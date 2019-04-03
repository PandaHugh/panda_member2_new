<style>
#last_activity{
    height: 410px;
    overflow-y: scroll;
  }
#scroll {
  height: 250px;
  overflow-y: scroll;
}

</style>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

</script>
<style> 
/*body {
    overflow-y: hidden;
}*/
</style>
<!--onload Init-->
<body>
    
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
    <div id="page-inner">

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo number_format($total_voucher)?></h3>

              <p>Voucher</p>
            </div>
            <div class="icon">
              <i class="ion-cash"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <?php
            if($preissue_card_method == '0' && $terminate_expiry_month != '0')
            {
          ?>
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo number_format($total_activation); ?>
                  <span style="font-size:20px;">(<?php echo number_format($total_active_percent)?>%)</span></h3>

                  <p>Active Member</p>
                </div>
                <div class="icon">
                  <i class="ion-android-checkmark-circle"></i>
                </div>
                <a href="<?php echo site_url('Transaction_c/activation')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
          <?php
            }
            else
            {
          ?>
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo number_format($total_member)?><sup style="font-size: 20px"></sup></h3>

              <p>Member Card Registered</p>
            </div>
            <div class="icon">
              <i class="ion-android-person"></i>
            </div>
            <a href="<?php echo site_url('Main_c')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
          <?php
            }
          ?>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo number_format($total_expiry_date_member)?></h3>

              <p>Member Expired</p>
            </div>
            <div class="icon">
              <i class="ion-android-time"></i>
            </div>
            <a href="<?php echo site_url('Transaction_c/activation')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <?php
            if($preissue_card_method == '0' && $terminate_expiry_month != '0')
            {
          ?>
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo number_format($total_member)?><sup style="font-size: 20px"></sup></h3>

                  <p>Member Card Registered</p>
                </div>
                <div class="icon">
                  <i class="ion-android-person"></i>
                </div>
                <a href="<?php echo site_url('Main_c')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
          <?php
            }
            else
            {
          ?>
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo number_format($total_active_percent)?><sup style="font-size: 20px">%</sup></h3>

              <p>Active Member</p>
            </div>
            <div class="icon">
              <i class="ion-android-checkmark-circle"></i>
            </div>
            <a href="<?php echo site_url('Transaction_c/activation')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
          <?php
            }
          ?>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-default">
            <div class="inner">
              <h3><?php echo number_format($total_preactivated)?></h3>

              <p>Pending Activation</p>
            </div>
            <div class="icon">
              <i class="ion-android-clipboard"></i>
            </div>
            <a href="<?php echo site_url('Transaction_c/pending_activation')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-6">
          <div class="box box-solid" id="last_activity">
            <div class="box-header with-border">
              <h4 class="box-title">Last Activity</h4>
            </div>
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Type</th>
                <th>Account No</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Created By</th>
              </tr>
              </thead>
              <tbody>

                <?php 
                foreach($last_activity->result() as $row)
                { 
                  ?>

                <tr>
                  <td><?php echo $row->TYPE; ?></td>
                  <td><?php echo $row->AccountNo; ?></td>
                  <td><?php echo $row->Name; ?></td>
                  <td><?php echo $row->created_at; ?></td>
                  <td><?php echo $row->created_by; ?></td>
                </tr>
                
                <?php 
                } 
                ?>
                
            </table>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-6">

                        <!--3-->
                        <div class="panel panel-default" style="margin-bottom:100px">
                            <div id="carousel-example" class="carousel slide" data-ride="carousel" style="">

                                <div class="carousel-inner" >
                                    <div class="item active" >
                                        <img src="<?php echo base_url('assets/img/panda image/1.jpg')?>" alt="" />

                                    </div>
                                    <div class="item">
                                        <img src="<?php echo base_url('assets/img/panda image/2.jpg')?>" alt="" />

                                    </div>
                                    <div class="item">
                                        <img src="<?php echo base_url('assets/img/panda image/3.jpg')?>" alt="" />

                                    </div>
                                </div>
                                <!--INDICATORS-->
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example" data-slide-to="1"></li>
                                    <li data-target="#carousel-example" data-slide-to="2"></li>
                                </ol>
                                <!--PREVIUS-NEXT BUTTONS-->
                                <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>
                        </div>
                        <!--3-->

                    </div>
                    <!-- /.REVIEWS &  SLIDESHOW  -->
      </div>

    </section>
   