<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  
  <title>Card PRint</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?php
  if(isset($_REQUEST['print_card']))
  {
    ?>    
      <meta http-equiv="refresh" content="1; url=<?php echo site_url($_REQUEST['redirect'])?>" media="all">
    <?php
  }
  ?>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/bootstrap/css/bootstrap.min.css'); ?>">
  <script src="<?php echo base_url('assets/template/bootstrap/js/bootstrap.min.js')?>"></script> 
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css'); ?>">


  <script src="<?php echo base_url('assets/JsBarcode.all.min.js');?>"></script>

  <style type="text/css">

  code {
  background-color: #90ed89; 
  color: #666;
  font: 10px/18px Arial, Helvetica, sans-serif;
  display: inline-block;
  height: <?php echo $border_height ?>;
  width:<?php echo $border_width ?>;
  margin: 0 0px;
  /*padding-top: 20px;*/
  text-align: center;
  
}
.border-solid {
  /*border: 2px solid black;*/
}
#print{
  .page-break { display: block; page-break-before: always; }
}

.text_font {
  font: <?php echo $text_font.'px'?> Arial, Helvetica, sans-serif;
}


/*@media print {

  @page
        {
        size: <?php echo $page_width ?> <?php echo $page_height ?>;
        size: landscape;
      }
}*/

@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}

@media print {
    @page { 
    margin: 0; 
    }

    body
    {
      margin-bottom: 0px;
    margin-left: 10px;
    margin-right : 10px;
    margin-top:  20px;
    }
    }
</style>

</head>

<!--  -->
<body onload="window.print();">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="print">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>


        <div class="page-break">
        <code class="border-solid" >
          <!-- <h5 class="page-header">Pallet No</h5>
          <br> -->
          <div class="row">
            <div class="col-md-12" style="height: 40%">
              <p class="text_font" style="text-align: left;font-weight:bold;"><?php echo $content_header?></p>
            </div>
          </div>
          <div class="row" style="height: 90px">
            <div class="col-md-12" style="height: 40%;padding-bottom: 0px">
              <p class="text_font" style="text-align: left"><?php echo $content_message?></p>
            </div>
          </div>
          <div class="row" >
            <div class="pull-left" style="text-align: left;padding: 0px 15px">
              
            <h6 style="margin-bottom:0px;"><?php echo $name?></h6>  
            <svg class="barcode_generator"
                jsbarcode-value="<?php echo $card_no?>"
                jsbarcode-margin="0"
                jsbarcode-textAlign="left"
                jsbarcode-fontoptions="bold"
                jsbarcode-fontSize="<?php echo $barcode_fontsize ?>"
                jsbarcode-displayValue="true"
                jsbarcode-height="<?php echo $barcode_height ?>"
                jsbarcode-width="<?php echo $barcode_width ?>"

                jsbarcode-textPosition="top"></svg><br>
            <span><?php echo $card_type; ?></span>
            </div>          
            <div class="pull-right" style="padding: 20px">  
              <h6 >Expiry Date</h6>
              <?php
                $expiry_date = date_create($expiry_date);
              ?>
              <p class="text_font"><?php echo date_format($expiry_date, "d-M"); ?></p>
            </div>
          </div>
        </code>
        </div>

  </div>
<script type="text/javascript">

  JsBarcode(".barcode_generator").init();
</script>

</body>
</html>
