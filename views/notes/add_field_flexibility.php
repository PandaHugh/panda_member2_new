<style>

.container1 input[type=text] {
    padding:5px 0px;
    margin:5px 5px 5px 0px;
    border: 1px solid #ccc;
    width: 200px;
    height: 30px;
    margin-bottom:14px;
    display: inline-block;
    border-radius: 4px;
}

.form-control {
    background-color: #1c97f3;
    border: none;
    color: white;
    padding: 2px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 2px 10px;
    cursor: pointer;
    border:1px solid #186dad;
}

.delete {
    background-color: #cccccc;
    border: none;
    color: white;
    padding: 5px 15px;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
    margin: 4px 2px;
    cursor: pointer;
}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    var max_fields      = 20;
    //class="container1" is assigned to variable of wrapper
    var wrapper         = $(".container1");
    var add_button      = $(".form-control");
  
    var x = 1;
    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){
            x++;
            $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="delete">Delete</a></div>'); //add input box
        }
  else
  {
  alert('You Reached the limits')
  }
    });
  
    $(wrapper).on("click",".delete", function(e){
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

</script>

<div class="col-md-4">
<div class="container1">
    <button class="form-control">Add New Field &nbsp; <span style="font-size:16px; font-weight:bold;">+ </span></button>
    <div><input type="text" class="inline-block" name="mytext[]" required></div>
</div>
</div>