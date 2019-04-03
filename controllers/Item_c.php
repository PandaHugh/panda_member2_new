<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_c extends CI_Controller {
    
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
        $this->load->library('excel');
        $this->load->model('Member_Model');
	}

    public function branch()
    {
        $branch = array();

        $data = array(
            'username' => $_SESSION['username'],
            'userpass' => $_SESSION['userpass'],
            'module_group_guid' => $_SESSION['module_group_guid'],
        );

        $result = $this->Member_Model->query_call('Item_c', 'branch', $data);

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
            $data = array(
                'item' => $this->db->query("SELECT * from mem_item"),
                'Item_Type' => '',
                'Item_Code' => '',
                'Item_Description' => '',
                'Point' => '0.00',
                'Price' => '0.00',
                'BF' => '0',
                'Received' => '0',
                'Redeem' => '0',
                'Adjust_In' => '0',
                'Adjust_Out' => '0',
                'Return_In' => '0',
                'Return_Out' => '0',
                'Stock_Balance' => '0',
                'Voucher' => '',
                'Active' => '1',
                'action' => site_url('Item_c/create'),
                'button' => 'Create',
                'branch' => $this->branch(),
            );

            $this->template->load('template' , 'item', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function create()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $date = $this->db->query("SELECT NOW() AS date")->row('date');
            $result = $this->db->query("SELECT ITEM_CODE from mem_item where ITEM_CODE = '".$this->input->post('Item_Code')."' ");
            
            if($result->num_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Duplicate Item Code<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                if($this->input->post('Item_Type') == 'REDEEM_VOUCHER')
                {
                    $voucher = '1';
                    $Item_Type = 'REDEEM';
                    $number = $this->db->query("SELECT * FROM set_sysrun where TRANS_TYPE = 'VOUCHER_NO' ")->num_rows();

                    if($number == '0')
                    {
                        $info = array(
                            'TRANS_TYPE' => 'VOUCHER_NO',
                            'REF_CODE' => 'HQVC',
                            'REF_RUNNINGNO' => '0',
                            'REF_DIGIT' => '4',
                            'REF_DATE' => $this->db->query("SELECT CURDATE() as date ")->row('date'),

                        );
                        $this->db->insert('set_sysrun', $info);
                    };

                    $current = $this->db->query("SELECT DATE_FORMAT(CURDATE(), '%Y-%m') as date")->row('date');
                    $month = $this->db->query("SELECT DATE_FORMAT(REF_DATE, '%Y-%m') as date FROM set_sysrun WHERE TRANS_TYPE = 'VOUCHER_NO' ")->row('date');

                    if($current != $month)
                    {
                        $value = array(
                            'REF_DATE' => $this->db->query("SELECT CURDATE() AS date")->row('date'),
                            'REF_RUNNINGNO' => '0',

                        );
                        $this->db->where('TRANS_TYPE', 'VOUCHER_NO');
                        $this->db->update('set_sysrun', $value);
                    };

                    /*$voucher_valid_in_days = $this->db->query("SELECT voucher_valid_in_days from set_parameter ")->row('voucher_valid_in_days');
                    $sysrun = $this->db->query("SELECT * from set_sysrun where TRANS_TYPE = 'VOUCHER_NO' ");
                    $pad = $this->db->query("SELECT CONCAT(REPLACE(CURDATE(), '-', ''), LPAD('".$sysrun->row('REF_RUNNINGNO')."', '".$sysrun->row('REF_DIGIT')."', '0')) AS pad")->row('pad');
                    $check_digit = $this->db->query("SELECT check_digit_voucher from set_parameter")->row('check_digit_voucher');

                    if($check_digit == '1')
                    {
                        $final_pad = $this->db->query("SELECT CONCAT('$pad', RIGHT(10-MOD(MID('$pad', 1, 1) + MID('$pad', 3, 1) + MID('$pad', 5, 1) + MID('$pad', 7, 1) + MID('$pad', 9, 1) + MID('$pad', 11, 1) + ((MID('$pad', 2, 1) + MID('$pad', 4, 1) + MID('$pad', 6, 1) + MID('$pad', 8, 1) + MID('$pad', 10, 1) + MID('$pad', 12, 1))*3), 10), 1)) AS check_digit ")->row('check_digit');
                    }
                    else
                    {
                        $final_pad = $pad;
                    }

                    $info = array(
                        'REFNO' => $final_pad,
                        'VOUCHER_TYPE' => 'COMP.VOUCHER',
                        'REMARK' => '',
                        'AMOUNT' => $this->input->post('Price'),
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
                        'hq_update' => '1',
                        'link_guid' => $guid,
                        'activated_at' => $date,
                        'activated_by' => '',

                        );
                    $this->db->insert('frontend.voucher_general', $info);

                    if($this->db->affected_rows() > 0)
                    {
                        $infomation = array(
                            'REF_RUNNINGNO' => $sysrun->row('REF_RUNNINGNO') + 1,

                        );
                        $this->db->where('TRANS_TYPE', 'VOUCHER_NO');
                        $this->db->update('set_sysrun', $infomation);
                    };*/
                }
                else
                {
                    $voucher = '0';
                    $Item_Type = $this->input->post('Item_Type');
                    $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS UUID")->row('UUID');
                }
                
                $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS UUID")->row('UUID');

                $data = array(
                    'ITEM_GUID' => $guid,
                    'ITEM_TYPE' => $Item_Type,
                    'ITEM_CODE' => $this->input->post('Item_Code'),
                    'ITEM_DESC' => $this->input->post('Item_Description'),
                    'POINT_TYPE1' => $this->input->post('Point'),
                    'PRICE' => $this->input->post('Price'),
                    'STK_BF' => addslashes($this->input->post('B/F')),
                    'STK_REC' => $this->input->post('Received'),
                    'STK_REDEEM' => $this->input->post('Redeem'),
                    'STK_ADJ_IN' => $this->input->post('Adjust_In'),
                    'STK_ADJ_OUT' => $this->input->post('Adjust_Out'),
                    'STK_RET_IN' => $this->input->post('Return_In'),
                    'STK_RET_OUT' => $this->input->post('Return_Out'),
                    'STK_BAL' => $this->input->post('Stock_Balance'),
                    'CREATED_AT' => $date,
                    'CREATED_BY' => $_SESSION['username'],
                    'UPDATED_AT' => $date,
                    'UPDATED_BY' => $_SESSION['username'],
                    'isVoucher' => $voucher,
                    'enable' => $this->input->post('enable'),

                    );
                $this->db->insert('mem_item', $data);

                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Insert Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Insert Record<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
            }
            redirect("Item_c");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function edit()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $code = $_REQUEST['code'];
            $result = $this->db->query("SELECT * from mem_item where ITEM_CODE = '$code' ");

            if($result->row('isVoucher') == '1')
            {
                $ITEM_TYPE = 'REDEEM => VOUCHER';
            }
            else
            {
                $ITEM_TYPE = $result->row('ITEM_TYPE');
            }

            $data = array(
                'item' => $this->db->query("SELECT * from mem_item"),
                'Item_Type' => $ITEM_TYPE,
                'Item_Code' => $result->row('ITEM_CODE'),
                'Item_Description' => $result->row('ITEM_DESC'),
                'Point' => $result->row('POINT_TYPE1'),
                'Price' => $result->row('PRICE'),
                'BF' => $result->row('STK_BF'),
                'Received' => $result->row('STK_REC'),
                'Redeem' => $result->row('STK_REDEEM'),
                'Adjust_In' => $result->row('STK_ADJ_IN'),
                'Adjust_Out' => $result->row('STK_ADJ_OUT'),
                'Return_In' => $result->row('STK_RET_IN'),
                'Return_Out' => $result->row('STK_RET_OUT'),
                'Stock_Balance' => $result->row('STK_BAL'),
                'Voucher' => $result->row('isVoucher'),
                'Active' => $result->row('enable'),
                'action' => site_url('Item_c/update?code='.$code),
                'button' => 'Update',
                'branch' => $this->branch(),
                );
            $this->template->load('template' , 'item' , $data);
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
            $code = $_REQUEST['code'];

            if($this->input->post('Item_Type') == 'REDEEM => VOUCHER' || $this->input->post('Item_Type') == 'REDEEM_VOUCHER')
            {
                $voucher = '1';
                $Item_Type = 'REDEEM';
            }
            else
            {
                $voucher = '0';
                $Item_Type = $this->input->post('Item_Type');
            }

            $data = array(
                // 'ITEM_TYPE' => $Item_Type,
                // 'ITEM_CODE' => $this->input->post('Item_Code'),
                'ITEM_DESC' => $this->input->post('Item_Description'),
                'POINT_TYPE1' => $this->input->post('Point'),
                'PRICE' => $this->input->post('Price'),
                // 'STK_BF' => $this->input->post('B/F'),
                // 'STK_REC' => $this->input->post('Received'),
                // 'STK_REDEEM' => $this->input->post('Redeem'),
                // 'STK_ADJ_IN' => $this->input->post('Adjust_In'),
                // 'STK_ADJ_OUT' => $this->input->post('Adjust_Out'),
                // 'STK_RET_IN' => $this->input->post('Return_In'),
                // 'STK_RET_OUT' => $this->input->post('Return_Out'),
                // 'STK_BAL' => $this->input->post('Stock_Balance'),
                // 'isVoucher' => $voucher,
                'enable' => $this->input->post('enable'),
                'UPDATED_AT' => $this->db->query("SELECT NOW() AS date")->row('date'),
                'UPDATED_BY' => $_SESSION['username'],

                );
            $this->db->where('ITEM_CODE', $code);
            $this->db->update('mem_item', $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Update Record<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Item_c");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function mem_item_trans_main()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $item_guid = $_REQUEST['item_guid'];
            $trans_type = $_REQUEST['trans_type'];

            if($trans_type == 'receive')
            {
                $trans_type = 'Receive';
            }
            else if($trans_type == 'adjust_in')
            {
                $trans_type = 'Adjust In';
            }
            else if($trans_type == 'adjust_out')
            {
                $trans_type = 'Adjust Out';
            }

            $columns = array(
                0 => "branch",
                1 => "Trans_type",
                2 => "refno",
                3 => "ITEM_CODE",
                4 => "ITEM_DESC",
                5 => "rec_qty",
                6 => "adj_in_qty",
                7 => "adj_out_qty",
            );

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalFiltered = $totalData = $this->db->query("
                SELECT COUNT(b.Child_guid) AS num FROM (SELECT Trans_guid, refno FROM mem_item_trans_main) AS a
                INNER JOIN mem_item_trans_child AS b ON a.Trans_guid = b.Trans_guid
                INNER JOIN mem_item AS c ON b.ITEM_GUID = c.ITEM_GUID
                WHERE b.ITEM_GUID = '$item_guid' AND b.Trans_type = '$trans_type' AND b.branch IN ("."'".implode($_SESSION['branch_code'], "','")."'".")
            ")->row('num');

            if(empty($this->input->post('search')['value']))
            {
                $posts = $this->db->query("
                    SELECT Trans_type, refno, ITEM_CODE, c.ITEM_DESC, rec_qty, adj_in_qty, adj_out_qty, branch FROM (SELECT Trans_guid, refno FROM mem_item_trans_main) AS a
                    INNER JOIN mem_item_trans_child AS b ON a.Trans_guid = b.Trans_guid
                    INNER JOIN mem_item AS c ON b.ITEM_GUID = c.ITEM_GUID
                    WHERE b.ITEM_GUID = '$item_guid' AND b.Trans_type = '$trans_type' AND b.branch IN ("."'".implode($_SESSION['branch_code'], "','")."'".") ORDER BY $order $dir LIMIT $start, $limit
                ")->result_array();
            }
            else
            {
                $search = $this->input->post('search')['value'];
                $query = $this->db->query("
                            SELECT Trans_type, refno, ITEM_CODE, c.ITEM_DESC, rec_qty, adj_in_qty, adj_out_qty, branch FROM (SELECT Trans_guid, refno FROM mem_item_trans_main) AS a
                            INNER JOIN mem_item_trans_child AS b ON a.Trans_guid = b.Trans_guid
                            INNER JOIN mem_item AS c ON b.ITEM_GUID = c.ITEM_GUID
                            WHERE b.ITEM_GUID = '$item_guid' AND b.Trans_type = '$trans_type' AND b.branch IN ("."'".implode($_SESSION['branch_code'], "','")."'".") AND (Trans_type LIKE '%$search%' or refno LIKE '%$search%' or ITEM_CODE LIKE '%$search%' or ITEM_DESC LIKE '%$search%' or branch LIKE '%$search%') ORDER BY $order $dir LIMIT $start, $limit
                        ");
                $posts = $query->result_array();
                $totalFiltered = $query->num_rows();
            }
           
            

            if(!empty($posts))
            {
                foreach ($posts as $post)
                {
                    $nestedData['Trans_type'] = $post['Trans_type'];
                    $nestedData['refno'] = $post['refno'];
                    $nestedData['ITEM_CODE'] = $post['ITEM_CODE'];
                    $nestedData['ITEM_DESC'] = $post['ITEM_DESC'];
                    $nestedData['rec_qty'] = $post['rec_qty'];
                    $nestedData['adj_in_qty'] = $post['adj_in_qty'];
                    $nestedData['adj_out_qty'] = $post['adj_out_qty'];
                    $nestedData['branch'] = $post['branch'];

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

    public function mem_item()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $columns = array(
                0 => "action",
                1 => "enable",
                2 => "isVoucher",
                3 => "ITEM_TYPE",
                4 => "ITEM_CODE",
                5 => "ITEM_DESC",
                6 => "POINT_TYPE1",
                7 => "PRICE",
                8 => "STK_BAL",
                9 => "STK_BF",
                10 => "STK_REC",
                11 => "STK_REDEEM",
                12 => "STK_ADJ_IN",
                13 => "STK_ADJ_OUT",
                // 14 => "STK_RET_IN",
                // 15 => "STK_RET_OUT",
                14 => "CREATED_AT",
                15 => "CREATED_BY",
                16 => "UPDATED_AT",
                17 => "UPDATED_BY",
            );

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalFiltered = $totalData = $this->db->query("SELECT COUNT(ITEM_GUID) AS num FROM mem_item")->row('num');

            if(empty($this->input->post('search')['value']))
            {
                $posts = $this->db->query("SELECT * FROM mem_item ORDER BY $order $dir LIMIT $start, $limit")->result_array();
            }
            else
            {
                $search = $this->input->post('search')['value'];
                $query = $this->db->query("SELECT * FROM mem_item WHERE ITEM_CODE LIKE '%$search%' OR ITEM_TYPE LIKE '%$search%' OR ITEM_DESC LIKE '%$search%'  ORDER BY $order $dir LIMIT $start, $limit");
                $posts = $query->result_array();
                $totalFiltered = $query->num_rows();
            }

            if(!empty($posts))
            {
                foreach ($posts as $post)
                {
                    $html = '<center>
                                <div class="row" style="margin-bottom:5px;">
                                  <a href="'.site_url('Item_c/edit').'?code='.$post['ITEM_CODE'].'" title="Edit" class="btn btn-xs btn-primary" style="margin-right:2px;"><i class="glyphicon glyphicon-pencil"></i></a>';

                    if($post['isVoucher'] == '0')
                    {
                        if(in_array('RI', $_SESSION['module_code']))
                        {
                            $html .= '<button data-toggle="modal" data-target="#modal-item" title="Receive" data-transtype="receive" data-itemcode="'.$post['ITEM_CODE'].'" data-name="'.$post['ITEM_DESC'].'" data-stkbalance = "'.$post['STK_BAL'].'" class="btn btn-xs btn-success receive_btn" id="'.$post['ITEM_GUID'].'"><i class="fa fa-download"></i></button>';
                        }

                        $html .= '</div><div class="row">';

                        if(in_array('AII', $_SESSION['module_code']))
                        {
                            $html .= '<button data-toggle="modal" data-target="#modal-item" title="Adjust In" data-transtype="adjust_in" data-itemcode="'.$post['ITEM_CODE'].'" data-name="'.$post['ITEM_DESC'].'" data-stkbalance = "'.$post['STK_BAL'].'" class="btn btn-xs btn-warning adj_in_btn" id="'.$post['ITEM_GUID'].'" style="margin-right:2px;"><i class="fa fa-plus"></i></button>';
                        }

                        if(in_array('AOI', $_SESSION['module_code']))
                        {
                            $html .= '<button data-toggle="modal" data-target="#modal-item" title="Adjust Out" data-transtype="adjust_out" data-itemcode="'.$post['ITEM_CODE'].'" data-name="'.$post['ITEM_DESC'].'" data-stkbalance = "'.$post['STK_BAL'].'" class="btn btn-xs btn-danger adj_out_btn" id="'.$post['ITEM_GUID'].'"><i class="fa fa-minus"></i></button>';
                        }
                    }

                    $html .= '  </div>
                            </center>';

                    $nestedData["action"] = $html;

                    if($post['enable'] == '1')
                    {
                        $enable = "&#10004";
                    }
                    else
                    {
                        $enable = "&#10006";
                    }

                    if($post['isVoucher'] == '1')
                    {
                        $isVoucher = "&#10004";
                    }
                    else
                    {
                        $isVoucher = "&#10006";
                    }

                    $nestedData["enable"] = "<center><span>".$enable."</span></center>";
                    $nestedData["isVoucher"] = "<center><span>".$isVoucher."</span></center>";
                    $nestedData["ITEM_TYPE"] = $post['ITEM_TYPE'];
                    $nestedData["ITEM_CODE"] = $post['ITEM_CODE'];
                    $nestedData["ITEM_DESC"] = $post['ITEM_DESC'];
                    $nestedData["POINT_TYPE1"] = $post['POINT_TYPE1'];
                    $nestedData["PRICE"] = $post['PRICE'];
                    $nestedData["STK_BF"] = $post['STK_BF'];
                    $nestedData["STK_REC"] = $post['STK_REC'];
                    $nestedData["STK_REDEEM"] = $post['STK_REDEEM'];
                    $nestedData["STK_ADJ_IN"] = $post['STK_ADJ_IN'];
                    $nestedData["STK_ADJ_OUT"] = $post['STK_ADJ_OUT'];
                    // $nestedData["STK_RET_IN"] = $post['STK_RET_IN'];
                    // $nestedData["STK_RET_OUT"] = $post['STK_RET_OUT'];
                    $nestedData["STK_BAL"] = $post['STK_BAL'];
                    $nestedData["CREATED_AT"] = $post['CREATED_AT'];
                    $nestedData["CREATED_BY"] = $post['CREATED_BY'];
                    $nestedData["UPDATED_AT"] = $post['UPDATED_AT'];
                    $nestedData["UPDATED_BY"] = $post['UPDATED_BY'];

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

    public function add_trans_main()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $trans_type = $this->input->post('trans_type');
            $item_guid = $this->input->post('item_guid');
            $qty = $this->input->post('qty');
            $branch = $this->input->post('branch');

            $Trans_guid = $this->db->query("SELECT UPPER(REPLACE(UUID(), '-', '')) AS guid")->row('guid');

            $data = array(
                'Child_guid' => $this->db->query("SELECT UPPER(REPLACE(UUID(), '-', '')) AS guid")->row('guid'),
                'Trans_guid' => $Trans_guid,
                'Trans_type' => $trans_type,
                'ITEM_GUID' => $item_guid,
                'branch' => $branch,
                'created_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                'updated_by' => $_SESSION['username'],
            );

            $refno_type = "ST";

            if($trans_type == 'Receive')
            {
                $data['rec_qty'] = $qty;
            }
            else if($trans_type == 'Adjust In')
            {
                $data['adj_in_qty'] = $qty;
            }
            else if($trans_type == 'Adjust Out')
            {
                $data['adj_out_qty'] = $qty;
            }

            $this->db->insert('mem_item_trans_child', $data);

            $refno = $this->db->query("SELECT IFNULL((SELECT RIGHT((SELECT refno FROM mem_item_trans_main WHERE Trans_type = '$trans_type' AND LEFT(CREATED_AT, 10) = CURDATE() ORDER BY CREATED_AT DESC LIMIT 1), 4)), 'new') AS running_no")->row('running_no');

            if($refno == 'new')
            {
                $refno = '0000';
            }
            else 
            {
                $refno = str_pad(($refno + 1), 4, "0", STR_PAD_LEFT);
            }

            $data = array(
                'Trans_guid' => $Trans_guid,
                'Trans_type' => "Stock Adjust",
                'refno' => $refno_type.$this->db->query("SELECT CONCAT(REPLACE(CURDATE(), '-', ''), '$refno') AS refno")->row('refno'),
                'created_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                'updated_by' => $_SESSION['username'],
            );

            $this->db->insert('mem_item_trans_main', $data);
            
            if($trans_type == 'Receive')
            {
                $this->db->query("UPDATE mem_item SET STK_REC = STK_REC + $qty WHERE ITEM_GUID = '$item_guid'");
            }
            else if($trans_type == 'Adjust In')
            {
                $this->db->query("UPDATE mem_item SET STK_ADJ_IN = STK_ADJ_IN + $qty WHERE ITEM_GUID = '$item_guid'");
            }
            else if($trans_type == 'Adjust Out')
            {
                $this->db->query("UPDATE mem_item SET STK_ADJ_OUT = STK_ADJ_OUT + $qty WHERE ITEM_GUID = '$item_guid'");
            }

            $this->db->query("UPDATE mem_item SET STK_BAL = (STK_BF + STK_REC - STK_REDEEM + STK_ADJ_IN - STK_ADJ_OUT) WHERE ITEM_GUID = '$item_guid'");

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">'.$trans_type.' Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail '.$trans_type.' Item<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Item_c");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function import_redemption()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $this->template->load('template' , 'import_item');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function mem_item_trans_list()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $columns = array(
                0 => "Trans_type",
                1 => "refno",
                2 => "created_at",
                3 => "created_by",
                4 => "action",
            );

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalFiltered = $totalData = $this->db->query("SELECT COUNT(refno) AS num FROM mem_item_trans_main")->row('num');

            if(empty($this->input->post('search')['value']))
            {
                $posts = $this->db->query("SELECT * FROM mem_item_trans_main ORDER BY $order $dir LIMIT $start, $limit")->result_array();
            }
            else
            {
                $search = $this->input->post('search')['value'];
                $query = $this->db->query("SELECT * FROM mem_item_trans_main WHERE Trans_type LIKE '%$search%' OR refno LIKE '%$search%' created_at LIKE '%$search%' OR created_by LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $limit");
                $posts = $query->result_array();
                $totalFiltered = $query->num_rows();
            }

            if(!empty($posts))
            {
                foreach ($posts as $post)
                {
                    $nestedData['Trans_type'] = $post['Trans_type'];
                    $nestedData['refno'] = $post['refno'];
                    $nestedData['created_at'] = $post['created_at'];
                    $nestedData['created_by'] = $post['created_by'];
                    $nestedData['action'] = "<button class='btn btn-primary btn-xs' id='".$post['Trans_guid']."' data-refno='".$post['refno']."'><i class='fa fa-eye'></i></button>";

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

    public function download_sample()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $query = $this->db->query('SELECT ITEM_CODE, ITEM_DESC, "" as qty, "" as branch FROM mem_item WHERE isVoucher = "0" AND enable = "1" AND ITEM_TYPE = "REDEEM" ORDER BY ITEM_DESC');

            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0); 
            ini_set('memory_limit','2048M');
            $this->load->dbutil();
            $this->load->helper('file');
            $this->load->helper('download');
            $delimiter = ",";
            $newline = "\r\n";

        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('Member Item Stock.csv', $data);

            // ini_set('memory_limit', '-1');
            // ini_set('max_execution_time', 0); 
            // ini_set('memory_limit','2048M');

            // //load our new PHPExcel library
            // $this->load->library('excel');
            // //activate worksheet number 1
            // $this->excel->setActiveSheetIndex(0);
            // //name the worksheet
            // $this->excel->getActiveSheet()->setTitle('Member Item');
            // $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
            // $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
            // //set cell A1 content with some text
            // $this->excel->getActiveSheet()->setCellValue('A1', 'ITEM_CODE');
            // $this->excel->getActiveSheet()->setCellValue('B1', 'ITEM_DESC');
            // $this->excel->getActiveSheet()->setCellValue('C1', 'qty');
            // $this->excel->getActiveSheet()->setCellValue('D1', 'branch');

            // $mem_item = $this->db->query('SELECT ITEM_CODE, ITEM_DESC FROM mem_item WHERE isVoucher = "0" AND enable = "1" AND ITEM_TYPE = "REDEEM" ORDER BY ITEM_DESC');
            // $i = 2;

            // foreach ($mem_item->result() AS $row) 
            // {
            //     $this->excel->getActiveSheet()->setCellValue('A'.$i, $row->ITEM_CODE);
            //     $this->excel->getActiveSheet()->setCellValue('B'.$i, $row->ITEM_DESC);

            //     $i++;
            // }

            // $filename='Member Item Stock.xlsx'; //save our workbook as this file name
            // header('Content-Type: application/vnd.ms-excel'); //mime type
            // header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            // header('Cache-Control: max-age=0'); //no cache

            // //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            // //if you want to save it as .XLSX Excel 2007 format
            // $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
            // ob_end_clean();
            // //force user to download the Excel file without writing it to server's HD
            // $objWriter->save('php://output');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function submit_redemption_trans()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $trans_type = $this->input->post('trans_type');

            if($trans_type == 'Receive')
            {
                $refno_type = "RI";
            }
            else if($trans_type == 'Adjust')
            {
                $refno_type = "ADJ";
            }

            //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)    
            $configUpload['upload_path'] = FCPATH.'uploads/excel/';
            $configUpload['allowed_types'] = 'xls|xlsx|csv';
            $configUpload['max_size'] = '5000';
            $this->load->library('upload', $configUpload);
            $this->upload->do_upload('userfile');  
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.

            $PHPReader = new PHPExcel_Reader_CSV();
            $PHPReader->setInputEncoding('GBK');
            $PHPReader->setDelimiter(',');
            

            $file_name = $upload_data['file_name']; //uploded file name
            $extension=$upload_data['file_ext'];    // uploded file extension
        
            // $objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
            // $objReader= PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007     
            //Set to read only
            // $objReader->setReadDataOnly(true);          
            //Load excel file
            $objPHPExcel = $PHPReader->load(FCPATH.'uploads/excel/'.$file_name);
            // $objPHPExcel=$objReader->load(FCPATH.'uploads/excel/'.$file_name);      
            $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel         
            $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);                
            //loop from first data untill last data

            $trans_guid = $this->db->query("SELECT UPPER(REPLACE(UUID(), '-', '')) AS guid")->row('guid');

            for($i=2;$i<=$totalrows;$i++)
            {
                $ITEM_CODE =  $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();

                $mem_item = $this->db->query('SELECT ITEM_GUID FROM mem_item WHERE ITEM_CODE = "'.$ITEM_CODE.'"');

                if($mem_item->num_rows() == 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Invalid Itemcode<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect('Item_c/import_redemption');
                }
            }

            if($trans_type == 'Receive')
            {
                for($i=2;$i<=$totalrows;$i++)
                {
                    $ITEM_CODE =  $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
                    $Qty = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
                    $branch = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();

                    $mem_item = $this->db->query('SELECT ITEM_GUID FROM mem_item WHERE ITEM_CODE = "'.$ITEM_CODE.'"');

                    $data = array(
                        'Child_guid' => $this->db->query("SELECT UPPER(REPLACE(UUID(), '-', '')) AS guid")->row('guid'),
                        'Trans_guid' => $trans_guid,
                        'Trans_type' => 'Receive',
                        'Item_GUID' => $mem_item->row('ITEM_GUID'),
                        'branch' => $branch,
                        'rec_qty' => $Qty,
                        'created_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                        'created_by' => $_SESSION['username'],
                        'updated_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                        'updated_by' => $_SESSION['username'],
                    );

                    $this->db->insert('mem_item_trans_child', $data);

                    $qty = $this->db->query("UPDATE mem_item SET STK_REC = STK_REC + $Qty WHERE ITEM_GUID = '".$mem_item->row('ITEM_GUID')."'");

                    $this->db->query("UPDATE mem_item SET STK_BAL = STK_BF + STK_REC - STK_REDEEM + STK_ADJ_IN - STK_ADJ_OUT, updated_at = NOW(), updated_by = '".$_SESSION['username']."' WHERE ITEM_GUID = '".$mem_item->row('ITEM_GUID')."'");
                }
            }
            elseif($trans_type == 'Adjust')
            {
                for($i=2;$i<=$totalrows;$i++)
                {
                    $ITEM_CODE =  $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
                    $Qty = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
                    $branch = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();

                    $mem_item = $this->db->query('SELECT * FROM mem_item WHERE ITEM_CODE = "'.$ITEM_CODE.'"');

                    if($Qty > $mem_item->row('STK_BAL'))
                    {
                        $data = array(
                            'Child_guid' => $this->db->query("SELECT UPPER(REPLACE(UUID(), '-', '')) AS guid")->row('guid'),
                            'Trans_guid' => $trans_guid,
                            'Trans_type' => 'Adjust In',
                            'Item_GUID' => $mem_item->row('ITEM_GUID'),
                            'branch' => $branch,
                            'adj_in_qty' => $Qty - $mem_item->row('STK_BAL'),
                            'created_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                            'created_by' => $_SESSION['username'],
                            'updated_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                            'updated_by' => $_SESSION['username'],
                        );

                        $this->db->insert('mem_item_trans_child', $data);

                        $stk_adj_in = $Qty - $mem_item->row('STK_BAL');

                        $qty = $this->db->query("UPDATE mem_item SET STK_ADJ_IN = STK_ADJ_IN + $stk_adj_in WHERE ITEM_GUID = '".$mem_item->row('ITEM_GUID')."'");
                    }
                    else
                    {
                        $data = array(
                            'Child_guid' => $this->db->query("SELECT UPPER(REPLACE(UUID(), '-', '')) AS guid")->row('guid'),
                            'Trans_guid' => $trans_guid,
                            'Trans_type' => 'Adjust Out',
                            'Item_GUID' => $mem_item->row('ITEM_GUID'),
                            'branch' => $branch,
                            'adj_out_qty' => $mem_item->row('STK_BAL') - $Qty,
                            'created_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                            'created_by' => $_SESSION['username'],
                            'updated_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                            'updated_by' => $_SESSION['username'],
                        );

                        $this->db->insert('mem_item_trans_child', $data);

                        $stk_adj_out = $mem_item->row('STK_BAL') - $Qty;

                        $qty = $this->db->query("UPDATE mem_item SET STK_ADJ_OUT = STK_ADJ_OUT + $stk_adj_out WHERE ITEM_GUID = '".$mem_item->row('ITEM_GUID')."'");
                    }

                    $this->db->query("UPDATE mem_item SET STK_BAL = STK_BF + STK_REC - STK_REDEEM + STK_ADJ_IN - STK_ADJ_OUT, updated_at = NOW(), updated_by = '".$_SESSION['username']."' WHERE ITEM_GUID = '".$mem_item->row('ITEM_GUID')."'");
                }
            }

            $refno = $this->db->query("SELECT IFNULL((SELECT RIGHT((SELECT refno FROM mem_item_trans_main WHERE Trans_type = '$trans_type' AND LEFT(CREATED_AT, 10) = CURDATE() ORDER BY CREATED_AT DESC LIMIT 1), 4)), 'new') AS running_no")->row('running_no');
            $curdate = $this->db->query('SELECT REPLACE(CURDATE(), "-", "") AS datenow')->row('datenow');

            if($refno == 'new')
            {
                $refno = '0000';
            }
            else 
            {
                $refno = str_pad(($refno + 1), 4, "0", STR_PAD_LEFT);
            }

            $data = array(
                'Trans_guid' => $trans_guid,
                'Trans_type' => 'Stock Adjust',
                'refno' => $refno_type.$curdate.$refno,
                'created_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at' => $this->db->query('SELECT NOW() AS datetime')->row('datetime'),
                'updated_by' => $_SESSION['username'],
            );

            $this->db->insert('mem_item_trans_main', $data);

            unlink('././uploads/excel/'.$file_name); //File Deleted After uploading in database .  
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Import Succes<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');         
            redirect('Item_c/import_redemption');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function trans_child_list()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $guid = $_REQUEST['id'];

            $columns = array(
                0 => "Trans_type",
                1 => "ITEM_CODE",
                2 => "ITEM_DESC",
                3 => "rec_qty",
                4 => "adj_in_qty",
                5 => "adj_out_qty",
                6 => "branch",
                7 => "created_at",
                8 => "created_by",
            );

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalFiltered = $totalData = $this->db->query("SELECT COUNT(a.Child_guid) AS num FROM mem_item_trans_child AS a INNER JOIN mem_item AS b ON a.ITEM_GUID = b.ITEM_GUID WHERE a.Trans_guid = '$guid'")->row('num');

            if(empty($this->input->post('search')['value']))
            {
                $posts = $this->db->query("SELECT * FROM mem_item_trans_child AS a INNER JOIN (SELECT ITEM_GUID, ITEM_CODE, ITEM_DESC FROM mem_item) AS b ON a.ITEM_GUID = b.ITEM_GUID WHERE a.Trans_guid = '$guid' ORDER BY $order $dir LIMIT $start, $limit")->result_array();
            }
            else
            {
                $search = $this->input->post('search')['value'];
                $query = $this->db->query("SELECT * FROM mem_item_trans_child AS a INNER JOIN (SELECT ITEM_GUID, ITEM_CODE, ITEM_DESC FROM mem_item) AS b ON a.ITEM_GUID = b.ITEM_GUID WHERE a.Trans_guid = '$guid' AND (b.ITEM_CODE LIKE '%$search%' OR b.ITEM_DESC LIKE '%$search%' OR a.rec_qty LIKE '%$search%' OR a.adj_in_qty LIKE '%$search%' OR a.adj_out_qty LIKE '%$search%' OR a.branch LIKE '%$search%' OR a.created_at LIKE '%$search%' OR a.created_by LIKE '%$search%') ORDER BY $order $dir LIMIT $start, $limit");
                $posts = $query->result_array();
                $totalFiltered = $query->num_rows();
            }

            if(!empty($posts))
            {
                foreach ($posts as $post)
                {
                    $nestedData['Trans_type'] = $post['Trans_type'];
                    $nestedData['ITEM_CODE'] = $post['ITEM_CODE'];
                    $nestedData['ITEM_DESC'] = $post['ITEM_DESC'];
                    $nestedData['rec_qty'] = $post['rec_qty'];
                    $nestedData['adj_in_qty'] = $post['adj_in_qty'];
                    $nestedData['adj_out_qty'] = $post['adj_out_qty'];
                    $nestedData['branch'] = $post['branch'];
                    $nestedData['created_at'] = $post['created_at'];
                    $nestedData['created_by'] = $post['created_by'];

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

    /*public function delete()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $code = $_REQUEST['code'];

            $this->db->where('ITEM_CODE', $code);
            $this->db->delete('mem_item');

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Item Deleted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Delete Item<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Item_c");
        }
        else
        {
            redirect('login_c');
        }
    }*/

    


}
?>
