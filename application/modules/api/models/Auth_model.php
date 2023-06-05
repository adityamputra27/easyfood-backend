<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    var $table = 'customers';

    public function __construct()
    {
        parent::__construct();
    }

    public function validateLogin($phone) 
    {
        $this->db->select('customers.*');
		$this->db->from($this->table);
		$this->db->where('customers.phone', $phone);

		$query = $this->db->get();

		if ($query->num_rows() > 0) return $query->row_array();
		else return [];
    }
    
    public function register($table, $payload) 
    {
		return $this->db->insert($table, $payload);
    }
}