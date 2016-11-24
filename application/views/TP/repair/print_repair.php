<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<style>
@page {
    margin-left: 30px;
    margin-right: 30px;
    margin-top: 30px;
    margin-bottom: 30px;
}

table {
    border-collapse: collapse;
    /*font-size: 14px;*/
}

td {
    padding-top: .5em;
    padding-bottom: .5em;
}
.undertd {
  border-bottom: 1px solid black;
}
</style>
</head>
<?php
foreach($repair_array as $loop) {
$rep_id = $loop->rep_id;
$rep_dateadd = $loop->rep_dateadd;
$rep_dateaddby = $loop->firstname." ".$loop->lastname;
$rep_remark = $loop->rep_remark;
$rep_cusname = $loop->rep_cusname;
$rep_custelephone = $loop->rep_custelephone;
$rep_customer = $loop->rep_customer;
$rep_number = $loop->rep_number;
$rep_shopin = $loop->shopin_code."-".$loop->shopin_name;
$rep_brand = $loop->br_code."-".$loop->br_name;
$rep_refcode = $loop->rep_refcode;
$rep_case = $loop->rep_case;
$rep_getfrom = $loop->rep_getfrom;
$rep_assess = $loop->rep_assess;
$rep_warranty = $loop->rep_warranty;
$rep_price = $loop->rep_price;
$rep_shopreturn = $loop->shopreturn_code."-".$loop->shopreturn_name;
$rep_return_shop_id = $loop->rep_return_shop_id;
$rep_responsename = $loop->rep_responsename;
$rep_status = $loop->rep_status;
$rep_enable = $loop->rep_enable;
$rep_repairable = $loop->rep_repairable;
$rep_customer_repair = $loop->rep_customer_repair;

if ($rep_repairable == 0) $rep_repairable_view = "";
else if ($rep_repairable == 1) $rep_repairable_view = "ซ่อมได้";
else if ($rep_repairable == 2) $rep_repairable_view = "ซ่อมไม่ได้";

if ($rep_customer_repair == 0) $rep_customer_repair_view = "";
else if ($rep_customer_repair == 1) $rep_customer_repair_view = "ลูกค้าให้ซ่อม";
else if ($rep_customer_repair == 2) $rep_customer_repair_view = "ลูกค้าไม่ให้ซ่อม";

$datein = explode("-", $loop->rep_datein);
$rep_datein = $datein[2]."/".$datein[1]."/".$datein[0];
$datecs = explode("-", $loop->rep_datecs);
$rep_datecs = $datecs[2]."/".$datecs[1]."/".$datecs[0];

if ($loop->rep_datedone != "0000-00-00") {
$datedone = explode("-", $loop->rep_datedone);
$rep_datedone = $datedone[2]."/".$datedone[1]."/".$datedone[0];
}else{
$rep_datedone = "";
}

if ($loop->rep_datereturn != "0000-00-00") {
$datereturn = explode("-", $loop->rep_datereturn);
$rep_datereturn = $datereturn[2]."/".$datereturn[1]."/".$datereturn[0];
}else{
$rep_datereturn = "";
}
$currentdate = date("d/m/Y");
}
?>
<body>
<table class="table">
  <tbody>
    <tr><td width="80%"><div style="text-align: left; font-weight: bold; font-size: 14pt;">NGG TIMEPIECES CO., LTD. </div><br\><div style="text-align: left; font-weight: bold;  font-size: 10pt;">27 Soi Pattanasin, Naradhiwas Rajanagarindra Rd.</div><br\><div style="text-align: left; font-weight: bold;  font-size: 10pt;">Thungmahamek Sathon Bangkok 10120</div><br\><div style="text-align: left; font-weight: bold;  font-size: 10pt;">Tax ID : 0105555081331  (Head Office)<br>Tel : 02-678-9988  Fax : 02-678-5566</div></td><td width="20%"><?php if($rep_enable==0) echo "ยกเลิกแล้ว"; ?></td></tr>
  </tbody>
</table>
<table class="table">
  <tbody>
    <tr style='border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;'>
      <td colspan='5' style='text-align: center;'>รายละเอียดการส่งซ่อม</td></tr>
    <tr><td width="120">วันที่ส่งซ่อม</td><td width="230" class='undertd'><?php echo $rep_datein; ?></td><td width="10"> </td>
        <td width="120">เลขที่ใบรับ</td><td width="230" class='undertd'><?php echo $rep_number; ?></td></tr>

    <tr><td>สาขาที่ส่งซ่อม</td><td class='undertd'><?php echo $rep_shopin; ?></td><td></td>
        <td>วันที่ CS รับ</td><td class='undertd'><?php echo $rep_datecs; ?></td></tr>

    <tr><td>รับของจาก</td><td class='undertd'><?php echo $rep_getfrom; ?></td><td></td>
        <td>ที่มา</td><td class='undertd'><?php if ($rep_customer == 1) echo "ลูกค้า"; else echo "สต็อก"; ?></td></tr>
    <tr><td colspan='5'> </td></tr>
    <tr style='border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;'>
      <td colspan='5' style='text-align: center;'>รายละเอียดลูกค้าและสินค้า</td></tr>
    <tr><td>ชื่อลูกค้า</td><td class='undertd'><?php echo $rep_cusname; ?></td><td></td>
        <td>เบอร์ติดต่อลูกค้า</td><td class='undertd'><?php echo $rep_custelephone; ?></td></tr>

    <tr><td>Ref. Number</td><td class='undertd'><?php echo $rep_refcode; ?></td><td></td>
        <td>ยี่ห้อ</td><td class='undertd'><?php echo $rep_brand; ?></td></tr>

    <tr><td>อาการ</td><td class='undertd' colspan="4"><?php echo $rep_case; ?></td></tr>

    <tr><td colspan='5'> </td></tr>
    <tr style='border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;'>
      <td colspan='5' style='text-align: center;'>รายละเอียดการซ่อม</td></tr>
    <tr><td>สถานะการซ่อม</td><td class='undertd'><?php echo $rep_repairable_view; ?></td><td></td>
        <td>ความเห็นลูกค้า</td><td class='undertd'><?php echo $rep_customer_repair_view; ?></td></tr>

    <tr><td>ประเมินการซ่อม</td><td class='undertd'><?php echo $rep_assess; ?></td><td></td>
        <td>ประกัน</td><td class='undertd'><?php if($rep_warranty==1) echo "หมดประกัน"; if($rep_warranty==2) echo "อยู่ในประกัน";  ?></td></tr>

    <tr><td>ราคาซ่อม</td><td class='undertd'><?php echo $rep_price; ?></td><td></td>
        <td>ผู้รับผิดชอบ</td><td class='undertd'><?php echo $rep_responsename; ?></td></tr>

    <tr><td>วันที่จบงาน</td><td class='undertd'><?php echo $rep_datedone; ?></td><td></td>
        <td>วันที่ส่งกลับ</td><td class='undertd'><?php echo $rep_datereturn; ?></td></tr>

    <tr><td>สาขาที่ส่งกลับ</td><td class='undertd'><?php echo $rep_shopreturn; ?></td><td></td>
        <td>สถานะ</td><td class='undertd'><?php
            if ($rep_status == 'G') echo "รับเข้าซ่อม";
            if ($rep_status == 'A') echo "ประเมินการซ่อมแล้ว";
            if ($rep_status == 'D') echo "ซ่อมเสร็จ";
            if ($rep_status == 'C') echo "ซ่อมไม่ได้";
            if ($rep_status == 'R') echo "ส่งกลับแล้ว";
        ?></td></tr>

    <tr><td>Remark</td><td class='undertd' colspan="4"><?php echo $rep_remark; ?></td></tr>
    <tr><td colspan='5' height='50px'> </td></tr>
    <tr><td>ผู้แก้ไขล่าสุด</td><td class='undertd' colspan="4"><?php echo $rep_dateaddby." ".$rep_dateadd; ?></td></tr>
  </tbody>
</table>

<?php $this->load->view('js_footer'); ?>
</body>
</html>
