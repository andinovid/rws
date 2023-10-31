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
            <li class="breadcrumb-item active">Project</li>
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
                  <h3 class="text-primary" style="margin-bottom: 18px;"><i class="fas fa-building"></i> <?php echo $project->nama_perusahaan; ?></h3>
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
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="text-muted">
                        <p class="text-sm">Tanggal Selesai
                          <b class="d-block"><?php echo shortdate_indo($project->tanggal_selesai); ?></b>
                        </p>
                        <p class="text-sm">Total Susut
                          <b class="d-block"><?php echo number_format($project->total_susut, 0, "", "."); ?> kg</b>
                        </p>
                        <p class="text-sm">Total Uang Sangu
                          <b class="d-block">Rp <?php echo number_format($project->total_uang_sangu, 0, "", "."); ?></b>
                        </p>
                        <p class="text-sm">Biaya Claim
                          <b class="d-block">Rp <?php echo number_format($project->harga_claim_satuan, 0, "", "."); ?></b>
                        </p>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="text-muted">
                        <p class="text-sm">Total Claim
                          <b class="d-block"><?php echo number_format($project->total_claim, 0, "", "."); ?> Kg</b>
                        </p>
                        <p class="text-sm">Total Biaya Claim
                          <b class="d-block">Rp <?php echo number_format($project->total_biaya_claim, 0, "", "."); ?></b>
                        </p>
                        <p class="text-sm">Total Pengeluaran
                          <b class="d-block">Rp <?php echo number_format($project->total_pengeluaran, 0, "", "."); ?></b>
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
                      <span class="info-box-number">Rp <?php echo number_format($project->total_nilai, 0, "", "."); ?></span>
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
                      <span class="info-box-number">Terkirim <?php echo number_format($project->total_terkirim, 0, "", "."); ?> kg dari <?php echo number_format($project->qty, 0, "", "."); ?> kg</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: <?php echo $project->persentase_terkirim; ?>%"></div>
                      </div>
                      <span class="progress-description">
                        <?php echo $project->persentase_terkirim; ?>% Terkirim | Sisa kirim <?php echo number_format($project->sisa_kirim, 0, "", "."); ?> Kg
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
                  <a href="<?php echo base_url(); ?>assets/rms/documents/spk/<?php echo $project->file_spk; ?>" class="link-black text-sm mr-3"><i class="fas fa-file mr-1"></i> File SPK</a>
                  <a href="<?php echo base_url(); ?>assets/rms/documents/do/<?php echo $project->file_do; ?>" class="link-black text-sm mr-3"><i class="fas fa-file mr-1"></i> File DO</a>
                  <a href="#" class="text-sm btn btn-danger btn-sm text-sm mr-1"><i class="fas fa-print mr-1"></i> Cetak Invoice</a>
                  <a href="#" class="text-sm btn btn-success btn-sm text-sm"><i class="fas fa-print mr-1"></i> Cetak Kwitansi</a>
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
                    <th colspan="2" class="text-center align-middle">Qty Awal</th>
                    <th colspan="2" class="text-center align-middle">Qty Akhir</th>
                    <th colspan="2" class="text-center align-middle">Susut</th>
                    <th rowspan="2" class="text-center align-middle">Action</th>
                  </tr>
                  <tr>
                    <th class="text-center align-middle">Bag</th>
                    <th class="text-center align-middle">Kg</th>
                    <th class="text-center align-middle">Bag</th>
                    <th class="text-center align-middle">Kg</th>
                    <th class="text-center align-middle">M</th>
                    <th class="text-center align-middle">C</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 0;
                  $no++;
                  foreach ($rekap as $row) : ?>
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
                      <td><?php echo $row->nama_tujuan; ?></td>
                      <td><?php echo number_format($row->timbang_kebun_bag, 0, "", "."); ?></td>
                      <td><?php echo number_format($row->timbang_kebun_kg, 0, "", "."); ?> Kg</td>
                      <td><?php echo number_format($row->qty_kirim_bag, 0, "", "."); ?></td>
                      <td><?php echo number_format($row->qty_kirim_kg, 0, "", "."); ?> Kg</td>
                      <td><?php echo number_format($row->m_susut, 0, "", "."); ?> Kg</td>
                      <td><?php echo number_format($row->c_claim, 0, "", "."); ?> Kg</td>

                      <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_rekap; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
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
                </tbody>
              </table>
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
                  <div class="form-group">
                    <label for="no_replas">Tanggal Muat</label>
                    <div class="input-group date reservationdate1" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal_muat" id="tanggal_muat" />
                      <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal Bongkar</label>
                    <div class="input-group date reservationdate2" data-target-input="nearest">
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
                    <label for="no_replas">Qty Kirim</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Bag" name="qty_kirim_bag" id="qty_kirim_bag">
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Kg" name="qty_kirim_kg" id="qty_kirim_kg">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Timbang Kebun</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="timbang_kebun_bag" id="timbang_kebun_bag" placeholder="Bag">
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="timbang_kebun_kg" id="timbang_kebun_kg" placeholder="Kg">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Uang Sangu</label>
                    <input type="text" class="form-control" name="uang_sangu" id="uang_sangu" placeholder="Uang Sangu">
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
          $('[name="tanggal"]').val(data[i].tanggal_muat);
          $('[name="tanggal"]').val(data[i].tanggal_bongkar);
          $('[name="supir"]').val(data[i].id_supir).change();
          $('[name="truck"]').val(data[i].id_truck).change();
          $('[name="tujuan"]').val(data[i].id_tujuan).change();
          $('[name="qty_kirim_bag"]').val(data[i].qty_kirim_bag);
          $('[name="qty_kirim_kg"]').val(data[i].qty_kirim_kg);
          $('[name="timbang_kebun_bag"]').val(data[i].timbang_kebun_bag);
          $('[name="timbang_kebun_kg"]').val(data[i].timbang_kebun_kg);
          $('[name="uang_sangu"]').val(data[i].uang_sangu);
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
</script>