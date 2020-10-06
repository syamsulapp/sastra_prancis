<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Label extends MX_Controller{

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
		$data['site']['page']='Label';
		$data['modules']='label';
		$data['content']='v_label';
		$this->load->view('../../template/template', $data);
	}

	function getlabel(){
		$data['data'] = null;
		$data['data'] = $this->label();
		echo json_encode($data);
	}

	function addlabel(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('nama_label', 'nama_label', 'required');
	            if ($this->form_validation->run()){
					if($this->input->post('id_label')==''){
						if($this->input->post('slug_label')!=''){
							$slug=$this->input->post('slug_label');
							$string="!@#$%^&*()_+{}[]:;<,.>/?|";
						    for($x=0;$x<strlen($string);$x++){
						    	$pecah=substr($string,$x,1);
						    	$slug=strtolower(str_replace($pecah,'-',$slug));
						    }
						    $slug=strtolower(str_replace(' ','-',$slug));
						}else{
							$slug=$this->input->post('nama_label');
							$string=" !@#$%^&*()_+{}[]:;<,.>/?|";
						    for($x=0;$x<strlen($string);$x++){
						    	$pecah=substr($string,$x,1);
						    	$slug=strtolower(str_replace($pecah,'-',$slug));
						    }
						    $slug=strtolower(str_replace(' ','-',$slug));
						}
						$data = array(
							'kategori'=>$this->input->post('nama_label'),
							'slug'=>$slug,
							'icon'=>$this->input->post('icon_menu'),
							'deskripsi'=>$this->input->post('deskripsi_label'),
							'tipe_kategori'=>'label'
						);
						$this->crud->insert($table_name,$data);
					}else{
						if($this->input->post('slug_label')!=''){
							$slug=$this->input->post('slug_label');
							$string="!@#$%^&*()_+{}[]:;<,.>/?|";
						    for($x=0;$x<strlen($string);$x++){
						    	$pecah=substr($string,$x,1);
						    	$slug=strtolower(str_replace($pecah,'-',$slug));
						    }
						    $slug=strtolower(str_replace(' ','-',$slug));
						}else{
							$slug=$this->input->post('nama_label');
							$string=" !@#$%^&*()_+{}[]:;<,.>/?|";
						    for($x=0;$x<strlen($string);$x++){
						    	$pecah=substr($string,$x,1);
						    	$slug=strtolower(str_replace($pecah,'-',$slug));
						    }
						    $slug=strtolower(str_replace(' ','-',$slug));
						}
						$data = array(
							'kategori'=>$this->input->post('nama_label'),
							'slug'=>$slug,
							'icon'=>$this->input->post('icon_menu'),
							'deskripsi'=>$this->input->post('deskripsi_label'),
							'tipe_kategori'=>'label'
						);
						$where=array(
							array(
								'where_field'=>'id_kategori',
								'where_key'=>$this->input->post('id_label')
							)
						);
						$this->crud->update($table_name,$data,$where);
					}
					$data['psn'] = 'Format '.$this->input->post('nama_label').' berhasil disimpan';
					$data['wrng'] = 'success';
				}else{
					$data['psn'] = 'Format gagal disimpan';
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
		$data['data'] = $this->label();
		echo json_encode($data);
	}

	function dellabel(){
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
	            	$data['psn'] = 'Format berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Format gagal dihapus';
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
		$data['data'] = $this->label();
		echo json_encode($data);
	}

	function dellabelmassal(){
		if($this->session->userdata('is_logged_in')!='login'){
			redirect('home/errors');
		}
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name='kategori';
		if($this->db->table_exists($table_name)){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('id_hapus_label_massal_', 'id_hapus_label_massal_', 'required');
	            if ($this->form_validation->run()){
	            	$id = $this->input->post('id_hapus_label_massal_');
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
	            	$data['psn'] = 'Format berhasil dihapus';
	            	$data['wrng'] = 'success';
	            }else{
					$data['psn'] = 'Format gagal dihapus';
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
		$data['data'] = $this->label();
		echo json_encode($data);
	}

	function searchlabel(){
		$data['data'] = null;
		$data['data'] = $this->label($this->input->post('cari_label'));
		echo json_encode($data);
	}

	function label($cari=null){
		$label_['label']=null;
		if($this->input->post('id_kat')!=''){
			$parent=$this->input->post('id_kat');
		}else{
			$parent=0;
		}
		$table_name = 'kategori';
		if($this->db->table_exists($table_name)){
			$label_['error']=0;
			if($cari==null){
				$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='label' AND `parent`=".$parent;
			}else if($cari==''){
				$string = "SELECT * FROM `kategori`  WHERE `tipe_kategori`='label' AND `parent`=".$parent;
			}else{
				$string = "SELECT * FROM `kategori` WHERE `kategori` LIKE '%".$cari."%' AND `tipe_kategori`='label' AND `parent`=".$parent;
			}
			$label_['label'] = $this->crud->get(null,null,null,null,null,$string);
		}else{
			$label_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $label_;
	}

}

/* End of file label.php */
/* Location: ./application/controllers/label.php */