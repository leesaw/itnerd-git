<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
</head>

<body>
<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	
	<div id="page-wrapper">
		<div class="row">
            <div class="col-lg-8">
                <h3 class="page-header">แก้ไข ใบส่งสินค้าชั่วคราว</h3>
            </div>
        </div>
		
		<div class="row">
            <div class="col-lg-10">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง</strong></div>
					<?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการแก้ไขข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ไม่มี Barcode นี้ในระบบ</div>';
					
					?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <?php 
									echo form_open('managebill/previewCashBill_edit'); ?>
                                
                                <?php if(is_array($bill_array)) {
									foreach($bill_array as $loop){ 
								?>
                                <input type="hidden" name="editid" value="<?php echo $loop->bid; ?>">
                                    <div class="form-group">
                                    	<label>สาขาที่ออก *</label>
                                        <input type="text" class="form-control" name="branch" id="branch" value="<?php echo $loop->branchname; ?>" readonly>
                                    </div>

							</div>
							<div class="col-md-4">
                                    <div class="form-group">
                                    	<label>เลขที่ใบส่งสินค้าชั่วคราว *</label>
                                        <input type="text" class="form-control" name="billid" id="billid" value="<?php echo $loop->billID; ?>" readonly>
                                    </div>

							</div>
						</div>
						<div class="row">
                            <div class="col-md-4">
                                    <div class="form-group">
                                    	<label>ชื่อลูกค้า *</label>
										<input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $loop->customerName; ?>" readonly>
                                    </div>

							</div>
						</div>
						<div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                    	<label>ที่อยู่ลูกค้า *</label>
										<textarea class="form-control" name="cusaddress" id="cusaddress" rows="3" readonly><?php echo $loop->customerAddress; ?></textarea>
                                    </div>

							</div>
						</div>
						<div class="row">
                            <div class="col-md-3">
                                    <div class="form-group">
                                    	<label>ราคาสินค้า *</label>
                                    <?php 
                                        switch($loop->_saleprice) {   
                                            case 1: $saleprice= "ไม่มี VAT"; break;
                                            case 2: $saleprice= "บวก VAT"; break;
                                        }
                                    ?>
                                        <input type="text" class="form-control" name="saleprice" id="saleprice" value="<?php echo $saleprice; ?>" readonly>
                                    </div>

							</div>
							<div class="col-md-3">
                                    <div class="form-group">
                                    	<label>ส่วนลด (บาท) *</label>
                                        <input type="text" class="form-control" name="discount" id="discount" value="<?php echo $loop->bdiscount; ?>" readonly>
                                    </div>

							</div>
							<div class="col-md-3">
                                    <div class="form-group">
                                    	<label>ส่วนลด (%) *</label>
                                        <input type="text" class="form-control" name="discount2" id="discount2" value="<?php echo $loop->bdiscount2; ?>" readonly>
                                    </div>

							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
									<div class="form-group">
                                            <label>ขนส่งโดย </label>
                                            <input type="text" class="form-control" name="transport" id="transport" value="<?php echo $loop->transport; ?>" readonly>
                                    </div>
							</div>
						</div>
                    <?php } } ?>
		<div class="row">
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
										<th>ลำดับ</th>
                                        <th>รหัสสินค้า/รายละเอียด</th>
										<th>จำนวน</th>
										<th style="text-align: center;width: 20%">ราคาต่อหน่วย</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php $numIndex = 0; 
									if(isset($billproduct_array)) { foreach($billproduct_array as $loop) { 
										$numIndex++;
									?>
									<tr>
									<td><?php echo $numIndex; ?></td>
									<td><a id="fancyboxview" href="<?php echo site_url("manageproduct/viewproduct_iframe/".$loop->pid);  ?>"><?php echo $loop->productname; ?></a></td>
									<td><?php echo $loop->amount." ".$loop->unit; ?></td>
									<td>
									<input type="hidden" name="barcode[]" value="<?php echo $loop->_barcode; ?>">
									<input type="hidden" name="lowestprice[]" id="lowestprice<?php echo $numIndex; ?>" value="<?php echo $loop->lowestPrice; ?>">
									<input type="hidden" name="pricevat[]" id="pricevat<?php echo $numIndex; ?>" value="<?php echo $loop->priceVAT; ?>">
									<input type="hidden" name="pricenovat[]" id="pricenovat<?php echo $numIndex; ?>" value="<?php echo $loop->priceNoVAT; ?>">
									<input type="text" class="form-control" name="price[]" onchange="checklowest(<?php echo $numIndex; ?>);" id="price<?php echo $numIndex; ?>" value="<?php echo $loop->pricePerUnit; ?>" readonly></td>
                                    <td>
                                    <button type="button" class="btnAmount btn btn-success btn-xs" onclick="edit_amount(<?php echo $loop->_id; ?>)" data-title="Edit" data-toggle="modal" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไขจำนวน"><span class="glyphicon glyphicon-plus"></span></button>
									<button type="button" class="btnDelete btn btn-danger btn-xs" onclick="del_confirm(<?php echo $loop->_id; ?>,<?php echo $id; ?>)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-remove"></span></button>
                                        </td>
									</tr>
								<?php } }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>
		
						<div class="row">
							<div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-thumbs-up"></span>  ยืนยันรายการสินค้าทั้งหมด  </button></a></form>
									<button type="button" id="cancel" class="btn btn-warning btn-md" onClick="window.location.href='<?php echo site_url("managebill/viewBillByBranch/".$id); ?>'">  ยกเลิก  </button></a>
							</div>
						</div>
								
						<?php echo form_close(); ?>


					</div>
				</div>
			</div>	
		</div>

<br><br><br><br><br><br>
<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
		
		$('#fancyboxview').fancybox({ 
		'width': '70%',
		'height': '70%', 
		'autoScale':false,
		'transitionIn':'none', 
		'transitionOut':'none', 
		'type':'iframe'}); 
		
    });
</script>
<script type="text/javascript">

function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}

function get_datepicker(id)
{

	$(id).datepicker({ language:'th-th',format:'dd/mm/yyyy'
		    });

}

function checklowest(id)
{
	var _lowestprice = parseFloat(document.getElementById('lowestprice'+id).value);
	var _price = parseFloat(document.getElementById('price'+id).value);
    //alert(_lowestprice+"/"+_price);
	if (_price < _lowestprice) {
		alert("ราคาที่กำหนด ต่ำกว่าราคาต่ำสุด");
		/*window.setTimeout(function () { 
			document.getElementById('price'+id).focus(); 
		}, 0); */
	}
}

function del_confirm(val1,val2) {
	bootbox.confirm("ต้องการลบข้อมูลที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				//var currentForm = this;
            	if (result) {
				
					window.location.replace("<?php echo site_url('managebill/deleteproduct_bill'); ?>/"+val1+"/"+val2);
				}

		});
}
function edit_amount(id) {
	bootbox.prompt("กรุณาป้อนจำนวนสินค้า", function(result) {       
		if (result != null && result>0) {                                                                        
			var amount = result;
			$.ajax({
					'url' : '<?php echo site_url('managebill/editproduct_amount_bill'); ?>',
					'type':'post',
					'data': {id:id, 
							amount:amount},
					'error' : function(data){ 
						alert('ไม่สามารถแก้ไขจำนวนสินค้าได้');
                    },
					'success' : function(data){
						window.location.reload();
					}
				}); 
						
		}else if(result != null && result<=0) {
			alert('ไม่สามารถแก้ไขจำนวนสินค้าได้');
		}
	});
}

function add_product(id) {
	bootbox.prompt("กรุณาใส่ Barcode", function(result) {       
		if (result != null) {                                                                        
			var barcode = result;
			$.ajax({
					'url' : '<?php echo site_url('managebill/addproduct_editbill'); ?>',
					'type':'post',
					'data': {id:id, 
							barcode:barcode},
					'error' : function(data){ 
						alert('ไม่สามารถเพิ่มสินค้าได้');
                    },
					'success' : function(data){
						window.location.reload();
					}
				}); 
						
		}else if(result != null) {
			alert('ไม่สามารถเพิ่มสินค้าได้');
		}
	});
}

</script>
</body>
</html>