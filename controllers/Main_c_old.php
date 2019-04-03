<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main_c extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        /*updated via*/
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
        $this->load->model('Point_Model');
	}

    public function check_parameter()
    {
        $query = $this->db->query("SELECT * FROM backend_member.`set_parameter`");
        return $query; 
    }

    public function dashbord()
    {
        if($this->session->userdata('loginuser')== true)
        { 
            $total_activation = $this->db->query("SELECT COUNT(AccountNo) AS num FROM backend_member.member WHERE Active = 1 and Expirydate > CURDATE() ")->row('num');
            $total_member = $this->db->query("SELECT COUNT(AccountNo) AS num FROM backend_member.member")->row('num');
            $total_preactivated = $this->db->query("SELECT count(AccountNo) as num FROM backend_member.`member` a WHERE a.`Expirydate` = '3000-12-31';")->row('num');

            if($total_activation == 0 || $total_member == 0)
            {
                $total_active_percent = 0;
            }
            else
            {
                $total_active_percent = $total_activation / $total_member * 100;
            }

            $data = array(
                'total_member' => $total_member,
                'total_preactivated' => $total_preactivated,
                'total_expiry_date_member' => $total_expiry_date_member = $this->db->query("SELECT COUNT(AccountNo) AS num FROM backend_member.member a WHERE Expirydate < CURDATE() AND a.`Expirydate` <> a.`Issuedate`")->row('num'),
                'total_activation' => $total_activation,
                'total_voucher' => $total_voucher = $this->db->query("SELECT COUNT(AccountNo) AS num FROM membervoucher")->row('num'),

                'total_active_percent' => $total_active_percent,

                'last_activity' => $this->db->query("SELECT 
                      a.AccountNo AS AccountNo,
                      a.Trans_type AS TYPE,
                      b.Name,
                      a.created_at,
                      a.created_by 
                    FROM
                      user_logs AS a
                      INNER JOIN member as b on a.accountno = b.accountno
                    WHERE a.created_at > DATE_SUB(NOW(), INTERVAL 1 DAY) 
                      AND a.Trans_type IN (
                        'RENEW',
                        'UPDATE RECORD',
                        'ACTIVATION',
                        'ISSUE MAIN CARD',
                        'ISSUE SUP CARD',
                        'UPDATE ACTIVE',
                        'UPDATE SUSPEND',
                        'UPDATE TERMINATE'
                      ) 
                    GROUP BY a.AccountNo,
                      LEFT(a.created_at, 10),a.Trans_type
                      ORDER BY a.created_at DESC"),
                );

            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0); 
            ini_set('memory_limit','2048M');

            $this->template->load('template' , 'dashbord', $data);
        }
        else
        {
            redirect('login_c');
        }
    }
    
    public function index()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $json_branch_code = json_encode($_SESSION['branch_code']);
            $branch_code = $this->db->query("SELECT REPLACE(REPLACE('$json_branch_code', '[', ''), ']', '') AS branch_code")->row('branch_code');
            if($_SESSION['user_group'] == 'MERCHANT GROUP')
            {
                $data['data'] = $this->db->query("SELECT * FROM member WHERE CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') LIMIT 500");
                $data['form_search'] = site_url('Main_c/search_merchant');
            }
            else
            {
                $data['data'] = $this->db->query("SELECT * FROM (
                   SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE accountno NOT IN (SELECT accountno FROM backend_member.membersupcard ) 
                    UNION ALL              
                    SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a 
                    INNER JOIN backend_member.membersupcard b 
                    ON a.accountno = b.accountno)a LIMIT 500");
                $data['form_search'] = site_url('Main_c/search');
            }
            ini_set('memory_limit', '-1');
            $this->template->load('template' , 'home' , $data);
        }
        else
        {
            redirect('login_c');
        }
        
    }

    public function all_member()
    {
        if($_SESSION['user_group'] == 'MERCHANT GROUP')
        {
            $query = $this->db->query("SELECT COUNT(CardNo) FROM member WHERE CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')");
        }
        else
        {
            $query = $this->db->query("SELECT COUNT(CardNo) AS num FROM (
               SELECT CardNo FROM backend_member.member WHERE accountno NOT IN (SELECT accountno FROM backend_member.membersupcard ) 
                UNION ALL              
                SELECT b.SupCardNo AS CardNo FROM backend_member.member a 
                INNER JOIN backend_member.membersupcard b 
                ON a.accountno = b.accountno)a");
        }

        $columns = array(
            0 => 'CardNo',
            1 => 'AccountNo',
            2 => 'Expirydate',
            3 => 'ICNo',
            4 => 'Phonemobile',
            5 => 'Name',
            6 => 'Full Detail',
            7 => 'Purchase Details'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalFiltered = $totalData = $query->row('num');
       
        $posts = $this->Trans_Model->allposts($limit,$start,$dir,$order);

        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $supcard = $this->db->query("SELECT IF(COUNT(*) > 0,1,0) AS result FROM member a INNER JOIN membersupcard b ON a.`AccountNo` = b.`AccountNo` WHERE a.`AccountNo` = '".$post->AccountNo."' AND b.`PrincipalCardNo` = 'SUPCARD'");

                if($supcard->row('result') > 0)
                {
                    $sup_button = '<a href="'.site_url('main_c/supcard_details').'?AccountNo='.$post->AccountNo.'&Name='.$post->Name.'"><button title="View" type="button" class="btn btn-xs btn-info">Sup Card <i class="fa fa-eye"></i></button></a>';
                }
                else
                {
                    $sup_button = '';
                }

                $disabled = "";
                $nestedData['CardNo'] = $post->CardNo;
                $nestedData['AccountNo'] = $post->AccountNo;
                $nestedData['Expirydate'] = $post->Expirydate;
                $nestedData['ICNo'] = $post->ICNo;
                $nestedData['Phonemobile'] = $post->Phonemobile;
                $nestedData['Name'] = $post->Name;
                $nestedData['Full Detail'] = '<center><a href="'.site_url('main_c/full_details').'?AccountNo='.$post->AccountNo.'"><button title="View" type="button" class="btn btn-xs btn-primary">Primary Card <i class="fa fa-eye"></i></button></a>&ensp;'.$sup_button.'</center>';


              if($_SESSION['user_group'] == 'MERCHANT GROUP')
              {
                $disabled = "disabled";
              }
                $nestedData['Purchase Details'] = '<center><a href = "'.site_url('main_c/purchase_details').'?AccountNo='.$post->AccountNo.'&Name='.$post->Name.'"><button title="View" type="button" class="btn btn-xs btn-success" '.$disabled.' >Purchase Details <i class="fa fa-eye"></i></button></a></center>';
                $data[] = $nestedData;

            }
        }
        else
        {
            $data = '';
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }

    public function search()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $json_branch_code = json_encode($_SESSION['branch_code']);
            $branch_code = $this->db->query("SELECT REPLACE(REPLACE('$json_branch_code', '[', ''), ']', '') AS branch_code")->row('branch_code');

            $data['keys'] = $this->input->post('memberno');
            $data['search'] = $this->input->post('search');

            $key = $this->input->post('memberno');
            if($this->input->post('search') == 'General')
            {
                $data['data'] = $this->db->query("SELECT * FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE NAME LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE cardno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE accountno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE icno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE oldicno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE passportno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Phonemobile LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Address1 LIKE '%$key%' 
                    UNION ALL
                    SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' )a1  GROUP BY accountno");

                //echo $this->db->last_query();die;
            };

            if($this->input->post('search') == 'Card')
            {
                // $result = $this->db->query("SELECT IF((SELECT COUNT(*) FROM backend_member.membersupcard WHERE SupCardNo like '%$key%')>0 , 'true', 'false') AS result ")->row('result');

                // if($result == 'true')
                // {
                //     $data['data'] = $this->db->query("SELECT * FROM backend_member.membersupcard WHERE SupCardNo LIKE '%$key%' ");
                // }
                // else
                // {
                //     $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE CardNo LIKE '%$key%' ");
                // }

                $data['data'] = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name` FROM backend_member.member WHERE CardNo like '%$key%' UNION ALL
                    SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' ");
            };

            if($this->input->post('search') == 'Account')
            {
                $data['data'] = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE AccountNo LIKE '%$key%' 
                    UNION ALL
                    SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.AccountNo LIKE '%$key%' ");
            };

            if($this->input->post('search') == 'Name')
            {
                $data['data'] = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Name like '%$key%' UNION ALL
                    SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Name LIKE '%$key%'");
            };

            if($this->input->post('search') == 'Passport')
            {
                $data['data'] = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE PassportNo like '%$key%' ");
            };

            if($this->input->post('search') == 'Ic')
            {
                $data['data'] = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE ICNo like '%$key%' 
                    UNION ALL
                    SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.ICNo LIKE '%$key%'");
            };

            if($this->input->post('search') == 'Phone')
            {
                $data['data'] = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Phonemobile LIKE '%$key%' 
                    UNION ALL
                    SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Phonemobile LIKE '%$key%' ");
            };

            if($this->input->post('search') == 'Address')
            {
                $data['data'] = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Address1 LIKE '%$key%' 
                    UNION ALL
                    SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Address1 LIKE '%$key%';");
            };
            $data['form_search'] = site_url('Main_c/search');
            $this->template->load('template' , 'home' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function all_member_1()
    {
        $key = $_REQUEST['key'];

        if($_REQUEST['searchs'] == 'General')
        {
            $query = $this->db->query("SELECT * FROM (
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE NAME LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE cardno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE accountno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE icno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE oldicno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE passportno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Phonemobile LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Address1 LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' )a1  GROUP BY accountno");

            //echo $this->db->last_query();die;
        };

        if($_REQUEST['searchs'] == 'Card')
        {
            // $result = $this->db->query("SELECT IF((SELECT COUNT(*) FROM backend_member.membersupcard WHERE SupCardNo like '%$key%')>0 , 'true', 'false') AS result ")->row('result');

            // if($result == 'true')
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM backend_member.membersupcard WHERE SupCardNo LIKE '%$key%' ");
            // }
            // else
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE CardNo LIKE '%$key%' ");
            // }

            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name` FROM backend_member.member WHERE CardNo like '%$key%' UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Account')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE AccountNo LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.AccountNo LIKE '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Name')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Name like '%$key%' UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Name LIKE '%$key%'");
        };

        if($_REQUEST['searchs'] == 'Passport')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE PassportNo like '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Ic')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE ICNo like '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.ICNo LIKE '%$key%'");
        };

        if($_REQUEST['searchs'] == 'Phone')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Phonemobile LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Phonemobile LIKE '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Address')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Address1 LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Address1 LIKE '%$key%';");
        };

        $columns = array(
            0 => 'Card No',
            1 => 'Account No',
            2 => 'Expired Date',
            3 => 'IC No',
            4 => 'Phone No',
            5 => 'Name',
            6 => 'Full Detail',
            7 => 'Purchase Details'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $query->num_rows();
        $totalFiltered = $totalData;
    
        $posts = $this->Trans_Model->allposts_1($limit,$start,$dir,$_REQUEST['searchs'],$key);

        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $supcard = $this->db->query("SELECT IF(COUNT(*) > 0,1,0) AS result FROM member a INNER JOIN membersupcard b ON a.`AccountNo` = b.`AccountNo` WHERE a.`AccountNo` = '".$post->AccountNo."' AND b.`PrincipalCardNo` = 'SUPCARD'");

                if($supcard->row('result') > 0)
                {
                    $sup_button = '<a href="'.site_url('main_c/supcard_details').'?AccountNo='.$post->AccountNo.'&Name='.$post->Name.'"><button title="View" type="button" class="btn btn-xs btn-info">Sup Card <i class="fa fa-eye"></i></button></a>';
                }
                else
                {
                    $sup_button = '';
                }

                $disabled = "";
                $nestedData['Card No'] = $post->CardNo;
                $nestedData['Account No'] = $post->AccountNo;
                $nestedData['Expired Date'] = $post->Expirydate;
                $nestedData['IC No'] = $post->ICNo;
                $nestedData['Phone No'] = $post->Phonemobile;
                $nestedData['Name'] = $post->Name;
                $nestedData['Full Detail'] = '<center><a href="'.site_url('main_c/full_details').'?AccountNo='.$post->AccountNo.'"><button title="View" type="button" class="btn btn-xs btn-primary">Primary Card <i class="fa fa-eye"></i></button></a>&ensp;'.$sup_button.'</center>';
                

                /*if($supcard->row('result') > 0)
                {
                    $nestedData['Full Detail'] = '<a href="'.site_url('main_c/supcard_details').'?AccountNo='.$post->AccountNo.'&Name='.$post->Name.'"><button title="View" type="button" class="btn btn-xs btn-info">Sup Card <i class="fa fa-eye"></i></button></a>';
                };*/


              if($_SESSION['user_group'] == 'MERCHANT GROUP')
              {
                $disabled = "disabled";
              }
                $nestedData['Purchase Details'] = '<center><a href = "'.site_url('main_c/purchase_details').'?AccountNo='.$post->AccountNo.'&Name='.$post->Name.'"><button title="View" type="button" class="btn btn-xs btn-success" '.$disabled.' >Purchase Details <i class="fa fa-eye"></i></button></a></center>';
                $data[] = $nestedData;

            }
        }
        else
        {
            $data = "";
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }

    public function all_member_2()
    {
        $key = $_REQUEST['key'];

        if($_REQUEST['searchs'] == 'General')
        {
            $query = $this->db->query("SELECT * FROM (
                SELECT * FROM backend_member.member WHERE NAME LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE cardno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE accountno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE icno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE oldicno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE passportno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE Phonemobile LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE Address1 LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') 
                UNION ALL
                SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno 
                WHERE supcardno LIKE '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."'))a1  
                GROUP BY accountno");

            //echo $this->db->last_query();die;
        };

        if($_REQUEST['searchs'] == 'Card')
        {
            // $result = $this->db->query("SELECT IF((SELECT COUNT(*) FROM backend_member.membersupcard WHERE SupCardNo like '%$key%')>0 , 'true', 'false') AS result ")->row('result');

            // if($result == 'true')
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM backend_member.membersupcard WHERE SupCardNo LIKE '%$key%' ");
            // }
            // else
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE CardNo LIKE '%$key%' ");
            // }

            $query = $this->db->query("SELECT * FROM backend_member.member WHERE CardNo like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' )UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Account')
        {
            $query = $this->db->query("SELECT * FROM backend_member.member WHERE AccountNo like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.AccountNo LIKE '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Name')
        {
            $query = $this->db->query("SELECT * FROM backend_member.member WHERE Name like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' )UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Name LIKE '%$key%'");
        };

        if($_REQUEST['searchs'] == 'Passport')
        {
            $query = $this->db->query("SELECT * FROM backend_member.member WHERE PassportNo like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' ");
        };

        if($_REQUEST['searchs'] == 'Ic')
        {
            $query = $this->db->query("SELECT * FROM backend_member.member WHERE ICNo like '%$key%' 
                    AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.ICNo LIKE '%$key%'");
        };

        if($_REQUEST['searchs'] == 'Phone')
        {
            $query = $this->db->query("SELECT * FROM backend_member.member WHERE Phonemobile LIKE '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' )
                    UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Phonemobile LIKE '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Address')
        {
            $query = $this->db->query("SELECT * FROM backend_member.member WHERE Address1 LIKE '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                    UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Address1 LIKE '%$key%';");
        };

        $columns = array(
            0 => 'Card No',
            1 => 'Account No',
            2 => 'Expired Date',
            3 => 'IC No',
            4 => 'Phone No',
            5 => 'Name',
            6 => 'Full Detail',
            7 => 'Purchase Details'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $query->num_rows();
        $totalFiltered = $totalData;
    
        $posts = $this->Trans_Model->allposts_2($limit,$start,$dir,$_REQUEST['searchs'],$key);

        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $disabled = "";
                $nestedData['Card No'] = $post->CardNo;
                $nestedData['Account No'] = $post->AccountNo;
                $nestedData['Expired Date'] = $post->Expirydate;
                $nestedData['IC No'] = $post->ICNo;
                $nestedData['Phone No'] = $post->Phonemobile;
                $nestedData['Name'] = $post->Name;
                $nestedData['Full Detail'] = '<a href="'.site_url('main_c/full_details').'?AccountNo='.$post->AccountNo.'"><button title="View" type="button" class="btn btn-xs btn-primary">Primary Card <i class="fa fa-eye"></i></button></a>';

              if($_SESSION['user_group'] == 'MERCHANT GROUP')
              {
                $disabled = "disabled";
              }
                $nestedData['Purchase Details'] = '<a href = "'.site_url('main_c/purchase_details').'?AccountNo='.$post->AccountNo.'&Name='.$post->Name.'"><button title="View" type="button" class="btn btn-xs btn-success" '.$disabled.' >Purchase Details <i class="fa fa-eye"></i></button></a>';
                $data[] = $nestedData;

            }
        }
        else
        {
            $data = "";
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }

    public function search_merchant()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $json_branch_code = json_encode($_SESSION['branch_code']);
            $branch_code = $this->db->query("SELECT REPLACE(REPLACE('$json_branch_code', '[', ''), ']', '') AS branch_code")->row('branch_code');

            $data['keys'] = $this->input->post('memberno');
            $data['search'] = $this->input->post('search');

            $key = $this->input->post('memberno');
            if($this->input->post('search') == 'General')
            {
                $data['data'] = $this->db->query("SELECT * FROM (
                SELECT * FROM backend_member.member WHERE NAME LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE cardno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE accountno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE icno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE oldicno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE passportno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE Phonemobile LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM backend_member.member WHERE Address1 LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') 
                UNION ALL
                SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno 
                WHERE supcardno LIKE '%$key%')a1  
                GROUP BY accountno");

                //echo $this->db->last_query();die;
            };

            if($this->input->post('search') == 'Card')
            {
                // $result = $this->db->query("SELECT IF((SELECT COUNT(*) FROM backend_member.membersupcard WHERE SupCardNo like '%$key%')>0 , 'true', 'false') AS result ")->row('result');

                // if($result == 'true')
                // {
                //     $data['data'] = $this->db->query("SELECT * FROM backend_member.membersupcard WHERE SupCardNo LIKE '%$key%' ");
                // }
                // else
                // {
                //     $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE CardNo LIKE '%$key%' ");
                // }

                $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE CardNo like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' )UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' ");
            };

            if($this->input->post('search') == 'Account')
            {
                $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE AccountNo like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.AccountNo LIKE '%$key%' ");
            };

            if($this->input->post('search') == 'Name')
            {
                $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE Name like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' )UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Name LIKE '%$key%'");
            };

            if($this->input->post('search') == 'Passport')
            {
                $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE PassportNo like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' ");
            };

            if($this->input->post('search') == 'Ic')
            {
                $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE ICNo like '%$key%' 
                    AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.ICNo LIKE '%$key%'");
            };

            if($this->input->post('search') == 'Phone')
            {
                $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE Phonemobile LIKE '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' )
                    UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Phonemobile LIKE '%$key%' ");
            };

            if($this->input->post('search') == 'Address')
            {
                $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE Address1 LIKE '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                    UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Address1 LIKE '%$key%';");
            };
            $data['form_search'] = site_url('Main_c/search_merchant');
            $this->template->load('template' , 'home' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function full_details()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $result = $this->db->query("SELECT * FROM member WHERE AccountNo = '".$_REQUEST['AccountNo']."' ");

            $check_lost_card = $this->db->query("SELECT * from membersupcard where accountno = '".$_REQUEST['AccountNo']."' and principalcardno = 'LOSTCARD' order by laststamp desc");
            //echo $this->db->last_query();die;
            if($check_lost_card->num_rows() == '0')
            {
                $cardno = $result->row('CardNo');
            }
            else
            {
                $cardno = $check_lost_card->row('SupCardNo');
            };

            $ic = $this->db->query("SELECT REPLACE('".$result->row('ICNo')."', '-', '') AS ic ")->row('ic');

            $data = array(
                'AccountNo' => $result->row('AccountNo'),
                'CardNo' => $cardno,
                'Cardtype' => $result->row('Cardtype'),
                'Active' => $result->row('Active'), 
                'staff' => $result->row('staff'), 
                'Credit' => $result->row('Credit'), 
                'ICNo' => $this->db->query("SELECT REPLACE('".$result->row('ICNo')."', '-', '') AS ic ")->row('ic'),
                'army_no' => $result->row('ICNo'),  
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

                'set_nationality' => $this->db->query("SELECT * FROM backend_member.set_nationality ORDER BY Nationality ASC "),
                'set_title' => $this->db->query("SELECT * FROM backend_member.set_title ORDER BY Title ASC"),
                'set_race' => $this->db->query("SELECT * FROM backend_member.set_race ORDER BY Race ASC"),
                'set_religion' => $this->db->query("SELECT * FROM backend_member.set_religion ORDER BY Religion ASC"),
                'set_status' => $this->db->query("SELECT * FROM backend_member.set_status ORDER BY Status ASC"),
                'set_occupation' => $this->db->query("SELECT * FROM backend_member.set_occupation ORDER BY Occupation ASC"),
                'set_misc' => $this->db->query("SELECT * FROM backend_member.set_misc ORDER BY misc_name ASC"),
                'set_cardtype' => $this->db->query("SELECT * FROM backend_member.cardtype ORDER BY Cardtype ASC"),

                'branch' => $result->row('branch'),
                'select_branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),

                'decision' => 'readonly',
                'page_title' => 'Member Details',
                'button' => 'Update',
                'direction' => site_url('Main_c/update'),
                'check_active' => $this->db->query("SELECT COUNT(*) AS active FROM backend_member.member WHERE AccountNo = '".$_REQUEST['AccountNo']."' AND Active = 1 AND Expirydate <> Issuedate")->row('active'),

                'movement_point_details' => $this->db->query("SELECT *, (Pointsbalance - PointsBF) AS Pointsearn FROM backend_member.points_movement WHERE AccountNo = '".$_REQUEST['AccountNo']."' ORDER BY `PeriodCode` DESC"),

                'cardhistory' => $this->db->query("SELECT cardno, created_at , 'First Card' as status from member where accountno = '".$_REQUEST['AccountNo']."'
                    union all
                    SELECT supcardno as cardno, issuestamp as created_at, 'Replaced' as status from membersupcard where accountno = '".$_REQUEST['AccountNo']."' and principalcardno = 'LOSTCARD'"),

                'disabled_branch' => $this->db->query("SELECT * FROM member_merchantcard WHERE CardNo = '$cardno' ")->num_rows(),
                'mem_misc' => $this->db->query("SELECT misc_guid, seq, text1, value1, text2, value2, remark, set_active, misc_group from member_miscellaneous where accountno = '".$_REQUEST['AccountNo']."'"),
                'active_expiry' => $this->check_parameter()->row('point_expiry'),
                'expiry_on' => $this->Point_Model->get_cut_off_point_expiry_date()['cut_off_date'],
                'purchase_list' => $this->db->query("
                    SELECT * FROM
                    (
                        SELECT 'Counter' AS TRANS_TYPE, RefNo, Location, BizDate, SysDate, User, Points, BillAmt, BillStatus, 
                        CONCAT(POSID, '-', USER) AS Created_By FROM frontend.posmain 
                        WHERE LEFT(BizDate, 7) = LEFT(CURDATE(), 7) AND AccountNo = '".$_REQUEST['AccountNo']."'
                        UNION ALL
                        SELECT TRANS_TYPE, REF_NO, branch AS Location, TRANS_DATE AS BizDate, '' AS SysDate, SUP_NAME AS User, VALUE_TOTAL AS Points,
                        '' AS BillAmt, '' AS BillStatus, Created_By FROM backend_member.trans_main
                        WHERE LEFT(TRANS_DATE, 7) = LEFT(CURDATE(), 7) AND SUP_CODE = '".$_REQUEST['AccountNo']."'
                    ) AS a
                    ORDER BY a.BizDate DESC, a.RefNo DESC
                "),
                'preissue_card_method' => $this->check_parameter()->row('preissue_card_method'),
                );

            if($this->check_parameter()->row('point_expiry') == 1)
            {
                $data['point_expiry'] = $this->Point_Model->get_point_expiry_by_account($this->Point_Model->get_cut_off_point_expiry_date()['end_period'],$result->row('AccountNo'))->row('point_expiry');
            }

            $preissue_card_method = $this->check_parameter()->row('preissue_card_method');
            if($preissue_card_method == 0)
            {
                $data['changes'] = $this->db->query("SELECT * FROM backend_member.mem_ii_trans WHERE CardNo = '".$result->row('AccountNo')."' ORDER BY created_at DESC");
            }

            $this->template->load('template' , 'full_details' , $data);
        
        }
        else
        {
            redirect('login_c');
        }
        
    }

    public function supcard_details()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['CardNo']))
            {
                $result = $this->db->query("SELECT * FROM membersupcard WHERE AccountNo = '".$_REQUEST['AccountNo']."' AND SupCardNo = '".$_REQUEST['CardNo']."' AND `PrincipalCardNo` = 'SUPCARD' ");
            }
            else
            {
                $result = $this->db->query("SELECT *, Phonemobile as PhoneMobile FROM membersupcard WHERE AccountNo = '".$_REQUEST['AccountNo']."' AND `PrincipalCardNo` = 'SUPCARD' limit 1 ");
            }
            //echo $this->db->last_query();die;
            $data = array(
                'AccountNo' => $result->row('AccountNo'),
                'CardNo' => $result->row('SupCardNo'),
                'ICNo' => $result->row('ICNo'), 
                'Expirydate' => $result->row('Expirydate'), 
                'Issuedate' => $result->row('Issuedate'), 
                'IssueStamp' => $result->row('IssueStamp'),
                'UPDATED_BY' => $result->row('UPDATED_BY'), 
                'UPDATED_AT' => $result->row('UPDATED_AT'),
                'PassportNo' => $result->row('PassportNo'),
                'Birthdate' => $result->row('Birthdate'), 
                'Title' => $result->row('Title'), 
                'Name' => $result->row('Name'), 
                'NameOnCard' => $result->row('NameOnCard'), 
                'Gender' => $result->row('Gender'),
                'Email' => $result->row('email'), 
                
                'Nationality' => $result->row('Nationality'), 
                'Phonemobile' => $result->row('PhoneMobile'),
                'Relationship' => $result->row('Relationship'),

                'set_nationality' => $this->db->query("SELECT * FROM backend_member.set_nationality "),
                'set_title' => $this->db->query("SELECT * FROM backend_member.set_title "),
                'set_relationship' => $this->db->query("SELECT * FROM backend_member.set_relationship "),
                'supcard_record' => $this->db->query("SELECT * FROM backend_member.membersupcard WHERE AccountNo = '".$_REQUEST['AccountNo']."' AND PrincipalCardNo = 'SUPCARD' "),

                'decision' => 'readonly',
                'page_title' => 'Member Details',
                'button' => 'Update',
                'direction' => site_url('Main_c/update'),
            );
             $this->template->load('template' , 'supcard_details' , $data);
        }
        else
        {
            redirect('login_c');
        }  
    }

    public function purchase_list()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $purchase = $this->db->query("
                SELECT * FROM
                (
                    SELECT 'COUNTER' AS TRANS_TYPE, RefNo, Location, BizDate, SysDate, User, Points, BillAmt, BillStatus, 
                    CONCAT(POSID, '-', USER) AS Created_By FROM frontend.posmain 
                    WHERE LEFT(BizDate, 7) = '".$_REQUEST['month']."' AND AccountNo = '".$_REQUEST['accountno']."'
                    UNION ALL
                    SELECT TRANS_TYPE, REF_NO, branch AS Location, TRANS_DATE AS BizDate, '' AS SysDate, SUP_NAME AS User, VALUE_TOTAL AS Points,
                    '' AS BillAmt, '' AS BillStatus, Created_By FROM backend_member.trans_main
                    WHERE LEFT(TRANS_DATE, 7) = '".$_REQUEST['month']."' AND SUP_CODE = '".$_REQUEST['accountno']."'
                ) AS a
                ORDER BY a.BizDate DESC, a.RefNo DESC
            ");

            $html = "";

            if($purchase->num_rows() > 0)
            {
                foreach ($purchase->result() as $row) {
                    $html .= "<tr>
                                <td>".$row->TRANS_TYPE."</td>
                                <td>".$row->RefNo."</td>
                                <td>".$row->Location."</td>
                                <td>".$row->BizDate."</td>
                                <td>".$row->SysDate."</td>
                                <td>".$row->User."</td>
                                <td>".$row->Points."</td>
                                <td>".$row->BillAmt."</td>
                                <td>".$row->BillStatus."</td>
                                <td>".$row->Created_By."</td>
                            </tr>";
                }
            }
            else
            {
                $html .= "<tr><td colspan = '9' align='center' style='width:100%;'>No Data Found</td></tr>";
            }

            echo $html;
        }
        else
        {
            redirect('login_c');
        }
    }

    /*public function direct_back_full_details()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $result = $this->db->query("SELECT * FROM member WHERE AccountNo = '".$this->input->post('AccountNo')."' ");
            
            $data = array(
                'AccountNo' => $result->row('AccountNo'),
                'CardNo' => $result->row('CardNo'),
                'Cardtype' => $result->row('Cardtype'),
                'Active' => $this->input->post('Active'), 
                'staff' => $this->input->post('staff'), 
                'Credit' => $result->row('Credit'), 
                'ICNo' => $this->input->post('ICNo'), 
                'army_no' => $this->input->post('army_no'),  
                'Expirydate' => $result->row('Expirydate'), 
                'Issuedate' => $result->row('Issuedate'), 
                'IssueStamp' => $result->row('IssueStamp'),
                'PassportNo' => $this->input->post('PassportNo'), 
                'Birthdate' => $this->input->post('Birthdate'),  
                'Title' => $this->input->post('Title'),  
                'Name' => $this->input->post('Name'), 
                'NameOnCard' => $this->input->post('NameOnCard'), 
                'Gender' => $this->input->post('Gender'), 
                'Race' => $this->input->post('Race'),  
                'Religion' => $this->input->post('Religion'),  
                'Status' => $this->input->post('Status'), 
                'Email' => $this->input->post('Email'), 
                'Occupation' => $this->input->post('Occupation'), 
                'Nationality' => $this->input->post('Nationality'), 
                'Phonemobile' => $this->input->post('Phonemobile'), 
                'Phoneoffice' => $this->input->post('Phoneoffice'), 
                'Phonehome' => $this->input->post('Phonehome'),  
                'Fax' => $this->input->post('Fax'), 
                'Address1' =>$this->input->post('Address1'), 
                'Address2' => $this->input->post('Address2'),  
                'Address3' => $this->input->post('Address3'),  
                'Postcode' => $this->input->post('Postcode'),
                'City' => $city, 
                'State' => $state, 
                'LimitAmtBalance' => $result->row('LimitAmtBalance'), 
                'UPDATED_AT' => $result->row('updated_at'), 
                'CREATED_BY' => $result->row('CREATED_BY'), 
                'NewForScript' => $result->row('NewForScript'),

                'PointsBF' => $result->row('PointsBF'),
                'Points' => $result->row('Points'),
                'PointsAdj' => $result->row('PointsAdj'),
                'Pointsused' => $result->row('Pointsused'),
                'Pointsbalance' => $result->row('Pointsbalance'),

                'set_nationality' => $this->db->query("SELECT * FROM backend_member.set_nationality "),
                'set_title' => $this->db->query("SELECT * FROM backend_member.set_title "),
                'set_race' => $this->db->query("SELECT * FROM backend_member.set_race "),
                'set_religion' => $this->db->query("SELECT * FROM backend_member.set_religion "),
                'set_status' => $this->db->query("SELECT * FROM backend_member.set_status"),
                'set_occupation' => $this->db->query("SELECT * FROM backend_member.set_occupation "),
                'set_cardtype' => $this->db->query("SELECT * FROM backend_member.cardtype "),

                'branch' => $result->row('branch'),
                'select_branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),

                'decision' => 'readonly',
                'page_title' => 'Member Details',
                'button' => 'Update',
                'direction' => site_url('Main_c/update'),
                'check_active' => $this->db->query("SELECT COUNT(*) AS active FROM backend_member.member WHERE AccountNo = '".$_REQUEST['AccountNo']."' AND Active = 1 AND Expirydate <> Issuedate")->row('active'),

                'movement_point_details' => $this->db->query("SELECT * FROM backend_member.points_movement WHERE AccountNo = '".$this->input->post('AccountNo')."'"),
                'cardhistory' => $this->db->query("SELECT cardno, created_at , 'First Card' as status from member where accountno = '".$_REQUEST['AccountNo']."'
                union all
                SELECT supcardno as cardno, issuestamp as created_at, 'Replaced' as status from membersupcard where accountno = '".$_REQUEST['AccountNo']."' and principalcardno = 'LOSTCARD'"),
            );

            $this->template->load('template' , 'full_details' , $data);
        }
        else
        {
            redirect('login_c');
        }  
    }*/

    public function check_duplicates()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $field = $this->input->post('field');
            $output = $this->input->post('output');
            $AccountNo = $this->input->post('AccountNo');
            $message = '0';

            if($field == 'ICNo')
            {
                $variable = 'IC no.';
                $get_icno = $this->db->query("SELECT CONCAT(LEFT('$output', 6), '-', SUBSTRING('$output', 7, 2), '-', RIGHT('$output', 4)) AS icno ")->row('icno');
                $check = $this->db->query("SELECT $field FROM member WHERE $field = '$get_icno' AND AccountNo <> '$AccountNo' ");
            }
            elseif($field == 'PassportNo')
            {
                $variable = 'Passport no.';
                $check = $this->db->query("SELECT $field FROM member WHERE $field = '$output' AND AccountNo <> '$AccountNo' ");
            }
            /*elseif($field == 'Email')
            {
                $variable = $field;
                $check = $this->db->query("SELECT $field FROM member WHERE $field = '$output' AND AccountNo <> '$AccountNo' ");
            }*/
            elseif($field == 'army_no')
            {
                $variable = 'Army card no.';
                $check = $this->db->query("SELECT ICNo FROM member WHERE ICNo = '$output' AND AccountNo <> '$AccountNo' ");
            }

            if($check->num_rows() > 0)
            {
                $message = $variable. ' is taken, please try again.';
            }
            else
            {
                $message = '0';
            }
            

            /*if($PassportNo != '')
            {
                $check_passport = $this->db->query("SELECT PassportNo FROM member WHERE PassportNo = '$PassportNo' AND AccountNo <> '$AccountNo' ");

                if($check_passport->num_rows() > 0)
                {
                    $message = 'Passport no. is taken, please try again.';
                };
            };

            if($ICNo != '')
            {
                $get_icno = $this->db->query("SELECT CONCAT(LEFT('$ICNo', 6), '-', SUBSTRING('$ICNo', 7, 2), '-', RIGHT('$ICNo', 4)) AS icno ")->row('icno');
                $check_ic = $this->db->query("SELECT ICNo FROM member WHERE ICNo = '$get_icno' AND AccountNo <> '$AccountNo' ");

                if($check_ic->num_rows() > 0)
                {
                    $message = 'IC no. is taken, please try again.';
                };
            };*/

            echo $message;
        }
        else
        {
            redirect('login_c');
        }
        
    }

    public function update()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            if($this->input->post('pass') == 'submit')
            {
                $check_email = $this->db->query("SELECT Email FROM member WHERE Email = '".$this->input->post('email')."' AND AccountNo <> '".$this->input->post('AccountNo')."' ");

                if($check_email->num_rows() > 0 && $this->input->post('email') <> '')
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Email already exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('main_c/direct_back_full_details?AccountNo=' .$this->input->post('AccountNo'). '&');
                } 

                $ic_input = $this->input->post('ICNo');

                if(strtoupper($this->input->post('Nationality_new')) == 'MALAYSIAN' || strtoupper($this->input->post('Nationality_new')) == 'MALAYSIA')
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
                }
                elseif((strtoupper($this->input->post('Nationality_new')) != 'MALAYSIAN' || strtoupper($this->input->post('Nationality_new')) != 'MALAYSIA') && $this->input->post('PassportNo') != '')
                {
                    $birthdate = $this->input->post('Birthdate');
                    $icno = '';
                }
                elseif(strtoupper($this->input->post('Nationality_new')) == 'MALAYSIAN (ARMY)' || strtoupper($this->input->post('Nationality_new')) == 'MALAYSIA (ARMY)')
                {//echo var_dump($this->input->post('army_no'));die;
                    $birthdate = $this->input->post('Birthdate');
                    $icno = $this->input->post('army_no');
                }

                $disabled_branch = $this->db->query("SELECT * FROM member_merchantcard WHERE CardNo = '".$this->input->post('CardNo')."' ")->num_rows();

                if($_SESSION['user_group'] == 'MERCHANT GROUP' || $disabled_branch > 0)
                {
                    $branch_group = 'HQ';
                }
                else
                {
                    $branch_group = addslashes($this->input->post('branch_new'));
                }

                //ori_log
                $ori = $this->db->query("SELECT * from backend_member.member where AccountNo = '".$this->input->post('AccountNo')."' ");
                $ori_AccountNo = $ori->row('AccountNo');
                $ori_CardNo = $ori->row('CardNo');
                $ori_Cardtype = $ori->row('Cardtype');
                $ori_Active = $ori->row('Active');
                $ori_staff = $ori->row('staff');
                $ori_Credit = $ori->row('Credit');
                $ori_ICNo = $ori->row('ICNo');
                $ori_Expirydate = $ori->row('Expirydate');
                $ori_Issuedate = $ori->row('Issuedate');
                $ori_IssueStamp = $ori->row('IssueStamp');
                $ori_PassportNo = $ori->row('PassportNo');
                $ori_Birthdate = $ori->row('Birthdate');
                $ori_Title = $ori->row('Title');
                $ori_Name = $ori->row('Name');
                $ori_NameOnCard = $ori->row('NameOnCard');
                $ori_Gender = $ori->row('Gender');
                $ori_Race = $ori->row('Race');
                $ori_Religion = $ori->row('Religion');
                $ori_Status = $ori->row('Status');
                $ori_Email = $ori->row('Email');
                $ori_Occupation = $ori->row('Occupation');
                $ori_Nationality = $ori->row('Nationality');
                $ori_Phonemobile = $ori->row('Phonemobile');
                $ori_Phoneoffice = $ori->row('Phoneoffice');
                $ori_Phonehome = $ori->row('Phonehome');
                $ori_Fax = $ori->row('Fax');
                $ori_Address1 = $ori->row('Address1');
                $ori_Address2 = $ori->row('Address2');
                $ori_Address3 = $ori->row('Address3');
                $ori_Postcode = $ori->row('Postcode');
                $ori_City = $ori->row('City');
                $ori_State = $ori->row('State');
                $ori_LimitAmtBalance = $ori->row('LimitAmtBalance');
                //$ori_UPDATED_AT = $ori->row('updated_at');
                //$ori_CREATED_BY = $ori->row('CREATED_BY');
                //$ori_NewForScript = $ori->row('NewForScript');
                $ori_branch = $ori->row('branch');
                $ori_branch_group = $ori->row('branch_group');
                $ori_PointsB = $ori->row('PointsBF');
                $ori_Points = $ori->row('Points');
                $ori_PointsAdj = $ori->row('PointsAdj');
                $ori_Pointsused = $ori->row('Pointsused');
                $ori_Pointsbalance = $ori->row('Pointsbalance');
                //ori_log

                $AccountNo = $this->input->post('AccountNo');
                $sql = $this->db->query("SELECT * from malaysia_postcode where postcode = '".$this->input->post('Postcode')."' ");

                /*if($this->input->post('Birthdate') == '')
                {
                    $Birthdate = '(NULL)';
                }
                else
                {
                    $Birthdate = $this->input->post('Birthdate');
                }*/

                if($this->input->post('Issuedate') == '')
                {
                    $Issuedate = '00-00-0000';
                }
                else
                {
                    $Issuedate = $this->input->post('Issuedate');
                }

                if($this->input->post('Expirydate') != $ori_Expirydate)
                {
                    $Expirydate = $this->input->post('Expirydate');
                }
                else
                {
                    $Expirydate = $ori_Expirydate;
                }

                /*if($this->input->post('City') != $sql->row('post_office'))
                { 
                    $city = $sql->row('post_office');
                    $state = $sql->row('state_code');
                }
                else
                {
                    $city = $this->input->post('City');
                    $state = $this->input->post('State');
                }*/

                $data = array(
                    'Nationality' => $this->input->post('Nationality_new'), 
                    'ICNo' => $icno, 
                    'PassportNo' => $this->input->post('PassportNo'),
                    'Title' => $this->input->post('Title'), 
                    'Name' => $this->input->post('Name'), 
                    'NameOnCard' => $this->input->post('NameOnCard'), 
                    'Birthdate' => $birthdate, 
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
                    
                    //'Active' => $this->input->post('Active'), 
                    'staff' => $this->input->post('staff'), 
                    'Cardtype' => $this->input->post('Cardtype_new'),
                    'Credit' => $this->input->post('Credit'), 
                    'LimitAmtBalance' => $this->input->post('LimitAmtBalance'), 
                    'Expirydate' => $Expirydate, 
                    // 'Issuedate' => $Issuedate,

                    'branch' => $this->input->post('branch_new'),
                    'branch_group' => $branch_group,
                    'updated_at' => $this->db->query("SELECT NOW() as datetime")->row('datetime'),
                    'NewForScript' => "1",
                    );
                $this->db->where('AccountNo', $AccountNo);
                $this->db->update('member' , $data);

                if($this->db->affected_rows() > 0)
                {
                    $date = $this->db->query("SELECT NOW() AS date")->row('date');

                    //upd_log
                    $upd = $this->db->query("SELECT * from backend_member.member where AccountNo = '".$this->input->post('AccountNo')."' ");
                    $upd_AccountNo = $upd->row('AccountNo');
                    $upd_CardNo = $upd->row('CardNo');
                    $upd_Cardtype = $upd->row('Cardtype');
                    $upd_Active = $upd->row('Active');
                    $upd_staff = $upd->row('staff');
                    $upd_Credit = $upd->row('Credit');
                    $upd_ICNo = $upd->row('ICNo');
                    $upd_Expirydate = $upd->row('Expirydate');
                    $upd_Issuedate = $upd->row('Issuedate');
                    $upd_IssueStamp = $upd->row('IssueStamp');
                    $upd_PassportNo = $upd->row('PassportNo');
                    $upd_Birthdate = $upd->row('Birthdate');
                    $upd_Title = $upd->row('Title');
                    $upd_Name = $upd->row('Name');
                    $upd_NameOnCard = $upd->row('NameOnCard');
                    $upd_Gender = $upd->row('Gender');
                    $upd_Race = $upd->row('Race');
                    $upd_Religion = $upd->row('Religion');
                    $upd_Status = $upd->row('Status');
                    $upd_Email = $upd->row('Email');
                    $upd_Occupation = $upd->row('Occupation');
                    $upd_Nationality = $upd->row('Nationality');
                    $upd_Phonemobile = $upd->row('Phonemobile');
                    $upd_Phoneoffice = $upd->row('Phoneoffice');
                    $upd_Phonehome = $upd->row('Phonehome');
                    $upd_Fax = $upd->row('Fax');
                    $upd_Address1 = $upd->row('Address1');
                    $upd_Address2 = $upd->row('Address2');
                    $upd_Address3 = $upd->row('Address3');
                    $upd_Postcode = $upd->row('Postcode');
                    $upd_City = $upd->row('City');
                    $upd_State = $upd->row('State');
                    $upd_LimitAmtBalance = $upd->row('LimitAmtBalance');
                    //$upd_UPDATED_AT = $upd->row('updated_at');
                    //$upd_CREATED_BY = $upd->row('CREATED_BY');
                    //$upd_NewForScript = $upd->row('NewForScript');
                    $upd_branch = $upd->row('branch');
                    $upd_branch_group = $upd->row('branch_group');
                    $upd_PointsB = $upd->row('PointsBF');
                    $upd_Points = $upd->row('Points');
                    $upd_PointsAdj = $upd->row('PointsAdj');
                    $upd_Pointsused = $upd->row('Pointsused');
                    $upd_Pointsbalance = $upd->row('Pointsbalance');
                    //upd_log

                    $field = array("AccountNo", "CardNo", "Cardtype", "Active", "staff", "Credit", "ICNo", "Expirydate", "Issuedate", "IssueStamp", "PassportNo", "Birthdate", "Title", "Name", "NameOnCard", "Gender", "Race", "Religion", "Status", "Email", "Occupation", "Nationality", "Phonemobile", "Phoneoffice", "Phonehome", "Fax", "Address1", "Address2", "Address3", "Postcode", "City", "State", "LimitAmtBalance", "branch", "branch_group", "PointsBF", "Points", "PointsAdj", "Pointsused", "Pointsbalance");

                    for ($x = 0; $x <= 39; $x++) 
                    {
                        switch (${'ori_'.$field[$x]}) 
                        {
                            case ${'upd_'.$field[$x]}:
                                break;
                            default:
                                $data = array(
                                    'Trans_type' => 'UPDATE RECORD',
                                    'AccountNo' => $this->input->post('AccountNo'),
                                    'field' => $field[$x],
                                    'value_from' => ${'ori_'.$field[$x]},
                                    'value_to' => ${'upd_'.$field[$x]},
                                    /*'expiry_date_before' => $upd_r,
                                    'expiry_date_after' => $upd_r,*/
                                    'created_at' => $date,
                                    'created_by' => $_SESSION['username'],
                                    );
                                $this->db->insert('user_logs', $data);
                        }
                    }

                    //check null fields
                    /*$find_null = array("Name", "ExpiryDate", "Credit", "Staff", "PointsBalance", "DiscLimitBalance", "LimitAmtBalance", "CardType");

                    foreach ($find_null as $key => $null)
                    {
                        if(is_null($upd->row($null)))
                        {
                            $this->db->query("UPDATE member
                                SET $null = ''
                                WHERE AccountNo = $AccountNo ");
                        }
                    }*/

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update Record Success<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('main_c/full_details?AccountNo='.$AccountNo);
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">No Record Update<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('main_c/full_details?AccountNo='.$AccountNo);
                }
            }
            else
            {
                $this->session->set_flashdata('message');

                $result = $this->db->query("SELECT * FROM member WHERE AccountNo = '".$this->input->post('AccountNo')."' ");
                $sql = $this->db->query("SELECT a.post_office, b.state_name from malaysia_postcode a inner join state_code b on a.state_code = b.state_code where a.postcode = '".$this->input->post('Postcode')."' ");
                $city = $sql->row('post_office');
                $state = $sql->row('state_name');

                if($sql->num_rows() < 1)
                {
                    $city = '';
                    $state = '';
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Invalid Post Code<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                };

                $data = array(
                    'AccountNo' => $result->row('AccountNo'),
                    'CardNo' => $result->row('CardNo'),
                    'Cardtype' => $result->row('Cardtype'),
                    'Active' => $this->input->post('Active'), 
                    'staff' => $this->input->post('staff'), 
                    'Credit' => $result->row('Credit'), 
                    'ICNo' => $this->input->post('ICNo'), 
                    'army_no' => $this->input->post('army_no'),  
                    'Expirydate' => $result->row('Expirydate'), 
                    'Issuedate' => $result->row('Issuedate'), 
                    'IssueStamp' => $result->row('IssueStamp'),
                    'PassportNo' => $this->input->post('PassportNo'), 
                    'Birthdate' => $this->input->post('Birthdate'),  
                    'Title' => $this->input->post('Title'),  
                    'Name' => $this->input->post('Name'), 
                    'NameOnCard' => $this->input->post('NameOnCard'), 
                    'Gender' => $this->input->post('Gender'), 
                    'Race' => $this->input->post('Race'),  
                    'Religion' => $this->input->post('Religion'),  
                    'Status' => $this->input->post('Status'), 
                    'Email' => $this->input->post('Email'), 
                    'Occupation' => $this->input->post('Occupation'), 
                    'Nationality' => $this->input->post('Nationality_new'), 
                    'Phonemobile' => $this->input->post('Phonemobile'), 
                    'Phoneoffice' => $this->input->post('Phoneoffice'), 
                    'Phonehome' => $this->input->post('Phonehome'),  
                    'Fax' => $this->input->post('Fax'), 
                    'Address1' =>$this->input->post('Address1'), 
                    'Address2' => $this->input->post('Address2'),  
                    'Address3' => $this->input->post('Address3'),  
                    'Postcode' => $this->input->post('Postcode'),
                    'City' => $city, 
                    'State' => $state, 
                    'LimitAmtBalance' => $result->row('LimitAmtBalance'), 
                    'UPDATED_AT' => $result->row('updated_at'), 
                    'CREATED_BY' => $result->row('CREATED_BY'), 
                    'NewForScript' => $result->row('NewForScript'),

                    'PointsBF' => $result->row('PointsBF'),
                    'Points' => $result->row('Points'),
                    'PointsAdj' => $result->row('PointsAdj'),
                    'Pointsused' => $result->row('Pointsused'),
                    'Pointsbalance' => $result->row('Pointsbalance'),

                    'set_nationality' => $this->db->query("SELECT * FROM backend_member.set_nationality "),
                    'set_title' => $this->db->query("SELECT * FROM backend_member.set_title "),
                    'set_race' => $this->db->query("SELECT * FROM backend_member.set_race "),
                    'set_religion' => $this->db->query("SELECT * FROM backend_member.set_religion "),
                    'set_status' => $this->db->query("SELECT * FROM backend_member.set_status"),
                    'set_occupation' => $this->db->query("SELECT * FROM backend_member.set_occupation "),
                    'set_misc' => $this->db->query("SELECT * FROM backend_member.set_misc"),
                    'set_cardtype' => $this->db->query("SELECT * FROM backend_member.cardtype "),

                    'branch' => $result->row('branch'),
                    'select_branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),

                    'decision' => 'readonly',
                    'page_title' => 'Member Details',
                    'button' => 'Update',
                    'direction' => site_url('Main_c/update'),
                    'check_active' => $this->db->query("SELECT COUNT(*) AS active FROM backend_member.member WHERE AccountNo = '".$_REQUEST['AccountNo']."' AND Active = 1 AND Expirydate <> Issuedate")->row('active'),

                    'movement_point_details' => $this->db->query("SELECT * FROM backend_member.points_movement WHERE AccountNo = '".$this->input->post('AccountNo')."'"),
                    'cardhistory' => $this->db->query("SELECT cardno, created_at , 'First Card' as status from member where accountno = '".$_REQUEST['AccountNo']."'
                    union all
                    SELECT supcardno as cardno, issuestamp as created_at, 'Replaced' as status from membersupcard where accountno = '".$_REQUEST['AccountNo']."' and principalcardno = 'LOSTCARD'"),
                    'mem_misc' => $this->db->query("SELECT seq, text1, value1, text2, value2, remark, set_active, misc_group from member_miscellaneous where accountno = '".$_REQUEST['AccountNo']."'"),
                );

                $this->template->load('template' , 'full_details' , $data);
            }

        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_supcard()
    {
        if($this->session->userdata('loginuser')== true)
        {  

                //ori_log
                $ori = $this->db->query("SELECT * from backend_member.membersupcard where AccountNo = '".$this->input->post('AccountNo')."' ");
                $ori_AccountNo = $ori->row('AccountNo');
                $ori_CardNo = $ori->row('CardNo');
                $ori_ICNo = $ori->row('ICNo');
                $ori_Relationship = $ori->row('Relationship');
               
                $ori_Birthdate = $ori->row('Birthdate');
                $ori_Title = $ori->row('Title');
                $ori_Name = $ori->row('Name');
                $ori_NameOnCard = $ori->row('NameOnCard');
                $ori_Gender = $ori->row('Gender');
                
                $ori_Email = $ori->row('Email');
                $ori_Nationality = $ori->row('Nationality');
                $ori_Phonemobile = $ori->row('Phonemobile');
                //ori log

                $AccountNo = $this->input->post('AccountNo');
                $CardNo = $this->input->post('CardNo');
               
                if($this->input->post('Birthdate') == '')
                {
                    $Birthdate = '00-00-0000';
                }
                else
                {
                    $Birthdate = $this->input->post('Birthdate');
                }

                if($this->input->post('Issuedate') == '')
                {
                    $Issuedate = '00-00-0000';
                }
                else
                {
                    $Issuedate = $this->input->post('Issuedate');
                }

                if($this->input->post('Expirydate') == '')
                {
                    $Expirydate = '00-00-0000';
                }
                else
                {
                    $Expirydate = $this->input->post('Expirydate');
                }

                $data = array(
                    'Nationality' => $this->input->post('Nationality'), 
                    'ICNo' => $this->input->post('ICNo'), 
                    'Title' => $this->input->post('Title'), 
                    'Name' => $this->input->post('Name'), 
                    'NameOnCard' => $this->input->post('NameOnCard'), 
                    'Birthdate' => $Birthdate, 
                    'Gender' => $this->input->post('Gender'),
                    'Email' => $this->input->post('Email'), 
                    'Phonemobile' => $this->input->post('Phonemobile'),
                    'Relationship' => $this->input->post('relay'),
                    'LastStamp' => $this->db->query("SELECT NOW() as datetime")->row('datetime'),
                    'UPDATED_BY' => $_SESSION['username'],
                    'NewForScript' => "1",
                    );
                $this->db->where('SupCardNo', $CardNo);
                $this->db->where('AccountNo', $AccountNo);
                $this->db->update('membersupcard' , $data);

                if($this->db->affected_rows() > 0)
                {
                    $date = $this->db->query("SELECT NOW() AS date")->row('date');

                    //upd_log
                    $upd = $this->db->query("SELECT * from backend_member.membersupcard where AccountNo = '".$this->input->post('AccountNo')."' ");
                    $upd_AccountNo = $upd->row('AccountNo');
                    $upd_CardNo = $upd->row('CardNo');
                    $upd_ICNo = $upd->row('ICNo');
                    $upd_Birthdate = $upd->row('Birthdate');
                    $upd_Title = $upd->row('Title');
                    $upd_Name = $upd->row('Name');
                    $upd_Gender = $upd->row('Gender');
                    $upd_Email = $upd->row('Email');
                    $upd_Relationship = $upd->row('Relationship');
                    $upd_Phonemobile = $upd->row('Phonemobile');
                    $upd_Nationality = $upd->row('Nationality');
                    //upd_log

                    $field = array("AccountNo", "CardNo", "ICNo", "Birthdate", "Title", "Name", "Gender","Nationality", "Phonemobile");

                    for ($x = 0; $x <= 9; $x++) 
                    {
                        switch (${'ori_'.$field[$x]}) 
                        {
                            case ${'upd_'.$field[$x]}:
                                break;
                            default:
                                $data = array(
                                    'Trans_type' => 'UPDATE RECORD',
                                    'AccountNo' => $this->input->post('AccountNo'),
                                    'field' => $field[$x],
                                    'value_from' => ${'ori_'.$field[$x]},
                                    'value_to' => ${'upd_'.$field[$x]},
                                    /*'expiry_date_before' => $upd_r,
                                    'expiry_date_after' => $upd_r,*/
                                    'created_at' => $date,
                                    'created_by' => $_SESSION['username'],
                                    );
                                $this->db->insert('user_logs', $data);
                        }
                    }

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update Record Success<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('main_c/supcard_details?AccountNo='.$AccountNo.'&Name='.$this->input->post('MainName').'&CardNo='.$this->input->post('CardNo'));
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">No Record Update<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('main_c/full_details?AccountNo='.$AccountNo);
                }

        }
        else
        {
            redirect('login_c');
        }
    }

     public function delete()
    {
        if($this->session->userdata('loginuser')== true)
        {  

            $condition = $_REQUEST['condition'];
            $column = 'misc_guid';
            $table = 'member_miscellaneous';

            $this->db->where($column, $condition);
            $this->db->delete($table);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Deleted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to delete data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            
            redirect('main_c/full_details?AccountNo='.$_REQUEST['AccountNo']);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function purchase_details()
    {
        if($this->session->userdata('loginuser')== true)
        {  
          
            $data['data'] = $this->db->query("SELECT a.refno,CONCAT(a.sysdate,' ',a.systime) AS transdate,b.`description`, ROUND(b.amount_after_tax/IF(b.soldbyweight = 1 AND b.barcodetype = 'P',ROUND(b.weightvalue,4),b.qty),2) AS price, IF(b.soldbyweight = 1 AND b.barcodetype = 'P',ROUND(b.weightvalue,4),b.qty) AS qty,ROUND(b.amount_after_tax,2) AS total
                FROM frontend.posmain a 
                INNER JOIN frontend.poschild b ON a.refno = b.refno 
                WHERE a.`AccountNo` = '".$_REQUEST['AccountNo']."' AND a.billstatus = 1 AND b.void = 0 
                ORDER BY a.bizdate DESC,a.refno,b.line");
            $data['excel'] = 'Export_excel_c/export_purchase_detail';
            $this->template->load('template' , 'purchase_details' , $data);
        }
        else
        {
            redirect('login_c');
        }
        
    }

    public function ewallet_purchase_details()
    {
        if($this->session->userdata('loginuser')== true)
        { 
            $data['data'] = $this->db->query("
                SELECT b.refno,CONCAT(b.sysdate,' ',b.systime) AS transdate,
                c.`description`, ROUND(c.amount_after_tax/IF(c.soldbyweight = 1 AND c.barcodetype = 'P',ROUND(c.weightvalue,4),c.qty),2) AS price, 
                IF(c.soldbyweight = 1 AND c.barcodetype = 'P',ROUND(c.weightvalue,4),c.qty) AS qty,ROUND(c.amount_after_tax,2) AS total FROM
                (   
                    SELECT account_no, trans_type, IF(POSITION('-' IN receipt_no) = 0, receipt_no, 
                    SUBSTRING(receipt_no, 1, (POSITION('-' IN receipt_no)-1))) AS receipt_no FROM backend_member.member_wallet_trans
                ) AS a
                INNER JOIN frontend.posmain AS b ON a.receipt_no = b.RefNo
                INNER JOIN frontend.poschild AS c ON a.receipt_no = c.RefNo
                WHERE a.account_no = '".$_REQUEST['AccountNo']."' AND a.trans_type = 'PAY' 
                AND b.BillStatus = '1' AND c.void = '0'
                ORDER BY b.BizDate, b.refno, c.line
            ");
            $data['excel'] = 'Export_excel_c/export_ewallet_purchase_detail';
            $this->template->load('template' , 'purchase_details' , $data);
        }
        else
        {
            redirect('login_c');
        }
        
    }

    public function insert_misc()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'misc_group';
            $table = 'member_miscellaneous';
           


            $sequence = $this->input->post('sequence');
            $accountno = $_REQUEST['AccountNo'];
            $misc_group = $this->input->post('misc_group');
            $text1 = $this->input->post('text1');
            $query = $this->db->query("SELECT misc_group FROM ".$table." WHERE misc_group = '".$misc_group."' AND accountno = '".$accountno."'");

            $data = array(
                'misc_guid' => $this->db->query("SELECT upper(replace(uuid(),'-','')) as guid")->row('guid'),
                'accountno' => $accountno,
                'misc_group' => $misc_group,
                'seq' => $sequence,
                'text1' => $text1,
            );

             if($query->num_rows() == 0)
            {
            $this->db->insert('member_miscellaneous', $data);
               $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">New Record  Added Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('main_c/full_details?AccountNo='.$accountno);
            }
            else
            {
                 $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to add data, Miscellaneous Group cannot be repeated.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('main_c/full_details?AccountNo='.$accountno);
                
            }
        }
        else
        {
              redirect('login_c');
        
        }
    }

public function update_misc()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $column = 'misc_guid';
            $table = 'member_miscellaneous';
           

            $misc_guid = $this->input->post('misc_guid');
            $sequence = $this->input->post('seq');
            $accountno = $_REQUEST['AccountNo'];
            $misc_group = $this->input->post('misc_group');
            $text1 = $this->input->post('text1');
            $ori = $this->db->query("SELECT misc_group FROM ".$table." WHERE accountno = '".$accountno."' AND misc_group = '".$misc_group."'");
            $orimisc_group = $ori->row('misc_group');
                $query = $this->db->query("SELECT misc_group FROM ".$table." WHERE misc_group = '".$misc_group."' AND accountno = '".$accountno."'");
           
            $data = array(
                'misc_guid' => $misc_guid,
                'accountno' => $accountno,
                'seq' => $sequence,
                'misc_group' => $misc_group,
                'text1' => $text1,
            );

            if($orimisc_group == $misc_group)
            {
                $this->db->where('misc_guid', $misc_guid);
            $this->db->update('member_miscellaneous',$data);

             $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update Record Success<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('main_c/full_details?AccountNo='.$accountno);

            }
            else
            {
                if($query->num_rows() == 0)
                 {
            
            
            $this->db->where('misc_guid', $misc_guid);
            $this->db->update('member_miscellaneous',$data);

             $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update Record Success<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('main_c/full_details?AccountNo='.$accountno);

            }
            else
            {
                 $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data, Miscellaneous Group cannot be repeated.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('main_c/full_details?AccountNo='.$accountno);
            }
        }
        }
        else
        {
              redirect('login_c');
        }
        
    }


    public function check_point()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['scan_card']))
            {
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
                        redirect('Main_c/check_point');
                }
                else
                {
                    if($get_data->num_rows() == 1)
                    {
                        redirect('Main_c/check_point?exist='.$key);
                    }
                    else
                    {
                        redirect('Main_c/check_point?multiple='.$key);
                    }
                    
                }
            }

            if(isset($_REQUEST['exist']))
            {
                $get_data = $this->db->query("SELECT * FROM backend_member.member WHERE CardNo = '".$_REQUEST['exist']."' UNION ALL
                    SELECT a.* FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE supcardno = '".$_REQUEST['exist']."'");
                $get_point_movement = $this->db->query("SELECT * FROM backend_member.points_movement WHERE AccountNo = '".$get_data->row('AccountNo')."' order by PeriodCode desc ");

                $AccountNo = $get_data->row('AccountNo');
                $CardNo = $_REQUEST['exist'];
                $Pointsused = $get_data->row('Pointsused');
                $Pointsbalance = $get_data->row('Pointsbalance');

                $Name = $get_data->row('Name');
                $MobileNo = $get_data->row('Phonemobile');
                $IcNo = $get_data->row('ICNo');
                $PassportNo = $get_data->row('PassportNo');
                $IssueDate = $get_data->row('Issuedate');
                $ExpiryDate = $get_data->row('Expirydate');
                $record = '';
            }
            else
            {
                $get_point_movement = $this->db->query("SELECT * FROM backend_member.points_movement WHERE AccountNo = '' order by PeriodCode desc ");

                $AccountNo = '';
                $CardNo = '';
                $Pointsused = '';
                $Pointsbalance = '';
                $Name = '';
                $MobileNo = '';
                $IcNo = '';
                $PassportNo = '';
                $IssueDate = '';
                $ExpiryDate = '';
                if(isset($_REQUEST['multiple']))
                {
                    $record = $this->Search_Model->search_card($_REQUEST['multiple']);    
                }
                else
                {
                    $record = '';
                }
            }

            $data = array(

                'get_point_movement' => $get_point_movement,
                'AccountNo' => $AccountNo,
                'CardNo' => $CardNo,
                'Pointsused' => $Pointsused,
                'Pointsbalance' => $Pointsbalance,

                'Name' => $Name,
                'MobileNo' => $MobileNo,
                'IcNo' => $IcNo,
                'PassportNo' => $PassportNo,
                'IssueDate' => $IssueDate,
                'ExpiryDate' => $ExpiryDate,
                'record' => $record,
                'active_expiry' => $this->check_parameter()->row('point_expiry'),
                'expiry_on' => $this->Point_Model->get_cut_off_point_expiry_date()['cut_off_date'],
            );

            if($this->check_parameter()->row('point_expiry') == 1)
            {
                $data['point_expiry'] = $this->Point_Model->get_point_expiry_by_account($this->Point_Model->get_cut_off_point_expiry_date()['end_period'],$AccountNo)->row('point_expiry');
            }

            $this->template->load('template' , 'check_point', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function wallet_search()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $json_branch_code = json_encode($_SESSION['branch_code']);
            $branch_code = $this->db->query("SELECT REPLACE(REPLACE('$json_branch_code', '[', ''), ']', '') AS branch_code")->row('branch_code');

            $data['keys'] = $this->input->post('memberno');
            $data['search'] = $this->input->post('search');

            $key = $this->input->post('memberno');
            if($this->input->post('search') == 'General')
            {
                $data['data'] = $this->db->query("SELECT a.*, b.acc_balance FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE NAME LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE cardno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE accountno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE icno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE oldicno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE passportno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Phonemobile LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Address1 LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");

                //echo $this->db->last_query();die;
            };

            if($this->input->post('search') == 'Card')
            {
                // $result = $this->db->query("SELECT IF((SELECT COUNT(*) FROM backend_member.membersupcard WHERE SupCardNo like '%$key%')>0 , 'true', 'false') AS result ")->row('result');

                // if($result == 'true')
                // {
                //     $data['data'] = $this->db->query("SELECT * FROM backend_member.membersupcard WHERE SupCardNo LIKE '%$key%' ");
                // }
                // else
                // {
                //     $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE CardNo LIKE '%$key%' ");
                // }

                $data['data'] = $this->db->query("SELECT a.*, b.acc_balance FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE cardno LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
            };

            if($this->input->post('search') == 'Account')
            {
                $data['data'] = $this->db->query("SELECT a.*, b.acc_balance FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE accountno LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
            };

            if($this->input->post('search') == 'Name')
            {
                $data['data'] = $this->db->query("SELECT a.*, b.acc_balance FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Name LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
            };

            if($this->input->post('search') == 'Passport')
            {
                $data['data'] = $this->db->query("SELECT a.*, b.acc_balance FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE PassportNo LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
            };

            if($this->input->post('search') == 'Ic')
            {
                $data['data'] = $this->db->query("SELECT a.*, b.acc_balance FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE ICNo LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
            };

            if($this->input->post('search') == 'Phone')
            {
                $data['data'] = $this->db->query("SELECT a.*, b.acc_balance FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Phonemobile LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
            };

            if($this->input->post('search') == 'Address')
            {
                $data['data'] = $this->db->query("SELECT a.*, b.acc_balance FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Address1 LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
            };
            
            $data['form_search'] = site_url('Main_c/wallet_search');
            $data['assign'] = site_url('Main_c/ewallet_assign_view');

            $this->template->load('template' , 'ewallet_home' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function wallet_search_key()
    {
        $key = $_REQUEST['key'];

        if($_REQUEST['searchs'] == 'General')
        {
            $query = $this->db->query("SELECT a.*, b.acc_balance FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE NAME LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE cardno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE accountno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE icno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE oldicno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE passportno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Phonemobile LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Address1 LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");

            //echo $this->db->last_query();die;
        };

        if($_REQUEST['searchs'] == 'Card')
        {
            // $result = $this->db->query("SELECT IF((SELECT COUNT(*) FROM backend_member.membersupcard WHERE SupCardNo like '%$key%')>0 , 'true', 'false') AS result ")->row('result');

            // if($result == 'true')
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM backend_member.membersupcard WHERE SupCardNo LIKE '%$key%' ");
            // }
            // else
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM backend_member.member WHERE CardNo LIKE '%$key%' ");
            // }

            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name` FROM backend_member.member WHERE CardNo like '%$key%' UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Account')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE AccountNo LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.AccountNo LIKE '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Name')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Name like '%$key%' UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Name LIKE '%$key%'");
        };

        if($_REQUEST['searchs'] == 'Passport')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE PassportNo like '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Ic')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE ICNo like '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.ICNo LIKE '%$key%'");
        };

        if($_REQUEST['searchs'] == 'Phone')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Phonemobile LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Phonemobile LIKE '%$key%' ");
        };

        if($_REQUEST['searchs'] == 'Address')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM backend_member.member WHERE Address1 LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM backend_member.member a INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE a.Address1 LIKE '%$key%';");
        };

        $columns = array(
            0 => 'Card No',
            1 => 'Account No',
            2 => 'Expired Date',
            3 => 'IC No',
            4 => 'Phone No',
            5 => 'Name',
            6 => 'Credit',
            7 => 'Full Detail',
            8 => 'Purchase Details'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $query->num_rows();
        $totalFiltered = $totalData;
       
        $posts = $this->Trans_Model->wallet_search_key($limit,$start,$dir,$_REQUEST['searchs'],$key);

        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $disabled = "";
                $nestedData['Card No'] = $post->CardNo;
                $nestedData['Account No'] = $post->AccountNo;
                $nestedData['Expired Date'] = $post->Expirydate;
                $nestedData['IC No'] = $post->ICNo;
                $nestedData['Phone No'] = $post->Phonemobile;
                $nestedData['Name'] = $post->Name;
                $nestedData['Credit'] = $post->Credit;
                $nestedData['Full Detail'] = '<a href="'.site_url('main_c/full_details').'?AccountNo='.$post->AccountNo.'"><button title="View" type="button" class="btn btn-xs btn-primary">E Wallet <i class="fa fa-eye"></i></button></a>';

                $nestedData['Purchase Details'] = '<a href = "'.site_url('main_c/purchase_details').'?AccountNo='.$post->AccountNo.'&Name='.$post->Name.'"><button title="View" type="button" class="btn btn-xs btn-success" '.$disabled.' >Purchase Details <i class="fa fa-eye"></i></button></a>';
                $data[] = $nestedData;

            }
        }
        else
        {
            $data = '';
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data);
    }

    public function ewallet()
    {
     // echo 'asdasd';
        $query =  $this->db->query("SELECT a.CardNo, a.AccountNo, a.Expirydate, a.ICNo, a.Phonemobile, a.`Name` , acc_balance from backend_member.member as a inner join backend_member.member_wallet as b on a.accountno = b.accountno ");
        
        $columns = array(
            0 => 'Card No',
            1 => 'Account No',
            2 => 'Expired Date',
            3 => 'IC No',
            4 => 'Phone No',
            5 => 'Name',
            6 => 'Credit',
            7 => 'Full Detail',
            8 => 'Purchase Details'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $query->num_rows();
        $totalFiltered = $totalData;
       
        $posts = $this->Trans_Model->allposts_member($limit,$start,$dir);

        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $disabled = "";
                $nestedData['Card No'] = $post->CardNo;
                $nestedData['Account No'] = $post->AccountNo;
                $nestedData['Expired Date'] = $post->Expirydate;
                $nestedData['IC No'] = $post->ICNo;
                $nestedData['Phone No'] = $post->Phonemobile;
                $nestedData['Name'] = $post->Name;
                $nestedData['Credit'] = $post->Credit;
                $nestedData['Full Detail'] = '<a href="'.site_url('main_c/full_details').'?AccountNo='.$post->AccountNo.'"><button title="View" type="button" class="btn btn-xs btn-primary">E Wallet <i class="fa fa-eye"></i></button></a>';

                $nestedData['Purchase Details'] = '<a href = "'.site_url('main_c/ewallet_purchase_details').'?AccountNo='.$post->AccountNo.'&Name='.$post->Name.'"><button title="View" type="button" class="btn btn-xs btn-success" '.$disabled.' >Purchase Details <i class="fa fa-eye"></i></button></a>';
                $data[] = $nestedData;

            }
        }
        else
        {
            $data = '';
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }

    public function ewallet_old()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $check_member = $this->db->query("SELECT a.CardNo, a.AccountNo, a.Expirydate, a.ICNo, a.Phonemobile, a.`Name` from backend_member.member as a inner join backend_member.member_wallet as b on a.accountno = b.accountno ");

            $data = array (
                'data' => $check_member,
                'form_search' => site_url('Main_c/wallet_search'),
                'assign' => site_url('Main_c/ewallet_assign_view'),
            );

            $this->template->load('template' , 'ewallet_home', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function ewallet_assign_view()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $check_member = $this->db->query("SELECT a.CardNo, a.AccountNo, a.Expirydate, a.ICNo, a.Phonemobile, a.`Name` from backend_member.member as a inner join backend_member.member_wallet as b on a.accountno = b.accountno ");

            $data = array (
                'data' => $check_member,
                'title' => 'Member to Wallet Assignment',
                'form_submit' => site_url('Main_c/ewallet_submit'),
                'show_other_field' => 'false',
                'show_input_field' => 'true',
            );

            $this->template->load('template' , 'ewallet_scancard', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function ewallet_submit()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $cardno = $this->input->post("confirm_cardno");
            $verify_card = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name` from backend_member.member  where cardno = '$cardno' and active = '1' and Name <> 'NEW'");
            if($verify_card->num_rows() > 0 )
            {
                $check_already_e_wallet = $this->db->query("SELECT CardNo, AccountNo, Active from backend_member.member_wallet where cardno = '$cardno' and active = '1'");

                if($check_already_e_wallet->num_rows() == 0)
                {
                     $data = array (
                        'data' => $verify_card,
                        'title' => 'Member to Wallet Assignment',
                        'form_submit' => site_url('Main_c/ewallet_assign_process'),
                        'show_other_field' => 'true',
                        'show_input_field' => 'false',
                        'guid' => $this->db->query("SELECT upper(replace(uuid(),'-','')) as guid")->row('guid'),
                        'wallet' => $this->db->query("SELECT * from set_wallet"),
                        );
                        $this->template->load('template' , 'ewallet_scancard', $data);
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Card No is already E Wallet Enabled.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('main_c/ewallet_assign_view');
                }
            }
            else
            {
                 $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Card No Does Not Exist/ Not Activated Yet<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('main_c/ewallet_assign_view');
            }
        }
        else
        {
            redirect('login_c');
        }
    }

    public function ewallet_assign_process()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $check_cardno = $_REQUEST['cardno'];
            $check_guid = $_REQUEST['guid'];
            $check_wallet_guid = $_REQUEST['wallet_name'];

            if($check_cardno == '')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">ERROR!! Invalid Input Method! <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Main_c/ewallet_assign_view');
            };

            $check_wallet = $this->db->query("SELECT wallet_name from set_wallet where wallet_guid ='$check_wallet_guid'")->row('wallet_name');

            $check_details = $this->db->query("SELECT * from backend_member.member where cardno = '$check_cardno'");
            $accountno = $check_details->row('AccountNo');

            $this->db->query("INSERT INTO backend_member.member_wallet SELECT '$check_guid' as wallet_guid
                , 'PandaWallet' as wallet_type
                , '$check_wallet' as wallet_name
                , '$accountno' as accountno 
                , '$check_cardno' as cardno
                , '0.00' as acc_balance
                , LPAD(FLOOR(RAND() * 999999.99), 6, '0') as tac
                , '1' as active
                , now() as created_at
                ,'".$_SESSION['username']."' as created_by
                , now() as updated_at
                ,'".$_SESSION['username']."' as updated_by
                ");
            
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Main_c/ewallet_assign_view');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Something Went Wrong<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Main_c/ewallet_assign_view');
            }
        }
        else
        {
            redirect('login_c');
        }
    }
    

    public function ewallet_topup()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $check_member = $this->db->query("SELECT a.CardNo, a.AccountNo, a.Expirydate, a.ICNo, a.Phonemobile, a.`Name` from backend_member.member as a inner join backend_member.member_wallet as b on a.accountno = b.accountno ");


            $data = array (
                'data' => $check_member,
                'title' => 'Wallet Top Up',
                'form_submit' => site_url('Main_c/ewallet_topup_submit'),
                'show_other_field' => 'false',
                'show_input_field' => 'true',
            );

            $this->template->load('template' , 'ewallet_scancard', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function ewallet_topup_submit()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $cardno = $this->input->post("confirm_cardno");
            $check_already_e_wallet = $this->db->query("SELECT CardNo, AccountNo, Active from backend_member.member_wallet where cardno = '$cardno' and active = '1'");
            $check_member = $this->db->query("SELECT a.CardNo, a.AccountNo, a.Expirydate, a.ICNo, a.Phonemobile, a.`Name` , wallet_name, acc_balance, b.active from backend_member.member as a inner join backend_member.member_wallet as b on a.accountno = b.accountno where a.accountno = '".$check_already_e_wallet->row('AccountNo')."'");

            if($check_already_e_wallet->num_rows() > 0)
            {
                $data = array (
                        'data' => $check_member,
                        'title' => 'Wallet Top Up',
                        'form_submit' => site_url('Main_c/ewallet_topup_process'),
                        'show_other_field' => 'true',
                        'show_input_field' => 'false',
                        'guid' => $this->db->query("SELECT upper(replace(uuid(),'-','')) as guid")->row('guid'),
                        );
                        $this->template->load('template' , 'ewallet_topup', $data);
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Card Is Inactive for Wallet<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Main_c/ewallet_topup');
            }

        }
        else
        {
             redirect('login_c');
        }

    }

    public function ewallet_topup_process()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $cardno = $_REQUEST['cardno'];
            $accountno = $_REQUEST['accountno'];
            $topup_amt = $_REQUEST['topup_amt'];
            $guid = $_REQUEST['guid'];

            /*echo '';die;*/
            $double_refresh_checking = $this->db->query("SELECT * from backend_member.member_wallet_trans where trans_guid = '$guid'");
            if($double_refresh_checking->num_rows() != 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Record Already Inserted. Please do not refresh after submit.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Main_c/ewallet_topup');
            };

            if($accountno == '')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Card Is Inactive for Wallet<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Main_c/ewallet_topup');
            }
            else
            {   
                $check_member = $this->db->query("SELECT * from backend_member.member where AccountNo = '$accountno'");

                $check_wallet = $this->db->query("SELECT * from backend_member.member_wallet where AccountNo = '$accountno'");

                $refno = $this->db->query("SELECT CONCAT('TRX',SUBSTRING(REPLACE(CURDATE(),'-',''),-6,4),a.run_no) AS ref_no FROM (
SELECT IFNULL(MAX(LPAD(RIGHT(ref_no,'6')+1,'6',0)),LPAD(1,'6',0)) AS run_no 
FROM backend_member.`member_wallet_trans` a 
WHERE SUBSTRING(ref_no,-10,4) =  SUBSTRING(REPLACE(CURDATE(),'-',''),-6,4)
)a")->row('ref_no');


                $data = array(
                        'trans_guid' => $guid,
                        'trans_type' => 'TOPUP',
                        'account_no' => $accountno,
                        'card_no' => $cardno,
                        'name' => $check_member->row('Name'),
                        'ref_no' => $refno,
                        'amount' => round($topup_amt,2),
                        'trans_date' => $this->db->query("SELECT curdate() as edate")->row('edate'),
                        'created_at' =>$this->db->query("SELECT now() as edate")->row('edate'),
                        'created_by' => $_SESSION['username'],
                        'pos_id' => 'WEB_MODULE',
                        'cashier_id' => $_SESSION['username'],
                    );
                $this->db->insert('member_wallet_trans', $data);
                $amount_before = $check_wallet->row('acc_balance');

                $new_amount = $check_wallet->row('acc_balance') + round($topup_amt,2);

                $data_logs = array(
                        'Trans_type' => 'TOPUP',
                        'AccountNo' => $accountno,
                        'ReceiptNo' => $refno,
                        'Field' => 'PointsBefore',
                        'Value_from' => $amount_before,
                        'Value_to' => $new_amount,
                        'expiry_date_before' => $check_member->row('Expirydate'),
                        'expiry_date_after' => $check_member->row('Expirydate'),
                        'created_at' =>$this->db->query("SELECT now() as edate")->row('edate'),
                        'created_by' => $_SESSION['username'],
                    );
                $this->db->insert('user_logs', $data_logs);


                
                $this->db->query("UPDATE backend_member.member_wallet set acc_balance = '$new_amount' where accountno = '$accountno' and cardno = '$cardno' and active = '1'");

                //print receipt
                if($this->db->affected_rows() > 0)
                {
                    $guid = $_REQUEST['guid'];
                    $main = $this->db->query("SELECT * from backend_member.member_wallet_trans where trans_guid = '".$_REQUEST['guid']."' ");
                    $child = $this->db->query("SELECT * from backend_member.member_wallet_trans where trans_guid = '".$_REQUEST['guid']."' ");

                    $date = $main->row('trans_date');
                    $datetime = $main->row('updated_at');
                    $UPDATED_AT = date("d/m/Y h:i a", strtotime($datetime));
                    $TRANS_DATE = date("d/m/Y", strtotime($date));

                    $sub_title = 'Wallet Top Up';
                    $form = 'Top Up Receipt';
                    $text = '';
                    $Point_after = '';
                      

            $data3 = array(
                'title' => $this->db->query("SELECT CompanyName from backend.companyprofile")->row('CompanyName'),
                'sub_title' => $sub_title,
                'form' => $form,
                'Points' => $this->db->query("SELECT Points from member where AccountNo = '".$this->input->post('Code')."' ")->row('Points'),
                'REF_NO' => $main->row('ref_no'),
                'username' => $_SESSION['username'],
                'TRANS_DATE' => $TRANS_DATE,
                'UPDATED_AT' => $UPDATED_AT,
                'SUP_NAME' => $main->row('name'),
                'SUP_CODE' => $main->row('card_no'),
                'Cardno' => $main->row('card_no'),
                'child' => $child,
                'text' => $text,
                'Point_before' => $this->db->query("SELECT value_from from backend_member.user_logs where receiptno = '$refno' and trans_type = 'TOPUP'")->row('value_from'),
                'Point_after' => $new_amount,
                'REMARK' => $main->row('remark'),
                'sum_qty' => $child->num_rows(),
                'sum_total' =>  $child->row('amount'),
                'cross_refno' => '',

                );

            $report_potrait = $this->db->query("SELECT report_potrait from set_parameter ")->row('report_potrait');

            if($report_potrait == 1)
            {
                $this->load->view('print_ewallet_topup', $data3);
            }
            else
            {
                $this->load->view('print_ewallet_topup', $data3);
            }
                   /* $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Top Up Successful<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Main_c/ewallet_topup');*/
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Top Up Fail<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Main_c/ewallet_topup');
                }

            };

        }
        else
        {
            redirect('login_c');
        }
    }


    public function reload_from_dropbox()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $file_path = $this->db->query("SELECT file_path from backend_member.set_parameter limit 1")->row('file_path');

            $destination_path = $this->db->query("SELECT destination_path from backend_member.set_parameter limit 1")->row('destination_path');
            $permission = '0777';

            if($file_path != '')
            {
            // to update file
            /*$controllers = $file_path."controllers";
            $models = $file_path."models";*/
            $source = $file_path."application";

            function recurse_copy($source,$destination_path) {
                $dir = opendir($source); 
                @mkdir($destination_path); 
                while(false !== ( $file = readdir($dir)) ) { 
                    if (( $file != '.' ) && ( $file != '..' )) { 
                        if ( is_dir($source . '/' . $file) ) { 
                            recurse_copy($source . '/' . $file,$destination_path . '/' . $file); 
                        } 
                        else { 
                            copy($source . '/' . $file,$destination_path . '/' . $file); 
                        } 
                    } 
                } 
                closedir($dir); 
            }

            recurse_copy($source, $destination_path);

            // to update database
            $file_name = $file_path.'panda_member2_deployment.sql';
            $file_time = date("Y-m-d H:i:s", filemtime($file_name));
            $file_gmt = date("Y-m-d H:i:s",  strtotime($file_time));


            if($fp = file_get_contents($file_name)) 
                {
                    $var_array = explode(';',$fp);

                  //echo var_dump($var_array);
                    
                    foreach($var_array as $value) 
                    {   
                        if($value != '')
                        {
                            $this->db->query($value."; ");
                        }
                        else
                        {   
                            $this->db->query("UPDATE backend_member.set_parameter set script_datetime = '$file_gmt'");
                            $this->db->query("UPDATE backend_member.set_parameter set updated_at = now()");
                            redirect("main_c/dashbord");
                        }
                        //die;
                    }
                 //   echo $this->db->last_query();die;
                }
            }
            else
            {
                // empty file path
                redirect('main_c/dashbord');
            }
        }
        else
        {
            redirect('login_c');
        }    
    }
    

    

}
?>
