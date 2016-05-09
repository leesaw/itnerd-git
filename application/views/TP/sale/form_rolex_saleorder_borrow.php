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
            
            <h1>แจ้งขาย</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("sale/saleorder_rolex_payment"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                        วันที่ขาย
                                        <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        ขายโดย
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php foreach($borrow_array as $loop) {  echo $loop->posrob_borrower_name; $borrow_item_id=$loop->posrobi_id; } ?>" readonly>
                                        <input type="hidden" name="shop_id" id="shop_id" value="0">
                                    </div>
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    ชื่อลูกค้า *
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="">
                                </div>
							</div>
                            <div class="col-md-9">
                                <div class="form-group-sm">
                                    ที่อยู่ลูกค้า *
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="">
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    เบอร์ติดต่อ *
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="">
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    ชำระเงิน *
                                    <select class="form-control" name="payment" id="payment">
                                        <option value="C">เงินสด</option>
                                        <option value="D">บัตรเครดิต</option>
                                        <option value="Q">เช็ค</option>
                                    </select>
                                </div>
							</div> 
                            <div class="col-md-2">
                                <div class="form-group-lg">
                                    <div id="text1">จำนวนเงินที่จ่าย *</div>
                                    <input type="text" class="form-control input-lg text-blue" name="payment_value" id="payment_value" style="font-weight:bold;" value="" onchange="numberWithCommas(this);" >
                                </div>
							</div> 
                        </div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"> </div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>Product No.</th>
                                                        <th>Serial No.</th>
                                                        <th>Description</th>
                                                        <th>Family</th>
                                                        <th>Bracelet</th>
                                                        <th>Retail Price</th>
                                                        <th>Discount (THB)</th>
														<th> </th>
				                                    </tr>
				                                </thead>
												<tbody>
                                                    <?php foreach($borrow_array as $loop) { ?>
                                                    <tr>
                                                    <td><?php echo $loop->it_refcode; ?></td>
                                                    <td><?php echo $loop->itse_serial_number; ?></td>
                                                    <td><?php echo $loop->it_short_description; ?></td>
                                                    <td><?php echo $loop->it_model; ?></td>
                                                    <td><?php echo $loop->it_remark; ?></td>
                                                    <td><?php echo $loop->it_srp; ?></td>
                                                    <input type='hidden' name='it_srp' id='it_srp' value="<?php echo $loop->it_srp; ?>">
                                                    <input type='hidden' name='it_id' id='it_id' value="<?php echo $loop->it_id; ?>">
                                                    <input type='hidden' name='itse_id' id='itse_id' value="<?php echo $loop->itse_id; ?>">
                                                    <td><input type="text" name="dc_thb" id="dc_thb" value="0" onChange="numberWithCommas(this); calSummary();"></td>
                                                    </tr>
                                                    <?php } ?>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:200%;" class="text-red">
                                                        <th colspan="6" style="text-align:right;"><label>ยอดรวม:</th>
                                                        <th><div id="summary"></div></th>
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
                                    <input type="text" class="form-control" name="remark" id="remark" value="">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึกการขาย </button>&nbsp;&nbsp;
							</div>
						</div>
						</form>

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

var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{    
    get_datepicker("#datein");
    $("#refcode").focus();
    
    document.getElementById("savebtn").disabled = false;
    setTimeout(function(){
        calSummary();
    },100);
    
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

    
function submitform()
{
    var cusname = document.getElementById('cusname').value;
    var cusaddress = document.getElementById('cusaddress').value;
    var custelephone = document.getElementById('custelephone').value;
    var datein = document.getElementById('datein').value;
    if (datein == "") {
        alert("กรุณาใส่วันที่ขาย");
    }else if (cusname == "") {
        alert("กรุณาใส่ชื่อลูกค้า");
    }else if (cusaddress == "") {
        alert("กรุณาใส่ที่อยู่ลูกค้า");
    }else if (custelephone == "") {
        alert("กรุณาใส่เบอร์ติดต่อลูกค้า");
    }else{
        var r = confirm("ยืนยันการขาย !!");
        if (r == true) {
            confirmform();
        }
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
    
    var shop_id = document.getElementById('shop_id').value;
    var datein = document.getElementById('datein').value;
    
    var itse_id = document.getElementsByName('itse_id');
    var it_id = document.getElementsByName('it_id');
    var it_srp = document.getElementsByName('it_srp');
    var dc_thb = document.getElementsByName('dc_thb');
    var it_array = new Array();
    var checked = 0;
    var index = 0;

    for(var i=0; i<it_id.length; i++){
        for(var j=0; j<index; j++) {
            if (it_id[i].value == it_array[j]['id']) {
                
                if (itse_id[i].value == it_array[j]['itse_id']) {
                    alert("Serial ซ้ำกัน");
                    return;
                }

            }

        }
        if (checked==0) {
            it_array[index] = {id: it_id[i].value, qty: 1, itse_id: itse_id[i].value, stob_id: 0, dc_thb:(dc_thb[i].value).replace(/,/g, ''), it_srp:it_srp[i].value};
            index++;
        }else{
            checked = 0;
        }
    }
    
    document.getElementById("savebtn").disabled = true;
    
    var borrow_item_id = <?php echo $borrow_item_id; ?>;
    
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("sale/saleorder_rolex_temp_save"); ?>" ,
        data : {datein: datein, shop_id: shop_id, item: it_array, cusname: cusname, cusaddress: cusaddress, custelephone: custelephone, payment: payment, payment_value: payment_value, saleperson_code: 0, remark: remark, borrow_item_id: borrow_item_id} ,
        dataType: 'json',
        success : function(data) {
            var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์เอกสาร ใช่หรือไม่";
            bootbox.confirm(message, function(result) {
                    var currentForm = this;
                    if (result) {
                        window.open("<?php echo site_url("sale/saleorder_rolex_temp_borrow_print"); ?>"+"/"+data.b+"/"+borrow_item_id, "_blank");
                        window.location = "<?php echo site_url("pos/form_list_borrow_item"); ?>/"+data.b;
                    }else{
                        window.location = "<?php echo site_url("pos/form_list_borrow_item"); ?>/"+data.b;
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