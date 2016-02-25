    <header class="main-header">
        <a href="#" class="logo"><b>NGG | </b><?php if ($this->session->userdata('sessrolex') == 0) echo "Nerd"; else echo "ROLEX"; ?> </a>
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
            <?php if (($this->session->userdata('sessstatus') > 0) && ($this->session->userdata('sessstatus') <= 3)) { ?>
            <?php if ($this->session->userdata('sessrolex') == 0) { ?>
            <li class="header">MAIN NAVIGATION</li>
            <li>
              <a href="<?php echo site_url("timepieces/main"); ?>">
                <i class="fa fa-home"></i> <span>หน้าแรก</span>
              </a>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-tags"></i> <span>สินค้า (Product)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
                    <li>
                        <a href="<?php echo site_url("item/manage"); ?>"><i class="fa fa-circle-o"></i> จัดการสินค้า</a>
                    </li>
				    <li>
                        <a href="<?php echo site_url("item/additem"); ?>"><i class="fa fa-circle-o"></i> เพิ่มข้อมูลสินค้า</a>
                    </li>
                    <!--
					<li>
                        <a href="<?php echo site_url("managecat"); ?>"><i class="fa fa-circle-o"></i> จัดการประเภทสินค้า</a>
                    </li>
                    -->
                </ul>

            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-truck"></i> <span>คลังสินค้า (Inventory)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
				    <li>
					   <a href="<?php echo site_url("warehouse/getBalance"); ?>"><i class="fa fa-circle-o"></i> ตรวจสอบจำนวนสินค้า</a>
					</li>
                    <li>
                        <a href="<?php echo site_url("warehouse_transfer/importstock"); ?>"><i class="fa fa-circle-o"></i> รับสินค้าเข้าคลัง</a>
                    </li>
					<li>
                        <a href="<?php echo site_url("warehouse_transfer/transferstock"); ?>"><i class="fa fa-circle-o"></i> ย้ายคลังสินค้า</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url("warehouse_transfer/report_transferstock"); ?>"><i class="fa fa-circle-o"></i> รายงาน-ย้ายคลังสินค้า</a>
                    </li>
					<li>
                        <a href="<?php echo site_url("warehouse_transfer/importstock_history"); ?>"><i class="fa fa-circle-o"></i> ประวัติรับสินค้าเข้าคลัง</a>
                    </li>
					<li>
                        <a href="<?php echo site_url("warehouse_transfer/transferstock_history"); ?>"><i class="fa fa-circle-o"></i> ประวัติย้ายคลังสินค้า</a>
                    </li>
                </ul>

            </li>
            <?php }else{ ?>
            <li class="header">ROLEX</li>
            <li>
              <a href="<?php echo site_url("timepieces/main_rolex"); ?>">
                <i class="fa fa-home"></i> <span>หน้าแรก</span>
              </a>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-tags"></i> <span>สินค้า (Product)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
                    <li>
                        <a href="<?php echo site_url("item/manage"); ?>"><i class="fa fa-circle-o"></i> จัดการสินค้า</a>
                    </li>
				    <li>
                        <a href="<?php echo site_url("item/additem"); ?>"><i class="fa fa-circle-o"></i> เพิ่มข้อมูลสินค้า</a>
                    </li>
                </ul>

            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-truck"></i> <span>คลังสินค้า (Inventory)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
				    <li>
					   <a href="<?php echo site_url("warehouse/getBalance"); ?>"><i class="fa fa-circle-o"></i> ตรวจสอบจำนวนสินค้า</a>
					</li>
                    <li>
                        <a href="<?php echo site_url("warehouse_transfer/importstock"); ?>"><i class="fa fa-circle-o"></i> รับสินค้าเข้าคลัง</a>
                    </li>
					<li>
                        <a href="<?php echo site_url("warehouse_transfer/transferstock"); ?>"><i class="fa fa-circle-o"></i> ย้ายคลังสินค้า</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url("warehouse_transfer/report_transferstock"); ?>"><i class="fa fa-circle-o"></i> รายงาน-ย้ายคลังสินค้า</a>
                    </li>
					<li>
                        <a href="<?php echo site_url("warehouse_transfer/importstock_history"); ?>"><i class="fa fa-circle-o"></i> ประวัติรับสินค้าเข้าคลัง</a>
                    </li>
					<li>
                        <a href="<?php echo site_url("warehouse_transfer/transferstock_history"); ?>"><i class="fa fa-circle-o"></i> ประวัติย้ายคลังสินค้า</a>
                    </li>
                </ul>

            </li>
    
            <?php } ?>
            <li class="treeview">
                <a href="#"><i class="fa fa-shopping-cart"></i> <span>ข้อมูลลูกค้า (Customer)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
                    <li>
                        <a href="<?php echo site_url("managecustomer"); ?>"><i class="fa fa-circle-o"></i> จัดการข้อมูลลูกค้า</a>
                    </li>
                    
				    <li>
                        <a href="<?php echo site_url("managecustomer/addcustomer"); ?>"><i class="fa fa-circle-o"></i> เพิ่มข้อมูลลูกค้า</a>
                    </li>
                </ul>

            </li>
            <li>
              <a href="<?php echo site_url("TP/main"); ?>">
                <i class="fa fa-usd"></i><span>ออกใบกำกับภาษี/ใบส่งสินค้า/<br>ใบเสร็จรับเงิน</span>
              </a>
            </li>
            <?php  } ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
