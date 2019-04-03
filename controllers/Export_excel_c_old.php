<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_excel_c extends CI_Controller {
    
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
        if($this->session->userdata('loginuser')== true)
        {
            if(isset($_REQUEST['search']))
            {
                if($this->input->post('search_mode') == 'Expiry')
                {
                    $_SESSION['search_type'] = 'BRANCH';
                    $search_data = $this->db->query("SELECT * FROM member a WHERE a.`Expirydate` BETWEEN '".$this->input->post('expiryfrom')."' AND '".$this->input->post('expiryto')."' LIMIT 1000");
                    $_SESSION['query'] = "WHERE a.`Expirydate` BETWEEN '".$this->input->post('expiryfrom')."' AND '".$this->input->post('expiryto')."'";
                };

                if($this->input->post('search_mode') == 'Issue')
                {
                    $_SESSION['search_type'] = 'BRANCH';
                    $search_data = $this->db->query("SELECT * FROM member a WHERE a.`Issuedate` BETWEEN '".$this->input->post('issuefrom')."' AND '".$this->input->post('issueto')."' LIMIT 1000");
                    $_SESSION['query'] = "WHERE a.`Issuedate` BETWEEN '".$this->input->post('issuefrom')."' AND '".$this->input->post('issueto')."'";
                };

                if($this->input->post('search_mode') == 'Branch')
                {
                    $this->form_validation->set_rules('branch[]', 'Branch', 'trim|required');
            
                    if($this->form_validation->run() == FALSE)
                    {
                        $search_data = $this->db->query("SELECT * FROM member a WHERE a.`branch` = 'paloi' LIMIT 1000;");
                        $_SESSION['query'] = "WHERE a.`branch` = 'paloi';";
                    }
                    else
                    {
                        $condition = implode("', '", $this->input->post('branch'));
                        $_SESSION['search_type'] = 'BRANCH';
                        $search_data = $this->db->query("SELECT * FROM member a WHERE a.`branch` IN ('$condition')  LIMIT 1000;");
                        $_SESSION['query'] = "WHERE a.`branch` IN ('$condition');";
                    }
                   
                };

                if($this->input->post('search_mode') == 'Merchant')
                {
                    $this->form_validation->set_rules('merchant[]', 'Merchant', 'trim|required');
            
                    if($this->form_validation->run() == FALSE)
                    {
                        $search_data = $this->db->query("SELECT * FROM member a WHERE a.`branch` = 'paloi' LIMIT 1000;");
                        $_SESSION['query'] = "WHERE a.`branch` = 'paloi';";
                    }
                    else
                    {
                        $condition = implode("', '", $this->input->post('merchant'));
                        $_SESSION['search_type'] = 'MERCHANT';
                        $search_data = $this->db->query("SELECT * FROM member a INNER JOIN member_merchantcard b ON a.`CardNo` = b.`CardNo` WHERE b.`merchant_id` IN ('$condition') LIMIT 1000;");
                        $_SESSION['query'] = "WHERE a.CardNo IN (SELECT a.`CardNo` FROM member_merchantcard a WHERE a.`merchant_id` IN ('$condition') );";
                        //echo $this->db->last_query();die;
                    }
                };
            }
            else
            {
                $search_data = $this->db->query("SELECT * FROM member a WHERE a.`branch` = 'paloi' LIMIT 1000;");
                $_SESSION['query'] = "WHERE a.`branch` = 'paloi';";
            }

            $data = array(
                'username' => $_SESSION['username'],
                'userpass' => $_SESSION['userpass'],
                'module_group_guid' => $_SESSION['module_group_guid'],
            );

            $branch = array();
            $result = $this->Member_Model->query_call('Export_excel_c', 'index', $data);

            if(isset($result['branch']))
            {
                $branch = $result['branch'];
            }

            $data = array(
                // 'branch' => $this->db->query("SELECT DISTINCT branch_code, branch_name FROM panda_b2b.set_user AS a INNER JOIN panda_b2b.acc_branch AS b ON a.branch_guid = b.branch_guid WHERE user_id = '".$_SESSION['username']."' AND user_password = '".$_SESSION['userpass']."' AND a.isactive = '1' AND module_group_guid = '".$_SESSION['module_group_guid']."' ORDER BY branch_code ASC"),
                'branch' => $branch,
                'merchant' => $this->db->query("SELECT * FROM member_merchantcard a GROUP BY a.`merchant_id`"),
                'search_data' => $search_data,
            );

            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0); 
            ini_set('memory_limit','2048M');

            $this->template->load('template' , 'export_excel', $data);
        }
        else
        {
            redirect('login_c');
        }
    }

    public function export_excel()
    {
        $query = $this->db->query("SELECT 
                    AccountNo,
                    CardNo,
                    Name,
                    NameOnCard,
                    Address1,
                    Address2,
                    Address3,
                    Address4,
                    City,
                    State,
                    Postcode,
                    Email,
                    Phonehome,
                    Phoneoffice,
                    Phonemobile,
                    Fax,
                    Issuedate,
                    Expirydate,
                    Cardtype,
                    Title,
                    ICNo,
                    OldICNo,            
                    Occupation,
                    Employer,
                    Birthdate,
                    Principal,
                    Active,
                    Nationality,
                    Pointsbalance,
                    /*Expirydate,
                    Issuedate,*/
                    branch FROM member a ".$_SESSION['query']);

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('Member Report.csv', $data);
    }

    public function export_sms_trans()
    {
        //echo $this->input->post('date_from');die;
        $query = $this->db->query("SELECT
              `trans_type`,
              `respond_code`,
              `respond_message`,
              `account_no`,
              `mobile_no`,
              `message`,
              `status`,
              `date`,
              `created_at`,
              `created_by`,
              `provider`
            FROM `sms_transaction` a
            WHERE a.`date` BETWEEN '".$this->input->post('date_from')."' AND '".$this->input->post('date_to')."'
            ORDER BY a.`created_at` DESC;");

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('Sms Trans ('.$this->input->post('date_from').' to '.$this->input->post('date_to').').csv', $data);
    }

    /*public function export_excel()
    {
        $query = $this->db->query("SELECT 
                    AccountNo,
                    CardNo,
                    Name,
                    NameOnCard,
                    Address1,
                    Address2,
                    Address3,
                    Address4,
                    City,
                    State,
                    Postcode,
                    Email,
                    Phonehome,
                    Phoneoffice,
                    Phonemobile,
                    Fax,
                    Issuedate,
                    Expirydate,
                    Cardtype,
                    Title,
                    ICNo,
                    OldICNo,            
                    Occupation,
                    Employer,
                    Birthdate,
                    Principal,
                    Active,
                    Nationality,
                    Pointsbalance,
                    /*Expirydate,
                    Issuedate,*/
                    /*branch FROM backend_member.member a ".$_SESSION['query']);

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        
        $data = $query->result_array();

        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Member Report');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'AccountNo ');
        $this->excel->getActiveSheet()->setCellValue('B1', 'CardNo ');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Name ');
        $this->excel->getActiveSheet()->setCellValue('D1', 'NameOnCard');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Address1 ');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Address2');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Address3 ');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Address4 ');
        $this->excel->getActiveSheet()->setCellValue('I1', 'City');
        $this->excel->getActiveSheet()->setCellValue('J1', 'State ');
        $this->excel->getActiveSheet()->setCellValue('K1', 'Postcode ');
        $this->excel->getActiveSheet()->setCellValue('L1', 'Email ');
        $this->excel->getActiveSheet()->setCellValue('M1', 'Phonehome ');
        $this->excel->getActiveSheet()->setCellValue('N1', 'Phoneoffice');
        $this->excel->getActiveSheet()->setCellValue('O1', 'Phonemobile ');
        $this->excel->getActiveSheet()->setCellValue('P1', 'FaxNo');
        $this->excel->getActiveSheet()->setCellValue('Q1', 'Issuedate');
        $this->excel->getActiveSheet()->setCellValue('R1', 'Expirydate');
        $this->excel->getActiveSheet()->setCellValue('S1', 'Cardtype');
        $this->excel->getActiveSheet()->setCellValue('T1', 'Title ');
        $this->excel->getActiveSheet()->setCellValue('U1', 'ICNo');
        $this->excel->getActiveSheet()->setCellValue('V1', 'OldICNo ');
        $this->excel->getActiveSheet()->setCellValue('W1', 'Occupation ');
        $this->excel->getActiveSheet()->setCellValue('X1', 'Employer');
        $this->excel->getActiveSheet()->setCellValue('Y1', 'Birthdate ');
        $this->excel->getActiveSheet()->setCellValue('Z1', 'Principal ');
        $this->excel->getActiveSheet()->setCellValue('AA1', 'Active ');
        $this->excel->getActiveSheet()->setCellValue('AB1', 'Nationality ');
        $this->excel->getActiveSheet()->setCellValue('AC1', 'PointsBalance ');
        /*$this->excel->getActiveSheet()->setCellValue('AD1', 'ExpiryDate ');
        $this->excel->getActiveSheet()->setCellValue('AE1', 'IssueDate ');*/
        /*$this->excel->getActiveSheet()->setCellValue('AD1', 'Branch ');
        
        $this->excel->getActiveSheet()->fromArray($data, ' ', 'A2');

        $filename='Member Report.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        ob_end_clean();
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }*/

    public function export_purchase_detail()
    {
        $AccountNo = $_REQUEST['AccountNo'];

        $data = array(
            'accountno' => $AccountNo,
        );

        $result = $this->Member_Model->query_call('Export_excel_c', 'export_purchase_detail', $data);

        // $query = $this->db->query("SELECT a.refno,CONCAT(a.sysdate,' ',a.systime) AS transdate,b.`description`, 
        //     ROUND(b.amount_after_tax/IF(b.soldbyweight = 1 AND b.barcodetype = 'P',ROUND(b.weightvalue,4),b.qty),2) AS price, 
        //     IF(b.soldbyweight = 1 AND b.barcodetype = 'P',ROUND(b.weightvalue,4),b.qty) AS qty,ROUND(b.amount_after_tax,2) AS total
        //     FROM frontend.posmain a 
        //     INNER JOIN frontend.poschild b ON a.refno = b.refno 
        //     WHERE a.`AccountNo` = '".$AccountNo."' AND a.billstatus = 1 AND b.void = 0 
        //     ORDER BY a.bizdate DESC,a.refno,b.line");

        // $data = $query->result_array();

        $query = array();

        if(isset($result['data']))
        {
            $query = $result['data'];
        }

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';
        $out = "";

        $line = array();
        foreach (array_keys($query[0]) as $key)
        {
            $line[] = $enclosure.str_replace($enclosure, $enclosure.$enclosure, $key).$enclosure;
        }
        $out .= implode($delimiter, $line).$newline;


        foreach ($query as $item)
        {
            $line = array();
            foreach(array_keys($item) as $key)
            {
                $line[] = $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item[$key]).$enclosure;
            }
            $out .= implode($delimiter, $line).$newline;
        }
        
        // $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('Purchase Details Report.csv', $out);
    }

    public function export_ewallet_purchase_detail()
    {
        $AccountNo = $_REQUEST['AccountNo'];

        $data = array(
            'accountno' => $AccountNo,
        );

        $result = $this->Member_Model->query_call('Export_excel_c', 'export_ewallet_purchase_detail', $data);

        // $query = $this->db->query("SELECT a.refno,CONCAT(a.sysdate,' ',a.systime) AS transdate,b.`description`, 
        //     ROUND(b.amount_after_tax/IF(b.soldbyweight = 1 AND b.barcodetype = 'P',ROUND(b.weightvalue,4),b.qty),2) AS price, 
        //     IF(b.soldbyweight = 1 AND b.barcodetype = 'P',ROUND(b.weightvalue,4),b.qty) AS qty,ROUND(b.amount_after_tax,2) AS total
        //     FROM frontend.posmain a 
        //     INNER JOIN frontend.poschild b ON a.refno = b.refno 
        //     WHERE a.`AccountNo` = '".$AccountNo."' AND a.billstatus = 1 AND b.void = 0 
        //     ORDER BY a.bizdate DESC,a.refno,b.line");

        // $data = $query->result_array();

        $query = array();

        if(isset($result['data']))
        {
            $query = $result['data'];
        }

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';
        $out = "";

        $line = array();
        foreach (array_keys($query[0]) as $key)
        {
            $line[] = $enclosure.str_replace($enclosure, $enclosure.$enclosure, $key).$enclosure;
        }
        $out .= implode($delimiter, $line).$newline;


        foreach ($query as $item)
        {
            $line = array();
            foreach(array_keys($item) as $key)
            {
                $line[] = $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item[$key]).$enclosure;
            }
            $out .= implode($delimiter, $line).$newline;
        }
        
        // $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('Purchase Details Report.csv', $out);
    }

    public function import()
    {

    }

}
?>