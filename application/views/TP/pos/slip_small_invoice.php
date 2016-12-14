<!DOCTYPE html>
<html lang="en">
<head>
<link href="<?php echo base_url(); ?>asset/custom/css/thsarabun.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
foreach($payment_array as $loop) {
  $payment_id = $loop->posp_id;
  $total_net = $loop->posp_price_net;
  $total_topup = $loop->posp_price_topup;
  $total_tax = $loop->posp_price_tax;
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
  $shop_name = $loop->posp_shop_name;
  $dateadd = $loop->posp_dateadd;
}

foreach($shop_array as $loop) {
  $print_tax = $loop->posh_print_tax;
  $shop_name = $loop->posh_name;
  $shop_address1 = $loop->posh_address1;
  $shop_address2 = $loop->posh_address2;
  $shop_telephone = $loop->posh_telephone;
  $shop_fax = $loop->posh_fax;
  $shop_taxid = $loop->posh_taxid;
  $shop_company = $loop->posh_company;
  $shop_branch_no = $loop->posh_branch_no;
}

echo '<table border="0"><tbody><tr><td width="220px"><b style="font-size:16px">'.$shop_company.'</b><br />'.$shop_address1.' '.$shop_address2.'<br />Tax ID : '.$shop_taxid.' ';
if ($shop_branch_no == 0) echo 'Head Office';
else if ($shop_branch_no > 0) echo 'Branch No. '.str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);

echo ' ';
if ($shop_telephone != "") echo "Tel. ".$shop_telephone." ";
if ($shop_fax != "") echo "Fax. ".$shop_fax;
echo '<br>สาขา : '.$shop_name.'<br><br>';

echo '</td></tr><tr><td style="text-align:center;">ใบกำกับภาษีอย่างย่อ / ใบเสร็จรับเงิน</td></tr></tbody></table>';
echo '<table><tbody>';
echo '<tr><td width="110px">เลขที่ : </td><td width="110px" style="text-align:right;">'.$small_invoice_number.'</td></tr>';
echo '<tr><td width="110px">วันที่ : </td><td width="110px" style="text-align:right;">'.$issuedate.'</td></tr>';
//echo '<tr><td colspan="2">นามลูกค้า : '.$cus_name.' </td></tr>';
echo '</tbody></table>';
echo '<table><tbody>';
echo '<tr><td colspan="3"><hr></td></tr>';
echo '<tr><td width="110">Description</td><td width="30px" style="text-align:center;">Qty</td><td width="80" style="text-align:center;">Net</td></tr>';
echo '<tr><td colspan="3"><hr></td></tr>';

$qty = 0;
foreach ($item_array as $loop) {
  echo '<tr><td width="110">'.$loop->popi_item_number."<br>".$loop->popi_item_name;
    if ($loop->popi_item_serial != "")	echo "<br>Serial : ".$loop->popi_item_serial;
    echo '</td><td width="30" style="text-align:center;" valign="top">'.$loop->popi_item_qty.'</td>
    <td width="80" style="text-align:right;" valign="top">'.number_format($loop->popi_item_net, 2,'.',',').'</td></tr>';
    $qty += $loop->popi_item_qty;
}

// discount topup
if($total_topup > 0) {
  echo '<tr><td>ส่วนลดท้ายบิล</td><td></td>
    <td width="105" style="text-align:right;">- '.number_format($total_topup, 2,'.',',').'</td>
    </tr>';
}
echo '<tr><td style="text-align:right;">จำนวนรวม</td>
<td style="text-align:center;">'.$qty.'</td><td></td></tr>';
echo '<tr><td colspan="2" style="text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม</td>
<td style="text-align:right;">'.number_format($total_net-$total_topup-$total_tax, 2,'.',',').'</td>
</tr>';
// vat
echo '<tr>
<td colspan="2" style="text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 %</td>
<td style="text-align:right;">'.number_format($total_tax, 2,'.',',').'</td>
</tr>';
// total price vat
echo '<tr><td colspan="2" style="text-align:right;">จํานวนเงินรวมทั้งสิ้น</td>
<td style="text-align:right;">'.number_format($total_net-$total_topup, 2,'.',',').'</td>
</tr>';

echo '<tr><td colspan="3"><hr></td></tr>';
echo '<tr><td colspan="3">พนักงานขาย : '.$saleperson_name.'</td></tr><tr><td colspan="3">'.$dateadd.'</td></tr>';
echo '</tbody></table>';
?>

<script>
window.onload = function () {
    window.print();
    setTimeout(window.close, 0);
}
</script>
</body>
</html>
