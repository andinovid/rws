<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Pinjaman</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Data Pinjaman</li>
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
              <h3 class="card-title">Data Pinjaman</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_keuangan()"><i class="fas fa-plus mr-1"></i> Input</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table data-table">
                <thead>
                  <tr>
                    <th>Supir</th>
                    <th>Nopol</th>
                    <th>Jumlah Pinjaman</th>
                    <th>Tanggal</th>
                    <th>Untuk Periode</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th  style="width: 8%;"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($pinjaman as $row) :
                  ?>
                    <tr>
                      <td><?php echo $row->nama_supir; ?></td>
                      <td><?php echo $row->nopol; ?></td>
                      <td>Rp <?php echo number_format($row->jumlah_pinjaman, 0, "", "."); ?></td>
                      <td><?php echo shortdate_indo($row->tanggal); ?></td>
                      <td><?php echo bulan($row->periode_bulan) . ' ' . $row->periode_tahun; ?></td>
                      <td><?php echo $row->keterangan; ?></td>
                      <td>
                        <?php if ($row->status_pinjaman == '0') { ?>
                          <span class="badge bg-warning">Belum dibayar</span>
                        <?php } else { ?>
                          <span class="badge bg-success ">Sudah dibayar</span>
                        <?php } ?>
                      </td>
                      <td class="project-actions text-right">

                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_pinjaman; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_keuangan(<?php echo $row->id_pinjaman; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
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

    <div class="modal fade" id="input-keuangan">
      <div class="modal-dialog modal-md ">
        <form id="form_keuangan" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input pinjaman</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
              </div>
              <div class="form-group">
                <label for="no_replas">Tanggal</label>
                <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal" id="tanggal" />
                  <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Untuk Periode</label>
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="bulan" id="bulan">
                      <option value="">Pilih bulan</option>
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" style="width: 100%;" name="tahun" id="tahun">
                      <option value="">Pilih tahun</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Truck</label>
                <select class="form-control select2" style="width: 100%;" name="truck" id="truck">
                  <option value="0">Pilih truck</option>
                  <?php foreach ($truck as $row) : ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->nopol; ?></option>
                  <?php endforeach; ?>
                </select>
                <input type="hidden" class="form-control" id="nama_supir" name="nama_supir">
              </div>
              <div class="form-group">
                <label>Supir</label>
                <select class="form-control select2" style="width: 100%;" name="supir" id="supir">
                  <option value="0">Pilih supir</option>
                  <?php foreach ($supir as $row) : ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?> (<?php if($row->kategori == '1'){echo 'Kantor';}else{ echo 'Vendor';} ?>)</option>
                  <?php endforeach; ?>
                </select>
                <input type="hidden" class="form-control" id="nama_supir" name="nama_supir">
              </div>
              <div class="form-group">
                <label for="nama_rekening">Jumlah</label>
                <input type="text" class="form-control number" id="jumlah" name="jumlah" placeholder="Input jumlah transaksi">
              </div>
              <div class="form-group">
                <label for="nama_rekening">Keterangan</label>
                <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
              </div>
              <div class="form-group">
                <label for="kategori">Status</label>
                <select id="colorselector" class="form-control" name="status">
                  <option>Pilih status</option>
                  <option value="0">Belum dibayar</option>
                  <option value="1">Sudah dibayar</option>
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
      url: '<?php echo base_url(); ?>rms/save_pinjaman/',
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
    $("#input-keuangan").modal('show');
    $('.modal-title').html('Edit pinjaman');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_pinjaman"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_keuangan')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="truck"]').val(data[i].id_truck).change();
          $('[name="supir"]').val(data[i].id_supir).change();
          $('[name="tanggal"]').val(data[i].tanggal);
          $('[name="bulan"]').val(data[i].periode_bulan).change();
          $('[name="tahun"]').val(data[i].periode_tahun).change();
          $('[name="keterangan"]').val(data[i].keterangan);
          $('[name="jumlah"]').val($.number(data[i].jumlah_pinjaman).replace(/\,/g, '.').replace(/\-/g, ''));
          $('[name="status"]').val(data[i].status).change();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_keuangan(id) {
    Swal.fire({
      title: 'Hapus data?',
      text: "Setelah data dihapus, data tidak dapat kembali!",
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
            tbl: "tbl_pinjaman",
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