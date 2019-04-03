

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

#scroll {
  height: 250px;
  overflow-y: scroll;
}

</style>

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
      <!-- <h1 class="page-head-line">
          <a href="<?php echo site_url('Point_c')?>?column=<?php echo $column; ?>" class="btn btn-default btn-xs"  style="float:right;" >
            <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
      </h1> -->
      <h1><?php echo $title; ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        
          <div class="box-header">
            <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('Point_c/add_point_adj_in_out'); ?>?column=<?php echo $column; ?>&accountno=<?php echo''?>&guid=<?php echo ''?>">

            <?php if($title != 'Cash Redemption')
            { ?>

              <div style="overflow-x:auto;">
                <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                <span style="color:white"></span><b>ADD</b></button>
              </div>

            <?php }; ?>

            </form>  
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div style="overflow-x:auto;">
            <table id="point_in_out_trans" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Edit</th>
                <th>Posted</th>
                <th>Reference No</th>
                <th>Date</th>
                <th>Code</th>
                <th>Name</th>
                <th>Total Value</th>
                <th>Remarks</th>
                <th>Created at</th>
                <th>Created by</th>
                <th>Updated at</th>
                <th>Updated by</th>
              </tr>
              </thead>
            </table>
            </div>
        </div>
        <!-- /.box -->