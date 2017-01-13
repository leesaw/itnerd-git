<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
</head>

<body class="skin-red">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ผลการค้นหา Serial Number : <?php echo $serial; ?>
        </h1>
    </section>

	<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-danger">


        <div class="box-body">

        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-success">
					<div class="panel-heading">
                        ข้อมูลสินค้า
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table" id="tablebarcode" width="100%">
                                <thead>
                                    <tr>
                                        <th>Serial No.</th>
                                        <th>Brand</th>
                                        <th width="120">Ref. Number</th>
                                        <th>Family</th>
                                        <th>Description</th>
                                        <th>SRP</th>
                                        <th>Warehouse</th>
                                        <th width="100">สถานะ</th>
                                    </tr>
                                </thead>
								<tbody>
                                <?php foreach($stock_array as $loop) { ?>
                                    <tr>
                                    <td><?php echo $loop->itse_serial_number; if ($loop->itse_sample > 0) echo "(Sample)"; ?></td>
                                    <td><?php echo $loop->br_name; ?></td>
                                    <td><?php echo $loop->it_refcode; ?></td>
                                    <td><?php echo $loop->it_model; ?></td>
                                    <td><?php echo $loop->it_short_description; ?></td>
                                    <td><?php echo $loop->it_srp; ?></td>
                                    <td><?php echo $loop->wh_code."-".$loop->wh_name; ?></td>
                                    <td><?php
                                        if ($loop->itse_enable == 0)
                                            echo "<a href='#'><button class='btn btn-danger btn-xs'>ขาย หรือ เอาออกจากคลังแล้ว</button></a>";
                                        else
                                            echo "<a href='#'><button class='btn btn-primary btn-xs'>อยู่ในคลังสินค้า</button></a>";
                                        ?>

                                    </td>
                                    </tr>
                                <?php } ?>
								</tbody>
							</table>

					</div>

				</div>
			</div>

		</div>
        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-default">
					<div class="panel-heading">
                        ข้อมูลการย้ายคลัง
                    </div>
                    <div class="panel-body table-responsive">
                            <table class="table table-hover" id="tabletransfer" width="100%">
                                <thead>
                                    <tr>
                                        <th width="80">วันที่กำหนดส่ง</th>
                                        <th width="100">เลขที่ย้ายคลัง</th>
                                        <th width="120">Ref. Number</th>
                                        <th width="100">Serial</th>
                                        <th>ออกจากคลัง</th>
                                        <th>เข้าคลัง</th>
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
        <div class="row">
            <div class="col-xs-12">
            <a href="<?php echo site_url("warehouse/getBalance"); ?>" class="btn btn-primary">ค้นหา</a>
            </div>
        </div>




					</div>
                </div>
            </div>
        </div>
        </section>
		</div>


	</div>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" data-dismiss="modal">
    <div class="modal-content"  >
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables2.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    var oTable = $('#tabletransfer').DataTable({
        "bProcessing": true,
        'bServerSide'    : false,
        "bDeferRender": true,
        'sAjaxSource'    : '<?php echo site_url("warehouse_transfer/ajaxView_seach_transfer_serial")."/".$serial; ?>',
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success":fnCallback

            });
        }
    });

    $('#fancyboxall').fancybox({
    'width': '30%',
    'height': '80%',
    'autoScale':false,
    'transitionIn':'none',
    'transitionOut':'none',
    'type':'iframe'});


});

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
