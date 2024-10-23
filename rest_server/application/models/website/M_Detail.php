<?php

/**
 * 
 */
class M_Detail extends CI_Model
{
    
    public function __construct()
    {
        # code...
    }

    public function get_detail($di_no_ktp = null)
    {
        $where = " website_v2.`data_detail`.`dd_id` is not null";
        if ($di_no_ktp!='') {
            $where .= " and website_v2.`data_detail`.`di_no_ktp` = '$di_no_ktp'";
        }
        if ($di_no_ktp === null) {
            $sql="SELECT 
                website_v2.`data_detail`.`dd_id`
                , website_v2.`data_detail`.`di_no_ktp`
                , website_v2.`data_detail`.`dd_tanggal_lahir`
                , website_v2.`data_detail`.`dd_tempat_lahir`
                , website_v2.`data_detail`.`dd_jenis_kelamin`
                , website_v2.`data_detail`.`dd_status_pernikahan`
                , website_v2.`data_detail`.`dd_gol_darah`
                , website_v2.`data_detail`.`dd_agama`
                , website_v2.`data_detail`.`dd_tinggi_badan`
                , website_v2.`data_detail`.`dd_berat_badan`
                , website_v2.`data_detail`.`dd_tempat_tinggal`
            FROM website_v2.`data_detail`";
            $hasil = $this->db4->query($sql);
            return $hasil->result_array();
        } else {
            $sql="SELECT 
                website_v2.`data_detail`.`dd_id`
                , website_v2.`data_detail`.`di_no_ktp`
                , website_v2.`data_detail`.`dd_tanggal_lahir`
                , website_v2.`data_detail`.`dd_tempat_lahir`
                , website_v2.`data_detail`.`dd_jenis_kelamin`
                , website_v2.`data_detail`.`dd_status_pernikahan`
                , website_v2.`data_detail`.`dd_gol_darah`
                , website_v2.`data_detail`.`dd_agama`
                , website_v2.`data_detail`.`dd_tinggi_badan`
                , website_v2.`data_detail`.`dd_berat_badan`
                , website_v2.`data_detail`.`dd_tempat_tinggal`
            FROM website_v2.`data_detail`
            WHERE $where";
            $hasil = $this->db4->query($sql);
            return $hasil->result_array();
        }
    }

}

?>