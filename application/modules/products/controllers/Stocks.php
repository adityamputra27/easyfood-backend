<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Stocks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("sistem_model");
		$this->load->model('lists_model');
        $this->load->model("stocks_model");
        $this->load->library("encryption");
        $this->load->helper("url");
        $this->loginCheck();
    }

    public function details($productId)
    {
		$data['product'] = $this->lists_model->getProductById($productId);
        $this->load->view("v_stocks", $data);
    }

	public function getProduct()
	{
		$lists = $this->lists_model->_getDatatables();
		$no = $this->input->post('no');
		$draw = $this->input->post('draw');
		$data = [];

		foreach ($lists as $key => $value) {
			$id = MD5($value->id);
			$link = '<button type="button" class="btn btn-info btn-sm selectStockProduct" id="selectProduct" data-idproduct="' . $value->id . '" data-capital="'.TRIM($value->capital_price).'" data-name="' . $value->name . '" data-price="' . $value->selling_price . '" data-barcode="' . $value->barcode . '" data-stock="' . $value->stock . '" data-id="' . $id . '" data-unit="'.$value->unit_name.'"><i class="glyphicon glyphicon-arrow-down"></i> Pilih</button>';

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<span class="label bg-maroon">'.$value->barcode.'</span>';
			$row[] = $value->name;
			$row[] = $value->unit_name;
			$row[] = 'Rp. ' . number_format($value->selling_price) . ',-';
			$row[] = $value->stock == 0 ? '<span class="badge bg-maroon">Habis</span>' : $value->stock;
			$row[] = $link;
			$data[] = $row;
		}

		$output = [
			'draw' => $draw,
			'recordsTotal' => $this->lists_model->_countAll(),
			'recordsFiltered' => $this->lists_model->_countFiltered(),
			'data' => $data
		];

		echo json_encode($output);
	}

	public function getStockIn()
    {
        $list = $this->stocks_model->_getDatatables();
        $data = [];
        $no = $_POST["start"];
        $draw = $_POST["draw"];

        foreach ($list as $key => $value) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = date('d-m-Y H:i:s', strtotime($value->date));
            $row[] = $value->total." "."(".$value->unit_name.")";
			$row[] = isset($value->expired_date) ? date('d-m-Y', strtotime($value->expired_date)) : '-';

            $row[] = $value->description;
            $data[] = $row;
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $this->stocks_model->_countAll(),
            "recordsFiltered" => $this->stocks_model->_countFiltered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }

    public function store()
    {
        $data = [
            "date" =>
                date("Y-m-d H:i", strtotime($this->input->post("date"))) .
                ":" .
                date("s"),
			"expired_date" =>
                date("Y-m-d", strtotime($this->input->post("expired_date"))),
            "products_id" => $this->input->post("products_id"),
            "description" => $this->input->post("description"),
            "total" => parent::checkPrice($this->input->post("total")),
            "updated_at" => date("Y-m-d H:i:s"),
            "created_at" => date("Y-m-d H:i:s"),
        ];

        $this->sistem_model->_input("stock_ins", $data);

        $getProduct = $this->sistem_model->_get_where_id("products", [
            "id" => $data["products_id"],
        ]);

        $products = [
            "stock" => floatval($getProduct["stock"] += $data["total"]),
        ];

        $this->sistem_model->_update("products", $products, [
            "id" => $data["products_id"],
        ]);

        $response["status"] = true;
        $response["message"] = "Data Stok Masuk Berhasil Di Tambahkan!";
        $response["data"] = $data;

        echo json_encode($response);
    }

    public function edit($id)
    {
        $check = $this->sistem_model->_get_where_id("stock_ins", [
            "MD5(id)" => $id,
        ]);

        if (count($check) > 0) {
            $data = [
                "date" => $this->input->post("date"),
                "products_id" => $this->input->post("products_id"),
                "description" => $this->input->post("description"),
                "total" => $this->input->post("total"),
                "updated_at" => date("Y-m-d H:i:s"),
            ];
            $this->sistem_model->_update("stock_ins", $data, [
                "MD5(id)" => $id,
            ]);
            $response["status"] = true;
            $response["message"] = "Data Stok Masuk Berhasil Di Update!";
            $response["data"] = null;
        } else {
            $response["status"] = false;
            $response["message"] = "ID Stok Masuk Tidak Ditemukan!";
            $response["data"] = null;
        }

        echo json_encode($response);
    }

    public function delete($id)
    {
        $check = $this->sistem_model->_get_where_id("stock_ins", [
            "MD5(id)" => $id,
        ]);

        if (count($check) > 0) {
            $this->sistem_model->_delete("stock_ins", ["MD5(id)" => $id]);
            $response["status"] = true;
            $response["message"] = "Data Stok Masuk Berhasil Di Hapus!";
            $response["data"] = null;
        } else {
            $response["status"] = false;
            $response["message"] = "ID Stok Masuk Tidak Ditemukan!";
            $response["data"] = null;
        }

        echo json_encode($response);
    }
}
