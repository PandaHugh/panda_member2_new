

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

</style>

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

  <div class="row">
    <div class="col-md-12">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <!-- <h1 class="page-head-line">
          <a href="<?php echo site_url('Point_c')?>?column=<?php echo $column; ?>" class="btn btn-default btn-xs"  style="float:right;" >
            <i class="fa fa-arrow-left" style="color:#000"></i> Back</a>
      </h1> -->
      <h1>Pending Activation</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        
          
          <!-- /.box-header -->
          <div class="box-body">
            <div style="overflow-x:auto;">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Action</th>
                <th>AccountNo</th>
                <th>CardNo</th>
                <th>Name</th>
                <th>Point Balance</th>
                <th>Branch</th>
                <th>Created at</th>
                <th>Created by</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($record->result() as $row)
                { ?>

                <tr>
                  <td>
                    <a href="<?php echo site_url('Transaction_c/activation?scan_card&CardNo='.$row->CardNo)?>"><button class="btn btn-info btn-xs" style="text-align: center;">Activate</button></a>
                  </td>
                  <td><?php echo $row->AccountNo; ?></td>
                  <td><?php echo $row->CardNo; ?></td>
                  <td><?php echo $row->Name; ?></td>
                  <td style="float: right"><?php echo $row->Pointsbalance; ?></td>
                  <td><?php echo $row->branch ?></td>
                  <td><?php echo $row->IssueStamp; ?></td>
                  <td><?php echo $row->CREATED_BY; ?></td>
                </tr>
                
                <?php } ?>
               
              </tbody>
                
            </table>
            </div>
        </div>
        <!-- /.box -->