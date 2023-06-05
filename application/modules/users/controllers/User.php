<?php
defined("BASEPATH") or exit("No direct script access allowed");

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("sistem_model");
        $this->load->model("user_model");
        $this->load->library("encryption");
        $this->load->helper("url");
        $this->loginCheck();
    }

    public function index()
    {
        $this->load->view("v_user");
    }

    public function store()
    {
        $data = [
            "name" => $this->input->post("name"),
            "username" => $this->input->post("username"),
            "password" => password_hash(
                $this->input->post("password"),
                PASSWORD_DEFAULT
            ),
            "roles_id" => $this->input->post("roles_id"),
            "updated_at" => date("Y-m-d H:i:s"),
            "created_at" => date("Y-m-d H:i:s"),
        ];

        $this->sistem_model->_input("users", $data);

        $response["status"] = true;
        $response["message"] = "Data Pengguna Berhasil Ditambahkan!";
        $response["data"] = $data;

        echo json_encode($response);
    }

    public function edit($id)
    {
        $check = $this->sistem_model->_get_where_id("users", [
            "MD5(id)" => $id,
        ]);

        if (count($check) > 0) {
            $data = [
                "name" => $this->input->post("name"),
                "username" => $this->input->post("username"),
                "roles_id" => $this->input->post("roles_id"),
                "updated_at" => date("Y-m-d H:i:s"),
            ];
            $this->sistem_model->_update("users", $data, ["MD5(id)" => $id]);
            $response["status"] = true;
            $response["message"] = "Data Pengguna Berhasil Diubah!";
            $response["data"] = null;
        } else {
            $response["status"] = false;
            $response["message"] = "ID Pengguna Tidak Ditemukan!";
            $response["data"] = null;
        }

        echo json_encode($response);
    }

    public function delete($id)
    {
        $check = $this->sistem_model->_get_where_id("users", [
            "MD5(id)" => $id,
        ]);

        if (count($check) > 0) {
            $this->sistem_model->_delete("users", ["MD5(id)" => $id]);
            $response["status"] = true;
            $response["message"] = "Data Pengguna Berhasil Di Hapus!";
            $response["data"] = null;
        } else {
            $response["status"] = false;
            $response["message"] = "ID Pengguna Tidak Ditemukan!";
            $response["data"] = null;
        }

        echo json_encode($response);
    }

    public function getUser()
    {
        $list = $this->user_model->_getDatatables();
        $data = [];
        $no = $_POST["start"];
        $draw = $_POST["draw"];

        foreach ($list as $key => $value) {
            $id = MD5($value->id);
            $link =
                '<div class="btn-group"><button type="button" data-name="' .
                $value->name .
                '" data-username="' .
                $value->username .
                '" data-password="' .
                $value->password .
                '" data-roles_id="' .
                $value->roles_id .
                '" class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#userModal" data-mode="edit" data-id="' .
                $id .
                '" ><i class="fa fa-edit"></i> Edit</button><button type="button" class="btn btn-danger btn-sm delete-user" data-id="' .
                $id .
                '"><i class="fa fa-trash"></i> Hapus</a></div>';

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->name;
            $row[] = $value->username;
            $row[] = ucfirst($value->role_name);
            $row[] = $link;
            $data[] = $row;
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $this->user_model->_countAll(),
            "recordsFiltered" => $this->user_model->_countFiltered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }
}
