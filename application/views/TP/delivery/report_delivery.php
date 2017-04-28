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
            รายงาน - ส่งของ
        </h1>
    </section>

	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="<?php echo site_url("tp_delivery/report_delivery"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
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
                <div class="panel panel-success">
					<div class="panel-heading">
                        <h4>รายการส่งของเดือน <?php echo $month; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่ย้ายคลังสินค้า</th>
                                        <th>วันที่กำหนดส่ง</th>
                                        <th>ออกจากคลัง</th>
										                    <th>เข้าคลัง</th>
																				<th width="200">หมายเหตุ</th>
                                        <th>สถานะการส่ง</th>
                                        <th width="80">ใบย้ายคลังสินค้า</th>
                                    </tr>
                                </thead>

								<tbody>
                                    <?php for($i=0; $i<count($final_array); $i++) { ?>
                                    <tr>
                                        <td><?php echo $final_array[$i]['stot_number']."<br><div class='text-blue'>".$final_array[$i]['brand']." "."</div>"; ?></td>
                                        <td><?php echo $final_array[$i]['stot_datein']; ?></td>
                                        <td><?php echo $final_array[$i]['wh_out']; ?></td>
                                        <td><?php echo $final_array[$i]['wh_in']; ?></td>
																				<td><?php echo $final_array[$i]['delivery_remark']; ?></td>
                                        <td><?php if($final_array[$i]['delivery_status']==1) { echo "<button class='btn btn-xs btn-danger'>รอส่งของ</button>"; }
                                        else { echo "<button class='btn btn-xs btn-success'>สินค้าถูกส่งแล้ว</button>"; } ?>
                                        </td>
                                        <td>
                                        <a href="<?php echo site_url("warehouse_transfer/transferstock_final_print")."/".$final_array[$i]['stot_id']; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-print"></span></a>
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
