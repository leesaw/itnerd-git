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
            
            <h1>รับสินค้าเข้าคลัง</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?php echo form_open('item/save'); ?>
                                    <div class="form-group-sm">
                                            วันที่รับเข้า
                                            <input type="text" class="form-control" name="dateadd" id="dateadd" value="<?php echo $currentdate; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            รหัสสินค้า *
                                            <input type="text" class="form-control" name="itcode" id="itcode" value="<?php echo set_value('itcode'); ?>">
											<p class="help-block"><?php echo form_error('itcode'); ?></p>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        ประเภท *
                                        <select class="form-control" name="catid" id="catid">
										<?php 	if(is_array($cat_array)) {
												foreach($cat_array as $loop){
													echo "<option value='".$loop->itc_id."'>".$loop->itc_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
							<div class="col-md-2">
									<div class="form-group-sm">
                                        ยี่ห้อ *
                                        <select class="form-control" name="brandid" id="brandid">
										<?php 	if(is_array($brand_array)) {
												foreach($brand_array as $loop){
													echo "<option value='".$loop->br_id."'>".$loop->br_code." - ".$loop->br_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            รุ่นสินค้า *
                                            <input type="text" class="form-control" name="model" id="model" value="<?php echo set_value('model'); ?>">
											<p class="help-block"><?php echo form_error('model'); ?></p>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-striped row-border table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>Item Code</th>
				                                        <th>Ref. Code</th>
														<th>ชื่อ</th>
														<th width="80">จำนวน</th>
														<th>หน่วย</th>
														<th>จัดการ</th>
				                                    </tr>
				                                </thead>
												<tbody>
												<div class="form-group-sm">
													<?php for ($i=1; $i<10; $i++) { ?>
													<tr>
														<td><label name="itemcode_array" id="itemcode_array_"<?php echo $i; ?> ></label></td>
														<td><label name="refcode_array" id="refcode_array_"<?php echo $i; ?> ></label></td>
														<td><label name="itemname_array" id="itemname_array_"<?php echo $i; ?> ></label></td>
														<td><label name="quantity_array" id="quantity_array_"<?php echo $i; ?> ></label></td>
														<td><label name="uom_array" id="uom_array_"<?php echo $i; ?> ></label></td>
														<td> </td>
													</tr>
													<?php } ?>
												</div>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>	
						</div>		
						<div class="row">
							<div class="col-md-6">
									<button type="submit" class="btn btn-primary">  เพิ่มข้อมูลสินค้า  </button>
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
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 5000);
</script>
<script>
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
</script>
</body>
</html>