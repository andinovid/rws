SELECT
    `b`.`id` AS `id_rekap`,
    `a`.`id` AS `id_project`,
    `a`.`no_kontrak` AS `no_kontrak`,
    `a`.`no_sto` AS `no_sto`,
    `a`.`no_do` AS `no_do`,
    `b`.`no_po` AS `no_po`,
    `b`.`no_replas` AS `no_replas`,
    `b`.`no_tiket` AS `no_tiket`,
    `a`.`qty` AS `qty`,
    `a`.`harga_unit` AS `harga_unit`,
    `a`.`qty` * `a`.`harga_unit` AS `harga_total`,
    `b`.`toleransi_susut` AS `toleransi_susut`,
    `c`.`nama_perusahaan` AS `nama_perusahaan`,
    `b`.`tanggal_muat` AS `tanggal_muat`,
    `b`.`tanggal_bongkar` AS `tanggal_bongkar`,
    `b`.`id_supir` AS `id_supir`,
    `d`.`nama` AS `nama_supir`,
    `b`.`id_truck` AS `id_truck`,
    `e`.`nopol` AS `nopol`,
    `e`.`id_vendor` AS `id_vendor`,
    `e`.`kategori` AS `kategori_truck`,
    `b`.`id_vendor_pajak` AS `id_vendor_pajak`,
    `b`.`id_vendor_pencairan` AS `id_vendor_pencairan`,
    CASE WHEN `b`.`non_do_id_komoditas` = '0' || `b`.`non_do_id_komoditas` is NULL THEN
    `a`.`id_komoditas` ELSE `k`.`id`
    END AS `id_komoditas`,
    CASE WHEN `b`.`non_do_id_komoditas` = '0' || `b`.`non_do_id_komoditas` is NULL THEN
    `f`.`komoditas` 
    ELSE
    `k`.`komoditas` 
    END
    AS `komoditas`,
    `g`.`nama_tujuan` AS `nama_tujuan`,
    `g`.`kode_tujuan` AS `kode_tujuan`,
    `g`.`harga` AS `harga`,
    `b`.`bruto_awal` AS `bruto_awal`,
    `b`.`tarra_awal` AS `tarra_awal`,
    `b`.`bruto_akhir` AS `bruto_akhir`,
    `b`.`tarra_akhir` AS `tarra_akhir`,
    `b`.`qty_kirim_bag` AS `qty_kirim_bag`,
    `b`.`qty_kirim_kg` AS `qty_kirim_kg`,
    `b`.`timbang_gudang_bag` AS `timbang_gudang_bag`,
    `b`.`timbang_gudang_kg` AS `timbang_gudang_kg`,
    `b`.`timbang_kebun_bag` AS `timbang_kebun_bag`,
    `b`.`timbang_kebun_kg` AS `timbang_kebun_kg`,
    `a`.`claim` AS `claim_invoice`,

    LEAST(
        `b`.`qty_kirim_kg`,
        `b`.`timbang_kebun_kg`
    ) AS `qty_terendah`,

    LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`) * `a`.`harga_unit` AS `harga_qty_terendah`,

    `b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg` AS `m_susut`,

    CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > `b`.`toleransi_susut` THEN 
        ROUND(CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`, 2)
    ELSE 0 END AS `c_claim`,

    `a`.`claim_replas` AS `claim`,

    CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > `b`.`toleransi_susut` THEN
        (CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas` 
    ELSE 0 END AS `total_claim`,

    `b`.`uang_sangu` AS `uang_sangu`,
    `b`.`pinjaman` AS `pinjaman`,
    `h`.`nama` AS `vendor`,
    CASE WHEN `b`.`non_do` != '1' THEN 
    `i`.`biaya_admin` 
    ELSE
    `b`.`non_do_biaya_admin`
    END
    AS `biaya_admin`,
    CASE WHEN `b`.`id_vendor_pajak` IS NULL OR `b`.`id_vendor_pajak` = '0' THEN `h`.`jenis_pajak` ELSE `j`.`jenis_pajak`
    END AS `jenis_pajak`,
    CASE WHEN `b`.`id_vendor_pajak` IS NULL OR `b`.`id_vendor_pajak` = '0' THEN `h`.`no_pajak` ELSE `j`.`no_pajak`
    END AS `no_pajak`,
    CASE WHEN `b`.`id_vendor_pajak` IS NULL OR `b`.`id_vendor_pajak` = '0' THEN `h`.`nama_pajak` ELSE `j`.`nama_pajak`
    END AS `nama_pajak`,
    
    CASE WHEN `b`.`non_do` != '1' THEN
        CASE WHEN `e`.`kategori` = '1' THEN
            CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
            ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_npwp` / 100), 1)
            WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
            ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1)
            ELSE
            ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1)
            END
        ELSE
        CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
        CASE WHEN `b`.`id_vendor_pajak` IS NULL OR `b`.`id_vendor_pajak` = '0' THEN 
            CASE WHEN `h`.`jenis_pajak` = 'skb' THEN ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_skb` / 100), 1)
            WHEN `h`.`jenis_pajak` = 'ktp' THEN ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_ktp` / 100), 1)
            WHEN `h`.`jenis_pajak` = 'npwp' THEN ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_npwp` / 100), 1)
            ELSE 0
            END 
        ELSE 
            CASE WHEN `j`.`jenis_pajak` = 'skb' THEN ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_skb` / 100), 1)
            WHEN `j`.`jenis_pajak` = 'ktp' THEN ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_ktp` / 100), 1)
            WHEN `j`.`jenis_pajak` = 'npwp' THEN ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_npwp` / 100), 1)
            ELSE 0
            END
        END

        WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
        CASE WHEN `b`.`id_vendor_pajak` IS NULL OR `b`.`id_vendor_pajak` = '0' THEN 
            CASE WHEN `h`.`jenis_pajak` = 'skb' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_skb` / 100), 1)
            WHEN `h`.`jenis_pajak` = 'ktp' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_ktp` / 100), 1)
            WHEN `h`.`jenis_pajak` = 'npwp' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1)
            ELSE 0
            END 
        ELSE 
            CASE WHEN `j`.`jenis_pajak` = 'skb' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_skb` / 100), 1)
            WHEN `j`.`jenis_pajak` = 'ktp' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_ktp` / 100), 1)
            WHEN `j`.`jenis_pajak` = 'npwp' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1)
            ELSE 0
            END
        END
        ELSE 
        CASE WHEN `b`.`id_vendor_pajak` IS NULL OR `b`.`id_vendor_pajak` = '0' THEN 
            CASE WHEN `h`.`jenis_pajak` = 'skb' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_skb` / 100), 1)
            WHEN `h`.`jenis_pajak` = 'ktp' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_ktp` / 100), 1)
            WHEN `h`.`jenis_pajak` = 'npwp' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1)
            ELSE 0
            END 
        ELSE 
            CASE WHEN `j`.`jenis_pajak` = 'skb' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_skb` / 100), 1)
            WHEN `j`.`jenis_pajak` = 'ktp' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_ktp` / 100), 1)
            WHEN `j`.`jenis_pajak` = 'npwp' THEN ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1)
            ELSE 0
            END
        END
        END
    END
    ELSE 0

    END AS `pph`,  

    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
        `g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)
    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
        `g`.`harga` * `b`.`qty_kirim_kg`
    ELSE
        `g`.`harga` * `b`.`qty_kirim_kg`
    END AS `total`,

    ROUND((`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100) ), 1) AS `toleransi_susut_invoice`,

    CONCAT(CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1)) AS `susut_invoice`,

    CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
        CONCAT(CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1)) * `a`.`claim` ELSE 0
    END AS `total_claim_invoice`,

    CASE WHEN `a`.`id_komoditas` = '3' AND (`a`.`id_klien` = '6' || `a`.`id_klien` = '14') THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`) * `a`.`harga_unit`)
        ELSE 
            LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`) * `a`.`harga_unit`
        END 
    WHEN `a`.`id_komoditas` = '3' AND `a`.`id_klien` = '1' THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(`b`.`timbang_kebun_kg` * `a`.`harga_unit`)
        ELSE 
            `b`.`timbang_kebun_kg` * `a`.`harga_unit`
        END 
    WHEN `a`.`id_komoditas` = '2' AND (`a`.`id_klien` = '4' || `a`.`id_klien` = '5' || `a`.`id_klien` = '9' || `a`.`id_klien` = '10' || `a`.`id_klien` = '16' || `a`.`id_klien` = '8') THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(`b`.`qty_kirim_kg` * `a`.`harga_unit`)
        ELSE 
            `b`.`qty_kirim_kg` * `a`.`harga_unit`
        END 
    WHEN `a`.`id_komoditas` = '2' AND (`a`.`id_klien` != '4' || `a`.`id_klien` != '5' || `a`.`id_klien` != '9' || `a`.`id_klien` != '10' || `a`.`id_klien` != '16' || `a`.`id_klien` != '8') THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(`b`.`timbang_kebun_kg` * `a`.`harga_unit`)
        ELSE 
            `b`.`timbang_kebun_kg` * `a`.`harga_unit`
        END 
    WHEN `a`.`id_komoditas` = '4' THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`) * `a`.`harga_unit`) 
        ELSE 
            LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`) * `a`.`harga_unit`
        END 
    ELSE
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(`b`.`timbang_kebun_kg` * `a`.`harga_unit`)
        ELSE 
            `b`.`timbang_kebun_kg` * `a`.`harga_unit`
        END 
    END
    AS `total_invoice_kotor`,

    CASE WHEN `a`.`id_komoditas` = '3' AND (`a`.`id_klien` = '6' || `a`.`id_klien` = '14') THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`) * `a`.`harga_unit`) - CONCAT(CONCAT(CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1)) * `a`.`claim`) 
        ELSE 
            LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`) * `a`.`harga_unit`
        END 
    WHEN `a`.`id_komoditas` = '3' AND `a`.`id_klien` = '1' THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(`b`.`timbang_kebun_kg` * `a`.`harga_unit`) - CONCAT(CONCAT(CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1)) * `a`.`claim`) 
        ELSE 
            `b`.`timbang_kebun_kg` * `a`.`harga_unit`
        END 
    WHEN `a`.`id_komoditas` = '2' AND (`a`.`id_klien` = '4' || `a`.`id_klien` = '5' || `a`.`id_klien` = '9' || `a`.`id_klien` = '10' || `a`.`id_klien` = '16' || `a`.`id_klien` = '8') THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(`b`.`qty_kirim_kg` * `a`.`harga_unit`) - CONCAT(CONCAT(CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1)) * `a`.`claim`) 
        ELSE 
            `b`.`qty_kirim_kg` * `a`.`harga_unit`
        END 
    WHEN `a`.`id_komoditas` = '2' AND (`a`.`id_klien` != '4' || `a`.`id_klien` != '5' || `a`.`id_klien` != '9' || `a`.`id_klien` != '10' || `a`.`id_klien` != '16' || `a`.`id_klien` != '8') THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(`b`.`timbang_kebun_kg` * `a`.`harga_unit`) - CONCAT(CONCAT(CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1)) * `a`.`claim`) 
        ELSE 
            `b`.`timbang_kebun_kg` * `a`.`harga_unit`
        END 
    WHEN `a`.`id_komoditas` = '4' THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`) * `a`.`harga_unit`) - CONCAT(CONCAT(CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1)) * `a`.`claim`) 
        ELSE 
            LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`) * `a`.`harga_unit`
        END 
    ELSE
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1) THEN 
            CONCAT(`b`.`timbang_kebun_kg` * `a`.`harga_unit`) - CONCAT(CONCAT(CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - ROUND(CONCAT(`b`.`timbang_kebun_kg` * (`a`.`toleransi_susut` / 100)), 1)) * `a`.`claim`) 
        ELSE 
            `b`.`timbang_kebun_kg` * `a`.`harga_unit`
        END 
    END
    AS `total_invoice`,

    CASE WHEN `b`.`non_do` = '1' THEN 
    CONCAT(`b`.`non_do_harga_vendor` * `b`.`qty_kirim_kg`) - `b`.`uang_sangu` - `b`.`non_do_biaya_admin`
    WHEN `e`.`kategori` = '1' THEN
        CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > `b`.`toleransi_susut` THEN
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`))  - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_npwp` / 100), 1) - CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`)  - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1) - CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1) - CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    END
                ELSE
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`))  - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_npwp` / 100), 1)
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1)
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1)
                    END
                END
    ELSE
        CASE WHEN `b`.`id_vendor_pajak` IS NULL OR `b`.`id_vendor_pajak` = '0' THEN 
            CASE WHEN `h`.`jenis_pajak` = 'skb' THEN 
                CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > `b`.`toleransi_susut` THEN
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    END
                ELSE
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin`
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin`
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin`
                    END
                END
            WHEN `h`.`jenis_pajak` = 'npwp' THEN 
                CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > `b`.`toleransi_susut` THEN
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) * (`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) * (`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    END
                ELSE
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) *(`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin`
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin`
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin`
                    END
                END
            WHEN `h`.`jenis_pajak` = 'ktp' THEN 
                CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > `b`.`toleransi_susut` THEN
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    END
                ELSE
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin`
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin`
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin`
                    END
                END
            ELSE 1
            END 
        ELSE 
            CASE WHEN `j`.`jenis_pajak` = 'skb' THEN 
                CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > `b`.`toleransi_susut` THEN
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    END
                ELSE
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin`
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin`
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_skb` / 100), 1) - `i`.`biaya_admin`
                    END
                END
            WHEN `j`.`jenis_pajak` = 'npwp' THEN
                CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > `b`.`toleransi_susut` THEN
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) *(`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    END
                ELSE
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) *(`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin`
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin`
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_npwp` / 100), 1) - `i`.`biaya_admin`
                    END
                END
            WHEN `j`.`jenis_pajak` = 'ktp' THEN 
                CASE WHEN CONCAT(`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) > `b`.`toleransi_susut` THEN
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin` -  CONCAT(CONCAT((`b`.`timbang_kebun_kg` - `b`.`qty_kirim_kg`) - `b`.`toleransi_susut`) * `a`.`claim_replas`) 
                    END
                ELSE
                    CASE WHEN (`a`.`id_komoditas` = '1' || `a`.`id_komoditas` = '3' || `a`.`id_komoditas` = '4') || ((`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '7') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '10') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '9') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '8')) THEN
                        CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) - ROUND(CONCAT(`g`.`harga` * LEAST(`b`.`qty_kirim_kg`, `b`.`timbang_kebun_kg`)) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin`
                    WHEN (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '4') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '16') || (`a`.`id_komoditas` = '2' AND `a`.`id_klien` = '5') THEN
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin`
                    ELSE
                        CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) - ROUND(CONCAT(`g`.`harga` * `b`.`qty_kirim_kg`) *(`i`.`pph_ktp` / 100), 1) - `i`.`biaya_admin`
                    END
                END
            ELSE 2
            END
        END
    END AS `grand_total`,
    `b`.`tanggal_pembayaran_replas` AS `tanggal_pembayaran_replas`,
    `b`.`status` AS `status`,
    CASE WHEN `b`.`status` = '0' THEN 'Belum Dibayar' WHEN `b`.`status` = '1' THEN 'Sudah Dibayar' ELSE 1
    END AS `nama_status`,
    `b`.`tanggal_input` AS `tanggal_input`,
    `b`.`non_do` AS `non_do`,
    `b`.`non_do_id_komoditas` AS `non_do_id_komoditas`,
    `b`.`non_do_harga` AS `non_do_harga`,
    `b`.`non_do_harga_vendor` AS `non_do_harga_vendor`
    FROM
        (
            (
                (
                    (
                        (
                            (
                                (
                                    (
                                        (
                                        (
                                            `u856234669_rws`.`tbl_rekap` `b`
                                        LEFT JOIN `u856234669_rws`.`tbl_project` `a`
                                        ON
                                            (`a`.`id` = `b`.`id_project`)
                                        )
                                    LEFT JOIN `u856234669_rws`.`tbl_klien` `c`
                                    ON
                                        (`a`.`id_klien` = `c`.`id`)
                                    )
                                LEFT JOIN `u856234669_rws`.`tbl_supir` `d`
                                ON
                                    (`b`.`id_supir` = `d`.`id`)
                                )
                            LEFT JOIN `u856234669_rws`.`tbl_truck` `e`
                            ON
                                (`b`.`id_truck` = `e`.`id`)
                            )
                        LEFT JOIN `u856234669_rws`.`tbl_komoditas` `f`
                        ON
                            (`a`.`id_komoditas` = `f`.`id`)
                        )
                    LEFT JOIN `u856234669_rws`.`tbl_tujuan` `g`
                    ON
                        (`b`.`id_tujuan` = `g`.`id`)
                    )
                LEFT JOIN `u856234669_rws`.`tbl_vendor_truck` `h`
                ON
                    (`e`.`id_vendor` = `h`.`id`)
                )
            LEFT JOIN `u856234669_rws`.`tbl_vendor_truck` `j`
            ON
                (`b`.`id_vendor_pajak` = `j`.`id`)
            )
        JOIN `u856234669_rws`.`tbl_adm_setting` `i`
        )
        LEFT JOIN `u856234669_rws`.`tbl_komoditas` `k`
                        ON
                            (`b`.`non_do_id_komoditas` = `k`.`id`)
                        )