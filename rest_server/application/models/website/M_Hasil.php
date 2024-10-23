<?php

/**
 * 
 */
class M_Hasil extends CI_Model
{
    
    public function __construct()
    {
        # code...
    }

    public function get_hasil_interview($no_ktp = null, $id = null)
    {
    	$where = " website_v2.`hasil_interview`.`id` is not null";
        if ($id!='') {
            $where .= " and website_v2.`hasil_interview`.`id` = '$id'";
        }
         if ($no_ktp!='') {
            $where .= " and website_v2.`hasil_interview`.`no_ktp` = '$no_ktp'";
        }
        if ($no_ktp === null and $id === null) {
            $sql="SELECT 
                website_v2.`hasil_interview`.`id`
                , website_v2.`hasil_interview`.`no_ktp`
                , website_v2.`hasil_interview`.`pendidikan`
                , website_v2.`hasil_interview`.`posisi`
                , website_v2.`hasil_interview`.`nilai_pertama`
                , website_v2.`hasil_interview`.`nilai_kedua`
                , website_v2.`hasil_interview`.`kelebihan`
                , website_v2.`hasil_interview`.`kekurangan`
                , website_v2.`hasil_interview`.`catatan_khusus`
                , website_v2.`hasil_interview`.`kesimpulan`
                , website_v2.`hasil_interview`.`pewawancara_satu`
                , website_v2.`hasil_interview`.`pewawancara_dua`
                , website_v2.`hasil_interview`.`pewawancara_tiga`
                , website_v2.`hasil_interview`.`nama_lengkap`
            FROM website_v2.`hasil_interview`";
            $hasil = $this->db4->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT 
                website_v2.`hasil_interview`.`id`
                , website_v2.`hasil_interview`.`no_ktp`
                , website_v2.`hasil_interview`.`pendidikan`
                , website_v2.`hasil_interview`.`posisi`
                , website_v2.`hasil_interview`.`nilai_pertama`
                , website_v2.`hasil_interview`.`nilai_kedua`
                , website_v2.`hasil_interview`.`kelebihan`
                , website_v2.`hasil_interview`.`kekurangan`
                , website_v2.`hasil_interview`.`catatan_khusus`
                , website_v2.`hasil_interview`.`kesimpulan`
                , website_v2.`hasil_interview`.`pewawancara_satu`
                , website_v2.`hasil_interview`.`pewawancara_dua`
                , website_v2.`hasil_interview`.`pewawancara_tiga`
                , website_v2.`hasil_interview`.`nama_lengkap`
            FROM website_v2.`hasil_interview`
            WHERE $where";
            $hasil = $this->db4->query($sql);
            return $hasil->result_array();
        }
    }

    public function updateStatus($data, $id)
    {
        $this->db4->update('hasil_interview', $data, ['id' => $id]);
        return $this->db4->affected_rows();
    }


}

?>