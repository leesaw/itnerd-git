<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
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
			<form action="<?php echo site_url("ss_certificate/result_search_certificate"); ?>" method="post">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Certificate Number ที่ต้องการค้นหา</label>
                    <input type="text" class="form-control" name="cer_number" id="cer_number">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>CARAT WEIGHT (ตัวอย่าง : 0.56-1.20)</label>
                    <input type="text" class="form-control" name="carat" id="carat" value="">
                </div>
            </div>
		</div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>NATURAL DIAMOND </label>
                    <select class="form-control" name="natural" id="natural">
                        <option value="0">-- ทั้งหมด --</option>
                    <?php foreach($naturaldiamond_array as $loop){
                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>SHAPE</label>
                    <select class="form-control" name="shape" id="shape">
                        <option value="0">-- ทั้งหมด --</option>
                        <?php foreach($shape_array as $loop){
                                echo "<option value='".$loop->id."'>".$loop->value."</option>";
                         } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                    <div class="form-group">
                        <label>CUTTING STYLE</label>
                        <select class="form-control" name="cuttingstyle" id="cuttingstyle">
                            <option value="0">-- ทั้งหมด --</option>
                        <?php foreach($cuttingstyle_array as $loop){
                                echo "<option value='".$loop->id."'>".$loop->value."</option>";
                         } ?>
                        </select>
                    </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>COLOR GRADE</label>
                    <select class="form-control" name="color" id="color">
                        <option value="0">-- ทั้งหมด --</option>
                    <?php foreach($color_array as $loop){
                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>CLARITY GRADE</label>
                    <select class="form-control" name="clarity" id="clarity">
                        <option value="0">-- ทั้งหมด --</option>
                    <?php foreach($clarity_array as $loop){
                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>FLUORESCENCE</label>
                    <select class="form-control" name="fluorescence" id="fluorescence">
                        <option value="0">-- ทั้งหมด --</option>
                    <?php foreach($fluorescence_array as $loop){
                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>PROPORTION</label>
                    <select class="form-control" name="proportion" id="proportion">
                        <option value="0">-- ทั้งหมด --</option>
                    <?php foreach($proportion_array as $loop){
                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>SYMMETRY</label>
                    <select class="form-control" name="symmetry" id="symmetry">
                        <option value="0">-- ทั้งหมด --</option>
                    <?php foreach($symmetry_array as $loop){
                            echo "<option value='".$loop->id."'>".$loop->value."</option>";
                     } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>POLISH</label>
                    <select class="form-control" name="polish" id="polish">
                        <option value="0">-- ทั้งหมด --</option>
                    <?php foreach($polish_array as $loop){
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
        </section>
		</div>
    
    
	</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    var oTable = $('#tablecert').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("ss_certificate/ajaxAllCertificate"); ?>',
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