<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">TRUK <?php echo $truck->nopol; ?> | <i class="fas fa-user" style="font-size:76%;"></i> <?php if($profil_supir){ echo $profil_supir->nama;} ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">truk <?php echo $truck->nopol; ?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <?php if ($truck->kategori == '1') { ?>
            <div class="row">
              <div class="col-12 col-sm-4">
                <div class="info-box">
                  <span class="info-box-icon <?php if ($truck->persentase_penggunaan_oli_mesin > '90') {
                                                echo 'bg-danger';
                                              } elseif ($truck->persentase_penggunaan_oli_mesin > '80' and $truck->persentase_penggunaan_oli_mesin < '90') {
                                                echo 'bg-warning';
                                              } else {
                                                echo 'bg-success';
                                              } ?>"><img src="<?php echo base_url(); ?>assets/rms/dist/img/engine-oil.png" width="40" /> </span>
                  <div class="info-box-content">
                    <div class="d-flex justify-content-md-between">
                      <span class="info-box-text">Oli Mesin</span>
                      <span class="info-box-number mt-0"><?php echo $truck->persentase_penggunaan_oli_mesin; ?>%</span>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-green" style="width: <?php echo $truck->persentase_penggunaan_oli_mesin; ?>%"></div>
                    </div>
                    <span class="info-box-number"><img src="<?php echo base_url(); ?>assets/rms/dist/img/dashboard2.png" width="25" class="mr-2" style="margin-top: -3px;" /><?php echo number_format($truck->oddo_terakhir, 0, "", "."); ?>/<?php echo number_format($truck->pergantian_oli_mesin_selanjutnya, 0, "", "."); ?> KM | Kurang <?php echo number_format($truck->kurang_oli_mesin, 0, "", "."); ?> KM</span>
                    <span style="font-size: 14px; font-style:italic;">Terakhir ganti oli mesin pada <b>KM <?php echo number_format($truck->oddo_terakhir_oli_mesin, 0, "", "."); ?></b></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box">
                  <span class="info-box-icon <?php if ($truck->persentase_penggunaan_oli_gardan > '90') {
                                                echo 'bg-danger';
                                              } elseif ($truck->persentase_penggunaan_oli_gardan > '80' and $truck->persentase_penggunaan_oli_gardan < '90') {
                                                echo 'bg-warning';
                                              } else {
                                                echo 'bg-success';
                                              } ?>"><img src="<?php echo base_url(); ?>assets/rms/dist/img/engine-oil.png" width="40" /> </span>
                  <div class="info-box-content">
                    <div class="d-flex justify-content-md-between">
                      <span class="info-box-text">Oli Gardan</span>
                      <span class="info-box-number mt-0"><?php echo $truck->persentase_penggunaan_oli_gardan; ?>%</span>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-green" style="width: <?php echo $truck->persentase_penggunaan_oli_gardan; ?>%"></div>
                    </div>
                    <span class="info-box-number"><img src="<?php echo base_url(); ?>assets/rms/dist/img/dashboard2.png" width="25" class="mr-1" style="margin-top: -3px;" /> <?php echo number_format($truck->oddo_terakhir, 0, "", "."); ?>/<?php echo number_format($truck->pergantian_oli_gardan_selanjutnya, 0, "", "."); ?> KM | Kurang <?php echo number_format($truck->kurang_oli_gardan, 0, "", "."); ?> KM</span>
                    <span style="font-size: 14px; font-style:italic;">Terakhir ganti oli gardan pada <b>KM <?php echo number_format($truck->oddo_terakhir_oli_gardan, 0, "", "."); ?></b></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box">
                  <span class="info-box-icon <?php if ($truck->persentase_penggunaan_oli_transmisi > '90') {
                                                echo 'bg-danger';
                                              } elseif ($truck->persentase_penggunaan_oli_transmisi > '80' and $truck->persentase_penggunaan_oli_transmisi < '90') {
                                                echo 'bg-warning';
                                              } else {
                                                echo 'bg-success';
                                              } ?>"><img src="<?php echo base_url(); ?>assets/rms/dist/img/engine-oil.png" width="40" /> </span>
                  <div class="info-box-content">
                    <div class="d-flex justify-content-md-between">
                      <span class="info-box-text">Oli Transmisi</span>
                      <span class="info-box-number mt-0"><?php echo $truck->persentase_penggunaan_oli_transmisi; ?>%</span>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-green" style="width: <?php echo $truck->persentase_penggunaan_oli_transmisi; ?>%"></div>
                    </div>
                    <span class="info-box-number"><img src="<?php echo base_url(); ?>assets/rms/dist/img/dashboard2.png" width="25" class="mr-1" style="margin-top: -3px;" /> <?php echo number_format($truck->oddo_terakhir, 0, "", "."); ?>/<?php echo number_format($truck->pergantian_oli_transmisi_selanjutnya, 0, "", "."); ?> KM | Kurang <?php echo number_format($truck->kurang_oli_transmisi, 0, "", "."); ?> KM</span>
                    <span style="font-size: 14px; font-style:italic;">Terakhir ganti oli transmisi pada <b>KM <?php echo number_format($truck->oddo_terakhir_oli_transmisi, 0, "", "."); ?></b></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
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
              <div class="col-md-3">
                <div class="info-box mb-3 <?php if ($truck->sisa_hari_pajak_tahunan > 0 and $truck->sisa_hari_pajak_tahunan < '30') {
                                            echo 'bg-danger';
                                          } elseif ($truck->sisa_hari_pajak_tahunan >= '30' and $truck->sisa_hari_pajak_tahunan < '60') {
                                            echo 'bg-warning';
                                          } else {
                                            echo 'bg-success';
                                          } ?>">
                  <span class="info-box-icon"><i class="fas fa-money-check"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Pajak Tahunan</span>
                    <span class="info-box-number mt-0">
                      <?php if ($truck->sisa_hari_pajak_tahunan > 0) { ?>
                        <?php echo shortdate_indo($truck->pajak_tahunan); ?><br>
                        <small style="font-style:italic;"> Sisa
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
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box mb-3 <?php if ($truck->sisa_hari_pajak_5_tahunan > 0 and $truck->sisa_hari_pajak_5_tahunan < '30') {
                                            echo 'bg-danger';
                                          } elseif ($truck->sisa_hari_pajak_5_tahunan >= '30' and $truck->sisa_hari_pajak_5_tahunan < '60') {
                                            echo 'bg-warning';
                                          } else {
                                            echo 'bg-success';
                                          } ?>">
                  <span class="info-box-icon"><i class="fas fa-money-check"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Pajak 5 Tahunan</span>
                    <span class="info-box-number mt-0">
                      <?php if ($truck->sisa_hari_pajak_5_tahunan > 0) { ?>
                        <?php echo shortdate_indo($truck->pajak_5_tahunan); ?><br>
                        <small style="font-style:italic;">Sisa
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
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box mb-3 <?php if ($truck->sisa_hari_kir > 0 and $truck->sisa_hari_kir < '7') {
                                            echo 'bg-danger';
                                          } elseif ($truck->sisa_hari_kir >= '7' and $truck->sisa_hari_kir < '30') {
                                            echo 'bg-warning';
                                          } else {
                                            echo 'bg-success';
                                          } ?>">
                  <span class="info-box-icon"><i class="fas fa-money-check"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Kir</span>
                    <span class="info-box-number mt-0">
                      <?php if ($truck->sisa_hari_kir > 0) { ?>
                        <?php echo shortdate_indo($truck->kir_selanjutnya); ?><br>
                        <small style="font-style:italic;">Sisa
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
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
            </div>
          <?php } ?>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title mt-2">Riwayat Penggunaan Truk</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-striped table-valign-middle data-table-default">
                    <thead>
                      <tr>
                        <th class="align-middle">No Kontrak</th>
                        <th class="align-middle">Tanggal muat</th>
                        <th class="align-middle">Tanggal bongkar</th>
                        <th class="align-middle">Supir</th>
                        <th class="align-middle">Tujuan</th>
                        <!-- <th class="align-middle">Status</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($rekap as $row) : ?>
                        <tr>
                          <td><?php echo $row->no_kontrak; ?></td>
                          <td>
                            <?php
                            if ($row->tanggal_muat) {
                              echo shortdate_indo($row->tanggal_muat);
                            }
                            ?>
                          </td>
                          <td>
                            <?php
                            if ($row->tanggal_bongkar) {
                              echo shortdate_indo($row->tanggal_bongkar);
                            }
                            ?>
                          </td>
                          <td><?php echo $row->nama_supir; ?></td>
                          <td><?php echo $row->nama_tujuan; ?></td>
                          <!-- <td>
                            <?php if ($row->status == '0') { ?>
                              <span class="badge badge-warning">Sedang Mengirim</span>
                            <?php } else { ?>
                              <span class="badge badge-secondary">Selesai</span>
                            <?php } ?>
                          </td> -->
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </div>

            <?php if ($truck->kategori == '1') { ?>
              <div class="col-md-7">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title mt-2">Riwayat Perbaikan Truk</h3>
                    <div class="card-tools mr-1">
                      <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_perbaikan()"><i class="fas fa-plus mr-1"></i> Input</button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-striped table-valign-middle data-table-default">
                      <thead>
                        <tr>
                          <th class="align-middle">Tanggal Perbaikan</th>
                          <th class="align-middle">Supir</th>
                          <th class="align-middle">Jenis</th>
                          <th class="align-middle">Deskripsi</th>
                          <th class="align-middle">Harga</th>
                          <th class="align-middle">status</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($perbaikan_reguler as $row) : ?>
                          <tr>
                            <td><?php if ($row->tanggal_perbaikan) {
                                  echo shortdate_indo($row->tanggal_perbaikan);
                                } ?></td>
                            <td><?php echo $row->nama_supir; ?></td>


                            <td>
                              <?php if ($row->id_kategori == '1') { ?>
                                <span class="badge badge-primary">Perbaikan Reguler</span>
                              <?php } elseif ($row->id_kategori == '2') { ?>
                                <span class="badge badge-primary">Pergantian Oli</span>
                              <?php } ?>
                            </td>
                            <td><?php echo $row->jenis_perbaikan; ?></td>
                            <td>Rp <?php echo number_format($row->jumlah, 0, "", "."); ?></td>
                            <td>
                              <?php if ($row->status == '0') { ?>
                                <span class="badge badge-secondary"><?php echo $row->nama_status; ?></span>
                              <?php } elseif ($row->status == '1') { ?>
                                <span class="badge badge-warning"><?php echo $row->nama_status; ?></span>
                              <?php } elseif ($row->status == '2') { ?>
                                <span class="badge badge-success"><?php echo $row->nama_status; ?></span>
                              <?php } ?>
                            </td>
                            <td class="project-actions text-right">
                              <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit_perbaikan(<?php echo $row->id_perbaikan; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fas fa-pencil-alt">
                                </i>
                              </a>
                              <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_perbaikan(<?php echo $row->id_perbaikan; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
                                <i class="fas fa-trash">
                                </i>
                              </a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>Total Perbaikan</td>
                          <td>Rp <?php echo number_format($total_perbaikan->total_perbaikan, 0, "", "."); ?></td>
                          <td></td>
                          <td></td>
                              </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
              <div class="col-md-5">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title mt-2">Riwayat Pengisian BBM</h3>
                    <div class="card-tools mr-1">
                      <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_riwayat_bbm()"><i class="fas fa-plus mr-1"></i> Input</button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-striped table-valign-middle data-table-default">
                      <thead>
                        <tr>
                          <th class="align-middle">Tanggal</th>
                          <th class="align-middle">Jumlah liter</th>
                          <th class="align-middle">Jumlah harga</th>
                          <th class="align-middle">Supir</th>
                          <th class="align-middle"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($bbm as $row) : ?>
                          <tr>
                            <td><?php if ($row->tanggal) {
                                  echo shortdate_indo($row->tanggal);
                                } ?></td>
                            <td><?php echo $row->jumlah_liter; ?></td>
                            <td>Rp <?php echo number_format($row->jumlah_harga, 0, "", "."); ?></td>
                            <td><?php echo $row->nama_supir; ?></td>
                            <td class="project-actions text-right">
                              <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fas fa-pencil-alt">
                                </i>
                              </a>
                              <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_data(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
                                <i class="fas fa-trash">
                                </i>
                              </a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- /.container-fluid -->


    <div class="modal fade" id="input-pergantian-oli">
      <div class="modal-dialog modal-lg">
        <form id="form_pergantian_oli" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Pergantian Oli</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Supir</label>
                    <input type="hidden" class="form-control" name="id" id="id">
                    <input type="hidden" class="form-control" name="truck" id="truck" value="<?php echo $truck->id_truck; ?>">
                    <input type="hidden" class="form-control" name="kategori" id="kategori" value="2">
                    <select class="form-control select2" style="width: 100%;" name="supir" id="supir">
                      <option value="0">Pilih supir</option>
                      <?php foreach ($supir as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <input type="hidden" class="form-control" id="nama_supir" name="nama_supir">
                  </div>

                  <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control" name="jenis" rows="2"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal perbaikan</label>
                    <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal" id="tanggal" />
                      <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cicilan">Jumlah</label>
                    <input type="text" class="form-control number" id="jumlah" name="jumlah" placeholder="Input jumlah biaya perbaikan">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Foto Nota</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="nota" name="nota">
                      <label class="custom-file-label" for="nota" id="label-nota">Pilih file pdf/jpg</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="kategori">Status</label>
                    <select id="colorselector" class="form-control" name="status">
                      <option>Pilih status</option>
                      <option value="0">Belum dibayar</option>
                      <option value="1">Sudah dibayar</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer" style="justify-content: flex-start;">
              <button type="submit" class="btn btn-primary">Save changes</button>
              <div class="loading" style="display: none;">
                <img src="<?php echo base_url(); ?>assets/rms/dist/img/ajax-loader.gif" />
              </div>
            </div>
          </div>
        </form>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="input-perbaikan">
      <div class="modal-dialog modal-lg">
        <form id="form_perbaikan" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Perbaikan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">

                  <input type="hidden" class="form-control" name="id" id="id">
                  <input type="hidden" class="form-control" name="truck" id="truck" value="<?php echo $truck->id_truck; ?>">
                  <input type="hidden" class="form-control" name="kategori" id="kategori" value="1">
                  <div class="form-group">
                    <label>Supir</label>
                    <select class="form-control select2" style="width: 100%;" name="supir" id="supir">
                      <option value="0">Pilih supir</option>
                      <?php foreach ($supir as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <input type="hidden" class="form-control" id="nama_supir" name="nama_supir">
                  </div>

                  <div class="form-group">
                    <label>Jenis Perbaikan</label>
                    <textarea class="form-control" name="jenis" rows="2"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal perbaikan</label>
                    <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal" id="tanggal" />
                      <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">

                  <div class="form-group">
                    <label for="cicilan">Jumlah</label>
                    <input type="text" class="form-control number" id="jumlah" name="jumlah" placeholder="Input jumlah biaya perbaikan">
                  </div>

                  <div class="form-group">
                    <label for="no_replas">Foto Nota</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="nota" name="nota">
                      <label class="custom-file-label" for="nota" id="label-nota">Pilih file pdf/jpg</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="kategori">Status</label>
                    <select id="colorselector" class="form-control" name="status">
                      <option>Pilih status</option>
                      <option value="0">Belum dibayar</option>
                      <option value="1">Sudah dibayar</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12" id="sparepart-content">
                  <hr>
                  <h3 style="font-size: 1.5rem;">Sparepart Kantor</h3>
                  <table class="table mt-3" id="perbaikan_sparepart">
                    <thead class="bg-dark">
                      <tr>
                        <th>Nama Sparepart</th>
                        <th>Jumlah</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <select class="form-control select2" style="width: 100%;" name="sparepart" id="sparepart">
                            <option value="0">Pilih sparepart</option><?php foreach ($sparepart as $row) : ?><option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option><?php endforeach; ?>
                          </select>
                        </td>
                        <td><input type="text" class="form-control" name="jumlah_sparepart" style="width:100px;" /></td>
                        <td>
                          <button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></button>
                        </td>
                      </tr>
                    </tbody>
                    <tbody id="tbody2">

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer" style="justify-content: flex-start;">
              <button type="submit" class="btn btn-primary">Save changes</button>
              <div class="loading" style="display: none;">
                <img src="<?php echo base_url(); ?>assets/rms/dist/img/ajax-loader.gif" />
              </div>
            </div>
          </div>
        </form>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="input-riwayat-bbm">
      <div class="modal-dialog modal-md">
        <form id="form_riwayat_bbm" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Riwayat BBM</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                <input type="hidden" class="form-control" name="id_truck" id="id_truck" placeholder="id_truck" value="<?php echo $truck->id_truck; ?>">
                <label for="no_replas">Tanggal Pengisian</label>
                <div class="input-group date reservationdate" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate" data-toggle="datetimepicker" name="tanggal" id="tanggal" />
                  <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="no_replas">Jumlah Liter</label>
                <input type="text" class="form-control" id="jumlah_liter" name="jumlah_liter" placeholder="Input jumlah liter">
              </div>
              <div class="form-group">
                <label for="no_replas">Jumlah Harga</label>
                <input type="text" class="form-control number" id="jumlah_harga" name="jumlah_harga" placeholder="Input jumlah harga">
              </div>

              <div class="form-group">
                <label>Supir</label>
                <select class="form-control select2" style="width: 100%;" name="supir" id="supir">
                  <option value="0">Pilih supir</option>
                  <?php foreach ($supir as $row) : ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                  <?php endforeach; ?>
                </select>
                <input type="hidden" class="form-control" id="nama_supir" name="nama_supir">
              </div>

            </div>
            <div class="modal-footer" style="justify-content: flex-start;">
              <button type="submit" class="btn btn-primary">Save changes</button>
              <div class="loading" style="display: none;">
                <img src="<?php echo base_url(); ?>assets/rms/dist/img/ajax-loader.gif" />
              </div>
            </div>
          </div>
        </form>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </section>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
  function input_riwayat_bbm(id) {
    $('#form_riwayat_bbm')[0].reset();
    $("#supir").val(0).change();
    $("#input-riwayat-bbm").modal('show');
  }
  $('#form_riwayat_bbm').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_riwayat_bbm')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_pengisian_bbm/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_riwayat_bbm')[0].reset();
        $('.loading').hide();
        if (data.status = "true") {
          Swal.fire({
            icon: 'success',
            title: "Success!",
            text: "Schedule has been saved.",
            type: "success"
          }).then((result) => {
            location.reload();
          });
        } else {
          alert("failed!");
        }
      }
    });
  });

  $(function() {
    $('#supir').change(function() {
      $('#nama_supir').val($(this).find('option:selected').text());
    });
  });

  function input_pergantian_oli() {
    $('#form_pergantian_oli')[0].reset();
    $('[name="supir"]').val(<?php echo $truck->id_supir; ?>).change();
    $("#input-pergantian-oli").modal('show');
  }



  $('#form_pergantian_oli').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_pergantian_oli')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_perbaikan/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_pergantian_oli')[0].reset();
        $('.loading').hide();
        if (data.status = "true") {
          Swal.fire({
            icon: 'success',
            title: "Berhasil!",
            text: "Data berhasil disimpan.",
            type: "success"
          }).then((result) => {
            location.reload();
          });
        } else {
          alert("failed!");
        }
      }
    });
  });

  function edit_pergantian_oli(id) {
    $("#input-pergantian-oli").modal('show');
    $('.modal-title').html('Edit pergantian olid');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_perbaikan"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_pergantian_oli')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {

          $('[name="kategori"]').val(data[i].kategori);
          $('[name="truck"]').val(data[i].id_truck).change();
          $('[name="nopol"]').val(data[i].nopol);
          $('[name="supir"]').val(data[i].id_supir).change();
          $('[name="nama_supir"]').val(data[i].nama_supir);
          $('[name="jenis"]').val(data[i].jenis);
          $('[name="tanggal"]').val(data[i].tanggal);
          $('[name="jumlah"]').val($.number(data[i].jumlah).replace(/\,/g, '.'));
          $('#label-nota').html(data[i].nota);
          $('[name="status"]').val(data[i].status).change();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function edit(id) {
    $("#input-riwayat-bbm").modal('show');
    $('.modal-title').html('Edit Replas');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_pengisian_bbm"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_riwayat_bbm')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="tanggal"]').val(data[i].tanggal);
          $('[name="jumlah_liter"]').val(data[i].jumlah_liter);
          $('[name="jumlah_harga"]').val($.number(data[i].jumlah_harga).replace(/\,/g, '.'));
          $('[name="supir"]').val(data[i].id_supir).change();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_data(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      $.ajax({
        url: "<?php echo base_url() ?>rms/delete",
        type: "POST",
        data: {
          id: id,
          tbl: "tbl_pengisian_bbm"
        },
        dataType: "JSON",
        success: function(data) {
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          ).then((result) => {
            location.reload();
          });
        }
      });
    })
  }

  function delete_pergantian_oli(id) {
    Swal.fire({
      title: 'Hapus data?',
      text: "Setelah data dihapus, data tidak dapat kembali!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url() ?>rms/delete_perbaikan",
          type: "POST",
          data: {
            id: id,
          },
          dataType: "JSON",
          success: function(data) {
            Swal.fire(
              'Berhasil!',
              'Data perbaikan berhasil dihapus.',
              'success'
            ).then((result) => {
              location.reload();
            });
          }
        });
      }
    })
  }












  function input_perbaikan() {
    $('#form_perbaikan')[0].reset();
    $('#sparepart-content').hide();
    $("#input-perbaikan").modal('show');
    $('[name="supir"]').val(<?php echo $truck->id_supir; ?>).change();
  }

  $('#form_perbaikan').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_perbaikan')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_perbaikan/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_perbaikan')[0].reset();
        $('.loading').hide();
        if (data.status = "true") {
          Swal.fire({
            icon: 'success',
            title: "Berhasil!",
            text: "Data berhasil disimpan.",
            type: "success"
          }).then((result) => {
            location.reload();
          });
        } else {
          alert("failed!");
        }
      }
    });
  });

  function edit_perbaikan(id) {
    $('#sparepart-content').show();
    load_data_sparepart_perbaikan(id);
    $("#input-perbaikan").modal('show');
    $('.modal-title').html('Edit perbaikan');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_perbaikan"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_perbaikan')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {

          $('[name="kategori"]').val(data[i].kategori).change();
          $('[name="truck"]').val(data[i].id_truck).change();
          $('[name="nopol"]').val(data[i].nopol);
          $('[name="supir"]').val(data[i].id_supir).change();
          $('[name="nama_supir"]').val(data[i].nama_supir);
          $('[name="jenis"]').val(data[i].jenis);
          $('[name="tanggal"]').val(data[i].tanggal);
          $('[name="jumlah"]').val($.number(data[i].jumlah).replace(/\,/g, '.'));
          $('#label-nota').html(data[i].nota);
          $('[name="status"]').val(data[i].status).change();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_perbaikan(id) {
    Swal.fire({
      title: 'Hapus data?',
      text: "Setelah data dihapus, data tidak dapat kembali!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url() ?>rms/delete_perbaikan",
          type: "POST",
          data: {
            id: id,
          },
          dataType: "JSON",
          success: function(data) {
            Swal.fire(
              'Berhasil!',
              'Data perbaikan berhasil dihapus.',
              'success'
            ).then((result) => {
              location.reload();
            });
          }
        });
      }
    })
  }

  function load_data_sparepart_perbaikan(id) {
    $.ajax({
      url: "<?php echo base_url(); ?>rms/load_data_sparepart_perbaikan/" + id,
      dataType: "JSON",
      success: function(data) {
        $('table#perbaikan_sparepart #tbody2').html('');
        for (var i = 0; i < data.length; i++) {
          var html = '<tr>';
          html += '<td class="table_data" data-row_id="' + data[i].id + '" data-column_name="nama" >' + data[i].nama_sparepart + '</td>';
          html += '<td class="table_data" data-row_id="' + data[i].id + '" data-column_name="jumlah" >' + data[i].jumlah + '</td>';
          html += '<td><button type="button" name="delete_btn" id="' + data[i].id + '" data-id="' + id + '" data-id-sparepart="' + data[i].id_sparepart + '" data-jumlah="' + data[i].jumlah + '" class="btn btn-xs btn-danger btn_delete"><i class="fa fa-times"></i></button></td></tr>';
          $('table#perbaikan_sparepart #tbody2').append(html);
        }

      }
    });
  }

  $(document).ready(function() {
    $(document).on('click', '#btn_add', function() {
      var sparepart = $('[name="sparepart"]').val();
      var jumlah = $('[name="jumlah_sparepart"]').val();
      var id_perbaikan = $('[name="id"]').val();
      $.ajax({
        url: "<?php echo base_url(); ?>rms/insert_sparepart_perbaikan",
        method: "POST",
        data: {
          id_sparepart: sparepart,
          id_perbaikan: id_perbaikan,
          jumlah: jumlah
        },
        success: function(data) {
          load_data_sparepart_perbaikan(id_perbaikan);
        }
      })
    });

    $(document).on('click', '.btn_delete', function() {
      var id = $(this).attr('id');
      var id_perbaikan = $(this).attr('data-id');
      var id_sparepart = $(this).attr('data-id-sparepart');
      var jumlah = $(this).attr('data-jumlah');
      Swal.fire({
        title: 'Hapus data?',
        text: "Data yang telah dihapus tidak dapat dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?php echo base_url() ?>rms/delete_perbaikan_sparepart",
            type: "POST",
            data: {
              id: id,
              id_sparepart: id_sparepart,
              jumlah: jumlah,
            },
            success: function(data) {
              Swal.fire(
                'Berhasil!',
                'Data berhasil dihapus.',
                'success'
              ).then((result) => {
                load_data_sparepart_perbaikan(id_perbaikan);
              });
            }
          });
        }
      })
    });
  });
</script>