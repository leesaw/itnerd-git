<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand"><b>NGG Gold</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo site_url("ngg_gold/main"); ?>">Home</a></li>
            <?php if ($this->session->userdata('sessstatus') == 61) { ?>
            <li><a href="<?php echo site_url("ngg_gold/form_warranty"); ?>">ออกบัตรรับประกันสินค้า (ทอง)</a></li>
            <?php } ?>
            <?php if ($this->session->userdata('sessstatus') == 62) { ?>
            <li>
                <a href="<?php echo site_url("ngg_gold/list_warranty_filter"); ?>">แสดงบัตรรับประกันสินค้าทั้งหมด (ทอง)</a>
            </li>
            <?php } ?>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>/dist/img/user.png" class="user-image" alt="User Image" />
                  <span class="hidden-xs">ผู้ใช้งาน :  <strong><?php echo $this->session->userdata('sessfirstname')." ".$this->session->userdata('sesslastname'); ?></strong>  <i class="fa fa-caret-down"></i></span>
                </a>
                <ul class="dropdown-menu">
                        <li class="user-footer">
                            <div class="pull-left">
                              <a href="<?php echo site_url("ngg_gold/changepass"); ?>" class="btn btn-default btn-flat"><small><i class="fa fa-gear fa-fw"></i> เปลี่ยนรหัสผ่าน</small></a>
                            </div>
                            <div class="pull-right">
                              <a href="<?php echo site_url("main/logout"); ?>" class="btn btn-default btn-flat"><small><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</small></a>
                            </div>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
              </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>