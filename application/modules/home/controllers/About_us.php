<?php defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends MX_Controller {
    

    

    function __construct() {
        parent::__construct();
        $this->load->library('envatoapi');
    }
    
    /*****************************/
    /***** About_us Index  ********/
    /*****************************/
    public function index(){        
        $data['basicinfo'] = $this->getBasicInfo();  
        $data['gallery'] = $this->getGallery(); 
        $data['purchase'] = $this->evnatoVerify();
        $this->load->view('header2', $data);
        $this->load->view('about_us/about_us', $data);
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
    /***** Get Gallery Info ********/
    /*****************************/
    public function getGallery(){ 
        $query = $this->db->get('gallery');
        return $query->result();
    }
    
    
    /*****************************/
    /***** Envato Verify ********/
    /*****************************/
    public function evnatoVerify(){
        $purchaseCode = $this->getBasicInfo()[0]->verify;
        $o = $this->envatoapi->verifyPurchase($purchaseCode);
        if ( is_object($o) ) {
            return true;
        }else {
            return false;
        }
    }
    
    
}
