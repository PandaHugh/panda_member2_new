<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_general_c extends CI_Controller {
    
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

    public function check_month($value)
    {
        if($value == '01')
        {
            $month = 'Janaury';
        }
        elseif($value == '02')
        {
            $month = 'February';
        }
        elseif($value == '03')
        {
            $month = 'March';
        }
        elseif($value == '04')
        {
            $month = 'April';
        }
        elseif($value == '05')
        {
            $month = 'May';
        }
        elseif($value == '06')
        {
            $month = 'June';
        }
        elseif($value == '07')
        {
            $month = 'July';
        }
        elseif($value == '08')
        {
            $month = 'August';
        }
        elseif($value == '09')
        {
           $month = 'September'; 
        }
        elseif($value == '10')
        {
            $month = 'October';
        }
        elseif($value == '11')
        {
            $month = 'November';
        }
        else
        {
            $month = 'December';
        }

        return $month;
    }

    public function check_parameter()
    {
        $query = $this->db->query("SELECT * FROM `set_parameter`");
        return $query; 
    }
    
    public function setup()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $data = array(
                'nationality' => $this->db->query("SELECT * from set_nationality order by Nationality asc"),
                'occupation' => $this->db->query("SELECT * from set_occupation order by Occupation asc"),
                'race' => $this->db->query("SELECT * from set_race order by Race asc"),
                'relationship' => $this->db->query("SELECT * from set_relationship order by Relationship asc"),
                'religion' => $this->db->query("SELECT * from set_religion order by Religion asc"),
                'status' => $this->db->query("SELECT * from set_status order by Status asc"),
                'title' => $this->db->query("SELECT * from set_title order by Title asc"),
                'cardtype' => $this->db->query("SELECT * from cardtype order by CardType asc"),
                'tnc' => $this->db->query("SELECT registration_form_t_c from set_parameter")->row('registration_form_t_c'),
                'wallet' => $this->db->query("SELECT * from set_wallet order by wallet_name asc"),
                'miscellaneous' => $this->db->query("SELECT * from set_misc order by misc_name asc"),

                'body_content' => $this->check_parameter()->row('card_content_message'),
                'body_header' => $this->check_parameter()->row('card_content_header'),
                'barcode_width' => $this->check_parameter()->row('card_barcode_width'),
                'barcode_heigth' => $this->check_parameter()->row('card_barcode_heigth'),
                'text_font' => $this->check_parameter()->row('text_font'),
                /*'receipt_no_amount_supcard' => $this->db->query("SELECT receipt_no_amount_supcard from set_parameter")->row('receipt_no_amount_supcard'),
                'supcard' => $this->db->query("SELECT * from set_itemcode where name = 'supcard' "),
                'lostcard' => $this->db->query("SELECT * from set_itemcode where name = 'lostcard' "),
                'newcard' => $this->db->query("SELECT * from set_itemcode where name = 'newcard' "),
                'activecard' => $this->db->query("SELECT * from set_itemcode where name = 'activecard' "),
                'set_branch_parameter' => $this->db->query("SELECT * from set_branch_parameter ORDER BY branch_code ASC "),*/
                );
            
            $this->template->load('template' , 'setup' , $data);
            /*$this->load->view('test2');*/
        
        }
        else
        {
            redirect('login_c');
        }
    }

    public function operation()
    {
        if($this->session->userdata('loginuser') == true)
        {  

            $data = array(
                'parameter' => $this->db->query("SELECT * from set_parameter"),
                'receipt_no_amount_supcard' => $this->db->query("SELECT receipt_no_amount_supcard from set_parameter")->row('receipt_no_amount_supcard'),
                'supcard' => $this->db->query("SELECT * from set_itemcode where name = 'supcard' "),
                'lostcard' => $this->db->query("SELECT * from set_itemcode where name = 'lostcard' "),
                'newcard' => $this->db->query("SELECT * from set_itemcode where name = 'newcard' "),
                'activecard' => $this->db->query("SELECT * from set_itemcode where name = 'activecard' "),
                'replacecard' => $this->db->query("SELECT * from set_itemcode where name = 'replacecard' "),
                'upgradecard' => $this->db->query("SELECT * FROM set_itemcode WHERE name = 'upgradecard' "),
                'set_branch_parameter' => $this->db->query("SELECT * from set_branch_parameter ORDER BY branch_code ASC "),
                'expiry_month' => $this->check_month($this->check_parameter()->row('point_expiry_period')),
                );
            
            $this->template->load('template' , 'operation' , $data);
        
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
            $column = $_REQUEST['column'];
            $table = $_REQUEST['table'];

            $this->db->where($column, $condition);
            $this->db->delete($table);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Deleted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to delete data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            
            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_insert_nationality()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'Nationality';
            $column2 = 'Preset';
            $table = 'set_nationality';
            $sql = $this->db->query("SELECT Nationality from set_nationality where Nationality = '".$this->input->post('name')."' ");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        $column => $this->input->post('name'),
                    );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                    $column => $this->input->post('name'),
                    );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_insert_occupation()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'Occupation';
            $column2 = 'Preset';
            $table = 'set_occupation';
            $sql = $this->db->query("SELECT Occupation from set_occupation where Occupation = '".$this->input->post('name')."' ");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        $column => $this->input->post('name'),

                    );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                    $column => $this->input->post('name'),
                    );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_insert_race()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'Race';
            $column2 = 'Preset';
            $table = 'set_race';
            $sql = $this->db->query("SELECT Race from set_race where Race = '".$this->input->post('name')."' ");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        $column => $this->input->post('name'),

                        );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                    $column => $this->input->post('name'),
                    );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_insert_relationship()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'Relationship';
            $column2 = 'Preset';
            $table = 'set_relationship';
            $sql = $this->db->query("SELECT Relationship from set_relationship where Relationship = '".$this->input->post('name')."' ");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        $column => $this->input->post('name'),
                        
                    );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                    $column => $this->input->post('name'),
                    );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_insert_religion()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'Religion';
            $column2 = 'Preset';
            $table = 'set_religion';
            $sql = $this->db->query("SELECT Religion from set_religion where Religion = '".$this->input->post('name')."' ");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        $column => $this->input->post('name'),
                        
                    );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                    $column => $this->input->post('name'),
                    );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_insert_status()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'Status';
            $column2 = 'Preset';
            $table = 'set_status';
            $sql = $this->db->query("SELECT Status from set_status where Status = '".$this->input->post('name')."' ");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        $column => $this->input->post('name'),
                     
                    );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                    $column => $this->input->post('name'),
                    );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_insert_title()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'Title';
            $column2 = 'Preset';
            $table = 'set_title';
            $sql = $this->db->query("SELECT Title from set_title where Title = '".$this->input->post('name')."' ");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        $column => $this->input->post('name'),
                        
                    );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                    $column => $this->input->post('name'),
                    );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }


    public function update_insert_wallet()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'wallet_name';
            $column2 = 'Preset';
            $table = 'set_wallet';
            $sql = $this->db->query("SELECT wallet_name from set_wallet where wallet_name = '".$this->input->post('name')."' ");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        'wallet_guid' => $this->db->query("SELECT upper(replace(uuid(),'-','')) as guid")->row('guid'),
                        $column => $this->input->post('name'),
                        
                    );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                    $column => $this->input->post('name'),
                    );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }


    public function update_insert_miscellaneous()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'misc_name';
            $column2 = 'Preset';
            $table = 'set_misc';
            $sql = $this->db->query("SELECT misc_name from set_misc where misc_name = '".$this->input->post('name')."' ");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        'misc_guid' => $this->db->query("SELECT upper(replace(uuid(),'-','')) as guid")->row('guid'),
                        $column => $this->input->post('name'),
                        
                    );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                    $column => $this->input->post('name'),
                    );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_insert_cardtype()
    {
        if($this->session->userdata('loginuser')== true)
        {  
            $oriname = $this->input->post('oriname');
            $column = 'CardType';
            $column2 = 'Preset';
            $column3 = 'PricingValue';
            $table = 'cardtype';
            $sql = $this->db->query("SELECT CardType from cardtype where CardType = '".$this->input->post('name')."' and PricingValue = '".$this->input->post('value')."'");

            if($sql->num_rows() == 0)
            {
                if($oriname == '')
                {
                    $data = array(
                        $column => $this->input->post('name'),
                        $column3 => $this->input->post('value'),
                    );

                    $this->db->insert($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Inserted Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                else
                {
                    $data = array(
                        $column => $this->input->post('name'),
                        $column3 => $this->input->post('value'),
                        );

                    $this->db->where($column, $oriname);
                    $this->db->update($table, $data);

                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to update data<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    }
                }
                redirect("Setup_general_c/setup");
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Already Exists<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                
            }

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $name = $this->input->post('name');
            $upd_column = $_REQUEST['upd_column'];
            $column = $_REQUEST['column'];
            $table = $_REQUEST['table'];

            /*if($name != '')
            {*/
                $info = array(
                    $upd_column => '0',
                );
                $this->db->update($table, $info);

                /*foreach($name as $key => $value)
                {*/
                $data = array(
                    //$upd_column => $preset[$key],
                    $upd_column => '1',
                );
                $this->db->where($column, $name);
                $this->db->update($table, $data);
                //}
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            /*}
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Unchanged<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }*/

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }


    public function save_card_layout()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $data = array(
                'card_content_header' => $this->input->post('content_header'),
                'card_content_message' => $this->input->post('content_message')
            );
            $this->db->update('set_parameter', $data);
            //}
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }


    public function save_tnc()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $data = array(
                'registration_form_t_c' => $this->input->post('tnc'),
            );
            $this->db->update('set_parameter', $data);
            //}
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_general()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $table = $_REQUEST['table'];

            $point_expiry = 0;
            if($this->input->post('point_expiry') != '')
            {
                $point_expiry = $this->input->post('point_expiry');
            }

            $info = array(
                //$upd_column => $preset[$key],
                'preissue_default_active' => $this->input->post('preissue_default_active'),
                'auto_renewsupcard' => $this->input->post('auto_renewsupcard'),
                'expiry_date_in_year' => $this->input->post('expiry_date_in_year'),
                'expiry_date_type' => $this->input->post('expiry_date_type'),
                'check_receipt_itemcode' => $this->input->post('check_receipt_itemcode'),
                'voucher_valid_in_days' => $this->input->post('voucher_valid_in_days'),
                'merchant_rewards_program' => $this->input->post('merchant_rewards_program'),
                'customized_voucher_no' => $this->input->post('customized_voucher_no'),
                'point_expiry' => $point_expiry,
                'card_verify' => $this->input->post('card_verify'),
            );

            if($this->check_parameter()->row('point_expiry') == '1')
            {
                $info['point_expiry_period'] = $this->input->post('point_expiry_period');
                $info['point_expiry_month'] = $this->input->post('point_expiry_month');
            }

            $this->db->update($table, $info);

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

            redirect("Setup_general_c/operation");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_check_digit()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $upd_column = array('check_digit_card', 'check_digit_voucher', 'check_digit_voucher_activation');
            $table = $_REQUEST['table'];

            if($this->input->post('check_digit_card') == 'on')
            {
                $check_digit_card = '1';
            }
            else
            {
                $check_digit_card = '0';
            }

            if($this->input->post('check_digit_voucher') == 'on')
            {
                $check_digit_voucher = '1';
            }
            else
            {
                $check_digit_voucher = '0';
            }

            if($this->input->post('check_digit_voucher_activation') == 'on')
            {
                $check_digit_voucher_activation = '1';
            }
            else
            {
                $check_digit_voucher_activation = '0';
            }

            for($x = 0; $x <= 2; $x++)
            {
                $info = array(
                    //$upd_column => $preset[$key],
                    $upd_column[$x] => ${$upd_column[$x]},
                );

                $this->db->update($table, $info);
            }
            
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

            redirect("Setup_general_c/operation");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_receipt_no()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $upd_column = array('receipt_no_supcard', 'receipt_no_lostcard', 'receipt_no_activerenew','receipt_no_replacecard');
            $upd_column_amt = array('receipt_no_amount_supcard', 'receipt_no_amount_lostcard', 'receipt_no_amount_activerenew','receipt_no_amount_replace');
            $table = $_REQUEST['table'];

            /*if($this->input->post('receipt_no_supcard') == 'on')
            {
                $receipt_no_supcard = '1';
                $receipt_no_amount_supcard = $this->input->post('receipt_no_amount_supcard');

                if($this->input->post('receipt_no_amount_supcard') == '')
                {
                    $receipt_no_amount_supcard = '0';
                };
            }
            else
            {
                $receipt_no_supcard = '0';
                $receipt_no_amount_supcard = $this->input->post('receipt_no_amount_supcard');

                if($this->input->post('receipt_no_amount_supcard') == '')
                {
                    $receipt_no_amount_supcard = '0';
                };
            }

            if($this->input->post('receipt_no_lostcard') == 'on')
            {
                $receipt_no_lostcard = '1';
                $receipt_no_amount_lostcard = $this->input->post('receipt_no_amount_lostcard');

                if($this->input->post('receipt_no_amount_lostcard') == '')
                {
                    $receipt_no_amount_lostcard = '0';
                };
            }
            else
            {
                $receipt_no_lostcard = '0';
                $receipt_no_amount_lostcard = $this->input->post('receipt_no_amount_lostcard');

                if($this->input->post('receipt_no_amount_lostcard') == '')
                {
                    $receipt_no_amount_lostcard = '0';
                };
            }

            if($this->input->post('receipt_no_activerenew') == 'on')
            {
                $receipt_no_activerenew = '1';
                $receipt_no_amount_activerenew = $this->input->post('receipt_no_amount_activerenew');

                if($this->input->post('receipt_no_amount_activerenew') == '')
                {
                    $receipt_no_amount_activerenew = '0';
                };
            }
            else
            {
                $receipt_no_activerenew = '0';
                $receipt_no_amount_activerenew = $this->input->post('receipt_no_amount_activerenew');

                if($this->input->post('receipt_no_amount_activerenew') == '')
                {
                    $receipt_no_amount_activerenew = '0';
                };
            }

            for($x = 0; $x <= 2; $x++)
            {
                $info = array(
                    $upd_column_amt[$x] => ${$upd_column_amt[$x]},
                    $upd_column[$x] => ${$upd_column[$x]},
                );

                $this->db->update($table, $info);
            }*/

            $info = array(
                'receipt_no_amount_lostcard' => $this->input->post('receipt_no_amount_lostcard'),
                'receipt_no_amount_supcard' => $this->input->post('receipt_no_amount_supcard'),
                'receipt_no_amount_active' => $this->input->post('receipt_no_amount_active'),
                'receipt_no_amount_renew' => $this->input->post('receipt_no_amount_renew'),
                'receipt_no_amount_replace' => $this->input->post('receipt_no_amount_replace'),
                'receipt_no_amount_upgradecard' => $this->input->post('receipt_no_amount_upgrade'),

            );

            $this->db->update('set_parameter', $info);
            
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

            redirect("Setup_general_c/operation");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_itemcode()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $table = $_REQUEST['table'];

            $loop_itemcode = $this->db->query("SELECT * FROM set_itemcode WHERE NAME IN('supcard', 'lostcard', 'newcard', 'activecard','replacecard', 'upgradecard') ");


            foreach($loop_itemcode->result() as $row => $value)
            {
                $info = array(
                    //$upd_column => $preset[$key],
                    'itemcode' => $this->input->post($value->name.'_ic'),
                    'description' => $this->input->post($value->name.'_desc'),
                    //${'upd_'.$variable[$x]}
                    /*'expiry_date_in_year' => $this->input->post('supcard_ic'),
                    'voucher_valid_in_days' => $this->input->post('supcard_desc'),
                    'voucher_valid_in_days' => $this->input->post('newcard_ic'),
                    'voucher_valid_in_days' => $this->input->post('newcard_desc'),*/
                );

                $this->db->where("name", $value->name);
                $this->db->update($table, $info);
            }
            
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

            redirect("Setup_general_c/operation");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_set_branch()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            //echo var_dump($this->input->post('foo'));die;
            $receipt_activate = $this->input->post('receipt_activate');
            $receipt_lost = $this->input->post('receipt_lost');
            $receipt_renew = $this->input->post('receipt_renew');
            $receipt_sup = $this->input->post('receipt_sup');
            $receipt_replace = $this->input->post('receipt_replace');
            $receipt_upgrade = $this->input->post('receipt_upgrade');
            $branch_guid = $this->input->post('branch_guid');
            $activate_amount = $this->input->post('activate_amount');
            $lost_amount = $this->input->post('lost_amount');
            $renew_amount = $this->input->post('renew_amount');
            $sup_amount = $this->input->post('sup_amount');
            $replace_amount = $this->input->post('replace_amount');
            $upgrade_amount = $this->input->post('upgrade_amount');
          
            foreach($branch_guid as $key => $value) 
            {   
                $data = array(
                    'receipt_activate' => $receipt_activate[$key],
                    'receipt_lost' => $receipt_lost[$key],
                    'receipt_renew' => $receipt_renew[$key],
                    'receipt_sup' => $receipt_sup[$key],
                    'receipt_replace' => $receipt_replace[$key],
                    'receipt_upgrade' => $receipt_upgrade[$key],
                    'amount_activate' => $activate_amount[$key],
                    'amount_lost' => $lost_amount[$key],
                    'amount_renew' => $renew_amount[$key],
                    'amount_sup' => $sup_amount[$key],
                    'amount_replace' => $replace_amount[$key],
                    'amount_upgrade' => $upgrade_amount[$key],
                );

                $this->db->where("branch_guid", $value);
                $this->db->update('set_branch_parameter', $data);
            }
            
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Data Updated Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

            redirect("Setup_general_c/operation");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function sync_branch()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            // $branch = $this->db->query("SELECT a.* FROM panda_b2b.acc_branch a LEFT JOIN set_branch_parameter b ON a.branch_guid = b.branch_guid WHERE b.branch_guid IS NULL AND a.isactive = '1' ");

            // foreach($branch->result() as $key => $value) 
            // {   
            //     $data = array(
            //         'guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS UUID")->row('UUID'),
            //         'branch_guid' => $value->branch_guid,
            //         'branch_code' => $value->branch_code,
            //         'branch_name' => $value->branch_name,
                    
            //     );
            //     $this->db->insert('backend_member.set_branch_parameter', $data);
            // }

            // $branch_update = $this->db->query("SELECT b.`guid`,a.* FROM panda_b2b.acc_branch a INNER JOIN set_branch_parameter b ON a.branch_guid = b.branch_guid WHERE a.isactive = '1';");

            // foreach($branch_update->result() as $key => $value) 
            // {   
            //     $data = array(
            //         'branch_code' => $value->branch_code,
            //         'branch_name' => $value->branch_name,
            //     );
            //     $this->db->where('guid', $value->guid);
            //     $this->db->where('branch_guid', $value->branch_guid);
            //     $this->db->update('backend_member.set_branch_parameter', $data);
            // }

            $result = $this->Member_Model->query_call('Setup_general_c', 'sync_branch');

           // echo $this->db->last_query();die;

            
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Sync Branch Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            if(isset($_REQUEST['redirect']))
            {
                redirect($_REQUEST['redirect']);  
            }
            else
            {
                redirect("Setup_general_c/operation");
            }
        }
        else
        {
            redirect('login_c');
        }
    }

    public function save_postcode()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            if($this->input->post('Postcode') == '' || $this->input->post('City') == '' || $this->input->post('State') == '' || $this->input->post('Location') == '' || $this->input->post('StateCode') == '' || $this->input->post('State') == '')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Please fill in required fields to add postcode!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Setup_general_c/setup");
            };

            $data = array(
                'postcode' => $this->input->post('Postcode'),
                'location' => $this->input->post('Location'),
                'post_office' => $this->input->post('City'),
                'state_code' => $this->input->post('StateCode'),
                'state_name' => $this->input->post('State'),
                'latitude' => '0.00',
                'longitude' => '0.00',
            );

            $info = array(
                'state_code' => $this->input->post('StateCode'),
                'state_name' => $this->input->post('State'),
            );

            $this->db->insert('malaysia_postcode', $data);
            $this->db->insert('state_code', $info);
            
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">New postcode inserted successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

            redirect("Setup_general_c/setup");
        }
        else
        {
            redirect('login_c');
        }
    }

    
    

}
?>
