<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_model');
        $this->loginCheck();
    }
    public function edit($users_id)
    {
        $this->db->select('users.*');
        $this->db->where('users.id', $users_id);
        $this->db->from('users');
        $data['profile'] = $this->db->get()->row_array();
        // echo json_encode($data);
        $this->load->view('v_edit_profile', $data);
    }
    public function store()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $users = $this->db->get_where('users', ['id' => $this->session->userdata('users_id')])->row_array();
        $oldLogo = $post['old_avatar'];
        $newLogo = $_FILES['avatar']['name'];
        $name = $post['name'];
        $username = $post['username'];
        $new_password = $post['new_password'];
        $confirm_password = $post['confirm_password'];
        
        // config file
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        if(strlen($new_password) == '' || strlen($confirm_password) == '') {
            $this->session->set_flashdata('error', 'Password Harus Diisi!');
            redirect('auth/profile/edit/'.$this->session->userdata('users_id'));
        }
        if ($new_password == $confirm_password) {
            if (!empty($newLogo)) {
            
                if (!$this->upload->do_upload('avatar')) {
                    echo $this->upload->display_errors(); die();
                } else {
                    $avatar = $this->upload->data('file_name'); 
                }
                $file = $this->upload->data();
                $avatar = $file['file_name'];
    
                $this->sistem_model->_update('users', [
                    'name' => $name,
                    'username' => $username,
                    'password' => password_hash($new_password, PASSWORD_DEFAULT),
                    'avatar' => $avatar,
                ], ['id' => $id]);
    
                $path = "assets/uploads/".$users['avatar'];
                chmod($path, 0777);
                unlink($path);
            } else {
                $this->sistem_model->_update('users', [
                    'name' => $name,
                    'username' => $username,
                    'password' => password_hash($new_password, PASSWORD_DEFAULT),
                    'avatar' => $avatar,
                ], ['id' => $id]);
            }
        } else {
            $this->session->set_flashdata('error', 'Password Baru Tidak Sama Dengan Konfirmasi Password!');
            redirect('auth/profile/edit/'.$this->session->userdata('users_id'));
        }

        $this->session->set_flashdata('success', 'Berhasil Edit Profile!');
        redirect('auth/profile/edit/'.$this->session->userdata('users_id'));
    }
}
