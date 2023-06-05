<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginCheck();
		$this->load->model('sistem_model');
	}
	public function index()
	{
		$this->db->select('count(name) as total_product');
		$totalProducts = $this->db->get('foods');
		$data['totalProduct'] = $totalProducts->row_array()['total_product'];

		$this->db->select('count(total) as total_transaction');
		$totalTransaction = $this->db->get('transactions');
		$data['totalTransaction'] = $totalTransaction->row_array()['total_transaction'];

		$today = date('Y-m-d');
		$this->db->select('sum(total) as total_today, count(total) as total_transaction_today');
		$this->db->where("created_at BETWEEN '".$today." 00:00:00 ' AND '".$today." 23:59:59'");
		$transactionToday = $this->db->get('transactions');

		$data['incomeTransactionToday'] = 'Rp. '.number_format($transactionToday->row()->total_today).',-';
		$data['totalTransactionToday'] = $transactionToday->row_array()['total_transaction_today'];

		$this->db->select('transactions.*');
        $this->db->join('users', 'transactions.users_id = users.id');
        $this->db->order_by('transactions.datetime', 'DESC');
		$this->db->limit(3);
        $transactions = $this->db->get('transactions')->result();
        foreach ($transactions as $key => &$value) {
            $this->db->select('transaction_details.*, foods.name');
            $this->db->from('transaction_details');
            $this->db->join('transactions', 'transactions.id = transaction_details.transactions_id');
			$this->db->join('foods', 'transaction_details.foods_id = foods.id');
            $this->db->where('transaction_details.transactions_id', $value->id);
            $value->transaction_details = $this->db->get()->result();
        }
        $data['lastTransctions'] = $transactions;

		$this->load->view('v_dashboard', $data);
	}
}
