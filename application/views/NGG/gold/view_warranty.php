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
<?php foreach($warranty_array as $loop) { 
    $id = $loop->ngw_id;
    $cusname = $loop->ngw_customername; 
    $cusaddress = $loop->ngw_customeraddress;
    $custelephone = $loop->ngw_customertelephone;
    $shopname = $loop->sh_name;
    $shoptelephone = $loop->sh_telephone;
    $number = $loop->ngw_number;
    $product = $loop->ngw_product;
    $kindgold = $loop->ngw_kindgold;
    $price = $loop->ngw_price;
    $payment = $loop->ngw_payment;
    $code = $loop->ngw_code;
    $weight = $loop->ngw_weight;
    $jewelry = $loop->ngw_jewelry;
    $datestart = $loop->ngw_datestart;
    $old = $loop->ngw_old;
    $model = $loop->ngw_model;
    $goldbuy = $loop->ngw_goldbuy;
    $goldsell = $loop->ngw_goldsell;
    $saleperson = $loop->sp_firstname." ".$loop->sp_lastname;
    $issuedate = $loop->ngw_issuedate;
    $salebarcode = $loop->sp_barcode;
    $status = $loop->ngw_status;
    $remark = $loop->ngw_remark;
} 
                                
 $datestart_year=substr($datestart,0,4); 
 $datestart_month=substr($datestart,5,2); 
 $datestart_day=substr($datestart,8,2); 
 $datestart = $datestart_day."/".$datestart_month."/".$datestart_year;
?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box_heading"><h3 class="box-title">ออกบัตรรับประกันสินค้า (ทอง)</h3></div>
                    <div class="box-body">
                    <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
					<div class="panel-heading"><strong>รายละเอียด <?php if($status=='V') { echo "<span class='text-red'>ยกเลิกแล้ว (Void)</span>"; } ?>
                        </strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">

                                    <div class="form-group">
                                            <label>วันที่ขาย</label>
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $issuedate; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                        <label>สาขาที่ขาย</label>
                                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php echo $shopname; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-1"> </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ชื่อลูกค้า *</label>
                                    <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $cusname; ?>" autocomplete="off" readonly>
                                </div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>เบอร์ติดต่อ *</label>
                                    <input type="text" class="form-control" name="custelephone" id="custelephone" value="<?php echo $custelephone; ?>" autocomplete="off" readonly>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label>ที่อยู่ลูกค้า *</label>
                                    <input type="text" class="form-control" name="cusaddress" id="cusaddress" value="<?php echo $cusaddress; ?>" autocomplete="off" readonly>
                                </div>
							</div>
                        </div>
                        <div class="row">
							<div class="col-md-7">
                                <div class="form-group">
                                <label>ประเภทสินค้า * </label><br>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="สร้อยคอ"<?php if ($product=="สร้อยคอ") echo " checked"; ?> disabled>สร้อยคอ</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="สร้อยข้อมือ"<?php if ($product=="สร้อยข้อมือ") echo " checked"; ?> disabled>สร้อยข้อมือ</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="แหวน"<?php if ($product=="แหวน") echo " checked"; ?> disabled>แหวน</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="จี้"<?php if ($product=="จี้") echo " checked"; ?> disabled>จี้</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="ต่างหู"<?php if ($product=="ต่างหู") echo " checked"; ?> disabled>ต่างหู</label>
                                <label class="radio-inline"><input type="radio" name="product" id="product" value="0"<?php if (($product!="สร้อยคอ")&&($product!="สร้อยข้อมือ")&&($product!="แหวน")&&($product!="จี้")&&($product!="ต่างหู")) echo " checked"; ?> disabled>อื่น ๆ .... <input type="text" name="txt_product" id="txt_product" value="<?php if (($product!="สร้อยคอ")&&($product!="สร้อยข้อมือ")&&($product!="แหวน")&&($product!="จี้")&&($product!="ต่างหู")) echo $product;  ?>" autocomplete="off" readonly></label>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>รหัส *</label>
                                    <input type="text" class="form-control" name="code" id="code" value="<?php echo $code; ?>" autocomplete="off" readonly>
                                </div>
                            </div>
						</div>	
                        <div class="row">
							<div class="col-md-5">
                                <div class="form-group">
                                <label>ชนิดของทอง * </label><br>
                                <label class="radio-inline"><input type="radio" name="kindgold" id="kindgold" value="96.5%"<?php if ($kindgold=="96.5%") echo " checked"; ?> disabled>96.5%</label>
                                <label class="radio-inline"><input type="radio" name="kindgold" id="kindgold" value="75%"<?php if ($kindgold=="75%") echo " checked"; ?> disabled>75%</label>
                                <label class="radio-inline"><input type="radio" name="kindgold" id="kindgold" value="0"<?php if (($kindgold!="75%") &&($kindgold!="96.5%")) echo " checked"; ?> disabled>อื่น ๆ .... <input type="text" name="txt_kindgold" id="txt_kindgold" value="<?php if (($kindgold!="75%") &&($kindgold!="96.5%")) echo $kindgold; ?>" autocomplete="off" readonly></label>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>น้ำหนัก *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="weight" id="weight" autocomplete="off" value="<?php echo $weight; ?>" readonly>
                                        <span class="input-group-addon">กรัม</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>จำนวนเงิน *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="price" id="price" autocomplete="off" value="<?php echo number_format($price, 2, '.', ','); ?>" readonly>
                                        <span class="input-group-addon">บาท</span>
                                    </div>
                                </div>
                            </div>
						</div>	
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>ชำระด้วย * </label><br>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="เงินสด"<?php if ($payment=="เงินสด") echo " checked"; ?> disabled>เงินสด</label>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="บัตรเครดิต"<?php if ($payment=="บัตรเครดิต") echo " checked"; ?> disabled>บัตรเครดิต</label>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="บัตรผ่อน"<?php if ($payment=="บัตรผ่อน") echo " checked"; ?> disabled>บัตรผ่อน</label>
                                <label class="radio-inline"><input type="radio" name="payment" id="payment" value="0"<?php if (($payment!="เงินสด")&&($payment!="บัตรผ่อน")&&($payment!="บัตรเครดิต")) echo " checked"; ?> disabled>อื่น ๆ .... <input type="text" name="txt_payment" id="txt_payment" value="<?php if (($payment!="เงินสด")&&($payment!="บัตรผ่อน")&&($payment!="บัตรเครดิต")) echo $payment; ?>" autocomplete="off" readonly></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>จำนวนเพชร/พลอย</label>
                                    <input type="text" class="form-control" name="jewelry" id="jewelry" autocomplete="off" value="<?php echo $jewelry; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>รูปแบบ *</label>
                                    <input type="text" class="form-control" name="model" id="model" autocomplete="off" value="<?php echo $model; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>วันที่เริ่มรับประกันสินค้า *</label>
                                    <input type="text" class="form-control" name="datestart" id="datestart" value="<?php echo $datestart; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>หมายเหตุมีของเก่ามาเปลี่ยน</label>
                                    <input type="text" class="form-control" name="old" id="old" autocomplete="off" value="<?php echo $old; ?>" readonly>
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
                                                        <input type="text" class="form-control" name="goldbuy" id="goldbuy" autocomplete="off" value="<?php echo number_format($goldbuy, 2, '.', ','); ?>" readonly>
                                                        <span class="input-group-addon">บาท</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ขาย *</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="goldsell" id="goldsell" autocomplete="off" value="<?php echo number_format($goldsell, 2, '.', ','); ?>" readonly>
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
                                <div class="form-group">
                                    <label>รหัสพนักงานขาย *</label>
                                    <input type="text" class="form-control" name="salepersonid" id="salepersonid" autocomplete="off" value="<?php echo $salebarcode; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ชื่อ-นามสกุลพนักงานขาย *</label>
                                    <input type="hidden" name="saleperson_code" id="saleperson_code" value="">
                                    <input type="text" class="form-control" name="salename" id="salename" value="<?php echo $saleperson; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>หมายเหตุเพิ่มเติม</label>
                                    <input type="text" class="form-control" name="remark" id="remark" autocomplete="off" value="<?php echo $remark; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
							<div class="col-md-12">
                                <?php if($status!='V') { ?>
								<a href="<?php echo site_url("ngg_gold/print_warranty")."/".$ngw_id; ?>" target="_blank">
                                <?php } ?>    
                                <button type="button" class="btn btn-primary" name="printbtn" id="printbtn"<?php if($status=='V') echo " disabled"; ?>><i class='fa fa-print'></i>  พิมพ์บัตรรับประกันสินค้า </button></a>&nbsp;&nbsp;
                                <button type="button" class="btn btn-danger pull-right" name="voidbtn" id="voidbtn" onclick="del_confirm()" <?php if($status=='V') echo "disabled"; ?>><i class='fa fa-close'></i>  ยกเลิกบัตรรับประกันสินค้า (Void) </button>&nbsp;&nbsp;
                                <form action="<?php echo site_url("ngg_gold/void_warranty")."/".$ngw_id; ?>" method="post" name="form2" id ="form2"><input type="hidden" name="remarkvoid" id="remarkvoid" value=""></form>
                                
							</div>
						</div>
						</form>

					</div> <!-- panel body -->
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
    </div>
<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{

    
});

    
function del_confirm() {
	bootbox.confirm("ต้องการยกเลิกบัตรรับประกันสินค้าที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = "<?php echo site_url("ngg_gold/void_warranty")."/".$ngw_id; ?>";
            	if (result) {
				    bootbox.prompt("เนื่องจาก..", function(result) {                
                      if (result === null) {                                             
                        document.getElementById("form2").submit();                           
                      } else {
                        document.getElementById("remarkvoid").value=result;
                        document.getElementById("form2").submit();                       
                      }
                    });
				}

		});
}
    
</script>
</body>
</html>