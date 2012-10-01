<?php
class MY_Controller extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->data['siteInfo'] = array(
            'name'        => 'Zebra',
            'description' => 'An open source social news application'
        );
       
        $this->user = $this->session->userdata('user_id') ? $this->user_model->find_by_id($this->session->userdata('user_id')) : FALSE;
    }

    /* Autoview */
    /*
    # Expects you to have a folder name === Controller class name and a function_name.php file for each function that needs a view just 
    # add data to the view $this->view_data['data'] = DATA_FOR_VIEW
    */


		protected $layout_view = 'app';
    protected $content_view = '';
  	protected $view_data = array(); //data sent to content view

  	public function _output($output){
  		//default content view
  		if($this->content_view !== FALSE && empty($this->content_view))
  				$this->content_view = $this->router->class .'/'. $this->router->method;

  		//render content view
  			$yield = file_exists(APPPATH.'views/'. $this->content_view.EXT) ? $this->load->view($this->content_view, $this->view_data, TRUE) : FALSE;

  			//render layout
  			if($this->layout_view)
  				echo $this->load->view('layouts/' . $this->layout_view, array('yield' => $yield), TRUE);
  			else
  				echo $yield;
  	}

}
