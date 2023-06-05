<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_model');
        $this->loginCheck();
        $this->load->library('session');
    }
    public function index()
    {
        $this->db->select('settings.*');
        $this->db->limit(1);
        $this->db->from('settings');
        $data['settings'] = $this->db->get()->row_array();
        // echo json_encode($data);
        $this->load->view('v_shop', $data);
    }
    public function store()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $settings = $this->db->get_where('settings', ['id' => $id])->row_array();
        $oldLogo = $post['old_logo'];
        $newLogo = $_FILES['logo']['name'];
        $shop_name = $post['shop_name'];
        $address = $post['address'];
        $phone = $post['phone'];
        $prefix_barcode = $post['prefix_barcode'];
        $prefix_invoice = $post['prefix_invoice'];
        
        // config file
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        if (!empty($newLogo)) { 
            if (!$this->upload->do_upload('logo')) {
                echo $this->upload->display_errors(); die();
            } else {
                $logo = $this->upload->data('file_name'); 
            }
            $file = $this->upload->data();
            $logo = $file['file_name'];

            $this->sistem_model->_update('settings', [
                'shop_name' => $shop_name,
                'address' => $address,
                'phone' => $phone,
                'prefix_barcode' => $prefix_barcode,
                'prefix_invoice' => $prefix_invoice,
                'logo' => $logo,
            ], ['id' => $id]);

            $path = "assets/uploads/".$settings['logo'];
            chmod($path, 0777);
            unlink($path);
        } else {
            $this->sistem_model->_update('settings', [
                'shop_name' => $shop_name,
                'address' => $address,
                'phone' => $phone,
                'prefix_barcode' => $prefix_barcode,
                'prefix_invoice' => $prefix_invoice,
                'logo' => $settings['logo'],
            ], ['id' => $id]);
        }

        $this->session->set_flashdata('success', 'Berhasil Edit Pengaturan Toko!');
        redirect('settings/shop');
    }
}
