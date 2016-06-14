<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/dropzone/dropzone.min.css">
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
                  <h3 class="box-title">กรุณาอัพโหลดรูปภาพสำหรับ Certificate นี้</h3>
                </div>
                <div class="box-body">
        <?php if ($this->session->flashdata('showresult') == 'true') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
        ?>
		<div class="row">
            <div class="col-xs-6">
                <div class="row"><div class="col-xs-12">
                <div class="panel panel-success">
                    <?php foreach($cer_array as $loop) { 
                        $symbol_check = explode("#",$loop->cer_symbol);
                    ?>
					<div class="panel-heading"><strong>Details</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CERTIFICATE NUMBER *</label>
                                    <input type="text" class="form-control" name="number" id="number" value="<?php echo $loop->cer_number; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NATURAL DIAMOND *</label>
                                    <input type="text" class="form-control" name="natural" id="natural" value="<?php echo $loop->naturaldiamond; ?>" readonly>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SHAPE *</label>
                                    <input type="text" class="form-control" name="shape" id="shape" value="<?php echo $loop->shape; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-6">
									<div class="form-group">
                                        <label>CUTTING STYLE *</label>
                                        <input type="text" class="form-control" name="cutting" id="cutting" value="<?php echo $loop->cuttingstyle; ?>" readonly>
                                    </div>
							</div>
						</div>
						<div class="row">
                            <div class="col-md-6">
									<div class="form-group">
                                            <label>MEASUREMENT *</label>
                                            <input type="text" class="form-control" name="measurement" id="measurement" value="<?php echo $loop->cer_measurement; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-6">
									<div class="form-group">
                                            <label>CARAT WEIGHT *</label>
                                            <input type="text" class="form-control" name="carat" id="carat" value="<?php echo $loop->cer_carat; ?>" readonly>
                                    </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>COLOR GRADE *</label>
                                    <input type="text" class="form-control" name="color" id="color" value="<?php echo $loop->color; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-6">
									<div class="form-group">
                                        <label>CLARITY GRADE *</label>
                                        <input type="text" class="form-control" name="clarity" id="clarity" value="<?php echo $loop->clarity; ?>" readonly>
                                    </div>
							</div>
						</div>
						
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>GIRDLE INSCRIPTION *</label>
                                    <input type="text" class="form-control" name="girdleinscription" id="girdleinscription" value="<?php echo $loop->cer_girdleinscription; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>FLUORESCENCE *</label>
                                    <input type="text" class="form-control" name="fluorescence" id="fluorescence" value="<?php echo $loop->fluorescence; ?>" readonly>
                                </div>
							</div>
						</div>
					</div>
				</div></div></div>
                <div class="row">
                <div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading"><strong>COMMENT</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>COMMENT *</label>
                                    <input type="text" class="form-control" name="comment" id="comment" value="<?php echo $loop->cer_comment; ?>" readonly>
                                </div>
							</div>
						</div>
                    </div>
                </div>
                </div></div>
                <div class="row">
                <div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading"><strong>SOFTWARE RESULT</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div id="my-dropzone" class="dropzone">
                                <div class="dz-message">
                                    <h3>Drop files here</h3> or <strong>click</strong> to upload<br>228px x 85px
                                </div>
                            </div>
						</div>
                    </div>
                </div>
                </div></div>
                <div class="row">
                <div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading"><strong>PROPORTIONS</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div id="my-dropzone2" class="dropzone">
                                <div class="dz-message">
                                    <h3>Drop files here</h3> or <strong>click</strong> to upload<br>300px x 250px
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
                <div class="panel panel-success">
					<div class="panel-heading"><strong>CUT</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>PROPORTION *</label>
                                    <input type="text" class="form-control" name="proportion" id="proportion" value="<?php echo $loop->proportion; ?>" readonly>
                                </div>
							</div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>SYMMETRY *</label>
                                    <input type="text" class="form-control" name="symmetry" id="symmetry" value="<?php echo $loop->symmetry; ?>" readonly>
                                </div>
							</div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>POLISH *</label>
                                    <input type="text" class="form-control" name="polish" id="polish" value="<?php echo $loop->polish; ?>" readonly>
                                </div>
							</div>
						</div>
                    </div>
                </div>
                </div></div>
                <div class="row">
                <div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading"><strong>TECHNICAL INFORMATION</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* TOTAL DEPTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="totaldepth" id="totaldepth" value="<?php echo $loop->cer_totaldepth; ?>" readonly>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* TABLE SIZE %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tablesize" id="tablesize" value="<?php echo $loop->cer_tablesize; ?>" readonly>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* CROWN HEIGHT %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="crownheight" id="crownheight" value="<?php echo $loop->cer_crownheight; ?>" readonly>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* CROWN ANGLE &deg;</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="crownangle" id="crownangle" value="<?php echo $loop->cer_crownangle; ?>" readonly>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* STAR LENGTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="starlength" id="starlength" value="<?php echo $loop->cer_starlength; ?>" readonly>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* PAVILION DEPTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="paviliondepth" id="paviliondepth" value="<?php echo $loop->cer_paviliondepth; ?>" readonly>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* PAVILION ANGLE &deg;</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="pavilionangle" id="pavilionangle" value="<?php echo $loop->cer_pavilionangle; ?>" readonly>
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-6">
                                <div class="form-group row">
                                    <label for="inputKey" class="col-lg-8 control-label" style="text-align:right">* LOWER HALF-LENGTH %</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="lowerhalflength" id="lowerhalflength" value="<?php echo $loop->cer_lowerhalflength; ?>" readonly>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <label>GIRDLE THICKNESS *</label>
                                <input type="text" class="form-control" name="girdlethickness" id="girdlethickness" value="<?php echo $loop->cer_girdlethickness; ?>" readonly>
							</div>
                            <div class="col-xs-6">
                                <label>GIRDLE FINISH *</label>
                                <input type="text" class="form-control" name="girdlefinish" id="girdlefinish" value="<?php echo $loop->girdlefinish; ?>" readonly>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-6">
                                <label>CULET *</label>
                                <input type="text" class="form-control" name="culet" id="culet" value="<?php echo $loop->culet; ?>" readonly>
							</div>
						</div>
                    </div>
                </div>
                </div>
                </div>
                <div class="row">
                <div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading"><strong>CLARITY CHARACTERISTICS</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div id="my-dropzone3" class="dropzone">
                                <div class="dz-message">
                                    <h3>Drop files here</h3> or <strong>click</strong> to upload<br>300px x 250px
                                </div>
                            </div>
						</div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class='row'>
                                    <div class="col-xs-12">
                                        <label>KEY TO SYMBOLS *</label>
                                    </div>
                                </div>
                                <div class='row'>
                                <?php $i_row = 0; foreach($symbol_array as $loop_symbol) { 
                                 $i_row++;    
                                ?>
                                
                                <div class="col-xs-3"><input type="checkbox" name="symbol" value="<?php echo $loop_symbol->id; ?>" 
                                <?php  
                                    for($i=0; $i<count($symbol_check); $i++) {
                                        if ($symbol_check[$i] == $loop_symbol->id)
                                            echo "checked";
                                    }                            
                                                             
                                ?> > <img src="<?php echo base_url()."/picture/ss/".$loop_symbol->picture; ?>" width="20"> <?php echo $loop_symbol->value; ?></div>
                                <?php if ($i_row%4 == 0) echo "</div><div class='row'>"; } ?>
                                </div>
                                <br>
                                <div class='row'>
                                    <div class="col-xs-12">
                                <button name="savesymbol" id="savesymbol" onclick="savesymbol()" class="btn btn-primary btn-sm">บันทึก KEY TO SYMBOLS</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div></div>
            </div>
            </div>
                    <?php } ?>
            <hr>
            <div class="row">
							<div class="col-md-6">
									<a href="<?php echo site_url("ss_certificate/view_certificate_pdf_full/".$cer_id); ?>" target="_blank"><button type="button" name="savebtn" id="savebtn"  class="btn btn-success"><i class='fa fa-diamond'></i> Full Certificate</button></a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo site_url("ss_certificate/view_certificate_pdf_small/".$cer_id); ?>" target="_blank"><button type="button" name="savebtn" id="savebtn"  class="btn btn-info"><i class='fa fa-diamond'></i> Small Certificate </button></a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo site_url("ss_certificate/view_certificate_pdf_form/".$cer_id); ?>" target="_blank"><button type="button" name="formbtn" id="formbtn"  class="btn bg-purple"><i class='fa fa-file-o'></i> Certificate Form </button></a>
                                    &nbsp;&nbsp;&nbsp;
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("ss_certificate/view_all_certificate"); ?>'"> Cancel </button>
							</div>
						</div>

            </div>
            </div>
            </div>                
    </section>
	</div>
</div>
<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>plugins/dropzone/dropzone.min.js"></script>
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
    
Dropzone.autoDiscover = false;
var myDropzone = new Dropzone("#my-dropzone", {
    url: "<?php echo site_url("ss_certificate/upload_picture_result/".$cer_id); ?>",
    acceptedFiles: "image/*",
    addRemoveLinks: true,
    removedfile: function(file) {
        var name = file.name;
        $.ajax({
            type: "post",
            url: "<?php echo site_url("ss_certificate/remove_picture_result/".$cer_id); ?>",
            data: { file: name },
            dataType: 'html'
        });

        // remove the thumbnail
        var previewElement;
        return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
    },
    init: function() {
        var me = this;
        $.get("<?php echo site_url("ss_certificate/list_picture_result/".$cer_id); ?>", function(data) {
            // if any files already in server show all here
            if (data.length > 0) {
                $.each(data, function(key, value) {
                    var mockFile = value;
                    me.createThumbnailFromUrl(mockFile,"<?php echo base_url(); ?>"+value.path);
                    me.emit("addedfile", mockFile);
                    //me.emit("thumbnail", mockFile, "<?php echo base_url(); ?>"+value.path);
                    me.emit("complete", mockFile);
                });
            }
        });
    }
});

var myDropzone2 = new Dropzone("#my-dropzone2", {
    url: "<?php echo site_url("ss_certificate/upload_picture_proportion/".$cer_id) ?>",
    acceptedFiles: "image/*",
    addRemoveLinks: true,
    removedfile: function(file) {
        var name = file.name;

        $.ajax({
            type: "post",
            url: "<?php echo site_url("ss_certificate/remove_picture_proportion/".$cer_id) ?>",
            data: { file: name },
            dataType: 'html'
        });

        // remove the thumbnail
        var previewElement;
        return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
    },
    init: function() {
        var me = this;
        $.get("<?php echo site_url("ss_certificate/list_picture_proportion/".$cer_id) ?>", function(data) {
            // if any files already in server show all here
            if (data.length > 0) {
                $.each(data, function(key, value) {
                    var mockFile = value;
                    me.createThumbnailFromUrl(mockFile,"<?php echo base_url(); ?>"+value.path);
                    me.emit("addedfile", mockFile);
                    //me.emit("thumbnail", mockFile, "<?php echo base_url(); ?>"+value.path);
                    me.emit("complete", mockFile);
                });
            }
        });
    }
});
    
var myDropzone3 = new Dropzone("#my-dropzone3", {
    url: "<?php echo site_url("ss_certificate/upload_picture_clarity/".$cer_id) ?>",
    acceptedFiles: "image/*",
    addRemoveLinks: true,
    removedfile: function(file) {
        var name = file.name;

        $.ajax({
            type: "post",
            url: "<?php echo site_url("ss_certificate/remove_picture_clarity/".$cer_id) ?>",
            data: { file: name },
            dataType: 'html'
        });

        // remove the thumbnail
        var previewElement;
        return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
    },
    init: function() {
        var me = this;
        $.get("<?php echo site_url("ss_certificate/list_picture_clarity/".$cer_id) ?>", function(data) {
            // if any files already in server show all here
            if (data.length > 0) {
                $.each(data, function(key, value) {
                    var mockFile = value;
                    me.createThumbnailFromUrl(mockFile,"<?php echo base_url(); ?>"+value.path);
                    me.emit("addedfile", mockFile);
                    //me.emit("thumbnail", mockFile, "<?php echo base_url(); ?>"+value.path);
                    me.emit("complete", mockFile);
                });
            }
        });
    }
});
    
function savesymbol() {
    var symbol = document.getElementsByName('symbol');
    var cer_id = '<?php echo $cer_id; ?>';
    document.getElementById("savesymbol").disabled = true;
    var index = 0;
    var symbol_array = new Array();
    for(var i=0; i<symbol.length; i++){
        if ( symbol[i].checked ) {
            symbol_array[index] = symbol[i].value;
            index++;
        }
    }
    
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("ss_certificate/save_symbol"); ?>" ,
        data : {symbol_array: symbol_array, cer_id: cer_id} ,
        dataType: 'json',
        success : function(data) {
            alert("บันทึก Key to Symbol เรียบร้อยแล้ว");
            location.reload();
        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
            document.getElementById("savesymbol").disabled = false;
        }
    });
}

</script>
</body>
</html>