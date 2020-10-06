<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Web extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
		//$this->load->library('Loginaut');
	}

	public function index(){
		if($this->session->userdata('id_pengguna')!=''){
			$id_user=$this->session->userdata('id_pengguna');
		}else{
			$id_user='0';
		}
		/*$data_2=array(
			'id_user'=>$id_user,
			'id_tulisan'=>'0',
			'tgl_statistik'=>date('Y-m-d h:i:s')
		);
		$this->crud->insert('statistik',$data_2);*/
		
		$data['statistik']=$this->statistik();
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Halaman Utama';
		$data['modules']='web';
		$data['content']='v_web_baru';
		$this->load->view('../../template/template_baru.php', $data);
	}

	public function statistik(){
		$s=null;
		$ip=$_SERVER['REMOTE_ADDR'];
		$tanggal=date("Ymd");
		$waktu=time();
		$bln=date("m");
		$tgl=date("d");
		$blan=date("Y-m");
		$thn=date("Y");
		$tglk=$tgl-1;
		$s = $this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `ip`='$ip' AND `tanggal`='$tanggal'");
		if($s == null){
			$data['pengunjung'] = array(
				'ip'=>$ip,
				'tanggal'=>$tanggal,
				'hits'=>'1',
				'online'=>$waktu
			);
			$this->crud->insert('konter',$data['pengunjung']);
		}else{
			$data['pengunjung'] = array(
				'tanggal'=>$tanggal,
				'hits'=>$s[0]['hits']+1,
				'online'=>$waktu
			);
			$where=array(
				array(
					'where_field'=>'ip',
					'where_key'=>$ip
				),
				array(
					'where_field'=>'tanggal',
					'where_key'=>$tanggal
				)
			);
			$this->crud->update('konter',$data['pengunjung'],$where);
		}
		if($tglk=='1' | $tglk=='2' | $tglk=='3' | $tglk=='4' | $tglk=='5' | $tglk=='6' | $tglk=='7' | $tglk=='8' | $tglk=='9'){
			$data['kemarin']=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal`='$thn-$bln-0$tglk'");
		}else{
			$data['kemarin']=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal`='$thn-$bln-$tglk'");
		}
		$data['bulan']=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal` LIKE '%$blan%'");
		$data['bulan1']=count($data['bulan']);
		$data['tahunini']=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal` LIKE '%$thn%'");
		$data['tahunini1']=count($data['tahunini']);
		$data['pengunjung']= count($this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal`='$tanggal' GROUP BY `ip`"));
		$total = $this->crud->get(null,null,null,null,null,"SELECT COUNT(`hits`) as `totalpengunjung` FROM `konter`");
		$data['totalpengunjung']= $total[0]['totalpengunjung'];
		$hits = $this->crud->get(null,null,null,null,null,"SELECT SUM(`hits`) as `hitstoday` FROM `konter` WHERE `tanggal`='$tanggal' GROUP BY `tanggal`");
		$data['hits']= $hits[0]['hitstoday'];
		$totalhits = $this->crud->get(null,null,null,null,null,"SELECT SUM(`hits`) as `totalhits` FROM `konter`");
		$data['totalhits']= $totalhits[0]['totalhits'];
		$data['bataswaktu']= time() - 300;
		$data['pengunjungonline'] = count($this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `online` > '".$data['bataswaktu']."'"));
		$data['kemarin1'] = count($data['kemarin']);
		return $data;
	}

	public function kosong(){
		$data = $this->setting->get_jml();
		$data['site']=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Halaman Kosong';
		$data['modules']='web';
		$data['content']='v_web_kosong';
		$this->load->view('../../template/template_baru.php', $data);
	}

	public function tulisanutama(){
		$data['berita_'] = $this->setting->kategoriLabelBy('label','berita');
		$data['tulisanutama'] = null;
		$where_string = array(
			'limit'=>'1',
			'tipe'=>$data['berita_']['kategori'][0]['id_kategori']
		);
		$data['tulisanutama'] = $this->tulisan($where_string);
		return $data['tulisanutama'];
	}

	public function tulisanutamajson(){
		$data['tulisanutama'] = null;
		$data['tulisanutama'] = $this->tulisanutama();
		echo json_encode($data['tulisanutama']);
	}

	public function semuatulisanterbaru(){
		$data['tulisanterbaru'] = null;
		$where_string_ = array(
			'limit'=>'0,6'
		);
		$data['tulisanterbaru'] = $this->tulisan($where_string_);
		return $data['tulisanterbaru'];
	}

	public function semuatulisanterbarujson(){
		$data['tulisanterbaru'] = null;
		$data['tulisanterbaru'] = $this->semuatulisanterbaru();
		echo json_encode($data['tulisanterbaru']);
	}

	public function moretulisanterbaru(){
		$data['tulisanterbaru'] = null;
		$where_string_ = array(
			'limit'=>$this->uri->segment(3).',6'
		);
		$data['tulisanterbaru'] = $this->tulisan($where_string_);
		return $data['tulisanterbaru'];
	}

	public function moretulisanterbarujson(){
		$data['tulisanterbaru'] = null;
		$data['tulisanterbaru'] = $this->moretulisanterbaru();
		echo json_encode($data['tulisanterbaru']);
	}

	public function tulisanterbaru(){
		$data['berita_'] = $this->setting->kategoriLabelBy('label','berita');
		$data['tulisanterbaru'] = null;
		$where_string_ = array(
			'limit'=>'0,10',
			'tipe'=>$data['berita_']['kategori'][0]['id_kategori']
		);
		$data['tulisanterbaru'] = $this->tulisan($where_string_);
		return $data['tulisanterbaru'];
	}

	public function tulisanterbarujson(){
		$data['tulisanterbaru'] = null;
		$data['tulisanterbaru'] = $this->tulisanterbaru();
		echo json_encode($data['tulisanterbaru']);
	}

	public function tulisanterbaru2(){
		$data['berita_'] = $this->setting->kategoriLabelBy('label','berita');
		$data['tulisanterbaru'] = null;
		$where_string_ = array(
			'limit'=>'0,4',
			'tipe'=>$data['berita_']['kategori'][0]['id_kategori']
		);
		$data['tulisanterbaru'] = $this->tulisan($where_string_);
		return $data['tulisanterbaru'];
	}

	public function tulisanterbarujson2(){
		$data['tulisanterbaru'] = null;
		$data['tulisanterbaru'] = $this->tulisanterbaru2();
		echo json_encode($data['tulisanterbaru']);
	}

	public function tulisanlainnya(){
		$data['berita_'] = $this->setting->kategoriLabelBy('label','berita');
		$data['tulisanlainnya'] = null;
		$where_string__ = array(
			'limit'=>'6,11',
			'tipe'=>$data['berita_']['kategori'][0]['id_kategori']
		);
		$data['tulisanlainnya'] = $this->tulisan($where_string__);
		return $data['tulisanlainnya'];
	}

	public function tulisanlainnyajson(){
		$data['tulisanlainnya'] = null;
		$data['tulisanlainnya'] = $this->tulisanlainnya();
		echo json_encode($data['tulisanlainnya']);
	}

	public function agendaterbaru(){
		$data['event_'] = $this->setting->kategoriLabelBy('label','event');
		$data['agenda'] = null;
		$where_string__ = array(
			'limit'=>'0,10',
			'tipe'=>$data['event_']['kategori'][0]['id_kategori']
		);
		$data['agenda'] = $this->tulisan($where_string__);
		return $data['agenda'];
	}

	public function agendajson(){
		$data['agenda'] = null;
		$data['agenda'] = $this->agendaterbaru();
		echo json_encode($data['agenda']);
	}

	public function agendaterbaru2(){
		$data['event_'] = $this->setting->kategoriLabelBy('label','event');
		$data['agenda'] = null;
		$where_string__ = array(
			'limit'=>'0,4',
			'tipe'=>$data['event_']['kategori'][0]['id_kategori']
		);
		$data['agenda'] = $this->tulisan($where_string__);
		return $data['agenda'];
	}

	public function agendajson2(){
		$data['agenda'] = null;
		$data['agenda'] = $this->agendaterbaru2();
		echo json_encode($data['agenda']);
	}

	public function pengumumanterbaru(){
		$data['pengumuman_'] = $this->setting->kategoriLabelBy('label','pengumuman');
		$data['pengumuman'] = null;
		$where_string__ = array(
			'limit'=>'0,10',
			'tipe'=>$data['pengumuman_']['kategori'][0]['id_kategori']
		);
		$data['pengumuman'] = $this->tulisan($where_string__);
		return $data['pengumuman'];
	}

	public function pengumumanjson(){
		$data['pengumuman'] = null;
		$data['pengumuman'] = $this->pengumumanterbaru();
		echo json_encode($data['pengumuman']);
	}

	public function pengumumanterbaru2(){
		$data['pengumuman_'] = $this->setting->kategoriLabelBy('label','pengumuman');
		$data['pengumuman'] = null;
		$where_string__ = array(
			'limit'=>'0,4',
			'tipe'=>$data['pengumuman_']['kategori'][0]['id_kategori']
		);
		$data['pengumuman'] = $this->tulisan($where_string__);
		return $data['pengumuman'];
	}

	public function pengumumanjson2(){
		$data['pengumuman'] = null;
		$data['pengumuman'] = $this->pengumumanterbaru2();
		echo json_encode($data['pengumuman']);
	}

	public function gagasan(){
		$data['gagasan_'] = $this->setting->kategoriLabelBy('label','gagasan');
		$data['tulisanutama'] = null;
		$where_string = array(
			'limit'=>'1',
			'tipe'=>$data['gagasan_']['kategori'][0]['id_kategori']
		);
		$data['tulisanutama'] = $this->tulisan($where_string);
		return $data['tulisanutama'];
	}

	public function gagasanjson(){
		$data['tulisanutama'] = null;
		$data['tulisanutama'] = $this->gagasan();
		echo json_encode($data['tulisanutama']);
	}

	public function quote(){
		$data['quote_'] = $this->setting->kategoriLabelBy('label','quote');
		$data['tulisanutama'] = null;
		$where_string = array(
			'limit'=>'1',
			'tipe'=>$data['quote_']['kategori'][0]['id_kategori']
		);
		$data['tulisanutama'] = $this->tulisan($where_string);
		return $data['tulisanutama'];
	}

	public function quotejson(){
		$data['tulisanutama'] = null;
		$data['tulisanutama'] = $this->quote();
		echo json_encode($data['tulisanutama']);
	}

	public function tulisangambar(){
		$data['tulisangambar'] = null;
		$where_string = array(
			'gambar'=>''
		);
		$data['tulisangambar'] = $this->tulisan($where_string);
		return $data['tulisangambar'];
	}

	public function tulisangambarjson(){
		$data['tulisangambar'] = null;
		$data['tulisangambar'] = $this->tulisangambar();
		echo json_encode($data['tulisangambar']);
	}

	public function tulisan($where=array()){
		if(isset($where['limit'])){
			$limit = " LIMIT ".$where['limit'];
		}else{
			$limit = "";
		}
		if(isset($where['id_kat'])){
			$id_kat = $where['id_kat'];
		}else{
			$id_kat = null;
		}
		if(isset($where['cari'])){
			$cari = $where['cari'];
		}else{
			$cari = null;
		}
		if(isset($where['id'])){
			$id = $where['id'];
		}else{
			$id = null;
		}
		if(isset($where['tipe'])){
			$tipe = "AND `tipe`='".$where['tipe']."'";
			$tipe2 = "AND `tulisan`.`tipe`='".$where['tipe']."'";
		}else{
			$tipe = "AND `tipe`!='page'";
			$tipe2 = "AND `tulisan`.`tipe`!='page'";
		}
		if(isset($where['gambar'])){
			$gambar = "AND `gambar_andalan`!=''";
		}else{
			$gambar = "";
		}
		$tulisan_['tulisan']=null;
		$tulisan_['kat_tul']=null;
		$status_tulisan=null;
		$status_tulisan_=null;
		if($this->session->userdata('status_tulisan')=='sampah'){
			$status_tulisan = " WHERE `status_tulisan`='sampah'";
			$status_tulisan_ = " AND `status_tulisan`='sampah'";
		}else if($this->session->userdata('status_tulisan')=='terbit'){
			$status_tulisan = " WHERE `status_tulisan`='terbit'";
			$status_tulisan_ = " AND `status_tulisan`='terbit'";
		}else if($this->session->userdata('status_tulisan')=='konsep'){
			$status_tulisan = " WHERE `status_tulisan`='draft'";
			$status_tulisan_ = " AND `status_tulisan`='draft'";
		}else{
			$status_tulisan = " WHERE `status_tulisan`='terbit'";
			$status_tulisan_ = " AND `status_tulisan`='terbit'";
		}
		$table_name = 'tulisan';
		if($this->db->table_exists($table_name)){
			$tulisan_['error']=0;
			if($id_kat==null or $id_kat==0){
				if($id!=null){
					$string = "SELECT * FROM `tulisan` WHERE `id_tulisan`=".$id.$status_tulisan_." ".$tipe.$gambar." ORDER BY `tgl_tulisan` DESC".$limit;
				}else if($cari!=null or $cari!=''){
					$string = "SELECT * FROM `tulisan` WHERE ((`judul` LIKE '%".$cari."%') or (`tulisan` LIKE '%".$cari."%'))".$status_tulisan_." ".$tipe.$gambar." ORDER BY `tgl_tulisan` DESC".$limit;
				}else{
					$string = "SELECT * FROM `tulisan`".$status_tulisan." ".$tipe.$gambar." ORDER BY `tgl_tulisan` DESC".$limit;
				}
			}else{
				if($id!=null){
					$string = "SELECT * FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE `hub_kat_tul`.`id_kat`=".$id_kat." AND `id_tulisan`=".$id.$status_tulisan_." ".$tipe2.$gambar."".$limit;
				}else if($cari!=null or $cari!=''){
					$string = "SELECT * FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE `hub_kat_tul`.`id_kat`=".$id_kat." AND ((`judul` LIKE '%".$cari."%') or (`tulisan` LIKE '%".$cari."%'))".$status_tulisan_." ".$tipe2.$gambar."".$limit;
				}else{
					$string = "SELECT * FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE `hub_kat_tul`.`id_kat`=".$id_kat.$status_tulisan_." ".$tipe2.$gambar."".$limit;
				}
			}
			$tulisan_['tulisan'] = $this->crud->get(null,null,null,null,null,$string);
			if($tulisan_['tulisan']==null){
				$tulisan_['error']='Tulisan tidak ditemukan';
			}else{
				foreach($tulisan_['tulisan'] as $id){
					$table_name_='hub_kat_tul';
					$table_name__='kategori';
					if($this->db->table_exists($table_name_)&&$this->db->table_exists($table_name__)){
						$tulisan_['kat_tul'][$id['id_tulisan']]=null;
						$tulisan_['tul_lain'][$id['id_tulisan']]=null;
						$string_="SELECT * FROM `hub_kat_tul` JOIN `kategori` ON `hub_kat_tul`.`id_kat` = `kategori`.`id_kategori` WHERE `hub_kat_tul`.`id_tul`=".$id['id_tulisan'];
						$tulisan_['kat_tul'][$id['id_tulisan']]=$this->crud->get(null,null,null,null,null,$string_);
						if($tulisan_['kat_tul'][$id['id_tulisan']]!=null){
							$kategori = '';
							$jml_kat = count($tulisan_['kat_tul'][$id['id_tulisan']]);
							$i = 1;
							foreach($tulisan_['kat_tul'][$id['id_tulisan']] as $id_kat){
								if($i%$jml_kat==0){
									$kategori .= " (`hub_kat_tul`.`id_kat`=".$id_kat['id_kat'].")";
								}else{
									$kategori .= " (`hub_kat_tul`.`id_kat`=".$id_kat['id_kat'].") OR ";
								}
								$i++;
							}
							$string__ = "SELECT * FROM `tulisan` JOIN `hub_kat_tul` ON `hub_kat_tul`.`id_tul`=`tulisan`.`id_tulisan` WHERE ".$kategori." AND `tulisan`.`id_tulisan`!=".$id['id_tulisan']." ".$tipe2." AND `tulisan`.`status_tulisan`='terbit' ORDER BY `tulisan`.`tgl_tulisan` DESC LIMIT 5";
							$tulisan_['tul_lain'][$id['id_tulisan']]=$this->crud->get(null,null,null,null,null,$string__);
						}
					}
				}
			}
		}else{
			$tulisan_['error']='Tabel '.$table_name.' tidak ada!';
		}
		//$tulisan_['tab_action']=$this->counttulisan();
		return $tulisan_;
	}

	public function carouselimagejson(){
		$data['carousel'] = null;
		$data['carousel'] = $this->carouselimage();
		echo json_encode($data['carousel']);
	}

	public function carouselimage(){
		$data['carousel'] = null;
		$data['carousel'] = $this->carousel();
		return $data['carousel'];
	}

	public function carousel(){
		$carousel_['tulisan']=null;
		$table_name = 'kategori';
		if($this->db->table_exists($table_name)){
			$carousel_['error']=0;
			$string = "SELECT * FROM `kategori` WHERE `status_kategori`='open' AND `tipe_kategori`='slide' ORDER BY `id_kategori` DESC limit 1";
			$carousel_['tulisan'] = $this->crud->get(null,null,null,null,null,$string);
			if($carousel_['tulisan']==null){
				$carousel_['error']='Tulisan tidak ditemukan';
			}else{
				$table_name_ = 'hub_slide_img';
				if($this->db->table_exists($table_name_)){
					$string_ = "SELECT * FROM `hub_slide_img` WHERE `id_tul`='".$carousel_['tulisan'][0]['id_kategori']."'";
					//$carousel_['slide'] = $this->crud->get(null,null,null,null,null,$string_);
					$carousel_smt = $this->crud->get(null,null,null,null,null,$string_);
					$i=1;
					foreach($carousel_smt as $row){
						$id_kat=explode('|',$row['id_kat']);
						if($id_kat[0]!='img'){
							$post = null;
							$string__ = "SELECT * FROM `tulisan` WHERE `id_tulisan`='".$id_kat[1]."'";
							$post = $this->crud->get(null,null,null,null,null,$string__);
							if($post!=null){
								$carousel_['slide'][$i]['kat_order']=$row['kat_order'];
								$carousel_['slide'][$i]['judul']=substr($post[0]['judul'],0,25).'...';
								$carousel_['slide'][$i]['keterangan']=substr(strip_tags($post[0]['tulisan']),0,80).'...';
								if($post[0]['tipe']=='post'){
									$tipe='berita';
								}else{
									$tipe=$post[0]['tipe'];
								}
								$carousel_['slide'][$i]['link']=site_url('lihat/'.$tipe.'/'.$post[0]['id_tulisan']);
							}else{
								$carousel_['slide'][$i]['kat_order']=$row['kat_order'];
								$carousel_['slide'][$i]['judul']=ucfirst($id_kat[0]);
								$carousel_['slide'][$i]['keterangan']=ucfirst($id_kat[0]);
								$carousel_['slide'][$i]['link']=site_url('lihat/'.$id_kat[0]);
							}
						}else{
							$carousel_['slide'][$i]['kat_order']=$row['kat_order'];
							$carousel_['slide'][$i]['judul']='Gambar Andalan';
							$carousel_['slide'][$i]['keterangan']='Gambar Andalan';
							$carousel_['slide'][$i]['link']=site_url('lihat/album');
						}
						$i++;
					}
				}
			}
		}else{
			$carousel_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $carousel_;
	}

	public function tautanjson(){
		$data['tulisan'] = null;
		$data['tulisan'] = $this->tautan();
		echo json_encode($data['tulisan']);
	}

	public function tautan(){
		$data['tulisan'] = null;
		$data['tulisan'] = $this->tautan_();
		return $data['tulisan'];
	}

	public function tautan_(){
		$carousel_['tulisan']=null;
		$table_name = 'kategori';
		if($this->db->table_exists($table_name)){
			$carousel_['error']=0;
			$string = "SELECT * FROM `kategori` WHERE `status_kategori`='open' AND `tipe_kategori`='menu' AND `posisi`='link' ORDER BY `id_kategori` DESC";
			$carousel_['tulisan'] = $this->crud->get(null,null,null,null,null,$string);
			if($carousel_['tulisan']==null){
				$carousel_['error']='Tulisan tidak ditemukan';
			}
		}else{
			$carousel_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $carousel_;
	}

}

/* End of file web.php */
/* Location: ./application/controllers/web.php */