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
            Dashboard <small>NGG Timepieces</small>
            &nbsp; &nbsp;<small><input type="radio" name="stock" id="allstock" value="0" <?php if(($remark=='0') || (!isset($remark))) echo "checked"; ?>> <label class="text-green"> ทั้งหมด</label>&nbsp; &nbsp;
              <input type="radio" name="stock" id="onlyconsignment" value="1" <?php if ($remark=='1') echo "checked"; ?>> <label class="text-red"> เฉพาะ Consignment</label>&nbsp; &nbsp;
              <input type="radio" name="stock" id="noconsignment" value="2" <?php if ($remark=='2') echo "checked"; ?>> <label class="text-blue"> ไม่รวม Consignment</label></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>
	<!-- Main content -->
    <section class="content">

            
<?php 
    
    $dataset_brand = array();
    $dataset_hq = array();
    $dataset_lux = array();
    $dataset_fashion = array();

    $sum_main = 0;
    $sum_hq = 0;
    $sum_lux = 0;
    $sum_fashion = 0;

    for($i=0; $i<count($whcode_array); $i++) {
        $dataset_brand[] = array($whcode_array[$i]['WTCode'], $whcode_array[$i]['luxsum'], $whcode_array[$i]['fashionsum']);
            //$dataset_wh[] = array($whcode_array[$i]['WTCode'], $whcode_array[$i]['WTDesc1']);
        $sum_main += $whcode_array[$i]['luxsum'] + $whcode_array[$i]['fashionsum'];
    }
    for($i=0; $i<count($hq_array); $i++) {
        $dataset_hq[] = array($hq_array[$i]['PTCode'], $hq_array[$i]['PTDesc1'], $hq_array[$i]['sum1']);
        $sum_hq += $hq_array[$i]['sum1'];
    }
        
    for($i=0; $i<count($luxbrand_array); $i++) {
        $dataset_lux[] = array($luxbrand_array[$i]['PTCode'], str_replace(array('Consignment','Baume&Mercier','Frederique Constant','Maurice Lacroix'),array('C','B&M','Fred. Cons.','Maur. Lacr.'),$luxbrand_array[$i]['PTDesc1']), $luxbrand_array[$i]['sum1']);
        $sum_lux += $luxbrand_array[$i]['sum1'];
    }
        
    for($i=0; $i<count($fashionbrand_array); $i++) {
        $dataset_fashion[] = array($fashionbrand_array[$i]['PTCode'], preg_replace("/\([^)]+\)/","",$fashionbrand_array[$i]['PTDesc1']), $fashionbrand_array[$i]['sum1']);
        $sum_fashion += $fashionbrand_array[$i]['sum1'];
    }

?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <label class="pull-right">Stock Balance - HeadQuarter</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-hq" style="height: 200px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum_hq; ?></u> ชิ้น 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <a id="fancyboxall" href="<?php echo site_url("jes/watch_store"); ?>"><button type="button" class="btn btn-xs btn-primary">แสดงรหัสสาขา</button></a>
                            <label class="pull-right">Stock Balance - All Warehouse</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-brand" style="height: 200px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum_main; ?></u> ชิ้น
                            </div>
                        </div>
                    </div>

                        
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                            <label class="pull-right">Stock Balance - Luxury</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-luxury" style="height: 200px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum_lux; ?></u> ชิ้น
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">   
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <label class="pull-right">Stock Balance - Fashion</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-fashion" style="height: 200px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum_fashion; ?></u> ชิ้น 
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
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.barnumbers.js" type="text/javascript"></script>
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

    //BAR CHART color type
        if ($('#bar-brand').length > 0)
        var all = Morris.Bar({
          element: 'bar-brand',
          resize: true,
          data: [
              <?php for($i=0; $i<count($dataset_brand); $i++) { ?>
            {y: <?php echo json_encode($dataset_brand[$i][0]); ?>, a: <?php echo str_replace( ',', '', json_encode($dataset_brand[$i][1], JSON_NUMERIC_CHECK)); ?>, b: <?php echo str_replace( ',', '', json_encode($dataset_brand[$i][2], JSON_NUMERIC_CHECK)); ?>},
              <?php } ?>
          ],
          barColors: ['#00a65a', '#605ca8'],
          xkey: 'y',
          ykeys: ['a', 'b'],
          labels: ['Luxury Watch', 'Fashion Watch'],
          xLabelMargin: 10,
          hideHover: 'auto'
        }).on('click', function(i, row){
            window.open("<?php echo site_url('jes/watch_viewInventory_whtype')."/".$remark; ?>"+"/"+row.y);
        });
          
        //BAR CHART - HQ
        if ($('#bar-hq').length > 0)
        var ct = Morris.Bar({
          element: 'bar-hq',
          resize: true,
          data: [
              <?php for($i=0; $i<count($dataset_hq); $i++) { ?>
            {y: <?php echo json_encode($dataset_hq[$i][1]); ?>, a: <?php echo str_replace( ',', '', json_encode($dataset_hq[$i][2], JSON_NUMERIC_CHECK)); ?>, b: <?php echo str_replace( ',', '', json_encode($dataset_hq[$i][0])); ?>},
              <?php } ?>
          ],
          barColors: ['#FE2E64'],
          xkey: 'y',
          ykeys: ['a'],
          labels: ['จำนวน'],
          xLabelMargin: 10,
          hideHover: 'auto',
          xLabelAngle: 30
        }).on('click', function(i, row){
            window.open("<?php echo site_url('jes/watch_viewInventory_whtype_brand')."/".$remark; ?>"+"/"+row.b);
        });    
    
        // BAR CHART - ONLY Fashion
        if ($('#bar-fashion').length > 0)
        var ct = Morris.Bar({
          element: 'bar-fashion',
          resize: true,
          data: [
              <?php for($i=0; $i<count($dataset_fashion); $i++) { ?>
            {y: <?php echo json_encode($dataset_fashion[$i][1]); ?>, a: <?php echo str_replace( ',', '', json_encode($dataset_fashion[$i][2], JSON_NUMERIC_CHECK)); ?>, b: <?php echo json_encode($dataset_fashion[$i][0]); ?>},
              <?php } ?>
          ],
          barColors: ['#605ca8'],
          xkey: 'y',
          ykeys: ['a'],
          labels: ['จำนวน'],
          xLabelMargin: 10,
          hideHover: 'auto',
          xLabelAngle: 30
        }).on('click', function(i, row){
            window.open("<?php echo site_url('jes/watch_viewInventory_product'); ?>"+"/"+row.b);
        });
    
        // BAR CHART - ONLY LUXURY
        if ($('#bar-luxury').length > 0)
        var ct = Morris.Bar({
          element: 'bar-luxury',
          resize: true,
          data: [
              <?php for($i=0; $i<count($dataset_lux); $i++) { ?>
            {y: <?php echo json_encode($dataset_lux[$i][1]); ?>, a: <?php echo str_replace( ',', '', json_encode($dataset_lux[$i][2], JSON_NUMERIC_CHECK)); ?>, b: <?php echo json_encode($dataset_lux[$i][0]); ?>},
              <?php } ?>
          ],
          barColors: ['#00a65a'],
          xkey: 'y',
          ykeys: ['a'],
          labels: ['จำนวน'],
          xLabelMargin: 10,
          hideHover: 'auto',
          xLabelAngle: 30
        }).on('click', function(i, row){
            window.open("<?php echo site_url('jes/watch_viewInventory_product'); ?>"+"/"+row.b);
        });
    
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
    
    $('#allstock').on('click', function(){            
            window.location.replace("<?php echo site_url("jes/watch"); ?>");
    });
    
    $('#onlyconsignment').on('click', function(){            
            window.location.replace("<?php echo site_url("jes/watch/1"); ?>");
    });

    $('#noconsignment').on('click', function(){            
            window.location.replace("<?php echo site_url("jes/watch/2"); ?>");
    });
});

</script>
</body>
</html>