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
            POS -> ใบกำกับภาษีแบบเต็ม
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
            <div class="col-md-10">
                <div class="box box-success">

        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("pos_invoice/result_view_full_invoice"); ?>" method="post">
            <div class="col-md-4">
                Ref. Number ที่ต้องการค้นหา
                <div class="input-group">
                    <input type="text" class="form-control" name="refcode" id="refcode">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success"><i class='fa fa-search'></i></button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    เลือกยี่ห้อ

                    <select id="brand" name="brand" class="form-control select2" style="width: 100%;">
                        <option value="0-ทั้งหมด" selected>เลือกทั้งหมด</option>
                        <?php foreach($brand_array as $loop) { if ($loop->br_name =="สินค้าซ่อม") continue; ?>
                        <option value="<?php echo $loop->br_id."-".$loop->br_name; ?>"><?php echo $loop->br_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group-sm">
                    เลือก Shop
                    <select id="shop" name="shop" class="form-control select2" style="width: 100%;">
                        <option value="0-ทั้งหมด" selected>เลือกทั้งหมด</option>
                        <?php
                            foreach($shop_array as $loop) {
                        ?>
                        <option value="<?php echo $loop->posh_id."-".$loop->posh_name; ?>"><?php echo $loop->posh_name; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                เลือกวันที่เริ่มต้น :
                <input type="text" class="form-control" id="startdate" name="startdate" value="" />
            </div>
            <div class="col-md-2">
                สิ้นสุด :
                <input type="text" class="form-control" id="enddate" name="enddate" value="" />
            </div>
        </div>
        <br>
            <div class="row"><div class="col-md-3"><button type="submit" name="action" value="0" class="btn btn-success"><i class="fa fa-search"></i> ค้นหา</button></div></div>

        </form>

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
    //Initialize Select2 Elements
    $(".select2").select2();

    get_datepicker("#startdate");
    get_datepicker("#enddate");
    get_datepicker("#startdate_count");
    get_datepicker("#enddate_count");

    $('#fancyboxall').fancybox({
    'width': '40%',
    'height': '70%',
    'autoScale':false,
    'transitionIn':'none',
    'transitionOut':'none',
    'type':'iframe'});
});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}
</script>
</body>
</html>
