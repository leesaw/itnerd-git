<!DOCTYPE html>
<html>
<head>
<title>Gold Warranty Printing</title>
</head>
<body>
<?php foreach($warranty_array as $loop) { 
    $cusname = $loop->ngw_customername; 
    $cusaddress = $loop->ngw_customeraddress;
    $custelephone = $loop->ngw_customertelephone;
    $shopname = $loop->sh_name;
    $shoptelephone = $loop->sh_telephone;
    $number = $loop->ngw_number;
    $product = $loop->ngw_product;
    $kindgold = $loop->ngw_kindgold;
    $price = $loop->ngw_price;
    $payment = $loop->ngw_payment;
    $code = $loop->ngw_code;
    $weight = $loop->ngw_weight;
    $jewelry = $loop->ngw_jewelry;
    $datestart = $loop->ngw_datestart;
    $old = $loop->ngw_old;
    $model = $loop->ngw_model;
    $goldbuy = $loop->ngw_goldbuy;
    $goldsell = $loop->ngw_goldsell;
    $saleperson = $loop->sp_firstname;
    $issuedate = $loop->ngw_issuedate;
    
} 

 $datestart_year=substr($datestart,0,4); 
 $datestart_month=substr($datestart,5,2); 
 $datestart_day=substr($datestart,8,2); 
 $datestart = $datestart_day."/".$datestart_month."/".($datestart_year+543);
?>
<table border="0">
<tbody>
<tr>
<td width="200"></td>
<td width="400"><center><img src="<?php echo base_url(); ?>dist/img/logo_NGG.png" width="200px" /></center></td>
<td width="200" style="text-align: right;">
    <table border="1">
        <tbody><tr><td width="120"><center><div style="font-size: 20pt;">สำหรับ NGG</div></center></td></tr>
    </tbody>
    </table>
</td>
</tr>
<tr><td colspan="3"><center><div style="font-size: 20pt;"><b>NGG ง้วน โกลด์ แอนด์ เจมส์ ศูนย์รวมเครื่องประดับครบวงจร</b></div></center></td></tr>
</tbody>
</table>
<table border="0">
<tbody>
    <tr><td width="50"></td><td width="300">ชื่อลูกค้า : <?php echo $cusname; ?></td><td width="100"></td><td width="300">สาขา : <?php echo $shopname." โทร. ".$shoptelephone; ?></td><td width="50"></td></tr>
    <tr><td></td><td colspan="3">ที่อยู่ : <?php echo $cusaddress; ?> เบอร์โทร : <?php echo $custelephone; ?></td><td></td></tr>
    <tr><td style="border-bottom:3px solid black;"></td><td style="border-bottom:3px solid black;"></td><td style="border-bottom:3px solid black;"></td><td style="border-bottom:3px solid black;"></td><td style="border-bottom:3px solid black;"></td></tr>
</tbody>
</table>

<table border="0">
<tbody>
<tr><td width="200"></td>
    <td width="400" style="text-align:center"><div style="font-size: 20pt;"><b>บัตรรับประกันสินค้า</b></div></td>
<td width="200"></td>
</tr>
<tr><td></td><td style="text-align:center"><div style="font-size: 20pt;"><b>CERTIFICATE CARDS</b></td><td>เลขที่ใบรับประกัน : <?php echo $number; ?></td></tr>
</tbody>
</table>

<table border="0">
<tbody>
    <tr><td width="50"></td><td width="400">ประเภทสินค้า (PRODUCT) : <?php echo $product; ?></td><td width="20"></td><td width="280">รหัส (NO.) : <?php echo $code; ?></td><td width="50"></td></tr>
    <tr><td></td><td>ชนิดของทอง (KIND OF GOLD) : <?php echo $kindgold; ?></td><td></td><td>น้ำหนัก (WEIGHT) : <?php echo $weight; ?> กรัม</td><td></td></tr>
    <tr><td></td><td>จำนวนเงิน (PRICE) : <?php echo number_format($price, 2, '.', ','); ?> บาท</td><td colspan="2" style="border-bottom:1px solid black;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;<?php echo num2thai($price); ?></td><td></td></tr>
    <tr><td></td><td>ชำระด้วย : <?php echo $payment; ?></td><td colspan="2" style="text-align:center;">( ตัวอักษรจำนวนเงิน )</td><td></td></tr>
    <tr><td></td><td>จำนวนเพชร/พลอย (NUMBER OF D/J) : <?php echo $jewelry; ?></td><td></td><td rowspan="5">
        
    <table border="1">
        <tbody>
            <tr><td style="text-align:center;" width="250">รูปแบบ<br><?php echo $model; ?></td></tr>
            <tr><td style="text-align:center;">ราคาทองคำแท่ง<br>ซื้อ <?php echo number_format($goldbuy, 2, '.', ','); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ขาย <?php echo number_format($goldsell, 2, '.', ','); ?></td></tr>
            <tr><td style="text-align:center;">ชื่อพนักงานขาย : <?php echo $saleperson; ?></td></tr>
        </tbody>
    </table>
        
    </td><td></td></tr>
    <tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull; วันที่เริ่มรับประกันสินค้า : <?php echo $datestart; ?></td><td></td><td></td></tr>
    <tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull; หมายเหตุมีสินค้าเก่ามาเปลี่ยน : <?php echo $old; ?></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td><td></td></tr>
    <tr><td></td><td colspan="2">หมายเหตุ: ใบรับประกันสินค้ามีผลในการรับซื้อคืนของสินค้าในราคามาตรฐาน</td><td></td></tr>
</tbody>
</table>
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

<pagebreak />
    
<table border="0">
<tbody>
<tr>
<td width="200"></td>
<td width="400"><center><img src="<?php echo base_url(); ?>dist/img/logo_NGG.png" width="200px" /></center></td>
<td width="200" style="text-align: right;">
    <table border="1">
        <tbody><tr><td width="120"><center><div style="font-size: 20pt;">สำหรับ ลูกค้า</div></center></td></tr>
    </tbody>
    </table>
</td>
</tr>
<tr><td colspan="3"><center><div style="font-size: 20pt;"><b>NGG ง้วน โกลด์ แอนด์ เจมส์ ศูนย์รวมเครื่องประดับครบวงจร</b></div></center></td></tr>
</tbody>
</table>
<table border="0">
<tbody>
    <tr><td width="50"></td><td width="300">ชื่อลูกค้า : <?php echo $cusname; ?></td><td width="100"></td><td width="300">สาขา : <?php echo $shopname." โทร. ".$shoptelephone; ?></td><td width="50"></td></tr>
    <tr><td></td><td colspan="3">ที่อยู่ : <?php echo $cusaddress; ?> เบอร์โทร : <?php echo $custelephone; ?></td><td></td></tr>
    <tr><td style="border-bottom:3px solid black;"></td><td style="border-bottom:3px solid black;"></td><td style="border-bottom:3px solid black;"></td><td style="border-bottom:3px solid black;"></td><td style="border-bottom:3px solid black;"></td></tr>
</tbody>
</table>

<table border="0">
<tbody>
<tr><td width="200"></td>
    <td width="400" style="text-align:center"><div style="font-size: 20pt;"><b>บัตรรับประกันสินค้า</b></div></td>
<td width="200"></td>
</tr>
<tr><td></td><td style="text-align:center"><div style="font-size: 20pt;"><b>CERTIFICATE CARDS</b></td><td>เลขที่ใบรับประกัน : <?php echo $number; ?></td></tr>
</tbody>
</table>

<table border="0">
<tbody>
    <tr><td width="50"></td><td width="400">ประเภทสินค้า (PRODUCT) : <?php echo $product; ?></td><td width="20"></td><td width="280">รหัส (NO.) : <?php echo $code; ?></td><td width="50"></td></tr>
    <tr><td></td><td>ชนิดของทอง (KIND OF GOLD) : <?php echo $kindgold; ?></td><td></td><td>น้ำหนัก (WEIGHT) : <?php echo $weight; ?> กรัม</td><td></td></tr>
    <tr><td></td><td>จำนวนเงิน (PRICE) : <?php echo number_format($price, 2, '.', ','); ?> บาท</td><td colspan="2" style="border-bottom:1px solid black;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;<?php echo num2thai($price); ?></td><td></td></tr>
    <tr><td></td><td>ชำระด้วย : <?php echo $payment; ?></td><td colspan="2" style="text-align:center;">( ตัวอักษรจำนวนเงิน )</td><td></td></tr>
    <tr><td></td><td>จำนวนเพชร/พลอย (NUMBER OF D/J) : <?php echo $jewelry; ?></td><td></td><td rowspan="5">
        
    <table border="1">
        <tbody>
            <tr><td style="text-align:center;" width="250">รูปแบบ<br><?php echo $model; ?></td></tr>
            <tr><td style="text-align:center;">ราคาทองคำแท่ง<br>ซื้อ <?php echo number_format($goldbuy, 2, '.', ','); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ขาย <?php echo number_format($goldsell, 2, '.', ','); ?></td></tr>
            <tr><td style="text-align:center;">ชื่อพนักงานขาย : <?php echo $saleperson; ?></td></tr>
        </tbody>
    </table>
        
    </td><td></td></tr>
    <tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull; วันที่เริ่มรับประกันสินค้า : <?php echo $datestart; ?></td><td></td><td></td></tr>
    <tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull; หมายเหตุมีสินค้าเก่ามาเปลี่ยน : <?php echo $old; ?></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td><td></td></tr>
    <tr><td></td><td colspan="2">หมายเหตุ: ใบรับประกันสินค้ามีผลในการรับซื้อคืนของสินค้าในราคามาตรฐาน</td><td></td></tr>
</tbody>
</table>
</body>
</html>