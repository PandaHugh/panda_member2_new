

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

<script type="text/javascript">


</script>

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
      <h1>Point Adjust-OUT </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <form method="post" action="<?php echo site_url('Transaction_c/create_pre_issue_card'); ?>">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Receipt No </label>
                <input type="text" id="pre" name="prefix" class="form-control" placeholder="Receipt No" onkeydown="upperCaseF(this)" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Card </label>
                <select name="cardtype" class="form-control" id="card" required>
                  <option disabled hidden></option>

                  

                </select>
              </div>
              
            </div>
            <!-- /.col -->
            <div class="col-md-4">

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Point Before </label>
                  <input type="number" min="0" step="any" name="nofrom" class="form-control" placeholder="Valid From" value="" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Point After </label>
                  <input type="number" min="0" name="noto" class="form-control" placeholder="Valid To" value="" required>
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Account No</label>
                  <input type="number" id="suf" min="1" name="runningno" class="form-control" placeholder="Ref No" max="20" value="" required>
                </div>
              </div>
              <div class="col-md-6">
                
              </div>
              </div>
              
              <!-- <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" name="remark" rows="3" placeholder="Remarks"><?php echo $remark_in; ?></textarea>
              </div> -->
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
             <div class="lockscreen-wrapper">
                <div class="lockscreen-logo">
                  <a href="../../index2.html"><b style="color: #ff9900">Page Under Construction</b> <i class="fa fa-spin fa-refresh"></i></a>
                </div>
                <!-- User name -->
                <div class="lockscreen-name"></div>

                <!-- START LOCK SCREEN ITEM -->
                <div class="lockscreen-item">
                 
                

                </div>
                <!-- /.lockscreen-item -->
                <div class="help-block text-center">
                  Contact Panda Support.
                </div>
                <div class="text-center">
                  <!-- <a href="login.html">Return Back</a> -->
                </div>
                <div class="lockscreen-footer text-center">
                  Copyright &copy; <b><a href="http://www.pandasoftware.my/" class="text-black">Panda Software House Sdn. Bhd.</a></b><br>
                  All rights reserved
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
          
        </div>
        <!-- /.box-body -->
      </form>
      </div>
      <!-- /.box -->

      <!-- <div class="box box-default">
        
        <div class="box">
          <div class="box-body">
            
          </div>
          
        </div>
         -->
      </div>
      
    </section>
