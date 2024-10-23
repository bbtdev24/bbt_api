<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */

// use namespace
use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

/**
 * 
 */
class Mutasi_rotasi extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->db2 = $this->load->database('db2', TRUE);

		$this->load->model('pengajuan/M_Mutasi');
	}

	public function index_get()
	{
		$id = $this->get('id_mutasi_rotasi');
		$nik_baru = $this->get('nik_pengajuan');
		
		if ($nik_baru === null and $id === null) {
			$user = $this->M_Mutasi->get_index_mutasi();
		} else {
			$user = $this->M_Mutasi->get_index_mutasi($nik_baru, $id);
		}

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_post()
	{
		$getNik = $this->M_Mutasi->get_NoUrut($this->post('nik_baru'));
		foreach($getNik as $row) {
			$no_urut = $row['no_urut'];
		}

		$data = [
			'no_urut' => $no_urut,
			'tanggal_pengajuan' => date('Y-m-d h:i:s'),
			'nik_pengajuan' => $this->post('nik_pengajuan'),
			'jabatan_pengajuan' => $this->post('jabatan_pengajuan'),
			'nik_baru' => $this->post('nik_baru'),
			'no_pengajuan' => $this->post('no_pengajuan'),
			'opsi' => $this->post('opsi') != null ? $this->post('opsi') : null,
			'nama_karyawan_mutasi' => $this->post('nama_karyawan_mutasi'),
			'pt_awal' => $this->post('pt_awal'),
			'dept_awal' => $this->post('dept_awal'),
			'lokasi_awal' => $this->post('lokasi_awal'),
			'jabatan_awal' => $this->post('jabatan_awal'),
			'level_awal' => $this->post('level_awal'),
			'permintaan' => $this->post('permintaan'),

			'pt_baru' => $this->post('pt_baru'),
			'dept_baru' => $this->post('dept_baru'),
			'lokasi_baru' => $this->post('lokasi_baru'),
			'jabatan_baru' => $this->post('jabatan_baru'),
			'level_baru' => $this->post('level_baru'),
			'rekomendasi_tanggal' => $this->post('rekomendasi_tanggal'),

			
			'status_atasan' => $this->post('status_atasan'),
			'status_1' => $this->post('status_1'),
			'status_dokumen' => $this->post('status_dokumen'),
			'status_pengajuan' => $this->post('status_pengajuan'),
			'nik_lama' => $this->post('nik_lama'),

		];

		if ($this->M_Mutasi->createMutasi($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new shift has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_atasan_get()
    {     
        $jabatan = $this->get('jabatan_struktur');

        if ($jabatan === null) {
            $team = $this->M_Mutasi->get_index_Mutasi_atasan();
        } else {
            $team = $this->M_Mutasi->get_index_Mutasi_atasan($jabatan);
        }

        if ($team) {
            $this->response([
                'status' => true,
                'data' => $team
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_put()
	{
		$id = $this->put('id_mutasi_rotasi');
		$data = [
			'status_atasan' => $this->put('status_atasan'),
		];

		if ($this->M_Mutasi->updateApproval($data, $id) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	// manager //
	public function index_manager_get()
	{
		$date1 = $this->get('date1');
		$date2 = $this->get('date2');
		$kondisi = $this->get('kondisi');
		
		
		$user = $this->M_Mutasi->get_index_Mutasi_manager($kondisi, $date1, $date2);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Kode Nomor Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_manager_put()
	{
		$id = $this->put('id_mutasi_rotasi');
		$data = [
			'status_manager' => $this->put('status_manager'),
			'tanggal_manager' => $this->put('tanggal_manager'),
			'ket_manager' => $this->put('ket_manager'),
		];

		if ($this->M_Mutasi->updateApproval($data, $id) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been updated',
			], REST_Controller::HTTP_OK);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to update data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}



}

?>