<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Board_of_directors extends MX_Controller {
   

    function __construct() {
        parent::__construct();

        $logged_in = $this->session->userdata('logged_in');
        $user_position = $this->session->userdata('user_position');
        if (!$logged_in) {
            redirect('access/login', 'refresh');
        } elseif (!in_array($user_position, array('Admin', 'Super Admin', 'Manager'))) {
            redirect('dashboard/index', 'refresh');
        }

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
        $this->load->library('coop_access');
        $this->coop_access->requireAnyRole(array('Super Admin', 'Admin', 'Manager'));
    }

    /*     * ************************** */
    /*     * *** Index Page Of Board_of_directors **** */
    /*     * ************************** */

    public function index() {
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('Board_of_directors/addboard_of_directors', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Add Board_of_directors ******* */
    /*     * ************************** */

    public function addboard_of_directors() {
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('Board_of_directors/addboard_of_directors', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* Adding New Board_of_directors ******* */
    /*     * ************************** */

    public function addnewboard_of_directors() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['position'] = $this->input->post('position');
            $data['bpdate'] = $this->input->post('bpdate');
            $data['blood'] = $this->input->post('blood');
            $data['dob'] = $this->input->post('dob');
            $data['marriagedate'] = $this->input->post('marriagedate');
            $data['socialstatus'] = $this->input->post('socialstatus');
            $data['job'] = $this->input->post('job');
            $data['family'] = $this->input->post('family');
            $data['department'] = $this->input->post('department');            
            $data['nationality'] = $this->input->post('nationality');
            $data['speech'] = $this->input->post('speech');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['country'] = $this->input->post('country');
            $data['postal'] = $this->input->post('postal');
            $data['facebook'] = $this->input->post('facebook');
            $data['twitter'] = $this->input->post('twitter');
            $data['youtube'] = $this->input->post('youtube');
            $data['googleplus'] = $this->input->post('googleplus');
            $data['linkedin'] = $this->input->post('linkedin');
            $data['pinterest'] = $this->input->post('pinterest');
            $data['whatsapp'] = $this->input->post('whatsapp');
            $data['instagram'] = $this->input->post('instagram');
            $data['cdate'] = date("j F Y");

            /*             * ** Uploading Profile Image *** */
            /*             * ****************************** */
            $imagePath = realpath(APPPATH . '../images/board_of_directors');
            $profileimage = $_FILES['profileimage']['tmp_name'];
            if ($profileimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['profileimage'] = $uploaded_data['file_name'];
                } else {
                    $data['profileimage'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }

                $config['image_library'] = 'gd2';
                $config['source_image'] = $uploaded_data['full_path'];
                $config['new_image'] = $imagePath . '/crop';
                $config['quality'] = '100%';
                $config['maintain_ratio'] = FALSE;
                $config['width'] = round($this->input->post('width'));
                $config['height'] = round($this->input->post('height'));
                $config['x_axis'] = $this->input->post('x');
                $config['y_axis'] = $this->input->post('y');

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->crop();

                //**** Resizing Upload Image ****/
                /*                 * ****************************** */
                $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                $config['new_image'] = $imagePath . '/profile';
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                /* Deleting Uploaded Image After Croping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($imagePath . '/crop/' . $uploaded_data['file_name']);
                unlink($uploaded_data['full_path']);
            }

            $inserted = $this->db->insert('board_of_directors', $data);
            if ($inserted == TRUE) {
                $success['success'] = "Successfully Inserted";
                echo json_encode($success);
                exit;
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
                exit;
            }
        }
    }

    /*     * ************************** */
    /*     * ******* All Board_of_directors ******* */
    /*     * ************************** */

    public function allBoard_of_directors() {

        $baselink = "board_of_directors/allBoard_of_directors";
        $database = "board_of_directors";
        $perpage = 9;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);
        $data['board_of_directors'] = $this->get_pagi_data($limit, $start);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('Dashboard/header');
        $this->load->view('Board_of_directors/allboard_of_directors', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******* View Individual Board_of_directors ******* */
    /*     * ************************** */

    public function view() {
        $data['individual'] = $this->getIndividual();
        $data['events'] = $this->getEvents();
        $this->load->view('Dashboard/header');
        $this->load->view('Board_of_directors/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Edit Board_of_directors Profile **** */
    /*     * ************************** */

    public function edit() {
        $data['individual'] = $this->getIndividual();
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('Board_of_directors/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Update Board_of_directors Profile **** */
    /*     * ************************** */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {
            $board_of_directorsid = $this->input->post('board_of_directorsid');
            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['position'] = $this->input->post('position');
            $data['bpdate'] = $this->input->post('bpdate');
            $data['blood'] = $this->input->post('blood');
            $data['dob'] = $this->input->post('dob');
            $data['marriagedate'] = $this->input->post('marriagedate');
            $data['socialstatus'] = $this->input->post('socialstatus');
            $data['job'] = $this->input->post('job');
            $data['family'] = $this->input->post('family');
            $data['department'] = $this->input->post('department');            
            $data['nationality'] = $this->input->post('nationality');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['country'] = $this->input->post('country');
            $data['postal'] = $this->input->post('postal');
            $data['facebook'] = $this->input->post('facebook');
            $data['twitter'] = $this->input->post('twitter');
            $data['youtube'] = $this->input->post('youtube');
            $data['googleplus'] = $this->input->post('googleplus');
            $data['linkedin'] = $this->input->post('linkedin');
            $data['pinterest'] = $this->input->post('pinterest');
            $data['whatsapp'] = $this->input->post('whatsapp');
            $data['instagram'] = $this->input->post('instagram');
            $data['cdate'] = date("j F Y");

            /*             * ** Uploading Profile Image *** */
            /*             * ****************************** */
            $imagePath = realpath(APPPATH . '../images/board_of_directors');
            $profileimage = $_FILES['profileimage']['tmp_name'];
            if ($profileimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('profileimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['profileimage'] = $uploaded_data['file_name'];
                } else {
                    $data['profileimage'] = '';
                    $errors['profileimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                }

                $config['image_library'] = 'gd2';
                $config['source_image'] = $uploaded_data['full_path'];
                $config['new_image'] = $imagePath . '/crop';
                $config['quality'] = '100%';
                $config['maintain_ratio'] = FALSE;
                $config['width'] = round($this->input->post('width'));
                $config['height'] = round($this->input->post('height'));
                $config['x_axis'] = $this->input->post('x');
                $config['y_axis'] = $this->input->post('y');

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->crop();

                //**** Resizing Upload Image ****/
                /*                 * ****************************** */
                $config['source_image'] = $imagePath . '/crop/' . $uploaded_data['file_name'];
                $config['new_image'] = $imagePath . '/profile';
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                /* Deleting Uploaded Image After Croping and Resizing */
                /* Why Deleting because it's saving space */
                unlink($imagePath . '/crop/' . $uploaded_data['file_name']);
                unlink($uploaded_data['full_path']);
            }

            $this->db->where('board_of_directorsid', $board_of_directorsid);
            $updated = $this->db->update('board_of_directors', $data);
            if ($updated == TRUE) {
                $success['success'] = "Successfully Updated";
                echo json_encode($success);
                exit;
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
                exit;
            }
        }
    }

    /*     * ************************** */
    /*     * *** Delete Board_of_directors Profile **** */
    /*     * ************************** */

    public function delete($board_of_directorsid) {
        $this->db->where('board_of_directorsid', $board_of_directorsid);
        $this->db->delete('board_of_directors');
        redirect('dashboard/board_of_directors/allBoard_of_directors', 'refresh');
    }

    /*     * ************************** */
    /*     * *** Getting Board_of_directors By Pagination **** */
    /*     * ************************** */

    public function get_pagi_data($limit, $start) {
        $this->db->order_by("board_of_directorsid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('board_of_directors');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Get Individual Board_of_directors Profile **** */
    /*     * ************************** */

    public function getIndividual() {
        $Board_of_directorsid = $this->uri->segment(4);
        $query = $this->db->get_where('board_of_directors', array('board_of_directorsid' => $Board_of_directorsid));
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Events ************ */
    /*     * ************************************* */

    public function getEvents() {

        $group = $this->uri->segment(2);
        $userID = $this->uri->segment(4);
        $queryEvents = $this->db->get_where('attendance', array('userid' => $userID, 'grouptype' => $group, 'status' => 'present'));
        return $queryEvents->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Events ************ */
    /*     * ************************************* */

    public function getFamily() {
        $queryFamily = $this->db->get('family');
        return $queryFamily->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Events ************ */
    /*     * ************************************* */

    public function getDepartment() {
        $queryDepartment = $this->db->get('department');
        return $queryDepartment->result();
    }

}
