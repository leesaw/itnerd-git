<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Rolex Sale Report
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
            <div class="col-md-10">
                <div class="box box-danger">
                        
        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("sale/report_rolex_sale_result"); ?>" method="post">
            <div class="col-xs-3 col-md-2">
                ยี่ห้อ
                <div class="input-group">
                    <select id="brand" name="brand" class="form-control">
                        <?php foreach($brand_array as $loop) { ?>
                        <option value="<?php echo $loop->br_id."-".$loop->br_name; ?>"><?php echo $loop->br_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-5 col-md-3">
                ขายที่
                <div class="input-group">
                    <select id="shop" name="shop" class="form-control">
                        <option value="0-ทั้งหมด" selected>เลือกทั้งหมด</option>
                        <?php 
                            foreach($shop_array as $loop) { 
                        ?>
                        <option value="<?php echo $loop->sh_id."-".$loop->sh_name; ?>"><?php echo $loop->sh_name; ?>
                        </option>
                        <?php } ?>
                        <?php 
                            foreach($borrower_array as $loop) { 
                        ?>
                        <option value="<?php echo $loop->posbor_id."-".$loop->posbor_name; ?>"><?php echo $loop->posbor_name; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-3 col-md-2">
                เลือกวันที่เริ่มต้น : 
                <input type="text" class="form-control" id="startdate" name="startdate" value="" />
            </div>
            <div class="col-xs-3 col-md-2">
                สิ้นสุด :
                <input type="text" class="form-control" id="enddate" name="enddate" value="" />
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