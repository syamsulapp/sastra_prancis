<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Pengguna extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('crud');
		$this->setting = new Setting();
	}

	function index(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Semua Pengguna';
		$data['data']			= $this->semua();
		$data['modules']		='pengguna';
		$data['content']		='v_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function semua(){
		$pengguna_['pengguna']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_pengguna` != 'block' AND (`username` LIKE '%".$_GET['cari']."%' OR `email` LIKE '%".$_GET['cari']."%' OR `nm_dp` LIKE '%".$_GET['cari']."%' OR `nm_blk` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_bergabung` DESC";
		}else{
			$cari = "WHERE `status_pengguna` != 'block' ORDER BY `tgl_bergabung` DESC";
		}
		$table_name = 'pengguna';
		if($this->db->table_exists($table_name)){
			$pengguna_['error']=0;
			$string = "SELECT * FROM `pengguna` ".$cari;
			$pengguna = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('pengguna/pengguna/index/page');
			$config['total_rows'] = count($pengguna);
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
			$pengguna_['pagging'] = $this->pagination->create_links();
			if($pengguna!=null){
				$pengguna_['total_rows'] = $config['total_rows'];
			}else{
				$pengguna_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `pengguna` ".$cari." limit ".$offset.",".$config['per_page'];
			$pengguna_['pengguna'] = $this->crud->get(null,null,null,null,null,$string_2);
			$pengguna_['no'] = $offset;
			$pengguna_['total_rows_1'][0]['total'] = $pengguna_['total_rows'];
			$pengguna_['total_rows_2'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'administrator' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_3'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'editor' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_4'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'user' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_5'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `status_pengguna` = 'block' ORDER BY `tgl_bergabung` DESC");
		}else{
			$pengguna_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $pengguna_;
	}

	function administrator(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Pengguna Administrator';
		$data['data']			= $this->pengguna_administrator();
		$data['modules']		='pengguna';
		$data['content']		='v_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function pengguna_administrator(){
		$pengguna_['pengguna']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_pengguna` != 'block' AND `level`='administrator' AND (`username` LIKE '%".$_GET['cari']."%' OR `email` LIKE '%".$_GET['cari']."%' OR `nm_dp` LIKE '%".$_GET['cari']."%' OR `nm_blk` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_bergabung` DESC";
		}else{
			$cari = "WHERE `status_pengguna` != 'block' AND `level`='administrator' ORDER BY `tgl_bergabung` DESC";
		}
		$table_name = 'pengguna';
		if($this->db->table_exists($table_name)){
			$pengguna_['error']=0;
			$string = "SELECT * FROM `pengguna` ".$cari;
			$pengguna = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('pengguna/administrator/index/page');
			$config['total_rows'] = count($pengguna);
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
			$pengguna_['pagging'] = $this->pagination->create_links();
			if($pengguna!=null){
				$pengguna_['total_rows'] = $config['total_rows'];
			}else{
				$pengguna_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `pengguna` ".$cari." limit ".$offset.",".$config['per_page'];
			$pengguna_['pengguna'] = $this->crud->get(null,null,null,null,null,$string_2);
			$pengguna_['no'] = $offset;
			$pengguna_['total_rows_2'][0]['total'] = $pengguna_['total_rows'];
			$pengguna_['total_rows_1'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_3'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'editor' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_4'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'user' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_5'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `status_pengguna` = 'block' ORDER BY `tgl_bergabung` DESC");
		}else{
			$pengguna_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $pengguna_;
	}

	function editor(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Pengguna Editor';
		$data['data']			= $this->pengguna_editor();
		$data['modules']		='pengguna';
		$data['content']		='v_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function pengguna_editor(){
		$pengguna_['pengguna']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_pengguna` != 'block' AND `level`='editor' AND (`username` LIKE '%".$_GET['cari']."%' OR `email` LIKE '%".$_GET['cari']."%' OR `nm_dp` LIKE '%".$_GET['cari']."%' OR `nm_blk` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_bergabung` DESC";
		}else{
			$cari = "WHERE `status_pengguna` != 'block' AND `level`='editor' ORDER BY `tgl_bergabung` DESC";
		}
		$table_name = 'pengguna';
		if($this->db->table_exists($table_name)){
			$pengguna_['error']=0;
			$string = "SELECT * FROM `pengguna` ".$cari;
			$pengguna = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('pengguna/editor/index/page');
			$config['total_rows'] = count($pengguna);
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
			$pengguna_['pagging'] = $this->pagination->create_links();
			if($pengguna!=null){
				$pengguna_['total_rows'] = $config['total_rows'];
			}else{
				$pengguna_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `pengguna` ".$cari." limit ".$offset.",".$config['per_page'];
			$pengguna_['pengguna'] = $this->crud->get(null,null,null,null,null,$string_2);
			$pengguna_['no'] = $offset;
			$pengguna_['total_rows_3'][0]['total'] = $pengguna_['total_rows'];
			$pengguna_['total_rows_1'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_2'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'administrator' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_4'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'user' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_5'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `status_pengguna` = 'block' ORDER BY `tgl_bergabung` DESC");
		}else{
			$pengguna_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $pengguna_;
	}

	function user(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Pengguna User';
		$data['data']			= $this->pengguna_user();
		$data['modules']		='pengguna';
		$data['content']		='v_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function pengguna_user(){
		$pengguna_['pengguna']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_pengguna` != 'block' AND `level`='user' AND (`username` LIKE '%".$_GET['cari']."%' OR `email` LIKE '%".$_GET['cari']."%' OR `nm_dp` LIKE '%".$_GET['cari']."%' OR `nm_blk` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_bergabung` DESC";
		}else{
			$cari = "WHERE `status_pengguna` != 'block' AND `level`='user' ORDER BY `tgl_bergabung` DESC";
		}
		$table_name = 'pengguna';
		if($this->db->table_exists($table_name)){
			$pengguna_['error']=0;
			$string = "SELECT * FROM `pengguna` ".$cari;
			$pengguna = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('pengguna/user/index/page');
			$config['total_rows'] = count($pengguna);
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
			$pengguna_['pagging'] = $this->pagination->create_links();
			if($pengguna!=null){
				$pengguna_['total_rows'] = $config['total_rows'];
			}else{
				$pengguna_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `pengguna` ".$cari." limit ".$offset.",".$config['per_page'];
			$pengguna_['pengguna'] = $this->crud->get(null,null,null,null,null,$string_2);
			$pengguna_['no'] = $offset;
			$pengguna_['total_rows_4'][0]['total'] = $pengguna_['total_rows'];
			$pengguna_['total_rows_1'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_2'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'administrator' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_3'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'editor' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_5'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `status_pengguna` = 'block' ORDER BY `tgl_bergabung` DESC");
		}else{
			$pengguna_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $pengguna_;
	}

	function block(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Pengguna Block';
		$data['data']			= $this->pengguna_block();
		$data['modules']		='pengguna';
		$data['content']		='v_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function pengguna_block(){
		$pengguna_['pengguna']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_pengguna` = 'block' AND (`username` LIKE '%".$_GET['cari']."%' OR `email` LIKE '%".$_GET['cari']."%' OR `nm_dp` LIKE '%".$_GET['cari']."%' OR `nm_blk` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_bergabung` DESC";
		}else{
			$cari = "WHERE `status_pengguna` = 'block' ORDER BY `tgl_bergabung` DESC";
		}
		$table_name = 'pengguna';
		if($this->db->table_exists($table_name)){
			$pengguna_['error']=0;
			$string = "SELECT * FROM `pengguna` ".$cari;
			$pengguna = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('pengguna/block/index/page');
			$config['total_rows'] = count($pengguna);
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
			$pengguna_['pagging'] = $this->pagination->create_links();
			if($pengguna!=null){
				$pengguna_['total_rows'] = $config['total_rows'];
			}else{
				$pengguna_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `pengguna` ".$cari." limit ".$offset.",".$config['per_page'];
			$pengguna_['pengguna'] = $this->crud->get(null,null,null,null,null,$string_2);
			$pengguna_['no'] = $offset;
			$pengguna_['total_rows_5'][0]['total'] = $pengguna_['total_rows'];
			$pengguna_['total_rows_1'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_2'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'administrator' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_3'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'editor' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
			$pengguna_['total_rows_4'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_pengguna`) as `total` FROM `pengguna` WHERE `level` = 'user' AND `status_pengguna` = 'aktif' ORDER BY `tgl_bergabung` DESC");
		}else{
			$pengguna_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $pengguna_;
	}

	function baru(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Tambah Pengguna Baru';
		$data['sunting'] = 'false';
		$data['modules']='pengguna';
		$data['content']='v_pengguna_baru';
		$this->load->view('../../template/template', $data);
	}

	function sunting(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		if($this->input->get('id')!=''){
			$data['pengguna']=null;
			$pengguna = null;
			$data = $this->setting->get_jml();
			$pengguna = $this->crud->get('pengguna',array(array('where_field'=>'id_pengguna','where_key'=>$this->input->get('id'))));
			if(isset($pengguna[0])){
				$data['pengguna'] = $pengguna[0];
				$data['sunting'] = 'true';
			};
			$data['site']=$this->setting->web();
			$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
			$data['site']['page']='Sunting Pengguna';
			$data['modules']='pengguna';
			$data['content']='v_pengguna_baru';
			$this->load->view('../../template/template', $data);
		}else{
			redirect('home/errors');
		}
	}

	function profil(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		if($this->session->userdata('id_pengguna')!=''){
			$data = $this->setting->get_jml();
			$data['pengguna']=null;
			$pengguna = null;
			$pengguna = $this->crud->get('pengguna',array(array('where_field'=>'id_pengguna','where_key'=>$this->session->userdata('id_pengguna'))));
			if(isset($pengguna[0])){
				$data['pengguna'] = $pengguna[0];
				$data['sunting'] = 'true';
			}
			$data['site']=$this->setting->web();
			$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
			$data['site']['page']='Sunting Profil';
			$data['modules']='pengguna';
			$data['content']='v_pengguna_baru';
			$this->load->view('../../template/template', $data);
		}else{
			redirect('home/errors');
		}
	}

	function addpengguna(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('username', 'username', 'required');
	            if ($this->form_validation->run()){
			    	if($this->input->post('id_pengguna')==''){
						$data_ = array(
				    		'username'=>$this->input->post('username'),
				    		'password'=>md5($this->input->post('password')),
				    		'level'=>$this->input->post('level'),
							'email'=>$this->input->post('email'),
							'nm_dp'=>$this->input->post('nm_dp'),
							'nm_blk'=>$this->input->post('nm_blk'),
							'web'=>$this->input->post('web'),
							'tgl_bergabung'=>date('Y-m-d H:i:s'),
							'foto'=>$this->input->post('foto')
						);
						$this->crud->insert($table_name,$data_);
					}else{
						if($this->input->post('password')==''){
							$data__ = array(
					    		'level'=>$this->input->post('level'),
								'email'=>$this->input->post('email'),
								'nm_dp'=>$this->input->post('nm_dp'),
								'nm_blk'=>$this->input->post('nm_blk'),
								'web'=>$this->input->post('web'),
								'foto'=>$this->input->post('foto')
							);
						}else{
							$data__ = array(
					    		'password'=>md5($this->input->post('password')),
					    		'level'=>$this->input->post('level'),
								'email'=>$this->input->post('email'),
								'nm_dp'=>$this->input->post('nm_dp'),
								'nm_blk'=>$this->input->post('nm_blk'),
								'web'=>$this->input->post('web'),
								'foto'=>$this->input->post('foto')
							);
						}
						$where=array(
							array(
								'where_field'=>'id_pengguna',
								'where_key'=>$this->input->post('id_pengguna')
							)
						);
						$this->crud->update($table_name,$data__,$where);
					}
					$this->session->set_flashdata('success','Pengguna berhasil disimpan');
	            }else{
					$this->session->set_flashdata('warning','Pengguna gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}

		redirect('pengguna');
	}

	function sembunyikan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_pengguna'=>'block'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_pengguna',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Pengguna berhasil diblock';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function tampilkan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_pengguna'=>'aktif'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_pengguna',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Pengguna berhasil diaktifkan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function delpengguna(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
		        	$where=array(
		        		array(
		        			'where_field'=>'id_pengguna',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','pengguna berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','pengguna gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('pengguna/pengguna');
	}
	function delpenggunamassal(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps_p' or $this->input->post('aksi_tindakan_massal_bawah')=='hps_p'){
				        	$where=array(
				        		array(
				        			'where_field'=>'id_pengguna',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->delete($table_name,$where);
			            }else if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$data=array(
			            		'status_pengguna'=>'block'
			            	);
			            	$where=array(
				        		array(
				        			'where_field'=>'id_pengguna',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }else if($this->input->post('aksi_tindakan_massal_atas')=='kmbl' or $this->input->post('aksi_tindakan_massal_bawah')=='kmbl'){
			            	$data=array(
			            		'status_pengguna'=>'aktif'
			            	);
			            	$where=array(
				        		array(
				        			'where_field'=>'id_pengguna',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','pengguna berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','pengguna gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('pengguna/pengguna');
	}
}

/* End of file pengguna.php */
/* Location: ./application/controllers/pengguna.php */