<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kwitansi Supir</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kwitansi Supir</li>
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
              <h3 class="card-title">Kwitansi Supir</h3>
              <div class="card-tools mr-1">
              </div>
            </div>
            <div class="card-body">
              <form class="form-horizontal" id="form_kwitansi_supir" method="get" enctype="multipart/form-data">
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
                      <label>Pilih Truck</label>
                      <select class="form-control select2" style="width: 100%;" name="truck" id="truck">
                        <option value="0">Pilih truk</option>
                        <?php foreach ($truck as $row) : ?>
                          <option value="<?php echo $row->id; ?>"><?php echo $row->nopol; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-warning">Generate Kwitansi</button>
                  <div class="loading" style="display: none;">
                    <img src="<?php echo base_url(); ?>assets/rms/dist/img/ajax-loader.gif" />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
  $('#form_kwitansi_supir').on('submit', function(event) {
    var bulan = $('#bulan').val();
    var tahun = $('#tahun').val();
    var truck = $('#truck').val();
    event.preventDefault();
    var formData = new FormData($('#form_kwitansi_supir')[0]);
    $('.loading').show();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>rms/cek_kwitansi_supir/',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('.loading').hide();
        obj = JSON.parse(data);
        if (obj.status == "TRUE") {
          $('#form_kwitansi_supir')[0].reset();
          window.open('<?php echo base_url(); ?>rms/print_kwitansi_transporter_periode/' + bulan + '/' + tahun + '/' + truck, '_blank');
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
</script>