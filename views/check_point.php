<style>

#scroll {
  height: 250px;
  overflow-y: scroll;
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
                    

  <div class="row">
    <div class="col-md-12">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Point Info</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
            <form method="post" action="<?php echo site_url('Main_c/check_point'); ?>?scan_card">
              <div class="form-group">
                <label data-toggle="tooltip" data-placement="right" title="Search cutomer detail by CardNo,ICNo,Name,PhoneNo,
                PassportNo or Address">Search Info</label>
                <input id="highlight" type="text" name="card_no" class="form-control" placeholder="Scan Card No"  autofocus autocomplete="off"
                <?php
                if(isset($_REQUEST['multiple']))
                {
                  ?>
                  value="<?php echo $_REQUEST['multiple']?>"
                  <?php
                }
                else
                {
                  ?>
                  value=""
                  <?php
                }
                ?>>
                <?php
                if($this->session->userdata('message'))
                {
                  echo "<br>";
                   echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                }
                ?>
              </div>
            </form>

            <?php if($CardNo != '')
            { ?>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Card No.</label>
                    <input type="text" class="form-control" value="<?php echo $CardNo?>"  name="card_no" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Account No.</label>
                    <input type="text"  name="noto" class="form-control" value="<?php echo $AccountNo?>"  name="account_no" readonly/>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="<?php echo $Name?>"  name="Name" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Mobile No.</label>
                    <input type="text"  name="noto" class="form-control" value="<?php echo $MobileNo?>"  name="MobileNo" readonly/>
                  </div>
                </div>
              </div>

              <?php
              if(in_array('VIC', $_SESSION['module_code']))
              { ?>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Ic No.</label>
                      <input type="text" class="form-control" value="<?php echo $IcNo?>"  name="IcNo" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Passport No.</label>
                      <input type="text"  name="noto" class="form-control" value="<?php echo $PassportNo?>"  name="PassportNo" readonly/>
                    </div>
                  </div>
                </div>

              <?php }; ?>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="text"  name="noto" class="form-control" value="<?php echo $ExpiryDate?>"  name="ExpiryDate" readonly/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Points Used</label>
                    <input type="text" class="form-control" name="ic_no" value="<?php echo $Pointsused?>" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                    <label>Point Balance</label>
                    <input type="text" class="form-control" value="<?php echo $Pointsbalance?>"  name="mobile_no" readonly/>
                  </div>
                </div>
                <?php
                if($active_expiry == 1)
                {
                  ?>
                  
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Point Expiry on <?php echo $expiry_on?></label>
                    <input type="text" class="form-control" value="<?php echo $point_expiry?>"  name="point_expiry" readonly/>
                  </div>
                </div>
                  <?php
                }
                ?>
              </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6" style="overflow-y: scroll; height: 410px;">

                <table id="" class="table table-bordered table-hover">
                  <thead style="cursor:s-resize"> 
                  <tr> 
                      <th>Period Code</th> 
                     <!--  <th>Account No</th>  -->
                      <th>Points BF</th>
                      <th>Point Adjusment</th> 
                      <th>Points Used</th>
                      <th>Point Balance</th> 
                  </tr> 
                  </thead> 
                  <tbody>
                   <?php
                    foreach ($get_point_movement->result() as $row)    
                        {                                        
                        ?> 
                    <tr>
                        <td><?php echo $row->PeriodCode ?></td>
                        <!-- <td><?php echo $row->AccountNo ?></td> -->
                        <td><?php echo $row->PointsBF?></td>
                        <td><?php echo $row->PointsAdj?></td>
                        <td><?php echo $row->PointsUsed?></td>
                        <td><?php echo $row->Pointsbalance ?></td>
                    </tr>
                     <?php
                        }
                        ?> 
                  </tbody> 
                </table>
              
              </div>

            <?php }; ?>
            <!-- /.col -->
            <div class="col-md-2" >
              
            </div>
          
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>

       <?php
      if(isset($_REQUEST['multiple']))
      {
        ?>
        <div class="box box-success">
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Action</th>
                <th>AccountNo</th>
                <th>CardNo</th>
                <th>Name</th>
                <th>IC NO</th>
                <th>Phone Mobile</th>
                <th>Expiry Date</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($record->result() as $row)
                { ?>

                <tr>
                  <td>
                    <a href="<?php echo site_url('Main_c/check_point?scan_card&select='.$row->CardNo); ?>"><button class="btn btn-info btn-xs" style="text-align: center;">SELECT</button></a>
                  </td>
                  <td><?php echo $row->AccountNo; ?></td>
                  <td><?php echo $row->CardNo; ?></td>
                  <td><?php echo $row->Name; ?></td>
                  <td><?php echo $row->ICNo; ?></td>
                  <td><?php echo $row->Phonemobile ?></td>
                  <td><?php echo $row->Expirydate; ?></td>
                </tr>
                
                <?php } ?>
               
              </tbody>
                
            </table>
          </div>
        </div>
        <?php
      }
      ?>
      
    </section>