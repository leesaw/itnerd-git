<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('NGG/gold/header_view'); ?>
</head>

<body class="hold-transition skin-red layout-top-nav">
<div class="wrapper">
	<?php $this->load->view('NGG/gold/menu'); ?>
	
<div class="content-wrapper">
    <div class="container">
	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <?php if ($this->session->flashdata('showresult') == 'success') {
						echo '<div class="box-heading"><div class="alert alert-success"> ระบบทำการเปลี่ยนรหัสผ่านเรียบร้อยแล้ว</div>'; 
						?> <button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("ngg_gold/main"); ?>'"> กลับไปหน้าแรก </button></div> <?php
					  } else if ($this->session->flashdata('showresult') == 'fail') {
					    echo '<div class="box-heading"><div class="alert alert-danger"> ระบบไม่สามารถเปลี่ยนรหัสผ่านได้</div>';
						?> <button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("ngg_gold/main"); ?>'"> กลับไปหน้าแรก </button></div> <?php
					  } else { 
				?>
					<div class="box-heading"><h4 class="box-title">* กรุณาใส่ข้อมูลให้ครบทุกช่อง</h4></div>
					
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo form_open('ngg_gold/updatepass'); ?>
								<?php if ($this->session->flashdata('showresult') == 'failpass') {
										echo '<div class="alert-message alert alert-danger"> รหัสผ่านไม่ถูกต้อง</div>'; }
								?> 
                                    <div class="form-group">
											<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                            <label>Old Password *</label>
                                            <input type="password" class="form-control" name="opassword" id="opassword">
											<p class="help-block"><?php echo form_error('opassword'); ?></p>
                                    </div>
									<div class="form-group">
                                            <label>New Password *</label>
                                            <input type="password" class="form-control" name="npassword" id="npassword">
											<p class="help-block"><?php echo form_error('npassword'); ?></p>
                                    </div>
									<div class="form-group">
                                            <label>Confirm Password *</label>
                                            <input type="password" class="form-control" name="passconf" id="passconf">
											<p class="help-block"><?php echo form_error('passconf'); ?></p>
                                    </div>

							</div>
						</div>
					</div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">  เปลี่ยนรหัสผ่าน  </button>
				        <button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("ngg_gold/main"); ?>'"> ยกเลิก </button>
                    </div>
				<?php } ?>
                </div>
            </div>
        </div>
    </section>
    </div>
</div>

<?php $this->load->view('js_footer'); ?>
<script type="text/javascript">
$(document).ready(function()
{

});

</script>
</body>
</html>