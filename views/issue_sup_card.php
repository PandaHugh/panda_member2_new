<style>

#scroll {
  height: 250px;
  overflow-y: scroll;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo base_url('assets/js/mykad.js'); ?>" language="javascript" type="text/javascript"> </script>
<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

</script>
<script src="<?php echo base_url('js/jquery.min.js');?>"></script>
<!--onload Init-->
<body onload="selectNationality(this);">
    
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
    <div id="page-inner">
                    

  <div class="row">
    <div class="col-md-12">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Issue Suplimentary Card </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header ">
          <?php
          if(isset($_REQUEST['created']))
          {
              ?>
              <div class="pull-right" style="margin-right: 10px">     
                <a href="<?php echo site_url('Transaction_c/print_card')?>?print_card&CardNo=<?php echo $_REQUEST['created']?>&redirect=Transaction_c/issue_sup_card?>" title="Print Card" class="print "><i class="btn btn-primary">Print Card</i></a>
              </div>
              <?php
          }
          ?>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
            <form method="post" action="<?php echo site_url('Transaction_c/issue_sup_card'); ?>?scan_card">
              <div class="form-group">
                <label>Main Card Holder No.</label>
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

              <div id="result" <?php echo $_SESSION['hidden_result']?> >
                <!-- /.form-group -->
                <form id='save' method="post" action="<?php echo site_url('Transaction_c/save_sup_card')?>">
                  <div class="form-group" id="receipt_box" style="display: none;">
                    <label>Receipt No. <a style="color:red;">*</a></label>
                    <input type="text" name="receipt_no" class="form-control" placeholder="Scan Receipt No" id="receipt_no" onkeyup="bypass_receipt(this)" required autocomplete="off">
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
                  
                <div class="form-group">
                  <label>Branch <a style="color:red;">*</a></label>
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
                <div class="form-group col-md-6">
                  <label>Expiry Date</label>
                    <input type="text"  class="form-control" name="expiry_date" value="<?php echo $expiry_date?>" readonly>
                </div>
                
                </div>
                
              </div>

            </div>
            <!-- /.col -->
            <div id="result"  <?php echo $_SESSION['hidden_result']?>>

            <div class="col-md-4">
              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Card No. <a style="color:red;">*</a></label>
                  <input type="text" class="form-control" required name="card_no" id="card_no"
                  <?php
                  if($preisse_method == 0)
                  {
                    ?>
                    readonly
                    <?php
                  }
                  ?>

                  <?php
                  if(isset($_REQUEST['created']))
                  {
                    ?>
                    value='<?php echo $_REQUEST['created']?>' style="background-color: #f0f287"
                    <?php
                  }
                  ?>
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Relationship <a style="color:red;">*</a></label>
                  <select name="relation" class="form-control"  required id="relation" onchange="selectNationality(this)">
                    <?php
                    foreach($set_relay->result() as $row)
                    {
                      ?>
                        <option required value="<?php echo $row->Relationship?>"
                          <?php
                          if($row->Preset == 1)
                          {
                            echo 'selected';
                          }
                          ?>><?php echo $row->Relationship;?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              </div>
              <?php 
                if($preissue_card_method == '0')
                {
              ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Name <a style="color:red">*</a></label>
                    <input type="text" class="form-control" placeholder="Name" id="Name" name="Name_Sup" value="<?php
                      if(isset($_REQUEST['name']))
                      {
                        echo $_REQUEST['name'];
                      }
                    ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Name On Card <a style="color:red">*</a></label>
                    <input type="text" class="form-control" placeholder="Name On Card" id="NameOnCard" name="NameOnSupCard" value="<?php
                      if(isset($_REQUEST['nameoncard']))
                      {
                        echo $_REQUEST['nameoncard'];
                      }
                    ?>">
                  </div>
                </div>
              </div>
              <?php
                }
              ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nationality <a style="color:red;">*</a></label>
                    <select class="form-control" id="sup_national" name="select_national" onchange="select_Nationality(this)">
                      <?php
                        foreach($nationality->result() as $row)
                        {
                      ?>
                          <option required value="<?php echo $row->Nationality?>"><?php echo $row->Nationality;?></option>    
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6" id="ic_form">
                  <div class="form-group">
                    <label>IC No. <a style="color:red;">*</a></label>
                    <input autocomplete="off" type="text" class="form-control" name="ic_no" id="ic_no" 
                    <?php
                    if(isset($_REQUEST['created']))
                    {
                      ?>
                      value='<?php echo $get_created->row('ICNo')?>'
                      <?php
                    }
                    else
                    {
                      ?>
                      value=""  
                      <?php
                    }
                    ?>
                     maxlength="12" onkeyup="checkic()" placeholder="Ex: 880455022200">
                    <span id="error_box" style="color: red; display: none;">Invalid IC No.</span>
                  </div>
                </div>
                <div class="col-md-6" id="passport_form" style="display: none;">
                  <div class="form-group">
                    <label>Passport No. <a style="color:red;">*</a></label>
                    <input id="passno" type="text" class="form-control" name="passport_no"/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Mobile No. <a style="color:red;">*</a><small class="help-block">Ex: 0112265222</small></label>
                    <input autocomplete="off" type="text" class="form-control" required name="mobile_no" id="mobile_no" placeholder="Ex: 0112265222" 
                    <?php
                    if(isset($_REQUEST['created']))
                    {
                      ?>
                      value='<?php echo $get_created->row('Phonemobile')?>'
                      <?php
                    }
                    else
                    {
                      ?>
                      value=""  
                      <?php
                    }
                    ?>/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Email <small class="help-block">Ex: abc@hotmail.com</small></label>
                    <input autocomplete="off" name="email" id="email" type="email" class="form-control" placeholder="Email"
                    <?php
                      if(isset($_REQUEST['created']))
                      {
                        ?>
                        value='<?php echo $get_created->row('email')?>'
                        <?php
                      }
                      ?>/>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" name="remarks" rows="4" placeholder="Remarks">
                  <?php
                  if(isset($_REQUEST['created']))
                  {
                  
                    echo $get_created->row('Remarks');
                    
                  }
                  ?>
                </textarea>
              </div>

            </div>

            <div class="col-md-4">
              
              <div class="row">
              <center><b>Main Card Details</b></center>
              <br>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Account No.</label>
                  <input type="text"  name="noto" class="form-control" value="<?php echo $_SESSION['account_no']?>" readonly />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Card No.</label>
                  <input readonly type="text" class="form-control" value="<?php echo $_SESSION['card_no']?>" required >
                </div>
              </div>
              </div>

              <div class="row">
              <input type="hidden" name="national" id="national" value="<?php echo $_SESSION['Nationality']; ?>">
              <div class="col-md-6">
                <div class="form-group" id="ic_box" style="display: none;">
                  <label>IC No.</label>
                  <input readonly type="text" class="form-control"  value="<?php echo $ic_no?>" required>
                </div>
                <div class="form-group" id="army_box" style="display: none;">
                  <label>Army Card No.</label>
                  <input readonly type="text" class="form-control"  value="<?php echo $ic_no?>" required>
                </div>
                <div class="form-group" id="passport_box" style="display: none;">
                  <label>Passport No.</label>
                  <input readonly type="text" class="form-control"  value="<?php echo $passport_no?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Mobile No.</label>
                  <input readonly type="text" class="form-control" value="<?php echo $mobile_no?>" required />
                </div>
              </div>
              </div>

              <div class="form-group">
                  <label>Name</label>
                  <input type="text" readonly class="form-control" required value="<?php echo $name?>">
              </div>

              <?php
                if($card_verify == '1')
                {
              ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Scan Card No. <a style="color:red;">*</a></label>
                        <input name="confirm_cardno" id="confirm_cardno" type="text" class="form-control" required 
                        <?php
                  if($preisse_method == 0)
                  {
                    ?>
                    readonly
                    <?php
                  }
                  ?>/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Confirm Card No. <a style="color:red;">*</a></label>
                        <input type="text" name="confirm_password" id="confirm_password" class="form-control" required
                        <?php
                  if($preisse_method == 0)
                  {
                    ?>
                    readonly
                    <?php
                  }
                  ?>/> <span id='message'></span>
                  </div>
                </div>
              </div>
              <?php
                }
              ?>
            <select name="msglist" id="SelectMsg" size="20" style="display: none;"></select>
            <button id="idReadMyKAD" type="button" onClick="ReadTest()" class="btn btn-default">Read MyKAD</button>
            <button 
            <?php
            if(isset($_REQUEST['created']))
            {
              ?>
              disabled
              <?php
            }
            ?> type="submit" class="btn btn-success pull-right" id="save_button" onclick="return checkrequiredfields()">Save</button> <!-- onclick="$('#save').submit()" -->

            </div>


            <!-- </form> -->
            
            </div>

          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <!-- <div class="box box-default">
        
        <div class="box">
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Branch</th>
                <th>Prefix</th>
                <th>From</th>
                <th>To</th>
                <th>Remarks</th>
                <th>Created by</th>
                <th>Created at</th>
                <th>Updated by</th>
                <th>Updated at</th>
              </tr>
              </thead>
              <tbody>

                
                
            </table>
          </div>
          
        </div>
        
      </div> -->
      
    </section>
    <section class="content">
      <!-- <section class="content"> -->

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
                  <label>Birthdate</label>
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
                  <input type="text" id="Religion" data-mask class="form-control" name="Religion" value="" readonly >
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

      <!-- </section> -->
    </section>

<script type="text/javascript">
  function selectNationality(obj) 
    {
        var select = document.getElementById('national').value.toUpperCase();

        if ( select == 'MALAYSIAN' || select == 'MALAYSIA')
        {   
            document.getElementById('ic_box').style.display = 'block';
            document.getElementById('army_box').style.display = 'none';
            document.getElementById('passport_box').style.display = 'none';
        }
        else if ( (select != 'MALAYSIAN' || select != 'MALAYSIA') && (select == 'MALAYSIAN (ARMY)' || select == 'MALAYSIA (ARMY)') )
        {
            document.getElementById('ic_box').style.display = 'none';
            document.getElementById('army_box').style.display = 'block';
            document.getElementById('passport_box').style.display = 'none';
        }
        else if ( select != 'MALAYSIAN' || select != 'MALAYSIA')
        {
            document.getElementById('ic_box').style.display = 'none';
            document.getElementById('army_box').style.display = 'none';
            document.getElementById('passport_box').style.display = 'block';
        }
    }

    function select_Nationality(obj) 
    {
        var select = document.getElementById('sup_national').value.toUpperCase();
        document.getElementById('ic_no').value = "";
        document.getElementById('passno').value = "";

        if ( select == 'MALAYSIAN' || select == 'MALAYSIA')
        {   
            document.getElementById('ic_form').style.display = 'block';
            document.getElementById('passport_form').style.display = 'none';
            document.getElementById('ic_no').required = true;
            document.getElementById('passno').required = false;
        }
        else if ( (select != 'MALAYSIAN' || select != 'MALAYSIA') && (select == 'MALAYSIAN (ARMY)' || select == 'MALAYSIA (ARMY)') )
        {
            document.getElementById('ic_form').style.display = 'block';
            document.getElementById('passport_form').style.display = 'none';
            document.getElementById('ic_no').required = true;
            document.getElementById('passno').required = false;
        }
        else if ( select != 'MALAYSIAN' || select != 'MALAYSIA')
        {
            document.getElementById('ic_form').style.display = 'none';
            document.getElementById('passport_form').style.display = 'block';
            document.getElementById('ic_no').required = false;
            document.getElementById('passno').required = true;
        }
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
    }
    else
    {
      document.getElementById('error_box').style.display = 'none';
      document.getElementById('save_button').disabled = false;
    }
  }
</script>

<?php 
if($preisse_method == 0)
{
  ?>
    <script type="text/javascript">
      function checkrequiredfields() {
        var branch = document.getElementById('branch').value;
        var mobile_no = document.getElementById('mobile_no').value;
        var relation = document.getElementById('relation').value;

        if(branch == null || branch == '' || mobile_no == null || mobile_no == '' || relation == null || relation == '')
        {
          alert('Please fill in required fields with (*)');
          return false;
        }
      }
    </script>
  <?php
}
else
{
  ?>
  <script type="text/javascript">
      function checkrequiredfields() {
        var confirm_cardno = document.getElementById('confirm_cardno').value;
        var confirm_password = document.getElementById('confirm_password').value;
        var branch = document.getElementById('branch').value;
        var mobile_no = document.getElementById('mobile_no').value;
        var card_no = document.getElementById('card_no').value;
        var relation = document.getElementById('relation').value;

        if(confirm_cardno == null || confirm_cardno == '' || confirm_password == null || confirm_password == '' || branch == null || branch == '' || mobile_no == null || mobile_no == '' || card_no == null || card_no == '' || relation == null || relation == '')
        {
          alert('Please fill in required fields with (*)');
          return false;
        }
      }
    </script>
  <?php
}
?>

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
      setReadPhoto("C:\\temp\\MYKAD-PHOTO.BMP");
     
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
      document.getElementById('Birthdate').value = birthDate();
      document.getElementById('Gender').value = gender();
      document.getElementById('Race').value = race();
      document.getElementById('Religion').value = religion();
      document.getElementById('Address').value = address1()+', '+address2()+', '+address3();
      document.getElementById('Postcode').value = postcode();
      document.getElementById('City').value = city();
      document.getElementById('State').value = state();
      document.getElementById('add1').value = address1();
      document.getElementById('add2').value = address2();
      document.getElementById('add3').value = address3();
      
      alert("Read finished.");
  }
</script>
