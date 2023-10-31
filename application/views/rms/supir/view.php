<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail Supir</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $supir->nama; ?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h3 class="text-primary" style="margin-bottom: 18px;"><i class="nav-icon fas fa-id-card"></i> <?php echo $supir->nama; ?> </h3>
              <div class="row">
                <div class="col-md-6">

                  <div class="text-muted">
                    <p class="text-sm">Nomor Telepon
                      <b class="d-block"><?php echo $supir->no_wa; ?></b>
                    </p>
                    <p class="text-sm">Nomor KTP
                      <b class="d-block"><?php echo $supir->no_ktp; ?></b>
                    </p>

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="text-muted">
                    <p class="text-sm">No SIM
                      <b class="d-block"><?php echo $supir->no_sim; ?></b>
                    </p>
                    <a target="_blank" href="<?php echo base_url(); ?>assets/rms/documents/supir/<?php echo $supir->file_ktp; ?>" class="link-black text-sm mr-3"><i class="fas fa-file mr-1"></i> File KTP</a>
                    <a target="_blank" href="<?php echo base_url(); ?>assets/rms/documents/supir/<?php echo $supir->file_sim; ?>" class="link-black text-sm mr-3"><i class="fas fa-file mr-1"></i> File SIM</a>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title mt-2">Riwayat Aktifitas Supir</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-striped table-valign-middle data-table-default">
                <thead>
                  <tr>
                    <th class="align-middle">No Kontrak</th>
                    <th class="align-middle">Tanggal muat</th>
                    <th class="align-middle">Tanggal bongkar</th>
                    <th class="align-middle">nopol</th>
                    <th class="align-middle">Tujuan</th>
                    <th class="align-middle">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($rekap as $row) : ?>
                    <tr>
                      <td><?php echo $row->no_kontrak; ?></td>
                      <td>
                        <?php
                        if ($row->tanggal_muat) {
                          echo shortdate_indo($row->tanggal_muat);
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if ($row->tanggal_bongkar) {
                          echo shortdate_indo($row->tanggal_bongkar);
                        }
                        ?>
                      </td>
                      <td><?php echo $row->nopol; ?></td>
                      <td><?php echo $row->nama_tujuan; ?></td>
                      <td>
                        <?php if ($row->status == '0') { ?>
                          <span class="badge badge-warning">Sedang Mengirim</span>
                        <?php } else { ?>
                          <span class="badge badge-secondary">Selesai</span>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
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
          $('[name="tanggal"]').val(data[i].tanggal);
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