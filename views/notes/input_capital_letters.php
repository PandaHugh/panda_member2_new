
<script type="text/javascript">

function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

</script>

<div class="form-group">
  <label>Prefix Code <a style="color:red;">*</a></label>
  <!-- All small capital letters will become capital letters -->
  <input type="text" id="pre" name="prefix" class="form-control" placeholder="Prefix Code" value="" onkeydown="upperCaseF(this)" required>
</div>