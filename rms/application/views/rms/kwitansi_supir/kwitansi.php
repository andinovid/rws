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
              <h3 class="card-title">Data Kwitansi</h3>
              <div class="card-tools mr-1">
                
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped" id="tbl_replas">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nopol</th>
                    <th>Supir</th>
                    <th>Tgl Input</th>
                    <th>Untuk Periode</th>
                    <th>Jumlah Replas</th>
                    <th>Total</th>
                    <th>Total Claim</th>
                    <th>Uang Sangu</th>
                    <th>Total PPh</th>
                    <th>Grand Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($kwitansi as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->nopol; ?></td>
                      <td><?php echo $row->nama_supir; ?></td>
                      <td><?php echo shortdate_indo($row->tanggal_input); ?></td>
                      <td><?php echo bulan($row->periode_bulan) . ' ' . $row->periode_tahun; ?></td>
                      <td><?php echo $row->total_replas; ?></td>
                      <td>Rp <?php echo number_format($row->total_kotor_replas, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->total_claim, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->uang_sangu, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->total_pph, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($row->grand_total_transporter, 0, "", "."); ?></td>
                      <td class="project-actions text-right">
                        
                        <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>rms/print_kwitansi_transporter/<?php echo $row->id_kwitansi; ?>" data-toggle="tooltip" data-placement="top" title="Cetak Kwitansi">
                          <i class="fas fa-print">
                          </i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="delete_kwitansi(<?php echo $row->id_kwitansi; ?>)" data-toggle="tooltip" data-placement="top" title="Hapus">
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
  </section>
</div>

<div class="modal fade" id="bayar-replas">
  <div class="modal-dialog modal-md">
    <form id="form_bayar_replas" class="form-horizontal" method="post" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pembayaran Replas</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="hidden" class="form-control" name="id" id="id">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="tanggal_pembayaran">Nomor Kwitansi</label>
                      <input type="text" class="form-control" name="nomor_kwitansi" id="nomor_kwitansi" disabled>
                    </div>
                    <div class="form-group">
                      <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                      <div class="input-group date reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate" data-toggle="datetimepicker" name="tanggal_pembayaran" id="tanggal_pembayaran" />
                        <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="justify-content: flex-start;">
          <button type="submit" class="btn btn-primary m-0">Bayar Replas</button>
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
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
  $(function() {

    const date = new Date();

    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    // This arrangement can be altered based on how we want the date's format to appear.
    let currentDate = `${day}-${month}-${year}`;
    $('#reservation').daterangepicker();
    var table = $("#tbl_replas").DataTable({
      "ordering": false,
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "pageLength": 20,
      "buttons": [{
          extend: 'pdfHtml5',
          footer: true,
          title: "Laporan Replas " + currentDate,
          exportOptions: {
            columns: [3, 6, 7]
          },
          customize: function(doc) {
            doc.content[1].table.widths = ['33%', '33%', '33%'];
            doc.styles.tableBodyEven.alignment = 'left';
            doc.styles.tableBodyOdd.alignment = 'left';
            doc.styles.tableFooter.alignment = 'left';
            doc.styles.tableHeader.alignment = 'left';
          }
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: ':visible'
          }
        },
        "colvis"
      ],
      "footerCallback": function(row, data, start, end, display) {
        var api = this.api(),
          data;

        // Remove the formatting to get integer data for summation
        var intVal = function(i) {
          return typeof i === 'string' ?
            i.replace(/[\$,]/g, '') * 1 :
            typeof i === 'number' ?
            i : 0;
        };

        // Total over all pages
        total = api
          .column(7)
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Total over this page
        pageTotal = api
          .column(8, {
            page: 'current'
          })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);


        // Total filtered rows on the selected column (code part added)
        var sumCol4Filtered = display.map(el => data[el][4]).reduce((a, b) => intVal(a) + intVal(b), 0);

        // Update footer
        $(api.column(7).footer()).html('Rp ' + $.number(pageTotal).replace(/\,/g, '.'));
      }
    }).buttons().container().appendTo('#tbl_replas_wrapper .col-md-6:eq(0)');
  });

  function filterData() {
    date = $("#date-filter").val();
    filter = date.substr(0, 10);
    startdate = date.substring(0, 10);
    enddate = date.substring(13, 23);

    $.fn.dataTable.ext.search.push(
      function(settings, data, dataIndex) {
        var min = startdate;
        var max = enddate;
        var createdAt = data[1];

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





  function bayar_kwitansi(id) {
    $("#bayar-replas").modal('show');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/get_kwitansi",
      type: "POST",
      data: {
        'id': id
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_bayar_replas')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('#nomor_kwitansi').val(data[i].no_kwitansi);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  $('#form_bayar_replas').on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#form_bayar_replas')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/save_pembayaran_kwitansi/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#form_bayar_replas')[0].reset();
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

  function delete_kwitansi(id) {
    Swal.fire({
      title: 'Hapus data?',
      text: "Data yang telah dihapus tidak dapat dikembalikan.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url() ?>rms/delete_kwitansi_transporter",
          type: "POST",
          data: {
            id: id,
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