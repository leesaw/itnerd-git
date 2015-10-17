<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
</head>

<body class="skin-purple">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            NGG Timepiece - Reports
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("jes/watch"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Reports</li>
        </ol>
    </section>
	<!-- Main content -->
    <section class="content">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <form action="<?php echo site_url("jes/report_filter"); ?>" method="post">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Warehouse Type : </label>
                                        <select class="form-control" name="whtype" id="whtype">
                                            <option value="0">--- All ---</option>
										<?php 	if(is_array($whtype_array)) {
												foreach($whtype_array as $loop){
													echo "<option value='".$loop->WTCode."'>".$loop->WTDesc1."</option>";
										 } } ?>
                                        </select>
                                    </div>
							    </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Warehouse Type : </label>
                                        <select class="form-control" name="whtype" id="whtype">
										<?php 	if(is_array($whtype_array)) {
												foreach($whtype_array as $loop){
													echo "<option value='".$loop->WTCode."'>".$loop->WTDesc1."</option>";
										 } } ?>
                                        </select>
                                    </div>
							    </div>
                                
                            </div>
                            <div class="box-body">

                            </div>
                            <div class="box-footer">

                            </div>
                        </div>
                    </div>
                    </div>
                        </form>
                </div>
            </div>
        </div>
    </section>
          
          
          
</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.barnumbers.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>WTCode
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">

$(function () {


});
    
$(document).ready(function()
{
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
});
</script>
</body>
</html>