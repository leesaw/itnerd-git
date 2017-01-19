<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>

<?php


?>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Suunto Report > อันดับยอดขาย ช่วงวันที่ <?php echo $startdate; ?> ถึง <?php echo $enddate; ?>
        </h1>
    </section>

	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">
            <div class="row">
              <form action="<?php echo site_url("tp_suunto_report/top_ten"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-2 control-label">เลือกช่วงเวลา เริ่ม</label>
									<div class="col-sm-2">
									<input type="text" class="form-control" name="startdate" id="startdate" value="<?php echo $startdate; ?>" autocomplete="off" readonly>
									</div>
									<label class="col-sm-2 control-label">ถึง</label>
									<div class="col-sm-2">
									<input type="text" class="form-control" name="enddate" id="enddate" value="<?php echo $enddate; ?>" autocomplete="off" readonly>
									</div>
									<div class="col-sm-2">
										<button type="button" class="btn btn-primary" onClick="submitform();">ตกลง</button>
									</div>
								</div>
              </form>
            </div>
            <br>
            <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading">
						<form name="exportexcel" class="pull-right" action="<?php echo site_url("tp_suunto_report/exportExcel_top_ten"); ?>" method="post">
							<input type="hidden" name="startdate" value="<?php echo $startdate; ?>">
							<input type="hidden" name="enddate" value="<?php echo $enddate; ?>">
						<button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
						</form>
                        <h4>อันดับยอดขาย ช่วงวันที่ <?php echo $startdate; ?> ถึง <?php echo $enddate; ?>

                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-bordered" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No.</th>
                                        <th rowspan="2">Shop Code</th>
                                        <th rowspan="2">Shop Name</th>
                                        <th rowspan="2">SBU</th>
                                        <th colspan="2" style="text-align: center;">Total Suunto</th>
                                        <th colspan="2" style="text-align: center;">Performance</th>
                                        <th colspan="2" style="text-align: center;">Lifestyle</th>
                                        <th colspan="2" style="text-align: center;">Outdoor</th>
                                    </tr>
                                    <tr>
                                      <th>Total Amount<br>(Local Currency)</th>
                                      <th>Qty</th>
                                      <th>Total Amount<br>(Local Currency)</th>
                                      <th>Qty</th>
                                      <th>Total Amount<br>(Local Currency)</th>
                                      <th>Qty</th>
                                      <th>Total Amount<br>(Local Currency)</th>
                                      <th>Qty</th>
                                    </tr>
                                </thead>

								<tbody>
                    <?php $no = 1; foreach($all_array as $loop) { ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $loop->sh_code; ?></td>
                        <td><?php echo $loop->sh_name; ?></td>
                        <?php $top_remark = ""; $top_price=0; $cost_performance = 0; $item_performance = 0;
                        $cost_lifestyle = 0; $item_lifestyle = 0; $cost_outdoor = 0; $item_outdoor = 0;
                         foreach($top_array as $loop2) {
                          if ($loop2->so_shop_id == $loop->so_shop_id) {
                            if ($top_price < $loop2->cost_price) {
                              $top_remark = $loop2->it_remark;
                              $top_price = $loop2->cost_price;
                            }
                            switch ($loop2->it_remark) {
                              case "performance": $cost_performance = $loop2->cost_price; $item_performance = $loop2->count_item; break;
                              case "lifestyle": $cost_lifestyle = $loop2->cost_price; $item_lifestyle = $loop2->count_item; break;
                              case "outdoor": $cost_outdoor = $loop2->cost_price; $item_outdoor = $loop2->count_item; break;
                            }


                          }
                         } ?>
                        <td><?php echo $top_remark; ?></td>
                        <td><?php echo $loop->cost_price; ?></td>
                        <td><?php echo $loop->count_item; ?></td>
                        <td><?php echo $cost_performance; ?></td><td><?php echo $item_performance; ?></td>
                        <td><?php echo $cost_lifestyle; ?></td><td><?php echo $item_lifestyle; ?></td>
                        <td><?php echo $cost_outdoor; ?></td><td><?php echo $item_outdoor; ?></td>
                      </tr>
                    <?php $no++; } ?>
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
	get_datepicker("#startdate");
	get_datepicker("#enddate");


});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}

function submitform()
{
    document.getElementById("form1").submit();
}

Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
     };
</script>
</body>
</html>
