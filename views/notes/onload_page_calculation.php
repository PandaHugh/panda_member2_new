
<!-- onload means when page is loaded, will run javascript -->
<body onload="sum()">
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
        <input type="number" min="0.00" step="0.00" name="value_total" value="50" id="value_total" class="form-control" placeholder=" Total Point Adjust" readonly>
      </div>
    </div> 
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Point Balance </label>
        <!-- this input box will output summation of Point Before and Total Point Adjust -->
        <input type="number" id="Point_Balance" min="0" value="" name="Point_Balance" class="form-control" placeholder="Point Balance" readonly>
      </div>
    </div>
  </div>
</div>
</body>

<script type="text/javascript">

  function sum()
{
  document.getElementById("Point_Balance").value = parseFloat(parseFloat(document.getElementById("Point_Before").value) + parseFloat(document.getElementById("value_total").value));
}

</script>