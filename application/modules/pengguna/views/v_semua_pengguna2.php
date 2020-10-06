<div class="row">
	<h2>
		<?php if(isset($site['page'])){echo$site['page'];}else{echo'page';}?>
		<a href="<?php echo site_url('pengguna/baru');?>" id="btn-tambah-pengguna-baru" class="btn btn-default square-btn-adjust" title="Tambah pengguna baru"><li class="fa fa-plus"></li> Tambah baru</a>
	</h2>
</div>
<div class="row">
	<form name="form_hapus_pengguna_massal" id="form-hapus-pengguna-massal" method="post">
	<div class="block tab-action" id="tab-action">
	</div>
	<div class="block">
		<div class="form-group">
			<div class="btn btl-default" style="float:left">
				<input id="check-pengguna-all-atas" onclick="check_pengguna_all_atas()" type="checkbox">
			</div>
			<div style="float:left">
				<select name="aksi_tindakan_massal_atas" id="aksi-tindakan-massal-atas" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
					<option>Tindakan Massal</option>
					<?php if($this->uri->segment(2)!='block'){?>
					<option value="hps">Block</option>
					<?php }else{?>
					<option value="kmbl">Aktifkan</option>
					<option value="hps_p">Hapus permanen</option>
					<?php }?>
				</select>
			</div>
			<div style="float:left">
				&nbsp;
				<button type="submit" class="btn btn-sm btn-default square-btn-adjust" title="Terapkan">Terapkan</button>
				&nbsp;&nbsp;&nbsp;
			</div>
			<div style="float:left">
				<select id="induk-level" name="induk_level" class="form-control square-btn-adjust auto-width" title="Induk level">
					<option value="0">Lihat seluruh level</option>
					<option value="administrator">Adminitrator</option>
					<option value="editor">Editor</option>
					<option value="user">User</option>
				</select>
			</div>
			<div style="float:right">
				<input id="cari-pengguna" onkeypress="cari_pengguna_()" onchange="cari_pengguna_()" onblur="cari_pengguna_()" name="cari_pengguna" type="text" class="form-control square-btn-adjust" title="Cari pengguna">
			</div>
			<div style="float:right">
				<div class="btn-group">
					<a type="button" class="btn btn-sm btn-default square-btn-adjust" id="prev" onclick="getpenggunaprev()" title="Baru">
						<i class="fa fa-chevron-left"></i>
					</a>
					<div class="btn-group" role="group">
						<input name="pagging" type="hidden" id="pagging" value="0,10">
						<button type="button" class="btn btn-sm btn-default square-btn-adjust dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<gedank id="set_page">1</gedank>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu pagging" role="menu" style="min-width:40px">
						</ul>
					</div>
					<a type="button" class="btn btn-sm btn-default square-btn-adjust" id="next" onclick="getpenggunanext()" title="Lama">
						<i class="fa fa-chevron-right"></i>
					</a>
				</div>&nbsp;
			</div>
			<br />
		</div>
	</div>
	<!--tabel pengguna-->
	<table class="widefat table-striped">
		<tbody id="tbody-pengguna">
			<!--pengguna-->
		</tbody>
	</table>
	<!--tabel pengguna end-->
	<div class="block">
		<div class="form-group">
			<div class="btn btl-default" style="float:left">
				<input id="check-pengguna-all-bawah" onclick="check_pengguna_all_bawah()" type="checkbox">
			</div>
			<div style="float:left">
				<select name="aksi_tindakan_massal_bawah" id="aksi-tindakan-massal-bawah" class="form-control square-btn-adjust auto-width" title="Tindakan massal">
					<option>Tindakan Massal</option>
					<?php if($this->uri->segment(2)!='block'){?>
					<option value="hps">Block</option>
					<?php }else{?>
					<option value="kmbl">Aktifkan</option>
					<option value="hps_p">Hapus permanen</option>
					<?php }?>
				</select>
			</div>
			<div style="float:left">
				&nbsp;
				<button type="submit" class="btn btn-sm btn-default square-btn-adjust" title="Terapkan">Terapkan</button>
			</div>
			<div style="float:right">
				<i><gedank id="jml-list-bawah">0</gedank> pengguna</i>
			</div>
		</div>
	</div>
	</form>
</div>

<!--warning-->
<div class="modal fade bs-warning" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-center">
        <div class="modal-content">
        <form method="post" name="form_warning" id="form-warning">
          <div class="modal-header">
            <input name="id" id="id-warning" type="hidden">
            <input name="element_warning" id="element-warning" type="hidden">
            <button type="submit" class="close" data-dismiss="modal" aria-hidden="true" title="Close">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning text-warning"></i> Peringatan</h4>
          </div>
          <div class="modal-body text-center">
            Anda ingin <gedank id="peringatan">memindahkan ke tong sampah</gedank> <span id="nama-warning"></span>.<h4> Apakah Anda yakin?</h4>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-default square-btn-adjust" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            <button type="submit" class="btn btn-sm btn-warning square-btn-adjust" data-dismiss=".modal"><i class="fa fa-check"></i> OK</button>
          </div>
        </form>
        </div>
    </div>
</div>
<!--warning end-->

<!--tampilkan-->
<div class="modal fade bs-tampilkan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-center">
        <div class="modal-content">
        <form method="post" name="form_tampilkan" id="form-tampilkan">
          <div class="modal-header">
            <input name="id" id="id-tampilkan" type="hidden">
            <input name="element_tampilkan" id="element-tampilkan" type="hidden">
            <button type="submit" class="close" data-dismiss="modal" aria-hidden="true" title="Close">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning text-primary"></i> Peringatan</h4>
          </div>
          <div class="modal-body text-center">
            Anda ingin <gedank id="peringatan-tampilkan">mengaktifkan</gedank> <span id="nama-tampilkan"></span>.<h4> Apakah Anda yakin?</h4>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-default square-btn-adjust" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            <button type="submit" class="btn btn-sm btn-primary square-btn-adjust" data-dismiss=".modal"><i class="fa fa-check"></i> OK</button>
          </div>
        </form>
        </div>
    </div>
</div>
<!--tampilkan end-->

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.10.2.js');?>"></script>
<script>
function set_war(data){
    //console.log(data);
    $('#form-warning').attr('action',data.act);
    $('#id-warning').val(data.id);
    $('#element-warning').val(data.element);
    $('#nama-warning').html(data.nm);
    $('#peringatan').html(data.p);
}

function set_tmpl(data){
    //console.log(data);
    $('#form-tampilkan').attr('action',data.act);
    $('#id-tampilkan').val(data.id);
    $('#element-tampilkan').val(data.element);
    $('#nama-tampilkan').html(data.nm);
    $('#peringatan-tampilkan').html(data.p);
}
</script>
<script type="text/javascript">
$(window).load(function(){
	getpengguna();
});

$(document).ready(function(){
	$('#form-warning').submit(function(e){
        //console.log('warning');
        e.preventDefault();
        $.ajax({
            'type': 'POST',
            'url': $('#form-warning').attr('action'),
            'dataType': 'json',
            'data': $(this).serialize(),
            success: function(data){
                //console.log(data);
                $('.bs-warning').hide();
                if(data.data!=null){
                    isi(data.data);
                    var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                }else{
                    alertify.error('ERROR!');
                }
            }
        });
    });

    $('#form-tampilkan').submit(function(e){
        //console.log('tampilkan');
        e.preventDefault();
        $.ajax({
            'type': 'POST',
            'url': $('#form-tampilkan').attr('action'),
            'dataType': 'json',
            'data': $(this).serialize(),
            success: function(data){
                //console.log(data);
                $('.bs-tampilkan').hide();
                if(data.data!=null){
                    isi(data.data);
                    var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                }else{
                    alertify.error('ERROR!');
                }
            }
        });
    });

	$('#induk-level').on('change', function(){
		$.ajax({
	        'type': 'POST',
	        'url': '<?php echo site_url("pengguna/getpengguna");?>',
	        'dataType': 'json',
	        'data': 'id_level='+$('#induk-level').val()+'&cari_pengguna='+$('#cari-pengguna').val(),
	        success: function(data){
	        	//console.log(data);
	        	if(data.data!=null){
		    		isi(data.data);
		    	}
	        }
	    });
	});

	$('#form-hapus-pengguna-massal').submit(function(e){
		e.preventDefault();
	    if($('#aksi-tindakan-massal-atas').val()=='hps_p' || $('#aksi-tindakan-massal-bawah').val()=='hps_p'){
			$.ajax({
		        'type': 'POST',
		        'url': '<?php echo site_url("pengguna/delpenggunamassal");?>',
		        'dataType': 'json',
		        'data': $(this).serialize(),
		        success: function(data){
		        	//console.log(data);
		        	if(data.data!=null){
						isi(data.data);
						var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
	                }else{
	                    alertify.error('ERROR!');
	                }
		        }
		    });
		}else if($('#aksi-tindakan-massal-atas').val()=='kmbl' || $('#aksi-tindakan-massal-bawah').val()=='kmbl'){
			$.ajax({
		        'type': 'POST',
		        'url': '<?php echo site_url("pengguna/aktifkanpenggunamassal");?>',
		        'dataType': 'json',
		        'data': $(this).serialize(),
		        success: function(data){
		        	//console.log(data);
		        	if(data.data!=null){
						isi(data.data);
						var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
	                }else{
	                    alertify.error('ERROR!');
	                }
		        }
		    });
		}else if($('#aksi-tindakan-massal-atas').val()=='hps' || $('#aksi-tindakan-massal-bawah').val()=='hps'){
			$.ajax({
		        'type': 'POST',
		        'url': '<?php echo site_url("pengguna/blockpenggunamassal");?>',
		        'dataType': 'json',
		        'data': $(this).serialize(),
		        success: function(data){
		        	//console.log(data);
		        	if(data.data!=null){
						isi(data.data);
						var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
	                }else{
	                    alertify.error('ERROR!');
	                }
		        }
		    });
		}
	});
});

function cari_pengguna_(){
	var semua = "<?php echo $this->uri->segment(2);?>";
	//console.log($('#cari-pengguna').val());
	$('#pagging').val('0,10');
	$.ajax({
        'type': 'POST',
        'url': '<?php echo site_url("pengguna/getpengguna");?>',
        'dataType': 'json',
        'data': 'cari_pengguna='+$('#cari-pengguna').val()+'&id_level='+$('#induk-level').val()+'&pagging='+$('#pagging').val(),
        success: function(data){
        	//console.log(data);
        	if(data.data!=null){
				isi(data.data);
				pagging=$('#pagging').val().split(',');
				pag1 = eval(pagging[0]);
				pag2 = eval(pagging[1]);
				$('#prev').addClass('disabled');
        		$('#pagging').val(pag1+','+pag2);
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
        		$('#set_page').html(1);
			}
        }
    });
    $('#check-pengguna-all-bawah').prop('checked', false);
    $('#check-pengguna-all-atas').prop('checked', false);
}

function level_link(id){
	var semua = "<?php echo $this->uri->segment(2);?>";
	$('#pagging').val('0,10');
	$.ajax({
        'type': 'POST',
        'url': '<?php echo site_url("pengguna/getpengguna");?>',
        'dataType': 'json',
        'data': 'cari_pengguna='+$('#cari-pengguna').val()+'&id_level='+$('#induk-level').val()+'&pagging='+$('#pagging').val(),
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

function row_actions_over(id){
	$('#row-actions-'+id).show();
	$('#br-'+id).hide();
}

function row_actions_blur(id){
	$('#row-actions-'+id).hide();
	$('#br-'+id).show();
}

function check_pengguna_all_atas(){
	if(document.getElementById('check-pengguna-all-atas').checked==true){
		$('.check-pengguna').prop('checked', true);
		$('#check-pengguna-all-bawah').prop('checked', true);
	}else{
		$('.check-pengguna').prop('checked', false);
		$('#check-pengguna-all-bawah').prop('checked', false);
	}
}

function check_pengguna_all_bawah(){
	if(document.getElementById('check-pengguna-all-bawah').checked==true){
		$('.check-pengguna').prop('checked', true);
		$('#check-pengguna-all-atas').prop('checked', true);
	}else{
		$('.check-pengguna').prop('checked', false);
		$('#check-pengguna-all-atas').prop('checked', false);
	}
}

function getpengguna(){
	var semua = "<?php echo $this->uri->segment(2);?>";
	$.ajax({
        'url': '<?php echo site_url("pengguna/getpengguna");?>',
        'dataType': 'json',
        'type': 'POST',
        'data': 'cari_pengguna='+$('#cari-pengguna').val()+'&id_level='+$('#induk-level').val()+'&pagging='+$('#pagging').val(),
        'success': function(data){
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
}

function getpenggunanext(){
	var semua = "<?php echo $this->uri->segment(2);?>";
	pagging=$('#pagging').val().split(',');
	pag1 = eval(pagging[0])+eval(pagging[1]);
	pag2 = eval(pagging[1]);
	$('#pagging').val(pag1+','+pag2);
	$.ajax({
        'url': '<?php echo site_url("pengguna/getpengguna");?>',
        'dataType': 'json',
        'type': 'POST',
        'data': 'cari_pengguna='+$('#cari-pengguna').val()+'&id_level='+$('#induk-level').val()+'&pagging='+$('#pagging').val(),
        'success': function(data){
        	//console.log(data);
        	if(data.data!=null){
        		isi(data.data);
        		pagging=$('#pagging').val().split(',');
				pag1 = eval(pagging[0])+eval(pagging[1]);
				pag2 = eval(pagging[1]);
        		$('#prev').removeClass('disabled');
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
				$('#set_page').html(eval($('#set_page').html())+1);
        		$('.pagging').html(pagging);
        	}
        }
    });
}

function getpenggunaprev(){
	var semua = "<?php echo $this->uri->segment(2);?>";
	pagging=$('#pagging').val().split(',');
	pag1 = eval(pagging[0])-eval(pagging[1]);
	pag2 = eval(pagging[1]);
	$('#pagging').val(pag1+','+pag2);
	$.ajax({
        'url': '<?php echo site_url("pengguna/getpengguna");?>',
        'dataType': 'json',
        'type': 'POST',
        'data': 'cari_pengguna='+$('#cari-pengguna').val()+'&id_level='+$('#induk-level').val()+'&pagging='+$('#pagging').val(),
        'success': function(data){
        	//console.log(data);
        	if(data.data!=null){
        		isi(data.data);
        		$('#next').removeClass('disabled');
        		if(pag1==0){
        			$('#prev').addClass('disabled');
        		}
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
        		jml_pg=eval(semua) / eval(pag2);
        		pagging='';
        		for(m=1;m<=Math.ceil(jml_pg);m++){
					pagging+='<li><a onclick="setpage(\''+m+'\',\''+((eval(m)-1)*pag2)+','+pag2+'\')">'+m+'</a></li>';
				}
				$('#set_page').html(eval($('#set_page').html())-1);
        		$('.pagging').html(pagging);
        	}
        }
    });
}

function isi(data){
	var semua = "<?php echo $this->uri->segment(2);?>";
	var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
	var months_ = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
	var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
	var url='<?php echo site_url(); ?>';
	var uri_2='<?php echo $this->uri->segment(2);?>';
	if(data.error==0){
		table = '';
		jml = 0;
	    $.each(data.pengguna, function(i,n){
			table += '<tr id="hapus-row-pengguna-'+n['id_pengguna']+'" onmouseover="row_actions_over(\''+n['id_pengguna']+'\')" onmouseout="row_actions_blur(\''+n['id_pengguna']+'\')">';
				if(n['id_pengguna']!=1){
					table+='<td width="3%" class="text-center"><input name="id_hapus_pengguna_massal_['+n['id_pengguna']+']" class="check-pengguna" type="checkbox" value="'+n['id_pengguna']+'"></td>';
				}else{
					table+='<td width="3%" class="text-center"></td>';
				}
				table+='<td width="5%"><img alt="" src="'+n['foto']+'" height="32" width="32"></td>';
				table+='<td>'
					+'<p>'+n['username']+'</p>'
					+'<br id="br-'+n['id_pengguna']+'">'
					+'<div class="row-actions" id="row-actions-'+n['id_pengguna']+'">'
						+'<span class="sunting"><a href="'+url+'pengguna/sunting?id='+n['id_pengguna']+'">Sunting</a></span>';
						if(n['id_pengguna']!=1 && n['status_pengguna']=='aktif'){
							table+='<span class="hapus"> | <a title="Sampah '+n['username']+'" data-toggle="modal" data-target=".bs-warning" onclick="set_war({id:\''+n['id_pengguna']+'\',nm:\'pengguna '+n['username']+'\',act:\''+url+'pengguna/blockpengguna\',element:\'hapus-row-pengguna-\',p:\'hapus pengguna\'})">Block</a></span>';
						}else if(n['id_pengguna']!=1 && n['status_pengguna']=='block'){
							table+='<span class="sunting"> | <a title="Aktifkan '+n['username']+'" data-toggle="modal" data-target=".bs-tampilkan" onclick="set_tmpl({id:\''+n['id_pengguna']+'\',nm:\'pengguna '+n['username']+'\',act:\''+url+'pengguna/aktifkanpengguna\',element:\'hapus-row-pengguna-\',p:\'aktifkan pengguna\'})">Aktifkan</a></span>';
							table+='<span class="hapus"> | <a title="Hapus permanen '+n['username']+'" data-toggle="modal" data-target=".bs-hapus" onclick="set_del({id:\''+n['id_pengguna']+'\',nm:\'pengguna '+n['username']+'\',act:\''+url+'pengguna/delpengguna\',element:\'hapus-row-pengguna-\'})">Hapus permanen</a></span>';
						}
					table+='</div>'
				+'</td>';
				table+='<td width="10%">'+n['level']+'</td>'
				+'<td width="13%">'+n['nm_dp']+' '+n['nm_blk']
				+'<br>'
				+'<div class="email-komentar">'+n['email']
				+'</div>'
				+'</td>'
				+'<td width="10%">'+n['web']+'</td>'
				+'<td width="5%">'+n['status_pengguna']+'</td>'
				+'<td width="5%">'+data.jml_tul[n['id_pengguna']]+'</td>';
				tgl=n['tgl_bergabung'].split(' ');
				var date = new Date(tgl[0]);
        		tgl_=tgl[0].split('-');
				table+='<td width="13%">'
					+myDays[date.getDay()]+', '
					+tgl_[2]+' '
					+months[date.getMonth(n['tgl_bergabung'])]+' '
					+tgl_[0]+' / '
					+tgl[1]+' '
				+'</td>';
			table+'</tr>';
			jml++;
	    });
	    if(semua=='administrator'){
			semua=data.tab_action.administrator;
		}else if(semua=='editor'){
			semua=data.tab_action.editor;
		}else if(semua=='user'){
			semua=data.tab_action.user;
		}else if(semua=='block'){
			semua=data.tab_action.block;
		}else if(semua==''){
			semua=data.tab_action.semua;
		}
	    table += '';
	    $("#tbody-pengguna").html(table);
	    pagging=$('#pagging').val().split(',');
		pag1 = eval(pagging[0]);
		pag2 = eval(pagging[1]);
		if(jml==1){
			$("#jml-list-bawah").html((pag1+1)+' dari '+semua);
		}else if(jml>1 && jml<pag2){
			$("#jml-list-bawah").html((pag1+1)+'-'+semua+' dari '+semua);
		}else{
			$("#jml-list-bawah").html((pag1+1)+'-'+(pag1+pag2)+' dari '+semua);
		}
	}else{
		table = '';
			table += '<tr>'
				+'<td colspan="7">pengguna tidak ditemukan.</td>'
			+'</tr>';
		table += '';
		$("#tbody-pengguna").html(table);
		$("#jml-list-bawah").html('0');
	}

	/*tab_action*/
	tab_action = '';
    if(uri_2!=''){
    	tab_action+='<a href="'+url+'pengguna">Semua</a> ('+data.tab_action.semua+')';
    }else{
    	tab_action+='Semua ('+data.tab_action.semua+')';
    }

    if(data.tab_action.administrator!=0){
	    if(uri_2!='administrator'){
	    	tab_action+=' | <a href="'+url+'pengguna/administrator">Administrator</a> ('+data.tab_action.administrator+')';
	    }else{
	    	tab_action+=' | Administrator ('+data.tab_action.administrator+')';
	    }
	}

	if(data.tab_action.editor!=0){
	    if(uri_2!='editor'){
	    	tab_action+=' | <a href="'+url+'pengguna/editor">Editor</a> ('+data.tab_action.editor+')';
	    }else{
	    	tab_action+=' | Editor ('+data.tab_action.editor+')';
	    }
	}

	if(data.tab_action.user!=0){
	    if(uri_2!='user'){
	    	tab_action+=' | <a href="'+url+'pengguna/user">User</a> ('+data.tab_action.user+')';
	    }else{
	    	tab_action+=' | User ('+data.tab_action.user+')';
	    }
	}

	if(data.tab_action.block!=0){
	    if(uri_2!='block'){
	    	tab_action+=' | <a href="'+url+'pengguna/block">Pengguna diblock</a> ('+data.tab_action.block+')';
	    }else{
	    	tab_action+=' | Pengguna diblock ('+data.tab_action.block+')';
	    }
	}
    tab_action += '';
    $("#tab-action").html(tab_action);
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

function setpage(pg,st_pg){
	$('#set_page').html(pg);
	$('#pagging').val(st_pg);
	getpengguna();
}
</script>