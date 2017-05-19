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

            <h1>ขอคืนสินค้าจากการสั่งขาย</h1>
        </section>

		<section class="content">
		<div class="row">
            <div class="col-xs-12">
                <div class="panel panel-danger">
                    <?php if ($this->session->flashdata('showresult') == 'success') echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>';
						  else if ($this->session->flashdata('showresult') == 'fail') echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';

					?>
					<div class="panel-heading"><strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง *</strong></div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <form action="<?php echo site_url("tp_stock_return/return_request_select_item"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่ขอคืนสินค้า
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $currentdate; ?>">
                                    </div>
							</div>
                            <div class="col-md-3">
                              <div class="form-group-sm text-red">
                                      เลขที่ใบสั่งขาย
                                      <input type="hidden" name="so_id" id="so_id" value="">
                                      <input type="text" class="form-control" name="so_number" id="so_number" value="" placeholder="** เฉพาะการสั่งขาย SO-HOxxx เท่านั้น**">
                              </div>
							</div>

						</div>
                        <br>
                        <div name="submit1" class="row">
							<div class="col-md-6">
									<button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-share'></i>  เลือกสินค้า </button>
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
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    get_datepicker("#datein");

    //Initialize Select2 Elements
    $(".select2").select2();
});

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

function submitform()
{
    if (document.getElementById('datein').value == "") {
      alert("กรุณาเลือกวันที่ขอคืนสินค้า !!");
      document.getElementById('datein').focus();
    }else if (document.getElementById('so_number').value == "") {
      alert("กรุณาใส่เลขที่ใบสั่งขาย !!");
      document.getElementById('so_number').focus();
    }else{
      var so_number = document.getElementById('so_number').value;

      $.ajax({
          type : "POST" ,
          url : "<?php echo site_url("tp_stock_return/check_so_number"); ?>" ,
          data : {so_number: so_number},
          success : function(data) {
              if(data == 0)
              {
                alert("เลขที่เอกสาร "+so_number+" ไม่สามารถขอคืนสินค้าได้ !!");
                document.getElementById('so_number').focus();
              }else{
                document.getElementById('so_id').value = data;
                document.getElementById("form1").submit();
              }
          }
      });

    }

}

</script>
</body>
</html>
