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

            <h1>ยืนยันการขอคืนสินค้า</h1>
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
                                            <input type="text" class="form-control" name="stor_number" id="stor_number" value="<?php echo $loop->stor_number; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                            วันที่คืน
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php $datein = explode('-', $loop->stor_issue);
    echo $datein[2]."/".$datein[1]."/".$datein[0]; ?>" readonly>
                                    </div>
							</div>
                    <div class="col-md-2">
									<div class="form-group-sm">
                                        คลังเดิม *
                                        <input type="text" class="form-control" name="wh_old" id="wh_old" value="<?php echo $loop->wh_code."-".$loop->wh_name; ?>" readonly>
                                    </div>
							</div>
              <div class="col-md-4">
                <div class="form-group-sm">
                เข้าคลัง *
                <select class="form-control select2" name="whid" id="whid" style="width: 100%;">
                    <option value='-1'>-- เลือกคลังสินค้า --</option>
                    <?php 	if(is_array($wh_array)) {
                        foreach($wh_array as $loop_wh){
                          echo "<option value='".$loop_wh->wh_id."'";
													if ($loop_wh->wh_id == $loop->wh_id) echo " selected";
													echo ">".$loop_wh->wh_code."-".$loop_wh->wh_name."</option>";
                     } } ?>
                    </select>
                </div>
              </div>
                                <?php $luxury = $loop->stor_has_serial; $status = $loop->stor_status; $remark = $loop->stor_remark; break; } ?>
								<div class="col-md-2">
									<div class="form-group-sm">
                      จำนวนนับเข้าระบบ
                      <div class="text-red" id="checkin" style="font-size: 24pt; font-weight: bold;">0</div>
                  </div>
								</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-8">
                      <input type="text" class="form-control" name="refcode" id="refcode" placeholder="<?php if ($luxury == 0) echo "Refcode No. ที่รับคืน"; else "Caseback No. ที่รับคืน"; ?>" autocomplete='off'><div class="input-group-btn">
                      <button type="button" class="btn btn-primary"><i class='fa fa-search'></i></button></div>
                      <label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; <?php echo count($stock_array); ?> &nbsp;&nbsp; รายการ</label><?php if ($status==2) echo "<label class='text-green'>&nbsp;&nbsp; ทำการยืนยันแล้ว</label>"; if ($status==3) echo "<label class='text-red'>&nbsp;&nbsp; ทำการยกเลิกแล้ว</label>"; ?>
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
                                                        <th>จำนวนที่ต้องการคืน</th>
                                                        <th width="105">จำนวนจริงที่รับคืน</th>
														<th>หน่วย</th>
				                                    </tr>
				                                </thead>
												<tbody>
                                                    <?php
                                                    $count=0;
                                                    foreach($stock_array as $loop) { ?>
                                                    <tr<?php if ($luxury==1) echo " class='danger'"; ?>>
                                                    <input type='hidden' name='it_id' id='it_id' value=" <?php echo $loop->log_stor_item_id; ?>">
                                                    <input type='hidden' name='log_id' id='log_id' value="<?php echo $loop->log_stor_id; ?>">
                                                    <td><?php echo $loop->it_refcode; ?></td>
                                                    <td><?php echo $loop->br_name; ?></td>
                                                    <td><?php echo $loop->it_model; ?></td>
                                                    <td><?php echo number_format($loop->it_srp); ?></td>
                                                    <td><input type='hidden' name='qty_update' id='qty_update' value="<?php echo $loop->qty_update; ?>">
																											  <input type='hidden' name='qty_so' id='qty_so' value="
																												<?php foreach($so_array as $loop_so) { if($loop_so->soi_item_id == $loop->log_stor_item_id)
																													echo $loop_so->soi_qty; break;
																												}  ?>
																												">
																										<?php echo $loop->qty_update; ?></td>
                                                    <td>
                                                        <?php if ($luxury==1) { ?>
                                                        <input type="hidden" name="count_serial_<?php echo $loop->log_stor_item_id; ?>" id="count_serial_<?php echo $loop->log_stor_item_id; ?>" value="<?php echo $count; ?>">
                                                        <?php } ?>
                                                        <input type='text' name='it_final' id='it_final' style="text-align:center;width: 50px;" value='<?php if ($status==2) { echo $loop->qty_final; }else{ echo "0"; } ?>' <?php if (($status==1) || ($status==2) || ($loop->it_has_caseback)) echo "readonly"; ?> onChange='calculate();'>
                                                    </td>
                                                    <td><?php echo $loop->it_uom; ?></td></tr>

                                                    <?php // if has serial
                                                    $count_serial = 0;
                                                    if ($luxury==1) {
                                                        for($i=1; $i<=$loop->qty_update; $i++) {
                                                            $count_serial++;
                                                    ?>
                                                    <tr>
                                                    <td colspan="8"><b><?php echo $i; ?>. Caseback Number : </b><input type='text' name='serial<?php echo $loop->log_stor_item_id; ?>' id='serial<?php echo $loop->log_stor_item_id; ?>' class="text-blue" value='' style='width: 200px; text-align:center' readonly>
                                                      <input type="hidden" name="serial_item_id<?php echo $loop->log_stor_item_id; ?>" id="serial_item_id<?php echo $loop->log_stor_item_id; ?>" value=""></td>
                                                    </tr>
                                                    <?php  } } $count++; ?>
                                                    <?php } ?>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:120%;" class="text-red">
                                                        <th colspan="5" style="text-align:right;"><label>จำนวนรวม:</th>
                                                        <th><div id="allcount"></div></th>
																												<th></th>
                                                    </tr>
                                                </tfoot>
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
                                    <input type="text" class="form-control" name="storremark" id="storremark" value="<?php echo $remark; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success <?php if ($status==2) echo "disabled"; ?>" name="savebtn" id="savebtn" onclick="submitform(<?php echo $luxury; ?>)"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-primary" name="returnbtn" id="returnbtn" onclick="returnform()"><i class='fa fa-save'></i>  กลับไปหน้ารายการ-ขอคืนสินค้า </button>
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

$(document).ready(function()
{
    document.getElementById("savebtn").disabled = false;
    get_datepicker("#datein");
    $(".select2").select2();


    setTimeout(function(){
                calculate();
            },3000);

		$("#refcode").focus();

		$('#refcode').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var refcode = $.trim($(this).val());
            var stor_id = "<?php echo $stor_id; ?>";
            if(refcode != "")
						{
                check_ref_code(refcode, stor_id);

						}

            $(this).val('');

            setTimeout(function(){
                calculate();
            },3000);
					}
		});
});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

function check_ref_code(refcode_input, stor_id)
{
	if(refcode_input != "")
	{
        $.ajax({
            type : "POST" ,
            dataType: "json",
            url : "<?php echo site_url("tp_stock_return/check_return_item_list"); ?>" ,
            data : {refcode: refcode_input, stor_id: stor_id},
            success : function(data) {
                if(data.c > 0)
                {
                    var item_id = data.a;
										var it_refcode = data.b;
										var luxury = data.luxury;
                    var it_id = document.getElementsByName("it_id");
                    var it_final = document.getElementsByName("it_final");
										var qty_update = document.getElementsByName("qty_update");
										var qty_so = document.getElementsByName("qty_so");
										var checkin = parseInt(document.getElementById("checkin").innerHTML);
										var count = 0;
										if (luxury == 0) {
											for (var i=0; i<it_id.length; i++) {
	                        if (parseInt(it_id[i].value) == item_id) {
														count++;
														if (parseInt(it_final[i].value) >= parseInt(qty_update[i].value)) {
															alert("จำนวนสินค้าเกินจากที่ต้องการ");
															break;
														}else if(parseInt(it_final[i].value) >= parseInt(qty_so[i].value)) {
															alert("จำนวนสินค้าเกินจากที่สามารถคืนได้ กรุณาตรวจสอบใบสั่งขายอีกครั้ง");
															break;
														}else{
															it_final[i].value = parseInt(it_final[i].value) + 1;
															checkin++;
															document.getElementById("checkin").innerHTML = checkin.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	                            break;
														}
	                        }
	                    }
											if (count == 0) alert("ไม่พบสินค้า "+it_refcode+" ในเอกสารนี้");
										}else{
											var check_refcode = document.getElementById("count_serial_"+data.a);
											if (check_refcode === null) {
												alert("ไม่พบ Ref. Code ที่ต้องการในเอกสารนี้ !!!");
											}else if(data.a > 0){

			                    var ind = "serial"+data.a;
			                    var serial = document.getElementById("count_serial_"+data.a).value;
													// var serial_array = new Array();
			                    var serial_array = document.getElementsByName(ind);
			                    var serial_id = document.getElementsByName("serial_item_id"+data.a);
													var count_serial = 0;
			                    for (var i=0; i<serial_array.length; i++) {

			                        if (serial_array[i].value == "") {

																	serial_array[i].value = data.b;

			                            serial_id[i].value = data.c;
			                            it_final[serial].value = parseInt(it_final[serial].value) + 1;
																	checkin++;
																	document.getElementById("checkin").innerHTML = checkin.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			                            break;
			                        }else if(data.b == serial_array[i].value) {
			                            alert("Caseback ซ้ำ !!");
			                            break;
			                        }else{
																count_serial++;
															}
			                    }
													if (count_serial == serial_array.length) {
														alert("สินค้าเกินจำนวนที่ต้องการ !!");
													}
			                }else{
			                    alert("ไม่พบ Caseback ที่ต้องการในคลัง");
			                }
										}

                }else{
                    alert("ไม่พบสินค้าที่ต้องการในเอกสารนี้");
                }
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
	}

}

function returnform()
{
    window.location = "<?php echo site_url("tp_stock_return/report_return_request"); ?>";
}

function submitform(luxury)
{
    var it_final = document.getElementsByName('it_final');
		var whid = document.getElementById("whid").value;
    for(var i=0; i<it_final.length; i++){
        if (it_final[i].value == 0) {
            alert("กรุณาใส่สินค้าให้ครบทุกช่อง");
            return;
        }
    }

		if(whid <= 0) {
			alert("กรุณาเลือกคลังที่รับคืน");
			return;
		}else{
			var r = confirm("ยืนยันการขอคืนสินค้า !!");
			if (r == true) {
					confirmform(luxury);
			}
		}

}

function calculate() {
    var count = 0;
    var qty = document.getElementsByName('it_final');
    for(var i=0; i<qty.length; i++) {
        if (qty[i].value == "") qty[i].value = 0;
        count += parseInt(qty[i].value);
    }
    document.getElementById("allcount").innerHTML = count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function confirmform(luxury)
{
    var it_final = document.getElementsByName('it_final');
    var log_id = document.getElementsByName('log_id');
    var item_id = document.getElementsByName('it_id');
    var stor_id = <?php echo $stor_id; ?>;
    var whid = document.getElementById("whid").value;
    var datein = document.getElementById("datein").value;
    var stor_remark =  document.getElementById("storremark").value;

    var serial_array = new Array();
    var index_serial = 0;

    var item_array = new Array();
    for(var i=0; i<log_id.length; i++){
        if (it_final[i].value % 1 != 0 || it_final[i].value == "") {
            alert("กรุณาใส่จำนวนสินค้าที่เป็นตัวเลขเท่านั้น");
            it_final[i].value = '';
            return;
        }
        item_array[i] = {id: log_id[i].value, qty_final: it_final[i].value, item_id: item_id[i].value};

        var serial = document.getElementsByName('serial'+item_id[i].value.replace(/\s+/g, ''));
        var serial_item_id = document.getElementsByName('serial_item_id'+item_id[i].value.replace(/\s+/g, ''));

        for(var j=0; j<serial.length; j++) {
            if (serial[j].value != "") {

                serial_array[index_serial] = {serial: serial[j].value, serial_item_id: serial_item_id[j].value, serial_log_id: log_id[i].value};
                index_serial++;

            }/*else{
                alert("กรุณาใส่ Caseback ให้ครบ");
                return;
            }*/

        }
    }

    document.getElementById("savebtn").disabled = true;

    $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("tp_stock_return/save_return_confirm"); ?>" ,
            data : {item: item_array, stor_id: stor_id, whid: whid, datein: datein, serial_array: serial_array, stor_remark: stor_remark, luxury: luxury} ,
            dataType: 'json',
            success : function(data) {
                var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบรับคืนสินค้า ใช่หรือไม่";
                bootbox.confirm(message, function(result) {
                        var currentForm = this;
                        if (result) {
                            window.open("<?php echo site_url("tp_stock_return/print_return_confirm"); ?>"+"/"+data.b, "_blank");
                            location.reload();
                        }else{
                            location.reload();
                        }

                });


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
