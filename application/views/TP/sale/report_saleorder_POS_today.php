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
            แสดงใบกำกับภาษีของวันนี้
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
                        <h4>รายการใบกำกับภาษีของวันที่ <?php echo $currentdate; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่ใบกำกับภาษี</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>เบอร์ติดต่อลูกค้า</th>
										<th>ชำระโดย</th>
                                        <th>พนักงานขาย</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($pos_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->posro_number; if ($loop->posro_status=='V') echo " <button class='btn btn-xs btn-danger'>ยกเลิก (Void)</button>"; if($loop->posro_refund==1) echo " <button class='btn btn-xs btn-primary'>VAT Refund</button>"; ?></td>
                                        <td><?php echo $loop->posro_customer_name; ?></td>
                                        <td><?php echo $loop->posro_customer_tel; ?></td>
                                        <td><?php if ($loop->posro_payment=='C') echo "เงินสด"; if ($loop->posro_payment=='D') echo "บัตรเครดิต"; if ($loop->posro_payment=='Q') echo "เช็ค";  ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><a href="<?php echo site_url("sale/saleorder_rolex_pos_last")."/".$loop->posro_id; ?>" class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-search"></span></a> 
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