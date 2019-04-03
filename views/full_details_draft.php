<?php 
'session_start()' 
?>

<script src="<?php echo base_url('js/jquery.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/mykad.js'); ?>" language="javascript" type="text/javascript"> </script>

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

<script language="javascript" type="text/javascript">

function checkForm(f)
{
    var postcodeDefault = "Post Code";
    if( f.Postcode.value == '' || f.Postcode.value == postcodeDefault )
    {
        f.Postcode.value = postcodeDefault;
        return false;
    }
    else
    { 
        return true; 
    }
}

/*onload = function()
{
  checkForm(document.forms.barcodeForm);
}*/

</script>

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
            

            <?php
            if($this->session->userdata('message'))
            {
               echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
            }
            ?>
                    
              <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('login_c/update_card')?>" class="btn btn-default btn-xs"  style="float:right;" >
                          <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                  </div>
              </div>

              <div class="row">
                <div class="col-md-12">

                    <div class="box-header with-border text-left">
                      <h3 class="box-title"><?php echo $page_title?></h3>
                    </div>
                    <!-- /.box-header -->
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <select name="msglist" id="SelectMsg" size="20" style="display: none;"></select>
                            <button id="idReadMyKAD" type="button" onClick="ReadTest()" style="float: right;">READ MyKAD</button>
                        </div>
                    </div>
                    <div class="box-body">

                      <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Personal Details</h5></center>
                        <form class="" role="form" action="<?php echo site_url('Login_c/update_full_details'); ?>" method="post">
                        <input type="hidden" name="AccountNo" value="<?php echo $AccountNo?>">
                            <div class="form-group"> 
                                <label for="varchar" class="col-sm-2 control-label">Nationality</label>
                                <div class="col-sm-10"><?php echo form_error('Nationality') ?>
                                    <select name="Nationality" id="Nationality" class="form-control" id="national" onchange="selectNationality(this)" required>
                                        <option selected data-default style="display: none; " ><?php echo $Nationality?></option>
                                        <?php 
                                        foreach ($set_nationality->result() as $row)
                                            {
                                                ?>
                                                <option 
                                                <?php
                                                if($row->Preset == 1 && $row->Preset == '')
                                                {
                                                    echo "selected";
                                                } 
                                                ?> value="<?php echo $row->Nationality?>"><?php echo $row->Nationality?></option>
                                                <?php
                                            }
                                        ?>     
                                    </select>
                                </div>
                            </div>

                            

                                <div class="form-group">
                                   <label for="varchar" class="col-sm-2 control-label">IC No</label>
                                    <div class="col-sm-10"><?php echo form_error('ICNo') ?>
                                        <input type="text" data-inputmask='"mask": "999999-99-9999"' class="form-control" name="ICNo" id="ICNo" placeholder="Identity Card No" value="<?php echo $ICNo?>" 
                                    
                                        <?php if(strtoupper($Nationality) != 'MALAYSIAN' || strtoupper($Nationality) != 'MALAYSIA')
                                        { 
                                            echo "disabled";
                                        } 
                                        ?>/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="varchar" class="col-sm-2 control-label">Passport No</label>
                                    <div class="col-sm-10"><?php echo form_error('PassportNo') ?>
                                        <input type="text" class="form-control" name="PassportNo" id="PassportNo" placeholder="Passport No" value="<?php echo $PassportNo?>" 
                                        <?php
                                        if(strtoupper($Nationality) == "MALAYSIAN" || strtoupper($Nationality) == "MALAYSIA")
                                        {
                                            echo "disabled";
                                        }
                                        ?>/>
                                    </div>
                                </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Title </label>
                                <div class="col-sm-10"><?php echo form_error('Title') ?>
                                    <select name="Title" id="Title" class="form-control">
                                        <option selected data-default style="display: none; " ><?php echo $Title?></option>
                                        <?php 
                                        foreach ($set_title->result() as $row)
                                            {
                                                ?>
                                                <option
                                                <?php
                                                if($row->Preset == 1 && $Title == '')
                                                {
                                                    echo "selected";
                                                } 
                                                ?> value="<?php echo $row->Title?>"><?php echo $row->Title?></option>
                                                <?php
                                            }
                                        ?>     
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10"><?php echo form_error('Name') ?>
                                    <input type="text" class="form-control" name="Name" id="Name" placeholder="Name" value="<?php echo $Name?>" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Name On Card </label>
                                <div class="col-sm-10"><?php echo form_error('NameOnCard') ?>
                                    <input type="text" class="form-control" name="NameOnCard" id="NameOnCard" placeholder="Name On Card" value="<?php echo $NameOnCard ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Birthday Date </label>
                                <div class="col-sm-10"><?php echo form_error('Birthdate') ?>
                                    <input type="text" class="form-control" name="Birthdate" id="Birthdate" placeholder="Birthday Date" value="<?php echo $Birthdate ?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Gender </label>
                                <div class="col-sm-10"><?php echo form_error('Gender') ?>
                                    <input type="test" class="form-control" name="Gender" id="Gender" placeholder="Gender" value="<?php echo $Gender ?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Race </label>
                                <div class="col-sm-10"><?php echo form_error('Race') ?>
                                    <input type="test" class="form-control" name="Race" id="Race" placeholder="Race" value="<?php echo $Race ?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Religion </label>
                                <div class="col-sm-10"><?php echo form_error('Religion') ?>
                                    <input type="test" class="form-control" name="Religion" id="Religion" placeholder="Religion" value="<?php echo $Religion ?>" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Status </label>
                                <div class="col-sm-10"><?php echo form_error('Status') ?>
                                    <select name="Status" id="Status" class="form-control">
                                        <option selected data-default style="display: none; " ><?php echo $Status?></option>
                                        <?php 
                                        foreach ($set_status->result() as $row)
                                            {
                                                ?>
                                                <option
                                                <?php
                                                if($row->Preset == 1 && $Status == '')
                                                {
                                                    echo "selected";
                                                } 
                                                ?> value="<?php echo $row->Status?>"><?php echo $row->Status?></option>
                                                <?php
                                            }
                                        ?>     
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Occupation </label>
                                <div class="col-sm-10"><?php echo form_error('Occupation') ?>
                                    <select name="Occupation" id="Occupation" class="form-control">
                                        <option selected data-default style="display: none; " ><?php echo $Occupation?></option>
                                        <?php 
                                        foreach ($set_occupation->result() as $row)
                                            {
                                                ?>
                                                <option
                                                <?php
                                                if($row->Preset == 1 && $Occupation == '')
                                                {
                                                    echo "selected";
                                                } 
                                                ?> value="<?php echo $row->Occupation?>"><?php echo $row->Occupation?></option>
                                                <?php
                                            }
                                        ?>     
                                    </select>
                                </div>
                            </div>
                        
                    </div>
                    <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Contact Details</h5></center>
                            <div class="form-group"> 
                                <label for="inputEmail3" class="col-sm-2 control-label">Email </label>
                                <div class="col-sm-10"><?php echo form_error('Email') ?>
                                    <input type="email" class="form-control" name="Email" id="Email" placeholder="Email" value="<?php echo $Email?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                 
                                <label for="inputPassword3" class="col-sm-2 control-label">Mobile No</label>
                                <div class="col-sm-10"><?php echo form_error('Phonemobile') ?>
                                    <input type="int" maxlength="12" class="form-control" name="Phonemobile" id="Phonemobile" placeholder="Mobile No" value="<?php echo $Phonemobile?>" />
                                </div>
                            </div>
                            <div class="form-group"> 
                                <label for="inputEmail3" class="col-sm-2 control-label">Telno Office</label>
                                <div class="col-sm-10"><?php echo form_error('Phoneoffice') ?>
                                    <input type="int" class="form-control" name="Phoneoffice" id="Phoneoffice" placeholder="Telno Office" value="<?php echo $Phoneoffice?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                 
                                <label for="inputPassword3" class="col-sm-2 control-label">Telno Home </label>
                                <div class="col-sm-10"><?php echo form_error('Phonehome') ?>
                                    <input type="int" class="form-control" name="Phonehome" id="Phonehome" placeholder="Telno Home" value="<?php echo $Phonehome?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Fax No </label>
                                <div class="col-sm-10"><?php echo form_error('Fax') ?>
                                    <input type="int" class="form-control" name="Fax" id="Fax" placeholder="Fax No" value="<?php echo $Fax?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Address 1</label>
                                <div class="col-sm-10"><?php echo form_error('Address1') ?>
                                    <input type="text" class="form-control" name="Address1" id="Address1" placeholder="Address 1" value="<?php echo $Address1?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Address 2</label>
                                <div class="col-sm-10"><?php echo form_error('Address2') ?>
                                    <input type="text" class="form-control" name="Address2" id="Address2" placeholder="Address 2" value="<?php echo $Address2?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Address 3</label>
                                <div class="col-sm-10"><?php echo form_error('Address3') ?>
                                    <input type="text" class="form-control" name="Address3" id="Address3" placeholder="Address 3" value="<?php echo $Address3?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Post Code</label>
                                <div class="col-sm-10"><?php echo form_error('Postcode') ?>
                                    <input type="int" class="form-control" name="Postcode" id="Postcode" placeholder="Post Code" value="<?php echo $Postcode?>" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">City</label>
                                <div class="col-sm-10"><?php echo form_error('City') ?>
                                    <input type="text" class="form-control" id="City" name="City" placeholder="City" value="<?php echo $City?>" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">State</label>
                                <div class="col-sm-10"><?php echo form_error('State') ?>
                                    <input type="text" class="form-control" id="State" name="State" id="acc_country" placeholder="State" value="<?php echo $State?>" required />
                                </div>
                            </div>
                        
                    </div>

                    <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Account Details</h5></center>
                            
                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Branch </label>
                                <div class="col-sm-10">
                                    <select name="branch" id="branch" class="form-control" required>
                                        <option selected data-default style="display: none; " ><?php if(isset($_SESSION['branch']))
                                        {
                                            echo $_SESSION['branch'];

                                        }
                                        else
                                        {
                                            echo $branch;
                                        } ?></option>
                                        <?php 
                                        foreach ($select_branch as $row)
                                            {
                                                ?>
                                                <option required value="<?php echo $row['branch_code']?>"><?php echo $row['branch_name']; echo "&nbsp (".$row['branch_code'].")"?></option>
                                                <?php
                                            }
                                        ?>     
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                         
                                        <label><?php echo form_error('Active') ?>
                                        <input type="hidden" name="Active" id="Active" value="1" disabled />
                                            <input type="checkbox" name="Active" id="Active" disabled value="1" 
                                            <?php
                                            if($Active == 1)
                                            {
                                              ?>
                                              checked
                                              <?php
                                            }
                                            ?>/> Active
                                        </label>

                                        <label style="margin-left: 20px"><?php echo form_error('staff') ?>
                                        <input type="hidden" disabled name="staff" id="staff" value="0" />
                                            <input type="checkbox" disabled name="staff" id="staff" value="1" 
                                            <?php
                                            if($staff == 1)
                                            {
                                              ?>
                                              checked
                                              <?php
                                            }
                                            ?>/> Staff
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group"> 
                                <label for="inputEmail3" class="col-sm-2 control-label">Account No</label>
                                <div class="col-sm-10"><?php echo form_error('AccountNo') ?>
                                    <input <?php echo $decision?> type="text" class="form-control" name="AccountNo" id="AccountNo" placeholder="Account No " value="<?php echo $AccountNo?>" />
                                </div>
                            </div>

                            <div class="form-group"> 
                                <label for="inputPassword3" class="col-sm-2 control-label">Card No</label>
                                <div class="col-sm-10"><?php echo form_error('CardNo') ?>
                                    <input <?php echo $decision?> type="text" class="form-control" name="CardNo" id="CardNo" placeholder="Card No" value="<?php echo $CardNo?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Card Type </label>
                                <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                    <select readonly name="Cardtype" id="Cardtype" class="form-control">
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
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Credit Limit </label>
                                <div class="col-sm-10"><?php echo form_error('LimitAmtBalance') ?>
                                <input type="hidden" name="Credit" id="Credit" value="0" >
                                  <input type="checkbox" name="Credit" id="Credit" value="1" 
                                   onclick="var input = document.getElementById('LimitAmtBalance'); if(this.checked){ input.disabled = false; input.focus();}else{input.readOnly =true;}"
                                    <?php
                                      if ($Credit == '1')
                                      {
                                          echo "checked='checked'";
                                      }
                                    ?> />
                                    <input required name="LimitAmtBalance" class="form-control" id="LimitAmtBalance" value="<?php echo $LimitAmtBalance?>" 
                                    <?php
                                    if ($Credit == '0')
                                      {
                                         echo $decision;
                                      }
                                    ?> >
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Expiry Date </label>
                                <div class="col-sm-10"><?php echo form_error('Expirydate') ?>
                                    <input type="hidden" value="<?php echo $Expirydate?>" name="Expirydate" />
                                    <input type="date" class="form-control" name="" id="Expirydate" placeholder="Expiry Date" value="<?php echo $Expirydate?>"  readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Issue Date </label>
                                <div class="col-sm-10"><?php echo form_error('Issuedate') ?>
                                    <input type="date" class="form-control" name="Issuedate" id="Issuedate" placeholder="Acc Country" value="<?php echo $Issuedate?>"  readonly/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Issue Stamp</label>
                                <div class="col-sm-10"><?php echo form_error('IssueStamp') ?>
                                    <input type="datetime" <?php echo $decision?> class="form-control" name="IssueStamp" id="IssueStamp" placeholder="Issue Stamp" value="<?php echo $IssueStamp?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Created By</label>
                                <div class="col-sm-10"><?php echo form_error('CREATED_BY') ?>
                                    <input type="text" readonly class="form-control" name="CREATED_BY" id="CREATED_BY" placeholder="" value="<?php echo $CREATED_BY?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Updated At</label>
                                <div class="col-sm-10"><?php echo form_error('UPDATED_AT') ?>
                                    <input type="datetime" readonly class="form-control" name="UPDATED_AT" id="UPDATED_AT" placeholder="" value="<?php echo $UPDATED_AT?>" />
                                </div>
                            </div>
                    </div>
                        <button type="submit" name="pass" value="submit" class="btn btn-success pull-right">Save</button> 
                    </form>
                    </div>
                    <!-- /.box-body -->
                    
            


            </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    </div>
    </div>

    <script type="text/javascript">

    function selectNationality(obj) 
    {
        var select = document.getElementById('Nationality').options[document.getElementById('Nationality').options.selectedIndex].value.toUpperCase();
        if ( select == 'MALAYSIAN' || select == 'MALAYSIA' )
        {
            document.getElementById('ICNo').disabled = false;
            document.getElementById('PassportNo').disabled = true;
        }
        else if ( select != 'MALAYSIAN' && select != 'MALAYSIA' )
        {
            document.getElementById('ICNo').disabled = true;
            document.getElementById('PassportNo').disabled = false;
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

        document.getElementById('ICNo').value = icNo();
        document.getElementById('Name').value = holderName();
        document.getElementById('NameOnCard').value = holderName();
        document.getElementById('Birthdate').value = birthDate();
        document.getElementById('Gender').value = gender();
        document.getElementById('Race').value = race();
        document.getElementById('Religion').value = religion();
        document.getElementById('Address1').value = address1()+', '+address2()+', '+address3();
        document.getElementById('Postcode').value = postcode();
        document.getElementById('City').value = city();
        document.getElementById('State').value = state();
        
        alert("Read finished.");
    }
    </script>
