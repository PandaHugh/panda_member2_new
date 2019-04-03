

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
          <button onclick="location.href = '<?php echo site_url('Setup_general_c/sync_branch?redirect=Setup_card_c')?>';" name="save" class="btn btn-default btn-sm" style="float: right" onclick="add_promo()"><span style="color:white"></span> <b>SYNC OUTLET</b></button>

      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        
          <!-- /.box-header -->
          <div class="box-body">
            <div style="overflow-x:auto;">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Branch Name</th>
                <th>Branch ID</th>
                <th>Prefix</th>
                <th>Date Format</th>
                <th>Card Digit</th>
                <th>Random Digit</th>
                <th>Running No format</th>
                <th>Sample</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($record->result() as $row)
                { ?>

                <tr>
                  <td>
                    <?php echo $row->branch_name?> <b>(<?php echo $row->branch_code?>)</b>
                    <button title="Edit" onclick="edit_promo()" type="button" class="btn btn-xs btn-primary pull-right" 
                    data-toggle="modal" data-target="#addpromo" 
                    data-guid="<?php echo $row->guid?>"
                    data-branch_name="<?php echo $row->branch_name?>" 
                    data-branch="<?php echo $row->branch_id?>" 
                    data-inc_branch="<?php echo $row->inc_branch?>"
                    data-prefix="<?php echo $row->prefix?>" 
                    data-inc_prefix="<?php echo $row->inc_prefix?>" 
                    data-date_format="<?php echo $row->date_format?>" 
                    data-inc_date="<?php echo $row->inc_date?>" 
                    data-random_digit="<?php echo $row->random_digit?>" 
                    data-inc_random_no="<?php echo $row->inc_random_no?>" 
                    data-card_digit="<?php echo $row->card_digit?>"
                    data-run_format="<?php echo $row->run_no_format?>" 
                    >
                    <i class="glyphicon glyphicon-pencil"></i></button>
                  </td>
                  <td><?php echo $row->branch_id; ?>
                    <span class="pull-right">

                    <?php if($row->inc_branch == '1')
                    {
                      echo "&#10004";
                    }
                    else
                    {
                      echo "&#10006";
                    } ?>

                    </span>
                  </td>
                  <td><?php echo $row->prefix; ?>
                    <span class="pull-right">

                    <?php if($row->inc_prefix == '1')
                    {
                      echo "&#10004";
                    }
                    else
                    {
                      echo "&#10006";
                    } ?>

                    </span>
                  </td>
                  <td><?php echo $row->date_format; ?> (<b> <?php echo $row->date_example?></b>)
                    <span class="pull-right">

                    <?php if($row->inc_date == '1')
                    {
                      echo "&#10004";
                    }
                    else
                    {
                      echo "&#10006";
                    } ?>

                    </span>
                  </td>
                  <td><?php echo $row->card_digit; ?></td>
                  <td><?php echo $row->random_digit; ?>
                    <span class="pull-right">

                    <?php if($row->inc_random_no == '1')
                    {
                      echo "&#10004";
                    }
                    else
                    {
                      echo "&#10006";
                    } ?>

                    </span>
                  </td>
                  <td><?php echo $row->run_no_format; ?></td>
                  <td><?php echo $row->sample_refno?></td>
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
                <form action="<?php echo site_url('Setup_card_c/save_update')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="guid"/> 
                    <div class="form-body">

                        <div class="form-group">
                            <label class="control-label col-md-3" data-toggle="tooltip" data-placement="right" title="This prefix value will be set in first position of Card Number.">Prefix</label>
                            <div class="col-md-9" >
                                <select id="prefix" name="prefix" class="form-control" required>
                                <option required name="prefix_exist" selected data-default style="display: none;" >Select Type</option>
                                <option value="Exclude">Exclude</option>
                                <option value="Include">Include</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="include_prefix">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-9" >
                              <input name="prefix_code" class="form-control" type="text" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" data-toggle="tooltip" data-placement="right" title="BranchId is not based on existing branch code and shall be set separately.This will be in second position.">Branch ID</label>
                            <div class="col-md-9" >
                                <select id="branch_id1234" name="branch_id1234" class="form-control" required>
                                <option required name="branch_id1234_exist" selected data-default style="display: none;" >Select Type</option>
                                <option value="Exclude">Exclude</option>
                                <option value="Include">Include</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="include_branch">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-9" >
                              <input name="branch_id" class="form-control" type="text" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" data-toggle="tooltip" data-placement="right" title="This will follow the date of generating/registration the Card Number and will placed in third position.">Date</label>
                            <div class="col-md-9" >
                                <select id="date" name="date" class="form-control" required>
                                <option required name="date_exist" selected data-default style="display: none;" >Select Type</option>
                                <option value="Exclude">Exclude</option>
                                <option value="Include">Include</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="include_date">
                            <label class="control-label col-md-3" data-toggle="tooltip" data-placement="right" title="Choose date format.">Date Format</label>
                            <div class="col-md-9" >
                              <select id="date_format" name="date_format" class="form-control" required>
                                <option required name="date_format_exist" selected data-default style="display: none;" >Select Format</option>
                                <option value="%Y%m%d"><?php echo $date_Ymd?></option>
                                <option value="%y%m%d"><?php echo $date_ymd?></option>
                                <option value="%y%m"><?php echo $date_ym?></option>
                               </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" data-toggle="tooltip" data-placement="right" title="Random digit that generated by system in last position.">Random Digit</label>
                            <div class="col-md-9" >
                                <select id="random1234" name="random1234" class="form-control" required>
                                <option required name="random_exist" selected data-default style="display: none;" >Select Type</option>
                                <option value="Exclude">Exclude</option>
                                <option value="Include">Include</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="include_random">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-9" >
                              <input name="random_digit" class="form-control" type="number" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" data-toggle="tooltip" data-placement="right" title="Format to reset the running number based on every year,month or day.">Running No Format</label>
                            <div class="col-md-9" >
                                <select id="run_format" name="run_format" class="form-control" required>
                                <option required name="run_format_exist" selected data-default style="display: none;" >Select Format</option>
                                <option value="YEAR">YEAR</option>
                                <option value="MONTH">MONTH</option>
                                <option value="DAY">DAY</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group"> 
                          <label class="control-label col-md-3" data-toggle="tooltip" data-placement="right" title="Card Number digit.">Card Digit</label>
                          <div class="col-md-9">
                              <input  type="number" class="form-control" name="card_digit" id="card_digit" placeholder="Card Digit" value="" required/>
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

    if(button.data('inc_branch') == '1')
    {
      var branch_id = 'Include'
    }
    else
    {
      var branch_id = 'Exclude'
    }

    if(button.data('inc_prefix') == '1')
    {
      var prefix = 'Include'
    }
    else
    {
      var prefix = 'Exclude'
    }

    if(button.data('inc_date') == '1')
    {
      var date = 'Include'
    }
    else
    {
      var date = 'Exclude'
    }

    if(button.data('inc_random_no') == '1')
    {
      var random_no = 'Include'
    }
    else
    {
      var random_no = 'Exclude'
    }

    if(button.data('date_format') == '%Y%m%d')
    {
      var date_format = <?php echo $this->db->query("SELECT DATE_FORMAT(curdate(), '%Y%m%d') as curdate")->row('curdate')?>
    }
    else if(button.data('date_format') == '%y%m%d')
    {
      var date_format = <?php echo $this->db->query("SELECT DATE_FORMAT(curdate(), '%y%m%d') as curdate")->row('curdate')?>
    }
    else
    {
      var date_format = <?php echo $this->db->query("SELECT DATE_FORMAT(curdate(), '%y%m') as curdate")->row('curdate')?>
    }


      var modal = $(this)
      modal.find('.modal-title').text('Edit ' + button.data('branch_name'))
      modal.find('[name="guid"]').val(button.data('guid'))
      modal.find('[name="card_digit"]').val(button.data('card_digit'))
      modal.find('[name="branch_name"]').val(button.data('branch_name'))

      modal.find('[name="branch_id"]').val(button.data('branch'))
      modal.find('[name="branch_id1234_exist"]').text(branch_id)
      modal.find('[name="branch_id1234_exist"]').val(branch_id)

      modal.find('[name="prefix_code"]').val(button.data('prefix'))
      modal.find('[name="prefix_exist"]').text(prefix)
      modal.find('[name="prefix_exist"]').val(prefix)

      modal.find('[name="random_digit"]').val(button.data('random_digit'))
      modal.find('[name="random_exist"]').text(random_no)
      modal.find('[name="random_exist"]').val(random_no)

      modal.find('[name="run_format"]').val(button.data('run_format'))
      modal.find('[name="run_format_exist"]').text(button.data('run_format'))
      modal.find('[name="run_format_exist"]').val(button.data('run_format'))

      modal.find('[name="date_exist"]').text(date)
      modal.find('[name="date_exist"]').val(date)

      modal.find('[name="date_format_exist"]').text(date_format)
      modal.find('[name="date_format_exist"]').val(button.data('date_format'))


      if ($("#branch_id1234").val() == 'Include')
        $("#include_branch").show();
      else
        $("#include_branch").hide();

      if ($("#prefix").val() == 'Include')
        $("#include_prefix").show();
      else
        $("#include_prefix").hide();

      if ($("#date").val() == 'Include')
        $("#include_date").show();
      else
        $("#include_date").hide();

      if ($("#random1234").val() == 'Include')
        $("#include_random").show();
      else
        $("#include_random").hide();

    });
  }

  function toggleFields() {
    if ($("#branch_id1234").val() == 'Include')
        $("#include_branch").show();
    else
        $("#include_branch").hide();
  }

  function toggleFields_prefix() {
    if ($("#prefix").val() == 'Include')
        $("#include_prefix").show();
    else
        $("#include_prefix").hide();
  }

  function toggleFields_date() {
    if ($("#date").val() == 'Include')
        $("#include_date").show();
    else
        $("#include_date").hide();
  }

  function toggleFields_random() {
    if ($("#random1234").val() == 'Include')
        $("#include_random").show();
    else
        $("#include_random").hide();
  }

</script>