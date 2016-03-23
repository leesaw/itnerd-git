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
            <div class="col-xs-8 col-md-4">
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
            <div class="col-xs-5 col-md-3">
                เลือกยี่ห้อ
                <div class="input-group">
                    <select id="brand" name="brand" class="form-control">
                        <option value="0" selected>เลือกทั้งหมด</option>
                        <?php foreach($brand_array as $loop) { ?>
                        <option value="<?php echo $loop->br_id; ?>"><?php echo $loop->br_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-5 col-md-3">
                เลือก Warehouse
                <div class="input-group">
                    <select id="warehouse" name="warehouse" class="form-control">
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
            <div class="col-xs-3 col-md-2">
                ราคาต่ำสุด
                <div class="input-group">
                    <input type="text" class="form-control" name="minprice" id="minprice">
                </div>
            </div>
            <div class="col-xs-3 col-md-2">
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
        </section>
          
          
          
</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script type="text/javascript">
    
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