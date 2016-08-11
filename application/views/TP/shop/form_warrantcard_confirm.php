<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">

    <?php 
        foreach($shop_array as $loop) { 
            $shopname = $loop->sh_name;
            $shopid = $loop->sh_id;
        }
    ?>
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ยืนยัน Serial Number ที่รูดแล้ว ที่สาขา <span class="text-red"><?php echo $shopname; ?></span>
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">

		<div class="row">
            <div class="col-md-10">
                <div class="box box-danger">
                        
        <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group-sm">
                        วันที่รูดใบรับประกัน
                        <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $datein; ?>">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><div class="input-group input-group-lg col-lg-6">
                        <input type="text" class="form-control" name="refcode" id="refcode" placeholder="Serial ที่รูดแล้ว">
                        <div class="input-group-btn">
                            <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shopid; ?>">
                        </div>
                        <label id="count_all" class="text-red pull-right">จำนวน &nbsp;&nbsp; 0 &nbsp;&nbsp; รายการ</label> 
                        </div></div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th>RMC</th>
                                        <th>Serial No.</th>
                                        <th>Description</th>
                                        <th>Family</th>
                                        <th>Bracelet</th>
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
        </div>  
        <br>
         <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-success" name="savebtn" id="savebtn" onclick="submitform()"><i class='fa fa-save'></i>  บันทึก </button>&nbsp;&nbsp;
                </div>
            </div>            
                        
        </form>               
                        
					</div>
                </div>
            </div>
        </div>
        </section>
          
          
          
</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>></script>
<script type="text/javascript">
var count_enter_form_input_product = 0;
var count_list = 0;

$(document).ready(function()
{    
    get_datepicker("#datein");

    $('#refcode').keyup(function(e){ //enter next
        if(e.keyCode == 13) {
            
            var product_code_value = $.trim($(this).val());
            var shop_id = document.getElementById("shop_id").value;
            if(product_code_value != "")
            {

                check_product_code(product_code_value,shop_id);
            }
            
            $(this).val('');
        
        }
    });
});

function delete_item_row(row1)
{
    count_list--;
    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
    $('#row'+row1).remove();
    setTimeout(function(){
        calSummary();
    },50);
}

function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}

function check_product_code(refcode_input, shop_id)
{
    if(refcode_input != "")
    {
        $.ajax({
            type : "POST" ,
            url : "<?php echo site_url("pos/check_rolex_detail"); ?>" ,
            data : {refcode: refcode_input, shop_id: shop_id},
            success : function(data) {
                if(data != "")
                {
                    var element = '<tr id="row'+count_enter_form_input_product+'">'+data+'<td><button type="button" id="row'+count_enter_form_input_product+'" class="btn btn-danger btn-xs" onClick="delete_item_row('+count_enter_form_input_product+');"><i class="fa fa-close"></i></button></td>'+''+'</tr>';
                    $('table > tbody').append(element);
                    count_enter_form_input_product++;
                    count_list++;
                    document.getElementById("count_all").innerHTML = "จำนวน &nbsp&nbsp "+count_list+"   &nbsp&nbsp รายการ";
                }else{
                    alert("ไม่พบ Serial ที่ต้องการในคลัง");
                }
            },
            error: function (textStatus, errorThrown) {
                alert("เกิดความผิดพลาด !!!");
            }
        });
    }

}

function submitform()
{
    var datein = document.getElementById('datein').value;
    var itse_id = document.getElementsByName('itse_id');
    if (datein == "") {
        alert("กรุณาใส่วันที่รูดใบรับประกัน");
    }else if (itse_id.length < 1) {
        alert("กรุณาใส่สินค้าที่ต้องการ");
    }else{
        var r = confirm("ยืนยันการบันทึก !!");
        if (r == true) {
            confirmform();
        }
    }
}

function confirmform()
{
    
    var shop_id = document.getElementById('shop_id').value;
    var datein = document.getElementById('datein').value;
    
    var itse_id = document.getElementsByName('itse_id');
    var it_id = document.getElementsByName('it_id');
    var itse_serial_number = document.getElementsByName('itse_serial_number');
    var it_array = new Array();
    var checked = 0;
    var index = 0;

    for(var i=0; i<it_id.length; i++){
        for(var j=0; j<index; j++) {
            if (it_id[i].value == it_array[j]['id']) {
                //it_array[j]['qty'] = parseInt(it_array[j]['qty']) + 1;
                
                if (itse_id[i].value == it_array[j]['itse_id']) {
                    alert("Serial ซ้ำกัน");
                    return;
                }
                //checked++;
            }

        }
        if (checked==0) {
            it_array[index] = {id: it_id[i].value, itse_id: itse_id[i].value, itse_serial_number: itse_serial_number[i].value};
            index++;
        }else{
            checked = 0;
        }
    }
    
    document.getElementById("savebtn").disabled = true;
    
    $.ajax({
        type : "POST" ,
        url : "<?php echo site_url("pos/save_rolex_warrantycard_confirm"); ?>" ,
        data : {datein: datein, shop_id: shop_id, item: it_array} ,
        dataType: 'json',
        success : function(data) {
            var message = "สินค้าจำนวน "+data.a+" ชิ้น  ทำการบันทึกเรียบร้อยแล้ว";
            bootbox.alert(message, function() {
                window.location = "<?php echo site_url("pos/form_rolex_warrantycard_comfirm"); ?>";
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