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

            <h1 class="text-red">ขอคืนสินค้าจากการสั่งขาย</h1>
        </section>

		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-danger">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("warehouse_transfer/save_importstock"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่ขอคืนสินค้า
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group-sm">
                                        เลขที่ใบสั่งขาย *
                                        <input type="text" class="form-control" name="so_number" id="so_number" value="<?php echo $so_number; ?>" readonly>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group-sm">
											คลังเดิม *
											<input type="text" class="form-control" name="wh_name" id="wh_name" value="<?php echo $warehouse_name; ?>" readonly>
									</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-danger">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-8">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="<?php if ($serial == 0) echo "Ref. Code ที่ต้องการ"; else echo "Caseback ที่ต้องการ"; ?>">
                                        <div class="input-group-btn">
                                            </div><label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label>
                                        </div></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablerefcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>Ref. Code</th>
                                                        <th>ยี่ห้อ</th>
                                                        <th>รุ่น</th>
                                                        <th>ราคาขาย</th>
																												<?php if ($serial == 0) { ?>
																													<th>จำนวนเดิมในเอกสาร</th>
																												<?php } ?>
														<th width="105">จำนวนที่ต้องการคืน</th>
														<th>หน่วย</th>
                            <?php if ($serial > 0) { ?>
                            <th width="200">Caseback No.</th>
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
                                <div class="form-group-sm">
                                    Remark
                                    <input type="text" class="form-control" name="storremark" id="storremark" value="">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform(<?php echo $serial; ?>)"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;

                                <a href="<?php echo site_url("tp_stock_return/form_return_request"); ?>"><button type="button" class="btn btn-danger" name="resetbtn" id="resetbtn"><i class='fa fa-rotate-left'></i>  เริ่มต้นใหม่ </button></a>
							</div>
						</div>
						</form>

					</div>
				</div>
			</div>
            </div></section>
	</div>
</div>


</div>
<!-- close modal -->
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
            var so_id = <?php echo $so_id; ?>;
            var serial = <?php echo $serial; ?>;
            // var so_number = <?php echo $so_number; ?>;
            if(product_code_value != "")
      			{
              check_product_code(product_code_value, so_id, serial);
      			}

            $(this).val('');

            setTimeout(function(){
                // calculate(0);
            },3000);
		}
	});


});

function calculate(remark) {
    var count = 0;
    var sum = 0;
    var srp = document.getElementsByName('it_srp');
    var qty = document.getElementsByName('it_quantity');
    for(var i=0; i<qty.length; i++) {
        if (qty[i].value == "") qty[i].value = 0;
        count += parseInt(qty[i].value);
        sum += parseInt(qty[i].value)*parseInt(srp[i].value);
    }
    document.getElementById("summary").innerHTML = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    document.getElementById("allcount").innerHTML = count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function check_product_code(refcode_input, so_id, luxury)
{
	if(refcode_input != "")
	{
    if (luxury == 0) {
        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("tp_stock_return/check_refcode_so_id"); ?>" ,
            data : {refcode: refcode_input, so_id: so_id },
            success : function(data) {
                if(data != "")
                {
                    var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                    $('#tablerefcode > tbody').append(element);
                    count_enter_form_input_product++;
                    count_list++;
                    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                }else{
                    alert("ไม่พบ Ref. Code ที่ต้องการในเลขที่สั่งขายนี้");
                }
            }
        });
    }else{
        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("tp_stock_return/check_caseback_so_id"); ?>" ,
            data : {refcode: refcode_input, so_id: so_id },
            success : function(data) {
                if(data != "")
                {
                    var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                    $('#tablerefcode > tbody').append(element);
                    count_enter_form_input_product++;
                    count_list++;
                    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                }else{
                    alert("ไม่พบ Caseback No. ที่ต้องการในเลขที่สั่งขายนี้");
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
    var so_id = <?php echo $so_id; ?>;
    var datein = "<?php echo $datein; ?>";

		var it_id = document.getElementsByName('it_id');
		var it_code = document.getElementsByName('it_code');
    var it_final = document.getElementsByName('it_quantity');
    var qty_old = document.getElementsByName('old_qty');
		var duplicate = 0;

		if (so_id < 0) {
        alert("กรุณาเลือกคลังสินค้า");
    }else if (datein == "") {
        alert("กรุณาใส่เลขที่ใบสั่งขาย");
    }else{

			if (x == 0) {
				for(var i=0; i<it_id.length; i++){
					for(var j=i+1; j<it_id.length; j++){
							if (it_id[i].value==it_id[j].value) {
									it_id[j].className += " text-red";
									duplicate++;
							}
					}
				}
				if (duplicate > 0) {
					alert("กรุณาใส่ Ref. Code ที่ไม่ซ้ำกัน");
					return;
				}
				for(var i=0; i<it_final.length; i++){

            if (it_final[i].value == "") {
							console.log(it_final[i].value);
                alert("กรุณาใส่จำนวนสินค้าที่ต้องการคืนให้ครบทุกช่อง");
                return;
            }
						console.log(qty_old[i].value);
            if (parseInt(it_final[i].value) > parseInt(qty_old[i].value)) {
                alert("จำนวนสินค้าคงเหลือไม่เพียงพอกับที่ต้องการ !!");
                return;
            }
        }

			}else{
				duplicate = 0;
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
					return;
				}
			}

			var r = confirm("ยืนยันขอคืนสินค้า !!");
			if (r == true) {
					confirmform(x);
			}
		}

}

function confirmform(x)
{

		var so_id = <?php echo $so_id; ?>;
		var datein = "<?php echo $datein; ?>";
		var stor_remark =  document.getElementById("storremark").value;

    var it_id = document.getElementsByName('it_id');
    var itse_id = document.getElementsByName('itse_id');
    var it_quantity = document.getElementsByName('it_quantity');
    var it_old_qty = document.getElementsByName('old_qty');
		var it_code = document.getElementsByName('it_code');

    var it_array = new Array();

		for(var i=0; i<it_quantity.length; i++){
				if (it_quantity[i].value % 1 != 0 || it_quantity[i].value == "") {
						alert("กรุณาใส่จำนวนสินค้าที่เป็นตัวเลขเท่านั้น");
						it_quantity[i].value = '';
						return;
				}

		}

		if (x==0) {
			var checked = 0;
			var index = 0;

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
		}else{
			for(var i=0; i<it_code.length; i++){
	        it_array[i] = {id: it_id[i].value, itse_id: itse_id[i].value, qty: 1, code: it_code[i].value, old_qty: it_old_qty[i].value};
	    }
		}

		document.getElementById("savebtn").disabled = true;

    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_stock_return/save_return_request"); ?>" ,
        data : {datein: datein, so_id: so_id, item_array: it_array, remark: stor_remark, serial: x} ,
        dataType: 'json',
        success : function(data) {
            var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบขอคืนสินค้าจากการสั่งขาย ใช่หรือไม่";
            bootbox.confirm(message, function(result) {
                    var currentForm = this;
                    if (result) {
                        window.open("<?php echo site_url("tp_stock_return/print_return_request"); ?>"+"/"+data.b, "_blank");
                        window.location = "<?php echo site_url("tp_stock_return/form_return_request"); ?>";
                    }else{
                        window.location = "<?php echo site_url("tp_stock_return/form_return_request"); ?>";
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
