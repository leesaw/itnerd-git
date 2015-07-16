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

<?php
	$team_graph = array();
    $count1 = 0;
    foreach($dataset_month as $loop) {
        $team_graph[] = array($loop->firstname." ".$loop->lastname, $loop->doing, $loop->ontime, $loop->late, $loop->reject, $loop->longtime);
        $count1++;
    }

    $status_graph = array();
    $sum_task = 0;
    $late_task = 0;
    foreach($dataset_status as $loop) {
        $status_graph[] = array($loop->doing, $loop->ontime, $loop->late, $loop->reject);
        $sum_task = $loop->doing + $loop->ontime + $loop->late + $loop->reject;
        $late_task = $loop->longtime;
    }
?>
	
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
                <div class="col-md-8">
                  <!-- USERS LIST -->
                  <div class="box box-danger">
                    <div class="box-body no-padding">
                      <ul class="users-list clearfix">
                          <?php if (isset($user_array)) { foreach($user_array as $loop) { ?>
                        <li>
                          <img src="<?php echo base_url(); ?>dist/img/user.png" width="80" height="80" />
                          <a class="users-list-name" href="<?php echo site_url("task/viewtask_myteam/".$loop->id); ?>"><?php echo $loop->firstname." ".$loop->lastname; ?></a>
                        </li>
                          <?php } } ?>
                      </ul><!-- /.users-list -->
                    </div><!-- /.box-body -->
                  </div><!--/.box -->
                </div><!-- /.col -->
            <div class="col-md-4">
            <!-- BAR CHART -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">งานทั้งหมดในเดือน <?php echo date("F Y")." <u>จำนวน ".$sum_task." งาน</u> <br> <text class='text-red'>งานค้าง ".$late_task." งาน</text>"; ?> </h3>
                </div>
                <div class="box-body chart-responsive">
                  <div class="chart" id="status-chart" style="height: 200px;"></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
                </div>
                </div>
            <div class="row">
                <div class="col-md-12">
            <!-- BAR CHART -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">จำนวนงานของคนในทีมเดือน <?php echo date("F Y"); ?> </h3>
                </div>
                <div class="box-body chart-responsive">
                  <div class="chart" id="bar-chart" style="height: 350px;"></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
                </div>
            </div>
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
    
    //BAR CHART
        var bar = new Morris.Bar({
          element: 'bar-chart',
          resize: true,
          data: [
              <?php for($i=0; $i<$count1; $i++) { ?>
            {y: <?php echo json_encode($team_graph[$i][0]); ?>, a: <?php echo json_encode($team_graph[$i][1]); ?>, b: <?php echo json_encode($team_graph[$i][2]); ?>, c: <?php echo json_encode($team_graph[$i][3]); ?>, d: <?php echo json_encode($team_graph[$i][4]); ?>, e: <?php echo json_encode($team_graph[$i][5]); ?> },
              <?php } ?>
          ],
          barColors: ['#5555FF','#00a65a', '#f56954', '#F2F5A9', '#FF0000'],
          xkey: 'y',
          ykeys: ['a', 'b', 'c', 'd', 'e'],
          labels: ['กำลังทำ', 'เสร็จตรงเวลา', 'เสร็จเกินเวลา', 'ต้องแก้ไข', 'งานค้าง'],
          hideHover: 'auto',
          parseTime: false,
          xLabelAngle: 30
        });
    
    //DONUT CHART
        var donut = new Morris.Donut({
          element: 'status-chart',
          resize: true,
          colors: ['#5555FF','#00a65a', '#f56954', '#F2F5A9'],
          data: [
            {label: "กำลังทำ", value: <?php echo json_encode($status_graph[0][0]); ?>},
            {label: "เสร็จตรงเวลา", value: <?php echo json_encode($status_graph[0][1]); ?>},
            {label: "เสร็จเกินเวลา", value: <?php echo json_encode($status_graph[0][2]); ?>},
            {label: "ต้องแก้ไข", value: <?php echo json_encode($status_graph[0][3]); ?>}
          ],
          hideHover: 'auto'
        });

});
    
$(document).ready(function()
{

});
</script>
</body>
</html>