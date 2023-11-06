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
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="cetak_invoice()"><i class="fas fa-print mr-1"></i> Cetak Invoice</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table table-bordered table-striped data-table" id="tbl-invoice">
                <thead>
                  <tr>
                    <th></th>
                    <th>No</th>
                    <th>No Kontrak</th>
                    <th>No DO</th>
                    <th>Nama Perusahaan</th>
                    <th>Total Nilai</th>
                    <th>Claim Susut</th>
                    <th>Grand Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($invoice as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><input type="checkbox" name="id[]" value="<?php echo $row->id_project; ?>" /></td>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->no_kontrak; ?></td>
                      <td><?php echo $row->no_do; ?></td>
                      <td><?php echo $row->nama_perusahaan; ?></td>
                      <td>Rp <?php echo number_format($row->total_nilai, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->total_biaya_claim, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->total_invoice, 0, "", "."); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>No</th>
                    <th>No Kontrak</th>
                    <th>No DO</th>
                    <th>Nama Perusahaan</th>
                    <th>Total Nilai</th>
                    <th>Claim Susut</th>
                    <th>Grand Total</th>
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

    <div class="modal fade" id="cetak-invoice">
      <div class="modal-dialog modal-sm">
        <form action="<?php echo base_url(); ?>rms/cetak_invoice" id="cetak_invoice1" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Cetak Invoice</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nama">PPh %</label>
                    <input type="hidden" class="form-control" id="id_project_invoice" name="id_project_invoice">
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

  function delete_tujuan(id) {
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
            tbl: "tbl_tujuan",
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