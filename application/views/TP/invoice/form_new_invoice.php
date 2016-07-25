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
            
            <h1>ออกใบ Invoice</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("tp_invoice/save_new_invoice"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่ขาย
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>">
                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group-sm">
                                        คลังสินค้า
                                        <select class="form-control select2" name="whid" id="whid" style="width: 100%;" onchange="showdetail()">
                                            <option value='-1'>-- เลือกคลังสินค้า --</option>
                                        <?php   if(is_array($wh_array)) {
                                                foreach($wh_array as $loop){
                                                    echo "<option value='".$loop->wh_id."'>".$loop->wh_code."-".$loop->wh_name."</option>";
                                         } } ?>
                                        </select>
                                    </div>
							</div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    นามผู้ซื้อ *
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    เลขประจำตัวผู้เสียภาษี *
                                    <input type="text" class="form-control" name="custax_id" id="custax_id" value="">
                                </div>
                            </div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    ที่อยู่ผู้ซื้อ แถวที่ 1 *
                                    <input type="text" class="form-control" name="cusaddress1" id="cusaddress1" value="">
                                </div>
							</div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    ที่อยู่ผู้ซื้อ แถวที่ 2 *
                                    <input type="text" class="form-control" name="cusaddress2" id="cusaddress2" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <br>
                                <label class="radio-inline"><input type="radio" name="branch" id="branch_0" value="0">สำนักงานใหญ่</label>
                                <label class="radio-inline"><input type="radio" name="branch" id="branch_1" value="-1">สาขาที่ <input type="text" name="branch_number" id="branch_number" value="" placeholder="00001"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    Vender Code
                                    <input type="text" class="form-control" name="vender" id="vender" value="">
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    Barcode
                                    <input type="text" class="form-control" name="barcode" id="barcode" value="">
                                </div>
							</div>
                        </div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group col-md-6">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Ref. Number">
                                        <div class="input-group-btn">
                                        <a data-toggle="modal" data-target="#myModal" type="button" class="btn btn-success" name="uploadbtn" id="uploadbtn"><i class='fa fa-upload'></i> นำเข้าจากเลขที่ใบส่งของ</a>
                                        </div>
                                        <label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label> 
                                        </div></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th width="250">Ref. Number</th>
                                                        <th width="250">รายละเอียด</th>
                                                        <th width="180">จำนวน</th>
                                                        <th width="180">หน่วยละ</th>
                                                        <th width="180">ส่วนลด %</th>
														<th width="200">จำนวนเงิน</th>
														<th width="80"> </th>
				                                    </tr>
				                                </thead>
												<tbody>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:200%;" class="text-red">
                                                        <th colspan="2" style="text-align:right;"><label>จำนวนรวม:</th>
                                                        <th><div id="allcount"></div></th>
                                                        <th colspan="2" style="text-align:right;"><label>ราคารวม:</th>
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
							<div class="col-md-12">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
                                <a href="<?php echo site_url('tp_invoice/form_new_invoice'); ?>" type="button" class="btn btn-warning" name="resetbtn" id="resetbtn"><i class='fa fa-refresh'></i>  เริ่มใหม่ </a>&nbsp;&nbsp;
							</div>
						</div>
						</form>

					</div>
				</div>
			</div>	
            </div></section>
	</div>
</div>

<!-- datepicker modal for upload excel -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

      <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">                        
                    <i class='fa fa-upload'></i> นำเข้าจากเลขใบส่งของ
                </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
                <div class="row"><div class="col-md-12"><div class="form-group"><label class="col-md-4 control-label" for="tb_number">เลขที่ใบส่งของ</label><div class="col-md-8"> <input type="text" class="form-control" id="tb_number" name="tb_number" /></div></div></form> </div>  </div>

            </div>            <!-- /modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="check_transfer_number();">นำเข้า</button>

            </div>  
                        
        </div>
    </div>
</div>

</div>
<!-- close modal -->  

<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>></script>
<script type="text/javascript">

var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{    
    //Initialize Select2 Elements
    $(".select2").select2();
    
    document.getElementById("savebtn").disabled = false;
    
    $('#refcode').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var product_code_value = $.trim($(this).val());
            if(product_code_value != "")
			{
                check_product_code(product_code_value);
			}
            
            $(this).val('');
            
            setTimeout(function(){
                calculate();
            },3000);
            //calSummary();
		}
	});

    $('#tb_number').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            check_transfer_number();
            //calSummary();
        }
    });
    
    $('#barcode').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var barcode = $.trim($(this).val());
            if(barcode != "")
            {
                check_barcode(barcode);
                calDiscount();
            }

        }
    });
});

function showdetail()
{
    var select_value = document.getElementById("whid").value;
    //alert(select_value);
    
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_invoice/check_warehouse_detail"); ?>" ,
        data : {whid: select_value },
        dataType: 'json',
        success : function(data) {
            document.getElementById("cusname").value = data.wh_detail;
            document.getElementById("cusaddress1").value = data.wh_address1;   
            document.getElementById("cusaddress2").value = data.wh_address2;  
            document.getElementById("custax_id").value = data.wh_taxid;   
            document.getElementById("vender").value = data.wh_vender;
            if (data.wh_branch == 0) {
                document.getElementById("branch_0").checked = true;
            }else if(data.wh_branch > 0) {
                document.getElementById("branch_1").checked = true;
                document.getElementById("branch_number").value = ('00000'+data.wh_branch).slice(-5);
            }else{
                document.getElementById("branch_0").checked = false;
                document.getElementById("branch_1").checked = false;
                document.getElementById("branch_number").value = "";
            }
        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
        }
    });

}

function check_transfer_number()
{
    var tb_number = document.getElementById("tb_number").value;
    //alert(tb_number);

    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_invoice/check_transfer_number"); ?>" ,
        data : {tb_number: tb_number},
        dataType: 'json',
        success : function(data) {
            if(data.item.length > 0)
            {
                for(var i=0; i<data.item.length; i++) {
                    var element = '<tr id="row'+count_enter_form_input_product+'">'+data.item[i]+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                    //console.log(element);
                    $('table > tbody').append(element);
                    count_enter_form_input_product++;
                    count_list++;
                }
                document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";

                document.getElementById("cusname").value = data.warehouse.wh_detail;
                document.getElementById("cusaddress1").value = data.warehouse.wh_address1;   
                document.getElementById("cusaddress2").value = data.warehouse.wh_address2;  
                document.getElementById("custax_id").value = data.warehouse.wh_taxid;   
                document.getElementById("vender").value = data.warehouse.wh_vender;
                $('#whid').val(data.warehouse.wh_id).change();
                if (data.warehouse.wh_branch == 0) {
                    document.getElementById("branch_0").checked = true;
                }else if(data.warehouse.wh_branch > 0) {
                    document.getElementById("branch_1").checked = true;
                    document.getElementById("branch_number").value = ('00000'+data.warehouse.wh_branch).slice(-5);
                }else{
                    document.getElementById("branch_0").checked = false;
                    document.getElementById("branch_1").checked = false;
                    document.getElementById("branch_number").value = "";
                }
                
                var message = "ทำการนำเข้าข้อมูลเรียบร้อยแล้ว";
                bootbox.alert(message, function() {
                    $('#myModal').modal('hide');
                });
                
            }else{
                alert("ไม่พบเลขใบส่งของที่ต้องการ");
            }


        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
        }
    });

    setTimeout(function(){
                calculate();
            },3000);
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

function calDiscount() {
    var result = 0;
    var srp = document.getElementsByName('it_srp');
    var dc = document.getElementsByName('it_discount');
    var net = document.getElementsByName('it_netprice');
    var dc_value;

    for(var i=0; i<dc.length; i++) {
        if (dc[i].value == "") dc_value = 0; 
        else dc_value = dc[i].value;
        net[i].value = (parseFloat(srp[i].value.replace(/,/g, '')) * (100 - parseFloat(dc_value))/100).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    }

    setTimeout(function(){
                calculate();
            },3000);
    
} 

function calculate() {
    var count = 0;
    var sum = 0;
    var srp = document.getElementsByName('it_netprice');
    var qty = document.getElementsByName('it_qty');
    for(var i=0; i<qty.length; i++) {
        if (qty[i].value == "") qty[i].value = 0; 
        count += parseInt(qty[i].value);
        sum += parseInt(qty[i].value)*parseFloat(srp[i].value.replace(/,/g, ''));
    }
    document.getElementById("summary").innerHTML = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    document.getElementById("allcount").innerHTML = count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
} 
    
function numberWithCommas(obj) {
	var x=$(obj).val();
    var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/,/g,"");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $(obj).val(parts.join("."));
}

function check_product_code(refcode_input)
{
	if(refcode_input != "")
	{
        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("tp_invoice/check_item_refcode"); ?>" ,
            data : {refcode: refcode_input},
            dataType: 'json',
            success : function(data) {
                if(data.length > 0)
                {
                    for(var i=0; i<data.length; i++) {
                        var element = '<tr id="row'+count_enter_form_input_product+'">'+data[i]+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                        //console.log(element);
                        $('table > tbody').append(element);
                        count_enter_form_input_product++;
                        count_list++;
                    }
                    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                }else{
                    alert("ไม่พบ Refcode ที่ต้องการ");
                }
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
	}
    setTimeout(function(){
                calculate();
            },3000);
}

function check_barcode(barcode_input)
{
    if(barcode_input != "")
    {
        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("tp_invoice/check_sale_barcode"); ?>" ,
            data : {barcode: barcode_input},
            success : function(data) {
                if(data != "")
                {
                    var dc = document.getElementsByName('it_discount');

                    for(var i = 0; i <dc.length; i++) {
                        dc[i].value = data;
                    }
                    calDiscount();
                }else{
                    alert("ไม่พบ Barcode ที่ต้องการ");
                }
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
    }
    setTimeout(function(){
                calculate();
            },3000);
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
    var itse_id = document.getElementsByName('itse_id');
    if (datein == "") {
        alert("กรุณาใส่วันที่ขาย");
    }else if (itse_id.length < 1) {
        alert("กรุณาใส่สินค้าที่ขาย");
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
    var cuspassport = document.getElementById('cuspassport').value;
    var custelephone = document.getElementById('custelephone').value;
    var refund = $('input[name="vat_refund"]:checked').val();
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
        data : {datein: datein, shop_id: shop_id, item: it_array, cusname: cusname, cusaddress: cusaddress, custax_id: custax_id, cuspassport: cuspassport, custelephone: custelephone, refund: refund, payment: payment, payment_value: payment_value, saleperson_code:saleperson_code, remark: remark} ,
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