<script type="text/javascript">

function FillBilling(f) {
  
    f.prefixvalue.value = f.prefix.value;
}

</script>

<form method="post" action="">
	<div class="form-group">
		<label>Prefix Code <a style="color:red;">*</a></label>
		<input type="text" id="pre" name="prefix" class="form-control" placeholder="Prefix Code" value="" onchange="FillBilling(this.form)" required>
	</div>
	<div class="form-group">
		<label>Copied Prefix Code <a style="color:red;">*</a></label>
		<!-- this input value is based on value of Prefix Code by using name=""-->
		<input type="text" id="pre" name="prefixvalue" class="form-control" placeholder="Prefix Code" value="" required>
	</div>
</form>