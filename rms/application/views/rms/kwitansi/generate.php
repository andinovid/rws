<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kwitansi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kwitansi</li>
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
              <h3 class="card-title">Kwitansi</h3>
              <div class="card-tools mr-1">
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="generate_invoice()"><i class="fas fa-print mr-1"></i> Generate Kwitansi</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table table-bordered table-striped data-table" id="tbl-invoice">
                <thead>
                  <tr>
                    <th></th>
                    <th>No DO</th>
                    <th>No Replas</th>
                    <th>Vendor</th>
                    <th>Nopol</th>
                    <th>Supir</th>
                    <th>Susut</th>
                    <th>Claim Susut</th>
                    <th>Total Claim</th>
                    <th>Uang Sangu</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($kwitansi as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><input type="checkbox" name="id[]" value="<?php echo $row->id_rekap; ?>" /></td>
                      <td><?php echo $row->no_do; ?></td>
                      <td><?php echo $row->no_replas; ?></td>
                      <td><?php echo $row->vendor; ?></td>
                      <td><?php echo $row->nopol; ?></td>
                      <td><?php echo $row->nama_supir; ?></td>
                      <td><?php echo $row->m_susut; ?></td>
                      <td><?php echo $row->c_claim; ?></td>
                      <td>Rp <?php echo number_format($row->total_claim, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->uang_sangu, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->grand_total, 0, "", "."); ?></td>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>No DO</th>
                    <th>No Replas</th>
                    <th>Vendor</th>
                    <th>Nopol</th>
                    <th>Supir</th>
                    <th>Susut</th>
                    <th>Claim Susut</th>
                    <th>Total Claim</th>
                    <th>Uang Sangu</th>
                    <th>Total</th>
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

    <div class="modal fade" id="generate-invoice">
      <div class="modal-dialog modal-md">
        <form id="form_generate_invoice" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Generate Kwitansi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nama">Nomor Kwitansi</label>
                    <input type="hidden" class="form-control" id="id_rekap_invoice" name="id_rekap_invoice">
                    <input type="text" class="form-control" id="no_invoice" name="no_invoice" placeholder="Input Nomor Kwitansi">
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
  

  function generate_invoice() {
    var table = $('#tbl-invoice').DataTable();
    event.preventDefault();
    table.page.len( -1 ).draw();
    var searchIDs = $("#tbl-invoice input:checkbox:checked").map(function() {
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
      url: '<?php echo base_url(); ?>rms/save_generate_kwitansi',
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
            location.reload();
          });
        } else {
          alert("failed!");
        }
      }
    });
  });
</script>