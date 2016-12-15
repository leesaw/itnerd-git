<?php
foreach($invoice_array as $loop) {
  $inv_id = $loop->pinv_id;
  $total_net = $loop->pinv_price_net;
  $total_topup = $loop->pinv_price_topup;
  $total_tax = $loop->pinv_price_tax;
  $inv_status = $loop->pinv_status;
  $cus_id = $loop->pinv_customer_id;
  $cus_name = $loop->pinv_customer_name;
  $cus_address = $loop->pinv_customer_address;
  $cus_taxid = $loop->pinv_customer_taxid;
  $cus_telephone = $loop->pinv_customer_telephone;
  $saleperson_number = $loop->nggu_number;
  $saleperson_name = $loop->nggu_firstname." ".$loop->nggu_lastname;
  $small_invoice_number = $loop->pinv_small_invoice_number;
  $invoice_number = $loop->pinv_invoice_number;
  $issuedate = $loop->pinv_issuedate;
  $issue_array = explode('-', $issuedate);
  $issue_array[0] += 543;
  $issuedate = $issue_array[2]."/".$issue_array[1]."/".$issue_array[0];
  $remark = $loop->pinv_remark;
  $shop_name = $loop->pinv_shop_name;
  $shop_company = $loop->pinv_shop_company;
  $shop_address1 = $loop->pinv_shop_address1;
  $shop_address2 = $loop->pinv_shop_address2;
  $shop_telephone = $loop->pinv_shop_telephone;
  $shop_fax = $loop->pinv_shop_fax;
  $shop_taxid = $loop->pinv_shop_taxid;
  $shop_branch_no = $loop->pinv_shop_branch_no;
}
$html = '
		<html><body><table border="0"><tbody><tr>
<td width="300">'.$shop_company.'<br>
'.$shop_address1.'<br/>
'.$shop_address2.'<br>Tax ID : '.$shop_taxid.' ';

if ($shop_branch_no == 0) $html .= 'Head Office';
else if ($shop_branch_no > 0) $html .= 'Branch No. '.str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);

$html .= '<br/>';
if ($shop_telephone != "") $html .= "Tel. ".$shop_telephone." ";
if ($shop_fax != "") $html .= "Fax. ".$shop_fax;

		$html .= '</td>
<td width="230" style="text-align: right;"><b style="font-size: 20pt">ใบกำกับภาษี /<br/>ใบเสร็จรับเงิน</b><br/><b style="font-size: 16pt">ต้นฉบับ</b></td></tr>
<tr><td></td><td></td></tr>

<tr><td width="350">นามลูกค้า : '.$cus_name.'<br>ที่อยู่ : '.$cus_address.'<br>เลขประจำตัวผู้เสียภาษี : '.$cus_taxid.'</td><td width="180">เลขที่ : '.$invoice_number.'<br>วันที่ออก : '.$issuedate.'<br>อ้างอิงใบกำกับภาษีอย่างย่อ : '.$small_invoice_number.'</td></tr>
</tbody></table>
<br/><br/>
<table border="0">
<thead>
	<tr>
		<th width="25" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">No.</th>
		<th width="200" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">รายละเอียดสินค้า</th>
		<th width="40" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</th>
		<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">หน่วยละ</th>
		<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">ส่วนลด</th>
		<th width="105" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวนเงิน</th>
	</tr>
</thead><tbody>';
		// $pdf->writeHTML($html, true, false, true, false, '');


		$no = 0;
		$max_item = 6;
		$qty = 0;
    $total_page = ceil(count($item_array)/$max_item);
    $current_page = 0;
		foreach ($item_array as $loop) {
			$no++;
			if (($no != 1) && ($no % $max_item == 1)) {
        $current_page++;
        $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">';
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
        $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190" style="text-align: center;">หน้า '.$current_page.' / '.$total_page;
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
        // sum qty & total price no vat
    		$html .= '<tr><td colspan="3" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จำนวน &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:center;"></td>
    		<td colspan="2" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';
    		// vat
    		$html .= '<tr>
    		<td colspan="6" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 % &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';
    		// total price vat
    		$html .= '<tr><td colspan="4" style="border-top:1px solid black;border-left:1px solid black;"></td>
    		<td colspan="2" style="border-top:1px solid black;border-right:1px solid black;text-align:right;">จํานวนเงินรวมทั้งสิ้น &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';

    		$html .= '<tr><td colspan="7" style="border-top:1px solid black;"></td></tr></tbody></table>';

        $html .= '<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
        <tbody>
        <tr style="">
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td>
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;"> </td>
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black; border-right:1px solid black;"> </td>
        </tr>
        <tr>
        <td height="30" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td>
        </tr>
        <tbody>
        </table>';
				$html .= '<br pagebreak="true"/>';
				$html .= '
						<html><body><table border="0"><tbody><tr>
        <td width="300">'.$shop_company.'<br>
        '.$shop_address1.'<br/>
        '.$shop_address2.'<br>Tax ID : '.$shop_taxid.' ';

        if ($shop_branch_no == 0) $html .= 'Head Office';
        else if ($shop_branch_no > 0) $html .= 'Branch No. '.str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);

        $html .= '<br/>';
        if ($shop_telephone != "") $html .= "Tel. ".$shop_telephone." ";
        if ($shop_fax != "") $html .= "Fax. ".$shop_fax;

						$html .= '</td>
				<td width="230" style="text-align: right;"><b style="font-size: 20pt">ใบกำกับภาษี /<br/>ใบเสร็จรับเงิน</b><br/><b style="font-size: 16pt">ต้นฉบับ</b></td></tr>
				<tr><td></td><td></td></tr>

        <tr><td width="350">นามลูกค้า : '.$cus_name.'<br>ที่อยู่ : '.$cus_address.'<br>เลขประจำตัวผู้เสียภาษี : '.$cus_taxid.'</td><td width="180">เลขที่ : '.$invoice_number.'<br>วันที่ออก : '.$issuedate.'<br>อ้างอิงใบกำกับภาษีอย่างย่อ : '.$small_invoice_number.'</td></tr>
        </tbody></table>
				<br/><br/>
				<table border="0">
				<thead>
					<tr>
						<th width="25" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">No.</th>
						<th width="200" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">รายละเอียดสินค้า</th>
						<th width="40" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</th>
						<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">หน่วยละ</th>
						<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">ส่วนลด</th>
						<th width="105" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวนเงิน</th>
					</tr>
				</thead><tbody>';
			}
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;">'.$no.'</td><td width="10" style="border-left:1px solid black;"></td><td width="190">'.$loop->pini_barcode.'<br/>'
				.$loop->pini_item_number."-".$loop->pini_item_name;
				if ($loop->pini_item_serial != "")	$html .= "<br>Serial : ".$loop->pini_item_serial; else $html .= "<br>";
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;">'.$loop->pini_item_qty.'</td>
				<td width="85" style="text-align:center;border-left:1px solid black;">'.number_format($loop->pini_item_srp, 2,'.',',').'</td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				if ($loop->pini_item_dc_baht > 0) $html .= number_format($loop->pini_item_dc_baht, 2,'.',',');
				// if ($loop->popi_item_dc_percent > 0) $html .= '<br>( '.number_format($loop->popi_item_dc_percent).'% )';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">'.number_format($loop->pini_item_net, 2,'.',',').'&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';



				$qty += $loop->pini_item_qty;
		}

    // discount topup
		if($total_topup > 0) {
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">ส่วนลดท้ายบิล</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">- '.number_format($total_topup, 2,'.',',').'&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
		}else{
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190"></td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;"></td>
				</tr>';
		}

    if ($no <= ($max_item*$total_page)) {
			for($j=$no; $j<($max_item*$total_page); $j++) {
				$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190"><br><br><br></td>
				<td width="40" style="text-align:center;border-left:1px solid black;"></td><td width="85" style="text-align:center;border-left:1px solid black;">
				</td><td width="85" style="text-align:center;border-left:1px solid black;"></td><td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;"></td></tr>';
			}
		}

    if ($total_page > 1) {
      $current_page++;
      $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">';
      $html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;">';
      $html .= '</td>
      <td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>';
      $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190" style="text-align: center;">หน้า '.$current_page.' / '.$total_page;
      $html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;">';
      $html .= '</td>
      <td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>';
    }

		// sum qty & total price no vat
		$html .= '<tr><td colspan="3" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จำนวน &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:center;">'.$qty.'</td>
		<td colspan="2" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_net-$total_topup-$total_tax, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';
		// vat
		$html .= '<tr>
		<td colspan="6" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 % &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_tax, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';
		// total price vat
		$html .= '<tr><td colspan="4" style="border-top:1px solid black;border-left:1px solid black;">&nbsp;&nbsp;('.num2thai($total_net-$total_topup).')</td>
		<td colspan="2" style="border-top:1px solid black;border-right:1px solid black;text-align:right;">จํานวนเงินรวมทั้งสิ้น &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_net-$total_topup, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';

		$html .= '<tr><td colspan="7" style="border-top:1px solid black;"></td></tr></tbody></table>';

    $html .= '<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr style="">
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td>
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;"> </td>
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="30" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td>
</tr>
<tbody>
</table>';

		// COPY
		$html .= '<br pagebreak="true"/>';

		$html .= '<table border="0"><tbody><tr>
<td width="300">'.$shop_company.'<br>
'.$shop_address1.'<br/>
'.$shop_address2.'<br>Tax ID : '.$shop_taxid.' ';

if ($shop_branch_no == 0) $html .= 'Head Office';
else if ($shop_branch_no > 0) $html .= 'Branch No. '.str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);

$html .= '<br/>';
if ($shop_telephone != "") $html .= "Tel. ".$shop_telephone." ";
if ($shop_fax != "") $html .= "Fax. ".$shop_fax;

		$html .= '</td>
<td width="230" style="text-align: right;"><b style="font-size: 20pt">ใบกำกับภาษี /<br/>ใบเสร็จรับเงิน</b><br/><b style="font-size: 16pt">สำเนา</b></td></tr>
<tr><td></td><td></td></tr>

<tr><td width="350">นามลูกค้า : '.$cus_name.'<br>ที่อยู่ : '.$cus_address.'<br>เลขประจำตัวผู้เสียภาษี : '.$cus_taxid.'</td><td width="180">เลขที่ : '.$invoice_number.'<br>วันที่ออก : '.$issuedate.'<br>อ้างอิงใบกำกับภาษีอย่างย่อ : '.$small_invoice_number.'</td></tr>
</tbody></table>
<br/><br/>
<table border="0">
<thead>
	<tr>
		<th width="25" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">No.</th>
		<th width="200" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">รายละเอียดสินค้า</th>
		<th width="40" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</th>
		<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">หน่วยละ</th>
		<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">ส่วนลด</th>
		<th width="105" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวนเงิน</th>
	</tr>
</thead><tbody>';
		// $pdf->writeHTML($html, true, false, true, false, '');


		$no = 0;
		$max_item = 6;
		$qty = 0;
    $total_page = ceil(count($item_array)/$max_item);
    $current_page = 0;
		foreach ($item_array as $loop) {
			$no++;
			if (($no != 1) && ($no % $max_item == 1)) {
        $current_page++;
        $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">';
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
        $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190" style="text-align: center;">หน้า '.$current_page.' / '.$total_page;
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
        // sum qty & total price no vat
    		$html .= '<tr><td colspan="3" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จำนวน &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:center;"></td>
    		<td colspan="2" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';
    		// vat
    		$html .= '<tr>
    		<td colspan="6" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 % &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';
    		// total price vat
    		$html .= '<tr><td colspan="4" style="border-top:1px solid black;border-left:1px solid black;"></td>
    		<td colspan="2" style="border-top:1px solid black;border-right:1px solid black;text-align:right;">จํานวนเงินรวมทั้งสิ้น &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';

    		$html .= '<tr><td colspan="7" style="border-top:1px solid black;"></td></tr></tbody></table>';

        $html .= '<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
        <tbody>
        <tr style="">
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td>
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;"> </td>
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black; border-right:1px solid black;"> </td>
        </tr>
        <tr>
        <td height="30" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td>
        </tr>
        <tbody>
        </table>';
				$html .= '<br pagebreak="true"/>';
				$html .= '
						<html><body><table border="0"><tbody><tr>
        <td width="300">'.$shop_company.'<br>
        '.$shop_address1.'<br/>
        '.$shop_address2.'<br>Tax ID : '.$shop_taxid.' ';

        if ($shop_branch_no == 0) $html .= 'Head Office';
        else if ($shop_branch_no > 0) $html .= 'Branch No. '.str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);

        $html .= '<br/>';
        if ($shop_telephone != "") $html .= "Tel. ".$shop_telephone." ";
        if ($shop_fax != "") $html .= "Fax. ".$shop_fax;

						$html .= '</td>
				<td width="230" style="text-align: right;"><b style="font-size: 20pt">ใบกำกับภาษี /<br/>ใบเสร็จรับเงิน</b><br/><b style="font-size: 16pt">สำเนา</b></td></tr>
				<tr><td></td><td></td></tr>

        <tr><td width="350">นามลูกค้า : '.$cus_name.'<br>ที่อยู่ : '.$cus_address.'<br>เลขประจำตัวผู้เสียภาษี : '.$cus_taxid.'</td><td width="180">เลขที่ : '.$invoice_number.'<br>วันที่ออก : '.$issuedate.'<br>อ้างอิงใบกำกับภาษีอย่างย่อ : '.$small_invoice_number.'</td></tr>
        </tbody></table>
				<br/><br/>
				<table border="0">
				<thead>
					<tr>
						<th width="25" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">No.</th>
						<th width="200" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">รายละเอียดสินค้า</th>
						<th width="40" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</th>
						<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">หน่วยละ</th>
						<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">ส่วนลด</th>
						<th width="105" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวนเงิน</th>
					</tr>
				</thead><tbody>';
			}
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;">'.$no.'</td><td width="10" style="border-left:1px solid black;"></td><td width="190">'.$loop->pini_barcode.'<br/>'
				.$loop->pini_item_number."-".$loop->pini_item_name;
				if ($loop->pini_item_serial != "")	$html .= "<br>Serial : ".$loop->pini_item_serial; else $html .= "<br>";
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;">'.$loop->pini_item_qty.'</td>
				<td width="85" style="text-align:center;border-left:1px solid black;">'.number_format($loop->pini_item_srp, 2,'.',',').'</td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				if ($loop->pini_item_dc_baht > 0) $html .= number_format($loop->pini_item_dc_baht, 2,'.',',');
				// if ($loop->popi_item_dc_percent > 0) $html .= '<br>( '.number_format($loop->popi_item_dc_percent).'% )';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">'.number_format($loop->pini_item_net, 2,'.',',').'&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';



				$qty += $loop->pini_item_qty;
		}

    // discount topup
		if($total_topup > 0) {
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">ส่วนลดท้ายบิล</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">- '.number_format($total_topup, 2,'.',',').'&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
		}else{
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190"></td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;"></td>
				</tr>';
		}

    if ($no <= ($max_item*$total_page)) {
			for($j=$no; $j<($max_item*$total_page); $j++) {
				$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190"><br><br><br></td>
				<td width="40" style="text-align:center;border-left:1px solid black;"></td><td width="85" style="text-align:center;border-left:1px solid black;">
				</td><td width="85" style="text-align:center;border-left:1px solid black;"></td><td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;"></td></tr>';
			}
		}

    if ($total_page > 1) {
      $current_page++;
      $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">';
      $html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;">';
      $html .= '</td>
      <td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>';
      $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190" style="text-align: center;">หน้า '.$current_page.' / '.$total_page;
      $html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;">';
      $html .= '</td>
      <td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>';
    }

		// sum qty & total price no vat
		$html .= '<tr><td colspan="3" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จำนวน &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:center;">'.$qty.'</td>
		<td colspan="2" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_net-$total_topup-$total_tax, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';
		// vat
		$html .= '<tr>
		<td colspan="6" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 % &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_tax, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';
		// total price vat
		$html .= '<tr><td colspan="4" style="border-top:1px solid black;border-left:1px solid black;">&nbsp;&nbsp;('.num2thai($total_net-$total_topup).')</td>
		<td colspan="2" style="border-top:1px solid black;border-right:1px solid black;text-align:right;">จํานวนเงินรวมทั้งสิ้น &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_net-$total_topup, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';

		$html .= '<tr><td colspan="7" style="border-top:1px solid black;"></td></tr></tbody></table>';

    $html .= '<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr style="">
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td>
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;"> </td>
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="30" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td>
</tr>
<tbody>
</table>';

		$html .= '</body></html>';


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

      echo $html;
?>
