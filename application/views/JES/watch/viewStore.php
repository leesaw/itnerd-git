<!DOCTYPE html>
<html>
<head><?php $this->load->view('header_view'); ?></head>
<body>
<table class="table no-margin">
<thead><tr><th>รหัส</th><th>ชื่อสาขา</th></tr></thead>
<tbody>
<?php foreach($brand_array as $loop) { ?>
    <tr>
    <td><?php echo $loop->WTCode; ?></td>
    <td><?php echo $loop->WTDesc1; ?></td>
    </tr>
 <?php } ?>
</tbody>
</table>
</body>
</html>