<!DOCTYPE html>
<html>
<head>
<title>Report</title>
<style>
table {
    border-collapse: collapse;
}


</style>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="150"><img src="<?php echo base_url(); ?>dist/img/logo_NGG.png" width="150px" />
</td> 
<td width="800" style="text-align: center;"><div style="font-weight: bold; font-size: 16pt;">รายงานประเมินและเป้าหมายการขาย<br>Monthly Target <u><?php echo number_format($daily_target); ?></u> เดือน : <u><?php echo $month; ?></u> พนักงานขาย : <u><?php echo $salename; ?></u> สาขา : <u><?php echo $shopname; ?></u></div></td>
<td width="150" style="text-align: right;"></td>
</tr>
</tbody>
</table>

<table border="1">
<tbody>
<tr>
    <th width="80" rowspan="2">วันที่</th>
    <th colspan="3">เป้าการขายประจำวัน</th>
    <th>
</tr>
</tbody>
</table>
</body>
</html>