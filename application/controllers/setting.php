<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('crud');
	}

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
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='menu' AND `parent`=0 " . $pos_menu;
			$menu_['menu'] = $this->crud->get(null, null, null, null, null, $string);
			if ($menu_['menu'] != null) {
				$parent = null;
				$menu_['error'] = 0;
				$string_2 = "SELECT * FROM `kategori` WHERE `tipe_kategori`='menu' AND `parent`!=0";
				$parent = $this->crud->get(null, null, null, null, null, $string_2);
				$string_3 = "SELECT * FROM `hub_menu_sub` JOIN `tulisan` ON `hub_menu_sub`.`id_kat`=`tulisan`.`id_tulisan` ORDER BY `id_kat` ASC";
				$parent_2 = $this->crud->get(null, null, null, null, null, $string_3);
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
		$tulisan_['tulisan'] = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `tulisan` JOIN `pengguna` ON `tulisan`.`penulis` = `pengguna`.`id_pengguna` WHERE `tulisan`.`tipe`='" . $tipe_tul . "' AND `tulisan`.`status_tulisan`='" . $sts_tul . "' " . $id_tul . " " . $pin_tul . " ORDER BY " . $order_tul . " " . $limit_tul;
			$tulisan_['tulisan'] = $this->crud->get(null, null, null, null, null, $string);
			if ($tulisan_['tulisan'] != null) {
				$tulisan_['error'] = 0;
				foreach ($tulisan_['tulisan'] as $id) {
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
			$limit_ = $limit;
		} else {
			$limit_tul = "";
			$limit_ = "3";
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
			$cari_tul = " AND (`tulisan`.`judul_" . $this->session->userdata('lang') . "` LIKE '%" . $cari . "%' OR `tulisan`.`tulisan_" . $this->session->userdata('lang') . "` LIKE '%" . $cari . "%') ";
		} else {
			$cari_tul = "";
		}
		$tulisan_['tulisan'] = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			if ($id_kat_ != "") {
				$string = "SELECT * FROM `tulisan` JOIN `pengguna` ON `tulisan`.`penulis` = `pengguna`.`id_pengguna` JOIN `hub_kat_tul` ON `tulisan`.`id_tulisan` = `hub_kat_tul`.`id_tul` WHERE " . $tipe_tul . " `tulisan`.`status_tulisan`='" . $sts_tul . "' " . $id_tul . " " . $id_kat_ . " " . $cari_tul . " ORDER BY `tulisan`.`id_tulisan` DESC ";
			} else {
				$string = "SELECT * FROM `tulisan` JOIN `pengguna` ON `tulisan`.`penulis` = `pengguna`.`id_pengguna` WHERE " . $tipe_tul . " `tulisan`.`status_tulisan`='" . $sts_tul . "' " . $id_tul . " " . $cari_tul . " ORDER BY `tulisan`.`id_tulisan` DESC ";
			}
			$tulisan_all = $this->crud->get(null, null, null, null, null, $string);
			if ($tulisan_all != null) {
				if ($this->uri->segment(2) == 'kategori') {
					$config['base_url'] = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/page/');
					$config['uri_segment'] = 5;
				} else {
					$config['base_url'] = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/page/');
					$config['uri_segment'] = 4;
				}
				$config['total_rows'] = count($tulisan_all);
				$config['per_page'] = $limit_;
				$config['first_page'] = clang('First');
				$config['last_page'] = clang('Last');
				$config['next_page'] = '«';
				$config['prev_page'] = '»';
				$this->pagination->initialize($config);
				$tulisan_['halaman'] = $this->pagination->create_links();

				if ($this->uri->segment(2) == 'kategori') {
					if ($this->uri->segment(5) == '') {
						$offset = 0;
					} else if ($this->uri->segment(4) == 'page') {
						$offset = $this->uri->segment(5);
					} else {
						$offset = 0;
					}
				} else {
					if ($this->uri->segment(4) == '') {
						$offset = 0;
					} else if ($this->uri->segment(3) == 'page') {
						$offset = $this->uri->segment(4);
					} else {
						$offset = 0;
					}
				}
				if ($id_kat_ != "") {
					$string_2 = "SELECT * FROM `tulisan` JOIN `pengguna` ON `tulisan`.`penulis` = `pengguna`.`id_pengguna` JOIN `hub_kat_tul` ON `tulisan`.`id_tulisan` = `hub_kat_tul`.`id_tul` WHERE " . $tipe_tul . " `tulisan`.`status_tulisan`='" . $sts_tul . "' " . $id_tul . " " . $id_kat_ . " " . $cari_tul . " ORDER BY `tulisan`.`id_tulisan` DESC limit " . $offset . "," . $config['per_page'];
				} else {
					$string_2 = "SELECT * FROM `tulisan` JOIN `pengguna` ON `tulisan`.`penulis` = `pengguna`.`id_pengguna` WHERE " . $tipe_tul . " `tulisan`.`status_tulisan`='" . $sts_tul . "' " . $id_tul . " " . $cari_tul . " ORDER BY `tulisan`.`id_tulisan` DESC limit " . $offset . "," . $config['per_page'];
				}
				$tulisan_['tulisan'] = $this->crud->get(null, null, null, null, null, $string_2);

				$tulisan_['error'] = 0;
				foreach ($tulisan_['tulisan'] as $id) {
					$table_name_1 = 'hub_kat_tul';
					$table_name_2 = 'kategori';
					if ($this->db->table_exists($table_name_1) && $this->db->table_exists($table_name_2)) {
						$tulisan_['kat_tul'][$id['id_tulisan']] = null;
						$string_ = "SELECT * FROM `hub_kat_tul` JOIN `kategori` ON `hub_kat_tul`.`id_kat` = `kategori`.`id_kategori` WHERE `hub_kat_tul`.`id_tul`=" . $id['id_tulisan'] . " AND `kategori`.`tipe_kategori`='category'";
						$tulisan_['kat_tul'][$id['id_tulisan']] = $this->crud->get(null, null, null, null, null, $string_);
					}

					$table_name_3 = 'komentar';
					if ($this->db->table_exists($table_name_3)) {
						$tulisan_['kom_tul'][$id['id_tulisan']] = null;
						$string__ = "SELECT * FROM `komentar` WHERE `id_tul`=" . $id['id_tulisan'] . " AND `status_komentar_`='terbit' ORDER BY `tgl_komentar` ASC";
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

	function kategoriBertingkat($tipe = null)
	{
		if ($tipe != null) {
			$tipe_tul = " AND `tulisan`.`tipe`='" . $tipe . "' ";
		} else {
			$tipe_tul = "";
		}
		$kategori_['kategori'] = null;
		$kategori_['parent'] = null;
		$table_name = 'kategori';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `kategori` WHERE `tipe_kategori`='category' AND `parent`=0 ";
			$kategori_['kategori'] = $this->crud->get(null, null, null, null, null, $string);
			if ($kategori_['kategori'] != null) {
				foreach ($kategori_['kategori'] as $row1) {
					$tul = null;
					$kategori_['jml_tul'][$row1['id_kategori']] = 0;
					$string_1 = "SELECT * FROM `tulisan` JOIN `hub_kat_tul` ON `tulisan`.`id_tulisan` = `hub_kat_tul`.`id_tul` WHERE `tulisan`.`status_tulisan`='terbit' AND `hub_kat_tul`.`id_kat`='" . $row1['id_kategori'] . "' " . $tipe_tul;
					$tul = $this->crud->get(null, null, null, null, null, $string_1);
					if ($tul != null) {
						$kategori_['jml_tul'][$row1['id_kategori']] = count($tul);
					}
				}
				$kategori_['error'] = 0;
				$parent = null;
				$string_2 = "SELECT * FROM `kategori` WHERE `tipe_kategori`='category' AND `parent`!=0";
				$parent = $this->crud->get(null, null, null, null, null, $string_2);
				if ($parent != null) {
					foreach ($parent as $row) {
						$tul = null;
						$kategori_['parent'][$row['parent']][] = $row;
						$kategori_['jml_tul'][$row['id_kategori']] = 0;
						$string_1_ = "SELECT * FROM `tulisan` JOIN `hub_kat_tul` ON `tulisan`.`id_tulisan` = `hub_kat_tul`.`id_tul` WHERE `tulisan`.`status_tulisan`='terbit' AND `hub_kat_tul`.`id_kat`='" . $row['id_kategori'] . "' " . $tipe_tul;
						$tul = $this->crud->get(null, null, null, null, null, $string_1_);
						if ($tul != null) {
							$kategori_['jml_tul'][$row['id_kategori']] = count($tul);
						}
					}
				}
			} else {
				$kategori_['error'] = 'Kategori tidak ada!';
			}
		} else {
			$kategori_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $kategori_;
	}

	function kategoriProdukSemua($tipe = null)
	{
		if ($tipe != null) {
			$tipe_tul = $tipe;
		} else {
			$tipe_tul = "page";
		}
		$kategori_['kategori'] = null;
		$table_name = 'kategori';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT DISTINCT `kategori`.`id_kategori`,`kategori`.* FROM `kategori` INNER JOIN `hub_kat_tul` ON `kategori`.`id_kategori`=`hub_kat_tul`.`id_kat` INNER JOIN `tulisan` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE `kategori`.`tipe_kategori`='category' AND `tulisan`.`tipe`='" . $tipe_tul . "'";
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

	function testimoni($status = null, $limit = null)
	{
		if ($status != null) {
			$sts_tes = $status;
		} else {
			$sts_tes = "terbit";
		}
		if ($limit != null) {
			$limit_tes = " LIMIT " . $limit;
		} else {
			$limit_tes = "";
		}

		$testimoni_['testimoni'] = null;
		$table_name = 'testimoni';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `testimoni` WHERE `status_testimoni_`='" . $sts_tes . "' " . $limit_tes;
			$testimoni_['testimoni'] = $this->crud->get(null, null, null, null, null, $string);
			if ($testimoni_['testimoni'] != null) {
				$testimoni_['error'] = 0;
			} else {
				$testimoni_['error'] = 'Testimoni tidak ada!';
			}
		} else {
			$testimoni_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $testimoni_;
	}

	function komentar($status = null, $limit = null)
	{
		if ($status != null) {
			$sts_tes = $status;
		} else {
			$sts_tes = "terbit";
		}
		if ($limit != null) {
			$limit_tes = " LIMIT " . $limit;
		} else {
			$limit_tes = "";
		}

		$komentar_['komentar'] = null;
		$table_name = 'komentar';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `komentar` JOIN `tulisan` ON `komentar`.`id_tul`=`tulisan`.`id_tulisan` WHERE `status_komentar_`='" . $sts_tes . "' ORDER BY `komentar`.`id_komentar` DESC " . $limit_tes;
			$komentar_['komentar'] = $this->crud->get(null, null, null, null, null, $string);
			if ($komentar_['komentar'] != null) {
				$komentar_['error'] = 0;
			} else {
				$komentar_['error'] = 'Komentar tidak ada!';
			}
		} else {
			$komentar_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $komentar_;
	}

	function carousel()
	{
		$slide_['slide'] = null;
		$table_name = 'carousel';
		if ($this->db->table_exists($table_name)) {
			$slide_['error'] = 0;
			$string = "SELECT * FROM `carousel` WHERE `status_carousel`='open'";
			$slide_['slide'] = $this->crud->get(null, null, null, null, null, $string);
			if ($slide_['slide'] != null) {
				foreach ($slide_['slide'] as $row) {
					$data_ = null;
					$string_ = "SELECT * FROM `carousel_animasi` WHERE `id_carousel`=" . $row['id_carousel'];
					if ($this->db->table_exists('carousel_animasi')) {
						$data_ = $this->crud->get(null, null, null, null, null, $string_);
						if ($data_ != null) {
							foreach ($data_ as $row2) {
								$slide_['parent'][$row['id_carousel']][$row2['animasi']] = $row2['animasi_value'];
							}
						} else {
							$slide_['parent'][$row['id_carousel']] = null;
						}
					}
				}
			} else {
				$slide_['error'] = 'Carousel tidak ada!';
			}
		} else {
			$slide_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $slide_;
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

	function gambar_album($limit = null, $id = null)
	{
		if ($limit != null) {
			$limit_tes = " LIMIT " . $limit;
		} else {
			$limit_tes = "";
		}
		if ($id != null) {
			$id_tul = " AND `tulisan`.`id_tulisan`='" . $id . "'";
		} else {
			$id_tul = "";
		}
		$gambar_['gambar'] = null;
		$table_name = 'gambar_album';
		if ($this->db->table_exists($table_name)) {
			$gambar_['error'] = 0;
			$string = "SELECT * FROM `gambar_album` JOIN `tulisan` ON `tulisan`.`id_tulisan` = `gambar_album`.`folder` WHERE `tulisan`.`status_tulisan`='terbit' AND `tulisan`.`tipe`='album' " . $id_tul . " " . $limit_tes;
			$data = $this->crud->get(null, null, null, null, null, $string);
			if ($data == null) {
				$gambar_['error'] = 'Gambar tidak ada!';
			} else {
				$gambar_['gambar'] = $data;
			}
		} else {
			$gambar_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $gambar_;
	}

	function carousel2()
	{
		$carousel_['tulisan'] = null;
		$table_name = 'kategori';
		if ($this->db->table_exists($table_name)) {
			$carousel_['error'] = 0;
			$string = "SELECT * FROM `kategori` WHERE `status_kategori`='open' AND `tipe_kategori`='slide' ORDER BY `id_kategori` DESC limit 1";
			$carousel_['tulisan'] = $this->crud->get(null, null, null, null, null, $string);
			if ($carousel_['tulisan'] == null) {
				$carousel_['error'] = 'Tulisan tidak ditemukan';
			} else {
				$table_name_ = 'hub_slide_img';
				if ($this->db->table_exists($table_name_)) {
					$string_ = "SELECT * FROM `hub_slide_img` WHERE `id_tul`='" . $carousel_['tulisan'][0]['id_kategori'] . "'";
					$carousel_smt = $this->crud->get(null, null, null, null, null, $string_);
					$i = 1;
					if ($carousel_smt != null) {
						foreach ($carousel_smt as $row) {
							$id_kat = explode('|', $row['id_kat']);
							if ($id_kat[0] == 'post') {
								$post = null;
								$string__ = "SELECT * FROM `tulisan` WHERE `id_tulisan`='" . $id_kat[1] . "'";
								$post = $this->crud->get(null, null, null, null, null, $string__);
								if ($post != null) {
									$carousel_['slide'][$i]['kat_order'] = $row['kat_order'];
									$carousel_['slide'][$i]['judul'] = substr($post[0]['judul_' . $this->session->userdata('lang')], 0, 25) . '...';
									$carousel_['slide'][$i]['keterangan'] = substr(strip_tags($post[0]['tulisan_' . $this->session->userdata('lang')]), 0, 80) . '...';
									if ($post[0]['tipe'] == 'post') {
										$tipe = 'berita';
									} else {
										$tipe = $post[0]['tipe'];
									}
									$carousel_['slide'][$i]['link'] = site_url('lihat/' . $tipe . '/' . $post[0]['id_tulisan']);
								} else {
									$carousel_['slide'][$i]['kat_order'] = $row['kat_order'];
									$carousel_['slide'][$i]['judul'] = ucfirst($id_kat[0]);
									$carousel_['slide'][$i]['keterangan'] = ucfirst($id_kat[0]);
									$carousel_['slide'][$i]['link'] = site_url('lihat/' . $id_kat[0]);
								}
							} else {
								$carousel_['slide'][$i]['kat_order'] = $row['kat_order'];
								$carousel_['slide'][$i]['judul'] = 'Gambar Andalan';
								$carousel_['slide'][$i]['keterangan'] = 'Gambar Andalan';
								$carousel_['slide'][$i]['link'] = site_url('lihat/album');
							}
							$i++;
						}
					}
				}
			}
		} else {
			$carousel_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $carousel_;
	}

	function carousel3($tipe = null)
	{
		$carousel_['tulisan'] = null;
		$table_name = 'tulisan';
		if ($this->db->table_exists($table_name)) {
			$post = null;
			$string__ = "SELECT * FROM `tulisan` JOIN `kategori` ON `tulisan`.`tipe`=`kategori`.`id_kategori` WHERE `tipe`='" . $tipe . "' AND `status_tulisan`='terbit' AND `kategori`.`tipe_kategori`='label' ORDER BY `id_tulisan` ASC LIMIT 4";
			$post = $this->crud->get(null, null, null, null, null, $string__);
			if ($post != null) {
				$carousel_['error'] = 0;
				foreach ($post as $row) {
					$carousel_['slide'][$row['id_tulisan']]['kat_order'] = $row['gambar_andalan'];
					$carousel_['slide'][$row['id_tulisan']]['judul'] = substr($row['judul_' . $this->session->userdata('lang')], 0, 25) . '...';
					$carousel_['slide'][$row['id_tulisan']]['keterangan'] = substr(strip_tags($row['tulisan_' . $this->session->userdata('lang')]), 0, 80) . '...';
					$carousel_['slide'][$row['id_tulisan']]['link'] = site_url('lihat/' . $row['slug'] . '/' . $row['id_tulisan']);
				}
			} else {
				$carousel_['error'] = 'Tulisan tidak ada!';
			}
		} else {
			$carousel_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $carousel_;
	}

	function banner($tipe = null)
	{
		if ($tipe != null) {
			$tipe_tul = $tipe;
		} else {
			$tipe_tul = "utama";
		}
		$kategori_['banner'] = null;
		$table_name = 'banner';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `banner` WHERE `posisi`='" . $tipe_tul . "'";
			$kategori_['banner'] = $this->crud->get(null, null, null, null, null, $string);
			if ($kategori_['banner'] != null) {
				$kategori_['error'] = 0;
			} else {
				$kategori_['error'] = 'Banner tidak ada!';
			}
		} else {
			$kategori_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $kategori_;
	}

	function video($status = null, $limit = null, $id = null)
	{
		if ($status != null) {
			$sts_vid = $status;
		} else {
			$sts_vid = "open";
		}
		if ($limit != null) {
			$limit_vid = " LIMIT " . $limit;
			$limit_ = $limit;
		} else {
			$limit_vid = "";
			$limit_ = "5";
		}
		if ($id != null) {
			$id_vid = " AND `video`.`id_video`='" . $id . "'";
		} else {
			$id_vid = "";
		}
		$video_['video'] = null;
		$table_name = 'video';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `video` JOIN `pengguna` ON `video`.`pengunggah`=`pengguna`.`id_pengguna` WHERE `status_video`='" . $sts_vid . "' " . $id_vid . " ORDER BY `id_video` DESC " . $limit_vid;
			$video_all = $this->crud->get(null, null, null, null, null, $string);
			if ($id_vid != '') {
				$string2 = "SELECT * FROM `video` JOIN `pengguna` ON `video`.`pengunggah`=`pengguna`.`id_pengguna` WHERE `status_video`='" . $sts_vid . "' ORDER BY `id_video` DESC limit 3";
				$video_['vid_lain'] = $this->crud->get(null, null, null, null, null, $string2);;
			}
			if ($video_all != null) {
				$video_['error'] = 0;
				$config['base_url'] = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/page/');
				$config['total_rows'] = count($video_all);
				$config['per_page'] = $limit_;
				$config['first_page'] = clang('First');
				$config['last_page'] = clang('Last');
				$config['next_page'] = '«';
				$config['prev_page'] = '»';
				$this->pagination->initialize($config);
				$video_['halaman'] = $this->pagination->create_links();
				if ($this->uri->segment(4) == '') {
					$offset = 0;
				} else if ($this->uri->segment(3) == 'page') {
					$offset = $this->uri->segment(4);
				} else {
					$offset = 0;
				}
				$string_2 = "SELECT * FROM `video` JOIN `pengguna` ON `video`.`pengunggah`=`pengguna`.`id_pengguna` WHERE `status_video`='" . $sts_vid . "' " . $id_vid . " ORDER BY `id_video` DESC limit " . $offset . "," . $config['per_page'];
				$video_['video'] = $this->crud->get(null, null, null, null, null, $string_2);
			} else {
				$video_['error'] = 'Video tidak ada!';
			}
		} else {
			$video_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $video_;
	}

	function poling($status = null, $status2 = null, $limit = null, $order = null, $id = null)
	{
		if ($status != null) {
			$sts_pol = "`status_poling`='" . $status . "'";
		} else {
			$sts_pol = "";
		}
		if ($status2 != null) {
			$sts_pol2 = "AND `status_poling_2`='" . $status2 . "'";
		} else {
			$sts_pol2 = "";
		}
		if ($limit != null) {
			$limit_pol = " LIMIT " . $limit;
		} else {
			$limit_pol = "";
		}
		if ($order != null) {
			$order_pol = $order;
		} else {
			$order_pol = " ORDER BY `id_poling` DESC ";
		}
		if ($id != null) {
			$id_pol = " AND `id_poling`='" . $id . "'";
		} else {
			$id_pol = "";
		}
		$poling_['poling'] = null;
		$table_name = 'poling';
		if ($this->db->table_exists($table_name)) {
			$string = "SELECT * FROM `poling` WHERE " . $sts_pol . " AND `parent_poling`='0' " . $sts_pol2 . " " . $id_pol . " " . $order_pol . " " . $limit_pol;
			$poling_['poling'] = $this->crud->get(null, null, null, null, null, $string);
			if ($poling_['poling'] != null) {
				$poling_['error'] = 0;
				foreach ($poling_['poling'] as $row) {
					$poling_['parent'][$row['id_poling']] = null;
					$string_2 = "SELECT * FROM `poling` WHERE " . $sts_pol . " AND `parent_poling`='" . $row['id_poling'] . "' ORDER BY `id_poling` ASC";
					$poling_['parent'][$row['id_poling']] = $this->crud->get(null, null, null, null, null, $string_2);
					if ($poling_['parent'][$row['id_poling']] != null) {
						foreach ($poling_['parent'][$row['id_poling']] as $row2) {
							$poling_['jml_poling'][$row2['id_poling']] = 0;
							$string_3 = "SELECT * FROM `poling_hasil` WHERE `id_poling_`='" . $row2['id_poling'] . "'";
							$get = null;
							$get = $this->crud->get(null, null, null, null, null, $string_3);
							if ($get != null) {
								$poling_['jml_poling'][$row2['id_poling']] = count($get);
							}
						}
					}
				}
			} else {
				$poling_['error'] = 'Poling tidak ada!';
			}
		} else {
			$poling_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $poling_;
	}

	function getstatistikhariini()
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
		$s = $this->crud->get(null, null, null, null, null, "SELECT * FROM `konter` WHERE `ip`='$ip' AND `tanggal`='$tanggal'");
		if ($s == null) {
			$data['pengunjung'] = array(
				'ip' => $ip,
				'tanggal' => $tanggal,
				'hits' => '1',
				'online' => $waktu
			);
			$this->crud->insert('konter', $data['pengunjung']);
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
			$this->crud->update('konter', $data['pengunjung'], $where);
		}
		if ($tglk == '1' | $tglk == '2' | $tglk == '3' | $tglk == '4' | $tglk == '5' | $tglk == '6' | $tglk == '7' | $tglk == '8' | $tglk == '9') {
			$tglk2 = $thn . $bln . '0' . $tglk;
			//$data['kemarin']=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal`='$thn-$bln-0$tglk'");
		} else {
			$tglk2 = $thn . $bln . $tglk;
			//$data['kemarin']=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal`='$thn-$bln-$tglk'");
		}
		$data['kemarin'] = $this->crud->get(null, null, null, null, null, "SELECT * FROM `konter` WHERE `tanggal`='$tglk2'");
		$data['bulan'] = $this->crud->get(null, null, null, null, null, "SELECT * FROM `konter` WHERE `tanggal` LIKE '%$blan%'");
		$data['bulan1'] = count($data['bulan']);
		$data['tahunini'] = $this->crud->get(null, null, null, null, null, "SELECT * FROM `konter` WHERE `tanggal` LIKE '%$thn%'");
		$data['tahunini1'] = count($data['tahunini']);
		$data['pengunjung'] = count($this->crud->get(null, null, null, null, null, "SELECT * FROM `konter` WHERE `tanggal`='$tanggal' GROUP BY `ip`"));
		$total = $this->crud->get(null, null, null, null, null, "SELECT COUNT(`hits`) as `totalpengunjung` FROM `konter`");
		$data['totalpengunjung'] = $total[0]['totalpengunjung'];
		$hits = $this->crud->get(null, null, null, null, null, "SELECT SUM(`hits`) as `hitstoday` FROM `konter` WHERE `tanggal`='$tanggal' GROUP BY `tanggal`");
		$data['hits'] = $hits[0]['hitstoday'];
		$totalhits = $this->crud->get(null, null, null, null, null, "SELECT SUM(`hits`) as `totalhits` FROM `konter`");
		$data['totalhits'] = $totalhits[0]['totalhits'];
		$data['bataswaktu'] = time() - 300;
		$data['pengunjungonline'] = count($this->crud->get(null, null, null, null, null, "SELECT * FROM `konter` WHERE `online` > '" . $data['bataswaktu'] . "'"));
		$data['totalcontent'] = count($this->crud->get(null, null, null, null, null, "SELECT * FROM `tulisan` WHERE `status_tulisan`='terbit'"));
		//$data['kemarin1'] = count($data['kemarin']);

		return $data;
	}

	function get_jml()
	{
		$where_tul = array(array('where_field' => 'tipe', 'where_key' => 'page'), array('where_field' => 'status_tulisan', 'where_key' => 'terbit'));
		$jml_tulisan = $this->crud->get('tulisan', $where_tul);
		if ($jml_tulisan != null) {
			$data['jml_tulisan'] = count($jml_tulisan);
		} else {
			$data['jml_tulisan'] = 0;
		}

		$where_hal = array(array('where_field' => 'tipe', 'where_key' => 'page'), array('where_field' => 'status_tulisan', 'where_key' => 'terbit'));
		$jml_halaman = $this->crud->get('tulisan', $where_hal);
		if ($jml_halaman != null) {
			$data['jml_halaman'] = count($jml_halaman);
		} else {
			$data['jml_halaman'] = 0;
		}

		$where_kom = array(array('where_field' => 'status_komentar_', 'where_key' => 'terbit'));
		$jml_komentar = $this->crud->get('komentar', $where_kom);
		if ($jml_komentar != null) {
			$data['jml_komentar'] = count($jml_komentar);
		} else {
			$data['jml_komentar'] = 0;
		}

		$where_kom2 = array(array('where_field' => 'status_komentar_', 'where_key' => 'menunggu'));
		$jml_komentar2 = $this->crud->get('komentar', $where_kom2);
		if ($jml_komentar2 != null) {
			$data['jml_komentar2'] = count($jml_komentar2);
		} else {
			$data['jml_komentar2'] = 0;
		}

		$where_tes2 = array(array('where_field' => 'status_testimoni_', 'where_key' => 'menunggu'));
		$jml_testimoni2 = $this->crud->get('testimoni', $where_tes2);
		if ($jml_testimoni2 != null) {
			$data['jml_testimoni2'] = count($jml_testimoni2);
		} else {
			$data['jml_testimoni2'] = 0;
		}

		$where_album = array(array('where_field' => 'tipe', 'where_key' => 'album'), array('where_field' => 'status_tulisan', 'where_key' => 'terbit'));
		$jml_album = $this->crud->get('tulisan', $where_album);
		if ($jml_album != null) {
			$data['jml_album'] = count($jml_album);
		} else {
			$data['jml_album'] = 0;
		}

		$data['jml_pengguna'] = count($this->crud->get('pengguna'));
		// $data['jml_statistik'] = count($this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal`='".date("Ymd")."' GROUP BY `ip`"));

		return $data;
	}

	function komentar_menunggu()
	{
		$komentar_['komentar'] = null;
		if (@$_GET['cari'] != '') {
			$cari = "WHERE `status_komentar_` = 'menunggu' AND (`komentar` LIKE '%" . $_GET['cari'] . "%' OR `nama` LIKE '%" . $_GET['cari'] . "%') ORDER BY `tgl_komentar` DESC";
		} else {
			$cari = "WHERE `status_komentar_` = 'menunggu' ORDER BY `tgl_komentar` DESC";
		}
		$table_name = 'komentar';
		if ($this->db->table_exists($table_name)) {
			$komentar_['error'] = 0;
			$string = "SELECT * FROM `komentar` JOIN `tulisan` ON `komentar`.`id_tul`=`tulisan`.`id_tulisan` " . $cari;
			$komentar = $this->crud->get(null, null, null, null, null, $string);
			$config['base_url'] = site_url('komentar/menunggu/index/page');
			$config['total_rows'] = count($komentar);
			$config['per_page'] = '10';
			$config['first_page'] = clang('First');
			$config['last_page'] = clang('Last');
			$config['next_page'] = '«';
			$config['prev_page'] = '»';
			$config['next_link'] = '&rarr;';
			$config['prev_link'] = '&larr;';
			$config['uri_segment'] = 5;
			$config['full_tag_open'] = '<ul class="pagination" style="margin:0px 7px;">';
			$this->pagination->initialize($config);
			$komentar_['pagging'] = $this->pagination->create_links();
			if ($komentar != null) {
				$komentar_['total_rows_2'] = $config['total_rows'];
			} else {
				$komentar_['total_rows_2'] = 0;
			}

			if ($this->uri->segment(5) != '') {
				$offset = $this->uri->segment(5);
			} else {
				$offset = 0;
			}
			$string_2 = "SELECT `komentar`.*,`tulisan`.`judul_" . $this->session->userdata('lang') . "`,`tulisan`.`penulis` FROM `komentar` JOIN `tulisan` ON `komentar`.`id_tul`=`tulisan`.`id_tulisan` " . $cari . " limit " . $offset . "," . $config['per_page'];
			$komentar_['komentar'] = $this->crud->get(null, null, null, null, null, $string_2);
			$komentar_['no'] = $offset;
			$semua = $this->crud->get(null, null, null, null, null, "SELECT count(`id_komentar`) as `total` FROM `komentar` WHERE `status_komentar_` != 'sampah' ORDER BY `tgl_komentar` DESC");
			if ($semua != null) {
				$komentar_['total_rows'] = $semua[0]['total'];
			} else {
				$komentar_['total_rows'] = 0;
			}
			$sampah = $this->crud->get(null, null, null, null, null, "SELECT count(`id_komentar`) as `total` FROM `komentar` WHERE `status_komentar_` = 'sampah' ORDER BY `tgl_komentar` DESC");
			if ($sampah != null) {
				$komentar_['total_rows_3'] = $sampah[0]['total'];
			} else {
				$komentar_['total_rows_3'] = 0;
			}
		} else {
			$komentar_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $komentar_;
	}

	function testimoni_menunggu()
	{
		$testimoni_['testimoni'] = null;
		if (@$_GET['cari'] != '') {
			$cari = "WHERE `status_testimoni_` = 'menunggu' AND (`testimoni` LIKE '%" . $_GET['cari'] . "%' OR `nama` LIKE '%" . $_GET['cari'] . "%') ORDER BY `tgl_testimoni` DESC";
		} else {
			$cari = "WHERE `status_testimoni_` = 'menunggu' ORDER BY `tgl_testimoni` DESC";
		}
		$table_name = 'testimoni';
		if ($this->db->table_exists($table_name)) {
			$testimoni_['error'] = 0;
			$string = "SELECT * FROM `testimoni` " . $cari;
			$testimoni = $this->crud->get(null, null, null, null, null, $string);
			$config['base_url'] = site_url('testimoni/menunggu/index/page');
			$config['total_rows'] = count($testimoni);
			$config['per_page'] = '10';
			$config['first_page'] = clang('First');
			$config['last_page'] = clang('Last');
			$config['next_page'] = '«';
			$config['prev_page'] = '»';
			$config['next_link'] = '&rarr;';
			$config['prev_link'] = '&larr;';
			$config['uri_segment'] = 5;
			$config['full_tag_open'] = '<ul class="pagination" style="margin:0px 7px;">';
			$this->pagination->initialize($config);
			$testimoni_['pagging'] = $this->pagination->create_links();
			if ($testimoni != null) {
				$testimoni_['total_rows_2'] = $config['total_rows'];
			} else {
				$testimoni_['total_rows_2'] = 0;
			}

			if ($this->uri->segment(5) != '') {
				$offset = $this->uri->segment(5);
			} else {
				$offset = 0;
			}
			$string_2 = "SELECT * FROM `testimoni` " . $cari . " limit " . $offset . "," . $config['per_page'];
			$testimoni_['testimoni'] = $this->crud->get(null, null, null, null, null, $string_2);
			$testimoni_['no'] = $offset;
			$semua = $this->crud->get(null, null, null, null, null, "SELECT count(`id_testimoni`) as `total` FROM `testimoni` WHERE `status_testimoni_` != 'sampah' ORDER BY `tgl_testimoni` DESC");
			if ($semua != null) {
				$testimoni_['total_rows'] = $semua[0]['total'];
			} else {
				$testimoni_['total_rows'] = 0;
			}
			$sampah = $this->crud->get(null, null, null, null, null, "SELECT count(`id_testimoni`) as `total` FROM `testimoni` WHERE `status_testimoni_` = 'sampah' ORDER BY `tgl_testimoni` DESC");
			if ($sampah != null) {
				$testimoni_['total_rows_3'] = $sampah[0]['total'];
			} else {
				$testimoni_['total_rows_3'] = 0;
			}
		} else {
			$testimoni_['error'] = 'Tabel ' . $table_name . ' tidak ada!';
		}
		return $testimoni_;
	}

	function status_website()
	{
		$string = "SELECT * FROM `web` WHERE `option_name` = 'status_website'";
		$sts_w  = $this->crud->get(null, null, null, null, null, $string);
		return $sts_w;
	}
}
