<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('NGG/gold/header_view'); ?>
</head>
<body>
<table class="table table-striped">
	<tr>
		<th>วันที่</th>
		<th>ประเภทสินค้า</th>
		<th>รหัสสินค้า</th>
		<th>จำนวนเงิน</th>
	</tr>
<?php foreach($item_array as $loop) { ?>
	<tr>
		<td><?php echo $loop->ngw_issuedate; ?></td>
		<td><?php echo $loop->ngw_product; ?></td>
		<td><?php echo $loop->ngw_code; ?></td>
		<td><?php echo $loop->ngw_price; ?></td>
	</tr>
<?php } ?>
</table>
<?php $this->load->view('js_footer'); ?>
</body>
</html>