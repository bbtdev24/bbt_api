<?php

/**
 * 
 */
class M_Supplier extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function M_SupplierTesting($mk_barcode = null)
	{
		$sql="SELECT 
			a.`mk_barcode`,
			a.`mk_pool`,
			a.`mk_armada_nopol`,
			a.`mk_armada_driver`,
			a.`mk_armada_driver_pengganti`,
			a.`mk_varian_label`,
			a.`mk_varian_muatan`,
			a.`transporter_kode`,
			a.`mk_transporter_kode_per`,
			a.`mk_po`,
			a.`mk_po_old`,
			a.`mk_po_return_isi`,
			a.`mk_po_gal_kos`,
			a.`mk_po_jugrack`,
			a.`mk_po_palet`,
			a.`mk_depo_asal`,
			a.`mk_so_asal`,
			a.`mk_depo_tujuan`,
			a.`mk_so_tujuan`,
			a.`mk_divert_plan_depo`,
			a.`mk_divert_plan_so`,
			a.`pabrik_nama`,
			a.`material_nama`,
			a.`mk_co_plan`,
			a.`mk_co_real`,
			a.`mk_co_uro`,
			h.`dn_m` AS mk_dn_m,
			h.`dn_m_qty` AS mk_dn_m_qty,
			h.`dn_t` AS mk_dn_t,
			h.`dn_t_qty` AS mk_dn_t_qty,
			a.`mk_dn_van`,
			a.`mk_dn_date`,
			h.`gr` AS mk_gr,
			h.`gr_qty` AS mk_gr_qty,
			a.`mk_tm_gal_isi`,
			a.`mk_tm_gal_kos`,
			a.`mk_tm_hp3`,
			a.`mk_tk_gal_isi_aqua`,
			a.`mk_tk_gal_isi_vit`,
			a.`mk_tk_gal_kos_aqua`,
			a.`mk_tk_gal_kos_vit`,
			a.`mk_tmd_gal_isi_aqua`,
			a.`mk_tmd_gal_isi_vit`,
			a.`mk_tmd_gal_kosong_aqua`,
			a.`mk_tmd_gal_kosong_vit`,
			a.`mk_keterangan`,
			a.`mk_bs_depo`,
			a.`mk_forklift`,
			a.`mk_jugrack`,
			a.`mk_palet`,
			a.`mk_wo`,
			a.`mk_note`,
			a.`mk_reason`,
			a.`mk_bs_bongkar`,
			a.`mk_bs_rusak`,
			a.`mk_bs_sps`,
			a.`mk_bs_handling`,
			a.`mk_muatan_keluar`,
			a.`mk_muatan_masuk`,
			a.`mk_status_rekap`,
			a.`mk_status_pool_isi`,
			a.`mk_status_unpost_aco`,
			a.`mk_status_unpost_checker`,
			a.`mk_tolakan_turun`,
			a.`mk_pengajuan_unpost`,
			a.`status_unpost`,
			a.`status_unpost_edit`,
			b.*,
			c.*,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_id,
		    g.po_id
			) AS po_id,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_nopol,
		    g.po_nopol
			) AS po_nopol,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_driver,
		    g.po_driver
			) AS po_driver,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_driver_pengganti,
		    g.po_driver_pengganti
			) AS po_driver_pengganti,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_varian_label,
		    g.po_varian_label
			) AS po_varian_label,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_varian_muatan,
		    g.po_varian_muatan
			) AS po_varian_muatan,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_transporter_kode,
		    g.po_transporter_kode
			) AS po_transporter_kode,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_transporter_kode_per,
		    g.po_transporter_kode_per
			) AS po_transporter_kode_per,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_po_new,
		    g.po_po_new
			) AS po_po_new,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_po_old,
		    g.po_po_old
			) AS po_po_old,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_return_isi,
		    g.po_return_isi
			) AS po_return_isi,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_gal_kos,
		    g.po_gal_kos
			) AS po_gal_kos,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_jugrack,
		    g.po_jugrack
			) AS po_jugrack,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_palet,
		    g.po_palet
			) AS po_palet,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_depo,
		    g.po_depo
			) AS po_depo,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_pool,
		    g.po_pool
			) AS po_pool,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_tgl,
		    g.po_tgl
			) AS po_tgl,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_jam,
		    g.po_jam
			) AS po_jam,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_status,
		    g.po_status
			) AS po_status,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_pabrik,
		    g.po_pabrik
			) AS po_pabrik,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_sku,
		    g.po_sku
			) AS po_sku,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_bs_isi,
		    g.po_bs_isi
			) AS po_bs_isi,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_bs_ksg,
		    g.po_bs_ksg
			) AS po_bs_ksg,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_bs_isi1,
		    g.po_bs_isi1
			) AS po_bs_isi1,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_bs_ksg1,
		    g.po_bs_ksg1
			) AS po_bs_ksg1,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_kat_palet,
		    g.po_kat_palet
			) AS po_kat_palet,
			IF(
		    a.`mk_so_asal` = '',
		    d.po_tissue,
		    g.po_tissue
			) AS po_tissue,
			IF(a.`mk_so_asal` = '', d.po_co, '') AS po_co,
			e.*,
			IF(a.`mk_so_asal` = '', f.`id`, i.`id`) AS id,
			IF(
		    a.`mk_so_asal` = '',
		    f.`mk_barcode`,
		    i.`mk_barcode`
			) AS mk_barcode,
			IF(
		    a.`mk_so_asal` = '',
		    f.`pool`,
		    i.`pool`
			) AS pool,
			IF(
		    a.`mk_so_asal` = '',
		    f.`asal`,
		    i.`asal`
			) AS asal,
			IF(
		    a.`mk_so_asal` = '',
		    f.`plan_tujuan`,
		    i.`plan_tujuan`
			) AS plan_tujuan,
			IF(
		    a.`mk_so_asal` = '',
		    f.`masuk_tujuan`,
		    i.`masuk_tujuan`
			) AS masuk_tujuan,
			IF(
		    a.`mk_so_asal` = '',
		    f.`nopol`,
		    i.`nopol`
			) AS nopol,
			IF(
		    a.`mk_so_asal` = '',
		    f.`driver1`,
		    i.`driver1`
			) AS driver1,
			IF(
		    a.`mk_so_asal` = '',
		    f.`driver2`,
		    i.`driver2`
			) AS driver2,
			IF(a.`mk_so_asal` = '', f.`co`, i.`co`) AS co,
			IF(
		    a.`mk_so_asal` = '',
		    f.`dn_m`,
		    i.`dn_m`
			) AS dn_m,
			IF(
		    a.`mk_so_asal` = '',
		    f.`dn_t`,
		    i.`dn_t`
			) AS dn_t,
			IF(
		    a.`mk_so_asal` = '',
		    f.`hp3`,
		    i.`hp3`
			) AS hp3,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_total`,
		    i.`isi_total`
			) AS isi_total,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_total`,
		    i.`ksg_total`
			) AS ksg_total,
			IF(
		    a.`mk_so_asal` = '',
		    f.`timestamp_pool`,
		    i.`timestamp_pool`
			) AS timestamp_pool,
			IF(
		    a.`mk_so_asal` = '',
		    f.`timestamp_depo`,
		    i.`timestamp_depo`
			) AS timestamp_depo,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_pecah`,
		    i.`isi_pecah`
			) AS isi_pecah,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_3kode_pabrik`,
		    i.`isi_3kode_pabrik`
			) AS isi_3kode_pabrik,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_ed_lbh_bln`,
		    i.`isi_ed_lbh_bln`
			) AS isi_ed_lbh_bln,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_kode_produksi`,
		    i.`isi_kode_produksi`
			) AS isi_kode_produksi,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_ed_krg_bln`,
		    i.`isi_ed_krg_bln`
			) AS isi_ed_krg_bln,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_cacat_penanganan`,
		    i.`isi_cacat_penanganan`
			) AS isi_cacat_penanganan,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_lumut`,
		    i.`isi_lumut`
			) AS isi_lumut,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_terkena_noda`,
		    i.`isi_terkena_noda`
			) AS isi_terkena_noda,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_seal`,
		    i.`isi_seal`
			) AS isi_seal,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_cacat_lain`,
		    i.`isi_cacat_lain`
			) AS isi_cacat_lain,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_id_excipio`,
		    i.`isi_id_excipio`
			) AS isi_id_excipio,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_bukan_tutup_aqua`,
		    i.`isi_bukan_tutup_aqua`
			) AS isi_bukan_tutup_aqua,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_botol_asing`,
		    i.`isi_botol_asing`
			) AS isi_botol_asing,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_buram`,
		    i.`ksg_buram`
			) AS ksg_buram,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_retak`,
		    i.`ksg_retak`
			) AS ksg_retak,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_spidol`,
		    i.`ksg_spidol`
			) AS ksg_spidol,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_karat`,
		    i.`ksg_karat`
			) AS ksg_karat,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_pecah`,
		    i.`ksg_pecah`
			) AS ksg_pecah,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_botol_asing`,
		    i.`ksg_botol_asing`
			) AS ksg_botol_asing,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_cat_parah`,
		    i.`ksg_cat_parah`
			) AS ksg_cat_parah,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_penyok`,
		    i.`ksg_penyok`
			) AS ksg_penyok,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_cat_ringan`,
		    i.`ksg_cat_ringan`
			) AS ksg_cat_ringan,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_minyak`,
		    i.`ksg_minyak`
			) AS ksg_minyak,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_botol_bersih`,
		    i.`ksg_botol_bersih`
			) AS ksg_botol_bersih,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_kena_api`,
		    i.`ksg_kena_api`
			) AS ksg_kena_api,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_kotor`,
		    i.`ksg_kotor`
			) AS ksg_kotor,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_botol_lubang`,
		    i.`ksg_botol_lubang`
			) AS ksg_botol_lubang,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_kotoran`,
		    i.`ksg_kotoran`
			) AS ksg_kotoran,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_botol_berlumut`,
		    i.`ksg_botol_berlumut`
			) AS ksg_botol_berlumut,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_bibir_sumbing`,
		    i.`ksg_bibir_sumbing`
			) AS ksg_bibir_sumbing,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_botol_thiner`,
		    i.`ksg_botol_thiner`
			) AS ksg_botol_thiner,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_sampah`,
		    i.`ksg_sampah`
			) AS ksg_sampah,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_bau_tajam`,
		    i.`ksg_bau_tajam`
			) AS ksg_bau_tajam,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_tambalan`,
		    i.`ksg_tambalan`
			) AS ksg_tambalan,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_tutup`,
		    i.`ksg_tutup`
			) AS ksg_tutup,
			IF(
		    a.`mk_so_asal` = '',
		    f.`isi_keterangan_tambahan`,
		    ''
			) AS isi_keterangan_tambahan,
			IF(
		    a.`mk_so_asal` = '',
		    f.`ksg_keterangan_tambahan`,
		    ''
			) AS ksg_keterangan_tambahan 
		      FROM
			db_sc_modust_dev.`tbl_sc_armada_barcode` a 
			LEFT JOIN db_sc_modust_dev.`tbl_sc_armada_barcode_waktu` b 
		    ON a.`mk_barcode` = b.`mk_barcode` 
			LEFT JOIN db_sc_modust_dev.`tbl_sc_jadwal_supply` c 
		    ON a.`mk_co_real` = c.`js_co` 
			LEFT JOIN db_sc_modust_dev.`tbl_sc_po_depo` d 
		    ON a.`mk_po` = d.`po_po_old` 
			LEFT JOIN db_sc_modust_dev.`tbl_hp3_depo` f 
		    ON a.`mk_co_real` = f.`co` 
			LEFT JOIN db_sc_modust_dev.`tbl_hp3_pool` i 
		    ON a.`mk_co_real` = i.`co` 
			LEFT JOIN db_sc_modust_dev.`tbl_sc_po_pool` g 
		    ON g.`po_po_new` = a.`mk_po` 
			LEFT JOIN db_sc_modust_dev.`tbl_pabrikan_checker` h 
		    ON h.`co` = a.`mk_co_real`
			LEFT JOIN mdba.`mdbawimasterproduk` e 
		    ON a.`material_nama` = e.`masterNamaWi` 
		      WHERE a.`mk_barcode` = '$mk_barcode'
		      GROUP BY e.`masterKode` ";
	    $hasil = $this->db7->query($sql);
	    return $hasil->result_array();
		
	}

	public function getBakkbPrint($asal_pengirim = null, $co = null)
	{
		$sql = "SELECT
                *
            FROM `db_sc_modust_dev`.`tbl_tolakan_keluar_pool` a
            INNER JOIN `db_sc_modust_dev`.`tbl_sc_armada_barcode` b
                ON b.`mk_co_real` = a.`co`
            WHERE a.`co` = '$co'
            AND a.`dest` = '$asal_pengirim'";
		$hasil = $this->db7->query($sql);
	    return $hasil->result_array();
		
	}

}

?>