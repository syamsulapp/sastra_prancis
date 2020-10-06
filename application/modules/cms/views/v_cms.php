<?php $two = $this->uri->segment(2); ?>

<div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-5 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable="" data-uk-grid-margin="">
	<a href="<?php echo site_url('tulisan'); ?>">
		<div class="md-card md-card-hover md-card-overlay">
			<div class="md-card-content">
				<div class="epc_chart" data-percent="76" data-bar-color="#03a9f4">
					<span class="epc_chart_icon"><i class="material-icons">&#xE8D2;</i></span>
				</div>
			</div>
			<div class="md-card-overlay-content">
				<div class="uk-clearfix md-card-overlay-header">
					<i class="md-icon material-icons md-card-overlay-toggler"></i>
					<h3>
						Tulisan (<?php if (@$jml_tulisan) echo $jml_tulisan; ?>)
					</h3>
				</div>
				Menu ini digunakan untuk mengelola Tulisan.
			</div>
		</div>
	</a>
	<?php if ($this->session->userdata('level') == 'administrator' || $this->session->userdata('level') == 'editor') { ?>
		<a href="<?php echo site_url('halaman'); ?>">
			<div class="md-card md-card-hover md-card-overlay">
				<div class="md-card-content">
					<div class="epc_chart" data-percent="76" data-bar-color="#03a9f4">
						<span class="epc_chart_icon"><i class="material-icons">&#xE24D;</i></span>
					</div>
				</div>
				<div class="md-card-overlay-content">
					<div class="uk-clearfix md-card-overlay-header">
						<i class="md-icon material-icons md-card-overlay-toggler"></i>
						<h3>
							Halaman (<?php if (@$jml_halaman) echo $jml_halaman; ?>)
						</h3>
					</div>
					Menu ini digunakan untuk mengelola Halaman.
				</div>
			</div>
		</a>
	<?php } ?>
	<a href="<?php echo site_url('album'); ?>">
		<div class="md-card md-card-hover md-card-overlay">
			<div class="md-card-content" id="canvas_1">
				<div class="epc_chart" data-percent="37" data-bar-color="#9c27b0">
					<span class="epc_chart_icon"><i class="material-icons">&#xE24D;</i></span>
				</div>
			</div>
			<div class="md-card-overlay-content">
				<div class="uk-clearfix md-card-overlay-header">
					<i class="md-icon material-icons md-card-overlay-toggler"></i>
					<h3>
						Galeri (<?php if (@$jml_album) echo $jml_album; ?>)
					</h3>
				</div>
				Menu ini digunakan untuk mengelola Album.
			</div>
		</div>
	</a>
	<a href="<?php echo site_url('komentar'); ?>">
		<div class="md-card md-card-hover md-card-overlay">
			<div class="md-card-content" id="canvas_1">
				<div class="epc_chart" data-percent="37" data-bar-color="#9c27b0">
					<span class="epc_chart_icon"><i class="material-icons">&#xE0B9;</i></span>
				</div>
			</div>
			<div class="md-card-overlay-content">
				<div class="uk-clearfix md-card-overlay-header">
					<i class="md-icon material-icons md-card-overlay-toggler"></i>
					<h3>
						Komentar (<?php if (@$jml_komentar) echo $jml_komentar; ?>)
					</h3>
				</div>
				Menu ini digunakan untuk mengelola Komentar.
			</div>
		</div>
	</a>
	<?php if ($this->session->userdata('level') == 'administrator') { ?>
		<a href="<?php echo site_url('pengguna'); ?>">
			<div class="md-card md-card-hover md-card-overlay">
				<div class="md-card-content">
					<div class="epc_chart" data-percent="37" data-bar-color="#607d8b">
						<span class="epc_chart_icon"><i class="material-icons">&#xE87C;</i></span>
					</div>
				</div>
				<div class="md-card-overlay-content">
					<div class="uk-clearfix md-card-overlay-header">
						<i class="md-icon material-icons md-card-overlay-toggler"></i>
						<h3>
							Pengguna (<?php if (@$jml_pengguna) echo $jml_pengguna; ?>)
						</h3>
					</div>
					Menu ini digunakan untuk mengelola Pengguna.
				</div>
			</div>
		</a>
	<?php } ?>
</div>

<br>
<br>


<div class="row">
	<div class="col-lg-9 col-md-10">
		<div class="panel panel-default square-btn-adjust">
			<div class="panel-body" style="min-height:300px">
				<div class="statistik-pengunjung"></div>
			</div>
		</div>
	</div>

	<!--aktifitas terbaru-->
	<div class="col-lg-3 col-md-2">
		<ul class="list-group">
			<li class="list-group-item">
				<h4>Aktifitas Terbaru</h4>
			</li>
			<li class="list-group-item">
				<span class="badge komentar-menunggu-menubar"><?php if (@$jml_komentar2) echo $jml_komentar2; ?></span>
				<i class="fa fa-comment-o"></i> Komentar menunggu
			</li>
			<li class="list-group-item">
				<span class="badge komentar-diterbitkan-menubar"><?php if (@$jml_komentar) echo $jml_komentar; ?></span>
				<i class="fa fa-comments-o"></i> Komentar yang diterbitkan
			</li>
			<li class="list-group-item">
				<span class="badge penayangan-hari-ini-menubar"><?php if (@$jml_statistik) echo $jml_statistik; ?></span>
				<i class="fa fa-group"></i> Penayangan hari ini
			</li>
			<li class="list-group-item">
				<span class="badge semua-tulisan-menubar"><?php if (@$jml_tulisan) echo $jml_tulisan; ?></span>
				<i class="fa fa-edit"></i> Tulisan
			</li>
		</ul>
	</div>
	<!--aktifitas terbaru end-->
</div>

<?php if (@$chart && $chart != null) {
	$datal = implode(',', $chart);
} ?>

<script src="<?php echo base_url('assets/plugin/highchart/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/highchart/exporting.js'); ?>"></script>
<script>
	$('.statistik-pengunjung').highcharts({
		chart: {
			type: 'line'
		},
		title: {
			text: 'Statistik Pengunjung Tahun ini'
		},
		subtitle: {
			text: '<?php echo site_url(); ?>'
		},
		xAxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Jumlah Pengunjung'
			}
		},
		tooltip: {
			valueSuffix: ' org'
		},
		series: [{
			name: 'Jumlah Pengunjung',
			data: [<?php echo $datal; ?>]
		}],
		credits: {
			enabled: false
		}
	});
</script>