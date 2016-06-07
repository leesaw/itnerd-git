<!DOCTYPE html>
<html>
<head>
<style type="text/css">
u {    
    border-bottom: 2px dotted #848484;
    text-decoration: none;
}
</style>
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
    
 $issuedate_year=substr($issuedate,0,4); 
 $issuedate_month=substr($issuedate,5,2); 
 $issuedate_day=substr($issuedate,8,2); 
 $issuedate = $issuedate_day."/".$issuedate_month."/".($issuedate_year+543);
?>
<table border="0">
<tbody>
<tr>
    <td width="200"><div style="font-size: 36pt;">ใบรับประกันสินค้า</div><div style="font-size: 24pt;">CERTIFICATE CARDS</div>เลขที่ใบรับประกัน : <u><?php echo $number; ?></u></td><td width="30"></td>
    <td width="360"><span style="font-size: 11pt;"><b>ของขวัญจากธรรมชาติ ศาสตร์และศิลป์แห่งเครื่องประดับ</b><br><br>ศูนย์รวมเครื่องประดับเลอค่า ทองคำ เพชร อัญมณี และนาฬิกา รับรองคุณภาพจากสถาบันชั้นนำ GIA GRS GIT และสมาคมผู้ค้าทองคำแห่งประเทศไทย รับประกันการซื้อคืน บริการซ่อมแซมและทำความสะอาด จำหน่าย / รับซื้อ และ แลกเปลี่ยน<br><br>
    WWW.NGGJEWELLERY.COM  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WWW.NGGTIMEPIECES.COM</span></td><td width="10"></td>
    <td width="200"><center><img src="<?php echo base_url(); ?>dist/img/logo_NGG.png" width="200px" /></center></td>
</tr>
    <tr><td colspan="5" height="8"></td></tr>
    <tr><td colspan="3"><div style="font-size: 20pt;"><b>NGG ง้วน โกลด์ แอนด์ เจมส์ ศูนย์รวมเครื่องประดับครบวงจร</b></div></td><td></td><td><center><div style="font-size: 20pt; color:red">สำหรับ ลูกค้า</div></center></td></tr>
</tbody>
</table>
<table border="0">
<tbody>
<tr><td colspan="3" height="5" style="border-top:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;"></td></tr>
<tr>
    <td style="border-left:1px solid #848484;border-right:1px solid #848484;"> &nbsp; วันที่ : <?php echo $issuedate; ?><br> &nbsp; สาขา : <?php echo $shopname." โทร. ".$shoptelephone; ?></td>
    <td colspan="2" style="border-right:1px solid #848484"> &nbsp; ชื่อลูกค้า : <?php echo $cusname; ?> &nbsp;&nbsp;&nbsp;&nbsp; เบอร์โทรศัพท์ : <?php echo $custelephone; ?><br> &nbsp; ที่อยู่ลูกค้า : <?php echo $cusaddress; ?> </td>
</tr>
<tr><td colspan="3" height="5" style="border-bottom:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;"></td></tr>
<tr>
    <th height="30" width="340" style="border-bottom:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;">ซื้อ</th><th width="180" style="border-bottom:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;">แลกเปลี่ยน</th><th width="280" style="border-bottom:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;">การชำระเงิน</th>
</tr>
<tr><td height="8" style="border-left:1px solid #848484;"></td><td style="border-left:1px solid #848484;"></td><td style="border-left:1px solid #848484;border-right:1px solid #848484"></td></tr>
</tbody>
</table>
<table border="0">
<tbody>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">ประเภทสินค้า <span style="font-size:12pt">(Product)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $product; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td width="180" rowspan="7" style="vertical-align:top;border-right:1px solid #848484;"><center>หมายเหตุมีสินค้าเก่ามาเปลี่ยน<br><?php echo insertspace($old,50); ?></center></td><td width="5" ></td><td width="110">จำนวนเงิน <span style="font-size:12pt">(Price)</span></td><td width="160" style="vertical-align:top;border-bottom:2px dotted #848484;"><center><?php echo number_format($price, 2, '.', ','); ?> บาท</center></td><td width="5" style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">รหัส <span style="font-size:12pt">(No.)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo $code; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td>ชำระด้วย <span style="font-size:12pt">(Payment)</td><td style="vertical-align:top;border-bottom:2px dotted #848484;"><center><?php echo $payment; ?></center></td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">ชนิดของทอง <span style="font-size:12pt">(Kind of Gold)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $kindgold; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td colspan="2" style="text-align:right;font-size:12pt;border-bottom:1px solid #848484;">(<?php echo num2thai($price); ?>)</td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">น้ำหนัก <span style="font-size:12pt">(Weight)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $weight; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td colspan="2" style="text-align:center">ราคาทองคำแท่ง</td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">รูปแบบ <span style="font-size:12pt">(Model)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $model; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td style="text-align:center">ซื้อ</td><td style="vertical-align:top;border-bottom:2px dotted #848484;"><center><?php echo number_format($goldbuy, 2, '.', ','); ?> บาท</center></td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">จำนวนเพชร/พลอย</td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $jewelry; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td style="text-align:center">ขาย</td><td style="vertical-align:top;border-bottom:2px dotted #848484;"><center><?php echo number_format($goldsell, 2, '.', ','); ?> บาท</center></td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;"><span style="font-size:12pt">(Number of D/J)</span></td><td width="10"></td><td style="vertical-align:top;" width="170"></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td></td><td></td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td colspan="5" style="border-right:1px solid #848484;border-left:1px solid #848484;border-bottom:1px solid #848484;"></td><td style="border-right:1px solid #848484;border-bottom:1px solid #848484;"></td><td colspan="4" style="border-right:1px solid #848484;border-bottom:1px solid #848484;"></td></tr>
<tr><td colspan="2" style="border-left:1px solid #848484;">วันที่เริ่มรับประกันสินค้า</td><td></td><td style="border-bottom:2px dotted #848484;"><center><?php echo $datestart; ?></center></td><td style="border-right:1px solid #848484;"></td><td><center>ชื่อพนักงานขาย</center></td><td colspan="4" style="border-right:1px solid #848484;border-bottom:2px dotted #848484;"><center><?php echo $saleperson; ?></center></td></tr>
<tr><td colspan="2" style="border-left:1px solid #848484;border-bottom:1px solid #848484;"></td><td style="border-bottom:1px solid #848484;"></td><td style="border-bottom:1px solid #848484;"></td><td style="border-right:1px solid #848484;border-bottom:1px solid #848484;"></td><td colspan="5" style="border-right:1px solid #848484;border-bottom:1px solid #848484;"></td></tr>
</tbody>
</table>
    <div style="font-size:12pt">หมายเหตุ : ใบรับประกันสินค้ามีผลในการรับซื้อคืนของสินค้าในราคามาตรฐาน</div>
<?php
function insertspace($string, $number) {
    $count = strlen($string);
    $diff = ($number - $count)/2;
    if ($count < $number) {
        $j = 0;
        for($i=$count; $i < $number; $i++) {
            $j++;
            if ($j < $diff) $string = "&nbsp;".$string;
            else $string = $string."&nbsp;";
        }
    }
    return "<u>".$string."</u>";
}    

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
    <td width="200"><div style="font-size: 36pt;">ใบรับประกันสินค้า</div><div style="font-size: 24pt;">CERTIFICATE CARDS</div>เลขที่ใบรับประกัน : <u><?php echo $number; ?></u></td><td width="30"></td>
    <td width="360"><span style="font-size: 11pt;"><b>ของขวัญจากธรรมชาติ ศาสตร์และศิลป์แห่งเครื่องประดับ</b><br><br>ศูนย์รวมเครื่องประดับเลอค่า ทองคำ เพชร อัญมณี และนาฬิกา รับรองคุณภาพจากสถาบันชั้นนำ GIA GRS GIT และสมาคมผู้ค้าทองคำแห่งประเทศไทย รับประกันการซื้อคืน บริการซ่อมแซมและทำความสะอาด จำหน่าย / รับซื้อ และ แลกเปลี่ยน<br><br>
    WWW.NGGJEWELLERY.COM  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WWW.NGGTIMEPIECES.COM</span></td><td width="10"></td>
    <td width="200"><center><img src="<?php echo base_url(); ?>dist/img/logo_NGG.png" width="200px" /></center></td>
</tr>
    <tr><td colspan="5" height="8"></td></tr>
    <tr><td colspan="3"><div style="font-size: 20pt;"><b>NGG ง้วน โกลด์ แอนด์ เจมส์ ศูนย์รวมเครื่องประดับครบวงจร</b></div></td><td></td><td><center><div style="font-size: 20pt; color:red">สำหรับ NGG</div></center></td></tr>
</tbody>
</table>
<table border="0">
<tbody>
<tr><td colspan="3" height="5" style="border-top:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;"></td></tr>
<tr>
    <td style="border-left:1px solid #848484;border-right:1px solid #848484;"> &nbsp; วันที่ : <?php echo $issuedate; ?><br> &nbsp; สาขา : <?php echo $shopname." โทร. ".$shoptelephone; ?></td>
    <td colspan="2" style="border-right:1px solid #848484"> &nbsp; ชื่อลูกค้า : <?php echo $cusname; ?> &nbsp;&nbsp;&nbsp;&nbsp; เบอร์โทรศัพท์ : <?php echo $custelephone; ?><br> &nbsp; ที่อยู่ลูกค้า : <?php echo $cusaddress; ?> </td>
</tr>
<tr><td colspan="3" height="5" style="border-bottom:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;"></td></tr>
<tr>
    <th height="30" width="340" style="border-bottom:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;">ซื้อ</th><th width="180" style="border-bottom:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;">แลกเปลี่ยน</th><th width="280" style="border-bottom:1px solid #848484;border-left:1px solid #848484;border-right:1px solid #848484;">การชำระเงิน</th>
</tr>
<tr><td height="8" style="border-left:1px solid #848484;"></td><td style="border-left:1px solid #848484;"></td><td style="border-left:1px solid #848484;border-right:1px solid #848484"></td></tr>
</tbody>
</table>
<table border="0">
<tbody>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">ประเภทสินค้า <span style="font-size:12pt">(Product)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $product; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td width="180" rowspan="7" style="vertical-align:top;border-right:1px solid #848484;"><center>หมายเหตุมีสินค้าเก่ามาเปลี่ยน<br><?php echo insertspace($old,50); ?></center></td><td width="5" ></td><td width="110">จำนวนเงิน <span style="font-size:12pt">(Price)</span></td><td width="160" style="vertical-align:top;border-bottom:2px dotted #848484;"><center><?php echo number_format($price, 2, '.', ','); ?> บาท</center></td><td width="5" style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">รหัส <span style="font-size:12pt">(No.)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo $code; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td>ชำระด้วย <span style="font-size:12pt">(Payment)</td><td style="vertical-align:top;border-bottom:2px dotted #848484;"><center><?php echo $payment; ?></center></td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">ชนิดของทอง <span style="font-size:12pt">(Kind of Gold)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $kindgold; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td colspan="2" style="text-align:right;font-size:12pt;border-bottom:1px solid #848484;">(<?php echo num2thai($price); ?>)</td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">น้ำหนัก <span style="font-size:12pt">(Weight)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $weight; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td colspan="2" style="text-align:center">ราคาทองคำแท่ง</td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">รูปแบบ <span style="font-size:12pt">(Model)</span></td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $model; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td style="text-align:center">ซื้อ</td><td style="vertical-align:top;border-bottom:2px dotted #848484;"><center><?php echo number_format($goldbuy, 2, '.', ','); ?> บาท</center></td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;">จำนวนเพชร/พลอย</td><td width="10"></td><td style="vertical-align:top;border-bottom:2px dotted #848484;" width="170"><center><?php echo  $jewelry; ?></center></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td style="text-align:center">ขาย</td><td style="vertical-align:top;border-bottom:2px dotted #848484;"><center><?php echo number_format($goldsell, 2, '.', ','); ?> บาท</center></td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td width="5" style="border-left:1px solid #848484;"></td><td width="150" style="vertical-align:top;"><span style="font-size:12pt">(Number of D/J)</span></td><td width="10"></td><td style="vertical-align:top;" width="170"></td><td width="5" style="border-right:1px solid #848484;"></td><td></td><td></td><td></td><td style="border-right:1px solid #848484;"></td></tr>
<tr><td colspan="5" style="border-right:1px solid #848484;border-left:1px solid #848484;border-bottom:1px solid #848484;"></td><td style="border-right:1px solid #848484;border-bottom:1px solid #848484;"></td><td colspan="4" style="border-right:1px solid #848484;border-bottom:1px solid #848484;"></td></tr>
<tr><td colspan="2" style="border-left:1px solid #848484;">วันที่เริ่มรับประกันสินค้า</td><td></td><td style="border-bottom:2px dotted #848484;"><center><?php echo $datestart; ?></center></td><td style="border-right:1px solid #848484;"></td><td><center>ชื่อพนักงานขาย</center></td><td colspan="4" style="border-right:1px solid #848484;border-bottom:2px dotted #848484;"><center><?php echo $saleperson; ?></center></td></tr>
<tr><td colspan="2" style="border-left:1px solid #848484;border-bottom:1px solid #848484;"></td><td style="border-bottom:1px solid #848484;"></td><td style="border-bottom:1px solid #848484;"></td><td style="border-right:1px solid #848484;border-bottom:1px solid #848484;"></td><td colspan="5" style="border-right:1px solid #848484;border-bottom:1px solid #848484;"></td></tr>
</tbody>
</table>
    <div style="font-size:12pt">หมายเหตุ : ใบรับประกันสินค้ามีผลในการรับซื้อคืนของสินค้าในราคามาตรฐาน</div>
</body>
</html>