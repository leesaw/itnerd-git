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
            
            <h1>ออกใบกำกับภาษี / ใบส่งสินค้า / ใบเสร็จรับเงิน</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("sale/saleorder_rolex_payment"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่ขาย
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        สาขาที่ขาย *
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php foreach($shop_array as $loop) {  echo $loop->sh_name; $shop_id = $loop->sh_id; } ?>" readonly>
                                        <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">
                                    </div>
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    ชื่อลูกค้า
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="">
                                </div>
							</div>
                            <div class="col-md-9">
                                <div class="form-group-sm">
                                    ที่อยู่ลูกค้า
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="">
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    เลขประจำตัวผู้เสียภาษี
                                    <input type="text" class="form-control" name="custax_id" id="custax_id" value="">
                                </div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    เบอร์ติดต่อ
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="">
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    ชำระเงิน
                                    <select class="form-control" name="payment" id="payment">
                                        <option value="C">เงินสด</option>
                                        <option value="D">บัตรเครดิต</option>
                                        <option value="Q">เช็ค</option>
                                    </select>
                                </div>
							</div> 
                            <div class="col-md-2">
                                <div class="form-group-lg">
                                    <div id="text1">จำนวนเงินที่จ่าย</div>
                                    <input type="text" class="form-control input-lg text-blue" name="payment_value" id="payment_value" style="font-weight:bold;" value="" onchange="numberWithCommas(this);" >
                                </div>
							</div> 
                        </div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-lg col-lg-6">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Serial ที่ขาย">
                                        <div class="input-group-btn">

                                        </div>
                                        <label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label> 
                                        </div></div>
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
														<th> </th>
				                                    </tr>
				                                </thead>
												<tbody>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:200%;" class="text-red">
                                                        <th colspan="7" style="text-align:right;"><label>ยอดรวม:</th>
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
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    รหัสพนักงานขาย
                                    <input type="text" class="form-control" name="salepersonid" id="salepersonid" value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    ชื่อ-นามสกุลพนักงานขาย
                                    <input type="hidden" name="saleperson_code" id="saleperson_code" value="">
                                    <input type="text" class="form-control" name="salename" id="salename" value="" readonly>
                                </div>
                            </div>
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
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  ชำระเงิน </button>&nbsp;&nbsp;
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
<script type="text/javascript">

var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{    
    $("#refcode").focus();
    
    document.getElementById("savebtn").disabled = false;
    
    $('#refcode').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var product_code_value = $.trim($(this).val());
            var shop_id = document.getElementById("shop_id").value;
            if(product_code_value != "")
			{
                check_product_code(product_code_value,shop_id);
			}
            
            $(this).val('');
            
            setTimeout(function(){
                calSummary();
            },100);
            //calSummary();
		}
	});
    
    $('#salepersonid').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var person_id = $.trim($(this).val());
            var shop_id = document.getElementById("shop_id").value;
            if(person_id != "")
			{
                check_saleperson_code(person_id,shop_id);
			}
            //calSummary();
		}
	});
    
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
    var custax_id = document.getElementById('custax_id').value;
    var custelephone = document.getElementById('custelephone').value;
    var datein = document.getElementById('datein').value;
    var saleperson_name = document.getElementById('salename').value;
    var saleperson_code = document.getElementById('saleperson_code').value;
    if (datein == "") {
        alert("กรุณาใส่วันที่ขาย");
    }else if (cusname == "") {
        alert("กรุณาใส่ชื่อลูกค้า");
    }else if (cusaddress == "") {
        alert("กรุณาใส่ที่อยู่ลูกค้า");
    }else if (custax_id == "") {
        alert("กรุณาใส่เลขประจำตัวผู้เสียภาษีลูกค้า");
    }else if (custelephone == "") {
        alert("กรุณาใส่เบอร์ติดต่อลูกค้า");
    }else if (saleperson_name == "" || saleperson_code =="") {
        alert("กรุณาใส่รหัสพนักงานขาย");
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
    var custax_id = document.getElementById('custax_id').value;
    var custelephone = document.getElementById('custelephone').value;
    var payment = document.getElementById('payment').value;
    var payment_value = (document.getElementById('payment_value').value).replace(/,/g, '');
    var remark = document.getElementById('remark').value;
    
    var shop_id = document.getElementById('shop_id').value;
    var datein = document.getElementById('datein').value;
    var saleperson_code = document.getElementById('saleperson_code').value;
    
    var itse_id = document.getElementsByName('itse_id');
    var stob_id = document.getElementsByName('stob_id');
    var it_id = document.getElementsByName('it_id');
    var it_srp = document.getElementsByName('it_srp');
    var dc_thb = document.getElementsByName('dc_thb');
    var it_array = new Array();
    var checked = 0;
    var index = 0;

    for(var i=0; i<it_id.length; i++){
        for(var j=0; j<index; j++) {
            if (it_id[i].value == it_array[j]['id']) {
                //it_array[j]['qty'] = parseInt(it_array[j]['qty']) + 1;
                
                if (itse_id[i].value == it_array[j]['itse_id']) {
                    alert("Serial ซ้ำกัน");
                    return;
                }
                //checked++;
            }

        }
        if (checked==0) {
            it_array[index] = {id: it_id[i].value, qty: 1, itse_id: itse_id[i].value, stob_id: stob_id[i].value, dc_thb:(dc_thb[i].value).replace(/,/g, ''), it_srp:it_srp[i].value};
            index++;
        }else{
            checked = 0;
        }
    }
    
    document.getElementById("savebtn").disabled = true;
    
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("sale/saleorder_rolex_save"); ?>" ,
        data : {datein: datein, shop_id: shop_id, item: it_array, cusname: cusname, cusaddress: cusaddress, custax_id: custax_id, custelephone: custelephone, payment: payment, payment_value: payment_value, saleperson_code:saleperson_code, remark: remark} ,
        dataType: 'json',
        success : function(data) {
            var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์เอกสาร ใช่หรือไม่";
            bootbox.confirm(message, function(result) {
                    var currentForm = this;
                    if (result) {
                        window.open("<?php echo site_url("sale/saleorder_rolex_print"); ?>"+"/"+data.b, "_blank");
                        window.location = "<?php echo site_url("sale/saleorder_rolex_pos_last"); ?>/"+data.b;
                    }else{
                        window.location = "<?php echo site_url("sale/saleorder_rolex_pos_last"); ?>/"+data.b;
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