<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sistem_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function _validate($username)
	{
		$this->db->select('users.*');
		$this->db->from('users');
		$this->db->where('users.username', $username);

		$query = $this->db->get();

		if ($query->num_rows() > 0) return $query->row_array();
		else return array();
	}

	function select(
		$table,
		$where = null,
		$likes = null,
		$joins = null,
		$select = null,
		$groupby = null,
		$orderby = null,
		$limit = null,
		$limit_start = null,
		$havings = null
	) {

		if (!empty($where)) {
			$this->db->where($where);
		}
		if (!empty($likes)) {
			$this->db->group_start();
			$like = $likes;
			reset($like);
			$this->db->like([key($like) => $like[key($like)]], 'both');
			array_shift($likes);
			$this->db->or_like($likes, 'both');
			$this->db->group_end();
		}
		if (!empty($select)) {
			$this->db->select($select);
		}
		if (!empty($joins)) {
			foreach ($joins as $key => $value) {
				$this->db->join($key, $value, 'left');
			}
		}
		if (!empty($groupby)) {
			$this->db->group_by($groupby);
		}
		if (!empty($orderby)) {
			$this->db->order_by($orderby);
		}
		if (!empty($limit)) {
			if (!empty($limit_start)) {
				$this->db->limit($limit, $limit_start);
			} else {
				$this->db->limit($limit);
			}
		}
		if (!empty($havings)) {
			$this->db->having($havings);
		}

		$query = $this->db->get($table);

		return $query;
	}

	function _input($table, $data)
	{
		return $this->db->insert($table, $data);
	}

	function _input_all($table, $data)
	{
		return $this->db->insert_batch($table, $data);
	}

	function _get($table, $order_by = "")
	{

		if (!empty($order_by)) {
			$order = explode("-", $order_by);
			$this->db->order_by($order['0'], $order[1]);
		}

		$query = $this->db->get($table);

		if ($query->num_rows() > 0) return $query->result_array();
		else return array();
	}

	function _get_spesipic($table, $spesipic = "", $order_by = "")
	{

		if (!empty($order_by)) {
			$order = explode("-", $order_by);
			$this->db->order_by($order['0'], $order[1]);
		}

		$this->db->select($spesipic);
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) return $query->result_array();
		else return array();
	}

	function _get_spesipic_where($table, $spesipic = "", $where = "", $order_by = "")
	{

		if (!empty($order_by)) {
			$order = explode("-", $order_by);
			$this->db->order_by($order['0'], $order[1]);
		}

		$this->db->select($spesipic);
		$this->db->where($where);
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) return $query->result_array();
		else return array();
	}

	function _get_spesipic_max_where($table, $spesipic = "", $where = "", $max = "")
	{
		$this->db->select($spesipic);
		$this->db->select_max($max);
		$this->db->where($where);
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) return $query->result_array();
		else return array();
	}

	function _get_where_id($table, $where)
	{
		$this->db->where($where);
		$query = $this->db->get($table);

		$row = $query->row_array();

		if ($query->num_rows() > 0) return $row;
		else return array();
	}

	function _get_wheres($table, $where, $order_by = "")
	{

		$this->db->where($where);

		if (!empty($order_by)) {
			$order = explode("-", $order_by);
			$this->db->order_by($order['0'], $order[1]);
		}

		$query = $this->db->get($table);

		if ($query->num_rows() > 0) return $query->result_array();
		else return array();
	}

	function _get_all($table, $order_by = "")
	{

		if (!empty($order_by)) {
			$order = explode("-", $order_by);
			$this->db->order_by($order['0'], $order[1]);
		}

		$query = $this->db->get($table);

		if ($query->num_rows() > 0) return $query->result_array();
		else return array();
	}

	// function _get_wheres_limit($table, $where, $order_by = "", $limit, $offset)
	// {

	// 	$this->db->where($where);

	// 	if (!empty($order_by)) {
	// 		$order = explode("-", $order_by);
	// 		$this->db->order_by($order['0'], $order[1]);
	// 	}

	// 	$this->db->limit($offset, $limit);
	// 	$query = $this->db->get($table);

	// 	if ($query->num_rows() > 0) return $query->result_array();
	// 	else return array();
	// }


	function _get_limit($table, $order_by = "", $limit = "")
	{

		if (!empty($order_by)) {
			$order = explode("-", $order_by);
			$this->db->order_by($order['0'], $order[1]);
		}

		$this->db->limit($limit);
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) return $query->result_array();
		else return array();
	}

	function _get_count($table)
	{
		if (!empty($order_by)) {
			$order = explode("-", $order_by);
			$this->db->order_by($order['0'], $order[1]);
		}

		$this->db->get($table);
		$query = $this->db->count_all();
		return $query;
	}

	function _get_wheres_count($table, $where)
	{

		$this->db->where($where);

		if (!empty($order_by)) {
			$order = explode("-", $order_by);
			$this->db->order_by($order['0'], $order[1]);
		}

		$this->db->get($table);
		$query = $this->db->count_all_results();
		return $query;
	}

	function _delete($table, $where)
	{
		$this->db->delete($table, $where);
	}

	function _update($table, $data, $where)
	{
		return $this->db->update($table, $data, $where);
	}

	function _get_abs()
	{
		$query = $this->db->query("SELECT * FROM `absensi` WHERE jenis = '1'
			ORDER BY `absensi`.`jenis` ASC");

		return $query->result_array();
	}

	function _get_karyawan_session()
	{
		$karyawan_id = $this->session->userdata('karyawan_id');
		$this->db->select('k.nama_lengkap as nama_lengkap, k.id, u.level');
		$this->db->join('user as u', 'u.karyawan_id = k.id', 'left');
		$this->db->where('k.id', $karyawan_id);
		$this->db->from('karyawan k');

		$query = $this->db->get();
		return $query->result_array();
	}

	function _get_jumlah_telat()
	{
		$konfig_jam_masuk = $this->_get_wheres('komposisi_gaji', array('title' => 'jam_masuk'), 'id-asc');
		$this->db->select('a.jam, a.status, c.jam_masuk, a.karyawan_id');
		$this->db->join('cabang c', 'c.id = a.cabang_id', 'left');
		$this->db->where('a.jam >', 'c.jam_masuk' . ' ' . date('s'));
		$this->db->where('a.status', '0');
		$this->db->where('a.karyawan_id', $this->session->userdata('karyawan_id'));
		$this->db->from('absensi a');

		$query = $this->db->get();
		return $query->result_array();
	}

	function get_karyawan_cabang()
	{
		$this->db->select('k.*, j.nama as jabatan, c.nama as nama_domisili, c.id as cabang_id');
		$this->db->join('jabatan as j', 'j.id = k.jabatan_id', 'left');
		$this->db->join('cabang as c', 'c.id = k.domisili', 'left');
		$this->db->where('k.status != ', 'Tidak Aktif');
		$this->db->order_by('nama_lengkap', 'ASC');
		$this->db->from('karyawan k');

		$query = $this->db->get();
		return $query->result_array();
	}

	function _grouping_array($arr, $group, $preserveGroupKey = false, $preserveSubArrays = false)
	{

		$temp = array();
		foreach ($arr as $key => $value) {
			$groupValue = isset($value[$group]) ? $value[$group] : '';

			if (count($arr[$key]) == 1) {
				$temp[$groupValue][] = current($arr[$key]);
			} else {
				$temp[$groupValue][] = $arr[$key];
			}
		}
		return $temp;
	}

	function dropTable()
	{
		$cek = $this->db->query('SHOW TABLES');

		if ($cek->num_rows() > 0) {
			$query = $this->db->query('DROP TABLE absensi, 
				branch, branch_toko, cabang, countries, hutang, hutang_pembayaran,
				hutang_pembayaran_2, jabatan, karyawan, karyawan_gaji, kategori, kk_desa, kk_kota, kk_provinsi, komposisi_gaji,
				konfigurasi, laporan, pemindahan_cabang, penggajian, penggajian_detail, piutang, rincian_gaji, user, v_pemindahan_cabang');

			return $query;
		} else {
			return false;
		}
	}

	function _get_only_limit($table, $order_by, $limit)
	{
		if (!empty($order_by)) {
			$order = explode("-", $order_by);
			$this->db->order_by($order['0'], $order[1]);
		}

		$this->db->limit($limit);
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) return $query->result_array();
		else return array();
	}
}
