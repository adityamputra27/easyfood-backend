<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistem_model');
		$this->load->model('unit_model');
		$this->load->library('encryption');
		$this->load->helper('url');
		$this->loginCheck();
	}
	public function index()
	{
		$this->load->view('v_unit');
	}
	public function store()
	{
		$data = [
			'unit_name' => $this->input->post('unitInput'),
			'updated_at' => date('Y-m-d H:i:s'),
			'created_at' => date('Y-m-d H:i:s')
		];
		$this->sistem_model->_input('product_units', $data);

		$response['status'] = true;
		$response['message'] = 'Satuan Produk Berhasil Di Tambahkan!';
		$response['data'] = $data;

		echo json_encode($response);
	}
	public function edit($id)
	{
		$check = $this->sistem_model->_get_where_id('product_units', array('MD5(id)' => $id));

		if (count($check) > 0) {
			$data = [
				'unit_name' => $this->input->post('unitInput'),
				'updated_at' => date('Y-m-d H:i:s')
				// 'created_at' => date('Y-m-d H:i:s')
			];
			$this->sistem_model->_update('product_units', $data, array('MD5(id)' => $id));
			$response['status'] = true;
			$response['message'] = 'Data Satuan Produk Berhasil Di Update!';
			$response['data'] = null;
		} else {
			$response['status'] = false;
			$response['message'] = 'ID Satuan Produk Tidak Ditemukan!';
			$response['data'] = null;
		}

		echo json_encode($response);
	}
	public function delete($id)
	{
		$check = $this->sistem_model->_get_where_id('product_units', array('MD5(id)' => $id));

		if (count($check) > 0) {
			$this->sistem_model->_delete('product_units', array('MD5(id)' => $id));
			$response['status'] = true;
			$response['message'] = 'Data Satuan Produk Berhasil Di Hapus!';
			$response['data'] = null;
		} else {
			$response['status'] = false;
			$response['message'] = 'ID Satuan Produk Tidak Ditemukan!';
			$response['data'] = null;
		}

		echo json_encode($response);
	}
	public function getUnit()
	{
		$list = $this->unit_model->_getDatatables();
		$data = array();
		$no = $_POST['start'];
		$draw = $_POST['draw'];

		foreach ($list as $key => $value) {
			// $id = $this->encryption->encrypt($value->id);
			$id = MD5($value->id);
			$link = '<div class="btn-group"><button type="button" class="btn btn-warning btn-sm" data-mode="edit" data-toggle="modal" data-target="#unitModal" data-id="' . $id . '"><i class="fa fa-edit"></i> Edit</button><button type="button" class="btn btn-danger btn-sm delete-unit" data-action="' . base_url() . 'products/unit/delete/' . $id . '" data-id="' . $id . '"><i class="fa fa-trash"></i> Hapus</a></div>';

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->unit_name;
			$row[] = $link;
			$data[] = $row;
		}

		$output = [
			'draw' => $draw,
			'recordsTotal' => $this->unit_model->_countAll(),
			'recordsFiltered' => $this->unit_model->_countFiltered(),
			'data' => $data
		];

		echo json_encode($output);
	}
}
