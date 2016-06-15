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
                <input type="text" class="form-control" name="number" id="number" value="<?php if ($number != "NULL") echo $number; ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                Ref. Number
                <input type="text" class="form-control" name="refcode" id="refcode" value="<?php if ($refcode != "NULL") echo $refcode; ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                ยี่ห้อ
                <select id="brandid" name="brandid" class="form-control">
                    <option value="0"<?php if($brandid==0) echo " selected"; ?>>เลือกทั้งหมด</option>
                    <?php foreach($brand_array as $loop) { ?>
                    <option value="<?php echo $loop->br_id; ?>"<?php if($brandid==$loop->br_id) echo " selected"; ?>><?php echo $loop->br_code."-".$loop->br_name; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                สาขาที่ส่งซ่อม
                <select class="form-control" name="shopid" id="shopid">
                    <option value="0"<?php if($shopid==0) echo " selected"; ?>>เลือกทั้งหมด</option>
                <?php 	if(is_array($shop_array)) {
                        foreach($shop_array as $loop){
                            echo "<option value='".$loop->sh_id."'";
                            if ($shopid==$loop->sh_id) echo " selected";
                            echo ">".$loop->sh_code."-".$loop->sh_name."</option>";
                 } } ?>
                </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                สถานะการซ่อม
                <select class="form-control" name="status" id="status">
                    <option value="0"<?php if($status=='0') echo " selected"; ?>>เลือกทั้งหมด</option>
                    <option value="G"<?php if($status=='G') echo " selected"; ?>>รับเข้าซ่อม</option>
                    <option value="A"<?php if($status=='A') echo " selected"; ?>>ประเมินการซ่อมแล้ว</option>
                    <option value="D"<?php if($status=='D') echo " selected"; ?>>ซ่อมเสร็จ</option>
                    <option value="C"<?php if($status=='C') echo " selected"; ?>>ซ่อมไม่ได้</option>
                    <option value="R"<?php if($status=='R') echo " selected"; ?>>ส่งกลับแล้ว</option>
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
        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading">
                        
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th width="80">วันที่ส่งซ่อม</th>
                                        <th width="80">เลขที่ใบรับ</th>
                                        <th>Ref. Number</th>
                                        <th>ยี่ห้อ</th>
                                        <th>สาขาที่ส่งซ่อม</th>
                                        <th>รายละเอียดลูกค้า</th>
                                        <th>อาการ</th>
                                        <th>สถานะ</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                
								<tbody>
								</tbody>
                                <tfoot>
                                   
                                </tfoot>
							</table>
                        
					</div>
                    
				</div>
			</div>	
            
		</div>
        <div class="row">
            <div class="col-xs-12">
            <a href="<?php echo site_url("warehouse_transfer/transferstock_history"); ?>" class="btn btn-primary">ค้นหา</a>    
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
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    var oTable = $('#tablebarcode').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("tp_repair/ajaxView_seach_repair")."/".$number."/".$refcode."/".$brandid."/".$shopid."/".$status; ?>',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success":fnCallback

            });
        }
    });
});

</script>
</body>
</html>