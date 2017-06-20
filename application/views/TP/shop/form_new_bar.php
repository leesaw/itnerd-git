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

            <h1>เพิ่มข้อมูล Bar ห้าง</h1>
        </section>

		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>';
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';

					?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่องที่มี *</strong></div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <form name="form1" id="form1" action="<?php echo site_url('shop/save_new_bar'); ?>" method="post">
                                    <div class="form-group">
                                            Bar *
                                            <input type="text" class="form-control" name="sbnumber" id="sbnumber" value="<?php echo set_value('sbnumber'); ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                            ชื่อ Bar *
                                            <input type="text" class="form-control" name="sbname" id="sbname" value="<?php echo set_value('sbname'); ?>">
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                        Shop Group *
                                        <select class="form-control" name="sgid" id="sgid">
										<?php 	if(is_array($group_array)) {
												foreach($group_array as $loop){
													echo "<option value='".$loop->sg_id."'>".$loop->sg_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
              <div class="col-md-3">
									<div class="form-group">
                                        ยี่ห้อ *
                                        <select class="form-control" name="brid" id="brid">
										<?php 	if(is_array($brand_array)) {
												foreach($brand_array as $loop){
													echo "<option value='".$loop->br_id."'>".$loop->br_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
									<div class="form-group">
                    ส่วนลด % *
                    <input type="text" class="form-control" name="dc" id="dc" value="<?php echo set_value('dc'); ?>">
                    <p class="help-block"><?php echo form_error('dc'); ?></p>
                  </div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									GP % *
									<input type="text" class="form-control" name="gp" id="gp" value="<?php echo set_value('gp'); ?>">
									<p class="help-block"><?php echo form_error('gp'); ?></p>
								</div>
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-md-6">
									<button type="button" name="savebtn" id="savebtn"  class="btn btn-primary" onclick="disablebutton()">  บันทึก </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("shop/bar_manage"); ?>'"> ยกเลิก </button>
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
<?php $this->load->view('js_footer'); ?>
<script>
$(document).ready(function()
{
    //document.getElementById("savebtn").disabled = false;
    $(".select2").select2();
});
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 5000);

function autobarcode(obj) {
	var input=$(obj).val();
	$('#barcode').val(input);
}
function disablebutton() {
    if (document.getElementById('sbnumber').value == "") {
      alert("กรุณาใส่รหัส Bar");
      document.getElementById('sbnumber').focus();
    }else if (document.getElementById('sbname').value == "") {
      alert("กรุณาใส่ชื่อ Bar");
      document.getElementById('sbname').focus();
    }else if (document.getElementById('sgid').value < 0) {
      alert("กรุณาเลือก Shop Group");
      document.getElementById('sgid').focus();
    }else if (document.getElementById('brid').value < 0) {
      alert("กรุณาเลือกยี่ห้อ");
      document.getElementById('brid').focus();
    }else if (document.getElementById('dc').value == "") {
      alert("กรุณาใส่ส่วนลด %");
      document.getElementById('dc').focus();
    }else if (document.getElementById('gp').value == "") {
      alert("กรุณาใส่ GP %");
      document.getElementById('gp').focus();
    }else{
      document.getElementById("savebtn").disabled = true;
      document.getElementById("form1").submit();
    }
}
</script>
</body>
</html>
