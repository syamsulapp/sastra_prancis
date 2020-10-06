<style>
.detail-sto li{
	list-style: none;
	padding: 5px;
	border-top: 1px dotted #666;
	margin-left: -40px;
}
.detail-sto li:first-child{
	border-top: none;
}
</style>
<form action="<?php echo site_url('sto/addsto');?>" name="form_tambah_sto" id="form-tambah-sto" method="post">
	<div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-large-7-10">
            <div class="md-card">
                <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                    <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" id="foto-sto">
                            <img src="<?php if(isset($sto['foto'])&&$sto['foto']!='')echo base_url('assets/img/img_andalan').'/'.$sto['foto'];?>" alt="user avatar"/>
                        </div>
                        <input type="hidden" name="foto" id="foto-input" value="<?php if(isset($sto['foto'])&&$sto['foto']!='')echo$sto['foto'];?>">
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div class="user_avatar_controls">
                            <span class="btn-file">
                                <span class="fileinput-new"><i class="material-icons">&#xE2C6;</i></span>
                                <span class="fileinput-exists"><i class="material-icons">&#xE86A;</i></span>
                                <input type="text" value="<?php if(isset($sto['foto'])&&$sto['foto']!='')echo base_url('assets/img/img_andalan').'/'.$sto['foto'];?>" onclick="ambil_gambar_form_web('foto-input,foto-sto')">
                            </span>
                            <a href="#" class="btn-file fileinput-exists" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('foto-input,foto-sto')"><i class="material-icons">&#xE5CD;</i></a>
                        </div>
                    </div>
                    <div class="user_heading_content">
                        <h2 class="heading_b"><span class="uk-text-truncate" id="user_edit_uname"><?php if(isset($sto['nm_dp']))echo $sto['nm_dp'];?> <?php if(isset($sto['nm_blk']))echo $sto['nm_blk'];?></span><span class="sub-heading" id="user_edit_position"><?php if(isset($sto['username']))echo $sto['username'];?> / <?php if(isset($sto['email']))echo $sto['email'];?></span></h2>
                    </div>
                    <button id="btn-tambah-sto" type="submit" class="md-fab md-fab-small md-fab-success">
                        <i class="material-icons">&#xE161;</i>
                    </button>
                </div>
                <div class="user_content">
                    <div class="row">
						<div class="col-lg-6">
							<input name="id_sto" id="id-sto" value="<?php if(isset($sto['id_sto']))echo $sto['id_sto'];?>" type="hidden">
							<input name="sunting_sto" id="sunting-sto" value="<?php if(isset($sunting))echo $sunting;?>" type="hidden">
							<div class="form-group">
								<label>
									Nama Depan
								</label>
									<input name="nm_dp" id="nm-dp" value="<?php if(isset($sto['nm_dp']))echo $sto['nm_dp'];?>" type="text" class="md-input square-btn-adjust required" title="Masukan nama depan sto di sini">
							</div>
							<div class="form-group">
								<label>
									Nama Belakang
								</label>
									<input name="nm_blk" id="nm-blk" value="<?php if(isset($sto['nm_blk']))echo $sto['nm_blk'];?>" type="text" class="md-input square-btn-adjust" title="Masukan nama belakang sto di sini">
							</div>
							<div class="form-group">
								<label>
									NIP
								</label>
									<input name="nip" id="nip" value="<?php if(isset($sto['nip']))echo $sto['nip'];?>" type="text" class="md-input square-btn-adjust" title="Masukan nip sto di sini">
							</div>
							<div class="form-group">
								<label>
									Tempat Lahir
								</label>
									<input name="kota_lahir" id="kota_lahir" value="<?php if(isset($sto['kota_lahir']))echo $sto['kota_lahir'];?>" type="text" class="md-input square-btn-adjust required" title="Masukan tempat lahir di sini">
							</div>
							<div class="form-group">
								<label>
									Tanggal Lahir
								</label>
									<input name="tgl_lahir" data-uk-datepicker="{format:'YYYY-MM-DD'}" id="tgl_lahir" value="<?php if(isset($sto['tgl_lahir']))echo $sto['tgl_lahir'];?>" type="text" class="md-input square-btn-adjust required" title="Masukan tgl lahir di sini">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>
									Surel / email
								</label>
									<input name="email" id="email" value="<?php if(isset($sto['email']))echo $sto['email'];?>" type="email" class="md-input square-btn-adjust required" title="Masukan email pegawai di sini">
							</div>
							<div class="form-group">
								<label>
									Jabatan
								</label>
									<input name="jabatan" id="jabatan" value="<?php if(isset($sto['jabatan']))echo $sto['jabatan'];?>" type="text" class="md-input square-btn-adjust required" title="Masukan jabatan pegawai di sini">
							</div>
							<div class="form-group">
								<label>
									Pangkat / GOl
								</label>
									<input name="pangkat" id="pangkat" value="<?php if(isset($sto['pangkat']))echo $sto['pangkat'];?>" type="text" class="md-input square-btn-adjust required" title="Masukan pangkat pegawai di sini">
							</div>
							<div class="form-group">
								<label>
									Pendidikan Terakhir
								</label>
									<input name="pendidikan" id="pendidikan" value="<?php if(isset($sto['pendidikan']))echo $sto['pendidikan'];?>" type="text" class="md-input square-btn-adjust required" title="Masukan pendidikan pegawai di sini">
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js');?>"></script>

<?php
  include(APPPATH.'modules/template/ambil_gambar.php');
?>