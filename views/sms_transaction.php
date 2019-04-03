<script src="<?php echo base_url('js/jquery.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/mykad.js'); ?>" language="javascript" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
      <button title="Send Partial SMS" id="export" type="button" class="btn btn-success" style="float: right" data-toggle="modal" ><i class="fa">&#xf1c3;</i> EXPORT</button>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">

          <!-- /.box-header -->
          <div class="box-body">
              <div style="overflow-x:auto;">
              <table id="sms_transaction" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Trans Type</th>
                  <th>PhoneNo</th>
                  <th>AccountNo</th>
                  <th>Message</th>
                  <th>Status</th>
                  <th>Code</th>
                  <th>Date</th>
                  <th>CreatedBy</th>
                </tr>
                </thead>
                  
              </table>
              </div>
          </div>
        </div>
      </section>
        <!-- /.box -->


<div class="modal fade" id="#export" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Export to excel</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Export_excel_c/export_sms_trans')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="guid"/> 
                    <div class="form-body">
                        
                        <div class="form-group">
                          <label class="control-label col-md-3">Date From</label>
                            <div class="col-md-9">
                              <input name="date_from" class="form-control" type="date" required >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3">Date To</label>
                            <div class="col-md-9">
                              <input name="date_to" class="form-control" type="date" required >
                                <span class="help-block"></span>
                            </div>
                        </div>
                                
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary" onClick="window.location.reload();">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div>
    </div>
</div>


<script type="text/javascript">

$('#export').click(function() {
      $('#\\#export').modal('show');
    
});
</script>

