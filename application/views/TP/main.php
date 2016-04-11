<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            NGG | Nerd <small>Timepieces</small>
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
        
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