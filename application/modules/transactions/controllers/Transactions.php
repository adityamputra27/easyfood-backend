<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transactions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_model');
        $this->load->model('transactions_model');
        $this->loginCheck();
    }

    public function index()
    {
        $this->load->view('v_index');
    }

    public function getTransactions()
    {
        $list = $this->transactions_model->_getDatatables();

        foreach ($list as &$value) {
            $this->db->select(
                'transaction_details.quantity, transaction_details.discount, transaction_details.price,
                transaction_details.subtotal, foods.name, foods.price, categories.name as category'
            );
            $this->db->from('transaction_details');
            $this->db->join('transactions', 'transactions.id = transaction_details.transactions_id');
            $this->db->join('foods', 'transaction_details.foods_id = foods.id');
            $this->db->join('categories', 'foods.categories_id = categories.id');
            $this->db->where('transaction_details.transactions_id', $value->id);
            $value->transaction_details = $this->db->get()->result();
        }

        $result = array();
        for ($i = 0; $i < count($list); $i++) {
            $result[] = $list[$i];
        }

        $data = array();
        $no = $_POST['start'];
        $draw = $_POST['draw'];

        foreach ($result as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<span class="text-center text-dark"><b>'.$value->datetime.'</b></span>';
            $row[] = '<span class="text-center text-primary"><b>'.$value->code.'</b></span>';
            $row[] = $value->table_name;
            $row[] = $value->customer;
            $row[] = $this->getTransactionDetail($value->transaction_details);
            $row[] = 'Rp. ' . number_format($value->total, 0, '.', '.') . ',-';
            $row[] = '<span class="label label-info">' . $value->nama_kasir . '</span>';

            $button = '';
            if ($value->status == 'FINISH') {
                $button = '<span class="text-center text-success"><b>SELESAI</b></span>';
            } else {
                $button = '<span class="text-center text-danger"><b>BELUM BAYAR</b></span>';
                $button .= '<div class="btn-group text-center" style="margin-top: 0.5em;">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payModal" type="button" data-id="'.$value->id.'" data-code="'.$value->code.'" data-total="'.$value->total.'"><i class="fa fa-money"></i> Bayar</button>
                        </div>';
            }

            $row[] = $button;
            $data[] = $row;
        }

        $output = [
            'draw' => $draw,
            'recordsTotal' => $this->transactions_model->_countAll(),
            'recordsFiltered' => $this->transactions_model->_countFiltered(),
            'data' => $data
        ];

        echo json_encode($output);
    }

    private function getTransactionDetail($attr)
    {
        $record = '';
        foreach ($attr as $detailRows) {
            $record .= '<div style="padding-bottom:0px;"><table class="table w-100" style="pointer-events:none; margin-bottom: 3px;"><tbody><tr>';
            $record .= '<td style="padding: 5px 3px 5px 3px;border-bottom:1px solid #ccc;">' . strtoupper($detailRows->name) . ' <span style="width:0px; border-bottom:1px solid #ccc; padding: 3px 7px;" class="label bg-maroon">' . $detailRows->quantity . '</span></td>';
            $record .= '<td style="padding: 5px 3px 5px 3px;text-align:right;border-bottom:1px solid #ccc;">';
            $record .= !empty($detailRows->discount) ? 'Rp. ' . number_format(floatval($detailRows->price * $detailRows->quantity), 0,  '.', '.') . ' - ' . 'Rp. ' . number_format(floatval($detailRows->discount), 0, '.', '.') . ' = ' . 'Rp. ' . number_format(floatval(($detailRows->price * $detailRows->quantity) - $detailRows->discount), 0, '.', '.') : 'Rp. ' . number_format(floatval($detailRows->price * $detailRows->quantity), 0,  '.', '.');
            $record .= '</td></tr>';
            $record .= '</tbody></table></div>';
        }
        return $record;
    }

    public function edit($transactionsId)
    {
        $this->sistem_model->_update('transactions', [
            'status' => 'FINISH',
            'pay' => $this->input->post('totalCash'),
            'change' => $this->input->post('totalChange'),
        ], ['id' => $transactionsId]);
        $response['status'] = true;
        $response['message'] = "Pembayaran Berhasil!";
        $response['data'] = null;

        echo json_encode($response);
    }
}
