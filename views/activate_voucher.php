
<!-- <script src="<?php echo base_url('js/jquery.min.js');?>"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
      <h1>Activate Voucher </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <form method="post" name="myform" id="myform" action="<?php echo site_url('Transaction_c/insert_activate_voucher'); ?>">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>From <a style="color:red;">*</a></label>
                <input type="number" id="From" name="From" class="form-control" placeholder="From no." required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group" style="color:black; font-size:12px;">
                <p></p>
                <p><i class="fa fa-info-circle" aria-hidden="true"></i> Remember to setup <br><b style="color: red;"">check digit</b> from Setup > General</p>
              </div>
            </div>
              <!-- /.form-group -->
            <!-- <div class="col-md-4">
              <div class="form-group">
                <br>
                <label>
                <input type="checkbox" name="check_digit" id="check_digit" readonly value="1" /> With check digit
                </label>
              </div>
            </div> -->
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>To <a style="color:red;">*</a></label>
                <input type="number" id="To" name="To" class="form-control" placeholder="To no." required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <br>
              <button title="Activate" id="Activate" type="button" class="btn btn-success pull-left" data-toggle="modal" data-name='prefixvalue' data-oriname="runningnos">Activate</button>
            </div> 
          </div> 
        
            </div>
            <!-- /.col -->
          <!-- /.row -->
          
      </form>
      </div>
      <!-- /.box -->
    </section>


<script type="text/javascript">

$('#Activate').click(function() {
    
    var test1 = $('#From').val();
    var test2 = $('#To').val();
    var x = document.forms["myform"]["From"].value;
    var y = document.forms["myform"]["To"].value;

    if (x == '' || y == '')
    {
      alert("Please fill in required field");
      return false;
    }

    if (parseInt(test1) > parseInt(test2))
    {
      $('#\\#fail').modal('show');
      document.getElementById('msg1').innerHTML = "'To' number must be more than 'From' number!";
      return false;
    }
    else 
    {
      document.getElementById("myform").submit();
      /*$("#user_id").val($(this).attr('data-id')); 
      $('#\\#success').modal('show');
      */
      /*$('#\\#success').modal('show');
      $('#From').html($('#From').val());
      $('#To').html($('#To').val());*/
      
    }
});

</script>

<div class="modal fade" id="#fail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title" style="color:red;">Reminder!</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_race')?>" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                      <!-- <center><strong><p>Length of prefix code + suffix digit cannot be more than 20</p></strong></center> -->
                      <h2><center><div id="msg1"></div></center></h2>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <!-- <button type="submit" class="btn btn-sm btn-primary">Save</button> -->
                      <center><button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" >OK </button></center>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="#success">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title">Confirmation!</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('Transaction_c/create_pre_issue_card')?>" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-6">
                              <!-- <h2><center><div style="color:red;" id="msg1"></div></center></h2> -->
                              <label>Name:  <span id="From"></span></label>
                              <label>Contact Number:  <span id="To"></span></label>
                                <!-- <input id="msg" name="" class="form-control" type="text" required maxlength="60"> -->
                                <!-- <h2><center><div style="color:red;" id="msg"></div></center></h2> -->
                                <!-- <center><p><label>Are you sure want to activate voucher no. from<br><p id="msg1"></p><br>to<br><p id="msg2"></p></label><center> -->
                                <!-- <input name="sample" class="form-control" type="text" required maxlength="50"></p> -->
                                <input type="" name="prefix" id="From" value=""/>
                                <input type="" name="suffix" id="To" value=""/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
