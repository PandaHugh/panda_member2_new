
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
<script type="text/javascript">

  $(document).ready(function() 
  {
    //by default text box is disabled
    $('#PassportNo').attr('disabled','disabled'); 
    //read from name="facility"        
    $('select[name="facility"]').on('change',function(){
    var  x = $(this).val();
        if(x == "MALAYSIAN")
        {           
          //if "MALAYSIAN is selected, text box will be disabled"
          $('#PassportNo').attr('disabled','disabled');           
        }
        else
        {
          $('#PassportNo').removeAttr('disabled');
        }  
      });
  });

</script>
</head>

<select name="facility" >
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="MALAYSIAN">MALAYSIAN</option>
</select>

<!-- link javascript with id="" -->
<input name="" type="text" id="PassportNo"/>


<!-- 
Mistake:
1. Javascript cannot be ran as bootstrap not exists
 -->