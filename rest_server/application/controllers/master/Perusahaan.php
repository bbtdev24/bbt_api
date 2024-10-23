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
class Perusahaan extends REST_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        
        $this->load->model('master/M_Perusahaan');
    }

    public function index_get()
    {
        $id = $this->get('perusahaan_id');

        if ($id === null) {
            $perusahaan = $this->M_Perusahaan->getPerusahaan();
        } else {
            $perusahaan = $this->M_Perusahaan->getPerusahaan($id);
        }

        if ($perusahaan) {
            $this->response([
                'status' => true,
                'data' => $perusahaan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function indexkode_get()
    {
        $kode_perusahaan = $this->get('kode_perusahaan');

        if ($kode_perusahaan === null) {
            $perusahaan = $this->M_Perusahaan->getkode();
        } else {
            $perusahaan = $this->M_Perusahaan->getkode($kode_perusahaan);
        }

        if ($perusahaan) {
            $this->response([
                'status' => true,
                'data' => $perusahaan
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