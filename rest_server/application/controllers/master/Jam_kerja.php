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
class Jam_Kerja extends REST_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        
        $this->load->model('master/M_Jam_Kerja');
    }

    public function index_get()
    {
        $id = $this->get('id_shifting');

        if ($id === null) {
            $jam_kerja = $this->M_Jam_Kerja->getJamkerja();
        } else {
            $jam_kerja = $this->M_Jam_Kerja->getJamkerja($id);
        }

        if ($jam_kerja) {
            $this->response([
                'status' => true,
                'data' => $jam_kerja
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