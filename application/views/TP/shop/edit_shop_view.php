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

            <h1>แก้ไขข้อมูลสาขา</h1>
        </section>

<?php
foreach ($sh_array as $loop) {
  $sh_id = $loop->sh_id;
  $sh_name = $loop->sh_name;
  $sh_code = $loop->sh_code;
  $sh_group = $loop->sh_group_id;
  $sh_category = $loop->sh_category_id;
  $wh_id = $loop->sh_warehouse_id;
}


?>

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
                                <form name="form1" id="form1" action="<?php echo site_url('shop/edit_shop_save'); ?>" method="post">
                                  <input type="hidden" name="shid" value="<?php echo $sh_id; ?>"/>
                                    <div class="form-group">
                                            Shop Name *
                                            <input type="text" class="form-control" name="shname" id="shname" value="<?php echo $sh_name; ?>">
											<p class="help-block"><?php echo form_error('shname'); ?></p>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                            Shop Code *
                                            <input type="text" class="form-control" name="shcode" id="shcode" value="<?php echo $sh_code; ?>">
											<p class="help-block"><?php echo form_error('shcode'); ?></p>
                                    </div>
							</div>
							<div class="col-md-3">
									<div class="form-group">
                                        Shop Group *
                                        <select class="form-control" name="sgid" id="sgid">
										<?php 	if(is_array($group_array)) {
												foreach($group_array as $loop){
													echo "<option value='".$loop->sg_id."'";
                          if($loop->sg_id==$sh_group) echo " selected";
                          echo ">".$loop->sg_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
              <div class="col-md-3">
									<div class="form-group">
                                        Shop Category *
                                        <select class="form-control" name="scid" id="scid">
										<?php 	if(is_array($category_array)) {
												foreach($category_array as $loop){
													echo "<option value='".$loop->sc_id."'";
                          if($loop->sc_id==$sh_category) echo " selected";
                          echo ">".$loop->sc_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
										เชื่อมต่อคลังสินค้า
                    <select class="form-control select2" name="whid" id="whid" style="width: 100%;">
                        <option value='-1'>-- เลือกคลังสินค้า --</option>
                        <?php 	if(is_array($wh_array)) {
                            foreach($wh_array as $loop){
                              echo "<option value='".$loop->wh_id."'";
                              if($loop->wh_id==$wh_id) echo " selected";
                              echo ">".$loop->wh_code."-".$loop->wh_name."</option>";
                         } } ?>
                    </select>
								</div>
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-md-6">
									<button type="button" name="savebtn" id="savebtn"  class="btn btn-primary" onclick="disablebutton()">  บันทึก </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("shop/manage"); ?>'"> ยกเลิก </button>
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


    if (document.getElementById('whid').value < 0) {
        alert("กรุณาเลือกคลังสินค้า");
        document.getElementById('whid').focus();
    }else{
      document.getElementById("savebtn").disabled = true;
      document.getElementById("form1").submit();
    }
}
</script>
</body>
</html>
