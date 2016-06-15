<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<style type="text/css">
.datepicker {z-index: 1151 !important;}
</style>
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
					<div class="panel-heading"><strong>รายละเอียด</strong> <h2 class="text-red" id="enable" name="enable"><?php if($rep_enable==0) echo "ยกเลิกแล้ว"; ?></h2></div>
					
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
                                        if ($rep_status == 'C') echo "ซ่อมไม่ได้";
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
								<button type="button" class="btn bg-orange" name="fixbtn" id="fixbtn" onclick="fix_status()" <?php if ($rep_status == 'R' || $rep_enable==0) echo " disabled"; ?>><i class='fa fa-wrench'></i> แจ้งประเมินการซ่อม </button>&nbsp;&nbsp;
                                <a data-toggle="modal" data-target="#myModal" type="button" class="btn btn-primary" name="donebtn" id="donebtn" <?php if ($rep_status == 'G' || $rep_status == 'R' || $rep_enable==0) echo " disabled"; ?>><i class='fa fa-thumbs-up'></i> แจ้งจบงาน </a>&nbsp;&nbsp;
                                <a data-toggle="modal" data-target="#myModal_return" type="button" class="btn btn-success" name="returnbtn" id="returnbtn"<?php if ($rep_status == 'G' || $rep_status=='A' || $rep_enable==0) echo " disabled"; ?>><i class='fa fa-check-square-o'></i> แจ้งส่งกลับ </a>&nbsp;&nbsp;
                                
							</div>
                            <div class="col-md-6">
                                <div class="pull-right">
                                <a href="<?php echo site_url("tp_repair/form_edit_repair")."/".$rep_id; ?>" type="button" class="btn btn-warning" id="editbtn" name="editbtn" <?php if ($rep_enable==0) echo " disabled"; ?>><i class='fa fa-edit'></i> แก้ไขข้อมูล</a>&nbsp;&nbsp;
                                <button type="button" class="btn btn-danger" onclick="disable_repair()" id="disablebtn" name="disablebtn" <?php if ($rep_enable==0) echo " disabled"; ?>><i class='fa fa-trash'></i> ลบข้อมูล</button>&nbsp;&nbsp;
                                </div>
                            </div>
						</div>

					</div>
				</div>
			</div>	
            </div></section>
	</div>
</div>
 

<!-- datepicker modal for done status -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

      <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">	                 	
                    <i class='fa fa-thumbs-up'></i> แจ้งจบงาน
                </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
                <div class="row"><div class="col-md-12"><form class="form-horizontal"><div class="form-group"><label class="col-md-4 control-label" for="donedate_done">วันที่จบงาน</label><div class="col-md-4"> <input type="text" class="form-control" id="donedate_done" name="donedate_done" value="<?php echo $rep_datedone; ?>" /></div></div><div class="form-group"><label class="col-md-4 control-label" for="status_done">ผลการซ่อม</label><div class="col-md-4"> <div class="radio"> <label for="status_done-D"><input type="radio" name="status_done" id="status_done-D" value="D" <?php if ($rep_status == 'D') echo "checked"; ?>> ซ่อมได้ </label></div><div class="radio"> <label for="status_done-C"><input type="radio" name="status_done" id="status_done-C" value="C" <?php if ($rep_status == 'C') echo "checked"; ?>> ซ่อมไม่ได้ </label> </div></div> </div><div class="form-group"><label class="col-md-4 control-label" for="remark_done">Remark</label><div class="col-md-8"><input id="remark_done" name="remark_done" type="text" placeholder="" class="form-control input-md" value="<?php echo $rep_remark; ?>"></div></div><div class="form-group"><label class="col-md-4 control-label" for="warranty_done">ประกัน</label><div class="col-md-4"> <div class="radio"> <label for="warranty_done-1"><input type="radio" name="warranty_done" id="warranty_done-1" value="1" <?php if ($rep_warranty == 1) echo "checked"; ?>>หมดประกัน </label></div><div class="radio"> <label for="warranty_done-2"><input type="radio" name="warranty_done" id="warranty_done-2" value="2" <?php if ($rep_warranty == 2) echo "checked"; ?>> อยู่ในประกัน </label></div></div> </div><div class="form-group"><label class="col-md-4 control-label" for="price_done">ราคา</label><div class="col-md-4"><div class="input-group"><input id="price_done" name="price_done" type="text" placeholder="" class="form-control input-md"  value="<?php echo $rep_price; ?>"> <span class="input-group-addon">บาท</span></div></div></div><div class="form-group"><label class="col-md-4 control-label" for="response_done">ผู้รับผิดชอบ</label><div class="col-md-8"><input id="response_done" name="response_done" type="text" placeholder="" class="form-control input-md" value="<?php echo $rep_responsename; ?>"></div></div></form> </div>  </div>

            </div>            <!-- /modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="done_status()"><i class='fa fa-save'></i> บันทึก</button>			

            </div> 	
            </form>								
        </div>
    </div>
</div>

</div>
<!-- close modal -->    

<!-- datepicker modal for return status -->
    <div class="modal fade" id="myModal_return" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_return" aria-hidden="true">

      <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">	                 	
                    <i class='fa fa-thumbs-up'></i> แจ้งส่งกลับ
                </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
                <div class="row"><div class="col-md-12"><form class="form-horizontal"><div class="form-group"><label class="col-md-4 control-label" for="returndate_return">วันที่ส่งกลับ</label><div class="col-md-4"> <input type="text" class="form-control" id="returndate_return" name="returndate_return" value="<?php echo $rep_datereturn; ?>" /></div></div><div class="form-group"><label class="col-md-4 control-label" for="shop_return">สาขาที่ส่งกลับ</label><div class="col-md-6"><select class="form-control" name="shop_return" id="shop_return"><option value='0'>-- เลือกสาขา --</option><?php 	if(is_array($shop_array)) { foreach($shop_array as $loop){ echo "<option value='".$loop->sh_id."'"; if($loop->sh_id==$rep_return_shop_id) echo " selected"; echo ">".$loop->sh_code."-".$loop->sh_name."</option>"; } } ?></select></div> </div><div class="form-group"><label class="col-md-4 control-label" for="remark_done">Remark</label><div class="col-md-8"><input id="remark_return" name="remark_return" type="text" placeholder="" class="form-control input-md" value="<?php echo $rep_remark; ?>"></div></div></form> </div>  </div>

            </div>            <!-- /modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="return_status()"><i class='fa fa-save'></i> บันทึก</button>			

            </div> 	
            </form>								
        </div>
    </div>
</div>

</div>
<!-- close modal -->  
    
<?php $this->load->view('js_footer'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    
    get_datepicker("#donedate_done");
    get_datepicker("#returndate_return");
});
    
  
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

function fix_status()
{
    bootbox.dialog({
        title: "<i class='fa fa-wrench'></i> แจ้งประเมินการซ่อม",
        message: '<div class="row">  ' +
            '<div class="col-md-12"> ' +
            '<form class="form-horizontal"> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="assess_fix">ประเมินการซ่อม *</label> ' +
            '<div class="col-md-8"> ' +
            '<input id="assess_fix" name="assess_fix" type="text" placeholder="" class="form-control input-md" value="<?php echo $rep_assess; ?>"> ' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="warranty_fix">ประกัน</label> ' +
            '<div class="col-md-4"> <div class="radio"> <label for="warranty-1"> ' +
            '<input type="radio" name="warranty_fix" id="warranty-1" value="1" <?php if ($rep_warranty == 1) echo "checked"; ?>> ' +
            'หมดประกัน </label> ' +
            '</div><div class="radio"> <label for="warranty-2"> ' +
            '<input type="radio" name="warranty_fix" id="warranty-2" value="2" <?php if ($rep_warranty == 2) echo "checked"; ?>> อยู่ในประกัน </label> ' +
            '</div> ' +
            '</div> </div>' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="price_fix">ราคา</label> ' +
            '<div class="col-md-4"> ' +
            '<div class="input-group"><input id="price_fix" name="price_fix" type="text" placeholder="" class="form-control input-md"  value="<?php echo $rep_price; ?>"> <span class="input-group-addon">บาท</span></div>' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="response_fix">ผู้รับผิดชอบ</label> ' +
            '<div class="col-md-8"> ' +
            '<input id="response_fix" name="response_fix" type="text" placeholder="" class="form-control input-md" value="<?php echo $rep_responsename; ?>"> ' +
            '</div> ' +
            '</div> ' +
            '</form> </div>  </div>',
        buttons: {
            success: {
                label: "<i class='fa fa-save'></i> บันทึก",
                className: "btn-success",
                callback: function () {
                    var assess = $('#assess_fix').val();
                    var warranty = $("input[name='warranty_fix']:checked").val();
                    var price = $('#price_fix').val();
                    var response = $('#response_fix').val();
                    
                    if (assess == "") {
                        alert("กรุณาใส่ประเมินการซ่อม");
                        document.getElementById("assess_fix").focus();
                        return false;
                    }else{
                        save_fix_status();
                    }
                    
                    },
                }
            }
        }
    );
}
    
function save_fix_status()
{
    var assess = $('#assess_fix').val();
    var warranty = $("input[name='warranty_fix']:checked").val();
    var price = $('#price_fix').val();
    var response = $('#response_fix').val();
    var rep_id = <?php echo $rep_id; ?>;
     
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_repair/save_fix_status"); ?>" ,
        data : {assess: assess, warranty: warranty, price: price, response: response, rep_id: rep_id} ,
        dataType: 'json',
        success : function(data) {
            var message = "ทำการบันทึกเรียบร้อยแล้ว";
            bootbox.alert(message, function() {
                location.reload();
            });
            
        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
        }
    });

}
    
function done_status()
{
    var datedone = $('#donedate_done').val();
    var status = $("input[name='status_done']:checked").val();
    var remark = $('#remark_done').val();
    var warranty = $("input[name='warranty_fix']:checked").val();
    var price = $('#price_fix').val();
    var response = $('#response_fix').val();

    if (datedone =="") {
        alert("กรุณาใส่วันที่จบงาน");
        document.getElementById("donedate_done").focus();
        return false;
    }else if (status != 'D' && status != 'C') {
        alert("กรุณาเลือกผลการซ่อม");
        return false;
    }else{
        save_done_status();
    }
}
    
function save_done_status()
{
    var datedone = $('#donedate_done').val();
    var status = $("input[name='status_done']:checked").val();
    var remark = $('#remark_done').val();
    var warranty = $("input[name='warranty_done']:checked").val();
    var price = $('#price_done').val();
    var response = $('#response_done').val();
    var rep_id = <?php echo $rep_id; ?>;
     
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_repair/save_done_status"); ?>" ,
        data : {datedone: datedone, status: status, remark: remark, warranty: warranty, price: price, response: response, rep_id: rep_id} ,
        dataType: 'json',
        success : function(data) {
            var message = "ทำการบันทึกเรียบร้อยแล้ว";
            bootbox.alert(message, function() {
                location.reload();
            });
            
        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
        }
    });

}
    
function return_status()
{
    var returndate = $('#returndate_return').val();
    var shop_return = $('#shop_return').val();
    var remark = $('#remark_done').val();

    if (returndate =="") {
        alert("กรุณาใส่วันที่ส่งกลับ");
        document.getElementById("returndate_return").focus();
        return false;
    }else if (shop_return == 0) {
        alert("กรุณาเลือกสาขาที่ส่งกลับ");
        return false;
    }else{
        save_return_status();
    }
}
    
function save_return_status()
{
    var returndate = $('#returndate_return').val();
    var shop_return = $('#shop_return').val();
    var remark = $('#remark_return').val();
    var rep_id = <?php echo $rep_id; ?>;
     
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("tp_repair/save_return_status"); ?>" ,
        data : {returndate: returndate, shop_return: shop_return, remark: remark, rep_id: rep_id} ,
        dataType: 'json',
        success : function(data) {
            var message = "ทำการบันทึกเรียบร้อยแล้ว";
            bootbox.alert(message, function() {
                location.reload();
            });
            
        },
        error: function (textStatus, errorThrown) {
            alert("เกิดความผิดพลาด !!!");
        }
    });

}
    
function disable_repair()
{
    var rep_id = <?php echo $rep_id; ?>;
    
    bootbox.confirm("ยืนยันการยกเลิก ?", function(result) {
      if(result) {
          $.ajax({
                type : "POST" ,
                url : "<?php echo site_url("tp_repair/disable_repair"); ?>" ,
                data : {rep_id: rep_id} ,
                dataType: 'json',
                success : function(data) {
                    location.reload();
                },
                error: function (textStatus, errorThrown) {
                    alert("เกิดความผิดพลาด !!!");
                }
            });
      }
    }); 

}
    
</script>
</body>
</html>