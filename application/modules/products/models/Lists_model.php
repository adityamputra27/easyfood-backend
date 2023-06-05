<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Lists_model extends CI_Model
{
    var $table = "foods as f";
    var $column_order = [
        "",
        "f.image",
        "f.name",
        "c.name",
        "f.price",
        "f.discount",
        "f.description",
    ];
    var $column_search = [
        "f.name",
        "c.name",
    ];
    var $order = ["f.name" => "ASC"];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _getDatatablesQuery()
    {
        $this->db->select("f.*, c.name as category_name");
        $this->db->join(
            "categories as c",
            "c.id = f.categories_id",
            "left"
        );
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

    public function getProductById($id)
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('MD5(id)', $id);

        return $this->db->get()->row();
    }

    public function insertBatch($payload = [])
    {
        $insert = $this->db->insert_batch('products', $payload);
        if ($insert) {
            return true;
        }
    }

    public function getProductCategoryByName($name = '')
    {
        $this->db->select('*');
        $this->db->from('product_categories');
        $this->db->where('category_name', $name);

        $query = $this->db->get();
        if ($query->row()) {
            return $query->row()->id;
        } else {
            return NULL;
        }
    }

    public function getProductUnitByName($name = '')
    {
        $this->db->select('*');
        $this->db->from('product_units');
        $this->db->where('unit_name', $name);

        $query = $this->db->get();
        if ($query->row()) {
            return $query->row()->id;
        } else {
            return NULL;
        }
    }
}
