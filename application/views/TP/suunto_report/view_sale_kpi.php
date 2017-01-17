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
            Suunto Report > Sale KPI ประจำเดือนที่ <?php echo $month; ?>
        </h1>
    </section>

	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="<?php echo site_url("tp_suunto_report/sale_kpi"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
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
                <div class="panel panel-danger">
					<div class="panel-heading">
						<form name="exportexcel" class="pull-right" action="<?php echo site_url("tp_suunto_report/exportExcel_sale_kpi"); ?>" method="post">
							<input type="hidden" name="datein" value="<?php echo $month; ?>">
						<button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
						</form>
                        <h4>Sale KPI ประจำเดือนที่ <?php echo $month; ?></h4>

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

    get_datepicker("#datein");

    var oTable = $('#tablebarcode').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("tp_suunto_report/ajaxView_sale_kpi")."/".$ajax_month; ?>',
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
