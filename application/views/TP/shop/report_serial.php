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
                                        <th width="120">Product No.</th>
                                        <th>Family</th>
                                        <th>Bracelet</th>
                                        <th>Description</th>
                                        <th>Retail Price</th>
                                        <th width="100">สถานะ</th>
                                        <th width="250">รายละเอียด</th>
                                        <!-- <th width="50">Caseback</th> -->
                                    </tr>
                                </thead>
								<tbody>
                                <?php foreach($temp_array as $loop) { ?>
                                    <tr>
                                    <td><?php echo $loop->itse_serial_number; ?></td>
                                    <td><?php echo $loop->br_name; ?></td>
                                    <td><a href="#" class="pop"><img src="<?php echo $loop->it_refcode; ?>" style="display: none;" /><?php echo $loop->it_refcode; ?></td>
                                    <td><?php echo $loop->it_model; ?></td>
                                    <td><?php echo $loop->it_remark; ?></td>
                                    <td><?php echo $loop->it_short_description; ?></td>
                                    <td><?php echo $loop->posroit_item_srp; ?></td>
                                    <td><?php if ($loop->posrot_status == 'N') echo "<a href='".site_url("sale/saleorder_rolex_pos_temp_last")."/".$loop->posroit_pos_rolex_temp_id."'><button class='btn btn-success btn-xs'>ขายแล้ว</button></a>"; else if ($loop->posrot_status == 'V') echo "<a href='".site_url("sale/saleorder_rolex_pos_temp_last")."/".$loop->posroit_pos_rolex_temp_id."'><button class='btn btn-danger btn-xs'>ยกเลิกการขายแล้ว (Void)</button></a>"; ?></td>
                                    <td><?php 
                                        echo "ราคา ".number_format($loop->posroit_netprice)." บาท";
                                        if ($loop->posroit_dc_baht > 0)
                                            echo "(ส่วนลด ".number_format($loop->posroit_dc_baht).")";
                                        $dateadd = explode("-", $loop->posrot_issuedate);
                                                                     
                                        echo "<br>วันที่ ".$dateadd[2]."/".$dateadd[1]."/".$dateadd[0];
                                    ?><br><a href="<?php echo site_url("sale/saleorder_rolex_pos_temp_last")."/".$loop->posroit_pos_rolex_temp_id; ?>" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียดการขาย"><span class="glyphicon glyphicon-search"></span>ดูรายละเอียดการขาย</a> </td>
                                    </tr>
                                <?php } ?>
                                    
                                <?php foreach($tax_array as $loop) { ?>
                                    <tr>
                                    <td><?php echo $loop->itse_serial_number; ?></td>
                                    <td><?php echo $loop->br_name; ?></td>
                                    <td><a href="#" class="pop"><img src="<?php echo $loop->it_refcode; ?>" style="display: none;" /><?php echo $loop->it_refcode; ?></td>
                                    <td><?php echo $loop->it_model; ?></td>
                                    <td><?php echo $loop->it_remark; ?></td>
                                    <td><?php echo $loop->it_short_description; ?></td>
                                    <td><?php echo $loop->posroi_item_srp; ?></td>
                                    <td><?php if ($loop->posro_status == 'N') echo "<button class='btn btn-success btn-xs'>ขายแล้ว</button>"; else if ($loop->posro_status == 'V') echo "<button class='btn btn-danger btn-xs'>ยกเลิกการขายแล้ว (Void)</button>"; ?></td>
                                    <td><?php 
                                        echo "ราคา ".number_format($loop->posroi_netprice)." บาท";
                                        if ($loop->posroi_dc_baht > 0)
                                            echo "(ส่วนลด ".number_format($loop->posroi_dc_baht).")";
                                        $dateadd = explode("-", $loop->posro_issuedate);
                                                                     
                                        echo "<br>วันที่ ".$dateadd[2]."/".$dateadd[1]."/".$dateadd[0];
                                    ?><br><a href="<?php echo site_url("sale/saleorder_rolex_pos_last")."/".$loop->posroi_pos_rolex_id; ?>" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-search"></span>ดูรายละเอียดการขาย</a> </td>
                                    </tr>
                                <?php } ?>
                                    
                                <?php foreach($udon_array as $loop) { ?>
                                    <tr>
                                    <td><?php echo $loop->itse_serial_number; ?></td>
                                    <td><?php echo $loop->br_name; ?></td>
                                    <td><a href="#" class="pop"><img src="<?php echo $loop->it_refcode; ?>" style="display: none;" /><?php echo $loop->it_refcode; ?></td>
                                    <td><?php echo $loop->it_model; ?></td>
                                    <td><?php echo $loop->it_remark; ?></td>
                                    <td><?php echo $loop->it_short_description; ?></td>
                                    <td><?php echo $loop->it_srp; ?></td>
                                    <td><?php echo "<button class='btn btn-primary btn-xs'>อยู่ที่ร้าน</button>"; ?></td>
                                    <td>Rolex - Central Udonthani</td>
                                    </tr>
                                <?php } ?>
                                    
                                <?php foreach($borrow_array as $loop) { ?>
                                    <tr>
                                    <td><?php echo $loop->itse_serial_number; ?></td>
                                    <td><?php echo $loop->br_name; ?></td>
                                    <td><a href="#" class="pop"><img src="<?php echo $loop->it_refcode; ?>" style="display: none;" /><?php echo $loop->it_refcode; ?></td>
                                    <td><?php echo $loop->it_model; ?></td>
                                    <td><?php echo $loop->it_remark; ?></td>
                                    <td><?php echo $loop->it_short_description; ?></td>
                                    <td><?php echo $loop->it_srp; ?></td>
                                    <td><?php echo "<button class='btn btn-danger btn-xs'>ถูกส่งออกจากร้าน</button>"; ?></td>
                                    <td><?php echo "ผู้รับของ : ".$loop->posrob_borrower_name; 
                                        $dateadd = explode("-", $loop->posrob_issuedate);
                                                                     
                                        echo "<br>วันที่ ".$dateadd[2]."/".$dateadd[1]."/".$dateadd[0];    
                                        
                                    ?><br><a href="<?php echo site_url("pos/stock_rolex_pos_borrow_last")."/".$loop->posrobi_pos_rolex_borrow_id; ?>" class="btn btn-danger btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-search"></span>ดูรายละเอียดการส่งของ</a></td>
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
            <a href="<?php echo site_url("pos/formSerial_detail_shop"); ?>" class="btn btn-primary">ค้นหา</a>    
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