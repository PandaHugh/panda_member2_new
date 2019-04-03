

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
      <h1>Item</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <form method="post" action="<?php echo $action; ?>">
        <div class="box-body">
          <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Tab 1</a></li>
                <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Item Type <a style="color:red;">*</a></label>
                      <select name="Item_Type" class="form-control" id="Item_Type" required
                      <?php if($Item_Code !='')
                      { 
                        echo "readonly";
                      }; ?>>
                        <option selected data-default style="display: none; "><?php echo $Item_Type;?></option>
                        <option value="ADJUST">ADJUST</option>
                        <option value="STOCK">STOCK</option>
                        <option value="REDEEM">REDEEM</option>
                        <option value="REDEEM_VOUCHER">REDEEM => VOUCHER</option>
                      </select>
                      <span class="input-group-btn">
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Item Code <a style="color:red;">*</a></label>
                      <input type="text" id="Item_Code" name="Item_Code" class="form-control" placeholder="Item Code" value="<?php echo $Item_Code; ?>" required

                      <?php if($Item_Code !='')
                      { 
                        echo "readonly";
                      }; ?>>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Item Description <a style="color:red;">*</a></label>
                      <input type="text" id="Item_Description" name="Item_Description" class="form-control" placeholder="Item Description" value="<?php echo $Item_Description; ?>" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Point <a style="color:red;">*</a></label>
                      <input type="number" min="0.00" step="0.01" id="Point" name="Point" class="form-control" placeholder="Point" value="<?php echo $Point; ?>" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Price <a style="color:red;">*</a></label>
                      <input type="number" min="0.00" step="0.01" id="Price" name="Price" class="form-control" placeholder="Price" value="<?php echo $Price; ?>" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="checkbox">
                      <label>
                        <input type="hidden" name="enable" id="enable" value="0" />
                          <input type="checkbox" name="enable" id="enable" readonly value="1" 
                            <?php
                            if($Active == 1)
                            {
                              ?>
                              checked
                              <?php
                            }
                            ?>/> Active
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <br>
                    <input type="submit" value="<?php echo $button; ?>" class="btn btn-success pull-left" />
                  </div> 
                </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Redeem </label>
                      <input type="number" id="Redeem" min="0" name="Redeem" class="form-control" placeholder="Redeem" value="<?php echo $Redeem; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Stock Balance </label>
                      <input type="number" id="Stock_Balance" min="0" name="Stock_Balance" class="form-control" placeholder="Stock Balance" value="<?php echo $Stock_Balance; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>B/F </label>
                      <input type="number" min="0" id="B/F" name="B/F" class="form-control" placeholder="B/F" value="<?php echo $BF; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Received </label>
                      <input type="number" min="0" id="Received" name="Received" class="form-control" placeholder="Received" value="<?php echo $Received; ?>" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                  <div class="form-group">
                    <label>Adjust In </label>
                    <input type="number" id="Adjust_In" min="0" name="Adjust_In" class="form-control" placeholder="Adjust In" value="<?php echo $Adjust_In; ?>" readonly>
                  </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Adjust Out </label>
                      <input type="number" id="Adjust_Out" min="0" name="Adjust_Out" class="form-control" placeholder="Adjust Out" value="<?php echo $Adjust_Out; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Return In </label>
                      <input type="number" min="0" id="Return_In" name="Return_In" class="form-control" placeholder="Return In" value="<?php echo $Return_In; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Return Out </label>
                      <input type="number" min="0" id="Return_Out" name="Return_Out" class="form-control" placeholder="Return Out" value="<?php echo $Return_Out; ?>" readonly>
                    </div>
                  </div>
                </div>
                </div>
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
          </div>
          <!-- /.col -->
          
        </div>
        <!-- /.box-body -->
      </form>
      </div>
      <!-- /.box -->

      <div class="box box-default">
          <div class="box-body" style="overflow-x: scroll;">
            <table id="redemption_table" class="table table-bordered table-striped">
              <thead>
              <tr>
                <!-- <th style="width:100px">Actions</th> -->
                <th>Actions</th>
                <th>Active</th>
                <th>Voucher</th>
                <th>Item Type</th>
                <th>Item Code</th>
                <th>Item Description</th>
                <th>Point</th>
                <th>Price</th>
                <th>Stock Balance</th>
                <th>B/F</th>
                <th>Received</th>
                <th>Redeem</th>
                <th>Adjust In</th>
                <th>Adjust Out</th>
                <!-- <th>Return In</th>
                <th>Return Out</th> -->
                <th>Created at</th>
                <th>Created by</th>
                <th>Updated at</th>
                <th>Updated by</th>
              </tr>
              </thead>
            </table>
          </div>
          <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>

<script type="text/javascript">

function confirm_modal(delete_url)
{
  $('#delete').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 

  var modal = $(this)
  modal.find('.modal_detail').text('Confirm delete ' + button.data('name') + '?')
  modal.find('.modal_alert').text(button.data('alert'))
  document.getElementById('url').setAttribute("href" , delete_url );
  });
}

</script>

<div class="modal fade" id="delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="text-align: center">Confirm Delete?</h3>
            </div> -->
            <div class="modal-body">
                <h4 class="modal_alert" style="text-align: center;color: red"></h4>
                <h4 class="modal_detail" style="text-align: center"></h4>
            </div>
            <div class="modal-footer" style="text-align: center">
            <span id="preloader-delete"></span>
                <a id="url" href=""><button type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button></a>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="redemption_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo site_url('Item_c/add_trans_main'); ?>">
                <div>
                  <input type="hidden" id="trans_type" name="trans_type">
                  <input type="hidden" id="item_guid" name="item_guid">
                  <div class="form-group">
                    <label class="control-label col-sm-3">Item Code</label>
                    <div class="col-sm-9">
                      <input type="text" id="itemcode" readonly class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Item Description</label>
                    <div class="col-sm-9">
                      <input type="text" id="item_description" readonly class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Stock Balance</label>
                    <div class="col-sm-9">
                      <input type="text" id="stk_balance" readonly class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" id="qty"></label>
                    <div class="col-sm-9">
                      <input type="number" id="input_qty" name="qty" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3">Branch</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="branch" required>
                        <option value="none">--- Branch ---</option>
                        <?php
                          foreach ($branch as $row) {
                        ?>
                          <option value="<?php echo $row['branch_code']; ?>"><?php echo $row['branch_name']; ?></option>
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div style="overflow:auto;">
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                  </div>
                </div>
                <div style="margin-top:10px;">
                  <table id="trans_type_table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <!-- <th style="width:100px">Actions</th> -->
                        <th>Branch</th>
                        <th>Trans Type</th>
                        <th>Refno</th>
                        <th>Item Code</th>
                        <th>Item Description</th>
                        <th>Receive</th>
                        <th>Adjust In</th>
                        <th>Adjust Out</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->