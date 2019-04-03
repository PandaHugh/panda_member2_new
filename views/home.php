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
            <div id="page-inner">
             <?php if($this->session->flashdata('msg')): ?>
            <strong><center><?php echo $this->session->flashdata('msg'); ?></center></strong>
            <?php endif; ?>
            <?php if($this->session->userdata('message'))
            {
               echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
            } ?>

                    <center>
                      <br>
                        <form class="form-inline" role="form" method="POST" id="myForm" 
                          action="<?php echo $form_search; ?>">
                            <div class="form-group">
                                <select name="search"  class="form-control" id="sel1" style="background-color:white;color:black;width: 175px;margin-bottom: 5px" required>
                                      <!--<option hidden>Search by:</option>-->
                                      <option value="Card">Card No:</option>
                                      <option value="Account">Account No:</option>
                                      <option value="Name">Name:</option>

                                      <?php
                                      if(in_array('VIC', $_SESSION['module_code']) || $_SESSION['user_group'] == 'MERCHANT GROUP')
                                      { ?>

                                        <option value="Ic">Ic No:</option>
                                        <option value="Passport">Passport No:</option>

                                      <?php }; ?>

                                      <option value="Phone">Phone No:</option>
                                      <option value="Address">Address:</option>
                                      <option value="General">General Search:</option>
                                </select>
                                <span class="input-group-btn">
                                <input type="text" style="width: 300px;" class="form-control" placeholder="Search Info" name="memberno" id="textarea" required autofocus/>
                                </span>
                            </div>
                        </form>
                        <button type="" class="btn" style="margin-top: 5px;" onclick="location.href = '<?php echo site_url('main_c')?>';" >Reset</button><br>
                      </center>
                   

                        <div class="row">
                            <div class="col-md-12">
                                <div id="liveEDit">
                                    <div style="overflow-x:auto;">
                              <table id="member" class="table table-bordered table-hover">
                                <thead style="cursor:s-resize"> 
                                <tr> 
                                    <th>Card No</th> 
                                    <th>Account No</th> 
                                    <th>Expired Date</th>
                                    
                                    <?php
                                    if(in_array('VIC', $_SESSION['module_code']) || $_SESSION['user_group'] == 'MERCHANT GROUP')
                                    { ?>

                                      <th>IC No</th>

                                    <?php }; ?>

                                    <th>Phone No</th> 
                                    <th>Name</th> 
                                    <th style="text-align: center; width: 200px;">Full Detail</th>
                                    <th style="text-align: center;">Purchase Details</th>
                                </tr> 
                                </thead> 
                                <tbody>
                                <!--<?php
                                  if($this->uri->segment(2) == 'search')
                                  {
                                ?>
                                <?php
                                  foreach ($data->result() as $row)    
                                    {                                        
                                    ?> 
                                <tr>
                                    <td><?php echo $row->CardNo ?></td>
                                    <td><?php echo $row->AccountNo ?></td>
                                    <td><?php echo $row->Expirydate?></td>

                                    <?php
                                    if(in_array('VIC', $_SESSION['module_code']))
                                    { ?>

                                      <td><?php echo $row->ICNo?></td>

                                    <?php }; ?>

                                    <td><?php echo $row->Phonemobile ?></td>
                                    <td><?php echo $row->Name ?></td>
                                    <td style="text-align:center">
                                    <?php
                                    $supcard = $this->db->query("SELECT IF(COUNT(*) > 0,1,0) AS result FROM member a INNER JOIN membersupcard b ON a.`AccountNo` = b.`AccountNo` 
                                      WHERE a.`AccountNo` = '$row->AccountNo' AND b.`PrincipalCardNo` = 'SUPCARD'");
                                    if($supcard->row('result') > 0)
                                    {
                                      ?>
                                      <a href="<?php echo site_url('main_c/supcard_details')?>?AccountNo=<?php echo $row->AccountNo?>&Name=<?php echo $row->Name?>"><button title="View" type="button" class="btn btn-xs btn-info">Sup Card <i class="fa fa-eye"></i></button></a>
                                      <?php
                                    }
                                    else
                                    {
                                      ?>

                                      <?php
                                    }
                                    ?>
                                    <a href="<?php echo site_url('main_c/full_details')?>?AccountNo=<?php echo $row->AccountNo?>"><button title="View" type="button" class="btn btn-xs btn-primary">Primary Card <i class="fa fa-eye"></i></button></a>
                                    </td>
                                    <td style="text-align:center">
                                    <button title="View" type="button" class="btn btn-xs btn-success" onclick="location.href = '<?php echo site_url('main_c/purchase_details')?>?AccountNo=<?php echo $row->AccountNo?>&Name=<?php echo $row->Name?>';"
                                      <?php
                                      if($_SESSION['user_group'] == 'MERCHANT GROUP')
                                      {
                                        echo "disabled";
                                      }
                                      ?>>Purchase Details <i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                 <?php
                                    }
                                    ?>
                                  <?php } ?>-->
                                </tbody>
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
    </div>
    </div>