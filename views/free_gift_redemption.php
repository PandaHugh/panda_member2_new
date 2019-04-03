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
      <h1>Free Gift Redemption</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        
          <div class="box-header">
            <a href="<?php echo site_url('Point_c/free_gift'); ?>">
              <button class="btn btn-success pull-right">Back</button>
            </a>
            <?php
              if(($date_redemption_from <= date('Y-m-d') && $date_redemption_to >= date('Y-m-d')) || ($date_redemption_from == "" && $date_redemption_to == ""))
              {
            ?>
              <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('Point_c/gift_scan_card'); ?>">
                <div style="overflow-x:auto;">
                  <input type="text" class="form-control" name="cardno" placeholder="Scan Card No" autofocus>
                  <input type="hidden" name="coupon_guid" value="<?php echo $_REQUEST['guid']; ?>">
                  <select class="form-control" name="branch" required>
                    <?php
                      foreach($branch as $branch)
                      {
                    ?>
                        <option value="<?php echo $branch['branch_code']; ?>"><?php echo $branch['branch_name']." (".$branch['branch_code'].")"; ?></option>
                    <?php
                      }
                    ?>
                  </select>
                </div>

              </form>
            <?php
              }
            ?>  
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div style="overflow-x:auto;">
            <table id="free_gift_redemption_table" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Account No</th>
                <th>Card No</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Created By</th>
                <th>Cancel</th>
                <th>Cancel At</th>
                <th>Cancel By</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
                
            </table>
            </div>
        </div>
        <!-- /.box -->

<div class="modal fade" id="modal-gift">
  <form class="form-horizontal" role="form" method="POST" id="myForm" action="<?php echo site_url('Point_c/submit_free_gift_redemption?guid='.$_REQUEST['guid']); ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <span style="font-size:20px;" class="pull-right">Points <?php
              if($this->session->userdata('free_gift_redemption_point') != NULL) 
              {
                echo $this->session->userdata('free_gift_redemption_point');
              }
            ?></span>
          <h4 class="modal-title">Card No :  
            <?php
              if($this->session->userdata('free_gift_redemption_cardno') != NULL) 
              {
                echo $this->session->userdata('free_gift_redemption_cardno');
              }
            ?></h4>
        </div>
        <div class="modal-body">
          <center>
            <input type="hidden" name="cardno" value="<?php
              if($this->session->userdata('free_gift_redemption_cardno') != NULL) 
              {
                echo $this->session->userdata('free_gift_redemption_cardno');
              }
            ?>">
            <input type="hidden" name="coupon_guid" value="<?php echo $_REQUEST['guid']; ?>">
            <input type="hidden" name="branch" value="<?php
              if($this->session->userdata('free_gift_redemption_branch') != NULL) 
              {
                echo $this->session->userdata('free_gift_redemption_branch');
              }
            ?>">
            <span style="font-size:50px;">
              <?php
                if($this->session->userdata('free_gift_redemption_have_rec_msg') != NULL) 
                {
                  echo $this->session->userdata('free_gift_redemption_have_rec_msg');
                }
              ?>
            </span>
            <span style="font-size:50px;">
              <?php
                if($this->session->userdata('free_gift_redemption_no_rec_msg') != NULL) 
                {
                  echo $this->session->userdata('free_gift_redemption_no_rec_msg');
                }
              ?>
            </span>
          </center>
        </div>
        <div class="modal-footer">
          <?php
            if($this->session->userdata('free_gift_redemption_have_rec_msg') != NULL && !isset($cannot_redemption)) 
            {
          ?>
          <div class="form-group">
              <label class="control-label col-lg-3">IC</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="tac" placeholder="Exp: XXXXXX012345 (Last 6 digits IC No)" required>
              </div>
            </div>
          <?php
            }
          ?>
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
          <?php
            if($this->session->userdata('free_gift_redemption_have_rec_msg') != NULL && !isset($cannot_redemption)) 
            {
          ?>
          <button type="submit" class="btn btn-primary pull-right" style="margin-right:5px;">Redemp</button>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
  </form>
</div>