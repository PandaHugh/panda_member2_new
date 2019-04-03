<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trans_Model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
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

    function terminate_card($accountno,$name,$pointbalance,$point_adjust,$branch,$cardno)
    {
                //add transaction
        $_SESSION['trans_guid'] = $this->guid();

        $datachild = array(
                    'CHILD_GUID' => $this->guid(),
                    'TRANS_GUID' => $_SESSION['trans_guid'],
                    'ITEMCODE' => $accountno,
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

                $data = array(
                    'TRANS_GUID' => $_SESSION['trans_guid'],
                    'TRANS_TYPE' => 'POINT_ADJ_OUT',
                    'REF_NO' => $this->get_point_trans_ref_no_terminate()->row('ref_no'),
                    'TRANS_DATE' => $this->date(),
                    'SUP_CODE' => $accountno,
                    'SUP_NAME' => $name,
                    'REMARK' => '',
                    'VALUE_TOTAL' => $point_adjust,
                    'CREATED_AT' => $this->datetime(),
                    'CREATED_BY' => $_SESSION['username'],
                    'UPDATED_AT' => $this->datetime(),
                    'UPDATED_BY' => $_SESSION['username'],
                    'reason' => 'TERMINATE',
                    'point_curr' => $pointbalance,
                    'branch' => $branch,
                    'send_outlet' => '0',
                    'cardno' => $cardno,
                    'POSTED' => '1',
                    );
                $this->db->insert('trans_main', $data);

                $memberdata = array (
                    'ICNo' => 'TERMINATE',
                    'PassportNo' => 'TERMINATE',
                    'Pointsbalance' => $pointbalance,
                );
                $this->db->where('accountno',$accountno);
                $this->db->update('member',$memberdata);
    }

    function get_point_trans_ref_no_terminate()
    {
        $result = $this->db->query("SELECT CONCAT('PAT',SUBSTRING(REPLACE(CURDATE(),'-',''),-8),a.run_no) AS ref_no FROM (SELECT IFNULL(MAX(LPAD(RIGHT(REF_NO,'4')+1,'4',0)),LPAD(1,'4',0)) AS run_no FROM `trans_main` a WHERE LEFT(a.`REF_NO`,3) = 'PAT' AND SUBSTRING(REF_NO,-10,6) = SUBSTRING(REPLACE(CURDATE(),'-',''),-6,6))a;");
        return $result;
    }

    function generate_card_no($branch)
    {
            $get_setup = $this->db->query("SELECT LEFT(a.`card_date`,4) AS year_format,LEFT(a.`card_date`,7) AS month_format, a.* FROM `set_branch_parameter` a WHERE a.`branch_code` = '$branch' ");
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
                    ) AS refno FROM `set_branch_parameter` a WHERE a.`branch_code` = '$branch' ")->row('refno');

            return $account_no;
    }

    function validate_ic_no($icno)
    {
        $icno_format = $this->db->query("SELECT CONCAT(LEFT('$icno', 6), '-', SUBSTRING('$icno', 7, 2), '-', RIGHT('$icno', 4)) AS icno ")->row('icno');

        $curyear = $this->db->query("SELECT DATE_FORMAT(CURDATE(), '%y') AS `curyear` ")->row('curyear');
        $icyear = $this->db->query("SELECT LEFT('$icno_format', 2) AS `year` ")->row('year');

        if($icyear >= '00' && $icyear <= $curyear)
        {
            $birthdate = $this->db->query("SELECT CONCAT('20', LEFT('$icno_format', 2), '-', SUBSTRING('$icno_format', 3, 2), '-', SUBSTRING('$icno_format', 5, 2)) AS birthdate ")->row('birthdate');
        }
        else
        {
            $birthdate = $this->db->query("SELECT CONCAT('19', LEFT('$icno_format', 2), '-', SUBSTRING('$icno_format', 3, 2), '-', SUBSTRING('$icno_format', 5, 2)) AS birthdate ")->row('birthdate');
        }

        $check_month_ic_no = $this->db->query("SELECT MID('".$icno_format."', 3, 2) as month")->row('month');
        $check_day_ic_no = $this->db->query("SELECT MID('".$icno_format."', 5, 2) as day")->row('day');

        if($check_month_ic_no > 12 || $check_day_ic_no > 31)
        {
            return 'Error';
        }
        else
        {
            return $icno_format;
        }
    }

    function get_check_degit($no)
    {
        $query = $this->db->query("SELECT CONCAT('$no', RIGHT(10-MOD(MID('$no', 1, 1) + MID('$no', 3, 1) + MID('$no', 5, 1) + MID('$no', 7, 1) + MID('$no', 9, 1) + MID('$no', 11, 1) + ((MID('$no', 2, 1) + MID('$no', 4, 1) + MID('$no', 6, 1) + MID('$no', 8, 1) + MID('$no', 10, 1) + MID('$no', 12, 1))*3), 10), 1)) AS check_digit ");
        return $query->row('check_digit');
    }
    
    function check_receipt_no_child($refno)
    {
        // script join web module setup
        $sql = "SELECT a.`BillAmt`,b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND b.Refno = '$refno' LIMIT 0, 500";
        $query = $this->db->query($sql);
        return $query;
    }

    function check_receipt_no_main($refno)
    {
        $sql = "SELECT a.`BillAmt`, a.BizDate FROM frontend.posmain a WHERE a.VoidFromRefNo = '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND a.Refno = '$refno' LIMIT 0, 500";
        $query = $this->db->query($sql);
        return $query;
    }
    
    function check_receipt_void_no_child($refno)
    {
        // script join web module setup
        $sql = "SELECT a.`BillAmt`,b.* FROM frontend.posmain a INNER JOIN frontend.poschild b ON a.RefNo = b.Refno WHERE a.VoidFromRefNo <> '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND a.BillAmt < 0 AND b.Refno = '$refno'";
        $query = $this->db->query($sql);
        return $query;
    }

    function check_receipt_void_no_main($refno)
    {
        $sql = "SELECT a.`BillAmt`, a.BizDate FROM frontend.posmain a WHERE a.VoidFromRefNo <> '' AND a.SalesType = 'SALES' AND a.BillStatus = '1' AND a.BillAmt < 0 AND a.Refno = '$refno'";
        $query = $this->db->query($sql);
        return $query;
    }

    function allposts($limit,$start,$dir,$order)
    {
        if($_SESSION['user_group'] == 'MERCHANT GROUP')
        {
            $query = $this->db->query("SELECT * FROM member WHERE CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') ORDER BY $order $dir LIMIT $start, $limit");
        }
        else
        {
            $query = $this->db->query("SELECT * FROM (
               SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name` FROM member WHERE accountno NOT IN (SELECT accountno FROM membersupcard ) 
                UNION ALL              
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM member a 
                INNER JOIN membersupcard b 
                ON a.accountno = b.accountno)a ORDER BY $order $dir LIMIT $start, $limit");
        }
        return $query->result();
    }

    function allposts_member($limit,$start,$dir)
    {
            if ($limit == '')
            {
                $limit = 1;
            };

            if ($start == '')
            {
                $start =1 ;
            };

            $query = $this->db->query("SELECT a.CardNo, a.AccountNo, a.Expirydate, a.ICNo, a.Phonemobile, a.`Name`,acc_balance as Credit from member as a inner join member_wallet as b on a.accountno = b.accountno LIMIT $start, $limit");
        
        return $query->result();
    }

    function wallet_search_key($limit,$start,$dir,$search,$key)
    {
        if($search == 'General')
        {
            $query = $this->db->query("SELECT a.*, b.acc_balance as Credit FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE NAME LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE cardno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE accountno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE icno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE oldicno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE passportno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Phonemobile LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Address1 LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");

            //echo $this->db->last_query();die;
        };

        if($search == 'Card')
        {
            // $result = $this->db->query("SELECT IF((SELECT COUNT(*) FROM membersupcard WHERE SupCardNo like '%$key%')>0 , 'true', 'false') AS result ")->row('result');

            // if($result == 'true')
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM membersupcard WHERE SupCardNo LIKE '%$key%' ");
            // }
            // else
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM member WHERE CardNo LIKE '%$key%' ");
            // }

            $query = $this->db->query("SELECT a.*, b.acc_balance as Credit FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE cardno LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno ");
        };

        if($search == 'Account')
        {
            $query = $this->db->query("SELECT a.*, b.acc_balance as Credit FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE accountno LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno ");
        };

        if($search == 'Name')
        {
            $query = $this->db->query("SELECT a.*, b.acc_balance as Credit FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Name LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
        };

        if($search == 'Passport')
        {
            $query = $this->db->query("SELECT a.*, b.acc_balance as Credit FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE PassportNo LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno ");
        };

        if($search == 'Ic')
        {
            $query = $this->db->query("SELECT a.*, b.acc_balance as Credit FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE ICNo LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
        };

        if($search == 'Phone')
        {
            $query = $this->db->query("SELECT a.*, b.acc_balance as Credit FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Phonemobile LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno ");
        };

        if($search == 'Address')
        {
            $query = $this->db->query("SELECT a.*, b.acc_balance as Credit FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Address1 LIKE '%$key%')a  
                    INNER JOIN member_wallet b ON a.AccountNo = b.accountno GROUP BY a.accountno");
        };
        return $query->result();
    }

    function allposts_1($limit,$start,$dir,$search,$key)
    {
        if($search == 'General')
        {
            $query = $this->db->query("SELECT * FROM (
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE NAME LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE cardno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE accountno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE icno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE oldicno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE passportno LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Phonemobile LIKE '%$key%' 
                UNION ALL
                SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Address1 LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, IF(PrincipalCardNo = 'LOSTCARD', a.Name, b.Name) AS NAME FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' )a1  GROUP BY accountno");

            //echo $this->db->last_query();die;
        };

        if($search == 'Card')
        {
            // $result = $this->db->query("SELECT IF((SELECT COUNT(*) FROM membersupcard WHERE SupCardNo like '%$key%')>0 , 'true', 'false') AS result ")->row('result');

            // if($result == 'true')
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM membersupcard WHERE SupCardNo LIKE '%$key%' ");
            // }
            // else
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM member WHERE CardNo LIKE '%$key%' ");
            // }

            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name` FROM member WHERE CardNo like '%$key%' UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, IF(PrincipalCardNo = 'LOSTCARD', a.Name, b.Name) AS NAME FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' ");
        };

        if($search == 'Account')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE AccountNo LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, IF(PrincipalCardNo = 'LOSTCARD', a.Name, b.Name) AS NAME FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.AccountNo LIKE '%$key%' ");
        };

        if($search == 'Name')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Name like '%$key%' UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, IF(PrincipalCardNo = 'LOSTCARD', a.Name, b.Name) AS NAME FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.Name LIKE '%$key%'");
        };

        if($search == 'Passport')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE PassportNo like '%$key%' ");
        };

        if($search == 'Ic')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE ICNo like '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, IF(PrincipalCardNo = 'LOSTCARD', a.Name, b.Name) AS NAME FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.ICNo LIKE '%$key%'");
        };

        if($search == 'Phone')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Phonemobile LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, IF(PrincipalCardNo = 'LOSTCARD', a.Name, b.Name) AS NAME FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.Phonemobile LIKE '%$key%' ");
        };

        if($search == 'Address')
        {
            $query = $this->db->query("SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`FROM member WHERE Address1 LIKE '%$key%' 
                UNION ALL
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, IF(PrincipalCardNo = 'LOSTCARD', a.Name, b.Name) AS NAME FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.Address1 LIKE '%$key%';");
        };
        return $query->result();
    }

    function allposts_2($limit,$start,$dir,$search,$key)
    {
        if($search == 'General')
        {
            $query = $this->db->query("SELECT * FROM (
                SELECT * FROM member WHERE NAME LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM member WHERE cardno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM member WHERE accountno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM member WHERE icno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM member WHERE oldicno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM member WHERE passportno LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM member WHERE Phonemobile LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                UNION ALL
                SELECT * FROM member WHERE Address1 LIKE '%$key%'
                 AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') 
                UNION ALL
                SELECT a.* FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno 
                WHERE supcardno LIKE '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."'))a1  
                GROUP BY accountno");

            //echo $this->db->last_query();die;
        };

        if($search == 'Card')
        {
            // $result = $this->db->query("SELECT IF((SELECT COUNT(*) FROM membersupcard WHERE SupCardNo like '%$key%')>0 , 'true', 'false') AS result ")->row('result');

            // if($result == 'true')
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM membersupcard WHERE SupCardNo LIKE '%$key%' ");
            // }
            // else
            // {
            //     $data['data'] = $this->db->query("SELECT * FROM member WHERE CardNo LIKE '%$key%' ");
            // }

            $query = $this->db->query("SELECT * FROM member WHERE CardNo like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' )UNION ALL
                    SELECT a.* FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' ");
        };

        if($search == 'Account')
        {
            $query = $this->db->query("SELECT * FROM member WHERE AccountNo like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') UNION ALL
                    SELECT a.* FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.AccountNo LIKE '%$key%' ");
        };

        if($search == 'Name')
        {
            $query = $this->db->query("SELECT * FROM member WHERE Name like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' )UNION ALL
                    SELECT a.* FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.Name LIKE '%$key%'");
        };

        if($search == 'Passport')
        {
            $query = $this->db->query("SELECT * FROM member WHERE PassportNo like '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' ");
        };

        if($search == 'Ic')
        {
            $query = $this->db->query("SELECT * FROM member WHERE ICNo like '%$key%' 
                    AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."') UNION ALL
                    SELECT a.* FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.ICNo LIKE '%$key%'");
        };

        if($search == 'Phone')
        {
            $query = $this->db->query("SELECT * FROM member WHERE Phonemobile LIKE '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."' )
                    UNION ALL
                    SELECT a.* FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.Phonemobile LIKE '%$key%' ");
        };

        if($search == 'Address')
        {
            $query = $this->db->query("SELECT * FROM member WHERE Address1 LIKE '%$key%' AND CardNo IN (SELECT CardNo FROM member_merchantcard WHERE merchant_id = '".$_SESSION['branch_code']."')
                    UNION ALL
                    SELECT a.* FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE a.Address1 LIKE '%$key%';");
        };
        return $query->result();
    }

    function allposts_sms($limit,$start,$dir,$order)
    {
            
            /*$limit = '10';
            $start = '0';
            $dir = 'CardNo';
            $order = 'DESC';
*/
            $query = $this->db->query("SELECT * FROM (
               SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name` FROM member
                UNION ALL              
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM member a 
                INNER JOIN membersupcard b 
                ON a.accountno = b.accountno)a ORDER BY $order $dir LIMIT $start, $limit ");            
            //ho $this->db->last_query();die;
            if($query->num_rows() > 0)
            {
                return $query->result();
            }
            else
            {
                return null;
            }
    }

    function allpost_sms_search($limit,$start,$dir,$order,$search)
    {
        $query = $this->db->query("SELECT * FROM (
               SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name` FROM member 
                UNION ALL              
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM member a 
                INNER JOIN membersupcard b 
                ON a.accountno = b.accountno)a 
                WHERE a.CardNo LIKE '%$search%'
                OR a.Name LIKE '%$search%' 
                OR a.AccountNo LIKE '%$search%' 
                OR a.Expirydate LIKE '%$search%' 
                OR a.ICNo LIKE '%$search%'
                OR a.Phonemobile LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $limit ");            
            //ho $this->db->last_query();die;
        if($query->num_rows() == 0)
            {
                return null;
                
            }
            else
            {
                return $query->result();
            }
    }

    function allpost_sms_search_count($limit,$start,$dir,$order,$search)
    {
        $query = $this->db->query("SELECT * FROM (
               SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name` FROM member 
                UNION ALL              
                SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name FROM member a 
                INNER JOIN membersupcard b 
                ON a.accountno = b.accountno)a 
                WHERE a.CardNo LIKE '%$search%'
                OR a.Name LIKE '%$search%' 
                OR a.AccountNo LIKE '%$search%' 
                OR a.Expirydate LIKE '%$search%' 
                OR a.ICNo LIKE '%$search%'
                OR a.Phonemobile LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $limit ");            
            //$this->db->last_query();die;
        return $query;
            
    }

}

?> 