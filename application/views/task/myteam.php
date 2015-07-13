<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/fancybox/jquery.fancybox.css" >
<link href="<?php echo base_url(); ?>plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css" >
<style type="text/css">
.datepicker {z-index: 1151 !important;}
</style>
</head>

<body class="skin-purple">
	<div class="wrapper">
	<?php $this->load->view('menu'); ?>

	
	
	
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            My Team
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-10">
                  <!-- USERS LIST -->
                  <div class="box box-danger">
                    <div class="box-body no-padding">
                      <ul class="users-list clearfix">
                          <?php if (isset($user_array)) { foreach($user_array as $loop) { ?>
                        <li>
                          <img src="<?php echo base_url(); ?>dist/img/user.png" width="100" height="100" />
                          <a class="users-list-name" href="<?php echo site_url("task/viewtask_myteam/".$loop->id); ?>"><?php echo $loop->firstname." ".$loop->lastname; ?></a>
                        </li>
                          <?php } } ?>
                      </ul><!-- /.users-list -->
                    </div><!-- /.box-body -->
                  </div><!--/.box -->
                </div><!-- /.col -->
                </div>
        </section>
          
          
          
      </div>
	</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/bootbox.min.js"></script>
<script type="text/javascript">

$(function () {
"use strict";


});
    
$(document).ready(function()
{

});
</script>
</body>
</html>