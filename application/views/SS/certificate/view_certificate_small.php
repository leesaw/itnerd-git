<!DOCTYPE html>
<html>
<head>
<title>NGG Certificate</title>
</head>
<body>
<?php 
foreach($cer_array as $loop) {
    $number = $loop->cer_number;
    $shape = $loop->shape;
    $cutting = $loop->cuttingstyle;
    $measurement = $loop->cer_measurement;
    $carat = $loop->cer_carat;
    $color = $loop->color;
    $clarity = $loop->clarity;
    $polish = $loop->polish;
    $symmetry = $loop->symmetry;
    $proportion = $loop->proportion;
    $fluorescence = $loop->fluorescence;
    
}    

foreach($result_array as $loop) {
    $pic_result = $loop->pre_value;
}
    
foreach($proportion_array as $loop) {
    $pic_proportion = $loop->ppr_value;
}
    
foreach($clarity_array as $loop) {
    $pic_clarity = $loop->pcl_value;
}
?>
<table border="0">
<tbody>
    <tr><td width="163" style="text-align:center"><b>DIAMOND REGISTERATION NUMBER</b><br><?php echo $number; ?></td></tr>
    <tr><td height="37"></td></tr>
    <tr><td height="12" style="text-align:right"><b><?php echo $shape." ".$cutting;  ?></b></td></tr>
    <tr><td height="12" style="text-align:right"><b><?php echo $measurement;  ?></b></td></tr>
    <tr><td height="8"></td></tr>
    <tr><td height="12" style="text-align:right"><b><?php echo $carat;  ?></b></td></tr>
    <tr><td height="12" style="text-align:right"><b><?php echo $color;  ?></b></td></tr>
    <tr><td height="12" style="text-align:right"><b><?php echo $clarity;  ?></b></td></tr>
    <tr><td height="12" style="text-align:right"><b><?php echo $proportion;  ?></b></td></tr>
</tbody>
</table>
<table border="0">
<tbody>
    <tr><td colspan="3" width="163" height="56"></td></tr>
    <tr><td width="52" height="12" style="text-align:center"><b><?php echo $polish;  ?></b></td><td width="52" height="12" style="text-align:center"><b><?php echo $symmetry;  ?></b></td><td width="52" height="12" style="text-align:center"><b><?php echo $fluorescence;  ?></b></td></tr>
    <tr><td height="5" colspan="3"> </td></tr>
    <tr><td style="text-align:center" colspan="3"><img src="<?php echo $path_result."/".$cer_id."/".$pic_result; ?>" width="163" height="65" /></td></tr>
    <tr><td height="70" colspan="3"> </td></tr>
</tbody>
</table>
</body>
</html>