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
                        <form action="<?php echo site_url("jes_salereport/exportExcel_saleShop_itemlist"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
                    <?php
                          echo '<input type="hidden" name="shop" value="'. $shop. '">';
                          echo '<input type="hidden" name="startdate" value="'. $startdate. '">';
                          echo '<input type="hidden" name="enddate" value="'. $enddate. '">';
                          echo '<input type="hidden" name="remark" value="'. $remark. '">';
                    ?>
                        </form>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $loading = base_url()."dist/img/ajax-loader.gif";  ?>
                        <table class="table table-bordered table-striped" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sale Date</th>
                                        <th>Brand</th>
                                        <th>Item Code</th>
                                        <th>Ref Code</th>
                                        <th>Description</th>
                                        <th>Shop</th>
                                        <th width="50">Qty (Pcs.)</th>
                                        <th width="100">Unit<br>Price</th>
                                        <th width="100">Discount%</th>
                                        <th width="100">Total<br>Amount</th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($sale_array as $loop) { ?>
                                    <tr>
                                        <td><span class=hide><?php echo $loop->date_sort; ?></span><?php echo $loop->PIIssueDate; ?></td>
                                        <td><?php echo $loop->PTDesc1; ?></td>
                                        <td><?php echo $loop->PDItemCode; ?></td>
                                        <td><?php echo $loop->ITRefCode; ?></td>
                                        <td><?php echo $loop->ITShortDesc1; ?></td>
                                        <td><?php echo $loop->SHDesc1." (".$loop->SHCode.")"; ?></td>
                                        <td><?php echo number_format($loop->PDQty); ?></td>
                                        <td><?php echo number_format($loop->PDUnitPrice, 2, '.', ','); ?></td>
                                        <td><?php echo number_format($loop->PDDiscPercent, 2, '.', ','); ?></td>
                                        <td><?php echo number_format($loop->PDAmount, 2, '.', ','); ?></td>
                                    </tr>
                                    <?php } ?>
								</tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" style="text-align:right">จำนวนทั้งหมด:</th>
                                        <th></th>
                                        <th colspan="2" style="text-align:right">ยอดเงินรวม:</th>
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
 
            // Total over all pages qty
            total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            // Total over this page qty
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer total qty
            $( api.column( 6 ).footer() ).html(
                total+' ('+pageTotal+')'
            );
            
            // Total over all pages totalamount
            amount = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
             
            // Total over this page totalamount
            pageAmount = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer totalamount
            $( api.column( 9 ).footer() ).html(
                amount.toLocaleString('en-US', { maximumFractionDigits: 2 })+' ('+pageAmount.toLocaleString('en-US', { maximumFractionDigits: 2 })+')'
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