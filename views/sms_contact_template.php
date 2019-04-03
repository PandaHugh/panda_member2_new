

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
      <h1><?php echo $title; ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        
          <div class="box-header">

              <div style="overflow-x:auto;">

                <button name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white" onclick="add_promo()"><span style="color:white"></span> <b>ADD</b></button>
              </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div style="overflow-x:auto;">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Edit</th>
                <th>Active</th>
                <th>Template</th>
                <th>Template Type</th>
                <th>Query</th>
                <th>Updated By</th>
                <th>Updated At</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($record->result() as $row)
                { ?>

                <tr>
                  <td>
                    <center>
                    <button title="Edit" onclick="edit_promo()" type="button" class="btn btn-xs btn-primary" 
                    data-toggle="modal" data-target="#addpromo" 
                    data-guid="<?php echo $row->guid?>"
                    data-template_name="<?php echo $row->template_name?>" 
                    data-template_type="<?php echo $row->template_type?>"
                    data-query="<?php echo $row->query?>"
                    data-active="<?php echo $row->set_active?>"
                    data-query="<?php echo $row->query?>"
                    >
                    <i class="glyphicon glyphicon-pencil"></i></button>

                    <button title="View List" onclick="window.location.href='<?php echo site_url('Sms_c/contact_c_list?guid='.$row->guid)?>'" type="button" class="btn btn-xs btn-info" >
                    <i class="glyphicon glyphicon-eye-open"></i></button>
                  </center>
                  </td>
                  <td>
                    <center><span>

                    <?php if($row->set_active == '1')
                    {
                      echo "&#10004";
                    }
                    else
                    {
                      echo "&#10006";
                    } ?>

                    </span></center>
                  </td>
                  <td><?php echo $row->template_name; ?></td>
                  <td><?php echo $row->template_type; ?>
                    <?php
                    if($row->template_type == 'MANUAL')
                    {
                      ?>
                      <button title="Add/Edit Contact" style="float: right" onclick="window.location.href='<?php echo site_url('Sms_c/add_contact_template?guid='.$row->guid)?>'" type="button" class="btn btn-xs btn-success" >
                      <i class="glyphicon glyphicon-plus"></i></button>
                      
                      <?php
                    }
                    ?>
                  </td>
                  <td><?php echo $row->query; ?></td>
                  <td><?php echo $row->updated_at; ?></td>
                  <td><?php echo $row->updated_by; ?></td>
                </tr>
                
                <?php } ?>
               
              </tbody>
                
            </table>
            </div>
        </div>
        <!-- /.box -->


<div class="modal fade" id="addpromo" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Contact</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Sms_c/contact_template_form')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="guid"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Active </label>
                            <div class="col-md-9" >
                                <select name="set_active" class="form-control" required>
                                <option required value="1" name="set_active_exist" selected data-default style="display: none;" >Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="control-label col-md-3">Template Name</label>
                            <div class="col-md-9">
                              <input name="template_name" class="form-control" type="text" required style="" maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Template Type </label>
                            <div class="col-md-9" >
                                <select id="template_type" name="template_type" class="form-control" required>
                                <option required name="template_type_exist" selected data-default style="display: none;" >Select Type</option>
                                <option value="MANUAL">MANUAL</option>
                                <option value="QUERY">QUERY</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="query">
                          <label class="control-label col-md-3">Query </label>
                            <div class="col-md-9" >
                              <textarea id="textarea" class="form-control" name="query" rows="4" placeholder="Type your sql query here.."></textarea>
                            </div>
                        </div>
                                
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div>
    </div>
</div>

<script type="text/javascript">
  
  function add_promo()
  {
    save_method = 'add';
    $('#addpromo').modal('show'); 
    $('.modal-title').text('Add New'); 
  }

  function edit_promo()
  {
    $('#addpromo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 

    if(button.data('active') == 1)
    {
      var active_value = 'Active'
    }
    else
    {
      var active_value = 'Inactive'
    }

      var modal = $(this)
      modal.find('.modal-title').text('Edit New')
      modal.find('[name="guid"]').val(button.data('guid'))
      modal.find('[name="template_name"]').val(button.data('template_name'))
      modal.find('[name="message"]').val(button.data('message'))
      modal.find('[name="query"]').text(button.data('query'))
      modal.find('[name="set_active_exist"]').text(active_value)
      modal.find('[name="set_active_exist"]').val(button.data('active'))
      modal.find('[name="template_type_exist"]').text(button.data('template_type'))
      modal.find('[name="template_type_exist"]').val(button.data('template_type'))

      if ($("#template_type").val() == 'QUERY')
        $("#query").show();
    else
        $("#query").hide();

    });
  }

  function toggleFields() {
    if ($("#template_type").val() == 'QUERY')
        $("#query").show();
    else
        $("#query").hide();
  }
  
</script>