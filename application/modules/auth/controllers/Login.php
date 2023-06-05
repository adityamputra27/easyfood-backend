<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_model');
        $this->load->model('auth_model');
    }
    public function index()
    {
        $this->load->view('v_login');
    }
    public function validate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $query = $this->sistem_model->_validate($username);
        if (strlen($username) == 0 || strlen($password) == 0) {
            $data['keterangan'] = 'no';
            $data['description'] = 'Username atau Password tidak boleh kosong!';
        } else {
            if (password_verify($password, $query['password'])) {
                $this->db->select('us.id, us.name as full_name, us.avatar as avatar, us.username, us.roles_id, us.created_at, rol.name as role_name');
                $this->db->from('users as us');
                $this->db->join('roles as rol', 'rol.id = us.roles_id');
                $this->db->where('rol.id', $query['roles_id']);
                $roles = $this->db->get()->row_array();
                $this->db->trans_start();

                $data = array();
                $data['users_id'] = $roles['id'];
                $data['is_logged_in'] = true;
                $data['name'] = $roles['full_name'];
                $data["username"] = $roles['username'];
                $data["avatar"] = $roles['avatar'];

                $data['keterangan'] = 'yes';
                $data['description'] = 'Login Berhasil!';
                $data['roles'] = $roles['role_name'];

                $this->session->set_userdata($data);

                $this->db->trans_complete();
            } else {
                $data['keterangan'] = 'no';
                $data['description'] = 'Username atau Password salah!';
            }
        }
        echo json_encode($data);
    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
