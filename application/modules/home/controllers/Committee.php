<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Committee extends MX_Controller {
    

    

    function __construct() {
        parent::__construct();
        
    }
    
    /*****************************/
    /***** Committee Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/committee/index";
        $database = "committee";
        $perpage = 12;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);	
        $data['committee'] = $this->getPagiData($limit, $start);  
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo(); 
        $this->load->view('header');
        $this->load->view('committee/committee', $data);
        $this->load->view('footer', $data);
    }
    
    /*****************************/
    /***** Committee View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();        
        $data['committee'] = $this->getIndividual();
        $this->load->view('header');
        $this->load->view('committee/view', $data);
        $this->load->view('footer', $data);
    }
    
    /*****************************/
    /***** Get Basic Info ********/
    /*****************************/
    public function getBasicInfo(){
        $query = $this->db->get('websitebasic');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Pastor Info ********/
    /*****************************/
    public function getCommittee(){ 
        $this->db->order_by('committeeid', "asc");
        $query = $this->db->get('committee');
        
        return $query->result();
    }
    
    /*****************************/
    /***** Get Commitee Individual ********/
    /*****************************/
    public function getIndividual(){ 
        $committeeid = $this->uri->segment(4);
        $query = $this->db->get_where('committee', array('committeeid' => $committeeid));
        return $query->result();
    }
    
    /****************************************/
    /********* Get Pagination Committee *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('committee');
            return $query->result();
    }
}