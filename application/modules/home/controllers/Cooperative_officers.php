<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cooperative_officers extends MX_Controller {
    

    

    function __construct() {
        parent::__construct();
        
    }
    
    /*****************************/
    /***** Cooperative_officers Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/cooperative_officers/index";
        $database = "cooperative_officers";
        $cooperative_officers = $this->getAllCooperative_officers();
        
        // Group officers by department
        $grouped = array();
        foreach($cooperative_officers as $officer) {
            $dept = !empty($officer->department) ? $officer->department : 'Unassigned';
            if(!isset($grouped[$dept])) {
                $grouped[$dept] = array();
            }
            $grouped[$dept][] = $officer;
        }
        
        $data['cooperative_officers'] = $grouped;  
        $data['basicinfo'] = $this->getBasicInfo();  
        $this->load->view('header2', $data);
        $this->load->view('cooperative_officers/cooperative_officers', $data);
        $this->load->view('footer2', $data);
    }
    
    /*****************************/
    /***** Cooperative_officers View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();        
        $data['cooperative_officers'] = $this->getIndividual();

        if (empty($data['cooperative_officers'])) {
            show_404();
            return;
        }

        $officer = $data['cooperative_officers'][0];
        $basic = !empty($data['basicinfo'][0]) ? $data['basicinfo'][0] : getBasic();
        $site_name = !empty($basic->title) ? $basic->title : 'BODARE & Community MPC';
        $full_name = trim($officer->fname . ' ' . $officer->lname);
        $position = !empty($officer->position) ? $officer->position : 'Cooperative Officer';
        $description = !empty($officer->speech)
            ? seo_plain_text($officer->speech, 160)
            : ($full_name . ' serves as ' . $position . ' at ' . $site_name . '.');
        $data['seo'] = array(
            'title' => $full_name . ' — ' . $position . ' | ' . $site_name,
            'description' => $description,
            'keywords' => $full_name . ', ' . $position . ', cooperative officers, BODARE',
            'canonical' => current_url(),
            'image' => !empty($officer->profileimage)
                ? base_url('images/cooperative_officers/profile/' . $officer->profileimage)
                : '',
            'type' => 'profile',
            'json_ld' => array(
                seo_organization_schema($basic),
                seo_breadcrumb_schema(array(
                    'Home' => '',
                    'Cooperative Officers' => 'home/cooperative_officers',
                    $full_name => current_url(),
                )),
                array(
                    '@context' => 'https://schema.org',
                    '@type' => 'Person',
                    'name' => $full_name,
                    'jobTitle' => $position,
                    'worksFor' => array(
                        '@type' => 'Organization',
                        'name' => $site_name,
                        'url' => base_url(),
                    ),
                    'url' => current_url(),
                ),
            ),
        );

        $this->load->view('header2', $data);
        $this->load->view('cooperative_officers/view', $data);
        $this->load->view('footer2', $data);
    }
    
    /*****************************/
    /***** Get Basic Info ********/
    /*****************************/
    public function getBasicInfo(){
        $query = $this->db->get('websitebasic');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Cooperative_officers Info ********/
    /*****************************/
    public function getCooperative_officersInfo(){ 
        $query = $this->db->get('cooperative_officers');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Cooperative_officers Individual ********/
    /*****************************/
    public function getIndividual(){ 
        $cooperative_officersid = $this->uri->segment(4);
        $query = $this->db->get_where('cooperative_officers', array('cooperative_officersid' => $cooperative_officersid));
        return $query->result();
    }
    
    /****************************************/
    /********* Get All Cooperative_officers *************/
    /****************************************/
    public function getAllCooperative_officers(){
            $query = $this->db->get('cooperative_officers');
            return $query->result();
    }
    
    /****************************************/
    /********* Get Pagination Cooperative_officers *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('cooperative_officers');
            return $query->result();
    }
}
