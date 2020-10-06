<div class="row">
	<!--newsticker baru-->
	<div class="col-lg-4">
		<form action="<?php echo site_url();?>tampilan/addnewsticker" name="form_tambah_newsticker" id="form-tambah-newsticker" method="post">
			<input name="id_newsticker" id="id-newsticker" type="hidden">
			<div class="form-group">
				<label>Newsticker</label>
				<textarea id="url-menu" name="url_menu" class="form-control square-btn-adjust" title="Title"></textarea>
			</div>
			<div class="form-group">
				<label>Url</label>
				<input id="url-action" name="url_action" class="form-control square-btn-adjust" title="Url" type="text">
			</div>
			<div class="form-group">
				<button type="reset" class="md-btn md-btn-default btn-sm square-btn-adjust" title="Batal/Reset Form" onclick="form_tambah_newsticker_reset()"><li class="fa fa-times"></li> Batal</button>
				<button type="submit" class="md-btn md-btn-primary btn-sm square-btn-adjust" title="Tambah newsticker baru"><li class="fa fa-save"></li> Tambah newsticker Baru</button>
			</div>
		</form>
	</div>
	<!--newsticker baru end-->

	<!--daftar newsticker-->
	<div class="col-lg-8" style="border-left:1px solid #f0f0f0;">
		<form action="<?php echo site_url();?>tampilan/delnewstickermassal" name="form_hapus_newsticker_massal" id="form-hapus-newsticker-massal" method="post">
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-newsticker-massal');">Terapkan</span>
					</div>
				</div>
				<br />
			</div>
		</div>
		<div class="table-responsive">
			<!--tabel newsticker-->
			<table class="uk-table">
				<thead>
					<tr>
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox"></th>
						<th class="md-bg-grey-100">Newsticker</th>
						<th class="md-bg-grey-100">Url</th>
						<th width="3%" colspan="2" class="md-bg-grey-100">Aksi</th>
					</tr>
				</thead>
				<tbody id="tbody-newsticker">
					<?php if(@$data['newsticker']&&$data['error']==0){
						$no=$data['no']+1;
						foreach($data['newsticker'] as $row){
					?>
						<tr>
							<td>
								<input name="check_list[<?php echo$row['id_newsticker'];?>]" value="<?php echo$row['id_newsticker'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
							</td>
							<td><?php echo$row['newsticker']?></td>
							<td><a href="<?php echo$row['url']?>" target="blank"><?php echo$row['url']?></a></td>
							<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
							<td>
								<a href="#" onclick="set_edit({
									id:'<?php echo$row['id_newsticker']?>'
									,slug:'<?php echo$row['newsticker']?>'
									,url:'<?php echo$row['url']?>'
								})" class="text-success"><i class="fa fa-pencil"></i>
								</a>
							</td>
							<td><a href="#" title="Hapus" onclick="set_delete({
									id:'<?php echo$row['id_newsticker']?>',
									nm:'<?php echo$row['newsticker']?>'
									,act:'<?php echo site_url();?>tampilan/delnewsticker'
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
				<tfoot>
					<tr>
						<th class="md-bg-grey-100"><input id="check-list-all-bawah" onclick="check_list_all_bawah()" type="checkbox"></th>
						<th class="md-bg-grey-100">Newsticker</th>
						<th class="md-bg-grey-100">Url</th>
						<th colspan="2" class="md-bg-grey-100">Aksi</th>
					</tr>
				</tfoot>
			</table>
			<!--tabel newsticker end-->
		</div>
		<div class="block" style="margin-top:10px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-newsticker-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:left">
					<?php if(@$data['pagging'])echo$data['pagging'];?>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php if(@$data['total_rows'])echo$data['total_rows'];?></gedank> newsticker</i>
				</div>
			</div>
		</div>
		</form>
	</div>
	<!--daftar newsticker end-->
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
							<h3 id="modal_title" class="modal-title">Hapus newsticker</h3>
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
$(window).load(function(){
    form_tambah_newsticker_reset();
});

$(document).ready(function(){
});

function form_tambah_newsticker_reset(){
	$('#id-newsticker').val('');
}


function set_edit(data){
	$('#id-newsticker').val(data.id);
	$('#url-menu').val(data.slug);
	$('#url-action').val(data.url);
}
function set_delete(data){
	$('#id_del').val(data.id);
	$('#nama_del').html(data.nm);
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