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
    <?php $url = site_url("task/finishtask_today"); 
        $url2 = site_url("task/canceltask_today"); 
        $url3 = site_url("task/gottask_notification");
    ?>
	
	
	
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Team Tasks
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

        <!-- TO DO List -->
              <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-skyatlas"> Today</i> 
                    <a class="btn btn-primary pull-right" href="<?php echo site_url("task/addtask"); ?>"><i class="fa fa-plus"></i> เพิ่มงานใหม่</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                  <ul class="todo-list">
                <?php if(isset($task_array)) { foreach($task_array as $loop) { ?>
                    <li class="primary">
                      <span class="text">
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <span class="text">
                    <?php                                                 
                        echo "<text class='text-maroon'>Owner: ".$loop->firstname." ".$loop->lastname."</text> - <u>".$loop->topic."</u> - ".$loop->detail;
                        echo " <text class='text-green'>[".$loop->name."]</text>";
                    ?>
                      </span>
                      <!-- Emphasis label -->
                        <?php if ($loop->userid!=$loop->assign) { ?>
                      <small class="label label-danger"><i class="fa fa-clock-o"></i> Urgent</small>
                        <?php } ?>
                      <!-- General tools such as edit or delete-->
                      
                    </li>
                <?php } } ?>
                  </ul>
                <hr>
                    <h3 class='text-red'>Late</h3>
                  <ul class="todo-list">
                <?php if(isset($tasklate_array)) { foreach($tasklate_array as $loop) { ?>
                    <li class="danger">
                      <span class="text">
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <span class="text">
                    <?php                                                 
                        echo "<text class='text-maroon'>Owner: ".$loop->firstname." ".$loop->lastname."</text> - <u>".$loop->topic."</u> - ".$loop->detail;
                        echo " <text class='text-green'>[".$loop->name."]</text>";                 
                    ?>
                        <?php
                         echo "<text class='text-blue'><small>วันที่เสร็จสิ้น : ".$loop->dateon." </small></text>";
                        ?>
                      </span>
                      <!-- Emphasis label -->
                        <?php if ($loop->userid!=$loop->assign) { ?>
                      <small class="label label-danger"><i class="fa fa-clock-o"></i> Urgent</small>
                        <?php } ?>
                      <!-- General tools such as edit or delete-->
                      
                    </li>
                <?php } } ?>
                  </ul>
                <hr>
                    <h3 class='text-aqua'>Tomorrow</h3>
                  <ul class="todo-list">
                <?php if(isset($tasktomorrow_array)) { foreach($tasktomorrow_array as $loop) { ?>
                    <li class="info">
                      <span class="text">
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <span class="text">
                    <?php                                                 
                        echo "<text class='text-maroon'>Owner: ".$loop->firstname." ".$loop->lastname."</text> - <u>".$loop->topic."</u> - ".$loop->detail;
                        echo " <text class='text-green'>[".$loop->name."]</text>";                 
                    ?>
                      </span>
                      <!-- Emphasis label -->
                        <?php if ($loop->userid!=$loop->assign) { ?>
                      <small class="label label-danger"><i class="fa fa-clock-o"></i> Urgent</small>
                        <?php } ?>
                      <!-- General tools such as edit or delete-->
                      
                    </li>
                <?php } } ?>
                  </ul>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                  
                </div>
              </div><!-- /.box -->

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
    get_datepicker("#startdate");
    get_datepicker("#enddate");
    
    $('#fancyboxall').fancybox({ 
    'width': '60%',
    'height': '60%', 
    'autoScale':false,
    'transitionIn':'none', 
    'transitionOut':'none', 
    'type':'iframe'}); 
});

function got_confirm(val1) {
    var myurl = <?php echo json_encode($url3); ?>;
    window.location.replace(myurl+"/"+val1);
}

function get_datepicker(id)
{

	$(id).datepicker({ language:'th-th',format:'dd/mm/yyyy'
		    });

}
    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[rel=tooltip]",
        container: "body"
    })
</script>
</body>
</html>