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
            
            <h1>แก้ไข ข้อมูลใบเสร็จรับเงิน</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-warning">
					<div class="panel-heading"> </div>
                    <div class="panel-body">
                        <?php foreach($pos_array as $loop) { ?>
                        <?php $pos_rolex_id = $loop->posrot_id; ?>
                        <div class="row">
                            <div class="col-md-2">
                                    <div class="form-group-sm has-success">
                                        <label class="control-label" for="inputSuccess">เลขที่ใบเสร็จ</label>
                                            <input type="text" class="form-control" name="number" id="number" value="<?php echo $loop->posrot_number; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
                                    <div class="form-group-sm">
                                        <label class="control-label" for="inputSuccess">วันที่ขาย</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php $datein =  explode('-',$loop->posrot_issuedate); echo $datein[2]."/".$datein[1]."/".$datein[0]; ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm has-success">
                                        <label class="control-label" for="inputSuccess"><?php if ($loop->posrot_status=='D') echo "ขายโดย"; else echo "สาขาที่ขาย"; ?></label>
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php if ($loop->posrot_status=='D') echo $posrob_borrower_name; else echo $loop->sh_name; ?>" readonly>
                                    </div>
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    <label class="control-label" for="inputSuccess">ชื่อลูกค้า</label>
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $loop->posrot_customer_name; ?>">
                                </div>
							</div>
                            <div class="col-md-9">
                                <div class="form-group-sm">
                                    <label class="control-label" for="inputSuccess">ที่อยู่ลูกค้า</label>
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="<?php echo $loop->posrot_customer_address; ?>">
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    <label class="control-label" for="inputSuccess">เบอร์ติดต่อ</label>
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="<?php echo $loop->posrot_customer_tel; ?>">
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    <label class="control-label" for="inputSuccess">ชำระเงิน</label>
                                    <select class="form-control" name="payment" id="payment">
                                        <option value="C"<?php if ($loop->posrot_payment == 'C') echo " selected"; ?>>เงินสด</option>
                                        <option value="D"<?php if ($loop->posrot_payment == 'D') echo " selected"; ?>>บัตรเครดิต</option>
                                        <option value="Q"<?php if ($loop->posrot_payment == 'Q') echo " selected"; ?>>เช็ค</option>
                                    </select>
                                </div>
							</div> 
                            <div class="col-md-3">
                                <div class="form-group-lg">
                                    <label class="control-label" for="inputSuccess" id="text1"><?php if ($loop->posrot_payment=='C') echo "จำนวนเงินที่จ่าย"; if ($loop->posrot_payment=='D') echo "บัตรเครดิตธนาคาร"; if ($loop->posrot_payment=='Q') echo "เลขที่"; ?></label>
                                    <input type="text" class="form-control input-lg text-blue" name="payment_value" id="payment_value" style="font-weight:bold;" value="<?php echo $loop->posrot_payment_value; ?>" onchange="numberWithCommas(this);">
                                </div>
							</div> 
                        </div>
                        <?php $remark = $loop->posrot_remark;
                              $sale_person = $loop->sp_barcode."-".$loop->firstname." ".$loop->lastname;
                              $pos_status = $loop->posrot_status;
                        } ?>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-primary">
									<div class="panel-heading">รายการสินค้า</div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>RMC</th>
                                                        <th>Serial No.</th>
                                                        <th>Description</th>
                                                        <th>Family</th>
                                                        <th>Bracelet</th>
														<th width="105">Quantity</th>
                                                        <th>Retail Price</th>
                                                        <th>Discount (THB)</th>
				                                    </tr>
				                                </thead>
												<tbody>
                                                <?php $sum=0; foreach($item_array as $loop) { ?>
                                                <tr>
                                                <td><input type='hidden' name='posroit_id' id='posroit_id' value='<?php echo $loop->posroit_id; ?>'><?php echo $loop->it_refcode; ?></td>
                                                <td><?php echo $loop->itse_serial_number; ?></td>
                                                <td><?php echo $loop->it_short_description; ?></td>
                                                <td><?php echo $loop->it_model; ?></td>
                                                <td><?php echo $loop->it_remark; ?></td>
                                                <td><?php echo $loop->posroit_qty." ".$loop->it_uom; ?></td>
                                                <td><input type="hidden" name="it_srp" id="it_srp" value="<?php echo $loop->posroit_item_srp; ?>"><?php echo number_format($loop->posroit_item_srp); ?></span></td>
                                                <td><input type="text" name="dc_thb" id="dc_thb" value="<?php echo number_format($loop->posroit_dc_baht); ?>" onChange="numberWithCommas(this); calSummary();"></td>
                                                </tr>
                                                <?php $sum += $loop->posroit_item_srp - $loop->posroit_dc_baht; } ?>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:200%;" class="text-red">
                                                        <th colspan="7" style="text-align:right;"><label>ยอดรวม:</th>
                                                        <th><div id="summary"><?php echo number_format($sum); ?></div></th>
                                                    </tr>
                                                </tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>	
						</div>	
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">ชื่อ-นามสกุลพนักงานขาย</label>
                                    <input type="text" class="form-control" name="salename" id="salename" value="<?php echo $sale_person; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-sm">
                                    <label class="control-label" for="inputSuccess">Remark</label>
                                    <input type="text" class="form-control" name="remark" id="remark" value="<?php echo $remark; ?>">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
							<div class="col-md-12">
                               <button type="button" class="btn btn-primary" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button></a>&nbsp;&nbsp;
                                <a href="<?php echo site_url("sale/saleorder_rolex_pos_temp_last")."/".$pos_rolex_id; ?>"><button type="button" class="btn btn-warning" name="printbtn" id="printbtn"><i class='fa fa-mail-reply'></i>  ยกเลิก </button></a>&nbsp;&nbsp;

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
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    get_datepicker("#datein");
    
    $("#payment").change(function() {
        var val = document.getElementById("payment").value;
        if (val == 'C') {
            document.getElementById("text1").innerHTML = "จำนวนเงินที่จ่าย";
            document.getElementById("payment_value").value = "";
        }else if (val == 'D'){
            document.getElementById("text1").innerHTML = "บัตรธนาคาร";
            document.getElementById("payment_value").value = "";
        }else if (val == 'Q'){
            document.getElementById("text1").innerHTML = "เลขที่";
            document.getElementById("payment_value").value = "";
        }
    });
});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
    
function calSummary() {
    var sum = 0;
    var srp = document.getElementsByName('it_srp');
    var dc = document.getElementsByName('dc_thb');
    for(var i=0; i<srp.length; i++) {
        if (dc[i].value == "") dc[i].value = 0; 
        sum += parseInt(srp[i].value) - parseInt((dc[i].value).replace(/,/g, ''));
    }
    document.getElementById("summary").innerHTML = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
} 
    
function numberWithCommas(obj) {
	var x=$(obj).val();
    var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/,/g,"");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $(obj).val(parts.join("."));
}

function check_product_code(refcode_input, shop_id)
{
	if(refcode_input != "")
	{
        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("sale/check_rolex_serial"); ?>" ,
            data : {refcode: refcode_input, shop_id: shop_id},
            success : function(data) {
                if(data != "")
                {
                    var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><input type="text" name="dc_thb" id="dc_thb" value="0" onChange="numberWithCommas(this); calSummary();"></td><td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                    $('table > tbody').append(element);
                    count_enter_form_input_product++;
                    count_list++;
                    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                }else{
                    alert("ไม่พบ Serial ที่ต้องการในคลัง");
                }
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
	}

}
    
function check_saleperson_code(saleperson_id, shop_id)
{
	if(saleperson_id != "")
	{
        $.ajax({
            type : "POST" ,
            dataType: 'json',
            url : "<?php echo site_url("sale/check_saleperson_rolex"); ?>" ,
            data : {saleperson_id: saleperson_id, shop_id: shop_id},
            success : function(data) {
                if(data.a != "")
                {
                    document.getElementById("salename").value = data.a;
                    document.getElementById("saleperson_code").value = data.b;
                }else{
                    alert("ไม่พบรหัสพนักงาน");
                }
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
	}

}

function delete_item_row(row1)
{
    count_list--;
    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
    $('#row'+row1).remove();
    setTimeout(function(){
        calSummary();
    },50);
}
    
function submitform()
{
    var cusname = document.getElementById('cusname').value;
    var cusaddress = document.getElementById('cusaddress').value;
    var custelephone = document.getElementById('custelephone').value;
    var datein = document.getElementById('datein').value;
    var dc_thb = document.getElementsByName('dc_thb');
    
    if (datein == "") {
        alert("กรุณาใส่วันที่ขาย");
        document.getElementById('datein').focus();
        return;
    }else if (cusname == "") {
        alert("กรุณาใส่ชื่อลูกค้า");
        document.getElementById('cusname').focus();
        return;
    }else if (cusaddress == "") {
        alert("กรุณาใส่ที่อยู่ลูกค้า");
        document.getElementById('cusaddress').focus();
        return;
    }else if (custelephone == "") {
        alert("กรุณาใส่เบอร์ติดต่อลูกค้า");
        document.getElementById('custelephone').focus();
        return;
    }
    
    for(var i=0; i<dc_thb.length; i++){
        if (dc_thb[i].value == "") {
            alert("กรุณาใส่ส่วนลดให้ครบทุกช่อง");
            dc_thb[i].focus();
            return;
        }else if (parseInt(dc_thb[i].value.replace(/,/g, '')) % 1 != 0) {
            alert("กรุณาใส่ส่วนลดที่เป็นตัวเลขเท่านั้น");
            dc_thb[i].value = '';
            dc_thb[i].focus();
            return;
        }
    }
    
    var r = confirm("ยืนยันการขาย !!");
    if (r == true) {
        confirmform();
    }
}

function confirmform()
{
    var cusname = document.getElementById('cusname').value;
    var cusaddress = document.getElementById('cusaddress').value;
    var custelephone = document.getElementById('custelephone').value;
    var payment = document.getElementById('payment').value;
    var payment_value = (document.getElementById('payment_value').value).replace(/,/g, '');
    var remark = document.getElementById('remark').value;
    var datein = document.getElementById('datein').value;
    
    var posroit_id = document.getElementsByName('posroit_id');
    var it_srp = document.getElementsByName('it_srp');
    var dc_thb = document.getElementsByName('dc_thb');
    var pos_rolex_id = <?php echo $pos_rolex_id; ?>;
    var it_array = new Array();
    var index = 0;

    for(var i=0; i<posroit_id.length; i++){
        it_array[index] = {posroit_id: posroit_id[i].value, dc_thb: (dc_thb[i].value).replace(/,/g, ''), it_srp: it_srp[i].value };
        index++;
    }
    
    document.getElementById("savebtn").disabled = true;
    
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("sale/saleorder_rolex_temp_save_edit"); ?>" ,
        data : {pos_id: pos_rolex_id, datein: datein, item: it_array, cusname: cusname, cusaddress: cusaddress, custelephone: custelephone, payment: payment, payment_value: payment_value, remark: remark} ,
        dataType: 'json',
        success : function(data) {
            var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์เอกสาร ใช่หรือไม่";
            bootbox.confirm(message, function(result) {
                    var currentForm = this;
                    if (result) {
                        window.open("<?php echo site_url("sale/saleorder_rolex_temp_print"); ?>"+"/"+data.b, "_blank");
                        window.location = "<?php echo site_url("sale/saleorder_rolex_pos_temp_last"); ?>/"+data.b;
                    }else{
                        window.location = "<?php echo site_url("sale/saleorder_rolex_pos_temp_last"); ?>/"+data.b;
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