<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Supir</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">supir</li>
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
              <h3 class="card-title">Data supir</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_supir()"><i class="fas fa-plus mr-1"></i> Input supir</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Supir RWS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Supir Vendor</a>
                </li>
              </ul>
              <div class="tab-content pt-3" id="custom-content-above-tabContent">
                <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                  <table class="table table-bordered table-striped data-table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>No KTP</th>
                        <th>No SIM</th>
                        <th>Kategori</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 0;
                      foreach ($supir_rws as $row) :
                        $no++;
                      ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $row->nama; ?></td>
                          <td><?php echo $row->no_wa; ?></td>
                          <td><?php echo $row->no_ktp; ?></td>
                          <td><?php echo $row->no_sim; ?></td>
                          <td><span class="badge <?php if ($row->kategori == '1') { ?>bg-success <?php } else { ?> bg-warning <?php } ?>"><?php if ($row->kategori == '1') { ?>Supir RWS <?php } else { ?> Supir Vendor <?php } ?></span></td>


                          <td class="project-actions text-right">
                            <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>supir/view/<?php echo $row->id; ?>" data-toggle="tooltip" data-placement="top" title="Detail supir">
                              <i class="fas fa-folder">
                              </i>
                            </a>
                            <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Edit supir">
                              <i class="fas fa-pencil-alt">
                              </i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_truck(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus supir">
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
                        <th>Telepon</th>
                        <th>No KTP</th>
                        <th>No SIM</th>
                        <th>Kategori</th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="tab-pane fade show" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                  <table class="table table-bordered table-striped data-table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>No KTP</th>
                        <th>No SIM</th>
                        <th>Kategori</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 0;
                      foreach ($supir_vendor as $row) :
                        $no++;
                      ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $row->nama; ?></td>
                          <td><?php echo $row->no_wa; ?></td>
                          <td><?php echo $row->no_ktp; ?></td>
                          <td><?php echo $row->no_sim; ?></td>
                          <td><span class="badge <?php if ($row->kategori == '1') { ?>bg-success <?php } else { ?> bg-warning <?php } ?>"><?php if ($row->kategori == '1') { ?>Supir RWS <?php } else { ?> Supir Vendor <?php } ?></span></td>


                          <td class="project-actions text-right">
                            <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>supir/view/<?php echo $row->id; ?>" data-toggle="tooltip" data-placement="top" title="Detail supir">
                              <i class="fas fa-folder">
                              </i>
                            </a>
                            <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Edit supir">
                              <i class="fas fa-pencil-alt">
                              </i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_truck(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus supir">
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
                        <th>Telepon</th>
                        <th>No KTP</th>
                        <th>No SIM</th>
                        <th>Kategori</th>
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

    <div class="modal fade" id="input-supir">
      <div class="modal-dialog modal-lg">
        <form id="form_supir" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input supir</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                    <label for="nopol">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Input nama supir">
                  </div>
                  <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="colorselector" class="form-control" name="kategori">
                      <option value="1">Supir Kantor</option>
                      <option value="2">Supir Vendor</option>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label for="no_wa">No Telepon</label>
                    <input type="text" class="form-control" id="no_wa" onkeyup="validate(this.id);" name="no_wa" placeholder="Input nomor telepon">
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="form-group">
                    <label for="no_ktp">KTP</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="form-control" id="no_ktp" name="no_ktp" placeholder="Input nomor KTP">
                      </div>
                      <div class="col-md-6">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="file_ktp" name="file_ktp">
                          <label class="custom-file-label" for="file_ktp" id="file_ktp_label">Pilih file pdf/jpg</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_sim">SIM</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="form-control" id="no_sim" name="no_sim" placeholder="Input nomor SIM">
                      </div>
                      <div class="col-md-6">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="file_sim" name="file_sim">
                          <label class="custom-file-label" for="file_sim" id="file_sim_label">Pilih file pdf/jpg</label>
                        </div>
                      </div>
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
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>







  </section>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
  function input_supir() {
    $('#form_supir')[0].reset();
    $("#input-supir").modal('show');
  }
  $(function() {
    bsCustomFileInput.init();
  });

  $('#form_supir').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_supir')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_supir/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_supir')[0].reset();
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
    $("#input-supir").modal('show');
    $('.modal-title').html('Edit supir');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_supir"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_supir')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {


          $('[name="nama"]').val(data[i].nama);
          $('[name="no_wa"]').val(data[i].no_wa);
          $('[name="kategori"]').val(data[i].kategori).change();
          $('[name="no_ktp"]').val(data[i].no_ktp);
          $('[name="no_sim"]').val(data[i].no_sim);
          $('#file_ktp_label').html(data[i].file_ktp);
          $('#file_sim_label').html(data[i].file_sim);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_truck(id) {
    Swal.fire({
      title: 'Hapus data?',
      text: "Data yang telah dihapus tidak dapat dikembalikan.",
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
            tbl: 'tbl_supir',
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