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
        }

        .grid-laporan h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 0px;
            margin-top: 5px;
        }


        .grid-laporan li {
            margin-bottom: 5px;
            clear: both;
            font-size: 14px;
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

        .clearfix{
            clear: both;
        }
    </style>
</head>

<body>
    <img src="<?php echo base_url(); ?>assets/rms/dist/img/kop.png" style="width: 100%;">
    <hr>
    <h2 class="text-center mt-4" style="font-weight: 800; font-size:20px; text-transform:uppercase; line-height:1.5em">Laporan Laba Rugi CV Raja Wali Sampit <br>Periode <?php echo $bulan; ?> <?php echo $tahun; ?></h2>
    <hr>
    <ul class="grid-laporan">
        <li>
            <h3>Pendapatan Usaha Komoditas</h3>
        </li>
        <ul>
            <li>
                <div class="float-left">Gross Profit</div>
                <div class="float-right" style="font-size: 18px;"><b>Rp <?php echo number_format($komoditas->total_pemasukan, 0, "", "."); ?></b></div>
            </li>
            <li>
                <div class="float-left">Net Profit Komoditas Non DO</div>
                <div class="float-right" style="font-size: 18px;"><b>Rp <?php echo number_format($non_do->total_keuntungan, 0, "", "."); ?></b></div>
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
            <li>
                <div class="float-left">Beban Lapangan</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_pengeluaran_lapangan, 0, "", "."); ?></div>
            </li>
            <li>
                <div class="float-left">Beban Claim</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_biaya_claim, 0, "", "."); ?></div>
            </li>
            <li>
                <div class="float-left">Beban PPh Invoice</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_potongan_pph, 0, "", "."); ?></div>
            </li>
            <li>
                <div class="float-left">Beban PPh Replas</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($komoditas->total_potongan_pph_replas, 0, "", "."); ?></div>
            </li>
        </ul>
        <li>
            <h3 class="float-left">Net Profit Usaha Komoditas</h3>
            <div class="float-right" style="font-size: 18px;color:#0ccc48;"><b>Rp <?php echo number_format($total_komoditas, 0, "", "."); ?></b></div>
        </li>
    </ul>
    <div class="clearfix"></div>
    <hr style="margin-top: 20px;">
    <ul class="grid-laporan" style="margin-top: 20px;">
        <li>
            <h3>Penghasilan Usaha Transporter</h3>
        </li>
        <ul>
            <li>
                <div class="float-left">Gross Profit</div>
                <div class="float-right" style="font-size: 18px;"><b>Rp <?php echo number_format($transporter->total_pemasukan, 0, "", "."); ?></b></div>
            </li>
        </ul>
        <li>
            <h3>Pengeluaran Usaha Transporter</h3>
        </li>
        <ul>
            <li>
                <div class="float-left">Beban Premi Supir</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($transporter->total_premi_supir, 0, "", "."); ?></div>
            </li>
            <li>
                <div class="float-left">Beban Operasional</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($transporter->total_operasional, 0, "", "."); ?></div>
            </li>
            <li>
                <div class="float-left">Beban Perbaikan</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($transporter->total_biaya_perbaikan, 0, "", "."); ?></div>
            </li>
        </ul>
        <li>
            <h3 class="float-left">Net Profit Usaha Transporter</h3>
            <div class="float-right" style="font-size: 18px;color:#0ccc48;"><b>Rp <?php echo number_format($transporter->total_bersih, 0, "", "."); ?></b></div>
        </li>
    </ul>
    <div class="clearfix"></div>
    <hr style="margin-top: 20px;">
    <ul class="grid-laporan" style="margin-top: 20px;">
        <li>
            <h3>Pengeluaran Operasional Kantor</h3>
        </li>
        <ul>
            <li>
                <div class="float-left">Beban Operasional General</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($keuangan->operasional_kantor, 0, "", "."); ?></div>
            </li>
            <li>
                <div class="float-left">Beban Gaji Karyawan</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($keuangan->gaji_karyawan, 0, "", "."); ?></div>
            </li>
            <li>
                <div class="float-left">Beban Asuransi Karyawan</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($keuangan->asuransi_karyawan, 0, "", "."); ?></div>
            </li>
            <li>
                <div class="float-left">Beban Atensi</div>
                <div class="float-right" style="color:#ff0000;">Rp <?php echo number_format($keuangan->atensi, 0, "", "."); ?></div>
            </li>
        </ul>
    </ul>
    <div class="clearfix"></div>
    <hr style="margin-top: 20px;">
    <ul class="grid-laporan" style="margin-top: 20px;">
        <li>
            <h3 class="float-left">Total Net Profit Perusahaan</h3>
            <div class="float-right" style="font-size: 24px; background-color:#0ccc48; color:#FFF;padding:0px 10px;border-radius:3px;"><b>Rp <?php echo number_format($total_net_profit, 0, "", "."); ?></b></div>
        </li>
    </ul>
</body>

</html>