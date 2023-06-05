<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('categories_model');
	}
	public function index()
	{
		$response['data'] = $this->categories_model->fetchAll();
		echo json_encode($response);
	}
}
