<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {
    

    

    function __construct() {
        parent::__construct();
        $this->load->library('envatoapi');
    }
    
    /*****************************/
    /***** Website Index  ********/
    /*****************************/
    public function index(){        
        $data['basicinfo'] = $this->getBasicInfo();
        //$data['basicinfo'] = getBasic();
        $data['event'] = $this->getEventInfo();
        $data['events'] = $this->getEventsInfo();
        $data['speech'] = $this->getSpeeches();
        $data['section'] = $this->getSection();
        $data['pastors'] = $this->getPastors();
        $data['committee'] = $this->getCommittee();
        $data['staff'] = $this->getStaff();
        $data['prayer'] = $this->getPrayerInfo();
        $data['notice'] = $this->getNoticeInfo();
        $data['gallery'] = $this->getGalleryInfo();
        $data['slider'] = $this->getSlider();
        $data['cooperative_officers'] = $this->getCooperativeOfficers();
        $data['pagination'] = '';
        $data['purchase'] = $this->evnatoVerify();
        $this->load->view('header2', $data);
        $this->load->view('index', $data);
        $this->load->view('footer2', $data);
    }
    
    /*****************************/
    /***** Products Page  ********/
    /*****************************/
    public function products(){        
        $data['basicinfo'] = $this->getBasicInfo();
        $data['purchase'] = $this->evnatoVerify();
        $this->load->view('header2', $data);
        $this->load->view('products/products', $data);
        $this->load->view('footer2', $data);
    }
    
    /*****************************/
    /***** About Us Page  ********/
    /*****************************/
    public function about(){        
        $data['basicinfo'] = $this->getBasicInfo();
        $data['purchase'] = $this->evnatoVerify();
        $this->load->view('header2', $data);
        $this->load->view('about/about', $data);
        $this->load->view('footer2', $data);
    }
    
    /*****************************/
    /***** Contact Us Page ********/
    /*****************************/
    public function contact(){        
        $data['basicinfo'] = $this->getBasicInfo();
        $data['purchase'] = $this->evnatoVerify();
        $this->load->view('header2', $data);
        $this->load->view('contact/contact', $data);
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
    public function getEventInfo(){        
        $this->db->order_by('eventid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('event');
        return $query->result();
    }
    
    /**********************************/
    /***** Get All Events Info ********/
    /**********************************/
    public function getEventsInfo(){        
        $this->db->order_by('eventid', 'desc');
        $query = $this->db->get('event');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Speech     ********/
    /*****************************/
    public function getSpeeches(){   
        $query =  $this->db->get('speech');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Section    ********/
    /*****************************/
    public function getSection(){   
        $this->db->where('status = 1');
        $this->db->order_by('serialid', 'asc');
        $query =  $this->db->get('section');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Pastor Info ********/
    /*****************************/
    public function getPastors(){ 
        $this->db->limit(4);
        $query = $this->db->get('pastor');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Committee Info ********/
    /*****************************/
    public function getCommittee(){ 
        $this->db->limit(4);
        $query = $this->db->get('committee');
        return $query->result();
    }

    /*****************************/
    /***** Get Staff Info ********/
    /*****************************/
    public function getStaff(){ 
        $this->db->limit(4);
        $query = $this->db->get('staff');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Payer Info ********/
    /*****************************/
    public function getPrayerInfo(){ 
        $query = $this->db->get('prayer');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Notice Info ********/
    /*****************************/
    public function getNoticeInfo(){ 
        $query = $this->db->get('notice');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Gallery Info ********/
    /*****************************/
    public function getGalleryInfo(){ 
        $this->db->limit(6);
        $query = $this->db->get('gallery');
        return $query->result();
    }
    
    /*****************************/
    /***** Get Gallery Info ********/
    /*****************************/
    public function getSlider(){ 
        $this->db->order_by('serialid', 'asc');
        $query = $this->db->get('slider');
        return $query->result();
    }
        /*****************************/
    /***** Get Cooperative Officers Info ********/
    /*****************************/
    public function getCooperativeOfficers(){ 
        $query = $this->db->get('cooperative_officers');
        $officers = $query->result();
        
        // Group officers by department
        $grouped = array();
        foreach($officers as $officer) {
            $dept = !empty($officer->department) ? $officer->department : 'Unassigned';
            if(!isset($grouped[$dept])) {
                $grouped[$dept] = array();
            }
            $grouped[$dept][] = $officer;
        }
        
        return $grouped;
    }
        
    /*****************************/
    /***** Get Gallery Info ********/
    /*****************************/
    public function contactWithUs(){ 
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $subject = $this->input->post('subject');
        $body = strip_tags($this->input->post('body'));
        
        $info = $this->getBasicInfo();
        $toEmail = $info[0]->email;
        
        $this->email->from($email, $name);
        $this->email->to($toEmail);
        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->send();
		redirect('dashboard', 'refresh');
    }
    
    
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