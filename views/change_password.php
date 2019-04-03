<?php 
'session_start()' 
?>


<style>

#none{
    display: none;
}

#poDetails, #promoDetails {
  display: none;
}

#head{
    font-size: 12px;
  }


b .font {
    font-size: 90px;
}

label {
  font-size: 12px;
}

@media screen and (max-width: 768px) {
  p,input,div,span,h4 {
    font-size: 95%;
  }
  h1 {
    font-size: 2px;  
  }
  h4 {
    font-size: 18px;  
  }
  h3 {
    font-size: 20px;  
  }
  h1 #head{
    font-size: 12px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
}


</style>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);


</script>
<!--onload Init-->
<body>
    
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
    <div id="page-inner">

        <?php
        if($this->session->userdata('message'))
        {
           echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
        }
        ?>
                    
              <!-- <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('main_c')?>" class="btn btn-default btn-xs"  style="float:right;" >
                          <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
                    </h1>
                  </div>
              </div> -->

  <div class="row">
    <div class="col-md-12">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Change Password</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
          <div class="box-header">
            <form method="post" action="<?php echo site_url('Login_c/save_password'); ?>">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Old Password</label>
                  <input type="password" id="Old_Password" name="Old_Password" value="" class="form-control" placeholder="Old Password" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" id="New_Password" name="New_Password" value="" class="form-control" placeholder="New Password" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Confirm New Password</label>
                  <input type="password" id="Confirm_New_Password" name="Confirm_New_Password" value="" class="form-control" placeholder="Confirm New Password" required />
                </div>
              </div>
            </div>
            <br>
            <input type="submit" value="Save" class="btn btn-success pull-left" />
            </form>
          </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
