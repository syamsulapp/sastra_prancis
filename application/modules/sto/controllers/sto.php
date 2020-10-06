<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Sto extends MX_Controller{

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
		$data['site']['page']	='Semua STO';
		$data['data']			= $this->semua();
		$data['modules']		='sto';
		$data['content']		='v_sto';
		$this->load->view('../../template/template', $data);
	}

	function semua(){
		$sto_['sto']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_sto` != 'block' AND (`email` LIKE '%".$_GET['cari']."%' OR `nm_dp` LIKE '%".$_GET['cari']."%' OR `nm_blk` LIKE '%".$_GET['cari']."%'  OR `kota_lahir` LIKE '%".$_GET['cari']."%' OR `jabatan` LIKE '%".$_GET['cari']."%' OR `pangkat` LIKE '%".$_GET['cari']."%' OR `pendidikan` LIKE '%".$_GET['cari']."%') ORDER BY `nm_dp` ASC";
		}else{
			$cari = "WHERE `status_sto` != 'block' ORDER BY `nm_dp` ASC";
		}
		$table_name = 'sto';
		if($this->db->table_exists($table_name)){
			$sto_['error']=0;
			$string = "SELECT * FROM `sto` ".$cari;
			$sto = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('sto/sto/index/page');
			$config['total_rows'] = count($sto);
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
			$sto_['pagging'] = $this->pagination->create_links();
			if($sto!=null){
				$sto_['total_rows'] = $config['total_rows'];
			}else{
				$sto_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `sto` ".$cari." limit ".$offset.",".$config['per_page'];
			$sto_['sto'] = $this->crud->get(null,null,null,null,null,$string_2);
			$sto_['no'] = $offset;
			$sto_['total_rows_1'][0]['total'] = $sto_['total_rows'];
			$sto_['total_rows_5'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_sto`) as `total` FROM `sto` WHERE `status_sto` = 'block' ORDER BY `nm_dp` ASC");
		}else{
			$sto_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $sto_;
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
		$data['site']['page']	='STO Block';
		$data['data']			= $this->sto_block();
		$data['modules']		='sto';
		$data['content']		='v_sto';
		$this->load->view('../../template/template', $data);
	}

	function sto_block(){
		$sto_['sto']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_sto` = 'block' AND (`email` LIKE '%".$_GET['cari']."%' OR `nm_dp` LIKE '%".$_GET['cari']."%' OR `nm_blk` LIKE '%".$_GET['cari']."%'  OR `kota_lahir` LIKE '%".$_GET['cari']."%' OR `jabatan` LIKE '%".$_GET['cari']."%' OR `pangkat` LIKE '%".$_GET['cari']."%' OR `pendidikan` LIKE '%".$_GET['cari']."%') ORDER BY `nm_dp` ASC";
		}else{
			$cari = "WHERE `status_sto` = 'block' ORDER BY `nm_dp` ASC";
		}
		$table_name = 'sto';
		if($this->db->table_exists($table_name)){
			$sto_['error']=0;
			$string = "SELECT * FROM `sto` ".$cari;
			$sto = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('sto/block/index/page');
			$config['total_rows'] = count($sto);
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
			$sto_['pagging'] = $this->pagination->create_links();
			if($sto!=null){
				$sto_['total_rows'] = $config['total_rows'];
			}else{
				$sto_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `sto` ".$cari." limit ".$offset.",".$config['per_page'];
			$sto_['sto'] = $this->crud->get(null,null,null,null,null,$string_2);
			$sto_['no'] = $offset;
			$sto_['total_rows_5'][0]['total'] = $sto_['total_rows'];
			$sto_['total_rows_1'] = $this->crud->get(null,null,null,null,null,"SELECT count(`id_sto`) as `total` FROM `sto` WHERE `status_sto` = 'aktif' ORDER BY `nm_dp` ASC");
		}else{
			$sto_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $sto_;
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
		$data['site']['page']='Tambah STO Baru';
		$data['sunting'] = 'false';
		$data['modules']='sto';
		$data['content']='v_sto_baru';
		$this->load->view('../../template/template', $data);
	}

	function sunting(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		if($this->input->get('id')!=''){
			$data['sto']=null;
			$sto = null;
			$data = $this->setting->get_jml();
			$sto = $this->crud->get('sto',array(array('where_field'=>'id_sto','where_key'=>$this->input->get('id'))));
			if(isset($sto[0])){
				$data['sto'] = $sto[0];
				$data['sunting'] = 'true';
			};
			$data['site']=$this->setting->web();
			$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
			$data['site']['page']='Sunting sto';
			$data['modules']='sto';
			$data['content']='v_sto_baru';
			$this->load->view('../../template/template', $data);
		}else{
			redirect('home/errors');
		}
	}


	function addsto(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$table_name='sto';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('nm_dp', 'nm_dp', 'required');
	            if ($this->form_validation->run()){
			    	if($this->input->post('id_sto')==''){
						$data_ = array(
							'email'=>$this->input->post('email'),
							'nm_dp'=>$this->input->post('nm_dp'),
							'nm_blk'=>$this->input->post('nm_blk'),
							'tgl_lahir'=>$this->input->post('tgl_lahir'),
							'kota_lahir'=>$this->input->post('kota_lahir'),
							'jabatan'=>$this->input->post('jabatan'),
							'pangkat'=>$this->input->post('pangkat'),
							'pendidikan'=>$this->input->post('pendidikan'),
							'nip'=>$this->input->post('nip'),
							'foto'=>$this->input->post('foto')
						);
						$this->crud->insert($table_name,$data_);
					}else{
						$data__ = array(
							'email'=>$this->input->post('email'),
							'nm_dp'=>$this->input->post('nm_dp'),
							'nm_blk'=>$this->input->post('nm_blk'),
							'tgl_lahir'=>$this->input->post('tgl_lahir'),
							'kota_lahir'=>$this->input->post('kota_lahir'),
							'jabatan'=>$this->input->post('jabatan'),
							'pangkat'=>$this->input->post('pangkat'),
							'pendidikan'=>$this->input->post('pendidikan'),
							'nip'=>$this->input->post('nip'),
							'foto'=>$this->input->post('foto')
						);
						$where=array(
							array(
								'where_field'=>'id_sto',
								'where_key'=>$this->input->post('id_sto')
							)
						);
						$this->crud->update($table_name,$data__,$where);
					}
					$this->session->set_flashdata('success','sto berhasil disimpan');
	            }else{
					$this->session->set_flashdata('warning','sto gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}

		redirect('sto');
	}

	function sembunyikan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='sto';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_sto'=>'block'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_sto',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'sto berhasil diblock';
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
		$table_name='sto';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_sto'=>'aktif'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_sto',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'sto berhasil diaktifkan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function delsto(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='sto';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
		        	$where=array(
		        		array(
		        			'where_field'=>'id_sto',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','sto berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','sto gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('sto/sto');
	}
	function delstomassal(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='sto';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps_p' or $this->input->post('aksi_tindakan_massal_bawah')=='hps_p'){
				        	$where=array(
				        		array(
				        			'where_field'=>'id_sto',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->delete($table_name,$where);
			            }else if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$data=array(
			            		'status_sto'=>'block'
			            	);
			            	$where=array(
				        		array(
				        			'where_field'=>'id_sto',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }else if($this->input->post('aksi_tindakan_massal_atas')=='kmbl' or $this->input->post('aksi_tindakan_massal_bawah')=='kmbl'){
			            	$data=array(
			            		'status_sto'=>'aktif'
			            	);
			            	$where=array(
				        		array(
				        			'where_field'=>'id_sto',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','sto berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','sto gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('sto/sto');
	}
}

/* End of file sto.php */
/* Location: ./application/controllers/sto.php */