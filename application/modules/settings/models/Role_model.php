<?php
defined('BASEPATH') or exit('No direct script access allowed');

class role_model extends CI_Model
{
  var $table = 'roles as r';
  var $columnOrder = array('', 'r.name');
  var $columnSearch = array('', 'r.name');
  var $order = array('r.name' => 'ASC');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  private function _getDatatablesQuery()
  {
    $this->db->select('r.*');
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

  public function getRoleById($id_role)
  {
    $this->db->select('*');
    $this->db->from('roles');
    $this->db->where('id', $id_role);

    return $this->db->get()->row();
  }

  public function getRoleAccess($id_role)
  {
    $result = [];
		if($id_role != '') {
			$query = $this->db->query("SELECT id_module FROM role_access WHERE roles_id = '".$id_role."'");
			$id_modules = $query->result_array();
		}

		if(count($id_modules) > 0) {
			foreach ($id_modules as $key => $value) {
				$result[] = isset($value['id_module'])?$value['id_module']:'';
			}
		}

		return $result;
  }

  public function getRoleAccessDetails($id_role)
  {
    $result = [];
		if($id_role != '') {
			$query = $this->db->query("SELECT id_sub_module FROM role_access_details WHERE roles_id = '".$id_role."'");
			$id_sub_modules = $query->result_array();
		}

		if(count($id_sub_modules) > 0) {
			foreach ($id_sub_modules as $key => $value) {
				$result[] = isset($value['id_sub_module'])?$value['id_sub_module']:'';
			}
		}

		return $result;
  }

}
