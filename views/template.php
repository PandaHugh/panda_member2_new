<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Panda | Member 2</title>
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/a.png');?>" >
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/bootstrap/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/vendor/font-awesome/css/font-awesome.min.css');?>"  />
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css');?>"  /> -->
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/datatables/dataTables.bootstrap.css');?>">
  <!-- Datatable Responsive -->
  <link href="<?php echo base_url('assets/template/vendor/datatables-responsive/dataTables.responsive.css');?>" rel="stylesheet">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/dist/css/AdminLTE.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/dist/css/skins/_all-skins.min.css');?>">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.css'); ?>">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css'); ?>">
  
  <link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/select2/select2.min.css');?>">

  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.min.css'); ?>">

    <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/timepicker/bootstrap-timepicker.css'); ?>">

<!--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<!-- link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/dataTables.responsive.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.js"> -->
<style type="text/css">
table {
    font-size: 12px;
  }
  #highlight {
    background-color: #f8f9c7;
  }
</style>

</head>
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

<header class="main-header">
    <nav class="navbar navbar-static-top">
       <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".collapse">
        <i class="fa fa-bars"></i>                   
      </button>
      <a class="navbar-brand" 
      <?php
      if($_SESSION['user_group'] == 'ADMIN')
      {
        ?>
        href="<?php echo site_url('main_c/dashbord')?>"><b>PANDA MEMBER</b></a>
        <?php
      }
      else
      {
        ?>
        href="<?php echo site_url('main_c')?>"><b>PANDA MEMBER</b></a>
        <?php
      }
      ?>
    </div>
    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
      <ul class="nav navbar-nav">
        <!-- <li><a href="#">Link</a></li> -->
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Voucher <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <?php
            if(in_array('AV', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Transaction_c/activate_voucher'); ?>">Activate Voucher </a></li>
              <?php
            }
            ?> -->
            <!-- <li><a href="<?php echo site_url('Transaction_c/issue_voucher'); ?>">Issue Voucher</a></li>
            <li><a href="<?php echo site_url('Transaction_c/voucher'); ?>">View Voucher </a></li> -->
            <!-- <li><a href="#">Credit Customer</a></li> -->
          <!-- </ul>
        </li> -->
        <!-- close due to tranfer the funtion to cash managment -->


        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Member <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <?php
            if(in_array('RM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Main_c'); ?>">Member Info</a></li>
              <?php
            }
            ?>

            <?php
            if(in_array('CP', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Main_c/check_point'); ?>">Check Point</a></li>
              <?php
            }
            ?>


            <?php
            if(in_array('ACM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Transaction_c/activation'); ?>">Activate Card </a></li>
              <?php
            }
            ?>

            <?php
            if(in_array('RCM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Transaction_c/renew'); ?>">Renew Card </a></li>
              <?php
            }
            ?>
            
            <?php
            if(in_array('LCM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Transaction_c/lost_card'); ?>">Lost Card </a></li>
              <?php
            }
            ?>

            <?php
            if(in_array('RPC', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Transaction_c/replace_card'); ?>">Replace Card </a></li>
              <?php
            }
            ?>
              <li><a href="<?php echo site_url('Transaction_c/upgrade_card'); ?>">Upgrade Card</a></li>

            
            <!-- <li><a href="#">Credit Customer</a></li> -->
            <li class="divider"></li>
            <?php
            if(in_array('PCM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Transaction_c/pre_issue_card'); ?>">Pre-Issue Card</a></li>
              <li><a href="<?php echo site_url('Transaction_c/issue_main_card'); ?>">Issue Main Card</a></li>
              <?php
            }
            ?>
            
            <?php
            if(in_array('SCM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Transaction_c/issue_sup_card'); ?>">Issue Sup Card</a></li> <!--temporary not function-->
              <?php
            }
            ?>

            <?php
            if(in_array('AC', $_SESSION['module_code']))
            {
              $check_for_merchant_program = $this->db->query("SELECT * FROM backend_member.`set_parameter` a WHERE a.`merchant_rewards_program` = '1';");

              if($check_for_merchant_program->num_rows() > 0)
              { ?>

                  <li><a href="<?php echo site_url('Transaction_c/assign_card'); ?>">Assign Card To Merchant</a></li> <!--temporary not function-->

              <?php } 
            } ?>

            <?php
            if(in_array('EW', $_SESSION['module_code']))
            {
              ?>

              <li><a href="<?php echo site_url('Main_c/ewallet_old'); ?>">E Wallet</a></li>

            <?php
            }
            ?>

            
            
          </ul>
        </li>
        
        
              <li class="dropdown">
                
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Point <span class="caret"></span></a>
                
                <ul class="dropdown-menu" role="menu">
                  <?php
                  if(in_array('PA', $_SESSION['module_code']))
                  {
                    ?>
                  <li><a href="<?php echo site_url('Point_c'); ?>?column=POINT_ADJ_IN">Point Adjust In</a></li>
                  <li><a href="<?php echo site_url('Point_c'); ?>?column=POINT_ADJ_OUT">Point Adjust Out</a></li>
                  <?php
                    }
                  ?>

                  <?php
                  if(in_array('PRS', $_SESSION['module_code']))
                  {
                    ?>
                  <li><a href="<?php echo site_url('Point_c/point_rules'); ?>">Point Rules Setup</a></li>
                    <?php
                  }
                  ?>

                  <?php
                  if(in_array('PPS', $_SESSION['module_code']))
                  {
                    ?>
                  <li><a href="<?php echo site_url('Point_c/point_promotion'); ?>">Promotion Point Setup</a></li>
                    <?php
                  }
                  ?>

                   <?php
                  if(in_array('APA', $_SESSION['module_code']))
                  {
                    ?>
                  <li><a href="<?php echo site_url('Point_c/auto_point_adjustment'); ?>">Auto Point Adjustment</a></li>
                    <?php
                  }
                  ?>
                </ul>
              </li>
              

        <li class="dropdown">
          
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Redemption <span class="caret"></span></a>
          
          <ul class="dropdown-menu" role="menu">
            <?php
            if(in_array('CRM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Point_c'); ?>?column=REDEEM_CASH">Cash Redemption</a></li>
              <?php
            }
            ?>

            <?php
            if(in_array('VRM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Point_c'); ?>?column=POINT_REDEEM">Voucher Redemption</a></li>
              <?php
            }
            ?>

            <?php
            if(in_array('IDM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Point_c'); ?>?column=ITEM_REDEEM">Item Redemption</a></li>
              <?php
            }
            ?>

            <?php
              if(in_array('FGR', $_SESSION['module_code']))
              {
            ?>
            <li><a href="<?php echo site_url('Point_c/free_gift'); ?>">Free Gift Redemption</a></li>
            <?php
              }
            ?>

          </ul>
        </li>

        <li class="dropdown">
          <?php
          if(in_array('RS', $_SESSION['module_code']))
          {
            ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Setup <span class="caret"></span></a>
            <?php
          }
          ?>
          
          <ul class="dropdown-menu" role="menu">

            <?php
            if(in_array('SG', $_SESSION['module_code']))
            { 
              ?>
              <li><a href="<?php echo site_url('Setup_general_c/setup'); ?>">General</a></li>
              <?php 
            }
            if(in_array('SO', $_SESSION['module_code']))
            { 
            ?>
              <li><a href="<?php echo site_url('Setup_general_c/operation'); ?>">Operation</a></li>
            <?php 
            } 
            ?>

            <?php
            if(in_array('SO', $_SESSION['module_code']))
            { 
              ?>
              <li><a href="<?php echo site_url('Setup_card_c'); ?>">Card Running No</a></li>
              <?php 
            }
            ?>





            <?php
            if(in_array('RSI', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Item_c'); ?>">Redemption</a></li>
              <?php
            }
            ?>

            <?php
            if(in_array('ISI', $_SESSION['module_code']))
            {
            ?>
              <li><a href="<?php echo site_url('Item_c/import_redemption'); ?>">Import Redemption</a></li>
            <?php
            }
            ?>

            <?php
            if(in_array('RSV', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Voucher_c'); ?>">Voucher Template</a></li>
              <?php
            }
            ?>
            <li><a href="<?php echo site_url('Query_c'); ?>">Query</a></li>
          </ul>
        </li>

        <li class="dropdown">
         
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools <span class="caret"></span></a>
          
          <ul class="dropdown-menu" role="menu">

            <?php
            if(in_array('EWTU', $_SESSION['module_code']))
            {
              ?>

              <li><a href="<?php echo site_url('Main_c/ewallet_topup'); ?>">E Wallet Top Up</a></li>

            <?php } ?>
            <?php
            if(in_array('TIE', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Export_excel_c'); ?>">Excel Import / Export</a></li>
              <?php
            }
            ?>
            <?php
            if(in_array('TPU', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Pending_c'); ?>">Retag Member Transaction</a></li> 
              <?php
            }
            ?>
            <?php
            if($_SESSION['user_group'] == 'ADMIN')
            {
              ?>
              <li><a href="<?php echo site_url('Pending_c/search_to_deactivate'); ?>">Update Account Status</a></li>
              <li><a href="<?php echo site_url('Log_c'); ?>">Log</a></li>
              <li><a href="<?php echo site_url('Main_c/reload_from_dropbox'); ?>">Update Version</a></li>
              <?php
            }
            ?>
            <?php
            if(in_array('PRA', $_SESSION['module_code']))
            {
              ?>

              <li><a href="<?php echo site_url('Transaction_c/pre_activate_card'); ?>">Pre Activate Card</a></li>
              <li><a href="<?php echo site_url('Transaction_c/pending_activation'); ?>">Pre Activate List</a></li>
            <?php } ?>
          </ul>
        </li>

        <?php
          if(array_intersect(['C-SMS', 'S-SMS'], $_SESSION['module_code']))
          {
        ?>
        <li class="dropdown">
         
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">E-Sms <span class="caret"></span></a>
          
          <ul class="dropdown-menu" role="menu">
            <?php
            if(in_array('C-SMS', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Sms_c/create_trans'); ?>">Send SMS</a></li> 
              <?php
            }
            ?>

            <?php
            if(in_array('C-SMS', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Sms_c/transaction'); ?>">Transaction</a></li> 
              <?php
            }
            ?>

            <li class="divider"></li>

            <?php
            if(in_array('S-SMS', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Sms_c/sending_template'); ?>">Sending Template</a></li>
              <li><a href="<?php echo site_url('Sms_c/contact_template'); ?>">Contact Template</a></li>
              <li><a href="<?php echo site_url('Sms_c/message_template'); ?>">Message Template</a></li>
              <li><a href="<?php echo site_url('Sms_c/setup'); ?>">Service Setup</a></li> 
              <?php
            }
            ?>


            
          </ul>
        </li>
        <?php
          }
        ?>

      </ul>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <?php
        if($_SESSION['user_group'] <> 'MERCHANT GROUP')
        {
          ?>
            <li><a href="<?php echo site_url('Login_c/change_password')?>"><center>Change Password</center></a></li>
            <li><a href="#"><center> Login As : <?php echo $_SESSION['username']; echo ' ('; echo $_SESSION['user_group']; echo ') ';?></center></a></li>
          <?php
        }
        else
        {
          ?>
          <li><a href="#"><center> Login As : <?php echo $_SESSION['username']; echo ' ('; echo $_SESSION['branch_name']; echo ') ';?></center></a></li>
          <?php
        }
        ?>
        <li><a href="<?php echo site_url('logout_c/logout')?>"><center><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</center></a></li>
      </ul>
    </div>
  </div>
      <!-- /.container-fluid -->
    </nav>
  </header>

  <!-- Content Wrapper. Contains page content 
<?php
                if($_SESSION["group"] == 'admin')
                {
              ?>
                <a href="<?php echo site_url('User_manager_c/supplier_user_setup_admin')?>">User Setup</a>
              <?php
                }
              ?>

<a href="<?php echo site_url('logout_c/logout')?>">Log Out</a>


  -->
  <div class="content-wrapper">
    <section class="content"><!-- <?php echo var_dump($_SESSION['module_code']);  ?>  -->
      <div class="row">
        <div class="col-xs-12">

          <?php echo $contents;?>
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Panda Member v</b> 2.0
    </div>
   <strong class="hidden-md hidden-lg"><center>&copy; Panda Software House Sdn. Bhd. </center></a></strong>
    <strong class="hidden-xs hidden-xs">&copy; Panda Software House Sdn. Bhd.</a></strong>
  </footer>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('assets/template/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/template/bootstrap/js/bootstrap.min.js');?>"></script>
<!-- DataTables -->
<script src="<?php echo base_url('assets/template/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('assets/template/plugins/datatables/dataTables.bootstrap.min.js');?>"></script>
<!-- Datatables Responsive -->
<script src="<?php echo base_url('assets/template/vendor/datatables-responsive/dataTables.responsive.js');?>"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url('assets/template/plugins/slimScroll/jquery.slimscroll.min.js');?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/template/plugins/fastclick/fastclick.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/template/dist/js/app.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/template/dist/js/demo.js');?>"></script>
<!-- page script -->
<!-- Morris.js charts -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> -->
<script src="<?php echo base_url('assets/css/raphael-min.js');?>"></script>
<script src="<?php echo base_url('assets/template/plugins/morris/morris.min.js');?>"></script>

<script src="<?php echo base_url('assets/template/plugins/input-mask/jquery.inputmask.js');?>"></script>
<script src="<?php echo base_url('assets/template/plugins/input-mask/jquery.inputmask.date.extensions.js');?>"></script>
<script src="<?php echo base_url('assets/template/plugins/input-mask/jquery.inputmask.extensions.js');?>"></script>
<!-- date-range-picker -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script> -->
<script src="<?php echo base_url('assets/template/plugins/daterangepicker/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>

<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<!-- bootstrap time picker -->
<script src="<?php echo base_url('assets/plugins/timepicker/bootstrap-timepicker.min.js')?>"></script>



<!-- add by faizul for fuction sms to monitor message character -->
<script>
      $(document).ready(function() {
    var text_max = 160;
    /*$('#textarea_feedback').html(text_max + ' characters');*/

    $('#textarea').keyup(function() {
        var text_length = $('#textarea').val().length;
        var text_remaining = text_max - text_length;
        var cal_sms = text_length / text_max;

        $('#textarea_feedback').html(text_length + ' characters');
        $('#total_sms').html(Math.ceil(cal_sms) + ' sms');

    });
});
</script>


<script>
    
  $('#datepicker').datepicker(
      {format: 'yyyy/mm/dd'}
    );

  $('#redemption_date_from').datepicker(
      {
        format: 'yyyy-mm-dd',
        startDate: '+0d'
      }
    );

  $('#redemption_date_to').datepicker(
      {
        format: 'yyyy-mm-dd',
        startDate: '+0d'
      }
    );

  $('#reservationtime').daterangepicker({
    timePicker: false, 
    timePickerIncrement: 5, 
    
    format: 'MM/dd/YYYY h:mm A'});

    //Timepicker
    $(".timepicker").timepicker({
    defaultTime: 'current',
    disableFocus: false,
    isOpen: false,
    minuteStep: 5,
    secondStep: 1,
    showSeconds: true,
    showInputs: false,
    showMeridian: false,
    });
</script>

<!-- not use -->
<script>
    function postalcode(obj) 
    {

      <?php
      $key=$_POST['poscode'];
      $sql="SELECT malaysia_postcode.location, malaysia_postcode.postcode, malaysia_postcode.post_office, malaysia_postcode.state_code,state_code.state_code, state_code.state_name FROM malaysia_postcode INNER JOIN state_code ON malaysia_postcode.state_code=state_code.state_code WHERE postcode = '$key'";
      $result = mysqli_query($conn5,$sql);
      $rowcount = mysqli_num_rows($result);

      while($row = mysqli_fetch_assoc($result))
      {
      ?>
      var select = document.getElementById('poscode').value;
      if ( select == <?php $row['malaysia_postcode.postcode'];?> )
      {
        document.getElementById('city').value = <?php echo $row['malaysia_postcode.post_office'];?>;
        document.getElementById('state').value = <?php echo $row['state_code.state_name'];?>;
      }
      <?php
        }
      ?>

    }
</script>

<script>
  $(function () {
    
    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();
    
    $("#example1").DataTable();
    $("#condition_list").DataTable();
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "dom":'<"pull-left"l><"pull-right"f>tip',
      stateSave: true,
      language: {
        searchPlaceholder: "Search records"
    }
    });

    $('#pre_activate').DataTable({
     "order": [[ 2, "desc" ]],
    });

    <?php
      if($this->uri->segment(2) == 'search')
      {
    ?>
        /*$('#member').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true,
          "dom":'<"pull-left"l><"pull-right"f>tip',
          stateSave: true,
          language: {
            searchPlaceholder: "Search records"
        }
        });*/

        $('#member').DataTable({
          "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax":{
         "url": "<?php echo site_url('Main_c/all_member_1'); ?>?key=<?php echo $keys; ?>&searchs=<?php echo $search; ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
        "columns": [
            { "data": "Card No" },
              { "data": "Account No" },
              { "data": "Expired Date" },

              <?php
              if(in_array('VIC', $_SESSION['module_code']))
              { ?>
              
                { "data": "IC No" },

              <?php }; ?>

              { "data": "Phone No" },
              { "data": "Name" },
              { "data": "Full Detail" },
              { "data": "Purchase Details" }
           ]   
        });
    <?php
      }
      else if($this->uri->segment(2) == 'search_merchant')
      { ?>

        $('#member').DataTable({
          "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax":{
         "url": "<?php echo site_url('Main_c/all_member_2'); ?>?key=<?php echo $keys; ?>&searchs=<?php echo $search; ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
        "columns": [
            { "data": "Card No" },
              { "data": "Account No" },
              { "data": "Expired Date" },

              <?php
              if(in_array('VIC', $_SESSION['module_code']) || $_SESSION['user_group'] == 'MERCHANT GROUP')
              { ?>

                { "data": "IC No" },

              <?php }; ?>

              { "data": "Phone No" },
              { "data": "Name" },
              { "data": "Full Detail" },
              { "data": "Purchase Details" }
           ]   
        });

      <?php }
      else
      {
    ?>
    $('#member').DataTable({
          "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax":{
         "url": "<?php echo site_url('Main_c/all_member'); ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
        "columns": [
            { "data": "CardNo" },
              { "data": "AccountNo" },
              { "data": "Expirydate" },

              <?php
              if(in_array('VIC', $_SESSION['module_code']) || $_SESSION['user_group'] == 'MERCHANT GROUP')
              { ?>

                { "data": "ICNo" },

              <?php }; ?>

              { "data": "Phonemobile" },
              { "data": "Name" },
              { "data": "Full Detail" },
              { "data": "Purchase Details" }
           ]   
        });
      <?php
        }
      ?>

      <?php
      if($this->uri->segment(2) == 'wallet_search')
      { ?>

        $('#ahseh').DataTable({
          "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax":{
         "url": "<?php echo site_url('Main_c/wallet_search_key'); ?>?key=<?php echo $keys; ?>&searchs=<?php echo $search; ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
        "columns": [
              { "data": "Card No" },
                { "data": "Account No" },
                { "data": "Expired Date" },

                <?php
                if(in_array('VIC', $_SESSION['module_code']))
                { ?>

                  { "data": "IC No" },

                <?php }; ?>

                { "data": "Phone No" },
                { "data": "Name" },
                { "data": "Credit" },
                { "data": "Full Detail" },
                { "data": "Purchase Details" }
             ]     
        });
        
      <?php }
      else
      { ?>

        $('#ahseh').DataTable({
            "processing": true,
              "serverSide": true,
              "searching": false,
              "ajax":{
           "url": "<?php echo site_url('Main_c/ewallet'); ?>",
           "dataType": "json",
           "type": "POST",
           "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                         },
          "columns": [
              { "data": "Card No" },
                { "data": "Account No" },
                { "data": "Expired Date" },

                <?php
                if(in_array('VIC', $_SESSION['module_code']))
                { ?>

                  { "data": "IC No" },

                <?php }; ?>

                { "data": "Phone No" },
                { "data": "Name" },
                { "data": "Credit" },
                { "data": "Full Detail" },
                { "data": "Purchase Details" }
             ]   
          });

      <?php } ?>

      $('#redemption_table').on('click', 'tbody button', function(){
          trans_type = $(this).data('transtype');
          name = $(this).data('name');
          itemcode = $(this).data('itemcode');
          stk_balance = $(this).data('stkbalance');
          guid = $(this).attr('id');

          if(trans_type == 'receive')
          {
            title = 'Receive Item';
            label = 'Receive';
          }
          else if(trans_type == 'adjust_in')
          {
            title = 'Adjust In Item';
            label = 'Adjust In';
          }
          else if(trans_type == 'adjust_out')
          {
            title = 'Adjust Out Item';
            label = 'Adjust Out';
          }

          $('#redemption_modal').find('#itemcode').val(itemcode);
          $('#redemption_modal').find('#item_description').val(name);
          $('#redemption_modal').find('#stk_balance').val(stk_balance);
          $('#redemption_modal').find('.modal-title').text(title);
          $('#redemption_modal').find('#trans_type').val(label);
          $('#redemption_modal').find('#item_guid').val(guid);
          $('#redemption_modal').find('#qty').text(label);
          $('#redemption_modal').find('#input_qty').focus();
          $('#redemption_modal').find('[name=qty]').attr('placeholder', label);

          $('#trans_type_table').DataTable({
            "destroy": true,
            "order": [[ 2, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax":{
             "url": "<?php echo site_url('Item_c/mem_item_trans_main?trans_type='); ?>" + label + '&item_guid=' + guid,
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [
                {"data":"branch"},
                {"data":"Trans_type"},
                {"data":"refno"},
                {"data":"ITEM_CODE"},
                {"data":"ITEM_DESC"},
                {"data":"rec_qty"},
                {"data":"adj_in_qty"},
                {"data":"adj_out_qty"},
            ]     
          });

          $('#redemption_modal').modal('show');
        });

    $('#redemption_table').DataTable({
      "columnDefs": [ {
      "targets": 0,
      "orderable": false
      } ],
      "order": [[ 14, "desc" ]],
      "processing": true,
      "serverSide": true,
      "ajax":{
       "url": "<?php echo site_url('Item_c/mem_item'); ?>",
       "dataType": "json",
       "type": "POST",
       "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
      },
      "columns": [
          {"data": "action"},
          {"data": "enable"},
          {"data": "isVoucher"},
          {"data": "ITEM_TYPE"},
          {"data": "ITEM_CODE"},
          {"data": "ITEM_DESC"},
          {"data": "POINT_TYPE1"},
          {"data": "PRICE"},
          {"data": "STK_BAL"},
          {"data": "STK_BF"},
          {"data": "STK_REC"},
          {"data": "STK_REDEEM"},
          {"data": "STK_ADJ_IN"},
          {"data": "STK_ADJ_OUT"},
          // {"data": "STK_RET_IN"},
          // {"data": "STK_RET_OUT"},
          {"data": "CREATED_AT"},
          {"data": "CREATED_BY"},
          {"data": "UPDATED_AT"},
          {"data": "UPDATED_BY"},
      ]     
    });

    $('#point_in_out_trans').DataTable({
      "columnDefs": [ {
      "targets": 0,
      "orderable": false
      } ],
      "order": [[ 8, "desc" ]],
      "processing": true,
      "serverSide": true,
      "ajax":{
       "url": "<?php echo site_url('Point_c/main_in_out_server_side'); ?>",
       "dataType": "json",
       "type": "POST",
       "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', "column" : "<?php if(isset($_REQUEST['column'])){ echo $_REQUEST['column']; } ?>" }
      },
      "columns": [
          {"data":"Edit"},
          {"data":"POSTED"},
          {"data":"REF_NO"},
          {"data":"TRANS_DATE"},
          {"data":"SUP_CODE"},
          {"data":"SUP_NAME"},
          {"data":"VALUE_TOTAL"},
          {"data":"REMARK"},
          {"data":"CREATED_AT"},
          {"data":"CREATED_BY"},
          {"data":"UPDATED_AT"},
          {"data":"UPDATED_BY"},
      ]     
    });

    $('#purchase_details_server_side').DataTable({
          "processing": true,
          "serverSide": true,
          "searching": true,
          "order": [[ 1, "desc" ]],
          "ajax":{
          "url": "<?php echo site_url('Main_c/purchase_details_server_side?accountno='); ?><?php if(isset($_REQUEST['AccountNo'])){ echo $_REQUEST['AccountNo']; } ?>",
          "dataType": "json",
          "type": "POST",
          "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                         },
          "columns": [
              { "data" : "refno" },
              { "data" : "transdate" },
              { "data" : "description" },
              { "data" : "price" },
              { "data" : "qty" },
              { "data" : "total" },
             ] 
    });

    $('#purchase_list_server_side').DataTable({
          "destroy" : true,
          "processing": true,
          "serverSide": true,
          "searching": true,
          "order": [[ "1", "desc" ]],
          "columnDefs": [ {
            "targets": 9,
            "orderable": false
          } ],
          "ajax":{
          "url": "<?php echo site_url('Main_c/purchase_list_server_side?accountno='); ?><?php if(isset($_REQUEST['AccountNo'])){ echo $_REQUEST['AccountNo']; } ?>&date=<?php echo date('Y-m-d'); ?>",
          "dataType": "json",
          "type": "POST",
          "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                         },
          "columns": [
              { "data" : "TRANS_TYPE" },
              { "data" : "RefNo" },
              { "data" : "location" },
              { "data" : "BizDate" },
              { "data" : "SysDate" },
              { "data" : "User" },
              { "data" : "Points" },
              { "data" : "BillAmt" },
              // { "data" : "BillStatus" },
              { "data" : "Created_By" },
              { "data" : "view" },
             ] 
    });
  });

  function month_sale_list(month)
  {
    $('#purchase_list_server_side').DataTable({
          "destroy" : true,
          "processing": true,
          "serverSide": true,
          "searching": true,
          "order": [[ "1", "desc" ]],
          "columnDefs": [ {
            "targets": 9,
            "orderable": false
          } ],
          "ajax":{
          "url": "<?php echo site_url('Main_c/purchase_list_server_side?accountno='); ?><?php if(isset($_REQUEST['AccountNo'])){ echo $_REQUEST['AccountNo']; } ?>&date=" + month + "-01",
          "dataType": "json",
          "type": "POST",
          "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                         },
          "columns": [
              { "data" : "TRANS_TYPE" },
              { "data" : "RefNo" },
              { "data" : "location" },
              { "data" : "BizDate" },
              { "data" : "SysDate" },
              { "data" : "User" },
              { "data" : "Points" },
              { "data" : "BillAmt" },
              // { "data" : "BillStatus" },
              { "data" : "Created_By" },
              { "data" : "view" },
             ] 
    });
  }

  function trans_child_list(refno)
  {
    $('#trans_child_table').DataTable({
          "destroy" : true,
          "processing": true,
          "serverSide": true,
          "searching": true,
          "order": [[ 5, "asc" ]],
          "ajax":{
          "url": "<?php echo site_url('Main_c/purchase_child_list_server_side?'); ?>refno=" + refno,
          "dataType": "json",
          "type": "POST",
          "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                         },
          "columns": [
              {"data" : "RefNo" },
              {"data" : "PosID" },
              {"data" : "Location" },
              {"data" : "BizDate" },
              {"data" : "User" },
              {"data" : "Line" },
              {"data" : "Itemcode" },
              {"data" : "Description" },
              {"data" : "Point" },
              {"data" : "UnitPrice" },
              {"data" : "Qty" },
              {"data" : "Amount" },
              {"data" : "Itemrefund" },
          ] 
    });

    $("#child_list").modal('show');
  }

  function point_child_list(refno)
  {
    $('#trans_child_server_side').DataTable({
          "destroy" : true,
          "processing": true,
          "serverSide": true,
          "searching": true,
          "order": [[ 1, "desc" ]],
          "ajax":{
          "url": "<?php echo site_url('Main_c/point_child_list_server_side?'); ?>refno=" + refno,
          "dataType": "json",
          "type": "POST",
          "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                         },
          "columns": [
              { "data" : "REF_NO" },
              { "data" : "TRANS_TYPE" },
              { "data" : "ITEMCODE" },
              { "data" : "DESCRIPTION" },
              { "data" : "QTY" },
              { "data" : "VALUE_UNIT" },
              { "data" : "VALUE_TOTAL" },
          ] 
    });

    $("#point_child_list").modal('show');
  }

$(function(){
  
 
  <?php
    if($this->session->userdata('free_gift_redemption_modal') != NULL) 
    {
  ?>
      $('#modal-gift').modal('show');
  <?php
    }
  ?>

  <?php
    if($this->session->userdata('Clean_Up_Point_modal') != NULL) 
    {
  ?>
      $('#Clean_Up_Point').modal('show');
  <?php
    }
  ?>

  $('#import_redemption_table').DataTable({
        "order": [[ 2, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax":{
         "url": "<?php echo site_url('Item_c/mem_item_trans_list'); ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
        },
        "columns": [
          {"data": "Trans_type"},
          {"data": "refno"},
          {"data": "created_at"},
          {"data": "created_by"},
          {"data": "action"}
        ]   
    });

    $('#import_redemption_table').on('click', 'tbody button', function(){
       id = $(this).attr('id');
        $('#trans_child_table').DataTable({
          "destroy": true,
          "order": [[ 6, "desc" ]],
          "processing": true,
          "serverSide": true,
          "ajax":{
           "url": "<?php echo site_url('Item_c/trans_child_list?id='); ?>" + id,
           "dataType": "json",
           "type": "POST",
           "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
          },
          "columns": [
            {"data": "Trans_type"},
            {"data": "ITEM_CODE"},
            {"data": "ITEM_DESC"},
            {"data": "rec_qty"},
            {"data": "adj_in_qty"},
            {"data": "adj_out_qty"},
            {"data": "branch"},
            {"data": "created_at"},
            {"data": "created_by"},
          ]   
      });

      $('#modal_trans_child').find('#refno').text($(this).data('refno'));
      $('#modal_trans_child').modal('show');
    });


    $('#example3').DataTable({
      "paging": true,
      "lengthChange": true,
      "lengthMenu": [ [5,10, 25, 50, -1], [5,10, 25, 50, "All"] ],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "dom": '<"pull-left"l><"pull-right"f>tip',
      "order": [[0, 'desc']],
      stateSave: true,
      language: {
        searchPlaceholder: "Search records"
    }
    });

    $('#free_gift_table').DataTable({
        "columnDefs": [{
          "targets": 8,
          "orderable": false
        }],
        "order": [[ 4, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax":{
         "url": "<?php echo site_url('Point_c/free_gift_server_side'); ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
        },
        "columns": [
          {"data": "refno"},
          {"data": "branch"},
          {"data": "doc_date"},
          {"data": "date_redemption_from"},
          {"data": "date_redemption_to"},
          {"data": "description"},
          {"data": "created_at"},
          {"data": "created_by"},
          {"data": "updated_at"},
          {"data": "updated_by"},
          {"data": "redemption"}
        ]
    });

    $('#submit').DataTable({
      "order": [[8, 'desc'], [4, 'desc'] ],
      language: {
        searchPlaceholder: "Search records"
    }
    });
    $('#submit2').DataTable({
      "order": [[7, 'desc'], [2, 'desc'] ],
      language: {
        searchPlaceholder: "Search records"
    }
    });

  });
</script>

  
<script>


$(function () {
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show: false,

    }).on('show', function () {

    });

    $(".table-hover").find('tr[data-id]').on('click', function () {
  

        
        $('#title').html($(this).data('desc'));
        $('#orderDetails').html($('<b> Itemcode: ' + $(this).data('id') + '</b>'));
        $('#orderModal').modal('show');



    });

});
$(document).ready( function() {
  $('#id').click( function( event_details ) {
    $(this).select();
  });
});
</script>
<script>
  $('#listedcostalert').delay(5000).fadeOut("fast");
  $('#listedcostalert').delay(5000).fadeIn("fast");   


</script>

<script>
      
        $(window).load(function(){
          var varname = '<?php echo $_SESSION["method"]; ?>';
          if (varname == 'done')
          {
            $('#confirm_modal').modal('show');
          }
          
        });

</script>    

<script type="text/javascript">

$(".select2").select2();

</script>

<script type="text/javascript">
    $(document).ready(function() {
    $("input[name$='search_mode']").click(function() {
        var test = $(this).val();

        $("div.desc").hide();
        $("div.descDefault").hide();
        $("#method" + test).show();
    });
});
</script>

<script>

  function myFunction() {
      window.print();
  }
  
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.edit_condition_btn').click(function(){
      $('#modal-edit-condition').find('[name=guid]').val($(this).data('guid'));
      $('#modal-edit-condition').find('[name=query]').val($(this).data('query_data'));
      $('#modal-edit-condition').find('[name=have_rec_msg]').val($(this).data('have_rec_msg'));
      $('#modal-edit-condition').find('[name=seq]').val($(this).data('seq'));
      $('#modal-edit-condition').find('.submit_btn').prop('disabled', false);

      if($(this).data('have_rec_msg_abort') == '1')
      {
        $('#modal-edit-condition').find('[name=have_rec_abort]').prop('checked', true);
      }
      else
      {
        $('#modal-edit-condition').find('[name=have_rec_abort]').prop('checked', false); 
      }
      
      $('#modal-edit-condition').find('[name=no_rec_msg]').val($(this).data('no_rec_msg'));

      if($(this).data('no_rec_msg_abort') == '1')
      {
        $('#modal-edit-condition').find('[name=no_rec_abort]').prop('checked', true);
      }
      else
      {
        $('#modal-edit-condition').find('[name=no_rec_abort]').prop('checked', false); 
      }
    });

    $('#add_condition_btn').click(function(){
      $('#modal-condition').find('#condition_query').val('');
      $('#modal-condition').find('input[type=text]').val('');
      $('#modal-condition').find('input[type=checkbox]').prop('checked', false);
      $('.submit_btn').prop('disabled', false);
    });

    $('#condition_query').focus(function(){
      $('.submit_btn').prop('disabled', false);
    });

    $("#modal-condition #condition_query").blur(function(event){
      check_query($('#modal-condition').find('#condition_query').val());
    });

    $("#modal-edit-condition #edit_condition_query").blur(function(event){
      check_query($('#modal-edit-condition').find('#edit_condition_query').val());
    });

    $('#condition_list tbody').on('click', 'button.delete_condition_btn', function(){
       guid = $(this).data('guid');
       coupon_guid = $(this).data('coupon_guid');

      if(confirm("Did you want delete this condition?"))
      {
        window.location.href = "<?php echo site_url('Point_c/delete_free_gift?guid='); ?>" + guid + '&coupon_guid=' + coupon_guid;
      }
    });

    function check_query(query)
    {
      $.ajax({
        "method": "POST",
        "url": "<?php echo site_url('Point_c/check_query'); ?>",
        "data": { "query": query },
        "success": function(result){
          if(result == 1)
          {
            $('.submit_btn').prop('disabled', false);
          }
          else
          {
            alert(result);
            $('.submit_btn').prop('disabled', true);
          }
        }
      });
    }
  });
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   

    $('#Voucher_Type').select2();
});

$(document).ready(function(){
    $('#schedule_type').change(function() {
      
      if ( this.value == 'Annually' || this.value == 'Monthly')
      {
        $("#date").show();        
      }
      else
      {
        $("#date").hide();
        $('[name="date"]').val('0000-00-00');
      }

      if ( this.value == 'Weekly')
      {
        $("#day").show();
      }
      else
      {
        $("#day").hide();
        $('[name="day"]').val('');
      }
    });

    $('#points_type').change(function() {
 
      if ( this.value == 'Additional Addon')
      {
        $("#addon").show();
      }
      else
      {
        $("#addon").hide();
        $('[name="points_addon"]').val('');
      }
    });
});

$(function(){
  $('#free_gift_redemption_table').DataTable({
      "columnDefs": [ {
      "targets": 8,
      "orderable": false
      } ],
      "order": [[ 3, "desc" ]],
      "processing": true,
      "serverSide": true,
      "ajax":{
       "url": "<?php echo site_url('Point_c/free_gift_redemption_list'); ?>",
       "dataType": "json",
       "type": "POST",
       "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', "guid":"<?php if(isset($_REQUEST['guid'])){ echo $_REQUEST['guid']; } ?>" }
      },
      "columns": [
        { "data": "accountno" },
        { "data": "cardno" },
        { "data": "name" },
        { "data": "created_at" },
        { "data": "created_by" },
        { "data": "canceled" },
        { "data": "canceled_at" },
        { "data": "canceled_by" },
        { "data": "action" }
      ]     
    });

  $('#free_gift_redemption_table').on('click', 'tbody button', function(){
    if(confirm("Did you want cancel this redemption"))
    {
      window.location.href = "<?php echo site_url('Point_c/canceled?guid='); ?>" + $(this).attr('id') + "&coupon_guid=" + $(this).data('guid');
    }
  });
});
</script>




<!-- add by faizul for fuction sms (contact template) -->
<script type="text/javascript">
      $(document).ready(function () {
          toggleFields(); //call this first so we start out with the correct visibility depending on the selected form values
          //this will call our toggleFields function every time the selection value of our underAge field changes
          $("#template_type").change(function () {
              toggleFields();
          });

      });
</script>


<!-- add by faizul for fuction sms (serverside table for pick contact template) -->

<script type="text/javascript">

  $('#sms_template_contact').DataTable({
          "processing": true,
            "serverSide": true,
            "searching": true,
            "ajax":{
         "url": "<?php echo site_url('Sms_c/all_member?template_guid='.$_REQUEST['guid']); ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
        "columns": [
            { "data": "CardNo" },
              { "data": "AccountNo" },
              { "data": "Expirydate" },
              { "data": "ICNo" },
              { "data": "Phonemobile" },
              { "data": "Name" },
              { "data": "Action" }
              
           ]   
        });

</script>

<!-- add by faizul for fuction sms (serverside table for sending list) -->
<script type="text/javascript">
  $('#sms_sending_list').DataTable({
          "processing": true,
            "serverSide": true,
            "searching": true,
            "ajax":{
         "url": "<?php echo site_url('Sms_c/all_member?sending_list&template_guid='.$_REQUEST['guid']); ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
        "columns": [
            { "data": "Message" },
            { "data": "Characters" },
            { "data": "TotalSms" },
            { "data": "PhoneNo" },
            { "data": "AccountNo" },
            { "data": "Name" },
              
           ]   
        });
</script>

<!-- add by faizul for fuction sms (serverside table for confirm sending list) -->
<script type="text/javascript">

  $('#sms_confirm_list').DataTable({
          "processing": true,
            "serverSide": true,
            "searching": true,
            "ajax":{
         "url": "<?php echo site_url('Sms_c/all_member?sending_list&template_guid='.$guid); ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
        "columns": [
            { "data": "Message" },
            { "data": "Characters" },
            { "data": "TotalSms" },
            { "data": "PhoneNo" },
            { "data": "AccountNo" },
            { "data": "Name" },
              
           ]   
        });

</script>

<!-- add by faizul for fuction sms (serverside table for sms transaction history) -->
<script type="text/javascript">

  $('#sms_transaction').DataTable({
          "processing": true,
            "serverSide": true,
            "searching": true,
            "order": [[ 6, "desc" ]],
            "ajax":{
         "url": "<?php echo site_url('Sms_c/sms_transaction'); ?>",
         "dataType": "json",
         "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
        "columns": [
            { "data": "TransType" },
            { "data": "PhoneNo" },
            { "data": "AccountNo" },
            { "data": "Message" },
            { "data": "Status" },
            { "data": "Code" },
            { "data": "Date" },
            { "data": "CreatedBy" },
              
           ]   
        });

</script>


<!-- add by faizul for fuction sms (contact template) -->
<script type="text/javascript">
      $(document).ready(function () {
          toggleFields(); //call this first so we start out with the correct visibility depending on the selected form values
          //this will call our toggleFields function every time the selection value of our underAge field changes
          $("#branch_id1234").change(function () {
              toggleFields();
          });

      });
</script>

<!-- add by faizul for fuction sms (contact template) -->
<script type="text/javascript">
      $(document).ready(function () {
          toggleFields_prefix(); //call this first so we start out with the correct visibility depending on the selected form values
          //this will call our toggleFields function every time the selection value of our underAge field changes
          $("#prefix").change(function () {
              toggleFields_prefix();
          });

      });
</script>

<!-- add by faizul for fuction sms (contact template) -->
<script type="text/javascript">
      $(document).ready(function () {
          toggleFields_date(); //call this first so we start out with the correct visibility depending on the selected form values
          //this will call our toggleFields function every time the selection value of our underAge field changes
          $("#date").change(function () {
              toggleFields_date();
          });

      });
</script>


<!-- add by faizul for fuction sms (contact template) -->
<script type="text/javascript">
      $(document).ready(function () {
          toggleFields_random(); //call this first so we start out with the correct visibility depending on the selected form values
          //this will call our toggleFields function every time the selection value of our underAge field changes
          $("#random1234").change(function () {
              toggleFields_random();
          });

      });
</script>
</body>
</html>


