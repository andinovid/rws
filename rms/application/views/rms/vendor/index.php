<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data vendor</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">data vendor</li>
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
              <h3 class="card-title">Data vendor</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_vendor()"><i class="fas fa-plus mr-1"></i> Input vendor</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table table-bordered table-striped data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No Rekening</th>
                    <th>Nama Rekening</th>
                    <th>Bank</th>
                    <th>Jenis Pajak</th>
                    <th>No Pajak</th>
                    <th>Nama Pajak</th>
                    <th>Jumlah Truk</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($vendor as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->nama; ?></td>
                      <td><?php echo $row->no_rekening; ?></td>
                      <td><?php echo $row->nama_rekening; ?></td>
                      <td><?php echo $row->bank; ?></td>
                      <td><?php echo $row->jenis_pajak; ?></td>
                      <td><?php echo $row->no_pajak; ?></td>
                      <td><?php echo $row->nama_pajak; ?></td>
                      <td><?php echo $row->total_truck; ?></td>
                      <td class="project-actions text-right">
                        <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>rms/vendor/view/<?php echo $row->id; ?>" data-toggle="tooltip" data-placement="top" title="Detail Vendor">
                          <i class="fas fa-folder">
                          </i>
                        </a>
                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_vendor(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
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
                    <th>Nama</th>
                    <th>No Rekening</th>
                    <th>Nama Rekening</th>
                    <th>Bank</th>
                    <th>Jenis Pajak</th>
                    <th>No Pajak</th>
                    <th>Nama Pajak</th>
                    <th>Jumlah Truk</th>
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

    <div class="modal fade" id="input-vendor">
      <div class="modal-dialog modal-lg">
        <form id="form_vendor" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input Vendor</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama">Nama</label>

                    <input type="hidden" class="form-control" name="id" id="id" placeholder="id">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Input nama vendor">
                  </div>
                  <div class="form-group">
                    <label for="nomor_rekening">Nomor Rekening</label>
                    <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening" placeholder="Input nomor rekening">
                  </div>
                  <div class="form-group">
                    <label for="nama_rekening">Nama Rekening</label>
                    <input type="text" class="form-control" id="nama_rekening" name="nama_rekening" placeholder="Input nama rekening">
                  </div>
                  <div class="form-group">
                    <label for="bank">Bank</label>
                    <input type="text" class="form-control" id="bank" name="bank" placeholder="Input nama bank">
                  </div>
                </div>
                <div class="col-md-6">

                  <div class="form-group">
                    <label for="jenis_pajak">Jenis Pajak</label>
                    <select id="colorselector" class="form-control" name="jenis_pajak">
                      <option>Pilih jenis pajak</option>
                      <option value="ktp">KTP</option>
                      <option value="npwp">NPWP</option>
                      <option value="skb">SKB</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="no_pajak">Nomor Pajak</label>
                    <input type="text" class="form-control" id="no_pajak" name="no_pajak" placeholder="Input nama rekening">
                  </div>
                  <div class="form-group">
                    <label for="no_pajak">Nama Pajak</label>
                    <input type="text" class="form-control" id="nama_pajak" name="nama_pajak" placeholder="Input nama rekening">
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

  function input_vendor() {
    $('#form_vendor')[0].reset();
    $("#input-vendor").modal('show');
  }

  $('#form_vendor').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_vendor')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_vendor/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_vendor')[0].reset();
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
    $("#input-vendor").modal('show');
    $('.modal-title').html('Edit vendor');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_vendor_truck"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_vendor')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="nama"]').val(data[i].nama);
          $('[name="nomor_rekening"]').val(data[i].no_rekening);
          $('[name="nama_rekening"]').val(data[i].nama_rekening);
          $('[name="bank"]').val(data[i].bank);
          $('[name="jenis_pajak"]').val(data[i].jenis_pajak).change();
          $('[name="no_pajak"]').val(data[i].no_pajak);
          $('[name="nama_pajak"]').val(data[i].nama_pajak);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_vendor(id) {
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
            tbl: "tbl_vendor_truck",
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