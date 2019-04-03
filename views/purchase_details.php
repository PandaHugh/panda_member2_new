<?php 
'session_start()' 
?>


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
  <div class="box">
            <!-- /.box-header -->
    <div class="box-body">
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
            <a href = "<?php echo site_url('Main_c'); ?>">
              <button class = "btn btn-xs btn-primary pull-right">Back</button>
            </a>
            <div id="page-inner">
             <?php if($this->session->flashdata('msg')): ?>

            <strong><center><?php echo $this->session->flashdata('msg'); ?></center></strong>
            <?php endif; ?>
             
                         <center><h3><b>Purchase Details</b></h3>
                            <h4><?php echo $_REQUEST['AccountNo'] ?></h4>
                            <h4><?php echo $_REQUEST['Name'] ?></h4>
                         </center>
            <?php if(in_array('TIE', $_SESSION['module_code']))
            { 
            ?>
              <a href="<?php echo site_url($excel); ?>?AccountNo=<?php echo $_REQUEST['AccountNo']; ?>"><button type="submit" class="btn btn-success btn-xs" style="float:left"><b><i class="fa">&#xf1c3;</i> EXPORT</b></button></a> 

            <?php 
          }; ?>

            <div class="row">
                <div class="col-md-12">
                    <!-- <h1 class="page-head-line">
                        <a href="<?php echo site_url('main_c')?>" class="btn btn-default btn-xs"  style="float:right;" >
                          <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
                    </h1> -->
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div><br><br>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="liveEDit">
                                    <div style="overflow-x:auto;">
                              <table id="purchase_details_server_side" class="table table-bordered table-hover">
                                <thead style="cursor:s-resize"> 
                                <tr> 
                                    <th>REF No</th> 
                                    <th>Transdate</th> 
                                    <th>Description</th>
                                    <th>Price</th>  
                                    <th>Quantity</th> 
                                    <th>Total</th> 
                                </tr> 
                                </thead> 
                                <!-- <tbody>
                                <?php
                                foreach ($data as $row)    
                                    {                                        
                                    ?> 
                                <tr>
                                    <td><?php echo $row['refno'] ?></td>
                                    <td><?php echo $row['transdate'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td><?php echo $row['price'] ?></td>
                                    <td><?php echo $row['qty'] ?></td>
                                    <td><?php echo $row['total'] ?></td>
                                </tr>
                                 <?php
                                    }
                                    ?> 
                                </tbody>  -->
                                </table>
                            </div>
                            </div>

                            </div>
                </div>
            </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
