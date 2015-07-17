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
    <?php $url = site_url("task/deleteCategory"); 
        ?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แสดงงานที่เสร็จแล้วทั้งหมด
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
			<div class="col-xs-6">
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">ประเภทงาน</h3> <button type="button" class="btn btn-primary btn-xs pull-right" onClick="add_category();"> <i class="fa fa-plus"></i> เพิ่มประเภทงาน</button>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table table-condensed">
                        <tr>
                          <th style="width: 40px">#</th>
                          <th>ชื่อประเภทงาน</th>
                          <th style="width: 80px"> </th>
                        </tr>
                    <?php   $count=1;
                            foreach($category_array as $loop) { ?>
                            <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $loop->name; ?></td>
                            <td><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="tooltip" data-target="#delete" data-placement="top" rel="tooltip" title="Delete" onClick="del_confirm(<?php echo $loop->category_id; ?>)"><span class="glyphicon glyphicon-remove"></span></button></td>
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

function finish_confirm(val1) {
	bootbox.confirm("ยืนยันการปิดงานใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = <?php echo json_encode($url); ?>;
            	if (result) {
				
					window.location.replace(myurl+"/"+val1);
				}

		});

}
    
function del_confirm(val1) {
	bootbox.confirm("ต้องการลบข้อมูลที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = <?php echo json_encode($url); ?>;
            	if (result) {
				
					window.location.replace(myurl+"/"+val1);
				}

		});

}
    
function add_category() {
            bootbox.prompt("ป้อนชื่อประเภทงานใหม่", function(result) {       
                if (result != null && result !="") {                                                                        
                    var name = result;
                    $.ajax({
                            'url' : '<?php echo site_url('task/addNewCategory'); ?>',
                            'type':'post',
                            'data': { category_name:name },
                            'success' : function(data){
                                window.location.reload();
                            }
                        }); 

                }else if (result =="") {
                    alert('ไม่สามารถเพิ่มข้อมูลได้');
                }
            });
}

</script>
</body>
</html>