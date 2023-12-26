<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Rekapitulasi Data</h1>
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
              <h3 class="card-title">Rekapitulasi Data</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-primary btn-sm float-sm-right" onclick="input_replas()"><i class="fas fa-plus mr-1"></i> Input</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table " id="tbl_replas">
                  <thead >
                    <tr>
                      <th class="align-middle">Supir</th>
                      <th class="align-middle">Nopol</th>
                      <th class="align-middle">Komoditas</th>
                      <th class="align-middle">Tujuan</th>
                      <th class="align-middle">Qty</th>
                      <th class="align-middle">Harga</th>
                      <th class="align-middle">Harga Supir</th>
                      <th class="align-middle">Uang Sangu</th>
                      <th class="align-middle">Grand Total</th>
                      <th class="align-middle"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    foreach ($rekap as $row) : 
                      $old_date = $row->tanggal_input;
                      $old_date_timestamp = strtotime($old_date);
                    ?>
                      <tr>
                        <td><?php echo $row->nama_supir; ?></td>
                        <td><?php echo $row->nopol; ?></td>
                        <td><?php echo $row->komoditas; ?></td>
                        <td><?php echo $row->kode_tujuan; ?></td>
                        <td><?php echo $row->qty_kirim_kg; ?> Kg</td>
                        <td><?php echo 'Rp ' . number_format($row->non_do_harga, 0, "", "."); ?></td>
                        <td><?php echo 'Rp ' . number_format($row->non_do_harga_vendor, 0, "", "."); ?></td>
                        <td><?php echo 'Rp ' . number_format($row->uang_sangu, 0, "", "."); ?></td>
                        <td><?php echo 'Rp ' . number_format($row->grand_total, 0, "", "."); ?></td>
                        <td class="project-actions text-right">

                          <a class="btn btn-warning btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_rekap; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fas fa-pencil-alt">
                            </i>
                          </a>
                          <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_data(<?php echo $row->id_rekap; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
                            <i class="fas fa-trash">
                            </i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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
    <div class="modal fade" id="input-replas">
      <div class="modal-dialog modal-lg">
        <form id="form_replas" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Replas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                    <label>Supir</label>
                    <select class="form-control select2" style="width: 100%;" name="supir" id="supir">
                      <option value="0">Pilih supir</option>
                      <?php foreach ($supir as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Vendor Pencairan</label>
                    <select class="form-control select2" style="width: 100%;" name="vendor_pencairan" id="vendor_pencairan">
                      <option value="0">Pilih vendor pajak</option>
                      <?php foreach ($vendor as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Truck</label>
                    <select class="form-control select2" style="width: 100%;" name="truck" id="truck">
                      <option value="0">Pilih truk</option>
                      <?php foreach ($truck as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nopol; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Komoditas</label>
                    <select class="form-control select2" style="width: 100%;" name="komoditas" id="komoditas">
                      <option value="0">Pilih komoditas</option>
                      <?php foreach ($komoditas as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->komoditas; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Qty</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="timbang_kebun_kg" id="timbang_kebun_kg" placeholder="Qty awal (Kg)">
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="qty_kirim_kg" id="qty_kirim_kg" placeholder="Qty akhir (Kg)">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tujuan</label>
                    <select class="form-control select2" style="width: 100%;" name="tujuan" id="tujuan">
                      <option value="0">Pilih tujuan</option>
                      <?php foreach ($tujuan as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->kode_tujuan; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Harga</label>
                    <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga Satuan">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Harga vendor</label>
                    <input type="text" class="form-control" name="harga_supir" id="harga_supir" placeholder="Harga untuk vendor">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Uang Sangu</label>
                    <input type="text" class="form-control number" name="uang_sangu" id="uang_sangu" placeholder="Uang Sangu">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Biaya Admin</label>
                    <input type="text" class="form-control number" name="biaya_admin" id="biaya_admin"  placeholder="Biaya Admin">
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







  </section>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
  $(function() {
    $('#reservation').daterangepicker();


    var table = $("#tbl_replas").DataTable({
      "columnDefs": [{
        "visible": false,
        "searchable": true,
        "targets": 1
      }],
      "ordering": false,
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "pageLength": 20,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],

    }).buttons().container().appendTo('#tbl_replas_wrapper .col-md-6:eq(0)');

  });

  function filterData() {
    date = $("#date-filter").val();
    startdate = date.substring(0, 10);
    enddate = date.substring(13, 23);

    $.fn.dataTable.ext.search.push(
      function(settings, data, dataIndex) {
        var min = startdate;
        var max = enddate;
        var createdAt = data[2];

        if (
          (min == "" || max == "") ||
          (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
        ) {
          return true;
        }
        return false;
      }
    );
    var table = $("#tbl_replas").DataTable();
    table.draw();
  }


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
      url: '<?php echo base_url(); ?>rms/save_replas_non_do/',
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

          $('[name="supir"]').val(data[i].id_supir).change();
          $('[name="truck"]').val(data[i].id_truck).change();
          $('[name="tujuan"]').val(data[i].id_tujuan).change();
          $('[name="komoditas"]').val(data[i].non_do_id_komoditas).change();

          $('[name="timbang_kebun_kg"]').val(data[i].timbang_kebun_kg);
          $('[name="qty_kirim_kg"]').val(data[i].qty_kirim_kg);
          $('[name="harga"]').val(data[i].non_do_harga);
          $('[name="harga_supir"]').val(data[i].non_do_harga_vendor);
          $('[name="uang_sangu"]').val($.number(data[i].uang_sangu).replace(/\,/g, '.'));
          $('[name="biaya_admin"]').val($.number(data[i].non_do_biaya_admin).replace(/\,/g, '.'));
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