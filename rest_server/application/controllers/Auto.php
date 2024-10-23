<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auto extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_login', 'm_kasir', 'm_bku', 'm_history', 'm_auto'));
		$this->load->library('uuid');
	}

	//Auto Scheduller Izin Non Full Day
	function nonFullDay()
	{
		$auto = 'Tes';
		var_dump($auto);
		die;
	}

}
