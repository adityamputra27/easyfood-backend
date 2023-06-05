<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lists extends CI_Controller
{
	public $settings;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistem_model');
		$this->load->model('lists_model');
        $this->load->model("stocks_model");
		$this->load->library(['encryption', 'upload']);
		$this->load->helper(["url", "html", "form"]);
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->helper("file");
		$this->loginCheck();

		$this->settings = $this->sistem_model->_get_only_limit('settings', 'shop_name-ASC', '1');
	}
	public function index()
	{
		$this->load->view('v_lists');
	}
	public function store()
	{
		$data = [
			'name' => $this->input->post('productNameInput'),
			'price' => parent::checkPrice($this->input->post('priceInput')),
			'categories_id' => $this->input->post('categoryIdInput'),
			'description' => $this->input->post('descriptionInput'),
			'discount' => $this->input->post('discountInput'),
			'updated_at' => date('Y-m-d H:i:s'),
			'created_at' => date('Y-m-d H:i:s')
		];

		if(!empty($_FILES['imageInput']['name']))
        {
            $upload = $this->doUpload();
            $data['image'] = $upload;
        }

		$this->sistem_model->_input('foods', $data);

		$response['status'] = true;
		$response['message'] = 'Menu Berhasil Di Tambahkan!';
		$response['data'] = $data;

		echo json_encode($response);
	}
	public function edit($id)
	{
		$check = $this->sistem_model->_get_where_id('foods', array('MD5(id)' => $id));

		if (count($check) > 0) {
			$data = [
				'name' => $this->input->post('productNameInput'),
				'price' => parent::checkPrice($this->input->post('priceInput')),
				'categories_id' => $this->input->post('categoryIdInput'),
				'description' => $this->input->post('descriptionInput'),
				'discount' => $this->input->post('discountInput'),
				'updated_at' => date('Y-m-d H:i:s'),
				'created_at' => date('Y-m-d H:i:s')
			];

			if(!empty($_FILES['imageInput']['name']))
			{
				if(file_exists('uploads/foods/'.$check['image']) && $check['image'])
				unlink('uploads/foods/'.$check['image']);

				$upload = $this->doUpload();
				$data['image'] = $upload;
			}

			$this->sistem_model->_update('foods', $data, array('MD5(id)' => $id));
			$response['status'] = true;
			$response['message'] = 'Menu Berhasil Diubah!';
			$response['data'] = null;
		} else {
			$response['status'] = false;
			$response['message'] = 'ID Menu Tidak Ditemukan!';
			$response['data'] = null;
		}

		echo json_encode($response);
	}
	public function delete($id)
	{
		$check = $this->sistem_model->_get_where_id('foods', array('MD5(id)' => $id));

		if (count($check) > 0) {
			if(file_exists('uploads/foods/'.$check['image']) && $check['image'])
            unlink('uploads/foods/'.$check['image']);

			$this->sistem_model->_delete('foods', array('MD5(id)' => $id));
			$response['status'] = true;
			$response['message'] = 'Menu Berhasil Di Hapus!';
			$response['data'] = null;
		} else {
			$response['status'] = false;
			$response['message'] = 'ID Menu Tidak Ditemukan!';
			$response['data'] = null;
		}

		echo json_encode($response);
	}
	public function getProduct()
	{
		$list = $this->lists_model->_getDatatables();
		$data = array();
		$no = $_POST['start'];
		$draw = $_POST['draw'];

		foreach ($list as $key => $value) {
			$id = MD5($value->id);
			$link = '<div class="btn-group">';
			$link .= '<button type="button" class="btn btn-warning btn-sm" data-mode="edit" data-toggle="modal" data-target="#productModal" data-id="' . $id . '" 
						data-categories_id="' . $value->categories_id . '" data-description="' . $value->description . '" 
						data-image="'.base_url('uploads/foods/'.$value->image).'"><i class="fa fa-edit"></i> Edit</button>';
			$link .= '<button type="button" class="btn btn-danger btn-sm delete-product" data-id="' . $id . '"><i class="fa fa-trash"></i> Hapus</a>';
			$link .= '</div>';

			$no++;
			$row = array();
			$row[] = $no;
			if($value->image)
                $row[] = '<a href="'.base_url('uploads/foods/'.$value->image).'" target="_blank"><img src="'.base_url('uploads/foods/'.$value->image).'" width="150" class="img-responsive" /></a>';
            else
                $row[] = '-';
			$row[] = $value->name;
			$row[] = $value->category_name;
			$row[] = 'Rp. ' . number_format($value->price, 0, '.', '.');
			$row[] = $value->description;
			$row[] = $link;
			$data[] = $row;
		}

		$output = [
			'draw' => $draw,
			'recordsTotal' => $this->lists_model->_countAll(),
			'recordsFiltered' => $this->lists_model->_countFiltered(),
			'data' => $data
		];

		echo json_encode($output);
	}

	public function loadCategory()
	{
		$category = $this->sistem_model->_get('categories', 'name-ASC');
		if (!empty($category)) {
			$response['status'] = false;
			$response['message'] = 'Data Kategori Menu Kosong!';
			$response['data'] = null;
		}
		$response['status'] = true;
		$response['message'] = 'Success Get Data Category!';
		$response['data'] = $category;

		echo json_encode($response);
	}

	private function doUpload()
    {
        $config['upload_path']  = './uploads/foods/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = round(microtime(true) * 1000); 
 
        $this->load->library('upload', $config);
		$this->upload->initialize($config);
 
        if(!$this->upload->do_upload('imageInput'))
        {
            $data['inputerror'][] = 'imageInput';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('','');
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

	public function getSearchProduct()
	{
		$lists = $this->lists_model->_getDatatables();
		$no = $this->input->post('no');
		$draw = $this->input->post('draw');
		$data = [];

		foreach ($lists as $key => $value) {
			$link = '<button type="button" class="btn btn-info btn-sm selectProduct" id="selectProduct" data-foods_id="' . $value->id . '" data-name="' . $value->name . '"
			data-price="'. $value->price .'" data-discount="'. ($value->price * $value->discount) / 100 .'"><i class="glyphicon glyphicon-arrow-down"></i> Pilih</button>';
			$no++;
			$row = array();
			$row[] = $no;
			if($value->image)
                $row[] = '<a href="'.base_url('uploads/foods/'.$value->image).'" target="_blank"><img src="'.base_url('uploads/foods/'.$value->image).'" width="150" class="img-responsive" /></a>';
            else
                $row[] = '-';
			$row[] = $value->name;
			$row[] = $value->category_name;
			$row[] = 'Rp. ' . number_format($value->price, 0, '.', '.');
			$row[] = $link;
			$data[] = $row;
		}

		$output = [
			'draw' => $draw,
			'recordsTotal' => $this->lists_model->_countAll(),
			'recordsFiltered' => $this->lists_model->_countFiltered(),
			'data' => $data
		];

		echo json_encode($output);
	}
}
