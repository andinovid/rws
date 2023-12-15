<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Laporan Perusahaan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">laporan Perusahaan</li>
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
              <h3 class="card-title">laporan perusahaan</h3>
              <div class="card-tools mr-1">
              </div>
            </div>
            <div class="card-body">
              <form class="form-horizontal" action="<?php echo base_url(); ?>laporan/all" method="get" enctype="multipart/form-data">
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
                <h2 class="text-center mt-4" style="font-weight: bold;">Laporan Laba Rugi <br>CV Raja Wali Sampit Periode <?php echo bulan($_GET['bulan']); ?> <?php echo $_GET['tahun']; ?></h2>
                <div class="row justify-content-md-center mt-5 mb-5">
                  <div class="col-md-6">
                    <ul class="grid-laporan">
                      <li>
                        <h3>Pendapatan Usaha Komoditas</h3>
                      </li>
                      <ul>
                        <li class="d-flex">
                          <div class="mr-auto">Gross Profit</div>
                          <div style="font-size: 18px;"><b>Rp <?php echo number_format($komoditas->total_pemasukan, 0, "", "."); ?></b></div>
                        </li>
                      </ul>
                      <li>
                        <h3>Pengeluaran Usaha Komoditas</h3>
                      </li>
                      <ul>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Replas</div>
                          <div style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_pengeluaran_replas, 0, "", "."); ?></div>
                        </li>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Lapangan</div>
                          <div style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_pengeluaran_lapangan, 0, "", "."); ?></div>
                        </li>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Claim</div>
                          <div style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_biaya_claim, 0, "", "."); ?></div>
                        </li>
                        <li class="d-flex">
                          <div class="mr-auto">Beban PPh Invoice</div>
                          <div style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_potongan_pph, 0, "", "."); ?></div>
                        </li>
                        <li class="d-flex">
                          <div class="mr-auto">Beban PPh Replas</div>
                          <div style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_potongan_pph_replas, 0, "", "."); ?></div>
                        </li>
                      </ul>
                      <li class="d-flex">
                        <h3 class="mr-auto">Net Profit Usaha Komoditas</h3>
                        <div style="font-size: 18px;color:#0ccc48;"><b>Rp <?php echo number_format($komoditas->total_bersih, 0, "", "."); ?></b></div>
                      </li>
                    </ul>
                    <hr>
                    <ul class="grid-laporan">
                      <li>
                        <h3>Penghasilan Usaha Transporter</h3>
                      </li>
                      <ul>
                        <li class="d-flex">
                          <div class="mr-auto">Gross Profit</div>
                          <div style="font-size: 18px;"><b>Rp <?php echo number_format($transporter->total_pemasukan, 0, "", "."); ?></b></div>
                        </li>
                      </ul>
                      <li>
                        <h3>Pengeluaran Usaha Transporter</h3>
                      </li>
                      <ul>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Premi Supir</div>
                          <div style="color:#ff0000;">Rp <?php echo number_format($transporter->total_premi_supir, 0, "", "."); ?></div>
                        </li>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Operasional</div>
                          <div style="color:#ff0000;">Rp <?php echo number_format($transporter->total_operasional, 0, "", "."); ?></div>
                        </li>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Perbaikan</div>
                          <div style="color:#ff0000;">Rp <?php echo number_format($transporter->total_biaya_perbaikan, 0, "", "."); ?></div>
                        </li>
                      </ul>
                      <li class="d-flex">
                        <h3 class="mr-auto">Net Profit Usaha Transporter</h3>
                        <div style="font-size: 18px;color:#0ccc48;"><b>Rp <?php echo number_format($transporter->total_bersih, 0, "", "."); ?></b></div>
                      </li>
                    </ul>
                    <hr>

                    <ul class="grid-laporan">
                      <li>
                        <h3>Pengeluaran Operasional Kantor</h3>
                      </li>
                      <ul>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Operasional General</div>
                          <div>Rp <?php echo number_format($keuangan->operasional_kantor, 0, "", "."); ?></div>
                        </li>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Gaji Karyawan</div>
                          <div>Rp <?php echo number_format($keuangan->gaji_karyawan, 0, "", "."); ?></div>
                        </li>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Asuransi Karyawan</div>
                          <div>Rp <?php echo number_format($keuangan->asuransi_karyawan, 0, "", "."); ?></div>
                        </li>
                        <li class="d-flex">
                          <div class="mr-auto">Beban Atensi</div>
                          <div>Rp <?php echo number_format($keuangan->atensi, 0, "", "."); ?></div>
                        </li>
                      </ul>
                    </ul>

                    <hr>
                    <ul class="grid-laporan">
                      <li class="d-flex">
                        <h3 class="mr-auto">Total Net Profit Perusahaan</h3>
                        <div style="font-size: 24px; background-color:#0ccc48; color:#FFF;padding:0px 10px;border-radius:3px;"><b>Rp <?php echo number_format($total_net_profit, 0, "", "."); ?></b></div>
                      </li>
                    </ul>

                    <hr>
                    <div class="text-center mt-5">
                      <a href="<?php echo base_url(); ?>rms/download_laporan/<?php echo $bulan; ?>/<?php echo $tahun; ?>" class="btn btn-lg btn-primary"><i class="nav-icon fas fa-download"></i> Download Laporan</a>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>