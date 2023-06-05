<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cash extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_model');
        $this->load->model('cash_report_model');
        $this->loginCheck();
    }

    public function index()
    {
        $this->load->view('v_report_cash');
    }

    public function getCash()
    {
        $cash = $this->cash_report_model->_datatablesQuery();

        foreach (!empty($cash) ? $cash->result() : [] as &$value) {
            $this->db->select('transaction_details.sub_total');
            $this->db->from('transaction_details');
            $this->db->join('transactions', 'transactions.id = transaction_details.transactions_id');
            $this->db->where('transaction_details.transactions_id', $value->trans_id);
            $value->transaction_details = $this->db->get()->result();
        }

        $countCash = !empty($cash) ? count($cash->result_array()) : count([]);

        $result = array();
            for ($i = 0; $i < $countCash; $i++) {
            $result[] = $cash->result()[$i];
        }

        $no = 1;
        $draw = $_POST['draw'];

        $totalSaldo = 0;
        $data = array();
        foreach ($result as $value) {

            $totalSaldo += $value->debet - $value->kredit;
            $row = array();
            $row[] = $no++;
            $row[] = '<span class="label label-primary">' . $value->invoice . '</span>';
            $row[] = $value->cash_date;
            $row[] = $value->keterangan;
            $row[] = 'Rp. ' . number_format($value->debet, 0, '.', '.') . ',-';
            $row[] = 'Rp. ' . number_format($value->kredit, 0, '.', '.').',-';
            $row[] = 'Rp. ' . number_format($totalSaldo, 0, '.', '.') . ',-';
            $data[] = $row;
        }

            $output = [
                'totalSaldoAkhir' => $totalSaldo,
                // 'draw' => $draw,
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data),
                'data' => $data
            ];

            echo json_encode($output);
        }
}
