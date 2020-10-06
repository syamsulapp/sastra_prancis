<?php
$one=$this->uri->segment(1);

$bln['01']='Januari';
$bln['02']='Februari';
$bln['03']='Maret';
$bln['04']='April';
$bln['05']='Mei';
$bln['06']='Juni';
$bln['07']='Juli';
$bln['08']='Agustus';
$bln['09']='September';
$bln['10']='Oktober';
$bln['11']='November';
$bln['12']='Desember';

$hari['1']='Senin';
$hari['2']='Selasa';
$hari['3']='Rabu';
$hari['4']='Kamis';
$hari['5']='Jumat';
$hari['6']='Sabtu';
$hari['7']='Minggu';
?>

<?php //print_r($statistik);?>
<!--carousel-->
<div class="carousel" id="hp_carousel" style="position: relative; ">
    <div class="carousel-controls">
        <a class="previous" href="#"></a>
        <a class="pause play" href="#"></a>
        <a class="next" href="#"></a>
    </div>
    <div class="carousel-controls">
        <a class="previous" ></a>
        <a class="pause play" ></a>
        <a class="next" ></a>
    </div>
    <div class="view view-hedu-homepage-carousel view-id-hedu_homepage_carousel view-display-id-block view-dom-id-12d8a05a53e6a1b941b6262b36854a4c">
        <div class="view-content-carousel">
            <div class="carousel-image-content"></div>
        </div>
    </div>
</div>
<!--carousel end-->
<div class="body">
    <div id="logo-marker"></div>
    <div style="position:absolute;margin-top:30px">
        <img id="logo-background" class="logo-background" src="<?php if(isset($site['web']['blogimgheader']))echo$site['web']['blogimgheader'];?>">
    </div>

    <div class="view-content action-footer">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-utama" style="width:100%;margin:10px 0;"></div>
                </div>
            </div>
        </div>
    </div>

    <!--tab action-->
    <div class="view-content action-footer">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-12">
                    <p class="streamer-more text-right">
                        <a href="<?php echo site_url('lihat2/event');?>">Agenda</a>
                        <a href="<?php echo site_url('lihat2/berita');?>">Berita</a>
                        <a href="<?php echo site_url('lihat2/pengumuman');?>">Pengumuman</a>
                    </p>
                    <div class="streamer streamer-social">
                        <div class="heading">
                            <h2>Aktifitas <strong>Terbaru</strong></h2>
                        </div>
                        <div class="prime twitter-feed heading-tabset">
                            <ul class="heading-tab">
                                <li id="listing-agenda" class="active">
                                    <a href="<?php echo site_url('lihat2/agenda');?>"><i class="fa fa-calendar"></i> Agenda</a>
                                </li>
                                <li class="" id="listing-berita">
                                    <a href="<?php echo site_url('lihat2/agenda');?>"><i class="fa fa-edit"></i> Berita</a>
                                </li>
                                <li class="" id="listing-pengumuman">
                                    <a href="<?php echo site_url('lihat2/agenda');?>"><i class="fa fa-thumb-tack"></i> Pengumuman</a>
                                </li>
                            </ul>

                            <!--agenda-->
                            <ul class="list-agenda-beranda listing slider" style="width: 656px; position: relative; overflow-x: hidden; overflow-y: hidden; display: block; list-style:none" id="ul-agenda"></ul>
                            <!--agenda end-->

                            <!--berita-->
                            <ul class="list-berita-beranda listing slider" style="width: 656px; position: relative; overflow-x: hidden; overflow-y: hidden; display: block; list-style:none" id="ul-berita"></ul>
                            <!--berita end-->

                            <!--pengumuman-->
                            <ul class="list-pengumuman-beranda listing slider" style="width: 656px; position: relative; overflow-x: hidden; overflow-y: hidden; display: block; list-style:none" id="ul-berita"></ul>
                            <!--pengumuman end-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--tab action end-->

    <div id="home_marker"></div>
    <div id="header_spacer"></div>
    <div class="view-content" id="kategori-fixed">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-12">
                    <div class="wrap filter-wrap" id="filter-drop">
                        <div class="filter">
                            <strong class="filter-all"><span>Kategori</span></strong>
                            <div class="list-kategori-beranda"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--content-->
    <div class="view-content">
        <div class="wrap">
            <div class="row list-tulisan-terbaru-beranda"></div>
        </div>
    </div>
    <!--content end-->

    <!--content lainnya-->
    <div class="view-content">
        <div class="wrap">
            <div class="row list-tulisan-lainnya-beranda"></div>
        </div>
    </div>
    <!--content lainnya end-->

    <!--view more-->
    <div class="view-content">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-12">
                    <input id="get-more" name="more" value="6" type="hidden">
                    <div class="load" id="view_more" onclick="get_more_home_items();"><span>lihat Lainnya</span></div>
                </div>
            </div>
        </div>
    </div>
    <!--view more end-->
</div>

<div class="container-fluid bg-grey" style="padding-top:10px">
    <!--Gagasan & Quote-->
    <div class="view-content">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-12">
                    <div class="streamer streamer-social">
                        <div class="prime twitter-feed heading-tabset" style="padding:0 10px">
                            <div class="gagasan-terbaru"></div>
                        </div>
                        <div class="heading-fluid">
                            <div class="quote-terbaru"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Gagasan & Quote end-->
</div>