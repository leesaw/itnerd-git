<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
</head>

<body class="skin-purple sidebar-collapse fixed">
    <section class="content">
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading">
                        <form action="<?php echo site_url("jes/exportExcel_stock_itemlist"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
                    <?php
                        foreach($producttype as $value)
                        {
                          echo '<input type="hidden" name="producttype[]" value="'. $value. '">';
                        }
                            
                        foreach($warehouse as $value)
                        {
                          echo '<input type="hidden" name="warehouse[]" value="'. $value. '">';
                        }
                    ?>
                        </form>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $loading = base_url()."dist/img/ajax-loader.gif";  ?>
                        <table class="table table-bordered table-striped" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th width="80">Barcode</th>
                                        <th>Item Code</th>
                                        <th>Ref Code</th>
                                        <th width="200">Description</th>
                                        <th width="300">Long Description</th>
                                        <th>SRP (Baht)</th>
                                        <th>Warehouse</th>
										<th width="50">Qty (Pcs.)</th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($item_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->IHBarcode; ?></td>
                                        <td><?php echo $loop->itemcode; ?></td>
                                        <td><?php echo $loop->ITRefCode; ?></td>
                                        <td><?php echo $loop->ITShortDesc2." ".$loop->ITShortDesc1; ?></td>
                                        <td><?php echo $loop->ITLongDesc1; ?></td>
                                        <td><?php echo number_format($loop->ITSRP); ?></td>
                                        <td><?php echo $loop->WHDesc1." (".$loop->WHCode.")"; ?></td>
                                        <td><?php echo $loop->IHQtyCal; ?></td>
                                    </tr>
                                    <?php } ?>
								</tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" style="text-align:right">จำนวนทั้งหมด:</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
							</table>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
    
$(document).ready(function()
{    
    $('#tablebarcode').dataTable({
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
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            // Total over this page
            pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                total+' ('+pageTotal+')'
            );
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
</script>
</body>
</html>