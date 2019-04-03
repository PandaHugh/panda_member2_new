<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Report View</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript">

        setTimeout( function ( )
        {
          self.close();
        }, 500 );

  </script>

  <style>

    td, th, b{
      font-size: 12px;
    }

    /*@media print {
        .Header, .Footer { display: none !important; }
    }*/
    @media print {
  #back {
    display: none;
  }
}
  </style>

  <!-- <style type="text/css" media="print">
      @page { 
          size: landscape!important;
      }
      body { 
          writing-mode: tb-rl;
      }
  </style> -->
  <br>
 <button type="" id="back" class="btn btn-success" onclick="location.href = '<?php echo site_url('Main_c/ewallet_topup')?>';" >Back</button>

</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
<div class="row">
  <div class="col-xs-12 col-ms-3 col-sm-6 col-md-6">
  <center><h3><?php echo $title; ?></h3>
  <h4><?php echo $sub_title; ?></h4></center>

  <section class="invoice">
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-xs-8">
      <h5><b><?php echo $form; ?></b></h5>
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
            <td style="width:50%;">Refno &emsp;&emsp;&emsp;: &emsp;<?php echo $REF_NO; ?></td>
            <td style="width:50%;">Served by &emsp;&emsp;&ensp;: &emsp;<?php echo $username; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Date &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $TRANS_DATE; ?></td>
            <td style="width:50%;">Posted on &emsp;&emsp;&ensp;: &emsp;<?php echo $UPDATED_AT; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Member &emsp;&emsp;: &emsp;<?php echo $SUP_NAME; ?></td>
            <td style="width:50%;">Account No &emsp;&emsp;: &emsp;<?php echo $SUP_CODE; ?></td>
          </tr>
          <tr>
            <td style="width:50%;"></td>
            <td style="width:50%;">Card No &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $Cardno; ?></td>
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
            <th style="width:40%;">Description</th>

            <?php if($cross_refno != '')
            { ?>

              <th style="width:30%;">Voucher No.</th>

            <?php }; ?>

            <th>Amount</th>
            <th>Qty</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>

          <?php foreach($child->result() as $row)
          { ?>

            <tr>
              <td><?php echo '' ?></td>
              <td><?php echo 'TOP UP'; ?></td>

              <?php if($cross_refno != '')
              { ?>

                <td><?php echo $row->cross_refno; ?></td>

              <?php }; ?>

              <td><?php echo $row->amount; ?></td>
              <td><?php echo '1'; ?></td>
              <td><?php echo abs($row->amount); ?></td>
            </tr>

          <?php } ?>

          </tbody>
          <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td><?php echo abs($sum_qty); ?></td>
              <td><?php echo abs($sum_total); ?></td>
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
              <th style="background: #dddddd;">Amount before <?php echo $text; ?> &ensp;:</th>
              <td style="width: 40%; text-align: right;"><?php echo $Point_before; ?></td>
            </tr>
            <tr>
              <th style="background: #dddddd;">Amount after <?php echo $text; ?>&ensp;&ensp;&ensp;:</th>
              <td style="width: 40%; text-align: right;"><?php echo $Point_after; ?></td>
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
      <b>Remarks :</b>&emsp;<?php echo $REMARK; ?>
    </div>
    </div>
  </section>
  <!-- /.content -->
  </div>
  <div class="col-xs-12 col-ms-3 col-sm-6 col-md-6">
  <center><h3><?php echo $title; ?></h3>
  <h4><?php echo $sub_title; ?></h4></center>

  <section class="invoice">
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-xs-8">
      <h5><b><?php echo $form; ?></b></h5>
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
            <td style="width:50%;">Refno &emsp;&emsp;&emsp;: &emsp;<?php echo $REF_NO; ?></td>
            <td style="width:50%;">Served by &emsp;&emsp;&ensp;: &emsp;<?php echo $username; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Date &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $TRANS_DATE; ?></td>
            <td style="width:50%;">Posted on &emsp;&emsp;&ensp;: &emsp;<?php echo $UPDATED_AT; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Member &emsp;&emsp;: &emsp;<?php echo $SUP_NAME; ?></td>
            <td style="width:50%;">Account No &emsp;&emsp;: &emsp;<?php echo $SUP_CODE; ?></td>
          </tr>
          <tr>
            <td style="width:50%;"></td>
            <td style="width:50%;">Card No &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $Cardno; ?></td>
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
            <th style="width:40%;">Description</th>

            <?php if($cross_refno != '')
            { ?>

              <th style="width:30%;">Voucher No.</th>

            <?php }; ?>

            <th>Point</th>
            <th>Qty</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>

          <?php foreach($child->result() as $row)
          { ?>

            <tr>
              <td><?php echo '' ?></td>
              <td><?php echo 'TOP UP'; ?></td>

              <?php if($cross_refno != '')
              { ?>

                <td><?php echo $row->cross_refno; ?></td>

              <?php }; ?>

              <td><?php echo $row->amount; ?></td>
              <td><?php echo '1'; ?></td>
              <td><?php echo abs($row->amount); ?></td>
            </tr>

          <?php } ?>

          </tbody>
          <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td><?php echo abs($sum_qty); ?></td>
              <td><?php echo abs($sum_total); ?></td>
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
              <th style="background: #dddddd;">Point before <?php echo $text; ?> &ensp;:</th>
              <td style="width: 40%; text-align: right;"><?php echo $Point_before; ?></td>
            </tr>
            <tr>
              <th style="background: #dddddd;">Point after <?php echo $text; ?>&ensp;&ensp;&ensp;:</th>
              <td style="width: 40%; text-align: right;"><?php echo $Point_after; ?></td>
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
      <b>Remarks :</b>&emsp;<?php echo $REMARK; ?>
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
