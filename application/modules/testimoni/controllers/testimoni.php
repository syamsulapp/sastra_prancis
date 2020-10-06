<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class testimoni extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('crud');
		$this->setting = new Setting();
	}

	function index(){
		$this->semua();
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
		$data['site']['page']='Tambah Testimoni Baru';
		$data['modules']='testimoni';
		$data['content']='v_testimoni_baru';
		$this->load->view('../../template/template', $data);
	}

	function addtestimoni(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='testimoni';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('username', 'username', 'required');
	            if ($this->form_validation->run()){
					if($this->input->post('id_testimoni')==''){
						$data_ = array(
				    		'nama'=>$this->input->post('username'),
							'email'=>$this->input->post('email'),
							'instansi'=>$this->input->post('instansi'),
							'testimoni'=>$this->input->post('testimoni'),
							'tgl_testimoni'=>date('Y-m-d H:i:s'),
							'foto'=>$this->input->post('foto')
						);
						$this->crud->insert($table_name,$data_);
					}else{
						$data_ = array(
							'nama'=>$this->input->post('username'),
							'email'=>$this->input->post('email'),
							'instansi'=>$this->input->post('instansi'),
							'testimoni'=>$this->input->post('testimoni'),
							'foto'=>$this->input->post('foto')
						);
						$where=array(
							array(
								'where_field'=>'id_testimoni',
								'where_key'=>$this->input->post('id_testimoni')
							)
						);
						$this->crud->update($table_name,$data__,$where);
					}
					$this->session->set_flashdata('success','testimoni '.$this->input->post('nama_testimoni').' berhasil disimpan');
				}else{
					$this->session->set_flashdata('warning','testimoni gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}
		redirect('testimoni');
	}

	function semua(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		if($this->uri->segment(2)==''){
			$data['psn']['status_testimoni']='';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Semua Testimoni';
		$data['data'] = $this->testimoni();
		$data['modules']='testimoni';
		$data['content']='v_testimoni';
		$this->load->view('../../template/template', $data);
	}

	function testimoni(){
		$testimoni_['testimoni']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_testimoni_` != 'sampah' AND (`testimoni` LIKE '%".$_GET['cari']."%' OR `nama` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_testimoni` DESC";
		}else{
			$cari = "WHERE `status_testimoni_` != 'sampah' ORDER BY `tgl_testimoni` DESC";
		}
		$table_name = 'testimoni';
		if($this->db->table_exists($table_name)){
			$testimoni_['error']=0;
			$string = "SELECT * FROM `testimoni` ".$cari;
			$testimoni = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('testimoni/testimoni/index/page');
			$config['total_rows'] = count($testimoni);
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
			$testimoni_['pagging'] = $this->pagination->create_links();
			if($testimoni!=null){
				$testimoni_['total_rows'] = $config['total_rows'];
			}else{
				$testimoni_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `testimoni` ".$cari." limit ".$offset.",".$config['per_page'];
			$testimoni_['testimoni'] = $this->crud->get(null,null,null,null,null,$string_2);
			$testimoni_['no'] = $offset;
			$menunggu = $this->crud->get(null,null,null,null,null,"SELECT count(`id_testimoni`) as `total` FROM `testimoni` WHERE `status_testimoni_` = 'menunggu' ORDER BY `tgl_testimoni` DESC");
			if($menunggu!=null){
				$testimoni_['total_rows_2'] = $menunggu[0]['total'];
			}else{
				$testimoni_['total_rows_2'] = 0;
			}
			$sampah = $this->crud->get(null,null,null,null,null,"SELECT count(`id_testimoni`) as `total` FROM `testimoni` WHERE `status_testimoni_` = 'sampah' ORDER BY `tgl_testimoni` DESC");
			if($sampah!=null){
				$testimoni_['total_rows_3'] = $sampah[0]['total'];
			}else{
				$testimoni_['total_rows_3'] = 0;
			}
		}else{
			$testimoni_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $testimoni_;
	}

	function menunggu(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		if($this->uri->segment(2)==''){
			$data['psn']['status_testimoni']='';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Testimoni Menunggu';
		$data['data'] = $this->testimoni_menunggu();
		$data['modules']='testimoni';
		$data['content']='v_testimoni';
		$this->load->view('../../template/template', $data);
	}

	function testimoni_menunggu(){
		$testimoni_['testimoni']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_testimoni_` = 'menunggu' AND (`testimoni` LIKE '%".$_GET['cari']."%' OR `nama` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_testimoni` DESC";
		}else{
			$cari = "WHERE `status_testimoni_` = 'menunggu' ORDER BY `tgl_testimoni` DESC";
		}
		$table_name = 'testimoni';
		if($this->db->table_exists($table_name)){
			$testimoni_['error']=0;
			$string = "SELECT * FROM `testimoni` ".$cari;
			$testimoni = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('testimoni/menunggu/index/page');
			$config['total_rows'] = count($testimoni);
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
			$testimoni_['pagging'] = $this->pagination->create_links();
			if($testimoni!=null){
				$testimoni_['total_rows_2'] = $config['total_rows'];
			}else{
				$testimoni_['total_rows_2'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `testimoni` ".$cari." limit ".$offset.",".$config['per_page'];
			$testimoni_['testimoni'] = $this->crud->get(null,null,null,null,null,$string_2);
			$testimoni_['no'] = $offset;
			$semua = $this->crud->get(null,null,null,null,null,"SELECT count(`id_testimoni`) as `total` FROM `testimoni` WHERE `status_testimoni_` != 'sampah' ORDER BY `tgl_testimoni` DESC");
			if($semua!=null){
				$testimoni_['total_rows'] = $semua[0]['total'];
			}else{
				$testimoni_['total_rows'] = 0;
			}
			$sampah = $this->crud->get(null,null,null,null,null,"SELECT count(`id_testimoni`) as `total` FROM `testimoni` WHERE `status_testimoni_` = 'sampah' ORDER BY `tgl_testimoni` DESC");
			if($sampah!=null){
				$testimoni_['total_rows_3'] = $sampah[0]['total'];
			}else{
				$testimoni_['total_rows_3'] = 0;
			}
		}else{
			$testimoni_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $testimoni_;
	}

	function sampah(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		if($this->uri->segment(2)==''){
			$data['psn']['status_testimoni']='';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Testimoni Sampah';
		$data['data'] = $this->testimoni_sampah();
		$data['modules']='testimoni';
		$data['content']='v_testimoni_sampah';
		$this->load->view('../../template/template', $data);
	}

	function testimoni_sampah(){
		$testimoni_['testimoni']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_testimoni_` = 'sampah' AND (`testimoni` LIKE '%".$_GET['cari']."%' OR `nama` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_testimoni` DESC";
		}else{
			$cari = "WHERE `status_testimoni_` = 'sampah' ORDER BY `tgl_testimoni` DESC";
		}
		$table_name = 'testimoni';
		if($this->db->table_exists($table_name)){
			$testimoni_['error']=0;
			$string = "SELECT * FROM `testimoni` ".$cari;
			$testimoni = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('testimoni/sampah/index/page');
			$config['total_rows'] = count($testimoni);
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
			$testimoni_['pagging'] = $this->pagination->create_links();
			if($testimoni!=null){
				$testimoni_['total_rows_3'] = $config['total_rows'];
			}else{
				$testimoni_['total_rows_3'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `testimoni` ".$cari." limit ".$offset.",".$config['per_page'];
			$testimoni_['testimoni'] = $this->crud->get(null,null,null,null,null,$string_2);
			$testimoni_['no'] = $offset;
			$semua = $this->crud->get(null,null,null,null,null,"SELECT count(`id_testimoni`) as `total` FROM `testimoni` WHERE `status_testimoni_` != 'sampah' ORDER BY `tgl_testimoni` DESC");
			if($semua!=null){
				$testimoni_['total_rows'] = $semua[0]['total'];
			}else{
				$testimoni_['total_rows'] = 0;
			}
			$sampah = $this->crud->get(null,null,null,null,null,"SELECT count(`id_testimoni`) as `total` FROM `testimoni` WHERE `status_testimoni_` = 'menunggu' ORDER BY `tgl_testimoni` DESC");
			if($sampah!=null){
				$testimoni_['total_rows_2'] = $sampah[0]['total'];
			}else{
				$testimoni_['total_rows_2'] = 0;
			}
		}else{
			$testimoni_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $testimoni_;
	}

	function sembunyikan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='testimoni';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_testimoni_'=>'menunggu'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_testimoni',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'testimoni berhasil disembunyikan';
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
		$table_name='testimoni';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_testimoni_'=>'terbit'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_testimoni',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'testimoni berhasil ditampilkan';
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
		$table_name='testimoni';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_testimoni_'=>'menunggu'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_testimoni',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'testimoni berhasil dikembalikan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}

	function deltestimoni(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='testimoni';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$data=array(
		        		'status_testimoni_'=>'sampah'
		        	);
		        	$where=array(
		        		array(
		        			'where_field'=>'id_testimoni',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->update($table_name,$data,$where);
	            	$this->session->set_flashdata('success','testimoni berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','testimoni gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('testimoni/testimoni');
	}
	function deltestimonimassal(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='testimoni';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$data=array(
				        		'status_testimoni_'=>'sampah'
				        	);
				        	$where=array(
				        		array(
				        			'where_field'=>'id_testimoni',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','testimoni berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','testimoni gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('testimoni/testimoni');
	}

	function deltestimonipermanen(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='testimoni';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
		        	$where=array(
		        		array(
		        			'where_field'=>'id_testimoni',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','testimoni berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','testimoni gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('testimoni/sampah');
	}
	function deltestimonimassalpermanen(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='testimoni';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
				        	$where=array(
				        		array(
				        			'where_field'=>'id_testimoni',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->delete($table_name,$where);
			            }else if($this->input->post('aksi_tindakan_massal_atas')=='kmbl' or $this->input->post('aksi_tindakan_massal_bawah')=='kmbl'){
			            	$data=array(
				        		'status_testimoni_'=>'menunggu'
				        	);
			            	$where=array(
				        		array(
				        			'where_field'=>'id_testimoni',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','testimoni berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','testimoni gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('testimoni/sampah');
	}

}
/* End of file testimoni.php */
/* Location: ./application/controllers/testimoni.php */