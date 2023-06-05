<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user_model extends CI_Model
{
  var $table = 'users as u';
  var $columnOrder = array('', 'u.name', 'u.username', 'r.name');
  var $columnSearch = array('', 'u.name', 'u.username', 'r.name');
  var $order = array('u.name' => 'ASC');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  private function _getDatatablesQuery()
  {
    $this->db->select('u.*, r.name as role_name');
    $this->db->join('roles as r', 'r.id = u.roles_id');
    $this->db->from($this->table);
    $i = 0;

    foreach ($this->columnSearch as $key => $value) {
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
        $this->db->order_by($this->columnOrder[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      } else if (isset($this->order)) {
        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);
    }
  }
  function _getDatatables()
  {
    $this->_getDatatablesQuery();
    if ($_POST['length'] != -1)
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
