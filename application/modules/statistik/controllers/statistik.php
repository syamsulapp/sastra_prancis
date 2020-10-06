<?php
require_once(dirname(__FILE__)."/../../../controllers/setting.php");
class Statistik extends MX_Controller{

	public function __construct(){
		parent::__construct();
		$this->setting = new Setting();
		$this->load->library('crud');
	}

	function index(){
		$data 			= $this->setting->get_jml();
		$data['site']	=$this->setting->web();
		$data['kom'] = $this->setting->komentar_menunggu();
		$data['tes'] = $this->setting->testimoni_menunggu();
		$data['sts'] = $this->setting->status_website();
		$data['site']['page']='Halaman Statistik';
		$data['modules']	='statistik';
		$data['content']	='v_statistik';
		$data['chart'] 		= $this->gettahunini();
		$this->load->view('../../template/template', $data);
		//$this->load->view('v_statistik', $data);
	}

	function pengguna(){
		$data = null;
		$string = "SELECT `tgl_statistik` as `tgl`, count(`id_statistik`) as `jml` FROM `statistik` GROUP BY `tgl_statistik`";
		$statistik = $this->crud->get(null,null,null,null,null,$string);
		$i=0;
		foreach($statistik as $row){
			$data[$i][1]=$row['jml'];
			$data[$i][0]=$row['tgl'];
			$i++;
		}
		echo json_encode($data);
	}

	function getstatistikhariini(){
		/*$data['data'] = null;
		$string = "SELECT `tgl_statistik` as `tgl`, count(`id_statistik`) as `jml` FROM `statistik` WHERE `tgl_statistik`='".strtotime(date('Y-m-d 00:00:00'))."'";
		$statistik = $this->crud->get(null,null,null,null,null,$string);
		$string_ = "SELECT `tgl_statistik` as `tgl`, count(`id_statistik`) as `jml` FROM `statistik`";
		$statistik_ = $this->crud->get(null,null,null,null,null,$string_);
		if(isset($statistik[0]['jml'])){
			$data['data']['hariini'] = $statistik[0]['jml'];
		}else{
			$data['data']['hariini'] = 0;
		}

		if(isset($statistik_[0]['jml'])){
			$data['data']['semua'] = $statistik_[0]['jml'];
		}else{
			$data['data']['semua'] = 0;
		}*/

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
			$tglk2=$thn.$bln.'0'.$tglk;
			//$data['kemarin']=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal`='$thn-$bln-0$tglk'");
		}else{
			$tglk2=$thn.$bln.$tglk;
			//$data['kemarin']=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal`='$thn-$bln-$tglk'");
		}
		$data['kemarin']=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE `tanggal`='$tglk2'");
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
		//$data['kemarin1'] = count($data['kemarin']);
		
		echo json_encode($data);
	}

	function gettahunini(){
		$tahun = date('Y');
		for($i=0;$i<12;$i++){
			if($i<10){
				$j='0'.($i+1);
			}else{
				$j=$i+1;
			}
			$count=$this->crud->get(null,null,null,null,null,"SELECT * FROM `konter` WHERE Substring(`tanggal`,1,6)='".$tahun.$j."'");
			if($count!=null){
				$count=count($count);
			}else{
				$count=0;
			}
			$data[$i]= $count;
		}
		//echo json_encode($data);
		return $data;
	}

	public function gettulisanstatistik(){
		$data['data'] = null;
		$data['data'] = $this->tulisanstatistik();
		echo json_encode($data);
	}

	public function tulisanstatistik(){
		$table_name = 'tulisan';
		if($this->db->table_exists($table_name)){
			$tulisan_['error']=0;
			$string = "SELECT * FROM `tulisan` JOIN `kategori` ON `tulisan`.`tipe`=`kategori`.`id_kategori` WHERE `kategori`.`tipe_kategori`='label' ORDER BY `view` DESC LIMIT 5";
			$tulisan_['tulisan'] = $this->crud->get(null,null,null,null,null,$string);
			if($tulisan_['tulisan']==null){
				$tulisan_['error']='Tulisan tidak ditemukan';
			}else{
				foreach($tulisan_['tulisan'] as $id){
					$table_name_='hub_kat_tul';
					$table_name__='kategori';
					if($this->db->table_exists($table_name_)&&$this->db->table_exists($table_name__)){
						$string_="SELECT * FROM `hub_kat_tul` JOIN `kategori` ON `hub_kat_tul`.`id_kat` = `kategori`.`id_kategori` WHERE `hub_kat_tul`.`id_tul`=".$id['id_tulisan']." AND `kategori`.`tipe_kategori`='category'";
						$tulisan_['kat_tul'][$id['id_tulisan']]=$this->crud->get(null,null,null,null,null,$string_);
					}

					$table_name___='komentar';
					if($this->db->table_exists($table_name___)){
						$tulisan_['kom_tul'][$id['id_tulisan']]=null;
						$string__="SELECT * FROM `komentar` WHERE `id_tul`=".$id['id_tulisan'];
						$tulisan_['kom_tul'][$id['id_tulisan']]=$this->crud->get(null,null,null,null,null,$string__);
						if($tulisan_['kom_tul'][$id['id_tulisan']]!=null){
							$tulisan_['jml_kom_tul'][$id['id_tulisan']]=count($tulisan_['kom_tul'][$id['id_tulisan']]);
						}else{
							$tulisan_['jml_kom_tul'][$id['id_tulisan']]=0;
						}
					}

					$foto_ = null;
					$string_ = "SELECT * FROM `pengguna` WHERE `id_pengguna`=".$id['penulis'];
					if($this->db->table_exists('pengguna')){
						$foto_ = $this->crud->get(null,null,null,null,null,$string_);
						if($foto_!=null){
							$tulisan_['foto'][$id['id_tulisan']]=$foto_[0]['foto'];
						}else{
							$tulisan_['foto'][$id['id_tulisan']]='';
						}
					}
				}
			}
		}else{
			$tulisan_['error']='Tabel '.$table_name.' tidak ada!';
		}
		return $tulisan_;
	}

}

/* End of file statistik.php */
/* Location: ./application/controllers/statistik.php */