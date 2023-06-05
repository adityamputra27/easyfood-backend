<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sale extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_model');
        $this->load->model('sale_report_model');
        $this->loginCheck();
    }

    public function index()
    {
        $this->load->view('v_report_sale');
    }

    public function getReportSale()
    {
        $list = $this->sale_report_model->_getDatatables();

        foreach ($list as &$value) {
            $this->db->select(
                'transaction_details.quantity, transaction_details.discount, transaction_details.price, transaction_details.stock_ins_id,
                transaction_details.sub_total, products.name, products.capital_price, product_categories.category_name,'
            );
            $this->db->from('transaction_details');
            $this->db->join('transactions', 'transactions.id = transaction_details.transactions_id');
            $this->db->join('stock_ins', 'transaction_details.stock_ins_id = stock_ins.id');
            $this->db->join('products', 'stock_ins.products_id = products.id');
            $this->db->join('product_categories', 'products.product_categories_id = product_categories.id');
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
            $row[] = $value->transaction_date;
            $row[] = '<span class="label label-primary">' . $value->invoice . '</span>';
            $row[] = $this->getTransactionDetail($value->transaction_details);
            $row[] = 'Rp. ' . number_format($value->discount + $value->total, 0, '.', '.') . ',-';
            $row[] = 'Rp. ' . number_format($value->discount, 0, '.', '.') . ',-';
            $row[] = 'Rp. ' . number_format($value->total, 0, '.', '.') . ',-';
            $row[] = '<span class="label label-info">' . $value->nama_kasir . '</span>';
            $row[] = ' <div class="btn-group text-center">
                            <a href="' . base_url() . 'transactions/input/printInvoice/' . $value->id . '" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i> Cetak</a>
                            <a href="#" class="btn btn-danger btn-sm delete-transaction" data-id="' . md5($value->id) . '"><i class="fa fa-times-circle"></i> Batalkan</a>
                        </div>';
            $data[] = $row;
        }

        $output = [
            'draw' => $draw,
            'recordsTotal' => $this->sale_report_model->_countAll(),
            'recordsFiltered' => $this->sale_report_model->_countFiltered(),
            'data' => $data
        ];

        echo json_encode($output);
    }

    private function getTransactionDetail($attr)
    {
        $record = '';
        foreach ($attr as $detailRows) {
            $record .= '<div style="padding-bottom:0px;"><table class="table w-100" style="font-size:12px;pointer-events:none; margin-bottom: 3px;"><tbody><tr>';
            $record .= '<td style="padding: 5px 3px 5px 3px;border-bottom:1px solid #ccc;">' . strtoupper($detailRows->name) . ' <span style="width:0px; border-bottom:1px solid #ccc; padding: 3px 7px;" class="label bg-maroon">' . $detailRows->quantity . '</span></td>';
            $record .= '<td style="padding: 5px 3px 5px 3px;text-align:right;border-bottom:1px solid #ccc;">';
            $record .= !empty($detailRows->discount) ? 'Rp. ' . number_format(floatval($detailRows->price * $detailRows->quantity), 0,  '.', '.') . ' - ' . 'Rp. ' . number_format(floatval($detailRows->discount), 0, '.', '.') . ' = ' . 'Rp. ' . number_format(floatval(($detailRows->price * $detailRows->quantity) - $detailRows->discount), 0, '.', '.') : 'Rp. ' . number_format(floatval($detailRows->price * $detailRows->quantity), 0,  '.', '.');
            $record .= '</td></tr>';
            $record .= '</tbody></table></div>';
        }
        return $record;
    }
}
