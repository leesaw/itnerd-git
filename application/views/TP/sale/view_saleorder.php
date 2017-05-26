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

            <h1>รายละเอียดการสั่งขาย (Sale Order)</h1>
        </section>

<?php
foreach($so_array as $loop) {
    $so_id = $loop->so_id;
    $number = $loop->so_number;
    $datein = $loop->so_issuedate;
    $shop_name = $loop->sh_code."-".$loop->sh_name;
    $addby = $loop->firstname." ".$loop->lastname;
    $dateadd = $loop->so_dateadd;
    $remark = $loop->so_remark;
    $status = $loop->so_status;
		$on_top_baht = $loop->so_ontop_baht;
}

$caseback = count($serial_array);

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
                                          เลขที่ใบสั่งขาย
                                          <input type="text" class="form-control" name="saleorder_number" id="saleorder_number" value="<?php echo $number; ?>" readonly>
                                  </div>
                          </div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            วันที่ขาย
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>" readonly>
                                    </div>
							              </div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        สาขาที่ขาย
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php echo $shop_name; ?>" readonly>
                                    </div>
                            </div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            ชื่อผู้ใส่ข้อมูล
                                            <input type="text" class="form-control" name="addby" id="addby" value="<?php echo $addby; ?>" readonly>
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
                                        <label id="count_all" class="text-red">จำนวน &nbsp;&nbsp; <?php echo count($item_array); ?> &nbsp;&nbsp; รายการ <?php if ($status == 'V') echo "ยกเลิกการสั่งขายแล้ว"; ?></label>
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
                                                        <?php if ($caseback >0) { ?>
														<th width="100">Caseback</th>
                                                        <?php }else{ ?>
                                                        <th width="105">จำนวน</th>
                                                        <?php } ?>
														<th>หน่วย</th>
                                                        <th width="500">Barcode</th>
				                                    </tr>
				                                </thead>
												<tbody>
                          <?php
                          if ($caseback >0) {
                            foreach($serial_array as $loop_item) { ?>
                            <tr>
                              <td><?php echo $loop_item->it_refcode; ?></td>
                              <td><?php echo $loop_item->br_name; ?></td>
                              <td><?php echo $loop_item->it_model; ?></td>
                              <td><?php echo number_format($loop_item->it_srp, 2, '.', ','); ?></td>
                              <td><?php echo $loop_item->itse_serial_number; ?></td>
                              <td><?php echo $loop_item->it_uom; ?></td>
                              <td>
                                <?php
                                if ($loop_item->soi_sale_barcode_id > 0) echo "Discount ".$loop_item->sb_discount_percent." % GP ".$loop_item->sb_gp." % ( ".$loop_item->sb_number." )";
                                else if ($loop_item->soi_sale_barcode_id == 0) echo "ไม่มีบาร์โค้ดห้าง";
                                else if ($loop_item->soi_sale_barcode_id == -1) echo "Discount ".$loop_item->soi_dc_percent." % GP ".$loop_item->soi_gp." % Discount ".$loop_item->soi_dc_baht." บาท";
                                ?>
                              </td>

                            </tr>


                          <?php } }else{
                            foreach($item_array as $loop_item) { ?>
                            <tr>
                              <td><?php echo $loop_item->it_refcode; ?></td>
                              <td><?php echo $loop_item->br_name; ?></td>
                              <td><?php echo $loop_item->it_model; ?></td>
                              <td><?php echo number_format($loop_item->it_srp, 2, '.', ','); ?></td>
                              <td><?php echo $loop_item->soi_qty; ?></td>
                              <td><?php echo $loop_item->it_uom; ?></td>
                              <td>
                                <?php
                                if ($loop_item->soi_sale_barcode_id > 0) echo "Discount ".$loop_item->sb_discount_percent." % GP ".$loop_item->sb_gp." % ( ".$loop_item->sb_number." )";
                                else if ($loop_item->soi_sale_barcode_id == 0) echo "ไม่มีบาร์โค้ดห้าง";
                                else if ($loop_item->soi_sale_barcode_id == -1) echo "Discount ".$loop_item->soi_dc_percent." % GP ".$loop_item->soi_gp." % Discount ".$loop_item->soi_dc_baht." บาท";
                                ?>
                              </td>

                            </tr>
                          <?php }  } ?>
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
									<?php $i = 0; foreach($return_array as $loop) {
										if($i == 0) echo "<b class='text-red'>เอกสารคืนสินค้า : </b>";
										echo "<a href='".site_url("tp_stock_return/print_return_confirm")."/".$loop->stor_id."' target='_blank'>".$loop->stor_number."</a>";
										$i++; } ?>
									<?php if ($i > 0) echo "<br><br>"; ?>
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
														<div class="col-md-2">
                                <div class="form-group-sm">
                                    <div class="text-red">ส่วนลดท้ายบิล (บาท)</div>
                                    <input type="text" class="form-control" name="on_top_baht" id="on_top_baht" value="<?php echo number_format($on_top_baht, 2, '.', ','); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
							<div class="col-md-12">
                <a href="<?php echo site_url("sale/saleorder_print")."/".$so_id; ?>" target="_blank"><button type="button" class="btn btn-primary" name="printbtn" id="printbtn"><i class='fa fa-print'></i>  พิมพ์ใบสั่งขาย </button></a>&nbsp;&nbsp;
                  <?php if($user_status == 1) { ?>
                <button type="button" class="btn btn-danger pull-right" name="voidbtn" id="voidbtn" onclick="del_confirm()" <?php if ($status == 'V') { echo "disabled"; } ?>><i class='fa fa-close'></i>  ยกเลิกการสั่งขาย (Void) </button>&nbsp;&nbsp;
                <form action="<?php echo site_url("sale/void_saleorder")."/".$so_id; ?>" method="post" name="form2" id ="form2"><input type="hidden" name="remarkvoid" id="remarkvoid" value=""></form>
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
