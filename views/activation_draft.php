<style>

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
<body onload="selectNationality(this)">
  
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
    <div id="page-inner">
                    

  <div class="row">
    <div class="col-md-12">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Member Card</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
            <form method="post" action="<?php echo site_url('login_c/full_details'); ?>">
              <div class="form-group">
                <label>Card No.</label>
                <input id="highlight" type="text" name="card_no" class="form-control" placeholder="Scan Card No" required autofocus>
                <?php
                if($this->session->userdata('message'))
                {
                  echo "<br>";
                   echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                }
                ?>
              </div>
            </form>
            
            </div>
          </div>
          <!-- /.row -->
        </div>

      </div>
      
    </section>

    <!-- confirm modal @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@-->
<div class="modal fade" id="delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="text-align: center">Confirm Delete?</h3>
            </div> -->
            <div class="modal-body">
                <h4 class="modal_detail" style="text-align: center"></h4>
            </div>
            <div class="modal-footer" style="text-align: center">
            <span id="preloader-delete"></span>
                <a id="url" href=""><button type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button></a>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End confirm modal modal -->

    <script type="text/javascript">
      
    function isNumberKey(evt)
    {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }

    function selectNationality(obj) 
    {
        var select = document.getElementById('national').options[document.getElementById('national').options.selectedIndex].value.toUpperCase();
        if ( select == 'MALAYSIAN' || select == 'MALAYSIA' )
        {
            document.getElementById('icno').disabled = false;
            document.getElementById('oldicno').disabled = false;
            document.getElementById('passno').disabled = true;
        }
        else if ( select != 'MALAYSIAN' && select == 'MALAYSIA' )
        {
            document.getElementById('icno').disabled = true;
            document.getElementById('oldicno').disabled = true;
            document.getElementById('passno').disabled = false;
        }
    }

    function confirm_modal(delete_url)
    {
      $('#delete').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 

      var modal = $(this)
      modal.find('.modal_detail').text('Confirm delete ' + button.data('name') + '?')
      document.getElementById('url').setAttribute("href" , delete_url );
      });
    }

    </script>
 
 