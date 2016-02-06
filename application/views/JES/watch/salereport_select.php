<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-purple">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Sale Report <small>NGG Timepieces</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("jes_salereport/salereport_graph"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Sale Report</li>
        </ol>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                        
        <div class="box-body">
        <div class="row">
            <form class="form-inline" role="form" action="<?php echo site_url("jes_salereport/show_salereport"); ?>" method="post" target="_blank">
            <div class="col-xs-12">
                <label>เลือกยี่ห้อ : </label>
                <div class="input-group">
                    <select id="brand" name="brand" class="form-control">
                        <option value="0" selected>เลือกทั้งหมด</option>
                        <?php foreach($brand_array as $loop) { ?>
                        <option value="<?php echo $loop->PTCode; ?>"><?php echo $loop->PTDesc1; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label> &nbsp;&nbsp;&nbsp;&nbsp;เลือก Shop : </label>
                <div class="input-group">
                    <select id="shop" name="shop" class="form-control">
                        <option value="0" selected>เลือกทั้งหมด</option>
                    <?php foreach($shop_array as $loop) { ?>
                        <option value="<?php echo $loop->SHCode; ?>"><?php echo $loop->SHDesc1; ?>
                        </option>
                    <?php }  ?>
                    </select>
                </div>
                <br><br>
                <div class="form-group">
                    <label for="">เลือกวันที่เริ่มต้น : </label>
					<input type="text" class="form-control" id="startdate" name="startdate" value="" />
				</div>
				<div class="form-group">
					<label for=""> &nbsp;&nbsp;&nbsp;&nbsp; สิ้นสุด : </label>
					<input type="text" class="form-control" id="enddate" name="enddate" value="" />
				</div>
            </div>

        </div>
        <br>
            <div class="row"><div class="col-md-3"><button type="submit" name="action" value="0" class="btn btn-success"><i class="fa fa-search"></i> ค้นหา</button></div></div>           
                        
        </form>               
                        
					</div>
                </div>
            </div>
        </div>
        </section>
          
          
          
</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script type="text/javascript">
    
$(document).ready(function()
{    
    get_datepicker("#startdate");
    get_datepicker("#enddate");
    
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
});
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}
</script>
</body>
</html>