<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link href="<?php echo base_url(); ?>plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css" />
<style>
.ui-autocomplete {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    float: left;
    display: none;
    min-width: 160px;
    _width: 160px;
    padding: 4px 0;
    margin: 2px 0 0 0;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-color: rgba(0, 0, 0, 0.2);
    border-style: solid;
    border-width: 1px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -webkit-background-clip: padding-box;
    -moz-background-clip: padding;
    background-clip: padding-box;
    *border-right-width: 2px;
    *border-bottom-width: 2px;
}
.ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
}
.ui-state-hover, &.ui-state-active {
      color: #ffffff;
      text-decoration: none;
      background-color: #0088cc;
      border-radius: 0px;
      -webkit-border-radius: 0px;
      -moz-border-radius: 0px;
      background-image: none;
    }
</style>
</head>

<body class="skin-red">
<div class="wrapper">
	<?php $this->load->view('menu'); ?>

<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ตรวจสอบ ประวัติลูกค้า
        </h1>
    </section>
	<!-- Main content -->
    <section class="content">
		<div class="row">
            <div class="col-md-10">
                <div class="box box-danger">

        <div class="box-body">
        <div class="row">
          <form action="<?php echo site_url("pos/result_customer_history"); ?>" method="POST">
            <div class="col-md-3">
                เบอร์ติดต่อของลูกค้า
                <input type="text" class="form-control" name="custelephone" id="custelephone" placeholder="ใส่เฉพาะตัวเลขเท่านั้น 0812345678">
            </div>
            <div class="col-md-4">
                ชื่อ-นามสกุลของลูกค้า
                <input type="text" class="form-control" name="cusname" id="cusname">
            </div>
            <div class="col-md-2">
              <br>
              <input type="submit" class="btn btn-primary btn-block" id="btnSearch" value="ค้นหา">
            </div>
          </form>
        </div>


					</div>
                </div>
            </div>
        </div>


        <!-- <div class="row">
                <div class="col-md-10">
                    <div class="panel panel-primary">
                      <div class="panel-heading">ประวัติลูกค้า</div>
            <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                  ชื่อนามสกุลของลูกค้า
                  <input type="text" class="form-control" name="cusname_view" id="cusname_view" readonly>
              </div>
              <div class="col-md-4">
                  เบอร์ติดต่อของลูกค้า
                  <input type="text" class="form-control" name="custelephone_view" id="custelephone_view" readonly>
              </div>
            </div>


    					</div>
                    </div>
                </div>
            </div> -->
        </section>



</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>plugins/jQueryUI/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript">

$(document).ready(function()
{
    $("#cusname").autocomplete({
      source: "<?php echo site_url("sale/get_customer_name"); ?>" // path to the get_birds method
    });
    $('#fancyboxall').fancybox({
    'width': '40%',
    'height': '70%',
    'autoScale':false,
    'transitionIn':'none',
    'transitionOut':'none',
    'type':'iframe'});
});

</script>
</body>
</html>
