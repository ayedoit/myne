<?php
  class Page {
    private $ci;
    
    function __construct () {
      $this->ci =& get_instance();
    }
    
    public function getHeader() {
      return $this->ci->load->view('header',true);
    }
    
    public function getFooter() {
      return $this->ci->load->view('footer','',true);
    }
    
    public function getNavLeft() {
      return $this->ci->load->view('nav_left','',true);
    }
    public function getPanelContent($content) {
      return $this->ci->load->view('panel_content',array('content' => $content),true);                                                                                                                                                      
    }                                                                                                                                                                                                                                       
                                                                                                                                                                                                                                            
    public function getMain($content) {                                                                                                                                                                                                     
      return $this->ci->load->view('main',                                                                                                                                                                                                  
          array(                                                                                                                                                                                                                            
            'nav_left' => $this->getNavLeft(),                                                                                                                                                                                              
            'panel_content' => $this->getPanelContent($content)                                                                                                                                                                             
          ),                                                                                                                                                                                                                                
          true);                                                                                                                                                                                                                            
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