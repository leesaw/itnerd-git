<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('NGG/gold/header_view'); ?>
</head>

<body class="hold-transition skin-red layout-top-nav">
<div class="wrapper">
	<?php $this->load->view('NGG/gold/menu'); ?>
	
<div class="content-wrapper">
    <div class="container">
	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box_heading"><h1 class="box-title">ออกบัตรรับประกันสินค้า (ทอง)</h1></div>
                    <div class="box-body">
                    <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("sale/saleorder_rolex_payment"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่ขาย
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group-sm">
                                        สาขาที่ขาย
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php foreach($shop_array as $loop) {  echo $loop->sh_name; $shop_id = $loop->sh_id; } ?>" readonly>
                                        <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">
                                    </div>
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    ชื่อลูกค้า *
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="">
                                </div>
							</div>
                            <div class="col-md-9">
                                <div class="form-group-sm">
                                    ที่อยู่ลูกค้า *
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="">
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    เบอร์ติดต่อ *
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="">
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    ชำระเงิน *
                                    <select class="form-control" name="payment" id="payment">
                                        <option value="C">เงินสด</option>
                                        <option value="D">บัตรเครดิต</option>
                                        <option value="Q">เช็ค</option>
                                    </select>
                                </div>
							</div> 
                            <div class="col-md-2">
                                <div class="form-group-lg">
                                    <div id="text1">จำนวนเงินที่จ่าย *</div>
                                    <input type="text" class="form-control input-lg text-blue" name="payment_value" id="payment_value" style="font-weight:bold;" value="" onchange="numberWithCommas(this);" >
                                </div>
							</div> 
                        </div>
						<br>
						<div class="row">
							<div class="col-md-12">
				                <div class="panel panel-default">
									<div class="panel-heading"><div class="input-group input-group-lg col-lg-6">
                                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Serial ที่ขาย">
                                        <div class="input-group-btn">

                                        </div>
                                        <label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label> 
                                        </div></div>
				                    <div class="panel-body">
				                        <div class="table-responsive">
				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
				                                <thead>
				                                    <tr>
				                                        <th>RMC</th>
                                                        <th>Serial No.</th>
                                                        <th>Description</th>
                                                        <th>Family</th>
                                                        <th>Bracelet</th>
														<th width="105">Quantity</th>
                                                        <th>Retail Price</th>
                                                        <th>Discount (THB)</th>
														<th> </th>
				                                    </tr>
				                                </thead>
												<tbody>
												</tbody>
                                                <tfoot>
                                                    <tr style="font-size:200%;" class="text-red">
                                                        <th colspan="7" style="text-align:right;"><label>ยอดรวม:</th>
                                                        <th><div id="summary"></div></th>
                                                    </tr>
                                                </tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>	
						</div>	
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group-sm">
                                    รหัสพนักงานขาย *
                                    <input type="text" class="form-control" name="salepersonid" id="salepersonid" value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group-sm">
                                    ชื่อ-นามสกุลพนักงานขาย *
                                    <input type="hidden" name="saleperson_code" id="saleperson_code" value="">
                                    <input type="text" class="form-control" name="salename" id="salename" value="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-sm">
                                    Remark
                                    <input type="text" class="form-control" name="remark" id="remark" value="">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  ชำระเงิน </button>&nbsp;&nbsp;
							</div>
						</div>
						</form>

					</div>
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
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    get_datepicker("#datein");
});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
</script>
</body>
</html>