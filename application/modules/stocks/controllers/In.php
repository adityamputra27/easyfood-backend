<?php
defined("BASEPATH") or exit("No direct script access allowed");

class In extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("sistem_model");
        $this->load->model("stock_in_model");
        $this->load->library("encryption");
        $this->load->helper("url");
        $this->loginCheck();
    }

    public function index()
    {
        $this->load->view("v_stock_in");
    }

    public function store()
    {
        $isExpired = $this->input->post('is_expired');
        $data = [
            "date" =>
                date("Y-m-d H:i", strtotime($this->input->post("date"))) .
                ":" .
                date("s"),
            "products_id" => $this->input->post("products_id"),
            "expired_date" => $isExpired == 'Ya' ? 
                date("Y-m-d", strtotime($this->input->post("expired_date")))  : null,
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

    public function getStock_in()
    {
        $list = $this->stock_in_model->_getDatatables();
        $data = [];
        $no = $_POST["start"];
        $draw = $_POST["draw"];

        foreach ($list as $key => $value) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->date;
            $row[] =
                '<span class="label bg-maroon">' . $value->barcode . "</span>";
            $row[] = $value->name;
            $row[] = $value->total." "."(".$value->unit_name.")";
            $row[] = isset($value->expired_date) && $value->expired_date != '0000-00-00' ? $value->expired_date : '-';

            $row[] = $value->description;
            $data[] = $row;
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $this->stock_in_model->_countAll(),
            "recordsFiltered" => $this->stock_in_model->_countFiltered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }

    public function getSearchProductStockIn()
    {
        $list = $this->stock_in_model->_getDatatables();
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
            $row[] = '<button type="button" class="btn btn-info btn-sm selectExpiredDataProduct"
                    data-idproduct="' . $value->products_id . '" data-id="' . $value->id . '"
                    data-name="' . $value->name . '" data-price="' . $value->selling_price . '" 
					data-barcode="' . $value->barcode . '" data-stock="' . $value->total . '" data-date_now="' .date('d-m-Y'). '"
                    data-unit="'.$value->unit_name.'" data-expired_date="' . (isset($value->expired_date) ? date('d-m-Y', strtotime($value->expired_date)) : '-') . '"
                    ><i class="glyphicon glyphicon-arrow-down"></i> Pilih</button>';
            $data[] = $row;
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $this->stock_in_model->_countAll(),
            "recordsFiltered" => $this->stock_in_model->_countFiltered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }
}
