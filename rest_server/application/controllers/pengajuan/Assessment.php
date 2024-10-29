<?php
defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */

// use namespace
use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

/**
 * 
 */
class Assessment extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        $this->db_absensi = $this->load->database('db_absensi', TRUE);

        $this->load->model('pengajuan/M_Assessment');
    }

    public function index_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru'),
            'pertanyaan' => $this->post('pertanyaan'),
            'id_jawaban' => $this->post('id_jawaban'),
        ];

        if ($this->M_Assessment->createAssesment($data) > 0) {
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

    public function index_get()
    {
        $nik_baru = $this->get('nik_baru');
        $tanggal = $this->get('tanggal');


        $team = $this->M_Assessment->get_count($nik_baru, $tanggal);


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

    public function index_soal_get()
    {

        $team = $this->M_Assessment->getSoal();


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

    public function index_jawaban_get()
    {
        $id = $this->get('id');
        $team = $this->M_Assessment->getJawaban($id);


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
}
