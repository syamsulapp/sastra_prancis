<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller
{

	private $limit = 15;

	function __construct()
	{
		parent::__construct();
		$this->load->library('cfpdf');

		$sts_w = $this->status_website();
		if (@$sts_w[0]['option_value'] && $sts_w[0]['option_value'] == 'off') {
			redirect('underconstruction');
		}
		$ses = array();
		if ($this->session->userdata('lang') == '') {
			$ses['lang'] = 'id';
		}
		if ($this->session->userdata('clang') == '') {
			$this->language('id');
		}
		$this->session->set_userdata($ses);
	}

	function path()
	{
		return base_url('assets/img/img_andalan/');
	}

	function status_website()
	{
		$string = "SELECT * FROM `web` WHERE `option_name` = 'status_website'";
		$sts_w  = $this->crud->get(null, null, null, null, null, $string);
		return $sts_w;
	}

	function index()
	{
		$ses['keywords']    = '';
		$ses['description'] = '';
		$ses['image']       = '';
		$this->session->set_userdata($ses);

		if ($this->session->userdata('lang') == '') {
			$ses['lang'] = 'id';
		}
		if ($this->session->userdata('clang') == '') {
			$this->language('id');
		}
		$this->session->set_userdata($ses);

		getTheme();
		$this->theme->set_theme(THEME);
		$data = null;
		$on_server = site_url() . $this->uri->segment('2');
		if ($on_server == site_url()) $data['is_home'] = 1;
		$this->theme->render('home', $data);
	}

	function language($lang)
	{
		$fl = base_url() . "assets/lang/$lang.json";
		$dict = @file_get_contents($fl);
		$ses['lang']        = $lang;
		$ses['clang']       = $dict;
		$this->session->set_userdata($ses);
		redirect('home');
	}

	function berita()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$cari = $this->input->post('pencarian');
		$this->session->set_flashdata('cari', $cari);
		$cont = '';
		$tipe = kategoriLabelBy('label', 'berita');
		$where[] = array(
			'where_field' => 'tipe',
			'where_key' => $tipe[0]['id_kategori']
		);
		if ($this->uri->segment(5) != 'preview') {
			$where[] = array(
				'where_field' => 'status_tulisan',
				'where_key' => 'terbit'
			);
		}
		if ($cari != '') {
			$rule['like_field'] = 'tulisan';
			$rule['like_key'] = $cari;
		} else {
			$rule = null;
		}
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_tulisan',
				'where_key' => $this->uri->segment(3)
			);
		}
		$join = array(
			array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			)
		);

		$tulisan_all = $this->crud->get('tulisan', $where, $rule, $join);

		$config['base_url'] = site_url() . 'home/berita/page/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = count($tulisan_all);
		$config['per_page'] = 10;
		$config['first_page'] = clang('First');
		$config['last_page'] = clang('Last');
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(4) != '') {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}

		$rule['order_field'] = 'tgl_tulisan';
		$rule['order_by'] = 'desc';
		$rule['limit'] = $config['per_page'];
		$rule['offset'] = $offset;

		$berita = $this->crud->get('tulisan', $where, $rule, $join);
		if ($berita != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $berita[0];

			if (isset($row['view'])) {
				$data_ = array(
					'view' => $row['view'] + 1
				);
				$where = array(
					array(
						'where_field' => 'id_tulisan',
						'where_key' => $row['id_tulisan']
					)
				);
				$this->crud->update('tulisan', $data_, $where);
			}

			if (isset($row['judul_' . $this->session->userdata('lang')])) {
				$ses['keywords'] = substr(str_replace(' ', ',', strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')])), 0, 150);
				$ses['description'] = substr(strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')]), 0, 250);
				$this->session->set_userdata($ses);
			}

			if (isset($row['gambar_andalan'])) {
				$ses['image'] = $this->path() . '/' . $row['gambar_andalan'];
				$this->session->set_userdata($ses);
			}

			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);

			$where_kat[] = array(
				'where_table' => 'hub_kat_tul',
				'where_field' => 'id_tul',
				'where_key' => $row['id_tulisan']
			);
			$where_kat[] = array(
				'where_table' => 'kategori',
				'where_field' => 'tipe_kategori',
				'where_key' => 'category'
			);
			$join_kat = array(
				array(
					'target_table' => 'kategori',
					'target_field' => 'id_kategori',
					'parent_field' => 'id_kat'
				)
			);
			$kat_tul = $this->crud->get('hub_kat_tul', $where_kat, null, $join_kat);
			$jml_kat = count($kat_tul);
			$kategori_1 = $kategori = '';
			if ($kat_tul != null) {
				$kat = '';
				$j = 1;
				foreach ($kat_tul as $row2) {
					if ($j == 1) {
						$kat .= '<a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					} else {
						$kat .= ', <a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					}
					if ($j == 1) {
						$kategori .= " (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ")";
					} else {
						$kategori .= " OR (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ")";
					}
					if ($kategori != '') {
						$kategori_1 = " (" . $kategori . ") AND ";
					}
					$j++;
				}
			} else {
				$kat = clang('Not categorized!');
			}

			$string__ = "SELECT DISTINCT `tulisan`.`id_tulisan`,`tulisan`.* FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE " . $kategori_1 . " `tipe`='" . $row['tipe'] . "' AND `tulisan`.`status_tulisan`='terbit' ORDER BY `tulisan`.`tgl_tulisan` DESC limit 3";
			$tul_lain = $this->crud->get(null, null, null, null, null, $string__);

			if ($row['status_komentar'] == 'open') {
				$where_kom[] = array(
					'where_field' => 'id_tul',
					'where_key' => $this->uri->segment(3)
				);
				$where_kom[] = array(
					'where_field' => 'status_komentar_',
					'where_key' => 'terbit'
				);
				$join_kom[1] = array(
					'target_table' => 'pengguna',
					'target_field' => 'id_pengguna',
					'parent_field' => 'id_user'
				);
				$komentar = $this->crud->get('komentar', $where_kom, null, $join_kom);
				if ($komentar != null) {
					$jml_kom = count($komentar);
					foreach ($komentar as $row_kom) {
						$kom_[$row_kom['parent_komentar']][$row_kom['id_komentar']] = $row_kom;
					}
				} else {
					$jml_kom = 0;
				}
			}


			//isi konten berita

			$cont .= '<section class="page_breadcrumbs ds parallax section_padding_top_100 section_padding_bottom_100">';
			$cont .= '	<div class="container">';
			$cont .= '		<div class="row">';
			$cont .= '			<div class="col-sm-12 text-center">';
			$cont .= '				<h2 class="highlight2">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h2>';
			$cont .= '				<ol class="breadcrumb darklinks">';
			$cont .= '					<li>';
			$cont .= '						<li class="breadcrumb-item"><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '						<li class="breadcrumb-item"><a href="' . site_url() . 'home/berita">' . clang('News') . '</a></li>';
			$cont .= '					</li>';
			$cont .= '					<li>';
			// syntax dibawah ini tidak digunakan
			// if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
			// 	$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
			// } else {
			// 	$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
			// }
			$cont .= '					</li>';
			$cont .= '				</ol>';
			$cont .= '			<div>';
			$cont .= '		</div>';
			$cont .= '	</div>';
			$cont .= '</section>';


			// PARTS::KONTEN BERITA NYA 

			$cont .= '<section class="ls section_padding_top_100 section_padding_bottom_100 columns_padding_25">';
			$cont .= '		<div class="container">';
			$cont .= '			<div class="row">';
			$cont .= '				<div class="col-sm-7 col-md-8 col-lg-8">';
			$cont .= '					<article class="single-post vertical-item post with_border content-padding big-padding">';
			$cont .= '						<div class="entry-thumbnail item-media">';
			if ($row['gambar_andalan'] != '') {
				$cont .= '		<img class="img-fluid" src="' . $this->path() . '/' . $row['gambar_andalan'] . '">';
			}
			$cont .= '						</div>';
			$cont .= '						<div class="item-content">';
			$cont .= '							<header class="entry-header">';
			$cont .= '								<div class="entry-meta small-text medium content-justify">';
			$cont .= '		  							 <span class="highlight2links">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '. ' . '</span>';
			$cont .= '		  							 <span class="highlight2links">' . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
			$cont .= '								</div>';
			$cont .= '							<h1 class="entry-title topmargin_0">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h1>';
			$cont .= '							</header>';
			$cont .= '							<div class="entry-content">';
			$cont .=								'<p>' . $row['tulisan_' . $this->session->userdata('lang')] . '</p>';
			$cont .= '							</div>';
			$cont .= '						</div>';
			$cont .= '					</article>';
			$cont .= '				</div>';
			// end berita

			// blok sidebar (widget)
			$cont .= '<aside class="col-sm-5 col-md-4 col-lg-4">';
			// sidebar berita populer
			$cont .= '		<div class="widget widget_popular_courses">';
			$cont .= '			<h3 class="widget-title">Berita Populer</h3>';
			$cont .= '			<ul class="media-list">';
			$cont .= '				<li class="media">';
			$cont .= '					<div class="media-left media-middle">';
			$cont .= '						<img>';
			$cont .= '					</div>';
			$cont .= '					<div class="media-body media-middle">';
			if ($tul_lain != null) {
				foreach ($tul_lain as $row2) {
					$cont .= '		<hr>';
					$cont .= '			<h4 class="entry-title"><a class="d-block date" href="' . site_url() . 'home/berita/' . $row2['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row2['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row2['judul_' . $this->session->userdata('lang')]) . ' </a></h4>';
				}
			}
			$cont .= '						<p class="small-text medium highlight2links">';
			$cont .= '						</p>';
			$cont .= '					</div>';
			$cont .= '				</li>';
			$cont .= '			</ul>';
			$cont .= '		</div>';
			// sidebar kategori
			$cont .= '		<div class="widget widget_popular_courses">';
			$cont .= '			<h3 class="widget-title">Kategori</h3>';
			$cont .= '				<ul class="media-list">';
			if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
				$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
			} else {
				$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
			}
			$cont .= '				</ul>';
			$cont .= '		</div>';
			// sidebar follow on
			$cont .= '		<div class="widget widget_popular_courses">';
			$cont .= '			<h3 class="widget-title">Follow On</h3>';
			$cont .= '				<div class="apsc-icons-wrapper clearfix apsc-theme-4">';
			$cont .= '					<div class="apsc-each-profile">';
			$cont .= '						<a class="apsc-facebook-icon clearfix" href="#">';
			$cont .= '							<div class="apsc-inner-block">';
			$cont .= '								<span class="social-icon">';
			$cont .= '									<i class="fa fa-facebook apsc-facebook"></i>';
			$cont .= '									<span class="media-name">Facebook</span>';
			$cont .= '								</span>';
			$cont .= '							</div>';
			$cont .= '					</div>';
			$cont .= '					<div class="apsc-each-profile">';
			$cont .= '						<a class="apsc-twitter-icon clearfix" href="#">';
			$cont .= '							<div class="apsc-inner-block">';
			$cont .= '								<span class="social-icon">';
			$cont .= '									<i class="fa fa-twitter apsc-twitter"></i>';
			$cont .= '									<span class="media-name">Twitter</span>';
			$cont .= '								</span>';
			$cont .= '							</div>';
			$cont .= '					</div>';
			$cont .= '					<div class="apsc-each-profile">';
			$cont .= '						<a class="apsc-instagram-icon clearfix" href="#">';
			$cont .= '							<div class="apsc-inner-block">';
			$cont .= '								<span class="social-icon">';
			$cont .= '									<i class="fa fa-instagram apsc-instagram"></i>';
			$cont .= '									<span class="media-name">Instagram</span>';
			$cont .= '								</span>';
			$cont .= '							</div>';
			$cont .= '					</div>';
			$cont .= '				</div>';
			$cont .= '		</div>';

			$cont .= '</aside>';
			$cont .= '			</div>';
			$cont .= '		</div>';
			$cont .= '</section>';




			// $cont .= '<div class="col-lg-8">';
			// $cont .= ' <div class="blog-detail">';
			// $cont .= '   <div class="blog-post">';
			// $cont .= '      <div class="blog-post-image">';
			// if ($row['gambar_andalan'] != '') {
			// 	$cont .= '		<img class="img-fluid" src="' . $this->path() . '/' . $row['gambar_andalan'] . '">';
			// }
			// $cont .= '      </div>';
			// $cont .= '		<div class="blog-post-content">';
			// $cont .= '		   <div class="blog-post-date"><span class="highlight2links">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span></div>';
			// $cont .= '         <h6 class="blog-post-title">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h6>';
			// $cont .= '      </div>';
			// $cont .= '   </div>';
			// $cont .= '  </div>';
			// $cont .= '<div class="blog-post-description text-center">';
			// $cont .=	'<p>' . $row['tulisan_' . $this->session->userdata('lang')] . '</p>';
			// $cont .= '</div>';

			// $cont .= '</div>';
			// $cont .= '</div>';

			// $cont .= '</div>';
			// $cont .= '</div>';
			// $cont .= '</section>';

			$cont .= $this->balas_komentar();

			$cont .= '	<div id="fb-root"></div>';
			$cont .= '	<script>(function(d, s, id) {';
			$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
			$cont .= '	  if (d.getElementById(id)) return;';
			$cont .= '	  js = d.createElement(s); js.id = id;';
			$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=364088984023158&version=v2.0";';
			$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
			$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
		} else if ($berita != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {
			// isi konten list berita di halaman
			$cont .= '<section class="page_breadcrumbs ds parallax section_padding_top_100 section_padding_bottom_100">';
			$cont .= '		<div class="container">';
			$cont .= '			<div class="row">';
			$cont .= '				<div class="col-sm-12 text-center">';
			$cont .= '					<h2 class="highlight2">List Berita</h2>';
			$cont .= '					<ol class="breadcrumb darklinks">';
			$cont .= '    						<li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    						<li>List</li>';
			$cont .= '    						<li class="active">Berita</li>';
			$cont .= '					</ol>';
			$cont .= '				</div>';
			$cont .= '			</div>';
			$cont .= '		</div>';
			$cont .= '</section>';

			// PARTS:: BEGIN TEMPLATE STATIC NOT DI LOOPING 
			$cont .= '<section class="space-ptb">';
			$cont .= '	<div class="container">';
			$cont .= '	  <div class="row">';

			foreach ($berita as $row) {
				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);
				if ($row['gambar_andalan'] != '') {
					$cont .= '<div class="col-md-5">';
					$cont .= '	<div class="item-media">';
					$cont .= '			<img class="img-fluid" src="' . $this->path() . '/' . $row['gambar_andalan'] . '" style="width:100%;">';
					$cont .= '		<div class="gradient_bg_color cs post-relater-person">';
					$cont .= '			<span class="playfair fontsize_18 bold"><i class="fa fa-clock-o">' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '</span></i>';
					$cont .= '		</div>';
					$cont .= '  </div>';
					$cont .= '  <div class="item-content">';
					$cont .= '  	<header class="entry-header">';
					$cont .= '  		<div class="content-justify vertical-center">';
					$cont .= '  			<span class="small-text medium highlight2"><i class="fa fa-user">' . clang('by') . ': ' . $row['nm_dp'] . '</span></i>';
					$cont .= '  		</div>';
					$cont .= '  		<h3 class="entry-title">';
					$cont .= '  			<a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . ' </a>';
					$cont .= '  		</h3>';
					$cont .= '  	</header>';
					$cont .= '				<p>' . substr(strip_tags($row['tulisan_' . $this->session->userdata('lang')]), 0, 200) . '...';
					$cont .= '					<a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '">' . clang('Read more') . '</a>';
					$cont .= '				</p>';
					$cont .= '  </div>';
					$cont .= '</div>';
					// END KONTEN
				} else {
					$cont .= '<div class="berita-detail" style="padding-bottom:10px; border-bottom:1px solid #EEE;">';
					$cont .= '	<h3 class="title-berita-detail"><a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . ' </a></h3>';
					$cont .= '	<div class="row">';
					$cont .= '		<div class="col-lg-12">';
					$cont .= '			<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
					$cont .= '			<p>' . substr(strip_tags($row['tulisan_' . $this->session->userdata('lang')]), 0, 200) . '...';
					$cont .= '				<a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '">' . clang('Read more') . '</a>';
					$cont .= '			</p>';
					$cont .= '		</div>';
					$cont .= '	</div>';
					$cont .= '</div>';
				}
			}
			$cont .= '	   </div>';

			$cont .= '	 </div>';
			$cont .= '</section>';
			// PARTS:: END TEMPLATE STATIC NOT DI LOOPING 

			$cont .= '<div class="berita-detail pagination">';
			$cont .= $halaman;
			$cont .= '</div>';
		} else {
			if ($cari != '') {
				$cont .= clang('News') . ' <b>' . $cari . '</b> ' . clang('not found!');
			} else {
				$cont .= clang('News') . ' ' . clang('not found!');
			}
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function berita_json()
	{
		$tipe = kategoriLabelBy('label', 'berita');
		$where[] = array(
			'where_field' => 'tipe',
			'where_key' => $tipe[0]['id_kategori']
		);
		$join = array(
			array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			)
		);

		$rule['order_field'] = 'tgl_tulisan';
		$rule['order_by'] = 'desc';
		$rule['limit'] = '7';

		$select = 'tulisan.id_tulisan,tulisan.judul_' . $this->session->userdata('lang');

		$berita = $this->crud->get('tulisan', $where, $rule, $join, $select);
		if ($berita != null) {
			echo json_encode($berita);
		}
	}

	function pengumuman()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$tipe = kategoriLabelBy('label', 'pengumuman');
		$where[] = array(
			'where_field' => 'tipe',
			'where_key' => $tipe[0]['id_kategori']
		);
		if ($this->uri->segment(5) != 'preview') {
			$where[] = array(
				'where_field' => 'status_tulisan',
				'where_key' => 'terbit'
			);
		}
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_tulisan',
				'where_key' => $this->uri->segment(3)
			);
		}
		$join = array(
			array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			)
		);

		$tulisan_all = $this->crud->get('tulisan', $where, null, $join);

		$config['base_url'] = site_url() . 'home/pengumuman/page/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = count($tulisan_all);
		$config['per_page'] = 10;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(4) != '') {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}

		$rule['order_field'] = 'tgl_tulisan';
		$rule['order_by'] = 'desc';
		$rule['limit'] = $config['per_page'];
		$rule['offset'] = $offset;

		$berita = $this->crud->get('tulisan', $where, $rule, $join);
		$cont = '';
		if ($berita != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $berita[0];

			if (isset($row['view'])) {
				$data_ = array(
					'view' => $row['view'] + 1
				);
				$where = array(
					array(
						'where_field' => 'id_tulisan',
						'where_key' => $row['id_tulisan']
					)
				);
				$this->crud->update('tulisan', $data_, $where);
			}

			if (isset($row['judul_' . $this->session->userdata('lang')])) {
				$ses['keywords'] = substr(str_replace(' ', ',', strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')])), 0, 150);
				$ses['description'] = substr(strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')]), 0, 250);
				$this->session->set_userdata($ses);
			}

			if (isset($row['gambar_andalan'])) {
				$ses['image'] = $this->path() . '/' . $row['gambar_andalan'];
				$this->session->set_userdata($ses);
			}

			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);

			$where_kat[] = array(
				'where_table' => 'hub_kat_tul',
				'where_field' => 'id_tul',
				'where_key' => $row['id_tulisan']
			);
			$where_kat[] = array(
				'where_table' => 'kategori',
				'where_field' => 'tipe_kategori',
				'where_key' => 'category'
			);
			$join_kat = array(
				array(
					'target_table' => 'kategori',
					'target_field' => 'id_kategori',
					'parent_field' => 'id_kat'
				)
			);
			$kat_tul = $this->crud->get('hub_kat_tul', $where_kat, null, $join_kat);
			$jml_kat = count($kat_tul);
			$kategori_1 = $kategori = '';
			if ($kat_tul != null) {
				$kat = '';
				$j = 0;
				$i = 1;
				foreach ($kat_tul as $row2) {
					if ($j == 0) {
						$kat .= '<a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					} else {
						$kat .= ', <a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					}
					if ($i == 1) {
						$kategori .= " (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ")";
					} else {
						$kategori .= " OR (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ")";
					}
					if ($kategori != '') {
						$kategori_1 = " (" . $kategori . ") AND ";
					}
					$i++;
					$j++;
				}
			} else {
				$kat = clang('Not categorized!');
			}

			$string__ = "SELECT DISTINCT `tulisan`.`id_tulisan`,`tulisan`.* FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE " . $kategori_1 . " `tipe`='" . $row['tipe'] . "' AND `tulisan`.`status_tulisan`='terbit' ORDER BY `tulisan`.`tgl_tulisan` DESC limit 3";
			$tul_lain = $this->crud->get(null, null, null, null, null, $string__);

			if ($row['status_komentar'] == 'open') {
				$where_kom[] = array(
					'where_field' => 'id_tul',
					'where_key' => $this->uri->segment(3)
				);
				$where_kom[] = array(
					'where_field' => 'status_komentar_',
					'where_key' => 'terbit'
				);
				$join_kom[1] = array(
					'target_table' => 'pengguna',
					'target_field' => 'id_pengguna',
					'parent_field' => 'id_user'
				);
				$komentar = $this->crud->get('komentar', $where_kom, null, $join_kom);
				if ($komentar != null) {
					$jml_kom = count($komentar);
					foreach ($komentar as $row_kom) {
						$kom_[$row_kom['parent_komentar']][$row_kom['id_komentar']] = $row_kom;
					}
				} else {
					$jml_kom = 0;
				}
			}

			// isi konten pengumuman::breadcumb
			$cont .= '<section class="page_breadcrumbs ds parallax section_padding_top_100 section_padding_bottom_100">';
			$cont .= '	<div class="container">';
			$cont .= '		<div class="row">';
			$cont .= '			<div class="col-sm-12 text-center">';
			$cont .= '				<h2 class="highlight2">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h2>';
			$cont .= '				<ol class="breadcrumb darklinks">';
			$cont .= '					<li>';
			$cont .= '						<li class="breadcrumb-item"><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '						<li class="breadcrumb-item"><a href="' . site_url() . 'home/pengumuman">' . clang('Pengumuman') . '</a></li>';
			$cont .= '					</li>';
			$cont .= '					<li>';
			// syntax dibawah ini tidak digunakan
			// if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
			// 	$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
			// } else {
			// 	$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
			// }
			$cont .= '					</li>';
			$cont .= '				</ol>';
			$cont .= '			<div>';
			$cont .= '		</div>';
			$cont .= '	</div>';
			$cont .= '</section>';


			// PARTS::KONTEN PENGUMUMANNYA 
			$cont .= '<section class="ls section_padding_top_100 section_padding_bottom_100 columns_padding_25">';
			$cont .= '		<div class="container">';
			$cont .= '			<div class="row">';
			$cont .= '				<div class="col-sm-7 col-md-8 col-lg-8">';
			$cont .= '					<article class="single-post vertical-item post with_border content-padding big-padding">';
			$cont .= '						<div class="entry-thumbnail item-media">';
			if ($row['gambar_andalan'] != '') {
				$cont .= '		<img class="img-fluid" src="' . $this->path() . '/' . $row['gambar_andalan'] . '">';
			}
			$cont .= '						</div>';
			$cont .= '						<div class="item-content">';
			$cont .= '							<header class="entry-header">';
			$cont .= '								<div class="entry-meta small-text medium content-justify">';
			$cont .= '		  							 <span class="highlight2links">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '. ' . '</span>';
			$cont .= '		  							 <span class="highlight2links">' . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
			$cont .= '								</div>';
			$cont .= '							<h1 class="entry-title topmargin_0">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h1>';
			$cont .= '							</header>';
			$cont .= '							<div class="entry-content">';
			$cont .=								'<p>' . $row['tulisan_' . $this->session->userdata('lang')] . '</p>';
			$cont .= '							</div>';
			$cont .= '						</div>';
			$cont .= '					</article>';
			$cont .= '				</div>';
			// end berita

			// blok sidebar (widget)
			$cont .= '<aside class="col-sm-5 col-md-4 col-lg-4">';
			// sidebar list pengumuman
			$cont .= '		<div class="widget widget_popular_courses">';
			$cont .= '			<h3 class="widget-title">List Pengumuman</h3>';
			$cont .= '			<ul class="media-list">';
			$cont .= '				<li class="media">';
			$cont .= '					<div class="media-left media-middle">';
			$cont .= '						<img>';
			$cont .= '					</div>';
			$cont .= '					<div class="media-body media-middle">';
			if ($tul_lain != null) {
				foreach ($tul_lain as $row2) {
					$cont .= '		<hr>';
					$cont .= '			<h4 class="entry-title"><a class="d-block date" href="' . site_url() . 'home/pengumuman/' . $row2['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row2['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row2['judul_' . $this->session->userdata('lang')]) . ' </a></h4>';
				}
			}
			$cont .= '						<p class="small-text medium highlight2links">';
			$cont .= '						</p>';
			$cont .= '					</div>';
			$cont .= '				</li>';
			$cont .= '			</ul>';
			$cont .= '		</div>';
			// sidebar kategori
			$cont .= '		<div class="widget widget_popular_courses">';
			$cont .= '			<h3 class="widget-title">Kategori</h3>';
			$cont .= '				<ul class="media-list">';
			if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
				$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
			} else {
				$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
			}
			$cont .= '				</ul>';
			$cont .= '		</div>';
			// sidebar follow on
			$cont .= '		<div class="widget widget_popular_courses">';
			$cont .= '			<h3 class="widget-title">Follow On</h3>';
			$cont .= '				<div class="apsc-icons-wrapper clearfix apsc-theme-4">';
			$cont .= '					<div class="apsc-each-profile">';
			$cont .= '						<a class="apsc-facebook-icon clearfix" href="#">';
			$cont .= '							<div class="apsc-inner-block">';
			$cont .= '								<span class="social-icon">';
			$cont .= '									<i class="fa fa-facebook apsc-facebook"></i>';
			$cont .= '									<span class="media-name">Facebook</span>';
			$cont .= '								</span>';
			$cont .= '							</div>';
			$cont .= '					</div>';
			$cont .= '					<div class="apsc-each-profile">';
			$cont .= '						<a class="apsc-twitter-icon clearfix" href="#">';
			$cont .= '							<div class="apsc-inner-block">';
			$cont .= '								<span class="social-icon">';
			$cont .= '									<i class="fa fa-twitter apsc-twitter"></i>';
			$cont .= '									<span class="media-name">Twitter</span>';
			$cont .= '								</span>';
			$cont .= '							</div>';
			$cont .= '					</div>';
			$cont .= '					<div class="apsc-each-profile">';
			$cont .= '						<a class="apsc-instagram-icon clearfix" href="#">';
			$cont .= '							<div class="apsc-inner-block">';
			$cont .= '								<span class="social-icon">';
			$cont .= '									<i class="fa fa-instagram apsc-instagram"></i>';
			$cont .= '									<span class="media-name">Instagram</span>';
			$cont .= '								</span>';
			$cont .= '							</div>';
			$cont .= '					</div>';
			$cont .= '				</div>';
			$cont .= '		</div>';

			$cont .= '</aside>';
			$cont .= '			</div>';
			$cont .= '		</div>';
			$cont .= '</section>';
			// $cont .= '	<span> ' . clang('Share') . ': ';
			// $cont .= '		<a href="https://plus.google.com/share?url=' . site_url() . 'home/pengumuman/' . $row['id_tulisan'] . '" onclick="javascript:window.open(this.href,
			// 			\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;">';
			// $cont .= '			<img style="width:12px;height:12px;margin-top:-3px;" src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>';
			// $cont .= '		</a>';
			// $cont .= '		<i class="fb-share-button" data-href="' . site_url() . 'home/pengumuman/' . $row['id_tulisan'] . '" data-layout="icon" style="width:14px;"></i> ';
			// $cont .= '	</span>';
			// $cont .= '	<span> ' . clang('Print') . ': ';
			// $cont .= '		<a target="blank" href="' . site_url('home/pdf/pengumuman/' . $row['id_tulisan']) . '"><i class="fa fa-file-o"></i></a> ';
			// $cont .= '		<a target="blank" href="' . site_url('home/word/pengumuman/' . $row['id_tulisan']) . '"><i class="fa fa-file-text-o"></i></a> ';
			// $cont .= '	</span>';
			// $cont .= '	<span> ' . clang('Category') . ': ' . $kat . '</span>';
			// $cont .= '</div>';

			// $cont .= '<div class="berita-terkait">';
			// $cont .= '	<hr/>';
			// $cont .= '	<div class="row text-center">';
			// if ($tul_lain != null) {
			// 	foreach ($tul_lain as $row2) {
			// 		$cont .= '		<div class="col-sm-4 col-md-4 col-lg-4">';
			// 		$cont .= '			<h4><a class="related_title" href="' . site_url() . 'home/pengumuman/' . $row2['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row2['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row2['judul_' . $this->session->userdata('lang')]) . ' </a></h4>';
			// 		$cont .= '			<p>' . substr(strip_tags($row2['tulisan_' . $this->session->userdata('lang')]), 0, 80) . '</p>';
			// 		$cont .= '		</div>';
			// 	}
			// }
			// $cont .= '	</div>';
			// $cont .= '	<hr/>';
			// $cont .= '</div>';
			// if ($row['status_komentar'] == 'open') {
			// 	$cont .= '<div class="komentar_user">';
			// 	if ($jml_kom != 0) {
			// 		$cont .= '	<div class="list-komentar">';
			// 		$cont .= '		<h3> Komentar </h3>';
			// 		$cont .= '		<ul>';
			// 		foreach ($kom_[0] as $row_k) {
			// 			$i = 1;
			// 			$cont .= $this->set_komentar($row_k, $kom_, $i);
			// 		}
			// 		$cont .= '		</ul>';
			// 		$cont .= '	</div>';
			// 	}
			// 	$cont .= '<div class="form-komentar post-comment">';
			// 	$cont .= '	<h3> Tinggalkan Komentar </h3>';
			// 	$cont .= '	<form id="contact_us" name="contact_us" action="' . site_url('home/komentar/' . $this->uri->segment('2') . '/' . $this->uri->segment('3') . '/' . $this->uri->segment('4')) . '" method="post">';
			// 	$cont .= '		<input name="id_komentar" type="hidden" value="0">';
			// 	if ($this->session->userdata('id_pengguna') == '') {
			// 		$cont .= '		<div class="form-group">';
			// 		$cont .= '			<label> Nama </label>';
			// 		$cont .= '			<input class="form-control" type="text" placeholder="Name" name="nama_komentar" id="nama-komentar">';
			// 		$cont .= '		</div>';
			// 		$cont .= '		<div class="form-group">';
			// 		$cont .= '			<label> Email </label>';
			// 		$cont .= '			<input class="form-control" type="email" placeholder="Email" name="email_komentar" id="email-komentar">';
			// 		$cont .= '		</div>';
			// 	}
			// 	$cont .= '		<div class="form-group">';
			// 	$cont .= '			<label> Komentar </label>';
			// 	$cont .= '			<textarea class="form-control" name="isi_komentar" id="isi-komentar" cols="60" rows="15"> </textarea> <br>';
			// 	$cont .= '		</div>';
			// 	$cont .= '		<div class="form-group">';
			// 	$cont .= '			<input class="btn btn-default btn-primary" type="submit" value="Kirim">';
			// 	$cont .= '		</div>';
			// 	$cont .= '	</form>';
			// 	$cont .= '</div>';
			// 	$cont .= '</div>';
			// }
			// $cont .= '</div>';

			$cont .= $this->balas_komentar();

			$cont .= '	<div id="fb-root"></div>';
			$cont .= '	<script>(function(d, s, id) {';
			$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
			$cont .= '	  if (d.getElementById(id)) return;';
			$cont .= '	  js = d.createElement(s); js.id = id;';
			$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=789972341083504&version=v2.0";';
			$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
			$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
		} else if ($berita != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {

			// isi konten list pengumuman di halaman
			$cont .= '<section class="page_breadcrumbs ds parallax section_padding_top_100 section_padding_bottom_100">';
			$cont .= '		<div class="container">';
			$cont .= '			<div class="row">';
			$cont .= '				<div class="col-sm-12 text-center">';
			$cont .= '					<h2 class="highlight2">List Pengumuman</h2>';
			$cont .= '					<ol class="breadcrumb darklinks">';
			$cont .= '    						<li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    						<li>List</li>';
			$cont .= '    						<li class="active">Pengumuman</li>';
			$cont .= '					</ol>';
			$cont .= '				</div>';
			$cont .= '			</div>';
			$cont .= '		</div>';
			$cont .= '</section>';

			// PARTS:: BEGIN TEMPLATE STATIC NOT DI LOOPING 
			$cont .= '<section class="space-ptb">';
			$cont .= '	<div class="container">';
			$cont .= '	  <div class="row">';

			foreach ($berita as $row) {
				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);
				// PARTS::BEGIN konten list pengumuman
				$cont .= '<div class="col-md-5">';
				$cont .= '	<div class="item-media">';
				$cont .= '			<img class="img-fluid" src="' . $this->path() . '/' . $row['gambar_andalan'] . '" style="width:100%;">';
				$cont .= '		<div class="gradient_bg_color cs post-relater-person">';
				$cont .= '			<span class="playfair fontsize_18 bold"><i class="fa fa-clock-o">' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '</span></i>';
				$cont .= '		</div>';
				$cont .= '  </div>';
				$cont .= '  <div class="item-content">';
				$cont .= '  	<header class="entry-header">';
				$cont .= '  		<div class="content-justify vertical-center">';
				$cont .= '  			<span class="small-text medium highlight2"><i class="fa fa-user">' . clang('by') . ': ' . $row['nm_dp'] . '</span></i>';
				$cont .= '  		</div>';
				$cont .= '  		<h3 class="entry-title">';
				$cont .= '  			<a href="' . site_url() . 'home/pengumuman/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . ' </a>';
				$cont .= '  		</h3>';
				$cont .= '  	</header>';
				$cont .= '				<p>' . substr(strip_tags($row['tulisan_' . $this->session->userdata('lang')]), 0, 200) . '...';
				$cont .= '					<a href="' . site_url() . 'home/pengumuman/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '">' . clang('Read more') . '</a>';
				$cont .= '				</p>';
				$cont .= '  </div>';
				$cont .= '</div>';
				// PARTS::END konten list pengumuman
			}

			$cont .= '	   </div>';

			$cont .= '	 </div>';
			$cont .= '</section>';
			// PARTS:: END TEMPLATE STATIC NOT DI LOOPING

			$cont .= '<div class="row topmargin_60">';
			$cont .= '	<div class="col-sm-12 text-center">';
			$cont .= '		<div class="with_padding small_padding content-justify vertical-center cs main_bg_color2">';
			$cont .= $halaman;
			$cont .= '		<div>';
			$cont .= '	</div>';
			$cont .= '</div>';
		} else {
			$cont .= clang('Announcement') . ' ' . clang('not found!');
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
		// end list pengumuman di halaman
	}

	function quote()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$tipe = kategoriLabelBy('label', 'quote');
		$where[] = array(
			'where_field' => 'tipe',
			'where_key' => $tipe[0]['id_kategori']
		);
		if ($this->uri->segment(5) != 'preview') {
			$where[] = array(
				'where_field' => 'status_tulisan',
				'where_key' => 'terbit'
			);
		}
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_tulisan',
				'where_key' => $this->uri->segment(3)
			);
		}
		$join = array(
			array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			)
		);

		$tulisan_all = $this->crud->get('tulisan', $where, null, $join);

		$config['base_url'] = site_url() . 'home/quote/page/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = count($tulisan_all);
		$config['per_page'] = 10;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(4) != '') {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}

		$rule['order_field'] = 'tgl_tulisan';
		$rule['order_by'] = 'desc';
		$rule['limit'] = $config['per_page'];
		$rule['offset'] = $offset;

		$berita = $this->crud->get('tulisan', $where, $rule, $join);
		$cont = '';
		if ($berita != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $berita[0];

			if (isset($row['view'])) {
				$data_ = array(
					'view' => $row['view'] + 1
				);
				$where = array(
					array(
						'where_field' => 'id_tulisan',
						'where_key' => $row['id_tulisan']
					)
				);
				$this->crud->update('tulisan', $data_, $where);
			}

			if (isset($row['judul_' . $this->session->userdata('lang')])) {
				$ses['keywords'] = substr(str_replace(' ', ',', strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')])), 0, 150);
				$ses['description'] = substr(strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')]), 0, 250);
				$this->session->set_userdata($ses);
			}

			if (isset($row['gambar_andalan'])) {
				$ses['image'] = $this->path() . '/' . $row['gambar_andalan'];
				$this->session->set_userdata($ses);
			}

			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);

			$where_kat[] = array(
				'where_table' => 'hub_kat_tul',
				'where_field' => 'id_tul',
				'where_key' => $row['id_tulisan']
			);
			$where_kat[] = array(
				'where_table' => 'kategori',
				'where_field' => 'tipe_kategori',
				'where_key' => 'category'
			);
			$join_kat = array(
				array(
					'target_table' => 'kategori',
					'target_field' => 'id_kategori',
					'parent_field' => 'id_kat'
				)
			);
			$kat_tul = $this->crud->get('hub_kat_tul', $where_kat, null, $join_kat);
			$jml_kat = count($kat_tul);
			$kategori = '';
			if ($kat_tul != null) {
				$kat = '';
				$j = 0;
				$i = 1;
				foreach ($kat_tul as $row2) {
					if ($j == 0) {
						$kat .= '<a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					} else {
						$kat .= ', <a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					}
					if ($i == 1) {
						$kategori .= " (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ")";
					} else {
						$kategori .= " OR (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ")";
					}
					if ($kategori != '') {
						$kategori_1 = " (" . $kategori . ") AND ";
					}
					$i++;
					$j++;
				}
			} else {
				$kat = clang('Not categorized!');
			}

			$string__ = "SELECT DISTINCT `tulisan`.`id_tulisan`,`tulisan`.* FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE " . $kategori_1 . " `tipe`='" . $row['tipe'] . "' AND `tulisan`.`status_tulisan`='terbit' ORDER BY `tulisan`.`tgl_tulisan` DESC limit 3";
			$tul_lain = $this->crud->get(null, null, null, null, null, $string__);

			if ($row['status_komentar'] == 'open') {
				$where_kom[] = array(
					'where_field' => 'id_tul',
					'where_key' => $this->uri->segment(3)
				);
				$where_kom[] = array(
					'where_field' => 'status_komentar_',
					'where_key' => 'terbit'
				);
				$join_kom[1] = array(
					'target_table' => 'pengguna',
					'target_field' => 'id_pengguna',
					'parent_field' => 'id_user'
				);
				$komentar = $this->crud->get('komentar', $where_kom, null, $join_kom);
				if ($komentar != null) {
					$jml_kom = count($komentar);
					foreach ($komentar as $row_kom) {
						$kom_[$row_kom['parent_komentar']][$row_kom['id_komentar']] = $row_kom;
					}
				} else {
					$jml_kom = 0;
				}
			}

			$cont = '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li><a href="' . site_url() . 'home/quote">Quote</a></li>';
			if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
			} else {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
			}
			$cont .= '</ol>';

			$cont .= '<div class="berita-detail">';
			$cont .= '<h1 class="title-berita-detail">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h1>';
			$cont .= '<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
			$cont .= '<div class="berita-content">';
			$cont .= '	<div class="berita-img-3" style="width:100%;text-align:center;margin-bottom:20px;">';
			if ($row['gambar_andalan'] != '') {
				$cont .= '		<img src="' . $this->path() . '/' . $row['gambar_andalan'] . '">';
			}
			$cont .= '	</div>';
			$cont .= str_replace('<p>', '<div class="quotes"></div><p class="p-quote">', $row['tulisan_' . $this->session->userdata('lang')]);
			$cont .= '</div>';
			$cont .= '<div class="berita-meta">';
			$cont .= '	<span> ' . clang('Share') . ': ';
			$cont .= '		<a href="https://plus.google.com/share?url=' . site_url() . 'home/quote/' . $row['id_tulisan'] . '" onclick="javascript:window.open(this.href,
						\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;">';
			$cont .= '			<img style="width:12px;height:12px;margin-top:-3px;" src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>';
			$cont .= '		</a>';
			$cont .= '		<i class="fb-share-button" data-href="' . site_url() . 'home/quote/' . $row['id_tulisan'] . '" data-layout="icon" style="width:14px;"></i> ';
			$cont .= '	</span>';
			$cont .= '	<span> ' . clang('Print') . ': ';
			$cont .= '		<a target="blank" href="' . site_url('home/pdf/quote/' . $row['id_tulisan']) . '"><i class="fa fa-file-o"></i></a> ';
			$cont .= '		<a target="blank" href="' . site_url('home/word/quote/' . $row['id_tulisan']) . '"><i class="fa fa-file-text-o"></i></a> ';
			$cont .= '	</span>';
			$cont .= '	<span> ' . clang('Category') . ': ' . $kat . '</span>';
			$cont .= '</div>';

			$cont .= '<div class="berita-terkait">';
			$cont .= '	<hr/>';
			$cont .= '	<div class="row text-center">';
			foreach ($tul_lain as $row2) {
				$cont .= '		<div class="col-sm-4 col-md-4 col-lg-4">';
				$cont .= '			<h4><a class="related_title" href="' . site_url() . 'home/quote/' . $row2['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row2['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row2['judul_' . $this->session->userdata('lang')]) . ' </a></h4>';
				$cont .= '			<div class="quotes"></div><p class="p-quote">' . substr(strip_tags($row2['tulisan_' . $this->session->userdata('lang')]), 0, 80) . '</p>';
				$cont .= '		</div>';
			}
			$cont .= '	</div>';
			$cont .= '	<hr/>';
			$cont .= '</div>';
			$cont .= '</div>';

			$cont .= '	<div id="fb-root"></div>';
			$cont .= '	<script>(function(d, s, id) {';
			$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
			$cont .= '	  if (d.getElementById(id)) return;';
			$cont .= '	  js = d.createElement(s); js.id = id;';
			$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=789972341083504&version=v2.0";';
			$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
			$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
		} else if ($berita != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {
			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="active">Quote</li>';
			$cont .= '</ol>';

			foreach ($berita as $row) {
				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);
				$cont .= '<div class="berita-detail" style="padding-bottom:10px; border-bottom:1px solid #EEE;">';
				$cont .= '	<h3 class="title-berita-detail"><a href="' . site_url() . 'home/quote/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . ' </a></h3>';
				$cont .= '	<div class="row">';
				$cont .= '		<div class="col-lg-12">';
				$cont .= '			<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
				$cont .= '			<p>' . substr(strip_tags($row['tulisan_' . $this->session->userdata('lang')]), 0, 200) . '...';
				$cont .= '				<a href="' . site_url() . 'home/quote/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '">' . clang('Read more') . '</a>';
				$cont .= '			</p>';
				$cont .= '		</div>';
				$cont .= '	</div>';
				$cont .= '</div>';
			}
			$cont .= '<div class="berita-detail pagination">';
			$cont .= $halaman;
			$cont .= '</div>';
		} else {
			$cont .= 'Quote ' . clang('not found!');
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function event()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$tipe = kategoriLabelBy('label', 'event');
		$where[] = array(
			'where_field' => 'tipe',
			'where_key' => $tipe[0]['id_kategori']
		);
		if ($this->uri->segment(5) != 'preview') {
			$where[] = array(
				'where_field' => 'status_tulisan',
				'where_key' => 'terbit'
			);
		}
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_tulisan',
				'where_key' => $this->uri->segment(3)
			);
		}
		$join = array(
			array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			)
		);

		$tulisan_all = $this->crud->get('tulisan', $where, null, $join);

		$config['base_url'] = site_url() . 'home/event/page/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = count($tulisan_all);
		$config['per_page'] = 10;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(4) != '') {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}

		$rule['order_field'] = 'tgl_tulisan';
		$rule['order_by'] = 'desc';
		$rule['limit'] = $config['per_page'];
		$rule['offset'] = $offset;

		$berita = $this->crud->get('tulisan', $where, $rule, $join);
		$cont = '';
		if ($berita != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $berita[0];

			if (isset($row['view'])) {
				$data_ = array(
					'view' => $row['view'] + 1
				);
				$where = array(
					array(
						'where_field' => 'id_tulisan',
						'where_key' => $row['id_tulisan']
					)
				);
				$this->crud->update('tulisan', $data_, $where);
			}

			if (isset($row['judul_' . $this->session->userdata('lang')])) {
				$ses['keywords'] = substr(str_replace(' ', ',', strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')])), 0, 150);
				$ses['description'] = substr(strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')]), 0, 250);
				$this->session->set_userdata($ses);
			}

			if (isset($row['gambar_andalan'])) {
				$ses['image'] = $this->path() . '/' . $row['gambar_andalan'];
				$this->session->set_userdata($ses);
			}

			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);
			if (isset($row['latitude']) && $row['latitude'] != '') {
				$latitude = $row['latitude'];
			} else {
				$latitude = '';
			}
			if (isset($row['longitude']) && $row['longitude'] != '') {
				$longitude = $row['longitude'];
			} else {
				$longitude = '';
			}

			$where_kat[] = array(
				'where_table' => 'hub_kat_tul',
				'where_field' => 'id_tul',
				'where_key' => $row['id_tulisan']
			);
			$where_kat[] = array(
				'where_table' => 'kategori',
				'where_field' => 'tipe_kategori',
				'where_key' => 'category'
			);
			$join_kat = array(
				array(
					'target_table' => 'kategori',
					'target_field' => 'id_kategori',
					'parent_field' => 'id_kat'
				)
			);
			$kat_tul = $this->crud->get('hub_kat_tul', $where_kat, null, $join_kat);
			$jml_kat = count($kat_tul);
			$kategori = '';
			$kategori_1 = '';
			if ($kat_tul != null) {
				$kat = '';
				$j = 0;
				$i = 1;
				foreach ($kat_tul as $row2) {
					if ($j == 0) {
						$kat .= '<a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					} else {
						$kat .= ', <a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					}
					if ($i % $jml_kat == 0) {
						$kategori .= " (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ")";
					} else {
						$kategori .= " (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ") OR ";
					}
					if ($kategori != '') {
						$kategori_1 = " (" . $kategori . ") AND ";
					}
					$i++;
					$j++;
				}
			} else {
				$kat = clang('Not categorized!');
			}

			$string__ = "SELECT DISTINCT `tulisan`.`id_tulisan`,`tulisan`.* FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE " . $kategori_1 . " `tipe`='" . $row['tipe'] . "' AND `tulisan`.`status_tulisan`='terbit' ORDER BY `tulisan`.`tgl_tulisan` DESC limit 3";
			$tul_lain = $this->crud->get(null, null, null, null, null, $string__);

			if ($row['status_komentar'] == 'open') {
				$where_kom[] = array(
					'where_field' => 'id_tul',
					'where_key' => $this->uri->segment(3)
				);
				$where_kom[] = array(
					'where_field' => 'status_komentar_',
					'where_key' => 'terbit'
				);
				$join_kom[1] = array(
					'target_table' => 'pengguna',
					'target_field' => 'id_pengguna',
					'parent_field' => 'id_user'
				);
				$komentar = $this->crud->get('komentar', $where_kom, null, $join_kom);
				if ($komentar != null) {
					$jml_kom = count($komentar);
					foreach ($komentar as $row_kom) {
						$kom_[$row_kom['parent_komentar']][$row_kom['id_komentar']] = $row_kom;
					}
				} else {
					$jml_kom = 0;
				}
			}
			// isi konten event
			$cont .= '<section class="header-inner bg-dark text-center">';
			$cont = '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li><a href="' . site_url() . 'home/event">Event</a></li>';
			if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
			} else {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
			}
			$cont .= '</ol>';
			$cont .= '</section>';


			$cont .= '<div class="berita-detail">';
			$cont .= '<h1 class="title-berita-detail">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h1>';
			$cont .= '<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
			$cont .= '<div class="berita-content">';
			$cont .= '	<div class="berita-img-2">';
			if ($row['gambar_andalan'] != '') {
				$cont .= '		<img src="' . $this->path() . '/' . $row['gambar_andalan'] . '">';
			}
			$cont .= '	</div>';

			$cont .= '	<div class="berita-jadwal" style="display:inline-block;width:100%;">';
			$cont .= '		<div class="row">';
			$cont .= '			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
			$tgl = explode(' ', $row['tgl_mulai']);
			$tgl2 = explode('-', $tgl[0]);
			$cont .= '				<h4>Tanggal Dimulai</h4>';
			$cont .= '				<p>' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '</p>';
			$cont .= '				<h4>Waktu</h4>';
			$cont .= '				<p>' . $tgl[1] . ' WITA</p>';
			$cont .= '				<h4>Email /Telp.</h4>';
			$cont .= '				<p>' . $row['email2'] . '</p>';
			$cont .= '			</div>';
			$cont .= '			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
			$tgl = explode(' ', $row['tgl_selesai']);
			$tgl2 = explode('-', $tgl[0]);
			$cont .= '				<h4>Tanggal Selesai</h4>';
			$cont .= '				<p>' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '</p>';
			$cont .= '				<h4>Lokasi</h4>';
			$cont .= '				<p>' . $row['lokasi'] . '</p>';
			$cont .= '			</div>';
			$cont .= '		</div>';
			$cont .= '	</div>';

			$cont .= $row['tulisan_' . $this->session->userdata('lang')];
			$cont .= '</div>';
			$cont .= '<div class="berita-meta">';
			if ($row['status_komentar'] == 'open') {
				$cont .= '<span> ' . clang('Comment') . ': <a href="#"> ' . $jml_kom . ' </a> </span>';
			}
			$cont .= '	<span> ' . clang('Share') . ': ';
			$cont .= '		<a href="https://plus.google.com/share?url=' . site_url() . 'home/event/' . $row['id_tulisan'] . '" onclick="javascript:window.open(this.href,
						\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;">';
			$cont .= '			<img style="width:12px;height:12px;margin-top:-3px;" src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>';
			$cont .= '		</a>';
			$cont .= '		<i class="fb-share-button" data-href="' . site_url() . 'home/event/' . $row['id_tulisan'] . '" data-layout="icon" style="width:14px;"></i> ';
			$cont .= '	</span>';
			$cont .= '	<span> ' . clang('Print') . ': ';
			$cont .= '		<a target="blank" href="' . site_url('home/pdf/event/' . $row['id_tulisan']) . '"><i class="fa fa-file-o"></i></a> ';
			$cont .= '		<a target="blank" href="' . site_url('home/word/event/' . $row['id_tulisan']) . '"><i class="fa fa-file-text-o"></i></a> ';
			$cont .= '	</span>';
			$cont .= '	<span> ' . clang('Category') . ': ' . $kat . '</span>';
			$cont .= '</div>';

			$cont .= '<div class="berita-terkait">';
			$cont .= '	<hr/>';
			$cont .= '	<div class="row text-center">';
			if ($tul_lain != null) {
				foreach ($tul_lain as $row2) {
					$cont .= '		<div class="col-sm-4 col-md-4 col-lg-4">';
					$cont .= '			<h4><a class="related_title" href="' . site_url() . 'home/event/' . $row2['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row2['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row2['judul_' . $this->session->userdata('lang')]) . ' </a></h4>';
					$cont .= '			<p>' . substr(strip_tags($row2['tulisan_' . $this->session->userdata('lang')]), 0, 80) . '</p>';
					$cont .= '		</div>';
				}
			}
			$cont .= '	</div>';
			$cont .= '	<hr/>';
			$cont .= '</div>';

			$cont .= '<div class="berita-peta-lokasi">';
			$cont .= '	<h3> Peta Lokasi </h3>';
			$cont .= '	<div id="map-canvas" style="min-height:300px;"></div>';
			$cont .= '</div>';

			if ($row['status_komentar'] == 'open') {
				$cont .= '<div class="komentar_user">';
				if ($jml_kom != 0) {
					$cont .= '	<div class="list-komentar">';
					$cont .= '		<h3> Komentar </h3>';
					$cont .= '		<ul>';
					foreach ($kom_[0] as $row_k) {
						$i = 1;
						$cont .= $this->set_komentar($row_k, $kom_, $i);
					}
					$cont .= '		</ul>';
					$cont .= '	</div>';
				}
				$cont .= '<div class="form-komentar post-comment">';
				$cont .= '	<h3> Tinggalkan Komentar </h3>';
				$cont .= '	<form id="contact_us" name="contact_us" action="' . site_url('home/komentar/' . $this->uri->segment('2') . '/' . $this->uri->segment('3') . '/' . $this->uri->segment('4')) . '" method="post">';
				$cont .= '		<input name="id_komentar" type="hidden" value="0">';
				if ($this->session->userdata('id_pengguna') == '') {
					$cont .= '		<div class="form-group">';
					$cont .= '			<label> Nama </label>';
					$cont .= '			<input class="form-control" type="text" placeholder="Name" name="nama_komentar" id="nama-komentar">';
					$cont .= '		</div>';
					$cont .= '		<div class="form-group">';
					$cont .= '			<label> Email </label>';
					$cont .= '			<input class="form-control" type="email" placeholder="Email" name="email_komentar" id="email-komentar">';
					$cont .= '		</div>';
				}
				$cont .= '		<div class="form-group">';
				$cont .= '			<label> Komentar </label>';
				$cont .= '			<textarea class="form-control" name="isi_komentar" id="isi-komentar" cols="60" rows="15"> </textarea> <br>';
				$cont .= '		</div>';
				$cont .= '		<div class="form-group">';
				$cont .= '			<input class="btn btn-default btn-primary" type="submit" value="Kirim">';
				$cont .= '		</div>';
				$cont .= '	</form>';
				$cont .= '</div>';
				$cont .= '</div>';
			}
			$cont .= '</div>';

			$cont .= $this->balas_komentar();

			$cont .= '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBe3r-6KdXUZ2RfrvoqQbte4HonzzxuZrY"type="text/javascript"></script>';
			$cont .= '	<script>';
			$cont .= '		var latitude = "' . $latitude . '";';
			$cont .= '		var longitude = "' . $longitude . '";';
			$cont .= '	   var map;';
			$cont .= '	   var markers = [];';
			$cont .= '	   function initialize() {';
			$cont .= '	      var objek = new google.maps.LatLng(-3.998619, 122.508842);';
			$cont .= '	      var mapOptions = {';
			$cont .= '	         zoom: 10,';
			$cont .= '	         center: objek,';
			$cont .= '	         mapTypeId: google.maps.MapTypeId.ROADMAP,';
			$cont .= '	         streetViewControl: false';
			$cont .= '	      };';
			$cont .= '	      map = new google.maps.Map(document.getElementById(\'map-canvas\'),';
			$cont .= '	         mapOptions);';
			$cont .= '	      if(latitude!=""&&longitude!=""){';
			$cont .= '	      	addMarker(new google.maps.LatLng(latitude,longitude));';
			$cont .= '	      }';
			$cont .= '	   }';
			$cont .= '	   function addMarker(lokasi) {';
			$cont .= '	      $("#latitude").val(lokasi.lat());';
			$cont .= '	      $("#longitude").val(lokasi.lng());';
			$cont .= '	      var marker = new google.maps.Marker({';
			$cont .= '	         position: lokasi,';
			$cont .= '	         map: map';
			$cont .= '	      });';
			$cont .= '	      markers.push(marker);';
			$cont .= '	   }';
			$cont .= '	   google.maps.event.addDomListener(window, \'load\', initialize);';
			$cont .= '	</script>';

			$cont .= '	<div id="fb-root"></div>';
			$cont .= '	<script>(function(d, s, id) {';
			$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
			$cont .= '	  if (d.getElementById(id)) return;';
			$cont .= '	  js = d.createElement(s); js.id = id;';
			$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=789972341083504&version=v2.0";';
			$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
			$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
		} else if ($berita != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {
			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="active">Event</li>';
			$cont .= '</ol>';

			foreach ($berita as $row) {
				$tgl = explode(' ', $row['tgl_mulai']);
				$tgl2 = explode('-', $tgl[0]);
				$cont .= '<div class="berita-detail" style="padding-bottom:10px; border-bottom:1px solid #EEE;">';
				$cont .= '	<div class="row">';
				$cont .= '		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">';
				$cont .= '			<div class="text-center" style="margin-top:20px;margin-bottom:10px;">';
				$cont .= '				<span class="bulan">' . bln2($tgl2[1]) . '</span>';
				$cont .= '				<span class="tanggal">' . $tgl2[2] . '</span>';
				$cont .= '				<span class="tahun">' . $tgl2[0] . '</span>';
				$cont .= '			</div>';
				$cont .= '		</div>';
				$cont .= '		<div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">';
				$cont .= '			<h3 class="title-berita-detail" style="margin-top:10px;"><a href="' . site_url() . 'home/event/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . ' </a></h3>';
				$cont .= '		</div>';
				$cont .= '	</div>';
				$cont .= '	<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
				$cont .= '	<p>' . substr(strip_tags($row['tulisan_' . $this->session->userdata('lang')]), 0, 200) . '...';
				$cont .= '		<a href="' . site_url() . 'home/event/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '">' . clang('Read more') . '</a>';
				$cont .= '	</p>';
				$cont .= '</div>';
			}
			$cont .= '<div class="berita-detail pagination">';
			$cont .= $halaman;
			$cont .= '</div>';
		} else {
			$cont .= clang('Event') . ' ' . clang('not found!');
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function album()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$where[] = array(
			'where_field' => 'tipe',
			'where_key' => 'album'
		);
		if ($this->uri->segment(5) != 'preview') {
			$where[] = array(
				'where_field' => 'status_tulisan',
				'where_key' => 'terbit'
			);
		}
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_tulisan',
				'where_key' => $this->uri->segment(3)
			);
		}
		$join = array(
			array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			)
		);

		$tulisan_all = $this->crud->get('tulisan', $where, null, $join);

		$config['base_url'] = site_url() . 'home/album/page/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = count($tulisan_all);
		$config['per_page'] = 9;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(4) != '') {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}

		$rule['order_field'] = 'tgl_tulisan';
		$rule['order_by'] = 'desc';
		$rule['limit'] = $config['per_page'];
		$rule['offset'] = $offset;

		$berita = $this->crud->get('tulisan', $where, $rule, $join);
		$cont = '';
		if ($berita != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $berita[0];

			if (isset($row['view'])) {
				$data_ = array(
					'view' => $row['view'] + 1
				);
				$where = array(
					array(
						'where_field' => 'id_tulisan',
						'where_key' => $row['id_tulisan']
					)
				);
				$this->crud->update('tulisan', $data_, $where);
			}

			if (isset($row['judul_' . $this->session->userdata('lang')])) {
				$ses['keywords'] = substr(str_replace(' ', ',', strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')])), 0, 150);
				$ses['description'] = substr(strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')]), 0, 250);
				$this->session->set_userdata($ses);
			}

			if (isset($row['gambar_andalan'])) {
				$ses['image'] = $this->path() . '/' . $row['gambar_andalan'];
				$this->session->set_userdata($ses);
			}

			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);

			$cont = '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li><a href="' . site_url() . 'home/album">Album</a></li>';
			if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
			} else {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
			}
			$cont .= '</ol>';

			$cont .= '<div class="berita-detail">';
			$cont .= '<h1 class="title-berita-detail">' . ucfirst($row['judul_id']) . '</h1>';
			$cont .= '<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';

			$cont .= '<div class="row album parent-container">';
			$where_img[1] = array(
				'where_field' => 'folder',
				'where_key' => $row['id_tulisan']
			);
			$img = $this->crud->get('gambar_album', $where_img);
			if ($img != null) {
				foreach ($img as $row2) {
					$cont .= '<div class="col-sm-6 col-md-3">';
					$cont .= '	<a href="' . $row2['path_gambar'] . '/' . $row2['nama_gambar'] . '" class="thumbnail">';
					$cont .= '		<img src="' . $row2['path_gambar'] . '/' . $row2['nama_gambar'] . '" alt="' . $row2['nama_gambar'] . '">';
					$cont .= '	</a>';
					$cont .= '</div>';
				}
			} else {
				$cont .= '<div class="col-lg-12">Gambar tidak ditemukan!</div>';
			}
			$cont .= '</div>';

			$cont .= '<div class="berita-meta">';
			$cont .= '	<span> ' . clang('Share') . ': ';
			$cont .= '		<a href="https://plus.google.com/share?url=' . site_url() . 'home/event/' . $row['id_tulisan'] . '" onclick="javascript:window.open(this.href,
						\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;">';
			$cont .= '			<img style="width:12px;height:12px;margin-top:-3px;" src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>';
			$cont .= '		</a>';
			$cont .= '		<i class="fb-share-button" data-href="' . site_url() . 'home/event/' . $row['id_tulisan'] . '" data-layout="icon" style="width:14px;"></i> ';
			$cont .= '	</span>';
			$cont .= '</div>';

			$cont .= '</div>';

			$cont .= '	<div id="fb-root"></div>';
			$cont .= '	<script>(function(d, s, id) {';
			$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
			$cont .= '	  if (d.getElementById(id)) return;';
			$cont .= '	  js = d.createElement(s); js.id = id;';
			$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=789972341083504&version=v2.0";';
			$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
			$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
		} else if ($berita != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {
			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="active">Album</li>';
			$cont .= '</ol>';

			$cont .= '<div class="row berita-detail">';
			foreach ($berita as $row) {
				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);
				$cont .= '<div class="col-sm-6 col-md-4">';
				$cont .= '    <div class="thumbnail">';
				$cont .= '      <div data-holder-rendered="true" style="height: 120px; width: 100%; display: block; overflow:hidden;">';
				$cont .= '      	<img src="' . base_url('assets/img/album') . '/' . $row['id_tulisan'] . '/' . $row['gambar_andalan'] . '" style="width:100%;">';
				$cont .= '      </div>';
				$cont .= '      <div class="caption">';
				$cont .= '        <h4 class="title-berita-detail text-center"><a href="' . site_url() . 'home/album/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_id']))) . '"> ';
				if (strlen($row['judul_' . $this->session->userdata('lang')]) > 20) {
					$cont .= ucfirst(substr($row['judul_id'], 0, 20)) . '...';
				} else {
					$cont .= ucfirst($row['judul_id']);
				}
				$cont .= ' 			</a></h4>';
				$cont .= '        <p><span class="tgl-berita-terpopuler">' . clang('Uploaded on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span></p>';
				$cont .= '      </div>';
				$cont .= '    </div>';
				$cont .= '  </div>';
			}
			$cont .= '</div>';
			$cont .= $halaman;
		} else {
			$cont .= clang('Album') . ' ' . clang('not found!');
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function produk()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$tipe = kategoriLabelBy('label', 'produk');
		$where[] = array(
			'where_field' => 'tipe',
			'where_key' => $tipe[0]['id_kategori']
		);
		if ($this->uri->segment(5) != 'preview') {
			$where[] = array(
				'where_field' => 'status_tulisan',
				'where_key' => 'terbit'
			);
		}
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_tulisan',
				'where_key' => $this->uri->segment(3)
			);
		}
		$join = array(
			array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			)
		);

		$tulisan_all = $this->crud->get('tulisan', $where, null, $join);

		$config['base_url'] = site_url() . 'home/produk/page/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = count($tulisan_all);
		$config['per_page'] = 10;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(4) != '') {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}

		$rule['order_field'] = 'tgl_tulisan';
		$rule['order_by'] = 'desc';
		$rule['limit'] = $config['per_page'];
		$rule['offset'] = $offset;

		$berita = $this->crud->get('tulisan', $where, $rule, $join);
		$cont = '';
		if ($berita != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $berita[0];

			if (isset($row['view'])) {
				$data_ = array(
					'view' => $row['view'] + 1
				);
				$where = array(
					array(
						'where_field' => 'id_tulisan',
						'where_key' => $row['id_tulisan']
					)
				);
				$this->crud->update('tulisan', $data_, $where);
			}

			if (isset($row['judul_' . $this->session->userdata('lang')])) {
				$ses['keywords'] = substr(str_replace(' ', ',', strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')])), 0, 150);
				$ses['description'] = substr(strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')]), 0, 250);
				$this->session->set_userdata($ses);
			}

			if (isset($row['gambar_andalan'])) {
				$ses['image'] = $this->path() . '/' . $row['gambar_andalan'];
				$this->session->set_userdata($ses);
			}

			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);

			$where_kat[] = array(
				'where_table' => 'hub_kat_tul',
				'where_field' => 'id_tul',
				'where_key' => $row['id_tulisan']
			);
			$where_kat[] = array(
				'where_table' => 'kategori',
				'where_field' => 'tipe_kategori',
				'where_key' => 'category'
			);
			$join_kat = array(
				array(
					'target_table' => 'kategori',
					'target_field' => 'id_kategori',
					'parent_field' => 'id_kat'
				)
			);
			$kat_tul = $this->crud->get('hub_kat_tul', $where_kat, null, $join_kat);
			$jml_kat = count($kat_tul);
			$kategori = '';
			if ($kat_tul != null) {
				$kat = '';
				$j = 0;
				$i = 1;
				foreach ($kat_tul as $row2) {
					if ($j == 0) {
						$kat .= '<a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					} else {
						$kat .= ', <a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					}
					if ($i % $jml_kat == 0) {
						$kategori .= " (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ")";
					} else {
						$kategori .= " (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ") OR ";
					}
					$i++;
					$j++;
				}
			} else {
				$kat = clang('Not categorized!');
			}

			$cont = '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li><a href="' . site_url() . 'home/produk">Produk</a></li>';
			if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
			} else {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
			}
			$cont .= '</ol>';

			$cont .= '<div class="berita-detail">';
			$cont .= '<h1 class="title-berita-detail">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h1>';
			$cont .= '<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
			$cont .= '<div class="berita-content">';
			$cont .= '	<div class="berita-img-2">';
			if ($row['gambar_andalan'] != '') {
				$cont .= '		<img src="' . $this->path() . '/' . $row['gambar_andalan'] . '">';
			}
			$cont .= '	</div>';

			$cont .= $row['tulisan_' . $this->session->userdata('lang')];
			$cont .= '</div>';
			$cont .= '<div class="berita-meta">';
			$cont .= '	<span> ' . clang('Share') . ': ';
			$cont .= '		<a href="https://plus.google.com/share?url=' . site_url() . 'home/produk/' . $row['id_tulisan'] . '" onclick="javascript:window.open(this.href,
						\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;">';
			$cont .= '			<img style="width:12px;height:12px;margin-top:-3px;" src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>';
			$cont .= '		</a>';
			$cont .= '		<i class="fb-share-button" data-href="' . site_url() . 'home/produk/' . $row['id_tulisan'] . '" data-layout="icon" style="width:14px;"></i> ';
			$cont .= '	</span>';
			$cont .= '	<span> ' . clang('Print') . ': ';
			$cont .= '		<a target="blank" href="' . site_url('home/pdf/produk/' . $row['id_tulisan']) . '"><i class="fa fa-file-o"></i></a> ';
			$cont .= '		<a target="blank" href="' . site_url('home/word/produk/' . $row['id_tulisan']) . '"><i class="fa fa-file-text-o"></i></a> ';
			$cont .= '	</span>';
			$cont .= '	<span> ' . clang('Category') . ': ' . $kat . '</span>';
			$cont .= '</div>';
			$cont .= '</div>';

			$cont .= '	<div id="fb-root"></div>';
			$cont .= '	<script>(function(d, s, id) {';
			$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
			$cont .= '	  if (d.getElementById(id)) return;';
			$cont .= '	  js = d.createElement(s); js.id = id;';
			$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=789972341083504&version=v2.0";';
			$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
			$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
		} else if ($berita != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {
			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="active">Produk</li>';
			$cont .= '</ol>';

			foreach ($berita as $row) {
				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);
				$cont .= '<div class="berita-detail" style="padding-bottom:10px; border-bottom:1px solid #EEE;">';
				$cont .= '	<h3 class="title-berita-detail"><a href="' . site_url() . 'home/produk/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . ' </a></h3>';
				$cont .= '	<div class="row">';
				$cont .= '		<div class="col-lg-12">';
				$cont .= '			<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
				$cont .= '			<p>' . substr(strip_tags($row['tulisan_' . $this->session->userdata('lang')]), 0, 200) . '...';
				$cont .= '				<a href="' . site_url() . 'home/produk/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '">' . clang('Read more') . '</a>';
				$cont .= '			</p>';
				$cont .= '		</div>';
				$cont .= '	</div>';
				$cont .= '</div>';
			}
			$cont .= '<div class="berita-detail pagination">';
			$cont .= $halaman;
			$cont .= '</div>';
		} else {
			$cont .= 'Produk ' . clang('not found!');
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function video()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$where[] = array(
			'where_field' => 'status_video',
			'where_key' => 'open'
		);
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_video',
				'where_key' => $this->uri->segment(3)
			);
		}
		$join = array(
			array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'pengunggah'
			)
		);

		$tulisan_all = $this->crud->get('video', $where, null, $join);

		$config['base_url'] = site_url() . 'home/video/page/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = count($tulisan_all);
		$config['per_page'] = 9;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(4) != '') {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}

		$rule['order_field'] = 'id_video';
		$rule['order_by'] = 'desc';
		$rule['limit'] = $config['per_page'];
		$rule['offset'] = $offset;

		$berita = $this->crud->get('video', $where, $rule, $join);
		$cont = '';
		if ($berita != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $berita[0];
			$tgl = explode(' ', $row['tgl_video']);
			$tgl2 = explode('-', $tgl[0]);

			$where_vid[] = array(
				'where_field' => 'status_video',
				'where_key' => 'open'
			);
			$rule_vid['limit'] = 3;
			$rule_vid['order_field'] = 'id_video';
			$rule_vid['order_by'] = 'desc';
			$vid_lain = $this->crud->get('video', $where_vid, $rule_vid);

			$cont = '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li><a href="' . site_url() . 'home/video">Video</a></li>';
			$cont .= '    <li class="active">' . ucfirst($row['nama_video']) . '</li>';
			$cont .= '</ol>';

			$cont .= '<div class="berita-detail">';
			$cont .= '<h1 class="title-berita-detail">' . ucfirst($row['nama_video']) . '</h1>';
			$cont .= '<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
			$cont .= '<div class="berita-content">';
			$cont .= '	<div class="berita-img-2">';
			if ($row['url_video'] != '') {
				$cont .= '		<iframe id="iframe-video-detail" src="' . $row['url_video'] . '" frameborder="0" allowfullscreen=""></iframe>';
			}
			$cont .= '	</div>';
			$cont .= '</div>';

			$cont .= '<div class="berita-meta">';
			$cont .= '	<span> ' . clang('Share') . ': ';
			$cont .= '		<a href="https://plus.google.com/share?url=' . site_url() . 'home/video/' . $row['id_video'] . '" onclick="javascript:window.open(this.href,
						\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;">';
			$cont .= '			<img style="width:12px;height:12px;margin-top:-3px;" src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>';
			$cont .= '		</a>';
			$cont .= '		<i class="fb-share-button" data-href="' . site_url() . 'home/video/' . $row['id_video'] . '" data-layout="icon" style="width:14px;"></i> ';
			$cont .= '	</span>';
			$cont .= '</div>';

			$cont .= '<div class="berita-terkait">';
			$cont .= '	<hr/>';
			$cont .= '	<div class="row text-center" style="margin-top:10px;">';
			foreach ($vid_lain as $row2) {
				$cont .= '<div class="col-sm-4 col-md-4 col-lg-4">';
				$cont .= '    <div class="thumbnail">';
				$cont .= '      <div data-holder-rendered="true" style="height: 120px; width: 100%; display: block; overflow:hidden;">';
				$cont .= '      	<iframe id="iframe-video" src="' . $row2['url_video'] . '" frameborder="0" allowfullscreen=""></iframe>';
				$cont .= '      </div>';
				$cont .= '      <div class="caption">';
				$cont .= '        <h4 class="title-berita-detail text-center"><a href="' . site_url() . 'home/video/' . $row2['id_video'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row2['nama_video']))) . '"> ';
				if (strlen($row2['nama_video']) > 20) {
					$cont .= ucfirst(substr($row2['nama_video'], 0, 20)) . '...';
				} else {
					$cont .= ucfirst($row2['nama_video']);
				}
				$cont .= ' 			</a></h4>';
				$cont .= '      </div>';
				$cont .= '    </div>';
				$cont .= '  </div>';
			}
			$cont .= '	</div>';
			$cont .= '	<hr/>';
			$cont .= '</div>';

			$cont .= '</div>';

			$cont .= '	<div id="fb-root"></div>';
			$cont .= '	<script>(function(d, s, id) {';
			$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
			$cont .= '	  if (d.getElementById(id)) return;';
			$cont .= '	  js = d.createElement(s); js.id = id;';
			$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=789972341083504&version=v2.0";';
			$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
			$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
		} else if ($berita != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {
			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="active">Video</li>';
			$cont .= '</ol>';

			$cont .= '<div class="row berita-detail">';
			foreach ($berita as $row) {
				$tgl = explode(' ', $row['tgl_video']);
				$tgl2 = explode('-', $tgl[0]);
				$cont .= '<div class="col-sm-6 col-md-4">';
				$cont .= '    <div class="thumbnail">';
				$cont .= '      <div data-holder-rendered="true" style="height: 120px; width: 100%; display: block; overflow:hidden;">';
				$cont .= '      	<iframe id="iframe-video" src="' . $row['url_video'] . '" frameborder="0" allowfullscreen=""></iframe>';
				$cont .= '      </div>';
				$cont .= '      <div class="caption">';
				$cont .= '        <h4 class="title-berita-detail text-center"><a href="' . site_url() . 'home/video/' . $row['id_video'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['nama_video']))) . '"> ';
				if (strlen($row['nama_video']) > 20) {
					$cont .= ucfirst(substr($row['nama_video'], 0, 20)) . '...';
				} else {
					$cont .= ucfirst($row['nama_video']);
				}
				$cont .= ' </a></h4>';
				$cont .= '        <p><span class="tgl-berita-terpopuler">' . clang('Uploaded on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span></p>';
				$cont .= '      </div>';
				$cont .= '    </div>';
				$cont .= '  </div>';
			}
			$cont .= '</div>';
			$cont .= '<div class="berita-detail pagination">';
			$cont .= $halaman;
			$cont .= '</div>';
		} else {
			$cont .= 'Video ' . clang('not found!');
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function ebook()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$tipe = kategoriLabelBy('label', 'ebook');
		$where[] = array(
			'where_field' => 'tipe',
			'where_key' => $tipe[0]['id_kategori']
		);
		if ($this->uri->segment(5) != 'preview') {
			$where[] = array(
				'where_field' => 'status_tulisan',
				'where_key' => 'terbit'
			);
		}
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_tulisan',
				'where_key' => $this->uri->segment(3)
			);
		}
		$join = array(
			array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			)
		);

		$tulisan_all = $this->crud->get('tulisan', $where, null, $join);

		$config['base_url'] = site_url() . 'home/ebook/page/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = count($tulisan_all);
		$config['per_page'] = 10;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(4) != '') {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}

		$rule['order_field'] = 'tgl_tulisan';
		$rule['order_by'] = 'desc';
		$rule['limit'] = $config['per_page'];
		$rule['offset'] = $offset;

		$berita = $this->crud->get('tulisan', $where, $rule, $join);
		$cont = '';
		if ($berita != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $berita[0];

			if (isset($row['view'])) {
				$data_ = array(
					'view' => $row['view'] + 1
				);
				$where = array(
					array(
						'where_field' => 'id_tulisan',
						'where_key' => $row['id_tulisan']
					)
				);
				$this->crud->update('tulisan', $data_, $where);
			}

			if (isset($row['judul_' . $this->session->userdata('lang')])) {
				$ses['keywords'] = substr(str_replace(' ', ',', strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')])), 0, 150);
				$ses['description'] = substr(strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')]), 0, 250);
				$this->session->set_userdata($ses);
			}

			if (isset($row['gambar_andalan'])) {
				$ses['image'] = $this->path() . '/' . $row['gambar_andalan'];
				$this->session->set_userdata($ses);
			}

			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);

			$where_kat[] = array(
				'where_table' => 'hub_kat_tul',
				'where_field' => 'id_tul',
				'where_key' => $row['id_tulisan']
			);
			$where_kat[] = array(
				'where_table' => 'kategori',
				'where_field' => 'tipe_kategori',
				'where_key' => 'category'
			);
			$join_kat = array(
				array(
					'target_table' => 'kategori',
					'target_field' => 'id_kategori',
					'parent_field' => 'id_kat'
				)
			);
			$kat_tul = $this->crud->get('hub_kat_tul', $where_kat, null, $join_kat);
			$jml_kat = count($kat_tul);
			$kategori = '';
			if ($kat_tul != null) {
				$kat = '';
				$j = 0;
				$i = 1;
				foreach ($kat_tul as $row2) {
					if ($j == 0) {
						$kat .= '<a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					} else {
						$kat .= ', <a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
					}
					if ($i % $jml_kat == 0) {
						$kategori .= " (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ")";
					} else {
						$kategori .= " (`hub_kat_tul`.`id_kat`=" . $row2['id_kat'] . ") OR ";
					}
					$i++;
					$j++;
				}
			} else {
				$kat = clang('Not categorized!');
			}

			$where_file[] = array(
				'where_field' => 'id_tulisan',
				'where_key' => $row['id_tulisan']
			);
			$file = $this->crud->get('file', $where_file);

			$cont = '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li><a href="' . site_url() . 'home/ebook">Ebook</a></li>';
			if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
			} else {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
			}
			$cont .= '</ol>';

			$cont .= '<div class="berita-detail">';
			$cont .= '<h1 class="title-berita-detail">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h1>';
			$cont .= '<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
			$cont .= '<div class="berita-content">';
			$cont .= '	<div class="berita-img-2">';
			if ($row['gambar_andalan'] != '') {
				$cont .= '		<img src="' . $this->path() . '/' . $row['gambar_andalan'] . '">';
			}
			$cont .= '	</div>';

			$cont .= $row['tulisan_' . $this->session->userdata('lang')];
			$cont .= '</div>';
			$cont .= '<div class="berita-meta">';
			$cont .= '	<span> ' . clang('Share') . ': ';
			$cont .= '		<a href="https://plus.google.com/share?url=' . site_url() . 'home/produk/' . $row['id_tulisan'] . '" onclick="javascript:window.open(this.href,
						\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;">';
			$cont .= '			<img style="width:12px;height:12px;margin-top:-3px;" src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>';
			$cont .= '		</a>';
			$cont .= '		<i class="fb-share-button" data-href="' . site_url() . 'home/produk/' . $row['id_tulisan'] . '" data-layout="icon" style="width:14px;"></i> ';
			$cont .= '	</span>';
			$cont .= '	<span> ' . clang('Print') . ': ';
			$cont .= '		<a target="blank" href="' . site_url('home/pdf/ebook/' . $row['id_tulisan']) . '"><i class="fa fa-file-o"></i></a> ';
			$cont .= '		<a target="blank" href="' . site_url('home/word/ebook/' . $row['id_tulisan']) . '"><i class="fa fa-file-text-o"></i></a> ';
			$cont .= '	</span>';
			$cont .= '	<span> ' . clang('Category') . ': ' . $kat . '</span>';
			$cont .= '</div>';

			$cont .= '<div class="berita-terkait">';
			$cont .= '	<hr/>';
			$cont .= '	<div class="row text-center accordion" id="accordion2">';
			$cont .= '		<div class="col-lg-12">';
			$no = 1;
			foreach ($file as $row2) {
				$cont .= '<div class="accordion-group">';
				$cont .= '	<div class="accordion-heading">';
				$cont .= '		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne' . $no . '">';
				$cont .= '			' . $row2['file'] . '';
				$cont .= '		</a>';
				$cont .= '	</div>';
				$cont .= '	<div id="collapseOne' . $no . '" class="accordion-body collapse" style="min-height: 0px; ">';
				$cont .= '		<div class="accordion-inner" style="min-height:200px">';
				$cont .= '			<iframe src="http://docs.google.com/viewer?url=' . base_url() . 'assets/file/' . $row2['file'] . '&embedded=true" width="100%" height="780" style="border: none;"></iframe>';
				$cont .= '		</div>';
				$cont .= '	</div>';
				$cont .= '</div>';
				$no++;
			}
			$cont .= '		</div>';
			$cont .= '	</div>';
			$cont .= '	<hr/>';
			$cont .= '</div>';
			$cont .= '</div>';

			$cont .= '	<div id="fb-root"></div>';
			$cont .= '	<script>(function(d, s, id) {';
			$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
			$cont .= '	  if (d.getElementById(id)) return;';
			$cont .= '	  js = d.createElement(s); js.id = id;';
			$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=789972341083504&version=v2.0";';
			$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
			$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
		} else if ($berita != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {
			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="active">Ebook</li>';
			$cont .= '</ol>';

			foreach ($berita as $row) {
				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);
				$cont .= '<div class="berita-detail" style="padding-bottom:10px; border-bottom:1px solid #EEE;">';
				$cont .= '	<h3 class="title-berita-detail"><a href="' . site_url() . 'home/ebook/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . ' </a></h3>';
				$cont .= '	<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
				$cont .= '</div>';
			}

			$cont .= '<div class="berita-detail pagination">';
			$cont .= $halaman;
			$cont .= '</div>';
		} else {
			$cont .= 'Ebook ' . clang('not found!');
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}



	function kategori()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$cont = '';
		$where_kat[] = array(
			'where_field' => 'tipe_kategori',
			'where_key' => 'category'
		);
		$kategori = $this->crud->get('kategori', $where_kat);
		if ($kategori != null && $this->uri->segment(3) != '') {
			$where_tul[] = array(
				'where_table' => 'hub_kat_tul',
				'where_field' => 'id_kat',
				'where_key' => $this->uri->segment(3)
			);
			$where_tul[] = array(
				'where_table' => 'tulisan',
				'where_field' => 'status_tulisan',
				'where_key' => 'terbit'
			);
			$join_tul[] = array(
				'target_table' => 'hub_kat_tul',
				'target_field' => 'id_tul',
				'parent_field' => 'id_tulisan'
			);
			$tulisan_all = $this->crud->get('tulisan', $where_tul, null, $join_tul);

			$config['base_url'] = site_url() . 'home/kategori/' . $this->uri->segment(3) . '/' . $this->uri->segment(4);
			$config['uri_segment'] = 5;
			$config['total_rows'] = count($tulisan_all);
			$config['per_page'] = 10;
			$config['first_page'] = 'Awal';
			$config['last_page'] = 'Akhir';
			$config['next_page'] = '«';
			$config['prev_page'] = '»';
			$this->pagination->initialize($config);
			$halaman = $this->pagination->create_links();
			if ($this->uri->segment(5) != '') {
				$offset = $this->uri->segment(5);
			} else {
				$offset = 0;
			}

			$join_tul[] = array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			);
			$join_tul[] = array(
				'target_table' => 'kategori',
				'target_field' => 'id_kategori',
				'parent_field' => 'tipe'
			);
			$rule_tul['order_field'] = 'tgl_tulisan';
			$rule_tul['order_by'] = 'desc';
			$rule_tul['limit'] = $config['per_page'];
			$rule_tul['offset'] = $offset;
			$tulisan = $this->crud->get('tulisan', $where_tul, $rule_tul, $join_tul);

			// isi konten kategori berita
			$cont .= '<section class="header-inner bg-dark text-center">';
			$cont .= '<div class="container">';
			$cont .= '<div class="row">';
			$cont .= '<div class="col-sm-12 ">';
			$cont .= '<ol class="breadcrumb mb-0 p-0">';
			$cont .= '    <li class="breadcrumb-item"><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="breadcrumb-item"><a href="' . site_url() . 'home/kategori">Kategori</a></li>';
			$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', $this->uri->segment(4))) . '</li>';
			$cont .= '</ol>';
			$cont .= '<h2 class="inner-banner-title">' . ucfirst(str_replace('-', ' ', $this->uri->segment(4))) . '</h2>';
			$cont .= '</div>';
			$cont .= '</div>';
			$cont .= '</div>';
			$cont .= '</section>';

			// PARTS:: BEGIN TEMPLATE STATIC NOT DI LOOPING 
			$cont .= '<section class="space-ptb">';
			$cont .= '	<div class="container">';
			$cont .= '	  <div class="row">';

			foreach ($tulisan as $row) {
				if ($row['gambar_andalan'] != '') {
					$img = CI()->path() . '/' . $row['gambar_andalan'];
				} else {
					$img = base_url('assets/img/web/no_image.png');
				}
				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);
				$cont .= '<div class="col-lg-4 col-md-6 mb-0 mb-lg-2">';
				$cont .= '  	<div class="blog-post">';
				$cont .= '      		<div class="blog-post-image">';
				$cont .= '          		<img class="img-fluid" src="' . $img . '" alt="img"> ';
				$cont .= '      		</div>';
				$cont .= '      		<div class="blog-post-content">';
				$cont .= '		   			<div class="blog-post-date"><span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span></div>';
				$cont .= '		   			<h6 class="blog-post-title"><a href="' . site_url() . 'home/' . $row['slug'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '"> ' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . ' </a></h6>';
				$cont .= '      		</div>';
				$cont .= '					<p>' . substr(strip_tags($row['tulisan_' . $this->session->userdata('lang')]), 0, 200) . '...';
				$cont .= '						<a href="' . site_url() . 'home/' . $row['slug'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . $this->session->userdata('lang')]))) . '">' . clang('Read more') . '</a>';
				$cont .= '					</p>';
				$cont .= '		 </div>';
				$cont .= '</div>';
			}
			$cont .= '	   </div>';

			$cont .= '	 </div>';
			$cont .= '</section>';
			// PARTS:: END TEMPLATE STATIC NOT DI LOOPING 

			$cont .= '<div class="row">';
			$cont .= '	<div class="col-12 text-center mt-2 mt-md-4 mt-lg-5">';
			$cont .= '		<ul class="pagination justify-content-center mb-0">';
			$cont .= $halaman;
			$cont .= '		</ul>';
			$cont .= '	</div>';
			$cont .= '</div>';
		} else if ($kategori != null && $this->uri->segment(3) == '') {
			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="active">Kategori</li>';
			$cont .= '</ol>';

			foreach ($kategori as $row) {
				$cont .= '<div class="berita-detail" style="padding-bottom:10px; border-bottom:1px solid #EEE;">';
				$cont .= '	<h3 class="title-berita-detail"><a href="' . site_url() . 'home/kategori/' . $row['id_kategori'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['kategori']))) . '"> ' . ucfirst($row['kategori']) . ' </a></h3>';
				$cont .= '</div>';
			}
		} else {
			$cont .= 'Kategori ' . clang('not found!');
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function poling()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$cont = '';
		$where_pol[] = array(
			'where_field' => 'parent_poling',
			'where_key' => '0'
		);
		$where_pol[] = array(
			'where_field' => 'status_poling',
			'where_key' => 'open'
		);
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_poling',
				'where_key' => $this->uri->segment(3)
			);
		}
		$jml_poling = $this->crud->get('poling', $where_pol);
		$config['base_url'] = site_url() . 'home/poling/page/' . $this->uri->segment(4);
		$config['uri_segment'] = 5;
		$config['total_rows'] = count($jml_poling);
		$config['per_page'] = 10;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(5) != '') {
			$offset = $this->uri->segment(5);
		} else {
			$offset = 0;
		}

		$rule_pol['order_field'] = 'id_poling';
		$rule_pol['order_by'] = 'desc';
		$rule_pol['limit'] = $config['per_page'];
		$rule_pol['offset'] = $offset;
		$poling = $this->crud->get('poling', $where_pol, $rule_pol);
		if ($poling != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $poling[0];
			$tgl = explode(' ', $row['tgl_poling']);
			$tgl2 = explode('-', $tgl[0]);

			$tgl_ = explode(' ', $row['tgl_akhir']);
			$tgl2_ = explode('-', $tgl_[0]);

			$where_pol_pil[] = array(
				'where_field' => 'parent_poling',
				'where_key' => $this->uri->segment(3)
			);
			$where_pol_pil[] = array(
				'where_field' => 'status_poling',
				'where_key' => 'open'
			);
			$pil = $this->crud->get('poling', $where_pol_pil);
			$total = 0;
			foreach ($pil as $row2) {
				$where_pol_hasil[1] = array(
					'where_field' => 'id_poling_',
					'where_key' => $row2['id_poling']
				);
				$jml_pil = $this->crud->get('poling_hasil', $where_pol_hasil);
				if ($jml_pil != null) {
					$jml[$row2['id_poling']] = count($jml_pil);
				} else {
					$jml[$row2['id_poling']] = 0;
				}
				$total += $jml[$row2['id_poling']];
			}

			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li><a href="' . site_url() . 'home/poling">Poling</a></li>';
			if (strlen($this->uri->segment(4)) > 30) {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', substr($this->uri->segment(4), 0, 30))) . '...</li>';
			} else {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', $this->uri->segment(4))) . '</li>';
			}
			$cont .= '</ol>';

			$cont .= '<div class="berita-detail" style="padding-bottom:10px; border-bottom:1px solid #EEE;">';
			$cont .= '	<h3 class="title-berita-detail">' . ucfirst($row['nama_poling']) . '</h3>';
			$cont .= '	<span class="tgl-berita-terpopuler">';
			$cont .= '		Dibuka sejak <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0];
			if ($row['status_poling_2'] == 'close') {
				$cont .= '		, ditutup pada <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2_[1], $tgl2_[2], $tgl2_[0]))) . ', ' . $tgl2_[2] . ' ' . bln($tgl2_[1]) . ' ' . $tgl2_[0];
			}
			$cont .= '	</span>';
			$cont .= '	<div class="berita-content">';
			$cont .= '		<p>Total : ' . $total . ' suara</p>';

			foreach ($pil as $row2) {
				if ($jml[$row2['id_poling']] != 0 && $total != 0) {
					$persen = ($jml[$row2['id_poling']] / $total) * 100;
				} else {
					$persen = 0;
				}
				$cont .= 			$row2['nama_poling'] . '<span class="pull-right">' . $persen . '%</span>';
				$cont .= '			<div class="progress">';
				$cont .= '			  <div class="progress-bar" role="progressbar" aria-valuenow="' . $persen . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $persen . '%;"></div>';
				$cont .= '			</div>';
			}

			$cont .= '	</div>';
			$cont .= '</div>';
		} else if ($poling != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {
			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="active">Poling</li>';
			$cont .= '</ol>';

			foreach ($poling as $row) {
				$tgl = explode(' ', $row['tgl_poling']);
				$tgl2 = explode('-', $tgl[0]);
				$tgl_ = explode(' ', $row['tgl_akhir']);
				$tgl2_ = explode('-', $tgl_[0]);

				$cont .= '<div class="berita-detail" style="padding-bottom:10px; border-bottom:1px solid #EEE;">';
				$cont .= '	<h3 class="title-berita-detail"><a href="' . site_url() . 'home/poling/' . $row['id_poling'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['nama_poling']))) . '">' . ucfirst($row['nama_poling']) . '</a></h3>';
				$cont .= '	<span class="tgl-berita-terpopuler">';
				$cont .= '		Dibuka sejak <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0];
				if ($row['status_poling_2'] == 'close') {
					$cont .= '		, ditutup pada <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2_[1], $tgl2_[2], $tgl2_[0]))) . ', ' . $tgl2_[2] . ' ' . bln($tgl2_[1]) . ' ' . $tgl2_[0];
				}
				$cont .= '	</span>';
				$cont .= '</div>';
			}

			$cont .= '<div class="berita-detail pagination">';
			$cont .= $halaman;
			$cont .= '</div>';
		} else {
			$cont .= 'Kategori ' . clang('not found!');
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function halaman()
	{
		if ($this->uri->segment(2) == 'halaman') $data['is_page'] = 1;
		if ($this->uri->segment(3) != '') {
			$cont = '';
			$where_hal[] = array(
				'where_field' => 'tipe',
				'where_key' => 'page'
			);
			if ($this->uri->segment(5) != 'preview') {
				$where_hal[] = array(
					'where_field' => 'status_tulisan',
					'where_key' => 'terbit'
				);
			}
			if ($this->uri->segment(3) != '') {
				$where_hal[] = array(
					'where_field' => 'id_tulisan',
					'where_key' => $this->uri->segment(3)
				);
			}
			$join_hal[1] = array(
				'target_table' => 'pengguna',
				'target_field' => 'id_pengguna',
				'parent_field' => 'penulis'
			);
			$halaman = $this->crud->get('tulisan', $where_hal, null, $join_hal);
			if ($halaman != null) {
				$row = $halaman[0];

				if (isset($row['view'])) {
					$data_ = array(
						'view' => $row['view'] + 1
					);
					$where = array(
						array(
							'where_field' => 'id_tulisan',
							'where_key' => $row['id_tulisan']
						)
					);
					$this->crud->update('tulisan', $data_, $where);
				}

				if (isset($row['judul_' . $this->session->userdata('lang')])) {
					$ses['keywords'] = substr(str_replace(' ', ',', strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')])), 0, 150);
					$ses['description'] = substr(strip_tags($row['judul_' . $this->session->userdata('lang')] . ' ' . $row['tulisan_' . $this->session->userdata('lang')]), 0, 250);
					$this->session->set_userdata($ses);
				}

				if (isset($row['gambar_andalan'])) {
					$ses['image'] = $this->path() . '/' . $row['gambar_andalan'];
					$this->session->set_userdata($ses);
				}

				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);

				if ($row['status_komentar'] == 'open') {
					$where_kom[] = array(
						'where_field' => 'id_tul',
						'where_key' => $this->uri->segment(3)
					);
					$where_kom[] = array(
						'where_field' => 'status_komentar_',
						'where_key' => 'terbit'
					);
					$join_kom[1] = array(
						'target_table' => 'pengguna',
						'target_field' => 'id_pengguna',
						'parent_field' => 'id_user'
					);
					$komentar = $this->crud->get('komentar', $where_kom, null, $join_kom);
					if ($komentar != null) {
						$jml_kom = count($komentar);
						foreach ($komentar as $row_kom) {
							$kom_[$row_kom['parent_komentar']][$row_kom['id_komentar']] = $row_kom;
						}
					} else {
						$jml_kom = 0;
					}
				}

				// isi konten halaman
				$cont .= '<section class="page_breadcrumbs ds parallax section_padding_top_100 section_padding_bottom_100">';
				$cont .= '	<div class="container">';
				$cont .= '		<div class="row">';
				$cont .= '			<div class="col-sm-12 text-center">';
				$cont .= '				<h2 class="highlight2">' . ucfirst($row['judul_' . $this->session->userdata('lang')]) . '</h2>';
				$cont .= '				<ol class="breadcrumb darklinks">';
				$cont .= '<ol class="breadcrumb">';
				$cont .= '    <li class="breadcrumb-item"><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
				if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
					$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
				} else {
					$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
				}
				$cont .= '</ol>';
				$cont .= '					<li>';
				// syntax dibawah ini tidak digunakan
				// if (strlen($row['judul_' . $this->session->userdata('lang')]) > 30) {
				// 	$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', substr($row['judul_' . $this->session->userdata('lang')], 0, 30))) . '...</li>';
				// } else {
				// 	$cont .= '    <li class="breadcrumb-item active">' . ucfirst(str_replace('-', ' ', $row['judul_' . $this->session->userdata('lang')])) . '</li>';
				// }
				$cont .= '					</li>';
				$cont .= '				</ol>';
				$cont .= '			<div>';
				$cont .= '		</div>';
				$cont .= '	</div>';
				$cont .= '</section>';
				// PART:: isi halaman

				// $cont .= '<section class="space-ptb">';
				// $cont .= '<div class="container">';
				// $cont .= '<div class="row">';

				// $cont .= '<div class="berita-detail">';
				// $cont .= '<div class="berita-content">';
				// $cont .= '	<div class="berita-img-2">';
				// if ($row['gambar_andalan'] != '') {
				// 	$cont .= '		<img src="' . $this->path() . '/' . $row['gambar_andalan'] . '">';
				// }
				// $cont .= '	</div>';
				// $cont .= $row['tulisan_' . $this->session->userdata('lang')];
				// $cont .= '</div>';
				// $cont .= '<div class="berita-meta">';

				// $cont .= '</section>';
				// $cont .= '</div>';
				// $cont .= '</div>';

				// $cont .= '</div>';

				$cont .= '<section class="ls section_padding_top_100 section_padding_bottom_100 columns_padding_25">';
				$cont .= '		<div class="container">';
				$cont .= '			<div class="row">';
				$cont .= '				<div class="col-sm-7 col-md-8 col-lg-12">';
				$cont .= '					<article class="single-post vertical-item post with_border content-padding big-padding">';
				$cont .= '						<div class="entry-thumbnail item-media">';
				if ($row['gambar_andalan'] != '') {
					$cont .= '		<img class="img-fluid" src="' . $this->path() . '/' . $row['gambar_andalan'] . '">';
				}
				$cont .= '						</div>';
				$cont .= '						<div class="item-content">';
				$cont .= '							<div class="entry-content">';
				$cont .=								'<p>' . $row['tulisan_' . $this->session->userdata('lang')] . '</p>';
				$cont .= '							</div>';
				$cont .= '						</div>';
				$cont .= '					</article>';
				$cont .= '				</div>';
				$cont .= '		</div>';
				$cont .= '	</div>';
				$cont .= '</section>';


				// PARTS:: DI OFF KAN
				// if ($row['status_komentar'] == 'open') {
				// 	$cont .= '<span> ' . clang('Comment') . ': <a href="#"> ' . $jml_kom . ' </a> </span>';
				// }
				// $cont .= '	<span> ' . clang('Share') . ': ';
				// $cont .= '		<a href="https://plus.google.com/share?url=' . site_url() . 'home/berita/' . $row['id_tulisan'] . '" onclick="javascript:window.open(this.href,
				// 			\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;">';
				// $cont .= '			<img style="width:12px;height:12px;margin-top:-3px;" src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>';
				// $cont .= '		</a>';
				// $cont .= '		<i class="fb-share-button" data-href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '" data-layout="icon" style="width:14px;"></i> ';
				// $cont .= '	</span>';
				// $cont .= '	<span> ' . clang('Print') . ': ';
				// $cont .= '		<a target="blank" href="' . site_url('home/pdf/halaman/' . $row['id_tulisan']) . '"><i class="fa fa-file-o"></i></a> ';
				// $cont .= '		<a target="blank" href="' . site_url('home/word/halaman/' . $row['id_tulisan']) . '"><i class="fa fa-file-text-o"></i></a> ';
				// $cont .= '	</span>';
				// $cont .= '</div>';

				if ($row['status_komentar'] == 'open') {
					$cont .= '<div class="komentar_user">';
					if ($jml_kom != 0) {
						$cont .= '	<div class="list-komentar">';
						$cont .= '		<h3> Komentar </h3>';
						$cont .= '		<ul>';
						foreach ($kom_[0] as $row_k) {
							$i = 1;
							$cont .= $this->set_komentar($row_k, $kom_, $i);
						}
						$cont .= '		</ul>';
						$cont .= '	</div>';
					}
					$cont .= '<div class="form-komentar post-comment">';
					$cont .= '	<h3> Tinggalkan Komentar </h3>';
					$cont .= '	<form id="contact_us" name="contact_us" action="' . site_url('home/komentar/' . $this->uri->segment('2') . '/' . $this->uri->segment('3') . '/' . $this->uri->segment('4')) . '" method="post">';
					$cont .= '		<input name="id_komentar" type="hidden" value="0">';
					if ($this->session->userdata('id_pengguna') == '') {
						$cont .= '		<div class="form-group">';
						$cont .= '			<label> Nama </label>';
						$cont .= '			<input class="form-control" type="text" placeholder="Name" name="nama_komentar" id="nama-komentar">';
						$cont .= '		</div>';
						$cont .= '		<div class="form-group">';
						$cont .= '			<label> Email </label>';
						$cont .= '			<input class="form-control" type="email" placeholder="Email" name="email_komentar" id="email-komentar">';
						$cont .= '		</div>';
					}
					$cont .= '		<div class="form-group">';
					$cont .= '			<label> Komentar </label>';
					$cont .= '			<textarea class="form-control" name="isi_komentar" id="isi-komentar" cols="60" rows="15"> </textarea> <br>';
					$cont .= '		</div>';
					$cont .= '		<div class="form-group">';
					$cont .= '			<input class="btn btn-default btn-primary" type="submit" value="Kirim">';
					$cont .= '		</div>';
					$cont .= '	</form>';
					$cont .= '</div>';
					$cont .= '</div>';
				}
				$cont .= '</div>';

				$cont .= $this->balas_komentar();

				$cont .= '	<div id="fb-root"></div>';
				$cont .= '	<script>(function(d, s, id) {';
				$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
				$cont .= '	  if (d.getElementById(id)) return;';
				$cont .= '	  js = d.createElement(s); js.id = id;';
				$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=789972341083504&version=v2.0";';
				$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
				$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
			}

			$data['content'] = $cont;
			getTheme();
			$this->theme->set_theme(THEME);
			$this->theme->render('home', $data);
		} else {
			redirect('home');
		}
	}

	function set_komentar($row, $parent, $i)
	{
		$bln = array(
			'01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
		);

		$hari = array(
			'1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu', '7' => 'Minggu'
		);
		$komentar = "";
		if (@$row['foto'] && $row['foto'] != '') {
			$img = base_url('assets/img/img_andalan') . '/' . $row['foto'];
		} else {
			$img = base_url('assets/img/web/no_image_komentar.png');
		}
		$tgl = explode(' ', $row['tgl_komentar']);
		$tgl2 = explode('-', $tgl[0]);
		if (isset($parent[$row['id_komentar']]) && $parent[$row['id_komentar']] != null) {
			$komentar .= '<li>
					<div class="komentar-holder">
						<div class="komentar-img">
							<img src="' . $img . '" class="avatar photo" alt="">
						</div>
						<div class="komentar-content">
							<h3>' . $row['nama'] . '</h3>
							<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . $bln[$tgl2[1]] . ' ' . $tgl2[2] . ', ' . $tgl2[0] . ' - pada ' . $tgl[1] . '</span>
							<p>' . $row['komentar'] . '</p>
							<a onclick="set_form_komentar(\'' . $row['id_komentar'] . '\')" class="btn btn-default btn-primary balas">Balas</a>
							<div class="form-komentar-c" id="form-balas-' . $row['id_komentar'] . '"></div>
							<ul class="children" style="width:100%">';
			$i++;
			foreach ($parent[$row['id_komentar']] as $row2) {
				$komentar .= $this->set_komentar($row2, $parent, $i);
			}
			$komentar .= '</ul>
						</div>
					</div>
				</li>';
		} else {
			$komentar .= '<li>
					<div class="komentar-holder">
						<div class="komentar-img">
							<img src="' . $img . '" class="avatar photo" alt="">
						</div>
						<div class="komentar-content">
							<h3>' . $row['nama'] . '</h3>
							<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . $bln[$tgl2[1]] . ' ' . $tgl2[2] . ', ' . $tgl2[0] . ' - pada ' . $tgl[1] . '</span>
							<p>' . $row['komentar'] . '</p>
							<a onclick="set_form_komentar(\'' . $row['id_komentar'] . '\')" class="btn btn-default btn-primary balas">Balas</a>
							<div class="form-komentar-c" id="form-balas-' . $row['id_komentar'] . '"></div>
						</div>
					</div>
				</li>';
		}
		return $komentar;
	}

	function balas_komentar()
	{
		$balas = '<script>';
		$balas .= 'id_pengguna = "' . $this->session->userdata("id_pengguna") . '";';
		$balas .= 'function set_form_komentar(id){';
		$balas .= 'url = "' . site_url('home/komentar/' . $this->uri->segment('2') . '/' . $this->uri->segment('3') . '/' . $this->uri->segment('4')) . '";';
		$balas .= '$(\'.post-comment\').hide();';
		$balas .= '$(\'.form-komentar-c\').html(\'\');';
		$balas .= 'form = \'<div class="form-komentar post-comment">\'';
		$balas .= '+\'<h3> ' . clang('Reply Comments') . ' </h3>\'';
		$balas .= '+\'<form id="contact_us" name="contact_us" action="\'+url+\'" method="post">\'';
		$balas .= '+\'<input name="id_komentar" type="hidden" value="\'+id+\'">\';';
		$balas .= 'if(id_pengguna==\'\'){';
		$balas .= 'form+=\'<div class="form-group">\'';
		$balas .= '+\'<label> ' . clang('Name') . ' </label>\'';
		$balas .= '+\'<input class="form-control" type="text" placeholder="' . clang('Name') . '" name="nama_komentar" id="nama-komentar">\'';
		$balas .= '+\'</div>\'';
		$balas .= '+\'<div class="form-group">\'';
		$balas .= '+\'<label> ' . clang('Email') . ' </label>\'';
		$balas .= '+\'<input class="form-control" type="email" placeholder="' . clang('Email') . '" name="email_komentar" id="email-komentar">\'';
		$balas .= '+\'</div>\';';
		$balas .= '}';
		$balas .= 'form+=\'<div class="form-group">\'';
		$balas .= '+\'<label> ' . clang('Comment') . ' </label>\'';
		$balas .= '+\'<textarea class="form-control" name="isi_komentar" id="isi-komentar" cols="60" rows="15"> </textarea> <br>\'';
		$balas .= '+\'</div>\'';
		$balas .= '+\'<div class="form-group">\'';
		$balas .= '+\'<input class="btn btn-default btn-primary" type="submit" value="Kirim"> \'';
		$balas .= '+\'<input class="btn btn-default btn-primary" type="reset" onclick="batal_form_komentar()" value="Batal">\'';
		$balas .= '+\'</div>\'';
		$balas .= '+\'</form>\'';
		$balas .= '+\'</div>\';';
		$balas .= '$(\'#form-balas-\'+id).html(form);';
		$balas .= '}';
		$balas .= 'function batal_form_komentar(){';
		$balas .= '$(\'.post-comment\').show();';
		$balas .= '$(\'.form-komentar-c\').html(\'\');';
		$balas .= '}';
		$balas .= '</script>';
		return $balas;
	}

	function komentar()
	{
		$table_name = 'komentar';
		if ($this->db->table_exists($table_name)) {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$this->form_validation->set_rules('isi_komentar', 'isi_komentar', 'required');
				if ($this->form_validation->run()) {
					if ($this->session->userdata('id_pengguna') != '') {
						$id_user = $this->session->userdata('id_pengguna');
					} else {
						$id_user = 0;
					}
					if ($this->session->userdata('username') != '') {
						$nm_user = $this->session->userdata('username');
					} else {
						$nm_user = strip_tags($this->input->post('nama_komentar'));
					}
					if ($this->session->userdata('email') != '') {
						$email_user = $this->session->userdata('email');
					} else {
						$email_user = strip_tags($this->input->post('email_komentar'));
					}
					$data = array(
						'id_tul' => $this->uri->segment('4'),
						'parent_komentar' => $this->input->post('id_komentar'),
						'nama' => $nm_user,
						'email' => $email_user,
						'komentar' => strip_tags($this->input->post('isi_komentar')),
						'tgl_komentar' => date('Y-m-d h:i:s'),
						'id_user' => $id_user
					);
					$this->crud->insert($table_name, $data);
					$ses = 'Komentar berhasil disimpan';
				} else {
					$ses = 'Komentar gagal disimpan';
				}
			} else {
				$ses = 'ERROR!';
			}
		} else {
			$data['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		redirect('home/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
	}


	function buku_tamu()
	{
		$cont = '';
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;
		$cari = $this->input->post('pencarian');
		$this->session->set_flashdata('cari', $cari);
		if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$where[] = array(
				'where_field' => 'id_testimoni',
				'where_key' => $this->uri->segment(3)
			);
		}
		$where[] = array(
			'where_field' => 'parent',
			'where_key' => '0'
		);
		$where[] = array(
			'where_field' => 'status_testimoni_',
			'where_key' => 'terbit'
		);

		$tes_all = $this->crud->get('testimoni', $where);

		$config['base_url'] = site_url() . 'home/buku_tamu/page/';
		$config['uri_segment'] = 4;
		$config['total_rows'] = count($tes_all);
		$config['per_page'] = 10;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(4) != '') {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}

		$rule['order_field'] = 'id_testimoni';
		$rule['order_by'] 	 = 'desc';
		$rule['limit'] 		 = $config['per_page'];
		$rule['offset'] 	 = $offset;

		$berita = $this->crud->get('testimoni', $where, $rule);
		if ($berita != null && $this->uri->segment(3) != '' && $this->uri->segment(3) != 'page') {
			$row = $berita[0];

			if (isset($row['nama'])) {
				$ses['keywords'] = substr(str_replace(' ', ',', strip_tags($row['nama'] . ' ' . $row['testimoni'])), 0, 150);
				$ses['description'] = substr(strip_tags($row['nama'] . ' ' . $row['testimoni']), 0, 250);
				$this->session->set_userdata($ses);
			}

			if (isset($row['foto'])) {
				$ses['image'] = $this->path() . '/' . $row['foto'];
				$this->session->set_userdata($ses);
			}

			$string = "SELECT * FROM `testimoni` WHERE `time`='" . $row['time'] . "' AND ((`id_testimoni`='" . $row['id_testimoni'] . "' AND `status_testimoni_`='terbit') OR (`parent`='" . $row['id_testimoni'] . "' AND `status_testimoni_`='terbit'))";
			$tanggapan = $this->crud->get(null, null, null, null, null, $string);
			$jml_tang = 0;
			if ($tanggapan != null) {
				foreach ($tanggapan as $row_tang) {
					if ($row_tang['parent'] != '0') {
						$jml_tang++;
					}
					$tang_[$row_tang['parent']][$row_tang['id_testimoni']] = $row_tang;
				}
			}

			$tgl = explode(' ', $row['tgl_testimoni']);
			$tgl2 = explode('-', $tgl[0]);

			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li><a href="' . site_url() . 'home/buku_tamu">Buku Tamu</a></li>';
			if (strlen($row['testimoni']) > 30) {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', substr($row['testimoni'], 0, 30))) . '...</li>';
			} else {
				$cont .= '    <li class="active">' . ucfirst(str_replace('-', ' ', $row['testimoni'])) . '</li>';
			}
			$cont .= '</ol>';

			$cont .= '<div class="berita-detail">';
			$cont .= '<h1 class="title-berita-detail">' . ucfirst($row['testimoni']) . '</h1>';
			$cont .= '<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nama'] . ' / ' . $row['instansi'] . '</span>';
			$cont .= '<div class="berita-meta">';
			$cont .= '<span> Tanggapan: <a href="#"> ' . $jml_tang . ' </a> </span>';
			$cont .= '	<span> ' . clang('Share') . ': ';
			$cont .= '		<a href="https://plus.google.com/share?url=' . site_url() . 'home/buku_tamu/' . $row['id_testimoni'] . '" onclick="javascript:window.open(this.href,
						\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;">';
			$cont .= '			<img style="width:12px;height:12px;margin-top:-3px;" src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>';
			$cont .= '		</a>';
			$cont .= '		<i class="fb-share-button" data-href="' . site_url() . 'home/buku_tamu/' . $row['id_testimoni'] . '" data-layout="icon" style="width:14px;"></i> ';
			$cont .= '	</span>';
			$cont .= '	<span> ' . clang('Print') . ': ';
			$cont .= '		<a target="blank" href="' . site_url('home/pdf/buku_tamu/' . $row['id_testimoni']) . '"><i class="fa fa-file-o"></i></a> ';
			$cont .= '		<a target="blank" href="' . site_url('home/word/buku_tamu/' . $row['id_testimoni']) . '"><i class="fa fa-file-text-o"></i></a> ';
			$cont .= '	</span>';
			$cont .= '</div>';

			$cont .= '<div class="komentar_user">';
			if ($jml_tang != 0) {
				$cont .= '	<div class="list-komentar">';
				$cont .= '		<h3> Tanggapan </h3>';
				$cont .= '		<ul>';
				foreach ($tang_[0] as $row_t) {
					$i = 1;
					$cont .= $this->set_tanggapan($row_t, $tang_, $i);
				}
				$cont .= '		</ul>';
				$cont .= '	</div>';
			}

			$cont .= '<div class="form-komentar post-comment">';
			$cont .= '	<h3> Tanggapi </h3>';
			$cont .= '	<form id="contact_us" name="contact_us" action="' . site_url('home/addtestimonitanggapan/' . $this->uri->segment('2') . '/' . $this->uri->segment('3') . '/' . $this->uri->segment('4')) . '" method="post">';
			$cont .= '		<input name="time" type="hidden" value="' . $row['time'] . '">';
			$cont .= '		<input name="parent" type="hidden" value="' . $row['id_testimoni'] . '">';
			if ($this->session->userdata('id_pengguna') == '') {
				$cont .= '		<div class="form-group">';
				$cont .= '			<label> Nama </label>';
				$cont .= '			<input class="form-control" type="text" placeholder="Name" name="username" id="username-buku-tamu">';
				$cont .= '		</div>';
				$cont .= '		<div class="form-group">';
				$cont .= '			<label> Email </label>';
				$cont .= '			<input class="form-control" type="email" placeholder="Email" name="email" id="email-buku-tamu">';
				$cont .= '		</div>';
				$cont .= '		<div class="form-group">';
				$cont .= '			<label> Instansi /Pekerjaan </label>';
				$cont .= '			<input class="form-control" type="text" placeholder="Instansi /Pekerjaan" name="instansi" id="instansi-buku-tamu">';
				$cont .= '		</div>';
			}
			$cont .= '		<div class="form-group">';
			$cont .= '			<label> Tanggapan </label>';
			$cont .= '			<textarea class="form-control" name="testimoni" id="testimoni-buku-tamu" cols="60" rows="15"> </textarea> <br>';
			$cont .= '		</div>';
			$cont .= '		<div class="form-group">';
			$cont .= '			<input class="btn btn-default btn-primary" type="submit" value="Kirim">';
			$cont .= '		</div>';
			$cont .= '	</form>';
			$cont .= '</div>';
			$cont .= '</div>';
			$cont .= '</div>';

			$cont .= $this->balas_tanggapan();

			$cont .= '	<div id="fb-root"></div>';
			$cont .= '	<script>(function(d, s, id) {';
			$cont .= '	  var js, fjs = d.getElementsByTagName(s)[0];';
			$cont .= '	  if (d.getElementById(id)) return;';
			$cont .= '	  js = d.createElement(s); js.id = id;';
			$cont .= '	  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&appId=789972341083504&version=v2.0";';
			$cont .= '	  fjs.parentNode.insertBefore(js, fjs);';
			$cont .= '	}(document, \'script\', \'facebook-jssdk\'));</script>';
		} else if ($berita != null && ($this->uri->segment(3) == '' || $this->uri->segment(3) == 'page')) {
			$cont .= '<ol class="breadcrumb">';
			$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
			$cont .= '    <li class="active">Buku Tamu</li>';
			$cont .= '</ol>';

			foreach ($berita as $row) {
				$tgl = explode(' ', $row['tgl_testimoni']);
				$tgl2 = explode('-', $tgl[0]);
				$cont .= '<div class="berita-detail" style="padding-bottom:10px; border-bottom:1px solid #EEE;">';
				$cont .= '	<h3 class="title-berita-detail"><a href="' . site_url() . 'home/buku_tamu/' . $row['id_testimoni'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['nama']))) . '"> ' . ucfirst($row['nama']) . ' </a></h3>';
				$cont .= '	<div class="row">';
				$cont .= '		<div class="col-lg-12">';
				$cont .= '			<span class="tgl-berita-terpopuler">' . clang('Write on') . ' <i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '</span>';
				$cont .= '			<p>' . $row['testimoni'] . '</p>';
				$cont .= '			<a href="' . site_url() . 'home/buku_tamu/' . $row['id_testimoni'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['nama']))) . '"> Lihat Tanggapan</a>';
				$cont .= '		</div>';
				$cont .= '	</div>';
				$cont .= '</div>';
			}

			$cont .= '<div class="form-komentar post-comment" style="padding:10px;">';
			$cont .= '	<h3> Buku Tamu </h3>';
			$cont .= '	<form id="contact_us" name="contact_us" action="' . site_url('home/addtestimonitanggapan/' . $this->uri->segment('2') . '/' . $this->uri->segment('3') . '/' . $this->uri->segment('4')) . '" method="post">';
			$cont .= '		<input name="time" type="hidden" value="' . date('dmy') . '">';
			$cont .= '		<input name="parent" type="hidden" value="0">';
			if ($this->session->userdata('id_pengguna') == '') {
				$cont .= '		<div class="form-group">';
				$cont .= '			<label> Nama </label>';
				$cont .= '			<input class="form-control" type="text" placeholder="Name" name="username" id="username-buku-tamu">';
				$cont .= '		</div>';
				$cont .= '		<div class="form-group">';
				$cont .= '			<label> Email </label>';
				$cont .= '			<input class="form-control" type="email" placeholder="Email" name="email" id="email-buku-tamu">';
				$cont .= '		</div>';
				$cont .= '		<div class="form-group">';
				$cont .= '			<label> Instansi /Pekerjaan </label>';
				$cont .= '			<input class="form-control" type="text" placeholder="Instansi /Pekerjaan" name="instansi" id="instansi-buku-tamu">';
				$cont .= '		</div>';
			}
			$cont .= '		<div class="form-group">';
			$cont .= '			<label> Tanggapan </label>';
			$cont .= '			<textarea class="form-control" name="testimoni" id="testimoni-buku-tamu" cols="60" rows="15"> </textarea> <br>';
			$cont .= '		</div>';
			$cont .= '		<div class="form-group">';
			$cont .= '			<input class="btn btn-default btn-primary" type="submit" value="Kirim">';
			$cont .= '		</div>';
			$cont .= '	</form>';
			$cont .= '</div>';

			$cont .= '<div class="berita-detail pagination">';
			$cont .= $halaman;
			$cont .= '</div>';
		} else {
			if ($cari != '') {
				$cont .= 'Buku Tamu <b>' . $cari . '</b> ' . clang('not found!');
			} else {
				$cont .= 'Buku Tamu ' . clang('not found!');
			}
		}
		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}



	function set_tanggapan($row, $parent, $i)
	{
		$bln = array(
			'01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
		);

		$hari = array(
			'1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu', '7' => 'Minggu'
		);
		$tanggapan = "";
		if (@$row['foto'] && $row['foto'] != '') {
			$img = base_url('assets/img/img_andalan') . '/' . $row['foto'];
		} else {
			$img = base_url('assets/img/web/no_image_komentar.png');
		}
		$tgl = explode(' ', $row['tgl_testimoni']);
		$tgl2 = explode('-', $tgl[0]);
		if (isset($parent[$row['id_testimoni']]) && $parent[$row['id_testimoni']] != null) {
			if ($i > 1) {
				$tanggapan .= '<li>
					<div class="komentar-holder">
						<div class="komentar-img">
							<img src="' . $img . '" class="avatar photo" alt="">
						</div>
						<div class="komentar-content">
							<h3>' . $row['nama'] . '</h3>
							<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . $bln[$tgl2[1]] . ' ' . $tgl2[2] . ', ' . $tgl2[0] . ' - pada ' . $tgl[1] . '</span>
							<p>' . $row['testimoni'] . '</p>
							<a onclick="set_form_testimoni(\'' . $row['time'] . '\',\'' . $row['id_testimoni'] . '\')" class="btn btn-default btn-primary balas">Tanggapi</a>
							<div class="form-testimoni-c" id="form-balas-testimoni-' . $row['id_testimoni'] . '"></div>
							<ul class="children" style="width:100%">';
				$i++;
				foreach ($parent[$row['id_testimoni']] as $row2) {
					$tanggapan .= $this->set_tanggapan($row2, $parent, $i);
				}
				$tanggapan .= '</ul>
						</div>
					</div>
				</li>';
			} else {
				$i++;
				foreach ($parent[$row['id_testimoni']] as $row2) {
					$tanggapan .= $this->set_tanggapan($row2, $parent, $i);
				}
			}
		} else {
			$tanggapan .= '<li>
					<div class="komentar-holder">
						<div class="komentar-img">
							<img src="' . $img . '" class="avatar photo" alt="">
						</div>
						<div class="komentar-content">
							<h3>' . $row['nama'] . '</h3>
							<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . $bln[$tgl2[1]] . ' ' . $tgl2[2] . ', ' . $tgl2[0] . ' - pada ' . $tgl[1] . '</span>
							<p>' . $row['testimoni'] . '</p>
							<a onclick="set_form_testimoni(\'' . $row['time'] . '\',\'' . $row['id_testimoni'] . '\')" class="btn btn-default btn-primary balas">Tanggapi</a>
							<div class="form-testimoni-c" id="form-balas-testimoni-' . $row['id_testimoni'] . '"></div>
						</div>
					</div>
				</li>';
		}
		return $tanggapan;
	}

	function balas_tanggapan()
	{
		$balas = '<script>';
		$balas .= 'id_pengguna = "' . $this->session->userdata("id_pengguna") . '";';
		$balas .= 'function set_form_testimoni(time,id){';
		$balas .= 'url = "' . site_url('home/addtestimonitanggapan/' . $this->uri->segment('2') . '/' . $this->uri->segment('3') . '/' . $this->uri->segment('4')) . '";';
		$balas .= '$(\'.post-comment\').hide();';
		$balas .= '$(\'.form-komentar-c\').html(\'\');';
		$balas .= 'form = \'<div class="form-komentar post-comment">\'';
		$balas .= '+\'<h3> Tanggapi </h3>\'';
		$balas .= '+\'<form id="contact_us" name="contact_us" action="\'+url+\'" method="post">\'';
		$balas .= '+\'<input name="time" type="hidden" value="\'+time+\'">\'';
		$balas .= '+\'<input name="parent" type="hidden" value="\'+id+\'">\';';
		$balas .= 'if(id_pengguna==\'\'){';
		$balas .= 'form+=\'<div class="form-group">\'';
		$balas .= '+\'<label> ' . clang('Name') . ' </label>\'';
		$balas .= '+\'<input class="form-control" type="text" placeholder="' . clang('Name') . '" name="username" id="username-buku-tamu">\'';
		$balas .= '+\'</div>\'';
		$balas .= '+\'<div class="form-group">\'';
		$balas .= '+\'<label> ' . clang('Email') . ' </label>\'';
		$balas .= '+\'<input class="form-control" type="email" placeholder="' . clang('Email') . '" name="email" id="email-buku-tamu">\'';
		$balas .= '+\'</div>\';';
		$balas .= '+\'<div class="form-group">\'';
		$balas .= '+\'<label> Instansi / Pekerjaan </label>\'';
		$balas .= '+\'<input class="form-control" type="email" placeholder="Instansi / Pekerjaan" name="instansi" id="instansi-buku-tamu">\'';
		$balas .= '+\'</div>\';';
		$balas .= '}';
		$balas .= 'form+=\'<div class="form-group">\'';
		$balas .= '+\'<label> Tanggapan </label>\'';
		$balas .= '+\'<textarea class="form-control" name="testimoni" id="testimoni-buku-tamu" cols="60" rows="15"> </textarea> <br>\'';
		$balas .= '+\'</div>\'';
		$balas .= '+\'<div class="form-group">\'';
		$balas .= '+\'<input class="btn btn-default btn-primary" type="submit" value="Kirim"> \'';
		$balas .= '+\'<input class="btn btn-default btn-primary" type="reset" onclick="batal_form_testimoni()" value="Batal">\'';
		$balas .= '+\'</div>\'';
		$balas .= '+\'</form>\'';
		$balas .= '+\'</div>\';';
		$balas .= '$(\'#form-balas-testimoni-\'+id).html(form);';
		$balas .= '}';
		$balas .= 'function batal_form_testimoni(){';
		$balas .= '$(\'.post-comment\').show();';
		$balas .= '$(\'.form-testimoni-c\').html(\'\');';
		$balas .= '}';
		$balas .= '</script>';
		return $balas;
	}

	function pdf()
	{
		$pdf = new FPDF();
		$pdf->AddPage('P', 'Legal');
		$pdf->SetMargins('20', '5');
		$pdf->SetFont('Arial', 'B', 14);
		$lebar = 180;

		$uri = 4;
		$name_pdf = '';
		if ($this->uri->segment($uri) != '') {
			if ($this->uri->segment($uri - 1) != 'halaman') {
				$tipe = $this->uri->segment($uri - 1);
				$data['berita_'] = $this->kategoriLabelBy('label', $tipe);
				if (isset($data['berita_']['kategori'][0]['id_kategori'])) {
					$detail	= $this->tulisan($data['berita_']['kategori'][0]['id_kategori'], 'terbit', null, $this->uri->segment($uri));
					if ($detail != null) {
						$row = $detail['tulisan_' . $this->session->userdata('lang')][0];
					}
				}
			} else {
				$tipe = 'page';
				$detail	= $this->tulisan($tipe, 'terbit', null, $this->uri->segment($uri));
				if ($detail != null) {
					$row = $detail['tulisan_' . $this->session->userdata('lang')][0];
				}
			}
			if (@$row) {
				$pdf->ln(10);
				$pdf->MultiCell($lebar, 5, $row['judul_' . $this->session->userdata('lang')], 0, 'C');
				$pdf->SetFont('Arial', 'I', 8);
				$pdf->Cell(0, 8, site_url() . $_SERVER['PATH_INFO'], 0, 0, 'C');
				$pdf->ln(10);
				if ($row['gambar_andalan'] != '') {
					$pdf->Image($this->path() . '/' . $row['gambar_andalan'], 20, 40, 180);
					$pdf->ln(70);
				}
				$pdf->SetFont('Arial', '', 10);
				$html = str_get_html($row['tulisan_' . $this->session->userdata('lang')]);
				// Find all images 
				$gbr = array();
				foreach ($html->find('img') as $elgbr)
					$gbr[] = $elgbr->src;
				$par = array();
				foreach ($html->find('p') as $elpar)
					$paragraph[] = strip_tags($elpar->innertext, '<p>');

				$pdf->MultiCell($lebar, 5, $paragraph[0], 0);
				$pdf->ln(4);
				count($gbr) > 0 ? $pdf->image($gbr[0], 65, null, 70) : null;

				foreach ($paragraph as $k => $v) {
					if ($k > 0)
						$pdf->MultiCell($lebar, 5, strip_tags($v), 0);
					$pdf->ln(3);
				}

				$pdf->SetY(-50);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(0, 20, 'Halaman ' . $pdf->PageNo(), 0, 0, 'C');
				$pdf->SetY(-50);
				$pdf->Cell(0, 20, date('d/m/Y'), 0, 0, 'R');
				$pdf->Output(strtolower(str_replace(' ', '_', substr($row['judul_' . $this->session->userdata('lang')], 0, 15))) . '.pdf', 'I');
			}
		} else {
			redirect('home');
		}
	}

	function word()
	{
		$data['header'] = 'aktif';
		$this->berita_pdf($data);
	}

	function berita_pdf($d = null)
	{
		$data['site'] = $this->web();
		$data['site']['page'] = 'Export Word';
		$uri = 4;
		if (isset($d['header']) && $d['header'] != '') {
			$data['header'] = $d['header'];
		}
		if ($this->uri->segment($uri) != '') {
			if ($this->uri->segment($uri - 1) != 'halaman') {
				$tipe = $this->uri->segment($uri - 1);
				$data['berita_'] = $this->kategoriLabelBy('label', $tipe);
				if (isset($data['berita_']['kategori'][0]['id_kategori'])) {
					$data['detail']	= $this->tulisan($data['berita_']['kategori'][0]['id_kategori'], 'terbit', null, $this->uri->segment($uri));
					if (isset($data['detail']['tulisan_' . $this->session->userdata('lang')][0]['judul_' . $this->session->userdata('lang')])) {
						$data['site']['page'] = $data['detail']['tulisan_' . $this->session->userdata('lang')][0]['judul_' . $this->session->userdata('lang')];
					}
				}
			} else {
				$tipe = 'page';
				$data['detail']	= $this->tulisan($tipe, 'terbit', null, $this->uri->segment($uri));
				if (isset($data['detail']['tulisan_' . $this->session->userdata('lang')][0]['judul_' . $this->session->userdata('lang')])) {
					$data['site']['page'] = $data['detail']['tulisan_' . $this->session->userdata('lang')][0]['judul_' . $this->session->userdata('lang')];
				}
			}
			$this->load->view('v_berita_word', $data);
		} else {
			redirect('home');
		}
	}

	function web()
	{
		$web_['web'] = null;
		$table_name = 'web';
		if ($this->db->table_exists($table_name)) {
			$web_['error'] = 0;
			$string = "SELECT * FROM `web`";
			$data = $this->crud->get(null, null, null, null, null, $string);
			if ($data == null) {
				$web_['error'] = 'web tidak ada!';
			} else {
				foreach ($data as $row) {
					$web_['web'][$row['option_name']] = $row['option_value'];
				}
			}
		} else {
			$web_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $web_;
	}

	function kategoriLabelBy($tipe = null, $slug = null, $id = null)
	{
		if ($tipe != null) {
			$tipe_kat = $tipe;
		} else {
			$tipe_kat = "category";
		}
		if ($id != null) {
			$id_kat = " AND `id_kategori`='" . $id . "'";
		} else {
			$id_kat = "";
		}
		if ($slug != null) {
			$slug_kat = " AND `slug`='" . $slug . "'";
		} else {
			$slug_kat = " AND (`slug`!='produk' OR `slug`!='servis' OR `slug`!='step' OR `slug`!='klien')";
		}
		$kategori_['kategori'] = null;
		$table_name = 'kategori';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='" . $tipe_kat . "' " . $id_kat . " " . $slug_kat;
			$kategori_['kategori'] = $this->crud->get(null, null, null, null, null, $string);
			if ($kategori_['kategori'] != null) {
				$kategori_['error'] = 0;
			} else {
				$kategori_['error'] = 'Kategori tidak ada!';
			}
		} else {
			$kategori_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $kategori_;
	}

	function tulisan($tipe = null, $status = null, $limit = null, $id = null, $pin = null, $order = null)
	{
		if ($tipe != null) {
			$tipe_tul = $tipe;
			$tipe2 = " AND `tulisan`.`tipe`='" . $tipe . "'";
		} else {
			$tipe_tul = "page";
			$tipe2 = "";
		}
		if ($status != null) {
			$sts_tul = $status;
		} else {
			$sts_tul = "terbit";
		}
		if ($limit != null) {
			$limit_tul = " LIMIT " . $limit;
		} else {
			$limit_tul = "";
		}
		if ($id != null) {
			$id_tul = " AND `tulisan`.`id_tulisan`='" . $id . "'";
		} else {
			$id_tul = "";
		}
		if ($pin != null) {
			$pin_tul = " AND `tulisan`.`pin`='" . $pin . "'";
		} else {
			$pin_tul = "";
		}
		if ($order != null) {
			$order_tul = $order;
		} else {
			$order_tul = "`tulisan`.`id_tulisan` DESC";
		}
		$tulisan_['tulisan_' . $this->session->userdata('lang')] = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `tulisan` JOIN `pengguna` ON `tulisan`.`penulis` = `pengguna`.`id_pengguna` WHERE `tulisan`.`tipe`='" . $tipe_tul . "' AND `tulisan`.`status_tulisan`='" . $sts_tul . "' " . $id_tul . " " . $pin_tul . " ORDER BY " . $order_tul . " " . $limit_tul;
			$tulisan_['tulisan_' . $this->session->userdata('lang')] = $this->crud->get(null, null, null, null, null, $string);
			if ($tulisan_['tulisan_' . $this->session->userdata('lang')] != null) {
				$tulisan_['error'] = 0;
				foreach ($tulisan_['tulisan_' . $this->session->userdata('lang')] as $id) {
					$table_name_1 = 'hub_kat_tul';
					$table_name_2 = 'kategori';
					if ($this->db->table_exists($table_name_1) && $this->db->table_exists($table_name_2)) {
						$tulisan_['kat_tul'][$id['id_tulisan']] = null;
						$string_ = "SELECT * FROM `hub_kat_tul` JOIN `kategori` ON `hub_kat_tul`.`id_kat` = `kategori`.`id_kategori` WHERE `hub_kat_tul`.`id_tul`=" . $id['id_tulisan'] . " AND `kategori`.`tipe_kategori`='category'";
						$tulisan_['kat_tul'][$id['id_tulisan']] = $this->crud->get(null, null, null, null, null, $string_);
						if ($tulisan_['kat_tul'][$id['id_tulisan']] != null) {
							$kategori = '';
							$string__ = '';
							$jml_kat = count($tulisan_['kat_tul'][$id['id_tulisan']]);
							$i = 1;
							foreach ($tulisan_['kat_tul'][$id['id_tulisan']] as $id_kat) {
								if ($i % $jml_kat == 0) {
									$kategori .= " (`hub_kat_tul`.`id_kat`=" . $id_kat['id_kat'] . ")";
								} else {
									$kategori .= " (`hub_kat_tul`.`id_kat`=" . $id_kat['id_kat'] . ") OR ";
								}
								$i++;
							}
							//$string__ = "SELECT DISTINCT `tulisan`.`id_tulisan`,`tulisan`.* FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE (".$kategori.") AND `tulisan`.`id_tulisan`!=".$id['id_tulisan'].$tipe2." AND `tulisan`.`status_tulisan`='terbit' ORDER BY `tulisan`.`tgl_tulisan` DESC ".$limit_tul;
							$string__ = "SELECT DISTINCT `tulisan`.`id_tulisan`,`tulisan`.* FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE (" . $kategori . ") " . $tipe2 . " AND `tulisan`.`status_tulisan`='terbit' ORDER BY `tulisan`.`tgl_tulisan` DESC " . $limit_tul;
							$tulisan_['tul_lain'][$id['id_tulisan']] = $this->crud->get(null, null, null, null, null, $string__);
						}
					}

					$table_name_3 = 'komentar';
					if ($this->db->table_exists($table_name_3)) {
						$tulisan_['kom_tul'][$id['id_tulisan']] = null;
						$string__ = "SELECT * FROM `komentar` JOIN `pengguna` ON `komentar`.`id_user` = `pengguna`.`id_pengguna` WHERE `id_tul`=" . $id['id_tulisan'] . " AND `status_komentar_`='terbit' ORDER BY `tgl_komentar` ASC";
						$kom = $this->crud->get(null, null, null, null, null, $string__);
						if ($kom != null) {
							$tulisan_['jml_kom_tul'][$id['id_tulisan']] = count($kom);
							foreach ($kom as $row) {
								$tulisan_['kom_tul'][$id['id_tulisan']][$row['parent_komentar']][] = $row;
							}
						} else {
							$tulisan_['jml_kom_tul'][$id['id_tulisan']] = 0;
						}
					}

					$table_name_4 = 'file';
					if ($this->db->table_exists($table_name_4)) {
						$tulisan_['file_tul'][$id['id_tulisan']] = null;
						$string_4 = "SELECT * FROM `file` WHERE `id_tulisan`=" . $id['id_tulisan'];
						$tulisan_['file_tul'][$id['id_tulisan']] = $this->crud->get(null, null, null, null, null, $string_4);
					}
				}
			} else {
				$tulisan_['error'] = 'Tulisan tidak ada!';
			}
		} else {
			$tulisan_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $tulisan_;
	}

	function addtestimoni()
	{
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name = 'testimoni';
		if ($this->db->table_exists($table_name)) {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$this->form_validation->set_rules('username', 'username', 'required');
				if ($this->form_validation->run()) {
					$data_ = array(
						'nama' => $this->input->post('username'),
						'time' => date('dmy'),
						'email' => $this->input->post('email'),
						'instansi' => $this->input->post('instansi'),
						'testimoni' => $this->input->post('testimoni'),
						'tgl_testimoni' => date('Y-m-d H:i:s'),
						'foto' => ''
					);
					$this->crud->insert($table_name, $data_);
				} else {
					$data['psn'] = 'testimoni gagal disimpan';
					$data['wrng'] = 'warning';
				}
			} else {
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		} else {
			$data['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		redirect('home');
	}

	function addtestimonitanggapan()
	{
		$data['psn'] = 'ok';
		$data['data'] = null;
		$table_name = 'testimoni';
		if ($this->db->table_exists($table_name)) {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$this->form_validation->set_rules('testimoni', 'testimoni', 'required');
				if ($this->form_validation->run()) {
					if ($this->session->userdata('id_pengguna') != '') {
						$id_user  = $this->session->userdata('id_pengguna');
						$instansi = 'administrator';
						$status   = 'terbit';
					} else {
						$id_user  = 0;
						$instansi = $this->input->post('instansi');
						$status   = 'menunggu';
					}
					if ($this->session->userdata('username') != '') {
						$nm_user = $this->session->userdata('username');
					} else {
						$nm_user = strip_tags($this->input->post('username'));
					}
					if ($this->session->userdata('email') != '') {
						$email_user = $this->session->userdata('email');
					} else {
						$email_user = strip_tags($this->input->post('email'));
					}
					$data_ = array(
						'nama' => $nm_user,
						'time' => $this->input->post('time'),
						'parent' => $this->input->post('parent'),
						'email' => $email_user,
						'instansi' => $instansi,
						'testimoni' => $this->input->post('testimoni'),
						'tgl_testimoni' => date('Y-m-d H:i:s'),
						'status_testimoni_' => $status,
						'foto' => ''
					);
					$this->crud->insert($table_name, $data_);
				} else {
					$data['psn'] = 'testimoni gagal disimpan';
					$data['wrng'] = 'warning';
				}
			} else {
				$data['psn'] = 'ERROR!';
				$data['wrng'] = 'danger';
			}
		} else {
			$data['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		redirect('home/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
	}

	function poling_user()
	{
		$table_name = 'poling_hasil';
		if ($this->db->table_exists($table_name)) {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$this->form_validation->set_rules('id_poling', 'id_poling', 'required');
				if ($this->form_validation->run()) {
					$where = array(
						array(
							'where_field' => 'ip_address',
							'where_key' => $this->session->userdata('ip_address')
						),
						array(
							'where_field' => 'id_poling_',
							'where_key' => $this->input->post('id_poling')
						)
					);
					$get = null;
					$get = $this->crud->get($table_name, $where);
					if ($get == null) {
						$data = array(
							'id_poling_' => $this->input->post('id_poling'),
							'ip_address' => $this->session->userdata('ip_address'),
							'tgl_poling_' => date('Y-m-d h:i:s')
						);
						$this->crud->insert($table_name, $data);
						$this->session->set_flashdata('danger', 'Poling berhasil disimpan');
					} else {
						$this->session->set_flashdata('warning', 'Anda sudah memberikan suara pada Poling ini!');
					}
				} else {
					$this->session->set_flashdata('warning', 'Poling gagal disimpan!');
				}
			} else {
				$this->session->set_flashdata('danger', 'ERROR!');
			}
		} else {
			$this->session->set_flashdata('danger', 'Tabel ' . $table_name . ' tidak ada!');
		}
		redirect('home/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
	}

	function data_keanggotaan()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;

		$statistik = $this->crud->get('perpusda_statistik', array(array('where_field' => 'tahun', 'where_key' => date('Y')), array('where_field' => 'jenis', 'where_key' => 'dk')));

		$cont .= '<ol class="breadcrumb">';
		$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
		$cont .= '    <li>Grafik Data Keanggotaan</li>';
		$cont .= '</ol>';

		$cont .= '<div class="berita-detail">';
		$cont .= '	<h3 class="title-berita-detail">Statistik Data Keanggotaan</h3>';
		$cont .= '</div>';
		$cont .= '<div class="berita-content">';
		$cont .= '	<div class="panel panel-default square-btn-adjust">';
		$cont .= '		<div class="panel-body" style="min-height:300px">';
		$cont .= '			<div class="statistik-pengunjung"></div>';
		$cont .= '		</div>';
		$cont .= '	</div>';
		$cont .= '</div>';

		$cont .= $this->grafik($statistik, 'Grafik Data Keanggotaan', 'Jumlah Anggota');

		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function pengunjung_perpustakaan()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;

		$statistik = $this->crud->get('perpusda_statistik', array(array('where_field' => 'tahun', 'where_key' => date('Y')), array('where_field' => 'jenis', 'where_key' => 'pengp')));

		$cont .= '<ol class="breadcrumb">';
		$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
		$cont .= '    <li>Grafik Pengunjung Perpustakaan</li>';
		$cont .= '</ol>';

		$cont .= '<div class="berita-detail">';
		$cont .= '	<h3 class="title-berita-detail">Statistik Pengunjung Perpustakaan</h3>';
		$cont .= '</div>';
		$cont .= '<div class="berita-content">';
		$cont .= '	<div class="panel panel-default square-btn-adjust">';
		$cont .= '		<div class="panel-body" style="min-height:300px">';
		$cont .= '			<div class="statistik-pengunjung"></div>';
		$cont .= '		</div>';
		$cont .= '	</div>';
		$cont .= '</div>';

		$cont .= $this->grafik($statistik, 'Grafik Pengunjung Perpustakaan', 'Jumlah Pengunjung');

		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function peminjam_perpustakaan()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;

		$statistik = $this->crud->get('perpusda_statistik', array(array('where_field' => 'tahun', 'where_key' => date('Y')), array('where_field' => 'jenis', 'where_key' => 'pemp')));

		$cont .= '<ol class="breadcrumb">';
		$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
		$cont .= '    <li>Grafik Peminjam Perpustakaan</li>';
		$cont .= '</ol>';

		$cont .= '<div class="berita-detail">';
		$cont .= '	<h3 class="title-berita-detail">Statistik Peminjam Perpustakaan</h3>';
		$cont .= '</div>';
		$cont .= '<div class="berita-content">';
		$cont .= '	<div class="panel panel-default square-btn-adjust">';
		$cont .= '		<div class="panel-body" style="min-height:300px">';
		$cont .= '			<div class="statistik-pengunjung"></div>';
		$cont .= '		</div>';
		$cont .= '	</div>';
		$cont .= '</div>';

		$cont .= $this->grafik($statistik, 'Grafik Peminjam Perpustakaan', 'Jumlah Peminjam');

		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function grafik($statistik, $judul, $jml)
	{
		$grafik = '';
		$grafik .= '<script src="' . base_url('assets/jquery/jquery-2.1.3.min.js') . '"></script>';
		$grafik .= '<script src="' . base_url('assets/plugin/highchart/highcharts.js') . '"></script>';
		$grafik .= '<script src="' . base_url('assets/plugin/highchart/exporting.js') . '"></script>';
		$datal = $datap = '0,0,0,0,0,0,0,0,0,0,0,0';
		if (@$statistik[0]) {
			for ($i = 1; $i <= 12; $i++) {
				$p[] = $statistik[0]['p' . $i];
				$l[] = $statistik[0]['l' . $i];
			}
			$datal = implode(',', $l);
			$datap = implode(',', $p);
		}
		$grafik .= '<script>';
		$grafik .= '$(\'.statistik-pengunjung\').highcharts({';
		$grafik .= '    chart: {';
		$grafik .= '		type: \'column\'';
		$grafik .= '	},';
		$grafik .= '	title: {';
		$grafik .= '		text: \'' . $judul . ' Tahun ' . date("Y") . '\'';
		$grafik .= '	},';
		$grafik .= '	subtitle: {';
		$grafik .= '		text: \'' . site_url() . '\'';
		$grafik .= '	},';
		$grafik .= '	xAxis: {';
		$grafik .= '		categories: [\'Jan\', \'Feb\', \'Mar\', \'Apr\', \'May\', \'Jun\', \'Jul\', \'Aug\', \'Sep\', \'Oct\', \'Nov\', \'Dec\']';
		$grafik .= '	},';
		$grafik .= '	yAxis: {';
		$grafik .= '		min: 0,';
		$grafik .= '		title: {';
		$grafik .= '			text: \'' . $jml . '\'';
		$grafik .= '		}';
		$grafik .= '	},';
		$grafik .= '	tooltip: {';
		$grafik .= '		valueSuffix: \' org\'';
		$grafik .= '	},';
		$grafik .= '	series: [{';
		$grafik .= '		name: \'Laki-laki\',';
		$grafik .= '		data: [' . $datal . ']';
		$grafik .= '	},';
		$grafik .= '	{';
		$grafik .= '		name: \'Perempuan\',';
		$grafik .= '		data: [' . $datap . ']';
		$grafik .= '	}],';
		$grafik .= '	credits: {';
		$grafik .= '		enabled: false';
		$grafik .= '	}';
		$grafik .= '});';
		$grafik .= '</script>';

		return $grafik;
	}

	function errors()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;


		$cont = '<ol class="breadcrumb">';
		// $cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
		// $cont .= '    <li>Errors</li>';
		$cont .= '</ol>';

		$cont .= '<section class="space-ptb">';
		$cont .= '	<div class="container">';
		$cont .= '		<div class="row justify-content-center">';
		$cont .= '			<div class="col-md-10 text-center">';
		$cont .= '				<div class="error-404-images">';
		$cont .= '					<img class="img-fluid" width="300" ' . 'src = "themes/umk/assets2/images/logo.png"' . 'alt="#">';
		$cont .= '				</div>';
		$cont .= '				<div class="error-404">';
		$cont .= '					<h1>Whoops</h1>';
		$cont .= '					<h4>Halaman Yang Anda Cari Tidak Di Temukan Silahkan</h4>';
		$cont .= '					<a class="btn btn-lg btn-primary" href="home">Kembali Ke Home</a>';
		$cont .= '				</div>';
		$cont .= '			</div>';
		$cont .= '		</div>';
		$cont .= '	</div>';
		$cont .= '</section>';

		// $cont .= $this->grafik($statistik,'Grafik Peminjam Perpustakaan','Jumlah Peminjam');

		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}



	function site_map()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;

		$cont = '<ol class="breadcrumb">';
		$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
		$cont .= '    <li>Peta Situs</li>';
		$cont .= '</ol>';

		$cont .= '<div class="berita-content">';
		$cont .= '<ul>';
		$cont .= '<li>Menu Atas <ul>' . get_menu_atas_sitemap() . '</ul></li>';
		$cont .= '<li>Menu Utama <ul>' . get_menu_sitemap() . '</ul></li>';
		$cont .= '<li>Menu Bawah <ul>' . get_menu_bawah_sitemap() . '</ul></li>';
		$cont .= '<li>Isi <ul>';
		$cont .= '<li><a href="' . site_url('home/berita') . '">' . clang('News') . '</a></li>';
		$cont .= '<li><a href="' . site_url('home/event') . '">Agenda</a></li>';
		$cont .= '<li><a href="' . site_url('home/pengumuman') . '">Pengumuman</a></li>';
		$cont .= '<li><a href="' . site_url('home/album') . '">Album</a></li>';
		$cont .= '<li><a href="' . site_url('home/video') . '">Video</a></li>';
		$cont .= '<li><a href="' . site_url('home/ebook') . '">Buku Digital</a></li>';
		$cont .= '<li><a href="' . site_url('home/kategori') . '">Kategori</a><ul>';
		$cont .= get_kategori_sitemap();
		$cont .= '</ul></li>';
		$cont .= '</ul></li>';
		$cont .= '</ul>';
		$cont .= '</div>';

		$data['content'] = $cont;
		$this->create_xml();
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}

	function create_xml()
	{
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$xml .= '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">';

		$xml .= get_menu_atas_sitemap('xml');
		$xml .= get_menu_bawah_sitemap('xml');
		$xml .= get_tulisan_sitemap();
		$xml .= get_kategori_sitemap('xml');

		$xml .= '</urlset>';

		$fp = fopen("sitemap.xml", "wb");
		fwrite($fp, $xml);
		fclose($fp);
	}


	function sto()
	{
		if ($this->uri->segment(2) != 'halaman') $data['is_article'] = 1;

		$cont = '<ol class="breadcrumb">';
		$cont .= '    <li><a href="' . site_url('') . '">' . clang('home') . '</a></li>';
		$cont .= '    <li>Struktur Organisasi</li>';
		$cont .= '</ol>';

		$where_sto[] = array(
			'where_field' => 'status_sto',
			'where_key' => 'aktif'
		);

		$sto_all = $this->crud->get('sto', $where_sto);

		$config['base_url'] = site_url() . 'home/sto';
		$config['uri_segment'] = 3;
		$config['total_rows'] = count($sto_all);
		$config['per_page'] = 10;
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '«';
		$config['prev_page'] = '»';
		$this->pagination->initialize($config);
		$halaman = $this->pagination->create_links();
		if ($this->uri->segment(3) != '') {
			$offset = $this->uri->segment(3);
		} else {
			$offset = 0;
		}

		$rule_sto['order_field'] = 'nm_dp';
		$rule_sto['order_by'] 	 = 'asc';
		$rule_sto['limit'] 		 = $config['per_page'];
		$rule_sto['offset'] 	 = $offset;
		$sto = $this->crud->get('sto', $where_sto, $rule_sto);

		$cont .= '<div class="berita-detail">';
		$cont .= '	<h3 class="title-berita-detail">Struktur Organisasi</h3>';
		$cont .= '</div>';
		if ($sto != null) {
			foreach ($sto as $row) {
				$cont .= '<div class="berita-detail">';
				$cont .= '	<div class="row">';
				$cont .= '		<div class="col-lg-3" style="max-widt:150px;max-height:200px;overflow:hidden;">';
				$cont .= '			<img src="' . $this->path() . '/thumb/' . $row['foto'] . '" style="width:100%;">';
				$cont .= '		</div>';
				$cont .= '		<div class="col-lg-9">';
				$cont .= '		<table class="table table-striped">';
				$cont .= '			<tr>';
				$cont .= '				<td width="25%">NIP</td>';
				$cont .= '				<td>: ' . $row['nip'] . '</td>';
				$cont .= '			</tr>';
				$cont .= '			<tr>';
				$cont .= '				<td>Nama</td>';
				$cont .= '				<td>: ' . $row['nm_dp'] . ' ' . $row['nm_blk'] . '</td>';
				$cont .= '			</tr>';
				$cont .= '			<tr>';
				$cont .= '				<td>Kota Kelahiran</td>';
				$cont .= '				<td>: ' . $row['kota_lahir'] . '</td>';
				$cont .= '			</tr>';
				$cont .= '			<tr>';
				$cont .= '				<td>Jabatan</td>';
				$cont .= '				<td>: ' . $row['jabatan'] . '</td>';
				$cont .= '			</tr>';
				$cont .= '			<tr>';
				$cont .= '				<td>Pangkat / Gol</td>';
				$cont .= '				<td>: ' . $row['pangkat'] . '</td>';
				$cont .= '			</tr>';
				$cont .= '			<tr>';
				$cont .= '				<td>Pendidikan</td>';
				$cont .= '				<td>: ' . $row['pendidikan'] . '</td>';
				$cont .= '			</tr>';
				$cont .= '		</table>';
				$cont .= '		</div>';
				$cont .= '	</div>';
				$cont .= '</div>';
			}
		}

		$cont .= '<div class="berita-detail pagination">';
		$cont .= $halaman;
		$cont .= '</div>';

		$data['content'] = $cont;
		getTheme();
		$this->theme->set_theme(THEME);
		$this->theme->render('home', $data);
	}
}
