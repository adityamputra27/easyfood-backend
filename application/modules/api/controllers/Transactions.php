<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transactions extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('sistem_model');
		$this->load->model('transactions_model');
        $this->load->helper("string");
	}
	public function index()
	{
		$response['data'] = $this->transactions_model->fetchAll();
		echo json_encode($response);
	}

	public function create()
	{
		$request = $this->input->post();

        $this->db->trans_start();

		$total = 0;
		for ($i = 0; $i < count($request['foods_id']); $i++) { 
			$total += $request['quantity'][$i] * $request['price'][$i];
		}

        if (
            $this->sistem_model->_get_wheres("transactions", [
                "code" => random_string("alnum", 6),
            ])
        ) {
            $this->sistem_model->_delete("transactions", [
                "code" => random_string("alnum", 6),
            ]);
        }
        $transactions = [
            "customers_id" => $request["customers_id"],
            "tables_id" => $request["tables_id"],
            "code" => random_string("alnum", 6),
            "datetime" => date('Y-m-d H:i:s'),
            "total" => $total,
            "pay" => 0,
            "change" => 0,
            "payment" => "CASH",
            "status" => "WAITING",
            "updated_at" => date("Y-m-d H:i:s"),
            "created_at" => date("Y-m-d H:i:s"),
        ];
        $this->sistem_model->_input("transactions", $transactions);
        $transactionsId = $this->db->insert_id();

        $foods = count($request["foods_id"]);
        for ($i = 0; $i < $foods; $i++) {
            $transactionDetails = [
                "foods_id" => $request["foods_id"][$i],
                "transactions_id" => $transactionsId,
                "subtotal" => $request["quantity"][$i] * $request["price"][$i],
                "quantity" => $request["quantity"][$i],
                "price" => $request["price"][$i],
                "updated_at" => date("Y-m-d H:i:s"),
                "created_at" => date("Y-m-d H:i:s"),
            ];
            $this->sistem_model->_input(
                "transaction_details",
                $transactionDetails
            );
        }

        $response["status"] = true;
        $response["message"] = "Pesanan Berhasil Dibuat!";
        $response["code"] = $transactions['code'];

        $this->db->trans_complete();

        echo json_encode($response);
	}
}
