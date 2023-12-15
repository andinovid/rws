<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?php echo base_url() ?>assets/rms/dist/img/logo_icon.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8; margin-top:5px;">
    <span class="brand-text font-weight-bold" style="font-size: 30px;letter-spacing:3px;">RMS APP</span>
    <p class="brand-text font-weight-light" style="font-size: 13px;margin-left:20px;letter-spacing:1px;">Rajawali Management System</p>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url() ?>assets/rms/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $this->sess->name; ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <?php if ($this->sess->role != '5') { ?>
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
    <?php } ?>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <?php if ($this->sess->role == '5') { ?>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>dashboard/" class="nav-link <?php if ($this->uri->segment(2) == "dashboard") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>update_truck/" class="nav-link <?php if ($this->uri->segment(1) == "update_truck") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Update Truk
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>bbm/" class="nav-link <?php if ($this->uri->segment(1) == "bbm") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-gas-pump"></i>
              <p>
                Riwayat BBM
              </p>
            </a>
          </li>
        </ul>
      <?php } else { ?>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>dashboard/" class="nav-link <?php if ($this->uri->segment(2) == "dashboard") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>

          </li>

          <li class="nav-header">Komoditas</li>
          <li class="nav-item <?php if ($this->uri->segment(1) == "project") { ?>menu-open <?php } ?>">
            <a href="#" class="nav-link <?php if ($this->uri->segment(1) == "project") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Project
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>project/data" class="nav-link <?php if ($this->uri->segment(2) == "data" || $this->uri->segment(2) == "view" || $this->uri->segment(2) == "kwitansi") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Project</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="<?php echo base_url(); ?>project/replas" class="nav-link <?php if ($this->uri->segment(2) == "replas") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Replas</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>project/non_do" class="nav-link <?php if ($this->uri->segment(2) == "non_do") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Non DO</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>klien/" class="nav-link <?php if ($this->uri->segment(1) == "klien") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Data Klien
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>tujuan/" class="nav-link <?php if ($this->uri->segment(1) == "tujuan") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-map"></i>
              <p>
                Data Tujuan
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo base_url(); ?>vendor/" class="nav-link <?php if ($this->uri->segment(1) == "vendor") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Vendor Truck
              </p>
            </a>
          </li>
          <li class="nav-item <?php if ($this->uri->segment(1) == "kwitansi") { ?>menu-open <?php } ?>">
            <a href="<?php echo base_url(); ?>invoice/" class="nav-link <?php if ($this->uri->segment(1) == "kwitansi") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Kwitansi
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>kwitansi/generate" class="nav-link <?php if ($this->uri->segment(1) == "kwitansi" and $this->uri->segment(2) == "generate") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generate Kwitansi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>kwitansi/data" class="nav-link <?php if ($this->uri->segment(1) == "kwitansi" and $this->uri->segment(2) == "data") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kwitansi</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item <?php if ($this->uri->segment(1) == "invoice") { ?>menu-open <?php } ?>">
            <a href="<?php echo base_url(); ?>invoice/" class="nav-link <?php if ($this->uri->segment(1) == "invoice") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Invoice
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>invoice/generate" class="nav-link <?php if ($this->uri->segment(2) == "generate") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generate Invoice</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>invoice/data" class="nav-link <?php if ($this->uri->segment(2) == "data") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Invoice</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">Transporter</li>
          <li class="nav-item <?php if ($this->uri->segment(1) == "rekapitulasi") { ?>menu-open <?php } ?>">
            <a href="<?php echo base_url(); ?>rekapitulasi" class="nav-link <?php if ($this->uri->segment(1) == "rekapitulasi") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Rekapitulasi
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>rekapitulasi/data" class="nav-link <?php if ($this->uri->segment(1) == "rekapitulasi" AND $this->uri->segment(2) == "data") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Rekapitulasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>rekapitulasi/periode" class="nav-link <?php if ($this->uri->segment(1) == "rekapitulasi" AND $this->uri->segment(2) == "periode") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rekapitulasi periode</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?php echo base_url(); ?>truck/" class="nav-link <?php if ($this->uri->segment(1) == "truck") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Truck
              </p>
            </a>

          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>perbaikan/" class="nav-link <?php if ($this->uri->segment(1) == "perbaikan") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Perbaikan
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo base_url(); ?>sparepart/" class="nav-link <?php if ($this->uri->segment(1) == "sparepart") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Sparepart
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>supir/" class="nav-link <?php if ($this->uri->segment(1) == "supir") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-id-card"></i>
              <p>
                Supir
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>pinjaman/" class="nav-link <?php if ($this->uri->segment(1) == "pinjaman") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Pinjaman
              </p>
            </a>
          </li>
          <li class="nav-item <?php if ($this->uri->segment(1) == "kwitansi-transporter") { ?>menu-open <?php } ?>">
            <a href="#" class="nav-link <?php if ($this->uri->segment(1) == "kwitansi-transporter") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Kwitansi Transporter
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>kwitansi-transporter/data" class="nav-link <?php if ($this->uri->segment(1) == "kwitansi-transporter" AND $this->uri->segment(2) == "data") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kwitansi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>kwitansi-transporter/periode" class="nav-link <?php if ($this->uri->segment(1) == "kwitansi-transporter" AND $this->uri->segment(2) == "periode") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kwitansi periode</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">KEUANGAN</li>
          <!--li class="nav-item">
          <a href="pages/widgets.html" class="nav-link">
            <i class="nav-icon fas fa-credit-card"></i>
            <p>
              Pinjaman
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>kas-masuk/" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Pinjaman</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>kas-keluar/" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Pembayaran</p>
              </a>
            </li>
          </ul>
        </li-->
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>keuangan/" class="nav-link <?php if ($this->uri->segment(1) == "keuangan") { ?>active <?php } ?>">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                Keuangan
              </p>
            </a>
          </li>



          <!--li class="nav-item">
          <a href="<?php echo base_url(); ?>kwitansi/" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Kwitansi
            </p>
          </a>
        </li-->
          <li class="nav-item <?php if ($this->uri->segment(1) == "laporan") { ?>menu-open <?php } ?>">
            <a href="<?php echo base_url(); ?>laporan/" class="nav-link ">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Laporan
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>laporan/all" class="nav-link <?php if ($this->uri->segment(2) == "all") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Semua Laporan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>laporan/komoditas" class="nav-link <?php if ($this->uri->segment(2) == "komoditas") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Komoditas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>laporan/transporter" class="nav-link <?php if ($this->uri->segment(2) == "transporter") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Transporter</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>laporan/replas" class="nav-link <?php if ($this->uri->segment(2) == "replas") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Replas</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>laporan/pajak_replas" class="nav-link <?php if ($this->uri->segment(2) == "all") { ?>active <?php } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Pajak Replas</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">PENGATURAN</li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>setting/" class="nav-link">
              <i class="nav-icon fas fa-wrench"></i>
              <p>
                Setting
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>users/" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
              </p>
            </a>
          </li>
        </ul>
      <?php } ?>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>