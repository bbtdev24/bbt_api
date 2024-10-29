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
class Event extends REST_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        
        $this->load->model('master/M_Event');
    }

    public function index_get()
    {

        $event = $this->M_Event->getEvent();
        $birth_date = $this->get('birth_date');

        if ($birth_date === null) {
            $event = $this->M_Event->getEvent();
        } else {
            $event = $this->M_Event->getEvent($birth_date);
        }

        if ($event) {
            $this->response([
                'status' => true,
                'data' => $event
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