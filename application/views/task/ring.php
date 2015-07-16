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
    <?php $url = site_url("task/unring"); 
    ?>
	
	
	
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <i class="fa fa-bell-o"> Reminder</i>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

        <!-- TO DO List -->
              <div class="box box-warning">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                
                  <ul class="todo-list">
                <?php if(isset($ring_array)) { foreach($ring_array as $loop) { 
                      
                    for($i=0; $i<$loop->ring; $i++) {   
                        if ($loop->status == 5) { echo "<li class='danger'>"; }
                        else { echo "<li class='warning'>"; }
                ?>
                      <!-- drag handle -->
                      <div class="tools">
                        <i class="fa fa-bell-slash-o" onClick="got_confirm(<?php echo $loop->task_id; ?>)"></i>
                      </div>
                      <span class="text">
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <span class="text">
                    <?php                 
                        if ($loop->status == 5) echo "<a href='".site_url('task/notification')."' class='text-red'>(Notification)</a> ";
                        echo "<u>".$loop->topic."</u> - ".$loop->detail; 
                        echo " <text class='text-green'>[".$loop->name."]</text>";                 
                    ?>
                      
                        <?php
                         echo "<text class='text-blue'><small>วันที่เสร็จสิ้น : ".$loop->dateon." </small></text>";
                        ?>
                      <!-- General tools such as edit or delete-->
                      </span>
                    </li>
                <?php } } } ?>
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
    var myurl = <?php echo json_encode($url); ?>;
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