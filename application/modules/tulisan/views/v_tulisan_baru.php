<style>
	#pac-input {
		background-color: #fff;
		padding: 0 11px 0 13px;
		width: 400px;
		font-family: Roboto;
		font-size: 15px;
		font-weight: 300;
		text-overflow: ellipsis;
	}

	#pac-input:focus {
		margin-left: 0;
		padding-left: 13px;
		width: 400px;
	}
</style>

<?php
if (isset($kategori) && ($kategori != null or $kategori != '')) {
	$kategori_ = json_encode($kategori);
} else {
	$kategori_ = json_encode(null);
}

if (isset($tulisan['tipe'])) {
	$label = $tulisan['tipe'];
} else {
	$label = "";
}
?>
<link href="<?php echo base_url('assets/plugin/datetimepicker/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" type="text/css" />
<div class="row">
	<form action="<?php echo site_url('tulisan/addtulisan'); ?>" name="form_tambah_tulisan" id="form-tambah-tulisan" method="post" enctype="multipart/form-data">
		<div class="col-lg-9">
			<input name="id_tulisan" id="id-tulisan" value="<?php if (isset($tulisan['id_tulisan'])) echo $tulisan['id_tulisan']; ?>" type="hidden">
			<input name="gambar_andalan" id="gambar-andalan-t" value="<?php if (isset($tulisan['gambar_andalan'])) echo $tulisan['gambar_andalan']; ?>" type="hidden">
			<ul class="uk-tab" data-uk-tab="{connect:'#tabs_1'}">
				<!-- <li class="uk-active" aria-expanded="true"><a href="#">Indonesia</a></li>
	            <li class="" aria-expanded="false"><a href="#">England</a></li>
	            <li class="" aria-expanded="false"><a href="#">Uni Emirat Arab</a></li> -->
			</ul>
			<ul id="tabs_1" class="uk-switcher uk-margin">
				<li class="uk-active" aria-hidden="false">
					<div class="form-group">
						<input name="nama_tulisan_id" id="nama-halaman" value="<?php if (isset($tulisan['judul_id'])) echo $tulisan['judul_id']; ?>" type="text" class="input-lg form-control square-btn-adjust" placeholder="Masukan Judul di sini">
					</div>
					<div class="form-group">
						<textarea name="tulisan_id" class="form-control square-btn-adjust tinymce_basic"><?php if (isset($tulisan['tulisan_id'])) echo $tulisan['tulisan_id']; ?></textarea>
					</div>
				</li>
				<li class="" aria-hidden="true">
					<div class="form-group">
						<input name="nama_tulisan_eng" id="nama-halaman" value="<?php if (isset($tulisan['judul_eng'])) echo $tulisan['judul_eng']; ?>" type="text" class="input-lg form-control square-btn-adjust" placeholder="Enter the Title here">
					</div>
					<div class="form-group">
						<textarea name="tulisan_eng" class="form-control square-btn-adjust tinymce_basic"><?php if (isset($tulisan['tulisan_eng'])) echo $tulisan['tulisan_eng']; ?></textarea>
					</div>
				</li>
				<li class="" aria-hidden="true">
					<div class="form-group">
						<input name="nama_tulisan_ae" id="nama-halaman" value="<?php if (isset($tulisan['judul_ae'])) echo $tulisan['judul_ae']; ?>" type="text" class="input-lg form-control square-btn-adjust" placeholder="أدخل العنوان هنا">
					</div>
					<div class="form-group">
						<textarea name="tulisan_ae" class="form-control square-btn-adjust tinymce_basic"><?php if (isset($tulisan['tulisan_ae'])) echo $tulisan['tulisan_ae']; ?></textarea>
					</div>
				</li>
			</ul>
			<div id="peta-panel" style="display:none;">
				<input type="hidden" name="latitude" id="latitude" class="form-control" value="<?php if (isset($tulisan['latitude'])) {
																									echo $tulisan['latitude'];
																									$latitude = $tulisan['latitude'];
																								} else {
																									$latitude = '';
																								} ?>">
				<input type="hidden" name="longitude" id="longitude" class="form-control" value="<?php if (isset($tulisan['longitude'])) {
																										echo $tulisan['longitude'];
																										$longitude = $tulisan['longitude'];
																									} else {
																										$longitude = '';
																									} ?>">
				<div class="form-group">
					<button type="button" class="btn btn-default" onclick="lihat_peta()">Peta Lokasi</button>
				</div>
				<input id="pac-input" class="controls" type="text" placeholder="Pencarian Lokasi" style="color:#ccc;display:none;">
				<div id="map-canvas" style="min-height:400px;"></div>
			</div>
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
							<div class="form-group" style="padding:0 10px;">
								<div class="radio">
									<label>
										<input name="status_komentar_tulisan" type="radio" id="status-komentar-tulisan-1" value="open" <?php if (isset($tulisan['status_komentar']) && $tulisan['status_komentar'] == 'open') echo 'checked'; ?>>Diijinkan
									</label>
									<label>
										<input name="status_komentar_tulisan" type="radio" id="status-komentar-tulisan-2" value="close" <?php if (isset($tulisan['status_komentar']) && $tulisan['status_komentar'] == 'close') echo 'checked'; ?>>Tidak diijinkan
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
									<input value="<?php if (@$tulisan['tgl_tulisan']) {
														echo $tulisan['tgl_tulisan'];
													} else {
														echo date('Y-m-d h:i');
													} ?>" name="tgl_tulisan" type='text' class="form-control" data-uk-datepicker="{format:'YYYY-MM-DD h:mm'}" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar">
										</span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg_12" style="padding:0 10px;">
							<p><i class="fa fa-file"></i> Format</p>
							<div class="form-group" style="padding:0 10px;">
								<div id="list-label"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default square-btn-adjust">
				<div class="panel-heading">
					<b>Kategori</b>
				</div>
				<div class="panel-body">
					<div id="list-kategori" class="border list-kategori">
					</div>
					<br />
					<a onclick="view_form_kategori();" title="Tambah kategori baru" class="onclick"><i class="fa fa-plus"></i> Tambah kategori baru</a>
					<div id="form-tambah-kategori-field" style="display:none">
						<br />
						<div class="form-group">
							<input id="nama-kategori" name="nama_kategori" type="text" class="form-control square-btn-adjust required" title="Nama kategori">
						</div>
						<div class="form-group">
							<select id="induk-kategori" name="induk_kategori" class="form-control square-btn-adjust" title="Induk kategori">
								<option>- kategori induk -</option>
							</select>
						</div>
						<div class="form-group">
							<button id="btn-tambah-kategori" type="button" class="btn btn-sm btn-default square-btn-adjust" title="Tambah kategori baru">
								<li class="fa fa-plus"></li> Tambah kategori baru
							</button>
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
						<a id="btn-buat-gambar-andalan" title="Buat gambar utama" class="onclick" onclick="ambil_gambar_form_web('gambar-andalan-t,gambar-andalan-pilihan')"><i class="fa fa-picture-o"></i> Buat gambar utama</a> |
						<a id="btn-hapus-gambar-andalan" title="Hapus gambar utama" class="onclick" onclick="hapus_gambar_andalan()"><i class="fa fa-times"></i> hapus gambar</a>
					</p>
					<div id="gambar-andalan-pilihan">
						<?php if (isset($tulisan['gambar_andalan']) && $tulisan['gambar_andalan'] != '') {
							echo '<img src="' . base_url('assets/img/img_andalan') . '/' . $tulisan['gambar_andalan'] . '" width="100%">';
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
			<div id="ebook-panel" class="panel panel-default square-btn-adjust" style="display:none">
				<div class="panel-heading">
					<b>File Lampiran</b>
				</div>
				<div class="panel-body">
					<div id="file-lampiran-pengumuman">
						<p>file lampiran <a id="btn-file-lampiran" title="File Lampiran" class="label label-default onclick" onclick="tambah()">+ tambah</a></p>
						<?php if (isset($file) && $file != null) { ?>
							<ol class="list-file-lampiran">
								<?php
								foreach ($file as $row) {
									echo '<li id="hapus-row-tulisan-' . $row['id_file'] . '"><a target="blank" href="' . base_url('assets/file/' . $row['file']) . '">' . $row['file'] . '<a> <a class="label label-danger onclick" title="Hapus ' . $row['file'] . '" data-toggle="modal" data-target=".bs-hapus" onclick="set_del({id:\'' . $row['id_file'] . '\',nm:\'' . $row['file'] . '\',act:\'' . site_url() . 'tulisan/delfile\',element:\'hapus-row-tulisan-\'})">x hapus</a></li>';
								}
								?>
							</ol>
						<?php } ?>
						<div class="form-group">
							<div class="input-group">
								<input name="file_lampiran[1]" id="file-lampiran" type="file" class="form-control square-btn-adjust browse" title="Pilih file">
								<span class="input-group-addon"><i class="fa fa-times" id="del-0" onclick="del(this.id)"></i></span>
							</div>
						</div>
						<input type="hidden" value="2" id="loop">
						<div class="batas"></div>
					</div>
				</div>
			</div>
			<div id="event-panel" class="panel panel-default square-btn-adjust" style="display:none">
				<div class="panel-heading">
					<b>Pelaksanaan</b>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Tanggal dimulai</label>
						<div class='input-group date' id='datetimepicker2'>
							<input value="<?php if (@$halaman['tgl_mulai']) {
												echo $halaman['tgl_mulai'];
											} else {
												echo date('Y-m-d h:i');
											} ?>" name="tgl_mulai" type='text' class="form-control" data-uk-datepicker="{format:'YYYY-MM-DD h:mm'}" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar">
								</span>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label>Tanggal selesai</label>
						<div class='input-group date' id='datetimepicker3'>
							<input value="<?php if (@$halaman['tgl_selesai']) {
												echo $halaman['tgl_selesai'];
											} else {
												echo date('Y-m-d h:i');
											} ?>" name="tgl_selesai" type='text' class="form-control" data-uk-datepicker="{format:'YYYY-MM-DD h:mm'}" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar">
								</span>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input name="email2" id="email2" value="<?php if (isset($tulisan['email2'])) echo $tulisan['email2']; ?>" type="text" class="form-control square-btn-adjust" title="Masukan email/telp. di sini">
					</div>
					<div class="form-group">
						<label>Lokasi</label>
						<input name="lokasi" id="lokasi" value="<?php if (isset($tulisan['lokasi'])) echo $tulisan['lokasi']; ?>" type="text" class="form-control square-btn-adjust" title="Masukan lokasi di sini">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	function tambah() {
		loop = eval($('#loop').val());
		row = '<div class="form-group">' +
			'<div class="input-group">' +
			'<input name="file_lampiran[' + loop + ']" id="file-lampiran" type="file" class="form-control square-btn-adjust browse" title="Pilih file">' +
			'<span class="input-group-addon"><i class="fa fa-times" id="del-' + loop + '" onclick="del(this.id)"></i></span>' +
			'</div>' +
			'</div>';
		loop++;
		$('#loop').val(loop);
		$(row).insertBefore(".batas");
	}

	function del(data) {
		$('#' + data).parent().parent().remove();
	}
</script>
<script src="<?php echo base_url('assets/plugin/datetimepicker/bootstrap-datetimepicker.js'); ?>"></script>
<script type="text/javascript">
	var kategori_ = <?php echo $kategori_; ?>;
	$(window).load(function() {
		$.ajax({
			'url': '<?php echo site_url("kategori/getkategori"); ?>',
			'dataType': 'json',
			'success': function(data) {
				console.log(data);
				if (data.data != null) {
					isi_kat(data.data);
					set_kategori(kategori_);
				}
			}
		});
		$.ajax({
			'url': '<?php echo site_url("label/getlabel"); ?>',
			'dataType': 'json',
			'success': function(data) {
				console.log(data);
				if (data.data != null) {
					isi_label(data.data);
				}
			}
		});

		// $('#datetimepicker').datetimepicker({
		// });
		// $('#datetimepicker2').datetimepicker({
		// });
		// $('#datetimepicker3').datetimepicker({
		// });

		form_tambah_kategori_reset();
	});

	$(document).ready(function() {
		$('#btn-tambah-kategori').on('click', function() {
			$.ajax({
				'type': 'POST',
				'url': '<?php echo site_url("kategori/addkategori"); ?>',
				'dataType': 'json',
				'data': 'nama_kategori=' + $('#nama-kategori').val() + '&induk_kategori=' + $('#induk-kategori').val() + '&deskripsi_kategori',
				success: function(data) {
					console.log(data);
					if (data.data != null) {
						isi_kat(data.data);
						var notification = alertify.notify(data.psn, data.wrng, 5, function() {});
					} else {
						alertify.error('ERROR!');
					}
				}
			});
			form_tambah_kategori_reset();
		});
		/*$('#btn-tb-file-lampiran').on('click',function(){
		$('#form-file-lampiran').submit();
	});
	$('#form-file-lampiran').on('submit',(function(e) {
		var url='<?php echo site_url(); ?>';
		var base_url='<?php echo base_url(); ?>';
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            'type':'POST',
            'url': $(this).attr('action'),
            'data':formData,
            'cache':false,
            'contentType': false,
            'processData': false,
            'dataType': 'json',
            success:function(data){
                console.log(data);
                list='';
                $.each(data.name, function(i,n){
                	list+='<li id="hapus-row-tulisan-'+n['id']+'"><a target="blank" href="'+base_url+'assets/file/'+n['nm']+'">'+n['nm']+'</a> <a class="label label-danger onclick" title="Hapus '+n['nm']+'" data-toggle="modal" data-target=".bs-hapus" onclick="set_del({id:\''+n['id']+'\',nm:\''+n['nm']+'\',act:\''+url+'tulisan/delfile\',element:\'hapus-row-tulisan-\'})">x hapus</a></li>';
                });
                $('.list-file-lampiran').append(list);
                document.getElementById("form-file-lampiran").reset();
                $('#id-tulisan-file').val("<?php if (isset($tulisan['id_tulisan'])) echo $tulisan['id_tulisan']; ?>");
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
            }
        });
    }));*/
	});

	function set_kategori(kategori_) {
		console.log(kategori_);
		if (kategori_ != null) {
			$.each(kategori_, function(i, n) {
				$('#checkbox-kat-' + n['id_kategori']).prop('checked', true);
			});
		}
	}

	function form_tambah_kategori_reset() {
		$('#nama-kategori').val('');
		$('#induk-kategori').val('0');
	}

	function isi_kat(data) {
		if (data.error == 0) {
			select_kategori = '<select id="induk-kategori" name="induk_kategori" class="form-control square-btn-adjust auto-width" title="Induk kategori">'
			select_kategori += '<option value="0">- kategori induk -</option>';
			list_kategori = '';
			$.each(data.kategori, function(i, n) {
				select_kategori += '<option id="kat-' + n['id_kategori'] + '" value="' + n['id_kategori'] + '">' + n['kategori'] + '</option>';

				list_kategori += '<div class="checkbox" id="hapus-row-kategori-' + n['id_kategori'] + '">' +
					'<label>' +
					'<input id="checkbox-kat-' + n['id_kategori'] + '" name="checkbox_kat[' + n['id_kategori'] + ']" value="' + n['id_kategori'] + '" type="checkbox"> ' + n['kategori'] +
					'</label>' +
					'</div>';

				kat_id(n['id_kategori'], 0);
			});
			list_kategori += '';
			$("#list-kategori").html(list_kategori);
			select_kategori += '</select>';
			$("#induk-kategori").html(select_kategori);
		} else {
			alert(data.error);
		}
	}

	function kat_id(id, i) {
		$.ajax({
			'type': 'POST',
			'url': '<?php echo site_url("kategori/getkategori"); ?>',
			'dataType': 'json',
			'data': 'id_kat=' + id,
			success: function(data) {
				j = i + 1;
				select_kategori = '';
				list_kategori = '';
				$.each(data.data.kategori, function(i, n) {
					strip = '';
					strip2 = '';
					for (k = 0; k < j; k++) {
						strip += '-';
						strip2 += '&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					select_kategori += '<option id="kat-' + n['id_kategori'] + '" value="' + n['id_kategori'] + '">' + strip + n['kategori'] + '</option>';

					list_kategori += '<div class="checkbox" id="hapus-row-kategori-' + n['id_kategori'] + '">' +
						'<label>' +
						strip2 + '<input id="checkbox-kat-' + n['id_kategori'] + '" name="checkbox_kat[' + n['id_kategori'] + ']" value="' + n['id_kategori'] + '" type="checkbox"> ' + n['kategori'] +
						'</label>' +
						'</div>';

					kat_id(n['id_kategori'], j);
				});
				$(select_kategori).insertAfter("#kat-" + id);

				$(list_kategori).insertAfter("#hapus-row-kategori-" + id);
			}
		});
	}

	function isi_label(data) {
		format = [];
		if (data.error == 0) {
			list_label = '';
			$.each(data.label, function(i, n) {
				if (n['slug'] == 'event') {
					f_onclick = 'event';
				} else if (n['slug'] == 'ebook') {
					f_onclick = 'ebook';
				} else {
					f_onclick = 'berita';
				}
				list_label += '<div class="radio">' +
					'<label>' +
					'<input name="format_tulisan" type="radio" id="format-tulisan-' + n['id_kategori'] + '" value="' + n['id_kategori'] + '" onclick="f_' + f_onclick + '()">' +
					'<i class="berita-tanggal fa ' + n['icon'] + '"></i> ' + n['kategori'] +
					'</label>' +
					'</div>';
				format[n['id_kategori']] = f_onclick;
			});
			list_label += '';
			$("#list-label").html(list_label);
		} else {
			alert(data.error);
		}
		label_check(format);
	}

	function label_check(format) {
		label = '<?php echo $label; ?>';
		if (format[label] == 'event') {
			f_event();
		} else if (format[label] == 'ebook') {
			f_ebook();
		} else {
			f_berita();
		}
		if (label != '') {
			document.getElementById('format-tulisan-' + label).checked = true;
		}
	}

	function f_event() {
		$('#event-panel').show();
		$('#ebook-panel').hide();
		$('#peta-panel').show();
	}

	function f_ebook() {
		$('#ebook-panel').show();
		$('#event-panel').hide();
		$('#peta-panel').hide();
	}

	function f_berita() {
		$('#ebook-panel').hide();
		$('#event-panel').hide();
		$('#peta-panel').hide();
	}
</script>

<script>
	function view_form_kategori() {
		$('#form-tambah-kategori-field').toggle('slow');
	}

	function hapus_gambar_andalan() {
		$('#gambar-andalan-t').val('');
		$('#gambar-andalan-pilihan').html('<div id="gambar-andalan-pilihan"></div>');
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAZSvXKqg___ZZmdThOy4_Zx6uaRilBj8c" type="text/javascript"></script>
<script>
	function lihat_peta() {
		$('#pac-input').show();
		var latitude = "<?php echo $latitude; ?>";
		var longitude = "<?php echo $longitude; ?>";
		var lat = -3.998619;
		var lng = 122.508842;
		if (latitude != '') {
			lat = latitude;
		}
		if (longitude != '') {
			lng = longitude;
		}

		var myLatlng = new google.maps.LatLng(lat, lng);
		var myOptions = {
			zoom: 13,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
		}

		var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

		marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: 'Default Marker',
			draggable: true
		});

		updatelokasi(myLatlng);

		var input = (document.getElementById("pac-input"));
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		var searchBox = new google.maps.places.SearchBox((input));
		google.maps.event.addListener(searchBox, 'places_changed', function() {
			var places = searchBox.getPlaces();
			if (places.length == 0) {
				return;
			}
			markers = [];
			var bounds = new google.maps.LatLngBounds();
			for (var i = 0, place; place = places[i]; i++) {
				var marker = new google.maps.Marker({
					map: map,
					title: place.name,
					position: place.geometry.location,
					draggable: true
				});
				updatelokasi(place.geometry.location);
				markers.push(marker);
				bounds.extend(place.geometry.location);
			}
			map.fitBounds(bounds);
			zoomChangeBoundsListener = google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
				if (this.getZoom()) {
					this.setZoom(15);
				}
			});
		});

		// google.maps.event.addListener(map,'click',function(event) {
		// 	marker = new google.maps.Marker({
		// 	position: event.latLng,
		// 	map: map,
		// 	title: 'Click Generated Marker',
		// 	draggable:true
		// 	});
		// });

		/*google.maps.event.addListener(
			marker,
			'drag',
			function(event) {
		    document.getElementById('lat').value = this.position.lat();
		    document.getElementById('lng').value = this.position.lng();
		    //alert('drag');
		});*/

		google.maps.event.addListener(marker, 'dragend', function(event) {
			updatelokasi(event.latLng);
		});

		function updatelokasi(lokasi) {
			$("#latitude").val(lokasi.lat());
			$("#longitude").val(lokasi.lng());
		}
	}
</script>

<?php
include(APPPATH . 'modules/template/ambil_gambar.php');
?>