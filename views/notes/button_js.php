<!-- this script can be copied into local file -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


<form name="myform" method="post" action="">
	<div class="form-group">
	    <label>Prefix Code <a style="color:red;">*</a></label>
      <!-- onkeydown="" means every characters automatically be upper case -->
      <!-- id="" is used to link to javascript on passing value -->
	    <input type="text" id="pre" name="prefix" class="form-control" placeholder="Prefix Code" value="" onkeydown="upperCaseF(this)" required>
  </div>
  <div class="form-group">
	    <label>Card Type <a style="color:red;">*</a></label>
	    <select name="cardtype" class="form-control" id="card" required>
	      <option disabled hidden></option>
	      <option>Member</option>
	    </select>
	</div>
	<div class="form-group">
	    <label>Remarks</label>
	    <textarea class="form-control" id="remark" name="remark" rows="3" placeholder="Remarks"></textarea>
	</div>
  <div class="form-group">
		  <label>Suffix Digit <a style="color:red;">*</a></label>
		  <input type="number" id="suf" min="1" name="runningno" class="form-control" placeholder="Suffix Digit" max="20" value="" required>
  </div>
  <div class="form-group">
      <label>From <a style="color:red;">*</a></label>
      <input type="number" id="nofrom" min="0" step="any" name="nofrom" class="form-control" placeholder="Number From" value="" required>
  </div>
  <div class="form-group">
      <label>To <a style="color:red;">*</a></label>
      <input type="number" id="noto" min="0" name="noto" class="form-control" placeholder="Number To" value="" required>
  </div>
	<button title="Create" id="create" type="button" class="btn btn-success pull-left" data-toggle="modal">Create</button>
</form>

<script type="text/javascript">

$('#create').click(function() 
{  
    //alternative way to get input value from user based on id
    /*var prefix_value = document.getElementById("pre").value;
    var suffix_value = document.getElementById("suf").value;
    var card_value = document.getElementById("card").value;
    var nofrom_value = document.getElementById("nofrom").value;
    var noto_value = document.getElementById("noto").value;
    var remark_value = document.getElementById("remark").value;*/
    
    //get input value from user based on id=""
    var test1 = $('#pre').val();
    var test2 = $('#suf').val();
    var test3 = $('#nofrom').val();
    var test4 = $('#noto').val();
    var test5 = $('#card').val();
    var test6 = $('#remark').val();

    //function of LPAD of sql
    var str = ""+  test1;
    //repeat value 0 by (test2) times
    var pad = '0'.repeat(test2);
    var ans = test1 + pad.substring(test3.length) + test3 ;

    //length of characters
    var result = test1.length;
    //convert into integer
    var z = parseInt(result) + parseInt(test2);

    var from_length = test3.length;

    //simple javascript to check required input fields
    var x = document.forms["myform"]["prefix"].value;
    var y = document.forms["myform"]["nofrom"].value;
    var a = document.forms["myform"]["runningno"].value;
    var b = document.forms["myform"]["noto"].value;
    var c = document.forms["myform"]["cardtype"].value;

    if (x == null || x == "" || y == null || y == "" || a == null || a == "" || b == null || b == "" || c == null || c == "")
    {
      alert("Please fill in required field");
      //return false makes current if statement run and discontinue 
      return false;
    }

    if (from_length > test2)
    {
    	//if condition is true will show modal based on id=""
      $('#\\#fail').modal('show');
      //will show the message in modal based on id="msg1"
      document.getElementById('msg1').innerHTML = "Length of Suffix digit and from value are not matched";
      return false;
    }

    if (parseInt(test3) > parseInt(test4))
    {
      $('#\\#fail').modal('show');
      document.getElementById('msg1').innerHTML = "To value must be more than from value";
      return false;
    }

    if (z <= "20") 
    {
      $('#\\#success').modal('show');
      //get the value from variables above and send to modal through class="modal-body..."
      $(".modal-body #prefix").val( test1 );
      $(".modal-body #suffix").val( test2 );
      $(".modal-body #card").val( test5 );
      $(".modal-body #from").val( test3 );
      $(".modal-body #to").val( test4 );
      $(".modal-body #remark").val( test6 );
      document.getElementById('msg').innerHTML = ans;
    }
    else 
    {
      $('#\\#fail').modal('show');
      document.getElementById('msg1').innerHTML = "Length of prefix code + suffix digit cannot be more than 20";
    }
});

function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

</script>

<!-- modal success -->
<div class="modal fade" id="#success">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">  
                <h3 class="modal-title" style="color:red;">Final Confirmation!</h3>
            </div>
            <div class="modal-body form">
                <form action="" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-6">
                            	<!-- will show message passed from javascript based on id="msg" -->
                                <h2><center><div style="color:red;" id="msg"></div></center></h2>
                                <p><label>Please confirm your sample card no.</label>
                                <input name="sample" class="form-control" type="text" required maxlength="50"></p>
                                <!-- hidden box contains values passed from javascript based on id=""-->
                                <input type="" name="prefix" id="prefix" value=""/>
                                <input type="" name="suffix" id="suffix" value=""/>
                                <input type="" name="card" id="card" value=""/>
                                <input type="" name="from" id="from" value=""/>
                                <input type="" name="to" id="to" value=""/>
                                <input type="" name="remark" id="remark" value=""/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <!-- onclick="" means will reload the page once button is clicked -->
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div>
    </div>
</div>

<!-- modal fail -->
<div class="modal fade" id="#fail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title" style="color:red;">Reminder!</h3>
            </div>
            <div class="modal-body form">
                <form action="" method="POST" id="form" class="form-horizontal">
                    <div class="form-body">
                      <h2><center><div id="msg1"></div></center></h2>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <center><button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">OK </button></center>
                  </div>
                </form>
        </div>
    </div>
</div>