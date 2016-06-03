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
														<th>จำนวนที่ต้องการ</th>
                                                        <th>หน่วย</th>
				                                    </tr>
				                                </thead>
												<tbody>
                                                    <?php $row_caseback=1;
                                                    foreach($stock_array as $loop) { ?>
                                                    <tr>
                                                    
                                                    <td><?php echo $loop->it_refcode; ?></td>
                                                    <td><?php echo $loop->br_name; ?></td>
                                                    <td><?php echo $loop->it_model; ?></td>
                                                    <td><?php echo number_format($loop->it_srp); ?></td>
                                                    <td style='width: 100px;'><?php echo $loop->qty_old; ?></td>
                                                    <td style='width: 100px;'><?php echo $loop->qty_update; ?></td>
                                                    <td><?php echo $loop->it_uom; ?></td>
                                                    </tr>
                                                    <?php foreach($serial_array as $loop2) { 
                                                    if ($loop->it_id==$loop2->itse_item_id) { 
                                                    ?>
                                                    <tr>
                                                    <td colspan="7"><b><?php echo $row_caseback; ?>. Caseback Number : </b><input type='text' name='serial' id='serial' class="text-red" value='<?php echo $loop2->itse_serial_number; ?>' style='width: 200px; text-align:center' readonly> <input type="checkbox" name="log_id" value=" <?php echo $loop2->log_stots_id; ?>" checked> ส่งได้ <input type='hidden' name='itse_id' id='itse_id' value=" <?php echo $loop2->log_stots_item_serial_id; ?>"><input type='hidden' name='it_id' id='it_id' value=" <?php echo $loop2->itse_item_id; ?>"></td>
                                                    </tr>
                                                    <?php $row_caseback++; } } } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>	
						</div>	
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success <?php if ($status>=2) echo "disabled"; ?>" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
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
    var log_id = document.getElementsByName("log_id");
    var count = 0;

    for (var i=0; i<log_id.length; i++) {       
       if (log_id[i].type == "checkbox" && log_id[i].checked == true){
          count++;
       }
    }

    var r = confirm("ยืนยันการย้ายคลังสินค้า จำนวน "+count+" ชิ้น !!");
    if (r == true) {
        confirmform();
    }
}

function confirmform()
{
    document.getElementById("savebtn").disabled = true;
    var log_id = document.getElementsByName('log_id');
    var itse_id = document.getElementsByName('itse_id');
    var item_id = document.getElementsByName('it_id');
    var stot_id = <?php echo $stot_id; ?>;
    var wh_out_id = document.getElementById("wh_out_id").value; 
    var wh_in_id = document.getElementById("wh_in_id").value; 
    var datein = document.getElementById("datein").value;
    var item_ok_array = new Array();
    var item_cancel_array = new Array();
    var index_ok = 0;
    var index_cancel = 0;
    
    for (var i=0; i<log_id.length; i++) {
       if (log_id[i].checked == true){
          item_ok_array[index_ok] = {id: log_id[i].value, item_serial: itse_id[i].value, item_id: item_id[i].value};
          index_ok++;
       }else if(log_id[i].checked == false) {
          item_cancel_array[index_cancel] = {id: log_id[i].value, item_serial: itse_id[i].value, item_id: item_id[i].value};
          
          index_cancel++;
       }
    }
    
    $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("warehouse_transfer/transferstock_save_confirm/1"); ?>" ,
            data : {item: item_ok_array, cancel_item: item_cancel_array, stot_id: stot_id, wh_out_id: wh_out_id, wh_in_id: wh_in_id, datein: datein} ,
            dataType: 'json',
            success : function(data) {
                var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบส่งของ ใช่หรือไม่";
                bootbox.confirm(message, function(result) {
                        var currentForm = this;
                        if (result) {
                            window.open("<?php echo site_url("warehouse_transfer/transferstock_final_print_serial"); ?>"+"/"+data.b, "_blank");
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