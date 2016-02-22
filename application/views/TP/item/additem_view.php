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
            
            <h1>เพิ่มข้อมูลสินค้า</h1>
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
                                <form name="form1" id="form1" action="<?php echo site_url('item/save'); ?>" method="post">
                                    <div class="form-group">
                                            Ref. Number *
                                            <input type="text" class="form-control" name="refcode" id="refcode" value="<?php echo set_value('refcode'); ?>">
											<p class="help-block"><?php echo form_error('refcode'); ?></p>
                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                        ประเภท *
                                        <select class="form-control" name="catid" id="catid">
										<?php 	if(is_array($cat_array)) {
												foreach($cat_array as $loop){
													echo "<option value='".$loop->itc_id."'>".$loop->itc_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                        ยี่ห้อ *
                                        <select class="form-control" name="brandid" id="brandid">
										<?php 	if(is_array($brand_array)) {
												foreach($brand_array as $loop){
													echo "<option value='".$loop->br_id."'>".$loop->br_code." - ".$loop->br_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                            รุ่นสินค้า *
                                            <input type="text" class="form-control" name="model" id="model" value="<?php echo set_value('model'); ?>">
											<p class="help-block"><?php echo form_error('model'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
                            <div class="col-md-3">
									<div class="form-group">
                                            หน่วยนับ *
                                            <input type="text" class="form-control" name="uom" id="uom" value="<?php echo set_value('uom'); ?>">
											<p class="help-block"><?php echo form_error('uom'); ?></p>
                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                            จำนวนเตือนขั้นต่ำ *
                                            <input type="text" class="form-control" name="minstock" id="minstock" value="<?php echo set_value('minstock'); ?>">
											<p class="help-block"><?php echo form_error('minstock'); ?></p>
                                    </div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
                                            Short Description
                                            <input type="text" class="form-control" name="short" id="short" value="<?php echo set_value('short'); ?>">
											<p class="help-block"><?php echo form_error('short'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
                            <div class="col-md-3">
									<div class="form-group">
                                            ราคาทุน *
                                            <input type="text" class="form-control" name="cost" id="cost" onChange="numberWithCommas(this);" value="<?php echo set_value('cost'); ?>">
											<p class="help-block"><?php echo form_error('cost'); ?></p>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                            ราคาขาย *
                                            <input type="text" class="form-control" name="srp" id="srp" onChange="numberWithCommas(this);" value="<?php echo set_value('srp'); ?>">
											<p class="help-block"><?php echo form_error('srp'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9">
									<div class="form-group">
                                            Long Description
											<textarea class="form-control" name="long" id="long" rows="3"><?php echo set_value('long'); ?></textarea>
											<p class="help-block"><?php echo form_error('long'); ?></p>
                                    </div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
									<button type="button" name="savebtn" id="savebtn"  class="btn btn-primary" onclick="disablebutton()">  เพิ่มข้อมูลสินค้า  </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("item/manage"); ?>'"> ยกเลิก </button>
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

function numberWithCommas(obj) {
	var x=$(obj).val();
    var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/,/g,"");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $(obj).val(parts.join("."));
}
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