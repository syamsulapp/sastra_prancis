<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/****************
 * Theme config
 *
 */

//This is the physical path to the themes (Thanks Marcus Reinhardt & Kristories, for the Mac and Linux fix)
$config['theme']['path'] = realpath(APPPATH .'../themes').'/';

//This is the url to the themes path
$config['theme']['url'] = trim(config_item('base_url'), '/ ') . '/themes/';

//This is the default theme (subfolder in the themes folder)
$config['theme']['theme'] = 'default';

//This is the default layout (index: a mapping to index.php)
$config['theme']['layout'] = 'index';

$CI = &get_instance();
$CI->load->database();
$cms = $CI->db->get('web')->result_array();
foreach($cms as $row){
	if(($row['option_name']=='blogimgpemimpin'||$row['option_name']=='blogimgwpemimpin'||$row['option_name']=='blogimgheader'||$row['option_name']=='blogimgheader2'||$row['option_name']=='background')&&$row['option_value']!=''){
		$config[$row['option_name']] = config_item('base_url').'/assets/img/img_andalan/'.$row['option_value'];
	}else{
		$config[$row['option_name']] = $row['option_value'];
	}
}

$b1 = $CI->db->where('slug','berita-1')->get('kategori')->row_array();
if($b1!=null&&@$b1['kategori']){
	$config['berita-1'] = $b1['kategori'];
}

$b2 = $CI->db->where('slug','berita-2')->get('kategori')->row_array();
if($b2!=null&&@$b2['kategori']){
	$config['berita-2'] = $b2['kategori'];
}
?>
