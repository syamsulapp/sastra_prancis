<div class="row">
	<!--theme baru-->
	<div class="col-lg-4">
		<form action="<?php echo site_url();?>tampilan/addtheme" name="form_tambah_theme" id="form-tambah-theme" method="post" enctype="multipart/form-data">
			<input name="id_theme" id="id-theme" type="hidden">
			<div class="form-group">
				<label>Unggah Tema dalam bentuk zip</label>
				<input id="icon-theme" name="theme" type="file" class="form-control square-btn-adjust" title="Icon theme">
			</div>
			<div class="form-group">
				<button type="reset" class="md-btn md-btn-default btn-sm square-btn-adjust" title="Batal/Reset Form" onclick="form_tambah_theme_reset()"><li class="fa fa-times"></li> Batal</button>
				<button type="submit" class="md-btn md-btn-primary btn-sm square-btn-adjust" title="Tambah theme baru"><li class="fa fa-save"></li> Tambah theme Baru</button>
			</div>
		</form>
	</div>
	<!--theme baru end-->

	<!--daftar theme-->
	<div class="col-lg-8" style="border-left:1px solid #f0f0f0;">
		<form action="<?php echo site_url();?>tampilan/delthememassal" name="form_hapus_theme_massal" id="form-hapus-theme-massal" method="post">
		<div class="block">
			<div class="form-group">
				<div style="float:left;padding:5px;">
					<input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox">
				</div>
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-theme-massal');">Terapkan</span>
					</div>
				</div>
				<br />
			</div>
		</div>
		<!-- <table class="widefat table-striped">
			<thead>
				<tr>
					<th width="5%"><input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox"></th>
					<th>theme</th>
					<th width="3%" colspan="2">Aksi</th>
				</tr>
			</thead>
			<tbody id="tbody-theme">
				<?php if(@$data['theme']){
					$no=$data['no']+1;
					foreach($data['theme'] as $row){
				?>
					<tr>
						<td>
							<input name="check_list[<?php echo$row['id_theme'];?>]" value="<?php echo$row['id_theme'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
						</td>
						<td><?php echo$row['theme']?></td>
						<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
						<td id="tmp_smb_<?php echo$row['id_theme'];?>">
							<?php if($row['status_theme']=='open'){?>
							<i class="fa fa-eye"></i>
							<?php }else{ ?>
							<a href="<?php echo site_url('tampilan/settheme/'.$row['id_theme']);?>" title="Gunakan">
								<i class="fa fa-eye-slash"></i>
							</a>
							<?php }?>
						</td>
						<td><a href="#" title="Hapus" onclick="set_delete({
								id:'<?php echo$row['id_theme']?>',
								nm:'<?php echo$row['theme']?>'
								,act:'<?php echo site_url();?>tampilan/deltheme'
							})" data-toggle="modal" data-target=".bs-hapus-">
							<i class="fa fa-trash-o"></i></a>
						</td>
						<?php }?>
					</tr>
				<?php
					$no++;
					}
				}else{
				?>
					<tr>
						<td colspan="5">Data masih Kosong</td>
					</tr>
				<?php
				}?>
			</tbody>
			<tfoot>
				<tr>
					<th><input id="check-list-all-bawah" onclick="check_list_all_bawah()" type="checkbox"></th>
					<th>theme</th>
					<th colspan="2">Aksi</th>
				</tr>
			</tfoot>
		</table> -->
		<div>
			<div class="row">
	            <div class="album-area" style="padding-top:10px;">
	            	<?php if(@$data['theme']){
						$no=$data['no']+1;
						foreach($data['theme'] as $row){
						if($row['status_theme']=='open'){$class_theme='active';}else{$class_theme='disactive';}
					?>
	            	<div class="col-lg-3 col-md-4 col-xs-6 text-center tema-height <?php echo $class_theme;?>">
	            		<div class="tema-item">
		            		<div class="tema-judul"><?php echo ucfirst($row['theme']);?></div>
		            		<div style="z-index:0;">
		            			<a href="<?php echo site_url('tampilan/settheme/'.$row['id_theme']);?>" title="Gunakan">
		            				<img class="img-responsive" src="<?php echo base_url('themes/'.$row['theme'].'/icon.png');?>" alt="">
		            			</a>
		            		</div>
		            		<div class="tema-aksi">
		            			<p class="row-actions" style="display: block;">
		            				<?php if($row['theme']!='default'){?>
		            				<span class="sunting">
		            					<input name="check_list[<?php echo$row['id_theme'];?>]" value="<?php echo$row['id_theme'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
		            				</span>
		            				<?php }?>
		            				<?php if($row['status_theme']=='open'){?>
		            				<span class="sunting"> | 
		            					Aktif
		            				</span>
		            				<?php }else{ ?>
		            				<span class="sunting"> | 
		            					<a href="<?php echo site_url('tampilan/settheme/'.$row['id_theme']);?>" title="Gunakan">Gunakan</a>
		            				</span>
		            				<?php }?>
		            				<?php if($row['theme']!='default'){?>
		            				<span class="hapus"> | 
		            					<a href="#" title="Hapus" onclick="set_delete({
											id:'<?php echo$row['id_theme']?>',
											nm:'<?php echo$row['theme']?>'
											,act:'<?php echo site_url();?>tampilan/deltheme'
										})" data-toggle="modal" data-target=".bs-hapus-">Hapus</a>
		            				</span>
		            				<?php }?>
		            			</p>
		            		</div>
		            	</div>
	            	</div>
	            	<?php
						$no++;
						}
					}
					?>
	            </div>
	        </div>
		</div>
		<div class="block">
			<div class="form-group">
				<div style="float:left;padding:5px;">
					<input id="check-list-all-bawah" onclick="check_list_all_bawah()" type="checkbox">
				</div>
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-theme-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:left">
					<?php if(@$data['pagging'])echo$data['pagging'];?>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php if(@$data['total_rows'])echo$data['total_rows'];?></gedank> theme</i>
				</div>
			</div>
		</div>
		</form>
	</div>
	<!--daftar theme end-->
</div>

<!--delete Modal-->
<div class="modal fade bs-hapus-" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content square-btn-adjust">
			<div class="row">
				<div class="col-lg-12">
					<form id="form_action_del" action="" method="post">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 id="modal_title" class="modal-title">Hapus theme</h3>
						</div>
						<div class="modal-body">
							<input id="id_del" name="id" type="hidden">
							<input id="nm_del" name="nm" type="hidden">
							<p>Apakah Anda ingin menghapus <b><span id="nama_del"></span></b></p>
						</div>
						<div class="modal-footer">
							<button type="reset" class="btn btn-default square-btn-adjust" data-dismiss="modal">Tidak</button>
							<button type="submit" class="btn btn-default square-btn-adjust">Ya</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--delete Modal end-->

<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js');?>"></script>
<script type="text/javascript">
$(window).load(function(){
    form_tambah_theme_reset();
});

$(document).ready(function(){
	$("#form-tambah-theme").validate({
	});
});

function form_tambah_theme_reset(){
	$('#id-theme').val('');
	$('#icon-theme').val('');
}

function set_delete(data){
	$('#id_del').val(data.id);
	$('#nama_del').html(data.nm);
	$('#nm_del').val(data.nm);
	$('#form_action_del').attr('action',data.act);
}
function check_list_all_atas(){
	if(document.getElementById('check-list-all-atas').checked==true){
		$('.check-list').prop('checked', true);
		$('#check-list-all-bawah').prop('checked', true);
	}else{
		$('.check-list').prop('checked', false);
		$('#check-list-all-bawah').prop('checked', false);
	}
}
function check_list_all_bawah(){
	if(document.getElementById('check-list-all-bawah').checked==true){
		$('.check-list').prop('checked', true);
		$('#check-list-all-atas').prop('checked', true);
	}else{
		$('.check-list').prop('checked', false);
		$('#check-list-all-atas').prop('checked', false);
	}
}
</script>

<?php
  include(APPPATH.'modules/template/ambil_gambar.php');
?>