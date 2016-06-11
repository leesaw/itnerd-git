<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('NGG/gold/header_view'); ?>
</head>

<body class="hold-transition skin-red layout-top-nav">
<div class="wrapper">
	<?php $this->load->view('NGG/gold/menu'); ?>
	
<div class="content-wrapper">
    <div class="container">
	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box_heading"><h3 class="box-title">ออกบัตรรับประกันสินค้า (ทอง)</h3></div>
                    <div class="box-body">
                    <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("sale/saleorder_rolex_payment"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group">
                                            <label>วันที่ขาย</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                        <label>สาขาที่ขาย</label>
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php foreach($shop_array as $loop) {  echo $loop->sh_name; $shop_id = $loop->sh_id; } ?>" readonly>
                                        <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">
                                    </div>
							</div>
                            <div class="col-md-1"> </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ชื่อลูกค้า *</label>
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="" autocomplete="off">
                                </div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>เบอร์ติดต่อ *</label>
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="" autocomplete="off">
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label>ที่อยู่ลูกค้า *</label>
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="" autocomplete="off">
                                </div>
							</div>
                        </div>
                        <div class="row">
							<div class="col-md-9">
                                <div class="form-group">
                                <label>ประเภทสินค้า * </label><br>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="สร้อยคอ">สร้อยคอ</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="สร้อยข้อมือ">สร้อยข้อมือ</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="แหวน">แหวน</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="จี้">จี้</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="ต่างหู">ต่างหู</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="กำไล">กำไล</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="สร้อยข้อมือกึ่งกำไล">มือกึ่งกำไล</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="กิมตุ้ง">กิมตุ้ง</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="กระเป๋า">กระเป๋า</label>
                                <br><br>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="เข็มขัด">เข็มขัด</label>
                                     
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="0">อื่น ๆ .... <input type="text" name="txt_product" id="txt_product" value="" autocomplete="off"></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>รหัส *</label>
                                    <input type="text" class="form-control" name="code" id="code" value="" autocomplete="off">
                                </div>
                            </div>
						</div>	
                        <div class="row">
							<div class="col-md-5">
                                <div class="form-group">
                                <label>ชนิดของทอง * </label><br>
                                <label class="radio-inline"><input type="radio" name="kindgold" id="kindgold" value="96.5%">96.5%</label>
                                <label class="radio-inline"><input type="radio" name="kindgold" id="kindgold" value="75%">75%</label>
                                <label class="radio-inline"><input type="radio" name="kindgold" id="kindgold" value="0">อื่น ๆ .... <input type="text" name="txt_kindgold" id="txt_kindgold" value="" autocomplete="off"></label>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>น้ำหนัก *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="weight" id="weight" autocomplete="off">
                                        <span class="input-group-addon">กรัม</span>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href='#' id='weight_list' onclick='addweight(1)'>1</a></li>
                        <li><a href='#' id='weight_list' onclick='addweight(1.89)'>1.89</a></li>
                        <li><a href='#' id='weight_list' onclick='addweight(3.79)'>3.79</a></li>
                        <li><a href='#' id='weight_list' onclick='addweight(7.58)'>7.58</a></li>
                        <li><a href='#' id='weight_list' onclick='addweight(15.16)'>15.16</a></li>
                        <li><a href='#' id='weight_list' onclick='addweight(30.32)'>30.32</a></li>
                        <li><a href='#' id='weight_list' onclick='addweight(45.48)'>45.48</a></li>
                        <li><a href='#' id='weight_list' onclick='addweight(60.64)'>60.64</a></li>
                        <li><a href='#' id='weight_list' onclick='addweight(75.8)'>75.8</a></li>
                        <li><a href='#' id='weight_list' onclick='addweight(151.6)'>151.6</a></li>
                      </ul>
                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>จำนวนเงิน *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="price" id="price" autocomplete="off" onchange="numberWithCommas(this);">
                                        <span class="input-group-addon">บาท</span>
                                    </div>
                                </div>
                            </div>
						</div>	
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>ชำระด้วย * </label><br>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="เงินสด">เงินสด</label>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="บัตรเครดิต">บัตรเครดิต</label>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="บัตรผ่อน">บัตรผ่อน</label>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="0">อื่น ๆ .... <input type="text" name="txt_payment" id="txt_payment" value="" autocomplete="off"></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>จำนวนเพชร/พลอย</label>
                                    <input type="text" class="form-control" name="jewelry" id="jewelry" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>รูปแบบ *</label>
                                    <input type="text" class="form-control" name="model" id="model" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>วันที่เริ่มรับประกันสินค้า *</label>
                                        <input type="text" class="form-control" name="datestart" id="datestart" value="<?php echo $datein; ?>" width="200">
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <label>หมายเหตุมีของเก่ามาเปลี่ยน</label>
                                        <input type="text" class="form-control" name="old" id="old" autocomplete="off">
                                    </div>
                                    </div>
                                </div>
							</div>

                            <div class="col-md-1">
                            </div>
                            <div class="col-md-5">
                                <div class="panel panel-danger">
									<div class="panel-heading">
                                        <label>ราคาทองคำแท่ง</label> 
                                        </div>
				                    <div class="panel-body">
				                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ซื้อ *</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="goldbuy" id="goldbuy" autocomplete="off" onchange="numberWithCommas(this);">
                                                        <span class="input-group-addon">บาท</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ขาย *</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="goldsell" id="goldsell" autocomplete="off" onchange="numberWithCommas(this);">
                                                        <span class="input-group-addon">บาท</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									</div>
								</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>รหัสพนักงานขาย *</label>
                                    <input type="text" class="form-control" name="salepersonid" id="salepersonid" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ชื่อ-นามสกุลพนักงานขาย *</label>
                                    <input type="hidden" name="saleperson_code" id="saleperson_code" value="">
                                    <input type="text" class="form-control" name="salename" id="salename" value="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>หมายเหตุเพิ่มเติม</label>
                                    <input type="text" class="form-control" name="remark" id="remark" value="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
                                
							</div>
						</div>
						</form>

					</div> <!-- panel body -->
				</div>
			</div>	
                        </div>     
					</div>
                </div>
            </div>
        </div>
    </section>
    </div>
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
    get_datepicker("#datestart");
    
    $("#cusname").focus();
    document.getElementById("savebtn").disabled = false;
    
    $('#custelephone').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var telephone = $.trim($(this).val());
            if(telephone != "")
			{
                check_number(telephone);
			}
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
});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
    
function numberWithCommas(obj) {
	var x=$(obj).val();
    var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/,/g,"");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $(obj).val(parts.join("."));
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
    
function check_number(telephone)
{
    telephone = telephone.replace(/[-/#]/g, "");
	if(telephone != "")
	{
        $.ajax({
            type : "POST" ,
            dataType: 'json',
            url : "<?php echo site_url("ngg_gold/check_telephone"); ?>" ,
            data : {telephone: telephone},
            success : function(data) {
                if(data.a != "")
                {
                    document.getElementById("cusname").value = data.a;
                    document.getElementById("cusaddress").value = data.b;
                }else{
                    alert("ไม่พบข้อมูลลูกค้า");
                }
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
	}

}
    
function submitform()
{
    
    var cusname = document.getElementById('cusname').value;
    var cusaddress = document.getElementById('cusaddress').value;
    var custelephone = document.getElementById('custelephone').value;
    custelephone = custelephone.replace(/[-/#\s]/g, "");
    var datein = document.getElementById('datein').value;
    
    // radio choice
    var product = document.getElementsByName('product');
    var txt_product = document.getElementById('txt_product').value;
    var kindgold = document.getElementsByName('kindgold');
    var txt_kindgold = document.getElementById('txt_kindgold').value;
    var payment = document.getElementsByName('payment');
    var txt_payment = document.getElementById('txt_payment').value;
    
    var code = document.getElementById('code').value;
    var weight = document.getElementById('weight').value;
    var price = document.getElementById('price').value;
    price = price.replace(/[,]/g, "");
    var jewelry = document.getElementById('jewelry').value;
    var model = document.getElementById('model').value;
    var datestart = document.getElementById('datestart').value;
    var old = document.getElementById('old').value;
    var goldbuy = document.getElementById('goldbuy').value;
    goldbuy = goldbuy.replace(/[,]/g, "");
    var goldsell = document.getElementById('goldsell').value;
    goldsell = goldsell.replace(/[,]/g, "");
    
    var saleperson_name = document.getElementById('salename').value;
    var saleperson_code = document.getElementById('saleperson_code').value;

    if (datein == "") {
        alert("กรุณาใส่วันที่ขาย");
        document.getElementById('datein').focus();
    }else if (cusname == "") {
        alert("กรุณาใส่ชื่อลูกค้า");
        document.getElementById('cusname').focus();
    }else if (custelephone == "") {
        alert("กรุณาใส่เบอร์ติดต่อลูกค้า");
        document.getElementById('custelephone').focus();
    }else if ((Math.floor(custelephone)*1000) % 1 != 0) {
        alert("กรุณาใส่เบอร์ติดต่อลูกค้า ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('custelephone').focus(); 
    }else if (cusaddress == "") {
        alert("กรุณาใส่ที่อยู่ลูกค้า");
        document.getElementById('cusaddress').focus();        
    }else if (get_radio_value(product) == "") {
        alert("กรุณาเลือกประเภทสินค้า");
        document.getElementById('product').focus();
    }else if ((get_radio_value(product) == "0") && (txt_product == "")) {
        alert("กรุณาใส่ประเภทสินค้าหลังช่อง 'อื่น ๆ'");
        document.getElementById('txt_product').focus();
    }else if (code == "") {
        alert("กรุณาใส่รหัส");
        document.getElementById('code').focus(); 
    }else if (get_radio_value(kindgold) == "") {
        alert("กรุณาเลือกชนิดของทอง");
        document.getElementById('kindgold').focus();
    }else if ((get_radio_value(kindgold) == "0") && (txt_kindgold == "")) {
        alert("กรุณาใส่ชนิดของทองหลังช่อง 'อื่น ๆ'");
        document.getElementById('txt_kindgold').focus();
    }else if (weight == "") {
        alert("กรุณาใส่น้ำหนัก");
        document.getElementById('weight').focus(); 
    }else if (price == "") {
        alert("กรุณาใส่จำนวนเงิน");
        document.getElementById('price').focus(); 
    }else if ((price*100) % 1 != 0) {
        alert("กรุณาใส่จำนวนเงิน ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('price').focus();
    }else if (get_radio_value(payment) == "") {
        alert("กรุณาเลือกชำระเงิน");
        document.getElementById('payment').focus();
    }else if ((get_radio_value(payment) == "0") && (txt_payment == "")) {
        alert("กรุณาใส่การชำระเงินหลังช่อง 'อื่น ๆ'");
        document.getElementById('txt_payment').focus();
    }else if (model == "") {
        alert("กรุณาใส่รูปแบบ");
        document.getElementById('model').focus(); 
    }else if (datestart == "") {
        alert("กรุณาใส่วันที่เริ่มรับประกันสินค้า");
        document.getElementById('datestart').focus(); 
    }else if (goldbuy == "") {
        alert("กรุณาใส่ราคาซื้อทองแท่ง");
        document.getElementById('goldbuy').focus();
    }else if ((Math.floor(goldbuy)*1000) % 1 != 0) {
        alert("กรุณาใส่ราคาซื้อทองแท่ง ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('goldbuy').focus();
    }else if (goldsell == "") {
        alert("กรุณาใส่ราคาขายทองแท่ง");
        document.getElementById('goldsell').focus(); 
    }else if ((Math.floor(goldsell)*1000) % 1 != 0) {
        alert("กรุณาใส่ราคาขายทองแท่ง ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('goldsell').focus();
    }else if (saleperson_name == "" || saleperson_code =="") {
        alert("กรุณาใส่รหัสพนักงานขาย");
        document.getElementById('salepersonid').focus();
    }else{
        var r = confirm("ยืนยันการบันทึก !!");
        if (r == true) {
            confirmform();
        }
    }
}
    
function get_radio_value(name)
{
    var val = "";
    for (var i=0, len=name.length; i<len; i++) {
        if ( name[i].checked ) { 
            val = name[i].value;
            break; 
        }
    }
    return val;
}
    
function confirmform()
{
    var cusname = document.getElementById('cusname').value;
    var cusaddress = document.getElementById('cusaddress').value;
    var custelephone = document.getElementById('custelephone').value;
    custelephone = custelephone.replace(/[-]/g, "");
    var datein = document.getElementById('datein').value;
    var shop_id = document.getElementById('shop_id').value;
    
    // radio choice
    var product = document.getElementsByName('product');
    var txt_product = document.getElementById('txt_product').value;
    if (get_radio_value(product) != "0") txt_product = get_radio_value(product);
    var kindgold = document.getElementsByName('kindgold');
    var txt_kindgold = document.getElementById('txt_kindgold').value;
    if (get_radio_value(kindgold) != "0") txt_kindgold = get_radio_value(kindgold);
    var payment = document.getElementsByName('payment');
    var txt_payment = document.getElementById('txt_payment').value;
    if (get_radio_value(payment) != "0") txt_payment = get_radio_value(payment);
    
    var code = document.getElementById('code').value;
    var weight = document.getElementById('weight').value;
    var price = document.getElementById('price').value;
    price = price.replace(/,/g, "");
    var jewelry = document.getElementById('jewelry').value;
    var model = document.getElementById('model').value;
    var datestart = document.getElementById('datestart').value;
    var old = document.getElementById('old').value;
    var goldbuy = document.getElementById('goldbuy').value;
    goldbuy = goldbuy.replace(/,/g, "");
    var goldsell = document.getElementById('goldsell').value;
    goldsell = goldsell.replace(/,/g, "");
    
    var saleperson_code = document.getElementById('saleperson_code').value;
    var remark = document.getElementById('remark').value;
     
    document.getElementById("savebtn").disabled = true;
    
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("ngg_gold/save_warranty"); ?>" ,
        data : {datein: datein, shop_id: shop_id, cusname: cusname, cusaddress: cusaddress, custelephone: custelephone, product: txt_product, kindgold: txt_kindgold, payment: txt_payment, code: code, weight: weight, price: price, jewelry: jewelry, model: model, datestart: datestart, old: old, goldbuy: goldbuy, goldsell: goldsell, saleperson_code:saleperson_code, remark: remark} ,
        dataType: 'json',
        success : function(data) {
            var message = "ทำการบันทึกเรียบร้อยแล้ว";
            bootbox.alert(message, function() {
                window.open("<?php echo site_url("ngg_gold/print_warranty"); ?>"+"/"+data.b, "_blank");
                window.location = "<?php echo site_url("ngg_gold/view_warranty"); ?>/"+data.b;

            });


        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
            document.getElementById("savebtn").disabled = false;
        }
    });
    
}
    
function addweight(val1) 
{
    document.getElementById('weight').value = val1;
}
</script>
</body>
</html>