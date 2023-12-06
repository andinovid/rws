<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Laporan </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Laporan Pajak Replas</li>
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
              <h3 class="card-title">Laporan Pajak Replas</h3>
              <div class="card-tools mr-1">
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <form id="form_pajak_replas" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-2">
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
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Periode tahun</label>
                      <select class="form-control" style="width: 100%;" name="tahun" id="tahun">
                        <option value="">Pilih tahun</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Jenis Pajak</label>
                      <select class="form-control" style="width: 100%;" name="jenis" id="jenis">
                        <option value="">Pilih jenis pajak</option>
                        <option value="skb">SKB</option>
                        <option value="npwp">NPWP</option>
                        <option value="ktp">KTP</option>
                      </select>
                    </div>
                  </div>
                </div>


                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Generate laporan</button>
                  <div class="loading" style="display: none;">
                    <img src="<?php echo base_url(); ?>assets/rms/dist/img/ajax-loader.gif" />
                  </div>
                </div>
              </form>
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

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
  function input_keuangan() {
    $('#form_pajak_replas')[0].reset();
    $("#input-keuangan").modal('show');
  }

  $('#form_pajak_replas').on('submit', function(event) {
    var bulan = $('#bulan').val();
    var tahun = $('#tahun').val();
    var jenis = $('#jenis').val();
    event.preventDefault();
    var formData = new FormData($('#form_pajak_replas')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/cek_laporan_replas/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('.loading').hide();
        obj = JSON.parse(data);
        if (obj.status == "TRUE") {
          $('#form_pajak_replas')[0].reset();
          window.open('<?php echo base_url(); ?>rms/generate_laporan_replas/' + bulan + '/' + tahun + '/' + jenis, '_blank');
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Data tidak ditemukan!"
          });
        }
      }
    });
  });

  function edit(id) {
    $("#input-keuangan").modal('show');
    $('.modal-title').html('Edit keuangan');
    $('input[name=id]').val(id);
    $.ajax({
      url: "<?php echo base_url(); ?>rms/edit",
      type: "POST",
      data: {
        'id': id,
        tbl: "tbl_keuangan"
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#form_pajak_replas')[0].reset();
      },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          $('[name="jenis"]').val(data[i].jenis).change();
          $('[name="tanggal"]').val(data[i].tanggal);
          $('[name="jumlah"]').val($.number(data[i].jumlah).replace(/\,/g, '.').replace(/\-/g, ''));
          $('[name="keterangan"]').val(data[i].keterangan);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_keuangan(id) {
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
            tbl: "tbl_keuangan",
          },
          dataType: "JSON",
          success: function(data) {
            Swal.fire(
              'Deleted!',
              'Data has been deleted.',
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