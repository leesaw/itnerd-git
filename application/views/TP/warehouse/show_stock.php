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
            แสดงสินค้า Ref. Number หรือ Description : <B><U><?php if ($refcode !="NULL") echo $refcode; ?></U></B> ทั้งหมดในคลัง
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
                        <form action="<?php echo '#';//echo site_url("warehouse/exportExcel_search"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
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
                                        <th>Model</th>
                                        <th>Warehouse</th>
										<th width="50">Qty</th>
                                        <th>SRP</th>
                                        <th width="200">Short Description</th>
                                        <!-- <th width="50">Caseback</th> -->
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php /* foreach($stock_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->it_refcode; ?></td>
                                        <td><?php echo $loop->br_name; ?></td>
                                        <td><?php echo $loop->it_model; ?></td>
                                        <td><?php echo $loop->wh_code."-".$loop->wh_name; ?></td>
                                        <td><?php echo $loop->stob_qty; ?></td>
                                        <td><?php echo number_format($loop->it_srp); ?></td>
                                        <td><?php echo $loop->it_short_description; ?></td>
                                        <td><?php if($loop->has_serial>0) { ?>
                                        <a id="fancyboxall" href="<?php echo site_url("warehouse/view_serial")."/".$loop->stob_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a> 
                                        <?php } ?></td>
                                    </tr>
                                    <?php } */?>
								</tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align:right">จำนวนทั้งหมด:</th>
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
            
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
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
    

});
    

</script>
</body>
</html>