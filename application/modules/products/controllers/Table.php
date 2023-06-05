<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Table extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistem_model');
		$this->load->model('table_model');
		$this->load->library('encryption');
		$this->load->helper('url');
		$this->loginCheck();
	}
	public function index()
	{
		$this->load->view('v_table');
	}
	public function store()
	{
		$data = [
			'name' => $this->input->post('tableInput'),
			'description' => $this->input->post('descriptionInput'),
			'updated_at' => date('Y-m-d H:i:s'),
			'created_at' => date('Y-m-d H:i:s')
		];
		$this->sistem_model->_input('tables', $data);

		$response['status'] = true;
		$response['message'] = 'Meja Berhasil Ditambahkan!';
		$response['data'] = $data;

		echo json_encode($response);
	}
	public function edit($id)
	{
		$check = $this->sistem_model->_get_where_id('tables', array('MD5(id)' => $id));

		if (count($check) > 0) {
			$data = [
				'name' => $this->input->post('tableInput'),
				'description' => $this->input->post('descriptionInput'),
				'updated_at' => date('Y-m-d H:i:s')
			];
			$this->sistem_model->_update('tables', $data, array('MD5(id)' => $id));
			$response['status'] = true;
			$response['message'] = 'Data Meja Berhasil Diubah!';
			$response['data'] = null;
		} else {
			$response['status'] = false;
			$response['message'] = 'ID Meja Tidak Ditemukan!';
			$response['data'] = null;
		}

		echo json_encode($response);
	}

	public function delete($id)
	{
		$check = $this->sistem_model->_get_where_id('tables', array('MD5(id)' => $id));

		if (count($check) > 0) {
			$this->sistem_model->_delete('tables', array('MD5(id)' => $id));
			$response['status'] = true;
			$response['message'] = 'Data Meja Berhasil Dihapus!';
			$response['data'] = null;
		} else {
			$response['status'] = false;
			$response['message'] = 'ID Meja Tidak Ditemukan!';
			$response['data'] = null;
		}

		echo json_encode($response);
	}

	public function getTable()
	{
		$list = $this->table_model->_getDatatables();
		$data = array();
		$no = $_POST['start'];
		$draw = $_POST['draw'];

		foreach ($list as $key => $value) {
			$id = MD5($value->id);
			$link = '<div class="btn-group"><button type="button" class="btn btn-warning btn-sm" data-mode="edit" data-toggle="modal" data-target="#modalForm" data-id="' . $id . '"><i class="fa fa-edit"></i> Edit</button><button type="button" class="btn btn-danger btn-sm delete-table" data-id="' . $id . '"><i class="fa fa-trash"></i> Hapus</a></div>';

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->name;
			$row[] = $value->description;
			$row[] = $link;
			$data[] = $row;
		}

		$output = [
			'draw' => $draw,
			'recordsTotal' => $this->table_model->_countAll(),
			'recordsFiltered' => $this->table_model->_countFiltered(),
			'data' => $data
		];

		echo json_encode($output);
	}
}
