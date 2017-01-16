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
            Suunto Report > Top 10 ประจำเดือนที่ี่ <?php echo $month; ?>
        </h1>
    </section>

	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="<?php echo site_url("tp_suunto_report/top_ten"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
                        <div class="form-group-sm">
                                <label class="col-sm-2 control-label">เลือกเดือน</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $month; ?>" onChange="submitform();" autocomplete="off" readonly>
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
                        <h4>Top 10 ประจำเดือนที่ี่ <?php echo $month; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
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

    get_datepicker("#datein");

    // var oTable = $('#tablefinal').DataTable( {
    //
    // } );


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
