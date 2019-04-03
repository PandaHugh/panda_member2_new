<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class logout_c extends CI_Controller {
    
    function logout()
    {

        $this->session->sess_destroy();
        redirect('login_c/index');
    }
    
    
}
