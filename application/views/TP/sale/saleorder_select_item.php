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
            
            <h1>การสั่งขาย (Sale Order)</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("warehouse_transfer/save_importstock"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่ขาย
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        สาขาที่ขาย *
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php echo $shop_name; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    <?php if ($caseback ==0) { ?>
                                        <label class="text-green"> No Caseback</label>
                                    <?php }else{ ?>
                                        <label class="text-red"> Caseback</label>
                                    <?php } ?>
                                </div>
                            </div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-6">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="<?php if ($caseback==0) echo "Ref. Code ที่ขาย"; else echo "Caseback ที่ขาย"; ?>">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary"><i class='fa fa-search'></i></button>
                                        </div> <label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label> 
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
                                                        <?php if ($caseback ==0) { ?>
														<th width="105">จำนวน</th>
                                                        <?php }else{ ?>
                                                        <th width="100">Caseback</th>
                                                        <?php } ?>
														<th>หน่วย</th>
                                                        <th width="500">Barcode</th>
														<th>จัดการ</th>
				                                    </tr>
				                                </thead>
												<tbody>
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
                                    Remark
                                    <input type="text" class="form-control" name="saleorder_remark" id="saleorder_remark" value="">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform(<?php echo $caseback; ?>)"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
                                
                                <a href="<?php echo site_url("sale/saleorder_view"); ?>"><button type="button" class="btn btn-danger" name="resetbtn" id="resetbtn"><i class='fa fa-rotate-left'></i>  เริ่มต้นใหม่ </button></a>
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
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">

var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{    
    document.getElementById("savebtn").disabled = false;
    
    $('#refcode').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var product_code_value = $.trim($(this).val());
            var shop_id = <?php echo $shop_id; ?>;
            var caseback = <?php echo $caseback; ?>;
            if(product_code_value != "")
			{
                check_product_code(product_code_value, shop_id, caseback);
                
			}
            
            $(this).val('');
		}
	});

});
function check_product_code(refcode_input, shop_id, caseback)
{
	if(refcode_input != "")
	{
        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("sale/check_code"); ?>" ,
            data : {refcode: refcode_input, shop_id: shop_id, caseback: caseback },
            success : function(data) {
                if(data != "")
                {
                    var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                    $('table > tbody').append(element);
                    count_enter_form_input_product++;
                    count_list++;
                    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                }else{
                    alert("ไม่พบ Ref. Code ที่ต้องการในสาขา");
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

function submitform(x)
{
    var shopid = "<?php echo $shop_id; ?>";
    var datein = "<?php echo $datein; ?>";
    var it_quantity = document.getElementsByName('it_quantity');
    
    var barcode_id = document.getElementsByName('barcode_id');
    var discount_value = document.getElementsByName('discount_value');
    var discount_baht = document.getElementsByName('discount_baht');
    var gp_value = document.getElementsByName('gp_value');
    
    var it_serial = document.getElementsByName('serial_id');
    if (shopid < 0) {
        alert("กรุณาเลือกสาขาที่ขาย");
    }else if (datein == "") {
        alert("กรุณาเลือกวันที่ขาย");
    }else{
        var duplicate = 0;
        for(var i=0; i<it_quantity.length; i++){
            it_serial
            if (x==0) {
                if (it_quantity[i].value % 1 != 0 || it_quantity[i].value == "") {
                    alert("กรุณาใส่จำนวนสินค้าที่เป็นตัวเลขเท่านั้น");
                    it_quantity[i].value = '';
                    return;
                }
            }else{
                if (it_serial[i].value =="") {
                    alert("กรุณาใส่ Caseback");
                    return;
                }
                for(var j=i+1; j<it_serial.length; j++){
                    if (it_serial[i].value==it_serial[j].value) {
                        //it_serial[j].value = "";
                        duplicate++;
                    }
                }
                if (duplicate > 0) {
                    alert("Caseback ซ้ำกัน");
                    return;
                }
            }
            if (barcode_id[i].value == -10) {
                alert("กรุณาเลือกบาร์โค้ดห้าง");
                return;
            }
            
            if (barcode_id[i].value == -1) {
                if (discount_value[i].value =="") {
                    alert("กรุณาใส่ Discount(%)");
                    return;
                }
                if (discount_baht[i].value =="") {
                    alert("กรุณาใส่ Discount(บาท)");
                    return;
                }
                if (gp_value[i].value =="") {
                    alert("กรุณาใส่ GP(%)");
                    return;
                }
            }
        }
        
        
        
        var r = confirm("ยืนยันการสั่งขาย !!");
        if (r == true) {
            confirmform(x);
        }
    }
}
    
function confirmform(caseback)
{
    var shop_id = "<?php echo $shop_id; ?>";
    var shop_code = "<?php echo $shop_code; ?>";
    var datein = "<?php echo $datein; ?>";
    if (caseback==1) var it_serial = document.getElementsByName('serial_id');
    var it_quantity = document.getElementsByName('it_quantity');
    
    // Barcode Discount GP
    var barcode_id = document.getElementsByName('barcode_id');
    var discount_value = document.getElementsByName('discount_value');
    var discount_baht = document.getElementsByName('discount_baht');
    var gp_value = document.getElementsByName('gp_value');
    
    var it_id = document.getElementsByName('it_id');
    var it_srp = document.getElementsByName('it_srp');
    var stob_id = document.getElementsByName('stob_id');
    
    var saleorder_remark =  document.getElementById("saleorder_remark").value;
    
    var it_array = new Array();
    var serial_array = new Array();
    var checked = 0;
    var index = 0;

    document.getElementById("savebtn").disabled = true;
    
    for(var i=0; i<it_id.length; i++){
        /*
        for(var j=0; j<index; j++) {
            if ((it_id[i].value == it_array[j]['id']) && (i)) {
                it_array[j]['qty'] = parseInt(it_array[j]['qty']) + parseInt(it_quantity[i].value);

                checked++;
            }
        }
        */
        //if (checked==0) {
            
        it_array[index] = {id: it_id[i].value, qty: it_quantity[i].value, barcode_id: barcode_id[i].value, discount_value: discount_value[i].value, discount_baht: discount_baht[i].value, gp_value: gp_value[i].value, stob_id: stob_id[i].value, srp: it_srp[i].value};
        
        if (caseback==1) {
            serial_array[index] = {id: it_id[i].value, stob_id: stob_id[i].value, serial: it_serial[i].value};
        }

        index++;
        //}else{
        //    checked = 0;
        //}
        
        
    }
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("sale/saleorder_save"); ?>" ,
        data : {datein: datein, shop_id: shop_id, shop_code: shop_code, item: it_array, serial: serial_array, caseback: caseback, saleorder_remark: saleorder_remark} ,
        dataType: 'json',
        success : function(data) {
            var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบสั่งขาย ใช่หรือไม่";
            bootbox.confirm(message, function(result) {
                    var currentForm = this;
                    if (result) {
                        window.open("<?php echo site_url("sale/saleorder_print"); ?>"+"/"+data.b, "_blank");
                        window.location = "<?php echo site_url("sale/saleOrder_view"); ?>";
                    }else{
                        window.location = "<?php echo site_url("sale/saleOrder_view"); ?>";
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