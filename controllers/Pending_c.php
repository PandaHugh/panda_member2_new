<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pending_c extends CI_Controller {
    
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
        $this->load->model('Search_Model');
        $this->load->model('Trans_Model');
        $this->load->model('Member_Model');
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

    public function index()
    {
        if($this->session->userdata('loginuser') == true)
        {
            if(isset($_REQUEST['reference']))
            {
                $reference = $_REQUEST['reference'];
            }
            else
            {
                $reference = '';
            }

            $data = array(
                'posmain_log' => $this->db->query("SELECT * from user_logs where Trans_type = 'RETAG TRANSACTION' "),
                'update' => '',
                'Reference_No' => $reference,
                'Card_No' => '',
                'Card_Name' => '',
                'Account_No' => '',
                'search_card' => '',

            );

            $this->template->load('template' , 'pending', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function search_reference()
    {
        if($this->session->userdata('loginuser') == true)
        {
            // $result = $this->db->query("SELECT * from frontend.posmain where RefNo = '".$this->input->post('Reference_No')."' ");

            $data = array(
                'refno' => $this->input->post('Reference_No'),
            );

            $result = $this->Member_Model->query_call('Pending_c', 'search_reference', $data);

            if($result['message'] != 'success')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Pending_c');
            }
            else
            {
                // if($result->row('CardNo') == '' AND $result->row('CardName') == '' AND $result->row('CardType') == 'NA' AND $result->row('AccountNo') == '')
                // {
                //     $data = array(
                //         'posmain_log' => $this->db->query("SELECT * from user_logs where Trans_type = 'RETAG TRANSACTION' "),
                //         'update' => '',
                //         'Reference_No' => $this->input->post('Reference_No'),
                //         'Card_No' => '',
                //         'Card_Name' => '',
                //         'Account_No' => '',
                //         'search_card' => 'show',

                //     );

                //     $this->template->load('template' , 'pending', $data);
                // }
                // else
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Reference number does not meet requirements<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                //     redirect('Pending_c');
                // }

                    $data = array(
                        'posmain_log' => $this->db->query("SELECT * from user_logs where Trans_type = 'RETAG TRANSACTION' "),
                        'update' => '',
                        'Reference_No' => $this->input->post('Reference_No'),
                        'Card_No' => '',
                        'Card_Name' => '',
                        'Account_No' => '',
                        'search_card' => 'show',

                    );

                    $this->template->load('template' , 'pending', $data);
            }
        }
        else
        {
            redirect('login_c');
        }
    }

    public function search_card()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $result = $this->db->query("SELECT * from member where CardNo = '".$this->input->post('Card_No')."' ");

            if($result->num_rows() == 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Invalid card number, please try again!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Pending_c');
            }
            else
            {
                $data = array(
                    'posmain_log' => $this->db->query("SELECT * from user_logs where Trans_type = 'RETAG TRANSACTION' "),
                    'update' => 'update',
                    'Reference_No' => $_REQUEST['reference'],
                    'Card_No' => $this->input->post('Card_No'),
                    'Card_Name' => $result->row('NameOnCard'),
                    'Account_No' => $result->row('AccountNo'),
                    /*'search_ref' => '',*/
                    'search_card' => 'show',

                );

                $this->template->load('template' , 'pending', $data);
            }
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update()
    {
        if($this->session->userdata('loginuser') == true)
        {
            // $ori = $this->db->query("SELECT * from frontend.posmain where RefNo = '".$this->input->post('Reference_No')."' ");
            // $ori_cardno = $ori->row('CardNo');
            // $ori_cardname = $ori->row('CardName');
            // $ori_cardtype = $ori->row('CardType');
            // $ori_accountno = $ori->row('AccountNo');

            $data = array(
                'cardno' => $this->input->post('Card_No'),
                'cardname' => $this->input->post('NameOnCard'),
                'cardtype' => $this->input->post('Cardtype'),
                'accountno' => $this->input->post('AccountNo'),
                'refno' => $this->input->post('Reference_No'),
                'username' => $_SESSION['username'],
            );

            $result = $this->Member_Model->query_call('Pending_c', 'update', $data);

            if($result['message'] == 'success')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');   
            }

            // $result = $this->db->query("SELECT * from member where CardNo = '".$this->input->post('Card_No')."' ");
            // /*$this->db->query(" SET @cardno = '".$result->row('CardNo')."' ");
            // $this->db->query(" SET @cardname = '".$result->row('NameOnCard')."' ");
            // $this->db->query(" SET @cardtype = '".$result->row('Cardtype')."' ");
            // $this->db->query(" SET @accountno = '".$result->row('AccountNo')."' ");
            // $this->db->query(" SET @refno = '".$this->input->post('Reference_No')."' ");
            // $SqlScript = $this->db->query("SELECT SqlScript from sqlserver.sqlscript where refno = 'E6731F31BE1311E7BEF540F02F073A1A' ")->row('SqlScript');
            // $this->db->query("$SqlScript");*/
            // $info = array(
            //     'refno' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid")->row('uuid'),
            //     'SqlScript' => "UPDATE frontend.posmain SET CardNo = '".$result->row('CardNo')."', CardName = '".$result->row('NameOnCard')."', CardType = '".$result->row('Cardtype')."', AccountNo = '".$result->row('AccountNo')."' WHERE RefNo = '".$this->input->post('Reference_No')."'",
            //     'CreatedDateTime' => $this->db->query("SELECT NOW() as date")->row('date'),
            //     'CreatedBy' => 'web_member',
            //     'Status' => '0', //$ori_cardno[0]
            //     'KeyField' => 'Posmain',
            // );
            // $this->db->insert('sqlserver.sqlscript', $info);

            // $infomation = array(
            //     'CardNo' => $result->row('CardNo'),
            //     'CardName' => $result->row('NameOnCard'),
            //     'CardType' => $result->row('Cardtype'), //$ori_cardno[0]
            //     'AccountNo' => $result->row('AccountNo'),
            // );
            // $this->db->where('RefNo', $this->input->post('Reference_No'));
            // $this->db->update('frontend.posmain', $infomation);

            // if($this->db->affected_rows() > 0)
            // {
            //     $upd = $this->db->query("SELECT * from frontend.posmain where RefNo = '".$this->input->post('Reference_No')."' ");
            //     $upd_cardno = $upd->row('CardNo');
            //     $upd_cardname = $upd->row('CardName');
            //     $upd_cardtype = $upd->row('CardType');
            //     $upd_accountno = $upd->row('AccountNo');
            //     $field = array("Card No", "Card Name", "Card Type", "Account No");
            //     $variable = array("cardno", "cardname", "cardtype", "accountno");
            //     $date = $this->db->query("SELECT NOW() as date")->row('date');

            //     for ($x = 0; $x <= 3; $x++) 
            //     {
            //         $data = array(
            //             /*'log_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid")->row('uuid'),
            //             'refno' => $this->input->post('Reference_No'),
            //             'field' => $field[$x],
            //             'process' => 'Update posmain',
            //             'value_from' => ${"ori_".$variable[$x]}, //$ori_cardno[0]
            //             'value_to' => ${'upd_'.$variable[$x]},
            //             'created_at' => $this->db->query("SELECT NOW() as date")->row('date'),
            //             'created_by' => $_SESSION['username'],*/
            //             'Trans_type' => 'RETAG TRANSACTION',
            //             'AccountNo' => $result->row('AccountNo'),
            //             'ReferenceNo' => $this->input->post('Reference_No'),
            //             'field' => $field[$x],
            //             'value_from' => ${"ori_".$variable[$x]},
            //             'value_to' => ${'upd_'.$variable[$x]},
            //             //'expiry_date_before' => addslashes($this->input->post('expiry_date')),
            //             //'expiry_date_after' => addslashes($get_new_expiry_date),
            //             'created_at' => $date,
            //             'created_by' => $_SESSION['username'],
            //         );
            //         $this->db->insert('user_logs', $data);
            //     }

            //      $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            // }
            // else
            // {
            //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update record<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            // }
            redirect('Pending_c');
        }
        else
        {
            redirect('login_c');
        }
    }


    public function search_to_deactivate()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['scan_card']))
            {
                // $get_data = $this->db->query("SELECT * FROM backend_member.`member` WHERE CardNo = '".$this->input->post('card_no')."' ");

                if(isset($_REQUEST['select']))
                {
                    $key = $_REQUEST['select'];
                }
                else
                {
                    $key = $this->input->post('card_no');
                }

                $get_data = $this->Search_Model->search_card($key);

                //echo $this->db->last_query();die;
                if($get_data->num_rows() == 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">Card Not Found!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Pending_c/search_to_deactivate');
                }
                else
                {
                    // $check_active_card = $this->db->query("SELECT AccountNo, CardNo, NameOnCard, `Name`, CardType, ICNo, Active  FROM member WHERE Issuedate < Expirydate AND Active = 1 AND ICNo = '".$this->input->post('ICNo')."' 
                    // UNION ALL
                    // SELECT b.AccountNo, b.SupCardNo, b.NameOnCard, b.`Name`, b.PrincipalCardNo AS CardType, b.ICNo, b.Active FROM backend_member.member a 
                    // INNER JOIN backend_member.membersupcard b ON a.accountno = b.accountno WHERE b.Active = 1 AND b.ICNo = '".$this->input->post('ICNo')."' ");
                    if($get_data->num_rows() == 1)
                    {
                        $check_active_card = $this->db->query("SELECT * FROM member WHERE CardNo = '".$get_data->row('CardNo')."' 
                            UNION ALL
                            SELECT a.* FROM member a 
                            INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE supcardno = '".$get_data->row('CardNo')."' ");
                        $check_suspend = $this->db->query("SELECT * FROM `member_suspended` a WHERE a.`card_no` = '".$get_data->row('CardNo')."' ");
                        
                        //echo $this->db->last_query();die;
                        if($check_active_card->row('Active') == 0 && $check_suspend->num_rows() == 0)
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This Card does not active. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Pending_c/search_to_deactivate');
                        };

                        if($check_active_card->row('acc_status') == 'TERMINATE')
                        {
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This card already terminate. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                            redirect('Pending_c/search_to_deactivate');
                        }
                        redirect('Pending_c/search_to_deactivate?exist_card='.$get_data->row('CardNo').'&account='.$get_data->row('AccountNo').'&ic_no='.$get_data->row('ICNo').'&active='.$get_data->row('Active').'&mobile_no='.$get_data->row('Phonemobile').'&Name='.$get_data->row('Name').'&Passport_No='.$get_data->row('PassportNo'));
                    }
                    else
                    {
                        redirect('Pending_c/search_to_deactivate?multiple='.$key);
                    }
                   
                }
                $style = 'display: block;';
                $result = 'hidden';
                $record = $get_data;

            }
            elseif(isset($_REQUEST['exist_card']))
            {
                $_SESSION['Name'] = $_REQUEST['Name'];
                $_SESSION['Passport_No'] = $_REQUEST['Passport_No'];
                $_SESSION['mobile_no'] = $_REQUEST['mobile_no'];
                $_SESSION['active'] = $_REQUEST['active'];
                $_SESSION['card_no'] = $_REQUEST['exist_card'];
                $_SESSION['account_no'] = $_REQUEST['account'];
                $_SESSION['ic_no'] = $_REQUEST['ic_no'];
                $_SESSION['hidden_result'] = '';
                $style = 'display: block;';
                $record = '';
            }
            else
            {   
                $_SESSION['Name'] = '';
                $_SESSION['Passport_No'] = '';   
                $_SESSION['mobile_no'] = '';
                $_SESSION['active'] = '';
                $_SESSION['card_no'] = '';
                $_SESSION['account_no'] = '';
                $_SESSION['ic_no'] = '';
                $_SESSION['hidden_result'] = 'hidden';
                $style = 'display: none;';
                if(isset($_REQUEST['multiple']))
                {
                    $record = $this->Search_Model->search_card($_REQUEST['multiple']);    
                }
                else
                {
                    $record = '';
                }
            }

            $get_account_data = $this->db->query("SELECT * FROM member WHERE AccountNo = '".$_SESSION['account_no']."' ");
           // $get_preset_expiry_date = $this->db->query("SELECT CURDATE()+INTERVAL (SELECT expiry_date_in_year FROM set_parameter) YEAR AS Expirydate")->row('Expirydate');

            $data = array(
                'username' => $_SESSION['username'],
                'userpass' => $_SESSION['userpass'],
                'module_group_guid' => $_SESSION['module_group_guid'],
            );

            $branch = array();
            $branch_list = $this->Member_Model->query_call('Pending_c', 'search_to_deactivate', $data);

            if(isset($branch_list['branch']))
            {
                $branch = $branch_list['branch'];
            }

            $data = array(

                /*'need_receipt_no' => $this->db->query("SELECT receipt_no_lostcard FROM backend_member.`set_parameter`;")->row('receipt_no_lostcard'),*/
                /*'branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),*/
                // 'branch' => $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name, c.receipt_lost FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY b.branch_code ASC"),
                'branch' => $branch,
                'field' => 'receipt_lost',
                'reason' => $this->db->query("SELECT * FROM set_reason where type = 'LOST' "),
                'style' => $style,
                'record' => $record,
                'active' => $_SESSION['active'],

            );

            $this->template->load('template' , 'search_to_deactivate', $data);
           // $this->template->load('template' , 'search_to_deactivate');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_status()
    {
        if($this->session->userdata('loginuser')== true)
        {

            $accountno = $this->input->post('accountno');
            $active = $this->input->post('active');

            $get_data = $this->Search_Model->search_card($accountno);

            if($active == 'ACTIVE')
            {
                $flag = '1';
                $expirydate = $this->db->query("SELECT * FROM member_suspended a WHERE a.`accountno` = '$accountno' ")->row('expiry_date');
            };

            if($active == 'SUSPEND' || $active == 'TERMINATE')
            {
                $flag = '0';
                $expirydate = '1970-12-31';
            };

            $data = array(
                'active' => $flag,
                'expirydate' => $expirydate,
                'acc_status' => $active
            );

            $this->db->WHERE("accountno",$accountno);
            $this->db->UPDATE("member",$data);
            
            /*$this->db->query("UPDATE backend_member.member set active = '$active' where accountno = '$accountno'");*/


            if($active == 'TERMINATE')
            {
                // if current point is negative
                if($get_data->row('Pointbalance') < 0)
                {
                    $pointbalance = $get_data->row('Pointbalance') + $get_data->row('Pointbalance');
                }
                else
                {
                    $pointbalance = $get_data->row('Pointbalance') - $get_data->row('Pointbalance');
                }

                $accountno = $accountno;
                $name = $get_data->row('Name');
                $cardno = $get_data->row('CardNo');
                $pointbalance = $pointbalance;
                $point_adjust = $get_data->row('Pointsbalance');
                $branch = $this->input->post('branch');

                $this->Trans_Model->terminate_card($accountno,$name,$pointbalance,$point_adjust,$branch,$cardno);
            };

            if($active == 'SUSPEND')
            {
                $data = array(
                    'guid' => $this->guid(),
                    'accountno' => $accountno,
                    'card_no' =>  $_SESSION['card_no'],
                    'created_by' => $_SESSION['username'],
                    'created_at' => $this->datetime(),
                    'updated_by' => $_SESSION['username'],
                    'updated_at' => $this->datetime(),
                    'expiry_date' => $get_data->row('Expirydate'),
                    'active' => $flag,
                    'branch' => $this->input->post('branch')
                );
                $this->db->insert("member_suspended",$data);
            };

            if($active == 'ACTIVE')
            {
                $data = array(
                    'updated_by' => $_SESSION['username'],
                    'updated_at' => $this->datetime(),
                    'active' => '1',
                    'branch' => $this->input->post('branch'),
                );
                $this->db->WHERE("accountno",$accountno);
                $this->db->UPDATE("member_suspended",$data);
            };

            $data = array(
                        'Trans_type' => 'UPDATE '.$active,
                        'AccountNo' => $accountno,
                        'ReceiptNo' => '',
                        'expiry_date_before' => $get_data->row('Expirydate'),
                        'expiry_date_after' => $expirydate,
                        'created_at' => $this->datetime(),
                        'created_by' => $_SESSION['username'],
                        );
                    $this->db->insert('user_logs', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful '.$active.'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('Pending_c/search_to_deactivate');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function reactivate()
    {
        if($this->session->userdata('loginuser')== true)
        {

            $accountno = $this->input->post('accountno');
            $active = $this->input->post('active');

            $get_data = $this->Search_Model->search_card($accountno);

            if($active == 'ACTIVE')
            {
                $flag = '1';
                $expirydate = $this->db->query("SELECT * FROM `member_suspended` a WHERE a.`accountno` = '$accountno' ")->row('expiry_date');
            };

            if($active == 'SUSPEND' || $active == 'TERMINATE')
            {
                $flag = '0';
                $expirydate = '1970-12-31';
            };

            $data = array(
                'active' => $flag,
                'expirydate' => $expirydate,
                'acc_status' => $active
            );

            $this->db->WHERE("accountno",$accountno);
            $this->db->UPDATE("member",$data);
            
            /*$this->db->query("UPDATE backend_member.member set active = '$active' where accountno = '$accountno'");*/


            if($active == 'TERMINATE')
            {
                // if current point is negative
                if($get_data->row('Pointbalance') < 0)
                {
                    $pointbalance = $get_data->row('Pointbalance') + $get_data->row('Pointbalance');
                }
                else
                {
                    $pointbalance = $get_data->row('Pointbalance') - $get_data->row('Pointbalance');
                }

                $accountno = $accountno;
                $name = $get_data->row('Name');
                $cardno = $get_data->row('CardNo');
                $pointbalance = $pointbalance;
                $point_adjust = $get_data->row('Pointsbalance');
                $branch = $this->input->post('branch');

                $this->Trans_Model->terminate_card($accountno,$name,$pointbalance,$point_adjust,$branch,$cardno);
            };

            if($active == 'SUSPEND')
            {
                $data = array(
                    'guid' => $this->guid(),
                    'accountno' => $accountno,
                    'card_no' =>  $_SESSION['card_no'],
                    'created_by' => $_SESSION['username'],
                    'created_at' => $this->datetime(),
                    'updated_by' => $_SESSION['username'],
                    'updated_at' => $this->datetime(),
                    'expiry_date' => $get_data->row('Expirydate'),
                    'active' => $flag,
                    'branch' => $this->input->post('branch')
                );
                $this->db->insert("member_suspended",$data);
            };

            if($active == 'ACTIVE')
            {
                $data = array(
                    'updated_by' => $_SESSION['username'],
                    'updated_at' => $this->datetime(),
                    'active' => '1',
                    'branch' => $this->input->post('branch'),
                );
                $this->db->WHERE("accountno",$accountno);
                $this->db->UPDATE("member_suspended",$data);
            };

            $data = array(
                'Trans_type' => 'UPDATE '.$active,
                'AccountNo' => $accountno,
                'ReceiptNo' => '',
                'expiry_date_before' => $get_data->row('Expirydate'),
                'expiry_date_after' => $expirydate,
                'created_at' => $this->datetime(),
                'created_by' => $_SESSION['username'],
                );
            $this->db->insert('user_logs', $data);


                $icno_input = $this->input->post('ic_no');
                $icno = $this->db->query("SELECT REPLACE('$icno_input','-','') AS icno")->row('icno');
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 16px">Successful '.$active.' Old Account.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('Transaction_c/activation?exist_card='.$_SESSION['card_no'].'&account='.$_SESSION['account_no'].'&ic_no='.$icno.'&active='.$_SESSION['active'].'&mobile_no='.$this->input->post('mobile_no').'&email='.$this->input->post('email').'&nationality='.$this->input->post('national').'&army_no='.$this->input->post('army_no').'&branch='.$this->input->post('branch'));
        }
        else
        {
            redirect('login_c');
        }
    }



}