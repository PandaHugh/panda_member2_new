<?php 
'session_start()' 
?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
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

#scroll {
  height: 250px;
  overflow-y: scroll;
}

</style>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

function FillBilling(f) {
  
    f.prefixvalue.value = f.prefix.value;
    /*f.runningnos.value = f.runningno.value;*/
}

</script>
<script>

/*window.onload = function() 
{
    // If values are not blank, restore them to the fields
    var card1 = sessionStorage.getItem('cardtype');
    if (card1 !== null) $('#card').val(card1);

    var card1 = sessionStorage.getItem('branch');
    if (card1 !== null) $('#branches').val(card1);
}*/

window.onbeforeunload = function() 
{
    sessionStorage.setItem("cardtype", $('#card').val());
    sessionStorage.setItem("branch", $('#branches').val());
}

</script>
<!--onload Init-->
<body>
    
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
    <section class="content-header">
      <h1>Pre-Issue Card</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <form name="myform" method="post" action="<?php echo site_url('Transaction_c/create_pre_issue_card'); ?>">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Prefix Code <a style="color:red;">*</a></label>
                <input type="text" id="pre" name="prefix" class="form-control" placeholder="Prefix Code" value="<?php echo $prefix_in; ?>" onkeydown="upperCaseF(this)" onchange="FillBilling(this.form)" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Card Type <a style="color:red;">*</a></label>
                <select name="cardtype" class="form-control" id="card" required>
                  <!-- <option disabled hidden></option> -->

                  <?php foreach($cardtype->result() as $row)
                  { ?>

                  <option value="<?php echo $row->CardType?>"
                    <?php
                    if($row->Preset == 1)
                    {
                      echo 'selected';
                    }
                    ?>
                    ><?php echo $row->CardType?></option>
                  
                  <?php } ?>

                </select>
              </div>
              <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" id="remark" name="remark" rows="3" placeholder="Remarks"><?php echo $remark_in; ?></textarea>
              </div>
              
            </div>
            <!-- /.col -->
            <div class="col-md-4">
              
              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>From <a style="color:red;">*</a></label>
                  <input type="number" id="nofrom" min="0" step="any" name="nofrom" class="form-control" placeholder="Number From" value="<?php echo $nofrom_in; ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>To <a style="color:red;">*</a></label>
                  <input type="number" id="noto" min="0" name="noto" class="form-control" placeholder="Number To" value="<?php echo $noto_in; ?>" required>
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Suffix Digit <a style="color:red;">*</a></label>
                  <input type="number" id="suf" min="1" name="runningno" class="form-control" placeholder="Suffix Digit" max="20" value="<?php echo $suffix_in; ?>" onchange="FillBilling(this.form)" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Branch</label>
                  <select class="form-control" name="branch" id='branch' required>
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
               
              </div>
              </div>

              
            </div>
            <!-- /.col -->
            <div class="col-md-4">
              
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
          <div class="col-md-4">
            <br>
            
            <button title="Edit" id="create" type="button" class="btn btn-success pull-left" data-toggle="modal" data-name='prefixvalue' data-oriname="runningnos" >Create</button>

          </div> 
          </div>
        </div>
        <!-- /.box-body -->
        </form>
      </div>
      <!-- /.box -->
      <div class="box box-default">
        
        <div class="box">
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <!-- <th>Branch</th> -->
                <th>Prefix</th>
                <th>From</th>
                <th>To</th>
                <th>Branch</th>
                <th>Remarks</th>
                <th>Created by</th>
                <th>Created at</th>
                <th>Updated by</th>
                <th>Updated at</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($mem_issue_card->result() as $row)
                { ?>

                <tr>
                  <!-- <td><?php echo $row->branch; ?></td> -->
                  <td><?php echo $row->PREFIX; ?></td>
                  <td><?php echo $row->CARDNO_FROM; ?></td>
                  <td><?php echo $row->CARDNO_TO; ?></td>
                  <td><?php echo $row->branch; ?></td>
                  <td><?php echo $row->REMARK; ?></td>
                  <td><?php echo $row->CREATED_BY; ?></td>
                  <td><?php echo $row->CREATED_AT; ?></td>
                  <td><?php echo $row->UPDATED_BY; ?></td>
                  <td><?php echo $row->UPDATED_AT; ?></td>
                </tr>
                
                <?php } ?>
                
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.box -->
    </section>

<script type="text/javascript">

$('#create').click(function() {
    
    //alternative way to get user input
    /*var prefix_value = document.getElementById("pre").value;
    var suffix_value = document.getElementById("suf").value;
    var card_value = document.getElementById("card").value;
    var nofrom_value = document.getElementById("nofrom").value;
    var noto_value = document.getElementById("noto").value;
    var remark_value = document.getElementById("remark").value;*/
    
    var test1 = $('#pre').val();
    var test2 = $('#suf').val();
    var test3 = $('#nofrom').val();
    var test4 = $('#noto').val();
    var test5 = $('#card').val();
    var test6 = $('#remark').val();
    var test7 = $('#branch').val();

    var str = ""+  test1;
    var pad = '0'.repeat(test2);
    var ans = test1 + pad.substring(test3.length) + test3 ;

    var result = test1.length;
    var z = parseInt(result) + parseInt(test2);

    var from_length = test3.length;
    var to_length = test4.length;

    var x = document.forms["myform"]["prefix"].value;
    var y = document.forms["myform"]["nofrom"].value;
    var a = document.forms["myform"]["runningno"].value;
    var b = document.forms["myform"]["noto"].value;
    var c = document.forms["myform"]["cardtype"].value;

    if (x == null || x == "" || y == null || y == "" || a == null || a == "" || b == null || b == "" || c == null || c == "")
    {
      alert("Please fill in required field");
      return false;
    }

    if (from_length > test2 || to_length > test2)
    {
      $('#\\#fail').modal('show');
      document.getElementById('msg1').innerHTML = "Length of input value 'From' exceeded suffix digit.";
      return false;
    }

    if (parseInt(test3) > parseInt(test4))
    {
      $('#\\#fail').modal('show');
      document.getElementById('msg1').innerHTML = "To value must be more than from value";
      return false;
    }

    if (z <= "20") {
      $('#\\#success').modal('show');
      $(".modal-body #prefix").val( test1 );
      $(".modal-body #suffix").val( test2 );
      $(".modal-body #card").val( test5 );
      $(".modal-body #from").val( test3 );
      $(".modal-body #to").val( test4 );
      $(".modal-body #remark").val( test6 );
      $(".modal-body #branch").val( test7 );
      document.getElementById('msg').innerHTML = ans;
    }
    else {
      $('#\\#fail').modal('show');
      document.getElementById('msg1').innerHTML = "Length of prefix code + suffix digit cannot be more than 20";
    }
});

</script>


<div class="modal fade" id="#success">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title">Confirmation!</h4>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Transaction_c/create_pre_issue_card')?>" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-6">
                                <!-- <input id="msg" name="" class="form-control" type="text" required maxlength="60"> -->
                                <h2><center><div style="color:red;" id="msg"></div></center></h2>
                                <center><p><label>Please confirm your sample card no.</label><center>
                                <input name="sample" class="form-control" type="text" required maxlength="50"></p>
                                <input type="hidden" name="prefix" id="prefix" value=""/>
                                <input type="hidden" name="suffix" id="suffix" value=""/>
                                <input type="hidden" name="card" id="card" value=""/>
                                <input type="hidden" name="from" id="from" value=""/>
                                <input type="hidden" name="to" id="to" value=""/>
                                <input type="hidden" name="remark" id="remark" value=""/>
                                <input type="hidden" name="branch" id="branch" value=""/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="#fail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title" style="color:red;">Reminder!</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_race')?>" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                      <!-- <center><strong><p>Length of prefix code + suffix digit cannot be more than 20</p></strong></center> -->
                      <h2><center><div id="msg1"></div></center></h2>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <!-- <button type="submit" class="btn btn-sm btn-primary">Save</button> -->
                      <center><button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" >OK </button></center>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>