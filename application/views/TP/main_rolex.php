<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            NGG | Rolex <?php if ($sessstatus ==8) echo "POS"; ?> <small>Current version 0.1.0</small>
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
        <?php if ($sessstatus ==8) { ?>
            <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
					<div class="box-heading"><h4 class="box-title"> </h4></div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("sale/saleorder_POS"); ?>"><button type="button" class="btn btn-success btn-lg btn-block"><h4>ออกใบกำกับภาษี / ใบส่งสินค้า / ใบเสร็จรับเงิน</h4></button></a>
                                </div>
                            </div>
						</div>
					</div>
                    <div class="box-footer">
                        
                    </div>
                </div>
        <?php } ?>
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