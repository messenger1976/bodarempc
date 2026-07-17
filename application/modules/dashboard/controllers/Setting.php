<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MX_Controller {
    
    

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
    }

    public function index() {
        $this->load->view('Dashboard/header');
        $this->load->view('Dashboard/dashboard');
        $this->load->view('Dashboard/footer');
    }
    
    public function about() {
        $this->load->view('Dashboard/header');
        $this->load->view('Setting/about');
        $this->load->view('Dashboard/footer');
    }

    public function backup() {
        $this->coop_access->requireAnyRole(array('Super Admin', 'Admin'));

        $backupPath = $this->getBackupPath();
        $files = array();

        if (is_dir($backupPath)) {
            $scan = scandir($backupPath);
            foreach ($scan as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $absolute = $backupPath . DIRECTORY_SEPARATOR . $file;
                if (is_file($absolute)) {
                    $files[] = array(
                        'name' => $file,
                        'size' => filesize($absolute),
                        'modified' => date('Y-m-d H:i:s', filemtime($absolute)),
                    );
                }
            }
        }

        usort($files, function ($a, $b) {
            return strcmp($b['modified'], $a['modified']);
        });

        $data['backupFiles'] = $files;
        $this->load->view('Dashboard/header');
        $this->load->view('Setting/backup', $data);
        $this->load->view('Dashboard/footer');
    }

    public function createBackup() {
        $this->coop_access->requireAnyRole(array('Super Admin', 'Admin'));

        $backupPath = $this->getBackupPath();
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $this->load->dbutil();
        $backup = $this->dbutil->backup(array(
            'format' => 'zip',
            'filename' => 'database-' . date('Y-m-d-H-i-s') . '.sql'
        ));

        $fileName = 'backup-' . date('Y-m-d-H-i-s') . '.zip';
        $saved = (bool) file_put_contents($backupPath . DIRECTORY_SEPARATOR . $fileName, $backup);

        if ($saved) {
            $this->coop_audit->log('backup_created', array('file' => $fileName));
            $this->session->set_flashdata('success', 'Manual backup created successfully.');
        } else {
            $this->session->set_flashdata('error', 'Unable to create backup file.');
        }

        redirect('dashboard/setting/backup', 'refresh');
    }

    public function downloadBackup($fileName = '') {
        $this->coop_access->requireAnyRole(array('Super Admin', 'Admin'));

        $safeFile = basename($fileName);
        $backupPath = $this->getBackupPath();
        $absolutePath = $backupPath . DIRECTORY_SEPARATOR . $safeFile;

        if (!$safeFile || !is_file($absolutePath)) {
            show_404();
        }

        $this->load->helper('download');
        force_download($absolutePath, NULL);
    }

    public function deleteBackup($fileName = '') {
        $this->coop_access->requireAnyRole(array('Super Admin', 'Admin'));

        $safeFile = basename($fileName);
        $backupPath = $this->getBackupPath();
        $absolutePath = $backupPath . DIRECTORY_SEPARATOR . $safeFile;

        if (!$safeFile || !is_file($absolutePath)) {
            $this->session->set_flashdata('error', 'Backup file not found.');
            redirect('dashboard/setting/backup', 'refresh');
        }

        if (unlink($absolutePath)) {
            $this->coop_audit->log('backup_deleted', array('file' => $safeFile));
            $this->session->set_flashdata('success', 'Backup file deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Unable to delete backup file.');
        }

        redirect('dashboard/setting/backup', 'refresh');
    }

    public function restoreBackup($fileName = '') {
        $this->coop_access->requireAnyRole(array('Super Admin', 'Admin'));

        $safeFile = basename($fileName);
        $backupPath = $this->getBackupPath();
        $absolutePath = $backupPath . DIRECTORY_SEPARATOR . $safeFile;

        if (!$safeFile || !is_file($absolutePath)) {
            $this->session->set_flashdata('error', 'Backup file not found.');
            redirect('dashboard/setting/backup', 'refresh');
        }

        // Safety snapshot before restore.
        $snapshotFile = $this->createSnapshotBackup();

        $sqlContent = $this->extractSqlContent($absolutePath);
        if ($sqlContent === '') {
            $this->session->set_flashdata('error', 'Unable to read SQL data from backup file.');
            redirect('dashboard/setting/backup', 'refresh');
        }

        $analysis = $this->analyzeSqlBatch($sqlContent);
        if (!$analysis['ok']) {
            $this->coop_audit->log('backup_restore_blocked', array(
                'file' => $safeFile,
                'blocked_count' => count($analysis['blocked'])
            ));
            $this->session->set_flashdata('error', 'Restore blocked by dry-run validation. Blocked statements: ' . count($analysis['blocked']));
            redirect('dashboard/setting/backup', 'refresh');
        }

        $result = $this->runSqlBatch($sqlContent);

        if ($result['ok']) {
            $this->coop_audit->log('backup_restored', array(
                'file' => $safeFile,
                'snapshot' => $snapshotFile,
                'queries' => $result['queries']
            ));
            $this->session->set_flashdata('success', 'Backup restored successfully. Executed queries: ' . $result['queries']);
        } else {
            $this->coop_audit->log('backup_restore_failed', array(
                'file' => $safeFile,
                'snapshot' => $snapshotFile,
                'error' => $result['error']
            ));
            $this->session->set_flashdata('error', 'Restore failed: ' . $result['error']);
        }

        redirect('dashboard/setting/backup', 'refresh');
    }

    public function dryRunBackup($fileName = '') {
        $this->coop_access->requireAnyRole(array('Super Admin', 'Admin'));

        $safeFile = basename($fileName);
        $backupPath = $this->getBackupPath();
        $absolutePath = $backupPath . DIRECTORY_SEPARATOR . $safeFile;

        if (!$safeFile || !is_file($absolutePath)) {
            $this->session->set_flashdata('error', 'Backup file not found.');
            redirect('dashboard/setting/backup', 'refresh');
        }

        $sqlContent = $this->extractSqlContent($absolutePath);
        if ($sqlContent === '') {
            $this->session->set_flashdata('error', 'Unable to read SQL data from backup file.');
            redirect('dashboard/setting/backup', 'refresh');
        }

        $analysis = $this->analyzeSqlBatch($sqlContent);
        if ($analysis['ok']) {
            $this->coop_audit->log('backup_dry_run_passed', array('file' => $safeFile, 'queries' => $analysis['count']));
            $this->session->set_flashdata('success', 'Dry run passed. SQL statements ready: ' . $analysis['count']);
        } else {
            $this->coop_audit->log('backup_dry_run_failed', array('file' => $safeFile, 'blocked' => $analysis['blocked']));
            $this->session->set_flashdata('error', 'Dry run failed. Blocked statements: ' . implode(' | ', $analysis['blocked']));
        }

        redirect('dashboard/setting/backup', 'refresh');
    }

    public function profile() {
        $data['indiUser'] = $this->getProfile();
        $this->load->view('Dashboard/header');
        $this->load->view('Setting/profile', $data);
        $this->load->view('Dashboard/footer');
    }

    public function editprofile() {
        $data['indiUser'] = $this->getProfile();
        $this->load->view('Dashboard/header');
        $this->load->view('Setting/editprofile', $data);
        $this->load->view('Dashboard/footer');
    }

    public function updateProfile() {

        $errors = array();
        $success = array();
        $data = array();

        $userID = $this->input->post('userid');
        $email = $this->input->post('email');
        $checked = $this->isEmailUnique($email, $userID);
        if ($checked == TRUE) {
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean|min_length[4]|max_length[12]');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|min_length[6]|max_length[12]|matches[conpassword]');
            $this->form_validation->set_rules('conpassword', 'Confirm Password', 'trim|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $errors['errorFormValidation'] = validation_errors();
                echo json_encode($errors);
            } else {
                $data['fname'] = $this->input->post('fname');
                $data['lname'] = $this->input->post('lname');
                $data['userstatus'] = 'Active';
                $data['username'] = strtolower($data['fname'] . $data['lname']);
                $data['about'] = $this->input->post('about');
                $data['phone'] = $this->input->post('phone');
                $data['email'] = $this->input->post('email');
                $password = $this->input->post('password');
                if ($password) {
                    $data['password'] = md5($password);
                }
                $data['position'] = $this->coop_access->normalizeRole($this->input->post('position'));
                $data['bpdate'] = $this->input->post('bpdate');
                $data['blood'] = $this->input->post('blood');
                $data['dob'] = $this->input->post('dob');
                $data['nationality'] = $this->input->post('nationality');
                $data['address'] = $this->input->post('address');
                $data['city'] = $this->input->post('city');
                $data['country'] = $this->input->post('country');
                $data['postal'] = $this->input->post('postal');

                /* Uploading Profile Images */
                $imagePath = realpath(APPPATH . '../images/users');
                $profileimage = $_FILES['profileimage']['tmp_name'];
                //If Profile Image $profileimage Has Anything Then Continue
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

                    /* Resizing Uploaded Images */
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
                    unlink($uploaded_data['full_path']);
                }

                $this->db->where('userid', $userID);
                $updated = $this->db->update('users', $data);
                if ($updated == TRUE) {
                    $succcess['success'] = "Successfully Updated";
                    echo json_encode($succcess);
                } else {
                    $errors['notsuccess'] = 'Opps! Something Wrong';
                    echo json_encode($errors);
                }
            }
        } else {
            $errors['emailexist'] = $email . ' already exist';
            echo json_encode($errors);
        }
    }

    public function getProfile() {
        $userId = $this->session->userdata('user_id');
        $query = $this->db->get_where('users', array('userid' => $userId));
        return $query->result();
    }

    /**************************************************************/
    /***** Checking If User Update Email Is Unique/Duplicate ******/
    /**************************************************************/

    public function isEmailUnique($email, $userID) {

        $query = $this->db->get_where('users', array('email' => $email));
        if ($query->num_rows() > 0) { //If rows bigger than 0 Email Found
            foreach ($query->result() as $row) {
                $newuserid = $row->userid;
            }
            if ($newuserid == $userID) {
                return TRUE;
            } else {
                return FALSE; // True means unique email 
            }
        } else {
            return True; // True means unique email 
        }
    }

    public function switchLang($language = "") {
        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('lang', $language);
        //redirect('dashboard/dashboard', 'refresh');
        redirect($_SERVER['HTTP_REFERER']);
    }

    private function getBackupPath() {
        return realpath(APPPATH . '..') . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'backups';
    }

    private function createSnapshotBackup() {
        $backupPath = $this->getBackupPath();
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $this->load->dbutil();
        $backup = $this->dbutil->backup(array(
            'format' => 'zip',
            'filename' => 'pre-restore-' . date('Y-m-d-H-i-s') . '.sql'
        ));

        $fileName = 'pre-restore-' . date('Y-m-d-H-i-s') . '.zip';
        file_put_contents($backupPath . DIRECTORY_SEPARATOR . $fileName, $backup);

        return $fileName;
    }

    private function extractSqlContent($absolutePath) {
        $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));

        if ($extension === 'sql') {
            $content = file_get_contents($absolutePath);
            return $content ? $content : '';
        }

        if ($extension === 'zip' && class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($absolutePath) === TRUE) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $name = $zip->getNameIndex($i);
                    if (strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'sql') {
                        $content = $zip->getFromIndex($i);
                        $zip->close();
                        return $content ? $content : '';
                    }
                }
                $zip->close();
            }
        }

        return '';
    }

    private function runSqlBatch($sqlContent) {
        $queries = $this->parseSqlStatements($sqlContent);
        $count = 0;

        foreach ($queries as $query) {
            $query = trim($query);
            if ($query === '' || strpos($query, '--') === 0) {
                continue;
            }

            $ok = $this->db->query($query);
            if ($ok === false) {
                return array('ok' => false, 'queries' => $count, 'error' => 'An SQL statement failed.');
            }
            $count++;
        }

        return array('ok' => true, 'queries' => $count, 'error' => '');
    }

    private function analyzeSqlBatch($sqlContent) {
        $blockedPrefixes = array('GRANT', 'REVOKE', 'CREATE USER', 'DROP USER', 'ALTER USER', 'SHUTDOWN', 'FLUSH');
        $queries = $this->parseSqlStatements($sqlContent);
        $blocked = array();
        $count = 0;

        foreach ($queries as $query) {
            $clean = trim($query);
            if ($clean === '' || strpos($clean, '--') === 0) {
                continue;
            }

            $upper = strtoupper(preg_replace('/\s+/', ' ', $clean));
            foreach ($blockedPrefixes as $prefix) {
                if (strpos($upper, $prefix) === 0) {
                    $blocked[] = $prefix;
                }
            }
            $count++;
        }

        return array(
            'ok' => empty($blocked),
            'blocked' => array_values(array_unique($blocked)),
            'count' => $count,
        );
    }

    private function parseSqlStatements($sqlContent) {
        $sqlContent = str_replace("\r", "", $sqlContent);
        $chunks = explode(";\n", $sqlContent);
        $queries = array();

        foreach ($chunks as $chunk) {
            $query = trim($chunk);
            if ($query !== '') {
                $queries[] = $query;
            }
        }

        return $queries;
    }

}
