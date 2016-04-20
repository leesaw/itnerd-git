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
            Sale Report : <?php 
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
                        <form name="exportexcel" action="<?php echo site_url("sale/exportExcel_sale_report"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
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
                                        <th>Sold Date</th>
                                        <th>Shop</th>
                                        <th width="80">Ref. Number</th>
                                        <th>Brand</th>
										<th width="50">Qty</th>
                                        <th>SRP</th>
                                        <th>BAR</th>
                                        <th>Discount<br>(%)</th>
                                        <th>On Top<br>บาท</th>
                                        <th>GP(%)</th>
                                        <th>Receive on Inv.</th>
                                        <!-- <th width="50">Caseback</th> -->
                                    </tr>
                                </thead>
                                
								<tbody>
								</tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align:right">จำนวนทั้งหมด:</th>
                                        <th></th>
                                        <th colspan="5" style="text-align:right">ยอดเงินทั้งหมด:</th>
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
            <a href="<?php echo site_url("sale/report_sale_form"); ?>" class="btn btn-primary">ค้นหา</a>    
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
        'sAjaxSource'    : '<?php echo site_url("sale/ajaxViewSaleReport")."/".$refcode."/".$brand_id."/".$shop_id."/".$startdate."/".$enddate; ?>',
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
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            total_money = api
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            pageTotal_money = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                total+' ('+pageTotal+')'
            );
            
            $( api.column( 10 ).footer() ).html(
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
</script>
</body>
</html>