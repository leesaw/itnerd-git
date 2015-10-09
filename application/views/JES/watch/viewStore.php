<!DOCTYPE html>
<html>
<head><?php $this->load->view('header_view'); ?></head>
<body>
<table class="table no-margin">
<thead><tr><th>รหัส</th><th>ชื่อสาขา</th></tr></thead>
<tbody>
<?php foreach($brand_array as $loop) { ?>
    <tr>
    <td style="font-size: 9pt;"><?php echo $loop->IHWareHouse; ?></td>
    <td style="font-size: 9pt;"><?php echo $loop->WHDesc1; ?></td>
    </tr>
 <?php } ?>
</tbody>
</table>
</body>
</html>