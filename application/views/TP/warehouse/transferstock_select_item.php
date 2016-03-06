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
            
            <h1>ย้ายคลังสินค้า</h1>
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
                                            วันที่ย้ายคลัง
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        ออกจากคลัง *
                                        <input type="hidden" name="whid_out" value="<?php echo $whid_out; ?>">
                                        <input type="text" class="form-control" name="whname_out" id="whname_out" value="<?php echo $whname_out; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-1">
                                <br><center><i class="fa fa-arrow-right"></i></center>
                            </div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        เข้าคลัง *
                                        <input type="hidden" name="whid_in" value="<?php echo $whid_in; ?>">
                                        <input type="text" class="form-control" name="whname_in" id="whname_in" value="<?php echo $whname_in; ?>" readonly>
                                    </div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-6">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="<?php if($remark==0) echo "Ref. Code ที่ต้องการย้าย"; else echo "Caseback No. ที่ต้องการย้าย"; ?>">
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
                                                        <th>รุ่น</th>
                                                        <th>ราคาขาย</th>
                                                        <?php if ($remark==0) { ?>
                                                        <th>จำนวนคงเหลือ</th>
                                                        <?php } ?>
														<th width="105">จำนวน</th>
														<th>หน่วย</th>
                                                        <?php if ($remark==1) { ?>
                                                        <th width="250">Caseback No.</th>
                                                        <?php } ?>
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
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform(<?php echo $remark; ?>)"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
                                
                                <a href="<?php echo site_url("warehouse_transfer/transferstock"); ?>"><button type="button" class="btn btn-danger" name="resetbtn" id="resetbtn"><i class='fa fa-rotate-left'></i>  เริ่มต้นใหม่ </button></a>
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
            var whid_out = <?php echo $whid_out; ?>;
            var whname_out = "<?php echo $whname_out; ?>";
            var luxury = <?php echo $remark; ?>;
            if(product_code_value != "")
			{
                check_product_code(product_code_value, whid_out, whname_out, luxury);
                
			}
            
            $(this).val('');
		}
	});

});
function check_product_code(refcode_input, whid_out, whname_out, luxury)
{
	if(refcode_input != "")
	{
        if (luxury == 0) {
            $.ajax({
                type : "POST" ,
                url : "<?php echo site_url("warehouse_transfer/checkStock_transfer"); ?>" ,
                data : {refcode: refcode_input, whid_out: whid_out },
                success : function(data) {
                    if(data != "")
                    {
                        var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                        $('table > tbody').append(element);
                        count_enter_form_input_product++;
                        count_list++;
                        document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                    }else{
                        alert("ไม่พบ Ref. Code ที่ต้องการในคลัง "+whname_out);
                    }
                }
            });
        }else{
            $.ajax({
                type : "POST" ,
                url : "<?php echo site_url("warehouse_transfer/checkStock_transfer_caseback"); ?>" ,
                data : {refcode: refcode_input, whid_out: whid_out} ,
                success : function(data) {
                    if(data != "")
                    {
                        var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                        $('table > tbody').append(element);
                        count_enter_form_input_product++;
                        count_list++;
                        document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                    }else{
                        alert("ไม่พบ Caseback No. ที่ต้องการในคลัง "+whname_out);
                    }
                }
            });
        }
	}
}

function delete_item_row(row1)
{
    count_list--;
    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
    $('#row'+row1).remove();
}
    
function submitform(x)
{
    var whid_out = <?php echo $whid_out; ?>;
    var whid_in = <?php echo $whid_in; ?>;
    var datein = "<?php echo $datein; ?>";
    var it_code = document.getElementsByName('it_code');
    if (whid_out < 0) {
        alert("กรุณาเลือกคลังสินค้า");
    }else if (whid_in < 0) {
        alert("กรุณาเลือกคลังสินค้า");
    }else if (datein == "") {
        alert("กรุณาเลือกวันที่รับเข้า");
    }else if (whid_out == whid_in) {
        alert("ไม่สามารถย้ายคลังเดียวกันได้");
    }else{
        var duplicate = 0;
        for(var i=0; i<it_code.length; i++){
            for(var j=i+1; j<it_code.length; j++){
                if (it_code[i].value==it_code[j].value) {
                    it_code[j].className += " text-red";
                    duplicate++;
                }
            }
        }
        if (duplicate > 0) {
            alert("Caseback ซ้ำกัน");
        }else{
            var r = confirm("ยืนยันการย้ายคลังสินค้า !!");
            if (r == true) {
                confirmform(x);
            }
        }
    }
}

function confirmform(luxury)
{
    if (luxury==1) {
        var whid_out = <?php echo $whid_out; ?>;
        var whid_in = <?php echo $whid_in; ?>;
        var datein = "<?php echo $datein; ?>";
        var it_id = document.getElementsByName('it_id');
        var it_quantity = document.getElementsByName('it_quantity');
        var it_old_qty = document.getElementsByName('old_qty');
        var it_array = new Array();
        
        var it_code = document.getElementsByName('it_code');
        for(var i=0; i<it_code.length; i++){
            it_array[i] = {id: it_id[i].value, qty: 1, code: it_code[i].value, old_qty: it_old_qty[i].value};
        }
        document.getElementById("savebtn").disabled = true;

        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("warehouse_transfer/transferstock_save/1"); ?>" ,
            data : {datein: datein, whid_out: whid_out, whid_in: whid_in, item: it_array} ,
            dataType: 'json',
            success : function(data) {
                var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบย้ายคลังชั่วคราว ใช่หรือไม่";
                bootbox.confirm(message, function(result) {
                        var currentForm = this;
                        if (result) {
                            window.open("<?php echo site_url("warehouse_transfer/transferstock_print_serial"); ?>"+"/"+data.b, "_blank");
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
    }else if (luxury==0){
        var whid_out = <?php echo $whid_out; ?>;
        var whid_in = <?php echo $whid_in; ?>;
        var datein = "<?php echo $datein; ?>";
        var it_id = document.getElementsByName('it_id');
        var it_quantity = document.getElementsByName('it_quantity');
        var it_old_qty = document.getElementsByName('old_qty');
        var it_array = new Array();
        var checked = 0;
        var index = 0;
        
        for(var i=0; i<it_quantity.length; i++){
            if (it_quantity[i].value % 1 != 0 || it_quantity[i].value == "") {
                alert("กรุณาใส่จำนวนสินค้าที่เป็นตัวเลขเท่านั้น");
                it_quantity[i].value = '';
                return;
            }

        }
        document.getElementById("savebtn").disabled = true;
        
        for(var i=0; i<it_id.length; i++){
            
            for(var j=0; j<index; j++) {
                if (it_id[i].value == it_array[j]['id']) {
                    it_array[j]['qty'] = parseInt(it_array[j]['qty']) + parseInt(it_quantity[i].value);
                    
                    checked++;
                }
                
            }
            if (checked==0) {
                it_array[index] = {id: it_id[i].value, qty: it_quantity[i].value, old_qty: it_old_qty[i].value};
                index++;
            }else{
                checked = 0;
            }
        }
        
        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("warehouse_transfer/transferstock_save/0"); ?>" ,
            data : {datein: datein, whid_out: whid_out, whid_in: whid_in, item: it_array} ,
            dataType: 'json',
            success : function(data) {
                var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบย้ายคลังชั่วคราว ใช่หรือไม่";
                bootbox.confirm(message, function(result) {
                        var currentForm = this;
                        if (result) {
                            window.open("<?php echo site_url("warehouse_transfer/transferstock_print"); ?>"+"/"+data.b, "_blank");
                            window.location = "<?php echo site_url("warehouse_transfer/transferstock"); ?>";
                        }else{
                            window.location = "<?php echo site_url("warehouse_transfer/transferstock"); ?>";
                        }

                });
                
                
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
                document.getElementById("savebtn").disabled = false;
            }
        });
    }
    
}
    
</script>
</body>
</html>