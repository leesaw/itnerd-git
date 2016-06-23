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
            รายงาน-ย้ายคลังสินค้า
        </h1>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-danger">
					<div class="panel-heading">
                        <h4>รายงานย้ายคลังสินค้าที่กำลังดำเนินการ <a href="<?php echo site_url("warehouse_transfer/undo_confirm_transfer_between"); ?>" class="btn btn-warning btn-sm pull-right" id="lastconfirm" name="lastconfirm">ยกเลิกการยืนยัน</a></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่ย้ายคลังสินค้า</th>
                                        <th>วันที่กำหนดส่ง</th>
                                        <th>ออกจากคลัง</th>
										<th>เข้าคลัง</th>
                                        <th>ผู้ทำรายการ</th>
                                        <th>สถานะ</th>
                                        <th width="80"> </th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($transfer_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->stot_number; ?></td>
                                        <td><?php echo $loop->stot_datein; ?></td>
                                        <td><?php echo $loop->wh_out_code."-".$loop->wh_out_name; ?></td>
                                        <td><?php echo $loop->wh_in_code."-".$loop->wh_in_name; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><?php if($loop->stot_status==1) echo "<button class='btn btn-xs btn-danger'>รอยืนยันจำนวนสินค้า</button>"; ?></td>
                                        <td><a href="<?php if($loop->stot_has_serial==0) echo site_url("warehouse_transfer/transferstock_print")."/".$loop->stot_id; else echo site_url("warehouse_transfer/transferstock_print_serial")."/".$loop->stot_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-print"></span></a> 
                                        <a href="<?php if($loop->stot_has_serial==0) echo site_url("warehouse_transfer/confirm_transfer_between")."/".$loop->stot_id; else echo site_url("warehouse_transfer/confirm_transfer_between_serial")."/".$loop->stot_id; ?>" class="btn btn-success btn-xs" data-title="ยืนยันจำนวนสินค้า" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="ยืนยันจำนวนสินค้า"><i class="fa fa-check-square-o"></i></a>
                                        <a href="<?php if($loop->stot_has_serial==0) echo site_url("warehouse_transfer/disable_transfer_between")."/".$loop->stot_id; else echo site_url("warehouse_transfer/disable_transfer_between_serial")."/".$loop->stot_id; ?>" class="btn btn-danger btn-xs" data-title="ยกเลิก" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="ยกเลิก"><i class="fa fa-remove"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
								</tbody>
							</table>
                        
					</div>
                    
				</div>
			</div>	
            
		</div>  
            <!--
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading">
                        <h4>รายการย้ายคลังสินค้าของเดือน <?php echo $month; ?></h4>
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
                                        <th> </th>
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
             -->           
                        
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
<script type="text/javascript">
$(document).ready(function()
{    
    var oTable = $('#tablebarcode').DataTable();
    var oTable = $('#tablefinal').DataTable();
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