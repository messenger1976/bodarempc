<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MX_Controller {
    

    
    function __construct() {
        parent::__construct();

        $logged_in = $this->session->userdata('logged_in');		
        $user_position = $this->session->userdata('user_position');		
        if(!$logged_in){
                redirect('access/login', 'refresh');
        }elseif($user_position !== "Admin" ){
                redirect('dashboard/index', 'refresh');
        }

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
    }

    /*     * ************************** */
    /*     * *** Website Index Menu **** */
    /*     * ************************** */

    public function index() {
        $data['parentmenu'] = $this->parentmenus();
        $data['menus'] = $this->allmenus();
        $data['pages'] = $this->allpages();
        $this->load->view('Dashboard/header');
        $this->load->view('Menu/menu', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * *** Website Menu **** */
    /*     * ************************** */

    public function menu() {
        $data['parentmenu'] = $this->parentmenus();
        $data['menus'] = $this->allmenus();
        $data['pages'] = $this->allpages();
        $this->load->view('Dashboard/header');
        $this->load->view('Menu/menu', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******** Add Menu ******** */
    /*     * ************************** */

    public function add() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('menuname', 'Menu Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
            exit;
        } else {
            $data['menuname'] = $this->input->post('menuname');
            $data['menuparentid'] = $this->input->post('menuparent');
            $data['menupageid'] = $this->input->post('menupage');
            $data['menulink'] = $this->input->post('menulink');
            $data['cdate'] = date("j F Y");

            /*             * ****** Uploading Menu Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../images/website/menu');
            $menuimage = (isset($_FILES['menuimage']['tmp_name'])) ? $_FILES['menuimage']['tmp_name'] : '';
            if ($menuimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('menuimage')) {
                    $uploaded_data = $this->upload->data();
                    $data['menuimage'] = $uploaded_data['file_name'];
                } else {
                    $data['menuimage'] = '';
                    $errors['menuimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                    exit;
                }
            } else {
                $data['menuimage'] = '';
            }

            $inserted = $this->db->insert('menu', $data);
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
    /*     * *** Website Menu View **** */
    /*     * ************************** */

    public function edit() {
        $data['individual'] = $this->individual();
        $data['menus'] = $this->allmenus();
        $data['pages'] = $this->allpages();
        $this->load->view('Dashboard/header');
        $this->load->view('Menu/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************** */
    /*     * ******** Update Menu ******** */
    /*     * ************************** */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();

        $menuid = $this->input->post('menuid');

        $this->form_validation->set_rules('menuname', 'Menu Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
            exit;
        } else {

            $data['menuname'] = $this->input->post('menuname');
            $data['menuparentid'] = $this->input->post('menuparent');
            $data['menupageid'] = $this->input->post('menupage');
            $data['menulink'] = $this->input->post('menulink');
            $data['cdate'] = date("j F Y");

            /*             * ****** Uploading Menu Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../images/website/menu');
            $menuimage = (isset($_FILES['menuimage']['tmp_name'])) ? $_FILES['menuimage']['tmp_name'] : '';
            if ($menuimage !== "") {
                $config['upload_path'] = $imagePath;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('menuimage')) {
                    $uploaded_data = $this->upload->data();
                    
                    // Delete old image if exists
                    $old_menu = $this->db->get_where('menu', array('menuid' => $menuid))->result();
                    if (!empty($old_menu) && !empty($old_menu[0]->menuimage)) {
                        $old_image_path = $imagePath . '/' . $old_menu[0]->menuimage;
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                    
                    $data['menuimage'] = $uploaded_data['file_name'];
                } else {
                    $errors['menuimage_error'] = strip_tags($this->upload->display_errors());
                    echo json_encode($errors);
                    exit;
                }
            }

            $this->db->where('menuid', $menuid);
            $updated = $this->db->update('menu', $data);
            if ($updated == TRUE) {
                $success['success'] = "Successfully Updted";
                echo json_encode($success);
                exit;
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
                exit;
            }
        }
    }

    /*     * ************************************* */
    /*     * ****** Individual Delete Menu ******* */
    /*     * ************************************* */

    public function delete($menuid) {
        // Get menu details to check for image
        $this->db->where('menuid', $menuid);
        $menu = $this->db->get('menu')->row();
        
        // Delete image file if it exists
        if ($menu && !empty($menu->menuimage)) {
            $imagePath = realpath(APPPATH . '../images/website/menu');
            $filePath = $imagePath . '/' . $menu->menuimage;
            if (file_exists($filePath)) {
                unlink($filePath);
                log_message('info', 'Deleted menu image: ' . $menu->menuimage);
            }
        }
        
        // Delete menu record from database
        $this->db->where('menuid', $menuid);
        $deleted = $this->db->delete('menu');
        if ($deleted == TRUE) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/menu/', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/menu/', 'refresh');
        }
    }

    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function parentmenus() {
        $this->db->where('menuparentid', " ");        
        $this->db->order_by('serialid', "asc");
        $query = $this->db->get('menu');
        return $query->result();
    }
    
    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function unassignmenus() {
        $this->db->where('menuparentid', " ");        
        $this->db->order_by('serialid', "asc");
        $query = $this->db->get('menu');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function individual() {
        $menuid = $this->uri->segment(4);
        $this->db->where('menuid', $menuid);
        $query = $this->db->get('menu');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function allmenus() {
        //$this->db->order_by('serialid');
        $query = $this->db->get('menu');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Website Menu ********* */
    /*     * ************************** */

    public function allpages() {
        $query = $this->db->get('page');
        return $query->result();
    }

    /*     * ************************** */
    /*     * *** Sort Section      **** */
    /*     * ************************** */

    public function sortmenu() {
        $sorted = $this->input->post('sort');
        
        $data = json_decode($sorted, TRUE);
        $counted = count($data[0]);
        for ($x = 0; $x < $counted; $x++) {
            $menuid = $data[0][$x]["id"];
            if (strlen($menuid) > 2) {
                $submenuarr = explode(",", $menuid);
                $submenuid = $submenuarr[0];
                $parentmenuid = $submenuarr[1];
                $submenuserial = $submenuarr[2];

                $query = $this->db->get_where('menu', array('menuid' => $parentmenuid));
                $parentmenuserialid = $query->result()[0]->serialid;

                $arrdata = array();
                $arrdata['serialid'] = $parentmenuid;
                $arrdata['subserialid'] = $x;
                $this->db->where('menuid', $submenuid);
                $this->db->update('menu', $arrdata);
            } else {
                $arrdata = array();
                $arrdata['serialid'] = $x;
                $this->db->where('menuid', $menuid);
                $this->db->update('menu', $arrdata);
            }
        }
    }

}
