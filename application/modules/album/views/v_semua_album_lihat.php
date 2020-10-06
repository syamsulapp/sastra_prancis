<link href="<?php echo base_url('assets/plugin/prettyphoto/prettyPhoto.css'); ?>" rel="stylesheet" type="text/css" />
<div class="row">
    <div class="col-lg-12">
        <h3 class="heading_a"><?php if(isset($album['tulisan'][0]['judul_id'])){echo$album['tulisan'][0]['judul_id'];}?>
        </h3>
        <br>
    </div>
</div>
<div class="row">
	<form name="form_hapus_album_massal" id="form-hapus-album-massal" method="post">
		<div>
			<div class="row">
	            <div class="col-lg-12 album-area">
	            </div>
	        </div>
		</div>
		</div>
	</form>
</div>
<?php if(isset($album['tulisan'][0]['penulis'])&&($album['tulisan'][0]['penulis']==$this->session->userdata('id_pengguna'))||$this->session->userdata('level')=='administrator'){?>
<div class="md-fab-wrapper">
    <a href="#" id="btn-tambah-album-baru" data-toggle="modal" data-target=".bs-album" class="md-fab md-fab-accent">
        <i class="material-icons"></i>
    </a>
</div>
<?php }?>

<!--album baru-->
<div class="modal fade bs-album" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-center">
        <div class="modal-content">
          <div class="modal-header">
            <input name="id" id="id-album" type="hidden">
            <button type="submit" class="close" data-dismiss="modal" aria-hidden="true" title="Close">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-picture-o text-primary"></i> Tambah Gambar Baru</h4>
          </div>
          <div class="modal-body text-center">
            <form name="form_gambar_andalan" id="form-gambar-andalan" method="post" enctype="multipart/form-data" action="<?php echo site_url("album/addimage");?>">
				<div class="form-group">
					<label>Pilih gambar dari komputer</label>
					<input name="folder" value="<?php if(isset($album['tulisan'][0]['id_tulisan'])){echo$album['tulisan'][0]['id_tulisan'];}?>" type="hidden">
					<input name="gambar_andalan" id="gambar-andalan" type="file" class="form-control square-btn-adjust auto-width browse" title="Pilih file">
				</div>
			</form>
          </div>
          <div class="modal-footer">
          </div>
        </div>
    </div>
</div>
<!--album baru end-->

<!--hapus-->
<div class="modal fade bs-hapus-img" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-center">
        <div class="modal-content">
        <form method="post" name="form_hapus" id="form-hapus-img">
          <div class="modal-header">
            <input name="id" id="id-hapus" type="hidden">
            <input name="element_hapus" id="element-hapus" type="hidden">
            <button type="submit" class="close" data-dismiss="modal" aria-hidden="true" title="Close">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash text-danger"></i> Hapus</h4>
          </div>
          <div class="modal-body text-center">
            Anda ingin menghapus <span id="nama-hapus"></span>.<h4> Apakah Anda yakin?</h4>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-default square-btn-adjust" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            <button type="submit" class="btn btn-sm btn-danger square-btn-adjust" data-dismiss=".modal"><i class="fa fa-check"></i> OK</button>
          </div>
        </form>
        </div>
    </div>
</div>
<!--hapus end-->

<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js');?>"></script>
<script type="text/javascript">
$(window).load(function(){
	var three="<?php echo$this->uri->segment(3);?>";
	tumbnail_gambar(three);
});

$(document).ready(function(){
	var three="<?php echo$this->uri->segment(3);?>";
	$('#form-gambar-andalan').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            'type':'POST',
            'url': $(this).attr('action'),
            'data':formData,
            'cache':false,
            'contentType': false,
            'processData': false,
            'dataType': 'json',
            success:function(data){
                //console.log(data);
                if(data!=null){
                    location.reload();
                    $('.modal-backdrop').remove();
                	tumbnail_gambar_andalan(data,data.path,three);
                }
            }
        });
    }));

    $("#gambar-andalan").on("change", function() {
        $("#form-gambar-andalan").submit();
        $('.bs-album').modal('hide');
    });

    $('#form-hapus-img').submit(function(e){
        //console.log('hapus');
        e.preventDefault();
        $.ajax({
	        'type': 'POST',
	        'url': '<?php echo site_url("album/delgambaralbum");?>',
	        'dataType': 'json',
	        'data': $(this).serialize(),
            success: function(data){
                //console.log(data);;
                $('.bs-hapus-img').modal('hide');
                $('.modal-backdrop').remove();
                if(data!=null){
                    location.reload();
                    tumbnail_gambar_andalan(data,data.path,data.folder);
                }
            }
        });
    });
});

function row_actions_over(id){
    $('#row-actions-'+id).show();
    //$('#br-'+id).hide();
}

function row_actions_blur(id){
    $('#row-actions-'+id).hide();
    //$('#br-'+id).show();
}

function tumbnail_gambar(three){
	$.ajax({
        'url': '<?php echo site_url("album/lihatgambar/'+three+'");?>',
        'dataType': 'json',
        'success': function(data){
        	//console.log(data);
        	if(data.gambar!=null){
            	tumbnail_gambar_andalan(data,data.path,three);
            }
        }
    });
}

function tumbnail_gambar_andalan(data,path,id){
	var url='<?php echo site_url(); ?>';
	var penulis="<?php echo $this->session->userdata('id_pengguna');?>";
    var admin="<?php echo $this->session->userdata('level');?>";
    var id_penulis="<?php echo $album['tulisan'][0]['penulis'];?>";
	thumbnail = '';
	i=1;
	$.each(data.gambar, function(i,n){
		thumbnail+='<div class="col-lg-2 col-md-3 col-xs-4 thumb text-center" id="hapus-row-album-'+n.replace('.','')+'" onmouseover="row_actions_over(\''+n.replace('.','')+'\')" onmouseout="row_actions_blur(\''+n.replace('.','')+'\')">'
			+'<a class="thumbnail" rel="lightbox[group]" href="'+data.path+'/'+n+'" style="margin-bottom:5px">'
	        	+'<img src="'+data.path+'/'+n+'" class="group1" style="width:100%;height:125px;" title="'+n+'">'
	        +'</a>';
	        if(penulis==id_penulis||admin=='administrator'||admin=='editor'){
		        //thumbnail+='<br id="br-'+n.replace('.','')+'">'
	            thumbnail+='<p class="row-actions" id="row-actions-'+n.replace('.','')+'" style="display:none;margin-top:-30px;">'
		        	+'<span class="hapus"><a title="Hapus '+n+'" data-toggle="modal" data-target=".bs-hapus-img" onclick="set_del_({id:\''+n+'|'+id+'\',nm:\''+n+'\',act:\''+url+'album/delgambaralbum\',element:\'hapus-row-album-'+n.replace('.','')+'\'})" class="text-danger"><i class="fa fa-trash-o"></i></a></span>'
		        +'</p>';
	    	}
        thumbnail+='</div>';
	});
	$('.album-area').html(thumbnail);
	$("[rel^='lightbox']").prettyPhoto();
}

function set_del_(data){
    //console.log(data);
    $('#form-hapus').attr('action',data.act);
    $('#id-hapus').val(data.id);
    $('#element-hapus').val(data.element);
    id = data.id.split('|');
    $('#nama-hapus').html('<img src="<?php echo base_url();?>assets/img/album/'+id[1]+'/'+data.nm+'">');
}
</script>