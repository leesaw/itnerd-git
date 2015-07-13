<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
</head>

<body class="skin-purple">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>
    <?php $url = site_url("task/finishtask"); 
          $url2 = site_url("task/canceltask"); 
          $url3 = site_url("task/gottask");
        ?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แสดงงานทั้งหมด
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> แสดงงานทั้งหมด</a></li>
        </ol>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">

                        
        <div class="box-body">
            
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><a class="btn btn-primary" href="<?php echo site_url("task/addtask"); ?>"><i class="fa fa-plus"></i> <b>เพิ่มงานใหม่</b></a> 
                        <?php if ($user_status==1) { ?>
                        &nbsp; &nbsp;<a class="btn btn-success" href="<?php echo site_url("task/viewtask_finish"); ?>"><i class="fa fa-check"></i> <b>งานที่ปิดแล้ว</b></a>
                        &nbsp; &nbsp;<a class="btn btn-danger" href="<?php echo site_url("task/viewtask_finish"); ?>"><i class="fa fa-search"></i> <b>งานเกินกำหนด</b></a>
                        &nbsp; &nbsp;<a class="btn btn-info" href="<?php echo site_url("task/viewtask_finish"); ?>"><i class="fa fa-search"></i> <b>งานกำลังดำเนินการ</b></a>
                        &nbsp; &nbsp;<a class="btn btn-warning" href="<?php echo site_url("task/viewtask_finish"); ?>"><i class="fa fa-search"></i> <b>งานที่ยังไม่รับ</b></a>
                        <?php } ?>
                    </div>
                    <div class="panel-body">
                            <table class="table table-bordered table-striped" id="tabletask" width="100%">
                                <thead>
                                    <tr>
                                        <th width="100">วันที่เสร็จสิ้น</th>
                                        <th>หัวข้องาน</th>
                                        <th>ประเภท</th>
                                        <th width="300">รายละเอียด</th>
                                        <th>ผู้สั่งงาน</th>
                                        <?php if ($user_status==1) { ?><th>ผู้ปฏิบัติงาน</th> <?php } ?>
										<th width="100"> </th>
                                    </tr>
                                </thead>
                                
								<tbody>
								<?php if(isset($task_array)) { foreach($task_array as $loop) { 
                                    $phpdate = strtotime($loop->taskdateon);
                                    $date = date( 'd/m/Y', $phpdate );
                                    $datehidden = date('Y/m/d', $phpdate);
								?>
                                    <tr><td><span class="hide"><?php echo $datehidden; ?></span><?php echo $date; ?></td>
                                    <td><?php echo $loop->topic; ?></td>
                                    <td><?php echo $loop->categoryname; ?></td>
                                    <td><?php echo $loop->detail; ?></td>
                                    <td><?php echo $loop->fname2." ".$loop->lname2; ?></td>
                                    <?php if ($user_status==1) { echo "<td>".$loop->fname1." ".$loop->lname1."</td>"; } ?>
									<td width="50">
                                <?php if ($loop->task_status==5) { ?>
                                        <a href="#" class="btn btn-info btn-md" data-title="OK" data-toggle="tooltip" data-target="#ok" data-placement="top" rel="tooltip" title="รับงาน" onClick="got_confirm(<?php echo $loop->task_id; ?>)"><i class="fa fa-fw fa-thumbs-o-up"></i> <b>รับงาน</b></a>
                                <?php }else if ($loop->task_status==1) { ?>
                                    <a href="#" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#change" data-placement="top" rel="tooltip" title="Finish" onClick="finish_confirm(<?php echo $loop->task_id; ?>)"><span class="glyphicon glyphicon-ok"></span></a>
                                <?php if ($loop->assignid==$loop->userid) { ?>
                                    <a href="#" class="btn btn-danger btn-xs" data-title="Cancel" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="Cancel" onClick="cancel_confirm(<?php echo $loop->task_id; ?>)"><span class="glyphicon glyphicon-remove"></span></a>
                                <?php } }?>
	</div>
                                        
									</td>
									</tr>
								<?php } }  ?>
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
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    $('#tabletask').dataTable();
    
    $('#fancyboxall').fancybox({ 
    'width': '85%',
    'height': '100%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
});

function finish_confirm(val1) {
	bootbox.confirm("ยืนยันการปิดงานใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = <?php echo json_encode($url); ?>;
            	if (result) {
				
					window.location.replace(myurl+"/"+val1);
				}

		});

}
    
function cancel_confirm(val1) {
	bootbox.confirm("ยืนยันการยกเลิกงานใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = <?php echo json_encode($url2); ?>;
            	if (result) {
				
					window.location.replace(myurl+"/"+val1);
				}

		});

}
    
function got_confirm(val1) {
    var myurl = <?php echo json_encode($url3); ?>;
    window.location.replace(myurl+"/"+val1);
}

</script>
</body>
</html>