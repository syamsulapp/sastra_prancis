<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../../controllers/setting.php");
class Halaman extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
		$this->nm_app = 'cms_kutim';
	}
	function index()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site'] = $this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page'] = 'Daftar Halaman';
		$data['data'] = $this->halaman();
		$data['modules'] = 'halaman';
		$data['content'] = 'v_halaman';
		$this->load->view('../../template/template', $data);
	}
	function sampah()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site'] = $this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page'] = 'Sampah Halaman';
		$data['data'] = $this->halaman_sampah();
		$data['modules'] = 'halaman';
		$data['content'] = 'v_halaman_sampah';
		$this->load->view('../../template/template', $data);
	}
	function baru()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}

		$data = $this->setting->get_jml();
		$data['site'] = $this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page'] = 'Tambah Halaman Baru';
		$data['modules'] = 'halaman';
		$data['content'] = 'v_halaman_baru';
		$this->load->view('../../template/template', $data);
	}
	function sunting()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}

		if ($this->input->get('id') != '') {
			$data = $this->setting->get_jml();
			$tulisan = null;
			$data['psn']['sunting'] = 'true';
			$this->session->set_userdata($data['psn']);

			$data['halaman'] = null;
			$tulisan = null;
			$tulisan = $this->crud->get('tulisan', array(array('where_field' => 'id_tulisan', 'where_key' => $this->input->get('id'))));
			if ($tulisan != null && isset($tulisan[0]['penulis']) && ($tulisan[0]['penulis'] == $this->session->userdata('id_pengguna')) or ($this->session->userdata('level') == 'administrator')) {
				if (isset($tulisan[0])) {
					$data['halaman'] = $tulisan[0];
					$data['sunting'] = 'true';
				}
				$data['site'] = $this->setting->web();
				$data['kom'] = $this->setting->komentar_menunggu();
				$data['tes'] = $this->setting->testimoni_menunggu();
				$data['sts'] = $this->setting->status_website();
				$data['site']['page'] = 'Sunting Tulisan';
				$data['modules'] = 'halaman';
				$data['content'] = 'v_halaman_baru';
				$this->load->view('../../template/template', $data);
			} else {
				redirect('halaman');
			}
		} else {
			redirect('halaman');
		}
	}
	function addhalaman()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$this->form_validation->set_rules('nama_halaman_id', 'nama_halaman_id', 'required');
				if ($this->form_validation->run()) {
					if ($this->input->post('id_halaman') == '') {
						$data = array(
							'penulis' => '1',
							'judul_eng' => ($this->input->post('nama_halaman_eng') != '') ? $this->input->post('nama_halaman_eng') : $this->input->post('nama_halaman_id'),
							'tulisan_eng' => str_replace('src="/' . $this->nm_app . '/', 'src="' . base_url(), $this->input->post('halaman_eng')),
							'judul_id' => $this->input->post('nama_halaman_id'),
							'tulisan_id' => str_replace('src="/' . $this->nm_app . '/', 'src="' . base_url(), $this->input->post('halaman_id')),
							'judul_ae' => ($this->input->post('nama_halaman_ae') != '') ? $this->input->post('nama_halaman_ae') : $this->input->post('nama_halaman_id'),
							'tulisan_ae' => str_replace('src="/' . $this->nm_app . '/', 'src="' . base_url(), $this->input->post('halaman_ae')),
							'gambar_andalan' => $this->input->post('gambar_andalan'),
							'status_komentar' => $this->input->post('status_komentar_halaman'),
							'tgl_tulisan' => $this->input->post('tgl_halaman'),
							'tipe' => 'page',
							'status_tulisan' => 'menunggu'
						);
						$this->crud->insert($table_name, $data);
					} else {
						$data = array(
							'penulis' => '1',
							'judul_eng' => ($this->input->post('nama_halaman_eng') != '') ? $this->input->post('nama_halaman_eng') : $this->input->post('nama_halaman_id'),
							'tulisan_eng' => str_replace('src="/' . $this->nm_app . '/', 'src="' . base_url(), $this->input->post('halaman_eng')),
							'judul_id' => $this->input->post('nama_halaman_id'),
							'tulisan_id' => str_replace('src="/' . $this->nm_app . '/', 'src="' . base_url(), $this->input->post('halaman_id')),
							'judul_ae' => ($this->input->post('nama_halaman_ae') != '') ? $this->input->post('nama_halaman_ae') : $this->input->post('nama_halaman_id'),
							'tulisan_ae' => str_replace('src="/' . $this->nm_app . '/', 'src="' . base_url(), $this->input->post('halaman_ae')),
							'gambar_andalan' => $this->input->post('gambar_andalan'),
							'status_komentar' => $this->input->post('status_komentar_halaman'),
							'tgl_tulisan' => $this->input->post('tgl_halaman'),
							'tipe' => 'page'
						);
						$where = array(
							array(
								'where_field' => 'id_tulisan',
								'where_key' => $this->input->post('id_halaman')
							)
						);
						$this->crud->update($table_name, $data, $where);
					}
					$this->session->set_flashdata('success', 'halaman ' . $this->input->post('nama_halaman') . ' berhasil disimpan');
				} else {
					$this->session->set_flashdata('warning', 'halaman gagal disimpan');
				}
			} else {
				$this->session->set_flashdata('danger', 'ERROR!');
			}
		} else {
			$this->session->set_flashdata('danger', 'Tabel ' . $table_name . ' tidak ada!');
		}
		redirect('halaman/halaman');
	}
	function delhalaman()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$this->form_validation->set_rules('id', 'id', 'required');
				if ($this->form_validation->run()) {
					$data = array(
						'status_tulisan' => 'sampah'
					);
					$where = array(
						array(
							'where_field' => 'id_tulisan',
							'where_key' => $this->input->post('id')
						)
					);
					$this->crud->update($table_name, $data, $where);
					$this->session->set_flashdata('success', 'halaman berhasil dihapus');
				} else {
					$this->session->set_flashdata('warning', 'halaman gagal dihapus');
				}
			} else {
				$this->session->set_flashdata('danger', 'ERROR!');
			}
		} else {
			$this->session->set_flashdata('danger', 'Tabel ' . $table_name . ' tidak ada!');
		}
		redirect('halaman/halaman');
	}
	function delhalamanmassal()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
				if ($this->form_validation->run()) {
					$id = $this->input->post('check_list');
					foreach ($id as $id_) {
						if ($this->input->post('aksi_tindakan_massal_atas') == 'hps' or $this->input->post('aksi_tindakan_massal_bawah') == 'hps') {
							$data = array(
								'status_tulisan' => 'sampah'
							);
							$where = array(
								array(
									'where_field' => 'id_tulisan',
									'where_key' => $id_
								)
							);
							$this->crud->update($table_name, $data, $where);
						}
					}
					$this->session->set_flashdata('success', 'halaman berhasil dihapus');
				} else {
					$this->session->set_flashdata('warning', 'halaman gagal dihapus');
				}
			} else {
				$this->session->set_flashdata('danger', 'ERROR!');
			}
		} else {
			$this->session->set_flashdata('danger', 'Tabel ' . $table_name . ' tidak ada!');
		}
		redirect('halaman/halaman');
	}
	function delhalamanpermanen()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$this->form_validation->set_rules('id', 'id', 'required');
				if ($this->form_validation->run()) {
					$where = array(
						array(
							'where_field' => 'id_tulisan',
							'where_key' => $this->input->post('id')
						)
					);
					$this->crud->delete($table_name, $where);
					$this->session->set_flashdata('success', 'halaman berhasil dihapus');
				} else {
					$this->session->set_flashdata('warning', 'halaman gagal dihapus');
				}
			} else {
				$this->session->set_flashdata('danger', 'ERROR!');
			}
		} else {
			$this->session->set_flashdata('danger', 'Tabel ' . $table_name . ' tidak ada!');
		}
		redirect('halaman/sampah');
	}
	function delhalamanmassalpermanen()
	{
		if ($this->session->userdata('is_logged_in') != 'login') {
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
				if ($this->form_validation->run()) {
					$id = $this->input->post('check_list');
					foreach ($id as $id_) {
						if ($this->input->post('aksi_tindakan_massal_atas') == 'hps' or $this->input->post('aksi_tindakan_massal_bawah') == 'hps') {
							$where = array(
								array(
									'where_field' => 'id_tulisan',
									'where_key' => $id_
								)
							);
							$this->crud->delete($table_name, $where);
						} else if ($this->input->post('aksi_tindakan_massal_atas') == 'kmbl' or $this->input->post('aksi_tindakan_massal_bawah') == 'kmbl') {
							$data = array(
								'status_tulisan' => 'menunggu'
							);
							$where = array(
								array(
									'where_field' => 'id_tulisan',
									'where_key' => $id_
								)
							);
							$this->crud->update($table_name, $data, $where);
						}
					}
					$this->session->set_flashdata('success', 'halaman berhasil dihapus');
				} else {
					$this->session->set_flashdata('warning', 'halaman gagal dihapus');
				}
			} else {
				$this->session->set_flashdata('danger', 'ERROR!');
			}
		} else {
			$this->session->set_flashdata('danger', 'Tabel ' . $table_name . ' tidak ada!');
		}
		redirect('halaman/sampah');
	}
	function halaman()
	{
		$tulisan_['tulisan'] = null;
		if (@$_GET['cari'] != '') {
			$cari = "WHERE `tipe`= 'page' AND `status_tulisan` != 'sampah' AND (`judul_id` LIKE '%" . $_GET['cari'] . "%' OR `tulisan_id` LIKE '%" . $_GET['cari'] . "%' OR `judul_eng` LIKE '%" . $_GET['cari'] . "%' OR `tulisan_eng` LIKE '%" . $_GET['cari'] . "%' OR `judul_ae` LIKE '%" . $_GET['cari'] . "%' OR `tulisan_ae` LIKE '%" . $_GET['cari'] . "%') ORDER BY `tgl_tulisan` DESC";
		} else {
			$cari = "WHERE `tipe`= 'page' AND `status_tulisan` != 'sampah' ORDER BY `tgl_tulisan` DESC";
		}
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			$tulisan_['error'] = 0;
			$string = "SELECT * FROM `tulisan` " . $cari;
			$tulisan = $this->crud->get(null, null, null, null, null, $string);
			$config['base_url'] = site_url('halaman/halaman/index/page');
			$config['total_rows'] = count($tulisan);
			$config['per_page'] = '10';
			$config['first_page'] = 'Awal';
			$config['last_page'] = 'Akhir';
			$config['next_page'] = '«';
			$config['prev_page'] = '»';
			$config['next_link'] = '&rarr;';
			$config['prev_link'] = '&larr;';
			$config['uri_segment'] = 5;
			$config['full_tag_open'] = '<ul class="pagination" style="margin:0px 7px;">';
			$this->pagination->initialize($config);
			$tulisan_['pagging'] = $this->pagination->create_links();
			if ($tulisan != null) {
				$tulisan_['total_rows'] = $config['total_rows'];
			} else {
				$tulisan_['total_rows'] = 0;
			}

			if ($this->uri->segment(5) != '') {
				$offset = $this->uri->segment(5);
			} else {
				$offset = 0;
			}
			$string_2 = "SELECT * FROM `tulisan` " . $cari . " limit " . $offset . "," . $config['per_page'];
			$tulisan_['tulisan'] = $this->crud->get(null, null, null, null, null, $string_2);
			$tulisan_['no'] = $offset;
			$tulisan_['total_rows_2'] = $this->crud->get(null, null, null, null, null, "SELECT count(`id_tulisan`) as `total` FROM `tulisan` WHERE `tipe` = 'page' AND `status_tulisan` = 'sampah' ORDER BY `tgl_tulisan` DESC");
		} else {
			$tulisan_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $tulisan_;
	}

	function halaman_sampah()
	{
		$tulisan_['tulisan'] = null;
		if (@$_GET['cari'] != '') {
			$cari = "WHERE `tipe`= 'page' AND `status_tulisan` = 'sampah' AND (`judul_id` LIKE '%" . $_GET['cari'] . "%' OR `tulisan_id` LIKE '%" . $_GET['cari'] . "%' OR `judul_eng` LIKE '%" . $_GET['cari'] . "%' OR `tulisan_eng` LIKE '%" . $_GET['cari'] . "%' OR `judul_ae` LIKE '%" . $_GET['cari'] . "%' OR `tulisan_ae` LIKE '%" . $_GET['cari'] . "%') ORDER BY `tgl_tulisan` DESC";
		} else {
			$cari = "WHERE `tipe`= 'page' AND `status_tulisan` = 'sampah' ORDER BY `tgl_tulisan` DESC";
		}
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			$tulisan_['error'] = 0;
			$string = "SELECT * FROM `tulisan` " . $cari;
			$tulisan = $this->crud->get(null, null, null, null, null, $string);
			$config['base_url'] = site_url('halaman/sampah/index/page');
			$config['total_rows'] = count($tulisan);
			$config['per_page'] = '10';
			$config['first_page'] = 'Awal';
			$config['last_page'] = 'Akhir';
			$config['next_page'] = '«';
			$config['prev_page'] = '»';
			$config['next_link'] = '&rarr;';
			$config['prev_link'] = '&larr;';
			$config['uri_segment'] = 5;
			$config['full_tag_open'] = '<ul class="pagination" style="margin:0px 7px;">';
			$this->pagination->initialize($config);
			$tulisan_['pagging'] = $this->pagination->create_links();
			if ($tulisan != null) {
				$tulisan_['total_rows'] = $config['total_rows'];
			} else {
				$tulisan_['total_rows'] = 0;
			}

			if ($this->uri->segment(5) != '') {
				$offset = $this->uri->segment(5);
			} else {
				$offset = 0;
			}
			$string_2 = "SELECT * FROM `tulisan` " . $cari . " limit " . $offset . "," . $config['per_page'];
			$tulisan_['tulisan'] = $this->crud->get(null, null, null, null, null, $string_2);
			$tulisan_['no'] = $offset;
			$tulisan_['total_rows_2'] = $this->crud->get(null, null, null, null, null, "SELECT count(`id_tulisan`) as `total` FROM `tulisan` WHERE `tipe`= 'page' AND `status_tulisan` != 'sampah' ORDER BY `tgl_tulisan` DESC");
		} else {
			$tulisan_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $tulisan_;
	}

	function sembunyikan()
	{
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			$data = array(
				'status_tulisan' => 'menunggu'
			);
			$where = array(
				array(
					'where_field' => 'id_tulisan',
					'where_key' => $this->uri->segment(3)
				)
			);
			$this->crud->update($table_name, $data, $where);
			$data['psn'] = 'Halaman berhasil disembunyikan';
			$data['wrng'] = 'success';
		} else {
			$data['psn'] = 'Tabel ' . $table_name . ' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function tampilkan()
	{
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			$data = array(
				'status_tulisan' => 'terbit'
			);
			$where = array(
				array(
					'where_field' => 'id_tulisan',
					'where_key' => $this->uri->segment(3)
				)
			);
			$this->crud->update($table_name, $data, $where);
			$data['psn'] = 'Halaman berhasil ditampilkan';
			$data['wrng'] = 'success';
		} else {
			$data['psn'] = 'Tabel ' . $table_name . ' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function kembalikan()
	{
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			$data = array(
				'status_tulisan' => 'menunggu'
			);
			$where = array(
				array(
					'where_field' => 'id_tulisan',
					'where_key' => $this->uri->segment(3)
				)
			);
			$this->crud->update($table_name, $data, $where);
			$data['psn'] = 'Halaman berhasil dikembalikan';
			$data['wrng'] = 'success';
		} else {
			$data['psn'] = 'Tabel ' . $table_name . ' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}
}
/* End of file halaman.php */
/* Location: ./application/controllers/halaman.php */