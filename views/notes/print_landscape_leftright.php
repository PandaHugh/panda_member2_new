<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Report View</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css'); ?>">

  <!-- <script type="text/javascript">

        setTimeout( function ( )
        {
          self.close();
        }, 500 );

  </script> -->

  <style>

    td, th, b{
      font-size: 12px;
    }

  </style>

</head>
<body>
<div class="wrapper">
  <!-- Main content -->
<div class="row">
  <div class="col-xs-12 col-ms-3 col-sm-6 col-md-6">
  <center><h3>PANDA</h3>
  <h4>HOUSE</h4></center>

  <section class="invoice">
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-xs-8">
      <h5><b>Form</b></h5>
      </div>
      <!-- /.col -->
      <div class="col-xs-4 invoice-col table-responsive" align="right">
      <h5><b>Office Copy</b></h5>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
          <tr>
            <td style="width:50%;">Refno &emsp;&emsp;&emsp;: &emsp;12345</td>
            <td style="width:50%;">Served by &emsp;&emsp;&ensp;: &emsp;abcd</td>
          </tr>
          <tr>
            <td style="width:50%;">Date &emsp;&emsp;&emsp;&ensp;: &emsp;10.10.2016</td>
            <td style="width:50%;">Posted on &emsp;&emsp;&ensp;: &emsp;10.10.2016</td>
          </tr>
          <tr>
            <td style="width:50%;">Member &emsp;&emsp;: &emsp;bacd</td>
            <td style="width:50%;">Account No &emsp;&emsp;: &emsp;54321</td>
          </tr>
        </table>
      </div>
    </div>

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th>Code</th>
            <th style="width:50%;">Description</th>
            <th>Point</th>
            <th>Qty</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td>5</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td>15</td>
              <td>15</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-xs-7 col-xs-offset-5">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th style="background: #dddddd;">Point before adjust &ensp;:</th>
              <td style="width: 40%; text-align: right;">500</td>
            </tr>
            <tr>
              <th style="background: #dddddd;">Point after adjust&ensp;&ensp;&ensp;:</th>
              <td style="width: 40%; text-align: right;">600</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
    <div class="col-xs-5">
      <input type="text" style="border: none; border-bottom: 1px solid #000; width: 70%;" /><br>
      <span style="font-size: 100%;">Received by<br>
      IC No :</span>
    </div>
    <div class="col-xs-7" >
      <b>Remarks :</b>&emsp;done
    </div>
    </div>
  </section>
  <!-- /.content -->
  </div>
  <div class="col-xs-12 col-ms-3 col-sm-6 col-md-6">
  <center><h3>PANDA</h3>
  <h4>HOUSE</h4></center>

  <section class="invoice">
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-xs-8">
      <h5><b>Form</b></h5>
      </div>
      <!-- /.col -->
      <div class="col-xs-4 invoice-col table-responsive" align="right">
      <h5><b>Member Copy</b></h5>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
          <tr>
            <td style="width:50%;">Refno &emsp;&emsp;&emsp;: &emsp;12345</td>
            <td style="width:50%;">Served by &emsp;&emsp;&ensp;: &emsp;abcd</td>
          </tr>
          <tr>
            <td style="width:50%;">Date &emsp;&emsp;&emsp;&ensp;: &emsp;10.10.2016</td>
            <td style="width:50%;">Posted on &emsp;&emsp;&ensp;: &emsp;10.10.2016</td>
          </tr>
          <tr>
            <td style="width:50%;">Member &emsp;&emsp;: &emsp;bacd</td>
            <td style="width:50%;">Account No &emsp;&emsp;: &emsp;54321</td>
          </tr>
        </table>
      </div>
    </div>

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th>Code</th>
            <th style="width:50%;">Description</th>
            <th>Point</th>
            <th>Qty</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td>5</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td>15</td>
              <td>15</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-xs-7 col-xs-offset-5">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th style="background: #dddddd;">Point before adjust &ensp;:</th>
              <td style="width: 40%; text-align: right;">500</td>
            </tr>
            <tr>
              <th style="background: #dddddd;">Point after adjust&ensp;&ensp;&ensp;:</th>
              <td style="width: 40%; text-align: right;">600</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!-- /.row -->
    <!-- <input type="text" style="border: none; border-bottom: 1px solid #000; width: 20%;" /><br>
    <span style="font-size: 120%;">Received by<br>
    IC No :</span> -->
    <div class="row">
    <div class="col-xs-5">
    </div>
    <div class="col-xs-7" >
      <b>Remarks :</b>&emsp;done
    </div>
    </div>
  </section>
  <!-- /.content -->
  </div>


</div>
</div>
<!-- ./wrapper -->
</body>
</html>
