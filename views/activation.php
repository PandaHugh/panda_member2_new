<style>

#scroll {
  height: 250px;
  overflow-y: scroll;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo base_url('assets/js/mykad.js'); ?>" language="javascript" type="text/javascript"> </script>
<script src="<?php echo base_url('js/jquery.min.js');?>"></script>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

</script>
<script src="<?php echo base_url('js/jquery.min.js');?>"></script>
<!--onload Init-->
<body onload="<?php echo $bodyload; ?>;selectNationality(this);">
  
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
    <div id="page-inner">
                    

  <div class="row">
    <div class="col-md-12">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $button?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
            <form method="post" action="<?php echo $direction; ?>?scan_card" >
              <div class="form-group">
                <label>Card No.</label>
                <input id="highlight" type="text" name="card_no" class="form-control" placeholder="Scan Card No" required autofocus>
                <?php
                if($this->session->userdata('message'))
                {
                  echo "<br>";
                   echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                }
                ?>
              </div>
            </form>
            
            <form id='save' method="post" action="<?php echo $form ?>">
              <div id="result" <?php echo $_SESSION['hidden_result']?> >
                <?php
                    if($button == 'Upgrade Card')
                    {
                  ?>
                  <div class="form-group">
                    <label>Card Type <a style="color:red;">*</a></label>
                    <select class="form-control" name="cardtype">
                      <option hidden selected value> -- Select card type -- </option>
                      <?php
                        foreach($cardtype_list->result() as $card_list)
                        {
                          if($cardtype != $card_list->CardType)
                          {
                      ?>
                          <option value="<?php echo $card_list->CardType; ?>"><?php echo $card_list->CardType; ?></option>
                      <?php
                          }
                        }
                      ?>
                    </select>
                  </div>
                  <?php
                    }
                  ?>
                <!-- /.form-group -->
                <div class="form-group" id="receipt_box" style="display: none;">
                  <label>Receipt No. <a style="color:red;">*</a></label>
                  <input type="text" name="receipt_no" class="form-control to_watch" placeholder="Scan Receipt No" id="receipt_no" onkeyup="bypass_receipt(this)">
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
                </div>
                <!-- <input type="text" class="form-control" id="branch" placeholder="Enter current password" name="branch" required> -->
                <!-- <input type="text" id="branch_demo"> -->
                <div class="form-group">
                  <label>Branch <a style="color:red;">*</a></label>
                  <?php
                  if($_SESSION['user_group'] == 'MERCHANT GROUP')
                  {
                    ?>
                    <select class="form-control" name="branch" required>
                      <option required value="<?php echo $_SESSION['branch_code']?>"><?php echo $_SESSION['branch_name']; echo "&nbsp (".$_SESSION['branch_code'].")"?></option>
                    </select>
                    <?php
                  }
                  else
                  {
                    if($button == 'Activate' || $button == 'Upgrade Card')
                    { ?>
                      <select class="form-control" name="branch" id="branch" required>

                        <?php if(sizeof($branch) > '1'){ ?>
                        <option hidden selected value> -- Select a branch -- </option>
                        <?php }
                        foreach($branch as $row)
                        {
                          ?>
                            <option required value="<?php echo $row['branch_code']?>"><?php echo $row['branch_name']; echo "&nbsp (".$row['branch_code'].")"?></option>
                          <?php
                        }
                        ?>
                      </select>
                    <?php  } 
                    else
                    { ?>
                      
                      <select class="form-control" name="branch" id="branch" disabled required>
                        <?php
                        foreach($branch as $row)
                        {
                          ?> 
                            <option required value="<?php echo $row['branch_code']?>"><?php echo $row['branch_name']; echo "&nbsp (".$row['branch_code'].")"?></option>
                            <input type="hidden" name="branch_hidden" value="<?php echo $row['branch_code']?>" />
                          <?php
                        }
                        ?>
                      </select>

                    <?php } ?>
                    
                    <?php
                  }
                  ?>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    
                      <label>Expiry Date</label>
                      <input type="text" id="expiry_date" readonly class="form-control" name="expiry_date" 
                      <?php
                      if($actual_expirydate == '3000-12-31')
                      {
                        ?>
                        value="" required
                        <?php
                      }
                      else
                      {
                        ?>
                        value="<?php echo $expiry_date?>" required

                        <?php
                      }
                      ?>>
                      
                      
                  </div>
                  <div class="form-group col-md-6">
                    <?php
                    if($button == 'Renew Card' && $check_receipt_itemcode == 0)
                    {
                      ?>
                      <label>Years <a style="color:red;">*</a></label>
                      <input type="number"  class="form-control" name="years" value="<?php echo $years; ?>" readonly>
                      <?php
                    }
                    ?>

                    <?php
                      if($button == 'Upgrade Card')
                      {
                    ?>
                        <label>Card Type</label>
                        <input type="text" class="form-control" value="<?php echo $cardtype; ?>" readonly>
                    <?php
                      }
                    ?>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <?php
                    if($actual_expirydate == '3000-12-31')
                    {
                      ?>
                        <label>Application Date<a style="color:red;">*</a></label>
                          <input type="date" class="form-control" name="application_date" id="application_date" value="" required>
                      <?php
                    }
                    ?>
                  </div>
                </div>
                
              </div>

            </div>
            <!-- /.col -->
            <div id="result" class="col-md-4" <?php echo $_SESSION['hidden_result']?>>
              <div class="row">
                <?php
                  if($button == 'Upgrade Card' && $upgrade_maintain_card == '0' && $preissue_card_method == '1')
                  {
                ?>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Card No. <a style="color:red;">*</a></label>
                        <input type="text" class="form-control" required name="card_no" required="">
                      </div>
                    </div>
                <?php
                  }
                  else
                  {
                ?>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Card No.</label>
                        <input type="text" class="form-control" value="<?php echo $_SESSION['card_no']?>" required readonly name="card_no">
                      </div>
                    </div>
                <?php
                  }
                ?>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Account No.</label>
                    <input type="text"  name="noto" class="form-control" value="<?php echo $_SESSION['account_no']?>" required readonly name="account_no"/>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Nationality <a style="color:red;">*</a></label>
                <select name="national" class="form-control"  required id="national" onchange="selectNationality(this)" 

                  <?php
                  if($button == 'Renew Card' || $button == 'Upgrade Card')
                  {
                    echo 'disabled';
                  }
                  ?> >

                <option disabled><?php echo $_SESSION['nationality']; ?></option>
                
                  <?php
                  foreach($select_nationality->result() as $row)
                  {
                    ?>

                      <option required value="<?php echo $row->Nationality?>"
                        <?php 
                        if($row->Nationality == $_SESSION['nationality'])
                        {
                          echo "selected";
                        }
                        else if($row->Preset == 1 && $_SESSION['nationality'] == '')
                        { 
                          echo 'selected="selected"';
                        } ?> >
                        <?php echo $row->Nationality;?></option>
                      
                    <?php
                  }
                  ?>
                </select>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group" id="ic_box" style="display: none;">
                    <label>IC No. <a style="color:red;">*</a><small class="help-block">Ex: 880455022200</small></label>
                    <input autocomplete="off" type="text" id="ic_no" class="form-control" name="ic_no" value="<?php echo $_SESSION['ic_no']?>" maxlength="12" onkeyup="checkic()" required placeholder="Ex: 880455022200"
                    
                    <?php
                    if($button == 'Renew Card' || $button == 'Upgrade Card')
                    {
                      echo 'readonly';
                    }
                    ?>>
                    <span id="error_box" style="color: red; display: none;">Invalid IC No.</span>
                  </div>
                  <div class="form-group" id="army_box" style="display: none;">
                    <label>Army Card No. <a style="color:red;">*</a><small class="help-block">Ex: xxxxxxxx</small></label>
                    <input type="text" id="army_no" class="form-control" name="army_no" value="<?php echo $_SESSION['army_no']?>" required placeholder="Ex: xxxxxxxx"
                    <?php
                    if($button == 'Renew Card' || $button == 'Upgrade Card')
                    {
                      echo 'readonly';
                    }
                    ?>>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Mobile No. <a style="color:red;">*</a><small class="help-block">Ex: 0112265222</small></label>
                    <input autocomplete="off" onkeypress="return isNumberKey(event)" type="text" id="mobile_no" class="form-control" value="<?php echo $_SESSION['mobile_no']?>" required placeholder="Ex: 0112265222" name="mobile_no"
                    <?php
                    if($button == 'Renew Card' || $button == 'Upgrade Card')
                    {
                      echo 'readonly';
                    }
                    ?>/>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Old IC No.</label>
                    <input type="text" id="oldicno" class="form-control" name="old_ic_no" value="<?php echo $_SESSION['old_ic_no']?>"
                    <?php
                    if($button == 'Renew Card' || $button == 'Upgrade Card')
                    {
                      echo 'readonly';
                    }
                    ?>>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Passport No. <a style="color:red;">*</a></label>
                    <input id="passno" type="text" class="form-control" value="<?php echo $_SESSION['passport_no']?>" required name="passport_no"
                    <?php
                    if($button == 'Renew Card' || $button == 'Upgrade Card')
                    {
                      echo 'readonly';
                    }
                    ?>/>
                  </div>
                </div>
              </div>

            </div>
           
            
            <div id="result" class="col-md-4" <?php echo $_SESSION['hidden_result']?>>
              
              <div class="form-group">
                <label>Email </label>
                <input name="email" id="email" type="email" class="form-control" value="<?php echo $_SESSION['email']?>" 
                <?php
                if($button == 'Renew Card' || $button == 'Upgrade Card')
                {
                  echo 'readonly';
                }
                ?> />
              </div>
              <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" name="remarks" rows="3" placeholder="Remarks"><?php echo $remarks?>
                </textarea>
              </div>

              <?php
                if($card_verify == '1')
                {
              ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Scan Card No. <a style="color:red;">*</a></label>
                        <input name="confirm_cardno" id="confirm_cardno" type="text" class="form-control" required />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Confirm Card No. <a style="color:red;">*</a></label>
                        <input type="text" name="confirm_password" id="confirm_password" class="form-control" required /> <span id='message'></span>
                  </div>
                </div>
              </div>
              <?php
                }
              ?>

              <?php
                if($this->session->userdata('message_confirm'))
                {
                  echo "<br>";
                   echo $this->session->userdata('message_confirm') <> '' ? $this->session->userdata('message_confirm') : ''; 
                }
                ?>

                <?php if($button == 'Activate')
                { ?>

                  <select name="msglist" id="SelectMsg" size="20" style="display: none;"></select>
                  <button id="idReadMyKAD" type="button" onClick="ReadTest()" class="btn btn-default">Read MyKAD</button>

                <?php } ?>

                <button id="final_submit"  type="submit" class="btn btn-success pull-right" onclick="return checkrequiredfields()"><?php echo $button?></button>
                <!-- onclick="$('#save').submit()" -->

              <?php
              if($_SESSION['account_no'] <> '')
              {
                ?>
                <button style="margin-right: 15px" type="submit" value="edit" id="save_button" name="button" class="btn btn-primary pull-right" onclick="return checkrequiredfields()"
                
                  <?php
                  if(in_array('UM', $_SESSION['module_code']))
                  {
                    echo '';
                  }
                  else
                  {
                    echo 'disabled';
                  }
                  ?>
                  >Edit Details</button>
                <?php
              }
              ?>

              </div>
              <!-- </form> -->
            </div>
          </div>
          <!-- /.row -->
        </div>
        </div>
        </div>
        </div>
        </div>

      </div>
      
    </section>
    <section class="content">
      <section class="content">

      <?php if($button == 'Activate')
      { ?>

        <div class="box box-default" <?php echo $_SESSION['hidden_result']?>>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" id="Name" data-mask class="form-control" name="Name" value="" readonly >
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Name On Card</label>
                  <input type="text" id="NameOnCard" data-mask class="form-control" name="NameOnCard" value="" readonly >
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Birth Date</label>
                  <input type="text" id="Birthdate" data-mask class="form-control" name="Birthdate" value="" readonly >
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>Gender</label>
                  <input type="text" id="Gender" data-mask class="form-control" name="Gender" value="" readonly >
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Race</label>
                  <input type="text" id="Race" data-mask class="form-control" name="Race" value="" readonly >
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Religion</label>
                  <input type="text" id="Religion" maxlength="10" data-mask class="form-control" name="Religion" value="" readonly >
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" id="Address" data-mask class="form-control" name="Address" value="" readonly >
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Postcode</label>
                  <input type="text" id="Postcode" data-mask class="form-control" name="Postcode" value="" readonly >
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>City</label>
                  <input type="text" id="City" data-mask class="form-control" name="City" value="" readonly >
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>State</label>
                  <input type="text" id="State" data-mask class="form-control" name="State" value="" readonly >
                </div>
                <input type="hidden" id="add1" name="add1" >
                <input type="hidden" id="add2" name="add2" >
                <input type="hidden" id="add3" name="add3" >
                <!-- /.form-group -->
                </form>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      <?php } ?>

      </section>
    </section>

    <!-- confirm modal @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@-->
<div class="modal fade" id="delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="text-align: center">Confirm Delete?</h3>
            </div> -->
            <div class="modal-body">
                <h4 class="modal_detail" style="text-align: center"></h4>
            </div>
            <div class="modal-footer" style="text-align: center">
            <span id="preloader-delete"></span>
                <a id="url" href=""><button type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button></a>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End confirm modal modal -->
    <div class="modal fade" id="Clean_Up_Point" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-body">
                  <h3 class="modal_detail" style="text-align: center">This member already expiry more than <?php echo $terminate_expiry_month; ?>.
                    <br>If renew will zeroing member point.
                  </h3>
              </div>
              <div class="modal-footer" style="text-align: center">
                <a href = "<?php echo site_url('Transaction_c/renew?scan_card='.$this->session->userdata('cardno').'&bypass=true'); ?>">
                  <button type="button" class="btn btn-sm btn-primary">Yes</button>
                </a>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">No</button>
              </div>
          </div>
      </div>
    </div>

    <script type="text/javascript">
      function checkrequiredfields() {
        var confirm_cardno = document.getElementById('confirm_cardno').value;
        var confirm_password = document.getElementById('confirm_password').value;
        var branch = document.getElementById('branch').value;
        var mobile_no = document.getElementById('mobile_no').value;
        var application_date = document.getElementById('application_date').value;

        if(confirm_cardno == null || confirm_cardno == '' || confirm_password == null || confirm_password == '' || branch == null || branch == '' || mobile_no == null || mobile_no == '' || application_date == '')
        {
          alert('Please fill in required fields with (*)');
          return false;
        }
      }
    </script>

    <script type="text/javascript">
      function printdetails()
      {
          setTimeout(function() {
            window.open ("<?php echo site_url('Transaction_c/print_details'); ?>?accountno=<?php echo $AccountNo; ?>&cardno=<?php echo $CardNo; ?>", "_blank"); 
          }, 2000);
      }
    </script>

    <script type="text/javascript">
      function checkic()
      {
        var ic_no = document.getElementById('ic_no').value;

        if(isNaN(ic_no))
        {
          document.getElementById('error_box').style.display = 'block';
          document.getElementById('save_button').disabled = true;
          document.getElementById('final_submit').disabled = true;
        }
        else
        {
          document.getElementById('error_box').style.display = 'none';
          document.getElementById('save_button').disabled = false;
          document.getElementById('final_submit').disabled = false;
        }
      }
    </script>

    <script type="text/javascript">
      
    function isNumberKey(evt)
    {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }

    function selectNationality(obj) 
    {
        var select = document.getElementById('national').options[document.getElementById('national').options.selectedIndex].value.toUpperCase();
        if ( select == 'MALAYSIAN' || select == 'MALAYSIA')
        {   
            document.getElementById('ic_box').style.display = 'block';
            document.getElementById('ic_no').disabled = false;
            document.getElementById('oldicno').disabled = false;
            document.getElementById('passno').disabled = true;
            document.getElementById('idReadMyKAD').disabled = false;
            document.getElementById('army_box').style.display = 'none';
            document.getElementById('ic_no').required = true;
            document.getElementById('army_no').required = false;
            document.getElementById('army_no').value = '';
        }
        else if ( (select != 'MALAYSIAN' || select != 'MALAYSIA') && (select == 'MALAYSIAN (ARMY)' || select == 'MALAYSIA (ARMY)') )
        {
            document.getElementById('army_box').style.display = 'block';
            document.getElementById('ic_no').disabled = false;
            document.getElementById('oldicno').disabled = false;
            document.getElementById('passno').disabled = true;
            document.getElementById('idReadMyKAD').disabled = true;
            document.getElementById('ic_box').style.display = 'none';
            document.getElementById('ic_no').required = false;
            document.getElementById('army_no').required = true;
            document.getElementById('ic_no').value = '';
        }
        else if ( select != 'MALAYSIAN' || select != 'MALAYSIA')
        {
            document.getElementById('ic_no').disabled = true;
            document.getElementById('oldicno').disabled = true;
            document.getElementById('passno').disabled = false;
            document.getElementById('idReadMyKAD').disabled = true;
            document.getElementById('ic_box').style.display = 'block';
            document.getElementById('army_box').style.display = 'none';
            document.getElementById('ic_no').required = false;
            document.getElementById('army_no').required = false;
            document.getElementById('ic_no').value = '';
            document.getElementById('army_no').value = '';
        }
    }

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

    /*function confirm_modal(delete_url)
    {
      $('#delete').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

      var modal = $(this)
      modal.find('.modal_detail').text('Confirm delete ' + button.data('name') + '?')
      document.getElementById('url').setAttribute("href" , delete_url );
      });
    }*/

    </script>

    <?php if($button == 'Activate' || $button == 'Upgrade Card')
    { ?>
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
                                      document.getElementById('reason_box').style.display = 'none';
                                      document.getElementById('reason').required = false;
                                    }          
                                     
                               }  
                          });  
                     }  
                });  
           });
      </script>
    <?php }; ?>

    <?php if($button == 'Renew Card')
    { ?>
      <script> 
           $(document).ready(function(){  
                /*id=Current*/
               /* $('#branch').change(function(){  */
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
               /* }); */ 
           });
      </script>
    <?php }; ?>

    <script type="text/javascript">
      function AddItem1(Text)
      {
          var opt = document.createElement("option");
          var n = document.getElementById("SelectMsg").options.length;
          
          document.getElementById("SelectMsg").options.add(opt);
          opt.text = Text;
          document.getElementById("SelectMsg").options[n].selected = true;
      }

      function AddItem(Text)
      {
          var listbox = document.getElementById('SelectMsg');
          var newOption = document.createElement('option'); 
          newOption.value = Text; // The value that this option will have 
          newOption.innerHTML = Text; // The displayed text inside of the <option> tags
          listbox.appendChild(newOption); 
      }

      function ResetList()
      {
          document.getElementById("SelectMsg").options.length = 0;
      }

      function ReadTest()
      {
          res = initMyKAD();
          AddItem("initMyKAD()");

          res = version();
          AddItem("version() " + res);

          res = openReader("ACS ACR38USB 0", "ACS ACR38USBSAM 0");
          AddItem("openReader() " + res);
          
          res = loadMyKAD();
          AddItem("loadMyKAD()" + res);

          // what to read
          setReadHolderName(true);
          setICNo(true);
          setReadOldICNo(true);
          setReadAddress1(true);
          setReadAddress2(true);
          setReadAddress3(true);
          setReadState(true);
          setReadPostCode(true);
          setReadCity(true);
          setReadReligion(true);
          setReadGender(true);
          setReadBirthDate(true);
          setReadBirthPlace(true);
          setReadRace(true);
          setReadCitizenship(true);
          setReadDateIssued(true);
          setReadDateRegistered(true);
          setReadPhoto("C:\\temp\\mykadphoto.bmp");
         
          res = readMyKAD();
          AddItem("readMyKAD()" + res);

          AddItem("=====================================================");
          AddItem("holderName():" + holderName());
          AddItem("icNo():" + icNo());
          AddItem("oldICNo():" + oldICNo());
          AddItem("address1():" + address1());
          AddItem("address2():" + address2());
          AddItem("address3():" + address3());
          AddItem("state():" + state());
          AddItem("postcode():" + postcode());
          AddItem("city():" + city());
          AddItem("religion():" + religion());
          AddItem("gender():" + gender());
          AddItem("birthDate():" + birthDate());
          AddItem("birthPlace():" + birthPlace());
          AddItem("race():" + race());
          AddItem("citizenship():" + citizenship());
          AddItem("dateIssued():" + dateIssued());
          AddItem("dateRegistered():" + dateRegistered());
          AddItem("Photo stored at " + "C:\\temp\\MYKAD-PHOTO.BMP");
          AddItem("=====================================================");
          
          res = unloadMyKAD();
          AddItem("unloadMyKAD()" + res);
          
          res = closeReader();
          AddItem("closeReader() " + res);

          res = freeMyKAD();
          AddItem("freeMyKAD()");

          document.getElementById('ic_no').value = icNo();
          document.getElementById('Name').value = holderName();
          document.getElementById('NameOnCard').value = holderName();
          document.getElementById('Gender').value = gender();
          document.getElementById('Race').value = race();
          document.getElementById('Religion').value = religion();
          document.getElementById('Address').value = address1()+', '+address2()+', '+address3();
          document.getElementById('Postcode').value = postcode();
          document.getElementById('City').value = city();
          document.getElementById('State').value = state();
          document.getElementById('Birthdate').value = birthDate();
          document.getElementById('add1').value = address1();
          document.getElementById('add2').value = address2();
          document.getElementById('add3').value = address3();
          
          alert("Read finished.");
      }
    </script>


    <script>  
     $(document).ready(function(){  
          $('#application_date').change(function(){  
               var application_date = $('#application_date').val();  
               if(application_date != '')  
               {  
                  $.ajax({  
                         url:"<?php echo site_url('Transaction_c/check_expiry_date'); ?>",  
                         method:"POST",  
                         data:{application_date:application_date},  
                         success:function(data)
                         {  
                          document.getElementById('expiry_date').value = data;  
                               
                         }  
                    });  
               }  
          });  
     });  
     </script>  

 
 