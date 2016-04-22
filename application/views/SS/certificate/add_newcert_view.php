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
                <div class="panel panel-primary">
                    
					<div class="panel-heading"><strong>Details</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form name="form1" id="form1" action="<?php echo site_url('ss_certificate/save'); ?>" method="post">
                                    <div class="form-group">
                                        <label>SHAPE *</label>
                                        <select class="form-control" name="shape" id="shape">
                                            <option value="0" <?php echo set_select('shape', '0', TRUE); ?>>-- เลือก --</option>
										<?php foreach($shape_array as $loop){
												echo "<option value='".$loop->id."' ".set_select('shape', $loop->id).">".$loop->value."</option>";
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
                                    <select class="form-control" name="girdleinscription" id="girdleinscription">
                                        <option value="0">-- เลือก --</option>
                                    <?php foreach($girdleinscription_array as $loop){
                                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                                     } ?>
                                    </select>
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
				</div>
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
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* TOTAL SIZE %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totaldepth" id="totaldepth" value="<?php echo set_value('totaldepth'); ?>">
				                    <p class="help-block"><?php echo form_error('totaldepth'); ?></p>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* CROWN HEIGHT %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totaldepth" id="totaldepth" value="<?php echo set_value('totaldepth'); ?>">
				                    <p class="help-block"><?php echo form_error('totaldepth'); ?></p>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* CROWN ANGLE &deg;</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totaldepth" id="totaldepth" value="<?php echo set_value('totaldepth'); ?>">
				                    <p class="help-block"><?php echo form_error('totaldepth'); ?></p>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* STAR LENGTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totaldepth" id="totaldepth" value="<?php echo set_value('totaldepth'); ?>">
				                    <p class="help-block"><?php echo form_error('totaldepth'); ?></p>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* PAVILION DEPTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totaldepth" id="totaldepth" value="<?php echo set_value('totaldepth'); ?>">
				                    <p class="help-block"><?php echo form_error('totaldepth'); ?></p>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* PAVILION ANGLE &deg;</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totaldepth" id="totaldepth" value="<?php echo set_value('totaldepth'); ?>">
				                    <p class="help-block"><?php echo form_error('totaldepth'); ?></p>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* LOWER HALF-LENGTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totaldepth" id="totaldepth" value="<?php echo set_value('totaldepth'); ?>">
				                    <p class="help-block"><?php echo form_error('totaldepth'); ?></p>
                                    </div>
                                </div>
							</div>
						</div>
                    </div>
                </div>
                </div>
                </div>
            </div>
            </div>
            
            <div class="row">
							<div class="col-md-6">
									<button type="button" name="savebtn" id="savebtn"  class="btn btn-primary" onclick="disablebutton()">  เพิ่มข้อมูลสินค้า  </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("item/manage"); ?>'"> ยกเลิก </button>
							</div>
						</div>
								
									
						</form>
            </div>
            </div>
            </div>                
    </section>
	</div>
</div>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<?php $this->load->view('js_footer'); ?>
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
    document.getElementById("savebtn").disabled = true;
    
    document.getElementById("form1").submit();
}
</script>
</body>
</html>