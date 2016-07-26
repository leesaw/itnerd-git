<!DOCTYPE html>
<html>
<head>
<title>Invoice Printing</title>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="300">
<div style="text-align: left; font-weight: bold; font-size: 18pt;">NGG TIMEPIECES COMPANY LIMITED </div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd.</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">Thungmahamek Sathon Bangkok 10120</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">เลขประจำตัวผู้เสียภาษี 0105555081331  สำนักงานใหญ่</div>
</td> 
<?php foreach($inv_array as $loop) { $datetime = $loop->inv_issuedate; $number = $loop->inv_number; $cusname = $loop->inv_warehouse_detail; $cusaddress1 = $loop->inv_warehouse_address1; $cusaddress2 = $loop->inv_warehouse_address2; $custaxid = $loop->inv_warehouse_taxid; $vender=$loop->inv_vender; $barcode=$loop->inv_barcode; 
if ($loop->inv_warehouse_branch == 0) $cusbranch = "สำนักงานใหญ่"; else $cusbranch = "สาขาที่ ".str_pad($loop->inv_warehouse_branch, 5, '0', STR_PAD_LEFT); } 

 $GGyear=substr($datetime,0,4); 
 $GGmonth=substr($datetime,5,2); 
 $GGdate=substr($datetime,8,2); 
?>
<td width="200"> </td>
    <td width="200" style="text-align: right;"><div style="font-weight: bold; font-size: 16pt;">ใบกำกับภาษี/ ใบส่งสินค้า/ ใบเสร็จรับเงิน</div></td>
</tr>
</tbody>
</table>
<br>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
<tr>
	<td width="20"></td>
	<td width="50" valign="top">นามผู้ซื้อ</td>
    <td width="380" style="border-right:1px solid black;" valign="top"><?php echo $cusname; ?><br><?php echo $cusaddress1; ?><br><?php echo $cusaddress2; ?><br>เลขประจำตัวผู้เสียภาษี  <?php echo $custaxid; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cusbranch; ?></td><td width="20"> </td><td width="50" valign="top">เลขที่ใบกำกับ<br>วันที่</td><td width="180" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $number; ?><br>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $GGdate."/".$GGmonth."/".$GGyear; ?>
    </td>
</tr>
</tbody>
</table>
<br>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="120" style="border-bottom:1px solid black;">รหัสสินค้า</th><th width="200" style="border-left:1px solid black;border-bottom:1px solid black;">รายละเอียด</th><th width="95" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="95" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="95" style="border-left:1px solid black;border-bottom:1px solid black;">ส่วนลด</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $page_no = 0; $sum=0; $sum_qty=0; if(isset($item_array)) { foreach($item_array as $loop) { 
?>
<tr style="border:1px solid black;"><td align="center" valign="top"><?php echo $loop->invit_refcode; ?></td>
<td style="border-left:1px solid black;" align="center" valign="top"><?php echo $loop->invit_brand; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo $loop->invit_qty; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo $loop->invit_srp; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo $loop->invit_discount; ?> %</td>
<td align="right" style="border-left:1px solid black;" valign="top"><?php echo $loop->invit_netprice."&nbsp;&nbsp;"; $sum += $loop->invit_netprice; ?></td>
</tr>
<?php $no++; 

if ($no >10) { $no=1; $page_no++; ?>
<tr><td height="120">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td></tr>

<tr style="border:1px solid black;"><td align="center" valign="top"></td>
<td style="border-left:1px solid black;" align="center" valign="top"><?php echo "หน้าที่ ".$page_no." / ".$totalpage; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="right" style="border-left:1px solid black;" valign="top"></td>
</tr>
<tr style="border:1px solid black;"><td align="center" valign="top"></td>
<td style="border-left:1px solid black;" align="center" valign="top"><?php echo "VENDER CODE &nbsp;&nbsp;&nbsp;&nbsp; ".$vender; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="right" style="border-left:1px solid black;" valign="top"></td>
</tr>
<tr style="border:1px solid black;"><td align="center" valign="top"></td>
<td style="border-left:1px solid black;" align="center" valign="top"><?php echo "BARCODE &nbsp;&nbsp;&nbsp;&nbsp; ".$barcode; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="right" style="border-left:1px solid black;" valign="top"></td>
</tr>
<tr><td height="50">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td></tr>

</tbody>
<tbody>
<tr>
<td align="right" colspan=5 scope="row" style="border-top:1px solid black;">รวมเป็นเงิน&nbsp;&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;"></td>
</tr>
<tr>
<td align="right" colspan=5 scope="row">จำนวนภาษีมูลค่าเพิ่ม&nbsp;&nbsp;7 %&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black;"></td>
</tr>
<tr>
<td height="40" align="left" colspan=3 scope="row" style="border-top:1px solid black;"></td>
<td align="right" colspan=2 scope="row" style="border-top:1px solid black;">จำนวนเงินรวมทั้งสิ้น&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black; border-top:1px solid black;"></td>
</tr>
</tbody>
</table>
<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr>
<td width="180" align="center" style="border-left:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td><td width="180" align="center" style="border-left:1px solid black;"> </td>
<td width="180" align="center" style="border-left:1px solid black;"> </td><td width="182" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="50" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
<td align="center" style="border-left:1px solid black;"> </td><td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
<td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
<td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
<td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td><td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้จัดการ / Manager</td>
</tr>
</tbody>
</table>
<pagebreak>
<table border="0">
<tbody>
<tr>
<td width="300">
<div style="text-align: left; font-weight: bold; font-size: 18pt;">NGG TIMEPIECES COMPANY LIMITED </div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd.</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">Thungmahamek Sathon Bangkok 10120</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">เลขประจำตัวผู้เสียภาษี 0105555081331  สำนักงานใหญ่</div>
</td> 
<td width="200"> </td>
    <td width="200" style="text-align: right;"><div style="font-weight: bold; font-size: 16pt;">ใบกำกับภาษี/ ใบส่งสินค้า/ ใบเสร็จรับเงิน</div></td>
</tr>
</tbody>
</table>
<br>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
<tr>
	<td width="20"></td>
	<td width="50" valign="top">นามผู้ซื้อ</td>
    <td width="380" style="border-right:1px solid black;" valign="top"><?php echo $cusname; ?><br><?php echo $cusaddress1; ?><br><?php echo $cusaddress2; ?><br>เลขประจำตัวผู้เสียภาษี  <?php echo $custaxid; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cusbranch; ?></td><td width="20"> </td><td width="50" valign="top">เลขที่ใบกำกับ<br>วันที่</td><td width="180" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $number; ?><br>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $GGdate."/".$GGmonth."/".$GGyear; ?>
    </td>
</tr>
</tbody>
</table>
<br>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="120" style="border-bottom:1px solid black;">รหัสสินค้า</th><th width="200" style="border-left:1px solid black;border-bottom:1px solid black;">รายละเอียด</th><th width="95" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="95" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="95" style="border-left:1px solid black;border-bottom:1px solid black;">ส่วนลด</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php
}


} } $page_no++;  ?> 

<?php if ($no<=10) { for($i=10-$no; $i>0; $i--) { ?> 
<tr><td height="30">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td></tr>
<?php } } ?>

<tr><td height="100">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td></tr>

<tr style="border:1px solid black;"><td align="center" valign="top"></td>
<td style="border-left:1px solid black;" align="center" valign="top"><?php echo "หน้าที่ ".$page_no." / ".$totalpage; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="right" style="border-left:1px solid black;" valign="top"></td>
</tr>
<tr style="border:1px solid black;"><td align="center" valign="top"></td>
<td style="border-left:1px solid black;" align="center" valign="top"><?php echo "VENDER CODE &nbsp;&nbsp;&nbsp;&nbsp; ".$vender; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="right" style="border-left:1px solid black;" valign="top"></td>
</tr>
<tr style="border:1px solid black;"><td align="center" valign="top"></td>
<td style="border-left:1px solid black;" align="center" valign="top"><?php echo "BARCODE &nbsp;&nbsp;&nbsp;&nbsp; ".$barcode; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="center" style="border-left:1px solid black;" valign="top"></td>
<td align="right" style="border-left:1px solid black;" valign="top"></td>
</tr>
<tr><td height="50">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td></tr>

</tbody>
<tbody>
<tr>
<td align="right" colspan=5 scope="row" style="border-top:1px solid black;">รวมเป็นเงิน&nbsp;&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;"><?php  echo number_format($sum/1.07, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
<tr>
<td align="right" colspan=5 scope="row">จำนวนภาษีมูลค่าเพิ่ม&nbsp;&nbsp;7 %&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black;"><?php echo number_format(($sum/1.07)*0.07, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
<tr>
<td height="40" align="left" colspan=3 scope="row" style="border-top:1px solid black;">( <?php echo num2thai($sum); ?> )</td>
<td align="right" colspan=2 scope="row" style="border-top:1px solid black;">จำนวนเงินรวมทั้งสิ้น&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black; border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
</tbody>
<?php
function num2thai($number){
$t1 = array("ศูนย์", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
$t2 = array("เอ็ด", "ยี่", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน");
$zerobahtshow = 0; // ในกรณีที่มีแต่จำนวนสตางค์ เช่น 0.25 หรือ .75 จะให้แสดงคำว่า ศูนย์บาท หรือไม่ 0 = ไม่แสดง, 1 = แสดง
(string) $number;
$number = explode(".", $number);
if(!empty($number[1])){
if(strlen($number[1]) == 1){
$number[1] .= "0";
}else if(strlen($number[1]) > 2){
if($number[1]{2} < 5){
$number[1] = substr($number[1], 0, 2);
}else{
$number[1] = $number[1]{0}.($number[1]{1}+1);
}
}
}

for($i=0; $i<count($number); $i++){
$countnum[$i] = strlen($number[$i]);
if($countnum[$i] <= 7){
$var[$i][] = $number[$i];
}else{
$loopround = ceil($countnum[$i]/6);
for($j=1; $j<=$loopround; $j++){
if($j == 1){
$slen = 0;
$elen = $countnum[$i]-(($loopround-1)*6);
}else{
$slen = $countnum[$i]-((($loopround+1)-$j)*6);
$elen = 6;
}
$var[$i][] = substr($number[$i], $slen, $elen);
}
}	

$nstring[$i] = "";
for($k=0; $k<count($var[$i]); $k++){
if($k > 0) $nstring[$i] .= $t2[7];
$val = $var[$i][$k];
$tnstring = "";
$countval = strlen($val);
for($l=7; $l>=2; $l--){
if($countval >= $l){
$v = substr($val, -$l, 1);
if($v > 0){
if($l == 2 && $v == 1){
$tnstring .= $t2[($l)];
}elseif($l == 2 && $v == 2){
$tnstring .= $t2[1].$t2[($l)];
}else{
$tnstring .= $t1[$v].$t2[($l)];
}
}
}
}
if($countval >= 1){
$v = substr($val, -1, 1);
if($v > 0){
if($v == 1 && $countval > 1 && substr($val, -2, 1) > 0){
$tnstring .= $t2[0];
}else{
$tnstring .= $t1[$v];
}

}
}

$nstring[$i] .= $tnstring;
}

}
$rstring = "";
if(!empty($nstring[0]) || $zerobahtshow == 1 || empty($nstring[1])){
if($nstring[0] == "") $nstring[0] = $t1[0];
$rstring .= $nstring[0]."บาท";
}
if(count($number) == 1 || empty($nstring[1])){
$rstring .= "ถ้วน";
}else{
$rstring .= $nstring[1]."สตางค์";
}
return $rstring;
}

?>
</table>
<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr>
<td width="180" align="center" style="border-left:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td><td width="180" align="center" style="border-left:1px solid black;"> </td>
<td width="180" align="center" style="border-left:1px solid black;"> </td><td width="182" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="50" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
<td align="center" style="border-left:1px solid black;"> </td><td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
<td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
<td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
<td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td><td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้จัดการ / Manager</td>
</tr>
</tbody>
</table>
</body>
</html>