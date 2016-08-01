<!DOCTYPE html>
<html>
<head>
<title>Invoice Printing</title>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="35"> </td>
<td width="400">
<div style="text-align: left; font-weight: bold; font-size: 18pt;">NGG TIMEPIECES COMPANY LIMITED </div><br\><div style="text-align: left; font-weight: bold;  font-size: 14pt;">27 Soi Pattanasin, Naradhiwas Rajanagarindra Rd.</div><br\><div style="text-align: left; font-weight: bold;  font-size: 14pt;">Thungmahamek Sathon Bangkok 10120</div><br\><div style="text-align: left; font-weight: bold;  font-size: 14pt;">เลขประจำตัวผู้เสียภาษี 0105555081331  สำนักงานใหญ่<br>เบอร์โทร 02-678-9988 เบอร์แฟกซ์ 02-678-5566</div>
</td> 
<?php foreach($inv_array as $loop) { $datetime = $loop->inv_issuedate; $number = $loop->inv_number; $cusname = $loop->inv_warehouse_detail; $cusaddress1 = $loop->inv_warehouse_address1; $cusaddress2 = $loop->inv_warehouse_address2; $custaxid = $loop->inv_warehouse_taxid; $note=$loop->inv_note; $vender=$loop->inv_vender; $barcode=$loop->inv_barcode; 
if ($loop->inv_warehouse_branch == 0) { $cusbranch = "สำนักงานใหญ่"; $mainbranch=1; }else{ $cusbranch = "สาขาที่ ".str_pad($loop->inv_warehouse_branch, 5, '0', STR_PAD_LEFT); $mainbranch=0; $branch_number=str_pad($loop->inv_warehouse_branch, 5, '0', STR_PAD_LEFT); } } 

 $GGyear=substr($datetime,0,4); 
 $GGmonth=substr($datetime,5,2); 
 $GGdate=substr($datetime,8,2); 

 $checkmark = '<img src="'.base_url().'dist/img/checkmark.png" width="15px" />';
?>

    <td width="250" style="text-align: right;"></td>
</tr>
</tbody>
</table>
<table style="border:0px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td height="18"></td><td></td><td></td><td></td><td></td></tr>
<tr><td width="250"></td><td width="200"><?php echo $custaxid; ?></td><td><?php echo $GGdate."/".$GGmonth."/".$GGyear; ?></td><td width="120"></td><td><?php echo $number; ?></td></tr>
<tr><td height="10"></td><td></td><td></td><td></td><td></td></tr>
</tbody>
</table>
<table style="border:0px solid black; border-spacing:0px 0px;">
<tbody>
<tr>
	<td width="50"></td>
    <td width="380" style="border-right:0px solid black;" valign="top"><?php echo $cusname; ?><br><?php echo $cusaddress1; ?><br><?php echo $cusaddress2; ?></td><td width="20"> </td><td width="50" valign="top"></td><td width="180" valign="top"></td>
</tr>
<tr><td colspan="5" height="10"></td></tr>
</tbody>
</table>
<table style="border:0px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td width="8"></td><td width="20"><?php if ($mainbranch==1) echo $checkmark; ?></td><td width="75"></td><td width="8"></td><td><?php if ($mainbranch==0) echo $checkmark; ?></td><td width="60"></td><td width="280"><?php if ($mainbranch==0) echo $branch_number; ?></td><td><?php echo $note; ?></td></tr>
<?php if (($mainbranch==1)&&($note=="")) { ?>
<tr><td colspan="8" height="120"></td></tr>
<?php }else{ ?>
<tr><td colspan="8" height="115"></td></tr>
<?php } ?>
</tbody>
</table>
<table style="border:0px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td width="10"></td><td width="110"></td><td width="300"></td><td width="80"></td><td width="80"></td><td width="70"></td><td width="100"></td></tr>
<!--
<tr><td width="10" style="border-right:1px solid black;"></td><td width="110" style="border-right:1px solid black;"></td><td width="300" style="border-right:1px solid black;"></td><td width="80" style="border-right:1px solid black;"></td><td width="80" style="border-right:1px solid black;"></td><td width="70" style="border-right:1px solid black;"></td><td width="100" style="border-right:1px solid black;"></td></tr>
-->
<?php $no=0; $page_no = 0; $sum=0; $sum_qty=0; if(isset($item_array)) { foreach($item_array as $loop) { 

// start pagebreak
if (($no >=10)) { 
	if (($page_no != $totalpage-1) || ($lastpage!=1) || ($no > 11)) {
		$page_no++; 
	

	
?>
<tr><td height="20" colspan="7"></td></tr>

<tr ><td></td><td align="center" valign="top"></td>
<td align="center" valign="top"><?php echo "หน้าที่ ".$page_no." / ".$totalpage; ?></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="right" valign="top"></td>
</tr>
<tr ><td></td><td align="center" valign="top"></td>
<td align="center" valign="top"><b><?php echo "VENDER CODE &nbsp;&nbsp;&nbsp;&nbsp; ".$vender; ?></b></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="right" valign="top"></td>
</tr>
<tr ><td></td><td align="center" valign="top"></td>
<td align="center" valign="top"><b><?php echo "BARCODE &nbsp;&nbsp;&nbsp;&nbsp; ".$barcode; ?></b></td>
<td align="center" valign="top"><b><?php echo $sum_qty; $sum_qty=0; ?></b></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="right" valign="top"></td>
</tr>
<tr><td height="60" colspan="7"></td></tr>

</tbody>
<tbody>
<tr>
<td align="right" colspan="5" scope="row"></td><td align="right"><div style="font-size: 16pt;"> </div></td>
</tr>
<tr><td colspan="6" height="10"></td></tr>
<tr>
<td align="right" colspan=5 scope="row"></td><td align="right"><div style="font-size: 16pt;"> </div></td>
</tr>
<tr>
<td height="40" align="left" colspan="3" scope="row"><div style="font-size: 16pt;"> </div></td>
<td align="right" colspan=2 scope="row"></td><td align="right"><div style="font-size: 16pt;"> </div></td>
</tr>
</tbody>
</table>
<pagebreak>
<table border="0">
<tbody>
<tr>
<td width="35"> </td>
<td width="400">
<div style="text-align: left; font-weight: bold; font-size: 18pt;">NGG TIMEPIECES COMPANY LIMITED </div><br\><div style="text-align: left; font-weight: bold;  font-size: 14pt;">27 Soi Pattanasin, Naradhiwas Rajanagarindra Rd.</div><br\><div style="text-align: left; font-weight: bold;  font-size: 14pt;">Thungmahamek Sathon Bangkok 10120</div><br\><div style="text-align: left; font-weight: bold;  font-size: 14pt;">เลขประจำตัวผู้เสียภาษี 0105555081331  สำนักงานใหญ่<br>เบอร์โทร 02-678-9988 เบอร์แฟกซ์ 02-678-5566</div>
</td> 
    <td width="250" style="text-align: right;"></td>
</tr>
</tbody>
</table>
<table style="border:0px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td height="18"></td><td></td><td></td><td></td><td></td></tr>
<tr><td width="250"></td><td width="200"><?php echo $custaxid; ?></td><td><?php echo $GGdate."/".$GGmonth."/".$GGyear; ?></td><td width="120"></td><td><?php echo $number; ?></td></tr>
<tr><td height="10"></td><td></td><td></td><td></td><td></td></tr>
</tbody>
</table>
<table style="border:0px solid black; border-spacing:0px 0px;">
<tbody>
<tr>
	<td width="50"></td>
    <td width="380" style="border-right:0px solid black;" valign="top"><?php echo $cusname; ?><br><?php echo $cusaddress1; ?><br><?php echo $cusaddress2; ?></td><td width="20"> </td><td width="50" valign="top"></td><td width="180" valign="top"></td>
</tr>
<tr><td colspan="5" height="10"></td></tr>
</tbody>
</table>
<table style="border:0px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td width="8"></td><td width="20"><?php if ($mainbranch==1) echo $checkmark; ?></td><td width="75"></td><td width="8"></td><td><?php if ($mainbranch==0) echo $checkmark; ?></td><td width="60"></td><td width="280"><?php if ($mainbranch==0) echo $branch_number; ?></td><td><?php echo $note; ?></td></tr>
<?php if (($mainbranch==1)&&($note=="")) { ?>
<tr><td colspan="7" height="120"></td></tr>
<?php }else{ ?>
<tr><td colspan="7" height="115"></td></tr>
<?php } ?>
</tbody>
</table>

<table style="border:0px solid black; border-spacing:0px 0px;">
<tr><td width="10"></td><td width="110"></td><td width="300"></td><td width="80"></td><td width="80"></td><td width="70"></td><td width="100"></td></tr>
<!--
<tr><td width="10" style="border-right:1px solid black;"></td><td width="110" style="border-right:1px solid black;"></td><td width="300" style="border-right:1px solid black;"></td><td width="80" style="border-right:1px solid black;"></td><td width="80" style="border-right:1px solid black;"></td><td width="70" style="border-right:1px solid black;"></td><td width="100" style="border-right:1px solid black;"></td></tr>
-->
<?php
 $no=0; 
} }

// end pagebreak
?>

<tr style="border:0px solid black;"><td></td>
<td align="left" valign="top" width="25"><?php echo $loop->invit_refcode; ?></td>
<td style="border-left:0px solid black;" align="left" valign="top"><?php echo strtoupper($loop->invit_brand); ?></td>
<td align="center" style="border-left:0px solid black;" valign="top"><?php echo $loop->invit_qty; $sum_qty+=$loop->invit_qty; ?></td>
<td align="right" style="border-left:0px solid black;" valign="top"><?php echo number_format($loop->invit_srp, 2, ".", ","); ?></td>
<td align="right" style="border-left:0px solid black;" valign="top"><?php echo number_format($loop->invit_discount); ?> %</td>
<td align="right" style="border-left:0px solid black;" valign="top"><?php echo number_format($loop->invit_netprice*$loop->invit_qty, 2, ".", ",")."&nbsp;&nbsp;"; $sum += ($loop->invit_netprice*$loop->invit_qty); ?></td>
</tr>
<?php $no++; 

} } $page_no++;  ?> 

<?php if ($no<10) { for($i=10-$no; $i>0; $i--) { ?> 
<tr><td colspan="7" > &nbsp;</td></tr>
<?php  } } 

if ($lastpage!=1) {
?>
<tr><td height="20" colspan="7"></td></tr>
<?php } ?>

<tr ><td></td><td align="center" valign="top"></td>
<td align="center" valign="top"><?php echo "หน้าที่ ".$page_no." / ".$totalpage; ?></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="right" valign="top"></td>
</tr>
<tr ><td></td><td align="center" valign="top"></td>
<td align="center" valign="top"><b><?php echo "VENDER CODE &nbsp;&nbsp;&nbsp;&nbsp; ".$vender; ?></b></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="right" valign="top"></td>
</tr>
<tr ><td></td><td align="center" valign="top"></td>
<td align="center" valign="top"><b><?php echo "BARCODE &nbsp;&nbsp;&nbsp;&nbsp; ".$barcode; ?></b></td>
<td align="center" valign="top"><b><?php echo $sum_qty; ?></b></td>
<td align="center" valign="top"></td>
<td align="center" valign="top"></td>
<td align="right" valign="top"></td>
</tr>
<?php if ($lastpage!=1) {
?>
<tr><td height="60" colspan="7"></td></tr>
<?php }else{ ?>
<tr><td height="55" colspan="7"></td></tr>
<?php } ?>
<tr><td></td>
<td align="right" colspan="5" scope="row"></td><td align="right"><div style="font-size: 16pt;"><?php  echo number_format($sum/1.07, 2, '.', ','); ?></div></td>
</tr>
<tr><td></td><td colspan="6" height="10"></td></tr>
<tr><td></td>
<td align="right" colspan=5 scope="row"><div style="font-size: 16pt;">7%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td><td align="right"><div style="font-size: 16pt;"><?php  echo number_format($sum/1.07*0.07, 2, '.', ','); ?></div></td>
</tr>
<tr><td height="3" colspan="7"></td></tr>
<tr><td></td>
<td height="40" align="left" colspan="3" scope="row"><div style="font-size: 14pt;"><?php echo num2thai($sum); ?></div></td>
<td align="right" colspan=2 scope="row"></td><td align="right"><div style="font-size: 16pt;"><?php  echo number_format($sum, 2, '.', ','); ?></div></td>
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
</body>
</html>