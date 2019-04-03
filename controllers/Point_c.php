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
        $this->load->model('Point_Model');
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


    public function check_parameter()
    {
        $query = $this->db->query("SELECT * FROM `set_parameter`");
        return $query; 
    }

    public function check_tac_for_redeem($data)
    {
        $result = $this->Member_Model->query_call('Point_c', 'check_tac_for_redeem', $data);
        return $result['tac'][0]['tac'];
    }

    public function recalc_point($data)
    {
        $result = $this->Member_Model->query_call('Point_c', 'recalc_point', $data);
        return $result['message'];
    }

    public function branch()
    {
        $branch = array();

        $data = array(
            'username' => $_SESSION['username'],
            'userpass' => $_SESSION['userpass'],
            'module_group_guid' => $_SESSION['module_group_guid'],
        );

        $result = $this->Member_Model->query_call('Point_c', 'branch', $data);

        if(isset($result['branch']))
        {
            $branch = $result['branch'];
        }

        return $branch;
    }

    public function index()
    {
        if($this->session->userdata('loginuser') == true)
        {
            //unset($_SESSION['title']);

            $column = $_REQUEST['column'];

            if($column == 'POINT_ADJ_IN')
            {
                //$_SESSION['title'] = 'Point Adjust-IN';
                $title = 'Point Adjust-IN';
                unset($_SESSION['item_redeem']);
            }
            elseif($column == 'POINT_ADJ_OUT')
            {
                //$_SESSION['title'] = 'Point Adjust-OUT';
                $title = 'Point Adjust-OUT';
                unset($_SESSION['item_redeem']);
            }
            elseif($column == 'POINT_REDEEM')
            {
                //$_SESSION['title'] = 'Voucher Redemption';
                $title = 'Voucher Redemption';
                unset($_SESSION['item_redeem']);

                $number = $this->db->query("SELECT * FROM set_sysrun where TRANS_TYPE = 'VOUCHER_NO' ")->num_rows();

                if($number == '0')
                {
                    $info = array(
                        'TRANS_TYPE' => 'VOUCHER_NO',
                        'REF_CODE' => 'HQVC',
                        'REF_RUNNINGNO' => '1',
                        'REF_DIGIT' => '4',
                        'REF_DATE' => $this->db->query("SELECT CURDATE() as date ")->row('date'),

                    );
                    $this->db->insert('set_sysrun', $info);
                };
            }
            elseif($column == 'ITEM_REDEEM')
            {
                //$_SESSION['title'] = 'Item Redemption';
                $title = 'Item Redemption';
                $_SESSION['item_redeem'] = 'item_redeem';
                // $column = 'ITEM_REDEEM';
            }
            elseif($column == 'REDEEM_CASH')
            {
                //$_SESSION['title'] = 'Cash Redemption';
                $title = 'Cash Redemption';
                $_SESSION['item_redeem'] = 'item_redeem';
                // $column = 'REDEEM_CASH';
            }

            if($column == 'POINT_REDEEM')
            {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');

                $trans_main = $this->db->query("SELECT c.* FROM mem_item a INNER JOIN trans_child b ON a.ITEM_CODE = b.ITEMCODE INNER JOIN trans_main c ON b.TRANS_GUID = c.TRANS_GUID WHERE a.ITEM_TYPE = 'REDEEM' AND a.isVoucher = '1' AND TRANS_TYPE = 'POINT_REDEEM' GROUP BY TRANS_GUID order by created_at desc limit 1000");
            }
            elseif($column == 'ITEM_REDEEM')
            {
                $trans_main = $this->db->query("SELECT c.* FROM mem_item a INNER JOIN trans_child b ON a.ITEM_CODE = b.ITEMCODE INNER JOIN trans_main c ON b.TRANS_GUID = c.TRANS_GUID WHERE a.ITEM_TYPE = 'REDEEM' AND a.isVoucher = '0' AND TRANS_TYPE = 'POINT_REDEEM' GROUP BY TRANS_GUID order by created_at desc limit 1000 ");
            }
            elseif($column == 'POINT_ADJ_IN')
            {
                $trans_main = $this->db->query("SELECT * FROM(
                    SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ_IN' GROUP BY TRANS_GUID
                    UNION ALL
                    SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ' AND VALUE_TOTAL > 0 GROUP BY TRANS_GUID) AS a
                    ORDER BY a.created_at DESC LIMIT 2000 ");
            }
            elseif($column == 'POINT_ADJ_OUT')
            {
                $trans_main = $this->db->query("SELECT * FROM(
                    SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ_OUT' GROUP BY TRANS_GUID
                    UNION ALL
                    SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ' AND VALUE_TOTAL < 0 GROUP BY TRANS_GUID) AS a
                    ORDER BY a.created_at DESC LIMIT 2000 ");
            }
            elseif($column == 'REDEEM_CASH')
            {
                $trans_main = $this->db->query("SELECT * FROM trans_main a WHERE a.`TRANS_TYPE` = 'POINT_REDEEM' AND LEFT(a.`REF_NO`,3) = 'RDC' AND a.`reason` = 'CASH' ORDER BY created_at DESC LIMIT 1000;");
            }
            else
            {
                $trans_main = $this->db->query("SELECT * from trans_main where TRANS_TYPE = '$column' GROUP BY TRANS_GUID order by created_at desc limit 2000 ");
            }

            $data = array(
                'trans_main' => $trans_main,
                'title' => $title,
                'column' => $column,

                );
            $this->template->load('template' , 'main_point_adj_in_out', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function main_in_out_server_side()
    {
        if($this->session->userdata('loginuser')== true)
        {   
            $columns = array(
                0 => "Edit",
                1 => "POSTED",
                2 => "REF_NO",
                3 => "TRANS_DATE",
                4 => "SUP_CODE",
                5 => "SUP_NAME",
                6 => "VALUE_TOTAL",
                7 => "REMARK",
                8 => "CREATED_AT",
                9 => "CREATED_BY",
                10 => "UPDATED_AT",
                11 => "UPDATED_BY",
            );

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];
            $column = $this->input->post('column');

            $totalFiltered = $totalData = $this->Point_Model->count_main_in_out($column);

            if(empty($this->input->post('search')['value']))
            {
                $posts = $this->Point_Model->main_in_out_list($column, $limit, $start, $order, $dir);
            }
            else
            {
                $search = $this->input->post('search')['value'];
                $posts = $this->Point_Model->search_main_in_out_list($column, $limit, $start, $order, $dir, $search);
                $totalFiltered = $posts->num_rows();
            }

            $check = $posts->result();

            if(!empty($check))
            {
                foreach ($posts->result() as $post)
                {
                    $nestedData['Edit'] = '<a href="'.site_url('Point_c/edit_main').'?guid='.$post->TRANS_GUID.'&column='.$post->TRANS_TYPE.'&edit=1" title="Edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a> ';

                    if($post->POSTED == '1')
                    {
                        $nestedData['POSTED'] = "<center><span>&#10004</span></center>";
                    }
                    else
                    {
                        $nestedData['POSTED'] = "<center><span>&#10006</span></center>";
                    }
                    
                    $nestedData['REF_NO'] = $post->REF_NO;
                    $nestedData['TRANS_DATE'] = $post->TRANS_DATE;
                    $nestedData['SUP_CODE'] = $post->SUP_CODE;
                    $nestedData['SUP_NAME'] = $post->SUP_NAME;
                    $nestedData['VALUE_TOTAL'] = $post->VALUE_TOTAL;
                    $nestedData['REMARK'] = $post->REMARK;
                    $nestedData['CREATED_AT'] = $post->CREATED_AT;
                    $nestedData['CREATED_BY'] = $post->CREATED_BY;
                    $nestedData['UPDATED_AT'] = $post->UPDATED_AT;
                    $nestedData['UPDATED_BY'] = $post->UPDATED_BY;

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
        else
        {
            redirect('login_c');
        }
    }

    public function add_point_adj_in_out()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $column = $_REQUEST['column'];

            if($column == 'POINT_ADJ_IN')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $title = 'Point Adjust-IN';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'ADJUSTMENT';");
            }
            elseif($column == 'POINT_ADJ_OUT')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $title = 'Point Adjust-OUT';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'ADJUSTMENT';");
            }
            elseif($column == 'POINT_REDEEM')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '1' and enable = 1 ");
                $title = 'Voucher Redemption';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'REDEMPTION';");
            }
            elseif($column == 'ITEM_REDEEM')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '0' and enable = 1 ");
                $title = 'Item Redemption';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'REDEMPTION';");
            }

            $data = array(
                // 'branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),
                'branch' => $this->branch(),
                'guid' => '',
                'trans_child' => '',
                'action' => site_url('Point_c/create_point_adj_in_out?condition='.$column),
                'button' => 'Create',
                'column' => $column,
                'title' => $title,
                'select_reason' => $select_reason,
                'type' => '',
                'Reference' => '',
                'Code' => '',
                'Cardno' => '',
                'Date' => '',
                'post' => '',
                'Remarks' => '',
                'branch_result' => '',
                'Name' => '',
                'Point_Before' => '',
                'Point_Adjust' => '0.00',
                'Point_Balance' => '', 
                'voucher' => $voucher,
                'Voucher_Type' => '',
                'Qty' => '1',
                'edit' => '',
                'reason' => '',
                'value_total' => '0.00',
                'Voucher_No' => '',
                'Voucher_No_Start' => '',
                'Voucher_No_End' => '',
                'customized_voucher_no' => $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no'),
                'check_digit' => $this->db->query("SELECT check_digit_voucher FROM set_parameter")->row('check_digit_voucher'),


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
            if($_REQUEST['accountno'] != NULL || $_REQUEST['accountno'] != ''){
                $key = $_REQUEST['accountno'];
                $col_name = 'CardNo';
                $col_name2 = 'b.SupCardNo';
            }
            else
            {
                $key = $this->input->post('memberno');

            }

            if($_REQUEST['guid'] != NULL || $_REQUEST['guid'] != ''){
                $key1 = $_REQUEST['guid'];
                
            }
            else
            {
                $key1 = '';

            }

            $condition = $_REQUEST['condition'];

            if($condition == 'ITEM_REDEEM')
            {
                $condition = 'POINT_REDEEM';
            }

            $current = $this->db->query("SELECT DATE_FORMAT(CURDATE(), '%Y-%m') as date")->row('date');
            $month = $this->db->query("SELECT DATE_FORMAT(REF_DATE, '%Y-%m') as date FROM set_sysrun WHERE TRANS_TYPE = '$condition' ")->row('date');
            // $branch = $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC");

            $branch = $this->branch();

            if($current == $month)
            {
                $sql = $this->db->query("SELECT CONCAT(REF_CODE, REPLACE(CURDATE(), '-', ''), REPEAT(0,REF_DIGIT-LENGTH(REF_RUNNINGNO)), REF_RUNNINGNO) AS asn_no FROM set_sysrun WHERE TRANS_TYPE = '$condition' ")->row('asn_no');
            }
            else
            {
                $info = array(
                        'REF_RUNNINGNO' => '1',
                        'REF_DATE' => $this->db->query("SELECT CURDATE() AS date")->row('date'),
                        );
                $this->db->where('TRANS_TYPE', $condition);
                $this->db->update('set_sysrun', $info);

                $sql = $this->db->query("SELECT CONCAT(REF_CODE, REPLACE(CURDATE(), '-', ''), REPEAT(0,REF_DIGIT-LENGTH(REF_RUNNINGNO)), REF_RUNNINGNO) AS asn_no FROM set_sysrun WHERE TRANS_TYPE = '$condition' ")->row('asn_no');
            }

            if($this->input->post('search') == 'Card')
            {
                $col_name = 'CardNo';
                $col_name2 = 'b.SupCardNo';
                $message = 'Invalid Card No.';
            };

            if($this->input->post('search') == 'Name')
            {
                $col_name = 'Name';
                $col_name2 = 'b.Name';
                $message = 'Name is not exist';
            };

            if($this->input->post('search') == 'Passport')
            {
                $col_name = 'PassportNo';
                $col_name2 = 'a.PassportNo';
                $message = 'Invalid Passport No';
            };

            if($this->input->post('search') == 'Ic')
            {
                $col_name = 'ICNo';
                $col_name2 = 'b.ICNo';
                $message = 'Invalid IC No';
            };   

            $result_sup = $this->db->query("SELECT a.Pointsbalance, b.*, b.SupCardNo as CardNo FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE $col_name2 = '$key' AND b.PrincipalCardNo IN ('SUPCARD', 'LOSTCARD') and b.Active = '1' ");

            if($result_sup->num_rows() == 0)
            {
                //$result_main = $this->db->query("SELECT * FROM member WHERE $col_name = '$key' UNION ALL SELECT a.* FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE $col_name2 = '$key' ");
                $result_main = $this->db->query("SELECT * FROM member WHERE $col_name = '$key' ");
            }
            else
            {
                $result_main = $this->db->query("SELECT a.Pointsbalance,
                    b.`AccountNo`,
                    b.`PrincipalCardNo`,
                    b.`SupCardNo`,
                    IF(b.PrincipalCardNo = 'LOSTCARD', a.Name, b.Name) AS Name,
                    IF(b.PrincipalCardNo = 'LOSTCARD', a.`NameOnCard`, b.`NameOnCard`) AS NameOnCard,
                    b.`Title`,
                    b.`ICNo`,
                    b.`OldICNo`,
                    b.`Nationality`,
                    b.`Relationship`,
                    b.`Birthdate`,
                    b.`Gender`,
                    b.`Principal`,
                    b.`PhoneMobile`,
                    b.`CREATED_BY`,
                    b.`IssueStamp`,
                    b.`UPDATED_BY`,
                    b.`LastStamp`,
                    b.`NewForScript`,
                    b.`Active`,
                    b.`InActiveStamp`,
                    b.`Remarks`,
                    b.`rec_edit`,
                    b.`rec_new`,
                    b.`name_first`,
                    b.`name_last`,
                    if(b.principalcardno = 'LOSTCARD', a.`Expirydate`, b.Expirydate) as Expirydate,
                    b.`email` , b.SupCardNo AS CardNo FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE $col_name2 = '$key' AND b.PrincipalCardNo IN ('SUPCARD', 'LOSTCARD') and b.Active = '1'");
            }
            //$result = $this->db->query("SELECT * FROM backend_member.member WHERE $col_name = '$key' ");

            $check_lost_card = $this->db->query("SELECT LostCardNo FROM memberlostcard WHERE LostCardNo = '".$key."'");

            if($check_lost_card->num_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 16px">This Card Already Lost. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/add_point_adj_in_out?column=".$condition."&accountno=&guid=");
            }
            
            if($result_main->num_rows() > 0)
            {
                $current = $this->db->query("SELECT CURDATE() as date")->row('date');

                if($result_main->row('Expirydate') > $current)
                {
                    if($_REQUEST['condition'] == 'POINT_ADJ_IN')
                    {
                        $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                        $title = 'Point Adjust-IN';
                        $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'ADJUSTMENT';");
                    }
                    elseif($_REQUEST['condition'] == 'POINT_ADJ_OUT')
                    {
                        $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                        $title = 'Point Adjust-OUT';
                        $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'ADJUSTMENT';");
                    }
                    elseif($_REQUEST['condition'] == 'POINT_REDEEM')
                    {
                        $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '1' and enable = 1 ");
                        $title = 'Voucher Redemption';
                        $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'REDEMPTION';");
                    }
                    elseif($_REQUEST['condition'] == 'ITEM_REDEEM')
                    {
                        $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '0' and enable = 1 ");
                        $title = 'Item Redemption';
                        $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'REDEMPTION';");
                    }

                    $sessiondata = array(
                        'accountno1' => $result_main->row('AccountNo'),
                    );

                    $this->session->set_userdata($sessiondata);

                    $data = array(
                        'branch' => $branch,
                        'trans_child' => '',
                        'guid' => $key1,
                        'action' => site_url('Point_c/create_point_adj_in_out?condition=' .$_REQUEST['condition'].'&accountno'.$key),
                        'button' => 'Create',
                        'title' => $title,
                        'column' => $condition,
                        'select_reason' => $select_reason,
                        'Reference' => $sql,
                        'Code' => $result_main->row('AccountNo'),
                        'Cardno' => $result_main->row('CardNo'),
                        'Date' => $current,
                        'post' => '',
                        'Remarks' => '',
                        'branch_result' => '',
                        'Name' => $result_main->row('Name'),
                        'Point_Before' => $result_main->row('Pointsbalance'),
                        'Point_Adjust' => '0.00',
                        'Point_Balance' => $result_main->row('Pointsbalance'),
                        'voucher' => $voucher,
                        'Voucher_Type' => $this->input->post('Voucher_Type'),
                        'Qty' => '1',
                        'edit' => '',
                        'reason' => '',
                        'value_total' => '0.00',
                        'Voucher_No' => '',
                        'Voucher_No_Start' => '',
                        'Voucher_No_End' => '',
                        'customized_voucher_no' => $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no'),
                        'check_digit' => $this->db->query("SELECT check_digit_voucher FROM set_parameter")->row('check_digit_voucher'),


                        );
                    $this->template->load('template' , 'point_adj_in_out' , $data);
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Member Has Expired<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/add_point_adj_in_out?column=".$condition."&accountno=&guid=");
                }
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">'.$message.'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/add_point_adj_in_out?column=".$condition."&accountno=&guid=");
            }      
        }
        else
        {
            redirect('login_c');
        }
    }

    public function create_point_adj_in_out()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $condition = $_REQUEST['condition'];
            $date = $this->db->query("SELECT NOW() AS date")->row('date');
            $Voucher_Type = $this->input->post('Voucher_Type');
            $Branch = $this->input->post('Branch');
            $split_Branch = explode('(', $Branch);
            $split_Branch2 = explode(')', $split_Branch[1]);
            $accountno = $_SESSION['accountno1'];

            if($condition == 'ITEM_REDEEM')
            {
                $type = 'POINT_REDEEM';
            }
            else
            {
                $type = $condition;
            }

            if($condition == 'POINT_ADJ_IN')
            {
                $split_voucher = explode('=>', $Voucher_Type);
                $QTY_FACTOR = '1';
            }
            else
            {
                $split_voucher = explode('=>', $Voucher_Type);
                $ex_voucher = explode('-', $split_voucher[0]);
                $split_voucher[0] = $ex_voucher[1];
                $QTY_FACTOR = '-1';
            }

            if($condition == 'POINT_ADJ_OUT')
            {
                $QTY_FACTOR = '-1';
            }
            else
            {
                $QTY_FACTOR = '1';
            }
            /*elseif($_SESSION['title'] == 'Voucher Redemption')
            {
                $split_voucher = explode('=>', $Voucher_Type);
                $ex_voucher = explode('-', $split_voucher[0]);
                $split_voucher[0] = $ex_voucher[1];
                $QTY_FACTOR = '1';
            }*/
            if($condition == 'POINT_ADJ_OUT')
            {
                $qty = $this->input->post('Qty');
                $vt = $this->input->post('value_total');
            }
            else
            {
                $qty = $this->input->post('Qty');
                $vt = $this->input->post('value_total');
            }

            /*if($_SESSION['title'] == 'Point Adjust-IN')
            {
                $total = abs($this->input->post('total'));
            }
            elseif($_SESSION['title'] == 'Point Adjust-OUT')
            {
                $total = $this->input->post('total');
            }
            else
            {
                $total = $this->input->post('total');
            }*/
            $total = $qty * $split_voucher[0];
            $guid = "";

            if(isset($_REQUEST['guid']))
            {
                $guid = $_REQUEST['guid'];
                $operation = 'edit';

                if($this->input->post('Point_Balance') < 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Point balance cannot be negative value<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/add_voucher?condition=" .$condition. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);
                };
            }
            else
            {
                $guid = $this->db->query('SELECT REPLACE(UPPER(UUID()), "-", "") AS guid')->row('guid');
                $operation = 'insert';

                if($this->input->post('Point_Balance') < 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Point balance cannot be negative value<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/search?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=");
                };
            }

            $data = array(
                'voucher_no' => $this->input->post('Voucher_No'),
                'guid' => $guid,
                'type' => $type,
                'refno' => $this->input->post('Reference'),
                'date' => date("Y-m-d",strtotime($this->input->post('Date'))),
                'code' => $this->input->post('Code'),
                'name' => $this->input->post('Name'),
                'remarks' => $this->input->post('Remarks'),
                'valuetotal' => $QTY_FACTOR * $total,
                'username' => $_SESSION['username'],
                'point_curr' => $this->input->post('Point_Before'),
                'branch' => $split_Branch2[0],
                'cardno' => addslashes($this->input->post('Cardno')),
                'reason' => $this->input->post('Reason'),
                'operation' => $operation,
            );

            $result = $this->Member_Model->query_call('Point_c', 'create_point_adj_in_out', $data);

            if($result['message'] != 'success')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Voucher no. ' .$this->input->post('Voucher_No'). ' already exists, please try again<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/search?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=");
            }

            // $REFNO = $this->db->query("SELECT REFNO FROM frontend.voucher_general WHERE REFNO = '".$this->input->post('Voucher_No')."'");
            // // echo $this->db->last_query();die;
            // if($REFNO->num_rows() > 0 && $this->input->post('Voucher_No'))
            // {
            //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Voucher no. ' .$this->input->post('Voucher_No'). ' already exists, please try again<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            //     redirect("Point_c/search?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=");
            // };

            // if(isset($_REQUEST['guid']))
            // {
                // $guid = $_REQUEST['guid'];

                // if($this->input->post('Point_Balance') < 0)
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Point balance cannot be negative value<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                //     redirect("Point_c/add_voucher?condition=" .$condition. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);
                // };

                /*$VALUE_TOTAL = $this->db->query("SELECT * from trans_main where TRANS_GUID = '$guid' ")->row('VALUE_TOTAL');
                $total = $VALUE_TOTAL + ($this->input->post('Point_Adjust'));*/

                //ori_log
                /*$ori = $this->db->query("SELECT * from backend_member.trans_main where TRANS_GUID = '$guid' ");
                $ori_VALUE_TOTAL = $ori->row('VALUE_TOTAL');*/
                //ori_log

                // $data = array(
                //     /*'VALUE_TOTAL' => $total,*/
                //     'VALUE_TOTAL' => $this->input->post('value_total'),

                // );
                // $this->db->where('TRANS_GUID', $guid);
                // $this->db->update('trans_main', $data);

                //upd_log
                /*$upd = $this->db->query("SELECT * from backend_member.trans_main where TRANS_GUID = '$guid' ");
                $upd_VALUE_TOTAL = $upd->row('VALUE_TOTAL');*/
                //upd_log

                /*switch ($ori_VALUE_TOTAL) 
                {
                    case $upd_VALUE_TOTAL:
                        break;
                    default:
                        $data = array(
                            'Trans_type' => $_SESSION['title'].' Main',
                            'AccountNo' => $this->input->post('Code'),
                            //'ReceiptNo' => $_SESSION['receipt_no'],
                            'field' => 'VALUE_TOTAL',
                            'value_from' => $ori_VALUE_TOTAL,
                            'value_to' => $upd_VALUE_TOTAL,
                            //'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                            //'expiry_date_after' => addslashes($get_new_expiry_date),
                            'created_at' => $this->db->query("SELECT NOW() as curdate")->row('curdate'),
                            'created_by' => $_SESSION['username'],
                            );
                        $this->db->insert('user_logs', $data);
                }*/
            // }
            // else
            // {
                // if($this->input->post('Point_Balance') < 0)
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Point balance cannot be negative value<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                //     redirect("Point_c/search?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=");
                // };

                // $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS UUID")->row('UUID');

                // $data = array(
                //     'TRANS_GUID' => $guid,
                //     'TRANS_TYPE' => $type,
                //     'REF_NO' => $this->input->post('Reference'),
                //     'TRANS_DATE' => date("Y-m-d",strtotime($this->input->post('Date'))),
                //     'SUP_CODE' => $this->input->post('Code'),
                //     'SUP_NAME' => $this->input->post('Name'),
                //     'REMARK' => addslashes($this->input->post('Remarks')),
                //     'VALUE_TOTAL' => $QTY_FACTOR * $total,
                //     'CREATED_AT' => $date,
                //     'CREATED_BY' => $_SESSION['username'],
                //     'UPDATED_AT' => $date,
                //     'UPDATED_BY' => $_SESSION['username'],
                //     'point_curr' => $this->input->post('Point_Before'),
                //     'branch' => $split_Branch2[0],
                //     'send_outlet' => '0',
                //     'cardno' => addslashes($this->input->post('Cardno')),
                //     'reason' => $this->input->post('Reason')

                //     );
                // $this->db->insert('trans_main', $data);

                // $ref = $this->db->query("SELECT (REF_RUNNINGNO+1) AS ref FROM set_sysrun WHERE TRANS_TYPE = '$type' ")->row('ref');
                // $info = array(
                //     'REF_RUNNINGNO' => $ref,
                //     'REF_DATE' => $this->db->query("SELECT CURDATE() AS date")->row('date'),
                //     );
                // $this->db->where('TRANS_TYPE', $type);
                // $this->db->update('set_sysrun', $info);
            // }
            
            if($condition == 'POINT_REDEEM')
            {
                $customized_voucher_no = $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no');

                if($customized_voucher_no == '1')
                {
                    $cross_refno = $this->input->post('Voucher_No');
                }
                else if($customized_voucher_no == '0')
                {
                    // $cross_refno = $this->db->query("SELECT b.REFNO FROM backend_member.mem_item a INNER JOIN frontend.voucher_general b ON a.ITEM_GUID = b.link_guid WHERE ITEM_CODE = '".$split_voucher[1]."' ")->row('REFNO');
                    $cross_refno = "";

                    $data = array(
                        'split_voucher' => $split_voucher[1],
                    );

                    $get_cross_refno = $this->Member_Model->query_call('Point_c', 'create_point_adj_in_out_tmp1', $data);

                    if(isset($get_cross_refno['cross_refno'][0]['REFNO']))
                    {
                        $cross_refno = $get_cross_refno['cross_refno'][0]['REFNO'];
                    }
                }
                else if($customized_voucher_no == '2')
                {
                    $Voucher1 = $this->input->post('Voucher_No_Start');
                    $Voucher2 = $this->input->post('Voucher_No_End');
                    if($Voucher2 == '' || $Voucher2 == NULL)
                    {
                        $Voucher2 = $Voucher1;
                    }
                    $price = $split_voucher[3];
                    // $check_voucher1 = $this->db->query("SELECT * FROM frontend.voucher_general WHERE REFNO = '$Voucher1'")->num_rows();
                    // $check_voucher2 = $this->db->query("SELECT * FROM frontend.voucher_general WHERE REFNO = '$Voucher2'")->num_rows();

                    // if($check_voucher1 < 1 || $check_voucher2 < 1)
                    // {
                    //      $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Voucher No does not exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    //         if($_REQUEST['guid'] != NULL || $_REQUEST['guid'] != ''){
                    //                 redirect("Point_c/add_voucher?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=".$_REQUEST['guid']);
                                    
                    //             }
                    //             else
                    //             {
                    //                 redirect("Point_c/search?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=");

                    //             }
                        
                    // }
                    
                    if(isset($_REQUEST['guid']) && $_REQUEST['guid'] != NULL && $_REQUEST['guid'] != '')
                    {
                        $voucher_checklist = $this->db->query("SELECT cross_refno FROM trans_child WHERE trans_guid='".$_REQUEST['guid']."' ")->result();

                        
                        foreach($voucher_checklist as $key =>$value)
                        {
                            if(strtoupper($Voucher1) == $value->cross_refno)
                            {
                                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Voucher No already created!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect("Point_c/add_voucher?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=".$_REQUEST['guid']);
                            }
                        }
                    }

                    $data = array(
                        'voucher1' => $Voucher1,
                        'voucher2' => $Voucher2,
                        'price' => $price,
                    );

                    $result = $this->Member_Model->query_call('Point_c', 'create_point_adj_in_out_tmp', $data);

                    if($result['message'] != 'success')
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                        if($_REQUEST['guid'] != NULL || $_REQUEST['guid'] != '')
                        {
                            redirect("Point_c/add_voucher?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=".$_REQUEST['guid']);
                        }
                        else
                        {
                            redirect("Point_c/search?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=");
                        }
                    }

                    // if($this->db->query("SELECT AMOUNT FROM frontend.voucher_general WHERE REFNO ='$Voucher1'")->row('AMOUNT') != $this->db->query("SELECT AMOUNT FROM frontend.voucher_general WHERE REFNO ='$Voucher2'")->row('AMOUNT'))
                    // {
                    //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Please insert same Voucher Type Voucher Number!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    //     if($_REQUEST['guid'] != NULL || $_REQUEST['guid'] != '')
                    //     {
                    //         redirect("Point_c/add_voucher?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=".$_REQUEST['guid']);
                    //     }
                    //     else
                    //     {
                    //         redirect("Point_c/search?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=");
                    //     }
                    // }

                    // if($price != $this->db->query("SELECT AMOUNT FROM frontend.voucher_general WHERE REFNO ='$Voucher1'")->row('AMOUNT') || $price != $this->db->query("SELECT AMOUNT FROM frontend.voucher_general WHERE REFNO ='$Voucher2'")->row('AMOUNT'))
                    // {
                    //      $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Different/Wrong Item selected!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    //       if($_REQUEST['guid'] != NULL || $_REQUEST['guid'] != ''){
                    //                 redirect("Point_c/add_voucher?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=".$_REQUEST['guid']);
                                    
                    //             }
                    //             else
                    //             {
                    //                  redirect("Point_c/search?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=");
                    //             }
                    // }

                    // $list_voucher = $this->db->query("SELECT REFNO,activated FROM frontend.voucher_general WHERE REFNO BETWEEN '$Voucher1' AND '$Voucher2'")->result();
                    $list_voucher = array();

                    if(isset($result['list_voucher']))
                    {
                        $list_voucher = $result['list_voucher'];
                    }

                    if(isset($_REQUEST['guid']) && ($_REQUEST['guid'] != NULL || $_REQUEST['guid'] != ''))
                    {
                        $voucher_checklist = $this->db->query("SELECT cross_refno FROM trans_child WHERE trans_guid='".$_REQUEST['guid']."' ")->result();

                        foreach($list_voucher as $value)
                        {
                            foreach($voucher_checklist as $value1)
                            {
                                if($value->REFNO == strtoupper($value1->cross_refno))
                                {
                                     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Voucher List contains created voucher!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                                redirect("Point_c/add_voucher?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=".$_REQUEST['guid']);
                                }
                            }
                        }
                    }

                    foreach ($list_voucher as $row) {

                        if($row['activated'] == 1)
                        {
                             $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Voucher list contains activated voucher!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                             if($_REQUEST['guid'] != NULL || $_REQUEST['guid'] != ''){
                                    redirect("Point_c/add_voucher?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=".$_REQUEST['guid']);
                                    
                                }
                                else
                                {
                                redirect("Point_c/search?condition=" .$condition."&accountno=".$_SESSION['accountno1']."&guid=");
                                }
                        }
                        
                    $data1[] = array(
                        'CHILD_GUID' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS UUID")->row('UUID'),
                        'TRANS_GUID' => $guid,
                        'ITEMCODE' => $split_voucher[1],
                        'DESCRIPTION' => $split_voucher[2],
                        'QTY_FACTOR' => $QTY_FACTOR,
                        'QTY' => 1,
                        'VALUE_UNIT' => $split_voucher[0],
                        'VALUE_TOTAL' => $split_voucher[0],
                        'CREATED_AT' => $date,
                        'CREATED_BY' => $_SESSION['username'],
                        'UPDATED_AT' => $date,
                        'UPDATED_BY' => $_SESSION['username'],
                        'cross_refno' => $row->REFNO,
                        );
                }
               

                    $this->db->insert_batch('trans_child', $data1);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Insert Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Insert Record<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    redirect("Point_c/add_voucher?condition=" .$condition. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);

                }
            }
            else
            { 
                $cross_refno = '';
            }

            $data = array(
                'CHILD_GUID' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS UUID")->row('UUID'),
                'TRANS_GUID' => $guid,
                'ITEMCODE' => $split_voucher[1],
                'DESCRIPTION' => $split_voucher[2],
                'QTY_FACTOR' => $QTY_FACTOR,
                'QTY' => $qty,
                'VALUE_UNIT' => $split_voucher[0],
                'VALUE_TOTAL' => $total,
                'CREATED_AT' => $date,
                'CREATED_BY' => $_SESSION['username'],
                'UPDATED_AT' => $date,
                'UPDATED_BY' => $_SESSION['username'],
                'cross_refno' => $cross_refno,

                );
            $this->db->insert('trans_child', $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Insert Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Insert Record<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Point_c/add_voucher?condition=" .$condition. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function edit_main()
    {
        if($this->session->userdata('loginuser')== true)
        {   
            $guid = $_REQUEST['guid'];
            $condition = $_REQUEST['column'];
            $result = $this->db->query("SELECT * from trans_main where TRANS_GUID = '$guid' ");
            $mem_result = $this->db->query("SELECT * from member where AccountNo = '".$result->row('SUP_CODE')."' ");
            $branch_name = "";
            // $branch_name = $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' AND branch_code = '".$result->row('branch')."' ORDER BY branch_code ASC")->row('branch_name');

            $data = array(
                'username' => $_SESSION['username'],
                'userpass' => $_SESSION['userpass'],
                'module_group_guid' => $_SESSION['module_group_guid'],
                'trans_guid' => $guid,
            );

            $get_result = $this->Member_Model->query_call('Point_c', 'edit_main', $data);

            if(isset($get_result['branch_name'][0]['branch_name']))
            {
                $branch_name = $get_result['branch_name'][0]['branch_name'];
            }

            $Point_Before = $Point_Balance = $mem_result->row('Pointsbalance');
            
            if($condition == 'POINT_REDEEM')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '1' and enable = 1 ");
                $value_result = -number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
                $title = 'Voucher Redemption';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'REDEMPTION';");
            }
            elseif($condition == 'POINT_ADJ_IN' || ($condition == 'POINT_ADJ' && $result->row('VALUE_TOTAL') > 0))
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $value_result = number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
                $title = 'Point Adjust-IN';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'ADJUSTMENT';");
            }
            elseif($condition == 'POINT_ADJ_OUT' || ($condition == 'POINT_ADJ' && $result->row('VALUE_TOTAL') < 0))
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $value_result = -number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
                $title = 'Point Adjust-OUT';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'ADJUSTMENT';");
            }
            elseif($condition == 'ITEM_REDEEM')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '0' and enable = 1 ");
                $value_result = -number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
                $title = 'Item Redemption';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'REDEMPTION';");
            }
            elseif($condition == 'REDEEM_CASH')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '0' and enable = 1 ");
                $value_result = -number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
                $title = 'Cash Redemption';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'REDEMPTION';");
            }

            if($result->row('POSTED') == '1')
            {
                /*$movement = $this->db->query("SELECT * from points_movement where PeriodCode = '".$result->row('REF_NO')."' and AccountNo = '".$result->row('SUP_CODE')."' ");*/
                $Point_Before = $result->row('point_curr');
                $Point_Balance = '';
                $_REQUEST['edit'] = '3';
            };

            $data = array(
                // 'branch' =>$this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),
                'branch' => $this->branch(),
                'guid' => $guid,
                'trans_child' => $this->db->query("SELECT * from trans_child where TRANS_GUID = '$guid' "),
                'action' => site_url('Point_c/create_point_adj_in_out?guid=' .$guid. '&accountno='.$result->row('SUP_CODE').'&condition=' .$condition),
                'button' => 'Create',
                'title' => $title,
                'column' => $condition,
                'select_reason' => $select_reason,
                'Reference' => $result->row('REF_NO'),
                'Code' => $result->row('SUP_CODE'),
                'Cardno' => $result->row('cardno'),
                'Date' => $result->row('TRANS_DATE'),
                'post' => $result->row('POSTED'),
                'Remarks' => $result->row('REMARK'),
                'branch_result' => $this->db->query("SELECT CONCAT('".$branch_name."', ' (', '".$result->row('branch')."', ')') as data ")->row('data'),
                'Name' => $result->row('SUP_NAME'),
                'Point_Before' => $Point_Before,
                'Point_Adjust' => '0.00',
                'Point_Balance' => $Point_Balance,
                'voucher' => $voucher,
                'Voucher_Type' => '',
                'Qty' => '1',
                'edit' => $_REQUEST['edit'],
                'reason' => $result->row('reason'),
                'value_total' => $value_result,
                'Voucher_No' => '',
                'Voucher_No_Start' => '',
                'Voucher_No_End' => '',
                'customized_voucher_no' => $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no'),
                'check_digit' => $this->db->query("SELECT check_digit_voucher FROM set_parameter")->row('check_digit_voucher'),

                );

            $this->template->load('template' , 'point_adj_in_out' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function edit_child()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $_REQUEST['guid'];
            $chi_guid = $_REQUEST['chi_guid'];
            $chi_result = $this->db->query("SELECT * from trans_child where CHILD_GUID = '$chi_guid' ");
            $condition = $_REQUEST['column'];
            $result = $this->db->query("SELECT * from trans_main where TRANS_GUID = '$guid' ");
            $mem_result = $this->db->query("SELECT * from member where AccountNo = '".$result->row('SUP_CODE')."' ");
            $uuid = $this->db->query("SELECT * from trans_child where CHILD_GUID = '$chi_guid' ");

            $data = array(
                'username' => $_SESSION['username'],
                'userpass' => $_SESSION['userpass'],
                'module_group_guid' => $_SESSION['module_group_guid'],
                'trans_guid' => $guid,
            );

            $branch_name = "";
            $get_branch_name = $this->Member_Model->query_call('Point_c', 'edit_child', $data);

            if(isset($get_branch_name['branch_name'][0]['branch_name']))
            {
                $branch_name = $get_branch_name['branch_name'][0]['branch_name'];
            }

            // $branch_name = $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' AND branch_code = '".$result->row('branch')."' ORDER BY branch_code ASC")->row('branch_name');

            if($condition == 'POINT_REDEEM')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '1' and enable = 1 ");
                $total = ($mem_result->row('Pointsbalance')) - ($uuid->row('VALUE_TOTAL'));
                $Point_Balance = $total;
                $Point_Adjust = -number_format(($uuid->row('VALUE_TOTAL')), 2, '.', '');
                $Point_Before = $mem_result->row('Pointsbalance');
                $Voucher_Type = $this->db->query("SELECT CONCAT('-', '".$chi_result->row('VALUE_UNIT')."', ' => ', '".$chi_result->row('ITEMCODE')."', ' => ', '".addslashes($chi_result->row('DESCRIPTION'))."') as data")->row('data');
                $value_result = -number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
                $title = 'Voucher Redemption';
            }
            elseif($condition == 'POINT_ADJ_IN')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $total = ($mem_result->row('Pointsbalance')) + ($uuid->row('VALUE_TOTAL'));
                $Point_Balance = $total;
                $Point_Adjust = number_format(($uuid->row('VALUE_TOTAL')), 2, '.', '');
                $Point_Before = $mem_result->row('Pointsbalance');
                $Voucher_Type = $this->db->query("SELECT CONCAT('".$chi_result->row('VALUE_UNIT')."', ' => ', '".$chi_result->row('ITEMCODE')."', ' => ', '".addslashes($chi_result->row('DESCRIPTION'))."') as data")->row('data');
                $value_result = number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
                $title = 'Point Adjust-IN';
            }
            elseif($condition == 'POINT_ADJ_OUT')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $total = ($mem_result->row('Pointsbalance')) - ($uuid->row('VALUE_TOTAL'));
                $Point_Balance = $total;
                $Point_Adjust = -number_format(($uuid->row('VALUE_TOTAL')), 2, '.', '');
                $Point_Before = $mem_result->row('Pointsbalance');
                $Voucher_Type = $this->db->query("SELECT CONCAT('-', '".$chi_result->row('VALUE_UNIT')."', ' => ', '".$chi_result->row('ITEMCODE')."', ' => ', '".addslashes($chi_result->row('DESCRIPTION'))."') as data")->row('data');
                $value_result = -number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
                $title = 'Point Adjust-OUT';
            }
            elseif($condition == 'ITEM_REDEEM')
            {
               $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '0' and enable = 1 ");
                $total = ($mem_result->row('Pointsbalance')) - ($uuid->row('VALUE_TOTAL'));
                $Point_Balance = $total;
                $Point_Adjust = -number_format(($uuid->row('VALUE_TOTAL')), 2, '.', '');
                $Point_Before = $mem_result->row('Pointsbalance');
                $Voucher_Type = $this->db->query("SELECT CONCAT('-', '".$chi_result->row('VALUE_UNIT')."', ' => ', '".$chi_result->row('ITEMCODE')."', ' => ', '".addslashes($chi_result->row('DESCRIPTION'))."') as data")->row('data');
                $value_result = -number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
                $title = 'Item Redemption';
            }

            if($result->row('POSTED') == '1')
            {
                $total = $chi_result->row('VALUE_UNIT') * $chi_result->row('QTY');
                $movement = $this->db->query("SELECT * from points_movement where PeriodCode = '".$result->row('REF_NO')."' and AccountNo = '".$result->row('SUP_CODE')."' ");
                $Point_Before = $movement->row('PointsBF');
                $Point_Adjust = $total;
                $Point_Balance = $movement->row('Pointsbalance');
            };

            /*if($_SESSION['title'] == 'Point Adjust-IN')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $value_result = number_format($VALUE_TOTAL, 2, '.', '');
            }
            elseif($_SESSION['title'] == 'Point Adjust-OUT')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $value_result = -number_format($VALUE_TOTAL, 2, '.', '');
            }
            elseif($_SESSION['title'] == 'Voucher Redemption')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '1' and enable = 1 ");
                $value_result = -number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
            }
            elseif($_SESSION['title'] == 'Item Redemption')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '0' and enable = 1 ");
                $value_result = -number_format($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'), 2, '.', '');
            }*/

            $data = array(
                // 'branch' =>$this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),
                'branch' => $this->branch(),
                'guid' => $guid,
                'trans_child' => $this->db->query("SELECT * from trans_child where TRANS_GUID = '$guid' "),
                'action' => site_url('Point_c/update?guid=' .$guid. '&chi_guid=' .$chi_guid.'&column=' .$condition),
                'button' => 'Update',
                'title' => $title,
                'column' => $condition,
                'select_reason' => $this->db->query("SELECT * FROM set_reason a"),
                'Reference' => $result->row('REF_NO'),
                'Code' => $result->row('SUP_CODE'),
                'Cardno' => $result->row('cardno'),
                'Date' => $result->row('TRANS_DATE'),
                'post' => $result->row('POSTED'),
                'Remarks' => $result->row('REMARK'),
                'branch_result' => $this->db->query("SELECT CONCAT('".$branch_name."', ' (', '".$result->row('branch')."', ')') as data ")->row('data'),
                'Name' => $result->row('SUP_NAME'),
                'Point_Before' => $Point_Before,
                'Point_Adjust' => $Point_Adjust,
                'Point_Balance' => $Point_Balance,
                'voucher' => $voucher,
                'Voucher_Type' => $Voucher_Type,
                'Qty' => $chi_result->row('QTY'),
                'edit' => $_REQUEST['edit'],
                'reason' => $result->row('reason'),
                'value_total' => $value_result,
                'Voucher_No' => $this->db->query("SELECT cross_refno from trans_child where CHILD_GUID = '$chi_guid' ")->row('cross_refno'),
                'Voucher_No_Start' => $this->db->query("SELECT cross_refno from trans_child where CHILD_GUID = '$chi_guid' ")->row('cross_refno'),
                'Voucher_No_End' => '--',
                'customized_voucher_no' => $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no'),
                'check_digit' => $this->db->query("SELECT check_digit_voucher FROM set_parameter")->row('check_digit_voucher'),

                );
            $this->template->load('template' , 'point_adj_in_out' , $data);
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
            $guid = $_REQUEST['guid'];
            $chi_guid = $_REQUEST['chi_guid'];
            $condition = $_REQUEST['column'];
            $result = $this->db->query("SELECT * from trans_main where TRANS_GUID = '$guid' ");
            $Voucher_Type = $this->input->post('Voucher_Type');
            $Branch = $this->input->post('Branch');
            $split_Branch = explode('(', $Branch);
            $split_Branch2 = explode(')', $split_Branch[1]);
            $date = $this->db->query("SELECT NOW() AS date")->row('date');
            $REFNO = "";

            $data = array(
                'refno' => $this->input->post('Voucher_No'),
            );

            $get_refno = $this->Member_Model->query_call('Point_c', 'update', $data);

            if(isset($get_refno['refno'][0]['REFNO']))
            {
                $REFNO = $get_refno['refno'][0]['REFNO'];
            }

            // $REFNO = $this->db->query("SELECT REFNO FROM frontend.voucher_general WHERE REFNO = '".$this->input->post('Voucher_No')."'");

            // if($REFNO->num_rows() > 0 && $this->input->post('Voucher_No'))
            // {
            //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Voucher no. ' .$this->input->post('Voucher_No'). ' already exists, please try again<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            //     redirect("Point_c/edit_child?guid=" .$guid. "&chi_guid=" .$chi_guid. "&column=" .$condition. "&edit=2");
            // };

            if($get_refno['message'] != 'success')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Voucher no. ' .$this->input->post('Voucher_No'). ' already exists, please try again<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/edit_child?guid=" .$guid. "&chi_guid=" .$chi_guid. "&column=" .$condition. "&edit=2");
            }

            if($this->input->post('Point_Balance') < 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Point balance cannot be negative value<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/edit_child?guid=" .$guid. "&chi_guid=" .$chi_guid. "&column=" .$condition. "&edit=2");
            };

            //ori_log
            /*$ori = $this->db->query("SELECT * from backend_member.trans_main where TRANS_GUID = '$guid' ");
            $ori_REMARK = $ori->row('REMARK');
            $ori_branch = $ori->row('branch');*/
            //$ori_VALUE_TOTAL = $ori->row('VALUE_TOTAL');
            //ori_log

            if($condition == 'POINT_ADJ_OUT')
            {
                $after_abs = abs($this->input->post('value_total'));
                $output_value_total = -$after_abs;
            }
            else
            {
                $output_value_total = $this->input->post('value_total');
            }
        
            $data = array(
                'REMARK' => $this->input->post('Remarks'),
                'branch' => $split_Branch2[0],
                'VALUE_TOTAL' => $output_value_total,
                'UPDATED_AT' => $date,
                'UPDATED_BY' => $_SESSION['username'],

                );
            $this->db->where('TRANS_GUID', $guid);
            $this->db->update('trans_main', $data);

            //$date = $this->db->query("SELECT NOW() as curdate")->row('curdate');

            //upd_log
            /*$upd = $this->db->query("SELECT * from backend_member.trans_main where TRANS_GUID = '$guid' ");
            $upd_REMARK = $upd->row('REMARK');
            $upd_branch = $upd->row('branch');*/
            //$upd_VALUE_TOTAL = $upd->row('VALUE_TOTAL');
            //upd_log

            /*$field = array("REMARK", "branch");

            for ($x = 0; $x <= 1; $x++) 
            {
                switch (${'ori_'.$field[$x]}) 
                {
                    case ${'upd_'.$field[$x]}:
                        break;
                    default:
                        $data = array(
                            'Trans_type' => $_SESSION['title']. ' Main',
                            'AccountNo' => $this->input->post('Code'),
                            //'ReceiptNo' => $_SESSION['receipt_no'],
                            'field' => $field[$x],
                            'value_from' => ${'ori_'.$field[$x]},
                            'value_to' => ${'upd_'.$field[$x]},
                            //'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                            //'expiry_date_after' => addslashes($get_new_expiry_date),
                            'created_at' => $date,
                            'created_by' => $_SESSION['username'],
                            );
                        $this->db->insert('user_logs', $data);
                }
            }*/

            if($condition == 'POINT_ADJ_IN')
            {
                $split_voucher = explode('=>', $Voucher_Type);
                $QTY_FACTOR = '1';
                $VALUE_TOTAL = $this->input->post('total');
            }
            elseif($condition == 'POINT_ADJ_OUT')
            {
                $split_voucher = explode('=>', $Voucher_Type);
                $ex_voucher = explode('-', $split_voucher[0]);
                $split_voucher[0] = $ex_voucher[1];
                $QTY_FACTOR = '-1';
                $VALUE_TOTAL = -$this->input->post('total');
            }
            elseif($condition == 'POINT_REDEEM' || $condition == 'ITEM_REDEEM')
            {
                $split_voucher = explode('=>', $Voucher_Type);
                $ex_voucher = explode('-', $split_voucher[0]);
                $split_voucher[0] = $ex_voucher[1];
                $QTY_FACTOR = '1';
                $VALUE_TOTAL = -$this->input->post('total');
            }

            //ori_log
            /*$ori = $this->db->query("SELECT * from backend_member.trans_child where CHILD_GUID = '$chi_guid' ");
            $ori_ITEMCODE = $ori->row('ITEMCODE');
            $ori_DESCRIPTION = $ori->row('DESCRIPTION');
            $ori_Qty = $ori->row('Qty');
            $ori_Qty = $ori->row('VALUE_UNIT');
            $ori_Qty = $ori->row('VALUE_TOTAL');*/
            //ori_log

            $customized_voucher_no = $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no');

            if($customized_voucher_no == '1')
            {
                $refno_data = array(
                    'cross_refno' => $this->input->post('Voucher_No'),

                    );
                $this->db->where('CHILD_GUID', $chi_guid);
                $this->db->update('trans_child', $refno_data);
            }
            elseif($customized_voucher_no == '2')
            {
                $refno_data = array(
                    'cross_refno' => $this->input->post('Voucher_No_Start'),

                    );
                $this->db->where('CHILD_GUID', $chi_guid);
                $this->db->update('trans_child', $refno_data);
            };

            $info = array(
                'ITEMCODE' => trim($split_voucher[1]),
                'DESCRIPTION' => trim($split_voucher[2]),
                'QTY_FACTOR' => $QTY_FACTOR,
                'QTY' => $this->input->post('Qty'),
                'VALUE_UNIT' => number_format(($split_voucher[0]), 2, '.', ''),
                'VALUE_TOTAL' => $VALUE_TOTAL,
                'UPDATED_AT' => $date,
                'UPDATED_BY' => $_SESSION['username'],

                );
            $this->db->where('CHILD_GUID', $chi_guid);
            $this->db->update('trans_child', $info);

            //upd_log
            /*$upd = $this->db->query("SELECT * from backend_member.trans_child where CHILD_GUID = '$chi_guid' ");
            $upd_ITEMCODE = $upd->row('ITEMCODE');
            $upd_DESCRIPTION = $upd->row('DESCRIPTION');
            $upd_Qty = $upd->row('Qty');
            $upd_Qty = $upd->row('VALUE_UNIT');
            $upd_Qty = $upd->row('VALUE_TOTAL');*/
            //upd_log

            /*$field1 = array("ITEMCODE", "DESCRIPTION", "Qty", "VALUE_UNIT", "VALUE_TOTAL");

            for ($x = 0; $x <= 4; $x++) 
            {
                switch (${'ori_'.$field1[$x]}) 
                {
                    case ${'upd_'.$field1[$x]}:
                        break;
                    default:
                        $data = array(
                            'Trans_type' => $_SESSION['title']. ' Child',
                            'AccountNo' => $this->input->post('Code'),
                            //'ReceiptNo' => $_SESSION['receipt_no'],
                            'field' => $field1[$x],
                            'value_from' => ${'ori_'.$field1[$x]},
                            'value_to' => ${'upd_'.$field1[$x]},
                            //'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                            //'expiry_date_after' => addslashes($get_new_expiry_date),
                            'created_at' => $date,
                            'created_by' => $_SESSION['username'],
                            );
                        $this->db->insert('user_logs', $data);
                }
            }*/

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Update Record<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Point_c/add_voucher?condition=" .$condition. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);
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
            $guid = $_REQUEST['guid'];

            /*if(isset($_REQUEST['chi_guid']))
            {*/
                $table_guid = $_REQUEST['chi_guid'];
                $table = $_REQUEST['table'];
                $column = $_REQUEST['column'];
            /*}
            else
            {
                $table_guid = $_REQUEST['guid'];
                $table = $_REQUEST['table'];
                $column = $_REQUEST['column'];
            }*/
            
            $this->db->where($column, $table_guid);
            $this->db->delete($table);

            if($this->db->affected_rows() > 0)
            {
                $result = $this->db->query("SELECT * from trans_child where TRANS_GUID = '$guid' ");

                if($result->num_rows() == '0')
                {
                    $this->db->where('TRANS_GUID', $guid);
                    $this->db->delete('trans_main');
                    $_SESSION['jump'] = 'main'; 
                };
                
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Item Deleted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Delete Item<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            if(isset($_SESSION['jump']))
            {
                if(isset($_SESSION['item_redeem']))
                {
                    $condition = 'ITEM_REDEEM';
                };

                unset($_SESSION['jump']);
                redirect('Point_c?column=' .$condition);
            }
            else
            {
                redirect('Point_c/add_voucher?guid=' .$guid. '&accountno='.$_SESSION['accountno1'].'&condition=' .$condition);
            }
        }
        else
        {
            redirect('login_c');
        }
    }

    public function add_voucher()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $_REQUEST['guid'];
            $column = $_REQUEST['condition'];

            $VALUE_TOTAL = $this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data');

            if($column == 'POINT_ADJ_IN')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $value_result = number_format($VALUE_TOTAL, 2, '.', '');
                $title = 'Point Adjust-IN';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'ADJUSTMENT';");
            }
            elseif($column == 'POINT_ADJ_OUT')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'ADJUST' and enable = 1 ");
                $value_result = -number_format($VALUE_TOTAL, 2, '.', '');
                $title = 'Point Adjust-OUT';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'ADJUSTMENT';");
            }
            elseif($column == 'POINT_REDEEM')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '1' and enable = 1 ");
                $value_result = -number_format($VALUE_TOTAL, 2, '.', '');
                $title = 'Voucher Redemption';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'REDEMPTION';");
            }
            elseif($column == 'ITEM_REDEEM')
            {
                $voucher = $this->db->query("SELECT * from mem_item where ITEM_TYPE = 'REDEEM' and isVoucher = '0' and enable = 1 ");
                $value_result = -number_format($VALUE_TOTAL, 2, '.', '');
                $title = 'Item Redemption';
                $select_reason = $this->db->query("SELECT * FROM `set_reason` a WHERE a.`type` = 'REDEMPTION';");
            }

            $result = $this->db->query("SELECT * from trans_main where TRANS_GUID = '$guid' ");
            $mem_result = $this->db->query("SELECT * from member where AccountNo = '".$result->row('SUP_CODE')."' ");
            /*$VALUE_TOTAL = $this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data');*/
            // $branch_name = $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' AND branch_code = '".$result->row('branch')."' ORDER BY branch_code ASC")->row('branch_name');

            $data = array(
                'username' => $_SESSION['username'],
                'userpass' => $_SESSION['userpass'],
                'module_group_guid' => $_SESSION['module_group_guid'],
                'trans_guid' => $guid,
            );

            $branch_name = "";

            $get_branch_name = $this->Member_Model->query_call('Point_c', 'add_voucher', $data);

            if(isset($get_branch_name['branch_name']['0']['branch_name']))
            {
                $branch_name = $get_branch_name['branch_name']['0']['branch_name'];
            }

            $data = array(
                // 'branch' =>$this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),
                'branch' => $this->branch(),
                'guid' => $guid,
                'trans_child' => $this->db->query("SELECT * from trans_child where TRANS_GUID = '$guid' "),
                'action' => site_url('Point_c/create_point_adj_in_out?guid=' .$guid. '&accountno='.$_SESSION['accountno1'].'&condition=' .$column),
                'button' => 'Create',
                'title' => $title,
                'column' => $column,
                'select_reason' => $select_reason,
                'Reference' => $result->row('REF_NO'),
                'Code' => $result->row('SUP_CODE'),
                'Cardno' => $result->row('cardno'),
                'Date' => $result->row('TRANS_DATE'),
                'post' => '',
                'Remarks' => $result->row('REMARK'),
                'branch_result' => $this->db->query("SELECT CONCAT('".$branch_name."', ' (', '".$result->row('branch')."', ')') as data ")->row('data'),
                'Name' => $result->row('SUP_NAME'),
                'Point_Before' => $mem_result->row('Pointsbalance'),
                'Point_Adjust' => '0.00',
                'Point_Balance' => $mem_result->row('Pointsbalance'),
                'voucher' => $voucher,
                'Voucher_Type' => '',
                'Qty' => '1',
                'edit' => '1',
                'reason' => $result->row('reason'),
                'value_total' => $value_result,
                'Voucher_No' => '',
                'Voucher_No_Start' => '',
                'Voucher_No_End' => '',
                'customized_voucher_no' => $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no'),
                'check_digit' => $this->db->query("SELECT check_digit_voucher FROM set_parameter")->row('check_digit_voucher'),

                );
            $this->template->load('template' , 'point_adj_in_out' , $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function post()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $_REQUEST['guid'];
            $column = $_REQUEST['condition'];
            $datepicker = $this->input->post('datepicker');
            $str_PeriodCode = date("Y-m-d", strtotime($datepicker));
            $PeriodCode = $this->db->query("SELECT LEFT('$str_PeriodCode', 7) as data")->row('data');
            $month_now = $this->db->query("SELECT DATE_FORMAT(NOW(), '%Y-%m') as data")->row('data');
            $cardno = $this->input->post('cardno');
            $account_tac = $this->check_tac_for_redeem(array('cardno' => $cardno));

            $child_refno = $this->db->query("SELECT * from trans_child where TRANS_GUID = '$guid' ");
            $customized_voucher_no = $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no');
            // $check_vouche_general = $this->db->query("SELECT REFNO FROM frontend.voucher_general ");


            if($column == 'POINT_REDEEM' || $column == 'ITEM_REDEEM')
            {
                $tac = $this->input->post('tac');
                // $account_tac = $this->Point_Model->check_tac_for_redeem($cardno)->row('tac');

                if($tac != $account_tac)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Invalid IC No<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/add_voucher?condition=" .$column. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);
                }
            }

            if($column == 'POINT_ADJ_IN')
            {
                $title = 'Point Adjust-IN';
            }
            elseif($column == 'POINT_ADJ_OUT')
            {
                $title = 'Point Adjust-OUT';
            }
            elseif($column == 'POINT_REDEEM')
            {
                $title = 'Voucher Redemption';
            }
            elseif($column == 'ITEM_REDEEM')
            {
                $title = 'Item Redemption';
            }

            $data = array(
                'trans_guid' => $guid,
                'str_PeriodCode' => $str_PeriodCode,
                'title' => $title,
                'accountno' => $this->input->post('Code'),
                'ReferenceNo' => $this->input->post('Reference'),
                'username' => $_SESSION['username'],
            );

            $result = $this->Member_Model->query_call('Point_c', 'post', $data);

            if($result['message'] != 'success')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">'.$result['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/add_voucher?condition=" .$column. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);   
            }

            // if($column == 'POINT_REDEEM' && $customized_voucher_no == '1')
            // {
            //     foreach($child_refno->result() as $row => $value)
            //     {
            //         $voucherno[] =  $value->cross_refno;
            //     }
            
            //     if(count($voucherno) != count(array_unique($voucherno)))
            //     {
                    // $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Unable to post as there is a duplicate voucher no. within this reference no.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    // redirect("Point_c/add_voucher?condition=" .$column. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);
            //     };

            //     foreach($check_vouche_general->result() as $row => $check)
            //     {
            //         $result_refno[] =  $check->REFNO;
            //     }

            //     if(array_intersect($voucherno, $result_refno)) 
            //     {
            //         $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Voucher no. already exists in the system<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            //         redirect("Point_c/add_voucher?condition=" .$column. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);
            //     };
            // };

            if($PeriodCode == $month_now)
            {
                // $PointsBF = $this->db->query("SELECT Pointsbalance FROM points_movement WHERE AccountNo = '".$this->input->post('Code')."' AND PeriodCode = (SELECT DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m')) ")->row('Pointsbalance');
                // $PointsBF_row = $this->db->query("SELECT Pointsbalance FROM points_movement WHERE AccountNo = '".$this->input->post('Code')."' AND PeriodCode = (SELECT DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m')) ")->num_rows();

                /*if($PointsBF_row == 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Point movements of current account for last month does not exist<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Point_c/add_voucher?condition=" .$condition. "&guid=" .$guid);
                }*/

                // $Points = $this->db->query("SELECT SUM(Points) as total FROM frontend.posmain WHERE AccountNo = '".$this->input->post('Code')."' AND DATE_FORMAT(BizDate, '%Y-%m') = (SELECT DATE_FORMAT(NOW(), '%Y-%m')) ")->row('total');
                // $date = $this->db->query("SELECT NOW() AS date")->row('date');
                // //ori_log
                // $ori = $this->db->query("SELECT * from trans_main where TRANS_GUID = '$guid' ");
                // $ori_POSTED = $ori->row('POSTED');
                // //$ori_VALUE_TOTAL = $ori->row('VALUE_TOTAL');
                // //ori_log

                // if($column == 'POINT_ADJ_IN')
                // {
                //     $vt = $this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data');
                // }
                // else
                // {
                //     $vt_abs = abs($this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'));
                //     $vt = -$vt_abs;
                // }

                // $infomation = array(
                //     'posted' => '1',
                // );

                // $this->db->where('TRANS_GUID', $guid);
                // $this->db->update('trans_child', $infomation);

                // $infomation = array(
                //     'POSTED' => '1',
                //     'VALUE_TOTAL' => $vt,
                //     'UPDATED_AT' => $this->db->query("SELECT NOW() AS date")->row('date'),
                //     'UPDATED_BY' => $_SESSION['username'],
                    
                //     );
                // $this->db->where('TRANS_GUID', $guid);
                // $this->db->update('trans_main', $infomation);

                // //upd_log
                // $upd = $this->db->query("SELECT * from trans_main where TRANS_GUID = '$guid' ");
                // $upd_POSTED = $upd->row('POSTED');
                // //$upd_VALUE_TOTAL = $upd->row('VALUE_TOTAL');
                // //upd_log

                // //$field = array("POSTED", "VALUE_TOTAL");

                // for ($x = 0; $x <= 1; $x++) 
                // {
                //     switch ($ori_POSTED)
                //     {
                //         case $upd_POSTED:
                //             break;
                //         default:
                //             $data = array(
                //                 'Trans_type' => $title,
                //                 'AccountNo' => $this->input->post('Code'),
                //                 'ReferenceNo' => $this->input->post('Reference'),
                //                 'field' => 'POSTED',
                //                 'value_from' => $ori_POSTED,
                //                 'value_to' => $upd_POSTED,
                //                 //'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                //                 //'expiry_date_after' => addslashes($get_new_expiry_date),
                //                 'created_at' => $date,
                //                 'created_by' => $_SESSION['username'],
                //                 );
                //             $this->db->insert('user_logs', $data);
                //     }
                // //}

                // if($this->db->affected_rows() > 0)
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Post Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                // }
                // else
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Post Record<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                // }

                // $PointsAdjIn = $this->db->query("SELECT SUM(VALUE_TOTAL) AS total FROM trans_main WHERE SUP_CODE = '".$this->input->post('Code')."' AND DATE_FORMAT(TRANS_DATE, '%Y-%m') = (SELECT DATE_FORMAT(NOW(), '%Y-%m')) AND POSTED = '1' AND trans_type = 'POINT_ADJ_IN' ")->row('total');
                // $PointsAdjOut = $this->db->query("SELECT SUM(VALUE_TOTAL) AS total FROM trans_main WHERE SUP_CODE = '".$this->input->post('Code')."' AND DATE_FORMAT(TRANS_DATE, '%Y-%m') = (SELECT DATE_FORMAT(NOW(), '%Y-%m')) AND POSTED = '1' AND trans_type = 'POINT_ADJ_OUT' ")->row('total');
                // $PointsUsed = $this->db->query("SELECT SUM(VALUE_TOTAL) AS total FROM trans_main WHERE SUP_CODE = '".$this->input->post('Code')."' AND DATE_FORMAT(TRANS_DATE, '%Y-%m') = (SELECT DATE_FORMAT(NOW(), '%Y-%m')) AND POSTED = '1' AND trans_type = 'POINT_REDEEM' ")->row('total');

                // if($column == 'POINT_ADJ_OUT')
                // {
                //     $PointsAdj = -($this->db->query("SELECT SUM(VALUE_TOTAL) AS total FROM trans_main WHERE SUP_CODE = '".$this->input->post('Code')."' AND DATE_FORMAT(TRANS_DATE, '%Y-%m') = (SELECT DATE_FORMAT(NOW(), '%Y-%m')) AND POSTED = '1' AND (trans_type = 'POINT_ADJ_IN' OR trans_type = 'POINT_ADJ_OUT') ")->row('total'));
                // };
        /*echo var_dump($PointsAdj);die;*/
                // if($PointsBF == NULL)
                // {
                //     $PointsBF = '0';
                // };

                // if($Points == NULL)
                // {
                //     $Points = '0';
                // };
                
                // if($PointsAdjIn == NULL)
                // {
                //     $PointsAdjIn = '0';
                // };

                // if($PointsAdjOut == NULL)
                // {
                //     $PointsAdjOut = '0';
                // };

                // if($PointsUsed == NULL)
                // {
                //     $PointsUsed ='0';
                // };

                // $PointsAdj = $PointsAdjIn + $PointsAdjOut;

                // if($PointsAdj == NULL)
                // {
                //     $PointsAdj ='0';
                // };

                // $Pointsbalance = $PointsBF + $Points + $PointsAdj + $PointsUsed;

                // $info = array(
                //     'PeriodCode' => $PeriodCode,
                //     'AccountNo' => $this->input->post('Code'),
                //     'PointsBF' => $PointsBF,
                //     'Points' => $Points,
                //     'PointsAdj' => $PointsAdj,
                //     'PointsUsed' => $PointsUsed,
                //     'Pointsbalance' => $Pointsbalance,
                //     'Created_at' => $this->db->query("SELECT NOW() AS date")->row('date'),
                    
                //     );
                // $this->db->replace('points_movement', $info);

                // $Code = $this->input->post('Code');

                //ori_log
                // $ori = $this->db->query("SELECT * from backend_member.member where AccountNo = '$Code' ");
                // $ori_PointsAdj = $ori->row('PointsAdj');
                // $ori_Pointsused = $ori->row('Pointsused');
                // $ori_Pointsbalance = $ori->row('Pointsbalance');
                //ori_log

                /*if($_SESSION['title'] == 'Item Redemption')
                {
                    $Pointsused = $this->db->query("SELECT Pointsused from member where AccountNo = '$Code' ")->row('Pointsused');
                    $total = $Pointsused + ($this->input->post('value_total'));

                    $data = array(
                        'PointsBF' => '',
                        'Points' => '',
                        'Pointsused' => $total,
                        'Pointsbalance' => $this->input->post('Point_Balance'),
                        
                        );
                }
                else*/if($column == 'POINT_REDEEM' && $customized_voucher_no != 2)
                {
                    $insert_voucher_general = $this->db->query("SELECT * FROM trans_child a INNER JOIN mem_item b ON a.ITEMCODE = b.ITEM_CODE WHERE TRANS_GUID = '$guid' ");

                    foreach($insert_voucher_general->result() as $row => $value)
                    {
                        for ($x = 1; $x <= $value->QTY; $x++) 
                        {
                            $voucher_valid_in_days = $this->db->query("SELECT voucher_valid_in_days from set_parameter ")->row('voucher_valid_in_days');
                            $sysrun = $this->db->query("SELECT * from set_sysrun where TRANS_TYPE = 'VOUCHER_NO' ");
                            $pad = $this->db->query("SELECT CONCAT(REPLACE(CURDATE(), '-', ''), LPAD('".$sysrun->row('REF_RUNNINGNO')."', '".$sysrun->row('REF_DIGIT')."', '0')) AS pad")->row('pad');
                            $check_digit = $this->db->query("SELECT check_digit_voucher from set_parameter")->row('check_digit_voucher');

                            $customized_voucher_no = $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no');

                            if($customized_voucher_no == '0')
                            {
                                if($check_digit == '1')
                                {
                                    $final_pad = $this->db->query("SELECT CONCAT('$pad', RIGHT(10-MOD(MID('$pad', 1, 1) + MID('$pad', 3, 1) + MID('$pad', 5, 1) + MID('$pad', 7, 1) + MID('$pad', 9, 1) + MID('$pad', 11, 1) + ((MID('$pad', 2, 1) + MID('$pad', 4, 1) + MID('$pad', 6, 1) + MID('$pad', 8, 1) + MID('$pad', 10, 1) + MID('$pad', 12, 1))*3), 10), 1)) AS check_digit ")->row('check_digit');
                                }
                                else
                                {
                                    $final_pad = $pad;
                                }
                            }
                            else
                            {
                                $final_pad = $value->cross_refno;
                            }

                            $date = $this->db->query("SELECT NOW() AS date")->row('date');

                            $info = array(
                                'REFNO' => $final_pad,
                                'VOUCHER_TYPE' => 'COMP.VOUCHER',
                                'REMARK' => '',
                                'AMOUNT' => $value->PRICE,
                                'VALID_FROM' => $this->db->query("SELECT CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d') , ' ', '00:00:00') AS date ")->row('date'),
                                'VALID_TO' => $this->db->query("SELECT CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d') + INTERVAL '$voucher_valid_in_days' DAY, ' ', '00:00:00') AS date ")->row('date'),
                                'CREATED_AT' => $date,
                                'CREATED_BY' => $_SESSION['username'],
                                'CREATED_POSREF' => '',
                                'UPDATED_AT' => $date,
                                'UPDATED_BY' => $_SESSION['username'],
                                'R_YEAR' => '0',
                                'R_MONTH' => '0',
                                'CLOSED_POSREF' => '',
                                'CLOSED_BY' => '',
                                'CLOSED_REMARK' => '',
                                'hq_update' => '0',
                                'link_guid' => '',
                                'activated' => '1',
                                'activated_at' => $date,
                                'activated_by' => $_SESSION['username'],

                                );
                            // $this->db->insert('frontend.voucher_general', $info);

                            $insert_voucher_general = $this->Member_Model->query_call('Point_c', 'post_tmp', $info);

                            // if($this->db->affected_rows() > 0)
                            if($insert_voucher_general['message'] == 'success')
                            {
                                $infomation = array(
                                    'REF_RUNNINGNO' => $sysrun->row('REF_RUNNINGNO') + 1,

                                );
                                $this->db->where('TRANS_TYPE', 'VOUCHER_NO');
                                $this->db->update('set_sysrun', $infomation);

                                $infos = array(
                                    'cross_refno' => $final_pad,
                                );
                                $this->db->where('CHILD_GUID', $value->CHILD_GUID);
                                $this->db->update('trans_child', $infos);
                            };
                        }
                    }

                    /*$Pointsused = $this->db->query("SELECT Pointsused from member where AccountNo = '$Code' ")->row('Pointsused');
                    $total = $Pointsused + ($this->input->post('value_total'));

                    $data = array(
                        'Pointsused' => $total,
                        'Pointsbalance' => $this->input->post('Point_Balance'),
                        
                        );*/
                }
                else
                {
                    $active_update = array(
                        'UPDATED_AT' => $date,
                        'UPDATED_BY' => $_SESSION['username'],
                        // 'update_hq' => 0,
                        // 'hq_update' => 0,
                        // 'activated' => 1,
                        'activated_at' => $date,
                        'activated_by' => $_SESSION['username'],
                    );

                    foreach($child_refno->result() as $row => $value)
                    {
                        $active_update['REFNO'] = $value->cross_refno;
                        // $this->db->where('REFNO', $value->cross_refno);
                        // $this->db->update('frontend.voucher_general', $active_update);

                        $this->Member_Model->query_call('Point_c', 'post_tmp1', $active_update);
                    }

                   

                }
                /*else
                {
                    $PointsAdj = $this->db->query("SELECT PointsAdj from member where AccountNo = '$Code' ")->row('PointsAdj');
                    $total = $PointsAdj + ($this->input->post('value_total'));

                    $data = array(
                        'PointsAdj' => $total,
                        'Pointsbalance' => $this->input->post('Point_Balance'),
                        
                        );
                }*/

                // $points_movement_result = $this->db->query("SELECT * FROM points_movement WHERE PeriodCode = (SELECT DATE_FORMAT(NOW(), '%Y-%m')) AND AccountNo = '$Code' ");

                // $data = array(
                //     'PointsBF' => $points_movement_result->row('PointsBF'),
                //     'Points' => $points_movement_result->row('Points'),
                //     'PointsAdj' => $points_movement_result->row('PointsAdj'),
                //     'Pointsused' => $points_movement_result->row('PointsUsed'),
                //     'Pointsbalance' => $points_movement_result->row('Pointsbalance'),
                    
                //     );

                // $this->db->where('AccountNo', $Code);
                // $this->db->update('member', $data);

                //upd_log
                // $upd = $this->db->query("SELECT * from backend_member.member where AccountNo = '$Code' ");
                // $upd_PointsAdj = $upd->row('PointsAdj');
                // $upd_Pointsused = $upd->row('Pointsused');
                // $upd_Pointsbalance = $upd->row('Pointsbalance');
                //upd_log

                // $field = array("PointsAdj", "Pointsused", "Pointsbalance");

                // for ($x = 0; $x <= 2; $x++) 
                // {
                //     switch (${'ori_'.$field[$x]}) 
                //     {
                //         case ${'upd_'.$field[$x]}:
                //             break;
                //         default:
                //             $data = array(
                //                 'Trans_type' => $title,
                //                 'AccountNo' => $this->input->post('Code'),
                //                 'ReferenceNo' => $this->input->post('Reference'),
                //                 'field' => $field[$x],
                //                 'value_from' => ${'ori_'.$field[$x]},
                //                 'value_to' => ${'upd_'.$field[$x]},
                //                 //'expiry_date_before' => addslashes($this->input->post('expiry_date')),
                //                 //'expiry_date_after' => addslashes($get_new_expiry_date),
                //                 'created_at' => $date,
                //                 'created_by' => $_SESSION['username'],
                //                 );
                //             $this->db->insert('user_logs', $data);
                //     }
                // }

                // if($this->db->affected_rows() > 0)
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Post Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                // }
                // else
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Post Record<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                // }

                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Post Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                $this->recalc_point(array('accountno' => $this->input->post('Code')));

                redirect("Point_c/edit_main?guid=" .$guid. '&column=' .$column. '&edit=3');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Date Has Expired To Post<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/add_voucher?condition=" .$column. "&accountno=".$_SESSION['accountno1']."&guid=" .$guid);
            }    
        }
        else
        {
            redirect('login_c');
        }
    }

    public function print_report()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $_REQUEST['guid'];
            $column = $_REQUEST['column'];
            $main = $this->db->query("SELECT * from trans_main where TRANS_GUID = '".$_REQUEST['guid']."' ");
            $child = $this->db->query("SELECT * from trans_child where TRANS_GUID = '".$_REQUEST['guid']."' ");
            $date = $main->row('TRANS_DATE');
            $datetime = $main->row('UPDATED_AT');
            $UPDATED_AT = date("d/m/Y h:i a", strtotime($datetime));
            $TRANS_DATE = date("d/m/Y", strtotime($date));

            if($column == 'POINT_ADJ_IN')
            {
                $sub_title = 'POINT ADJUSTMENT IN';
                $form = 'Point Adjustment Form';
                $text = 'adjust';
                $Point_after = number_format($main->row('point_curr') + $main->row('VALUE_TOTAL'), 2, '.', '');
            }
            elseif($column == 'POINT_ADJ_OUT')
            {
                $sub_title = 'POINT ADJUSTMENT OUT';
                $form = 'Point Adjustment Form';
                $text = 'adjust';
                $Point_after = number_format($main->row('point_curr') + $main->row('VALUE_TOTAL'), 2, '.', '');
            }
            elseif($column == 'POINT_REDEEM' || $column == 'ITEM_REDEEM' || $column == 'REDEEM_CASH')
            {
                $sub_title = 'POINT REDEMPTION';
                $form = 'Point Redemption Form';
                $text = 'redeem';
                $Point_after = number_format($main->row('point_curr') + $main->row('VALUE_TOTAL'), 2, '.', '');
            }

            $result = $this->Member_Model->query_call('Point_c', 'print_report');

            $data = array(
                // 'title' => $this->db->query("SELECT CompanyName from backend.companyprofile")->row('CompanyName'),
                'title' => $result['companyname'][0]['CompanyName'],
                'sub_title' => $sub_title,
                'form' => $form,
                'Points' => $this->db->query("SELECT Points from member where AccountNo = '".$this->input->post('Code')."' ")->row('Points'),
                'REF_NO' => $main->row('REF_NO'),
                'username' => $_SESSION['username'],
                'TRANS_DATE' => $TRANS_DATE,
                'UPDATED_AT' => $UPDATED_AT,
                'SUP_NAME' => $main->row('SUP_NAME'),
                'SUP_CODE' => $main->row('SUP_CODE'),
                'Cardno' => $main->row('cardno'),
                'child' => $child,
                'text' => $text,
                'Point_before' => number_format($main->row('point_curr') + $main->row('VALUE_TOTAL'), 2, '.', ''),
                'Point_after' => number_format($main->row('point_curr') + $main->row('VALUE_TOTAL'), 2, '.', ''),
                'REMARK' => $main->row('REMARK'),
                'sum_qty' => $this->db->query("SELECT SUM(QTY) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'),
                'sum_total' => $this->db->query("SELECT SUM(VALUE_TOTAL) as data from trans_child where TRANS_GUID = '$guid' ")->row('data'),
                'cross_refno' => $child->row('cross_refno'),

                );
            $report_potrait = $this->db->query("SELECT report_potrait from set_parameter ")->row('report_potrait');

            if($report_potrait == 1)
            {
                $this->load->view('print_report_potrait', $data);
            }
            else
            {
                $this->load->view('print_report', $data);
            }
        }
        else
        {
            redirect('login_c');
        }
    }

    public function print_voucher()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $guid = $_REQUEST['guid'];
            $result = $this->db->query("SELECT a.QTY, c.*, b.PRICE FROM trans_child a INNER JOIN mem_item b ON a.ITEMCODE = b.ITEM_CODE INNER JOIN trans_main c ON a.trans_guid = c.trans_guid WHERE a.TRANS_GUID = '".$_REQUEST['guid']."' AND b.isVoucher = '1' ");
            // $result = $this->db->query("SELECT a.SUP_CODE,a.SUP_NAME, b.QTY, b.UPDATED_AT,b.UPDATED_BY, c.VALID_TO, c.REFNO, c.AMOUNT FROM trans_main a INNER JOIN trans_child b ON a.TRANS_GUID = b.TRANS_GUID INNER JOIN frontend.voucher_general c ON b.cross_refno = c.REFNO WHERE a.TRANS_GUID = '".$_REQUEST['guid']."' ");
            // $member = $this->db->query("SELECT * from member where AccountNo = '".$result->row('SUP_CODE')."' ");
            $template = $this->db->query("SELECT title from voucher_template where type = 'preset' and output = '1' ")->row('title');
            $row_num = $result->num_rows();
            $title = $this->db->query("SELECT output from voucher_template where title = '".$template."' and type = 'logo' ")->row('output');

            $data = array(
                'trans_guid' => $_REQUEST['guid'],
            );

            $result = $this->Member_Model->query_call('Point_c', 'print_voucher', $data);

            /*if($logo_active == 1)
            {
                $title = $this->db->query("SELECT output from voucher_template where title = 'logo' and type = 'path' ")->row('output');
            }
            else
            {
                $title = $this->db->query("SELECT CompanyName from backend.companyprofile")->row('CompanyName')
            }*/

            $data = array(
                'result' => $result['result'],
                'row_num' => $result['num_rows'][0]['num_rows'],
                'title' => $title,
                // 'company_profile' => $this->db->query("SELECT CompanyName from backend.companyprofile")->row('CompanyName'),
                'company_profile' => $result['companyname']['0']['CompanyName'],
                'logo' => $this->db->query("SELECT output from voucher_template where title = 'logo' and type = 'path' ")->row('output'),
                'expiry' => '2017-01-01',
                't_c' => $this->db->query("SELECT output from voucher_template where title = '".$template."' and type = 't&c' ")->row('output'),
                'prefix' => $this->db->query("SELECT output from voucher_template where title = '".$template."' and type = 'prefix' ")->row('output'),
                'width' => $this->db->query("SELECT output from voucher_template where title = '".$template."' and type = 'width' ")->row('output'),
                'height' => $this->db->query("SELECT output from voucher_template where title = '".$template."' and type = 'height' ")->row('output'),
                'ic' => $result['member']['0']['ICNo'],
                'point_balance' => $result['member']['0']['Pointsbalance'], 
                'logo_width' => $this->db->query("SELECT output from voucher_template where title = 'logo' and type = 'width' ")->row('output'),
                'logo_height' => $this->db->query("SELECT output from voucher_template where title = 'logo' and type = 'height' ")->row('output'),
                
            );

            /*if($template == 'template2')
            {
                $this->load->view('print_voucher2', $data);
            }
            else
            {*/
                $this->load->view('print_voucher', $data);
            /*}*/
        }
        else
        {
            redirect('login_c');
        }
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

    public function point_adj_in()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $this->template->load('template' , 'point_adj_in');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function point_adj_out()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $this->template->load('template' , 'point_adj_out');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function point_promotion()
    {
        $query_card_type = $this->db->query("SELECT * FROM `cardtype` a ;");
        $query_transaction = $this->db->query("SELECT * FROM `set_promo_point_as_payment` a ;");
        $query_current_active = $this->db->query("SELECT * FROM `set_promo_point_as_payment` a WHERE a.`time_from` < CURTIME() AND a.`time_to` > CURTIME() AND CURDATE() BETWEEN a.`date_from` AND a.`date_to` AND a.`set_active` = 1 ORDER BY a.`updated_at` DESC LIMIT 1;")->row('point_guid');
        $data = array(
                'trans_main' => $query_transaction,
                'card_type' => $query_card_type,
                'current_active' => $query_current_active,
                'title' => 'Promotion Point Setup',
                'column' => 'Point Promotion',
                );
        $this->template->load('template' , 'promotion_point_setup', $data);
    }

    public function point_promotion_form()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $this->input->post('guid');
            $check_exist = $this->db->query("SELECT * FROM `set_promo_point_as_payment` a WHERE a.`point_guid` = '$guid' ");

            $daterange = explode(' - ', $this->input->post('daterange'));
            $datefrom = date('Y-m-d',strtotime($daterange[0]));
            $dateto = date('Y-m-d',strtotime($daterange[1]));

            if($check_exist->num_rows() == 0)//add process
            {
                $process = "Create";
                $data = array(
                    'point_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid'),   
                    'type' => $this->input->post('type'),
                    'description' => $this->input->post('description'),  
                    'point_total' => $this->input->post('point_total'),  
                    'point_disc' => $this->input->post('point_disc'),   
                    'created_at' => $this->db->query("SELECT NOW() as updated_at")->row('updated_at'),   
                    'created_by' => $_SESSION['username'],   
                    'updated_at' => $this->db->query("SELECT NOW() as updated_at")->row('updated_at'),   
                    'updated_by' => $_SESSION['username'],   
                    'cardtype' => $this->input->post('cardtype'),     
                    'set_active' => $this->input->post('set_active'),   
                    'date_from' => $datefrom,    
                    'date_to' => $dateto,      
                    'time_from' => $this->input->post('timefrom'),    
                    'time_to' => $this->input->post('timeto'),  
                );

                $this->db->insert("set_promo_point_as_payment",$data);
            }
            else// edit process
            {
                $process = "Update";
                $data = array(  
                    'description' => $this->input->post('description'),  
                    'type' => $this->input->post('type'),
                    'point_total' => $this->input->post('point_total'),  
                    'point_disc' => $this->input->post('point_disc'),      
                    'updated_at' => $this->db->query("SELECT NOW() as updated_at")->row('updated_at'),   
                    'updated_by' => $_SESSION['username'],   
                    'cardtype' => $this->input->post('cardtype'),     
                    'set_active' => $this->input->post('set_active'),   
                    'date_from' => $datefrom,    
                    'date_to' => $dateto,      
                    'time_from' => $this->input->post('timefrom'),    
                    'time_to' => $this->input->post('timeto'),  
                );
                $this->db->where("point_guid", $guid);
                $this->db->update("set_promo_point_as_payment", $data);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful '.$process.'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/point_promotion");
        }
        else
        {
            redirect('login_c');
        }
    }


    public function point_rules()
    {
        $query_point_rules = $this->db->query("SELECT * FROM `set_point_rules` a;");
        $query_current_active = $this->db->query("SELECT * FROM `set_point_rules` a WHERE a.`time_from` < CURTIME() AND a.`time_to` > CURTIME() AND CURDATE() BETWEEN a.`date_from` AND a.`date_to` AND a.`set_active` = 1 ORDER BY a.`updated_at` desc LIMIT 1;")->row('point_guid');
        $data = array(
                'amount_limit' => $this->check_parameter()->row('counter_redeem_amt_limit'),
                'preset_amount' => $this->check_parameter()->row('counter_redeem_interval_seq'),
                'trans_main' => $query_point_rules,
                'current_active' => $query_current_active,
                'title' => 'Point Rules Setup',
                'column' => 'Point Rules',

                );
        $this->template->load('template' , 'point_rules_setup', $data);
    }


    public function point_rules_form()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $this->input->post('guid');
            $check_exist = $this->db->query("SELECT * FROM `set_point_rules` a WHERE a.`point_guid` = '$guid' ");

            $daterange = explode(' - ', $this->input->post('daterange'));
            $datefrom = date('Y-m-d',strtotime($daterange[0]));
            $dateto = date('Y-m-d',strtotime($daterange[1]));

            if($check_exist->num_rows() == 0)//add process
            {
                $process = "Create";
                $data = array(
                    'point_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid'),   
                    'description' => $this->input->post('description'),  
                    'amount' => $this->input->post('amount'),  
                    'point' => $this->input->post('point'),   
                    'created_at' => $this->db->query("SELECT NOW() as updated_at")->row('updated_at'),   
                    'created_by' => $_SESSION['username'],   
                    'updated_at' => $this->db->query("SELECT NOW() as updated_at")->row('updated_at'),   
                    'updated_by' => $_SESSION['username'],        
                    'set_active' => $this->input->post('set_active'),   
                    'date_from' => $datefrom,    
                    'date_to' => $dateto,      
                    'time_from' => $this->input->post('timefrom'),    
                    'time_to' => $this->input->post('timeto'),  
                );

                $this->db->insert("set_point_rules",$data);
            }
            else// edit process
            {
                $process = "Update";
                $data = array(  
                    'description' => $this->input->post('description'),  
                    'amount' => $this->input->post('amount'),  
                    'point' => $this->input->post('point'),     
                    'updated_at' => $this->db->query("SELECT NOW() as updated_at")->row('updated_at'),   
                    'updated_by' => $_SESSION['username'],    
                    'set_active' => $this->input->post('set_active'),   
                    'date_from' => $datefrom,    
                    'date_to' => $dateto,      
                    'time_from' => $this->input->post('timefrom'),    
                    'time_to' => $this->input->post('timeto'),  
                );
                $this->db->where("point_guid", $guid);
                $this->db->update("set_point_rules", $data);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful '.$process.'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/point_rules");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function amount_limit_form()
    {
        $data = array(

            'counter_redeem_amt_limit' => $this->input->post('amount_limit'),
            'counter_redeem_interval_seq' => $this->input->post('set_active')
        );

        $this->db->update("set_parameter",$data);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/point_rules");
    }

    public function auto_point_adjustment()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $query_auto_point = $this->db->query("SELECT * FROM `auto_point_adjustment` a;");
            $current_active = $this->db->query("SELECT * FROM (
            /*if it is by annually, check specific month and date and time_from and time_to */
            SELECT '1' AS sort, a.* FROM `auto_point_adjustment` AS a 
            WHERE schedule_type = 'Annually'
            AND RIGHT(`date`,5) = DATE_FORMAT(CURDATE() , '%m-%d')
            AND time_from <= CURTIME() 
            AND time_to >= CURTIME()
            AND  set_active = '1'

            UNION ALL 

            /*if it is by monthly, check date and time_from and time_to */
            SELECT '2' AS sort, a.* FROM `auto_point_adjustment`  AS a
            WHERE schedule_type = 'Monthly'
            AND RIGHT(`date`,2) = DATE_FORMAT(CURDATE() , '%d')
            AND time_from <= CURTIME() 
            AND time_to >= CURTIME()
            AND  set_active = '1'

            UNION ALL

            /*if it is by weekly, check dayname*/
            SELECT '3' AS sort, a.* FROM `auto_point_adjustment`  AS a
            WHERE schedule_type = 'Weekly'
            AND day = DAYNAME(CURDATE())
            AND time_from <= CURTIME() 
            AND time_to >= CURTIME()
            AND  set_active = '1'

            UNION ALL

            /*if it is by hourly, check time_from_time_to*/
            SELECT '4' AS sort, a.* FROM `auto_point_adjustment`  AS a
            WHERE schedule_type = 'Hourly'
            AND time_from <= CURTIME() 
            AND time_to >= CURTIME()
            AND  set_active = '1'
            ) a
            ORDER BY sort DESC , updated_at DESC
            LIMIT 1")->row('point_guid');
          
            $data = array(
                    'trans_main' => $query_auto_point,
                    'current_active' => $current_active,
                    'title' => 'Auto Point Adjustment',
                    'column' => 'Point Rules',

                    );

            $this->template->load('template' , 'auto_point_adjustment', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    /*            */
        public function auto_point_adjustment_form()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $this->input->post('guid');
            $check_exist = $this->db->query("SELECT * FROM `auto_point_adjustment` a WHERE a.`point_guid` = '$guid' ");
 
            
            if($check_exist->num_rows() == 0)//add process
            {
                $process = "Create";
                $data = array(
                    'set_active' => $this->input->post('set_active'), 
                    'point_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid'),   
                    'description' => $this->input->post('description'),
                    'time_from' => $this->input->post('timefrom'),    
                    'time_to' => $this->input->post('timeto'),
                    'schedule_type' => $this->input->post('schedule_type'),
                    'date' => $this->input->post('date'),
                    'day' => $this->input->post('day'),
                    'type' => $this->input->post('type'),
                    'point' => $this->input->post('point'),   
                    'points_type' => $this->input->post('points_type'),
                    'points_addon' => $this->input->post('points_addon'),
                    'created_at' => $this->db->query("SELECT NOW() as updated_at")->row('updated_at'),   
                    'created_by' => $_SESSION['username'],   
                    'updated_at' => $this->db->query("SELECT NOW() as updated_at")->row('updated_at'),   
                    'updated_by' => $_SESSION['username'],                        
                );
               
                $this->db->insert("auto_point_adjustment",$data);
            }
            else// edit process
            {   
                $process = "Update";
                $data = array(  
                    'set_active' => $this->input->post('set_active'),
                    'description' => $this->input->post('description'),                     
                    'time_from' => $this->input->post('timefrom'),    
                    'time_to' => $this->input->post('timeto'),
                    'schedule_type' => $this->input->post('schedule_type'),
                    'date' => $this->input->post('date'),
                    'day' => $this->input->post('day'),
                    'type' => $this->input->post('type'),
                    'point' => $this->input->post('point'),   
                    'points_type' => $this->input->post('points_type'),
                    'points_addon' => $this->input->post('points_addon'),                   
                    'updated_at' => $this->db->query("SELECT NOW() as updated_at")->row('updated_at'),   
                    'updated_by' => $_SESSION['username'], 
                );

                //print_r($data);die;
                $this->db->where("point_guid", $guid);
                $this->db->update("auto_point_adjustment", $data);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful '.$process.'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/auto_point_adjustment");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function free_gift()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $this->template->load('template' , 'free_gift');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function free_gift_server_side()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $columns = array(
                0 => "refno",
                1 => "branch",
                2 => "doc_date",
                3 => "date_redemption_from",
                4 => "date_redemption_to",
                5 => "description",
                6 => "created_at",
                7 => "created_by",
                8 => "updated_at",
                9 => "updated_by",
                10 => "redemption",
            );

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalFiltered = $totalData = $this->db->query("SELECT COUNT(refno) AS num FROM coupon_batch")->row('num');

            if(empty($this->input->post('search')['value']))
            {
                $posts = $this->db->query("SELECT * FROM coupon_batch ORDER BY $order $dir LIMIT $start, $limit")->result();
            }
            else
            {
                $search = $this->input->post('search')['value'];
                $query = $this->db->query("SELECT * FROM coupon_batch WHERE refno LIKE '%$search%' OR branch LIKE '%$search%' OR doc_date LIKE '%$search%' OR description LIKE '%$search%' OR created_at LIKE '%$search%' OR created_by LIKE '%$search%' OR updated_at LIKE '%$search%' OR updated_by LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $limit");
                $posts = $query->result();
                $totalFiltered = $query->num_rows();
            }

            if(!empty($posts))
            {
                foreach ($posts as $post)
                {
                    $nestedData['refno'] = $post->refno;
                    $nestedData['branch'] = $post->branch;
                    $nestedData['doc_date'] = $post->doc_date;
                    $nestedData['description'] = $post->description;
                    $nestedData['created_at'] = $post->created_at;
                    $nestedData['created_by'] = $post->created_by;
                    $nestedData['updated_at'] = $post->updated_at;
                    $nestedData['updated_by'] = $post->updated_by;
                    $nestedData['date_redemption_from'] = $post->date_redemption_from;
                    $nestedData['date_redemption_to'] = $post->date_redemption_to;

                    $redemption = "<center>
                                    <a href='".site_url('Point_c/free_gift_redemption?guid='.$post->coupon_guid)."'>
                                        <button class='btn btn-warning btn-xs'>
                                            <i class='fa fa-gift'></i>
                                        </button>
                                    </a>";

                    if(in_array('EFG', $_SESSION['module_code']))
                    {
                        $redemption .= "<a href='".site_url('Point_c/edit_free_gift?guid='.$post->coupon_guid)."'>
                                    <button class='btn btn-primary btn-xs'>
                                        <i class='fa fa-pencil'></i>
                                    </button>
                                </a>";
                    }

                    $redemption .= "</center>";

                    $nestedData['redemption'] = $redemption;

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
        else
        {
            redirect('login_c');
        }
    }

    public function free_gift_redemption()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $coupon_batch = $this->db->query("SELECT * FROM coupon_batch WHERE coupon_guid = '".$_REQUEST['guid']."'"); 
            $branch_code = $coupon_batch->row('branch');

            $data = array(
                // 'branch' => $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = 4'".$_SESSION['module_group_guid']."' ORDER BY b.branch_code = '".$branch_code."' DESC, b.branch_code ASC"),
                'branch' => $this->branch(),
                'date_redemption_from' => $coupon_batch->row('date_redemption_from'),
                'date_redemption_to' => $coupon_batch->row('date_redemption_to'),
            );
            
            $this->template->load('template' , 'free_gift_redemption', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function gift_scan_card()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $branch = $this->input->post('branch');
            $cardno = addslashes($this->input->post('cardno'));
            $coupon_guid = $this->input->post('coupon_guid');

            $check_member = $this->db->query("
                SELECT AccountNo, CardNo, Name, Pointsbalance FROM member WHERE CardNo = '$cardno'
                UNION ALL
                SELECT b.AccountNo, b.SupCardNo AS CardNo, b.Name, a.Pointsbalance FROM member AS a
                INNER JOIN membersupcard AS b ON a.AccountNo = b.AccountNo WHERE b.SupCardNo = '$cardno'
            ");

            if($check_member->num_rows() > 0)
            {
                $accountno = $check_member->row('AccountNo');

                $check_lost_card = $this->db->query("SELECT LostCardNo FROM memberlostcard WHERE LostCardNo = '".$cardno."'");

                if($check_lost_card->num_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 16px">This Card Already Lost. Process Not Allowed!!!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Point_c/free_gift_redemption?guid='.$coupon_guid);
                }

                $check_coupon_batch_c = $this->db->query("SELECT * FROM coupon_batch_c WHERE accountno = '$accountno' AND canceled = '0' AND coupon_guid = '$coupon_guid'");

                if($check_coupon_batch_c->num_rows() == 0)
                {
                    $condition = $this->db->query("
                        SELECT * FROM coupon_batch AS a
                        INNER JOIN coupon_batch_query_varified AS b ON a.coupon_guid = b.coupon_guid
                        WHERE a.coupon_guid = '".$coupon_guid."' ORDER BY seq ASC
                    ");

                    $have_rec_msg = $no_rec_msg = $break = "";
                    if($condition->num_rows() > 0)
                    {
                        $this->db->query("SET @cardno = '$cardno'");
                        foreach($condition->result() as $cond)
                        {
                            if($break == "1")
                            {
                                break;
                            }


                            $check = $this->db->query($cond->query_data);

                            if($check->num_rows() > 0)
                            {
                                $have_rec_msg = $cond->have_rec_msg;

                                if($cond->have_rec_msg_abort == 1)
                                {
                                    $break = "1";
                                }
                            }
                            else
                            {
                                $no_rec_msg = $cond->no_rec_msg;

                                if($cond->no_rec_msg_abort == 1)
                                {
                                    $this->session->set_flashdata('cannot_redemption', $cannot_redemption);
                                    $break = "1";
                                }
                            }
                        }
                    }

                    $this->session->set_flashdata('free_gift_redemption_modal', 'show');
                    $this->session->set_flashdata('free_gift_redemption_cardno', $cardno);
                    $this->session->set_flashdata('free_gift_redemption_have_rec_msg', $have_rec_msg);
                    $this->session->set_flashdata('free_gift_redemption_no_rec_msg', $no_rec_msg);
                    $this->session->set_flashdata('free_gift_redemption_point', $check_member->row('Pointsbalance'));
                    $this->session->set_flashdata('free_gift_redemption_branch', $branch);
                    redirect('Point_c/free_gift_redemption?guid='.$coupon_guid);
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">This member already redemption.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Point_c/free_gift_redemption?guid='.$coupon_guid);
                }
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Invalid Card No<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Point_c/free_gift_redemption?guid='.$coupon_guid);
            }
        }
        else
        {
            redirect('login_c');
        }
    }

    public function submit_free_gift_redemption()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $cardno = $this->input->post('cardno');
            $coupon_guid = $this->input->post('coupon_guid');
            $tac = $this->input->post('tac');

            $account_tac = $this->Point_Model->check_tac_for_redeem($cardno)->row('tac');

            if($tac != $account_tac)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Invalid IC No.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/free_gift_redemption?guid=".$_REQUEST['guid']);
            }
            
            $member = $this->db->query("
                SELECT AccountNo, CardNo, Name, Pointsbalance FROM member WHERE CardNo = '$cardno'
                UNION ALL
                SELECT b.AccountNo, b.SupCardNo AS CardNo, b.Name, a.Pointsbalance FROM member AS a
                INNER JOIN membersupcard AS b ON a.AccountNo = b.AccountNo WHERE b.SupCardNo = '$cardno'
            ");

            $data = array(
                'detail_guid' => $this->db->query("SELECT UPPER(REPLACE(UUID(), '-', '')) as guid")->row('guid'),
                'coupon_guid' => $coupon_guid,
                'accountno' => $member->row('AccountNo'),
                'cardno' => $member->row('CardNo'),
                'name' => $member->row('Name'),
                'created_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                'updated_by' => $_SESSION['username'],
                'branch' => $this->input->post('branch'),
                'create_script' => '1',
            );

            $this->db->insert('coupon_batch_c', $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Success Redemption.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Fail redemption.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Point_c/free_gift_redemption?guid=".$_REQUEST['guid']);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function free_gift_redemption_list()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $columns = array(
               0 => "accountno",
               1 => "cardno",
               2 => "name",
               3 => "created_at",
               4 => "created_by",
               5 => "canceled",
               6 => "canceled_at",
               7 => "canceled_by",
               8 => "action",
            );

            $guid = $this->input->post('guid');
            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalFiltered = $totalData = $this->db->query("SELECT COUNT(detail_guid) AS num FROM coupon_batch_c WHERE coupon_guid = '$guid'")->row('num');

            if(empty($this->input->post('search')['value']))
            {
                $posts = $this->db->query("SELECT * FROM coupon_batch_c WHERE coupon_guid = '$guid' ORDER BY $order $dir LIMIT $start, $limit")->result_array();
            }
            else
            {
                $search = $this->input->post('search')['value'];
                $query = $this->db->query("SELECT * FROM coupon_batch_c WHERE coupon_guid = '$guid' AND (accountno LIKE '%$search%' OR cardno LIKE '%$search%' OR name LIKE '%$search%' OR created_at LIKE '%$search%' OR created_by LIKE '%$search%' OR canceled LIKE '%$search%' OR canceled_at LIKE '%$search%' OR canceled_by LIKE '%$search%') ORDER BY $order $dir LIMIT $start, $limit");
                $posts = $query->result_array();
                $totalFiltered = $query->num_rows();
            }

            if(!empty($posts))
            {
                foreach ($posts as $post)
                {
                    
                    $nestedData['accountno'] = $post['accountno'];
                    $nestedData['cardno'] = $post['cardno'];
                    $nestedData['name'] = $post['name'];
                    $nestedData['created_at'] = $post['created_at'];
                    $nestedData['created_by'] = $post['created_by'];

                    if($post['canceled'] == 1)
                    {
                        $cancel = '<i class="fa fa-check"></i>';
                        $action = "<button class='btn btn-danger btn-xs cancel_free_gift disabled' id='".$post['detail_guid']."' title='cancel'><i class='fa fa-close'></i></button>";
                    }
                    else
                    {
                        $cancel = '';
                        $action = "<button class='btn btn-danger btn-xs cancel_free_gift' id='".$post['detail_guid']."' data-guid='".$post['coupon_guid']."' title='cancel'><i class='fa fa-close'></i></button>";
                    }

                    $nestedData['canceled'] = $cancel;
                    $nestedData['canceled_at'] = $post['canceled_at'];
                    $nestedData['canceled_by'] = $post['canceled_by'];
                    $nestedData['action'] = $action;

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
        else
        {
            redirect('login_c');
        }
    }

    public function canceled()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $_REQUEST['guid'];
            $coupon_guid = $_REQUEST['coupon_guid'];

            $data = array(
                'canceled' => 1,
                'canceled_by' => $_SESSION['username'],
                'canceled_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
            );

            $this->db->where('detail_guid', $guid);
            $this->db->update('coupon_batch_c', $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Success cancel.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Fail cancel.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Point_c/free_gift_redemption?guid=".$coupon_guid);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function add_free_gift()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $data = array(
                // 'branch' => $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY b.branch_code ASC"),
                'branch' => $this->branch(),
                "action" => site_url('Point_c/submit_add_free_gift'),
            );

            $this->template->load('template' , 'free_gift_setup', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function submit_add_free_gift()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $description = $this->input->post('description');
            $branch = $this->input->post('branch');
            $doc_date = $this->input->post('doc_date');
            $remarks = $this->input->post('remarks');
            $guid = $this->guid();
            $date_redemption_from = $this->input->post('date_redemption_from');
            $date_redemption_to = $this->input->post('date_redemption_to');

            $data = array(
                "coupon_guid" => $guid,
                "refno" => $this->db->query("SELECT CONCAT('CPB', REPLACE(CURDATE(), '-', ''), IF(COUNT(refno) = 0, '0001', LPAD((RIGHT(refno, 4) + 1), 4, '0'))) AS refno FROM coupon_batch WHERE doc_date = CURDATE() ORDER BY created_at DESC LIMIT 1")->row("refno"),
                "branch" => $branch,
                "doc_date" => $doc_date,
                "description" => $description,
                "remarks" => $remarks,
                "created_at" => $this->datetime(),
                "created_by" => $_SESSION['username'],
                "updated_at" => $this->datetime(),
                "updated_by" => $_SESSION['username'],
                "locked" => "0",
                "locked_at" => $this->datetime(),
                "date_redemption_from" => $date_redemption_from,
                "date_redemption_to" => $date_redemption_to,
            );

            $this->db->insert("coupon_batch", $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Success add.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/edit_free_gift?guid=".$guid);
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Fail add.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Point_c/add_free_gift");
            }
            
        }
        else
        {
            redirect('login_c');
        }
    }

    public function edit_free_gift()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $coupon_guid = $_REQUEST['guid'];

            $result = $this->db->query("SELECT * FROM coupon_batch WHERE coupon_guid = '".$coupon_guid."'");

            $data = array(
                // 'branch' => $this->db->query("SELECT DISTINCT b.branch_code, b.branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid INNER JOIN set_branch_parameter c ON b.branch_guid = c.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY b.branch_code ASC"),
                'branch' => $this->branch(),
                'description' => $result->row('description'),
                'doc_date' => $result->row('doc_date'),
                'branchs' => $result->row('branch'),
                'remarks' => $result->row('remarks'),
                "action" => site_url('Point_c/submit_edit_free_gift?guid=').$result->row('coupon_guid'),
                "condition" => $this->db->query("SELECT b.* FROM coupon_batch AS a INNER JOIN coupon_batch_query_varified AS b ON a.coupon_guid = b.coupon_guid WHERE a.coupon_guid = '".$coupon_guid."'"),
                "seq" => $this->db->query("SELECT (seq + 1) AS seq FROM coupon_batch_query_varified WHERE coupon_guid = '".$coupon_guid."' ORDER BY seq DESC LIMIT 1")->row('seq'),
                "date_redemption_from" => $result->row('date_redemption_from'),
                "date_redemption_to" => $result->row('date_redemption_to'),
            );

            $this->template->load('template' , 'free_gift_setup', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function submit_edit_free_gift()
    {
       if($this->session->userdata('loginuser') == true)
       {
            $description = $this->input->post('description');
            $branch = $this->input->post('branch');
            $doc_date = $this->input->post('doc_date');
            $remarks = $this->input->post('remarks');
            $coupon_guid = $_REQUEST['guid'];
            $date_redemption_from = $this->input->post('date_redemption_from');
            $date_redemption_to = $this->input->post('date_redemption_to');

            $data = array(
                "branch" => $branch,
                "doc_date" => $doc_date,
                "description" => $description,
                "remarks" => $remarks,
                "updated_at" => $this->datetime(),
                "updated_by" => $_SESSION['username'],
                "date_redemption_from" => $date_redemption_from,
                "date_redemption_to" => $date_redemption_to,
            );

            $this->db->where('coupon_guid', $coupon_guid);
            $this->db->update('coupon_batch', $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Success edit.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Fail edit.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Point_c/edit_free_gift?guid=".$coupon_guid);
       }
       else
       {
            redirect('login_c');
       } 
    }

    public function submit_add_condition()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $seq = $this->input->post('seq');
            $query = $this->input->post('query');
            $have_rec_msg = $this->input->post('have_rec_msg');
            $have_rec_abort = $this->input->post('have_rec_abort');
            $no_rec_msg = $this->input->post('no_rec_msg');
            $no_rec_abort = $this->input->post('no_rec_abort');

            if($have_rec_abort == true)
            {
                $have_rec_abort = 1;
            }
            else
            {
                $have_rec_abort = 0;
            }

            if($no_rec_abort == true)
            {
                $no_rec_abort = 1;
            }
            else
            {
                $no_rec_abort = 0;
            }

            $data = array(
                "query_guid" => $this->guid(),
                "coupon_guid" => $_REQUEST['guid'],
                "seq" => $seq,
                "query_data" => $query,
                "have_rec_msg" => $have_rec_msg,
                "have_rec_msg_abort" => $have_rec_abort,
                "no_rec_msg" => $no_rec_msg,
                "no_rec_msg_abort" => $no_rec_abort,
                "created_at" => $this->datetime(),
                "created_by" => $_SESSION['username'],
                "updated_at" => $this->datetime(),
                "updated_by" => $_SESSION['username'],
            );

            $this->db->insert("coupon_batch_query_varified", $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Success add.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Fail add.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Point_c/edit_free_gift?guid=".$_REQUEST['guid']);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function check_query()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $this->db->db_debug = FALSE;
            $query = $this->input->post('query');
            $this->db->query($query);
            $error = $this->db->error();
            $this->db->db_debug = TRUE;
            
            if(empty($error['message']))
            {
                echo "1";
            }
            else
            {
                echo $error['message'];
            }
        }
        else
        {
            redirect('login_c');
        }
    }

    public function submit_edit_condition()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $guid = $this->input->post('guid');
            $seq = $this->input->post('seq');
            $query = $this->input->post('query');
            $have_rec_msg = $this->input->post('have_rec_msg');
            $have_rec_abort = $this->input->post('have_rec_abort');
            $no_rec_msg = $this->input->post('no_rec_msg');
            $no_rec_abort = $this->input->post('no_rec_abort');

            if($have_rec_abort == true)
            {
                $have_rec_abort = 1;
            }
            else
            {
                $have_rec_abort = 0;
            }

            if($no_rec_abort == true)
            {
                $no_rec_abort = 1;
            }
            else
            {
                $no_rec_abort = 0;
            }

            $data = array(
                "query_data" => $query,
                "have_rec_msg" => $have_rec_msg,
                "have_rec_msg_abort" => $have_rec_abort,
                "no_rec_msg" => $no_rec_msg,
                "no_rec_msg_abort" => $no_rec_abort,
                "seq" => $seq,
            );

            $this->db->where('query_guid', $guid);
            $this->db->update('coupon_batch_query_varified', $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Success edit.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Fail edit.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Point_c/edit_free_gift?guid=".$_REQUEST['query_guid']);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function delete_free_gift()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $this->db->where('query_guid', $_REQUEST['guid']);
            $this->db->delete('coupon_batch_query_varified');

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Success delete.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Fail delete.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Point_c/edit_free_gift?guid=".$_REQUEST['coupon_guid']);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function check_for_expiry()
    {

        $interval_month = $this->check_parameter()->row('point_expiry_month');

        $start_cut_off = $this->Point_Model->get_cut_off_point_expiry_date()['cut_off_datetime'];    
        $end_cut_off = $this->db->query("SELECT CONCAT(DATE('$start_cut_off'),' ','23:59:59') as end_cut_off ")->row('end_cut_off');
    

        $active = $this->check_parameter()->row('point_expiry');
        $check_trigger = $this->db->query("SELECT IF(NOW() BETWEEN '2018-11-10 13:50:00' AND '$end_cut_off','1','0') AS trigger_trans");
        $check_trans = $this->db->query("SELECT * FROM `auto_point_expiry_trans` a WHERE DATE(a.`calc_start`) = '".$this->Point_Model->get_cut_off_point_expiry_date()['cut_off_date']."' OR DATE(a.`calc_start`) = CURDATE() ;");

        //check trigger schedule, is active, and prevent from redundent process
        if($check_trigger->row('trigger_trans') == '1' && $active == '1' && $check_trans->num_rows() == 0)
        {
            $remark = $this->check_parameter()->row('point_expiry_type').' Point Expiry. Cut off period: '.$this->Point_Model->get_cut_off_point_expiry_date()['end_period'] ;
            $trans = $this->Point_Model->get_point_expiry_trans($this->Point_Model->get_cut_off_point_expiry_date()['end_period']);
            //echo $this->db->last_query();die;
            
            $_SESSION['guid_log'] = $this->guid(); 
            $data_trans_log = array(
                'guid' => $_SESSION['guid_log'],
                'end_period' => $this->Point_Model->get_cut_off_point_expiry_date()['end_period'],
                'interval_month' => $interval_month,
                'calc_type' => 'ANNUAL',
                'calc_start' => $this->datetime(),
                'calc_end' => '',
                'calc_running' => '1',
                'calc_by' => 'PANDA API',
                'total_affect' => $trans->num_rows()
            );
            $this->db->insert('auto_point_expiry_trans',$data_trans_log);

             ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                ini_set('memory_limit','2048M');
                
            foreach($trans->result() as $key => $value) 
            {
                $_SESSION['guid_trans'] = $this->guid();
                
                $data = array(
                    'TRANS_GUID' => $_SESSION['guid_trans'],
                    'TRANS_TYPE' => 'POINT_ADJ_OUT',
                    'REF_NO' => $this->Point_Model->get_point_auto_expiry_trans_ref_no()->row('ref_no'),
                    'TRANS_DATE' => $this->date(),
                    'SUP_CODE' => $value->AccountNo,
                    'SUP_NAME' => $value->Name,
                    'REMARK' => $remark,
                    'VALUE_TOTAL' => $value->point_expiry,
                    'POSTED' => '1',
                    'CREATED_AT' => $this->datetime(),
                    'CREATED_BY' => 'PANDA_API',
                    'UPDATED_AT' => $this->datetime(),
                    'UPDATED_BY' => 'PANDA_API',
                    'point_curr' => $value->Pointsbalance,
                    'branch' => 'HQ',
                    'send_outlet' => '0',
                    'cardno' => $value->AccountNo,
                    'reason' => 'EXPIRY'
                );
                $this->db->insert('trans_main', $data);

                $data_child = array(
                    'CHILD_GUID' => $this->guid(),
                    'TRANS_GUID' => $_SESSION['guid_trans'],
                    'ITEMCODE' => $this->check_parameter()->row('point_expiry_type'),
                    'DESCRIPTION' => 'EXPIRY_TYPE',
                    'QTY_FACTOR' =>  '-1',
                    'QTY' =>  '1',
                    'VALUE_UNIT' => $value->point_expiry,
                    'VALUE_TOTAL' => $value->point_expiry,
                    'CREATED_AT' => $this->datetime(),
                    'CREATED_BY' => 'PANDA_API',
                    'UPDATED_AT' => $this->datetime(),
                    'UPDATED_BY' => 'PANDA_API',
                    'posted' => '1',
                );
                $this->db->insert('trans_child', $data_child);
            }

            $data_update_log = array(
                'calc_end' => $this->datetime(),
                'calc_running' => '0',
                'calc_by' => 'PANDA_API',
            );
            $this->db->WHERE('guid',$_SESSION['guid_log']);
            $this->db->update('auto_point_expiry_trans',$data_update_log);

            //echo $this->db->last_query();die;
        }


        //echo 'done';die;
        
    }

    public function delete_manually()
    {
        $result = $this->Member_Model->query_call('Point_c', 'delete_manually');
        // $get_account_to_delete = $this->db->query("SELECT a.`AccountNo` FROM backend_member.`member_replaced` a ");

        // foreach($get_account_to_delete->result() as $key => $value) 
        // {
        //     $data = array(

        //         'refno' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid'),
        //         'SqlScript' => "DELETE FROM backend_member.`member` WHERE AccountNo = '".$value->AccountNo."' " ,  
        //         'CreatedDateTime' => $this->db->query("SELECT NOW() as datetime")->row('datetime'),
        //         'CreatedBy' => '-',
        //         'Status' => '0',
        //         'KeyField' => '',
        //     );
        //     $this->db->insert('mem_server.sqlscript',$data);
        // }
    }


}
?>