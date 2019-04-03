<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login_c extends CI_Controller {
    
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
        $this->load->model('Member_Model');
    }
    
    
    public function index()
    {
        $this->load->view('header');
        $this->load->view('index');
        $this->load->view('footer');
    }

    public function merchant_login()
    {
        $this->load->view('header');
        $this->load->view('merchant_login');
        $this->load->view('footer');
    }
    
    public function login_form()
    {
        // $this->form_validation->set_rules('supcode', 'Supcode', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('userpass', 'Password', 'trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->load->view('header');
            $this->load->view('index');
            $this->load->view('footer');
        }
        else
        {   
            // $supcode = $this->input->post('supcode');
            $username = $this->input->post('username');
            $userpass = $this->input->post('userpass');
            
            if ($this->input->post('login') == "Login")
            {
                $module_code = array();
                // $result  = $this->db->query("SELECT * FROM set_user WHERE user_name = '$username' AND user_pass = '$userpass'");
                //script not join web module setup

                // $result  = $this->db->query("SELECT a.*,b.`user_group_name`,d.`module_name`,e.`module_group_name`,module_code,c.`isenable` 
                //     FROM panda_b2b.set_user a 
                //     INNER JOIN panda_b2b.set_user_group b ON a.`user_group_guid` = b.`user_group_guid`
                //     INNER JOIN panda_b2b.set_user_module c ON c.`user_group_guid` = b.`user_group_guid` 
                //     INNER JOIN panda_b2b.set_module d ON d.`module_guid` = c.`module_guid`
                //     INNER JOIN panda_b2b.set_module_group e ON e.`module_group_guid`= d.`module_group_guid` 
                //     AND e.`module_group_guid` = a.`module_group_guid`
                //     WHERE a.user_id = '$username' AND a.`user_password` = '$userpass' AND a.`isactive` = 1 
                //     AND c.`isenable` = 1 AND module_group_name = 'Panda Member 2' GROUP BY d.`module_guid`;");

                $data = array(
                    'username' => $username,
                    'userpass' => $userpass,
                );

                $result = $this->Member_Model->query_call('Login_c', 'login_form', $data);

                if($result['message'] != 'success')
                {
                    $data = $this->session->set_flashdata("msg", '<div class="alert alert-danger alert-sm alert-dismissable fade in">Username or Password not Exist!</div>');
                    redirect('login_c' , $data);
                }
                else
                {
                    foreach($result['module_code'] as $row)
                    {
                        $module_code[] = $row['module_code'];
                    }

                    foreach($result['branch'] as $row)
                    {
                        $branch_code[] = $row['branch_code'];
                        $branch_name[] = $row['branch_code'];
                    }

                    $sessiondata = array(
                        'user_guid' => $result['module_code'][0]['user_guid'],
                        'module_group_guid' => $result['module_code'][0]['module_group_guid'],
                        'branch_name' => $branch_name,
                        'branch_code' => $branch_code,
                        'module_code' => $module_code,
                        // 'user_group' => $result->row('USER_GROUP'),
                        'user_group' => $result['module_code'][0]['user_group_name'],
                        'username' => $username,
                        'userpass' => $userpass,
                        'loginuser' => TRUE,
                    );
                    $this->session->set_userdata($sessiondata);

                    if($result['module_code'][0]['user_group_name'] == 'ADMIN')
                    {
                        redirect('main_c/dashbord');
                    }
                    else
                    {
                        redirect('main_c');
                    }
                }

                // if($result->num_rows() > 0)
                // {
                //     $get_loc = $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '$username' AND user_password = '$userpass' AND a.isactive = '1' AND module_group_guid = '".$result->row('module_group_guid')."' ORDER BY branch_code ASC");
                    
                //     if($get_loc->num_rows() == 0)
                //     {
                //         $data = $this->session->set_flashdata("msg", '<div class="alert alert-danger alert-sm alert-dismissable fade in">Unable to define branch.</div>');
                //         redirect('login_c' , $data);
                //     };

                //     foreach($get_loc->result() as $row)
                //     {
                //         $branch_code[] = $row->branch_code;
                //         $branch_name[] = $row->branch_name;
                //     }

                //     //set the session variables
                //     $sessiondata = array(
                //         'user_guid' => $result->row('user_guid'),
                //         'module_group_guid' => $result->row('module_group_guid'),
                //         'branch_name' => $branch_name,
                //         'branch_code' => $branch_code,
                //         'module_code' => $module_code,
                //         // 'user_group' => $result->row('USER_GROUP'),
                //         'user_group' => $result->row('user_group_name'),
                //         'username' => $username,
                //         'userpass' => $userpass,
                //         'loginuser' => TRUE,
                //     );
                //     $this->session->set_userdata($sessiondata);

                //     if($result->row('user_group_name') == 'ADMIN')
                //     {
                //         redirect('main_c/dashbord');
                //     }
                //     else
                //     {
                //         redirect('main_c');
                //     }    
                // }
                // else
                // {
                //     $data = $this->session->set_flashdata("msg", '<div class="alert alert-danger alert-sm alert-dismissable fade in">Username or Password not Exist!</div>');
                //     redirect('login_c' , $data);
                // }
                
            }
            
        }
    }

    public function merchant_login_form()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('userpass', 'Password', 'trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->load->view('header');
            $this->load->view('merchant_login');
            $this->load->view('footer');
        }
        else
        {
            $username = $this->input->post('username');
            $userpass = $this->input->post('userpass');
            
            if ($this->input->post('login') == "Login")
            {
                $data = array(
                    'username' => $username,
                    'userpass' => $userpass,
                );

                $result = $this->Member_Model->query_call('Login_c', 'merchant_login_form', $data);
                // $result  = $this->db->query("SELECT * FROM set_user WHERE user_name = '$username' AND user_pass = '$userpass'");
                //script not join web module setup

                // $result  = $this->db->query("SELECT * FROM (SELECT a.id AS user_guid,'MERCHANT' AS module_group_guid,b.`name` AS branch_name,b.`ID` AS branch_code, a.`ID`,a.`password`,'MERCHANT GROUP' as user_group_name FROM web_merchant.`user` a INNER JOIN web_merchant.`user_group` c ON c.`group_guid` = a.`user_group_guid`INNER JOIN web_merchant.`merchant` b ON a.`merchant_guid` = b.`merchant_guid` WHERE a.`ID` = '$username' AND a.`password` = '$userpass')a INNER JOIN (SELECT a.`module_code` FROM panda_b2b.`set_module` a INNER JOIN panda_b2b.`set_module_group` b ON a.`module_group_guid` = b.`module_group_guid`
                //     WHERE b.`module_group_name` = 'Panda Member 2' AND a.`module_code` IN ('ACM','UM','BPRN','CP','VIC'))b");

                if($result['message'] != 'success')
                {
                    $data = $this->session->set_flashdata("msg", '<div class="alert alert-danger alert-sm alert-dismissable fade in">'.$result['message'].'</div>');
                    redirect('login_c/merchant_login' , $data);
                }

                // if($result->num_rows() > 0)
                // {
                    foreach($result['merchant'] as $row)
                    {
                        $module_code[] = $row['module_code'];
                    }

                    // $branch_code = $row->branch_code;
                    // $branch_name = $row->branch_name;

                    $branch_code = $result['merchant']['0']['branch_code'];
                    $branch_name = $result['merchant']['0']['branch_name'];

                    //set the session variables
                    $sessiondata = array(
                        'user_guid' => $result['merchant']['0']['user_guid'],
                        'module_group_guid' => $result['merchant']['0']['module_group_guid'],
                        'branch_name' => $branch_name,
                        'branch_code' => $branch_code,
                        'module_code' => $module_code,
                        // 'user_group' => $result->row('USER_GROUP'),
                        'user_group' => $result['merchant']['0']['user_group_name'],
                        'username' => $username,
                        'userpass' => $userpass,
                        'loginuser' => TRUE,
                    );
                    $this->session->set_userdata($sessiondata);

                    if($result['merchant']['0']['user_group_name'] == 'ADMIN')
                    {
                        redirect('main_c/dashbord');
                    }
                    else
                    {
                        redirect('main_c');
                    }    
                // }
                // else
                // {
                //     $data = $this->session->set_flashdata("msg", '<div class="alert alert-danger alert-sm alert-dismissable fade in">Username or Password not Exist!</div>');
                //     redirect('login_c/merchant_login' , $data);
                // }
                
            }
        }
    }

    public function update_card()
    {
        $this->template->load('template_draft' , 'activation_draft');
    }

    public function full_details()
    {
        $branch_list = array();
        $CardNo = $this->input->post('card_no');
        $result = $this->db->query("SELECT * FROM member WHERE CardNo = '".$CardNo."' AND NAME = 'NEW' AND Issuedate = Expirydate AND Active = '0' ");

        if($result->num_rows() == 0)
        {
            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Card no. has been activated!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('Login_c/update_card');
        };

        $branch = $this->Member_Model->query_call('Login_c', 'full_details');

        if(isset($branch['branch']))
        {
            $branch_list = $branch['branch'];
        }
        
        $data = array(
            'AccountNo' => $result->row('AccountNo'),
            'CardNo' => $result->row('CardNo'),
            'Cardtype' => $result->row('Cardtype'),
            'Active' => $result->row('Active'), 
            'staff' => $result->row('staff'), 
            'Credit' => $result->row('Credit'), 
            'ICNo' => $result->row('ICNo'), 
            'Expirydate' => $result->row('Expirydate'), 
            'Issuedate' => $result->row('Issuedate'), 
            'IssueStamp' => $result->row('IssueStamp'),
            'PassportNo' => $result->row('PassportNo'),
            'Birthdate' => $result->row('Birthdate'), 
            'Title' => $result->row('Title'), 
            'Name' => $result->row('Name'), 
            'NameOnCard' => $result->row('NameOnCard'), 
            'Gender' => $result->row('Gender'),
            'Race' => $result->row('Race'), 
            'Religion' => $result->row('Religion'), 
            'Status' => $result->row('Status'), 
            'Email' => $result->row('Email'), 
            'Occupation' => $result->row('Occupation'),
            'Nationality' => $result->row('Nationality'), 
            'Phonemobile' => $result->row('Phonemobile'),
            'Phoneoffice' => $result->row('Phoneoffice'), 
            'Phonehome' => $result->row('Phonehome'), 
            'Fax' => $result->row('Fax'),
            'Address1' => $result->row('Address1'), 
            'Address2' => $result->row('Address2'), 
            'Address3' => $result->row('Address3'), 
            'Postcode' => $result->row('Postcode'),
            'City' => $result->row('City'), 
            'State' => $result->row('State'), 
            'LimitAmtBalance' => $result->row('LimitAmtBalance'), 
            'UPDATED_AT' => $result->row('updated_at'), 
            'CREATED_BY' => $result->row('CREATED_BY'), 
            'NewForScript' => $result->row('NewForScript'),

            'PointsBF' => $result->row('PointsBF'),
            'Points' => $result->row('Points'),
            'PointsAdj' => $result->row('PointsAdj'),
            'Pointsused' => $result->row('Pointsused'),
            'Pointsbalance' => $result->row('Pointsbalance'),

            'set_nationality' => $this->db->query("SELECT * FROM set_nationality "),
            'set_title' => $this->db->query("SELECT * FROM set_title "),
            'set_race' => $this->db->query("SELECT * FROM set_race "),
            'set_religion' => $this->db->query("SELECT * FROM set_religion "),
            'set_status' => $this->db->query("SELECT * FROM set_status"),
            'set_occupation' => $this->db->query("SELECT * FROM set_occupation "),
            'set_cardtype' => $this->db->query("SELECT * FROM cardtype "),

            'branch' => $result->row('branch'),
            // 'select_branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid "),
            'select_branch' => $branch_list,

            'decision' => 'readonly',
            'page_title' => 'Member Details',
            'button' => 'Update',
            'direction' => site_url('Main_c/update'),
            'check_active' => $this->db->query("SELECT COUNT(*) AS active FROM member WHERE AccountNo = '".$result->row('AccountNo')."' AND Active = 1 AND Expirydate <> Issuedate")->row('active'),

            'movement_point_details' => $this->db->query("SELECT * FROM points_movement WHERE AccountNo = '".$result->row('AccountNo')."'")
            );
        $this->template->load('template_draft' , 'full_details_draft' , $data);
    }

    public function update_full_details()
    {
        $_SESSION['branch'] = $this->input->post('branch');
        $check_ic_no = $this->db->query("SELECT * FROM `member` WHERE ICNo = '".$this->input->post('ic_no')."' ");

        if($check_ic_no->num_rows() > 0 && (strtoupper($this->input->post('national')) == 'MALAYSIAN' || strtoupper($this->input->post('national')) == 'MALAYSIA'))
        {
            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Member already exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('Login_c/update_card');
        };

        $Birthdate = $this->input->post('Birthdate');
        /*$originalDate = $this->input->post('expiry_date');
        $newDate = date("Y-m-d", strtotime($originalDate));*/
        $get_new_expiry_date = $this->db->query("SELECT '".$this->input->post('Expirydate')."'+INTERVAL 1 YEAR AS Expirydate")->row('Expirydate');

        $data = array(
            'Nationality' => $this->input->post('Nationality'), 
            'ICNo' => $this->input->post('ICNo'), 
            'PassportNo' => $this->input->post('PassportNo'),
            'Title' => $this->input->post('Title'), 
            'Name' => $this->input->post('Name'), 
            'NameOnCard' => $this->input->post('NameOnCard'), 
            'Birthdate' => $this->db->query("SELECT CONCAT('19', LEFT($Birthdate, 2), '/', MID($Birthdate, 3, 2), '/', RIGHT($Birthdate, 2)) AS date ")->row('date'), 
            'Active' => '1',
            'Gender' => $this->input->post('Gender'),
            'Race' => $this->input->post('Race'), 
            'Religion' => $this->input->post('Religion'), 
            'Status' => $this->input->post('Status'), 
            'Occupation' => $this->input->post('Occupation'),
            
            'Email' => $this->input->post('Email'), 
            'Phonemobile' => $this->input->post('Phonemobile'),
            'Phoneoffice' => $this->input->post('Phoneoffice'), 
            'Phonehome' => $this->input->post('Phonehome'),
            'Expirydate' => $get_new_expiry_date,
            'Fax' => $this->input->post('Fax'),
            'Address1' => $this->input->post('Address1'), 
            'Address2' => $this->input->post('Address2'), 
            'Address3' => $this->input->post('Address3'), 
            'Postcode' => $this->input->post('Postcode'),
            'City' => $this->input->post('City'), 
            'State' => $this->input->post('State'), 
            
            //'Active' => $this->input->post('Active'), 
            //'staff' => $this->input->post('staff'), 
            'Cardtype' => $this->input->post('Cardtype'),
            'Credit' => $this->input->post('Credit'), 
            'LimitAmtBalance' => $this->input->post('LimitAmtBalance'), 
            // 'Expirydate' => $Expirydate, 
            // 'Issuedate' => $Issuedate,

            'branch' => $this->input->post('branch'),
            'updated_at' => $this->db->query("SELECT NOW() as datetime")->row('datetime'),
            'NewForScript' => "1",
            );

        $this->db->where('AccountNo', $this->input->post('AccountNo'));
        $this->db->update('member' , $data);

        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update records successfully!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
        }
        else
        {
            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update member details!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
        }

        redirect('Login_c/update_card');
    }

    public function change_password()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $this->template->load('template' , 'change_password');
        }
        else
        {
            redirect('login_c');
        }
        
    }

    public function save_password()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            if($this->input->post('Old_Password') != $_SESSION['userpass'])
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Incorrect old password<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                redirect('Login_c/change_password');
            }
            else
            {
                if($this->input->post('New_Password') != $this->input->post('Confirm_New_Password'))
                {
                    /*$_SESSION['Old_Password'] = $this->input->post('Old_Password');*/
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">New password does not match<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                    redirect('Login_c/change_password');
                }
                else
                {
                    // $info = array(
                    //     'user_password' => $this->input->post('New_Password'),
                    // );
                    // $this->db->where('user_guid', $_SESSION['user_guid']);
                    // $this->db->update('panda_b2b.set_user', $info);

                    $data = array(
                        'password' => $this->input->post('New_Password'),
                        'user_guid' => $_SESSION['user_guid'],
                    );

                    $result = $this->Member_Model->query_call('Login_c', 'save_password', $data);

                    if($result['message'] != 'success')
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to change password<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                        redirect('Login_c/change_password');
                    }

                    // if($this->db->affected_rows() > 0)
                    // {
                    //     $this->session->set_flashdata("msg", '<div class="alert alert-success text-center">Password changed successfully</div>');

                    //     redirect('Login_c');
                    // }
                    // else
                    // {
                    //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to change password<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                    //     redirect('Login_c/change_password');
                    // }

                    $this->session->set_flashdata("msg", '<div class="alert alert-success text-center">Password changed successfully</div>');

                    redirect('Login_c');
                }  
            }
        }
        else
        {
            redirect('login_c');
        }
        
    }
}
