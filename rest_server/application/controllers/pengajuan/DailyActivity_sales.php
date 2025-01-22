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
class DailyActivity_sales extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('db2', TRUE);
		$this->db9 = $this->load->database('db9', TRUE);
		$this->db10 = $this->load->database('db10', TRUE);
		$this->db11 = $this->load->database('db11', TRUE);

		$this->load->model('pengajuan/M_DailyActivity_sales');
	}

	public function index_History_get()
	{
		$nik_baru = $this->get('nik_baru');

		$user = $this->M_DailyActivity_sales->getHistoryUraian($nik_baru);

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

	public function index_kategori_get()
	{
		$user = $this->M_DailyActivity_sales->getKategori();

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

	public function index_one_kategori_get()
	{
		$kategori = $this->get('kategori');
		$user = $this->M_DailyActivity_sales->getOneKategori($kategori);

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

	public function index_tanggal_get()
	{
		$nik_baru = $this->get('nik_baru');

		$user = $this->M_DailyActivity_sales->getTanggalDailyActivity($nik_baru);

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

	public function index_tanggal_nik_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');

		$user = $this->M_DailyActivity_sales->getTanggalDailyActivityNik($nik_baru, $tanggal);

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

	public function index_tanggal_nik2_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');

		$user = $this->M_DailyActivity_sales->getTanggalDailyActivityNik2($nik_baru, $tanggal);

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

	public function index_tanggal_saved_get()
	{
		$nik_baru = $this->get('nik_baru');

		$user = $this->M_DailyActivity_sales->getSavedTanggalDailyActivity($nik_baru);

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

	public function index_realization_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');

		$user = $this->M_DailyActivity_sales->getRealization($nik_baru, $tanggal);

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

	public function index_per_tanggal_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');
		$tanggal2 = $this->get('tanggal2');

		$user = $this->M_DailyActivity_sales->getSavedTanggalDailyActivity2($nik_baru, $tanggal, $tanggal2);

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

	public function index_per_range_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');
		$tanggal2 = $this->get('tanggal2');

		$user = $this->M_DailyActivity_sales->getRangeDate($nik_baru, $tanggal, $tanggal2);

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

	public function index_realization_plan_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');
		$status = $this->get('status');

		$user = $this->M_DailyActivity_sales->getRealizationPlan($nik_baru, $tanggal, $status);

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

	public function index_count_realization_plan_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');
		$tanggal2 = $this->get('tanggal2');

		$user = $this->M_DailyActivity_sales->getCountRealization($nik_baru, $tanggal, $tanggal2);

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

	public function index_count_plan_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');
		$tanggal2 = $this->get('tanggal2');

		$user = $this->M_DailyActivity_sales->getCountPlan($nik_baru, $tanggal, $tanggal2);

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

	public function index_per_range_status_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');
		$tanggal2 = $this->get('tanggal2');
		$status = $this->get('status');

		$user = $this->M_DailyActivity_sales->getRangeDateStatus($nik_baru, $tanggal, $tanggal2, $status);

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

	public function index_per_range_status_not_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');
		$tanggal2 = $this->get('tanggal2');

		$user = $this->M_DailyActivity_sales->getRangeDateStatusNot($nik_baru, $tanggal, $tanggal2);

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

	public function index_id_get()
	{
		$id = $this->get('id');

		$user = $this->M_DailyActivity_sales->getId($id);

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

	public function index_draft_nik_get()
	{
		$nik_baru = $this->get('nik_baru');

		$user = $this->M_DailyActivity_sales->getDraftNik($nik_baru);

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

	public function index_get_lastId_get()
	{
		$nik_baru = $this->get('nik_baru');
		$tanggal = $this->get('tanggal');

		$user = $this->M_DailyActivity_sales->getLastId($nik_baru, $tanggal);

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

	public function index_Daily_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'jabatan' => $this->post('jabatan'),
			'date' => $this->post('date'),
			'start' => $this->post('start'),
			'end' => $this->post('end'),
			'kategori' => $this->post('kategori'),
			'ket_plan' => $this->post('ket_plan'),
			'status' => '0',
			'draft' => '0',
		];

		if ($this->M_DailyActivity_sales->createDailyActivity($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_daily_draft_put()
	{
		$nik_baru = $this->put('nik_baru');
		$date = $this->put('date');
		$draft_awal = $this->put('draft_awal');

		$data = [
			'draft' => $this->put('draft'),
		];

		if ($this->M_DailyActivity_sales->updateDraft($data, $nik_baru, $date, $draft_awal) > 0) {
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

	public function index_realisasi_put()
	{
		$id = $this->put('id');
		$data = [
			'start_realisasi' => $this->put('start_realisasi'),
			'end_realisasi' => $this->put('end_realisasi'),
			'ket_realisasi' => $this->put('ket_realisasi'),
			'status' => $this->put('status'),
			'pengganti' => $this->put('pengganti'),
			'user_update' => $this->put('user_update'),
			'lat' => $this->put('lat'),
			'lon' => $this->put('lon'),
		];

		if ($this->M_DailyActivity_sales->updateRealisasi($data, $id) > 0) {
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

	public function index_hapus_per_id_put()
	{
		$id = $this->put('id');
		$data = [
			'draft' => '2',
		];

		if ($this->M_DailyActivity_sales->HapusDraftPerId($data, $id) > 0) {
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

	public function index_update_plan_put()
	{
		$id = $this->put('id');
	
		$data = [
			'start' => $this->put('start'),
			'end' => $this->put('end'),
			'ket_plan' => $this->put('ket_plan'),
			'kategori' => $this->put('kategori'),
		];

		if ($this->M_DailyActivity_sales->updatePlan($data, $id) > 0) {
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

	public function index_simpan_per_id_put()
	{
		$id = $this->put('id');
		$data = [
			'draft' => '1',
		];

		if ($this->M_DailyActivity_sales->SimpanDraftPerId($data, $id) > 0) {
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

	public function index_edit_per_id_put()
	{
		$id = $this->put('id');
		$data = [
			'date' => $this->put('date'),
			'start' => $this->put('start'),
			'end' => $this->put('end'),

			'kategori' => $this->put('kategori'),
			'ket_plan' => $this->put('ket_plan'),
		];

		if ($this->M_DailyActivity_sales->EditDraftPerId($data, $id) > 0) {
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


	public function index_classCustomer_get()
	{
		$user = $this->M_DailyActivity_sales->getClassCustomer();

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


	public function index_customer_get()
	{
		$szSoldToBranchId = $this->get('szSoldToBranchId');
		$szclass = $this->get('szclass');
		$user = $this->M_DailyActivity_sales->getCustomerALL($szSoldToBranchId, $szclass);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$user_asa = $this->M_DailyActivity_sales->getCustomerALL_ASA($szSoldToBranchId, $szclass);
			if ($user_asa) {
				$this->response([
					'status' => true,
					'data' => $user_asa
			], REST_Controller::HTTP_OK);
				} else {
				$this->response([
					'status' => false,
					'message' => 'Kode Nomor Not Found'
				], REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}

	public function index_customerId_get()
	{
		$szId = $this->get('szId');
		$user = $this->M_DailyActivity_sales->getCustomer($szId);

		if ($user) {
			$this->response([
				'status' => true,
				'data' => $user
			], REST_Controller::HTTP_OK);
		} else {
			$user_asa = $this->M_DailyActivity_sales->getCustomer_ASA($szId);
			if ($user_asa) {
				$this->response([
					'status' => true,
					'data' => $user_asa
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Kode Nomor Not Found'
				], REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}

	public function index_competitor_get()
	{
		$user = $this->M_DailyActivity_sales->getCompetitor();

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

	public function index_DailyExternal_post()
	{
		$nomor = $this->M_DailyActivity_sales->getNomor();
		foreach($nomor as $row) {
			$nomor_daily = $row['nomor_daily'];
		}

		$getIdProduk = $this->M_DailyActivity_sales->getIdProduk($this->post('brand'));
		foreach($getIdProduk as $row) {
			$id = $row['id'];
		}

		$getNikLokasi = $this->M_DailyActivity_sales->getLokasi($this->post('nik_baru'));
		foreach($getNikLokasi as $nikRow) {
			$lokasiHrd = $nikRow['lokasi_hrd'];
		}
		if($this->post('lokasi') == 'lokasi'){
			$location = $lokasiHrd;
		} else {
			$location = $this->post('lokasi');
		}

		$data = [
			'no_daily' => $nomor_daily,
			'nik' => $this->post('nik_baru'),
			'lokasi' => $location,
			'segment' => $this->post('segment'),
			'toko' => $this->post('id_customer'),
			'ket' => $this->post('ket_plan'),
			'status' => '1',
			'lat' => $this->post('lat'),
			'lon' => $this->post('lon'),
			'out_radius' => $this->post('out_radius'),
			'ket_out_radius' => $this->post('ket_out_radius'),
			'type_customer' => $this->post('type_customer'),
			'in' => $this->post('in'),
			'out' => $this->post('out'),
		];

		if (strpos($this->post('harga_beli_normal'), ',') !== false) {
		    $cleanedNumberStringNormal = str_replace(",", "", $this->post('harga_beli_normal'));
		} else {
		    $cleanedNumberStringNormal = $this->post('harga_beli_normal');
		}

		if (strpos($this->post('diskon'), ',') !== false) {
		    $cleanedNumberStringDiskon = str_replace(",", "", $this->post('diskon'));
		} else {
		    $cleanedNumberStringDiskon = $this->post('diskon');
		}

		if (strpos($this->post('cashback'), ',') !== false) {
		    $cleanedNumberStringCashback = str_replace(",", "", $this->post('cashback'));
		} else {
		    $cleanedNumberStringCashback = $this->post('cashback');
		}

		if (strpos($this->post('harga_beli_net'), ',') !== false) {
		    $cleanedNumberStringHargaBeli = str_replace(",", "", $this->post('harga_beli_net'));
		} else {
		    $cleanedNumberStringHargaBeli = $this->post('harga_beli_net');
		}

		if (strpos($this->post('harga_jual'), ',') !== false) {
		    $cleanedNumberStringHargaJual = str_replace(",", "", $this->post('harga_jual'));
		} else {
		    $cleanedNumberStringHargaJual = $this->post('harga_jual');
		}

		$data2 = [
			'no_daily' => $nomor_daily,
			'nik_baru' => $this->post('nik_baru'),
			'market_activity' => $this->post('market_activity'),
			'brand' => $this->post('brand'),
			'sku' => $this->post('sku'),
			'harga_beli_normal' => $cleanedNumberStringNormal,
			'diskon' => $cleanedNumberStringDiskon,
			'cashback' => $cleanedNumberStringCashback,
			'harga_beli_net' => $cleanedNumberStringHargaBeli,
			'harga_jual' => $cleanedNumberStringHargaJual,
			'margin' => $cleanedNumberStringHargaJual - $cleanedNumberStringHargaBeli,
			'feedback' => $this->post('feedback'),
			'feedback_2' => $this->post('feedback_2'),
			'feedback_3' => $this->post('feedback_3'),
			'feedback_4' => $this->post('feedback_4'),
			'feedback_5' => $this->post('feedback_5'),
			'qty' => $this->post('qty'),

		];

		$this->M_DailyActivity_sales->createMarketInsight($data2);

		if ($this->M_DailyActivity_sales->createMarketInsightHeader($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_header_get()
	{
		$nik = $this->get('nik');
		$date = $this->get('date');

		$user = $this->M_DailyActivity_sales->getHeader($nik, $date);

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


	public function index_sub_get()
	{
		$no_daily = $this->get('no_daily');

		$user = $this->M_DailyActivity_sales->getSub($no_daily);

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

	public function index_hapus_transaksi_post()
	{
		$no_daily = $this->post('no_daily');
	
		$data = [
			'status' => '2',
		];

		if ($this->M_DailyActivity_sales->hapusTransaksi($data, $no_daily) > 0) {
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

	public function index_Check_In_Failed_get()
	{
		$get = $this->M_DailyActivity_sales->getReasonCheckInFailed();
		if ($get) {
			$this->response([
				'status' => true,
				'data' => $get
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Not Found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_sku_get()
	{
		$user = $this->M_DailyActivity_sales->getSKU();

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

	public function index_status_selesai_post()
	{
		$no_daily = $this->post('no_daily');
	
		$data = [
			'status_end' => '1',
			'tanggal_end' => $this->post('tanggal_end'),
		];

		if ($this->M_DailyActivity_sales->hapusTransaksi($data, $no_daily) > 0) {
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



	public function index_StatusNik_get()
	{
		$nik_baru = $this->get('nik_baru');

		$user = $this->M_DailyActivity_sales->getStatusNik($nik_baru);

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

	public function index_DailyStatus_post()
	{
		$data = [
			'nik_baru' => $this->post('nik_baru'),
			'tanggal_start' => $this->post('tanggal_start'),
			'tanggal' => $this->post('tanggal'),
		];

		if ($this->M_DailyActivity_sales->createStatusKunjungan($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'new pengajuan has been created',
			], REST_Controller::HTTP_CREATED);
		} else {
			// Gagal
			$this->response([
				'status' => false,
				'message' => 'Failed to create new data'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_updateKunjungan_put()
	{
		$nik_baru = $this->put('nik_baru');
		$tanggal = $this->put('tanggal');

		$data = [
			'status_kunjungan' => '1',
			'tanggal_end' => $this->put('tanggal_end'),
		];

		if ($this->M_DailyActivity_sales->UpdateStatusKunjungan($data, $nik_baru, $tanggal) > 0) {
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

	public function index_depo_get()
	{
		$kode_dms = $this->get('kode_dms');
		$user = $this->M_DailyActivity_sales->getStatusDepo($kode_dms);

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

	public function index_feedback_get()
	{
		$user = $this->M_DailyActivity_sales->getFeedback();

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


	public function index_feedbackHeader_get()
	{
		$user = $this->M_DailyActivity_sales->getHeaderFeedback();

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

	public function index_feedbackFooter_get()
	{
		$jenis = $this->get('jenis');
		$user = $this->M_DailyActivity_sales->getFooterFeedback($jenis);

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

	public function index_depoGeoTag_get()
	{
		$depo_nama = $this->get('depo_nama');
		$user = $this->M_DailyActivity_sales->getDepo($depo_nama);

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


	public function index_nearest_get()
	{
		$latitude = $this->get('latitude');
		$longitude = $this->get('longitude');
		$user = $this->M_DailyActivity_sales->getNearest($latitude, $longitude);

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


	

}

?>