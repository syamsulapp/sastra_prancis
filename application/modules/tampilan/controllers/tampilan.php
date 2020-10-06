<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Tampilan extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
	}

	function index(){
		$this->banner();
	}

	function banner(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Tampilan Banner';
		$data['data']			= $this->banner_db();
		$data['modules']		='tampilan';
		$data['content']		='v_banner';
		$this->load->view('../../template/template', $data);
	}

	function banner_db(){
		$banner_['banner']=null;
		$cari = "WHERE 1=1 ORDER BY `id_banner` DESC";
		$table_name = 'banner';
		if($this->db->table_exists($table_name)){
			$banner_['error']=0;
			$string = "SELECT * FROM `banner` ".$cari;
			$banner = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('tampilan/banner/index/page');
			$config['total_rows'] = count($banner);
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
			$banner_['pagging'] = $this->pagination->create_links();
			if($banner!=null){
				$banner_['total_rows'] = $config['total_rows'];
			}else{
				$banner_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `banner` ".$cari." limit ".$offset.",".$config['per_page'];
			$banner_['banner'] = $this->crud->get(null,null,null,null,null,$string_2);
			$banner_['no'] = $offset;
		}else{
			$banner_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $banner_;
	}

	function addbanner(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$id_kat = null;
		$table_name='banner';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('icon_banner', 'icon_banner', 'required');
	            if ($this->form_validation->run()){
	            	if($this->input->post('url_menu')!=''){
						$slug='http://'.str_replace('http://','',$this->input->post('url_menu'));
					}else{
					    $slug=site_url().'#';
					}
					if($this->input->post('id_banner')==''){
						$data = array(
							'gambar'=>$this->input->post('icon_banner'),
							'posisi'=>$this->input->post('posisi_banner'),
							'slug'=>$slug
						);
						$this->crud->insert($table_name,$data);
					}else{
						$data = array(
							'gambar'=>$this->input->post('icon_banner'),
							'posisi'=>$this->input->post('posisi_banner'),
							'slug'=>$slug
						);
						$where=array(
							array(
								'where_field'=>'id_banner',
								'where_key'=>$this->input->post('id_banner')
							)
						);
						$this->crud->update($table_name,$data,$where);
					}
	            	$this->session->set_flashdata('success','Banner '.$this->input->post('nama_banner').' berhasil disimpan');
				}else{
					$this->session->set_flashdata('warning','Banner gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/banner');
	}

	function delbanner(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='banner';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$where=array(
	            		array(
	            			'where_field'=>'id_banner',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','Banner berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','Banner gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/banner');
	}

	function delbannermassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='banner';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$where=array(
			            		array(
			            			'where_field'=>'id_banner',
			            			'where_key'=>$id_
			            		)
			            	);
			            	$this->crud->delete($table_name,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','Banner berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','Banner gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/banner');
	}

	function gambar_bergerak(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Tampilan Gambar Bergerak';
		$data['data']			= $this->gambar_bergerak_db();
		$data['tulisan']		=$this->crud->get(null,null,null,null,null,"SELECT `id_tulisan`,`judul_id`,`gambar_andalan` FROM `tulisan` WHERE (`tipe`!='album' AND `tipe`!='page') AND `status_tulisan`='terbit' AND `gambar_andalan`!='' ORDER BY `tgl_tulisan` DESC LIMIT 0,10");
		$data['gambar_andalan']	=$this->crud->get(null,null,null,null,null,"SELECT * FROM `gambar_andalan` ORDER BY `id_gambar_andalan` DESC LIMIT 0,50");
		$data['modules']		='tampilan';
		$data['content']		='v_gambar_bergerak';
		$this->load->view('../../template/template', $data);
	}

	function gambar_bergerak_db(){
		$gambar_bergerak_['gambar_bergerak']=null;
		$cari = "WHERE `tipe_kategori`='slide' ORDER BY `id_kategori` DESC";
		$table_name = 'kategori';
		if($this->db->table_exists($table_name)){
			$gambar_bergerak_['error']=0;
			$string = "SELECT * FROM `kategori` ".$cari;
			$gambar_bergerak = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('tampilan/gambar_bergerak/index/page');
			$config['total_rows'] = count($gambar_bergerak);
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
			$gambar_bergerak_['pagging'] = $this->pagination->create_links();
			if($gambar_bergerak!=null){
				$gambar_bergerak_['total_rows'] = $config['total_rows'];
			}else{
				$gambar_bergerak_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `kategori` ".$cari." limit ".$offset.",".$config['per_page'];
			$gambar_bergerak_['gambar_bergerak'] = $this->crud->get(null,null,null,null,null,$string_2);
			$gambar_bergerak_['no'] = $offset;
			if($gambar_bergerak_['gambar_bergerak']!=null){
				foreach ($gambar_bergerak_['gambar_bergerak'] as $row) {
					$data_=null;
					$string_ = "SELECT * FROM `hub_slide_img` WHERE `id_tul`=".$row['id_kategori'];
					if($this->db->table_exists('hub_slide_img')){
						$data_ = $this->crud->get(null,null,null,null,null,$string_);
						if($data_!=null){
							$gambar_bergerak_['img'][$row['id_kategori']] = $data_;
						}else{
							$gambar_bergerak_['img'][$row['id_kategori']] = null;
						}
					}
				}
			}
		}else{
			$gambar_bergerak_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $gambar_bergerak_;
	}

	function addgambar_bergerak(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('nama_gambar_bergerak', 'nama_gambar_bergerak', 'required');
	            if ($this->form_validation->run()){
					$slug=$this->input->post('nama_gambar_bergerak');
					$string=" !@#$%^&*()_+{}[]:;<,.>/?|";
				    for($x=0;$x<strlen($string);$x++){
				    	$pecah=substr($string,$x,1);
				    	$slug=strtolower(str_replace($pecah,'-',$slug));
				    }

					if($this->input->post('id_gambar_bergerak')==''){
						$data = array(
							'kategori'=>$this->input->post('nama_gambar_bergerak'),
							'slug'=>$slug,
							'tipe_kategori'=>'slide',
							'status_kategori'=>'close'
						);
						$this->crud->insert($table_name,$data);
						$id_tul = $this->db->insert_id();
					}else{
						$data = array(
							'kategori'=>$this->input->post('nama_gambar_bergerak'),
							'slug'=>$slug,
							'tipe_kategori'=>'slide'
						);
						$where=array(
							array(
								'where_field'=>'id_kategori',
								'where_key'=>$this->input->post('id_gambar_bergerak')
							)
						);
						$this->crud->update($table_name,$data,$where);
						$id_tul = $this->input->post('id_gambar_bergerak');
					}

					if($this->db->table_exists('hub_slide_img')){
						$where_=array(
							array(
								'where_field'=>'id_tul',
								'where_key'=>$id_tul
							)
						);
						$this->crud->delete('hub_slide_img',$where_);
					}

					$id_kat = $this->input->post('pilihan');
					foreach($id_kat as $row){
						$id = explode('|',$row);
						$data = array(
							'id_tul'=>$id_tul,
							'id_kat'=>$id[1].'|'.$id[2],
							'kat_order'=>$id[0]
						);
						if($this->db->table_exists('hub_slide_img')){
							$this->crud->insert('hub_slide_img',$data);
						}
						$data_ = array(
							'slug'=>''
						);
						$where_=array(
							array(
								'where_field'=>'id_kategori',
								'where_key'=>$id_tul
							)
						);
						$this->crud->update($table_name,$data_,$where_);
					}
					$this->session->set_flashdata('success','Gambar bergerak '.$this->input->post('nama_gambar_bergerak').' berhasil disimpan');
				}else{
					$this->session->set_flashdata('warning','Gambar bergerak gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/gambar_bergerak');
	}

	function delgambar_bergerak(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$where=array(
	            		array(
	            			'where_field'=>'id_kategori',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','Gambar bergerak berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','Gambar bergerak gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/gambar_bergerak');
	}

	function delgambar_bergerakmassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$where=array(
			            		array(
			            			'where_field'=>'id_kategori',
			            			'where_key'=>$id_
			            		)
			            	);
			            	$this->crud->delete($table_name,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','Gambar bergerak berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','Gambar bergerak gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/gambar_bergerak');
	}

	function sembunyikan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_kategori'=>'close'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_kategori',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Gambar bergerak berhasil disembunyikan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		redirect('tampilan/'.$this->uri->segment(4));
	}

	function tampilkan(){
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
        	$data=array(
        		'status_kategori'=>'open'
        	);
        	$where=array(
        		array(
        			'where_field'=>'id_kategori',
        			'where_key'=>$this->uri->segment(3)
        		)
        	);
        	$this->crud->update($table_name,$data,$where);
        	$data['psn'] = 'Gambar bergerak berhasil ditampilkan';
        	$data['wrng'] = 'success';
		}else{
			$data['psn']='Tabel '.$table_name.' tidak ada!';
			$data['wrng'] = 'success';
		}
		redirect('tampilan/'.$this->uri->segment(4));
	}

	//header
	function website(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Tampilan Website';
		$data['modules']		='tampilan';
		$data['content']		='v_website';
		$this->load->view('../../template/template', $data);
	}

	function updatewebsite(){
		// echo'<pre>';
		// print_r($this->input->post());
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['status'] = null;
		$data['judul'] = null;
		$data['deskripsi'] = null;
		$table_name='web';
		if($this->db->table_exists($table_name)){
			//blogimgheader
			$data['blogimgheader']=array(
				'option_name'=>'blogimgheader',
				'option_value'=>$this->input->post('blogimgheader')
			);
        	$where_blogimgheader=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogimgheader'
        		)
        	);
        	$data['cblogimgheader']=$this->crud->get($table_name,$where_blogimgheader);
        	if($data['cblogimgheader']!=null){
        		$this->crud->update($table_name,$data['blogimgheader'],$where_blogimgheader);
        	}else{
        		$this->crud->insert($table_name,$data['blogimgheader']);
        	}

        	//blogimgheader2
			$data['blogimgheader2']=array(
				'option_name'=>'blogimgheader2',
				'option_value'=>$this->input->post('blogimgheader2')
			);
        	$where_blogimgheader2=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogimgheader2'
        		)
        	);
        	$data['cblogimgheader2']=$this->crud->get($table_name,$where_blogimgheader2);
        	if($data['cblogimgheader2']!=null){
        		$this->crud->update($table_name,$data['blogimgheader2'],$where_blogimgheader2);
        	}else{
        		$this->crud->insert($table_name,$data['blogimgheader2']);
        	}

			//blogname
			$data['blogname']=array(
				'option_name'=>'blogname',
				'option_value'=>$this->input->post('blogname')
			);
        	$where_blogname=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogname'
        		)
        	);
        	$data['cblogname']=$this->crud->get($table_name,$where_blogname);
        	if($data['cblogname']!=null){
        		$this->crud->update($table_name,$data['blogname'],$where_blogname);
        	}else{
        		$this->crud->insert($table_name,$data['blogname']);
        	}

        	//blogdescription
        	$data['blogdescription']=array(
        		'option_name'=>'blogdescription',
				'option_value'=>$this->input->post('blogdescription')
			);
        	$where_blogdescription=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogdescription'
        		)
        	);
        	$data['cblogdescription']=$this->crud->get($table_name,$where_blogdescription);
        	if($data['cblogdescription']!=null){
        		$this->crud->update($table_name,$data['blogdescription'],$where_blogdescription);
        	}else{
        		$this->crud->insert($table_name,$data['blogdescription']);
        	}

        	//blogkeyword
			$data['blogkeyword']=array(
				'option_name'=>'blogkeyword',
				'option_value'=>$this->input->post('blogkeyword')
			);
        	$where_blogkeyword=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogkeyword'
        		)
        	);
        	$data['cblogkeyword']=$this->crud->get($table_name,$where_blogkeyword);
        	if($data['cblogkeyword']!=null){
        		$this->crud->update($table_name,$data['blogkeyword'],$where_blogkeyword);
        	}else{
        		$this->crud->insert($table_name,$data['blogkeyword']);
        	}

        	//blogalamat
			$data['blogalamat']=array(
				'option_name'=>'blogalamat',
				'option_value'=>$this->input->post('blogalamat')
			);
        	$where_blogalamat=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogalamat'
        		)
        	);
        	$data['cblogalamat']=$this->crud->get($table_name,$where_blogalamat);
        	if($data['cblogalamat']!=null){
        		$this->crud->update($table_name,$data['blogalamat'],$where_blogalamat);
        	}else{
        		$this->crud->insert($table_name,$data['blogalamat']);
        	}

        	//blogpemimpin
			$data['blogpemimpin']=array(
				'option_name'=>'blogpemimpin',
				'option_value'=>$this->input->post('blogpemimpin')
			);
        	$where_blogpemimpin=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogpemimpin'
        		)
        	);
        	$data['cblogpemimpin']=$this->crud->get($table_name,$where_blogpemimpin);
        	if($data['cblogpemimpin']!=null){
        		$this->crud->update($table_name,$data['blogpemimpin'],$where_blogpemimpin);
        	}else{
        		$this->crud->insert($table_name,$data['blogpemimpin']);
        	}

        	//blogwpemimpin
			$data['blogwpemimpin']=array(
				'option_name'=>'blogwpemimpin',
				'option_value'=>$this->input->post('blogwpemimpin')
			);
        	$where_blogwpemimpin=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogwpemimpin'
        		)
        	);
        	$data['cblogwpemimpin']=$this->crud->get($table_name,$where_blogwpemimpin);
        	if($data['cblogwpemimpin']!=null){
        		$this->crud->update($table_name,$data['blogwpemimpin'],$where_blogwpemimpin);
        	}else{
        		$this->crud->insert($table_name,$data['blogwpemimpin']);
        	}

        	//blogimgpemimpin
			$data['blogimgpemimpin']=array(
				'option_name'=>'blogimgpemimpin',
				'option_value'=>$this->input->post('blogimgpemimpin')
			);
        	$where_blogimgpemimpin=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogimgpemimpin'
        		)
        	);
        	$data['cblogimgpemimpin']=$this->crud->get($table_name,$where_blogimgpemimpin);
        	if($data['cblogimgpemimpin']!=null){
        		$this->crud->update($table_name,$data['blogimgpemimpin'],$where_blogimgpemimpin);
        	}else{
        		$this->crud->insert($table_name,$data['blogimgpemimpin']);
        	}

        	//blogimgwpemimpin
			$data['blogimgwpemimpin']=array(
				'option_name'=>'blogimgwpemimpin',
				'option_value'=>$this->input->post('blogimgwpemimpin')
			);
        	$where_blogimgwpemimpin=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogimgwpemimpin'
        		)
        	);
        	$data['cblogimgwpemimpin']=$this->crud->get($table_name,$where_blogimgwpemimpin);
        	if($data['cblogimgwpemimpin']!=null){
        		$this->crud->update($table_name,$data['blogimgwpemimpin'],$where_blogimgwpemimpin);
        	}else{
        		$this->crud->insert($table_name,$data['blogimgwpemimpin']);
        	}

        	//background
			$data['background']=array(
				'option_name'=>'background',
				'option_value'=>$this->input->post('background')
			);
        	$where_background=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'background'
        		)
        	);
        	$data['cbackground']=$this->crud->get($table_name,$where_background);
        	if($data['cbackground']!=null){
        		$this->crud->update($table_name,$data['background'],$where_background);
        	}else{
        		$this->crud->insert($table_name,$data['background']);
        	}

        	//background_s
			$data['background_s']=array(
				'option_name'=>'background_s',
				'option_value'=>$this->input->post('background_s')
			);
        	$where_background_s=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'background_s'
        		)
        	);
        	$data['cbackground_s']=$this->crud->get($table_name,$where_background_s);
        	if($data['cbackground_s']!=null){
        		$this->crud->update($table_name,$data['background_s'],$where_background_s);
        	}else{
        		$this->crud->insert($table_name,$data['background_s']);
        	}

        	//repeat
			$data['repeat']=array(
				'option_name'=>'repeat',
				'option_value'=>$this->input->post('repeat')
			);
        	$where_repeat=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'repeat'
        		)
        	);
        	$data['crepeat']=$this->crud->get($table_name,$where_repeat);
        	if($data['crepeat']!=null){
        		$this->crud->update($table_name,$data['repeat'],$where_repeat);
        	}else{
        		$this->crud->insert($table_name,$data['repeat']);
        	}

        	//fixed
			$data['fixed']=array(
				'option_name'=>'fixed',
				'option_value'=>$this->input->post('fixed')
			);
        	$where_fixed=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'fixed'
        		)
        	);
        	$data['cfixed']=$this->crud->get($table_name,$where_fixed);
        	if($data['cfixed']!=null){
        		$this->crud->update($table_name,$data['fixed'],$where_fixed);
        	}else{
        		$this->crud->insert($table_name,$data['fixed']);
        	}

        	//underconstruction
			$data['underconstruction']=array(
				'option_name'=>'underconstruction',
				'option_value'=>$this->input->post('underconstruction')
			);
        	$where_underconstruction=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'underconstruction'
        		)
        	);
        	$data['cunderconstruction']=$this->crud->get($table_name,$where_underconstruction);
        	if($data['cunderconstruction']!=null){
        		$this->crud->update($table_name,$data['underconstruction'],$where_underconstruction);
        	}else{
        		$this->crud->insert($table_name,$data['underconstruction']);
        	}

        	//blogfb
			$data['blogfb']=array(
				'option_name'=>'blogfb',
				'option_value'=>$this->input->post('blogfb')
			);
        	$where_blogfb=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogfb'
        		)
        	);
        	$data['cblogfb']=$this->crud->get($table_name,$where_blogfb);
        	if($data['cblogfb']!=null){
        		$this->crud->update($table_name,$data['blogfb'],$where_blogfb);
        	}else{
        		$this->crud->insert($table_name,$data['blogfb']);
        	}

        	//blogtw
			$data['blogtw']=array(
				'option_name'=>'blogtw',
				'option_value'=>$this->input->post('blogtw')
			);
        	$where_blogtw=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogtw'
        		)
        	);
        	$data['cblogtw']=$this->crud->get($table_name,$where_blogtw);
        	if($data['cblogtw']!=null){
        		$this->crud->update($table_name,$data['blogtw'],$where_blogtw);
        	}else{
        		$this->crud->insert($table_name,$data['blogtw']);
        	}

        	//bloggp
			$data['bloggp']=array(
				'option_name'=>'bloggp',
				'option_value'=>$this->input->post('bloggp')
			);
        	$where_bloggp=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'bloggp'
        		)
        	);
        	$data['cbloggp']=$this->crud->get($table_name,$where_bloggp);
        	if($data['cbloggp']!=null){
        		$this->crud->update($table_name,$data['bloggp'],$where_bloggp);
        	}else{
        		$this->crud->insert($table_name,$data['bloggp']);
        	}

        	$this->session->set_flashdata('success','Pengaturan web berhasil disimpan.');
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/website');
	}

	//menu
	function menu(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Tampilan Menu';

		$select = 'id_kategori,kategori,slug,parent,tipe_kategori,icon,posisi,jenis,no_urut';
		$where = array(array('where_field'=>'tipe_kategori','where_key'=>'menu'));
		$rule['order_field'] = 'no_urut';
		$rule['order_by'] = 'ASC';
		$menu					=$this->crud->get('kategori',$where,$rule,null,$select);
		if($menu!=null){
			$no=1;
			foreach ($menu as $row) {
				if($row['parent']==0){
					$data['urutan2'][$no] = $row['id_kategori'];
					$no++;
				}
				$data['menu'][$row['parent']][$row['id_kategori']] = $row;
				$string = "SELECT `tulisan`.`id_tulisan`,`tulisan`.`judul_id`,`tulisan`.`gambar_andalan`,`hub_menu_sub`.`kat_order`,`hub_menu_sub`.`id_kat` FROM `hub_menu_sub` JOIN `tulisan` ON `hub_menu_sub`.`id_kat`=`tulisan`.`id_tulisan` WHERE (`hub_menu_sub`.`kat_order`='album' OR `hub_menu_sub`.`kat_order`='halaman') AND `hub_menu_sub`.`id_tul`=".$row['id_kategori']." AND (`tulisan`.`tipe`='page' OR `tulisan`.`tipe`='album') ORDER BY `tulisan`.`id_tulisan` ASC";
				$data['submenu'][$row['id_kategori']] = $this->crud->get(null,null,null,null,null,$string);
			}
		}

		$select_hal = 'id_tulisan,judul_id';
		$where_hal = array(array('where_field'=>'tipe','where_key'=>'page'),array('where_field'=>'status_tulisan','where_key'=>'terbit'));
		$data['halaman']		=$this->crud->get('tulisan',$where_hal,null,null,$select_hal);

		$select_alb = '';
		$where_alb = array(array('where_field'=>'tipe','where_key'=>'album'),array('where_field'=>'status_tulisan','where_key'=>'terbit'));
		$data['album']			=$this->crud->get('tulisan',$where_alb,null,null,$select_hal);

		/*$select_kat = 'id_kategori,kategori';
		$where_kat = array(array('where_field'=>'tipe_kategori','where_key'=>'category'));
		$data['kategori']		=$this->crud->get('kategori',$where_kat,null,null,$select_kat);*/

		$data['modules']		='tampilan';
		$data['content']		='v_menu';
		$this->load->view('../../template/template', $data);
	}

	function addmenu(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$id_kat = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('nama_menu', 'nama_menu', 'required');
	            if ($this->form_validation->run()){
	            	if($this->input->post('url_menu')!=''){
						$slug='http://'.str_replace('http://','',$this->input->post('url_menu'));
					}else{
						$slug=$this->input->post('nama_menu');
						$string=" !@#$%^&*()_+{}[]:;<,.>/?|";
					    for($x=0;$x<strlen($string);$x++){
					    	$pecah=substr($string,$x,1);
					    	$slug=strtolower(str_replace($pecah,'-',$slug));
					    }
					    $slug=site_url();
					}

					// $where_[1] = array(
					// 	'where_field'=>'tipe_kategori',
					// 	'where_key'=>'menu'
					// );
					$rule['order_field'] = 'no_urut';
					$rule['order_by'] = 'desc';
					$rule['limit'] = 1;
					$check = $this->crud->get($table_name,null,$rule);
					if($check!=null){
						$no_urut = $check[0]['no_urut'] + 1;
					}else{
						$no_urut = 1;
					}

					if($this->input->post('id_menu')==''){
						$data = array(
							'kategori'=>$this->input->post('nama_menu'),
							'slug'=>$slug,
							'parent'=>$this->input->post('induk_menu'),
							'tipe_kategori'=>'menu',
							'posisi'=>$this->input->post('posisi_menu'),
							'jenis'=>$this->input->post('jenis_menu'),
							'icon'=>$this->input->post('icon_menu'),
							'no_urut'=>$no_urut
						);
						$this->crud->insert($table_name,$data);
						$id_tul = $this->db->insert_id();
					}else{
						$data = array(
							'kategori'=>$this->input->post('nama_menu'),
							'slug'=>$slug,
							'parent'=>$this->input->post('induk_menu'),
							'tipe_kategori'=>'menu',
							'posisi'=>$this->input->post('posisi_menu'),
							'jenis'=>$this->input->post('jenis_menu'),
							'icon'=>$this->input->post('icon_menu'),
							'no_urut'=>$no_urut
						);
						$where=array(
							array(
								'where_field'=>'id_kategori',
								'where_key'=>$this->input->post('id_menu')
							)
						);
						$this->crud->update($table_name,$data,$where);
						$id_tul = $this->input->post('id_menu');
					}

					if($this->db->table_exists('hub_menu_sub')){
						$where_=array(
							array(
								'where_field'=>'id_tul',
								'where_key'=>$id_tul
							)
						);
						$this->crud->delete('hub_menu_sub',$where_);
					}

					$id_kat = $this->input->post('checkbox_kat');
					if($id_kat!=null){
						foreach($id_kat as $row){
							$id = explode('-',$row);
							$data = array(
								'id_tul'=>$id_tul,
								'id_kat'=>$id[0],
								'kat_order'=>$id[1]
							);
							if($this->db->table_exists('hub_menu_sub')){
								$this->crud->insert('hub_menu_sub',$data);
							}
							$data_ = array(
								'slug'=>''
							);
							$where_=array(
								array(
									'where_field'=>'id_kategori',
									'where_key'=>$id_tul
								)
							);
							$this->crud->update($table_name,$data_,$where_);
						}
					}
	            	$this->session->set_flashdata('success','Menu '.$this->input->post('nama_menu').' berhasil disimpan');
				}else{
					$this->session->set_flashdata('warning','Menu gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/menu');
	}

	function delmenu(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$where=array(
	            		array(
	            			'where_field'=>'id_kategori',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->delete($table_name,$where);

	            	$where2=array(
	            		array(
	            			'where_field'=>'parent',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->delete($table_name,$where2);

	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	if($this->db->table_exists('hub_menu_sub')){
						$where_=array(
							array(
								'where_field'=>'id_tul',
								'where_key'=>$this->input->post('id')
							)
						);
						$this->crud->delete('hub_menu_sub',$where_);
					}
	            	$this->session->set_flashdata('success','Menu berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','Menu gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/menu');
	}

	function delmenumassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$where=array(
			            		array(
			            			'where_field'=>'id_kategori',
			            			'where_key'=>$id_
			            		)
			            	);
			            	$this->crud->delete($table_name,$where);

			            	$where2=array(
			            		array(
			            			'where_field'=>'parent',
			            			'where_key'=>$this->input->post('id')
			            		)
			            	);
			            	//$this->crud->delete($table_name,$where2);

			            	if($this->db->table_exists('hub_menu_sub')){
								$where_=array(
									array(
										'where_field'=>'id_tul',
										'where_key'=>$this->input->post('id')
									)
								);
								//$this->crud->delete('hub_menu_sub',$where_);
							}
			            }
		            }
	            	$this->session->set_flashdata('success','Menu berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','Menu gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/menu');
	}

	function newsticker(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Tampilan Newsticker';
		$data['data']			= $this->newsticker_db();
		$data['modules']		='tampilan';
		$data['content']		='v_newsticker';
		$this->load->view('../../template/template', $data);
	}

	function newsticker_db(){
		$newsticker_['newsticker']=null;
		$cari = "WHERE 1=1 ORDER BY `id_newsticker` DESC";
		$table_name = 'newsticker';
		if($this->db->table_exists($table_name)){
			$newsticker_['error']=0;
			$string = "SELECT * FROM `newsticker` ".$cari;
			$newsticker = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('tampilan/newsticker/index/page');
			$config['total_rows'] = count($newsticker);
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
			$newsticker_['pagging'] = $this->pagination->create_links();
			if($newsticker!=null){
				$newsticker_['total_rows'] = $config['total_rows'];
			}else{
				$newsticker_['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `newsticker` ".$cari." limit ".$offset.",".$config['per_page'];
			$newsticker_['newsticker'] = $this->crud->get(null,null,null,null,null,$string_2);
			$newsticker_['no'] = $offset;
		}else{
			$newsticker_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $newsticker_;
	}

	function addnewsticker(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$id_kat = null;
		$table_name='newsticker';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('url_menu', 'url_menu', 'required');
	            if ($this->form_validation->run()){
					if($this->input->post('id_newsticker')==''){
						$data = array(
							'newsticker'=>$this->input->post('url_menu'),
							'url'=>$this->input->post('url_action'),
						);
						$this->crud->insert($table_name,$data);
					}else{
						$data = array(
							'newsticker'=>$this->input->post('url_menu'),
							'url'=>$this->input->post('url_action'),
						);
						$where=array(
							array(
								'where_field'=>'id_newsticker',
								'where_key'=>$this->input->post('id_newsticker')
							)
						);
						$this->crud->update($table_name,$data,$where);
					}
	            	$this->session->set_flashdata('success','Newsticker '.$this->input->post('url_menu').' berhasil disimpan');
				}else{
					$this->session->set_flashdata('warning','Newsticker gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/newsticker');
	}

	function delnewsticker(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='newsticker';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$where=array(
	            		array(
	            			'where_field'=>'id_newsticker',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','Newsticker berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','Newsticker gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/newsticker');
	}

	function delnewstickermassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='newsticker';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$where=array(
			            		array(
			            			'where_field'=>'id_newsticker',
			            			'where_key'=>$id_
			            		)
			            	);
			            	$this->crud->delete($table_name,$where);
			            }
		            }
	            	$this->session->set_flashdata('success','Newsticker berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','Newsticker gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/newsticker');
	}

	function theme(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Tampilan Tema';
		$data['data']			= $this->theme_db();
		$data['modules']		='tampilan';
		$data['content']		='v_theme';
		$this->load->view('../../template/template', $data);
	}

	function theme_db(){
		$theme['theme']=null;
		$cari = "WHERE 1=1 ORDER BY `id_theme` DESC";
		$table_name = 'theme';
		if($this->db->table_exists($table_name)){
			$theme['error']=0;
			$string = "SELECT * FROM `theme` ".$cari;
			$theme = $this->crud->get(null,null,null,null,null,$string);
			$config['base_url'] = site_url('tampilan/theme/index/page');
			$config['total_rows'] = count($theme);
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
			$theme['pagging'] = $this->pagination->create_links();
			if($theme!=null){
				$theme['total_rows'] = $config['total_rows'];
			}else{
				$theme['total_rows'] = 0;
			}

			if($this->uri->segment(5)!=''){
				$offset=$this->uri->segment(5);
			}else{
				$offset=0;
			}
			$string_2 = "SELECT * FROM `theme` ".$cari." limit ".$offset.",".$config['per_page'];
			$theme['theme'] = $this->crud->get(null,null,null,null,null,$string_2);
			$theme['no'] = $offset;
		}else{
			$theme['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $theme;
	}

	function addtheme(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$dir = "themes";
		if(!is_dir($dir)){
			mkdir($dir,0777,TRUE);
		}
		$config['upload_path'] = "./".$dir;
		$config['allowed_types'] = 'zip';
		$config['remove_spaces'] = TRUE;
		if(!is_dir($config['upload_path'])){};
		$this->load->library('upload', $config);
		if($this->upload->do_upload('theme')){
			$this->load->library('unzip');
	        $this->unzip->extract('themes/'.$_FILES['theme']['name']);
	        $data_=array(
				'theme'=>str_replace('.zip','',$_FILES['theme']['name']),
				'status_theme'=>'close'
			);
			if($this->crud->insert('theme',$data_)){
				$path = dirname(__FILE__)."/../../../../themes";
        		$namafile = $path.'/'.$_FILES['theme']['name'];
				if(file_exists($namafile)){
					if(unlink ($namafile)){
						$this->session->set_flashdata('success','Tema berhasil disimpan.');
					}else{
						$this->session->set_flashdata('warning','ZIP Tema gagal dihapus.');
					}
				}
			}else{
				$this->session->set_flashdata('danger','Tema gagal disimpan.');
			}
		}else{
			$this->session->set_flashdata('danger','Tema gagal diunggah.');
		}

		redirect('tampilan/theme');
	}

	function settheme(){
		$data_=array(
			'status_theme'=>'close'
		);
		$this->crud->update('theme',$data_);
		$data_2=array(
			'status_theme'=>'open'
		);
		$where[1]=array(
			'where_field'=>'id_theme',
			'where_key'=>$this->uri->segment(3)
		);
		if($this->crud->update('theme',$data_2,$where)){
			$this->session->set_flashdata('success','Tema berhasil digunakan.');
		}else{
			$this->session->set_flashdata('danger','Tema gagal digunakan.');
		}
		redirect('tampilan/theme');
	}

	function deltheme(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='theme';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$where=array(
	            		array(
	            			'where_field'=>'id_theme',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->delete($table_name,$where);
	            	$path = dirname(__FILE__)."/../../../../themes/".$this->input->post('nm');
	            	echo $path;
	            	if(unlink($path)){
	            		$this->session->set_flashdata('success','Tema berhasil dihapus');
	            	}else{
	            		$this->session->set_flashdata('warning','Direktori Tema gagal dihapus');
	            	}
	            }else{
					$this->session->set_flashdata('warning','Tema gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/theme');
	}

	function delthememassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='theme';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$where=array(
			            		array(
			            			'where_field'=>'id_theme',
			            			'where_key'=>$id_
			            		)
			            	);
			            	$file = $this->crud->get('theme',$where);
			            	$this->crud->delete($table_name,$where);
			            	$path = dirname(__FILE__)."/../../../../themes/".$file[0]['theme'];
			            	if(rmdir($path)){
			            		$this->session->set_flashdata('success','Tema berhasil dihapus');
			            	}else{
			            		$this->session->set_flashdata('warning','Direktori Tema gagal dihapus');
			            	}
			            }
		            }
	            }else{
					$this->session->set_flashdata('warning','Tema gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/theme');
	}

	function widget(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data = $this->setting->get_jml();
		$data['site']			=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	='Tampilan Widget';
		$data['data1']			= $this->widget_db('kiri');
		$data['data2']			= $this->widget_db('kanan');
		$data['data3']			= $this->widget_db('bawah');
		$data['modules']		='tampilan';
		$data['content']		='v_widget';
		$this->load->view('../../template/template', $data);
	}

	function widget_db($posisi){
		$data_['data']=null;
		$cari = "WHERE `posisi_widget`='".$posisi."' ORDER BY `posisi_widget` ASC, `no_urut` ASC";
		$table_name = 'widget';
		if($this->db->table_exists($table_name)){
			$data_['error']=0;
			$string_2 = "SELECT * FROM `widget` ".$cari;
			$data_['data'] = $this->crud->get(null,null,null,null,null,$string_2);
		}else{
			$data_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $data_;
	}

	function addwidget(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$id_kat = null;
		$table_name='widget';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('widget', 'widget', 'required');
	            if ($this->form_validation->run()){
	            	$where_[1] = array(
						'where_field'=>'posisi_widget',
						'where_key'=>$this->input->post('posisi_widget')
					);
					$rule['order_field'] = 'id_widget';
					$rule['order_by'] = 'desc';
					$rule['limit'] = 1;
					$check = $this->crud->get($table_name,$where_,$rule);
					if($check!=null){
						$no_urut = $check[0]['no_urut'] + 1;
					}else{
						$no_urut = 1;
					}
					if($this->input->post('id_widget')==''){
						$data = array(
							'widget'=>$this->input->post('widget'),
							'nama_widget'=>$this->input->post('nama_widget'),
							'posisi_widget'=>$this->input->post('posisi_widget'),
							'content_widget'=>preg_replace("/[\"']/", "",$this->input->post('content_widget')).$this->input->post('jml_widget'),
							'no_urut'=>$no_urut
						);
						$this->crud->insert($table_name,$data);
					}else{
						$data = array(
							'widget'=>$this->input->post('widget'),
							'nama_widget'=>$this->input->post('nama_widget'),
							'posisi_widget'=>$this->input->post('posisi_widget'),
							'content_widget'=>preg_replace("/[\"']/", "",$this->input->post('content_widget')).$this->input->post('jml_widget')
						);
						$where[1]=array(
							'where_field'=>'id_widget',
							'where_key'=>$this->input->post('id_widget')
						);
						$this->crud->update($table_name,$data,$where);
					}
	            	$this->session->set_flashdata('success','Widget '.$this->input->post('nama_widget').' berhasil disimpan');
				}else{
					$this->session->set_flashdata('warning','Widget gagal disimpan');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/widget');
	}

	function getwidget(){
		$where[1]=array(
			'where_field'=>'id_widget',
			'where_key'=>$this->uri->segment(3)
		);
		echo json_encode($this->crud->get('widget',$where));
	}
	function delwidget(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='widget';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$where=array(
	            		array(
	            			'where_field'=>'id_widget',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->delete($table_name,$where);
	            	$this->session->set_flashdata('success','Widget berhasil dihapus');
	            }else{
					$this->session->set_flashdata('warning','Widget gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/widget');
	}

	function delwidgetmassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='widget';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('check_list', 'check_list', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('check_list');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$where=array(
			            		array(
			            			'where_field'=>'id_widget',
			            			'where_key'=>$id_
			            		)
			            	);
			            	$file = $this->crud->get('widget',$where);
			            	$this->crud->delete($table_name,$where);
			            	$this->session->set_flashdata('success','Widget berhasil dihapus');
			            }
		            }
	            }else{
					$this->session->set_flashdata('warning','Widget gagal dihapus');
				}
			}else{
				$this->session->set_flashdata('danger','ERROR!');
			}
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/widget');
	}

	function dragwidget(){
		$table_name='widget';
		if($this->db->table_exists($table_name)){
			$a = $this->uri->segment(3);
			$b = $this->uri->segment(4);
			$where_a[1] = array(
				'where_field'=>'id_widget',
				'where_key'=>$a
			);
			$aq = $this->crud->get('widget',$where_a);
			$where_b[1] = array(
				'where_field'=>'id_widget',
				'where_key'=>$b
			);
			$bq = $this->crud->get('widget',$where_b);

			$data_a = array(
				'no_urut'=>$bq[0]['no_urut']
			);
			$this->crud->update('widget',$data_a,$where_a);

			$data_b = array(
				'no_urut'=>$aq[0]['no_urut']
			);
			$this->crud->update('widget',$data_b,$where_b);

			$this->session->set_flashdata('success','Widget berhasil dipindah');
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/widget');
	}

	function dragmenu(){
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			$a = $this->uri->segment(3);
			$b = $this->uri->segment(4);
			$where_a[1] = array(
				'where_field'=>'id_kategori',
				'where_key'=>$a
			);
			$aq = $this->crud->get('kategori',$where_a);
			$where_b[1] = array(
				'where_field'=>'id_kategori',
				'where_key'=>$b
			);
			$bq = $this->crud->get('kategori',$where_b);

			$data_a = array(
				'no_urut'=>$bq[0]['no_urut']
			);
			$this->crud->update('kategori',$data_a,$where_a);

			$data_b = array(
				'no_urut'=>$aq[0]['no_urut']
			);
			$this->crud->update('kategori',$data_b,$where_b);

			$this->session->set_flashdata('success','Menu berhasil dipindah');
		}else{
			$this->session->set_flashdata('danger','Tabel '.$table_name.' tidak ada!');
		}
		redirect('tampilan/menu');
	}

}
/* End of file tampilan.php */
/* Location: ./application/controllers/tampilan.php */