<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-purple">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Search <small>NGG Timepieces</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url("jes/watch"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Search</li>
        </ol>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                        
        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("jes/show_refcode"); ?>" method="post">
            <div class="col-md-6">
                <label>Ref. Code หรือ Description ที่ต้องการค้นหา</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="refcode" id="refcode">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success"><i class='fa fa-search'></i></button>
                    </div>
                </div>
            </div>
            </form>
        </div>       
                        
                        
                        
                        
					</div>
                </div>
            </div>
        </div>
        </section>
          
          
          
</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script type="text/javascript">
    
$(document).ready(function()
{    
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
});
</script>
</body>
</html>