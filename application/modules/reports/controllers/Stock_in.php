<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_in extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('stock_in_report_model');
        $this->loginCheck();
    }
    public function index()
    {
        $this->load->view('v_report_stock_in');
    }
    public function getStockInReport()
    {
        $list = $this->stock_in_report_model->_getDatatables();
        $data = [];
        $no = $_POST["start"];
        $draw = $_POST["draw"];

        foreach ($list as $key => $value) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->date;
            $row[] =
                '<span class="label bg-maroon">' . $value->barcode . "</span>";
            $row[] = $value->name;
            $row[] = $value->total." "."(".$value->unit_name.")";
            $row[] = isset($value->expired_date) ? $value->expired_date : '-';

            if($value->status == 'Baru') {
				$status = '<span class="label label-success">Baru</span>';
			} else if($value->status == 'Digunakan') {
				$status = '<span class="label label-warning">Digunakan</span>';
			} else {
				$status = '<span class="label label-danger">Habis</span>';
			}

            $row[] = $status;
            $row[] = $value->description;
            $data[] = $row;
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $this->stock_in_report_model->_countAll(),
            "recordsFiltered" => $this->stock_in_report_model->_countFiltered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }
}