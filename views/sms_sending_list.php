

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

  <div class="row">
    <div class="col-md-12">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $title; ?>
      <button onclick="window.location.href='<?php echo site_url('Sms_c/sending_template')?>'" name="save" class="btn btn-default btn-sm" style="float: right" onclick="add_promo()"><span style="color:white"></span> <b>BACK</b></button></h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">

          <!-- /.box-header -->
          <div class="box-body">
              <div style="overflow-x:auto;">
              <table id="sms_sending_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Message</th>
                  <th>Characters</th>
                  <th>TotalSms</th>
                  <th>PhoneNo</th>
                  <th>AccountNo</th>
                  <th>Name</th>
                </tr>
                </thead>
                  
              </table>
              </div>
          </div>
        </div>
      </section>
        <!-- /.box -->

