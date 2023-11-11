<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Perbaikan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">data perbaikan</li>
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
              <h3 class="card-title">Data Perbaikan</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_perbaikan()"><i class="fas fa-plus mr-1"></i> Input Perbaikan</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table table-bordered table-striped data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nopol Truk</th>
                    <th>Jenis</th>
                    <th>Supir</th>
                    <th>Tanggal Perbaikan</th>
                    <th>Jumlah</th>
                    <th>Nota</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $no = 0;
                  foreach ($perbaikan as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->nopol; ?></td>
                      <td><?php echo $row->jenis_perbaikan; ?></td>
                      <td><?php echo $row->nama_supir; ?></td>
                      <td><?php echo shortdate_indo($row->tanggal_perbaikan); ?></td>
                      <td><?php echo number_format($row->jumlah, 0, "", "."); ?></td>
                      <td><?php if ($row->nota) { ?> <a href="javascript:void(0);" class="lihat-nota" data-rel="<?php echo base_url(); ?>assets/rms/documents/nota_perbaikan/<?php echo $row->nota; ?>">Lihat nota</a> <?php } else { ?> - <?php } ?></td>
                      <td>
                        <span class="badge <?php if ($row->status == '0') { ?>bg-warning <?php } else { ?> bg-success <?php } ?>"><?php echo $row->nama_status; ?></span>
                      </td>

                      <td class="project-actions text-right">
                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id_perbaikan; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_perbaikan(<?php echo $row->id_perbaikan; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
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
                    <th>Nopol Truk</th>
                    <th>Jenis</th>
                    <th>Supir</th>
                    <th>Tanggal Perbaikan</th>
                    <th>Jumlah</th>
                    <th>Nota</th>
                    <th>Status</th>
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

    <div class="modal fade" id="input-perbaikan">
      <div class="modal-dialog modal-lg">
        <form id="form_perbaikan" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Perbaikan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Truck</label>
                    <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                    <select class="form-control select2" style="width: 100%;" name="truck" id="truck">
                      <option value="0">Pilih truk</option>
                      <?php foreach ($truck as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nopol; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <input type="hidden" class="form-control" id="nopol" name="nopol">
                  </div>
                  <div class="form-group">
                    <label>Supir</label>
                    <select class="form-control select2" style="width: 100%;" name="supir" id="supir">
                      <option value="0">Pilih supir</option>
                      <?php foreach ($supir as $row) : ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <input type="hidden" class="form-control" id="nama_supir" name="nama_supir">
                  </div>

                  <div class="form-group">
                    <label>Jenis Perbaikan</label>
                    <textarea class="form-control" name="jenis" rows="2"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal perbaikan</label>
                    <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal" id="tanggal" />
                      <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">

                  <div class="form-group">
                    <label for="cicilan">Jumlah</label>
                    <input type="text" class="form-control number" id="jumlah" name="jumlah" placeholder="Input jumlah biaya perbaikan">
                  </div>

                  <div class="form-group">
                    <label for="no_replas">Foto Nota</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="nota" name="nota">
                      <label class="custom-file-label" for="nota" id="label-nota">Pilih file pdf/jpg</label>
                    </div>
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

                <div class="col-md-12" id="sparepart-content">
                  <hr>
                  <h3 style="font-size: 1.5rem;">Sparepart Kantor</h3>
                  <table class="table mt-3" id="perbaikan_sparepart">
                    <thead class="bg-dark">
                      <tr>
                        <th>Nama Sparepart</th>
                        <th>Jumlah</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <select class="form-control select2" style="width: 100%;" name="sparepart" id="sparepart">
                            <option value="0">Pilih sparepart</option><?php foreach ($sparepart as $row) : ?><option value="<?php echo $row->id; ?>"><?php echo $row->nama; ?></option><?php endforeach; ?>
                          </select>
                        </td>
                        <td><input type="text" class="form-control" name="jumlah_sparepart" style="width:100px;" /></td>
                        <td>
                          <button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></button>
                        </td>
                      </tr>
                    </tbody>
                    <tbody id="tbody2">

                    </tbody>
                  </table>
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





    <div class="modal fade" id="modal-nota">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Nota</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="modal-body-nota">

          </div>
        </div>
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

    $('#truck').change(function() {
      $('#nopol').val($(this).find('option:selected').text());
    });
    $('#supir').change(function() {
      $('#nama_supir').val($(this).find('option:selected').text());
    });
  });


  $(function() {
    bsCustomFileInput.init();
  });


  $(".lihat-nota").click(function() {
    $("#modal-nota").modal('show');
    var imgUrl = $(this).data('rel');
    $("#modal-body-nota").html("<img src='" + imgUrl + "' style='width:100%;'/>");
  });

  function input_perbaikan() {
    $('#form_perbaikan')[0].reset();
    $('#sparepart-content').hide();
    $("#input-perbaikan").modal('show');
  }

  function pilih_truck(id) {
    $("#input-truck").modal('show');
    $("#id_project").val(id);
  }

  $('#form_perbaikan').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_perbaikan')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_perbaikan/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_perbaikan')[0].reset();
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

  function delete_perbaikan(id) {
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
            tbl: "tbl_perbaikan",
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

  function load_data_sparepart_perbaikan(id) {
    $.ajax({
      url: "<?php echo base_url(); ?>rms/load_data_sparepart_perbaikan/" + id,
      dataType: "JSON",
      success: function(data) {
        $('table#perbaikan_sparepart #tbody2').html('');
        for (var i = 0; i < data.length; i++) {
          var html = '<tr>';
          html += '<td class="table_data" data-row_id="' + data[i].id + '" data-column_name="nama" >' + data[i].nama_sparepart + '</td>';
          html += '<td class="table_data" data-row_id="' + data[i].id + '" data-column_name="jumlah" >' + data[i].jumlah + '</td>';
          html += '<td><button type="button" name="delete_btn" id="' + data[i].id + '" data-id="' + id + '" data-id-sparepart="' + data[i].id_sparepart + '" data-jumlah="' + data[i].jumlah + '" class="btn btn-xs btn-danger btn_delete"><i class="fa fa-times"></i></button></td></tr>';
          $('table#perbaikan_sparepart #tbody2').append(html);
        }

      }
    });
  }

  $(document).ready(function() {
    $(document).on('click', '#btn_add', function() {
      var sparepart = $('[name="sparepart"]').val();
      var jumlah = $('[name="jumlah_sparepart"]').val();
      var id_perbaikan = $('[name="id"]').val();
      $.ajax({
        url: "<?php echo base_url(); ?>rms/insert_sparepart_perbaikan",
        method: "POST",
        data: {
          id_sparepart: sparepart,
          id_perbaikan: id_perbaikan,
          jumlah: jumlah
        },
        success: function(data) {
          load_data_sparepart_perbaikan(id_perbaikan);
        }
      })
    });

    $(document).on('click', '.btn_delete', function() {
      var id = $(this).attr('id');
      var id_perbaikan = $(this).attr('data-id');
      var id_sparepart = $(this).attr('data-id-sparepart');
      var jumlah = $(this).attr('data-jumlah');
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
            url: "<?php echo base_url() ?>rms/delete_perbaikan_sparepart",
            type: "POST",
            data: {
              id: id,
              id_sparepart: id_sparepart,
              jumlah: jumlah,
            },
            success: function(data) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              ).then((result) => {
                load_data_sparepart_perbaikan(id_perbaikan);
              });
            }
          });
        }
      })
    });
  });
</script>