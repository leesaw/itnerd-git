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

            <h1>ยกเลิกการย้ายคลังสินค้า</h1>
        </section>

		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading">กรุณาตรวจสอบจำนวนสินค้า</div>

                    <div class="panel-body">
                        <div class="row">
                            <?php foreach($stock_array as $loop) { ?>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            เลขที่
                                            <input type="text" class="form-control" name="stot_number" id="stot_number" value="<?php echo $loop->stot_number; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            วันที่กำหนดส่ง
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $loop->stot_datein; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        ออกจากคลัง *
                                        <input type="hidden" name="wh_out_id" id="wh_out_id" value="<?php echo $loop->wh_out_id; ?>">
                                        <input type="text" class="form-control" name="whname_out" id="whname_out" value="<?php echo $loop->wh_out_code."-".$loop->wh_out_name; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-1">
                                <br><center><i class="fa fa-arrow-right"></i></center>
                            </div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        เข้าคลัง *
                                        <input type="hidden" name="wh_in_id" id="wh_in_id" value="<?php echo $loop->wh_in_id; ?>">
                                        <input type="text" class="form-control" name="whname_in" id="whname_in" value="<?php echo $loop->wh_in_code."-".$loop->wh_in_name; ?>" readonly>
                                    </div>
							</div>
                                <?php $status = $loop->stot_status; $stot_remark = $loop->stot_remark; break; } ?>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-6">
                                        <div class="input-group-btn">
                                        </div> <label id="count_all" class="text-red pull-left">จำนวน &nbsp;&nbsp; <?php echo count($stock_array); ?> &nbsp;&nbsp; รายการ<?php if ($status==2) echo "<label class='text-green'>&nbsp;&nbsp; ทำการยืนยันแล้ว</label>"; if ($status==3) echo "<label class='text-red'>&nbsp;&nbsp; ทำการยกเลิกแล้ว</label>"; ?></label>
                                        </div></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>Ref. Code</th>
                                                        <th>ยี่ห้อ</th>
                                                        <th>รุ่น</th>
                                                        <th>ราคาขาย</th>
                                                        <th>จำนวนคงเหลือ</th>
														<th width="105">จำนวนที่ต้องการ</th>
														<th>หน่วย</th>
				                                    </tr>
				                                </thead>
												<tbody>
                                                    <?php foreach($stock_array as $loop) { ?>
                                                    <tr>
                                                    <input type='hidden' name='it_id' id='it_id' value=" <?php echo $loop->log_stot_item_id; ?>">
                                                    <input type='hidden' name='log_id' id='log_id' value=" <?php echo $loop->log_stot_id; ?>">
                                                    <td><?php echo $loop->it_refcode; ?></td>
                                                    <td><?php echo $loop->br_name; ?></td>
                                                    <td><?php echo $loop->it_model; ?></td>
                                                    <td><?php echo number_format($loop->it_srp); ?></td>
                                                    <td><?php echo $loop->qty_old; ?></td>
                                                    <td><?php echo $loop->qty_update; ?></td>
                                                    <td><?php echo $loop->it_uom; ?></td></tr>
                                                    <?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
								<div class="col-md-6">
										<div class="form-group-sm">
												Remark
												<input type="text" class="form-control" name="stotremark" id="stotremark" value="<?php echo $stot_remark; ?>" readonly>
										</div>
								</div>
						</div>
						<br>
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-danger <?php if ($status>=2) echo "disabled"; ?>" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  ยกเลิกการย้ายคลัง </button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-primary" name="returnbtn" id="returnbtn" onclick="returnform()"><i class='fa fa-save'></i>  กลับไปหน้ารายการ-ย้ายคลังสินค้า </button>

							</div>
						</div>

					</div>
				</div>
			</div>
            </div></section>
	</div>
</div>
<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">

var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{
    document.getElementById("savebtn").disabled = false;

});

function submitform()
{
	bootbox.confirm("ยืนยันการยกเลิกการย้ายคลัง ที่เลือกไว้ใช่หรือไม่ ?", function(result) {
		var currentForm = this;
		if (result) {
				bootbox.prompt("เนื่องจาก..", function(result) {
					if (result === null) {
						alert("กรุณาใส่เหตุผลในการยกเลิก !!");
					} else {
						confirmform(result);
					}
				});
		}

	});
}

function returnform()
{
    window.location = "<?php echo site_url("warehouse_transfer/report_transferstock"); ?>";
}

function confirmform(remarkvoid = "")
{
    document.getElementById("savebtn").disabled = true;
    var stot_id = <?php echo $stot_id; ?>;
		var remark = document.getElementById("stotremark").value;
		remark = remark+"##VOID##"+remarkvoid;
    $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("warehouse_transfer/transferstock_disable_confirm"); ?>" ,
            data : {stot_id: stot_id, remark: remark} ,
            dataType: 'json',
            success : function(data) {
                location.reload();
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
                document.getElementById("savebtn").disabled = false;
            }
        });
}

</script>
</body>
</html>
