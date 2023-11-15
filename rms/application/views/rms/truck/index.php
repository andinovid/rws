<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Truk</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">truk</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Truk</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_truk()"><i class="fas fa-plus mr-1"></i> Input Truk</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Truk RWS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Truk Vendor</a>
                </li>
              </ul>
              <div class="tab-content pt-3" id="custom-content-above-tabContent">
                <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                  <table class="table table-bordered table-striped data-table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nopol</th>
                        <th>Jenis Truk</th>
                        <th>Oddo saat ini</th>
                        <th>Oli Mesin</th>
                        <th>Oli Gardan</th>
                        <th>Oli Transmisi</th>
                        <th>Pajak Tahunan</th>
                        <th>Pajak 5 Tahunan</th>
                        <th>KIR</th>
                        <th>Supir</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 0;
                      foreach ($truck_rws as $row) :
                        $no++;
                      ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $row->nopol; ?></td>
                          <td><?php echo $row->jenis_truck; ?></td>
                          <td><img src="<?php echo base_url(); ?>assets/rms/dist/img/dashboard2.png" width="25" class="mr-2" style="margin-top: -3px;"><?php echo number_format($row->oddo_terakhir, 0, "", "."); ?> KM</td>
                          <td class="project_progress">
                            <div class="progress progress-sm">
                              <div class="progress-bar <?php if ($row->persentase_penggunaan_oli_mesin > '90') {
                                                          echo 'bg-danger';
                                                        } elseif ($row->persentase_penggunaan_oli_mesin > '80' and $row->persentase_penggunaan_oli_mesin < '90') {
                                                          echo 'bg-warning';
                                                        } else {
                                                          echo 'bg-green';
                                                        } ?>" role="progressbar" aria-valuenow="<?php echo $row->persentase_penggunaan_oli_mesin; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row->persentase_penggunaan_oli_mesin; ?>%">
                              </div>
                            </div>
                            <small>
                              <?php echo $row->persentase_penggunaan_oli_mesin; ?>% - Kurang <?php echo number_format($row->kurang_oli_mesin, 0, "", "."); ?> KM
                            </small>
                          </td>
                          <td class="project_progress">
                            <div class="progress progress-sm">
                              <div class="progress-bar <?php if ($row->persentase_penggunaan_oli_gardan > '90') {
                                                          echo 'bg-danger';
                                                        } elseif ($row->persentase_penggunaan_oli_gardan > '80' and $row->persentase_penggunaan_oli_gardan < '90') {
                                                          echo 'bg-warning';
                                                        } else {
                                                          echo 'bg-green';
                                                        } ?>" role="progressbar" aria-valuenow="<?php echo $row->persentase_penggunaan_oli_gardan; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row->persentase_penggunaan_oli_gardan; ?>%">
                              </div>
                            </div>
                            <small>
                              <?php echo $row->persentase_penggunaan_oli_gardan; ?>% - Kurang <?php echo number_format($row->kurang_oli_gardan, 0, "", "."); ?> KM
                            </small>
                          </td>
                          <td class="project_progress">
                            <div class="progress progress-sm">
                              <div class="progress-bar <?php if ($row->persentase_penggunaan_oli_transmisi > '90') {
                                                          echo 'bg-danger';
                                                        } elseif ($row->persentase_penggunaan_oli_transmisi > '80' and $row->persentase_penggunaan_oli_transmisi < '90') {
                                                          echo 'bg-warning';
                                                        } else {
                                                          echo 'bg-green';
                                                        } ?>" role="progressbar" aria-valuenow="<?php echo $row->persentase_penggunaan_oli_transmisi; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row->persentase_penggunaan_oli_transmisi; ?>%">
                              </div>
                            </div>
                            <small>
                              <?php echo $row->persentase_penggunaan_oli_transmisi; ?>% - Kurang <?php echo number_format($row->kurang_oli_transmisi, 0, "", "."); ?> KM
                            </small>
                          </td>


                          <td>
                            <?php if ($row->sisa_hari_pajak_tahunan > 0) { ?>
                              <?php echo shortdate_indo($row->pajak_tahunan); ?><br>
                              <small class="badge <?php if ($row->sisa_hari_pajak_tahunan > 0 and $row->sisa_hari_pajak_tahunan < '30') {
                                                    echo 'badge-danger';
                                                  } elseif ($row->sisa_hari_pajak_tahunan >= '30' and $row->sisa_hari_pajak_tahunan < '60') {
                                                    echo 'badge-warning';
                                                  } else {
                                                    echo 'badge-success';
                                                  } ?>"> Sisa
                                <?php
                                $days = $row->sisa_hari_pajak_tahunan;
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
                          </td>

                          <td>
                            <?php if ($row->sisa_hari_pajak_5_tahunan > 0) { ?>
                              <?php echo shortdate_indo($row->pajak_5_tahunan); ?><br>
                              <small class="badge <?php if ($row->sisa_hari_pajak_5_tahunan > 0 and $row->sisa_hari_pajak_5_tahunan < '30') {
                                                    echo 'badge-danger';
                                                  } elseif ($row->sisa_hari_pajak_5_tahunan >= '30' and $row->sisa_hari_pajak_5_tahunan < '60') {
                                                    echo 'badge-warning';
                                                  } else {
                                                    echo 'badge-success';
                                                  } ?>">Sisa
                                <?php
                                $days = $row->sisa_hari_pajak_5_tahunan;
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
                          </td>

                          <td>
                            <?php if ($row->sisa_hari_kir > 0) { ?>
                              <?php echo shortdate_indo($row->kir_selanjutnya); ?><br>
                              <small class="badge <?php if ($row->sisa_hari_kir > 0 and $row->sisa_hari_kir < '7') {
                                                    echo 'badge-danger';
                                                  } elseif ($row->sisa_hari_kir >= '7' and $row->sisa_hari_kir < '30') {
                                                    echo 'badge-warning';
                                                  } else {
                                                    echo 'badge-success';
                                                  } ?>">Sisa
                                <?php
                                $days = $row->sisa_hari_kir;
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
                          </td>
                          <td><?php echo $row->nama_supir; ?></td>

                          <td class="project-actions text-right">
                            <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>truck/view/<?php echo $row->id_truck; ?>" data-toggle="tooltip" data-placement="top" title="Detail Truk">
                              <i class="fas fa-folder">
                              </i>
                            </a>
                            <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_truck; ?>)" data-toggle="tooltip" data-placement="top" title="Edit Truk">
                              <i class="fas fa-pencil-alt">
                              </i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_truck(<?php echo $row->id_truck; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus Truk">
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
                        <th>Nopol</th>
                        <th>Jenis Truk</th>
                        <th>Oddo saat ini</th>
                        <th>Oli Mesin</th>
                        <th>Oli Gardan</th>
                        <th>Oli Transmisi</th>
                        <th>Pajak Tahunan</th>
                        <th>Pajak 5 Tahunan</th>
                        <th>KIR</th>
                        <th>Supir</th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                  <table class="table table-bordered table-striped data-table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nopol</th>
                        <th>Vendor</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 0;
                      foreach ($truck_vendor as $row) :
                        $no++;
                      ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $row->nopol; ?></td>
                          <td><?php echo $row->nama_vendor; ?></td>
                          <td class="project-actions text-right">
                            <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>truck/view/<?php echo $row->id_truck; ?>" data-toggle="tooltip" data-placement="top" title="Detail Truk">
                              <i class="fas fa-folder">
                              </i>
                            </a>
                            <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_truck; ?>)" data-toggle="tooltip" data-placement="top" title="Edit Truk">
                              <i class="fas fa-pencil-alt">
                              </i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_truck(<?php echo $row->id_truck; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus Truk">
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
                        <th>Nopol</th>
                        <th>Vendor</th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="input-truk">
      <div class="modal-dialog modal-lg">
        <form id="form_truk" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Truk</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                <label for="nopol">Nopol</label>
                <input type="text" class="form-control" id="nopol" name="nopol" placeholder="Input nomor polisi">
              </div>
              <div class="form-group">
                <label for="kategori">Kategori</label>
                <select id="colorselector" class="form-control" name="kategori">
                  <option value="0">Pilih Kategori</option>
                  <option value="1">Truk Kantor</option>
                  <option value="2">Truk Vendor</option>
                </select>
              </div>
              <div id="kategori-1" class="kategori">

                <div class="row">
                  <div class="col-md-6">
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
                      <label for="kategori">Jenis Truk</label>
                      <select id="jenis_truck" class="form-control" name="jenis_truck">
                        <option value="">Pilih Jenis Truk</option>
                        <option value="1">Euro 2</option>
                        <option value="2">Euro 4</option>
                        <option value="3">Isuzu Diesel</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="no_replas">Nomor Rangka</label>
                      <input type="text" class="form-control" id="nomor_rangka" name="nomor_rangka" placeholder="Input nomor rangka">
                    </div>
                    <div class="form-group">
                      <label for="no_replas">Nomor Mesin</label>
                      <input type="text" class="form-control" id="nomor_mesin" name="nomor_mesin" placeholder="Input nomor mesin">
                    </div>

                    <div class="form-group">
                      <label for="no_replas">Update KIR terakhir</label>
                      <div class="input-group date reservationdate reservationdate3" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate3" data-toggle="datetimepicker" name="kir_terakhir" id="kir_terakhir" />
                        <div class="input-group-append" data-target=".reservationdate3" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="no_replas">Masa berlaku pajak tahunan</label>
                      <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="pajak_tahunan" id="pajak_tahunan" />
                        <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="no_replas">Masa berlaku pajak 5 tahunan</label>
                      <div class="input-group date reservationdate reservationdate2" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate2" data-toggle="datetimepicker" name="pajak_5_tahunan" id="pajak_5_tahunan" />
                        <div class="input-group-append" data-target=".reservationdate2" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cicilan">Cicilan</label>
                      <input type="text" class="form-control number" id="cicilan" name="cicilan" placeholder="Input cicilan truk">
                    </div>
                    <div class="form-group">
                      <label for="oddo_terakhir">Oddo saat ini</label>
                      <input type="text" class="form-control number" id="no_sto" name="oddo_terakhir" placeholder="Input oddo saat ini">
                    </div>
                    <div class="form-group">
                      <label for="oddo_terakhir_oli_mesin">Oddo terakhir pergantian oli mesin </label>
                      <input type="text" class="form-control number" id="oddo_terakhir_oli_mesin" name="oddo_terakhir_oli_mesin" placeholder="Input oddo terakhir pergantian oli mesin">
                    </div>
                    <div class="form-group">
                      <label for="oddo_terakhir_oli_gardan">Oddo terakhir pergantian oli gardan </label>
                      <input type="text" class="form-control number" id="oddo_terakhir_oli_gardan" name="oddo_terakhir_oli_gardan" placeholder="Input oddo terakhir pergantian oli gardan">
                    </div>
                    <div class="form-group">
                      <label for="oddo_terakhir_oli_transmisi">Oddo terakhir pergantian oli transmisi </label>
                      <input type="text" class="form-control number" id="oddo_terakhir_oli_transmisi" name="oddo_terakhir_oli_transmisi" placeholder="Input oddo terakhir pergantian oli transmisi">
                    </div>
                    <div class="form-group">
                      <label for="no_replas">Tanggal terakhir ganti air radiator</label>
                      <div class="input-group date reservationdate reservationdate4" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate4" data-toggle="datetimepicker" name="air_raidator" id="air_raidator" />
                        <div class="input-group-append" data-target=".reservationdate4" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div id="kategori-2" class="kategori">
                <select class="form-control select2" style="width: 100%;" name="vendor" id="vendor">
                  <option value="1">Pilih vendor</option>
                  <?php foreach ($vendor as $row) : ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                  <?php endforeach; ?>
                </select>
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
  $(function() {
    $('.kategori').hide();
    $('#colorselector').change(function() {
      $('.kategori').hide();
      $('#kategori-' + $(this).val()).show();
    });
  });

  function input_truk() {
    $('#form_truk')[0].reset();
    $("#colorselector").val(0).change();
    $('.kategori').hide();
    $("#input-truk").modal('show');
  }

  function pilih_truck(id) {
    $("#input-truck").modal('show');
    $("#id_project").val(id);
  }

  $('#form_truk').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_truk')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_truk/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_truk')[0].reset();
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
    $("#input-truk").modal('show');
    $('.modal-title').html('Edit truk');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_truck"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_truk')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {


          $('[name="nopol"]').val(data[i].nopol);
          $('[name="kategori"]').val(data[i].kategori).change();

          if (data[i].kategori == '1') {
            $('#kategori-1').show();
            $('#kategori-2').hide();
            $('[name="cicilan"]').val($.number(data[i].cicilan).replace(/\,/g, '.'));
            $('[name="jenis_truck"]').val(data[i].jenis_truck).change();
            $('[name="supir"]').val(data[i].id_supir).change();
            $('[name="nomor_rangka"]').val(data[i].nomor_rangka);
            $('[name="nomor_mesin"]').val(data[i].nomor_mesin);
            $('[name="pajak_tahunan"]').val(data[i].pajak_tahunan);
            $('[name="pajak_5_tahunan"]').val(data[i].pajak_5_tahunan);
            $('[name="kir_terakhir"]').val(data[i].kir_terakhir);
            $('[name="oddo_terakhir"]').val($.number(data[i].oddo_terakhir).replace(/\,/g, '.'));
            $('[name="oddo_terakhir_oli_mesin"]').val($.number(data[i].oddo_terakhir_oli_mesin).replace(/\,/g, '.'));
            $('[name="oddo_terakhir_oli_gardan"]').val($.number(data[i].oddo_terakhir_oli_gardan).replace(/\,/g, '.'));
            $('[name="oddo_terakhir_oli_transmisi"]').val($.number(data[i].oddo_terakhir_oli_transmisi).replace(/\,/g, '.'));
          } else {
            $('#kategori-2').show();
            $('#kategori-1').hide();
            $('[name="vendor"]').val(data[i].id_vendor).change();
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_truck(id) {
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
        url: "<?php echo base_url() ?>rms/delete_truck",
        type: "POST",
        data: {
          id: id,
        },
        dataType: "JSON",
        success: function(data) {
          Swal.fire(
            'Deleted!',
            'Truck has been deleted.',
            'success'
          ).then((result) => {
            location.reload();
          });
        }
      });
    })
  }
</script>