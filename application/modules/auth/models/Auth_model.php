<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	public function getAllModules($id_role)
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
	public function getAllChildrenModules($id_role)
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

?>