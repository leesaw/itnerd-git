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
    <tr><td height="12" style="text-align:right"><?php echo $shape." ".$cutting;  ?></td></tr>
    <tr><td height="12" style="text-align:right"><?php echo $measurement;  ?></td></tr>
    <tr><td height="8"></td></tr>
    <tr><td height="12" style="text-align:right"><?php echo $carat;  ?></td></tr>
    <tr><td height="12" style="text-align:right"><?php echo $color;  ?></td></tr>
    <tr><td height="12" style="text-align:right"><?php echo $clarity;  ?></td></tr>
    <tr><td height="12" style="text-align:right"><?php echo $proportion;  ?></td></tr>
</tbody>
</table>
</body>
</html>