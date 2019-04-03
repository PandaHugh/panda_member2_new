<?php 
'session_start()' 
?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
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

#scroll {
  height: 250px;
  overflow-y: scroll;
}

</style>

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
      <h1>Assign Card To Merchant</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <form name="myform" method="post" action="<?php echo site_url('Transaction_c/insert_assign_card')?>">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>From <a style="color:red;">*</a></label>
                    <input type="text" id="nofrom" name="nofrom" class="form-control" placeholder="Number From" value="<?php echo $nofrom; ?>" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>To <a style="color:red;">*</a></label>
                    <input type="text" id="noto" name="noto" class="form-control" placeholder="Number To" value="<?php echo $noto; ?>" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label>Merchant <a style="color:red;">*</a></label>
                  <select class="form-control" name="merchant" id='merchant' required>
                    <option hidden selected value> -- Please select merchant -- </option>

                    <?php
                    foreach($merchant_list as $row)
                    {
                      ?>
                        <option value="<?php echo $row['ID']; ?>"

                        <?php if($merchant == $row['ID'])
                        {
                          echo "selected";
                        } ?> ><?php echo $row['name']; echo "&nbsp (".$row['ID'].")"?></option>

                    <?php } ?>

                  </select>
                </div>
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-md-4">
              <br>
              
              <button title="Edit" id="create" type="button" class="btn btn-success pull-left" data-toggle="modal">Assign</button>

            </div> 
          </div>
        </div>
        <!-- /.box-body -->
        </form>
      </div>
      <!-- /.box -->
      <div class="box box-default">
        
        <div class="box">
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Card From</th>
                <th>Card To</th>
                <th>Merchant ID</th>
                <th>Created at</th>
                <th>Created by</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($non_active->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->from_no; ?></td>
                  <td><?php echo $row->to_no; ?></td>
                  <td><?php echo $row->merchant_id; ?></td>
                  <td><?php echo $row->created_at; ?></td>
                  <td><?php echo $row->created_by; ?></td>
                </tr>
                
                <?php } ?>
                   
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.box -->
    </section>

<script>
$('#create').click(function() {

    //output
    var x = document.forms["myform"]["nofrom"].value;
    var y = document.forms["myform"]["noto"].value;
    var z = document.forms["myform"]["merchant"].value;

    //length
    var x_length = x.length;
    var y_length = y.length;

    if (x == '' || y == '' || z == '' )
    {
      alert("Please fill in required field!");
      return false;
    }

    if (x_length != y_length)
    {
      alert("Length of card no. does not match!");
      return false;
    }

    if (x > y)
    {
      alert("Value 'From' cannot be more than value 'To'!");
    }
    else
    {
      $('#\\#reminder').modal('show');
      $(".modal-body #nofrom").val( x );
      $(".modal-body #noto").val( y );
      $(".modal-body #merchant").val( z );
      document.getElementById('msg1').innerHTML = x;
      document.getElementById('msg2').innerHTML = y;
    }
});

</script>

<!--  Modal-->
<div class="modal fade" id="#reminder">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h3 class="modal-title" style="color:red;">Confirmation!</h3>
            </div> -->
            <form action="<?php echo site_url('Transaction_c/insert_assign_card')?>" method="POST" id="form" class="form-horizontal">
              <div class="modal-body form">
                <div>
                  <h2><center>Are you sure want to assign card no. from <i><b><div id="msg1" style="color: red;"></div></b></i> to <i><b><div id="msg2" style="color: red;"></div></b><i>?</center></h2>
                </div>
                <input type="hidden" name="nofrom" id="nofrom" />
                <input type="hidden" name="noto" id="noto" />
                <input type="hidden" name="merchant" id="merchant" />
              </div>
              <div class="modal-footer">
                  <!-- <button type="submit" class="btn btn-sm btn-primary">Save</button> -->
                  <center>
                    <input type="submit" class="btn btn-sm btn-primary" value="YES" />
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">NO</button>
                  </center>
              </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>