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
                    <div class="box_heading"><h1 class="box-title">ระบบจัดการร้าน NGG | สาขา <span class="text-blue"><?php foreach($shop_array as $loop) echo $loop->sh_name; ?> </span></h1></div>
                    <div class="box-body">

                    <hr>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <a href="<?php echo site_url("ngg_gold/form_warranty"); ?>"><button type="button" class="btn btn-primary btn-lg btn-block"><h4>ออกบัตรรับประกันสินค้า (ทอง)</h4></button></a>
                            </div>
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
<script type="text/javascript">
$(document).ready(function()
{

});

</script>
</body>
</html>