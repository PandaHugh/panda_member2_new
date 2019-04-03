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
        <h1>Import Redemption</h1>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="box box-default">
          
            <div class="box-header">
              <button class="btn btn-primary" data-toggle="modal" data-target="#import_excel">Import Excel</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow-x:auto;">
                <table id="import_redemption_table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Trans Type</th>
                    <th>RefNo</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                    
                </table>
              </div>
          </div>
          <!-- /.box -->
      </div>
    </section>
  </div>
  </div>

  <div class="modal fade" id="import_excel" role="dialog">
    <div class="modal-dialog">
      <form method="POST" enctype="multipart/form-data" action="<?php echo site_url('Item_c/submit_redemption_trans'); ?>">                  
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="text-align: center">Import Excel</h3>
            </div>
            <div class="modal-body">
              <!-- <label>Excel File:</label>      -->                   
              <div class="form-group" style="overflow:auto;">
                <label class="label-control col-sm-3">Trans Type</label>
                <div class="col-sm-9">
                  <select class="form-control" name="trans_type">
                    <option value="none">--- Trans Type ---</option>
                    <option value="Receive">Receive</option>
                    <option value="Adjust">Adjust</option>
                  </select>
                </div>
              </div>
              <input id="dragndrop" type="file" name="userfile" style="height:300px;width:100%;background-image:url('<?php echo base_url(); ?>assets/img/drag-drop-file-uploading.gif');background-size:100%;"/>
            </div>
            <div class="modal-footer">
              <a href="<?php echo site_url('Item_c/download_sample'); ?>">
                <button type="button" class="btn btn-success pull-left">Download Sample</button>
              </a>
              <button class="btn btn-primary pull-right">Save</button>
            </div>
        </div><!-- /.modal-content -->
      </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_trans_child" role="dialog">
    <div class="modal-dialog modal-lg">              
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title" id="refno"></h3>
          </div>
          <div class="modal-body">
            <table id="trans_child_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Trans Type</th>
                  <th>Item Code</th>
                  <th>Item Description</th>
                  <th>Receive Qty</th>
                  <th>Adjust In Qty</th>
                  <th>Adjust Out Qty</th>
                  <th>Branch</th>
                  <th>Created At</th>
                  <th>Created By</th>
                </tr>
              </thead>
            </table>
          </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>