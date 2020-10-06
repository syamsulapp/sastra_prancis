<div class="row">
	<div class="col-lg-12">
		<form action="<?php echo site_url();?>testimoni/deltestimonimassal" name="form_hapus_tulisan_massal" id="form-hapus-tulisan-massal" method="post">
		<ul class="uk-tab">
            <?php if($this->uri->segment(2)=='testimoni' || $this->uri->segment(2)==''){?>
            <li class="uk-active"><a href="#">Semua (<?php if(@$data['total_rows']){echo$data['total_rows'];}else{echo'0';}?>)</a></li>
            <?php }else{?>
			<li class=""><a href="<?php echo site_url()?>testimoni">
			Semua (<?php echo$data['total_rows'];?>)</a></li> 
			<?php }?>

			<?php if($this->uri->segment(2)=='menunggu'){?>
			<li class="uk-active"><a href="#">Menunggu (<?php echo$data['total_rows_2'];?>)</a></li> <?php }else{?>
			<li class=""><a href="<?php echo site_url()?>testimoni/menunggu">Menunggu (<?php echo$data['total_rows_2'];?>)</a></li> 
			<?php }?>

			<?php if($this->uri->segment(2)=='sampah'){?>
			<li class="uk-active"><a href="#">Sampah (<?php echo$data['total_rows_3'];?>) </a></li><?php }else{?>
			<li class=""><a href="<?php echo site_url()?>testimoni/sampah">Sampah (<?php echo$data['total_rows_3'];?>)</a></li> 
			<?php }?> 
        </ul>
        <br>
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-4">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-tulisan-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:right" class="row col-md-4">
					<div class="input-group">
					  <input value="<?php if(@$_GET['cari'])echo$_GET['cari'];?>" onblur="cari(this.value)" type="text" class="form-control square-btn-adjust" title="Cari testimoni">
					  <div class="input-group-btn">
					  	<a class="btn btn-default"><i class="fa fa-search"></i></a>
					    <a href="<?php echo site_url().'testimoni';?>" class="btn btn-default"><i class="fa fa-refresh"></i></a>
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
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox"></th>
						<th width="3%" class="md-bg-grey-100">No</th>
						<th class="md-bg-grey-100">Testimoni</th>
						<th width="15%" class="md-bg-grey-100">Tanggal</th>
						<th colspan="2" width="5%" class="md-bg-grey-100">Aksi</th>
					</tr>
				</thead>
				<tbody id="tbody-tulisan">
				<?php if(@$data['testimoni']&&$data['error']==0){
					$no=$data['no']+1;
					foreach($data['testimoni'] as $row){
				?>
					<tr>
						<td>
							<input name="check_list[<?php echo$row['id_testimoni'];?>]" value="<?php echo$row['id_testimoni'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
						</td>
						<td><?php echo$no?></td>
						<td><img alt="   " src="<?php if($row['foto']!=''){echo base_url('assets/img/img_andalan/thumb').'/'.$row['foto'];}?>" style="width:30px;height:30px"> <?php echo$row['testimoni']?> - <i><?php echo$row['nama']?> [<?php echo$row['email']?>] dari <?php echo$row['instansi']?></i></td>
						<td><?php echo$row['tgl_testimoni']?></td>
						<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
						<td id="tmp_smb_<?php echo$row['id_testimoni'];?>">
							<?php if($row['status_testimoni_']=='terbit'){?>
							<a href="#" title="Sembunyikan" onclick="set_sembunyikan('<?php echo$row['id_testimoni']?>')" class="text-warning">
								<i class="fa fa-eye"></i>
							</a>
							<?php }else{ ?>
							<a href="#" title="Tampilkan" onclick="set_tampilkan('<?php echo$row['id_testimoni']?>')" class="text-warning">
								<i class="fa fa-eye-slash"></i>
							</a>
							<?php }?>
						</td>
						<td><a href="#" title="Hapus" onclick="set_delete({
								id:'<?php echo$row['id_testimoni']?>',
								nm:'<?php echo$row['testimoni']?>'
								,act:'<?php echo site_url();?>testimoni/deltestimoni'
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
						<th class="md-bg-grey-100">No</th>
						<th class="md-bg-grey-100">Testimoni</th>
						<th class="md-bg-grey-100">Tanggal</th>
						<th colspan="2" class="md-bg-grey-100">Aksi</th>
					</tr>
				</tfoot>
			</table>
			<!--tabel tulisan end-->
		</div>
		<div class="block" style="margin-top:10px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-4">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-tulisan-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:left">
					<?php if(@$data['pagging'])echo$data['pagging'];?>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php if(@$data['total_rows'])echo$data['total_rows'];?></gedank> testimoni</i>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>

<div class="md-fab-wrapper">
    <a href="<?php echo site_url('testimoni/baru');?>" id="btn-tambah-testimoni-baru" class="md-fab md-fab-accent">
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
							<h3 id="modal_title" class="modal-title">Hapus testimoni</h3>
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
function set_sembunyikan(id){
	$.ajax({
        'url': '<?php echo site_url("testimoni/sembunyikan/'+id+'")?>',
        'dataType': 'json',
        success: function(data){
        	console.log(data);
            if(data.psn!=null){
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                $('#tmp_smb_'+id).html('<a href="#" title="Tampilkan" onclick="set_tampilkan('+id+')"><i class="fa fa-eye-slash"></i></a>');
            }else{
                alertify.error('ERROR!');
            }
        }
    });
}
function set_tampilkan(id){
	$.ajax({
        'url': '<?php echo site_url("testimoni/tampilkan/'+id+'")?>',
        'dataType': 'json',
        success: function(data){
        	console.log(data);
            if(data.psn!=null){
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                $('#tmp_smb_'+id).html('<a href="#" title="Sembunyikan" onclick="set_sembunyikan('+id+')"><i class="fa fa-eye"></i></a>');
            }else{
                alertify.error('ERROR!');
            }
        }
    });
}
function cari(val){
	window.location.assign("<?php echo site_url()?>testimoni?cari="+val)
}
</script>

<?php
$success = $this->session->flashdata('success'); if (!empty($success)){?><script>$(document).ready(function(){ var notification = alertify.notify('<?php echo$success;?>', 'success', 5, function(){});});</script><?php }
$warning = $this->session->flashdata('warning'); if (!empty($warning)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$warning;?>', 'warning', 5, function(){});});</script><?php }
$danger = $this->session->flashdata('danger'); if (!empty($danger)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$danger;?>', 'danger', 5, function(){});});</script><?php }
?>