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

            <h1>ข้อมูลสินค้า</h1>
        </section>

		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading"></div>

                    <div class="panel-body">
                        <div class="row">
                        <?php foreach($product_array as $loop) { ?>
                            <div class="col-md-3">
                                    <div class="form-group">
                                            Ref. Number
                                            <input type="text" class="form-control" name="refcode" id="refcode" value="<?php echo $loop->it_refcode; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                        ประเภท
                                        <input type="text" class="form-control" name="catname" id="catname" value="<?php echo $loop->itc_name; ?>" readonly>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                        ยี่ห้อ
                                        <input type="text" class="form-control" name="itcode" id="itcode" value="<?php echo $loop->br_code."-".$loop->br_name; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                            Family
                                            <input type="text" class="form-control" name="model" id="model" value="<?php echo $loop->it_model; ?>" readonly>
                                    </div>
							</div>
						</div>
						<div class="row">
                            <div class="col-md-3">
									<div class="form-group">
                                            หน่วยนับ
                                            <input type="text" class="form-control" name="uom" id="uom" value="<?php echo $loop->it_uom; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                            จำนวนเตือนขั้นต่ำ
                                            <input type="text" class="form-control" name="minstock" id="minstock" value="<?php echo $loop->it_min_stock; ?>" readonly>
                                    </div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
                                            Short Description
                                            <input type="text" class="form-control" name="short" id="short" value="<?php echo $loop->it_short_description; ?>" readonly>
                                    </div>
							</div>
						</div>
						<div class="row">
                            <div class="col-md-3">
									<div class="form-group">
                                            ราคาทุน
                                            <input type="text" class="form-control" name="cost" id="cost" value="<?php if ($cost == 1) echo number_format($loop->it_cost_baht,2,'.',','); ?>" readonly>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                            ราคาขาย
                                            <input type="text" class="form-control" name="srp" id="srp" value="<?php echo number_format($loop->it_srp,2,'.',','); ?>" readonly>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
										<br>
										<input type="radio" name="caseback" id="caseback0" value="0"<?php if($loop->it_has_caseback == 0) echo " checked"; ?> disabled> <label class="text-green"> No Caseback</label>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
										<input type="radio" name="caseback" id="caseback1" value="1"<?php if($loop->it_has_caseback == 1) echo " checked"; ?> disabled> <label class="text-red"> Caseback</label>
									<p class="help-block"><?php echo form_error('caseback'); ?></p>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
	                    <div class="text-red">BRACELET (สำหรับ Rolex เท่านั้น : OYSTER, JUBILEE)</div>
	                    <input type="text" class="form-control" name="remark" id="remark" value="<?php echo $loop->it_remark; ?>" readonly>
											<p class="help-block"><?php echo form_error('remark'); ?></p>
                  </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9">
									<div class="form-group">
                                            Long Description
											<textarea class="form-control" name="long" id="long" rows="3" readonly><?php echo $loop->it_long_description; ?></textarea>
                                    </div>
							</div>
						</div>
                        <?php } ?>
						<div class="row">
							<div class="col-md-6">
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("item/manage"); ?>'"> ยกเลิก </button>
							</div>
						</div>

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
