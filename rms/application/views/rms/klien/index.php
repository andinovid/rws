<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data klien</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">data klien</li>
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
              <h3 class="card-title">Data klien</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="input_klien()"><i class="fas fa-plus mr-1"></i> Input klien</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table table-bordered table-striped data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Klien</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No TLP</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($klien as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->nama_perusahaan; ?></td>
                      <td><?php echo $row->alamat; ?></td>
                      <td><?php echo $row->email; ?></td>
                      <td><?php echo $row->no_tlp; ?></td>
                      <td class="project-actions text-right">
                        <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>rms/klien/view/<?php echo $row->id; ?>" data-toggle="tooltip" data-placement="top" title="Detail klien">
                          <i class="fas fa-folder">
                          </i>
                        </a>
                        <a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="edit(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Edit">
                          <i class="fas fa-pencil-alt">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_klien(<?php echo $row->id; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
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
                    <th>Nama Klien</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No TLP</th>
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

    <div class="modal fade" id="input-klien">
      <div class="modal-dialog modal-lg">
        <form id="form_klien" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Input klien</h4>
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
                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" placeholder="Input nama klien">
                  </div>
                  <div class="form-group">
                    <label for="nomor_rekening">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Input nomor alamat">
                  </div>
                  <div class="form-group">
                    <label for="nama_rekening">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Input email">
                  </div>
                  <div class="form-group">
                    <label for="bank">No Tlp</label>
                    <input type="text" class="form-control" id="no_tlp" name="no_tlp" placeholder="Input nama bank">
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

  function input_klien() {
    $('#form_klien')[0].reset();
    $("#input-klien").modal('show');
  }

  $('#form_klien').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_klien')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_klien/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_klien')[0].reset();
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
    $("#input-klien").modal('show');
    $('.modal-title').html('Edit klien');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_klien"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_klien')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="nama"]').val(data[i].nama_perusahaan);
          $('[name="alamat"]').val(data[i].alamat);
          $('[name="email"]').val(data[i].alamat);
          $('[name="no_tlp"]').val(data[i].no_tlp);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_klien(id) {
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
            tbl: "tbl_klien",
          },
          dataType: "JSON",
          success: function(data) {
            Swal.fire(
              'Deleted!',
              'Klien has been deleted.',
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