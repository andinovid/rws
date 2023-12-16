<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Rekapitulasi Data</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Project</li>
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
              <h3 class="card-title">Rekapitulasi Data</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="generate_invoice()"><i class="fas fa-print mr-1"></i> Generate Kwitansi</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered data-table" id="tbl-rekap">
                <thead class="thead-dark">
                  <tr>
                    <th rowspan="2" class="text-center align-middle">#</th>
                    <th rowspan="2" class="text-center align-middle">No Replas</th>
                    <th rowspan="2" class="text-center align-middle">Tanggal Muat</th>
                    <th rowspan="2" class="text-center align-middle">Tanggal Bongkar</th>
                    <th rowspan="2" class="text-center align-middle">Supir</th>
                    <th rowspan="2" class="text-center align-middle">Nopol</th>
                    <th rowspan="2" class="text-center align-middle">Tujuan</th>
                    <th colspan="2" class="text-center align-middle">Qty Awal</th>
                    <th colspan="2" class="text-center align-middle">Qty Akhir</th>
                    <th colspan="2" class="text-center align-middle">Susut</th>
                    <th rowspan="2" class="text-center align-middle">Action</th>
                  </tr>
                  <tr>
                    <th class="text-center align-middle">Bag</th>
                    <th class="text-center align-middle">Kg</th>
                    <th class="text-center align-middle">Bag</th>
                    <th class="text-center align-middle">Kg</th>
                    <th class="text-center align-middle">M</th>
                    <th class="text-center align-middle">C</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 0;
                  $no++;
                  foreach ($rekap as $row) : ?>
                    <tr>
                      <td>
                        <input type="checkbox" class="select-row" name="id[]" value="<?php echo $row->id_rekap; ?>" />
                      </td>
                      <td><?php echo $row->no_replas; ?></td>
                      <td><?php if ($row->tanggal_muat) {
                            echo shortdate_indo($row->tanggal_muat);
                          } ?></td>
                      <td><?php if ($row->tanggal_bongkar) {
                            echo shortdate_indo($row->tanggal_bongkar);
                          } ?></td>
                      <td><?php echo $row->nama_supir; ?></td>
                      <td><?php echo $row->nopol; ?></td>
                      <td><?php echo $row->nama_tujuan; ?></td>
                      <td><?php echo number_format($row->timbang_kebun_bag, 0, "", "."); ?></td>
                      <td><?php echo number_format($row->timbang_kebun_kg, 0, "", "."); ?> Kg</td>
                      <td><?php echo number_format($row->qty_kirim_bag, 0, "", "."); ?></td>
                      <td><?php echo number_format($row->qty_kirim_kg, 0, "", "."); ?> Kg</td>
                      <td><?php echo number_format($row->m_susut, 0, "", "."); ?> Kg</td>
                      <td><?php echo number_format($row->c_claim, 0, "", "."); ?> Kg</td>

                      <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_rekap; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
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
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="generate-invoice">
      <div class="modal-dialog modal-md">
        <form id="form_generate_invoice" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Generate Kwitansi Transporter</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Periode bulan</label>
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
                  <div class="form-group">
                    <label>Periode tahun</label>
                    <select class="form-control" style="width: 100%;" name="tahun" id="tahun">
                      <option value="">Pilih tahun</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="nama">Uang Sangu</label>
                    <input type="hidden" class="form-control" id="id_rekap_invoice" name="id_rekap_invoice">
                    <input type="text" class="form-control number" id="uang_sangu" name="uang_sangu" placeholder="Input uang sangu">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer" style="justify-content: flex-start;">
              <button type="submit" class="btn btn-primary">Generate</button>
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
    $('.select-row').click(function() {
      var backgroundColor = $(this).is(":checked") ? "#fff99c;" : "";
      $(this).closest('tr').attr('style', 'background-color: ' + backgroundColor + '');
    });
  });

  function generate_invoice() {
    var table = $('#tbl-rekap').DataTable();
    event.preventDefault();
    table.page.len(-1).draw();
    var searchIDs = $("#tbl-rekap input:checkbox:checked").map(function() {
      return $(this).val();
    }).get();

    if (searchIDs != "") {
      $('[name="id_rekap_invoice"]').val(searchIDs);
      $('#form_generate_invoice')[0].reset();
      $("#generate-invoice").modal('show');
    } else {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Silahkan pilih invoice yang akan dicetak!"
      });
    }
  }

  $('#form_generate_invoice').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_generate_invoice')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_generate_kwitansi_transporter',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_generate_invoice')[0].reset();
        $('.loading').hide();
        if (data.status = "true") {
          Swal.fire({
            icon: 'success',
            title: "Berhasil!",
            text: "Kwitansi berhasil digenerate.",
            type: "success"
          }).then((result) => {
            window.open('<?php echo base_url(); ?>kwitansi-transporter/data', '_self');
          });
        } else {
          alert("failed!");
        }
      }
    });
  });

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
          $('[name="tanggal"]').val(data[i].tanggal_muat);
          $('[name="tanggal"]').val(data[i].tanggal_bongkar);
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