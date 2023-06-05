<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Stock_in_model extends CI_Model
{
    var $table = "stock_ins as sti";
    var $column_order = [
        "",
        "sti.date",
        "p.barcode",
        "p.name",
        "sti.total",
        "sti.expired_date",
        "sti.description",
    ];
    var $column_search = [
        "sti.date",
        "p.barcode",
        "p.name",
        "sti.total",
        "sti.expired_date",
        "sti.description",
    ];
    var $order = ["sti.date" => "DESC"];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _getDatatablesQuery()
    {
        $this->db->select("sti.*, p.barcode, p.name, pu.unit_name, p.selling_price");
        $this->db->join("products as p", "sti.products_id = p.id");
        $this->db->join("product_units as pu", "p.product_units_id = pu.id", "left");

        if($this->input->post('products_id')) {
            $this->db->where("sti.products_id", $this->input->post('products_id'));
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
}
