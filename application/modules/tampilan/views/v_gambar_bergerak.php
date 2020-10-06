<div class="row">
	<!--gambar_bergerak baru-->
	<div class="col-lg-4">
		<form action="<?php echo site_url()?>tampilan/addgambar_bergerak" name="form_tambah_gambar_bergerak" id="form-tambah-gambar-bergerak" method="post">
			<input name="id_gambar_bergerak" id="id-gambar-bergerak" type="hidden">
			<div class="form-group">
				<label>Nama</label>
				<input id="nama-gambar-bergerak" name="nama_gambar_bergerak" type="text" class="form-control square-btn-adjust required" title="Nama gambar_bergerak">
			</div>
			<div class="form-group">
				<label>Pilihan</label>
				<div class="input-group pilihan1">
					<input name="pilihan[1]" id="pilihan12015" type="text" class="form-control square-btn-adjust pilihan" title="Pilihan">
					<div class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="ambil_gambar_form_web('pilihan12015,')"><i class="fa fa-picture-o"></i></button>
						<button class="btn btn-default" type="button" id="del-0" onclick="del(this.id)"><i class="fa fa-times"></i></button>
					</div>
				</div>
			</div>
			<input type="hidden" value="2" id="loop">
			<div class="batas"></div>
			<div class="form-group text-right">
				<a class="btn btn-default square-btn-adjust" onclick="tambah()" title="Tambah Pilihan"><i class="fa fa-plus"></i> tambah</a>
			</div>
			<div class="form-group">
				<button type="reset" class="md-btn md-btn-default btn-sm square-btn-adjust" title="Batal/Reset Form" onclick="form_tambah_gambar_bergerak_reset()"><li class="fa fa-times"></li> Batal</button>
				<button type="submit" class="md-btn md-btn-primary btn-sm square-btn-adjust" title="Tambah gambar_bergerak baru"><li class="fa fa-floppy-o"></li> Tambah Gambar Bergerak Baru</button>
			</div>
		</form>
	</div>
	<!--gambar_bergerak baru end-->

	<!--daftar gambar_bergerak-->
	<div class="col-lg-8" style="border-left:1px solid #f0f0f0;">
		<form action="<?php echo site_url();?>tampilan/delgambar_bergerakmassal" name="form_hapus_gambar_bergerak_massal" id="form-hapus-gambar-bergerak-massal" method="post">
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-gambar-bergerak-massal');">Terapkan</span>
					</div>
				</div>
				<br />
			</div>
		</div>
		<div class="table-responsive">
			<!--tabel gambar_bergerak-->
			<table class="uk-table">
				<thead>
					<tr>
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox"></th>
						<th width="35%" class="md-bg-grey-100">Nama</th>
						<th width="45%" class="md-bg-grey-100">Gambar</th>
						<th width="3%" colspan="3" class="md-bg-grey-100">Aksi</th>
					</tr>
				</thead>
				<tbody id="tbody-gambar-bergerak">
					<?php if(@$data['gambar_bergerak']&&$data['gambar_bergerak']!=null){
						$no=$data['no']+1;
						foreach($data['gambar_bergerak'] as $row){
					?>
						<tr>
							<td>
								<input name="check_list[<?php echo$row['id_kategori'];?>]" value="<?php echo$row['id_kategori'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
							</td>
							<td><?php echo$row['kategori']?></td>
							<td>
								<?php
								if(@$data['img'][$row['id_kategori']]){
									$k=0;
									$parent = '{';
									foreach ($data['img'][$row['id_kategori']] as $row2) {
										echo'<img src="'.base_url('assets/img/img_andalan/thumb').'/'.$row2['kat_order'].'" style="height:30px;">';
										if($k==0){
											$parent .= $k.':{img:\''.$row2['kat_order'].'\'}';
										}else{
											$parent .= ','.$k.':{img:\''.$row2['kat_order'].'\'}';
										}
										$k++;
									}
									$parent .= '}';
								}else{
									$parent = '{}';
								}
								?>
							</td>
							<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
							<td id="tmp_smb_<?php echo$row['id_kategori'];?>">
								<?php if($row['status_kategori']=='open'){?>
								<a href="<?php echo site_url('tampilan/sembunyikan/'.$row['id_kategori'].'/gambar_bergerak')?>" title="Sembunyikan" class="text-warning">
									<i class="fa fa-eye"></i>
								</a>
								<?php }else{ ?>
								<a href="<?php echo site_url('tampilan/tampilkan/'.$row['id_kategori'].'/gambar_bergerak')?>" title="Tampilkan" class="text-warning">
									<i class="fa fa-eye-slash"></i>
								</a>
								<?php }?>
							</td>
							<td>
								<a href="#" onclick="set_edit({
									id:'<?php echo$row['id_kategori']?>'
									,nm:'<?php echo$row['kategori']?>'
									,img:<?php echo$parent?>
								})" class="text-success"><i class="fa fa-pencil"></i>
								</a>
							</td>
							<td><a href="#" title="Hapus" onclick="set_delete({
									id:'<?php echo$row['id_kategori']?>'
									,nm:'<?php echo$row['kategori']?>'
									,act:'<?php echo site_url();?>tampilan/delgambar_bergerak'
								})" data-toggle="modal" data-target=".bs-hapus-" class="text-danger">
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
			</table>
		</div>
		<div class="block" style="margin-top:10px;">
			<div class="form-group">
				<div style="float:left">
					<ul class="pagination">
						<?php if(@$data['paging']['page'])print_r($data['paging']['page']);?>
					</ul>
				</div>
				<div style="float:right">
					<?php if(@$data['paging']['info'])print_r($data['paging']['info']);?>
				</div>
			</div>
		</div>
		</form>
	</div>
	<!--daftar gambar_bergerak end-->
</div>

<?php
  include(APPPATH.'modules/template/ambil_gambar.php');
?>

<!--delete Modal-->
<div class="modal fade bs-hapus-" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content square-btn-adjust">
			<div class="row">
				<div class="col-lg-12">
					<form id="form_action_del" action="" method="post">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 id="modal_title" class="modal-title">Hapus Gambar Bergerak</h3>
						</div>
						<div class="modal-body">
							<input id="id_del" name="id" type="hidden">
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
function tambah(){
	loop = eval($('#loop').val());
	row = '<div class="form-group pilihan1">'
			+'<div class="input-group">'
				+'<input type="hidden" name="id_pilihan['+loop+'2015]" value="'+loop+'2015" class="id-pilihan-hidden">'
				+'<input name="pilihan['+loop+'2015]" id="pilihan'+loop+'2015" type="text" class="form-control square-btn-adjust pilihan" title="Pilihan">'
				+'<div class="input-group-btn">'
					+'<button class="btn btn-default" type="button" onclick="ambil_gambar_form_web(\'pilihan'+loop+'2015,\')"><i class="fa fa-picture-o"></i></button>'
					+'<button class="btn btn-default" type="button" id="del-'+loop+'" onclick="del(this.id)"><i class="fa fa-times"></i></button>'
				+'</div>'
			+'</div>'
		+'</div>';
	loop++;
	$('#loop').val(loop);
	$(row).insertBefore(".batas");
}
function del(data){
		$('#'+data).parent().parent().parent().remove();
}
</script>
<script type="text/javascript">
function form_tambah_slide_reset(){
	$('#id-gambar-bergerak').val('');
	$('#nama-gambar-bergerak').val('');
	$('.list-check-img').prop('checked', false);
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

function set_delete(data){
	$('#id_del').val(data.id);
	$('#nama_del').html('<b>'+data.nm+'</b>?');
	$('#form_action_del').attr('action',data.act);
}

function set_edit(data){
	$('#id-gambar-bergerak').val(data.id);
	$('#nama-gambar-bergerak').val(data.nm);
	$('.pilihan1').remove();
	if(data.img!=null){
		loop = 1;
		row = '';
		$.each(data.img, function(i,n){
			row += '<div class="form-group pilihan1">'
				+'<div class="input-group">'
					+'<input type="hidden" name="id_pilihan['+loop+'2015]" value="'+loop+'2015" class="id-pilihan-hidden">'
					+'<input name="pilihan['+loop+'2015]" value="'+n.img+'" id="pilihan'+loop+'2015" type="text" class="form-control square-btn-adjust pilihan" title="Pilihan">'
					+'<div class="input-group-btn">'
						+'<button class="btn btn-default" type="button" onclick="ambil_gambar_form_web(\'pilihan'+loop+'2015,\')"><i class="fa fa-picture-o"></i></button>'
						+'<button class="btn btn-default" type="button" id="del-'+loop+'" onclick="del(this.id)"><i class="fa fa-times"></i></button>'
					+'</div>'
				+'</div>'
			+'</div>';
			loop++;
		});
		$('#loop').val(loop);
		$(row).insertBefore(".batas");
	}

}
</script>
					
<?php
$success = $this->session->flashdata('success'); if (!empty($success)){?><script>$(document).ready(function(){ var notification = alertify.notify('<?php echo$success;?>', 'success', 5, function(){});});</script><?php }
$warning = $this->session->flashdata('warning'); if (!empty($warning)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$warning;?>', 'warning', 5, function(){});});</script><?php }
$danger = $this->session->flashdata('danger'); if (!empty($danger)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$danger;?>', 'danger', 5, function(){});});</script><?php }
?>