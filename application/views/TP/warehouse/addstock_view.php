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
            
            <h1>สินค้าเข้า</h1>
        </section>
	
	<section class="content">
		<div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
					<?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                    <div class="form-group">
                                    	<a href="<?php echo site_url("managestock/addstockfrombarcode"); ?>" class="btn btn-success btn-lg btn-block">เริ่มสแกน Barcode สินค้าเข้าสต็อก</a>
                                    </div>
							</div>
						</div>
								
									

					</div>
				</div>
			</div>	
	</section>
	</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>