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
                <img src="<?php echo base_url(); ?>assets/rms/dist/img/gas-station.png" width="100" class="mr-2" style="margin-top: -3px;">
                <h1 class="mt-3" style="font-weight: 600;"><?php echo $truck->bbm_terakhir; ?></h1>
                <a href="#" onclick="update_oddo()" class="btn btn-primary mt-3">Update BBM</a>
              </div>

              <table class="table table-striped table-valign-middle data-table-default">
                <thead>
                  <tr>
                    <th class="align-middle">Tanggal</th>
                    <th class="align-middle">Jumlah liter</th>
                    <th class="align-middle">Jumlah harga</th>
                    <th class="align-middle">Supir</th>
                    <th class="align-middle"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($bbm as $row) : ?>
                    <tr>
                      <td><?php if ($row->tanggal) {
                            echo shortdate_indo($row->tanggal);
                          } ?></td>
                      <td><?php echo $row->jumlah_liter; ?></td>
                      <td>Rp <?php echo number_format($row->jumlah_harga, 0, "", "."); ?></td>
                      <td><?php echo $row->nama_supir; ?></td>
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
              <h4 class="modal-title">Input Riwayat BBM</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                <input type="hidden" class="form-control" name="id_truck" id="id_truck" placeholder="id_truck" value="<?php echo $truck->id_truck; ?>">
                <input type="hidden" class="form-control" name="supir" id="supir" placeholder="id_truck" value="<?php echo $truck->id_supir; ?>">
                <input type="hidden" class="form-control" id="nama_supir" name="nama_supir" value="<?php echo $this->sess->name; ?>">
                <label for="no_replas">Tanggal Pengisian</label>
                <div class="input-group date reservationdate" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate" data-toggle="datetimepicker" name="tanggal" id="tanggal" />
                  <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="no_replas">Jumlah Liter</label>
                <input type="text" class="form-control" id="jumlah_liter" name="jumlah_liter" placeholder="Input jumlah liter">
              </div>
              <div class="form-group">
                <label for="no_replas">Jumlah Harga</label>
                <input type="text" class="form-control number" id="jumlah_harga" name="jumlah_harga" placeholder="Input jumlah harga">
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
      url: '<?php echo base_url(); ?>rms/save_pengisian_bbm/',
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
          tbl: 'tbl_pengisian_bbm',
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