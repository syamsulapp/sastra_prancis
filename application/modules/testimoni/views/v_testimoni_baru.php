<form action="<?php echo site_url('testimoni/addtestimoni');?>" name="form_tambah_testimoni" id="form-tambah-testimoni" method="post">
<div class="row">
	<!--form testimoni-->
	<div class="col-lg-9">
		<input name="id_testimoni" id="id-testimoni" value="<?php if(isset($testimoni['id_testimoni']))echo $testimoni['id_testimoni'];?>" type="hidden">
		<input name="sunting_testimoni" id="sunting-testimoni" value="<?php if(isset($sunting))echo $sunting;?>" type="hidden">
		<div class="form-group">
			<div class="row">
				<div class="col-lg-3">
					Nama
				</div>
				<div class="col-lg-9">
					<input name="username" id="username" value="<?php if(isset($testimoni['username']))echo $testimoni['username'];?>" type="text" class="form-control  square-btn-adjust required" title="Masukan nama testimoni di sini">
					<input name="username2" id="username2" value="<?php if(isset($testimoni['username']))echo $testimoni['username'];?>" type="text" class="form-control  square-btn-adjust" title="Masukan nama testimoni di sini" style="display:none" disabled>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-lg-3">
					Surel / email
				</div>
				<div class="col-lg-9">
					<input name="email" id="email" value="<?php if(isset($testimoni['email']))echo $testimoni['email'];?>" type="email" class="form-control  square-btn-adjust required" title="Masukan email testimoni di sini">
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-lg-3">
					Instansi / Kantor
				</div>
				<div class="col-lg-9">
					<input name="instansi" id="instansi" value="<?php if(isset($testimoni['instansi']))echo $testimoni['instansi'];?>" type="text" class="form-control  square-btn-adjust required" title="Masukan Instansi / Kantor di sini">
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-lg-3">
					Testimoni
				</div>
				<div class="col-lg-9">
					<textarea name="testimoni" id="testimoni" cols="10" rows="5" class="form-control  square-btn-adjust" title="Masukan testimoni di sini"><?php if(isset($testimoni['testimoni']))echo $testimoni['testimoni'];?></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-3">
		<div class="row">
			<div class="col-lg-12 text-center" style="height:300px">
				<div id="foto-testimoni">
					<img src="<?php if(isset($testimoni['foto'])&&$testimoni['foto']!='')echo$testimoni['foto'];?>" style="max-width:100%;max-height:100%">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3">
				Url foto
			</div>
			<div class="col-lg-9">
				<div class="input-group">
					<input name="foto" id="foto" onclick="ambil_gambar_form_web('foto,foto-testimoni')" value="<?php if(isset($testimoni['foto'])&&$testimoni['foto']!='')echo$testimoni['foto'];?>" type="text" class="form-control  square-btn-adjust" title="Url foto testimoni di sini">
					<span class="input-group-addon"><i class="fa fa-picture-o" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('foto,foto-testimoni')"></i></span>
				</div>
			</div>
		</div>
	</div>
	<!--form testimoni end-->
</div>
<hr />
<div class="row">
	<div class="col-lg-12">
		<button id="btn-tambah-testimoni" type="submit" class="md-btn md-btn-primary btn-sm square-btn-adjust" title="Tambah testimoni baru"><li class="fa fa-save"></li> Tambah testimoni Baru</button>
	</div>
</div>
</form>

<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js');?>"></script>
<script type="text/javascript">
$(window).load(function(){
	var sunting = $('#sunting-testimoni').val();
	if(sunting=='true'){
		$('#username').hide();
		$('#username2').show();
	}
});

$(document).ready(function(){
	$("#form-tambah-testimoni").validate({
	});
});
</script>

<?php
$success = $this->session->flashdata('success'); if (!empty($success)){?><script>$(document).ready(function(){ var notification = alertify.notify('<?php echo$success;?>', 'success', 5, function(){});});</script><?php }
$warning = $this->session->flashdata('warning'); if (!empty($warning)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$warning;?>', 'warning', 5, function(){});});</script><?php }
$danger = $this->session->flashdata('danger'); if (!empty($danger)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$danger;?>', 'danger', 5, function(){});});</script><?php }
?>

<?php
  include(APPPATH.'modules/template/ambil_gambar.php');
?>