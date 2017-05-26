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

            <h1>รายละเอียดการคืนสินค้า</h1>
        </section>

<?php
foreach($stor_array as $loop) {
    $stor_id = $loop->stor_id;
    $stor_number = $loop->stor_number;
    $so_number = $loop->so_number;
    $datein = $loop->stor_issue;
    $shop_name = $loop->sh_code."-".$loop->sh_name;
    $addby = $loop->firstname." ".$loop->lastname;
    $confirmby = $loop->firstname_confirm." ".$loop->lastname_confirm;
    $dateadd = $loop->stor_dateadd;
    $confirmdate = $loop->stor_confirm_dateadd;
    $remark = $loop->stor_remark;
    $status = $loop->stor_status;
    $wh_from = $loop->wh_code." ".$loop->wh_name;
    $wh_in = $loop->wh_code_in." ".$loop->wh_name_in;
    $caseback = $loop->stor_has_serial;
}


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
                                          เลขที่คืนสินค้า
                                          <input type="text" class="form-control" name="stor_number" id="stor_number" value="<?php echo $stor_number; ?>" readonly>
                                  </div>
                          </div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            วันที่ขอคืน
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>" readonly>
                                    </div>
							              </div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        เลขที่ใบสั่งขาย
                                        <input type="text" class="form-control" name="so_number" id="so_number" value="<?php echo $so_number; ?>" readonly>
                                    </div>
                            </div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            ชื่อผู้ขอคืนสินค้า
                                            <input type="text" class="form-control" name="addby" id="addby" value="<?php echo $addby; ?>" readonly>
                                    </div>
							              </div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            วันที่บันทึกขอคืน
                                            <input type="text" class="form-control" name="dateadd" id="dateadd" value="<?php echo $dateadd; ?>" readonly>
                                    </div>
							              </div>

						</div>
            <br>
            <div class="row">
              <div class="col-md-2">
                      <div class="form-group-sm">
                              คลังเดิมที่ตัดขาย
                              <input type="text" class="form-control" name="wh_from" id="wh_from" value="<?php echo $wh_from; ?>" readonly>
                      </div>
              </div>
                <div class="col-md-2">
                        <div class="form-group-sm">
                                คลังที่รับคืน
                                <input type="text" class="form-control" name="wh_in" id="wh_in" value="<?php echo $wh_in; ?>" readonly>
                        </div>
                </div>
                <div class="col-md-2">
                <div class="form-group-sm">
                                      ชื่อผู้ทำการรับคืน
                                      <input type="text" class="form-control" name="confirmby" id="confirmby" value="<?php echo $confirmby; ?>" readonly>
                                  </div>
                          </div>
                          <div class="col-md-2">
                                  <div class="form-group-sm">
                                          วันที่บันทึกรับคืน
                                          <input type="text" class="form-control" name="confirmdate" id="confirmdate" value="<?php echo $confirmdate; ?>" readonly>
                                  </div>
                          </div>
                          <div class="col-md-2">
                                  <div class="form-group-sm">
                                          สถานะ
                                          <input type="text" class="form-control" name="status" id="status" value="<?php if($status==1) echo "รอยืนยันสินค้า"; elseif($status==2) echo "ยืนยันคืนสินค้าแล้ว"; elseif($status==3) echo "ยกเลิกแล้ว"; ?>" readonly>
                                  </div>
                          </div>

          </div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-6">
                                        <label id="count_all" class="text-red">จำนวน &nbsp;&nbsp; <?php echo count($item_array); ?> &nbsp;&nbsp; รายการ <?php if ($status == 3) echo "ยกเลิกแล้ว"; ?></label>
                                        </div></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>Ref. Code</th>
                                                        <th>ยี่ห้อ</th>
                                                        <th>รายละเอียด</th>
                                                        <th>ราคาขาย</th>
                                                        <th width="105">จำนวน</th>
														<th>หน่วย</th>
				                                    </tr>
				                                </thead>
												<tbody>
                          <?php
                            foreach($item_array as $loop_item) { ?>
                            <tr>
                              <td><?php echo $loop_item->it_refcode; ?></td>
                              <td><?php echo $loop_item->br_name; ?></td>
                              <td><?php echo $loop_item->it_model;
                                $count_serial = 0;
                                foreach($serial_array as $loop_serial) {
                                  if (($loop_serial->log_stor_item_id == $loop_item->log_stor_item_id) && ($loop_serial->itse_serial_number !="")) {

                                    echo "<br>Caseback : ".$loop_serial->itse_serial_number;
                                  }
                                }
                               ?></td>
                              <td><?php echo number_format($loop_item->it_srp, 2, '.', ','); ?></td>
                              <td><?php echo $loop_item->qty_update;  ?></td>
                              <td><?php echo $loop_item->it_uom; ?></td>

                            </tr>
                          <?php }   ?>
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
                                    <input type="text" class="form-control" name="saleorder_remark" id="saleorder_remark" value="<?php echo $remark; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
							<div class="col-md-12">
                <?php if($status!=3) { ?><a href="<?php if($loop->stor_status==1) echo site_url("tp_stock_return/print_return_request")."/".$loop->stor_id; else if($loop->stor_status==2) echo site_url("tp_stock_return/print_return_confirm")."/".$loop->stor_id; ?>" target="_blank"><button type="button" class="btn btn-primary<?php if($status==3) echo " disabled"; ?>" name="printbtn" id="printbtn"><i class='fa fa-print'></i>  พิมพ์ใบขอคืนสินค้า </button></a><?php } ?>&nbsp;&nbsp;
                  <?php if (($user_status == 1 || $user_status==3) && ($status == 1)) { ?>
                <button type="button" class="btn btn-danger pull-right" name="voidbtn" id="voidbtn" onclick="del_confirm()" <?php if ($status == 3) { echo "disabled"; } ?>><i class='fa fa-close'></i>  ยกเลิกการขอคืนสินค้า (Void) </button>&nbsp;&nbsp;
                <form action="<?php echo site_url("tp_stock_return/void_return")."/".$stor_id; ?>" method="post" name="form2" id ="form2"><input type="hidden" name="remarkvoid" id="remarkvoid" value=""></form>
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
    bootbox.confirm("ต้องการยกเลิกการสั่งขาย ที่เลือกไว้ใช่หรือไม่ ?", function(result) {
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
