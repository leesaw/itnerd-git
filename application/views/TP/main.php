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
            NGG | Nerd <small>Timepieces</small>
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <i class="fa fa-warning"></i>

                      <h3 class="box-title">NERD version 1.3 noted</h3>
                    </div>
                    <div class="box-body">
                        <ul>
                            <li>เจ้าหน้าที่ดูแลคลังสามารถย้ายสินค้าเฉพาะในคลังโปรและคลัง Head Office มายังคลัง Head Office ได้เอง</li>
                            <li>สามารถเลือก Ref. Number ทั้งหมดในคลังที่ต้องการย้ายคลัง โดยการคลิกปุ่ม "เลือกสินค้าทั้งหมด"</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <i class="fa fa-warning"></i>

                      <h3 class="box-title">NERD version 1.2 noted</h3>
                    </div>
                    <div class="box-body">
                        <ul>
                            <li>เพิ่มเมนู "รายงาน-การขาย" สำหรับ Sale และ Accounting สำหรับเรียกดูรายงานการขาย โดยสามารถ Filter ตาม Ref. Number, Brand, Shop และเฉพาะช่วงวันที่ รวมทั้งสามารถ Export เป็น Excel ได้</li>
                            <li>สามารถค้นหาสินค้าที่มีการย้ายคลังได้</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.barnumbers.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script src="<?php echo base_url(); ?>js/spin.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{

});

</script>
</body>
</html>