<div class="row">
	<!--poling baru-->
	<div class="col-lg-4">
		<form action="<?php echo site_url().'poling/addpoling';?>" name="form_tambah_poling" id="form-tambah-poling" method="post">
			<input name="id_poling" id="id-poling" type="hidden">
			<div class="form-group">
				<label>Tapik Masalah</label>
				<textarea id="deskripsi-poling" name="deskripsi_poling" class="form-control square-btn-adjust" rows="5" title="Topik Masalah"></textarea>
			</div>
			<div class="form-group">
				<label>Pilihan</label>
				<div class="input-group pilihan1">
					<input name="pilihan[1]" id="pilihan" type="text" class="form-control square-btn-adjust pilihan" title="Pilihan">
					<span class="input-group-addon"><i class="fa fa-times" id="del-0" onclick="del(this.id)"></i></span>
				</div>
			</div>
			<input type="hidden" value="2" id="loop">
			<div class="batas"></div>
			<div class="form-group text-right">
				<a class="btn btn-default square-btn-adjust" onclick="tambah()" title="Tambah Pilihan"><i class="fa fa-plus"></i> tambah</a>
			</div>
			<div class="form-group">
				<button type="reset" class="md-btn md-btn-default btn-sm square-btn-adjust" title="Batal/Reset Form" onclick="form_tambah_poling_reset()"><li class="fa fa-times"></li> Batal</button>
				<button type="submit" class="md-btn md-btn-primary btn-sm square-btn-adjust" title="Tambah poling baru"><li class="fa fa-save"></li> Tambah Poling Baru</button>
			</div>
		</form>
	</div>
	<!--poling baru end-->

	<!--daftar poling-->
	<div class="col-lg-8" style="border-left:1px solid #f0f0f0;">
		<form action="<?php echo site_url();?>poling/delpolingmassal" name="form_hapus_poling_massal" id="form-hapus-poling-massal" method="post">
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-poling-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:right" class="row col-md-5">
					<div class="input-group">
					  <input value="<?php if(@$_GET['cari'])echo$_GET['cari'];?>" onblur="cari(this.value)" type="text" class="form-control square-btn-adjust" title="Cari poling">
					  <div class="input-group-btn">
					  	<a class="btn btn-default"><i class="fa fa-search"></i></a>
					    <a href="<?php echo site_url().'poling';?>" class="btn btn-default"><i class="fa fa-refresh"></i></a>
					  </div>
					</div>
				</div>
				<br />
			</div>
		</div>
		<div class="table-responsive">
			<!--tabel poling-->
			<table class="uk-table">
				<thead>
					<tr>
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox"></th>
						<th width="3%" class="md-bg-grey-100">No</th>
						<th class="md-bg-grey-100">Poling</th>
						<th width="25%" class="md-bg-grey-100">Pilihan</th>
						<th width="15%" class="md-bg-grey-100">Tanggal</th>
						<th colspan="2" width="5%" class="md-bg-grey-100">Aksi</th>
					</tr>
				</thead>
				<tbody id="tbody-tulisan">
				<?php if(@$data['poling']&&$data['error']==0){
					$no=$data['no']+1;
					foreach($data['poling'] as $row){
				?>
					<tr>
						<td>
							<input name="check_list[<?php echo$row['id_poling'];?>]" value="<?php echo$row['id_poling'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
						</td>
						<td><?php echo$no?></td>
						<td><?php echo$row['nama_poling']?></td>
						<td><ol><?php if(@$data['child'][$row['id_poling']]){
							$parent = '{';
							$k=0;
							foreach($data['child'][$row['id_poling']] as $row2){
								echo'<li><span id="tmp_smb_'.$row2['id_poling'].'">';
								if($row2['status_poling']=='open'){
								?>
								<a href="#" title="Sembunyikan" onclick="set_sembunyikan('<?php echo$row2['id_poling']?>')" class="text-warning">
									<i class="fa fa-eye"></i>
								</a>
								<?php }else{ ?>
								<a href="#" title="Tampilkan" onclick="set_tampilkan('<?php echo$row2['id_poling']?>')" class="text-warning">
									<i class="fa fa-eye-slash"></i>
								</a>
								<?php }?>
								</span>
								<a href="#" title="Hapus" onclick="set_delete({
									id:'<?php echo$row2['id_poling']?>',
									nm:'<?php echo$row2['nama_poling']?>'
									,act:'<?php echo site_url();?>poling/delpoling'
								})" data-toggle="modal" data-target=".bs-hapus-" class="text-danger">
								<i class="fa fa-trash-o"></i></a>
								<?php
									if(@$data['jml'][$row2['id_poling']][0]['jml']){echo'('.$data['jml'][$row2['id_poling']][0]['jml'].')';}else{echo'(0)';}
									echo'&nbsp;'.$row2['nama_poling'].'';
								echo'</li>';
								if($k==0){
									$parent .= $k.':{nm:\''.$row2['nama_poling'].'\',id:\''.$row2['id_poling'].'\'}';
								}else{
									$parent .= ','.$k.':{nm:\''.$row2['nama_poling'].'\',id:\''.$row2['id_poling'].'\'}';
								}
								$k++;
							}
							$parent .= '}';
						}else{
							$parent = '{}';
						}?></ol></td>
						<td><?php echo$row['tgl_poling']?></td>
						<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
						<td>
							<span id="tmp_smb_<?php echo$row['id_poling'];?>">
							<?php if($row['status_poling']=='open'){?>
							<a href="#" title="Sembunyikan" onclick="set_sembunyikan('<?php echo$row['id_poling']?>')" class="text-warning">
								<i class="fa fa-eye"></i>
							</a>
							<?php }else{ ?>
							<a href="#" title="Tampilkan" onclick="set_tampilkan('<?php echo$row['id_poling']?>')" class="text-warning">
								<i class="fa fa-eye-slash"></i>
							</a>
							<?php }?>
							</span>
						<br>
							<a href="#" title="Ubah" onclick="set_edit({
								id:'<?php echo$row['id_poling']?>'
								,nm:'<?php echo$row['nama_poling']?>'
								,prt:<?php echo$parent?>
							})" class="text-success"><i class="fa fa-pencil"></i>
							</a>
						</td>
						<td>
							<span id="bk_smb_<?php echo$row['id_poling'];?>">
							<?php if($row['status_poling_2']=='open'){?>
							<a href="#" title="Tutup" onclick="set_tutup('<?php echo$row['id_poling']?>')" class="text-primary">
								<i class="fa fa-check-circle"></i>
							</a>
							<?php }else{ ?>
							<a href="#" title="Buka" onclick="set_buka('<?php echo$row['id_poling']?>')" class="text-primary">
								<i class="fa fa-times-circle"></i>
							</a>
							<?php }?>
							</span>
						<br>
							<a href="#" title="Hapus" onclick="set_delete({
								id:'<?php echo$row['id_poling']?>',
								nm:'<?php echo$row['nama_poling']?>'
								,act:'<?php echo site_url();?>poling/delpoling'
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
						<td colspan="7">Data masih Kosong</td>
					</tr>
				<?php
				}?>
				</tbody>
				<tfoot>
					<tr>
						<th class="md-bg-grey-100"><input id="check-list-all-bawah" onclick="check_list_all_bawah()" type="checkbox"></th>
						<th class="md-bg-grey-100">No</th>
						<th class="md-bg-grey-100">Poling</th>
						<th class="md-bg-grey-100">Pilihan</th>
						<th class="md-bg-grey-100">Tanggal</th>
						<th colspan="2" class="md-bg-grey-100">Aksi</th>
					</tr>
				</tfoot>
			</table>
			<!--tabel poling end-->
		</div>
		<div class="block" style="margin-top:10px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-poling-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:left">
					<?php if(@$data['pagging'])echo$data['pagging'];?>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php if(@$data['total_rows'])echo$data['total_rows'];?></gedank> poling</i>
				</div>
			</div>
		</div>
		</form>
	</div>
	<!--daftar poling end-->
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
							<h3 id="modal_title" class="modal-title">Hapus poling</h3>
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

<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js');?>"></script>
<script type="text/javascript">
function tambah(){
	loop = eval($('#loop').val());
	row = '<div class="form-group pilihan2">'
			+'<div class="input-group">'
				+'<input type="hidden" name="id_pilihan['+loop+'2015]" value="'+loop+'2015" class="id-pilihan-hidden">'
				+'<input name="pilihan['+loop+'2015]" id="pilihan" type="text" class="form-control square-btn-adjust pilihan" title="Pilihan">'
				+'<span class="input-group-addon"><i class="fa fa-times" id="del-'+loop+'" onclick="del(this.id)"></i></span>'
			+'</div>'
		+'</div>';
	loop++;
	$('#loop').val(loop);
	$(row).insertBefore(".batas");
}
function del(data){
		$('#'+data).parent().parent().remove();
}
</script>
<script type="text/javascript">

$(document).ready(function(){
	$("#form-tambah-poling").validate({
	});
});


function form_tambah_poling_reset(){
	$('#id-poling').val('');
	$('#nama-poling').val('');
	$('#deskripsi-poling').val('');
	$('.pilihan').val('');
	$('.pilihan2').remove();
	$('.pilihan1').show();
	$('#loop').val('2');
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

function set_edit(data){
	form_tambah_poling_reset();
	console.log(data);
	$('#id-poling').val(data.id);
	$('#deskripsi-poling').val(data.nm);
	$('.pilihan1').hide();
	if(data.prt!=null){
		loop = 1;
		row = '';
		$.each(data.prt, function(i,n){
			row += '<div class="form-group pilihan2">'
				+'<input type="hidden" name="id_pilihan['+loop+']" value="'+n.id+'" class="id-pilihan-hidden">'
				+'<div class="input-group">'
					+'<input name="pilihan['+n.id+']" id="pilihan" type="text" class="form-control square-btn-adjust pilihan" title="Pilihan" value="'+n.nm+'">'
					+'<span class="input-group-addon"><i class="fa fa-times" id="del-'+loop+'e" onclick="del(this.id)"></i></span>'
				+'</div>'
			+'</div>';
			loop++;
		});
		$('#loop').val(loop);
		$(row).insertBefore(".batas");
	}

}
function set_delete(data){
	$('#id_del').val(data.id);
	$('#nama_del').html(data.nm);
	$('#form_action_del').attr('action',data.act);
}
function set_tampilkan(id){
	$.ajax({
        'url': '<?php echo site_url("poling/tampilkan/'+id+'")?>',
        'dataType': 'json',
        success: function(data){
        	console.log(data);
            if(data.psn!=null){
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                $('#tmp_smb_'+id).html('<a href="#" title="Sembunyikan" onclick="set_sembunyikan('+id+')" class="text-warning"><i class="fa fa-eye"></i></a>');
            }else{
                alertify.error('ERROR!');
            }
        }
    });
}
function set_sembunyikan(id){
	$.ajax({
        'url': '<?php echo site_url("poling/sembunyikan/'+id+'")?>',
        'dataType': 'json',
        success: function(data){
        	console.log(data);
            if(data.psn!=null){
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                $('#tmp_smb_'+id).html('<a href="#" title="Tampilkan" onclick="set_tampilkan('+id+')" class="text-warning"><i class="fa fa-eye-slash"></i></a>');
            }else{
                alertify.error('ERROR!');
            }
        }
    });
}

function set_buka(id){
	$.ajax({
        'url': '<?php echo site_url("poling/buka/'+id+'")?>',
        'dataType': 'json',
        success: function(data){
        	console.log(data);
            if(data.psn!=null){
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                $('#bk_smb_'+id).html('<a href="#" title="Tutup" onclick="set_tutup('+id+')" class="text-primary"><i class="fa fa-check-circle"></i></a>');
            }else{
                alertify.error('ERROR!');
            }
        }
    });
}
function set_tutup(id){
	$.ajax({
        'url': '<?php echo site_url("poling/tutup/'+id+'")?>',
        'dataType': 'json',
        success: function(data){
        	console.log(data);
            if(data.psn!=null){
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                $('#bk_smb_'+id).html('<a href="#" title="Buka" onclick="set_buka('+id+')" class="text-primary"><i class="fa fa-times-circle"></i></a>');
            }else{
                alertify.error('ERROR!');
            }
        }
    });
}
function cari(val){
	window.location.assign("<?php echo site_url()?>poling?cari="+val)
}
</script>
<?php
$success = $this->session->flashdata('success'); if (!empty($success)){?><script>$(document).ready(function(){ var notification = alertify.notify('<?php echo$success;?>', 'success', 5, function(){});});</script><?php }
$warning = $this->session->flashdata('warning'); if (!empty($warning)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$warning;?>', 'warning', 5, function(){});});</script><?php }
$danger = $this->session->flashdata('danger'); if (!empty($danger)){?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$danger;?>', 'danger', 5, function(){});});</script><?php }
?>