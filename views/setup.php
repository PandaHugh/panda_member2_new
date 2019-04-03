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

function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

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
                  <input type="radio" id="radioname" name="radioname" value="<?php echo $row->Nationality?>"
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
         <!-- /.row -->
        <div class="col-md-4">
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
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($cardtype->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->CardType; ?></td>
                  <td><?php echo $row->PricingValue; ?></td>

                  <td>
                  <input type="radio" name="radioname" value="<?php echo $row->CardType?>"
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
                    <button title="Edit" onclick="edit_cardtype()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#cardtype" 
                        data-name="<?php echo $row->CardType?>"
                        data-value="<?php echo $row->PricingValue?>"
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
          
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Wallet</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                <button class="btn btn-xs btn-success" onclick="$('#formWa').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  
                  <?php
                }
                ?>

                <?php
                if(in_array('CAS', $_SESSION['module_code']))
                {
                  ?>
                  <button class="btn btn-xs btn-primary" onclick="add_wallet()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                  <?php
                }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_wallet&column=wallet_name&upd_column=Preset" id="formWa" class="formWa">
              <table class="table" >
                <tr>
                  <th>Wallet Name</th>
                  <th>Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($wallet->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->wallet_name; ?></td>

                  <td>
                  <input type="radio" name="radioname" value="<?php echo $row->wallet_name?>"
                  <?php if($row->preset == '1')
                  {
                    echo "checked";
                  }; ?> />
                  </td>

                  <td>
                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                      
                      <button title="Edit" onclick="edit_wallet()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#wallet" 
                          data-name="<?php echo $row->wallet_name?>"
                          data-oriname="<?php echo $row->wallet_name?>" >
                          <i class="glyphicon glyphicon-pencil"></i></button>
                      <?php
                    }
                    ?>

                    <?php
                    if(in_array('DAS', $_SESSION['module_code']))
                    {
                      ?>
                      <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->wallet_name; ?>&column=wallet_name&table=set_wallet')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->wallet_name?>" ><i class="glyphicon glyphicon-trash"></i></button>
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

      <div class="row">
       <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Miscellaneous</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                <button class="btn btn-xs btn-success" onclick="$('#formWa').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                  
                  <?php
                }
                ?>

                <?php
                if(in_array('CAS', $_SESSION['module_code']))
                {
                  ?>
                  <button class="btn btn-xs btn-primary" onclick="add_misc()"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                  <?php
                }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Setup_general_c/save'); ?>?table=set_misc&column=misc_name&upd_column=Preset" id="formWa" class="formWa">
              <table class="table" >
                <tr>
                  <th>Miscellaneous Group</th>
                  <th type="hidden">Preset</th>
                  <th style="width:100px">Actions</th>
                </tr>
                <input type="hidden" name="name" readonly="readonly" />

                <?php foreach($miscellaneous->result() as $row)
                { ?>

                <tr>
                  <td><?php echo $row->misc_name; ?></td>

                  <td>
                  <input type="hidden" name="radioname" value="<?php echo $row->misc_name?>"
                  <?php if($row->preset == '1')
                  {
                    echo "checked";
                  }; ?> />
                  </td>

                  <td>
                    <?php
                    if(in_array('UAS', $_SESSION['module_code']))
                    {
                      ?>
                      
                      <button title="Edit" onclick="edit_misc()" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#miscellaneous" 
                          data-name="<?php echo $row->misc_name?>"
                          data-oriname="<?php echo $row->misc_name?>" >
                          <i class="glyphicon glyphicon-pencil"></i></button>
                      <?php
                    }
                    ?>

                    <?php
                    if(in_array('DAS', $_SESSION['module_code']))
                    {
                      ?>
                      <button title="Delete" onclick="confirm_modal('<?php echo site_url('Setup_general_c/delete'); ?>?condition=<?php echo $row->misc_name; ?>&column=misc_name&table=set_misc')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->misc_name?>" ><i class="glyphicon glyphicon-trash"></i></button>
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
          <div class="box"  id="scroll" style="height: 342px">
            <div class="box-header">
              <h3 class="box-title">Card Layout Setup</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                <button class="btn btn-xs btn-success" onclick="$('#formCLS').submit()"><i class="glyphicon glyphicon-floppy-saved" ></i> Save</button>
                  
                  <?php
                }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <form method="post" action="<?php echo site_url('Setup_general_c/save_card_layout'); ?>" id="formCLS" class="formAPC">
                <div class="box-body ">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Body Content</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" style="font-size: 12pt;" rows="3" name="content_message" ><?php echo $body_content?></textarea>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-body ">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Header Content</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" style="font-size: 12pt;" rows="2" name="content_header" ><?php echo $body_header?></textarea>
                    </div>
                  </div>
                </div>
                
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">T&C (Registration Form)</h3>
              <div class="box-tools pull-right">
                <?php
                if(in_array('UAS', $_SESSION['module_code']))
                {
                  ?>
                <button class="btn btn-xs btn-success" onclick="$('#formTNC').submit()"><i class="glyphicon glyphicon-floppy-saved" ></i> Save</button>
                  
                  <?php
                }
                ?>
                
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <form method="post" action="<?php echo site_url('Setup_general_c/save_tnc'); ?>" id="formTNC" class="formTNC">

              <div class="form-group">
                <div class="col-sm-12">
                  <textarea class="form-control" style="font-size: 12pt;" rows="11" placeholder="Term & Conditions" name="tnc" id="tnc"><?php echo $tnc; ?></textarea>
                </div>
              </div>

              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <?php
        if(in_array('APC', $_SESSION['module_code']))
        {
          ?>

          <div class="col-md-4">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Add Postcode</h3>
                <div class="box-tools pull-right">
                 
                  <?php
                  if(in_array('UAS', $_SESSION['module_code']))
                  {
                    ?>
                  <button class="btn btn-xs btn-success" onclick="$('#formAPC').submit()" id="save_apc"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                    
                    <?php
                  }
                  ?>
                  
                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
                </div>
              </div>
              <!-- /.box-header -->
              <form method="post" action="<?php echo site_url('Setup_general_c/save_postcode'); ?>" id="formAPC" class="formAPC">
                <div class="box-body ">

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Postcode<span style="color: red;">*</span></label>

                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="Postcode" placeholder="Example: 75450" value="" name="Postcode" >
                    </div>
                  </div>

                </div>
                <!-- /.box-body -->
                <div class="box-body ">

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Location<span style="color: red;">*</span></label>

                    <div class="col-sm-9">
                      <textarea class="form-control" style="font-size: 12pt;" rows="2" placeholder="Example: Jalan Sentosa" name="Location" id="Location"></textarea>
                    </div>
                  </div>

                </div>
                <!-- /.box-body -->
                <div class="box-body ">

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">City Name<span style="color: red;">*</span></label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="City" placeholder="Example: Bukit Beruang" value="" name="City" >
                    </div>
                  </div>

                </div>
                <!-- /.box-body -->
                <div class="box-body ">

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">State Code<span style="color: red;">*</span></label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="StateCode" placeholder="Example: MLK (max 3 characters)" value="" name="StateCode" onkeydown="upperCaseF(this)" onkeyup="statecode()">
                      <span id="error_box" style="color: red; display: none;">Maximum 3 characters</span>
                    </div>
                  </div>

                </div>
                <!-- /.box-body -->
                <div class="box-body ">

                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">State<span style="color: red;">*</span></label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="State" placeholder="Example: MELAKA" value="" name="State" onkeydown="upperCaseF(this)" >
                    </div>
                  </div>

                </div>
                <!-- /.box-body -->
              </form>
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->

        <?php }; ?>

      </div>
      

        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

<script type="text/javascript">
  function statecode()
  {
    var StateCode = document.getElementById('StateCode').value;
    var state = StateCode.length

    if(state > 3)
    {
      document.getElementById('error_box').style.display = 'block';
      document.getElementById('save_apc').disabled = true;
    }
    else
    {
      document.getElementById('error_box').style.display = 'none';
      document.getElementById('save_apc').disabled = false;
    }
  }
</script>

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

  var sz = document.forms['formWa'].elements['radioname'];
  for (var i=0, len=sz.length; i<len; i++) {
      sz[i].onclick = function() {
          this.form.elements.name.value = this.value;
      };
  }

</script>

<script type="text/javascript">

  var sz = document.forms['formCT'].elements['radioname'];
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

    function edit_wallet()
    {
      $('#wallet').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

        var modal = $(this)
        modal.find('.modal-title').text('Edit')
        modal.find('[name="name"]').val(button.data('name'))
        modal.find('[name="oriname"]').val(button.data('oriname'))
      });
    }

    function edit_misc()
    {
      $('#miscellaneous').on('show.bs.modal', function (event) {
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

    function add_wallet()
    {
      save_method = 'add';
      $('#wallet').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title
    }

    function add_misc()
    {
      save_method = 'add';
      $('#miscellaneous').modal('show'); // show bootstrap modal
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
                                <input name="name" class="form-control" type="text" onkeydown="upperCaseF(this)" required maxlength="60">
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
                                <input name="name" class="form-control" type="text" required maxlength="60" onkeydown="upperCaseF(this)">
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
                                <input name="name" class="form-control" type="text" required maxlength="60" onkeydown="upperCaseF(this)">
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
                                <input name="name" class="form-control" type="text" required maxlength="60" onkeydown="upperCaseF(this)">
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
                                <input name="name" class="form-control" type="text" required maxlength="60" onkeydown="upperCaseF(this)">
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
                                <input name="name" class="form-control" type="text" required maxlength="60" onkeydown="upperCaseF(this)">
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
                                <input name="name" class="form-control" type="text" required maxlength="60" onkeydown="upperCaseF(this)">
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

<div class="modal fade" id="wallet" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_wallet')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Wallet Name</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60" onkeydown="upperCaseF(this)">
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

<div class="modal fade" id="miscellaneous" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('Setup_general_c/update_insert_miscellaneous')?>" method="POST" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="oriname"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Miscellaneous Group</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" required maxlength="60" onkeydown="upperCaseF(this)">
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
                                <input name="name" class="form-control" type="text" required maxlength="60" onkeydown="upperCaseF(this)">
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