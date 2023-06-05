<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Foods extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('foods_model');
	}
	public function index()
	{
		$response['data'] = $this->foods_model->fetchAll();
		echo json_encode($response);
	}

	public function detail($id)
	{
		$response['data'] = $this->foods_model->fetchById($id);
		echo json_encode($response);
	}
}
