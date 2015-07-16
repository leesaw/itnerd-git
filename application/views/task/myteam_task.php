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
	<?php $url = site_url("task/ringtask_member"); 
    ?>
	
<?php
/*
    $status_graph = array();
    $sum_month = 0;
    foreach($dataset_6month as $loop) {
        $status_graph[] = array($loop->month."-".$loop->year, $loop->ontime, $loop->late);
        $sum_month++;
    }
*/
?>
	
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $firstname." ".$lastname; ?>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!--
            <div class="row">
                <div class="col-md-10">
                 <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">6 เดือนล่าสุด</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div>
                    <div class="box-body chart-responsive">
                      <div class="chart" id="line-chart" style="height: 300px;"></div>
                    </div>
                  </div>
                </div>
            </div>
        -->
        <!-- TO DO List -->
              <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-skyatlas"> Today</i> 
                </div><!-- /.box-header -->
                <div class="box-body">
                
                  <ul class="todo-list">
                <?php if(isset($task_array)) { foreach($task_array as $loop) { ?>
                    <li class="primary">
                      <div class="tools">
                        <?php if ($loop->ring>0) echo "[".$loop->ring."]"; ?><i class="fa fa-bell-o" onClick="ring(<?php echo $loop->task_id; ?>)"></i>
                      </div>
                      <span class="text">
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <span class="text">
                    <?php                                                 
                        echo "<u>".$loop->topic."</u> - ".$loop->detail;
                        echo " <text class='text-green'>[".$loop->name."]</text>";
                    ?>
                      </span>
                      <!-- Emphasis label -->
                        <?php if ($loop->userid!=$loop->assign) { ?>
                      <small class="label label-danger"><i class="fa fa-clock-o"></i> Urgent</small>
                        <?php } ?>
                        <?php if ($loop->datecomplete!=0) { ?>
                      <small class="label label-warning"><i class="fa fa-backward"></i> Return</small>
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
                      <div class="tools">
                        <?php if ($loop->ring>0) echo "[".$loop->ring."]"; ?><i class="fa fa-bell-o" onClick="ring(<?php echo $loop->task_id; ?>)"></i>
                      </div>
                      <span class="text">
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <span class="text">
                    <?php                                                 
                        echo "<u>".$loop->topic."</u> - ".$loop->detail;
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
                        <?php if ($loop->datecomplete!=0) { ?>
                      <small class="label label-warning"><i class="fa fa-backward"></i> Return</small>
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
                      <div class="tools">
                        <?php if ($loop->ring>0) echo "[".$loop->ring."]"; ?><i class="fa fa-bell-o" onClick="ring(<?php echo $loop->task_id; ?>)"></i>
                      </div>
                      <span class="text">
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <span class="text">
                    <?php                                                 
                        echo "<u>".$loop->topic."</u> - ".$loop->detail;
                        echo " <text class='text-green'>[".$loop->name."]</text>";                 
                    ?>
                      </span>
                      <!-- Emphasis label -->
                        <?php if ($loop->userid!=$loop->assign) { ?>
                      <small class="label label-danger"><i class="fa fa-clock-o"></i> Urgent</small>
                        <?php } ?>
                        <?php if ($loop->datecomplete!=0) { ?>
                      <small class="label label-warning"><i class="fa fa-backward"></i> Return</small>
                        <?php } ?>
                      <!-- General tools such as edit or delete-->
                      
                    </li>
                <?php } } ?>
                </ul>
                <hr>
                    <h3 class='text-orange'>Next Task</h3>
                  <ul class="todo-list">
                <?php if(isset($tasknext_array)) { foreach($tasknext_array as $loop) { ?>
                    <li class="warning">
                      <!-- drag handle -->
                      <div class="tools">
                        <?php if ($loop->ring>0) echo "[".$loop->ring."]"; ?><i class="fa fa-bell-o" onClick="ring(<?php echo $loop->task_id; ?>)"></i>
                      </div>
                      <span class="text">
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- todo text -->
                      <span class="text">
                    <?php                                                 
                        echo "<u>".$loop->topic."</u> - ".$loop->detail; 
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
                        <?php if ($loop->datecomplete!=0) { ?>
                      <small class="label label-warning"><i class="fa fa-backward"></i> Return</small>
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
<script src="<?php echo base_url(); ?>plugins/morris/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/morris.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(function () {
"use strict";
/*
    // LINE CHART
        var line = new Morris.Line({
          element: 'line-chart',
          resize: true,
          data: [
            <?php for($i=0; $i<$sum_month; $i++) { ?>
            {y: <?php echo json_encode($status_graph[$i][0]); ?>, item1: <?php echo json_encode($status_graph[$i][1]); ?>, item2: <?php echo json_encode($status_graph[$i][2]); ?>},
             <?php } ?>
          ],
          xkey: 'y',
          ykeys: ['item1', 'item2'],
          labels: ['เสร็จตรงเวลา', 'เสร็จเกินเวลา'],
          lineColors: ['#3c8dbc'],
          hideHover: 'auto'
        });
    */
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

function ring(val1) {
    bootbox.confirm("ยืนยันการเตือน ใช่หรือไม่ ?", function(result) {
        var currentForm = this;
        var myurl = <?php echo json_encode($url); ?>;
        var userid = <?php echo json_encode($userid); ?>;
        if (result) {
            window.location.replace(myurl+"/"+userid+"/"+val1);
        }

    });
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