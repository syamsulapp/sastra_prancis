<?php
$op_widget = array(
	'1'=>'1. Berita',
	'2'=>'2. Pengumuman',
	'3'=>'3. Agenda',
	'4'=>'4. Album',
	'5'=>'5. Ebook',
	'6'=>'6. Layanan Informasi',
	'7'=>'7. Buku Tamu',
	'8'=>'8. Poling',
	'9'=>'9. Statistik Pengunjung',
	/*'10'=>'10. Komoditas Pertanian',*/
	'11'=>'11. Text area',
	'12'=>'12. Kepala Dinas',
	'13'=>'13. Link / Tautan',
	'14'=>'14. Link 2 / Tautan 2',
	'15'=>'15. Kategori'
);
?>
<div class="row">
	<!--widget baru-->
	<div class="col-lg-4">
		<form action="<?php echo site_url();?>tampilan/addwidget" name="form_tambah_widget" id="form-tambah-widget" method="post">
			<input name="id_widget" id="id-widget" type="hidden">
			<div class="form-group">
				<label>Posisi widget</label>
				<div class="radio">
					<label>
						<input name="posisi_widget" type="radio" id="posisi-widget-1" value="kiri" checked data-original-title="" title="Sidebar Kiri">
						<i class="berita-tanggal fa fa-arrow-left"></i> Sidebar Kiri
					</label>
				</div>
				<div class="radio">
					<label>
						<input name="posisi_widget" type="radio" id="posisi-widget-2" value="kanan" data-original-title="" title="Sidebar Kanan">
						<i class="berita-tanggal fa fa-arrow-right"></i> Sidebar Kanan
					</label>
				</div>
				<div class="radio">
					<label>
						<input name="posisi_widget" type="radio" id="posisi-widget-3" value="bawah" data-original-title="" title="Sidebar Bawah">
						<i class="berita-tanggal fa fa-arrow-down"></i> Sidebar Bawah
					</label>
				</div>
			</div>
			<div class="form-group">
				<labl>Nama Widget</label>
				<input id="nama-widget" name="nama_widget" type="text" class="form-control square-btn-adjust" title="Nama Widget">
			</div>
			<div class="form-group">
				<label>Widget</label>
				<?php echo form_dropdown('widget',$op_widget,null,'class="form-control square-btn-adjust" id="widget" onchange="set_area(this.value);"')?>
			</div>
			<div class="form-group" id="textarea" style="display:none;">
				<label>Text</label>
				<textarea rows="5" id="content-widget" name="content_widget" class="form-control square-btn-adjust tinymce_komentar"></textarea>
			</div>
			<div class="form-group" id="jumlah">
				<label>Jumlah</label>
				<input id="jml-widget" name="jml_widget" type="text" class="form-control square-btn-adjust" title="Jumlah" onKeyPress="return angkadanhuruf(event,'1234567890',this)">
			</div>
			<div class="form-group">
				<button type="reset" class="md-btn md-btn-default btn-sm square-btn-adjust" title="Batal/Reset Form" onclick="form_tambah_widget_reset()"><li class="fa fa-times"></li> Batal</button>
				<button type="submit" class="md-btn md-btn-primary btn-sm square-btn-adjust" title="Tambah widget baru"><li class="fa fa-save"></li> Tambah widget Baru</button>
			</div>
		</form>
	</div>
	<!--widget baru end-->

	<!--daftar widget-->
	<div class="col-lg-8" style="border-left:1px solid #f0f0f0;">
		<h3>Widget Kiri</h3>
		<form action="<?php echo site_url();?>tampilan/delwidgetmassal" name="form_hapus_widget_massal" id="form-hapus-widget-massal" method="post">
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-widget-massal');">Terapkan</span>
					</div>
				</div>
				<br />
			</div>
		</div>
		<div class="table-responsive">
			<!--tabel widget-->
			<table class="uk-table">
				<thead>
					<tr>
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox"></th>
						<th class="md-bg-grey-100">Nama Widget</th>
						<th class="md-bg-grey-100">Widget</th>
						<th width="3%" colspan="2" class="md-bg-grey-100">Aksi</th>
						<th width="3%" colspan="2" class="md-bg-grey-100"></th>
					</tr>
				</thead>
				<tbody id="tbody-widget">
					<?php $no = 1; if(@$data1['data']&&$data1['error']==0){
						$jml = count($data1['data']);
						$i = 1;
						$urutan[0] = 0;
						foreach($data1['data'] as $row){
							$urutan[$i] = $row['id_widget'];
							$i++;
						}
						$urutan[$i] = 0;
						foreach($data1['data'] as $row){
						?>
						<tr>
							<td>
								<input name="check_list[<?php echo$row['id_widget'];?>]" value="<?php echo$row['id_widget'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
							</td>
							<td><?php echo$row['nama_widget'];?></td>
							<td><?php echo $op_widget[$row['widget']];?></td>
							<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
							<td>
								<a href="#" onclick="set_edit('<?php echo$row['id_widget']?>')" class="text-success">
								<i class="fa fa-pencil"></i>
								</a>
							</td>
							<td><a href="#" title="Hapus" onclick="set_delete({
									id:'<?php echo$row['id_widget']?>',
									nm:'<?php echo$row['nama_widget']?>'
									,act:'<?php echo site_url();?>tampilan/delwidget'
								})" data-toggle="modal" data-target=".bs-hapus-" class="text-danger">
								<i class="fa fa-trash-o"></i></a>
							</td>
							<td>
								<?php if($no!=1){?>
								<a href="<?php echo site_url('tampilan/dragwidget/'.$urutan[$no-1].'/'.$urutan[$no])?>" class="text-primary"><i class="fa fa-arrow-up"></i></a>
								<?php }?>
							</td>
							<td>
								<?php if($no!=$jml){?>
								<a href="<?php echo site_url('tampilan/dragwidget/'.$urutan[$no].'/'.$urutan[$no+1])?>" class="text-primary"><i class="fa fa-arrow-down"></i></a>
								<?php }?>
							</td>
							<?php }?>
						</tr>
						<?php
						$no++;
						}
					}else{
					?>
						<tr>
							<td colspan="8">Data masih Kosong</td>
						</tr>
					<?php
					}?>
				</tbody>
				<tfoot>
					<tr>
						<th class="md-bg-grey-100"><input id="check-list-all-bawah" onclick="check_list_all_bawah()" type="checkbox"></th>
						<th class="md-bg-grey-100">Nama widget</th>
						<th class="md-bg-grey-100">Widget</th>
						<th colspan="2" class="md-bg-grey-100">Aksi</th>
						<th colspan="2" class="md-bg-grey-100"></th>
					</tr>
				</tfoot>
			</table>
			<!--tabel widget end-->
		</div>
		<div class="block" style="margin-bottom:30px;margin-top:10px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-widget-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php echo $no-1;?></gedank> widget</i>
				</div>
			</div>
		</div>
		</form>

		<br>
		<h3>Widget Kanan</h3>
		<form action="<?php echo site_url();?>tampilan/delwidgetmassal" name="form_hapus_widget_massal" id="form-hapus-widget-massal2" method="post">
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-widget-massal2');">Terapkan</span>
					</div>
				</div>
				<br />
			</div>
		</div>
		<div class="table-responsive">
			<!--tabel widget-->
			<table class="uk-table">
				<thead>
					<tr>
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas-2" onclick="check_list_all_atas_2()" type="checkbox"></th>
						<th class="md-bg-grey-100">Nama Widget</th>
						<th class="md-bg-grey-100">Widget</th>
						<th width="3%" colspan="2" class="md-bg-grey-100">Aksi</th>
						<th width="3%" colspan="2" class="md-bg-grey-100"></th>
					</tr>
				</thead>
				<tbody id="tbody-widget">
					<?php $no = 1; if(@$data2['data']&&$data2['error']==0){
						$i = 1;
						$urutan2[0] = 0;
						foreach($data2['data'] as $row){
							$urutan2[$i] = $row['id_widget'];
							$i++;
						}
						$urutan2[$i] = 0;
						$jml = count($data2['data']);
						foreach($data2['data'] as $row){
						?>
						<tr>
							<td>
								<input name="check_list[<?php echo$row['id_widget'];?>]" value="<?php echo$row['id_widget'];?>" id="check-list-<?php echo$no;?>" class="check-list-2" type="checkbox">
							</td>
							<td><?php echo$row['nama_widget'];?></td>
							<td><?php echo $op_widget[$row['widget']];?></td>
							<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
							<td>
								<a href="#" onclick="set_edit('<?php echo$row['id_widget']?>')" class="text-success">
								<i class="fa fa-pencil"></i>
								</a>
							</td>
							<td><a href="#" title="Hapus" onclick="set_delete({
									id:'<?php echo$row['id_widget']?>',
									nm:'<?php echo$row['nama_widget']?>'
									,act:'<?php echo site_url();?>tampilan/delwidget'
								})" data-toggle="modal" data-target=".bs-hapus-" class="text-danger">
								<i class="fa fa-trash-o"></i></a>
							</td>
							<td>
								<?php if($no!=1){?>
								<a href="<?php echo site_url('tampilan/dragwidget/'.$urutan2[$no-1].'/'.$urutan2[$no])?>" class="text-primary"><i class="fa fa-arrow-up"></i></a>
								<?php }?>
							</td>
							<td>
								<?php if($no!=$jml){?>
								<a href="<?php echo site_url('tampilan/dragwidget/'.$urutan2[$no].'/'.$urutan2[$no+1])?>" class="text-primary"><i class="fa fa-arrow-down"></i></a>
								<?php }?>
							</td>
							<?php }?>
						</tr>
						<?php
						$no++;
						}
					}else{
					?>
						<tr>
							<td colspan="8">Data masih Kosong</td>
						</tr>
					<?php
					}?>
				</tbody>
				<tfoot>
					<tr>
						<th class="md-bg-grey-100"><input id="check-list-all-bawah-2" onclick="check_list_all_bawah_2()" type="checkbox"></th>
						<th class="md-bg-grey-100">Nama widget</th>
						<th class="md-bg-grey-100">Widget</th>
						<th colspan="2" class="md-bg-grey-100">Aksi</th>
						<th colspan="2" class="md-bg-grey-100"></th>
					</tr>
				</tfoot>
			</table>
			<!--tabel widget end-->
		</div>
		<div class="block" style="margin-bottom:30px;margin-top:10px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-widget-massal2');">Terapkan</span>
					</div>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php echo $no-1;?></gedank> widget</i>
				</div>
			</div>
		</div>
		</form>

		<br>
		<h3>Widget Bawah</h3>
		<form action="<?php echo site_url();?>tampilan/delwidgetmassal" name="form_hapus_widget_massal" id="form-hapus-widget-massal3" method="post">
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-widget-massal3');">Terapkan</span>
					</div>
				</div>
				<br />
			</div>
		</div>
		<div class="table-responsive">
			<!--tabel widget-->
			<table class="uk-table">
				<thead>
					<tr>
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas-3" onclick="check_list_all_atas_3()" type="checkbox"></th>
						<th class="md-bg-grey-100">Nama Widget</th>
						<th class="md-bg-grey-100">Widget</th>
						<th width="3%" colspan="2" class="md-bg-grey-100">Aksi</th>
						<th width="3%" colspan="2" class="md-bg-grey-100"></th>
					</tr>
				</thead>
				<tbody id="tbody-widget">
					<?php $no = 1; if(@$data3['data']&&$data3['error']==0){
						$i = 1;
						$urutan3[0] = 0;
						foreach($data3['data'] as $row){
							$urutan3[$i] = $row['id_widget'];
							$i++;
						}
						$urutan3[$i] = 0;
						$jml = count($data3['data']);
						foreach($data3['data'] as $row){
						?>
						<tr>
							<td>
								<input name="check_list[<?php echo$row['id_widget'];?>]" value="<?php echo$row['id_widget'];?>" id="check-list-<?php echo$no;?>" class="check-list-3" type="checkbox">
							</td>
							<td><?php echo$row['nama_widget'];?></td>
							<td><?php echo $op_widget[$row['widget']];?></td>
							<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
							<td>
								<a href="#" onclick="set_edit('<?php echo$row['id_widget']?>')" class="text-success">
								<i class="fa fa-pencil"></i>
								</a>
							</td>
							<td><a href="#" title="Hapus" onclick="set_delete({
									id:'<?php echo$row['id_widget']?>',
									nm:'<?php echo$row['nama_widget']?>'
									,act:'<?php echo site_url();?>tampilan/delwidget'
								})" data-toggle="modal" data-target=".bs-hapus-" class="text-danger">
								<i class="fa fa-trash-o"></i></a>
							</td>
							<td>
								<?php if($no!=1){?>
								<a href="<?php echo site_url('tampilan/dragwidget/'.$urutan3[$no-1].'/'.$urutan3[$no])?>" class="text-primary"><i class="fa fa-arrow-up"></i></a>
								<?php }?>
							</td>
							<td>
								<?php if($no!=$jml){?>
								<a href="<?php echo site_url('tampilan/dragwidget/'.$urutan3[$no].'/'.$urutan3[$no+1])?>" class="text-primary"><i class="fa fa-arrow-down"></i></a>
								<?php }?>
							</td>
							<?php }?>
						</tr>
						<?php
						$no++;
						}
					}else{
					?>
						<tr>
							<td colspan="8">Data masih Kosong</td>
						</tr>
					<?php
					}?>
				</tbody>
				<tfoot>
					<tr>
						<th class="md-bg-grey-100"><input id="check-list-all-bawah-3" onclick="check_list_all_bawah_3()" type="checkbox"></th>
						<th class="md-bg-grey-100">Nama widget</th>
						<th class="md-bg-grey-100">Widget</th>
						<th colspan="2" class="md-bg-grey-100">Aksi</th>
						<th colspan="2" class="md-bg-grey-100"></th>
					</tr>
				</tfoot>
			</table>
			<!--tabel widget end-->
		</div>
		<div class="block" style="margin-bottom:30px;margin-top:10px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-widget-massal3');">Terapkan</span>
					</div>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php echo $no-1;?></gedank> widget</i>
				</div>
			</div>
		</div>
		</form>
	</div>
	<!--daftar widget end-->
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
							<h3 id="modal_title" class="modal-title">Hapus widget</h3>
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
    form_tambah_widget_reset();
});

$(document).ready(function(){
});

function form_tambah_widget_reset(){
	$('#id-widget').val('');
	$('#nama-widget').val('');
	$('#content-widget').val('');
	$('#jml-widget').val('');
}

function set_area(val){
	if(val==11){
		$('#textarea').show();
		$('#jumlah').hide();
		$('#jml-widget').val('');
	}else if(val==1||val==2||val==3||val==4||val==5||val==7||val==13||val==14||val==15||val==16){
		$('#jumlah').show();
		$('#textarea').hide();
		$('#content-widget').val('');
	}else{
		$('#jumlah').hide();
		$('#textarea').hide();
		$('#jml-widget').val('');
		$('#content-widget').val('');
	}
}

function set_edit(id){
	$.ajax({
        'url': '<?php echo site_url("tampilan/getwidget/'+id+'");?>',
        'dataType': 'json',
        'success': function(data){
        	console.log(data);
        	$.each(data, function(i,n){
	        	$('#id-widget').val(n.id_widget);
				if(n.posisi_widget=='kiri'){
					$('#posisi-widget-1').prop('checked', true);
				}else if(n.posisi_widget=='kanan'){
					$('#posisi-widget-2').prop('checked', true);
				}else if(n.posisi_widget=='bawah'){
					$('#posisi-widget-3').prop('checked', true);
				}
				$('#nama-widget').val(n.nama_widget);
				$('#widget').val(n.widget);
				if(n.widget=='11'){
					$('#jumlah').hide();
					$('#jml-widget').val('');
					$('#textarea').show();
					$('#content-widget').val(n.content_widget);
				}else if(n.widget=='1'||n.widget=='2'||n.widget=='3'||n.widget=='4'||n.widget=='5'||n.widget=='7'||n.widget=='13'||n.widget=='14'||n.widget=='15'||n.widget=='16'){
					$('#jumlah').show();
					$('#jml-widget').val(n.content_widget);
					$('#textarea').hide();
					$('#content-widget').val('');
				}else{
					$('#jumlah').hide();
					$('#jml-widget').val('');
					$('#textarea').hide();
					$('#content-widget').val('');
				}
			});
        }
    });
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
function check_list_all_atas_2(){
	if(document.getElementById('check-list-all-atas-2').checked==true){
		$('.check-list-2').prop('checked', true);
		$('#check-list-all-bawah-2').prop('checked', true);
	}else{
		$('.check-list-2').prop('checked', false);
		$('#check-list-all-bawah-2').prop('checked', false);
	}
}
function check_list_all_bawah_2(){
	if(document.getElementById('check-list-all-bawah-2').checked==true){
		$('.check-list-2').prop('checked', true);
		$('#check-list-all-atas-2').prop('checked', true);
	}else{
		$('.check-list-2').prop('checked', false);
		$('#check-list-all-atas-2').prop('checked', false);
	}
}
function check_list_all_atas_3(){
	if(document.getElementById('check-list-all-atas-3').checked==true){
		$('.check-list-3').prop('checked', true);
		$('#check-list-all-bawah-3').prop('checked', true);
	}else{
		$('.check-list-3').prop('checked', false);
		$('#check-list-all-bawah-3').prop('checked', false);
	}
}
function check_list_all_bawah_3(){
	if(document.getElementById('check-list-all-bawah-3').checked==true){
		$('.check-list-3').prop('checked', true);
		$('#check-list-all-atas-3').prop('checked', true);
	}else{
		$('.check-list-3').prop('checked', false);
		$('#check-list-all-atas-3').prop('checked', false);
	}
}
</script>

<script language="javascript">
function getkey(e){
    if (window.event)
        return window.event.keyCode;
    else if (e)
        return e.which;
    else
        return null;
}

function angkadanhuruf(e, goods, field){
    var angka, karakterangka;
    angka = getkey(e);
    if (angka == null) return true;  
    karakterangka = String.fromCharCode(angka);
    karakterangka = karakterangka.toLowerCase();
    goods = goods.toLowerCase();
    if (goods.indexOf(karakterangka) != -1)
        return true;
        if ( angka==null || angka==0 || angka==8 || angka==9 || angka==27 )
            return true;
        if (angka == 13){
            var i;
            for (i = 0; i < field.form.elements.length; i++)
            if (field == field.form.elements[i])
                break;
            i = (i + 1) % field.form.elements.length;
            field.form.elements[i].focus();
            return false;
        };
    return false;
}
</script>

<?php
  include(APPPATH.'modules/template/ambil_gambar.php');
?>