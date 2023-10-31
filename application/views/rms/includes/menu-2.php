<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?php echo base_url() ?>assets/rms/dist/img/icon2.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8; margin-top:5px;">
    <span class="brand-text font-weight-bold" style="font-size: 30px;letter-spacing:3px;">RMS APP</span>
    <p class="brand-text font-weight-light" style="font-size: 13px;margin-left:20px;letter-spacing:1px;">Rajawali Management System</p>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image mt-2">
        <img src="<?php echo base_url() ?>assets/rms/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block" style="font-weight:600; color:#FFF"><?php echo $this->sess->name; ?></a>
        <p class="small text-white mb-0" style="opacity: 0.5;"><?php echo $this->sess->role_name; ?></p>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item <?php if ($this->uri->segment(2) == "dashboard") { ?>menu-open <?php } ?>">
          <a href="<?php echo base_url(); ?>rms/dashboard/" class="nav-link <?php if ($this->uri->segment(2) == "dashboard") { ?>active <?php } ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>

        </li>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>rms/rekapitulasi/" class="nav-link <?php if ($this->uri->segment(2) == "rekapitulasi") { ?>active <?php } ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Rekapitulasi Data
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>rms/truck/" class="nav-link <?php if ($this->uri->segment(2) == "truck") { ?>active <?php } ?>">
            <i class="nav-icon fas fa-truck"></i>
            <p>
              Truck
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>rms/perbaikan/" class="nav-link <?php if ($this->uri->segment(2) == "perbaikan") { ?>active <?php } ?>">
            <i class="nav-icon fas fa-tools"></i>
            <p>
              Perbaikan
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>rms/sparepart/" class="nav-link <?php if ($this->uri->segment(2) == "sparepart") { ?>active <?php } ?>">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>
              Sparepart
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>rms/supir/" class="nav-link <?php if ($this->uri->segment(2) == "supir") { ?>active <?php } ?>">
            <i class="nav-icon fas fa-id-card"></i>
            <p>
              Supir
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>