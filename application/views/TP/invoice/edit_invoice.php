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

            <h1>แก้ไขใบ Invoice</h1>
        </section>
<?php
    foreach($inv_array as $loop) {
        $inv_id = $loop->inv_id;
        $inv_datein = $loop->inv_issuedate;
        $inv_number = $loop->inv_number;
        $datein_array = explode("-",$inv_datein);
        $inv_datein = $datein_array[2]."/".$datein_array[1]."/".$datein_array[0];
        $inv_warehouse_id = $loop->inv_warehouse_id;
        $inv_whname = $loop->wh_code."-".$loop->wh_name;
        $inv_cusname = $loop->inv_warehouse_detail;
        $inv_address1 = $loop->inv_warehouse_address1;
        $inv_address2 = $loop->inv_warehouse_address2;
        $inv_taxid = $loop->inv_warehouse_taxid;
        $inv_branch_number = $loop->inv_warehouse_branch;
        $inv_branch = $loop->inv_warehouse_branch;
        if ($inv_branch == 0) {
            $inv_branch = "สำนักงานใหญ่";
        }else{
            $inv_branch = str_pad($inv_branch, 5, '0', STR_PAD_LEFT);
        }

        $inv_vender = $loop->inv_vender;
        $inv_barcode = $loop->inv_barcode;
        $inv_stot_number = $loop->inv_stot_number;
        $inv_stot_id = $loop->inv_stot_id;
        $inv_srp_discount = $loop->inv_srp_discount;
        $inv_note = $loop->inv_note;
        $inv_dateadd = $loop->inv_dateadd;
        $inv_remark = $loop->inv_remark;
        $inv_enable = $loop->inv_enable;

        $editor_view = $loop->firstname." ".$loop->lastname." ".$loop->inv_dateadd;
    }
?>
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                        วันที่ออกใบ Invoice
                                        <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $inv_datein; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                        เลขที่ Invoice
                                        <input type="text" class="form-control" name="number" id="number" value="<?php echo $inv_number; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
									<div class="form-group-sm">
                                        คลังสินค้า
                                        <select class="form-control select2" name="whid" id="whid" style="width: 100%;" onchange="showdetail()">
                                            <option value='-1'>-- เลือกคลังสินค้า --</option>
                                            <option value='1035'>HOM-คลังหลัก</option>
                                        <?php   if(is_array($wh_array)) {
                                                foreach($wh_array as $loop){
                                                    echo "<option value='".$loop->wh_id."'";
                                                    if ($loop->wh_id == $inv_warehouse_id) echo " selected";
                                                    echo ">".$loop->wh_code."-".$loop->wh_name."</option>";
                                         } } ?>
                                        </select>
                                    </div>
							</div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    นามผู้ซื้อ *
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $inv_cusname; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    เลขประจำตัวผู้เสียภาษี *
                                    <input type="text" class="form-control" name="custax_id" id="custax_id" value="<?php echo $inv_taxid; ?>">
                                </div>
                            </div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    ที่อยู่ผู้ซื้อ แถวที่ 1 *
                                    <input type="text" class="form-control" name="cusaddress1" id="cusaddress1" value="<?php echo $inv_address1; ?>">
                                </div>
							</div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    ที่อยู่ผู้ซื้อ แถวที่ 2 *
                                    <input type="text" class="form-control" name="cusaddress2" id="cusaddress2" value="<?php echo $inv_address2; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <br>
                                <label class="radio-inline"><input type="radio" name="branch" id="branch_0" value="0"<?php if ($inv_branch==0) echo " checked"; ?>>สำนักงานใหญ่</label>
                                <label class="radio-inline"><input type="radio" name="branch" id="branch_1" value="-1"<?php if ($inv_branch_number>0) echo " checked"; ?>>สาขาที่ <input type="text" name="branch_number" id="branch_number" value="<?php if ($inv_branch_number>0) echo $inv_branch; ?>" placeholder="00001"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    Vender Code
                                    <input type="text" class="form-control" name="vender" id="vender" value="<?php echo $inv_vender; ?>">
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    Barcode
                                    <input type="text" class="form-control" name="barcode" id="barcode" value="<?php echo $inv_barcode; ?>">
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    เลขที่ใบส่งของอ้างอิง
                                    <input type="text" class="form-control" name="tb_number_input" id="tb_number_input" value="<?php echo $inv_stot_number; ?>">
                                    <input type="hidden" class="form-control" name="stot_id" id="stot_id" value="<?php echo $inv_stot_id; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    ส่วนลดราคาป้าย %
                                    <input type="text" class="form-control" name="discount_srp" id="discount_srp" value="<?php echo number_format($inv_srp_discount); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    หมายเหตุ
                                    <input type="text" class="form-control" name="note" id="note" value="<?php echo $inv_note; ?>" maxlength="45">
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
                                                        <th width="200">รายละเอียด</th>
                                                        <th width="100">ราคาป้าย</th>
                                                        <th width="100">ส่วนลดราคาป้าย %</th>
                                                        <th width="180">จำนวน</th>
                                                        <th width="180">หน่วยละ</th>
                                                        <th width="100">ส่วนลด %</th>
														<th width="200">จำนวนเงิน</th>
														<th width="80"> </th>
				                                    </tr>
				                                </thead>
												<tbody>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:200%;" class="text-red">
                                                        <th colspan="4" style="text-align:right;"><label>จำนวนรวม:</th>
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
                                    <input type="text" class="form-control" name="remark" id="remark" value="<?php echo $inv_remark; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-sm">
                                    แก้ไขล่าสุด
                                    <input type="text" class="form-control" name="editor" id="editor" value="<?php echo $editor_view; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
							<div class="col-md-12">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
                                <a href="<?php echo site_url('tp_invoice/view_invoice').'/'.$inv_id; ?>" type="button" class="btn btn-warning" name="resetbtn" id="resetbtn"><i class='fa fa-refresh'></i>  ยกเลิก </a>&nbsp;&nbsp;
							</div>
						</div>
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
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script></script>
<script type="text/javascript">

var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{
    //Initialize Select2 Elements
    $(".select2").select2();
    get_datepicker("#datein");

    start_get_invoice_item();

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

    $('#discount_srp').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var dc_value = $.trim($(this).val());
            var dc = document.getElementsByName('it_discount1');
            if(dc_value != "")
            {
                for(var i = 0; i < dc.length; i++) {
                    dc[i].value = dc_value;
                }
                calSRP();
                calDiscount();
            }

        }
    });

});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

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

function start_get_invoice_item()
{
    var inv_id = <?php echo $inv_id; ?>;
    var dc1 = document.getElementById("discount_srp").value;

    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_invoice/get_invoice_item"); ?>" ,
        data : {inv_id: inv_id, dc1: dc1},
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
                alert("ไม่พบสินค้าใน Invoice");
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

function check_transfer_number()
{
    var tb_number = document.getElementById("tb_number").value;
    var confirm_number;
    //alert(tb_number);

    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_invoice/check_transfer_number"); ?>" ,
        data : {tb_number: tb_number},
        dataType: 'json',
        success : function(data) {
            if(data.item.length > 0)
            {

                if (data.exist_number) {
                    if( confirm("เลขใบส่งของ "+tb_number+" ถูกอ้างอิงใน Invoice อื่นแล้ว\n\nต้องการดำเนินการต่อใช่หรือไม่")==true) {
                        confirm_number = true;
                    }else{
                        confirm_number = false;
                    }
                }else{ confirm_number = true; }

                if (confirm_number) {

                    for(var i=0; i<data.item.length; i++) {
                        var element = '<tr id="row'+count_enter_form_input_product+'">'+data.item[i]+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                        //console.log(element);
                        $('table > tbody').append(element);
                        count_enter_form_input_product++;
                        count_list++;
                    }
                    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";

                    /*document.getElementById("cusname").value = data.warehouse.wh_detail;
                    document.getElementById("cusaddress1").value = data.warehouse.wh_address1;
                    document.getElementById("cusaddress2").value = data.warehouse.wh_address2;
                    document.getElementById("custax_id").value = data.warehouse.wh_taxid;
                    document.getElementById("vender").value = data.warehouse.wh_vender;
                    */
                    var tb = document.getElementById("tb_number_input").value;
                    if (tb == "") {
                        document.getElementById("tb_number_input").value = data.warehouse.stot_number;
                    }else{
                        document.getElementById("tb_number_input").value = tb+","+data.warehouse.stot_number;
                    }
                    document.getElementById("stot_id").value = data.warehouse.stot_id;
                    /*
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
                    */
                    var message = "ทำการนำเข้าข้อมูลเรียบร้อยแล้ว";
                    bootbox.alert(message, function() {
                        $('#myModal').modal('hide');
                    });
                }

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
    document.getElementById("summary").innerHTML = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

function calSRP() {
    var result = 0;
    var srp1 = document.getElementsByName('it_srp1');
    var srp = document.getElementsByName('it_srp');
    var dc1 = document.getElementsByName('it_discount1');
    var dc_value;

    for(var i=0; i<dc1.length; i++) {
        if (dc1[i].value == "") { dc_value = 0; }
        else dc_value = dc1[i].value;
        srp[i].value = (parseFloat(srp1[i].value.replace(/,/g, '')) * (100 - parseFloat(dc_value))/100).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    calDiscount();
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
    document.getElementById("summary").innerHTML = sum.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
                calculate();
            },3000);
}

function submitform()
{

    var datein = document.getElementById('datein').value;
    var cusname = document.getElementById('cusname').value;
    var cusaddress = document.getElementById('cusaddress1').value;
    var custax_id = document.getElementById('custax_id').value;

    var branch = $('input[name="branch"]:checked').val();
    var wh_id = document.getElementById("whid").value;
    var branch_number = document.getElementById('branch_number').value;
    var it_id = document.getElementsByName('it_id');
    var it_dc = document.getElementsByName('it_discount');
    var it_net = document.getElementsByName('it_netprice');
    var it_qty = document.getElementsByName('it_qty');

    if (datein == "") {
        alert("กรุณาใส่วันที่ออกใบ Invoice");
        document.getElementById('datein').focus();
    }else if (wh_id == -1) {
        alert("กรุณาใส่เลือกคลังสินค้า");
        document.getElementById('whid').focus();
    }else if (it_id.length < 1) {
        alert("กรุณาใส่รายการสินค้า");
    }else if (cusname == "") {
        alert("กรุณาใส่นามผู้ซื้อ");
        document.getElementById('cusname').focus();
    }else if (cusaddress == "") {
        alert("กรุณาใส่ที่อยู่ผู้ซื้อ");
        document.getElementById('cusaddress1').focus();
    }else if (custax_id == "") {
        alert("กรุณาใส่เลขประจำตัวผู้เสียภาษีผู้ซื้อ");
        document.getElementById('custax_id').focus();
    }else if (branch != 0 && branch != -1 ) {
        alert("กรุณาเลือกสำนักงานใหญ่ หรือ สาขาที่");
    }else if (branch == -1 && branch_number =="") {
        alert("กรุณาใส่เลขที่สาขา");
        document.getElementById('branch_number').focus();
    }else{

        for(var i=0; i<it_dc.length; i++) {

            if ((it_qty[i].value).replace(/,/g, '')*1000 %  1 != 0) {
                alert("กรุณาใส่จำนวนเฉพาะตัวเลขเท่านั้น");
                it_qty[i].focus();
                return;
            }

            if ((it_dc[i].value).replace(/,/g, '')*1000 %  1 != 0) {
                alert("กรุณาใส่ส่วนลดเฉพาะตัวเลขเท่านั้น");
                it_dc[i].focus();
                return;
            }



            if (Math.round((it_net[i].value).replace(/,/g, '')*1000) %  1 != 0) {
                alert("กรุณาใส่จำนวนเฉพาะตัวเลขเท่านั้น");
                it_net[i].focus();
                return;
            }
        }

        var r = confirm("ยืนยันการขาย !!");
        if (r == true) {
            confirmform();
        }
    }
}

function confirmform()
{
    var inv_id = <?php echo $inv_id; ?>;
    var number = document.getElementById('number').value;
    var cusname = document.getElementById('cusname').value;
    var cusaddress1 = document.getElementById('cusaddress1').value;
    var cusaddress2 = document.getElementById('cusaddress2').value;
    var custax_id = document.getElementById('custax_id').value;
    var branch = $('input[name="branch"]:checked').val();
    var branch_number = document.getElementById('branch_number').value;

    var remark = document.getElementById('remark').value;

    var wh_id = document.getElementById("whid").value;
    var datein = document.getElementById('datein').value;
    var vender = document.getElementById('vender').value;
    var barcode = document.getElementById('barcode').value;
    var tb_number = document.getElementById('tb_number_input').value;
    var stot_id = document.getElementById('stot_id').value;
    var discount_srp = document.getElementById('discount_srp').value;
    var note = document.getElementById('note').value;


    var it_id = document.getElementsByName('it_id');
    var it_refcode = document.getElementsByName('it_refcode');
    var it_brand = document.getElementsByName('br_name');
    var it_srp = document.getElementsByName('it_srp');
    var it_dc = document.getElementsByName('it_discount');
    var it_net = document.getElementsByName('it_netprice');
    var it_qty = document.getElementsByName('it_qty');
    var it_array = new Array();
    var index = 0;

    for(var i=0; i<it_id.length; i++){
        it_array[index] = {id: it_id[i].value, refcode: it_refcode[i].value, brand: it_brand[i].value, qty: it_qty[i].value, dc: (it_dc[i].value).replace(/,/g, ''), net: (it_net[i].value).replace(/,/g, ''), srp: (it_srp[i].value).replace(/,/g, '')};
        index++;
    }

    document.getElementById("savebtn").disabled = true;

    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_invoice/save_edit_invoice"); ?>" ,
        data : {inv_id: inv_id, number: number, datein: datein, item: it_array, cusname: cusname, cusaddress1: cusaddress1, cusaddress2: cusaddress2, custax_id: custax_id, branch: branch, branch_number: branch_number, wh_id: wh_id, vender: vender, barcode: barcode, tb_number: tb_number, stot_id: stot_id, discount_srp: discount_srp, note: note, remark: remark} ,
        dataType: 'json',
        success : function(data) {
            var message = "เอกสาร Invoice เลขที่ "+data.a+" ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์เอกสาร ใช่หรือไม่";
            bootbox.confirm(message, function(result) {
                    var currentForm = this;
                    if (result) {
                        window.open("<?php echo site_url("tp_invoice/print_invoice"); ?>"+"/"+data.b, "_blank");
                        window.location = "<?php echo site_url("tp_invoice/view_invoice"); ?>/"+data.b;
                    }else{
                        window.location = "<?php echo site_url("tp_invoice/view_invoice"); ?>/"+data.b;
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
