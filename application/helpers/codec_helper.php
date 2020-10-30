<?php
if (!function_exists('CI')) {
	function CI()
	{
		$CI = &get_instance();
		return $CI;
	}
}

if (!function_exists('path')) {
	function path()
	{
		return base_url('assets/img/img_andalan/');
	}
}

if (!function_exists('cut_words')) {
	function cut_words($content, $word_count)
	{
		$space_count = 0;
		$print_string = '';
		for ($i = 0; $i < strlen($content); $i++) {
			if ($content[$i] == ' ')
				$space_count++;
			$print_string .= $content[$i];
			if ($space_count == $word_count)
				break;
		}
		return $print_string;
	}
}

if (!function_exists('get_bahasa')) {
	function get_bahasa()
	{
		$lang = '<link rel="stylesheet" href="' . base_url() . 'assets/icons/flags/flags.min.css" media="all">';
		$lang .= '<div class="dropdown" aria-labelledby="dropdownMenu1">';
		$lang .= '<button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
		if (CI()->session->userdata('lang') == 'id') {
			$lang .= '<span class="flag-ID"></span>&nbspID&nbsp&nbsp';
		}
		if (CI()->session->userdata('lang') == 'eng') {
			$lang .= '<span class="flag-_england"></span>&nbspEND&nbsp&nbsp';
		}
		if (CI()->session->userdata('lang') == 'ae') {
			$lang .= '<span class="flag-AE"></span>&nbspAE&nbsp&nbsp';
		}
		$lang .= '<span class="caret"></span>';
		$lang .= '</button>';
		$lang .= '<ul class="dropdown-menu">';
		if (CI()->session->userdata('lang') != 'id') {
			$lang .= '<li><a href="' . site_url('home/language/id') . '"><span class="flag-ID"></span>&nbspID</a></li>';
		}
		if (CI()->session->userdata('lang') != 'eng') {
			$lang .= '<li><a href="' . site_url('home/language/eng') . '"><span class="flag-_england"></span>&nbspEND</a></li>';
		}
		if (CI()->session->userdata('lang') != 'ae') {
			$lang .= '<li><a href="' . site_url('home/language/ae') . '"><span class="flag-AE"></span>&nbspAE</a></li>';
		}
		$lang .= '</ul>';
		$lang .= '</div>';
		return $lang;
	}
}

if (!function_exists('lang')) {
	function lang($s)
	{
		echo clang($s);
	}
}

if (!function_exists('clang')) {
	function clang($s)
	{
		$object_dict = json_decode(CI()->session->userdata('clang'));
		$found = false;
		for ($i = 0; $i < count($object_dict->dictionary); $i++) {
			$dt = $object_dict->dictionary;
			if ($dt[$i]->f == $s) {
				$found = true;
				return $dt[$i]->t;
				exit;
			}
		}
		if (!$found) {
			return $s;
		}
	}
}

if (!function_exists('get_search')) {
	function get_search()
	{
		$form = '<form id="form-pencarian" action="' . site_url('home/berita') . '" method="post">
				<div class="input-group input-pencarian">
					<input name="pencarian" id="pencarian" type="text" class="form-control" placeholder="' . clang('Searching...') . '" aria-describedby="basic-addon2" value="' . CI()->session->flashdata('cari') . '">
					<span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
				</div>
			</form>';
		return $form;
	}
}

if (!function_exists('get_book_opac')) {
	function get_book_opac()
	{
		$json_url = "http://opac.technophoriajogja.com/index.php/opac/webservice";
		$json = file_get_contents($json_url);
		$data = json_decode($json, TRUE);
		$slider = '';
		foreach ($data as $row) {
			$slider .= '<div class="recent-work-item">';
			$slider .= '	<div class="text-center" style="margin:0;">';
			$slider .= '		<div class="ch-item-2" style="background-image: url(http://opac.technophoriajogja.com/sampuls/' . $row['biblio_image'] . ');">';
			$slider .= '			<div class="ch-info-2">';
			$slider .= '				<h3><a target="blank" href="http://opac.technophoriajogja.com/index.php/opac/detail/' . $row['biblio_id'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['biblio_title']))) . '" title="' . $row['biblio_title'] . '"> ';
			$row['biblio_title'] . ' </a></h3>';
			$slider .= '				<p><a target="blank" href="http://opac.technophoriajogja.com/index.php/opac/detail/' . $row['biblio_id'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['biblio_title']))) . '" title="' . $row['biblio_title'] . '"> Detail </a></p>';
			$slider .= '			</div>';
			$slider .= '		</div>';
			$slider .= '	</div>';
			$slider .= '</div>';
			$no++;
		}
		return $slider;
	}
}

if (!function_exists('get_slideshow')) {
	function get_slideshow($indicator = null, $id = null)
	{
		$no = 1;
		$slide_ = $slide_ind = '';
		$slide = slide();
		if (@$slide['slide']) {
			$slide_ .= '<div class="carousel-inner box-carousel-utama" role="listbox">';
			$slide_ind .= '<ol class="carousel-indicators">';
			foreach ($slide['slide'] as $row) {
				if ($no == 1) {
					$first = 'active';
				} else {
					$first = '';
				}
				$slide_ .= '<div class="item ' . $first . ' text-center">';
				$slide_ .= '	<img style="width:100%;" src="' . CI()->path() . '/' . $row['kat_order'] . '" alt="Slide ' . $no . '">';
				$slide_ .= '</div>';
				$slide_ind .= '<li data-target="#' . $id . '" data-slide-to="' . ($no - 1) . '" class="' . $first . '"></li>';
				$no++;
			}
			$slide_ .= '</div>';
			$slide_ind .= '</ol>';
			if ($indicator == true) {
				$slide_ .= $slide_ind;
			}
		}
		return $slide_;
	}
	function slide()
	{
		$carousel_ =
			$q = null;
		$table_name = 'kategori';
		if (CI()->db->table_exists($table_name)) {
			CI()->db->where(array('status_kategori' => 'open', 'tipe_kategori' => 'slide'));
			CI()->db->order_by('id_kategori DESC');
			CI()->db->limit(1);
			$q = CI()->db->get('kategori')->result_array();
			if ($q != null) {
				$table_name_ = 'hub_slide_img';
				if (CI()->db->table_exists($table_name_)) {
					CI()->db->where('id_tul', $q[0]['id_kategori']);
					$carousel_smt = CI()->db->get('hub_slide_img')->result_array();
					$i = 1;
					if ($carousel_smt != null) {
						foreach ($carousel_smt as $row) {
							$id_kat = explode('|', $row['id_kat']);
							if ($id_kat[0] == 'post') {
								$post = null;
								CI()->db->where('id_tulisan', $id_kat[1]);
								$post = CI()->db->get('tulisan')->result_array();
								if ($post != null) {
									$carousel_['slide'][$i]['kat_order'] = $row['kat_order'];
									$carousel_['slide'][$i]['judul_' . CI()->session->userdata('lang')] = implode(' ', array_slice(explode(' ', strip_tags($post[0]['judul_' . CI()->session->userdata('lang')])), 0, 4)) . '...';
									$carousel_['slide'][$i]['keterangan'] = implode(' ', array_slice(explode(' ', strip_tags($post[0]['tulisan_' . CI()->session->userdata('lang')])), 0, 10)) . '...';
									if ($post[0]['tipe'] == 'post') {
										$tipe = 'berita';
									} else {
										$tipe = $post[0]['tipe'];
									}
									$carousel_['slide'][$i]['link'] = site_url('home/' . $tipe . '/' . $post[0]['id_tulisan']);
								} else {
									$carousel_['slide'][$i]['kat_order'] = $row['kat_order'];
									$carousel_['slide'][$i]['judul_' . CI()->session->userdata('lang')] = ucfirst($id_kat[0]);
									$carousel_['slide'][$i]['keterangan'] = ucfirst($id_kat[0]);
									$carousel_['slide'][$i]['link'] = site_url('home/' . $id_kat[0]);
								}
							} else {
								$carousel_['slide'][$i]['kat_order'] = $row['kat_order'];
								$carousel_['slide'][$i]['judul_' . CI()->session->userdata('lang')] = 'Gambar Andalan';
								$carousel_['slide'][$i]['keterangan'] = 'Gambar Andalan';
								$carousel_['slide'][$i]['link'] = site_url('home/album');
							}
							$i++;
						}
					}
				}
			}
		}
		return $carousel_;
	}
}

if (!function_exists('get_slider_post')) {
	function get_slider_post($label = 'berita', $limit = 5, $indicator = null, $id = null, $screen = '', $l = '6', $r = '6')
	{
		$berita = berita_label($label, $limit);
		$no = 1;
		$slider = '<div class="carousel-inner box-carousel-utama' . $screen . '" role="listbox">';
		$slide_ind = '<ol class="carousel-indicators' . $screen . ' hidden-xs">';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);
			if ($no == 1) {
				$active = 'active';
			} else {
				$active = '';
			}
			if ($row['gambar_andalan'] != '') {
				$img = CI()->path() . '/' . $row['gambar_andalan'];
			} else {
				$img = base_url('assets/img/web/no_image.png');
			}

			if ($screen == '') {
				$slider .= '<div class="item ' . $active . '">';
				$slider .= '	<div class="col-lg-' . $l . ' col-sm-' . $l . '">';
				$slider .= '		<div class="img-slider-post">';
				$slider .= '		<div class="img-slider-post2" style="width:100%;background:url(' . $img . ');background-position: center;background-size:cover;"></div>';
				$slider .= '		</div>';
				$slider .= '	</div>';
				$slider .= '	<div class="col-lg-' . $r . ' col-sm-' . $r . '">';
				$slider .= '		<h1><a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 10)));
				$slider .= (count(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')]))) > 10) ? '...' : '';
				$str = (count(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')]))) > 5) ? 350 : 550;
				$slider .= '</a></h1>';
				$slider .= '		<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
				$slider .= '		<p>' . substr(strip_tags($row['tulisan_' . CI()->session->userdata('lang')]), 0, $str) . '...<br><a class="btn btn-default btn-primary" href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . clang('Read more') . '</a></p>';
				$slider .= '	</div>';
				$slider .= '</div>';
				$slide_ind .= '<li data-target="#' . $id . '" data-slide-to="' . ($no - 1) . '" class="' . $active . '"></li>';
			} else if ($screen == 'full') {
				$slider .= '<div class="item ' . $active . '">';
				$slider .= '	<img src="' . $img . '" alt="img" class="img-slider-post">';
				$slider .= '	<div class="caption-carousel-full">';
				$slider .= '		<div class="text-carousel-full">';
				$slider .= '			<h1><a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst(substr($row['judul_' . CI()->session->userdata('lang')], 0, 20));
				if (strlen($row['judul_' . CI()->session->userdata('lang')]) > 20) {
					$slider .= '...';
				}
				$slider .= '			</a></h1>';
				$slider .= '			<p>' . substr(strip_tags($row['tulisan_' . CI()->session->userdata('lang')]), 0, 250) . '...</p>';
				$slider .= '		</div>';
				$slider .= '		<div class="button-carousel-full">';
				$slider .= '<a class="btn btn-default btn-warning" href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '"><i class="glyphicon glyphicon-chevron-right"></i></a>';
				$slider .= '<a class="btn btn-default btn-primary" href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . clang('Read more') . '</a>';
				$slider .= '		</div>';
				$slider .= '	</div>';
				$slider .= '</div>';
				$slide_ind .= '<li data-target="#' . $id . '" data-slide-to="' . ($no - 1) . '" class="' . $active . '">';
				$slide_ind .= '		<img src="' . $img . '" alt="img">';
				$slide_ind .= '</li>';
			}

			$no++;
		}
		$slide_ind .= '</ol>';
		if ($indicator == true) {
			$slider .= $slide_ind;
		}
		$slider .= '</div>';
		return $slider;
	}
}

if (!function_exists('get_slider_post_b1')) {
	function get_slider_post_b1($label = 'berita', $limit = 5, $indicator = null, $id = null, $screen = null)
	{
		$berita = berita_label($label, $limit);
		$no = 1;
		$slider = '	<section class="slider-01 bg-overlay-black-30 bg-holder">';
		$slider = '			<div id="main-slider" class="swiper-container">';
		$slider = '<div class="carousel-inner box-carousel-berita-utama2" role="listbox">';
		$slide_ind = '<ol class="carousel-indicators' . $screen . ' hidden-xs">';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);
			if ($no == 1) {
				$active = 'active';
			} else {
				$active = '';
			}
			if ($row['gambar_andalan'] != '') {
				$img = CI()->path() . '/' . $row['gambar_andalan'];
			} else {
				$img = base_url('assets/img/web/no_image.png');
			}
			$slider .= '<div class="item ' . $active . '">';
			$slider .= '	<div class="box-img-berita-utama2">';
			$slider .= '		<img src="' . $img . '" alt="img" style="margin-top:0px;">';
			$slider .= '	</div>';
			$slider .= '	<div class="box-ket-berita-utama2">';
			$slider .= '		<h4><a style="color:#FFF" href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 30)));
			$slider .= (count(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')]))) > 30) ? '...' : '';
			$slider .= '</a></h4>';


			$slider .= '	</section>';
			$slider .= '	</div>';
			$slider .= '	</div>';
			$slider .= '</div>';
			$slide_ind .= '<li data-target="#' . $id . '" data-slide-to="' . ($no - 1) . '" class="' . $active . '"></li>';
			$no++;
		}
		$slide_ind .= '</ol>';
		if ($indicator == true) {
			$slider .= $slide_ind;
		}
		$slider .= '</div>';
		return $slider;
	}
}

if (!function_exists('get_slider_post_b')) {
	function get_slider_post_b($label = 'berita', $limit = 5, $indicator = null, $id = null, $list_control = null, $des = null)
	{
		$screen = '';
		$berita = berita_label($label, $limit, 'a.id_tulisan desc');
		$no = 1;
		if ($list_control == null) {
			$col = 'col-lg-12';
		} else {
			$col = 'col-lg-9 col-sm-9';
		}
		$slider = '<div class="row" style="margin:0px;padding:0px;">';
		$slider .= '<div class="' . $col . '" style="padding:0px;">';
		$slider .= '<div class="carousel-inner box-carousel-berita-utama2" role="listbox">';
		$slide_ind = '<ol class="carousel-indicators' . $screen . ' hidden-xs">';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);
			if ($no == 1) {
				$active = 'active';
			} else {
				$active = '';
			}
			if ($row['gambar_andalan'] != '') {
				$img = CI()->path() . '/' . $row['gambar_andalan'];
			} else {
				$img = base_url('assets/img/web/no_image.png');
			}
			$slider .= '<div class="item ' . $active . '">';
			$slider .= '	<div class="box-img-berita-utama2" style="background:url(' . $img . ');background-position: center;background-size:cover;">';
			//$slider .= '		<img src="'.$img.'" alt="img" style="margin-top:0px;">';
			$slider .= '	</div>';
			$slider .= '	<div class="box-ket-berita-utama2">';
			$slider .= '		<h4><a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst(substr($row['judul_' . CI()->session->userdata('lang')], 0, 75)) . '</a></h4>';
			$slider .= '		<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> oleh: ' . $row['nm_dp'] . '</span>';
			if ($des == null || $des == 'yes') {
				$slider .= '		<p>' . substr(strip_tags($row['tulisan_' . CI()->session->userdata('lang')]), 0, 200) . '...<a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">Selengkapnya</a></p>';
			} else {
				$slider .= '<p></p>';
			}
			$slider .= '	</div>';
			$slider .= '</div>';
			$slide_ind .= '<li data-target="#' . $id . '" data-slide-to="' . ($no - 1) . '" class="' . $active . '"></li>';
			$no++;
		}
		$slide_ind .= '</ol>';
		if ($indicator == true) {
			$slider .= $slide_ind;
		}
		$slider .= '</div>';
		$slider .= '</div>';
		if ($list_control == 'yes') {
			$slider .= '<div class="col-lg-3 col-sm-3" style="padding:0px;">';
			$slider .= '	<ul class="carousel-indicators2 list-slider-control">';
			$no = 1;
			foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
				if ($no == 1) {
					$active = 'active';
				} else {
					$active = '';
				}
				$slider .= '	<li data-target="#' . $id . '" data-slide-to="' . ($no - 1) . '" class="' . $active . '">' . $row['judul_' . CI()->session->userdata('lang')] . '</li>';
				$no++;
			}
			$slider .= '	</ul>';
			$slider .= '</div>';
		}
		$slider .= '</div>';
		return $slider;
	}
}

if (!function_exists('get_slider_post_2')) {
	function get_slider_post_2($label = 'berita', $limit = 5)
	{
		$berita = berita_label($label, $limit);
		$no = 1;
		$slider = '';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);
			if ($row['gambar_andalan'] != '') {
				$img = CI()->path() . '/' . $row['gambar_andalan'];
			} else {
				$img = base_url('assets/img/web/no_image.png');
			}
			$slider .= '<div class="recent-work-item">';
			$slider .= '	<div class="text-center" style="margin:0;">';
			$slider .= '		<div class="ch-item-2" style="background-image: url(' . CI()->path() . '/' . $row['gambar_andalan'] . ');">';
			$slider .= '			<div class="ch-info-2">';
			$slider .= '				<h3><a href="' . site_url() . 'home/' . $label . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '"> ';
			$row['judul_' . CI()->session->userdata('lang')] . ' </a></h3>';
			$slider .= '				<p><a href="' . site_url() . 'home/' . $label . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '"> Detail </a></p>';
			$slider .= '			</div>';
			$slider .= '		</div>';
			$slider .= '	</div>';
			$slider .= '</div>';
			$no++;
		}
		return $slider;
	}
}

if (!function_exists('get_slider_post_4')) {
	function get_slider_post_4($tipe = 'album', $limit = 5)
	{
		$berita = tulisan($tipe, 'terbit', $limit, 'a.id_tulisan desc');
		$no = 1;
		$slider = '<div class="owl-carousel owl-carousel4">';
		foreach ($berita as $row) {
			if ($row['gambar_andalan'] != '') {
				$img = base_url('assets/img/album') . '/' . $row['id_tulisan'] . '/' . $row['gambar_andalan'];
			} else {
				$img = base_url('assets/img/web/no_image.png');
			}
			$slider .= '<div class="recent-work-item">';
			$slider .= '	<div class="text-center" style="margin:0;">';
			$slider .= '		<div class="ch-item-2" style="background-image: url(' . $img . ');background-position: center;background-size: cover;">';
			$slider .= '			<div class="ch-info-2">';
			$slider .= '				<h3><a href="' . site_url() . 'home/' . $tipe . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '"> ';
			$row['judul_' . CI()->session->userdata('lang')] . ' </a></h3>';
			$slider .= '				<p><a href="' . site_url() . 'home/' . $tipe . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '"> Detail </a></p>';
			$slider .= '			</div>';
			$slider .= '		</div>';
			$slider .= '	</div>';
			$slider .= '</div>';
			$no++;
		}
		$slider .= '</div>';
		return $slider;
	}
}

if (!function_exists('get_slider_beranda')) {
	function get_slider_beranda($label = 'berita', $limit = 5)
	{
		$berita = berita_label($label, $limit);
		$no = 1;
		$slider = '';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);
			if ($row['gambar_andalan'] != '') {
				$img = CI()->path() . '/' . $row['gambar_andalan'];
			} else {
				$img = base_url('assets/img/web/no_image.png');
			}

			$slider .= '<div class="recent-work-item" style="padding: 0px 10px;">';
			$slider .= '   <div class="panel panel-produk">';
			$slider .= '      <a href="' . site_url() . 'home/' . $label . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '"><img src="' . $row['gambar_andalan'] . '" style="width: 100%"></a>';
			$slider .= '      <div class="panel-body">';
			$slider .= '         <a href="' . site_url() . 'home/' . $label . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '"><h4>' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</h4></a>';
			$slider .= '         <p>' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 50)) . '</p>';
			$slider .= '      </div>';
			$slider .= '   </div>';
			$slider .= '</div>';
			$no++;
		}
		return $slider;
	}
}

if (!function_exists('get_berita_utama')) {
	function get_berita_utama($label = 'berita', $limit = 5)
	{
		$berita = berita_label($label, $limit);
		$no = 1;
		$slider = '';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);
			if ($no == 1) {
				$active = 'active';
			} else {
				$active = '';
			}
			if ($row['gambar_andalan'] != '') {
				$img = CI()->path() . '/' . $row['gambar_andalan'];
			} else {
				$img = base_url('assets/img/web/no_image.png');
			}
			$slider .= '<div class="media">';
			$slider .= '    <a class="media-left" href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '">';
			$slider .= '       <img class="media-object" src="' . $img . '" alt="#">';
			$slider .= '    </a>';
			$slider .= '    <div class="media-body">';
			$slider .= '       <h4 class="media-heading">';
			$slider .= '          <a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '">' . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 10)));
			$slider .= (count(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')]))) > 10) ? '...' : '';
			$slider .= '</a>';
			$slider .= '       </h4>';
			$slider .= '		<p>' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 20)) . ' […] <a class="more" href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '">' . clang('Read more') . '</a></p>';
			$slider .= '    </div>';
			$slider .= '</div>';
			$no++;
		}
		return $slider;
	}
}

if (!function_exists('list_tab_post')) {
	function list_tab_post($kategori = 'berita-1', $limit = 5, $mode = 'img')
	{
		$berita = berita_kategori($kategori, $limit);
		// die(print_r($berita));
		$no = 1;
		$tab = '';
		if (@$berita['tulisan_' . CI()->session->userdata('lang')] && $berita['tulisan_' . CI()->session->userdata('lang')] != null) {
			if ($mode == 'img') {
				foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
					$tgl = explode(' ', $row['tgl_tulisan']);
					$tgl2 = explode('-', $tgl[0]);
					if ($no == 1) {
						$active = 'active';
					} else {
						$active = '';
					}
					if ($row['gambar_andalan'] != '') {
						$img = CI()->path() . '/' . $row['gambar_andalan'];
					} else {
						$img = base_url('assets/img/web/no_image.png');
					}
					if ($berita['kategori'][0]['tipe_kategori'] == 'label') {
						$link = $berita['kategori'][0]['slug'];
					} else {
						$link = 'berita';
					}
					// <!-- PARTS::TEMPLATE_ENGINE('bagian berita')

					// PARTS::ISI KONTENNYA
					$tab .= '<article class="vertical-item content-padding with_border">';
					$tab .= '	<div class="item-media">';
					$tab .= '		<img class="img-fluid" src="' . $img . '" alt="img"> ';
					$tab .= '		<div class="cs vertical_gradient_bg_color entry-meta media-meta text-center">';
					$tab .= '			<div>';
					$tab .= '				<span class="date"><span class="tgl-berita-terpopuler">' . ' <i class="fa fa-user"></i> ' .  '</span>';
					$tab .= '				<span class="small-text big-spacing"> ' . clang('by') . ': ' . $row['nm_dp'] .  '</span>';
					$tab .= '			</div>';
					$tab .= '		</div>';
					$tab .= '	</div>';
					$tab .= '	<div class="item-content">';
					$tab .= '		<div class="catogories-links highlight2links small-text medium">';
					$tab .= '			<i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0];
					$tab .= '		</div>';
					$tab .= '		<h4 class="entry-title">';
					$tab .= '			<a class="blog-single-right.html" href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a>';
					$tab .= '		</h4>';
					$tab .= '		<div class="entry-content">';
					$tab .= '			<p>' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 10)) . '... <a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . clang('Read more') . '&rarr;</a></p>';
					$tab .= '		</div>';
					$tab .= '	</div>';
					$tab .= '</article>';


					// $tab .= '<div class="item">';
					// $tab .= '  <div class="service-style-02 mb-0 mb-md-4">';
					// $tab .= '     <div class="service-image">';
					// $tab .= '		<img class="img-fluid" src="' . $img . '" alt="img"> ';
					// $tab .= '     </div>';
					// $tab .= '     <div class="service-content">';
					// $tab .= '       <div class="blog-post-date"><span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span> </div>';
					// $tab .= '        <h6 class="service-title"><a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></h6>';
					// $tab .= '     </div>';
					// $tab .= '  </div>';
					// $tab .= '</div>';
					// $tab .= '		<p>' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 30)) . '... <a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . clang('Read more') . '&rarr;</a></p>';
					$no++;
				}
			} else if ($mode == 'list') {
				$tab .= '<div class="row item-berita1" style="margin:0;padding:0px;">';
				foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
					$tgl = explode(' ', $row['tgl_tulisan']);
					$tgl2 = explode('-', $tgl[0]);
					if ($row['gambar_andalan'] != '') {
						$img = CI()->path() . '/thumb/' . $row['gambar_andalan'];
					} else {
						$img = base_url('assets/img/web/no_image.png');
					}
					if ($berita['kategori'][0]['tipe_kategori'] == 'label') {
						$link = $berita['kategori'][0]['slug'];
					} else {
						$link = 'berita';
					}
					if ($no == 1) {
						$tab .= '<div class="col-md-5 col-sm-6">';
						$tab .= '	<div style="width:200%;height:200px;background:url(' . $img . ');background-position: center;background-size:cover;"></div>';
						$tab .= '	<h2 class="text-center"><a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 5)));
						$tab .= (count(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')]))) > 5) ? '...' : '';
						$tab .= '</a></h2>';
						$tab .= '	<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '</span>';
						$tab .= '	<p class="text-left">' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 30)) . '... <a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . clang('Read more') . '&rarr;</a></p>';
						$tab .= '</div>';
						$tab .= '<div class="col-md-7 col-sm-6">';
						$tab .= '	<ul class="tab-list-post-home">';
					} else {
						$tab .= '<li>';
						$tab .= '	<a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '"><i class="fa fa-rss"></i> ' . ucwords(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 5)));
						$tab .= (count(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')]))) > 5) ? '...' : '';
						$tab .= '</a>';
						$tab .= '	<p class="text-left">' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 20)) . '...</p>';
						$tab .= '	<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '</span>';
						$tab .= '</li>';
					}
					$no++;
				}
				$tab .= '		</ul>';
				$tab .= '	</div>';
				$tab .= '</div>';
			}
		}
		$tab .= '	<div class="text-right" style="margin-bottom:10px;margin-right:10px;">';
		$tab .= (@$berita['kategori'][0]['id_kategori']) ? '		<a class="btn btn-sm btn-info" href="' . site_url('home/kategori/' . $berita['kategori'][0]['id_kategori'] . '/' . $berita['kategori'][0]['slug']) . '"><b>' . ucfirst($berita['kategori'][0]['kategori']) . ' ' . clang('Other') . ' </b><i class="fa fa-arrow-right"></i></a>' : '';
		$tab .= '	</div>';
		return $tab;
	}
}

if (!function_exists('list_tab_post_2')) {
	function list_tab_post_2($label = 'pengumuman', $limit = 5, $mode = 'img')
	{
		$berita = berita_label($label, $limit, 'a.id_tulisan desc');
		$no = 1;
		$tab = '';
		if ($berita['tulisan_' . CI()->session->userdata('lang')] != null) {
			if ($mode == 'img') {
				foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
					$tgl = explode(' ', $row['tgl_tulisan']);
					$tgl2 = explode('-', $tgl[0]);
					if ($no == 1) {
						$active = 'active';
					} else {
						$active = '';
					}
					if ($row['gambar_andalan'] != '') {
						$img = CI()->path() . '/thumb/' . $row['gambar_andalan'];
					} else {
						$img = base_url('assets/img/web/no_image.png');
					}
					if ($berita['label'][0]['tipe_kategori'] == 'label') {
						$link = $berita['label'][0]['slug'];
					} else {
						$link = 'berita';
					}
					// <!-- PARTS::TEMPLATE_ENGINE('bagian pengumuman')
					$tab .= '<div class="item">';
					$tab .= '  <div class="service-style-02 mb-0 mb-md-4">';
					$tab .= '     <div class="service-image">';
					$tab .= '			<span class="btn btn-dark"><i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . ' <i class="fa fa-user"></i> ' . clang('by') . ': ' . $row['nm_dp'] . '</span>';
					$tab .= '     </div>';
					$tab .= '     <div class="service-content">';
					$tab .= '			<h4 class="service-title">';
					$tab .= '				<a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></h2>';
					$tab .= '			</h4>';
					$tab .= '			<p>' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 20)) . '... <a class="btn btn-dark" href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . clang('Read more') . '&rarr;</a></p>';
					$tab .= '     </div>';
					$tab .= '  </div>';
					$tab .= '</div>';
					$no++;
				}
			} else if ($mode == 'list') {
				$tab .= '<div class="row item-berita1" style="margin:0;padding:0px;">';
				foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
					$tgl = explode(' ', $row['tgl_tulisan']);
					$tgl2 = explode('-', $tgl[0]);
					if ($row['gambar_andalan'] != '') {
						$img = CI()->path() . '/thumb/' . $row['gambar_andalan'];
					} else {
						$img = base_url('assets/img/web/no_image.png');
					}
					if ($berita['label'][0]['tipe_kategori'] == 'label') {
						$link = $berita['label'][0]['slug'];
					} else {
						$link = 'berita';
					}
					if ($no == 1) {
						$tab .= '<div class="service-style-02 mb-0 mb-md-4">';
						if ($img != '') {
							$tab .= '	<div style="width:100%;height:120px;background:url(' . $img . ');background-position: center;background-size:cover;"></div>';
						}
						$tab .= '	<h2 class="service-title"><a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 5)));
						$tab .= (count(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')]))) > 5) ? '...' : '';
						$tab .= '</a></h2>';
						$tab .= '	<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '</span>';
						$tab .= '	<p class="text-left">' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 30)) . '... <a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . clang('Read more') . '&rarr;</a></p>';
						$tab .= '</div>';
						$tab .= '<div class="col-md-7 col-sm-6">';
						$tab .= '	<ul class="tab-list-post-home">';
					} else {
						$tab .= '<li>';
						$tab .= '	<a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '"><i class="fa fa-bullhorn"></i> ' . ucwords(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 5)));
						$tab .= (count(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')]))) > 5) ? '...' : '';
						$tab .= '</a>';
						$tab .= '	<p class="text-left">' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 20)) . '...</p>';
						$tab .= '	<span class="tgl-berita-terpopuler"><i class="fa fa-clock-o"></i> ' . hari(date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))) . ', ' . $tgl2[2] . ' ' . bln($tgl2[1]) . ' ' . $tgl2[0] . '</span>';
						$tab .= '</li>';
					}
					$no++;
				}
				$tab .= '		</ul>';
				$tab .= '	</div>';
				$tab .= '</div>';
			}
		}
		return $tab;
	}
}

if (!function_exists('list_post1')) {
	function list_post1($label = 'berita', $limit = 5)
	{
		$berita = berita_label($label, $limit);
		$no = 1;
		$icon = '';
		if ($label == 'berita') {
			$icon = '<i class="fa fa-rss"></i> ';
		} else if ($label == 'pengumuman') {
			$icon = '<i class="fa fa-bullhorn"></i> ';
		} else if ($label == 'event') {
			$icon = '<i class="fa fa-calendar"></i> ';
		} else if ($label == 'ebook') {
			$icon = '<i class="fa fa-book"></i> ';
		}
		$tab = '<div style="margin-bottom:10px;">';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tab .= '<div class="item-berita">';
			if ($berita['label'][0]['tipe_kategori'] == 'label') {
				$link = $berita['label'][0]['slug'];
			} else {
				$link = 'berita';
			}
			$tab .= '	<h5><a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . $icon . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 10)));
			$tab .= (count(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')]))) > 10) ? '...' : '';
			$tab .= '</a></h5>';
			$tab .= '</div>';
			$no++;
		}
		$tab .= '</div>';

		$tab .= '	<div class="text-right">';
		$tab .= '		<a href="' . site_url('home/' . $label) . '">' . ucfirst($berita['label'][0]['kategori']) . ' ' . clang('Other') . ' <i class="fa fa-arrow-right"></i></a>';
		$tab .= '	</div>';
		return $tab;
	}
}

if (!function_exists('list_post')) {
	function list_post($label = 'berita', $limit = 5, $order = 'a.id_tulisan desc', $mode = null)
	{
		$berita = berita_label($label, $limit, $order);
		$no = 1;
		$icon = '';
		if ($label == 'berita') {
			$icon = '<i class="fa fa-rss"></i> ';
		} else if ($label == 'pengumuman') {
			$icon = '<i class="fa fa-bullhorn"></i> ';
		} else if ($label == 'event') {
			$icon = '<i class="fa fa-calendar"></i> ';
		} else if ($label == 'ebook') {
			$icon = '<i class="fa fa-book"></i> ';
		}
		$tab = '<div style="margin-bottom:10px;">';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tab .= '<div class="item-berita">';
			if ($berita['label'][0]['tipe_kategori'] == 'label') {
				$link = $berita['label'][0]['slug'];
			} else {
				$link = 'berita';
			}

			if ($row['gambar_andalan'] != '') {
				$img = CI()->path() . '/thumb/' . $row['gambar_andalan'];
			} else {
				$img = '';
			}

			if ($mode == 'img') {
				$tab .= '<h5>';
				$tab .= '	<div class="berita" style="display: block;content: \'\';clear: both;width: 100%;">';
				$tab .= '		<div class="col-md-3 col-xs-3" style="padding:0px 3px;height:38px;background: url(' . $img . ');background-position: center;background-size: cover;">';
				$tab .= '		</div>';
				$tab .= '		<div class="col-md-9 col-xs-9" style="padding:0px 3px;">';
				$tab .= '			<a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '"><h5 class="list-group-item-heading">' . ucfirst(substr($row['judul_' . CI()->session->userdata('lang')], 0, 40)) . '...</h5></a>';
				$tab .= '		</div>';
				$tab .= '	</div>';
				$tab .= '</h5>';
			} else {
				$tab .= '	<h5><a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . $icon . ucfirst(strtolower(substr($row['judul_' . CI()->session->userdata('lang')], 0, 60))) . '</a></h5>';
			}
			$tab .= '</div>';

			$no++;
		}
		$tab .= '</div>';

		// $tab .= '	<div class="text-right">';
		// $tab .= '		<a href="'.site_url('home/'.$label).'"><b>'.ucfirst($berita['label'][0]['kategori']).' Lainnya </b><i class="fa fa-arrow-right"></i></a>';
		// $tab .= '	</div>';
		return $tab;
	}
}

if (!function_exists('list_download')) {
	function list_download($limit)
	{
		$no = 1;
		$SQL = "SELECT * FROM file WHERE status_file='y' ORDER BY id_file desc LIMIT " . $limit;
		$download = CI()->db->query($SQL)->result_array();
		$tab = '<div style="margin-bottom:10px;">';
		if ($download != null) {
			foreach ($download as $row) {
				$tab .= '<div class="item-berita">';
				if ($row['judul_file'] != '') {
					$tab .= '	<h5><a href="' . base_url() . 'assets/file/' . $row['file'] . '" title="' . $row['judul_file'] . '"><i class="fa fa-file"></i> ' . ucfirst(strtolower(substr($row['judul_file'], 0, 60))) . '</a></h5>';
				} else {
					$tab .= '	<h5><a href="' . base_url() . 'assets/file/' . $row['file'] . '" title="' . $row['judul_file'] . '"><i class="fa fa-file"></i> ' . strtolower(substr($row['file'], 0, 60)) . '</a></h5>';
				}
				$tab .= '</div>';

				$no++;
			}
		}
		$tab .= '</div>';

		// $tab .= '	<div class="text-right">';
		// $tab .= '		<a href="'.site_url('home/'.$label).'"><b>'.ucfirst($berita['label'][0]['kategori']).' Lainnya </b><i class="fa fa-arrow-right"></i></a>';
		// $tab .= '	</div>';
		return $tab;
	}
}

if (!function_exists('list_tab_post_3')) {
	function list_tab_post_3($label = 'event', $limit = 5, $mode = 'img')
	{
		$berita = berita_label($label, $limit, 'a.id_tulisan desc');
		$no = 1;
		$tab = '';
		if ($mode == 'img') {
			$tab .= '<div class="list-img">';
			foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);
				if ($berita['label'][0]['tipe_kategori'] == 'label') {
					$link = $berita['label'][0]['slug'];
				} else {
					$link = 'berita';
				}
				$tab .= '<div class="item-berita">';
				$tab .= '	<div class="box-img-berita-umum">';
				$tab .= '		<div class="agenda-tanggal text-center">';
				$tab .= '			<span class="tanggal">' . $tgl2[2] . '</span>';
				$tab .= '			<span class="tahun">' . bln2($tgl2[1]) . ' ' . $tgl2[0] . '</span>';
				$tab .= '		</div>';
				$tab .= '	</div>';
				$tab .= '	<div class="box-ket-berita-umum">';
				$tab .= '		<h2 style="display: block;content: \'\';clear: both;"><i class="fa ' . $berita['label'][0]['icon'] . '"></i>&nbsp<a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},']/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 8)));
				$tab .= (count(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')]))) > 8) ? '...' : '';
				$tab .= '</a></h2>';
				$tab .= '		<span class="tgl-berita-terpopuler">&nbsp<i class="fa fa-map-marker"></i> ' . $row['lokasi'] . '&nbsp</span>';
				$tab .= '	</div>';
				$tab .= '</div>';
				$no++;
			}
			$tab .= '</div>';
		} else if ($mode == 'list') {
			$tab .= '<div class="list-img">';
			foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
				$tgl = explode(' ', $row['tgl_tulisan']);
				$tgl2 = explode('-', $tgl[0]);
				if ($row['gambar_andalan'] != '') {
					$img = CI()->path() . '/thumb/' . $row['gambar_andalan'];
				} else {
					$img = '';
				}
				if ($berita['label'][0]['tipe_kategori'] == 'label') {
					$link = $berita['label'][0]['slug'];
				} else {
					$link = 'berita';
				}
				if ($no == 1) {
					$tab .= '<div class="item-berita" style="margin-bottom:5px;">';
					$tab .= '	<div class="box-img-berita-umum">';
					$tab .= '		<div class="agenda-tanggal text-center">';
					$tab .= '			<span class="tanggal">' . $tgl2[2] . '</span>';
					$tab .= '			<span class="tahun">' . bln2($tgl2[1]) . ' ' . $tgl2[0] . '</span>';
					$tab .= '		</div>';
					$tab .= '	</div>';
					$tab .= '	<div class="box-ket-berita-umum">';
					$tab .= '		<h2 style="display: block;content: \'\';clear: both;"><i class="fa ' . $berita['label'][0]['icon'] . '"></i>&nbsp<a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},']/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></h2>';
					$tab .= '		<span class="tgl-berita-terpopuler">&nbsp<i class="fa fa-clock-o"></i> ' . $row['lokasi'] . '&nbsp</span>';
					$tab .= '	</div>';
					$tab .= '</div>';
				} else {
					$tab .= '<div class="item-berita">';
					$tab .= '		<h2 style="display: block;content: \'\';clear: both;"><i class="fa ' . $berita['label'][0]['icon'] . '"></i>&nbsp<a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},']/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></h2>';
					$tab .= '</div>';
				}
				$no++;
			}
			$tab .= '</div>';
		} else if ($mode == 'title-only') {
			$tab .= '<div class="list-img">';
			foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
				if ($berita['label'][0]['tipe_kategori'] == 'label') {
					$link = $berita['label'][0]['slug'];
				} else {
					$link = 'berita';
				}
				$tab .= '<div class="item-berita">';
				$tab .= '		<h2 style="display: block;content: \'\';clear: both;"><i class="fa ' . $berita['label'][0]['icon'] . '"></i>&nbsp<a href="' . site_url() . 'home/' . $link . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},']/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></h2>';
				$tab .= '</div>';
				$no++;
			}
			$tab .= '</div>';
		}
		// $tab .= '	<div class="text-right" style="margin-bottom:10px;margin-right:10px;">';
		// $tab .= '		<a class="btn btn-sm btn-default" href="'.site_url('home/'.$label).'"><b>'.ucfirst($berita['label'][0]['kategori']).' '.clang('Other').' </b><i class="fa fa-arrow-right"></i></a>';
		// $tab .= '	</div>';
		return $tab;
	}
}

if (!function_exists('list_popular_post')) {
	function list_popular_post($label = 'berita', $limit = 5)
	{
		$berita = berita_label($label, $limit);
		$no = 1;
		$slider = '';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tgl = explode(' ', $row['tgl_tulisan']);
			$tgl2 = explode('-', $tgl[0]);
			if ($no == 1) {
				$active = 'active';
			} else {
				$active = '';
			}
			if ($row['gambar_andalan'] != '') {
				$img = CI()->path() . '/' . $row['gambar_andalan'];
			} else {
				$img = base_url('assets/img/web/no_image.png');
			}
			$slider .= '<li>';
			$v = $row['view'];
			if ($row['view'] >= 1000) {
				$v = round($row['view'] / 1000, 1) . ' rb';
			} else if ($row['view'] >= 1000000) {
				$v = round($row['view'] / 1000000, 1) . ' jt';
			} else if ($row['view'] >= 1000000000) {
				$v = round($row['view'] / 1000000000, 1) . ' m';
			}
			$slider .= '	<a href="' . site_url() . 'home/berita/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '"><i class="fa fa-rss"></i> ' . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 10)));
			$slider .= (count(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')]))) > 10) ? '...' : '';
			$slider .= '</a> [' . $v . 'x]';
			$slider .= '</li>';
			$no++;
		}
		$slider .= '<div class="text-right">';
		$slider .= '	<a href="' . site_url('home/berita') . '">' . clang('News') . ' ' . clang('Other') . ' <i class="fa fa-arrow-right"></i></a>';
		$slider .= '</div>';
		return $slider;
	}
}

if (!function_exists('list_event1')) {
	function list_event1($limit = 5)
	{
		$berita = berita_label('event', $limit);
		$no = 1;
		$event = '';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tgl = explode(' ', $row['tgl_mulai']);
			$tgl2 = explode('-', $tgl[0]);
			$event .= '<li title="' . $row['judul_' . CI()->session->userdata('lang')] . '">';
			$event .= '	<div class="agenda" style="display: block;width: 100%;margin-bottom:5px;">';
			$event .= '		<div class="agenda-tanggal text-center">';
			$event .= '			<span class="bulan">' . bln2($tgl2[1]) . '</span>';
			$event .= '			<span class="tanggal">' . $tgl2[2] . '</span>';
			$event .= '			<span class="tahun">' . $tgl2[0] . '</span>';
			$event .= '		</div>';
			$event .= '		<div class="agenda-content">';
			$event .= '			<a href="' . site_url() . 'home/event/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '"><h5 class="list-group-item-heading">' . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row['judul_' . CI()->session->userdata('lang')])), 0, 5))) . '...</h5></a>';
			$event .= '			<p class="list-group-item-text">' . implode(' ', array_slice(explode(' ', strip_tags($row['tulisan_' . CI()->session->userdata('lang')])), 0, 6)) . '...</p>';
			$event .= '			<span class="tgl-berita-terpopuler">&nbsp<i class="fa fa-clock-o"></i> ' . $row['lokasi'] . '&nbsp</span>';
			$event .= '		</div>';
			$event .= '	</div>';
			$event .= '</li>';
			$no++;
		}

		$event .= '<div class="text-right">';
		$event .= '		<a href="' . site_url('home/event') . '">' . clang('Event') . ' ' . clang('Other') . ' <i class="fa fa-arrow-right"></i></a>';
		$event .= '</div>';
		return $event;
	}
}

if (!function_exists('list_event')) {
	function list_event($limit = 5, $mode = 'img')
	{
		$berita = berita_label('event', $limit, 'a.id_tulisan desc');
		$no = 1;
		$event = '';
		foreach ($berita['tulisan_' . CI()->session->userdata('lang')] as $row) {
			$tgl = explode(' ', $row['tgl_mulai']);
			$tgl2 = explode('-', $tgl[0]);
			if ($mode == 'img' || $no == 1) {
				$event .= '<li title="' . $row['judul_' . CI()->session->userdata('lang')] . '">';
				$event .= '	<div class="agenda" style="display: block;content: \'\';clear: both;width: 100%;">';
				$event .= '		<div class="agenda-tanggal text-center">';
				$event .= '			<span class="bulan">' . bln2($tgl2[1]) . '</span>';
				$event .= '			<span class="tanggal">' . $tgl2[2] . '</span>';
				$event .= '			<span class="tahun">' . $tgl2[0] . '</span>';
				$event .= '		</div>';
				$event .= '		<div class="agenda-content">';
				$event .= '			<a href="' . site_url() . 'home/event/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '"><h5 class="list-group-item-heading">' . ucfirst(substr($row['judul_' . CI()->session->userdata('lang')], 0, 40)) . '...</h5></a>';
				$event .= '			<p class="list-group-item-text">' . substr(strip_tags($row['tulisan_' . CI()->session->userdata('lang')]), 0, 50) . '</p>';
				$event .= '			<span class="tgl-berita-terpopuler">&nbsp<i class="fa fa-clock-o"></i> ' . $row['lokasi'] . '&nbsp</span>';
				$event .= '		</div>';
				$event .= '	</div>';
				$event .= '</li>';
			} else if ($mode == 'list') {
				$event .= '<li title="' . $row['judul_' . CI()->session->userdata('lang')] . '">';
				$event .= '		<a href="' . site_url() . 'home/event/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '"><i class="fa fa-calendar"></i> ' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a>';
				$event .= '</li>';
			}
			$no++;
		}

		// $event .= '<div class="text-right">';
		// $event .= '		<a href="'.site_url('home/event').'"><b>Agenda Lainnya </b><i class="fa fa-arrow-right"></i></a>';
		// $event .= '</div>';
		return $event;
	}
}

if (!function_exists('get_quote')) {
	function get_quote($label = 'quote', $limit = 5, $img = 'no')
	{
		$berita = berita_label($label, $limit);
		$quote = '';
		if ($berita['tulisan_' . CI()->session->userdata('lang')][0]['gambar_andalan'] != '' && $img == 'yes') {
			$quote = '<div style="display:block;text-align:center;margin-bottom:10px;width:100%;max-height:315px;overflow:hidden;"><img src="' . CI()->path() . '/' . $berita['tulisan_' . CI()->session->userdata('lang')][0]['gambar_andalan'] . '"></div>';
		}
		$quote .= '<div class="quotes"></div>';
		$quote .= '<p class="p-quote">' . substr(strip_tags($berita['tulisan_' . CI()->session->userdata('lang')][0]['tulisan_' . CI()->session->userdata('lang')]), 0, 150);
		if (strlen($berita['tulisan_' . CI()->session->userdata('lang')][0]['tulisan_' . CI()->session->userdata('lang')]) > 150) {
			$quote .= '...<a href="' . site_url() . 'home/quote/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '"> ' . clang('Read more') . '&rarr;</a>';
		}
		$quote .= '</p>';
		$quote .= '<p><b>' . ucfirst($berita['tulisan_' . CI()->session->userdata('lang')][0]['nm_dp']) . '</b></p>';
		return $quote;
	}
}

if (!function_exists('get_thumbnail_album')) {
	function get_thumbnail_album($limit)
	{
		$album = tulisan('album', 'terbit', $limit);
		$album_ = '';
		if ($album != null) {
			if ($album[0]['gambar_andalan'] != '') {
				$img = base_url('assets/img/album') . '/' . $album[0]['id_tulisan'] . '/' . $album[0]['gambar_andalan'];
			} else {
				$img = base_url('assets/img/web/no_image.png');
			}
			$album_ .= '<div class="row text-center">';
			if (isset($album[0])) {
				$album_ .= '	<div class="col col-lg-12" title="' . $album[0]['judul_' . CI()->session->userdata('lang')] . '">';
				$album_ .= '		<div class="thumbnail">';
				$album_ .= '			<a href="' . site_url() . 'home/album/' . $album[0]['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($album[0]['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $album[0]['judul_' . CI()->session->userdata('lang')] . '">';
				$album_ .= '				<img src="' . $img . '" alt="img" class="foto-album-1">';
				//$album_ .='				<div class="caption">';
				//$album_ .='					<h5>'.ucfirst(substr(strip_tags($album[0]['judul_'.CI()->session->userdata('lang')]),0,15)).'</h5>';
				//$album_ .='				</div>';
				$album_ .= '			</a>';
				$album_ .= '		</div>';
				$album_ .= '	</div>';
			}
			$album_ .= '</div>';

			$album_ .= '<div class="row text-center">';
			if (isset($album)) {
				$i = 1;
				foreach ($album as $row) {
					if ($i != 1) {
						if ($row['gambar_andalan'] != '') {
							$img = base_url('assets/img/album') . '/' . $row['id_tulisan'] . '/' . $row['gambar_andalan'];
						} else {
							$img = base_url('assets/img/web/no_image.png');
						}
						$album_ .= '	<div class="col col-lg-16 col-sm-6 col-xs-6" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">';
						$album_ .= '		<div class="thumbnail">';
						$album_ .= '			<a href="' . site_url() . 'home/album/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')]))) . '" title="' . $row['judul_' . CI()->session->userdata('lang')] . '">';
						$album_ .= '				<img src="' . $img . '" alt="img" class="foto-album-2">';
						//$album_ .='				<div class="caption">';
						//$album_ .='					<a>'.ucfirst(substr(strip_tags($row['judul_'.CI()->session->userdata('lang')]),0,15)).'</a>';
						//$album_ .='				</div>';
						$album_ .= '			</a>';
						$album_ .= '		</div>';
						$album_ .= '	</div>';
					}
					$i++;
				}
			}
			$album_ .= '</div>';

			$album_ .= '<div class="text-right">';
			$album_ .= '		<a href="' . site_url('home/album') . '">Foto ' . clang('Other') . ' <i class="fa fa-arrow-right"></i></a>';
			$album_ .= '	</div>';
		}
		return $album_;
	}
}

if (!function_exists('get_video')) {
	function get_video($limit)
	{
		CI()->db->where('status_video', 'open');
		CI()->db->order_by('id_video DESC');
		CI()->db->limit($limit);
		$q = CI()->db->get('video')->result_array();
		$video_ = '<div class="tpb tpb-html col-md-9">';
		$video_ .= '	<div class="row">';
		$video_ .= '<div class="col-md-12 widget-html">';
		$video_ .= '</div>';
		foreach ($q as $vid) {
			$video_ .= '		<a">';
			$video_ .= '			<iframe width="560" height="315"  src="' . $vid['url_video'] . '" frameborder="0" allowfullscreen=""></iframe>';
			$video_ .= '		</a>';
		}
		$video_ .= '</div>';

		$video_ .= '<div class="text-right">';
		$video_ .= '		<a href="' . site_url('home/video') . '">Video ' . clang('Other') . ' <i class="fa fa-arrow-right"></i></a>';
		$video_ .= '	</div>';
		$video_ .= '</div>';
		$video_ .= '</div>';
		return $video_;
	}
}

if (!function_exists('hari')) {
	function hari($i)
	{
		if (CI()->session->userdata('lang') == 'id') {
			$hari = array('1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu', '7' => 'Minggu');
		} else if (CI()->session->userdata('lang') == 'eng') {
			$hari = array('1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday');
		} else if (CI()->session->userdata('lang') == 'ae') {
			$hari = array('1' => 'يوم الاِثنين', '2' => 'يوم الثّلاثاء', '3' => 'يوم الأربعاء', '4' => 'يوم الخميس', '5' => 'يوم الجمعة', '6' => 'يوم السّبت', '7' => 'يوم الأحد');
		}
		return $hari[$i];
	}
}

if (!function_exists('bln')) {
	function bln($i)
	{
		$bln = pil_bulan();
		return $bln[$i];
	}
}

if (!function_exists('pil_bulan')) {
	function pil_bulan()
	{
		$bln = array('00' => 'bulan', '01' => clang('Jan'), '02' => clang('Feb'), '03' => clang('Mar'), '04' => clang('Apr'), '05' => clang('May'), '06' => clang('Jun'), '07' => clang('Jul'), '08' => clang('Aug'), '09' => clang('Sep'), '10' => clang('Oct'), '11' => clang('Nov'), '12' => clang('Dec'));
		return $bln;
	}
}

if (!function_exists('bln2')) {
	function bln2($i)
	{
		$bln2 = pil_bulan2($i);
		return strtoupper($bln2[$i]);
	}
}

if (!function_exists('pil_bulan2')) {
	function pil_bulan2()
	{
		$bln = array('00' => 'bulan', '01' => clang('Jan'), '02' => clang('Feb'), '03' => clang('Mar'), '04' => clang('Apr'), '05' => clang('May'), '06' => clang('Jun'), '07' => clang('Jul'), '08' => clang('Aug'), '09' => clang('Sep'), '10' => clang('Oct'), '11' => clang('Nov'), '12' => clang('Dec'));
		return $bln;
	}
}

if (!function_exists('berita_label')) {
	function berita_label($label, $limit)
	{
		$data_['label'] = kategoriLabelBy('label', $label);
		if (isset($data_['label'][0]['id_kategori'])) {
			$data_['tulisan_' . CI()->session->userdata('lang')] = tulisan($data_['label'][0]['id_kategori'], 'terbit', $limit);
		}
		return $data_;
	}
}

if (!function_exists('berita_kategori')) {
	function berita_kategori($kategori, $limit)
	{
		$data_['kategori'] = kategoriLabelBy('category', $kategori);
		// die(print_r($data_));
		$data_['label'] = kategoriLabelBy('label', 'berita');
		if (isset($data_['kategori'][0]['id_kategori']) && isset($data_['label'][0]['id_kategori'])) {
			$data_['tulisan_' . CI()->session->userdata('lang')] = tulisan_berita($data_['label'][0]['id_kategori'], 'terbit', $limit, null, $data_['kategori'][0]['id_kategori']);
		}
		return $data_;
	}
}

if (!function_exists('kategoriLabelBy')) {
	function kategoriLabelBy($tipe = 'label', $slug = 'berita')
	{
		CI()->db->where(array('tipe_kategori' => $tipe, 'slug' => $slug));
		$kategori_ = null;
		$table_name = 'kategori';
		if (CI()->db->table_exists($table_name)) {
			$kategori_ = CI()->db->get('kategori')->result_array();
		}
		return $kategori_;
	}
}

if (!function_exists('tulisan')) {
	function tulisan($tipe = 'page', $status = 'terbit', $limit = 1)
	{
		CI()->db->where(array('a.tipe' => $tipe, 'a.status_tulisan' => $status));
		CI()->db->join('pengguna b', 'a.penulis = b.id_pengguna');
		CI()->db->order_by('a.tgl_tulisan desc');
		CI()->db->limit($limit);
		$tulisan_ = null;
		$table_name = 'tulisan';
		if (CI()->db->table_exists($table_name)) {
			$tulisan_ = CI()->db->get('tulisan a')->result_array();
		}
		return $tulisan_;
	}
}

if (!function_exists('tulisan_berita')) {
	function tulisan_berita($tipe = null, $status = null, $limit = null, $id = null, $id_kat = null, $cari = null)
	{
		if ($tipe != null) {
			$tipe_tul = " `tulisan`.`tipe`='" . $tipe . "' AND ";
		} else {
			$tipe_tul = " `tulisan`.`tipe`!='page' AND ";
		}
		if ($status != null) {
			$sts_tul = $status;
		} else {
			$sts_tul = "terbit";
		}
		if ($limit != null) {
			$limit_tul = " LIMIT " . $limit;
		} else {
			$limit_tul = " LIMIT 3";
		}
		if ($id != null) {
			$id_tul = " AND `tulisan`.`id_tulisan`='" . $id . "'";
		} else {
			$id_tul = "";
		}
		if ($id_kat != null) {
			$id_kat_ = " AND `hub_kat_tul`.`id_kat`='" . $id_kat . "'";
		} else {
			$id_kat_ = "";
		}
		if (isset($cari)) {
			$cari_tul = " AND (`tulisan`.`judul` LIKE '%" . $cari . "%' OR `tulisan`.`tulisan` LIKE '%" . $cari . "%') ";
		} else {
			$cari_tul = "";
		}
		$tulisan_ = null;
		$table_name = 'tulisan';
		if (CI()->db->table_exists($table_name)) {
			if ($id_kat_ != "") {
				$string = "SELECT * FROM `tulisan` JOIN `pengguna` ON `tulisan`.`penulis` = `pengguna`.`id_pengguna` JOIN `hub_kat_tul` ON `tulisan`.`id_tulisan` = `hub_kat_tul`.`id_tul` WHERE " . $tipe_tul . " `tulisan`.`status_tulisan`='" . $sts_tul . "' " . $id_tul . " " . $id_kat_ . " " . $cari_tul . " ORDER BY `tulisan`.`tgl_tulisan` DESC " . $limit_tul;
			} else {
				$string = "SELECT * FROM `tulisan` JOIN `pengguna` ON `tulisan`.`penulis` = `pengguna`.`id_pengguna` WHERE " . $tipe_tul . " `tulisan`.`status_tulisan`='" . $sts_tul . "' " . $id_tul . " " . $cari_tul . " ORDER BY `tulisan`.`tgl_tulisan` DESC " . $limit_tul;
			}
			$tulisan_ = CI()->db->query($string)->result_array();
		}
		return $tulisan_;
	}
}

// if(!function_exists('get_newsticker')) {
// 	function get_newsticker() {
// 		$newsticker_ = newsticker();
// 		$newsticker__ = '';
// 		if($newsticker_!=null){
// 			foreach ($newsticker_ as $row) {
// 				$newsticker__ .= '<li>
// 					<a href="#">
// 						'.$row['komoditi'].' &rarr; ';
// 						if($row['harga_komoditi_1']!='')$newsticker__ .=' Produsen : Rp '.number_format($row['harga_komoditi_1'],'0',',','.').'/'.$row['satuan_komoditi'];
// 						if($row['harga_komoditi_2']!='')$newsticker__ .=' - Eceran : Rp '.number_format($row['harga_komoditi_2'],'0',',','.').'/'.$row['satuan_komoditi'];
// 					$newsticker__ .='</a>
// 				</li>';
// 			}
// 		}
// 		return $newsticker__;
// 	}
// 	function newsticker() {
// 		$data = null;
// 		$komoditi = CI()->db->get('komoditi')->result_array();
// 		if($komoditi!=null){
// 			foreach($komoditi as $row){
// 				CI()->db->join('komoditi b','a.id_komoditi=b.id_komoditi');
// 				CI()->db->where('a.id_komoditi',$row['id_komoditi']);
// 				CI()->db->order_by('a.id_komoditi_harga','desc');
// 				$harga_komoditi = CI()->db->get('komoditi_harga a')->result_array();
// 				if($harga_komoditi!=null){
// 					if($harga_komoditi!=null){
// 						$data[$row['id_komoditi']] = $harga_komoditi[0];
// 					}
// 				}
// 			}
// 		}
// 		return $data;
// 	}
// }

if (!function_exists('get_newsticker')) {
	function get_newsticker($limit)
	{
		$newsticker_ = newsticker($limit);
		$newsticker__ = '';
		if ($newsticker_ != null) {
			foreach ($newsticker_ as $row) {
				$newsticker__ .= '<li>
					<a href="#">
						' . $row['newsticker'];
				$newsticker__ .= '</a>
				</li>';
			}
		}
		return $newsticker__;
	}
	function newsticker($limit)
	{
		$data = null;
		CI()->db->limit($limit);
		CI()->db->order_by('id_newsticker', 'DESC');
		$data = CI()->db->get('newsticker')->result_array();
		return $data;
	}
}

if (!function_exists('get_banner')) {
	function get_banner($tipe = 'utama')
	{
		$banner = banner($tipe);
		$banner_ = '';
		$no = 1;
		foreach ($banner as $row) {
			if ($no == 1) {
				$first = 'active';
			} else {
				$first = '';
			}
			$banner_ .= '<div class="item ' . $first . ' text-center">';
			$banner_ .= '	<a href="' . $row['slug'] . '" target="blank">';
			$banner_ .= '		<img src="' . CI()->path() . '/' . $row['gambar'] . '" alt="">';
			$banner_ .= '	</a>';
			$banner_ .= '</div>';
			$no++;
		}
		return $banner_;
	}
}

if (!function_exists('banner')) {
	function banner($tipe)
	{
		$banner_ = null;
		$table_name = 'banner';
		if (CI()->db->table_exists($table_name)) {
			CI()->db->where('posisi', $tipe);
			$banner_ = CI()->db->get('banner')->result_array();
		}
		return $banner_;
	}
}

if (!function_exists('get_list_page')) {
	function get_list_page()
	{
		CI()->db->where('id_kat', CI()->uri->segment(3));
		$q = CI()->db->get('hub_menu_sub')->result_array();
		foreach ($q as $row) {
			CI()->db->or_where('a.id_tul', $row['id_tul']);
		}
		CI()->db->distinct();
		CI()->db->select('b.id_tulisan,b.*');
		CI()->db->join('tulisan b', 'a.id_kat=b.id_tulisan');
		CI()->db->order_by('b.id_tulisan', 'asc');
		$q2 = CI()->db->get('hub_menu_sub a')->result_array();
		$halaman = '';
		$halaman .= '<div class="widget bg_primary">';
		$halaman .= '	<h4 class="title-widget"><span>HALAMAN TERKAITS</span><hr/></h4>';
		$halaman .= '	<ul class="box-list-halaman">';
		$no = 1;
		foreach ($q2 as $row2) {
			if ($row2['id_tulisan'] == CI()->uri->segment(3)) {
				$active = 'active';
			} else {
				$active = '';
			}
			$halaman .= '		<li><a class="' . $active . '" href="' . site_url() . 'home/halaman/' . $row2['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},.]/", "_", str_replace(' ', '-', strtolower($row2['judul_' . CI()->session->userdata('lang')]))) . '"> ' . $row2['judul_' . CI()->session->userdata('lang')] . ' </a></li>';
		}
		$halaman .= '	</ul>';
		$halaman .= '</div>';

		return $halaman;
	}
}

/* -- WIDGET 1 (KIRI) -- */
if (!function_exists('get_widget_1')) {
	function get_widget_1()
	{
		CI()->db->where('posisi_widget', 'kiri');
		CI()->db->order_by('no_urut', 'asc');
		$exc = CI()->db->get('widget');

		if ($exc->num_rows() != '0') {
			foreach ($exc->result() as $row) {
				if ($row->widget == '1') get_berita($row->nama_widget, $row->content_widget);
				else if ($row->widget == '2') get_pengumuman($row->nama_widget, $row->content_widget);
				else if ($row->widget == '3') get_agenda($row->nama_widget, $row->content_widget);
				else if ($row->widget == '4') get_album($row->nama_widget, $row->content_widget);
				else if ($row->widget == '5') get_ebook($row->nama_widget, $row->content_widget);
				else if ($row->widget == '6') get_layanan_informasi($row->nama_widget, 'tulisan');
				else if ($row->widget == '7') get_buku_tamu($row->nama_widget, $row->content_widget);
				else if ($row->widget == '8') get_poling($row->nama_widget, 'open', 'open');
				else if ($row->widget == '9') get_statistik($row->nama_widget);
				else if ($row->widget == '10') get_komoditas($row->nama_widget);
				else if ($row->widget == '11') get_textarea($row->nama_widget, $row->content_widget, 0);
				else if ($row->widget == '12') get_kepala_dinas($row->nama_widget);
				else if ($row->widget == '13') get_link($row->nama_widget, $row->content_widget);
				else if ($row->widget == '14') get_link_2($row->nama_widget, $row->content_widget);
				else if ($row->widget == '15') get_kategori($row->nama_widget, $row->content_widget);
				else if ($row->widget == '16') get_download($row->nama_widget, $row->content_widget);
			}
		}
	}
}

/* -- WIDGET 2 (KANAN) -- */
if (!function_exists('get_widget_2')) {
	function get_widget_2()
	{
		CI()->db->where('posisi_widget', 'kanan');
		CI()->db->order_by('no_urut', 'asc');
		$exc = CI()->db->get('widget');

		if ($exc->num_rows() != '0') {
			foreach ($exc->result() as $row) {
				if ($row->widget == '1') get_berita($row->nama_widget, $row->content_widget);
				else if ($row->widget == '2') get_pengumuman($row->nama_widget, $row->content_widget);
				else if ($row->widget == '3') get_agenda($row->nama_widget, $row->content_widget);
				else if ($row->widget == '4') get_album($row->nama_widget, $row->content_widget);
				else if ($row->widget == '5') get_ebook($row->nama_widget, $row->content_widget);
				else if ($row->widget == '6') get_layanan_informasi($row->nama_widget, 'halaman');
				else if ($row->widget == '7') get_buku_tamu($row->nama_widget, $row->content_widget);
				else if ($row->widget == '8') get_poling($row->nama_widget, 'open', 'open');
				else if ($row->widget == '9') get_statistik($row->nama_widget);
				else if ($row->widget == '10') get_komoditas($row->nama_widget);
				else if ($row->widget == '11') get_textarea($row->nama_widget, $row->content_widget, 0);
				else if ($row->widget == '12') get_kepala_dinas($row->nama_widget);
				else if ($row->widget == '13') get_link($row->nama_widget, $row->content_widget);
				else if ($row->widget == '14') get_link_2($row->nama_widget, $row->content_widget);
				else if ($row->widget == '15') get_kategori($row->nama_widget, $row->content_widget);
				else if ($row->widget == '16') get_download($row->nama_widget, $row->content_widget);
			}
		}
	}
}

/* -- WIDGET 3 (BAWAH) -- */
if (!function_exists('get_widget_3')) {
	function get_widget_3($class = 'footer-recent-List', $bg = 'bg_3')
	{
		CI()->db->where('posisi_widget', 'bawah');
		CI()->db->order_by('no_urut', 'asc');
		$exc = CI()->db->get('widget');

		if ($exc->num_rows() != '0') {
			echo '<div class="row">';
			foreach ($exc->result() as $row) {
				if ($row->widget == '1') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_berita($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
				if ($row->widget == '2') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_pengumuman($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
				if ($row->widget == '3') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_agenda($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
				if ($row->widget == '4') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_album($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
				if ($row->widget == '5') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_ebook($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
				if ($row->widget == '6') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_layanan_informasi($row->nama_widget);
					echo '	</div>';
				}
				if ($row->widget == '7') {
					echo '	<div class="col-lg-3 col-sm-3">';
					get_buku_tamu($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
				if ($row->widget == '8') {
					echo '	<div class="col-lg-3 col-sm-3">';
					get_poling($row->nama_widget, 'open', 'open');
					echo '	</div>';
				}
				if ($row->widget == '9') {
					echo '	<div class="col-lg-3 col-sm-3">';
					get_statistik($row->nama_widget);
					echo '	</div>';
				}
				if ($row->widget == '10') {
					echo '	<div class="col-lg-3 col-sm-3">';
					get_komoditas($row->nama_widget);
					echo '	</div>';
				}
				if ($row->widget == '12') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					echo '<div class="row">';
					get_kepala_dinas($row->nama_widget);
					echo '</div>';
					echo '</div>';
				}
				if ($row->widget == '13') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_link($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
				if ($row->widget == '14') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_link_2($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
				if ($row->widget == '15') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_kategori($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
				if ($row->widget == '16') {
					echo '	<div class="col-lg-3 col-md-6 mt-4 mt-lg-0">';
					get_download($row->nama_widget, $row->content_widget);
					echo '	</div>';
				}
			}
			echo '</div>';
		}
	}
}

if (!function_exists('get_kepala_dinas')) {
	function get_kepala_dinas($judul = 'Kepala Dinas')
	{
		$q = CI()->db->get('web')->result_array();
		foreach ($q as $row) {
			$w[$row['option_name']] = $row['option_value'];
		}
		$k_dinas_ = '<div class="widget bg_primary">';
		$k_dinas_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$k_dinas_ .= '   <img src="' . $w['blogimgpemimpin'] . '" style="width:50%;float:left;">';
		$k_dinas_ .= '   <img src="' . $w['blogimgwpemimpin'] . '" style="width:50%;">';
		$k_dinas_ .= '</div>';
		echo $k_dinas_;
	}
}

if (!function_exists('get_album')) {
	function get_album($judul = 'Album', $limit = '3')
	{
		$album_ = '<div class="widget bg_primary">';
		$album_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$album_ .= '<div class="galeri-widget">';
		$album_ .= get_thumbnail_album($limit);
		$album_ .= '</div>';
		$album_ .= '</div>';
		echo $album_;
	}
}

if (!function_exists('get_halaman_utama')) {
	function get_halaman_utama($id = null)
	{
		$string = "SELECT * FROM `tulisan` WHERE `id_tulisan`='" . $id . "'";
		$a 		= CI()->db->query($string)->result_array();
		$hal = '<h1>Selamat Datang</h1>';
		$hal .= '<img src="' . CI()->path() . '/' . $a[0]['gambar_andalan'] . '" class="img-techno" style="width: 100%">';
		$hal .= '<p>' . substr(strip_tags($a[0]['tulisan_' . CI()->session->userdata('lang')]), 0, 500) . '...</p>';
		$hal .= '<a href="' . site_url('home/halaman/' . $a[0]['id_tulisan'] . '/' . str_replace(' ', '-', $a[0]['judul_' . CI()->session->userdata('lang')])) . '">' . clang('Read more') . ' &nbsp;&raquo;</a>';
		echo $hal;
	}
}

if (!function_exists('get_agenda')) {
	function get_agenda($judul = 'Agenda', $limit = '3')
	{
		$event_ = '<div class="widget bg_primary">';
		$event_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$event_ .= '	<ul class="box-list-agenda-kerja">';
		$event_ .= list_event($limit);
		// $event_ .= list_event($limit,'list');
		$event_ .= '	</ul>';
		$event_ .= '</div>';
		echo $event_;
	}
}

if (!function_exists('get_pengumuman')) {
	function get_pengumuman($judul = 'Pengumuman', $limit = '3')
	{
		$pengumuman_ = '<div class="widget bg_primary">';
		$pengumuman_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$pengumuman_ .= list_post('pengumuman', $limit);
		$pengumuman_ .= '</div>';
		echo $pengumuman_;
	}
}

if (!function_exists('get_berita')) {
	function get_berita($judul = 'Berita', $limit = '3')
	{
		$berita_ = '<div class="widget bg_primary">';
		$berita_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		// $berita_ .= list_post('berita',$limit,'a.id_tulisan desc','img');
		$berita_ .= list_post('berita', $limit);
		$berita_ .= '</div>';
		echo $berita_;
	}
}

if (!function_exists('get_ebook')) {
	function get_ebook($judul = 'Ebook', $limit = '3')
	{
		$ebook_ = '<div class="widget bg_primary">';
		$ebook_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$ebook_ .= list_post('ebook', $limit);
		$ebook_ .= '</div>';
		echo $ebook_;
	}
}

if (!function_exists('get_download')) {
	function get_download($judul = 'Download', $limit = '3')
	{
		$ebook_ = '<div class="widget bg_primary">';
		$ebook_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$ebook_ .= list_download($limit);
		$ebook_ .= '</div>';
		echo $ebook_;
	}
}

if (!function_exists('get_link')) {
	function get_link($judul = 'Berita', $limit = '3')
	{
		$link_ = '<div class="widget bg_primary">';
		$link_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';

		$no = 1;
		CI()->db->where(array('tipe_kategori' => 'menu', 'posisi' => 'link'));
		CI()->db->limit($limit, 0);
		$link = CI()->db->get('kategori')->result_array();
		$link_ .= '	<div style="margin-bottom:10px;">';
		foreach ($link as $row) {
			$link_ .= '<div class="item-berita">';
			$link_ .= '	<h5><a href="' . $row['slug'] . '"><i class="fa fa-angle-right"></i> ' . $row['kategori'] . '</a></h5>';
			$link_ .= '</div>';
			$no++;
		}

		$link_ .= '	</div>';
		$link_ .= '</div>';
		echo $link_;
	}
}

if (!function_exists('get_link_2')) {
	function get_link_2($judul = 'Berita', $limit = '3')
	{
		$link_ = '<div class="widget bg_primary">';
		$link_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';

		$no = 1;
		CI()->db->where(array('tipe_kategori' => 'menu', 'posisi' => 'link2'));
		CI()->db->limit($limit, 0);
		$link = CI()->db->get('kategori')->result_array();
		$link_ .= '	<div style="margin-bottom:10px;">';
		foreach ($link as $row) {
			$link_ .= '<div class="item-berita">';
			$link_ .= '	<h5><a href="' . $row['slug'] . '"><i class="fa fa-angle-right"></i> ' . $row['kategori'] . '</a></h5>';
			$link_ .= '</div>';
			$no++;
		}
		$link_ .= ' </div>';
		$link_ .= '</div>';
		echo $link_;
	}
}

if (!function_exists('get_kategori')) {
	function get_kategori($judul = 'Berita', $limit = '3')
	{
		$link_ = '<div class="widget bg_primary">';
		$link_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';

		$no = 1;
		CI()->db->where(array('tipe_kategori' => 'category'));
		CI()->db->limit($limit, 0);
		$link = CI()->db->get('kategori')->result_array();
		if ($link != null) {
			foreach ($link as $row) {
				if ($row['parent'] == '0') {
					$link2[$row['id_kategori']] = $row;
				} else {
					$linkp[$row['parent']][$row['id_kategori']] = $row;
				}
			}
		}
		$link_ .= '	<div style="margin-bottom:10px;">';
		foreach ($link2 as $row) {
			$link_ .= '<div class="item-berita">';
			$link_ .= '	<h5><a href="' . site_url('home/kategori') . '/' . $row['id_kategori'] . '/' . $row['slug'] . '"><i class="fa fa-angle-right"></i> ' . ucwords($row['kategori']) . '</a></h5>';
			$link_ .= '</div>';
			if (@$linkp[$row['id_kategori']] && $linkp[$row['id_kategori']] != null) {
				$link_ .= link_child($linkp[$row['id_kategori']], $linkp, 1);
			}
			$no++;
		}

		$link_ .= '	</div>';
		$link_ .= '</div>';
		echo $link_;
	}

	function link_child($link_child, $linkp, $i)
	{
		$j = $i;
		$link_ = '';
		$strip = '';
		for ($k = 0; $k <= $j; $k++) {
			$strip .= '&nbsp&nbsp';
		}
		foreach ($link_child as $row) {
			$link_ .= '<div class="item-berita">';
			$link_ .= '	<h6>' . $strip . '<a href="' . site_url('home/kategori') . '/' . $row['id_kategori'] . '/' . $row['slug'] . '"><i class="fa fa-angle-right"></i> ' . ucwords($row['kategori']) . '</a></h6>';
			$link_ .= '</div>';
			if ($linkp[$row['id_kategori']] != null) {
				$link_ .= link_child($linkp[$row['id_kategori']], $linkp, $j + 1);
			}
		}
		return $link_;
	}
}

if (!function_exists('get_kategori_sitemap')) {
	function get_kategori_sitemap($mode = null)
	{
		$link_ = '';
		$no = 1;
		CI()->db->where(array('tipe_kategori' => 'category'));
		$link = CI()->db->get('kategori')->result_array();
		if ($link != null) {
			foreach ($link as $row) {
				if ($row['parent'] == '0') {
					$link2[$row['id_kategori']] = $row;
				} else {
					$linkp[$row['parent']][$row['id_kategori']] = $row;
				}
			}

			foreach ($link2 as $row) {
				if ($mode == 'xml') {
					$link_ .= '<url><loc>' . site_url('home/kategori') . '/' . $row['slug'] . '</loc></url>';
				} else {
					$link_ .= '<li><a href="' . site_url('home/kategori') . '/' . $row['id_kategori'] . '/' . $row['slug'] . '">' . ucwords($row['kategori']) . '</a></li>';
				}
				if (@$linkp[$row['id_kategori']] && $linkp[$row['id_kategori']] != null) {
					if ($mode == 'xml') {
						$link_ .= link_child_sitemap($linkp[$row['id_kategori']], $linkp, 1, 'xml');
					} else {
						$link_ .= '<ul>';
						$link_ .= link_child_sitemap($linkp[$row['id_kategori']], $linkp, 1, null);
						$link_ .= '</ul>';
					}
				}
				$no++;
			}
		}
		return $link_;
	}

	function link_child_sitemap($link_child_sitemap, $linkp, $i, $mode = null)
	{
		$j = $i;
		$link_ = '';
		$strip = '';
		for ($k = 0; $k <= $j; $k++) {
			$strip .= '&nbsp&nbsp';
		}
		foreach ($link_child_sitemap as $row) {
			if ($mode == 'xml') {
				$link_ .= '<url><loc>' . site_url('home/kategori') . '/' . $row['slug'] . '</loc></url>';
			} else {
				$link_ .= '<li>' . $strip . '<a href="' . site_url('home/kategori') . '/' . $row['slug'] . '">' . ucwords($row['kategori']) . '</a></li>';
			}
			if ($linkp[$row['id_kategori']] != null) {
				if ($mode == 'xml') {
					$link_ .= link_child_sitemap($linkp[$row['id_kategori']], $linkp, $j + 1, 'xml');
				} else {
					$link_ .= '<ul>';
					$link_ .= link_child_sitemap($linkp[$row['id_kategori']], $linkp, $j + 1, null);
					$link_ .= '</ul>';
				}
			}
		}
		return $link_;
	}
}

if (!function_exists('btn_link2')) {
	function btn_link2()
	{
		CI()->db->where(array('tipe_kategori' => 'menu', 'posisi' => 'link2'));
		CI()->db->limit(6, 0);
		$link = CI()->db->get('kategori')->result_array();
		$kat  = '';
		$warna = array(
			'1' => 'btn-default',
			'2' => 'btn-warning',
			'3' => 'btn-danger',
			'4' => 'btn-info',
			'5' => 'btn-primary',
			'6' => 'btn-success'
		);
		if ($link != null) {
			$i   = 1;
			$jml = count($link);
			foreach ($link as $row) {
				if ($i % 3 == 1) {
					$kat .= '<div class="row" style="margin:0px -5px;">';
					$kat .= '<div class="col-md-6 col-sm-6 col-box" style="padding:5px;">
								<a href="' . $row['slug'] . '" class="btn ' . $warna[$i] . ' btn-lg">' . $row['kategori'] . '</a>
							</div>';
				} else if ($i % 3 == 0) {
					$kat .= '<div class="col-md-3 col-sm-3 col-box" style="padding:5px;">
								<a href="' . $row['slug'] . '" class="btn ' . $warna[$i] . ' btn-lg">' . $row['kategori'] . '</a>
							</div>';
					$kat .= '</div>';
				} else {
					$kat .= '<div class="col-md-3 col-sm-3 col-box" style="padding:5px;">
								<a href="' . $row['slug'] . '" class="btn ' . $warna[$i] . ' btn-lg">' . $row['kategori'] . '</a>
							</div>';
				}
				if ($i == $jml && $i % 3 != 0) {
					$kat .= '</div>';
				}
				$i++;
			}
		}

		return $kat;
	}
}

if (!function_exists('get_textarea')) {
	function get_textarea($judul = '', $content = '', $a = 0)
	{
		$textarea = ($a == 1) ? '<div class="col-sm-12 col-md-12 col-lg-12 text-center">' : '<div class="text-center">';
		$textarea .= '<div class="widget bg_primary">';
		$textarea .= '	<h4 class="title-widget" style="margin-bottom:10px;"><span>' . $judul . '</span></h4>';
		$textarea .= '	<div class="about-web">';
		$textarea .= $content;
		if (CI()->config->config['blogfb'] != '' || CI()->config->config['blogtw'] != '' || CI()->config->config['bloggp'] != '') {
			$textarea .= '<div id="socialicons" class="hidden-phone" style="margin:0px;">';
			if (CI()->config->config['blogfb'] != '') {
				$textarea .= '<a id="social_facebook" target="blank" class="social_active" href="' . CI()->config->config['blogfb'] . '" title="Visit facebook page"><span class="da-animate da-slideFromBottom" style="display: inline-block;"></span></a>';
			}
			if (CI()->config->config['bloggp'] != '') {
				$textarea .= '<a id="social_google_plus" target="blank" class="social_active" href="' . CI()->config->config['bloggp'] . '" title="Visit google_plus page"><span class="da-animate da-slideFromLeft" style="display: block;"></span></a>';
			}
			if (CI()->config->config['blogtw'] != '') {
				$textarea .= '<a id="social_twitter" target="blank" class="social_active" href="' . CI()->config->config['blogtw'] . '" title="Visit twitter page"><span class="da-animate da-slideFromRight" style="display: block;"></span></a>';
			}
			$textarea .= '</div>';
		}
		$textarea .= '	</div>';
		$textarea .= '</div>';
		$textarea .= '</div>';
		echo $textarea;
	}
}

if (!function_exists('get_layanan_informasi')) {
	function get_layanan_informasi($judul = 'Layanan Informasi', $tipe = 'halaman')
	{
		$q = banner($tipe);
		$banner_ = '<div class="widget bg_primary">';
		$banner_ .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$banner_ .= '		<div class="banner-halaman">';
		$banner_ .= '			<div id="myCarousel2" class="carousel carousel-fade slide" data-ride="carousel">';
		$banner_ .= '				<div class="carousel-inner" role="listbox">';
		$no = 1;
		foreach ($q as $row) {
			if ($no == 1) {
				$first = 'active';
			} else {
				$first = '';
			}
			$banner_ .= '<div class="item ' . $first . ' text-center">';
			$banner_ .= '	<a href="' . $row['slug'] . '" target="blank">';
			$banner_ .= '		<img src="' . CI()->path() . '/' . $row['gambar'] . '" alt="">';
			$banner_ .= '	</a>';
			$banner_ .= '</div>';
			$no++;
		}
		$banner_ .= '			</div>';
		$banner_ .= '		</div>';
		$banner_ .= '	</div>';
		$banner_ .= '</div>';
		echo $banner_;
	}
}

if (!function_exists('get_buku_tamu')) {
	function get_buku_tamu($judul = 'Buku Tamu', $limit = 10)
	{
		CI()->db->where('status_testimoni_', 'terbit');
		CI()->db->order_by('id_testimoni desc');
		CI()->db->limit($limit);
		$q = CI()->db->get('testimoni')->result_array();
		$testimoni = '<div class="widget bg_primary">';
		$testimoni .= '<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$testimoni .= '	<div id="myCarousel3" class="carousel slide" data-ride="carousel">';
		$testimoni .= '		<div class="carousel-inner box-carousel-buku-tamu" role="listbox">';
		$no = 1;
		foreach ($q as $row) {
			if ($no == 1) {
				$active = 'active';
			} else {
				$active = '';
			}
			$testimoni .= '<div class="item ' . $active . '">';
			$testimoni .= '	<p>' . $row['testimoni'] . '</p>';
			$testimoni .= '	<p class="buku-tamu-pengunjung">' . clang('by') . ': <b>' . $row['nama'] . '</b> - ' . $row['instansi'] . '</p>';
			$testimoni .= '</div>';
			$no++;
		}
		$testimoni .= '		</div>';
		$testimoni .= '	</div>';
		$testimoni .= '	<div class="text-right">';
		$testimoni .= '	<div class="btn-group">';
		$testimoni .= '	<a href="' . site_url('home/buku_tamu') . '" class="btn btn-default btn-primary"><i class="fa fa-eye"></i></a>';
		$testimoni .= '	<button type="button" class="btn btn-default btn-primary" data-toggle="modal" data-target="#m-buku-tamu"><i class="fa fa-edit"></i></button>';
		$testimoni .= '	</div>';
		$testimoni .= '	</div>';
		$testimoni .= '</div>';
		echo $testimoni;
	}
}

if (!function_exists('get_poling')) {
	function get_poling($judul = 'Poling', $status = null, $status2 = null, $limit = 1)
	{
		if ($status != null) {
			CI()->db->where('status_poling', $status);
		}
		if ($status2 != null) {
			CI()->db->where('status_poling_2', $status2);
		}
		CI()->db->where('parent_poling', '0');
		CI()->db->limit($limit);
		CI()->db->order_by('id_poling', 'DESC');
		$q = CI()->db->get('poling')->result_array();
		$poling = '<div class="widget bg_primary">';
		$poling .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$poling .= '		<form action="' . site_url('home/poling_user') . '" method="post">';
		if ($q != null) {
			foreach ($q as $row) {
				$poling .= '<div class="item">';
				$poling .= '	<p>' . $row['nama_poling'] . '</p>';
				if ($status != null) {
					CI()->db->where('status_poling', $status);
				}
				if ($status2 != null) {
					CI()->db->where('status_poling_2', $status2);
				}
				CI()->db->where('parent_poling', $row['id_poling']);
				CI()->db->order_by('id_poling', 'DESC');
				$q2 = CI()->db->get('poling')->result_array();
				if ($q2 != null) {
					foreach ($q2 as $row2) {
						$poling .= '<div class="checkbox">';
						$poling .= '	<label class="radio-inline">';
						$poling .= '		<input type="radio" name="id_poling" value="' . $row2['id_poling'] . '"> ' . $row2['nama_poling'];
						$poling .= '	</label>';
						$poling .= '</div>';
					}
				}
				$poling .= '</div>';
			}
		} else {
			$poling .= '<div class="">';
			$poling .= '	<p>Tidak ada poling untuk saat ini.</p>';
			$poling .= '</div>';
		}
		$poling .= '		<div class="text-right">';
		$poling .= '	<div class="btn-group">';
		if ($q != null) {
			$poling .= '<button type="submit" class="btn btn-default btn-primary"><i class="fa fa-check"></i></button>';
			$poling .= '<a href="' . site_url('home/poling/' . $q[0]['id_poling'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['nama_poling'])))) . '" class="btn btn-default btn-primary"><i class="fa fa-eye"></i></a>';
		}
		$poling .= '			<a href="' . site_url('home/poling') . '" class="btn btn-default btn-primary"><i class="fa fa-list"></i></a>';
		$poling .= '			</div>';
		$poling .= '		</div>';
		$poling .= '	</form>';
		$poling .= '</div>';
		echo $poling;
	}
}

if (!function_exists('get_komoditas')) {
	function get_komoditas($judul = 'Komoditas Pertanian')
	{
		$pil_group = CI()->db->get('komoditi_group')->result_array();
		$pil_indikator = CI()->db->get('komoditi_indikator')->result_array();
		$bln = pil_bulan();
		$komoditas = '<div class="widget bg_primary">';
		$komoditas .= '	<h4 class="title-widget"><span><span>' . $judul . '</span><hr/></h4>';
		$komoditas .= '	<form action="' . site_url() . 'komoditiapp/laporankomoditi/laporan_pertanian_detail" method="post">';
		$komoditas .= '		<div class="form-group">';
		$komoditas .= '			<label>Komoditi</label>';
		$komoditas .= '			<select id="pil_group" name="id_komoditi_group" type="text" class="form-control">';
		$komoditas .= '				<option value="">-pilih-</option>';
		foreach ($pil_group as $row) {
			$kom_grp[$row['id_komoditi_group']] = $row['komoditi_group'];
			$komoditas .= '	<option value="' . $row['id_komoditi_group'] . '">' . $row['komoditi_group'] . '</option>';
		}
		$komoditas .= '			</select>';
		$komoditas .= '		</div>';
		$komoditas .= '		<div class="form-group">';
		$komoditas .= '			<label>Laporan</label>';
		$komoditas .= '			<select id="pil_laporan" name="id_komoditi_laporan" type="text" class="form-control" onchange="laporan(this.value);">';
		$komoditas .= '				<option value="">-pilih-</option>';
		$komoditas .= '				<option value="bln">per bulan</option>';
		$komoditas .= '				<option value="thn">per tahun</option>';
		$komoditas .= '				<option value="thn2">per 10 tahun</option>';
		$komoditas .= '			</select>';
		$komoditas .= '		</div>';
		$komoditas .= '		<div class="form-group" id="indikator" style="display:none;">';
		$komoditas .= '			<label>Indikator</label>';
		$komoditas .= '			<select id="pil_indikator" name="id_komoditi_indikator" type="text" class="form-control">';
		$komoditas .= '				<option value="">-pilih-</option>';
		foreach ($pil_indikator as $row) {
			$kom_ink[$row['komoditi_indikator']] = $row['komoditi_indikator'];
			$komoditas .= '				<option value="' . $row['komoditi_indikator'] . '">' . $row['komoditi_indikator'] . '</option>';
		}
		$komoditas .= '			</select>';
		$komoditas .= '		</div>';
		$komoditas .= '		<div class="form-group" id="bulan" style="display:none;">';
		$komoditas .= '			<label>Periode</label>';
		$komoditas .= '			<div class="input-group" style="width:100%;">';
		$komoditas .= '				<select name="bulan_komoditi" id="bulan_komoditi" class="form-control"  style="width:50%;">';
		foreach ($bln as $row) {
			$komoditas .= '				<option value="' . array_search($row, $bln) . '">' . $row . '</option>';
		}
		$komoditas .= '				</select>';
		$komoditas .= '				<select name="tahun_komoditi" id="tahun_komoditi" class="form-control" style="width:50%;">';
		for ($i = date('Y') - 5; $i <= date('Y'); $i++) {
			$komoditas .= '				<option value="' . $i . '">' . $i . '</option>';
		}
		$komoditas .= '				</select>';
		$komoditas .= '			</div>';
		$komoditas .= '		</div>';
		$komoditas .= '		<div class="form-group" id="tahun" style="display:none;">';
		$komoditas .= '			<label>Tahun</label>';
		$komoditas .= '			<select name="tahun_komoditi2" id="tahun_komoditi2" class="form-control">';
		for ($i = date('Y') - 5; $i <= date('Y'); $i++) {
			$komoditas .= '			<option value="' . $i . '">' . $i . '</option>';
		}
		$komoditas .= '			</select>';
		$komoditas .= '		</div>';
		$komoditas .= '		<div class="form-group" id="tahun2" style="display:none;">';
		$komoditas .= '			<label>Tahun</label>';
		$komoditas .= '			<select name="tahun_komoditi3" id="tahun_komoditi3" class="form-control">';
		$komoditas .= '				<option value="1990-1999">1990-1999</option>';
		$komoditas .= '				<option value="2000-2009">2000-2009</option>';
		$komoditas .= '				<option value="2010-2019">2010-2019</option>';
		$komoditas .= '				<option value="2020-2029">2020-2029</option>';
		$komoditas .= '				<option value="2030-2039">2030-2039</option>';
		$komoditas .= '			</select>';
		$komoditas .= '		</div>';
		$komoditas .= '		<div class="form-group">';
		$komoditas .= '			<button type="submit" class="btn btn-primary square-btn-adjust"><i class="fa fa-search"></i> Lihat</button>';
		$komoditas .= '		</div>';
		$komoditas .= '	</form>';
		$komoditas .= '</div>';

		$komoditas .= '<script>
			function laporan(id){
				if(id=="bln"){
					$("#bulan").show();
					$("#indikator").hide();
					$("#tahun").hide();
					$("#tahun2").hide();
				}else if(id=="thn"){
					$("#bulan").hide();
					$("#indikator").show();
					$("#tahun").show();
					$("#tahun2").hide();
				}else if(id=="thn2"){
					$("#bulan").hide();
					$("#indikator").show();
					$("#tahun").hide();
					$("#tahun2").show();
				}else{
					$("#bulan").hide();
					$("#indikator").hide();
					$("#tahun").hide();
					$("#tahun2").hide();
				}
			}
			</script>';
		echo $komoditas;
	}
}

if (!function_exists('get_statistik')) {
	function get_statistik($judul = 'Statistik Pengunjung')
	{
		$s = null;
		$ip = $_SERVER['REMOTE_ADDR'];
		$tanggal = date("Ymd");
		$waktu = time();
		$bln = date("m");
		$tgl = date("d");
		$blan = date("Y-m");
		$thn = date("Y");
		$tglk = $tgl - 1;
		CI()->db->where(array('ip' => $ip, 'tanggal' => $tanggal));
		$s = CI()->db->get('konter')->result_array();
		if ($s == null) {
			$data['pengunjung'] = array(
				'ip' => $ip,
				'tanggal' => $tanggal,
				'hits' => '1',
				'online' => $waktu
			);
			CI()->db->insert('konter', $data['pengunjung']);
		} else {
			$data['pengunjung'] = array(
				'tanggal' => $tanggal,
				'hits' => $s[0]['hits'] + 1,
				'online' => $waktu
			);
			$where = array(
				array(
					'where_field' => 'ip',
					'where_key' => $ip
				),
				array(
					'where_field' => 'tanggal',
					'where_key' => $tanggal
				)
			);
			CI()->db->where(array('ip' => $ip, 'tanggal' => $tanggal));
			CI()->db->update('konter', $data['pengunjung']);
		}
		$statistik = '<div class="widget bg_primary">';
		$statistik .= '	<h4 class="title-widget"><span>' . $judul . '</span><hr/></h4>';
		$statistik .= '		<div class="item">';
		$statistik .= '		<ul class="list-statistik">';
		$statistik .= '			<li class="li-statistik">';
		$statistik .= '				<span class="badge">' . totalhits() . '</span>';
		$statistik .= '				Total Pengunjung';
		$statistik .= '			</li>';
		$statistik .= '			<li class="li-statistik">';
		$statistik .= '				<span class="badge">' . totalpengunjung() . '</span>';
		$statistik .= '				Unique Visitors';
		$statistik .= '			</li>';
		$statistik .= '			<li class="li-statistik">';
		$statistik .= '				<span class="badge">' . totalcontent() . '</span>';
		$statistik .= '				Jumlah konten';
		$statistik .= '			</li>';
		$statistik .= '			<li class="li-statistik">';
		$statistik .= '				<span class="badge">' . CI()->session->userdata('ip_address') . '</span>';
		$statistik .= '				IP Anda';
		$statistik .= '			</li>';
		$statistik .= '			<li class="li-statistik">';
		$statistik .= '				<span class="badge">' . date("h:i, d/m/Y ", CI()->session->userdata('last_activity')) . '</span>';
		$statistik .= '				Mengakses Sejak';
		$statistik .= '			</li>';
		$statistik .= '		</ul>';
		$statistik .= '		</div>';
		$statistik .= '	</div>';

		echo $statistik;
	}

	function totalpengunjung()
	{
		CI()->db->select('COUNT(`hits`) as `totalpengunjung`');
		$q = CI()->db->get('konter')->result_array();
		return $q[0]['totalpengunjung'];
	}

	function totalhits()
	{
		CI()->db->select('SUM(`hits`) as `totalhits`');
		$q = CI()->db->get('konter')->result_array();
		return $q[0]['totalhits'];
	}

	function totalcontent()
	{
		CI()->db->where('status_tulisan', 'terbit');
		$q = CI()->db->get('tulisan')->num_rows();;
		return $q;
	}
}

if (!function_exists('get_meta')) {
	function get_meta()
	{
		if (CI()->session->userdata('keywords') != '') {
			$meta['k'] = CI()->session->userdata('keywords');
		} else {
			$meta['k'] = CI()->config->config['blogkeyword'];
		}
		if (CI()->session->userdata('description') != '') {
			$meta['d'] = CI()->session->userdata('description');
		} else {
			$meta['d'] = CI()->config->config['blogdescription'];
		}
		if (CI()->session->userdata('image') != '') {
			$meta['i'] = CI()->session->userdata('image');
		} else {
			$meta['i'] = CI()->config->config['blogimgheader2'];
		}
		$meta['u'] = site_url();
		return $meta;
	}
}

if (!function_exists('get_tautan')) {
	function get_tautan($jml = 3, $link = 'link')
	{
		CI()->db->where(array('tipe_kategori' => 'menu', 'posisi' => $link));
		$tautan = CI()->db->get('kategori')->result_array();
		$tautan_ = '<div class="owl-carousel owl-carousel' . $jml . '">';
		$no = 1;
		foreach ($tautan as $row) {
			if ($no == 1) {
				$first = 'active';
			} else {
				$first = '';
			}
			$tautan_ .= '<div class="recent-work-item">';
			$tautan_ .= '	<div class="text-center" style="margin:0;">';
			$tautan_ .= '		<div class="ch-item-' . $jml . '" style="background-image: url(' . CI()->path() . '/' . $row['icon'] . ')">';
			$tautan_ .= '			<div class="ch-info-' . $jml . '">';
			$tautan_ .= '				<h3><a href="' . $row['slug'] . '" target="blank"> ' . $row['kategori'] . ' </a></h3>';
			$tautan_ .= '			</div>';
			$tautan_ .= '		</div>';
			$tautan_ .= '	</div>';
			$tautan_ .= '</div>';
			$no++;
		}
		$tautan_ .= '</div>';
		return $tautan_;
	}
}

if (!function_exists('get_tautan_li')) {
	function get_tautan_li($link = 'link')
	{
		CI()->db->where(array('tipe_kategori' => 'menu', 'posisi' => $link));
		$tautan = CI()->db->get('kategori')->result_array();
		$tautan_ = '<ul>';
		$no = 1;
		foreach ($tautan as $row) {
			$tautan_ .= '<li>';
			//$tautan_ .='<img src="'.base_url('assets/img/img_andalan').'/'.$row['icon'].'">';
			//$tautan_ .='<a href="'.$row['slug'].'" target="blank"> '.$row['kategori'].' </a>';
			$tautan_ .= '<a href="' . $row['slug'] . '" target="blank" title="' . $row['kategori'] . '"><img src="' . CI()->path() . '/' . $row['icon'] . '"></a>';
			$tautan_ .= '</li>';
			$no++;
		}
		$tautan_ .= '</ul>';
		return $tautan_;
	}
}

if (!function_exists('get_menu')) {
	function get_menu($animate = '', $warna = null)
	{
		$i = 1;
		$menu = '';
		$menu_ = menu('utama');
		foreach ($menu_['menu'] as $row) {
			$j = 1;
			$jenis = $row['jenis'];
			$menu .= set_menu($row, $menu_['parent'], $i, $j, $row['jenis'], $animate, $warna);
			$i++;
		}
		return $menu;
	}
	function set_menu($row, $parent, $i, $j, $jenis, $animate, $warna)
	{
		if ($i <= 4) {
			$drop = 'left';
		} else {
			$drop = 'right';
		}
		$menu = '';
		$li_warna = '';
		if ($j == 1) {
			if ($warna != null) {
				$li_warna = $warna[array_rand($warna, 1)];
			}
		}
		if (isset($row['id_kategori']) && isset($parent[$row['id_kategori']]) && $parent[$row['id_kategori']] != null && $jenis == 'dropdown') {
			if ($j == 1) {
				$class = 'dropdown nav-item';
				$role = '';
				$simbol = '<span class="caret"></span>';
			} else {
				$class = 'dropdown-submenu';
				$role = 'role="menu"';
				$simbol = '';
			}
			$menu .= '<li class="dropdown nav-item' . $class . ' ' . $li_warna . '">
			<a class="nav-link" data-toggle="dropdown" data-target="#" href="#">' . ucfirst($row['kategori'])  . $simbol . '</a>
            <ul class="dropdown-menu' . $animate . '" ' . $role . '>';
			$j++;
			foreach ($parent[$row['id_kategori']] as $row2) {
				$menu .= set_menu($row2, $parent, $i, $j, $jenis, $animate, $warna);
			}
			$menu .= '</ul>
        </li>';
		} else if (isset($row['id_kategori']) && isset($parent[$row['id_kategori']]) && $parent[$row['id_kategori']] != null && $jenis == 'mega') {
			$menu .= '<li class="dropdown mega-dropdown ' . $drop . ' ' . $li_warna . '">
			<a href="#" data-toggle="dropdown" class="nav-link">
			' . ucfirst($row['kategori']) . '
			<span class="caret"></span></a>
			<ul class="mega-dropdown-menu ' . $animate . '">';
			foreach ($parent[$row['id_kategori']] as $row2) {
				$menu .= '<li>';
				if (isset($row2['id_kategori']) && isset($parent[$row2['id_kategori']]) && $parent[$row2['id_kategori']] != null) {
					$menu .= '<h5><b>' . ucfirst($row2['kategori']) . '</b></h5><ul>';
					foreach ($parent[$row2['id_kategori']] as $row3) {
						if (isset($row3['id_kategori'])) {
							$menu .= '<li><a href="' . $row3['slug'] . '">' . ucfirst($row3['kategori']) . '</a></li>';
						} else {
							$menu .= '<li><a href="' . site_url() . 'home/' . $row3['kat_order'] . '/' . $row3['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row3['judul_' . CI()->session->userdata('lang')]))) . '">' . ucfirst($row3['judul_' . CI()->session->userdata('lang')]) . '</a></li>';
						}
					}
					$menu .= '</ul>';
				} else if (isset($row2['id_kategori'])) {
					$menu .= '<ul><li><a href="' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a></li></ul>';
				} else {
					if (isset($row2['id_tulisan'])) {
						if ($row2['gambar_andalan'] == '') {
							$img = '';
						} else {
							$img = '<img src="' . CI()->path() . '/' . $row2['gambar_andalan'] . '" alt="" style="width:100%">';
						}

						if ($img != '') {
							$menu .= '<h5><b>' . ucfirst($row2['judul_' . CI()->session->userdata('lang')]) . '</b></h5>
						<div class="img-mega-menu">
							' . $img . '
						</div>
						<p>
						<a href="' . site_url('home/' . $row2['kat_order'] . '/' . $row2['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row2['judul_' . CI()->session->userdata('lang')])))) . '"> ' . clang('Read more') . '</a>
						</p>';
						} else {
							$menu .= '<h5><b>' . ucfirst($row2['judul_' . CI()->session->userdata('lang')]) . '</b></h5>
						<p>' . substr(strip_tags($row2['tulisan_' . CI()->session->userdata('lang')]), 0, 150) . '...
						<a href="' . site_url('home/' . $row2['kat_order'] . '/' . $row2['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row2['judul_' . CI()->session->userdata('lang')])))) . '"> ' . clang('Read more') . '</a>
						</p>';
						}
					}
				}
				$menu .= '</li>';
			}
			$menu .= '
			</ul>
		</li>';
		} else if (isset($row['slug'])) {
			$menu .= '<li class="' . $li_warna . '"><a href="' . $row['slug'] . '">' . ucfirst($row['kategori']) . '</a></li>';
		} else {
			$menu .= '<li class="' . $li_warna . '"><a href="' . site_url('home/' . $row['kat_order'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')])))) . '"> ' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></li>';
		}
		return $menu;
	}
}

if (!function_exists('get_menu_sitemap')) {
	function get_menu_sitemap()
	{
		$i = 1;
		$menu = '';
		$menu_ = menu('utama');
		foreach ($menu_['menu'] as $row) {
			$j = 1;
			$jenis = $row['jenis'];
			$menu .= set_menu_sitemap($row, $menu_['parent'], $i, $j, $row['jenis']);
			$i++;
		}
		return $menu;
	}
	function set_menu_sitemap($row, $parent, $i, $j, $jenis)
	{
		if ($i <= 4) {
			$drop = 'left';
		} else {
			$drop = 'right';
		}
		$menu = '';
		if (isset($row['id_kategori']) && isset($parent[$row['id_kategori']]) && $parent[$row['id_kategori']] != null && $jenis == 'dropdown') {
			$menu .= '<li>
        <a href="#">' . ucfirst($row['kategori']) . ' </a>
            <ul>';
			$j++;
			foreach ($parent[$row['id_kategori']] as $row2) {
				$menu .= set_menu_sitemap($row2, $parent, $i, $j, $jenis);
			}
			$menu .= '</ul>
        </li>';
		} else if (isset($row['id_kategori']) && isset($parent[$row['id_kategori']]) && $parent[$row['id_kategori']] != null && $jenis == 'mega') {
			$menu .= '<li>
			<a href="#">
			' . ucfirst($row['kategori']) . '
			</a>
			<ul>';
			foreach ($parent[$row['id_kategori']] as $row2) {
				$menu .= '<li>';
				if (isset($row2['id_kategori']) && isset($parent[$row2['id_kategori']]) && $parent[$row2['id_kategori']] != null) {
					$menu .= '' . ucfirst($row2['kategori']) . '<ul>';
					foreach ($parent[$row2['id_kategori']] as $row3) {
						if (isset($row3['id_kategori'])) {
							$menu .= '<li><a href="' . $row3['slug'] . '">' . ucfirst($row3['kategori']) . '</a></li>';
						} else {
							$menu .= '<li><a href="' . site_url() . 'home/' . $row3['kat_order'] . '/' . $row3['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row3['judul_' . CI()->session->userdata('lang')]))) . '">' . ucfirst($row3['judul_' . CI()->session->userdata('lang')]) . '</a></li>';
						}
					}
					$menu .= '</ul>';
				} else if (isset($row2['id_kategori'])) {
					$menu .= '<ul><li><a href="' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a></li></ul>';
				} else {
					if (isset($row2['id_tulisan'])) {
						$menu .= '<a href="' . site_url('home/' . $row2['kat_order'] . '/' . $row2['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row2['judul_' . CI()->session->userdata('lang')])))) . '">' . ucfirst(implode(' ', array_slice(explode(' ', strip_tags($row2['judul_' . CI()->session->userdata('lang')])), 0, 5))) . '</a>';
					}
				}
				$menu .= '</li>';
			}
			$menu .= '
			</ul>
		</li>';
		} else if (isset($row['slug'])) {
			$menu .= '<li><a href="' . $row['slug'] . '">' . ucfirst($row['kategori']) . '</a></li>';
		} else {
			$menu .= '<li><a href="' . site_url('home/' . $row['kat_order'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')])))) . '"> ' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></li>';
		}
		return $menu;
	}
}

if (!function_exists('background')) {
	function background()
	{
		$bg = '';
		if (CI()->config->config['background'] != '' && CI()->config->config['background_s'] == 'yes') {
			$bg  = 'background: url(' . CI()->config->config['background'] . ');';
			if (CI()->config->config['repeat'] != '') {
				$bg .= 'background-repeat: ' . CI()->config->config['repeat'] . ';';
			}
			if (CI()->config->config['repeat'] != '') {
				$bg .= 'background-attachment: ' . CI()->config->config['fixed'] . ';';
			}
		} else if (CI()->config->config['background'] == '' && CI()->config->config['background_s'] == 'no') {
			$bg = 'background:#fff;background-image:none;';
		}
		echo $bg;
	}
}

if (!function_exists('get_menu_atas')) {
	function get_menu_atas()
	{
		$i = 1;
		$menu = '<ul>';
		$menu_ = menu('atas');
		//$menu.='<li><img src="'.CI()->config->config['blogimgheader'].'" style="height:26px;margin-top:-10px;margin-bottom:-5px;margin-left:-5px;margin-right:-5px;"></li>';
		foreach ($menu_['menu'] as $row) {
			$j = 1;
			if (isset($row['slug'])) {
				$menu .= '<li class="hidden-xs"><a href="' . $row['slug'] . '">' . ucfirst($row['kategori']) . '</a></li>';
			} else {
				$menu .= '<li class="hidden-xs"><a href="' . site_url('home/' . $row['kat_order'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')])))) . '"> ' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></li>';
			}
			$i++;
		}
		$menu .= '<div class="pull-right">';
		$menu .= '<li><a href="' . site_url() . '"><b>' . hari(date('N', mktime(0, 0, 0, date('m'), date('d'), date('Y')))) . ', ' . date('d') . ' ' . bln(date('m')) . ' ' . date('Y') . '</b></a></li>';
		$menu .= '<li><a href="' . site_url('d4sh') . '"><i class="fa fa-sign-in"></i> ' . clang('Login') . '</a></li>';
		// $menu .= '<span class="pull-right">'.get_bahasa().'</span>';
		$menu .= '</div>';
		$menu .= '</ul>';
		return $menu;
	}
}

if (!function_exists('get_menu_atas_sitemap')) {
	function get_menu_atas_sitemap($mode = null)
	{
		$i = 1;
		$menu = '';
		$menu_ = menu('atas');
		foreach ($menu_['menu'] as $row) {
			$j = 1;
			if ($mode == 'xml') {
				if (isset($row['slug'])) {
					$menu .= '<url><loc>' . $row['slug'] . '</loc></url>';
				} else {
					$menu .= '<url><loc>' . site_url('home/' . $row['kat_order'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')])))) . '</loc></url>';
				}
			} else {
				if (isset($row['slug'])) {
					$menu .= '<li><a href="' . $row['slug'] . '">' . ucfirst($row['kategori']) . '</a></li>';
				} else {
					$menu .= '<li><a href="' . site_url('home/' . $row['kat_order'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')])))) . '"> ' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></li>';
				}
			}
			$i++;
		}
		return $menu;
	}
}

if (!function_exists('get_menu_bawah')) {
	function get_menu_bawah()
	{
		$i = 1;
		$menu = '<ul>';
		$menu_ = menu('bawah');
		foreach ($menu_['menu'] as $row) {
			$j = 1;
			if (isset($row['slug'])) {
				$menu .= '<li><a href="' . $row['slug'] . '">' . ucfirst($row['kategori']) . '</a></li>';
			} else {
				$menu .= '<li><a href="' . site_url('home/' . $row['kat_order'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')])))) . '"> ' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></li>';
			}
			$i++;
		}
		$menu .= '</ul>';
		return $menu;
	}
}

if (!function_exists('get_menu_bawah_sitemap')) {
	function get_menu_bawah_sitemap($mode = null)
	{
		$i = 1;
		$menu = '';
		$menu_ = menu('bawah');
		foreach ($menu_['menu'] as $row) {
			$j = 1;
			if ($mode == 'xml') {
				if (isset($row['slug'])) {
					$menu .= '<url><loc>' . $row['slug'] . '</loc></url>';
				} else {
					$menu .= '<url><loc>' . site_url('home/' . $row['kat_order'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')])))) . '</loc></url>';
				}
			} else {
				if (isset($row['slug'])) {
					$menu .= '<li><a href="' . $row['slug'] . '">' . ucfirst($row['kategori']) . '</a></li>';
				} else {
					$menu .= '<li><a href="' . site_url('home/' . $row['kat_order'] . '/' . $row['id_tulisan'] . '/' . preg_replace("/[\/\!@#$%^&*()=+{},]/", "_", str_replace(' ', '-', strtolower($row['judul_' . CI()->session->userdata('lang')])))) . '"> ' . ucfirst($row['judul_' . CI()->session->userdata('lang')]) . '</a></li>';
				}
			}
			$i++;
		}
		return $menu;
	}
}

if (!function_exists('get_tulisan_sitemap')) {
	function get_tulisan_sitemap()
	{
		$ber = '';
		CI()->db->where(array('tipe_kategori' => 'label'));
		CI()->db->select('id_kategori,slug');
		$k = CI()->db->get('kategori')->result_array();
		if ($k != null) {
			foreach ($k as $row) {
				CI()->db->where(array('tipe' => $row['id_kategori']));
				CI()->db->select('id_tulisan,judul_' . CI()->session->userdata('lang'));
				$t = CI()->db->get('tulisan')->result_array();
				$ber .= '<url><loc>' . site_url('home/' . $row['slug']) . '</loc></url>';
				foreach ($t as $row2) {
					$ber .= '<url><loc>' . site_url('home/' . $row['slug']) . '/' . $row2['id_tulisan'] . '</loc></url>';
				}
			}
			CI()->db->where(array('tipe' => 'album'));
			CI()->db->select('id_tulisan,judul_' . CI()->session->userdata('lang'));
			$t = CI()->db->get('tulisan')->result_array();
			$ber .= '<url><loc>' . site_url('home/album') . '</loc></url>';
			foreach ($t as $row2) {
				$ber .= '<url><loc>' . site_url('home/album') . '/' . $row2['id_tulisan'] . '</loc></url>';
			}
			CI()->db->where(array('tipe' => 'page'));
			CI()->db->select('id_tulisan,judul_' . CI()->session->userdata('lang'));
			$t = CI()->db->get('tulisan')->result_array();
			foreach ($t as $row2) {
				$ber .= '<url><loc>' . site_url('home/halaman') . '/' . $row2['id_tulisan'] . '</loc></url>';
			}
			$ber .= '<url><loc>' . site_url('home/video') . '</loc></url>';
		}
		return $ber;
	}
}

if (!function_exists('menu')) {
	function menu($posisi = null)
	{
		if ($posisi != null) {
			$pos_menu = "AND `posisi`='" . $posisi . "'";
		} else {
			$pos_menu = "";
		}
		$menu_['menu'] = null;
		$menu_['parent'] = null;
		$table_name = 'kategori';
		if (CI()->db->table_exists($table_name)) {
			$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='menu' AND `parent`=0 " . $pos_menu . " ORDER BY no_urut ASC";
			$menu_['menu'] = CI()->db->query($string)->result_array();
			if ($menu_['menu'] != null) {
				$parent = null;
				$menu_['error'] = 0;
				$string_2 = "SELECT * FROM `kategori` WHERE `tipe_kategori`='menu' AND `parent`!=0";
				$parent = CI()->db->query($string_2)->result_array();
				$string_3 = "SELECT * FROM `hub_menu_sub` JOIN `tulisan` ON `hub_menu_sub`.`id_kat`=`tulisan`.`id_tulisan` ORDER BY `id_kat` ASC";
				$parent_2 = CI()->db->query($string_3)->result_array();
				if ($parent_2 != null) {
					foreach ($parent_2 as $row2) {
						$menu_['parent'][$row2['id_tul']][] = $row2;
					}
				}
				if ($parent != null) {
					foreach ($parent as $row) {
						$menu_['parent'][$row['parent']][] = $row;
					}
				}
			} else {
				$menu_['error'] = 'Menu tidak ada!';
			}
		} else {
			$menu_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $menu_;
	}
}

if (!function_exists('gg_')) {
	function gg_()
	{
		$url = $_SERVER['SERVER_NAME'];
		$file = fopen("code.txt", "r");
		while (!feof($file)) {
			$b = fgets($file);
			if ($url != sdxDec($b) && $url != sdxDec('e7d9287079696d74767983803439') && $url != sdxDec('12a8423543383a3944423e3d423e4241473439')) {
				exit();
			}
		}
		fclose($file);
	}
}
