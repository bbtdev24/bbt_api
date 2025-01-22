<?php

/**
 * 
 */
class M_Resign extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

	public function get_index_alasan($alasan = null)
	{
		if ($alasan === null) {
			$sql = "SELECT * FROM tbl_alasan_resign  WHERE status = '0'";
			$hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		} else {
			$sql = "SELECT * FROM tbl_alasan_resign WHERE alasan_resign = '$alasan' AND status = '0'";
			$hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		}
	}

	public function get_index_case($case = null)
	{
		if ($case === null) {
			$sql = "SELECT * FROM tbl_alasan_resign WHERE status = '0'";
			$hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		} else {
			$sql = "SELECT * FROM tbl_alasan_resign WHERE ket_resign = '$case' AND status = '0'";
			$hasil = $this->db2->query($sql);
	        return $hasil->result_array();
		}
	}

	public function getnomor()
	{
		$sql = "SELECT * FROM `tbl_karyawan_resign`
		ORDER BY `tbl_karyawan_resign`.`id` DESC
		LIMIT 0, 1
		";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getnikresign($nik_baru = null)
	{
		$sql = "SELECT * FROM tbl_karyawan_resign WHERE nik_baru = '$nik_baru'
        ORDER BY id DESC LIMIT 0, 1";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getid($id = null)
	{
		$sql = "SELECT * FROM `tbl_karyawan_resign` WHERE id = '$id'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

    public function getsoalexit()
    {
        $sql = "SELECT * FROM `tbl_soal_exit`";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

	public function getjabatan($jabatan = null)
	{
		$sql = "SELECT
		            tbl_karyawan_resign.`id`
		            ,tbl_karyawan_resign.`submit_date`
		            ,tbl_karyawan_resign.`no_pengajuan`
		            ,tbl_karyawan_resign.`nik_baru`
		            ,tbl_karyawan_resign.`alasan_resign`
		            ,tbl_karyawan_resign.`klarifikasi_resign`
		            ,tbl_karyawan_struktur.`nama_karyawan_struktur`
		            ,tbl_karyawan_struktur.`jabatan_struktur`
		            ,tbl_jabatan_karyawan.`jabatan_karyawan`
		            ,tbl_karyawan_struktur.`lokasi_struktur`
		            ,tbl_karyawan_resign.`tanggal_pengajuan`
		            ,tbl_karyawan_resign.`tanggal_efektif_resign`
		            ,tbl_karyawan_resign.`status_exit`
		            ,tbl_karyawan_resign.`status_atasan`
		            ,tbl_karyawan_resign.`status_atasan_2`
		        FROM `tbl_jabatan_karyawan_approval`
		        INNER JOIN `tbl_jabatan_karyawan` 
		            ON tbl_jabatan_karyawan.`no_jabatan_karyawan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_resign`
		            ON tbl_karyawan_resign.`jabatan` = tbl_jabatan_karyawan_approval.`no_jabatan_karyawan`
		        INNER JOIN `tbl_karyawan_struktur`
		            ON tbl_karyawan_struktur.`nik_baru` = tbl_karyawan_resign.`nik_baru`
		        WHERE (tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_1`='$jabatan' 
		            OR tbl_jabatan_karyawan_approval.`no_jabatan_karyawan_atasan_2`='$jabatan')";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getkuisioner()
	{
		$sql = "SELECT * FROM tbl_type_kuisioner";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getjawabankuisioner($nik_baru = null, $type_soal = null)
	{
		$sql = "SELECT 
					a.nik_baru,
					a.id_soal,
					b.soal
				FROM tbl_karyawan_kuisioner a JOIN tbl_soal_kuisioner b ON
				a.`id_soal` = b.`id` WHERE a.`nik_baru` = '$nik_baru' AND b.`type_soal` = '$type_soal'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getjawabanexit($nik_baru = null)
	{
		$sql = "SELECT 
					a.nik_baru,
					a.id_soal,
					a.jawaban_soal,
					a.keterangan,
					b.soal,
					b.jawaban
					FROM tbl_karyawan_exit a INNER JOIN tbl_soal_exit b ON a.`id_soal` = b.`id`
				WHERE nik_baru = $nik_baru";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getsoalkuisioner($type_soal = null)
	{
		$sql = "SELECT * FROM tbl_soal_kuisioner WHERE type_soal = '$type_soal'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getkuisionerfinal($nik_baru = null)
	{
		$sql = "SELECT * FROM tbl_karyawan_kuisioner_final WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getserahterima($nik_baru = null)
	{
		$sql = "SELECT * FROM tbl_karyawan_serah_terima WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getserahalatkerja($nik_baru = null)
    {
    	$sql = "SELECT * FROM tbl_serah_terima_alat_kerja WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
        
    }

    public function gethardcopy($nik_baru = null)
    {
    	$sql = "SELECT * FROM tbl_serah_terima_hardcopy WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
        
    }

    public function getsoftcopy($nik_baru = null)
    {
    	$sql = "SELECT * FROM tbl_serah_terima_softcopy WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
        
    }

    public function getproject($nik_baru = null)
    {
    	$sql = "SELECT * FROM tbl_serah_terima_project WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
        
    }

    public function getsdm($nik_baru = null)
    {
    	$sql = "SELECT * FROM tbl_serah_terima_sdm WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getcekexit($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_karyawan_exit WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getcekexitsaran($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_karyawan_exit_saran WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getstatusterima($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_status_serah_terima WHERE nik = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getpenerima($nik_baru = null, $id = null)
    {
    	$where = " a.id is not null";
        if ($id!='') {
            $where .= " and a.id = '$id'";
        }
        if ($nik_baru!='') {
            $where .= " and a.nik_penerima_1 = '$nik_baru' OR a.nik_penerima_2 = '$nik_baru'";
        }
        $sql = "SELECT 
                    a. id,
                    a. submit_date,
                    a. nik_baru,
                    b. nama_karyawan_struktur,
                    a. nik_penerima_1,
                    a. status_penerima_1,
                    a. tanggal_penerima_1,
                    a. nik_penerima_2,
                    a. status_penerima_2,
                    a. tanggal_penerima_2
                    FROM tbl_karyawan_serah_terima a JOIN tbl_karyawan_struktur b ON a.nik_baru = b.nik_baru
        		WHERE $where";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getserahterimaalatkerja($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_serah_terima_alat_kerja WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getserahterimahardcopy($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_serah_terima_hardcopy WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getserahterimasoftcopy($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_serah_terima_softcopy WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getserahterimaproject($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_serah_terima_project WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

    public function getserahterimasdm($nik_baru = null)
    {
        $sql = "SELECT * FROM tbl_serah_terima_sdm WHERE nik_baru = '$nik_baru'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
    }

	public function createresign($data)
    {
        $this->db2->insert('tbl_karyawan_resign', $data);
        return $this->db2->affected_rows();
    }

    public function createresignbaru($data)
    {
        $this->db2->insert('tbl_karyawan_resign', $data);
        return $this->db2->affected_rows();
    }

    public function createkritiksaran($data)
    {
        $this->db2->insert('tbl_karyawan_kuisioner_final', $data);
        return $this->db2->affected_rows();
    }

    public function createserahterima($data)
    {
        $this->db2->insert('tbl_karyawan_serah_terima', $data);
        return $this->db2->affected_rows();
    }

    public function createkuisioner($data)
    {
        $this->db2->insert('tbl_karyawan_kuisioner', $data);
        return $this->db2->affected_rows();
    }

    public function createserahalatkerja($data)
    {
        $this->db2->insert('tbl_serah_terima_alat_kerja', $data);
        return $this->db2->affected_rows();
    }

    public function createhardcopy($data)
    {
        $this->db2->insert('tbl_serah_terima_hardcopy', $data);
        return $this->db2->affected_rows();
    }

    public function createsoftcopy($data)
    {
        $this->db2->insert('tbl_serah_terima_softcopy', $data);
        return $this->db2->affected_rows();
    }

    public function createproject($data)
    {
        $this->db2->insert('tbl_serah_terima_project', $data);
        return $this->db2->affected_rows();
    }

    public function createsdm($data)
    {
        $this->db2->insert('tbl_serah_terima_sdm', $data);
        return $this->db2->affected_rows();
    }

    public function createexitsaran($data)
    {
        $this->db2->insert('tbl_karyawan_exit_saran', $data);
        return $this->db2->affected_rows();
    }

    public function createexitinterview($data)
    {
        $this->db2->insert('tbl_karyawan_exit', $data);
        return $this->db2->affected_rows();
    }

    public function createfinalexit($data)
    {
        $this->db2->insert('tbl_karyawan_exit_final', $data);
        return $this->db2->affected_rows();
    }

    public function createstatusterima($data)
    {
        $this->db2->insert('tbl_status_serah_terima', $data);
        return $this->db2->affected_rows();
    }

    public function updateApproval($data, $id)
	{
		$this->db2->update('tbl_karyawan_resign', $data, ['id' => $id]);
		return $this->db2->affected_rows();
	}

	public function updatehakcuti($data, $tahun, $nik_sisa_cuti)
    {
        $this->db2->update('tbl_hak_cuti', $data, ['tahun' => $tahun, 'nik_sisa_cuti' => $nik_sisa_cuti]);
        return $this->db2->affected_rows();
    }

    public function statuscuti($data, $nik_baru)
    {
        $this->db2->update('tbl_karyawan_resign', $data, ['nik_baru' => $nik_baru]);
        return $this->db2->affected_rows();
    }

    public function statuskuisioner($data, $nik_baru)
    {
        $this->db2->update('tbl_karyawan_resign', $data, ['nik_baru' => $nik_baru]);
        return $this->db2->affected_rows();
    }

    public function statusserahterima($data, $nik_baru)
    {
        $this->db2->update('tbl_karyawan_resign', $data, ['nik_baru' => $nik_baru]);
        return $this->db2->affected_rows();
    }

    public function statusexit($data, $nik_baru)
    {
        $this->db2->update('tbl_karyawan_resign', $data, ['nik_baru' => $nik_baru]);
        return $this->db2->affected_rows();
    }

    public function approval_serahterima1($data, $nik_penerima_1) {
		$this->db2->update('tbl_karyawan_serah_terima', $data, ['nik_penerima_1' => $nik_penerima_1]);
		return $this->db2->affected_rows();		
	}

	public function approval_serahterima2($data, $nik_penerima_2) {
		$this->db2->update('tbl_karyawan_serah_terima', $data, ['nik_penerima_2' => $nik_penerima_2]);
		return $this->db2->affected_rows();		
	}

	public function approval_statusserahterima($data, $nik) {
		$this->db2->update('tbl_status_serah_terima', $data, ['nik' => $nik]);
		return $this->db2->affected_rows();		
	}

}

?>