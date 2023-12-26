<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Tujuan Antar</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">data tujuan antar</li>
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
              <h3 class="card-title">Data Tujuan Antar</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_tujuan()"><i class="fas fa-plus mr-1"></i> Input tujuan</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table data-table">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama Perusahaan</th>
                    <th>Harga</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($tujuan as $row) :
                  ?>
                    <tr>
                      <td><?php echo $row->kode_tujuan; ?></td>
                      <td><?php echo $row->nama_tujuan; ?></td>
                      <td>Rp <?php echo number_format($row->harga, 0, "", "."); ?></td>
                      <td class="project-actions text-right">

                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_tujuan(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
                          <i class="fas fa-trash">
                          </i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Kode</th>
                    <th>Nama Perusahaan</th>
                    <th>Harga</th>
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

    <div class="modal fade" id="input-tujuan">
      <div class="modal-dialog modal-lg">
        <form id="form_tujuan" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input tujuan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama">Kode Tujuan</label>

                    <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                    <input type="text" class="form-control" id="kode_tujuan" name="kode_tujuan" placeholder="Input kode tujuan">
                  </div>
                  <div class="form-group">
                    <label for="nomor_rekening">Nama Tujuan</label>
                    <input type="text" class="form-control" id="nama_tujuan" name="nama_tujuan" placeholder="Input nama tujuan">
                  </div>
                  <div class="form-group">
                    <label for="nama_rekening">Harga</label>
                    <input type="text" class="form-control number" id="harga" name="harga" placeholder="Input harga tujuan">
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
  function input_tujuan() {
    $('#form_tujuan')[0].reset();
    $("#input-tujuan").modal('show');
  }

  $('#form_tujuan').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_tujuan')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_tujuan/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_tujuan')[0].reset();
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
    $("#input-tujuan").modal('show');
    $('.modal-title').html('Edit tujuan');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_tujuan"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_tujuan')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="kode_tujuan"]').val(data[i].kode_tujuan);
          $('[name="nama_tujuan"]').val(data[i].nama_tujuan);
          $('[name="harga"]').val($.number(data[i].harga).replace(/\,/g, '.'));
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_tujuan(id) {
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
            tbl: "tbl_tujuan",
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