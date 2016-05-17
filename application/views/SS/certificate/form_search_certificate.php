<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/bootstrap-slider/slider.css">
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Advanced Search
        </h1>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            
        <div class="row">
			<form action="<?php echo site_url("ss_certificate/result_search_certificate"); ?>" method="post" class="form-inline">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Certificate Number ที่ต้องการค้นหา : </label>
                    <input type="text" class="form-control" name="cer_number" id="cer_number" value="<?php if ($number !="NULL") echo $number; ?>">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>CARAT WEIGHT : </label>
                    <input type="text" class="form-control" name="carat1" id="carat1" value="<?php echo $carat1; ?>" style="width:60px"> - 
                    <input type="text" class="form-control" name="carat2" id="carat2" value="<?php echo $carat2; ?>" style="width:60px">
                </div>
            </div>
		</div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>SHAPE</label>
                    <select class="form-control" name="shape" id="shape">
                        <option value="0"<?php if ($shape==0) echo " selected"; ?>>-- ทั้งหมด --</option>
                        <?php foreach($shape_array as $loop){
                                echo "<option value='".$loop->id."'";
                                if ($loop->id==$shape) echo " selected"; 
                                echo ">".$loop->value."</option>";
                         } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                    <div class="form-group">
                        <label>CUTTING STYLE</label>
                        <select class="form-control" name="cuttingstyle" id="cuttingstyle">
                            <option value="0"<?php if ($cuttingstyle==0) echo " selected"; ?>>-- ทั้งหมด --</option>
                        <?php foreach($cuttingstyle_array as $loop){
                                echo "<option value='".$loop->id."'";
                                if ($loop->id==$cuttingstyle) echo " selected"; 
                                echo ">".$loop->value."</option>";
                         } ?>
                        </select>
                    </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>COLOR GRADE</label>
                    <select class="form-control" name="color" id="color">
                        <option value="0"<?php if ($color==0) echo " selected"; ?>>-- ทั้งหมด --</option>
                    <?php foreach($color_array as $loop){
                            echo "<option value='".$loop->id."'";
                            if ($loop->id==$color) echo " selected"; 
                            echo ">".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>CLARITY GRADE</label>
                    <select class="form-control" name="clarity" id="clarity">
                        <option value="0"<?php if ($clarity==0) echo " selected"; ?>>-- ทั้งหมด --</option>
                    <?php foreach($clarity_array as $loop){
                            echo "<option value='".$loop->id."'";
                            if ($loop->id==$clarity) echo " selected"; 
                            echo ">".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>FLUORESCENCE</label>
                    <select class="form-control" name="fluorescence" id="fluorescence">
                        <option value="0"<?php if ($fluorescence==0) echo " selected"; ?>>-- ทั้งหมด --</option>
                    <?php foreach($fluorescence_array as $loop){
                            echo "<option value='".$loop->id."'";
                            if ($loop->id==$fluorescence) echo " selected"; 
                            echo ">".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-2">
                <div class="form-group">
                    <label>PROPORTION</label>
                    <select class="form-control" name="proportion" id="proportion">
                        <option value="0"<?php if ($proportion==0) echo " selected"; ?>>-- ทั้งหมด --</option>
                    <?php foreach($proportion_array as $loop){
                            echo "<option value='".$loop->id."'";
                            if ($loop->id==$proportion) echo " selected"; 
                            echo ">".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>SYMMETRY</label>
                    <select class="form-control" name="symmetry" id="symmetry">
                        <option value="0"<?php if ($symmetry==0) echo " selected"; ?>>-- ทั้งหมด --</option>
                    <?php foreach($symmetry_array as $loop){
                            echo "<option value='".$loop->id."'";
                            if ($loop->id==$symmetry) echo " selected"; 
                            echo ">".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>POLISH</label>
                    <select class="form-control" name="polish" id="polish">
                        <option value="0"<?php if ($polish==0) echo " selected"; ?>>-- ทั้งหมด --</option>
                    <?php foreach($polish_array as $loop){
                            echo "<option value='".$loop->id."'";
                            if ($loop->id==$polish) echo " selected"; 
                            echo ">".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
        </div>                
        <hr>
            <div class="row"><div class="col-md-3"><button type="submit" name="action" value="0" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา</button></div></div> 
            </form>       
                        
					</div>
                </div>
            </div>
        </div>
        </section>
		</div>
    
    
	</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo base_url(); ?>plugins/bootstrap-slider/bootstrap-slider.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    $('.slider').slider();
    
    var oTable = $('#tablecert').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("ss_certificate/ajaxView_search_certificate")."/".$number."/".$carat1."/".$carat2."/"; ?>',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success":fnCallback

            });
        }
    });
    
    $('#fancyboxall').fancybox({ 
    'width': '30%',
    'height': '80%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
    

});
</script>
</body>
</html>