<!DOCTYPE html>
<html>
<head>
<title>Stock Printing</title>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="450">
<div style="text-align: left; font-weight: bold; font-size: 20pt;">NGG TIMEPIECES COMPANY LIMITED</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek Sathon Bangkok 10120</div>
</td> 
<td width="50"> </td>
<td width="200"><div style="text-align: right; font-weight: bold; font-size: 16pt;">ใบรายการสินค้าในร้าน</div></td>
</tr>
<?php 
 $datetime = date("Y-m-d H:i:s");
?>
<tr>
    <td>สาขา <?php echo $shop_name; ?></td><td> </td><td> วันที่พิมพ์: <?php echo $datetime; ?><br>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="30">No.</th><th width="80" style="border-left:1px solid black;">Product Code</th><th width="60" style="border-left:1px solid black;">Serial</th><th width="50" style="border-left:1px solid black;">Brand</th><th width="170" style="border-left:1px solid black;">Description</th><th width="120" style="border-left:1px solid black;">Family</th><th width="60" style="border-left:1px solid black;">Bracelet</th><th width="50" style="border-left:1px solid black;">จำนวน</th><th width="70" style="border-left:1px solid black;">ราคาขาย</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $sum=0; $count_serial=0; if(isset($item_array)) { foreach($item_array as $loop) { ?>
<tr><td align="center" style="border-top:1px solid black;"><?php echo $no; ?></td>
<td style="border-left:1px solid black; border-top:1px solid black;"><?php echo $loop->it_refcode; ?></td>
<td style="border-left:1px solid black; border-top:1px solid black;"></td>
<td style="border-left:1px solid black; border-top:1px solid black;" align="center"><?php echo $loop->br_name; ?></td>
<td style="border-left:1px solid black; border-top:1px solid black;"><?php echo $loop->it_short_description; ?></td>
<td style="border-left:1px solid black; border-top:1px solid black;"><?php echo $loop->it_model; ?></td>
<td style="border-left:1px solid black; border-top:1px solid black;" align="center"><?php echo $loop->it_remark; ?></td>
<td align="center" style="border-left:1px solid black; border-top:1px solid black;"><?php echo $loop->stob_qty." &nbsp; ".$loop->it_uom; $sum += $loop->stob_qty; ?></td>
<td align="right" style="border-left:1px solid black; border-top:1px solid black;"><?php echo number_format($loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
</tr>
<?php
// print serial number
if(isset($serial_array)) {
    foreach ($serial_array as $loop2) {
        if ($loop->stob_item_id==$loop2->it_id) { ?>
<tr style=""><td align="center"></td>
<td align="center" style="border-left:1px solid black;"></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop2->itse_serial_number; $count_serial++; ?></td>
<?php if ($loop2->itse_enable ==0) { 
    $message = "";
    foreach($sold_array as $loop_sold) {
        if ($loop_sold->itse_serial_number == $loop2->itse_serial_number) {
            $message = "(ขายแล้ว)"; break;
        }
    }
    if ($message == "") {
        foreach($borrow_array as $loop_borrow) {
            if ($loop_borrow->itse_serial_number == $loop2->itse_serial_number) {
            $message = "(ถูกส่งไปให้ ".$loop_borrow->posrob_borrower_name." )"; break;
        }
        }
    }
?>
<td align="left" colspan="2"><?php echo $message; ?></td>
<?php }else{ ?>
<td align="center" style="border-left:1px solid black;"></td>
<td style="border-left:1px solid black;"></td>
<?php } ?>
<td align="center" style="border-left:1px solid black;"></td>
<td align="center" style="border-left:1px solid black;"></td>
<td align="center" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
</tr>
    <?php
        }
    }
}
?> 
<?php $no++; } } ?> 
<tr><td style="border-top:1px solid black;">&nbsp;</td><td style="border-top:1px solid black; border-left:1px solid black;">จำนวน Serial ทั้งหมด</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $count_serial; ?></td><td style="border-top:1px solid black; border-left:1px solid black;">&nbsp;</td><td style="border-top:1px solid black;">&nbsp;</td><td style="border-top:1px solid black;">&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;">รวมจำนวน</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum; ?></td><td style="border-top:1px solid black; border-left:1px solid black;">&nbsp;</td></tr>

</tbody>
</table>
<table style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td width="350" align="center">ผู้ตรวจสอบสินค้า</td><td width="350" align="center">ผู้อนุมัติ</td>
</tr>
<tr><td> &nbsp;</td><td> &nbsp;</td></tr>
<tr><td align="center">..........................................................</td><td align="center">  &nbsp;&nbsp;&nbsp; ..........................................................</td>
</tr>
<tbody>
</table>
</body>
</html>