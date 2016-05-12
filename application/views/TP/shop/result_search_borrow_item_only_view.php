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
            รายการสินค้ายืม
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
                        <h3>ผู้ยืม : <?php echo $borrower; ?></h3>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th>วันที่ส่งของ</th>
                                        <th>Serial No.</th>
                                        <th>Brand</th>
                                        <th width="120">Product No.</th>
                                        <th>Family</th>
                                        <th>Bracelet</th>
                                        <th>Description</th>
                                        <th>Retail Price</th>
                                        <th width="100">รายละเอียด</th>
                                    </tr>
                                </thead>
								<tbody>
                                                                    
                                <?php foreach($borrow_array as $loop) { ?>
                                    <tr>
                                    <td><?php echo $loop->posrob_issuedate; ?></td>
                                    <td><?php echo $loop->itse_serial_number; ?></td>
                                    <td><?php echo $loop->br_name; ?></td>
                                    <td><a href="#" class="pop"><img src="<?php echo $loop->it_refcode; ?>" style="display: none;" /><?php echo $loop->it_refcode; ?></a></td>
                                    <td><?php echo $loop->it_model; ?></td>
                                    <td><?php echo $loop->it_remark; ?></td>
                                    <td><?php echo $loop->it_short_description; ?></td>
                                    <td><?php echo $loop->it_srp; ?></td>
                                    <td>
                                    <?php if ($loop->posrobi_enable == 1) { ?>    
                                        <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-user"></i> อยู่ที่ผู้ยืม</a>
                                    <?php }else if ($loop->posrobi_enable == 0) { ?>
                                        <a href="#"  class="btn btn-success btn-xs"><i class="fa fa-check-square-o"></i> ขายแล้ว</a>
                                    <?php } ?>
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
            <a href="<?php echo site_url("pos/form_list_borrow_item"); ?>" class="btn btn-primary">ค้นหา</a>    
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
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <center><h3 id="showrefcode"></h3>
        <img src="" class="imagepreview" style="width:80%; height: 60%;" >
        </center>
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
    
    var oTable = $('#tablebarcode').DataTable({
       
    });
    
    $('#tablebarcode').on('click', '.pop', function(e){
        var imgsrc = '<?php echo base_url(); ?>'+'picture/rolex/'+$(this).find('img').attr('src')+"/1.png";
        
        //alert($(this).find('img').attr('src'));
        $('.imagepreview').attr('src', imgsrc);
        document.getElementById("showrefcode").innerHTML = $(this).find('img').attr('src');
        $('#imagemodal').modal('show');   
    });		
});
</script>
</body>
</html>