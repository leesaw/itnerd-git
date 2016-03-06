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
<div style="text-align: left; font-weight: bold; font-size: 18pt;">NGG TIMEPIECES COMPANY LIMITED </div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">Sathon Bangkok 10120</div>
</td> 
<?php foreach($pos_array as $loop) { $datetime = $loop->posrob_issuedate; $so_id = $loop->posrob_number; $editor = $loop->firstname." ".$loop->lastname; $shop = $loop->sh_name; $cusname = $loop->posrob_borrower_name;  break; } 

 $GGyear=substr($datetime,0,4); 
 $GGmonth=substr($datetime,5,2); 
 $GGdate=substr($datetime,8,2); 
?>
<td width="50"> </td>
    <td width="200" style="text-align: right;"><div style="font-weight: bold; font-size: 16pt;">ใบส่งของชั่วคราว</div><div style="font-weight: bold; font-size: 16pt;">ต้นฉบับ</div></td>
</tr>
<tr>
    <td width="300" colspan="2">นามผู้รับของ : <?php echo $cusname; ?><br>พนักงานขาย:  <?php echo $editor; ?><br></td><td> </td><td colspan="2">เลขที่ใบส่งของ: <?php echo $so_id; ?><br>สาขา : <?php echo $shop; ?><br>วันที่ : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?>
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
<td style="border-left:1px solid black;" valign="top"><?php echo $loop->itse_serial_number; ?></td>
<td style="border-left:1px solid black;" valign="top"><?php echo $loop->br_name." ".$loop->it_refcode." ".$loop->it_model; ?><br><?php echo $loop->it_remark." , ".$loop->it_short_description; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo $loop->posrobi_qty." ".$loop->it_uom; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo number_format($loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
<td align="right" style="border-left:1px solid black;" valign="top"><?php $cal = $loop->posrobi_qty*$loop->it_srp; echo number_format($cal, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $cal; $sum_qty += $loop->posrobi_qty; ?></td>
</tr>
<?php $no++; } } ?> 
    
<tr><td style="border-top:1px solid black;">&nbsp;</td><td style="border-top:1px solid black;">&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;">รวมจำนวน</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum_qty; ?></td><td align="right" style="border-left:1px solid black;border-top:1px solid black;">รวมเงิน</td><td align="right" style="border-left:1px solid black;border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ',')."&nbsp;&nbsp;"; ?></td></tr>
</tbody>
</table>
<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr>
<td width="340" align="center" style="border-left:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td><td width="340" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="50" align="center" style="border-left:1px solid black;">&nbsp;</td><td width="340" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td width="340" align="center" style="border-left:1px solid black;">......................................</td><td width="340" align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td width="340" align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td width="340" align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td width="170" align="center" style="border-left:1px solid black; border-top:1px solid black;"><?php echo $cusname; ?><br>ผู้รับของ / Receiver</td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;"><?php echo $editor; ?><br>ผู้ส่งของ / Delivered By</td>
</tr>
</tbody>
</table>

<pagebreak />
    
<table border="0">
<tbody>
<tr>
<td width="100"><img src="<?php echo base_url(); ?>dist/img/logo-nggtp.jpg" width="100px" /></td>
<td width="320">
<div style="text-align: left; font-weight: bold; font-size: 18pt;">NGG TIMEPIECES COMPANY LIMITED </div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">Sathon Bangkok 10120</div>
</td> 
<?php foreach($pos_array as $loop) { $datetime = $loop->posrob_issuedate; $so_id = $loop->posrob_number; $editor = $loop->firstname." ".$loop->lastname; $shop = $loop->sh_name; $cusname = $loop->posrob_borrower_name;  break; } 

 $GGyear=substr($datetime,0,4); 
 $GGmonth=substr($datetime,5,2); 
 $GGdate=substr($datetime,8,2); 
?>
<td width="50"> </td>
    <td width="200" style="text-align: right;"><div style="font-weight: bold; font-size: 16pt;">ใบส่งของชั่วคราว</div><div style="font-weight: bold; font-size: 16pt;">สำเนา</div></td>
</tr>
<tr>
    <td width="300" colspan="2">นามผู้รับของ : <?php echo $cusname; ?><br>พนักงานขาย:  <?php echo $editor; ?><br></td><td> </td><td colspan="2">เลขที่ใบส่งของ: <?php echo $so_id; ?><br>สาขา : <?php echo $shop; ?><br>วันที่ : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?>
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
<td style="border-left:1px solid black;" valign="top"><?php echo $loop->itse_serial_number; ?></td>
<td style="border-left:1px solid black;" valign="top"><?php echo $loop->br_name." ".$loop->it_refcode." ".$loop->it_model; ?><br><?php echo $loop->it_remark." , ".$loop->it_short_description; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo $loop->posrobi_qty." ".$loop->it_uom; ?></td>
<td align="center" style="border-left:1px solid black;" valign="top"><?php echo number_format($loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
<td align="right" style="border-left:1px solid black;" valign="top"><?php $cal = $loop->posrobi_qty*$loop->it_srp; echo number_format($cal, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $cal; $sum_qty += $loop->posrobi_qty; ?></td>
</tr>
<?php $no++; } } ?> 
    
<tr><td style="border-top:1px solid black;">&nbsp;</td><td style="border-top:1px solid black;">&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;">รวมจำนวน</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum_qty; ?></td><td align="right" style="border-left:1px solid black;border-top:1px solid black;">รวมเงิน</td><td align="right" style="border-left:1px solid black;border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ',')."&nbsp;&nbsp;"; ?></td></tr>
</tbody>
</table>
<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr>
<td width="340" align="center" style="border-left:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td><td width="340" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="50" align="center" style="border-left:1px solid black;">&nbsp;</td><td width="340" align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td width="340" align="center" style="border-left:1px solid black;">......................................</td><td width="340" align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td width="340" align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td width="340" align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td width="170" align="center" style="border-left:1px solid black; border-top:1px solid black;"><?php echo $cusname; ?><br>ผู้รับของ / Receiver</td><td width="170" align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;"><?php echo $editor; ?><br>ผู้ส่งของ / Delivered By</td>
</tr>
</tbody>
</table>
</body>
</html>