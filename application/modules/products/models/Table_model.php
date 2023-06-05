<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_model extends CI_Model
{
    var $table = 'tables as t';
    var $column_order = array('', 't.name');
    var $column_search = array('t.name');
    var $order = array('t.name' => 'ASC');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _getDatatablesQuery()
    {
        $this->db->select('t.*');
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $key => $value) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($value, $_POST['search']['value']);
                } else {
                    $this->db->or_like($value, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function _getDatatables()
    {
        $this->_getDatatablesQuery();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
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