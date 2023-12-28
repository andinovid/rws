<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <?php if ($this->sess->role != '5') { ?>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  <?php } else { ?>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="card-title underline pb-3 mb-4 mt-4 card-title float-none">
              <i class="fas fa-chart-pie mr-1"></i>
              Status Oli & BBM Truck
            </h3>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <?php } ?>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <?php if ($this->sess->role == '5') { ?>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <div class="text-center">
                <h1><?php echo $truck->nopol; ?></h1>
                <img src="<?php echo base_url() ?>assets/rms/dist/img/truck.png" style="width: 70%;" /><br>
                <img src="<?php echo base_url(); ?>assets/rms/dist/img/dashboard2.png" width="80">
                <h2 style="font-weight: bold;"><?php echo number_format($truck->oddo_terakhir, 0, "", "."); ?></h2>
              </div>
              <div class="d-flex justify-content-md-between mt-2 mb-2">
                <span class="info-box-number mt-0" style="font-weight:400;"><span class="text-bold">Oli Mesin <?php echo $truck->persentase_penggunaan_oli_mesin; ?>%</span></span>
                <span class="progress-description">
                  Kurang <span class="text-bold">
                    <?php echo number_format($truck->kurang_oli_mesin, 0, "", "."); ?> </span> KM
                </span>
              </div>
              <div class="progress progress-xs active">
                <div class="progress-bar <?php if ($truck->persentase_penggunaan_oli_mesin > '90') {
                                            echo 'bg-danger';
                                          } elseif ($truck->persentase_penggunaan_oli_mesin > '80' and $truck->persentase_penggunaan_oli_mesin < '90') {
                                            echo 'bg-warning';
                                          } else {
                                            echo 'bg-green';
                                          } ?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $truck->persentase_penggunaan_oli_mesin; ?>%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <div class="d-flex justify-content-md-between mt-2 mb-2">
                <span class="info-box-number mt-0" style="font-weight:400;"><span class="text-bold">Oli Gardan <?php echo $truck->persentase_penggunaan_oli_gardan; ?>%</span></span>
                <span class="progress-description">
                  Kurang <span class="text-bold">
                    <?php echo number_format($truck->kurang_oli_gardan, 0, "", "."); ?> </span> KM
                </span>
              </div>
              <div class="progress progress-xs active">
                <div class="progress-bar <?php if ($truck->persentase_penggunaan_oli_gardan > '90') {
                                            echo 'bg-danger';
                                          } elseif ($truck->persentase_penggunaan_oli_gardan > '80' and $truck->persentase_penggunaan_oli_gardan < '90') {
                                            echo 'bg-warning';
                                          } else {
                                            echo 'bg-green';
                                          } ?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $truck->persentase_penggunaan_oli_gardan; ?>%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <div class="d-flex justify-content-md-between mt-2 mb-2">
                <span class="info-box-number mt-0" style="font-weight:400;"><span class="text-bold">Oli Transmisi <?php echo $truck->persentase_penggunaan_oli_transmisi; ?>%</span></span>
                <span class="progress-description">
                  Kurang <span class="text-bold">
                    <?php echo number_format($truck->kurang_oli_transmisi, 0, "", "."); ?> </span> KM
                </span>
              </div>
              <div class="progress progress-xs active">
                <div class="progress-bar <?php if ($truck->persentase_penggunaan_oli_transmisi > '90') {
                                            echo 'bg-danger';
                                          } elseif ($truck->persentase_penggunaan_oli_transmisi > '80' and $truck->persentase_penggunaan_oli_transmisi < '90') {
                                            echo 'bg-warning';
                                          } else {
                                            echo 'bg-green';
                                          } ?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $truck->persentase_penggunaan_oli_transmisi; ?>%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <hr>
              <p class="mb-0 mt-0"><i class="fas fa-gas-pump dark-grey"></i>&nbsp;&nbsp;<span style="font-size:14px;text-transform:uppercase;"><?php echo $truck->bbm_terakhir; ?></span></p>
            </div>
          </div>


          <div class="col-md-12">
            <div class="card card-body">
              <div class="mb-2">
                <span class="text-bold d-block">Pajak Tahunan</span>
                <?php if ($truck->sisa_hari_pajak_tahunan > 0) { ?>
                  <?php echo shortdate_indo($truck->pajak_tahunan); ?><br>
                  <small class="badge <?php if ($truck->sisa_hari_pajak_tahunan > 0 and $truck->sisa_hari_pajak_tahunan < '30') {
                                        echo 'badge-danger';
                                      } elseif ($truck->sisa_hari_pajak_tahunan >= '30' and $truck->sisa_hari_pajak_tahunan < '60') {
                                        echo 'badge-warning';
                                      } else {
                                        echo 'badge-success';
                                      } ?>"> Sisa
                    <?php
                    $days = $truck->sisa_hari_pajak_tahunan;
                    $start_date = new DateTime();
                    $end_date = (new $start_date)->add(new DateInterval("P{$days}D"));
                    $dd = date_diff($start_date, $end_date);
                    if ($dd->y != 0 and $dd->m != 0 and $dd->d != 0) {
                      echo $dd->y . " tahun " . $dd->m . " bulan " . $dd->d . " hari";
                    } elseif ($dd->y == 0 and $dd->m != 0 and $dd->d != 0) {
                      echo $dd->m . " bulan " . $dd->d . " hari";
                    } elseif ($dd->y == 0 and $dd->m == 0 and $dd->d != 0) {
                      echo $dd->d . " hari";
                    } elseif ($dd->y == 0 and $dd->m != 0 and $dd->d == 0) {
                      echo $dd->m . " bulan ";
                    } elseif ($dd->y != 0 and $dd->m == 0 and $dd->d == 0) {
                      echo $dd->y . " tahun ";
                    } elseif ($dd->y != 0 and $dd->m == 0 and $dd->d != 0) {
                      echo $dd->y . " tahun "  . $dd->d . " hari";
                    } elseif ($dd->y != 0 and $dd->m != 0 and $dd->d == 0) {
                      echo $dd->y . " tahun " . $dd->m . " bulan ";
                    } elseif ($dd->y == 0 and $dd->m == 0 and $dd->d == 0) {
                      echo "Sudah habis";
                    }
                    ?>
                  </small>
                <?php } else {
                  echo "-";
                } ?>
              </div>
              <div class="mt-2 mb-2">
                <span class="text-bold d-block">Pajak 5 Tahunan</span>
                <?php if ($truck->sisa_hari_pajak_5_tahunan > 0) { ?>
                  <?php echo shortdate_indo($truck->pajak_5_tahunan); ?><br>
                  <small class="badge <?php if ($truck->sisa_hari_pajak_5_tahunan > 0 and $truck->sisa_hari_pajak_5_tahunan < '30') {
                                        echo 'badge-danger';
                                      } elseif ($truck->sisa_hari_pajak_5_tahunan >= '30' and $truck->sisa_hari_pajak_5_tahunan < '60') {
                                        echo 'badge-warning';
                                      } else {
                                        echo 'badge-success';
                                      } ?>">Sisa
                    <?php
                    $days = $truck->sisa_hari_pajak_5_tahunan;
                    $start_date = new DateTime();
                    $end_date = (new $start_date)->add(new DateInterval("P{$days}D"));
                    $dd = date_diff($start_date, $end_date);
                    if ($dd->y != 0 and $dd->m != 0 and $dd->d != 0) {
                      echo $dd->y . " tahun " . $dd->m . " bulan " . $dd->d . " hari";
                    } elseif ($dd->y == 0 and $dd->m != 0 and $dd->d != 0) {
                      echo $dd->m . " bulan " . $dd->d . " hari";
                    } elseif ($dd->y == 0 and $dd->m == 0 and $dd->d != 0) {
                      echo $dd->d . " hari";
                    } elseif ($dd->y == 0 and $dd->m != 0 and $dd->d == 0) {
                      echo $dd->m . " bulan ";
                    } elseif ($dd->y != 0 and $dd->m == 0 and $dd->d == 0) {
                      echo $dd->y . " tahun ";
                    } elseif ($dd->y != 0 and $dd->m == 0 and $dd->d != 0) {
                      echo $dd->y . " tahun "  . $dd->d . " hari";
                    } elseif ($dd->y != 0 and $dd->m != 0 and $dd->d == 0) {
                      echo $dd->y . " tahun " . $dd->m . " bulan ";
                    } elseif ($dd->y == 0 and $dd->m == 0 and $dd->d == 0) {
                      echo "Sudah habis";
                    }
                    ?>
                  </small>
                <?php } else {
                  echo "-";
                } ?>
              </div>

              <div class="mt-2">
                <span class="text-bold d-block">KIR</span>
                <?php if ($truck->sisa_hari_kir > 0) { ?>
                  <?php echo shortdate_indo($truck->kir_selanjutnya); ?><br>
                  <small class="badge <?php if ($truck->sisa_hari_kir > 0 and $truck->sisa_hari_kir < '7') {
                                        echo 'badge-danger';
                                      } elseif ($truck->sisa_hari_kir >= '7' and $truck->sisa_hari_kir < '30') {
                                        echo 'badge-warning';
                                      } else {
                                        echo 'badge-success';
                                      } ?>">Sisa
                    <?php
                    $days = $truck->sisa_hari_kir;
                    $start_date = new DateTime();
                    $end_date = (new $start_date)->add(new DateInterval("P{$days}D"));
                    $dd = date_diff($start_date, $end_date);
                    if ($dd->y != 0 and $dd->m != 0 and $dd->d != 0) {
                      echo $dd->y . " tahun " . $dd->m . " bulan " . $dd->d . " hari";
                    } elseif ($dd->y == 0 and $dd->m != 0 and $dd->d != 0) {
                      echo $dd->m . " bulan " . $dd->d . " hari";
                    } elseif ($dd->y == 0 and $dd->m == 0 and $dd->d != 0) {
                      echo $dd->d . " hari";
                    } elseif ($dd->y == 0 and $dd->m != 0 and $dd->d == 0) {
                      echo $dd->m . " bulan ";
                    } elseif ($dd->y != 0 and $dd->m == 0 and $dd->d == 0) {
                      echo $dd->y . " tahun ";
                    } elseif ($dd->y != 0 and $dd->m == 0 and $dd->d != 0) {
                      echo $dd->y . " tahun "  . $dd->d . " hari";
                    } elseif ($dd->y != 0 and $dd->m != 0 and $dd->d == 0) {
                      echo $dd->y . " tahun " . $dd->m . " bulan ";
                    } elseif ($dd->y == 0 and $dd->m == 0 and $dd->d == 0) {
                      echo "Sudah habis";
                    }
                    ?>
                  </small>
                <?php } else {
                  echo "-";
                } ?>
              </div>


            </div>
          </div>

          <div class="col-md-12">
            <div class="info-box mb-3 <?php if ($truck->sisa_hari_air_radiator > 0 and $truck->sisa_hari_air_radiator < '30') {
                                        echo 'bg-danger';
                                      } elseif ($truck->sisa_hari_air_radiator >= '30' and $truck->sisa_hari_air_radiator < '60') {
                                        echo 'bg-warning';
                                      } else {
                                        echo 'bg-success';
                                      } ?>">
              <span class="info-box-icon"><i class="fas fa-temperature-low"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Air Radiator</span>
                <span class="info-box-number mt-0">
                  <?php if ($truck->sisa_hari_air_radiator > 0) { ?>
                    <?php echo shortdate_indo($truck->air_radiator_selanjutnya); ?><br>
                    <small style="font-style:italic;"> Sisa
                      <?php
                      $days = $truck->sisa_hari_air_radiator;
                      $start_date = new DateTime();
                      $end_date = (new $start_date)->add(new DateInterval("P{$days}D"));
                      $dd = date_diff($start_date, $end_date);
                      if ($dd->y != 0 and $dd->m != 0 and $dd->d != 0) {
                        echo $dd->y . " tahun " . $dd->m . " bulan " . $dd->d . " hari";
                      } elseif ($dd->y == 0 and $dd->m != 0 and $dd->d != 0) {
                        echo $dd->m . " bulan " . $dd->d . " hari";
                      } elseif ($dd->y == 0 and $dd->m == 0 and $dd->d != 0) {
                        echo $dd->d . " hari";
                      } elseif ($dd->y == 0 and $dd->m != 0 and $dd->d == 0) {
                        echo $dd->m . " bulan ";
                      } elseif ($dd->y != 0 and $dd->m == 0 and $dd->d == 0) {
                        echo $dd->y . " tahun ";
                      } elseif ($dd->y != 0 and $dd->m == 0 and $dd->d != 0) {
                        echo $dd->y . " tahun "  . $dd->d . " hari";
                      } elseif ($dd->y != 0 and $dd->m != 0 and $dd->d == 0) {
                        echo $dd->y . " tahun " . $dd->m . " bulan ";
                      } elseif ($dd->y == 0 and $dd->m == 0 and $dd->d == 0) {
                        echo "Sudah habis";
                      }
                      ?>
                    </small>
                  <?php } else {
                    echo "-";
                  } ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>

        </div>


      <?php } else { ?>
        <div class="row">
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?php echo $all_project; ?></h3>
                <p>Total Project</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $project_on_progress; ?></h3>

                <p>Project On Progress</p>
              </div>
              <div class="icon">
                <i class="ion ion-clock"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $project_complete; ?></h3>

                <p>Project Selesai</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-checkmark-outline"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Rp <?php echo number_format($saldo->total, 0, "", "."); ?></h3>

                <p>Saldo Keuangan</p>
              </div>
              <div class="icon">
                <i class="ion ion-card"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <!-- Left col -->
        <!--section class="col-lg-12 connectedSortable">
        
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Pendapatan Perusahaan
            </h3>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="barChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </section-->
        <section class="content">
          <div class="container-fluid">
            <h3 class="card-title underline pb-3 mb-4 mt-4 card-title float-none">
              <i class="fas fa-chart-pie mr-1"></i>
              Project Sedang Berlangsung
            </h3>
            <div class="row">
              <?php foreach ($project_on_progress_list as $row) : ?>
                <div class="col-md-3">
                  <div class="info-box ">
                    <span class="info-box-icon bg-info"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text text-bold"><?php echo $row->nama_perusahaan; ?></span>
                      <span class="info-box-text"><?php echo $row->no_do; ?></span>
                      <div class="d-flex justify-content-md-between">
                        <span class="info-box-number mt-0" style="font-weight:400;"><span class="text-bold"><?php echo $row->persentase_terkirim; ?></span>%</span>
                        <span class="progress-description">
                          Sisa <span class="text-bold">
                            <?php if ($row->total_terkirim != NULL) {
                              echo number_format($row->sisa_kirim, 0, "", ".");
                            } else {
                              echo "0";
                            } ?></span> Kg
                        </span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-info" style="width: <?php echo $row->persentase_terkirim; ?>%"></div>
                      </div>
                      <span class="info-box-text">Terikirim <span class="text-bold">
                          <?php if ($row->total_terkirim != NULL) {
                            echo number_format($row->total_terkirim, 0, "", ".");
                          } else {
                            echo "0";
                          } ?>/<?php if ($row->total_terkirim != NULL) {
                                  echo number_format($row->qty, 0, "", ".");
                                } else {
                                  echo "0";
                                } ?></span> kg</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </section>

        <section class="col-lg-12 connectedSortable">
          <h3 class="card-title underline pb-3 mb-4 mt-4 card-title float-none">
            <i class="fas fa-chart-pie mr-1"></i>
            Status Oli & BBM Truck
          </h3>
          <div class="row">
            <?php foreach ($truck as $row) : ?>
              <div class="col-md-3">
                <div class="card card-body">
                  <div class="text-center">
                    <img src="<?php echo base_url() ?>assets/rms/dist/img/truck.png" style="width: 70%;" />
                    <h3><?php echo $row->nopol; ?></h3>
                  </div>
                  <div class="d-flex justify-content-md-between mt-2 mb-2">
                    <span class="info-box-number mt-0" style="font-weight:400;"><span class="text-bold">Oli Mesin <?php echo $row->persentase_penggunaan_oli_mesin; ?>%</span></span>
                    <span class="progress-description">
                      Kurang <span class="text-bold">
                        <?php echo number_format($row->kurang_oli_mesin, 0, "", "."); ?> </span> KM
                    </span>
                  </div>
                  <div class="progress progress-xs active">
                    <div class="progress-bar <?php if ($row->persentase_penggunaan_oli_mesin > '90') {
                                                echo 'bg-danger';
                                              } elseif ($row->persentase_penggunaan_oli_mesin > '80' and $row->persentase_penggunaan_oli_mesin < '90') {
                                                echo 'bg-warning';
                                              } else {
                                                echo 'bg-green';
                                              } ?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row->persentase_penggunaan_oli_mesin; ?>%">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                  <div class="d-flex justify-content-md-between mt-2 mb-2">
                    <span class="info-box-number mt-0" style="font-weight:400;"><span class="text-bold">Oli Gardan <?php echo $row->persentase_penggunaan_oli_gardan; ?>%</span></span>
                    <span class="progress-description">
                      Kurang <span class="text-bold">
                        <?php echo number_format($row->kurang_oli_gardan, 0, "", "."); ?> </span> KM
                    </span>
                  </div>
                  <div class="progress progress-xs active">
                    <div class="progress-bar <?php if ($row->persentase_penggunaan_oli_gardan > '90') {
                                                echo 'bg-danger';
                                              } elseif ($row->persentase_penggunaan_oli_gardan > '80' and $row->persentase_penggunaan_oli_gardan < '90') {
                                                echo 'bg-warning';
                                              } else {
                                                echo 'bg-green';
                                              } ?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row->persentase_penggunaan_oli_gardan; ?>%">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                  <div class="d-flex justify-content-md-between mt-2 mb-2">
                    <span class="info-box-number mt-0" style="font-weight:400;"><span class="text-bold">Oli Transmisi <?php echo $row->persentase_penggunaan_oli_transmisi; ?>%</span></span>
                    <span class="progress-description">
                      Kurang <span class="text-bold">
                        <?php echo number_format($row->kurang_oli_transmisi, 0, "", "."); ?> </span> KM
                    </span>
                  </div>
                  <div class="progress progress-xs active">
                    <div class="progress-bar <?php if ($row->persentase_penggunaan_oli_transmisi > '90') {
                                                echo 'bg-danger';
                                              } elseif ($row->persentase_penggunaan_oli_transmisi > '80' and $row->persentase_penggunaan_oli_transmisi < '90') {
                                                echo 'bg-warning';
                                              } else {
                                                echo 'bg-green';
                                              } ?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row->persentase_penggunaan_oli_transmisi; ?>%">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                  <hr>
                  <p class="mb-0 mt-0"><i class="fas fa-gas-pump dark-grey"></i>&nbsp;&nbsp;<span style="font-size:14px;text-transform:uppercase;"><?php echo $row->bbm_terakhir; ?></span></p>

                </div>
              </div>
            <?php endforeach; ?>
          </div><!-- /.card-body -->
        </section>
      <?php } ?>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->

      <!-- right col -->
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>