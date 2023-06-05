<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistem_model');
		$this->load->model('customers_model');
		$this->load->library('encryption');
		$this->load->helper('url');
		$this->loginCheck();
	}
	public function index()
	{
		$this->load->view('v_customers');
	}
	public function store()
	{
		$data = [
			'fullname' => $this->input->post('fullname'),
			'phone' => $this->input->post('phone'),
			'address' => $this->input->post('address'),
			'updated_at' => date('Y-m-d H:i:s'),
			'created_at' => date('Y-m-d H:i:s')
		];
		$this->sistem_model->_input('customers', $data);

		$response['status'] = true;
		$response['message'] = 'Pelanggan Berhasil Ditambahkan!';
		$response['data'] = $data;

		echo json_encode($response);
	}
	public function edit($id)
	{
		$check = $this->sistem_model->_get_where_id('customers', array('MD5(id)' => $id));

		if (count($check) > 0) {
			$data = [
				'fullname' => $this->input->post('fullname'),
			'phone' => $this->input->post('phone'),
			'address' => $this->input->post('address'),
				'updated_at' => date('Y-m-d H:i:s')
			];
			$this->sistem_model->_update('customers', $data, array('MD5(id)' => $id));
			$response['status'] = true;
			$response['message'] = 'Data Pelanggan Berhasil Diubah!';
			$response['data'] = null;
		} else {
			$response['status'] = false;
			$response['message'] = 'ID Pelanggan Tidak Ditemukan!';
			$response['data'] = null;
		}

		echo json_encode($response);
	}

	public function delete($id)
	{
		$check = $this->sistem_model->_get_where_id('customers', array('MD5(id)' => $id));

		if (count($check) > 0) {
			$this->sistem_model->_delete('customers', array('MD5(id)' => $id));
			$response['status'] = true;
			$response['message'] = 'Data Pelanggan Berhasil Dihapus!';
			$response['data'] = null;
		} else {
			$response['status'] = false;
			$response['message'] = 'ID Pelanggan Tidak Ditemukan!';
			$response['data'] = null;
		}

		echo json_encode($response);
	}

	public function getCustomers()
	{
		$list = $this->customers_model->_getDatatables();
		$data = array();
		$no = $_POST['start'];
		$draw = $_POST['draw'];

		foreach ($list as $key => $value) {
			$id = MD5($value->id);
			$link = '<div class="btn-group"><button type="button" class="btn btn-warning btn-sm" data-mode="edit" data-toggle="modal" data-target="#modalForm" data-id="' . $id . '"><i class="fa fa-edit"></i> Edit</button><button type="button" class="btn btn-danger btn-sm delete-customers" data-id="' . $id . '"><i class="fa fa-trash"></i> Hapus</a></div>';

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->fullname;
			$row[] = $value->phone;
			$row[] = $value->address;
			$row[] = $link;
			$data[] = $row;
		}

		$output = [
			'draw' => $draw,
			'recordsTotal' => $this->customers_model->_countAll(),
			'recordsFiltered' => $this->customers_model->_countFiltered(),
			'data' => $data
		];

		echo json_encode($output);
	}
}
