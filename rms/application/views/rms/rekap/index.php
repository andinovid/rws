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
                <button type="button" class="btn btn-inline btn-success btn-sm" onclick="generate_invoice()"><i class="fas fa-print mr-1"></i> Generate Kwitansi</button>
                <button type="button" class="btn btn-inline btn-primary btn-sm" onclick="input_replas()"><i class="fas fa-plus mr-1"></i> Input Replas</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body fixed-table">
              <table class="table data-table-fixed2 display nowrap" id="tbl-rekap">
                <thead>
                  <tr>
                    <th rowspan="2" class="text-center align-middle">#</th>
                    <th rowspan="2" class="text-center align-middle">No Replas</th>
                    <th rowspan="2" class="text-center align-middle">Tanggal Muat</th>
                    <th rowspan="2" class="text-center align-middle">Tanggal Bongkar</th>
                    <th rowspan="2" class="text-center align-middle">Supir</th>
                    <th rowspan="2" class="text-center align-middle">Nopol</th>
                    <th rowspan="2" class="text-center align-middle">Tujuan</th>
                    <th colspan="2" class="text-center align-middle hidden-xs">Qty Awal</th>
                    <th colspan="2" class="text-center align-middle hidden-xs">Qty Akhir</th>
                    <th colspan="2" class="text-center align-middle hidden-xs">Susut</th>
                    <th rowspan="2" class="text-center align-middle" style="width: 8%;">Action</th>
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
              <div class="form-group">
                <label>Project</label>
                <select class="form-control select2" style="width: 100%;" name="id_project" id="id_project">
                  <option value="0">Pilih No. DO</option>
                  <?php foreach ($project as $row) : ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->no_do; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <hr>
              <div class="row" id="content-replas">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="id" id="id" placeholder="id">

                    <label for="no_replas">Nomor Replas</label>
                    <input type="text" class="form-control" id="no_replas" name="no_replas" placeholder="Input nomor replas">
                  </div>

                  <div class="form-group" id="nomor_tiket">
                    <label for="no_replas">Nomor Tiket</label>
                    <input type="text" class="form-control" id="no_tiket" name="no_tiket" placeholder="Input nomor tiket">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal Muat</label>
                    <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal_muat" id="tanggal_muat" />
                      <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal Bongkar</label>
                    <div class="input-group date reservationdate reservationdate2" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate2" data-toggle="datetimepicker" name="tanggal_bongkar" id="tanggal_bongkar" />
                      <div class="input-group-append" data-target=".reservationdate2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Supir</label>
                    <select class="form-control select2" style="width: 100%;" name="supir" id="supir">
                      <option value="0">Pilih supir</option>
                      <?php foreach ($supir as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?> (<?php if ($row->kategori == '1') {
                                                                                              echo 'Kantor';
                                                                                            } else {
                                                                                              echo 'Vendor';
                                                                                            } ?>)</option>
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
                    <label for="no_replas">Qty Awal</label>
                    <hr class="mt-1 mb-1">
                    <div class="row bruto_tarra">
                      <div class="col-md-4">
                        <label for="no_replas">Bruto Awal</label>
                        <input type="text" class="form-control" name="bruto_awal" id="bruto_awal" placeholder="Bruto awal (kg)">
                      </div>
                      <div class="col-md-4">
                        <label for="no_replas">Tarra Awal</label>
                        <input type="text" class="form-control" name="tarra_awal" id="tarra_awal" placeholder="Tarra awal (kg)">
                      </div>
                      <div class="col-md-4">
                        <label for="no_replas">Netto Awal</label>
                        <input type="text" class="form-control" name="timbang_kebun_kg" id="timbang_kebun_kg" placeholder="Netto (kg)">
                      </div>
                    </div>
                    <div class="row bag_kg">
                      <div class="col-md-6">
                        <label for="no_replas">Bag</label>
                        <input type="text" class="form-control" name="timbang_kebun_bag" id="timbang_kebun_bag" placeholder="Bag">
                      </div>
                      <div class="col-md-6">
                        <label for="no_replas">Kg</label>
                        <input type="text" class="form-control number" name="timbang_kebun_kg" id="timbang_kebun_kg" placeholder="Kg">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Qty Akhir</label>
                    <hr class="mt-1 mb-1">
                    <div class="row bruto_tarra">
                      <div class="col-md-4">
                        <label for="no_replas">Bruto Akhir</label>
                        <input type="text" class="form-control" name="bruto_akhir" id="bruto_akhir" placeholder="Bruto akhir (kg)">
                      </div>
                      <div class="col-md-4">
                        <label for="no_replas">Tarra Akhir</label>
                        <input type="text" class="form-control" name="tarra_akhir" id="tarra_akhir" placeholder="Tarra akhir (kg)">
                      </div>
                      <div class="col-md-4">
                        <label for="no_replas">Netto Akhir</label>
                        <input type="text" class="form-control" placeholder="Netto (kg)" name="qty_kirim_kg" id="qty_kirim_kg">
                      </div>
                    </div>
                    <div class="row bag_kg">
                      <div class="col-md-6">
                        <label for="no_replas">Bag</label>
                        <input type="text" class="form-control" placeholder="Bag" name="qty_kirim_bag" id="qty_kirim_bag">
                      </div>
                      <div class="col-md-6">
                        <label for="no_replas">Kg</label>
                        <input type="text" class="form-control" placeholder="Kg" name="qty_kirim_kg" id="qty_kirim_kg">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Toleransi Susut (kg)</label>
                    <input type="text" class="form-control" name="toleransi_susut" id="toleransi_susut" placeholder="Toleransi Susut">
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
            <div class="container bg-loading noEvents noSelect" style="display: none;">
              <button class="btn btn-lg btn-warning"><i class="fa fa-spinner glyphicon-refresh-animate"></i><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Please wait...</button>
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

  $('#bruto_awal, #tarra_awal').on('change keyup', function() {
    var res = $('#bruto_awal').val() - $('#tarra_awal').val();
    $('#timbang_kebun_kg').val(res)
  })

  $('#bruto_akhir, #tarra_akhir').on('change keyup', function() {
    var res = $('#bruto_akhir').val() - $('#tarra_akhir').val();
    $('#qty_kirim_kg').val(res)
  })


  $(function() {
    $('#content-replas').hide();
    $('#id_project').change(function() {
      var id_project = $('#id_project').val();
      $.ajax({
        url: '<?php echo base_url(); ?>rms/cek_project/' + id_project,
        processData: false,
        contentType: false,
        dataType: "JSON",
        beforeSend: function() {
        $('.bg-loading').show();
      },
        success: function(data) {
        $('.bg-loading').hide();
          $('#content-replas').show();
          if (data.id_klien == '8' || data.id_klien == '9' || data.id_klien == '16') {
            $('#nomor_tiket').show();
          } else {
            $('#nomor_tiket').hide();
          }

          if (data.id_komoditas == '2' || (data.id_komoditas == '3' && data.id_klien == '6')) {
            $('.bruto_tarra').show();
            $('.bag_kg').hide();
          } else {
            $('.bruto_tarra').hide();
            $('.bag_kg').show();
          }
        }
      });
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
        
        $('.bg-loading').show();
      },
      success: function(data) {
        $('.bg-loading').hide();
        for (var i = 0; i < data.length; i++) {
          $('[name="no_replas"]').val(data[i].no_replas);
          $('[name="id_project"]').val(data[i].id_project).change();

          if (data[i].id_klien == '8' || data[i].id_klien == '9' || data[i].id_klien == '16') {
            $('#nomor_tiket').show();
          } else {
            $('#nomor_tiket').hide();
          }

          if (data[i].id_komoditas == '2' || (data[i].id_komoditas == '3' && data[i].id_klien == '6')) {
            $('.bruto_tarra').show();
            $('.bag_kg').hide();
          } else {
            $('.bruto_tarra').hide();
            $('.bag_kg').show();
          }
          $('[name="no_tiket"]').val(data[i].no_tiket);
          $('[name="tanggal_muat"]').val(data[i].tanggal_muat);
          $('[name="tanggal_bongkar"]').val(data[i].tanggal_bongkar);
          $('[name="supir"]').val(data[i].id_supir).change();
          $('[name="truck"]').val(data[i].id_truck).change();
          $('[name="tujuan"]').val(data[i].id_tujuan).change();
          $('[name="bruto_awal"]').val(data[i].bruto_awal);
          $('[name="tarra_awal"]').val(data[i].tarra_awal);
          $('[name="bruto_akhir"]').val(data[i].bruto_akhir);
          $('[name="tarra_akhir"]').val(data[i].tarra_akhir);
          $('[name="qty_kirim_bag"]').val(data[i].qty_kirim_bag);
          $('[name="qty_kirim_kg"]').val(data[i].qty_kirim_kg);
          $('[name="timbang_kebun_bag"]').val(data[i].timbang_kebun_bag);
          $('[name="timbang_kebun_kg"]').val(data[i].timbang_kebun_kg);
          $('[name="toleransi_susut"]').val(data[i].toleransi_susut);
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