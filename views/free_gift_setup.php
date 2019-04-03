<style>
  .error
  {
    color : red;
  }
</style>
<body>
	<div id="wrapper">
		<div id="page-inner">
      <?php
        if($this->session->userdata('message'))
        {
           echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
        }
      ?>
			<div class="row">
  			<div class="col-md-12">
  				<section class="content-header">
  					<h1>Free Gift Redemption</h1>
  				</section>
  				<section class="content">
  					<div class="box box-default">
              <div class="box-header">
                <a href="<?php echo site_url('Point_c/free_gift'); ?>">
                  <button class="btn btn-success pull-right">Back</button>
                </a>
              </div>
              <form method="POST" action="<?php echo $action; ?>">
    						<div class="box-body">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Description</label>
                          <input type="text" class="form-control" name="description" value="<?php if(isset($description)){ echo $description; } ?>" required autofocus>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Branch</label>
                          <select class="form-control" name="branch" required>
                            <option style="display: none" value=""></option>
                            <?php
                              foreach($branch as $branch)
                              {
                            ?>
                                <option value="<?php echo $branch['branch_code']; ?>" <?php if(isset($branchs) && $branch['branch_code'] == $branchs){ echo "selected"; } ?>><?php echo $branch['branch_name']." (".$branch['branch_code'].")"; ?></option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Doc Date</label>
                          <input type="text" class="form-control" value="<?php if(isset($doc_date)){ echo $doc_date; }else{ echo date('Y-m-d'); } ?>" readonly>
                          <input type="hidden" class="form-control" name="doc_date" value="<?php if(isset($doc_date)){ echo $doc_date; }else{ echo date('Y-m-d'); } ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Date Redemption From</label>
                          <input type="text" class="form-control" id="redemption_date_from" name="date_redemption_from" value="<?php if(isset($date_redemption_from)){ echo $date_redemption_from; }else{ echo date('Y-m-d'); } ?>" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Date Redemption To</label>
                          <input type="text" class="form-control" id="redemption_date_to" name="date_redemption_to" value="<?php if(isset($date_redemption_to)){ echo $date_redemption_to; }else{ echo date('Y-m-d'); } ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <label>Remarks</label>
                        <textarea class="form-control" rows="5" name="remarks"><?php if(isset($remarks)){ echo $remarks;} ?></textarea>
                      </div>
                    </div>
                  </div>
    						</div>
                <div class="box-footer">
                  <button class="btn btn-primary pull-right">Submit</button>
                </div>
              </form>
  					</div>
            <div class="box">
              <div class="box-header">
                <?php
                  if(isset($_REQUEST['guid']))
                  {
                ?>
                    <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#modal-condition" id="add_condition_btn">
                      <i class="fa fa-plus"></i>
                    </button>
                <?php
                  }
                ?>
                <h3 class="box-title">Setup Condition</h3>
              </div>
              <div class="box-body" style="overflow:auto;">
                <table id="condition_list" class="table">
                  <thead>
                    <tr>
                      <th>Seq</th>
                      <th style="width:250px;">Query</th>
                      <th>Have Record:<br> Message</th>
                      <th>Have Record:<br> Abort Process</th>
                      <th>No Record:<br> Message</th>
                      <th>No Record:<br> Abort Process</th>
                      <th>Created At</th>
                      <th>Created By</th>
                      <th>Updated At</th>
                      <th>Updated By</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if(isset($condition) && !empty($condition->result()))
                      {
                        foreach($condition->result() as $cond)
                        {
                    ?>
                          <tr>
                            <td><?php echo $cond->seq; ?></td>
                            <td><?php echo $cond->query_data; ?></td>
                            <td><?php echo $cond->have_rec_msg; ?></td>
                            <td><?php echo $cond->have_rec_msg_abort; ?></td>
                            <td><?php echo $cond->no_rec_msg; ?></td>
                            <td><?php echo $cond->no_rec_msg_abort; ?></td>
                            <td><?php echo $cond->created_at; ?></td>
                            <td><?php echo $cond->created_by; ?></td>
                            <td><?php echo $cond->updated_at; ?></td>
                            <td><?php echo $cond->updated_by; ?></td>
                            <td>
                              <button class="btn btn-primary btn-xs edit_condition_btn" data-toggle="modal" data-target="#modal-edit-condition" id="edit_condition_btn" data-guid="<?php echo $cond->query_guid; ?>" data-query_data="<?php echo $cond->query_data; ?>" data-have_rec_msg="<?php echo $cond->have_rec_msg; ?>" data-have_rec_msg_abort="<?php echo $cond->have_rec_msg_abort; ?>" data-no_rec_msg="<?php echo $cond->no_rec_msg; ?>" data-no_rec_msg_abort="<?php echo $cond->no_rec_msg_abort; ?>" data-seq="<?php echo $cond->seq; ?>">
                                <i class="fa fa-pencil"></i>
                              </button>
                              <button class="btn btn-danger btn-xs delete_condition_btn" data-guid="<?php echo $cond->query_guid; ?>" data-coupon_guid="<?php echo $_REQUEST['guid']; ?>">
                                <i class="fa fa-trash"></i>
                              </button>
                            </td>
                          </tr>
                    <?php
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
  				</section>
    		</div>
    	</div>
		</div>
	</div>
  <div class="modal fade" id="modal-condition">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Setup Condition</h4>
        </div>
        <form class="form-horizontal" id="setup_condition_form" method="POST" action="<?php echo site_url('Point_c/submit_add_condition?guid='.$_REQUEST['guid']); ?>">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-md-3 control-label"><span class="error">*</span>Seq</label>
              <div class="col-md-9">
                <input type="number" class="form-control" name="seq" min="0" value="<?php if(empty($seq) || $seq == ""){ echo 0; }else{ echo $seq; } ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label"><span class="error">*</span>Query</label>
              <div class="col-md-9">
                <textarea class="form-control" id="condition_query" name="query" rows="5" style="resize:none;" required></textarea>
                <span style="color:red;">Var : @cardno</span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Have Record: Message</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="have_rec_msg">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Have Record: Abort Process</label>
              <div class="col-md-9">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="have_rec_abort" value="true">
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">No Record: Message</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="no_rec_msg">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">No Record: Abort Process</label>
              <div class="col-md-9">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="no_rec_abort" value="true">
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary pull-right submit_btn">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-edit-condition">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Setup Condition</h4>
        </div>
        <form class="form-horizontal" id="setup_condition_form" method="POST" action="<?php echo site_url('Point_c/submit_edit_condition?query_guid='.$_REQUEST['guid']); ?>">
          <div class="modal-body">
            <input type="hidden" id="condition_guid" name="guid">
            <div class="form-group">
              <label class="col-md-3 control-label"><span class="error">*</span>Seq</label>
              <div class="col-md-9">
                <input type="number" class="form-control" name="seq" min="0">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label"><span class="error">*</span>Query</label>
              <div class="col-md-9">
                <textarea class="form-control" id="edit_condition_query" name="query" rows="5" style="resize:none;" required></textarea>
                <span style="color:red;">Var : @cardno</span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Have Record: Message</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="have_rec_msg">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Have Record: Abort Process</label>
              <div class="col-md-9">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="have_rec_abort" value="true">
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">No Record: Message</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="no_rec_msg">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">No Record: Abort Process</label>
              <div class="col-md-9">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="no_rec_abort" value="true">
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary pull-right submit_btn">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>