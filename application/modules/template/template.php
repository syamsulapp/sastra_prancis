<!doctype html>
<?php
$one = $this->uri->segment(1);
$two = $this->uri->segment(2);
$tree = $this->uri->segment(3);
?>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no" />
    <link rel="icon" type="image/png" href="<?php if (isset($site['web']['blogimgheader'])) echo base_url('assets/img/img_andalan') . '/' . $site['web']['blogimgheader']; ?>" sizes="16x16">
    <link rel="icon" type="image/png" href="<?php if (isset($site['web']['blogimgheader'])) echo base_url('assets/img/img_andalan') . '/' . $site['web']['blogimgheader']; ?>" sizes="32x32">
    <title><?php if (isset($site['web']['blogname'])) {
                echo $site['web']['blogname'];
            } else {
                echo 'title';
            } ?> | <?php if (isset($site['page'])) {
                        echo $site['page'];
                    } else {
                        echo 'page';
                    } ?></title>

    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/uikit/css/uikit.almost-flat.min.css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/main.min.css" media="all">
    <!-- bootstrap -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--font-awesome-->
    <link href="<?php echo base_url('assets/font-awesome/font-awesome.css'); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/coba.css" media="all">
    <script src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js'); ?>"></script>

</head>

<body class="sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <header id="header_main">
        <div class="header_main_content">
            <nav class="uk-navbar">
                <!-- main sidebar switch -->
                <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                    <span class="sSwitchIcon"></span>
                </a>
                <!-- secondary sidebar switch -->
                <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                    <span class="sSwitchIcon"></span>
                </a>
                <div id="menu_top" class="uk-float-left uk-hidden-small">
                    <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                        <a href="#" class="top_menu_toggle"><i class="material-icons md-24">&#xE8F0;</i></a>
                        <div class="uk-dropdown uk-dropdown-width-1">
                            <div class="uk-grid uk-dropdown-grid" data-uk-grid-margin>
                                <div class="uk-width">
                                    <div class="uk-grid uk-margin-top uk-margin-bottom uk-text-center" data-uk-grid-margin>
                                        <a href="<?php echo site_url('tulisan/baru'); ?>">
                                            <i class="material-icons md-36">&#xE8D2;</i>
                                            <span class="uk-text-muted uk-display-block">Tulisan</span>
                                        </a>
                                        <a href="<?php echo site_url('halaman/baru'); ?>">
                                            <i class="material-icons md-36">&#xE24D;</i>
                                            <span class="uk-text-muted uk-display-block">Halaman</span>
                                        </a>
                                        <a href="<?php echo site_url('album'); ?>">
                                            <i class="material-icons md-36 md-color-red-600">&#xE24D;</i>
                                            <span class="uk-text-muted uk-display-block">Album</span>
                                        </a>
                                        <a href="<?php echo site_url('video'); ?>">
                                            <i class="material-icons md-36">&#xE24D;</i>
                                            <span class="uk-text-muted uk-display-block">Video</span>
                                        </a>
                                        <a href="<?php echo site_url('poling'); ?>">
                                            <i class="material-icons md-36">&#xE85C;</i>
                                            <span class="uk-text-muted uk-display-block">Poling</span>
                                        </a>
                                        <a href="<?php echo site_url('pengguna/baru'); ?>">
                                            <i class="material-icons md-36">&#xE87C;</i>
                                            <span class="uk-text-muted uk-display-block">Pengguna</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav user_actions">
                        <!-- <li><a href="#" id="main_search_btn" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE8B6;</i></a></li> -->
                        <li data-uk-dropdown="{mode:'click'}">
                            <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i><span class="uk-badge">
                                    <?php if ($this->session->userdata('level') == 'administrator') { ?>
                                        <?php echo ($jml_komentar2 + $jml_testimoni2); ?>
                                    <?php } else { ?>
                                        <?php echo $jml_komentar2; ?>
                                    <?php } ?>
                                </span></a>
                            <div class="uk-dropdown uk-dropdown-xlarge uk-dropdown-flip">
                                <div class="md-card-content">
                                    <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                                        <li class="uk-width-1-2 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Komentar (<?php echo $jml_komentar2; ?>)</a></li>
                                        <?php if ($this->session->userdata('level') == 'administrator') { ?>
                                            <li class="uk-width-1-2"><a href="#" class="js-uk-prevent uk-text-small">Testimoni (<?php echo $jml_testimoni2; ?>)</a></li>
                                        <?php } ?>
                                    </ul>
                                    <ul id="header_alerts" class="uk-switcher uk-margin">
                                        <li>
                                            <ul class="md-list md-list-addon">
                                                <?php if (@$kom['komentar'] && $kom['komentar'] != null) {
                                                    foreach ($kom['komentar'] as $row) {
                                                ?>
                                                        <li>
                                                            <div class="md-list-addon-element">
                                                                <span class="md-user-letters md-bg-cyan"><?php echo substr($row['nama'], 0, 2); ?></span>
                                                            </div>
                                                            <div class="md-list-content">
                                                                <span class="md-list-heading"><a href="<?php echo site_url('komentar/menunggu'); ?>"><?php echo $row['nama']; ?></a></span>
                                                                <span class="uk-text-small uk-text-muted"><?php echo substr($row['komentar'], 0, 100); ?></span>
                                                            </div>
                                                        </li>
                                                <?php
                                                    }
                                                } ?>
                                            </ul>
                                            <div class="uk-text-center uk-margin-top uk-margin-small-bottom">
                                                <a href="<?php echo site_url('komentar/menunggu'); ?>" class="md-btn md-btn-flat md-btn-flat-primary js-uk-prevent">Lihat Semua</a>
                                            </div>
                                        </li>
                                        <li>
                                            <ul class="md-list md-list-addon">
                                                <?php if (@$tes['testimoni'] && $tes['testimoni'] != null) {
                                                    foreach ($tes['testimoni'] as $row) {
                                                ?>
                                                        <li>
                                                            <div class="md-list-addon-element">
                                                                <span class="md-user-letters md-bg-cyan"><?php echo substr($row['nama'], 0, 2); ?></span>
                                                            </div>
                                                            <div class="md-list-content">
                                                                <span class="md-list-heading"><?php echo $row['nama']; ?></span>
                                                                <span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo substr($row['testimoni'], 0, 100); ?></span>
                                                            </div>
                                                        </li>
                                                <?php
                                                    }
                                                } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li data-uk-dropdown="{mode:'click'}">
                            <a href="#" class="user_action_image"><?php if ($this->session->userdata('foto') == '') { ?><i class="fa fa-user"></i><?php } else { ?>
                                    <img class="md-user-image" src="<?php echo base_url('assets/img/img_andalan') . '/' . $this->session->userdata('foto'); ?>" style="max-width:100%;max-height:100%" alt="<?php echo $this->session->userdata('username'); ?>" title="<?php echo $this->session->userdata('username'); ?>">
                                <?php } ?>
                            </a>
                            <div class="uk-dropdown uk-dropdown-small uk-dropdown-flip">
                                <ul class="uk-nav js-uk-prevent">
                                    <li><a href="<?php echo site_url('pengguna/profil'); ?>"><i class="fa fa-user"></i> <?php echo $this->session->userdata('username'); ?></a></li>
                                    <li><a href="<?php echo site_url('d4sh/logout'); ?>"><i class="fa fa-power-off"></i> Keluar</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header><!-- main header end -->

    <!-- main sidebar -->
    <aside id="sidebar_main">
        <div class="sidebar_main_header">
            <div class="sidebar_logo">
                <a href="<?php echo site_url(); ?>" class="sSidebar_hide">
                    <img src="<?php if (isset($site['web']['blogimgheader2'])) echo base_url('assets/img/img_andalan') . '/' . $site['web']['blogimgheader2']; ?>" alt="" style="height: 40px;" />
                </a>
                <a href="<?php echo site_url(); ?>" class="sSidebar_show"><img src="<?php if (isset($site['web']['blogimgheader'])) echo  base_url('assets/img/img_andalan') . '/' . $site['web']['blogimgheader']; ?>" alt="" height="32" width="32" /></a>
            </div>
        </div>
        <div class="menu_section">
            <ul>
                <li class="<?php if ($one == '' or $one == 'cms') echo 'current_section'; ?>" title="Beranda">
                    <a href="<?php echo site_url('cms'); ?>">
                        <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                        <span class="menu_title">Beranda</span>
                    </a>
                </li>
                <?php if ($this->session->userdata('level') == 'administrator' || $this->session->userdata('level') == 'editor') { ?>
                    <li class="<?php if ($one == 'sto') echo 'current_section'; ?>" title="Struktur Organisasi">
                        <a href="<?php echo site_url('sto'); ?>">
                            <span class="menu_icon"><i class="material-icons">&#xE87C;</i></span>
                            <span class="menu_title">Struktur Organisasi</span>
                        </a>
                    </li>
                <?php } ?>
                <li class="<?php if ($one == 'tulisan') echo 'current_section'; ?>">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8D2;</i></span>
                        <span class="menu_title">Tulisan</span>
                    </a>
                    <ul>
                        <li><a href="<?php echo site_url('tulisan'); ?>">Semua Tulisan</a></li>
                        <li><a href="<?php echo site_url('tulisan/baru'); ?>">Tambah Baru</a></li>
                    </ul>
                </li>
                <li class="<?php if ($one == 'kategori') echo 'current_section'; ?>">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE87B;</i></span>
                        <span class="menu_title">Kategori</span>
                    </a>
                    <ul>
                        <li><a href="<?php echo site_url('kategori'); ?>">Semua Kategori</a></li>
                    </ul>
                </li>
                <?php if ($this->session->userdata('level') == 'administrator' || $this->session->userdata('level') == 'editor') { ?>
                    <li class="<?php if ($one == 'halaman') echo 'current_section'; ?>">
                        <a href="#">
                            <span class="menu_icon"><i class="material-icons">&#xE24D;</i></span>
                            <span class="menu_title">Halaman</span>
                        </a>
                        <ul>
                            <li><a href="<?php echo site_url('halaman'); ?>">Semua Halaman</a></li>
                            <li><a href="<?php echo site_url('halaman/baru'); ?>">Tambah Baru</a></li>
                        </ul>
                    </li>
                <?php } ?>

                <li class="<?php if ($one == 'album' or $one == 'video' or $one == 'media') echo 'current_section'; ?>">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE24D;</i></span>
                        <span class="menu_title">Galeri</span>
                    </a>
                    <ul>
                        <li><a href="<?php echo site_url('album'); ?>">Album Foto</a></li>
                        <li><a href="<?php echo site_url('video'); ?>">Video</a></li>
                        <?php if ($this->session->userdata('level') == 'administrator' || $this->session->userdata('level') == 'editor') { ?>
                            <li><a href="<?php echo site_url('media'); ?>">Media</a></li>
                        <?php } ?>
                    </ul>
                </li>



                <li class="<?php if ($one == 'komentar') echo 'current_section'; ?>" title="Komentar">
                    <a href="<?php echo site_url('komentar'); ?>">
                        <span class="menu_icon"><i class="material-icons">&#xE0B9;</i></span>
                        <span class="menu_title">Komentar</span>
                    </a>
                </li>

                <?php if ($this->session->userdata('level') == 'administrator') { ?>
                    <li class="<?php if ($one == 'testimoni') echo 'current_section'; ?>" title="Testimoni">
                        <a href="<?php echo site_url('testimoni'); ?>">
                            <span class="menu_icon"><i class="material-icons">&#xE0B9;</i></span>
                            <span class="menu_title">Testimoni</span>
                        </a>
                    </li>
                    <li class="<?php if ($one == 'poling') echo 'current_section'; ?>" title="Poling">
                        <a href="<?php echo site_url('poling'); ?>">
                            <span class="menu_icon"><i class="material-icons">&#xE85C;</i></span>
                            <span class="menu_title">Poling</span>
                        </a>
                    </li>
                    <li class="<?php if ($one == 'pengguna') echo 'current_section'; ?>">
                        <a href="#">
                            <span class="menu_icon"><i class="material-icons">&#xE87C;</i></span>
                            <span class="menu_title">Pengguna</span>
                        </a>
                        <ul>
                            <li><a href="<?php echo site_url('pengguna'); ?>">Semua Pengguna</a></li>
                            <li><a href="<?php echo site_url('pengguna/baru'); ?>">Tambah Baru</a></li>
                            <li><a href="<?php echo site_url('pengguna/profil'); ?>">Profil</a></li>
                        </ul>
                    </li>
                    <li class="<?php if ($one == 'tampilan') echo 'current_section'; ?>">
                        <a href="#">
                            <span class="menu_icon"><i class="material-icons">&#xE1BD;</i></span>
                            <span class="menu_title">Pengaturan</span>
                        </a>
                        <ul>
                            <li><a href="<?php echo site_url('tampilan/menu'); ?>">Menu</a></li>
                            <li><a href="<?php echo site_url('tampilan/website'); ?>">Website</a></li>
                            <li><a href="<?php echo site_url('tampilan/gambar_bergerak'); ?>">Gambar Bergerak</a></li>
                            <li><a href="<?php echo site_url('tampilan/banner'); ?>">Banner</a></li>
                            <li><a href="<?php echo site_url('tampilan/newsticker'); ?>">Teks Berjalan</a></li>
                            <li><a href="<?php echo site_url('tampilan/theme'); ?>">Tema</a></li>
                            <li><a href="<?php echo site_url('tampilan/widget'); ?>">Widget</a></li>
                        </ul>
                    </li>
                    <li class="<?php if ($one == 'statistik') echo 'current_section'; ?>">
                        <a href="#">
                            <span class="menu_icon"><i class="material-icons">&#xE85C;</i></span>
                            <span class="menu_title">Statistik</span>
                        </a>
                        <ul>
                            <li><a href="<?php echo site_url('statistik'); ?>">Pengunjung Website</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </aside><!-- main sidebar end -->

    <div id="page_content">
        <div id="page_content_inner">
            <!-- large chart -->
            <?php if ($this->uri->segment(1) != 'pengguna' && $this->uri->segment(1) != 'cms') { ?>
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <div class="md-card">
                            <div class="md-card-toolbar">
                                <div class="md-card-toolbar-actions">
                                    <i class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</i>
                                    <?php //if(@$tombol)echo$tombol;
                                    ?>
                                </div>
                                <h3 class="md-card-toolbar-heading-text">
                                    <?php if (isset($site['page'])) {
                                        echo $site['page'];
                                    } else {
                                        echo 'page';
                                    } ?>
                                </h3>
                            </div>
                            <div class="md-card-content">
                                <div class="mGraph-wrapper">
                                    <!-- content start -->
                                    <?php
                                    include(APPPATH . 'modules/' . $modules . '/views/' . $content . '.php');
                                    ?>
                                    <!-- content end -->
                                </div>
                                <div class="md-card-fullscreen-content">
                                    <div class="uk-overflow-container">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <!-- content start -->
                <?php
                include(APPPATH . 'modules/' . $modules . '/views/' . $content . '.php');
                ?>
                <!-- content end -->
            <?php } ?>
        </div>
    </div>

    <!-- google web fonts -->
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!--bootstrap-->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.js'); ?>"></script>

    <!-- common functions -->
    <script src="<?php echo base_url(); ?>/assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="<?php echo base_url(); ?>/assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="<?php echo base_url(); ?>/assets/js/altair_admin_common.min.js"></script>


    <div id="style_switcher">
        <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
        <div class="uk-margin-medium-bottom" style="margin-bottom:10px!important;">
            <h4 class="heading_c uk-margin-bottom">Warna</h4>
            <ul class="switcher_app_themes" id="theme_switcher">
                <li class="app_style_default active_theme" data-app-theme="">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_a" data-app-theme="app_theme_a">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_b" data-app-theme="app_theme_b">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_c" data-app-theme="app_theme_c">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_d" data-app-theme="app_theme_d">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_e" data-app-theme="app_theme_e">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_f" data-app-theme="app_theme_f">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_g" data-app-theme="app_theme_g">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
            </ul>
        </div>
        <div class="uk-visible-large">
            <h4 class="heading_c">Menu Samping</h4>
            <p>
                <input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck />
                <label for="style_sidebar_mini" class="inline-label">Menu Samping Kecil</label>
            </p>
        </div>
        <?php if ($this->session->userdata('level') == 'administrator') { ?>
            <div class="uk-visible-large">
                <h4 class="heading_c">Status Website</h4>
                <p>
                    <input type="checkbox" name="status_website" id="status_website" data-md-icheck <?php if (@$sts[0]['option_value'] && $sts[0]['option_value'] != null && $sts[0]['option_value'] == 'off') {
                                                                                                        echo 'checked';
                                                                                                    } ?> />
                    <label for="status_website" class="inline-label">Non Aktifkan</label>
                </p>
            </div>
        <?php } ?>
    </div>

    <script>
        $(function() {
            var $switcher = $('#style_switcher'),
                $switcher_toggle = $('#style_switcher_toggle'),
                $theme_switcher = $('#theme_switcher'),
                $mini_sidebar_toggle = $('#style_sidebar_mini');
            $status_website = $('#status_website');

            $status_website
                .on('ifChecked', function(event) {
                    $.ajax({
                        'type': 'POST',
                        'url': '<?php echo site_url("cms/status_website"); ?>',
                        'dataType': 'json',
                        'data': 'status_website=on',
                        success: function(data) {
                            console.log(data);
                        }
                    });
                })
                .on('ifUnchecked', function(event) {
                    $.ajax({
                        'type': 'POST',
                        'url': '<?php echo site_url("cms/status_website"); ?>',
                        'dataType': 'json',
                        'data': 'status_website=off',
                        success: function(data) {
                            console.log(data);
                        }
                    });
                });

            $switcher_toggle.click(function(e) {
                e.preventDefault();
                $switcher.toggleClass('switcher_active');
            });

            $theme_switcher.children('li').click(function(e) {
                e.preventDefault();
                var $this = $(this),
                    this_theme = $this.attr('data-app-theme');

                $theme_switcher.children('li').removeClass('active_theme');
                $(this).addClass('active_theme');
                $('body')
                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g')
                    .addClass(this_theme);

                if (this_theme == '') {
                    localStorage.removeItem('altair_theme');
                } else {
                    localStorage.setItem("altair_theme", this_theme);
                }

            });

            // change input's state to checked if mini sidebar is active
            if ((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $('body').hasClass('sidebar_mini')) {
                $mini_sidebar_toggle.iCheck('check');
            }

            // toggle mini sidebar
            $mini_sidebar_toggle
                .on('ifChecked', function(event) {
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_sidebar_mini", '1');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event) {
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_sidebar_mini');
                    location.reload(true);
                });

            // hide style switcher
            $document.on('click keyup', function(e) {
                if ($switcher.hasClass('switcher_active')) {
                    if (
                        (!$(e.target).closest($switcher).length) ||
                        (e.keyCode == 27)
                    ) {
                        $switcher.removeClass('switcher_active');
                    }
                }
            });

            if (localStorage.getItem("altair_theme") !== null) {
                $theme_switcher.children('li[data-app-theme=' + localStorage.getItem("altair_theme") + ']').click();
            }
        });
    </script>

    <!--hapus-->
    <div class="modal fade bs-hapus" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-center">
            <div class="modal-content">
                <form method="post" name="form_hapus" id="form-hapus">
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
                        <button type="submit" class="btn btn-sm btn-danger square-btn-adjust" data-dismiss=".modal"><i class="fa fa-ok"></i> OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--hapus end-->

    <!--kembali-->
    <div class="modal fade bs-kembali" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-center">
            <div class="modal-content">
                <form method="post" name="form_kembali" id="form-kembali">
                    <div class="modal-header">
                        <input name="id" id="id-kembali" type="hidden">
                        <input name="element_kembali" id="element-kembali" type="hidden">
                        <button type="submit" class="close" data-dismiss="modal" aria-hidden="true" title="Close">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-arrow-left text-primary"></i> Kembalikan</h4>
                    </div>
                    <div class="modal-body text-center">
                        Anda ingin mengembalikan <span id="nama-kembali"></span>.<h4> Apakah Anda yakin?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-default square-btn-adjust" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary square-btn-adjust" data-dismiss=".modal"><i class="fa fa-ok"></i> OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--kembali end-->

    <!--note-->
    <div class="modal fade bs-note" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-m modal-dialog-center">
            <div class="modal-content">
                <form action="<?php echo site_url('cms/simpanNote'); ?>" method="post" name="form_note" id="form-note">
                    <div class="modal-header">
                        <button type="submit" class="close" data-dismiss="modal" aria-hidden="true" title="Close">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pencil text-success"></i> Note</h4>
                    </div>
                    <div class="modal-body text-center">
                        <textarea name="catatan" rows="10" class="form-control square-btn-adjust"><?php echo $catatan; ?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary square-btn-adjust" data-dismiss=".modal"><i class="fa fa-ok"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--note end-->

    <!--alertifyjs-->
    <script src="<?php echo base_url('assets/plugin/alertifyjs/alertify.js'); ?>"></script>
    <script type="text/javascript">
        alertify.defaults.transition = "slide";
    </script>

    <!--bootstrap-->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.js'); ?>"></script>
    <!--tinyeditor-->
    <script src="<?php echo base_url('assets/plugin/ckeditor/ckeditor.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugin/editors.js'); ?>"></script>

    <script src="<?php echo base_url('assets/plugin/ckeditor/adapters/jquery.js'); ?>"></script>
    <!--gallery-->
    <script src="<?php echo base_url('assets/plugin/prettyphoto/jquery.prettyPhoto.js'); ?>"></script>

    <script>
        $(function() {
            $('a').tooltip();
            $('input').tooltip();
            //$('button').tooltip();
            $('select').tooltip();
            $('.progress-lap').tooltip();
        });

        function set_del(data) {
            console.log(data);
            $('#form-hapus').attr('action', data.act);
            $('#id-hapus').val(data.id);
            $('#element-hapus').val(data.element);
            $('#nama-hapus').html(data.nm);
        }

        function set_prev(data) {
            console.log(data);
            $('#form-kembali').attr('action', data.act);
            $('#id-kembali').val(data.id);
            $('#element-kembali').val(data.element);
            $('#nama-kembali').html(data.nm);
        }

        $(document).ready(function() {
            $('#logo-cms').html('<a href="http://technophoria.co.id" target="blank" style="padding:0px;margin:0px;" title="TechnoPhoria.co.id"><img src="http://website.serverjogja.com/assets/img/techno.png" style="height:21px;float:left;margin:7px 5px;"></a>');

            $('#form-hapus').submit(function(e) {
                console.log('hapus');
                e.preventDefault();
                $.ajax({
                    'type': 'POST',
                    'url': $('#form-hapus').attr('action'),
                    'dataType': 'json',
                    'data': $(this).serialize(),
                    success: function(data) {
                        console.log(data);
                        //if(data.element!=null){
                        $('#' + data.element).remove();
                        $('.bs-hapus').modal('hide');
                        $('.modal-backdrop').remove();
                        if (data.data != null) {
                            isi(data.data);
                            var notification = alertify.notify(data.psn, data.wrng, 5, function() {});
                        } else {
                            alertify.error('ERROR!');
                        }
                        //}
                    }
                });
            });

            $('#form-kembali').submit(function(e) {
                console.log('kembali');
                e.preventDefault();
                $.ajax({
                    'type': 'POST',
                    'url': $('#form-kembali').attr('action'),
                    'dataType': 'json',
                    'data': $(this).serialize(),
                    success: function(data) {
                        console.log(data);
                        //if(data.element!=null){
                        //$('#'+data.element).remove();
                        $('.bs-kembali').hide();
                        $('.modal-backdrop').remove();
                        if (data.data != null) {
                            isi(data.data);
                            var notification = alertify.notify(data.psn, data.wrng, 5, function() {});
                        } else {
                            alertify.error('ERROR!');
                        }
                        //}
                    }
                });
            });
        });

        function submit(form) {
            $(form).submit();
        }
    </script>

</body>

</html>