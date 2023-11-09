<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data sparepart</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">data sparepart</li>
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
              <h3 class="card-title">Data Sparepart</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_sparepart()"><i class="fas fa-plus mr-1"></i> Input sparepart</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table table-bordered table-striped data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($sparepart as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->nama; ?></td>
                      <td><?php if($row->foto){ ?> <img src="<?php echo base_url(); ?>assets/rms/documents/sparepart/<?php echo $row->foto; ?>"/> <?php }else{ ?> <img src="<?php echo base_url(); ?>assets/rms/dist/img/no-photo.jpg"/>  <?php } ?></td>
                      <td><?php echo number_format($row->qty, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->harga, 0, "", "."); ?></td>
                      <td class="project-actions text-right">
                        <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>sparepart/view/<?php echo $row->id; ?>" data-toggle="tooltip" data-placement="top" title="Detail sparepart">
                          <i class="fas fa-folder">
                          </i>
                        </a>
                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_sparepart(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
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
                    <th>Foto</th>
                    <th>Qty</th>
                    <th>Harga</th>
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

    <div class="modal fade" id="input-sparepart">
      <div class="modal-dialog modal-lg">
        <form id="form_sparepart" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input sparepart</h4>
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
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Input nama sparepart">
                  </div>
                  <div class="form-group">
                    <label for="nomor_rekening">Qty</label>
                    <input type="text" class="form-control" id="qty" name="qty" placeholder="Input qty sparepart">
                  </div>
                  <div class="form-group">
                    <label for="nama_rekening">Harga</label>
                    <input type="text" class="form-control number" id="harga" name="harga" placeholder="Input harga sparepart">
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Foto</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="foto" name="foto">
                      <label class="custom-file-label" for="foto" id="label-foto">Pilih file pdf/jpg</label>
                    </div>
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
  function input_sparepart() {
    $('#form_sparepart')[0].reset();
    $("#input-sparepart").modal('show');
  }

  $(function() {
    bsCustomFileInput.init();
  });
  $('#form_sparepart').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_sparepart')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_sparepart/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_sparepart')[0].reset();
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
    $("#input-sparepart").modal('show');
    $('.modal-title').html('Edit sparepart');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_sparepart"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_sparepart')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="nama"]').val(data[i].nama);
          $('[name="qty"]').val($.number(data[i].qty).replace(/\,/g, '.'));
          $('[name="harga"]').val($.number(data[i].harga).replace(/\,/g, '.'));
          $('#label-foto').html(data[i].foto);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_sparepart(id) {
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
            tbl: "tbl_sparepart",
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