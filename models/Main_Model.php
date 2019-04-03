<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_Model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
    }
    

     /*server side datatable*/

    function allposts_count()
    {   
        $sql = "SELECT * FROM order_main WHERE status = 'Accepted'";
        $query = $this->db->query($sql);
        return $query->num_rows();  

    }
    
    function allposts($limit,$start,$col,$dir)
    {   

        // $limit = '10';
        // $start = '0';
        // $col = 'ref_no';
        // $dir = 'ASC';

        $sql = $_SESSION['query_string']." ORDER BY " .$col. "  " .$dir. " LIMIT " .$start. " , " .$limit. ";";
        $query = $this->db->query($sql);
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search($limit,$start,$search,$col,$dir)
    {
        if($_SESSION['ajax_request'] == 'main_member')
        {
            $sql = $_SESSION['query_string']." WHERE storage_id LIKE '%".$search."%' OR 
                    zone_id LIKE '%".$search."%' ORDER BY " .$col. "  " .$dir. " LIMIT " .$start. " , " .$limit. "; ";
        };
        
        $query = $this->db->query($sql);
        $_SESSION['query'] = $query;
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function posts_search_count($search)
    {
        if($_SESSION['ajax_request'] == 'location_bin')
        {
            $sql = $_SESSION['query_string']." WHERE storage_id LIKE '%".$search."%' OR 
                zone_id LIKE '%".$search."%' ;";
        };

        if($_SESSION['ajax_request'] == 'manual_batch')
        {
            $sql = $_SESSION['query_string']." WHERE batch_barcode LIKE '%".$search."%' OR 
                method_name LIKE '%".$search."%' ;";
        };

        if($_SESSION['ajax_request'] == 'item_tracking')
        {
            $sql = $_SESSION['query_string']." WHERE storage_id LIKE '%".$search."%' OR 
                batch_barcode LIKE '%".$search."%' ;";
        };

        $query = $this->db->query($sql);
        return $query->num_rows();
    } 
}

?> 
