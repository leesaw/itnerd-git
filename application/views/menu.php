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
          <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">

            </ul>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <?php if ($this->session->userdata('sessstatus') == 1) { ?>
              <li class="tasks-menu">
                <a href="<?php echo site_url("main/config"); ?>"><i class="fa fa-gears"></i> ตั้งค่า</a>
              </li>
            <?php } ?>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">ผู้ใช้งาน :  <strong><?php echo $this->session->userdata('sessfirstname')." ".$this->session->userdata('sesslastname'); ?></strong><i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i></span>
                </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo site_url("main/changepass"); ?>"><i class="fa fa-gear fa-fw"></i> เปลี่ยนรหัสผ่าน</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url("main/logout"); ?>"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
              </li>
            </ul>
          </div>
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
            <!-- 
            <li>
              <a href="<?php echo site_url("task/notification"); ?>">
                <i class="fa fa-bullhorn"></i> <span>Notifications</span><?php if (isset($numstatus5) && ($numstatus5>0)) { ?><small class="label pull-right bg-red"><?php echo $numstatus5; ?></small> <?php } ?>
              </a>
            </li>
            -->
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
                <i class="fa fa-file-text-o"></i> <span>Task</span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
