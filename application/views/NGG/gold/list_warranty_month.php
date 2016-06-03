<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('NGG/gold/header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<body class="hold-transition skin-red layout-top-nav">
<div class="wrapper">
	<?php $this->load->view('NGG/gold/menu'); ?>
	
<div class="content-wrapper">
    <div class="container">
	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h1 class="box-title">บัตรรับประกันสินค้า (ทอง) | สาขา <span class="text-blue"><?php foreach($shop_array as $loop) echo $loop->sh_name; ?> </span></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box_heading"></div>
                    <div class="box-body"> 
                        <div class="row">
                        <form action="<?php echo site_url("ngg_gold/result_warranty_filter"); ?>" name="formfilter" id="formfilter" method="post">
                        <div class="col-xs-3 col-md-2">
                            เลือกวันที่เริ่มต้น : 
                            <input type="text" class="form-control" id="startdate" name="startdate" value="<?php echo $start_form; ?>" />
                        </div>
                        <div class="col-xs-3 col-md-2">
                            สิ้นสุด :
                            <input type="text" class="form-control" id="enddate" name="enddate" value="<?php echo $end_form; ?>" />
                        </div>
                        <div class="col-xs-3 col-md-2">
                            <br>
                            <div class="col-md-3"><button type="submit" name="action" value="0" class="btn btn-success"><i class="fa fa-search"></i> ค้นหา</button></div>
                        </div>
                    </div>


                    </form>  
					</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
					<div class="panel-heading">
                        <h4>รายการบัตรรับประกันสินค้า<?php if ($search==0) { ?>ของเดือนที่ <?php echo $month; } ?> <u>จำนวน <?php echo $count_warranty; ?> ชิ้น</u></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablegold" width="100%">
                                <thead>
                                    <tr>
                                        <th width="125">เลขที่ใบรับประกัน</th>
                                        <th>ประเภทสินค้า</th>
                                        <th>ชนิดของทอง</th>
                                        <th>น้ำหนัก</th>
                                        <th>จำนวนเงิน</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>เบอร์ติดต่อลูกค้า</th>
                                        <th>พนักงานขาย</th>
                                        <th>สาขา</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                
								<tbody>
								</tbody>
							</table>
                        
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
    get_datepicker("#startdate");
    get_datepicker("#enddate");
    
    var oTable = $('#tablegold').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("ngg_gold/ajaxViewWarranty")."/".$startdate."/".$enddate; ?>',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success":fnCallback

            });
        }
    });
});
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}

</script>
</body>
</html>