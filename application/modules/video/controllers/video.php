<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class video extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('crud');
		$this->setting = new Setting();
	}

	function index(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Video';
		$data['data']			= $this->video();
		$data['modules']		='video';
		$data['content']		='v_video';
		$this->load->view('../../template/template', $data);
	}

	function video(){
		$video_['video']=null;
		if(@$_GET['cari']!=''){
			$cari = "WHERE (`nama_video` LIKE '%".$_GET['cari']."%') ORDER BY `tgl_video` DESC";
		}else{
			$cari = " ORDER BY `tgl_video` DESC";
		}
		$table_name = 'video';
		if($this->db->table_exists($table_name)){
			$video_['error']=0;
			$string = "SELECT * FROM `video` ".$cari;
			$video = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('video/video/index/page');
			$config['total_rows'] = count($video);
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
			$video_['pagging'] = $this->pagination->create_links();
			if($video!=null){
				$video_['total_rows'] = $config['total_rows'];
			}else{
				$video_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `video` ".$cari." limit ".$offset.",".$config['per_page'];
			$video_['video'] = $this->crud->get(null,null,null,null,null,$string_2);
			$video_['no'] = $offset;
		}else{
			$video_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $video_;
	}

	function addvideo(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='video';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('nama_video', 'nama_video', 'required');
	            if ($this->form_validation->run()){
	            	if($this->session->userdata('id_pengguna')!=''){
			    		$penulis = $this->session->userdata('id_pengguna');
			    	}else{
			    		$penulis = '1';
			    	}
					if($this->input->post('id_video')==''){
						$data = array(
							'nama_video'=>$this->input->post('nama_video'),
							'url_video'=>$this->input->post('deskripsi_video'),
							'tgl_video'=>date('Y-m-d h:i:s'),
							'pengunggah'=>$penulis,
							'status_video'=>'close'
						);
						$this->crud->insert($table_name,$data);
					}else{
						$data = array(
							'nama_video'=>$this->input->post('nama_video'),
							'url_video'=>$this->input->post('deskripsi_video'),
							'tgl_video'=>date('Y-m-d h:i:s'),
							'pengunggah'=>$penulis
						);
						$where=array(
							array(
								'where_field'=>'id_video',
								'where_key'=>$this->input->post('id_video')
							)
						);
						$this->crud->update($table_name,$data,$where);
					}
					$this->session->set_flashdata('success','video '.$this->input->post('nama_video').' berhasil disimpan');
				}else{
					$this->session->set_flashdata('warning','video gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('video');
	}

	function delvideo(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='video';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$where=array(
	            		array(
	            			'where_field'=>'id_video',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','video berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','video gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('video');
	}

	function delvideomassal(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='video';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$where=array(
			            		array(
			            			'where_field'=>'id_video',
			            			'where_key'=>$id_
			            		)
			            	);
			            	$this->crud->delete($table_name,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','video berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','video gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('video');
	}

	function sembunyikan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='video';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_video'=>'close'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_video',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Video berhasil disembunyikan';
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
		$table_name='video';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_video'=>'open'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_video',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'video berhasil ditampilkan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		echo json_encode($data);
	}
}
/* End of file video.php */
/* Location: ./application/controllers/video.php */