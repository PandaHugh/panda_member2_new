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

#scroll {
  height: 350px;
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

<body onload="activate_change_box(); lost_change_box(); renew_change_box(); sup_change_box(); replace_change_box(); upgrade_change_box();">


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
                    
              <!-- <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('main_c')?>" class="btn btn-default btn-xs"  style="float:right;" >
                          <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
                    </h1>
                  </div>
              </div> -->

  <div class="row">
    <div class="col-md-12">

    <!-- Content Header (Page header) -->
    <section class="content-header ">
      <h1>Operation</h1>
    </section>
    <br>
    <br>
    <!-- Main content -->
    <section class="content">
       <div class="tabbable" id="tabs-577039">
                         <ul class="nav nav-tabs">
                                <li class="active">
                                    <a class="tab-head" href="#panel-11" data-toggle="tab">Setting (Operations)</a>
                                </li>
                                <li >
                                    <a class="tab-head" href="#panel-22" data-toggle="tab">Card charges Based On Outlet</a>
                                </li>
                                <li >
                                    <a class="tab-head" href="#panel-33" data-toggle="tab">Setting (Check Digit)</a>
                                </li>
                                <li >
                                    <a class="tab-head" href="#panel-44" data-toggle="tab">Sub Settings</a>
                                </li>
                            </ul>
     
      
        <div class="tab-content">
      <div class="tab-pane active" id="panel-11">
        <div class="row">
        <!-- /.col -->
        <div class="col-md-8">
          <div class="box">
            <div class="box-header">
              <form method="post" action="<?php echo site_url('Setup_general_c/save_general'); ?>?table=set_parameter" id="formS" class="formS">
              <h3 class="box-title" style="color:blue">Setting (Operations)</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" type="submit"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            
              <table class="table">
                <tr style="display:none;">
                  <td><label>Auto Renew Supcard</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="auto_renewsupcard" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('auto_renewsupcard'); ?>" max="1" min="0" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="display: none;">
                  <td><label>Active Preissue</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="preissue_default_active" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('preissue_default_active'); ?>" max="1" min="0" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Interval year for renew card.">Member Expiry Date In Year</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="expiry_date_in_year" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('expiry_date_in_year'); ?>" min="0"/>
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Type 1: New expiry date will follow based on date of renewal card.
                    Type 2: New expiry date will follow based on current expiry date.">Member Expiry Date Type</label></td>
                  <td style="width: 80px;">
                    <input type="number" min="1" max="<?php if($parameter->row('expiry_date_roundup') == '0'){ echo '2';}else{ echo '3';} ?>" name="expiry_date_type" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('expiry_date_type'); ?>"/>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Set 0: System will check similar receipt amount for all outlets. Set 1: System will check itemcode that has been set in iventory. Set 2: System will check receipt amount based on each outlet.">Checking Receipt Method</label></td>
                  <td style="width: 80px;">
                    <input type="number" min="0" max="2" name="check_receipt_itemcode" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('check_receipt_itemcode'); ?>" />
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Set 1: System shall allow merchant user to login.">Merchant Reward Program</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" min="0" max="1" name="merchant_rewards_program" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('merchant_rewards_program'); ?>" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label>Voucher Valid In Day</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="voucher_valid_in_days" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('voucher_valid_in_days'); ?>" min="0" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Set 0: System will auto generate voucher number. Set 1:Voucher number Customization. Set 2: System will check voucher number via prelisted list .">Voucher No. Customization</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="customized_voucher_no" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('customized_voucher_no'); ?>" max="2" min="0" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="System auto calculate for expiry point.">Auto Point Expiry</label></td>
                  <td style="width: 80px;">
                    <input type="checkbox" name="point_expiry" class="subject-list" onChange="$('#formS').submit()"
                    value="1"
                    <?php if($parameter->row('point_expiry') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                
                <?php
                if($parameter->row('point_expiry') == '1')
                {
                  ?>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="System calculate expiry point on end of month anually.
                    Example: If you choose December, System will run a calculation program for every end of December.">Cut Off Month</label></td>
                  <td style="width: 120px;">
                    <select class="form-control" name="point_expiry_period">
                      <option selected value='<?php echo $parameter->row('point_expiry_period')?>'><?php echo $expiry_month?></option>
                      <option value='01'>Janaury</option>
                      <option value='02'>February</option>
                      <option value='03'>March</option>
                      <option value='04'>April</option>
                      <option value='05'>May</option>
                      <option value='06'>June</option>
                      <option value='07'>July</option>
                      <option value='08'>August</option>
                      <option value='09'>September</option>
                      <option value='10'>October</option>
                      <option value='11'>November</option>
                      <option value='12'>December</option>
                    </select> 
                  </td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="System calculate based on previous interval month. Example: If December/2018 as cut off month, and the interval month is 6. So system will calculate all point earn and point balance on June/2018 period to set as expiry point.">Expiry Interval Month</label></td>
                  <td style="width: 120px;">
                    <input type="number" name="point_expiry_month" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('point_expiry_month'); ?>" max="12" min="0" />
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                  
                  <?php
                }
                ?>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Set 0: By Pass card verify. Set 1: Need card verify. (Renew Card, Issue Sup Card, Active Card)">Card Verify</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="card_verify" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('card_verify'); ?>" min="0" max="2"/>
                  
                  </td>
                </tr>


              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      </div>
 
        <!-- /.box -->

      <div class="tab-pane" id="panel-22">
        <div class="row">
        <div class="col-md-8">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="color:blue">Card Charges Based On Outlet</h3>

              <?php if(in_array('UAS', $_SESSION['module_code']))
              { ?>
                
                <button class="btn btn-xs" onclick="location.href = '<?php echo site_url('Setup_general_c/sync_branch')?>';" >Sync Outlet</button>

              <?php } ?>
          
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSBNC').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save_set_branch'); ?>?table=set_branch_newcard" id="formSBNC" name="formSBNC" class="formSBNC">
              <table class="table">
                <tr>
                  <th>Outlet</th>
                  <th>Activate Card <input type="checkbox" onClick="selectall_activate(this); printfield_activate()" id="activate" /></th>
                  <th>Lost Card <input type="checkbox" onClick="selectall_lost(this); printfield_lost()" id="lost" /></th>
                  <th>Renew Card <input type="checkbox" onClick="selectall_renew(this); printfield_renew()" id="renew" /></th>
                  <th>Supplementary Card <input type="checkbox" onClick="selectall_sup(this); printfield_sup()" id="sup" /></th>
                  <th>Replace Card <input type="checkbox" onClick="selectall_replace(this); printfield_replace()" id="replace" /></th>
                  <th>Upgrade Card <input type="checkbox" onClick="selectall_upgrade(this); printfield_upgrade()" id="upgrade"/></th>

                </tr>

                <?php foreach($set_branch_parameter->result() as $row)
                { ?>

                  <tr>
                    <td><?php echo $row->branch_name; echo "&nbsp (".$row->branch_code.")" ?></td>
                    <td>
                      <center>
                        <input type="hidden" value="<?php echo $row->branch_guid; ?>" name="branch_guid[]" />
                        <input type="hidden" name="receipt_activate[]" 

                        <?php if($row->receipt_activate == 0)
                        {
                        echo 'value="0"';
                        }
                        else
                        {
                          echo 'value="1"';
                        }
                        ?>
                        ><input type="checkbox" name="activate[]" class="subject-list" 

                        <?php if($row->receipt_activate == '1')
                        {
                          echo "checked";
                        }; ?> onchange="this.previousSibling.value=1-this.previousSibling.value; activate_change_box()" />

                        <?php if($parameter->row('check_receipt_itemcode') == 2)
                        { ?>

                          <input type="number" name="activate_amount[]" class="input-sm" style="border-radius: 5px; width: 65px;" value="<?php echo $row->amount_activate; ?>" min="0" />

                        <?php }
                        else
                        { ?>

                          <input type="hidden" name="activate_amount[]" value="<?php echo $row->amount_activate; ?>" min="0" />

                        <?php } ?>

                      </center>
                    </td>
                    <td>
                      <center>
                        <!-- <input type="hidden" value="<?php echo $row->branch_guid; ?>" name="branch_guid[]" /> -->
                        <input type="hidden" name="receipt_lost[]" 

                        <?php if($row->receipt_lost == 0)
                        {
                        echo 'value="0"';
                        }
                        else
                        {
                          echo 'value="1"';
                        }
                        ?>
                        ><input type="checkbox" name="lost[]" class="subject-list"

                        <?php if($row->receipt_lost == '1')
                        {
                          echo "checked";
                        }; ?> onchange="this.previousSibling.value=1-this.previousSibling.value; lost_change_box()" />

                        <?php if($parameter->row('check_receipt_itemcode') == 2)
                        { ?>
                        
                          <input type="number" name="lost_amount[]" class="input-sm" style="border-radius: 5px; width: 65px;" value="<?php echo $row->amount_lost; ?>" min="0" />

                        <?php }
                        else
                        { ?>

                          <input type="hidden" name="lost_amount[]" value="<?php echo $row->amount_lost; ?>" min="0" />

                        <?php } ?>

                      </center>
                    </td>
                    <td>
                      <center>
                        <!-- <input type="hidden" value="<?php echo $row->branch_guid; ?>" name="branch_guid[]" /> -->
                        <input type="hidden" name="receipt_renew[]" 

                        <?php if($row->receipt_renew == 0)
                        {
                          echo 'value="0"';
                        }
                        else
                        {
                          echo 'value="1"';
                        }
                        ?>
                        ><input type="checkbox" name="renew[]" class="subject-list"

                        <?php if($row->receipt_renew == '1')
                        {
                          echo "checked";
                        }; ?> onchange="this.previousSibling.value=1-this.previousSibling.value; renew_change_box()" />

                        <?php if($parameter->row('check_receipt_itemcode') == 2)
                        { ?>
                        
                          <input type="number" name="renew_amount[]" class="input-sm" style="border-radius: 5px; width: 65px;" value="<?php echo $row->amount_renew; ?>" min="0" />

                        <?php }
                        else
                        { ?>

                          <input type="hidden" name="renew_amount[]" value="<?php echo $row->amount_renew; ?>" min="0" />

                        <?php } ?>

                      </center>
                    </td>
                    <td>
                      <center>
                        <!-- <input type="hidden" value="<?php echo $row->branch_guid; ?>" name="branch_guid[]" /> -->
                        <input type="hidden" name="receipt_sup[]" 

                        <?php if($row->receipt_sup == 0)
                        {
                        echo 'value="0"';
                        }
                        else
                        {
                          echo 'value="1"';
                        }
                        ?>
                        ><input type="checkbox" name="sup[]" class="subject-list"

                        <?php if($row->receipt_sup == '1')
                        {
                          echo "checked";
                        }; ?> onchange="this.previousSibling.value=1-this.previousSibling.value; sup_change_box()" />

                        <?php if($parameter->row('check_receipt_itemcode') == 2)
                        { ?>

                          <input type="number" name="sup_amount[]" class="input-sm" style="border-radius: 5px; width: 65px;" value="<?php echo $row->amount_sup; ?>" min="0" />

                        <?php }
                        else
                        { ?>

                          <input type="hidden" name="sup_amount[]" value="<?php echo $row->amount_sup; ?>" min="0" />

                        <?php } ?>
                        
                      </center>
                    </td>
                    <td>
                      <center>
                        <!-- <input type="hidden" value="<?php echo $row->branch_guid; ?>" name="branch_guid[]" /> -->
                        <input type="hidden" name="receipt_replace[]" 

                        <?php if($row->receipt_replace == 0)
                        {
                        echo 'value="0"';
                        }
                        else
                        {
                          echo 'value="1"';
                        }
                        ?>
                        ><input type="checkbox" name="replace[]" class="subject-list"

                        <?php if($row->receipt_replace == '1')
                        {
                          echo "checked";
                        }; ?> onchange="this.previousSibling.value=1-this.previousSibling.value; replace_change_box()" />

                        <?php if($parameter->row('check_receipt_itemcode') == 2)
                        { ?>

                          <input type="number" name="replace_amount[]" class="input-sm" style="border-radius: 5px; width: 65px;" value="<?php echo $row->amount_replace; ?>" min="0" />

                        <?php }
                        else
                        { ?>

                          <input type="hidden" name="replace_amount[]" value="<?php echo $row->amount_replace; ?>" min="0" />

                        <?php } ?>
                        
                      </center>
                    </td>
                    <td>

                      <center>
                        <!-- <input type="hidden" value="<?php echo $row->branch_guid; ?>" name="branch_guid[]" /> -->
                        <input type="hidden" name="receipt_upgrade[]" 

                        <?php if($row->receipt_upgrade == 0)
                        {
                        echo 'value="0"';
                        }
                        else
                        {
                          echo 'value="1"';
                        }
                        ?>
                        ><input type="checkbox" name="upgrade[]" class="subject-list"

                        <?php if($row->receipt_upgrade == '1')
                        {
                          echo "checked";
                        }; ?> onchange="this.previousSibling.value=1-this.previousSibling.value; upgrade_change_box()" />

                        <?php if($parameter->row('check_receipt_itemcode') == 2)
                        { ?>

                          <input type="number" name="upgrade_amount[]" class="input-sm" style="border-radius: 5px; width: 65px;" value="<?php echo $row->amount_upgrade; ?>" min="0" />

                        <?php }
                        else
                        { ?>

                          <input type="hidden" name="upgrade_amount[]" value="<?php echo $row->amount_upgrade; ?>" min="0" />

                        <?php } ?>
                        
                      </center>
                    </td>
                  </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </div>
        <!-- /.col -->
      <!-- /.row -->
      

      <div class="tab-pane" id="panel-33">
        <div class="row">
        <div class="col-md-8">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="color:blue">Setting (Check Digit)</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                <button class="btn btn-xs btn-success" onclick="$('#formSCD').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save_check_digit'); ?>?table=set_parameter" id="formSCD" class="formSCD">
              <table class="table">
                <tr>
                  <th style="width: 100px;">Type</th>
                  <th style="width: 80px;">Active</th>
                </tr>
                <tr>
                  <td>Pre-issue Member card</td>
                  <td>
                    <input type="checkbox" name="check_digit_card" class="subject-list" 

                    <?php if($parameter->row('check_digit_card') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td>
                </tr>
                <tr>
                  <td>Voucher Setup</td>
                  <td>
                    <input type="checkbox" name="check_digit_voucher" class="subject-list" 

                    <?php if($parameter->row('check_digit_voucher') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td>
                </tr>
                <!-- <tr>
                  <td>Voucher Activation</td>
                  <td>
                    <input type="checkbox" name="check_digit_voucher_activation" class="subject-list" 

                    <?php if($parameter->row('check_digit_voucher_activation') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td>
                </tr> -->
              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      </div>
        <!-- /.col -->
     
       <div class="tab-pane" id="panel-44">
        <div class="row">
        <div class="col-md-8" 

        <?php
        if($parameter->row('check_receipt_itemcode') == 0 || $parameter->row('check_receipt_itemcode') == 2)
        {
          echo "hidden";
        }
        ?> >
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="color:blue">Setting (Item Code)</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSIC').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save_itemcode'); ?>?table=set_itemcode" id="formSIC" class="formSIC">
              <table class="table">
                <tr>
                  <td><label>Type</label></td>
                  <td style="width: 140px;"><center><label>Item Code</label></center></td>
                  <!-- <td style="width: 190px;"><center><label>Description</label></center></td> -->
                  <td></td>
                </tr>
                <tr>
                  <td>Supplementary Card</td>
                  <td>
                    <input type="number" name="supcard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $supcard->row('itemcode'); ?>" />
                  </td>
                  <td>
                    <!-- <input type="text" name="supcard_desc" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $supcard->row('description'); ?>" /> -->
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Lost Card</td>
                  <td style="width: 80px;">
                    <input type="number" name="lostcard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $lostcard->row('itemcode'); ?>" />
                  </td>
                  <td>
                    <!-- <input type="text" name="lostcard_desc" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $lostcard->row('description'); ?>" /> -->
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Renew Card</td>
                  <td style="width: 80px;">
                    <input type="number" name="newcard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $newcard->row('itemcode'); ?>" />
                  </td>
                  <td>
                    <!-- <input type="text" name="newcard_desc" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $newcard->row('description'); ?>" /> -->
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Activate Card</td>
                  <td style="width: 80px;">
                    <input type="number" name="activecard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $activecard->row('itemcode'); ?>" />
                  </td>
                  <td>
                    <!-- <input type="text" name="activecard_desc" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $activecard->row('description'); ?>" /> -->
                  </td>
                  <td></td>
                </tr>
                <tr>

                  <td>Replace Card</td>
                  <td style="width: 80px;">
                    <input type="number" name="replacecard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $replacecard->row('itemcode'); ?>" />
                  </td>
                  <td>
                    <!-- <input type="text" name="activecard_desc" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $activecard->row('description'); ?>" /> -->
                  </td>
                  <td></td>
                </tr>
                <tr>

                  <td>Upgrade Card</td>
                  <td style="width: 80px;">
                    <input type="number" name="upgradecard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $upgradecard->row('itemcode'); ?>"
                  </td>
                </tr>
              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <!-- /.col -->
        <div class="col-md-8"

        <?php
        if($parameter->row('check_receipt_itemcode') == 1 || $parameter->row('check_receipt_itemcode') == 2)
        {
          echo "hidden";
        }
        ?> >
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="color:blue">Setting (Receipt No.)</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSRN').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save_receipt_no'); ?>?table=set_parameter" id="formSRN" class="formSRN">
              <table class="table">
                <tr>
                  <th style="width: 120px;">Functions</th>
                  <!-- <th style="width: 80px;">Show</th> -->
                  <th style="width: 80px;">Amount</th>
                </tr>
                <tr>
                  <td>Issue sup card</td>
                  <!-- <td>
                    <input type="checkbox" name="receipt_no_supcard" class="subject-list" 

                    <?php if($parameter->row('receipt_no_supcard') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td> -->

                  <td>
                    <input type="number" name="receipt_no_amount_supcard" class="form-control input-sm" style="border-radius: 10px; width: 60px;" value="<?php echo $parameter->row('receipt_no_amount_supcard'); ?>" min="0" />
                  </td>
                </tr>
                <tr>
                  <td>Replace Lost Card</td>
                  <!-- <td>
                    <input type="checkbox" name="receipt_no_lostcard" class="subject-list" 

                    <?php if($parameter->row('receipt_no_lostcard') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td> -->

                  <td>
                    <input type="number" name="receipt_no_amount_lostcard" class="form-control input-sm" style="border-radius: 10px; width: 60px;" value="<?php echo $parameter->row('receipt_no_amount_lostcard'); ?>" min="0" />
                  </td>
                </tr>
                <tr>
                  <td>Activate Card</td>
                  <!-- <td>
                    <input type="checkbox" name="receipt_no_activerenew" class="subject-list" 

                    <?php if($parameter->row('receipt_no_activerenew') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td> -->

                  <td>
                    <input type="number" name="receipt_no_amount_active" class="form-control input-sm" style="border-radius: 10px; width: 60px;" value="<?php echo $parameter->row('receipt_no_amount_active'); ?>" min="0" />
                  </td>
                </tr>
                <tr>
                  <td>Renew Card</td>
                  <!-- <td>
                    <input type="checkbox" name="receipt_no_activerenew" class="subject-list" 

                    <?php if($parameter->row('receipt_no_activerenew') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td> -->

                  <td>
                    <input type="number" name="receipt_no_amount_renew" class="form-control input-sm" style="border-radius: 10px; width: 60px;" value="<?php echo $parameter->row('receipt_no_amount_renew'); ?>" min="0" />
                  </td>
                </tr>
                <tr>
                  <td>Replace Card</td>
                  <!-- <td>
                    <input type="checkbox" name="receipt_no_activerenew" class="subject-list" 

                    <?php if($parameter->row('receipt_no_replacecard') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td> -->

                  <td>
                    <input type="number" name="receipt_no_amount_replace" class="form-control input-sm" style="border-radius: 10px; width: 60px;" value="<?php echo $parameter->row('receipt_no_amount_replace'); ?>" min="0" />
                  </td>
                </tr>
                <tr>

                  <td>Upgrade Card</td>
                  <td>
                    <input type="number" name="receipt_no_amount_upgrade" class="form-control input-sm" style="border-radius: 10px; width: 60px;" value="<?php echo $parameter->row('receipt_no_amount_upgradecard'); ?>" min="0" />
                  </td>
                </tr>
              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>  
    </div> 
      </div>
      </div>
    </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

<script type="text/javascript">
  function selectall_activate(source) {
    /*document.getElementsById('foo').value = 2;*/
    activate = document.getElementsByName('activate[]');
    for(var i=0, n=activate.length;i<n;i++) {
      activate[i].checked = source.checked;
      
    }
  }

  function printfield_activate() {
    /*var formSBNC = document.getElementById("formSBNC");*/
      var checkBox = document.getElementById("activate");
      var text = document.getElementsByName("receipt_activate[]");
      var activate_amount = document.getElementsByName("activate_amount[]");
      //var text = document.forms["formSBNC"].elements["receipt_activate[]"];
      for(var i=0, n=text.length;i<n;i++) {
        if (checkBox.checked == true){
            text[i].value = "1";
            activate_amount[i].style.display = "inline-block";
        } else {
            text[i].value = "0";
            activate_amount[i].style.display = "none";
        }
      }
  }

  function activate_change_box() {
    /*document.getElementsById('foo').value = 2;*/
    var activate = document.getElementsByName('activate[]');
    var activate_amount = document.getElementsByName("activate_amount[]");
    for(var i=0, n=activate.length;i<n;i++) {
      if (activate[i].checked == true){
          activate_amount[i].style.display = "inline-block";
      } else {
          activate_amount[i].style.display = "none";
      }
    }
  }
</script>

<script type="text/javascript">
  function selectall_lost(source) {
    /*document.getElementsById('foo').value = 2;*/
    lost = document.getElementsByName('lost[]');
    for(var i=0, n=lost.length;i<n;i++) {
      lost[i].checked = source.checked;
      
    }
  }

  function printfield_lost() {
    /*var formSBNC = document.getElementById("formSBNC");*/
      var checkBox = document.getElementById("lost");
      var text = document.getElementsByName("receipt_lost[]");
      var lost_amount = document.getElementsByName("lost_amount[]");
      //var text = document.forms["formSBNC"].elements["receipt_activate[]"];
      for(var i=0, n=text.length;i<n;i++) {
        if (checkBox.checked == true){
            text[i].value = "1";
            lost_amount[i].style.display = "inline-block";
        } else {
            text[i].value = "0";
            lost_amount[i].style.display = "none";
        }
      }
  }

  function lost_change_box() {
    /*document.getElementsById('foo').value = 2;*/
    var lost = document.getElementsByName('lost[]');
    var lost_amount = document.getElementsByName("lost_amount[]");
    for(var i=0, n=lost.length;i<n;i++) {
      if (lost[i].checked == true){
          lost_amount[i].style.display = "inline-block";
      } else {
          lost_amount[i].style.display = "none";
      }
    }
  }
</script>

<script type="text/javascript">
  function selectall_renew(source) {
    /*document.getElementsById('foo').value = 2;*/
    renew = document.getElementsByName('renew[]');
    for(var i=0, n=renew.length;i<n;i++) {
      renew[i].checked = source.checked;
      
    }
  }

  function printfield_renew() {
    /*var formSBNC = document.getElementById("formSBNC");*/
      var checkBox = document.getElementById("renew");
      var text = document.getElementsByName("receipt_renew[]");
      var renew_amount = document.getElementsByName("renew_amount[]");
      //var text = document.forms["formSBNC"].elements["receipt_activate[]"];
      for(var i=0, n=text.length;i<n;i++) {
        if (checkBox.checked == true){
            text[i].value = "1";
            renew_amount[i].style.display = "inline-block";
        } else {
            text[i].value = "0";
            renew_amount[i].style.display = "none";
        }
      }
  }

  function renew_change_box() {
    /*document.getElementsById('foo').value = 2;*/
    var renew = document.getElementsByName('renew[]');
    var renew_amount = document.getElementsByName("renew_amount[]");
    for(var i=0, n=renew.length;i<n;i++) {
      if (renew[i].checked == true){
          renew_amount[i].style.display = "inline-block";
      } else {
          renew_amount[i].style.display = "none";
      }
    }
  }

</script>

<script type="text/javascript">
  function selectall_sup(source) {
    /*document.getElementsById('foo').value = 2;*/
    sup = document.getElementsByName('sup[]');
    for(var i=0, n=sup.length;i<n;i++) {
      sup[i].checked = source.checked;
      
    }
  }

  function printfield_sup() {
    /*var formSBNC = document.getElementById("formSBNC");*/
      var checkBox = document.getElementById("sup");
      var text = document.getElementsByName("receipt_sup[]");
      var sup_amount = document.getElementsByName("sup_amount[]");
      //var text = document.forms["formSBNC"].elements["receipt_activate[]"];
      for(var i=0, n=text.length;i<n;i++) {
        if (checkBox.checked == true){
            text[i].value = "1";
            sup_amount[i].style.display = "inline-block";
        } else {
            text[i].value = "0";
            sup_amount[i].style.display = "none";
        }
      }
  }

  function sup_change_box() {
    /*document.getElementsById('foo').value = 2;*/
    var sup = document.getElementsByName('sup[]');
    var sup_amount = document.getElementsByName("sup_amount[]");
    for(var i=0, n=sup.length;i<n;i++) {
      if (sup[i].checked == true){
          sup_amount[i].style.display = "inline-block";
      } else {
          sup_amount[i].style.display = "none";
      }
    }
  }
</script>

<script type="text/javascript">
  function selectall_replace(source) {
    /*document.getElementsById('foo').value = 2;*/
    sup = document.getElementsByName('replace[]');
    for(var i=0, n=sup.length;i<n;i++) {
      sup[i].checked = source.checked;
      
    }
  }

  function printfield_replace() {
    /*var formSBNC = document.getElementById("formSBNC");*/
      var checkBox = document.getElementById("replace");
      var text = document.getElementsByName("receipt_replace[]");
      var replace_amount = document.getElementsByName("replace_amount[]");
      //var text = document.forms["formSBNC"].elements["receipt_activate[]"];
      for(var i=0, n=text.length;i<n;i++) {
        if (checkBox.checked == true){
            text[i].value = "1";
            replace_amount[i].style.display = "inline-block";
        } else {
            text[i].value = "0";
            replace_amount[i].style.display = "none";
        }
      }
  }

  function replace_change_box() {
    /*document.getElementsById('foo').value = 2;*/
    var replace = document.getElementsByName('replace[]');
    var replace_amount = document.getElementsByName("replace_amount[]");
    for(var i=0, n=replace.length;i<n;i++) {
      if (replace[i].checked == true){
          replace_amount[i].style.display = "inline-block";
      } else {
          replace_amount[i].style.display = "none";
      }
    }
  }
</script>
<script type="text/javascript">
  function selectall_upgrade(source) {
    /*document.getElementsById('foo').value = 2;*/
    upgrade = document.getElementsByName('upgrade[]');
    for(var i=0, n=upgrade.length;i<n;i++) {
      upgrade[i].checked = source.checked;
    }
  }

  function printfield_upgrade() {
    var checkbox = document.getElementById("upgrade");
    var text = document.getElementsByName("receipt_upgrade[]");
    var upgrade_amount = document.getElementsByName("upgrade_amount[]");

    for(var i=0, n=text.length; i<n; i++) {
      if(checkbox.checked == true) {
        text[i].value = "1";
        upgrade_amount[i].style.display = "inline-block";
      }
      else
      {
        text[i].value = "0";
        upgrade_amount[i].style.display = "none";
      }
    }
  }

  function upgrade_change_box() {
    var upgrade = document.getElementsByName('upgrade[]');
    var upgrade_amount = document.getElementsByName('upgrade_amount[]');

    for(var i=0, n=upgrade.length;i<n;i++)
    {
      if(upgrade[i].checked == true)
      {
        upgrade_amount[i].style.display = "inline-block";
      }
      else
      {
        upgrade_amount[i].style.display = "none";
      }
    }
  }
</script>

<script type="text/javascript">
  // get list of radio buttons with name 'size'
  var sz = document.forms['formSN'].elements['radioname'];
  // loop through list
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() { // assign onclick handler function to each
          // put clicked radio button's value in total field
          this.form.elements.name.value = this.value;
      };
  }
</script>

<script type="text/javascript">

  var sz = document.forms['formSO'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formSR'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formSRe'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formSRel'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formSS'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formST'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

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

    function edit_nationality()
    {
      $('#nationality').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_occupation()
    {
      $('#occupation').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_race()
    {
      $('#race').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_relationship()
    {
      $('#relationship').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_religion()
    {
      $('#religion').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_status()
    {
      $('#status').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_title()
    {
      $('#title').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_cardtype()
    {
      $('#cardtype').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="value"]').val(button.data('value'))
        modal.find('[name="orivalue"]').val(button.data('orivalue'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function add_nationality()
    {
      save_method = 'add';
      $('#nationality').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_occupation()
    {
      save_method = 'add';
      $('#occupation').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_race()
    {
      save_method = 'add';
      $('#race').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_relationship()
    {
      save_method = 'add';
      $('#relationship').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_religion()
    {
      save_method = 'add';
      $('#religion').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_status()
    {
      save_method = 'add';
      $('#status').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_title()
    {
      save_method = 'add';
      $('#title').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_cardtype()
    {
      save_method = 'add';
      $('#cardtype').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

</script>

<div class="modal fade" id="delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="text-align: center">Confirm Delete?</h3>
            </div> -->
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

<div class="modal fade" id="nationality" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_nationality')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nationality</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
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

<div class="modal fade" id="occupation" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_occupation')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Occupation</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
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

<div class="modal fade" id="race" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_race')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Race</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
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

<div class="modal fade" id="relationship" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_relationship')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Relationship</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
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

<div class="modal fade" id="religion" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_religion')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Religion</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
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

<div class="modal fade" id="status" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_status')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
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

<div class="modal fade" id="title" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_title')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Title</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
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

<div class="modal fade" id="cardtype" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_cardtype')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <input type="hidden" value="" name="orivalue"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Card Type</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-3">Pricing Type</label>
                            <div class="col-md-9">
                                <input name="value" class="form-control" type="text" required maxlength="60">
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


<script type="text/javascript">
  
  function myFunction() {
  // Get the checkbox
  var checkBox = document.getElementById("myCheck");
  // Get the output text
  var text = document.getElementById("text");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
    text.style.display = "none";
  }
}

</script>