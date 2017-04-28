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

            <h1>แจ้งส่งของแล้ว</h1>
        </section>

		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                      <div class="form-group-sm">
                              เลขที่ย้ายคลังสินค้าที่ยืนยันสินค้าแล้ว
                              <input type="text" class="form-control" name="transfer_number" id="transfer_number" value="" placeholder="ตัวอย่าง TB00000000">
                      </div>
							      </div>
						    </div>
                        <br>
                        <div class="row">
            							<div class="col-md-12">
            				                <div class="panel panel-default">
            				                    <div class="panel-body">
            				                        <div class="table-responsive">
            				                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
            				                                <thead>
            				                                    <tr>
            				                                        <th>เลขที่ย้ายคลังสินค้า</th>
                                                            <th>รายละเอียด</th>
                                                            <th>จำนวนรวมทั้งหมด</th>
                                                            <th>วันที่กำหนดส่ง</th>
																														<th>ออกจากคลัง</th>
																				                    <th>เข้าคลัง</th>
            				                                    </tr>
            				                                </thead>
            												<tbody>
            												</tbody>
            											</table>
            										</div>
            									</div>
            								</div>
            							</div>
            						</div>
												<div class="row">
				                    <div class="col-md-6">
				                      <div class="form-group-sm">
				                              หมายเหตุ
				                              <input type="text" class="form-control" name="transfer_remark" id="transfer_remark" value="" maxlength="500">
				                      </div>
											      </div>
										    </div>
                        <br>
                        <div name="submit1" class="row">
							<div class="col-md-6">
									<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="saveconfirm()"><i class='fa fa-save'></i>  ยืนยันส่งสินค้าแล้ว </button>&nbsp;&nbsp;
                  <a href="<?php echo site_url("tp_delivery/form_confirm_sent"); ?>"><button type="button" class="btn btn-danger" name="resetbtn" id="resetbtn"><i class='fa fa-rotate-left'></i>  เริ่มต้นใหม่ </button></a>
							</div>
						</div>

					</div>
				</div>
			</div>
            </div></section>
	</div>
</div>
<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    document.getElementById("transfer_number").focus();
    document.getElementById("savebtn").disabled = false;

    $('#transfer_number').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
          submitform();
		    }
	  });

});


function submitform()
{
    if (document.getElementById('transfer_number').value == "") {
      alert("กรุณาใส่เลขที่ย้ายคลังสินค้าที่ยืนยันสินค้าแล้ว");
      document.getElementById('transfer_number').focus();
    }else{
      document.getElementById("savebtn").disabled = true;

      var transfer_number = document.getElementById("transfer_number").value;

      $.ajax({
          type : "POST" ,
          url : "<?php echo site_url("Tp_delivery/check_transfer_number"); ?>" ,
          data : {transfer_number: transfer_number },
          dataType: "json",
          success : function(data) {
            console.log("ok");
            switch(data.alert) {
              case 0: alert("ไม่พบเลขที่ย้ายคลังสินค้า !!!"); break;
							case 1: alert("เลขที่ย้ายคลังสินค้านี้ ยังไม่ยืนยันจำนวนสินค้า !!!"); break;
							case 2: alert("เลขที่ย้ายคลังสินค้านี้ มีการยืนยันการส่งสินค้าแล้ว !!!"); break;
							case 3: alert("เลขที่ย้ายคลังสินค้านี้ ยกเลิกแล้ว !!!"); break;
							case 4: alert("เลขที่ย้ายคลังสินค้านี้ เป็นการสวม !!!"); break;
							case 10:
								var element = "<tr>"+data.output+"</tr>";
	          		$('table > tbody').append(element);
								document.getElementById('transfer_number').value="";
								break;
            }
						document.getElementById('transfer_number').value="";
						document.getElementById("savebtn").disabled = false;
          },
          error: function (textStatus, errorThrown) {
              alert("เกิดความผิดพลาด !!!");
              document.getElementById("savebtn").disabled = false;
          }
      });
    }

}

function saveconfirm() {
	if (document.getElementsByName('stot_id').length < 1) {
		alert("กรุณาเลือกเลขที่ใบส่งของที่ต้องการยืนยัน");
		document.getElementById('transfer_number').focus();
	}else{
		var message = "คุณต้องการยืนยันการส่งของแล้วตามเอกสาร ใช่หรือไม่";
		bootbox.confirm(message, function(result) {
			var currentForm = this;
			if (result) {
				var stot_id = document.getElementsByName('stot_id');
				var remark = document.getElementById('transfer_remark').value;
				var stot_array = new Array();
				for(var i =0; i<stot_id.length; i++) {
					stot_array[i] = stot_id[i].value;
				}

				if(stot_array.length>0) {
					$.ajax({
							type : "POST" ,
							url : "<?php echo site_url("tp_delivery/save_confirm_sent"); ?>" ,
							data : {stot_array: stot_array, remark: remark} ,
							dataType: 'json',
							success : function(data) {
									if (data == 0) {
											alert("ไม่สามารถยืนยันการส่งของได้");
											document.getElementById("savebtn").disabled = false;
									}else{
											alert("ระบบทำการยืนยันการส่งสินค้าแล้ว");
											location.reload();
									}

							},
							error: function (textStatus, errorThrown) {
									alert("เกิดความผิดพลาด !!!");
									document.getElementById("savebtn").disabled = false;
							}
					});
				}
			}

		});


	}
}

</script>
</body>
</html>
