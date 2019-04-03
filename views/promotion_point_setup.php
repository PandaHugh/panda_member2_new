

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
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Edit</th>
                <th>Active</th>
                <th>Card Type</th>
                <th>Promo Type</th>
                <th>Total Point</th>
                <th>Discount Point</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Time From</th>
                <th>Time To</th>
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
                    <button title="Edit" onclick="edit_promo()" type="button" class="btn btn-xs btn-primary" 
                    data-toggle="modal" data-target="#addpromo" 
                    data-guid="<?php echo $row->point_guid?>"
                    data-description="<?php echo $row->description?>" 
                    data-cardtype="<?php echo $row->cardtype?>" 
                    data-active="<?php echo $row->set_active?>"
                    data-type="<?php echo $row->type?>"
                    data-point_total="<?php echo $row->point_total?>"
                    data-point_disc="<?php echo $row->point_disc?>"
                    data-date_from="<?php echo date('m-d-Y',strtotime($row->date_from))?>"
                    data-date_to="<?php echo date('m-d-Y',strtotime($row->date_to))?>"
                    data-time_from="<?php echo $row->time_from?>"
                    data-time_to="<?php echo $row->time_to?>"
                    >
                    <i class="glyphicon glyphicon-pencil"></i></button></center>
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
                  <td><?php echo $row->cardtype; ?></td>
                  <td><?php echo $row->type; ?></td>
                  <td><?php echo $row->point_total; ?></td>
                  <td><?php echo $row->point_disc; ?></td>
                  <td><?php echo $row->date_from; ?></td>
                  <td><?php echo $row->date_to; ?></td>
                  <td><?php echo $row->time_from; ?></td>
                  <td><?php echo $row->time_to; ?></td>
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
                <h3 class="modal-title">Add Promotion</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('point_c/point_promotion_form')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="guid"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Card Type </label>
                            <div class="col-md-9" >
                              <select name="cardtype" class="form-control" required>
                                <option required name="cardtype_exist" selected data-default style="display: none;" >Select Card Type</option>
                                <?php
                                foreach($card_type->result() as $row)
                                {
                                  ?>
                                    <option required value="<?php echo $row->CardType?>"><?php echo $row->CardType?></option>
                                  <?php
                                }
                                ?>
                                </select>
                            </div>
                        </div>

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
                          <label class="control-label col-md-3" data-toggle="tooltip" data-placement="top" title="">Type</label>
                            <div class="col-md-9" >
                                <select name="type" class="form-control" required>
                                <option required name="type_exist" selected data-default style="display: none;" >Select Type</option>
                                <option value="EVERY">Every</option>
                                <option value="GREATER">Greater Than</option>
                                
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
                          <label class="control-label col-md-3">Date range</label>
                          <div class="col-md-9">
                            <input required name="daterange" type="datetime" class="form-control pull-right" id="reservationtime" >
                                <span class="help-block"></span>
                          </div>
                        </div>

                                <div class="bootstrap-timepicker">
                                  <div class="form-group">
                                    <label class="control-label col-md-3">Time from</label>
                                    <div class="col-md-9">
                                      <input required name="timefrom" type="time" class="form-control pull-right">
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3">Time to</label>
                                    <div class="col-md-9">
                                      <input required name="timeto" type="time" class="form-control pull-right">
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">
                                        Total Point
                                    </label>
                                    <div class="col-md-9">
                                        <input required type="number" name="point_total" type="text" class="form-control" id="inputPassword3" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">
                                        Discount Point
                                    </label>
                                    <div class="col-sm-9">
                                        <input required type="number" name="point_disc" type="text" class="form-control" id="inputPassword3" />
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
      modal.find('[name="point_total"]').val(button.data('point_total'))
      modal.find('[name="point_disc"]').val(button.data('point_disc'))
      modal.find('[name="cardtype_exist"]').text(button.data('cardtype'))
      modal.find('[name="cardtype_exist"]').val(button.data('cardtype'))
      modal.find('[name="set_active_exist"]').text(active_value)
      modal.find('[name="set_active_exist"]').val(button.data('active'))
      modal.find('[name="type_exist"]').text(button.data('type'))
      modal.find('[name="type_exist"]').val(button.data('type'))
      modal.find('[name="timefrom"]').val(button.data('time_from'))
      modal.find('[name="timeto"]').val(button.data('time_to'))
      

    });
  }
  
</script>