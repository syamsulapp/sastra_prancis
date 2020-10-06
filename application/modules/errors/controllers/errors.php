<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Errors extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
	}

	function index(){
		$data = $this->setting->get_jml();
		$data['site'] = $this->setting->web();
		$data['menu'] = $this->setting->menu('utama');
		if(isset($data['site']['web']['blogslide'])&&$data['site']['web']['blogslide']!='pilihan'){
			$data['slide'] = $this->setting->carousel3($data['site']['web']['blogslide']);
		}else{
			$data['slide'] = $this->setting->carousel2();
		}
		// $komoditi = $this->crud->get('komoditi');
		// if($komoditi!=null){
		// 	foreach($komoditi as $row){
		// 		$where = array(array('where_field'=>'id_komoditi','where_key'=>$row['id_komoditi']));
		// 		$rule['order_by'] = 'DESC';
		// 		$rule['order_field'] = 'id_komoditi_harga';
		// 		$join = array(array('target_table'=>'komoditi','target_field'=>'id_komoditi','parent_field'=>'id_komoditi'));
		// 		$harga_komoditi = $this->crud->get('komoditi_harga',$where,$rule,$join);
		// 		if($harga_komoditi!=null){
		// 			if($harga_komoditi!=null){
		// 			$data['newsticker'][$row['id_komoditi']] = $harga_komoditi[0];
		// 		}
		// 		}
		// 	}
		// }
		$data['site']['page']='Halaman Bermasalah';
		$data['modules']='errors';
		$data['content']='v_error';
		$this->load->view('v_error', $data);
	}

}

/* End of file errors.php */
/* Location: ./application/controllers/errors.php */