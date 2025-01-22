<?php

/**
 * 
 */
class M_Refund extends CI_Model
{
	
	public function __construct()
	{
		# code...
	}

    public function getNomor()
	{
		$sql = "SELECT * FROM `tbl_karyawan_refund`
		ORDER BY `tbl_karyawan_refund`.`id` DESC
		LIMIT 0, 1
		";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getNomorPengajuan($nik_pengajuan = null)
	{
		$sql = "SELECT no_pengajuan, COUNT(no_pengajuan) AS jumlah_pengajuan
				FROM tbl_karyawan_refund WHERE nik_pengajuan = '$nik_pengajuan' AND status_ba = '0'
				GROUP BY no_pengajuan";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getNikAtasan($nik_pengajuan = null)
	{
		$sql = "SELECT
				  a.id,
				  a.submit_date,
				  a.no_pengajuan,
				  a.nik_pengajuan,
				  a.nik,
				  b.nama_karyawan_struktur,
				  a.tanggal_absen,
				  a.absen_awal,
				  a.absen_akhir,
				  a.ket,
				  a.dokumen,
				  a.status_refund,
				  a.status_ba,
				  a.no_ba,
				  a.tanggal_ba,
				  a.status_pengajuan,
				  a.ket_pengajuan
				FROM tbl_karyawan_refund a INNER JOIN tbl_karyawan_struktur b
				ON a.`nik`=b.`nik_baru`
				WHERE nik_pengajuan = '$nik_pengajuan'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function getNomorId($no_pengajuan = null)
	{
		$sql = "SELECT
				  a.id,
				  a.submit_date,
				  a.no_pengajuan,
				  a.nik_pengajuan,
				  a.nik,
				  b.nama_karyawan_struktur,
				  a.tanggal_absen,
				  a.absen_awal,
				  a.absen_akhir,
				  a.ket,
				  a.dokumen,
				  a.status_refund,
				  a.status_ba,
				  a.no_ba,
				  a.tanggal_ba,
				  a.status_pengajuan,
				  a.ket_pengajuan
				FROM tbl_karyawan_refund a INNER JOIN tbl_karyawan_struktur b
				ON a.`nik`=b.`nik_baru`
				where no_pengajuan = '$no_pengajuan'";
        $hasil = $this->db2->query($sql);
        return $hasil->result_array();
	}

	public function createrefund($data)
    {
        $this->db2->insert('tbl_karyawan_refund', $data);
        return $this->db2->affected_rows();
    }

    public function updateba($data, $id)
	{
		$this->db2->update('tbl_karyawan_refund', $data, ['no_pengajuan' => $id]);
		return $this->db2->affected_rows();
	}


}

?>