<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_Model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
    }
    

    public function search_card($key)
    {
        $get_query = $this->db->query("SELECT * FROM (
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`,Active,Pointsbalance FROM member WHERE NAME LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`,Active,Pointsbalance FROM member WHERE cardno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`,Active,Pointsbalance FROM member WHERE accountno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`,Active,Pointsbalance FROM member WHERE icno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`,Active,Pointsbalance FROM member WHERE oldicno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`,Active,Pointsbalance FROM member WHERE passportno LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`,Active,Pointsbalance FROM member WHERE Phonemobile LIKE '%$key%' 
                    UNION ALL
                    SELECT CardNo, AccountNo, Expirydate, ICNo, Phonemobile, `Name`,Active,Pointsbalance FROM member WHERE Address1 LIKE '%$key%' 
                    UNION ALL
                    SELECT b.SupCardNo AS CardNo, b.AccountNo, b.Expirydate, b.ICNo, b.Phonemobile, b.Name,b.Active,a.Pointsbalance FROM member a INNER JOIN membersupcard b ON a.accountno = b.accountno WHERE supcardno LIKE '%$key%' )a1  GROUP BY accountno");
        //echo $this->db->last_query();die;
        return $get_query;
    }
}

?> 
