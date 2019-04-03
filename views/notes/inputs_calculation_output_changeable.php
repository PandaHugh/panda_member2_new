<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<form method="POST">
<table style="border:1px solid purple">
    <tr>
      <th>Qty</th>
      <th>Price</th>
      <th>Total</th>
    </tr>
        <!-- class="test" links to js -->
      <tr class="test">
      <td><input class="qty" type="text" name="qty[]"></td>
      <td><input class="price" type="text" name="price[]"></td>
      <td><input class="output" type="text" name="output[]"></td>
    </tr>
    <tr class="test">
        <td><input class="qty" type="text" name="qty[]"></td>
        <td><input class="price" type="text" name="price[]"></td>
        <td><input class="output" type="text" name="output[]"></td>
    </tr>
    <tr class="test">
        <td><input class="qty" type="text" name="qty[]"></td>
        <td><input class="price" type="text" name="price[]"></td>
        <td><input class="output" type="text" name="output[]"></td>
    </tr>
</table>
<!-- <div id="grand">
Grand Total:<input type="text" name="gran" id="gran">
</div> -->


<script type="text/javascript">

  $(document).ready(function() {
    // if any of the qty or price inputs on the page change
    //.qty means class="qty"
    $(".qty, .price").change(function() {
        // find parent TR of the input being changed
        var $row = $(this).closest('tr');

        var a = $row.find(".qty").val();
        var b = $row.find(".price").val();
        var r = $row.find(".output").val(a * b);
    });
});

  // declare variable outside of loop
  var total = 0;

  // loop each table row with class .test
  $('.test').each(function() {
      var $row = $(this);
      var value = $row.find('.price').val() * $row.find('.qty').val();
      //total = total + value;
  });

  //$('#gran').val(total);

</script>
