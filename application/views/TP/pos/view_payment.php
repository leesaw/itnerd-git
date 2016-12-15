<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>

  <?php
      foreach($payment_array as $loop) {
        $payment_id = $loop->posp_id;
        $total_net = $loop->posp_price_net;
        $total_topup = $loop->posp_price_topup;
        $total_tax = $loop->posp_price_tax;
        $payment_status = $loop->posp_status;
        $cus_name = $loop->posc_name;
        $cus_address = $loop->posc_address;
        $cus_taxid = $loop->posc_taxid;
        $cus_telephone = $loop->posc_telephone;
        $saleperson_number = $loop->nggu_number;
        $saleperson_name = $loop->nggu_firstname." ".$loop->nggu_lastname;
  			$small_invoice_number = $loop->posp_small_invoice_number;
  			$issuedate = $loop->posp_issuedate;
  			$issue_array = explode('-', $issuedate);
  			$issue_array[0] += 543;
  			$issuedate = $issue_array[2]."/".$issue_array[1]."/".$issue_array[0];
        $remark = $loop->posp_remark;
        $pos_shop_id = $loop->posp_shop_id;
				$shop_name = $loop->posp_shop_name;
      }

      foreach($shop_array as $loop) {
        $print_tax = $loop->posh_print_tax;
      }

      $today = date("Y-m-d");
      $issue_array[0] -= 543;
      $issue = $issue_array[0]."-".$issue_array[1]."-".$issue_array[2];
    ?>

<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            POS -> ใบกำกับภาษีอย่างย่อ
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-md-9">
            <div class="box box-success">
              <div class="box-header with-border">
                <div class='row'>
                  <div class='col-md-4'>
                    <?php if ($payment_status == 'N') { ?><a href="<?php echo site_url("pos_sale/print_slip_small_invoice")."/".$payment_id; ?>" target="_blank" type="button" class="btn btn-primary btn-lg" name="btnSmallInvoice" id="btnSmallInvoice"><i class="fa fa-print"></i> พิมพ์ใบกำกับภาษีอย่างย่อ</a><?php } ?>
                  </div>
                  <div class='col-md-8' style='text-align:right;'>
                    <form action="<?php echo site_url('pos_sale/void_payment')."/".$payment_id; ?>" method="post" name="frmVoid" id ="frmVoid"><input type="hidden" name="pos_shop_id" value="<?php echo $pos_shop_id; ?>"><input type="hidden" name="remarkvoid" id="remarkvoid" value=""></form>
                    <?php if (($user_status == 6) && ($payment_status == 'N')) { ?><a type="button" class="btn bg-orange btn-lg" name="btnVoid" id="btnVoid"><i class="fa fa-ban"></i> ยกเลิกการขาย (Void)</a><?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php if (($user_status == 6) && ($print_tax != 0) && ($had_payment == 0) && ($payment_status == 'N')) { ?><a type="button" href='<?php echo site_url('pos_sale/convert_invoice')."/".$payment_id; ?>' class="btn btn-danger btn-lg" name="btnInvoice" id="btnInvoice"><i class="fa fa-file-text-o"></i> เปลี่ยนเป็นใบกำกับภาษี</a><?php } ?>
                  </div>
                </div>
              </div>
              <div class="box-body">
								<div class='row'>
									<div class='col-md-4'>
										<label>POS : </label> <?php echo $shop_name; ?>
									</div>
								</div>
                <div class='row'>
                  <div class='col-md-4'>
                    <label>เลขที่ใบกำกับภาษีอย่างย่อ : </label> <?php echo $small_invoice_number; ?>
                  </div>
                  <div class='col-md-4'>
                    <label>วันที่ออกใบกำกับภาษีอย่างย่อ : </label> <?php echo $issuedate; ?>
                  </div>
                  <div class='col-md-4'>
                    <label>สถานะ : </label> <?php if ($payment_status == 'N') echo "<label class='text-green'>ปิดการขาย</label>";
                    else if ($payment_status == 'V') echo "<label class='text-red'>ยกเลิกแล้ว</label>";
                    else if ($payment_status == 'T') echo "<label class='text-orange'>เปลี่ยนเป็นใบกำกับภาษีแบบเต็มแล้ว</label><br><a href='".site_url("pos_sale/view_invoice_abb_id")."/".$payment_id."' type='button' class='btn btn-success btn-sm'>ดูใบกำกับภาษี</a>"; ?>
                  </div>
                </div>
                <br/>

                <div class='row'>
                  <div class='col-md-12 table-responsive'>
                    <table class='table table-bordered' id='itemlist'>
                      <thead>
                        <th class='col-xs-2 center-text'>Barcode</th>
                        <th class='col-xs-3 center-text'>สินค้า</th>
                        <th class='col-xs-1 center-text'>ราคาป้าย</th>
                        <th class='col-xs-1 center-text'>จำนวน</th>
                        <th class='col-xs-1 center-text'>ส่วนลด(บาท)</th>
                        <th class='col-xs-1 center-text'>ส่วนลด(%)</th>
                        <th class='col-xs-2' style="text-align:right;">Net</th>
                      </thead>
                      <tbody>
                        <?php $sum_qty = 0; foreach($item_array as $loop) { ?>
                        <tr>
                          <td class="center-text"><?php echo $loop->popi_barcode; ?></td>
                          <td><?php echo $loop->popi_item_number."-".$loop->popi_item_name."<br>".$loop->popi_item_brand."<br>".$loop->popi_item_description; ?>
                          <?php  if ($loop->popi_item_serial != "")	echo "<br>Serial : ".$loop->popi_item_serial; ?>
                          </td>
                          <td class="center-text"><?php echo number_format($loop->popi_item_srp, 2,'.',','); ?></td>
                          <td class="center-text"><?php echo $loop->popi_item_qty." ".$loop->popi_item_uom; ?></td>
                          <td class="center-text"><?php echo number_format($loop->popi_item_dc_baht, 2,'.',','); ?></td>
                          <td class="center-text"><?php echo number_format($loop->popi_item_dc_percent); ?></td>
                          <td style="text-align:right;"><?php echo number_format($loop->popi_item_net, 2,'.',','); ?></td>
                        </tr>
                        <?php $sum_qty += $loop->popi_item_qty; } ?>
                        <?php if($total_topup > 0) { ?>
                        <tr><td></td><td>ส่วนลดท้ายบิล</td><td colspan="4"></td><td style="text-align:right;"><?php echo "- ".number_format($total_topup, 2,'.',','); ?></td></tr>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3" style="text-align:right;">จำนวน</td>
                          <td class="center-text"><?php echo $sum_qty; ?></td>
                          <td colspan="2" style="text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม</td>
                          <td style="text-align:right;"><?php echo number_format($total_net-$total_topup-$total_tax, 2,'.',','); ?></td>
                        </tr>
                        <tr><td colspan="4"></td><td colspan="2" style="text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 %</td><td style="text-align:right;"><?php echo number_format($total_tax, 2,'.',','); ?></td></tr>
                        <tr><td colspan="4"></td><td colspan="2" style="text-align:right;">จํานวนเงินรวมทั้งสิ้น</td><td style="text-align:right;"><?php echo number_format($total_net-$total_topup, 2,'.',','); ?></td></tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <div class='row'>
                  <div class="col-md-10">
                    <label class="control-label" for="paymentRemark">หมายเหตุ </label>
                    <input type="text" class="form-control" id="paymentRemark" name="paymentRemark" value="<?php echo $remark; ?>" readonly/>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class='col-md-3'>
            <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">ข้อมูลลูกค้า</h3>
                </div>
                <div class="box-body">
                  <div class='row'>
                    <div class='col-md-12'>
                      เลขสมาชิก / เบอร์ติดต่อ
                      <input type='text' name='cusTelephone_view' id='cusTelephone_view' class='form-control' value='<?php echo $cus_telephone; ?>' disabled>
                    </div>
                    <div class='col-md-12'>
                      ชื่อ-นามสกุล
                      <input type='hidden' name='customer_id' id='customer_id' value='0'>
                      <input type='text' name='cusName_view' id='cusName_view' class='form-control' value='<?php echo $cus_name; ?>' disabled>
                    </div>
                    <!-- <div class='col-md-12'>
                      ที่อยู่
                      <input type='text' name='cusAddress_view' id='cusAddress_view' class='form-control' value='' disabled>
                    </div>
                    <div class='col-md-12'>
                      เลขที่ผู้เสียภาษี
                      <input type='text' name='cusTaxID_view' id='cusTaxID_view' class='form-control' value='' disabled>
                    </div> -->
                  </div>
                <hr/>
                <div class='row'>
                  <div class='col-md-5'>
                    รหัสพนักงาน
                    <input type='text' name='staffCode' id='staffCode' class='form-control' value='<?php echo $saleperson_number; ?>' disabled>

                  </div>
                  <div class='col-md-7'>
                    ชื่อ-นามสกุลพนักงาน
                    <input type='text' name='staffName' id='staffName' class='form-control' value='<?php echo $saleperson_name; ?>' disabled>
                  </div>
                </div>
                <hr/>
                <h3>ชำระเงิน</h3>
              <div class='row'>
                <div class='col-md-12'>
                  <table class="table table-condensed" id='payment_list'>
                    <tbody>
                      <?php foreach($paid_array as $loop) { ?>
                        <tr><td><?php echo $loop->paid_gateway; ?></td><td><?php echo number_format($loop->paid_price_paid, 2,'.',','); ?></td></tr>

                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
                </div>
          </div>
      </div>
        </div>
        <!-- /.row -->

        </section>



</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#btnEdit").click(function() {
    var message = "ต้องการแก้ไขข้อมูลการขายนี้ ใช่หรือไม่ !";
    return confirm(message);
  });

  $("#btnVoid").click(function() {
      bootbox.confirm("ต้องการยกเลิกการสั่งขาย ที่เลือกไว้ใช่หรือไม่ ?", function(result) {
        var currentForm = this;
        if (result) {
            bootbox.prompt("เนื่องจาก..", function(result) {
              if (result === null) {
                document.getElementById("frmVoid").submit();
              } else {
                document.getElementById("remarkvoid").value=result;
                document.getElementById("frmVoid").submit();
              }
            });
        }

      });
  });


});
</script>
</body>
</html>
