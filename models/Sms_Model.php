<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_Model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}

    public function search_account_by_contact($contact_no)
    {
        $query = $this->db->query("SELECT IF(COUNT(*) = 1,a.AccountNo,'NOTFOUND') AS account_no FROM(
        SELECT a.`AccountNo` FROM `member` a WHERE a.`Phonemobile` = '$contact_no'
        UNION ALL
        SELECT `AccountNo`FROM `membersupcard`  WHERE Phonemobile = '$contact_no')a LIMIT 1; ");
        return $query;
    }

    public function sending_list_all($guid)
    {
        $query = $this->db->query("SELECT a1.*,a11.url,a11.`provider`,a11.`api_username`,a11.`api_password`,a11.`sender_id`,a11.`languagetype` FROM(
        SELECT 
        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE (a1.message, '@account_no', a1.account_no),
        '@point_balance', b.Pointsbalance),
        '@name',SUBSTRING(REPLACE(a1.name,' ',''),1,15)),
        '@expiry_date',b.`Expirydate`),
        '@card_no',a1.card_no) AS decode_message,
        a1.*,b.`Expirydate`,b.`Pointsbalance` FROM (
        SELECT b.`message`,d.`contact_no`,d.`name`,d.`card_no`,d.`account_no` FROM `sms_sending_template` a 
        INNER JOIN `sms_message` b ON a.`message_guid` = b.`guid`
        INNER JOIN `sms_contact` c ON a.`contact_guid` = c.`guid`
        INNER JOIN `sms_contact_c` d ON d.`contact_guid` = c.guid
        WHERE a.`guid` = '$guid')a1
        INNER JOIN `member` b ON a1.account_no = b.`AccountNo`)a1
        JOIN `sms_setup` a11 WHERE a11.`set` = '1' ");
        return $query;
    }


    public function sending_list_count($guid)
    {
        $query = $this->db->query("SELECT COUNT(*) AS num FROM (SELECT 
        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE (a1.message, '@account_no', a1.account_no),
        '@point_balance', b.Pointsbalance),
        '@name',SUBSTRING(REPLACE(a1.name,' ',''),1,15)),
        '@expiry_date',b.`Expirydate`),
        '@card_no',a1.card_no) AS decode_message,
        a1.*,b.`Expirydate`,b.`Pointsbalance` FROM (
        SELECT b.`message`,d.`contact_no`,d.`name`,d.`card_no`,d.`account_no` FROM `sms_sending_template` a 
        INNER JOIN `sms_message` b ON a.`message_guid` = b.`guid`
        INNER JOIN `sms_contact` c ON a.`contact_guid` = c.`guid`
        INNER JOIN `sms_contact_c` d ON d.`contact_guid` = c.guid
        WHERE a.`guid` = '$guid')a1
        INNER JOIN `member` b ON a1.account_no = b.`AccountNo`)a11");
        return $query;
    }

    public function sending_list($guid,$limit,$start,$dir,$order)
    {
        $query = $this->db->query("SELECT CHAR_LENGTH(a11.decode_message) AS total_char,CEILING(CHAR_LENGTH(a11.decode_message)/160) AS total_sms,a11.* FROM(SELECT 
        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE (a1.message, '@account_no', a1.account_no),
        '@point_balance', b.Pointsbalance),
        '@name',SUBSTRING(REPLACE(a1.name,' ',''),1,15)),
        '@expiry_date',b.`Expirydate`),
        '@card_no',a1.card_no) AS decode_message,
        a1.*,b.`Expirydate`,b.`Pointsbalance` FROM (
        SELECT b.`message`,d.`contact_no`,d.`name`,d.`card_no`,d.`account_no` FROM `sms_sending_template` a 
        INNER JOIN `sms_message` b ON a.`message_guid` = b.`guid`
        INNER JOIN `sms_contact` c ON a.`contact_guid` = c.`guid`
        INNER JOIN `sms_contact_c` d ON d.`contact_guid` = c.guid
        WHERE a.`guid` = '$guid')a1
        INNER JOIN `member` b ON a1.account_no = b.`AccountNo` ORDER BY $order $dir LIMIT $start, $limit)a11 ");
        //echo $this->db->last_query();die;
        return $query;
    }

    public function sending_list_search($guid,$limit,$start,$dir,$order,$search)
    {
        $query = $this->db->query("SELECT CHAR_LENGTH(a11.decode_message) AS total_char,CEILING(CHAR_LENGTH(a11.decode_message)/160) AS total_sms,a11.* FROM(SELECT 
        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE (a1.message, '@account_no', a1.account_no),
        '@point_balance', b.Pointsbalance),
        '@name',SUBSTRING(REPLACE(a1.name,' ',''),1,15)),
        '@expiry_date',b.`Expirydate`),
        '@card_no',a1.card_no) AS decode_message,
        a1.*,b.`Expirydate`,b.`Pointsbalance` FROM (
        SELECT b.`message`,d.`contact_no`,d.`name`,d.`card_no`,d.`account_no` FROM `sms_sending_template` a 
        INNER JOIN `sms_message` b ON a.`message_guid` = b.`guid`
        INNER JOIN `sms_contact` c ON a.`contact_guid` = c.`guid`
        INNER JOIN `sms_contact_c` d ON d.`contact_guid` = c.guid
        WHERE a.`guid` = '$guid')a1
        INNER JOIN `member` b ON a1.account_no = b.`AccountNo`
        WHERE a1.card_no LIKE '%$search%'
        OR a1.account_no LIKE '%$search%'
        OR a1.name LIKE '%$search%'
        OR a1.card_no LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $limit)a11 ");
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function sending_list_search_count($guid,$limit,$start,$dir,$order,$search)
    {
        $query = $this->db->query("SELECT CHAR_LENGTH(a11.decode_message) AS total_char,CEILING(CHAR_LENGTH(a11.decode_message)/160) AS total_sms,a11.* FROM(SELECT 
        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE (a1.message, '@account_no', a1.account_no),
        '@point_balance', b.Pointsbalance),
        '@name',SUBSTRING(REPLACE(a1.name,' ',''),1,15)),
        '@expiry_date',b.`Expirydate`),
        '@card_no',a1.card_no) AS decode_message,
        a1.*,b.`Expirydate`,b.`Pointsbalance` FROM (
        SELECT b.`message`,d.`contact_no`,d.`name`,d.`card_no`,d.`account_no` FROM `sms_sending_template` a 
        INNER JOIN `sms_message` b ON a.`message_guid` = b.`guid`
        INNER JOIN `sms_contact` c ON a.`contact_guid` = c.`guid`
        INNER JOIN `sms_contact_c` d ON d.`contact_guid` = c.guid
        WHERE a.`guid` = '$guid')a1
        INNER JOIN `member` b ON a1.account_no = b.`AccountNo`
        WHERE a1.card_no LIKE '%$search%'
        OR a1.account_no LIKE '%$search%'
        OR a1.name LIKE '%$search%'
        OR a1.card_no LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $limit)a11 ");
        //echo $this->db->last_query();die;
        return $query;
    }

    public function sms_transaction_all($limit,$start,$dir,$order)
    {
        $query = $this->db->query("SELECT a.`trans_type` as TransType, a.`respond_code`,a.`status`
                AS sending_status,a.`respond_message`,a.`account_no`,a.`mobile_no`,a.`message`,
                a.`date`,a.`created_by`,a.`provider`,a.`created_at` FROM `sms_transaction` a
                ORDER BY $order $dir LIMIT $start, $limit;");
        //echo $this->db->last_query();die;
        return $query;
    }

    public function sms_transaction_search($search,$limit,$start,$dir,$order)
    {
        $query = $this->db->query("SELECT a.`trans_type` as TransType,a.`respond_code`,a.`status`
            AS sending_status,a.`respond_message`,a.`account_no`,a.`mobile_no`,a.`message`,
            a.`date`,a.`created_by`,a.`provider`,a.`created_at` FROM `sms_transaction` a
            WHERE 
            a.`trans_type` LIKE '%$search%'
            OR a.`respond_code` LIKE '%$search%'
            OR a.`status` LIKE '%$search%'
            OR a.`account_no` LIKE '%$search%'
            OR a.`mobile_no` LIKE '%$search%'
            OR a.`date` LIKE '%$search%'
            OR a.`provider` LIKE '%$search%'
            OR a.`created_by` LIKE '%$search%'
            ORDER BY $order $dir LIMIT $start, $limit;");
        //echo $this->db->last_query();die;
        return $query;
    }
    
    
    public function send_sms($url,$provider,$user,$pass,$sms_from,$sms_to,$sms_msg,$languagetype)
    {
        if($provider == 'ONEWAY')
        {
            $query_string = "apiusername=".$user."&apipassword=".$pass;
            $query_string .= "&mobileno=".rawurlencode($sms_to)."&senderid=".rawurlencode($sms_from);
            $query_string .= "&languagetype=".$languagetype."&message=".rawurlencode(stripslashes($sms_msg));
            $url = $url.$query_string;
            $code = @implode ('', file ($url));
        };

        if($provider == 'MAXIS')
        {
            $query_string = "ID=".$user."&Password=".$pass;
            $query_string .= "&Mobile=".rawurlencode($sms_to)."&Type=A";
            $query_string .= "&message=".rawurlencode(stripslashes($sms_msg));
            $url = $url.$query_string;
            $code = @implode ('', file ($url));
        };

        //echo $url;die;
        $str_params = $url;
        $json = parse_str($str_params, $jsonParams);
        $jsonData = json_encode($jsonParams);
        $result = json_decode($jsonData, true);

        if($provider == 'ONEWAY')
        {
            if($code)
            {
                if($code > 0)
                {
                    $respond_message = 'Succesful';
                    $status = 'SUCCESS';
                };

                if($code == -100)
                {
                    $respond_message = 'apipassname or apipassword is invalid ';
                    $status = 'FAIL';
                };

                if($code == -200)
                {
                    $respond_message = 'senderid parameter is invalid ';
                    $status = 'FAIL';
                };

                if($code == -300)
                {
                    $respond_message = 'mobileno parameter is invalid ';
                    $status = 'FAIL';
                };

                if($code == -400)
                {
                    $respond_message = 'language type is invalid ';
                    $status = 'FAIL';
                };

                if($code == -500)
                {
                    $respond_message = 'Invalid characters in message ';
                    $status = 'FAIL';
                };

                if($code == -600)
                {
                    $respond_message = 'Insufficient credit balance ';
                    $status = 'FAIL';
                };
            }
            else
            {
                $respond_message = 'No connection';
                $status = 'FAIL';
                $code = 'ERROR';
            }

            $mobileno = $result['mobileno'];
        }

        if($provider == 'MAXIS')
        {
            if($code)
            {
                $respond_message = 'Succesful';
                $status = 'SUCCESS';
            }
            else
            {
                $respond_message = 'No connection';
                $status = 'FAIL';
                $code = 'ERROR';
            }

            $mobileno = $result['Mobile'];
        }

        $result_data = array(
            'code' => $code,
            'status' => $status,
            'respond_message' => $respond_message,
            'mobileno' => $mobileno,
            'message' => $result['message']
        );

        return $result_data;
    }  
    
}

?> 
