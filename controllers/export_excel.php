

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

#scroll {
  height: 250px;
  overflow-y: scroll;
}

#dragndrop{
  height:100%;
  width:100%;
  background-image:url('../assets/img/drag-drop-file-uploading.gif') ;
  background-repeat: no-repeat; 
  background-size: 100% 100%;
}

</style>

<script type="text/javascript">


</script>

<body>
    
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
    <div id="page-inner">

        
                    
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
      <h1>Export / Import Excel </h1>
      <?php
        if($this->session->userdata('message'))
        {
           echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
        }
        ?>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            
            <div class="col-md-6">
              <h4><b>Export to excel</b></h4>
              <br>
                <form class="form-inline" role="form" method="POST" id="myForm" 
                action="<?php echo site_url('Export_excel_c'); ?>?search">
                    
                    <div class="form-group">
                      <label class="control-label col-md-3" for="radios">Search Mode</label>
                      <div class="col-md-9"> 
                        <label class="radio-inline" for="radios-0">
                          <input type="radio" name="search_mode" value="Expiry" required>
                          Expiry Date
                        </label> 
                        <label class="radio-inline" for="radios-1">
                          <input type="radio" name="search_mode" value="Issue" required>
                          Issue Date
                        </label> 
                        <label class="radio-inline" for="radios-2">
                          <input type="radio" name="search_mode" value="Branch" required>
                          Branch
                        </label>
                        <label class="radio-inline" for="radios-2">
                          <input type="radio" name="search_mode" value="Merchant" required>
                          Merchant
                        </label>
                      </div>
                    </div>
                    <br><br>
                    
                    <div id="methodExpiry" class="desc" style="display: none;">
                        <div class="form-group"  id="div1" >
                        <label class="control-label col-md-3">Expiry Date</label> 
                            <div class="col-md-9">
                            <label>From</label>
                            <input type="date" name="expiryfrom" class="form-control">
                            <br><br>
                            <label>to</label>
                            <input type="date" name="expiryto" class="form-control">
                            </div> 
                        </div>
                    </div>

                    <div id="methodIssue" class="desc" style="display: none;">
                        <div class="form-group"  id="div1">
                        <label class="control-label col-md-3">Issue Date</label> 
                            <div class="col-md-9">
                            <label>From</label>
                            <input type="date" name="issuefrom" class="form-control">
                            <br><br>
                            <label>to</label>
                            <input type="date" name="issueto" class="form-control">
                            </div> 
                        </div>
                    </div>

                    <div id="methodBranch" class="desc" style="display: none;">
                        <div class="form-group"  id="div1" >
                            <label class="control-label col-md-3">Branch</label> 
                            <div class="col-md-9">
                            <select class="form-control" name="branch" id='branch' required>
                              <?php
                              foreach($branch->result() as $row)
                              {
                                ?>
                                  <option required value="<?php echo $row->branch_code?>"><?php echo $row->branch_name; echo "&nbsp (".$row->branch_code.")"?></option>
                                <?php
                              }
                              ?>
                            </select>
                            </div> 
                        </div>
                    </div>

                    <div id="methodMerchant" class="desc" style="display: none;">
                        <div class="form-group"  id="div1" >
                            <label class="control-label col-md-3">Merchant</label> 
                            <div class="col-md-9">
                            <select class="form-control" name="merchant" id='merchant' required>
                              <?php
                              foreach($merchant->result() as $row)
                              {
                                ?>
                                  <option required value="<?php echo $row->merchant_id?>"><?php echo $row->merchant_id; ?></option>
                                <?php
                              }
                              ?>
                            </select>
                            </div> 
                        </div>
                    </div>

                    <button style="margin-left: 15px" title="Search" id="create" type="submit" class="btn btn-primary btn-xs" >Search</button>
                  </form>

                  <?php
                  if(isset($_REQUEST['search']))
                  {
                    ?>
                    <a href="<?php echo site_url('Export_excel_c/export_excel')?>"><button type="submit" class="btn btn-success btn-xs" style="float:right"><b><i class="fa">&#xf1c3;</i> EXPORT</b></button></a> 
                    <?php
                  }
                  ?>
                  

                    <br><br>
                    <div style="overflow-x:auto;height: 250px" >
                      <table id="" class="table table-bordered table-hover" >
                        <thead style="cursor:s-resize"> 
                        <tr> 
                            <th>Account No</th> 
                            <th>Name</th>
                            <th>Point Balance</th> 
                            <th>Expiry Date</th>
                            <th>Issue Date</th>
                            <?php
                            if(isset($_SESSION['search_type']))
                            {
                              ?>
                              <th>Merchant</th>
                              <?php
                            }
                            else
                            {
                              ?>
                              <th>Branch</th> 
                              <?php
                            }
                            ?>
                        </tr> 
                        </thead> 
                        <tbody>
                        <?php foreach($search_data->result() as $row)
                        { ?>

                        <tr>
                          <td><?php echo $row->AccountNo; ?></td>
                          <td><?php echo $row->Name; ?></td>
                          <td><?php echo $row->Pointsbalance; ?></td>
                          <td><?php echo $row->Expirydate; ?></td>
                          <td><?php echo $row->Issuedate; ?></td>
                          <?php
                            if(isset($_SESSION['search_type']))
                            {
                              ?>
                              <td><?php echo $row->merchant_id; ?></td>
                              <?php
                            }
                            else
                            {
                              ?>
                              <td><?php echo $row->branch; ?></td>
                              <?php
                            }
                            ?>
                        </tr>
                        
                        <?php } ?>
                        </tbody> 
                        </table>
                    </div>
                
            </div>

            <div class="col-md-6">
              <h4><b>Import from excel</b></h4>
              <?php echo form_open_multipart('exceldatainsert/ExcelDataAdd');?>                      
              <!-- <label>Excel File:</label>      -->                   
              <input id="dragndrop" type="file" name="userfile" style="height:300px;width:100%;background-image:url('../assets/img/drag-drop-file-uploading.gif') "/>
              <br>                        
              <input type="submit" value="Upload" name="upload" class="form-control btn-primary" />
              </form> 
            </div>

          </div>
        </div>
      
      </div>
      <!-- /.box -->

      <!-- <div class="box box-default">
        
        <div class="box">
          <div class="box-body">
            
          </div>
          
        </div>
         -->
      </div>
      
    </section>
