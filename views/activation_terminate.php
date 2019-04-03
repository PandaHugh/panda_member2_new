<style>

#scroll {
  height: 250px;
  overflow-y: scroll;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo base_url('assets/js/mykad.js'); ?>" language="javascript" type="text/javascript"> </script>
<script src="<?php echo base_url('js/jquery.min.js');?>"></script>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

</script>
<script src="<?php echo base_url('js/jquery.min.js');?>"></script>

<body onload="<?php echo $bodyload; ?>;selectNationality(this);">
  
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
    <div id="page-inner">

		<div class="row">
		    <div class="col-md-12">

		    <!-- Content Header (Page header) -->
		    <section class="content-header">
		      <h1><?php echo $button?></h1>
		    </section>
		    <section class="content">
		      <div class="box box-default">
		        <div class="box-body">
		          <div class="row">
		            <div class="col-md-12 text-center">
		            	<form id='save' method="post" action="<?php echo site_url('Pending_c/reactivate')?>">


		            	<input type="hidden" name="accountno" value="<?php echo $account?>"/>
		            	<input type="hidden" name="ic_no" value="<?php echo $ic_no?>"/>
		            	<input type="hidden" name="branch" value="<?php echo $branch?>"/>
		            	<input type="hidden" name="mobile_no" value="<?php echo $mobile_no?>"/>
		            	<input type="hidden" name="national" value="<?php echo $nationality?>"/>
		            	<input type="hidden" name="army_no" value="<?php echo $army_no?>"/>
		            	<input type="hidden" name="email" value="<?php echo $email?>"/>
		            	<input type="hidden" name="active" value="TERMINATE"/>

		            	<h3>IC No already exist!</h3>
		            	<h3>IC No : <i style="color: blue"><?php echo $ic_no?></i></h3>
		            	<h3>Do You Want To Terminate Existing Account No?</h3>
		            	<h3>Old Account No : <i style="color: blue"><?php echo $account?></i></h3>
		            	<br><br><br>

						<button type="submit" class="btn btn-success">Confirm</button>
                      	<button type="button" class="btn btn-danger" onclick="goBack()" style="margin-right: 15px;">Cancel</button>


                      </form>
		            </div>
		        </div>
		    </div>
		</div>
	</section>


		</div>
	</div>
    </div>
</div>

<script>
function goBack() {
    window.history.back();
}
</script>