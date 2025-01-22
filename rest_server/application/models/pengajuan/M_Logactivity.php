<?php

/**
 * 
 */
class M_Logactivity extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function get_index_keterangan($id = null, $jabatan = null)
	{
		$where = " `tbl_activity`.`id` is not null";
        if ($id!='') {
            $where .= " and `tbl_activity`.`id` = '$id'";
        }

        if ($jabatan!='') {
            $where .= " and `tbl_activity`.`jabatan` = '$jabatan'";
        }
        
		if ($id === null AND $jabatan === null) {
			$sql="SELECT * FROM tbl_activity";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		} else {
			$sql="SELECT * FROM tbl_activity WHERE $where";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		}
	}

	public function get_indexid($id = null)
	{        
		$sql="SELECT * FROM tmp_daily_activity WHERE id = '$id'";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function get_index_keterangan_nik($nik_baru = null, $id = null)
	{        
		$sql="SELECT 
			a.submit_date,
			a.nik,
			a.jabatan,
			b.list_pekerjaan,
			a.status,
			a.dokumen,
			a.ket_tambahan,
			a.lat,
			a.lon
				FROM tbl_karyawan_activity a LEFT JOIN tbl_activity b ON
				a.`id_activity` = b.`id`
				WHERE a.nik = '$nik_baru' AND b.`id`='$id'
				AND a.submit_date >= CURDATE() AND a.submit_date < CURDATE() + INTERVAL 1 DAY
				ORDER BY b.id
				ASC";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
		
	}

	public function get_index_keterangan_nikdate($nik_baru = null, $date = null, $date2 = null)
	{        
		$sql="SELECT * FROM tbl_karyawan_activity WHERE nik = '$nik_baru' AND 
				DATE(submit_date) >= '$date' AND DATE(submit_date) <= '$date2'
				AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-14') 
				AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-13') 
				AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-12') 
				AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-11') 
				AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-10')
				AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-09')
				AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-08')
				AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-07') ";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
		
	}

	public function get_absenvsdaily($nik_baru = null, $date = null, $date2 = null)
	{        
		$sql="SELECT
		tbl_karyawan.`badgenumber`
		, tbl_karyawan.`name`
		, DATE(tbl_karyawan.`shift_day`) AS bulan
		, IFNULL((SELECT COUNT(DISTINCT(DATE(`rd_ket_absen`.`shift_day`)))
			FROM `rd_ket_absen`
			LEFT JOIN `tbl_jabatan_karyawan`
			ON `rd_ket_absen`.`jabatan_karyawan` = `tbl_jabatan_karyawan`.`jabatan_karyawan`
			WHERE DATE(`rd_ket_absen`.`shift_day`) >= '$date' 
			AND DATE(`rd_ket_absen`.`shift_day`) <= '$date2'
			AND MONTH(`rd_ket_absen`.`shift_day`) = MONTH(tbl_karyawan.`shift_day`)
			AND `rd_ket_absen`.`badgenumber` = tbl_karyawan.`badgenumber`
			AND `rd_ket_absen`.`ket_absensi` NOT IN ('LI')
			GROUP BY MONTH(`rd_ket_absen`.`shift_day`)),0) AS jumlah_absen
		, IFNULL((SELECT COUNT(DISTINCT(DATE(`rd_ket_absen`.`shift_day`)))
			FROM `rd_ket_absen`
			LEFT JOIN `tbl_jabatan_karyawan`
			ON `rd_ket_absen`.`jabatan_karyawan` = `tbl_jabatan_karyawan`.`jabatan_karyawan`
			WHERE DATE(`rd_ket_absen`.`shift_day`) >= '$date' 
			AND DATE(`rd_ket_absen`.`shift_day`) <= '$date2'
			AND MONTH(`rd_ket_absen`.`shift_day`) = MONTH(tbl_karyawan.`shift_day`)
			AND `rd_ket_absen`.`badgenumber` = tbl_karyawan.`badgenumber`
			AND `rd_ket_absen`.`ket_absensi` IN ('LI')
			GROUP BY MONTH(`rd_ket_absen`.`shift_day`)),0) AS jumlah_non_work
		, IFNULL((SELECT COUNT(DISTINCT(DATE(`tbl_daily_activity`.`waktu_submit`)))
			FROM `tbl_daily_activity`
			WHERE DATE(`tbl_daily_activity`.`waktu_submit`) >= '$date'
			AND DATE(`tbl_daily_activity`.`waktu_submit`) <= '$date2'
			AND MONTH(`tbl_daily_activity`.`waktu_submit`) = MONTH(tbl_karyawan.`shift_day`)
			AND `tbl_daily_activity`.`nik` = tbl_karyawan.`badgenumber`
			GROUP BY MONTH(`tbl_daily_activity`.`waktu_submit`)),0) AS jumlah_daily_perday
		FROM (SELECT 
		`rd_ket_absen`.`badgenumber`
		, `rd_ket_absen`.`name`
		, `rd_ket_absen`.`shift_day`	
		FROM `rd_ket_absen`
		WHERE `rd_ket_absen`.`badgenumber` = '$nik_baru'
		AND DATE(`rd_ket_absen`.`shift_day`) >= '$date'
		AND DATE(`rd_ket_absen`.`shift_day`) <= '$date2'
		AND DATE(`rd_ket_absen`.`shift_day`) NOT IN (
			 (DATE(`rd_ket_absen`.`shift_day`) >= '2021-09-01'
			 AND DATE(`rd_ket_absen`.`shift_day`) <= '2021-09-14'))
		GROUP BY MONTH(`rd_ket_absen`.`shift_day`) ORDER BY `rd_ket_absen`.`shift_day` ASC) tbl_karyawan";
	    $hasil = $this->db6->query($sql);
	    return $hasil->result_array();
	}

	public function get_persentase($nik = null, $date = null, $date2 = null)
	{        
		$sql="SELECT 
				`tbl_daily_activity`.`nik`
				, IFNULL(COUNT(`tbl_daily_activity`.`nik`),0) AS frekuensi_daily
				, `tbl_daily_activity`.`waktu_submit`
					FROM `tbl_daily_activity`
					WHERE `tbl_daily_activity`.`nik` = '$nik'
					AND DATE(`tbl_daily_activity`.`waktu_submit`) >= '$date'
					AND DATE(`tbl_daily_activity`.`waktu_submit`) <= '$date2'
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-14') 
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-13') 
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-12') 
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-11') 
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-10')
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-09')
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-08')
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-07') 
					GROUP BY DATE(`tbl_daily_activity`.`waktu_submit`)";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();	
	}

	public function get_paretointernal($nik = null, $date = null, $date2 = null)
	{        
		$sql="SELECT
				c.lokasi
				,SUM(jumlah_kunjungan_harian) AS jumlah_kunjungan
				FROM (
					SELECT
					a.`lokasi`, 
					DATE(a.`waktu_submit`),
					SUM(IF(a.`lokasi` IS NOT NULL,1,0)) AS jumlah_kunjungan
					,1 AS jumlah_kunjungan_harian
					FROM `tbl_daily_activity` a

					WHERE DATE(a.`waktu_submit`) >= '$date'
					AND DATE(a.`waktu_submit`) <= '$date2'
					AND a.`nik` = '$nik'
					AND a.`status_lokasi` = '1'
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-14') 
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-13') 
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-12') 
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-11') 
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-10')
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-09')
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-08')
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-07') 
					GROUP BY DATE(a.`waktu_submit`), a.`lokasi`
				) c 
				GROUP BY c.lokasi
				ORDER BY jumlah_kunjungan ASC";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function get_paretoeksternal($nik = null, $date = null, $date2 = null)
	{        
		$sql="SELECT
				c.lokasi
				,SUM(jumlah_kunjungan_harian) AS jumlah_kunjungan
				FROM (
					SELECT
					a.`lokasi`, 
					DATE(a.`waktu_submit`),
					SUM(IF(a.`lokasi` IS NOT NULL,1,0)) AS jumlah_kunjungan
					,1 AS jumlah_kunjungan_harian
					FROM `tbl_daily_activity` a

					WHERE DATE(a.`waktu_submit`) >= '$date'
					AND DATE(a.`waktu_submit`) <= '$date2'
					AND a.`nik` = '$nik'
					AND a.`status_lokasi` = '0'
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-14') 
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-13') 
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-12') 
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-11') 
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-10')
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-09')
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-08')
					AND DATE(a.`waktu_submit`) NOT IN ('2021-09-07') 
					GROUP BY DATE(a.`waktu_submit`), a.`lokasi`
				) c
				GROUP BY c.lokasi
				ORDER BY jumlah_kunjungan ASC";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function get_internalvseksternal($nik = null, $date = null, $date2 = null)
	{        
		$sql="SELECT 
				`tbl_daily_activity`.`waktu_submit`
				, `tbl_daily_activity`.`nik`
				, IFNULL(COUNT(CASE
					WHEN `tbl_daily_activity`.`status_lokasi` = '0'
					THEN `tbl_daily_activity`.`status_lokasi`
					ELSE NULL
					END),0) AS eksternal_jumlah
				, IFNULL(COUNT(CASE
					WHEN `tbl_daily_activity`.`status_lokasi` = '1'
					THEN `tbl_daily_activity`.`status_lokasi`
					ELSE NULL
					END),0) AS internal_jumlah	
						FROM `tbl_daily_activity`
						WHERE `tbl_daily_activity`.`nik` = '$nik'
						AND DATE(`tbl_daily_activity`.`waktu_submit`) >= '$date'
						AND DATE(`tbl_daily_activity`.`waktu_submit`) <= '$date2'
						AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-14') 
						AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-13') 
						AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-12') 
						AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-11') 
						AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-10')
						AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-09')
						AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-08')
						AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-07') 
						GROUP BY MONTH(`tbl_daily_activity`.`waktu_submit`)";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
		
	}

	public function createLogActivity($data)
	{
		$this->db2->insert('tbl_karyawan_activity', $data);
		return $this->db2->affected_rows();
	}

	public function get_index_tmp_hariini($nik = null)
	{        
		$sql="SELECT * FROM tmp_daily_activity WHERE nik = '$nik'
				AND submit_date >= CURDATE() AND submit_date < CURDATE() + INTERVAL 1 DAY";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function getketerangan($nik = null, $tanggal1 = null, $tanggal2 = null)
	{        
		$sql="SELECT
				`tbl_daily_activity`.`id`
				, `tbl_daily_activity`.`submit_date`
				, `tbl_daily_activity`.`waktu_submit`
				, `tbl_daily_activity`.`nik`
				, `tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, `tbl_jabatan_karyawan`.`jabatan_karyawan`
				, `tbl_karyawan_struktur`.`level_struktur`
				, `tbl_karyawan_struktur`.`lokasi_struktur`
				, `tbl_karyawan_struktur`.`dept_struktur`
				, `tbl_daily_activity`.`status_lokasi` AS status_lokasi
				, `tbl_daily_activity`.`lokasi` AS lokasi
				, `tbl_daily_activity`.`keterangan`
				, `tbl_daily_activity`.`lat` AS lat
				, `tbl_daily_activity`.`lon` AS lon
					FROM `tbl_daily_activity`
					INNER JOIN `tbl_karyawan_struktur`
						ON `tbl_daily_activity`.`nik` = `tbl_karyawan_struktur`.`nik_baru`
					INNER JOIN `tbl_jabatan_karyawan`
						ON `tbl_karyawan_struktur`.`jabatan_struktur` = `tbl_jabatan_karyawan`.`no_jabatan_karyawan`
					WHERE `tbl_daily_activity`.`nik` = '$nik'
					AND DATE(`tbl_daily_activity`.`waktu_submit`) >= '$tanggal1'
					AND DATE(`tbl_daily_activity`.`waktu_submit`) <= '$tanggal2'
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-14') 
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-13') 
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-12') 
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-11') 
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-10')
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-09')
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-08')
					AND DATE(`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-07') 
					GROUP BY `tbl_daily_activity`.`keterangan`
					ORDER BY `tbl_daily_activity`.`waktu_submit` DESC";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function createtmp($data)
    {
        $this->db2->insert('tmp_daily_activity', $data);
        return $this->db2->affected_rows();
    }

    public function createreal($data)
    {
        $this->db2->insert('tbl_daily_activity', $data);
        return $this->db2->affected_rows();
    }

    public function hapustmp($nik)
	{
		$this->db2->delete('tmp_daily_activity', ['nik' => $nik]);
		return $this->db2->affected_rows();
	}

	public function updateKeterangan($data, $id)
    {
        $this->db2->update('tmp_daily_activity', $data, ['id' => $id]);
        return $this->db2->affected_rows();
    }

    public function hapusKeterangan($id)
    {
        $this->db2->delete('tmp_daily_activity', ['id' => $id]);
        return $this->db2->affected_rows();
    }

	

}

?>