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
            รายการย้ายคลังสินค้าที่กำลังดำเนินการ
        </h1>
    </section>
	
	<section class="content">
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
                                    <?php foreach($transfer_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->stot_number; ?></td>
                                        <td><?php echo $loop->stot_datein; ?></td>
                                        <td><?php echo $loop->wh_out_code."-".$loop->wh_out_name; ?></td>
                                        <td><?php echo $loop->wh_in_code."-".$loop->wh_in_name; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><?php if($loop->stot_status==1) echo "<button class='btn btn-xs btn-danger'>รอยืนยันจำนวนสินค้า</button>"; ?></td>
                                        <td><a href="<?php if($loop->stot_has_serial==0) echo site_url("warehouse_transfer/transferstock_print")."/".$loop->stot_id; else echo site_url("warehouse_transfer/transferstock_print_serial")."/".$loop->stot_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-print"></span></a> 
                                        <a href="<?php if($loop->stot_has_serial==0) echo site_url("warehouse_transfer/confirm_transfer_between")."/".$loop->stot_id; else echo site_url("warehouse_transfer/confirm_transfer_between_serial")."/".$loop->stot_id; ?>" class="btn btn-success btn-xs" data-title="ยืนยันจำนวนสินค้า" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="ยืนยันจำนวนสินค้า"><i class="fa fa-check-square-o"></i></a></td>
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
<script type="text/javascript">
$(document).ready(function()
{    
    var oTable = $('#tablebarcode').DataTable();
    
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