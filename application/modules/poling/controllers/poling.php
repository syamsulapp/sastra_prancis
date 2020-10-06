<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Poling extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
	}

	function index(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			= $this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	= 'Poling';
		$data['data']			= $this->poling();
		$data['modules']		= 'poling';
		$data['content']		= 'v_poling';
		$this->load->view('../../template/template', $data);
	}

	function poling(){
		$poling_['poling']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `parent_poling` = '0' AND (`nama_poling` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_poling` DESC";
		}else{
			$cari = "WHERE `parent_poling` = '0' ORDER BY `tgl_poling` DESC";
		}
		$table_name = 'poling';
		if($this->db->table_exists($table_name)){
			$poling_['error']=0;
			$string = "SELECT * FROM `poling` ".$cari;
			$poling = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('poling/poling/index/page');
			$config['total_rows'] = count($poling);
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
			$poling_['pagging'] = $this->pagination->create_links();
			if($poling!=null){
				$poling_['total_rows'] = $config['total_rows'];
			}else{
				$poling_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `poling` ".$cari." limit ".$offset.",".$config['per_page'];
			$poling_['poling'] = $this->crud->get(null,null,null,null,null,$string_2);
			if($poling_['poling']!=null){
				foreach ($poling_['poling'] as $row) {
					$poling_['child'][$row['id_poling']] = $this->crud->get('poling',array(array('where_field'=>'parent_poling','where_key'=>$row['id_poling'])));
					if($poling_['child'][$row['id_poling']]!=null){
						foreach ($poling_['child'][$row['id_poling']] as $row2) {
							$string3 = 'SELECT count(`id_poling_`) as `jml` FROM `poling_hasil` WHERE `id_poling_`='.$row2['id_poling'];
							$poling_['jml'][$row2['id_poling']] = $this->crud->get(null,null,null,null,null,$string3);
						}
					}
				}
			}
			$poling_['no'] = $offset;
		}else{
			$poling_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $poling_;
	}

	function addpoling(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='poling';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('deskripsi_poling', 'deskripsi_poling', 'required');
	            if ($this->form_validation->run()){
	            	if($this->session->userdata('id_pengguna')!=''){
			    		$penulis = $this->session->userdata('id_pengguna');
			    	}else{
			    		$penulis = '1';
			    	}
					if($this->input->post('id_poling')==''){
						$data_ = array(
							'nama_poling'=>$this->input->post('deskripsi_poling'),
							'tgl_poling'=>date('Y-m-d h:i:s'),
							'parent_poling'=>'0',
							'status_poling'=>'close',
							'status_poling_2'=>'open'
						);
						$this->crud->insert($table_name,$data_);
						$parent = $this->db->insert_id();
						$pilihan = $this->input->post('pilihan');
						foreach($pilihan as $row){
							if($row!=''){
								$data_2 = array(
									'nama_poling'=>$row,
									'tgl_poling'=>date('Y-m-d h:i:s'),
									'parent_poling'=>$parent,
									'status_poling'=>'close',
									'status_poling_2'=>'open'
								);
								$this->crud->insert($table_name,$data_2);
							}
						}
					}else{
						$data_ = array(
							'nama_poling'=>$this->input->post('deskripsi_poling'),
							'tgl_poling'=>date('Y-m-d h:i:s'),
							'parent_poling'=>'0'
						);
						$where=array(
							array(
								'where_field'=>'id_poling',
								'where_key'=>$this->input->post('id_poling')
							)
						);
						$this->crud->update($table_name,$data_,$where);
						$pilihan = $this->input->post('pilihan');
						$id_pilihan = $this->input->post('id_pilihan');
						foreach($id_pilihan as $row){
							$where_3=array(
								array(
									'where_field'=>'id_poling',
									'where_key'=>$row
								)
							);
							$check=null;
							$check=$this->crud->get($table_name,$where_3);
							if($pilihan[$row]!=''){
								$where_2=array(
									array(
										'where_field'=>'id_poling',
										'where_key'=>$row
									)
								);
								$data_2 = array(
									'nama_poling'=>$pilihan[$row],
									'tgl_poling'=>date('Y-m-d h:i:s'),
									'parent_poling'=>$this->input->post('id_poling')
								);
								if($check!=null){
									$this->crud->update($table_name,$data_2,$where_2);
								}else{
									$this->crud->insert($table_name,$data_2);
								}
							}
						}
					}
					$this->session->set_flashdata('success','poling '.$this->input->post('nama_poling').' berhasil disimpan');
				}else{
					$this->session->set_flashdata('warning','poling gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('poling');
	}

	function sembunyikan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='poling';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_poling'=>'close'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_poling',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'poling berhasil disembunyikan';
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
		$table_name='poling';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_poling'=>'open'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_poling',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'poling berhasil ditampilkan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function tutup(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='poling';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_poling_2'=>'close',
        		'tgl_akhir'=>date('Y-m-d h:i:s')
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_poling',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'poling berhasil ditutup';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function buka(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='poling';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_poling_2'=>'open'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_poling',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'poling berhasil dibuka';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function delpoling(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='poling';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
		        	$where=array(
		        		array(
		        			'where_field'=>'id_poling',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->delete($table_name,$where);
		        	$where2=array(
		        		array(
		        			'where_field'=>'parent_poling',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->delete($table_name,$where2);
	            	$this->session->set_flashdata('success','poling berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','poling gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('poling/poling');
	}

	function delpolingmassal(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='poling';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
				        	$where=array(
				        		array(
				        			'where_field'=>'id_poling',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->delete($table_name,$where);
				        	$where2=array(
				        		array(
				        			'where_field'=>'parent_poling',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->delete($table_name,$where2);
			            }
		            }
	            	$this->session->set_flashdata('success','poling berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','poling gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('poling/poling');
	}

}

/* End of file poling.php */
/* Location: ./application/controllers/poling.php */