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
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css'); ?>">
  
  <link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/select2/select2.min.css');?>">

  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.min.css'); ?>">

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
<body class="hold-transition skin-green layout-top-nav  fixed">
<div class="wrapper">

<header class="main-header">
    <nav class="navbar navbar-static-top">
       <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
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
              <li><a href="<?php echo site_url('Transaction_c/activation'); ?>">Activation / Renew Card </a></li>
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
            
            
            <!-- <li><a href="#">Credit Customer</a></li> -->
            <li class="divider"></li>
            <?php
            if(in_array('PCM', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Transaction_c/pre_issue_card'); ?>">Pre-Issue Card</a></li><!-- <li><a href="<?php echo site_url('Transaction_c/issue_main_card'); ?>">Issue Main Card</a></li> -->
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
        
        <?php
            if(in_array('PA', $_SESSION['module_code']))
            {
              ?>
              <li class="dropdown">
                
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Point <span class="caret"></span></a>
                
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo site_url('Point_c'); ?>?column=POINT_ADJ_IN">Point Adjust In</a></li>
                  <li><a href="<?php echo site_url('Point_c'); ?>?column=POINT_ADJ_OUT">Point Adjust Out</a></li>
                </ul>
              </li>
              <?php
            }
          ?>

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
            { ?>

              <li><a href="<?php echo site_url('Setup_general_c/setup'); ?>">General</a></li>

            <?php }
            if(in_array('SO', $_SESSION['module_code']))
            { ?>

              <li><a href="<?php echo site_url('Setup_general_c/operation'); ?>">Operation</a></li>

            <?php } ?>

            <?php
            if(in_array('RSI', $_SESSION['module_code']))
            {
              ?>
              <li><a href="<?php echo site_url('Item_c'); ?>">Redemption</a></li>
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
              <li><a href="<?php echo site_url('Pending_c/search_to_deactivate'); ?>">Deactivate</a></li>
              <li><a href="<?php echo site_url('Log_c'); ?>">Log</a></li>
              <?php
            }
            ?>
          </ul>
        </li>

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
<!-- not use -->
<!-- <script>
    $(document).ready(function () {
        $('#learn').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "<?php echo site_url('main_c/posts') ?>",
                "dataType": "json",
                "type": "POST",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
      "columns": [
              { "data": "id" },
              { "data": "title" },
              { "data": "body" },
              { "data": "created_at" },
           ]   

      });
    });
</script> -->

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
              { "data": "IC No" },
              { "data": "Phone No" },
              { "data": "Name" },
              { "data": "Full Detail" },
              { "data": "Purchase Details" }
           ]   
        });
    <?php
      }
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
            { "data": "Card No" },
              { "data": "Account No" },
              { "data": "Expired Date" },
              { "data": "IC No" },
              { "data": "Phone No" },
              { "data": "Name" },
              { "data": "Full Detail" },
              { "data": "Purchase Details" }
           ]   
        });
      <?php
        }
      ?>

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
              { "data": "IC No" },
              { "data": "Phone No" },
              { "data": "Name" },
              { "data": "Credit" },
              { "data": "Full Detail" },
              { "data": "Purchase Details" }
           ]   
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

$( ".datepicker" ).datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd'
});

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

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>


</body>
</html>

