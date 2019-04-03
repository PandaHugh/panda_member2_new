<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Point_c extends CI_Controller {
    
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

    public function point_redeemtion()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $this->template->load('template' , 'point_redeemtion');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function point_adj_in_out()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $data = array(
                'branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),
                'trans_main' => $this->db->query("SELECT * from trans_main"),
                'column' => $_REQUEST['column'],
                'type' => '',
                'Reference' => '',
                'Code' => '',
                'Name' => '',
                'Point_Before' => '',
                'Point_Adjust' => '',
                'Point_Balance' => '',

                );

            $this->template->load('template' , 'point_adj_in_out', $data);
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
            $key = $this->input->post('memberno');
            $condition = $_REQUEST['condition'];
            $current = $this->db->query("SELECT MONTH(CURDATE()) as month")->row('month');
            $month = $this->db->query("SELECT MONTH(REF_DATE) as month FROM set_sysrun WHERE TRANS_TYPE = '$condition' ")->row('month');
            $branch = $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC");
            $trans_main = $this->db->query("SELECT * from trans_main");

            if($current == $month)
            {
                $sql = $this->db->query("SELECT CONCAT(REF_CODE, REPLACE(CURDATE(), '-', ''), REPEAT(0,REF_DIGIT-LENGTH(REF_RUNNINGNO + 1)), REF_RUNNINGNO) AS asn_no FROM backend_member.set_sysrun WHERE TRANS_TYPE = '$condition' ")->row('asn_no');
            }
            else
            {
                $info = array(
                        'REF_RUNNINGNO' => '0',
                        );
                $this->db->where('TRANS_TYPE', $condition);
                $this->db->update('set_sysrun', $info);

                $sql = $this->db->query("SELECT CONCAT(REF_CODE, REPLACE(CURDATE(), '-', ''), REPEAT(0,REF_DIGIT-LENGTH(REF_RUNNINGNO + 1)), REF_RUNNINGNO) AS asn_no FROM backend_member.set_sysrun WHERE TRANS_TYPE = '$condition' ")->row('asn_no');
            }
            
            if($this->input->post('search') == 'Card')
            {
                $result = $this->db->query("SELECT * FROM backend_member.member WHERE AccountNo = '$key' ");
                $ref = $this->db->query("SELECT (REF_RUNNINGNO+1) AS ref FROM set_sysrun WHERE TRANS_TYPE='POINT_ADJ_IN' ")->row('ref');

                if($result->num_rows() > 0)
                {
                    $data = array(
                        'branch' => $branch,
                        'trans_main' => $trans_main,
                        'column' => 'POINT_ADJ_IN',
                        'Reference' => $sql,
                        'Code' => $result->row('AccountNo'),
                        'Name' => $result->row('Name'),
                        'Point_Before' => $result->row('Points'),
                        'Point_Adjust' => $result->row('PointsAdj'),
                        'Point_Balance' => $result->row('Pointsbalance'),

                        );
                    $this->template->load('template' , 'point_adj_in' , $data);
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Invalid Card No.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/point_adj_in");
                }     
            };

            if($this->input->post('search') == 'Name')
            {
                $result = $this->db->query("SELECT * FROM backend_member.member WHERE Name = '$key' ");

                if($result->num_rows() > 0)
                {
                    $data = array(
                        'branch' => $branch,
                        'trans_main' => $trans_main,
                        'column' => 'POINT_ADJ_IN',
                        'Reference' => $sql,
                        'Code' => $result->row('AccountNo'),
                        'Name' => $result->row('Name'),
                        'Point_Before' => $result->row('Points'),
                        'Point_Adjust' => $result->row('PointsAdj'),
                        'Point_Balance' => $result->row('Pointsbalance'),

                        );
                    $this->template->load('template' , 'point_adj_in' , $data);
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Name is not exist<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/point_adj_in");
                }
            };

            if($this->input->post('search') == 'Passport')
            {
                $result = $this->db->query("SELECT * FROM backend_member.member WHERE PassportNo = '$key' ");

                if($result->num_rows() > 0)
                {
                    $data = array(
                        'branch' => $branch,
                        'trans_main' => $trans_main,
                        'column' => 'POINT_ADJ_IN',
                        'Reference' => $sql,
                        'Code' => $result->row('AccountNo'),
                        'Name' => $result->row('Name'),
                        'Point_Before' => $result->row('Points'),
                        'Point_Adjust' => $result->row('PointsAdj'),
                        'Point_Balance' => $result->row('Pointsbalance'),

                        );
                    $this->template->load('template' , 'point_adj_in' , $data);
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Invalid Passport No.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/point_adj_in");
                }
            };

            if($this->input->post('search') == 'Ic')
            {
                $result = $this->db->query("SELECT * FROM backend_member.member WHERE ICNo = '$key' ");

                if($result->num_rows() > 0)
                {
                    $data = array(
                        'branch' => $branch,
                        'trans_main' => $trans_main,
                        'column' => 'POINT_ADJ_IN',
                        'Reference' => $sql,
                        'Code' => $result->row('AccountNo'),
                        'Name' => $result->row('Name'),
                        'Point_Before' => $result->row('Points'),
                        'Point_Adjust' => $result->row('PointsAdj'),
                        'Point_Balance' => $result->row('Pointsbalance'),

                        );
                    $this->template->load('template' , 'point_adj_in' , $data);
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Invalid IC No.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/point_adj_in");
                }
            };         
        }
        else
        {
            redirect('login_c');
        }
    }

    public function create_point_adj_in()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $condition = $_REQUEST['condition'];
            $date = $this->db->query("SELECT NOW() AS date")->row('date');

            if($this->input->post('post') == 'on')
            {
                $post = '1';
            }
            else
            {
                $post = '0';
            }

            $data = array(
                'TRANS_GUID' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS UUID")->row('UUID'),
                'TRANS_TYPE' => $_REQUEST['condition'],
                'REF_NO' => $this->input->post('Reference'),
                'TRANS_DATE' => $this->input->post('Date'),
                'SUP_CODE' => $this->input->post('Code'),
                'SUP_NAME' => $this->input->post('Name'),
                'REMARK' => $this->input->post('Remarks'),
                'VALUE_TOTAL' => '0',
                'POSTED' => $post,
                'CREATED_AT' => $date,
                'CREATED_BY' => $_SESSION['username'],
                'UPDATED_AT' => $date,
                'UPDATED_BY' => $_SESSION['username'],
                'point_curr' => $this->input->post('Point_Balance'),
                'branch' => $this->input->post('Branch'),
                'send_outlet' => '0',

                );
            $this->db->insert('trans_main', $data);

            if($this->db->affected_rows() > 0)
                {
                    $ref = $this->db->query("SELECT (REF_RUNNINGNO+1) AS ref FROM set_sysrun WHERE TRANS_TYPE='POINT_ADJ_IN' ")->row('ref');
                    $info = array(
                        'REF_RUNNINGNO' => $ref,
                        'REF_DATE' => $this->db->query("SELECT CURDATE() AS date")->row('date'),
                        );
                    $this->db->where('TRANS_TYPE', $condition);
                    $this->db->update('set_sysrun', $info);

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Insert Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Insert Record<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                
            redirect("Point_c/point_adj_in");
        }
        else
        {
            redirect('login_c');
        }
    }

    /*public function point_adj_out()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $this->template->load('template' , 'point_adj_out');
        }
        else
        {
            redirect('login_c');
        }
    }*/
}