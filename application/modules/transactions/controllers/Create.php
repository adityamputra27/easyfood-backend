<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Create extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("sistem_model");
        $this->load->model("create_model");
        $this->load->library("encryption");
        $this->load->helper("string");
        $this->load->helper("url");
        $this->loginCheck();
    }
    public function index()
    {
        $settings = $this->sistem_model->_get_only_limit(
            "settings",
            "shop_name-ASC",
            "1"
        );
        $code = random_string("alnum", 6);
        $this->load->view("v_create", compact("code"));
    }

    public function loadTables()
    {
        $tables = $this->sistem_model->_get('tables', 'name-ASC');
		if (!empty($tables)) {
			$response['status'] = false;
			$response['message'] = 'Tidak ada data meja!';
			$response['data'] = null;
		}
		$response['status'] = true;
		$response['message'] = 'success';
		$response['data'] = $tables;

		echo json_encode($response);
    }

    public function loadCustomers()
    {
        $customers = $this->sistem_model->_get('customers', 'fullname-ASC');
		if (!empty($customers)) {
			$response['status'] = false;
			$response['message'] = 'Tidak ada data pelanggan!';
			$response['data'] = null;
		}
		$response['status'] = true;
		$response['message'] = 'success';
		$response['data'] = $customers;

		echo json_encode($response);
    }

    public function store()
    {
        $request = $this->input->post();
        $this->db->trans_start();

        if (
            $this->sistem_model->_get_wheres("transactions", [
                "code" => $request["code"],
            ])
        ) {
            $this->sistem_model->_delete("transactions", [
                "code" => $request["code"],
            ]);
        }
        $data_transactions = [
            "customers_id" => $request["customers_id"],
            "tables_id" => $request["tables_id"],
            "code" => $request["code"],
            "datetime" => $request["datetime"],
            "total" => $request["total"],
            // "discount" => $request["discountAll"],
            "pay" => $request["totalCash"],
            "change" => $request["totalChange"],
            "payment" => "CASH",
            "status" => "FINISH",
            "users_id" => $this->session->userdata("users_id"),
            "description" => $request["description"],
            "updated_at" => date("Y-m-d H:i:s"),
            "created_at" => date("Y-m-d H:i:s"),
        ];
        $this->sistem_model->_input("transactions", $data_transactions);
        $transactionsId = $this->db->insert_id();

        $productsCount = count($request["foods_id"]);
        for ($i = 0; $i < $productsCount; $i++) {
            $data_transaction_details = [
                "foods_id" => $request["foods_id"][$i],
                "transactions_id" => $transactionsId,
                "subtotal" => $request["subtotal"][$i],
                "quantity" => $request["qty"][$i],
                "price" => $request["price"][$i],
                "discount" => $this->checkPrice($request["discountEach"][$i]),
                "updated_at" => date("Y-m-d H:i:s"),
                "created_at" => date("Y-m-d H:i:s"),
            ];
            $this->sistem_model->_input(
                "transaction_details",
                $data_transaction_details
            );
        }

        $response["status"] = true;
        $response["message"] = "Transaksi Berhasil!";
        $response["data"] = $transactionsId;

        $this->db->trans_complete();

        echo json_encode($response);
    }

    public function printInvoice($transactions_id)
    {
        $this
            ->db->select('transactions.total as total, transactions.transaction_date as tanggal_transaksi, 
    transactions.id, transactions.invoice as nota, users.name as nama_kasir, transactions.discount as total_discount,
    transactions.total_cash as total_bayar, transactions.total_change as kembalian');
        $this->db->join("users", "transactions.users_id = users.id");
        $this->db->where("transactions.id", $transactions_id);
        $transactions = $this->db->get("transactions")->result();
        foreach ($transactions as $key => &$value) {
            $this->db->select("transaction_details.*, products.name");
            $this->db->from("transaction_details");
            $this->db->join(
                "transactions",
                "transactions.id = transaction_details.transactions_id"
            );
            $this->db->join(
                "products",
                "transaction_details.products_id = products.id"
            );
            $this->db->where("transaction_details.transactions_id", $value->id);
            $value->transaction_details = $this->db->get()->result();
        }
        $data["transactions"] = $transactions[0];

        $this->db->select("settings.*");
        $this->db->limit(1);
        $this->db->from("settings");
        $data["settings"] = $this->db->get()->row_array();

        $this->load->view("v_print", $data);
        // echo json_encode($data);
    }
    public function delete($transactions_id)
    {
        $check = $this->sistem_model->_get_where_id("transactions", [
            "MD5(id)" => $transactions_id,
        ]);
        $this->db->select("transactions.*");
        $this->db->join("users", "transactions.users_id = users.id");
        $this->db->order_by("transactions.transaction_date", "DESC");
        $this->db->where("md5(transactions.id)", $transactions_id);
        $transactions = $this->db->get("transactions")->result();
        foreach ($transactions as $key => &$value) {
            $this->db->select(
                "transaction_details.*, products.name, stock_ins.total"
            );
            $this->db->from("transaction_details");
            $this->db->join(
                "transactions",
                "transactions.id = transaction_details.transactions_id"
            );
            $this->db->join(
                "products",
                "transaction_details.products_id = products.id"
            );
            $this->db->join(
                "stock_ins",
                "transaction_details.stock_ins_id = stock_ins.id"
            );
            $this->db->where("transaction_details.transactions_id", $value->id);
            $value->transaction_details = $this->db->get()->result();
        }
        if (count($check) > 0) {
            foreach ($transactions as $transaction) {
                // update stock
                foreach ($value->transaction_details as $key => $transaction_detail) {
                    $quantity = $transaction_detail->quantity;
                    $total = isset($transaction_detail->total) ? $transaction_detail->total : 0;

                    $stock_ins = [
                        "total" => ($transaction_detail->total += $quantity),
                    ];

                    $this->sistem_model->_update("stock_ins", $stock_ins, [
                        "id" => $transaction_detail->stock_ins_id,
                    ]);
                }
            }
            $this->sistem_model->_delete("transactions", [
                "MD5(id)" => $transactions_id,
            ]);
            $response["status"] = true;
            $response["message"] = "Data Transaksi Berhasil Di Hapus!";
            $response["data"] = null;
        } else {
            $response["status"] = false;
            $response["message"] = "Transaksi Tidak Ditemukan!";
            $response["data"] = null;
        }
        echo json_encode($response);
    }

    public function hold()
    {
        $request = $this->input->post();
        $this->db->trans_start();

        //insert transactions
        $data_transactions = [
            "invoice" => $request["invoice"],
            "transaction_date" => $request["transaction_date"],
            "total" => $request["total_bayar"],
            "total_cash" => 0,
            "total_change" => 0,
            "payment_type" => "-",
            "status" => "PENDING",
            "users_id" => $this->session->userdata("users_id"),
            "description" => "",
            "updated_at" => date("Y-m-d H:i:s"),
            "created_at" => date("Y-m-d H:i:s"),
        ];
        $this->sistem_model->_input("transactions", $data_transactions);
        $transactionId = $this->db->insert_id();

        // insert transactions detail
        $productsCount = count($request["products_id"]);
        for ($i = 0; $i < $productsCount; $i++) {
            $data_transaction_details = [
                "stock_ins_id" => $request["stock_ins_id"][$i],
                "products_id" => $request["products_id"][$i],
                "transactions_id" => $transactionId,
                "sub_total" => $request["subtotal"][$i],
                "quantity" => $request["qty"][$i],
                "price" => $request["price"][$i],
                "discount" => $request["discountEach"][$i],
                "description" => "PENDING",
                "updated_at" => date("Y-m-d H:i:s"),
                "created_at" => date("Y-m-d H:i:s"),
            ];
            $this->sistem_model->_input(
                "transaction_details",
                $data_transaction_details
            );
        }

        $response["status"] = true;
        $response["message"] = "Transaksi Berhasil Di Hold!";

        $this->db->trans_complete();

        echo json_encode($response);
    }

    public function getTransactionHold()
    {
        $list = $this->create_model->_getDatatables();

        foreach ($list as &$value) {
            $this->db->select(
                'transaction_details.quantity, transaction_details.discount, transaction_details.price,
        transaction_details.sub_total, products.name, products.capital_price, transaction_details.stock_ins_id'
            );
            $this->db->from("transaction_details");
            $this->db->join(
                "transactions",
                "transactions.id = transaction_details.transactions_id"
            );
            $this->db->join(
                "products",
                "transaction_details.products_id = products.id"
            );
            $this->db->where("transaction_details.transactions_id", $value->id);
            $value->transaction_details = $this->db->get()->result();
        }

        $result = [];
        for ($i = 0; $i < count($list); $i++) {
            $result[] = $list[$i];
        }

        $data = [];
        $no = $_POST["start"];
        $draw = $_POST["draw"];

        foreach ($result as $value) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] =
                '<span class="label label-primary">' .
                $value->invoice .
                "</span>";
            $row[] = $value->transaction_date;
            $row[] = $this->getTransactionHoldDetail(
                $value->transaction_details
            );
            $row[] = "Rp. " . number_format($value->total, 0, ".", ".") . ",-";
            $row[] =
                ' <div class="btn-group text-center">
                            <button type="button" data-id ="' .
                $value->id .
                '" id="Proccess" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Proses</button>
                            <button type="button" class="btn btn-danger btn-sm delete-transaction-hold" data-id="' .
                md5($value->id) .
                '"><i class="fa fa-times-circle"></i> Batalkan</button>
                        </div>';
            $data[] = $row;
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $this->create_model->_countAll(),
            "recordsFiltered" => $this->create_model->_countFiltered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }

    private function getTransactionHoldDetail($attr)
    {
        $record = "";
        foreach ($attr as $detailRows) {
            $record .=
                '<div style="padding-bottom:0px;"><table class="table w-100" style="font-size:12px;pointer-events:none; margin-bottom: 3px;"><tbody><tr>';
            $record .=
                '<td style="padding: 5px 3px 5px 3px;border-bottom:1px solid #ccc;">' .
                strtoupper($detailRows->name) .
                ' <span style="width:10px; border-bottom:1px solid #ccc; padding: 3px;" class="label bg-maroon">' .
                $detailRows->quantity .
                "</span></td>";
            $record .= "</tr></tbody></table></div>";
        }
        return $record;
    }

    public function proccess($id)
    {
        $transactions = $this->sistem_model->_get_wheres("transactions", [
            "id" => $id,
        ]);
        $this->db->select(
            "transaction_details.*, products.*, product_units.unit_name as unit_name"
        );
        $this->db->from("transaction_details");
        $this->db->join(
            "transactions",
            "transactions.id = transaction_details.transactions_id"
        );
        $this->db->join(
            "products",
            "transaction_details.products_id = products.id"
        );
        $this->db->join(
            "product_units",
            "products.product_units_id = product_units.id"
        );
        // $this->db->join('product_units', 'transaction_details.product_units_id = product_units.id');

        $this->db->where(
            "transaction_details.transactions_id",
            $transactions[0]["id"]
        );
        $transactions[0]["transaction_details"] = $this->db->get()->result();

        echo json_encode($transactions);
    }

    public function delete_hold($transactions_id)
    {
        $check = $this->sistem_model->_get_where_id("transactions", [
            "MD5(id)" => $transactions_id,
        ]);
        if (count($check) > 0) {
            $this->sistem_model->_delete("transaction_details", [
              "MD5(transactions_id)" =>  $transactions_id
            ]);
            $this->sistem_model->_delete("transactions", [
                "MD5(id)" => $transactions_id,
            ]);
            $response["status"] = true;
            $response["message"] = "Transaksi Hold Berhasil Di Hapus!";
            $response["data"] = null;
        } else {
            $response["status"] = false;
            $response["message"] = "Transaksi Hold Tidak Ditemukan!";
            $response["data"] = null;
        }
        echo json_encode($response);
    }

    public function getProductExpiredDate($productId)
    {
        $expiredDateExists = $this->create_model->expiredDateExists($productId);

        if ($expiredDateExists->num_rows() == 0) {
            $result = $this->db->query("SELECT sti.id, sti.products_id, sti.total, 
                                        sti.expired_date, sti.status, p.barcode, p.name, p.selling_price, pu.unit_name 
                                        FROM stock_ins AS sti LEFT JOIN products AS p ON sti.products_id = p.id
                                        LEFT JOIN product_units as pu ON p.product_units_id = pu.id
                                        WHERE sti.total > 0 AND sti.expired_date IS NULL 
                                        AND sti.products_id = ".$productId." ORDER BY sti.created_at ASC")->row_array();
        } else {
            $result = $this->db->query("SELECT sti.id, sti.products_id, sti.total, sti.expired_date, sti.status, 
                                        p.barcode, p.name, p.selling_price, pu.unit_name 
                                        FROM stock_ins AS sti LEFT JOIN products AS p ON sti.products_id = p.id
                                        LEFT JOIN product_units as pu ON p.product_units_id = pu.id
                                        WHERE sti.total > 0 AND sti.expired_date IS NOT NULL AND sti.products_id = ".$productId."
                                        ORDER BY sti.expired_date ASC")->row_array();
        }

        if (isset($result['products_id'])) {
            $response['status'] = true;
            $response['message'] = 'success';
            $response['data'] = $result;
        } else {
            $response['status'] = false;
            $response['message'] = 'failed';
            $response['data'] = null;
        }

        echo json_encode($response);
    }
}
