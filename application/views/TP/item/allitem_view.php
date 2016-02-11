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
        <section class="content-header">
            
            <h1>จัดการข้อมูลสินค้า</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                        
        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("item/filter_item"); ?>" method="post">
            <div class="col-xs-4 col-md-4">
                ค้นหา Refcode/Description
                <input type="text" class="form-control-sm" name="refcode" id="refcode">
            </div>
            <div class="col-xs-3 col-md-3">
                เลือกยี่ห้อ
                    <select class="form-control-sm" name="brandid" id="brandid">
                        <option value='0'>เลือกทั้งหมด</option>
                    <?php 	if(is_array($brand_array)) {
                                foreach($brand_array as $loop){
                                    echo "<option value='".$loop->br_id."'>".$loop->br_code." - ".$loop->br_name."</option>";
                            } } ?>
                    </select>
            </div>
            <div class="col-xs-3 col-md-3">
                เลือกประเภทสินค้า
                    <select class="form-control-sm" name="catid" id="catid">
                        <option value='0'>เลือกทั้งหมด</option>
                        <?php 	if(is_array($cat_array)) {
								    foreach($cat_array as $loop){
								        echo "<option value='".$loop->itc_id."'>".$loop->itc_name."</option>";
								} } ?>
                    </select>
            </div>
            <div class="col-xs-1 col-md-2">
                <button type="submit" name="action" value="0" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> Filter</button>
            </div>

        </div>              
                        
        </form>               
                        
					</div>
                </div>
            </div>
        </div>
            
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-danger">
					<div class="panel-heading"></div>
                    <div class="panel-body">
                            <table class="table table-bordered table-striped" id="itemtable" width="100%">
                                <thead>
                                    <tr>
                                        <th>รหัสสินค้า</th>
										<th>Ref. Code</th>
										<th>ชื่อ</th>
                                        <th>ยี่ห้อ</th>
                                        <th>รุ่น</th>
                                        <th>ราคา</th>
										<th>ประเภท</th>
										<th width="80">จัดการ</th>
                                    </tr>
                                </thead>
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
<script type="text/javascript">
$(document).ready(function()
{    
    $('#itemtable').dataTable
        ({
            "bProcessing": true,
            'bServerSide'    : false,
            "bDeferRender": true,
            'sAjaxSource'    : '<?php echo site_url("item/ajaxViewAllItem"); ?>',
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
// tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[rel=tooltip]",
        container: "body"
    })  
</script>
</body>
</html>