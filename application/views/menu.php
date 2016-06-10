    <header class="main-header">
        <a href="#" class="logo"><b>NGG | </b><?php if ($this->session->userdata('sessrolex') == 0) echo "Nerd"; else echo "ROLEX"; if ($this->session->userdata('sessstatus') == 8) echo " POS"; ?> </a>
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
            <?php if (($this->session->userdata('sessstatus') > 0) && ($this->session->userdata('sessstatus') <= 4)) { ?>
            <?php if ($this->session->userdata('sessrolex') == 0) { ?>
            <li class="header">MAIN NAVIGATION</li>
            <li>
              <a href="<?php echo site_url("timepieces/main"); ?>">
                <i class="fa fa-home"></i> <span>หน้าแรก</span>
              </a>
            </li>
            <?php if (($this->session->userdata('sessstatus') == 1) || ($this->session->userdata('sessstatus') == 2)) { ?>
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
            <?php } ?>
            <li class="treeview">
                <a href="#"><i class="fa fa-truck"></i> <span>คลังสินค้า (Inventory)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
				    <li>
					   <a href="<?php echo site_url("warehouse/getBalance"); ?>"><i class="fa fa-circle-o"></i> ตรวจสอบจำนวนสินค้า</a>
					</li>
                    <?php if (($this->session->userdata('sessstatus') == 1) || ($this->session->userdata('sessstatus') == 2)) { ?>
                    <li>
                        <a href="<?php echo site_url("warehouse_transfer/importstock"); ?>"><i class="fa fa-circle-o"></i> รับสินค้าเข้าคลัง</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url("warehouse_transfer/report_transferstock"); ?>"><i class="fa fa-circle-o"></i> รายงาน-ย้ายคลังสินค้า</a>
                    </li>
                    <?php } ?>
                    <?php if (($this->session->userdata('sessstatus') == 1) || ($this->session->userdata('sessstatus') == 3)) { ?>
                    <li>
                        <a href="<?php echo site_url("warehouse_transfer/transferstock"); ?>"><i class="fa fa-circle-o"></i> ย้ายคลังสินค้า</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url("warehouse_transfer/form_replace_branch"); ?>"><i class="fa fa-circle-o"></i> สวมสินค้าสาขา</a>
                    </li>
                    <?php } ?>
                    <?php if (($this->session->userdata('sessstatus') == 1) || ($this->session->userdata('sessstatus') == 2)) { ?>
                    <li>
                        <a href="<?php echo site_url("warehouse_transfer/form_return_headoffice"); ?>"><i class="fa fa-circle-o"></i> คืนสินค้าเข้าคลัง HO</a>
                    </li>
                    <?php } ?>
					<li>
                        <a href="<?php echo site_url("warehouse_transfer/importstock_history"); ?>"><i class="fa fa-circle-o"></i> เอกสาร-รับสินค้าเข้าคลัง</a>
                    </li>
					<li>
                        <a href="<?php echo site_url("warehouse_transfer/transferstock_history"); ?>"><i class="fa fa-circle-o"></i> เอกสาร-ย้ายคลังสินค้า</a>
                    </li>
                    <?php if (($this->session->userdata('sessstatus') == 1) || ($this->session->userdata('sessstatus') == 2)) { ?>
                    <li>
					   <a href="<?php echo site_url("warehouse/manage"); ?>"><i class="fa fa-circle-o"></i> จัดการข้อมูลคลังสินค้า</a>
					</li>
                    <?php } ?>
                </ul>

            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-usd"></i> <span>การขาย (Sale)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
                <?php if ($this->session->userdata('sessstatus') != 2) { ?>
                    <?php if ($this->session->userdata('sessstatus') != 4) { ?>
				    <li>
					   <a href="<?php echo site_url("sale/saleorder_view"); ?>"><i class="fa fa-circle-o"></i> การสั่งขาย (Sale Order)</a>
					</li>
                    <?php } ?>
					<li>
                        <a href="<?php echo site_url("sale/saleorder_history"); ?>"><i class="fa fa-circle-o"></i> เอกสาร-การสั่งขาย</a>
                    </li>
                <?php } ?>
                    <li>
                        <a href="<?php echo site_url("sale/report_sale_form"); ?>"><i class="fa fa-circle-o"></i> รายงาน-การขาย</a>
                    </li>
                </ul>

            </li>
            <?php if ($this->session->userdata('sessstatus') == 1 || $this->session->userdata('sessstatus') == 2) { ?>
            <li class="treeview">
                <a href="#"><i class="fa fa-wrench"></i> <span>ส่งซ่อม (Repair)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
                    <li>
                        <a href="<?php echo site_url("tp_repair/form_new_repair"); ?>"><i class="fa fa-circle-o"></i> เพิ่มข้อมูลส่งซ่อม</a>
                    </li>
                </ul>

            </li>
            <?php } ?>
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
                        <a href="<?php echo site_url("warehouse_transfer/importstock_history"); ?>"><i class="fa fa-circle-o"></i> เอกสาร-รับสินค้าเข้าคลัง</a>
                    </li>
					<li>
                        <a href="<?php echo site_url("warehouse_transfer/transferstock_history"); ?>"><i class="fa fa-circle-o"></i> เอกสาร-ย้ายคลังสินค้า</a>
                    </li>
                </ul>

            </li>
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
            
            <?php  } ?>
            <?php } ?>
            
            <?php 
              // only POS user
              if ($this->session->userdata('sessrolex') == 1 && $this->session->userdata('sessstatus')==8) { ?>
            <li class="header">ROLEX POS</li>
            <li>
              <a href="<?php echo site_url("timepieces/main_rolex"); ?>">
                <i class="fa fa-home"></i> <span>หน้าหลัก</span>
              </a>
            </li>
            <li class="header">ออกเอกสาร</li>
            <li>
              <a href="<?php echo site_url("sale/saleorder_POS"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ออกใบกำกับภาษี</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("sale/saleorder_POS_temp"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ออกใบเสร็จรับเงิน</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("pos/stock_rolex_borrow"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ออกใบส่งของชั่วคราว</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("pos/stock_rolex_borrow_return"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ออกใบรับสินค้าคืน</span>
              </a>
            </li>
            <li class="header">รายงาน</li>
            <li>
              <a href="<?php echo site_url("sale/saleorder_POS_today"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ใบกำกับภาษีของวันนี้</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("sale/saleorder_POS_temp_today"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ใบเสร็จรับเงินของวันนี้</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("pos/stock_POS_borrow_today"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ใบส่งของ/รับคืนของวันนี้</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("pos/getBalance_shop"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ตรวจสอบสินค้าในร้าน</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("pos/formSerial_detail_shop"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ตรวจสอบ Serial</span>
              </a>
            </li>
            <li><a href="<?php echo site_url("pos/form_list_borrow_item"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>รายการสินค้ายืม</span>
            </a></li>
            <?php } ?>
              
            <?php 
              // only HATA
              if ($this->session->userdata('sessrolex') == 1 && $this->session->userdata('sessstatus')==88) { ?>
            <li class="header">รายงาน ROLEX</li>
            <li>
              <a href="<?php echo site_url("sale/saleorder_POS_history"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ประวัติใบกำกับภาษี</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("sale/saleorder_POS_temp_history"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ประวัติใบเสร็จรับเงิน</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("pos/stock_POS_borrow_history"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ประวัติใบส่งของ/รับคืน</span>
              </a>
            </li>
            <!--
            <li>
              <a href="<?php echo site_url("pos/stock_POS_sale_history"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>สินค้าที่ขายแล้ว</span>
              </a>
            </li>
            -->
            <li>
              <a href="<?php echo site_url("pos/getBalance_shop"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ตรวจสอบสินค้าในร้าน</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("pos/formSerial_detail_shop"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ตรวจสอบ Serial</span>
              </a>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-cube text-red"></i> <span>รายงาน (Reports)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
                    <li><a href="<?php echo site_url("pos/form_list_borrow_item"); ?>">
                        <i class="fa fa-circle-o text-red"></i><span>รายการสินค้ายืม</span>
                    </a></li>
                    <li><a href="<?php echo site_url("sale/report_rolex_sale_form"); ?>">
                        <i class="fa fa-circle-o text-red"></i><span>รายงานการขาย Rolex</span>
                    </a></li>
                </ul>

            </li>
            <li>
              
            </li>
            <li class="header">NGG Timepieces Office</li>
            <li>
               <a href="<?php echo site_url("warehouse/getBalance"); ?>"><i class="fa fa-circle-o"></i> ตรวจสอบจำนวนสินค้า</a>
            </li>
            <li>
                <a href="<?php echo site_url("warehouse_transfer/importstock_history"); ?>"><i class="fa fa-circle-o"></i> เอกสาร-รับสินค้าเข้าคลัง</a>
            </li>
            <li>
                <a href="<?php echo site_url("warehouse_transfer/transferstock_history"); ?>"><i class="fa fa-circle-o"></i> เอกสาร-ย้ายคลังสินค้า</a>
            </li>
            <li>
                <a href="<?php echo site_url("sale/saleorder_history"); ?>"><i class="fa fa-circle-o"></i> เอกสาร-การสั่งขาย</a>
            </li>
            <li>
                <a href="<?php echo site_url("sale/report_sale_form"); ?>"><i class="fa fa-circle-o"></i> รายงาน-การขาย</a>
            </li>
            <?php } ?>
              
            <?php 
              // only view rolex sale
              if ($this->session->userdata('sessrolex') == 1 && $this->session->userdata('sessstatus')==89) { ?>
            <li class="header">รายงาน ROLEX</li>
            <li>
              <a href="<?php echo site_url("sale/saleorder_POS_history"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ประวัติใบกำกับภาษี</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("sale/saleorder_POS_temp_history"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ประวัติใบเสร็จรับเงิน</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("pos/stock_POS_borrow_history"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ประวัติใบส่งของ/รับคืน</span>
              </a>
            </li>
            <!--
            <li>
              <a href="<?php echo site_url("pos/stock_POS_sale_history"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>สินค้าที่ขายแล้ว</span>
              </a>
            </li>
            -->
            <li>
              <a href="<?php echo site_url("pos/getBalance_shop"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ตรวจสอบสินค้าในร้าน</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("pos/formSerial_detail_shop"); ?>">
                <i class="fa fa-circle-o text-red"></i><span>ตรวจสอบ Serial</span>
              </a>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-cube text-red"></i> <span>รายงาน (Reports)</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
                    <li><a href="<?php echo site_url("pos/form_list_borrow_item"); ?>">
                        <i class="fa fa-circle-o text-red"></i><span>รายการสินค้ายืม</span>
                    </a></li>
                    <li><a href="<?php echo site_url("sale/report_rolex_sale_form"); ?>">
                        <i class="fa fa-circle-o text-red"></i><span>รายงานการขาย Rolex</span>
                    </a></li>
                </ul>

            </li>
            <?php } ?>
            <?php 
              // only Sesto
              if (($this->session->userdata('sessstatus') >= 50) && ($this->session->userdata('sessstatus') <= 59)) { ?>
            <li class="header">Certificate Menu</li>
            <li>
              <a href="<?php echo site_url("sesto/main"); ?>">
                <i class="fa fa-home"></i> <span>หน้าแรก</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("ss_certificate/add_newcert"); ?>">
                <i class="fa fa-circle-o"></i> <span>Add New Certificate</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("ss_certificate/view_all_certificate"); ?>">
                <i class="fa fa-circle-o"></i> <span>All Certificates</span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
