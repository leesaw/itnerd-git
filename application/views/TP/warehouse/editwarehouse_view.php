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

            <h1>แก้ไขข้อมูลคลังสินค้า</h1>
        </section>

<?php
foreach ($wh_array as $loop) {
  $wh_id = $loop->wh_id;
  $wh_name = $loop->wh_name;
  $wh_code = $loop->wh_code;
  $wh_detail = $loop->wh_detail;
  $wh_address1 = $loop->wh_address1;
  $wh_address2 = $loop->wh_address2;
  $wh_taxid = $loop->wh_taxid;
  $wh_branch = $loop->wh_branch;
  $wh_group = $loop->wg_id;
}


?>

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
                                <form name="form1" id="form1" action="<?php echo site_url('warehouse/edit_warehouse_save'); ?>" method="post">
                                <input type="hidden" name="whid" value="<?php echo $wh_id; ?>"/>
                                    <div class="form-group">
                                            Warehouse Name *
                                            <input type="text" class="form-control" name="whname" id="whname" value="<?php echo $wh_name; ?>">
											<p class="help-block"><?php echo form_error('whname'); ?></p>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                            Warehouse Code *
                                            <input type="text" class="form-control" name="whcode" id="whcode" value="<?php echo $wh_code; ?>">
											<p class="help-block"><?php echo form_error('whcode'); ?></p>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                        Group *
                                        <select class="form-control" name="wgid" id="wgid">
										<?php 	if(is_array($whgroup_array)) {
												foreach($whgroup_array as $loop){
													echo "<option value='".$loop->wg_id."'";
                          if ($wh_group == $loop->wg_id) echo " selected";
                          echo ">".$loop->wg_code." - ".$loop->wg_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
										ชื่อบริษัท
										<input type="text" class="form-control" name="detail" id="detail" value="<?php echo $wh_detail; ?>">
										<p class="help-block"><?php echo form_error('detail'); ?></p>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
										เลขที่ผู้เสียภาษี
										<input type="text" class="form-control" name="taxid" id="taxid" value="<?php echo $wh_taxid; ?>">
										<p class="help-block"><?php echo form_error('taxid'); ?></p>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
										สาขาที่ ( 0 = สำนักงานใหญ่ )
										<input type="text" class="form-control" name="branch" id="branch" value="<?php echo $wh_branch; ?>">
										<p class="help-block"><?php echo form_error('branch'); ?></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
										ที่อยู่บริษัท แถว 1
										<input type="text" class="form-control" name="address1" id="address1" value="<?php echo $wh_address1; ?>">
										<p class="help-block"><?php echo form_error('address1'); ?></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
										ที่อยู่บริษัท แถว 2
										<input type="text" class="form-control" name="address2" id="address2" value="<?php echo $wh_address2; ?>">
										<p class="help-block"><?php echo form_error('address2'); ?></p>
								</div>
							</div>
						</div>
						<hr/>
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
