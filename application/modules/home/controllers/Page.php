<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MX_Controller {
    

    

    function __construct() {
        parent::__construct();
        
    }
    
    /*****************************/
    /***** Page Index  ********/
    /*****************************/
    public function index(){        
        $data['basicinfo'] = $this->getBasicInfo();   
        $data['page'] = $this->getPage();

        if (empty($data['page'])) {
            show_404();
            return;
        }

        $page = $data['page'][0];
        $basic = !empty($data['basicinfo'][0]) ? $data['basicinfo'][0] : getBasic();
        $site_name = !empty($basic->title) ? $basic->title : 'BODARE & Community MPC';
        $slug = !empty($page->pageslug) ? $page->pageslug : $page->pageid;
        $description = seo_plain_text($page->pagecontent, 160);
        if ($description === '') {
            $description = $page->pagetitle . ' — information from ' . $site_name . '.';
        }
        $data['seo'] = array(
            'title' => $page->pagetitle . ' | ' . $site_name,
            'description' => $description,
            'keywords' => $page->pagetitle . ', BODARE, Bohol cooperative',
            'canonical' => base_url('home/page/' . $slug),
            'type' => 'article',
            'json_ld' => array(
                seo_organization_schema($basic),
                seo_breadcrumb_schema(array(
                    'Home' => '',
                    $page->pagetitle => 'home/page/' . $slug,
                )),
                array(
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => $page->pagetitle,
                    'description' => $description,
                    'url' => base_url('home/page/' . $slug),
                    'isPartOf' => array(
                        '@type' => 'WebSite',
                        'name' => $site_name,
                        'url' => base_url(),
                    ),
                ),
            ),
        );

        $this->load->view('header2',$data);
        $this->load->view('page/view', $data);
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
    /***** Get Page Info ********/
    /*****************************/
    public function getPage(){ 
        $pagekey = $this->uri->segment(3);
        if(is_numeric($pagekey)){ 
            $this->db->where('pageid', $pagekey);
            $query = $this->db->get('page');
        }else{
            $this->db->where('pageslug', $pagekey);
            $query = $this->db->get('page');
        }
        
        return $query->result();
    }
    
    
}