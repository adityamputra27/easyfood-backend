<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_out extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('stock_out_report_model');
        $this->loginCheck();
    }
    public function index()
    {
        $this->load->view('v_report_stock_out');
    }
    public function getStockOutReport()
    {
        $list = $this->stock_out_report_model->_getDatatables();
        $data = array();
        $no = $_POST['start'];
        $draw = $_POST['draw'];

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
            $row[] = $value->description;
            $data[] = $row;
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $this->stock_out_report_model->_countAll(),
            "recordsFiltered" => $this->stock_out_report_model->_countFiltered(),
            "data" => $data,
        ];

        echo json_encode($output);
    }
}