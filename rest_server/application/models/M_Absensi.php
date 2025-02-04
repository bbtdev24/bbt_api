<?php

/**
 * 
 */
class M_Absensi extends CI_Model
{

    public function __construct()
    {
                    $this->absensi = $this->config->item('db_absensi');
                    $this->payroll = $this->config->item('db_payroll');
                    $this->adms = $this->config->item('db_adms');
    }

    public function getKeteranganMasukMobile($nik_baru = null, $tanggal = null)
    {
        $sql = "SELECT * FROM absen a WHERE a.nik = '$nik_baru' AND a.`time` LIKE '%$tanggal%' AND kat ='masuk'
			ORDER BY a.`time`
			DESC
			LIMIT 0, 1";
        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }

    public function getKeteranganKeluarMobile($nik_baru = null, $tanggal = null)
    {
        $sql = "SELECT * FROM absen a WHERE 
			a.nik = '$nik_baru' AND a.`time` LIKE '%$tanggal%' AND kat ='keluar'
			ORDER BY a.`time`
			DESC
			LIMIT 0, 1";
        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }

    public function getAbsensi($tanggal1 = null, $tanggal2 = null, $nik = null, $depo = null, $pt = null, $jabatan = null, $dept = null)
    {
        $where = " DATE(`tarikan_absen_adms`.`shift_day`) >= '$tanggal1' AND DATE(`tarikan_absen_adms`.`shift_day`) <= '$tanggal2'";
        if ($nik != '') {
            $where .= " and `tarikan_absen_adms`.`badgenumber` = '$nik'";
        }
        if ($depo != '') {
            $where .= "  and `tbl_karyawan_struktur`.`lokasi_struktur` = '$depo'";
        }
        if ($jabatan != '') {
            $where .= "  and tbl_karyawan_struktur.jabatan_struktur = '$jabatan'";
        }
        if ($dept != '') {
            $where .= "  and tbl_karyawan_struktur.dept_struktur = '$dept'";
        }
        if ($pt != '') {
            $where .= "  and tbl_karyawan_struktur.perusahaan_struktur = '$pt'";
        }

        $sql = "
            SELECT
                tbl_final.`shift_day`
                , tbl_final.`badgenumber`
                , tbl_final.`name`
                , tbl_final.`jabatan_karyawan`
                , tbl_final.`lokasi_struktur`
                , tbl_final.`dept_struktur`
                , tbl_final.`join_date_struktur`
                , tbl_final.minimum_in
                , tbl_final.f1 AS `F1`
                , tbl_final.depo_f1 AS `depo_f1`
                , tbl_final.waktu_masuk
                , tbl_final.waktu_keluar
                , tbl_final.f4 AS `F4`
                , tbl_final.depo_f4 AS `depo_f4`
                , tbl_final.maximum_out
                , CASE 
                WHEN tbl_final.`ket_izin` IS NOT NULL
                    THEN tbl_final.`ket_izin`
                WHEN tbl_final.f1 = 'OFF'
                    AND tbl_final.f4 = 'OFF'
                THEN 'LI'
                WHEN (tbl_final.f1>=tbl_final.minimum_in)
                    AND (tbl_final.f1<=tbl_final.waktu_masuk) 
                    AND (tbl_final.f4<=tbl_final.maximum_out)
                    AND (tbl_final.f4>=tbl_final.waktu_keluar) 
                THEN 'HD'
                WHEN (tbl_final.f1>=tbl_final.minimum_in)
                    AND (tbl_final.f1>tbl_final.waktu_masuk) 
                    AND (tbl_final.f4<=tbl_final.maximum_out)
                    AND (tbl_final.f4>=tbl_final.waktu_keluar) 
                THEN 'TL'
                WHEN (tbl_final.f1 IS NULL AND tbl_final.f4 IS NULL) and 
                    (tbl_final.`waktu_shift` is null and dayname(DATE(tbl_final.`shift_day`)) = 'Sunday')
                THEN 'LI'
                WHEN (tbl_final.f1 IS NULL AND tbl_final.f4 IS NULL) 
                AND (tbl_final.`waktu_shift` IS NULL AND DAYNAME(DATE(tbl_final.`shift_day`)) = 'Saturday')
                AND tbl_final.`jabatan_struktur` = '342'
                THEN 'LI'
                WHEN tbl_final.birth_date = tbl_final.`shift_day`
                    AND tbl_final.`waktu_shift` IS NULL
                THEN 'LI'
                WHEN (tbl_final.`shift_day` BETWEEN '2020-04-01' and '2020-05-31')
                AND DAYNAME(DATE(tbl_final.`shift_day`)) = 'Saturday'
                AND tbl_final.`area` = '1'
                THEN 'LI'
                WHEN (tbl_final.`shift_day` BETWEEN '2020-09-14' AND '2020-09-30')
                AND DAYNAME(DATE(tbl_final.`shift_day`)) = 'Saturday'
                AND tbl_final.`area` = '1'
                AND (tbl_final.`dept_struktur` <> 'Information Communication and Technology'
                OR tbl_final.`dept_struktur` <> 'Warehouse Operation')
                THEN 'LI'
                WHEN tbl_final.`shift_day` BETWEEN '$tanggal1'
                and (SELECT `tbl_karyawan_struktur`.`join_date_struktur` FROM `tbl_karyawan_struktur`
                WHERE `tbl_karyawan_struktur`.`nik_baru` = '$nik' 
                AND `tbl_karyawan_struktur`.`join_date_struktur` >= '$tanggal1')
                THEN 'NEW'
                when tbl_final.`shift_day` between (SELECT `tbl_resign`.`tanggal_efektif_resign` FROM `tbl_resign`
                where `tbl_resign`.`nik_resign` = '$nik' 
                and `tbl_resign`.`tanggal_efektif_resign` >= '$tanggal1') and '$tanggal2'
                then 'RESIGN'
                WHEN tbl_final.f1 IS NULL
                    AND tbl_final.f4 IS NULL
                THEN 'AL'
                WHEN tbl_final.f1 IS NULL 
                THEN 'TD F1'
                WHEN tbl_final.f4 IS NULL 
                THEN 'TD F4'
                WHEN (tbl_final.f1>=tbl_final.minimum_in)
                    AND (tbl_final.f1>tbl_final.waktu_masuk) 
                    AND (tbl_final.f4<=tbl_final.maximum_out)
                    AND (tbl_final.f4<tbl_final.waktu_keluar) 
                THEN 'F4 Tidak Sesuai'
                ELSE 'Tidak Sesuai Jadwal'
                END AS `ket_absensi`
                , CASE 
                WHEN (tbl_final.f1>=tbl_final.minimum_in)
                    AND (tbl_final.f1>tbl_final.waktu_masuk) 
                    AND (tbl_final.f4<=tbl_final.maximum_out)
                    AND (tbl_final.f4>=tbl_final.waktu_keluar) 
                THEN TIMEDIFF( tbl_final.waktu_masuk, tbl_final.f1 )
                ELSE ''
                END  AS `waktu_telat`
                FROM (SELECT 
                `tarikan_absen_adms`.`shift_day`
                , `tarikan_absen_adms`.`badgenumber`
                , `tarikan_absen_adms`.`name`
                , `tbl_jabatan_karyawan`.`jabatan_karyawan`
                , `tbl_karyawan_struktur`.`jabatan_struktur`
                , `tbl_karyawan_struktur`.`lokasi_struktur`
                , `tbl_karyawan_struktur`.`dept_struktur`
                , `tbl_karyawan_struktur`.`join_date_struktur`
                , CASE
                WHEN `tarikan_absen_adms`.`waktu_shift` = '7' 
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`) , ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR 
                WHEN `tarikan_absen_adms`.`waktu_shift` = '25' 
                    THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' '
                    , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                    ) AS DATETIME
                    ) - INTERVAL 5 HOUR 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '28' 
                    THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' '
                    , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                    ) AS DATETIME
                    ) - INTERVAL 5 HOUR 
                WHEN `tarikan_absen_adms`.`waktu_shift` is not null
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 5 HOUR 
                ELSE CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 04:00:01'
                ) AS DATETIME
                ) 
                END AS minimum_in
                , CASE 
                WHEN `tarikan_absen_adms`.`waktu_shift` = '18' 
                THEN 'OFF'
                WHEN `tarikan_absen_adms`.`in_manual` IS NOT NULL 
                AND `tarikan_absen_adms`.`in_manual` >= '22:00:01'
                AND `tarikan_absen_adms`.`in_manual` <= '23:59:59'
                THEN  CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , `tarikan_absen_adms`.`in_manual`
                ) AS DATETIME
                ) - INTERVAL 1 DAY
                WHEN `tarikan_absen_adms`.`in_manual` IS NOT NULL
                    THEN  CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' '
                    , `tarikan_absen_adms`.`in_manual`
                    ) AS DATETIME
                    )   
                WHEN `tarikan_absen_adms`.`waktu_shift` IS NULL
                THEN (
                SELECT MIN(checktime)
                FROM $this->$adms.checkinout masuk_normal
                WHERE masuk_normal.userid=userinfo.userid
                AND masuk_normal.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 04:00:01'
                ) AS DATETIME
                )
                AND masuk_normal.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 12:00:59'
                ) AS DATETIME
                ) 
                )
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30'
                and `tarikan_absen_adms`.`waktu_shift` = '21'
                THEN (
                SELECT MIN(checktime)
                FROM $this->$adms.checkinout masuk_malem
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '22:00:00')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '22:00:00')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                )
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30'
                AND `tarikan_absen_adms`.`waktu_shift` = '24'
                THEN (
                SELECT MIN(checktime)
                FROM $this->$adms.checkinout masuk_malem
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '13:00:00')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '13:00:00')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                )
                WHEN `tarikan_absen_adms`.`waktu_shift` = '25'
                THEN (
                SELECT MIN(checktime)
                FROM $this->$adms.checkinout masuk_malem
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                )
                WHEN `tarikan_absen_adms`.`waktu_shift` = '30'
                THEN (
                SELECT MIN(checktime)
                FROM $this->$adms.checkinout masuk_malem
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '03:00:00')
                ) AS DATETIME
                ) + INTERVAL 1 day
                )
                ELSE (
                SELECT MIN(checktime)
                FROM $this->$adms.checkinout masuk_malem
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                )
                END AS `f1`
                , CASE  
                WHEN `tarikan_absen_adms`.`waktu_shift` IS NULL
                THEN (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_normal
                LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_normal.userid=userinfo.userid
                AND masuk_normal.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 04:00:01'
                ) AS DATETIME
                )
                AND masuk_normal.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 12:00:59'
                ) AS DATETIME
                ) 
                LIMIT 0, 1
                )
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30'
                AND `tarikan_absen_adms`.`waktu_shift` = '21'
                THEN (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_malem
                LEFT JOIN `sn_depo`
                    ON masuk_malem.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '22:00:00')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '22:00:00')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                LIMIT 0, 1
                )
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30'
                AND `tarikan_absen_adms`.`waktu_shift` = '24'
                THEN (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_malem
                LEFT JOIN `sn_depo`
                    ON masuk_malem.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '13:00:00')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '13:00:00')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                LIMIT 0, 1
                )
                WHEN `tarikan_absen_adms`.`waktu_shift` = '25'
                THEN (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_malem
                LEFT JOIN `sn_depo`
                    ON masuk_malem.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                LIMIT 0, 1
                )
                WHEN `tarikan_absen_adms`.`waktu_shift` = '30'
                THEN (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_malem
                LEFT JOIN `sn_depo`
                    ON masuk_malem.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '03:00:00')
                ) AS DATETIME
                ) + INTERVAL 1 day
                LIMIT 0, 1
                )
                ELSE (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_malem
                LEFT JOIN `sn_depo`
                    ON masuk_malem.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_malem.userid=userinfo.userid
                AND masuk_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND masuk_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                LIMIT 0, 1
                )
                END AS `depo_f1`
                , CAST(
                CONCAT(
                case 
                when `tarikan_absen_adms`.`waktu_shift` = '25' 
                    then DATE(`tarikan_absen_adms`.`shift_day`)
                else 
                    DATE(`tarikan_absen_adms`.`shift_day`)
                end, ' '
                , CASE 
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30' 
                and `tarikan_absen_adms`.`waktu_shift` = '21' THEN '22:00:00'
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30' 
                AND `tarikan_absen_adms`.`waktu_shift` = '24' THEN '13:00:00'
                WHEN `tarikan_absen_adms`.`waktu_shift` IS NULL THEN '08:00:00'
                ELSE TIME_FORMAT(tbl_shifting.waktu_masuk, '%H:%i:%S')
                END
                ) AS DATETIME
                ) AS waktu_masuk
                , CASE
                WHEN `tarikan_absen_adms`.`waktu_shift` = '16' THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 07:00:00'
                ) AS DATETIME  
                ) + INTERVAL 1 DAY 
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30'
                and `tarikan_absen_adms`.`waktu_shift` = '21' THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 07:00:00'
                ) AS DATETIME  
                ) + INTERVAL 1 DAY 
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30'
                AND `tarikan_absen_adms`.`waktu_shift` = '24' THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 22:00:00'
                ) AS DATETIME  
                )
                WHEN `tarikan_absen_adms`.`waktu_shift` = '21' THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 06:00:00'
                ) AS DATETIME  
                ) + INTERVAL 1 DAY 
                WHEN `tarikan_absen_adms`.`waktu_shift` = '25' THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 08:00:00'
                    ) AS DATETIME  
                    ) + interval 1 day
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '27' THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 01:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '28' THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 06:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '29' THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 01:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '30' THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 08:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '31' THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 04:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '35' THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 05:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '37' THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 08:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                WHEN `tarikan_absen_adms`.`attendance_date_longshift` IS NOT NULL AND `tarikan_absen_adms`.`attendance_date_longshift` > '00:00:01' 
                AND `tarikan_absen_adms`.`attendance_date_longshift` < '03:00:00' THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`),' ',`tarikan_absen_adms`.`attendance_date_longshift`
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`attendance_date_longshift` IS NOT NULL THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`),' ',`tarikan_absen_adms`.`attendance_date_longshift`
                    ) AS DATETIME  
                    )
                WHEN `tarikan_absen_adms`.`shift_day` BETWEEN '2020-03-26'
                AND '2020-05-31' THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , CASE 
                WHEN `tarikan_absen_adms`.`waktu_shift` IS NULL THEN '16:00:00'
                ELSE TIME_FORMAT(tbl_shifting.waktu_keluar, '%H:%i:%S')
                END
                ) AS DATETIME
                )
                WHEN `tarikan_absen_adms`.`shift_day` BETWEEN '2020-09-18'
                AND '2020-09-30' 
                AND (`tbl_karyawan_struktur`.`dept_struktur` = 'Information Communication and Technology' 
                OR `tbl_karyawan_struktur`.`dept_struktur` = 'Warehouse Operation') 
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , CASE 
                WHEN `tarikan_absen_adms`.`waktu_shift` IS NULL THEN '17:00:00'
                ELSE TIME_FORMAT(tbl_shifting.waktu_keluar, '%H:%i:%S')
                END
                ) AS DATETIME
                )
                WHEN `tarikan_absen_adms`.`shift_day` BETWEEN '2020-09-14'
                AND '2020-09-30' THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , CASE 
                WHEN `tarikan_absen_adms`.`waktu_shift` IS NULL THEN '16:00:00'
                ELSE TIME_FORMAT(tbl_shifting.waktu_keluar, '%H:%i:%S')
                END
                ) AS DATETIME
                )
                ELSE CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , CASE 
                WHEN `tarikan_absen_adms`.`waktu_shift` IS NULL THEN '17:00:00'
                ELSE TIME_FORMAT(tbl_shifting.waktu_keluar, '%H:%i:%S')
                END
                ) AS DATETIME
                )
                END AS waktu_keluar
                , CASE 
                WHEN `tarikan_absen_adms`.`waktu_shift` = '18' 
                THEN 'OFF'
                WHEN `tarikan_absen_adms`.`out_manual` IS NOT NULL 
                AND `tarikan_absen_adms`.`out_manual` >= '00:00:01'
                AND `tarikan_absen_adms`.`out_manual` <= '12:00:00'
                THEN  CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , `tarikan_absen_adms`.`out_manual`
                ) AS DATETIME
                ) + INTERVAL 1 DAY
                WHEN `tarikan_absen_adms`.`out_manual` IS NOT NULL
                THEN  CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , `tarikan_absen_adms`.`out_manual`
                ) AS DATETIME
                )
                WHEN `tarikan_absen_adms`.`waktu_shift` = '16' 
                THEN (
                SELECT MAX(checktime)
                FROM $this->$adms.checkinout masuk_normal
                WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 03:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 11:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                )
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30' 
                and `tarikan_absen_adms`.`waktu_shift` = '24' 
                THEN (
                SELECT MAX(checktime)
                FROM $this->$adms.checkinout masuk_normal
                WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 18:00:00'
                    ) AS DATETIME  
                    )
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 02:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                )
                WHEN `tarikan_absen_adms`.`waktu_shift` = '21' 
                THEN (
                SELECT MAX(checktime)
                FROM $this->$adms.checkinout masuk_normal
                WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 02:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 10:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                )
                WHEN `tarikan_absen_adms`.`waktu_shift`= '25' 
                    THEN (
                    SELECT MAX(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 03:00:00'
                    ) AS DATETIME  
                    ) + interval 1 day
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 13:00:00'
                    ) AS DATETIME  
                    ) + interval 1 day
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '27' 
                    THEN (
                    SELECT MAX(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 09:00:00'
                    ) AS DATETIME  
                    )
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 05:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '28' 
                    THEN (
                    SELECT MAX(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 02:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 11:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '29' 
                    THEN (
                    SELECT max(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 21:00:00'
                    ) AS DATETIME  
                    )
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 05:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '30' 
                    THEN (
                    SELECT MAX(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 04:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 12:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '31' 
                    THEN (
                    SELECT max(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 00:00:01'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 08:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '35' 
                    THEN (
                    SELECT MAX(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 01:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 09:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '37' 
                    THEN (
                    SELECT MAX(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 04:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 12:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    )
                WHEN `tarikan_absen_adms`.`attendance_date_longshift` IS NOT NULL AND `tarikan_absen_adms`.`attendance_date_longshift` > '00:00:01' 
                AND `tarikan_absen_adms`.`attendance_date_longshift` < '03:00:00'
                    THEN (
                    SELECT MAX(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    `tarikan_absen_adms`.`shift_day`, ' 00:00:01'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    `tarikan_absen_adms`.`shift_day`, ' 03:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    )
                 WHEN `tarikan_absen_adms`.`attendance_date_longshift` IS NOT NULL
                    THEN (
                    SELECT MAX(checktime)
                    FROM $this->$adms.checkinout masuk_normal
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' '
                    , TIME_FORMAT(`tarikan_absen_adms`.`attendance_date_longshift`, '%H:%i:%S')
                    ) AS DATETIME  
                    ) - INTERVAL 5 hour 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' '
                    , TIME_FORMAT(`tarikan_absen_adms`.`attendance_date_longshift`, '%H:%i:%S')
                    ) AS DATETIME  
                    ) + INTERVAL 5 hour 
                    )
                WHEN `tarikan_absen_adms`.`waktu_shift` IS NULL
                THEN (
                SELECT MAX(checktime)
                FROM $this->$adms.checkinout masuk_normal
                WHERE masuk_normal.userid=userinfo.userid
                AND masuk_normal.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 12:01:00'
                ) AS DATETIME
                )
                AND masuk_normal.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 23:59:59'
                ) AS DATETIME
                ) 
                )
                ELSE (
                SELECT MAX(checktime)
                FROM $this->$adms.checkinout keluar_malem
                WHERE keluar_malem.userid=userinfo.userid
                AND keluar_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_keluar, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND keluar_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_keluar, '%H:%i:%S')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                )
                END AS `f4`
                , CASE 
                WHEN `tarikan_absen_adms`.`waktu_shift` = '16' 
                THEN (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_normal
                LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 03:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 11:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                LIMIT 0, 1
                )
                WHEN `tarikan_absen_adms`.`shift_day` <= '2020-05-30' 
                and `tarikan_absen_adms`.`waktu_shift` = '24' 
                THEN (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_normal
                LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 18:00:00'
                    ) AS DATETIME  
                    )
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 02:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                LIMIT 0, 1
                )
                WHEN `tarikan_absen_adms`.`waktu_shift` = '21' 
                THEN (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_normal
                LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 02:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 10:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                LIMIT 0, 1
                )
                WHEN `tarikan_absen_adms`.`waktu_shift`= '25' 
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 03:00:00'
                    ) AS DATETIME  
                    ) + interval 1 day
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 13:00:00'
                    ) AS DATETIME  
                    ) + interval 1 day
                    LIMIT 0, 1
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '27' 
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 09:00:00'
                    ) AS DATETIME  
                    )
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 05:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    LIMIT 0, 1
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '28' 
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 02:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 11:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    LIMIT 0, 1
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '29' 
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 21:00:00'
                    ) AS DATETIME  
                    )
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 05:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    LIMIT 0, 1
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '30' 
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 04:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 12:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    LIMIT 0, 1
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '31' 
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 00:00:01'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 08:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    LIMIT 0, 1
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '35' 
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 01:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 09:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    LIMIT 0, 1
                    )
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '37' 
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 04:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 12:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    LIMIT 0, 1
                    )
                WHEN `tarikan_absen_adms`.`attendance_date_longshift` IS NOT NULL AND `tarikan_absen_adms`.`attendance_date_longshift` > '00:00:01' 
                AND `tarikan_absen_adms`.`attendance_date_longshift` < '03:00:00'
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    `tarikan_absen_adms`.`shift_day`, ' 00:00:01'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    `tarikan_absen_adms`.`shift_day`, ' 03:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    LIMIT 0, 1
                    )
                 WHEN `tarikan_absen_adms`.`attendance_date_longshift` IS NOT NULL
                    THEN (
                    SELECT `tbl_depo`.`depo_nama`
                    FROM $this->$adms.checkinout masuk_normal
                    LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                    LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                    WHERE masuk_normal.userid=userinfo.userid
                    AND masuk_normal.checktime>=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' '
                    , TIME_FORMAT(`tarikan_absen_adms`.`attendance_date_longshift`, '%H:%i:%S')
                    ) AS DATETIME  
                    ) - INTERVAL 5 hour 
                    AND masuk_normal.checktime<=CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' '
                    , TIME_FORMAT(`tarikan_absen_adms`.`attendance_date_longshift`, '%H:%i:%S')
                    ) AS DATETIME  
                    ) + INTERVAL 5 hour 
                    LIMIT 0, 1
                    )
                WHEN `tarikan_absen_adms`.`waktu_shift` IS NULL
                THEN (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout masuk_normal
                LEFT JOIN `sn_depo`
                    ON masuk_normal.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE masuk_normal.userid=userinfo.userid
                AND masuk_normal.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 12:01:00'
                ) AS DATETIME
                )
                AND masuk_normal.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 23:59:59'
                ) AS DATETIME
                )
                LIMIT 0, 1 
                )
                ELSE (
                SELECT `tbl_depo`.`depo_nama`
                FROM $this->$adms.checkinout keluar_malem
                LEFT JOIN `sn_depo`
                    ON keluar_malem.`SN` = `sn_depo`.`SN`
                LEFT JOIN `tbl_depo`
                    ON `sn_depo`.`depo_id` = `tbl_depo`.`depo_id`
                WHERE keluar_malem.userid=userinfo.userid
                AND keluar_malem.checktime>=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_keluar, '%H:%i:%S')
                ) AS DATETIME
                ) - INTERVAL 4 HOUR
                AND keluar_malem.checktime<=CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_keluar, '%H:%i:%S')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                LIMIT 0, 1
                )
                END AS `depo_f4`
                , CASE
                WHEN `tarikan_absen_adms`.`waktu_shift` = '9' 
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' '
                , TIME_FORMAT(tbl_shifting.waktu_keluar, '%H:%i:%S')
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
                WHEN `tarikan_absen_adms`.`waktu_shift` = '12' 
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 03:00:00'
                ) AS DATETIME  
                ) + INTERVAL 1 DAY 
                WHEN `tarikan_absen_adms`.`waktu_shift` = '14' 
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 02:00:00'
                ) AS DATETIME  
                ) + INTERVAL 1 DAY 
                WHEN `tarikan_absen_adms`.`waktu_shift` = '16' 
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 11:00:00'
                ) AS DATETIME  
                ) + INTERVAL 1 DAY 
                WHEN DATE(`tarikan_absen_adms`.`shift_day`) <= '2020-05-30'
                and `tarikan_absen_adms`.`waktu_shift` = '21' 
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 11:00:00'
                ) AS DATETIME  
                ) + INTERVAL 1 DAY 
                WHEN DATE(`tarikan_absen_adms`.`shift_day`) <= '2020-05-30'
                AND `tarikan_absen_adms`.`waktu_shift` = '24' 
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 02:00:00'
                ) AS DATETIME  
                ) + INTERVAL 1 DAY 
                WHEN `tarikan_absen_adms`.`waktu_shift` = '21' 
                THEN CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 10:00:00'
                ) AS DATETIME  
                ) + INTERVAL 1 DAY 
                WHEN `tarikan_absen_adms`.`waktu_shift` = '25' 
                    THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 12:00:00'
                    ) AS DATETIME  
                    ) + interval 1 day
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '27' 
                    THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 05:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '28' 
                    THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 11:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '29' 
                    THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 05:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '30' 
                    THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 12:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '31' 
                    THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 08:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '35' 
                    THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 09:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                    WHEN `tarikan_absen_adms`.`waktu_shift` = '37' 
                    THEN CAST(
                    CONCAT(
                    DATE(`tarikan_absen_adms`.`shift_day`), ' 12:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                WHEN `tarikan_absen_adms`.`attendance_date_longshift` IS NOT NULL 
                AND `tarikan_absen_adms`.`attendance_date_longshift` > '00:00:01' AND `tarikan_absen_adms`.`attendance_date_longshift` < '03:00:00'
                    THEN CAST(
                    CONCAT(
                    date(`tarikan_absen_adms`.`shift_day`), ' 03:00:00'
                    ) AS DATETIME  
                    ) + INTERVAL 1 DAY 
                ELSE CAST(
                CONCAT(
                DATE(`tarikan_absen_adms`.`shift_day`), ' 23:59:59'
                ) AS DATETIME
                ) 
                END AS maximum_out
                , `tarikan_absen_adms`.`waktu_shift`
                , CASE 
                WHEN `tarikan_absen_adms`.`jenis_full_day` IS NOT NULL
                THEN `tarikan_absen_adms`.`jenis_full_day`
                WHEN `tarikan_absen_adms`.`jenis_non_full_day` IS NOT NULL
                THEN `tarikan_absen_adms`.`jenis_non_full_day`
                WHEN `tarikan_absen_adms`.`opsi_cuti_tahunan` IS NOT NULL
                THEN 'CU'
                WHEN `tarikan_absen_adms`.`jenis_cuti_khusus` IS NOT NULL
                THEN 'CK'
                END AS ket_izin
                , `tmp_events`.`birth_date`
                , `tbl_jabatan_karyawan`.`area`
                FROM `tarikan_absen_adms`
            LEFT JOIN `tbl_shifting`
                ON `tarikan_absen_adms`.`waktu_shift` = `tbl_shifting`.`id_shifting`
            INNER JOIN $this->$adms.`userinfo`
                ON `tarikan_absen_adms`.`userid` = $this->$adms.`userinfo`.`userid`
            INNER JOIN `tbl_karyawan_struktur`
                ON `tbl_karyawan_struktur`.`nik_baru` = `tarikan_absen_adms`.`badgenumber`
            INNER JOIN `tbl_jabatan_karyawan`
                ON `tbl_karyawan_struktur`.`jabatan_struktur` = `tbl_jabatan_karyawan`.`no_jabatan_karyawan`
            LEFT JOIN `tmp_events`
                ON `tmp_events`.`birth_date` = `tarikan_absen_adms`.`shift_day`
            WHERE $where
            AND `tbl_karyawan_struktur`.`status_karyawan` = '0'
            ) tbl_final
        ";
        $hasil = $this->db->query($sql);
        // $get = $this->db->get();
        // return $get->result_array();
        return $hasil->result_array();
    }


    public function getAbsensi_new($tanggal1 = null, $tanggal2 = null, $nik = null, $depo = null, $pt = null, $jabatan = null, $dept = null)
    {
        $where = " DATE(a.`shift_day`) >= '$tanggal1' AND DATE(a.`shift_day`) <= '$tanggal2'";
        if ($nik != '') {
            $where .= " and a.`badgenumber` = '$nik'";
        }
        if ($depo != '') {
            $where .= "  and a.`lokasi_struktur` = '$depo'";
        }
        if ($jabatan != '') {
            $where .= "  and tbl_karyawan_struktur.jabatan_struktur = '$jabatan'";
        }
        if ($dept != '') {
            $where .= "  and tbl_karyawan_struktur.dept_struktur = '$dept'";
        }
        if ($pt != '') {
            $where .= "  and tbl_karyawan_struktur.perusahaan_struktur = '$pt'";
        }

        $sql = "SELECT
            *,
            CASE
            WHEN tbl_final.`ket_izin` IS NOT NULL 
                THEN tbl_final.`ket_izin` 
            WHEN tbl_final.checkin = 'OFF' 
            AND tbl_final.checkout = 'OFF' 
                THEN 'LI' 
            WHEN (
            tbl_final.checkin >= tbl_final.minimum_in
            ) 
            AND (
            tbl_final.checkin <= tbl_final.jadwal_masuk
            ) 
            AND (
            tbl_final.checkout <= tbl_final.maximum_out
            ) 
            AND (
            tbl_final.checkout >= tbl_final.jadwal_keluar
            ) 
                THEN 'HD' 
            WHEN (
            tbl_final.checkin >= tbl_final.minimum_in
            ) 
            AND (
            tbl_final.checkin > tbl_final.jadwal_masuk
            ) 
            AND (
            tbl_final.checkout <= tbl_final.maximum_out
            ) 
            AND (
            tbl_final.checkout >= tbl_final.jadwal_keluar
            ) 
                THEN 'TL' 
            WHEN (
            tbl_final.checkin IS NULL 
            AND tbl_final.checkout IS NULL
            ) 
            AND (
            tbl_final.`waktu_shift` IS NULL 
            AND (DAYNAME(DATE(tbl_final.`shift_day`)) = 'Sunday' OR DAYNAME(DATE(tbl_final.`shift_day`)) = 'Saturday')
            ) 
                THEN 'LI' 
            WHEN tbl_final.birth_date = tbl_final.`shift_day` 
            AND tbl_final.`waktu_shift` IS NULL 
                THEN 'LI' 
            WHEN tbl_final.`shift_day` BETWEEN '2024-09-01' 
            AND 
            (SELECT 
                $this->absensi.`tbl_karyawan_struktur`.`tanggalJoin`
            FROM
            $this->absensi.`tbl_karyawan_struktur` 
            WHERE $this->absensi.`tbl_karyawan_struktur`.`nip` = tbl_final.`badgenumber` 
            AND $this->absensi.`tbl_karyawan_struktur`.`tanggalJoin` >= '2024-09-01') 
                THEN 'NEW' 
            WHEN tbl_final.`shift_day` BETWEEN 
            (SELECT 
                $this->absensi.`tbl_resign`.`tanggalEfektifResign` 
            FROM
            $this->absensi.`tbl_resign` 
            WHERE $this->absensi.`tbl_resign`.`nip` = tbl_final.`badgenumber`
            AND $this->absensi.`tbl_resign`.`tanggalEfektifResign` >= '2024-09-01') 
            AND '2024-09-30' 
                THEN 'RESIGN' 
            WHEN tbl_final.checkin IS NULL 
            AND tbl_final.checkout IS NULL 
                THEN 'AL' 
            WHEN tbl_final.checkin IS NULL 
                THEN 'TD IN' 
            WHEN tbl_final.checkout IS NULL 
                THEN 'TD OUT' 
            WHEN (
            tbl_final.checkin >= tbl_final.minimum_in
            ) 
            AND (
            tbl_final.checkin > tbl_final.jadwal_masuk
            ) 
            AND (
            tbl_final.checkout <= tbl_final.maximum_out
            ) 
            AND (
            tbl_final.checkout < tbl_final.jadwal_keluar
            ) 
                THEN 'OUT Tidak Sesuai' 
            ELSE 'Tidak Sesuai Jadwal' 
            END AS `ket_absensi`
            
        FROM (SELECT
            a.`shift_day`,
            a.`badgenumber`,
            c.`noUrut`,
            c.`nip`,
            c.`namaKaryawan`,
            d.`jabatanKaryawan`,
            e.`namaDivisi`,
            f.`namaBagian`,
            
            CASE
            WHEN b.`extend` = '1'
            THEN CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_masuk,
                '%H:%i:%S'
                )
                ) AS DATETIME
            ) - INTERVAL 4 HOUR
            ELSE CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 04:00:00'
                ) AS DATETIME
            ) 
            END AS minimum_in,
            
            CASE
            WHEN a.`waktu_shift` = '2' 
            THEN 'OFF' 
            WHEN a.`in_manual` IS NOT NULL 
            THEN CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                a.`in_manual`
                ) AS DATETIME
            ) 
            WHEN a.`waktu_shift` IS NULL 
            THEN 
            (SELECT 
                MIN(checktime) 
            FROM
                $this->absensi.tbl_absen masuk_normal 
            WHERE masuk_normal.noUrut = c.noUrut
                AND masuk_normal.checktime >= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 04:00:00'
                ) AS DATETIME
                ) 
                AND masuk_normal.checktime <= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 12:00:00'
                ) AS DATETIME
                )
            ) 
            ELSE 
            (SELECT 
                MIN(checktime) 
            FROM
                $this->absensi.tbl_absen masuk_malem 
            WHERE masuk_malem.noUrut = c.noUrut
                AND masuk_malem.checktime >= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_masuk,
                '%H:%i:%S'
                )
                ) AS DATETIME
                ) - INTERVAL 4 HOUR 
                AND masuk_malem.checktime <= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_masuk,
                '%H:%i:%S'
                )
                ) AS DATETIME
                ) + INTERVAL 4 HOUR) 
            END AS checkin,
            
            CASE
            WHEN a.`waktu_shift` IS NULL 
            THEN 
            (SELECT 
                CONCAT(masuk_normal.long,',', masuk_normal.lat)
            FROM
                $this->absensi.tbl_absen masuk_normal 
            WHERE masuk_normal.noUrut = c.noUrut
                AND masuk_normal.checktime >= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 04:00:00'
                ) AS DATETIME
                ) 
                AND masuk_normal.checktime <= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 12:00:00'
                ) AS DATETIME
                )
            GROUP BY masuk_normal.noUrut) 
            ELSE 
            (SELECT 
                CONCAT(masuk_malem.long,' ', masuk_malem.lat)
            FROM
                $this->absensi.tbl_absen masuk_malem 
            WHERE masuk_malem.noUrut = c.noUrut
                AND masuk_malem.checktime >= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_masuk,
                '%H:%i:%S'
                )
                ) AS DATETIME
                ) - INTERVAL 4 HOUR 
                AND masuk_malem.checktime <= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_masuk,
                '%H:%i:%S'
                )
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
            GROUP BY masuk_malem.noUrut) 
            END AS longlat_checkin,
            
            CAST(
            CONCAT(
                CASE
                WHEN b.`extend` = '1'
                THEN DATE(
                a.`shift_day`
                ) - INTERVAL 1 DAY 
                ELSE DATE(
                a.`shift_day`
                ) 
                END,
                ' ',
                CASE
                WHEN a.`waktu_shift` IS NULL 
                THEN (SELECT
                $this->absensi.`tbl_shifting`.`waktu_masuk`
                FROM $this->absensi.`tbl_shifting`
                WHERE $this->absensi.`tbl_shifting`.`extend` = '2')
                ELSE TIME_FORMAT(
                b.waktu_masuk,
                '%H:%i:%S'
                ) 
                END
            ) AS DATETIME
            ) AS jadwal_masuk,
            
            CAST(
            CONCAT(
                CASE
                WHEN b.`extend` = '1'
                THEN DATE(
                a.`shift_day`
                ) + INTERVAL 1 DAY 
                ELSE DATE(
                a.`shift_day`
                ) 
                END,
                ' ',
                CASE
                WHEN a.`waktu_shift` IS NULL 
                THEN (SELECT
                $this->absensi.`tbl_shifting`.`waktu_keluar`
                FROM $this->absensi.`tbl_shifting`
                WHERE $this->absensi.`tbl_shifting`.`extend` = '2')
                ELSE TIME_FORMAT(
                b.waktu_keluar,
                '%H:%i:%S'
                ) 
                END
            ) AS DATETIME
            ) AS jadwal_keluar,
            
            CASE
            WHEN a.`waktu_shift` = '18' 
            THEN 'OFF' 
            WHEN a.`out_manual` IS NOT NULL 
            THEN CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                a.`out_manual`
                ) AS DATETIME
            )
            WHEN a.`waktu_shift` IS NULL 
            THEN 
            (SELECT 
                MAX(checktime) 
            FROM
                $this->absensi.tbl_absen masuk_normal 
            WHERE masuk_normal.noUrut = a.userid 
                AND masuk_normal.checktime >= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 12:01:00'
                ) AS DATETIME
                ) 
                AND masuk_normal.checktime <= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 23:59:59'
                ) AS DATETIME
                )) 
            ELSE 
            (SELECT 
                MAX(checktime) 
            FROM
                $this->absensi.tbl_absen keluar_malem 
            WHERE keluar_malem.noUrut = a.userid 
                AND keluar_malem.checktime >= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_keluar,
                '%H:%i:%S'
                )
                ) AS DATETIME
                ) - INTERVAL 4 HOUR 
                AND keluar_malem.checktime <= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_keluar,
                '%H:%i:%S'
                )
                ) AS DATETIME
                ) + INTERVAL 4 HOUR) 
            END AS checkout,
            
            CASE
            WHEN a.`waktu_shift` IS NULL 
            THEN 
            (SELECT 
                CONCAT(masuk_normal.long,' ', masuk_normal.lat)
            FROM
                $this->absensi.tbl_absen masuk_normal 
            WHERE masuk_normal.noUrut = a.userid 
                AND masuk_normal.checktime >= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 12:01:00'
                ) AS DATETIME
                ) 
                AND masuk_normal.checktime <= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 23:59:59'
                ) AS DATETIME
                )
            GROUP BY masuk_normal.noUrut) 
            ELSE 
            (SELECT 
                CONCAT(keluar_malem.long,' ', keluar_malem.lat)
            FROM
                $this->absensi.tbl_absen keluar_malem 
            WHERE keluar_malem.noUrut = a.userid 
                AND keluar_malem.checktime >= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_keluar,
                '%H:%i:%S'
                )
                ) AS DATETIME
                ) - INTERVAL 4 HOUR 
                AND keluar_malem.checktime <= CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_keluar,
                '%H:%i:%S'
                )
                ) AS DATETIME
                ) + INTERVAL 4 HOUR
            GROUP BY keluar_malem.noUrut) 
            END AS longlat_checkout,
            
            CASE
            WHEN b.`extend` = '1'
            THEN CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' ',
                TIME_FORMAT(
                b.waktu_keluar,
                '%H:%i:%S'
                )
                ) AS DATETIME
            ) - INTERVAL 4 HOUR
            ELSE CAST(
                CONCAT(
                DATE(
                a.`shift_day`
                ),
                ' 23:59:59'
                ) AS DATETIME
            ) 
            END AS maximum_out,
            
            a.`waktu_shift`,
            
            CASE
            WHEN a.`jenis_full_day` IS NOT NULL 
            THEN a.`jenis_full_day` 
            WHEN a.`jenis_non_full_day` IS NOT NULL 
            THEN a.`jenis_non_full_day` 
            WHEN a.`opsi_cuti_tahunan` IS NOT NULL 
            THEN 'CU' 
            WHEN a.`jenis_cuti_khusus` IS NOT NULL 
            THEN 'CK' 
            END AS ket_izin,
            
            g.`birth_date`
            
        FROM $this->absensi.`tarikan_absen_adms` a
        LEFT JOIN $this->absensi.`tbl_shifting` b
            ON a.`waktu_shift` = b.`id_shifting`
        INNER JOIN $this->absensi.`tbl_karyawan_struktur` c
            ON c.`noUrut` = a.`userId` 
        INNER JOIN $this->absensi.`tbl_jabatan` d
            ON c.`idJabatan` = d.`idJabatan`
        LEFT JOIN $this->absensi.`tbl_divisi` e
            ON c.`idDivisi` = e.`idDivisi`
        LEFT JOIN $this->absensi.`tbl_bagian` f
            ON e.`idBagian` = f.`idBagian`
        LEFT JOIN $this->absensi.`tmp_events` g
            ON g.`birth_date` = a.`shift_day`
        WHERE $where) tbl_final
        ORDER BY tbl_final.`shift_day` DESC ";
        $hasil = $this->db_absensi->query($sql);
        // $get = $this->db->get();
        // return $get->result_array();
        return $hasil->result_array();
    }


    public function post_absen_get_in($data)
    {
        $this->db_absensi->insert('tbl_absen', $data);
        return $this->db_absensi->affected_rows();
    }

    public function post_absen_get_out($data)
    {
        $this->db_absensi->insert('tbl_absen', $data);
        return $this->db_absensi->affected_rows();
    }

    public function get_absen_getin($nip_karyawan = null, $checktime = null, $typeInsert = null)
    {
        $sql = "SELECT a.`noUrut`,
		a.`nip`,
		a.`checktime`,
		a.`checktype`,
		a.`long`,
		a.`lat`,
		a.`foto`,
		a.`userCreate`,
		a.`userDateCreate`,
		a.`typeInsert`
		FROM `tbl_absen` a
		WHERE a.`nip` = '$nip_karyawan'
        AND DATE(a.`checktime`) = '$checktime'
        AND a.`typeInsert` = '$typeInsert'
        AND a.`checktype` = '0'";

        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }

    public function get_absen_getout($nip_karyawan = null, $checktime = null, $typeInsert = null)
    {
        $sql = "SELECT a.`noUrut`,
		a.`nip`,
		a.`checktime`,
		a.`checktype`,
		a.`long`,
		a.`lat`,
		a.`foto`,
		a.`userCreate`,
		a.`userDateCreate`,
		a.`typeInsert`
		FROM `tbl_absen` a
		WHERE a.`nip` = '$nip_karyawan'
        AND DATE(a.`checktime`) = '$checktime'
        AND a.`typeInsert` = '$typeInsert'
        AND a.`checktype` = '1'";

        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }

    public function get_longlat_lokasi_user()
    {
        $sql = "SELECT * FROM `tbl_lokasi`";

        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }

    public function get_payment($bulan_start = null, $bulan_end = null, $tahun = null, $noUrut = null)
    {
        $sql = "SELECT
            a.`noUrut` 
            , a.`nip`
            , a.`namaKaryawan`
            , a.`lokasiHrd`
            , a.`jabatan`
            , a.`divisi`
            , a.`bagian`
            , a.`jenisKelamin`
            , a.`tanggalJoin`
            , a.`npwp`
            , c.`golongan`
            , b.`noRek`
            , b.`namaRek`
            , f.`digit_ktp`
            , f.`digit_npwp`
            , f.`digit_bpjs_ket`
            , f.`digit_bpjs_kes`
            
            , a.`gajiPokok`
            , a.`allowanceProject`
            , a.`tunjFungsional`
            , a.`tunjJabatan`
            , a.`tunjKinerja`
            , a.`TunjKomunikasi`
            , a.`tunjTransportasiAllowance`
            , a.`bonus`	
            , a.`asuransiKesAllowance`
            , a.`perjalananDinasAllowance`
            , a.`jkkJkmJpkAllowance`
            , a.`jhtcAllowance`
            , a.`bpjsByCompanyAllowance`
            , a.`jpByCompanyAllowance`
            , a.`jhteAllowance`
            , a.`jpByEmployeeAllowance`
            , a.`bpjsByEmployeeAllowance`
            , a.`telatDeduction`
            , a.`absenDeduction`
            , a.`tunjTransportasiDeduction`
            , a.`asuransiKesDeduction`
            , a.`perjalananDinasDeduction`
            , a.`jkkJkmJpkDeduction`
            , a.`jhtcDeduction`
            , a.`bpjsByCompanyDeduction`
            , a.`jpByCompanyDeduction`
            , a.`jhteDeduction`
            , a.`jpByEmployeeDeduction`
            , a.`bpjsByEmployeeDeduction`
            
            , a.`gajiPokok` + a.`allowanceProject` + a.`tunjFungsional` + a.`tunjJabatan` + a.`tunjTransportasiAllowance`
            + a.`TunjKomunikasi` + a.`tunjKinerja` + a.`bonus` AS thp
            
            , a.`gajiPokok` + a.`allowanceProject` + a.`tunjFungsional` + a.`tunjJabatan` + a.`tunjTransportasiAllowance`
            + a.`TunjKomunikasi` + a.`tunjKinerja` + a.`bonus` + a.`jhteAllowance` + a.`jpByEmployeeAllowance`
            + a.`bpjsByEmployeeAllowance` + a.`bpjsByCompanyAllowance` + a.`jkkJkmJpkAllowance` +  a.`asuransiKesAllowance`
            + a.`perjalananDinasAllowance` AS bruto
            
            , e.`tunjangan_pph` AS tax
            , a.`bulan`
            , a.`tahun`
        FROM $this->$payroll.`tmp_atribut_payroll` a
        LEFT JOIN $this->absensi.`tbl_karyawan_struktur` b ON a.`noUrut` = b.`noUrut`
        LEFT JOIN $this->$payroll.`tbl_ptkp` c ON b.`idPtkp` = c.`id`
        LEFT JOIN $this->$payroll.`tbl_kpp` d ON b.`idKpp` = d.`id`
        LEFT JOIN $this->$payroll.`tbl_pph_gross_up` e ON e.`nik_baru` = a.`nip`
        AND e.`bulan` = '$bulan_start'
        AND e.`tahun` = '$tahun'
        AND e.`id_proses` = '1'

        LEFT JOIN $this->absensi.`tbl_karyawan_induk` f ON f.`no_urut` = b.`noUrut`
        WHERE (a.`bulan` >= '$bulan_start' 
        AND a.`bulan` <= '$bulan_end')
        AND a.`tahun` = '$tahun'
        AND a.`noUrut` = '$noUrut'
        ORDER BY a.`namaKaryawan` ASC";

        $hasil = $this->db_absensi->query($sql);
        return $hasil->result_array();
    }
}
