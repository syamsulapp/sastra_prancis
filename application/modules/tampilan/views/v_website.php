<style>
	.row{
		margin-bottom: 10px;
	}
</style>
<form action="<?php echo site_url('tampilan/updatewebsite');?>" name="form_simpan_web" id="form-simpan-web" method="post">

<div class="row">
	<div class="col-lg-6 col-sm-6">

<div class="row">
	<div class="col-lg-4">
		<b>Logo Website</b>
	</div>
	<div class="col-lg-8">
		<div class="row">
			<div class="col-lg-12">
				<div class="img-judul-jargon">
					<div id="gambar-pilihan-logo" class="header-img-src">
						<?php if(@$site['web']['blogimgheader']){ ?><img src="<?php echo base_url('assets/img/img_andalan').'/'.$site['web']['blogimgheader'];?>" style="max-width:100px;max-height:100%"><?php }?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				Ukuran gambar yang disarankan <b>300 x 300</b> pixel.
				<br />
				<br />
				<div class="input-group">
					<input value="<?php if(@$site['web']['blogimgheader'])echo$site['web']['blogimgheader'];?>" id="gambar-logo" name="blogimgheader" type="text" class="form-control square-btn-adjust auto-width required" title="Logo" onclick="ambil_gambar_form_web('gambar-logo,gambar-pilihan-logo')">
					<span class="input-group-addon"><i class="fa fa-picture-o" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('gambar-logo,gambar-pilihan-logo')"></i></span>
				</div>
				<br />
				Ukuran maksimal unggahan berkas: <b>10 MB</b>. <gedank id="hapus-gambar-pilihan"></gedank>
			</div>
		</div>
	</div>
</div>
<hr />

<div class="row">
	<div class="col-lg-4">
		<b>Header Website</b>
	</div>
	<div class="col-lg-8">
		<div class="row">
			<div class="col-lg-12">
				<div class="img-judul-jargon">
					<div id="gambar-pilihan-header" class="header-img-src">
						<?php if(@$site['web']['blogimgheader2']){ ?><img src="<?php echo base_url('assets/img/img_andalan').'/'.$site['web']['blogimgheader2'];?>" style="background:#eee; max-width:100%;max-height:100%"><?php }?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<br />
				Ukuran gambar yang disarankan <b>800 x 160</b> pixel.
				<br />
				<br />
				<div class="input-group">
					<input value="<?php if(@$site['web']['blogimgheader2'])echo$site['web']['blogimgheader2'];?>" id="gambar-header" name="blogimgheader2" type="text" class="form-control square-btn-adjust auto-width required" title="Gambar Header" onclick="ambil_gambar_form_web('gambar-header,gambar-pilihan-header')">
					<span class="input-group-addon"><i class="fa fa-picture-o" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('gambar-header,gambar-pilihan-header')"></i></span>
				</div>
				<br />
				Ukuran maksimal unggahan berkas: <b>10 MB</b>. <gedank id="hapus-gambar-pilihan"></gedank>
			</div>
		</div>
	</div>
</div>
<hr />

<div class="row">
	<div class="col-lg-4">
		<b>Judul dan Deskripsi Web</b>
	</div>
	<div class="col-lg-8">
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		Judul Web
	</div>
	<div class="col-lg-8">
		<input value="<?php if(@$site['web']['blogname'])echo$site['web']['blogname'];?>" id="blogname" name="blogname" type="text" class="form-control square-btn-adjust required" title="Judul web">
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		Deskripsi Web
	</div>
	<div class="col-lg-8">
		<textarea name="blogdescription" class="form-control square-btn-adjust required" title="Deskripsi web" rows="5"><?php if(@$site['web']['blogdescription'])echo$site['web']['blogdescription'];?></textarea>
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		Keyword Web
	</div>
	<div class="col-lg-8">
		<textarea name="blogkeyword" class="form-control square-btn-adjust required" title="Keyword web" rows="5"><?php if(@$site['web']['blogkeyword'])echo$site['web']['blogkeyword'];?></textarea>
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		Alamat Instansi
	</div>
	<div class="col-lg-8">
		<textarea name="blogalamat" class="form-control square-btn-adjust required tinymce_komentar" title="Alamat Instansi" rows="5"><?php if(@$site['web']['blogalamat'])echo$site['web']['blogalamat'];?></textarea>
	</div>
</div>
<hr />

<div class="row">
	<div class="col-lg-4">
		<b>Undercontruction Website</b>
	</div>
	<div class="col-lg-8">
		<div class="row">
			<div class="col-lg-12">
				<div class="img-judul-jargon">
					<div id="gambar-pilihan-underconstruction" class="header-img-src">
						<?php if(@$site['web']['underconstruction']){ ?><img src="<?php echo base_url('assets/img/img_andalan').'/'.$site['web']['underconstruction'];?>" style="background:#eee; max-width:100%;max-height:100%"><?php }?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				Ukuran gambar yang disarankan <b>1366 x 768</b> pixel.
				<br />
				<br />
				<div class="input-group">
					<input value="<?php if(@$site['web']['underconstruction'])echo$site['web']['underconstruction'];?>" id="gambar-underconstruction" name="underconstruction" type="text" class="form-control square-btn-adjust auto-width required" title="Logo" onclick="ambil_gambar_form_web('gambar-underconstruction,gambar-pilihan-underconstruction')">
					<span class="input-group-addon"><i class="fa fa-picture-o" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('gambar-underconstruction,gambar-pilihan-underconstruction')"></i></span>
				</div>
				<br />
				Ukuran maksimal unggahan berkas: <b>10 MB</b>. <gedank id="hapus-gambar-pilihan"></gedank>
			</div>
		</div>
	</div>
</div>
<hr />

	</div>
	<div class="col-lg-6 col-sm-6">

<div class="row">
	<div class="col-lg-4">
		<b>Pejabat Instansi</b>
	</div>
	<div class="col-lg-8">
	</div>
</div>

<hr />

<div class="row">
	<div class="col-lg-6 col-sm-6 col-xs-6">
		Nama Kepala
	</div>
	<div class="col-lg-6 col-sm-6 col-xs-6">
		<input value="<?php if(@$site['web']['blogpemimpin'])echo$site['web']['blogpemimpin'];?>" id="blogpemimpin" name="blogpemimpin" type="text" class="form-control square-btn-adjust required" title="Nama Kepala">
	</div>
</div>
<div class="row">
	<div class="col-lg-6 col-sm-6 col-xs-6">
		Nama Wakil Kepala
	</div>
	<div class="col-lg-6 col-sm-6 col-xs-6">
		<input value="<?php if(@$site['web']['blogwpemimpin'])echo$site['web']['blogwpemimpin'];?>" id="blogwpemimpin" name="blogwpemimpin" type="text" class="form-control square-btn-adjust required" title="Nama Wakil Kepala">
	</div>
</div>
<hr />

<div class="row">
	<div class="col-lg-6 col-sm-6 col-xs-6">
		<label>Foto Kepala (140x190px)</label>
		<div id="foto-gubernur" class="text-center" style="height:180px;overflow:hidden;">
			<?php if(@$site['web']['blogimgpemimpin']){ ?><img src="<?php echo base_url('assets/img/img_andalan').'/'.$site['web']['blogimgpemimpin'];?>" style="max-width:50%;max-height:100%"><?php }?>
		</div>
		<div class="input-group">
			<input value="<?php if(@$site['web']['blogimgpemimpin'])echo$site['web']['blogimgpemimpin'];?>" id="blogimgpemimpin" name="blogimgpemimpin" type="text" class="form-control square-btn-adjust required" title="Foto Kepala" onclick="ambil_gambar_form_web('blogimgpemimpin,foto-gubernur')">
			<span class="input-group-addon"><i class="fa fa-picture-o" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('blogimgpemimpin,foto-gubernur')"></i></span>
		</div>
	</div>
	<div class="col-lg-6 col-sm-6 col-xs-6">
		<label>Foto Wakil Kepala (140x190px)</label>
		<div id="foto-w-gubernur" class="text-center" style="height:180px;overflow:hidden;">
			<?php if(@$site['web']['blogimgwpemimpin']){ ?><img src="<?php echo base_url('assets/img/img_andalan').'/'.$site['web']['blogimgwpemimpin'];?>" style="max-width:50%;max-height:100%"><?php }?>
		</div>
		<div class="input-group">
			<input value="<?php if(@$site['web']['blogimgwpemimpin'])echo$site['web']['blogimgwpemimpin'];?>" id="blogimgwpemimpin" name="blogimgwpemimpin" type="text" class="form-control square-btn-adjust required" title="Foto Wakil Kepala" onclick="ambil_gambar_form_web('blogimgwpemimpin,foto-w-gubernur')">
			<span class="input-group-addon"><i class="fa fa-picture-o" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('blogimgwpemimpin,foto-w-gubernur')"></i></span>
		</div>
	</div>
</div>
<hr />

<div class="row">
	<div class="col-lg-4">
		<b>Media Sosial</b>
	</div>
	<div class="col-lg-8">
	</div>
</div>

<hr />

<div class="row">
	<div class="col-lg-4 col-sm-4 col-xs-4">
		Facebook
	</div>
	<div class="col-lg-8 col-sm-8 col-xs-8">
		<input value="<?php if(@$site['web']['blogfb'])echo$site['web']['blogfb'];?>" id="blogfb" name="blogfb" type="text" class="form-control square-btn-adjust required" title="Facebook">
	</div>
</div>
<div class="row">
	<div class="col-lg-4 col-sm-4 col-xs-4">
		Twitter
	</div>
	<div class="col-lg-8 col-sm-8 col-xs-8">
		<input value="<?php if(@$site['web']['blogtw'])echo$site['web']['blogtw'];?>" id="blogtw" name="blogtw" type="text" class="form-control square-btn-adjust required" title="Twitter">
	</div>
</div>
<div class="row">
	<div class="col-lg-4 col-sm-4 col-xs-4">
		Google Plus
	</div>
	<div class="col-lg-8 col-sm-8 col-xs-8">
		<input value="<?php if(@$site['web']['bloggp'])echo$site['web']['bloggp'];?>" id="bloggp" name="bloggp" type="text" class="form-control square-btn-adjust required" title="Google Plus">
	</div>
</div>
<hr />

<div class="row">
	<div class="col-lg-4">
		<b>Background Website</b>
	</div>
	<div class="col-lg-8">
		<div class="form-group">
			<div class="radio">
				<label>
					<input name="background_s" type="radio" id="background-s-1" value="yes" <?php if(@$site['web']['background_s']&&$site['web']['background_s']=='yes')echo'checked';?>>Ya
				</label>
				<label>
					<input name="background_s" type="radio" id="background-s-2" value="no" <?php if(@$site['web']['background_s']&&$site['web']['background_s']=='no')echo'checked';?>>Tidak
				</label>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		Background
	</div>
	<div class="col-lg-8">
		<div class="row">
			<div class="col-lg-12">
				<div class="img-judul-jargon">
					<div id="gambar-pilihan-background" class="header-img-src">
						<?php if(@$site['web']['background']){ ?><img src="<?php echo base_url('assets/img/img_andalan').'/'.$site['web']['background'];?>" style="background:#eee; max-width:100%;max-height:100%"><?php }?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				Ukuran gambar yang disarankan <b>1366 x 768</b> pixel.
				<br />
				<br />
				<div class="input-group">
					<input value="<?php if(@$site['web']['background'])echo$site['web']['background'];?>" id="gambar-background" name="background" type="text" class="form-control square-btn-adjust auto-width required" title="Logo" onclick="ambil_gambar_form_web('gambar-background,gambar-pilihan-background')">
					<span class="input-group-addon"><i class="fa fa-picture-o" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('gambar-background,gambar-pilihan-background')"></i></span>
				</div>
				<br />
				Ukuran maksimal unggahan berkas: <b>10 MB</b>. <gedank id="hapus-gambar-pilihan"></gedank>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		Repeat
	</div>
	<div class="col-lg-8">
		<div class="form-group">
			<div class="radio">
				<label>
					<input name="repeat" type="radio" id="repeat-1" value="repeat" <?php if(@$site['web']['repeat']&&$site['web']['repeat']=='repeat')echo'checked';?>>repeat
				</label>
				<label>
					<input name="repeat" type="radio" id="repeat-2" value="no-repeat" <?php if(@$site['web']['repeat']&&$site['web']['repeat']=='no-repeat')echo'checked';?>>no-repeat
				</label>
				<label>
					<input name="repeat" type="radio" id="repeat-2" value="repeat-x" <?php if(@$site['web']['repeat']&&$site['web']['repeat']=='repeat-x')echo'checked';?>>repeat-x
				</label>
				<label>
					<input name="repeat" type="radio" id="repeat-2" value="repeat-y" <?php if(@$site['web']['repeat']&&$site['web']['repeat']=='repeat-y')echo'checked';?>>repeat-y
				</label>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		Fixed
	</div>
	<div class="col-lg-8">
		<div class="form-group">
			<div class="radio">
				<label>
					<input name="fixed" type="radio" id="fixed-1" value="fixed" <?php if(@$site['web']['fixed']&&$site['web']['fixed']=='fixed')echo'checked';?>>Ya
				</label>
				<label>
					<input name="fixed" type="radio" id="fixed-2" value="scroll" <?php if(@$site['web']['fixed']&&$site['web']['fixed']=='scroll')echo'checked';?>>Tidak
				</label>
			</div>
		</div>
	</div>
</div>
<hr />

	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<button id="btn-simpan-perubahan" type="submit" class="md-btn md-btn-primary btn-sm square-btn-adjust" title="Simpan perubahan"><li class="fa fa-save"></li> Simpan Perubahan</button>
	</div>
</div>
</form>

<?php
  include(APPPATH.'modules/template/ambil_gambar.php');
?>