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
    <div class="box">
            <!-- /.box-header -->
    <div class="box-body">

    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
            <div id="page-inner">
             <?php if($this->session->flashdata('msg')): ?>
            <strong><center><?php echo $this->session->flashdata('msg'); ?></center></strong>
            <?php endif; ?>
            <?php if($this->session->userdata('message'))
            {
               echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
            } ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                  <section class="content-header">
                                    <h1><?php echo $title ?></h1><br>
                                  </section>
                                </div>
                                   <form class="form-inline" role="form" method="POST" id="myForm" 
                        action="<?php echo $form_submit; ?>">
                                      <?php if($show_input_field == 'true') { ?>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Scan Card No. <a style="color:red;">*</a></label>
                                                  <input name="confirm_cardno" id="confirm_cardno" type="text" class="form-control" required autofocus />
                                            </div>
                                          </div>
                                        </div>
                                      <?php } ?>
                                  </form>
                                 
                                <?php if($show_other_field == 'true') { ?>
                                <?php foreach($data->result() as $row) { ?>
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Name</label>
                                                  <input name="cardname" id="cardname" type="text" class="form-control" value = "<?php echo $row->Name ?>" readonly />
                                            </div>
                                    </div>
                                     <div class="col-md-6">
                                            <div class="form-group">
                                              <label>IC No</label>
                                                  <input name="ICNo" id="ICNo" type="text" class="form-control" value = "<?php echo $row->ICNo ?>" readonly />
                                            </div>
                                    </div>
                                     <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Account No</label>
                                                  <input name="AccountNo" id="AccountNo" type="text" class="form-control" value = "<?php echo $row->AccountNo ?>" readonly />
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Card No</label>
                                                  <input name="CardNo" id="CardNo" type="text" class="form-control" value = "<?php echo $row->CardNo ?>" readonly />
                                            </div>
                                    </div>

                                    <div class="col-md-6">
                                            <div class="form-group">
                                              <label>E Wallet Type</label>
                                              <select class="form-control" name="wallet_name" id="wallet_name" >
                                                  <?php foreach($wallet->result() as $row2) { ?>
                                                      <option value="<?php echo $row2->wallet_guid ?>" <?php if($row2->preset == '1'){ echo 'selected'; } ?> ><?php echo $row2->wallet_name ?></option>
                                                  <?php } ?>
                                              </select>
                                            </div>
                                            <button type="" id="javascript_para" class="btn btn-primary" style="margin-top: 5px;" onclick="ahsheng()" >Assign Member to E Wallet</button><br>
                                    </div>

                                   <script>
                                         function ahsheng() {
                                              location.href = '<?php echo $form_submit ?>?cardno=<?php echo $row->CardNo?>&guid=<?php echo $guid ?>&wallet_name='+$('#wallet_name').val();
                                            }
                                    </script>
                                </div>
                              <?php } } ?>
                            </div>
                             
                        </div>
                       
            </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    </div>
    </div>
    