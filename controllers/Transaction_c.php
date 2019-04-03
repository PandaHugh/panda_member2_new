<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_c extends CI_Controller {
    
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
        $this->load->model('Member_Model');
	}

    public function test()
    {
        $query = $this->db->query("SELECT * FROM member a limit 20");
        var_dump($query->list_fields()) ;

        $data = array(
            'result' => $query
        );
        $this->load->view('testting_table', $data);
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

    public function branch()
    {
        $branch = array();

        $data = array(
            'username' => $_SESSION['username'],
            'userpass' => $_SESSION['userpass'],
            'module_group_guid' => $_SESSION['module_group_guid'],
        );

        $result = $this->Member_Model->query_call('Transaction_c', 'branch', $data);

        if(isset($result['branch']))
        {
            $branch = $result['branch'];
        }

        return $branch;
    }

    public function branch_with_receipt()
    {
        $branch = array();

        $data = array(
                'username' => $_SESSION['username'],
                'userpass' => $_SESSION['userpass'],
                'module_group_guid' => $_SESSION['module_group_guid'],
            );

        $result = $this->Member_Model->query_call('Transaction_c', 'branch_with_receipt', $data);

        if(isset($result['branch']))
        {
            $branch = $result['branch'];
        }

        return $branch;
    }

    public function insert_sqlscript($data)
    {
        $result = $this->Member_Model->query_call('Transaction_c', 'insert_sqlscript', $data);

        return $result;
    }

    public function check_parameter()
    {
        $query = $this->db->query("SELECT * FROM `set_parameter`");
        return $query; 
    }
    
    public function index()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $data = array(
                'AccountNo' => '',
                'CardNo' => '',
                'Cardtype' => '',
                'Active' => '',
                'staff' => '',
                'Credit' => '',
                'ICNo' => '',
                'Expirydate' => '',
                'Issuedate' => '',
                'IssueStamp' => '',
                'PassportNo' => '',
                'Birthdate' => '',
                'Title' => '',
                'Name' => '',
                'NameOnCard' => '',
                'Gender' => '',
                'Race' => '',
                'Religion' => '',
                'Status' => '', 
                'Email' => '',
                'Occupation' => '',
                'Nationality' => '',
                'Phonemobile' => '',
                'Phoneoffice' => '',
                'Phonehome' => '',
                'Fax' => '',
                'Address1' => '',
                'Address2' => '',
                'Address3' => '',
                'Postcode' => '',
                'City' => '',
                'State' => '',
                'LimitAmtBalance' => '',
                'UPDATED_AT' => '',
                'CREATED_BY' => $_SESSION['username'],
                'NewForScript' => '',

                'set_nationality' => $this->db->query("SELECT * FROM set_nationality "),
                'set_title' => $this->db->query("SELECT * FROM set_title  "),
                'set_race' => $this->db->query("SELECT * FROM set_race "),
                'set_religion' => $this->db->query("SELECT * FROM set_religion "),
                'set_status' => $this->db->query("SELECT * FROM set_status"),
                'set_occupation' => $this->db->query("SELECT * FROM set_occupation "),
                'set_cardtype' => $this->db->query("SELECT * FROM cardtype "),

                'decision' => '',
                'page_title' => 'Add Member',
                'button' => 'Create',
                'direction' => site_url('Transaction_c/insert'),
                );
            $this->template->load('template' , 'test' , $data);
        
        }
        else
        {
            redirect('login_c');
        }
        
    }

    public function check_exist_receipt_no($receipt_no)
    {
        $check_exist_receipt_no = $this->db->query("SELECT * FROM user_logs WHERE ReceiptNo = '$receipt_no'");
        return $check_exist_receipt_no;
    }

    public function insert()
    {
        if($this->session->userdata('loginuser')== true)
        {  
                if($this->input->post('Birthdate') == '')
                {
                    $Birthdate = '(00-00-0000)';
                }
                else
                {
                    $Birthdate = $this->input->post('Birthdate');
                }

                if($this->input->post('Issuedate') == '')
                {
                    $Issuedate = "(NULL)";
                }
                else
                {
                    $Issuedate = $this->input->post('Issuedate');
                }

                if($this->input->post('Expirydate') == '')
                {
                    $Expirydate = '0000-00-00';
                }
                else
                {
                    $Expirydate = $this->input->post('Expirydate');
                }

                $data = array(
                    'AccountNo' => $this->input->post('AccountNo'),
                    'Nationality' => $this->input->post('Nationality'), 
                    'ICNo' => $this->input->post('ICNo'), 
                    'PassportNo' => $this->input->post('PassportNo'),
                    'Title' => $this->input->post('Title'), 
                    'Name' => $this->input->post('Name'), 
                    'NameOnCard' => $this->input->post('NameOnCard'), 
                    'Birthdate' => $Birthdate, 
                    'Gender' => $this->input->post('Gender'),
                    'Race' => $this->input->post('Race'), 
                    'Religion' => $this->input->post('Religion'), 
                    'Status' => $this->input->post('Status'), 
                    'Occupation' => $this->input->post('Occupation'),
                    
                    'Email' => $this->input->post('Email'), 
                    'Phonemobile' => $this->input->post('Phonemobile'),
                    'Phoneoffice' => $this->input->post('Phoneoffice'), 
                    'Phonehome' => $this->input->post('Phonehome'), 
                    'Fax' => $this->input->post('Fax'),
                    'Address1' => $this->input->post('Address1'), 
                    'Address2' => $this->input->post('Address2'), 
                    'Address3' => $this->input->post('Address3'), 
                    'Postcode' => $this->input->post('Postcode'),
                    'City' => $this->input->post('City'), 
                    'State' => $this->input->post('State'), 
                    
                    'Active' => $this->input->post('Active'), 
                    'staff' => $this->input->post('staff'), 
                    'Cardtype' => $this->input->post('Cardtype'),
                    'Credit' => $this->input->post('Credit'), 
                    'LimitAmtBalance' => $this->input->post('LimitAmtBalance'), 
                    'Expirydate' => $Expirydate, 
                    'Issuedate' => $Issuedate,
                    //'updated_at' => $this->db->query("SELECT NOW() as datetime")->row('datetime'),
                    //'NewForScript' => "1",
                    'CREATED_BY' => $this->input->post('CREATED_BY'),
                    );

                $this->db->insert('member' , $data);

                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Insert Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Main_c');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">No Record Update<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Main_c');
                }
            
        }
        else
        {
            redirect('login_c');
        }
    }

    public function pre_issue_card()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $data = array(
                'mem_issue_card' => $this->db->query("SELECT * from mem_issue_card"),
                'cardtype' => $this->db->query("SELECT * from cardtype order by CardType asc"),
                // 'branch' => $this->db->query("SELECT * from set_branch"),
                'prefix_in' => '',
                'cardtype_in' => '',
                'branch_in' => '',
                'suffix_in' => '4',
                'nofrom_in' => '',
                'noto_in' => '',
                'remark_in' => '',
                'total' => '',
                'disable' => 'disabled',
                'enable' => '',
                'type' => 'hidden',
                // 'branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),
                'branch' => $this->branch(),
                );
            // echo $this->db->last_query();die;
            $this->template->load('template' , 'pre_issue_card' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function create_pre_issue_card()
    {
        if($this->session->userdata('loginuser')== true)
        {  
           $_SESSION['sample'] = $this->input->post('sample');
           $_SESSION['prefix'] = $this->input->post('prefix');
           $_SESSION['cardtype'] = $this->input->post('card');
           $_SESSION['branch'] = $this->input->post('branch');
           $_SESSION['suffix'] = $this->input->post('suffix');
           $_SESSION['nofrom'] = $this->input->post('from');
           $_SESSION['noto'] = $this->input->post('to');
           $_SESSION['remark'] = $this->input->post('remark');
           $prefix_len = strlen($_SESSION['prefix']);
           $running = $_SESSION['suffix'];
           $total = $prefix_len + $running;
           $account_card = $this->db->query("SELECT CONCAT('".$this->input->post('prefix')."', LPAD('".$this->input->post('from')."', '".$running."', '0')) as pad")->row('pad');

           if($_SESSION['sample'] != $account_card)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Your input sample is not match with sample card no<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                //$result = $_SESSION['noto'] - $_SESSION['nofrom'];
                //$active = $this->db->query("SELECT preissue_default_active as active from set_parameter")->row('active');
                $results_num = explode($_SESSION['prefix'], $account_card);
                $result_account_card_no = $results_num[1];

                $result_final = $this->db->query("SELECT CONCAT('".$this->input->post('prefix')."', LPAD('".$result_account_card_no."', '".$_SESSION['suffix']."' , '0')) as pad")->row('pad');
                $check_digit = $this->db->query("SELECT check_digit_card from set_parameter")->row('check_digit_card');
                $check_cardno_length = $this->db->query("SELECT cardno_length from set_parameter")->row('cardno_length');

                if($check_digit == '1')
                {
                    $result_final_no = $this->db->query("SELECT CONCAT('$result_final', RIGHT(10-MOD(MID('$result_final', 1, 1) + MID('$result_final', 3, 1) + MID('$result_final', 5, 1) + MID('$result_final', 7, 1) + MID('$result_final', 9, 1) + MID('$result_final', 11, 1) + ((MID('$result_final', 2, 1) + MID('$result_final', 4, 1) + MID('$result_final', 6, 1) + MID('$result_final', 8, 1) + MID('$result_final', 10, 1) + MID('$result_final', 12, 1))*3), 10), 1)) AS check_digit ")->row('check_digit');
                    $length = $this->db->query("SELECT length('$result_final_no') as length ")->row('length');
                }
                else
                {
                    $result_final_no = $result_final;
                    $length = $this->db->query("SELECT length('$result_final_no') as length ")->row('length');
                }

                if($length > $check_cardno_length)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Card no. has exceeded $check_cardno_length digits, please contact our support team<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                else
                {  
                    $time = $this->db->query("SELECT NOW() as time")->row('time');
                    $data = array(
                        'PREFIX' => $this->input->post('prefix'),
                        'CARDNO_FROM' => $this->input->post('from'),
                        'CARDNO_TO' => $this->input->post('to'),
                        'REMARK' =>  $this->input->post('remark'),
                        'CREATED_BY' => $_SESSION['username'],
                        'CREATED_AT' => $time,
                        'UPDATED_BY' => $_SESSION['username'],
                        'UPDATED_AT' => $time,
                        'branch' => $this->input->post('branch'),
                        );

                    // $this->db->insert('mem_issue_card', $data);

                    $this->db->query("INSERT INTO mem_issue_card (
                                        PREFIX,
                                        CARDNO_FROM,
                                        CARDNO_TO,
                                        REMARK,
                                        CREATED_BY,
                                        CREATED_AT,
                                        UPDATED_BY,
                                        UPDATED_AT,
                                        branch
                                        )
                                        VALUES(
                                        '".$this->input->post('prefix')."',
                                        '".$this->input->post('from')."',
                                        '".$this->input->post('to')."',
                                        '".$this->input->post('remark')."',
                                        '".$_SESSION['username']."',
                                        NOW(),
                                        '".$_SESSION['username']."',
                                        NOW(),
                                        '".$this->input->post('branch')."'
                                        )
                                        ON DUPLICATE KEY UPDATE PREFIX='".$this->input->post('prefix')."', CARDNO_FROM='".$this->input->post('from')."', CARDNO_TO='".$this->input->post('to')."' " );
                    // echo $this->db->last_query();die;


                    if($this->db->affected_rows() > 0)
                    {
                        $result = $_SESSION['noto'] - $_SESSION['nofrom'];
                        $active = $this->db->query("SELECT preissue_default_active as active from set_parameter")->row('active');

                        $len_prefix = strlen($_SESSION['prefix'])+1;
                        $account_card_no = $this->db->query("SELECT SUBSTRING('$account_card', $len_prefix, 100) AS a ")->row('a');
                        /*$results = explode($_SESSION['prefix'], $account_card);
                        $account_card_no = $results[1];*/
                        $x = 0;

                        do {
                            
                            $final = $this->db->query("SELECT CONCAT('".$this->input->post('prefix')."', LPAD('".$account_card_no."', '".$_SESSION['suffix']."' , '0')) as pad")->row('pad');

                            $check_digit = $this->db->query("SELECT check_digit_card from set_parameter")->row('check_digit_card');

                            if($check_digit == '1')
                            {
                                $final_no = $this->db->query("SELECT CONCAT('$final', RIGHT(10-MOD(MID('$final', 1, 1) + MID('$final', 3, 1) + MID('$final', 5, 1) + MID('$final', 7, 1) + MID('$final', 9, 1) + MID('$final', 11, 1) + ((MID('$final', 2, 1) + MID('$final', 4, 1) + MID('$final', 6, 1) + MID('$final', 8, 1) + MID('$final', 10, 1) + MID('$final', 12, 1))*3), 10), 1)) AS check_digit ")->row('check_digit');
                            }
                            else
                            {
                                $final_no = $final;
                            }

                            // echo $this->db->last_query();die;
                            $info = array(
                                'AccountNo' => $final_no,
                                'CardNo' => $final_no,
                                'Name' => 'NEW',
                                'Issuedate' =>  $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y-%m-%d') as date")->row('date'),
                                'Expirydate' => $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y-%m-%d') as date")->row('date'),
                                'Cardtype' => $_SESSION['cardtype'],
                                'Active' => $active,
                                'CREATED_BY' => $_SESSION['username'],
                                'IssueStamp' => $time,
                                'created_at' => $time,
                                'UPDATED_BY' => $_SESSION['username'],
                                'LastStamp' => $time,
                                'updated_at' => $time,
                                'branch' => $this->input->post('branch'),
                                'NewForScript' => '1',
                                );

                            // $this->db->insert('member', $info);
                            $this->db->query("INSERT INTO member (
                                        AccountNo,
                                        CardNo,
                                        Name,
                                        Issuedate,
                                        Expirydate,
                                        Cardtype,
                                        Active,
                                        CREATED_BY,
                                        IssueStamp,
                                        created_at,
                                        UPDATED_BY,
                                        LastStamp,
                                        updated_at,
                                        branch,
                                        branch_group,
                                        NewForScript,
                                        acc_status
                                        )
                                        VALUES(
                                        '$final_no',
                                        '$final_no',
                                        'NEW',
                                        DATE_FORMAT(NOW(),'%Y-%m-%d'),
                                        DATE_FORMAT(NOW(),'%Y-%m-%d'),
                                        '".$_SESSION['cardtype']."',
                                        '$active',
                                        '".$_SESSION['username']."',
                                        '$time',
                                        '$time',
                                        '".$_SESSION['username']."',
                                        '$time',
                                        '$time',
                                        '".$this->input->post('branch')."',
                                        '".$this->input->post('branch')."',
                                        '1',
                                        'NEW'
                                        )
                                        ON DUPLICATE KEY UPDATE branch='".$this->input->post('branch')."', branch_group='".$this->input->post('branch')."', LastStamp='$time', NewForScript='1' " );
                            
                            $account_card_no += 1;
                            $x++;

                        } while($x <= $result);
            
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');     
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }    
                }    
            } 

            redirect("Transaction_c/pre_issue_card");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function issue_main_card()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            if(isset($_REQUEST['print']))
            {
                $bodyload = 'printdetails()';
                $AccountNo = $_REQUEST['AccountNo'];
                $CardNo = $_REQUEST['CardNo'];
            }
            else
            {
                $bodyload = '';
                $AccountNo = '';
                $CardNo = '';
            }

            if(isset($_REQUEST['created']))
            {
                $get_member = $this->db->query("SELECT * FROM `member` a WHERE a.`AccountNo` = '".$_REQUEST['created']."'");

                $data = array(
                    'AccountNo' => $get_member->row('AccountNo'),
                    'CardNo' => $get_member->row('CardNo'),
                    'Cardtype' => $get_member->row('Cardtype'),
                    'Credit' => $get_member->row('Credit'),
                    'ICNo' => $get_member->row('ICNo'),
                    'Expirydate' => $get_member->row('Expirydate'),
                    'Issuedate' => $get_member->row('Issuedate'),
                    'PassportNo' => $get_member->row('PassportNo'),
                    'Birthdate' => $get_member->row('Birthdate'),
                    'Title' => $get_member->row('Title'),
                    'Name' => $get_member->row('Name'),
                    'NameOnCard' => $get_member->row('NameOnCard'),
                    'Gender' => $get_member->row('Gender'),
                    'Race' => $get_member->row('Race'),
                    'Religion' => $get_member->row('Religion'),
                    'Status' => $get_member->row('Status'), 
                    'Email' => $get_member->row('Email'),
                    'Occupation' => $get_member->row('Occupation'),
                    'Nationality' => $get_member->row('Nationality'),
                    'Phonemobile' => $get_member->row('Phonemobile'),
                    'Phoneoffice' => $get_member->row('Phoneoffice'),
                    'Phonehome' => $get_member->row('Phonehome'),
                    'Fax' => $get_member->row('Fax'),
                    'Address1' => $get_member->row('Address1'),
                    'Address2' => $get_member->row('Address2'),
                    'Address3' => $get_member->row('Address3'),
                    'Postcode' => $get_member->row('Postcode'),
                    'City' => $get_member->row('City'),
                    'State' => $get_member->row('State'),

                    'set_nationality' => $this->db->query("SELECT Nationality FROM member WHERE accountno = '".$_REQUEST['created']."'  "),
                    'set_title' => $this->db->query("SELECT Title FROM member WHERE accountno = '".$_REQUEST['created']."'  "),
                    'set_race' => $this->db->query("SELECT Race FROM member WHERE accountno = '".$_REQUEST['created']."'  "),
                    'set_religion' => $this->db->query("SELECT Religion FROM member WHERE accountno = '".$_REQUEST['created']."'  "),
                    'set_status' => $this->db->query("SELECT Status FROM member WHERE accountno = '".$_REQUEST['created']."'  "),
                    'set_occupation' => $this->db->query("SELECT Occupation FROM member WHERE accountno = '".$_REQUEST['created']."'  "),
                    'set_cardtype' => $this->db->query("SELECT CardType FROM member WHERE accountno = '".$_REQUEST['created']."'  "),
                    'branch' => $this->db->query("SELECT branch as branch_code,'' as branch_name FROM member WHERE accountno = '".$_REQUEST['created']."' ") ,
                    'reason' => $this->db->query("SELECT * FROM set_reason where type = 'ACTIVATION' "),

                    'Nationality' => $get_member->row('Nationality') ,
                    'Title' => $get_member->row('Title') ,
                    'Race' => $get_member->row('Race') ,
                    'Religion' => $get_member->row('Religion') ,
                    'Status' => $get_member->row('Status') ,
                    'Occupation' => $get_member->row('Occupation') ,
                    'Cardtype' => $get_member->row('Cardtype') ,
                    'Gender' => $get_member->row('Gender'),
                    'branch_select' => $get_member->row('branch') ,

                    'decision' => '',
                    'page_title' => 'Issue Main Card',
                    'button' => 'Create',
                    'direction' => site_url('Transaction_c/insert_main_card'),

                    'bodyload' => $bodyload
                );
            }
            else
            {


               $get_preset_expiry_date = $this->db->query("SELECT CURDATE()+INTERVAL (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
            
            $data = array(
                'AccountNo' => '',
                'CardNo' => '',
                'Cardtype' => '',
                'Credit' => '',
                'ICNo' => '',
                'Expirydate' => $get_preset_expiry_date,
                'Issuedate' => $this->date(),
                'PassportNo' => '',
                'Birthdate' => '',
                'Title' => '',
                'Name' => '',
                'NameOnCard' => '',
                'Gender' => '',
                'Race' => '',
                'Religion' => '',
                'Status' => '', 
                'Email' => '',
                'Occupation' => '',
                'Nationality' => '',
                'Phonemobile' => '',
                'Phoneoffice' => '',
                'Phonehome' => '',
                'Fax' => '',
                'Address1' => '',
                'Address2' => '',
                'Address3' => '',
                'Postcode' => '',
                'City' => '',
                'State' => '',

                'set_nationality' => $this->db->query("SELECT * FROM set_nationality  "),
                'set_title' => $this->db->query("SELECT * FROM set_title  "),
                'set_race' => $this->db->query("SELECT * FROM set_race  "),
                'set_religion' => $this->db->query("SELECT * FROM set_religion  "),
                'set_status' => $this->db->query("SELECT * FROM set_status  "),
                'set_occupation' => $this->db->query("SELECT * FROM set_occupation  "),
                'set_cardtype' => $this->db->query("SELECT * FROM cardtype  "),
                // 'branch' => $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name, c.receipt_activate FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY b.branch_code ASC"),
                'branch' => $this->branch_with_receipt(),
                'reason' => $this->db->query("SELECT * FROM set_reason where type = 'ACTIVATION' "),
                'decision' => '',
                'page_title' => 'Issue Main Card',
                'button' => 'Create',
                'direction' => site_url('Transaction_c/insert_main_card'),

                'bodyload' => $bodyload
                ); 
            }

            $this->template->load('template' , 'issue_main_card' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function insert_main_card()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            //echo $this->db->last_query();die;
            //echo $account_no;die;

            // if user using army no as ic, pick armyno field
            if($this->input->post('army_no') != '' )
            {
                $icno = $this->input->post('army_no');
            }
            else
            {
                // if not decode ic no based on format.
                $icno = $this->Trans_Model->validate_ic_no($this->input->post('ic_no'));
                if($icno == 'Error')
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid Ic No!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                };
            };


            // if nationality is  not malaysian 
            if(strtoupper($this->input->post('national')) <> 'MALAYSIA' || strtoupper($this->input->post('national')) <> 'MALAYSIAN')
            {
                $id_type = 'PassportNo';
                $checking = $this->db->query("SELECT PassportNo FROM member WHERE PassportNo = '".$this->input->post('passport_no')."' ");
            };

            
            // if nationality is malaysian
            if(strtoupper($this->input->post('national')) == 'MALAYSIA' || strtoupper($this->input->post('national')) == 'MALAYSIAN')
            {
                echo $this->input->post('national');
                $id_type = 'IcNo';
                $checking = $this->db->query("SELECT ICNo FROM `member` WHERE ICNo = '".$icno."' ");
            };

            // if nationality is malaysian army
            if(strtoupper($this->input->post('national')) == 'MALAYSIA (ARMY)' || strtoupper($this->input->post('national')) == 'MALAYSIAN (ARMY)')
            {
                $id_type = 'ArmyNo';
                $checking = $this->db->query("SELECT ICNo FROM member WHERE ICNo = '".$this->input->post('army_no')."' ");
            };

            if($checking->num_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$id_type.'. already exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/issue_main_card');
            }

            $get_setup = $this->db->query("SELECT LEFT(a.`card_date`,4) AS year_format,LEFT(a.`card_date`,7) AS month_format, a.* FROM `set_branch_parameter` a WHERE a.`branch_code` = '".$this->input->post('branch')."' ");
            $curyear = $this->db->query("SELECT LEFT(CURDATE(),4) AS YEAR")->row('YEAR');
            $curmonth = $this->db->query("SELECT LEFT(CURDATE(),7) AS MONTH")->row('MONTH');
            
            if($get_setup->row('run_no_format') == 'DAY')
            {
                if($get_setup->row('card_date') <> $this->date() )
                {
                    $data = array(
                        'card_date' => $this->date(),
                        'card_run_no' => '1'
                    );
                }
                else
                {
                    $data = array(
                        'card_run_no' => $get_setup->row('card_run_no')+1,
                    );
                }
            };

            if($get_setup->row('run_no_format') == 'MONTH')
            {
                if($get_setup->row('month_format') <> $curmonth)
                {
                    $data = array(
                        'card_date' => $this->date(),
                        'card_run_no' => '1'
                    );
                }
                else
                {
                    $data = array(
                        'card_run_no' => $get_setup->row('card_run_no')+1,
                    );
                }
            };

            if($get_setup->row('run_no_format') == 'YEAR')
            {
                if($get_setup->row('year_format') <> $curyear)
                {
                    $data = array(
                        'card_date' => $this->date(),
                        'card_run_no' => '1'
                    );
                }
                else
                {
                    $data = array(
                        'card_run_no' => $get_setup->row('card_run_no')+1,
                    );
                }
            };

            $this->db->WHERE("guid",$get_setup->row('guid'));
            $this->db->update("set_branch_parameter",$data);

            $get_card_run_no = $this->db->query("SELECT * FROM set_branch_parameter a WHERE a.guid = '".$get_setup->row('guid')."'")->row('card_run_no');

            $account_no = $this->db->query("SELECT 
                    CONCAT(
                    IF(a.`inc_prefix` = 1,a.`prefix`,''),
                    IF(a.`inc_branch` = 1,a.`branch_id`,''),
                    IF(a.`inc_date` = 1,DATE_FORMAT(CURDATE(),a.`date_format`),''),
                    LPAD('".$get_card_run_no."',a.`card_digit`,0),
                    IF(a.`inc_random_no` = 1,LPAD(FLOOR(RAND() * 999999.99), a.`random_digit`, '0'),'')
                    ) AS refno FROM `set_branch_parameter` a WHERE a.`branch_code` = '".$this->input->post('branch')."' ")->row('refno');

            $data_trans = array(

                'TRANS_GUID' => $this->guid(),
                'TRANS_TYPE' => 'ISSUE MAIN'  ,
                'REF_NO' => addslashes($this->input->post('receipt_no')),
                'AccountNo' => $account_no,
                'CardNo' => $account_no,
                'CardNoNew' => '',
                'Name' => addslashes($this->input->post('Name')),
                'NameOnCard' => addslashes($this->input->post('NameOnCard')),
                'Address1' => addslashes($this->input->post('Address1')),
                'Address2' => addslashes($this->input->post('Address2')),
                'Address3' => addslashes($this->input->post('Address3')),
                'City' => addslashes($this->input->post('City')),
                'State' => addslashes($this->input->post('State')),
                'Postcode' => addslashes($this->input->post('Postcode')),
                'Email' => addslashes($this->input->post('Email')),
                'Phonehome' => addslashes($this->input->post('Phonehome')),
                'Phoneoffice' => addslashes($this->input->post('Phoneoffice')),
                'Phonemobile' => addslashes($this->input->post('Phonemobile')),
                'Fax' => addslashes($this->input->post('Fax')),
                'Issuedate' => addslashes($this->input->post('Issuedate')),
                'Expirydate' => addslashes($this->input->post('Expirydate')),
                'Cardtype' => addslashes($this->input->post('Cardtype')),
                'Title' => addslashes($this->input->post('Title')),
                'ICNo' => $icno,
                'OldICNo' => addslashes($this->input->post('old_ic_no')),
                'Occupation' => addslashes($this->input->post('Occupation')),
                'Employer' => addslashes($this->input->post('Employer')),
                'Birthdate' => addslashes($this->input->post('Birthdate')),
                'Principal' => addslashes($this->input->post('Principal')),
                'Active' => '1',
                'Nationality' => addslashes($this->input->post('national')),
                'Race' => addslashes($this->input->post('Race')),
                
                'Remarks' => addslashes($this->input->post('Remarks')),
                'Religion' => addslashes($this->input->post('Religion')),

                'Gender' => addslashes($this->input->post('Gender')),
                'PassportNo' => addslashes($this->input->post('passport_no')),
                
                'IssueStamp' => $this->datetime(),
                'UPDATED_BY' => $_SESSION['username'],
                'UPDATED_AT' => $this->datetime(),
                'LastStamp' => $this->datetime(),
                'created_at' => $this->datetime(),
                'created_by' => $_SESSION['username'],
                'NewForScript' => '1',
               
                'branch' => $this->input->post('branch'),
            );

                $data = array(
                    'AccountNo' => $account_no,
                    'CardNo' => $account_no,
                    'Nationality' => $this->input->post('national'), 
                    'ICNo' => $icno, 
                    'PassportNo' => $this->input->post('PassportNo'),
                    'Title' => $this->input->post('Title'), 
                    'Name' => addslashes($this->input->post('Name')), 
                    'NameOnCard' => addslashes($this->input->post('NameOnCard')), 
                    'Birthdate' => $this->input->post('Birthdate'), 
                    'Gender' => $this->input->post('Gender'),
                    'Race' => $this->input->post('Race'), 
                    'Religion' => $this->input->post('Religion'), 
                    'Status' => $this->input->post('Status'), 
                    'Occupation' => $this->input->post('Occupation'),
                    
                    'Email' => addslashes($this->input->post('Email')), 
                    'Phonemobile' => $this->input->post('Phonemobile'),
                    'Phoneoffice' => $this->input->post('Phoneoffice'), 
                    'Phonehome' => $this->input->post('Phonehome'), 
                    'Fax' => $this->input->post('Fax'),
                    'Address1' => addslashes($this->input->post('Address1')) , 
                    'Address2' => addslashes($this->input->post('Address2')), 
                    'Address3' => addslashes($this->input->post('Address3')), 
                    'Postcode' => $this->input->post('Postcode'),
                    'City' => $this->input->post('City'), 
                    'State' => $this->input->post('State'), 
                    
                    'Cardtype' => $this->input->post('Cardtype'),  
                    'Expirydate' => $Expirydate, 
                    'Issuedate' => $this->date(),

                    'IssueStamp' => $this->datetime(),
                    'UPDATED_BY' => $_SESSION['username'],
                    'UPDATED_AT' => $this->datetime(),
                    'LastStamp' => $this->datetime(),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION['username'],
                    'branch' => $this->input->post('branch'),

                    'Expirydate' => $this->input->post('Expirydate'),
                    'Active' => '1',
                    'NewForScript' => '1',
                    );

                $this->db->insert('mem_ii_trans' , $data_trans);
                $this->db->insert('member' , $data);

                //echo $this->db->last_query();die;
                if($this->db->affected_rows() > 0)
                {
                    $data = array(
                        'Trans_type' => 'ISSUE MAIN CARD',
                        'AccountNo' => $account_no,
                        'ReceiptNo' => addslashes($this->input->post('receipt_no')),
                        'expiry_date_before' => $this->input->post('Expirydate'),
                        'expiry_date_after' => $this->input->post('Expirydate'),
                        'field' => 'CardNo',
                        'value_to' => $account_no,
                        'created_at' => $this->datetime(),
                        'created_by' => $_SESSION['username'],
                        );
                    $this->db->insert('user_logs', $data);

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Insert Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/issue_main_card?created='.$account_no);
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">No Record Update<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/issue_main_card');
                }
            
        }
        else
        {
            redirect('login_c');
        }
    }

    public function receiptno_by_branch()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $branch = $this->input->post('branch');
            $field = $this->input->post('field');

            $preissue_card_method = $this->db->query("SELECT preissue_card_method FROM set_parameter")->row('preissue_card_method');

            if($preissue_card_method == 0)
            {
                $set_receipt_no = $this->db->query("SELECT $field FROM set_branch_parameter WHERE branch_id = '$branch' OR branch_code = '$branch'")->row($field);   
            }
            else
            {
                $set_receipt_no = $this->db->query("SELECT $field FROM set_branch_parameter WHERE branch_code = '$branch' ")->row($field);
            }
            //echo $this->db->last_query();die;
            echo $set_receipt_no;
        }
        else
        {
            redirect('login_c');
        }
        
    }

    public function print_details()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['AccountNo']))
            {
                $member = $this->db->query("SELECT * from member where AccountNo = '".$_REQUEST['AccountNo']."' AND CardNo = '".$_REQUEST['CardNo']."' ");
            }
            else
            {
                $member = $this->db->query("SELECT * from member where AccountNo = '".$_REQUEST['accountno']."' AND CardNo = '".$_REQUEST['cardno']."' ");
            }

            $check_preissue_card_method = $this->db->query("SELECT preissue_card_method FROM set_parameter")->row('preissue_card_method');
            if($check_preissue_card_method == '0')
            {
                $title = $this->db->query("SELECT branch_name FROM set_branch_parameter WHERE branch_code = '".$member->row('branch')."' OR branch_id = '".$member->row('branch')."'")->row('branch_name');
            }
            else
            {
                // $title = $this->db->query("SELECT CompanyName from backend.companyprofile")->row('CompanyName');
                $title = "";

                $result = $this->Member_Model->query_call('Transaction_c', 'print_details');

                if(isset($result['companyprofile'][0]['CompanyName']))
                {
                    $title = $result['companyprofile'][0]['CompanyName'];
                }
            }

            $data = array(
                'title' => $title,
                'Name' => $member->row('Name'),
                'Card' => $member->row('CardNo'),
                'IC' => $member->row('ICNo'),
                'Passport' => $member->row('PassportNo'),
                'DOB' => $member->row('Birthdate'),
                'Race' => $member->row('Race'),
                'Gender' => $member->row('Gender'),
                'Nationality' => $member->row('Nationality'),
                /*'Address' => $member->row('Address1'),*/
                'Address1' => $member->row('Address1'),
                'Address2' => $member->row('Address2'),
                'Address3' => $member->row('Address3'),
                'Postcode' => $member->row('Postcode'),
                'City' => $member->row('City'),
                'State' => $member->row('State'),
                'Mobile' => $member->row('Phonemobile'),
                'Email' => $member->row('Email'),
                'Activated' => $_SESSION['username'],
                'Store' => $member->row('branch'),
                't_c' => $this->db->query("SELECT registration_form_t_c from set_parameter")->row('registration_form_t_c'),
                'Date' => $this->db->query("SELECT LEFT('".$member->row('updated_at')."', 10) AS `date`")->row('date'),
                
                );
            $this->load->view('print_report_activation', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function print_card()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['CardNo']))//supcard
            {
                $get_account_data = $this->db->query("SELECT *, IF(PrincipalCardNo = 'LOSTCARD', 'Principal Card', 'Supplementary Card') AS card_type FROM `membersupcard` a WHERE a.`SupCardNo` = '".$_REQUEST['CardNo']."' AND a.`PrincipalCardNo` IN ('SUPCARD','LOSTCARD') ");
                $CardNo = $get_account_data->row('SupCardNo');
            }
            else
            {
                $get_account_data = $this->db->query("SELECT *, 'Principal Card' AS card_type FROM member a WHERE a.AccountNo = '".$_REQUEST['AccountNo']."'");
                $CardNo = $get_account_data->row('CardNo');
            }

            $get_setup = $this->db->query("SELECT * FROM set_parameter limit 1 ");

            $data = array(
                'card_no' => $CardNo,
                'name' => $get_account_data->row('NameOnCard'),
                'expiry_date' => $get_account_data->row('Expirydate'),
                'card_type' => $get_account_data->row('card_type'),
                'barcode_height' => $get_setup->row('card_barcode_heigth'),
                'barcode_width' => $get_setup->row('card_barcode_width'),
                'barcode_fontsize' => '12',
                'page_height' => $get_setup->row('card_page_heigth'),
                'page_width' => $get_setup->row('card_page_width'),
                'border_height' => $get_setup->row('card_border_heigth'),
                'border_width' => $get_setup->row('card_border_width'),
                'text_font' => $get_setup->row('text_font'),

                'content_message' => $get_setup->row('card_content_message'),
                'content_header' => $get_setup->row('card_content_header'),
            );

            $this->load->view('print_card', $data);
            //$this->load->view('taxinvoice_form', $data);

           /* $data = array(
                'record' => $this->db->query("SELECT * FROM member a WHERE a.AccountNo = 'ARAU18102200023'"),
            );
            $this->load->view('print_card', $data);*/
        }   
        else
        {
            redirect('login_c');
        }
    }

    public function activation()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['scan_card']))
            {
                if(isset($_REQUEST['CardNo']))
                {
                    $cardno = $_REQUEST['CardNo'];
                }
                else
                {
                    $cardno = $this->input->post('card_no');
                }
                $reason_field = '';
                $field = '';
                //for merchant only
                if($_SESSION['user_group'] == 'MERCHANT GROUP')
                {
                    $get_data = $this->db->query("SELECT * FROM member WHERE CardNo = (SELECT CardNo FROM member_merchantcard WHERE CardNo = '".$cardno."' AND merchant_id = '".$_SESSION['branch_code']."') ");
                }
                else //for outlet
                {
                    $get_data = $this->db->query("SELECT * FROM `member` WHERE CardNo = '".$cardno."' ");
                }

                if($get_data->num_rows() == 0)
                {
                    //for merchant checking only
                    if($_SESSION['user_group'] == 'MERCHANT GROUP')
                    {
                        $check_member_exist = $this->db->query("SELECT * FROM `member` WHERE CardNo = '".$cardno."' ");

                        if($check_member_exist->num_rows() > 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">You are not allowed to access this card!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/activation');
                        }
                        else
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Card No. not found!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/activation');
                        }
                    };

                    $get_data2 = $this->db->query("SELECT a.`SupCardNo` AS CardNo,a.*  FROM `membersupcard` a WHERE SupCardNo = '".$cardno."' ");
                    if($get_data2->num_rows() == 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Card Not Found!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/activation');
                    }
                    else
                    {
                        $_SESSION['card_type'] = 'sup_card';
                        $_SESSION['update_table'] = 'membersupcard';
                        redirect('Transaction_c/activation?exist_card='.$get_data2->row('CardNo').'&account='.$get_data2->row('AccountNo').'&ic_no='.$get_data2->row('ICNo').'&active='.$get_data2->row('Active').'&mobile_no='.$get_data2->row('Phonemobile').'&email='.$get_data2->row('email').'&nationality='.$get_data2->row('Nationality').'&army_no=');
                    }
                    
                }
                else
                {

                    // if($get_data->row('Active') == 1)
                    // {
                    //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card already active!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    //     redirect('Transaction_c/activation');
                    // }
                    // else
                    // {
                        $_SESSION['card_type'] = 'primary_card';
                        $_SESSION['update_table'] = 'member';
                        redirect('Transaction_c/activation?exist_card='.$get_data->row('CardNo').'&account='.$get_data->row('AccountNo').'&ic_no='.$get_data->row('ICNo').'&active='.$get_data->row('Active').'&mobile_no='.$get_data->row('Phonemobile').'&email='.$get_data->row('Email').'&nationality='.$get_data->row('Nationality').'&army_no='.$get_data->row('ICNo'));
                    // }
                }

                $result = 'hidden';

            }
            elseif(isset($_REQUEST['exist_card']))
            {
                $check_for_merchant = $this->db->query("SELECT * FROM member_merchantcard WHERE CardNo = '".$_REQUEST['exist_card']."' ");
                $get_account_data = $this->db->query("SELECT * FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_REQUEST['account']."' ");

                if($get_account_data->row('acc_status') == 'TERMINATE' || $get_account_data->row('acc_status') == 'SUSPEND')
                {
                     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card Has Been '.$get_account_data->row('acc_status').'. Unable to activate.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                       redirect('Transaction_c/activation');
                }

                // $_REQUEST['active'] == 0 || 
                if($get_account_data->row('Issuedate') == $get_account_data->row('Expirydate') 
                    && $get_account_data->row('Name') == 'NEW' 
                    || $get_account_data->row('Active') == 0 
                    || $get_account_data->row('Expirydate') == '3000-12-31')
                // if not active yet
                {
                    $years = '';
                    $reason_field = 'ACTIVATION';
                    $field = 'receipt_activate';
                    $button = 'Activate';
                    $form = site_url('Transaction_c/save_activation');

                    if(!in_array('AMC', $_SESSION['module_code']) && $check_for_merchant->num_rows() > 0 && $_SESSION['user_group'] <> 'MERCHANT GROUP')
                    {
                       $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card Belong To  Merchant. Unable to activate.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                       redirect('Transaction_c/activation');
                    }
                }
                else
                {
                    /*$years = $this->db->query('SELECT expiry_date_in_year FROM set_parameter')->row('expiry_date_in_year');
                    $reason_field = 'RENEWAL';
                    $field = 'receipt_renew';
                    $button = 'Renew Card';
                    $form = site_url('Transaction_c/save_renew');*/

                    /*if($_SESSION['user_group'] == 'MERCHANT GROUP')
                    {*/
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card has been actived.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/activation');
                    /*}*/
                }
                $_SESSION['old_ic_no'] = $get_account_data->row('OldICNo');
                $_SESSION['passport_no'] = $get_account_data->row('PassportNo');

                $_SESSION['mobile_no'] = $_REQUEST['mobile_no'];
                $_SESSION['active'] = $_REQUEST['active'];
                $_SESSION['card_no'] = $_REQUEST['exist_card'];
                $_SESSION['account_no'] = $_REQUEST['account'];
                $_SESSION['ic_no'] = $_REQUEST['ic_no'];
                $_SESSION['army_no'] = $_REQUEST['army_no'];
                $_SESSION['email'] = $_REQUEST['email'];
                $_SESSION['hidden_result'] = '';
                $_SESSION['nationality'] = $_REQUEST['nationality'];
            }
            else
            {  
                $years = '';
                $reason_field = '';
                $field = ''; 
                $_SESSION['old_ic_no'] = '';
                $_SESSION['passport_no'] = '';

                $_SESSION['update_table'] = 'member';
                $button = 'Activate';
                $form = '';
                $_SESSION['mobile_no'] = '';
                $_SESSION['active'] = '';
                $_SESSION['card_no'] = '';
                $_SESSION['account_no'] = '';
                $_SESSION['ic_no'] = '';
                $_SESSION['army_no'] = '';
                $_SESSION['email'] = '';
                $_SESSION['hidden_result'] = 'hidden';
                $_SESSION['nationality'] = '';
            }

            $get_account_data = $this->db->query("SELECT * FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."' ");

            if($get_account_data->row('Issuedate') == $get_account_data->row('Expirydate') && $get_account_data->row('Name') == 'NEW' || $get_account_data->row('Active') == 0 || $get_account_data->row('Expirydate') == '3000-12-31')// if new card need to activate
            {
                // $get_preset_expiry_date = $this->db->query("SELECT (SELECT Expirydate FROM member WHERE AccountNo = '".$_SESSION['account_no']."')+INTERVAL (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
                // script with interval based on setting
                // $get_preset_expiry_date = $this->db->query("SELECT Expirydate FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."'")->row('Expirydate');

                // $get_preset_expiry_date = $this->db->query("SELECT (SELECT Expirydate FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."')+INTERVAL 
                //     (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
                // not capture currdate

                $get_preset_expiry_date = $this->db->query("SELECT CURDATE()+INTERVAL 
                    (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
                
                /*$branch = $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC");*/
                // $branch = $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name, c.receipt_activate FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY b.branch_code ASC");

                $branch = $this->branch_with_receipt();
            }
            else// if card need to renew
            {
                $get_setting = $this->db->query("SELECT expiry_date_type from set_parameter")->row('expiry_date_type');
                if($get_setting == 1)// if setup equal to 1 new expiry date will follow the logic
                {
                    $today = $this->db->query("SELECT CURDATE() AS today ")->row('today');
                    if($get_account_data->row('Expirydate') > $today)// if expired date more then current date
                    {
                        $get_preset_expiry_date = $get_account_data->row('Expirydate');
                    }
                    else
                    {
                        $get_preset_expiry_date = $today; 
                    }
                };

                if($get_setting == 2)// if setup equal to 2 new expiry date will old expiry date format.
                {
                    $get_preset_expiry_date = $get_account_data->row('Expirydate');
                };
                
                // $branch = $this->db->query("SELECT branch as branch_code, branch as branch_name  FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."' ");
                $branch = $this->db->query("SELECT branch as branch_code, branch as branch_name  FROM member WHERE AccountNo = '".$_SESSION['account_no']."' ")->result_array();
            }

            if(isset($_REQUEST['print']))
            {
                $bodyload = 'printdetails()';
                $AccountNo = $_REQUEST['AccountNo'];
                $CardNo = $_REQUEST['CardNo'];
            }
            else
            {
                $bodyload = '';
                $AccountNo = '';
                $CardNo = '';
            }
            /*if($branch->num_rows() == 1)
            {
                $need_receipt_no = $this->db->query("SELECT set_receipt_no FROM set_branch_newcard where branch_code = '".$branch->row('branch_code')."' ")->row('set_receipt_no'),
            }
            else
            {
                $need_receipt_no = '';
            }*/

            $data = array(

                /*'need_receipt_no' => $need_receipt_no,*/
                'actual_expirydate' => $get_account_data->row('Expirydate'),
                'direction' => site_url('Transaction_c/activation'),
                'bodyload' => $bodyload,
                'button' => $button,
                'form' => $form,
                'branch' => $branch,
                'expiry_date' => $get_preset_expiry_date,
                'remarks' => $this->db->query("SELECT * FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."' ")->row('Remarks'),

                'select_nationality' => $this->db->query("SELECT * FROM set_nationality"),
                'reason' => $this->db->query("SELECT * FROM set_reason where type = '".$reason_field."' "),
                'field' => $field,
                'years' => $years,
                'check_receipt_itemcode' => $this->db->query("SELECT * FROM set_parameter ")->row('check_receipt_itemcode'),
                'AccountNo' => $AccountNo,
                'CardNo' => $CardNo,
                'card_verify' => $this->check_parameter()->row('card_verify'),
            );
            //echo $this->db->last_query();die;

            $this->template->load('template' , 'activation', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_activation()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $_SESSION['branch_details'] = $this->input->post('branch');
            $_SESSION['accountno_dtl'] = $_SESSION['account_no'];
            $_SESSION['cardno_dtl'] = $_SESSION['card_no'];
            $now_date = $this->db->query("SELECT NOW() as datetime")->row('datetime');

            if($this->input->post('branch') == '' || $this->input->post('branch') == '-- Select a branch --' || $this->input->post('branch') == ' -- Select a branch -- ')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please fill in branch!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
            };

            if(strpos($this->input->post('ic_no'), '-') !== false) //check ic with '-'
            {
                $icno = $this->input->post('ic_no');
                $ic_input = $this->input->post('ic_no');
            }
            else
            {
                if((strtoupper($this->input->post('national')) == 'MALAYSIAN' || strtoupper($this->input->post('national')) == 'MALAYSIA') && ($this->input->post('ic_no') == ''))
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please press Read MyKAD to fill in IC no. again!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                };

                $ic_input = $this->input->post('ic_no');
                $icno = $this->db->query("SELECT CONCAT(LEFT('$ic_input', 6), '-', SUBSTRING('$ic_input', 7, 2), '-', RIGHT('$ic_input', 4)) AS icno ")->row('icno');
            }
            
            $curyear = $this->db->query("SELECT DATE_FORMAT(CURDATE(), '%y') AS `curyear` ")->row('curyear');
            $icyear = $this->db->query("SELECT LEFT('$icno', 2) AS `year` ")->row('year');

            //$get_ic_year = substr($icno, 0, 2);
            if($this->input->post('army_no') == '' && $this->input->post('ic_no') != '')
            {
                if($icyear >= '00' && $icyear <= $curyear)
                {
                    $birthdate = $this->db->query("SELECT CONCAT('20', LEFT('$ic_input', 2), '-', SUBSTRING('$ic_input', 3, 2), '-', SUBSTRING('$ic_input', 5, 2)) AS birthdate ")->row('birthdate');
                }
                else
                {
                    $birthdate = $this->db->query("SELECT CONCAT('19', LEFT('$ic_input', 2), '-', SUBSTRING('$ic_input', 3, 2), '-', SUBSTRING('$ic_input', 5, 2)) AS birthdate ")->row('birthdate');
                }
            }
            elseif($this->input->post('army_no') == '' && $this->input->post('ic_no') == '' && $this->input->post('passport_no') != '')
            {
                $birthdate = '0000-00-00';

                $check_passport = $this->db->query("SELECT PassportNo FROM member WHERE PassportNo = '".$this->input->post('passport_no')."' ");

                if($check_passport->num_rows() > 0 && $this->input->post('passport_no') <> '')
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Passport no. already exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    
                    if($this->check_parameter()->row('terminate_method') == '1')
                    {
                        $acc_no = $this->db->query("SELECT AccountNo FROM `member` WHERE PassportNo = '".$this->input->post('passport_no')."' ")->row('AccountNo');
                        $data = array(
                            'button' => 'Activate',
                            'bodyload' => '',
                            'account' => $acc_no,
                            'ic_no' => $this->input->post('passport_no'),
                            'active' => $_SESSION['active'],
                            'mobile_no' => $this->input->post('mobile_no'),
                            'email' => $this->input->post('email'),
                            'nationality' => $this->input->post('national'),
                            'army_no' => $this->input->post('army_no'),
                            'branch' => $this->input->post('branch'),
                        );             
                        $this->template->load('template' , 'activation_terminate' , $data);
                        
                    }
                    else
                    {    
                    redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                    }
                };
            }
            elseif($this->input->post('army_no') != '' && $this->input->post('ic_no') == '' && $this->input->post('passport_no') == '')
            {
                $birthdate = '0000-00-00';

                $check_army_no = $this->db->query("SELECT ICNo FROM member WHERE ICNo = '".$this->input->post('army_no')."' ");

                if($check_army_no->num_rows() > 0 && $this->input->post('army_no') <> '')
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Army card no. already exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                };
            }

            /*$birthdate = $this->db->query("SELECT CONCAT('19', LEFT('$ic_input', 2), '-', SUBSTRING('$ic_input', 3, 2), '-', SUBSTRING('$ic_input', 5, 2)) AS birthdate ")->row('birthdate');*/
            $check_email = $this->db->query("SELECT Email FROM member WHERE Email = '".$this->input->post('email')."' ");

            if($check_email->num_rows() > 0 && $this->input->post('email') <> '')
            {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');

                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Email already exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
            } 

            if($this->check_parameter()->row('card_verify') == '1')
            {
                if($this->input->post('confirm_cardno') != $_SESSION['card_no'] || $this->input->post('confirm_password') != $_SESSION['card_no'])
                {
                    ini_set('memory_limit', '-1');
                    ini_set('max_execution_time', 0); 
                    ini_set('memory_limit','2048M');

                    $this->session->set_flashdata('message_confirm', '<div class="alert alert-warning text-center" style="font-size: 16px">Card No Not Match!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                }
            }   

            $check_month_ic_no = $this->db->query("SELECT MID('".$this->input->post('ic_no')."', 3, 2) as month")->row('month');
            $check_day_ic_no = $this->db->query("SELECT MID('".$this->input->post('ic_no')."', 5, 2) as day")->row('day');

            if($this->input->post('army_no') == '' && $this->input->post('ic_no') != '')
            {
                if(strpos($this->input->post('ic_no'), '_') !== false || $check_month_ic_no > 12 || $check_day_ic_no > 31 || strlen($this->input->post('ic_no')) != '12')
                {
                    ini_set('memory_limit', '-1');
                    ini_set('max_execution_time', 0); 
                    ini_set('memory_limit','2048M');

                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid IC No!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                };
            };

            $check_ic_no = $this->db->query("SELECT ICNo FROM member WHERE ICNo = '".$icno."' ");

            if(($check_ic_no->num_rows() > 0) && (strtoupper($this->input->post('national')) == 'MALAYSIAN' || strtoupper($this->input->post('national')) == 'MALAYSIA'))
            {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">IC No already exist!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                if($this->check_parameter()->row('terminate_method') == '1')
                {
                    $acc_no = $this->db->query("SELECT AccountNo FROM member WHERE ICNo = '".$icno."' ")->row('AccountNo');
                    $data = array(
                        'button' => 'Activate',
                        'bodyload' => '',
                        'account' => $acc_no,
                        'ic_no' => $icno,
                        'active' => $_SESSION['active'],
                        'mobile_no' => $this->input->post('mobile_no'),
                        'email' => $this->input->post('email'),
                        'nationality' => $this->input->post('national'),
                        'army_no' => $this->input->post('army_no'),
                        'branch' => $this->input->post('branch'),
                    );             
                    $this->template->load('template' , 'activation_terminate' , $data);
                }
                else
                {
                    redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='. $this->input->post('ic_no').'&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                }
            }
            else
            {
                if($this->input->post('Gender') == 'L')
                {
                    $Gender = 'MALE';
                }
                elseif($this->input->post('Gender') == 'P')
                {
                    $Gender = 'FEMALE';
                }
                else
                {
                    $Gender = '';
                }

                if($_SESSION['user_group'] == 'MERCHANT GROUP')
                {
                    $branch_group = 'HQ';
                }
                else
                {
                    $branch_group = addslashes($this->input->post('branch'));
                }

                /*$need_receipt_no = $this->db->query("SELECT receipt_no_activerenew FROM `set_parameter`;")->row('receipt_no_activerenew');*/
                $need_receipt_no = $this->db->query("SELECT receipt_activate FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch')."' ")->row('receipt_activate');
                if($need_receipt_no == 1)
                {
                    if($this->input->post('receipt_no') == '')
                    {
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', 0); 
                        ini_set('memory_limit','2048M');

                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please fill in receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                    };

                    if(!in_array('BPRN', $_SESSION['module_code']))// if dont have authorization to by pass
                    {
                        $_SESSION['receipt_no'] = $this->input->post('receipt_no');

                        $check_check_receipt_itemcode = $this->db->query("SELECT a.`check_receipt_itemcode` FROM set_parameter a ")->row('check_receipt_itemcode');

                        if($check_check_receipt_itemcode == 0) //check amount (all outlets)
                        {
                            $check_receipt_setup = $this->db->query("SELECT receipt_no_amount_active FROM `set_parameter` ")->row('receipt_no_amount_active');
                        }
                        elseif($check_check_receipt_itemcode == 2) //check amount (based outlets)
                        {
                            $check_receipt_setup = $this->db->query("SELECT amount_activate FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch')."' ")->row('amount_activate');
                        }
                        else
                        {
                            $check_receipt_setup = '0';
                        }
                        
                        $check_itemcode = $this->db->query("SELECT * FROM set_itemcode WHERE name = 'activecard' ");

                        // if($this->check_parameter()->row('check_receipt_itemcode') == 1)
                        // {
                        //     $check_receipt = $this->Trans_Model->check_receipt_no_child($this->input->post('receipt_no'));
                        //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_child($this->input->post('receipt_no'));
                        // }
                        // else
                        // {
                        //     $check_receipt = $this->Trans_Model->check_receipt_no_main($this->input->post('receipt_no'));
                        //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_main($this->input->post('receipt_no'));
                        // }
                        //echo $this->db->last_query();die;

                        // $check_exist_receipt = $this->db->query("SELECT * FROM frontend.posmain WHERE RefNo = '".$this->input->post('receipt_no')."'");

                        $data = array(
                            'refno' => $this->input->post('receipt_no'),
                            'branch' => $this->input->post('branch'),
                        );

                        $check_receipt = $check_receipt_void = array();
                        $result = $this->Member_Model->query_call('Transaction_c', 'save_activation', $data);

                        if(isset($result['check_receipt']))
                        {
                            $check_receipt = $result['check_receipt'][0];
                        }

                        if(isset($result['check_receipt_void']))
                        {
                            $check_receipt_void = $result['check_receipt_void'][0];
                        }

                        // if($check_exist_receipt->num_rows() == 0)//if not found
                        // {
                        //     $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt Not Found !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        //     redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                        // }
                        // elseif($check_receipt_void->num_rows() == 1)//if receipt void
                        // {
                        //     ini_set('memory_limit', '-1');
                        //     ini_set('max_execution_time', 0); 
                        //     ini_set('memory_limit','2048M');

                        //     $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt Already Voided !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        //     redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                        // }
                        
                        if($result['message'] != 'success')
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                        }

                        // else
                        // {
                        //     $check_receipt_day = $this->db->query("SELECT check_receipt_day FROM set_parameter ")->row('check_receipt_day');
                        //     $get_days = $this->db->query("SELECT TIMESTAMPDIFF(DAY, '".$check_receipt['BizDate']."', CURDATE()) AS day ")->row('day');

                        //     if(($check_check_receipt_itemcode == 0 || $check_check_receipt_itemcode == 2) && $check_receipt['BillAmt'] < $check_receipt_setup)// if setup not check itemcode and bill amount less than tamount setup
                        //     {
                        //         ini_set('memory_limit', '-1');
                        //         ini_set('max_execution_time', 0); 
                        //         ini_set('memory_limit','2048M');

                        //         $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Receipt Amount Not Enough !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        //         redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                        //     }
                        //     /*elseif($check_receipt->row('BizDate') <> $this->db->query("SELECT CURDATE() AS curr_date")->row('curr_date'))
                        //         {*/
                        //     elseif($get_days > $check_receipt_day)
                        //     {
                        //         ini_set('memory_limit', '-1');
                        //         ini_set('max_execution_time', 0); 
                        //         ini_set('memory_limit','2048M');

                        //         $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid receipt date. !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        //          redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                        //     }
                        //     elseif($check_check_receipt_itemcode == 1)
                        //     {
                        //         $check_receipt = $this->db->query("SELECT b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND b.Refno = '".$this->input->post('receipt_no')."' AND b.itemcode = '".$check_itemcode->row('itemcode')."' ");
                        //         if($check_receipt->num_rows() == 0)//if not found
                        //         {
                        //             ini_set('memory_limit', '-1');
                        //             ini_set('max_execution_time', 0); 
                        //             ini_set('memory_limit','2048M');

                        //             $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for activation card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        //             redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                        //         };
                        //     }
                        // }

                        $receipt_no = $_SESSION['receipt_no'];
                        if($this->check_exist_receipt_no($receipt_no)->num_rows() > 0)
                        {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', 0); 
                            ini_set('memory_limit','2048M');

                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt No Already Exist In Record !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                        };

                        $get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$this->input->post('years')."' YEAR AS Expirydate")->row('Expirydate');

                        $account_no = $_SESSION['account_no'];

                        if($this->input->post('army_no') != '')
                        {
                            $icno = $this->input->post('army_no');
                        };

                        //ori_log
                        $ori = $this->db->query("SELECT branch_group, branch, Nationality, OldICNo, PassportNo, ICNo, CardNo, Expirydate, Remarks, Phonemobile, Name, NameOnCard, Birthdate, Gender, Race, Religion, Address1, Postcode, City, State, Email from member where AccountNo = '$account_no' ");
                        $ori_branch_group = $ori->row('branch_group');
                        $ori_branch = $ori->row('branch');
                        $ori_Nationality = $ori->row('Nationality');
                        $ori_OldICNo = $ori->row('OldICNo');
                        $ori_PassportNo = $ori->row('PassportNo');
                        $ori_ICNo = $ori->row('ICNo');
                        $ori_CardNo = $ori->row('CardNo');
                        $ori_Expirydate = $ori->row('Expirydate');
                        $ori_Remarks = $ori->row('Remarks');
                        $ori_Phonemobile = $ori->row('Phonemobile');
                        $ori_Name = $ori->row('Name');
                        $ori_NameOnCard = $ori->row('NameOnCard');
                        $ori_Birthdate = $ori->row('Birthdate');
                        $ori_Gender = $ori->row('Gender');
                        $ori_Race = $ori->row('Race');
                        $ori_Religion = $ori->row('Religion');
                        $ori_Address1 = $ori->row('Address1');
                        $ori_Postcode = $ori->row('Postcode');
                        $ori_City = $ori->row('City');
                        $ori_State = $ori->row('State');
                        $ori_Email = $ori->row('Email');
                        $ori_Reason = '';
                        /*$ori_Active = $ori->row('Active');
                        $ori_Issuedate = $ori->row('Issuedate');
                        $ori_NewForScript = $ori->row('NewForScript');*/
                        //ori_log

                        $data = array(
                            'branch_group' => $branch_group,
                            'branch' => addslashes($this->input->post('branch')),
                            'Nationality' => addslashes($this->input->post('national')),
                            'OldICNo' => addslashes($this->input->post('old_ic_no')),
                            'PassportNo' => addslashes($this->input->post('passport_no')),
                            'ICNo' => $icno,
                            'CardNo' => addslashes($this->input->post('card_no')),
                            'Expirydate' => addslashes($get_new_expiry_date),
                            'Remarks' => addslashes($this->input->post('remarks')),
                            'Phonemobile' => addslashes($this->input->post('mobile_no')),
                            'Active' => '1',
                            'Issuedate' => $this->db->query("SELECT CURDATE() as curdate")->row('curdate'),
                            'NewForScript' => 1,

                            // close by faizul 4/10/2018 due to wrong purpose of activation in doremon
                            /*'Name' => addslashes($this->input->post('Name')),
                            'NameOnCard' => addslashes($this->input->post('NameOnCard')),
                            'Birthdate' => $birthdate,
                            'Gender' => $Gender,
                            'Race' => addslashes($this->input->post('Race')),
                            'Religion' => addslashes($this->input->post('Religion')),
                            'Address1' => addslashes($this->input->post('add1')),
                            'Address2' => addslashes($this->input->post('add2')),
                            'Address3' => addslashes($this->input->post('add3')),
                            'Postcode' => addslashes($this->input->post('Postcode')),
                            'City' => addslashes($this->input->post('City')),
                            'State' => addslashes($this->input->post('State')),*/
                            'Email' => addslashes($this->input->post('email')),
                            'updated_at' => $now_date,
                            'acc_status' => 'ACTIVE'
                        );
                        $this->db->where('AccountNo', $account_no);
                        $this->db->update('member', $data);

                        $date = $this->db->query("SELECT NOW() as curdate")->row('curdate');

                        //upd_log
                        $upd = $this->db->query("SELECT branch_group, branch, Nationality, OldICNo, PassportNo, ICNo, CardNo, Expirydate, Remarks, Phonemobile, Name, NameOnCard, Birthdate, Gender, Race, Religion, Address1, Postcode, City, State, Email from member where AccountNo = '$account_no' ");
                        $upd_branch_group = $upd->row('branch_group');
                        $upd_branch = $upd->row('branch');
                        $upd_Nationality = $upd->row('Nationality');
                        $upd_OldICNo = $upd->row('OldICNo');
                        $upd_PassportNo = $upd->row('PassportNo');
                        $upd_ICNo = $upd->row('ICNo');
                        $upd_CardNo = $upd->row('CardNo');
                        $upd_Expirydate = $upd->row('Expirydate');
                        $upd_Remarks = $upd->row('Remarks');
                        $upd_Phonemobile = $upd->row('Phonemobile');
                        $upd_Name = $upd->row('Name');
                        $upd_NameOnCard = $upd->row('NameOnCard');
                        $upd_Birthdate = $upd->row('Birthdate');
                        $upd_Gender = $upd->row('Gender');
                        $upd_Race = $upd->row('Race');
                        $upd_Religion = $upd->row('Religion');
                        $upd_Address1 = $upd->row('Address1');
                        $upd_Postcode = $upd->row('Postcode');
                        $upd_City = $upd->row('City');
                        $upd_State = $upd->row('State');
                        $upd_Email = $upd->row('Email');
                        $upd_Reason = $this->input->post('reason');
                        //$upd_Active = $upd->row('Active');
                        //$upd_Issuedate = $upd->row('Issuedate');
                        //$upd_NewForScript = $upd->row('NewForScript');
                        //upd_log

                        $field = array("branch_group", "branch", "Nationality", "OldICNo", "PassportNo", "ICNo", "CardNo", "Expirydate", "Remarks", "Phonemobile", "Name", "NameOnCard", "Birthdate", "Gender", "Race", "Religion", "Address1", "Postcode", "City", "State", "Reason", "Email");

                        for ($x = 0; $x <= 21; $x++) 
                        {
                            switch (${'ori_'.$field[$x]}) 
                            {
                                case ${'upd_'.$field[$x]}:
                                    break;
                                default:
                                    $data = array(
                                        'Trans_type' => 'ACTIVATION',
                                        'AccountNo' => $_SESSION['account_no'],
                                        'ReceiptNo' => $_SESSION['receipt_no'],
                                        'field' => $field[$x],
                                        'value_from' => ${'ori_'.$field[$x]},
                                        'value_to' => ${'upd_'.$field[$x]},
                                        'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                                        'expiry_date_after' => addslashes($get_new_expiry_date),
                                        'created_at' => $date,
                                        'created_by' => $_SESSION['username'],
                                        );
                                    $this->db->insert('user_logs', $data);
                            }
                        }
                        
                        if($this->db->affected_rows() > 0)
                        {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', 0); 
                            ini_set('memory_limit','2048M');

                            if($this->input->post('button') == 'edit')
                            {
                                redirect('Main_c/full_details?AccountNo=' .$_SESSION['account_no']);
                            }
                            else
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/activation?print&AccountNo=' .$_SESSION['account_no']. '&CardNo=' .$_SESSION['card_no']);
                            }
                        }
                        else
                        {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', 0); 
                            ini_set('memory_limit','2048M');

                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Failed ! !<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/activation');
                        }
                    }
                    else
                    {
                        if($this->input->post('receipt_no') != '-')
                        {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', 0); 
                            ini_set('memory_limit','2048M');

                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please use "-" for bypass receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no=&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no'));
                        };

                        $_SESSION['receipt_no'] = $this->input->post('receipt_no');
                        $get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$this->input->post('years')."' YEAR AS Expirydate")->row('Expirydate');

                        $account_no = $_SESSION['account_no'];

                        if($this->input->post('army_no') != '')
                        {
                            $icno = $this->input->post('army_no');
                        };

                        //ori_log
                        $ori = $this->db->query("SELECT branch_group, branch, Nationality, OldICNo, PassportNo, ICNo, CardNo, Expirydate, Remarks, Phonemobile, Name, NameOnCard, Birthdate, Gender, Race, Religion, Address1, Postcode, City, State, Email from member where AccountNo = '$account_no' ");
                        $ori_branch_group = $ori->row('branch_group');
                        $ori_branch = $ori->row('branch');
                        $ori_Nationality = $ori->row('Nationality');
                        $ori_OldICNo = $ori->row('OldICNo');
                        $ori_PassportNo = $ori->row('PassportNo');
                        $ori_ICNo = $ori->row('ICNo');
                        $ori_CardNo = $ori->row('CardNo');
                        $ori_Expirydate = $ori->row('Expirydate');
                        $ori_Remarks = $ori->row('Remarks');
                        $ori_Phonemobile = $ori->row('Phonemobile');
                        $ori_Name = $ori->row('Name');
                        $ori_NameOnCard = $ori->row('NameOnCard');
                        $ori_Birthdate = $ori->row('Birthdate');
                        $ori_Gender = $ori->row('Gender');
                        $ori_Race = $ori->row('Race');
                        $ori_Religion = $ori->row('Religion');
                        $ori_Address1 = $ori->row('Address1');
                        $ori_Postcode = $ori->row('Postcode');
                        $ori_City = $ori->row('City');
                        $ori_State = $ori->row('State');
                        $ori_Email = $ori->row('email');
                        $ori_Reason = '';
                        /*$ori_Active = $ori->row('Active');
                        $ori_Issuedate = $ori->row('Issuedate');
                        $ori_NewForScript = $ori->row('NewForScript');*/
                        //ori_log

                        $data = array(
                            'branch_group' => $branch_group,
                            'branch' => addslashes($this->input->post('branch')),
                            'Nationality' => addslashes($this->input->post('national')),
                            'OldICNo' => addslashes($this->input->post('old_ic_no')),
                            'PassportNo' => addslashes($this->input->post('passport_no')),
                            'ICNo' => $icno,
                            //'CardNo' => addslashes($this->input->post('card_no')),
                            'Expirydate' => addslashes($get_new_expiry_date),
                            'Remarks' => addslashes($this->input->post('remarks')),
                            'Phonemobile' => addslashes($this->input->post('mobile_no')),
                            'Active' => '1',
                            'Issuedate' => $this->db->query("SELECT CURDATE() as curdate")->row('curdate'),
                            'NewForScript' => 1,

                            'Name' => addslashes($this->input->post('Name')),
                            'NameOnCard' => addslashes($this->input->post('NameOnCard')),
                            'Birthdate' => $birthdate,
                            'Gender' => $Gender,
                            'Race' => addslashes($this->input->post('Race')),
                            'Religion' => addslashes($this->input->post('Religion')),
                            'Address1' => addslashes($this->input->post('add1')),
                            'Address2' => addslashes($this->input->post('add2')),
                            'Address3' => addslashes($this->input->post('add3')),
                            'Postcode' => addslashes($this->input->post('Postcode')),
                            'City' => addslashes($this->input->post('City')),
                            'State' => addslashes($this->input->post('State')),
                            'Email' => addslashes($this->input->post('email')),
                            'updated_at' => $now_date,
                            'acc_status' => 'ACTIVE'

                        );
                        $this->db->where('AccountNo', $account_no);
                        $this->db->update('member', $data);

                        $date = $this->db->query("SELECT NOW() as curdate")->row('curdate');

                        //upd_log
                        $upd = $this->db->query("SELECT branch_group, branch, Nationality, OldICNo, PassportNo, ICNo, CardNo, Expirydate, Remarks, Phonemobile, Name, NameOnCard, Birthdate, Gender, Race, Religion, Address1, Postcode, City, State, Email from member where AccountNo = '$account_no' ");
                        $upd_branch_group = $upd->row('branch_group');
                        $upd_branch = $upd->row('branch');
                        $upd_Nationality = $upd->row('Nationality');
                        $upd_OldICNo = $upd->row('OldICNo');
                        $upd_PassportNo = $upd->row('PassportNo');
                        $upd_ICNo = $upd->row('ICNo');
                        $upd_CardNo = $upd->row('CardNo');
                        $upd_Expirydate = $upd->row('Expirydate');
                        $upd_Remarks = $upd->row('Remarks');
                        $upd_Phonemobile = $upd->row('Phonemobile');
                        $upd_Name = $upd->row('Name');
                        $upd_NameOnCard = $upd->row('NameOnCard');
                        $upd_Birthdate = $upd->row('Birthdate');
                        $upd_Gender = $upd->row('Gender');
                        $upd_Race = $upd->row('Race');
                        $upd_Religion = $upd->row('Religion');
                        $upd_Address1 = $upd->row('Address1');
                        $upd_Postcode = $upd->row('Postcode');
                        $upd_City = $upd->row('City');
                        $upd_State = $upd->row('State');
                        $upd_Email = $upd->row('Email');
                        $upd_Reason = $this->input->post('reason');
                        //$upd_Active = $upd->row('Active');
                        //$upd_Issuedate = $upd->row('Issuedate');
                        //$upd_NewForScript = $upd->row('NewForScript');
                        //upd_log

                        $field = array("branch_group", "branch", "Nationality", "OldICNo", "PassportNo", "ICNo", "CardNo", "Expirydate", "Remarks", "Phonemobile", "Name", "NameOnCard", "Birthdate", "Gender", "Race", "Religion", "Address1", "Postcode", "City", "State", "Reason", "Email");

                        for ($x = 0; $x <= 21; $x++) 
                        {
                            switch (${'ori_'.$field[$x]}) 
                            {
                                case ${'upd_'.$field[$x]}:
                                    break;
                                default:
                                    $data = array(
                                        'Trans_type' => 'ACTIVATION',
                                        'AccountNo' => $_SESSION['account_no'],
                                        'ReceiptNo' => $_SESSION['receipt_no'],
                                        'field' => $field[$x],
                                        'value_from' => ${'ori_'.$field[$x]},
                                        'value_to' => ${'upd_'.$field[$x]},
                                        'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                                        'expiry_date_after' => addslashes($get_new_expiry_date),
                                        'created_at' => $date,
                                        'created_by' => $_SESSION['username'],
                                        );
                                    $this->db->insert('user_logs', $data);
                            }
                        }
                        
                        if($this->db->affected_rows() > 0)
                        {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', 0); 
                            ini_set('memory_limit','2048M');

                            if($this->input->post('button') == 'edit')
                            {
                                redirect('Main_c/full_details?AccountNo=' .$_SESSION['account_no']);
                            }
                            else
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/activation?print&AccountNo=' .$_SESSION['account_no']. '&CardNo=' .$_SESSION['card_no']);
                            }
                        }
                        else
                        {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', 0); 
                            ini_set('memory_limit','2048M');

                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Failed ! !<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/activation');
                        }
                    }
                    
                }
                else
                {
                    $_SESSION['receipt_no'] = '';
                    $get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$this->input->post('years')."' YEAR AS Expirydate")->row('Expirydate');
                    
                    $account_no = $_SESSION['account_no'];

                    if($this->input->post('army_no') != '')
                    {
                        $icno = $this->input->post('army_no');
                    };

                    //ori_log
                    $ori = $this->db->query("SELECT branch_group, branch, Nationality, OldICNo, PassportNo, ICNo, CardNo, Expirydate, Remarks, Phonemobile, Name, NameOnCard, Birthdate, Gender, Race, Religion, Address1, Postcode, City, State, Email from member where AccountNo = '$account_no' ");
                    $ori_branch_group = $ori->row('branch_group');
                    $ori_branch = $ori->row('branch');
                    $ori_Nationality = $ori->row('Nationality');
                    $ori_OldICNo = $ori->row('OldICNo');
                    $ori_PassportNo = $ori->row('PassportNo');
                    $ori_ICNo = $ori->row('ICNo');
                    $ori_CardNo = $ori->row('CardNo');
                    $ori_Expirydate = $ori->row('Expirydate');
                    $ori_Remarks = $ori->row('Remarks');
                    $ori_Phonemobile = $ori->row('Phonemobile');
                    $ori_Name = $ori->row('Name');
                    $ori_NameOnCard = $ori->row('NameOnCard');
                    $ori_Birthdate = $ori->row('Birthdate');
                    $ori_Gender = $ori->row('Gender');
                    $ori_Race = $ori->row('Race');
                    $ori_Religion = $ori->row('Religion');
                    $ori_Address1 = $ori->row('Address1');
                    $ori_Postcode = $ori->row('Postcode');
                    $ori_City = $ori->row('City');
                    $ori_State = $ori->row('State');
                    $ori_Email = $ori->row('Email');
                    $ori_Reason = '';
                    /*$ori_Active = $ori->row('Active');
                    $ori_Issuedate = $ori->row('Issuedate');
                    $ori_NewForScript = $ori->row('NewForScript');*/
                    //ori_log

                    $data = array(
                        'branch_group' => $branch_group,
                        'branch' => addslashes($this->input->post('branch')),
                        'Nationality' => addslashes($this->input->post('national')),
                        'OldICNo' => addslashes($this->input->post('old_ic_no')),
                        'PassportNo' => addslashes($this->input->post('passport_no')),
                        'ICNo' => $icno,
                        'CardNo' => addslashes($this->input->post('card_no')),
                        'Expirydate' => addslashes($get_new_expiry_date),
                        'Remarks' => addslashes($this->input->post('remarks')),
                        'Phonemobile' => addslashes($this->input->post('mobile_no')),
                        'Active' => '1',
                        'Issuedate' => $this->db->query("SELECT CURDATE() as curdate")->row('curdate'),
                        'NewForScript' => 1,

                        'Name' => addslashes($this->input->post('Name')),
                        'NameOnCard' => addslashes($this->input->post('NameOnCard')),
                        'Birthdate' => $birthdate,
                        'Gender' => $Gender,
                        'Race' => addslashes($this->input->post('Race')),
                        'Religion' => addslashes($this->input->post('Religion')),
                        'Address1' => addslashes($this->input->post('add1')),
                        'Address2' => addslashes($this->input->post('add2')),
                        'Address3' => addslashes($this->input->post('add3')),
                        'Postcode' => addslashes($this->input->post('Postcode')),
                        'City' => addslashes($this->input->post('City')),
                        'State' => addslashes($this->input->post('State')),
                        'Email' => addslashes($this->input->post('email')),
                        'updated_at' => $now_date,
                        'acc_status' => 'ACTIVE'
                    );
                    $this->db->where('AccountNo', $account_no);
                    $this->db->update('member', $data);

                    $date = $this->db->query("SELECT NOW() as curdate")->row('curdate');

                    //upd_log
                    $upd = $this->db->query("SELECT branch_group, branch, Nationality, OldICNo, PassportNo, ICNo, CardNo, Expirydate, Remarks, Phonemobile, Name, NameOnCard, Birthdate, Gender, Race, Religion, Address1, Postcode, City, State, Email from member where AccountNo = '$account_no' ");
                    $upd_branch_group = $upd->row('branch_group');
                    $upd_branch = $upd->row('branch');
                    $upd_Nationality = $upd->row('Nationality');
                    $upd_OldICNo = $upd->row('OldICNo');
                    $upd_PassportNo = $upd->row('PassportNo');
                    $upd_ICNo = $upd->row('ICNo');
                    $upd_CardNo = $upd->row('CardNo');
                    $upd_Expirydate = $upd->row('Expirydate');
                    $upd_Remarks = $upd->row('Remarks');
                    $upd_Phonemobile = $upd->row('Phonemobile');
                    $upd_Name = $upd->row('Name');
                    $upd_NameOnCard = $upd->row('NameOnCard');
                    $upd_Birthdate = $upd->row('Birthdate');
                    $upd_Gender = $upd->row('Gender');
                    $upd_Race = $upd->row('Race');
                    $upd_Religion = $upd->row('Religion');
                    $upd_Address1 = $upd->row('Address1');
                    $upd_Postcode = $upd->row('Postcode');
                    $upd_City = $upd->row('City');
                    $upd_State = $upd->row('State');
                    $upd_Email = $upd->row('Email');
                    $upd_Reason = $this->input->post('reason');
                    /*$upd_Active = $upd->row('Active');
                    $upd_Issuedate = $upd->row('Issuedate');
                    $upd_NewForScript = $upd->row('NewForScript');*/
                    //upd_log

                    $field = array("branch_group", "branch", "Nationality", "OldICNo", "PassportNo", "ICNo", "CardNo", "Expirydate", "Remarks", "Phonemobile", "Name", "NameOnCard", "Birthdate", "Gender", "Race", "Religion", "Address1", "Postcode", "City", "State", "Reason", "Email");

                    for ($x = 0; $x <= 21; $x++) 
                    {
                        switch (${'ori_'.$field[$x]}) 
                        {
                            case ${'upd_'.$field[$x]}:
                                break;
                            default:
                                $data = array(
                                    'Trans_type' => 'ACTIVATION',
                                    'AccountNo' => $_SESSION['account_no'],
                                    'ReceiptNo' => $_SESSION['receipt_no'],
                                    'field' => $field[$x],
                                    'value_from' => ${'ori_'.$field[$x]},
                                    'value_to' => ${'upd_'.$field[$x]},
                                    'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                                    'expiry_date_after' => addslashes($get_new_expiry_date),
                                    'created_at' => $date,
                                    'created_by' => $_SESSION['username'],
                                    );
                                $this->db->insert('user_logs', $data);
                        }
                    }
                    
                    if($this->db->affected_rows() > 0)
                    {
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', 0); 
                        ini_set('memory_limit','2048M');

                        if($this->input->post('button') == 'edit')
                        {
                            redirect('Main_c/full_details?AccountNo=' .$_SESSION['account_no']);
                        }
                        else
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/activation?print&AccountNo=' .$_SESSION['account_no']. '&CardNo=' .$_SESSION['card_no']);
                        }
                    }
                    else
                    {
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', 0); 
                        ini_set('memory_limit','2048M');

                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Failed ! !<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/activation');
                    }
                }

                

            }
        }
        else
        {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0); 
            ini_set('memory_limit','2048M');

            redirect('login_c');
        }
    }

    public function renew()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['scan_card']))
            {   
                $reason_field = '';
                $field = '';
                $bypass = '';

                if(isset($_REQUEST['bypass']))
                {
                    $bypass = '&bypass=true';
                    $cardno = $_REQUEST['scan_card'];
                }
                else
                {
                    $cardno = $this->input->post('card_no');
                }

                //for merchant only
                if($_SESSION['user_group'] == 'MERCHANT GROUP')
                {
                    $get_data = $this->db->query("SELECT * FROM member WHERE CardNo = (SELECT CardNo FROM member_merchantcard WHERE CardNo = '".$cardno."' AND merchant_id = '".$_SESSION['branch_code']."') ");
                }
                else //for outlet
                {
                    $get_data = $this->db->query("SELECT * FROM `member` WHERE CardNo = '".$cardno."' ");
                }

                $check_lost_card = $this->db->query("SELECT LostCardNo FROM memberlostcard WHERE LostCardNo = '".$get_data->row('CardNo')."'");

                if($check_lost_card->num_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This Card Already Lost. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/renew');
                }

                if($get_data->num_rows() == 0)
                {
                    //for merchant checking only
                    if($_SESSION['user_group'] == 'MERCHANT GROUP')
                    {
                        $check_member_exist = $this->db->query("SELECT * FROM `member` WHERE CardNo = '".$cardno."' ");

                        if($check_member_exist->num_rows() > 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">You are not allowed to access this card!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/renew');
                        }
                        else
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Card No. not found!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/renew');
                        }
                    };

                    $get_data2 = $this->db->query("SELECT a.`SupCardNo` AS CardNo,a.*  FROM `membersupcard` a WHERE SupCardNo = '".$cardno."' ");
                    if($get_data2->num_rows() == 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Card Not Found!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/renew');
                    }
                    else
                    {
                        $_SESSION['card_type'] = 'sup_card';
                        $_SESSION['update_table'] = 'membersupcard';
                        redirect('Transaction_c/renew?exist_card='.$get_data2->row('CardNo').'&account='.$get_data2->row('AccountNo').'&ic_no='.$get_data2->row('ICNo').'&active='.$get_data2->row('Active').'&mobile_no='.$get_data2->row('PhoneMobile').'&email='.$get_data2->row('email').'&nationality='.$get_data2->row('Nationality').'&army_no='.$bypass);
                    }
                }
                else
                {

                    // if($get_data->row('Active') == 1)
                    // {
                    //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card already active!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    //     redirect('Transaction_c/activation');
                    // }
                    // else
                    // {
                        $_SESSION['card_type'] = 'primary_card';
                        $_SESSION['update_table'] = 'member';
                        redirect('Transaction_c/renew?exist_card='.$get_data->row('CardNo').'&account='.$get_data->row('AccountNo').'&ic_no='.$get_data->row('ICNo').'&active='.$get_data->row('Active').'&mobile_no='.$get_data->row('Phonemobile').'&email='.$get_data->row('Email').'&nationality='.$get_data->row('Nationality').'&army_no='.$get_data->row('ICNo').$bypass);
                    // }
                }

                $result = 'hidden';

            }
            elseif(isset($_REQUEST['exist_card']))
            {
                $bypass = '';

                if(isset($_REQUEST['bypass']))
                {
                    $bypass = '&bypass=true';
                }

                $check_for_merchant = $this->db->query("SELECT * FROM member_merchantcard WHERE CardNo = '".$_REQUEST['exist_card']."' ");
                $get_account_data = $this->db->query("SELECT * FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_REQUEST['account']."' order by laststamp desc ");
                
                // $_REQUEST['active'] == 0 || 
                if($get_account_data->row('Issuedate') == $get_account_data->row('Expirydate') && $get_account_data->row('Name') == 'NEW' || $get_account_data->row('Active') == 0 || $get_account_data->row('Expirydate') == '3000-12-31')// if not active yet
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card is not activated yet.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/renew');

                    /*$years = '';
                    $reason_field = 'ACTIVATION';
                    $field = 'receipt_activate';
                    $button = 'Activate';
                    $form = site_url('Transaction_c/save_activation');

                    if(!in_array('AMC', $_SESSION['module_code']) && $check_for_merchant->num_rows() > 0 && $_SESSION['user_group'] <> 'MERCHANT GROUP')
                    {
                       $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card Belong To  Merchant. Unable to activate.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                       redirect('Transaction_c/renew');
                    }*/
                }
                else
                {
                    $years = $this->db->query('SELECT expiry_date_in_year FROM set_parameter')->row('expiry_date_in_year');
                    $reason_field = 'RENEWAL';
                    $field = 'receipt_renew';
                    $button = 'Renew Card';
                    $form = site_url('Transaction_c/save_renew?'.$bypass);

                    if($_SESSION['user_group'] == 'MERCHANT GROUP')
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card Already Active<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/renew');
                    }
                }

                if($this->check_parameter()->row('terminate_expiry_month') != '0' && date('Y-m-d') > date('Y-m-d', strtotime("+".$this->check_parameter()->row('terminate_expiry_month')." month", strtotime($get_account_data->row('Expirydate')))) && !isset($_REQUEST['bypass']))
                {
                    $check_main_card = $this->db->query("SELECT * FROM membersupcard WHERE supcardno = '".$_REQUEST['exist_card']."' AND PrincipalCardNo <> 'LOSTCARD'");
                    if($check_main_card->num_rows() > 0)
                    {
                        $check_main_expiry = $this->db->query('SELECT * FROM member WHERE accountno = "'.$_REQUEST['account'].'" AND expirydate < CURDATE()');

                        if($check_main_expiry->num_rows() > 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Main Card Already Expirydate More Than '.$this->check_parameter()->row('terminate_expiry_month').' Month. Please Renew Main Card First.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/renew');
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('Clean_Up_Point_modal', 'true');
                        $this->session->set_flashdata('cardno', $_REQUEST['exist_card']);
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card Already Expirydate More than '.$this->check_parameter()->row('terminate_expiry_month').' month.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/renew');
                    }
                }

                $_SESSION['old_ic_no'] = $get_account_data->row('OldICNo');

                if((strtoupper($get_account_data->row('Nationality')) != 'MALAYSIAN' || strtoupper($get_account_data->row('Nationality')) != 'MALAYSIA' || strtoupper($get_account_data->row('Nationality')) != 'MY') && $_SESSION['update_table'] == 'membersupcard')
                {
                    $_SESSION['passport_no'] = $_REQUEST['ic_no'];
                }
                else
                {
                    $_SESSION['passport_no'] = $get_account_data->row('PassportNo');
                }

                $_SESSION['mobile_no'] = $_REQUEST['mobile_no'];
                $_SESSION['active'] = $_REQUEST['active'];
                $_SESSION['card_no'] = $_REQUEST['exist_card'];
                $_SESSION['account_no'] = $_REQUEST['account'];
                $_SESSION['ic_no'] = $_REQUEST['ic_no'];
                $_SESSION['army_no'] = $_REQUEST['army_no'];
                $_SESSION['email'] = $_REQUEST['email'];
                $_SESSION['hidden_result'] = '';
                $_SESSION['nationality'] = $_REQUEST['nationality'];
            }
            else
            {  
                $years = '';
                $reason_field = '';
                $field = ''; 
                $_SESSION['old_ic_no'] = '';
                $_SESSION['passport_no'] = '';

                $_SESSION['update_table'] = 'member';
                $button = 'Renew Card';
                $form = '';
                $_SESSION['mobile_no'] = '';
                $_SESSION['active'] = '';
                $_SESSION['card_no'] = '';
                $_SESSION['account_no'] = '';
                $_SESSION['ic_no'] = '';
                $_SESSION['army_no'] = '';
                $_SESSION['email'] = '';
                $_SESSION['hidden_result'] = 'hidden';
                $_SESSION['nationality'] = '';
            }

            $get_account_data = $this->db->query("SELECT * FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."' ORDER BY LastStamp DESC");

            if($get_account_data->row('Issuedate') == $get_account_data->row('Expirydate') && $get_account_data->row('Name') == 'NEW' || $get_account_data->row('Active') == 0)// if new card need to activate
            {
                // $get_preset_expiry_date = $this->db->query("SELECT (SELECT Expirydate FROM member WHERE AccountNo = '".$_SESSION['account_no']."')+INTERVAL (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
                // script with interval based on setting
                // $get_preset_expiry_date = $this->db->query("SELECT Expirydate FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."'")->row('Expirydate');

                // $get_preset_expiry_date = $this->db->query("SELECT (SELECT Expirydate FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."')+INTERVAL 
                //     (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
                // not capture currdate

                $get_preset_expiry_date = $this->db->query("SELECT CURDATE()+INTERVAL 
                    (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
                
                /*$branch = $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC");*/
                // $branch = $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name, c.receipt_activate FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY b.branch_code ASC");

                $branch = $this->branch_with_receipt();
            }
            else// if card need to renew
            {
                $get_setting = $this->db->query("SELECT expiry_date_type from set_parameter")->row('expiry_date_type');
                $today = $this->db->query("SELECT CURDATE() AS today ")->row('today');

                if($get_setting == 1)// if setup equal to 1 new expiry date will follow the logic
                {

                    if($get_account_data->row('Expirydate') > $today)// if expired date more then current date
                    {
                        $get_preset_expiry_date = $get_account_data->row('Expirydate');
                    }
                    else
                    {
                        $get_preset_expiry_date = $today; 
                    }
                };

                if($get_setting == 2)// if setup equal to 2 new expiry date will old expiry date format.
                {
                    $get_preset_expiry_date = $get_account_data->row('Expirydate');
                };

                if($get_setting == 3)// if setup equal to 3 all expiry date round up to n months.
                {
                    if($get_account_data->row('Expirydate') > $today && $get_account_data->row('Expirydate') != '3000-12-31')// if expired date more then current date
                    {
                        $date = $get_account_data->row('Expirydate');
                    }
                    else
                    {
                        $date = $today; 
                    }
                    $month = date("m", strtotime($date));
                    $year = date("Y", strtotime($date));
                    $month_rounder = $this->db->query("SELECT expiry_date_roundup FROM set_parameter")->row('expiry_date_roundup');
                    $expiry_month = ceil($month/$month_rounder) * $month_rounder;
                    $expiry_month = str_pad($expiry_month, 2, '0', STR_PAD_LEFT);
                    $days = cal_days_in_month(CAL_GREGORIAN,$expiry_month,$year);
                    $get_preset_expiry_date  = $year.'-'.$expiry_month.'-'.$days;
                }
                
                // $branch = $this->db->query("SELECT branch as branch_code, branch as branch_name  FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."' ");
                $branch = $this->db->query("SELECT branch as branch_code, branch as branch_name  FROM member WHERE AccountNo = '".$_SESSION['account_no']."' ")->result_array();
            }

            if(isset($_REQUEST['print']))
            {
                $bodyload = 'printdetails()';
                $AccountNo = $_REQUEST['AccountNo'];
                $CardNo = $_REQUEST['CardNo'];
            }
            else
            {
                $bodyload = '';
                $AccountNo = '';
                $CardNo = '';
            }
            /*if($branch->num_rows() == 1)
            {
                $need_receipt_no = $this->db->query("SELECT set_receipt_no FROM set_branch_newcard where branch_code = '".$branch->row('branch_code')."' ")->row('set_receipt_no'),
            }
            else
            {
                $need_receipt_no = '';
            }*/

            $data = array(

                /*'need_receipt_no' => $need_receipt_no,*/
                'actual_expirydate' => $get_account_data->row('Expirydate'),
                'direction' => site_url('Transaction_c/renew'),
                'bodyload' => $bodyload,
                'button' => $button,
                'form' => $form,
                'branch' => $branch,
                'expiry_date' => $get_preset_expiry_date,
                'remarks' => $this->db->query("SELECT * FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."' ")->row('Remarks'),

                'select_nationality' => $this->db->query("SELECT * FROM set_nationality"),
                'reason' => $this->db->query("SELECT * FROM set_reason where type = '".$reason_field."' "),
                'field' => $field,
                'years' => $years,
                'check_receipt_itemcode' => $this->db->query("SELECT * FROM set_parameter ")->row('check_receipt_itemcode'),
                'AccountNo' => $AccountNo,
                'CardNo' => $CardNo,
                'card_verify' => $this->check_parameter()->row('card_verify'),
                'terminate_expiry_month' => $this->check_parameter()->row('terminate_expiry_month'),
            );
            //echo $this->db->last_query();die;

            $this->template->load('template' , 'activation', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_renew()
    {
       if($this->session->userdata('loginuser')== true)
        {
            $bypass = '';

            if(isset($_REQUEST['bypass']))
            {
                $bypass = '&bypass=true';
            }

            if($this->check_parameter()->row('card_verify') == '1' && ($this->input->post('confirm_cardno') != $_SESSION['card_no'] || $this->input->post('confirm_password') != $_SESSION['card_no']))
            {
                $this->session->set_flashdata('message_confirm', '<div class="alert alert-warning text-center" style="font-size: 16px">Card No. Not Match!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
            }
            else
            {
                /*$need_receipt_no = $this->db->query("SELECT receipt_no_activerenew FROM `set_parameter`;")->row('receipt_no_activerenew');*/
                $need_receipt_no = $this->db->query("SELECT receipt_renew FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch_hidden')."' OR branch_id = '".$this->input->post('branch_hidden')."'")->row('receipt_renew');
                $check_check_receipt_itemcode = "";
                    if($need_receipt_no == 1)
                    {
                        if($this->input->post('receipt_no') == '')
                        {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', 0); 
                            ini_set('memory_limit','2048M');

                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please fill in receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                        };

                        $_SESSION['receipt_no'] = $this->input->post('receipt_no');

                        if(!in_array('BPRN', $_SESSION['module_code']))// if dont have authorization to by pass
                        {
                            $_SESSION['receipt_no'] = $this->input->post('receipt_no');

                            $check_check_receipt_itemcode = $this->db->query("SELECT a.`check_receipt_itemcode` FROM set_parameter a;")->row('check_receipt_itemcode');

                            //$check_receipt_setup = $this->db->query("SELECT receipt_no_amount_renew FROM `set_parameter`;")->row('receipt_no_amount_renew');

                            if($check_check_receipt_itemcode == 0) //check amount (all outlets)
                            {
                                $check_receipt_setup = $this->db->query("SELECT receipt_no_amount_renew FROM set_parameter ")->row('receipt_no_amount_renew');
                            }
                            elseif($check_check_receipt_itemcode == 2) //check amount (based outlets)
                            {
                                $check_receipt_setup = $this->db->query("SELECT amount_renew FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch_hidden')."' ")->row('amount_renew');
                            }
                            else
                            {
                                $check_receipt_setup = '0';
                            }

                            // if($this->check_parameter()->row('check_receipt_itemcode') == 1)
                            // {
                            //     $check_receipt = $this->Trans_Model->check_receipt_no_child($this->input->post('receipt_no'));
                            //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_child($this->input->post('receipt_no'));
                            // }
                            // else
                            // {
                            //     $check_receipt = $this->Trans_Model->check_receipt_no_main($this->input->post('receipt_no'));
                            //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_main($this->input->post('receipt_no'));
                            // }

                            //echo $this->db->last_query();die;
                            $check_itemcode = $this->db->query("SELECT * FROM set_itemcode WHERE name = 'newcard' ");

                            // $check_exist_receipt = $this->db->query("SELECT * FROM frontend.posmain WHERE RefNo = '".$this->input->post('receipt_no')."'");

                            $data = array(
                                'refno' => $this->input->post('receipt_no'),
                            );

                            $result = $this->Member_Model->query_call('Transaction_c', 'save_renew', $data);

                            if($result['message'] != 'success')//if not found
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                            }
                            // elseif($check_receipt_void->num_rows() == 1)//if receipt void
                            // {
                            //     $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt Already Voided !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            //     redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no'));
                            // }
                            else
                            {
                                $check_receipt_day = $this->db->query("SELECT check_receipt_day FROM set_parameter ")->row('check_receipt_day');
                                $get_days = $this->db->query("SELECT TIMESTAMPDIFF(DAY, '".$result['check_receipt'][0]['BizDate']."', CURDATE()) AS day ")->row('day');

                                if(($check_check_receipt_itemcode == 0 || $check_check_receipt_itemcode == 2) && $result['check_receipt'][0]['BillAmt'] < $check_receipt_setup)// if setup not check itemcode and bill amount less than tamount setup
                                {
                                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Receipt Amount Not Enough !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                                }
                                /*elseif($check_receipt->row('BizDate') <> $this->db->query("SELECT CURDATE() AS curr_date")->row('curr_date'))*/
                                elseif($get_days > $check_receipt_day)
                                {
                                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid receipt date. !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                                }
                                elseif($check_check_receipt_itemcode == 1)
                                {
                                    // $check_receipt = $this->db->query("SELECT b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND b.Refno = '".$this->input->post('receipt_no')."' AND b.itemcode = '".$check_itemcode->row('itemcode')."' ");
                                    // if($check_receipt->num_rows() == 0)//if not found
                                    // {
                                    //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for renew card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    //     redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no'));
                                    // };

                                    // $check_receipt->row('Qty');

                                    $data = array(
                                        'refno' => $this->input->post('receipt_no'),
                                        'itemcode' => $check_itemcode->row('itemcode'),
                                    );

                                    $check_receipt = $this->Member_Model->query_call('Transaction_c', 'save_renew1', $data);

                                    if($check_receipt['message'] != 'success')
                                    {
                                        if($check_receipt['message'] == 'Unable find itemcode for renew card on this receipt no.Please make payment to proceed this transaction.')
                                        {
                                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for renew card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                        }
                                        else
                                        {
                                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$check_receipt['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                        }

                                        redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                                    }
                                }
                            }


                            $receipt_no = $_SESSION['receipt_no'];
                            if($this->check_exist_receipt_no($receipt_no)->num_rows() > 0)
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt No. Exist In Record !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                            }
                        }
                        else
                        {
                            if($this->input->post('receipt_no') != '-')
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please use "-" for bypass receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                            };
                        }
                        
                    }
                    else
                    {
                        $_SESSION['receipt_no'] = '';
                    }

                if($check_check_receipt_itemcode == 1)
                {
                    $expiry_date_in_year = $check_receipt['check_receipt']['0']['Qty'];
                }
                else
                {
                    $expiry_date_in_year = $this->db->query('SELECT expiry_date_in_year FROM set_parameter')->row('expiry_date_in_year');
                }
                
                /*$get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$this->input->post('years')."' YEAR AS Expirydate")->row('Expirydate');*/
                $get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$expiry_date_in_year."' YEAR AS Expirydate")->row('Expirydate');
                //echo $this->db->last_query();die;
                $account_no = $_SESSION['account_no'];
                $card_no = $_SESSION['card_no'];

                //ori_log
                $ori = $this->db->query("SELECT branch, ICNo, CardNo, Expirydate, Remarks, Phonemobile from member where AccountNo = '$account_no' ");
                $ori_branch = $ori->row('branch');
                $ori_ICNo = $ori->row('ICNo');
                $ori_CardNo = $ori->row('CardNo');
                $ori_Expirydate = $ori->row('Expirydate');
                $ori_Remarks = $ori->row('Remarks');
                $ori_Phonemobile = $ori->row('Phonemobile');
                $ori_Reason = '';
                //$ori_NewForScript = $ori->row('NewForScript');
                //ori_log

                $data = array(

                    // 'branch' => addslashes($this->input->post('branch')),
                    // 'ICNo' => addslashes($this->input->post('ic_no')),
                    // 'CardNo' => addslashes($this->input->post('card_no')),
                    // 'Phonemobile' => addslashes($this->input->post('mobile_no')),
                    'Expirydate' => addslashes($get_new_expiry_date),
                    'Remarks' => addslashes($this->input->post('remarks')),
                    'NewForScript' => 1,
                    'updated_at' => $this->datetime(),
                );

                if($_SESSION['card_type'] == 'sup_card')
                {
                    $check_type = $this->db->query("SELECT * FROM membersupcard WHERE AccountNo = '$account_no' AND SupCArdNo = '$card_no'")->row('PrincipalCardNo');
                    if($check_type == 'LOSTCARD')
                    {
                        $get_setting = $this->db->query("SELECT * FROM set_parameter")->row('auto_renewsupcard');

                        if($get_setting == 1)
                        {
                            $this->db->where('AccountNo', $account_no);
                            $this->db->update('member', $data);

                            $this->db->where('AccountNo', $account_no);
                            $this->db->update('membersupcard', $data);
                        }
                        else
                        {
                            $where = array(
                                'AccountNo' => $account_no,
                                'PrincipalCardNo' => 'LOSTCARD',
                            );

                            $this->db->where($where);
                            $this->db->update('membersupcard', $data);

                            $this->db->where('AccountNo', $account_no);
                            $this->db->update('member', $data);
                        }
                    }
                    else
                    {
                        $get_setting = $this->db->query("SELECT * FROM set_parameter")->row('auto_renewsupcard');
                        $where = array(
                                'AccountNo' => $account_no,
                                'Active' => '1',
                            );

                        if($get_setting == 1)
                        {
                            $this->db->where('AccountNo', $account_no);
                            $this->db->update('member', $data);

                            $this->db->where($where);
                            $this->db->update('membersupcard', $data);
                        }
                        else
                        {
                            $where = array(
                                'AccountNo' => $account_no,
                                'Active' => '1',
                                'SupCardNo' => $card_no,
                            );

                            $this->db->where($where);
                            $this->db->update('membersupcard', $data);

                            $where = array(
                                'AccountNo' => $account_no,
                                'Active' => '1',
                                'OldCardNo' => $card_no,
                                'PrincipalCardNo' => 'LOSTSUPCARD',
                            );

                            $this->db->where($where);
                            $this->db->update('membersupcard', $data);
                        }

                    }

                    $renew_card = "RENEWALSUP";
                };
                
                if($_SESSION['card_type'] == 'primary_card')
                {
                    $get_data = $this->db->query("SELECT * FROM member WHERE accountno = '".$account_no."'");
                    $old_expirydate = $get_data->row('Expirydate');
                    if($this->check_parameter()->row('terminate_expiry_month') != '0' && date('Y-m-d') > date('Y-m-d', strtotime("+".$this->check_parameter()->row('terminate_expiry_month')." month", strtotime($old_expirydate))))
                    {
                        if($get_data->row('Pointbalance') < 0)
                        {
                            $pointbalance = $get_data->row('Pointbalance') + $get_data->row('Pointbalance');
                        }
                        else
                        {
                            $pointbalance = $get_data->row('Pointbalance') - $get_data->row('Pointbalance');
                        }

                        $point_adjust = $get_data->row('Pointsbalance');

                        $branch_id = $this->db->query("SELECT branch_name FROM set_branch_parameter AS a WHERE a.branch_id = '".$get_data->row('branch')."'");

                        if($branch_id->num_rows() == '0')
                        {
                            $branch = $get_data->row('branch');
                        }
                        else
                        {
                            $branch = $branch_id->row('branch_name');
                        }

                        $trans_guid = $this->db->query('SELECT REPLACE(UPPER(UUID()), "-", "") AS guid')->row('guid');
                        $datachild = array(
                            'CHILD_GUID' => $this->guid(),
                            'TRANS_GUID' => $trans_guid,
                            'ITEMCODE' => $account_no,
                            'DESCRIPTION' => 'Account No',
                            'QTY_FACTOR' => '-1',
                            'QTY' => '1',
                            'VALUE_UNIT' => $point_adjust,
                            'VALUE_TOTAL' => $point_adjust,
                            'CREATED_AT' => $this->datetime(),
                            'CREATED_BY' => $_SESSION['username'],
                            'UPDATED_AT' => $this->datetime(),
                            'UPDATED_BY' => $_SESSION['username'],

                            );
                        $this->db->insert('trans_child', $datachild);

                        $data_main = array(
                            'TRANS_GUID' => $trans_guid,
                            'TRANS_TYPE' => 'POINT_ADJ_OUT',
                            'REF_NO' => $this->Trans_Model->get_point_trans_ref_no_terminate()->row('ref_no'),
                            'TRANS_DATE' => $this->date(),
                            'SUP_CODE' => $account_no,
                            'SUP_NAME' => $get_data->row('Name'),
                            'REMARK' => 'Expiry more than '.$this->check_parameter()->row('terminate_expiry_month').' month',
                            'VALUE_TOTAL' => $point_adjust,
                            'CREATED_AT' => $this->datetime(),
                            'CREATED_BY' => $_SESSION['username'],
                            'UPDATED_AT' => $this->datetime(),
                            'UPDATED_BY' => $_SESSION['username'],
                            'reason' => 'ADJUST OUT',
                            'point_curr' => $pointbalance,
                            'branch' => $branch,
                            'send_outlet' => '0',
                            'cardno' => $card_no,
                            'POSTED' => '1',
                            );
                        $this->db->insert('trans_main', $data_main);

                        $data['Pointsbalance'] = '0';
                    }

                    $this->db->where('AccountNo', $account_no);
                    $this->db->update('member', $data);

                    $get_setting = $this->db->query("SELECT * FROM set_parameter")->row('auto_renewsupcard');
                    $where = array(
                            'AccountNo' => $account_no,
                            'Active' => '1',
                        );

                    if(isset($data['Pointsbalance']))
                    {
                        unset($data['Pointsbalance']);
                    }

                    if($get_setting == 1)
                    {
                        $this->db->where('AccountNo', $account_no);
                        $this->db->update('member', $data);

                        $this->db->where($where);
                        $this->db->update('membersupcard', $data);
                    }
                    else
                    {
                        $where['PrincipalCardNo'] = 'LOSTCARD';
                        $this->db->where($where);
                        $this->db->update('membersupcard', $data);
                    }

                    $renew_card = "RENEWAL";
                };

                if($this->check_parameter()->row('terminate_expiry_month') != '0' && date('Y-m-d') > date('Y-m-d', strtotime("+".$this->check_parameter()->row('terminate_expiry_month')." month", strtotime($old_expirydate))))
                {
                    $this->Member_Model->query_call('Point_c', 'recalc_point', array('accountno' => $account_no));
                }

                $date = $this->db->query("SELECT NOW() as curdate")->row('curdate');

                if($this->check_parameter()->row('preissue_card_method') == '0')
                {
                    $get_member = $this->db->query("
                            SELECT a.* FROM member AS a 
                            WHERE a.accountno = '$account_no' AND a.CardNo = '$card_no'
                            UNION ALL
                            SELECT a.* FROM member AS a
                            INNER JOIN membersupcard AS b ON a.AccountNo = b.Accountno
                            WHERE b.accountno = '$account_no' AND b.SupCardNo = '$card_no'
                        ");

                    $data_trans = array(
                        'TRANS_GUID' => $this->guid(),
                        'TRANS_TYPE' => $renew_card ,
                        'REF_NO' => addslashes($this->input->post('receipt_no')),
                        'AccountNo' => $account_no,
                        'CardNo' => $card_no,
                        'Name' => $get_member->row('Name'),
                        'NameOnCard' => $get_member->row('NameOnCard'),
                        'Phonemobile' => $get_member->row('mobile_no'),
                        'Issuedate' => $this->date(),
                        'Expirydate' => $get_member->row('Expirydate'),
                        'ICNo' => $get_member->row('ICNo'),
                        'Active' => $get_member->row('Active'),
                        'Remarks' => $get_member->row('remarks'),
                        'Gender' => $get_member->row('Gender'),
                        'IssueStamp' => $this->datetime(),
                        'UPDATED_BY' => $_SESSION['username'],
                        'UPDATED_AT' => $this->datetime(),
                        'LastStamp' => $this->datetime(),
                        'created_at' => $this->datetime(),
                        'created_by' => $_SESSION['username'],
                        'NewForScript' => '1',
                        'branch' => $this->input->post('branch'),
                        'Address1' => $get_member->row('Address1'),
                        'Address2' => $get_member->row('Address2'),
                        'Address3' => $get_member->row('Address3'),
                        'City' => $get_member->row('City'),
                        'State' => $get_member->row('State'),
                        'Email' => $get_member->row('Email'),
                        'Phonehome' => $get_member->row('Phonehome'),
                        'Phoneoffice' => $get_member->row('Phoneoffice'),
                        'Phonemobile' => $get_member->row('Phonemobile'),
                        'Fax' => $get_member->row('Fax'),
                        'Cardtype' => $get_member->row('Cardtype'),
                        'Title' => $get_member->row('Title'),
                        'OldICNo' => $get_member->row('OldICNo'),
                        'Occupation' => $get_member->row('Occupation'),
                        'Employer' => $get_member->row('Employer'),
                        'Birthdate' => $get_member->row('Birthdate'),
                        'Principal' => $get_member->row('Principal'),
                        'Nationality' => $get_member->row('Nationality'),
                        'Status' => $get_member->row('Status'),
                        'Race' => $get_member->row('Race'),
                        'Religion' => $get_member->row('Religion'),
                        'PointsBF' => $get_member->row('PointsBF'),
                        'Points' => $get_member->row('Points'),
                        'PointsAdj' => $get_member->row('PointsAdj'),
                        'Pointsbalance' => $get_member->row('Pointsbalance'),
                        'PassportNo' => $get_member->row('PassportNo'),
                    );
                    $this->db->insert('mem_ii_trans' , $data_trans);
                }

                //upd_log
                $upd = $this->db->query("SELECT branch, ICNo, CardNo, Expirydate, Remarks, Phonemobile from member where AccountNo = '$account_no' ");
                $upd_branch = $upd->row('branch');
                $upd_ICNo = $upd->row('ICNo');
                $upd_CardNo = $upd->row('CardNo');
                $upd_Expirydate = $upd->row('Expirydate');
                $upd_Remarks = $upd->row('Remarks');
                $upd_Phonemobile = $upd->row('Phonemobile');
                $upd_Reason = $this->input->post('reason');
                //$upd_NewForScript = $upd->row('NewForScript');
                //upd_log

                $field = array("branch", "ICNo", "CardNo", "Expirydate", "Remarks", "Phonemobile", "Reason");

                for ($x = 0; $x <= 6; $x++) 
                {
                    switch (${'ori_'.$field[$x]}) 
                    {
                        case ${'upd_'.$field[$x]}:
                            break;
                        default:
                            $data = array(
                                'Trans_type' => 'RENEW',
                                'AccountNo' => $_SESSION['account_no'],
                                'ReceiptNo' => $_SESSION['receipt_no'],
                                'field' => $field[$x],
                                'value_from' => ${'ori_'.$field[$x]},
                                'value_to' => ${'upd_'.$field[$x]},
                                'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                                'expiry_date_after' => addslashes($get_new_expiry_date),
                                'created_at' => $date,
                                'created_by' => $_SESSION['username'],
                                );
                            $this->db->insert('user_logs', $data);
                    }
                }

                if($this->db->affected_rows() > 0)
                {
                    if($this->input->post('button') == 'edit')
                    {
                        redirect('Main_c/full_details?AccountNo=' .$_SESSION['account_no']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/renew');
                    }
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Failed ! !<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/renew');
                }
            }
        } 
        else
        {
            redirect('login_c');
        }
    }

public function issue_sup_card()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['scan_card']))
            {
                $get_data = $this->db->query("SELECT * FROM `member` WHERE CardNo = '".$this->input->post('card_no')."' ");

                if(($get_data->row('Issuedate') == $get_data->row('Expirydate')) && ($get_data->row('Name') == 'NEW'))
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card is not activated.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/issue_sup_card');
                };

                if($get_data->row('acc_status') == 'TERMINATE' || $get_data->row('acc_status') == 'SUSPEND')
                {
                     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card Has Been '.$get_data->row('acc_status').'. Unable to activate.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                       redirect('Transaction_c/issue_sup_card');
                }

                $check_lost_card = $this->db->query("SELECT LostCardNo FROM memberlostcard WHERE LostCardNo = '".$get_data->row('CardNo')."'");

                if($check_lost_card->num_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This Card Already Lost. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/issue_sup_card');
                }

                if($get_data->num_rows() == 0)
                {
                    $get_data_supcard = $this->db->query("SELECT * FROM `membersupcard` WHERE SupCardNo = '".$this->input->post('card_no')."' ");
                    //$get_data_member = $this->db->query("SELECT * FROM `member` WHERE CardNo = '".$this->input->post('card_no')."' ");

                    if($get_data_supcard->num_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Only main card holder can issue suplimentary card.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/issue_sup_card');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Card Not Found!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/issue_sup_card');
                    }
                }
                else
                {
                    
                    redirect('Transaction_c/issue_sup_card?exist_card='.$get_data->row('CardNo').'&account='.$get_data->row('AccountNo').'&Nationality='.$get_data->row('Nationality'));
                    
                }

                $result = 'hidden';

            }
            elseif(isset($_REQUEST['exist_card']))
            {
                $get_main_card = $this->db->query("SELECT * FROM member WHERE AccountNo = '".$_REQUEST['account']."'");
                $_SESSION['Nationality'] = $_REQUEST['Nationality'];
                $_SESSION['card_no'] = $_REQUEST['exist_card'];
                $_SESSION['account_no'] = $_REQUEST['account'];
                $_SESSION['hidden_result'] = '';
            }
            else
            {
                $get_main_card = $this->db->query("SELECT * FROM member WHERE AccountNo = ''");  
                $_SESSION['Nationality'] = '';
                $_SESSION['card_no'] = '';
                $_SESSION['account_no'] = '';
                $_SESSION['hidden_result'] = 'hidden';
            }

            $get_setting = $this->db->query("SELECT * FROM set_parameter")->row('auto_renewsupcard');
            // check setting if main
            if($get_setting == 1)
            {
                $get_preset_expiry_date = $this->db->query("SELECT Expirydate FROM member WHERE accountno = '".$_SESSION['account_no']."' ")->row('Expirydate');
            }
            else
            {
                $get_preset_expiry_date = $this->db->query("SELECT CURDATE()+INTERVAL (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
            }

            //echo $this->db->last_query();die;
            
           if(isset($_REQUEST['created']))
           {
                $cardno = $_REQUEST['created'];
           }
           else
           {
                $cardno = '';
           }

            $data =array(

                /*'need_receipt_no' => $this->db->query("SELECT receipt_no_supcard FROM `set_parameter`;")->row('receipt_no_supcard'),*/
                /*'branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),*/
                // 'branch' => $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name, c.receipt_sup FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY b.branch_code ASC"),
                'branch' => $this->branch_with_receipt(),
                'expiry_date' => $get_preset_expiry_date,
                'set_relay' => $this->db->query("SELECT * FROM set_relationship"),
                'ic_no' => $get_main_card->row('ICNo'),
                'passport_no' => $get_main_card->row('PassportNo'),
                'mobile_no' => $get_main_card->row('Phonemobile'),
                'name' => $get_main_card->row('Name'),
                'field' => 'receipt_sup',
                'reason' => $this->db->query("SELECT * FROM set_reason where type = 'SUPPLEMENT' "),
                'preisse_method' => $this->check_parameter()->row('preissue_card_method'),
                'get_created' => $this->db->query("SELECT * FROM membersupcard a WHERE a.SupCardNo = '$cardno' "),
                'nationality' => $this->db->query("SELECT * FROM set_nationality"),
                'preissue_card_method' => $this->db->query('SELECT preissue_card_method FROM set_parameter')->row('preissue_card_method'),
                'card_verify' => $this->check_parameter()->row('card_verify'),
            );

            //echo $this->db->last_query();die;

            $this->template->load('template' , 'issue_sup_card', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_sup_card()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $name_sup = $nameonsupcard = "";

            if($this->input->post('Name_Sup'))
            {
                $name_sup = $this->input->post('Name_Sup');
            }

            if($this->input->post('NameOnSupCard'))
            {
                $nameonsupcard = $this->input->post('NameOnSupCard');
            }

            if($this->check_parameter()->row('card_verify') == '1')
            {
                if($this->input->post('confirm_cardno') != $this->input->post('card_no') || $this->input->post('confirm_password') != $this->input->post('card_no'))
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card No. Not Match!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                };
            }

            $national = strtoupper($this->input->post('select_national'));
            $ic_input = $this->input->post('ic_no');
            $passno = $this->input->post('passport_no');
            $icno = "";

            if($national == 'MALAYSIAN' || $national == 'MALAYSIA')
            {
                $icno = $this->db->query("SELECT CONCAT(LEFT('$ic_input', 6), '-', SUBSTRING('$ic_input', 7, 2), '-', RIGHT('$ic_input', 4)) AS icno ")->row('icno');
                $curyear = $this->db->query("SELECT DATE_FORMAT(CURDATE(), '%y') AS `curyear` ")->row('curyear');
                $icyear = $this->db->query("SELECT LEFT('$icno', 2) AS `year` ")->row('year');

                if($icyear >= '00' && $icyear <= $curyear)
                {
                    $birthdate = $this->db->query("SELECT CONCAT('20', LEFT('$ic_input', 2), '-', SUBSTRING('$ic_input', 3, 2), '-', SUBSTRING('$ic_input', 5, 2)) AS birthdate ")->row('birthdate');
                }
                else
                {
                    $birthdate = $this->db->query("SELECT CONCAT('19', LEFT('$ic_input', 2), '-', SUBSTRING('$ic_input', 3, 2), '-', SUBSTRING('$ic_input', 5, 2)) AS birthdate ")->row('birthdate');
                }

                $check_month_ic_no = $this->db->query("SELECT MID('".$this->input->post('ic_no')."', 3, 2) as month")->row('month');
                $check_day_ic_no = $this->db->query("SELECT MID('".$this->input->post('ic_no')."', 5, 2) as day")->row('day');

                if(strpos($this->input->post('ic_no'), '_') !== false || $check_month_ic_no > 12 || $check_day_ic_no > 31 || strlen($this->input->post('ic_no')) != '12')
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid IC No!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                };
            }
            
            /*$check_valid = $this->db->query("SELECT Active FROM member WHERE Active = 0 AND NAME = 'NEW' AND CardNo = '".$this->input->post('card_no')."' "); recommended by hugh */ 

            /*check if card no is new and pre issue method is active then prompt error*/
            $check_valid = $this->db->query("SELECT Active FROM member WHERE NAME = 'NEW' AND CardNo = '".$this->input->post('card_no')."' ");
            if($check_valid->num_rows() == 0 && $this->check_parameter()->row('preissue_card_method') == 1)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$this->input->post('card_no').' has been used.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
            }
            

            /*$check_ic_no = $this->db->query("SELECT * FROM (
            SELECT ICNo FROM member WHERE ICNo = '".$this->input->post('ic_no')."' 
            UNION ALL
            SELECT ICNo FROM membersupcard WHERE ICNo = '".$this->input->post('ic_no')."')a1");*/

            if($national == 'MALAYSIAN' || $national == 'MALAYSIA')
            {
                $check_ic_no = $this->db->query("SELECT ICNo FROM `member` WHERE ICNo = '".$icno."' ");

                if(($check_ic_no->num_rows() > 0) && ($this->input->post('ic_no') != ''))
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">IC No already exist!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                };
            }
            else
            {
                $check_passport = $this->db->query("SELECT PassportNo FROM member WHERE PassportNo = '".$passno."'");

                if(($check_passport->num_rows() > 0) && ($passno != ''))
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Passport No already exist!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard  );
                }
            }

            $check_card_no = $this->db->query("SELECT * FROM (
            SELECT SupCardNo FROM membersupcard WHERE SupCardNo = '".$this->input->post('card_no')."')a1");

            if($check_card_no->num_rows() > 0 && $this->check_parameter()->row('preissue_card_method') == 1)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card No already exist!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
            };

            if($this->input->post('Gender') == 'L')
            {
                $Gender = 'MALE';
            }
            elseif($this->input->post('Gender') == 'P')
            {
                $Gender = 'FEMALE';
            }
            else
            {
                $Gender = '';
            }

            /*$need_receipt_no = $this->db->query("SELECT receipt_no_supcard FROM `set_parameter`;")->row('receipt_no_supcard');*/
            $need_receipt_no = $this->db->query("SELECT receipt_sup FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch')."' ")->row('receipt_sup');
                if($need_receipt_no == 1)
                {
                    if($this->input->post('receipt_no') == '')
                    {
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', 0); 
                        ini_set('memory_limit','2048M');

                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please fill in receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                    };

                    if(!in_array('BPRN', $_SESSION['module_code']))
                    {
                        $_SESSION['receipt_no'] = $this->input->post('receipt_no');

                        $check_check_receipt_itemcode = $this->db->query("SELECT a.`check_receipt_itemcode` FROM set_parameter a;")->row('check_receipt_itemcode');

                        //$check_receipt_setup = $this->db->query("SELECT receipt_no_amount_supcard FROM `set_parameter`;")->row('receipt_no_amount_supcard');

                        if($check_check_receipt_itemcode == 0) //check amount (all outlets)
                        {
                            $check_receipt_setup = $this->db->query("SELECT receipt_no_amount_supcard FROM `set_parameter` ")->row('receipt_no_amount_supcard');
                        }
                        elseif($check_check_receipt_itemcode == 2) //check amount (based outlets)
                        {
                            $check_receipt_setup = $this->db->query("SELECT amount_sup FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch')."' ")->row('amount_sup');
                        }
                        else
                        {
                            $check_receipt_setup = '0';
                        }

                        // if($this->check_parameter()->row('check_receipt_itemcode') == 1)
                        // {
                        //     $check_receipt = $this->Trans_Model->check_receipt_no_child($this->input->post('receipt_no'));
                        //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_child($this->input->post('receipt_no'));
                        // }
                        // else
                        // {
                        //     $check_receipt = $this->Trans_Model->check_receipt_no_main($this->input->post('receipt_no'));
                        //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_main($this->input->post('receipt_no'));
                        // }
                            
                        $check_itemcode = $this->db->query("SELECT * FROM set_itemcode WHERE name = 'supcard' ");

                        $data = array(
                            'refno' => $this->input->post('receipt_no'),
                        );

                        $result = $this->Member_Model->query_call('Transaction_c', 'save_renew', $data);
                        $check_receipt = $result['check_receipt'];

                        //echo $this->db->last_query();die;
                        // $check_exist_receipt = $this->db->query("SELECT * FROM frontend.posmain WHERE RefNo = '".$this->input->post('receipt_no')."'");

                        // if($check_exist_receipt->num_rows() == 0)//if not found
                        if($result['message'] != 'success')
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                             redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                        }
                        // elseif($check_receipt_void->num_rows() == 1)//if receipt void
                        // {
                        //     $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt Already Voided !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        //     redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                        // }
                        else
                        {
                            $check_receipt_day = $this->db->query("SELECT check_receipt_day FROM set_parameter ")->row('check_receipt_day');
                            $get_days = $this->db->query("SELECT TIMESTAMPDIFF(DAY, '".$check_receipt[0]['BizDate']."', CURDATE()) AS day ")->row('day');

                            if(($check_check_receipt_itemcode == 0 || $check_check_receipt_itemcode == 2) && $check_receipt[0]['BillAmt'] < $check_receipt_setup)// if setup not check itemcode and bill amount less than tamount setup
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Receipt Amount Not Enough !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                            }
                            /*elseif($check_receipt->row('BizDate') <> $this->db->query("SELECT CURDATE() AS curr_date")->row('curr_date'))*/
                            elseif($get_days > $check_receipt_day)
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid receipt date. !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                            }
                            elseif($check_check_receipt_itemcode == 1)
                            {
                                // $check_receipt = $this->db->query("SELECT b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND b.Refno = '".$this->input->post('receipt_no')."' AND b.itemcode = '".$check_itemcode->row('itemcode')."' ");
                                // if($check_receipt->num_rows() == 0)//if not found
                                // {
                                //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for activation card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                //     redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                                // }

                                $data = array(
                                        'refno' => $this->input->post('receipt_no'),
                                        'itemcode' => $check_itemcode->row('itemcode'),
                                    );

                                $check_receipt = $this->Member_Model->query_call('Transaction_c', 'save_renew1', $data);

                                if($check_receipt['message'] != 'success')
                                {
                                    if($check_receipt['message'] == 'Unable find itemcode for renew card on this receipt no.Please make payment to proceed this transaction.')
                                    {
                                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for activation card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    }
                                    else
                                    {
                                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$check_receipt['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    }

                                    redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                                }
                            }
                        }

                        $receipt_no = $_SESSION['receipt_no'];
                        if($this->check_exist_receipt_no($receipt_no)->num_rows() > 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt No Already Exist In Record !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                        };
                    }
                    else
                    {
                        if($this->input->post('receipt_no') != '-')
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please use "-" for bypass receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                        };

                        $_SESSION['receipt_no'] = $this->input->post('receipt_no');
                    }
                    
                }
                else
                {
                    $_SESSION['receipt_no'] = '';
                }

            $get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$this->input->post('years')."' YEAR AS Expirydate")->row('Expirydate');

            // if not use preisse card no, system auto create ne card no
            if($this->check_parameter()->row('preissue_card_method') == '0')
            {
                $account_no = $this->Trans_Model->generate_card_no($this->input->post('branch'));
                $SupCardNo = $account_no;
            }
            else
            {
                $SupCardNo = addslashes($this->input->post('card_no'));
            }

            // if not use preisse card no, system auto create ne card no
            if($this->check_parameter()->row('preissue_card_method') == '0')
            {
                // $account_no = $this->Trans_Model->generate_card_no($this->input->post('branch'));

                $data_trans = array(
                    'TRANS_GUID' => $this->guid(),
                    'TRANS_TYPE' => 'ISSUE SUP' ,
                    'REF_NO' => addslashes($this->input->post('receipt_no')),
                    'AccountNo' => $_SESSION['account_no'],
                    'CardNo' => $SupCardNo,
                    'CardNoNew' => '',
                    'Name' => addslashes($name_sup),
                    'NameOnCard' => addslashes($nameonsupcard),
                    'Phonemobile' => addslashes($this->input->post('mobile_no')),
                    'Issuedate' => $this->date(),
                    'Expirydate' => addslashes($this->input->post('expiry_date')),
                    'ICNo' => $icno,
                    'PassportNo' =>$passno,
                    'Active' => '1',
                    'Remarks' => addslashes($this->input->post('remarks')),
                    'Gender' => $Gender,
                    'IssueStamp' => $this->datetime(),
                    'UPDATED_BY' => $_SESSION['username'],
                    'UPDATED_AT' => $this->datetime(),
                    'LastStamp' => $this->datetime(),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION['username'],
                    'NewForScript' => '1',
                    'branch' => $this->input->post('branch'),
                );
                $this->db->insert('mem_ii_trans' , $data_trans);
            }

            if($national != 'MALAYSIAN' && $national != 'MALAYSIA')
            {
                $icno = $passno;
            }
            
            $data = array(
                'PrincipalCardNo' => 'SUPCARD',
                'AccountNo' => $_SESSION['account_no'],
                'ICNo' => addslashes($icno),
                'SupCardNo' => $SupCardNo,
                'Expirydate' => addslashes($this->input->post('expiry_date')),
                'Remarks' => addslashes($this->input->post('remarks')),
                'Phonemobile' => addslashes($this->input->post('mobile_no')),
                'Relationship' => addslashes($this->input->post('relation')),
                'Active' => '1',
                'IssueStamp' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                'LastStamp' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                'UPDATED_BY' => $_SESSION['username'],
                'CREATED_BY' => $_SESSION['username'],
                'NewForScript' => 0,
                'Nationality' => $national,

                'Name' => addslashes($name_sup),
                'NameOnCard' => addslashes($nameonsupcard),
                'Birthdate' => addslashes($birthdate),
                'Gender' => $Gender,
                'email' => addslashes($this->input->post('email')),
            );
            $this->db->insert('membersupcard', $data);

            $this->db->query("UPDATE membersupcard SET rec_new = '1', rec_edit = '0' WHERE AccountNo = '".$_SESSION['account_no']."' AND SupCardNo = '".addslashes($this->input->post('card_no'))."'");

            // if preissue method. need to delete initial account at member table
            if($this->check_parameter()->row('preissue_card_method') == 1)
            {
                $get_rep_card = $this->db->query("SELECT * FROM member WHERE CardNo = '".$this->input->post('card_no')."'");
                
                $data = array(
                    'AccountNo' => $get_rep_card->row('AccountNo'),
                    'CardNo' => $get_rep_card->row('CardNo'),
                    'Name' => $get_rep_card->row('Name'),
                    'NameOnCard' => $get_rep_card->row('NameOnCard'),
                    'Address1' => $get_rep_card->row('Address1'),
                    'Address2' => $get_rep_card->row('Address2'),
                    'Address3' => $get_rep_card->row('Address3'),
                    'Address4' => $get_rep_card->row('Address4'),
                    'City' => $get_rep_card->row('City'),
                    'State' => $get_rep_card->row('State'),
                    'Postcode' => $get_rep_card->row('Postcode'),
                    'Email' => $get_rep_card->row('Email'),
                    'Phonehome' => $get_rep_card->row('Phonehome'),
                    'Phoneoffice' => $get_rep_card->row('Phoneoffice'),
                    'Phonemobile' => $get_rep_card->row('Phonemobile'),
                    'Fax' => $get_rep_card->row('Fax'),
                    'Issuedate' => $get_rep_card->row('Issuedate'),
                    'Expirydate' => $get_rep_card->row('Expirydate'),
                    'Cardtype' => $get_rep_card->row('Cardtype'),
                    'Title' => $get_rep_card->row('Title'),
                    'ICNo' => $get_rep_card->row('ICNo'),
                    'OldICNo' => $get_rep_card->row('OldICNo'),
                    'Occupation' => $get_rep_card->row('Occupation'),
                    'Employer' => $get_rep_card->row('Employer'),
                    'Birthdate' => $get_rep_card->row('Birthdate'),
                    'Principal' => $get_rep_card->row('Principal'),
                    'Active' => $get_rep_card->row('Active'),
                    'Nationality' => $get_rep_card->row('Nationality'),
                    'LimitBF' => $get_rep_card->row('LimitBF'),
                    'LimitAmt' => $get_rep_card->row('LimitAmt'),
                    'LimitAmtAdj' => $get_rep_card->row('LimitAmtAdj'),
                    'LimitAmtUsed' => $get_rep_card->row('LimitAmtUsed'),
                    'LimitAmtBalance' => $get_rep_card->row('LimitAmtBalance'),
                    'Status' => $get_rep_card->row('Status'),
                    'Race' => $get_rep_card->row('Race'),
                    'ChildrenNo' => $get_rep_card->row('ChildrenNo'),
                    'Remarks' => $get_rep_card->row('Remarks'),
                    'Religion' => $get_rep_card->row('Religion'),
                    'PointsBF' => $get_rep_card->row('PointsBF'),
                    'Points' => $get_rep_card->row('Points'),
                    'PointsAdj' => $get_rep_card->row('PointsAdj'),
                    'Pointsused' => $get_rep_card->row('Pointsused'),
                    'Pointsbalance' => $get_rep_card->row('Pointsbalance'),
                    'Income' => $get_rep_card->row('Income'),
                    'Credit' => $get_rep_card->row('Credit'),
                    'Gender' => $get_rep_card->row('Gender'),
                    'PassportNo' => $get_rep_card->row('PassportNo'),
                    'Picture' => $get_rep_card->row('Picture'),
                    'CREATED_BY' => $get_rep_card->row('CREATED_BY'),
                    'IssueStamp' => $get_rep_card->row('IssueStamp'),
                    'UPDATED_BY' => $get_rep_card->row('UPDATED_BY'),
                    'LastStamp' => $get_rep_card->row('LastStamp'),
                    'NewForScript' => $get_rep_card->row('NewForScript'),
                    'DiscLimitActive' => $get_rep_card->row('DiscLimitActive'),
                    'DiscLimitBF' => $get_rep_card->row('DiscLimitBF'),
                    'DiscLimit' => $get_rep_card->row('DiscLimit'),
                    'DiscLimitAdj' => $get_rep_card->row('DiscLimitAdj'),
                    'DiscLimitUsed' => $get_rep_card->row('DiscLimitUsed'),
                    'DiscLimitBalance' => $get_rep_card->row('DiscLimitBalance'),
                    'DiscLimitReset' => $get_rep_card->row('DiscLimitReset'),
                    'LimitReset' => $get_rep_card->row('LimitReset'),
                    'MemberType' => $get_rep_card->row('MemberType'),
                    'Terms' => $get_rep_card->row('Terms'),
                    'CreditLimit' => $get_rep_card->row('CreditLimit'),
                    'Area' => $get_rep_card->row('Area'),
                    'Region' => $get_rep_card->row('Region'),
                    'comp_address' => $get_rep_card->row('comp_address'),
                    'comp_postcode' => $get_rep_card->row('comp_postcode'),
                    'comp_email' => $get_rep_card->row('comp_email'),
                    'biz_nature' => $get_rep_card->row('biz_nature'),
                    'biz_category' => $get_rep_card->row('biz_category'),
                    'created_at' => $get_rep_card->row('created_at'),
                    'updated_at' => $get_rep_card->row('updated_at'),
                    'staff' => $get_rep_card->row('staff'),
                    'rsupdate' => $get_rep_card->row('rsupdate'),
                    'branch' => $get_rep_card->row('branch'),
                    'referral_id' => $get_rep_card->row('referral_id'),
                    'recruiter_id' => $get_rep_card->row('recruiter_id'),
                    'name_first' => $get_rep_card->row('name_first'),
                    'name_last' => $get_rep_card->row('name_last'),
                    'replace_at' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                    'replace_by' => $_SESSION['username'],
                    'replace_type' => 'SUP CARD',
                );
                $this->db->insert('member_replaced', $data);
                // insert replacement
                
                $this->db->query("UPDATE member_replaced SET rec_new = '".$get_rep_card->row('rec_new')."', rec_edit = '".$get_rep_card->row('rec_edit')."' WHERE AccountNo = '".$get_rep_card->row('AccountNo')."' AND CardNo = '".$get_rep_card->row('CardNo')."'");
                $this->db->query("DELETE FROM member WHERE CardNo = '".$this->input->post('card_no')."'");

                //mem_server to update all branch
                $server = array(
                    // 'refno' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') AS uuid ")->row('uuid'),
                    'SqlScript' => "DELETE FROM member WHERE CardNo = '".$this->input->post('card_no')."' AND AccountNo = '".$get_rep_card->row('AccountNo')."' ",
                    // 'CreatedDateTime' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                    'CreatedBy' => 'Point.cal:web_member',
                    // 'Status' => '0',
                    // 'KeyField' => '',
                );
                // $this->db->insert('mem_server.sqlscript', $server);
                $this->insert_sqlscript($server);
            }

            $data = array(
                'Trans_type' => 'ISSUE SUP CARD',
                'ReferenceNo' => addslashes($this->input->post('reason')),
                'AccountNo' => $_SESSION['account_no'],
                'ReceiptNo' => $_SESSION['receipt_no'],
                'field' => 'supcardno',
                'value_to' => $SupCardNo,
                'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                'expiry_date_after' => addslashes($this->input->post('expiry_date')),
                'created_at' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                'created_by' => $_SESSION['username'],
                );
            $this->db->insert('user_logs', $data);

            if($this->db->affected_rows() > 0)
            {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');

                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                if($this->check_parameter()->row('preissue_card_method') == 1)
                {
                    redirect('Transaction_c/issue_sup_card');
                }
                else
                {
                    /*redirect('Transaction_c/issue_sup_card?created='.$account_no);*/
                    redirect('Transaction_c/issue_sup_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&Nationality='.$_SESSION['Nationality'].'&created='.$SupCardNo.'&name='.$name_sup.'&nameoncard='.$nameonsupcard);
                }
            }
            else
            {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');

                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Failed ! !<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/issue_sup_card');
            }
        } 
        else
        {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0); 
            ini_set('memory_limit','2048M');

            redirect('login_c');
        }
    }

    public function lost_card()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['scan_card']))
            {
                // $get_data = $this->db->query("SELECT * FROM `member` WHERE CardNo = '".$this->input->post('card_no')."' ");
                if(isset($_REQUEST['select']))
                {
                    $key = $_REQUEST['select'];
                }
                else
                {
                    $key = $this->input->post('card_no');
                }

                $get_data = $this->Search_Model->search_card($key);
                if($get_data->num_rows() == 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Card Not Found!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/lost_card');
                }
                else
                {
                    if($get_data->num_rows() == 1)
                    {
                        $check_lost_card = $this->db->query("SELECT LostCardNo FROM memberlostcard WHERE LostCardNo = '".$get_data->row('CardNo')."'");

                        if($check_lost_card->num_rows() > 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This Card Already Lost. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/lost_card');
                        }

                        $check_active_card = $this->db->query("SELECT * FROM member WHERE Issuedate < Expirydate AND Active = 1 AND CardNo = '".$get_data->row('CardNo')."' 
                        UNION ALL
                        SELECT a.* FROM member a 
                        INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE b.Active = 1 AND supcardno = '".$get_data->row('CardNo')."' ");
                        //echo $this->db->last_query();die;
                        if($check_active_card->num_rows() == 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This Card does not active. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/lost_card');
                        }

                        $check_preactive_card = $this->db->query("SELECT AccountNo FROM member WHERE NAME = 'PREACTIVATED' AND Expirydate = '3000-12-31' AND CardNo = '".$key."'");
                        if($check_preactive_card->num_rows() == 1 && $this->check_parameter()->row('preissue_card_method') == 1)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$this->input->post('card_no').' is preactive card. Please active card.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/lost_card');
                        }

                        redirect('Transaction_c/lost_card?exist_card='.$get_data->row('CardNo').'&account='.$get_data->row('AccountNo').'&ic_no='.$get_data->row('ICNo').'&active='.$get_data->row('Active').'&mobile_no='.$get_data->row('Phonemobile').'&Name='.$get_data->row('Name').'&Passport_No='.$get_data->row('PassportNo').'&Nationality='.$get_data->row('Nationality'));
                    }
                    else
                    {
                        redirect('Transaction_c/lost_card?multiple='.$key);
                    }
                   
                }
                $style = 'display: block;';
                $result = 'hidden';
                $record = $get_data;
                $form = 'Transaction_c/save_sup_card_lost';
                $form1 = 'Transaction_c/lost_card';

            }
            elseif(isset($_REQUEST['exist_card']))
            {
                $_SESSION['Nationality'] = $_REQUEST['Nationality'];
                $_SESSION['Name'] = $_REQUEST['Name'];
                $_SESSION['Passport_No'] = $_REQUEST['Passport_No'];
                $_SESSION['mobile_no'] = $_REQUEST['mobile_no'];
                $_SESSION['active'] = $_REQUEST['active'];
                $_SESSION['card_no'] = $_REQUEST['exist_card'];
                $_SESSION['account_no'] = $_REQUEST['account'];
                $_SESSION['ic_no'] = $_REQUEST['ic_no'];
                $_SESSION['hidden_result'] = '';
                $style = 'display: block;';
                $form = 'Transaction_c/save_sup_card_lost';
                $form1 = 'Transaction_c/lost_card';
                $record = '';
            }
            else
            {   
                $_SESSION['Nationality'] = '';
                $_SESSION['Name'] = '';
                $_SESSION['Passport_No'] = '';   
                $_SESSION['mobile_no'] = '';
                $_SESSION['active'] = '';
                $_SESSION['card_no'] = '';
                $_SESSION['account_no'] = '';
                $_SESSION['ic_no'] = '';
                $_SESSION['hidden_result'] = 'hidden';
                $style = 'display: none;';
                $form = 'Transaction_c/save_sup_card_lost';
                $form1 = 'Transaction_c/lost_card';
                if(isset($_REQUEST['multiple']))
                {
                    $record = $this->Search_Model->search_card($_REQUEST['multiple']);    
                }
                else
                {
                    $record = '';
                }
                
            }

        if(isset($_REQUEST['created']))
           {
                $cardno = $_REQUEST['created'];
           }
           else
           {
                $cardno = '';
           }

            $get_account_data = $this->db->query("SELECT * FROM member WHERE AccountNo = '".$_SESSION['account_no']."' ");
            $get_preset_expiry_date = $this->db->query("SELECT CURDATE()+INTERVAL (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');

            $data = array(

                /*'need_receipt_no' => $this->db->query("SELECT receipt_no_lostcard FROM `set_parameter`;")->row('receipt_no_lostcard'),*/
                /*'branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),*/
                // 'branch' => $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name, c.receipt_lost FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY b.branch_code ASC"),
                'button' => 'Lost Card',
                'branch' => $this->branch_with_receipt(),
                'field' => 'receipt_lost',
                'reason' => $this->db->query("SELECT * FROM set_reason where type = 'LOST' "),
                'style' => $style,
                'form' => $form,
                'form1' => $form1,
                'record' => $record,
                'preisse_method' => $this->check_parameter()->row('preissue_card_method'),
                'get_created' => $this->db->query("SELECT * FROM membersupcard a WHERE a.SupCardNo = '$cardno' "),

            );

            $this->template->load('template' , 'lost_card', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function replace_card()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['scan_card']))
            {
                // $get_data = $this->db->query("SELECT * FROM `member` WHERE CardNo = '".$this->input->post('card_no')."' ");
                if(isset($_REQUEST['select']))
                {
                    $key = $_REQUEST['select'];
                }
                else
                {
                    $key = $this->input->post('card_no');
                }

                $get_data = $this->Search_Model->search_card($key);
                if($get_data->num_rows() == 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Card Not Found!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/replace_card');
                }
                else
                {
                    if($get_data->num_rows() == 1)
                    {
                        $check_lost_card = $this->db->query("SELECT LostCardNo FROM memberlostcard WHERE LostCardNo = '".$get_data->row('CardNo')."'");

                        if($check_lost_card->num_rows() > 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This Card Already Lost. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/replace_card');
                        }

                        $check_active_card = $this->db->query("SELECT * FROM member WHERE Issuedate < Expirydate AND Active = 1 AND CardNo = '".$get_data->row('CardNo')."' 
                        UNION ALL
                        SELECT a.* FROM member a 
                        INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE b.Active = 1 AND supcardno = '".$get_data->row('CardNo')."' ");
                        //echo $this->db->last_query();die;
                        if($check_active_card->num_rows() == 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This Card does not active. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/replace_card');
                        }

                        $check_preactive_card = $this->db->query("SELECT AccountNo FROM member WHERE NAME = 'PREACTIVATED' AND Expirydate = '3000-12-31' AND CardNo = '".$key."'");
                        if($check_preactive_card->num_rows() == 1 && $this->check_parameter()->row('preissue_card_method') == 1)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$this->input->post('card_no').' is preactive card. Please active card.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/replace_card');
                        }

                        redirect('Transaction_c/replace_card?exist_card='.$get_data->row('CardNo').'&account='.$get_data->row('AccountNo').'&ic_no='.$get_data->row('ICNo').'&active='.$get_data->row('Active').'&mobile_no='.$get_data->row('Phonemobile').'&Name='.$get_data->row('Name').'&Passport_No='.$get_data->row('PassportNo').'&Nationality='.$get_data->row('Nationality').'&Expirydate='.$get_data->row('Expirydate'));
                    }
                    else
                    {
                        redirect('Transaction_c/replace_card?multiple='.$key);
                    }
                   
                }
                $style = 'display: block;';
                $result = 'hidden';
                $record = $get_data;
                $form = 'Transaction_c/save_replace_card';
                $form1 = 'Transaction_c/replace_card';

            }
            elseif(isset($_REQUEST['exist_card']))
            {
                $_SESSION['Nationality'] = $_REQUEST['Nationality'];
                $_SESSION['Name'] = $_REQUEST['Name'];
                $_SESSION['Passport_No'] = $_REQUEST['Passport_No'];
                $_SESSION['mobile_no'] = $_REQUEST['mobile_no'];
                $_SESSION['active'] = $_REQUEST['active'];
                $_SESSION['card_no'] = $_REQUEST['exist_card'];
                $_SESSION['account_no'] = $_REQUEST['account'];
                $_SESSION['ic_no'] = $_REQUEST['ic_no'];
                $_SESSION['Expirydate'] = $_REQUEST['Expirydate'];
                $_SESSION['hidden_result'] = '';
                $style = 'display: block;';
                $record = '';
                $form = 'Transaction_c/save_replace_card';
                $form1 = 'Transaction_c/replace_card';
            }
            else
            {   
                $_SESSION['Nationality'] = '';
                $_SESSION['Name'] = '';
                $_SESSION['Passport_No'] = '';   
                $_SESSION['mobile_no'] = '';
                $_SESSION['active'] = '';
                $_SESSION['card_no'] = '';
                $_SESSION['account_no'] = '';
                $_SESSION['ic_no'] = '';
                $_SESSION['Expirydate'] = '';
                $_SESSION['hidden_result'] = 'hidden';
                $style = 'display: none;';
                $form = 'Transaction_c/save_replace_card';
                $form1 = 'Transaction_c/replace_card';
                if(isset($_REQUEST['multiple']))
                {
                    $record = $this->Search_Model->search_card($_REQUEST['multiple']);    
                }
                else
                {
                    $record = '';
                }
                
            }

        if(isset($_REQUEST['created']))
           {
                $cardno = $_REQUEST['created'];
           }
           else
           {
                $cardno = '';
           }

            $get_account_data = $this->db->query("SELECT * FROM member WHERE AccountNo = '".$_SESSION['account_no']."' ");
            $get_preset_expiry_date = $this->db->query("SELECT CURDATE()+INTERVAL (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
            //echo var_dump($record);die;

            $data = array(

                'button' => 'Replace Card',
                'branch' => $this->branch_with_receipt(),
                'field' => 'receipt_replace',
                'reason' => $this->db->query("SELECT * FROM set_reason where type = 'REPLACE' "),
                'style' => $style,
                'form' => $form,
                'form1' => $form1,
                'record' => $record,
                'preisse_method' => $this->check_parameter()->row('preissue_card_method'),
                'get_created' => $this->db->query("SELECT * FROM membersupcard a WHERE a.SupCardNo = '$cardno' "),

            );

            $this->template->load('template' , 'lost_card', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_sup_card_lost()
    {
        // $check_ic_no = $this->db->query("SELECT * FROM (
        //     SELECT ICNo FROM member WHERE ICNo = '".$this->input->post('ic_no')."' 
        //     UNION ALL
        //     SELECT ICNo FROM membersupcard WHERE ICNo = '".$this->input->post('ic_no')."')a1");


            // if($check_ic_no->num_rows() > 0)
            // {
            //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">IC No already exist!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            //     redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no']);
            // };

            $accountno = $this->input->post('accountno');

            if($accountno == '')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable to save as session expired, please login again! <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
            };

            /*check if card no is new and pre issue method is active then prompt error*/
            $check_valid = $this->db->query("SELECT Active FROM member WHERE NAME = 'NEW' AND CardNo = '".$this->input->post('card_no')."' ");
            if($check_valid->num_rows() == 0 && $this->check_parameter()->row('preissue_card_method') == 1)
            {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');

                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$this->input->post('card_no').' has been used.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
            }

            $check_card_no = $this->db->query("SELECT * FROM member a INNER JOIN membersupcard b ON a.`AccountNo` = b.`AccountNo` WHERE b.`SupCardNo` = '".$this->input->post('card_no')."'");
            // check valid card no to allow supcard/lost card process

            if($check_card_no->num_rows() > 0)
            {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');

                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card No already exist!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
            };

            /*$need_receipt_no = $this->db->query("SELECT receipt_no_lostcard FROM `set_parameter`;")->row('receipt_no_lostcard');*/
            $need_receipt_no = $this->db->query("SELECT receipt_lost FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch')."' ")->row('receipt_lost');
                if($need_receipt_no == 1)
                {
                    if($this->input->post('receipt_no') == '')
                    {
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', 0); 
                        ini_set('memory_limit','2048M');

                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please fill in receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                    };

                    if(!in_array('BPRN', $_SESSION['module_code']))
                    {
                        $_SESSION['receipt_no'] = $this->input->post('receipt_no');

                        $check_check_receipt_itemcode = $this->db->query("SELECT a.`check_receipt_itemcode` FROM set_parameter a;")->row('check_receipt_itemcode');

                        //$check_receipt_setup = $this->db->query("SELECT receipt_no_amount_lostcard FROM `set_parameter`;")->row('receipt_no_amount_lostcard');

                        if($check_check_receipt_itemcode == 0) //check amount (all outlets)
                        {
                            $check_receipt_setup = $this->db->query("SELECT receipt_no_amount_lostcard FROM `set_parameter` ")->row('receipt_no_amount_lostcard');
                        }
                        elseif($check_check_receipt_itemcode == 2) //check amount (based outlets)
                        {
                            $check_receipt_setup = $this->db->query("SELECT amount_lost FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch')."' ")->row('amount_lost');
                        }
                        else
                        {
                            $check_receipt_setup = '0';
                        }

                        //$check_receipt = $this->db->query("SELECT a.`BillAmt`,b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND b.Refno = '".$this->input->post('receipt_no')."' ");
                        
                        // if($this->check_parameter()->row('check_receipt_itemcode') == 1)
                        // {
                        //     $check_receipt = $this->Trans_Model->check_receipt_no_child($this->input->post('receipt_no'));
                        //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_child($this->input->post('receipt_no'));
                        // }
                        // else
                        // {
                        //     $check_receipt = $this->Trans_Model->check_receipt_no_main($this->input->post('receipt_no'));
                        //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_main($this->input->post('receipt_no'));
                        // }

                        $check_itemcode = $this->db->query("SELECT * FROM set_itemcode WHERE name = 'lostcard' ");

                        $data = array(
                            'refno' => $this->input->post('receipt_no'),
                        );

                        $result = $this->Member_Model->query_call('Transaction_c', 'save_renew', $data);
                        $check_receipt = $result['check_receipt'];

                        // $check_exist_receipt = $this->db->query("SELECT * FROM frontend.posmain WHERE RefNo = '".$this->input->post('receipt_no')."'");

                        // if($check_exist_receipt->num_rows() == 0)//if not found
                        if($result['message'] != 'success')
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                             redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                        }
                        // elseif($check_receipt_void->num_rows() == 1)//if receipt void
                        // {
                        //     ini_set('memory_limit', '-1');
                        //     ini_set('max_execution_time', 0); 
                        //     ini_set('memory_limit','2048M');

                        //     $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt Already Voided !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        //     redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                        // }
                        else
                        {
                            $check_receipt_day = $this->db->query("SELECT check_receipt_day FROM set_parameter ")->row('check_receipt_day');
                            $get_days = $this->db->query("SELECT TIMESTAMPDIFF(DAY, '".$check_receipt[0]['BizDate']."', CURDATE()) AS day ")->row('day');

                            if(($check_check_receipt_itemcode == 0 || $check_check_receipt_itemcode == 2) && $check_receipt[0]['BillAmt'] < $check_receipt_setup)// if setup not check itemcode and bill amount less than tamount setup
                            {
                                ini_set('memory_limit', '-1');
                                ini_set('max_execution_time', 0); 
                                ini_set('memory_limit','2048M');

                                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Receipt Amount Not Enough !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                            }
                            /*elseif($check_receipt->row('BizDate') <> $this->db->query("SELECT CURDATE() AS curr_date")->row('curr_date'))*/
                            elseif($get_days > $check_receipt_day)
                                {
                                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid receipt date. !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                     redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                                }
                            elseif($check_check_receipt_itemcode == 1)
                            {
                                // $check_receipt = $this->db->query("SELECT b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND b.Refno = '".$this->input->post('receipt_no')."' AND b.itemcode = '".$check_itemcode->row('itemcode')."' ");

                                // if($check_receipt->num_rows() == 0)//if not found
                                // {
                                //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for replacement card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                //     redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                                // }

                                $data = array(
                                        'refno' => $this->input->post('receipt_no'),
                                        'itemcode' => $check_itemcode->row('itemcode'),
                                    );

                                $check_receipt = $this->Member_Model->query_call('Transaction_c', 'save_renew1', $data);

                                if($check_receipt['message'] != 'success')
                                {
                                    if($check_receipt['message'] == 'Unable find itemcode for renew card on this receipt no.Please make payment to proceed this transaction.')
                                    {
                                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for replacement card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    }
                                    else
                                    {
                                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$check_receipt['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    }

                                    redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                                }
                            }
                        }

                        $receipt_no = $_SESSION['receipt_no'];
                        if($this->check_exist_receipt_no($receipt_no)->num_rows() > 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt No Already Exist In Record !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                        };
                    }
                    else
                    {
                        if($this->input->post('receipt_no') != '-')
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please use "-" for bypass receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                        };

                        $_SESSION['receipt_no'] = $this->input->post('receipt_no');
                    }
                    
                }
                else
                {
                    $_SESSION['receipt_no'] = "";
                }

            // $get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$this->input->post('years')."' YEAR AS Expirydate")->row('Expirydate');
            $get_account_data = $this->db->query("
                    SELECT Title, ICNo, Name, NameOnCard, Expirydate, CardNo,
                    Active, OldICNo, Birthdate, Principal, Nationality, Gender, Email, Remarks, Expirydate, 
                    'LOSTCARD' AS card, register_online, register_date, CardNo AS OldCardNo, '' AS Relationship, PhoneMobile FROM member WHERE AccountNo = '".$accountno."' AND CardNo = '".$_SESSION['card_no']."'
                    UNION ALL
                    SELECT b.Title, b.ICNo, b.Name, b.NameOnCard, b.Expirydate, b.SupcardNo AS CardNo,
                    b.Active, b.OldICNo, b.Birthdate, b.Principal, b.Nationality, b.Gender, 
                    b.Email, b.Remarks, b.Expirydate,
                    IF(b.PrincipalCardNo = 'LOSTCARD','LOSTCARD', 'LOSTSUPCARD') AS card, b.register_online, b.register_date, IF(b.OldCardNo IS NULL OR b.OldCardNo = '', b.SupcardNo, b.OldCardNo) AS OldCardNo, b.Relationship, b.PhoneMobile FROM member AS a
                    INNER JOIN membersupcard AS b ON a.AccountNo = b.AccountNo
                    WHERE b.AccountNo = '".$accountno."' AND b.SupCardNo = '".$_SESSION['card_no']."'
                ");

            // if not use preisse card no, system auto create ne card no
            if($this->check_parameter()->row('preissue_card_method') == '0')
            {
                $account_no = $this->Trans_Model->generate_card_no($this->input->post('branch'));
                $SupCardNo = $account_no;
            }
            else
            {
                $SupCardNo = addslashes($this->input->post('card_no'));
            }
            
            // if not use preisse card no, system auto create ne card no
            if($this->check_parameter()->row('preissue_card_method') == '0')
            {
                $data_trans = array(

                    'TRANS_GUID' => $this->guid(),
                    'TRANS_TYPE' => 'LOST MAIN' ,
                    'REF_NO' => addslashes($this->input->post('receipt_no')),
                    'AccountNo' => $accountno,
                    'CardNo' => $_SESSION['card_no'],
                    'CardNoNew' => $account_no,
                    'Name' => addslashes($this->input->post('Name')),
                    'NameOnCard' => addslashes($this->input->post('NameOnCard')),
                   
                    'Phonemobile' => addslashes($this->input->post('mobile_no')),
                    'Issuedate' => $this->date(),
                    'Expirydate' => addslashes($this->input->post('expiry_date')),
                    'ICNo' => addslashes($this->input->post('ic_no')),
                    'Active' => '1',
                    'Remarks' => addslashes($this->input->post('remarks')),
                    'Gender' => $get_account_data->row('Gender'),
                    
                    'IssueStamp' => $this->datetime(),
                    'UPDATED_BY' => $_SESSION['username'],
                    'UPDATED_AT' => $this->datetime(),
                    'LastStamp' => $this->datetime(),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION['username'],
                    'NewForScript' => '1',
                   
                    'branch' => $this->input->post('branch'),
                );
                $this->db->insert('mem_ii_trans' , $data_trans);
            }

            $data = array(
                'PrincipalCardNo' => $get_account_data->row('card'),
                'AccountNo' => $accountno,
                'Title' => $get_account_data->row('Title'),
                'ICNo' => addslashes($this->input->post('ic_no')),
                'SupCardNo' => $SupCardNo,
                'Name' => $get_account_data->row('Name'),
                'NameOnCard' => $get_account_data->row('NameOnCard'),
                'Expirydate' => $get_account_data->row('Expirydate'),
                'Remarks' => addslashes($this->input->post('remarks')),
                'Phonemobile' => str_replace(' ', '', addslashes('+'.$this->input->post('mobile_no'))),
                'Active' => $get_account_data->row('Active'),
                'OldICNo' => $get_account_data->row('OldICNo'),
                'Birthdate' => $get_account_data->row('Birthdate'),
                'Principal' => $get_account_data->row('Principal'),
                'Nationality' => $this->db->query("SELECT LEFT('".$get_account_data->row('Nationality')."', 9) AS nation")->row('nation'),
                'Gender' => $get_account_data->row('Gender'),
                'email' => $get_account_data->row('Email'),
                'Remarks' => $get_account_data->row('Remarks'),
                "register_online" => $get_account_data->row('register_online'),
                "register_date" => $get_account_data->row('register_date'),
                "OldCardNo" => $get_account_data->row('OldCardNo'),
                // 'branch' => $get_account_data->row('branch'),
                'IssueStamp' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                'LastStamp' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                'UPDATED_BY' => $_SESSION['username'],
                'CREATED_BY' => $_SESSION['username'],
                'NewForScript' => 1,
            );
            $this->db->insert('membersupcard', $data);

            $data = array(
                "AccountNo" => $accountno,
                "LostCardNo" => $get_account_data->row('CardNo'),
                "Name" => $get_account_data->row('Name'),
                "NameOnCard" => $get_account_data->row('NameOnCard'),
                "Title" => $get_account_data->row('Title'),
                "ICNo" => $get_account_data->row('ICNo'),
                "OldICNo" => $get_account_data->row('OldICNo'),
                "Nationality" => $get_account_data->row('Nationality'),
                "Relationship" => $get_account_data->row('Relationship'),
                "Birthdate" => $get_account_data->row('Birthdate'),
                "Gender" => $get_account_data->row('Gender'),
                "Principal" => $get_account_data->row('Principal'),
                "PhoneMobile" => $get_account_data->row('PhoneMobile'),
                "SubstituteCardNo" => $SupCardNo,
                "CreateDate" => $this->db->query("SELECT CURDATE() AS cur_date")->row('cur_date'),
                "CreateTime" => $this->db->query("SELECT CURTIME() AS cur_time")->row('cur_time'),
            );
            $this->db->insert('memberlostcard', $data);
            
            $this->db->query("UPDATE membersupcard SET rec_new = '1', rec_edit = '0' WHERE AccountNo = '$accountno' AND SupCardNo = '".addslashes($this->input->post('card_no'))."'");

            if($get_account_data->row('card') == 'LOSTSUPCARD')
            {
                $replace_type = "LOST SUPCARD";
            }
            else
            {
                $replace_type = "LOST CARD";
            }

            //user_logs
            $data = array(
                'Trans_type' => 'REPLACE '.$replace_type,
                'AccountNo' => $accountno,
                'ReferenceNo' => addslashes($this->input->post('reason')),
                'ReceiptNo' => $_SESSION['receipt_no'],
                'field' => 'CardNo',
                'value_from' => $get_account_data->row('CardNo'),
                'value_to' => $SupCardNo,
                'expiry_date_before' => $get_account_data->row('Expirydate'),
                'expiry_date_after' => $get_account_data->row('Expirydate'),
                'created_at' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                'created_by' => $_SESSION['username'],
            );
            $this->db->insert('user_logs', $data);

            // if preissue method. need to delete initial account at member table
            if($this->check_parameter()->row('preissue_card_method') == 1)
            {
                $get_rep_card = $this->db->query("SELECT * FROM member WHERE CardNo = '".$this->input->post('card_no')."'");
                
                $data = array(
                    'AccountNo' => $get_rep_card->row('AccountNo'),
                    'CardNo' => $get_rep_card->row('CardNo'),
                    'Name' => $get_rep_card->row('Name'),
                    'NameOnCard' => $get_rep_card->row('NameOnCard'),
                    'Address1' => $get_rep_card->row('Address1'),
                    'Address2' => $get_rep_card->row('Address2'),
                    'Address3' => $get_rep_card->row('Address3'),
                    'Address4' => $get_rep_card->row('Address4'),
                    'City' => $get_rep_card->row('City'),
                    'State' => $get_rep_card->row('State'),
                    'Postcode' => $get_rep_card->row('Postcode'),
                    'Email' => $get_rep_card->row('Email'),
                    'Phonehome' => $get_rep_card->row('Phonehome'),
                    'Phoneoffice' => $get_rep_card->row('Phoneoffice'),
                    'Phonemobile' => $get_rep_card->row('Phonemobile'),
                    'Fax' => $get_rep_card->row('Fax'),
                    'Issuedate' => $get_rep_card->row('Issuedate'),
                    'Expirydate' => $get_rep_card->row('Expirydate'),
                    'Cardtype' => $get_rep_card->row('Cardtype'),
                    'Title' => $get_rep_card->row('Title'),
                    'ICNo' => $get_rep_card->row('ICNo'),
                    'OldICNo' => $get_rep_card->row('OldICNo'),
                    'Occupation' => $get_rep_card->row('Occupation'),
                    'Employer' => $get_rep_card->row('Employer'),
                    'Birthdate' => $get_rep_card->row('Birthdate'),
                    'Principal' => $get_rep_card->row('Principal'),
                    'Active' => $get_rep_card->row('Active'),
                    'Nationality' => $get_rep_card->row('Nationality'),
                    'LimitBF' => $get_rep_card->row('LimitBF'),
                    'LimitAmt' => $get_rep_card->row('LimitAmt'),
                    'LimitAmtAdj' => $get_rep_card->row('LimitAmtAdj'),
                    'LimitAmtUsed' => $get_rep_card->row('LimitAmtUsed'),
                    'LimitAmtBalance' => $get_rep_card->row('LimitAmtBalance'),
                    'Status' => $get_rep_card->row('Status'),
                    'Race' => $get_rep_card->row('Race'),
                    'ChildrenNo' => $get_rep_card->row('ChildrenNo'),
                    'Remarks' => $get_rep_card->row('Remarks'),
                    'Religion' => $get_rep_card->row('Religion'),
                    'PointsBF' => $get_rep_card->row('PointsBF'),
                    'Points' => $get_rep_card->row('Points'),
                    'PointsAdj' => $get_rep_card->row('PointsAdj'),
                    'Pointsused' => $get_rep_card->row('Pointsused'),
                    'Pointsbalance' => $get_rep_card->row('Pointsbalance'),
                    'Income' => $get_rep_card->row('Income'),
                    'Credit' => $get_rep_card->row('Credit'),
                    'Gender' => $get_rep_card->row('Gender'),
                    'PassportNo' => $get_rep_card->row('PassportNo'),
                    'Picture' => $get_rep_card->row('Picture'),
                    'CREATED_BY' => $get_rep_card->row('CREATED_BY'),
                    'IssueStamp' => $get_rep_card->row('IssueStamp'),
                    'UPDATED_BY' => $get_rep_card->row('UPDATED_BY'),
                    'LastStamp' => $get_rep_card->row('LastStamp'),
                    'NewForScript' => $get_rep_card->row('NewForScript'),
                    'DiscLimitActive' => $get_rep_card->row('DiscLimitActive'),
                    'DiscLimitBF' => $get_rep_card->row('DiscLimitBF'),
                    'DiscLimit' => $get_rep_card->row('DiscLimit'),
                    'DiscLimitAdj' => $get_rep_card->row('DiscLimitAdj'),
                    'DiscLimitUsed' => $get_rep_card->row('DiscLimitUsed'),
                    'DiscLimitBalance' => $get_rep_card->row('DiscLimitBalance'),
                    'DiscLimitReset' => $get_rep_card->row('DiscLimitReset'),
                    'LimitReset' => $get_rep_card->row('LimitReset'),
                    'MemberType' => $get_rep_card->row('MemberType'),
                    'Terms' => $get_rep_card->row('Terms'),
                    'CreditLimit' => $get_rep_card->row('CreditLimit'),
                    'Area' => $get_rep_card->row('Area'),
                    'Region' => $get_rep_card->row('Region'),
                    'comp_address' => $get_rep_card->row('comp_address'),
                    'comp_postcode' => $get_rep_card->row('comp_postcode'),
                    'comp_email' => $get_rep_card->row('comp_email'),
                    'biz_nature' => $get_rep_card->row('biz_nature'),
                    'biz_category' => $get_rep_card->row('biz_category'),
                    'created_at' => $get_rep_card->row('created_at'),
                    'updated_at' => $get_rep_card->row('updated_at'),
                    'staff' => $get_rep_card->row('staff'),
                    'rsupdate' => $get_rep_card->row('rsupdate'),
                    'branch' => $get_rep_card->row('branch'),
                    'referral_id' => $get_rep_card->row('referral_id'),
                    'recruiter_id' => $get_rep_card->row('recruiter_id'),
                    'name_first' => $get_rep_card->row('name_first'),
                    'name_last' => $get_rep_card->row('name_last'),
                    'replace_at' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                    'replace_by' => $_SESSION['username'],
                    'replace_type' => $replace_type,
                );
                $this->db->insert('member_replaced', $data);
                // insert replacement
                $this->db->query("UPDATE member_replaced SET rec_new = '".$get_rep_card->row('rec_new')."', rec_edit = '".$get_rep_card->row('rec_edit')."' WHERE AccountNo = '".$get_rep_card->row('AccountNo')."' AND CardNo = '".$get_rep_card->row('CardNo')."'");
                $this->db->query("DELETE FROM member WHERE CardNo = '".$this->input->post('card_no')."'");
                //delete card at member table

                // $data = array(
                //     'Active' => 0
                // );
                // $this->db->WHERE('AccountNo',$_SESSION['account_no']);
                // $this->db->update('member', $data);// set old card no as in active

                //mem_server
                $server = array(
                    // 'refno' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') AS uuid ")->row('uuid'),
                    'SqlScript' => "DELETE FROM member WHERE CardNo = '".$this->input->post('card_no')."' AND AccountNo = '".$get_rep_card->row('AccountNo')."' ",
                    // 'CreatedDateTime' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                    'CreatedBy' => 'Point.cal:web_member',
                    // 'Status' => '0',
                    // 'KeyField' => '',
                );
                // $this->db->insert('mem_server.sqlscript', $server);
                $this->insert_sqlscript($server);
            }
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                
                if($this->check_parameter()->row('preissue_card_method') == 1)
                {
                    redirect('Transaction_c/lost_card');
                }
                else
                {
                    /*redirect('Transaction_c/issue_sup_card?created='.$account_no);*/
                    redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&created='.$account_no);
                }
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Failed ! !<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/lost_card');
            }
    }

    public function save_replace_card()
    {
            $accountno = $this->input->post('accountno');

            if($accountno == '')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable to save as session expired, please login again! <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
            };

            /*check if card no is new and pre issue method is active then prompt error*/
            $check_valid = $this->db->query("SELECT Active FROM member WHERE NAME = 'NEW' AND CardNo = '".$this->input->post('card_no')."' ");
            if($check_valid->num_rows() == 0 && $this->check_parameter()->row('preissue_card_method') == 1)
            {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');

                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$this->input->post('card_no').' has been used.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
            };

            $check_card_no = $this->db->query("SELECT * FROM member a INNER JOIN membersupcard b ON a.`AccountNo` = b.`AccountNo` WHERE b.`SupCardNo` = '".$this->input->post('card_no')."'");
            // check valid card no to allow supcard/lost card process

            if($check_card_no->num_rows() > 0)
            {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');

                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card No already exist!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
            };

            /*$need_receipt_no = $this->db->query("SELECT receipt_no_lostcard FROM `set_parameter`;")->row('receipt_no_lostcard');*/
            $need_receipt_no = $this->db->query("SELECT receipt_replace FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch')."' ")->row('receipt_replace');
                if($need_receipt_no == 1)
                {
                    if($this->input->post('receipt_no') == '')
                    {
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', 0); 
                        ini_set('memory_limit','2048M');

                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please fill in receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
                    };

                    if(!in_array('BPRN', $_SESSION['module_code']))
                    {
                        $_SESSION['receipt_no'] = $this->input->post('receipt_no');

                        $check_check_receipt_itemcode = $this->db->query("SELECT a.`check_receipt_itemcode` FROM set_parameter a;")->row('check_receipt_itemcode');

                        //$check_receipt_setup = $this->db->query("SELECT receipt_no_amount_lostcard FROM `set_parameter`;")->row('receipt_no_amount_lostcard');

                        if($check_check_receipt_itemcode == 0) //check amount (all outlets)
                        {
                            $check_receipt_setup = $this->db->query("SELECT receipt_no_amount_replace FROM `set_parameter` ")->row('receipt_no_amount_replace');
                        }
                        elseif($check_check_receipt_itemcode == 2) //check amount (based outlets)
                        {
                            $check_receipt_setup = $this->db->query("SELECT amount_replace FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch')."' ")->row('amount_replace');
                        }
                        else
                        {
                            $check_receipt_setup = '0';
                        }

                        //$check_receipt = $this->db->query("SELECT a.`BillAmt`,b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND b.Refno = '".$this->input->post('receipt_no')."' ");
                        
                        // if($this->check_parameter()->row('check_receipt_itemcode') == 1)
                        // {
                        //     $check_receipt = $this->Trans_Model->check_receipt_no_child($this->input->post('receipt_no'));
                        //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_child($this->input->post('receipt_no'));
                        // }
                        // else
                        // {
                        //     $check_receipt = $this->Trans_Model->check_receipt_no_main($this->input->post('receipt_no'));
                        //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_main($this->input->post('receipt_no'));
                        // }

                        $check_itemcode = $this->db->query("SELECT * FROM set_itemcode WHERE name = 'replacecard' ");

                        $data = array(
                            'refno' => $this->input->post('receipt_no'),
                        );

                        $result = $this->Member_Model->query_call('Transaction_c', 'save_renew', $data);
                        $check_receipt = $result['check_receipt'];

                        // $check_exist_receipt = $this->db->query("SELECT * FROM frontend.posmain WHERE RefNo = '".$this->input->post('receipt_no')."'");

                        if($result['message'] != 'success')
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                             redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
                        }
                        // elseif($check_receipt_void->num_rows() == 1)//if receipt void
                        // {
                        //     ini_set('memory_limit', '-1');
                        //     ini_set('max_execution_time', 0); 
                        //     ini_set('memory_limit','2048M');

                        //     $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt Already Voided !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        //     redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                        // }
                        else
                        {
                            $check_receipt_day = $this->db->query("SELECT check_receipt_day FROM set_parameter ")->row('check_receipt_day');
                            $get_days = $this->db->query("SELECT TIMESTAMPDIFF(DAY, '".$check_receipt[0]['BizDate']."', CURDATE()) AS day ")->row('day');

                            if(($check_check_receipt_itemcode == 0 || $check_check_receipt_itemcode == 2) && $check_receipt[0]['BillAmt'] < $check_receipt_setup)// if setup not check itemcode and bill amount less than tamount setup
                            {
                                ini_set('memory_limit', '-1');
                                ini_set('max_execution_time', 0); 
                                ini_set('memory_limit','2048M');

                                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Receipt Amount Not Enough !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
                            }
                            /*elseif($check_receipt->row('BizDate') <> $this->db->query("SELECT CURDATE() AS curr_date")->row('curr_date'))*/
                            elseif($get_days > $check_receipt_day)
                                {
                                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid receipt date. !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                     redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
                                }
                            elseif($check_check_receipt_itemcode == 1)
                            {
                                // $check_receipt = $this->db->query("SELECT b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND b.Refno = '".$this->input->post('receipt_no')."' AND b.itemcode = '".$check_itemcode->row('itemcode')."' ");

                                // if($check_receipt->num_rows() == 0)//if not found
                                // {
                                //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for replacement card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                //     redirect('Transaction_c/lost_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality']);
                                // }

                                $data = array(
                                        'refno' => $this->input->post('receipt_no'),
                                        'itemcode' => $check_itemcode->row('itemcode'),
                                    );

                                $check_receipt = $this->Member_Model->query_call('Transaction_c', 'save_renew1', $data);

                                if($check_receipt['message'] != 'success')
                                {
                                    if($check_receipt['message'] == 'Unable find itemcode for renew card on this receipt no.Please make payment to proceed this transaction.')
                                    {
                                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for replacement card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    }
                                    else
                                    {
                                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$check_receipt['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    }

                                    redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
                                }
                            }
                        }

                        $receipt_no = $_SESSION['receipt_no'];
                        if($this->check_exist_receipt_no($receipt_no)->num_rows() > 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt No Already Exist In Record !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
                        };
                    }
                    else
                    {
                        if($this->input->post('receipt_no') != '-')
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please use "-" for bypass receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&Expirydate='.$_SESSION['Expirydate']);
                        };

                        $_SESSION['receipt_no'] = $this->input->post('receipt_no');
                    }
                    
                }
                else
                {
                    $_SESSION['receipt_no'] = "";
                }

            // $get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$this->input->post('years')."' YEAR AS Expirydate")->row('Expirydate');
            $get_account_data = $this->db->query("
                    SELECT Title, ICNo, Name, NameOnCard, Expirydate, CardNo,
                    Active, OldICNo, Birthdate, Principal, Nationality, Gender, Email, Remarks, Expirydate, 
                    'REPLACECARD' AS card, register_online, register_date, CardNo AS OldCardNo FROM member WHERE AccountNo = '".$accountno."' AND CardNo = '".$_SESSION['card_no']."'
                    UNION ALL
                    SELECT b.Title, b.ICNo, b.Name, b.NameOnCard, b.Expirydate, b.SupcardNo AS CardNo,
                    b.Active, b.OldICNo, b.Birthdate, b.Principal, b.Nationality, b.Gender, 
                    b.Email, b.Remarks, b.Expirydate,
                    IF(b.PrincipalCardNo = 'REPLACECARD' OR 'LOSTCARD' OR 'UPGRADECARD' OR 'APPMAIN','REPLACECARD', 'REPLACESUPCARD') AS card, b.register_online, b.register_date, IF(b.OldCardNo IS NULL OR b.OldCardNo = '', b.SupcardNo, b.OldCardNo) AS OldCardNo FROM member AS a
                    INNER JOIN membersupcard AS b ON a.AccountNo = b.AccountNo
                    WHERE b.AccountNo = '".$accountno."' AND b.SupCardNo = '".$_SESSION['card_no']."'
                ");

            // if not use preisse card no, system auto create ne card no
            if($this->check_parameter()->row('preissue_card_method') == '0')
            {
                $account_no = $this->Trans_Model->generate_card_no($this->input->post('branch'));
                $SupCardNo = $account_no;
            }
            else
            {
                $SupCardNo = addslashes($this->input->post('card_no'));
            }

            if($get_account_data->row('card') == 'REPLACECARD')
            {
                $trans_type = 'REPLACE MAIN';
            }
            else
            {
                $trans_type = 'REPLACE SUP';
            }
            
            // if not use preisse card no, system auto create ne card no
            if($this->check_parameter()->row('preissue_card_method') == '0')
            {
                $data_trans = array(

                    'TRANS_GUID' => $this->guid(),
                    'TRANS_TYPE' => $trans_type,
                    'REF_NO' => addslashes($this->input->post('receipt_no')),
                    'AccountNo' => $accountno,
                    'CardNo' => $_SESSION['card_no'],
                    'CardNoNew' => $account_no,
                    'Name' => addslashes($this->input->post('Name')),
                    'NameOnCard' => addslashes($this->input->post('NameOnCard')),
                   
                    'Phonemobile' => addslashes($this->input->post('mobile_no')),
                    'Issuedate' => $this->date(),
                    'Expirydate' => addslashes($this->input->post('expirydate')),
                    'ICNo' => addslashes($this->input->post('ic_no')),
                    'Active' => '1',
                    'Remarks' => addslashes($this->input->post('remarks')),
                    'Gender' => $get_account_data->row('Gender'),
                    
                    'IssueStamp' => $this->datetime(),
                    'UPDATED_BY' => $_SESSION['username'],
                    'UPDATED_AT' => $this->datetime(),
                    'LastStamp' => $this->datetime(),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION['username'],
                    'NewForScript' => '1',
                   
                    'branch' => $this->input->post('branch'),
                );
                $this->db->insert('mem_ii_trans' , $data_trans);
            }

            $data = array(
                'PrincipalCardNo' => $get_account_data->row('card'),
                'AccountNo' => $accountno,
                'Title' => $get_account_data->row('Title'),
                'ICNo' => addslashes($this->input->post('ic_no')),
                'SupCardNo' => $SupCardNo,
                'Name' => $get_account_data->row('Name'),
                'NameOnCard' => $get_account_data->row('NameOnCard'),
                'Expirydate' => $get_account_data->row('Expirydate'),
                'Remarks' => addslashes($this->input->post('remarks')),
                'Phonemobile' => str_replace(' ', '', addslashes('+'.$this->input->post('mobile_no'))),
                'Active' => $get_account_data->row('Active'),
                'OldICNo' => $get_account_data->row('OldICNo'),
                'Birthdate' => $get_account_data->row('Birthdate'),
                'Principal' => $get_account_data->row('Principal'),
                'Nationality' => $this->db->query("SELECT LEFT('".$get_account_data->row('Nationality')."', 9) AS nation")->row('nation'),
                'Gender' => $get_account_data->row('Gender'),
                'email' => $get_account_data->row('Email'),
                'Remarks' => $get_account_data->row('Remarks'),
                "register_online" => $get_account_data->row('register_online'),
                "register_date" => $get_account_data->row('register_date'),
                "OldCardNo" => $get_account_data->row('OldCardNo'),
                // 'branch' => $get_account_data->row('branch'),
                'IssueStamp' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                'LastStamp' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                'UPDATED_BY' => $_SESSION['username'],
                'CREATED_BY' => $_SESSION['username'],
                'NewForScript' => 1,
            );
            $this->db->insert('membersupcard', $data);
            
            $this->db->query("UPDATE membersupcard SET rec_new = '1', rec_edit = '0' WHERE AccountNo = '$accountno' AND SupCardNo = '".addslashes($this->input->post('card_no'))."'");

            if($get_account_data->row('card') == 'REPLACESUPCARD')
            {
                $replace_type = "REPLACE SUPCARD";
            }
            else
            {
                $replace_type = "REPLACE CARD";
            }

            $data1 = array(
                'AccountNo' => $accountno,
                'LostcardNo' => $_SESSION['card_no'],
                'Name' => $get_account_data->row('Name'),
                'NameOnCard' => $get_account_data->row('NameOnCard'),
                'Title' => $get_account_data->row('Title'),
                'ICNo' => addslashes($this->input->post('ic_no')),
                'OldICNo' => $get_account_data->row('OldICNo'),
                'Nationality' => $this->db->query("SELECT LEFT('".$get_account_data->row('Nationality')."', 9) AS nation")->row('nation'),
                'Birthdate' => $get_account_data->row('Birthdate'),
                'Gender' => $get_account_data->row('Gender'),
                'Principal' => $get_account_data->row('Principal'),
                'Phonemobile' => str_replace(' ', '', addslashes('+'.$this->input->post('mobile_no'))),
                'SubstituteCardNo' => $SupCardNo,
                'CreateDate' => date('Y-m-d'),
                'CreateTime' => date('H:i:s'),
                'Remarks' => $get_account_data->row('Remarks'),
            );
            $this->db->insert('memberlostcard', $data1);

            //user_logs
            $data = array(
                'Trans_type' => $replace_type,
                'AccountNo' => $accountno,
                'ReferenceNo' => addslashes($this->input->post('reason')),
                'ReceiptNo' => $_SESSION['receipt_no'],
                'field' => 'CardNo',
                'value_from' => $get_account_data->row('CardNo'),
                'value_to' => $SupCardNo,
                'expiry_date_before' => $get_account_data->row('Expirydate'),
                'expiry_date_after' => $get_account_data->row('Expirydate'),
                'created_at' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                'created_by' => $_SESSION['username'],
            );
            $this->db->insert('user_logs', $data);

            // if preissue method. need to delete initial account at member table
            if($this->check_parameter()->row('preissue_card_method') == 1)
            {
                $get_rep_card = $this->db->query("SELECT * FROM member WHERE CardNo = '".$this->input->post('card_no')."'");
                
                $data = array(
                    'AccountNo' => $get_rep_card->row('AccountNo'),
                    'CardNo' => $get_rep_card->row('CardNo'),
                    'Name' => $get_rep_card->row('Name'),
                    'NameOnCard' => $get_rep_card->row('NameOnCard'),
                    'Address1' => $get_rep_card->row('Address1'),
                    'Address2' => $get_rep_card->row('Address2'),
                    'Address3' => $get_rep_card->row('Address3'),
                    'Address4' => $get_rep_card->row('Address4'),
                    'City' => $get_rep_card->row('City'),
                    'State' => $get_rep_card->row('State'),
                    'Postcode' => $get_rep_card->row('Postcode'),
                    'Email' => $get_rep_card->row('Email'),
                    'Phonehome' => $get_rep_card->row('Phonehome'),
                    'Phoneoffice' => $get_rep_card->row('Phoneoffice'),
                    'Phonemobile' => $get_rep_card->row('Phonemobile'),
                    'Fax' => $get_rep_card->row('Fax'),
                    'Issuedate' => $get_rep_card->row('Issuedate'),
                    'Expirydate' => $get_rep_card->row('Expirydate'),
                    'Cardtype' => $get_rep_card->row('Cardtype'),
                    'Title' => $get_rep_card->row('Title'),
                    'ICNo' => $get_rep_card->row('ICNo'),
                    'OldICNo' => $get_rep_card->row('OldICNo'),
                    'Occupation' => $get_rep_card->row('Occupation'),
                    'Employer' => $get_rep_card->row('Employer'),
                    'Birthdate' => $get_rep_card->row('Birthdate'),
                    'Principal' => $get_rep_card->row('Principal'),
                    'Active' => $get_rep_card->row('Active'),
                    'Nationality' => $get_rep_card->row('Nationality'),
                    'LimitBF' => $get_rep_card->row('LimitBF'),
                    'LimitAmt' => $get_rep_card->row('LimitAmt'),
                    'LimitAmtAdj' => $get_rep_card->row('LimitAmtAdj'),
                    'LimitAmtUsed' => $get_rep_card->row('LimitAmtUsed'),
                    'LimitAmtBalance' => $get_rep_card->row('LimitAmtBalance'),
                    'Status' => $get_rep_card->row('Status'),
                    'Race' => $get_rep_card->row('Race'),
                    'ChildrenNo' => $get_rep_card->row('ChildrenNo'),
                    'Remarks' => $get_rep_card->row('Remarks'),
                    'Religion' => $get_rep_card->row('Religion'),
                    'PointsBF' => $get_rep_card->row('PointsBF'),
                    'Points' => $get_rep_card->row('Points'),
                    'PointsAdj' => $get_rep_card->row('PointsAdj'),
                    'Pointsused' => $get_rep_card->row('Pointsused'),
                    'Pointsbalance' => $get_rep_card->row('Pointsbalance'),
                    'Income' => $get_rep_card->row('Income'),
                    'Credit' => $get_rep_card->row('Credit'),
                    'Gender' => $get_rep_card->row('Gender'),
                    'PassportNo' => $get_rep_card->row('PassportNo'),
                    'Picture' => $get_rep_card->row('Picture'),
                    'CREATED_BY' => $get_rep_card->row('CREATED_BY'),
                    'IssueStamp' => $get_rep_card->row('IssueStamp'),
                    'UPDATED_BY' => $get_rep_card->row('UPDATED_BY'),
                    'LastStamp' => $get_rep_card->row('LastStamp'),
                    'NewForScript' => $get_rep_card->row('NewForScript'),
                    'DiscLimitActive' => $get_rep_card->row('DiscLimitActive'),
                    'DiscLimitBF' => $get_rep_card->row('DiscLimitBF'),
                    'DiscLimit' => $get_rep_card->row('DiscLimit'),
                    'DiscLimitAdj' => $get_rep_card->row('DiscLimitAdj'),
                    'DiscLimitUsed' => $get_rep_card->row('DiscLimitUsed'),
                    'DiscLimitBalance' => $get_rep_card->row('DiscLimitBalance'),
                    'DiscLimitReset' => $get_rep_card->row('DiscLimitReset'),
                    'LimitReset' => $get_rep_card->row('LimitReset'),
                    'MemberType' => $get_rep_card->row('MemberType'),
                    'Terms' => $get_rep_card->row('Terms'),
                    'CreditLimit' => $get_rep_card->row('CreditLimit'),
                    'Area' => $get_rep_card->row('Area'),
                    'Region' => $get_rep_card->row('Region'),
                    'comp_address' => $get_rep_card->row('comp_address'),
                    'comp_postcode' => $get_rep_card->row('comp_postcode'),
                    'comp_email' => $get_rep_card->row('comp_email'),
                    'biz_nature' => $get_rep_card->row('biz_nature'),
                    'biz_category' => $get_rep_card->row('biz_category'),
                    'created_at' => $get_rep_card->row('created_at'),
                    'updated_at' => $get_rep_card->row('updated_at'),
                    'staff' => $get_rep_card->row('staff'),
                    'rsupdate' => $get_rep_card->row('rsupdate'),
                    'branch' => $get_rep_card->row('branch'),
                    'referral_id' => $get_rep_card->row('referral_id'),
                    'recruiter_id' => $get_rep_card->row('recruiter_id'),
                    'name_first' => $get_rep_card->row('name_first'),
                    'name_last' => $get_rep_card->row('name_last'),
                    'replace_at' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                    'replace_by' => $_SESSION['username'],
                    'replace_type' => $replace_type,
                );
                $this->db->insert('member_replaced', $data);
                // insert replacement
                $this->db->query("UPDATE member_replaced SET rec_new = '".$get_rep_card->row('rec_new')."', rec_edit = '".$get_rep_card->row('rec_edit')."' WHERE AccountNo = '".$get_rep_card->row('AccountNo')."' AND CardNo = '".$get_rep_card->row('CardNo')."'");
                $this->db->query("DELETE FROM member WHERE CardNo = '".$this->input->post('card_no')."'");
                //delete card at member table

                // $data = array(
                //     'Active' => 0
                // );
                // $this->db->WHERE('AccountNo',$_SESSION['account_no']);
                // $this->db->update('member', $data);// set old card no as in active

                //mem_server
                $server = array(
                    // 'refno' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') AS uuid ")->row('uuid'),
                    'SqlScript' => "DELETE FROM member WHERE CardNo = '".$this->input->post('card_no')."' AND AccountNo = '".$get_rep_card->row('AccountNo')."' ",
                    // 'CreatedDateTime' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                    'CreatedBy' => 'Point.cal:web_member',
                    // 'Status' => '0',
                    // 'KeyField' => '',
                );
                // $this->db->insert('mem_server.sqlscript', $server);
                $this->insert_sqlscript($server);
            }
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                
                if($this->check_parameter()->row('preissue_card_method') == 1)
                {
                    redirect('Transaction_c/replace_card');
                }
                else
                {
                    /*redirect('Transaction_c/issue_sup_card?created='.$account_no);*/
                    redirect('Transaction_c/replace_card?exist_card='.$_SESSION['card_no'].'&account='.$accountno.'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&Name='.$_SESSION['Name'].'&Passport_No='.$_SESSION['Passport_No'].'&Nationality='.$_SESSION['Nationality'].'&created='.$account_no.'&Expirydate='.$_SESSION['Expirydate']);
                }
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Failed ! !<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/replace_card');
            }
    }

    public function voucher()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $this->template->load('template' , 'voucher' );
        }
        else
        {
            redirect('login_c');
        }
    }

    public function issue_voucher()
    {
        if($this->session->userdata('loginuser')== true)
        {

            
             $this->template->load('template' , 'issue_voucher' );
        }
        else
        {
            redirect('login_c');
        }
    }

    public function activate_voucher()
    {
        if($this->session->userdata('loginuser') == true)
        {
            if(isset($_REQUEST['From']))
            {
                $From = $_REQUEST['From'];
                $To = $_REQUEST['To'];
            }
            else
            {
                $From = '';
                $To = '';
            }

            $data = array(
                'From' => $From,
                'To' => $To,

            );

            $this->template->load('template' , 'activate_voucher', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function insert_activate_voucher()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $result = $this->db->query("SELECT * from frontend.voucher_general where REFNO between '".$this->input->post('From')."' and  '".$this->input->post('To')."' and activated = '0' ");

            if($result->num_rows() == 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid card numbers or card already activated!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/activate_voucher');
            };
            /*else
            {
                $check_digit = $this->db->query("SELECT check_digit_voucher_activation from set_parameter ")->row('check_digit_voucher_activation');

                if($check_digit == '1')
                {
                    $from_value = $this->db->query("SELECT LEFT('".$this->input->post('From')."', LENGTH('".$this->input->post('From')."')-1) AS from_value ")->row('from_value');
                    $to_value = $this->db->query("SELECT LEFT('".$this->input->post('To')."', LENGTH('".$this->input->post('To')."')-1) AS to_value ")->row('to_value');
                    $voucher_range = $this->db->query("SELECT * from frontend.voucher_general where REFNO between '$from_value_%' and '$to_value_%' ");
                }
                elseif($check_digit == '0')
                {
                    $from_value = $this->input->post('From');
                    $to_value = $this->input->post('To');
                    $voucher_range = $this->db->query("SELECT * from $voucher_db.$voucher_col where REFNO between '$from_value' and '$to_value' ");
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid check digit value in the table<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                    redirect('Transaction_c/activate_voucher?from=' .$this->input->post('From'). '&to=' .$this->input->post('To'));
                }*/

                $date = $this->db->query("SELECT NOW() as curdate")->row('curdate');
                /*$final_result = $this->db->query("SELECT * from frontend.voucher_general where REFNO between '$from_value' and '$to_value' and activated = '0' ");*/
                $voucher_valid_in_days = $this->db->query("SELECT voucher_valid_in_days from set_parameter ")->row('voucher_valid_in_days');

                foreach($result->result() as $row => $value)
                {
                    $information = array(
                        'VALID_FROM' => $this->db->query("SELECT CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d') , ' ', '00:00:00') AS date ")->row('date'),
                        'VALID_TO' => $this->db->query("SELECT CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d') + INTERVAL '$voucher_valid_in_days' DAY, ' ', '00:00:00') AS date ")->row('date'),
                        'activated' => '1',
                        'activated_by' => $_SESSION['username'],
                    );

                    $this->db->where('REFNO', $value->REFNO);
                    $this->db->update('frontend.voucher_general', $information);

                    $info = array(
                        'Trans_type' => 'ACTIVATE VOUCHER',
                        //'AccountNo' => $_SESSION['account_no'],
                        'ReferenceNo' => $value->REFNO,
                        'field' => 'activated',
                        'value_from' => '0',
                        'value_to' => '1',
                        //'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                        //'expiry_date_after' => addslashes($get_new_expiry_date),
                        'created_at' => $date,
                        'created_by' => $_SESSION['username'],
                        );
                    $this->db->insert('user_logs', $info);
                }

                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Activate cards successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                    redirect('Transaction_c/activate_voucher');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Failed to activate cards<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                    redirect('Transaction_c/activate_voucher?from=' .$this->input->post('From'). '&to=' .$this->input->post('To'));
                }
            /*}*/
        }
        else
        {
            redirect('login_c');
        }
    }

    public function assign_card()
    {
        if($this->session->userdata('loginuser') == true)
        {
            // $branch_code = $this->db->query("SELECT branch_code from panda_b2b.acc_branch");
            $merchant_list = array();

            if(isset($_REQUEST['back']))
            {
                $nofrom = $_REQUEST['nofrom'];
                $noto = $_REQUEST['noto'];
                $merchant = $_REQUEST['merchant'];
            }
            else
            {
                $nofrom = '';
                $noto = '';
                $merchant = '';
            }

            $result = $this->Member_Model->query_call('Transaction_c', 'assign_card');

            if(isset($result['merchant_list']))
            {
                $merchant_list = $result['merchant_list'];
            }

            $data = array(
                'non_active' => $this->db->query("SELECT MIN(CardNo) AS from_no, MAX(CardNo) AS to_no, merchant_id, created_at, created_by FROM member_merchantcard GROUP BY merchant_id, created_at "),
                'merchant_list' => $merchant_list,

                'nofrom' => $nofrom,
                'noto' => $noto,
                'merchant' => $merchant,
                
                );
            
            $this->template->load('template' , 'assign_card' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function insert_assign_card()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $nofrom = strlen($this->input->post('nofrom'));
            $noto = strlen($this->input->post('noto'));

            $cardno = $this->db->query("SELECT * FROM member WHERE CardNo BETWEEN '".$this->input->post('nofrom')."' AND '".$this->input->post('noto')."' ");
            $merchant_cardno = $this->db->query("SELECT COUNT(CardNo) AS no FROM member_merchantcard WHERE CardNo BETWEEN '".$this->input->post('nofrom')."' AND '".$this->input->post('noto')."' ")->row('no');
            $date = $this->db->query("SELECT NOW() AS date")->row('date');

            //checking length not equal
            if($nofrom != $noto)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Length of card no. does not match!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/assign_card?nofrom=' .$this->input->post('nofrom'). '&noto=' .$this->input->post('noto'). '&merchant=' .$this->input->post('merchant'). '&back');
            };

            //checking nofrom cannot exceed noto
            if($this->input->post('nofrom') > $this->input->post('noto'))
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Value "From" cannot be more than value "To"!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/assign_card?nofrom=' .$this->input->post('nofrom'). '&noto=' .$this->input->post('noto'). '&merchant=' .$this->input->post('merchant'). '&back');
            };

            //checking card no. not exists
            if($cardno->num_rows() == 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card no. not found!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/assign_card?nofrom=' .$this->input->post('nofrom'). '&noto=' .$this->input->post('noto'). '&merchant=' .$this->input->post('merchant'). '&back');
            };

            //checking duplicate card no in member_merchantcard
            if($merchant_cardno > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">There is duplicate card no. for your other merchant!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/assign_card?nofrom=' .$this->input->post('nofrom'). '&noto=' .$this->input->post('noto'). '&merchant=' .$this->input->post('merchant'). '&back');
            };

            //checking all cards meet requirements
            foreach($cardno->result() as $row => $value)
            {  
                /*$check_no = $this->db->query("SELECT AccountNo FROM member WHERE CardNo = '$value->CardNo' AND Name = 'NEW' AND Active = '0' AND branch IN (SELECT branch_code FROM panda_b2b.acc_branch) ")->num_rows();*/
                $check_no = $this->db->query("SELECT AccountNo FROM member WHERE CardNo = '$value->CardNo' AND Name = 'NEW' AND Expirydate = Issuedate ")->num_rows();
                
                if($check_no == 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable to assign card due to one/more of the card no. you assigned does not meet requirements!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/assign_card?nofrom=' .$this->input->post('nofrom'). '&noto=' .$this->input->post('noto'). '&merchant=' .$this->input->post('merchant'). '&back');
                };
            }

            //after checking above only update
            foreach($cardno->result() as $row => $value)
            {   
                $info = array(
                    //'guid' => $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS UUID")->row('UUID'),
                    'CardNo' => $value->CardNo,
                    'merchant_id' => $this->input->post('merchant'),
                    'created_at' => $date,
                    'created_by' => $_SESSION['username'],    
                );
                $this->db->insert('member_merchantcard', $info);
            }

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Assign cards successfully!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/assign_card');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Fail to assign cards!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/assign_card?nofrom=' .$this->input->post('nofrom'). '&noto=' .$this->input->post('noto'). '&merchant=' .$this->input->post('merchant'). '&back');
            }

        }
        else
        {
            redirect('login_c');
        }
    }

    public function pre_activate_card()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $data = array(
                'mem_activate_card' => $this->db->query("SELECT * from member_pre_activate a ORDER BY a.`created_at` DESC "),
                'cardtype' => $this->db->query("SELECT * from cardtype order by CardType asc"),
                // 'branch' => $this->db->query("SELECT * from set_branch"),
                'prefix_in' => '',
                'cardtype_in' => '',
                'branch_in' => '',
                'suffix_in' => '4',
                'nofrom_in' => '',
                'noto_in' => '',
                'remark_in' => '',
                'total' => '',
                'disable' => 'disabled',
                'enable' => '',
                'type' => 'hidden',
                // 'branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),
                'branch' => $this->branch(),
                );
            // echo $this->db->last_query();die;
            $this->template->load('template' , 'pre_activate_card' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function create_pre_activate_card()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $check_digit = $this->check_parameter()->row('check_digit_card');

                if($check_digit == '1')
                {
                    $card_from = $this->db->query("SELECT SUBSTRING('".$this->input->post('card_from')."',1,LENGTH('".$this->input->post('card_from')."')-1) as card")->row('card');
                    $card_to = $this->db->query("SELECT SUBSTRING('".$this->input->post('card_to')."',1,LENGTH('".$this->input->post('card_to')."')-1) as card")->row('card');
                    $check_member = $this->db->query("SELECT * FROM member 
                        WHERE SUBSTRING(cardno,1,LENGTH(cardno)-1) BETWEEN '$card_from' AND '$card_to' 
                        AND NAME = 'NEW' 
                        AND issuedate = expirydate 
                        AND icno IS NULL 
                        AND oldicno IS NULL 
                        AND passportno IS NULL 
                        AND active = 0 
                        AND pointsbalance = 0;");
                }
                else
                {
                    $card_from = $this->input->post('card_from');
                    $card_to = $this->input->post('card_to');
                    $check_member = $this->db->query("SELECT * FROM member 
                        WHERE cardno BETWEEN '$card_from' AND '$card_to' 
                        AND NAME = 'NEW' 
                        AND issuedate = expirydate 
                        AND icno IS NULL 
                        AND oldicno IS NULL 
                        AND passportno IS NULL 
                        AND active = 0 
                        AND pointsbalance = 0;");
                }

            if($check_member->num_rows() == 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Card No not Found !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/pre_activate_card');
            }
            else
            {
                    $data = array(
                        'guid' => $this->guid(),
                        'card_from' => $card_from,
                        'card_to' => $card_to,
                        'remark' =>  $this->input->post('remark'),
                        'created_by' => $_SESSION['username'],
                        'created_at' => $this->db->query("SELECT now() as datetime")->row('datetime'),
                        'branch' => $this->input->post('branch'),
                        );
                    $this->db->insert('member_pre_activate',$data);

                    foreach ($check_member->result() as $row ) 
                    {
                        $data_update = array(
                            'active' => 1,
                            'expirydate' => '3000-12-31',
                            'NAME' => 'PREACTIVATED',
                            'remarks' => 'PREACTIVATED',
                            'newforscript' => 1,
                            'acc_status' => 'PREACTIVE'
                        );
                        $this->db->where('AccountNo', $row->AccountNo);
                        $this->db->update('member',$data_update);
                    }

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Transaction_c/pre_activate_card");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function pending_activation()
    {
        $data = array(
            'record' => $this->db->query("SELECT * FROM `member` a WHERE a.`Expirydate` = '3000-12-31';")
        );
        $this->template->load('template' , 'pending_activation_card' , $data);
    }

    public function delete_manually()
    {
        $get_account_to_delete = $this->db->query("SELECT a.`AccountNo` FROM `member_replaced` a ");

        foreach($get_account_to_delete->result() as $key => $value) 
        {
            $data = array(

                // 'refno' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid'),
                'SqlScript' => "DELETE FROM `member` WHERE AccountNo = '".$value->AccountNo."' " ,  
                // 'CreatedDateTime' => $this->db->query("SELECT NOW() as datetime")->row('datetime'),
                'CreatedBy' => '-',
                // 'Status' => '0',
                // 'KeyField' => '',
            );
            // $this->db->insert('mem_server.sqlscript',$data);
            $this->insert_sqlscript($data);
        }
    }

    public function check_expiry_date()
    {
        $get_preset_expiry_date = $this->db->query("SELECT '".$this->input->post('application_date')."'+INTERVAL 
                    (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
        echo $get_preset_expiry_date;die;
       
    }

    public function upgrade_card()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['scan_card']))
            {
                $cardno = $this->input->post('card_no');
                $reason_field = '';
                $field = '';
                
                $get_data = $this->db->query("SELECT CardNo, AccountNo, ICNo, Phonemobile, Email, Nationality,Active FROM `member` WHERE CardNo = '$cardno' UNION ALL SELECT SupCardNo AS CardNo, AccountNo, ICNo, Phonemobile, Email, Nationality,Active FROM membersupcard WHERE PrincipalCardNo IN ('LOSTCARD','REPLACECARD','UPGRADECARD') AND SupCardNo = '$cardno'");

                if($get_data->num_rows() == 0)
                {
                    $check_sup = $this->db->query("SELECT * FROM membersupcard WHERE SupCardNo = '$cardno'");

                    if($check_sup->num_rows() == 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Card Not Found!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/upgrade_card');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Supcard cannot be upgraded!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/upgrade_card');
                    }
                }
                else
                {
                    $_SESSION['card_type'] = 'primary_card';
                    $_SESSION['update_table'] = 'member';
                    redirect('Transaction_c/upgrade_card?exist_card='.$get_data->row('CardNo').'&account='.$get_data->row('AccountNo').'&ic_no='.$get_data->row('ICNo').'&active='.$get_data->row('Active').'&mobile_no='.$get_data->row('Phonemobile').'&email='.$get_data->row('Email').'&nationality='.$get_data->row('Nationality').'&army_no='.$get_data->row('ICNo'));
                }

                $result = 'hidden';

            }
            elseif(isset($_REQUEST['exist_card']))
            {
                $get_account_data = $this->db->query("SELECT * FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_REQUEST['account']."' ");

                $check_lost_card = $this->db->query("SELECT LostCardNo FROM memberlostcard WHERE LostCardNo = '".$get_account_data->row('CardNo')."'");

                if($check_lost_card->num_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This Card Already Lost. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/upgrade_card');
                }

                if($get_account_data->row('acc_status') == 'TERMINATE' || $get_account_data->row('acc_status') == 'SUSPEND')
                {
                     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card Has Been '.$get_account_data->row('acc_status').'. Unable to activate.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/upgrade_card');
                }

                if($get_account_data->row('Expirydate') < date('Y-m-d'))
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card Already Expiry !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/upgrade_card');
                }

                if($get_account_data->row('Active') == 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Card is inactive!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/upgrade_card');
                }

                if($get_account_data->row('Name') != 'NEW' && $get_account_data->row('Active') == 1)
                // if not active yet
                {
                    $years = '';
                    $reason_field = 'UPGRADE';
                    $field = 'receipt_upgrade';
                    $button = 'Upgrade Card';
                    $form = site_url('Transaction_c/save_upgrade');
                }
               
                if($get_account_data->row('Name') == 'NEW' && $get_account_data->row('Active') == 1)
                // if not active yet
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Cannot upgrade preissue card!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/upgrade_card');
                }

                $_SESSION['old_ic_no'] = $get_account_data->row('OldICNo');
                $_SESSION['passport_no'] = $get_account_data->row('PassportNo');

                $_SESSION['mobile_no'] = $_REQUEST['mobile_no'];
                $_SESSION['active'] = $_REQUEST['active'];
                $_SESSION['card_no'] = $_REQUEST['exist_card'];
                $_SESSION['account_no'] = $_REQUEST['account'];
                $_SESSION['ic_no'] = $_REQUEST['ic_no'];
                $_SESSION['army_no'] = $_REQUEST['army_no'];
                $_SESSION['email'] = $_REQUEST['email'];
                $_SESSION['hidden_result'] = '';
                $_SESSION['nationality'] = $_REQUEST['nationality'];
            }
            else
            {  
                $years = '';
                $reason_field = '';
                $field = ''; 
                $_SESSION['old_ic_no'] = '';
                $_SESSION['passport_no'] = '';

                $_SESSION['update_table'] = 'member';
                $button = 'Upgrade Card';
                $form = '';
                $_SESSION['mobile_no'] = '';
                $_SESSION['active'] = '';
                $_SESSION['card_no'] = '';
                $_SESSION['account_no'] = '';
                $_SESSION['ic_no'] = '';
                $_SESSION['army_no'] = '';
                $_SESSION['email'] = '';
                $_SESSION['hidden_result'] = 'hidden';
                $_SESSION['nationality'] = '';
            }

            $get_account_data = $this->db->query("SELECT * FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."' ");

            if($get_account_data->row('Issuedate') == $get_account_data->row('Expirydate') && $get_account_data->row('Name') == 'NEW' || $get_account_data->row('Active') == 0 || $get_account_data->row('Expirydate') == '3000-12-31')// if new card need to activate
            {
                // $get_preset_expiry_date = $this->db->query("SELECT (SELECT Expirydate FROM member WHERE AccountNo = '".$_SESSION['account_no']."')+INTERVAL (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
                // script with interval based on setting
                // $get_preset_expiry_date = $this->db->query("SELECT Expirydate FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."'")->row('Expirydate');

                // $get_preset_expiry_date = $this->db->query("SELECT (SELECT Expirydate FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."')+INTERVAL 
                //     (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
                // not capture currdate

                $get_preset_expiry_date = $this->db->query("SELECT CURDATE()+INTERVAL 
                    (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');
                
                /*$branch = $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC");*/
                // $branch = $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name, c.receipt_activate FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY b.branch_code ASC");

                $branch = $this->branch_with_receipt();
            }
            else// if card need to renew
            {
                $get_setting = $this->db->query("SELECT expiry_date_type from set_parameter")->row('expiry_date_type');
                $today = $this->db->query("SELECT CURDATE() AS today ")->row('today');

                if($get_setting == 1)// if setup equal to 1 new expiry date will follow the logic
                {
                    if($get_account_data->row('Expirydate') > $today)// if expired date more then current date
                    {
                        $get_preset_expiry_date = $get_account_data->row('Expirydate');
                    }
                    else
                    {
                        $get_preset_expiry_date = $today; 
                    }
                };

                if($get_setting == 2)// if setup equal to 2 new expiry date will old expiry date format.
                {
                    $get_preset_expiry_date = $get_account_data->row('Expirydate');
                };

                if($get_setting == 3)// if setup equal to 3 all expiry date round up to n months.
                {
                    if($get_account_data->row('Expirydate') > $today && $get_account_data->row('Expirydate') != '3000-12-31')// if expired date more then current date
                    {
                        $date = $get_account_data->row('Expirydate');
                    }
                    else
                    {
                        $date = $today; 
                    }

                    $month = date("m", strtotime($date));
                    $year = date("Y", strtotime($date));
                    $month_rounder = $this->db->query("SELECT expiry_date_roundup FROM set_parameter")->row('expiry_date_roundup');
                    $expiry_month = ceil($month/$month_rounder) * $month_rounder;
                    $expiry_month = str_pad($expiry_month, 2, '0', STR_PAD_LEFT);
                    $days = cal_days_in_month(CAL_GREGORIAN,$expiry_month,$year);
                    $get_preset_expiry_date  = $year.'-'.$expiry_month.'-'.$days;
                }
                
                // $branch = $this->db->query("SELECT branch as branch_code, branch as branch_name  FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."' ");
                $branch = $this->branch_with_receipt();
            }

            if(isset($_REQUEST['print']))
            {
                $bodyload = 'printdetails()';
                $AccountNo = $_REQUEST['AccountNo'];
                $CardNo = $_REQUEST['CardNo'];
            }
            else
            {
                $bodyload = '';
                $AccountNo = '';
                $CardNo = '';
            }
            /*if($branch->num_rows() == 1)
            {
                $need_receipt_no = $this->db->query("SELECT set_receipt_no FROM set_branch_newcard where branch_code = '".$branch->row('branch_code')."' ")->row('set_receipt_no'),
            }
            else
            {
                $need_receipt_no = '';
            }*/

            $data = array(

                /*'need_receipt_no' => $need_receipt_no,*/
                'actual_expirydate' => $get_account_data->row('Expirydate'),
                'direction' => site_url('Transaction_c/upgrade_card'),
                'bodyload' => $bodyload,
                'button' => $button,
                'form' => $form,
                'branch' => $branch,
                'expiry_date' => $get_preset_expiry_date,
                'remarks' => $this->db->query("SELECT * FROM ".$_SESSION['update_table']." WHERE AccountNo = '".$_SESSION['account_no']."' ")->row('Remarks'),

                'select_nationality' => $this->db->query("SELECT * FROM set_nationality"),
                'reason' => $this->db->query("SELECT * FROM set_reason where type = '".$reason_field."' "),
                'field' => $field,
                'years' => $years,
                'check_receipt_itemcode' => $this->db->query("SELECT * FROM set_parameter ")->row('check_receipt_itemcode'),
                'AccountNo' => $AccountNo,
                'CardNo' => $CardNo,
                'card_verify' => $this->check_parameter()->row('card_verify'),
                'cardtype' => $get_account_data->row('Cardtype'),
                'cardtype_list' => $this->db->query("SELECT CardType FROM cardtype"),
                'upgrade_maintain_card' => $this->check_parameter()->row('upgrade_maintain_card'),
                'preissue_card_method' => $this->check_parameter()->row('preissue_card_method'),
            );
            //echo $this->db->last_query();die;

            $this->template->load('template' , 'activation', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_upgrade()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $card_no = $this->input->post('card_no');

            if($this->check_parameter()->row('preissue_card_method') == '1' && $this->check_parameter()->row('upgrade_maintain_card') == '0')
            {
                $check_card = $this->db->query("SELECT NameOnCard FROM backend_member.member WHERE CardNo = '$card_no' AND Name = 'New' AND Issuedate = Expirydate");

                if($check_card->num_rows() < 1)
                {
                    $this->session->set_flashdata('message_confirm', '<div class="alert alert-warning text-center" style="font-size: 16px">The New Card Must be Pre issue card!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/upgrade_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no'));
                }
            }

            if($this->check_parameter()->row('card_verify') == '1' && ($this->input->post('confirm_cardno') != $card_no || $this->input->post('confirm_password') != $card_no))
            {
                $this->session->set_flashdata('message_confirm', '<div class="alert alert-warning text-center" style="font-size: 16px">Card No. Not Match!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Transaction_c/upgrade_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no'));
            }
            else
            {
                /*$need_receipt_no = $this->db->query("SELECT receipt_no_activerenew FROM `set_parameter`;")->row('receipt_no_activerenew');*/
                $need_receipt_no = $this->db->query("SELECT receipt_upgrade FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch_hidden')."' OR branch_id = '".$this->input->post('branch_hidden')."'")->row('receipt_upgrade');
                $check_check_receipt_itemcode = "";
                $cardtype = $this->input->post('cardtype');
                    if($need_receipt_no == 1)
                    {
                        if($this->input->post('receipt_no') == '')
                        {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', 0); 
                            ini_set('memory_limit','2048M');

                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please fill in receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Transaction_c/upgrade_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                        };

                        if(!in_array('BPRN', $_SESSION['module_code']))// if dont have authorization to by pass
                        {
                            $_SESSION['receipt_no'] = $this->input->post('receipt_no');

                            $check_check_receipt_itemcode = $this->db->query("SELECT a.`check_receipt_itemcode` FROM set_parameter a;")->row('check_receipt_itemcode');

                            //$check_receipt_setup = $this->db->query("SELECT receipt_no_amount_renew FROM `set_parameter`;")->row('receipt_no_amount_renew');

                            if($check_check_receipt_itemcode == 0) //check amount (all outlets)
                            {
                                $check_receipt_setup = $this->db->query("SELECT receipt_no_amount_upgradecard FROM set_parameter ")->row('receipt_no_amount_upgradecard');
                            }
                            elseif($check_check_receipt_itemcode == 2) //check amount (based outlets)
                            {
                                $check_receipt_setup = $this->db->query("SELECT amount_upgrade FROM set_branch_parameter WHERE branch_code = '".$this->input->post('branch_hidden')."' ")->row('amount_upgrade');
                            }
                            else
                            {
                                $check_receipt_setup = '0';
                            }

                            // if($this->check_parameter()->row('check_receipt_itemcode') == 1)
                            // {
                            //     $check_receipt = $this->Trans_Model->check_receipt_no_child($this->input->post('receipt_no'));
                            //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_child($this->input->post('receipt_no'));
                            // }
                            // else
                            // {
                            //     $check_receipt = $this->Trans_Model->check_receipt_no_main($this->input->post('receipt_no'));
                            //     $check_receipt_void = $this->Trans_Model->check_receipt_void_no_main($this->input->post('receipt_no'));
                            // }

                            //echo $this->db->last_query();die;
                            $check_itemcode = $this->db->query("SELECT * FROM set_itemcode WHERE name = 'upgradecard' ");

                            // $check_exist_receipt = $this->db->query("SELECT * FROM frontend.posmain WHERE RefNo = '".$this->input->post('receipt_no')."'");

                            $data = array(
                                'refno' => $this->input->post('receipt_no'),
                            );

                            $result = $this->Member_Model->query_call('Transaction_c', 'save_renew', $data);

                            if($result['message'] != 'success')//if not found
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/upgrade_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                            }
                            // elseif($check_receipt_void->num_rows() == 1)//if receipt void
                            // {
                            //     $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt Already Voided !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            //     redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no'));
                            // }
                            else
                            {
                                $check_receipt_day = $this->db->query("SELECT check_receipt_day FROM set_parameter ")->row('check_receipt_day');
                                $get_days = $this->db->query("SELECT TIMESTAMPDIFF(DAY, '".$result['check_receipt'][0]['BizDate']."', CURDATE()) AS day ")->row('day');

                                if(($check_check_receipt_itemcode == 0 || $check_check_receipt_itemcode == 2) && $result['check_receipt'][0]['BillAmt'] < $check_receipt_setup)// if setup not check itemcode and bill amount less than tamount setup
                                {
                                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Receipt Amount Not Enough !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    redirect('Transaction_c/upgrade_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                                }
                                /*elseif($check_receipt->row('BizDate') <> $this->db->query("SELECT CURDATE() AS curr_date")->row('curr_date'))*/
                                elseif($get_days > $check_receipt_day)
                                {
                                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Invalid receipt date. !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    redirect('Transaction_c/upgrade_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                                }
                                elseif($check_check_receipt_itemcode == 1)
                                {
                                    // $check_receipt = $this->db->query("SELECT b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND b.Refno = '".$this->input->post('receipt_no')."' AND b.itemcode = '".$check_itemcode->row('itemcode')."' ");
                                    // if($check_receipt->num_rows() == 0)//if not found
                                    // {
                                    //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for renew card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                    //     redirect('Transaction_c/renew?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no'));
                                    // };

                                    // $check_receipt->row('Qty');

                                    $data = array(
                                        'refno' => $this->input->post('receipt_no'),
                                        'itemcode' => $check_itemcode->row('itemcode'),
                                    );

                                    $check_receipt = $this->Member_Model->query_call('Transaction_c', 'save_renew1', $data);

                                    if($check_receipt['message'] == 'success')
                                    {
                                        if($check_receipt['message'] == 'Unable find itemcode for renew card on this receipt no.Please make payment to proceed this transaction.')
                                        {
                                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Unable find itemcode for upgrade card on this receipt no.Please make payment to proceed this transaction.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                        }
                                        else
                                        {
                                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">'.$check_receipt['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                        }

                                        redirect('Transaction_c/upgrade_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                                    }
                                }
                            }


                            $receipt_no = $_SESSION['receipt_no'];
                            if($this->check_exist_receipt_no($receipt_no)->num_rows() > 0)
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Receipt No. Exist In Record !!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/upgrade_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                            }
                        }
                        else
                        {
                            if($this->input->post('receipt_no') != '-')
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Please use "-" for bypass receipt no.!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect('Transaction_c/upgrade_card?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$_SESSION['ic_no'].'&active='.$_SESSION['active'].'&mobile_no='.$_SESSION['mobile_no'].'&email='.$_SESSION['email'].'&nationality='.$_SESSION['nationality'].'&army_no='.$this->input->post('army_no').$bypass);
                            };

                            $_SESSION['receipt_no'] = $this->input->post('receipt_no');
                        }
                        
                    }
                    else
                    {
                        $_SESSION['receipt_no'] = '';
                    }

              
                $expiry_date_in_year = $this->db->query('SELECT expiry_date_in_year FROM set_parameter')->row('expiry_date_in_year');

                /*$get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$this->input->post('years')."' YEAR AS Expirydate")->row('Expirydate');*/
                $get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('expiry_date')."'+INTERVAL '".$expiry_date_in_year."' YEAR AS Expirydate")->row('Expirydate');
                //echo $this->db->last_query();die;
                $account_no = $_SESSION['account_no'];
                // $card_no = $_SESSION['card_no'];
                $card_no = $this->input->post('card_no');

                //ori_log
                $ori = $this->db->query("SELECT Cardtype, Expirydate, CardNo from member where AccountNo = '$account_no' ");
                $ori_Cardtype = $ori->row('Cardtype');
                $ori_Expirydate = $ori->row('Expirydate');
                $ori_CardNo = $ori->row('CardNo');
                //ori_log

                $data = array(
                    'Cardtype' => $cardtype,
                    'Expirydate' => addslashes($get_new_expiry_date),
                    'Remarks' => addslashes($this->input->post('remarks')),
                    'NewForScript' => 1,
                    'updated_at' => $this->datetime(),
                );
                
                if($_SESSION['card_type'] == 'primary_card')
                {
                    $get_data = $this->db->query("SELECT * FROM member WHERE accountno = '".$account_no."'");
                    $old_expirydate = $get_data->row('Expirydate');

                    $get_setting = $this->db->query("SELECT * FROM set_parameter")->row('auto_renewsupcard');
                    $where = array(
                            'AccountNo' => $account_no,
                            'Active' => '1',
                        );

                    if($get_setting == 1)
                    {
                        $this->db->where('AccountNo', $account_no);
                        $this->db->update('member', $data);

                        if(isset($data['Cardtype']))
                        {
                            unset($data['Cardtype']);
                        }

                        $this->db->where($where);
                        $this->db->update('membersupcard', $data);
                    }
                    else
                    {
                        $where['PrincipalCardNo'] = 'LOSTCARD';
                        $this->db->where($where);
                        $this->db->update('membersupcard', $data);
                    }

                    $upgrade_card = "UPGRADE CARD";
                };

                $date = $this->db->query("SELECT NOW() as curdate")->row('curdate');

                $get_account_data = $this->db->query("
                    SELECT Title, ICNo, Name, NameOnCard, Expirydate, CardNo,
                    Active, OldICNo, Birthdate, Principal, Nationality, Gender, Email, Remarks, Expirydate, 
                    'UPGRADECARD' AS card, register_online, register_date, CardNo AS OldCardNo, '' AS Relationship, Phonemobile FROM member WHERE AccountNo = '".$account_no."' AND CardNo = '".$_SESSION['card_no']."'
                    UNION ALL
                    SELECT b.Title, b.ICNo, b.Name, b.NameOnCard, b.Expirydate, b.SupcardNo AS CardNo,
                    b.Active, b.OldICNo, b.Birthdate, b.Principal, b.Nationality, b.Gender, 
                    b.Email, b.Remarks, b.Expirydate,
                    'UPGRADECARD' AS card, b.register_online, b.register_date, IF(b.OldCardNo IS NULL OR b.OldCardNo = '', b.SupcardNo, b.OldCardNo) AS OldCardNo, b.Relationship, b.Phonemobile FROM member AS a
                    INNER JOIN membersupcard AS b ON a.AccountNo = b.AccountNo
                    WHERE b.AccountNo = '".$account_no."' AND b.SupCardNo = '".$_SESSION['card_no']."'
                ");

                if($this->check_parameter()->row('preissue_card_method') == '0')
                {
                    $account_no_new = $this->Trans_Model->generate_card_no($this->input->post('branch'));
                    $SupCardNo = $account_no_new;
                }
                else
                {
                    $SupCardNo = addslashes($this->input->post('card_no'));
                }

                if($this->check_parameter()->row('preissue_card_method') == '0')
                {
                    // $get_member = $this->db->query("
                    //         SELECT a.* FROM member AS a 
                    //         WHERE a.accountno = '$account_no' AND a.CardNo = '".$_SESSION['card_no']."'
                    //     ");

                     $data_trans = array(

                    'TRANS_GUID' => $this->guid(),
                    'TRANS_TYPE' => 'LOST MAIN' ,
                    'REF_NO' => addslashes($this->input->post('receipt_no')),
                    'AccountNo' => $account_no,
                    'CardNo' => $_SESSION['card_no'],
                    'CardNoNew' => $account_no_new,
                    'Name' => addslashes($this->input->post('Name')),
                    'NameOnCard' => addslashes($this->input->post('NameOnCard')),
                    'PhoneMobile' => addslashes($this->input->post('mobile_no')),
                    'Issuedate' => $this->date(),
                    'Expirydate' => addslashes($this->input->post('expiry_date')),
                    'ICNo' => addslashes($this->input->post('ic_no')),
                    'Active' => '1',
                    'Remarks' => addslashes($this->input->post('remarks')),
                    'Gender' => $get_account_data->row('Gender'),
                    
                    'IssueStamp' => $this->datetime(),
                    'UPDATED_BY' => $_SESSION['username'],
                    'UPDATED_AT' => $this->datetime(),
                    'LastStamp' => $this->datetime(),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION['username'],
                    'NewForScript' => '1',
                   
                    'branch' => $this->input->post('branch'),
                );
                    $this->db->insert('mem_ii_trans' , $data_trans);
                }

                if($this->check_parameter()->row('upgrade_maintain_card') == '0')
                {
                    $data = array(
                        "AccountNo" => $account_no,
                        "LostCardNo" => $get_account_data->row('CardNo'),
                        "Name" => $get_account_data->row('Name'),
                        "NameOnCard" => $get_account_data->row('NameOnCard'),
                        "Title" => $get_account_data->row('Title'),
                        "ICNo" => $get_account_data->row('ICNo'),
                        "OldICNo" => $get_account_data->row('OldICNo'),
                        "Nationality" => $get_account_data->row('Nationality'),
                        "Relationship" => $get_account_data->row('Relationship'),
                        "Birthdate" => $get_account_data->row('Birthdate'),
                        "Gender" => $get_account_data->row('Gender'),
                        "Principal" => $get_account_data->row('Principal'),
                        "PhoneMobile" => $get_account_data->row('Phonemobile'),
                        "SubstituteCardNo" => $card_no,
                        "CreateDate" => $this->db->query("SELECT CURDATE() AS cur_date")->row('cur_date'),
                        "CreateTime" => $this->db->query("SELECT CURTIME() AS cur_time")->row('cur_time'),
                    );
                    $this->db->insert('memberlostcard', $data);

                    $data = array(
                        'PrincipalCardNo' => $get_account_data->row('card'),
                        'AccountNo' => $account_no,
                        'Title' => $get_account_data->row('Title'),
                        'ICNo' => addslashes($get_account_data->row('ICNo')),
                        'SupCardNo' => $SupCardNo,
                        'Name' => $get_account_data->row('Name'),
                        'NameOnCard' => $get_account_data->row('NameOnCard'),
                        'Expirydate' => $get_account_data->row('Expirydate'),
                        'Remarks' => addslashes($this->input->post('remarks')),
                        'PhoneMobile' => $get_account_data->row('Phonemobile'),
                        'Active' => $get_account_data->row('Active'),
                        'OldICNo' => $get_account_data->row('OldICNo'),
                        'Birthdate' => $get_account_data->row('Birthdate'),
                        'Principal' => $get_account_data->row('Principal'),
                        'Nationality' => $this->db->query("SELECT LEFT('".$get_account_data->row('Nationality')."', 9) AS nation")->row('nation'),
                        'Gender' => $get_account_data->row('Gender'),
                        'email' => $get_account_data->row('Email'),
                        'Remarks' => $get_account_data->row('Remarks'),
                        "register_online" => $get_account_data->row('register_online'),
                        "register_date" => $get_account_data->row('register_date'),
                        "OldCardNo" => $get_account_data->row('OldCardNo'),
                        // 'branch' => $get_account_data->row('branch'),
                        'IssueStamp' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                        'LastStamp' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                        'UPDATED_BY' => $_SESSION['username'],
                        'CREATED_BY' => $_SESSION['username'],
                        'NewForScript' => 1,
                    );
                    $this->db->insert('membersupcard', $data);

                    $data = array(
                        'Trans_type' => 'UPGRADE',
                        'AccountNo' => $_SESSION['account_no'],
                        'ReceiptNo' => $_SESSION['receipt_no'],
                        'field' => "CardNo",
                        'value_from' => $_SESSION['card_no'],
                        'value_to' => $card_no,
                        'expiry_date_before' => $ori_Expirydate,
                        'expiry_date_after' => $get_account_data->row('Expirydate'),
                        'created_at' => $date,
                        'created_by' => $_SESSION['username'],
                        );
                    $this->db->insert('user_logs', $data);
                }

                if($this->check_parameter()->row('preissue_card_method') == 1 && $this->check_parameter()->row('upgrade_maintain_card') == 0)
                {
                    $get_rep_card = $this->db->query("SELECT * FROM member WHERE CardNo = '".$this->input->post('card_no')."'");
                    
                    $data = array(
                        'AccountNo' => $get_rep_card->row('AccountNo'),
                        'CardNo' => $get_rep_card->row('CardNo'),
                        'Name' => $get_rep_card->row('Name'),
                        'NameOnCard' => $get_rep_card->row('NameOnCard'),
                        'Address1' => $get_rep_card->row('Address1'),
                        'Address2' => $get_rep_card->row('Address2'),
                        'Address3' => $get_rep_card->row('Address3'),
                        'Address4' => $get_rep_card->row('Address4'),
                        'City' => $get_rep_card->row('City'),
                        'State' => $get_rep_card->row('State'),
                        'Postcode' => $get_rep_card->row('Postcode'),
                        'Email' => $get_rep_card->row('Email'),
                        'Phonehome' => $get_rep_card->row('Phonehome'),
                        'Phoneoffice' => $get_rep_card->row('Phoneoffice'),
                        'Phonemobile' => $get_rep_card->row('Phonemobile'),
                        'Fax' => $get_rep_card->row('Fax'),
                        'Issuedate' => $get_rep_card->row('Issuedate'),
                        'Expirydate' => $get_rep_card->row('Expirydate'),
                        'Cardtype' => $get_rep_card->row('Cardtype'),
                        'Title' => $get_rep_card->row('Title'),
                        'ICNo' => $get_rep_card->row('ICNo'),
                        'OldICNo' => $get_rep_card->row('OldICNo'),
                        'Occupation' => $get_rep_card->row('Occupation'),
                        'Employer' => $get_rep_card->row('Employer'),
                        'Birthdate' => $get_rep_card->row('Birthdate'),
                        'Principal' => $get_rep_card->row('Principal'),
                        'Active' => $get_rep_card->row('Active'),
                        'Nationality' => $get_rep_card->row('Nationality'),
                        'LimitBF' => $get_rep_card->row('LimitBF'),
                        'LimitAmt' => $get_rep_card->row('LimitAmt'),
                        'LimitAmtAdj' => $get_rep_card->row('LimitAmtAdj'),
                        'LimitAmtUsed' => $get_rep_card->row('LimitAmtUsed'),
                        'LimitAmtBalance' => $get_rep_card->row('LimitAmtBalance'),
                        'Status' => $get_rep_card->row('Status'),
                        'Race' => $get_rep_card->row('Race'),
                        'ChildrenNo' => $get_rep_card->row('ChildrenNo'),
                        'Remarks' => $get_rep_card->row('Remarks'),
                        'Religion' => $get_rep_card->row('Religion'),
                        'PointsBF' => $get_rep_card->row('PointsBF'),
                        'Points' => $get_rep_card->row('Points'),
                        'PointsAdj' => $get_rep_card->row('PointsAdj'),
                        'Pointsused' => $get_rep_card->row('Pointsused'),
                        'Pointsbalance' => $get_rep_card->row('Pointsbalance'),
                        'Income' => $get_rep_card->row('Income'),
                        'Credit' => $get_rep_card->row('Credit'),
                        'Gender' => $get_rep_card->row('Gender'),
                        'PassportNo' => $get_rep_card->row('PassportNo'),
                        'Picture' => $get_rep_card->row('Picture'),
                        'CREATED_BY' => $get_rep_card->row('CREATED_BY'),
                        'IssueStamp' => $get_rep_card->row('IssueStamp'),
                        'UPDATED_BY' => $get_rep_card->row('UPDATED_BY'),
                        'LastStamp' => $get_rep_card->row('LastStamp'),
                        'NewForScript' => $get_rep_card->row('NewForScript'),
                        'DiscLimitActive' => $get_rep_card->row('DiscLimitActive'),
                        'DiscLimitBF' => $get_rep_card->row('DiscLimitBF'),
                        'DiscLimit' => $get_rep_card->row('DiscLimit'),
                        'DiscLimitAdj' => $get_rep_card->row('DiscLimitAdj'),
                        'DiscLimitUsed' => $get_rep_card->row('DiscLimitUsed'),
                        'DiscLimitBalance' => $get_rep_card->row('DiscLimitBalance'),
                        'DiscLimitReset' => $get_rep_card->row('DiscLimitReset'),
                        'LimitReset' => $get_rep_card->row('LimitReset'),
                        'MemberType' => $get_rep_card->row('MemberType'),
                        'Terms' => $get_rep_card->row('Terms'),
                        'CreditLimit' => $get_rep_card->row('CreditLimit'),
                        'Area' => $get_rep_card->row('Area'),
                        'Region' => $get_rep_card->row('Region'),
                        'comp_address' => $get_rep_card->row('comp_address'),
                        'comp_postcode' => $get_rep_card->row('comp_postcode'),
                        'comp_email' => $get_rep_card->row('comp_email'),
                        'biz_nature' => $get_rep_card->row('biz_nature'),
                        'biz_category' => $get_rep_card->row('biz_category'),
                        'created_at' => $get_rep_card->row('created_at'),
                        'updated_at' => $get_rep_card->row('updated_at'),
                        'staff' => $get_rep_card->row('staff'),
                        'rsupdate' => $get_rep_card->row('rsupdate'),
                        'branch' => $get_rep_card->row('branch'),
                        'referral_id' => $get_rep_card->row('referral_id'),
                        'recruiter_id' => $get_rep_card->row('recruiter_id'),
                        'name_first' => $get_rep_card->row('name_first'),
                        'name_last' => $get_rep_card->row('name_last'),
                        'replace_at' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                        'replace_by' => $_SESSION['username'],
                        'replace_type' => $replace_type,
                    );
                    $this->db->insert('member_replaced', $data);
                    // insert replacement
                    $this->db->query("UPDATE member_replaced SET rec_new = '".$get_rep_card->row('rec_new')."', rec_edit = '".$get_rep_card->row('rec_edit')."' WHERE AccountNo = '".$get_rep_card->row('AccountNo')."' AND CardNo = '".$get_rep_card->row('CardNo')."'");
                    $this->db->query("DELETE FROM member WHERE CardNo = '".$this->input->post('card_no')."'");
                    //delete card at member table

                      $server = array(
                    // 'refno' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') AS uuid ")->row('uuid'),
                    'SqlScript' => "DELETE FROM member WHERE CardNo = '".$this->input->post('card_no')."' AND AccountNo = '".$get_rep_card->row('AccountNo')."' ",
                    // 'CreatedDateTime' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                    'CreatedBy' => 'Point.cal:web_member',
                    // 'Status' => '0',
                    // 'KeyField' => '',
                    );
                    // $this->db->insert('mem_server.sqlscript', $server);
                    $this->insert_sqlscript($server);
                }

                //upd_log
                $upd = $this->db->query("SELECT Cardtype, CardNo, Expirydate from member where AccountNo = '$account_no' ");
                $upd_Cardtype = $upd->row('Cardtype');
                $upd_CardNo = $upd->row('CardNo');
                $upd_Expirydate = $upd->row('Expirydate');
                //$upd_NewForScript = $upd->row('NewForScript');
                //upd_log

                $field = array("Cardtype", "Expirydate", "CardNo");

                for ($x = 0; $x <= 2; $x++) 
                {
                    switch (${'ori_'.$field[$x]}) 
                    {
                        case ${'upd_'.$field[$x]}:
                            break;
                        default:
                            $data = array(
                                'Trans_type' => 'UPGRADE',
                                'AccountNo' => $_SESSION['account_no'],
                                'ReceiptNo' => $_SESSION['receipt_no'],
                                'field' => $field[$x],
                                'value_from' => ${'ori_'.$field[$x]},
                                'value_to' => ${'upd_'.$field[$x]},
                                'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                                'expiry_date_after' => addslashes($get_new_expiry_date),
                                'created_at' => $date,
                                'created_by' => $_SESSION['username'],
                                );
                            $this->db->insert('user_logs', $data);
                    }
                }

                if($this->db->affected_rows() > 0)
                {
                    if($this->input->post('button') == 'edit')
                    {
                        redirect('Main_c/full_details?AccountNo=' .$_SESSION['account_no']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        redirect('Transaction_c/upgrade_card');
                    }
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">Failed ! !<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Transaction_c/upgrade_card');
                }
            }
        }
        else
        {
            redirect('login_c');
        }
    }
}
?>