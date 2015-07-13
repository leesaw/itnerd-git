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
    <?php $url = site_url("task/finishtask"); ?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แสดงงานที่ปิดแล้วทั้งหมด
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> แสดงงานที่ปิดแล้วทั้งหมด</a></li>
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
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                            <table class="table table-bordered table-striped" id="tabletask" width="100%">
                                <thead>
                                    <tr>
                                        <th width="100">วันที่เสร็จสิ้น</th>
                                        <th>หัวข้องาน</th>
                                        <th>ประเภท</th>
                                        <th width="300">รายละเอียด</th>
                                        <th>ผู้สั่งงาน</th>
                                        <th>ผู้ปฏิบัติงาน</th>
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
                                    <td><?php echo $loop->fname1." ".$loop->lname1; ?></td>
									<td width="50">
                                    <a href="#" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="View" onClick="finish_confirm(<?php echo $loop->task_id; ?>)"><span class="glyphicon glyphicon-ok"></span></a>
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

</script>
</body>
</html>