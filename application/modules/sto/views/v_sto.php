<div class="uk-grid">
                <div class="uk-width-1-1">
                    <div class="md-card">
                        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                <i class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</i>
                                <?php //if(@$tombol)echo$tombol;?>
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                                <?php if(isset($site['page'])){echo$site['page'];}else{echo'page';}?>
                            </h3>
                        </div>
                        <div class="md-card-content">
                            <div class="mGraph-wrapper">
<div class="row">
	<div class="col-lg-12">
		<form action="<?php echo site_url();?>sto/delstomassal" name="form_hapus_sto_massal" id="form-hapus-sto-massal" method="post">
		<ul class="uk-tab">
			<?php if($this->uri->segment(2)==''or$this->uri->segment(2)=='sto'){?>
				<li class="uk-active"><a href="#">Semua (<?php if(@$data['total_rows_1'][0]['total']){echo$data['total_rows_1'][0]['total'];}else{echo'0';}?>)</a></li>
			<?php }else{ ?>
				<li class=""><a href="<?php echo site_url(); ?>sto/sto">Semua (<?php if(@$data['total_rows_1'][0]['total']){echo$data['total_rows_1'][0]['total'];}else{echo'0';}?>)</a></li>
			<?php }?>

			<?php if($this->uri->segment(2)=='block'){?>
				<li class="uk-active"><a href="#">Block (<?php if(@$data['total_rows_5'][0]['total']){echo$data['total_rows_5'][0]['total'];}else{echo'0';}?>)</a></li>
			<?php }else{ ?>
				<li class=""><a href="<?php echo site_url(); ?>sto/block">Block (<?php if(@$data['total_rows_5'][0]['total']){echo$data['total_rows_5'][0]['total'];}else{echo'0';}?>)</a></li>
			<?php }?> 
		</ul>
        <br>
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-4">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" id="aksi-tindakan-massal-atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<?php if($this->uri->segment(2)!='block'){?>
							<option value="hps">Block</option>
							<?php }else{?>
							<option value="kmbl">Aktifkan</option>
							<option value="hps_p">Hapus permanen</option>
							<?php }?>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-sto-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:right" class="row col-md-4">
					<div class="input-group">
					  <input value="<?php if(@$_GET['cari'])echo$_GET['cari'];?>" onblur="cari(this.value)" type="text" class="form-control square-btn-adjust" title="Cari sto">
					  <div class="input-group-btn">
					  	<a class="btn btn-default"><i class="fa fa-search"></i></a>
					    <a href="<?php echo site_url().'sto';?>" class="btn btn-default"><i class="fa fa-refresh"></i></a>
					  </div>
					</div>
				</div>
				<br />
			</div>
		</div>
		<div class="table-responsive">
			<!--tabel sto-->
			<table class="uk-table">
				<thead>
					<tr>
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox"></th>
						<th class="md-bg-grey-100"></th>
						<th class="md-bg-grey-100">Nama</th>
						<th class="md-bg-grey-100">NIP</th>
						<th class="md-bg-grey-100">Email</th>
						<th class="md-bg-grey-100">Tempat, Tgl Lahir</th>
						<th class="md-bg-grey-100">Jabatan</th>
						<th class="md-bg-grey-100">Pangkat / Golongan</th>
						<th class="md-bg-grey-100">Pendidikan</th>
						<th colspan="3" width="5%" class="md-bg-grey-100">Aksi</th>
					</tr>
				</thead>
				<tbody id="tbody-sto">
					<?php if(@$data['sto']&&$data['error']==0){
					$no=$data['no']+1;
					foreach($data['sto'] as $row){
					?>
					<tr>
						<td>
							<input name="check_list[<?php echo$row['id_sto'];?>]" value="<?php echo$row['id_sto'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
						</td>
						<td><img src="<?php if($row['foto']!=''){echo base_url('assets/img/img_andalan/thumb').'/'.$row['foto'];}?>" style="width:30px;height:30px" alt="  "></td>
						<td><?php echo$row['nm_dp'].' '.$row['nm_blk']?></td>
						<td><?php echo$row['nip']?></td>
						<td><?php echo$row['email']?></td>
						<td><?php echo$row['kota_lahir']?>, <?php echo$row['tgl_lahir']?></td>
						<td><?php echo$row['jabatan']?></td>
						<td><?php echo$row['pangkat']?></td>
						<td><?php echo$row['pendidikan']?></td>
						<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
						<td id="tmp_smb_<?php echo$row['id_sto'];?>">
							<?php if($row['status_sto']=='aktif'){?>
							<a href="#" title="Block" onclick="set_sembunyikan('<?php echo$row['id_sto']?>')" class="text-warning">
								<i class="fa fa-eye"></i>
							</a>
							<?php }else{ ?>
							<a href="#" title="Aktifkan" onclick="set_tampilkan('<?php echo$row['id_sto']?>')" class="text-warning">
								<i class="fa fa-eye-slash"></i>
							</a>
							<?php }?>
						</td>
						<td><a href="<?php echo site_url().'sto/sunting?id='.$row['id_sto'];?>" title="Ubah" class="text-success">
							<i class="fa fa-pencil"></i></a>
						</td>
						<td><a href="#" title="Hapus" onclick="set_delete({
								id:'<?php echo$row['id_sto']?>',
								nm:'<?php echo$row['nm_dp']?>'
								,act:'<?php echo site_url();?>sto/delsto'
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
						<td colspan="9">Data masih Kosong</td>
					</tr>
				<?php
				}?>
				</tbody>
				<tfoot>
					<tr>
						<th class="md-bg-grey-100"><input id="check-list-all-bawah" onclick="check_list_all_bawah()" type="checkbox"></th>
						<th class="md-bg-grey-100"></th>
						<th class="md-bg-grey-100">Nama</th>
						<th class="md-bg-grey-100">NIP</th>
						<th class="md-bg-grey-100">Email</th>
						<th class="md-bg-grey-100">Tempat, Tgl Lahir</th>
						<th class="md-bg-grey-100">Jabatan</th>
						<th class="md-bg-grey-100">Pangkat / Golongan</th>
						<th class="md-bg-grey-100">Pendidikan</th>
						<th colspan="3" class="md-bg-grey-100">Aksi</th>
					</tr>
				</tfoot>
			</table>
			<!--tabel sto end-->
		</div>
		<div class="block" style="margin-top:10px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-4">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" id="aksi-tindakan-massal-bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<?php if($this->uri->segment(2)!='block'){?>
							<option value="hps">Block</option>
							<?php }else{?>
							<option value="kmbl">Aktifkan</option>
							<option value="hps_p">Hapus permanen</option>
							<?php }?>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-sto-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:left">
					<?php if(@$data['pagging'])echo$data['pagging'];?>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php if(@$data['total_rows'])echo$data['total_rows'];?></gedank> sto</i>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
				</div>
                <div class="md-card-fullscreen-content">
                    <div class="uk-overflow-container">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="md-fab-wrapper">
    <a href="<?php echo site_url('sto/baru');?>" id="btn-tambah-testimoni-baru" class="md-fab md-fab-accent">
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
							<h3 id="modal_title" class="modal-title">Hapus sto</h3>
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
<script>
function set_delete(data){
	$('#id_del').val(data.id);
	$('#nama_del').html(data.nm);
	$('#form_action_del').attr('action',data.act);
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#induk-level').on('change', function(){
		$.ajax({
	        'type': 'POST',
	        'url': '<?php echo site_url("sto/getsto");?>',
	        'dataType': 'json',
	        'data': 'id_level='+$('#induk-level').val()+'&cari_sto='+$('#cari-sto').val(),
	        success: function(data){
	        	//console.log(data);
	        	if(data.data!=null){
		    		isi(data.data);
		    	}
	        }
	    });
	});
});

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

function level_link(id){
	var semua = "<?php echo $this->uri->segment(2);?>";
	$('#pagging').val('0,10');
	$.ajax({
        'type': 'POST',
        'url': '<?php echo site_url("sto/getsto");?>',
        'dataType': 'json',
        'data': 'cari_sto='+$('#cari-sto').val()+'&id_level='+$('#induk-level').val()+'&pagging='+$('#pagging').val(),
        success: function(data){
        	//console.log(data);
        	if(data.data!=null){
				isi(data.data);
				pagging=$('#pagging').val().split(',');
				pag1 = eval(pagging[0]);
				pag2 = eval(pagging[1]);
        		$('#pagging').val(pag1+','+pag2);
        		$('#prev').addClass('disabled');
        		if(semua=='administrator'){
					semua=data.data.tab_action.administrator;
				}else if(semua=='editor'){
					semua=data.tab_action.editor;
				}else if(semua=='user'){
					semua=data.data.tab_action.user;
				}else if(semua=='block'){
					semua=data.data.tab_action.block;
				}else if(semua==''){
					semua=data.data.tab_action.semua;
				}
        		if(semua<pag1 || semua<=pag2){
        			$('#next').addClass('disabled');
        		}
        		jml_pg=eval(semua) / eval(pag2);
        		pagging='';
        		for(m=1;m<=Math.ceil(jml_pg);m++){
					pagging+='<li><a onclick="setpage(\''+m+'\',\''+((eval(m)-1)*pag2)+','+pag2+'\')">'+m+'</a></li>';
				}
        		$('.pagging').html(pagging);
			}
        }
    });
    $('#induk-level option[value='+id+']').prop('selected', true);
}

function isi_lev(data){
	if(data.error==0){
		var url='<?php echo site_url(); ?>';
		select_level = '<select id="induk-level" name="induk_level" class="form-control square-btn-adjust auto-width" title="Induk level">'
		select_level += '<option value="0">Lihat seluruh level</option>';
	    $.each(data.level, function(i,n){
			select_level += '<option value="'+n['id_level']
			+'">'+n['level']
			+'</option>';
	    });
	    select_level += '</select>';
	    $("#induk-level").html(select_level);
	}
}

function set_sembunyikan(id){
	$.ajax({
        'url': '<?php echo site_url("sto/sembunyikan/'+id+'")?>',
        'dataType': 'json',
        success: function(data){
        	console.log(data);
            if(data.psn!=null){
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                $('#tmp_smb_'+id).html('<a href="#" title="Aktifkan" onclick="set_tampilkan('+id+')"><i class="fa fa-eye-slash"></i></a>');
            }else{
                alertify.error('ERROR!');
            }
        }
    });
}
function set_tampilkan(id){
	$.ajax({
        'url': '<?php echo site_url("sto/tampilkan/'+id+'")?>',
        'dataType': 'json',
        success: function(data){
        	console.log(data);
            if(data.psn!=null){
                var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                $('#tmp_smb_'+id).html('<a href="#" title="Block" onclick="set_sembunyikan('+id+')"><i class="fa fa-eye"></i></a>');
            }else{
                alertify.error('ERROR!');
            }
        }
    });
}

function cari(val){
	window.location.assign("<?php echo site_url()?>sto/<?php echo $this->uri->segment(2)?>?cari="+val)
}
</script>

<?php
$success = $this->session->flashdata('success'); if (!empty($success)){ ?><script>$(document).ready(function(){ var notification = alertify.notify('<?php echo$success;?>', 'success', 5, function(){});});</script><?php }
$warning = $this->session->flashdata('warning'); if (!empty($warning)){ ?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$warning;?>', 'warning', 5, function(){});});</script><?php }
$danger = $this->session->flashdata('danger'); if (!empty($danger)){ ?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$danger;?>', 'danger', 5, function(){});});</script><?php }
?>