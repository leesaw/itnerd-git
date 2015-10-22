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
            Reports <small>NGG Timepieces</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("jes/watch"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Reports</li>
        </ol>
    </section>
	<!-- Main content -->
    <section class="content">
        <form action="<?php echo site_url("jes/report_filter"); ?>" method="post" target="_blank">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                            
                                <div class="col-md-4">
                                    <!-- warehouse type checkbox -->
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                        
                                            Warehouse Type
                                        <label class="pull-right text-black"><input type="checkbox" name="all_whtype" id="all_whtype" onClick="toggle_all(this)"> ทั้งหมด</label>
                                        </div>
                                        <div class="panel-body">
                                <?php if(is_array($whtype_array)) { 						                      						foreach($whtype_array as $loop){ $wh_array[] = $loop->WTCode; ?>
                                            <div class="checkbox">
                                                <label>
                                                <input type="checkbox" name="whtype_<?php echo $loop->WTCode; ?>" id="whtype_<?php echo $loop->WTCode; ?>" value="<?php echo $loop->WTCode; ?>" onClick="toggle(this,'whname_<?php echo $loop->WTCode; ?>[]')">
                                                <?php echo "<b>".$loop->WTCode." - ".$loop->WTDesc1."</b>"; ?>
                                                </label>
                                            </div>
                                    <?php if(is_array($whname_array)) { 	
                                            $count=0; 
                                            for($i=0; $i<count($whname_array); $i++) {
                                              foreach($whname_array[$i]["wh"] as $loop2) { 
                                                if ($loop->WTCode==$whname_array[$i]["WHType"]) {
                                                    if ($count==0) echo "<ul>"; $count++;
                                    ?>
                                                <div class="checkbox">
                                                <label>
                                                <input type="checkbox" name="whname_<?php echo $loop->WTCode; ?>[]" id="whname_<?php echo $loop->WTCode; ?>" value="<?php echo $loop2->WHCode; ?>">
                                                <?php echo $loop2->WHDesc1; ?>
                                                </label>
                                            </div>
                                    <?php } } } if ($count>0) echo "</ul>"; } ?>
                                <?php }} ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- product type checkbox -->
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">Brand
                                        <label class="pull-right text-black"><input type="checkbox" name="all_whtype" id="all_ptype" onClick="toggle_all_product(this)"> ทั้งหมด</label>
                                        </div>
                                        <div class="panel-body">
                                            <label><input type="checkbox" name="ptype_lux_all" id="ptype_lux_all" value="0" onClick="toggle(this,'ptype_lux[]')"> Luxury</label>
                                <?php if(is_array($lux_array)) {  ?>
                                        <ul>
                                <?php    foreach($lux_array as $loop){ ?>
                                            <div class="checkbox">
                                                <label>
                                                <input type="checkbox" name="ptype_lux[]" id="ptype_lux[]" value="<?php echo $loop->PTCode ?>">
                                                <?php echo $loop->PTDesc1; ?>
                                                </label>
                                            </div>
                                <?php } ?> </ul> <?php } ?>
                                <label><input type="checkbox" name="ptype_fashion_all" id="ptype_fashion_all" value="0" onClick="toggle(this,'ptype_fashion[]')"> Fashion</label>
                                <?php if(is_array($fashion_array)) {  ?>
                                        <ul>
                                <?php    foreach($fashion_array as $loop){ ?>
                                            <div class="checkbox">
                                                <label>
                                                <input type="checkbox" name="ptype_fashion[]" id="ptype_fashion[]" value="<?php echo $loop->PTCode ?>">
                                                <?php echo $loop->PTDesc1; ?>
                                                </label>
                                            </div>
                                <?php } ?> </ul> <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-warning">
                                        <div class="panel-body">
                                            <button type="submit" name="action" value="0" class="btn btn-success"><i class="fa fa-fw fa-bar-chart"></i> Stock Balance Report</button>
                                            <br> <br>
                                            <button type="submit" name="action" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> Stock Item List Report</button>
                                        </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
                        </form>
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
<script type="text/javascript">
function toggle(source,checkboxname) {
  checkboxes = document.getElementsByName(checkboxname);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
    

    
function toggle_all(source) {
    var wh_array = <?php echo json_encode($wh_array); ?>;
    
    for (var j=0; j < wh_array.length; j++) {
        checkboxes = document.getElementsByName('whtype_'+wh_array[j]);
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
        checkboxes = document.getElementsByName('whname_'+wh_array[j]+'[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
        
    }
    
}
    
function toggle_all_product(source) {
    checkboxes = document.getElementsByName('ptype_lux_all');
    for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
    }
    checkboxes = document.getElementsByName('ptype_fashion_all');
    for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
    }
    checkboxes = document.getElementsByName('ptype_lux[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
    }
    checkboxes = document.getElementsByName('ptype_fashion[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
    }
}
    
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