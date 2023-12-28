<div class="content-wrapper">
  <div class="content-header">

  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">

            <!-- /.card-header -->
            <div class="card-body">
              <div class="text-center mb-5">
                <img src="<?php echo base_url(); ?>assets/rms/dist/img/dashboard2.png" width="100">
                <h1 style="font-weight: 600;"><?php echo number_format($truck->oddo_terakhir, 0, "", "."); ?> KM</h1>
                <a href="#" onclick="update_oddo()" class="btn btn-primary mt-3">Update Oddo</a>
              </div>

              <table class="table data-table">
                <thead>
                  <tr>
                    <th>Nopol</th>
                    <th>Supir</th>
                    <th>Oddo</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  foreach ($oddo as $row) :
                  ?>
                    <tr>
                      <td><?php echo $row->nopol; ?></td>
                      <td><?php echo $row->nama_supir; ?></td>
                      <td><?php echo $row->oddo; ?></td>
                      <td><?php echo shortdate_indo($row->tanggal); ?></td>
                      <td><?php echo $row->keterangan; ?></td>

                      <td class="project-actions text-right">

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
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="update-oddo">
      <div class="modal-dialog modal-lg">
        <form id="form_oddo" class="form-horizontal" method="post" enctype="multipart/form-data">
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
                <input type="hidden" class="form-control" name="id_truck" id="id_truck" value="<?php echo $truck->id_truck; ?>" placeholder="id_truck">
                <input type="hidden" class="form-control" name="id_supir" id="id_supir" value="<?php echo $truck->id_supir; ?>" placeholder="id_supir">
                <label for="nopol">Oddo Terbaru</label>
                <input type="text" class="form-control" id="oddo" name="oddo" placeholder="Input oddo terbaru saat ini">
              </div>
              <div class="form-group">
                <label for="no_replas">Foto Oddometer</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="foto_oddo" name="foto_oddo">
                  <label class="custom-file-label" for="foto_oddo" id="foto_oddo_label">Pilih file pdf/jpg</label>
                </div>
              </div>
              <div class="form-group">
                <label for="kategori">Keterangan</label>
                <textarea class="form-control" rows="3" name="keterangan" id="keterangan"></textarea>
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


  $(function() {
    bsCustomFileInput.init();
  });


  function update_oddo() {
    $('#form_oddo')[0].reset();
    $("#update-oddo").modal('show');
  }

  function pilih_truck(id) {
    $("#input-truck").modal('show');
    $("#id_project").val(id);
  }

  $('#form_oddo').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_oddo')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_oddo/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_oddo')[0].reset();
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
    $("#update-oddo").modal('show');
    $('.modal-title').html('Edit oddo');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_update_oddo"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_oddo')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="id_truck"]').val(data[i].id_truck);
          $('[name="id_supir"]').val(data[i].id_supir);
          $('[name="oddo"]').val(data[i].oddo);
          $('#foto_oddo_label').html(data[i].foto);
          $('[name="keterangan"]').val(data[i].keterangan);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_data(id) {
    Swal.fire({
      title: 'Hapus data?',
      text: "Data yang telah dihapus tidak dapat dikembalikan.",
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
          tbl: 'tbl_update_oddo',
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
    })
  }
</script>