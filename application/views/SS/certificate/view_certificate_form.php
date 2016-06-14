<!DOCTYPE html>
<html>
<head>
<title>NGG Certificate</title>
<style>
    .underline{
        border-bottom:1px solid black;
    }
    .lineleftbottom{
        border-left:1px solid black;
        border-bottom:1px solid black;
    }
    .lineleftrightbottom{
        border-left:1px solid black;
        border-right:1px solid black;
        border-bottom:1px solid black;
    }
    .lineleft{
        border-left:1px solid black;
    }
    .lineleftright{
        border-left:1px solid black;
        border-right:1px solid black;
    }
    .imgcenter {
        display: block;
        margin: 0 auto;
    }
</style>
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
    $proportion_id = $loop->lpt_id;
    $totaldepth = $loop->cer_totaldepth;
    $tablesize = $loop->cer_tablesize;
    $crownheight = $loop->cer_crownheight;
    $crownangle = $loop->cer_crownangle;
    $starlength = $loop->cer_starlength;
    $paviliondepth = $loop->cer_paviliondepth;
    $pavilionangle = $loop->cer_pavilionangle;
    $lowerhalflength = $loop->cer_lowerhalflength;
    $girdlethickness = $loop->cer_girdlethickness;
    $girdlefinish = $loop->girdlefinish;
    $girdlefinish_id = $loop->lgf_id;
    $culet = $loop->culet;
    $culet_id = $loop->lct_id;
    $girdleinscription = $loop->cer_girdleinscription;
    $softwareresult = $loop->cer_softwareresult;
    $fluorescence = $loop->fluorescence;
    $comment = $loop->cer_comment;
    $symbol = explode("#",$loop->cer_symbol);
}    

$none_picture = base_url()."picture/ss/none2.png";

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
    
$symbol_key = array();
$index = 0;
foreach($symbol_array as $loop) {
    for($i=0; $i<count($symbol); $i++) {
        if ($symbol[$i] == $loop->id) {
            $symbol_key[$index] = array("value" => $loop->value, "picture" => $loop->picture);
            $index++;
        }
    }
}
    
?>
<table border="0">
<tbody>
    <tr><td width="350"><img src="<?php echo base_url()."dist/img/logo_NGG.png"; ?>" width="180"></td><td width="300" style="vertical-align:top; text-align:center"><b>NATURAL DIAMOND CERTIFICATE (Type la)</b><br><br><br><?php echo $number; ?><br>-----------------------------------<br>DIAMOND REGISTERATION NUMBER</td></tr>
</tbody>
</table>
<br>
<br>    
<table border="0">
<tbody>
    <tr><td width="20"></td><td width="180"></td><td width="30"></td><td width="50"></td><td width="50"></td><td width="40"></td><td width="30"></td><td width="105"></td><td width="20"></td><td width="220"></td></tr>
    
    
    <tr><td colspan="2" height="25"><b>SHAPE</b></td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $shape; ?></td><td> </td><td><b>CUTTING STYLE</b></td><td> </td><td class="underline">&nbsp;&nbsp;&nbsp;<?php echo $cutting; ?></td></tr>
    <tr><td height="25"> </td><td>MEASUREMENT</td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $measurement; ?></td><td colspan="4" class="underline"> </td></tr>
    <tr><td colspan="2"></td><td style="font-size: 10px" colspan="8">&nbsp;&nbsp;&nbsp;MINIMUM GIRDLE DIAMETER - MAXIMUM GIRDLE DIAMETER X DEPTH IN MM</td></tr>
    <tr><td colspan="10" height="10"> </td></tr>
    <tr><td colspan="2" height="25"><b>CARAT WEIGHT</b></td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $carat; ?> CARATS</td><td colspan="4"></td></tr>
    <tr><td colspan="10" height="15"> </td></tr>
    <tr><td colspan="2" height="25"><b>COLOR GRADE</b></td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $color; ?> </td><td></td><td colspan="3" rowspan="2" style="vertical-align:top;">
        
    <table border="0" height="75" style="font-size:8px">
        <tbody>
            <tr><th width="15" height="23" class="lineleftbottom">D</th><th width="15" class="lineleftbottom">E</th><th width="15" class="lineleftbottom">F</th><th width="15" class="lineleftbottom">G</th><th width="15" class="lineleftbottom">H</th><th width="15" class="lineleftbottom">I</th><th width="15" class="lineleftbottom">J</th><th width="15" class="lineleftbottom">K</th><th width="15" class="lineleftbottom">L</th><th width="15" class="lineleftbottom">M</th><th width="15" class="lineleftbottom">N</th><th width="15" class="lineleftbottom">O</th><th width="15" class="lineleftbottom">P</th><th width="15" class="lineleftbottom">Q</th><th width="15" class="lineleftbottom">R</th><th width="15" class="lineleftbottom">S</th><th width="15" class="lineleftbottom">T</th><th width="15" class="lineleftbottom">U</th><th width="15" class="lineleftbottom">V</th><th width="15" class="lineleftbottom">W</th><th width="15" class="lineleftbottom">X</th><th width="15" class="lineleftbottom">Y</th><th width="15" class="lineleftrightbottom">Z</th></tr>
            <tr><td colspan="3" height="40" class="lineleft"><center>COLORLESS</center></td><td colspan="4" class="lineleft"><center>NEAR COLORLESS</center></td><td colspan="3" class="lineleft"><center>FAINT</center></td><td colspan="5" class="lineleft"><center>VERY LIGHT</center></td><td colspan="8" class="lineleftright"><center>LIGHT</center></td></tr>
        </tbody>
    </table>
        
        </td></tr>
    <tr><td colspan="7" height="50"> </td><td colspan="3"></td></tr>
    
    <tr><td colspan="2" height="25"><b>CLARITY GRADE</b></td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $clarity; ?> </td><td></td><td colspan="3" rowspan="2" style="vertical-align:top;">

    <table border="0" height="75" style="font-size:8px">
        <tbody>
            <tr><th width="60" height="23" class="lineleftbottom">FL</th><th width="60" class="lineleftbottom">IF</th><th width="38" class="lineleftbottom">VVS1</th><th width="37" class="lineleftbottom">VVS2</th><th width="34" class="lineleftbottom">VS1</th><th width="34" class="lineleftbottom">VS2</th><th width="34" class="lineleftbottom">SI1</th><th width="33" class="lineleftrightbottom">SI2</th></tr>
            <tr><td height="40" class="lineleft"><center>FLAWLESS</center></td><td class="lineleft"><center>INTERNALLY FLAWLESS</center></td><td colspan="2" class="lineleft"><center>VERY VERY SLIGHTLY INCLUDED</center></td><td colspan="2" class="lineleft"><center>VERY SLIGHTLY INCLUDED</center></td><td colspan="2" class="lineleftright"><center>SLIGHTLY INCLUDED</center></td></tr>
        </tbody>
    </table>
       
        </td></tr>
    

    <tr><td colspan="7" height="50"> </td><td colspan="3"></td></tr>

    <tr><td colspan="2" height="20"><b>CUT</b></td><td colspan="8"></td></tr>
    <?php if ($proportion_id != 100) { ?>
    <tr><td></td><td height="20">PROPORTION</td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $proportion; ?></td><td rowspan="13"></td><td colspan="3" rowspan="13" style="text-align:center;"><img src="<?php echo $pic_proportion; ?>" style="max-width:300px;max-height:250px"></td></tr>
    <?php } ?>
    
    <tr><td></td><td height="20">SYMMETRY</td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $symmetry; ?></td>
    <?php if ($proportion_id != 100) { ?>
        <td></td></tr>
    <?php }else{ ?>
        <td rowspan="13"></td><td colspan="3" rowspan="13" style="text-align:center;"><img src="<?php echo $pic_proportion; ?>" style="max-width:300px; max-height:300px"></td></tr>
    <?php } ?>
    <tr><td></td><td height="20">POLISH</td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $polish; ?></td></tr>
    
    <?php if ($proportion_id == 100) { ?>
    <tr><td></td><td height="20"> </td><td colspan="4"> </td></tr>
    <?php } ?>
    
    <tr><td colspan="6" height="10"> </td></tr>
    
    <tr><td colspan="2" height="20"><b>TECHNICAL INFORMATION</b></td><td colspan="3"></td></tr>
    <?php $empty = ""; ?>
    <?php if ($totaldepth != 0) { ?>
    <tr><td></td><td height="20" colspan="2">TOTAL DEPTH PERCENTAGE</td><td></td><td  class="underline">&nbsp;&nbsp;&nbsp;<?php echo $totaldepth; ?></td><td>&nbsp;&nbsp;%</td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="6"> </td></tr>'; } ?>
    
    <?php if ($tablesize != 0) { ?>
    <tr><td></td><td height="20" colspan="2">TABLE SIZE PERCENTAGE</td><td></td><td  class="underline">&nbsp;&nbsp;&nbsp;<?php echo $tablesize; ?></td><td>&nbsp;&nbsp;%</td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="6"> </td></tr>'; } ?>
    
    <?php if ($crownheight != 0) { ?>
    <tr><td></td><td height="20" colspan="2">CROWN HEIGHT PERCENTAGE</td><td></td><td  class="underline">&nbsp;&nbsp;&nbsp;<?php echo $crownheight; ?></td><td>&nbsp;&nbsp;%</td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="6"> </td></tr>'; } ?>
    
    <?php if ($crownangle != 0) { ?>
    <tr><td></td><td height="20" colspan="2">CROWN ANGLE</td><td></td><td  class="underline">&nbsp;&nbsp;&nbsp;<?php echo $crownangle; ?> &deg;</td><td></td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="6"> </td></tr>'; } ?>
    
    <?php if ($starlength != 0) { ?>
    <tr><td></td><td height="20" colspan="2">STAR LENGHT PERCENTAGE</td><td></td><td  class="underline">&nbsp;&nbsp;&nbsp;<?php echo $starlength; ?></td><td>&nbsp;&nbsp;%</td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="6"> </td></tr>'; } ?>
    
    <?php if ($paviliondepth != 0) { ?>
    <tr><td></td><td height="20" colspan="2">PAVILION DEPTH PERCENTAGE</td><td></td><td  class="underline">&nbsp;&nbsp;&nbsp;<?php echo $paviliondepth; ?></td><td>&nbsp;&nbsp;%</td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="6"> </td></tr>'; } ?>
    
    <?php if ($pavilionangle != 0) { ?>
    <tr><td></td><td height="20" colspan="2">PAVILION ANGLE</td><td></td><td  class="underline">&nbsp;&nbsp;&nbsp;<?php echo $pavilionangle; ?> &deg;</td><td></td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="6"> </td></tr>'; } ?>
    
    <?php if ($lowerhalflength != 0) { ?>
    <tr><td></td><td height="20" colspan="2">LOWER HALF-LENGTH PERCENTAGE</td><td></td><td  class="underline">&nbsp;&nbsp;&nbsp;<?php echo $lowerhalflength; ?></td><td>&nbsp;&nbsp;%</td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="6"> </td></tr>'; } ?>
    
    <?php echo $empty; $empty = ""; ?>

    <tr><td colspan="7" height="10"> </td><td colspan="3" rowspan="11" style="vertical-align:top;"><table border="0"><tbody><tr><td style="font-size:12px" width="345">CLARITY PLOT</td></tr><tr><td><center><img src="<?php echo $pic_clarity; ?>" style="max-width:300px; max-height:250px;"/></center></td></tr></tbody></table></td></tr>
    
    <?php if ($lowerhalflength != 0) { ?>
    <tr><td></td><td height="20">GIRDLE THICKNESS</td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $girdlethickness; ?></td><td></td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="7"> </td></tr>'; } ?>
    
    <?php if ($girdlefinish_id != 100) { ?>
    <tr><td></td><td height="20">GIRDLE FINISH</td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $girdlefinish; ?></td><td></td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="7"> </td></tr>'; } ?>
    
    <?php if ($culet_id != 100) { ?>
    <tr><td></td><td height="20">CULET</td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $culet; ?></td><td></td></tr>
    <?php }else{ $empty .= '<tr><td height="20" colspan="7"> </td></tr>'; } ?>
        
    <tr><td colspan="7" height="10"> </td></tr>
    
    <tr><td colspan="2" height="20">GIRDLE INSCRIPTION</td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $girdleinscription; ?></td><td></td></tr>
    <tr><td colspan="2" height="20">FLUORESCENCE</td><td colspan="4" class="underline">&nbsp;&nbsp;&nbsp;<?php echo $fluorescence; ?></td><td></td></tr>
    <?php echo $empty; ?>
    <tr><td colspan="7" height="10"> </td></tr>
    
    <tr><td colspan="6" height="25">SOFTWARE RESULT : PASS</td><td></td></tr>
    <tr><td colspan="6" height="90"><img src="<?php echo $pic_result; ?>" style="width:100%; max-width:400px; max-height:90px" /></td><td> </td></tr>
    <tr><td colspan="7" height="10"> </td></tr>
    <tr><td colspan="6" height="20">COMMENT</td><td></td><td colspan="3">KEY TO SYMBOL</td></tr>
    <tr><td colspan="6" height="20"><?php echo $comment; ?></td><td></td><td colspan="3"><?php for($i=0; $i<count($symbol_key); $i++) {
            echo "<img src='".base_url()."/picture/ss/".$symbol_key[$i]['picture']."' width='8'> ".$symbol_key[$i]['value']." &nbsp;&nbsp;&nbsp; ";
            if ($i==3) echo "<br>";
        } ?></td></tr>
    <tr><td colspan="10" height="10"> </td></tr>
    
    <tr><td colspan="6" height="20" style="font-size:8px">THE CHARACTERISTICS OF DIAMOND DESCRIBED IN THIS CERTIFICATE WERE DETERMINED USING 10X BINOCULAR MAGNIFICATION, DIAMOND LITE AND MASTER COLOR DIAMONDS, ULTRAVIOLET LIGHT, MILLIMETER GAUGE, DIAMOND BALANCE AND AN ELECTRONIC PROPORTION MEASUREMENT SYSTEM.</td><td></td><td colspan="3" style="font-size:8px">RED SYMBOL DENOTES INTERNAL CHARACTERISTICS (INCLUSIONS). GREEN SYMBOLS DENOTE EXTERNAL CHARACTERISTICS (BLEMISHES). DIAGRAM IS AN APPROXIMATE REPRESENTATION OF THE DIAMOND AND SYMBOLS SHOWN INDICATE TYPE, POSITION AND APPROXIMATE SIZE OF CLARITY CHARACTERISTICS. ALL CLARITY CHARACTERISTICS MAY NOT BE SHOWN. DETAILS OF FINISH ARE NOT SHOWN.</td></tr>
    
    <tr><td colspan="10" height="10"> </td></tr>
    <tr style="background-color:black;"><td colspan="10" style="font-size:8px;color:white"><center>FOR TERM AND CONDITION SEE WWW.NGGJEWELLERY.COM/TERM OR CALL 02 635 1391</center></td></tr>
</tbody>
</table>
</body>
</html>