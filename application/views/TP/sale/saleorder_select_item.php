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
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-6">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Ref. Code ที่ขาย">
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
														<th width="105">จำนวน</th>
														<th>หน่วย</th>
                                                        <th>Barcode</th>
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
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
                                
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
            if(product_code_value != "")
			{
                check_product_code(product_code_value, shop_id);
                
			}
            
            $(this).val('');
		}
	});

});
function check_product_code(refcode_input, shop_id)
{
    //alert(refcode_input+"/"+shop_id);
	if(refcode_input != "")
	{
        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("sale/check_code"); ?>" ,
            data : {refcode: refcode_input, shop_id: shop_id },
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
}

function submitform()
{
    var shopid = "<?php echo $shop_id; ?>";
    var datein = "<?php echo $datein; ?>";
    var it_quantity = document.getElementsByName('it_quantity');
    var barcode_id = document.getElementsByName('barcode_id');
    if (shopid < 0) {
        alert("กรุณาเลือกสาขาที่ขาย");
    }else if (datein == "") {
        alert("กรุณาเลือกวันที่ขาย");
    }else{
        for(var i=0; i<it_quantity.length; i++){
            if (it_quantity[i].value % 1 != 0 || it_quantity[i].value == "") {
                alert("กรุณาใส่จำนวนสินค้าที่เป็นตัวเลขเท่านั้น");
                it_quantity[i].value = '';
                return;
            }
            if (barcode_id[i].value < 0) {
                alert("กรุณาเลือกบาร์โค้ดห้าง");
                return;
            }

        }
        
        var r = confirm("ยืนยันการสั่งขาย !!");
        if (r == true) {
            confirmform();
        }
    }
}
    
function confirmform()
{
    var shop_id = "<?php echo $shop_id; ?>";
    var shop_code = "<?php echo $shop_code; ?>";
    var datein = "<?php echo $datein; ?>";
    var it_quantity = document.getElementsByName('it_quantity');
    var barcode_id = document.getElementsByName('barcode_id');
    var it_id = document.getElementsByName('it_id');
    var stob_id = document.getElementsByName('stob_id');
    var it_array = new Array();
    var checked = 0;
    var index = 0;

    document.getElementById("savebtn").disabled = true;

    for(var i=0; i<it_id.length; i++){

        for(var j=0; j<index; j++) {
            if (it_id[i].value == it_array[j]['id']) {
                it_array[j]['qty'] = parseInt(it_array[j]['qty']) + parseInt(it_quantity[i].value);

                checked++;
            }

        }
        if (checked==0) {
            it_array[index] = {id: it_id[i].value, qty: it_quantity[i].value, barcode_id: barcode_id[i].value, stob_id: stob_id[i].value};
            index++;
        }else{
            checked = 0;
        }
    }

    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("sale/saleorder_save"); ?>" ,
        data : {datein: datein, shop_id: shop_id, shop_code: shop_code, item: it_array} ,
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