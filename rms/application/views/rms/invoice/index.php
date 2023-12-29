<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Invoice</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">invoice</li>
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
              <h3 class="card-title">Invoice</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body fixed-table">

              <table class="table data-table-fixed display nowrap" id="tbl-invoice">
                <thead>
                  <tr>
                    <th>No Invoice</th>
                    <th>Nama Perusahaan</th>
                    <th>Komoditas</th>
                    <th>Total Nilai</th>
                    <th>PPh</th>
                    <th>PPn</th>
                    <th>Claim Susut</th>
                    <th>Grand Total</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($invoice as $row) :
                  ?>
                    <tr>
                      <td><?php echo $row->no_invoice; ?></td>
                      <td><?php echo $row->nama_perusahaan; ?></td>
                      <td><?php echo $row->komoditas; ?></td>
                      <td>Rp <?php echo number_format($row->total, 0, "", "."); ?></td>
                      <td><?php if ($row->pph) { ?><span class="badge badge-danger"><?php echo $row->pph . '%'; ?></span> <?php echo 'Rp' . number_format($row->total_pph, 0, "", "."); ?> <?php } ?></td>
                      <td><?php if ($row->ppn) { ?><span class="badge badge-danger"><?php echo $row->ppn . '%'; ?></span> <?php echo 'Rp' . number_format($row->total_ppn, 0, "", "."); ?> <?php } ?></td>
                      <td>Rp <?php echo number_format($row->total_claim, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->grand_total, 0, "", "."); ?></td>
                      <td><span class="badge <?php if ($row->status == '0') { ?>bg-secondary <?php } elseif ($row->status == '1') { ?> bg-warning <?php } else { ?> bg-success <?php } ?>"><?php if ($row->status == '0') { ?> Belum dibayar <?php } elseif ($row->status == '1') { ?> Bayar pokok <?php } else { ?> Lunas <?php } ?></span></td>
                      <td class="project-actions text-right">
                        <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>rms/cetak_invoice/<?php echo $row->id_invoice; ?>" target="_blank" title="Cetak Invoice">
                          <i class="fas fa-print">
                          </i>
                        </a>
                        <?php if ($row->status != "2") { ?>
                          <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="bayar_invoice(<?php echo $row->id_invoice; ?>)" title="Bayar Invoice">
                            <i class="fas fa-credit-card">
                            </i>
                          </a>
                        <?php } elseif (($row->status != "0")) { ?>
                          <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>invoice/view/<?php echo $row->id_invoice; ?>" title="Riwayat Pembayaran Invoice">
                            <i class="fas fa-clock">
                            </i>
                          </a>
                        <?php } ?>
                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_invoice; ?>)" title="Edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_invoice(<?php echo $row->id_invoice; ?>)" title="Hapus">
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

    <div class="modal fade" id="cetak-invoice">
      <div class="modal-dialog modal-sm">
        <form action="<?php echo base_url(); ?>rms/cetak_invoice" id="cetak_invoice1" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Invoice</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nama">Nomor Invoice</label>
                    <input type="hidden" class="form-control" id="id_project_invoice" name="id_project_invoice">
                    <input type="text" class="form-control" id="no_invoice" name="no_invoice" placeholder="Input Nomor Invoice">
                  </div>
                  <div class="form-group">
                    <label for="nama">PPh %</label>
                    <input type="text" class="form-control" id="pph" name="pph" placeholder="Input PPh">
                  </div>
                  <div class="form-group">
                    <label for="nama">PPn %</label>
                    <input type="text" class="form-control" id="ppn" name="ppn" placeholder="Input PPn">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer" style="justify-content: flex-start;">
              <button type="submit" class="btn btn-primary">Cetak</button>
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

    <div class="modal fade" id="bayar-invoice">
      <div class="modal-dialog modal-lg">
        <form id="form_bayar_invoice" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pembayaran Invoice</h4>
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
                      <div class="col-md-4">
                        <div class="text-muted">
                          <p class="text-sm">No Invoice
                            <b class="d-block" id="label-no-invoice"></b>
                          </p>
                          <p class="text-sm">Nama Perusahaan
                            <b class="d-block" id="label-nama-perusahaan"></b>
                          </p>
                          <p class="text-sm">Total
                            <b class="d-block" id="label-total"></b>
                          </p>

                        </div>
                      </div>
                      <div class="col-md-4">
                        <p class="text-sm">PPh
                          <b class="d-block" id="label-pph"></b>
                        </p>
                        <p class="text-sm">PPn
                          <b class="d-block" id="label-ppn"></b>
                        </p>
                        <p class="text-sm">Grand Total
                          <b class="d-block" id="label-grand-total"></b>
                        </p>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                          <div class="input-group date reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate" data-toggle="datetimepicker" name="tanggal_pembayaran" id="tanggal_pembayaran" />
                            <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Status Pembayaran</label>
                          <select class="form-control" style="width: 100%;" name="status" id="status">
                            <option value="0">Belum dibayar</option>
                            <option value="1">Bayar Pokok</option>
                            <option value="2">Bayar Lunas</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer" style="justify-content: flex-start;">
              <button type="submit" class="btn btn-primary m-0">Bayar Invoice</button>
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
  function cetak_invoice() {

    event.preventDefault();
    var searchIDs = $("#tbl-invoice input:checkbox:checked").map(function() {
      return $(this).val();
    }).get();

    if (searchIDs != "") {
      $('[name="id_project_invoice"]').val(searchIDs);
      $('#cetak_invoice1')[0].reset();
      $("#cetak-invoice").modal('show');
    } else {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Silahkan pilih invoice yang akan dicetak!"
      });
    }
  }

  function edit(id) {
    $('#sparepart-content').show();
    load_data_sparepart_perbaikan(id);
    $("#input-perbaikan").modal('show');
    $('.modal-title').html('Edit perbaikan');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_perbaikan"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_perbaikan')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {

          $('[name="kategori"]').val(data[i].kategori).change();
          $('[name="truck"]').val(data[i].id_truck).change();
          $('[name="nopol"]').val(data[i].nopol);
          $('[name="supir"]').val(data[i].id_supir).change();
          $('[name="nama_supir"]').val(data[i].nama_supir);
          $('[name="jenis"]').val(data[i].jenis);
          $('[name="tanggal"]').val(data[i].tanggal);
          $('[name="jumlah"]').val($.number(data[i].jumlah).replace(/\,/g, '.'));
          $('#label-nota').html(data[i].nota);
          $('[name="status"]').val(data[i].status).change();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  $('#form_bayar_invoice').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_bayar_invoice')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_pembayaran_invoice/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_bayar_invoice')[0].reset();
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

  function bayar_invoice(id) {
    $("#bayar-invoice").modal('show');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/get_invoice",
      type: "POST",
      data: {
        'id': id
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_bayar_invoice')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('#label-no-invoice').html(data[i].no_invoice);
          $('#label-nama-perusahaan').html(data[i].nama_perusahaan);
          $('#label-total').html('Rp ' + $.number(data[i].total).replace(/\,/g, '.'));
          $('#label-ppn').html(data[i].ppn + '% - ' + data[i].total_ppn);
          $('#label-pph').html(data[i].pph + '% - ' + data[i].total_pph);
          $('#label-grand-total').html('Rp ' + $.number(data[i].grand_total).replace(/\,/g, '.'));
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }









  $('#form_tujuan').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_tujuan')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/cetak_invoice/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_tujuan')[0].reset();
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

  function delete_invoice(id) {
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
          url: "<?php echo base_url() ?>rms/delete_invoice",
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