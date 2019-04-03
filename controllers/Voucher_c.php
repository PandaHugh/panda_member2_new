<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_c extends CI_Controller {
    
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

	}

    public function index()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $template = $this->db->query("SELECT title from voucher_template where type = 'preset' and output = '1' ")->row('title');
            /*$result1 = $this->db->query("SELECT * from voucher_template where template = '1' ");
            $result2 = $this->db->query("SELECT * from voucher_template where template = '2' ");*/

            $data = array(
                'template1' => $template,
                'template2' => $template,
                'tc' => $this->db->query("SELECT output from voucher_template where type = 't&c' and title = '$template' ")->row('output'),
                'prefix' => $this->db->query("SELECT output from voucher_template where type = 'prefix' and title = '$template' ")->row('output'),
                'width' => $this->db->query("SELECT output from voucher_template where type = 'width' and title = '$template' ")->row('output'),
                'height' => $this->db->query("SELECT output from voucher_template where type = 'height' and title = '$template' ")->row('output'),
                'template' => $template,
                'logo_temp1' => $this->db->query("SELECT output from voucher_template where type = 'logo' and title = 'template1' ")->row('output'),
                'logo_temp2' => $this->db->query("SELECT output from voucher_template where type = 'logo' and title = 'template2' ")->row('output'),
                'logo' => $this->db->query("SELECT output from voucher_template where type = 'path' and title = 'logo' ")->row('output'),
                'logo_width' => $this->db->query("SELECT output from voucher_template where type = 'width' and title = 'logo' ")->row('output'),
                'logo_height' => $this->db->query("SELECT output from voucher_template where type = 'height' and title = 'logo' ")->row('output'),
            );
/*$this->load->view('test');*/
            $this->template->load('template' , 'voucher_setting', $data);
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
            if($this->input->post('subject') == '1')
            {
                $this->db->query("UPDATE voucher_template SET output = '1' WHERE title = 'template1' and type = 'preset' ");
                $this->db->query("UPDATE voucher_template SET output = '0' WHERE title = 'template2' and type = 'preset' ");
            }
            elseif($this->input->post('subject') == '2')
            {
                $this->db->query("UPDATE voucher_template SET output = '0' WHERE title = 'template1' and type = 'preset' ");
                $this->db->query("UPDATE voucher_template SET output = '1' WHERE title = 'template2' and type = 'preset' ");
            }

            $this->db->query("UPDATE voucher_template SET output = '".$this->input->post('logo_temp1')."' WHERE title = 'template1' and type = 'logo' ");
            $this->db->query("UPDATE voucher_template SET output = '".$this->input->post('logo_temp2')."' WHERE title = 'template2' and type = 'logo' ");

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Save Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

            redirect("Voucher_c");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function submit()
    {
        if($this->session->userdata('loginuser') == true)
        {
            if(isset($_REQUEST['submit']))
            {
                $this->db->query("UPDATE voucher_template SET output = '".$this->input->post('Prefix')."' WHERE type = 'prefix' and title = '".$_REQUEST['template']."' ");
                $this->db->query("UPDATE voucher_template SET output = '".$this->input->post('Width')."' WHERE type = 'width' and title = '".$_REQUEST['template']."' ");
                $this->db->query("UPDATE voucher_template SET output = '".$this->input->post('Height')."' WHERE type = 'height' and title = '".$_REQUEST['template']."' ");
            }
            elseif(isset($_REQUEST['logo']))
            {
                $this->db->query("UPDATE voucher_template SET output = '".$this->input->post('Width')."' WHERE type = 'width' and title = 'logo' ");
                $this->db->query("UPDATE voucher_template SET output = '".$this->input->post('Height')."' WHERE type = 'height' and title = 'logo' ");
            }
            else
            {
                $this->db->query("UPDATE voucher_template SET output = '".$this->input->post('tc')."' WHERE type = 't&c' and title = '".$_REQUEST['template']."' ");
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Save Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

            redirect("Voucher_c");
        }
        else
        {
            redirect('login_c');
        }
    }

    public function update_logo()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $config = array(
                /*'upload_path' => "./uploads/",*/
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => TRUE,
                'max_size' => "200", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "700",//768
                'max_width' => "1000",//1024
            );

            $this->load->library('upload', $config);

            if($this->upload->do_upload())
            {
                $path = 'uploads/'. $this->upload->data('file_name');
                $this->db->query("UPDATE voucher_template SET output = '".$path."' WHERE type = 'path' and title = 'logo' ");

                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Save Record Successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Upload Image<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Voucher_c");
        }
        else
        {
            redirect('login_c');
        }
    }

    


}