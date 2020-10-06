<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Tulisan extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
		$this->nm_app = 'cms_kutim';
		if($this->session->userdata('id')==''){
			$ses['id'] = 'all';
			$this->session->set_userdata($ses);
		}
	}
	function index(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		if(@$_GET['id']&&($_GET['id']!='all'||$_GET['id']!='')){
			$ses['id'] = $_GET['id'];
			$this->session->set_userdata($ses);
		}
		$data = $this->setting->get_jml();
		$data['site'] = $this->setting->web();
		$data['lbl'] = $this->label();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Daftar Tulisan';
		$data['data'] = $this->tulisan();
		$data['modules']='tulisan';
		$data['content']='v_tulisan';
		$this->load->view('../../template/template', $data);
	}
	function sampah(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		if(@$_GET['id']&&($_GET['id']!='all'||$_GET['id']!='')){
			$ses['id'] = $_GET['id'];
			$this->session->set_userdata($ses);
		}
		$data = $this->setting->get_jml();
		$data['site'] = $this->setting->web();
		$data['lbl'] = $this->label();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Sampah Tulisan';
		$data['data'] = $this->tulisan_sampah();
		$data['modules']='tulisan';
		$data['content']='v_tulisan_sampah';
		$this->load->view('../../template/template', $data);
	}

	function label(){
		$label = null;
		$string = "SELECT * FROM `kategori`  WHERE `tipe_kategori`='label'";
		$label = $this->crud->get(null,null,null,null,null,$string);
		return $label;
	}

	function baru(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Tambah Tulisan Baru';
		$data['modules']='tulisan';
		$data['content']='v_tulisan_baru';
		$this->load->view('../../template/template', $data);
	}
	function sunting(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		
		if($this->input->get('id')!=''){
			$data = $this->setting->get_jml();
			$tulisan = null;
			$data['psn']['sunting']='true';
			$this->session->set_userdata($data['psn']);

			$data['tulisan']=null;
			$tulisan = null;
			$tulisan = $this->crud->get('tulisan',array(array('where_field'=>'id_tulisan','where_key'=>$this->input->get('id'))));
			if($tulisan!=null&&isset($tulisan[0]['penulis'])&&($tulisan[0]['penulis']==$this->session->userdata('id_pengguna'))or($this->session->userdata('level')=='administrator')or($this->session->userdata('level')=='editor')){
				if(isset($tulisan[0])){
					$data['tulisan'] = $tulisan[0];
					$string = "SELECT * FROM `hub_kat_tul` JOIN `kategori` ON `kategori`.`id_kategori`=`hub_kat_tul`.`id_kat` WHERE `hub_kat_tul`.`id_tul`=".$this->input->get('id');
					$data['kategori'] = $this->crud->get(null,null,null,null,null,$string);
					$string2 = "SELECT * FROM `file` WHERE `id_tulisan`=".$this->input->get('id');
					$data['file'] = $this->crud->get(null,null,null,null,null,$string2);
					$data['sunting'] = 'true';
				}
				$data['site']=$this->setting->web();
				$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
				$data['site']['page']='Sunting Tulisan';
				$data['modules']='tulisan';
				$data['content']='v_tulisan_baru';
				$this->load->view('../../template/template', $data);
			}else{
				redirect('tulisan');
			}
		}else{
			redirect('tulisan');
		}
	}
	function addtulisan(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='tulisan';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('nama_tulisan_id', 'nama_tulisan_id', 'required');
	            if ($this->form_validation->run()){
	            	if($this->session->userdata('id_pengguna')!=''){
	            		$penulis = $this->session->userdata('id_pengguna');
	            	}else{
	            		$penulis = '1';
	            	}
					if($this->input->post('id_tulisan')==''){
						$data = array(
							'judul_id'=>$this->input->post('nama_tulisan_id'),
							'tulisan_id'=>str_replace('src="/'.$this->nm_app.'/','src="'.base_url(),$this->input->post('tulisan_id')),
							'judul_eng'=>($this->input->post('nama_tulisan_eng')!='')?$this->input->post('nama_tulisan_eng'):$this->input->post('nama_tulisan_id'),
							'tulisan_eng'=>str_replace('src="/'.$this->nm_app.'/','src="'.base_url(),$this->input->post('tulisan_eng')),
							'judul_ae'=>($this->input->post('nama_tulisan_ae')!='')?$this->input->post('nama_tulisan_ae'):$this->input->post('nama_tulisan_id'),
							'tulisan_ae'=>str_replace('src="/'.$this->nm_app.'/','src="'.base_url(),$this->input->post('tulisan_ae')),
							'gambar_andalan'=>$this->input->post('gambar_andalan'),
							'status_komentar'=>$this->input->post('status_komentar_tulisan'),
							'tgl_tulisan'=>$this->input->post('tgl_tulisan'),
							'tipe'=>$this->input->post('format_tulisan'),
							'status_tulisan'=>'menunggu',
							'lokasi'=>$this->input->post('lokasi'),
							'email2'=>$this->input->post('email2'),
							'map'=>$this->input->post('map'),
							'tgl_mulai'=>$this->input->post('tgl_mulai'),
							'tgl_selesai'=>$this->input->post('tgl_selesai'),
							'latitude'=>$this->input->post('latitude'),
							'longitude'=>$this->input->post('longitude'),
							'penulis'=>$penulis
						);
						$this->crud->insert($table_name,$data);
						$id_tul = $this->db->insert_id();
					}else{
						$data = array(
							'judul_id'=>$this->input->post('nama_tulisan_id'),
							'tulisan_id'=>str_replace('src="/'.$this->nm_app.'/','src="'.base_url(),$this->input->post('tulisan_id')),
							'judul_eng'=>($this->input->post('nama_tulisan_eng')!='')?$this->input->post('nama_tulisan_eng'):$this->input->post('nama_tulisan_id'),
							'tulisan_eng'=>str_replace('src="/'.$this->nm_app.'/','src="'.base_url(),$this->input->post('tulisan_eng')),
							'judul_ae'=>($this->input->post('nama_tulisan_ae')!='')?$this->input->post('nama_tulisan_ae'):$this->input->post('nama_tulisan_id'),
							'tulisan_ae'=>str_replace('src="/'.$this->nm_app.'/','src="'.base_url(),$this->input->post('tulisan_ae')),
							'gambar_andalan'=>$this->input->post('gambar_andalan'),
							'status_komentar'=>$this->input->post('status_komentar_tulisan'),
							'tgl_tulisan'=>$this->input->post('tgl_tulisan'),
							'tipe'=>$this->input->post('format_tulisan'),
							'lokasi'=>$this->input->post('lokasi'),
							'email2'=>$this->input->post('email2'),
							'map'=>$this->input->post('map'),
							'tgl_mulai'=>$this->input->post('tgl_mulai'),
							'tgl_selesai'=>$this->input->post('tgl_selesai'),
							'latitude'=>$this->input->post('latitude'),
							'longitude'=>$this->input->post('longitude')
						);
						$where=array(
							array(
								'where_field'=>'id_tulisan',
								'where_key'=>$this->input->post('id_tulisan')
							)
						);
						$this->crud->update($table_name,$data,$where);
						$id_tul = $this->input->post('id_tulisan');
					}
					$id_kat = null;
					$id_kat = $this->input->post('checkbox_kat');
					if($this->db->table_exists('hub_kat_tul')){
						$where_=array(
							array(
								'where_field'=>'id_tul',
								'where_key'=>$id_tul
							)
						);
						$this->crud->delete('hub_kat_tul',$where_);
					}
					if($id_kat!=null){
						foreach($id_kat as $id){
							$data = array(
								'id_tul'=>$id_tul,
								'id_kat'=>$id
							);
							if($this->db->table_exists('hub_kat_tul')){
								$this->crud->insert('hub_kat_tul',$data);
							}
						}
					}

					$path = dirname(__FILE__)."/../../../../assets/file";
					if((file_exists($path))&&(is_dir($path))){
						$config['upload_path'] = "./assets/file";
						$config['allowed_types'] = 'pdf|doc|xls|docx|xlsx|jpg|jpeg|gif|png';
						$config['max_size'] = '50240';
						$config['max_width']  = '2400';
						$config['max_height']  = '1600';
						$config['overwrite'] = TRUE;
						$config['encrypt_name'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$this->load->library('upload', $config);
						$_FILES['file_0']=null;
						foreach($_FILES['file_lampiran'] as $key=>$val){
							$i = 1;
							foreach($val as $v){
								$field_name = "file".$i;
								$_FILES[$field_name][$key] = $v;
								$i++;
							}
						}
						unset($_FILES['file_lampiran']);
						$error = array();
						$success = array();
						foreach($_FILES as $field_name => $file){
							if ( ! $this->upload->do_upload($field_name)){
								$error[] = $this->upload->display_errors();
							}else{
								$success[] = $this->upload->data();
								if($this->db->table_exists('file')){
									$data__=array(
										'id_user'=>$penulis,
										'id_tulisan'=>$id_tul,
										'file'=>str_replace(' ','_',$file['name']),
										'tgl_file'=>date('Y-m-d h:i:s')
									);
									$this->crud->insert('file',$data__);
								}
							}
						}
					}
					$this->session->set_flashdata('success','tulisan '.$this->input->post('tulisan').' berhasil disimpan');
				}else{
					$this->session->set_flashdata('warning','tulisan gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tulisan/tulisan');
	}
	function deltulisan(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='tulisan';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$data=array(
		        		'status_tulisan'=>'sampah'
		        	);
		        	$where=array(
		        		array(
		        			'where_field'=>'id_tulisan',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->update($table_name,$data,$where);
	            	$this->session->set_flashdata('success','tulisan berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','tulisan gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tulisan/tulisan');
	}
	function deltulisanmassal(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='tulisan';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$data=array(
				        		'status_tulisan'=>'sampah'
				        	);
				        	$where=array(
				        		array(
				        			'where_field'=>'id_tulisan',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','tulisan berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','tulisan gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tulisan/tulisan');
	}
	function deltulisanpermanen(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='tulisan';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
		        	$where=array(
		        		array(
		        			'where_field'=>'id_tulisan',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','tulisan berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','tulisan gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tulisan/sampah');
	}
	function deltulisanmassalpermanen(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='tulisan';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
				        	$where=array(
				        		array(
				        			'where_field'=>'id_tulisan',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->delete($table_name,$where);
			            }else if($this->input->post('aksi_tindakan_massal_atas')=='kmbl' or $this->input->post('aksi_tindakan_massal_bawah')=='kmbl'){
			            	$data=array(
				        		'status_tulisan'=>'menunggu'
				        	);
			            	$where=array(
				        		array(
				        			'where_field'=>'id_tulisan',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','tulisan berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','tulisan gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tulisan/sampah');
	}
	function tulisan(){
		$tulisan_['tulisan']=null;
		if($this->session->userdata('id')!='all'&&$this->session->userdata('id')!=''){
			$format = " AND `tipe`=".$this->session->userdata('id');
		}else{
			$format = "";
		}
		if(@$_GET['cari']!=''){
			$cari = "WHERE `tipe`!= 'page' AND `tipe`!= 'album' AND `status_tulisan` != 'sampah' AND (`judul_id` LIKE '%".$_GET['cari']."%' OR `tulisan_id` LIKE '%".$_GET['cari']."%' OR `judul_ae` LIKE '%".$_GET['cari']."%' OR `tulisan_ae` LIKE '%".$_GET['cari']."%' OR `judul_eng` LIKE '%".$_GET['cari']."%' OR `tulisan_eng` LIKE '%".$_GET['cari']."%') ".$format." ORDER BY `tgl_tulisan` DESC";
		}else{
			$cari = "WHERE `tipe`!= 'page' AND `tipe`!= 'album' AND `status_tulisan` != 'sampah' ".$format." ORDER BY `tgl_tulisan` DESC";
		}
		$table_name = 'tulisan';
		if($this->db->table_exists($table_name)){
			$tulisan_['error']=0;
			$string = "SELECT * FROM `tulisan` ".$cari;
			$tulisan = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('tulisan/tulisan/index/page');
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
			$tulisan_['total_rows'] = $config['total_rows'];

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}

			if($tulisan!=null){
				$config['total_rows'] = count($tulisan);
			}else{
				$config['total_rows'] = 0;
			}
			
			$string_2 = "SELECT * FROM `tulisan` JOIN `kategori` ON `tulisan`.`tipe`=`kategori`.`id_kategori` ".$cari." limit ".$offset.",".$config['per_page'];
			$tulisan_['tulisan'] = $this->crud->get(null,null,null,null,null,$string_2);
			$tulisan_['no'] = $offset;
			$tulisan_['total_rows_2'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_tulisan`) as `total` FROM `tulisan` WHERE `tipe` != 'page' AND `tipe` != 'album' AND `status_tulisan` = 'sampah' ORDER BY `tgl_tulisan` DESC");
		}else{
			$tulisan_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $tulisan_;
	}

	function tulisan_sampah(){
		$tulisan_['tulisan']=null;
		if($this->session->userdata('id')!='all'&&$this->session->userdata('id')!=''){
			$format = " AND `tipe`=".$this->session->userdata('id');
		}else{
			$format = "";
		}
		if(@$_GET['cari']!=''){
			$cari = "WHERE `tipe`!= 'page' AND `tipe`!= 'album' AND `status_tulisan` = 'sampah' AND (`judul_id` LIKE '%".$_GET['cari']."%' OR `tulisan_id` LIKE '%".$_GET['cari']."%' OR `judul_ae` LIKE '%".$_GET['cari']."%' OR `tulisan_ae` LIKE '%".$_GET['cari']."%' OR `judul_eng` LIKE '%".$_GET['cari']."%' OR `tulisan_eng` LIKE '%".$_GET['cari']."%') ".$format." ORDER BY `tgl_tulisan` DESC";
		}else{
			$cari = "WHERE `tipe`!= 'page' AND `tipe`!= 'album' AND `status_tulisan` = 'sampah' ".$format." ORDER BY `tgl_tulisan` DESC";
		}
		$table_name = 'tulisan';
		if($this->db->table_exists($table_name)){
			$tulisan_['error']=0;
			$string = "SELECT * FROM `tulisan` ".$cari;
			$tulisan = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('tulisan/sampah/index/page');
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
			$tulisan_['total_rows'] = $config['total_rows'];

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}

			if($tulisan!=null){
				$config['total_rows'] = count($tulisan);
			}else{
				$config['total_rows'] = 0;
			}

			$string_2 = "SELECT * FROM `tulisan` JOIN `kategori` ON `tulisan`.`tipe`=`kategori`.`id_kategori` ".$cari." limit ".$offset.",".$config['per_page'];
			$tulisan_['tulisan'] = $this->crud->get(null,null,null,null,null,$string_2);
			$tulisan_['no'] = $offset;
			$tulisan_['total_rows_2'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_tulisan`) as `total` FROM `tulisan` WHERE `tipe` != 'page' AND `tipe` != 'album' AND `status_tulisan` != 'sampah' ORDER BY `tgl_tulisan` DESC");
		}else{
			$tulisan_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $tulisan_;
	}

	function sembunyikan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='tulisan';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_tulisan'=>'menunggu'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_tulisan',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Tulisan berhasil disembunyikan';
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
		$table_name='tulisan';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_tulisan'=>'terbit'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_tulisan',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Tulisan berhasil ditampilkan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function kembalikan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='tulisan';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_tulisan'=>'menunggu'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_tulisan',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Tulisan berhasil dikembalikan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}


	//IMAGE

	function lihatgambarandalan(){
		$data['psn']['gambar']=null;
		$path = dirname(__FILE__)."/../../../../assets/img/img_andalan/thumb";
		if((file_exists($path))&&(is_dir($path))){
			$data['psn']['path']	=base_url('assets/img/img_andalan/thumb');
			$data_					=$this->lihatfolder($this->uri->segment(3));
			$data['psn']['gambar']	=$data_['gambar_andalan'];
			$total = $this->crud->get('gambar_andalan');
			if($this->uri->segment(3)==''or$this->uri->segment(3)==0){
				$data['psn']['tombol']	='<button onclick="prev()" class="btn btn-default disabled"><i class="fa fa-arrow-left"></i></button>
					<button onclick="next()" class="btn btn-default"><i class="fa fa-arrow-right"></i></button>';
			}else if($this->uri->segment(3)>=(count($total)-20)){
				$data['psn']['tombol']	='<button onclick="prev()" class="btn btn-default"><i class="fa fa-arrow-left"></i></button>
					<button onclick="next()" class="btn btn-default disabled"><i class="fa fa-arrow-right"></i></button>';
			}else{
				$data['psn']['tombol']	='<button onclick="prev()" class="btn btn-default"><i class="fa fa-arrow-left"></i></button>
					<button onclick="next()" class="btn btn-default"><i class="fa fa-arrow-right"></i></button>';
			}
		}else{
			$data['psn']['gambar']	=$path;
		}
		echo json_encode($data['psn']);
	}

	function lihatfolder($pg=null){
		$gambar_andalan_['gambar_andalan']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE (`gambar_andalan` LIKE '%".$_GET['cari']."%') ORDER BY `id_gambar_andalan` DESC";
		}else{
			$cari = "WHERE 1=1 ORDER BY `id_gambar_andalan` DESC";
		}
		$table_name = 'tulisan';
		if($this->db->table_exists($table_name)){
			$config['per_page'] = '20';
			if($pg!=''){
				$offset=$pg;
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `gambar_andalan` ".$cari." limit ".$offset.",".$config['per_page'];
			$gambar_andalan_['gambar_andalan'] = $this->crud->get(null,null,null,null,null,$string_2);
			$gambar_andalan_['no'] = $offset;
		}else{
			$gambar_andalan_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $gambar_andalan_;
	}

	function addimage(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn']['tnd']=0;
		$data['psn']['gambar']=null;
		$this->load->library('image_lib');
		$path = dirname(__FILE__)."/../../../../assets/img/img_andalan";
		if((file_exists($path))&&(is_dir($path))){
			$config['upload_path'] = "./assets/img/img_andalan";
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '10240';
			$config['max_width']  = '2400';
			$config['max_height']  = '1600';
			$config['overwrite'] = TRUE;
			$config['encrypt_name'] = FALSE;
			$config['remove_spaces'] = TRUE;
			$name=$_FILES['gambar_andalan']['name'];
			if(!is_dir($config['upload_path']))die("Folder upload gambar tidak ditemukan.");
			$this->load->library('upload', $config);
			if(empty($name)){
				$data['psn']['wrng'] = 'danger';
				$data['psn']['psn']='Gambar baru gagal disimpan.';
				$data['psn']['tnd']=0;
			}else{
				if(!$this->upload->do_upload('gambar_andalan')){
					$data['psn']['wrng']='danger';
					$data['psn']['psn']='Gambar baru gagal disimpan. '.$this->upload->display_errors();
					$data['psn']['tnd']=0;
				}else{
					$data_=array(
						'gambar_andalan'=>$name
					);
					$this->crud->insert('gambar_andalan',$data_);

					$fileNameResize = $config['upload_path'].$name;
            		$resize = array();         
            		$resize = array(
	                    "width"         => 160,
	                    "height"        => 100,
	                    "quality"       => '100%',
	                    "source_image"  => $config['upload_path'].'/'.$name,
	                    "new_image"     => $config['upload_path'].'/thumb'.'/'.$name
	                );
	                $this->image_lib->initialize($resize); 
                	if(!$this->image_lib->resize()){
                		$data['psn']['psn']='Resize gambar baru gagal.'.$this->image_lib->display_errors();
						$data['psn']['tnd']=0;
						$data['psn']['wrng'] = 'danger';
                	}else{
                		$data['psn']['psn']='Gambar baru berhasil disimpan.';
						$data['psn']['tnd']=1;
						$data['psn']['wrng'] = 'success';
                	}
				}
				$image_data = $this->upload->data();
			}
		}else{
			$data['psn']['psn']='Direktori tidak ditemukan.';
		}
		if((file_exists($path))&&(is_dir($path))){
			$data['psn']['path']	=base_url('assets/img/img_andalan/thumb');
			$data_					=$this->lihatfolder();
			$data['psn']['gambar']	=$data_['gambar_andalan'];
			$total = $this->crud->get('gambar_andalan');
			if($this->uri->segment(3)==''or$this->uri->segment(3)==0){
				$data['psn']['tombol']	='<button onclick="prev()" class="btn btn-default disabled"><i class="fa fa-arrow-left"></i></button>
					<button onclick="next()" class="btn btn-default"><i class="fa fa-arrow-right"></i></button>';
			}else if($this->uri->segment(3)>=(count($total)-20)){
				$data['psn']['tombol']	='<button onclick="prev()" class="btn btn-default"><i class="fa fa-arrow-left"></i></button>
					<button onclick="next()" class="btn btn-default disabled"><i class="fa fa-arrow-right"></i></button>';
			}else{
				$data['psn']['tombol']	='<button onclick="prev()" class="btn btn-default"><i class="fa fa-arrow-left"></i></button>
					<button onclick="next()" class="btn btn-default"><i class="fa fa-arrow-right"></i></button>';
			}
		}
		echo json_encode($data['psn']);
	}

	function delimage(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='gambar_andalan';
		if($this->db->table_exists($table_name)){
        	$where=array(
        		array(
        			'where_field'=>'id_gambar_andalan',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$file_ = $this->crud->get($table_name,$where);
        	$path = dirname(__FILE__)."/../../../../assets/img/gambar_andalan/";
			$file = $file_[0]['gambar_andalan'];
			$namafile = $path.'/'.$file;
			if(file_exists($namafile)){
				unlink ($namafile);
			}
        	$this->crud->delete($table_name,$where);
        	$this->session->set_flashdata('success','gambar andalan berhasil dihapus');
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tulisan');
	}

	public function lihatgambarandalan1(){
		$data['psn']['gambar']=null;
		$path = dirname(__FILE__)."/../../../../assets/img/img_andalan";
		$this->load->library('image_lib');
		if((file_exists($path))&&(is_dir($path))){
			$config['upload_path'] = "./assets/img/img_andalan";
			$data['psn']['path']=base_url('assets/img/img_andalan');
			$data['psn']['gambar']=$this->lihatfolder1($path);
			if($data['psn']['gambar']!=null){
				foreach($data['psn']['gambar'] as $row){
					$data = array(
						'gambar_andalan'=>$row
					);
					$this->crud->insert('gambar_andalan',$data);

					$fileNameResize = $config['upload_path'].$row;
            		$resize = array();         
            		$resize = array(
	                    "width"         => 160,
	                    "height"        => 100,
	                    "quality"       => '100%',
	                    "source_image"  => $config['upload_path'].'/'.$row,
	                    "new_image"     => $config['upload_path'].'/thumb'.'/'.$row
	                );
	                $this->image_lib->initialize($resize); 
                	if(!$this->image_lib->resize()){
                		print_r($this->image_lib->display_errors());
                	}else{
                		echo'Gambar baru berhasil disimpan.';
                	}
				}
				$status = 'sukses';
			}
		}else{
			$data['psn']['gambar']=$path;
			$status = 'gagal';
		}
		echo json_encode($status);
	}

	public function lihatfolder1($path){
		$folder = $path;
		$dir=opendir($folder);
		$no=1;
		while($file=readdir($dir)){
			if ($file=="." or $file=="..")continue;
			$data[$no]=$file;
			$no++;
		}
		closedir($dir);

		return $data;
	}

	/*function addfile(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['tnd']=0;
		$path = dirname(__FILE__)."/../../../../assets/file";
		if((file_exists($path))&&(is_dir($path))){
			$config['upload_path'] = "./assets/file";
			$config['allowed_types'] = 'pdf|doc|xls|docx|xlsx|jpg|jpeg|gif|png';
			$config['max_size'] = '50240';
			$config['max_width']  = '2400';
			$config['max_height']  = '1600';
			$config['overwrite'] = TRUE;
			$config['encrypt_name'] = FALSE;
			$config['remove_spaces'] = TRUE;
			$this->load->library('upload', $config);
			$_FILES['file_0']=null;
			foreach($_FILES['file_lampiran'] as $key=>$val){
				$i = 1;
				foreach($val as $v){
					$field_name = "file".$i;
					$_FILES[$field_name][$key] = $v;
					$i++;
				}
			}
			unset($_FILES['file_lampiran']);
			$error = array();
			$success = array();
			foreach($_FILES as $field_name => $file){
				if ( ! $this->upload->do_upload($field_name)){
					$error[] = $this->upload->display_errors();
				}else{
					$success[] = $this->upload->data();
					if($this->db->table_exists('file')){
						$data__=array(
							'id_user'=>$this->session->userdata('id_pengguna'),
							'id_tulisan'=>$this->input->post('id_tulisan'),
							'file'=>str_replace(' ','_',$file['name']),
							'tgl_file'=>date('Y-m-d h:i:s')
						);
						$this->crud->insert('file',$data__);
						$data['name'][$this->db->insert_id()]['nm'] = str_replace(' ','_',$file['name']);
						$data['name'][$this->db->insert_id()]['id'] = $this->db->insert_id();
					}
				}
			}
			if(count($error) > 0){
				$data['error']=implode('<br />',$error);
			}else{
				$data['psn']['status']=implode('<br />',$success);
				$data['tnd']=1;
				$data['wrng'] = 'success';
			}
		}else{
			$data['psn']='Direktori tidak ditemukan.';
		}
		echo json_encode($data);
	}*/

	function delfile(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='file';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$data['data']['error']=0;
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$file=null;
	            	$where=array(
	            		array(
	            			'where_field'=>'id_file',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$file=$this->crud->get($table_name,$where);
	            	if($file!=null){
	            		$path = dirname(__FILE__)."/../../../../assets/file";
	            		$namafile = $path.'/'.$file[0]['file'];
	            		if(file_exists($namafile)){
	            			unlink ($namafile);
	            		}
	            	}
	            	$this->crud->delete($table_name,$where);
	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	$data['psn'] = 'File berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'File gagal dihapus';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['data']['error']=1;
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}
		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		echo json_encode($data);
	}
}
/* End of file tulisan.php */
/* Location: ./application/controllers/tulisan.php */