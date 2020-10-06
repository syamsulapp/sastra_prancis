<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Kategori extends MX_Controller{

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
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Kategori';
		$data['modules']='kategori';
		$data['content']='v_kategori';
		$this->load->view('../../template/template', $data);
	}

	function getkategori(){
		$data['data'] = null;
		$data['data'] = $this->kategori();
		echo json_encode($data);
	}

	function addkategori(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('nama_kategori', 'nama_kategori', 'required');
	            if ($this->form_validation->run()){
					if($this->input->post('id_kategori')==''){
						if($this->input->post('slug_kategori')!=''){
							$slug=$this->input->post('slug_kategori');
							$string="!@#$%^&*()_+{}[]:;<,.>/?|";
						    for($x=0;$x<strlen($string);$x++){
						    	$pecah=substr($string,$x,1);
						    	$slug=strtolower(str_replace($pecah,'-',$slug));
						    }
						    $slug=strtolower(str_replace(' ','-',$slug));
						}else{
							$slug=$this->input->post('nama_kategori');
							$string=" !@#$%^&*()_+{}[]:;<,.>/?|";
						    for($x=0;$x<strlen($string);$x++){
						    	$pecah=substr($string,$x,1);
						    	$slug=strtolower(str_replace($pecah,'-',$slug));
						    }
						    $slug=strtolower(str_replace(' ','-',$slug));
						}
						$data = array(
							'kategori'=>$this->input->post('nama_kategori'),
							'slug'=>$slug,
							'icon'=>$this->input->post('icon_menu'),
							'parent'=>$this->input->post('induk_kategori'),
							'deskripsi'=>$this->input->post('deskripsi_kategori'),
							'tipe_kategori'=>'category'
						);
						$this->crud->insert($table_name,$data);
					}else{
						if($this->input->post('slug_kategori')!=''){
							$slug=$this->input->post('slug_kategori');
							$string="!@#$%^&*()_+{}[]:;<,.>/?|";
						    for($x=0;$x<strlen($string);$x++){
						    	$pecah=substr($string,$x,1);
						    	$slug=strtolower(str_replace($pecah,'-',$slug));
						    }
						    $slug=strtolower(str_replace(' ','-',$slug));
						}else{
							$slug=$this->input->post('nama_kategori');
							$string=" !@#$%^&*()_+{}[]:;<,.>/?|";
						    for($x=0;$x<strlen($string);$x++){
						    	$pecah=substr($string,$x,1);
						    	$slug=strtolower(str_replace($pecah,'-',$slug));
						    }
						    $slug=strtolower(str_replace(' ','-',$slug));
						}
						$data = array(
							'kategori'=>$this->input->post('nama_kategori'),
							'slug'=>$slug,
							'icon'=>$this->input->post('icon_menu'),
							'parent'=>$this->input->post('induk_kategori'),
							'deskripsi'=>$this->input->post('deskripsi_kategori'),
							'tipe_kategori'=>'category'
						);
						$where=array(
							array(
								'where_field'=>'id_kategori',
								'where_key'=>$this->input->post('id_kategori')
							)
						);
						$this->crud->update($table_name,$data,$where);
					}
					$data['psn'] = 'Kategori '.$this->input->post('nama_kategori').' berhasil disimpan';
					$data['wrng'] = 'success';
				}else{
					$data['psn'] = 'Kategori gagal disimpan';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}
		$data['ses'] = $data['psn'];
		$data['data'] = $this->kategori();
		echo json_encode($data);
	}

	function delkategori(){
		if($this->session->userdata('is_logged_in')!='login'){
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
	            	$element = $this->input->post('element_hapus').$this->input->post('id');
	            	$data['psn'] = 'Kategori berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Kategori gagal dihapus';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}
		$data['ses'] = $data['psn'];
		$data['element'] = $element;
		$data['data'] = $this->kategori();
		//echo json_encode($data);
		redirect('kategori');
	}

	function delkategorimassal(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id_hapus_kategori_massal_', 'id_hapus_kategori_massal_', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('id_hapus_kategori_massal_');
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
	            	$data['psn'] = 'Kategori berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Kategori gagal dihapus';
					$data['wrng'] = 'warning';
				}
			}else{
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		}else{
			$data['error']='Tabel '.$table_name.' tidak ada!';
		}
		$data['ses'] = $data['psn'];
		$data['data'] = $this->kategori();
		echo json_encode($data);
	}

	function searchkategori(){
		$data['data'] = null;
		$data['data'] = $this->kategori($this->input->post('cari_kategori'));
		echo json_encode($data);
	}

	function kategori($cari=null){
		$kategori_['kategori']=null;
		if($this->input->post('id_kat')!=''){
			$parent=$this->input->post('id_kat');
		}else{
			$parent=0;
		}
		$table_name = 'kategori';
		if($this->db->table_exists($table_name)){
			$kategori_['error']=0;
			if($cari==null){
				$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='category' AND `parent`=".$parent;
			}else if($cari==''){
				$string = "SELECT * FROM `kategori`  WHERE `tipe_kategori`='category' AND `parent`=".$parent;
			}else{
				$string = "SELECT * FROM `kategori` WHERE `kategori` LIKE '%".$cari."%' AND `tipe_kategori`='category' AND `parent`=".$parent;
			}
			$kategori_['kategori'] = $this->crud->get(null,null,null,null,null,$string);
		}else{
			$kategori_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $kategori_;
	}

}

/* End of file kategori.php */
/* Location: ./application/controllers/kategori.php */