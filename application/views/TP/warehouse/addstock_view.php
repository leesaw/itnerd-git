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
            
            <h1>รับสินค้าเข้าคลัง</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("warehouse_transfer/save_importstock"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่รับเข้า
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $currentdate; ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        เข้าคลัง *
                                        <select class="form-control" name="whid" id="whid">
                                            <option value='-1'>-- เลือกคลังสินค้า --</option>
										<?php 	if(is_array($wh_array)) {
												foreach($wh_array as $loop){
													echo "<option value='".$loop->wh_id."'>".$loop->wh_code."-".$loop->wh_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
                            <div class="col-md-4">
                                <?php if ($sessrolex != 1) { ?>
                                <input type="radio" name="watch_fashion" id="watch_fashion" value="1" <?php if(($remark=='0') || (!isset($remark))) echo "checked"; ?>> <label class="text-green"> No Caseback</label>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                <?php } ?>
              <input type="radio" name="watch_luxury" id="watch_luxury" value="1" <?php if ($remark=='1') echo "checked"; ?>> <label class="text-red"> Caseback</label>
                            </div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-6">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Ref. Code ที่รับเข้าคลัง">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary"><i class='fa fa-search'></i></button>
                                            <a data-toggle="modal" data-target="#myModal" type="button" class="btn btn-success" name="uploadbtn" id="uploadbtn"><i class='fa fa-check-square-o'></i> Upload Excel</a>
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
														<th width="80">จำนวน</th>
														<th>หน่วย</th>
                                                        <?php if ($remark==1) { ?>
                                                        <th width="200">Caseback No.</th>
                                                        <?php } ?>
														<th>จัดการ</th>
				                                    </tr>
				                                </thead>
												<tbody>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:120%;" class="text-red">
                                                        <th colspan="3" style="text-align:right;"><label>รวม:</th>
                                                        <th><div id="summary"></div></th>
                                                        <th><div id="allcount"></div></th>
                                                        <th></label></th>
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
									<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform(<?php echo $remark; ?>)"><i class='fa fa-save'></i>  บันทึก </button>
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
                    <i class='fa fa-thumbs-up'></i> Import Excel File
                </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
                <form action="<?php echo site_url("warehouse_transfer/upload_excel_import_stock"); ?>" method="post" enctype="multipart/form-data" id="upload_excel">
                <div class="row"><div class="col-md-12"><form class="form-horizontal"><div class="form-group"><label class="col-md-4 control-label" for="donedate_done">เลือกไฟล์</label><div class="col-md-8"> <input type="file" class="form-control" id="excelfile_name" name="excelfile_name" /></div></div></form> </div>  </div>

            </div>            <!-- /modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="upload_excel();">Upload</button>

            </div> 	
            </form>								
        </div>
    </div>
</div>

</div>
<!-- close modal -->  
<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 5000);

var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{    
    get_datepicker("#datein");
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
            
            setTimeout(function(){
                calculate();
            },3000);
		}
	});
    
    $('#watch_fashion').on('click', function(){            
            window.location.replace("<?php echo site_url("warehouse_transfer/importstock/fashion"); ?>");
    });
    
    $('#watch_luxury').on('click', function(){            
            window.location.replace("<?php echo site_url("warehouse_transfer/importstock/luxury"); ?>");
    });

});
function check_product_code(refcode_input, luxury)
{
	if(refcode_input != "")
	{
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
	}
}

function delete_item_row(row1)
{
    count_list--;
    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
    $('#row'+row1).remove();
    setTimeout(function(){
        calculate();
    },50);
}
    
function calculate() {
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
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
    
function alphanumeric(inputtxt)  
{   
    var letters = /^[0-9a-zA-Z]+$/;  
    if(inputtxt.match(letters))  
    {
        return true;  
    }else{  
        return false;  
    }  
}  
    
function submitform(x)
{
    if (document.getElementsByName('it_id').length < 1) {
        alert("กรุณาเลือกสินค้าที่ต้องการรับเข้าคลัง");
    }else if (document.getElementById('whid').value < 0) {
        alert("กรุณาเลือกคลังสินค้า");
        document.getElementById('whid').focus();
    }else if (document.getElementById('datein').value == "") {
        alert("กรุณาเลือกวันที่รับเข้า");
        document.getElementById('datein').focus();
    }else{
        if (x==1) {
            var it_code = document.getElementsByName('it_code');
            var duplicate = 0;
            for(var i=0; i<it_code.length; i++){
                
                if (!alphanumeric(it_code[i].value))
                {
                    alert("กรุณาใส่เฉพาะตัวเลขหรือตัวอักษรเท่านั้นในช่อง Caseback");
                    it_code[i].value = "";
                    return;
                }
                
                for(var j=i+1; j<it_code.length; j++){
                    if (it_code[i].value==it_code[j].value) {
                        it_code[j].value = "";
                        duplicate++;
                    }
                }
            }
            if (duplicate > 0) {
                alert("Caseback ซ้ำกัน");
            }else{
                var r = confirm("ยืนยันการรับสินค้าเข้าคลัง !!");
                if (r == true) {
                    confirmform(x);
                }
            }
        }else{

            var r = confirm("ยืนยันการรับสินค้าเข้าคลัง !!");
            if (r == true) {
                confirmform(x);
            }
        }
    }
}

function confirmform(luxury)
{
    if (luxury==1) {
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
        
        if(it_id.length>0) {
            $.ajax({
                type : "POST" ,
                url : "<?php echo site_url("warehouse_transfer/importstock_save/1"); ?>" ,
                data : {datein: datein, whid: whid, item: it_array} ,
                dataType: 'json',
                success : function(data) {
                    if (data.b == 0) {
                        alert("Caseback ซ้ำกับที่มีอยู่แล้ว");
                        it_code[data.a].value = "";
                        document.getElementById("savebtn").disabled = false;
                    }else{
                        var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว <br><br>คุณต้องการพิมพ์ใบรับเข้าคลัง ใช่หรือไม่";
                        bootbox.confirm(message, function(result) {
                                var currentForm = this;
                                if (result) {
                                    window.open("<?php echo site_url("warehouse_transfer/importstock_serial_print"); ?>"+"/"+data.b, "_blank");
                                    location.reload();
                                }else{
                                    location.reload();
                                }

                        });
                    }

                },
                error: function (textStatus, errorThrown) {
                    alert("เกิดความผิดพลาด !!!");
                    document.getElementById("savebtn").disabled = false;
                }
            });
        }
    }else if (luxury==0){
        var datein = document.getElementById("datein").value;
        var whid = document.getElementById('whid').value;
        var it_id = document.getElementsByName('it_id');
        var it_quantity = document.getElementsByName('it_quantity');
        var it_array = new Array();
        
        for(var i=0; i<it_quantity.length; i++){
            if (it_quantity[i].value % 1 != 0 || it_quantity[i].value == "") {
                alert("กรุณาใส่จำนวนสินค้าที่เป็นตัวเลขเท่านั้น");
                it_quantity[i].value = '';
                return;
            }
            it_array[i] = {id: it_id[i].value, qty: it_quantity[i].value};
        }
        document.getElementById("savebtn").disabled = true;
        
        if(it_id.length>0) {
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
                    document.getElementById("savebtn").disabled = false;

                }
            });
        }
    }
    
}
    
function upload_excel() {
    document.getElementById("upload_excel").submit();
};
    
</script>
</body>
</html>