<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rolesetup extends MX_Controller {

    function __construct() {
        parent::__construct();

        $logged_in = $this->session->userdata('logged_in');
        if (!$logged_in) {
            redirect('access/login', 'refresh');
        }

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
        $this->load->library('coop_access');
        $this->load->library('coop_audit');
        $this->coop_access->requireAnyRole(array('Super Admin', 'Admin'));
    }

    public function index() {
        $roles = $this->coop_access->getAvailableRoles();

        $filters = array(
            'q' => trim((string) $this->input->get('q')),
            'email' => trim((string) $this->input->get('email')),
            'role' => trim((string) $this->input->get('role')),
        );
        if ($filters['role'] !== '' && !in_array($filters['role'], $roles, true)) {
            $filters['role'] = '';
        }

        $perpage = 20;
        $start = ($this->uri->segment(4)) ? (int) $this->uri->segment(4) : 0;

        $total_rows = $this->applyUserFilters($filters)->count_all_results('users');

        $this->setup_rolesetup_pagination($total_rows, $perpage, $filters);
        $limit_start = ($start > $total_rows) ? 0 : $start;

        $data['users'] = $this->applyUserFilters($filters)
            ->order_by('userid', 'DESC')
            ->limit($perpage, $limit_start)
            ->get('users')
            ->result();
        $data['pagination'] = $this->pagination->create_links();
        $data['filters'] = $filters;
        $data['totalUsers'] = $total_rows;
        $data['showingFrom'] = $total_rows ? ($limit_start + 1) : 0;
        $data['showingTo'] = min($limit_start + $perpage, $total_rows);
        $data['roleChanges'] = $this->coop_audit->getLatestRoleChangesByUser();
        $data['roles'] = $roles;
        $data['roleStats'] = $this->db->select('position, COUNT(*) AS total')
            ->from('users')
            ->group_by('position')
            ->get()
            ->result();
        $data['capabilityMatrix'] = array(
            array('module' => 'Analytics Reports', 'Super Admin' => 'Yes', 'Admin' => 'Yes', 'Manager' => 'Yes', 'Staff' => 'Yes', 'Viewer' => 'Yes'),
            array('module' => 'Users and Roles Setup', 'Super Admin' => 'Yes', 'Admin' => 'Yes', 'Manager' => 'No', 'Staff' => 'No', 'Viewer' => 'No'),
            array('module' => 'Backup Settings', 'Super Admin' => 'Yes', 'Admin' => 'Yes', 'Manager' => 'No', 'Staff' => 'No', 'Viewer' => 'No'),
            array('module' => 'Financial Records', 'Super Admin' => 'Yes', 'Admin' => 'Yes', 'Manager' => 'Yes', 'Staff' => 'No', 'Viewer' => 'No'),
            array('module' => 'Members', 'Super Admin' => 'Yes', 'Admin' => 'Yes', 'Manager' => 'Yes', 'Staff' => 'Yes', 'Viewer' => 'No'),
            array('module' => 'Events / Notices / Prayers', 'Super Admin' => 'Yes', 'Admin' => 'Yes', 'Manager' => 'Yes', 'Staff' => 'Yes', 'Viewer' => 'No'),
            array('module' => 'Website / Page / Menu Management', 'Super Admin' => 'Yes', 'Admin' => 'Yes', 'Manager' => 'No', 'Staff' => 'No', 'Viewer' => 'No'),
        );

        $this->load->view('Dashboard/header');
        $this->load->view('Roles/setup', $data);
        $this->load->view('Dashboard/footer');
    }

    public function update() {
        $userId = (int) $this->input->post('userid');
        $role = $this->coop_access->normalizeRole($this->input->post('position'));
        $redirect = 'dashboard/rolesetup' . $this->buildFilterQuery($this->input->post('return_filters'));

        if (!$userId || !in_array($role, $this->coop_access->getAvailableRoles(), true)) {
            $this->session->set_flashdata('error', 'Invalid user or role selection.');
            redirect($redirect, 'refresh');
        }

        $existing = $this->db->select('position')->where('userid', $userId)->get('users')->row();
        $oldRole = $existing ? $existing->position : '';

        $updated = $this->db->where('userid', $userId)->update('users', array('position' => $role));

        if ($updated) {
            $this->coop_audit->log('role_updated', array(
                'target_user_id' => $userId,
                'old_role' => $oldRole,
                'new_role' => $role,
                'changed_by_name' => $this->currentActorName(),
            ));
            $this->session->set_flashdata('success', 'Role updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Unable to update role right now.');
        }

        redirect($redirect, 'refresh');
    }

    protected function applyUserFilters($filters) {
        if (!empty($filters['q'])) {
            $this->db->group_start()
                ->like('fname', $filters['q'])
                ->or_like('lname', $filters['q'])
                ->group_end();
        }
        if (!empty($filters['email'])) {
            $this->db->like('email', $filters['email']);
        }
        if (!empty($filters['role'])) {
            $this->db->where('position', $filters['role']);
        }

        return $this->db;
    }

    protected function setup_rolesetup_pagination($total_rows, $perpage, $filters) {
        $config['base_url'] = base_url() . 'dashboard/rolesetup/index';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $perpage;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
    }

    protected function currentActorName() {
        $actorId = (int) $this->session->userdata('user_id');
        if ($actorId) {
            $actor = $this->db->select('fname, lname')->where('userid', $actorId)->get('users')->row();
            if ($actor) {
                $name = trim($actor->fname . ' ' . $actor->lname);
                if ($name !== '') {
                    return $name;
                }
            }
        }

        $email = $this->session->userdata('user_email');
        return $email ? $email : (string) $this->session->userdata('user_position');
    }

    protected function buildFilterQuery($rawFilters) {
        if (!is_array($rawFilters)) {
            return '';
        }

        $allowed = array('q', 'email', 'role');
        $params = array();
        foreach ($allowed as $key) {
            if (isset($rawFilters[$key]) && $rawFilters[$key] !== '') {
                $params[$key] = $rawFilters[$key];
            }
        }

        return $params ? '?' . http_build_query($params) : '';
    }
}
