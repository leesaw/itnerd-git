<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
        <div class="content-wrapper">
        <section class="content-header">
            
            <h1>ออกใบกำกับภาษี / ใบส่งสินค้า / ใบเสร็จรับเงิน</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("sale/saleorder_rolex_payment"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่ขาย
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        สาขาที่ขาย *
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php echo $shop_name; ?>" readonly>
                                        <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>">
                                    </div>
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    ชื่อลูกค้า
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $cusname; ?>">
                                </div>
							</div>
                            <div class="col-md-9">
                                <div class="form-group-sm">
                                    ที่อยู่ลูกค้า
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="<?php echo $cusaddress; ?>">
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    เลขประจำตัวผู้เสียภาษี
                                    <input type="text" class="form-control" name="custax_id" id="custax_id" value="<?php echo $custax_id; ?>">
                                </div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    เบอร์ติดต่อ
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="<?php echo $custelephone; ?>">
                                </div>
							</div>
                        </div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-lg col-lg-6">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Serial ที่ขาย">
                                        <div class="input-group-btn">

                                        </div>
                                        <label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label> 
                                        </div></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>RMC</th>
                                                        <th>Serial No.</th>
                                                        <th>Description</th>
                                                        <th>Family</th>
                                                        <th>Bracelet</th>
														<th width="105">Quantity</th>
                                                        <th>Retail Price</th>
                                                        <th>Discount (THB)</th>
				                                    </tr>
				                                </thead>
												<tbody>
                                                <?php for($i=0; $i<count($item_array); $i++) { ?>
                                                    <tr>
                                                    <td><?php echo $item_array[$i]["it_refcode"]; ?></td>
                                                    <td><?php echo $item_array[$i]["it_serial"]; ?></td>
                                                    <td><?php echo $item_array[$i]["it_short_description"]; ?></td>
                                                    <td><?php echo $item_array[$i]["it_model"]; ?></td>
                                                    <td><?php echo $item_array[$i]["it_remark"]; ?></td>
                                                    <td><?php echo "1 ".$item_array[$i]["it_uom"]; ?></td>
                                                    <td><?php echo number_format($item_array[$i]["it_srp"]); ?></td>
                                                    <td><?php echo $item_array[$i]["discount"]; ?></td>
                                                    </tr>
                                                <?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>	
						</div>	
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
							</div>
						</div>
						</form>

					</div>
				</div>
			</div>	
            </div></section>
	</div>
</div>
<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">

var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{    
    
    document.getElementById("savebtn").disabled = false;


});

</script>
</body>
</html>