<!DOCTYPE html>
<html>

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>INVOICE <?php echo $invoice->no_invoice; ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

    <style>
        html {
            font-family: sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%
        }

        @page { margin: 10px 20px; }

        body {
            margin: 0 auto;
            width: 95%;
            padding: 0;
            font-size: 11px;
            line-height: 1.2em;
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
    <div style="text-align: center;">
    <img src="https://rms.rajawalisampit.com/assets/rms/dist/img/kop.png" style="width: 90%;">
    </div>
    <h1 style="text-align:center;font-size:22px;margin-top:10px;">INVOICE</h1>

    <div style="margin-top:20px;">
        <div style="display: inline-table; width:20%;vertical-align:top;">
            <label style="vertical-align:top;">NO. INVOICE</label>
        </div>
        <div style="display: inline-table; width:2%;">
            <label style="vertical-align:top;">:</label>
        </div>
        <div style="display: inline-table;">
            <label style="vertical-align:top;"><?php echo $invoice->no_invoice; ?></label>
        </div>
    </div>
    <div>
        <div style="display: inline-table; width:20%; vertical-align:top;">
            <label style="vertical-align:top;">KEPADA YTH.</label>
        </div>
        <div style="display: inline-table; width:2%; vertical-align:top;">
            <label style="vertical-align:top;">:</label>
        </div>
        <div style="display: inline-table; width:50%; vertical-align:top;">
            <label style="vertical-align:top;"><?php echo $invoice->nama_perusahaan; ?><br><span style="font-weight: 400;"><?php echo $invoice->alamat; ?></span></label>
        </div>
    </div>
    <?php if ($invoice->remark) { ?>
        <div>
            <div style="display: inline-table; width:20%; vertical-align:top;">
                <label style=" vertical-align:top; vertical-align:top;">RE</label>
            </div>
            <div style="display: inline-table; width:2%; vertical-align:top;">
                <label style="vertical-align:top;">:</label>
            </div>
            <div style="display: inline-table; width:70%; vertical-align:top;">
                <label style="vertical-align:top;"><?php echo $invoice->remark; ?></label>
            </div>
        </div>
    <?php } ?>

    <?php if ($invoice->no_kontrak AND $invoice->id_klien != '6') { ?>
        <div>
            <div style="display: inline-table; width:20%;vertical-align:top;">
                <label style="vertical-align:top;">NO. KONTRAK</label>
            </div>
            <div style="display: inline-table; width:2%;vertical-align:top;">
                <label style="vertical-align:top;">:</label>
            </div>
            <div style="display: inline-table; vertical-align:top;">
                <label style="vertical-align:top;">
                    <?php foreach ($project as $do) : ?>
                        <?php echo $do->no_kontrak; ?><br>
                    <?php endforeach; ?>
                </label>
            </div>
        </div>
    <?php } ?>

    <?php if ($invoice->id_komoditas == '2' || $invoice->id_komoditas == '4' || ($invoice->id_komoditas == '3' and $invoice->id_klien == '1') || $invoice->id_klien == '6') { ?>
        <div>
            <div style="display: inline-table; width:20%;vertical-align:top;">
                <label style="vertical-align:top;">NO. DO</label>
            </div>
            <div style="display: inline-table; width:2%;vertical-align:top;">
                <label style="vertical-align:top;">:</label>
            </div>
            <div style="display: inline-table;vertical-align:top;">
                <label style="vertical-align:top;">
                    <?php foreach ($project as $do) : ?>
                        <?php echo $do->no_do; ?><br>
                    <?php endforeach; ?>
                </label>
            </div>
        </div>
    <?php } ?>

    <table class="table table-hover" cellpadding="0" style="width:100%; margin-top:10px; cell-margin:0px; border-spacing:0;">
        <thead style="background-color: #EEE;">
            <tr style="border: 1px solid #111;">
                <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:3%;">No</th>
                <?php if ($invoice->id_komoditas == '1') { ?>
                    <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:10%;">NO. STO</th>
                    <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:10%;">NO. DO</th>
                <?php } else { ?>
                    <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:40%;">DESC</th>
                <?php } ?>
                <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:10%;">QTY</th>
                <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:10%;">HARGA</th>
                <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:12%;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $no = 0;
            foreach ($project as $row) :
                $no++;
            ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no; ?></td>
                    <?php if ($invoice->id_komoditas == '1') { ?>
                        <td style="text-align: center;"><?php echo $row->no_sto; ?></td>
                        <td style="text-align: center;"><?php echo $row->no_do; ?></td>
                    <?php } else { ?>
                        <td><?php echo $row->deskripsi; ?></td>
                    <?php } ?>
                    <?php if ($invoice->id_komoditas == '2' and ($invoice->id_klien == '4' || $invoice->id_klien == '5' || $invoice->id_klien == '9' || $invoice->id_klien == '10' || $invoice->id_klien == '16' || $invoice->id_klien == '8')) { ?>
                        <td style="text-align: center;"><?php echo number_format($row->total_qty_akhir, 0, "", "."); ?> KG</td>
                    <?php } elseif ($invoice->id_komoditas == '2' and $invoice->id_klien == '7') { ?>
                        <td style="text-align: center;"><?php echo number_format($row->total_qty_awal, 0, "", "."); ?> KG</td>
                    <?php } elseif (($invoice->id_komoditas == '3' and ($invoice->id_klien == '6' || $invoice->id_klien == '14')) || $invoice->id_komoditas == '4') { ?>
                        <td style="text-align: center;"><?php echo number_format($row->total_qty_terendah, 0, "", "."); ?> KG</td>
                    <?php } elseif (($invoice->id_komoditas == '3' and $invoice->id_klien == '1')) { ?>
                        <td style="text-align: center;"><?php echo number_format($row->qty, 0, "", "."); ?> KG</td>
                    <?php } else { ?>
                        <td style="text-align: center;"><?php echo number_format($row->qty, 0, "", "."); ?> KG</td>
                    <?php } ?>
                    <td style="text-align: center;">Rp <?php echo number_format($row->harga_unit, 0, "", "."); ?></td>
                    <td style="text-align: center;">Rp <?php echo number_format($row->total, 0, "", "."); ?></td>
                </tr>
                <?php if ($invoice->id_komoditas != '2' AND $invoice->id_komoditas != '1') { ?>
                    <tr>
                        <td></td>
                        <?php if ($invoice->id_komoditas == '1') { ?>
                            <td colspan="3">Potongan Claim Susut</td>
                        <?php } else { ?>
                            <td colspan="2">Potongan Claim Susut</td>
                        <?php } ?>

                        <td></td>
                        <td style="text-align: center;">Rp <?php echo number_format($row->total_biaya_susut, 0, "", "."); ?></td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" <?php if ($invoice->id_komoditas == '1') { ?> colspan="4" <?php } else { ?> colspan="3" <?php } ?>></td>
                <td style="text-align:right;">Total</td>
                <td style="text-align: center;">Rp <?php echo number_format($invoice->total, 0, "", "."); ?></td>
            </tr>
            <?php if ($invoice->total_pph != '0') { ?>
                <tr style="border: none;">
                    <td style="border: none; text-align:right;" <?php if ($invoice->id_komoditas == '1') { ?> colspan="4" <?php } else { ?> colspan="3" <?php } ?>></td>
                    <td style="text-align:right;">PPh <?php echo $invoice->pph; ?> %</td>
                    <td style="text-align: center;">Rp <?php echo number_format($invoice->total_pph, 0, "", "."); ?></td>
                </tr>
            <?php } ?>
            <?php if ($invoice->total_ppn != '0') { ?>
                <tr style="border: none;">
                    <td style="border: none; text-align:right;" <?php if ($invoice->id_komoditas == '1') { ?> colspan="4" <?php } else { ?> colspan="3" <?php } ?>></td>
                    <td style="text-align:right;">PPn <?php echo $invoice->ppn; ?> %</td>
                    <td style="text-align: center;">Rp <?php echo number_format($invoice->total_ppn, 0, "", "."); ?></td>
                </tr>
            <?php } ?>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" <?php if ($invoice->id_komoditas == '1') { ?> colspan="4" <?php } else { ?> colspan="3" <?php } ?>></td>
                <td style="text-align:right;">Grand Total</td>
                <td style="text-align: center;">Rp <?php echo number_format($invoice->grand_total, 0, "", "."); ?></td>
            </tr>
        </tbody>
    </table>
    <div>
        <div style="display: inline-table; width:20%; vertical-align:top;">
            <label style=" vertical-align:top; vertical-align:top;">Total Tagihan</label>
        </div>
        <div style="display: inline-table; width:2%; vertical-align:top;">
            <label style="vertical-align:top;">:</label>
        </div>
        <div style="display: inline-table; width:50%; vertical-align:top;">
            <label style="vertical-align:top;">Rp <?php echo number_format($invoice->grand_total, 0, "", "."); ?></label>
        </div>
    </div>
    <div>
        <div style="display: inline-table; width:20%; vertical-align:top;">
            <label style=" vertical-align:top; vertical-align:top;">Terbilang</label>
        </div>
        <div style="display: inline-table; width:2%; vertical-align:top;">
            <label style="vertical-align:top;">:</label>
        </div>
        <div style="display: inline-table; width:50%; vertical-align:top;">
            <label style="vertical-align:top;"><?php echo ucwords(terbilang(number_format($invoice->grand_total, 0, "", ""))); ?> Rupiah</label>
        </div>
    </div>
    <div>
        <div style="display: inline-table; width:50%;">
            Seluruh pembayaran dapat dilakukan melalui transfer ke :
        </div>
    </div>
    <?php if ($invoice->id_klien == "2" || $invoice->id_klien == "3" || $invoice->id_klien == "6" || $invoice->id_klien == "4" || $invoice->id_klien == "1") { ?>
        <div>
            <div style="display: inline-table; width:50%;">
                Bank Mandiri Kantor Cabang Sampit
            </div>
        </div>
        <div style="margin-top:5px;">
            <div style="display: inline-table; width:20%; vertical-align:top;">
                <label style=" vertical-align:top;">No Rekening</label>
            </div>
            <div style="display: inline-table; width:2%; vertical-align:top;">
                <label style="vertical-align:top;">:</label>
            </div>
            <div style="display: inline-table; width:50%; vertical-align:top;">
                <label style="vertical-align:top;">159-00-0157784-9</label>
            </div>
        </div>
        <div>
            <div style="display: inline-table; width:20%; vertical-align:top;">
                <label style=" vertical-align:top; vertical-align:top;">Atas Nama</label>
            </div>
            <div style="display: inline-table; width:2%; vertical-align:top;">
                <label style="vertical-align:top;">:</label>
            </div>
            <div style="display: inline-table; width:50%; vertical-align:top;">
                <label style="vertical-align:top;">CV. RAJA WALI SAMPIT</label>
            </div>
        </div>
    <?php } else { ?>
        <div>
            <div style="display: inline-table; width:50%;">
                Bank BRI Kantor Cabang Sampit
            </div>
        </div>
        <div>
            <div style="display: inline-table; width:20%; vertical-align:top;">
                <label style=" vertical-align:top;">No Rekening</label>
            </div>
            <div style="display: inline-table; width:2%; vertical-align:top;">
                <label style="vertical-align:top;">:</label>
            </div>
            <div style="display: inline-table; width:50%; vertical-align:top;">
                <label style="vertical-align:top;">0163-01-001828-30-8</label>
            </div>
        </div>
        <div>
            <div style="display: inline-table; width:20%; vertical-align:top;">
                <label style=" vertical-align:top; vertical-align:top;">Atas Nama</label>
            </div>
            <div style="display: inline-table; width:2%; vertical-align:top;">
                <label style="vertical-align:top;">:</label>
            </div>
            <div style="display: inline-table; width:50%; vertical-align:top;">
                <label style="vertical-align:top;">CV. RAJA WALI SAMPIT</label>
            </div>
        </div>
    <?php } ?>

    <div style="display: flex;">
        <div style="margin-left: auto; width:300px; text-align:center;">
            Sampit, <?php echo shortdate_indo($invoice->tanggal_invoice); ?><br>
            Diajukan Oleh<br>
            <b>CV. RAJA WALI SAMPIT</b><br><br><br><br><br><br>
            <b><u>ABDULLAH</u></b><br>
            <i>Direktur</i>
        </div>
    </div>
</body>

</html>