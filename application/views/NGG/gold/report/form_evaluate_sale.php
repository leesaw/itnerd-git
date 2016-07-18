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
    <section class="content">
        <h1>ระบบจัดการร้าน NGG | <span class="text-blue">รายงาน (Report)</span></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">รายงานประเมินและเป้าหมายการขาย</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>สาขา</label>
                                <select class="form-control" name="shopid" id="shopid" onchange="selectShop()">
                                    <option value='-1'>-- เลือกสาขา --</option>
                                <?php   if(is_array($shop_array)) {
                                        foreach($shop_array as $loop){
                                            echo "<option value='".$loop->sh_id."'>".$loop->sh_name."</option>";
                                 } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>พนักงานขาย</label>
                                <select class="form-control" name="salepersonid" id="salepersonid">
                                    <option value='-1'>-- เลือกพนักงานขาย --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>เดือน</label>
                            <input type="text" class="form-control" name="month" id="month" value="<?php echo $month; ?>">
                            </div>
                        </div>
                        </div>
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" onclick="submit_value()">แสดงรายงาน</button>
                        </div>
                    </div>


                    </div>
                    
                    
                </div>
            </div>
        </div>

    </section>
    </div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    get_datepicker_month("#month");
});

function selectShop()
{
    var select_value = document.getElementById("shopid").value;
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("ngg_saleperson/select_option_saleperson_shop"); ?>" ,
        data : {shopid: select_value },
        success : function(data) {
            if(data != "")
            {
                $('#salepersonid').find('option').remove().end().append('<option value="-1">-- เลือกพนักงานขาย --</option>');
                var element = data;
                $("#salepersonid").append(element);
            }else{
                //alert("ไม่พบพนักงาน");
                $('#salepersonid').find('option').remove().end().append('<option value="-1">-- เลือกพนักงานขาย --</option>');
            }
        },
        error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
    });
}

function get_datepicker_month(id)
{
    $(id).datepicker({ language:'th-th',format: "mm/yyyy", viewMode: "months", 
    minViewMode: "months" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}

function submit_value()
{
    var shopid = document.getElementById("shopid").value;
    var salepersonid = document.getElementById("salepersonid").value;
    var month = document.getElementById("month").value;

    if (salepersonid < 0) { alert("กรุณาเลือกพนักงานขาย !!");
    }else if(month == "") {
        alert("กรุณาเลือกเดือน !!");
        document.getElementById('month').focus();
    }else{
        var method = "post"; 
        var path = "<?php echo site_url("ngg_gold/result_report_evaluate_sale"); ?>";
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "month");
        hiddenField.setAttribute("value", month);

        form.appendChild(hiddenField);

        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "shopid");
        hiddenField.setAttribute("value", shopid);
        form.appendChild(hiddenField);

        hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "salepersonid");
        hiddenField.setAttribute("value", salepersonid);
        form.appendChild(hiddenField);

        document.body.appendChild(form);
        form.submit();
    }
}
</script>
</body>
</html>