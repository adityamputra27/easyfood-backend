<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carts_model extends CI_Model
{
    var $table = 'carts';

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAll()
    {
        $this->db->select('ca.*, f.name as food_name, cu.fullname as fullname');
        $this->db->from($this->table . ' as ca');
        $this->db->join('foods as f', 'ca.foods_id = f.id');
        $this->db->join('customers as cu', 'ca.customers_id = cu.id', 'LEFT');
        $this->db->order_by('ca.created_at', 'DESC');

        $query = $this->db->get();

        return $query->result();
    }

    public function fetchCartCustomers($customersId)
    {
        $this->db->select('COUNT(*) as total, cu.fullname as fullname');
        $this->db->from($this->table . ' as ca');
        $this->db->join('customers as cu', 'ca.customers_id = cu.id', 'LEFT');
        $this->db->where('ca.customers_id', $customersId);

        $query = $this->db->get()->row();

        $this->db->select('ca.*, f.name as food_name, f.price as food_price, f.image as food_image');
        $this->db->from($this->table . ' as ca');
        $this->db->join('foods as f', 'ca.foods_id = f.id');
        $this->db->join('customers as cu', 'ca.customers_id = cu.id', 'LEFT');
        $this->db->order_by('ca.created_at', 'DESC');
        $this->db->where('ca.customers_id', $customersId);

        $carts = $this->db->get()->result();

        $result = [];
        foreach ($carts as $key => $value) {
            $result[] = [
                'id' => $value->id,
                'foods_id' => $value->foods_id,
                'customers_id' => $value->customers_id,
                'quantity' => $value->quantity,
                'food_name' => $value->food_name,
                'food_price' => $value->food_price,
                'food_image' => base_url()."uploads/foods/".$value->food_image,
            ];
        }
        $query->carts = $result;

        return $query;
    }

    public function insertCarts($payload)
    {
        return $this->db->insert($this->table, $payload);
    }

    public function findByWhere($payload)
    {
        $this->db->select('*');
        $this->db->where($payload);
        $this->db->from($this->table);
        
        return $this->db->get()->row();
    }

    public function existCarts($customersId, $foodsId)
    {
        $this->db->select('*');
        $this->db->where('customers_id', $customersId);
        $this->db->where('foods_id', $foodsId);
        $this->db->from($this->table);
        
        return $this->db->get()->row();
    }

    public function updateCarts($payload, $where)
    {
        return $this->db->update($this->table, $payload, $where);
    }

    public function deleteCarts($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
    
}