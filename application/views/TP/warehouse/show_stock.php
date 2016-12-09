<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แสดงสินค้า <B><U><?php if ($refcode !="NULL") echo $refcode_show; ?></U></B> <?php if ($brand!=0) { foreach($brand_array as $b) echo "ยี่ห้อ ".$b->br_name; } ?> <?php if ($warehouse!=0) { foreach($whname_array as $w) echo "ในคลัง ".$w->wh_name; } ?>
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
                        <form name="exportexcel" action="<?php echo site_url("warehouse/exportExcel_stock_itemlist"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel จำนวน</button>
                        <input type="hidden" name="refcode" value="<?php echo $refcode; ?>">
                        <input type="hidden" name="brand" value="<?php echo $brand; ?>">
                        <input type="hidden" name="warehouse" value="<?php echo $warehouse; ?>">
                        <input type="hidden" name="minprice" value="<?php echo $minprice; ?>">
                        <input type="hidden" name="maxprice" value="<?php echo $maxprice; ?>">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="byquantity" value="0"<?php if ($viewby ==0) echo " checked"; ?>> แสดงจำนวน
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="byserial" id="byserial" value="1"<?php if ($viewby ==1) echo " checked"; ?>> แสดง Caseback
                        <button class="btn btn-primary pull-right" type="button" onclick="showcaseback();"><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> Excel Caseback</button>
                        </form>
                        <form name="exportcaseback" id="exportcaseback" action="<?php echo site_url("warehouse/exportExcel_stock_itemlist_caseback"); ?>" method="post">
                        <input type="hidden" name="refcode" value="<?php echo $refcode; ?>">
                        <input type="hidden" name="brand" value="<?php echo $brand; ?>">
                        <input type="hidden" name="warehouse" value="<?php echo $warehouse; ?>">
                        <input type="hidden" name="minprice" value="<?php echo $minprice; ?>">
                        <input type="hidden" name="maxprice" value="<?php echo $maxprice; ?>">
                        </form>
                        <form name="viewbyserial" id="viewbyserial" action="<?php echo site_url("warehouse/showBalance_byserial"); ?>" method="post">
                        <input type="hidden" name="refcode" value="<?php echo $refcode; ?>">
                        <input type="hidden" name="brand" value="<?php echo $brand; ?>">
                        <input type="hidden" name="warehouse" value="<?php echo $warehouse; ?>">
                        <input type="hidden" name="minprice" value="<?php echo $minprice; ?>">
                        <input type="hidden" name="maxprice" value="<?php echo $maxprice; ?>">
                        </form>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th width="80">Ref. Number</th>
                                        <th>Brand</th>
                                        <th>Family</th>
                                        <th>Warehouse Code</th>
                                        <th>Warehouse</th>
										<th width="50">Qty</th>
                                        <th>SRP</th>
                                        <th width="200">Short Description</th>
                                        <!-- <th width="50">Caseback</th> -->
                                    </tr>
                                </thead>

								<tbody>
								</tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align:right">จำนวนทั้งหมด:</th>
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
            <a href="<?php echo site_url("warehouse/getBalance"); ?>" class="btn btn-primary">ค้นหา</a>
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
        'sAjaxSource'    : '<?php echo site_url("warehouse/ajaxViewStock")."/".$refcode."/".$brand."/".$warehouse."/".$minprice."/".$maxprice; ?>',
        "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
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
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
                total+' ('+pageTotal+')'
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

function showcaseback()
{
    document.getElementById("exportcaseback").submit();
}
</script>
</body>
</html>
