<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Create_model extends CI_Model
{
    var $table = "transactions as t";
    var $column_order = ["", "t.transaction_date", "t.invoice"];
    var $column_search = ["", "t.transaction_date", "t.invoice"];
    var $order = ["t.transaction_date" => "DESC"];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _getDatatablesQuery()
    {
        $this->db->select("id, invoice, transaction_date, total, status");
        $this->db->where("t.status", "PENDING");

        if (
            $this->input->post("start_date") &&
            $this->input->post("end_date")
        ) {
            $start_date = date(
                "Y-m-d",
                strtotime($this->input->post("start_date"))
            );
            $end_date = date(
                "Y-m-d",
                strtotime($this->input->post("end_date"))
            );
            $this->db->where(
                "t.transaction_date BETWEEN '" .
                    $start_date .
                    " 00:00:00' AND '" .
                    $end_date .
                    " 23:59:59'"
            );
        }
        if ($this->input->post("invoice")) {
            $this->db->like("t.invoice", $this->input->post("invoice"));
        }

        $this->db->from($this->table);
        $i = 0;

        foreach ($this->column_search as $key => $value) {
            if ($_POST["search"]["value"]) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($value, $_POST["search"]["value"]);
                } else {
                    $this->db->or_like($value, $_POST["search"]["value"]);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($_POST["order"])) {
            $this->db->order_by(
                $this->column_order[$_POST["order"]["0"]["column"]],
                $_POST["order"]["0"]["dir"]
            );
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function _getDatatables()
    {
        $this->_getDatatablesQuery();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function _countFiltered()
    {
        $this->_getDatatablesQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function _countAll()
    {
        $this->_getDatatablesQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function expiredDateExists($productId)
    {
        $this->db->select("expired_date");
        $this->db->from("stock_ins");
        $this->db->where("products_id", $productId);
        $this->db->where("expired_date !=", "null");
        $this->db->where("total !=", "0");

        return $this->db->get();
    }
}
