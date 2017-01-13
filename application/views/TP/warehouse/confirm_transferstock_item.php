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

            <h1>ยืนยันการย้ายคลังสินค้า</h1>
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
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php $datein = explode('-', $loop->stot_datein);
    echo $datein[2]."/".$datein[1]."/".$datein[0]; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        ออกจากคลัง *
                                        <input type="hidden" name="wh_out_id" id="wh_out_id" value="<?php echo $loop->wh_out_id; ?>">
                                        <input type="text" class="form-control" name="whname_out" id="whname_out" value="<?php echo $loop->wh_out_code."-".$loop->wh_out_name; ?>" readonly>
                                        <?php $wh_out_id = $loop->wh_out_id; ?>
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
                                <?php $status = $loop->stot_status; break; } ?>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-6">
                                    <?php $must_serial=0;
                                          foreach($stock_array as $loop){
                                              $stot_remark = $loop->stot_remark;
                                              if ($loop->it_has_caseback == 1) { $must_serial++; break; } }
                                        if ($must_serial>0) {
                                    ?>
                                            <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Caseback No. ที่ต้องการย้าย"><div class="input-group-btn">
                                            <button type="button" class="btn btn-primary"><i class='fa fa-search'></i></button></div>
                                    <?php } ?>
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
                                                        <th>จำนวนคงเหลือ</th>
														<th width="105">จำนวนที่ต้องการ</th>
                                                        <th width="105">จำนวนที่ส่งได้</th>
														<th>หน่วย</th>
				                                    </tr>
				                                </thead>
												<tbody>
                                                    <?php
                                                    $count=0;
                                                    foreach($stock_array as $loop) { ?>
                                                    <tr<?php if ($loop->it_has_caseback==1) echo " class='danger'"; ?>>
                                                    <input type='hidden' name='it_id' id='it_id' value=" <?php echo $loop->log_stot_item_id; ?>">
                                                    <input type='hidden' name='log_id' id='log_id' value="<?php echo $loop->log_stot_id; ?>">
                                                    <td><?php echo $loop->it_refcode; ?></td>
                                                    <td><?php echo $loop->br_name; ?></td>
                                                    <td><?php echo $loop->it_model; ?></td>
                                                    <td><?php echo number_format($loop->it_srp); ?></td>
                                                    <td><input type='hidden' name='qty_old' id='qty_old' value=" <?php echo $loop->qty_old; ?>"><?php if ($loop->qty_old <1) echo "<span class='text-red'><b>".$loop->qty_old."</b></span>";
                                                        else echo $loop->qty_old; ?></td>
                                                    <td><?php echo $loop->qty_update; ?></td>
                                                    <td>
                                                        <?php if ($loop->it_has_caseback==1) { ?>
                                                        <input type="hidden" name="count_serial_<?php echo $loop->log_stot_item_id; ?>" id="count_serial_<?php echo $loop->log_stot_item_id; ?>" value="<?php echo $count; ?>">
                                                        <?php } ?>
                                                        <input type='text' name='it_final' id='it_final' style="text-align:center;width: 50px;" value='<?php if ($loop->it_has_caseback==0) { echo $loop->qty_update; }else{ echo "0"; } ?>' <?php if (($status==2) || ($loop->it_has_caseback)) echo "readonly"; ?> onChange='calculate();'>
                                                    </td>
                                                    <td><?php echo $loop->it_uom; ?></td></tr>

                                                    <?php // if has serial
                                                    $count_serial = 0;
                                                    if ($loop->it_has_caseback==1) {
                                                        for($i=1; $i<=$loop->qty_update; $i++) {
                                                            $count_serial++;
                                                    ?>
                                                    <tr>
                                                    <td colspan="8"><b><?php echo $i; ?>. Caseback Number : </b><input type='text' name='serial<?php echo $loop->log_stot_item_id; ?>' id='serial<?php echo $loop->log_stot_item_id; ?>' class="text-blue" value='' style='width: 200px; text-align:center' readonly><input type="hidden" name="serial_wh_id<?php echo $loop->log_stot_item_id; ?>" id="serial_wh_id<?php echo $loop->log_stot_item_id; ?>" value="<?php echo $loop->stot_warehouse_out_id; ?>"><input type="hidden" name="serial_item_id<?php echo $loop->log_stot_item_id; ?>" id="serial_item_id<?php echo $loop->log_stot_item_id; ?>" value=""></td>
                                                    </tr>
                                                    <?php  } } $count++; ?>
                                                    <?php } ?>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:120%;" class="text-red">
                                                        <th colspan="6" style="text-align:right;"><label>จำนวนรวม:</th>
                                                        <th><div id="allcount"></div></th>
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
                                    <input type="text" class="form-control" name="stotremark" id="stotremark" value="<?php echo $stot_remark; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success <?php if ($status==2) echo "disabled"; ?>" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
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

$(document).ready(function()
{
    document.getElementById("savebtn").disabled = false;
    get_datepicker("#datein");


    setTimeout(function(){
                calculate();
            },3000);

    $('#refcode').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var product_code_value = $.trim($(this).val());
            var wh_out_id = "<?php echo $wh_out_id; ?>";
            if(product_code_value != "")
			{
                check_product_code(product_code_value, wh_out_id);

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

function check_product_code(refcode_input, wh_id)
{
	if(refcode_input != "")
	{
        $.ajax({
            type : "POST" ,
            dataType: "json",
            url : "<?php echo site_url("warehouse_transfer/checkSerial_warehouse"); ?>" ,
            data : {serial: refcode_input, serial_wh_id: wh_id},
            success : function(data) {
                if(data.a > 0)
                {
                    var ind = "serial"+data.a;
                    var serial = document.getElementById("count_serial_"+data.a).value;
                    var serial_array = document.getElementsByName(ind);
                    var serial_id = document.getElementsByName("serial_item_id"+data.a);
                    var it_final = document.getElementsByName("it_final");
                    for (var i=0; i<serial_array.length; i++) {

                        if (serial_array[i].value == "") {
														if (data.d > 0) serial_array[i].value = data.b + "(Sample)";
                            else serial_array[i].value = data.b;
														
                            serial_id[i].value = data.c;
                            it_final[serial].value = parseInt(it_final[serial].value) + 1;
                            break;
                        }else if(data.b == serial_array[i].value) {
                            alert("Caseback ซ้ำ");
                            break;
                        }
                    }
                }else{
                    alert("ไม่พบ Caseback ที่ต้องการในคลัง");
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
    window.location = "<?php echo site_url("warehouse_transfer/report_transferstock"); ?>";
}

function submitform()
{
    var it_final = document.getElementsByName('it_final');
    var qty_old = document.getElementsByName('qty_old');
    for(var i=0; i<it_final.length; i++){
        if (it_final[i].value == "") {
            alert("กรุณาใส่จำนวนสินค้าให้ครบทุกช่อง");
            return;
        }

        if (parseInt(it_final[i].value) > parseInt(qty_old[i].value)) {
            alert("จำนวนสินค้าคงเหลือไม่เพียงพอกับที่ต้องการ !!");
            return;
        }
    }
    if (document.getElementById('datein').value == "") {
        alert("กรุณาเลือกวันที่รับเข้า");
        document.getElementById('datein').focus();
    }else{
        var r = confirm("ยืนยันการย้ายคลังสินค้า !!");
        if (r == true) {
            confirmform();
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

function confirmform()
{
    var it_final = document.getElementsByName('it_final');
    var log_id = document.getElementsByName('log_id');
    var item_id = document.getElementsByName('it_id');
    var stot_id = <?php echo $stot_id; ?>;
    var wh_out_id = document.getElementById("wh_out_id").value;
    var wh_in_id = document.getElementById("wh_in_id").value;
    var datein = document.getElementById("datein").value;
    var stot_remark =  document.getElementById("stotremark").value;

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
        var serial_wh_id = document.getElementsByName('serial_wh_id'+item_id[i].value.replace(/\s+/g, ''));
        var serial_item_id = document.getElementsByName('serial_item_id'+item_id[i].value.replace(/\s+/g, ''));

        for(var j=0; j<serial.length; j++) {
            if (serial[j].value != "") {

                serial_array[index_serial] = {serial_wh_id: serial_wh_id[j].value, serial: serial[j].value, serial_item_id: serial_item_id[j].value, serial_log_id: log_id[i].value};
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
            url : "<?php echo site_url("warehouse_transfer/transferstock_save_confirm"); ?>" ,
            data : {item: item_array, stot_id: stot_id, wh_out_id: wh_out_id, wh_in_id: wh_in_id, datein: datein, serial_array: serial_array, stot_remark: stot_remark} ,
            dataType: 'json',
            success : function(data) {
                var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบส่งของ ใช่หรือไม่";
                bootbox.confirm(message, function(result) {
                        var currentForm = this;
                        if (result) {
                            window.open("<?php echo site_url("warehouse_transfer/transferstock_final_print"); ?>"+"/"+data.b, "_blank");
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
