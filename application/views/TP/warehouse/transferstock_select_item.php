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
                                        <input type="text" class="form-control" name="whid_out" id="whid_out" value="<?php echo $whname_out; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-1">
                                <br><center><i class="fa fa-arrow-right"></i></center>
                            </div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        เข้าคลัง *
                                        <input type="text" class="form-control" name="whid_in" id="whid_in" value="<?php echo $whname_in; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-4">
                                <?php echo $caseback_label; ?>
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
                                
                                <a  href="<?php echo site_url("warehouse_transfer/transferstock"); ?>"><button type="button" class="btn btn-danger" name="resetbtn" id="resetbtn"><i class='fa fa-rotate-left'></i>  เริ่มต้นใหม่ </button></a>
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
            var luxury = <?php echo $remark; ?>;
            if(product_code_value != "")
			{
                check_product_code(product_code_value, luxury);
                
			}
            $(this).val('');
		}
	});

});
function check_product_code(refcode_input, luxury)
{
	if(refcode_input != "")
	{
        if (luxury == 0) {
            $.ajax({
                type : "POST" ,
                url : "<?php echo site_url("item/getRefcode"); ?>" ,
                data : {refcode: refcode_input, luxury: luxury} ,
                success : function(data) {
                    if(data != "")
                    {
                        var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                        $('table > tbody').append(element);
                        count_enter_form_input_product++;
                        count_list++;
                        document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                    }else{
                        alert("ไม่พบ Ref. Code ที่ต้องการ");
                    }
                }
            });
        }else{
            $.ajax({
                type : "POST" ,
                url : "<?php echo site_url("item/getCaseback"); ?>" ,
                data : {refcode: refcode_input} ,
                success : function(data) {
                    if(data != "")
                    {
                        var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                        $('table > tbody').append(element);
                        count_enter_form_input_product++;
                        count_list++;
                        document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                    }else{
                        alert("ไม่พบ Caseback No. ที่ต้องการ");
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
    
function submitform(luxury)
{
    if (document.getElementById('whid').value < 0) {
        alert("กรุณาเลือกคลังสินค้า");
        document.getElementById('whid').focus();
    }else if (document.getElementById('datein').value == "") {
        alert("กรุณาเลือกวันที่รับเข้า");
        document.getElementById('datein').focus();
    }else if (luxury==1) {
        var datein = document.getElementById("datein").value;
        var whid = document.getElementById('whid').value;
        var it_id = document.getElementsByName('it_id');
        var it_array = new Array();
        var it_code = document.getElementsByName('it_code');
        for(var i=0; i<it_code.length; i++){
            if (it_code[i].value == "") {
                alert("กรุณาใส่ Cashback No. ให้ครบทุกช่อง");
                return;
            }
            it_array[i] = {id: it_id[i].value, qty: 1, code: it_code[i].value};
        }
        document.getElementById("savebtn").disabled = true;

        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("warehouse_transfer/importstock_save/1"); ?>" ,
            data : {datein: datein, whid: whid, item: it_array} ,
            dataType: 'json',
            success : function(data) {
                var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบรับเข้าคลัง ใช่หรือไม่";
                bootbox.confirm(message, function(result) {
                        var currentForm = this;
                        if (result) {
                            window.open("<?php echo site_url("warehouse_transfer/importstock_print"); ?>"+"/"+data.b, "_blank");
                            location.reload();
                        }else{
                            location.reload();
                        }

                });
                
                
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
    }else if (luxury==0){
        document.getElementById("savebtn").disabled = true;

        var datein = document.getElementById("datein").value;
        var whid = document.getElementById('whid').value;
        var it_id = document.getElementsByName('it_id');
        var it_quantity = document.getElementsByName('it_quantity');
        var it_array = new Array();

        for(var i=0; i<it_id.length; i++){
            it_array[i] = {id: it_id[i].value, qty: it_quantity[i].value};
        }

        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("warehouse_transfer/importstock_save/0"); ?>" ,
            data : {datein: datein, whid: whid, item: it_array} ,
            dataType: 'json',
            success : function(data) {
                var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบรับเข้าคลัง ใช่หรือไม่";
                bootbox.confirm(message, function(result) {
                        var currentForm = this;
                        if (result) {
                            window.open("<?php echo site_url("warehouse_transfer/importstock_print"); ?>"+"/"+data.b, "_blank");
                            location.reload();
                        }else{
                            location.reload();
                        }

                });
                
                
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
    }
    
}
    
</script>
</body>
</html>