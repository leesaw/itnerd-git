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
                                            วันที่ย้ายคลัง
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
                                <?php $status = $loop->stot_status; break; } ?>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-6">
                                        <div class="input-group-btn">
                                        </div> <label id="count_all" class="text-red pull-left">จำนวน &nbsp;&nbsp; <?php echo count($stock_array); ?> &nbsp;&nbsp; รายการ</label><?php if ($status==2) echo "<label class='text-green'>&nbsp;&nbsp; ทำการยืนยันแล้ว</label>"; if ($status==3) echo "<label class='text-red'>&nbsp;&nbsp; ทำการยกเลิกแล้ว</label>"; ?>
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
                                                    <?php foreach($stock_array as $loop) { ?>
                                                    <tr<?php if ($loop->br_has_serial==1) echo " class='danger'"; ?>>
                                                    <input type='hidden' name='it_id' id='it_id' value=" <?php echo $loop->log_stot_item_id; ?>">
                                                    <input type='hidden' name='log_id' id='log_id' value="<?php echo $loop->log_stot_id; ?>">
                                                    <td><?php echo $loop->it_refcode; ?></td>
                                                    <td><?php echo $loop->br_name; ?></td>
                                                    <td><?php echo $loop->it_model; ?></td>
                                                    <td><?php echo number_format($loop->it_srp); ?></td>
                                                    <td><?php echo $loop->qty_old; ?></td>
                                                    <td><?php echo $loop->qty_update; ?></td>
                                                    <td><input type='text' name='it_final' id='it_final' value='<?php if ($loop->br_has_serial==0) echo $loop->qty_update; ?>' style='width: 50px;' <?php if ($status==2 || $loop->br_has_serial==1) echo "readonly"; ?>></td>
                                                    <td><?php echo $loop->it_uom; ?></td></tr>
                                                    
                                                    <?php // if has serial
                                                    
                                                    if ($loop->br_has_serial==1) {
                                                        for($i=1; $i<=$loop->qty_update; $i++) {
                                                    ?>
                                                    <tr>
                                                    <td colspan="8"><b><?php echo $i; ?>. Caseback Number : </b><input type='text' name='serial' id='serial' class="text-blue" value='' style='width: 200px; text-align:center'><input type="hidden" name="serial_log_id" id="serial_log_id" value="<?php echo $loop->log_stot_id; ?>"></td>
                                                    </tr>
                                                    <?php } } ?>
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

var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{    
    document.getElementById("savebtn").disabled = false;

});

function returnform()
{
    window.location = "<?php echo site_url("warehouse_transfer/report_transferstock"); ?>";
}

function submitform()
{
    var it_final = document.getElementsByName('it_final');
    for(var i=0; i<it_final.length; i++){
        if (it_final[i].value == "") {
            alert("กรุณาใส่จำนวนสินค้าให้ครบทุกช่อง");
            return;
        }
    }

    var r = confirm("ยืนยันการย้ายคลังสินค้า !!");
    if (r == true) {
        confirmform();
    }
}
    
function checkCaseback()
{
        
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
    
    // serial item
    var serial = document.getElementsByName('serial');
    var serial_log_id = document.getElementsByName('serial_log_id');
    
    var serial_array = new Array();
    var index_serial = 0;
    for(var i=0; i<serial_log_id.length; i++) {
        if (serial[i].value != "") {
            serial_array[index_serial] = {serial_log_id: serial_log_id[i].value, serial: serial[i].value};
            index_serial++;
        }
    }
    
    
    
    var item_array = new Array();
    for(var i=0; i<log_id.length; i++){
        
        if (it_final[i].value % 1 != 0 || it_quantity[i].value == "") {
            alert("กรุณาใส่จำนวนสินค้าที่เป็นตัวเลขเท่านั้น");
            it_final[i].value = '';
            return;
        }
        
        item_array[i] = {id: log_id[i].value, qty_final: it_final[i].value, item_id: item_id[i].value};
    }
    document.getElementById("savebtn").disabled = true;
    $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("warehouse_transfer/transferstock_save_confirm/0"); ?>" ,
            data : {item: item_array, stot_id: stot_id, wh_out_id: wh_out_id, wh_in_id: wh_in_id, datein: datein} ,
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