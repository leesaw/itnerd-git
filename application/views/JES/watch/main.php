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
            NGG Timepiece - Dashboard
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">

            
<?php 
    
    $dataset_brand = array();
    //$dataset_wh = array();
    $sum = 0;
    for($i=0; $i<count($whcode_array); $i++) {
        $dataset_brand[] = array($whcode_array[$i]['WTCode'], $whcode_array[$i]['luxsum'], $whcode_array[$i]['fashionsum']);
        //$dataset_wh[] = array($whcode_array[$i]['WTCode'], $whcode_array[$i]['WTDesc1']);
        $sum += $whcode_array[$i]['luxsum'] + $whcode_array[$i]['fashionsum'];
    }
    
    for($i=0; $i<count($ct_array); $i++) {
        $dataset_ct[] = array($ct_array[$i]['WHCode'], $ct_array[$i]['luxsum'], $ct_array[$i]['fashionsum']);
    }

?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <a id="fancyboxall" href="<?php echo site_url("jes/watch_store"); ?>"><button type="button" class="btn btn-primary">แสดงรหัสสาขา</button></a>
                            <label class="pull-right">All Warehouse</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-brand" style="height: 300px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum; ?></u> ชิ้น 
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <a id="fancyboxall" href="<?php echo site_url("jes/watch_store"); ?>"><button type="button" class="btn btn-primary">แสดงรหัสสาขา</button></a>
                                <label class="pull-right">Central (Counter)</label>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="bar-ct" style="height: 300px;"></div>
                            </div>
                            <div class="box-footer">
                                จำนวนทั้งหมด <u><?php echo $sum; ?></u> ชิ้น 
                            </div>
                        </div>
                    </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-body">
                                <table class="table table-bordered table-striped" id="tabletask" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Balance(Pcs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $i = 0;
                                        for($i; $i<(count($pt_array)/2); $i++) { ?>
                                        <tr>
                                            <td><?php echo $pt_array[$i]['PTDesc1']; ?></td>
                                            <td width="100"><?php if($pt_array[$i]['sum1']>0) { echo "<a href='".site_url("jes/watch_viewInventory_product")."/".$pt_array[$i]['PTCode']."'>".$pt_array[$i]['sum1']."</a>"; }else{ echo "<code><b>".$pt_array[$i]['sum1']."</b></code>"; }; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div></div>
                        <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-body">
                                <table class="table table-bordered table-striped" id="tabletask" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Balance(Pcs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i; $i<count($pt_array); $i++) { ?>
                                        <tr>
                                            <td><?php echo $pt_array[$i]['PTDesc1']; ?></td>
                                            <td width="100"><?php if($pt_array[$i]['sum1']>0) { echo "<a href='".site_url("jes/watch_viewInventory_product")."/".$pt_array[$i]['PTCode']."'>".$pt_array[$i]['sum1']."</a>"; }else{ echo "<code><b>".$pt_array[$i]['sum1']."</b></code>"; }; ?></td>
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
<script type="text/javascript">

      $(function () {

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
          barColors: ['#00a65a', '#a65aff'],
          xkey: 'y',
          ykeys: ['a', 'b'],
          labels: ['Luxury Watch', 'Fashion Watch'],
          xLabelMargin: 10,
          hideHover: 'auto'
        }).on('click', function(i, row){
            window.location.replace("<?php echo site_url('jes/watch_viewInventory_branch'); ?>"+"/"+row.y);
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
          barColors: ['#5555FF', '#FF0000'],
          xkey: 'y',
          ykeys: ['a', 'b'],
          labels: ['Luxury Watch', 'Fashion Watch'],
          xLabelMargin: 10,
          hideHover: 'auto'
        }).on('click', function(i, row){
            window.location.replace("<?php echo site_url('jes/watch_viewInventory_branch'); ?>"+"/"+row.y);
        });

    });
    
$(document).ready(function()
{
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