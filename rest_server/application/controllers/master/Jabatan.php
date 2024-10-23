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
class Jabatan extends REST_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        
        $this->load->model('master/M_Jabatan');
    }

    public function index_get()
    {
        $id = $this->get('no_jabatan_karyawan');

        if ($id === null) {
            $jabatan = $this->M_Jabatan->getJabatan();
        } else {
            $jabatan = $this->M_Jabatan->getJabatan($id);
        }

        if ($jabatan) {
            $this->response([
                'status' => true,
                'data' => $jabatan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_departement_get()
    {
        $dept = $this->get('dept_jabatan_karyawan');

        if ($dept === null) {
            $jabatan = $this->M_Jabatan->getJabatanDepart();
        } else {
            $jabatan = $this->M_Jabatan->getJabatanDepart($dept);
        }

        if ($jabatan) {
            $this->response([
                'status' => true,
                'data' => $jabatan
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