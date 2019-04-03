<form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_nationality&column=Nationality&upd_column=preset" id="formSN">
  <table class="table" >
    <tr>
      <th>Nationality</th>
      <th>Preset</th>
      <th style="width:100px">Actions</th>
    </tr>

    <?php foreach($nationality->result() as $row)
    { ?>

    <tr>
      <td><?php echo $row->Nationality; ?></td>
      <td>
      <input type="hidden" name="name[]" value="<?php echo $row->Nationality?>">
      <input type="" name="preset[]" 
      <?php if($row->Preset == 0)
      {
      echo 'value="0"';
      }
      else
      {
        echo 'value="1"';
      }
      ?>
      ><input type="checkbox"
      <?php if($row->Preset == 0)
      {
        echo " ";
      }
      else
      {
        echo "checked";
      } ?> 
        onchange="this.previousSibling.value=1-this.previousSibling.value" 
        /></td>

      <td>
        <button title="Edit" onclick="edit_nationality()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#nationality" 
            data-name="<?php echo $row->Nationality?>"
            data-oriname="<?php echo $row->Nationality?>" >
            <i class="glyphicon glyphicon-pencil"></i></button>

        <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->Nationality; ?>&column=Nationality&table=set_nationality')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->Nationality?>" ><i class="glyphicon glyphicon-trash"></i></button>
      </td>
    </tr>

    <?php } ?>

  </table>
</form>