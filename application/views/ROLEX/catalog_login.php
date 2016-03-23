<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<style>
.login-page{
  background: #FFFFFF;
}
.login-box {
  width: 360px;
  margin: 7% auto;
}
</style>
</head>
<body class="login-page">
    <div class="login-box">
      <div class="login-logo">
          <b><span class="text-green">ROLEX</span> Catalog</b>
         
          
      </div><!-- /.login-logo -->
      <div class="login-box-body">
          
        <?php echo validation_errors(); ?>
          
        <form action="<?php echo site_url("catalog/verify"); ?>" method="post">
        <div class="form-group has-feedback">
            <input class="form-control" placeholder="Username" name="username" type="username" autofocus>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input class="form-control" placeholder="Password" name="password" type="password" value="">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="rememberme" value="1"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-danger btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    
    <center>Rolex Nerd 2016 - All rights reserved</center>

    <?php $this->load->view('js_footer'); ?>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });

        $(".alert").alert();
        window.setTimeout(function() { $(".alert").alert('close'); }, 2000);
    </script>
  </body>
</html>