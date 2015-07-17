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
    <?php $url = site_url("login/banUser"); 
        ?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Users
        </h1>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">

                        
        <div class="box-body">
            
        <div class="row">
			<div class="col-xs-6">
                <div class="box">
                    <div class="box-header">
                      <a class="btn btn-primary btn-sm pull-right" href="<?php echo site_url("login/adduser"); ?>"><i class="fa fa-plus"></i> เพิ่ม User</a>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table table-condensed">
                        <tr>
                          <th style="width: 40px">#</th>
                          <th>Username</th>
                          <th>ชื่อ</th>
                          <th>นามสกุล</th>
                          <th>สถานะ</th>
                          <th>หมายเลขทีม</th>
                          <th style="width: 80px"> </th>
                        </tr>
                    <?php   $count=1;
                        foreach($user_array as $loop) { ?>
                            <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $loop->username; ?></td>
                            <td><?php echo $loop->firstname; ?></td>
                            <td><?php echo $loop->lastname; ?></td>
                            <td><?php echo $loop->status; ?></td>
                            <td><?php echo $loop->team_id; ?></td>
                            <td><a href="<?php echo site_url("login/edituser/".$loop->id); ?>" class="btn btn-warning btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="Edit"><span class="glyphicon glyphicon-edit"></span></a>
                                <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="tooltip" data-target="#delete" data-placement="top" rel="tooltip" title="Delete" onClick="del_confirm(<?php echo $loop->id; ?>)"><span class="glyphicon glyphicon-remove"></span></button></td>
                            </tr>
                    <?php $count++; } ?>
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

    
function del_confirm(val1) {
	bootbox.confirm("ต้องการลบข้อมูลที่เลือกไว้ใช่หรือไม่ ?", function(result) {
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