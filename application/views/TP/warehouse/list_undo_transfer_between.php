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
            รายงาน-ยกเลิกย้ายคลังสินค้า
        </h1>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-warning">
					<div class="panel-heading">
                        <h4>รายงานย้ายคลังสินค้าที่สามารถยกเลิกได้ (ไม่เกิน 7 วัน) <a href="<?php echo site_url("warehouse_transfer/report_transferstock"); ?>" class="btn btn-danger btn-sm pull-right" id="lastconfirm" name="lastconfirm">รายงานย้ายคลังที่กำลังดำเนินการ</a></h4>
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
                                    <?php foreach($final_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->stot_number; ?></td>
                                        <td><?php echo $loop->stot_datein; ?></td>
                                        <td><?php echo $loop->wh_out_code."-".$loop->wh_out_name; ?></td>
                                        <td><?php echo $loop->wh_in_code."-".$loop->wh_in_name; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><?php if($loop->stot_status==1) { echo "<a href='";
                                        if($loop->stot_has_serial==0) echo site_url("warehouse_transfer/transferstock_print")."/".$loop->stot_id; else echo site_url("warehouse_transfer/transferstock_print_serial")."/".$loop->stot_id;
                                        echo "' target='blank'><button class='btn btn-xs btn-danger'>รอยืนยันจำนวนสินค้า</button></a>"; } if($loop->stot_status==2) echo "<button class='btn btn-xs btn-success'>ย้ายสินค้าเรียบร้อยแล้ว</button>"; if($loop->stot_status==3) echo "<button class='btn btn-xs btn-warning'>ยกเลิกแล้ว</button>"; if($loop->stot_status==4) echo "<button class='btn btn-xs bg-navy'>ย้ายสินค้าเรียบร้อยแล้ว(สวม)</button>"; ?></td>
                                        <td><?php if ($loop->stot_status==2 || $loop->stot_status==4) { ?>
                                        <a href="<?php echo site_url("warehouse_transfer/transferstock_final_print")."/".$loop->stot_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-print"></span></a> 
                                        
                                        <a href="#" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="tooltip" data-target="#delete" data-placement="top" rel="tooltip" title="ยกเลิก" onClick="del_confirm(<?php echo $loop->stot_id.",'".$loop->stot_number; ?>')"><span class="glyphicon glyphicon-remove"></span></a>
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
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
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
    
function del_confirm(val1, val2) {
	bootbox.confirm("ต้องการยกเลิกเลขที่ย้ายคลัง "+val2+" ใช่หรือไม่ ?", function(result) {
        if (result) {
            $.ajax({
                type : "POST" ,
                url : "<?php echo site_url("warehouse_transfer/check_undo_transfer_between"); ?>" ,
                data : { stot_id: val1 } ,
                dataType: 'json',
                success : function(data) {
                    if (data.a>0) {
                        $.ajax({
                            type : "POST" ,
                            url : "<?php echo site_url("warehouse_transfer/save_undo_transfer_between"); ?>" ,
                            data : { stot_id: val1 } ,
                            dataType: 'json',
                            success : function(data) {
                                var message = "ทำการบันทึกเรียบร้อยแล้ว";
                                bootbox.alert(message, function() {
                                    location.reload();

                                });
                            },
                            error: function (textStatus, errorThrown) {
                                alert("เกิดความผิดพลาด !!!");
                            }
                        });
                    }else{
                        alert("ไม่สามารถยกเลิกการยืนยันได้ !!!");
                    }
                },
                error: function (textStatus, errorThrown) {
                    alert("เกิดความผิดพลาด !!!");
                }
            });
            
            

        }

    });

} 
</script>
</body>
</html>