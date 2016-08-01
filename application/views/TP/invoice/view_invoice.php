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
            
            <h1>Invoice</h1>
        </section>
<?php 
    foreach($inv_array as $loop) {
        $inv_id = $loop->inv_id;
        $inv_datein = $loop->inv_issuedate;
        $datein_array = explode("-",$inv_datein);
        $inv_datein = $datein_array[2]."/".$datein_array[1]."/".$datein_array[0];
        $inv_number = $loop->inv_number;
        $inv_whname = $loop->wh_code."-".$loop->wh_name;
        $inv_cusname = $loop->inv_warehouse_detail;
        $inv_address1 = $loop->inv_warehouse_address1;
        $inv_address2 = $loop->inv_warehouse_address2;
        $inv_taxid = $loop->inv_warehouse_taxid;
        $inv_branch = $loop->inv_warehouse_branch;
        if ($inv_branch == 0) {
            $inv_branch = "สำนักงานใหญ่";
        }else{
            $inv_branch = str_pad($inv_branch, 5, '0', STR_PAD_LEFT);
        }

        $inv_vender = $loop->inv_vender;
        $inv_barcode = $loop->inv_barcode;
        $inv_stot_number = $loop->inv_stot_number;
        $inv_srp_discount = $loop->inv_srp_discount;
        $inv_note = $loop->inv_note;
        $inv_dateadd = $loop->inv_dateadd;
        $inv_remark = $loop->inv_remark;
        $inv_enable = $loop->inv_enable;

        $editor_view = $loop->firstname." ".$loop->lastname." ".$loop->inv_dateadd;
    }
?>
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading"><strong>รายละเอียด Invoice <?php if ($inv_enable == 0) { ?><h3 class="text-red">ยกเลิก Invoice นี้แล้ว</h3><?php } ?></strong></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                        วันที่ออกใบ Invoice
                                        <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $inv_datein; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                        เลขที่ Invoice
                                        <input type="text" class="form-control" name="number" id="number" value="<?php echo $inv_number; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
									<div class="form-group-sm">
                                        คลังสินค้า
                                        <input type="text" class="form-control" name="whid" id="whid" value="<?php echo $inv_whname; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    นามผู้ซื้อ *
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $inv_cusname; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    เลขประจำตัวผู้เสียภาษี *
                                    <input type="text" class="form-control" name="custax_id" id="custax_id" value="<?php echo $inv_taxid; ?>" readonly>
                                </div>
                            </div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    ที่อยู่ผู้ซื้อ แถวที่ 1 *
                                    <input type="text" class="form-control" name="cusaddress1" id="cusaddress1" value="<?php echo $inv_address1; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-4">
                                <div class="form-group-sm">
                                    ที่อยู่ผู้ซื้อ แถวที่ 2 *
                                    <input type="text" class="form-control" name="cusaddress2" id="cusaddress2" value="<?php echo $inv_address2; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    สาขา
                                    <input type="text" class="form-control" name="branch" id="branch" value="<?php echo $inv_branch; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    Vender Code
                                    <input type="text" class="form-control" name="vender" id="vender" value="<?php echo $inv_vender; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    Barcode
                                    <input type="text" class="form-control" name="barcode" id="barcode" value="<?php echo $inv_barcode; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    เลขที่ใบส่งของอ้างอิง
                                    <input type="text" class="form-control" name="tb_number" id="tb_number" value="<?php echo $inv_stot_number; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    ส่วนลดราคาป้าย %
                                    <input type="text" class="form-control" name="discount_srp" id="discount_srp" value="<?php echo number_format($inv_srp_discount); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    หมายเหตุ
                                    <input type="text" class="form-control" name="note" id="note" value="<?php echo $inv_note; ?>" readonly>
                                </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-primary">
									<div class="panel-heading"><h3 class="panel-title">รายการสินค้า</h3></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th width="250">Ref. Number</th>
                                                        <th width="250">รายละเอียด</th>
                                                        <th width="180">จำนวน</th>
                                                        <th width="180">หน่วยละ</th>
                                                        <th width="180">ส่วนลด %</th>
														<th width="200">จำนวนเงิน</th>
				                                    </tr>
				                                </thead>
												<tbody>
                                                <?php $count_qty = 0; $sum_netprice = 0; foreach($item_array as $loop) { ?>
                                                    <tr>
                                                        <td><?php echo $loop->invit_refcode; ?></td>
                                                        <td><?php echo $loop->invit_brand; ?></td>
                                                        <td><?php echo $loop->invit_qty; $count_qty+=$loop->invit_qty;  ?></td>
                                                        <td><?php echo number_format($loop->invit_srp,2,".",","); ?></td>
                                                        <td><?php echo $loop->invit_discount; ?></td>
                                                        <td><?php echo number_format($loop->invit_netprice*$loop->invit_qty,2,".",","); $sum_netprice+=$loop->invit_netprice*$loop->invit_qty; ?></td>
                                                    </tr>
                                                <?php } ?>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:200%;" class="text-red">
                                                        <th colspan="2" style="text-align:right;"><label>จำนวนรวม:</th>
                                                        <th><div id="allcount"><?php echo $count_qty; ?></div></th>
                                                        <th colspan="2" style="text-align:right;"><label>ราคารวม:</th>
                                                        <th><div id="summary"><?php echo number_format($sum_netprice, 2, ".", ","); ?></div></th>
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
                                    <input type="text" class="form-control" name="remark" id="remark" value="<?php echo $inv_remark; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-sm">
                                    แก้ไขล่าสุด
                                    <input type="text" class="form-control" name="editor" id="editor" value="<?php echo $editor_view; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
							<div class="col-md-12">
								<a href="<?php echo site_url("tp_invoice/print_invoice")."/".$inv_id; ?>" target="_blank"><button type="button" class="btn btn-primary" name="printbtn" id="printbtn"><i class='fa fa-print'></i>  พิมพ์ใบ Invoice </button></a>&nbsp;&nbsp;
                                <a href="<?php echo site_url("tp_invoice/excel_invoice")."/".$inv_id; ?>"><button type="button" class="btn btn-success" name="excelbtn" id="excelbtn"><i class='fa fa-file-excel-o'></i>  Export Excel </button></a>&nbsp;&nbsp;
                                <?php if($auth_edit) { ?>
                                <a href="<?php echo site_url("tp_invoice/edit_invoice")."/".$inv_id; ?>"><button type="button" class="btn btn-warning" name="editbtn" id="editbtn" <?php if ($inv_enable == 0) { echo "disabled"; } ?>><i class='fa fa-edit'></i>  แก้ไขใบ Invoice </button></a>&nbsp;&nbsp;
                                <button type="button" class="btn btn-danger pull-right" name="voidbtn" id="voidbtn" onclick="del_confirm()" <?php if ($inv_enable == 0) { echo "disabled"; } ?>><i class='fa fa-close'></i>  ยกเลิก Invoice (Void) </button>&nbsp;&nbsp;
                                <form action="<?php echo site_url("tp_invoice/void_invoice")."/".$inv_id; ?>" method="post" name="form2" id ="form2"><input type="hidden" name="remarkvoid" id="remarkvoid" value=""></form>
                                <?php }else{ ?>
                                <?php } ?>
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
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script></script>
<script type="text/javascript">
$(document).ready(function()
{    

});

function del_confirm() {
    bootbox.confirm("ต้องการยกเลิก Invoice ที่เลือกไว้ใช่หรือไม่ ?", function(result) {
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