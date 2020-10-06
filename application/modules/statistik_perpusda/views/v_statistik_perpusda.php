<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default square-btn-adjust">
			<div class="panel-body" style="min-height:300px">
				<div class="statistik-pengunjung"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default square-btn-adjust">
			<div class="panel-heading">
				Kolom Inputan Statistik
			</div>
			<!--tabel tulisan-->
			<form action="<?php echo site_url('statistik_perpusda/simpan');?>" method="post">
				<input name="id" value="<?php if(isset($statistik[0]['id_perpusda_statistik']))echo$statistik[0]['id_perpusda_statistik'];?>" type="hidden">
				<input name="jenis" value="<?php echo$jenis;?>" type="hidden">
				<div class="table-responsive">
					<table class="uk-table">
						<thead>
							<tr>
								<th class="md-bg-grey-100">Jenis Kelamin</th>
								<th class="md-bg-grey-100">Jan</th>
								<th class="md-bg-grey-100">Feb</th>
								<th class="md-bg-grey-100">Mar</th>
								<th class="md-bg-grey-100">Apr</th>
								<th class="md-bg-grey-100">Mei</th>
								<th class="md-bg-grey-100">Jun</th>
								<th class="md-bg-grey-100">Jul</th>
								<th class="md-bg-grey-100">Ags</th>
								<th class="md-bg-grey-100">Sep</th>
								<th class="md-bg-grey-100">Okt</th>
								<th class="md-bg-grey-100">Nov</th>
								<th class="md-bg-grey-100">Des</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>L</td>
								<td><input type="text" name="L[1]" class="form-control" value="<?php if(@$statistik[0]['l1'])echo$statistik[0]['l1'];?>"></td>
								<td><input type="text" name="L[2]" class="form-control" value="<?php if(@$statistik[0]['l2'])echo$statistik[0]['l2'];?>"></td>
								<td><input type="text" name="L[3]" class="form-control" value="<?php if(@$statistik[0]['l3'])echo$statistik[0]['l3'];?>"></td>
								<td><input type="text" name="L[4]" class="form-control" value="<?php if(@$statistik[0]['l4'])echo$statistik[0]['l4'];?>"></td>
								<td><input type="text" name="L[5]" class="form-control" value="<?php if(@$statistik[0]['l5'])echo$statistik[0]['l5'];?>"></td>
								<td><input type="text" name="L[6]" class="form-control" value="<?php if(@$statistik[0]['l6'])echo$statistik[0]['l6'];?>"></td>
								<td><input type="text" name="L[7]" class="form-control" value="<?php if(@$statistik[0]['l7'])echo$statistik[0]['l7'];?>"></td>
								<td><input type="text" name="L[8]" class="form-control" value="<?php if(@$statistik[0]['l8'])echo$statistik[0]['l8'];?>"></td>
								<td><input type="text" name="L[9]" class="form-control" value="<?php if(@$statistik[0]['l9'])echo$statistik[0]['l9'];?>"></td>
								<td><input type="text" name="L[10]" class="form-control" value="<?php if(@$statistik[0]['l10'])echo$statistik[0]['l10'];?>"></td>
								<td><input type="text" name="L[11]" class="form-control" value="<?php if(@$statistik[0]['l11'])echo$statistik[0]['l11'];?>"></td>
								<td><input type="text" name="L[12]" class="form-control" value="<?php if(@$statistik[0]['l12'])echo$statistik[0]['l12'];?>"></td>
							</tr>
							<tr>
								<td>P</td>
								<td><input type="text" name="P[1]" class="form-control" value="<?php if(@$statistik[0]['p1'])echo$statistik[0]['p1'];?>"></td>
								<td><input type="text" name="P[2]" class="form-control" value="<?php if(@$statistik[0]['p2'])echo$statistik[0]['p2'];?>"></td>
								<td><input type="text" name="P[3]" class="form-control" value="<?php if(@$statistik[0]['p3'])echo$statistik[0]['p3'];?>"></td>
								<td><input type="text" name="P[4]" class="form-control" value="<?php if(@$statistik[0]['p4'])echo$statistik[0]['p4'];?>"></td>
								<td><input type="text" name="P[5]" class="form-control" value="<?php if(@$statistik[0]['p5'])echo$statistik[0]['p5'];?>"></td>
								<td><input type="text" name="P[6]" class="form-control" value="<?php if(@$statistik[0]['p6'])echo$statistik[0]['p6'];?>"></td>
								<td><input type="text" name="P[7]" class="form-control" value="<?php if(@$statistik[0]['p7'])echo$statistik[0]['p7'];?>"></td>
								<td><input type="text" name="P[8]" class="form-control" value="<?php if(@$statistik[0]['p8'])echo$statistik[0]['p8'];?>"></td>
								<td><input type="text" name="P[9]" class="form-control" value="<?php if(@$statistik[0]['p9'])echo$statistik[0]['p9'];?>"></td>
								<td><input type="text" name="P[10]" class="form-control" value="<?php if(@$statistik[0]['p10'])echo$statistik[0]['p10'];?>"></td>
								<td><input type="text" name="P[11]" class="form-control" value="<?php if(@$statistik[0]['p11'])echo$statistik[0]['p11'];?>"></td>
								<td><input type="text" name="P[12]" class="form-control" value="<?php if(@$statistik[0]['p12'])echo$statistik[0]['p12'];?>"></td>
							</tr>
						</tbody>
					</table>
					<!--tabel tulisan end-->
				</div>
			<div class="panel-footer text-right">
				<button class="btn btn-default">Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/plugin/highchart/highcharts.js');?>"></script>
<script src="<?php echo base_url('assets/plugin/highchart/exporting.js');?>"></script>

<?php
$datal = $datap = '0,0,0,0,0,0,0,0,0,0,0,0';
if(@$statistik[0]){
	for($i=1;$i<=12;$i++){
		$p[] = $statistik[0]['p'.$i];
		$l[] = $statistik[0]['l'.$i];
	}
	$datal = implode(',',$l);
	$datap = implode(',',$p);
}
?>

<script>
	$('.statistik-pengunjung').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<?php if(isset($site["page"])){echo$site["page"];}else{echo"page";}?> Tahun <?php echo date("Y");?>'
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
            name: 'Jumlah Pengunjung L',
            data: [<?php echo $datal; ?>]
        },
        {
            name: 'Jumlah Pengunjung P',
            data: [<?php echo $datap; ?>]
        }],
        credits: {
		  enabled: false
		}
    });
</script>