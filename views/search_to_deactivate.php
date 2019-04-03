<style>

#scroll {
  height: 250px;
  overflow-y: scroll;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
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
      <h1>Update Account Status</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
            <form method="post" action="<?php echo site_url('Pending_c/search_to_deactivate'); ?>?scan_card">
              <div class="form-group">
                <label data-toggle="tooltip" data-placement="right" title="Search cutomer detail by CardNo,ICNo,Name,PhoneNo,
                PassportNo or Address">Search Info</label>
                <input id="highlight" type="text" name="card_no" class="form-control" placeholder="Search Info" required autofocus
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

              <div id="result" style="<?php echo $style; ?>">
                <!-- /.form-group -->
                <form id='save' method="post" action="<?php echo site_url('Pending_c/save_status')?>">
                  <!-- <div class="form-group" id="receipt_box" style="display: none;">
                    <label>Receipt No. <a style="color:red;">*</a></label>
                    <input type="text" name="receipt_no" class="form-control" placeholder="Scan Receipt No" id="receipt_no" onkeyup="bypass_receipt(this)" required>
                  </div>
                  <div class="form-group" id="reason_box" style="display: none;">
                    <label>Reason<a style="color:red;">*</a></label>
                    <select name="reason" class="form-control" id="reason" onchange="">
                      <option hidden selected value> -- Select a reason -- </option>

                    <?php
                    foreach($reason->result() as $row)
                    { ?>

                        <option required value="<?php echo $row->reason?>"><?php echo $row->reason;?></option>

                    <?php } ?>

                  </select>
                  </div> -->
                  <div class="form-group" <?php echo $_SESSION['hidden_result']?>>
                    <label>Branch</label>
                    <select class="form-control" name="branch" id="branch" required>
                      <?php if(sizeof($branch) > '1'){ ?>
                      <option hidden selected value> -- Select a branch -- </option>
                    <?php } ?>
                      <?php
                      foreach($branch as $row)
                      {
                        ?>
                          <option required value="<?php echo $row['branch_code']?>"><?php echo $row['branch_name']; echo "&nbsp (".$row['branch_code'].")"?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
               <div class="row">
               <div class="col-md-12">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="<?php echo $_SESSION['Name']?>" required name="Name" readonly>
                  </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Passport No.</label>
                    <input type="text"  name="noto" class="form-control" value="<?php echo $_SESSION['Passport_No']?>" required readonly name="Passport_No" readonly/>
                  </div>
                </div>
                </div>

                <div class="row">
                <!-- <div class="form-group col-md-6">
                  <label>Expiry Date</label>
                    <input type="date"  class="form-control" name="expiry_date" value="<?php echo $expiry_date?>" required>
                </div> -->
                
                </div>
                
              </div>

            </div>
            <!-- /.col -->
            <div id="result" class="col-md-4" style="<?php echo $style; ?>">

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Status <a style="color:red;">*</a></label>
                    <select class="form-control" name="active" id="active" required>
                          <?php
                          if($active == '1')
                            {
                              ?>
                              <option value="SUSPEND">SUSPEND</option>
                              <option value="TERMINATE">TERMINATE</option>
                              <?php
                            }
                            else
                            {
                              ?>
                              <option value="ACTIVE">ACTIVATE</option>  
                              <option value="TERMINATE">TERMINATE</option>
                              <?php
                            }
                            ?>
                          
                    </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Account No.</label>
                  <input type="text" class="form-control" value="<?php echo $_SESSION['account_no']?>" required readonly name="account_no"/>
                  <input type="hidden" name="accountno" value="<?php echo $_SESSION['account_no']?>" />
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>IC No.<small class="help-block">Ex: 880455-02-2200</small></label>
                  <input type="text" data-inputmask='"mask": "999999-99-9999"' data-mask class="form-control" name="ic_no" value="<?php echo $_SESSION['ic_no']?>" required readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Mobile No.<small class="help-block">Ex: 011-2265222</small></label>
                  <input type="text" class="form-control" value="<?php echo $_SESSION['mobile_no']?>" required name="mobile_no" readonly/>
                </div>
              </div>
              </div>

              <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" name="remarks" rows="4" placeholder="Remarks"></textarea>
              </div>
              
              <div <?php echo $_SESSION['hidden_result']?>>
                
              <button type="submit" class="btn btn-success pull-right">Save</button> <!-- onclick="$('#save').submit()" -->
              </div>
            </form>
            
            </div>
            <!-- /.col -->
            <!-- <div class="col-md-4" >
              <div class="lockscreen-wrapper">
                <div class="lockscreen-logo">
                  <a href="../../index2.html"><b style="color: #ff9900">Page Under Construction</b> <i class="fa fa-spin fa-refresh"></i></a>
                </div>
                
                <div class="lockscreen-name"></div>

                
                <div class="lockscreen-item">
                 
                

                </div>
                
                <div class="help-block text-center">
                  Contact Panda Support.
                </div>
                <div class="text-center">
                  
                </div>
                <div class="lockscreen-footer text-center">
                  Copyright &copy; <b><a href="http://www.pandasoftware.my/" class="text-black">Panda Software House Sdn. Bhd.</a></b><br>
                  All rights reserved
                </div>
              </div>
            </div> -->
          
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
                    <a href="<?php echo site_url('Pending_c/search_to_deactivate?scan_card&select='.$row->CardNo); ?>"><button class="btn btn-info btn-xs" style="text-align: center;">SELECT</button></a>
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

<script> 
   $(document).ready(function(){  
        /*id=Current*/
        $('#branch').change(function(){  
          
             var branch = $('#branch').val();
             /*var field = 'receipt_activate';*/   
             var field = "<?php echo $field; ?>";
  
             if(branch != '')  
             {  
                $.ajax({  
                        /*ajax: go into controller as shown below*/
                       url:"<?php echo site_url('Transaction_c/receiptno_by_branch'); ?>",  
                       method:"POST",  
                       data:{branch:branch, field:field}, 
                       success:function(data){  
                            /*get echo data from controller*/
                          if(data == 1)
                            {
                              document.getElementById('receipt_box').style.display = 'block';
                              document.getElementById('receipt_no').required = true;
                            }
                          else
                            {
                              document.getElementById('receipt_box').style.display = 'none';
                              document.getElementById('receipt_no').required = false;
                            }          
                             
                       }  
                  });  
             }  
        });  
   });

   function bypass_receipt(obj) 
    {
      var receipt = document.getElementById('receipt_no').value;

      if(receipt == '-')
      {
        document.getElementById('reason_box').style.display = 'block';
        document.getElementById('reason').required = true;
      }
      else
      {
        document.getElementById('reason_box').style.display = 'none';
        document.getElementById('reason').required = false;
      }    
    }
</script>

