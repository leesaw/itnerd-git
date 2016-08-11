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
                <input type="text" class="form-control input-sm" name="number" id="number">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                Ref. Number
                <input type="text" class="form-control input-sm" name="refcode" id="refcode">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                ยี่ห้อ
                <select id="brandid" name="brandid" class="form-control select2" style="width: 100%;">
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
                <select class="form-control select2" name="shopid" id="shopid" style="width: 100%;">
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
                <select class="form-control select2" name="status" id="status" style="width: 100%;">
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
            <div class="col-md-2">
                <div class="form-group">
                เดือนที่ส่งซ่อม
                <input type="text" class="form-control input-sm" name="month" id="month">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                เดือนที่ CS รับ
                <input type="text" class="form-control input-sm" name="month_cs" id="month_cs">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                เดือนที่ส่งกลับ
                <input type="text" class="form-control input-sm" name="month_return" id="month_return">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3 col-md-2">
                <button type="submit" name="action" value="0" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> ค้นหา</button>
            </div>
        </div>
    
                        
        </form>               
                        
					</div>
                </div>
            </div>
        </div>

        <?php 
        $status_got = 0; $status_assess = 0; $status_done = 0; $status_cancel = 0;
        foreach($summary_array as $loop) { 
                if ($loop->rep_status == 'G') $status_got = $loop->count1;
                if ($loop->rep_status == 'A') $status_assess = $loop->count1;
                if ($loop->rep_status == 'D') $status_done = $loop->count1;
                if ($loop->rep_status == 'C') $status_cancel = $loop->count1;
         } ?>
         <!-- Info boxes -->
         <form action="<?php echo site_url("tp_repair/result_list_repair"); ?>" name="formviewstatus" id="formviewstatus" method="post">
            <input type="hidden" name="number" value="">
            <input type="hidden" name="refcode" value="">
            <input type="hidden" name="brandid" value="0">
            <input type="hidden" name="shopid" value="0">
            <input type="hidden" name="status" id="status_all" value="">
         </form>
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-cart-arrow-down"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">รับเข้าซ่อม</span>
                  <span class="info-box-number"><a href="#" onclick="submit_status('G');"><?php echo $status_got; ?></a></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fa fa-wrench"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">ประเมินการซ่อมแล้ว</span>
                  <span class="info-box-number"><a href="#" onclick="submit_status('A');"><?php echo $status_assess; ?></a></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-thumbs-up"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">ซ่อมเสร็จ</span>
                  <span class="info-box-number"><a href="#" onclick="submit_status('D');"><?php echo $status_done; ?></a></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-reply"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">ซ่อมไม่ได้</span>
                  <span class="info-box-number"><a href="#" onclick="submit_status('C');"><?php echo $status_cancel; ?></a></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
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
    //Initialize Select2 Elements
    $(".select2").select2();
    get_datepicker_month("#month");
    get_datepicker_month("#month_cs");
    get_datepicker_month("#month_return");
});
function submit_status(val1)
{
    document.getElementById('status_all').value = val1;
    document.getElementById("formviewstatus").submit();
}

function get_datepicker_month(id)
{
    $(id).datepicker({ language:'th-th',format: "mm/yyyy", viewMode: "months", 
    minViewMode: "months" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
</script>
</body>
</html>