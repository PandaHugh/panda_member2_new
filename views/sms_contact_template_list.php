

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
      <button onclick="window.location.href='<?php echo site_url('Sms_c/contact_template')?>'" name="save" class="btn btn-default btn-sm" style="float: right" onclick="add_promo()"><span style="color:white"></span> <b>BACK</b></button></h1>
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
                <th>AccountNo</th>
                <th>CardNo</th>
                <th>Name</th>
                <th>PhoneNo</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($record->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->account_no; ?></td>
                  <td><?php echo $row->card_no; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $row->contact_no; ?></td>
                </tr>
                
                <?php } ?>
               
              </tbody>
                
            </table>
            </div>
        </div>
        <!-- /.box -->

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


    });
  }


  
</script>