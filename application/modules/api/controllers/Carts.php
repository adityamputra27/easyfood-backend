<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Carts extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('carts_model');
	}
	public function index()
	{
		$response['data'] = $this->carts_model->fetchAll();
		echo json_encode($response);
	}

	public function create()
	{
		$foodsId = $this->input->post('foods_id');
		$customersId = $this->input->post('customers_id');
		$quantity = $this->input->post('quantity');

		$existCarts = $this->carts_model->existCarts($customersId, $foodsId);

		if ($foodsId == '' || $customersId == '' || $quantity == '') {
			$response['status'] = false;
			$response['message'] = 'Gagal Menambahkan ke Keranjang!';
		} else if (count($existCarts) > 0) {
			$this->carts_model->updateCarts([
				'foods_id' => $foodsId,
				'customers_id' => $customersId,
				'quantity' => $existCarts->quantity + $quantity,
			], [
				'id' => $existCarts->id,
			]);
			$response['status'] = true;
			$response['message'] = 'Berhasil Menambahkan ke Keranjang!';
		} else {
			$payload = [
				'foods_id' => $foodsId,
				'customers_id' => $customersId,
				'quantity' => $quantity,
			];
	
			$this->carts_model->insertCarts($payload);

			$response['status'] = true;
			$response['message'] = 'Berhasil Menambahkan ke Keranjang!';
		}

		echo json_encode($response);
	}

	public function customer($customersId)
	{
		$response['data'] = $this->carts_model->fetchCartCustomers($customersId);
		echo json_encode($response);
	}

	public function delete($id)
	{
		$this->carts_model->deleteCarts($id);

		$response['status'] = true;
		$response['message'] = 'Berhasil Menghapus Keranjang!';

		echo json_encode($response);
	}
}
