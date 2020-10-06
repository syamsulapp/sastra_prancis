<!--Gambar Andalan Modal-->
<div class="modal fade bs-gambar-andalan" id="modal-ambil-gambar" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content square-btn-adjust">
			<input id="id-set" type="hidden">
			<div class="modal-title" style="padding:10px;">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">Daftar Gambar</h3>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="active" id="li-unggah-gambar"><a href="#unggah-gambar" data-toggle="tab">Unggah Berkas</a></li>
					<li id="li-pustaka-gambar"><a href="#pustaka-gambar" data-toggle="tab">Pustaka Media</a></li>
				</ul>

				<div class="tab-content" style="height: 430px">
					<!--Berkas-->
					<div class="tab-pane active" id="unggah-gambar">
						<div class="row" style="padding-top:130px">
							<div class="col-lg-12 text-center">
								<h3>Pilih gambar untuk diunggah</h3>
								<br />
								<form name="form_gambar_andalan" id="form-gambar-andalan" method="post" enctype="multipart/form-data" action="<?php echo site_url("tulisan/addimage");?>">
									<div class="form-group">
										<input name="gambar_andalan" id="gambar-andalan" type="file" class="form-control square-btn-adjust auto-width browse" title="Pilih file">
									</div>
								</form>
								Ukuran maksimal unggahan berkas: 10 MB.
							</div>
						</div>
					</div>
					<!--Berkas end-->

					<!--Pustaka-->
					<div class="tab-pane" id="pustaka-gambar">
						<div class="row">
							<div class="col-lg-12" style="padding-top:10px">
								<!--gambar-->
								<form name="form_gambar_andalan_tumbnail" id="form-gambar-andalan-tumbnail">
								<div id="gambar-thumbnail" style="height:380px;overflow:scroll;overflow-x:hidden">
									<div class="row">
										<div class="col-xs-6 col-md-3">
											<a href="#" class="thumbnail">
												<img src="<?php //echo base_url('assets/img/1.jpg'); ?>" alt="...">
											</a>
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 text-center" style="margin-top:10px;">
								<input id="batas" type="hidden" value="20">
								<span class="text-left" id="tombol"></span>
							</div>
						</div>
					</div>
					<!--Pustaka end-->
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default square-btn-adjust" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
			</div>
		</div>
	</div>
</div>
<!--Gambar Andalan Modal end-->

<script>
$(document).ready(function(){
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
                if(data.tnd==1){
                	$('#unggah-gambar').removeClass('active');
                	$('#pustaka-gambar').addClass('active');
                	$('#li-unggah-gambar').removeClass('active');
                	$('#li-pustaka-gambar').addClass('active');
                	var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                }else{
                	var notification = alertify.notify(data.psn, data.wrng, 5, function(){});
                }
                if(data.gambar!=null){
                	tumbnail_gambar_andalan(data,data.path,'gambar-thumbnail');
                }
            }
        });
    }));
});

$("#gambar-andalan").on("change", function() {
    $("#form-gambar-andalan").submit();
});


function prev(){
	bts = eval($('#batas').val())-20;
	$.ajax({
	    'type':'POST',
	    'url': '<?php echo site_url()?>tulisan/lihatgambarandalan/'+bts,
	    'dataType': 'json',
	    success:function(data){
	        if(data.gambar!=null){
	        	tumbnail_gambar_andalan(data,data.path,'gambar-thumbnail');
	        }
	    }
	});
	$('#batas').val(bts);
}

function next(){
	bts = eval($('#batas').val());
	$.ajax({
	    'type':'POST',
	    'url': '<?php echo site_url()?>tulisan/lihatgambarandalan/'+bts,
	    'dataType': 'json',
	    success:function(data){
	    	console.log(data);
	        if(data.gambar!=null){
	        	tumbnail_gambar_andalan(data,data.path,'gambar-thumbnail');
	        }
	    }
	});
	$('#batas').val(bts+20);
}

function tumbnail_gambar(){
	$.ajax({
        'url': '<?php echo site_url("tulisan/lihatgambarandalan");?>',
        'dataType': 'json',
        'success': function(data){
        	if(data.gambar!=null){
            	tumbnail_gambar_andalan(data,data.path,'gambar-thumbnail');
            }
        }
    });
}

function tumbnail_gambar_andalan(data,path,id){
	id_field = $('#id-set').val();
	thumbnail = '';
	i=1;
	$.each(data.gambar, function(i,n){
		if(i%4==0){
			thumbnail +='<div class="row">';
		}
		thumbnail += '<div class="col-xs-6 col-md-3">'
			+'<a id="gambar-andalan-a-'+i+'" onclick="set_gambar_andalan(\''+path+'\',\''+n['gambar_andalan']+'\',\''+id_field+'\')" class="thumbnail" style="height:125px;overflow:hidden;">'
			+'<img src="'+path+'/'+n['gambar_andalan']+'" alt="...">'
			+'</a>'
			+'</div>';
		if(i%4==3){
			thumbnail +='</div>';
		}
	});
	$('#'+id).html(thumbnail);
	$('#tombol').html(data.tombol);
}

function set_gambar_andalan(path,img,id){
	id_set = id.split(',');
	$('#'+id_set[0]).val(img);
	$('#'+id_set[1]).html('<img src="'+path+'/'+img+'" style="max-width:100%">');
	$('#modal-ambil-gambar').modal('hide');
	console.log(id_set[0]);
}

function ambil_gambar_form_web(id){
	$('#modal-ambil-gambar').modal('show');
	$('#id-set').val(id);
	tumbnail_gambar();
}
</script>

<?php
$success = $this->session->flashdata('success'); if (!empty($success)){ ?><script>$(document).ready(function(){ var notification = alertify.notify('<?php echo$success;?>', 'success', 5, function(){});});</script><?php }
$warning = $this->session->flashdata('warning'); if (!empty($warning)){ ?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$warning;?>', 'warning', 5, function(){});});</script><?php }
$danger = $this->session->flashdata('danger'); if (!empty($danger)){ ?><script>$(document).ready(function(){var notification = alertify.notify('<?php echo$danger;?>', 'danger', 5, function(){});});</script><?php }
?>