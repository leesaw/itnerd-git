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
            ประวัติคืนสินค้า
        </h1>
    </section>

	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="<?php echo site_url("tp_stock_return/list_return"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
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
                        <h4>รายการคืนสินค้าของเดือน <?php echo $month; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                              <thead>
                                  <tr>
                                      <th>เลขที่ขอคืนสินค้า</th>
                                      <th>วันที่</th>
                                      <th>เลขที่ใบสั่งขาย</th>
                                      <th>ผู้ขอคืนสินค้า</th>
                                      <th>สถานะ</th>
                                      <th width="80"> </th>
                                  </tr>
                              </thead>

                              <tbody>
                                  <?php foreach($request_array as $loop) { ?>
                                  <tr>
                                      <td><?php echo $loop->stor_number; ?></td>
                                      <td><?php echo $loop->stor_issue; ?></td>
                                      <td><?php echo $loop->so_number; ?></td>
                                      <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                      <td><?php if($loop->stor_status==1) echo "<button class='btn btn-xs btn-danger'>รอยืนยันสินค้า</button>"; else if($loop->stor_status==2) echo "<button class='btn btn-xs btn-success'>ยืนยันคืนสินค้าแล้ว</button>"; else if($loop->stor_status==3) echo "<button class='btn btn-xs btn-warning'>ยกเลิกการขอคืนแล้ว</button>"; ?></td>
                                      <td><?php if ($loop->stor_status != 3) { ?><a href="<?php if($loop->stor_status==1) echo site_url("tp_stock_return/print_return_request")."/".$loop->stor_id; else if($loop->stor_status==2) echo site_url("tp_stock_return/print_return_confirm")."/".$loop->stor_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="พิมพ์เอกสาร"><span class="glyphicon glyphicon-print"></span></a><?php } ?>

																			<a href="<?php echo site_url("tp_stock_return/view_return")."/".$loop->stor_id; ?>" class="btn btn-success btn-xs" data-title="ดูรายละเอียด" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><i class="fa fa-search"></i></a>
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
