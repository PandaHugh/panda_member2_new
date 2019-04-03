<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_c extends CI_Controller {
    
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
        $this->load->model('Sms_Model');
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

    public function create_trans()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $provider = $this->db->query("SELECT * FROM `sms_setup` a WHERE a.`set` = '1';");
            
            if($this->input->post('sending_template'))
            {
                $record = $this->Sms_Model->sending_list_all($this->input->post('sending_template'));
                $box_style = '';
                $setup_style = 'hidden';
                $guid = $this->input->post('sending_template');

                $this->session->set_flashdata('confirm_message', '<div class="alert alert-success text-center" style="font-size: 18px">Sending SMS using '.$provider->row('provider').' as provider to '.$record->num_rows().' total of Member. Please confirm bellow list before click confirmation button.<br></div>');

                $this->session->set_flashdata('confirm_button', '<center class="text-center" style="font-size: 22px">
                    <a href="create_trans" class="btn btn-danger btn-md">CANCEL</a>
                    <a href="send_sms_template?guid='.$this->input->post('sending_template').'" class="btn btn-primary btn-md">COFIRM SEND</a></center>');

            }
            else
            {
                $record = $this->db->query("SELECT '' AS decode_message,'' AS contact_no, '' AS account_no, '' AS NAME;");
                $box_style = 'hidden';
                $setup_style = '';
                $guid = '';
            }
            
            $data = array(
                'provider' => $provider,
                'sending_template' => $this->db->query("SELECT * FROM `sms_sending_template` a WHERE a.`set_active` = '1';"),
                'record' => $record,
                'box_style' => $box_style,
                'setup_style' => $setup_style,
                'guid' => $guid
            );

            $this->template->load('template' , 'sms_create_trans', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function setup()
    {
        if($this->session->userdata('loginuser')== true)
        {
            if($this->input->post('provider'))
            {
                $this->db->query("UPDATE `sms_setup` a SET a.`set` = '0';");
                $data = array(
                    'set' => '1',
                );
                $this->db->where('guid', $this->input->post('provider'));
                $this->db->update('sms_setup',$data);
            }

            $get_setup = $this->db->query("SELECT * FROM `sms_setup` a  where a.set = '1';");
            $get_setup_all = $this->db->query("SELECT * FROM `sms_setup` a;");

            if($get_setup->row('provider') == 'ONEWAY')
            {

                $url = "http://gateway.onewaysms.com.my:10001/bulkcredit.aspx?apiusername=".$get_setup->row('api_username')."&apipassword=".$get_setup->row('api_password');
                $balance = @implode ('', file ($url));
            }
            else
            {
                $balance = '';
            }

            $data = array(
                'setup' => $get_setup,
                'setup_all' => $get_setup_all,
                'oneway_balance' => $balance
            );

            $this->template->load('template' , 'sms_setup', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function setup_action()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $data = array(
                'url' => $this->input->post('url'),
                'api_username' => $this->input->post('api_username'),
                'api_password' => $this->input->post('api_password'),
                'sender_id' => $this->input->post('sender_id'),
            );
            $this->db->where('guid', $_REQUEST['guid']);
            $this->db->update('sms_setup',$data);

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update Record Success<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('Sms_c/setup');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function send_sms_template()
    {
        if($this->session->userdata('loginuser')== true)
        {   
            $_SESSION['sending_session'] = $this->guid();
            $setup = $this->Sms_Model->sending_list_all($_REQUEST['guid']);
            //echo $this->db->last_query();die;
            foreach ($setup->result() as $row) 
            {
                $provider = $row->provider;
                $user = $row->api_username;
                $pass = $row->api_password;
                $sms_from = $row->sender_id;
                $sms_to = "6".$row->contact_no;
                $sms_msg = $row->decode_message;
                $languagetype = $row->languagetype;
                $url = $row->url;

                $process = $this->Sms_Model->send_sms($url,$provider,$user,$pass,$sms_from,$sms_to,$sms_msg,$languagetype);
                $data = array(
                    'trans_guid' => $this->guid(),
                    'trans_type' => 'TEMPLATE',
                    'respond_code' => $process['code'],
                    'respond_message' => $process['respond_message'],
                    'merchant_id' => 'WEB_MEMBER',
                    'merchant_name' => 'WEB_MEMBER',
                    'account_no' => $row->account_no,
                    'mobile_no' => $process['mobileno'],
                    'message' => $process['message'],
                    'status' => $process['status'],
                    'date' => $this->db->query("SELECT CURDATE() AS date")->row('date'),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION["username"],
                    'provider' => $provider,
                    'sending_template' => $_REQUEST['guid'],
                    'sending_session' => $_SESSION['sending_session'],
                    );
                $send_sms = $this->db->insert('sms_transaction', $data);
            }

            $get_total_sending = $this->db->query("SELECT COUNT(*) AS total FROM `sms_transaction` a 
                WHERE a.`sending_session` = '".$_SESSION['sending_session']."' AND a.`status` = 'SUCCESS';")->row('total');

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Succesfull sent = '.$get_total_sending.'.Please go to transaction list to view full sending report.<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('Sms_c/create_trans');
        }
        else
        {
            redirect('login_c');
        }
    }

    public function send_sms()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $_SESSION['sending_session'] = $this->guid();
            $setup = $this->db->query("SELECT * FROM sms_setup a where a.guid = '".$_REQUEST['provider_guid']."' ");

            if(isset($_REQUEST['testing']))
            {
                $phoneno = "6".$this->input->post('phoneno');
                $message = $this->input->post('message');
                $trans_type = 'TEST';
                $merchant_id = 'TEST';
                $merchant_name = 'TEST';  
                $account_no = 'TEST'; 
            };

            if(isset($_REQUEST['partial']))
            {
                $phoneno = "6".$this->input->post('phoneno');
                $message = $this->input->post('message');
                $trans_type = 'PARTIAL';
                $merchant_id = 'WEB_MEMBER';
                $merchant_name = 'WEB_MEMBER';  
                $account_no = $this->Sms_Model->search_account_by_contact($this->input->post('phoneno'))->row('account_no'); 
            };

            
            $provider = $setup->row('provider');
            $user = $setup->row('api_username');
            $pass = $setup->row('api_password');
            $sms_from = $setup->row('sender_id');
            $sms_to = $phoneno;
            $sms_msg = $message;
            $languagetype = $setup->row('languagetype');
            $url = $setup->row('url');

            $process = $this->Sms_Model->send_sms($url,$provider,$user,$pass,$sms_from,$sms_to,$sms_msg,$languagetype);
            

            $data = array(
                    'trans_guid' => $this->guid(),
                    'trans_type' => $trans_type,
                    'respond_code' => $process['code'],
                    'respond_message' => $process['respond_message'],
                    'merchant_id' => $merchant_id,
                    'merchant_name' => $merchant_name,
                    'account_no' => $account_no,
                    'mobile_no' => $process['mobileno'],
                    'message' => $process['message'],
                    'status' => $process['status'],
                    'date' => $this->db->query("SELECT CURDATE() AS date")->row('date'),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION["username"],
                    'provider' => $provider,
                    'sending_template' => '',
                    'sending_session' => $_SESSION['sending_session'],
                    );

            $send_sms = $this->db->insert('sms_transaction', $data);
            //echo $this->db->last_query();die;
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Sms Respond = '.$process['respond_message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect('Sms_c/create_trans');
        }
        else
        {
            redirect('login_c');
        }

    }

    public function message_template()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $data = array(
                'title' => 'Message Template',
                'record' => $this->db->query("SELECT * FROM `sms_message` a;"),
            );

            $this->template->load('template' , 'sms_message_template', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function message_template_form()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $this->input->post('guid');
            $check_exist = $this->db->query("SELECT * FROM `sms_message` a WHERE a.`guid` = '$guid' order by a.updated_at desc ");

            if($check_exist->num_rows() == 0)//add process
            {
                $process = "Create";
                $data = array(
                    'guid' => $this->guid(),
                    'message' => $this->input->post('message'),
                    'template_name' => $this->input->post('template_name'),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $this->datetime(),
                    'updated_by' => $_SESSION['username'],
                    'set_active' => $this->input->post('set_active'),
                );

                $this->db->insert("sms_message",$data);
            }
            else// edit process
            {
                $process = "Update";
                $data = array(
                    'message' => $this->input->post('message'),
                    'template_name' => $this->input->post('template_name'),
                    'updated_at' => $this->datetime(),
                    'updated_by' => $_SESSION['username'],
                    'set_active' => $this->input->post('set_active'),
                );
                $this->db->where("guid", $guid);
                $this->db->update("sms_message", $data);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful '.$process.'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Sms_c/message_template");
        }
        else
        {
            redirect('login_c');
        }
    }


    public function contact_template()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $data = array(
                'title' => 'Contact Template',
                'record' => $this->db->query("SELECT * FROM `sms_contact` a order by a.updated_at desc;"),
                'record_c' => $this->db->query("SELECT * FROM `sms_contact_c` a ;"),
            );
            $this->template->load('template' , 'sms_contact_template', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function contact_c_list()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $get_template = $this->db->query("SELECT * FROM sms_contact a WHERE a.guid = '".$_REQUEST['guid']."' ");
            $data = array(
                'title' => 'Contact List <b>'.$get_template->row('template_name').'</b>',
                'record' => $this->db->query("SELECT * FROM `sms_contact_c` a WHERE a.contact_guid = '".$_REQUEST['guid']."'  order by a.updated_at desc;"),
            );
            $this->template->load('template' , 'sms_contact_template_list', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function contact_template_form()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $this->input->post('guid');
            $check_exist = $this->db->query("SELECT * FROM `sms_contact` a WHERE a.`guid` = '$guid' ");

            if($this->input->post('template_type') == 'QUERY')
            {
                // testing query
                $test_query = $this->db->query($this->input->post('query'));
                $error_sql = $this->db->error() ;
                // if have error than prompt 
                if($error_sql['message'] <> '')
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" style="font-size: 18px">Query Error :'.$error_sql['code'].''.$error_sql['message'].'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Sms_c/contact_template");
                };

                if($test_query->num_rows() == 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Query Return Null Result<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Sms_c/contact_template");
                };

            }

            if($check_exist->num_rows() == 0)//add process
            {
                $_SESSION['sms_contact_guid'] = $this->guid();
                $process = "Create";
                $data = array(
                    'guid' => $_SESSION['sms_contact_guid'],
                    'template_name' => $this->input->post('template_name'),
                    'template_type' => $this->input->post('template_type'),
                    'query' => $this->input->post('query'),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $this->datetime(),
                    'updated_by' => $_SESSION['username'],
                    'total_sending' => $this->input->post('set_active'),
                    'set_active' => $this->input->post('set_active'),
                );
                $this->db->insert("sms_contact",$data);

                if($this->input->post('template_type') == 'QUERY')
                {
                    $result = $this->db->query($this->input->post('query'));

                    foreach ($result->result() as $row) 
                    {   
                        $data = array(
                            'contact_guid' => $_SESSION['sms_contact_guid'],
                            'contact_c_guid' => $this->guid(),
                            'card_no' => $row->CardNo,
                            'account_no' => $row->AccountNo,
                            'name' => $row->Name,
                            'contact_no' => $this->replace_char_phoneno($row->Phonemobile),
                            'created_at' => $this->datetime(),
                            'created_by' => $_SESSION['username'],
                            'updated_at' => $this->datetime(),
                            'updated_by' => $_SESSION['username'],
                        );
                        $this->db->insert("sms_contact_c",$data);                   
                    }
                }

            }
            else// edit process
            {
                $process = "Update";
                $data = array(
                    'template_name' => $this->input->post('template_name'),
                    'template_type' => $this->input->post('template_type'),
                    'query' => $this->input->post('query'),
                    'updated_at' => $this->datetime(),
                    'updated_by' => $_SESSION['username'],
                    'set_active' => $this->input->post('set_active'),
                );
                $this->db->where("guid", $guid);
                $this->db->update("sms_contact", $data);

                if($check_exist->row('query') <> $this->input->post('query'))
                {
                    $delete_c = $this->db->query("DELETE a.* FROM `sms_contact_c` a WHERE a.contact_guid = '$guid'");

                    $result = $this->db->query($this->input->post('query'));
                    //echo $this->db->last_query();die;
                    foreach ($result->result() as $row) 
                    {   
                        $data = array(
                            'contact_guid' => $guid,
                            'contact_c_guid' => $this->guid(),
                            'card_no' => $row->CardNo,
                            'account_no' => $row->AccountNo,
                            'name' => $row->Name,
                            'contact_no' => $this->replace_char_phoneno($row->Phonemobile),
                            'created_at' => $this->datetime(),
                            'created_by' => $_SESSION['username'],
                            'updated_at' => $this->datetime(),
                            'updated_by' => $_SESSION['username'],
                        );
                        $this->db->insert("sms_contact_c",$data);                   
                    }
                }
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful '.$process.'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Sms_c/contact_template");
        }
        else
        {
            redirect('login_c');
        }

    }

    public function add_contact_template()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $get_template = $this->db->query("SELECT * FROM sms_contact a WHERE a.guid = '".$_REQUEST['guid']."' ");

            if(isset($_REQUEST['add_list']))
            {
                $get_account = $this->db->query("SELECT * FROM member a WHERE a.AccountNo = '".$_REQUEST['AccountNo']."'");
                $get_exist_list = $this->db->query("SELECT * FROM sms_contact_c a 
                    WHERE a.account_no = '".$_REQUEST['AccountNo']."' and a.contact_guid = '".$_REQUEST['guid']."' ");
                if($get_exist_list->num_rows() == 0)
                {
                    $data = array(
                        'contact_guid' => $_REQUEST['guid'],
                        'contact_c_guid' => $this->guid(),
                        'card_no' => $get_account->row('CardNo'),
                        'account_no' => $get_account->row('AccountNo'),
                        'name' => $get_account->row('Name'),
                        'contact_no' => $this->replace_char_phoneno($get_account->row('Phonemobile')),
                        'created_at' => $this->datetime(),
                        'created_by' => $_SESSION['username'],
                        'updated_at' => $this->datetime(),
                        'updated_by' => $_SESSION['username'],
                    );
                    $this->db->insert("sms_contact_c",$data);
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful Insert<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Already in template list<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                redirect('Sms_c/add_contact_template?guid='.$_REQUEST['guid']);
            };

            if(isset($_REQUEST['delete_list']))
            {
                $this->db->query("DELETE  FROM sms_contact_c WHERE contact_c_guid = '".$_REQUEST['contact_c_guid']."' ");
                //echo $this->db->last_query();die;
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful Delete<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Sms_c/add_contact_template?guid='.$_REQUEST['guid']);
            };


            $data = array(
                'title' => 'Add Contact List <b>'.$get_template->row('template_name').'</b>',
                'record' => $this->db->query("SELECT * FROM `sms_contact_c` a WHERE a.contact_guid = '".$_REQUEST['guid']."'  order by a.updated_at desc;"),
            );
            $this->template->load('template' , 'sms_add_contact_template', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function sending_template()
    {
       if($this->session->userdata('loginuser')== true)
        {
            $data = array(
                'title' => 'Sending Template',
                'record' => $this->db->query("SELECT * FROM `sms_sending_template` a ORDER BY a.`updated_at` DESC;"),
                'message_select' => $this->db->query("SELECT * FROM `sms_message` a WHERE a.`set_active` = '1';"),
                'contact_select' => $this->db->query("SELECT * FROM `sms_contact` a WHERE a.`set_active` = '1';"),
            );
            $this->template->load('template' , 'sms_sending_template', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function sending_template_form()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $this->input->post('guid');
            $check_exist = $this->db->query("SELECT * FROM `sms_sending_template` a WHERE a.`guid` = '$guid' order by a.updated_at desc ");

            if($this->input->post('message_select') == 'Select Template' || $this->input->post('contact_select') == 'Select Template')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Please select valid template<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Sms_c/sending_template");
            }

            $get_message = $this->db->query("SELECT * FROM `sms_message` a WHERE a.`guid` = '".$this->input->post('message_select')."' ");

            $get_contact = $this->db->query("SELECT * FROM `sms_contact` a WHERE a.`guid` = '".$this->input->post('contact_select')."' ");

            if($check_exist->num_rows() == 0)//add process
            {

                $process = "Create";
                $data = array(
                    'guid' => $this->guid(),
                    'template_name' => $this->input->post('template_name'),
                    'message_guid' => $this->input->post('message_select'),
                    'message' => $get_message->row('template_name'),
                    'contact_guid' => $this->input->post('contact_select'),
                    'contact' => $get_contact->row('template_name'),
                    'created_at' => $this->datetime(),
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $this->datetime(),
                    'updated_by' => $_SESSION['username'],
                    'set_active' => $this->input->post('set_active'),
                );

                $this->db->insert("sms_sending_template",$data);
            }
            else// edit process
            {
                $process = "Update";
                $data = array(
                    'template_name' => $this->input->post('template_name'),
                    'message_guid' => $this->input->post('message_select'),
                    'message' => $get_message->row('template_name'),
                    'contact_guid' => $this->input->post('contact_select'),
                    'contact' => $get_contact->row('template_name'),
                    'updated_at' => $this->datetime(),
                    'updated_by' => $_SESSION['username'],
                    'set_active' => $this->input->post('set_active'),
                );
                $this->db->where("guid", $guid);
                $this->db->update("sms_sending_template", $data);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Successful '.$process.'<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect("Sms_c/sending_template");
        }
        else
        {
            redirect('login_c');
        }
    } 

    public function sending_list()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $get_template = $this->db->query("SELECT * FROM sms_sending_template a WHERE a.guid = '".$_REQUEST['guid']."' ");
            $data = array(
                'title' => 'Sending List <b>'.$get_template->row('template_name').'</b>',
            );
            $this->template->load('template' , 'sms_sending_list', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function transaction()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $data = array(
                'title' => 'Transaction History',
            );
            $this->template->load('template' , 'sms_transaction', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function all_member()
    {
        // if query for sending template list
        if(isset($_REQUEST['sending_list']))
        {
            $query = $this->Sms_Model->sending_list_count($_REQUEST['template_guid']);
        }
        else
        {
            $query = $this->db->query("SELECT COUNT(*) AS num FROM (
                   SELECT CardNo FROM member WHERE accountno NOT IN (SELECT accountno FROM membersupcard ) 
                    UNION ALL              
                    SELECT b.SupCardNo AS CardNo FROM member a 
                    INNER JOIN membersupcard b 
                    ON a.accountno = b.accountno)a");
        }

        // if query for sending template list
        if(isset($_REQUEST['sending_list']))
        {
            
            $columns = array(
                0 => 'Message',
                1 => 'Characters',
                2 => 'TotalSms',
                3 => 'PhoneNo',
                4 => 'AccountNo',
                5 => 'Name',
            );
        }
        else
        {
            $columns = array(
                0 => 'CardNo',
                1 => 'AccountNo',
                2 => 'Expirydate',
                3 => 'ICNo',
                4 => 'Phonemobile',
                5 => 'Name',
                6 => 'Action',
            );
        }


        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalFiltered = $totalData = $query->row('num');
        

        if(empty($this->input->post('search')['value']))
        {
            if(isset($_REQUEST['sending_list']))
            {
                $posts = $this->Sms_Model->sending_list($_REQUEST['template_guid'],$limit,$start,$dir,$order)->result();
            }
            else
            {
                $posts = $this->Trans_Model->allposts_sms($limit,$start,$dir,$order);
            }
            //echo $this->db->last_query();die;
        }
        else
        {
            if(isset($_REQUEST['sending_list']))
            {
                $search = $this->input->post('search')['value'];
                $posts = $this->Sms_Model->sending_list_search($_REQUEST['template_guid'],$limit,$start,$dir,$order,$search);
                $totalFiltered = $this->Sms_Model->sending_list_search_count($_REQUEST['template_guid'],$limit,$start,$dir,$order,$search)->num_rows();
            }
            else
            {
                $search = $this->input->post('search')['value'];
                $posts = $this->Trans_Model->allpost_sms_search($limit,$start,$dir,$order,$search);
                $totalFiltered = $this->Trans_Model->allpost_sms_search_count($limit,$start,$dir,$order,$search)->num_rows();
            }

        }
        
        $data = array();
        if(!empty($posts))
        {

            foreach ($posts as $post)
                {
                    if(isset($_REQUEST['sending_list']))
                    {
                        $nestedData['Message'] = $post->decode_message;
                        $nestedData['Characters'] = $post->total_char;
                        $nestedData['TotalSms'] = $post->total_sms;
                        $nestedData['PhoneNo'] = $post->contact_no;
                        $nestedData['AccountNo'] = $post->account_no;
                        $nestedData['Name'] = $post->name;
                    }
                    else
                    {
                        $nestedData['CardNo'] = $post->CardNo;
                        $nestedData['AccountNo'] = $post->AccountNo;
                        $nestedData['Expirydate'] = $post->Expirydate;
                        $nestedData['ICNo'] = $post->ICNo;
                        $nestedData['Phonemobile'] = $post->Phonemobile;
                        $nestedData['Name'] = $post->Name;
                        $nestedData['Action'] = '<center><a href="'.site_url('Sms_c/add_contact_template').'?add_list&AccountNo='.$post->AccountNo.'&guid='.$_REQUEST['template_guid'].'"><button title="Add to List" type="button" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-plus"></i></button></a>&ensp;</center>';
                    }

                    $data[] = $nestedData;

                }
        }
        
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }

    public function sms_transaction()
    {

        $query = $this->db->query("SELECT COUNT(*) AS num FROM `sms_transaction` a");

            $columns = array(
                0 => 'TransType',
                1 => 'PhoneNo',
                2 => 'AccountNo',
                3 => 'Message',
                4 => 'Status',
                5 => 'Code',
                6 => 'Date',
                7 => 'CreatedBy',
            );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalFiltered = $totalData = $query->row('num');
        

        if(empty($this->input->post('search')['value']))
        {
            $posts = $this->Sms_Model->sms_transaction_all($limit,$start,$dir,$order)->result();
        }
        else
        {
            $search = $this->input->post('search')['value'];
            $posts = $query =  $this->Sms_Model->sms_transaction_search($search,$limit,$start,$dir,$order)->result();
            $totalFiltered = $this->Sms_Model->sms_transaction_search($search,$limit,$start,$dir,$order)->num_rows();

        }
        
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
                {
                    
                    $nestedData['TransType'] = $post->TransType;
                    $nestedData['PhoneNo'] = $post->mobile_no;
                    $nestedData['AccountNo'] = $post->account_no;
                    $nestedData['Message'] = $post->message;
                    $nestedData['Status'] = $post->sending_status;
                    $nestedData['Code'] = $post->respond_code;
                    $nestedData['Date'] = $post->date;
                    $nestedData['CreatedBy'] = $post->created_by;
                    

                    $data[] = $nestedData;

                }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }
}
?>