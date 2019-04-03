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
      <h1>Query</h1>
    </section>
    </div>
  </div>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
          <div class="box-header">
            <form method="post" action="<?php echo site_url('Query_c/submit'); ?>">
            <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Item Code <a style="color:red;">*</a></label>
                <input type="text" id="Item_Code" name="Item_Code" value="" class="form-control" placeholder="Item Code" required />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Description <a style="color:red;">*</a></label>
                <input type="text" id="Description" name="Description" value="<?php echo $Description; ?>" class="form-control" placeholder="Description" required>
              </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
              <label>Script <a style="color:red;">*</a></label>
                <textarea class="textarea" name="Script" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required><?php echo $Script; ?></textarea>
            </div>
            </div>
            <div class="row">
              <div class="col-md-3">
              <div class="form-group">
                <br>
                <input type="submit" class="btn btn-success pull-left" />
              </div>
              </div>
            </div>
            </form>
          </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->




