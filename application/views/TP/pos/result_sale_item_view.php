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
</style>
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            POS Sale Report : <?php
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

                        <form name="exportexcel" action="<?php echo site_url("pos_sale/exportExcel_sale_item"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
                        <input type="hidden" name="refcode" value="<?php echo $refcode; ?>">
                        <input type="hidden" name="brand" value="<?php echo $brand_id; ?>">
                        <input type="hidden" name="shop" value="<?php echo $shop_id; ?>">
                        <input type="hidden" name="startdate" value="<?php echo $startdate; ?>">
                        <input type="hidden" name="enddate" value="<?php echo $enddate; ?>">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-primary" type="button" onclick="print_report();"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                        </form>

                        <form name="printreport" id="printreport" action="<?php echo site_url("pos_sale/print_sale_item"); ?>" method="post" target="_blank">
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
                                      <th width="70">Sold Date</th>
                                      <th>เลขที่ใบกำกับภาษีอย่างย่อ</th>
                                      <th>Shop</th>
                                      <th width="100">Ref. Number</th>
                                      <th>Model</th>
                                      <th width="100">Caseback</th>
                                      <th>Brand</th>
                                      <th width="50">Qty</th>
                                      <th>SRP</th>
                                      <th>Discount(บาท)</th>
                                      <th>Net</th>

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
        <div class="row">
            <div class="col-xs-12">
            <a href="<?php echo site_url("pos_sale/form_sale_item_view"); ?>" class="btn btn-primary">ค้นหา</a>
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
				"oLanguage": {
		      "sEmptyTable": "ไม่พบข้อมูล"
		    },
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("pos_sale/ajax_sale_item_view")."/".$refcode."/".$brand_id."/".$shop_id."/".$startdate."/".$enddate; ?>',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success":fnCallback

            });
        },
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
