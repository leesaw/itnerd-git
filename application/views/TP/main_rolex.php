<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            NGG | Rolex <?php if ($sessstatus ==8) echo "POS"; ?> <small>Current version 1.2.0</small>
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
        <?php if ($sessstatus ==8) { ?>
            <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
					<div class="box-heading"><h4 class="box-title"> </h4></div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("sale/saleorder_POS"); ?>"><button type="button" class="btn btn-success btn-lg btn-block"><h4>ออกใบกำกับภาษี</h4></button></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("sale/saleorder_POS_temp"); ?>"><button type="button" class="btn btn-primary btn-lg btn-block"><h4>ออกใบเสร็จรับเงิน</h4></button></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("pos/stock_rolex_borrow"); ?>"><button type="button" class="btn bg-maroon btn-lg btn-block"><h4>ออกใบส่งของชั่วคราว</h4></button></a>
                                </div>
                            </div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("pos/form_rolex_warrantycard_comfirm"); ?>"><button type="button" class="btn bg-navy btn-lg btn-block"><h4>แจ้งรูดใบรับประกัน</h4></button></a>
                                </div>
                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("pos/stock_rolex_borrow_return"); ?>"><button type="button" class="btn btn-danger btn-lg btn-block"><h4>ออกใบรับสินค้าคืน</h4></button></a>
                                </div>
                            </div>
						</div>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("sale/saleorder_POS_today"); ?>"><button type="button" class="btn bg-purple btn-lg btn-block"><h4>ใบกำกับภาษีของวันนี้</h4></button></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("sale/saleorder_POS_temp_today"); ?>"><button type="button" class="btn btn-warning btn-lg btn-block"><h4>ใบเสร็จรับเงินของวันนี้</h4></button></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("pos/stock_POS_borrow_today"); ?>"><button type="button" class="btn btn-info btn-lg btn-block"><h4>ใบส่งของ/รับคืน ของวันนี้</h4></button></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("pos/getBalance_shop"); ?>"><button type="button" class="btn bg-navy btn-lg btn-block"><h4>ตรวจสอบสินค้าในร้าน</h4></button></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("pos/formSerial_detail_shop"); ?>"><button type="button" class="btn bg-olive btn-lg btn-block"><h4>ตรวจสอบ Serial</h4></button></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("pos/form_list_borrow_item"); ?>"><button type="button" class="btn bg-orange btn-lg btn-block"><h4>รายการสินค้ายืม</h4></button></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="<?php echo site_url("pos/list_rolex_warrantycard"); ?>"><button type="button" class="btn btn-success btn-lg btn-block"><h4>รายการใบรับประกันที่รูดแล้ว</h4></button></a>
                                </div>
                            </div>
						</div>
					</div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12"><h4>หากพบปัญหาการใช้งาน สามารถติดต่อสอบถาม ได้ที่เบอร์  099-561-5636 </h4></div>
                        </div>
                    </div>
                </div>
        <?php }else{ ?>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <i class="fa fa-warning"></i>

                      <h3 class="box-title">NERD version 1.2 noted</h3>
                    </div>
                    <div class="box-body">
                        <ul>
                            <li>เพิ่มเมนู "รายงาน (Reports)"</li>
                            <li>สามารถดูรายการสินค้า Rolex ที่ถูกยืมได้ โดยไปที่เมนู <b>"รายงาน(Reports) -> รายการสินค้ายืม"</b></li>
                            <li>สามารถดู Sale Report โดยไปที่เมนู <b>"รายงาน(Reports) -> รายงานการขาย Rolex"</b></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <?php } ?>
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