<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Access extends CI_Controller 
{
    var $webconfig;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('sistem_model');
        $this->load->model('role_model'); 
        $this->loginCheck();
        $this->webconfig = $this->config->item('webconfig');
    }

    public function index()
    {
        $this->load->view('v_access');
    }

    public function delete($id)
    {
        $check = $this->sistem_model->_get_where_id('users', array('MD5(roles_id)' => $id));

        if (!$check) {
            $this->sistem_model->_delete('roles', array('MD5(id)' => $id));
            $this->sistem_model->_delete('role_access', array('MD5(roles_id)' => $id));
            $this->sistem_model->_delete('role_access_details', array('MD5(roles_id)' => $id));
            
            $response['status'] = true;
            $response['message'] = 'Data Role Berhasil Di Hapus!';
            $response['data'] = null;
        } else {
            $response['status'] = false;
            $response['message'] = 'Role ini sedang digunakan!';
            $response['data'] = null;
        }

        echo json_encode($response);
    }

    public function getRoles()
    {
        $list = $this->role_model->_getDatatables();
        $data = array();
        $no = $_POST['start'];
        $draw = $_POST['draw'];

        foreach ($list as $key => $value) {

            $id = MD5($value->id);
            $link = '<div class="btn-group"><button type="button" data-id="' . $value->id . '" data-name="' . $value->name . '" class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#roleModal" data-mode="edit" data-id="' . $id . '" ><i class="fa fa-edit"></i> Edit</button>';
            $link .= '<button type="button" class="btn btn-danger btn-sm delete-roles" data-action="' . base_url() . 'settings/access/delete/' . $id . '" data-id="' . $id . '"><i class="fa fa-trash"></i> Hapus</a>';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->name;
            $row[] = $link;
            $data[] = $row;
        }

        $output = [
            'draw' => $draw,
            'recordsTotal' => $this->role_model->_countAll(),
            'recordsFiltered' => $this->role_model->_countFiltered(),
            'data' => $data
        ];

        echo json_encode($output);
    }

    public function getAccessModules($id_role = null)
    {
        $data['role'] = $id_role ? $this->role_model->getRoleById($id_role) : null;
        $data['role_access'] = $id_role ? $this->role_model->getRoleAccess($id_role) : null;
        $data['role_access_details'] = $id_role ? $this->role_model->getRoleAccessDetails($id_role) : null;

        $this->db->select('*');
        $this->db->order_by('order', 'ASC');
        $this->db->from('modules');
        $this->db->where('status', 'Active');

        $data['modules'] = $this->db->get();

        foreach ($data['modules']->result() as $key => $value) {
            $this->db->select('md.*, sm.nama, sm.link');
            $this->db->from('module_details md');
            $this->db->join('sub_modules sm', 'md.id_sub_module = sm.id');
            $this->db->where('sm.status', 'Active');
            $this->db->where('md.id_module', $value->id);
            $value->children = $this->db->get()->result();
        }

        $this->load->view('v_modules', $data);
    }

    public function store()
    {
        $name = $this->input->post('name');
        $id_module = $this->input->post('id_module');
        $id_sub_module = $this->input->post('id_sub_module');

        $this->db->insert('roles', ['name' => $name]);
        $id_role = $this->db->insert_id();

        if(count($id_module) > 0) {
            foreach($id_module as $key => $value) {
                $mdata = [];
                $mdata['roles_id'] = $id_role;
                $mdata['id_module'] = $value;
                $this->db->insert('role_access', $mdata);
            }
        }

        if(count($id_sub_module) > 0) {
            foreach($id_sub_module as $key => $value) {
                $smdata = [];
                $smdata['roles_id'] = $id_role;
                $smdata['id_sub_module'] = $value;
                $this->db->insert('role_access_details', $smdata);
            }
        }

        $response['status'] = true;
		$response['message'] = 'Data Role Berhasil Di Tambahkan! Silahkan Login Kembali!';

		echo json_encode($response);
    }

    public function update($id_role)
    {
        $name = $this->input->post('name');
        $id_module = $this->input->post('id_module');
        $id_sub_module = $this->input->post('id_sub_module');

        $this->db->where('id', $id_role)->update('roles', ['name' => $name]);

		$this->db->where('roles_id', $id_role)->delete('role_access');

        if(count($id_module) > 0) {
            foreach($id_module as $key => $value) {
                $mdata = [];
                $mdata['roles_id'] = $id_role;
                $mdata['id_module'] = $value;
                $this->db->insert('role_access', $mdata);
            }
        }

		$this->db->where('roles_id', $id_role)->delete('role_access_details');

        if(count($id_sub_module) > 0) {
            foreach($id_sub_module as $key => $value) {
                $smdata = [];
                $smdata['roles_id'] = $id_role;
                $smdata['id_sub_module'] = $value;
                $this->db->insert('role_access_details', $smdata);
            }
        }

        $response['status'] = true;
		$response['message'] = 'Data Role Berhasil Di Ubah! Silahkan Login Kembali!';

		echo json_encode($response);
    }
}