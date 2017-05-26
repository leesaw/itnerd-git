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
            รายงาน-ขอคืนสินค้า
        </h1>
    </section>

	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">

        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading">
                        <h4>รายงานขอคืนสินค้าที่กำลังดำเนินการ</h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่ขอคืนสินค้า</th>
                                        <th>วันที่</th>
										                    <th>คลังเดิม</th>
                                        <th>ผู้ทำรายการ</th>
                                        <th>สถานะ</th>
                                        <th width="80"> </th>
                                    </tr>
                                </thead>

								<tbody>
                                    <?php foreach($request_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->stor_number; ?></td>
                                        <td><?php echo $loop->stor_issue; ?></td>
                                        <td><?php echo $loop->wh_code." - ".$loop->wh_name; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><?php if($loop->stor_status==1) echo "<button class='btn btn-xs btn-danger'>รอยืนยันสินค้า</button>"; ?></td>
                                        <td><a href="<?php echo site_url("tp_stock_return/print_return_request")."/".$loop->stor_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-print"></span></a>
                                        <a href="<?php echo site_url("tp_stock_return/confirm_return_request")."/".$loop->stor_id; ?>" class="btn btn-success btn-xs" data-title="ยืนยันสินค้าที่คืน" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="ยืนยันสินค้าที่คืน"><i class="fa fa-check-square-o"></i></a>
                          
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
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    var oTable = $('#tablebarcode').DataTable();
    var oTable = $('#tablefinal').DataTable();
    $('#fancyboxall').fancybox({
    'width': '40%',
    'height': '70%',
    'autoScale':false,
    'transitionIn':'none',
    'transitionOut':'none',
    'type':'iframe'});

});

function confirm_undo()
{
    bootbox.confirm("ต้องการเข้าสู่รายการ 'ยกเลิกการยืนยันการย้ายคลัง' ใช่หรือไม่ ?", function(result) {
        if(result) {
            window.location = "<?php echo site_url("warehouse_transfer/undo_confirm_transfer_between"); ?>";
        }
    });
}
</script>
</body>
</html>
