<?php 
'session_start()' 
?>

<script src="<?php echo base_url('js/jquery.min.js');?>"></script>

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
  font-size:12px;
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
<body>
    
    <div class="box">
            <!-- /.box-header -->
    <div class="box-body">

    <div id="wrapper">

        <?php
        if($this->session->userdata('message'))
        {
           echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
        }
        ?>

    <center>
    <br>
      <form class="form-inline" role="form" method="POST" id="myForm" 
      action="<?php echo site_url('Log_c/search'); ?>">
          <div class="form-group">
              <select name="search"  class="form-control" id="sel1" style="background-color:white;color:black;width: 175px;margin-bottom: 5px" required>
                    <!--<option hidden>Search by:</option>-->
                    <option value="General">General Search:</option>
                    <option value="Type">Type:</option>
                    <option value="Account No">Account No:</option>
                    <option value="Field">Field:</option>
                    <option value="Created At">Created At:</option>
              </select>
              <span class="input-group-btn">
              <input type="text" class="form-control" placeholder="Search Log" name="log" id="textarea" required autofocus/>
              </span>
          </div>
      </form><br>
    </center>
      
          <div class="box-body">
            <div style="overflow-x:auto;">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Type</th>
                <th>Account No</th>
                <th>Reference No</th>
                <th>Field</th>
                <th>Value From</th>
                <th>Value To</th>
                <th>Created At</th>
                <th>Created By</th>
              </tr>
              </thead>
              <tbody>

                <?php 
                foreach($user_logs->result() as $row)
                { ?>

                  <tr>
                    <td><?php echo $row->Trans_type; ?></td>
                    <td><?php echo $row->AccountNo; ?></td>
                    <td><?php echo $row->ReferenceNo; ?></td>
                    <td><?php echo $row->Field; ?></td>
                    <td><?php echo $row->Value_from; ?></td>
                    <td><?php echo $row->Value_to; ?></td>
                    <td><?php echo $row->created_at; ?></td>
                    <td><?php echo $row->created_by; ?></td>
                  </tr>
                
                <?php } ?>

              </tbody>
            </table>
            </div>
          </div>
          <!-- /.box-body -->
      



