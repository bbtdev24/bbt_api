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
class Seragam extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        $this->db_absensi = $this->load->database('db_absensi', TRUE);


        $this->load->model('master/M_Seragam');
    }

    public function index_get()
    {
        $id = $this->get('id_seragam');

        if ($id === null) {
            $seragam = $this->M_Seragam->getSeragam();
        } else {
            $seragam = $this->M_Seragam->getSeragam($id);
        }

        if ($seragam) {
            $this->response([
                'status' => true,
                'data' => $seragam
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
