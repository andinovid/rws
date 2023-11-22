select
  `a`.`id` AS `id_project`,
  `a`.`no_kontrak` AS `no_kontrak`,
  `a`.`deskripsi` AS `deskripsi`,
  `a`.`no_sto` AS `no_sto`,
  `a`.`no_do` AS `no_do`,
  `b`.`no_po` AS `no_po`,
  count(`b`.`id_rekap`) AS `total_replas`,
  `a`.`qty` AS `qty`,
  sum(`b`.`bruto_awal`) AS `total_bruto_awal`,
  sum(`b`.`tarra_awal`) AS `total_tarra_awal`,
  sum(`b`.`timbang_kebun_kg`) AS `total_qty_awal`,
  sum(`b`.`timbang_kebun_bag`) AS `total_qty_awal_bag`,
  sum(`b`.`bruto_akhir`) AS `total_bruto_akhir`,
  sum(`b`.`tarra_akhir`) AS `total_tarra_akhir`,
  sum(`b`.`qty_kirim_kg`) AS `total_qty_akhir`,
  sum(`b`.`qty_kirim_bag`) AS `total_qty_akhir_bag`,
  `a`.`claim` AS `harga_claim_satuan`,
  `a`.`harga_unit` AS `harga_unit`,
  round(`a`.`qty` * `a`.`harga_unit`, 0) AS `total_nilai`,
  `a`.`harga_jasa_muat` AS `harga_jasa_muat`,
  round(`a`.`qty` / 1000 * `a`.`harga_jasa_muat`, 0) AS `estimasi_total_harga_jasa_muat`,
  round(`a`.`qty` / 1000 * `a`.`harga_jasa_bongkar`, 0) AS `estimasi_total_harga_jasa_bongkar`,
  `a`.`tanggal_angkut` AS `tanggal_angkut`,
  `a`.`tanggal_selesai` AS `tanggal_selesai`,
  to_days(`a`.`tanggal_selesai`) - to_days(`a`.`tanggal_angkut`) AS `durasi_project`,
  to_days(current_timestamp()) - to_days(`a`.`tanggal_angkut`) AS `sisa_durasi_project`,
  `a`.`toleransi_susut` AS `toleransi_susut`,
  `a`.`id_klien` AS `id_klien`,
  `c`.`nama_perusahaan` AS `nama_perusahaan`,
  `c`.`alamat` AS `alamat`,
  `a`.`id_komoditas` AS `id_komoditas`,
  `d`.`komoditas` AS `komoditas`,
  `e`.`nama_tujuan` AS `nama_tujuan`,
  sum(`b`.`timbang_kebun_kg`) AS `total_terkirim`,
  `a`.`qty` - sum(`b`.`timbang_kebun_kg`) AS `sisa_kirim`,
  sum(`b`.`m_susut`) AS `total_susut`,
  sum(`b`.`c_claim`) AS `total_claim_replas`,
  sum(`b`.`m_susut`) - `a`.`toleransi_susut` AS `total_claim_invoice`,
  (sum(`b`.`m_susut`) - `a`.`toleransi_susut`) * `a`.`claim` AS `total_biaya_claim_invoice`,
  sum(`b`.`total_claim`) AS `total_biaya_claim_replas`,
  round(sum(`b`.`timbang_kebun_kg`) / `a`.`qty` * 100, 1) AS `persentase_terkirim`,
  sum(`b`.`uang_sangu`) AS `total_uang_sangu`,
  sum(`b`.`pinjaman`) AS `total_pinjaman`,
  sum(`b`.`grand_total`) AS `total_pengeluaran`,
  sum(`b`.`total_invoice`) AS `total_invoice`,
  `a`.`pph` AS `pph`, 
  `a`.`ppn` AS `ppn`,
  `a`.`file_spk` AS `file_spk`,
  `a`.`file_do` AS `file_do`,
  `a`.`tanggal_input` AS `tanggal_input`,
  `a`.`id_penagih` AS `id_penagih`,
  `g`.`nama` AS `nama_penagih`,
  `a`.`status` AS `status`,
  case
    when `a`.`status` = '0' then 'Menunggu Approval'
    when `a`.`status` = '1' then 'Sedang Berlangsung'
    when `a`.`status` = '1'
    and sum(`b`.`timbang_kebun_kg`) >= `a`.`qty` then 'Menunggu Pembayaran'
    when `a`.`status` = '2' then 'Selesai'
    else 1
  end AS `nama_status`
from
  (
    (
      (
        (
          (
            `u856234669_rws`.`tbl_project` `a`
            left join `u856234669_rws`.`v_rekap` `b` on(`b`.`id_project` = `a`.`id`)
          )
          left join `u856234669_rws`.`tbl_klien` `c` on(`a`.`id_klien` = `c`.`id`)
        )
        left join `u856234669_rws`.`tbl_komoditas` `d` on(`a`.`id_komoditas` = `d`.`id`)
      )
      left join `u856234669_rws`.`tbl_tujuan` `e` on(`a`.`id_tujuan` = `e`.`id`)
    )
    left join `u856234669_rws`.`tbl_penagih` `g` on(`g`.`id` = `a`.`id_penagih`)
  )
group by
  `a`.`id`