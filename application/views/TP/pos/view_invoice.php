<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>

  <?php
    foreach($invoice_array as $loop) {
      $inv_id = $loop->pinv_id;
      $total_net = $loop->pinv_price_net;
      $total_topup = $loop->pinv_price_topup;
      $total_tax = $loop->pinv_price_tax;
      $inv_status = $loop->pinv_status;
      $cus_id = $loop->pinv_customer_id;
      $cus_name = $loop->pinv_customer_name;
      $cus_address = $loop->pinv_customer_address;
      $cus_taxid = $loop->pinv_customer_taxid;
      $cus_telephone = $loop->pinv_customer_telephone;
      $saleperson_number = $loop->nggu_number;
      $saleperson_name = $loop->nggu_firstname." ".$loop->nggu_lastname;
			$small_invoice_number = $loop->pinv_small_invoice_number;
      $invoice_number = $loop->pinv_invoice_number;
			$issuedate = $loop->pinv_issuedate;
			$issue_array = explode('-', $issuedate);
			$issue_array[0] += 543;
			$issuedate = $issue_array[2]."/".$issue_array[1]."/".$issue_array[0];
      $remark = $loop->pinv_remark;
      $shop_name = $loop->pinv_shop_name;
      $shop_company = $loop->pinv_shop_company;
      $shop_address1 = $loop->pinv_shop_address1;
      $shop_address2 = $loop->pinv_shop_address2;
      $shop_telephone = $loop->pinv_shop_telephone;
      $shop_fax = $loop->pinv_shop_fax;
      $shop_taxid = $loop->pinv_shop_taxid;
      $shop_branch_no = $loop->pinv_shop_branch_no;
			$payment_id = $loop->pinv_payment_id;
    }

    $today = date("Y-m-d");
    $issue_array[0] -= 543;
    $issue = $issue_array[0]."-".$issue_array[1]."-".$issue_array[2];

  ?>

<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            POS -> ใบกำกับภาษีแบบเต็ม
				</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-10">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">ใบกำกับภาษีแบบเต็ม</h3>
            </div>
            <div class="box-body">
              <div class='row'>
                <div class='col-md-6'>
                  <?php echo $shop_company."<br/>".$shop_address1."<br/>".$shop_address2."<br/>Tax ID. ".$shop_taxid." ";
                  if ($shop_branch_no == 0) echo "Head Office";
                  else if ($shop_branch_no > 0) echo "Branch No. ".str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);
                  echo "<br/>";
                  if ($shop_telephone != "") echo "Tel. ".$shop_telephone." ";
                  if ($shop_fax != "") echo "Fax. ".$shop_fax;

                  ?>
                </div>
                <div class='col-md-6'>
                  <?php echo $cus_name."<br/>".$cus_address."<br/>Tax ID. ".$cus_taxid; ?>
                </div>
              </div>
              <br/>
              <div class='row'>
                <div class='col-md-6'>
                  <label>เลขที่ใบกำกับภาษี : </label> <?php echo $invoice_number; ?>
                </div>
                <div class='col-md-6'>
                  <label>วันที่ออก : </label> <?php echo $issuedate; ?>
                </div>
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <label>อ้างอิงใบกำกับภาษีอย่างย่อ : </label> <a href="<?php echo site_url("pos_sale/view_payment")."/".$payment_id; ?>"><?php echo $small_invoice_number; ?></a>
                </div>
                <div class='col-md-6'>
                  <label>สาขาที่ขาย : </label> <?php echo $shop_name; ?>
                </div>
              </div>
							<div class='row'>
                <div class='col-md-6'>
                  <label>สถานะ : </label> <?php if ($inv_status == 'N') echo "<label class='text-green'>ปกติ</label>";
									else if ($inv_status == 'V') echo "<label class='text-red'>ยกเลิกแล้ว</label>";
									?>
                </div>
                <div class='col-md-6'>

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
                        <td class="center-text"><?php echo $loop->pini_barcode; ?></td>
                        <td><?php echo $loop->pini_item_number."-".$loop->pini_item_name."<br>".$loop->pini_item_brand."<br>".$loop->pini_item_description; ?>
                        <?php  if ($loop->pini_item_serial != "")	echo "<br>Serial : ".$loop->pini_item_serial; ?>
                        </td>
                        <td class="center-text"><?php echo number_format($loop->pini_item_srp, 2,'.',','); ?></td>
                        <td class="center-text"><?php echo $loop->pini_item_qty." ".$loop->pini_item_uom; ?></td>
                        <td class="center-text"><?php echo number_format($loop->pini_item_dc_baht, 2,'.',','); ?></td>
                        <td class="center-text"><?php echo number_format($loop->pini_item_dc_percent); ?></td>
                        <td style="text-align:right;"><?php echo number_format($loop->pini_item_net, 2,'.',','); ?></td>
                      </tr>
                      <?php $sum_qty += $loop->pini_item_qty; } ?>
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

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div class='col-md-2'>

            <?php if ($inv_status == 'N') { ?><a href="<?php echo site_url("pos_invoice/print_invoice")."/".$inv_id; ?>" target="_blank" type="button" class="btn btn-primary btn-lg btn-block" name="btnInvoice" id="btnInvoice">พิมพ์ใบกำกับภาษี</a><?php } ?>

          <br/><br/><br/><br/>
          <?php if ($inv_status == 'N' && $user_status == 6) { ?><a type="button" href='<?php echo site_url('pos_invoice/void_invoice')."/".$inv_id; ?>' class="btn btn-danger btn-lg btn-block" name="btnVoid" id="btnVoid"><i class="fa fa-ban"></i> ยกเลิก (Void)<br>ใบกำกับภาษี</a><?php } ?>
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
      bootbox.confirm("ต้องการยกเลิกใบกำกับภาษีแบบเต็ม ที่เลือกไว้ใช่หรือไม่ ?", function(result) {
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
