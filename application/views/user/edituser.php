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
            แก้ไข User
        </h1>
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
					<form method="post" action="<?php echo site_url('login/save_edituser'); ?>" onSubmit="return chk_add_user()">
                    <div class="box-body">
                        <?php foreach($user_array as $loop) { ?>
                        <input type="hidden" name="userid" value="<?php echo $loop->id; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username *</label>
                                    <input type="text" class="form-control" name="username" id="username" value="<?php echo $loop->username; ?>" disabled>
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Firstname *</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $loop->firstname; ?>">
                                </div>
							</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lastname *</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $loop->lastname; ?>">
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <input type="text" class="form-control" name="status" id="status" value="<?php echo $loop->status; ?>">
                                </div>
							</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Team ID *</label>
                                    <input type="text" class="form-control" name="team_id" id="team_id" value="<?php echo $loop->team_id; ?>">
                                </div>
							</div>
                        </div>
                        <?php } ?>
					</div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-lg">  <i class="fa fa-floppy-o"></i> &nbsp;&nbsp; <b>Save</b>  &nbsp; &nbsp; </button>&nbsp; &nbsp; &nbsp; &nbsp; 
                        <button type="button" class="btn btn-warning btn-lg" onClick="window.location.href='<?php echo site_url("login/users"); ?>'"> <i class="fa fa-reply"></i> &nbsp;&nbsp; <b>Back</b> </button>
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

        function chk_add_user()
		{
            var username=$('#username').val();
            if(username==""){
                alert('กรุณาป้อน Username');
                $('#username').focus();
                return false;
            }

            var password1=$('#password1').val();
            var password2=$('#password2').val();
            if(password1!=password2){
                alert('กรุณาป้อน Password ให้เหมือนกัน');
                $('#password1').focus();
                return false;
            }
            
            var status=$('#status').val();
            if(status==""){
                alert('กรุณาป้อน Status');
                $('#status').focus();
                return false;
            }
            
            var team_id=$('#team_id').val();
            if(team_id==""){
                alert('กรุณาป้อน Team ID');
                $('#team_id').focus();
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