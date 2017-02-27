<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
<style>
.btnVoid {
	padding: 1px 5px;
  font-size: 12px;
  line-height: 1.5;
  border-radius: 3px;
	color: #fff;
  background-color: #c9302c;
  border-color: #ac2925;
	display: inline-block;
  margin-bottom: 0;
  font-weight: normal;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -ms-touch-action: manipulation;
      touch-action: manipulation;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  background-image: none;
  border: 1px solid transparent;
}

.btnFull {
	padding: 1px 5px;
  font-size: 12px;
  line-height: 1.5;
  border-radius: 3px;
	color: #fff;
  background-color: #5cb85c;
  border-color: #4cae4c;
	display: inline-block;
  margin-bottom: 0;
  font-weight: normal;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -ms-touch-action: manipulation;
      touch-action: manipulation;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  background-image: none;
  border: 1px solid transparent;
}

</style>
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ใบกำกับภาษีแบบเต็ม : <?php
            if ($refcode !="NULL") echo $refcode;
            echo " Brand : ".$brand_name;
            echo " Shop : ".$shop_name;
            echo " ช่วงเวลา : ";
            if ($startdate != '1970-01-01') $startdate;
            echo " ถึง ".$enddate;  ?>
        </h1>
    </section>

	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">

        <div class="row">
			<div class="col-xs-12">
        <div class="panel panel-default">
					<div class="panel-heading">

                        <form name="exportexcel" action="<?php echo site_url("pos_invoice/exportExcel_view_full_invoice"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
                        <input type="hidden" name="refcode" value="<?php echo $refcode; ?>">
                        <input type="hidden" name="brand" value="<?php echo $brand_id; ?>">
                        <input type="hidden" name="shop" value="<?php echo $shop_id; ?>">
                        <input type="hidden" name="startdate" value="<?php echo $startdate; ?>">
                        <input type="hidden" name="enddate" value="<?php echo $enddate; ?>">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-primary" type="button" onclick="print_report();"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                        </form>

                        <form name="printreport" id="printreport" action="<?php echo site_url("pos_invoice/print_view_full_invoice"); ?>" method="post" target="_blank">
                        <input type="hidden" name="refcode" value="<?php echo $refcode; ?>">
                        <input type="hidden" name="brand" value="<?php echo $brand_id; ?>">
                        <input type="hidden" name="shop" value="<?php echo $shop_id; ?>">
                        <input type="hidden" name="startdate" value="<?php echo $startdate; ?>">
                        <input type="hidden" name="enddate" value="<?php echo $enddate; ?>">
                        </form>

                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th class='col-xs-2'>เลขที่ใบกำกับภาษีแบบเต็ม</th>
                                        <th class='col-xs-1'>วันที่</th>
                                        <th class='col-xs-2'>POS</th>
                                        <th class='col-xs-1'>พนักงานขาย</th>
                                        <th class='col-xs-1'>ลูกค้า</th>
                                        <th class='col-xs-1'>รวมส่วนลด</th>
                                        <th class='col-xs-1'>ส่วนลดท้ายบิล</th>
                                        <th class='col-xs-1'>ภาษีมูลค่าเพิ่ม</th>
                                        <th class='col-xs-1'>รวมยอดเงิน<br>(รวมภาษี)</th>
                                        <th class='col-xs-1'> </th>
                                    </tr>
                                </thead>

								<tbody>
								</tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="8" style="text-align:right">ยอดเงินทั้งหมด:</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
							</table>

					</div>

				</div>
			</div>

		</div>
        <div class="row">
            <div class="col-xs-12">
            <a href="<?php echo site_url("pos_invoice/form_view_full_invoice"); ?>" class="btn btn-primary">ค้นหา</a>
            </div>
        </div>




					</div>
                </div>
            </div>
        </div>
        </section>
		</div>


	</div>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" data-dismiss="modal">
    <div class="modal-content"  >
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    var oTable = $('#tablebarcode').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("pos_invoice/ajax_view_full_invoice")."/".$refcode."/".$brand_id."/".$shop_id."/".$startdate."/".$enddate; ?>',
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

            total_money = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal_money = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 8 ).footer() ).html(
                (total_money).formatMoney(2, '.', ',')+'<br>('+(pageTotal_money).formatMoney(2, '.', ',')+')'
            );
        }
    });

    $('#fancyboxall').fancybox({
    'width': '30%',
    'height': '80%',
    'autoScale':false,
    'transitionIn':'none',
    'transitionOut':'none',
    'type':'iframe'});

    $('#byserial').on('click', function(){
        document.getElementById('byserial').checked = false;
        document.getElementById("viewbyserial").submit();
    });
});

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
function showcaseback()
{

    document.getElementById("exportcaseback").submit();
}

function print_report()
{
    document.getElementById("printreport").submit();
}
</script>
</body>
</html>