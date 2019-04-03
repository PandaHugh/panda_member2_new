<?php 
'session_start()' 
?>

<script src="<?php echo base_url('js/jquery.min.js');?>"></script>

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

            <center><h3><b>Suplimentary Card Details</b></h3>
                            <h4><?php echo $_REQUEST['AccountNo'] ?></h4>
                            <h4><?php echo $_REQUEST['Name'] ?></h4>
                         </center>
                    
              <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('main_c')?>" class="btn btn-default btn-md"  style="float:right;" >
                          <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
                    </h1>

                    <a style="float: right;margin-right: 10px"  href="<?php echo site_url('Transaction_c/print_card')?>?print_card&CardNo=<?php echo $CardNo?>&redirect=main_c" title="Print Card" class="print "><i class="btn btn-primary">Print Card</i></a>
                        <!--<h1 class="page-subhead-line"></h1>-->
                  </div>
              </div>

              <div class="row">
                <div class="col-md-12">

                    <!-- <div class="box-header with-border text-left">
                      <h3 class="box-title"></h3>
                    </div> -->
                    <!-- /.box-header -->
                    <div class="box-body">

                      <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Personal Details</h5></center>
                        <form class="" role="form" action="<?php echo site_url('main_c/update_supcard')?>" method="post">
                        <input type="hidden" name="AccountNo" value="<?php echo $AccountNo?>">
                            <div class="form-group"> 
                                <label for="varchar" class="col-sm-2 control-label">Nationality</label>
                                <div class="col-sm-10"><?php echo form_error('Nationality') ?>
                                    <select name="Nationality" id="Nationality" class="form-control" id="national" onchange="selectNationality(this)">
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

                             <?php
                            if(in_array('VIC', $_SESSION['module_code']))
                            { ?>

                                <div class="form-group" id="icno_form">
                                   <label for="varchar" class="col-sm-2 control-label">IC No</label>
                                    <div class="col-sm-10"><?php echo form_error('ICNo') ?>
                                        <input type="text" data-inputmask='"mask": "999999-99-9999"' data-mask class="form-control" name="ICNo" id="ICNo" placeholder="Identity Card No" value="<?php echo $ICNo?>" />
                                    </div>
                                </div>
                                <div class="form-group" id="passport_form">
                                    <label class="col-sm-2 control-label">Passport No</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="ICNo" id="PassportNo" value="<?php echo $ICNo; ?>">
                                    </div>
                                </div>

                            <?php }
                            else
                            { ?>

                                <input type="hidden" name="ICNo" value="<?php echo $ICNo?>"/>

                            <?php } ?>

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
                                    <input type="date" class="form-control" name="Birthdate" id="Birthdate" placeholder="Birthday Date" value="<?php echo $Birthdate ?>" required/>
                                </div>
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
                                <label for="varchar" class="col-sm-2 control-label">Relationship </label>
                                <div class="col-sm-10"><?php echo form_error('Title') ?>
                                    <select name="relay" id="relay" class="form-control">
                                        <option selected data-default style="display: none; " ><?php echo $Relationship?></option>
                                        <?php 
                                        foreach ($set_relationship->result() as $row)
                                            {
                                                ?>
                                                <option
                                                <?php
                                                if($row->Preset == 1 && $Title == '')
                                                {
                                                    echo "selected";
                                                } 
                                                ?> value="<?php echo $row->Relationship?>"><?php echo $row->Relationship?></option>
                                                <?php
                                            }
                                        ?>     
                                    </select>
                                </div>
                            </div>

                        
                        
                    </div>
                    <div class="col-md-4 form-horizontal">
                        <center><h5 style="color:blue">Account Details</h5></center>

                            <div class="form-group"> 
                                <label for="inputEmail3" class="col-sm-2 control-label">Account No</label>
                                <div class="col-sm-10"><?php echo form_error('AccountNo') ?>
                                    <input <?php echo $decision?> type="text" class="form-control" name="AccountNo" id="AccountNo" placeholder="Account No " value="<?php echo $AccountNo?>" />
                                    <input <?php echo $decision?> type="hidden" class="form-control" name="MainName" id="MainName"  value="<?php echo $_REQUEST['Name']?>" />
                                </div>
                            </div>

                            <div class="form-group"> 
                                <label for="inputPassword3" class="col-sm-2 control-label">Card No</label>
                                <div class="col-sm-10"><?php echo form_error('CardNo') ?>
                                    <input <?php echo $decision?> type="text" class="form-control" name="CardNo" id="CardNo" placeholder="Card No" value="<?php echo $CardNo?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Expiry Date </label>
                                <div class="col-sm-10"><?php echo form_error('Expirydate') ?>
                                    <input type="date" class="form-control" name="Expirydate" id="Expirydate" placeholder="Expiry Date" value="<?php echo $Expirydate?>"  readonly/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Issue Stamp</label>
                                <div class="col-sm-10"><?php echo form_error('IssueStamp') ?>
                                    <input type="datetime" <?php echo $decision?> class="form-control" name="IssueStamp" id="IssueStamp" placeholder="Issue Stamp" value="<?php echo $IssueStamp?>" />
                                </div>
                            </div>
                            
                        
                    </div>

                    <div class="col-md-4 form-horizontal">
                    <center><h5 style="color:black"><b>Supcard List</b></h5></center>
                        <div style="overflow-x:auto;height: 400px">
                          <table id="" class="table table-bordered table-hover">
                            <thead style="cursor:s-resize"> 
                            <tr> 
                                <th>Account No</th> 
                                <th>Supcard No</th>
                                <th>Name</th> 
                                <th>IC No</th>
                            </tr> 
                            </thead> 
                            <tbody>
                            <?php
                            foreach ($supcard_record->result() as $row)    
                                {                                        
                                ?> 
                            <tr>
                                <td><?php echo $row->AccountNo ?></td>
                                <td><span class="label label-primary" style="font-size: 14px;"><a style="color: white;" href="<?php echo site_url('main_c/supcard_details')?>?AccountNo=<?php  echo $row->AccountNo?>&CardNo=<?php  echo $row->SupCardNo?>&Name=<?php echo $_REQUEST['Name']?>"><?php echo $row->SupCardNo?></a></span></td>
                                <td><?php echo $row->Name?></td>
                                <td><?php echo $row->ICNo?></td>
                            </tr>
                             <?php
                                }
                                ?>    
                            </tbody> 
                            </table>
                        </div>

                    </div>
                     
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-right">
                        
                        <?php
                          if(in_array('UM', $_SESSION['module_code']))
                          {
                            ?>
                            <button type="submit" name="pass" value="submit" class="btn btn-success">Update</button> 
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

    <script type="text/javascript">

    function selectNationality(obj) 
    {

        var select = document.getElementById('Nationality').options[document.getElementById('Nationality').options.selectedIndex].value.toUpperCase();
        
        if ( select == 'MALAYSIAN' || select == 'MALAYSIA' )
        {
            document.getElementById('ICNo').disabled = false;
            document.getElementById('PassportNo').disabled = true;
            document.getElementById('icno_form').style.display = "block";
            document.getElementById('passport_form').style.display = "none";
            document.getElementById('PassportNo').value = "";
        }
        else if ( select != 'MALAYSIAN' && select != 'MALAYSIA' )
        {
            document.getElementById('ICNo').disabled = true;
            document.getElementById('PassportNo').disabled = false;
            document.getElementById('icno_form').style.display = "none";
            document.getElementById('passport_form').style.display = "block";
            document.getElementById('ICNo').value = "";
        }
    }

    </script>
