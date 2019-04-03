

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
            <table id="example1" class="table table-bordered">
              <thead>
              <tr>
                <th>Edit</th>
                <th>Active</th>
                <th>Description</th>
                <th>Schedule Type</th>
                <th>Date </th>
                <th>Day </th>
                <th>Time From</th>
                <th>Time To</th>
                <th>Type</th>
                <th>Point</th>
                <th>Point Type</th>                
                <th>Points Addon</th>
                <th>Updated at</th>
                <th>Updated by</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($trans_main->result() as $row)
                { ?>

                <tr
                <?php 
                      if($current_active == $row->point_guid)
                      {
                        ?>
                        id="highlight" 
                        <?php
                      }
                      ?>
                      >
                  <td>
                    <center>

                    <?php if($current_active != $row->point_guid) 
                      { 
                    ?>
                    <button title="Edit" onclick="edit_promo()" type="button" class="btn btn-xs btn-primary" 
                    data-toggle="modal" data-target="#addpromo" 
                    data-guid="<?php echo $row->point_guid?>"
                    data-description="<?php echo $row->description?>" 
                    data-active="<?php echo $row->set_active?>"
                    data-point="<?php echo $row->point?>"
                    data-points_type="<?php echo $row->points_type?>"
                    data-type="<?php echo $row->type?>"
                    data-time_from="<?php echo $row->time_from?>"
                    data-time_to="<?php echo $row->time_to?>"
                    data-point_addon ="<?php echo $row->points_addon;?>"
                    data-schedule_type ="<?php echo $row->schedule_type ;?>"
                    data-schedule = "<?php echo $row->date;?>"
                    data-day = "<?php echo $row->day ;?>"
                    >
                    <i class="glyphicon glyphicon-pencil"></i></button>

                    <?php
                      }
                    ?>
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
                  <td><?php echo $row->description ;?></td>
                  <td><?php echo $row->schedule_type ;?></td>                  
                  <td><center><?php if($row->date == '0000-00-00')
                    {
                      echo '-';
                    }
                    else
                    {
                     echo $row->date  ;
                    }
                    ?></center>
                    </td>
                  <td><center><?php if($row->day  == '')
                    {
                      echo '-';
                    }
                    else
                    {
                     echo $row->day;
                    }
                    ?></center>
                  </td>
                  <td><?php echo $row->time_from ;?></td>
                  <td><?php echo $row->time_to ;?></td>
                  <td><?php echo $row->type ;?></td>
                  <td><?php echo $row->point ;?></td>
                  <td><?php echo $row->points_type ;?> Points</td>
                  <td><center><?php if($row->points_addon  == '')
                    {
                      echo '-';
                    }
                    else
                    {
                     echo $row->points_addon;
                    }
                    ?></center>
                  </td>
                  <td><?php echo $row->updated_at ;?></td>
                  <td><?php echo $row->updated_by ;?></td>
 
                </tr>
                
                <?php } ?>
               
              </tbody>
                
            </table>
            <p></p>
            </div>
        </div>
        <!-- /.box -->


<div class="modal fade" id="addpromo" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Promotion</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('point_c/auto_point_adjustment_form')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="guid"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Active </label>
                            <div class="col-md-9" >
                                <select name="set_active" class="form-control" required>
                                <option required name="set_active_exist" selected data-default style="display: none;" >Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                          <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                              <input name="description" class="form-control" type="text" required style="" maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>
 
                        <div class="form-group">
                          <label class="control-label col-md-3">Time from</label>
                          <div class="col-md-9 bootstrap-timepicker">
                            <input required name="timefrom" type="text" class="form-control timepicker">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3">Time to</label>
                          <div class="col-md-9 bootstrap-timepicker">                    
                            <input name="timeto" type="text" class="form-control timepicker">
                          </div>
                        </div>
   
                        <div class="form-group ">
                          <label class="control-label col-md-3">Schedule Type </label>
                          <div class="col-md-9" >
                            <select name="schedule_type" id="schedule_type" class="form-control">
                            <option required name="schedule_type_exist" selected data-default style="display: none;" >Select Schedule Type</option> 
                            <option value="Annually">Annually</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Weekly">Weekly</option>                             
                            <option value="Hourly">Hourly</option>                            
                            </select>
                            

                            <div style='display:none;' id='date'> 
                                <label>Select Date</label>
                                <input type="date" name="date" class="form-control pull-right">
                            </div>

                            <div style='display:none;' id='day'>
                            <label>Select Day</label>
                            <select name="day" class="form-control">
                            <option required name="day_exist" selected data-default style="display: none;" >Select Day</option> 
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            </select>
                            </div>
                              
                          </div>
 
                        </div>
 
                        <div class="form-group ">
                          <label class="control-label col-md-3"> Type </label>
                          <div class="col-md-9" >
                            <select name="type" class="form-control" required>
                            <option required name="type_exist" selected data-default style="display: none;" >Select Type</option>
                            <option value="Every">Every</option>
                            <option value="Greater Than">Greater Than</option>                        
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3">Points</label>
                            <div class="col-md-9">
                              <input name="point" class="form-control" type="number" required style="" maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Points Addon</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="points_type" name="points_type" required>
                                  <option required name="points_type_exist" selected data-default style="display: none;" >Select Type</option>
                                  <option value="2x">2x Points</option>
                                  <option value="3x">3x Points</option>
                                  <option value="4x">4x Points</option>
                                  <option value="5x">5x Points</option>
                                  <option value="Additional Addon">Additional Addon</option>
                                </select>

                                <div id="addon" style='display:none;'>
                                  <label>Additional Points Addon</label>
                                  <input name="points_addon" class="form-control" type="text">
                                </div>
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

    $('#reservationtime').daterangepicker({
    "startDate": button.data('date_from'),
    "endDate": button.data('date_to'),
    }, function(start, end, label) {
    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });

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
      modal.find('[name="description"]').val(button.data('description'))
      modal.find('[name="amount"]').val(button.data('amount'))
      modal.find('[name="point"]').val(button.data('point'))
      modal.find('[name="set_active_exist"]').text(active_value)
      modal.find('[name="set_active_exist"]').val(button.data('active'))
      modal.find('[name="timefrom"]').val(button.data('time_from'))
      modal.find('[name="timeto"]').val(button.data('time_to'))

      modal.find('[name="type_exist"]').text(button.data('type'))
      modal.find('[name="type_exist"]').val(button.data('type'))

      modal.find('[name="points_type_exist"]').text(button.data('points_type'))
      modal.find('[name="points_type_exist"]').val(button.data('points_type'))
 
      modal.find('[name="schedule_type_exist"]').text(button.data('schedule_type'))
      modal.find('[name="schedule_type_exist"]').val(button.data('schedule_type'))

      if(button.data('points_type') == 'Additional Addon')
      {
        $('#addon').css('display','block');         
        modal.find('[name="points_addon"]').val(button.data('point_addon'))
      }

      if(button.data('schedule_type') == 'Annually' || button.data('schedule_type') == 'Monthly')
      {
        $('#date').css('display','block');         
        modal.find('[name="date"]').val(button.data('schedule'))
        modal.find('[name="day_exist"]').val('')
      }
      else
      {
        $('#day').css('display','block');              
        modal.find('[name="day_exist"]').text(button.data('day'))
        modal.find('[name="day_exist"]').val(button.data('day'))
        modal.find('[name="date"]').val('0000-00-00') 
      }
    });
  }
  
</script> 
 