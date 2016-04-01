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
            แสดงประวัติใบเสร็จรับเงิน
        </h1>
    </section>
	
	<section class="content">        
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="<?php echo site_url("sale/saleorder_POS_temp_history"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
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
                <div class="panel panel-primary">
					<div class="panel-heading">
                        <h4>รายการใบเสร็จรับเงินของเดือนที่ <?php echo $currentdate; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่ใบเสร็จ</th>
                                        <th>วันที่ออก</th>
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
                                        <td><?php echo $loop->posrot_number; if ($loop->posrot_status=='V') echo " <button class='btn btn-xs btn-danger'>ยกเลิก (Void)</button>"; ?></td>
                                        <td><?php echo $loop->posrot_issuedate; ?></td>
                                        <td><?php echo $loop->posrot_customer_name; ?></td>
                                        <td><?php echo $loop->posrot_customer_tel; ?></td>
                                        <td><?php if ($loop->posrot_payment=='C') echo "เงินสด"; if ($loop->posrot_payment=='D') echo "บัตรเครดิต"; if ($loop->posrot_payment=='Q') echo "เช็ค"; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                        <td><a href="<?php echo site_url("sale/saleorder_rolex_pos_temp_last")."/".$loop->posrot_id; ?>" class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-search"></span></a> 
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
    get_datepicker("#datein");
    
    var oTable = $('#tablefinal').DataTable();
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
    
});
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "mm/yyyy", viewMode: "months", 
    minViewMode: "months" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
    
function submitform()
{
    document.getElementById("form1").submit();
}
</script>
</body>
</html>