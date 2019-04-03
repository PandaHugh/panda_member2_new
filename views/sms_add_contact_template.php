<?php 
'session_start()' 
?>
<!--onload Init-->
<body>
  <section class="content-header">
      <h1><?php echo $title; ?>
      <button onclick="window.location.href='<?php echo site_url('Sms_c/contact_template')?>'" name="save" class="btn btn-default btn-sm" style="float: right" onclick="add_promo()"><span style="color:white"></span> <b>BACK</b></button></h1>
    </section>
  
  <section class="content">
    <div class="box">
            <!-- /.box-header -->
    <div class="box-body">

    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
            <div id="page-inner">
             <?php if($this->session->flashdata('msg')): ?>
            <strong><center><?php echo $this->session->flashdata('msg'); ?></center></strong>
            <?php endif; ?>
                      

                      <div class="row">
                          <div class="col-md-8">
                                
                            <div style="overflow-x:auto;">
                              <header><b>Choose Contact No</b></header>
                              <br>
                                <table id="sms_template_contact" class="table table-bordered table-hover">
                                <thead style="cursor:s-resize"> 
                                <tr> 
                                    <th>Card No</th> 
                                    <th>Account No</th> 
                                    <th>Expired Date</th>
                                    <th>IC No</th>
                                    <th>Phone No</th> 
                                    <th>Name</th> 
                                    <th style="text-align: center;">Action</th>
                                </tr> 
                                </thead> 
                                
                                </table>
                            </div>

                          </div>
                        

                        <div class="col-md-4 well" >
                          <header><b>Selected Contact No</b>
                            <?php if($this->session->userdata('message'))
            {
               echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
            } ?>
                          </header>
                          <br>
                          <table  class="table table-bordered">
                        <thead>
                        <tr>
                          <th>AccountNo</th>
                          <th>CardNo</th>
                          <th>Name</th>
                          <th>ContactNo</th>
                        </tr>
                        </thead>
                        <tbody>

                          <?php foreach($record->result() as $row)
                          { ?>

                          <tr>
                            <td><?php echo $row->account_no; ?></td>
                            <td><?php echo $row->card_no; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->contact_no; ?>
                              <a href="<?php echo site_url('Sms_c/add_contact_template?delete_list&AccountNo='.$row->account_no.'&contact_c_guid='.$row->contact_c_guid.'&guid='.$row->contact_guid)?>" style="float: right"><button title="Add to List" type="button" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-minus"></i></button></a>
                            </td>
                          </tr>
                          
                          <?php } ?>
                         
                        </tbody>
                          
                      </table>
                        </div>

                    </div>
            </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    </div>
    </div>
  </section>
 