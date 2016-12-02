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
            ประวัติการเอาสินค้าออกจากคลัง
        </h1>
    </section>

	<section class="content">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-primary">

        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("warehouse_transfer/result_search_transfer_out_item"); ?>" name="formfilter" id="formfilter" method="post">
            <div class="col-md-4">
                <label>Ref. Number หรือ Description ที่ต้องการค้นหา</label>
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
            <div class="col-md-2">
                <div class="form-group">
                    เลือกยี่ห้อ

                    <select id="brand" name="brand" class="form-control select2" style="width: 100%;">
                        <option value="0-ทั้งหมด" selected>เลือกทั้งหมด</option>
                        <?php foreach($brand_array as $loop) { ?>
                        <option value="<?php echo $loop->br_id."-".$loop->br_name; ?>"><?php echo $loop->br_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    เลือก Warehouse

                    <select id="warehouse" name="warehouse" class="form-control select2" style="width: 100%;">
                        <option value="0-ทั้งหมด" selected>เลือกทั้งหมด</option>
                        <?php
                            foreach($whname_array as $loop) {
                        ?>
                        <option value="<?php echo $loop->wh_id."-".$loop->wh_name; ?>"><?php echo $loop->wh_code."-".$loop->wh_name; ?>
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
                <div class="col-md-6">
                    <form action="<?php echo site_url("warehouse_transfer/out_stock_history"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
                        <div class="form-group-sm">
                                <label class="col-sm-2 control-label">เลือกเดือน</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $currentdate; ?>" onChange="submitform();" autocomplete="off" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-danger">
					<div class="panel-heading">
                        <h4>รายการสินค้าออกจากคลังของเดือน <?php echo $month; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่</th>
                                        <th>วันที่</th>
										<th>ออกจากคลัง</th>
                                        <th>ผู้ทำรายการ</th>
                                        <th> </th>
                                    </tr>
                                </thead>

								<tbody>
                                    <?php foreach($final_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->stoo_number; ?></td>
                                        <td><?php echo $loop->stoo_datein; ?></td>
                                        <td><?php echo $loop->wh_code."-".$loop->wh_name; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><a href="<?php if($loop->stoo_has_serial==0) echo site_url("warehouse_transfer/out_stock_final_print")."/".$loop->stoo_id; else echo site_url("warehouse_transfer/out_stock_final_print")."/".$loop->stoo_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-print"></span></a>
                                        <a href="<?php if($loop->stoo_has_serial==0) echo site_url("warehouse_transfer/out_stock_final_excel")."/".$loop->stoo_id; else echo site_url("warehouse_transfer/out_stock_final_excel")."/".$loop->stoo_id; ?>" class="btn bg-maroon btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="Excel"><i class="fa fa-download"></i></a>
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

    get_datepicker_month("#datein");

    var oTable = $('#tablefinal').DataTable();
    $('#fancyboxall').fancybox({
    'width': '40%',
    'height': '70%',
    'autoScale':false,
    'transitionIn':'none',
    'transitionOut':'none',
    'type':'iframe'});

});

function get_datepicker_month(id)
{
    $(id).datepicker({ language:'th-th',format: "mm/yyyy", viewMode: "months",
    minViewMode: "months" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}

function submitform()
{
    document.getElementById("form1").submit();
}
</script>
</body>
</html>
