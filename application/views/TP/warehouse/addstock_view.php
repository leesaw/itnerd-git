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
                                        ประเภท *
                                        <select class="form-control" name="whid" id="whid">
										<?php 	if(is_array($wh_array)) {
												foreach($wh_array as $loop){
													echo "<option value='".$loop->wh_id."'>".$loop->wh_code."-".$loop->wh_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-sm col-xs-4">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Ref. Code ที่รับเข้าคลัง">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary"><i class='fa fa-search'></i></button>
                                        </div>
                                        </div></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-striped row-border table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>Ref. Code</th>
														<th>ชื่อ</th>
                                                        <th>ยี่ห้อ</th>
                                                        <th>รุ่น</th>
														<th width="80">จำนวน</th>
														<th>หน่วย</th>
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
									<button type="button" class="btn btn-success" onClick="submitform();"><i class='fa fa-save'></i>  บันทึก </button>
							</div>
						</div>
						</form>

					</div>
				</div>
			</div>	
            </div></section>
	</div>
</div>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<?php $this->load->view('js_footer'); ?>
<script type="text/javascript">
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 5000);

var count_enter_form_input_product = 0;

$(document).ready(function()
{    
    get_datepicker("#datein");
    
    $('#refcode').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            var product_code_value = $.trim($(this).val());
            if(product_code_value != "")
			{
                check_product_code(product_code_value);
                
			}
            $(this).val('');
		}
	});

});
function check_product_code(refcode_input)
{
	if(refcode_input != "")
	{
		$.ajax({
			type : "POST" ,
			url : "<?php echo site_url("item/getRefcode"); ?>" ,
			data : {refcode: refcode_input} ,
			success : function(data) {
				if(data != "")
				{
                    var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                    $('table tbody').append(element);
                    count_enter_form_input_product++;
                }else{
                	alert("ไม่พบ Ref. Code ที่ต้องการ");
                }
			}
		});
	}
}

function delete_item_row(row1)
{
    $('#row'+row1).remove();
}
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}

function submitform()
{
	document.getElementById("form1").submit();
}
</script>
</body>
</html>