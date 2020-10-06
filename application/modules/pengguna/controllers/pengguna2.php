<?php

class Pengguna extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('crud');
		//$this->load->library('Loginaut');
	}

	function index(){
		$this->semua_pengguna();
	}

	function semua_pengguna(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'lihat semua',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		if($this->uri->segment(2)==''){
			$data['psn']['status_pengguna_']='aktif';
			$data['psn']['level_']='';
			$this->session->set_userdata($data['psn']);
		}
		$data['site']=$this->web();
		$data['site']['page']='Semua Pengguna';
		$data['modules']='pengguna';
		$data['content']='v_semua_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function administrator(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'lihat administrator',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		if($this->uri->segment(2)=='administrator'){
			$data['psn']['status_pengguna_']='aktif';
			$data['psn']['level_']='administrator';
			$this->session->set_userdata($data['psn']);
		}
		$data['site']=$this->web();
		$data['site']['page']='Pengguna Administrator';
		$data['modules']='pengguna';
		$data['content']='v_semua_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function editor(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'lihat editor',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		if($this->uri->segment(2)=='editor'){
			$data['psn']['status_pengguna_']='aktif';
			$data['psn']['level_']='editor';
			$this->session->set_userdata($data['psn']);
		}
		$data['site']=$this->web();
		$data['site']['page']='Pengguna Editor';
		$data['modules']='pengguna';
		$data['content']='v_semua_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function user(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'lihat user',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		if($this->uri->segment(2)=='user'){
			$data['psn']['status_pengguna_']='aktif';
			$data['psn']['level_']='user';
			$this->session->set_userdata($data['psn']);
		}
		$data['site']=$this->web();
		$data['site']['page']='Pengguna User';
		$data['modules']='pengguna';
		$data['content']='v_semua_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function block(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'lihat block',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		if($this->uri->segment(2)=='block'){
			$data['psn']['status_pengguna_']='block';
			$data['psn']['level_']='';
			$this->session->set_userdata($data['psn']);
		}
		$data['site']=$this->web();
		$data['site']['page']='Pengguna Block';
		$data['modules']='pengguna';
		$data['content']='v_semua_pengguna';
		$this->load->view('../../template/template', $data);
	}

	function baru(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'tambah baru',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['site']=$this->web();
		$data['site']['page']='Tambah Pengguna Baru';
		$data['sunting'] = 'false';
		$data['modules']='pengguna';
		$data['content']='v_pengguna_baru';
		$this->load->view('../../template/template', $data);
	}

	function sunting(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		if($this->input->get('id')!=''){
			$data['psn']['sunting']='true';
			$this->session->set_userdata($data['psn']);

			$data['pengguna']=null;
			$pengguna = null;
			$pengguna = $this->pengguna(null,$this->input->get('id'));
			if(isset($pengguna['pengguna'][0])){
				$data['pengguna'] = $pengguna['pengguna'][0];
				$data['sunting'] = 'true';
			}
			
			$data['site']=$this->web();
			$data['site']['page']='Sunting Pengguna';

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'sunting:'.$this->input->get('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

			$data['modules']='pengguna';
			$data['content']='v_pengguna_baru';
			$this->load->view('../../template/template', $data);
		}else{
			redirect('errors');
		}
	}

	function profil(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('errors');
		}
		if($this->session->userdata('id_pengguna')!=''){
			$data['psn']['sunting']='true';
			$this->session->set_userdata($data['psn']);

			$data['pengguna']=null;
			$pengguna = null;
			$pengguna = $this->pengguna(null,$this->session->userdata('id_pengguna'));
			if(isset($pengguna['pengguna'][0])){
				$data['pengguna'] = $pengguna['pengguna'][0];
				$data['sunting'] = 'true';
			}
			
			$data['site']=$this->web();
			$data['site']['page']='Sunting Pengguna';

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'sunting:'.$this->session->userdata('id_pengguna'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

			$data['modules']='pengguna';
			$data['content']='v_pengguna_baru';
			$this->load->view('../../template/template', $data);
		}else{
			redirect('errors');
		}
	}

	function addpengguna(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('errors');
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
					$data['psn'] = 'Pengguna berhasil disimpan';
					$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Pengguna gagal disimpan';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'tambah pengguna:'.$this->input->post('username'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		redirect('pengguna');
	}

	function getpengguna(){
		$data['data'] = null;
		$data['data'] = $this->pengguna();
		echo json_encode($data);
	}

	function blockpengguna(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$data=array(
	            		'status_pengguna'=>'block'
	            	);
	            	$where=array(
	            		array(
	            			'where_field'=>'id_pengguna',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->update($table_name,$data,$where);
	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	$data['psn'] = 'Pengguna berhasil diblock';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Pengguna gagal diblock';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'block pengguna:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->pengguna();
		echo json_encode($data);
	}

	function blockpenggunamassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id_hapus_pengguna_massal_', 'id_hapus_pengguna_massal_', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('id_hapus_pengguna_massal_');
	            	foreach($id as $id_){
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
		            }
	            	$data['psn'] = 'Pengguna berhasil diblock';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Pengguna gagal diblock';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'block pengguna massal',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['data'] = $this->pengguna();
		echo json_encode($data);
	}

	function aktifkanpengguna(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$data=array(
	            		'status_pengguna'=>'aktif'
	            	);
	            	$where=array(
	            		array(
	            			'where_field'=>'id_pengguna',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->update($table_name,$data,$where);
	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	$data['psn'] = 'Pengguna berhasil diaktifkan';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Pengguna gagal diaktifkan';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'aktifkan pengguna:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->pengguna();
		echo json_encode($data);
	}

	function aktifkanpenggunamassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id_hapus_pengguna_massal_', 'id_hapus_pengguna_massal_', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('id_hapus_pengguna_massal_');
	            	foreach($id as $id_){
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
	            	$data['psn'] = 'Pengguna berhasil diaktifkan';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Pengguna gagal diaktifkan';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'aktifkan pengguna massal',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['data'] = $this->pengguna();
		echo json_encode($data);
	}

	function delpenggunamassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='pengguna';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id_hapus_pengguna_massal_', 'id_hapus_pengguna_massal_', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('id_hapus_pengguna_massal_');
	            	foreach($id as $id_){
		            	$where=array(
		            		array(
		            			'where_field'=>'id_pengguna',
		            			'where_key'=>$id_
		            		)
		            	);
		            	$this->crud->delete($table_name,$where);
		            }
	            	$data['psn'] = 'Pengguna berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Pengguna gagal dihapus';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'hapus pengguna massal',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['data'] = $this->pengguna();
		echo json_encode($data);
	}

	function delpengguna(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
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
	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	$data['psn'] = 'Pengguna berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Pengguna gagal dihapus';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'pengguna',
				'status_log'=>'hapus pengguna:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->pengguna();
		echo json_encode($data);
	}

	function checkusername(){
		$data['check'] = null;
		$check = null;
		$string = "SELECT * FROM `pengguna` WHERE `username`='".$this->input->post('username')."'";
		$check = $this->crud->get(null,null,null,null,null,$string);
		if($check!=null){
			$data['check'] = $check[0];
		}
		echo json_encode($data);
	}

	function pengguna($cari=null,$id=null,$id_lev=null){
		if($this->input->post('pagging')){
			$limit='limit '.$this->input->post('pagging');
		}else{
			$limit='';
		}
		if($this->input->post('cari_pengguna')==''){
			$cari=null;
		}else{
			$cari=$this->input->post('cari_pengguna');
		}
		if($this->input->post('id_level')=='0'){
			$id_lev=null;
		}else{
			$id_lev=$this->input->post('id_level');
		}
		$pengguna_['pengguna']=null;
		$table_name = 'pengguna';
		$status_pengguna=null;
		$status_pengguna_=null;
		if($this->session->userdata('status_pengguna_')=='aktif'){
			$status_pengguna = " WHERE `status_pengguna`='aktif'";
			$status_pengguna_ = " AND `status_pengguna`='aktif'";
		}else if($this->session->userdata('status_pengguna_')=='block'){
			$status_pengguna = " WHERE `status_pengguna`='block'";
			$status_pengguna_ = " AND `status_pengguna`='block'";
		}else{
			$status_pengguna = " WHERE `status_pengguna`!='block'";
			$status_pengguna_ = " AND `status_pengguna`!='block'";
		}

		if($this->session->userdata('level_')=='administrator'){
			$level_ = " AND `level`='administrator'";
		}else if($this->session->userdata('level_')=='editor'){
			$level_ = " AND `level`='editor'";
		}else if($this->session->userdata('level_')=='user'){
			$level_ = " AND `level`='user'";
		}else{
			$level_ = "";
		}
		if($this->db->table_exists($table_name)){
			$pengguna_['error']=0;
			$pengguna_['pengguna']=null;
			if($id_lev==null or $id_lev=='0'){
				if($id!=null){
					$string = "SELECT * FROM `pengguna` WHERE `id_pengguna`=".$id.$status_pengguna_.$level_." ORDER BY `tgl_bergabung` ASC ".$limit;
				}else if($cari!=null or $cari!=''){
					$string = "SELECT * FROM `pengguna` WHERE ((`nm_dp` LIKE '%".$cari."%') or (`nm_blk` LIKE '%".$cari."%') or (`username` LIKE '%".$cari."%')) ".$status_pengguna_.$level_." ORDER BY `tgl_bergabung` ASC ".$limit;
				}else{
					$string = "SELECT * FROM `pengguna` ".$status_pengguna.$level_." ORDER BY `tgl_bergabung` ASC ".$limit;
				}
			}else{
				if($id!=null){
					$string = "SELECT * FROM `pengguna` WHERE `id_pengguna`=".$id.$status_pengguna_." AND `level`='".$id_lev."'".$level_." ORDER BY `tgl_bergabung` ASC ".$limit;
				}else if($cari!=null or $cari!=''){
					$string = "SELECT * FROM `pengguna` WHERE ((`nm_dp` LIKE '%".$cari."%') or (`nm_blk` LIKE '%".$cari."%') or (`username` LIKE '%".$cari."%')) AND `level`='".$id_lev."'".$level_."".$status_pengguna_." ORDER BY `tgl_bergabung` ASC ".$limit;
				}else{
					$string = "SELECT * FROM `pengguna` WHERE `level`='".$id_lev."'".$level_."".$status_pengguna_." ORDER BY `tgl_bergabung` ASC ".$limit;
				}
			}
			$pengguna_['pengguna'] = $this->crud->get(null,null,null,null,null,$string);
			if($pengguna_['pengguna']==null){
				$pengguna_['error']='Pengguna tidak ada';
			}else{
				foreach($pengguna_['pengguna'] as $row){
					if($this->db->table_exists('tulisan')){
						$jml_tul = null;
						$string_ = "SELECT * FROM `tulisan` WHERE `penulis`=".$row['id_pengguna'];
						$jml_tul = $this->crud->get(null,null,null,null,null,$string_);
						if($jml_tul!=null){
							$pengguna_['jml_tul'][$row['id_pengguna']]=count($jml_tul);
						}else{
							$pengguna_['jml_tul'][$row['id_pengguna']]=0;
						}
					}
				}
			}
		}else{
			$pengguna_['error']='Tabel '.$table_name.' tidak ada!';
		}
		$pengguna_['tab_action']=$this->countpengguna();
		//$pengguna_['string']=$string;
		return $pengguna_;
	}

	function countpengguna(){
		$pengguna_['semua']=null;
		$pengguna_['user']=null;
		$pengguna_['administrator']=null;
		$pengguna_['block']=null;
		if($this->db->table_exists('pengguna')){
			$string = "SELECT * FROM `pengguna` WHERE `status_pengguna`!='block'";
			$pengguna_['semua']=$this->crud->get(null,null,null,null,null,$string);
			if($pengguna_['semua']!=null){
				$pengguna_['semua']=count($pengguna_['semua']);
			}else{
				$pengguna_['semua']=0;
			}

			$string_ = "SELECT * FROM `pengguna` WHERE `status_pengguna`!='block' AND `level`='administrator'";
			$pengguna_['administrator']=$this->crud->get(null,null,null,null,null,$string_);
			if($pengguna_['administrator']!=null){
				$pengguna_['administrator']=count($pengguna_['administrator']);
			}else{
				$pengguna_['administrator']=0;
			}

			$string_ = "SELECT * FROM `pengguna` WHERE `status_pengguna`!='block' AND `level`='editor'";
			$pengguna_['editor']=$this->crud->get(null,null,null,null,null,$string_);
			if($pengguna_['editor']!=null){
				$pengguna_['editor']=count($pengguna_['editor']);
			}else{
				$pengguna_['editor']=0;
			}

			$string_ = "SELECT * FROM `pengguna` WHERE `status_pengguna`!='block' AND `level`='user'";
			$pengguna_['user']=$this->crud->get(null,null,null,null,null,$string_);
			if($pengguna_['user']!=null){
				$pengguna_['user']=count($pengguna_['user']);
			}else{
				$pengguna_['user']=0;
			}

			$string_ = "SELECT * FROM `pengguna` WHERE `status_pengguna`='block'";
			$pengguna_['block']=$this->crud->get(null,null,null,null,null,$string_);
			if($pengguna_['block']!=null){
				$pengguna_['block']=count($pengguna_['block']);
			}else{
				$pengguna_['block']=0;
			}
		}

		return $pengguna_;
	}

	function gambarprofil(){
		$data['gambarandalan'] = $this->input->post('gambar_andalan');
		echo json_encode($data);
	}

	function web(){
		$web_['web']=null;
		$table_name = 'web';
		if($this->db->table_exists($table_name)){
			$web_['error']=0;
			$string = "SELECT * FROM `web`";
			$data = $this->crud->get(null,null,null,null,null,$string);
			if($data==null){
				$web_['error']='web tidak ada!';
			}else{
				foreach($data as $row){
					$web_['web'][$row['option_name']]=$row['option_value'];
				}
			}
		}else{
			$web_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $web_;
	}
}

/* End of file pengguna.php */
/* Location: ./application/controllers/pengguna.php */