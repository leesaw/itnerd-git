<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายการสินค้าส่งซ่อม
        </h1>
    </section>

	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

        <div class="box-body">
        <div class="row">
            <form action="<?php echo site_url("tp_repair/result_list_repair"); ?>" name="formfilter" id="formfilter" method="post">
            <div class="col-md-2">
                <div class="form-group">
                เลขที่ใบรับ
                <input type="text" class="form-control input-sm" name="number" id="number" value="<?php echo $number_show; ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                Ref. Number
                <input type="text" class="form-control input-sm" name="refcode" id="refcode" value="<?php if ($refcode!="NULL") echo $refcode; ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                ยี่ห้อ
                <select id="brandid" name="brandid" class="form-control select2">
                    <option value="0"<?php if($brandid==0) echo " selected"; ?>>เลือกทั้งหมด</option>
                    <?php foreach($brand_array as $loop) { ?>
                    <option value="<?php echo $loop->br_id; ?>" <?php if($loop->br_id==$brandid) echo " selected"; ?>><?php echo $loop->br_code."-".$loop->br_name; ?></option>
                    <?php } ?>
                    <option value='99999'<?php if($brandid==99999) echo " selected"; ?>>-- อื่น ๆ --</option>
                </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                สาขาที่ส่งซ่อม
                <select class="form-control select2" name="shopid" id="shopid">
                    <option value="0"<?php if($shopid==0) echo " selected"; ?>>เลือกทั้งหมด</option>
										<option value="1"<?php if($shopid==1) echo " selected"; ?>>HO-Head Office นราธิวาสราชนครินทร์</option>
                <?php   if(is_array($shop_array)) {
                        foreach($shop_array as $loop){
                            echo "<option value='".$loop->sh_id."'";
                            if($loop->sh_id==$shopid) echo " selected";
                            echo ">".$loop->sh_code."-".$loop->sh_name."</option>";
                 } } ?>
                    <option value='99999'<?php if($shopid==99999) echo " selected"; ?>>-- อื่น ๆ --</option>
                </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                สถานะการซ่อม
                <select class="form-control select2" name="status" id="status">
                    <option value="0"<?php if($status=="0") echo " selected"; ?>>เลือกทั้งหมด</option>
                    <option value="G"<?php if($status=="G") echo " selected"; ?>>รับเข้าซ่อม</option>
                    <option value="A"<?php if($status=="A") echo " selected"; ?>>ประเมินการซ่อมแล้ว</option>
                    <option value="D"<?php if($status=="D") echo " selected"; ?>>ซ่อมเสร็จ</option>
                    <option value="C"<?php if($status=="C") echo " selected"; ?>>ซ่อมไม่ได้</option>
                    <option value="R"<?php if($status=="R") echo " selected"; ?>>ส่งกลับแล้ว</option>
                </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                เดือนที่ส่งซ่อม
                <input type="text" class="form-control input-sm" name="month" id="month" value="<?php echo $month; ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                เดือนที่ CS รับ
                <input type="text" class="form-control input-sm" name="month_cs" id="month_cs" value="<?php echo $month_cs; ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                เดือนที่ส่งกลับ
                <input type="text" class="form-control input-sm" name="month_return" id="month_return" value="<?php echo $month_return; ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3 col-md-2">
                <button type="submit" name="action" value="0" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> ค้นหา</button>
            </div>
        </div>


        </form>

					</div>
                </div>
            </div>
        </div>



        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading">
                        <form name="exportexcel" action="<?php echo site_url("tp_repair/exportExcel_repair_report"); ?>" method="post">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Excel</button>
                        <input type="hidden" name="excel_number" value="<?php echo $number; ?>">
                        <input type="hidden" name="excel_refcode" value="<?php echo $refcode; ?>">
                        <input type="hidden" name="excel_brandid" value="<?php echo $brandid; ?>">
                        <input type="hidden" name="excel_shopid" value="<?php echo $shopid; ?>">
                        <input type="hidden" name="excel_status" value="<?php echo $status; ?>">
                        <input type="hidden" name="excel_month" value="<?php echo $month_ajax; ?>">
                        <input type="hidden" name="excel_month_cs" value="<?php echo $month_cs_ajax; ?>">
                        <input type="hidden" name="excel_month_return" value="<?php echo $month_return_ajax; ?>">
                        </form>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="tablebarcode" width="100%">
                            <thead>
                                <tr>
                                    <th width="80">วันที่ส่งซ่อม</th>
                                    <th width="80">เลขที่ใบรับ</th>
                                    <th>Ref. Number</th>
                                    <th>ยี่ห้อ</th>
                                    <th>สาขาที่ส่งซ่อม</th>
                                    <th>รายละเอียดลูกค้า</th>
                                    <th width="50">ที่มา</th>
                                    <th>อาการ</th>
                                    <th>ประกัน</th>
                                    <th>ราคาซ่อม</th>
                                    <th>สถานะ</th>
                                    <th> </th>
                                </tr>
                            </thead>

							<tbody>
							</tbody>
                            <tfoot>

                            </tfoot>
						</table>

					</div>

				</div>
			</div>

		</div>





        </section>
		</div>


	</div>


<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    get_datepicker_month("#month");
    get_datepicker_month("#month_cs");
    get_datepicker_month("#month_return");

    $(".select2").select2();

    var oTable = $('#tablebarcode').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("tp_repair/ajaxView_seach_repair")."/".$number."/".$refcode."/".$brandid."/".$shopid."/".$status."/".$month_ajax."/".$month_cs_ajax."/".$month_return_ajax; ?>',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success":fnCallback

            });
        }
    });
});

function get_datepicker_month(id)
{
    $(id).datepicker({ language:'th-th',format: "mm/yyyy", viewMode: "months",
    minViewMode: "months" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
</script>
</body>
</html>
