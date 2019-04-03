<body>
	<div id="wrapper">
		<div id="page-inner">
			<div class="row">
    			<div class="col-md-12">
    				<section class="content-header">
    					<h1>Free Gift Redemption</h1>
    				</section>
    				<section class="content">
      					<div class="box box-default">
      						<?php
      							if(in_array('AFG', $_SESSION['module_code']))
      							{
      						?>
      						<div class="box-header">
      							<a href="<?php echo site_url('Point_c/add_free_gift'); ?>">
	      							<button class="btn btn-success btn-sm pull-right">
	      								<i class="fa fa-plus"></i>
	      							</button>
	      						</a>
      						</div>
      						<?php
      							}
      						?>
      						<div class="box-body">
      							<div style="overflow-x:auto;">
      								<table id="free_gift_table" class="table table-bordered table-striped">
      									<thead>
      										<tr>
      											<th>Ref No</th>
      											<th>Branch</th>
      											<th>Date</th>
                            <th>Date Redemption From</th>
                            <th>Date Redemption To</th>
      											<th>Description</th>
      											<th>Created At</th>
      											<th>Created By</th>
      											<th>Updated At</th>
      											<th>Updated By</th>
      											<th>Redemption</th>
      										</tr>
      									</thead>
      								</table>
      							</div>
      						</div>
      					</div>
      				</section>
    			</div>
    		</div>
		</div>
	</div>
</body>