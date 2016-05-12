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
    $comment = $loop->cer_comment;
}
    
$none_picture = base_url()."picture/ss/none.png";

foreach($result_array as $loop) {
    $pic_result = $loop->pre_value;
}
    
if ($pic_result != "") {
    $pic_result = $path_result."/".$cer_id."/".$pic_result;
}else{
    $pic_result = $none_picture;
}
    
foreach($proportion_array as $loop) {
    $pic_proportion = $loop->ppr_value;
}
    
if ($pic_proportion != "") {
    $pic_proportion = $path_proportion."/".$cer_id."/".$pic_proportion;
}else{
    $pic_proportion = $none_picture;
}
    
foreach($clarity_array as $loop) {
    $pic_clarity = $loop->pcl_value;
}
  
if ($pic_clarity != "") {
    $pic_clarity = $path_clarity."/".$cer_id."/".$pic_clarity;
}else{
    $pic_clarity = $none_picture;
}

?>
<table border="0">
<tbody>
    <tr><td height="100"></td><td> </td><td style="text-align:center"><h3>DIAMOND REGISTERATION NUMBER</h3><br><b><?php echo $number; ?></b></td></tr>
    <tr><td width="232" height="17" ></td><td rowspan="8" width="36"> </td><td rowspan="8" width="253"><img src="<?php echo $pic_proportion; ?>" width="253" height="135" /></td></tr>
    <tr><td width="232" height="12" style="text-align:right"><b><?php echo $shape." ".$cutting;  ?></b></td></tr>
    <tr><td width="232" height="12" style="text-align:right"><b><?php echo $measurement;  ?></b></td></tr>
    <tr><td width="232" height="8" style="text-align:right"> </td></tr>
    <tr><td width="232" height="12" style="text-align:right"><b><?php echo $carat." Ct";  ?></b></td></tr>
    <tr><td width="232" height="12" style="text-align:right"><b><?php echo $color;  ?></b></td></tr>
    <tr><td width="232" height="12" style="text-align:right"><b><?php echo $clarity;  ?></b></td></tr>
    <tr><td width="232" height="12" style="text-align:right"><b><?php echo $proportion;  ?></b></td></tr>
</tbody>
</table>
<table border="1">
<tbody>
    <tr><td height="30" colspan="3"> </td><td> </td><td> </td></tr>
    <tr><td colspan="3" width="232" height="30" style="text-align:right"> </td><td rowspan="4" width="36"> </td><td rowspan="4" width="253"><img src="<?php echo $pic_clarity; ?>" width="253" height="210" /></td></tr>
    <tr><td width="80" height="12" style="text-align:center"><b><?php echo $polish;  ?></b></td><td width="75" height="12" style="text-align:center"><b><?php echo $symmetry;  ?></b></td><td width="75" height="12" style="text-align:center"><b><?php echo $fluorescence;  ?></b></td></tr>
    <tr><td height="8" colspan="3"> </td></tr>
    <tr><td width="228" style="text-align:center" colspan="3"><img src="<?php echo $pic_result; ?>" width="228" height="80" /></td></tr>
    <tr><td height="30" colspan="3"><?php echo substr($comment,0,26); ?></td><td> </td><td><?php echo substr($comment,0,26); ?></td></tr>
</tbody>
</table>
</body>
</html>