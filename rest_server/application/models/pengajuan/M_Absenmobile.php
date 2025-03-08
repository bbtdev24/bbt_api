<?php

/**
 * 
 */
class M_Absenmobile extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getKeterangan($nik_baru = null, $tanggal = null)
	{
		$sql="SELECT * FROM tbl_karyawan_wfh WHERE nik_baru = '$nik_baru' AND tanggal LIKE '%$tanggal%'";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
		
	}

	public function getKeterangan3($nik_baru = null)
	{
		$sql="SELECT * FROM tbl_karyawan_wfh WHERE nik_baru = '$nik_baru' ";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
		
	}

	public function getKaryawanTKBM($lokasi = null)
	{
		$staticstart = date('Y-m-d',strtotime('last Monday'));  
		$staticfinish = date('Y-m-d',strtotime('next Sunday'));

		$sql="SELECT 
				  a.id,
				  a.submit_date,
				  a.`perusahaan`,
				  a.nik,
				  b.`nama_karyawan_struktur`,
				  b.lokasi_hrd AS lokasi,
				  a.start_date,
				  a.end_date 
				FROM
				  tbl_karyawan_tkbm a 
				  LEFT JOIN tbl_karyawan_struktur b 
				    ON a.`nik` = b.`nik_baru` 
				WHERE a.`lokasi` = '$lokasi' 
				 -- AND a.`start_date` >= '$staticstart'
				 -- AND a.`start_date` <= '$staticfinish'
				GROUP BY a.`nik`
				ORDER BY b.`nama_karyawan_struktur` ASC";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function getNikKaryawanTKBM($nik_baru = null)
	{
		$sql="SELECT
				a.id,
				a.submit_date,
				a.nik,
				b.`nama_karyawan_struktur`,
				b.lokasi_hrd as lokasi,
				a.start_date,
				a.end_date
					FROM tbl_karyawan_tkbm a
					LEFT JOIN tbl_karyawan_struktur b
						ON a.`nik` = b.`nik_baru`
					WHERE a.nik = '$nik_baru'
					GROUP BY a.`nik` ";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function getKeteranganhariini($nik_baru = null)
	{
		$sql="SELECT * FROM tbl_karyawan_wfh 
			WHERE nik_baru = '$nik_baru'
			AND tanggal >= CURDATE() AND tanggal < CURDATE() + INTERVAL 1 DAY ";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
		
	}

	public function getAbsenKbkm($nik_ktp = null, $tanggal = null)
	{
		$sql="SELECT * FROM tarikan_absen_tkbm 
			WHERE nik = '$nik_ktp'
				AND DATE(shift_day) = '$tanggal' ";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function cekAbsenKbkm($nik_ktp = null) 
	{
		$sql="SELECT * FROM tbl_absen_gigo WHERE nik = '$nik_ktp' ORDER BY time DESC LIMIT 0, 1";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function getDataAbsen($nik_ktp = null) 
	{
		$sql="SELECT * FROM tbl_absen_gigo WHERE nik = '$nik_ktp' ORDER BY TIME DESC ";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();
	}

	public function getCheckAbsen($tanggal1 = null, $tanggal2 = null, $nik = null) 
	{
		$sql="SELECT 
  tbl_final.`shift_day`,
  tbl_final.`nik`,
  tbl_final.`nama_karyawan_struktur`,
  tbl_final.`jabatan_karyawan`,
  tbl_final.minimum_in,
  tbl_final.f1 AS `F1`,
  tbl_final.depo_f1 AS `depo_f1`,
  tbl_final.longlat_f1 AS `longlat_f1`,
  tbl_final.waktu_masuk,
  tbl_final.waktu_keluar,
  tbl_final.f4 AS `F4`,
  tbl_final.depo_f4 AS `depo_f4`,
  tbl_final.longlat_f4 AS `longlat_f4`,
  tbl_final.maximum_out,
  CASE
    WHEN tbl_final.`ket_izin` IS NOT NULL 
    THEN tbl_final.`ket_izin` 
    WHEN tbl_final.f1 = 'OFF' 
    AND tbl_final.f4 = 'OFF' 
    THEN 'LI' 
    WHEN (
      tbl_final.f1 >= tbl_final.minimum_in
    ) 
    AND (
      tbl_final.f1 <= tbl_final.waktu_masuk
    ) 
    AND (
      tbl_final.f4 <= tbl_final.maximum_out
    ) 
    AND (
      tbl_final.f4 >= tbl_final.waktu_keluar
    ) 
    THEN 'HD' 
    WHEN (
      tbl_final.f1 >= tbl_final.minimum_in
    ) 
    AND (
      tbl_final.f1 > tbl_final.waktu_masuk
    ) 
    AND (
      tbl_final.f4 <= tbl_final.maximum_out
    ) 
    AND (
      tbl_final.f4 >= tbl_final.waktu_keluar
    ) 
    THEN 'TL' 
    WHEN (
      tbl_final.f1 IS NULL 
      AND tbl_final.f4 IS NULL
    ) 
    AND (
      tbl_final.`waktu_shift` IS NULL 
      AND DAYNAME(DATE(tbl_final.`shift_day`)) = 'Sunday'
    ) 
    THEN 'LI' 
    WHEN tbl_final.birth_date = tbl_final.`shift_day` 
    AND tbl_final.`waktu_shift` IS NULL 
    THEN 'LI' 
    WHEN tbl_final.f1 IS NULL 
    AND tbl_final.f4 IS NULL 
    THEN 'AL' 
    WHEN tbl_final.f1 IS NULL 
    THEN 'TD F1' 
    WHEN tbl_final.f4 IS NULL 
    THEN 'TD F4' 
    WHEN (
      tbl_final.f1 >= tbl_final.minimum_in
    ) 
    AND (
      tbl_final.f1 > tbl_final.waktu_masuk
    ) 
    AND (
      tbl_final.f4 <= tbl_final.maximum_out
    ) 
    AND (
      tbl_final.f4 < tbl_final.waktu_keluar
    ) 
    THEN 'F4 Tidak Sesuai' 
    ELSE 'Tidak Sesuai Jadwal' 
  END AS `ket_absensi`,
  CASE
    WHEN (
      tbl_final.f1 >= tbl_final.minimum_in
    ) 
    AND (
      tbl_final.f1 > tbl_final.waktu_masuk
    ) 
    AND (
      tbl_final.f4 <= tbl_final.maximum_out
    ) 
    AND (
      tbl_final.f4 >= tbl_final.waktu_keluar
    ) 
    THEN TIMEDIFF(
      tbl_final.waktu_masuk,
      tbl_final.f1
    ) 
    ELSE '' 
  END AS `waktu_telat` 
FROM
  (SELECT 
    absensi_new.`tarikan_absen_tkbm`.`shift_day`,
    absensi_new.`tarikan_absen_tkbm`.`nik`,
    absensi_new.`tbl_karyawan_struktur`.`nama_karyawan_struktur`,
    absensi_new.`tbl_jabatan_karyawan`.`jabatan_karyawan`,
    absensi_new.`tbl_jabatan_karyawan`.`no_jabatan_karyawan`,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '7' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' ',
          TIME_FORMAT(
            absensi_new.tbl_shifting.waktu_masuk,
            '%H:%i:%S'
          )
        ) AS DATETIME
      ) - INTERVAL 4 HOUR 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' ',
          TIME_FORMAT(
            absensi_new.tbl_shifting.waktu_masuk,
            '%H:%i:%S'
          )
        ) AS DATETIME
      ) - INTERVAL 5 HOUR 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '28' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' ',
          TIME_FORMAT(
            absensi_new.tbl_shifting.waktu_masuk,
            '%H:%i:%S'
          )
        ) AS DATETIME
      ) - INTERVAL 5 HOUR 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` IS NOT NULL 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' ',
          TIME_FORMAT(
            absensi_new.tbl_shifting.waktu_masuk,
            '%H:%i:%S'
          )
        ) AS DATETIME
      ) - INTERVAL 5 HOUR 
      ELSE CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 04:00:01'
        ) AS DATETIME
      ) 
    END AS minimum_in,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '18' 
      THEN 'OFF' 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` IS NULL 
      THEN 
      (SELECT 
        MIN(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 04:00:01'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:00:59'
          ) AS DATETIME
        )) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
      THEN 
      (SELECT 
        MIN(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '22:00:00'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '22:00:00'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '24' 
      THEN 
      (SELECT 
        MIN(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '13:00:00'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '13:00:00'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
      THEN 
      (SELECT 
        MIN(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '30' 
      THEN 
      (SELECT 
        MIN(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '03:00:00'
            )
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      ELSE 
      (SELECT 
        MIN(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR) 
    END AS `f1`,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` IS NULL 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 04:00:01'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:00:59'
          ) AS DATETIME
        ) 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
      AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
      THEN 
      (SELECT 
        masuk_malem.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '22:00:00'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '22:00:00'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
      AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '24' 
      THEN 
      (SELECT 
        masuk_malem.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '13:00:00'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '13:00:00'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
      THEN 
      (SELECT 
        masuk_malem.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '30' 
      THEN 
      (SELECT 
        masuk_malem.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '03:00:00'
            )
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      ELSE 
      (SELECT 
        masuk_malem.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
    END AS `depo_f1`,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` IS NULL 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 04:00:01'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:00:59'
          ) AS DATETIME
        ) 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
      AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_malem.`lat`,
          ',',
          masuk_malem.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '22:00:00'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '22:00:00'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
      AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '24' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_malem.`lat`,
          ',',
          masuk_malem.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '13:00:00'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '13:00:00'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_malem.`lat`,
          ',',
          masuk_malem.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '30' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_malem.`lat`,
          ',',
          masuk_malem.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '03:00:00'
            )
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      ELSE 
      (SELECT 
        CONCAT(
          masuk_malem.`lat`,
          ',',
          masuk_malem.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_malem 
      WHERE masuk_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND masuk_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_masuk,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
    END AS `longlat_f1`,
    CAST(
      CONCAT(
        CASE
          WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
          THEN DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ) 
          ELSE DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ) 
        END,
        ' ',
        CASE
          WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
          AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
          THEN '22:00:00' 
          WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
          AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '24' 
          THEN '13:00:00' 
          WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` IS NULL 
          THEN '08:00:00' 
          ELSE TIME_FORMAT(
            absensi_new.tbl_shifting.waktu_masuk,
            '%H:%i:%S'
          ) 
        END
      ) AS DATETIME
    ) AS waktu_masuk,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '16' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 07:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
      AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 07:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
      AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '24' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 22:00:00'
        ) AS DATETIME
      ) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 06:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 08:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '27' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 01:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '28' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 06:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '29' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 01:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '30' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 08:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '31' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 04:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '35' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 05:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '37' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 08:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      ELSE CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' ',
          CASE
            WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` IS NULL 
            THEN '17:00:00' 
            ELSE TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_keluar,
              '%H:%i:%S'
            ) 
          END
        ) AS DATETIME
      ) 
    END AS waktu_keluar,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '18' 
      THEN 'OFF' 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '16' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 03:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 11:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
      AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '24' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 18:00:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 02:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 02:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 10:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 03:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 13:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '27' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 09:00:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 05:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '28' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 02:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 11:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '29' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 21:00:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 05:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '30' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 04:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '31' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 00:00:01'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 08:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '35' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 01:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 09:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '37' 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 04:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` IS NULL 
      THEN 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:01:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 23:59:59'
          ) AS DATETIME
        )) 
      ELSE 
      (SELECT 
        MAX(`time`) 
      FROM
        absensi_new.`tbl_absen_gigo` keluar_malem 
      WHERE keluar_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND keluar_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_keluar,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND keluar_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_keluar,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR) 
    END AS `f4`,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '16' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 03:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 11:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
      AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '24' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 18:00:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 02:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 02:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 10:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 03:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 13:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '27' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 09:00:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 05:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '28' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 02:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 11:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '29' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 21:00:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 05:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '30' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 04:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '31' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 00:00:01'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 08:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '35' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 01:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 09:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '37' 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 04:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` IS NULL 
      THEN 
      (SELECT 
        masuk_normal.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:01:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 23:59:59'
          ) AS DATETIME
        ) 
      LIMIT 0, 1) 
      ELSE 
      (SELECT 
        keluar_malem.`lokasi` 
      FROM
        absensi_new.`tbl_absen_gigo` keluar_malem 
      WHERE keluar_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND keluar_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_keluar,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND keluar_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_keluar,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
    END AS `depo_f4`,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '16' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 03:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 11:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`shift_day` <= '2020-05-30' 
      AND absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '24' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 18:00:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 02:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 02:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 10:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 03:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 13:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '27' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 09:00:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 05:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '28' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 02:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 11:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '29' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 21:00:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 05:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '30' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 04:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '31' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 00:00:01'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 08:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '35' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 01:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 09:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '37' 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 04:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:00:00'
          ) AS DATETIME
        ) + INTERVAL 1 DAY 
      LIMIT 0, 1) 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` IS NULL 
      THEN 
      (SELECT 
        CONCAT(
          masuk_normal.`lat`,
          ',',
          masuk_normal.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` masuk_normal 
      WHERE masuk_normal.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND masuk_normal.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 12:01:00'
          ) AS DATETIME
        ) 
        AND masuk_normal.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' 23:59:59'
          ) AS DATETIME
        ) 
      LIMIT 0, 1) 
      ELSE 
      (SELECT 
        CONCAT(
          keluar_malem.`lat`,
          ',',
          keluar_malem.`lon`
        ) AS longlat 
      FROM
        absensi_new.`tbl_absen_gigo` keluar_malem 
      WHERE keluar_malem.nik = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
        AND keluar_malem.time >= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_keluar,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) - INTERVAL 4 HOUR 
        AND keluar_malem.time <= CAST(
          CONCAT(
            DATE(
              absensi_new.`tarikan_absen_tkbm`.`shift_day`
            ),
            ' ',
            TIME_FORMAT(
              absensi_new.tbl_shifting.waktu_keluar,
              '%H:%i:%S'
            )
          ) AS DATETIME
        ) + INTERVAL 4 HOUR 
      LIMIT 0, 1) 
    END AS `longlat_f4`,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '9' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' ',
          TIME_FORMAT(
            absensi_new.tbl_shifting.waktu_keluar,
            '%H:%i:%S'
          )
        ) AS DATETIME
      ) + INTERVAL 4 HOUR 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '12' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 03:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '14' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 02:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '16' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 11:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '21' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 10:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '25' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 12:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '27' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 05:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '28' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 11:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '29' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 05:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '30' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 12:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '31' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 08:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '35' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 09:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      WHEN absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = '37' 
      THEN CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 12:00:00'
        ) AS DATETIME
      ) + INTERVAL 1 DAY 
      ELSE CAST(
        CONCAT(
          DATE(
            absensi_new.`tarikan_absen_tkbm`.`shift_day`
          ),
          ' 23:59:59'
        ) AS DATETIME
      ) 
    END AS maximum_out,
    absensi_new.`tarikan_absen_tkbm`.`waktu_shift`,
    CASE
      WHEN absensi_new.`tarikan_absen_tkbm`.`ket_tambahan` IS NOT NULL 
      THEN absensi_new.`tarikan_absen_tkbm`.`ket_tambahan` 
    END AS ket_izin,
    absensi_new.`tmp_events`.`birth_date`,
    absensi_new.`tbl_jabatan_karyawan`.`area` 
  FROM
    absensi_new.`tarikan_absen_tkbm` 
    LEFT JOIN absensi_new.`tbl_shifting` 
      ON absensi_new.`tarikan_absen_tkbm`.`waktu_shift` = absensi_new.`tbl_shifting`.`id_shifting` 
    INNER JOIN absensi_new.`tbl_karyawan_struktur` 
      ON absensi_new.`tarikan_absen_tkbm`.`nik` = absensi_new.`tbl_karyawan_struktur`.`nik_baru` 
    INNER JOIN absensi_new.`tbl_jabatan_karyawan` 
      ON absensi_new.`tbl_karyawan_struktur`.`jabatan_hrd` = absensi_new.`tbl_jabatan_karyawan`.`no_jabatan_karyawan` 
    LEFT JOIN absensi_new.`tmp_events` 
      ON absensi_new.`tmp_events`.`birth_date` = absensi_new.`tarikan_absen_tkbm`.`shift_day` 
  WHERE DATE(
      absensi_new.`tarikan_absen_tkbm`.`shift_day`
    ) >= '$tanggal1' 
    AND DATE(
      absensi_new.`tarikan_absen_tkbm`.`shift_day`
    ) <= '$tanggal2' 
    AND absensi_new.`tarikan_absen_tkbm`.`nik` = '$nik' 
  GROUP BY absensi_new.`tbl_karyawan_struktur`.`nik_baru`,
    absensi_new.`tarikan_absen_tkbm`.`shift_day`) tbl_final 
ORDER BY tbl_final.`shift_day` DESC ";
	    $hasil = $this->db2->query($sql);
	    return $hasil->result_array();

	}

	public function getAbsen($nik_baru = null, $shift_day = null)
	{
		if ($nik_baru === null) {
			$sql="SELECT 
				absensi_new.`tarikan_absen_adms`.`shift_day`
				, absensi_new.`tarikan_absen_adms`.`badgenumber` AS nik_baru
				, absensi_new.`tarikan_absen_adms`.`userid` 
				, absensi_new.`tarikan_absen_adms`.`in_manual` 
				, absensi_new.`tarikan_absen_adms`.`out_manual`
			FROM absensi_new.`tarikan_absen_adms`
			ORDER BY absensi_new.`tarikan_absen_adms`.`userid` DESC
			LIMIT 0, 1";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		} else {
			$sql="SELECT 
				absensi_new.`tarikan_absen_adms`.`shift_day`
				, absensi_new.`tarikan_absen_adms`.`badgenumber` AS nik_baru
				, absensi_new.`tarikan_absen_adms`.`userid` 
				, absensi_new.`tarikan_absen_adms`.`in_manual` 
				, absensi_new.`tarikan_absen_adms`.`out_manual`
			FROM absensi_new.`tarikan_absen_adms`
			WHERE absensi_new.`tarikan_absen_adms`.`badgenumber` = '$nik_baru' AND
			absensi_new.`tarikan_absen_adms`.`shift_day` = '$shift_day'
			ORDER BY absensi_new.`tarikan_absen_adms`.`userid` DESC
			LIMIT 0, 1";
	        $hasil = $this->db2->query($sql);
	    	return $hasil->result_array();
		}
	}

	public function updateJam($data, $id, $shift_day)
	{
		$this->db2->update('tarikan_absen_adms', $data, ['userid' => $id, 'shift_day' => $shift_day]);
		return $this->db2->affected_rows();
	}

	public function updateJamKbkm($data, $nik_ktp, $shift_day)
	{
		$this->db2->update('tarikan_absen_tkbm', $data, ['nik' => $nik_ktp, 'shift_day' => $shift_day]);
		return $this->db2->affected_rows();
	}

	public function createAbsenManual($data)
	{
		if ($data['nik'] != '0100038100' AND $data['nik'] != '1117009400') {
			$this->db3->insert('absen', $data);
			return $this->db3->affected_rows();
		}
	}

	public function createKeterangan($data)
	{
		$this->db2->insert('tbl_karyawan_wfh', $data);
		return $this->db2->affected_rows();
	}

	public function updateketerangan($data, $id)
	{
		$this->db2->update('tbl_karyawan_wfh', $data, ['id' => $id]);
		return $this->db2->affected_rows();
	}

	public function createtbkm($data)
	{
		$this->db2->insert('tbl_absen_gigo', $data);
		return $this->db2->affected_rows();
	}


  public function updateJam_new($data, $id, $shift_day)
  {
    $this->db_absensi->update('tarikan_absen_adms', $data, ['badgenumber' => $id, 'shift_day' => $shift_day]);
    return $this->db_absensi->affected_rows();
  }

}

?>