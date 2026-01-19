<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Board_of_directors extends MX_Controller {
    

    

    function __construct() {
        parent::__construct();
        
    }
    
    /*****************************/
    /***** Board_of_directors Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/board_of_directors/index";
        $database = "board_of_directors";
        $perpage = 12;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage);	
        $data['board_of_directors'] = $this->getPagiData($limit, $start);  
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();  
        $this->load->view('header2', $data);
        $this->load->view('board_of_directors/board_of_directors', $data);
        $this->load->view('footer2', $data);
    }
    
    /*****************************/
    /***** Board_of_directors View  ********/
    /*****************************/
    public function view(){
        $data['basicinfo'] = $this->getBasicInfo();        
        $data['board_of_directors'] = $this->getIndividual();
        $this->load->view('header2', $data);
        $this->load->view('board_of_directors/view', $data);
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
    /***** Get Board_of_directors Info ********/
    /*****************************/
    public function getBoard_of_directorsInfo(){ 
        $query = $this->db->get('board_of_directors');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Board_of_directors Individual ********/
    /*****************************/
    public function getIndividual(){ 
        $board_of_directorsid = $this->uri->segment(4);
        $query = $this->db->get_where('board_of_directors', array('board_of_directorsid' => $board_of_directorsid));
        return $query->result();
    }
    
    /****************************************/
    /********* Get Pagination Board_of_directors *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->db->limit($limit, $start);
            $query = $this->db->get('board_of_directors');
            return $query->result();
    }
}
