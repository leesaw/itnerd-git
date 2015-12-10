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
    $dataset_ct = array();
    $dataset_mg = array();
    $dataset_rb = array();
    //$dataset_wh = array();
    $sum_main = 0;
    $sum_ct = 0;
    $sum_mg = 0;
    $sum_rb = 0;
    for($i=0; $i<count($whcode_array); $i++) {
        $dataset_brand[] = array($whcode_array[$i]['WTCode'], $whcode_array[$i]['luxsum'], $whcode_array[$i]['fashionsum']);
            //$dataset_wh[] = array($whcode_array[$i]['WTCode'], $whcode_array[$i]['WTDesc1']);
        $sum_main += $whcode_array[$i]['luxsum'] + $whcode_array[$i]['fashionsum'];
    }
    
    for($i=0; $i<count($ct_array); $i++) {
        $dataset_ct[] = array($ct_array[$i]['WHCode'], $ct_array[$i]['luxsum'], $ct_array[$i]['fashionsum']);
        $sum_ct += $ct_array[$i]['luxsum'] + $ct_array[$i]['fashionsum'];
    }
        
    for($i=0; $i<count($mg_array); $i++) {
        $dataset_mg[] = array($mg_array[$i]['WHCode'], $mg_array[$i]['luxsum'], $mg_array[$i]['fashionsum']);
        $sum_mg += $mg_array[$i]['luxsum'] + $mg_array[$i]['fashionsum'];
    }
        
    for($i=0; $i<count($rb_array); $i++) {
        $dataset_rb[] = array($rb_array[$i]['WHCode'], $rb_array[$i]['luxsum'], $rb_array[$i]['fashionsum']);
        $sum_rb += $rb_array[$i]['luxsum'] + $rb_array[$i]['fashionsum'];
    }

?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
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
                                <div class="pull-right">
                                <i class="fa fa-circle text-green"></i> Luxury Watch 
                                <i class="fa fa-circle text-purple"></i> Fashion Watch 
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <a id="fancyboxall" href="<?php echo site_url("jes/watch_store_departmentstore/ct"); ?>"><button type="button" class="btn btn-xs btn-primary">แสดงรหัสสาขา</button></a>
                                <label class="pull-right">Stock Balance - Central (Counter)</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-ct" style="height: 200px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum_ct; ?></u> ชิ้น 
                                <div class="pull-right">
                                <i class="fa fa-circle text-green"></i> Luxury Watch 
                                <i class="fa fa-circle text-purple"></i> Fashion Watch 
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <a id="fancyboxall" href="<?php echo site_url("jes/watch_store_departmentstore/mg"); ?>"><button type="button" class="btn btn-xs btn-primary">แสดงรหัสสาขา</button></a>
                            <label class="pull-right">Stock Balance - The Mall (Counter)</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-mg" style="height: 200px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum_mg; ?></u> ชิ้น
                                <div class="pull-right">
                                <i class="fa fa-circle text-green"></i> Luxury Watch 
                                <i class="fa fa-circle text-purple"></i> Fashion Watch 
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <a id="fancyboxall" href="<?php echo site_url("jes/watch_store_departmentstore/rb"); ?>"><button type="button" class="btn btn-xs btn-primary">แสดงรหัสสาขา</button></a>
                                <label class="pull-right">Stock Balance - Robinson (Counter)</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-rb" style="height: 200px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum_rb; ?></u> ชิ้น 
                                <div class="pull-right">
                                <i class="fa fa-circle text-green"></i> Luxury Watch 
                                <i class="fa fa-circle text-purple"></i> Fashion Watch 
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                        <div class="box box-success">
                            <div class="box-body">
                                <table class="table table-bordered table-striped" id="tabletask" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Luxury Brand</th>
                                            <th>Balance(Pcs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        for($i=0; $i<(count($luxbrand_array)); $i++) { ?>
                                        <tr>
                                            <td><?php echo $luxbrand_array[$i]['PTDesc1']; ?></td>
                                            <td width="100"><?php if($luxbrand_array[$i]['sum1']>0) { echo "<a href='".site_url("jes/watch_viewInventory_product")."/".$luxbrand_array[$i]['PTCode']."'>".$luxbrand_array[$i]['sum1']."</a>"; }else{ echo "<code><b>".$luxbrand_array[$i]['sum1']."</b></code>"; }; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div></div>
                        <div class="col-md-4">
                        <div class="box box-success">
                            <div class="box-body">
                                <table class="table table-bordered table-striped" id="tabletask" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Fashion Brand</th>
                                            <th>Balance(Pcs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i=0; $i<count($fashionbrand_array); $i++) { ?>
                                        <tr>
                                            <td><?php echo $fashionbrand_array[$i]['PTDesc1']; ?></td>
                                            <td width="100"><?php if($fashionbrand_array[$i]['sum1']>0) { echo "<a href='".site_url("jes/watch_viewInventory_product")."/".$fashionbrand_array[$i]['PTCode']."'>".$fashionbrand_array[$i]['sum1']."</a>"; }else{ echo "<code><b>".$fashionbrand_array[$i]['sum1']."</b></code>"; }; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div></div>
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
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>WTCode
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
          
        
        //BAR CHART - CT
        if ($('#bar-ct').length > 0)
        var ct = Morris.Bar({
          element: 'bar-ct',
          resize: true,
          data: [
              <?php for($i=0; $i<count($dataset_ct); $i++) { ?>
            {y: <?php echo json_encode($dataset_ct[$i][0]); ?>, a: <?php echo str_replace( ',', '', json_encode($dataset_ct[$i][1], JSON_NUMERIC_CHECK)); ?>, b: <?php echo str_replace( ',', '', json_encode($dataset_ct[$i][2], JSON_NUMERIC_CHECK)); ?>},
              <?php } ?>
          ],
          barColors: ['#00a65a', '#605ca8'],
          xkey: 'y',
          ykeys: ['a', 'b'],
          labels: ['Luxury Watch', 'Fashion Watch'],
          xLabelMargin: 10,
          hideHover: 'auto'
        }).on('click', function(i, row){
            window.open("<?php echo site_url('jes/watch_viewInventory_branch')."/".$remark; ?>"+"/"+row.y);
        });
          
        //BAR CHART - MG
        if ($('#bar-mg').length > 0)
        var ct = Morris.Bar({
          element: 'bar-mg',
          resize: true,
          data: [
              <?php for($i=0; $i<count($dataset_mg); $i++) { ?>
            {y: <?php echo json_encode($dataset_mg[$i][0]); ?>, a: <?php echo str_replace( ',', '', json_encode($dataset_mg[$i][1], JSON_NUMERIC_CHECK)); ?>, b: <?php echo str_replace( ',', '', json_encode($dataset_mg[$i][2], JSON_NUMERIC_CHECK)); ?>},
              <?php } ?>
          ],
          barColors: ['#00a65a', '#605ca8'],
          xkey: 'y',
          ykeys: ['a', 'b'],
          labels: ['Luxury Watch', 'Fashion Watch'],
          xLabelMargin: 10,
          hideHover: 'auto'
        }).on('click', function(i, row){
            window.open("<?php echo site_url('jes/watch_viewInventory_branch')."/".$remark; ?>"+"/"+row.y);
        });
          
        //BAR CHART - RB
        if ($('#bar-rb').length > 0)
        var ct = Morris.Bar({
          element: 'bar-rb',
          resize: true,
          data: [
              <?php for($i=0; $i<count($dataset_rb); $i++) { ?>
            {y: <?php echo json_encode($dataset_rb[$i][0]); ?>, a: <?php echo str_replace( ',', '', json_encode($dataset_rb[$i][1], JSON_NUMERIC_CHECK)); ?>, b: <?php echo str_replace( ',', '', json_encode($dataset_rb[$i][2], JSON_NUMERIC_CHECK)); ?>},
              <?php } ?>
          ],
          barColors: ['#00a65a', '#605ca8'],
          xkey: 'y',
          ykeys: ['a', 'b'],
          labels: ['Luxury Watch', 'Fashion Watch'],
          xLabelMargin: 10,
          hideHover: 'auto'
        }).on('click', function(i, row){
            window.open("<?php echo site_url('jes/watch_viewInventory_branch')."/".$remark; ?>"+"/"+row.y);
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