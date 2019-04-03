<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_card_c extends CI_Controller {
    
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
        $this->load->model('Trans_Model');
        $this->load->model('Search_Model');
	}

    public function date()
    {
        $date = $this->db->query("SELECT CURDATE() as curdate")->row('curdate');
        return $date;
    }

    public function datetime()
    {
        $datetime = $this->db->query("SELECT NOW() as datetime")->row('datetime');
        return $datetime;
    }

    public function guid()
    {
        $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid');
        return $guid;
    }

    public function replace_char_phoneno($phone_no)
    {
        $replace = $this->db->query("SELECT REPLACE(REPLACE('$phone_no','-',''),' ','') AS phone_no")->row('phone_no');
        return $replace;
    }

    public function check_parameter()
    {
        $query = $this->db->query("SELECT * FROM `set_parameter`");
        return $query; 
    }

    public function index()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $data = array(
                'title' => 'Setup Card Running No by Branch',
                'record' => $this->db->query(" SELECT 
                    CONCAT(
                    IF(a.`inc_prefix` = 1,a.`prefix`,''),
                    IF(a.`inc_branch` = 1,a.`branch_id`,''),
                    IF(a.`inc_date` = 1,DATE_FORMAT(CURDATE(),a.`date_format`),''),
                    LPAD('0'+1,a.`card_digit`,0),
                    IF(a.`inc_random_no` = 1,LPAD(FLOOR(RAND() * 999999.99), a.`random_digit`, '0'),'')
                    ) AS sample_refno,
                    DATE_FORMAT(CURDATE(), a.`date_format`) AS date_example,
                    a.* FROM `set_branch_parameter` a;"),
                'date_Ymd' => $this->db->query("SELECT DATE_FORMAT(curdate(), '%Y%m%d') as curdate")->row('curdate'),
                'date_ymd' => $this->db->query("SELECT DATE_FORMAT(curdate(), '%y%m%d') as curdate")->row('curdate'),
                'date_ym' => $this->db->query("SELECT DATE_FORMAT(curdate(), '%y%m') as curdate")->row('curdate'),
            );    
            $this->template->load('template' , 'setup_card', $data);
        }   
        else
        {
            redirect('login_c');
        }
    }

    public function save_update()
    {
        if($this->input->post('random1234') == 'Include'){$value_random1234 = 1;}else{$value_random1234 = 0;};
        if($this->input->post('branch_id1234') == 'Include'){$branch_id1234 = 1;}else{$branch_id1234 = 0;};
        if($this->input->post('prefix') == 'Include'){$value_prefix = 1;}else{$value_prefix = 0;};
        if($this->input->post('date') == 'Include'){$value_date = 1;}else{$value_date = 0;};
        
        $data = array(
            'inc_branch' => $branch_id1234,
            'branch_id' => $this->input->post('branch_id'),
            'card_digit' => $this->input->post('card_digit'),
            'run_no_format' => $this->input->post('run_format'),
            'inc_random_no' => $value_random1234,
            'random_digit' => $this->input->post('random_digit'),
            'inc_prefix' => $value_prefix,
            'prefix' => $this->input->post('prefix_code'),
            'inc_date' => $value_date,
            'date_format' => $this->input->post('date_format'),
        );
        $this->db->where('guid',$this->input->post('guid'));
        $this->db->update('set_branch_parameter',$data);

        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
        redirect('Setup_card_c');
    }


}
?>


        