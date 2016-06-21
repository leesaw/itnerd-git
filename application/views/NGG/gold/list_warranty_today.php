<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('NGG/gold/header_view'); ?>
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
                <div class="panel panel-primary">
					<div class="panel-heading">
                        <h4>รายการบัตรรับประกันสินค้าของวันที่ <?php echo $currentdate; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th>เลขที่ใบรับประกัน</th>
                                        <th>ประเภทสินค้า</th>
                                        <th>ชนิดของทอง</th>
                                        <th>น้ำหนัก</th>
                                        <th>จำนวนเงิน</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>เบอร์ติดต่อลูกค้า</th>
                                        <th>พนักงานขาย</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($pos_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->ngw_number; if ($loop->ngw_status=='V') echo " <button class='btn btn-xs btn-danger'>ยกเลิก (Void)</button>"; ?></td>
                                        <td><?php echo $loop->ngw_product; ?></td>
                                        <td><?php echo $loop->ngw_kindgold; ?></td>
                                        <td><?php echo $loop->ngw_weight; ?></td>
                                        <td><?php echo $loop->ngw_price; ?></td>
                                        <td><?php echo $loop->ngw_customername; ?></td>
                                        <td><?php echo $loop->ngw_customertelephone; ?></td>
                                        <td><?php echo $loop->sp_firstname." ".$loop->sp_lastname."<br>".$loop->sp_firstname2." ".$loop->sp_lastname2; ?></td>
                                        <td><a href="<?php echo site_url("ngg_gold/view_warranty")."/".$loop->ngw_id; ?>" class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-search"></span></a> 
                                        </td>
                                    </tr>
                                    <?php } ?>
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
<script type="text/javascript">
$(document).ready(function()
{

});

</script>
</body>
</html>