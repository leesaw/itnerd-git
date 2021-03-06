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
            
            <h1>ข้อมูลการขาย</h1>
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
                                        <label class="control-label" for="inputSuccess">เลขที่ใบกำกับภาษี</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $loop->posro_number; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
                                    <div class="form-group-sm has-success">
                                        <label class="control-label" for="inputSuccess">วันที่ขาย</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php $datein =  explode('-',$loop->posro_issuedate); echo $datein[2]."/".$datein[1]."/".$datein[0]; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm has-success">
                                        <label class="control-label" for="inputSuccess">สาขาที่ขาย</label>
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php echo $loop->sh_name; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label text-red">
                                    <?php if ($loop->posro_refund == 1) { ?><u>VAT REFUND</u><?php } ?></label>
                                </div>
                            </div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">ชื่อลูกค้า</label>
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $loop->posro_customer_name; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-9">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">ที่อยู่ลูกค้า</label>
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="<?php echo $loop->posro_customer_address; ?>" readonly>
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">เลขประจำตัวผู้เสียภาษี</label>
                                    <input type="text" class="form-control" name="custax_id" id="custax_id" value="<?php echo $loop->posro_customer_taxid; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">Passport No.</label>
                                    <input type="text" class="form-control" name="cuspassport" id="cuspassport" value="<?php echo $loop->posro_customer_passport; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">เบอร์ติดต่อ</label>
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="<?php echo $loop->posro_customer_tel; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm has-success">
                                    <label class="control-label" for="inputSuccess">ชำระเงิน</label>
                                    <input type="text" class="form-control" name="payment" id="payment" value="<?php if ($loop->posro_payment=='C') echo "เงินสด"; if ($loop->posro_payment=='D') echo "บัตรเครดิต"; if ($loop->posro_payment=='Q') echo "เช็ค"; ?>" readonly>
                                </div>
							</div> 
                            <div class="col-md-3">
                                <div class="form-group-lg has-success">
                                    <label class="control-label" for="inputSuccess"><?php if ($loop->posro_payment=='C') echo "จำนวนเงินที่จ่าย"; if ($loop->posro_payment=='D') echo "บัตรเครดิตธนาคาร"; if ($loop->posro_payment=='Q') echo "เลขที่"; ?></label>
                                    <input type="text" class="form-control input-lg text-blue" name="payment_value" id="payment_value" style="font-weight:bold;" value="<?php echo number_format($loop->posro_payment_value); ?>" readonly>
                                </div>
							</div> 
                        </div>
                        <?php $remark = $loop->posro_remark;
                              $sale_person = $loop->sp_barcode."-".$loop->firstname." ".$loop->lastname;
                              $pos_status = $loop->posro_status;
                              $posro_id = $loop->posro_id;
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
                                                <td><?php echo $loop->posroi_qty." ".$loop->it_uom; ?></td>
                                                <td><?php echo number_format($loop->posroi_item_srp); ?></td>
                                                <td><?php echo number_format($loop->posroi_dc_baht); ?></td>
                                                <td><?php echo number_format($loop->posroi_item_srp - $loop->posroi_dc_baht); ?></td>
                                                </tr>
                                                <?php $sum += $loop->posroi_item_srp - $loop->posroi_dc_baht; } ?>
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
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    ชื่อ-นามสกุลพนักงานขาย                                    <input type="text" class="form-control" name="salename" id="salename" value="<?php echo $sale_person; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-sm">
                                    Remark
                                    <input type="text" class="form-control" name="remark" id="remark" value="<?php echo $remark; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
							<div class="col-md-12">
                                <a href="<?php echo site_url("sale/saleorder_rolex_print")."/".$pos_rolex_id; ?>" target="_blank"><button type="button" class="btn btn-primary" name="printbtn" id="printbtn"><i class='fa fa-print'></i>  พิมพ์ใบกำกับภาษี </button></a>&nbsp;&nbsp;
                                <button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-warning" name="printbtn" id="printbtn"><i class='fa fa-edit'></i>  แก้ไข Remark </button>
                                <button type="button" class="btn btn-danger pull-right" name="voidbtn" id="voidbtn" onclick="del_confirm()" <?php if($pos_status=='V') echo "disabled"; ?>><i class='fa fa-close'></i>  ยกเลิกใบกำกับภาษี (Void) </button>&nbsp;&nbsp;
                                <form action="<?php echo site_url("sale/saleorder_rolex_void_pos")."/".$pos_rolex_id; ?>" method="post" name="form2" id ="form2"><input type="hidden" name="remarkvoid" id="remarkvoid" value=""></form>
							</div>
						</div>

					</div>
				</div>
			</div>	
            </div></section>
	</div>
</div>

<!-- datepicker modal for return status -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_return" aria-hidden="true">

      <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">                        
                    <i class='fa fa-edit'></i>  แก้ไข Remark 
                </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
                <div class="row"><div class="col-md-12"><div class="form-group"><label class="col-md-3 control-label" for="remark">Remark</label><br><div class="col-md-12"> <input type="text" class="form-control" id="remark_edit" name="remark_edit" value="<?php echo $remark; ?>" /></div></div> </div>  </div>

            </div>            <!-- /modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="edit_remark()"><i class='fa fa-save'></i> บันทึก</button>          

            </div>  
            </form>                             
        </div>
    </div>
</div>

</div>
<!-- close modal -->  


<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    
});
    
function del_confirm() {
	bootbox.confirm("ต้องการยกเลิกใบกำกับภาษีที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = "<?php echo site_url("sale/saleorder_rolex_void_pos")."/".$pos_rolex_id; ?>";
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

function edit_remark()
{
    var remark = $('#remark_edit').val();
    var posro_id = <?php echo $posro_id; ?>;

    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("sale/save_edit_remark"); ?>" ,
        data : {remark: remark, posro_id: posro_id} ,
        dataType: 'json',
        success : function(data) {
            var message = "ทำการบันทึกเรียบร้อยแล้ว";
            bootbox.alert(message, function() {
                location.reload();
            });
            
        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
        }
    });
}

</script>
</body>
</html>