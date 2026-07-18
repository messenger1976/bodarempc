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

        if (empty($data['board_of_directors'])) {
            show_404();
            return;
        }

        $director = $data['board_of_directors'][0];
        $basic = !empty($data['basicinfo'][0]) ? $data['basicinfo'][0] : getBasic();
        $site_name = !empty($basic->title) ? $basic->title : 'BODARE & Community MPC';
        $full_name = trim($director->fname . ' ' . $director->lname);
        $position = !empty($director->position) ? $director->position : 'Board Member';
        $description = !empty($director->speech)
            ? seo_plain_text($director->speech, 160)
            : ($full_name . ' serves on the Board of Directors of ' . $site_name . ' as ' . $position . '.');
        $data['seo'] = array(
            'title' => $full_name . ' — ' . $position . ' | ' . $site_name,
            'description' => $description,
            'keywords' => $full_name . ', ' . $position . ', board of directors, BODARE',
            'canonical' => current_url(),
            'image' => !empty($director->profileimage)
                ? base_url('images/board_of_directors/profile/' . $director->profileimage)
                : '',
            'type' => 'profile',
            'json_ld' => array(
                seo_organization_schema($basic),
                seo_breadcrumb_schema(array(
                    'Home' => '',
                    'Board of Directors' => 'home/board_of_directors',
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
