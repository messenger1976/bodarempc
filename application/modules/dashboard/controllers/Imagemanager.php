<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Image Manager for the admin HTML editor (Trumbowyg).
 * Stores uploads in images/editor and serves the library listing as JSON.
 */
class Imagemanager extends MX_Controller {

    function __construct() {
        parent::__construct();

        $logged_in = $this->session->userdata('logged_in');
        $user_position = $this->session->userdata('user_position');
        if (!$logged_in) {
            redirect('access/login', 'refresh');
        } elseif (!in_array($user_position, array('Admin', 'Super Admin', 'Manager', 'Staff'))) {
            redirect('dashboard/index', 'refresh');
        }

        $language = $this->session->userdata('lang');
        $this->lang->load('dashboard', $language);
        $this->load->library('coop_access');
        $this->coop_access->requireAnyRole(array('Super Admin', 'Admin', 'Manager', 'Staff'));
    }

    /*     * ************************************* */
    /*     * ******* Upload Editor Image ******** */
    /*     * ************************************* */

    public function upload() {
        $editorPath = $this->getEditorPath();
        if ($editorPath === FALSE) {
            $this->respond(array('success' => FALSE, 'error' => 'The image folder could not be created on the server.'));
            return;
        }

        if (empty($_FILES['imagefile']['name'])) {
            $this->respond(array('success' => FALSE, 'error' => 'Please choose an image file to upload.'));
            return;
        }

        $config['upload_path'] = $editorPath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 5120;
        $config['file_name'] = date('Ymd_His_') . mt_rand(1000, 9999);
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('imagefile')) {
            $this->respond(array('success' => FALSE, 'error' => strip_tags($this->upload->display_errors())));
            return;
        }

        $uploaded = $this->upload->data();
        $this->respond(array(
            'success' => TRUE,
            'name' => $uploaded['file_name'],
            'url' => base_url() . 'images/editor/' . $uploaded['file_name']
        ));
    }

    /*     * ************************************* */
    /*     * ****** Browse Uploaded Images ****** */
    /*     * ************************************* */

    public function browse() {
        $editorPath = $this->getEditorPath();
        $files = array();

        if ($editorPath !== FALSE) {
            foreach (scandir($editorPath) as $file) {
                if (!preg_match('/\.(jpe?g|png|gif|webp)$/i', $file)) {
                    continue;
                }
                $fullPath = $editorPath . DIRECTORY_SEPARATOR . $file;
                $files[] = array(
                    'name' => $file,
                    'url' => base_url() . 'images/editor/' . $file,
                    'path' => 'images/editor/' . $file,
                    'size' => filesize($fullPath),
                    'modified' => filemtime($fullPath)
                );
            }

            usort($files, function ($a, $b) {
                return $b['modified'] - $a['modified'];
            });
        }

        $this->respond(array('success' => TRUE, 'files' => $files));
    }

    /*     * ************************************* */
    /*     * ***** Editor Image Directory ******* */
    /*     * ************************************* */

    protected function getEditorPath() {
        $imagesPath = realpath(APPPATH . '../images');
        if ($imagesPath === FALSE) {
            return FALSE;
        }

        $editorPath = $imagesPath . DIRECTORY_SEPARATOR . 'editor';
        if (!is_dir($editorPath) && !mkdir($editorPath, 0755, TRUE)) {
            return FALSE;
        }

        return $editorPath;
    }

    protected function respond($payload) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }

}
