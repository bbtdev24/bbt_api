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
class Team extends REST_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        
        $this->load->model('master/M_Team');
    }

    public function index_rdamt_get()
    {     
        $jabatan = $this->get('jabatan_struktur');

        if ($jabatan === null) {
            $team = $this->M_Team->getTeamRdamt();
        } else {
            $team = $this->M_Team->getTeamRdamt($jabatan);
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

    public function index_manager_get()
    {
        
        $user = $this->M_Team->getManager();
        
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

    public function index_get()
    {     
        $jabatan = $this->get('jabatan_struktur');

        if ($jabatan === null) {
            $team = $this->M_Team->getJabatan();
        } else {
            $team = $this->M_Team->getJabatan($jabatan);
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

    public function index_team_lokasi_get()
    {     
        $jabatan = $this->get('jabatan_struktur');
        $lokasi = $this->get('lokasi');

       
        $team = $this->M_Team->get_team_lokasi($jabatan, $lokasi);
        

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

?>