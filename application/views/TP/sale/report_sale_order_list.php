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
            ประวัติการสั่งขาย
        </h1>
    </section>

	<section class="content">
            <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                <div class="box-body">
                <div class="row">
                    <form action="<?php echo site_url("sale/saleorder_history"); ?>" name="formfilter" id="formfilter" method="post">
                    <div class="col-md-2">
                        Ref. Number ที่ต้องการค้นหา
                        <div class="input-group">
                            <input type="text" class="form-control" name="refcode" id="refcode" value="<?php echo $refcode; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        เลือกเดือน
                        <div class="input-group">
                        <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $month; ?>" autocomplete="off" readonly></div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            เลือกยี่ห้อ

                            <select id="brand" name="brand" class="form-control select2" style="width: 100%;">
                                <option value="0-ทั้งหมด" selected>เลือกทั้งหมด</option>
                                <?php foreach($brand_array as $loop) { ?>
                                <option value="<?php echo $loop->br_id; ?>"<?php if($loop->br_id == $brand_id) echo " selected"; ?>><?php echo $loop->br_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            เลือก Shop

                            <select id="shop" name="shop" class="form-control select2" style="width: 100%;">
                                <option value="0-ทั้งหมด" selected>เลือกทั้งหมด</option>
                                <?php
                                    foreach($shop_array as $loop) {
                                ?>
                                <option value="<?php echo $loop->sh_id; ?>"<?php if($loop->sh_id == $shop_id) echo " selected"; ?>><?php echo $loop->sh_code."-".$loop->sh_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <div class="col-md-3"><button type="submit" name="action" value="0" class="btn btn-success"><i class="fa fa-search"></i> ค้นหา</button></div>
                    </div>
                </div>


                </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">
            <div class="row">
			<div class="col-xs-12">
					<!-- <div class="panel-heading">
                        <h4>รายการใบสั่งขายของเดือน <?php echo $month; ?></h4>
                    </div>
                    -->
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่ใบสั่งขาย</th>
                                        <th>วันที่ขาย</th>
                                        <th>สาขาที่ขาย</th>
                                        <th>ผู้ทำรายการ</th>
                                        <th>วันเวลาทำรายการ</th>
                                        <th> </th>
                                    </tr>
                                </thead>

								<tbody>
                                    <?php foreach($final_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->so_number; ?></td>
                                        <td><?php echo $loop->so_issuedate; ?></td>
                                        <td><?php echo $loop->sh_code."-".$loop->sh_name; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><?php echo $loop->so_dateadd; ?></td>
                                        <td><a href="<?php echo site_url("sale/saleorder_print")."/".$loop->so_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-print"></span></a>
																				<?php if ($user_status == 1) { ?>
																					<a href="<?php echo site_url("sale/view_saleorder")."/".$loop->so_id; ?>" class="btn btn-danger btn-xs" data-title="ดูรายละเอียด" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><i class="fa fa-search"></i></a>
																				<?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
								</tbody>
							</table>

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
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    $(".select2").select2();
    get_datepicker("#datein");

    var oTable = $('#tablefinal').DataTable();
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
    $(id).datepicker({ language:'th-th',format: "mm/yyyy", viewMode: "months",
    minViewMode: "months" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

function submitform()
{
    document.getElementById("form1").submit();
}
</script>
</body>
</html>
