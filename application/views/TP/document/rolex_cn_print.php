<!DOCTYPE html>
<html>
<head>
<title>POS Printing</title>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="100"><img src="<?php echo base_url(); ?>dist/img/logo-nggtp.jpg" width="100px" /></td>
<td width="320">
<div style="text-align: left; font-weight: bold; font-size: 18pt;">NGG TIMEPIECES COMPANY LIMITED </div><br\><div style="text-align: left; font-weight: font-size: 16pt;">277/1-3,271/5 Prajaksillapakhom Rd., Tambon Markkeang</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">Amphur Mungudonthani, Udonthani 41000, Thailand</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">เลขประจำตัวผู้เสียภาษี 0105555081331  สาขาที่ 00001</div>
</td> 
<?php foreach($pos_array as $loop) { $datetime = $loop->posro_issuedate; $so_id = $loop->posro_number; $editor = $loop->firstname." ".$loop->lastname; $shop = $loop->sh_name; $cusname = $loop->posro_customer_name; $cusaddress = $loop->posro_customer_address; $custaxid = $loop->posro_customer_taxid; $cuspassport = $loop->posro_customer_passport; break; } 

 $GGyear=substr($datetime,0,4); 
 $GGmonth=substr($datetime,5,2); 
 $GGdate=substr($datetime,8,2); 
?>
<td width="50"> </td>
    <td width="200" style="text-align: right;"><div style="font-weight: bold; font-size: 16pt;">ใบลดหนี้ / Credit Note</div><div style="font-weight: bold; font-size: 16pt;">ต้นฉบับ</div></td>
</tr>
<tr>
    <td width="300" colspan="2">นามผู้ซื้อ : <?php echo $cusname; ?><br>ที่อยู่ : <?php $strlen = mb_strlen($cusaddress); echo $cusaddress; ?><br>เลขประจำตัวผู้เสียภาษี : <?php echo $custaxid; if ($cuspassport !="") echo " &nbsp;&nbsp;&nbsp; Passport No. : ".$cuspassport; if ($strlen < 75) echo "<br>&nbsp;"; ?></td><td> </td><td colspan="2">เลขที่ใบลดหนี้: NGGCN1607001<br>วันที่ : <br>เลขที่ใบกำกับภาษี: <?php echo $so_id; ?><br>สาขาที่ขาย : <?php echo $shop; ?><br>พนักงานขาย:  <?php echo $editor; ?><br>วันที่ใบกำกับภาษี : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?>
    </td>
</tr>
</tbody>
</table>
<br>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="30" style="border-bottom:1px solid black;">No.</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Serial Number</th><th width="250" style="border-left:1px solid black;border-bottom:1px solid black;">รายละเอียดสินค้า</th><th width="50" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="120" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="140" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $sum=0; $sum_qty=0; if(isset($item_array)) { foreach($item_array as $loop) { 
?>
<tr style="border:1px solid black;"><td align="center" valign="top"><?php echo $no; ?></td>
<td style="border-left:1px solid black;" align="center" valign="top"><?php echo $loop->itse_serial_number; ?></td>
<td style="border-left:1px solid black;" valign="top"><?php echo $loop->br_name." ".$loop->it_refcode." ".$loop->it_model; ?><br><?php echo $loop->it_remark." , ".$loop->it_short_description; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo $loop->posroi_qty." ".$loop->it_uom; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo number_format($loop->posroi_netprice, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
<td align="right" style="border-left:1px solid black;" valign="top"><?php $cal = $loop->posroi_qty*$loop->posroi_netprice; echo number_format($cal, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $cal; $sum_qty += $loop->posroi_qty; ?></td>
</tr>
<?php $no++; } } ?> 

<?php if ($no*2<=24) { for($i=24-$no*2; $i>0; $i--) {?> 
<tr><td>&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td></tr>
<?php } } ?>

</tbody>
<tbody>
<tr>
<td align="right" colspan=5 scope="row" style="border-top:1px solid black;">รวมเป็นเงิน&nbsp;&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;"><?php  echo number_format($sum/1.07, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
<tr>
<td align="right" colspan=5 scope="row"><u>หัก</u>&nbsp;ส่วนลด&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black;"><?php echo number_format(0, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
<tr>
<td align="right" colspan=5 scope="row">จำนวนเงินหลังหักส่วนลด&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black;"><?php echo number_format($sum/1.07, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
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
<td width="170" align="center" style="border-left:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td><td width="170" align="center" style="border-left:1px solid black;"> </td>
<td width="170" align="center" style="border-left:1px solid black;"> </td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="50" align="center" style="border-left:1px solid black;">&nbsp;</td><td width="170" align="center" style="border-left:1px solid black;"> </td>
<td width="170" align="center" style="border-left:1px solid black;"> </td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td width="170" align="center" style="border-left:1px solid black;">......................................</td><td width="170" align="center" style="border-left:1px solid black;">......................................</td>
<td width="170" align="center" style="border-left:1px solid black;">......................................</td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td width="170" align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td width="170" align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
<td width="170" align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td width="170" align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td width="170" align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
<td width="170" align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้จัดการ / Manager</td>
</tr>
<tbody>
</table>

<pagebreak />
    
<table border="0">
<tbody>
<tr>
<td width="100"><img src="<?php echo base_url(); ?>dist/img/logo-nggtp.jpg" width="100px" /></td>
<td width="320">
<div style="text-align: left; font-weight: bold; font-size: 18pt;">NGG TIMEPIECES COMPANY LIMITED </div><br\><div style="text-align: left; font-weight: font-size: 16pt;">277/1-3,271/5 Prajaksillapakhom Rd., Tambon Markkeang</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">Amphur Mungudonthani, Udonthani 41000, Thailand</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">เลขประจำตัวผู้เสียภาษี 0105555081331  สาขาที่ 00001</div>
</td> 
<?php foreach($pos_array as $loop) { $datetime = $loop->posro_issuedate; $so_id = $loop->posro_number; $editor = $loop->firstname." ".$loop->lastname; $shop = $loop->sh_name; $cusname = $loop->posro_customer_name; $cusaddress = $loop->posro_customer_address; $custaxid = $loop->posro_customer_taxid; break; } 

 $GGyear=substr($datetime,0,4); 
 $GGmonth=substr($datetime,5,2); 
 $GGdate=substr($datetime,8,2); 
?>
<td width="50"> </td>
    <td width="200" style="text-align: right;"><div style="font-weight: bold; font-size: 16pt;">ใบกำกับภาษี/ ใบส่งสินค้า/ ใบเสร็จรับเงิน</div><div style="font-weight: bold; font-size: 16pt;">สำเนา</div></td>
</tr>
<tr>
    <td width="300" colspan="2">นามผู้ซื้อ : <?php echo $cusname; ?><br>ที่อยู่ : <?php $strlen = mb_strlen($cusaddress); echo $cusaddress; ?><br>เลขประจำตัวผู้เสียภาษี : <?php echo $custaxid; if ($strlen < 75) echo "<br>&nbsp;"; ?></td><td> </td><td colspan="2">เลขที่ใบกำกับภาษี: <?php echo $so_id; ?><br>สาขาที่ขาย : <?php echo $shop; ?><br>พนักงานขาย:  <?php echo $editor; ?><br>วันที่ : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?>
    </td>
</tr>
</tbody>
</table>
<br>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="30" style="border-bottom:1px solid black;">No.</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Serial Number</th><th width="250" style="border-left:1px solid black;border-bottom:1px solid black;">รายละเอียดสินค้า</th><th width="50" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="120" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="140" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $sum=0; $sum_qty=0; if(isset($item_array)) { foreach($item_array as $loop) { 
?>
<tr style="border:1px solid black;"><td align="center" valign="top"><?php echo $no; ?></td>
<td style="border-left:1px solid black;" align="center" valign="top"><?php echo $loop->itse_serial_number; ?></td>
<td style="border-left:1px solid black;" valign="top"><?php echo $loop->br_name." ".$loop->it_refcode." ".$loop->it_model; ?><br><?php echo $loop->it_remark." , ".$loop->it_short_description; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo $loop->posroi_qty." ".$loop->it_uom; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo number_format($loop->posroi_netprice, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
<td align="right" style="border-left:1px solid black;" valign="top"><?php $cal = $loop->posroi_qty*$loop->posroi_netprice; echo number_format($cal, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $cal; $sum_qty += $loop->posroi_qty; ?></td>
</tr>
<?php $no++; } } ?> 

<?php if ($no*2<=24) { for($i=24-$no*2; $i>0; $i--) {?> 
<tr><td>&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td><td style="border-left:1px solid black;">&nbsp;</td></tr>
<?php } } ?>

</tbody>
<tbody>
<tr>
<td align="right" colspan=5 scope="row" style="border-top:1px solid black;">รวมเป็นเงิน&nbsp;&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;"><?php  echo number_format($sum*0.93, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
<tr>
<td align="right" colspan=5 scope="row"><u>หัก</u>&nbsp;ส่วนลด&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black;"><?php echo number_format(0, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
<tr>
<td align="right" colspan=5 scope="row">จำนวนเงินหลังหักส่วนลด&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black;"><?php echo number_format($sum*0.93, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
<tr>
<td align="right" colspan=5 scope="row">จำนวนภาษีมูลค่าเพิ่ม&nbsp;&nbsp;7 %&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black;"><?php echo number_format($sum*0.07, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
<tr>
<td height="40" align="left" colspan=3 scope="row" style="border-top:1px solid black;">( <?php echo num2thai($sum); ?> )</td>
<td align="right" colspan=2 scope="row" style="border-top:1px solid black;">จำนวนเงินรวมทั้งสิ้น&nbsp;&nbsp;</td><td align="right" style="border-left:1px solid black; border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
</tbody>
</table>
<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr>
<td width="170" align="center" style="border-left:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td><td width="170" align="center" style="border-left:1px solid black;"> </td>
<td width="170" align="center" style="border-left:1px solid black;"> </td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="50" align="center" style="border-left:1px solid black;">&nbsp;</td><td width="170" align="center" style="border-left:1px solid black;"> </td>
<td width="170" align="center" style="border-left:1px solid black;"> </td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td width="170" align="center" style="border-left:1px solid black;">......................................</td><td width="170" align="center" style="border-left:1px solid black;">......................................</td>
<td width="170" align="center" style="border-left:1px solid black;">......................................</td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td width="170" align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td width="170" align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
<td width="170" align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td width="170" align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td width="170" align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
<td width="170" align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้จัดการ / Manager</td>
</tr>
<tbody>
</table>
</body>
</html>