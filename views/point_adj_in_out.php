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

#scroll {
  height: 250px;
  overflow-y: scroll;
}

a.print {
    text-decoration: none;
    display: inline-block;
    width: 40px;
    margin: auto;
    background: #4380B8;
    background: linear-gradient(#4380B8);
    text-align: center;
    color: #fff;
    padding: 3px 6px;
    border-radius: 3px;
    border: 1px solid;
}


</style>

<body onload="sum()">

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

        <!-- <h1 class="page-head-line">
            <a href="<?php echo site_url('main_c')?>" class="btn btn-default btn-xs"  style="float:right;" >
              <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
        </h1> -->
            <!-- <h1 class="page-subhead-line"></h1> -->
      </div>
  </div>

  <div class="row">
    <div class="col-md-12">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <!-- <h1 class="page-head-line">
          <a href="<?php echo site_url('Point_c')?>?column=<?php echo $column; ?>" class="btn btn-default btn-xs"  style="float:right;" >
            <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
      </h1> -->
      <h1><?php echo $title; ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header">
            <!-- <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('Point_c/add_voucher'); ?>?guid=<?php echo $guid; ?>&condition=<?php echo $column; ?>">
            <div style="float:left;">
              <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white" 

              <?php if($post == '1')
              {
                echo "disabled";
              };?>>
              <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> Add Voucher</b></button>
            </div>
            </form> -->

          <?php
          if($edit == '1')
          { ?>

            <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('Point_c/post'); ?>?guid=<?php echo $guid; ?>&condition=<?php echo $column; ?>">
            <div style="float:right;">
              <!-- <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
              <span style="color:white"></span><b> Post</b></button> -->
              <button title="Post" id="post" type="button" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white" data-toggle="modal" data-name="" data-oriname="" ><span style="color:white"></span><b> Post</b></button>
            </div>
            </form>

          <?php };
          if($edit == '3')
          { ?>

            <div style="float:right;">
            <!-- <button onclick="myFunction()" class="print"><span class="glyphicon glyphicon-print"></span></button> -->
            <a href="<?php echo site_url('Point_c/add_point_adj_in_out?column='.$column.'&accountno=&guid='); ?>" title="Add new Voucher" class="print" style="background:green;"><i class="glyphicon glyphicon-plus"></i></a>
            <a href="<?php echo site_url('Point_c/print_report'); ?>?guid=<?php echo $guid; ?>&column=<?php echo $_REQUEST['column']; ?>" target="_blank" title="Print Report" class="print"><i class="glyphicon glyphicon-file"></i></a>
            </div>

            <?php
             $customized_voucher_no = $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no');
            if($title == 'Voucher Redemption' && $customized_voucher_no != 2)
            { ?>

              <div style="float:right;">
              <!-- <button onclick="myFunction()" class="print"><span class="glyphicon glyphicon-print"></span></button> -->
              <a href="<?php echo site_url('Point_c/print_voucher'); ?>?guid=<?php echo $guid; ?>" target="_blank" title="Print Voucher" class="print"><i class="glyphicon glyphicon-tag"></i></a>
              </div>

            <?php };

          }; ?>
          
          <center>
          <br>
            <form class="form-inline" role="form" method="POST" id="myForm" 
            action="<?php echo site_url('Point_c/search'); ?>?condition=<?php echo $column; ?>&accountno=<?php echo ''; ?>&guid=<?php 
            if($_REQUEST['guid'] != '' || $_REQUEST['guid'] != NULL )
            {
              echo $_REQUEST['guid'];
            }
            else
            {
              echo '';
            }
            ?>">
                <div class="form-group">
                    <select name="search"  class="form-control" id="sel1" style="background-color:white;color:black;width: 175px;margin-bottom: 5px" required>
                          <!--<option hidden>Search by:</option>-->
                          <option value="Card">Card No:</option>
                          <option value="Name">Name:</option>
                          <option value="Ic">Ic No:</option>
                          <option value="Passport">Passport No:</option>
                    </select>
                    <span class="input-group-btn">
                    <input type="text" class="form-control" placeholder="Search Member" name="memberno" id="textarea" required autofocus

                    <?php if($edit == '1' || $edit == '2' || $edit == '3')
                    {
                      echo "readonly";
                    }; ?>/>

                    </span>
                </div>
            </form><br>
          </center>
        </div>
        <form method="post" action="<?php echo $action; ?>"" id="myForm1" class="myForm1">
        <div class="box-body">
          <div class="row">
            <!-- /.col -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Reference No. </label>
                <input type="text" id="Reference" name="Reference" value="<?php echo $Reference; ?>" class="form-control" placeholder="Reference No" readonly>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Account No. </label>
                    <input type="text" id="Code" name="Code" value="<?php echo $Code; ?>" class="form-control" placeholder="Account No." readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Card No. </label>
                    <input type="text" id="Cardno" name="Cardno" value="<?php echo $Cardno; ?>" class="form-control" placeholder="Card No." readonly>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" id="Remarks" name="Remarks" rows="5" placeholder="Remarks" 
                <?php if($edit == '1')
                {
                  echo "readonly";
                }; ?>><?php echo $Remarks; ?></textarea>
              </div>
              <!-- /.form-group --> 
            </div>
            <!-- /.col -->
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="Name" value="<?php echo $Name; ?>" name="Name" placeholder="Name" readonly/>
                  </div>
                </div> 
              </div>

              <div class="row">
                <!-- <div class="col-md-12">
                  <div class="form-group">
                    <label>Date</label>
                    <input type="text" class="form-control" id="Name" value="<?php echo $Name; ?>" name="Name" placeholder="Name" readonly/>
                  </div>
                </div> -->
                <div class="col-md-12">
                  <div class="form-group">
                  <label>Date</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" id="datepicker" placeholder="Date" class="form-control" name="Date" 

                    <?php if($Date != '')
                    { ?>
                      value="<?php echo date("Y-m-d", strtotime($Date)) ?>";
                    <?php }
                    else
                    { ?>
                      value="";
                    <?php } ?> readonly>
                  </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                  <label>Branch<a style="color:red;">*</a></label>
                  <select name="Branch" class="form-control" id="Branch" placeholder="Branch" required="required" 

                  <?php if($edit == '1')
                  {
                    echo "disabled";
                  }; ?>><?php if($edit != ''){ ?>
                    <option selected data-default style="display: none; "><?php echo $branch_result;?></option>
                  <?php } ?>
                  <?php
                    if(!isset($_REQUEST['edit']))
                    {
                      if(sizeof($branch) > '1')
                      {
                  ?>
                        <option hidden selected value> -- Select a branch -- </option>
                  <?php
                      }
                    }
                  ?>
                    <?php foreach($branch as $row)
                    { ?>

                        <option required value="<?php echo $row['branch_name']; echo "&nbsp (".$row['branch_code'].")"?>"><?php echo $row['branch_name']; echo "&nbsp (".$row['branch_code'].")"?></option>

                    <?php } ?>

                  </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                  <label>Reason <a style="color:red;">*</a></label>
                  <select name="Reason" class="form-control" id="Reason" placeholder="Reason" required 

                  <?php if($edit == '1')
                  {
                    echo "disabled";
                  }; ?>>
                    <option selected data-default style="display: none; "><?php echo $reason;?></option>

                    <?php foreach($select_reason->result() as $row)
                    { ?>

                        <option required value="<?php echo $row->reason;?>"><?php echo $row->reason;?></option>

                    <?php } ?>

                  </select>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Point Before </label>
                    <input type="number" min="0" step="any" value="<?php echo $Point_Before; ?>" name="Point_Before" id="Point_Before" class="form-control" placeholder="Point Before" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <?php if ($column == 'POINT_REDEEM' || $column == 'ITEM_REDEEM')
                    {
                      ?>
                      <label>Total Point Used </label>
                      <?php
                    }
                    else
                    {
                      ?>
                      <label>Total Point Adjust </label>
                      <?php
                    }

                    ?>
                    <input type="number" min="0.00" step="0.00" name="value_total" value="<?php echo $value_total; ?>" id="value_total" class="form-control" placeholder=" Total Point Adjust" readonly>

                    <input type="hidden" name="Point_Adjust" value="<?php echo $value_total; ?>" id="Point_Adjust" class="form-control">

                    <input type="hidden" name="total" value="<?php echo $Point_Adjust; ?>" id="total" class="form-control">
                  </div>
                  <!-- <div class="form-group">
                      <div>
                        <input type="checkbox" id="post" name="post" 

                        <?php if($post == '1')
                        { 
                          echo "checked disabled";
                        }; ?>/>
                        <label for="post"><span></span><h4><b>Post</b></h4></label>
                      </div>
                  </div> -->
                </div> 
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Point Balance </label>
                    <input type="number" id="Point_Balance" min="0" value="<?php echo $Point_Balance; ?>" name="Point_Balance" class="form-control" placeholder="Point Balance" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Qty</label>
                    <input type="hidden" name="test" value="<?php echo $customized_voucher_no?>" id="test" class="form-control">
                    <input type="hidden" name="check_digit" value="<?php echo $check_digit?>" id="check_digit" class="form-control">
                    <input type="number" min="1" name="Qty" value="<?php echo $Qty; ?>" id="Qty" class="form-control" placeholder="Qty" onchange="sumtotal()" 
                    
                    <?php if($title == 'Voucher Redemption')
                    { 
                      echo "readonly"; 
                    }; ?> >
                    
                  </div>
                </div>
              </div>
              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Item <a style="color:red;">*</a></label>
                  <select name="Voucher_Type" class="form-control select2" id="Voucher_Type" onchange="sumtotal()" required>
                    <option selected data-default style="display: none; "><?php echo $Voucher_Type;?></option>

                    <?php foreach($voucher->result() as $row)
                    { 
                      if($title == 'Point Adjust-IN')
                      { ?>

                        <option required value="<?php echo $row->POINT_TYPE1;echo "=>";echo $row->ITEM_CODE;echo "=>";echo $row->ITEM_DESC;?>"><?php echo $row->POINT_TYPE1;echo " => ";echo $row->ITEM_CODE;echo " => ";echo $row->ITEM_DESC ?></option>

                      <?php }
                      else
                      { ?>

                        <option required value="<?php echo "-";echo $row->POINT_TYPE1;echo "=>";echo $row->ITEM_CODE;echo "=>";echo $row->ITEM_DESC;echo "=>";echo $row->PRICE  ?>"><?php echo "-";echo $row->POINT_TYPE1;echo " => ";echo $row->ITEM_CODE;echo " => ";echo $row->ITEM_DESC ?></option>

                      <?php } 
                    } ?>
                    
                  </select>
                  <span class="input-group-btn">
                  </span>
                </div>
              </div>
              </div>

              <?php 
              $customized_voucher_no = $this->db->query("SELECT customized_voucher_no FROM set_parameter ")->row('customized_voucher_no');

              if($title == 'Voucher Redemption' && $customized_voucher_no == '1')
              { ?>

                <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Voucher No. <a style="color:red;">*</a></label>
                    <input type="text" name="Voucher_No" value="<?php echo $Voucher_No; ?>" id="Voucher_No" class="form-control" placeholder="Voucher No." required />
                    
                    <span class="input-group-btn">
                    </span>
                  </div>
                </div>
                </div>

              <?php }; ?>

              <?php if($title == 'Voucher Redemption' && $customized_voucher_no == '2')
              { ?>

                <div class="row">
                  <div class="col-md-12">
                  <label>Voucher No. <a style="color:red;">*</a></label>
                  </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>From  </label>
                    <input type="text" name="Voucher_No_Start" value="<?php echo $Voucher_No_Start; ?>" id="Voucher_No_Start" class="form-control" placeholder="Voucher No."   onblur="voucher_from()" required autocomplete="off" />
                    <span class="input-group-btn">
                    </span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>To</label>
                   <input type="text" name="Voucher_No_End" value="<?php echo $Voucher_No_End; ?>" id="Voucher_No_End" class="form-control" placeholder="Voucher No."   onblur="check_voucher();voucher_from()" autocomplete="off" 
                   <?php if($Voucher_No_End == '--')
                   {
                    echo "readonly";
                   }?>
                   />
                    <span class="input-group-btn">
                    </span>
                  </div>
                </div>
              
                </div>

              <?php }; ?>

            </div>
          </div> 
          
         
      </div>
       <div class="row">
            <div class="col-md-4" style="margin-left: 20px;margin-bottom: 20px">
              <br>
              

           
            <Button type="submit" value="<?php echo $button; ?>" class="btn btn-success pull-left" style="float:right"

              <?php if($Reference && $Code != '')
              {
                if($post == '1')
                {
                  echo "disabled";
                }
                else
                {
                  echo " ";
                }
              }
              else
              {
                echo "disabled";
              } ?>><?php echo $button?></Button>
               </div> 
          </div>
        </div>
        <!-- /.box-body -->
      </form>


      <div class="box box-default">   
          <div class="box-body">
            <div style="overflow-x:auto;">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>

                <?php if($post == '0' || $post == '')
                { ?>

                  <th>Actions</th>

                <?php }; ?>

                <th>Item Code</th>
                <th><?php 
                if($column == 'POINT_REDEEM')
                  {
                    echo "Voucher No.";
                  }
                  else
                  {
                   echo "Description";
                  }?></th>
                <th>Qty</th>
                <th>Unit Value</th>
                <th>Value Total</th>
                <th>Created at</th>
                <th>Created by</th>
                <th>Updated at</th>
                <th>Updated by</th>
              </tr>
              </thead>
              <tbody>

              <?php if($trans_child != '')
              {
                foreach($trans_child->result() as $row)
                { ?>

                <tr>

                  <?php if($post == '0' || $post == '')
                  { ?>

                    <td>
                      <center><a href="<?php echo site_url('Point_c/edit_child'); ?>?guid=<?php echo $row->TRANS_GUID; ?>&chi_guid=<?php echo $row->CHILD_GUID; ?>&column=<?php echo $column; ?>&edit=2" title="Edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a> <button title="Delete" onclick="confirm_modal('<?php echo site_url('Point_c/delete'); ?>?guid=<?php echo $row->TRANS_GUID; ?>&chi_guid=<?php echo $row->CHILD_GUID; ?>&condition=<?php echo $column; ?>&table=trans_child&column=CHILD_GUID')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->ITEMCODE?>"><i class="glyphicon glyphicon-trash"></i></button><center>
                    </td>

                  <?php }; ?>

                  <td><?php echo $row->ITEMCODE; ?></td>
                  <td><?php 
                  if($column == 'POINT_REDEEM')
                  {
                  echo $row->cross_refno; 
                  }
                  else
                  {
                  echo $row->DESCRIPTION; 
                  }
                  ?></td>
                  <td><?php echo $row->QTY; ?></td>
                  <td><?php echo $row->VALUE_UNIT; ?></td>
                  <td><?php echo $row->VALUE_TOTAL; ?></td>
                  <td><?php echo $row->CREATED_AT; ?></td>
                  <td><?php echo $row->CREATED_BY; ?></td>
                  <td><?php echo $row->UPDATED_AT; ?></td>
                  <td><?php echo $row->UPDATED_BY; ?></td>
                </tr>
                
                <?php }
              } ?>
               
              </tbody>
                
            </table>
            </div>
          </div>
          <!-- /.box-body -->
      </div>
      <!-- /.box -->
      </section>
    </div>
  </div>

<script type="text/javascript">

function sum()
{
  document.getElementById("Point_Balance").value = parseFloat(parseFloat(document.getElementById("Point_Before").value) + parseFloat(document.getElementById("value_total").value));
}

function check_voucher()
{
  var Voucher_No_Start = document.getElementById("Voucher_No_Start").value;
  var Voucher_No_End = document.getElementById("Voucher_No_End").value;
  Voucher_No_Start = Voucher_No_Start.replace(/\D/g,'');
  Voucher_No_End = Voucher_No_End.replace(/\D/g,'');
  var check_digit = document.getElementById("check_digit").value;

  if(check_digit == 1)
  {
  Voucher_No_Start = Voucher_No_Start.slice(0, -1);
  Voucher_No_End = Voucher_No_End.slice(0, -1);
  }
  
  if(Voucher_No_Start > Voucher_No_End && Voucher_No_End != ''){
    alert("Voucher number must FROM smaller TO bigger!");
  }
}

function voucher_from()
{
  var point = document.getElementById("Voucher_Type").value;
  var split_point =  point.split("=>");
  var point_result = split_point[0];
  var Voucher_No_Start = document.getElementById("Voucher_No_Start").value;
  var Voucher_No_End = document.getElementById("Voucher_No_End").value;
  Voucher_No_Start = Voucher_No_Start.replace(/\D/g,'');
  Voucher_No_End = Voucher_No_End.replace(/\D/g,'');
  var check_digit = document.getElementById("check_digit").value;
  
  if(check_digit == 1)
  {
  Voucher_No_Start = Voucher_No_Start.slice(0, -1);
  Voucher_No_End = Voucher_No_End.slice(0, -1);
  }
  

  if(Voucher_No_End != null && Voucher_No_End != '')
  {
    document.getElementById("Qty").value = Voucher_No_End - Voucher_No_Start + 1;
    document.getElementById("value_total").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value) + parseFloat(document.getElementById("Point_Adjust").value));
    document.getElementById("Point_Balance").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value) + parseFloat(document.getElementById("Point_Before").value) + parseFloat(document.getElementById("Point_Adjust").value));
     
  }
  else
  {
    document.getElementById("Qty").value =1;
     document.getElementById("value_total").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value) + parseFloat(document.getElementById("Point_Adjust").value));
    document.getElementById("Point_Balance").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value) + parseFloat(document.getElementById("Point_Before").value) + parseFloat(document.getElementById("Point_Adjust").value));
    
  }
  
  
}

function sumtotal()
{
  var test = document.getElementById("test").value;
  if(test != 2)
  {
  var point = document.getElementById("Voucher_Type").value;
  var split_point =  point.split("=>");
  var point_result = split_point[0];

  document.getElementById("Point_Balance").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value) + parseFloat(document.getElementById("Point_Before").value) + parseFloat(document.getElementById("Point_Adjust").value));

  document.getElementById("total").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value));

  /*document.getElementById("Point_Balance").value = parseFloat(parseFloat(document.getElementById("Point_Before").value) + parseFloat(document.getElementById("value_total").value) + parseFloat(point_result) * parseFloat(document.getElementById("Qty").value));*/

  /*document.getElementById("Point_Adjust").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value));*/

  document.getElementById("value_total").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value) + parseFloat(document.getElementById("Point_Adjust").value));
  /*document.getElementById("value_total").value = parseFloat(parseFloat(point_result).toFixed(2) * parseFloat(document.getElementById("Qty").value).toFixed(2));*/
}

}


</script>

<script type="text/javascript">

$('#post').click(function() {
    
  /*var post = document.getElementById("post").value;*/
  var datepicker = $('#datepicker').val();
  var Code = $('#Code').val();
  var Point_Before = $('#Point_Before').val();
  var Point_Balance = $('#Point_Balance').val();
  var value_total = $('#value_total').val();
  var Reference = $('#Reference').val();
  var CardNo = $('#Cardno').val();

  if (Point_Balance < '0')
  {
    alert("Exceed Point Balance");
    return false;
  }

  $('#\\#post').modal('show');
  $(".modal-body #datepicker").val( datepicker );
  $(".modal-body #Code").val( Code );
  $(".modal-body #Point_Before").val( Point_Before );
  $(".modal-body #Point_Balance").val( Point_Balance );
  $(".modal-body #value_total").val( value_total );
  $(".modal-body #Reference").val( Reference );
  $(".modal-body #cardno").val(CardNo);
});

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

</script>

<div class="modal fade" id="delete" role="dialog" data-backdrop="static" data-keyboard="false">
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
        </div>
    </div>
</div>

<div class="modal fade" id="#post" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title">Confirmation!</h4>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Point_c/post')?>?guid=<?php echo $guid; ?>&condition=<?php echo $column; ?>" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-6">
                                <!-- <input id="msg" name="" class="form-control" type="text" required maxlength="60"> -->
                                <h2><center><div style="color:red;" id="msg"></div></center></h2>
                                <center><p><label>Are you sure want to post?</label><center>
                                <input type="hidden" name="datepicker" id="datepicker" value=""/>
                                <input type="hidden" name="Code" id="Code" value=""/>
                                <input type="hidden" name="Point_Before" id="Point_Before" value=""/>
                                <input type="hidden" name="Point_Balance" id="Point_Balance" value=""/>
                                <input type="hidden" name="value_total" id="value_total" value=""/>
                                <input type="hidden" name="Reference" id="Reference" value=""/>
                                <input type="hidden" name="cardno" id="cardno" value=""/>
                                <span class="help-block"></span>
                                <?php
                                  if($column == 'POINT_REDEEM' || $column == 'ITEM_REDEEM')
                                  {
                                ?>
                                  <div class="form-group">
                                    <label class="control-label col-md-3">
                                      <span style="color:red;">*</span> IC
                                    </label>
                                    <div class="col-md-9">
                                      <input type="text" class="form-control" name="tac" placeholder="Exp: XXXXXX012345 (Last 6 digits IC No)" required>
                                    </div>
                                  </div>
                                <?php
                                  }
                                ?>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer" style="text-align: center">
                      <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
