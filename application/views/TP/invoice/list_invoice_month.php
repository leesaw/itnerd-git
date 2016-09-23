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
            เอกสาร-Invoice
        </h1>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">

                        
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="<?php echo site_url("tp_invoice/list_invoice_month"); ?>" name="form1" id="form1" method="post" class="form-horizontal">
                        <div class="form-group-sm">
                                <label class="col-sm-2 control-label">เลือกเดือน</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="datein" id="datein" value="<?php echo $month; ?>" onChange="submitform();" autocomplete="off" readonly>
                            </div>  
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading">
                        <h4>Invoice ของเดือน <?php echo $month; ?></h4>
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tablefinal" width="100%">
                                <thead>
                                    <tr>
                                        <th width="80">เลขที่ Invoice</th>
                                        <th width="80">วันที่</th>
                                        <th>คลังสินค้า</th>
                                        <th>นามผู้ซื้อ</th>
                                        <th>เลขที่ใบส่งของอ้างอิง</th>
                                        <th width="80">จำนวนเงินรวม</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                
								<tbody>
                                    <?php foreach($inv_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->inv_number; ?></td>
                                        <td><?php echo $loop->inv_issuedate; ?></td>
                                        <td><?php echo $loop->wh_code."-".$loop->wh_name; ?></td>
                                        <td><?php echo $loop->inv_warehouse_detail; ?></td>
                                        <td><?php echo $loop->inv_stot_number; ?></td>
                                        <td><?php echo number_format($loop->sum_netprice, 2, '.', ','); ?></td>
                                        <td><a href="<?php echo site_url("tp_invoice/view_invoice")."/".$loop->inv_id; ?>" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-info-sign"></span></a> 
                                        </td>
                                    </tr>
                                    <?php } ?>
								</tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align:right">จำนวนเงินรวมทั้งหมด:</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
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
    
    get_datepicker("#datein");

    var oTable = $('#tablefinal').DataTable( {
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                (total).formatMoney(2, '.', ',')+'<br>('+(pageTotal).formatMoney(2, '.', ',')+')'
            );
        }
    } );


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
    $(id).datepicker({ language:'th-th',format: "mm/yyyy", viewMode: "months", 
    minViewMode: "months" }).on('changeDate', function(ev){
    $(this).datepicker('hide'); });
}
    
function submitform()
{
    document.getElementById("form1").submit();
}

Number.prototype.formatMoney = function(c, d, t){
    var n = this, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
     };
</script>
</body>
</html>