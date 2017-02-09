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
            รายการยอดเคลื่อนไหวสินค้า
        </h1>
    </section>

	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("tp_stockmovement/result_stockmovement"); ?>" name="formfilter" id="formfilter" method="post">
            <div class="col-md-2">
                <div class="form-group">
                Ref. Number
                <input type="text" class="form-control input-sm" name="refcode" id="refcode" value="<?php if ($refcode != "NULL") echo $refcode; ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                ยี่ห้อ
                <select id="brandid" name="brandid" class="form-control select2" style="width: 100%;">
                    <option value="0" selected>เลือกทั้งหมด</option>
                    <?php foreach($brand_array as $loop) { ?>
                    <option value="<?php echo $loop->br_id; ?>"<?php if ($loop->br_id == $brandid) echo " selected"; ?>><?php echo $loop->br_code."-".$loop->br_name; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    เลือก Warehouse
                    <select id="warehouse" name="warehouse" class="form-control select2" style="width: 100%;" required>
                        <option value="">-- กรุณาเลือก --</option>
                        <?php
                            foreach($whname_array as $loop) {
                        ?>
                        <option value="<?php echo $loop->wh_id; ?>"<?php if ($loop->wh_id == $warehouse) echo " selected"; ?>><?php echo $loop->wh_code."-".$loop->wh_name; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                เลือกวันที่เริ่มต้น :
                <input type="text" class="form-control input-sm" id="startdate" name="startdate" value="<?php echo $start; ?>" />
            </div>
            <div class="col-md-2">
                สิ้นสุด :
                <input type="text" class="form-control input-sm" id="enddate" name="enddate" value="<?php echo $end; ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3 col-md-2">
                <button type="submit" name="action" value="0" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> ค้นหา</button>
            </div>
        </div>


        </form>

					</div>
                </div>
            </div>
        </div>


        <div class="row">
        <div class="col-xs-12">
                <div class="panel panel-default">
          <div class="panel-heading">
                        <form name="exportexcel" action="<?php echo site_url("tp_stockmovement/exportExcel_stockmovement"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
                        <input type="hidden" name="excel_refcode" value="<?php echo $refcode; ?>">
                        <input type="hidden" name="excel_brandid" value="<?php echo $brandid; ?>">
                        <input type="hidden" name="excel_warehouse" value="<?php echo $warehouse; ?>">
                        <input type="hidden" name="excel_startdate" value="<?php echo $start_ajax; ?>">
                        <input type="hidden" name="excel_enddate" value="<?php echo $end_ajax; ?>">
												<input type="hidden" name="excel_showcost" value="<?php echo $showcost; ?>">
                        </form>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="tablebarcode" width="100%">
                            <thead>
                                <tr>
                                    <th>Ref. Number</th>
                                    <th>ยี่ห้อ</th>
																		<th>ราคาป้าย</th>
                                    <th>ชื่อคลัง</th>
                                    <th>ยอดยกมา</th>
                                    <th>รับเข้า</th>
                                    <th>ขายออก</th>
                                    <th>ย้ายเข้า</th>
                                    <th>ย้ายออก</th>
                                    <th>ยอดคงเหลือ</th>
																		<?php if ($showcost ==1) { ?><th>ราคาทุน</th><?php } ?>
                                </tr>
                            </thead>

              <tbody>
              </tbody>
                            <tfoot>
                              <tr>
                                  <th colspan="4" style="text-align:right">ยอดรวม:</th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
																	<?php if ($showcost ==1) { ?><th></th><?php } ?>
                              </tr>
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
    //Initialize Select2 Elements
    $(".select2").select2();
    get_datepicker("#startdate");
    get_datepicker("#enddate");

    var oTable = $('#tablebarcode').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("tp_stockmovement/ajaxView_stockmovement")."/".$refcode."/".$brandid."/".$warehouse."/".$start_ajax."/".$end_ajax."/".$showcost; ?>',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success":fnCallback

            });
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total1 = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            total2 = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            total3 = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            total4 = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            total5 = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            total6 = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over this page
            pageTotal1 = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotal2 = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotal3 = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotal4 = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotal5 = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotal6 = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 4 ).footer() ).html(
                total1+' ('+pageTotal1+')'
            );

            $( api.column( 5 ).footer() ).html(
                total2+' ('+pageTotal2+')'
            );

            $( api.column( 6 ).footer() ).html(
                total3+' ('+pageTotal3+')'
            );

            $( api.column( 7 ).footer() ).html(
                total4+' ('+pageTotal4+')'
            );

            $( api.column( 8 ).footer() ).html(
                total5+' ('+pageTotal5+')'
            );

            $( api.column( 9 ).footer() ).html(
                total6+' ('+pageTotal6+')'
            );

        }
    });
});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}
</script>
</body>
</html>
