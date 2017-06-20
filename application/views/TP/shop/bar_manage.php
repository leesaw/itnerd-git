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
        <section class="content-header">

            <h1>จัดการข้อมูล Bar ห้าง</h1>
        </section>

		<section class="content">
		<div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

        <div class="box-body">
        <div class="row">
            <div class="col-xs-1 col-md-2">
                <a href="<?php echo site_url("shop/form_new_bar"); ?>"><button type="button" name="addnew" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> เพิ่ม Bar ใหม่</button></a>
            </div>
        </div>

					</div>
                </div>
            </div>
        </div>

        <div class="row">
			<div class="col-xs-12">
                <div class="panel panel-primary">
					<div class="panel-heading">Bar ห้าง</div>
                    <div class="panel-body">
                            <table class="table table-bordered table-striped" id="itemtable" width="100%">
                                <thead>
                                    <tr>
										<th>Bar</th>
                    <th>ชื่อ Bar</th>
                                        <th>Shop Group</th>
                                        <th>ยี่ห้อ</th>
                                        <th>ส่วนลด %</th>
                                        <th>GP %</th>
                                        <th width="80">Status</th>
										<th width="80"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($shop_array as $loop) { ?>
                                    <tr>
                                        <td><?php echo $loop->sb_number.'</b>'; ?></td>
                                        <td><?php echo $loop->sb_brand_name; ?></td>
                                        <td><?php echo $loop->sg_name; ?></td>
                                        <td><?php echo $loop->br_name; ?></td>
																				<td><?php echo $loop->sb_discount_percent; ?></td>
                                        <td><?php echo $loop->sb_gp; ?></td>
                                        <td><?php
                                        if ($loop->sb_enable == 0) {
                                            echo "<button class='btn btn-xs btn-warning'>Deleted</button>";
                                        }else{
                                            echo "<button class='btn btn-xs btn-success'>OK</button>";
                                        } ?>
                                        </td>
                                        <td>
																				<a href="<?php echo site_url("shop/form_edit_bar").'/'.$loop->sb_id ?>" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="#" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="tooltip" data-target="#delete" data-placement="top" rel="tooltip" title="ลบ" onClick="del_confirm(<?php echo $loop->sb_id; ?>)"><span class="glyphicon glyphicon-remove"></span></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
							</table>
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
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
    $('#itemtable').dataTable();

});
// tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[rel=tooltip]",
        container: "body"
    })

function del_confirm(val1) {
	bootbox.confirm("ต้องการลบข้อมูลที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = "<?php echo site_url("shop/disable_bar"); ?>";
            	if (result) {
					window.location.replace(myurl+"/"+val1);
				}

		});

}
</script>
</body>
</html>
