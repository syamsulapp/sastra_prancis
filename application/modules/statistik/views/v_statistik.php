<div class="row">
	<div class="col-lg-9">
		<div class="panel panel-default square-btn-adjust">
			<div class="panel-body" style="min-height:300px">
				<div class="statistik-pengunjung"></div>
			</div>
		</div>
	</div>
	<!--aktifitas terbaru-->
	<div class="col-lg-3">
		<ul class="list-group">
			<li class="list-group-item"><h4>Statistik Pengunjung</h4></li>
			<li class="list-group-item">
				<span class="badge pengunjung-hari-ini">0</span>
				<i class="fa fa-user"></i> Pengunjung hari ini
			</li>
			<li class="list-group-item">
				<span class="badge pengunjung-kemarin">0</span>
				<i class="fa fa-user"></i> Pengunjung kemarin
			</li>
			<li class="list-group-item">
				<span class="badge pengunjung-bulan-ini">0</span>
				<i class="fa fa-group"></i> Pengunjung bulan ini
			</li>
			<li class="list-group-item">
				<span class="badge pengunjung-tahun-ini">0</span>
				<i class="fa fa-group"></i> Pengunjung tahun ini
			</li>
			<li class="list-group-item">
				<span class="badge total-pengunjung">0</span>
				<i class="fa fa-group"></i> Total pengunjung
			</li>
			<li class="list-group-item">
				<span class="badge pengunjung-online">0</span>
				<i class="fa fa-globe"></i> Pengunjung online
			</li>
		</ul>
	</div>
	<!--aktifitas terbaru end-->
</div>

<div class="row">
	<div class="col-lg-9">
		<div class="panel panel-default square-btn-adjust">
			<div class="panel-heading">
				Statistik Tulisan
			</div>
			<!--tabel tulisan-->
			<table class="uk-table">
				<tbody id="tbody-tulisan">
					<!--Tulisan-->
				</tbody>
			</table>
			<!--tabel tulisan end-->
		</div>
	</div>
</div>

<?php if(@$chart&&$chart!=null){
	$datal = implode(',',$chart);
}?>

<script src="<?php echo base_url('assets/plugin/highchart/highcharts.js');?>"></script>
<script src="<?php echo base_url('assets/plugin/highchart/exporting.js');?>"></script>
<script>
$('.statistik-pengunjung').highcharts({
    chart: {
        type: 'line'
    },
    title: {
        text: 'Statistik Pengunjung Tahun ini'
    },
    subtitle: {
        text: '<?php echo site_url();?>'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
    	min: 0,
        title: {
            text: 'Jumlah Pengunjung'
        }
    },
    tooltip: {
        valueSuffix: ' org'
    },
    series: [{
        name: 'Jumlah Pengunjung',
        data: [<?php echo $datal; ?>]
    }],
    credits: {
	  enabled: false
	}
});

$(window).load(function(){
	$.ajax({
        'url': '<?php echo site_url("statistik/gettulisanstatistik");?>',
        'dataType': 'json',
        'success': function(data){
        	//console.log(data);
        	if(data.data!=null){
        		isi(data.data);
        	}
        }
    });
});

function isi(data){
	var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
	var months_ = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
	var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
	var url='<?php echo site_url(); ?>';
	var uri_2='<?php echo $this->uri->segment(2);?>';
	var penulis="<?php echo $this->session->userdata('id_pengguna');?>";
	var admin="<?php echo $this->session->userdata('level');?>";
	if(data.error==0){
		table = '';
	    $.each(data.tulisan, function(i,n){
			table += '<tr id="hapus-row-tulisan-'+n['id_tulisan']+'">';
				table+='<td>';
						judul=n['judul'].split(' ');
                        judul_='';
                        for(x=0;x<judul.length;x++){
                            if(x==0){
                                judul_+=judul[x];
                            }else{
                                judul_+='-'+judul[x];
                            }
                        }
					if(penulis==n['penulis']||admin=='administrator'){
						if(n['status_tulisan']=='draft'){
							table +='<p><a target="blank" href="'+url+'lihat/pra'+n['slug']+'/'+n['id_tulisan']+'-'+judul_+'">'+n['judul']+'</a></p>';
						}else if(n['status_tulisan']=='terbit'){
							table +='<p><a target="blank" href="'+url+'lihat/'+n['slug']+'/'+n['id_tulisan']+'-'+judul_+'">'+n['judul']+'</a></p>';
						}
					}else{
						table+='<p>'+n['judul']+'</p>';
					}
				table += '</td>'
				+'<td width="3%"><a class="post-com-count"><span class="comment-count">'+data.jml_kom_tul[n['id_tulisan']]+'</span></a></td>'
				+'<td width="3%">'+n['view']+'</td>';
			table+'</tr>';
	    });
	    table += '';
	    $("#tbody-tulisan").html(table);
	}else{
		table = '';
			table += '<tr>'
				+'<td colspan="7">Tulisan tidak ditemukan.</td>'
			+'</tr>';
		table += '';
		$("#tbody-tulisan").html(table);
	}
}
</script>
<script type="text/javascript">
$(window).load(function(){
    var url="<?php echo site_url();?>";
    $.ajax({
        'url': '<?php echo site_url("statistik/getstatistikhariini");?>',
        'dataType': 'json',
        'success': function(data){
            //console.log(data);
            if(data!=null){
                $('.penayangan-hari-ini-menubar').html('<a href="'+url+'statistik" style="color:inherit">'+data.pengunjung+'</a>');
                $('.semua-statistik-menubar').html('<a href="'+url+'statistik" style="color:inherit">'+data.totalpengunjung+'</a>');
                $('.pengunjung-hari-ini').html(data.pengunjung);
                if(data.kemarin!=false){
                    $('.pengunjung-kemarin').html(data.kemarin1);
                }else{
                    $('.pengunjung-kemarin').html(0);
                }
                $('.pengunjung-bulan-ini').html(data.bulan1);
                $('.pengunjung-tahun-ini').html(data.tahunini1);
                $('.total-pengunjung').html(data.totalpengunjung);
                $('.pengunjung-online').html(data.pengunjungonline);
            }
        }
    });
});
</script>