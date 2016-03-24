<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('ROLEX/header_view'); ?>
</head>

<body class="hold-transition skin-black layout-top-nav">
<div class="wrapper">
	<?php $this->load->view('ROLEX/menu'); ?>
	
<div class="content-wrapper">
    <div class="container">
	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                        
        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("rolex/filter_item"); ?>" method="post">
            <div class="col-md-4 col-sm-4">
                Product Code/Serial Number
                <input type="text" class="form-control" name="refcode" id="refcode" value="<?php echo $refcode; ?>">
            </div>
            <div class="col-sm-3 col-md-3">
                Family
                    <select class="form-control" name="model" id="model">
                        <option value='0' <?php if ($model == "0") echo " selected"; ?>>เลือกทั้งหมด</option>
                    <?php 	if(is_array($collection_array)) {
                                foreach($collection_array as $loop){
                                    echo "<option value='".$loop->it_model."'";
                                    if ($loop->it_model == $model) echo " selected";
                                    echo ">".$loop->it_model."</option>";
                            } } ?>
                    </select>
            </div>
            <div class="col-sm-3 col-md-3">
                Bracelet
                    <select class="form-control" name="remark" id="remark">
                        <option value='0' <?php if ($bracelet == "0") echo " selected"; ?>>เลือกทั้งหมด</option>
                        <?php 	if(is_array($bracelet_array)) {
								    foreach($bracelet_array as $loop){
								        echo "<option value='".$loop->it_remark."'";
                                        if ($loop->it_remark == $bracelet) echo " selected";
                                        echo ">".$loop->it_remark."</option>";
								} } ?>
                    </select>
            </div>
            <div class="col-sm-2 col-md-2">
                <br>
                <button type="submit" name="action" value="0" class="btn btn-success btn-block"><i class="fa fa-search"></i> Filter</button>
            </div>

        </div>              
                        
        </form>               
                        
					</div>
                </div>
            </div>
        </div>
        <!-- Projects Row -->
        
        <?php 
        $count = 1;
        foreach($item_array as $loop) { ?>
           <?php if ($count % 3 == 1) { echo '<div class="row" style="text-align:center">'; } ?>
	       <div class="col-md-4 col-sm-4 portfolio-item">
                <a href="<?php echo site_url("rolex/view")."/".$loop->it_id; ?>" target="blank">
                    <img class="img-responsive" src="<?php echo base_url()."picture/rolex/".$loop->it_refcode."/1.png"; ?>" alt="<?php echo $loop->it_refcode; ?>">
                </a>
                <a href="<?php echo site_url("rolex/view")."/".$loop->it_id; ?>"><span class="text-black"><?php echo $loop->it_refcode."<br><b>".$loop->it_model."</b>"; ?></span></a>
            </div>
        <?php if ($count % 3 == 0) { echo "</div><br><br>"; } ?>
        <?php $count++; /* if ($count>15) break; */ } ?>
        <!-- /.row -->
    </section>
    </div>
</div>

<?php $this->load->view('js_footer'); ?>
<script type="text/javascript">
$(document).ready(function()
{

});

</script>
</body>
</html>