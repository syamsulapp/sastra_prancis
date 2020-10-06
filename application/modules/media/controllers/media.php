<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Media extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
	}

	public function index(){
		$this->semua_media();
	}

	public function semua_media(){
		$data = $this->setting->get_jml();
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		$limit_ = 20;

		$media_all = $this->crud->get('gambar_andalan');
		$config['base_url'] = base_url('media/index/');
		$config['uri_segment'] = 3;
		$config['total_rows'] = count($media_all);
		$config['per_page'] = $limit_;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$config['next_link'] = '&rarr;';
		$config['prev_link'] = '&larr;';
		$config['full_tag_open'] = '<ul class="pagination" style="margin:0px 7px;">';
		$this->pagination->initialize($config);
		$data['halaman'] = $this->pagination->create_links();

		if($this->uri->segment(3)!=''){
			$offset=$this->uri->segment(3);
		}else{
			$offset=0;
		}

		$rule['limit']		 = $limit_;
		$rule['order_by']	 = 'DESC';
		$rule['order_field'] = 'id_gambar_andalan';
		$rule['offset']		 = $offset;

		$data['data'] = $this->crud->get('gambar_andalan',null,$rule);

		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['tombol'] = '<a id="btn-tambah-album-baru" title="Tambah gambar baru" data-toggle="modal" data-target=".bs-album">
			<li class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</li>
		</a>';
		$data['site']['page']='Semua Media';
		$data['modules']='media';
		$data['content']='v_media';
		$this->load->view('../../template/template', $data);
	}

	public function delgambar(){
		$data['psn'] = '';
		$data['psn']['gambar']='kosong';
		$img = $this->input->post('nama');
		$id = $this->input->post('id');
		$path = dirname(__FILE__)."/../../../../assets/img/img_andalan/";
		$file = $img;
		$namafile = $path.'/'.$file;
		$namafile2 = $path.'/thumb/'.$file;
		if(file_exists($namafile)){
			unlink ($namafile);
			unlink ($namafile2);
			$this->session->set_flashdata('success','Gambar berhasil dihapus.');
		}else{
			$this->session->set_flashdata('danger','Gambar gagal dihapus.');
		}
		//img db
		if($this->db->table_exists('gambar_andalan')){
			$where_img=array(
				array(
					'where_field'=>'id_gambar_andalan',
					'where_key'=>$id
				)
			);
			$this->crud->delete('gambar_andalan',$where_img);
		}
		//img db end
		redirect('media');
	}

	public function addimage(){
		$path = dirname(__FILE__)."/../../../../assets/img/img_andalan/";
		$this->load->library('image_lib');
		if((file_exists($path))&&(is_dir($path))){
			$config['upload_path'] = "./assets/img/img_andalan/";
			$config['allowed_types'] = 'gif|jpg|png|pdf|docx';
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
				$this->session->set_flashdata('danger','Gambar gagal disimpan.');
			}else{
				if(!$this->upload->do_upload('gambar_andalan')){
					$this->session->set_flashdata('danger',$this->upload->display_errors());
				}else{
					$image_data = $this->upload->data();
					$this->session->set_flashdata('success','Gambar berhasil disimpan.');

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
			}
		}else{
			$this->session->set_flashdata('danger','Direktori tidak ditemukan.');
		}
		if($this->db->table_exists('gambar_andalan')){
			$data_img=array(
				'gambar_andalan'=>$name
			);
			$this->crud->insert('gambar_andalan',$data_img);
		}
		redirect('media');
	}

}

/* End of file album.php */
/* Location: ./application/controllers/album.php */