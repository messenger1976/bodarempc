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
