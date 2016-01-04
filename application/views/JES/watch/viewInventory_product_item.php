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

<?php

$dataset_pt = array();

foreach($pt_array as $loop) {
        $dataset_pt[] = array($loop->WHCode,$loop->sum1);
}

?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แสดงสินค้า <B><U><?php echo $branchname; ?></U></B> ทั้งหมดในสต็อก
        </h1>
    </section>
	
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <a id="fancyboxall" href="<?php echo site_url("jes/watch_store_product/".$pt_code); ?>"><button type="button" class="btn btn-xs btn-primary">แสดงรหัสสาขา</button></a>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="bar-pt" style="height: 300px;"></div>
                            <br>
                        </div>
                    </div>
                </div>
        </div>
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
                                        <th width="300">Long Description</th>
                                        <th>Warehouse</th>
										<th width="50">Qty (Pcs.)</th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($item_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->IHBarcode; ?></td>
                                        <td><a href="#" class="pop"><?php echo $loop->itemcode; ?></a></td>
                                        <td><?php echo $loop->ITRefCode; ?></td>
                                        <td><?php echo number_format($loop->ITSRP); ?></td>
                                        <td><?php echo $loop->ITShortDesc2." ".$loop->ITShortDesc1; ?></td>
                                        <td><?php echo $loop->ITLongDesc1; ?></td>
                                        <td><?php echo $loop->WHDesc1." (".$loop->WHCode.")"; ?></td>
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
<script src="<?php echo base_url(); ?>plugins/morris/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/morris.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    var oTable = $('#tablebarcode').dataTable();
    
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
    
    if ($('#bar-pt').length > 0)
    var morris = Morris.Bar({
        element: 'bar-pt',
        resize: true,
        data: [
            <?php for($i=0; $i<count($dataset_pt); $i++) { ?>
        {y: <?php echo json_encode($dataset_pt[$i][0]); ?>, a: <?php echo str_replace( ',', '', json_encode($dataset_pt[$i][1], JSON_NUMERIC_CHECK)); ?>},
            <?php } ?>
        ],
        barColors: ['#FF6A6A'],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['จำนวน'],
        hideHover: 'auto',
        xLabelAngle: 0
    });
    
    $('.pop').on('click', function() {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
		});	
    
});
    

</script>
</body>
</html>