<style>
/* The container */
.container {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 15px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default radio button */
.container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
  top: 9px;
  left: 9px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}
</style>

<div class="form-group">
  <label for="inputName" class="col-sm-2 control-label">Confirm New Password</label>

  <div class="col-sm-5">
    <label class="container">Hour
      <input type="radio" checked="checked" name="radio" onclick="show_hour();">
      <span class="checkmark"></span>
    </label>
    <label class="container">Day
      <input type="radio" name="radio" onclick="show_day();">
      <span class="checkmark"></span>
    </label>
  </div>
</div>
<div class="form-group">
  <label for="inputName" class="col-sm-2 control-label"></label>

  <div class="col-sm-5">
    <input type="text" class="form-control" id="test" placeholder="Hour" name="Hour" required>
  </div>
</div>

<script type="text/javascript">

  function show_hour() 
  { 
    document.getElementById("test").placeholder = "Hour";
    document.getElementById("test").name = "Hour";
  }

  function show_day() 
  { 
    document.getElementById("test").placeholder = "Day";
    document.getElementById("test").name = "Day";
  }

</script>