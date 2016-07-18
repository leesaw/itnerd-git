<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('NGG/gold/header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>สาขา</label>
                                <select class="form-control" name="shopid" id="shopid" onchange="selectShop()">
                                    <option value='-1'>-- เลือกสาขา --</option>
                                <?php   if(is_array($shop_array)) {
                                        foreach($shop_array as $loop){
                                            echo "<option value='".$loop->sh_id."'";
                                            if ($loop->sh_id==$shopid) { 
                                                echo " selected";
                                                $shopname = $loop->sh_name;
                                            }
                                            echo ">".$loop->sh_name."</option>";
                                 } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>พนักงานขาย</label>
                                <select class="form-control" name="salepersonid" id="salepersonid">
                                    <option value='-1'>-- เลือกพนักงานขาย --</option>
                                <?php   if(is_array($saleperson_array)) {
                                        foreach($saleperson_array as $loop){
                                            echo "<option value='".$loop->sp_id."'";
                                            if ($loop->sp_id==$salepersonid) { 
                                                echo " selected";
                                                $salename = $loop->sp_firstname." ".$loop->sp_lastname;
                                            }
                                            echo ">".$loop->sp_firstname." ".$loop->sp_lastname." (".$loop->sp_barcode.")"."</option>";
                                 } } ?>
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

                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">Monthly Target <b class="text-blue"><u><?php echo number_format($daily_target); ?></u></b> เดือน : <b class="text-blue"><u><?php echo $month; ?></u></b> พนักงานขาย : <b class="text-blue"><u><?php echo $salename; ?></u></b> สาขา : <b class="text-blue"><u><?php echo $shopname; ?></u></b></h3>

                      <button class="btn bg-purple pull-right" type="button" onclick="print_pdf();"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tableday" width="100%">
                                <thead>
                                    <tr>
                                        <th width="150" rowspan="2">วันที่</th>
                                        <th colspan="3" style="text-align:center">ผลลัพธ์ที่ทำสำเร็จประจำวัน</th>
                                        <th colspan="3" style="text-align:center">ผลสรุปทำสำเร็จคิดเป็นเปอเซ็นต์</th>
                                        <th rowspan="2"></th>
                                    </tr>
                                    <tr>
                                        <th>จำนวนลูกค้าที่ซื้อ</th>
                                        <th>จำนวนที่ขายสำเร็จ</th>
                                        <th>ยอดขายประจำวัน</th>
                                        <th>เป้าหมายต่อวัน</th>
                                        <th>ลูกค้าที่ซื้อ</th>
                                        <th>ยอดขาย</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                <?php 
                                $sum_customer = 0;
                                $sum_gold = 0;
                                $sum_price = 0;
                                $sum_date = 0;
                                foreach($day_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->ngw_issuedate; $sum_date++; ?></td>
                                        <td><?php echo $loop->count_customer; $sum_customer+=$loop->count_customer; ?></td>
                                        <td><?php echo $loop->count_gold; $sum_gold+=$loop->count_gold; ?></td>
                                        <td><?php echo number_format($loop->sum_price, 2, '.', ','); $sum_price += $loop->sum_price; ?></td>
                                        <td><?php echo "100%"; ?></td>
                                        <td><?php 
                                            $customer_percent = ($loop->count_customer/$daily_customer)*100;
                                            if ($customer_percent > 100) {
                                                echo "<b class='text-green'>".$customer_percent."%</b>";
                                            }else{
                                                echo "<b class='text-red'>".$customer_percent."%</b>";
                                            }

                                        ?></td>
                                        <td><?php 
                                            $price_percent = ($loop->sum_price/$daily_target)*100;
                                            if ($price_percent > 100) {
                                                echo "<b class='text-green'>".$price_percent."%</b>";
                                            }else{
                                                echo "<b class='text-red'>".$price_percent."%</b>";
                                            }

                                         ?></td>
                                         <td><a id="fancyboxall" href="<?php echo site_url("ngg_gold/view_sold_gold")."/".$loop->ngw_issuedate."/".$salepersonid; ?>" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr style="font-size:120%;" class="text-blue">
                                        <th style="text-align:right;"><label>ยอดรวมประจำเดือน:<br>(<?php echo $sum_date; ?> วัน)</th>
                                        <th><?php echo $sum_customer; ?></th>
                                        <th><?php echo $sum_gold; ?></th>
                                        <th><?php echo number_format($sum_price, 2, '.', ','); ?></th>
                                        <th>100%</th>
                                        <th><?php $sum_customer_percent = ($sum_customer/($sum_date*$daily_customer))*100; 
                                            echo number_format($sum_customer_percent, 2, '.', ',')."%"; ?></th>
                                        <th><?php $sum_price_percent = ($sum_price/($sum_date*$daily_target))*100; 
                                            echo number_format($sum_price_percent, 2, '.', ',')."%"; ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        
                            </div>

                        </div>
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </section>
    </div>
</div>

<!-- view sold product -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_return" aria-hidden="true">

      <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">                        
                    รายการสินค้าที่ขายได้ในวันที่ 
                </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
                <div class="row"><div class="col-md-12"><form class="form-horizontal"><div class="form-group"><label class="col-md-4 control-label" for="returndate_return">วันที่ส่งกลับ</label><div class="col-md-4"> <input type="text" class="form-control" id="returndate_return" name="returndate_return" value="<?php echo $rep_datereturn; ?>" /></div></div><div class="form-group"><label class="col-md-4 control-label" for="shop_return">สาขาที่ส่งกลับ</label><div class="col-md-6"><select class="form-control" name="shop_return" id="shop_return"><option value='0'>-- เลือกสาขา --</option><?php   if(is_array($shop_array)) { foreach($shop_array as $loop){ echo "<option value='".$loop->sh_id."'"; if($loop->sh_id==$rep_return_shop_id) echo " selected"; echo ">".$loop->sh_code."-".$loop->sh_name."</option>"; } } ?><option value='99999'>-- อื่น ๆ --</option></select></div> </div><div class="form-group"><label class="col-md-4 control-label" for="remark_done">Remark</label><div class="col-md-8"><input id="remark_return" name="remark_return" type="text" placeholder="" class="form-control input-md" value="<?php echo $rep_remark; ?>"></div></div></form> </div>  </div>

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
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    get_datepicker_month("#month");
    var oTable = $('#tableday').DataTable();

    $('#fancyboxall').fancybox({ 
    'width': '50%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
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

        hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "month");
        hiddenField.setAttribute("value", month);
        form.appendChild(hiddenField);


        document.body.appendChild(form);
        form.submit();
    }
}

function print_pdf()
{
    var shopid = document.getElementById("shopid").value;
    var salepersonid = document.getElementById("salepersonid").value;
    var month = document.getElementById("month").value;

    var method = "post"; 
    var path = "<?php echo site_url("ngg_gold/print_report_evaluate_sale"); ?>";
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
    form.setAttribute("target", "_blank")

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

    hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "month");
    hiddenField.setAttribute("value", month);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();
}
</script>
</body>
</html>