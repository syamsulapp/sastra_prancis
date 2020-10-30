<link href="<?php echo base_url('assets/plugin/prettyphoto/prettyPhoto.css'); ?>" rel="stylesheet" type="text/css" />
<form name="form_hapus_album_massal" id="form-hapus-album-massal" method="post">
  <div id="dragula_sortable" class="uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-5 dragula" data-uk-grid-margin="">
    <?php if (@$data) {
      foreach ($data as $row) {
    ?>
        <div id="hapus-row-album-<?php echo $row['id_gambar_andalan']; ?>" onmouseover="row_actions_over('<?php echo $row['id_gambar_andalan']; ?>')" onmouseout="row_actions_blur('<?php echo $row['id_gambar_andalan']; ?>')" style="margin-bottom:20px;">
          <div class="md-card">
            <a class="thumbnail" rel="lightbox[group]" href="<?php echo base_url() . 'assets/img/img_andalan/' . $row['gambar_andalan']; ?>" style="margin-bottom:5px">
              <div class="md-card-head head_background" style="background-image: url('<?php echo base_url() . 'assets/img/img_andalan/thumb/' . $row['gambar_andalan']; ?>')"></div>
            </a>
          </div>
          <?php if ($this->session->userdata('level') != 'user') { ?>
            <br id="br-<?php echo $row['id_gambar_andalan']; ?>" style="display: block;">
            <p class="row-actions text-center" id="row-actions-<?php echo $row['id_gambar_andalan']; ?>" style="display:none;">
              <span class="hapus">
                <a title="Hapus <?php echo $row['gambar_andalan']; ?>" data-toggle="modal" data-target=".bs-hapus-img" onclick="set_del_({id:'<?php echo $row['id_gambar_andalan']; ?>',nm:'<?php echo $row['gambar_andalan']; ?>',act:'<?php echo site_url(); ?>media/delgambar',element:'hapus-row-album-<?php echo $row['id_gambar_andalan']; ?>'})"><i class="fa fa-trash-o"></i></a>
              </span>
            </p>
          <?php } ?>
        </div>
    <?php }
    } ?>
  </div>
  <div class="row">
    <div class="col-lg-12 text-center">
      <?php echo $halaman; ?>
    </div>
  </div>
</form>

<div class="md-fab-wrapper">
  <a href="#" id="btn-tambah-album-baru" data-toggle="modal" data-target=".bs-album" class="md-fab md-fab-accent">
    <i class="material-icons"></i>
  </a>
</div>

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
        <form name="form_gambar_andalan" id="form-gambar-andalan" method="post" enctype="multipart/form-data" action="<?php echo site_url("media/addimage"); ?>">
          <div class="form-group">
            <label>Pilih gambar dari komputer</label>
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
          <input name="nama" id="nama-gambar" type="hidden">
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

<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $("[rel^='lightbox']").prettyPhoto();

    $("#gambar-andalan").on("change", function() {
      $("#form-gambar-andalan").submit();
      $('.bs-album').modal('hide');
    });
  });

  function row_actions_over(id) {
    $('#row-actions-' + id).show();
    $('#br-' + id).hide();
  }

  function row_actions_blur(id) {
    $('#row-actions-' + id).hide();
    $('#br-' + id).show();
  }

  equalheight = function(container) {
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
        for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
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
      for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
        rowDivs[currentDiv].height(currentTallest);
      }
    });
  }

  $(window).load(function() {
    equalheight('.thumb');
  });


  $(window).resize(function() {
    equalheight('.thumb');
  });

  function set_del_(data) {
    $('#form-hapus-img').attr('action', data.act);
    $('#form-hapus').attr('action', data.act);
    $('#id-hapus').val(data.id);
    $('#nama-gambar').val(data.nm);
    $('#nama-hapus').html('<img src="<?php echo base_url(); ?>assets/img/img_andalan/' + data.nm + '" style="width:100%;">');
  }
</script>

<?php
$success = $this->session->flashdata('success');
if (!empty($success)) { ?><script>
    $(document).ready(function() {
      var notification = alertify.notify('<?php echo $success; ?>', 'success', 5, function() {});
    });
  </script><?php }
          $warning = $this->session->flashdata('warning');
          if (!empty($warning)) { ?><script>
    $(document).ready(function() {
      var notification = alertify.notify('<?php echo $warning; ?>', 'warning', 5, function() {});
    });
  </script><?php }
          $danger = $this->session->flashdata('danger');
          if (!empty($danger)) { ?><script>
    $(document).ready(function() {
      var notification = alertify.notify('<?php echo $danger; ?>', 'danger', 5, function() {});
    });
  </script><?php }
            ?>