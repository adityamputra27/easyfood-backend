<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tables extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('tables_model');
	}
	public function index()
	{
		$response['data'] = $this->tables_model->fetchAll();
		echo json_encode($response);
	}
}
