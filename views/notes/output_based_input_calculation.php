<div class="col-md-4">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Point Before </label>
        <input type="number" min="0" step="any" value="100" name="Point_Before" id="Point_Before" class="form-control" placeholder="Point Before" readonly>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Total Point Adjust </label>
        <input type="number" min="0.00" step="0.00" name="value_total" value="" id="value_total" class="form-control" placeholder=" Total Point Adjust" readonly>

        <!-- two hidden input to make Total Point Adjust shows correcy output -->
        <input type="" name="Point_Adjust" value="0" id="Point_Adjust" class="form-control">
        <input type="" name="total" value="" id="total" class="form-control">
      </div>

    </div> 
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Point Balance </label>
        <input type="number" id="Point_Balance" min="0" value="" name="Point_Balance" class="form-control" placeholder="Point Balance" readonly>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Qty</label>
        <!-- onchange means when key in quantity will make javascript run -->
        <input type="number" min="1" name="Qty" value="1" id="Qty" class="form-control" placeholder="Qty" onchange="sumtotal()">
      </div>
    </div>
  </div>
  <div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>Voucher Type <a style="color:red;">*</a></label>
      <select name="Voucher_Type" class="form-control" id="Voucher_Type" onchange="sumtotal()" required>

        <!-- the way to use echo for foreach statement -->
        <!-- <option required value="<?php echo "-";echo $row->POINT_TYPE1;echo "=>";echo $row->ITEM_CODE;echo "=>";echo $row->ITEM_DESC ?>"><?php echo "-";echo $row->POINT_TYPE1;echo " => ";echo $row->ITEM_CODE;echo " => ";echo $row->ITEM_DESC ?></option> -->

        <!-- currently is negative point, postive point is accepted too -->
        <option value="-1=>1000=>RM1">- 1 => 1000 => RM1</option>
        <option value="-2=>2000=>RM1">- 2 => 2000 => RM2</option>
        <option value="-3=>3000=>RM3">- 3 => 3000 => RM3</option>
      </select>
      <span class="input-group-btn">
      </span>
    </div>
  </div>
  </div>

<script type="text/javascript">

  function sumtotal()
  {
    var point = document.getElementById("Voucher_Type").value;
    //split Voucher_Type function
    var split_point =  point.split("=>");
    //after split take first array output
    var point_result = split_point[0];

    //parseFloat to avoid 1+1=11
    document.getElementById("Point_Balance").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value) + parseFloat(document.getElementById("Point_Before").value) + parseFloat(document.getElementById("Point_Adjust").value));

    document.getElementById("total").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value));

    /*document.getElementById("Point_Balance").value = parseFloat(parseFloat(document.getElementById("Point_Before").value) + parseFloat(document.getElementById("value_total").value) + parseFloat(point_result) * parseFloat(document.getElementById("Qty").value));*/

    /*document.getElementById("Point_Adjust").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value));*/

    document.getElementById("value_total").value = parseFloat(parseFloat(point_result) * parseFloat(document.getElementById("Qty").value) + parseFloat(document.getElementById("Point_Adjust").value));
    /*document.getElementById("value_total").value = parseFloat(parseFloat(point_result).toFixed(2) * parseFloat(document.getElementById("Qty").value).toFixed(2));*/

  }

</script>


<!-- 
Mistake:
1. Sometimes output value is not desired value, the solution is to use hidden input box.
 -->