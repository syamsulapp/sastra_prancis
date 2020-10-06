<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../../controllers/setting.php");
class Cms extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
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
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site'] = $this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['chart'] 		= $this->gettahunini();
		$data['site']['page'] = 'Beranda';
		$data['modules'] = 'cms';
		$data['content'] = 'v_cms';
		$this->load->view('../../template/template', $data);
	}

	function language($lang)
	{
		$fl = base_url() . "assets/lang/$lang.json";
		$dict = @file_get_contents($fl);
		$ses['lang']        = $lang;
		$ses['clang']       = $dict;
		$this->session->set_userdata($ses);
		redirect('home');
	}

	public function simpanNote()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$catatan = trim($this->input->post('catatan'));
		if ($this->session->userdata('user') != '') {
			$uid = $this->session->userdata('user');
		} else {
			$uid = 1;
		}
		if (!$uid)
			die('Halaman tidak dapat diakses !');
		$BASEDIR = dirname(BASEPATH);
		$path = $BASEDIR;
		$this->buatfolder($path, 'note');
		$nBASEDIR   = $BASEDIR . '/note/' . $uid . '-note.txt';
		if ($sch_file_handle = @fopen($nBASEDIR, "w+")) {
			@fwrite($sch_file_handle, $catatan);
			@fclose($sch_file_handle);
		}

		redirect('cms');
	}

	public function buatfolder($path, $name)
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$new_dir = $path . "/" . $name;
		if ((file_exists($new_dir)) && (is_dir($new_dir))) {
			//echo "Direktori <b>".$new_dir."</b> Sudah ada";
		} else {
			$handle = mkdir($new_dir);
			if ($handle) {
				//echo "Direktori <b>".$new_dir."</b> berhasil dibuat";
			} else {
				//echo "Direktori <b>".$new_dir."</b> gagal dibuat";
			}
		}
		return true;
	}

	function gettahunini()
	{
		$tahun = date('Y');
		for ($i = 0; $i < 12; $i++) {
			if ($i < 10) {
				$j = '0' . ($i + 1);
			} else {
				$j = $i + 1;
			}
			$count = $this->crud->get(null, null, null, null, null, "SELECT * FROM `konter` WHERE Substring(`tanggal`,1,6)='" . $tahun . $j . "'");
			if ($count != null) {
				$count = count($count);
			} else {
				$count = 0;
			}
			$data[$i] = $count;
		}
		//echo json_encode($data);
		return $data;
	}

	function tulisan()
	{
		$this->index();
	}

	function halaman()
	{
		$this->index();
	}

	function pengguna()
	{
		if ($this->session->userdata('level') != 'administrator') {
			redirect('home/errors');
		}
		$this->index();
	}

	function tampilan()
	{
		if ($this->session->userdata('level') != 'administrator') {
			redirect('home/errors');
		}
		$this->index();
	}

	function statistik()
	{
		if ($this->session->userdata('level') != 'administrator') {
			redirect('home/errors');
		}
		$this->index();
	}

	function status_website()
	{
		$table_name = 'web';
		$where = array(
			array(
				'where_field' => 'option_name',
				'where_key' => 'status_website'
			)
		);
		if ($this->input->post('status_website') == 'on') {
			$data = array(
				'option_value' => 'off'
			);
			$this->crud->update($table_name, $data, $where);
		} else {
			$data = array(
				'option_value' => 'on'
			);
			$this->crud->update($table_name, $data, $where);
		}
		echo json_encode('ok');
	}
}

/* End of file cms.php */
/* Location: ./application/controllers/cms.php */