<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Truk <?php echo $truck->nopol; ?></h1>
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
                  <span class="info-box-icon <?php if($truck->persentase_penggunaan_oli_mesin > '90'){echo 'bg-danger';}elseif($truck->persentase_penggunaan_oli_mesin > '80' AND $truck->persentase_penggunaan_oli_mesin < '90'){echo 'bg-warning';}else{echo 'bg-success';} ?>"><img src="<?php echo base_url(); ?>assets/rms/dist/img/engine-oil.png" width="40" /> </span>
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
                  <span class="info-box-icon <?php if($truck->persentase_penggunaan_oli_gardan > '90'){echo 'bg-danger';}elseif($truck->persentase_penggunaan_oli_gardan > '80' AND $truck->persentase_penggunaan_oli_gardan < '90'){echo 'bg-warning';}else{echo 'bg-success';} ?>"><img src="<?php echo base_url(); ?>assets/rms/dist/img/engine-oil.png" width="40" /> </span>
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
                  <span class="info-box-icon <?php if($truck->persentase_penggunaan_oli_transmisi > '90'){echo 'bg-danger';}elseif($truck->persentase_penggunaan_oli_transmisi > '80' AND $truck->persentase_penggunaan_oli_transmisi < '90'){echo 'bg-warning';}else{echo 'bg-success';} ?>"><img src="<?php echo base_url(); ?>assets/rms/dist/img/engine-oil.png" width="40" /> </span>
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
              <div class="col-md-4">
                <div class="info-box mb-3 <?php if ($truck->sisa_hari_pajak_tahunan > 0 AND $truck->sisa_hari_pajak_tahunan < '30') { echo 'bg-danger'; }elseif ($truck->sisa_hari_pajak_tahunan >= '30' AND $truck->sisa_hari_pajak_tahunan < '60') { echo 'bg-warning'; }else{echo 'bg-success';} ?>">
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
              <div class="col-md-4">
                <div class="info-box mb-3 <?php if ($truck->sisa_hari_pajak_5_tahunan > 0 AND $truck->sisa_hari_pajak_5_tahunan < '30') { echo 'bg-danger'; }elseif ($truck->sisa_hari_pajak_5_tahunan >= '30' AND $truck->sisa_hari_pajak_5_tahunan < '60') { echo 'bg-warning'; }else{echo 'bg-success';} ?>">
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
              <div class="col-md-4">
                <div class="info-box mb-3 <?php if ($truck->sisa_hari_kir > 0 AND $truck->sisa_hari_kir < '7') { echo 'bg-danger'; }elseif ($truck->sisa_hari_kir >= '7' AND $truck->sisa_hari_kir < '30') { echo 'bg-warning'; }else{echo 'bg-success';} ?>">
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
                        <th class="align-middle">Status</th>
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
                          <td>
                            <?php if ($row->status == '0') { ?>
                              <span class="badge badge-warning">Sedang Mengirim</span>
                            <?php } else { ?>
                              <span class="badge badge-secondary">Selesai</span>
                            <?php } ?>
                          </td>
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
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-striped table-valign-middle data-table-default">
                      <thead>
                        <tr>
                          <th class="align-middle">Tanggal Muat</th>
                          <th class="align-middle">Tanggal Bongkar</th>
                          <th class="align-middle">Jenis Perbaikan</th>
                          <th class="align-middle">Supir</th>
                          <th class="align-middle">Harga</th>
                          <th class="align-middle">status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($perbaikan as $row) : ?>
                          <tr>
                            <td><?php if ($row->tanggal_perbaikan) {
                                  echo shortdate_indo($row->tanggal_perbaikan);
                                } ?></td>
                            <td><?php echo $row->nama_supir; ?></td>
                            <td><?php echo $row->harga; ?></td>
                            <td>
                              <?php if ($row->status == '0') { ?>
                                <span class="badge badge-secondary"><?php echo $row->nama_status; ?></span>
                              <?php } elseif ($row->status == '1') { ?>
                                <span class="badge badge-warning"><?php echo $row->nama_status; ?></span>
                              <?php } elseif ($row->status == '2') { ?>
                                <span class="badge badge-success"><?php echo $row->nama_status; ?></span>
                              <?php } ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
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
  $(function() {
    $('#supir').change(function() {
      $('#nama_supir').val($(this).find('option:selected').text());
    });
  });

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
</script>