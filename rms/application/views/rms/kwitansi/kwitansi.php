<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kwitansi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kwitansi</li>
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
              <h3 class="card-title">Data Kwitansi</h3>
              <div class="card-tools mr-1">
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No Kwitansi</th>
                    <th>Vendor</th>
                    <th>Jumlah Replas</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($kwitansi as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->no_kwitansi; ?></td>
                      <td><?php echo $row->vendor; ?></td>
                      <td><?php echo $row->total_replas; ?></td>
                      <td>Rp <?php echo number_format($row->grand_total, 0, "", "."); ?></td>

                      </td>
                      <td class="project-actions text-right">
                        <?php if ($row->status != "1") { ?>
                          <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="bayar_kwitansi(<?php echo $row->id_kwitansi; ?>)" data-toggle="tooltip" data-placement="top" title="Bayar Kwitansi">
                            <i class="fas fa-credit-card">
                            </i>
                          </a>
                        <?php } ?>
                        <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>rms/print_kwitansi/<?php echo $row->id_kwitansi; ?>" data-toggle="tooltip" data-placement="top" title="Cetak Kwitansi">
                          <i class="fas fa-print">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_kwitansi(<?php echo $row->id_kwitansi; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
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
                    <th>No DO</th>
                    <th>Vendor</th>
                    <th>Jumlah Replas</th>
                    <th>Total</th>
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
  </section>
</div>

<div class="modal fade" id="bayar-replas">
  <div class="modal-dialog modal-md">
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
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="tanggal_pembayaran">Nomor Kwitansi</label>
                      <input type="text" class="form-control" name="nomor_kwitansi" id="nomor_kwitansi" disabled>
                    </div>
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
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
  function bayar_kwitansi(id) {
    $("#bayar-replas").modal('show');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/get_kwitansi",
      type: "POST",
      data: {
        'id': id
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_bayar_replas')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('#nomor_kwitansi').val(data[i].no_kwitansi);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  $('#form_bayar_replas').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_bayar_replas')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_pembayaran_kwitansi/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_bayar_replas')[0].reset();
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

  function delete_kwitansi(id) {
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
          url: "<?php echo base_url() ?>rms/delete_kwitansi",
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