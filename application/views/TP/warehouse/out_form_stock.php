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

            <h1>เอาสินค้าออกจากคลัง</h1>
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
                                <form action="<?php echo site_url("warehouse_transfer/out_stock_select_item"); ?>" name="form1" id="form1" method="post">
                                    <div class="form-group-sm">
                                            วันที่เอาออก
                                            <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $currentdate; ?>">
                                    </div>
							</div>
                            <div class="col-md-3">
									<div class="form-group-sm">
                                        ออกจากคลัง *
                                        <select class="form-control select2" name="whid_out" id="whid_out" style="width: 100%;">
                                            <option value='-1'>-- เลือกคลังสินค้า --</option>
										<?php 	if(is_array($wh_out)) {
												foreach($wh_out as $loop){
													echo "<option value='".$loop->wh_id."#".$loop->wh_code."-".$loop->wh_name."'>".$loop->wh_code."-".$loop->wh_name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
                            
                            <div class="col-md-3">
                                <?php if ($sessrolex != 1) { ?>
                                <input type="radio" name="watch_luxury" id="watch_luxury" value="0" <?php if(($remark=='0') || (!isset($remark))) echo "checked"; ?>> <label class="text-green"> No Caseback</label>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                <?php } ?>
              <input type="radio" name="watch_luxury" id="watch_luxury" value="1" <?php if ($remark=='1') echo "checked"; ?>> <label class="text-red"> Caseback</label>
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
    if (document.getElementById('whid_out').value < 0) {
        alert("กรุณาเลือกคลังสินค้า");
        document.getElementById('whid_out').focus();
    }else if (document.getElementById('datein').value == "") {
        alert("กรุณาเลือกวันที่เอาออก");
        document.getElementById('datein').focus();
    }else{
        document.getElementById("form1").submit();
    }

}

</script>
</body>
</html>
