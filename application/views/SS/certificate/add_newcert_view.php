<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
        <div class="content-wrapper">
        <section class="content-header">
            
            <h1>เพิ่มข้อมูล Certificate</h1>
        </section>
            
		<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title">กรุณาใส่ข้อมูลให้ครบทุกช่องที่มี *</h3>
                </div>
                <div class="box-body">
                
        <?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
              else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
        ?>
		<div class="row">
            <div class="col-xs-6">
                <div class="row"><div class="col-xs-12">
                <div class="panel panel-primary">
                    
					<div class="panel-heading"><strong>Details</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form name="form1" id="form1" action="<?php echo site_url('ss_certificate/save'); ?>" method="post">
                                    <div class="form-group">
                                        <label>NATURAL DIAMOND *</label>
                                        <select class="form-control" name="natural" id="natural">
                                            <option value="0">-- เลือก --</option>
										<?php foreach($naturaldiamond_array as $loop){
												echo "<option value='".$loop->id."'>".$loop->value."</option>";
										 } ?>
                                        </select>
                                    </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SHAPE *</label>
                                    <select class="form-control" name="shape" id="shape">
                                        <option value="0">-- เลือก --</option>
                                        <?php foreach($shape_array as $loop){
                                                echo "<option value='".$loop->id."'>".$loop->value."</option>";
                                         } ?>
                                    </select>
                                </div>
							</div>
                            <div class="col-md-6">
									<div class="form-group">
                                        <label>CUTTING STYLE *</label>
                                        <select class="form-control" name="cuttingstyle" id="cuttingstyle">
                                            <option value="0">-- เลือก --</option>
										<?php foreach($cuttingstyle_array as $loop){
												echo "<option value='".$loop->id."'>".$loop->value."</option>";
										 } ?>
                                        </select>
                                    </div>
							</div>
						</div>
						<div class="row">
                            <div class="col-md-6">
									<div class="form-group">
                                            <label>MEASUREMENT *</label>
                                            <input type="text" class="form-control" name="measurement" id="measurement" value="<?php echo set_value('measurement'); ?>" required>
											<p class="help-block"><?php echo form_error('measurement'); ?></p>
                                    </div>
							</div>
                            <div class="col-md-6">
									<div class="form-group">
                                            <label>CARAT WEIGHT *</label>
                                            <input type="text" class="form-control" name="carat" id="carat" value="<?php echo set_value('carat'); ?>">
											<p class="help-block"><?php echo form_error('carat'); ?></p>
                                    </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>COLOR GRADE *</label>
                                    <select class="form-control" name="color" id="color">
                                        <option value="0">-- เลือก --</option>
                                    <?php foreach($color_array as $loop){
                                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                                     } ?>
                                    </select>
                                </div>
							</div>
                            <div class="col-md-6">
									<div class="form-group">
                                        <label>CLARITY GRADE *</label>
                                        <select class="form-control" name="clarity" id="clarity">
                                            <option value="0">-- เลือก --</option>
										<?php foreach($clarity_array as $loop){
												echo "<option value='".$loop->id."'>".$loop->value."</option>";
										 } ?>
                                        </select>
                                    </div>
							</div>
						</div>
						
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>GIRDLE INSCRIPTION *</label>
                                    <input type="text" class="form-control" name="girdleinscription" id="girdleinscription" value="<?php echo set_value('girdleinscription'); ?>" required>
                                    <p class="help-block"><?php echo form_error('girdleinscription'); ?></p>
                                </div>
							</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>FLUORESCENCE *</label>
                                    <select class="form-control" name="fluorescence" id="fluorescence">
                                        <option value="0">-- เลือก --</option>
                                    <?php foreach($fluorescence_array as $loop){
                                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                                     } ?>
                                    </select>
                                </div>
							</div>
						</div>
					</div>
				</div></div></div>
                <div class="row">
                <div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading"><strong>COMMENT</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>COMMENT * (ไม่เกิน 90 ตัวอักษร)</label>
                                    <input type="text" class="form-control" name="comment" id="comment" value="<?php echo set_value('comment'); ?>" maxlength="90" required>
                                    <p class="help-block"><?php echo form_error('comment'); ?></p>
                                </div>
							</div>
						</div>
                    </div>
                </div>
                </div></div>
			</div>	
            <div class="col-xs-6">
                <div class="row">
                <div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading"><strong>CUT</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>PROPORTION *</label>
                                    <select class="form-control" name="proportion" id="proportion">
                                        <option value="0">-- เลือก --</option>
                                    <?php foreach($proportion_array as $loop){
                                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                                     } ?>
                                    </select>
                                </div>
							</div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>SYMMETRY *</label>
                                    <select class="form-control" name="symmetry" id="symmetry">
                                        <option value="0">-- เลือก --</option>
                                    <?php foreach($symmetry_array as $loop){
                                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                                     } ?>
                                    </select>
                                </div>
							</div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>POLISH *</label>
                                    <select class="form-control" name="polish" id="polish">
                                        <option value="0">-- เลือก --</option>
                                    <?php foreach($polish_array as $loop){
                                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                                     } ?>
                                    </select>
                                </div>
							</div>
						</div>
                    </div>
                </div>
                </div></div>
                <div class="row">
                <div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading"><strong>TECHNICAL INFORMATION</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* TOTAL DEPTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totaldepth" id="totaldepth" value="<?php echo set_value('totaldepth'); ?>">
				                    <p class="help-block"><?php echo form_error('totaldepth'); ?></p>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* TABLE SIZE %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totalsize" id="totalsize" value="<?php echo set_value('totalsize'); ?>">
				                    <p class="help-block"><?php echo form_error('totalsize'); ?></p>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* CROWN HEIGHT %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="crownheight" id="crownheight" value="<?php echo set_value('crownheight'); ?>">
				                    <p class="help-block"><?php echo form_error('crownheight'); ?></p>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* CROWN ANGLE &deg;</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="crownangle" id="crownangle" value="<?php echo set_value('crownangle'); ?>">
				                    <p class="help-block"><?php echo form_error('crownangle'); ?></p>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* STAR LENGTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="starlength" id="starlength" value="<?php echo set_value('starlength'); ?>">
				                    <p class="help-block"><?php echo form_error('starlength'); ?></p>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* PAVILION DEPTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="paviliondepth" id="paviliondepth" value="<?php echo set_value('paviliondepth'); ?>">
				                    <p class="help-block"><?php echo form_error('paviliondepth'); ?></p>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* PAVILION ANGLE &deg;</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="pavilionangle" id="pavilionangle" value="<?php echo set_value('pavilionangle'); ?>">
				                    <p class="help-block"><?php echo form_error('pavilionangle'); ?></p>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* LOWER HALF-LENGTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="lowerhalflength" id="lowerhalflength" value="<?php echo set_value('lowerhalflength'); ?>">
				                    <p class="help-block"><?php echo form_error('lowerhalflength'); ?></p>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <label>GIRDLE THICKNESS *</label>
                                <input type="text" class="form-control" name="girdlethickness" id="girdlethickness" value="<?php echo set_value('girdlethickness'); ?>" required>
                                    <p class="help-block"><?php echo form_error('girdlethickness'); ?></p>
							</div>
                            <div class="col-xs-6">
                                <label>GIRDLE FINISH *</label>
                                <select class="form-control" name="girdlefinish" id="girdlefinish">
                                    <option value="0">-- เลือก --</option>
                                <?php foreach($girdlefinish_array as $loop){
                                        echo "<option value='".$loop->id."'>".$loop->value."</option>";
                                 } ?>
                                </select>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <label>CULET *</label>
                                <select class="form-control" name="culet" id="culet">
                                    <option value="0">-- เลือก --</option>
                                <?php foreach($culet_array as $loop){
                                        echo "<option value='".$loop->id."'>".$loop->value."</option>";
                                 } ?>
                                </select>
							</div>
						</div>
                    </div>
                </div>
                </div>
                </div>

            </div>
            </div>
            <hr>
            <div class="row">
							<div class="col-md-6">
									<button type="button" name="savebtn" id="savebtn"  class="btn btn-primary" onclick="disablebutton()"><i class='fa fa-save'></i>  บันทึก </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("sesto/main"); ?>'"> ยกเลิก </button>
							</div>
						</div>
								
									
						</form>
            </div>
            </div>
            </div>                
    </section>
	</div>
</div>
<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script>
$(document).ready(function()
{    
    //document.getElementById("savebtn").disabled = false;

});
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 5000);

function numberWithCommas(obj) {
	var x=$(obj).val();
    var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/,/g,"");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $(obj).val(parts.join("."));
}
function autobarcode(obj) {
	var input=$(obj).val();
	$('#barcode').val(input);
}
function disablebutton() {
    
    
    if (document.getElementById('natural').value < 1) {
        alert("กรุณาเลือก NATURAL DIAMOND");
        document.getElementById('natural').focus();
    }else if (document.getElementById('shape').value < 1) {
        alert("กรุณาเลือก SHAPE");
        document.getElementById('shape').focus();
    }else if (document.getElementById('cuttingstyle').value < 1) {
        alert("กรุณาเลือก CUTTING STYLE");
        document.getElementById('cuttingstyle').focus();
    }else if (document.getElementById('measurement').value == "") {
        alert("กรุณาป้อนค่า MEASUREMENT");
        document.getElementById('measurement').focus();
    }else if (document.getElementById('carat').value == "") {
        alert("กรุณาป้อนค่า CARAT WEIGHT");
        document.getElementById('carat').focus();
    }else if ((document.getElementById('carat').value*1000) % 1 != 0) {
        alert("กรุณาป้อนค่า CARAT WEIGHT ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('carat').focus();
    }else if (document.getElementById('color').value < 1) {
        alert("กรุณาเลือก COLOR GRADE");
        document.getElementById('color').focus();
    }else if (document.getElementById('clarity').value < 1) {
        alert("กรุณาเลือก CLARITY GRADE");
        document.getElementById('clarity').focus();
    }else if (document.getElementById('girdleinscription').value == "") {
        alert("กรุณาป้อนค่า GIRDLE INSCRIPTION");
        document.getElementById('girdleinscription').focus();
    }else if (document.getElementById('fluorescence').value < 1) {
        alert("กรุณาเลือก FLUORESCENCE");
        document.getElementById('fluorescence').focus();
    }else if (document.getElementById('proportion').value < 1) {
        alert("กรุณาเลือก PROPORTION");
        document.getElementById('proportion').focus();
    }else if (document.getElementById('symmetry').value < 1) {
        alert("กรุณาเลือก SYMMETRY");
        document.getElementById('symmetry').focus();
    }else if (document.getElementById('polish').value < 1) {
        alert("กรุณาเลือก POLISH");
        document.getElementById('polish').focus();
    }else if (document.getElementById('totaldepth').value == "") {
        alert("กรุณาป้อนค่า TOTAL DEPTH");
        document.getElementById('totaldepth').focus();
    }else if ((document.getElementById('totaldepth').value*1000) % 1 != 0) {
        alert("กรุณาป้อนค่า TOTAL DEPTH ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('totaldepth').focus();
    }else if (document.getElementById('totalsize').value == "") {
        alert("กรุณาป้อนค่า TOTAL SIZE");
        document.getElementById('totalsize').focus();
    }else if ((document.getElementById('totalsize').value*1000) % 1 != 0) {
        alert("กรุณาป้อนค่า TOTAL SIZE ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('totalsize').focus();
    }else if (document.getElementById('crownheight').value == "") {
        alert("กรุณาป้อนค่า CROWN HEIGHT");
        document.getElementById('crownheight').focus();
    }else if ((document.getElementById('crownheight').value*1000) % 1 != 0) {
        alert("กรุณาป้อนค่า CROWN HEIGHT ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('crownheight').focus();
    }else if (document.getElementById('crownangle').value == "") {
        alert("กรุณาป้อนค่า CROWN ANGLE");
        document.getElementById('crownangle').focus();
    }else if ((document.getElementById('crownangle').value*1000) % 1 != 0) {
        alert("กรุณาป้อนค่า CROWN ANGLE ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('crownangle').focus();
    }else if (document.getElementById('starlength').value == "") {
        alert("กรุณาป้อนค่า STAR LENGTH");
        document.getElementById('starlength').focus();
    }else if ((document.getElementById('starlength').value*1000) % 1 != 0) {
        alert("กรุณาป้อนค่า STAR LENGTH ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('starlength').focus();
    }else if (document.getElementById('paviliondepth').value == "") {
        alert("กรุณาป้อนค่า PAVILION DEPTH");
        document.getElementById('paviliondepth').focus();
    }else if ((document.getElementById('paviliondepth').value*1000) % 1 != 0) {
        alert("กรุณาป้อนค่า PAVILION DEPTH ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('paviliondepth').focus();
    }else if (document.getElementById('pavilionangle').value == "") {
        alert("กรุณาป้อนค่า PAVILION ANGLE");
        document.getElementById('pavilionangle').focus();
    }else if ((document.getElementById('pavilionangle').value*1000) % 1 != 0) {
        alert("กรุณาป้อนค่า PAVILION ANGLE ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('pavilionangle').focus();
    }else if (document.getElementById('lowerhalflength').value == "") {
        alert("กรุณาป้อนค่า LOWER HALF-LENGTH");
        document.getElementById('lowerhalflength').focus();
    }else if ((document.getElementById('lowerhalflength').value*1000) % 1 != 0) {
        alert("กรุณาป้อนค่า LOWER HALF-LENGTH ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('lowerhalflength').focus();
    }else if (document.getElementById('girdlethickness').value == "") {
        alert("กรุณาป้อนค่า GIRDLE THICKNESS");
        document.getElementById('girdlethickness').focus();
    }else if (document.getElementById('girdlefinish').value < 1) {
        alert("กรุณาเลือก GIRDLE FINISH");
        document.getElementById('girdlefinish').focus();
    }else if (document.getElementById('culet').value < 1) {
        alert("กรุณาเลือก CULET");
        document.getElementById('culet').focus();
    }else{
        var r = confirm("ยืนยันการบันทึก !!");
        if (r == true) {
            document.getElementById("savebtn").disabled = true;
            document.getElementById("form1").submit();
        }
        
    }
}
    

</script>
</body>
</html>