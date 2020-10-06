<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Underconstruction extends CI_Controller {

	function __construct() {
		parent::__construct();

		$sts_w = $this->status_website();
		if(@$sts_w[0]['option_value']&&$sts_w[0]['option_value']=='on'){
			redirect(site_url());
		}
	}

	function index() {
		$string		 = "SELECT * FROM `web` WHERE `option_name` = 'underconstruction'";
		$img['img']  = $this->crud->get(null,null,null,null,null,$string);
		$this->load->view('underconstruction',$img);
	}

	function status_website(){
		$string = "SELECT * FROM `web` WHERE `option_name` = 'status_website'";
		$sts_w  = $this->crud->get(null,null,null,null,null,$string);
		return $sts_w;
	}
}
