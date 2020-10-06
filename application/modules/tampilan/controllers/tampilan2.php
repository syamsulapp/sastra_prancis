<?php

class Tampilan extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('crud');
		$this->load->dbutil();
		//$this->load->library('Loginaut');
	}

	function index(){
		$this->menu();
	}

	//menu
	function menu(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'tampilan',
				'status_log'=>'lihat menu',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['site']=$this->web();
		$data['site']['page']='Tampilan Menu';
		$data['modules']='tampilan';
		$data['content']='v_menu';
		$this->load->view('../../template/template', $data);
	}

	//header
	function website(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'tampilan',
				'status_log'=>'lihat website',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['site']=$this->web();
		$data['site']['page']='Tampilan Website';
		$data['modules']='tampilan';
		$data['content']='v_header';
		$this->load->view('../../template/template', $data);
	}

	//banner
	function banner(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'tampilan',
				'status_log'=>'lihat banner',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['site']=$this->web();
		$data['site']['page']='Tampilan Banner';
		$data['modules']='tampilan';
		$data['content']='v_banner';
		$this->load->view('../../template/template', $data);
	}

	//template
	function template(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'tampilan',
				'status_log'=>'lihat template',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['site']=$this->web();
		$data['site']['page']='Tampilan Template';
		$data['modules']='tampilan';
		$data['content']='v_lainnya';
		$this->load->view('../../template/template', $data);
	}

	function simpanHTML(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
        $catatan = trim($this->input->post('template_web'));
        $BASEDIR = dirname(BASEPATH);
        $nBASEDIR   = $BASEDIR .'/application/modules/template/template_baru.php';
        if($sch_file_handle = @fopen($nBASEDIR, "w+")){
			@fwrite($sch_file_handle, $catatan); 
			@fclose($sch_file_handle);
			$data['psn'] = 'Template berhasil disimpan';
	        $data['wrng'] = 'success';
		}else{
			$data['psn'] = 'Template gagal disimpan';
			$data['wrng'] = 'warning';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'tampilan',
				'status_log'=>'simpan template HTML',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		redirect('tampilan/template');
	}

	function simpanCSS(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		$catatan_2 = trim($this->input->post('css_web'));
        $BASEDIR_2 = dirname(BASEPATH);
        $nBASEDIR_2   = $BASEDIR_2 .'/assets/css/css_ku.css';
        if($sch_file_handle_2 = @fopen($nBASEDIR_2, "w+")){
			@fwrite($sch_file_handle_2, $catatan_2); 
			@fclose($sch_file_handle_2);
			$data['psn'] = 'CSS berhasil disimpan';
	        $data['wrng'] = 'success';
		}else{
			$data['psn'] = 'CSS gagal disimpan';
			$data['wrng'] = 'warning';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'tampilan',
				'status_log'=>'simpan template CSS',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		redirect('tampilan/template');
	}

	//slide
	function gambar_bergerak(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'tampilan',
				'status_log'=>'lihat gambar bergerak',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['site']=$this->web();
		$data['site']['page']='Tampilan Gambar Bergerak';
		$data['modules']='tampilan';
		$data['content']='v_gambar_bergerak';
		$this->load->view('../../template/template', $data);
	}

	//menu function
	function getmenu(){
		$data['data'] = null;
		$data['data'] = $this->menu_();
		echo json_encode($data);
	}

	function getmenuall(){
		$data['data'] = null;
		$data['data'] = $this->menu_();
		echo json_encode($data);
	}

	function getmenuutama(){
		$data['data'] = null;
		$data['data'] = $this->menu_(null,'utama');
		echo json_encode($data);
	}

	function getmenuatas(){
		$data['data'] = null;
		$data['data'] = $this->menu_(null,'atas');
		echo json_encode($data);
	}

	function getmenubawah(){
		$data['data'] = null;
		$data['data'] = $this->menu_(null,'bawah');
		echo json_encode($data);
	}

	function addmenu(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
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

					if($this->input->post('id_menu')==''){
						$data = array(
							'kategori'=>$this->input->post('nama_menu'),
							'slug'=>$slug,
							'parent'=>$this->input->post('induk_menu'),
							'tipe_kategori'=>'menu',
							'posisi'=>$this->input->post('posisi_menu'),
							'jenis'=>$this->input->post('jenis_menu'),
							'icon'=>$this->input->post('icon_menu')
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
							'icon'=>$this->input->post('icon_menu')
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
					$data['psn'] = 'Menu '.$this->input->post('nama_menu').' berhasil disimpan';
	            	$data['wrng'] = 'success';
				}else{
					$data['psn'] = 'Menu gagal disimpan';
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
				'log'=>'tampilan',
				'status_log'=>'tambah menu:'.$this->input->post('nama_menu'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['data'] = $this->menu_();
		echo json_encode($data);
	}

	function delmenu(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
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
	            	$data['psn'] = 'Menu berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Menu gagal dihapus';
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
				'log'=>'tampilan',
				'status_log'=>'hapus menu:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->menu_();
		echo json_encode($data);
	}

	function delmenumassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id_hapus_menu_massal_', 'id_hapus_menu_massal_', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('id_hapus_menu_massal_');
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
	            	$data['psn'] = 'Menu berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Menu gagal dihapus';
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
				'log'=>'tampilan',
				'status_log'=>'hapus menu massal',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['data'] = $this->menu_();
		echo json_encode($data);
	}

	function searchmenu(){
		$data['data'] = null;
		$data['data'] = $this->menu_($this->input->post('cari_menu'));
		echo json_encode($data);
	}

	function menu_($cari=null,$posisi=null){
		if($this->input->post('id_kat')!=''){
			$parent=$this->input->post('id_kat');
		}else{
			$parent=0;
		}
		if($this->input->post('pagging')){
			$limit='limit '.$this->input->post('pagging');
		}else{
			$limit='';
		}
		if($this->input->post('cari_menu')==''){
			$cari=null;
		}else{
			$cari=$this->input->post('cari_menu');
		}
		if($posisi!=null){
			$pos_menu="AND `posisi`='".$posisi."'";
		}else{
			$pos_menu="";
		}
		$menu_['menu']=null;
		$table_name = 'kategori';
		if($this->db->table_exists($table_name)){
			$menu_['error']=0;
			if($cari==null){
				$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='menu'".$pos_menu." AND `parent`=".$parent." ".$limit;
			}else if($cari==''){
				$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='menu'".$pos_menu." AND `parent`=".$parent." ".$limit;
			}else{
				$string = "SELECT * FROM `kategori` WHERE `kategori` LIKE '%".$cari."%' AND `tipe_kategori`='menu'".$pos_menu." AND `parent`=".$parent." ".$limit;
			}
			$menu_['menu'] = $this->crud->get(null,null,null,null,null,$string);
			if($menu_['menu']!=null){
				foreach($menu_['menu'] as $row){
					$menu_['parent'][$row['parent']][$row['id_kategori']] = null;
					$menu_1=null;
					$menu_2=null;
					$menu_3=null;
					$string_1 = "SELECT * FROM `hub_menu_sub` JOIN `kategori` ON `hub_menu_sub`.`id_kat`=`kategori`.`id_kategori` WHERE `hub_menu_sub`.`kat_order`='kategori' AND `hub_menu_sub`.`id_tul`=".$row['id_kategori']." AND `kategori`.`id_kategori`!=".$row['id_kategori']." AND `kategori`.`tipe_kategori`='category' ORDER BY `kategori`.`id_kategori` ASC";
					$string_2 = "SELECT * FROM `hub_menu_sub` JOIN `tulisan` ON `hub_menu_sub`.`id_kat`=`tulisan`.`id_tulisan` WHERE (`hub_menu_sub`.`kat_order`='album' OR `hub_menu_sub`.`kat_order`='halaman') AND `hub_menu_sub`.`id_tul`=".$row['id_kategori']." AND (`tulisan`.`tipe`='page' OR `tulisan`.`tipe`='album') ORDER BY `tulisan`.`id_tulisan` ASC";
					$string_3 = "SELECT * FROM `kategori` WHERE `parent`=".$row['id_kategori']." AND `tipe_kategori`='menu' ORDER BY `id_kategori` ASC";
					if($this->db->table_exists('hub_menu_sub')&&$this->db->table_exists('kategori')&&$this->db->table_exists('tulisan')){
						$data_1 = $this->crud->get(null,null,null,null,null,$string_1);
						$menu_1 = $data_1;

						$data_2 = $this->crud->get(null,null,null,null,null,$string_2);
						$menu_2 = $data_2;

						$data_3 = $this->crud->get(null,null,null,null,null,$string_3);
						$menu_3 = $data_3;

						if($menu_1!=null&&$menu_2!=null&&$menu_3!=null){
							$menu_['parent'][$row['parent']][$row['id_kategori']] = array_merge($menu_1,$menu_2,$menu_3);
						}else if($menu_1!=null&&$menu_2!=null&&$menu_3==null){
							$menu_['parent'][$row['parent']][$row['id_kategori']] = array_merge($menu_1,$menu_2);
						}else if($menu_1!=null&&$menu_2==null&&$menu_3!=null){
							$menu_['parent'][$row['parent']][$row['id_kategori']] = array_merge($menu_1,$menu_3);
						}else if($menu_1==null&&$menu_2!=null&&$menu_3!=null){
							$menu_['parent'][$row['parent']][$row['id_kategori']] = array_merge($menu_2,$menu_3);
						}else if($menu_1!=null&&$menu_2==null&&$menu_3==null){
							$menu_['parent'][$row['parent']][$row['id_kategori']] = $menu_1;
						}else if($menu_1==null&&$menu_2!=null&&$menu_3==null){
							$menu_['parent'][$row['parent']][$row['id_kategori']] = $menu_2;
						}else if($menu_1==null&&$menu_2==null&&$menu_3!=null){
							$menu_['parent'][$row['parent']][$row['id_kategori']] = $menu_3;
						}else{
							$menu_['parent'][$row['parent']][$row['id_kategori']] = null;
						}
					}
				}
				$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='menu' AND `parent`='0'";
				$menu_['semua']=$this->crud->get(null,null,null,null,null,$string);
				if($menu_['semua']!=null){
					$menu_['semua']=count($menu_['semua']);
				}else{
					$menu_['semua']=0;
				}
			}else{
				$menu_['error']='Menu tidak ada!';
			}
		}else{
			$menu_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $menu_;
	}

	//slide function
	function getslide(){
		$data['data'] = null;
		$data['data'] = $this->slide_();
		echo json_encode($data);
	}

	function addslide(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
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

					$id_kat = $this->input->post('checkbox_img');
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
					$data['psn'] = 'Gambar bergerak '.$this->input->post('nama_gambar_bergerak').' berhasil disimpan';
					$data['wrng'] = 'success';
				}else{
					$data['psn'] = 'Gambar bergerak gagal disimpan';
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
				'log'=>'tampilan',
				'status_log'=>'tambah slide:'.$this->input->post('nama_gambar_bergerak'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['data'] = $this->slide_();
		echo json_encode($data);
	}

	function delslide(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
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
	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	if($this->db->table_exists('hub_slide_img')){
						$where_=array(
							array(
								'where_field'=>'id_tul',
								'where_key'=>$this->input->post('id')
							)
						);
						$this->crud->delete('hub_slide_img',$where_);
					}
	            	$data['psn'] = 'Gambar bergerak berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Gambar bergerak gagal dihapus';
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
				'log'=>'tampilan',
				'status_log'=>'hapus slide:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->slide_();
		echo json_encode($data);
	}

	function delslidemassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id_hapus_gambar_bergerak_massal_', 'id_hapus_gambar_bergerak_massal_', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('id_hapus_gambar_bergerak_massal_');
	            	foreach($id as $id_){
	            		if($this->input->post('aksi_tindakan_massal_atas')=='hps' or $this->input->post('aksi_tindakan_massal_bawah')=='hps'){
			            	$where=array(
			            		array(
			            			'where_field'=>'id_kategori',
			            			'where_key'=>$id_
			            		)
			            	);
			            	$this->crud->delete($table_name,$where);
			            	if($this->db->table_exists('hub_slide_img')){
								$where_=array(
									array(
										'where_field'=>'id_tul',
										'where_key'=>$id_
									)
								);
								$this->crud->delete('hub_slide_img',$where_);
							}
			            }
		            }
	            	$data['psn'] = 'Gambar bergerak berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Gambar bergerak gagal dihapus';
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
				'log'=>'tampilan',
				'status_log'=>'hapus slide massal',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['data'] = $this->slide_();
		echo json_encode($data);
	}

	function tampilkanslide(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$data_=array(
	            		'status_kategori'=>'close'
	            	);
	            	$where_=array(
	            		array(
	            			'where_field'=>'tipe_kategori',
	            			'where_key'=>'slide'
	            		)
	            	);
	            	$this->crud->update($table_name,$data_,$where_);
	            	$data=array(
	            		'status_kategori'=>'open'
	            	);
	            	$where=array(
	            		array(
	            			'where_field'=>'id_kategori',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->update($table_name,$data,$where);
	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	$data['psn'] = 'Slide berhasil ditampilkan';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Slide gagal diditampilkan';
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
				'log'=>'tampilan',
				'status_log'=>'tampilkan slide:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->slide_();
		echo json_encode($data);
	}

	function prevslide(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$element = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id', 'id', 'required');
	            if ($this->form_validation->run()){
	            	$data=array(
	            		'status_kategori'=>'close'
	            	);
	            	$where=array(
	            		array(
	            			'where_field'=>'id_kategori',
	            			'where_key'=>$this->input->post('id')
	            		)
	            	);
	            	$this->crud->update($table_name,$data,$where);
	            	$element = $this->input->post('element_kembali').$this->input->post('id');
	            	$data['psn'] = 'Slide berhasil disembunyikan';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Slide gagal disembunyikan';
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
				'log'=>'tampilan',
				'status_log'=>'sembunyikan slide:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->slide_();
		echo json_encode($data);
	}

	function searchslide(){
		$data['data'] = null;
		$data['data'] = $this->slide_($this->input->post('cari_slide'));
		echo json_encode($data);
	}

	function slide_($cari=null){
		$slide_['slide']=null;
		$table_name = 'kategori';
		if($this->db->table_exists($table_name)){
			$slide_['error']=0;
			if($cari==null){
				$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='slide'";
			}else if($cari==''){
				$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='slide'";
			}else{
				$string = "SELECT * FROM `kategori` WHERE `kategori` LIKE '%".$cari."%' AND `tipe_kategori`='slide'";
			}
			$slide_['slide'] = $this->crud->get(null,null,null,null,null,$string);
			if($slide_['slide']!=null){
				foreach($slide_['slide'] as $row){
					$slide__1=null;
					$string_ = "SELECT * FROM `hub_slide_img` WHERE `id_tul`=".$row['id_kategori'];
					if($this->db->table_exists('hub_slide_img')){
						$data_ = $this->crud->get(null,null,null,null,null,$string_);
						$slide__1 = $data_;

						if($slide__1!=null){
							$slide_['parent'][$row['parent']][$row['id_kategori']] = $slide__1;
						}else{
							$slide_['parent'][$row['parent']][$row['id_kategori']] = null;
						}
					}
				}
			}else{
				$slide_['error']='Gambar bergerak tidak ada!';
			}
		}else{
			$slide_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $slide_;
	}

	//web function
	function updateweb(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['status'] = null;
		$data['judul'] = null;
		$data['deskripsi'] = null;
		$table_name='web';
		if($this->db->table_exists($table_name)){
			//status
			if($this->input->post('status_judul_web')=='true'){
				$status='true';
			}else{
				$status='false';
			}
			$data['bgjdlsts']=array(
				'option_name'=>'blogstatusjudul',
				'option_value'=>$status
			);
        	$where_bgjdlsts=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogstatusjudul'
        		)
        	);
        	$data['status']=$this->crud->get($table_name,$where_bgjdlsts);
        	if($data['status']!=null){
        		$this->crud->update($table_name,$data['bgjdlsts'],$where_bgjdlsts);
        	}else{
        		$this->crud->insert($table_name,$data['bgjdlsts']);
        	}

			//judul
			$data['bgnm']=array(
				'option_name'=>'blogname',
				'option_value'=>$this->input->post('judul_web')
			);
        	$where_bgnm=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogname'
        		)
        	);
        	$data['judul']=$this->crud->get($table_name,$where_bgnm);
        	if($data['judul']!=null){
        		$this->crud->update($table_name,$data['bgnm'],$where_bgnm);
        	}else{
        		$this->crud->insert($table_name,$data['bgnm']);
        	}

        	//deskripsi
        	$data['bgdes']=array(
        		'option_name'=>'blogdescription',
				'option_value'=>$this->input->post('deskripsi_web')
			);
        	$where_bgdes=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogdescription'
        		)
        	);
        	$data['deskripsi']=$this->crud->get($table_name,$where_bgdes);
        	if($data['deskripsi']!=null){
        		$this->crud->update($table_name,$data['bgdes'],$where_bgdes);
        	}else{
        		$this->crud->insert($table_name,$data['bgdes']);
        	}

        	//alamat
			$data['bgadrs']=array(
				'option_name'=>'blogaddress',
				'option_value'=>$this->input->post('alamat')
			);
        	$where_bgadrs=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogaddress'
        		)
        	);
        	$data['alamat']=$this->crud->get($table_name,$where_bgadrs);
        	if($data['alamat']!=null){
        		$this->crud->update($table_name,$data['bgadrs'],$where_bgadrs);
        	}else{
        		$this->crud->insert($table_name,$data['bgadrs']);
        	}

        	//tentang
			$data['bgtnt']=array(
				'option_name'=>'blogabout',
				'option_value'=>$this->input->post('tentang')
			);
        	$where_bgtnt=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogabout'
        		)
        	);
        	$data['tentang']=$this->crud->get($table_name,$where_bgtnt);
        	if($data['tentang']!=null){
        		$this->crud->update($table_name,$data['bgtnt'],$where_bgtnt);
        	}else{
        		$this->crud->insert($table_name,$data['bgtnt']);
        	}

        	//taghtml
			$data['bgtaghtml']=array(
				'option_name'=>'blogtaghtml',
				'option_value'=>$this->input->post('taghtml')
			);
        	$where_bgtaghtml=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogtaghtml'
        		)
        	);
        	$data['taghtml']=$this->crud->get($table_name,$where_bgtaghtml);
        	if($data['taghtml']!=null){
        		$this->crud->update($table_name,$data['bgtaghtml'],$where_bgtaghtml);
        	}else{
        		$this->crud->insert($table_name,$data['bgtaghtml']);
        	}

        	//footer format
			$data['bgff']=array(
				'option_name'=>'blogff',
				'option_value'=>$this->input->post('footer_format')
			);
        	$where_bgff=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogff'
        		)
        	);
        	$data['ff']=$this->crud->get($table_name,$where_bgff);
        	if($data['ff']!=null){
        		$this->crud->update($table_name,$data['bgff'],$where_bgff);
        	}else{
        		$this->crud->insert($table_name,$data['bgff']);
        	}

        	//no telp
			$data['bgtlp']=array(
				'option_name'=>'blogtlp',
				'option_value'=>$this->input->post('no_telp')
			);
        	$where_bgtlp=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogtlp'
        		)
        	);
        	$data['no_telp']=$this->crud->get($table_name,$where_bgtlp);
        	if($data['no_telp']!=null){
        		$this->crud->update($table_name,$data['bgtlp'],$where_bgtlp);
        	}else{
        		$this->crud->insert($table_name,$data['bgtlp']);
        	}

        	//gubernur
			$data['bggbr']=array(
				'option_name'=>'blogpemimpin',
				'option_value'=>$this->input->post('gubernur')
			);
        	$where_bggbr=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogpemimpin'
        		)
        	);
        	$data['nmgbr']=$this->crud->get($table_name,$where_bggbr);
        	if($data['nmgbr']!=null){
        		$this->crud->update($table_name,$data['bggbr'],$where_bggbr);
        	}else{
        		$this->crud->insert($table_name,$data['bggbr']);
        	}

        	//wgubernur
			$data['bgwgbr']=array(
				'option_name'=>'blogwpemimpin',
				'option_value'=>$this->input->post('w_gubernur')
			);
        	$where_bgwgbr=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogwpemimpin'
        		)
        	);
        	$data['wnmgbr']=$this->crud->get($table_name,$where_bgwgbr);
        	if($data['wnmgbr']!=null){
        		$this->crud->update($table_name,$data['bgwgbr'],$where_bgwgbr);
        	}else{
        		$this->crud->insert($table_name,$data['bgwgbr']);
        	}

        	//fgubernur
			$data['bgfgbr']=array(
				'option_name'=>'blogimgpemimpin',
				'option_value'=>$this->input->post('f_gubernur')
			);
        	$where_bgfgbr=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogimgpemimpin'
        		)
        	);
        	$data['fgbr']=$this->crud->get($table_name,$where_bgfgbr);
        	if($data['fgbr']!=null){
        		$this->crud->update($table_name,$data['bgfgbr'],$where_bgfgbr);
        	}else{
        		$this->crud->insert($table_name,$data['bgfgbr']);
        	}

        	//fwgubernur
			$data['bgfwgbr']=array(
				'option_name'=>'blogimgwpemimpin',
				'option_value'=>$this->input->post('f_w_gubernur')
			);
        	$where_bgfwgbr=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogimgwpemimpin'
        		)
        	);
        	$data['fwgbr']=$this->crud->get($table_name,$where_bgfwgbr);
        	if($data['fwgbr']!=null){
        		$this->crud->update($table_name,$data['bgfwgbr'],$where_bgfwgbr);
        	}else{
        		$this->crud->insert($table_name,$data['bgfwgbr']);
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
        	$data['blogimgheader2_']=$this->crud->get($table_name,$where_blogimgheader2);
        	if($data['blogimgheader2_']!=null){
        		$this->crud->update($table_name,$data['blogimgheader2'],$where_blogimgheader2);
        	}else{
        		$this->crud->insert($table_name,$data['blogimgheader2']);
        	}

        	//text berjalan
			$data['bgtb']=array(
				'option_name'=>'blogtextb',
				'option_value'=>$this->input->post('text_berjalan')
			);
        	$where_bgtb=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogtextb'
        		)
        	);
        	$data['tb']=$this->crud->get($table_name,$where_bgtb);
        	if($data['tb']!=null){
        		$this->crud->update($table_name,$data['bgtb'],$where_bgtb);
        	}else{
        		$this->crud->insert($table_name,$data['bgtb']);
        	}

        	$data['psn'] = 'Pengaturan web berhasil disimpan.';
        	$data['wrng'] = 'success';
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}
		$data['ses'] = $data['psn'];
		$this->session->set_userdata($data['psn']);
		redirect('tampilan/website');
	}

	function getweb(){
		$data['data'] = null;
		$data['data'] = $this->web();
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

	//header function
	function gambarheader(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'tampilan',
				'status_log'=>'lihat website',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['imgheader']=null;
		$table_name='web';
		if($this->db->table_exists($table_name)){
			$data['imghd']=array(
				'option_name'=>'blogimgheader',
				'option_value'=>$this->input->post('gambar_andalan')
			);
        	$where_imghd=array(
        		array(
        			'where_field'=>'option_name',
        			'where_key'=>'blogimgheader'
        		)
        	);
        	$data['imgheader']=$this->crud->get($table_name,$where_imghd);
        	if($data['imgheader']!=null){
        		$this->crud->update($table_name,$data['imghd'],$where_imghd);
        	}else{
        		$this->crud->insert($table_name,$data['imghd']);
        	}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}
		$data['gambarandalan'] = $this->input->post('gambar_andalan');
		echo json_encode($data);
	}

	function delgambarheader(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$table_name='web';
		if($this->db->table_exists($table_name)){
			$data_ = array(
				'option_name'=>'blogimgheader',
				'option_value'=>''
			);
			$where=array(
				array(
					'where_field'=>'option_name',
        			'where_key'=>'blogimgheader'
				)
			);
			$this->crud->update($table_name,$data_,$where);
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}

		//log
		if($this->db->table_exists('log')){
			$data_=array(
				'id_user'=>$this->session->userdata('id_pengguna'),
				'log'=>'tampilan',
				'status_log'=>'hapus website',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['gambarandalan'] = '';
		echo json_encode($data);
	}

	//icon function
	function gambaricon(){
		$data['gambarandalan'] = $this->input->post('gambar_andalan');
		echo json_encode($data);
	}

	function getbanner(){
		$data['data'] = null;
		$data['data'] = $this->banner_();
		echo json_encode($data);
	}

	function getbannerutama(){
		$data['data'] = null;
		$data['data'] = $this->banner_('utama');
		echo json_encode($data);
	}

	function getbannertulisan(){
		$data['data'] = null;
		$data['data'] = $this->banner_('tulisan');
		echo json_encode($data);
	}

	function getbannerhalaman(){
		$data['data'] = null;
		$data['data'] = $this->banner_('halaman');
		echo json_encode($data);
	}

	function banner_($posisi=null){
		if($this->input->post('pagging')){
			$limit='limit '.$this->input->post('pagging');
		}else{
			$limit='';
		}
		if($posisi!=null){
			$pos_banner="WHERE `posisi`='".$posisi."'";
		}else{
			$pos_banner="";
		}
		$banner_['banner']=null;
		$table_name = 'banner';
		if($this->db->table_exists($table_name)){
			$banner_['error']=0;
			$string = "SELECT * FROM `banner` ".$pos_banner." ORDER BY `id_banner` DESC ".$limit;
			$banner_['banner'] = $this->crud->get(null,null,null,null,null,$string);
			if($banner_['banner']!=null){
				$string = "SELECT * FROM `banner`";
				$banner_['semua']=$this->crud->get(null,null,null,null,null,$string);
				if($banner_['semua']!=null){
					$banner_['semua']=count($banner_['semua']);
				}else{
					$banner_['semua']=0;
				}
			}else{
				$banner_['error']='Menu tidak ada!';
			}
		}else{
			$banner_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $banner_;
	}

	function addbanner(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
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
					$data['psn'] = 'Banner '.$this->input->post('nama_banner').' berhasil disimpan';
	            	$data['wrng'] = 'success';
				}else{
					$data['psn'] = 'Banner gagal disimpan';
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
				'log'=>'tampilan',
				'status_log'=>'tambah banner:'.$this->input->post('icon_banner'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['data'] = $this->banner_();
		echo json_encode($data);
	}

	function delbannermassal(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='banner';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id_hapus_banner_massal_', 'id_hapus_banner_massal_', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('id_hapus_banner_massal_');
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
	            	$data['psn'] = 'Banner berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Banner gagal dihapus';
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
				'log'=>'tampilan',
				'status_log'=>'hapus banner massal',
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['data'] = $this->banner_();
		echo json_encode($data);
	}

	function delbanner(){
		if($this->session->userdata('is_logged_in')!='login'||$this->session->userdata('level')!='administrator'){
			redirect('errors');
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
	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	$data['psn'] = 'Banner berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Banner gagal dihapus';
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
				'log'=>'tampilan',
				'status_log'=>'hapus banner:'.$this->input->post('id'),
				'tgl_log'=>date('Y-m-d h:i:s')
			);
			$this->crud->insert('log',$data_);
		}
		//log end

		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->banner_();
		echo json_encode($data);
	}

	function setslide(){
		$table_name='web';
		if($this->db->table_exists($table_name)){
			$data['dslide']=array(
				'option_name'=>'blogslide',
				'option_value'=>$this->input->post('id')
			);
	    	$where_bgslide=array(
	    		array(
	    			'where_field'=>'option_name',
	    			'where_key'=>'blogslide'
	    		)
	    	);
	    	$data['slide']=$this->crud->get($table_name,$where_bgslide);
	    	if($data['slide']!=null){
	    		$this->crud->update($table_name,$data['dslide'],$where_bgslide);
	    	}else{
	    		$this->crud->insert($table_name,$data['dslide']);
	    	}
	    	$data['psn'] = 'Format gambar bergerak berhasil disimpan.';
        	$data['wrng'] = 'success';
	    }else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}
		$data['ses'] = $data['psn'];
		$this->session->set_userdata($data['psn']);
		echo json_encode($data);
	}

}

/* End of file tampilan.php */
/* Location: ./application/controllers/tampilan.php */