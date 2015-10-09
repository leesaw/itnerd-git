    <header class="main-header">
        <a href="#" class="logo"><b>NGG | </b>IT Nerd <i class="fa fa-fw fa-angellist"></i></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
            
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <?php if ($this->session->userdata('sessstatus') != 1) { ?>
            <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="<?php echo site_url("task/ringshow"); ?>">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning"><?php if (isset($numring) && ($numring>0)) { echo $numring; } ?></span>
                </a>
              </li>
            
              <li class="dropdown notifications-menu">
                <a href="<?php echo site_url("task/notification"); ?>">
                  <i class="fa fa-bullhorn"></i>
                  <span class="label label-danger"><?php if (isset($numstatus5) && ($numstatus5>0)) { echo $numstatus5; } ?></span>
                </a>
              </li>
            <?php }elseif($this->session->userdata('sessstatus') == 1) { ?>
              <li class="dropdown notifications-menu">
                <a href="<?php echo site_url("task/completedtask"); ?>">
                  <i class="fa fa-check-square-o"></i>
                  <span class="label label-success"><?php if (isset($numring) && ($numring>0)) { echo $numring; } ?></span>
                </a>
              </li>
            <?php } ?>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>/dist/img/user.png" class="user-image" alt="User Image" />
                  <span class="hidden-xs">ผู้ใช้งาน :  <strong><?php echo $this->session->userdata('sessfirstname')." ".$this->session->userdata('sesslastname'); ?></strong>  <i class="fa fa-caret-down"></i></span>
                </a>
                    <ul class="dropdown-menu">
                        <li class="user-footer">
                            <div class="pull-left">
                              <a href="<?php echo site_url("main/changepass"); ?>" class="btn btn-default btn-flat"><small><i class="fa fa-gear fa-fw"></i> เปลี่ยนรหัสผ่าน</small></a>
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
        </nav>
      </header>

<!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <?php if ($this->session->userdata('sessstatus') == 99) { ?>
            <li>
              <a href="<?php echo site_url("login/users"); ?>">
                <i class="fa fa-users"></i> <span>Users</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("jes/license_now"); ?>">
                <i class="fa fa-pencil-square-o"></i> <span>JES</span>
              </a>
            </li>
            <?php } ?>
            <?php if (($this->session->userdata('sessstatus') > 0) && ($this->session->userdata('sessstatus') <= 2)) { ?>
            <li>
              <a href="<?php echo site_url("main"); ?>">
                <i class="fa fa-home"></i> <span>Today</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("task/nexttask"); ?>">
                <i class="fa fa-calendar"></i> <span>Next Tasks</span>
              </a>
            </li>
            <?php if ($this->session->userdata('sessstatus') == 1) { ?>
            <li>
              <a href="<?php echo site_url("task/teamtask"); ?>">
                <i class="fa fa-coffee"></i> <span>Team Tasks</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("task/myteam"); ?>">
                <i class="fa fa-users"></i> <span>My Team</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("task/main"); ?>">
                <i class="fa fa-check-square-o"></i> <span>Completed Tasks</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("task/category"); ?>">
                <i class="fa fa-pencil-square-o"></i> <span>Category</span>
              </a>
            </li>
            <?php } } ?>
            <?php if (($this->session->userdata('sessstatus') > 0) && ($this->session->userdata('sesscompany') == 1) && ($this->session->userdata('sessposition') < 3)) { ?>
            <li>
              <a href="<?php echo site_url("jes/watch/main"); ?>">
                <i class="fa fa-home"></i> <span>Dashboard</span>
              </a>
            </li>
            <?php if ($this->session->userdata('sessstatus') == 99) { ?>
            <li>
              <a href="<?php echo site_url("jes/license_now"); ?>">
                <i class="fa fa-pencil-square-o"></i> <span>JES</span>
              </a>
            </li>
            <?php } } ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
