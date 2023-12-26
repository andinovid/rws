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
                <button type="button" class="btn btn-block btn-primary btn-sm" onclick="generate_invoice()"><i class="fas fa-print mr-1"></i> Generate Invoice</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table class="table data-table" id="tbl-invoice">
                <thead>
                  <tr>
                    <th id="total_selected"></th>
                    <th>No DO</th>
                    <th>No Kontrak</th>
                    <th>Nama Perusahaan</th>
                    <th>Total Nilai</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($invoice as $row) :
                  ?>
                    <tr>
                      <td><input type="checkbox" name="id[]" class="select-row" value="<?php echo $row->id_project; ?>" /></td>
                      <td><?php echo $row->no_do; ?></td>
                      <td><?php echo $row->no_kontrak; ?></td>
                      <td><?php echo $row->nama_perusahaan; ?></td>
                      <td>Rp <?php echo number_format($row->total_nilai, 0, "", "."); ?></td>
                      <td class="project-actions text-right">
                        <a class="btn btn-success btn-sm" target="_blank" href="<?php echo base_url(); ?>project/view/<?php echo $row->id_project; ?>" data-toggle="tooltip" data-placement="top" title="Detail Project">
                          <i class="fas fa-folder">
                          </i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>No DO</th>
                    <th>No Kontrak</th>
                    <th>Nama Perusahaan</th>
                    <th>Total Nilai</th>
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

    <div class="modal fade" id="generate-invoice">
      <div class="modal-dialog modal-md">
        <form id="form_generate_invoice" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Generate Invoice</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nama">Nomor Invoice</label>
                    <input type="hidden" class="form-control" id="id_project_invoice" name="id_project_invoice">
                    <input type="text" class="form-control" id="no_invoice" name="no_invoice" placeholder="Input Nomor Invoice">
                  </div>
                  <div class="form-group">
                    <label for="nama">Remark</label>
                    <textarea class="form-control" name="remark" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="no_replas">Tanggal Invoice</label>
                    <div class="input-group date reservationdate reservationdate1" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate1" data-toggle="datetimepicker" name="tanggal_invoice" id="tanggal_invoice" />
                      <div class="input-group-append" data-target=".reservationdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nama">PPh %</label>
                        <input type="text" class="form-control" id="pph" name="pph" placeholder="Input PPh">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nama">PPn %</label>
                        <input type="text" class="form-control" id="ppn" name="ppn" placeholder="Input PPn">
                      </div>
                    </div>
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
    table.page.len(-1).draw();
    var searchIDs = $("#tbl-invoice input:checkbox:checked").map(function() {
      return $(this).val();
    }).get();

    if (searchIDs != "") {
      $('[name="id_project_invoice"]').val(searchIDs);
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

  $(function() {
    $('.select-row').click(function() {
      var backgroundColor = $(this).is(":checked") ? "#fff000;" : "";
      $(this).closest('tr').attr('style', 'background-color: ' + backgroundColor + '');
      // var numberNotChecked = $("input[name='id[]']:checked").length;
      // $('#total_selected').html(numberNotChecked);
    });
  });


    $("input[name='id[]']").click(function() {
      var table = $("#tbl-invoice").DataTable();
      var countchecked = table
        .rows()
        .nodes()
        .to$() // Convert to a jQuery object
        .find("input[name='id[]']:checked").length;
        $('#total_selected').html(countchecked);
    });


  $('#form_generate_invoice').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_generate_invoice')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_generate_invoice',
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
            text: "Invoice berhasil digenerate.",
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