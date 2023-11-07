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
        td {
            border: 1px solid #111;
            
        }
        td{
            padding-top: 0px;
            padding-bottom: 0px;
        }
    </style>
</head>

<body>
    <img src="https://rms.rajawalisampit.com/assets/rms/dist/img/kop.png" style="width: 100%;">
    <h1 style="text-align:center;font-size:22px;margin-top:20px;">INVOICE</h1>

    <div style="margin-top:30px;">
        <div style="display: inline-table; width:20%;vertical-align:top;">
            <label style="vertical-align:top;">Invoice No</label>
        </div>
        <div style="display: inline-table; width:2%;">
            <label style="vertical-align:top;">:</label>
        </div>
        <div style="display: inline-table;">
            <label style="vertical-align:top;"><?php echo $invoice->no_invoice; ?></label>
        </div>
    </div>
    <div style="margin-top:10px;">
        <div style="display: inline-table; width:20%; vertical-align:top;">
            <label style=" vertical-align:top; vertical-align:top;">Re</label>
        </div>
        <div style="display: inline-table; width:2%; vertical-align:top;">
            <label style="vertical-align:top;">:</label>
        </div>
        <div style="display: inline-table; width:50%; vertical-align:top;">
            <label style="vertical-align:top;"><?php echo $invoice->remark; ?></label>
        </div>
    </div>
    <div style="margin-top:10px;">
        <div style="display: inline-table; width:20%; vertical-align:top;">
            <label style="vertical-align:top;">To</label>
        </div>
        <div style="display: inline-table; width:2%; vertical-align:top;">
            <label style="vertical-align:top;">:</label>
        </div>
        <div style="display: inline-table; width:50%; vertical-align:top;">
            <label style="vertical-align:top;"><?php echo $invoice->nama_perusahaan; ?><br><?php echo $invoice->alamat; ?></label>
        </div>
    </div>
    <table class="table table-hover" style="width:100%; margin-top:50px;">
        <thead style="background-color: #EEE;">
            <tr style="border: 1px solid #111;">
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:5%;">No</th>
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:10%;">No DO</th>
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:35%;">Description</th>
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:5%;">Qty</th>
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:20%;">Unit Price (IDR)</th>
                <th style="border: 1px solid #111;text-align:left; padding-bottom:10px; width:25%;">Total Amount (IDR)</th>
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
                    <td><?php echo $row->no_do; ?></td>
                    <td><?php echo $row->deskripsi; ?></td>
                    <td><?php echo $row->qty; ?></td>
                    <td>Rp <?php echo number_format($row->harga_unit, 0, "", "."); ?></td>
                    <td>Rp <?php echo number_format($row->total, 0, "", "."); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Potongan Claim Susut</td>
                    <td></td>
                    <td>Rp <?php echo number_format($row->total_biaya_susut, 0, "", "."); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" colspan="4"></td>
                <td style="text-align:right;">Total</td>
                <td>Rp <?php echo number_format($invoice->total, 0, "", "."); ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" colspan="4"></td>
                <td style="text-align:right;">PPh <?php echo $invoice->$pph; ?> %</td>
                <td>Rp <?php echo number_format($invoice->total_pph, 0, "", "."); ?></td>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" colspan="4"></td>
                <td style="text-align:right;">PPn <?php echo $invoice->$ppn; ?> %</td>
                <td>Rp <?php echo number_format($invoice->total_ppn, 0, "", "."); ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align:right;" colspan="4"></td>
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