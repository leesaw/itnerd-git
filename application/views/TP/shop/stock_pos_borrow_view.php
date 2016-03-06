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
            
            <h1>ข้อมูลใบส่งของชั่วคราว</h1>
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
                                        <label class="control-label" for="inputSuccess">เลขที่ใบส่งของ</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $loop->posrob_number; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
                                    <div class="form-group-sm has-success">
                                        <label class="control-label" for="inputSuccess">วันที่ส่งของ</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php $datein =  explode('-',$loop->posrob_issuedate); echo $datein[2]."/".$datein[1]."/".$datein[0]; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm has-success">
                                        <label class="control-label" for="inputSuccess">สาขา</label>
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php echo $loop->sh_name; ?>" readonly>
                                    </div>
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">ชื่อผู้รับของ</label>
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $loop->posrob_borrower_name; ?>" readonly>
                                </div>
							</div>
                        </div>
                        <?php $remark = $loop->posrob_remark;
                              $sale_person = $loop->sp_barcode."-".$loop->firstname." ".$loop->lastname;
                              $pos_status = $loop->posrob_status;
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
                                                <td><?php echo $loop->posrobi_qty." ".$loop->it_uom; ?></td>
                                                <td><?php echo number_format($loop->it_srp); ?></td>
                                                </tr>
                                                <?php $sum += $loop->posrobi_qty; } ?>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:200%;" class="text-red">
                                                        <th colspan="5" style="text-align:right;"><label>จำนวนรวม:</th>
                                                        <th><?php echo $sum; ?></th>
                                                        <th> </th>
                                                    </tr>
                                                </tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>	
						</div>	
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    ชื่อ-นามสกุลพนักงานขาย
                                    <input type="text" class="form-control" name="salename" id="salename" value="<?php echo $sale_person; ?>">
                                </div>
                            </div>
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
                                <a href="<?php echo site_url("pos/stock_rolex_borrow_print")."/".$pos_rolex_id; ?>" target="_blank"><button type="button" class="btn btn-primary" name="printbtn" id="printbtn"><i class='fa fa-print'></i>  พิมพ์ใบส่งของชั่วคราว </button></a>&nbsp;&nbsp;
                                <button type="button" class="btn btn-danger" name="voidbtn" id="voidbtn" onclick="del_confirm()" <?php if($pos_status=='V') echo "disabled"; ?>><i class='fa fa-close'></i>  ยกเลิกใบส่งของชั่วคราว </button>
                                <form action="<?php echo site_url("pos/saleorder_rolex_void_pos_borrow")."/".$pos_rolex_id; ?>" method="post" name="form2" id ="form2"><input type="hidden" name="remarkvoid" id="remarkvoid" value=""></form>
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
	bootbox.confirm("ต้องการยกเลิกใบส่งของชั่วคราวที่เลือกไว้ใช่หรือไม่ ?", function(result) {
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