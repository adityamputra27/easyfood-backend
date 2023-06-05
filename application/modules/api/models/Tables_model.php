<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tables_model extends CI_Model
{
    var $table = 'tables';

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAll()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('name', 'ASC');

        $query = $this->db->get();

        return $query->result();
    }
    
}