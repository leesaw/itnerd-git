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
            Graph Report <small>NGG Timepieces</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Graph Report</a></li>
        </ol>
    </section>
	<!-- Main content -->
<?php 
    
    $dataset_fashion_brand = array();
    $dataset_luxury_brand = array();
    $dataset_fashion_shop = array();
    $dataset_luxury_shop = array();

    $sum_lux_brand = 0;
    $sum_fashion_brand = 0;
    $sum_lux_shop = 0;
    $sum_fashion_shop = 0;
    foreach($sale_fashion_brand as $loop) {
        $dataset_fashion_brand[] = array($loop->PTDesc1, number_format($loop->sum1,2, '.', ','));
        $sum_fashion_brand += $loop->sum1;
    }
    
    foreach($sale_luxury_brand as $loop) {
        $dataset_luxury_brand[] = array($loop->PTDesc1, number_format($loop->sum1,2, '.', ','));
        $sum_lux_brand += $loop->sum1;
    }
    
    for($i=0; $i<count($sale_fashion_shop); $i++) {
        if ($sale_fashion_shop[$i]['sum1']>0) {
            $dataset_fashion_shop[] = array($sale_fashion_shop[$i]['WTDesc1'], number_format($sale_fashion_shop[$i]['sum1'],2, '.', ','));
            $sum_fashion_shop += $sale_fashion_shop[$i]['sum1'];
        }
    }
    
    for($i=0; $i<count($sale_luxury_shop); $i++) {
        if ($sale_luxury_shop[$i]['sum1']>0) {
            $dataset_luxury_shop[] = array($sale_luxury_shop[$i]['WTDesc1'], number_format($sale_luxury_shop[$i]['sum1'],2, '.', ','));
            $sum_lux_shop += $sale_luxury_shop[$i]['sum1'];
        }
    }

?>    

    <section class="content">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <form class="form-inline" role="form" action="<?php echo site_url("jes_salereport/filter_graph"); ?>" method="post">
                                    <div class="form-group">
										<label for="">เริ่ม : </label>
										<input type="text" class="form-control" id="startdate" name="startdate" value="<?php echo $start_date; ?>" />
									</div>
									<div class="form-group">
										<label for=""> สิ้นสุด : </label>
										<input type="text" class="form-control" id="enddate" name="enddate" value="<?php echo $end_date; ?>" />
									</div>
                                    <div class="form-group">
										<button class="btn btn-primary" type="submit">Filter</button>
									</div>
                                </form>
                            </div>
                        </div>
                    </div>
                        
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <label class="pull-left">Sale Report | Luxury</label>
                                <label class="pull-right">All Brand</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-lux1" style="height: 300px;"></div>
                            </div>
                            <div class="box-footer">
                                ยอดขายทั้งหมด <u><?php echo number_format($sum_lux_brand,2, '.', ','); ?></u> บาท
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <label class="pull-left">Sale Report | Fashion</label>
                                <label class="pull-right">All Brand</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-fashion1" style="height: 300px;"></div>
                            </div>
                            <div class="box-footer">
                                ยอดขายทั้งหมด <u><?php echo number_format($sum_fashion_brand,2, '.', ','); ?></u> บาท
                            </div>
                        </div>
                    </div>
                        
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <label class="pull-left">Sale Report | Luxury</label>
                                <label class="pull-right">All Shop</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-lux2" style="height: 300px;"></div>
                            </div>
                            <div class="box-footer">
                                ยอดขายทั้งหมด <u><?php echo number_format($sum_lux_shop,2, '.', ','); ?></u> บาท
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-md-6">
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <label class="pull-left">Sale Report | Fashion</label>
                                <label class="pull-right">All Shop</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-fashion2" style="height: 300px;"></div>
                            </div>
                            <div class="box-footer">
                                ยอดขายทั้งหมด <u><?php echo number_format($sum_fashion_shop,2, '.', ','); ?></u> บาท
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
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script src="<?php echo base_url(); ?>js/spin.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    get_datepicker("#startdate");
    get_datepicker("#enddate");
    
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
    
    var dataset_lux1 = <?php echo json_encode($dataset_fashion_brand); ?>;
    var dataset_fashion1 = <?php echo json_encode($dataset_luxury_brand); ?>;
    var dataset_lux2 = <?php echo json_encode($dataset_fashion_shop); ?>;
    var dataset_fashion2 = <?php echo json_encode($dataset_luxury_shop); ?>;
    
    var colors_array= ["#00a65a", "#39CCCC", "#3c8dbc", "#f56954", "#ff851b", "#605ca8", "#00c0ef", "#D81B60"];
    
    if (($('#bar-lux1').length > 0) && (dataset_lux1))
    var morris = Morris.Donut({
        element: 'bar-lux1',
        resize: true,
        data: [
            <?php for($i=0; $i<count($dataset_luxury_brand); $i++) { ?>
        {label: <?php echo json_encode($dataset_luxury_brand[$i][0]); ?>, value: <?php echo str_replace( ',', '', json_encode($dataset_luxury_brand[$i][1], JSON_NUMERIC_CHECK)); ?>},
            <?php } ?>
        ],
        colors: colors_array,
        hideHover: 'auto'
    });
    
    
    
    if (($('#bar-fashion1').length > 0) && (dataset_fashion1))
    var morris = Morris.Donut({
        element: 'bar-fashion1',
        resize: true,
        data: [
            <?php for($i=0; $i<count($dataset_fashion_brand); $i++) { ?>
        {label: <?php echo json_encode($dataset_fashion_brand[$i][0]); ?>, value: <?php echo str_replace( ',', '', json_encode($dataset_fashion_brand[$i][1], JSON_NUMERIC_CHECK)); ?>},
            <?php } ?>
        ],
        colors: colors_array,
        hideHover: 'auto'
    });
    
    if (($('#bar-lux2').length > 0) && (dataset_lux2))
    var morris = Morris.Donut({
        element: 'bar-lux2',
        resize: true,
        data: [
            <?php for($i=0; $i<count($dataset_luxury_shop); $i++) { ?>
        {label: <?php echo json_encode($dataset_luxury_shop[$i][0]); ?>, value: <?php echo str_replace( ',', '', json_encode($dataset_luxury_shop[$i][1], JSON_NUMERIC_CHECK)); ?>},
            <?php } ?>
        ],
        colors: colors_array,
        hideHover: 'auto'
    });
    
    
    
    if (($('#bar-fashion2').length > 0) && (dataset_fashion2))
    var morris = Morris.Donut({
        element: 'bar-fashion2',
        resize: true,
        data: [
            <?php for($i=0; $i<count($dataset_fashion_shop); $i++) { ?>
        {label: <?php echo json_encode($dataset_fashion_shop[$i][0]); ?>, value: <?php echo str_replace( ',', '', json_encode($dataset_fashion_shop[$i][1], JSON_NUMERIC_CHECK)); ?>},
            <?php } ?>
        ],
        colors: colors_array,
        hideHover: 'auto'
    });

});
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}

</script>
</body>
</html>