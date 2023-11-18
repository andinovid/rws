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
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Project</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_project()"><i class="fas fa-plus mr-1"></i> Input Project</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No Kontrak</th>
                    <th>No DO</th>
                    <th>Klien</th>
                    <th>Komoditas</th>
                    <th>Qty</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th style="width: 15%;"></th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $no = 0;
                  foreach ($project as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->no_kontrak; ?></td>
                      <td><?php echo $row->no_do; ?></td>
                      <td><?php echo $row->nama_perusahaan; ?></td>
                      <td><?php echo $row->komoditas; ?></td>
                      <td><?php echo number_format($row->qty, 0, "", "."); ?></td>
                      <td class="project_progress">
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $row->persentase_terkirim; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row->persentase_terkirim; ?>%">
                          </div>
                        </div>
                        <small>
                          <?php echo $row->persentase_terkirim; ?>% Complete
                        </small>
                      </td>
                      <td class="project-state">
                        <span class='badge <?php if ($row->status == '0') {
                                              echo "badge-secondary";
                                            } elseif ($row->status == '1') {
                                              echo "badge-warning";
                                            } elseif ($row->status == '2') {
                                              echo "badge-success";
                                            } ?>'><?php echo $row->nama_status; ?></span>
                      </td>
                      </td>
                      <td class="project-actions text-right">
                        <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>project/view/<?php echo $row->id_project; ?>" data-toggle="tooltip" data-placement="top" title="Detail Project">
                          <i class="fas fa-folder">
                          </i>
                        </a>
                        <!--a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="pilih_truck(<?php echo $row->id_project; ?>)" data-toggle="tooltip" data-placement="top" title="Pilih Truck">
                          <i class="fas fa-truck">
                          </i>
                        </a-->
                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_project; ?>)" data-toggle="tooltip" data-placement="top" title="Edit Project">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_project(<?php echo $row->id_project; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus Project">
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
                    <th>No Kontrak</th>
                    <th>No DO</th>
                    <th>Klien</th>
                    <th>Komoditas</th>
                    <th>Qty</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </tfoot>
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

    <div class="modal fade" id="input-project">
      <div class="modal-dialog modal-lg">
        <form id="form_project" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Project</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                    <label for="no_replas">Nomor Kontrak</label>
                    <input type="text" class="form-control" id="no_kontrak" name="no_kontrak" placeholder="Input nomor kontrak">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Nomor STO</label>
                    <input type="text" class="form-control" id="no_sto" name="no_sto" placeholder="Input nomor STO">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Nomor DO</label>
                    <input type="text" class="form-control" id="no_sto" name="no_do" placeholder="Input nomor DO">
                  </div>

                  <div class="form-group">
                    <label for="no_replas">Klien</label>
                    <select class="form-control select2" style="width: 100%;" name="klien" id="klien">
                      <option value="0">Pilih klien</option>
                      <?php foreach ($klien as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama_perusahaan; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal angkut</label>
                    <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal_angkut" id="tanggal_angkut" />
                      <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal selesai</label>
                    <div class="input-group date reservationdate reservationdate2" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate2" data-toggle="datetimepicker" name="tanggal_selesai" id="tanggal_selesai" />
                      <div class="input-group-append" data-target=".reservationdate2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Komoditas</label>
                    <select class="form-control select2" style="width: 100%;" name="komoditas" id="komoditas">
                      <option value="0">Pilih komoditas</option>
                      <?php foreach ($komoditas as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->komoditas; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2"></textarea>
                  </div>

                </div>
                <div class="col-md-6">
                  

                  <div class="form-group">
                    <label for="no_replas">Qty</label>
                    <input type="text" class="form-control number" placeholder="Quantity" name="qty" id="qty">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Harga unit</label>
                    <input type="text" class="form-control number" placeholder="Harga unit" name="harga_unit" id="harga_unit">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Toleransi susut</label>
                    <input type="text" class="form-control" placeholder="Toleransi susut" name="toleransi_susut" id="toleransi_susut">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Harga Claim Invoice</label>
                    <input type="text" class="form-control number" placeholder="Harga claim invoice" name="claim" id="claim">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Harga Claim Replas</label>
                    <input type="text" class="form-control number" placeholder="Harga claim replas" name="claim_replas" id="claim_replas">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Penagih</label>
                    <select class="form-control select2" style="width: 100%;" name="penagih" id="penagih">
                      <option value="0">Pilih penagih</option>
                      <?php foreach ($penagih as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">File SPK</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="file_spk" name="file_spk">
                      <label class="custom-file-label" for="file_spk" id="file_spk_label">Pilih file pdf/jpg</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">File DO</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="file_do" name="file_do">
                      <label class="custom-file-label" for="file_do" id="file_do_label">Pilih file pdf/jpg</label>
                    </div>
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
      </div>
    </div>






    <div class="modal fade" id="input-truck">
      <div class="modal-dialog modal-lg" style="min-width: 60%;">
        <form id="form_pilih_truck" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Truck</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id_project" id="id_project" />
              <div class="table-responsive" style="min-height:400px;">
                <table class="table" id="dynamic_field">
                  <thead class="thead-dark">
                    <tr>
                      <th style="width: 20%;">Nopol</th>
                      <th style="width: 20%;">Supir</th>
                      <th style="width: 20%;">Tujuan</th>
                      <th>Tanggal muat</th>
                      <th>Uang Sangu</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tr>
                    <td>
                      <select class="form-control select2" style="width: 100%;" name="truck[]" id="truck">
                        <option value="0">Pilih Truck</option>
                        <?php foreach ($truck as $row) : ?>
                          <option value="<?php echo $row->id; ?>"><?php echo $row->nopol; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td>
                      <select class="form-control select2" style="width: 100%;" name="supir[]" id="supir">
                        <option value="0">Pilih Supir</option>
                        <?php foreach ($supir as $row) : ?>
                          <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td>
                      <select class="form-control select2" style="width: 100%;" name="tujuan[]" id="tujuan">
                        <option value="0">Pilih Tujuan</option>
                        <?php foreach ($tujuan as $row) : ?>
                          <option value="<?php echo $row->id; ?>"><?php echo $row->kode_tujuan; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td>
                      <div class="form-group">
                        <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal_muat" id="tanggal_muat_1" />
                          <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <input type="text" name="uang_sangu[]" placeholder="Uang Sangu" class="form-control number" />
                    </td>
                    <td><button type="button" name="add" id="add" class="btn btn-success">+</button></td>
                  </tr>
                </table>
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
  $(document).ready(function() {
    var i = 1;

    $('#add').click(function() {
      setTimeout(function() {
        $('.select2').select2();
      }, 100);
      i++;
      $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><select class="form-control select2" style="width: 100%;" name="truck[]" id="truck' + i + '"><option value="0">Pilih Truck</option><?php foreach ($truck as $row) : ?><option value="<?php echo $row->id; ?>"><?php echo $row->nopol; ?></option><?php endforeach; ?></select></td><td><select class="form-control select2" style="width: 100%;" name="supir[]" id="supir' + i + '"><option value="0">Pilih Supir</option><?php foreach ($supir as $row) : ?><option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option><?php endforeach; ?></select></td><td><select class="form-control select2" style="width: 100%;" name="tujuan[]" id="tujuan' + i + '"><option value="0">Pilih Tujuan</option><?php foreach ($tujuan as $row) : ?><option value="<?php echo $row->id; ?>"><?php echo $row->nama_tujuan; ?></option><?php endforeach; ?></select></td><td><div class="form-group"><div class="input-group date reservationdate reservationdate' + i + '" data-target-input="nearest"><input type="text" class="form-control datetimepicker-input" data-target=".reservationdate' + i + '" data-toggle="datetimepicker" name="tanggal_muat[]" id="tanggal_muat_' + i + '" /><div class="input-group-append" data-target=".reservationdate' + i + '" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div></div></td><td><input type="text" name="uang_sangu[]" placeholder="Uang Sangu" class="form-control" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">x</button></td></tr>');
      $('.reservationdate' + i + '').datetimepicker({
        format: 'Y-M-DD'
      })
    });

    $(document).on('click', '.btn_remove', function() {
      var button_id = $(this).attr("id");
      $('#row' + button_id + '').remove();
    });

  });
  $(function() {
    bsCustomFileInput.init();
  });

  function input_project() {
    $('#form_project')[0].reset();
    $("#supir").val(0).change();
    $('#truck').val(0).change();
    $("#input-project").modal('show');
  }

  function pilih_truck(id) {
    $("#input-truck").modal('show');
    $("#id_project").val(id);
  }

  $('#form_project').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_project')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_project/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_project')[0].reset();
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

  $('#form_pilih_truck').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_pilih_truck')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_pilih_truck/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_pilih_truck')[0].reset();
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

  function edit(id) {
    $("#input-project").modal('show');
    $('.modal-title').html('Edit Project');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_project"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_project')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="no_kontrak"]').val(data[i].no_kontrak);
          $('[name="no_sto"]').val(data[i].no_sto);
          $('[name="no_do"]').val(data[i].no_do);
          $('[name="klien"]').val(data[i].id_klien).change();
          $('[name="tanggal_angkut"]').val(data[i].tanggal_angkut);
          $('[name="tanggal_selesai"]').val(data[i].tanggal_selesai);
          $('[name="komoditas"]').val(data[i].id_komoditas).change();
          $('[name="penagih"]').val(data[i].id_penagih).change();
          $('[name="qty"]').val(data[i].qty);
          $('[name="harga_unit"]').val(data[i].harga_unit);
          $('[name="toleransi_susut"]').val(data[i].toleransi_susut);
          $('[name="claim"]').val(data[i].claim);
          $('[name="claim_replas"]').val(data[i].claim_replas);
          $('[name="deskripsi"]').val(data[i].deskripsi);
          $('#file_spk_label').html(data[i].file_spk);
          $('#file_do_label').html(data[i].file_do);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_project(id) {
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
          url: "<?php echo base_url() ?>rms/delete_project",
          type: "POST",
          data: {
            id: id,
          },
          dataType: "JSON",
          success: function(data) {
            Swal.fire(
              'Berhasil!',
              'Data berhasil dihapus.',
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