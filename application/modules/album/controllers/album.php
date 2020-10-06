<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Album extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
	}

	public function index(){
		$this->semua_tulisan();
	}

	public function lihat(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'album',
				'status_log'=>'lihat',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Album Lihat';
		$data['album']=$this->album(null,$this->uri->segment(3));
		$data['modules']='album';
		$data['content']='v_semua_album_lihat';
		$this->load->view('../../template/template', $data);
	}

	public function semua_tulisan(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'album',
				'status_log'=>'semua album',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		if($this->uri->segment(2)==''){
			$data['psn']['status_tulisan']='';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Semua Album';
		$data['modules']='album';
		$data['content']='v_semua_album';
		$this->load->view('../../template/template', $data);
	}

	public function terbit(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'album',
				'status_log'=>'terbit',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		if($this->uri->segment(2)=='terbit'){
			$data['psn']['status_tulisan']='terbit';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Album Terbit';
		$data['tombol'] = '<a href="#" id="btn-tambah-album-baru" title="Tambah album baru" data-toggle="modal" data-target=".bs-album">
			<li class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</li>
		</a>';
		$data['modules']='album';
		$data['content']='v_semua_album';
		$this->load->view('../../template/template', $data);
	}

	public function konsep(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'album',
				'status_log'=>'konsep',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		if($this->uri->segment(2)=='konsep'){
			$data['psn']['status_tulisan']='konsep';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['modules']='album';
		$data['content']='v_semua_album';
		$this->load->view('../../template/template', $data);
	}

	public function sampah(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'album',
				'status_log'=>'sampah',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		if($this->uri->segment(2)=='sampah'){
			$data['psn']['status_tulisan']='sampah';
			$this->session->set_userdata($data['psn']);
		}
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Album Sampah';
		$data['modules']='album';
		$data['content']='v_semua_album';
		$this->load->view('../../template/template', $data);
	}

	public function getalbumjson(){
		$data['data'] = null;
		$data['data'] = $this->getalbum();
		echo json_encode($data);
	}

	public function getalbum(){
		$data['album'] = null;
		$data['album'] = $this->album();
		return $data['album'];
	}

	public function addalbum(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$table_name='tulisan';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('album', 'album', 'required');
	            if ($this->form_validation->run()){
	            	if($this->session->userdata('id_pengguna')!=''){
			    		$penulis = $this->session->userdata('id_pengguna');
			    	}else{
			    		$penulis = '1';
			    	}
			    	if($this->input->post('id')==''){
						$data_ = array(
				    		'penulis'=>$penulis,
				    		'tgl_tulisan'=>date('Y-m-d H:i:s'),
				    		'tulisan_id'=>'',
							'judul_id'=>$this->input->post('album'),
							'tgl_modifikasi'=>date('Y-m-d H:i:s'),
							'tipe'=>'album'
						);
						$this->crud->insert($table_name,$data_);
						$path = dirname(__FILE__)."/../../../../assets/img/album/";
						$name = $this->db->insert_id();
						$this->buatfolder($path,$name);
					}else{
						$data_ = array(
							'judul_id'=>$this->input->post('album')
						);
						$where=array(
							array(
								'where_field'=>'id_tulisan',
								'where_key'=>$this->input->post('id')
							)
						);
						$this->crud->update($table_name,$data_,$where);
					}
					$data['psn'] = 'Album berhasil disimpan';
					$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Album gagal disimpan';
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
				'log'=>'album',
				'status_log'=>'tambah album:'.$this->input->post('album'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['data'] = $this->album();
		echo json_encode($data);
	}

	public function sampahalbum(){
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
	            	$data['psn'] = 'Album berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Album gagal dihapus';
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
				'log'=>'album',
				'status_log'=>'hapus album:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->getalbum();
		echo json_encode($data);
	}

	public function delalbum(){
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

	            	$path = dirname(__FILE__)."/../../../../assets/img/album/";
	            	$name = $this->input->post('id');
	            	$this->hapusfolder($path,$name);
	            	$data['psn'] = 'Album berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Album gagal dihapus';
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
				'log'=>'album',
				'status_log'=>'hapus permane album:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->getalbum();
		echo json_encode($data);
	}

	public function prevalbum(){
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
	            		'status_tulisan'=>'draft'
	            	);
	            	$where=array(
	            		array(
	            			'where_field'=>'id_tulisan',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->update($table_name,$data,$where);
	            	$data['psn'] = 'Album berhasil disembunyikan';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Album gagal disembunyikan';
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
				'log'=>'album',
				'status_log'=>'kembalikan album:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->getalbum();
		echo json_encode($data);
	}

	public function tampilkanalbum(){
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
	            		'status_tulisan'=>'terbit'
	            	);
	            	$where=array(
	            		array(
	            			'where_field'=>'id_tulisan',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->update($table_name,$data,$where);
	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	$data['psn'] = 'Album berhasil ditampilkan';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Album gagal ditampilkan';
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
				'log'=>'album',
				'status_log'=>'tampilkan album:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->getalbum();
		echo json_encode($data);
	}

	public function album($cari=null,$id=null,$id_kat=null){
		$tulisan_['tulisan']=null;
		$tulisan_['kat_tul']=null;
		$status_tulisan=null;
		$status_tulisan_=null;
		if($this->session->userdata('status_tulisan')=='sampah'){
			$status_tulisan = " WHERE `status_tulisan`='sampah'";
			$status_tulisan_ = " AND `status_tulisan`='sampah'";
		}else if($this->session->userdata('status_tulisan')=='terbit'){
			$status_tulisan = " WHERE `status_tulisan`='terbit'";
			$status_tulisan_ = " AND `status_tulisan`='terbit'";
		}else if($this->session->userdata('status_tulisan')=='konsep'){
			$status_tulisan = " WHERE `status_tulisan`='draft'";
			$status_tulisan_ = " AND `status_tulisan`='draft'";
		}else{
			$status_tulisan = " WHERE `status_tulisan`!='sampah'";
			$status_tulisan_ = " AND `status_tulisan`!='sampah'";
		}
		$table_name = 'tulisan';
		if($this->db->table_exists($table_name)){
			if($id!=null){
				$string = "SELECT * FROM `tulisan` WHERE `id_tulisan`=".$id.$status_tulisan_." AND `tipe`='album' ORDER BY `tgl_tulisan` DESC";
			}else if($cari!=null or $cari!=''){
				$string = "SELECT * FROM `tulisan` WHERE ((`judul_id` LIKE '%".$cari."%') or (`tulisan_id` LIKE '%".$cari."%'))".$status_tulisan_." AND `tipe`='album' ORDER BY `tgl_tulisan` DESC";
			}else{
				$string = "SELECT * FROM `tulisan`".$status_tulisan." AND `tipe`='album' ORDER BY `tgl_tulisan` DESC";
			}
			$tulisan_['tulisan'] = $this->crud->get(null,null,null,null,null,$string);
			if($tulisan_['tulisan']!=null){
				$tulisan_['error']=0;
				foreach($tulisan_['tulisan'] as $id){
					$table_name___='komentar';
					if($this->db->table_exists($table_name___)){
						$tulisan_['kom_tul'][$id['id_tulisan']]=null;
						$string__="SELECT * FROM `komentar` WHERE `id_tul`=".$id['id_tulisan'];
						$tulisan_['kom_tul'][$id['id_tulisan']]=$this->crud->get(null,null,null,null,null,$string__);
						if($tulisan_['kom_tul'][$id['id_tulisan']]!=null){
							$tulisan_['jml_kom_tul'][$id['id_tulisan']]=count($tulisan_['kom_tul'][$id['id_tulisan']]);
						}else{
							$tulisan_['jml_kom_tul'][$id['id_tulisan']]=0;
						}
					}
				}
			}
		}else{
			$tulisan_['error']='Tabel '.$table_name.' tidak ada!';
		}
		$tulisan_['tab_action']=$this->countalbum();
		return $tulisan_;
	}

	public function countalbum(){
		$tulisan_['semua']=null;
		$tulisan_['konsep']=null;
		$tulisan_['terbit']=null;
		$tulisan_['sampah']=null;
		if($this->db->table_exists('tulisan')){
			$string = "SELECT * FROM `tulisan` WHERE `status_tulisan`!='sampah' AND `tipe`='album'";
			$tulisan_['semua']=$this->crud->get(null,null,null,null,null,$string);
			if($tulisan_['semua']!=null){
				$tulisan_['semua']=count($tulisan_['semua']);
			}else{
				$tulisan_['semua']=0;
			}
			$string_="SELECT*FROM `tulisan` WHERE `status_tulisan`='terbit' AND `tipe`='album'";
			$tulisan_['terbit']=$this->crud->get(null,null,null,null,null,$string_);
			if($tulisan_['terbit']!=null){
				$tulisan_['terbit']=count($tulisan_['terbit']);
			}else{
				$tulisan_['terbit']=0;
			}
			$string__="SELECT*FROM `tulisan` WHERE `status_tulisan`='sampah' AND `tipe`='album'";
			$tulisan_['sampah']=$this->crud->get(null,null,null,null,null,$string__);
			if($tulisan_['sampah']!=null){
				$tulisan_['sampah']=count($tulisan_['sampah']);
			}else{
				$tulisan_['sampah']=0;
			}
			$string___="SELECT*FROM `tulisan` WHERE `status_tulisan`='draft' AND `tipe`='album'";
			$tulisan_['konsep']=$this->crud->get(null,null,null,null,null,$string___);
			if($tulisan_['konsep']!=null){
				$tulisan_['konsep']=count($tulisan_['konsep']);
			}else{
				$tulisan_['konsep']=0;
			}
		}

		return $tulisan_;
	}

	public function buatfolder($path,$name){
		//$new_dir = preg_replace("([^/w/s/d/-_~,;:/[/]/(/].]|[/.]{2,})", '', $_POST["dir"]);
		$new_dir = $path."/".$name;
		if((file_exists($new_dir))&&(is_dir($new_dir))){
			echo "Direktori <b>".$new_dir."</b> Sudah ada";
		}else{
			$handle = mkdir($new_dir);
		}
	}

	public function hapusfolder($path,$name){
		$target_dir = $path."/".$name;
		if((file_exists($target_dir))&&(is_dir($target_dir))){
			$handle = rmdir($target_dir);
		}else{
			echo "Direktori <b>".$target_dir."</b> Tidak ada";
		}
	}

	public function lihatgambar(){
		$data['psn']['gambar']='kosong';
		$path = dirname(__FILE__)."/../../../../assets/img/album/".$this->uri->segment(3);
		if((file_exists($path))&&(is_dir($path))){
			$data['psn']['path']=base_url('assets/img/album/'.$this->uri->segment(3));
			$data['psn']['gambar']=$this->lihatfolder($path);
		}
		echo json_encode($data['psn']);
	}

	public function delgambaralbum(){
		$data['psn'] = '';
		$data['psn']['gambar']='kosong';
		$img = $this->input->post('id');
		$img_smtr = explode('|',$img);
		$path = dirname(__FILE__)."/../../../../assets/img/album/".$img_smtr[1];
		$file = $img_smtr[0];
		$namafile = $path.'/'.$file;
		if(file_exists($namafile)){
			unlink ($namafile);
			$data['psn']['path']=base_url('assets/img/album/'.$img_smtr[1]);
			$data['psn']['gambar']=$this->lihatfolder($path);
			$data['psn']['folder']=$img_smtr[1];
			$data['wrng'] = 'success';
			//img db
			if($this->db->table_exists('gambar_album')){
				$where_img=array(
					array(
						'where_field'=>'nama_gambar',
						'where_key'=>$img_smtr[0]
					),
					array(
						'where_field'=>'folder',
						'where_key'=>$img_smtr[1]
					)
				);
				$this->crud->delete('gambar_album',$where_img);
			}
			//img db end
		}else{
			$data['psn'] = 'Gambar gagal dihapus';
			$data['wrng'] = 'danger';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'album',
				'status_log'=>'hapus gambar:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		echo json_encode($data['psn']);
	}

	public function addimage(){
		$data['psn']['tnd']=0;
		$data['psn']['gambar']='kosong';
		$path = dirname(__FILE__)."/../../../../assets/img/album/".$this->input->post('folder');
		if((file_exists($path))&&(is_dir($path))){
			chmod($path, 0755);
			$config['upload_path'] = "./assets/img/album/".$this->input->post('folder');
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
				$data['psn']['psn']='Gambar baru gagal disimpan.';
			}else{
				if(!$this->upload->do_upload('gambar_andalan')){
					$data['psn']['psn']['error'] =  $this->upload->display_errors();
				}else{
					$image_data = $this->upload->data();
					$data['psn']['psn']['status']='Gambar baru berhasil disimpan.';
					$data['psn']['tnd']=1;

					if((file_exists($path))&&(is_dir($path))){
					$data['psn']['path']=base_url('assets/img/album/'.$this->input->post('folder'));
					$data['psn']['gambar']=$this->lihatfolder($path);
					$data['wrng'] = 'success';
					//img db
					if($this->db->table_exists('gambar_album')){
						$data_img=array(
							'folder'=>$this->input->post('folder'),
							'nama_gambar'=>$name,
							'path_gambar'=>$data['psn']['path'],
							'tgl_gambar'=>date('Y-m-d h:i:s')
						);
						$this->crud->insert('gambar_album',$data_img);
						$where_img_=array(
							array(
								'where_field'=>'id_tulisan',
								'where_key'=>$this->input->post('folder')
							)
						);
						$data_img_a=array(
							'gambar_andalan'=>$name
						);
						$this->crud->update('tulisan',$data_img_a,$where_img_);
					}
					//img db end
				}else{
					$data['psn'] = 'Gambar gagal ditambahkan';
					$data['wrng'] = 'danger';
				}
				}
			}
		}else{
			$data['psn']['psn']='Direktori tidak ditemukan.';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'album',
				'status_log'=>'tambah gambar album:'.$name,
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end
		echo json_encode($data['psn']);
	}

	public function lihatfolder($path){
		$data='';
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

}

/* End of file album.php */
/* Location: ./application/controllers/album.php */