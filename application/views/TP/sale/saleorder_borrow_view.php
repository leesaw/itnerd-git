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
            
            <h1>ข้อมูลใบแจ้งขาย</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading"> </div>
                    <div class="panel-body">
                        <?php foreach($pos_array as $loop) { ?>
                        <div class="row">
                            <div class="col-md-2">
                                    <div class="form-group-sm has-success">
                                        <label class="control-label" for="inputSuccess">เลขที่ใบเสร็จ</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $loop->posrot_number; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
                                    <div class="form-group-sm has-success">
                                        <label class="control-label" for="inputSuccess">วันที่ขาย</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php $datein =  explode('-',$loop->posrot_issuedate); echo $datein[2]."/".$datein[1]."/".$datein[0]; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm has-success">
                                        <label class="control-label" for="inputSuccess">ขายโดย</label>
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php foreach($borrow_array as $loop_borrow) { echo $loop_borrow->posrob_borrower_name; } ?>" readonly>
                                    </div>
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">ชื่อลูกค้า</label>
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $loop->posrot_customer_name; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-9">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">ที่อยู่ลูกค้า</label>
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="<?php echo $loop->posrot_customer_address; ?>" readonly>
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">เบอร์ติดต่อ</label>
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="<?php echo $loop->posrot_customer_tel; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">ชำระเงิน</label>
                                    <input type="text" class="form-control" name="payment" id="payment" value="<?php if ($loop->posrot_payment=='C') echo "เงินสด"; if ($loop->posrot_payment=='D') echo "บัตรเครดิต"; if ($loop->posrot_payment=='Q') echo "เช็ค"; ?>" readonly>
                                </div>
							</div> 
                            <div class="col-md-3">
                                <div class="form-group-lg has-success">
                                    <label class="control-label" for="inputSuccess"><?php if ($loop->posrot_payment=='C') echo "จำนวนเงินที่จ่าย"; if ($loop->posrot_payment=='D') echo "บัตรเครดิตธนาคาร"; if ($loop->posrot_payment=='Q') echo "เลขที่"; ?></label>
                                    <input type="text" class="form-control input-lg text-blue" name="payment_value" id="payment_value" style="font-weight:bold;" value="<?php echo $loop->posrot_payment_value; ?>" readonly>
                                </div>
							</div> 
                        </div>
                        <?php $remark = $loop->posrot_remark;
                              $sale_person = $loop->sp_barcode."-".$loop->firstname." ".$loop->lastname;
                              $pos_status = $loop->posrot_status;
                        } ?>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-primary">
									<div class="panel-heading">รายการสินค้า</div>
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
                                                        <th>จำนวนเงิน</th>
				                                    </tr>
				                                </thead>
												<tbody>
                                                <?php $sum=0; foreach($item_array as $loop) { ?>
                                                <tr>
                                                <td><?php echo $loop->it_refcode; ?></td>
                                                <td><?php echo $loop->itse_serial_number; ?></td>
                                                <td><?php echo $loop->it_short_description; ?></td>
                                                <td><?php echo $loop->it_model; ?></td>
                                                <td><?php echo $loop->it_remark; ?></td>
                                                <td><?php echo $loop->posroit_qty." ".$loop->it_uom; ?></td>
                                                <td><?php echo number_format($loop->posroit_item_srp); ?></td>
                                                <td><?php echo number_format($loop->posroit_dc_baht); ?></td>
                                                <td><?php echo number_format($loop->posroit_item_srp - $loop->posroit_dc_baht); ?></td>
                                                </tr>
                                                <?php $sum += $loop->posroit_item_srp - $loop->posroit_dc_baht; } ?>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:200%;" class="text-red">
                                                        <th colspan="8" style="text-align:right;"><label>ยอดรวม:</th>
                                                        <th><?php echo number_format($sum); ?></th>
                                                    </tr>
                                                </tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>	
						</div>	
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-sm">
                                    Remark
                                    <input type="text" class="form-control" name="remark" id="remark" value="<?php echo $remark; ?>">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
							<div class="col-md-6">
                                <a href="<?php echo site_url("sale/saleorder_rolex_temp_borrow_print")."/".$pos_rolex_id."/".$borrow_item_id; ?>" target="_blank"><button type="button" class="btn btn-primary" name="printbtn" id="printbtn"><i class='fa fa-print'></i>  พิมพ์ใบแจ้งขาย </button></a>&nbsp;&nbsp;
                                <button type="button" class="btn btn-danger" name="voidbtn" id="voidbtn" onclick="del_confirm()" <?php if($pos_status=='V') echo "disabled"; ?>><i class='fa fa-close'></i>  ยกเลิกใบแจ้งขาย (Void) </button>
                                <form action="<?php echo site_url("sale/saleorder_rolex_void_borrow")."/".$pos_rolex_id."/".$borrow_item_id; ?>" method="post" name="form2" id ="form2"><input type="hidden" name="remarkvoid" id="remarkvoid" value=""></form>
							</div>
						</div>

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
$(document).ready(function()
{    
    
});

    
function del_confirm() {
	bootbox.confirm("ต้องการยกเลิกใบแจ้งขายที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
            	if (result) {
				    bootbox.prompt("เนื่องจาก..", function(result) {                
                      if (result === null) {                                             
                        document.getElementById("form2").submit();                           
                      } else {
                        document.getElementById("remarkvoid").value=result;
                        document.getElementById("form2").submit();                       
                      }
                    });
				}

		});
}
    
</script>
</body>
</html>