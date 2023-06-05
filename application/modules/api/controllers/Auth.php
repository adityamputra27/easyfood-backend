<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	}
	public function login()
	{
		$phone = $this->input->post('phone');
        $password = $this->input->post('password');

        $query = $this->auth_model->validateLogin($phone);

        if (strlen($phone) == 0 || strlen($password) == 0) {
			$response['status'] = false;
			$response['message'] = 'Nomor Telepon atau Password tidak boleh kosong!';
        } else if (count($query) == 0) {
			$response['status'] = false;
			$response['message'] = 'Data tidak ditemukan! Silahkan register!';
		} else {
			if (password_verify($password, $query['password'])) {
				$this->db->select('customers.*');
				$this->db->from('customers');
				$this->db->where('customers.phone', $query['phone']);

				$customers = $this->db->get()->row_array();
				$customers['is_logged_in'] = true;

				$this->db->trans_start();

				$response['status'] = true;
				$response['message'] = 'Login Sukses!';
				$response['data'] = $customers;

				$this->db->trans_complete();
			} else {
				$response['status'] = false;
				$response['message'] = 'Nomor Telepon atau Password salah!';
			}
		}
		echo json_encode($response);
	}

	public function register()
	{
		$fullname = $this->input->post("fullname");
		$phone = $this->input->post("phone");
		$password = $this->input->post("password");

		$phoneExists = $this->auth_model->validateLogin($phone);

		if ($fullname == '' || $phone == '' || $password == '') {
			$response["status"] = false;
			$response["message"] = "Registrasi Gagal! Pastikan Form Terisi!";
		} else if (count($phoneExists) > 0) {
			$response["status"] = false;
			$response["message"] = "Nomor Telepon Sudah Digunakan!";
		} else {
			$payload = [
				"fullname" => $fullname,
				"phone" => $phone,
				"password" => password_hash(
					$password,
					PASSWORD_DEFAULT
				),
				"updated_at" => date("Y-m-d H:i:s"),
				"created_at" => date("Y-m-d H:i:s"),
			];
	
			$this->auth_model->register("customers", $payload);
	
			$response["status"] = true;
			$response["message"] = "Registrasi Berhasil!";
			$response["data"] = $payload;
		}

        echo json_encode($response);
	}
}
