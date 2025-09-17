<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chorus extends MX_Controller {
   

    function __construct() {
        parent::__construct();

        $logged_in = $this->session->userdata('logged_in');
        $user_position = $this->session->userdata('user_position');
        if (!$logged_in) {
            redirect('access/login', 'refresh');
        } elseif ($user_position !== "Admin") {
            redirect('dashboard/index', 'refresh');
        }

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
    }

    /*     * ************************************* */
    /*     * ******* Index Of Chorus ************ */
    /*     * ************************************* */

    public function index() {
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('Chorus/addchorus', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Add Chorus Member ****************** */
    /*     * ************************************* */

    public function addchorus() {
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('Chorus/addchorus', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Adding Chorus Member ****************** */
    /*     * ************************************* */

    public function addnewchorus() {

        $errors = array();
        $success = array();
        $data = array();

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['gender'] = $this->input->post('gender');
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

            /*             * ****** Uploading Profile Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../images/chorus');
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

                /*                 * ****** Resizing Profile Images ****** */
                /*                 * ************************************** */
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

            $inserted = $this->db->insert('chorus', $data);
            if ($inserted == TRUE) {
                $succcess['success'] = "Successfully Inserted";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ******* All Chorus Members ************ */
    /*     * ************************************* */

    public function allchorus() {

        $table = "chorus";
        $data['chorus'] = $this->getTotal($table);
        $this->load->view('Dashboard/header');
        $this->load->view('Chorus/allchorus', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* View Chorus Member ************ */
    /*     * ************************************* */

    public function view() {
        $data['individual'] = $this->getIndividual();
        $data['events'] = $this->getEvents();
        $this->load->view('Dashboard/header');
        $this->load->view('Chorus/view', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Edit Chorus Member ************ */
    /*     * ************************************* */

    public function edit() {
        $data['individual'] = $this->getIndividual();
        $data['family'] = $this->getFamily();
        $data['department'] = $this->getDepartment();
        $this->load->view('Dashboard/header');
        $this->load->view('Chorus/edit', $data);
        $this->load->view('Dashboard/footer');
    }

    /*     * ************************************* */
    /*     * ******* Update Chorus Member ************ */
    /*     * ************************************* */

    public function update() {

        $errors = array();
        $success = array();
        $data = array();
        $chorusid = $this->input->post('chorusid');

        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $errors['errorFormValidation'] = validation_errors();
            echo json_encode($errors);
        } else {

            $data['fname'] = $this->input->post('fname');
            $data['lname'] = $this->input->post('lname');
            $data['gender'] = $this->input->post('gender');
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

            /*             * ****** Uploading Profile Images ****** */
            /*             * ************************************** */
            $imagePath = realpath(APPPATH . '../images/chorus');
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

                /*                 * ****** Resizing Profile Images ****** */
                /*                 * ************************************** */
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

            $this->db->where('chorusid', $chorusid);
            $updated = $this->db->update('chorus', $data);
            if ($updated == TRUE) {
                $succcess['success'] = "Successfully Updated";
                echo json_encode($succcess);
            } else {
                $errors['notsuccess'] = 'Opps! Something Wrong';
                echo json_encode($errors);
            }
        }
    }

    /*     * ************************************* */
    /*     * ******* Delete Chorus Member ************ */
    /*     * ************************************* */

    public function delete($chorusid) {
        $this->db->where('chorusid', $chorusid);
        $deleted = $this->db->delete('chorus');
        if ($deleted == TRUE) {
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('dashboard/chorus/allchorus', 'refresh');
        } else {
            $this->session->set_flashdata('notsuccess', 'Opps! Something Went Wrong');
            redirect('dashboard/chorus/allchorus', 'refresh');
        }
    }

    /*     * ************************************* */
    /*     * ******* Get Individual Chorus Member ************ */
    /*     * ************************************* */

    public function getIndividual() {
        $chorusid = $this->uri->segment(4);
        $query = $this->db->get_where('chorus', array('chorusid' => $chorusid));
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ********** Get Total ********** */
    /*     * ************************************* */

    public function getTotal($table) {
        $query = $this->db->get($table);
        return $query->result();
    }

    /*     * ************************************* */
    /*     * ******* Get Pagination Chorus Member ************ */
    /*     * ************************************* */

    public function getPagiData($limit, $start) {
        $this->db->order_by("chorusid", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('chorus');
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
