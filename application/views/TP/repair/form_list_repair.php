<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายการสินค้าส่งซ่อม
        </h1>
    </section>
	
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                        
        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("tp_repair/result_list_repair"); ?>" name="formfilter" id="formfilter" method="post">
            <div class="col-md-2">
                <div class="form-group">
                เลขที่ใบรับ
                <input type="text" class="form-control" name="number" id="number">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                Ref. Number
                <input type="text" class="form-control" name="refcode" id="refcode">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                ยี่ห้อ
                <select id="brandid" name="brandid" class="form-control">
                    <option value="0" selected>เลือกทั้งหมด</option>
                    <?php foreach($brand_array as $loop) { ?>
                    <option value="<?php echo $loop->br_id; ?>"><?php echo $loop->br_code."-".$loop->br_name; ?></option>
                    <?php } ?>
                    <option value='99999'>-- อื่น ๆ --</option>
                </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                สาขาที่ส่งซ่อม
                <select class="form-control" name="shopid" id="shopid">
                    <option value="0" selected>เลือกทั้งหมด</option>
                <?php 	if(is_array($shop_array)) {
                        foreach($shop_array as $loop){
                            echo "<option value='".$loop->sh_id."'>".$loop->sh_code."-".$loop->sh_name."</option>";
                 } } ?>
                    <option value='99999'>-- อื่น ๆ --</option>
                </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                สถานะการซ่อม
                <select class="form-control" name="status" id="status">
                    <option value="0" selected>เลือกทั้งหมด</option>
                    <option value="G">รับเข้าซ่อม</option>
                    <option value="A">ประเมินการซ่อมแล้ว</option>
                    <option value="D">ซ่อมเสร็จ</option>
                    <option value="C">ซ่อมไม่ได้</option>
                    <option value="R">ส่งกลับแล้ว</option>
                </select>
                </div>
            </div>
        </div> 
        <div class="row">
            
            
            
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-3 col-md-2">
                <div class="col-md-3"><button type="submit" name="action" value="0" class="btn btn-success"><i class="fa fa-search"></i> ค้นหา</button></div>
            </div>
        </div>
    
                        
        </form>               
                        
					</div>
                </div>
            </div>
        </div>
        </div>
        </section>
		</div>
    
    
	</div>


<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    

    
});

</script>
</body>
</html>