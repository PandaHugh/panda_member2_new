<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Panda | Web Ordering Module</title>
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/a.png');?>" >
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/bootstrap/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/datatables/dataTables.bootstrap.css');?>">
  <!-- Datatable Responsive -->
  <link href="<?php echo base_url('assets/template/vendor/datatables-responsive/dataTables.responsive.css');?>" rel="stylesheet">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/dist/css/AdminLTE.min.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/dist/css/skins/_all-skins.min.css');?>">
  <!-- Selectpicker -->
  <link rel="stylesheet" href="<?php echo base_url('dist/css/bootstrap-select.css')?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="<?php echo base_url('dist/js/bootstrap-select.js')?>"></script>
  <!-- Angular JS -->  
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>   
  <style type="text/css">
  table {
    font-size: 12px;
  } 
  @media screen and (max-width: 768px) {
  p,input,div,span,h4 {
    font-size: 95%;
  }
}
  </style>

</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>W</b>OM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-xs">Web Ordering Module</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="footer"><a style="cursor: pointer;"> Login As : <?php echo $_SESSION['username']; ?></a></li>
          <?php
          if(isset($_SESSION['show_password']) == 1)
          {
            ?>
            <li class="footer"><a href="#" data-toggle="modal" data-target="#myModal">Show Password</a></li>
            <?php
          }
          ?>
          
          <li><a href="<?php echo site_url('logout_c/logout')?>"><center><i class="fa fa-sign-out" aria-hidden="true"></i>Log Out</center></a></li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="treeview">
          <a href="<?php echo site_url('User_manager_c/buyer_user_setup'); ?>">
            <i class="fa fa-user"></i> <span>Buyer User</span>
          </a> </li>
          <?php
          if(isset($_SESSION['supplier_setup']) == 1)
          {
            ?>

            <li class="treeview">
              <a href="<?php echo site_url('User_manager_c/supplier_group_setup'); ?>">
                <i class="fa fa-group"></i> <span>Supplier Group</span>
              </a>

            </li>
           

            
            <li class="treeview">
              <a href="<?php echo site_url('User_manager_c/supplier_user_setup'); ?>"><i class="fa fa-user"></i> <span>Supplier User</span></a>
            </li>



            <?php
          }
          ?>
        
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
                <?php echo $contents ;?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>    
      </div>
  </section>
</div>   
  <!-- /.content-wrapper -->
  <footer class="main-footer">
   <div class="pull-right hidden-xs">
      <b>Web Ordering Module v</b> 2.0
    </div>
   <strong class="hidden-md hidden-lg"><center>&copy; Panda Software House Sdn. Bhd. </center></a></strong>
    <strong class="hidden-xs hidden-sm">&copy; Panda Software House Sdn. Bhd.</a></strong>
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
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
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": true,
      "dom": '<"pull-left"l><"pull-right"f>tip',
    });
  });
</script>

<script>
      $(document).ready(function () {
        var mySelect = $('#first-disabled2');

        $('#special').on('click', function () {
          mySelect.find('option:selected').prop('disabled', true);
          mySelect.selectpicker('refresh');
        });

        $('#special2').on('click', function () {
          mySelect.find('option:disabled').prop('disabled', false);
          mySelect.selectpicker('refresh');
        });

        $('#basic2').selectpicker({
          liveSearch: true,
          maxOptions: 1
        });
      });
    </script>


</body>
</html>


 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center>Your Password</center></h4>
        </div>
        <div class="modal-body">
          <h2><center>
          <?php
              foreach($password->result() as $row)
              {
                echo $row->password;
              }
          ?>      
          </center></h2>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>