<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Out extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("stock_out_model");
        $this->load->model("sistem_model");
        $this->load->library("encryption");
        $this->load->helper("url");
        $this->loginCheck();
    }

    public function index()
    {
        $this->load->view("v_stock_out");
    }

    public function store()
    {
        $data = [
            "date" =>
                date("Y-m-d H:i", strtotime($this->input->post("date"))) .
                ":" .
                date("s"),
            "products_id" => $this->input->post("products_id"),
            "description" => $this->input->post("description"),
            "total" => parent::checkPrice($this->input->post("total")),
            "updated_at" => date("Y-m-d H:i:s"),
            "created_at" => date("Y-m-d H:i:s"),
        ];

        $getStockIns = $this->sistem_model->_get_where_id("stock_ins", [
            "id" => $this->input->post('stock_ins_id'),
        ]);

        $stockIns = [
            "total" => floatval($getStockIns["total"] -= $data["total"]),
            "status" => $getStockIns["total"] > 0 ? "Digunakan" : "Habis"
        ];

        $this->sistem_model->_update("stock_ins", $stockIns, [
            "id" => $this->input->post('stock_ins_id'),
        ]);
        $this->sistem_model->_input("stock_outs", $data);

        $response["status"] = true;
        $response["message"] = "Data Stok Keluar Berhasil Di Tambahkan!";
        $response["data"] = $data;

        echo json_encode($response);
    }

    public function edit($id)
    {
        $check = $this->sistem_model->_get_where_id("stock_outs", [
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
            $this->sistem_model->_update("stock_outs", $data, [
                "MD5(id)" => $id,
            ]);
            $response["status"] = true;
            $response["message"] = "Data Stok Keluar Berhasil Di Update!";
            $response["data"] = null;
        } else {
            $response["status"] = false;
            $response["message"] = "ID Stok Keluar Tidak Ditemukan!";
            $response["data"] = null;
        }

        echo json_encode($response);
    }

    public function delete($id)
    {
        $check = $this->sistem_model->_get_where_id("stock_outs", [
            "MD5(id)" => $id,
        ]);

        if (count($check) > 0) {
            $this->sistem_model->_delete("stock_outs", ["MD5(id)" => $id]);
            $response["status"] = true;
            $response["message"] = "Data Stok Keluar Berhasil Di Hapus!";
            $response["data"] = null;
        } else {
            $response["status"] = false;
            $response["message"] = "ID Stok Keluar Tidak Ditemukan!";
            $response["data"] = null;
        }

        echo json_encode($response);
    }

    public function getStock_out()
    {
        $list = $this->stock_out_model->_getDatatables();
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
            $row[] = $value->total . " " . "(" . $value->unit_name . ")";
            $row[] = $value->description;
            $data[] = $row;
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $this->stock_out_model->_countAll(),
            "recordsFiltered" => $this->stock_out_model->_countFiltered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }
}
