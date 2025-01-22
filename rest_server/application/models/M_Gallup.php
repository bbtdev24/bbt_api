<?php

/**
 * 
 */
class M_Gallup extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function getGallup($nik = null, $depo = null, $pt = null, $jabatan = null, $dept = null)
	{
		$where = " `tbl_karyawan_struktur`.`nik_baru` NOT LIKE '%.%'
            AND `tbl_karyawan_struktur`.`status_karyawan` = '0'
            AND `tbl_karyawan_struktur`.`nik_baru` <> 'victor' 
            AND `tbl_karyawan_struktur`.`nik_baru` <> '12345'
            AND (`tbl_karyawan_struktur`.`perusahaan_struktur` <> 'MPB PAKET'
            AND `tbl_karyawan_struktur`.`perusahaan_struktur` <> 'SDUP'
            AND `tbl_karyawan_struktur`.`perusahaan_struktur` <> 'BSP')";
        if ($nik!='') {
            $where .= " and `tbl_karyawan_struktur`.`nik_baru` = '$nik'";
        }
        if ($depo!='') {
            $where .= "  and `tbl_karyawan_struktur`.`lokasi_struktur` = '$depo'";
        }
        if ($jabatan!='') {
            $where .= "  and `tbl_karyawan_struktur`.`jabatan_struktur` = '$jabatan'";
        }
        if ($dept!='') {
            $where .= "  and `tbl_karyawan_struktur`.`dept_struktur` = '$dept'";
        }
        if ($pt!='') {
            $where .= "  and `tbl_karyawan_struktur`.perusahaan_struktur = '$pt'";
        }

        $sql = "
            SELECT
                tbl_penilaian.`nik_baru`
                , tbl_penilaian.`nama_karyawan_struktur`
                , tbl_penilaian.`jabatan_karyawan`
                , tbl_penilaian.`jabatan_struktur`
                , tbl_penilaian.`dept_struktur`
                , tbl_penilaian.`lokasi_struktur`
                , tbl_penilaian.`join_date_struktur`
                , tbl_penilaian.`perusahaan_struktur`
                , tbl_penilaian.`masa_kerja`
                , tbl_penilaian.`assesor_1`
                , tbl_penilaian.`assesor_2`
                , tbl_penilaian.`nilai`
                , CASE
                WHEN tbl_penilaian.`nilai` >= 57
                    THEN 'A'
                WHEN tbl_penilaian.`nilai` >= 38 AND tbl_penilaian.`nilai` <= 56
                    THEN 'B'
                WHEN tbl_penilaian.`nilai` >= 19 AND tbl_penilaian.`nilai` <= 37
                    THEN 'C'
                WHEN tbl_penilaian.`nilai` <= 18 AND tbl_penilaian.`nilai` > 0
                    THEN 'D'
                ELSE NULL
                END AS hasil_akhir
                , CASE
                WHEN tbl_penilaian.`nilai` >= 57
                    THEN 'Sangat Baik'
                WHEN tbl_penilaian.`nilai` >= 38 AND tbl_penilaian.`nilai` <= 56
                    THEN 'Baik'
                WHEN tbl_penilaian.`nilai` >= 19 AND tbl_penilaian.`nilai` <= 37
                    THEN 'Kurang Baik'
                WHEN tbl_penilaian.`nilai` <= 18 AND tbl_penilaian.`nilai` > 0
                    THEN 'Tidak Baik'
                ELSE NULL
                END AS kesimpulan
            FROM (SELECT 
                tbl_karyawan.`nik_baru`
                , tbl_karyawan.`nama_karyawan_struktur`
                , tbl_karyawan.`jabatan_karyawan`
                , tbl_karyawan.`jabatan_struktur`
                , tbl_karyawan.`lokasi_struktur`
                , tbl_karyawan.`dept_struktur`
                , tbl_karyawan.`join_date_struktur`
                , tbl_karyawan.`perusahaan_struktur`
                , tbl_karyawan.`masa_kerja`
                , IFNULL((SELECT SUM(`tbl_karyawan_gallup_essay`.`angka_mutu_atasan`)
                FROM `tbl_karyawan_gallup_essay`
                LEFT JOIN `tbl_pertanyaan_gallup_essay`
                    ON `tbl_pertanyaan_gallup_essay`.`no_pertanyaan` = `tbl_karyawan_gallup_essay`.`pertanyaan`
                WHERE `tbl_karyawan_gallup_essay`.`nik_baru` = tbl_karyawan.`nik_baru`
                AND `tbl_pertanyaan_gallup_essay`.`status` = '0'),0) AS assesor_1
                
                , IFNULL((SELECT SUM(`tbl_karyawan_gallup_essay`.`angka_mutu_atasan_2`)
                FROM `tbl_karyawan_gallup_essay`
                LEFT JOIN `tbl_pertanyaan_gallup_essay`
                    ON `tbl_pertanyaan_gallup_essay`.`no_pertanyaan` = `tbl_karyawan_gallup_essay`.`pertanyaan`
                WHERE `tbl_karyawan_gallup_essay`.`nik_baru` = tbl_karyawan.`nik_baru`
                AND `tbl_pertanyaan_gallup_essay`.`status` = '0'),0) AS assesor_2
                
                , (IFNULL((SELECT SUM(`tbl_karyawan_gallup_essay`.`angka_mutu_atasan`)
                FROM `tbl_karyawan_gallup_essay`
                LEFT JOIN `tbl_pertanyaan_gallup_essay`
                    ON `tbl_pertanyaan_gallup_essay`.`no_pertanyaan` = `tbl_karyawan_gallup_essay`.`pertanyaan`
                WHERE `tbl_karyawan_gallup_essay`.`nik_baru` = tbl_karyawan.`nik_baru`
                AND `tbl_pertanyaan_gallup_essay`.`status` = '0'),0) + 
                IFNULL((SELECT SUM(`tbl_karyawan_gallup_essay`.`angka_mutu_atasan_2`)
                FROM `tbl_karyawan_gallup_essay`
                LEFT JOIN `tbl_pertanyaan_gallup_essay`
                    ON `tbl_pertanyaan_gallup_essay`.`no_pertanyaan` = `tbl_karyawan_gallup_essay`.`pertanyaan`
                WHERE `tbl_karyawan_gallup_essay`.`nik_baru` = tbl_karyawan.`nik_baru`
                AND `tbl_pertanyaan_gallup_essay`.`status` = '0'),0)) / 2 AS nilai
            FROM (SELECT 
                `tbl_karyawan_struktur`.`nik_baru`
                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
                , `tbl_karyawan_struktur`.`jabatan_struktur`
                , `tbl_karyawan_struktur`.`lokasi_struktur`
                , `tbl_karyawan_struktur`.`dept_struktur`
                , `tbl_karyawan_struktur`.`perusahaan_struktur`
                , `tbl_karyawan_struktur`.`join_date_struktur`
                , DATEDIFF('2021-01-20', `tbl_karyawan_struktur`.`join_date_struktur`) AS masa_kerja
            FROM `tbl_karyawan_struktur`
            INNER JOIN `tbl_jabatan_karyawan`
                ON `tbl_karyawan_struktur`.`jabatan_struktur` = `tbl_jabatan_karyawan`.`no_jabatan_karyawan`
            WHERE $where) tbl_karyawan
            WHERE tbl_karyawan.`masa_kerja` >= '364'
            ORDER BY tbl_karyawan.`nik_baru` ASC ) tbl_penilaian
        ";
        $hasil = $this->db->query($sql);
        return $hasil->result_array();

	}

    public function getSurvey($nik = null, $depo = null, $pt = null, $jabatan = null, $dept = null, $tahun = null)
    {
        $where = " `tbl_karyawan_struktur`.`status_karyawan` = '0'
            AND (`tbl_karyawan_struktur`.`perusahaan_struktur` <> 'MPB PAKET'
            AND `tbl_karyawan_struktur`.`perusahaan_struktur` <> 'SDUP'
            AND `tbl_karyawan_struktur`.`perusahaan_struktur` <> 'BSP')
            AND DATEDIFF('2021-01-20', `tbl_karyawan_struktur`.`join_date_struktur`) >= '364'";
        if ($nik!='') {
            $where .= " and `tbl_karyawan_struktur`.`nik_baru` = '$nik'";
        }
        if ($depo!='') {
            $where .= "  and `tbl_karyawan_struktur`.`lokasi_struktur` = '$depo'";
        }
        if ($jabatan!='') {
            $where .= "  and `tbl_karyawan_struktur`.`jabatan_struktur` = '$jabatan'";
        }
        if ($dept!='') {
            $where .= "  and `tbl_karyawan_struktur`.`dept_struktur` = '$dept'";
        }
        if ($pt!='') {
            $where .= "  and `tbl_karyawan_struktur`.perusahaan_struktur = '$pt'";
        }
        if ($tahun!='') {
            $where .= "  and `tbl_karyawan_gallup`.`tahun` = '$tahun'";
        }

        $sql = "
            SELECT 
                `tbl_karyawan_struktur`.`nik_baru`
                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
                , `tbl_karyawan_struktur`.`lokasi_struktur`
                , `tbl_karyawan_struktur`.`dept_struktur`
                , `tbl_karyawan_struktur`.`perusahaan_struktur`
                , `tbl_karyawan_gallup`.`tahun`
                , `tbl_karyawan_gallup`.`jawaban_1`
                , `tbl_karyawan_gallup`.`jawaban_2`
                , `tbl_karyawan_gallup`.`jawaban_3`
                , `tbl_karyawan_gallup`.`jawaban_4`
                , `tbl_karyawan_gallup`.`jawaban_5`
                , `tbl_karyawan_gallup`.`jawaban_6`
                , `tbl_karyawan_gallup`.`jawaban_7`
                , `tbl_karyawan_gallup`.`jawaban_8`
                , `tbl_karyawan_gallup`.`jawaban_9`
                , `tbl_karyawan_gallup`.`jawaban_10`
                , `tbl_karyawan_gallup`.`jawaban_11`
                , `tbl_karyawan_gallup`.`jawaban_12`
                , DATEDIFF('2021-10-12', `tbl_karyawan_struktur`.`join_date_struktur`) AS masa_kerja
            FROM `tbl_karyawan_gallup`
            INNER JOIN `tbl_karyawan_struktur`
                ON `tbl_karyawan_struktur`.`nik_baru` = `tbl_karyawan_gallup`.`nik_baru`
            INNER JOIN `tbl_jabatan_karyawan`
                ON `tbl_jabatan_karyawan`.`no_jabatan_karyawan` = `tbl_karyawan_struktur`.`jabatan_struktur`
            WHERE $where
        ";
        $hasil = $this->db->query($sql);
        return $hasil->result_array();

    }

    public function getSurvey_saran($nik = null, $depo = null, $pt = null, $jabatan = null, $dept = null, $tahun = null)
    {
        $where = " `tbl_karyawan_struktur`.`status_karyawan` = '0'
            AND (`tbl_karyawan_struktur`.`perusahaan_struktur` <> 'MPB PAKET'
            AND `tbl_karyawan_struktur`.`perusahaan_struktur` <> 'SDUP'
            AND `tbl_karyawan_struktur`.`perusahaan_struktur` <> 'BSP')
            AND DATEDIFF('2021-01-20', `tbl_karyawan_struktur`.`join_date_struktur`) >= '364'";
        if ($nik!='') {
            $where .= " and `tbl_karyawan_struktur`.`nik_baru` = '$nik'";
        }
        if ($depo!='') {
            $where .= "  and `tbl_karyawan_struktur`.`lokasi_struktur` = '$depo'";
        }
        if ($jabatan!='') {
            $where .= "  and `tbl_karyawan_struktur`.`jabatan_struktur` = '$jabatan'";
        }
        if ($dept!='') {
            $where .= "  and `tbl_karyawan_struktur`.`dept_struktur` = '$dept'";
        }
        if ($pt!='') {
            $where .= "  and `tbl_karyawan_struktur`.perusahaan_struktur = '$pt'";
        }
        if ($tahun!='') {
            $where .= "  and `tbl_karyawan_gallup_saran`.`tahun` = '$tahun'";
        }

        $sql = "
            SELECT 
                `tbl_karyawan_struktur`.`nik_baru`
                , `tbl_karyawan_struktur`.`nama_karyawan_struktur`
                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
                , `tbl_karyawan_struktur`.`lokasi_struktur`
                , `tbl_karyawan_struktur`.`dept_struktur`
                , `tbl_karyawan_struktur`.`perusahaan_struktur`
                , `tbl_karyawan_gallup_saran`.`nomor_saran`
                , `tbl_karyawan_gallup_saran`.`saran`
                , `tbl_karyawan_gallup_saran`.`tahun`
                , DATEDIFF('2021-01-20', `tbl_karyawan_struktur`.`join_date_struktur`) AS masa_kerja
            FROM `tbl_karyawan_gallup_saran`
            INNER JOIN `tbl_karyawan_struktur`
                ON `tbl_karyawan_struktur`.`nik_baru` = `tbl_karyawan_gallup_saran`.`nik_baru`
            INNER JOIN `tbl_jabatan_karyawan`
                ON `tbl_jabatan_karyawan`.`no_jabatan_karyawan` = `tbl_karyawan_struktur`.`jabatan_struktur`
            WHERE $where
        ";
        $hasil = $this->db->query($sql);
        return $hasil->result_array();

    }

    public function getKaryawan($id = null)
    {
        // return $this->db->get('tbl_user')->result_array();
        if ($id === null) {
            $this->db2->select("ks.`nik_baru`
                , ks.`nama_karyawan_struktur`
                , ks.`lokasi_struktur`
                , jk.`jabatan_karyawan`
                , ks.`dept_struktur`
                , ks.`join_date_struktur`
                , DATEDIFF('2021-01-20', ks.`join_date_struktur`) AS masa_kerja");
            $this->db2->from('tbl_karyawan_struktur ks');
            $this->db2->join('tbl_karyawan_induk ki ', 
                'ki.nik_baru=ks.nik_baru', 'inner');
            $this->db2->join('tbl_jabatan_karyawan jk', 
                'jk.no_jabatan_karyawan=ks.jabatan_struktur', 'inner');
            $this->db2->where("ks.`status_karyawan` = '0'
                AND (ks.`nik_baru` NOT LIKE '%.%'
                AND ks.`nik_baru` NOT LIKE '%12345%')
                AND (ks.`perusahaan_struktur` <> 'MPB PAKET'
                AND ks.`perusahaan_struktur` <> 'SDUP'
                AND ks.`perusahaan_struktur` <> 'BSP')
                AND DATEDIFF('2021-01-20', ks.`join_date_struktur`) >= '364'");

            $get = $this->db2->get();
            return $get->result_array();
        } else {
            $this->db2->select("ks.`nik_baru`
                , ks.`nama_karyawan_struktur`
                , ks.`lokasi_struktur`
                , jk.`jabatan_karyawan`
                , ks.`dept_struktur`
                , ks.`join_date_struktur`
                , DATEDIFF('2021-01-20', ks.`join_date_struktur`) AS masa_kerja");
            $this->db2->from('tbl_karyawan_struktur ks');
            $this->db2->join('tbl_karyawan_induk ki ', 
                'ki.nik_baru=ks.nik_baru', 'inner');
            $this->db2->join('tbl_jabatan_karyawan jk', 
                'jk.no_jabatan_karyawan=ks.jabatan_struktur', 'inner');
            $this->db2->where("ks.lokasi_struktur = '$id'
                AND ks.`status_karyawan` = '0'
                AND (ks.`nik_baru` NOT LIKE '%.%'
                AND ks.`nik_baru` NOT LIKE '%12345%')
                AND (ks.`perusahaan_struktur` <> 'MPB PAKET'
                AND ks.`perusahaan_struktur` <> 'SDUP'
                AND ks.`perusahaan_struktur` <> 'BSP')
                AND DATEDIFF('2021-01-20', ks.`join_date_struktur`) >= '364'");

            $get = $this->db2->get();
            return $get->result_array();
        }
    }

}

?>