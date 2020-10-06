<div class="row">
	<div class="col-lg-12">
		<form action="<?php echo site_url();?>tulisan/deltulisanmassalpermanen" name="form_hapus_tulisan_massal" id="form-hapus-tulisan-massal" method="post">
		<ul class="uk-tab">
            <li class=""><a href="<?php echo site_url()?>tulisan">Semua (<?php if(@$data['total_rows_2'][0]['total']){echo$data['total_rows_2'][0]['total'];}else{echo'0';}?>)</a></li>
            <li class="uk-active" aria-expanded="true"><a href="#">Sampah (<?php if(@$data['total_rows']){echo$data['total_rows'];}else{echo'0';}?>)</a></li>
        </ul>
        <br>
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<?php if($this->session->userdata('level')!='user'){?>
				<div style="float:left" class="row col-md-4">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
							<option value="kmbl">Kembalikan</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-tulisan-massal');">Terapkan</span>
					</div>
				</div>
				<?php }?>
				<div class="row col-md-1">
				</div>
				<div class="row col-md-2">
					<select name="format_tulisan" onchange="set_format(this.value)" class="form-control square-btn-adjust auto-width" title="Format Tulisan">
						<option value="all" <?php if($this->session->userdata('id')=='all')echo'selected';?>>Semua</option>
						<?php
						if(@$lbl&&$lbl!=null){
							foreach($lbl as $r){ ?>
							<option value="<?php echo $r['id_kategori'];?>" <?php if($this->session->userdata('id')==$r['id_kategori'])echo'selected';?>><?php echo $r['kategori']; ?></option>
							<?php }
						}
						?>
					</select>
				</div>
				<div class="row col-md-1">
				</div>
				<div style="float:right" class="row col-md-4">
					<div class="input-group">
					  <input value="<?php if(@$_GET['cari'])echo$_GET['cari'];?>" onblur="cari(this.value)" type="text" class="form-control square-btn-adjust" title="Cari tulisan">
					  <div class="input-group-btn">
					  	<a class="btn btn-default"><i class="fa fa-search"></i></a>
					    <a href="<?php echo site_url().'tulisan/sampah';?>" class="btn btn-default"><i class="fa fa-refresh"></i></a>
					  </div>
					</div>
				</div>
				<br />
			</div>
		</div>
		<div class="table-responsive">
			<!--tabel tulisan-->
			<table class="uk-table">
				<thead>
					<tr>
						<?php if($this->session->userdata('level')!='user'){?>
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox"></th>
						<?php }?>
						<th width="3%" class="md-bg-grey-100">No</th>
						<th class="md-bg-grey-100">Judul</th>
						<th width="15%" class="md-bg-grey-100">Tanggal</th>
						<th width="3%" class="md-bg-grey-100">View</th>
						<th width="3%" class="md-bg-grey-100">Jenis</th>
						<th colspan="3" width="5%" class="md-bg-grey-100">Aksi</th>
					</tr>
				</thead>
				<tbody id="tbody-tulisan">
				<?php if(@$data['tulisan']&&$data['error']==0){
					$no=$data['no']+1;
					foreach($data['tulisan'] as $row){
				?>
					<tr id="tmp_tr_<?php echo$row['id_tulisan'];?>">
						<?php if($this->session->userdata('level')!='user'){?>
						<td>
							<input name="check_list[<?php echo$row['id_tulisan'];?>]" value="<?php echo$row['id_tulisan'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
						</td>
						<?php }?>
						<td><?php echo$no?></td>
						<td><img src="<?php if($row['gambar_andalan']!=''){echo base_url('assets/img/img_andalan/thumb').'/'.$row['gambar_andalan'];}?>" style="width:30px;height:30px" alt="  "> <?php echo$row['judul_id']?> | <?php echo$row['judul_eng']?> | <?php echo$row['judul_ae']?> <?php if($row['status_tulisan']=='draft'){echo'(<i>draft</i>)';}?></td>
						<td><?php echo$row['tgl_tulisan']?></td>
						<td><?php echo$row['view']?></td>
						<td title="<?php echo$row['kategori']?>">
							<i class="fa <?php echo$row['icon']?>"></i>
						</td>
						<?php if($this->session->userdata('id_pengguna')==$row['penulis']||$this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
						<?php if($this->session->userdata('level')!='user'){?>
						<td id="tmp_smb_<?php echo$row['id_tulisan'];?>">
							<a href="#" title="Kembalikan" onclick="set_kembalikan('<?php echo$row['id_tulisan']?>')" class="text-primary">
								<i class="fa fa-arrow-left"></i>
							</a>
						</td>
						<?php }?>
						<td><a href="<?php echo site_url().'tulisan/sunting?id='.$row['id_tulisan'];?>" title="Ubah" class="text-success">
							<i class="fa fa-pencil"></i></a>
						</td>
						<td><a href="#" title="Hapus" onclick="set_delete({
								id:'<?php echo$row['id_tulisan']?>',
								nm:'<?php echo$row['judul_id']?>'
								,act:'<?php echo site_url();?>tulisan/deltulisanpermanen'
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
						<?php if($this->session->userdata('level')!='user'){?>
						<th class="md-bg-grey-100"><input id="check-list-all-bawah" onclick="check_list_all_bawah()" type="checkbox"></th>
						<?php }?>
						<th class="md-bg-grey-100">No</th>
						<th class="md-bg-grey-100">Judul</th>
						<th class="md-bg-grey-100">Tanggal</th>
						<th class="md-bg-grey-100">View</th>
						<th class="md-bg-grey-100">Jenis</th>
						<th colspan="3" class="md-bg-grey-100">Aksi</th>
					</tr>
				</tfoot>
			</table>
			<!--tabel tulisan end-->
		</div>
		<div class="block" style="margin-top:10px;">
			<div class="form-group">
				<?php if($this->session->userdata('level')!='user'){?>
				<div style="float:left" class="row col-md-4">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
							<option value="kmbl">Kembalikan</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-tulisan-massal');">Terapkan</span>
					</div>
				</div>
				<?php }?>
				<div style="float:left">
					<?php if(@$data['pagging'])echo$data['pagging'];?>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php if(@$data['total_rows'])echo$data['total_rows'];?></gedank> tulisan</i>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>

<div class="md-fab-wrapper">
    <a href="<?php echo site_url();?>tulisan/baru" class="md-fab md-fab-accent">
        <i class="material-icons"></i>
    </a>
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
							<h3 id="modal_title" class="modal-title">Hapus tulisan</h3>
						</div>
						<div class="modal-body">
							<input id="id_del" name="id" type="hidden">
							<p>Apakah Anda ingin menghapus <b><span id="nama_del"></span></b>?</p>
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

<script>
function set_format(id){
	window.location.href = "<?php echo site_url('tulisan/sampah?id=')?>"+id;
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
function set_kembalikan(id){
	$.ajax({
        'url': '<?php echo site_url("tulisan/kembalikan/'+id+'")?>',
        'dataType': 'json',
        success: function(data){
        	console.log(data);
            if(data.psn!=null){
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                $('#tmp_tr_'+id).remove();
            }else{
                alertify.error('ERROR!');
            }
        }
    });
}
function cari(val){
	window.location.assign("<?php echo site_url()?>tulisan/sampah?cari="+val)
}
</script>

<?php
$success = $this->session->flashdata('success'); if (!empty($success)){?><script>$(document).ready(function(){ var notification = alertify.notify('<?php echo$success;?>', 'success', 5, function(){});});</script><?php }
$warning = $this->session->flashdata('warning'); if (!empty($warning)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$warning;?>', 'warning', 5, function(){});});</script><?php }
$danger = $this->session->flashdata('danger'); if (!empty($danger)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$danger;?>', 'danger', 5, function(){});});</script><?php }
?>