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
                    <div class="box_heading"><h3 class="box-title">ออกบัตรรับประกันสินค้า (ทอง)</h3></div>
                    <div class="box-body">
                    <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("sale/saleorder_rolex_payment"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group">
                                            <label>วันที่ขาย</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                        <label>สาขาที่ขาย</label>
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php foreach($shop_array as $loop) {  echo $loop->sh_name; $shop_id = $loop->sh_id; } ?>" readonly>
                                        <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">
                                    </div>
							</div>
                            <div class="col-md-1"> </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ชื่อลูกค้า *</label>
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="" autocomplete="off">
                                </div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>เบอร์ติดต่อ *</label>
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="" autocomplete="off">
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label>ที่อยู่ลูกค้า *</label>
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="" autocomplete="off">
                                </div>
							</div>
                        </div>
                        <div class="row">
							<div class="col-md-7">
                                <div class="form-group">
                                <label>ประเภทสินค้า * </label><br>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="สร้อยคอ">สร้อยคอ</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="สร้อยข้อมือ">สร้อยข้อมือ</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="แหวน">แหวน</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="จี้">จี้</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="ต่างหู">ต่างหู</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="0">อื่น ๆ .... <input type="text" name="txt_product" value="" autocomplete="off"></label>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>รหัส *</label>
                                    <input type="text" class="form-control" name="code" id="code" value="" autocomplete="off">
                                </div>
                            </div>
						</div>	
                        <div class="row">
							<div class="col-md-5">
                                <div class="form-group">
                                <label>ชนิดของทอง * </label><br>
                                <label class="radio-inline"><input type="radio" name="kindgold" id="kindgold" value="96.5%">96.5%</label>
                                <label class="radio-inline"><input type="radio" name="kindgold" id="kindgold" value="75%">75%</label>
                                <label class="radio-inline"><input type="radio" name="kindgold" id="kindgold" value="0">อื่น ๆ .... <input type="text" name="txt_kindgold" value="" autocomplete="off"></label>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>น้ำหนัก *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="weight" id="weight" autocomplete="off">
                                        <span class="input-group-addon">กรัม</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>จำนวนเงิน *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="price" id="price" autocomplete="off">
                                        <span class="input-group-addon">บาท</span>
                                    </div>
                                </div>
                            </div>
						</div>	
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>ชำระด้วย * </label><br>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="96.5%">เงินสด</label>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="75%">บัตรเครดิต</label>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="75%">บัตรผ่อน</label>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="0">อื่น ๆ .... <input type="text" name="txt_payment" value="" autocomplete="off"></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>จำนวนเพชร/พลอย *</label>
                                    <input type="text" class="form-control" name="jewelry" id="jewelry" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>รูปแบบ *</label>
                                    <input type="text" class="form-control" name="model" id="model" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>วันที่เริ่มรับประกันสินค้า</label>
                                    <input type="text" class="form-control" name="datestart" id="datestart" value="<?php echo $datein; ?>">
                                </div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>หมายเหตุมีของเก่ามาเปลี่ยน *</label>
                                    <input type="text" class="form-control" name="old" id="old" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-5">
                                <div class="panel panel-danger">
									<div class="panel-heading">
                                        <label>ราคาทองคำแท่ง</label> 
                                        </div>
				                    <div class="panel-body">
				                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ซื้อ *</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="buy" id="buy" autocomplete="off">
                                                        <span class="input-group-addon">บาท</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ขาย *</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="sell" id="sell" autocomplete="off">
                                                        <span class="input-group-addon">บาท</span>
                                                    </div>
                                                </div>
                                            </div>
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
    get_datepicker("#datestart");
});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
</script>
</body>
</html>