<?php 
'session_start()' 
?>

<script src="<?php echo base_url('js/jquery.min.js');?>"></script>

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

label {
  font-size:12px;
}

@media screen and (max-width: 768px) {
  p,input,div,span,h4 {
    font-size: 95%;
  }
  h1 {
    font-size: 2px;  
  }
  h4 {
    font-size: 18px;  
  }
  h3 {
    font-size: 20px;  
  }
  h1 #head{
    font-size: 12px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
}


</style>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);


</script>
<!--onload Init-->
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
      <h1>Pending For Update</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
          <div class="box-header">
            <div class="row">
            <div class="col-md-3">
              <form method="post" action="<?php echo site_url('Pending_c/search_reference'); ?>">
                <div class="form-group">
                  <label>Receipt No.<a style="color:red;">*</a></label>
                  <input id="Reference_No" type="text" name="Reference_No" value="<?php echo $Reference_No; ?>" class="form-control" placeholder="Insert Receipt No" required 
                  
                  <?php if($Reference_No == '')
                  {
                    echo "autofocus";
                  };

                  if($Reference_No != '')
                  {
                    echo "readonly";
                  }; ?> >
                </div>
              </form>
            </div>
            <div class="col-md-3">

              <?php if($search_card != '')
              { ?>

                <form method="post" action="<?php echo site_url('Pending_c/search_card'); ?>?reference=<?php echo $Reference_No; ?>">
                  <div class="form-group">
                    <label>Card No.<a style="color:red;">*</a></label>
                    <input id="Card_No" type="text" name="Card_No" value="<?php echo $Card_No; ?>" class="form-control" placeholder="Insert Card No" required autofocus>
                  </div>
                </form>

              <?php }; ?>

            </div>
            <div class="col-md-3">

              <?php if($Card_No != '')
              { ?>

                <div class="form-group">
                  <label>Card Name</label>
                  <input id="Card_Name" type="text" name="Card_Name" value="<?php echo $Card_Name; ?>" class="form-control" placeholder="Insert Card Name" required readonly>
                </div>

              <?php }; ?>

            </div>
            <div class="col-md-3">

              <?php if($Card_No != '')
              { ?>

                <div class="form-group">
                  <label>Account No.</label>
                  <input id="Account_No" type="text" name="Account_No" value="<?php echo $Account_No; ?>" class="form-control" placeholder="Insert Account No" required readonly>
                </div>

              <?php }; ?>

            </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              <form method="post" action="<?php echo site_url('Pending_c/update'); ?>">
              <div class="form-group">
                <br><br>

                <?php if($update != '')
                { ?>

                    <button title="Update" id="update" type="button" class="btn btn-success pull-left"  data-toggle="modal" data-name="" data-oriname="" >Update</button>

                <?php }; ?>

              </div>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>

      <div class="box box-default">   
          <div class="box-body">
            <div style="overflow-x:auto;">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Reference Number</th>
                <th>Field</th>
                <th>Value From</th>
                <th>Value To</th>
                <th>Created At</th>
                <th>Created By</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($posmain_log->result() as $row)
                { ?>

                  <tr>
                    <td><?php echo $row->ReferenceNo; ?></td>
                    <td><?php echo $row->field; ?></td>
                    <td><?php echo $row->value_from; ?></td>
                    <td><?php echo $row->value_to; ?></td>
                    <td><?php echo $row->created_at; ?></td>
                    <td><?php echo $row->created_by; ?></td>
                  </tr>

                <?php } ?>

              </tbody>
            </table>
            </div>
          </div>
          <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
      
<script type="text/javascript">

$('#update').click(function() {

  var Reference_No = $('#Reference_No').val();
  var Card_No = $('#Card_No').val();
  var Card_Name = $('#Card_Name').val();
  var Account_No = $('#Account_No').val();

  $('#\\#update').modal('show');
  $(".modal-body #Reference_No").val( Reference_No );
  $(".modal-body #Card_No").val( Card_No );
  $(".modal-body #Card_Name").val( Card_Name );
  $(".modal-body #Account_No").val( Account_No );
});

</script>

<div class="modal fade" id="#update">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title">Confirmation!</h4>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Pending_c/update')?>" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-12"></label>
                                <h2><center><div style="color:red;" id="msg"></div></center></h2>
                                <center><p><label>Are you sure want to update?</label><center>
                                <input type="hidden" name="Reference_No" id="Reference_No" value=""/>
                                <input type="hidden" name="Card_No" id="Card_No" value=""/>
                                <input type="hidden" name="Account_No" id="Account_No" value=""/>
                                <span class="help-block"></span>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer" style="text-align: center">
                      <button type="submit" class="btn btn-success">YES</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



