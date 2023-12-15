<!DOCTYPE html>
<html>

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>LAPORAN REPLAS <?php echo $periode; ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

    <style>
        html {
            font-family: sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%
        }

        body {
            margin: 0 auto;
            width: 95%;
            padding: 0;
            font-size: 11px;
        }

        tr,
        td,
        th {
            border: 1px solid #111;
            padding: 0px;
            border-spacing: 0px;
            padding-top: 2px !important;
            padding-bottom: 2px !important;
            border-spacing: 0;
        }
    </style>
</head>

<body>
    <img src="<?php echo base_url(); ?>assets/rms/dist/img/kop.png" style="width: 100%;">

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
                </ul>
            </ul>

            <hr>
            <ul class="grid-laporan">
                <li class="d-flex">
                    <h3 class="mr-auto">Total Net Profit Perusahaan</h3>
                    <div style="font-size: 24px; background-color:#0ccc48; color:#FFF;padding:0px 10px;border-radius:3px;"><b>Rp <?php echo number_format($total_net_profit, 0, "", "."); ?></b></div>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>