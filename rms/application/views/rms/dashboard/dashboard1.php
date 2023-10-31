<div class="content-wrapper">
  <!-- Content Header (Page header) -->
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

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>150</h3>
              <p>Total Project</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Project On Progress</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>44</h3>

              <p>Project Selesai</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Menunggu Persetujuan</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Pendapatan Perusahaan
            </h3>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="chart">
              <canvas id="barChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
            </div>
          </div><!-- /.card-body -->
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
        <h3 class="card-title underline pb-3 mb-4 mt-4 card-title float-none">
          <i class="fas fa-chart-pie mr-1"></i>
          Project Sedang Berlangsung
        </h3>
          <div class="row">
            <div class="col-md-3">
              <div class="info-box ">
                <span class="info-box-icon bg-info"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-bold">PT Wilmar Chemical Indonesia</span>
                  <span class="info-box-text">WJ12992392012</span>
                  <div class="d-flex justify-content-md-between">
                    <span class="info-box-number mt-0">41,410 Kg</span>
                    <span class="progress-description">
                      Sisa 1.100 Kg
                    </span>
                  </div>
                  <div class="progress">
                    <div class="progress-bar bg-info" style="width: 70%"></div>
                  </div>
                  <ul class="list-inline mb-0 mt-2" data-toggle="tooltip" data-placement="top" title="Supir 1, Supir 2, Supir 3">
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar2.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar3.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar4.png">
                    </li>
                  </ul>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-box ">
                <span class="info-box-icon bg-info"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-bold">PT Wilmar Chemical Indonesia</span>
                  <span class="info-box-text">WJ12992392012</span>
                  <div class="d-flex justify-content-md-between">
                    <span class="info-box-number mt-0">41,410 Kg</span>
                    <span class="progress-description">
                      Sisa 1.100 Kg
                    </span>
                  </div>
                  <div class="progress">
                    <div class="progress-bar bg-info" style="width: 70%"></div>
                  </div>
                  <ul class="list-inline mb-0 mt-2" data-toggle="tooltip" data-placement="top" title="Supir 1, Supir 2, Supir 3">
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar2.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar3.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar4.png">
                    </li>
                  </ul>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-box ">
                <span class="info-box-icon bg-info"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-bold">PT Wilmar Chemical Indonesia</span>
                  <span class="info-box-text">WJ12992392012</span>
                  <div class="d-flex justify-content-md-between">
                    <span class="info-box-number mt-0">41,410 Kg</span>
                    <span class="progress-description">
                      Sisa 1.100 Kg
                    </span>
                  </div>
                  <div class="progress">
                    <div class="progress-bar bg-info" style="width: 70%"></div>
                  </div>
                  <ul class="list-inline mb-0 mt-2" data-toggle="tooltip" data-placement="top" title="Supir 1, Supir 2, Supir 3">
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar2.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar3.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar4.png">
                    </li>
                  </ul>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-box ">
                <span class="info-box-icon bg-info"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-bold">PT Wilmar Chemical Indonesia</span>
                  <span class="info-box-text">WJ12992392012</span>
                  <div class="d-flex justify-content-md-between">
                    <span class="info-box-number mt-0">41,410 Kg</span>
                    <span class="progress-description">
                      Sisa 1.100 Kg
                    </span>
                  </div>
                  <div class="progress">
                    <div class="progress-bar bg-info" style="width: 70%"></div>
                  </div>
                  <ul class="list-inline mb-0 mt-2" data-toggle="tooltip" data-placement="top" title="Supir 1, Supir 2, Supir 3">
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar2.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar3.png">
                    </li>
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" src="<?php echo base_url() ?>assets/rms/dist/img/avatar4.png">
                    </li>
                  </ul>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="col-lg-12 connectedSortable">
        <h3 class="card-title underline pb-3 mb-4 mt-4 card-title float-none">
          <i class="fas fa-chart-pie mr-1"></i>
          Status Oli & BBM Truck
        </h3>
        <div class="row">
          

          <div class="col-md-3">
            <div class="card card-body">
              <div class="text-center">
                <img src="<?php echo base_url() ?>assets/rms/dist/img/truck.png" style="width: 70%;" />
                <h3>KH 8950 FG</h3>
              </div>
              <p class="mb-0"><code>Oli Mesin - Kurang <b>360</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <p class="mb-0 mt-2"><code>Oli Gardan - Kurang <b>160</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <p class="mb-0 mt-2"><code>Oli Transmisi - Kurang <b>320</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>

              <p class="mb-0 mt-2"><i class="fas fa-gas-pump dark-grey"></i>&nbsp;&nbsp;<code><b>2 Oktober 2023</b> | <b>10L</b> | <b>Rp 700.000</b></code></p>
              
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-body">
              <div class="text-center">
                <img src="<?php echo base_url() ?>assets/rms/dist/img/truck.png" style="width: 70%;" />
                <h3>KH 8950 FG</h3>
              </div>
              <p class="mb-0"><code>Oli Mesin - Kurang <b>360</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <p class="mb-0 mt-2"><code>Oli Gardan - Kurang <b>160</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <p class="mb-0 mt-2"><code>Oli Transmisi - Kurang <b>320</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>

              <p class="mb-0 mt-2"><i class="fas fa-gas-pump dark-grey"></i>&nbsp;&nbsp;<code><b>2 Oktober 2023</b> | <b>10L</b> | <b>Rp 700.000</b></code></p>
              
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-body">
              <div class="text-center">
                <img src="<?php echo base_url() ?>assets/rms/dist/img/truck.png" style="width: 70%;" />
                <h3>KH 8950 FG</h3>
              </div>
              <p class="mb-0"><code>Oli Mesin - Kurang <b>360</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <p class="mb-0 mt-2"><code>Oli Gardan - Kurang <b>160</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <p class="mb-0 mt-2"><code>Oli Transmisi - Kurang <b>320</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>

              <p class="mb-0 mt-2"><i class="fas fa-gas-pump dark-grey"></i>&nbsp;&nbsp;<code><b>2 Oktober 2023</b> | <b>10L</b> | <b>Rp 700.000</b></code></p>
              
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-body">
              <div class="text-center">
                <img src="<?php echo base_url() ?>assets/rms/dist/img/truck.png" style="width: 70%;" />
                <h3>KH 8950 FG</h3>
              </div>
              <p class="mb-0"><code>Oli Mesin - Kurang <b>360</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <p class="mb-0 mt-2"><code>Oli Gardan - Kurang <b>160</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
              <p class="mb-0 mt-2"><code>Oli Transmisi - Kurang <b>320</b></code></p>
              <div class="progress progress-sm active">
                <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>

              <p class="mb-0 mt-2"><i class="fas fa-gas-pump dark-grey"></i>&nbsp;&nbsp;<code><b>2 Oktober 2023</b> | <b>10L</b> | <b>Rp 700.000</b></code></p>
              
            </div>
          </div>
          
          
        </div><!-- /.card-body -->
    </div>
  </section>
  <!-- /.Left col -->
  <!-- right col (We are only adding the ID to make the widgets sortable)-->

  <!-- right col -->
  <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>