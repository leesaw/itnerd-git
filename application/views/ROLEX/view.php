<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('ROLEX/header_view'); ?>
</head>

<body class="hold-transition skin-black layout-top-nav">
<div class="wrapper">
	
<div class="content-wrapper">
    <div class="container">
	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
        <?php foreach($item_array as $loop) { ?>
        <h3 class="box-title" style="text-align:center"><?php echo $loop->it_refcode."<br><br><b>".$loop->it_model."</b>"; ?></h3>            
        <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <center><img class="img-responsive" src="<?php echo base_url()."picture/rolex/".$loop->it_refcode."/1.png"; ?>" alt="<?php echo $loop->it_refcode; ?>"></center>    
            </div>
            
        </div>  
        <br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <table class="table">
                <tbody>
                    <tr><th><i>Brand</i></th><td style="text-align:center"><?php echo $loop->br_name; ?></td></tr>
                    <tr><th><i>Reference</i></th><td style="text-align:center"><?php echo substr($loop->it_refcode, 1); ?></td></tr>
                    <tr><th><i>Collection</i></th><td style="text-align:center"><?php echo $loop->it_model; ?></td></tr>
                    <tr><th><i>Bracelet</i></th><td style="text-align:center"><?php echo $loop->it_remark; ?></td></tr>
                    <tr><th><i>Description</i></th><td style="text-align:center"><?php echo $loop->it_short_description; ?></td></tr>
                    <tr><th><i>Retail Price</i></th><td style="text-align:center"><?php echo number_format($loop->it_srp)." THB"; ?></td></tr>
                    <tr><th><i>Status</i></th><td style="text-align:center">
                    <?php 
                        $count = 0;
                        foreach($available_array as $loop2) {
                            $count++;
                        }
                        if ($count > 0) echo "<button class='btn btn-success'>มีสินค้า</button>";
                        else echo "<button class='btn btn-warning'>สั่งจองสินค้า</button>";
                    ?>
                    </td></tr>
                </tbody>
                </table>
            </div>
        </div>
                                  
        <?php } ?>      
					</div>
                </div>
            </div>
        </div>
        <!-- Projects Row -->
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