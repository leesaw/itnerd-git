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
    $dataset_lux = array();
    $dataset_fashion = array();
    $dataset_branch = array();
    $sum_lux = 0;
    $sum_fashion = 0;
    foreach($lux_array as $loop) {
        $dataset_lux[] = array($loop->PTDesc1, $loop->sum1);
        $sum_lux += $loop->sum1;
    }
    
    foreach($fashion_array as $loop) {
        $dataset_fashion[] = array($loop->PTDesc1, $loop->sum1);
        $sum_fashion += $loop->sum1;
    }
    if (isset($branch_array)) {
        for($i=0; $i<count($branch_array); $i++) {
            $dataset_branch[] = array($branch_array[$i]['WHCode'], $branch_array[$i]['luxsum'], $branch_array[$i]['fashionsum']);
        }
    }

?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แสดงสินค้าทั้งหมดในสต็อก : <B><U><?php echo $branchname; ?></U></B>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("jes/watch"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $branchname; ?></li>
        </ol>
    </section>
	
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <label class="pull-right">Luxury Brand</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-lux" style="height: 300px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum_lux; ?></u> ชิ้น
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-md-4">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <label class="pull-right">Fashion Brand</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-fashion" style="height: 300px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum_fashion; ?></u> ชิ้น 
                            </div>
                        </div>
                    </div>
                        
                </div>
                <?php if (isset($branch_array)) { ?>
                <div class="row">
                    <div class="col-md-10">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <a id="fancyboxall" href="<?php echo site_url("jes/watch_store_branch/".$whcode); ?>"><button type="button" class="btn btn-xs btn-primary">แสดงรหัสสาขา</button></a>
                                <label class="pull-right">Warehouse</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-branch" style="height: 220px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
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
    
    var dataset_lux = <?php echo json_encode($dataset_lux); ?>;
    var dataset_fashion = <?php echo json_encode($dataset_fashion); ?>;
    var dataset_branch = <?php echo json_encode($dataset_branch); ?>;
    
    var colors_array= ["#00a65a", "#39CCCC", "#3c8dbc", "#f56954", "#ff851b", "#605ca8", "#00c0ef", "#D81B60"];
    if (($('#bar-lux').length > 0) && (dataset_lux))
    var morris = Morris.Donut({
        element: 'bar-lux',
        resize: true,
        data: [
            <?php for($i=0; $i<count($dataset_lux); $i++) { ?>
        {label: <?php echo json_encode($dataset_lux[$i][0]); ?>, value: <?php echo str_replace( ',', '', json_encode($dataset_lux[$i][1], JSON_NUMERIC_CHECK)); ?>},
            <?php } ?>
        ],
        colors: colors_array,
        hideHover: 'auto'
    });
    
    
    
    if (($('#bar-fashion').length > 0) && (dataset_fashion))
    var morris = Morris.Donut({
        element: 'bar-fashion',
        resize: true,
        data: [
            <?php for($i=0; $i<count($dataset_fashion); $i++) { ?>
        {label: <?php echo json_encode($dataset_fashion[$i][0]); ?>, value: <?php echo str_replace( ',', '', json_encode($dataset_fashion[$i][1], JSON_NUMERIC_CHECK)); ?>},
            <?php } ?>
        ],
        colors: colors_array,
        hideHover: 'auto'
    });
    
    //BAR CHART - Branch
    if (($('#bar-branch').length > 0) && (dataset_branch))
        var ct = Morris.Bar({
          element: 'bar-branch',
          resize: true,
          data: [
              <?php for($i=0; $i<count($dataset_branch); $i++) { ?>
            {y: <?php echo json_encode($dataset_branch[$i][0]); ?>, a: <?php echo str_replace( ',', '', json_encode($dataset_branch[$i][1], JSON_NUMERIC_CHECK)); ?>, b: <?php echo str_replace( ',', '', json_encode($dataset_branch[$i][2], JSON_NUMERIC_CHECK)); ?>},
              <?php } ?>
          ],
          barColors: ['#00c0ef', '#D81B60'],
          xkey: 'y',
          ykeys: ['a', 'b'],
          labels: ['Luxury Watch', 'Fashion Watch'],
          xLabelMargin: 10,
          hideHover: 'auto'
        }).on('click', function(i, row){
            window.location.replace("<?php echo site_url('jes/watch_viewInventory_branch'); ?>"+"/"+<?php echo json_encode($remark); ?>+"/"+row.y);
        });
    
});
    

</script>
</body>
</html>