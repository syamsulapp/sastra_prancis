<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Komentar extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('crud');
		$this->setting = new Setting();
	}

	function index(){
		$this->semua();
	}

	function semua(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		if($this->uri->segment(2)==''){
			$data['psn']['status_komentar']='';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Semua Komentar';
		$data['data'] = $this->komentar();
		$data['modules']='komentar';
		$data['content']='v_komentar';
		$this->load->view('../../template/template', $data);
	}

	function komentar(){
		$komentar_['komentar']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_komentar_` != 'sampah' AND (`komentar` LIKE '%".$_GET['cari']."%' OR `nama` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_komentar` DESC";
		}else{
			$cari = "WHERE `status_komentar_` != 'sampah' ORDER BY `tgl_komentar` DESC";
		}
		$table_name = 'komentar';
		if($this->db->table_exists($table_name)){
			$komentar_['error']=0;
			$string = "SELECT * FROM `komentar` JOIN `tulisan` ON `komentar`.`id_tul`=`tulisan`.`id_tulisan` ".$cari;
			$komentar = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('komentar/komentar/index/page');
			$config['total_rows'] = count($komentar);
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
			$komentar_['pagging'] = $this->pagination->create_links();
			if($komentar!=null){
				$komentar_['total_rows'] = $config['total_rows'];
			}else{
				$komentar_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT `komentar`.*,`tulisan`.`judul_id`,`tulisan`.`penulis` FROM `komentar` JOIN `tulisan` ON `komentar`.`id_tul`=`tulisan`.`id_tulisan` ".$cari." limit ".$offset.",".$config['per_page'];
			$komentar_['komentar'] = $this->crud->get(null,null,null,null,null,$string_2);
			$komentar_['no'] = $offset;
			$menunggu = $this->crud->get(null,null,null,null,null,"SELECT count(`id_komentar`) as `total` FROM `komentar` WHERE `status_komentar_` = 'menunggu' ORDER BY `tgl_komentar` DESC");
			if($menunggu!=null){
				$komentar_['total_rows_2'] = $menunggu[0]['total'];
			}else{
				$komentar_['total_rows_2'] = 0;
			}
			$sampah = $this->crud->get(null,null,null,null,null,"SELECT count(`id_komentar`) as `total` FROM `komentar` WHERE `status_komentar_` = 'sampah' ORDER BY `tgl_komentar` DESC");
			if($sampah!=null){
				$komentar_['total_rows_3'] = $sampah[0]['total'];
			}else{
				$komentar_['total_rows_3'] = 0;
			}
		}else{
			$komentar_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $komentar_;
	}

	function menunggu(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		if($this->uri->segment(2)==''){
			$data['psn']['status_komentar']='';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Komentar Menunggu';
		$data['data'] = $this->komentar_menunggu();
		$data['modules']='komentar';
		$data['content']='v_komentar';
		$this->load->view('../../template/template', $data);
	}

	function komentar_menunggu(){
		$komentar_['komentar']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_komentar_` = 'menunggu' AND (`komentar` LIKE '%".$_GET['cari']."%' OR `nama` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_komentar` DESC";
		}else{
			$cari = "WHERE `status_komentar_` = 'menunggu' ORDER BY `tgl_komentar` DESC";
		}
		$table_name = 'komentar';
		if($this->db->table_exists($table_name)){
			$komentar_['error']=0;
			$string = "SELECT * FROM `komentar` JOIN `tulisan` ON `komentar`.`id_tul`=`tulisan`.`id_tulisan` ".$cari;
			$komentar = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('komentar/menunggu/index/page');
			$config['total_rows'] = count($komentar);
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
			$komentar_['pagging'] = $this->pagination->create_links();
			if($komentar!=null){
				$komentar_['total_rows_2'] = $config['total_rows'];
			}else{
				$komentar_['total_rows_2'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT `komentar`.*,`tulisan`.`judul_id`,`tulisan`.`penulis` FROM `komentar` JOIN `tulisan` ON `komentar`.`id_tul`=`tulisan`.`id_tulisan` ".$cari." limit ".$offset.",".$config['per_page'];
			$komentar_['komentar'] = $this->crud->get(null,null,null,null,null,$string_2);
			$komentar_['no'] = $offset;
			$semua = $this->crud->get(null,null,null,null,null,"SELECT count(`id_komentar`) as `total` FROM `komentar` WHERE `status_komentar_` != 'sampah' ORDER BY `tgl_komentar` DESC");
			if($semua!=null){
				$komentar_['total_rows'] = $semua[0]['total'];
			}else{
				$komentar_['total_rows'] = 0;
			}
			$sampah = $this->crud->get(null,null,null,null,null,"SELECT count(`id_komentar`) as `total` FROM `komentar` WHERE `status_komentar_` = 'sampah' ORDER BY `tgl_komentar` DESC");
			if($sampah!=null){
				$komentar_['total_rows_3'] = $sampah[0]['total'];
			}else{
				$komentar_['total_rows_3'] = 0;
			}
		}else{
			$komentar_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $komentar_;
	}

	function sampah(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		if($this->uri->segment(2)==''){
			$data['psn']['status_komentar']='';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Komentar Sampah';
		$data['data'] = $this->komentar_sampah();
		$data['modules']='komentar';
		$data['content']='v_komentar_sampah';
		$this->load->view('../../template/template', $data);
	}

	function komentar_sampah(){
		$komentar_['komentar']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE `status_komentar_` = 'sampah' AND (`komentar` LIKE '%".$_GET['cari']."%' OR `nama` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_komentar` DESC";
		}else{
			$cari = "WHERE `status_komentar_` = 'sampah' ORDER BY `tgl_komentar` DESC";
		}
		$table_name = 'komentar';
		if($this->db->table_exists($table_name)){
			$komentar_['error']=0;
			$string = "SELECT * FROM `komentar` JOIN `tulisan` ON `komentar`.`id_tul`=`tulisan`.`id_tulisan` ".$cari;
			$komentar = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('komentar/sampah/index/page');
			$config['total_rows'] = count($komentar);
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
			$komentar_['pagging'] = $this->pagination->create_links();
			if($komentar!=null){
				$komentar_['total_rows_3'] = $config['total_rows'];
			}else{
				$komentar_['total_rows_3'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT `komentar`.*,`tulisan`.`judul_id`,`tulisan`.`penulis` FROM `komentar` JOIN `tulisan` ON `komentar`.`id_tul`=`tulisan`.`id_tulisan` ".$cari." limit ".$offset.",".$config['per_page'];
			$komentar_['komentar'] = $this->crud->get(null,null,null,null,null,$string_2);
			$komentar_['no'] = $offset;
			$semua = $this->crud->get(null,null,null,null,null,"SELECT count(`id_komentar`) as `total` FROM `komentar` WHERE `status_komentar_` != 'sampah' ORDER BY `tgl_komentar` DESC");
			if($semua!=null){
				$komentar_['total_rows'] = $semua[0]['total'];
			}else{
				$komentar_['total_rows'] = 0;
			}
			$sampah = $this->crud->get(null,null,null,null,null,"SELECT count(`id_komentar`) as `total` FROM `komentar` WHERE `status_komentar_` = 'menunggu' ORDER BY `tgl_komentar` DESC");
			if($sampah!=null){
				$komentar_['total_rows_2'] = $sampah[0]['total'];
			}else{
				$komentar_['total_rows_2'] = 0;
			}
		}else{
			$komentar_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $komentar_;
	}

	function sembunyikan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='komentar';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_komentar_'=>'menunggu'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_komentar',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Komentar berhasil disembunyikan';
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
		$table_name='komentar';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_komentar_'=>'terbit'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_komentar',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Komentar berhasil ditampilkan';
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
		$table_name='komentar';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_komentar_'=>'menunggu'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_komentar',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Komentar berhasil dikembalikan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}
	
	function delkomentar(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='komentar';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$data=array(
		        		'status_komentar_'=>'sampah'
		        	);
		        	$where=array(
		        		array(
		        			'where_field'=>'id_komentar',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->update($table_name,$data,$where);
	            	$this->session->set_flashdata('success','komentar berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','komentar gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('komentar/komentar');
	}
	function delkomentarmassal(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='komentar';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$data=array(
				        		'status_komentar_'=>'sampah'
				        	);
				        	$where=array(
				        		array(
				        			'where_field'=>'id_komentar',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','komentar berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','komentar gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('komentar/komentar');
	}

	function delkomentarpermanen(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='komentar';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
		        	$where=array(
		        		array(
		        			'where_field'=>'id_komentar',
		        			'where_key'=>$this->input->post('id')
		        		)
		        	);
		        	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','komentar berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','komentar gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('komentar/sampah');
	}
	function delkomentarmassalpermanen(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='komentar';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
				        	$where=array(
				        		array(
				        			'where_field'=>'id_komentar',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->delete($table_name,$where);
			            }else if($this->input->post('aksi_tindakan_massal_atas')=='kmbl' or $this->input->post('aksi_tindakan_massal_bawah')=='kmbl'){
			            	$data=array(
				        		'status_komentar_'=>'menunggu'
				        	);
			            	$where=array(
				        		array(
				        			'where_field'=>'id_komentar',
				        			'where_key'=>$id_
				        		)
				        	);
				        	$this->crud->update($table_name,$data,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','komentar berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','komentar gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('komentar/sampah');
	}

}

/* End of file komentar.php */
/* Location: ./application/controllers/komentar.php */