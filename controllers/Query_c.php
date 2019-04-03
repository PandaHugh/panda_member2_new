<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Query_c extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');

	}

    public function index()
    {
        if($this->session->userdata('loginuser') == true)
        {
            if(isset($_SESSION['Description']))
            {
                $data = array(
                    'Description' => $_SESSION['Description'],
                    'Script' => $_SESSION['Script'],

                );

                unset($_SESSION['Description']);
                unset($_SESSION['Script']);
            }
            else
            {
                $data = array(
                    'Description' => '',
                    'Script' => '',

                );
            }

            $this->template->load('template' , 'query', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function submit()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $result = $this->db->query("SELECT * from query_backend where itemcode = '".$this->input->post('Item_Code')."' ");

            if($result->num_rows() > 0)
            {
                $_SESSION['Description'] = $this->input->post('Description');
                $_SESSION['Script'] = $this->input->post('Script');

                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Item code already exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                redirect("Query_c");
            }
            else
            {
                $data = array(
                    'guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS UUID")->row('UUID'),
                    'itemcode' => $this->input->post('Item_Code'),
                    'description' => $this->input->post('Description'),
                    'script' => $this->input->post('Script'),

                );
                $this->db->insert('query_backend', $data);

                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Insert script successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert script<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }

                redirect("Query_c");
            }
        }
        else
        {
            redirect('login_c');
        }
    }

    


}