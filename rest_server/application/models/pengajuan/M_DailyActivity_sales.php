<?php

/**
 * 
 */
class M_DailyActivity_sales extends CI_Model
{
    
    public function __construct()
    {
        # code...
    }

    public function getHistoryUraian($nik_baru = null)
    {
        $sql = "SELECT
                    a.`ket_plan`
                    FROM tbl_weekly_planner_sales a WHERE a.`nik_baru` = '$nik_baru'
                    AND DATE(a.`submit_date`) = CURDATE() - 7";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getKategori()
    {
        $sql = "SELECT * FROM tbl_kategori_kegiatan";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getOneKategori($kategori = null)
    {
        $sql = "SELECT * FROM tbl_kategori_kegiatan a WHERE a.`kategori` = '$kategori'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    } 

    public function getTanggalDailyActivity($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_weekly_planner_sales WHERE nik_baru = '$nik_baru' AND draft = '0' GROUP BY DATE(date) ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getTanggalDailyActivityNik($nik_baru = null, $tanggal = null)
    {
        $sql = "SELECT a.*,
                    b.kategori AS nama_kategori
                    FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` WHERE nik_baru = '$nik_baru' AND DATE(DATE) = '$tanggal' AND draft = '0'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getTanggalDailyActivityNik2($nik_baru = null, $tanggal = null)
    {
        $sql = "SELECT a.*,
                    b.kategori AS nama_kategori
                    FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` WHERE nik_baru = '$nik_baru' AND DATE(DATE) = '$tanggal' AND draft = '1'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getSavedTanggalDailyActivity($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_weekly_planner_sales WHERE nik_baru = '$nik_baru' AND draft = '1' GROUP BY DATE(date) ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getRealization($nik_baru = null, $tanggal = null)
    {
        $sql = "SELECT a.*,
                    b.kategori AS nama_kategori
                    FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` WHERE nik_baru = '$nik_baru' AND DATE(DATE) = '$tanggal' AND status = '0' ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getSavedTanggalDailyActivity2($nik_baru = null, $tanggal = null, $tanggal2 = null)
    {
        $sql = "SELECT a.*,
                    b.kategori AS nama_kategori
                    FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` WHERE nik_baru = '$nik_baru' AND draft = '1' AND DATE(DATE) BETWEEN '$tanggal' AND '$tanggal2'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getId($id = null)
    {
        $sql = "SELECT a.*,
                    b.kategori AS nama_kategori
                    FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` WHERE a.`id` = '$id' ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getDraftNik($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_weekly_planner_sales WHERE nik_baru = '$nik_baru' AND draft ='0'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getLastId($nik_baru = null, $tanggal = null)
    {
        $sql = "SELECT * FROM tbl_weekly_planner_sales a
                    WHERE a.`nik_baru` = '$nik_baru'
                    AND DATE = '$tanggal'
                    AND a.`draft` != '2'
                    ORDER BY id DESC LIMIT 1";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getRangeDate($nik_baru = null, $tanggal = null, $tanggal2 = null)
    {
        $sql = "SELECT * FROM tbl_weekly_planner_sales WHERE nik_baru = '$nik_baru' AND draft = '1' AND DATE(DATE) BETWEEN '$tanggal' AND '$tanggal2' GROUP BY DATE";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getRangeDateStatus($nik_baru = null, $tanggal = null, $tanggal2 = null, $status = null)
    {
        if($status == 'Semua'){
            $sql = "SELECT a.*,
                    b.kategori AS nama_kategori
                    FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` WHERE nik_baru = '$nik_baru' AND DATE(DATE) BETWEEN '$tanggal' AND '$tanggal2' 
                AND STATUS !=  '0'  GROUP BY DATE ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
        } else if ($status == 'Ya'){
            $sql = "SELECT a.*,
                    b.kategori AS nama_kategori
                    FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` WHERE nik_baru = '$nik_baru' AND DATE(DATE) BETWEEN '$tanggal' AND '$tanggal2' 
                AND STATUS =  '1'  GROUP BY DATE ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
        } else if ($status == 'Tidak'){
            $sql = "SELECT a.*,
                    b.kategori AS nama_kategori
                    FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` WHERE nik_baru = '$nik_baru' AND DATE(DATE) BETWEEN '$tanggal' AND '$tanggal2' 
                AND STATUS =  '2'  GROUP BY DATE ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
        }
        
    }

    public function getCountPlan($nik_baru = null, $tanggal = null, $tanggal2 = null)
    {
        $sql = "SELECT COUNT(nik_baru) FROM tbl_weekly_planner_sales WHERE nik_baru = '$nik_baru' AND 
        DATE(DATE) BETWEEN '$tanggal' AND '$tanggal2' AND STATUS = '0' AND draft = '1'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getCountRealization($nik_baru = null, $tanggal = null, $tanggal2 = null)
    {
        $sql = "SELECT COUNT(nik_baru) FROM tbl_weekly_planner_sales WHERE nik_baru = '$nik_baru' AND 
        DATE(DATE) BETWEEN '$tanggal' AND '$tanggal2' AND STATUS != '0'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }



    public function getRealizationPlan($nik_baru = null, $tanggal = null, $status = null)
    {
        if($status == 'Semua'){
            $sql = "SELECT a.*,
                      b.kategori AS nama_kategori
                   FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` 
                   WHERE nik_baru = '$nik_baru' AND DATE(DATE) = '$tanggal'
                   AND STATUS !=  '0'  ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();

        } else if ($status == 'Ya'){
            $sql = "SELECT a.*,
                      b.kategori AS nama_kategori
                   FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` 
                   WHERE nik_baru = '$nik_baru' AND DATE(DATE) = '$tanggal'
                   AND STATUS =  '1'  ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();

        } else if ($status == 'Tidak'){
            $sql = "SELECT a.*,
                      b.kategori AS nama_kategori
                   FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` 
                   WHERE nik_baru = '$nik_baru' AND DATE(DATE) = '$tanggal'
                   AND STATUS =  '2'  ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
        }
        
    }

    public function getRangeDateStatusNot($nik_baru = null, $tanggal = null, $tanggal2 = null)
    {
        $sql = "SELECT a.*,
                    b.kategori AS nama_kategori
                    FROM tbl_weekly_planner_sales a JOIN tbl_kategori_kegiatan b ON a.`kategori` = b.`id` WHERE nik_baru = '$nik_baru' AND DATE(DATE) BETWEEN '$tanggal' AND '$tanggal2' 
                AND STATUS = '0' GROUP BY DATE ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function createDailyActivity($data)
    {
        $this->db2->insert('tbl_weekly_planner_sales', $data);
        return $this->db2->affected_rows();
    }

    public function updateDraft($data, $nik_baru, $date, $draft_awal)
    {
        $this->db2->update('tbl_weekly_planner_sales', $data, ['nik_baru' => $nik_baru, 'date' => $date, 'draft' => $draft_awal]);
        return $this->db2->affected_rows();
    }

    public function updateRealisasi($data, $id)
    {
        $this->db2->update('tbl_weekly_planner_sales', $data, ['id' => $id]);
        return $this->db2->affected_rows();
    }

    public function updatePlan($data, $id)
    {
        $this->db2->update('tbl_weekly_planner_sales', $data, ['id' => $id]);
        return $this->db2->affected_rows();
    }

    public function HapusDraftPerId($data, $id)
    {
        $this->db2->update('tbl_weekly_planner_sales', $data, ['id' => $id]);
        return $this->db2->affected_rows();
    }

    public function SimpanDraftPerId($data, $id)
    {
        $this->db2->update('tbl_weekly_planner_sales', $data, ['id' => $id]);
        return $this->db2->affected_rows();
    }

    public function EditDraftPerId($data, $id)
    {
        $this->db2->update('tbl_weekly_planner_sales', $data, ['id' => $id]);
        return $this->db2->affected_rows();
    }


    public function getClassCustomer()
    {
        $sql = "SELECT 
                  c.szclass AS segment 
                FROM
                  dms.dms_ar_arinvoice a 
                  LEFT JOIN dms.dms_ar_customer b 
                    ON b.szId = a.szCustomerId 
                  LEFT JOIN dms_ar_customer_class c 
                    ON b.szHierarchyId = c.szid 
                  LEFT JOIN dms_ar_customerstructure d 
                    ON a.szCustomerId = d.szId 
                WHERE a.bClosed = '0' 
                  AND a.decRemain <> '0' 
                  AND c.szclass != 'INTERN'
                  AND a.bCash = '0' 
                  AND a.szDocId NOT LIKE '%F%' 
                  AND a.szDocId NOT LIKE '%B%' 
                  AND a.szDocId NOT LIKE '%S%' 
                  AND c.`szclass` IS NOT NULL 
                GROUP BY c.szclass";
        $hasil = $this->db9->query($sql);
        return $hasil->result_array();
    }

    public function getCustomerALL($szSoldToBranchId = null, $szclass = null)
    {
        $sql = "SELECT 
                  a.`szId`,
                  a.`szName`,
                  b.`szAddress`,
                  e.`szclass`,
                  b.`szLatitude`,
                  b.`szLongitude`
                FROM
                  `dms_ar_customer` a 
                  INNER JOIN `dms_sm_addressinfo` b 
                    ON a.`szId` = b.`szId` 
                  INNER JOIN `dms_ar_customersalesinfo` c 
                    ON a.`szId` = c.`szId` 
                  INNER JOIN `dms_ar_customerstructure` d 
                    ON a.`szId` = d.szId 
                  INNER JOIN dms_ar_customer_class e 
                    ON a.szHierarchyId = e.szid 
                WHERE b.`szObjectId` = 'DMSCustomer' 
                  AND c.`szStatus` = 'ACT' 
                  AND d.`szSoldToBranchId` = '$szSoldToBranchId' 
                  AND e.`szclass` = '$szclass' ";
        $hasil = $this->db10->query($sql);
        return $hasil->result_array();
    }

    public function getCustomerALL_ASA($szSoldToBranchId = null, $szclass = null)
    {
        $sql = "SELECT 
                  a.`szId`,
                  a.`szName`,
                  b.`szAddress`,
                  e.`szclass`,
                  b.`szLatitude`,
                  b.`szLongitude`
                FROM
                  `dms_ar_customer` a 
                  INNER JOIN `dms_sm_addressinfo` b 
                    ON a.`szId` = b.`szId` 
                  INNER JOIN `dms_ar_customersalesinfo` c 
                    ON a.`szId` = c.`szId` 
                  INNER JOIN `dms_ar_customerstructure` d 
                    ON a.`szId` = d.szId 
                  INNER JOIN dms_ar_customer_class e 
                    ON a.szHierarchyId = e.szid 
                WHERE b.`szObjectId` = 'DMSCustomer' 
                  AND c.`szStatus` = 'ACT' 
                  AND d.`szSoldToBranchId` = '$szSoldToBranchId' 
                  AND e.`szclass` = '$szclass' ";
        $hasil = $this->db11->query($sql);
        return $hasil->result_array();
    }

    public function getCustomer($szId = null)
    {
        $sql = "SELECT 
                  a.`szId`,
                  a.`szName`,
                  b.`szAddress`,
                  b.`szLatitude`,
                  b.`szLongitude`
                FROM
                  `dms_ar_customer` a 
                  INNER JOIN `dms_sm_addressinfo` b 
                    ON a.`szId` = b.`szId` 
                  INNER JOIN `dms_ar_customersalesinfo` c 
                    ON a.`szId` = c.`szId` 
                  INNER JOIN `dms_ar_customerstructure` d 
                    ON a.`szId` = d.szId 
                WHERE b.`szObjectId` = 'DMSCustomer' 
                  AND c.`szStatus` = 'ACT' 
                  AND a.`szId` = '$szId'";
        $hasil = $this->db10->query($sql);
        return $hasil->result_array();
    }

    public function getCustomer_ASA($szId = null)
    {
        $sql = "SELECT 
                  a.`szId`,
                  a.`szName`,
                  b.`szAddress`,
                  b.`szLatitude`,
                  b.`szLongitude`
                FROM
                  `dms_ar_customer` a 
                  INNER JOIN `dms_sm_addressinfo` b 
                    ON a.`szId` = b.`szId` 
                  INNER JOIN `dms_ar_customersalesinfo` c 
                    ON a.`szId` = c.`szId` 
                  INNER JOIN `dms_ar_customerstructure` d 
                    ON a.`szId` = d.szId 
                WHERE b.`szObjectId` = 'DMSCustomer' 
                  AND c.`szStatus` = 'ACT' 
                  AND a.`szId` = '$szId'";
        $hasil = $this->db11->query($sql);
        return $hasil->result_array();
    }

    public function getReasonCheckInFailed()
    {
        $sql="SELECT * FROM dms_gen_reason WHERE szReasonType = 'SFA_FAILED_CHECKIN'";
        $hasil = $this->db9->query($sql);
        return $hasil->result_array();
    }

    public function getCompetitor()
    {
        $sql = "SELECT 
				  a.* 
				FROM
				  `tbl_produk_competitor` a 
				ORDER BY a.`status_priority` DESC";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }


    // EXTERNAL //
    public function getIdProduk($produk = null)
    {
        $sql = "SELECT a.* FROM
                `tbl_produk_competitor` a
                WHERE a.`produk` = '$produk' ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getSKU()
    {
        $sql = "SELECT a.* FROM
                `tbl_sku` a";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }



    public function getNomor()
    {
        $sql = "SELECT 
                  COUNT(a.`id`) + 1 AS 'nomor_daily' 
                FROM
                  `tbl_header_market_insight` a ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function createMarketInsightHeader($data)
    {
        $this->db2->insert('tbl_header_market_insight', $data);
        return $this->db2->affected_rows();
    }

    public function createMarketInsight($data)
    {
        $this->db2->insert('tbl_market_insight', $data);
        return $this->db2->affected_rows();
    }

    public function getHeader($nik = null, $date = null)
    {
        $sql = "SELECT 
                  a.`no_daily`,
                  a.`toko`,
                  a.`submit_date`,
                  a.lokasi,
                  a.type_customer,
                  a.ket
                FROM
                  `tbl_header_market_insight` a 
                  WHERE a.`nik` = '$nik'
                  AND DATE(a.`submit_date`) = '$date'
                  and a.status = '1'
                ORDER BY a.`no_daily` DESC";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getSub($no_daily = null)
    {
        $sql = "SELECT 
                  a.*
                FROM
                  `tbl_market_insight` a 
                  WHERE a.`no_daily` = '$no_daily'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function hapusTransaksi($data, $no_daily)
    {
        $this->db2->update('tbl_header_market_insight', $data, ['no_daily' => $no_daily]);
        return $this->db2->affected_rows();
    }


    public function createStatusKunjungan($data)
    {
        $this->db2->insert('tbl_status_kunjungan', $data);
        return $this->db2->affected_rows();
    }
    public function UpdateStatusKunjungan($data, $nik_baru, $tanggal)
    {
        $this->db2->update('tbl_status_kunjungan', $data, ['nik_baru' => $nik_baru, 'tanggal' => $tanggal]);
        return $this->db2->affected_rows();
    }
    public function getStatusNik($nik_baru = null)
    {
        $sql = "SELECT 
                  * 
                FROM
                  `tbl_status_kunjungan` a 
                WHERE a.`nik_baru` = '$nik_baru' 
                  AND DATE(a.`tanggal`) = CURDATE()";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }


    public function getStatusDepo($kode_dms = null)
    {
        $sql = "SELECT 
                  * 
                FROM
                  `tbl_depo` a 
                WHERE a.`kode_dms` = '$kode_dms' 
                  AND a.`status_daily` = '1' ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getFeedback()
    {
        $sql = "SELECT 
				  * 
				FROM
				  `tbl_master_feedback` a ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }


    // pilih kelurahan //
  
    public function getHeaderFeedback()
    {
        $sql = "SELECT 
				  * 
				FROM
				  `tbl_master_feedback` a 
				GROUP BY a.`jenis_keterangan`";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getFooterFeedback($jenis = null)
    {
        $sql = "SELECT 
				  * 
				FROM
				  `tbl_master_feedback` a 
				WHERE a.`jenis_keterangan` = '$jenis'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getLokasi($nik_baru = null)
    {
        $sql = " SELECT 
				  a.lokasi_hrd 
				FROM
				  `tbl_karyawan_struktur` a 
				WHERE a.`nik_baru` = '$nik_baru' 
				  AND a.`status_karyawan` = '0'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }


    public function getDepo($depo_nama = null)
    {
        $sql = "SELECT 
                  SUBSTRING_INDEX(url_longlat, ',', 1) AS latitude,
                  SUBSTRING_INDEX(url_longlat, ',', -1) AS longitude
              FROM
                  tbl_depo
              WHERE
                  depo_nama = '$depo_nama'
               ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getNearest($latitude = null, $longitude = null)
    {
        $sql = "SELECT 
				  a.`url_longlat`,
				  (
				    6371 * ACOS(
				      COS(RADIANS($latitude)) * COS(
				        RADIANS(
				          CAST(
				            NULLIF(
				              SUBSTRING_INDEX(a.url_longlat, ',', 1),
				              ''
				            ) AS DECIMAL (10, 6)
				          )
				        )
				      ) * COS(
				        RADIANS(
				          CAST(
				            NULLIF(
				              SUBSTRING_INDEX(a.url_longlat, ',', - 1),
				              ''
				            ) AS DECIMAL (10, 6)
				          )
				        ) - RADIANS($longitude)
				      ) + SIN(RADIANS($latitude)) * SIN(
				        RADIANS(
				          CAST(
				            NULLIF(
				              SUBSTRING_INDEX(a.url_longlat, ',', 1),
				              ''
				            ) AS DECIMAL (10, 6)
				          )
				        )
				      )
				    )
				  ) AS distance 
				FROM
				  `tbl_depo` a 
				WHERE a.`url_longlat` IS NOT NULL 
				  AND SUBSTRING_INDEX(a.url_longlat, ',', 1) <> '' 
				  AND SUBSTRING_INDEX(a.url_longlat, ',', - 1) <> '' 
				HAVING distance <= 0.5
				ORDER BY distance 
				LIMIT 1 
               ";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    
    
     





    

}

?>