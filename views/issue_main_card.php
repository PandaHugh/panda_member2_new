<?php 
'session_start()' 
?>


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
    <div class="box">
            <!-- /.box-header -->
    <div class="box-body">

    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
            <div id="page-inner">
            

            <?php
            if($this->session->userdata('message'))
            {
               echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
            }
            ?>
                    
              <div class="row">
                <div class="col-md-12">

                    <!-- <h1 class="page-head-line">
                        <a href="<?php echo site_url('main_c')?>" class="btn btn-default btn-xs"  style="float:right;" >
                          <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
                    </h1> -->
                        <!--<h1 class="page-subhead-line"></h1>-->
                  </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                    <form class="" name="myForm" action="<?php echo $direction?>" method="post" id="target">
                    <div class="box-header ">
                      <h1 class="box-title"><?php echo $page_title?>
                      </h1>

                        <?php
                        if(isset($_REQUEST['created']))
                        {
                            ?>
                            <div class="pull-right" style="margin-right: 10px">      
                              <a href="<?php echo site_url('Transaction_c/print_details')?>?AccountNo=<?php echo $AccountNo?>&CardNo=<?php echo $CardNo?>" target="_blank" title="Print Form" class="print "><i class="btn btn-primary">Print Details</i></a>
                              </div>

                              <div class="pull-right" style="margin-right: 10px">      
                              <a href="<?php echo site_url('Transaction_c/issue_main_card')?>" title="Create New" class=""><i class="btn btn-success">Create New</i></a>

                              <a href="<?php echo site_url('Transaction_c/print_card')?>?print_card&AccountNo=<?php echo $AccountNo?>&redirect=Transaction_c/issue_main_card?created=<?php echo $AccountNo?>" title="Print Card" class="print "><i class="btn btn-primary">Print Card</i></a>
                              </div>
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <button type="submit" value="submit"  class="btn btn-success pull-right" ><?php echo $button?></button>
                            <?php
                        }
                        ?>
                          
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            
                        <select name="msglist" id="SelectMsg" size="20" style="display: none;"></select>
                                <button id="idReadMyKAD" type="button" onClick="ReadTest()" class="btn btn-default" style="float: right;">Read MyKAD</button>
                        </div>
                      <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Personal Details</h5></center>
                        <input type="hidden" name="AccountNo" value="<?php echo $AccountNo?>">

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Branch </label>
                                <?php if(isset($_REQUEST['created']))
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                        <input type="text" name="branch_select" class="form-control " value="<?php echo $branch_select?>">
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
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
                                    <?php
                                }
                                ?>

                            </div>

                            <div class="form-group" id="receipt_box" style="display: none;">
                              <label class="col-sm-2 control-label">Receipt No. <a style="color:red;">*</a></label>
                                <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                    <input type="text" name="receipt_no" class="form-control to_watch" placeholder="Scan Receipt No" id="receipt_no" onkeyup="bypass_receipt(this)">
                                </div>
                            </div>
                            
                            <div class="form-group" id="reason_box" style="display: none;">
                              <label class="col-sm-2 control-label">Reason<a style="color:red;">*</a></label>
                              <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                <select name="reason" class="form-control" id="reason" onchange="">
                                    <option hidden selected value> -- Select a reason -- </option>

                                  <?php
                                  foreach($reason->result() as $row)
                                  { ?>

                                      <option required value="<?php echo $row->reason?>"><?php echo $row->reason;?></option>

                                  <?php } ?>

                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Card Type </label>
                                <?php if(isset($_REQUEST['created']))
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                        <input type="text" name="branch_select" class="form-control " value="<?php echo $Cardtype?>">
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                        <select name="Cardtype" id="Cardtype" class="form-control">
                                            <option selected data-default style="display: none; " ><?php echo $Cardtype?></option>
                                            <?php 
                                            foreach ($set_cardtype->result() as $row)
                                                {
                                                    ?>
                                                    <option value="<?php echo $row->CardType?>"><?php echo $row->CardType?></option>
                                                    <?php
                                                }
                                            ?>     
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nationality</label>
                                <?php if(isset($_REQUEST['created']))
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                        <input type="text" name="branch_select" class="form-control " value="<?php echo $Nationality?>">
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-sm-10">
                                    <select name="national" class="form-control"  required id="national" onchange="selectNationality(this)" >
                                    
                                      <?php
                                      foreach($set_nationality->result() as $row)
                                      {
                                        ?>
                                          <option required value="<?php echo $row->Nationality?>" >
                                            <?php echo $row->Nationality;?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="form-group" id="ic_box" style="display: none;">
                                <label for="varchar" class="col-sm-2 control-label">IC No</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" id="ic_no" class="form-control" name="ic_no" value="<?php echo $ICNo?>" maxlength="12" onkeyup="checkic()" onfocusout="auto_generate_birthdate()" required placeholder="Ex: 880455022200" />
                                    <span id="error_box" style="color: red; display: none;">Invalid IC No.</span>
                                </div>
                            </div>

                            <div class="form-group" id="old_ic_box" style="display: none;">
                                <label for="varchar" class="col-sm-2 control-label">Old IC No.</label>
                                <div class="col-sm-10">
                                <input autocomplete="off" type="text" id="oldicno" class="form-control" name="old_ic_no" value="" >
                                </div>
                            </div>


                            <div class="form-group" id="army_box" style="display: none;">
                                <label for="varchar" class="col-sm-2 control-label">Army Card No.</label>
                                <div class="col-sm-10">
                                    <input type="text" id="army_no" class="form-control" required name="army_no" value=""  placeholder="Ex: xxxxxxxx"  />
                                </div>
                            </div>

                            <div class="form-group" id="passno_box" style="display: none;">
                                <label class="col-sm-2 control-label">Passport No. </label>
                                <div class="col-sm-10">
                                <input id="passno" type="text" class="form-control" value="" required  name="passport_no"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Title </label>
                                <?php if(isset($_REQUEST['created']))
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                        <input type="text" name="branch_select" class="form-control " value="<?php echo $Title?>">
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-sm-10">
                                        <select name="Title" id="Title" class="form-control">
                                            <option selected data-default style="display: none; " ><?php echo $Title?></option>
                                            <?php 
                                            foreach ($set_title->result() as $row)
                                                {
                                                    ?>
                                                    <option value="<?php echo $row->Title?>"><?php echo $row->Title?></option>
                                                    <?php
                                                }
                                            ?>     
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10"><?php echo form_error('Name') ?>
                                    <input autocomplete="off" onkeyup="autopopulate()" type="text" class="form-control" name="Name" id="Name" placeholder="Name" value="<?php echo $Name?>" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Name On Card </label>
                                <div class="col-sm-10"><?php echo form_error('NameOnCard') ?>
                                    <input type="text" autocomplete="off" class="form-control" name="NameOnCard" id="NameOnCard" placeholder="Name On Card" value="<?php echo $NameOnCard ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Birthday Date </label>
                                <div class="col-sm-10"><?php echo form_error('Birthdate') ?>
                                    <input type="date" class="form-control" name="Birthdate" id="Birthdate" placeholder="Birthday Date" value="<?php echo $Birthdate ?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Gender </label>
                                <?php if(isset($_REQUEST['created']))
                                {
                                    ?>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control " value="<?php echo $Gender?>">
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Gender') ?>
                                        <select name="Gender" id="Gender" class="form-control">
                                            <option selected data-default style="display: none; " ><?php echo $Gender?></option>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Race </label>
                                <?php if(isset($_REQUEST['created']))
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                        <input type="text" class="form-control"  value="<?php echo $Race?>">
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Race') ?>
                                        <select name="Race" id="Race" class="form-control">
                                            <option id="Race" selected data-default style="display: none; " ><?php echo $Race?></option>
                                            <?php 
                                            foreach ($set_race->result() as $row)
                                                {
                                                    ?>
                                                    <option value="<?php echo $row->Race?>"><?php echo $row->Race?></option>
                                                    <?php
                                                }
                                            ?>     
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Religion </label>
                                <?php if(isset($_REQUEST['created']))
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                        <input type="text" class="form-control " value="<?php echo $Religion?>">
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Religion') ?>
                                        <select name="Religion" id="Religion" class="form-control">
                                            <option selected data-default style="display: none; " ><?php echo $Religion?></option>
                                            <?php 
                                            foreach ($set_religion->result() as $row)
                                                {
                                                    ?>
                                                    <option value="<?php echo $row->Religion?>"><?php echo $row->Religion?></option>
                                                    <?php
                                                }
                                            ?>     
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Status </label>
                                <?php if(isset($_REQUEST['created']))
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                        <input type="text" class="form-control " value="<?php echo $Status?>">
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Status') ?>
                                        <select name="Status" id="Status" class="form-control">
                                            <option selected data-default style="display: none; " ><?php echo $Status?></option>
                                            <?php 
                                            foreach ($set_status->result() as $row)
                                                {
                                                    ?>
                                                    <option value="<?php echo $row->Status?>"><?php echo $row->Status?></option>
                                                    <?php
                                                }
                                            ?>     
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Occupation </label>
                                <?php if(isset($_REQUEST['created']))
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                        <input type="text"  class="form-control " value="<?php echo $Occupation?>">
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="col-sm-10"><?php echo form_error('Occupation') ?>
                                        <select name="Occupation" id="Occupation" class="form-control">
                                            <option selected data-default style="display: none; " ><?php echo $Occupation?></option>
                                            <?php 
                                            foreach ($set_occupation->result() as $row)
                                                {
                                                    ?>
                                                    <option value="<?php echo $row->Occupation?>"><?php echo $row->Occupation?></option>
                                                    <?php
                                                }
                                            ?>     
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        
                    </div>
                    <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Contact Details</h5></center>
                            <div class="form-group"> 
                                <label for="inputEmail3" class="col-sm-2 control-label">Email </label>
                                <div class="col-sm-10"><?php echo form_error('Email') ?>
                                    <input type="email" autocomplete="off" class="form-control" name="Email" id="Email" placeholder="Email" value="<?php echo $Email?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                 
                                <label for="inputPassword3" class="col-sm-2 control-label">Mobile No</label>
                                <div class="col-sm-10"><?php echo form_error('Phonemobile') ?>
                                    <input type="number" required autocomplete="off" maxlength="12" class="form-control" name="Phonemobile" id="Phonemobile" placeholder="Mobile No" value="<?php echo $Phonemobile?>" />
                                </div>
                            </div>
                            <div class="form-group"> 
                                <label for="inputEmail3" class="col-sm-2 control-label">Telno Office</label>
                                <div class="col-sm-10"><?php echo form_error('Phoneoffice') ?>
                                    <input type="number" autocomplete="off" class="form-control" name="Phoneoffice" id="Phoneoffice" placeholder="Telno Office" value="<?php echo $Phoneoffice?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                 
                                <label for="inputPassword3" class="col-sm-2 control-label">Telno Home </label>
                                <div class="col-sm-10"><?php echo form_error('Phonehome') ?>
                                    <input type="number" autocomplete="off" class="form-control" name="Phonehome" id="Phonehome" placeholder="Telno Home" value="<?php echo $Phonehome?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Fax No </label>
                                <div class="col-sm-10"><?php echo form_error('Fax') ?>
                                    <input type="number" autocomplete="off" class="form-control" name="Fax" id="Fax" placeholder="Fax No" value="<?php echo $Fax?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Address 1</label>
                                <div class="col-sm-10"><?php echo form_error('Address1') ?>
                                    <input type="text" autocomplete="off" class="form-control" name="Address1" id="Address1" placeholder="Address 1" value="<?php echo $Address1?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Address 2</label>
                                <div class="col-sm-10"><?php echo form_error('Address2') ?>
                                    <input type="text" autocomplete="off" class="form-control" name="Address2" id="Address2" placeholder="Address 2" value="<?php echo $Address2?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Address 3</label>
                                <div class="col-sm-10"><?php echo form_error('Address3') ?>
                                    <input type="text" autocomplete="off" class="form-control" name="Address3" id="Address3" placeholder="Address 3" value="<?php echo $Address3?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Post Code</label>
                                <div class="col-sm-10"><?php echo form_error('Postcode') ?>
                                    <input type="number" autocomplete="off" class="form-control" name="Postcode" id="Postcode" placeholder="Post Code" value="<?php echo $Postcode?>" onchange="postalcode(this)"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">City</label>
                                <div class="col-sm-10"><?php echo form_error('City') ?>
                                    <input type="text" autocomplete="off" class="form-control" id="City" name="City" placeholder="City" value="<?php echo $City?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">State</label>
                                <div class="col-sm-10"><?php echo form_error('State') ?>
                                    <input type="text" autocomplete="off" class="form-control" id="State" name="State" id="acc_country" placeholder="State" value="<?php echo $State?>" />
                                </div>
                            </div>
                        
                    </div>

                    <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Account Details</h5></center>
                            <div class="form-group"> 
                                <label for="inputEmail3" class="col-sm-2 control-label">Account No</label>
                                <div class="col-sm-10"><?php echo form_error('AccountNo') ?>
                                    <input <?php echo $decision?> type="text" class="form-control" name="AccountNo" id="AccountNo" placeholder="Account No" value="<?php echo $AccountNo?>" readonly
                                    <?php if(isset($_REQUEST['created'])){ echo 'style="background-color: #f0f287"';}?> />
                                </div>
                            </div>

                            <div class="form-group"> 
                                <label for="inputPassword3" class="col-sm-2 control-label">Card No</label>
                                <div class="col-sm-10"><?php echo form_error('CardNo') ?>
                                    <input <?php echo $decision?> type="text" class="form-control" name="CardNo" id="CardNo" placeholder="Card No" value="<?php echo $CardNo?>" readonly
                                    <?php if(isset($_REQUEST['created'])){ echo 'style="background-color: #f0f287"';}?> />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Expiry Date </label>
                                <div class="col-sm-10"><?php echo form_error('Expirydate') ?>
                                    <input type="date" class="form-control" name="Expirydate" id="Expirydate" placeholder="Expiry Date" value="<?php echo $Expirydate?>" required readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Issue Date </label>
                                <div class="col-sm-10"><?php echo form_error('Issuedate') ?>
                                    <input type="date" class="form-control" name="Issuedate" id="Issuedate" placeholder="Acc Country" value="<?php echo $Issuedate?>" required readonly/>
                                </div>
                            </div>

                    </div>
                     
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-right">
                        <?php
                        if(!isset($_REQUEST['created']))
                        {
                        ?>
                            <button type="submit" class="btn btn-success" value="submit" ><?php echo $button?></button> 
                        <?php
                        }
                        ?>
                    </form>

                  </div>
                  <!-- /.box -->

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

<?php
if(isset($_REQUEST['created']))
{
?>
<script type="text/javascript">
    $("#target input").prop("readonly", true);
    $("#target select").prop("readonly", true);
</script>
<?php
}
?>

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
        /*$(document).ready(function(){  */

            /*$('.checking').keyup(function(){*/
                
            /*});*/  
        /*}); */ 

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
        //document.getElementById('Gender').value = gender();
        document.getElementById('Race').value = race();
        document.getElementById('Religion').value = religion();
        //document.getElementById('Address1').value = address1()+', '+address2()+', '+address3();
        document.getElementById('Postcode').value = postcode();
        document.getElementById('City').value = city();
        document.getElementById('State').value = state();
        document.getElementById('Address1').value = address1();
        document.getElementById('Address2').value = address2();
        document.getElementById('Address3').value = address3();

        if(gender() == 'L')
        {
            document.getElementById('Gender').value = 'MALE';
        }

        if(gender() == 'P')
        {
            document.getElementById('Gender').value = 'FEMALE';
        }

        var output = icNo();
        var field = 'ICNo';
        
         var AccountNo = "<?php echo $AccountNo; ?>";
        
         /*if(ICNo != '' || PassportNo != '' || Email != '')*/ 
         if(output != '') 
         {  
            $.ajax({  
                    /*ajax: go into controller as shown below*/
                   url:"<?php echo site_url('Main_c/check_duplicates'); ?>",  
                   method:"POST", 
                   data:{output:output, AccountNo:AccountNo, field:field}, 
                   /*data:{branch:branch, field:field}, */
                   success:function(data){  
                        /*get echo data from controller*/
                      if(data != 0)
                        {
                            //document.getElementById('demo').innerHTML = data;
                            document.getElementById('update_button').disabled = true;
                            document.getElementById('error').innerHTML = data;
                            document.getElementById('error_box').style.display = 'none';
                            //document.getElementById('error').style.display = 'block';
                            return false;
                            
                            //document.getElementById('receipt_no').required = true;
                        }
                        else
                        {
                            document.getElementById('update_button').disabled = false;
                            document.getElementById('error').innerHTML = '';
                            document.getElementById('error_box').style.display = 'none';
                        }
                        
                   }  
              });  
         } 
        
        alert("Read finished.");
    }

</script>


<script type="text/javascript">
    
    // monitor name field to make auto complete cardname
    function autopopulate() 
    {
        var x = document.getElementById("Name").value;
        document.getElementById("NameOnCard").value =  x;
    }

    // monitor receipt no field to by pass
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

    // monitor nationality to decide which ic field can appear
    function selectNationality(obj) 
    {
        var select = document.getElementById('national').options[document.getElementById('national').options.selectedIndex].value.toUpperCase();
        
        if ( select == 'MALAYSIAN' || select == 'MALAYSIA')
        {   
            document.getElementById('old_ic_box').style.display = 'block';
            document.getElementById('ic_box').style.display = 'block';
            document.getElementById('passno_box').style.display = 'none';
            document.getElementById('ic_no').disabled = false;
            document.getElementById('oldicno').disabled = false;
            document.getElementById('passno').disabled = true;
            document.getElementById('army_no').disabled = true;
            document.getElementById('idReadMyKAD').disabled = false;
            document.getElementById('army_box').style.display = 'none';
            document.getElementById('ic_no').required = true;
            document.getElementById('passno').required = false;
            document.getElementById('army_no').value = '';
        }
        else if ( select == 'MALAYSIAN (ARMY)' || select == 'MALAYSIA (ARMY)' )
        {
            document.getElementById('army_box').style.display = 'block';
            document.getElementById('ic_box').style.display = 'none';
            document.getElementById('old_ic_box').style.display = 'none';
            document.getElementById('army_no').disabled = false;
            document.getElementById('ic_no').disabled = true;
            document.getElementById('oldicno').disabled = true;
            document.getElementById('passno').disabled = true;
            document.getElementById('idReadMyKAD').disabled = true;
            document.getElementById('ic_box').style.display = 'none';
            document.getElementById('ic_no').required = false;
            document.getElementById('army_no').attr('required', 'true');
            document.getElementById('ic_no').value = '';
           
        }
        else if ( select != 'MALAYSIAN' || select != 'MALAYSIA')
        {
            document.getElementById('army_box').style.display = 'none';
            document.getElementById('passno_box').style.display = 'block';
            document.getElementById('ic_no').disabled = true;
            document.getElementById('oldicno').disabled = true;
            document.getElementById('passno').disabled = false;
            document.getElementById('army_no').disabled = true;
            document.getElementById('idReadMyKAD').disabled = true;
            document.getElementById('ic_box').style.display = 'block';
            document.getElementById('ic_no').required = false;
            document.getElementById('army_no').required = false;
            document.getElementById('ic_no').value = '';
            document.getElementById('army_no').value = '';
        }
    }


    // valid ic no characrter checking
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

    function auto_generate_birthdate()
    {
        var ic_no = document.getElementById('ic_no').value;

        if(!isNaN(ic_no) && ic_no.length >= 6)
        {
            curyear = new Date().getFullYear().toString();

            if(curyear.substring(2,4) > ic_no.substring(0,2))
            {
                birthdate_year = curyear.substring(0, 2);
            }
            else
            {
                birthdate_year = curyear.substring(0, 2) - 1; 
            }

            document.getElementById('Birthdate').value = birthdate_year + ic_no.substring(0,2) + '-' + ic_no.substring(2,4) + '-' + ic_no.substring(4,6);
        }
    }

</script>

<!-- trigger when branch was select and direct to check require receiptno o not -->
<script> 
           $(document).ready(function(){  
                /*id=Current*/
                $('#branch').change(function(){  
                     var branch = $('#branch').val();
                     /*var field = 'receipt_activate';*/   
                     var field = "receipt_activate";

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


    