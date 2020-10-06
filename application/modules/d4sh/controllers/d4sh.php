<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class d4sh extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_login');
		$this->load->library('crud');
		//$this->load->dbutil();
		$ses = array();
		if ($this->session->userdata('lang') == '') {
			$ses['lang'] = 'id';
		}
		if ($this->session->userdata('clang') == '') {
			$this->language('id');
		}
		$this->session->set_userdata($ses);
	}

	public function index()
	{
		if ($this->session->userdata('is_logged_in') == 'login') {
			redirect('cms');
		}
		$ses['email'] = '';
		$this->session->set_userdata($ses);
		$data['site'] = $this->web();
		$data['site']['web']['blogpagetitle'] = 'Halaman Masuk';
		$data['modules'] = 'd4sh';
		$data['content'] = 'v_login';
		$this->load->view('login', $data);
	}

	function web()
	{
		$web_['web'] = null;
		$table_name = 'web';
		if ($this->db->table_exists($table_name)) {
			$web_['error'] = 0;
			$string = "SELECT * FROM `web`";
			$data = $this->crud->get(null, null, null, null, null, $string);
			if ($data == null) {
				$web_['error'] = 'web tidak ada!';
			} else {
				foreach ($data as $row) {
					$web_['web'][$row['option_name']] = $row['option_value'];
				}
			}
		} else {
			$web_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $web_;
	}

	function __encrip_password($password)
	{
		return md5($password);
	}

	function validate_credentials()
	{
		$is_valid = null;
		$user['info_lain'] = null;
		$username = $this->input->post('username');
		$password = $this->__encrip_password($this->input->post('password'));
		$is_valid = $this->model_login->validate($username, $password);
		if ($is_valid != null) {
			$data_user = $this->model_login->data_user($username, $password);
			foreach ($data_user[0] as $row) {
				$index = array_search($row, $data_user[0]);
				$ses[$index] = $row;
			}
			$table_name = 'pengguna';
			$where = array(
				array(
					'where_field' => 'id_pengguna',
					'where_key' => $data_user[0]['id_pengguna']
				)
			);
			$data = array('last_activity_' => date('Y-m-d h:i:s'));
			$this->model_login->update($table_name, $data, $where);
			if ($data_user[0]['id_pengguna'] != '') {
				$data['site'] = $this->web();
				$ses['is_logged_in'] = 'login';
				$ses['psn'] = 'Selamat datang ' . $username . ' di ' . $data['site']['web']['blogname'] . '-' . $data['site']['web']['blogdescription'];
				$this->session->set_userdata($ses);
				//log
				if ($this->db->table_exists('log')) {
					$data_ = array(
						'id_user' => $this->session->userdata('id_pengguna'),
						'log' => 'login',
						'status_log' => 'success',
						'tgl_log' => date('Y-m-d h:i:s')
					);
					$this->crud->insert('log', $data_);
				}
				//log end
				redirect('d4sh');
			}
		} else {
			$ses['psn'] = 'Nama Pengguna atau Kata Kunci tidak cocok dengan Anggota manapun.';
			$this->session->set_userdata($ses);
			redirect('d4sh');
		}
	}

	function logout()
	{
		//log
		if ($this->db->table_exists('log')) {
			$data_ = array(
				'id_user' => $this->session->userdata('id_pengguna'),
				'log' => 'logout',
				'status_log' => 'success',
				'tgl_log' => date('Y-m-d h:i:s')
			);
			$this->crud->insert('log', $data_);
		}
		//log end

		$this->session->sess_destroy();
		header("location: " . base_url() . "index.php");
	}

	function hps_ses_msg()
	{
		$this->session->sess_destroy();
		echo json_encode('ok');
	}

	function lupapass()
	{
		$data['site'] = $this->web();
		$data['site']['web']['blogpagetitle'] = 'Halaman Lupa Kata Kunci';
		$data['modules'] = 'login';
		$data['content'] = 'v_lupapass';
		$this->load->view('login', $data);
	}

	function checkemail()
	{
		$is_valid = null;
		$email = $this->input->post('email');
		$where = array(
			array(
				'where_field' => 'email',
				'where_key' => $email
			)
		);
		$is_valid = $this->crud->get('pengguna', $where);
		if ($is_valid != null) {
			if (isset($email) && $email != '') {
				$ses['email'] = $email;
				$ses['uid'] = $is_valid[0]['id_pengguna'];
				$this->session->set_userdata($ses);
			}
			if ($this->session->userdata('email') != '') {
				$data['site'] = $this->web();
				$data['site']['web']['blogpagetitle'] = 'Halaman Lupa Kata Kunci';
				$data['modules'] = 'login';
				$data['content'] = 'v_newpass';
				$this->load->view('login', $data);
			} else {
				redirect('login');
			}
		} else {
			$ses['psn'] = 'Email tidak terdaftar oleh Anggota manapun.';
			$this->session->set_userdata($ses);
			redirect('login');
		}
	}

	function setpass()
	{
		//print_r($this->input->post());
		if ($this->input->post('uid') != '' && $this->input->post('email2') != '' && ($this->input->post('password1') == $this->input->post('password2'))) {
			$data = array(
				'kode_aktivasi' => md5($this->input->post('password1'))
			);
			$where = array(
				array(
					'where_field' => 'id_pengguna',
					'where_key' => $this->input->post('uid')
				),
				array(
					'where_field' => 'email',
					'where_key' => $this->input->post('email2')
				)
			);
			$this->crud->update('pengguna', $data, $where);

			/*sending email*/
			$this->load->library('email');
			$this->email->from('no-reply@serverjogja.com', site_url());
			$this->email->to($this->input->post('email2'));
			$this->email->cc('gedankgorenk@rocketmail.com');
			$this->email->bcc('wahyu_ha3x@yahoo.co.id');
			$this->email->subject('Ubah Kata Kunci');
			$this->email->message(site_url('login/kukk/' . $this->input->post('uid') . '/' . md5($this->input->post('password1'))));
			$this->email->send();

			//echo $this->email->print_debugger();

			echo $ses['psn'] = 'Ubah Kata Kunci Berhasil.<br>Check Email Anda dan Konfirmasi.';
			$this->session->set_userdata($ses);
			redirect('login');
		} else {
			echo $ses['psn'] = 'Ubah Kata Kunci Gagal.';
			$this->session->set_userdata($ses);
			redirect('login');
		}
	}

	function kukk()
	{
		if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
			$data = array(
				'password' => $this->uri->segment(4)
			);
			$where = array(
				array(
					'where_field' => 'id_pengguna',
					'where_key' => $this->uri->segment(3)
				),
				array(
					'where_field' => 'kode_aktivasi',
					'where_key' => $this->uri->segment(4)
				)
			);
			$this->crud->update('pengguna', $data, $where);
			$ses['psn'] = 'Ubah Kata Kunci Berhasi.';
			$this->session->set_userdata($ses);
			redirect('login');
		} else {
			$ses['psn'] = 'Ubah Kata Kunci Gagal.';
			$this->session->set_userdata($ses);
			redirect('login');
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */