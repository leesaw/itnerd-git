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

            <h1>พิมพ์ป้ายราคา</h1>
        </section>

		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong class="text-red">* จำเป็นต้องตั้งขนาดกระดาษเป็น 110.00mm * 19.00 mm</strong></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="radio" name="watch_fashion" id="watch_fashion" value="1" <?php if(($remark=='0') || (!isset($remark))) echo "checked"; ?>> <label class="text-green"> No Caseback</label>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              <input type="radio" name="watch_luxury" id="watch_luxury" value="1" <?php if ($remark=='1') echo "checked"; ?>> <label class="text-red"> Caseback</label>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading">
                                        <div class="input-group input-group-sm col-md-8">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="<?php if($remark==0) echo "Ref. Code ที่ต้องการ"; else echo "Caseback No. ที่ต้องการ"; ?>">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary"><i class='fa fa-search'></i></button>
                                            <a data-toggle="modal" data-target="#myModal" type="button" class="btn btn-success" name="uploadbtn" id="uploadbtn"><i class='fa fa-upload'></i> นำเข้า Excel</a>
                                            <a href="<?php if ($remark=='0') echo base_url()."uploads/excel/ตัวอย่างไฟล์นำเข้า_fashion.xlsx"; else echo base_url()."uploads/excel/ตัวอย่างไฟล์นำเข้า_only_caseback.xlsx"; ?>" type="button" class="btn bg-purple btn-sm"><i class='fa fa-file-excel-o'></i> ตัวอย่าง Excel</a>
                                        </div> <label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label>



                                        </div>
                                    </div>
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
							<div class="col-md-12">
                                    <button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="printrefcode(<?php echo $remark; ?>)"><i class='fa fa-print'></i>  พิมพ์ป้ายราคา QR แบบ Refcode </button>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
																		<button type="button" class="btn btn-primary" name="savebtn" id="savebtn" onclick="printean(<?php echo $remark; ?>)"><i class='fa fa-print'></i>  พิมพ์ป้ายราคาแบบ EAN </button>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    <?php if ($remark ==1) { ?>

                                    <button type="button" class="btn bg-orange" name="savebtn" id="savebtn" onclick="printcaseback(<?php echo $remark; ?>)"><i class='fa fa-print'></i>  พิมพ์ป้ายราคาแบบ Caseback </button>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
																		<button type="button" class="btn bg-purple" name="savebtn" id="savebtn" onclick="printrolex(<?php echo $remark; ?>)"><i class='fa fa-print'></i>  พิมพ์ป้ายราคา Rolex </button>
                                    <?php  } ?>

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
                    <i class='fa fa-upload'></i> นำเข้า Excel
                </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
                <form action="<?php echo site_url("warehouse_transfer/upload_excel_import_stock"); ?>" method="post" enctype="multipart/form-data" id="form_uploadexcel" class="form-horizontal">
                <div class="row"><div class="col-md-12"><div class="form-group"><label class="col-md-4 control-label" for="donedate_done">เลือกไฟล์</label><div class="col-md-8"> <input type="file" class="form-control" id="excelfile_name" name="excelfile_name" /></div></div></form> </div>  </div>

            </div>            <!-- /modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="upload_excel();">Upload</button>

            </div>

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
            window.location.replace("<?php echo site_url("item/form_print_tag/fashion"); ?>");
    });

    $('#watch_luxury').on('click', function(){
            window.location.replace("<?php echo site_url("item/form_print_tag/luxury"); ?>");
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
                url : "<?php echo site_url("item/getCaseback_lockCaseback"); ?>" ,
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
                        alert("ไม่พบ Caseback ที่ต้องการ");
                    }
                }
            });
        }
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

function printean(x)
{
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
            confirmean(x);
        }
    }else{
			var it_code = document.getElementsByName('it_id');
	    var it_quantity = document.getElementsByName('it_quantity');
	    for(var i=0; i<it_code.length; i++){
	        if (it_quantity[i].value % 1 !== 0)
	        {
	            alert("กรุณาใส่เฉพาะตัวเลขเท่านั้นในช่อง จำนวน");
	            it_quantity[i].value = "";
	            return;
	        }

	    }

			console.log("ean");
      confirmean(x);
    }

}

function printrefcode(x)
{
    var it_code = document.getElementsByName('it_id');
    var it_quantity = document.getElementsByName('it_quantity');
    for(var i=0; i<it_code.length; i++){
        if (it_quantity[i].value % 1 !== 0)
        {
            alert("กรุณาใส่เฉพาะตัวเลขเท่านั้นในช่อง จำนวน");
            it_quantity[i].value = "";
            return;
        }

    }

    confirmrefcode(x);


}

function printcaseback(x)
{
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
            confirmcaseback(x);
        }
    }else{
        confirmcaseback(x);
    }

}

function printrolex(x)
{
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
            confirmrolex(x);
        }
    }else{
        confirmrolex(x);
    }

}

function confirmean(luxury)
{

    if (luxury==1) {
        var it_id = document.getElementsByName('it_id');
        var it_code = document.getElementsByName('it_code');
        var input_form = "";

        for(var i=0; i<it_code.length; i++){
            if (it_code[i].value == "") {
                alert("กรุณาใส่ Cashback No. ให้ครบทุกช่อง");
                return;
            }
            input_form += "<input type='hidden' name='caseback[]' value='"+it_code[i].value+"'>";
        }
        var url = '<?php echo site_url("item/result_print_tag_ean"); ?>';
        var form3 = $('<form action="'+url+'" method="post" target="_blank">'+input_form+'</form>');

        $('body').append(form3);

        form3.submit();


    }else{
			var it_id = document.getElementsByName('it_id');
	    var it_quantity = document.getElementsByName('it_quantity');
	    var input_form = "";

	    for(var i=0; i<it_id.length; i++){
	        input_form += "<input type='hidden' name='it_id[]' value='"+it_id[i].value+"'><input type='hidden' name='it_qty[]' value='"+it_quantity[i].value+"'>";
	    }

	    var url = '<?php echo site_url("item/result_print_tag_ean_refcode"); ?>';
	    var form3 = $('<form action="'+url+'" method="post" target="_blank">'+input_form+'</form>');

	    $('body').append(form3);

	    form3.submit();
		}

}

function confirmrefcode(luxury)
{

    var it_id = document.getElementsByName('it_id');
    var it_quantity = document.getElementsByName('it_quantity');
    var input_form = "";

    for(var i=0; i<it_id.length; i++){
        input_form += "<input type='hidden' name='it_id[]' value='"+it_id[i].value+"'><input type='hidden' name='it_qty[]' value='"+it_quantity[i].value+"'>";
    }

    var url = '<?php echo site_url("item/result_print_tag_refcode"); ?>';
    var form3 = $('<form action="'+url+'" method="post" target="_blank">'+input_form+'</form>');

    $('body').append(form3);

    form3.submit();

}

function confirmcaseback(luxury)
{

    if (luxury==1) {
        var it_id = document.getElementsByName('it_id');
        var it_code = document.getElementsByName('it_code');
        var input_form = "";

        for(var i=0; i<it_code.length; i++){
            if (it_code[i].value == "") {
                alert("กรุณาใส่ Cashback No. ให้ครบทุกช่อง");
                return;
            }
            input_form += "<input type='hidden' name='caseback[]' value='"+it_code[i].value+"'>";
        }
        var url = '<?php echo site_url("item/result_print_tag_caseback"); ?>';
        var form3 = $('<form action="'+url+'" method="post" target="_blank">'+input_form+'</form>');

        $('body').append(form3);

        form3.submit();


    }

}

function confirmrolex(luxury)
{

    if (luxury==1) {
        var it_id = document.getElementsByName('it_id');
        var it_code = document.getElementsByName('it_code');
        var input_form = "";

        for(var i=0; i<it_code.length; i++){
            if (it_code[i].value == "") {
                alert("กรุณาใส่ Cashback No. ให้ครบทุกช่อง");
                return;
            }
            input_form += "<input type='hidden' name='caseback[]' value='"+it_code[i].value+"'>";
        }
        var url = '<?php echo site_url("item/result_print_tag_rolex"); ?>';
        var form3 = $('<form action="'+url+'" method="post" target="_blank">'+input_form+'</form>');

        $('body').append(form3);

        form3.submit();


    }

}

function upload_excel() {
    var fileSelect = document.getElementById('excelfile_name');
    var files = fileSelect.files;
    var formData = new FormData();

    if (files[0] != 'undefined') {
        formData.append("excelfile_name", files[0]);

        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("item/upload_excel_item")."/".$remark; ?>" ,
            data : formData ,
            processData : false,
            contentType : false,
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

                    var message = "ทำการนำเข้าข้อมูลเรียบร้อยแล้ว";
                    bootbox.alert(message, function() {
                        $('#myModal').modal('hide');
                    });

                }else{
                	alert("ไม่พบ Ref. Code ที่ต้องการ");
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
};

</script>
</body>
</html>
