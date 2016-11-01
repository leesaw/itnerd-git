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
            รายการสินค้ายืม
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
            <div class="col-md-10">
                <div class="box box-danger">

        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("pos/get_borrow_item"); ?>" method="post">
            <div class="col-xs-8 col-md-4">
                เลือกผู้ยืม
                <div class="input-group">
                    <select class="form-control" name="borrower" id="borrower">
                        <option value="-1">--- เลือกชื่อผู้รับของ ---</option>
                <?php foreach($borrower_array as $loop) { ?>
                <option value="<?php echo $loop->posbor_name; ?>"><?php echo $loop->posbor_name; ?></option>
                <?php } ?>

                    </select>
                </div>
            </div>

        </div>
        <br>
            <div class="row"><div class="col-md-3"><button type="submit" name="action" value="0" class="btn btn-success"><i class="fa fa-search"></i> ค้นหา</button></div>
						<div class="col-md-3">
							<a href="<?php echo site_url("pos/stock_rolex_borrow_excel"); ?>" target="_blank"><button type="button" class="btn btn-primary" name="btnExcel" id="btnExcel"><i class='fa fa-download'></i> Excel รายการสินค้ายืม</button></a>
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
<script type="text/javascript">

$(document).ready(function()
{
    get_datepicker("#startdate");
    get_datepicker("#enddate");

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
