<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
        <div class="content-wrapper">
        <section class="content-header">
            
            <h1>เพิ่มข้อมูลคลังสินค้า</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่องที่มี *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <form name="form1" id="form1" action="<?php echo site_url('warehouse/newwarehouse_save'); ?>" method="post">
                                    <div class="form-group">
                                            Warehouse Name *
                                            <input type="text" class="form-control" name="whname" id="whname" value="<?php echo set_value('whname'); ?>">
											<p class="help-block"><?php echo form_error('whname'); ?></p>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                            Warehouse Code *
                                            <input type="text" class="form-control" name="whcode" id="whcode" value="<?php echo set_value('whcode'); ?>">
											<p class="help-block"><?php echo form_error('whcode'); ?></p>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                        Group *
                                        <select class="form-control" name="wgid" id="wgid">
										<?php 	if(is_array($whgroup_array)) {
												foreach($whgroup_array as $loop){
													echo "<option value='".$loop->wg_id."'>".$loop->wg_code." - ".$loop->wg_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
									<button type="button" name="savebtn" id="savebtn"  class="btn btn-primary" onclick="disablebutton()">  บันทึก </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("warehouse/manage"); ?>'"> ยกเลิก </button>
							</div>
						</div>
								
									
						</form>

					</div>
				</div>
			</div>	
            </div></section>
	</div>
</div>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<?php $this->load->view('js_footer'); ?>
<script>
$(document).ready(function()
{    
    //document.getElementById("savebtn").disabled = false;

});
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 5000);

function autobarcode(obj) {
	var input=$(obj).val();
	$('#barcode').val(input);
}
function disablebutton() {
    document.getElementById("savebtn").disabled = true;
    
    document.getElementById("form1").submit();
}
</script>
</body>
</html>