<?php 
'session_start()' 
?>


<script src="<?php echo base_url('js/jquery.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/mykad.js'); ?>" language="javascript" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<style>
    
#ttable > tr > th 
{

    width: 11%;

}

#ttable2 > tr > td 
{

    width: 11%;

}


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

<style type="text/css">
    
        table.bill_list, table.point-list  {
            width: 100%;
        }

        table.bill_list thead, 
        table.bill_list tbody, 
        table.bill_list tr, 
        table.bill_list td, 
        table.bill_list th, { display: block; }

        table.bill_list tr:after {
            content: ' ';
            display: block;
            visibility: hidden;
            clear: both;
        }

        table.bill_list thead th {
            height: 30px;

            /*text-align: left;*/
        }

        table.bill_list tbody
        {
            height: 180px;
            overflow-y: auto;
        }

        thead {
            /* fallback */
        }


        /*tbody td, thead th {
            width: 16.2%;
            float: left;
        }*/

        #card_history_table tbody td, #card_history_table thead th {
            width: 33.3%;
        }

        table#changes_table td, table#changes_table th
        {
            width: 9.09%;
        }

        table#point_movement_table {
            width: 100%;
        }

        #point_movement_table thead, 
        #point_movement_table tbody, 
        #point_movement_table tr, 
        #point_movement_table td, 
        #point_movement_table th { display: block; }

        #point_movement_table tr:after {
            content: ' ';
            display: block;
            visibility: hidden;
            clear: both;
        }

        #point_movement_table thead th {
            height: 30px;

            /*text-align: left;*/
        }

        #point_movement_table tbody {
            height: 200px;
            overflow-y: auto;
        }

        #point_movement_table thead {
            /* fallback */
        }


        #point_movement_table tbody td, 
        #point_movement_table thead th {
            width: 16.6%;
            float: left;
        }

</style>

<style type="text/css">
    
    .table-fixed tbody {
    height: 200px;
    overflow-y: auto;
    width: 100%;
    }
    .table-fixed thead,
    .table-fixed tbody,
    .table-fixed tr,
    .table-fixed td,
    .table-fixed th {
    display: block;
    }
    .table-fixed tr:after {
    content: "";
    display: block;
    visibility: hidden;
    clear: both;
    }
    .table-fixed tbody td,
    .table-fixed thead > tr > th {
    float: left;
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
<body onload="selectNationality(this)">
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

                    <div class="box-header with-border text-left">
                      <h3 class="box-title"><?php echo $page_title?></h3>

                      <?php
                        if($check_active == 0 || $Name == 'PREACTIVATED' && $Expirydate == '3000-12-31')
                        {
                            echo '<h3 style="color:red">Card not activate. Please Activate Card First!!Updating not allowed!!!</h3>';
                        }
                        ?>
                      <a href="<?php echo site_url('main_c'); ?>">
                        <button class="btn btn-default pull-right">Back</button>
                      </a>
                    </div>
                    <!-- /.box-header -->

                    <br>
                         <div class="tabbable" id="tabs-577039">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="col-md-2">Account No <span class="pull-right">:</span></label>
                                    <div class="col-md-10">
                                        <p><?php echo $AccountNo; ?></p>
                                    </div>
                                    <label class="col-md-2">Name <span class="pull-right">:</span></label>
                                    <div class="col-md-10">
                                        <p><?php echo $Name; ?></p>
                                    </div>
                                </div>
                            </div>
                         <ul class="nav nav-tabs">
                                <li class="active">
                                    <a class="tab-head" href="#panel-1111" data-toggle="tab">Details</a>
                                </li>
                                <li >
                                    <a class="tab-head" href="#panel-2222" data-toggle="tab">Point Movement</a>
                                </li>
                                <li >
                                    <a class="tab-head" href="#panel-3333" data-toggle="tab">Card History</a>
                                </li>
                                <li >
                                    <a class="tab-head" href="#panel-4444" data-toggle="tab">Miscellaneous</a>
                                </li>
                                <?php
                                    if($preissue_card_method == 0)
                                    {
                                ?>
                                <li>
                                    <a class="tab-head" href="#panel-5555" data-toggle="tab">Changes</a>
                                </li>
                                <?php
                                    }
                                ?>
                            </ul>
                     <div class="tab-content">
                        <div class="tab-pane active" id="panel-1111">
                                <div class="row">
                            <div class="col-md-12" style="padding-top:10px;">

                        <?php
                        if(in_array('VIC', $_SESSION['module_code']))
                        { ?>
                                <select name="msglist" id="SelectMsg" size="20" style="display: none;"></select>
                                <button id="idReadMyKAD" type="button" onClick="ReadTest()" class="btn btn-default" style="float: right;">Read MyKAD</button>
                        <?php }; ?>
                                <a style="float: right;margin-right: 10px"  href="<?php echo site_url('Transaction_c/print_card')?>?print_card&AccountNo=<?php echo $AccountNo?>&redirect=main_c/full_details?AccountNo=<?php echo $AccountNo?>" title="Print Card" class="print "><i class="btn btn-primary">Print Card</i></a>
                            </div>

                            <br>
                            <br>
                            <br>
                    </div>
                    <div class="box-body">

                      <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Personal Details</h5></center>
                        <form class="" role="form" id="form_submit" action="<?php echo $direction?>" method="post">
                        <input type="hidden" name="AccountNo" value="<?php echo $AccountNo?>">
                        <input type="hidden" id="Nationality_new" name="Nationality_new" value="<?php echo $Nationality?>" />
                            <div class="form-group"> 
                                <label for="varchar" class="col-sm-2 control-label">Nationality</label>
                                <div class="col-sm-10"><?php echo form_error('Nationality') ?>
                                    <select name="Nationality" id="Nationality" class="form-control" id="national" onchange="selectNationality(this); FillNationality(this.form);"

                                    <?php
                                    if(!in_array('VIC', $_SESSION['module_code']))
                                    {
                                        echo "disabled";
                                    } ?> >
                                        <option selected data-default><?php echo $Nationality?></option>
                                        <?php 
                                        foreach ($set_nationality->result() as $row)
                                            {
                                                ?>
                                                <option 
                                                <?php
                                                if($row->Preset == 1 && $Nationality == '')
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

                            <?php
                            if(in_array('VIC', $_SESSION['module_code']))
                            { ?>

                                <div class="form-group" id="ic_box">
                                   <label for="varchar" class="col-sm-2 control-label">IC No</label>
                                    <div class="col-sm-10"><?php echo form_error('ICNo') ?>
                                        <input type="text" class="form-control checking" name="ICNo" id="ICNo" placeholder="Ex: 880455022200" onkeyup="checkic()" onfocusout = 'auto_generate_birthdate()' value="<?php echo $ICNo?>" maxlength="12" />
                                        <span id="error_box" style="color: red; display: none;">Invalid IC No.</span>
                                    </div>
                                </div>
                                <div class="form-group" id="army_box">
                                   <label for="varchar" class="col-sm-2 control-label">Army Card No. </label>
                                    <div class="col-sm-10"><?php echo form_error('ICNo') ?>
                                        <input type="text" class="form-control checking" name="army_no" id="army_no" placeholder="Ex: xxxxxxxxx" value="<?php echo $army_no?>" onkeyup="checkic()" />
                                    
                                        <span id="error_box" style="color: red; display: none;">Invalid IC No.</span>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                   <label for="varchar" class="col-sm-2 control-label">Army Card No.</label>
                                    <div class="col-sm-10"><?php echo form_error('army_no') ?>
                                        <input type="text" class="form-control" name="army_no" id="army_no" placeholder="Army Card No." value="<?php echo $ICNo?>" 
                                    
                                        <?php if($Nationality != 'MALAYSIAN')
                                        { 
                                            echo "disabled";
                                        } 
                                        ?>/>
                                    </div>
                                </div> -->

                            <?php }
                            else
                            { ?>

                                <input type="hidden" name="ICNo" value="<?php echo $ICNo?>"/>
                                <input type="hidden" name="army_no" value="<?php echo $ICNo?>"/>

                            <?php } ?>

                            <?php
                            if(in_array('VIC', $_SESSION['module_code']))
                            { ?>

                                <div class="form-group">
                                    <label for="varchar" class="col-sm-2 control-label">Passport No</label>
                                    <div class="col-sm-10"><?php echo form_error('PassportNo') ?>
                                        <input type="text" class="form-control checking" name="PassportNo" id="PassportNo" placeholder="Passport No" value="<?php echo $PassportNo?>" />
                                    </div>
                                </div>

                            <?php }
                            else
                            { ?>

                                <input type="hidden" name="PassportNo" value="<?php echo $PassportNo?>"/>

                            <?php } ?>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Title </label>
                                <div class="col-sm-10"><?php echo form_error('Title') ?>
                                    <select name="Title" id="Title" class="form-control">
                                        <option><?php echo $Title?></option>
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
                                    <input type="text" maxlength="80" class="form-control" name="Name" id="Name" placeholder="Name" value="<?php echo $Name?>" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Name On Card </label>
                                <div class="col-sm-10"><?php echo form_error('NameOnCard') ?>
                                    <input type="text" class="form-control" name="NameOnCard" id="NameOnCard" placeholder="Name On Card" value="<?php echo $NameOnCard ?>" />
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Birthday Date </label>
                                <div class="col-sm-10"><?php echo form_error('Birthdate') ?>
                                    <input type="text" class="form-control" name="Birthdate" id="Birthdate" placeholder="Birthday Date" value="<?php echo $Birthdate ?>" required/>
                                </div>
                            </div> -->
                            <div class="form-group">
                            <label for="varchar" class="col-sm-2 control-label">Birthday Date </label>
                                <!-- <div class="input-group date"> -->
                                <div class="col-sm-10"><?php echo form_error('Birthdate') ?>
                                  <!-- <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div> -->
                                  <input type="date" class="form-control datepicker" name="Birthdate" id="Birthdate" placeholder="Birthday Date" value="<?php echo $Birthdate ?>" onclick="clearbirthday()">
                                  <span id="" style="color: #808080;">Press 1 to select date</span>
                                </div>
                                <!-- /.input group -->
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Gender </label>
                                <div class="col-sm-10"><?php echo form_error('Gender') ?>
                                    <select name="Gender" id="Gender" class="form-control">
                                        <option selected data-default style="display: none; " ><?php echo $Gender?></option>
                                        <option value="MALE">MALE</option>
                                        <option value="FEMALE">FEMALE</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Race </label>
                                <div class="col-sm-10"><?php echo form_error('Race') ?>
                                    <select name="Race" id="Race" class="form-control">
                                        <!-- <option value></option> -->
                                        <option selected data-default><?php echo $Race?></option>
                                        <?php 
                                        foreach ($set_race->result() as $row)
                                            {
                                                ?>
                                                <option <?php
                                                if($row->Preset == 1 && $Race == '')
                                                {
                                                    echo "selected";
                                                } 
                                                ?> value="<?php echo $row->Race?>"><?php echo $row->Race?></option>
                                                <?php
                                            }
                                        ?>     
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Religion </label>
                                <div class="col-sm-10"><?php echo form_error('Religion') ?>
                                    <select name="Religion" id="Religion" class="form-control">
                                        <!-- <option value></option> -->
                                        <option selected data-default><?php echo $Religion?></option>
                                        <?php 
                                        foreach ($set_religion->result() as $row)
                                            {
                                                ?>
                                                <option
                                                <?php
                                                if($row->Preset == 1 && $Religion == '')
                                                {
                                                    echo "selected";
                                                } 
                                                ?> value="<?php echo $row->Religion?>"><?php echo $row->Religion?></option>
                                                <?php
                                            }
                                        ?>     
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="varchar" class="col-sm-2 control-label">Status </label>
                                <div class="col-sm-10"><?php echo form_error('Status') ?>
                                    <select name="Status" id="Status" class="form-control">
                                        <!-- <option value></option> -->
                                        <option selected data-default><?php echo $Status?></option>
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
                                        <!-- <option value></option> -->
                                        <option selected data-default><?php echo $Occupation?></option>
                                        <?php 
                                        foreach ($set_occupation->result() as $row)
                                            {
                                                ?>
                                                <option

                                                <?php if($row->Preset == 1 && $Occupation == '')
                                                {
                                                    echo "selected";
                                                } ?>
                                                 value="<?php echo $row->Occupation?>"><?php echo $row->Occupation?></option>
                    
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
                                    <input type="email" class="form-control checking" name="Email" id="Email" placeholder="Email" value="<?php echo $Email?>" onkeyup="clearsentence();" />
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
                                    <input type="int" class="form-control" name="Postcode" id="Postcode" placeholder="Post Code" value="<?php echo $Postcode?>" />
                                    <!-- onchange="postalcode(this)" onfocus="this.value=''" onblur="if(checkForm(this.form))this.form.submit();"  -->
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">City</label>
                                <div class="col-sm-10"><?php echo form_error('City') ?>
                                    <input type="text" class="form-control" id="City" name="City" placeholder="City" value="<?php echo $City?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">State</label>
                                <div class="col-sm-10"><?php echo form_error('State') ?>
                                    <input type="text" class="form-control" id="State" name="State" id="acc_country" placeholder="State" value="<?php echo $State?>" />
                                </div>
                            </div>
                        
                    </div>

                    <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Account Details</h5></center>
                            
                            <div class="form-group">
                                <input type="hidden" id="branch_new" name="branch_new" value="<?php echo $branch?>" />
                                <label for="varchar" class="col-sm-2 control-label">Branch </label>
                                <div class="col-sm-10">
                                    <select name="branch" id="branch" class="form-control" onchange="FillBranch(this.form)"

                                    <?php
                                    if(!in_array('UB', $_SESSION['module_code']) || $disabled_branch > 0)
                                    { 
                                        echo "disabled"; 
                                    } ?> >
                                        <option selected data-default style="display: none; " ><?php echo $branch?></option>
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
                                        <input type="hidden" name="Active" id="Active" value="<?php echo $Active; ?>" />
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

                                            <input type="hidden" name="staff" 
                                              <?php if($staff == 0)
                                              {
                                              echo 'value="0"';
                                              }
                                              else
                                              {
                                                echo 'value="1"';
                                              }
                                              ?>
                                              ><input type="checkbox" 
                                              <?php
                                                if(!in_array('US', $_SESSION['module_code']))
                                                { 
                                                    echo "disabled"; 
                                                } ?>
                                              <?php if($staff == 0)
                                              {
                                                echo " ";
                                              }
                                              else
                                              {
                                                echo "checked";
                                              } ?> 
                                                onchange="this.previousSibling.value=1-this.previousSibling.value" /> Staff
                                        </label>

                                        <!-- <label style="margin-left: 20px"><?php echo form_error('staff') ?>
                                        <input type="" disabled name="staff" id="staff" value="0" />
                                            <input type="checkbox" name="staff" id="staff" value="1" 
                                            <?php
                                            if($staff == 1)
                                            {
                                              ?>
                                              checked
                                              <?php
                                            }
                                            ?>/> Staff
                                        </label> -->
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
                                <input type="hidden" id="Cardtype_new" name="Cardtype_new" value="<?php echo $Cardtype?>" />
                                <label for="varchar" class="col-sm-2 control-label">Card Type </label>
                                <div class="col-sm-10"><?php echo form_error('Cardtype') ?>
                                    <select name="Cardtype" id="Cardtype" class="form-control" onchange="FillCardType(this.form)"

                                    <?php
                                    if(!in_array('UCT', $_SESSION['module_code']))
                                    { 
                                        echo "disabled"; 
                                    } ?> >
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

                                    <input type="date" class="form-control" name="Expirydate" id="Expirydate" placeholder="Expiry Date" value="<?php echo $Expirydate?>" 
                                    <?php if(in_array('OED', $_SESSION['module_code'])) { echo ""; } else { echo "readonly"; } ?>  />
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
                            <div style="float: right;"
                        <?php
                        if($check_active == 0 || $Name == 'PREACTIVATED' && $Expirydate == '3000-12-31')
                        {
                            ?>
                            class = "hidden";
                            <?php
                        }
                        ?>>    
                        <?php
                          if(in_array('UM', $_SESSION['module_code']))
                          {
                            ?>

                            <a href="<?php echo site_url('Transaction_c/print_details')?>?AccountNo=<?php echo $AccountNo?>&CardNo=<?php echo $CardNo?>" target="_blank" title="Print Form" class="print"><i class="btn btn-primary">Print Details</i></a>
                            <button type="submit" name="pass" value="submit" onclick="return checking_lists();" class="btn btn-success" id="update_button"><?php echo $button?></button> 
                            
                            <?php
                          }
                          ?>
                        </div>
                    </div>
                </form>
                     </div>
                    </div>
                    <!-- /.box-body -->

                         <div class="tab-pane" id="panel-2222">
                        <div class="row">
                            <div class="col-md-4">
                                <center><h5 style="color:blue">Point Info</h5></center>
                                <div style="border:1px solid #ddd;padding:5px;">
                                    <div class="row">
                                        <label class="col-sm-5 control-label">Points Bring Forward <span class="pull-right">:</span></label>
                                        <div class="col-sm-7">
                                            <p><?php echo $PointsBF; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-5 control-label">Points <span class="pull-right">:</span></label>
                                        <div class="col-sm-7">
                                            <p><?php echo $Points; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-5 control-label">Points Adjustment <span class="pull-right">:</span></label>
                                        <div class="col-sm-7">
                                            <p><?php echo $PointsAdj; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-5 control-label">Point Used <span class="pull-right">:</span></label>
                                        <div class="col-sm-7">
                                            <p><?php echo $Pointsused; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-5 control-label">Point Balance<span class="pull-right">:</span></label>
                                        <div class="col-sm-7">
                                            <p><?php echo $Pointsbalance; ?></p>
                                        </div>
                                    </div>
                                    <?php
                                    if($active_expiry == 1)
                                    {
                                      ?>
                                        <div class="row">
                                            <label class="col-sm-5 control-label">Point on <?php echo $expiry_on?><span class="pull-right">:</span></label>
                                            <div class="col-sm-7">
                                                <p><?php echo $point_expiry?></p>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-8 form-horizontal">
                            <center><h5 style="color:blue">Point Movement</h5></center>
                                
                                  <table id="point_movement_table" class="table table-bordered table-hover point-list">
                                    <thead style="cursor:s-resize"> 
                                    <tr> 
                                        <th>Period Code</th> 
                                        <th>Points Bring Forward</th>
                                        <th>Point Earned</th>
                                        <th>Point Adjusment</th> 
                                        <th>Points Used</th>
                                        <th>Point Balance</th>
                                    </tr> 
                                    </thead> 
                                    <tbody>
                                    <?php
                                    foreach ($movement_point_details->result() as $row)    
                                        {                                        
                                        ?> 
                                    <tr style="cursor:pointer;">
                                        <td class="filterable-cell" align="center" style="padding:5px;">
                                            <button class="btn btn-primary btn-xs" onclick="month_sale_list('<?php echo $row->PeriodCode?>')"><?php echo $row->PeriodCode ?></button>
                                        </td>
                                        <td class="filterable-cell"><?php echo $row->PointsBF?></td>
                                        <td class="filterable-cell"><?php echo $row->Pointsearn; ?></td>
                                        <td class="filterable-cell"><?php echo $row->PointsAdj?></td>
                                        <td class="filterable-cell"><?php echo $row->PointsUsed?></td>
                                        <td class="filterable-cell"><?php echo $row->Pointsbalance ?></td>
                                    </tr>
                                     <?php
                                        }
                                        ?> 
                                    </tbody> 
                                    </table>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered bill_list table-hover" id="purchase_list_server_side">
                                    <thead>
                                        <tr>
                                            <th>Trans Type</th>
                                            <th>Ref No</th>
                                            <th>Location</th>
                                            <th>Biz Date</th>
                                            <th>Sys Date</th>
                                            <th>User</th>
                                            <th>Points</th>
                                            <th>Bill Amount</th>
                                            <!-- <th>Bill Status</th> -->
                                            <th>Created By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody id="purchase_list">
                                        <?php
                                            foreach ($purchase_list as $row) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $row['TRANS_TYPE']; ?></td>
                                                    <td><?php echo $row['RefNo']; ?></td>
                                                    <td><?php echo $row['Location']; ?></td>
                                                    <td><?php echo $row['BizDate']; ?></td>
                                                    <td><?php echo $row['SysDate']; ?></td>
                                                    <td><?php echo $row['User']; ?></td>
                                                    <td><?php echo $row['Points']; ?></td>
                                                    <td><?php echo $row['BillAmt']; ?></td>
                                                    <td><?php echo $row['BillStatus']; ?></td>
                                                    <td><?php echo $row['Created_By']; ?></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody> -->
                                </table>
                            </div>
                        </div>
                        </div>
                        <div class="tab-pane" id="panel-3333">
                            <div class="col-md-5 form-horizontal">
                                <center><h5 style="color:blue">Card History</h5></center>
                                <div style="overflow-x:auto;">
                                <table id="card_history_table" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                      <th>Card No</th>
                                      <th>Created At</th>
                                      <th>Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($cardhistory->result() as $row) { ?>
                                    <tr>
                                        <td><?php echo $row->cardno; ?></td>
                                        <td><?php echo $row->created_at; ?></td>
                                        <td><?php echo $row->status; ?></td>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                              </table>
                                 
                            </div>
                        </div>






                        
                        </div>
                        <div class="tab-pane" id="panel-4444">
                            <div class="row">
                            <div class="col-md-12 form-horizontal" style="margin-top:10px;">
                                 <button class="btn btn-xs btn-primary" style="float: right;" onclick="add_misc()"><i class="glyphicon glyphicon-plus" style="line-height: 2"></i>Add New</button>
                                <center><h5 style="color:blue">Member Miscellaneous</h5></center>

                                 
                            </div>
                        </div>

                            <div class="col-md-12 form-horizontal">
                                  <table  id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                    <thead id="ttable" style="cursor:s-resize"> 
                                    <tr> 
                                        <th>Actions</th> 
                                        <th>Sequence</th>
                                        <th>Miscellaneous Group</th>
                                        <th>Text 1</th>
                                        
                                    </tr> 
                                    </thead> 
                                    <tbody id="ttable2">
                                    <?php
                                    foreach ($mem_misc->result() as $row)    
                                        {                                        
                                        ?> 
                                    <tr>
                                         <td class="filterable-cell"><button title="Edit" onclick="edit_misc()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#Misc" 
                          data-seq="<?php echo $row->seq?>"
                          data-misc_guid="<?php echo $row->misc_guid?>"
                          data-misc_group="<?php echo $row->misc_group?>"
                          data-text1="<?php echo $row->text1?>">
                          <i class="glyphicon glyphicon-pencil"></i></button>
                                         <button title="Delete" onclick="confirm_modal('<?php echo site_url('Main_c/delete'); ?>?AccountNo=<?php echo $AccountNo?>&condition=<?php echo $row->misc_guid; ?>&column=misc_guid&table=member_miscellaneous')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="This Record" ><i class="glyphicon glyphicon-trash"></i></button>

                                        </td>
                                        <td class="filterable-cell"><?php echo $row->seq ?></td>
                                        <td class="filterable-cell"><?php echo $row->misc_group ?></td>
                                        <td class="filterable-cell"><?php echo $row->text1 ?></td>
                                    </tr>
                                     <?php
                                        }
                                        ?> 
                                    </tbody> 
                                    </table>
                                
                            </div>
                        </div>
                        <div class="tab-pane" id="panel-5555">
                            <center><h5 style="color:blue">Changes</h5></center>
                            <table class="table table-striped table-bordered" id="changes_table">
                                <thead>
                                    <tr>
                                        <th>Trans Type</th>
                                        <th>Ref No</th>
                                        <th>Account No</th>
                                        <th>Card No</th>
                                        <th>New Card No</th>
                                        <th>Name</th>
                                        <th>Issue Date</th>
                                        <th>Created by</th>
                                        <th>Mobile No</th>
                                        <th>Expiry Date</th>
                                        <th>Relationship</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                if(isset($changes) && $changes->num_rows() > 0)
                                {
                                    foreach($changes->result() as $change)
                                    {
                            ?>
                                            <tr>
                                                <td><?php echo $change->TRANS_TYPE; ?></td>
                                                <td><?php echo $change->REF_NO; ?></td>
                                                <td><?php echo $change->AccountNo; ?></td>
                                                <td><?php echo $change->CardNo; ?></td>
                                                <td><?php echo $change->CardNoNew; ?></td>
                                                <td><?php echo $change->Name; ?></td>
                                                <td><?php echo $change->IssueStamp; ?></td>
                                                <td><?php echo $change->created_at; ?></td>
                                                <td><?php echo $change->Phonemobile; ?></td>
                                                <td><?php echo $change->Expirydate; ?></td>
                                                <td><?php echo $change->Relationship; ?></td>
                                            </tr>
                            <?php
                                    }
                                }
                            ?>
                                </tbody>
                            </table>
                        </div>
                        
                    <!-- ori here -->


                  <!-- /.box -->

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

    <script type="text/javascript">
        
        function clearsentence() 
        {
            var Email = document.getElementById('Email').value;
                
            /*if(ICNo != '' || PassportNo != '' || Email != '')*/ 
            if(Email == '') 
            {  
                document.getElementById('update_button').disabled = false;
                document.getElementById('error').innerHTML = ''; 
            }
        }

        function add_misc()
        {
          save_method = 'add';
          $('#Miscellaneous').modal('show'); // show bootstrap modal
          $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
        }

         function edit_misc()
        {
          $('#Misc').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) 

            var modal = $(this)
            modal.find('.modal-title').text('Edit')
            modal.find('[name="seq"]').val(button.data('seq'))
            modal.find('[name="misc_guid"]').val(button.data('misc_guid'))
            modal.find('[name="misc_group"]').val(button.data('misc_group'))
            modal.find('[name="text1"]').val(button.data('text1'))

            if(button.data('set_active') == 1)
            {
                modal.find('input[type=checkbox]').prop('checked', true);
            }
            else
            {
                modal.find('input[type=checkbox]').prop('checked', false);
            }
          });
        }

            function confirm_modal(delete_url)
        {
          $('#delete').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) 

          var modal = $(this)
          modal.find('.modal_detail').text('Confirm delete ' + button.data('name') + '?')
          modal.find('.modal_alert').text(button.data('alert'))
          document.getElementById('url').setAttribute("href" , delete_url );
          });
        }

    </script>

    <script type="text/javascript">
        
        function checking_lists() 
        {
            checkrequiredfields();
            //checkduplicates();
        }

    </script>

    <script>
      $(document).ready(function(){  

            $('.checking').keyup(function(){
            var output = $(this).val();
            var field = $(this).attr('id');
            
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
                                if(field == 'ICNo')
                                {
                                    var ic_no = document.getElementById('ICNo').value;
                                    var ic_month = ic_no.substring(2, 4);
                                    var ic_date = ic_no.substring(4, 6);

                                    if(isNaN(ic_no))
                                    {
                                        document.getElementById('update_button').disabled = true;
                                        document.getElementById('error_box').style.display = 'block';
                                        document.getElementById('error').innerHTML = '';
                                        //document.getElementById('final_submit').disabled = true;
                                    }
                                    else
                                    {
                                        if(ic_no.length != 12 || ic_month > 12 || ic_date > 31)
                                        {
                                            document.getElementById('update_button').disabled = true;
                                            document.getElementById('error_box').style.display = 'block';
                                            document.getElementById('error').innerHTML = '';
                                            //document.getElementById('final_submit').disabled = true;
                                        }
                                        else
                                        {
                                            document.getElementById('update_button').disabled = false;
                                            document.getElementById('error_box').style.display = 'none';
                                            document.getElementById('error').innerHTML = '';
                                            //document.getElementById('final_submit').disabled = false;
                                        }
                                    }
                                }
                                else
                                {
                                    document.getElementById('error').innerHTML = '';
                                    document.getElementById('error_box').style.display = 'none';
                                    document.getElementById('update_button').disabled = false;
                                    return false;
                                }
                            }
                            
                       }  
                  });  
             } 
             else
            {
                document.getElementById('error').innerHTML = '';
                document.getElementById('error_box').style.display = 'none';
                document.getElementById('update_button').disabled = false;
                return false;
            }
        });  
    });
            /*}*/

    </script>

    <script type="text/javascript">

      function checkrequiredfields() 
      {
        var select = document.getElementById('Nationality').value.toUpperCase();

        var ic = document.getElementById('ICNo').value;
        var army = document.getElementById('army_no').value;
        var passport = document.getElementById('PassportNo').value;

        if ( select == 'MALAYSIAN' || select == 'MALAYSIA' )
        {
            if(ic == null || ic == '')
            {
              alert('Please fill in IC no.');
              return false;
            }
        }
        else if ( (select != 'MALAYSIAN' || select != 'MALAYSIA') && (select == 'MALAYSIAN (ARMY)' || select == 'MALAYSIA (ARMY)') )
        {
            if(army == null || army == '')
            {
              alert('Please fill in army card no.');
              return false;
            }
        }
        else if ( select != 'MALAYSIAN' || select != 'MALAYSIA' )
        {
            if(passport == null || passport == '')
            {
              alert('Please fill in passport no.');
              return false;
            }
        }
      }

    </script>

    <script type="text/javascript">
      function clearbirthday()
      {
        var Birthdate = document.getElementById('Birthdate').value;

        if(Birthdate == '0000-00-00')
        {
          document.getElementById('Birthdate').value = '';
        }
      }
    </script>

    <!-- <script type="text/javascript">
      function checkic()
      {
        var ic_no = document.getElementById('ICNo').value;
        var ic_month = ic_no.substring(2, 4);
        var ic_date = ic_no.substring(4, 6);

        if(isNaN(ic_no))
        {
            document.getElementById('update_button').disabled = true;
            document.getElementById('error_box').style.display = 'block';
            //document.getElementById('final_submit').disabled = true;
        }
        else
        {
            if(ic_no.length != 12 || ic_month > 12 || ic_date > 31)
            {
                document.getElementById('update_button').disabled = true;
                document.getElementById('error_box').style.display = 'block';
                //document.getElementById('final_submit').disabled = true;
            }
            else
            {
                document.getElementById('update_button').disabled = false;
                document.getElementById('error_box').style.display = 'none';
                //document.getElementById('final_submit').disabled = false;
            }
        }
      }
    </script> -->

    <script type="text/javascript">

    function selectNationality(obj) 
    {
        var select = document.getElementById('Nationality').options[document.getElementById('Nationality').options.selectedIndex].value.toUpperCase();

        if ( select == 'MALAYSIAN' || select == 'MALAYSIA' )
        {
            document.getElementById('ICNo').disabled = false;
            document.getElementById('PassportNo').disabled = true;
            document.getElementById('idReadMyKAD').disabled = false;

            document.getElementById('army_box').style.display = 'none';
            document.getElementById('ic_box').style.display = 'block';

            document.getElementById('army_no').value = '';
            document.getElementById('PassportNo').value = '';

            document.getElementById('ICNo').required = true;
            document.getElementById('PassportNo').required = false;
            document.getElementById('army_no').required = false;
        }
        else if ( (select != 'MALAYSIAN' || select != 'MALAYSIA') && (select == 'MALAYSIAN (ARMY)' || select == 'MALAYSIA (ARMY)') )
        {
            document.getElementById('ICNo').disabled = false;
            document.getElementById('PassportNo').disabled = true;
            document.getElementById('idReadMyKAD').disabled = true;

            document.getElementById('army_box').style.display = 'block';
            document.getElementById('ic_box').style.display = 'none';

            document.getElementById('ICNo').value = '';
            document.getElementById('PassportNo').value = '';

            document.getElementById('ICNo').required = false;
            document.getElementById('PassportNo').required = false;
            document.getElementById('army_no').required = true;
        }
        else if ( select != 'MALAYSIAN' || select != 'MALAYSIA' )
        {
            document.getElementById('ICNo').disabled = true;
            document.getElementById('PassportNo').disabled = false;
            document.getElementById('idReadMyKAD').disabled = true;

            document.getElementById('army_box').style.display = 'none';
            document.getElementById('ic_box').style.display = 'none';

            document.getElementById('ICNo').value = '';
            document.getElementById('army_no').value = '';

            document.getElementById('ICNo').required = false;
            document.getElementById('PassportNo').required = true;
            document.getElementById('army_no').required = false;
        }
    }

    function FillBranch(f) {
  
        f.branch_new.value = f.branch.value;
    }

    function FillCardType(f) {
  
        f.Cardtype_new.value = f.Cardtype.value;
    }

  
    function FillNationality(f) {
  
        f.Nationality_new.value = f.Nationality.value;
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

        document.getElementById('ICNo').value = icNo();
        document.getElementById('Name').value = holderName();
        document.getElementById('NameOnCard').value = holderName();
        document.getElementById('Birthdate').value = birthDate();
        //document.getElementById('Gender').value = gender();
        //document.getElementById('Race').value = race();
        //document.getElementById('Religion').value = religion();
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

    function ahsheng()
    {
        modal = $('#Misc');
        if(modal.find('input[type=checkbox]').prop("checked") == true)
        {
            modal.find('[name="set_active"]').val('1');
        }
        else
        {
            modal.find('[name="set_active"]').val('0');
        }
    }

    function auto_generate_birthdate()
    {
        var ic_no = document.getElementById('ICNo').value;

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


<div class="modal fade" id="delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal_alert" style="text-align: center;color: red"></h4>
                <h4 class="modal_detail" style="text-align: center"></h4>
            </div>
            <div class="modal-footer" style="text-align: center">
            <span id="preloader-delete"></span>
                <a id="url" href=""><button type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button></a>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="Misc" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Main_c/update_misc')?>?AccountNo=<?php echo $_REQUEST['AccountNo'] ?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group" style="line-height: normal;">
                            <input type="hidden" name="misc_guid"/> 
                            <label class="control-label col-md-3">Account Number</label>
                            <div class="col-md-9">
                                <input readonly name="accno" class="form-control" type="text" maxlength="60" value="<?php echo $AccountNo?>" >
                                <span class="help-block"></span>
                            </div>
                             <label class="control-label col-md-3">Sequence</label>
                            <div class="col-md-9">
                                <input name="seq" class="form-control" type="number" maxlength="60"  autocomplete="off">
                                <span class="help-block"></span>
                            </div>
                                
                             <label class="control-label col-md-3">Miscellaneous</label>
                           <div class="col-md-9">

                              <select name="misc_group" class="selectpicker form-control" >

                                        <?php 
                                 foreach ($set_misc->result()  as $row)
                                  {
                                    ?>
                                     
                                  <option><?php echo $row->misc_name;?></option>
                              <?php
                                  }
                                ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                             <label class="control-label col-md-3">Text 1</label>
                            <div class="col-md-9">
                                <input name="text1" class="form-control" type="text" maxlength="60" autocomplete="off">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" >Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="Miscellaneous" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Main_c/insert_misc')?>?AccountNo=<?php echo $_REQUEST['AccountNo'] ?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group" style="line-height: normal;">
                            <label class="control-label col-md-3">Account Number</label>
                            <div class="col-md-9">
                                <input readonly name="accno" class="form-control" type="text" maxlength="60" value="<?php echo $AccountNo?>" >
                                <span class="help-block"></span>
                            </div>
                             <label class="control-label col-md-3">Sequence</label>
                            <div class="col-md-9">
                                <input name="sequence" class="form-control" type="number" maxlength="60"  autocomplete="off">
                                <span class="help-block"></span>
                            </div>
                                
                             <label class="control-label col-md-3">Miscellaneous</label>
                           <div class="col-md-9">
                              <select name="misc_group" class="selectpicker form-control" >
                                        <?php 
                                 foreach ($set_misc->result()  as $row)
                                  {
                                    ?>
                                     
                                  <option><?php echo $row->misc_name;?></option>
                              <?php
                                  }
                                ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                             <label class="control-label col-md-3">Text 1</label>
                            <div class="col-md-9">
                                <input name="text1" class="form-control" type="text" maxlength="60" autocomplete="off">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="child_list" role="dialog">
    <div class="modal-dialog modal-lg" style="width:80%">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Sales</h3>
            </div>
            <div class="modal-body" style="overflow:auto;">
                <table class="table table-striped table-bordered" id="trans_child_table">
                    <thead>
                        <tr>
                            <th>Ref No</th>
                            <th>PosID</th>
                            <th>Location</th>
                            <th>BizDate</th>
                            <th>User</th>
                            <th>Line</th>
                            <th>ItemCode</th>
                            <th>Description</th>
                            <th>Point</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Refund</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default pull-right" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="point_child_list" role="dialog">
    <div class="modal-dialog modal-lg" style="width:80%">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Point Transaction</h3>
            </div>
            <div class="modal-body" style="overflow:auto;">
                <table class="table table-striped table-bordered" id="trans_child_server_side">
                    <thead>
                        <tr>
                            <th>RefNo</th>
                            <th>Trans Type</th>
                            <th>Itemcode</th>
                            <th>Description</th>
                            <th>QTY</th>
                            <th>Value Unit</th>
                            <th>Value Total</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default pull-right" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>