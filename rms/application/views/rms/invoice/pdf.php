<!DOCTYPE html>
<html>

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Create PDF from View in CodeIgniter Example</title>
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
        td,th {
            border: 1px solid #111;
            padding: 0px;
            border-spacing: 0px;
            padding-top: 2px !important;
            padding-bottom: 2px !important;
            border-spacing:0;
        }
    </style>
</head>

<body>
    <img src="https://rms.rajawalisampit.com/assets/rms/dist/img/kop.png" style="width: 100%;">
    <h1 style="text-align:center;font-size:22px;margin-top:30px;">INVOICE</h1>

    <div style="margin-top:30px;">
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
    <div style="margin-top:5px;">
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
        <div style="margin-top:5px;">
            <div style="display: inline-table; width:20%; vertical-align:top;">
                <label style=" vertical-align:top; vertical-align:top;">RE</label>
            </div>
            <div style="display: inline-table; width:2%; vertical-align:top;">
                <label style="vertical-align:top;">:</label>
            </div>
            <div style="display: inline-table; width:50%; vertical-align:top;">
                <label style="vertical-align:top;"><?php echo $invoice->remark; ?></label>
            </div>
        </div>
    <?php } ?>

    <?php if ($invoice->no_kontrak) { ?>
        <div style="margin-top:5px;">
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

    <?php if ($invoice->id_komoditas == '2' || $invoice->id_komoditas == '4') { ?>
        <div style="margin-top:5px;">
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

    <table class="table table-hover" cellpadding="0" style="width:100%; margin-top:20px; cell-margin:0px; border-spacing:0;">
        <thead style="background-color: #EEE;">
            <tr style="border: 1px solid #111;">
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:5%;">No</th>
                <?php if ($invoice->id_komoditas == '1') { ?>
                    <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:10%;">NO. STO</th>
                    <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:10%;">NO. DO</th>
                <?php } else { ?>
                    <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:10%;">DESC</th>
                <?php } ?>
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:10%;">QTY</th>
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:10%;">HARGA</th>
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:20%;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $no = 0;
            foreach ($project as $row) :
                $no++;
            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <?php if ($invoice->id_komoditas == '1') { ?>
                        <td><?php echo $row->no_sto; ?></td>
                        <td><?php echo $row->no_do; ?></td>
                    <?php } else { ?>
                        <td><?php echo $row->deskripsi; ?></td>
                    <?php } ?>
                    <td><?php echo number_format($row->qty, 0, "", "."); ?> KG</td>
                    <td>Rp <?php echo number_format($row->harga_unit, 0, "", "."); ?></td>
                    <td>Rp <?php echo number_format($row->total, 0, "", "."); ?></td>
                </tr>
                <?php if ($invoice->id_komoditas != '2') { ?>
                <tr>
                    <td></td>
                    <?php if ($invoice->id_komoditas == '1') { ?>
                        <td colspan="3">Potongan Claim Susut</td>
                    <?php } else { ?>
                        <td colspan="2">Potongan Claim Susut</td>
                    <?php } ?>

                    <td></td>
                    <td>Rp <?php echo number_format($row->total_biaya_susut, 0, "", "."); ?></td>
                </tr>
                <?php } ?>
            <?php endforeach; ?>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" <?php if ($invoice->id_komoditas == '1') { ?> colspan="4" <?php } else { ?> colspan="3" <?php } ?>></td>
                <td style="text-align:right;">Total</td>
                <td>Rp <?php echo number_format($invoice->total, 0, "", "."); ?></td>
            </tr>
            <?php if($invoice->$total_pph !='0'){ ?>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" <?php if ($invoice->id_komoditas == '1') { ?> colspan="4" <?php } else { ?> colspan="3" <?php } ?>></td>
                <td style="text-align:right;">PPh <?php echo $invoice->$pph; ?> %</td>
                <td>Rp <?php echo number_format($invoice->total_pph, 0, "", "."); ?></td>
            </tr>
            <?php } ?>
            <?php if($invoice->$total_ppn !='0'){ ?>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" <?php if ($invoice->id_komoditas == '1') { ?> colspan="4" <?php } else { ?> colspan="3" <?php } ?>></td>
                <td style="text-align:right;">PPn <?php echo $invoice->$ppn; ?> %</td>
                <td>Rp <?php echo number_format($invoice->total_ppn, 0, "", "."); ?></td>
            </tr>
            <?php } ?>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" <?php if ($invoice->id_komoditas == '1') { ?> colspan="4" <?php } else { ?> colspan="3" <?php } ?>></td>
                <td style="text-align:right;">Grand Total</td>
                <td>Rp <?php echo number_format($invoice->grand_total, 0, "", "."); ?></td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top:10px;">
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
    <div style="margin-top:10px;">
        <div style="display: inline-table; width:20%; vertical-align:top;">
            <label style=" vertical-align:top; vertical-align:top;">Total Tagihan</label>
        </div>
        <div style="display: inline-table; width:2%; vertical-align:top;">
            <label style="vertical-align:top;">:</label>
        </div>
        <div style="display: inline-table; width:50%; vertical-align:top;">
            <label style="vertical-align:top;"><?php echo ucwords(terbilang($invoice->grand_total)); ?></label>
        </div>
    </div>
    <div style="margin-top:10px;">
        <div style="display: inline-table; width:50%;">
            Seluruh pembayaran dapat dilakukan melalue transfer ke :
        </div>
    </div>
    <div style="margin-top:10px;">
        <div style="display: inline-table; width:50%;">
            Bank Mandiri Kantor Cabang Sampit
        </div>
    </div>

    <div style="margin-top:10px;">
        <div style="display: inline-table; width:20%; vertical-align:top;">
            <label style=" vertical-align:top;">No Rekening</label>
        </div>
        <div style="display: inline-table; width:2%; vertical-align:top;">
            <label style="vertical-align:top;">:</label>
        </div>
        <div style="display: inline-table; width:50%; vertical-align:top;">
            <label style="vertical-align:top;">1590-0015-77849</label>
        </div>
    </div>
    <div style="margin-top:10px;">
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

    <div style="display: flex;">
        <div style="margin-left: auto; width:300px; text-align:center;">
            Sampit, <?php echo shortdate_indo(date("Y-m-d")); ?><br>
            Diajukan Oleh<br>
            <b>CV. RAJA WALI SAMPIT</b><br><br><br><br><br><br>
            <b><u>Abdullah</u></b><br>
            <i>Direktur</i>
        </div>
    </div>
</body>

</html>