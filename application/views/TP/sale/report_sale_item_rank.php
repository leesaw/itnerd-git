<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body class="skin-red">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>
	
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sale Report
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

<?php foreach($brand_array as $loop) { if ($loop->br_name =="สินค้าซ่อม") continue; $brand_list[] = array("br_id" => $loop->br_id, "br_name" => $loop->br_name); } ?>
                        
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo site_url("sale/report_sale_item_rank"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
                        <div class="form-group-sm">
                                <label class="col-sm-4 control-label">จำนวนที่ขายระหว่างวันที่</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="startdate" id="startdate" value="<?php echo $startdate; ?>" autocomplete="off" readonly>
                            </div>  
                            <label class="col-sm-1 control-label"> ถึง </label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="enddate" id="enddate" value="<?php echo $enddate; ?>" autocomplete="off" readonly>
                            </div>  
                            <div class="col-sm-2">
                                <input type="submit" class="btn btn-primary" value="Filter">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-success">
                    <div class="panel-body table-responsive">
                        <?php for($i=0; $i<count($brand_list); $i++) { if ($i%3 == 0) echo "<div class='row'>"; ?>
                            <div class="col-xs-4">
                                <table class="table table-bordered" id="tablebarcode" width="100%">
                                    <thead>
                                    <tr><th colspan="3" style="text-align: center;background-color:#f1f1f1"><?php echo $brand_list[$i]["br_name"]; ?></th></tr>
                                    <tr><th width="30">No.</th><th>Description</th><th width="50">จำนวน</th></tr>
                                    </thead>
                                    <tbody>
                                    <?php $rank = ${"rank_brand".$brand_list[$i]["br_id"]}; $no = 1; 
                                        foreach($rank as $loop) {
                                            echo "<tr><td>".$no."</td><td>".$loop->it_refcode;
                                            if ($loop->it_refcode!=$loop->it_model) echo " ".$loop->it_model;
                                            echo "</td><td>".$loop->sum1."</td></tr>";
                                            $no++;
                                        }

                                        if ($no == 1) echo "<tr><td colspan='3' style='text-align: center;color:#ff0000'>No Bill</td></tr>";
                                     ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php if ($i%3 == 2) echo "</div>"; } ?>
                        
                    </div>
                    
                </div>
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
<script type="text/javascript">
    
$(document).ready(function()
{    
    //Initialize Select2 Elements
    $(".select2").select2();
    
    get_datepicker("#startdate");
    get_datepicker("#enddate");
    get_datepicker("#startdate_count");
    get_datepicker("#enddate_count");
    
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
});
    
function get_datepicker(id)
{
    $(id).datepicker({ language:'th-th',format: "dd/mm/yyyy" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });

}
</script>
</body>
</html>