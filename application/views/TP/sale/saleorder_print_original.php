<!DOCTYPE html>
<html>
<head>
<title>Sale Order Printing</title>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="450">
<div style="text-align: left; font-weight: bold; font-size: 20pt;">NGG TIMEPIECES COMPANY LIMITED</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek Sathon Bangkok 10120</div>
</td>
<?php foreach($so_array as $loop) { $datetime = $loop->so_issuedate; $so_id = $loop->so_number; $editor = $loop->firstname." ".$loop->lastname;
  $shop = $loop->sh_code."-".$loop->sh_name; $dateadd = $loop->so_dateadd; $so_remark = $loop->so_remark; $on_top_baht = $loop->so_ontop_baht; break; }

 $GGyear=substr($datetime,0,4);
 $GGmonth=substr($datetime,5,2);
 $GGdate=substr($datetime,8,2);
?>
<td width="50"> </td>
<td width="200"><div style="text-align: right; font-weight: bold; font-size: 16pt;">ใบสั่งขาย</div></td>
</tr>
<tr>
    <td>สาขาที่ขาย : <?php echo $shop; ?><br>วันที่บันทึก : <?php echo $dateadd; ?><br>Remark: <?php echo $so_remark; ?></td><td> </td><td>เลขที่ <?php echo $so_id; ?><br>ชื่อผู้ใส่ข้อมูล:  <?php echo $editor; ?><br>วันที่ : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="30" style="border-bottom:1px solid black;">No.</th><th width="120" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number</th><th width="230" style="border-left:1px solid black;border-bottom:1px solid black;">รายละเอียดสินค้า</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="150" style="border-left:1px solid black;border-bottom:1px solid black;">Discount/GP</th><th width="140" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $sum=0; $sum_qty=0; $serial_exist = array(); $serial_index = 0; if(isset($item_array)) { foreach($item_array as $loop) {
?>
<tr style="border:1px solid black;"><td align="center"><?php echo $no; ?></td>
<td style="border-left:1px solid black;"><?php echo $loop->it_refcode; ?></td>
<td style="border-left:1px solid black;"><?php echo $loop->br_name." ".$loop->it_model; ?></td>
<td align="center" style="border-left:1px solid black;">
<?php
$qty = 0;
// $log_return_item_id = 0;
// foreach($return_item_array as $loop_item_return) {
//   if ($loop_item_return->log_stor_item_id == $loop->soi_item_id) {
//     $qty += $loop_item_return->qty_final;
//     $log_return_item_id = $loop_item_return->log_stor_item_id;
//     $loop_item_return->log_stor_item_id = 0;
//     $loop_item_return->qty_final = 0;
//   }
// }
// $return_serial_qty = $qty;
$qty += $loop->soi_qty;
echo $qty." ".$loop->it_uom; ?>
</td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
<td align="center" style="border-left:1px solid black;">
<?php
if ($loop->soi_sale_barcode_id > 0) echo "Discount".$loop->sb_discount_percent."% GP".$loop->sb_gp."%(".$loop->sb_number.")";
else if ($loop->soi_sale_barcode_id == 0) echo "ไม่มีบาร์โค้ดห้าง";
else if ($loop->soi_sale_barcode_id == -1) echo "Discount".$loop->soi_dc_percent."% GP".$loop->soi_gp."% Discount".$loop->soi_dc_baht."บาท";
?>
</td>
<td align="right" style="border-left:1px solid black;">
<?php
if ($loop->soi_sale_barcode_id > -1) { $cal = ($qty*$loop->it_srp)*((100-$loop->sb_discount_percent)/100)*((100-$loop->sb_gp)/100); echo number_format($cal, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $cal; $sum_qty += $qty; }
else if ($loop->soi_sale_barcode_id == -1) { $cal = (($qty*$loop->it_srp)*((100-$loop->soi_dc_percent)/100)- ($qty*$loop->soi_dc_baht))*((100-$loop->soi_gp)/100); echo number_format($cal, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $cal; $sum_qty += $qty; }
?></td>
</tr>
<?php
// print serial number
$current_qty = $loop->soi_qty;
if(isset($serial_array)) {
    foreach ($serial_array as $loop2) {
        if ($loop->soi_id==$loop2->sos_soi_id && $current_qty>0) {
            $check_exist = true;
            for($k=0; $k<count($serial_exist); $k++) {
                if ($loop2->itse_serial_number == $serial_exist[$k]) { $check_exist = false; } }
            if ($check_exist) { ?>
<tr style="border:1px solid black;"><td align="center"></td>
<td align="center" style="border-left:1px solid black;"></td>
<td style="border-left:1px solid black;"><?php echo "Caseback : ".$loop2->itse_serial_number; $serial_exist[$serial_index]=$loop2->itse_serial_number; $serial_index++; $current_qty--; ?>
</td>
<td align="center" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
</tr>
    <?php
        } }
    }
}
// print return serial number

?>
<?php $no++; } }

?>
<?php if ($on_top_baht > 0) { ?>
<tr style="border:1px solid black;"><td align="center"></td>
<td align="center" style="border-left:1px solid black;"></td>
<td style="border-left:1px solid black;">ส่วนลดท้ายบิล</td>
<td align="center" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"><?php echo "-".number_format($on_top_baht, 2, '.', ',')."&nbsp;&nbsp;"; $sum -= $on_top_baht; ?></td>
</tr>
<?php } ?>
<tr><td style="border-top:1px solid black;" colspan="2">&nbsp;</td><td align="right" style="border-top:1px solid black; ">รวมจำนวน</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum_qty; ?></td><td align="right" style="border-top:1px solid black; border-left:1px solid black;" colspan="2">รวมเงิน</td>
  <td align="right" style="border-left:1px solid black;border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ',')."&nbsp;&nbsp;"; ?></td></tr>

</tbody>
</table>
<table style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td width="350" align="center">ผู้ใส่ข้อมูล</td><td width="350" align="center">ผู้อนุมัติ</td>
</tr>
<tr><td> </td><td>&nbsp;</td></tr>
<tr><td align="center">..........................................................</td><td align="center">  &nbsp;&nbsp;&nbsp; ..........................................................</td>
</tr>
<tr><td align="center"><?php echo $editor; ?></td><td> &nbsp;</td></tr>
<tbody>
</table>
</body>
</html>
