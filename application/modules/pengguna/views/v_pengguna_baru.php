<style>
.detail-pengguna li{
	list-style: none;
	padding: 5px;
	border-top: 1px dotted #666;
	margin-left: -40px;
}
.detail-pengguna li:first-child{
	border-top: none;
}
</style>
<form action="<?php echo site_url('pengguna/addpengguna');?>" name="form_tambah_pengguna" id="form-tambah-pengguna" method="post">
	<div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-large-7-10">
            <div class="md-card">
                <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                    <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" id="foto-pengguna">
                            <img src="<?php if(isset($pengguna['foto'])&&$pengguna['foto']!='')echo base_url('assets/img/img_andalan').'/'.$pengguna['foto'];?>" alt="user avatar"/>
                        </div>
                        <input type="hidden" name="foto" id="foto-input" value="<?php if(isset($pengguna['foto'])&&$pengguna['foto']!='')echo$pengguna['foto'];?>">
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div class="user_avatar_controls">
                            <span class="btn-file">
                                <span class="fileinput-new"><i class="material-icons">&#xE2C6;</i></span>
                                <span class="fileinput-exists"><i class="material-icons">&#xE86A;</i></span>
                                <input type="text" value="<?php if(isset($pengguna['foto'])&&$pengguna['foto']!='')echo base_url('assets/img/img_andalan').'/'.$pengguna['foto'];?>" onclick="ambil_gambar_form_web('foto-input,foto-pengguna')">
                            </span>
                            <a href="#" class="btn-file fileinput-exists" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('foto-input,foto-pengguna')"><i class="material-icons">&#xE5CD;</i></a>
                        </div>
                    </div>
                    <div class="user_heading_content">
                        <h2 class="heading_b"><span class="uk-text-truncate" id="user_edit_uname"><?php if(isset($pengguna['nm_dp']))echo $pengguna['nm_dp'];?> <?php if(isset($pengguna['nm_blk']))echo $pengguna['nm_blk'];?></span><span class="sub-heading" id="user_edit_position"><?php if(isset($pengguna['username']))echo $pengguna['username'];?> / <?php if(isset($pengguna['email']))echo $pengguna['email'];?></span></h2>
                    </div>
                    <button id="btn-tambah-pengguna" type="submit" class="md-fab md-fab-small md-fab-success">
                        <i class="material-icons">&#xE161;</i>
                    </button>
                </div>
                <div class="user_content">
                    <div class="row">
						<div class="col-lg-6">
							<input name="id_pengguna" id="id-pengguna" value="<?php if(isset($pengguna['id_pengguna']))echo $pengguna['id_pengguna'];?>" type="hidden">
							<input name="sunting_pengguna" id="sunting-pengguna" value="<?php if(isset($sunting))echo $sunting;?>" type="hidden">
							<div class="form-group">
								<label>
									Nama Pengguna / username
								</label>
									<input name="username" id="username" value="<?php if(isset($pengguna['username']))echo $pengguna['username'];?>" type="text" class="md-input square-btn-adjust required" title="Masukan nama pengguna di sini (min 5 digit)">
									<input name="username2" id="username2" value="<?php if(isset($pengguna['username']))echo $pengguna['username'];?>" type="text" class="md-input square-btn-adjust" title="Masukan nama pengguna di sini (min 5 digit)" style="display:none" disabled>
							</div>
							<div class="form-group">
								<label>
									Surel / email
								</label>
									<input name="email" id="email" value="<?php if(isset($pengguna['email']))echo $pengguna['email'];?>" type="email" class="md-input square-btn-adjust required" title="Masukan email pengguna di sini">
							</div>
							<div class="form-group">
								<label>
									Nama Depan
								</label>
									<input name="nm_dp" id="nm-dp" value="<?php if(isset($pengguna['nm_dp']))echo $pengguna['nm_dp'];?>" type="text" class="md-input square-btn-adjust required" title="Masukan nama depan pengguna di sini">
							</div>
							<div class="form-group">
								<label>
									Nama Belakang
								</label>
									<input name="nm_blk" id="nm-blk" value="<?php if(isset($pengguna['nm_blk']))echo $pengguna['nm_blk'];?>" type="text" class="md-input square-btn-adjust" title="Masukan nama belakang pengguna di sini">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>
									Situs Web
								</label>
									<input name="web" id="web" value="<?php if(isset($pengguna['web']))echo $pengguna['web'];?>" type="text" class="md-input square-btn-adjust" title="Masukan situs web pengguna di sini">
							</div>
							<div class="form-group">
								<label>
									Password
								</label>
									<input name="password" id="password" value="" type="password" class="md-input square-btn-adjust required" title="Masukan password pengguna di sini (min 5 digit)">
							</div>
							<div class="form-group">
								<label>
									Ulangi Password
								</label>
									<input name="c_password" id="c-password" value="" type="password" class="md-input square-btn-adjust required" title="Ulangi password pengguna di sini">
							</div>
							<div class="form-group">
									<select name="level" id="level" class="md-input square-btn-adjust" title="Pilih level pengguna di sini">
										<option value="user" <?php if(isset($pengguna['level'])&&$pengguna['level']=='user')echo'selected';?>>User</option>
										<?php if($this->session->userdata('level')=='administrator' or $this->session->userdata('level')=='editor'){?><option value="editor" <?php if(isset($pengguna['level'])&&$pengguna['level']=='editor')echo'selected';?>>Editor</option><?php }?>
										<?php if($this->session->userdata('level')=='administrator'){?><option value="administrator" <?php if(isset($pengguna['level'])&&$pengguna['level']=='administrator')echo'selected';?>>Administrator</option><?php }?>
									</select>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js');?>"></script>
<script type="text/javascript">
$(window).load(function(){
	var sunting = $('#sunting-pengguna').val();
	if(sunting=='true'){
		$('#username').hide();
		$('#username2').show();
		$('#password').removeClass('required');
		$('#c-password').removeClass('required');
		$('#btn-tambah-pengguna').removeClass('disabled');
	}
});

$(document).ready(function(){
	$('#c-password').on('blur',function(){
		password=$('#password').val();
		cpassword=$('#c-password').val();
		if(password==cpassword){
			if($('#username').val().length>=5 && $('#password').val().length>=5){
				$('#btn-tambah-pengguna').removeClass('disabled');
			}else{
				var notification = alertify.notify('Nama pengguna dan kata kunci minimal 5 digit.', 'warning', 5, function(){console.log('pswrd&cpswrd#');});
			}
		}else{
			$('#btn-tambah-pengguna').addClass('disabled');
			var notification = alertify.notify('konfirmasi password dan password tidak cocok.', 'danger', 5, function(){console.log('pswrd&cpswrd#');});
		}
	});

    $('#username').on('blur', function(){
    	if($('#username').val().length>=5 && $('#password').val().length>=5){
    		$('#btn-tambah-pengguna').removeClass('disabled');
    	}else{
    		if($('#username').val().length<5){
    			var notification = alertify.notify('Nama pengguna minimal 5 digit.', 'warning', 5, function(){console.log('pswrd&cpswrd#');});
    		}
    		$('#btn-tambah-pengguna').addClass('disabled');
    	}
    	if($('#username').val()==$('#level').val()){
    		var notification = alertify.notify('Username tidak boleh sama dengan level.', 'warning', 5, function(){console.log('usr&level#');});
    		$('#username').val('');
    	}else{
    		$.ajax({
		        'type': 'POST',
		        'url': '<?php echo site_url("pengguna/checkusername");?>',
		        'dataType': 'json',
		        'data': 'username='+$('#username').val(),
		        success: function(data){
		        	console.log(data);
		        	if(data.check!=null){
		        		var notification = alertify.notify('Username sudah digunakan.', 'warning', 5, function(){console.log('usr&level#');});
		        		$('#username').val('');
		        	}
		        }
		    });
    	}
    });
    $('#password').on('blur', function(){
    	if($('#username').val().length>=5 && $('#password').val().length>=5){
    		password=$('#password').val();
			cpassword=$('#c-password').val();
			if(password==cpassword){
				if($('#username').val().length>=5 && $('#password').val().length>=5){
					$('#btn-tambah-pengguna').removeClass('disabled');
				}else{
					var notification = alertify.notify('Nama pengguna dan kata kunci minimal 5 digit.', 'warning', 5, function(){console.log('pswrd&cpswrd#');});
				}
			}else{
				$('#btn-tambah-pengguna').addClass('disabled');
			}
    	}else{
    		if($('#password').val().length<5){
    			var notification = alertify.notify('Kata kunci minimal 5 digit.', 'warning', 5, function(){console.log('pswrd&cpswrd#');});
    		}
    		$('#btn-tambah-pengguna').addClass('disabled');
    	}
    });
});
</script>

<?php
  include(APPPATH.'modules/template/ambil_gambar.php');
?>