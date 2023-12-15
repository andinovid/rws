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
    <h1 style="text-align:center;font-size:22px;margin-top:30px;font-family: sans-serif !important; text-transform:uppercase;">Laporan Replas <?php echo $periode; ?></h1>
    <table class="table" cellpadding="0" style="width:100%; margin-top:20px; cell-margin:0px; border-spacing:0;">
        <thead style="background-color: #061E45; color:#FFF;">
            <tr style="border: 1px solid #111;">
                <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:20%;">GROUP</th>
                <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:10%;">JUMLAH</th>
                <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:50%;">TUJUAN</th>
                <th style="border: 1px solid #111;text-align:center; padding-bottom:10px; width:20%;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($replas as $row) :
                $item = $this->rms_model->get_by_query("SELECT kode_tujuan FROM v_generate_kwitansi WHERE id_kwitansi = '$row->id_kwitansi' ORDER BY tanggal_bongkar ASC")->result();
            ?>
                <tr>
                    <td><?php echo $row->vendor; ?></td>
                    <td><?php echo $row->total_replas; ?></td>
                    <td>
                        <?php
                        $i = 0;
                        $len = count($item);
                        foreach ($item as $item) :
                            if(++$i === $len) {
                                echo $item->kode_tujuan;
                            }else{
                                echo $item->kode_tujuan . ', ';
                            }
                            
                        endforeach;
                        ?>
                    </td>
                    <td>Rp <?php echo number_format($row->total_kotor_replas, 0, "", "."); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td><b>TOTAL</b></td>
                <td><b>Rp <?php echo number_format($total->total_biaya_replas, 0, "", "."); ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>