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
            
            <h1>เพิ่มข้อมูลส่งซ่อม (New Repair Order)</h1>
        </section>
            
		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("sale/saleorder_select_item"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group">
                                            วันที่ส่งซ่อม *
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $currentdate; ?>">
                                    </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                        เลขที่ใบรับ *
                                        <input type="text" class="form-control" name="number" id="number" value="">
                                </div>
							</div>
                            <div class="col-md-2">
									<div class="form-group">
                                        สาขาที่ส่งซ่อม *
                                        <select class="form-control" name="shopid" id="shopid">
                                            <option value='0'>-- เลือกสาขา --</option>
										<?php 	if(is_array($shop_array)) {
												foreach($shop_array as $loop){
													echo "<option value='".$loop->sh_id."#".$loop->sh_code."-".$loop->sh_name."'>".$loop->sh_code."-".$loop->sh_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    วันที่ CS รับ *
                                    <input type="text" class="form-control" name="datecs" id="datecs" value="<?php echo $currentdate; ?>">
                                </div>
							</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    รับของจาก *
                                    <input type="text" class="form-control" name="getfrom" id="getfrom" value="">
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                ชื่อลูกค้า *
                                <input type="text" class="form-control" name="cusname" id="cusname" value="">
                                </div>
                            </div>    
                            <div class="col-md-2">
                                <div class="form-group">
                                เบอร์ติดต่อลูกค้า *
                                <input type="text" class="form-control" name="custelephone" id="custelephone" value="">
                                </div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                Ref. Number *
                                <input type="text" class="form-control" name="refcode" id="refcode" value="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                ยี่ห้อ *
                                <select class="form-control" name="brandid" id="brandid">
                                    <option value="0">-- เลือกยี่ห้อ --</option>
                                <?php 	if(is_array($brand_array)) {
                                        foreach($brand_array as $loop){
                                            echo "<option value='".$loop->br_id."'>".$loop->br_code." - ".$loop->br_name."</option>";
                                 } } ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                อาการ *
                                <input type="text" class="form-control" name="case" id="case" value="">
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
    custelephone = custelephone.replace(/[-/#\s]/g, "");
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
    var datein = document.getElementById('datein').value;
    var datecs = document.getElementById('datecs').value;
    var shopid = document.getElementById('shopid').value;
    var number = document.getElementById('number').value;
    var getfrom = document.getElementById('getfrom').value;
    var refcode = document.getElementById('refcode').value;
    var brandid = document.getElementById('brandid').value;
    var case1 = document.getElementById('case').value;
     
    document.getElementById("savebtn").disabled = true;
    
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_repair/save_repair"); ?>" ,
        data : {datein: datein, cusname: cusname, custelephone: custelephone, datecs: datecs, shopid: shopid, number: number, getfrom: getfrom, refcode: refcode, brandid: brandid, case: case1} ,
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