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
                    <?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("sale/saleorder_select_item"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่ขาย
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $currentdate; ?>">
                                    </div>
							</div>
                            <div class="col-md-4">
									<div class="form-group-sm">
                                        สาขาที่ขาย *
                                        <select class="form-control select2" name="shopid" id="shopid" style="width: 100%;">
                                            <option value='-1'>-- เลือกสาขา --</option>
										<?php 	if(is_array($shop_array)) {
												foreach($shop_array as $loop){
													echo "<option value='".$loop->sh_id."#".$loop->sh_code."-".$loop->sh_name."'>".$loop->sh_code."-".$loop->sh_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
                            <div class="col-md-4">
                                <input type="radio" name="caseback" id="caseback" value="0" checked> <label class="text-green"> No Caseback</label>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              <input type="radio" name="caseback" id="caseback" value="1"> <label class="text-red"> Caseback</label>
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
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    //Initialize Select2 Elements
    $(".select2").select2();
    
    get_datepicker("#datein");

});
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

function submitform()
{
    if (document.getElementById('shopid').value < 0) {
        alert("กรุณาเลือกสาขา");
        document.getElementById('shopid').focus();
    }else if (document.getElementById('datein').value == "") {
        alert("กรุณาเลือกวันที่ขาย");
        document.getElementById('datein').focus();
    }else{
        document.getElementById("form1").submit();
    }
    
}
    
</script>
</body>
</html>