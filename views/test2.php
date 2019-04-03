<script src="<?php echo base_url('assets/JsBarcode.all.min.js');?>"></script>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-success coupon_success">
                <div class="panel-heading">
                    <div class="col-md-12 panel-title" id="title">
                        <center><span class="value">PANDA SOFTWARE HOUSE SDN. BHD</span></center>
                    </div>
                </div>
                <div class="panel-heading" id="head">
                    <div class="col-md-12 panel-title" id="title">
                        <center><span class="valuetext">RM20</span></center>
                    </div>
                </div>
                <div class="panel-body">
                    <label>Voucher Expiry Date: </label>
                    <div class="boxed">
                        <center><p>16 October 2018</p></center>
                    </div>
                    <div class="issue">
                        <p>Issued On <span style="margin-left: 15px;">: 2017-10-16 12:52:02</span></p>
                        <pl>Issued By <span style="margin-left: 20px;">: ADMIN</span></p>
                    </div>
                    <hr>
                    <div class="term">
                        <center><h4><b>Terms & Conditions</b></h4></center>
                    </div>
                    <!-- <img src="http://www.prepbootstrap.com/Content/images/shared/coupontemplate/coupon_green.jpg" class="coupon-img img-rounded img-responsive"> -->
                    <div class="col-md-12">
                        <ul class="items_success">
                            <li>Vouchers can be replaced if lost, stolen (but not used) or destroyed. Just email us.</li>
                            <li>Only one voucher/voucher code can be used per booking.</li>
                            <li>Vouchers can only be used with Responsible Travel members towards full and final payment for any holiday or accommodation marked as eligible. They may not be used against a deposit or other part payment.</li>
                            <li>Vouchers are non-refundable and non-exchangable.</li>
                            <li>Your voucher can be used against multiple bookings.</li>
                            <li>In the case of vouchers with a minimum spend the full minimum spend must be reached within the same one single booking in order for the voucher to be redeemed.</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <p class="disclosure_success">This voucher only can be redeemed</p>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="boxed">
                        <center><p>PANDA SOFTWARE HOUSE SDN. BHD</p></center>
                    </div>
                    <div class="foot">
                        Account No. <span style="margin-left: 40px;">: 12345</span><br>
                        Name <span style="margin-left: 95px;">: Mr. Lee</span><br>
                        NRIC <span style="margin-left: 100px;">: 763892-01-7829</span><br>
                        Point Balance<span style="margin-left: 30px;">: 100</span>
                    </div>
                    <div class="coupon_success_footertext">
                        <svg id="barcode"></svg>
                        <!-- <span class="print">
                            <a href="#" class="btn btn-link coupon_success_footertext"><i class="fa fa-lg fa-print"></i> Print Coupon</a>
                        </span> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
/* <![CDATA[ */
  JsBarcode("#barcode", "Hi world!");
</script>

<style>

    .boxed {
      border: 1px solid ;
      height: 40px;
      font-size: 20px;
    }

    .issue {
      font-size: 25px;
    }

    .foot {
      font-size: 20px;
    }

    .coupon_success {
        border: 2px dotted #336633;
        border-radius: 10px;
        font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
        font-weight: 100;
        width: 500px;
        margin: 20px;
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
        padding-top: 15px;
        font-size: 11px;
        color: #7a7979;
        text-align: center;
    }

    .coupon_success_footertext {
        /*color: #588944;*/
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
        margin: 20px;
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
        font-size: 11px;
        color: #214f77;
        text-align: center;
    }

    .coupon_primary_footertext {
        color: #337ab7;
        font-size: 12px;
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
        font-size: 11px;
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
        font-size: 14px;
        float: right;
    }

    #title .visible-xs {
        font-size: 14px;
    }

    .coupon_success #title img {
        font-size: 30px;
        height: 30px;
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
        font-size: 50px;
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