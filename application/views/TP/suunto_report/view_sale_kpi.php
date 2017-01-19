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
            Suunto Report > Sale KPI ช่วงวันที่ <?php echo $startdate; ?> ถึง <?php echo $enddate; ?>
        </h1>
    </section>

	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">
            <div class="row">
              <form action="<?php echo site_url("tp_suunto_report/sale_kpi"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
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
                <div class="panel panel-danger">
					<div class="panel-heading">
						<form name="exportexcel" class="pull-right" action="<?php echo site_url("tp_suunto_report/exportExcel_sale_kpi"); ?>" method="post">
							<input type="hidden" name="startdate" value="<?php echo $startdate; ?>">
							<input type="hidden" name="enddate" value="<?php echo $enddate; ?>">
						<button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
						</form>
                        <h4>Sale KPI ช่วงวันที่ <?php echo $startdate; ?> ถึง <?php echo $enddate; ?></h4>

                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="tablebarcode" width="100%">
                            <thead>
                                <tr>
                                    <th>Shop Code</th>
                                    <th>Shop Name</th>
																		<th>Channel</th>
                                    <th>Issue Date</th>
                                    <th>Suunto Code</th>
                                    <th>Description</th>
                                    <th>SBU</th>
                                    <th>Landed Cost<br>(Local Currency)</th>
                                    <th>Qty</th>
                                    <th>Selling Price<br>(Local Currency)</th>
                                    <th>Total Amount<br>(Local Currency)</th>
                                    <th>Month</th>
                                </tr>
                            </thead>

								<tbody>

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

    var oTable = $('#tablebarcode').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("tp_suunto_report/ajaxView_sale_kpi")."/".$ajax_start."/".$ajax_end; ?>',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success":fnCallback

            });
        }
    });


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
