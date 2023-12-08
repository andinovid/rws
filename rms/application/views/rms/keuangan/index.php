<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Keuangan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">data keuangan</li>
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
              <h3 class="card-title">Data Keuangan</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_keuangan()"><i class="fas fa-plus mr-1"></i> Input</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table table-bordered table-striped data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($keuangan as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo shortdate_indo($row->tanggal); ?></td>
                      <td>
                        <?php if ($row->jenis == '1') { ?>
                          <span class="badge bg-success">Pemasukan</span>
                        <?php } elseif ($row->jenis == '2') { ?>
                          <span class="badge bg-warning">Pengeluaran</span>
                        <?php } ?>
                      </td>
                      <td>Rp <?php echo str_replace('-', '', number_format($row->jumlah, 0, "", ".")); ?></td>
                      <td><?php echo $row->keterangan; ?></td>
                      <td class="project-actions text-right">

                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_keuangan(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
                          <i class="fas fa-trash">
                          </i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3"></th>
                    <th><span style="font-weight: 400;">Saldo :</span> Rp <?php echo number_format($saldo->total, 0, "", "."); ?></th>
                    <th colspan="2"></th>
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

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Laporan Keuangan</h3>
              <div class="card-tools mr-1">
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Periode</th>
                    <th>Total Dana Masuk</th>
                    <th>Total Dana Keluar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($laporan as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo bulan($row->bulan); ?> <?php echo $row->tahun; ?></td>
                      <td>Rp <?php echo str_replace('-', '', number_format($row->total_dana_masuk, 0, "", ".")); ?></td>
                      <td>Rp <?php echo str_replace('-', '', number_format($row->total_dana_keluar, 0, "", ".")); ?></td>
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

    <div class="modal fade" id="input-keuangan">
      <div class="modal-dialog modal-md ">
        <form id="form_keuangan" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input keuangan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
              </div>
              <div class="form-group">
                <label for="no_replas">Tanggal Transaksi</label>
                <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal" id="tanggal" />
                  <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Jenis</label>
                <select class="form-control" style="width: 100%;" name="jenis" id="jenis">
                  <option value="">Pilih jenis</option>
                  <option value="1">Pemasukan</option>
                  <option value="2">Pengeluaran</option>
                </select>
              </div>
              <div class="form-group">
                <label for="nama_rekening">Jumlah</label>
                <input type="text" class="form-control number" id="jumlah" name="jumlah" placeholder="Input jumlah transaksi">
              </div>
              <div class="form-group">
                <label for="nomor_rekening">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
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
  function input_keuangan() {
    $('#form_keuangan')[0].reset();
    $("#input-keuangan").modal('show');
  }

  $('#form_keuangan').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_keuangan')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_keuangan/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_keuangan')[0].reset();
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
    $("#input-keuangan").modal('show');
    $('.modal-title').html('Edit keuangan');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_keuangan"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_keuangan')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="jenis"]').val(data[i].jenis).change();
          $('[name="tanggal"]').val(data[i].tanggal);
          $('[name="jumlah"]').val($.number(data[i].jumlah).replace(/\,/g, '.').replace(/\-/g, ''));
          $('[name="keterangan"]').val(data[i].keterangan);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_keuangan(id) {
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
            tbl: "tbl_keuangan",
          },
          dataType: "JSON",
          success: function(data) {
            Swal.fire(
              'Deleted!',
              'Data has been deleted.',
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