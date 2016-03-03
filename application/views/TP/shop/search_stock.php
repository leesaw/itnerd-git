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
            Stock Balance : <?php echo $shop_name; ?>
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                        
        <div class="box-body">
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-warning">
					<div class="panel-heading">
                        <div class="row">
                        <div class="col-md-3">รายการสินค้า</div><div class="col-md-6"><input type="radio" name="show_all" id="show_all" value="1" <?php if(($remark=='all') || (!isset($remark)) || ($remark=='')) echo "checked"; ?>> <label class="text-green"> แสดงทั้งหมด</label>&nbsp; &nbsp; &nbsp; 
              <input type="radio" name="show_have" id="show_have" value="1" <?php if ($remark=='have') echo "checked"; ?>> <label class="text-blue"> เฉพาะที่มีของ(จำนวน > 0)</label>&nbsp; &nbsp; &nbsp; 
              <input type="radio" name="show_no" id="show_no" value="1" <?php if ($remark=='no') echo "checked"; ?>> <label class="text-red"> เฉพาะของหมด(จำนวน = 0)</label></div>
                    <div class="col-md-3" style="text-align:right"><a href="<?php echo site_url("pos/stock_rolex_print")."/".$remark; ?>" target="_blank"><button type="button" class="btn btn-success" name="printbtn" id="printbtn"><i class='fa fa-print'></i>  พิมพ์รายการสินค้า </button></a></div>
                    </div></div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
				                        <th>RMC</th>
                                        <th>Brand</th>
                                        <th>Description</th>
                                        <th>Family</th>
                                        <th>Bracelet</th>
										<th width="105">Quantity</th>
                                        <th>Retail Price</th>
                                        <th>Serial No.</th>
				                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($item_array as $loop) {
                                        if ($loop->stob_qty<1) echo "<tr class='danger'>";
                                        else echo "<tr>";
                                    ?>
                                        <td><?php echo $loop->it_refcode; ?></td>
                                        <td><?php echo $loop->br_name; ?></td>
                                        <td><?php echo $loop->it_short_description; ?></td>
                                        <td><?php echo $loop->it_model; ?></td>
                                        <td><?php echo $loop->it_remark; ?></td>
                                        <td><?php echo $loop->stob_qty; ?></td>
                                        <td><?php echo number_format($loop->it_srp); ?></td>
                                        <td><a id="fancyboxall" href="<?php echo site_url("warehouse/view_serial")."/".$loop->stob_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                    <?php } ?>
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
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
    
$(document).ready(function()
{    
    $('#show_all').on('click', function(){            
            window.location.replace("<?php echo site_url("pos/getBalance_shop/all"); ?>");
    });
    
    $('#show_have').on('click', function(){            
            window.location.replace("<?php echo site_url("pos/getBalance_shop/have"); ?>");
    });
    
    $('#show_no').on('click', function(){            
            window.location.replace("<?php echo site_url("pos/getBalance_shop/no"); ?>");
    });
    
    var oTable = $('#tablebarcode').DataTable({
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