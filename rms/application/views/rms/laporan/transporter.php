<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Laporan Transporter</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Laporan Transporter</li>
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
              <h3 class="card-title">Laporan Transporter</h3>
              <div class="card-tools mr-1">
              </div>
            </div>
            <div class="card-body">
              <form class="form-horizontal" action="<?php echo base_url(); ?>laporan/transporter/" method="get" enctype="multipart/form-data">
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
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Generate laporan</button>
                  <div class="loading" style="display: none;">
                    <img src="<?php echo base_url(); ?>assets/rms/dist/img/ajax-loader.gif" />
                  </div>
                </div>
              </form>
              <?php if (!empty($_GET)) { ?>
                <hr class=" mt-4">
                <h2 class="text-center mt-4" style="font-weight: bold;">Laporan Transporter Periode <?php echo bulan($_GET['bulan']); ?> <?php echo $_GET['tahun']; ?></h2>
                <div class="row mt-4">
                  <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                      <div class="inner">
                        <h3>Rp <?php echo number_format($total->total_pemasukan, 0, "", "."); ?></h3>
                        <p>Gross profit</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-ios-checkmark-outline"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3>Rp <?php echo number_format($total->total_premi_supir, 0, "", "."); ?></h3>
                        <p>Beban Premi Supir</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-ios-checkmark-outline"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3>Rp <?php echo number_format($total->total_biaya_perbaikan, 0, "", "."); ?></h3>
                        <p>Beban Perbaikan</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-ios-checkmark-outline"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3>Rp <?php echo number_format($total->total_cicilan, 0, "", "."); ?></h3>
                        <p>Beban Cicilan</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-ios-checkmark-outline"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>Rp <?php echo number_format($total->total_bersih, 0, "", "."); ?></h3>
                        <p>Net Profit</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-ios-checkmark-outline"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>


                <table class="table table-bordered table-striped data-table">
                  <thead>
                    <tr>
                      <th>Nopol</th>
                      <th>Supir</th>
                      <th>Periode</th>
                      <th>Gross profit</th>
                      <th>Beban Operasional</th>
                      <th>Beban Premi Supir</th>
                      <th>Beban Perbaikan</th>
                      <th>Beban Cicilan</th>
                      <th>Net Profit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($laporan as $row) : ?>
                      <tr>
                        <td><?php echo $row->nopol; ?></td>
                        <td><?php echo $row->nama_supir; ?></td>
                        <td><?php echo bulan($row->periode_bulan); ?> <?php echo $row->periode_tahun; ?></td>
                        <td>Rp <?php echo number_format($row->grand_total, 0, "", "."); ?></td>
                        <td>Rp <?php echo number_format($row->operasional, 0, "", "."); ?></td>
                        <td>Rp <?php echo number_format($row->premi_supir, 0, "", "."); ?></td>
                        <td>Rp <?php echo number_format($row->total_perbaikan, 0, "", "."); ?></td>
                        <td>Rp <?php echo number_format($row->cicilan, 0, "", "."); ?></td>
                        <td>Rp <?php echo number_format($row->total_keuntungan, 0, "", "."); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3" class="text-right">Total : </td>
                      <td>Rp <?php echo number_format($total->total_pemasukan, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($total->total_operasional, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($total->total_premi_supir, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($total->total_biaya_perbaikan, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($total->total_cicilan, 0, "", "."); ?></td>
                      <td>Rp <?php echo number_format($total->total_bersih, 0, "", "."); ?></td>
                    </tr>
                  </tfoot>
                </table>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>