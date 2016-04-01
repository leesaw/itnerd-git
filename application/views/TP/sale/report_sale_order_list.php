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
            ประวัติการสั่งขาย
        </h1>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading">
                        <h4>รายการใบสั่งขายทั้งหมด</h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่ใบสั่งขาย</th>
                                        <th>วันที่</th>
                                        <th>สาขาที่ขาย</th>
                                        <th>ผู้ทำรายการ</th>
                                        <th>วันเวลาทำรายการ</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($final_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->so_number; ?></td>
                                        <td><?php echo $loop->so_issuedate; ?></td>
                                        <td><?php echo $loop->sh_code."-".$loop->sh_name; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><?php echo $loop->so_dateadd; ?></td>
                                        <td><a href="<?php echo site_url("sale/saleorder_print")."/".$loop->so_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-print"></span></a> 
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
<script type="text/javascript">
$(document).ready(function()
{    
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