<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Voucher View</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script src="<?php echo base_url('assets/JsBarcode.all.min.js');?>"></script>

    <script type="text/javascript">

        setTimeout( function ( )
        {
          self.close();
        }, 500 );

    </script>

</head>

<body onload="window.print();">

<?php foreach($result as $row)
{
    for ($x = 1; $x <= $row['QTY']; $x++) 
    { ?>

        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-success coupon_success">
                        <div class="panel-heading">
                            <div class="col-md-12 panel-title" id="title">

                                <?php if($title == 1)
                                { ?>

                                    <center><img src="<?php echo base_url($logo); ?>" alt="no image" height="<?php echo $logo_height; ?>" width="<?php echo $logo_width; ?>"></center>

                                <?php }
                                else
                                { ?>

                                    <center style="font-size:20px"><?php echo $company_profile; ?></center>

                                <?php } ?>
                
                            </div>
                        </div>
                        <div class="panel-heading" id="head">
                            <div class="col-md-12 panel-title" id="title">
                                <h2><small style="float:left;">&ensp;<?php echo $prefix; ?></small></h2>
                                <center>
                                <span class="valuetext"><?php echo number_format($row['AMOUNT'], 0); ?></span>
                                <center>
                            </div>
                        </div>
                        <div class="panel-body">
                            <label><b>Voucher Expiry Date: </b></label><br><br>
                            <div class="boxed">
                                <center><b><?php echo date("d/m/Y l" , strtotime($row['VALID_TO'])); ?></b></center>
                            </div>
                            <div class="issue" style="margin: 3px;">
                                <p>Issued On <span style="margin-left: 15px;">: <?php echo date("d/m/Y h:i:s a", strtotime($row['UPDATED_AT'])); ?></span></p>
                                <p>Issued By <span style="margin-left: 17px;">: <?php echo $row['UPDATED_BY']; ?></span></p>
                            </div>
                            <hr>
                            <div class="term">
                                <center><h4><b>Terms & Conditions</b></h4></center>
                            </div>
                            <!-- <img src="http://www.prepbootstrap.com/Content/images/shared/coupontemplate/coupon_green.jpg" class="coupon-img img-rounded img-responsive"> -->
                            <div class="col-md-12">
                                <!-- <ul class="items_success"> -->
                                <span class="break"><?php echo $t_c; ?></span>
                                <!-- </ul> -->
                            </div>
                            <!-- <div class="col-md-12">
                                <p class="disclosure_success">This voucher only can be redeemed</p>
                            </div> -->
                        </div>
                        <div class="panel-footer">
                            <!-- <div class="boxed">
                                <center><p>PANDA SOFTWARE HOUSE SDN. BHD</p></center>
                            </div> -->
                            <hr>
                            <div class="foot">
                                <br>
                                Account No. <span style="margin-left: 40px;">: <?php echo $row['SUP_CODE']; ?></span><br>
                                Name <span style="margin-left: 85px;">: <?php echo $row['SUP_NAME']; ?></span><br>
                                NRIC <span style="margin-left: 88px;">: <?php echo $ic; ?></span><br>
                                Point Balance<span style="margin-left: 33px;">: <?php echo $point_balance; ?></span>
                            </div>
                            <div class="coupon_success_footertext">
                                <center>
                                    <svg class="barcode"
                                      jsbarcode-value="<?php echo $row['REFNO']; ?>"
                                      jsbarcode-width="<?php echo $width?>"
                                      jsbarcode-height="<?php echo $height?>"
                                      jsbarcode-textmargin="0"
                                      jsbarcode-fontoptions="bold">
                                    </svg>
                                </center>
                                <!-- <span class="print">
                                    <a href="#" class="btn btn-link coupon_success_footertext"><i class="fa fa-lg fa-print"></i> Print Coupon</a>
                                </span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

    <?php } ?>
<?php } ?>

</body>

<script type="text/javascript">
/* <![CDATA[ */
  /*JsBarcode("#barcode", "<?php echo 'vf1234'; ?>");*/
  JsBarcode(".barcode").init();
</script>

<style type="text/css">

.container
{
    page-break-before: always;
    /*page-break-after: always;*/
}

</style>

<style>
    
    @media print 
    {
       @page
       {
        size: 3.5in 13.0in;
        margin: 0px 25px 0px 0px;
      }
    }

    .break {
        white-space: pre-line;
        text-align: justify;
    }

    .panel-body {
        font-size: 15px;
    }

    .boxed {
      border: 1px solid ;
      height: 23px;
      font-size: 15px;
      margin: 10px;
    }

    .coupon_success {
        /*border: 1px solid;*/
        border-radius: 10px;
        font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
        font-weight: 100;
        width: 380px;
        height: 780px;
        margin: 10px;
        /*background-color: #d1e9c7;*/
    }

    .coupon_success #head {
        min-height: 100px;
    }

    .coupon_success > footer {
        coupon_success-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        background-color: #d1e9c7;
    }

    .disclosure_success {
        
        /*font-size: 11px;*/
        color: #7a7979;
        text-align: center;
    }

    .coupon_success_footertext {
        color: #588944;
        font-size: 12px;
    }

    .items_success {
        margin: 0px 0px;
        /*color: #336633;*/
    }

    .coupon_primary {
        border: 2px dotted #9ec8ed;
        border-radius: 10px;
        font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
        font-weight: 100;
        width: 500px;
        margin: 25px;
        background-color: #337ab7;
    }

    .coupon_primary #head {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        min-height: 52px;
        background-color: #337ab7;
    }

    .coupon_primary > footer {
        coupon_primary-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        background-color: #337ab7;
    }

    .disclosure_primary {
        padding-top: 15px;
        /*font-size: 11px;*/
        color: #214f77;
        text-align: center;
    }

    .coupon_primary_footertext {
        color: #337ab7;
        /*font-size: 12px;*/
    }

    .items_primary {
        margin: 0px 0px;
        color: #9ec8ed;
    }

    .coupon_warning {
        border: 2px dotted #f0ad4e;
        border-radius: 10px;
        font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
        font-weight: 100;
        width: 500px;
        margin: 20px;
        background-color: #fbf6de;
    }

    .coupon_warning #head {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        min-height: 52px;
        background-color: #fbf6de;
    }

    .coupon_warning > footer {
        coupon_warning-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        background-color: #fbf6de;
    }

    .disclosure_warning {
        padding-top: 15px;
        /*font-size: 11px;*/
        color: #9b6f31;
        text-align: center;
    }

    .coupon_warning_footertext {
        color: #9b6f31;
        font-size: 12px;
    }

    .items_warning {
        margin: 0px 0px;
        color: #9b6f31;
    }

    .print {
        /*font-size: 14px;*/
        float: right;
    }

    #title .visible-xs {
        /*font-size: 14px;*/
    }

    .coupon_success #title img {
        /*font-size: 30px;*/
        /*height: 30px;*/
        margin-top: 5px;
    }

    .coupon #title span {
        float: right;
        margin-top: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .coupon-img {
        width: 100%;
        margin-bottom: 15px;
        padding: 0;
    }
    
    .value {
        font-size: 20px;
        font-weight: 500;
    }

    .valuetext {
        font-size: 150px;
        font-weight: 400;
    }

    #business-info ul {
        margin: 0;
        padding: 0;
        list-style-type: none;
        text-align: center;
    }

    #business-info ul li {
        display: inline;
        text-align: center;
    }

    #business-info ul li span {
        text-decoration: none;
    }

    #business-info ul li span i {
        padding-right: 5px;
    }

</style>