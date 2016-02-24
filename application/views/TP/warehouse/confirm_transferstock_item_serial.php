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
                                        </div> <label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; <?php echo count($stock_array); ?> &nbsp;&nbsp; รายการ<?php if ($status==2) echo "&nbsp;&nbsp; ทำการยืนยันแล้ว"; ?></label> 
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
                                                    <?php foreach($stock_array as $loop) { ?>
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
                                                    <input type='hidden' name='itse_id' id='itse_id' value=" <?php echo $loop2->log_stots_item_serial_id; ?>">
                                                    <input type='hidden' name='log_id' id='log_id' value=" <?php echo $loop2->log_stots_id; ?>">
                                                    <td> </td>
                                                    <td><input type="checkbox" name="log_id" value=" <?php echo $loop2->log_stots_id; ?>" checked> ส่งได้</td>
                                                    <td><input type='text' name='serial' id='serial' value='<?php echo $loop2->itse_serial_number; ?>' style='width: 200px;'  readonly></td>
                                                    <td colspan="4"></td>
                                                    </tr>
                                                    <?php } } } ?>
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

function confirmform()
{
    document.getElementById("savebtn").disabled = true;
    var it_final = document.getElementsByName('it_final');
    var log_id = document.getElementsByName('log_id');
    var item_id = document.getElementsByName('it_id');
    var stot_id = <?php echo $stot_id; ?>;
    var wh_out_id = document.getElementById("wh_out_id").value; 
    var wh_in_id = document.getElementById("wh_in_id").value; 
    var datein = document.getElementById("datein").value;
    var item_array = new Array();
    for(var i=0; i<log_id.length; i++){
        item_array[i] = {id: log_id[i].value, qty_final: it_final[i].value, item_id: item_id[i].value};
    }
    
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