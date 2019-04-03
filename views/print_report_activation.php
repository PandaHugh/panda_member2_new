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
 <!--  <script type="text/javascript">

        setTimeout( function ( )
        {
          self.close();
        }, 500 );

  </script> -->

  <style>

    td, th, b{
      font-size: 12px;
    }

    td {
      border: 1px solid black !important;
    }

    .break {
        white-space: pre;
        text-align: justify;
    }

    @media print {
      #printPageButton {
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

</head>
<body>
<div class="wrapper">
  <!-- Main content -->

<div class="row">
  <div class="col-xs-12 col-ms-3 col-sm-6 col-md-6">
  <button onclick="window.print();" style="float: right;" id="printPageButton">Print</button>
  <center><h3><?php echo $title; ?></h3>
  <h4>Member Registration Form</h4></center>

  <section class="invoice">
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-xs-8">
      <!-- <h5><b>CARD "INFINITE"</b></h5> -->
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
            <td style="width:50%;">Name &emsp;&emsp;&emsp;: &emsp;<?php echo $Name; ?></td>
            <td style="width:50%;">Card no. &emsp;&emsp;&ensp;: &emsp;<?php echo $Card; ?></td>
          </tr>
          <tr>

            <?php if(strtoupper($Nationality) == 'MALAYSIAN' || strtoupper($Nationality) == 'MALAYSIA' || strtoupper($Nationality) == 'MALAYSIAN (ARMY)')
            { ?>

              <td style="width:50%;">IC no. &emsp;&emsp;&emsp;: &emsp;<?php echo $IC; ?></td>

            <?php }
            else
            { ?>

              <td style="width:50%;">Passport no.&emsp;: &emsp;<?php echo $Passport; ?></td>

            <?php } ?>
            <td style="width:50%;">DOB &emsp;&emsp;&emsp;&emsp;: &emsp;<?php echo $DOB; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Race &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $Race; ?></td>
            <td style="width:50%;">Nationality &emsp;: &emsp;<?php echo $Nationality; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Gender &emsp;&emsp;: &emsp;<?php echo $Gender; ?></td>
            <td style="width:50%;">Postcode &emsp;&emsp;: &emsp;<?php echo $Postcode; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Mobile no. &emsp;: &emsp;<?php echo $Mobile; ?></td>
            <td style="width:50%;">City &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $City; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Email &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $Email; ?></td>
            <td style="width:50%;">State &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $State; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Store &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $Store; ?></td>
            <td style="width:50%;">Address 1&emsp;&emsp;: &emsp;<?php echo $Address1; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Activated by&ensp;: &emsp;<?php echo $Activated; ?></td>
            <td style="width:50%;">Address 2&emsp;&emsp;: &emsp;<?php echo $Address2; ?></td>
          </tr>
          <tr>
            <td style="width:50%;">Date &emsp;&emsp;&emsp;&ensp;: &emsp;<?php echo $Date; ?></td>
            <td style="width:50%;">Address 3&emsp;&emsp;: &emsp;<?php echo $Address3; ?></td>
          </tr>
        </table>
      </div>
    </div>

    <!-- /.row -->
    <br><br><br>
    <div class="row">
    <div class="col-xs-7">
      <input type="text" style="border: none; border-bottom: 1px solid #000; width: 70%;" /><br>
      <span style="font-size: 100%"><b>Signed by</b></span><br><br>
      <span style="font-size: 70%"><b>Terms & Conditions</b></span><br>
      <span style="font-size: 70%" class="break"><?php echo $t_c; ?></span>
    </div>
    <div class="col-xs-5" >
      <b>Remarks :</b>
    </div>
    </div>
  </section>
  <!-- /.content -->
  </div>


</div>
</div>
<!-- ./wrapper -->
</body>

<script type="text/javascript">
  window.onload = function() {
      if(!window.location.hash) {
          window.location = window.location + '#loaded';
          window.location.reload();
          window.print();
      }
  }
</script>
</html>
