<div class="row">
	<!--banner baru-->
	<div class="col-lg-4">
		<form action="<?php echo site_url();?>tampilan/addbanner" name="form_tambah_banner" id="form-tambah-banner" method="post">
			<input name="id_banner" id="id-banner" type="hidden">
			<div class="form-group">
				<label>Icon banner (url)</label>
				<div class="input-group">
					<input id="icon-banner" name="icon_banner" type="text" class="form-control square-btn-adjust" title="Icon banner" onclick="ambil_gambar_form_web('icon-banner,')">
					<span class="input-group-addon"><i class="fa fa-picture-o" id="btn-gambar-pilih" onclick="ambil_gambar_form_web('icon-banner,')"></i></span>
				</div>
			</div>
			<div class="form-group">
				<label>http://</label>
				<input id="url-menu" name="url_menu" type="text" class="form-control square-btn-adjust" title="Url" onKeyPress="return angkadanhuruf(event,'abcdefghijklmnopqrstuvwxyz./?&#_-1234567890=',this)">
			</div>
			<div class="form-group">
				<label>Posisi Banner</label>
				<div class="radio">
					<label>
						<input name="posisi_banner" type="radio" id="posisi-banner-1" value="utama" checked data-original-title="" title="">
						<i class="berita-tanggal fa fa-expand"></i> Halaman Utama *lebar gambar maks 978px
					</label>
				</div>
				<div class="radio">
					<label>
						<input name="posisi_banner" type="radio" id="posisi-banner-2" value="tulisan" data-original-title="" title="">
						<i class="berita-tanggal fa fa-arrow-up"></i> Halaman Tulisan *lebar gambar maks 225px
					</label>
				</div>
				<div class="radio">
					<label>
						<input name="posisi_banner" type="radio" id="posisi-banner-3" value="halaman" data-original-title="" title="">
						<i class="berita-tanggal fa fa-arrow-down"></i> Setiap Halaman *lebar gambar maks 225px
					</label>
				</div>
			</div>
			<div class="form-group">
				<button type="reset" class="md-btn md-btn-default btn-sm square-btn-adjust" title="Batal/Reset Form" onclick="form_tambah_banner_reset()"><li class="fa fa-times"></li> Batal</button>
				<button type="submit" class="md-btn md-btn-primary btn-sm square-btn-adjust" title="Tambah banner baru"><li class="fa fa-save"></li> Tambah Banner Baru</button>
			</div>
		</form>
	</div>
	<!--banner baru end-->

	<!--daftar banner-->
	<div class="col-lg-8" style="border-left:1px solid #f0f0f0;">
		<form action="<?php echo site_url();?>tampilan/delbannermassal" name="form_hapus_banner_massal" id="form-hapus-banner-massal" method="post">
		<div class="block" style="margin-bottom:30px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-banner-massal');">Terapkan</span>
					</div>
				</div>
				<br />
			</div>
		</div>
		<div class="table-responsive">
			<!--tabel banner-->
			<table class="uk-table">
				<thead>
					<tr>
						<th width="3%" class="md-bg-grey-100"><input id="check-list-all-atas" onclick="check_list_all_atas()" type="checkbox"></th>
						<th class="md-bg-grey-100">Banner</th>
						<th width="25%" class="md-bg-grey-100">url</th>
						<th width="20%" class="md-bg-grey-100">Posisi</th>
						<th width="3%" colspan="2" class="md-bg-grey-100">Aksi</th>
					</tr>
				</thead>
				<tbody id="tbody-banner">
					<?php if(@$data['banner']&&$data['error']==0){
						$no=$data['no']+1;
						foreach($data['banner'] as $row){
					?>
						<tr>
							<td>
								<input name="check_list[<?php echo$row['id_banner'];?>]" value="<?php echo$row['id_banner'];?>" id="check-list-<?php echo$no;?>" class="check-list" type="checkbox">
							</td>
							<td><img src="<?php echo base_url('assets/img/img_andalan').'/'.$row['gambar']?>" style="width:100%;"></td>
							<td><?php echo$row['slug']?></td>
							<td><?php echo$row['posisi']?></td>
							<?php if($this->session->userdata('level')=='administrator'||$this->session->userdata('level')=='editor'){?>
							<td>
								<a href="#" onclick="set_edit({
									id:'<?php echo$row['id_banner']?>'
									,posisi:'<?php echo$row['posisi']?>'
									,icon:'<?php echo$row['gambar']?>'
									,slug:'<?php echo$row['slug']?>'
								})" class="text-success"><i class="fa fa-pencil"></i>
								</a>
							</td>
							<td><a href="#" title="Hapus" onclick="set_delete({
									id:'<?php echo$row['id_banner']?>',
									nm:'<?php echo base_url('assets/img/img_andalan').'/'.$row['gambar']?>'
									,act:'<?php echo site_url();?>tampilan/delbanner'
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
						<th class="md-bg-grey-100">Banner</th>
						<th class="md-bg-grey-100">url</th>
						<th class="md-bg-grey-100">Posisi</th>
						<th colspan="2" class="md-bg-grey-100">Aksi</th>
					</tr>
				</tfoot>
			</table>
			<!--tabel banner end-->
		</div>
		<div class="block" style="margin-top:10px;">
			<div class="form-group">
				<div style="float:left" class="row col-md-5">
					<div class="input-group">
						<select name="aksi_tindakan_massal_bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
							<option>Tindakan Massal</option>
							<option value="hps">Hapus</option>
						</select>
						<span class="btn btn-default square-btn-adjust input-group-addon" title="Terapkan" onclick="submit('#form-hapus-banner-massal');">Terapkan</span>
					</div>
				</div>
				<div style="float:left">
					<?php if(@$data['pagging'])echo$data['pagging'];?>
				</div>
				<div style="float:right">
					<i><gedank id="jml-list-bawah"><?php if(@$data['total_rows'])echo$data['total_rows'];?></gedank> banner</i>
				</div>
			</div>
		</div>
		</form>
	</div>
	<!--daftar banner end-->
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
							<h3 id="modal_title" class="modal-title">Hapus banner</h3>
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
    form_tambah_banner_reset();
});

$(document).ready(function(){
});

function form_tambah_banner_reset(){
	$('#id-banner').val('');
	$('#icon-banner').val('');
}


function set_edit(data){
	$('#id-banner').val(data.id);
	if(data.posisi=='utama'){
		$('#posisi-banner-1').prop('checked', true);
	}else if(data.posisi=='tulisan'){
		$('#posisi-banner-2').prop('checked', true);
	}else if(data.posisi=='halaman'){
		$('#posisi-banner-3').prop('checked', true);
	}
	$('#icon-banner').val(data.icon);
	$('#url-menu').val(data.slug);
}
function set_delete(data){
	$('#id_del').val(data.id);
	$('#nama_del').html('<img src="'+data.nm+'" style="width:100%">');
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