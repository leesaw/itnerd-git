<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
</head>

<body class="skin-purple">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แสดงสินค้า <?php echo $productname; ?> ใน : <B><U><?php echo $branchname; ?></U></B>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("jes/watch"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading"></div>
                    <div class="panel-body">
                            <table class="table table-bordered table-striped" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th width="80">Barcode</th>
                                        <th>Item Code</th>
                                        <th>Ref Code</th>
                                        <th>SRP</th>
                                        <th width="200">Description</th>
                                        <th width="400">Long Description</th>
										<th width="50">Qty (Pcs.)</th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($item_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->IHBarcode; ?></td>
                                        <td><?php echo $loop->itemcode; ?></td>
                                        <td><?php echo $loop->ITRefCode; ?></td>
                                        <td><?php echo number_format($loop->ITSRP); ?></td>
                                        <td><?php echo $loop->ITShortDesc2." ".$loop->ITShortDesc1; ?></td>
                                        <td><?php echo $loop->ITLongDesc1; ?></td>
                                        <td><?php echo $loop->IHQtyCal; ?></td>
                                    </tr>
                                    <?php } ?>
								</tbody>
                                
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
<script src="<?php echo base_url(); ?>plugins/morris/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/morris.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    var oTable = $('#tablebarcode').dataTable();
    
    $('#fancyboxall').fancybox({ 
    'width': '60%',
    'height': '60%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
    
});
    

</script>
</body>
</html>