<?php
  class Page {
    private $ci;
    
    function __construct () {
      $this->ci =& get_instance();
      $this->ci->load->library('user_agent');
    }
    
    public function getHeader() {
		if ($this->ci->agent->is_mobile()) {
			 return $this->ci->load->view('header_mobile',true);
		}
		else {
			return $this->ci->load->view('header',true);
		}
    }
    
    public function getFooter() {
		if ($this->ci->agent->is_mobile()) {
			 return $this->ci->load->view('footer_mobile',true);
		}
		else {
			return $this->ci->load->view('footer',true);
		}
    }
    
    //~ public function getNavLeft() {
      //~ return $this->ci->load->view('nav_left','',true);
    //~ }
    public function getPanelContent($content) {
		if ($this->ci->agent->is_mobile()) {
			 return $this->ci->load->view('panel_content_mobile',array('content' => $content),true);
		}
		else {
			return $this->ci->load->view('panel_content',array('content' => $content),true);
		}                                                                                                                                                   
    }                                                                                                                                                                                                                                       
                                                                                                                                                                                                                                            
    public function getMain($content) {
		$panelcontent = array(
			//'nav_left' => $this->getNavLeft(),                                                                                                                                                                                              
            'panel_content' => $this->getPanelContent($content) 
		);
		if ($this->ci->agent->is_mobile()) {
			 return $this->ci->load->view('main_mobile',$panelcontent,true);
		}
		else {
			return $this->ci->load->view('main',$panelcontent,true);
		}                                                                                                                                                                                                                           
    }                                                                                                                                                                                                                                       
                                                                                                                                                                                                                                            
    public function show($content) {                                                                                                                                                                                                        
      $this->ci->load->view('body',                                                                                                                                                                                                         
          array(                                                                                                                                                                                                                            
            'header' => $this->getHeader(),                                                                                                                                                                                                 
            'main' => $this->getMain($content),                                                                                                                                                                                             
            'footer' => $this->getFooter()                                                                                                                                                                                                   
          )
        );
    }
  }
?>
