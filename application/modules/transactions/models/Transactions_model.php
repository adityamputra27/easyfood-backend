<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Transactions_model extends CI_Model
{
    var $table = "transactions as t";
    var $column_order = ["t.datetime"];
    var $column_search = ["t.datetime", "t.code"];
    var $order = ["t.datetime" => "DESC"];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _getDatatablesQuery()
    {
        $this->db->select(
            "t.*, u.name as nama_kasir, ta.name as table_name, cu.fullname as customer"
        );

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
                "t.datetime BETWEEN '" .
                    $start_date .
                    " 00:00:00' AND '" .
                    $end_date .
                    " 23:59:59'"
            );
        }
        if ($this->input->post("code")) {
            $this->db->like("t.code", $this->input->post("code"));
        }

        if ($this->input->post("customers")) {
            $this->db->like("cu.fullname", $this->input->post("customers"));
        }

        $this->db->join("users as u", "t.users_id = u.id", 'LEFT');
        $this->db->join('tables as ta', 't.tables_id = ta.id', 'LEFT');
        $this->db->join('customers as cu', 't.customers_id = cu.id', 'LEFT');
        $this->db->order_by("t.datetime", "DESC");
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
}
