<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Project</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>project/">Project</a></li>
            <li class="breadcrumb-item"><?php echo $project->no_do; ?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- /.card-header -->
          <div class="row">
            <div class="col-12 col-md-12 col-lg-6 order-1 order-md-1">
              <div class="card">
                <div class="card-body">
                  <h3 class="text-primary"><i class="fas fa-building"></i> <?php echo $project->nama_perusahaan; ?></h3>
                  <br>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="text-muted">
                        <p class="text-sm">No Kontrak
                          <b class="d-block"><?php echo $project->no_kontrak; ?></b>
                        </p>
                        <p class="text-sm">No STO
                          <b class="d-block"><?php echo $project->no_sto; ?></b>
                        </p>
                        <p class="text-sm">No PO
                          <b class="d-block"><?php echo $project->no_po; ?></b>
                        </p>
                        <p class="text-sm">No DO
                          <b class="d-block"><?php echo $project->no_do; ?></b>
                        </p>
                        <p class="text-sm">Komoditas
                          <b class="d-block"><?php echo $project->komoditas; ?></b>
                        </p>

                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="text-muted">
                        <p class="text-sm">Tujuan
                          <b class="d-block"><?php echo $project->nama_tujuan; ?></b>
                        </p>
                        <p class="text-sm">Harga Satuan
                          <b class="d-block">Rp <?php echo number_format($project->harga_unit, 0, "", "."); ?></b>
                        </p>
                        <p class="text-sm">Toleransi Susut
                          <b class="d-block"><?php echo $project->toleransi_susut; ?> kg</b>
                        </p>
                        <p class="text-sm">Tanggal Angkut
                          <b class="d-block"><?php echo shortdate_indo($project->tanggal_angkut); ?></b>
                        </p>
                        <p class="text-sm">Tanggal Selesai
                          <b class="d-block"><?php echo shortdate_indo($project->tanggal_selesai); ?></b>
                        </p>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="text-muted">

                        <p class="text-sm">Total Susut
                          <b class="d-block"><?php if ($project->total_susut != NULL) {
                                                echo number_format($project->total_susut, 0, "", ".");
                                              } else {
                                                echo "-";
                                              }  ?> kg</b>
                        </p>
                        <p class="text-sm">Total Uang Sangu
                          <b class="d-block">Rp <?php if ($project->total_uang_sangu != NULL) {
                                                  echo number_format($project->total_uang_sangu, 0, "", ".");
                                                } else {
                                                  echo "0";
                                                } ?></b>
                        </p>
                        <p class="text-sm">Biaya Claim
                          <b class="d-block">Rp <?php if ($project->harga_claim_satuan != NULL) {
                                                  echo number_format($project->harga_claim_satuan, 0, "", ".");
                                                } else {
                                                  echo "0";
                                                } ?></b>
                        </p>
                        <p class="text-sm">Jasa Muat
                          <b class="d-block">Rp <?php if ($project->estimasi_total_harga_jasa_muat != NULL) {
                                                  echo number_format($project->estimasi_total_harga_jasa_muat, 0, "", ".");
                                                } else {
                                                  echo "0";
                                                }  ?></b>
                        </p>
                        <p class="text-sm">Jasa Bongkar
                          <b class="d-block">Rp <?php if ($project->estimasi_total_harga_jasa_muat != NULL) {
                                                  echo number_format($project->estimasi_total_harga_jasa_bongkar, 0, "", ".");
                                                } else {
                                                  echo "0";
                                                } ?></b>
                        </p>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="text-muted">
                        <p class="text-sm">Total Claim
                          <b class="d-block"><?php if ($project->total_claim != NULL) {
                                                echo number_format($project->total_claim, 0, "", ".");
                                              } else {
                                                echo "0";
                                              } ?> Kg</b>
                        </p>
                        <p class="text-sm">Total Biaya Claim
                          <b class="d-block">Rp <?php if ($project->total_biaya_claim != NULL) {
                                                  echo number_format($project->total_biaya_claim, 0, "", ".");
                                                } else {
                                                  echo "0";
                                                } ?></b>
                        </p>
                        <p class="text-sm">Total Replas
                          <b class="d-block">Rp <?php if ($project->total_pengeluaran != NULL) {
                                                  echo number_format($project->total_pengeluaran, 0, "", ".");
                                                } else {
                                                  echo "0";
                                                } ?></b>
                        </p>
                        <p class="text-sm">Status
                          <b class="d-block text-green"><?php echo $project->nama_status; ?></b>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6 order-2 order-md-2">
              <div class="row">
                <div class="col-12 col-sm-4">
                  <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fa fa-weight"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Total Qty</span>
                      <span class="info-box-number"><?php echo number_format($project->qty, 0, "", "."); ?> Kg</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fa fa-money-bill"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Nilai Project</span>
                      <span class="info-box-number">Rp <?php if ($project->total_nilai != NULL) {
                                                          echo number_format($project->total_nilai, 0, "", ".");
                                                        } else {
                                                          echo "0";
                                                        } ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fa fa-calendar"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Durasi Project</span>
                      <span class="info-box-number"><?php echo $project->sisa_durasi_project; ?> / <?php echo $project->durasi_project; ?> Hari</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>

                <div class="col-12 col-sm-12">
                  <div class="info-box bg-primary">
                    <span class="info-box-icon"><i class="fa fa-weight"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Status Project</span>
                      <span class="info-box-number">Terkirim <?php if ($project->total_terkirim != NULL) {
                                                                echo number_format($project->total_terkirim, 0, "", ".");
                                                              } else {
                                                                echo "0";
                                                              } ?> kg dari <?php if ($project->total_terkirim != NULL) {
                                                                              echo number_format($project->qty, 0, "", ".");
                                                                            } else {
                                                                              echo "0";
                                                                            } ?> kg</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: <?php echo $project->persentase_terkirim; ?>%"></div>
                      </div>
                      <span class="progress-description">
                        <?php echo $project->persentase_terkirim; ?>% Terkirim | Sisa kirim <?php if ($project->total_terkirim != NULL) {
                                                                                              echo number_format($project->sisa_kirim, 0, "", ".");
                                                                                            } else {
                                                                                              echo "0";
                                                                                            } ?> Kg
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Dokumen Project </h3>
                </div>
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>assets/rms/documents/spk/<?php echo $project->file_spk; ?>" class="link-black text-sm mr-3" target="_blank"><i class="fas fa-file mr-1"></i> File SPK</a>
                  <a href="<?php echo base_url(); ?>assets/rms/documents/do/<?php echo $project->file_do; ?>" class="link-black text-sm mr-3" target="_blank"><i class="fas fa-file mr-1"></i> File DO</a>
                  <!--a href="#" class="text-sm btn btn-danger btn-sm text-sm mr-1"><i class="fas fa-print mr-1"></i> Cetak Invoice</a-->
                  <a href="<?php echo base_url(); ?>project/kwitansi/<?php echo $project->id_project; ?>" class="text-sm btn btn-success btn-sm text-sm"><i class="fas fa-print mr-1"></i> Kwitansi</a>
                  <a href="<?php echo base_url(); ?>rms/download_replas/<?php echo $project->id_project; ?>" class="text-sm btn btn-success btn-sm text-sm"><i class="fas fa-download mr-1"></i> Download data replas</a>
                </div>
              </div>
            </div>

            <!-- /.card-body -->
          </div>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title mt-2">Rekapitulasi Data</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_replas()"><i class="fas fa-plus mr-1"></i> Tambah Angkutan</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered data-table">
                <thead class="thead-dark">
                  <tr>
                    <th rowspan="2" class="text-center align-middle">#</th>
                    <th rowspan="2" class="text-center align-middle">No Replas</th>
                    <th rowspan="2" class="text-center align-middle">Tanggal Muat</th>
                    <th rowspan="2" class="text-center align-middle">Tanggal Bongkar</th>
                    <th rowspan="2" class="text-center align-middle">Supir</th>
                    <th rowspan="2" class="text-center align-middle">Nopol</th>
                    <th rowspan="2" class="text-center align-middle">Tujuan</th>
                    <?php if ($project->id_komoditas == '2' || ($project->id_komoditas == '3' and $project->id_klien == '6')) { ?>
                      <th colspan="3" class="text-center align-middle">Qty Awal</th>
                      <th colspan="3" class="text-center align-middle">Qty Akhir</th>
                    <?php } else { ?>
                      <th colspan="2" class="text-center align-middle">Qty Awal</th>
                      <th colspan="2" class="text-center align-middle">Qty Akhir</th>
                    <?php } ?>
                    <th colspan="2" class="text-center align-middle">Susut</th>
                    <th rowspan="2" class="text-center align-middle">Status</th>
                    <th rowspan="2" class="text-center align-middle">Action</th>
                  </tr>
                  <tr>
                    <?php if ($project->id_komoditas == '2' || ($project->id_komoditas == '3' and $project->id_klien == '6')) { ?>
                      <th class="text-center align-middle">Bruto</th>
                      <th class="text-center align-middle">Tarra</th>
                      <th class="text-center align-middle">Netto</th>
                      <th class="text-center align-middle">Bruto</th>
                      <th class="text-center align-middle">Tarra</th>
                      <th class="text-center align-middle">Netto</th>
                    <?php } else { ?>
                      <th class="text-center align-middle">Bag</th>
                      <th class="text-center align-middle">Kg</th>
                      <th class="text-center align-middle">Bag</th>
                      <th class="text-center align-middle">Kg</th>
                    <?php } ?>
                    <th class="text-center align-middle">M</th>
                    <th class="text-center align-middle">C</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 0;

                  foreach ($rekap as $row) : $no++; ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->no_replas; ?></td>
                      <td><?php if ($row->tanggal_muat) {
                            echo shortdate_indo($row->tanggal_muat);
                          } ?></td>
                      <td><?php if ($row->tanggal_bongkar) {
                            echo shortdate_indo($row->tanggal_bongkar);
                          } ?></td>
                      <td><?php echo $row->nama_supir; ?></td>
                      <td><?php echo $row->nopol; ?></td>
                      <td><?php echo $row->kode_tujuan; ?></td>
                      <?php if ($project->id_komoditas == '2' || ($project->id_komoditas == '3' and $project->id_klien == '6')) { ?>
                        <td><?php if ($row->bruto_awal != NULL) {
                              echo number_format($row->bruto_awal, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?> Kg</td>
                        <td><?php if ($row->tarra_awal != NULL) {
                              echo number_format($row->tarra_awal, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?> Kg</td>
                        <td><?php if ($row->timbang_kebun_kg != NULL) {
                              echo number_format($row->timbang_kebun_kg, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?></td>

                        <td><?php if ($row->bruto_akhir != NULL) {
                              echo number_format($row->bruto_akhir, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?> Kg</td>
                        <td><?php if ($row->tarra_akhir != NULL) {
                              echo number_format($row->tarra_akhir, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?> Kg</td>
                        <td><?php if ($row->qty_kirim_kg != NULL) {
                              echo number_format($row->qty_kirim_kg, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?></td>
                      <?php } else { ?>
                        <td><?php if ($row->timbang_kebun_bag != NULL) {
                              echo number_format($row->timbang_kebun_bag, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?></td>
                        <td><?php if ($row->timbang_kebun_kg != NULL) {
                              echo number_format($row->timbang_kebun_kg, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?> Kg</td>
                        <td><?php if ($row->qty_kirim_bag != NULL) {
                              echo number_format($row->qty_kirim_bag, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?></td>
                        <td><?php if ($row->qty_kirim_kg != NULL) {
                              echo number_format($row->qty_kirim_kg, 0, "", ".");
                            } else {
                              echo "0";
                            }  ?> Kg</td>
                      <?php } ?>
                      <td><?php if ($row->m_susut != NULL) {
                            echo number_format($row->m_susut, 0, "", ".");
                          } else {
                            echo "0";
                          } ?> Kg</td>
                      <td><?php if ($row->c_claim != NULL) {
                            echo number_format($row->c_claim, 0, "", ".");
                          } else {
                            echo "0";
                          }  ?> Kg</td>
                      <td><span class="badge <?php if ($row->status == '0') { ?>bg-warning <?php } else { ?> bg-success <?php } ?>"><?php echo $row->nama_status; ?></span></td>

                      <td class="project-actions text-right">
                        <?php if ($row->no_replas != "" and $row->no_replas != "0" and $row->no_replas != NULL and $row->status != "1") { ?>
                          <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="bayar_replas(<?php echo $row->id_rekap; ?>)" data-toggle="tooltip" data-placement="top" title="Bayar Replas">
                            <i class="fas fa-credit-card">
                            </i>
                          </a>
                        <?php } ?>
                        <a class="btn btn-warning btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_rekap; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_data(<?php echo $row->id_rekap; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
                          <i class="fas fa-trash">
                          </i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  <tr>
                    <?php if ($project->id_komoditas == '2' || ($project->id_komoditas == '3' and $project->id_klien == '6')) { ?>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>Total : <?php echo number_format($total->total_bruto_awal, 0, "", "."); ?> Kg</td>
                      <td>Total : <?php echo number_format($total->total_tarra_awal, 0, "", "."); ?> Kg</td>
                      <td>Total : <?php echo number_format($total->total_qty_awal_kg, 0, "", "."); ?> Kg</td>
                      <td>Total : <?php echo number_format($total->total_bruto_akhir, 0, "", "."); ?> Kg</td>
                      <td>Total : <?php echo number_format($total->total_tarra_akhir, 0, "", "."); ?> Kg</td>
                      <td>Total : <?php echo number_format($total->total_qty_akhir_kg, 0, "", "."); ?> Kg</td>
                      <td>Total : <?php echo number_format($total->total_susut, 0, "", "."); ?> Kg</td>
                      <td></td>
                      <td></td>
                      <td></td>

                    <?php } else { ?>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>Total : <?php echo number_format($total->total_qty_awal_bag, 0, "", "."); ?> Bag</td>
                      <td>Total : <?php echo number_format($total->total_qty_awal_kg, 0, "", "."); ?> Kg</td>
                      <td>Total : <?php echo number_format($total->total_qty_akhir_bag, 0, "", "."); ?> Bag</td>
                      <td>Total : <?php echo number_format($total->total_qty_akhir_kg, 0, "", "."); ?> Kg</td>
                      <td>Total : <?php echo number_format($total->total_susut, 0, "", "."); ?> Kg</td>
                      <td></td>
                      <td></td>
                      <td></td>
                    <?php } ?>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title mt-2">Riwayat Pembayaran Jasa Bongkar Muat</h3>
                  <div class="card-tools mr-1">
                    <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_pembayaran_bongkar_muat(<?php echo $project->id_project; ?>)"><i class="fas fa-plus mr-1"></i> Input Pembayaran</button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered table-striped data-table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pembayaran</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      foreach ($pembayaran_bongkar_muat as $row) :
                        $no++;
                      ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php if ($row->jenis == '1') {
                                echo "Bongkar";
                              } else {
                                echo "Muat";
                              } ?></td>
                          <td>Rp <?php echo number_format($row->jumlah_pembayaran, 0, "", "."); ?></td>
                          <td><?php echo shortdate_indo($row->tanggal_pembayaran); ?></td>
                          <td class="project-actions text-right">
                            <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit_bongkar_muat(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                              <i class="fas fa-pencil-alt">
                              </i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_bongkar_muat(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
                              <i class="fas fa-trash">
                              </i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title mt-2">Riwayat Pembayaran Replas</h3>
                  <div class="card-tools mr-1">
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered table-striped data-table">
                    <thead>
                      <tr>
                        <th>No Replas</th>
                        <th>Vendor</th>
                        <th>Nominal Pembayaran</th>
                        <th>Tanggal Pembayaran</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($pembayaran_replas as $row) :
                      ?>
                        <tr>
                          <td><?php echo $row->no_replas; ?></td>
                          <td><?php echo $row->vendor; ?></td>
                          <td>Rp <?php echo number_format($row->grand_total, 0, "", "."); ?></td>
                          <td><?php echo shortdate_indo($row->tanggal_pembayaran_replas); ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No Replas</th>
                        <th>Vendor</th>
                        <th>Nominal Pembayaran</th>
                        <th>Tanggal Pembayaran</th>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="input-replas">
      <div class="modal-dialog modal-lg">
        <form id="form_replas" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Replas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                    <input type="hidden" class="form-control" name="id_project" id="id_project" placeholder="id_project" value="<?php echo $project->id_project; ?>">

                    <label for="no_replas">Nomor Replas</label>
                    <input type="text" class="form-control" id="no_replas" name="no_replas" placeholder="Input nomor replas">
                  </div>
                  <?php if ($project->id_klien == '8' || $project->id_klien == '9' || $project->id_klien == '16') { ?>
                    <div class="form-group">
                    <label for="no_replas">Nomor Tiket</label>
                    <input type="text" class="form-control" id="no_tiket" name="no_tiket" placeholder="Input nomor tiket">
                  </div>
                  <?php } ?>


                  <div class="form-group">
                    <label for="no_replas">Tanggal Muat</label>
                    <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal_muat" id="tanggal_muat" />
                      <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal Bongkar</label>
                    <div class="input-group date reservationdate reservationdate2" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate2" data-toggle="datetimepicker" name="tanggal_bongkar" id="tanggal_bongkar" />
                      <div class="input-group-append" data-target=".reservationdate2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Supir</label>
                    <select class="form-control select2" style="width: 100%;" name="supir" id="supir">
                      <option value="0">Pilih supir</option>
                      <?php foreach ($supir as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Truck</label>
                    <select class="form-control select2" style="width: 100%;" name="truck" id="truck">
                      <option value="0">Pilih truk</option>
                      <?php foreach ($truck as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nopol; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Vendor Pajak</label>
                    <select class="form-control select2" style="width: 100%;" name="vendor_pajak" id="vendor_pajak">
                      <option value="0">Pilih vendor pajak</option>
                      <?php foreach ($vendor as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tujuan</label>
                    <select class="form-control select2" style="width: 100%;" name="tujuan" id="tujuan">
                      <option value="0">Pilih tujuan</option>
                      <?php foreach ($tujuan as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->kode_tujuan; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Qty Awal</label>
                    <div class="row">
                      <?php if ($project->id_komoditas == '2' || ($project->id_komoditas == '3' and $project->id_klien == '6')) { ?>
                        <div class="col-md-4">
                          <label for="no_replas">Bruto Awal</label>
                          <input type="text" class="form-control number" name="bruto_awal" id="bruto_awal" placeholder="Bruto awal (kg)">
                        </div>
                        <div class="col-md-4">
                          <label for="no_replas">Tarra Awal</label>
                          <input type="text" class="form-control number" name="tarra_awal" id="tarra_awal" placeholder="Tarra awal (kg)">
                        </div>
                        <div class="col-md-4">
                          <label for="no_replas">Netto Awal</label>
                          <input type="text" class="form-control number" name="timbang_kebun_kg" id="timbang_kebun_kg" placeholder="Netto (kg)">
                        </div>
                      <?php } else { ?>
                        <div class="col-md-6">
                          <label for="no_replas">Bag</label>
                          <input type="text" class="form-control" name="timbang_kebun_bag" id="timbang_kebun_bag" placeholder="Bag">
                        </div>
                        <div class="col-md-6">
                          <label for="no_replas">Kg</label>
                          <input type="text" class="form-control number" name="timbang_kebun_kg" id="timbang_kebun_kg" placeholder="Kg">
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Qty Akhir</label>
                    <div class="row">
                      <?php if ($project->id_komoditas == '2' || ($project->id_komoditas == '3' and $project->id_klien == '6')) { ?>
                        <div class="col-md-4">
                          <label for="no_replas">Bruto Akhir</label>
                          <input type="text" class="form-control number" name="bruto_akhir" id="bruto_akhir" placeholder="Bruto akhir (kg)">
                        </div>
                        <div class="col-md-4">
                          <label for="no_replas">Tarra Akhir</label>
                          <input type="text" class="form-control number" name="tarra_akhir" id="tarra_akhir" placeholder="Tarra akhir (kg)">
                        </div>
                        <div class="col-md-4">
                          <label for="no_replas">Netto Akhir</label>
                          <input type="text" class="form-control number" placeholder="Netto (kg)" name="qty_kirim_kg" id="qty_kirim_kg">
                        </div>
                      <?php } else { ?>
                        <div class="col-md-6">
                          <label for="no_replas">Bag</label>
                          <input type="text" class="form-control" placeholder="Bag" name="qty_kirim_bag" id="qty_kirim_bag">
                        </div>
                        <div class="col-md-6">
                          <label for="no_replas">Kg</label>
                          <input type="text" class="form-control number" placeholder="Kg" name="qty_kirim_kg" id="qty_kirim_kg">
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Toleransi Susut (kg)</label>
                    <input type="text" class="form-control" name="toleransi_susut" id="toleransi_susut" placeholder="Toleransi Susut">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Uang Sangu</label>
                    <input type="text" class="form-control number" name="uang_sangu" id="uang_sangu" placeholder="Uang Sangu">
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


    <div class="modal fade" id="input-pembayaran-bongkar-muat">
      <div class="modal-dialog modal-md">
        <form id="form_bongkar_muat" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Pembayaran Bongkar Muat</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="id" id="id">
                    <input type="hidden" class="form-control" name="id_project" id="id_project" placeholder="id_project" value="<?php echo $project->id_project; ?>">
                  </div>
                  <div class="form-group">
                    <label>Jenis</label>
                    <select class="form-control" style="width: 100%;" name="jenis" id="jenis">
                      <option value="1">Bongkar</option>
                      <option value="2">Muat</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Jumlah</label>
                    <input type="text" class="form-control number" id="jumlah" name="jumlah" placeholder="Input jumlah pembayaran">
                  </div>
                  <div class="form-group">
                    <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                    <div class="input-group date reservationdate3" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate3" data-toggle="datetimepicker" name="tanggal_pembayaran" id="tanggal_pembayaran" />
                      <div class="input-group-append" data-target=".reservationdate3" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer" style="justify-content: flex-start;">
              <button type="submit" class="btn btn-primary m-0">Save changes</button>
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

    <div class="modal fade" id="bayar-replas">
      <div class="modal-dialog modal-lg">
        <form id="form_bayar_replas" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pembayaran Replas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="id" id="id">
                    <input type="hidden" class="form-control" name="id_project" id="id_project" placeholder="id_project" value="<?php echo $project->id_project; ?>">

                    <div class="row">
                      <div class="col-md-4">
                        <div class="text-muted">
                          <p class="text-sm">No Replas
                            <b class="d-block" id="label-no-replas"></b>
                          </p>
                          <p class="text-sm">Vendor
                            <b class="d-block" id="label-vendor"></b>
                          </p>
                          <p class="text-sm">Supir
                            <b class="d-block" id="label-supir"></b>
                          </p>
                          <p class="text-sm">Truk
                            <b class="d-block" id="label-truk"></b>
                          </p>
                          <p class="text-sm">Jumlah angkut
                            <b class="d-block" id="label-jumlah-angkut"></b>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-muted">
                          <p class="text-sm">Toleransi Susut
                            <b class="d-block" id="label-toleransi-susut"></b>
                          </p>
                          <p class="text-sm">Susut
                            <b class="d-block" id="label-susut"></b>
                          </p>
                          <p class="text-sm">Total Claim Susut
                            <b class="d-block" id="label-total-claim"></b>
                          </p>

                          <p class="text-sm">Total Biaya Claim Susut
                            <b class="d-block" id="label-total-biaya-claim"></b>
                          </p>
                          <p class="text-sm">Uang Sangu
                            <b class="d-block" id="label-uang-sangu"></b>
                          </p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-muted">

                          <p class="text-sm">PPH
                            <b class="d-block" id="label-pph"></b>
                          </p>
                          <p class="text-sm">Biaya Admin
                            <b class="d-block" id="label-biaya-admin"></b>
                          </p>
                          <p class="text-sm">Grand Total Bayar
                            <b class="d-block" id="label-grand-total"></b>
                          </p>
                          <div class="form-group">
                            <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                            <div class="input-group date reservationdate" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate" data-toggle="datetimepicker" name="tanggal_pembayaran" id="tanggal_pembayaran" />
                              <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer" style="justify-content: flex-start;">
              <button type="submit" class="btn btn-primary m-0">Bayar Replas</button>
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
  function input_replas(id) {
    $('#form_replas')[0].reset();
    $("#supir").val(0).change();
    $('#tujuan').val(0).change();
    $('#truck').val(0).change();
    $("#input-replas").modal('show');
  }

  $('#form_replas').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_replas')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_replas/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_replas')[0].reset();
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

  $('#form_bongkar_muat').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_bongkar_muat')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_pembayaran_bongkar_muat/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_bongkar_muat')[0].reset();
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

  $('#form_bayar_replas').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_bayar_replas')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_pembayaran_replas/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_bayar_replas')[0].reset();
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

  function input_pembayaran_bongkar_muat() {
    $("#input-pembayaran-bongkar-muat").modal('show');
  }


  function edit_bongkar_muat(id) {
    $("#input-pembayaran-bongkar-muat").modal('show');
    $('.modal-title').html('Edit Pembayaran Bongkar Muat');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_pembayaran_bongkar_muat"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_replas')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="jenis"]').val(data[i].jenis).change();
          $('[name="jumlah"]').val($.number(data[i].jumlah_pembayaran).replace(/\,/g, '.'));
          $('[name="tanggal_pembayaran"]').val(data[i].tanggal_pembayaran);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function edit(id) {
    $("#input-replas").modal('show');
    $('.modal-title').html('Edit Replas');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_rekap"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_replas')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="no_replas"]').val(data[i].no_replas);
          $('[name="no_tiket"]').val(data[i].no_tiket);
          $('[name="tanggal_muat"]').val(data[i].tanggal_muat);
          $('[name="tanggal_bongkar"]').val(data[i].tanggal_bongkar);
          $('[name="supir"]').val(data[i].id_supir).change();
          $('[name="truck"]').val(data[i].id_truck).change();
          $('[name="tujuan"]').val(data[i].id_tujuan).change();
          $('[name="vendor_pajak"]').val(data[i].id_vendor_pajak).change();
          $('[name="bruto_awal"]').val($.number(data[i].bruto_awal).replace(/\,/g, '.'));
          $('[name="tarra_awal"]').val($.number(data[i].tarra_awal).replace(/\,/g, '.'));
          $('[name="bruto_akhir"]').val($.number(data[i].bruto_akhir).replace(/\,/g, '.'));
          $('[name="tarra_akhir"]').val($.number(data[i].tarra_akhir).replace(/\,/g, '.'));
          $('[name="qty_kirim_bag"]').val(data[i].qty_kirim_bag);
          $('[name="qty_kirim_kg"]').val($.number(data[i].qty_kirim_kg).replace(/\,/g, '.'));
          $('[name="timbang_kebun_bag"]').val(data[i].timbang_kebun_bag);
          $('[name="timbang_kebun_kg"]').val($.number(data[i].timbang_kebun_kg).replace(/\,/g, '.'));
          $('[name="toleransi_susut"]').val(data[i].toleransi_susut);
          $('[name="uang_sangu"]').val($.number(data[i].uang_sangu).replace(/\,/g, '.'));
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function bayar_replas(id) {
    $("#bayar-replas").modal('show');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/get_rekap",
      type: "POST",
      data: {
        'id': id
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_replas')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('#label-no-replas').html(data[i].no_replas);
          $('#label-vendor').html(data[i].vendor);
          $('#label-supir').html(data[i].nama_supir);
          $('#label-truk').html(data[i].nopol);
          $('#label-jumlah-angkut').html(data[i].qty_kirim_kg + ' Kg');
          $('#label-susut').html(data[i].m_susut + ' Kg');
          $('#label-toleransi-susut').html(data[i].toleransi_susut + ' Kg');
          $('#label-total-biaya-claim').html('Rp ' + $.number(data[i].total_claim).replace(/\,/g, '.'));
          $('#label-total-claim').html(data[i].c_claim + ' Kg');
          $('#label-pph').html(data[i].jenis_pajak + '/ Rp' + $.number(data[i].pph).replace(/\,/g, '.'));
          $('#label-biaya-admin').html('Rp ' + $.number(data[i].biaya_admin).replace(/\,/g, '.'));
          $('#label-grand-total').html('Rp ' + $.number(data[i].grand_total).replace(/\,/g, '.'));
          $('#label-uang-sangu').html('Rp ' + $.number(data[i].uang_sangu).replace(/\,/g, '.'));
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
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url() ?>rms/delete",
          type: "POST",
          data: {
            id: id,
            tbl: "tbl_rekap"
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
      }
    })
  }

  function delete_bongkar_muat(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url() ?>rms/delete",
          type: "POST",
          data: {
            id: id,
            tbl: "tbl_pembayaran_bongkar_muat"
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
      }
    })
  }
</script>