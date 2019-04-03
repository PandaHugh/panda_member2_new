<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
    }
    

    // function login_data($supcode, $username, $userpass)
    // {
    //     //data is retrive from this query
    //     $sql = "SELECT supcus.*, set_user.* FROM supcus 
    //             INNER JOIN set_user WHERE supcus.code = '$supcode' AND set_user.user_name = '$username' 
    //             AND set_user.user_password = '$userpass'";
    //     $query = $this->db->query($sql);
    //     return $query->num_rows();
        
    // }

    // function login_data($username, $userpass)
    // {
    //     //data is retrive from this query
    //     $sql = "SELECT ID, PASSWORD FROM test.user";
    //     $query = $this->db->query($sql);
    //     return $query->num_rows();
    // }
    
    function login_data($username, $userpass)// admin/buyer user
    {
        // script join web module setup
        $sql = "SELECT a.*,b.`user_group_name`,d.`module_name`,e.`module_group_name`,c.`isenable` FROM set_user a 
            INNER JOIN set_user_group b ON a.`user_group_guid` = b.`user_group_guid`
            INNER JOIN set_user_module c ON c.`user_group_guid` = b.`user_group_guid` 
            INNER JOIN set_module d ON d.`module_guid` = c.`module_guid`
            INNER JOIN set_module_group e ON e.`module_group_guid`= d.`module_group_guid` 
            AND e.`module_group_guid` = a.`module_group_guid`
            WHERE a.user_id = '$username' AND a.`user_password` = '$userpass' AND a.`isactive` = 1 
            AND c.`isenable` = 1 AND module_group_name = 'Web Ordering Module';";


        // script without join web module setup 
        // $sql = "SELECT * FROM ordering_module_setup.`set_user` a  WHERE a.`user_id` = '$username' AND a.`user_password` = '$userpass' AND a.`isactive` = 1;";
        $query = $this->db->query($sql);
        return $query;
    }

    function login_data2($username, $userpass)// supplier user
    {
        // script for join web module setup
        $sql = "SELECT SUBSTRING_INDEX(a.supplier_name, ' ->', 1) AS supcode, SUBSTRING_INDEX(a.supplier_name, '-> ', -1) AS supname, a.user_id, b.supplier_group_name, b.user_setup FROM `set_supplier` a INNER JOIN `set_supplier_group` b ON a.`supplier_group_guid` = b.`supplier_group_guid` WHERE user_id = '$username' AND user_password = '$userpass' AND a.`isactive` = '1';";

        // $sql = "SELECT SUBSTRING_INDEX(a.supplier_name, ' ->', 1) AS supcode, SUBSTRING_INDEX(a.supplier_name, '-> ', -1) AS supname, a.user_id, b.supplier_group_name, b.user_setup FROM ordering_module_setup.`set_supplier` a INNER JOIN ordering_module_setup.`set_supplier_group` b ON a.`supplier_group_guid` = b.`supplier_group_guid` WHERE user_id = '$username' AND user_password = '$userpass' AND a.`isactive` = '1';";
        $query = $this->db->query($sql);
        return $query;
    }
}

?> 
