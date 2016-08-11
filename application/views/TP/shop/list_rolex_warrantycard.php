<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<body class="skin-red">
    <div class="wrapper">
    <?php $this->load->view('menu'); ?>
    
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แสดงใบรับประกันที่ถูกรูดแล้ว
        </h1>
    </section>
    
    <section class="content">        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="<?php echo site_url("pos/list_rolex_warrantycard"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
                        <div class="form-group-sm">
                                <label class="col-sm-2 control-label">เลือกเดือน</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $currentdate; ?>" onChange="submitform();" autocomplete="off" readonly>
                            </div>  
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>รายการใบรับประกันที่ถูกรูดแล้วของเดือน <?php echo $month; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th>วันที่รูด</th>
                                        <th>RMC</th>
                                        <th>Serial No.</th>
                                        <th>Description</th>
                                        <th>Family</th>
                                        <th>Bracelet</th>
                                        <th>โดย</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach($warranty_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->rowa_issuedate; ?></td>
                                        <td><?php echo $loop->it_refcode; ?></td>
                                        <td><?php echo $loop->rowa_serial_number; ?></td>
                                        <td><?php echo $loop->it_short_description; ?></td>
                                        <td><?php echo $loop->it_model; ?></td>
                                        <td><?php echo $loop->it_remark; ?></td>
                                        <td><?php echo $loop->firstname." ".$loop->lastname; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        
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
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript">
$(document).ready(function()
{    

    get_datepicker_month("#datein");

    var oTable = $('#tablefinal').DataTable();
    $('#fancyboxall').fancybox({ 
    'width': '40%',
    'height': '70%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
    
    
});
    
function submitform()
{
    document.getElementById("form1").submit();
}

function get_datepicker_month(id)
{
    $(id).datepicker({ language:'th-th',format: "mm/yyyy", viewMode: "months", 
    minViewMode: "months" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
</script>
</body>
</html>