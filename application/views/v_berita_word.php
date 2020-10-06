<?php if (isset($header) && $header == 'aktif') {
	$name_file = 'word';
	if (isset($site['web']['blogname'])) {
		$name_file = $site['web']['blogname'];
	}
	if (isset($site['page'])) {
		$name_file .= ' ' . $site['page'];
	}
	header("Content-Type: application/vnd.ms-word");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=" . preg_replace("/[\/\!@#$%^&*()=+{}:,.;]/", "_", str_replace(' ', '_', $name_file)) . ".doc");
} ?>

<?php
$bln = array(
	'01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
);

$hari = array(
	'1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu', '7' => 'Minggu'
);
?>

<?php
if (isset($detail['tulisan'][0]) && $detail['tulisan'][0] != null && $detail['error'] == 0) {
	$row = $detail['tulisan'][0];
	$tgl = explode(' ', $row['tgl_tulisan']);
	$tgl2 = explode('-', $tgl[0]);
	$kom = $detail['kom_tul'][$row['id_tulisan']][0];
	$kom2 = $detail['kom_tul'][$row['id_tulisan']];
	$jml_kom = $detail['jml_kom_tul'][$row['id_tulisan']];
	$kat = '';
	if (isset($detail['kat_tul'][$row['id_tulisan']]) && $detail['kat_tul'][$row['id_tulisan']] != null) {
		$j = 0;
		foreach ($detail['kat_tul'][$row['id_tulisan']] as $row2) {
			if ($j == 0) {
				$kat .= '<a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
			} else {
				$kat .= ', <a href="' . site_url('home/kategori/' . $row2['id_kategori']) . '/' . $row2['slug'] . '">' . ucfirst($row2['kategori']) . '</a>';
			}
			$j++;
		}
	} else {
		$kat = 'Tidak berkategori';
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link href="<?php echo base_url('assets/bootstrap-3.3.2-dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php //echo base_url('assets/lihat3/css/lihat3.css');
				?>" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
</head>

<body style="background-color:#FFF;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php if (isset($detail['tulisan'][0]) && $detail['tulisan'][0] != null && $detail['error'] == 0) { ?>
					<div class="berita-detail">
						<h1 class="title-berita-detail"><?php echo ucfirst($row['judul']); ?></h1>
						<span class="tgl-berita-terpopuler">Ditulis pada <i class="fa fa-clock-o"></i> <?php echo $hari[date('N', mktime(0, 0, 0, $tgl2[1], $tgl2[2], $tgl2[0]))]; ?>, <?php echo $tgl2[2] . ' ' . $bln[$tgl2[1]] . ' ' . $tgl2[0]; ?> <i class="fa fa-user"></i> oleh: <?php echo $row['nm_dp']; ?></span>
						<div class="berita-content">
							<?php if ($row['gambar_andalan'] != '') { ?>
								<div class="berita-img-2">
									<img src="<?php echo base_url('assets/img/img_andalan') . '/' . $row['gambar_andalan']; ?>">
								</div>
							<?php } ?>
							<?php echo $row['tulisan']; ?>
						</div>
						<div class="berita-meta">
							<?php if ($row['status_komentar'] == 'open') {
								if (isset($jml_kom)) { ?>
									<span> Komentar: <a href="#"> <?php echo $jml_kom; ?> </a> </span>
								<?php } ?>
							<?php } ?>
							<?php
							$link_pdf = '';
							for ($i = 2; $i <= 3; $i++) {
								if ($this->uri->segment($i) != '') {
									$link_pdf .= $this->uri->segment($i) . '/';
								}
							}
							?>
							<span> Bagikan: <i class="fa fa-facebook-square"></i> <i class="fa fa-google-plus-square"></i> </span>
							<span> Cetak:
								<a href="<?php echo site_url('home/pdf/' . $link_pdf); ?>"><i class="fa fa-file-o"></i></a>
								<a href="<?php echo site_url('home/word/' . $link_pdf); ?>"><i class="fa fa-file-text-o"></i></a>
							</span>
							<span> Kategori: <?php echo $kat; ?></span>
						</div>

					</div>
				<?php } ?>

			</div>
		</div>
	</div>
</body>

</html>