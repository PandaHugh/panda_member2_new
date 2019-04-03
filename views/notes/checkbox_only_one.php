<div class="box-body no-padding" id="scroll">
<form method="post" action="" id="formSN">
  <table class="table" >
    <tr>
      <th>Template</th>
      <th>Preset</th>
    </tr>
    <tr>
      <td>1</td>
      <td>
        <!-- class and name are linked to javascript -->
        <input type="checkbox" value="1" name="subject" class="subject-list">
      </td>
    </tr>
    <tr>
      <td>2</td>
      <td>
        <input type="checkbox" value="2" name="subject" class="subject-list">
      </td>
    </tr>
  </table>
  </form>
</div>
<!-- /.box-body -->

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">

  $('.subject-list').on('change', function() {
    $('.subject-list').not(this).prop('checked', false);  
  });

</script>