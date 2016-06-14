<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
        <div class="content-wrapper">
        <section class="content-header">
            
            <h1>ข้อมูลส่งซ่อม (Repair Order)</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <?php 
            foreach($repair_array as $loop) {
                $rep_id = $loop->rep_id;
                $rep_dateadd = $loop->rep_dateadd;
                $rep_dateaddby = $loop->firstname." ".$loop->lastname;
                $rep_remark = $loop->rep_remark;
                $rep_cusname = $loop->rep_cusname;
                $rep_custelephone = $loop->rep_custelephone;
                $rep_number = $loop->rep_number;
                $rep_shopin = $loop->shopin_code."-".$loop->shopin_name;
                $rep_brand = $loop->br_code."-".$loop->br_name;
                $rep_refcode = $loop->rep_refcode;
                $rep_case = $loop->rep_case;
                $rep_getfrom = $loop->rep_getfrom;
                $rep_assess = $loop->rep_assess;
                $rep_warranty = $loop->rep_warranty;
                $rep_price = $loop->rep_price;
                $rep_shopreturn = $loop->shopreturn_code."-".$loop->shopreturn_name;
                $rep_responsename = $loop->rep_responsename;
                $rep_status = $loop->rep_status;
                
                $datein = explode("-", $loop->rep_datein);
                $rep_datein = $datein[2]."/".$datein[1]."/".$datein[0];
                $datecs = explode("-", $loop->rep_datecs);
                $rep_datecs = $datecs[2]."/".$datecs[1]."/".$datecs[0];
                
                if ($loop->rep_datedone != "0000-00-00") {
                    $datedone = explode("-", $loop->rep_datedone);
                    $rep_datedone = $datedone[2]."/".$datedone[1]."/".$datedone[0];
                }else{
                    $rep_datedone = "";
                }
                
                if ($loop->rep_datereturn != "0000-00-00") {
                    $datereturn = explode("-", $loop->rep_datereturn);
                    $rep_datereturn = $datereturn[2]."/".$datereturn[1]."/".$datereturn[0];
                }else{
                    $rep_datereturn = "";
                }
    
            }
					?>
					<div class="panel-heading"><strong>รายละเอียด</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                        <label>วันที่ส่งซ่อม</label>
                                        <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $rep_datein; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                        <label>เลขที่ใบรับ</label>
                                        <input type="text" class="form-control" name="number" id="number" value="<?php echo $rep_number; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                        <label>สาขาที่ส่งซ่อม</label>
                                        <input type="text" class="form-control" name="shopin" id="shopin" value="<?php echo $rep_shopin; ?>" readonly>
                                    </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>วันที่ CS รับ</label>
                                    <input type="text" class="form-control" name="datecs" id="datecs" value="<?php echo $rep_datecs; ?>" readonly>
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>รับของจาก</label>
                                    <input type="text" class="form-control" name="getfrom" id="getfrom" value="<?php echo $rep_getfrom; ?>" readonly>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>ชื่อลูกค้า</label>
                                <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $rep_cusname; ?>" readonly>
                                </div>
                            </div>    
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>เบอร์ติดต่อลูกค้า</label>
                                <input type="text" class="form-control" name="custelephone" id="custelephone" value="<?php echo $rep_custelephone; ?>" readonly>
                                </div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>Ref. Number</label>
                                <input type="text" class="form-control" name="refcode" id="refcode" value="<?php echo $rep_refcode; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>ยี่ห้อ</label>
                                <input type="text" class="form-control" name="brandid" id="brandid" value="<?php echo $rep_brand; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                <label>อาการ</label>
                                <input type="text" class="form-control" name="case" id="case" value="<?php echo $rep_case; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label>ประเมินการซ่อม</label>
                                <input type="text" class="form-control" name="assess" id="assess" value="<?php echo $rep_assess; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>ประกัน</label>
                                <input type="text" class="form-control" name="warranty" id="warranty" value="<?php if($rep_warranty==1) echo "หมดประกัน"; if($rep_warranty==2) echo "อยู่ในประกัน";  ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>ราคาซ่อม</label>
                                <input type="text" class="form-control" name="price" id="price" value="<?php echo $rep_price; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>ผู้รับผิดชอบ</label>
                                <input type="text" class="form-control" name="response" id="response" value="<?php echo $rep_responsename; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>วันที่จบงาน</label>
                                <input type="text" class="form-control" name="datedone" id="datedone" value="<?php echo $rep_datedone;  ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>วันที่ส่งกลับ</label>
                                <input type="text" class="form-control" name="datereturn" id="datereturn" value="<?php echo $rep_datereturn; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>สาขาที่ส่งกลับ</label>
                                <input type="text" class="form-control" name="returnshop" id="returnshop" value="<?php echo $rep_shopreturn; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                <label>Remark</label>
                                <input type="text" class="form-control" name="remark" id="remark" value="<?php echo $rep_remark; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group-lg">
                                    <label>สถานะ</label>
                                    <input type="text" class="form-control text-red" name="case" id="case" value="<?php 
                                        if ($rep_status == 'G') echo "รับเข้าซ่อม";
                                        if ($rep_status == 'A') echo "ประเมินการซ่อมแล้ว";
                                        if ($rep_status == 'D') echo "ซ่อมเสร็จ";
                                        if ($rep_status == 'R') echo "ส่งกลับแล้ว";
                                    ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group-lg">
                                    <label>ผู้แก้ไขล่าสุด</label>
                                    <input type="text" class="form-control text-red" name="user" id="user" value="<?php echo $rep_dateaddby." ".$rep_dateadd; ?>" readonly>
                                </div>
                            </div>
                        </div>
						<br>
                        <div name="submit1" class="row">
							<div class="col-md-6">
								<a href="<?php echo site_url("tp_repair/form_new_repair"); ?>" type="button" class="btn btn-success" name="savebtn" id="savebtn"><i class='fa fa-save'></i> เพิ่มข้อมูลส่งซ่อม </a>&nbsp;&nbsp;
                                
							</div>
						</div>

					</div>
				</div>
			</div>	
            </div></section>
	</div>
</div>
<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    

});

    
</script>
</body>
</html>