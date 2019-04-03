<?php 
'session_start()' 
?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script src="<?php echo base_url('js/jquery.min.js');?>"></script> 

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
                    
  <div class="row">
    <div class="col-md-12">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Create Transaction</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-success">
        
        <div class="box-body">
          <div class="row" <?php echo $setup_style?>>
            <div class="col-md-4">

              <div class="form-group">
                  <label for="varchar" class=" control-label">Service Provider</label>
                  <input readonly type="text" class="form-control" value="<?php echo $provider->row('provider')?>" required name="provider" >

              </div>

              <div>
                <button title="Send Partial SMS" id="create" type="button" class="btn btn-success" style="width: 100%" data-toggle="modal" data-name='prefixvalue' data-oriname="runningnos" >Send Partial SMS</button>
              </div>
            </div>

              <div class="col-md-4" style="">
                <div class="form-group">
                  <form  method="post" action="<?php echo site_url('Sms_c/create_trans')?>">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Select Sending Template</label>
                            <select name="sending_template" id="sending_template" class="form-control" style="background: #e6f497">
                              <?php 
                              foreach ($sending_template->result() as $row)
                                {
                                  ?>
                                  <option value="<?php echo $row->guid?>"><?php echo $row->template_name?></option>
                                  <?php
                                }
                              ?>     
                              </select>
                          </div>
                        </div>
                      </div>
                    
                </div>

                <div >
                
                <button title="Submit" id="create" type="submit" class="btn btn-primary pull-right"  >Submit</button> <!-- onclick="$('#save').submit()" -->
                </form>
                </div>
              </div>

            </div>
          </div>  


          <div class="box-body" <?php echo $box_style?>>
          <?php
          if($this->session->userdata('confirm_message'))
          {
             echo $this->session->userdata('confirm_message') <> '' ? $this->session->userdata('confirm_message') : ''; 
          }
          ?>

          <?php
          if($this->session->userdata('confirm_button'))
          {
             echo $this->session->userdata('confirm_button') <> '' ? $this->session->userdata('confirm_button') : ''; 
          }
          ?>

              <div style="overflow-x:auto;">
              <table id="sms_confirm_list" class="table table-bordered table-striped">
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
            
        <!-- /.box-body -->
        
      </div>

      <!-- /.box -->

    </section>


<script type="text/javascript">

$('#create').click(function() {
      $('#\\#success').modal('show');
    
});
</script>

<div class="modal fade" id="#success">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body form">
                <form action="<?php echo site_url('Sms_c/send_sms?partial&provider_guid='.$provider->row('guid'))?>" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-6">
                                <center><p><label>Phone number</label></p><center>
                                <input required name="phoneno" class="form-control" type="number" required maxlength="50">
                                <br>
                                <center><p><label>Message</label></p></center>
                                <textarea id="textarea" class="form-control" name="message" rows="4" placeholder="Type your message here.."></textarea>
                                <div id="textarea_feedback"></div>
                                <div id="total_sms"></div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Send</button>
                      <button type="button" onClick="window.location.reload()" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>