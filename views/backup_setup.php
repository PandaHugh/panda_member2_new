<?php 
'session_start()' 
?>


<style>

#none{
    display: none;
}

#poDetails, #promoDetails {
  display: none;
}

#head{
    font-size: 12px;
  }


b .font {
    font-size: 90px;
}

@media screen and (max-width: 768px) {
  p,input,div,span,h4 {
    font-size: 95%;
  }
  h1 {
    font-size: 2px;  
  }
  h4 {
    font-size: 18px;  
  }
  h3 {
    font-size: 20px;  
  }
  h1 #head{
    font-size: 12px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
}

#scroll {
  height: 250px;
  overflow-y: scroll;
}

</style>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);



</script>
<!--onload Init-->
<body>
    
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
    <div id="page-inner">

        <?php
        if($this->session->userdata('message'))
        {
           echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
        }
        ?>
                    
              <!-- <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('main_c')?>" class="btn btn-default btn-xs"  style="float:right;" >
                          <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
                    </h1>
                  </div>
              </div> -->

  <div class="row">
    <div class="col-md-12">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>General</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Nationality</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  <button class="btn btn-xs btn-success" onclick="$('#formSN').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>
                
                <?php
                  if(in_array('CAS', $_SESSION['module_code']))
                  {
                    ?>
                    <button class="btn btn-xs btn-primary" onclick="add_nationality()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                    <?php
                  }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_nationality&column=Nationality&upd_column=preset" id="formSN" class="formSN">
              <table class="table" >
                <tr>
                  <th>Nationality</th>
                  <th>Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($nationality->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->Nationality; ?></td>

                  <td>
                  <input type="radio" name="radioname" value="<?php echo $row->Nationality?>"
                  <?php if($row->Preset == '1')
                  {
                    echo "checked";
                  }; ?> />
                  </td>

                  <td>
                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                        <button title="Edit" onclick="edit_nationality()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#nationality" 
                        data-name="<?php echo $row->Nationality?>"
                        data-oriname="<?php echo $row->Nationality?>" >
                        <i class="glyphicon glyphicon-pencil"></i></button>
                      <?php
                    }
                    ?>

                    <?php
                      if(in_array('DAS', $_SESSION['module_code']))
                      {
                        ?>
                        <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->Nationality; ?>&column=Nationality&table=set_nationality')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->Nationality?>" ><i class="glyphicon glyphicon-trash"></i></button>
                        <?php
                      }
                    ?>
                    
                  </td>
                </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Occupation</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                <button class="btn btn-xs btn-success" onclick="$('#formSO').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  
                  <?php
                }
                ?>

                <?php
                  if(in_array('CAS', $_SESSION['module_code']))
                  {
                    ?>
                    <button class="btn btn-xs btn-primary" onclick="add_occupation()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                    <?php
                  }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_occupation&column=Occupation&upd_column=Preset" id="formSO" class="formSO">
              <table class="table" >
                <tr>
                  <th>Occupation</th>
                  <th>Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($occupation->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->Occupation; ?></td>

                  <td>
                  <input type="radio" name="radioname" value="<?php echo $row->Occupation?>"
                  <?php if($row->Preset == '1')
                  {
                    echo "checked";
                  }; ?> />
                  </td>

                  <td>
                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                    <button title="Edit" onclick="edit_occupation()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#occupation" 
                        data-name="<?php echo $row->Occupation?>"
                        data-oriname="<?php echo $row->Occupation?>" >
                        <i class="glyphicon glyphicon-pencil"></i></button>
                      
                      <?php
                    }
                    ?>

                    <?php
                      if(in_array('DAS', $_SESSION['module_code']))
                      {
                        ?>
                        <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->Occupation; ?>&column=Occupation&table=set_occupation')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->Occupation?>" ><i class="glyphicon glyphicon-trash"></i></button>
                        <?php
                      }
                    ?>
                    
                  </td>
                </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Race</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSR').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

                <?php
                  if(in_array('CAS', $_SESSION['module_code']))
                  {
                    ?>
                    <button class="btn btn-xs btn-primary" onclick="add_race()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                    <?php
                  }
                ?>
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_race&column=Race&upd_column=Preset" id="formSR" class="formSR">
              <table class="table" >
                <tr>
                  <th>Race</th>
                  <th>Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($race->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->Race; ?></td>

                  <td>
                  <input type="radio" name="radioname" value="<?php echo $row->Race?>"
                  <?php if($row->Preset == '1')
                  {
                    echo "checked";
                  }; ?> />
                  </td>

                  <td>
                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                    <button title="Edit" onclick="edit_race()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#race" 
                        data-name="<?php echo $row->Race?>"
                        data-oriname="<?php echo $row->Race?>" >
                        <i class="glyphicon glyphicon-pencil"></i></button>
                      
                      <?php
                    }
                    ?>

                    <?php
                      if(in_array('DAS', $_SESSION['module_code']))
                      {
                        ?>
                        <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->Race; ?>&column=Race&table=set_race')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->Race?>" ><i class="glyphicon glyphicon-trash"></i></button>
                        <?php
                      }
                    ?>
                    
                  </td>
                </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
      <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Relationship</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSRe').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

                <?php
                  if(in_array('CAS', $_SESSION['module_code']))
                  {
                    ?>
                    <button class="btn btn-xs btn-primary" onclick="add_relationship()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                    <?php
                  }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_relationship&column=Relationship&upd_column=Preset" id="formSRe" class="formSRe">
              <table class="table" >
                <tr>
                  <th>Relationship</th>
                  <th>Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($relationship->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->Relationship; ?></td>

                  <td>
                  <input type="radio" name="radioname" value="<?php echo $row->Relationship?>"
                  <?php if($row->Preset == '1')
                  {
                    echo "checked";
                  }; ?> />
                  </td>

                  <td>

                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                      
                    <button title="Edit" onclick="edit_relationship()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#relationship" 
                        data-name="<?php echo $row->Relationship?>"
                        data-oriname="<?php echo $row->Relationship?>" >
                        <i class="glyphicon glyphicon-pencil"></i></button>
                      <?php
                    }
                    ?>

                    <?php
                      if(in_array('DAS', $_SESSION['module_code']))
                      {
                        ?>
                        <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->Relationship; ?>&column=Relationship&table=set_relationship')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->Relationship?>" ><i class="glyphicon glyphicon-trash"></i></button>
                        <?php
                      }
                    ?>
                    
                  </td>
                </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Religion</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSRel').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

                <?php
                  if(in_array('CAS', $_SESSION['module_code']))
                  {
                    ?>
                <button class="btn btn-xs btn-primary" onclick="add_religion()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                    
                    <?php
                  }
                ?>
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_religion&column=Religion&upd_column=Preset" id="formSRel" class="formSRel">
              <table class="table" >
                <tr>
                  <th>Religion</th>
                  <th>Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($religion->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->Religion; ?></td>

                  <td>
                  <input type="radio" name="radioname" value="<?php echo $row->Religion?>"
                  <?php if($row->Preset == '1')
                  {
                    echo "checked";
                  }; ?> />
                  </td>

                  <td>

                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                      
                    <button title="Edit" onclick="edit_religion()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#religion" 
                        data-name="<?php echo $row->Religion?>"
                        data-oriname="<?php echo $row->Religion?>" >
                        <i class="glyphicon glyphicon-pencil"></i></button>
                      <?php
                    }
                    ?>

                    <?php
                    if(in_array('DAS', $_SESSION['module_code']))
                    {
                      ?>
                      <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->Religion; ?>&column=Religion&table=set_religion')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->Religion?>" ><i class="glyphicon glyphicon-trash"></i></button>
                      <?php
                    }
                    ?>
                    
                  </td>
                </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Status</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSS').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

                <?php
                if(in_array('CAS', $_SESSION['module_code']))
                {
                  ?>
                  <button class="btn btn-xs btn-primary" onclick="add_status()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                  <?php
                }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_status&column=Status&upd_column=Preset" id="formSS" class="formSS">
              <table class="table" >
                <tr>
                  <th>Status</th>
                  <th>Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($status->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->Status; ?></td>

                  <td>
                  <input type="radio" name="radioname" value="<?php echo $row->Status?>"
                  <?php if($row->Preset == '1')
                  {
                    echo "checked";
                  }; ?> />
                  </td>

                  <td>
                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                      
                    <button title="Edit" onclick="edit_status()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#status" 
                        data-name="<?php echo $row->Status?>"
                        data-oriname="<?php echo $row->Status?>" >
                        <i class="glyphicon glyphicon-pencil"></i></button>
                      <?php
                    }
                    ?>

                    <?php
                    if(in_array('DAS', $_SESSION['module_code']))
                    {
                      ?>
                      <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->Status; ?>&column=Status&table=set_status')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->Status?>" ><i class="glyphicon glyphicon-trash"></i></button>
                      <?php
                    }
                    ?>
                    
                  </td>
                </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
      <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Title</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                <button class="btn btn-xs btn-success" onclick="$('#formST').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  
                  <?php
                }
                ?>

                <?php
                if(in_array('CAS', $_SESSION['module_code']))
                {
                  ?>
                  <button class="btn btn-xs btn-primary" onclick="add_title()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                  <?php
                }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_title&column=Title&upd_column=Preset" id="formST" class="formST">
              <table class="table" >
                <tr>
                  <th>Title</th>
                  <th>Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($title->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->Title; ?></td>

                  <td>
                  <input type="radio" name="radioname" value="<?php echo $row->Title?>"
                  <?php if($row->Preset == '1')
                  {
                    echo "checked";
                  }; ?> />
                  </td>

                  <td>
                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                      
                      <button title="Edit" onclick="edit_title()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#title" 
                          data-name="<?php echo $row->Title?>"
                          data-oriname="<?php echo $row->Title?>" >
                          <i class="glyphicon glyphicon-pencil"></i></button>
                      <?php
                    }
                    ?>

                    <?php
                    if(in_array('DAS', $_SESSION['module_code']))
                    {
                      ?>
                      <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->Title; ?>&column=Title&table=set_title')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->Title?>" ><i class="glyphicon glyphicon-trash"></i></button>
                      <?php
                    }
                    ?>
                    
                  </td>
                </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Setting (Receipt No.)</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSRN').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save_receipt_no'); ?>?table=set_parameter" id="formSRN" class="formSRN">
              <table class="table">
                <tr>
                  <th style="width: 100px;">Functions</th>
                  <th style="width: 80px;">Show</th>
                  <th style="width: 80px;"
                  <?php
      if($parameter->row('check_receipt_itemcode') == 1 )
      {
        echo "class='hidden'";
      }
      ?>>Amount</th>
                </tr>
                <tr>
                  <td>Issue sup card</td>
                  <td>
                    <input type="checkbox" name="receipt_no_supcard" class="subject-list" 

                    <?php if($parameter->row('receipt_no_supcard') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td>

                  <td 
                  <?php
      if($parameter->row('check_receipt_itemcode') == 1 )
      {
        echo "class='hidden'";
      }
      ?>>
                    <input type="number" name="receipt_no_amount_supcard" class="form-control input-sm" style="border-radius: 10px; width: 60px;" value="<?php echo $parameter->row('receipt_no_amount_supcard'); ?>" />
                  </td>
                </tr>
                <tr>
                  <td>Replace Lost Card</td>
                  <td>
                    <input type="checkbox" name="receipt_no_lostcard" class="subject-list" 

                    <?php if($parameter->row('receipt_no_lostcard') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td>

                  <td
                  <?php
      if($parameter->row('check_receipt_itemcode') == 1 )
      {
        echo "class='hidden'";
      }
      ?>>
                    <input type="number" name="receipt_no_amount_lostcard" class="form-control input-sm" style="border-radius: 10px; width: 60px;" value="<?php echo $parameter->row('receipt_no_amount_lostcard'); ?>" />
                  </td>
                </tr>
                <tr>
                  <td>Active/Renew Card</td>
                  <td>
                    <input type="checkbox" name="receipt_no_activerenew" class="subject-list" 

                    <?php if($parameter->row('receipt_no_activerenew') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td>

                  <td
                  <?php
      if($parameter->row('check_receipt_itemcode') == 1 )
      {
        echo "class='hidden'";
      }
      ?>>
                    <input type="number" name="receipt_no_amount_activerenew" class="form-control input-sm" style="border-radius: 10px; width: 60px;" value="<?php echo $parameter->row('receipt_no_amount_activerenew'); ?>" />
                  </td>
                </tr>
              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Setting (Check Digit)</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                <button class="btn btn-xs btn-success" onclick="$('#formSCD').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save_check_digit'); ?>?table=set_parameter" id="formSCD" class="formSCD">
              <table class="table">
                <tr>
                  <th style="width: 100px;">Type</th>
                  <th style="width: 80px;">Active</th>
                </tr>
                <tr>
                  <td>Pre-issue Member card</td>
                  <td>
                    <input type="checkbox" name="check_digit_card" class="subject-list" 

                    <?php if($parameter->row('check_digit_card') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td>
                </tr>
                <tr>
                  <td>Voucher Setup</td>
                  <td>
                    <input type="checkbox" name="check_digit_voucher" class="subject-list" 

                    <?php if($parameter->row('check_digit_voucher') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td>
                </tr>
                <!-- <tr>
                  <td>Voucher Activation</td>
                  <td>
                    <input type="checkbox" name="check_digit_voucher_activation" class="subject-list" 

                    <?php if($parameter->row('check_digit_voucher_activation') == '1')
                    {
                      echo "checked";
                    }; ?> />
                  </td>
                </tr> -->
              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Setting (Operation)</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" type="submit" onclick="$('#formS').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save_general'); ?>?table=set_parameter" id="formS" class="formS">
              <table class="table">
                <tr>
                  <td><label>Auto Renew Supcard</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="auto_renewsupcard" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('auto_renewsupcard'); ?>" max="1" min="0" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label>Active Preissue</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="preissue_default_active" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('preissue_default_active'); ?>" max="1" min="0" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Interval year for renew card.">Member Expiry Date In Year</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="expiry_date_in_year" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('expiry_date_in_year'); ?>" min="0" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Type 1: New expiry date will follow based on date of renewal card.
                    Type 2: New expiry date will follow based on current expiry date.">Member Expiry Date Type</label></td>
                  <td style="width: 80px;">
                    <input type="number" min="1" max="2" name="expiry_date_type" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('expiry_date_type'); ?>"/>
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Set 0: System will not checking the itemcode in the receipt no.
                    Set 1: System will check itemcode that has been set in iventory.">Checking Receipt Itemcode</label></td>
                  <td style="width: 80px;">
                    <input type="number" min="0" max="1" name="check_receipt_itemcode" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('check_receipt_itemcode'); ?>" />
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label data-toggle="tooltip" data-placement="top" title="Set 1: System shall allow merchant user to login.">Merchant Reward Program</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" min="0" max="1" name="merchant_rewards_program" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('merchant_rewards_program'); ?>" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label>Voucher Valid In Day</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="voucher_valid_in_days" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('voucher_valid_in_days'); ?>" min="0" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label>Voucher No. Customization</label></td>
                  <td style="width: 80px;">
                  
                    <input type="number" name="customized_voucher_no" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $parameter->row('customized_voucher_no'); ?>" max="1" min="0" />
                  
                  </td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4" 

        <?php
        if($parameter->row('check_receipt_itemcode') == 0 )
        {
          echo "hidden";
        }
        ?> >
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Setting (Item Code)</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSIC').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save_itemcode'); ?>?table=set_itemcode" id="formSIC" class="formSIC">
              <table class="table">
                <tr>
                  <td><label>Type</label></td>
                  <td style="width: 140px;"><center><label>Item Code</label></center></td>
                  <!-- <td style="width: 190px;"><center><label>Description</label></center></td> -->
                  <td></td>
                </tr>
                <tr>
                  <td>Supplementary Card</td>
                  <td>
                    <input type="number" name="supcard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $supcard->row('itemcode'); ?>" />
                  </td>
                  <td>
                    <!-- <input type="text" name="supcard_desc" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $supcard->row('description'); ?>" /> -->
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Lost Card</td>
                  <td style="width: 80px;">
                    <input type="number" name="lostcard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $lostcard->row('itemcode'); ?>" />
                  </td>
                  <td>
                    <!-- <input type="text" name="lostcard_desc" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $lostcard->row('description'); ?>" /> -->
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Renew Card</td>
                  <td style="width: 80px;">
                    <input type="number" name="newcard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $newcard->row('itemcode'); ?>" />
                  </td>
                  <td>
                    <!-- <input type="text" name="newcard_desc" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $newcard->row('description'); ?>" /> -->
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Activate Card</td>
                  <td style="width: 80px;">
                    <input type="number" name="activecard_ic" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $activecard->row('itemcode'); ?>" />
                  </td>
                  <td>
                    <!-- <input type="text" name="activecard_desc" class="form-control input-sm" style="border-radius: 10px;" value="<?php echo $activecard->row('description'); ?>" /> -->
                  </td>
                  <td></td>
                </tr>
              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Setting (Branch)</h3>

              <?php if(in_array('UAS', $_SESSION['module_code']))
              { ?>
                
                <button class="btn btn-xs" onclick="location.href = '<?php echo site_url('Setup_general_c/sync_branch')?>';" >Sync Branch</button>

              <?php } ?>
              
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  
                <button class="btn btn-xs btn-success" onclick="$('#formSSB').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>

               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save_set_branch'); ?>?table=set_parameter" id="formSSB" class="formSSB">
              <table class="table">
                <tr>
                  <th>Branch</th>
                  <th style="width: 120px;">Free Registration</th>
                </tr>

                <?php foreach($setup_branch->result() as $row)
                { ?>

                  <tr>
                    <td><?php echo $row->branch_name; ?></td>
                    <td>
                      <center>
                        <input type="hidden" value="<?php echo $row->branch_guid; ?>" name="branch_guid[]" />
                        <input type="hidden" name="set_receipt_no[]" 

                        <?php if($row->set_receipt_no == 0)
                        {
                        echo 'value="0"';
                        }
                        else
                        {
                          echo 'value="1"';
                        }
                        ?>
                        ><input type="checkbox" name="" class="subject-list" 

                        <?php if($row->set_receipt_no == '1')
                        {
                          echo "checked";
                        }; ?> onchange="this.previousSibling.value=1-this.previousSibling.value" />
                      </center>
                    </td>
                  </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      

      <!-- /.row -->
        <!-- <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Card Type</h3>
              <div class="box-tools pull-right">

                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                  <button class="btn btn-xs btn-success" onclick="$('#formCT').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  <?php
                }
                ?>
                
                <?php
                if(in_array('CAS', $_SESSION['module_code']))
                {
                  ?>
                  <button class="btn btn-xs btn-primary" onclick="add_cardtype()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                  <?php
                }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=cardtype&column=CardType&upd_column=Preset" id="formCT">
              <table class="table" >
                <tr>
                  <th>Card Type</th>
                  <th>Pricing Type</th>
                  <th>Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>

                <?php foreach($cardtype->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->CardType; ?></td>
                  <td><?php echo $row->PricingValue; ?></td>
                  <td>
                  <input type="hidden" name="name[]" value="<?php echo $row->CardType?>">
                  <input type="hidden" name="preset[]" 
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
                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                      <button title="Edit" onclick="edit_cardtype()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#cardtype" 
                        data-name="<?php echo $row->CardType?>"
                        data-value="<?php echo $row->PricingValue?>"
                        data-orivalue="<?php echo $row->PricingValue?>"
                        data-oriname="<?php echo $row->CardType?>" >
                        <i class="glyphicon glyphicon-pencil"></i></button>
                      <?php
                    }
                    ?>
                    
                    <?php
                    if(in_array('DAS', $_SESSION['module_code']))
                    {
                      ?>
                      <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->CardType; ?>&column=CardType&table=cardtype')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->CardType?>" ><i class="glyphicon glyphicon-trash"></i></button>
                      <?php
                    }
                    ?>
                    
                  </td>
                </tr>

                <?php } ?>

              </table>
              </form>
            </div>
            
          </div>
          
        </div> -->


        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

<script type="text/javascript">
  // get list of radio buttons with name 'size'
  var sz = document.forms['formSN'].elements['radioname'];
  // loop through list
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() { // assign onclick handler function to each
          // put clicked radio button's value in total field
          this.form.elements.name.value = this.value;
      };
  }
</script>

<script type="text/javascript">

  var sz = document.forms['formSO'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formSR'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formSRe'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formSRel'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formSS'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formST'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

    function confirm_modal(delete_url)
    {
      $('#delete').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

      var modal = $(this)
      modal.find('.modal_detail').text('Confirm delete ' + button.data('name') + '?')
      modal.find('.modal_alert').text(button.data('alert'))
      document.getElementById('url').setAttribute("href" , delete_url );
      });
    }

    function edit_nationality()
    {
      $('#nationality').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_occupation()
    {
      $('#occupation').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_race()
    {
      $('#race').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_relationship()
    {
      $('#relationship').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_religion()
    {
      $('#religion').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_status()
    {
      $('#status').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_title()
    {
      $('#title').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_cardtype()
    {
      $('#cardtype').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="value"]').val(button.data('value'))
        modal.find('[name="orivalue"]').val(button.data('orivalue'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function add_nationality()
    {
      save_method = 'add';
      $('#nationality').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_occupation()
    {
      save_method = 'add';
      $('#occupation').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_race()
    {
      save_method = 'add';
      $('#race').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_relationship()
    {
      save_method = 'add';
      $('#relationship').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_religion()
    {
      save_method = 'add';
      $('#religion').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_status()
    {
      save_method = 'add';
      $('#status').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_title()
    {
      save_method = 'add';
      $('#title').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_cardtype()
    {
      save_method = 'add';
      $('#cardtype').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

</script>

<div class="modal fade" id="delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="text-align: center">Confirm Delete?</h3>
            </div> -->
            <div class="modal-body">
                <h4 class="modal_alert" style="text-align: center;color: red"></h4>
                <h4 class="modal_detail" style="text-align: center"></h4>
            </div>
            <div class="modal-footer" style="text-align: center">
            <span id="preloader-delete"></span>
                <a id="url" href=""><button type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button></a>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="nationality" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_nationality')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nationality</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="occupation" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_occupation')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Occupation</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="race" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_race')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Race</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="relationship" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_relationship')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Relationship</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="religion" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_religion')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Religion</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="status" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_status')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="title" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_title')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Title</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="cardtype" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_cardtype')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <input type="hidden" value="" name="orivalue"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Card Type</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-3">Pricing Type</label>
                            <div class="col-md-9">
                                <input name="value" class="form-control" type="text" required maxlength="60">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onClick="window.location.reload();">Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>