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
                    <?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("warehouse_transfer/transferstock_select_item"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่ย้ายคลัง
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $currentdate; ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        ออกจากคลัง *
                                        <select class="form-control" name="whid_out" id="whid_out">
                                            <option value='-1'>-- เลือกคลังสินค้า --</option>
										<?php 	if(is_array($wh_array)) {
												foreach($wh_array as $loop){
													echo "<option value='".$loop->wh_id."#".$loop->wh_code."-".$loop->wh_name."'>".$loop->wh_code."-".$loop->wh_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
                            <div class="col-md-1">
                                <br><center><i class="fa fa-arrow-right"></i></center>
                            </div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        เข้าคลัง *
                                        <select class="form-control" name="whid_in" id="whid_in">
                                            <option value='-1'>-- เลือกคลังสินค้า --</option>
										<?php 	if(is_array($wh_array)) {
												foreach($wh_array as $loop){
													echo "<option value='".$loop->wh_id."#".$loop->wh_code."-".$loop->wh_name."'>".$loop->wh_code."-".$loop->wh_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
						</div>
                        <br>
                        <div name="submit1" class="row">
							<div class="col-md-6">
									<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-share'></i>  เลือกสินค้า </button>
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
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    get_datepicker("#datein");

});
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

function submitform()
{
    if (document.getElementById('whid_out').value < 0) {
        alert("กรุณาเลือกคลังสินค้า");
        document.getElementById('whid_out').focus();
    }else if (document.getElementById('whid_in').value < 0) {
        alert("กรุณาเลือกคลังสินค้า");
        document.getElementById('whid_in').focus();
    }else if (document.getElementById('datein').value == "") {
        alert("กรุณาเลือกวันที่รับเข้า");
        document.getElementById('datein').focus();
    }else if (document.getElementById('whid_out').value == document.getElementById('whid_in').value) {
        alert("ไม่สามารถย้ายคลังเดียวกันได้");
        document.getElementById('whid_out').focus();
    }else{
        document.getElementById("form1").submit();
    }
    
}
    
</script>
</body>
</html>