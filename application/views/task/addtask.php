<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css" >
</head>

<body class="skin-purple">
	<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            เพิ่มงานใหม่
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> เพิ่มงานใหม่</a></li>
        </ol>
    </section>
	
	<section class="content">
		<div class="row">
            <div class="col-lg-8">
                <div class="box box-primary">
				<?php if ($this->session->flashdata('showresult') == 'fail') {
					    echo '<div class="box-heading"><div class="alert alert-danger"> ไม่สามารถเพิ่มข้อมูลได้</div>';
						?> </div> <?php
                      }else if($this->session->flashdata('showresult') == 'true') {
                        echo '<div class="box-heading"><div class="alert alert-success"> เพิ่มข้อมูลเรียบร้อยแล้ว</div>';
                        ?> </div> 
                    <?php  } ?>
					<div class="box-header"><h4 class="box-title">* Please fill in all fields</h4> </div>
					<form method="post" action="<?php echo site_url('task/savetask'); ?>" onSubmit="return chk_add_task()">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>หัวข้องาน *</label>
                                    <input type="text" class="form-control" name="topic" id="topic" value="<?php echo set_value('topic'); ?>">
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label>ประเภทงาน *</label>
                                        <select class="form-control" name="category" id="category">
										<?php 	if(is_array($category_array)) {
												foreach($category_array as $loop){
													echo "<option value='".$loop->category_id."'>".$loop->name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
								    <label>วันที่เสร็จสิ้น * </label>
								    <input type="text" class="form-control" id="dateon" name="dateon" />
								</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>รายละเอียด *</label>
                                    <textarea type="text" class="form-control" name="detail" id="detail" value="<?php echo set_value('detail'); ?>"></textarea>
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                    <div class="form-group">
                                            <label>ผู้ปฏิบัติงาน *</label>
                                        <?php if($user_status>1) { ?>
                                            <input type="hidden" name="userid" value="<?php echo $user_id; ?>">
                                            <input type="hidden" name="assign" value="<?php echo $user_id; ?>">
                                            <input type="text" class="form-control" name="user" id="user" value="<?php echo $user_firstname." ".$user_lastname; ?>" readonly>
                                        <?php }else{ ?>
                                            <select class="form-control" name="userid" id="userid">
                                            <?php 	if(is_array($user_array)) {
                                                    foreach($user_array as $loop){
                                                        echo "<option value='".$loop->id."'>".$loop->firstname." ".$loop->lastname."</option>";
                                             } } ?>
                                            </select>
                                        <?php } ?>
                                    </div>
							</div>
                            <?php if($user_status==1) { ?>
                            <div class="col-md-4">
                                    <div class="form-group">
                                            <label>ผู้สั่งงาน *</label>
                                            <input type="hidden" name="assign" value="<?php echo $user_id; ?>">
                                            <input type="text" class="form-control" name="userassign" id="userassign" value="<?php echo $user_firstname." ".$user_lastname; ?>" readonly>
                                    </div>
							</div>
                            <?php } ?>
                        </div>
					</div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-lg">  <i class="fa fa-floppy-o"></i> &nbsp;&nbsp; <b>Save</b>  &nbsp; &nbsp; </button>&nbsp; &nbsp; &nbsp; &nbsp; 
                        <button type="button" class="btn btn-warning btn-lg" onClick="window.location.href='<?php echo site_url("main"); ?>'"> <i class="fa fa-reply"></i> &nbsp;&nbsp; <b>Back</b> </button>
                    </div>
                </div>
			</section>
		</div>
	</div>
</form>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker-thai.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/locales/bootstrap-datepicker.th.js"></script>
<script>
      $(function () {
        
        get_datepicker("#dateon");
          
        $('#dateon').on('change', function(){
            $('.datepicker').hide();
        });

      });


        $(".alert").alert();
        window.setTimeout(function() { $(".alert").alert('close'); }, 4000);
        
        function chk_add_task()
		{
            var topic=$('#topic').val();
            if(topic==""){
                alert('กรุณาป้อนหัวข้องาน');
                $('#topic').focus();
                return false;
            }

            var detail=$('#detail').val();
            if(detail==""){
                alert('กรุณาป้อนรายละเอียดงาน');
                $('#detail').focus();
                return false;
            }
		}
        

     
        
function get_datepicker(id)
{

	$(id).datepicker({ language:'th-th',format:'dd/mm/yyyy', defaultDate: new Date()
		    }).datepicker("setDate", new Date());

}
</script>
</body>
</html>