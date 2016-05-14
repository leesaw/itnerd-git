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
            ผลการค้นหา Serial Number : <?php echo $serial; ?>
        </h1>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading">
                        
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th>Serial No.</th>
                                        <th>Brand</th>
                                        <th width="120">Ref. Number</th>
                                        <th>Family</th>
                                        <th>Description</th>
                                        <th>SRP</th>
                                        <th>Warehouse</th>
                                        <th width="100">สถานะ</th>
                                    </tr>
                                </thead>
								<tbody>
                                <?php foreach($stock_array as $loop) { ?>
                                    <tr>
                                    <td><?php echo $loop->itse_serial_number; ?></td>
                                    <td><?php echo $loop->br_name; ?></td>
                                    <td><?php echo $loop->it_refcode; ?></td>
                                    <td><?php echo $loop->it_model; ?></td>
                                    <td><?php echo $loop->it_short_description; ?></td>
                                    <td><?php echo $loop->it_srp; ?></td>
                                    <td><?php echo $loop->wh_code."-".$loop->wh_name; ?></td>
                                    <td><?php 
                                        if ($loop->itse_enable == 0)
                                            echo "<a href='#'><button class='btn btn-danger btn-xs'>ขายแล้ว</button></a>"; 
                                        else 
                                            echo "<a href='#'><button class='btn btn-primary btn-xs'>อยู่ในคลังสินค้า</button></a>"; 
                                        ?>
                                        
                                    </td>
                                    </tr>
                                <?php } ?>
								</tbody>
							</table>
                        
					</div>
                    
				</div>
			</div>	
            
		</div>
        <div class="row">
            <div class="col-xs-12">
            <a href="<?php echo site_url("warehouse/getBalance"); ?>" class="btn btn-primary">ค้นหา</a>    
            </div>
        </div>
                        
                        
                        
                        
					</div>
                </div>
            </div>
        </div>
        </section>
		</div>
    
    
	</div>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" data-dismiss="modal">
    <div class="modal-content"  >              
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div> 
    </div>
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
    
});
</script>
</body>
</html>