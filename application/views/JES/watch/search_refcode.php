<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-purple">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Search <small>NGG Timepieces</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("jes/watch"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Search</li>
        </ol>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
            <div class="col-md-10">
                <div class="box box-primary">
                        
        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("jes/show_refcode"); ?>" method="post">
            <div class="col-xs-8 col-md-4">
                <label>Ref. Code หรือ Description ที่ต้องการค้นหา</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="refcode" id="refcode">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success"><i class='fa fa-search'></i></button>
                    </div>
                </div>
            </div>

        </div> 
        <br>
        <?php if ($session_user==2) { ?>
        <div class="row">
            <div class="col-xs-5 col-md-3">
                <label>เลือกยี่ห้อ</label>
                <div class="input-group">
                    <select id="brand" name="brand" class="form-control">
                        <option value="0" selected>เลือกทั้งหมด</option>
                        <?php foreach($brand_array as $loop) { ?>
                        <option value="<?php echo $loop->PTCode; ?>"><?php echo $loop->PTDesc1; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-5 col-md-3">
                <label>เลือก Warehouse</label>
                <div class="input-group">
                    <select id="warehouse" name="warehouse" class="form-control">
                        <option value="0" selected>เลือกทั้งหมด</option>
                        <?php 
                            for($i=0; $i<count($whname_array); $i++) {
                                foreach($whname_array[$i]["wh"] as $loop2) { 
                        ?>
                        <option value="<?php echo $loop2->WHCode; ?>"><?php echo $whname_array[$i]["WHType"]."-".$loop2->WHDesc1; ?>
                        </option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-3 col-md-2">
                <label>ราคาต่ำสุด</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="minprice" id="minprice">
                </div>
            </div>
            <div class="col-xs-3 col-md-2">
                <label>ราคาสูงสุด</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="maxprice" id="maxprice">
                </div>
            </div>
            
        </div>
        <br>
            <div class="row"><div class="col-md-3"><button type="submit" name="action" value="0" class="btn btn-success"><i class="fa fa-search"></i> ค้นหา</button></div></div>
        <?php } ?>                
                        
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