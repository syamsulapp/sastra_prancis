<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Statistik_perpusda extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
	}

	function index(){
		$this->dk();
	}

	function dk(){
		$data 					= $this->setting->get_jml();
		$data['site']			= $this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	= 'Statistik Data Keanggotaan';
		$data['modules']		= 'statistik_perpusda';
		$data['content']		= 'v_statistik_perpusda';
		$data['statistik']		= $this->crud->get('perpusda_statistik',array(array('where_field'=>'tahun','where_key'=>date('Y')),array('where_field'=>'jenis','where_key'=>'dk')));
		$data['jenis']			= 'dk';
		$this->load->view('../../template/template', $data);
	}

	function pengp(){
		$data 					= $this->setting->get_jml();
		$data['site']			= $this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	= 'Statistik Pengunjung Perpustakaan';
		$data['modules']		= 'statistik_perpusda';
		$data['content']		= 'v_statistik_perpusda';
		$data['statistik']		= $this->crud->get('perpusda_statistik',array(array('where_field'=>'tahun','where_key'=>date('Y')),array('where_field'=>'jenis','where_key'=>'pengp')));
		$data['jenis']			= 'pengp';
		$this->load->view('../../template/template', $data);
	}

	function pemp(){
		$data 					= $this->setting->get_jml();
		$data['site']			= $this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']	= 'Statistik Peminjam Perpustakaan';
		$data['modules']		= 'statistik_perpusda';
		$data['content']		= 'v_statistik_perpusda';
		$data['statistik']		= $this->crud->get('perpusda_statistik',array(array('where_field'=>'tahun','where_key'=>date('Y')),array('where_field'=>'jenis','where_key'=>'pemp')));
		$data['jenis']			= 'pemp';
		$this->load->view('../../template/template', $data);
	}

	function simpan(){
		$post = $this->input->post();
		$table_name = 'perpusda_statistik';
		if($post['id']==''){
			$data = array(
				'jenis'=>$post['jenis'],
				'tahun'=>date('Y'),
				'l1'=>$post['L'][1],
				'l2'=>$post['L'][2],
				'l3'=>$post['L'][3],
				'l4'=>$post['L'][4],
				'l5'=>$post['L'][5],
				'l6'=>$post['L'][6],
				'l7'=>$post['L'][7],
				'l8'=>$post['L'][8],
				'l9'=>$post['L'][9],
				'l10'=>$post['L'][10],
				'l11'=>$post['L'][11],
				'l12'=>$post['L'][12],
				'p1'=>$post['P'][1],
				'p2'=>$post['P'][2],
				'p3'=>$post['P'][3],
				'p4'=>$post['P'][4],
				'p5'=>$post['P'][5],
				'p6'=>$post['P'][6],
				'p7'=>$post['P'][7],
				'p8'=>$post['P'][8],
				'p9'=>$post['P'][9],
				'p10'=>$post['P'][10],
				'p11'=>$post['P'][11],
				'p12'=>$post['P'][12]
			);
			$this->crud->insert($table_name,$data);
		}else{
			$where=array(
				array(
					'where_field'=>'id_perpusda_statistik',
					'where_key'=>$post['id']
				)
			);
			$data = array(
				'jenis'=>$post['jenis'],
				'tahun'=>date('Y'),
				'l1'=>$post['L'][1],
				'l2'=>$post['L'][2],
				'l3'=>$post['L'][3],
				'l4'=>$post['L'][4],
				'l5'=>$post['L'][5],
				'l6'=>$post['L'][6],
				'l7'=>$post['L'][7],
				'l8'=>$post['L'][8],
				'l9'=>$post['L'][9],
				'l10'=>$post['L'][10],
				'l11'=>$post['L'][11],
				'l12'=>$post['L'][12],
				'p1'=>$post['P'][1],
				'p2'=>$post['P'][2],
				'p3'=>$post['P'][3],
				'p4'=>$post['P'][4],
				'p5'=>$post['P'][5],
				'p6'=>$post['P'][6],
				'p7'=>$post['P'][7],
				'p8'=>$post['P'][8],
				'p9'=>$post['P'][9],
				'p10'=>$post['P'][10],
				'p11'=>$post['P'][11],
				'p12'=>$post['P'][12]
			);
			$this->crud->update($table_name,$data,$where);
		}

		redirect('statistik_perpusda/'.$post['jenis']);
	}

}

/* End of file statistik_perpusda.php */
/* Location: ./application/controllers/statistik_perpusda.php */