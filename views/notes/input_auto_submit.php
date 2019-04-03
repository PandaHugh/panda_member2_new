<script language="javascript" type="text/javascript">

function checkForm(f)
{
  //just a placeholder
  var barcodeDefault = "Enter a barcode";
  if( f.Postcode.value == '' || f.Postcode.value == barcodeDefault )
  {
    //if empty box will not run
    f.Postcode.value = barcodeDefault;
    return false;
  }
  else
  { 
    //will run if there is something in the box
    return true; 
  }
}

/*onload = function(){
  checkForm(document.forms.barcodeForm);
}*/

</script>

</head>
<body>
<form class="" role="form" action="action.php" method="post" id="barcodeForm">
  <!-- id="" is used to link to javascript, onblur means javascript will be ran when cursor leaves from the box -->
  <!-- <input name="barcode" type="text" value="" name="" id="Postcode" onfocus="this.value=''" onblur="if(checkForm(this.form))this.form.submit();" />&nbsp; -->
  <select id="Postcode" onfocus="this.value=''" onblur="if(checkForm(this.form))this.form.submit();">
  <option value="volvo">Volvo</option>
  <option value="saab">Saab</option>
  <option value="opel">Opel</option>
  <option value="audi">Audi</option>
</select>

<!-- <button type="submit" name="pass" value="submit" class="btn btn-success">Submit</button> -->
</form>


<!-- 
Mistake:
1. Javascript cannot be read as button's name must be changed to other name instead of using "submit"
 -->
