
<div class="row">
<div class="col-md-6">
<div class="box">
  <div class="box-header">
    <h3 class="box-title">Nationality</h3>
    <div class="box-tools pull-right">
      <!-- onclick="" will submit the form below in which this button is not within form -->
      <button class="btn btn-xs btn-success" onclick="$('#formSN').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
      <!-- onclick will go to javascript named add_nationality -->
      <button class="btn btn-xs btn-primary" onclick="add_nationality()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
     <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
    </div>
  </div>
  <div class="box-body no-padding" id="scroll">
  <!-- receive instruction from button above based on id -->
  <form method="post" action="" id="formSN">
    <table class="table" >
      <tr>
        <th>Nationality</th>
        <th>Preset</th>
        <th style="width:100px">Actions</th>
      </tr>
      <tr>
        <td>Malaysian</td>
        <td>
        <input type="hidden" name="name[]" value="">

        <?php $Preset=1; ?>

        <input type="" name="preset[]" 
        <?php if($Preset == 0)
        {
        echo 'value="0"';
        }
        else
        {
          echo 'value="1"';
        }
        ?>
        ><input type="checkbox"
        <?php if($Preset == 0)
        {
          echo " ";
        }
        else
        {
          echo "checked";
        } //box value shows 1 when check box is checked and vice versa?> 
          onchange="this.previousSibling.value=1-this.previousSibling.value" 
          /></td>

        <td>
          <!-- button will direct to nationality modal based on data-target="" -->
          <button title="Edit" onclick="edit_nationality()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#nationality" 
              data-name="Malaysian"
              data-oriname="" >
              <i class="glyphicon glyphicon-pencil"></i></button>

          <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="Malaysian" ><i class="glyphicon glyphicon-trash"></i></button>
        </td>
      </tr>
    </table>
    </form>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
</div>
</div>


<script type="text/javascript">

  function confirm_modal(delete_url)
  {
    $('#delete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 

    var modal = $(this)
    //pass text of data-name="" from input value to modal which class="modal_detail"
    modal.find('.modal_detail').text('Confirm delete ' + button.data('name') + '?')
    });
  }

  function edit_nationality()
  {
    $('#nationality').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 

      var modal = $(this)
      modal.find('.modal-title').text('Edit')
      modal.find('[name="name"]').val(button.data('name'))
      modal.find('[name="oriname"]').val(button.data('oriname'))
    });
  }

  function add_nationality()
  {
    save_method = 'add';
    $('#nationality').modal('show');
    //pass title name to class="modal-title" in modal 
    $('.modal-title').text('Add New'); 
  }

</script>

<!-- delete modal -->
<!-- if use data-toggle="" in button, id is without # in front, else # is needed when called by javascript -->
<div class="modal fade" id="delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal_alert" style="text-align: center;color: red"></h4>
                <!-- receive message from javascript -->
                <h4 class="modal_detail" style="text-align: center"></h4>
            </div>
            <div class="modal-footer" style="text-align: center">
            <span id="preloader-delete"></span>
                <a id="url" href=""><button type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button></a>
                <!-- onclick="" will reload the page when cancel button is clicked -->
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- nationality modal -->
<div class="modal fade" id="nationality" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_nationality')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nationality</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
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


<!--
Mistakes:
1. Modal cannot be run as related bootstrap is not exists.
2. Delete modal didn't show or message disappears when delete button is clicked as codes are no proper closed since bootstrap exists.
3. Check box is checked but value has no response as the spacing problem. 

 -->