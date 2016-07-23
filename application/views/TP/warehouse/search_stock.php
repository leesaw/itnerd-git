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
            Stock Balance
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
            <div class="col-md-10">
                <div class="box box-primary">
                        
        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("warehouse/showBalance"); ?>" method="post">
            <div class="col-md-4">
                Ref. Number หรือ Description ที่ต้องการค้นหา
                <div class="input-group">
                    <input type="text" class="form-control" name="refcode" id="refcode">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success"><i class='fa fa-search'></i></button>
                    </div>
                </div>
            </div>
        </div> 
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group-sm">
                    เลือกยี่ห้อ
                    <select id="brand" name="brand" class="form-control select2" style="width: 100%;">
                        <option value="0" selected>เลือกทั้งหมด</option>
                        <?php foreach($brand_array as $loop) { ?>
                        <option value="<?php echo $loop->br_id; ?>"><?php echo $loop->br_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    เลือก Warehouse

                    <select id="warehouse" name="warehouse" class="form-control select2" style="width: 100%;">
                        <option value="0" selected>เลือกทั้งหมด</option>
                        <?php 
                            foreach($whname_array as $loop) { 
                        ?>
                        <option value="<?php echo $loop->wh_id; ?>"><?php echo $loop->wh_code."-".$loop->wh_name; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                ราคาต่ำสุด
                <div class="input-group">
                    <input type="text" class="form-control" name="minprice" id="minprice">
                </div>
            </div>
            <div class="col-md-2">
                ราคาสูงสุด
                <div class="input-group">
                    <input type="text" class="form-control" name="maxprice" id="maxprice">
                </div>
            </div>
            
        </div>
        <br>
            <div class="row"><div class="col-md-3"><button type="submit" name="action" value="0" class="btn btn-success"><i class="fa fa-search"></i> ค้นหา</button></div></div>              
                        
        </form>               
                        
					</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-primary">
                    <div class="panel-heading">ค้นหาเฉพาะ Caseback</div>
        <div class="panel-body">
        <div class="row">
            <form action="<?php echo site_url("warehouse/showSerial"); ?>" method="post">
            <div class="col-xs-3 col-md-3">
                Caseback ที่ต้องการค้นหา
                <input type="text" class="form-control" name="serial" id="serial">
            </div>
            <div class="col-xs-3 col-md-3">
            <br><button type="submit" name="action" value="0" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา</button></div>              
                        
        </form>               
                        
					</div>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">จำนวนสินค้าในทุกสาขา</div>
        <div class="panel-body table-responsive">
        <div class="row">
            <div class="col-xs-4">
                <table class="table table-bordered" id="tablebarcode" width="100%">
                    <thead>
                    <tr><th>No.</th><th>สาขา</th><th>จำนวน</th></tr>
                    </thead>
                    <tbody>
                    <?php 
                        $divide = ceil(count($number_array) / 3);
                        $count_row = 1;
                        foreach($number_array as $elementKey => &$element) { ?>
                    <tr><td><?php echo $count_row; ?></td><td><?php echo $element->wh_code."-".$element->wh_name; ?></td><td><form action="<?php echo site_url("warehouse/showBalance"); ?>" method="post"><input type="hidden" name="warehouse" value="<?php echo $element->stob_warehouse_id; ?>"><input type="hidden" name="brand" value="0"><a href="javascript:;" onclick="parentNode.submit();"><?php echo $element->sum1; ?></a></form></td></tr>
                    <?php  
                        unset($number_array[$elementKey]); 
                        if ($count_row >= $divide) break;
                        $count_row++;
                        } 
                    ?>
                    <tr></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-4">
                <table class="table table-bordered" id="tablebarcode" width="100%">
                    <thead>
                    <tr><th>No.</th><th>สาขา</th><th>จำนวน</th></tr>
                    </thead>
                    <tbody>
                    <?php 
                        $count_row = 1;
                        foreach($number_array as $elementKey => &$element) { ?>
                    <tr><td><?php echo $divide+$count_row; ?></td><td><?php echo $element->wh_code."-".$element->wh_name; ?></td><td><form action="<?php echo site_url("warehouse/showBalance"); ?>" method="post"><input type="hidden" name="warehouse" value="<?php echo $element->stob_warehouse_id; ?>"><input type="hidden" name="brand" value="0"><a href="javascript:;" onclick="parentNode.submit();"><?php echo $element->sum1; ?></a></form></td></tr>
                    <?php  
                        unset($number_array[$elementKey]); 
                        if ($count_row >= $divide) break;
                        $count_row++;
                        } 
                    ?>
                    <tr></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-4">
                <table class="table table-bordered" id="tablebarcode" width="100%">
                    <thead>
                    <tr><th>No.</th><th>สาขา</th><th>จำนวน</th></tr>
                    </thead>
                    <tbody>
                    <?php 
                        $count_row++;
                        foreach($number_array as $elementKey => &$element) { ?>
                    <tr><td><?php echo $divide+$count_row; ?></td><td><?php echo $element->wh_code."-".$element->wh_name; ?></td><td><form action="<?php echo site_url("warehouse/showBalance"); ?>" method="post"><input type="hidden" name="warehouse" value="<?php echo $element->stob_warehouse_id; ?>"><input type="hidden" name="brand" value="0"><a href="javascript:;" onclick="parentNode.submit();"><?php echo $element->sum1; ?></a></form></td></tr>
                    <?php  
                        $count_row++;
                        } 
                    ?>
                    <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        </section>
          
          
          
</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script type="text/javascript">
    
$(document).ready(function()
{    
    //Initialize Select2 Elements
    $(".select2").select2();

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