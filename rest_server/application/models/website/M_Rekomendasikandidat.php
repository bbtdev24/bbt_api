<?php

/**
 * 
 */
class M_Rekomendasikandidat extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function get_index_rekomendasi($dd_id = null)
	{
		$where = " c.di_id is not null";

        if ($dd_id!='') {
            $where .= " and c.di_id = '$dd_id'";
        }
        if ($dd_id === null){
			$sql="SELECT
                        c.di_id
                        , c.di_no_ktp
                        , f.`tanggal_pelamar`
                        , c.departement
                        , c.di_foto_pas
                        , c.di_cv_pelamar
                        , d.dd_tanggal_lahir
                        , c.di_nama_lengkap
                        , c.di_status_rekomendasi
                        , c.di_nilai_cv_calon_karyawan
                        , c.di_nilai_validitas_calon_karyawan
                        , c.di_status_jadwal
                        , f.id_user AS `id_lamaran`
                        , f.posisi AS `posisi_user`
                        , f.nilai_cv 
                        , f.nilai_validasi
                        , g.status
                    FROM data_induk c
                    LEFT JOIN lamaran f ON c.id_user = f.id_user 
                    LEFT JOIN jadwal_interview g ON c.di_no_ktp = g.no_ktp 
                    LEFT JOIN data_detail d ON c.di_no_ktp = d.di_no_ktp WHERE 
                    c.di_status_rekomendasi = '1'
                    AND (f.`nilai_cv` + f.`nilai_validasi`) / 2 >= 80";
	        $hasil = $this->db4->query($sql);
	    	return $hasil->result_array();
	    } else {
	    	$sql="SELECT
                        c.di_id
                        , c.di_no_ktp
                        , f.`tanggal_pelamar`
                        , c.departement
                        , c.di_foto_pas
                        , c.di_cv_pelamar
                        , d.dd_tanggal_lahir
                        , c.di_nama_lengkap
                        , c.di_status_rekomendasi
                        , c.di_nilai_cv_calon_karyawan
                        , c.di_nilai_validitas_calon_karyawan
                        , c.di_status_jadwal
                        , f.id_user AS `id_lamaran`
                        , f.posisi AS `posisi_user`
                        , f.nilai_cv 
                        , f.nilai_validasi
                        , g.status
                    FROM data_induk c
                    LEFT JOIN lamaran f ON c.id_user = f.id_user 
                    LEFT JOIN jadwal_interview g ON c.di_no_ktp = g.no_ktp 
                    LEFT JOIN data_detail d ON c.di_no_ktp = d.di_no_ktp WHERE 
                    c.di_status_rekomendasi = '1'
                    AND $where";
	        $hasil = $this->db4->query($sql);
	    	return $hasil->result_array();
		}
	}

	 public function createRekomendasi($data)
    {
        $this->db4->insert('jadwal_interview', $data);
        return $this->db4->affected_rows();
    }
}

?>