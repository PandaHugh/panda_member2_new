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

label {
  font-size: 12px;
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


</style>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);


</script>
<!--onload Init-->
<body onload="selectActive()">
    
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
      <h1>Voucher</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Template Selection</h3>
              <div class="box-tools pull-right">
                
              <button class="btn btn-xs btn-success" onclick="$('#formSN').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>
                     
              <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>    -->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" id="scroll">
            <form method="post" action="<?php echo site_url('Voucher_c/save'); ?>" id="formSN">
              <table class="table" >
                <tr>
                  <th>Template</th>
                  <th>Preset</th>
                  <th>Logo</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td>
                    <input type="checkbox" value="1" name="subject" class="subject-list"

                    <?php if($template1 == 'template1')
                    {
                      echo "checked";
                    }; ?>>
                  </td>
                  <td>
                    <input type="hidden" name="logo_temp1" id="logo_temp1"
                    <?php if($logo_temp1 == 0)
                    {
                      echo 'value="0"';
                    }
                    else
                    {
                      echo 'value="1"';
                    }
                    ?>
                    ><input type="checkbox"

                    <?php if($logo_temp1 == 1)
                    {
                      echo "checked";
                    }; ?> 
                    onchange="this.previousSibling.value=1-this.previousSibling.value" 
                    />
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>
                    <input type="checkbox" value="2" name="subject" class="subject-list"

                    <?php if($template2 == 'template2')
                    {
                      echo "checked";
                    }; ?>>
                  </td>
                  <td>
                    <input type="hidden" name="logo_temp2" id="logo_temp2"
                    <?php if($logo_temp2 == 0)
                    {
                      echo 'value="0"';
                    }
                    else
                    {
                      echo 'value="1"';
                    }
                    ?>
                    ><input type="checkbox"

                    <?php if($logo_temp2 == 1)
                    {
                      echo "checked";
                    }; ?> 
                    onchange="this.previousSibling.value=1-this.previousSibling.value" 
                    />
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
        <div class="col-md-8">
          <div class="box">
          <div class="box-header">
            <h3 class="box-title">Barcode Size</h3>
          </div>
          <div class="box-body">
            <form method="post" action="<?php echo site_url('Voucher_c/submit'); ?>?submit&template=<?php echo $template; ?>">
            <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Prefix</label>
                <input type="text" id="Prefix" name="Prefix" value="<?php echo $prefix; ?>" class="form-control" placeholder="Prefix">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Barcode Width</label>
                <input type="number" id="Width" name="Width" value="<?php echo $width; ?>" class="form-control" placeholder="Barcode Width">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Barcode Height</label>
                <input type="number" id="Height" name="Height" value="<?php echo $height; ?>" class="form-control" placeholder="Barcode Height">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group" style="color:#8c8c8c; font-size:12px;">
                <p>Default Width: 3</p>
                <p>Default Height: 60</p>
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-3">
              <div class="form-group">
                <br><br>
                <input type="submit" value="Submit" class="btn btn-success pull-left" />
              </div>
              </div>
            </div>
            </form>
          </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-4">

          <?php echo form_open_multipart('Voucher_c/update_logo') ?>

            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Company Logo</h3>
                <!-- <div class="box-tools pull-right">
                       
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>   
                </div> -->
              </div>
              <!-- /.box-header -->

              <center>
              <div class="box-body">
                <div class="timeline-body">

                  <?php if($logo == '' || $logo == 'NULL')
                  { ?>

                    <img src="<?php echo base_url('uploads/no_image.png'); ?>" alt="no image" height="190">

                  <?php }
                  else
                  { ?>

                    <img src="<?php echo base_url($logo); ?>" alt="no image" height="190" style="width: 100%;">

                  <?php } ?>
                  
                </div>
                <br>
                <div class="form-group">
                  <label for="exampleInputFile">Please choose an image (<span style="color: red;">Requirement: image size < 200kb</span>)</label>
                  <input type='file' name='userfile' id="userfile" size='20' required/>
                </div>
              </div>
              <!-- /.box-body -->
              </center>

              <div class="box-footer">
                <button type="submit" class="btn btn-success pull-left">Submit</button>
              </div>
            </div>
            <!-- /.box -->

          <?php echo "</form>"?>

        </div>
        <div class="col-md-8">
          <div class="box">
          <div class="box-header">
            <h3 class="box-title">Logo Size</h3>
          </div>
          <div class="box-body">
            <form method="post" action="<?php echo site_url('Voucher_c/submit'); ?>?logo">
            <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Logo Width</label>
                <input type="number" id="Width" name="Width" value="<?php echo $logo_width; ?>" class="form-control" placeholder="Logo Width">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Logo Height</label>
                <input type="number" id="Height" name="Height" value="<?php echo $logo_height; ?>" class="form-control" placeholder="Logo Height">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group" style="color:#8c8c8c; font-size:12px;">
                <p>Default Width: 300</p>
                <p>Default Height: 120</p>
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-3">
              <div class="form-group">
                <br><br>
                <input type="submit" value="Submit" class="btn btn-success pull-left" />
              </div>
              </div>
            </div>
            </form>
          </div>
          </div>
        </div>
        <div class="col-md-8">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Terms & Conditions
            </h3>
            <!-- tools box -->
            <!-- <div class="pull-right box-tools">
              <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div> -->
            <!-- /. tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body pad">
            <form method="post" action="<?php echo site_url('Voucher_c/submit'); ?>?template=<?php echo $template; ?>">
              <textarea class="textarea" name="tc" placeholder="Place T&C here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $tc; ?></textarea>
              <input type="submit" value="Submit" class="btn btn-success pull-left" />
            </form>
          </div>
        </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">

  $('.subject-list').on('change', function() {
    $('.subject-list').not(this).prop('checked', false);  
  });

</script>
<!-- <script type="text/javascript">
  
  function selectActive() 
  {
    var x = document.getElementById('logo_active').value;

    if(x == 1)
    {
      document.getElementById('userfile').required = true;
    }
    else
    {
      document.getElementById('userfile').required = false;
    }    
  }

</script> -->



