<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MX_Controller {
    

    

    function __construct() {
        parent::__construct();
        
    }
    
    /*****************************/
    /***** Event Index  ********/
    /*****************************/
    public function index(){
        $baselink = "home/event/index";
        $database = "event";
        $perpage = 6;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = iniPagination($baselink, $database, $perpage, $this->getPublishedCount());	
        $data['event'] = $this->getPagiData($limit, $start);  
        $data['pagination'] = $this->pagination->create_links();
        $data['basicinfo'] = $this->getBasicInfo();   
        $this->load->view('header2', $data);
        $this->load->view('event/event', $data);
        $this->load->view('footer2', $data);
    }
    
    /*****************************/
    /***** Event View  ********/
    /*****************************/
    public function view(){        
        $data['basicinfo'] = $this->getBasicInfo();        
        $data['event'] = $this->getIndividual();

        if (empty($data['event'])) {
            show_404();
            return;
        }

        $this->load->view('header2', $data);
        $this->load->view('event/view', $data);
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
    /***** Get Event Info ********/
    /*****************************/
    public function getEvent(){ 
        $this->applyPublicationFilter();
        $this->db->order_by('eventid', 'desc');
        $query = $this->db->get('event');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Event Individual ********/
    /*****************************/
    public function getIndividual(){ 
        $eventid = $this->uri->segment(4);
        $this->db->where('eventid', $eventid);
        $this->applyPublicationFilter();
        $query = $this->db->get('event');
        return $query->result();
    }
    
    /****************************************/
    /********* Get Pagination Event *************/
    /****************************************/
    public function getPagiData($limit, $start){
            $this->applyPublicationFilter();
            $this->db->order_by('eventid', 'desc');
            $this->db->limit($limit, $start);
            $query = $this->db->get('event');
            return $query->result();
    }

    /**
     * Count events that are visible on the public website.
     */
    public function getPublishedCount(){
        $this->applyPublicationFilter();
        return $this->db->count_all_results('event');
    }

    /**
     * Apply the shared status and publication-window rules.
     */
    protected function applyPublicationFilter(){
        $now = date('Y-m-d H:i:s');

        $this->db->where('status', 'published');
        $this->db->where('publish_start_at <=', $now);
        $this->db->group_start();
        $this->db->where('publish_end_at IS NULL', NULL, FALSE);
        $this->db->or_where('publish_end_at >', $now);
        $this->db->group_end();
    }
        
}