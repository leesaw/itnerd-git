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
            Suunto Report > จำนวนสินค้าคงเหลือ ประจำวันที่ <?php echo $currentdate; ?>
        </h1>
    </section>

	<section class="content">

        <div class="row">
        <div class="col-xs-12">
                <div class="panel panel-default">
          <div class="panel-heading">
                        <form name="exportexcel" action="<?php echo site_url("tp_suunto_report/exportExcel_inventory_now"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
                        </form>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="tablebarcode" width="100%">
                            <thead>
                                <tr>
                                    <th>WH Code</th>
                                    <th>WH Name</th>
																		<th>Suunto Code</th>
                                    <th>Description</th>
                                    <th>SBU</th>
                                    <th>Month</th>
                                    <th>Qty</th>
                                    <th>Unit Price<br>(Local Currency)</th>
                                    <th>Total Amount<br>(Local Currency)</th>
                                    <th>Landed Cost</th>
                                </tr>
                            </thead>

              <tbody>
              </tbody>
                            <tfoot>
                            </tfoot>
            </table>

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

    var oTable = $('#tablebarcode').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("tp_suunto_report/ajaxView_inventory_now"); ?>',
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

</script>
</body>
</html>
