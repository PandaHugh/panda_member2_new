
<div class="form-group">
  <label>Date:</label>

  <div class="input-group date">
    <div class="input-group-addon">
      <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control pull-right" id="datepicker">
  </div>
  <!-- /.input group -->
</div>
<!-- /.form group -->

<!-- Date range -->
<div class="form-group">
  <label>Date range:</label>

  <div class="input-group">
    <div class="input-group-addon">
      <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control pull-right" id="reservation" name="daterange">
  </div>
  <!-- /.input group -->
</div>
<!-- /.form group -->

<script type="text/javascript">

    $('input[name="daterange"]').daterangepicker(
    {
        locale: {
          format: 'YYYY/MM/DD'
        },
    });

    $('#datepicker').datepicker({
      autoclose: true,
      format: 'yyyy/mm/dd'
    });

</script>

<!-- 
Mistake:
1.Bootstrap will not run unless it read datepicker and daterangepicker bootstrap
 -->