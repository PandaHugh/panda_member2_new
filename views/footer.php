 <!--<div id="footer-sec">
        &copy; Panda Software House Sdn. Bhd.
    </div>-->

    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-1.10.2.js'?>"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
    <!-- METISMENU SCRIPTS -->
    <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.metisMenu.js'?>"></script>
    <!-- CUSTOM SCRIPTS -->
    <script type="text/javascript" src="<?php echo base_url().'assets/js/custom.js'?>"></script>

    
    <!-- BOOTSTRAP SELECT -->
    <script>
      $(document).ready(function () {
        var mySelect = $('#first-disabled2');

        $('#special').on('click', function () {
          mySelect.find('option:selected').prop('disabled', true);
          mySelect.selectpicker('refresh');
        });

        $('#special2').on('click', function () {
          mySelect.find('option:disabled').prop('disabled', false);
          mySelect.selectpicker('refresh');
        });

        $('#basic2').selectpicker({
          liveSearch: true,
          maxOptions: 1
        });
      });
    </script>

    <!--TABLE CUSTOM -->
    <script type="text/javascript" src="<?php echo base_url().'assets/tablesorter/jquery-latest.js'?>"></script> 
    <script type="text/javascript" src="<?php echo base_url().'assets/tablesorter/jquery.tablesorter.js'?>"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/template/vendor/jquery/jquery.min.js');?>"></script>
    <sccrpt type="text/javascript" src="<?php echo base_url().'assets/js/jquery-1.10.2.js'?>"></script>
    

</body>
</html>