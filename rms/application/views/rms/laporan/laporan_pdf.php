<!DOCTYPE html>
<html>

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>LAPORAN LABA RUGI PERIODE <?php echo bulan($bulan); ?> <?php echo $tahun; ?></title>
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

        .grid-laporan {
            margin: 0px;
            padding: 0px;
            list-style: none;
        }

        .grid-laporan ul {
            padding-left: 25px;
            width: 100%;
        }

        .grid-laporan h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 0px;
        }


        .grid-laporan li {
            margin-bottom: 5px;
            clear: both;
            width: 100%;
        }

        .d-flex {
            display: flex !important;
        }

        .mr-auto {
            margin-right: auto !important;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
            text-align: right;
        }
    </style>
</head>

<body>
    <img src="<?php echo base_url(); ?>assets/rms/dist/img/kop.png" style="width: 100%;">
    <hr class=" mt-4">
    <h2 class="text-center mt-4" style="font-weight: bold;">Laporan Laba Rugi <br>CV Raja Wali Sampit Periode <?php echo $bulan; ?> <?php echo $tahun; ?></h2>
    <div style="width: 70%; margin:0 auto">
        <ul class="grid-laporan">
            <li>
                <h3>Pendapatan Usaha Komoditas</h3>
            </li>
            <ul>
                <li>
                    <div class="mr-auto">Gross Profit</div>
                    <div style="font-size: 18px;"><b>Rp <?php echo number_format($komoditas->total_pemasukan, 0, "", "."); ?></b></div>
                </li>
            </ul>
            <li>
                <h3>Pengeluaran Usaha Komoditas</h3>
            </li>
            <ul>
                <li>
                    <div class="float-left">Beban Replas</div>
                    <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_pengeluaran_replas, 0, "", "."); ?></div>
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
    </div>
</body>

</html>