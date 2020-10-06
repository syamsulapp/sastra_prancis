<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('crud');
		//$this->load->library('Loginaut');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function index(){
		//$data['site']=$this->web();
		$data['site']['page']='Halaman Utama';
		$data['modules']='web';
		$data['content']='v_web_baru';
		//$this->load->view('\\../../template/template_baru.php', $data);
		//$data['content']='v_web';
		$this->load->view('welcome_message',$data);
	}

	public function kosong(){
		$data['site']=$this->web();
		$data['site']['page']='Halaman Kosong';
		$data['modules']='web';
		$data['content']='v_web_kosong';
		$this->load->view('welcome_message',$data);
	}

	public function web(){
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */