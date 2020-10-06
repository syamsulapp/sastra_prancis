<?php

class Model_login extends CI_Model
{

	public function get($table_name = null, $where = null, $join = null, $order = null, $select = null, $string = null)
	{
		if ($string) {
			$query = $this->db->query($string);
		} else {
			if ($where) {
				foreach ($where as $where_) {
					$this->db->where($where_['where_field'], $where_['where_key']);
				}
			}
			if ($select) {
				$this->db->select($select);
			} else {
				$this->db->select('*');
			}
			$this->db->from($table_name);
			$query = $this->db->get();
		}
		return $query->result_array();
	}

	function get_db_session_data()
	{
		$query = $this->db->select('user_data')->get('ci_sessions');
		$user = array();
		foreach ($query->result() as $row) {
			$udata = unserialize($row->user_data);
			$user['username'] = $udata['username'];
			$user['is_logged_in'] = $udata['is_logged_in'];
		}
		return $user;
	}

	function data_user($username, $password)
	{
		/*$this->db->select('*');
		$this->db->from('pengguna');
		$this->db->where('username', $username);
		$query = $this->db->get();
		return $query->result_array();*/
		$string = "SELECT * FROM `pengguna` WHERE (`username`='" . $username . "' OR `email`='" . $username . "') AND `password`='" . $password . "' AND `status_pengguna`='aktif'";
		$get = $this->get(null, null, null, null, null, $string);
		return $get;
	}

	function validate($username, $password)
	{
		$get = null;
		/*$where = array(
			array(
				'where_field'=>'username',
				'where_key'=>$username
			),
			array(
				'where_field'=>'password',
				'where_key'=>$password
			),
			array(
				'where_field'=>'status_pengguna',
				'where_key'=>'aktif'
			)
		);
		$get = $this->get('pengguna',$where);*/
		$string = "SELECT * FROM `pengguna` WHERE (`username`='" . $username . "' OR `email`='" . $username . "') AND `password`='" . $password . "' AND `status_pengguna`='aktif'";
		$get = $this->get(null, null, null, null, null, $string);
		if ($get != null) {
			$get = 'true';
			return $get;
		}
	}

	function validate_email($email)
	{
		$get = null;
		$where = array(
			array(
				'where_field' => 'email',
				'where_key' => $email
			)
		);
		$get = $this->get('pengguna', $where);
		if ($get != null) {
			$get = 'true';
			return $get;
		}
	}

	public function update($table_name, $data, $where)
	{
		if ($where) {
			foreach ($where as $where_) {
				$this->db->where($where_['where_field'], $where_['where_key']);
			}
		}
		$this->db->update($table_name, $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if ($report !== 0) {
			return true;
		} else {
			return false;
		}
	}
}

/* End of file model_login.php */
/* Location: ./application/models/model_login.php */