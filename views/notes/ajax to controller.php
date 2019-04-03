
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- VIEW : -->
<form class="form-horizontal" action="<?php echo site_url('Login_c/save_password'); ?>" method="post">
  <div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Current Password</label>

    <div class="col-sm-5">
      <input type="password" class="form-control" id="Current" placeholder="Enter current password" name="Current" required>
      <span style="font-weight: bolder;" id="Current_result"></span>
    </div>
  </div>
</form>

<script>  
   $(document).ready(function(){  
        /*id=Current*/
        $('#Current').keyup(function(){  
             var Current = $('#Current').val();  
             if(Current != '')  
             {  
                $.ajax({  
                        /*ajax: go into controller as shown below*/
                       url:"<?php echo site_url('change_password'); ?>",  
                       method:"POST",  
                       data:{Current:Current},  
                       success:function(data){  
                            /*get echo data from controller*/
                          if(data == 1)
                            {
                              $('#Current').css('border', '2px green solid');
                              $('#Current_result').css('color', 'green');
                              $('#Current_result').html('Password is correct');
                              $('#save').prop("disabled",false);
                            }
                          else
                            {
                              $('#Current').css('border', '2px red solid');
                              $('#Current_result').html('Incorrect password');   
                              $('#Current_result').css('color', 'red');
                              $('#save').prop("disabled",true);
                            }          
                             
                       }  
                  });  
             }  
        });  
   });
</script>


<!-- CONTROLLER: -->

<?php 
public function change_password()
{
    if($this->session->userdata('loginuser') == true)
    {  
        if($_SESSION['userpass'] == $this->input->post('Current'))
        {
            echo "1";
        }
        else
        {
            echo "2";
        }
    }
    else
    {
        redirect('login_c');
    }
    
}
?>