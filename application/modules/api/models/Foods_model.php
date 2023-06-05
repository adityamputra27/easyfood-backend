<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foods_model extends CI_Model
{
    var $table = 'foods';

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAll()
    {
        $this->db->select('f.*, c.name as category');
        $this->db->from($this->table. ' as f');
        $this->db->join('categories as c', 'f.categories_id = c.id');
        $this->db->order_by('f.name', 'ASC');

        $query = $this->db->get();

        $result = [];
        foreach ($query->result() as $key => $value) {
            $result[] = [
                'id' => $value->id,
                'name' => $value->name,
                'category' => $value->category,
                'price' => $value->price,
                'discount' => $value->discount,
                'description' => $value->description,
                'image' => base_url()."uploads/foods/".$value->image,
                'created_at' => $value->created_at,
                'updated_at' => $value->updated_at,
            ];
        }

        return $result;
    }

    public function fetchById($id)
    {
        $this->db->select('f.*, c.name as category');
        $this->db->from($this->table. ' as f');
        $this->db->join('categories as c', 'f.categories_id = c.id');
        $this->db->where('f.id', $id);

        $query = $this->db->get()->row();
        $query->image = base_url()."uploads/foods/".$query->image;

        return $query;
    }
    
}