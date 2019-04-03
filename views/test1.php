<!DOCTYPE html>
<html>
<head>

</head>

<body>

<button title="Edit" onclick="edit_nationality()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#nationality" 
                        data-name="aaa"
                        data-oriname="bbb" >
                        <i class="glyphicon glyphicon-pencil"></i></button>

</html>

<script type="text/javascript">

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

</script>

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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>