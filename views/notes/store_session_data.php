<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url('selectpicker/dist/js/bootstrap-select.js');?>"></script>
<script>
    window.onload = function() 
    {
        // If values are not blank, restore them to the fields
        var name = sessionStorage.getItem('name');
        if (name !== null) $('#car').val(name);
    }

    window.onbeforeunload = function() 
    {
        sessionStorage.setItem("name", $('#car').val());
    }

</script>

<!-- id="" is linked to javascript -->
<select id='car'>
  <option value="volvo">Volvo</option>
  <option value="saab">Saab</option>
  <option value="opel">Opel</option>
  <option value="audi">Audi</option>
</select>