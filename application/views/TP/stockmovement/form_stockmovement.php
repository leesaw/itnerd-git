<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายการสินค้าส่งซ่อม
        </h1>
    </section>

	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("tp_stockmovement/result_stockmovement"); ?>" name="formfilter" id="formfilter" method="post">
            <div class="col-md-2">
                <div class="form-group">
                Ref. Number
                <input type="text" class="form-control input-sm" name="refcode" id="refcode">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                ยี่ห้อ
                <select id="brandid" name="brandid" class="form-control select2" style="width: 100%;">
                    <option value="0" selected>เลือกทั้งหมด</option>
                    <?php foreach($brand_array as $loop) { ?>
                    <option value="<?php echo $loop->br_id; ?>"><?php echo $loop->br_code."-".$loop->br_name; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    เลือก Warehouse
                    <select id="warehouse" name="warehouse" class="form-control select2" style="width: 100%;" required>
                        <option value="" selected>-- กรุณาเลือก --</option>
                        <?php
                            foreach($whname_array as $loop) {
                        ?>
                        <option value="<?php echo $loop->wh_id; ?>"><?php echo $loop->wh_code."-".$loop->wh_name; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <label for="">เลือกวันที่เริ่มต้น : </label>
                <input type="text" class="form-control input-sm" id="startdate" name="startdate" value="" />
            </div>
            <div class="col-md-2">
                <label for="">สิ้นสุด : </label>
                <input type="text" class="form-control input-sm" id="enddate" name="enddate" value="" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3 col-md-2">
                <button type="submit" name="action" value="0" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> ค้นหา</button>
            </div>
        </div>


        </form>

					</div>
                </div>
            </div>
        </div>

        </section>
		</div>


	</div>


<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    //Initialize Select2 Elements
    $(".select2").select2();
    get_datepicker("#startdate");
    get_datepicker("#enddate");
});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}
</script>
</body>
</html>
