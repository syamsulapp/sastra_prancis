<?php
if (isset($kategori) && ($kategori != null or $kategori != '')) {
	$kategori_ = json_encode($kategori);
} else {
	$kategori_ = json_encode(null);
}
?>
<link href="<?php echo base_url('assets/plugin/datetimepicker/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" type="text/css" />
<div class="row">
	<form action="<?php echo site_url('halaman/addhalaman'); ?>" name="form_tambah_halaman" id="form-tambah-halaman" method="post">
		<div class="col-lg-9">
			<input name="gambar_andalan" id="gambar-andalan-h" value="<?php if (isset($halaman['gambar_andalan'])) echo $halaman['gambar_andalan']; ?>" type="hidden">
			<input name="id_halaman" id="id-halaman" value="<?php if (isset($halaman['id_tulisan'])) echo $halaman['id_tulisan']; ?>" type="hidden">
			<ul class="uk-tab" data-uk-tab="{connect:'#tabs_1'}">
				<!-- <li class="uk-active" aria-expanded="true"><a href="#">Indonesia</a></li>
            <li class="" aria-expanded="false"><a href="#">England</a></li>
            <li class="" aria-expanded="false"><a href="#">Uni Emirat Arab</a></li> -->
			</ul>
			<ul id="tabs_1" class="uk-switcher uk-margin">
				<li class="uk-active" aria-hidden="false">
					<div class="form-group">
						<input name="nama_halaman_id" id="nama-halaman" value="<?php if (isset($halaman['judul_id'])) echo $halaman['judul_id']; ?>" type="text" class="input-lg form-control square-btn-adjust" placeholder="Masukan Judul di sini">
					</div>
					<div class="form-group">
						<textarea name="halaman_id" class="form-control square-btn-adjust tinymce_basic"><?php if (isset($halaman['tulisan_id'])) echo $halaman['tulisan_id']; ?></textarea>
					</div>
				</li>
				<li class="" aria-hidden="true">
					<div class="form-group">
						<input name="nama_halaman_eng" id="nama-halaman" value="<?php if (isset($halaman['judul_eng'])) echo $halaman['judul_eng']; ?>" type="text" class="input-lg form-control square-btn-adjust" placeholder="Enter the Title here">
					</div>
					<div class="form-group">
						<textarea name="halaman_eng" class="form-control square-btn-adjust tinymce_basic"><?php if (isset($halaman['tulisan_eng'])) echo $halaman['tulisan_eng']; ?></textarea>
					</div>
				</li>
				<li class="" aria-hidden="true">
					<div class="form-group">
						<input name="nama_halaman_ae" id="nama-halaman" value="<?php if (isset($halaman['judul_ae'])) echo $halaman['judul_ae']; ?>" type="text" class="input-lg form-control square-btn-adjust" placeholder="أدخل العنوان هنا">
					</div>
					<div class="form-group">
						<textarea name="halaman_ae" class="form-control square-btn-adjust tinymce_basic"><?php if (isset($halaman['tulisan_ae'])) echo $halaman['tulisan_ae']; ?></textarea>
					</div>
				</li>
			</ul>
		</div>
		<div class="col-lg-3">
			<div class="panel panel-default square-btn-adjust">
				<div class="panel-heading">
					<b>Terbitkan</b>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg_12" style="padding:0 10px;">
							<p><i class="fa fa-comment"></i> Komentar</p>
							<div class="form-group">
								<div class="radio">
									<label>
										<input name="status_komentar_halaman" type="radio" id="status-komentar-halaman-1" value="open" <?php if (isset($halaman['status_komentar']) && $halaman['status_komentar'] == 'open') echo 'checked'; ?>>Diijinkan
									</label>
									<label>
										<input name="status_komentar_halaman" type="radio" id="status-komentar-halaman-2" value="close" <?php if (isset($halaman['status_komentar']) && $halaman['status_komentar'] == 'close') echo 'checked'; ?>>Tidak diijinkan
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg_12" style="padding:0 10px;">
							<p><i class="fa fa-calendar"></i> Terbitkan</p>
							<div class="form-group">
								<div class='input-group date' id='datetimepicker'>
									<input value="<?php if (@$halaman['tgl_tulisan']) {
														echo $halaman['tgl_tulisan'];
													} else {
														echo date('Y-m-d h:i:s');
													} ?>" name="tgl_halaman" type='text' class="form-control" data-uk-datepicker="{format:'YYYY-MM-DD h:i:s'}" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar">
										</span>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default square-btn-adjust">
				<div class="panel-heading">
					<b>Gambar Andalan</b>
				</div>
				<div class="panel-body">
					<p>
						<a id="btn-buat-gambar-andalan" title="Buat gambar utama" class="onclick" onclick="ambil_gambar_form_web('gambar-andalan-h,gambar-andalan-pilihan')"><i class="fa fa-picture-o"></i> Buat gambar utama</a> |
						<a id="btn-hapus-gambar-andalan" title="Hapus gambar utama" class="onclick" onclick="hapus_gambar_andalan()"><i class="fa fa-times"></i> hapus gambar</a>
					</p>
					<div id="gambar-andalan-pilihan">
						<?php if (isset($halaman['gambar_andalan']) && $halaman['gambar_andalan'] != '') {
							echo '<img src="' . base_url('assets/img/img_andalan') . '/' . $halaman['gambar_andalan'] . '" width="100%">';
						}
						?>
					</div>
				</div>
				<div class="panel-footer text-right">
					<button id="btn-terbitkan-halaman" type="submit" class="btn btn-primary square-btn-adjust" style="padding:5px 7px;">
						<li class="fa fa-check"></li> Simpan
					</button>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/datetimepicker/bootstrap-datetimepicker.js'); ?>"></script>
<script type="text/javascript">
	$(window).load(function() {
		$('#datetimepicker').datetimepicker({});
		form_tambah_kategori_reset();
	});

	function form_tambah_kategori_reset() {
		$('#nama-kategori').val('');
		$('#induk-kategori').val('0');
	}

	function hapus_gambar_andalan() {
		$('#gambar-andalan-h').val('');
		$('#gambar-andalan-pilihan').html('<div id="gambar-andalan-pilihan"></div>');
	}
</script>

<?php
$success = $this->session->flashdata('success');
if (!empty($success)) { ?><script>
		$(document).ready(function() {
			var notification = alertify.notify('<?php echo $success; ?>', 'success', 5, function() {});
		});
	</script><?php }
			$warning = $this->session->flashdata('warning');
			if (!empty($warning)) { ?><script>
		$(document).ready(function() {
			var notification = alertify.notify('<?php echo $warning; ?>', 'warning', 5, function() {});
		});
	</script><?php }
			$danger = $this->session->flashdata('danger');
			if (!empty($danger)) { ?><script>
		$(document).ready(function() {
			var notification = alertify.notify('<?php echo $danger; ?>', 'danger', 5, function() {});
		});
	</script><?php }
				?>

<?php
include(APPPATH . 'modules/template/ambil_gambar.php');
?>