<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_advance_c extends CI_Controller {
    
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
        if($this->session->userdata('loginuser')== true)
        {  
            if($_REQUEST['name'] == 'branch')
            {
                $data = array(
                    'title' => 'Branch',
                    'action' => site_url("Setup_advance_c/insert_data?table=set_branch&form=branch"),
                    'label1' => 'Code',
                    'label2' => 'Name',
                    'label3' => 'Voucher Code',
                    'label4' => 'Current No (Voucher)',
                    'label5' => 'No of Digit (Voucher)',
                    /*'label6' => '',*/
                    );
            }

            $this->template->load('template' , 'setup_advance' , $data);   
        }
        else
        {
            redirect('login_c');
        }
    }

    public function insert_data()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $table = $_REQUEST['table'];
            $form = $_REQUEST['form'];

            if($form == 'branch')
            {
                $time = $this->db->query("SELECT NOW() as time")->row('time');
                $data = array(
                    'branch_guid' => $this->db->query("SELECT(REPLACE(UPPER(UUID()), '-', '')) as uuid")->row('uuid'),
                    'branch_code' => $this->input->post('input1'),
                    'branch_name' => $this->input->post('input2'),
                    'voucher_code' => $this->input->post('input3'),
                    'voucher_no_current' => $this->input->post('input4'),
                    'voucher_no_digit' => $this->input->post('input5'),
                    'created_at' => $time,
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $time,
                    'updated_by' => $_SESSION['username'],
                    /*'label6' => '',*/
                    );
            }

            $this->db->insert($table, $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_advance_c?name=" .$form);
        }
        else
        {
            redirect('login_c');
        }
    }

    

}
?>
