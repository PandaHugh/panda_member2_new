<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home_c extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('Home_Model');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');

	}

	public function viewdata()
    {
        if($this->session->userdata('loginuser')== true)
        {
        //load the database  
        $this->load->database();  
        //load the model  
        $this->load->model('home_model');  
        //load the method of model  
        $data['h'] = $this->home_model->home_data();
        //return the data in view
        $this->load->view('header');
        $this->load->view('home', $data);
        $this->load->view('footer');
        }
        else
        {
            $this->load->view('header');
            $this->load->view('index');
            $this->load->view('footer');
        }
        
    }
}
