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
                        <form action="<?php echo site_url("jes/exportExcel_stock"); ?>" method="post">
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
                        <?php $count=0; ?>
                        <table class="table table-bordered table-striped" id="tablebarcode" width="100%">
                            <thead>
                                <tr>
                                    <th>Warehouse</th>
                                <?php for($i=0; $i<count($product); $i++) { ?>
                                    <th><?php echo $product[$i]; ?></th>
                                <?php $count++; $sum_product[$i] = 0; } ?>
                                    <th>Sum</th>
                                </tr>
                            </thead>
                                
				            <tbody>
                                <?php for($i=0; $i<count($stock); $i++) { ?>
                                <tr>
                                    <td><?php echo $stock[$i]['whname']; ?></td>
                                    <?php foreach($stock[$i]['number'] as $loop) { 
                                        $sum_store=0; for($k=0; $k<$count; $k++) {
                                    ?>
                                    <td><?php if($loop->{"num".$k} >0) echo $loop->{"num".$k}; $sum_store+=$loop->{"num".$k}; $sum_product[$k]+=$loop->{"num".$k}; ?></td>
                                    <?php } } ?>
                                    <td><b><?php echo $sum_store; ?></b></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td>Sum</td>
                                    <?php for($i=0; $i<count($product); $i++) { ?>
                                    <td><b><?php echo $sum_product[$i]; ?></b></td>
                                    <?php } ?>
                                    <td> </td>
                                </tr>
				            </tbody>
                                
				        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
    
$(document).ready(function()
{    
    //var oTable = $('#tablebarcode').dataTable();
    
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