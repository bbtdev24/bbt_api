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
		$where = " absensi_new.`tbl_activity`.`id` is not null";
        if ($id!='') {
            $where .= " and absensi_new.`tbl_activity`.`id` = '$id'";
        }

        if ($jabatan!='') {
            $where .= " and absensi_new.`tbl_activity`.`jabatan` = '$jabatan'";
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
				AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-14') 
				AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-13') 
				AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-12') 
				AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-11') 
				AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-10')
				AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-09')
				AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-08')
				AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-07') ";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
		
	}

	public function get_absenvsdaily($nik_baru = null, $date = null, $date2 = null)
	{        
		$sql="SELECT
		tbl_karyawan.`badgenumber`
		, tbl_karyawan.`name`
		, DATE(tbl_karyawan.`shift_day`) AS bulan
		, IFNULL((SELECT COUNT(DISTINCT(DATE(tvip_mdb.`rd_ket_absen`.`shift_day`)))
			FROM tvip_mdb.`rd_ket_absen`
			LEFT JOIN tvip_mdb.`tbl_jabatan_karyawan`
			ON tvip_mdb.`rd_ket_absen`.`jabatan_karyawan` = tvip_mdb.`tbl_jabatan_karyawan`.`jabatan_karyawan`
			WHERE DATE(tvip_mdb.`rd_ket_absen`.`shift_day`) >= '$date' 
			AND DATE(tvip_mdb.`rd_ket_absen`.`shift_day`) <= '$date2'
			AND MONTH(tvip_mdb.`rd_ket_absen`.`shift_day`) = MONTH(tbl_karyawan.`shift_day`)
			AND tvip_mdb.`rd_ket_absen`.`badgenumber` = tbl_karyawan.`badgenumber`
			AND tvip_mdb.`rd_ket_absen`.`ket_absensi` NOT IN ('LI')
			GROUP BY MONTH(tvip_mdb.`rd_ket_absen`.`shift_day`)),0) AS jumlah_absen
		, IFNULL((SELECT COUNT(DISTINCT(DATE(tvip_mdb.`rd_ket_absen`.`shift_day`)))
			FROM tvip_mdb.`rd_ket_absen`
			LEFT JOIN tvip_mdb.`tbl_jabatan_karyawan`
			ON tvip_mdb.`rd_ket_absen`.`jabatan_karyawan` = tvip_mdb.`tbl_jabatan_karyawan`.`jabatan_karyawan`
			WHERE DATE(tvip_mdb.`rd_ket_absen`.`shift_day`) >= '$date' 
			AND DATE(tvip_mdb.`rd_ket_absen`.`shift_day`) <= '$date2'
			AND MONTH(tvip_mdb.`rd_ket_absen`.`shift_day`) = MONTH(tbl_karyawan.`shift_day`)
			AND tvip_mdb.`rd_ket_absen`.`badgenumber` = tbl_karyawan.`badgenumber`
			AND tvip_mdb.`rd_ket_absen`.`ket_absensi` IN ('LI')
			GROUP BY MONTH(tvip_mdb.`rd_ket_absen`.`shift_day`)),0) AS jumlah_non_work
		, IFNULL((SELECT COUNT(DISTINCT(DATE(tvip_mdb.`tbl_daily_activity`.`waktu_submit`)))
			FROM tvip_mdb.`tbl_daily_activity`
			WHERE DATE(tvip_mdb.`tbl_daily_activity`.`waktu_submit`) >= '$date'
			AND DATE(tvip_mdb.`tbl_daily_activity`.`waktu_submit`) <= '$date2'
			AND MONTH(tvip_mdb.`tbl_daily_activity`.`waktu_submit`) = MONTH(tbl_karyawan.`shift_day`)
			AND tvip_mdb.`tbl_daily_activity`.`nik` = tbl_karyawan.`badgenumber`
			GROUP BY MONTH(tvip_mdb.`tbl_daily_activity`.`waktu_submit`)),0) AS jumlah_daily_perday
		FROM (SELECT 
		tvip_mdb.`rd_ket_absen`.`badgenumber`
		, tvip_mdb.`rd_ket_absen`.`name`
		, tvip_mdb.`rd_ket_absen`.`shift_day`	
		FROM tvip_mdb.`rd_ket_absen`
		WHERE tvip_mdb.`rd_ket_absen`.`badgenumber` = '$nik_baru'
		AND DATE(tvip_mdb.`rd_ket_absen`.`shift_day`) >= '$date'
		AND DATE(tvip_mdb.`rd_ket_absen`.`shift_day`) <= '$date2'
		AND DATE(tvip_mdb.`rd_ket_absen`.`shift_day`) NOT IN (
			 (DATE(tvip_mdb.`rd_ket_absen`.`shift_day`) >= '2021-09-01'
			 AND DATE(tvip_mdb.`rd_ket_absen`.`shift_day`) <= '2021-09-14'))
		GROUP BY MONTH(tvip_mdb.`rd_ket_absen`.`shift_day`) ORDER BY tvip_mdb.`rd_ket_absen`.`shift_day` ASC) tbl_karyawan";
	    $hasil = $this->db6->query($sql);
	    return $hasil->result_array();
	}

	public function get_persentase($nik = null, $date = null, $date2 = null)
	{        
		$sql="SELECT 
				absensi_new.`tbl_daily_activity`.`nik`
				, IFNULL(COUNT(absensi_new.`tbl_daily_activity`.`nik`),0) AS frekuensi_daily
				, absensi_new.`tbl_daily_activity`.`waktu_submit`
					FROM absensi_new.`tbl_daily_activity`
					WHERE absensi_new.`tbl_daily_activity`.`nik` = '$nik'
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) >= '$date'
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) <= '$date2'
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-14') 
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-13') 
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-12') 
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-11') 
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-10')
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-09')
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-08')
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-07') 
					GROUP BY DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`)";
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
				absensi_new.`tbl_daily_activity`.`waktu_submit`
				, absensi_new.`tbl_daily_activity`.`nik`
				, IFNULL(COUNT(CASE
					WHEN absensi_new.`tbl_daily_activity`.`status_lokasi` = '0'
					THEN absensi_new.`tbl_daily_activity`.`status_lokasi`
					ELSE NULL
					END),0) AS eksternal_jumlah
				, IFNULL(COUNT(CASE
					WHEN absensi_new.`tbl_daily_activity`.`status_lokasi` = '1'
					THEN absensi_new.`tbl_daily_activity`.`status_lokasi`
					ELSE NULL
					END),0) AS internal_jumlah	
						FROM absensi_new.`tbl_daily_activity`
						WHERE absensi_new.`tbl_daily_activity`.`nik` = '$nik'
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) >= '$date'
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) <= '$date2'
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-14') 
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-13') 
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-12') 
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-11') 
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-10')
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-09')
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-08')
						AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-07') 
						GROUP BY MONTH(absensi_new.`tbl_daily_activity`.`waktu_submit`)";
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
				absensi_new.`tbl_daily_activity`.`id`
				, absensi_new.`tbl_daily_activity`.`submit_date`
				, absensi_new.`tbl_daily_activity`.`waktu_submit`
				, absensi_new.`tbl_daily_activity`.`nik`
				, absensi_new.`tbl_karyawan_struktur`.`nama_karyawan_struktur`
				, absensi_new.`tbl_jabatan_karyawan`.`jabatan_karyawan`
				, absensi_new.`tbl_karyawan_struktur`.`level_struktur`
				, absensi_new.`tbl_karyawan_struktur`.`lokasi_struktur`
				, absensi_new.`tbl_karyawan_struktur`.`dept_struktur`
				, absensi_new.`tbl_daily_activity`.`status_lokasi` AS status_lokasi
				, absensi_new.`tbl_daily_activity`.`lokasi` AS lokasi
				, absensi_new.`tbl_daily_activity`.`keterangan`
				, absensi_new.`tbl_daily_activity`.`lat` AS lat
				, absensi_new.`tbl_daily_activity`.`lon` AS lon
					FROM absensi_new.`tbl_daily_activity`
					INNER JOIN absensi_new.`tbl_karyawan_struktur`
						ON absensi_new.`tbl_daily_activity`.`nik` = absensi_new.`tbl_karyawan_struktur`.`nik_baru`
					INNER JOIN absensi_new.`tbl_jabatan_karyawan`
						ON absensi_new.`tbl_karyawan_struktur`.`jabatan_struktur` = absensi_new.`tbl_jabatan_karyawan`.`no_jabatan_karyawan`
					WHERE absensi_new.`tbl_daily_activity`.`nik` = '$nik'
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) >= '$tanggal1'
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) <= '$tanggal2'
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-14') 
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-13') 
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-12') 
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-11') 
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-10')
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-09')
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-08')
					AND DATE(absensi_new.`tbl_daily_activity`.`waktu_submit`) NOT IN ('2021-09-07') 
					GROUP BY absensi_new.`tbl_daily_activity`.`keterangan`
					ORDER BY absensi_new.`tbl_daily_activity`.`waktu_submit` DESC";
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