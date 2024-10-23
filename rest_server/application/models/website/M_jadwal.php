<?php

/**
 * 
 */
class M_jadwal extends CI_Model
{
    
    public function __construct()
    {
        # code...
    }

    public function get_jadwal_interview($no_ktp = null, $id = null)
    {
    	$where = " website_v2.`jadwal_interview`.`id_interview` is not null";
        if ($id!='') {
            $where .= " and website_v2.`jadwal_interview`.`id_interview` = '$id'";
        }
         if ($no_ktp!='') {
            $where .= " and website_v2.`jadwal_interview`.`no_ktp` = '$no_ktp'";
        }
        if ($no_ktp === null and $id === null) {
            $sql="SELECT 
                website_v2.`jadwal_interview`.`id_interview`
                , website_v2.`jadwal_interview`.`posisi`
                , website_v2.`jadwal_interview`.`no_ktp`
                , website_v2.`jadwal_interview`.`nama_lengkap`
                , website_v2.`jadwal_interview`.`tanggal_interview`
                , website_v2.`jadwal_interview`.`jam_interview`
                , website_v2.`jadwal_interview`.`lokasi_interview`
                , website_v2.`jadwal_interview`.`jam_masuk`
                , website_v2.`jadwal_interview`.`jam_keluar`
                , website_v2.`jadwal_interview`.`jaminan_interview`
                , website_v2.`jadwal_interview`.`tanggal_submit`
                , website_v2.`jadwal_interview`.`status`
                , website_v2.`jadwal_interview`.`nama_pewawancara_1`
                , website_v2.`jadwal_interview`.`nama_pewawancara_2`
                , website_v2.`jadwal_interview`.`nama_pewawancara_`
                , website_v2.`hasil_interview`.`kesimpulan`
            FROM website_v2.`jadwal_interview` LEFT JOIN website_v2.`hasil_interview`
            ON website_v2.`jadwal_interview`.`no_ktp` = website_v2.`hasil_interview`.`no_ktp`";
            $hasil = $this->db4->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT 
                website_v2.`jadwal_interview`.`id_interview`
                , website_v2.`jadwal_interview`.`posisi`
                , website_v2.`jadwal_interview`.`no_ktp`
                , website_v2.`jadwal_interview`.`nama_lengkap`
                , website_v2.`data_detail`.`dd_tanggal_lahir`
                , website_v2.`jadwal_interview`.`tanggal_interview`
                , website_v2.`jadwal_interview`.`jam_interview`
                , website_v2.`jadwal_interview`.`lokasi_interview`
                , website_v2.`jadwal_interview`.`jam_masuk`
                , website_v2.`jadwal_interview`.`jam_keluar`
                , website_v2.`jadwal_interview`.`jaminan_interview`
                , website_v2.`jadwal_interview`.`tanggal_submit`
                , website_v2.`jadwal_interview`.`status`
                , website_v2.`jadwal_interview`.`nama_pewawancara_1`
                , website_v2.`jadwal_interview`.`nama_pewawancara_2`
                , website_v2.`jadwal_interview`.`nama_pewawancara_`
            FROM website_v2.`jadwal_interview` LEFT JOIN website_v2.`data_detail`
				ON website_v2.`jadwal_interview`.`no_ktp` = website_v2.`data_detail`.`di_no_ktp`
            WHERE $where";
            $hasil = $this->db4->query($sql);
            return $hasil->result_array();
        }
    }

    public function createInterview($data)
    {
        $this->db4->insert('hasil_interview', $data);
        return $this->db4->affected_rows();
    }

    public function updateStatus($data, $id)
    {
        $this->db4->update('jadwal_interview', $data, ['id_interview' => $id]);
        return $this->db4->affected_rows();
    }

    public function updateJadwal($data, $id)
    {
        $this->db4->update('jadwal_interview', $data, ['id_interview' => $id]);
        return $this->db4->affected_rows();
    }


}

?>