<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cash_report_model extends CI_Model
{
  var $table = 'transactions as t';
  var $column_order = array('cash_date', 'invoice');
  var $column_search = array('cash_date', 'invoice');
  var $order = array('cash_date' => 'DESC');

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function _datatablesQuery()
  {
    $sql = "";
        
    if ($this->input->post('start_date') && $this->input->post('end_date')) {
        $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
        $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
        $sql .= "WHERE result.cash_date BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'";
    }

    if ($this->input->post('user')) {
        $sql .= " AND result.users_id = '".$this->input->post('user')."'";
    }

    $cash = $this->db->query("
        SELECT
            *
        FROM
            (
            SELECT
                id AS trans_id,
                transaction_date AS cash_date,
                invoice,
                total AS debet,
                'TRANSAKSI' AS keterangan,
                NULL AS kredit,
                users_id
            FROM
                transactions
            WHERE
        STATUS
            = 'SUCCESS'
        UNION ALL
        SELECT NULL AS
            trans_id,
            date AS cash_date,
            NULL,
            total AS debet,
            UPPER(description) AS keterangan,
            NULL AS kredit,
            users_id
        FROM
            incomes
        UNION ALL
        SELECT NULL AS
            trans_id,
            date AS cash_date,
            NULL,
            NULL AS debet,
            UPPER(description) AS keterangan,
            total AS kredit,
            users_id
        FROM
            expenditures
        ) AS result

        ".$sql."

        ORDER BY result.cash_date ASC
    ");

    if ($cash->num_rows() > 0) {
      return $cash;
    } else {
      return [];
    }

  }

  public function _getDatatablesQuery()
  {
    $this->db->query("SELECT t.id as trans_id, t.transaction_date as cash_date, t.invoice, 
    t.total as debet, 'TRANSAKSI' as keterangan, NULL as kredit, t.users_id as users_id 
    FROM transactions t WHERE t.status = 'SUCCESS' UNION ALL SELECT NULL as trans_id, 
    i.date as cash_date, NULL, i.total as debet, UPPER(i.description) as keterangan, 
    NULL as kredit, NULL FROM incomes i UNION ALL SELECT NULL as trans_id, e.date as cash_date, 
    NULL, NULL as debet, UPPER(e.description) as keterangan, e.total as kredit, 
    NULL FROM expenditures e;");

    if ($this->input->post('start_date') && $this->input->post('end_date')) {
      $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
      $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
      $this->db->where("cash_date BETWEEN '" . $start_date . " 00:00:00' AND '" . $end_date . " 23:59:59'");
    }
    if ($this->input->post('user')) {
      $this->db->where('users_id', $this->input->post('user'));
    }
    $this->db->from($this->table);
    $this->db->get()->result();

    $i = 0;

    foreach ($this->column_search as $key => $value) {
      if ($_POST['search']['value']) {
        if ($i === 0) {
          $this->db->group_start();
          $this->db->like($value, $_POST['search']['value']);
        } else {
          $this->db->or_like($value, $_POST['search']['value']);
        }
        if (count($this->column_search) - 1 == $i)
          $this->db->group_end();
      }
      $i++;
    }
    if (isset($_POST['order'])) {
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function _getDatatables()
  {
    $this->_getDatatablesQuery();
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function _countFiltered()
  {
    $this->_getDatatablesQuery();
    $query = $this->db->get();
    return $query->num_rows();
  }

  function _countAll()
  {
    $this->_getDatatablesQuery();
    $query = $this->db->get();
    return $query->num_rows();
  }
}
