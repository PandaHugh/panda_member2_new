<html>
<body>

    <form action="#" method="post" class="demoForm" id="demoForm">
    <fieldset>
        <legend>Demo: Get Value Onclick</legend>

    <p>Select your size:&nbsp;
        <!-- name with size is used by javascript -->
        <label><input type="radio" name="size" value="5" /> Small</label>
        <label><input type="radio" name="size" value="8" checked="checked" /> Medium</label>
        <label><input type="radio" name="size" value="12" /> Large</label>
    </p>

    <p>
        <!-- name with total is linked to javascript -->
        <label>Total: $ <input type="text" name="total" class="num" value="8" readonly="readonly" /></label>
    </p>
    </fieldset>
    </form>

</body>

 <script type="text/javascript">
    // get list of radio buttons with name 'size'
var sz = document.forms['demoForm'].elements['size'];

// loop through list
for (var i=0, len=sz.length; i<len; i++) {
    sz[i].onclick = function() { // assign onclick handler function to each
        // put clicked radio button's value in total field
        this.form.elements.total.value = this.value;
    };
}
  </script>
</html>


<!-- 
Mistake:
1. Total output value didn't work as name of size and total are not equal to javascript's variables.
 -->