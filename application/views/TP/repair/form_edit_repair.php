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
            
            <h1>แก้ไขข้อมูลส่งซ่อม (Edit Repair Order)</h1>
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
                $rep_customer = $loop->rep_customer;
                $rep_number = $loop->rep_number;
                $rep_shop_id = $loop->rep_shop_id;
                $rep_shopin = $loop->shopin_code."-".$loop->shopin_name;
                $rep_brand = $loop->br_code."-".$loop->br_name;
                $rep_brand_id = $loop->rep_brand_id;
                $rep_refcode = $loop->rep_refcode;
                $rep_case = $loop->rep_case;
                $rep_getfrom = $loop->rep_getfrom;
                $rep_assess = $loop->rep_assess;
                $rep_warranty = $loop->rep_warranty;
                $rep_price = $loop->rep_price;
                $rep_shopreturn = $loop->shopreturn_code."-".$loop->shopreturn_name;
                $rep_return_shop_id = $loop->rep_return_shop_id;
                $rep_responsename = $loop->rep_responsename;
                $rep_status = $loop->rep_status;
                $rep_enable = $loop->rep_enable;
                
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
                $currentdate = date("d/m/Y");
            }
        ?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("sale/saleorder_select_item"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group">
                                            วันที่ส่งซ่อม *
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $rep_datein; ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                        เลขที่ใบรับ *
                                        <input type="text" class="form-control" name="number" id="number" value="<?php echo $rep_number; ?>">
                                </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group">
                                        สาขาที่ส่งซ่อม *
                                        <select class="form-control" name="shopid" id="shopid">
                                            <option value='0'>-- เลือกสาขา --</option>
										<?php 	if(is_array($shop_array)) {
												foreach($shop_array as $loop){
													echo "<option value='".$loop->sh_id."'";
                                                    if ($loop->sh_id==$rep_shop_id) echo " selected";
                                                    echo ">".$loop->sh_code."-".$loop->sh_name."</option>";
										 } } ?>
                                            <option value='99999'<?php if ($rep_shop_id==99999) echo " selected"; ?>>-- อื่น ๆ --</option>
                                        </select>
                                    </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    วันที่ CS รับ *
                                    <input type="text" class="form-control" name="datecs" id="datecs" value="<?php echo $rep_datecs; ?>">
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    รับของจาก *
                                    <input type="text" class="form-control" name="getfrom" id="getfrom" value="<?php echo $rep_getfrom; ?>">
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                ชื่อลูกค้า *
                                <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $rep_cusname; ?>">
                                </div>
                            </div>    
                            <div class="col-md-3">
                                <div class="form-group">
                                เบอร์ติดต่อลูกค้า *
                                <input type="text" class="form-control" name="custelephone" id="custelephone" value="<?php echo $rep_custelephone; ?>">
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group">
                                ที่มา * &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                <input type="radio" name="customer" id="customer" value="1" <?php if ($rep_customer == 1) echo " checked"; ?>> ลูกค้า&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                <input type="radio" name="customer" id="customer" value="0" <?php if ($rep_customer == 0) echo " checked"; ?>> สต็อก
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                Ref. Number *
                                <input type="text" class="form-control" name="refcode" id="refcode" value="<?php echo $rep_refcode; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                ยี่ห้อ *
                                <select class="form-control" name="brandid" id="brandid">
                                    <option value="0">-- เลือกยี่ห้อ --</option>
                                <?php 	if(is_array($brand_array)) {
                                        foreach($brand_array as $loop){
                                            echo "<option value='".$loop->br_id."'";
                                            if ($loop->br_id==$rep_brand_id) echo " selected";
                                            echo ">".$loop->br_code." - ".$loop->br_name."</option>";
                                 } } ?>
                                    <option value='99999'<?php if ($rep_brand_id==99999) echo " selected"; ?>>-- อื่น ๆ --</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                อาการ *
                                <input type="text" class="form-control" name="case" id="case" value="<?php echo $rep_case; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                Remark
                                <input type="text" class="form-control" name="remark" id="remark" value="<?php echo $rep_remark; ?>">
                                </div>
                            </div>
                        </div>
						<br>
                        <div name="submit1" class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
							</div>
						</div>
						</form>

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
    get_datepicker("#datein");
    get_datepicker("#datecs");
    document.getElementById("savebtn").disabled = false;
});
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

function submitform()
{
    var cusname = document.getElementById('cusname').value;
    var custelephone = document.getElementById('custelephone').value;
    custelephone = custelephone.replace(/[-,/#\s]/g, "");
    var customer = $('input[name="customer"]:checked').val();
    var datein = document.getElementById('datein').value;
    var datecs = document.getElementById('datecs').value;
    var shopid = document.getElementById('shopid').value;
    var number = document.getElementById('number').value;
    var getfrom = document.getElementById('getfrom').value;
    var refcode = document.getElementById('refcode').value;
    var brandid = document.getElementById('brandid').value;
    var case1 = document.getElementById('case').value;

    if (datein == "") {
        alert("กรุณาใส่วันที่ส่งซ่อม");
        document.getElementById('datein').focus();
    }else if (number == "") {
        alert("กรุณาใส่เลขที่ใบรับ");
        document.getElementById('number').focus(); 
    }else if (shopid == 0) {
        alert("กรุณาเลือกสาขาที่ส่งซ่อม");
        document.getElementById('shopid').focus(); 
    }else if (datecs == "") {
        alert("กรุณาใส่วันที่ CS รับ");
        document.getElementById('datecs').focus();
    }else if (getfrom == "") {
        alert("กรุณาใส่รับของจาก");
        document.getElementById('getfrom').focus(); 
    }else if (cusname == "") {
        alert("กรุณาใส่ชื่อลูกค้า");
        document.getElementById('cusname').focus();
    }else if (custelephone == "") {
        alert("กรุณาใส่เบอร์ติดต่อลูกค้า");
        document.getElementById('custelephone').focus();
    }else if ((Math.floor(custelephone)*1000) % 1 != 0) {
        alert("กรุณาใส่เบอร์ติดต่อลูกค้า ที่เป็นตัวเลขเท่านั้น");
        document.getElementById('custelephone').focus(); 
    }else if (customer != 0 && customer != 1) {
        alert("กรุณาเลือกที่มาของซ่อม");
    }else if (refcode == "") {
        alert("กรุณาใส่ Ref. Number");
        document.getElementById('refcode').focus();
    }else if (brandid == 0) {
        alert("กรุณาเลือกยี่ห้อ");
        document.getElementById('brandid').focus(); 
    }else if (case1 == "") {
        alert("กรุณาระบุอาการ");
        document.getElementById('case').focus(); 
    }else{
        var r = confirm("ยืนยันการบันทึก !!");
        if (r == true) {
            confirmform();
        }
    }
    
}
    
function confirmform()
{
    var cusname = document.getElementById('cusname').value;
    var custelephone = document.getElementById('custelephone').value;
    custelephone = custelephone.replace(/[-/#\s]/g, "");
    var customer = $('input[name="customer"]:checked').val();
    var datein = document.getElementById('datein').value;
    var datecs = document.getElementById('datecs').value;
    var shopid = document.getElementById('shopid').value;
    var number = document.getElementById('number').value;
    var getfrom = document.getElementById('getfrom').value;
    var refcode = document.getElementById('refcode').value;
    var brandid = document.getElementById('brandid').value;
    var case1 = document.getElementById('case').value;
    var remark = document.getElementById('remark').value;
    var rep_id = <?php echo $rep_id; ?>;
     
    document.getElementById("savebtn").disabled = true;
    
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_repair/edit_repair"); ?>" ,
        data : {rep_id: rep_id, datein: datein, cusname: cusname, custelephone: custelephone, customer: customer, datecs: datecs, shopid: shopid, number: number, getfrom: getfrom, refcode: refcode, brandid: brandid, case: case1, remark: remark} ,
        dataType: 'json',
        success : function(data) {
            var message = "ทำการบันทึกเรียบร้อยแล้ว";
            bootbox.alert(message, function() {
                window.location = "<?php echo site_url("tp_repair/view_repair"); ?>/"+data.b;
            });


        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
            document.getElementById("savebtn").disabled = false;
        }
    });
    
}
    
</script>
</body>
</html>