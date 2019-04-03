<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_c extends CI_Controller {
    
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
            $data = array(
                'user_logs' => $this->db->query("SELECT Trans_type, AccountNo, ReferenceNo, field as Field, value_from as Value_from, value_to as Value_to, created_at, created_by from user_logs order by created_at desc limit 500"),

            );

            $this->template->load('template' , 'log', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function search()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $key = $this->input->post('log');

            if($this->input->post('search') == 'General')
            {
                $data['user_logs'] = $this->db->query("SELECT * FROM (
                    SELECT Trans_type, AccountNo, ReferenceNo, field as Field, value_from as Value_from, value_to as Value_to, created_at, created_by FROM user_logs WHERE Trans_type LIKE '%$key%' 
                    UNION ALL
                    SELECT Trans_type, AccountNo, ReferenceNo, field as Field, value_from as Value_from, value_to as Value_to, created_at, created_by FROM user_logs WHERE AccountNo LIKE '%$key%' 
                    UNION ALL
                    SELECT Trans_type, AccountNo, ReferenceNo, field as Field, value_from as Value_from, value_to as Value_to, created_at, created_by FROM user_logs WHERE field LIKE '%$key%' 
                    UNION ALL
                    SELECT Trans_type, AccountNo, ReferenceNo, field as Field, value_from as Value_from, value_to as Value_to, created_at, created_by FROM user_logs WHERE created_at LIKE '%$key%' ) a ");
            };

            if($this->input->post('search') == 'Type')
            {
                $data['user_logs'] = $this->db->query("SELECT Trans_type, AccountNo, ReferenceNo, field as Field, value_from as Value_from, value_to as Value_to, created_at, created_by FROM user_logs WHERE Trans_type LIKE '%$key%' ");
            };

            if($this->input->post('search') == 'Account No')
            {
                $data['user_logs'] = $this->db->query("SELECT Trans_type, AccountNo, ReferenceNo, field as Field, value_from as Value_from, value_to as Value_to, created_at, created_by FROM user_logs WHERE AccountNo LIKE '%$key%' ");
            };

            if($this->input->post('search') == 'Field')
            {
                $data['user_logs'] = $this->db->query("SELECT Trans_type, AccountNo, ReferenceNo, field as Field, value_from as Value_from, value_to as Value_to, created_at, created_by FROM user_logs WHERE field LIKE '%$key%' ");
            };

            if($this->input->post('search') == 'Created At')
            {
                $data['user_logs'] = $this->db->query("SELECT Trans_type, AccountNo, ReferenceNo, field as Field, value_from as Value_from, value_to as Value_to, created_at, created_by FROM user_logs WHERE created_at LIKE '%$key%' ");
            };

            $this->template->load('template' , 'log' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    



}