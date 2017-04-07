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

            <h1>รายละเอียดรับสินค้าเข้าคลัง</h1>
        </section>

<?php
foreach($stock_array as $loop) {
    $datetime = $loop->stoi_datein;
    $si_id = $loop->stoi_number;
    $editor = $loop->firstname." ".$loop->lastname;
    $stock_name = $loop->wh_code."-".$loop->wh_name;
    $dateadd = $loop->stoi_dateadd;
    $status = $loop->stoi_status;
    $remark = $loop->stoi_remark;
    $caseback = $loop->stoi_has_serial;
    break;
}

// $caseback = count($serial_array);

?>

		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading"><strong></strong></div>

                    <div class="panel-body">
                        <div class="row">
                          <div class="col-md-2">
                                  <div class="form-group-sm">
                                          เลขที่ใบรับสินค้าเข้าคลัง
                                          <input type="text" class="form-control" name="stoi_number" id="stoi_number" value="<?php echo $si_id; ?>" readonly>
                                  </div>
                          </div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            วันที่รับเข้าคลัง
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datetime; ?>" readonly>
                                    </div>
							              </div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        คลังที่รับเข้า
                                        <input type="text" class="form-control" name="stock_name" id="stock_name" value="<?php echo $stock_name; ?>" readonly>
                                    </div>
                            </div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            ชื่อผู้ใส่ข้อมูล
                                            <input type="text" class="form-control" name="addby" id="addby" value="<?php echo $editor; ?>" readonly>
                                    </div>
							              </div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            วันที่บันทึก
                                            <input type="text" class="form-control" name="dateadd" id="dateadd" value="<?php echo $dateadd; ?>" readonly>
                                    </div>
							              </div>

						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-6">
                                        <label id="count_all" class="text-red">จำนวน &nbsp;&nbsp; <?php echo count($stock_array); ?> &nbsp;&nbsp; รายการ <?php if ($status == 'V') echo "ยกเลิกแล้ว"; ?></label>
                                        </div></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>Ref. Code</th>
                                                <th>ยี่ห้อ</th>
                                                <th>รายละเอียด</th>
                                                <th>จำนวน<br>ในคลัง</th>
                                                <th>จำนวน<br>รับเข้า</th>
                                                <th>จำนวน<br>ในคลังหลังรับเข้า</th>
										                            <th>หน่วยละ</th>
                                                <th>จำนวนเงิน</th>
				                                    </tr>
				                                </thead>
												<tbody>
                          <?php
                            foreach($stock_array as $loop) { ?>
                            <tr>
                              <td><?php echo $loop->it_refcode; ?></td>
                              <td><?php echo $loop->br_name; ?></td>
                              <td><?php
                              echo $loop->it_model;
                              if($caseback > 0) {
                                foreach ($serial_array as $loop2) {
                                  if ($loop->log_stob_item_id==$loop2->log_stob_item_id) {
                                    echo "<br>Caseback : ".$loop2->itse_serial_number;
                                  }
                                }
                              }
                              ?>
                              </td>
                              <td><?php echo $loop->qty_old." &nbsp; ".$loop->it_uom; ?></td>
                              <td><?php echo $loop->qty_update." &nbsp; ".$loop->it_uom; ?></td>
                              <td><?php echo ($loop->qty_old+$loop->qty_update)." &nbsp; ".$loop->it_uom; ?></td>
                              <td><?php echo number_format($loop->it_srp, 2, '.', ','); ?></td>
                              <td><?php echo number_format($loop->qty_update*$loop->it_srp, 2, '.', ','); ?></td>

                            </tr>
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
                                    <input type="text" class="form-control" name="remark" id="remark" value="<?php echo $remark; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
							<div class="col-md-12">
                <a href="<?php if ($caseback>0) { echo site_url("warehouse_transfer/importstock_serial_print")."/".$stoi_id; }
                else{ echo site_url("warehouse_transfer/importstock_print")."/".$stoi_id; } ?>
                " target="_blank"><button type="button" class="btn btn-primary" name="printbtn" id="printbtn"><i class='fa fa-print'></i>  พิมพ์ใบรับสินค้าเข้าคลัง </button></a>&nbsp;&nbsp;
                  <?php if($user_status == 1) { ?>
                <button type="button" class="btn btn-danger pull-right" name="voidbtn" id="voidbtn" onclick="del_confirm()" <?php if ($status == 'V') { echo "disabled"; } ?>><i class='fa fa-close'></i>  ยกเลิกการรับสินค้าเข้าคลัง (Void) </button>&nbsp;&nbsp;
                <form action="<?php echo site_url("warehouse_transfer/void_stock_in")."/".$stoi_id; ?>" method="post" name="form2" id ="form2"><input type="hidden" name="remarkvoid" id="remarkvoid" value=""></form>
                <?php } ?>
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
function del_confirm() {
    bootbox.confirm("ต้องการยกเลิกการรับสินค้าเข้าคลัง ที่เลือกไว้ใช่หรือไม่ ?", function(result) {
      var currentForm = this;
      if (result) {
          bootbox.prompt("เนื่องจาก..", function(result) {
            if (result === null) {
              document.getElementById("form2").submit();
            } else {
              document.getElementById("remarkvoid").value=result;
              document.getElementById("form2").submit();
            }
          });
      }

    });
}
</script>
</body>
</html>
