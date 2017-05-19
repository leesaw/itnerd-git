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

            <h1 class="text-red">เอาสินค้าออกจากคลัง</h1>
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
                                            วันที่เอาออก
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
                            <!-- <div class="col-md-4">
                                <?php if ($sessrolex != 1) { ?>
                                <input type="radio" name="watch_luxury" id="watch_luxury" value="0" <?php if(($remark=='0') || (!isset($remark))) echo "checked"; ?> disabled> <label class="text-green"> No Caseback</label>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                <?php } ?>
              <input type="radio" name="watch_luxury" id="watch_luxury" value="1" <?php if ($remark=='1') echo "checked"; ?> disabled> <label class="text-red"> Caseback</label>
                            </div> -->
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-danger">
									<div class="panel-heading"><h4>เฉพาะสินค้าที่ไม่มี Caseback</h4><div class="input-group input-group-sm col-xs-8">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Ref. Code ที่ต้องการ">
                                        <div class="input-group-btn">

                                            <a data-toggle="modal" data-target="#myModal" type="button" class="btn btn-success" name="uploadbtn" id="uploadbtn"><i class='fa fa-upload'></i> นำเข้า Excel</a>
                                            <a href="<?php echo base_url()."uploads/excel/ตัวอย่างไฟล์นำเข้า_fashion.xlsx"; ?>" type="button" class="btn bg-purple btn-sm"><i class='fa fa-file-excel-o'></i> ตัวอย่าง Excel</a>
                                        </div> <label id="count_all_refcode" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label>
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
                                                        <th>จำนวนคงเหลือ</th>
														<th width="105">จำนวน</th>
														<th>หน่วย</th>
														<th>จัดการ</th>
				                                    </tr>
				                                </thead>
												<tbody>
												</tbody>
                                                <!-- <tfoot>
                                                    <tr style="font-size:120%;" class="text-red">
                                                        <th colspan="3" style="text-align:right;"><label>ราคารวม:</th>
                                                        <th><div id="summary_refcode"></div></th>
                                                        <th style="text-align:right;"><label>จำนวนรวม:</th>
                                                        <th><div id="allcount_refcode"></div></th>
																												<th></th><th></th>
                                                    </tr>
                                                </tfoot> -->
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-warning">
									<div class="panel-heading"><h4>เฉพาะสินค้า Caseback</h4><div class="input-group input-group-sm col-xs-8">
                                        <input type="text" class="form-control" name="caseback" id="caseback" placeholder="Caseback No. ที่ต้องการ">
                                        <div class="input-group-btn">

                                            <a data-toggle="modal" data-target="#myModal_caseback" type="button" class="btn btn-success" name="uploadbtn" id="uploadbtn"><i class='fa fa-upload'></i> นำเข้า Excel</a>
                                            <a href="<?php echo base_url()."uploads/excel/ตัวอย่างไฟล์นำเข้า_caseback.xlsx"; ?>" type="button" class="btn bg-purple btn-sm"><i class='fa fa-file-excel-o'></i> ตัวอย่าง Excel</a>
                                        </div> <label id="count_all_caseback" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label>
                                        </div></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablecaseback" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>Ref. Code</th>
                                                        <th>ยี่ห้อ</th>
                                                        <th>รุ่น</th>
                                                        <th>ราคาขาย</th>
														<th width="105">จำนวน</th>
														<th>หน่วย</th>
                                                        <th width="250">Caseback No.</th>

														<th>จัดการ</th>
				                                    </tr>
				                                </thead>
												<tbody>
												</tbody>
                                                <!-- <tfoot>
                                                    <tr style="font-size:120%;" class="text-red">
                                                        <th colspan="3" style="text-align:right;"><label>ราคารวม:</th>
                                                        <th><div id="summary_caseback"></div></th>
                                                        <th style="text-align:right;"><label>จำนวนรวม:</th>
                                                        <th><div id="allcount_caseback"></div></th>
																												<th></th><th></th>
                                                    </tr>
                                                </tfoot> -->
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
                                    <input type="text" class="form-control" name="stotremark" id="stotremark" value="">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;

                                <a href="<?php echo site_url("warehouse_transfer/out_form_stock"); ?>"><button type="button" class="btn btn-danger" name="resetbtn" id="resetbtn"><i class='fa fa-rotate-left'></i>  เริ่มต้นใหม่ </button></a>
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
                    <i class='fa fa-upload'></i> นำเข้า Excel Ref. Code
                </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
                <form action="<?php echo site_url("warehouse_transfer/upload_excel_import_stock"); ?>" method="post" enctype="multipart/form-data" id="form_uploadexcel" class="form-horizontal">
                <div class="row"><div class="col-md-12"><div class="form-group"><label class="col-md-4 control-label" for="donedate_done">เลือกไฟล์</label><div class="col-md-8"> <input type="file" class="form-control" id="excelfile_name" name="excelfile_name" /></div></div></form> </div>  </div>

            </div>            <!-- /modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="upload_excel(0);">Upload</button>

            </div>

        </div>
    </div>
</div>

<!-- datepicker modal for upload excel -->
    <div class="modal fade" id="myModal_caseback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_caseback" aria-hidden="true">

      <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class='fa fa-upload'></i> นำเข้า Excel Caseback
                </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
                <form action="<?php echo site_url("warehouse_transfer/upload_excel_import_stock"); ?>" method="post" enctype="multipart/form-data" id="form_uploadexcel_caseback" class="form-horizontal">
                <div class="row"><div class="col-md-12"><div class="form-group"><label class="col-md-4 control-label" for="donedate_done">เลือกไฟล์</label><div class="col-md-8"> <input type="file" class="form-control" id="excelfile_name_caseback" name="excelfile_name_caseback" /></div></div></form> </div>  </div>

            </div>            <!-- /modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="upload_excel(1);">Upload</button>

            </div>

        </div>
    </div>
</div>

</div>
<!-- close modal -->
<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">

var count_enter_form_input_product_refcode = 0;
var count_list_refcode = 0;
var count_enter_form_input_product_caseback = 0;
var count_list_caseback = 0;

$(document).ready(function()
{
    document.getElementById("savebtn").disabled = false;

    $('#refcode').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var product_code_value = $.trim($(this).val());
            var whid_out = <?php echo $whid_out; ?>;
            var whname_out = "<?php echo $whname_out; ?>";
            if(product_code_value != "")
			{
                check_product_code(product_code_value, whid_out, whname_out, 0);

			}

            $(this).val('');

            setTimeout(function(){
                // calculate(0);
            },3000);
		}
	});

		$('#caseback').keyup(function(e){ //enter next
				if(e.keyCode == 13) {
						var product_code_value = $.trim($(this).val());
						var whid_out = <?php echo $whid_out; ?>;
						var whname_out = "<?php echo $whname_out; ?>";
						if(product_code_value != "")
						{
											check_product_code(product_code_value, whid_out, whname_out, 1);

						}

									$(this).val('');

									setTimeout(function(){
											// calculate(1);
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

function check_product_code(refcode_input, whid_out, whname_out, luxury)
{
	if(refcode_input != "")
	{
        if (luxury == 0) {
            $.ajax({
                type : "POST" ,
                url : "<?php echo site_url("warehouse_transfer/checkStock_transfer_out_onlyfashion"); ?>" ,
                data : {refcode: refcode_input, whid_out: whid_out },
                success : function(data) {
                    if(data != "")
                    {
                        var element = '<tr id="row_refcode'+count_enter_form_input_product_refcode+'">'+data+'<td><button type="button" id="row_refcode'+count_enter_form_input_product_refcode+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product_refcode+', 0);"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                        $('#tablerefcode > tbody').append(element);
                        count_enter_form_input_product_refcode++;
                        count_list_refcode++;
                        document.getElementById("count_all_refcode").innerHTML = "จำนวน &nbsp&nbsp "+count_list_refcode+"   &nbsp&nbsp รายการ";
                    }else{
                        alert("ไม่พบ Ref. Code ที่ต้องการในคลัง "+whname_out);
                    }
                }
            });
        }else{
            $.ajax({
                type : "POST" ,
                url : "<?php echo site_url("warehouse_transfer/checkStock_transfer_out_caseback"); ?>" ,
                data : {refcode: refcode_input, whid_out: whid_out} ,
                success : function(data) {
                    if(data != "")
                    {
                        var element = '<tr id="row_caseback'+count_enter_form_input_product_caseback+'">'+data+'<td><button type="button" id="row_caseback'+count_enter_form_input_product_caseback+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product_caseback+', 1);"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                        $('#tablecaseback > tbody').append(element);
                        count_enter_form_input_product_caseback++;
                        count_list_caseback++;
                        document.getElementById("count_all_caseback").innerHTML = "จำนวน &nbsp&nbsp "+count_list_caseback+"   &nbsp&nbsp รายการ";
                    }else{
                        alert("ไม่พบ Caseback No. ที่ต้องการในคลัง "+whname_out);
                    }
                }
            });
        }
	}
}


function delete_item_row(row1, remark)
{
	if (remark == 0) {
    count_list_refcode--;
    document.getElementById("count_all_refcode").innerHTML = "จำนวน &nbsp&nbsp "+count_list_refcode+"   &nbsp&nbsp รายการ";
    $('#row_refcode'+row1).remove();

	}else{
		count_list_caseback--;
    document.getElementById("count_all_caseback").innerHTML = "จำนวน &nbsp&nbsp "+count_list_caseback+"   &nbsp&nbsp รายการ";
    $('#row_caseback'+row1).remove();

	}
}

function submitform(x)
{
    var whid_out = <?php echo $whid_out; ?>;
    var datein = "<?php echo $datein; ?>";
    var it_code = document.getElementsByName('it_code');
    var it_final_refcode = document.getElementsByName('it_quantity_refcode');
    var qty_old_refcode = document.getElementsByName('old_qty_refcode');
    if (whid_out < 0) {
        alert("กรุณาเลือกคลังสินค้า");
    }else if (datein == "") {
        alert("กรุณาเลือกวันที่รับเข้า");
    }else{
        for(var i=0; i<it_final_refcode.length; i++){
            if (it_final_refcode[i].value == "") {
                alert("กรุณาใส่จำนวนสินค้าให้ครบทุกช่อง");
                return;
            }

            if (parseInt(it_final_refcode[i].value) > parseInt(qty_old_refcode[i].value)) {
                alert("จำนวนสินค้าคงเหลือไม่เพียงพอกับที่ต้องการ !!");
                return;
            }
        }
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
            var r = confirm("ยืนยันเอาสินค้าออกจากคลัง !!");
            if (r == true) {
                confirmform();
            }
        }
    }
}

function confirmform()
{
		var whid_out = <?php echo $whid_out; ?>;
		var datein = "<?php echo $datein; ?>";
		var stot_remark =  document.getElementById("stotremark").value;

    var it_id_refcode = document.getElementsByName('it_id_refcode');
		var it_id_caseback = document.getElementsByName('it_id_caseback');
    var itse_id = document.getElementsByName('itse_id');
    var it_quantity_refcode = document.getElementsByName('it_quantity_refcode');
		var it_quantity_caseback = document.getElementsByName('it_quantity_caseback');
    var it_old_qty_refcode = document.getElementsByName('old_qty_refcode');
		var it_old_qty_caseback = document.getElementsByName('old_qty_caseback');
		var it_code = document.getElementsByName('it_code');

    var it_array_caseback = new Array();

		for(var i=0; i<it_quantity_refcode.length; i++){
				if (it_quantity_refcode[i].value % 1 != 0 || it_quantity_refcode[i].value == "") {
						alert("กรุณาใส่จำนวนสินค้าที่เป็นตัวเลขเท่านั้น");
						it_quantity_refcode[i].value = '';
						return;
				}

		}

    for(var i=0; i<it_code.length; i++){
        it_array_caseback[i] = {id: it_id_caseback[i].value, itse_id: itse_id[i].value, qty: 1, code: it_code[i].value, old_qty: it_old_qty_caseback[i].value};
    }

		var it_array_refcode = new Array();
		var checked = 0;
		var index = 0;

		for(var i=0; i<it_id_refcode.length; i++){

				for(var j=0; j<index; j++) {
						if (it_id_refcode[i].value == it_array_refcode[j]['id']) {
								it_array_refcode[j]['qty'] = parseInt(it_array_refcode[j]['qty']) + parseInt(it_quantity_refcode[i].value);

								checked++;
						}

				}
				if (checked==0) {
						it_array_refcode[index] = {id: it_id_refcode[i].value, qty: it_quantity_refcode[i].value, old_qty: it_old_qty_refcode[i].value};
						index++;
				}else{
						checked = 0;
				}
		}

		document.getElementById("savebtn").disabled = true;

    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("warehouse_transfer/save_out_stock"); ?>" ,
        data : {datein: datein, whid_out: whid_out, item_caseback: it_array_caseback, item_refcode: it_array_refcode, stot_remark: stot_remark} ,
        dataType: 'json',
        success : function(data) {
            var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบเอาสินค้าออกจากคลัง ใช่หรือไม่";
            bootbox.confirm(message, function(result) {
                    var currentForm = this;
                    if (result) {
                        window.open("<?php echo site_url("warehouse_transfer/out_stock_final_print"); ?>"+"/"+data.b, "_blank");
                        window.location = "<?php echo site_url("warehouse_transfer/out_form_stock"); ?>";
                    }else{
                        window.location = "<?php echo site_url("warehouse_transfer/out_form_stock"); ?>";
                    }

            });


        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
            document.getElementById("savebtn").disabled = false;
        }
    });


}

function upload_excel(remark) {
		if (remark == 0) var fileSelect = document.getElementById('excelfile_name');
		else var fileSelect = document.getElementById('excelfile_name_caseback');
    var files = fileSelect.files;
    var formData = new FormData();
    var whname_out = "<?php echo $whname_out; ?>";

    if (files[0] != 'undefined') {
        formData.append("excelfile_name", files[0]);

        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("warehouse_transfer/upload_excel_transfer_out_stock_fashion")."/"; ?>"+remark+"<?php echo "/".$whid_out; ?>" ,
            data : formData ,
            processData : false,
            contentType : false,
            dataType: 'json',
            success : function(data) {
                if(data.length > 0)
                {
										if (remark == 0) {
	                    for(var i=0; i<data.length; i++) {
	                        var element = '<tr id="row_refcode'+count_enter_form_input_product_refcode+'">'+data[i]+'<td><button type="button" id="row_refcode'+count_enter_form_input_product_refcode+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product_refcode+', 0);"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
													$('#tablerefcode > tbody').append(element);
	                        count_enter_form_input_product_refcode++;
	                        count_list_refcode++;
	                    }
	                    document.getElementById("count_all_refcode").innerHTML = "จำนวน &nbsp&nbsp "+count_list_refcode+"   &nbsp&nbsp รายการ";

	                    var message = "ทำการนำเข้าข้อมูลเรียบร้อยแล้ว";
	                    bootbox.alert(message, function() {
	                        $('#myModal').modal('hide');
	                    });
										}else{
											for(var i=0; i<data.length; i++) {
	                        var element = '<tr id="row_caseback'+count_enter_form_input_product_caseback+'">'+data[i]+'<td><button type="button" id="row_caseback'+count_enter_form_input_product_caseback+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product_caseback+', 1);"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
													$('#tablecaseback > tbody').append(element);
	                        count_enter_form_input_product_caseback++;
	                        count_list_caseback++;
	                    }
	                    document.getElementById("count_all_caseback").innerHTML = "จำนวน &nbsp&nbsp "+count_list_caseback+"   &nbsp&nbsp รายการ";

	                    var message = "ทำการนำเข้าข้อมูลเรียบร้อยแล้ว";
	                    bootbox.alert(message, function() {
	                        $('#myModal_caseback').modal('hide');
	                    });
										}
                }else{
                    alert("ไม่พบสินค้าที่ต้องการในคลัง "+whname_out);
                }

            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
    }
    setTimeout(function(){
        // calculate();
    },3000);

};
</script>
</body>
</html>
