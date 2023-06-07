<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions_model extends CI_Model
{
    var $table = 'transactions';

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAll()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('datetime', 'DESC');

        $query = $this->db->get();

        return $query->result();
    }
    
}