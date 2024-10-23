<?php

/**
 * 
 */
class M_pendidikan extends CI_Model
{
    
    public function __construct()
    {
        # code...
    }

    public function get_pendidikan($di_no_ktp = null)
    {
    	$where = " website_v2.`data_pendidikan`.`dp_id` is not null";
        if ($di_no_ktp!='') {
            $where .= " and website_v2.`data_pendidikan`.`di_no_ktp` = '$di_no_ktp'";
        }
        if ($di_no_ktp === null) {
            $sql="SELECT 
                website_v2.`data_pendidikan`.`dp_id`
                , website_v2.`data_pendidikan`.`di_no_ktp`
                , website_v2.`data_pendidikan`.`di_nama_lengkap`
                , website_v2.`data_pendidikan`.`dp_status_sd`
                , website_v2.`data_pendidikan`.`dp_status_smp`
                , website_v2.`data_pendidikan`.`dp_status_sma`
                , website_v2.`data_pendidikan`.`dp_nama_st`
                , website_v2.`data_pendidikan`.`dp_nama_s1`
                , website_v2.`data_pendidikan`.`dp_nama_s2`
                , website_v2.`data_pendidikan`.`dp_nama_s3`
            FROM website_v2.`data_pendidikan`";
            $hasil = $this->db4->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT 
                website_v2.`data_pendidikan`.`dp_id`
                , website_v2.`data_pendidikan`.`di_no_ktp`
                , website_v2.`data_pendidikan`.`di_nama_lengkap`
                , website_v2.`data_pendidikan`.`dp_status_sd`
                , website_v2.`data_pendidikan`.`dp_status_smp`
                , website_v2.`data_pendidikan`.`dp_status_sma`
                , website_v2.`data_pendidikan`.`dp_nama_st`
                , website_v2.`data_pendidikan`.`dp_nama_s1`
                , website_v2.`data_pendidikan`.`dp_nama_s2`
                , website_v2.`data_pendidikan`.`dp_nama_s3`
            FROM website_v2.`data_pendidikan`
            WHERE $where";
            $hasil = $this->db4->query($sql);
            return $hasil->result_array();
        }
    }

}

?>