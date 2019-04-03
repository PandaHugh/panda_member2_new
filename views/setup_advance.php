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
      <h1>Setup - <?php echo $title; ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <form method="post" action="<?php echo $action; ?>">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label><?php echo $label1; ?></label>
                <input type="text" name="input1" class="form-control" placeholder="" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><?php echo $label2; ?></label>
                <input type="text" name="input2" class="form-control" placeholder="" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><?php echo $label3; ?></label>
                <input type="text" name="input3" class="form-control" placeholder="" required>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
              <div class="form-group">
                <label><?php echo $label4; ?></label>
                <input type="text" name="input4" class="form-control" placeholder="" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><?php echo $label5; ?></label>
                <input type="text" name="input5" class="form-control" placeholder="" required>
              </div>
              <!-- /.form-group -->

              <?php if(isset($label6))
              { ?>

                <div class="form-group">
                  <label><?php echo $label6; ?></label>
                  <input type="text" name="input6" class="form-control" placeholder="" required>
                </div>

              <?php } ?>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
          <div class="col-md-4">
            <br>
            <button type="submit" class="btn btn-success pull-left">Save</button>
          </div> 
          </div>
        </div>
        <!-- /.box-body -->
      </form>
      </div>
      <!-- /.box -->
    </section>