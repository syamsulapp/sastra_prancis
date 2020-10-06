<div class="row">
  <div class="col-lg-12">
  	<form name="form_hapus_album_massal" id="form-hapus-album-massal" method="post">
      <ul class="uk-tab" id="tab-action">
      </ul>
      <br>
  		<div>
  			<div class="row">
          <div class="col-lg-12">
            <div class="album-area"></div>
          </div>
        </div>
  		</div>
  	</form>
  </div>
</div>

<div class="md-fab-wrapper">
    <a href="#" id="btn-tambah-album-baru" data-toggle="modal" data-target=".bs-album" class="md-fab md-fab-accent">
        <i class="material-icons"></i>
    </a>
</div>

<!--album baru-->
<div class="modal fade bs-album" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-center">
        <div class="modal-content">
        <form method="post" name="form_album" id="form-album">
          <div class="modal-header">
            <input name="id" id="id-album" type="hidden">
            <button type="submit" class="close" data-dismiss="modal" aria-hidden="true" title="Close">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus text-primary"></i> Tambah Album Baru</h4>
          </div>
          <div class="modal-body text-center">
            <div class="form-group">
            	Nama Album
            	<input name="album" class="form-control required" id="album" type="text">
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-sm btn-default square-btn-adjust" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            <button type="submit" class="btn btn-sm btn-primary square-btn-adjust" data-dismiss=".modal"><i class="fa fa-check"></i> Simpan</button>
          </div>
        </form>
        </div>
    </div>
</div>
<!--album baru end-->

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
            Anda ingin <gedank id="peringatan-tampilkan">menampilkan</gedank> <span id="nama-tampilkan"></span>.<h4> Apakah Anda yakin?</h4>
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

<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js');?>"></script>
<script type="text/javascript">
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

$(window).load(function(){
	$.ajax({
        'url': '<?php echo site_url("album/getalbumjson");?>',
        'dataType': 'json',
        'success': function(data){
        	//console.log(data);
        	if(data.data!=null){
        		isi(data.data);
        	}
        }
    });
});

$(document).ready(function(){

	$("#form-album").submit(function(e){
		e.preventDefault();
		$.ajax({
	        'type': 'POST',
	        'url': '<?php echo site_url("album/addalbum");?>',
	        'dataType': 'json',
	        'data': $(this).serialize(),
	        success: function(data){
	        	console.log(data);
	        	if(data.data!=null){
              location.reload();
					     isi(data.data);
                    var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                }else{
                    alertify.error('ERROR!');
                }
	        }
	    });
	    $('.bs-album').modal('hide');
      $('.modal-backdrop').remove();
	});

	$('#form-warning').submit(function(e){
      //console.log('warning');
      e.preventDefault();
      $.ajax({
          'type': 'POST',
          'url': $('#form-warning').attr('action'),
          'dataType': 'json',
          'data': $(this).serialize(),
          success: function(data){
              console.log(data);
              $('.bs-warning').modal('hide');
              $('.modal-backdrop').remove();
              if(data.data!=null){
                location.reload();
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
              console.log(data);
              $('.bs-tampilkan').modal('hide');
              $('.modal-backdrop').remove();
              if(data.data!=null){
                location.reload();
                  isi(data.data);
                  var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
              }else{
                  alertify.error('ERROR!');
              }
          }
      });
  });
});

function set_edit(data){
    $('#id-album').val(data.id);
    $('#album').val(data.nm);
}

function row_actions_over(id){
    $('#row-actions-'+id).show();
    $('#row-judul-'+id).show();
    //$('#br-'+id).hide();
}

function row_actions_blur(id){
    $('#row-actions-'+id).hide();
    $('#row-judul-'+id).hide();
    //$('#br-'+id).show();
}

function isi(data){
	var url='<?php echo site_url(); ?>';
	var base_url='<?php echo base_url(); ?>';
	var uri_2='<?php echo $this->uri->segment(2);?>';
    var penulis="<?php echo $this->session->userdata('id_pengguna');?>";
    var admin="<?php echo $this->session->userdata('level');?>";
	if(data.error==0){
		album='';
		jml = 0;
		$.each(data.tulisan, function(i,n){
			album+='<div class="col-lg-2 col-md-3 col-xs-4 text-center album-height" id="hapus-row-album-'+n['id_tulisan']+'" onmouseover="row_actions_over(\''+n['id_tulisan']+'\')" onmouseout="row_actions_blur(\''+n['id_tulisan']+'\')" style="padding-left:5px;padding-right:5px;">';
                /*album+='<div class="album-judul text-primary" id="row-judul-'+n['id_tulisan']+'" style="position:absolute;display:none;background:rgba(255,255,255,0.9);">'+
                  '<a href="'+url+'album/lihat/'+n['id_tulisan']+'" style="margin-bottom:5px" title="'+n['judul_id']+'">'+
                  n['judul_id']+
                  '</a>'+
                '</div>';*/

                album+='<div style="z-index:0;">'
                  +'<a class="thumbnail" href="'+url+'album/lihat/'+n['id_tulisan']+'" style="margin-bottom:5px" title="'+n['judul_id']+'">'
                      +'<img class="img-responsive" src="'+base_url+'assets/img/web/folder.png" alt="">'
                  +'</a>'
                +'</div>';

                album+='<div class="album-aksi">';
                if(penulis==n['penulis']||admin=='administrator'||admin=='editor'){
                  album+=''
                    +'<p class="row-actions" id="row-actions-'+n['id_tulisan']+'" style="display:none;margin-top:-30px;">';
                        album+='<span class="sunting"><a title="Ubah '+n['judul_id']+'" data-toggle="modal" data-target=".bs-album" onclick="set_edit({id:\''+n['id_tulisan']+'\',nm:\''+n['judul_id']+'\',act:\''+url+'album/addalbum\',element:\'hapus-row-album-'+n['id_tulisan']+'\',p:\'ubah nama album\'})" class="text-success"><i class="fa fa-pencil"></i></a></span>';
                    if(admin=='administrator'||admin=='editor'){
                      if(n['status_tulisan']!='terbit'){
                        album+='<span class="sunting"> | <a title="Tampilkan '+n['judul_id']+'" data-toggle="modal" data-target=".bs-tampilkan" onclick="set_tmpl({id:\''+n['id_tulisan']+'\',nm:\'album '+n['judul_id']+'\',act:\''+url+'album/tampilkanalbum\',element:\'hapus-row-album-'+n['id_tulisan']+'\',p:\'menampilkan\'})" class="text-warning"><i class="fa fa-eye-slash"></i></a></span>';
                      }else if(n['status_tulisan']=='terbit'){
                        album+='<span class="sunting"> | <a title="Sembunyikan '+n['judul_id']+'" data-toggle="modal" data-target=".bs-warning" onclick="set_war({id:\''+n['id_tulisan']+'\',nm:\'album '+n['judul_id']+'\',act:\''+url+'album/prevalbum\',element:\'hapus-row-album-'+n['id_tulisan']+'\',p:\'menyembunyikan\'})" class="text-warning"><i class="fa fa-eye"></i></a></span>';
                      }

              				if(n['status_tulisan']!='sampah'){
              					album+='<span class="hapus"> | <a title="Sampah '+n['judul_id']+'" data-toggle="modal" data-target=".bs-warning" onclick="set_war({id:\''+n['id_tulisan']+'\',nm:\'album '+n['judul_id']+'\',act:\''+url+'album/sampahalbum\',element:\'hapus-row-album-'+n['id_tulisan']+'\',p:\'memindahkan ke tong sampah\'})" class="text-danger"><i class="fa fa-trash-o"></i></a></span>';
              				}else{
              					album+='<span class="hapus"> | <a title="Hapus permanen '+n['judul_id']+'" data-toggle="modal" data-target=".bs-hapus" onclick="set_del({id:\''+n['id_tulisan']+'\',nm:\'album '+n['judul_id']+'\',act:\''+url+'album/delalbum\',element:\'hapus-row-album-'+n['id_tulisan']+'\'})" class="text-danger"><i class="fa fa-trash-o"></i></a></span>';
              				}
                    }
                    album+='</p>';
                }
                album+='</div>';
            album+='</div>';
            jml++;
		});
		$('.album-area').html(album);
		$("#jml-list-bawah").html(jml);
	}else{
		$('.album-area').html('');
	}
	tab_action = '';
    if(uri_2!=''){
    	tab_action+='<li class=""><a href="'+url+'album">Semua ('+data.tab_action.semua+')</a></li>';
    }else{
    	tab_action+='<li class="uk-active" aria-expanded="true"><a href="#">Semua ('+data.tab_action.semua+')</a></li>';
    }

    if(data.tab_action.konsep!=0){
	    if(uri_2!='konsep'){
	    	tab_action+='<li class=""><a href="'+url+'album/konsep">Konsep ('+data.tab_action.konsep+')</a></li>';
	    }else{
	    	tab_action+='<li class="uk-active" aria-expanded="true"><a href="#">Konsep ('+data.tab_action.konsep+')</a></li>';
	    }
	}

	if(data.tab_action.terbit!=0){
	    if(uri_2!='terbit'){
	    	tab_action+='<li class=""><a href="'+url+'album/terbit">Telah Terbit ('+data.tab_action.terbit+')</a></li>';
	    }else{
	    	tab_action+='<li class="uk-active" aria-expanded="true"><a href="#">Telah Terbit ('+data.tab_action.terbit+')</a></li>';
	    }
	}

	if(data.tab_action.sampah!=0){
	    if(uri_2!='sampah'){
	    	tab_action+='<li class=""><a href="'+url+'album/sampah">Sampah ('+data.tab_action.sampah+')</a></li>';
	    }else{
	    	tab_action+='<li class="uk-active" aria-expanded="true"><a href="#">Sampah ('+data.tab_action.sampah+')</a></li>';
	    }
	}
    tab_action += '';
    $("#tab-action").html(tab_action);
}

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).load(function() {
  equalheight('.thumb');
});


$(window).resize(function(){
  equalheight('.thumb');
});
</script>