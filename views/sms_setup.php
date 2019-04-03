<?php 
'session_start()' 
?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script src="<?php echo base_url('js/jquery.min.js');?>"></script>

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
      <h1>SMS Provider Setup</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">

              <div class="form-group">
                    <form  method="post" action="<?php echo site_url('Sms_c/setup'); ?>">
                    <label for="varchar" class=" control-label">Select Service Provider</label>
                      <select name="provider" id="provider" class="form-control" onchange="this.form.submit()"
                      style="background: #e6f497">
                          <?php 
                          foreach ($setup_all->result() as $row)
                              {
                                  ?>
                                  <option <?php
                                  if($row->set == '1')
                                  {
                                      echo "selected data-default";
                                  } 
                                  ?> value="<?php echo $row->guid?>"><?php echo $row->provider?></option>
                                  <?php
                              }
                          ?>     
                      </select>
                      <br>
                    </form>

                    <?php 
                      if($setup->row('provider') == 'ONEWAY')
                      {
                        ?>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Current Balance</label>
                              <input type="text" class="form-control" value="<?php echo $oneway_balance?>" disabled name="sender_id" >
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Sender ID</label>
                              <input type="text" class="form-control" value="<?php echo $setup->row('sender_id')?>" required name="sender_id" disabled >
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                      ?>
                                    
                </div> 
              </div>

              <div class="col-md-4" style="">
                <div class="form-group">
                  <form  method="post" action="<?php echo site_url('Sms_c/setup_action?guid='.$setup->row('guid')); ?>">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>URL</label>
                            <input type="text" class="form-control" value="<?php echo $setup->row('url')?>" required name="url" onfocusout="this.form.submit()" >
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Api Username</label>
                            <input type="text" class="form-control" value="<?php echo $setup->row('api_username')?>" required name="api_username" onfocusout="this.form.submit()">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Api Password</label>
                            <input type="password" class="form-control" value="<?php echo $setup->row('api_password')?>" required name="api_password" onfocusout="this.form.submit()">
                          </div>
                        </div>
                      </div>
                      
                    </form>
                </div>

                <div >
                
                <button style="float: right" title="Edit" id="create" type="button" class="btn btn-success pull-right" data-toggle="modal" data-name='prefixvalue' data-oriname="runningnos" >Test Send</button> <!-- onclick="$('#save').submit()" -->
                </div>
              </div>

              <div class="col-md-4 well" >
                      <h4><b>Message :</b></h4>
                      <p>Normal Text message (160 characters as 1MT)</p>
                      <!-- <p>Unicode Text message (70 characters as 1MT)</p> -->
                      <h4><b>Firewall :</b></h4>
                      <p>Allow port <b>10001</b> on firewall for ONEWAY or <b>8443</b> for MAXIS</p>
              </div>

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

<script type="text/javascript">
  


</script>



<div class="modal fade" id="#success">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body form">
                <form action="<?php echo site_url('Sms_c/send_sms?testing&provider_guid='.$setup->row('guid'))?>" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-6">
                                <center><p><label>Phone number</label></p><center>
                                <input required name="phoneno" class="form-control" type="number" required maxlength="50">
                                <br>
                                <center><p><label>Message</label></p></center>
                                <textarea id="textarea" class="form-control" name="message" rows="4" placeholder="Type your message here.."></textarea>
                                <div id="textarea_feedback" ></div>
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