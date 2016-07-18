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
        <h1>ระบบจัดการร้าน NGG | <span class="text-blue">รายงาน (Report)</span></h1>
        <div class="row">
            <div class="col-md-3">
                <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">เลือกรายงาน</h3>
                    </div>
                    <div class="box-body no-padding">
                      <ul class="nav nav-pills nav-stacked">
                        <li><a href="<?php echo site_url("ngg_gold/form_report_evaluate_sale"); ?>"><i class="fa fa-circle-o"></i> ประเมินและเป้าหมายการขาย</a></li>
                      </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                  <!-- /. box -->
            </div>
        </div>

    </section>
    </div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="plugins/chartjs/Chart.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{

});

</script>
</body>
</html>