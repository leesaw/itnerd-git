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
            ประวัติย้ายคลังสินค้า
        </h1>
    </section>
	
	<section class="content">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-primary">
                        
        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("warehouse_transfer/result_search_transfer_item"); ?>" name="formfilter" id="formfilter" method="post">
            <div class="col-xs-8 col-md-4">
                <label>Ref. Number หรือ Description ที่ต้องการค้นหา</label>
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
            <div class="col-xs-2 col-md-2">
                เลือกยี่ห้อ
                <div class="input-group">
                    <select id="brand" name="brand" class="form-control">
                        <option value="0-ทั้งหมด" selected>เลือกทั้งหมด</option>
                        <?php foreach($brand_array as $loop) { ?>
                        <option value="<?php echo $loop->br_id."-".$loop->br_name; ?>"><?php echo $loop->br_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-5 col-md-3">
                เลือก Warehouse
                <div class="input-group">
                    <select id="warehouse" name="warehouse" class="form-control">
                        <option value="0-ทั้งหมด" selected>เลือกทั้งหมด</option>
                        <?php 
                            foreach($whname_array as $loop) { 
                        ?>
                        <option value="<?php echo $loop->wh_id."-".$loop->wh_name; ?>"><?php echo $loop->wh_code."-".$loop->wh_name; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-3 col-md-2">
                เลือกวันที่เริ่มต้น : 
                <input type="text" class="form-control" id="startdate" name="startdate" value="" />
            </div>
            <div class="col-xs-3 col-md-2">
                สิ้นสุด :
                <input type="text" class="form-control" id="enddate" name="enddate" value="" />
            </div>
            <div class="col-xs-3 col-md-2">
                <br>
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
                <div class="col-md-6">
                    <form action="<?php echo site_url("warehouse_transfer/transferstock_history"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
                        <div class="form-group-sm">
                                <label class="col-sm-2 control-label">เลือกเดือน</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $currentdate; ?>" onChange="submitform();" autocomplete="off" readonly>
                            </div>  
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading">
                        <h4>รายการสินค้าย้ายคลังของเดือน <?php echo $month; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่ย้ายคลังสินค้า</th>
                                        <th>วันที่</th>
                                        <th>ออกจากคลัง</th>
										<th>เข้าคลัง</th>
                                        <th>ผู้ทำรายการ</th>
                                        <th>สถานะ</th>
                                        <th width="80">ใบส่งของ</th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($final_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->stot_number; ?></td>
                                        <td><?php echo $loop->stot_datein; ?></td>
                                        <td><?php echo $loop->wh_out_code."-".$loop->wh_out_name; ?></td>
                                        <td><?php echo $loop->wh_in_code."-".$loop->wh_in_name; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><?php if($loop->stot_status==1) { echo "<a href='";
                                        if($loop->stot_has_serial==0) echo site_url("warehouse_transfer/transferstock_print")."/".$loop->stot_id; else echo site_url("warehouse_transfer/transferstock_print_serial")."/".$loop->stot_id;
                                        echo "' target='blank'><button class='btn btn-xs btn-danger'>รอยืนยันจำนวนสินค้า</button></a>"; } if($loop->stot_status==2) echo "<button class='btn btn-xs btn-success'>ย้ายสินค้าเรียบร้อยแล้ว</button>"; if($loop->stot_status==3) echo "<button class='btn btn-xs btn-warning'>ยกเลิกแล้ว</button>"; ?></td>
                                        <td>
                                        <?php if ($loop->stot_status==2) { ?>
                                        <a href="<?php if($loop->stot_has_serial==0) echo site_url("warehouse_transfer/transferstock_final_print")."/".$loop->stot_id; else echo site_url("warehouse_transfer/transferstock_final_print_serial")."/".$loop->stot_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-print"></span></a> 
                                        &nbsp;
                                        <a href="<?php if($loop->stot_has_serial==0) echo site_url("warehouse_transfer/transferstock_final_excel")."/".$loop->stot_id; else echo site_url("warehouse_transfer/transferstock_final_print_excel")."/".$loop->stot_id; ?>" class="btn bg-maroon btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="Excel"><i class="fa fa-download"></i></a>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
								</tbody>
							</table>
                        
					</div>
                    
				</div>
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
    get_datepicker("#startdate");
    get_datepicker("#enddate");
    get_datepicker_month("#datein");
    
    var oTable = $('#tablefinal').DataTable();
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
    
});
    
function get_datepicker_month(id)
{
    $(id).datepicker({ language:'th-th',format: "mm/yyyy", viewMode: "months", 
    minViewMode: "months" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}
    
function submitform()
{
    document.getElementById("form1").submit();
}
</script>
</body>
</html>