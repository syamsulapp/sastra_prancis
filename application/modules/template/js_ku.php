<script type="text/javascript">
var three="<?php echo$this->uri->segment(3);?>";
var warna=['arts','community','global','public','science','sustainability','teaching','unparalleled','teaching'];
var url="<?php echo site_url(); ?>";
$(window).load(function(){
    var url="<?php echo site_url();?>";
    var base_url = "<?php echo base_url()?>";

    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    var months_ = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    //get banner utama
    $.ajax({
        'url': "<?php echo site_url('tampilan/getbannerutama');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log(data);
            if(data.data.banner!=null){
                $('.banner-utama').html('<a target="balank" href="'+data.data.banner[0]['slug']+'"><img src="'+data.data.banner[0]['gambar']+'" style="width:100%"></a>');
            }
        }
    });

    //get banner tulisan
    $.ajax({
        'url': "<?php echo site_url('tampilan/getbannertulisan');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log(data);
            if(data.data.banner!=false){
                banner='<div class="listing berita-auto listing-black shadow">'
                        +'<div class="first-auto item-black">'
                            +'<div class="side-right">'
                                +'<div class="nama-universitas blogname">'
                                +'</div>'
                                +'<div class="title-berita-terbaru">'
                                    +'<i class="fa fa-picture-o"></i> Banner'
                                    +'</div>'
                                +'</div>'
                                +'<div class="embed-container-berita">';
                                $.each(data.data.banner, function(i,n){
                                    banner+='<a target="balank" href="'+n['slug']+'"><img src="'+n['gambar']+'" style="width:100%"></a>';
                                });
                                banner+='</div>'
                            +'</div>'
                        +'</div>';
                $('.banner-tulisan').append(banner);
            }
        }
    });

    //get banner halaman
    $.ajax({
        'url': "<?php echo site_url('tampilan/getbannerhalaman');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log(data);
            if(data.data.banner!=false){
                banner = '<div class="listing berita-auto listing-black shadow">'
                        +'<div class="first-auto item-black">'
                            +'<div class="side-right">'
                                +'<div class="nama-universitas blogname">'
                                +'</div>'
                                +'<div class="title-berita-terbaru">'
                                    +'<i class="fa fa-picture-o"></i> Banner'
                                    +'</div>'
                                +'</div>'
                                +'<div class="embed-container-berita">';
                                $.each(data.data.banner, function(i,n){
                                    banner+='<a target="balank" href="'+n['slug']+'"><img src="'+n['gambar']+'" style="width:100%"></a>';
                                });
                                banner+='</div>'
                            +'</div>'
                        +'</div>';
                $('.banner-halaman').append(banner);
            }
        }
    });

    //get web
    $.ajax({
        'url': "<?php echo site_url('tampilan/getweb');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log(data);
            if(data.data.web!=null){
                $('.blogname').html(data.data.web.blogname);
                $('.blogdescription').html(data.data.web.blogdescription);
                $('.alamat-kantor').html(data.data.web.blogaddress);
                $('.no-telp-kantor').html(data.data.web.blogtlp);
                if(data.data.web.blogimgheader!=''){
                    $('.logo').html('<img src="'+data.data.web.blogimgheader+'" style="max-height:100%;max-width:100%">');
                }
                //$('.web').attr('style',data.data.web.blogbodybackground);
                /*$('.body').attr('style','background:#F3F3F1 url("'+data.data.web.blogimgheader+'") no-repeat left 90px;'
                    +'background:url("'+data.data.web.blogimgheader+'") no-repeat left 90px, -moz-linear-gradient(top, #F3F3F1 10%, white 100%);'
                    +'background:url("'+data.data.web.blogimgheader+'") no-repeat left 90px, -webkit-gradient(linear, left top, left bottom, color-stop(10%,#F3F3F1), color-stop(100%,white);'
                    +'background:url("'+data.data.web.blogimgheader+'") no-repeat left 90px, -webkit-linear-gradient(top, #F3F3F1 10%,white 100%);'
                    +'background:url("'+data.data.web.blogimgheader+'") no-repeat left 90px, -o-linear-gradient(top, #F3F3F1 10%,white 100%);'
                    +'background:url("'+data.data.web.blogimgheader+'") no-repeat left 90px, linear-gradient(top, #F3F3F1 10%,white 100%);');*/
            }
        }
    });

    //berita terbaru
    $.ajax({
        'url': "<?php echo site_url('web/tulisanterbarujson');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('berita 2');
            console.log(data);
            if(data.tulisan!=null){
                berita='';
                i=1;
                left=0;
                $.each(data.tulisan, function(i,n){
                    if(i==1){first='first';}else{first='';}
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    berita+='<li class="'+first+'" style="position: absolute; top: 0px; left: '+left+'px; ">'
                            +'<p class="p"><i class="fa fa-edit"></i> '
                                +'<a class="more" href="'+url+'lihat2/berita/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'+ucfirst(n['judul'].substr(0,30).toLowerCase())
                                +'...</a>'
                            +'</p>'
                            +'<p class="p">'
                                +strip_tags(n['tulisan'],'').substr(0,80).toLowerCase()+'...'
                            +'</p>'
                            +'<p class="data"><a class="more" href="'+url+'lihat2/berita/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'
                                +'Read more…</a>'
                            +'</p>'
                            +'';
                        tgl=n['tgl_tulisan'].split(' ');
                        var date = new Date(tgl[0]);
                        tgl_=tgl[0].split('-');
                        berita+='<div class="data-">'
                            +'<i class="fa fa-calendar"></i> '
                            +myDays[date.getDay()]+', '
                            +tgl_[2]+' '
                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                            +tgl_[0]
                        +'</div>';
                    berita+='</li>';
                    i++;
                    left+=219;
                });
                berita+='';
                $('.list-berita-beranda').html(berita);
            }
        }
    });

    //agenda
    $.ajax({
        'url': "<?php echo site_url('web/agendajson');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('agenda');
            console.log(data);
            if(data.tulisan!=null){
                ul_='';
                i=1;
                left=0;
                $.each(data.tulisan, function(i,n){
                    tgl=n['tgl_modifikasi'].split(' ');
                    var date = new Date(tgl[0]);
                    tgl_=tgl[0].split('-');
                    if(i==1){first='first';}else{first='';}
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    ul_+='<div class="agenda-">';
                        ul_+='<li class="'+first+'" style="position: absolute; top: 0px; left: '+left+'px; ">'
                            +'<p class="p"><i class="fa fa-calendar"></i> '
                                +'<a class="more"href="'+url+'lihat2/event/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'+ucfirst(n['judul'].substr(0,30).toLowerCase())
                                +'...</a>'
                            +'</p>'
                            +'<p class="p">'
                                +'<div class="event-item">'
                                    +'<div class="event-date">'
                                        +months_[date.getMonth(n['tgl_modifikasi'])]+'<br>'+tgl_[2]
                                    +'</div>'
                                    +'<div class="event-judul">'
                                        +'<p class="p">'+strip_tags(n['tulisan'],'').substr(0,45).toLowerCase()+'...</p>'
                                    +'</div>'
                                +'</div>'
                            +'</p>'
                            +'<p class="data"><a class="more"href="'+url+'lihat2/event/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'
                                +'Read more…</a>'
                            +'</p>'
                            +'';
                        tgl=n['tgl_tulisan'].split(' ');
                        var date = new Date(tgl[0]);
                        tgl_=tgl[0].split('-');
                        ul_+='<div class="data-">'
                            +'<i class="fa fa-calendar"></i> '
                            +myDays[date.getDay()]+', '
                            +tgl_[2]+' '
                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                            +tgl_[0]
                        +'</div>';
                    ul_+='</div>';
                    i++;
                    left+=219;
                });
                $('.list-agenda-beranda').html(ul_);
            }
        }
    });

    //tautan
    $.ajax({
        'url': "<?php echo site_url('web/tautanjson');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('tautan');
            console.log(data.tulisan);
            if(data.tulisan!=null){
                ul_='';
                i=1;
                left=0;
                $.each(data.tulisan, function(i,n){
                    if(i==1){first='first';}else{first='';}
                    ul_+='<li class="'+first+' text-center" style="position: absolute; top: 0px; left: '+left+'px; ">'
                            +'<p class="data"><i class="fa fa-link"></i> '+n['kategori']+''+'</p>'
                            +'<a target="blank" class="more" href="'+n['slug']+'">'
                            +'<p class="p">'
                                +'<img src="'+n['icon']+'" style="max-width:100%;max-height:85%">'
                            +'</p>'
                            +'</a>'
                            +'';
                    ul_+='</div>';
                    i++;
                    left+=219;
                });
                $('.list-tautan-beranda').html(ul_);
            }
        }
    });

    //pengumuman
    $.ajax({
        'url': "<?php echo site_url('web/pengumumanjson');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('pengumuman');
            console.log(data);
            if(data.tulisan!=null){
                ul___='';
                i=1;
                left=0;
                $.each(data.tulisan, function(i,n){
                    if(i==1){first='first';}else{first='';}
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    ul___+='<div class="agenda-">';
                        ul___+='<li class="'+first+'" style="position: absolute; top: 0px; left: '+left+'px; ">'
                            +'<p class="p"><i class="fa fa-thumb-tack"></i> '
                                +'<a class="more" href="'+url+'lihat2/pengumuman/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'+ucfirst(n['judul'].substr(0,30).toLowerCase())
                                +'...</a>'
                            +'</p>'
                            +'<p class="p">'
                                +strip_tags(n['tulisan'],'').substr(0,80).toLowerCase()+'...'
                            +'</p>'
                            +'<p class="data"><a class="more" href="'+url+'lihat2/pengumuman/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'
                                +'Read more…</a>'
                            +'</p>'
                            +'';
                        tgl=n['tgl_tulisan'].split(' ');
                        var date = new Date(tgl[0]);
                        tgl_=tgl[0].split('-');
                        ul___+='<div class="data-">'
                            +'<i class="fa fa-calendar"></i> '
                            +myDays[date.getDay()]+', '
                            +tgl_[2]+' '
                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                            +tgl_[0]
                        +'</div>';
                    ul___+='</div>';
                    i++;
                    left+=219;
                });
                $('.list-pengumuman-beranda').html(ul___);
            }
        }
    });

    //menu
    $.ajax({
        'url': "<?php echo site_url('tampilan/getmenuutama');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log(data);
            if(data.data.menu!=null){
                menu='';
                $.each(data.data.menu, function(i,n){
                    if(data.data.parent[0][n['id_kategori']]!=null){
                        var element_count = 0;
                        for(var e in data.data.parent[0][n['id_kategori']]){
                            if(data.data.parent[0][n['id_kategori']].hasOwnProperty(e)){
                                element_count++;
                            }
                        }
                        if(element_count>1){
                            menu+='<li id="li-'+n['id_kategori']+'" class="dropdown">'
                                +'<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'
                                    +n['kategori']
                                +' <span class="caret"></span></a>';
                                menu+='<ul class="dropdown-menu" role="menu">';
                                $.each(data.data.parent[0][n['id_kategori']], function(j,m){
                                    if(m['kategori']){
                                        menu+='<li class="';
                                        if(three==m['slug']){
                                            menu+='active';
                                        }
                                        menu+='">'
                                            +'<a href="'+url+'lihat2/kategori/'+m['slug']+'#li-'+n['id_kategori']+'">'
                                                +m['kategori']
                                            +'</a>'
                                        +'</li>';
                                    }
                                    if(m['judul']){
                                        menu+='<li class="';
                                        judul=m['judul'].split(' ');
                                        judul_='';
                                        for(x=0;x<judul.length;x++){
                                            if(x==0){
                                                judul_+=judul[x];
                                            }else{
                                                judul_+='-'+judul[x];
                                            }
                                        }
                                        if(m['tipe']=='page'){
                                            if(three==judul_.toLowerCase()){
                                                menu+='active';
                                            }
                                            menu+='">'
                                                +'<a href="'+url+'lihat2/halaman/'+m['id_tulisan']+'-'+judul_.toLowerCase()+'#li-'+n['id_kategori']+'">'
                                                    +m['judul']
                                                +'</a>'
                                            +'</li>';
                                        }else{
                                            if(three==m['id_tulisan']){
                                                menu+='active';
                                            }
                                            menu+='">'
                                                +'<a href="'+url+'lihat2/album/'+m['id_tulisan']+'#li-'+n['id_kategori']+'">'
                                                    +m['judul']
                                                +'</a>'
                                            +'</li>';
                                        }
                                    }
                                });
                                menu+='</ul>';
                            menu+='</li>';
                        }else{
                            var m = data.data.parent[0][n['id_kategori']][0];
                            if(m['kategori']){
                                menu+='<li class="';
                                if(three==m['slug']){
                                    menu+='active';
                                }
                                menu+='">'
                                    +'<a href="'+url+'lihat2/kategori/'+m['slug']+'#li-'+n['id_kategori']+'">'
                                        +n['kategori']
                                    +'</a>'
                                +'</li>';
                            }
                            if(m['judul']){
                                menu+='<li class="';
                                judul=m['judul'].split(' ');
                                judul_='';
                                for(x=0;x<judul.length;x++){
                                    if(x==0){
                                        judul_+=judul[x];
                                    }else{
                                        judul_+='-'+judul[x];
                                    }
                                }
                                if(m['tipe']=='page'){
                                    if(three==judul_.toLowerCase()){
                                        menu+='active';
                                    }
                                    menu+='">'
                                        +'<a href="'+url+'lihat2/halaman/'+m['id_tulisan']+'-'+judul_.toLowerCase()+'#li-'+n['id_kategori']+'">'
                                            +n['kategori']
                                        +'</a>'
                                    +'</li>';
                                }else{
                                    if(three==m['id_tulisan']){
                                        menu+='active';
                                    }
                                    menu+='">'
                                        +'<a href="'+url+'lihat2/album/'+m['id_tulisan']+'#li-'+n['id_kategori']+'">'
                                            +n['kategori']
                                        +'</a>'
                                    +'</li>';
                                }
                            }
                        }
                    }else{
                        if(n['kategori']){
                            menu+='<li class="';
                            if(three==n['slug']){
                                menu+='active';
                            }
                            menu+='">'
                                +'<a href="'+n['slug']+'">'
                                    +n['kategori']
                                +'</a>'
                            +'</li>';
                        }
                    }
                });
                $('#menu-utama').append(menu);
                var hash = window.location.hash;
                //$(hash+':first').addClass('active');
            }
        }
    });

    //menu atas
    $.ajax({
        'url': "<?php echo site_url('tampilan/getmenuatas');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log(data);
            if(data.data.menu!=null){
                menu='';
                $.each(data.data.menu, function(i,n){
                    if(data.data.parent[0][n['id_kategori']]!=null){
                        var element_count = 0;
                        for(var e in data.data.parent[0][n['id_kategori']]){
                            if(data.data.parent[0][n['id_kategori']].hasOwnProperty(e)){
                                element_count++;
                            }
                        }
                        if(element_count>1){
                            menu+='<li id="li-'+n['id_kategori']+'" class="dropdown">'
                                +'<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'
                                    +n['kategori']
                                +' <span class="caret"></span></a>';
                                menu+='<ul class="dropdown-menu" role="menu" style="z-index:9999999999">';
                                $.each(data.data.parent[0][n['id_kategori']], function(j,m){
                                    if(m['kategori']){
                                        menu+='<li class="';
                                        if(three==m['slug']){
                                            menu+='active';
                                        }
                                        menu+='">'
                                            +'<a href="'+url+'lihat2/kategori/'+m['slug']+'#li-'+n['id_kategori']+'">'
                                                +m['kategori']
                                            +'</a>'
                                        +'</li>';
                                    }
                                    if(m['judul']){
                                        menu+='<li class="';
                                        judul=m['judul'].split(' ');
                                        judul_='';
                                        for(x=0;x<judul.length;x++){
                                            if(x==0){
                                                judul_+=judul[x];
                                            }else{
                                                judul_+='-'+judul[x];
                                            }
                                        }
                                        if(m['tipe']=='page'){
                                            if(three==judul_.toLowerCase()){
                                                menu+='active';
                                            }
                                            menu+='">'
                                                +'<a href="'+url+'lihat2/halaman/'+m['id_tulisan']+'-'+judul_.toLowerCase()+'#li-'+n['id_kategori']+'">'
                                                    +m['judul']
                                                +'</a>'
                                            +'</li>';
                                        }else{
                                            if(three==m['id_tulisan']){
                                                menu+='active';
                                            }
                                            menu+='">'
                                                +'<a href="'+url+'lihat2/album/'+m['id_tulisan']+'#li-'+n['id_kategori']+'">'
                                                    +m['judul']
                                                +'</a>'
                                            +'</li>';
                                        }
                                    }
                                });
                                menu+='</ul>';
                            menu+='</li>';
                        }else{
                            var m = data.data.parent[0][n['id_kategori']][0];
                            if(m['kategori']){
                                menu+='<li class="';
                                if(three==m['slug']){
                                    menu+='active';
                                }
                                menu+='">'
                                    +'<a href="'+url+'lihat2/kategori/'+m['slug']+'#li-'+n['id_kategori']+'">'
                                        +n['kategori']
                                    +'</a>'
                                +'</li>';
                            }
                            if(m['judul']){
                                menu+='<li class="';
                                judul=m['judul'].split(' ');
                                judul_='';
                                for(x=0;x<judul.length;x++){
                                    if(x==0){
                                        judul_+=judul[x];
                                    }else{
                                        judul_+='-'+judul[x];
                                    }
                                }
                                if(m['tipe']=='page'){
                                    if(three==judul_.toLowerCase()){
                                        menu+='active';
                                    }
                                    menu+='">'
                                        +'<a href="'+url+'lihat2/halaman/'+m['id_tulisan']+'-'+judul_.toLowerCase()+'#li-'+n['id_kategori']+'">'
                                            +n['kategori']
                                        +'</a>'
                                    +'</li>';
                                }else{
                                    if(three==m['id_tulisan']){
                                        menu+='active';
                                    }
                                    menu+='">'
                                        +'<a href="'+url+'lihat2/album/'+m['id_tulisan']+'#li-'+n['id_kategori']+'">'
                                            +n['kategori']
                                        +'</a>'
                                    +'</li>';
                                }
                            }
                        }
                    }else{
                        if(n['kategori']){
                            menu+='<li class="';
                            if(three==n['slug']){
                                menu+='active';
                            }
                            menu+='">'
                                +'<a href="'+n['slug']+'">'
                                    +n['kategori']
                                +'</a>'
                            +'</li>';
                        }
                    }
                });
                $('#menu-atas').append(menu);
                var hash = window.location.hash;
                //$(hash+':first').addClass('active');
            }
        }
    });

    //menu bawah
    $.ajax({
        'url': "<?php echo site_url('tampilan/getmenubawah');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log(data);
            if(data.data.menu!=null){
                menu='';
                $.each(data.data.menu, function(i,n){
                    if(data.data.parent[0][n['id_kategori']]!=null){
                        var element_count = 0;
                        for(var e in data.data.parent[0][n['id_kategori']]){
                            if(data.data.parent[0][n['id_kategori']].hasOwnProperty(e)){
                                element_count++;
                            }
                        }
                        if(element_count>1){
                            menu+='<li class="footer-menu-divider">⋅</li>';
                            menu+='<li id="li-'+n['id_kategori']+'" class="dropdown">'
                                +'<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'
                                    +n['kategori']
                                +' <span class="caret"></span></a>';
                                menu+='<ul class="dropdown-menu" role="menu">';
                                $.each(data.data.parent[0][n['id_kategori']], function(j,m){
                                    if(m['kategori']){
                                        menu+='<li class="';
                                        if(three==m['slug']){
                                            menu+='active';
                                        }
                                        menu+='">'
                                            +'<a href="'+url+'lihat2/kategori/'+m['slug']+'#li-'+n['id_kategori']+'">'
                                                +m['kategori']
                                            +'</a>'
                                        +'</li>';
                                    }
                                    if(m['judul']){
                                        menu+='<li class="';
                                        judul=m['judul'].split(' ');
                                        judul_='';
                                        for(x=0;x<judul.length;x++){
                                            if(x==0){
                                                judul_+=judul[x];
                                            }else{
                                                judul_+='-'+judul[x];
                                            }
                                        }
                                        if(m['tipe']=='page'){
                                            if(three==judul_.toLowerCase()){
                                                menu+='active';
                                            }
                                            menu+='">'
                                                +'<a href="'+url+'lihat2/halaman/'+m['id_tulisan']+'-'+judul_.toLowerCase()+'#li-'+n['id_kategori']+'">'
                                                    +m['judul']
                                                +'</a>'
                                            +'</li>';
                                        }else{
                                            if(three==m['id_tulisan']){
                                                menu+='active';
                                            }
                                            menu+='">'
                                                +'<a href="'+url+'lihat2/album/'+m['id_tulisan']+'#li-'+n['id_kategori']+'">'
                                                    +m['judul']
                                                +'</a>'
                                            +'</li>';
                                        }
                                    }
                                });
                                menu+='</ul>';
                            menu+='</li>';
                        }else{
                            var m = data.data.parent[0][n['id_kategori']][0];
                            menu+='<li class="footer-menu-divider">⋅</li>';
                            if(m['kategori']){
                                        menu+='<li class="';
                                        if(three==m['slug']){
                                            menu+='active';
                                        }
                                        menu+='">'
                                            +'<a href="'+url+'lihat2/kategori/'+m['slug']+'#li-'+n['id_kategori']+'">'
                                                +m['kategori']
                                            +'</a>'
                                        +'</li>';
                                    }
                                    if(m['judul']){
                                        menu+='<li class="';
                                        judul=m['judul'].split(' ');
                                        judul_='';
                                        for(x=0;x<judul.length;x++){
                                            if(x==0){
                                                judul_+=judul[x];
                                            }else{
                                                judul_+='-'+judul[x];
                                            }
                                        }
                                        if(m['tipe']=='page'){
                                            if(three==judul_.toLowerCase()){
                                                menu+='active';
                                            }
                                            menu+='">'
                                                +'<a href="'+url+'lihat2/halaman/'+m['id_tulisan']+'-'+judul_.toLowerCase()+'#li-'+n['id_kategori']+'">'
                                                    +m['judul']
                                                +'</a>'
                                            +'</li>';
                                        }else{
                                            if(three==m['id_tulisan']){
                                                menu+='active';
                                            }
                                            menu+='">'
                                                +'<a href="'+url+'lihat2/album/'+m['id_tulisan']+'#li-'+n['id_kategori']+'">'
                                                    +m['judul']
                                                +'</a>'
                                            +'</li>';
                                        }
                                    }
                        }
                    }else{
                        if(n['kategori']){
                            menu+='<li class="footer-menu-divider">⋅</li>';
                            menu+='<li class="';
                            if(three==n['slug']){
                                menu+='active';
                            }
                            menu+='">'
                                +'<a href="'+n['slug']+'">'
                                    +n['kategori']
                                +'</a>'
                            +'</li>';
                        }
                    }
                });
                $('#menu-bawah').append(menu);
                var hash = window.location.hash;
                //$(hash+':first').addClass('active');
            }
        }
    });

    //kategori
    $.ajax({
        'url': "<?php echo site_url('kategori/getkategori');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log(data);
            if(data.data!=null){
                isi(data.data);
                //isi2(data.data);
            }
        }
    });

    //semua tulisan terbaru
    $.ajax({
        'url': "<?php echo site_url('web/semuatulisanterbarujson');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('semua tulisan');
            console.log(data.tulisan);
            if(data.tulisan!=null){
                berita='';
                i=1;
                id_img='';
                $.each(data.tulisan, function(i,n){
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    if(n['tipe']=='berita'){
                        tipe='blue';
                        tulisan='Berita';
                        icon='edit';
                        link='berita';
                    }else if(n['tipe']=='quote'){
                        tipe='yellow';
                        tulisan='Quote';
                        icon='quote-left';
                        link='quote';
                    }else if(n['tipe']=='pengumuman'){
                        tipe='green-old';
                        tulisan='Pengumuman';
                        icon='thumb-tack';
                        link='pengumuman';
                    }else if(n['tipe']=='event'){
                        tipe='pink';
                        tulisan='Event';
                        icon='calendar';
                        link='event';
                    }else if(n['tipe']=='gagasan'){
                        tipe='green';
                        tulisan='Gagasan';
                        icon='paperclip';
                        link='gagasan';
                    }else if(n['tipe']=='album'){
                        tipe='ungu';
                        tulisan='Album';
                        icon='picture-o';
                        link='album';
                    }else{
                        tipe='blue';
                        tulisan='Berita';
                        icon='edit';
                        link='berita';
                    }
                    if(n['tipe']=='event'){
                        len_str=300;
                        tgl=n['tgl_modifikasi'].split(' ');
                        var date = new Date(tgl[0]);
                        tgl_=tgl[0].split('-');
                        berita+='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'
                            +'<div class="listing berita listing-'+tipe+' shadow">'
                                +'<div class="first item-'+tipe+'">'
                                    +'<strong class="channel-more"><a href="'+url+'lihat2/'+link+'""><i class="fa fa-'+icon+'"></i> '+tulisan+'</a></strong>';
                                    if(n['gambar_andalan']!=''){
                                        berita+='<div class="embed-container">'
                                            +'<img src="'+n['gambar_andalan']+'" style="max-width:100%">'
                                        +'</div>';
                                        len_str=100;
                                    }else{
                                        berita+='<div class="embed-container bg-'+tipe+'">'
                                            +'<div class="icon"><i class="fa fa-'+icon+'"></i></div>'
                                            +'<div class="judul">'
                                                +'<h3>'+n['judul'].substr(0,30).toUpperCase()+'</h3>'
                                            +'</div>'
                                        +'</div>';
                                        len_str=100;
                                    }
                                    berita+='<div class="event-item">'
                                        +'<div class="event-date">'
                                            +months_[date.getMonth(n['tgl_modifikasi'])]+'<br>'+tgl_[2]
                                        +'</div>'
                                        +'<div class="event-judul">'
                                            +'<h3 class="h3"><a href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'+n['judul'].substr(0,30)+'...</a></h3>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="event-content">'
                                        +'<p class="p">'+strip_tags(n['tulisan'],'').substr(0,len_str)+'[…] <a class="more" href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">Read more…</a></p>';
                                        berita+='<p class="data-">'
                                            +'<i class="fa fa-calendar"></i> '
                                            +myDays[date.getDay()]+', '
                                            +tgl_[2]+' '
                                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                                            +tgl_[0]
                                        +'</p>';
                                    berita+='</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    }else if(n['tipe']=='quote'){
                        len_str=200;
                        berita+='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'
                            +'<div class="listing berita listing-'+tipe+' shadow">'
                                +'<div class="first item-'+tipe+'">'
                                    +'<strong class="channel-more"><a href="'+url+'lihat2/'+link+'"><i class="fa fa-'+icon+'"></i> '+tulisan+'</a></strong>';
                                    if(n['gambar_andalan']!=''){
                                        berita+='<div class="embed-container">'
                                            +'<img src="'+n['gambar_andalan']+'" style="max-width:100%">'
                                        +'</div>';
                                        len_str=50;
                                    }else{
                                        berita+='<div class="embed-container bg-'+tipe+'">'
                                            +'<div class="icon"><i class="fa fa-'+icon+'"></i></div>'
                                            +'<div class="judul">'
                                                +'<h3>'+n['judul'].substr(0,30).toUpperCase()+'</h3>'
                                            +'</div>'
                                        +'</div>';
                                        len_str=50;
                                    }
                                    berita+='<h3 class="h3"><a href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">Quote</a></h3>'
                                    +'<div class="event-content">'
                                        +'<p class="p">'
                                            +'<span class="quote">'
                                                +'<i class="fa fa-quote-left"></i> '
                                                +strip_tags(n['tulisan'],'').substr(0,len_str).replace('<p class="p">','').replace('</p>','')+'[…]'
                                                +' <i class="fa fa-quote-right"></i>'
                                            +'</span>'
                                            +'<a class="more" href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">Read more…</a>'
                                        +'</p>';
                                        tgl=n['tgl_tulisan'].split(' ');
                                        var date = new Date(tgl[0]);
                                        tgl_=tgl[0].split('-');
                                        berita+='<p class="data-">'
                                            +'<i class="fa fa-calendar"></i> '
                                            +myDays[date.getDay()]+', '
                                            +tgl_[2]+' '
                                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                                            +tgl_[0]
                                        +'</p>';
                                    berita+='</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    }else if(n['tipe']=='album'){
                        berita+='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'
                            +'<div class="listing berita- listing-'+tipe+' shadow">'
                                +'<div class="first item-'+tipe+'">'
                                    +'<strong class="channel-more"><a href="'+url+'lihat2/'+link+'"><i class="fa fa-'+icon+'"></i> '+tulisan+'</a></strong>';
                                        berita+='<div class="embed-container">'
                                            +'<div class="album-img-utama album-img-utama-'+n['id_tulisan']+'"></div>'
                                        +'</div>';
                                    berita+='<h3 class="h3"><a href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'+n['judul'].substr(0,20)+'...</a></h3>'
                                    +'<div class="event-content album-overflow" id="album-overflow">'
                                        +'<div class="album-area-'+n['id_tulisan']+'"></div>';
                                        id_img+=n['id_tulisan']+'|'
                                        tgl=n['tgl_tulisan'].split(' ');
                                        var date = new Date(tgl[0]);
                                        tgl_=tgl[0].split('-');
                                        berita+='<p class="data-">'
                                            +'<i class="fa fa-calendar"></i> '
                                            +myDays[date.getDay()]+', '
                                            +tgl_[2]+' '
                                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                                            +tgl_[0]
                                        +'</p>';
                                    berita+='</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    }else{
                        len_str=350;
                        berita+='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'
                            +'<div class="listing berita listing-'+tipe+' shadow">'
                                +'<div class="first item-'+tipe+'">'
                                    +'<strong class="channel-more"><a href="'+url+'lihat2/'+link+'"><i class="fa fa-'+icon+'"></i> '+tulisan+'</a></strong>';
                                    if(n['gambar_andalan']!=''){
                                        berita+='<div class="embed-container">'
                                            +'<img src="'+n['gambar_andalan']+'" style="max-width:100%">'
                                        +'</div>';
                                        len_str=100;
                                    }else{
                                        berita+='<div class="embed-container bg-'+tipe+'">'
                                            +'<div class="icon"><i class="fa fa-'+icon+'"></i></div>'
                                            +'<div class="judul">'
                                                +'<h3>'+n['judul'].substr(0,30).toUpperCase()+'</h3>'
                                            +'</div>'
                                        +'</div>';
                                        len_str=100;
                                    }
                                    berita+='<h3 class="h3"><a href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'+n['judul'].substr(0,30)+'...</a></h3>'
                                    +'<div class="event-content">'
                                        +'<p class="p">'+strip_tags(n['tulisan'],'').substr(0,len_str)+'[…] <a class="more" href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">Read more…</a></p>';
                                        tgl=n['tgl_tulisan'].split(' ');
                                        var date = new Date(tgl[0]);
                                        tgl_=tgl[0].split('-');
                                        berita+='<p class="data-">'
                                            +'<i class="fa fa-calendar"></i> '
                                            +myDays[date.getDay()]+', '
                                            +tgl_[2]+' '
                                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                                            +tgl_[0]
                                        +'</p>';
                                    berita+='</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    }
                });
                berita+='';
                $('.list-tulisan-terbaru-beranda').html(berita);

                id_img_2=id_img.split('|');
                $.each(id_img_2, function(i,n){
                    if(n!=''){
                        tumbnail_gambar(n);
                    }
                });
            }
        }
    });

    //berita terbaru 2
    $.ajax({
        'url': "<?php echo site_url('web/tulisanterbarujson2');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('berita 2');
            //console.log(data);
            if(data.tulisan!=null){
                ul='<ol style="margin-left:-15px">';
                $.each(data.tulisan, function(i,n){
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    ul+='<li>'
                        +'<a href="'+url+'lihat2/berita/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'
                            +n['judul']
                        +'</a>';
                        tgl=n['tgl_tulisan'].split(' ');
                        var date = new Date(tgl[0]);
                        tgl_=tgl[0].split('-');
                        ul_+='<div class="berita-tanggal">'
                            +'<i class="glyphicon glyphicon-calendar"></i> '
                            +myDays[date.getDay()]+', '
                            +tgl_[2]+' '
                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                            +tgl_[0]+' / '
                            +tgl[1]+' '
                        +'</div>';
                    ul+='</li>';
                });
                ul+='</ol>';
                $('.list-berita-sidebar').append(ul);
            }
        }
    });

    //agenda terbaru
    $.ajax({
        'url': "<?php echo site_url('web/agendajson2');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('agenda');
            //console.log(data);
            if(data.tulisan!=null){
                ul='<ol style="margin-left:-15px">';
                $.each(data.tulisan, function(i,n){
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    ul+='<li>'
                        +'<a href="'+url+'lihat2/event/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'
                            +n['judul']
                        +'</a>';
                        tgl=n['tgl_tulisan'].split(' ');
                        var date = new Date(tgl[0]);
                        tgl_=tgl[0].split('-');
                        ul_+='<div class="berita-tanggal">'
                            +'<i class="glyphicon glyphicon-calendar"></i> '
                            +myDays[date.getDay()]+', '
                            +tgl_[2]+' '
                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                            +tgl_[0]+' / '
                            +tgl[1]+' '
                        +'</div>';
                    ul+='</li>';
                });
                ul+='</ol>';
                $('.list-agenda-sidebar').append(ul);
            }
        }
    });

    //pengumuman terbaru
    $.ajax({
        'url': "<?php echo site_url('web/pengumumanjson2');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('pengumuman');
            //console.log(data);
            if(data.tulisan!=null){
                ul='<ol style="margin-left:-15px">';
                $.each(data.tulisan, function(i,n){
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    ul+='<li>'
                        +'<a href="'+url+'lihat2/pengumuman/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'
                            +n['judul']
                        +'</a>';
                        tgl=n['tgl_tulisan'].split(' ');
                        var date = new Date(tgl[0]);
                        tgl_=tgl[0].split('-');
                        ul_+='<div class="berita-tanggal">'
                            +'<i class="glyphicon glyphicon-calendar"></i> '
                            +myDays[date.getDay()]+', '
                            +tgl_[2]+' '
                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                            +tgl_[0]+' / '
                            +tgl[1]+' '
                        +'</div>';
                    ul+='</li>';
                });
                ul+='</ol>';
                $('.list-pengumuman-sidebar').append(ul);
            }
        }
    });

    //carousel
    $.ajax({
        'url': "<?php echo site_url('web/carouselimagejson');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('carousel');
            //console.log(data);
            if(data.slide!=null){
                //console.log(data);
                var img;
                var prev;
                var next;
                var com = ['comp-a','comp-b','comp-c','comp-d'];
                img_='';
                jud_='';
                ket_='';
                link_='';
                k=0;
                $.each(data.slide, function(i,n){
                    if(k==0){
                        img_+=n['kat_order'];
                        jud_+=n['judul'];
                        ket_+=n['keterangan'];
                        link_+=n['link'];
                    }else{
                        img_+='|'+n['kat_order'];
                        jud_+='|'+n['judul'];
                        ket_+='|'+n['keterangan'];
                        link_+='|'+n['link'];
                    }
                    k++;
                });
                img=img_.split('|');
                jud=jud_.split('|');
                ket=ket_.split('|');
                link=link_.split('|');
                carousel='';
                for(j=0;j<k;j++){
                    if(j==0){
                        prev=k-1;
                    }else{
                        prev=j-1;
                    }
                    if(j+1==k){
                        next=0;
                    }else{
                        next=j+1;
                    }

                    if(j==0){
                        display='block';
                        opacity=1;
                        position='relative';
                        left=0;
                    }else{
                        display='none';
                        opacity=0;
                        position='absolute';
                        left=-793;
                    }
                    carousel+='<div class="wrap carousel-item" style="position: '+position+'; top: 0px; opacity: '+opacity+'; left: '+left+'px; display: '+display+'; z-index: 1; ">'
                        +'<div class="slide-caption '+com[j%4]+'">'
                            +'<h2><a href="'+link[j]+'">'+jud[j]+'</a></h2>'
                            +'<div class="slide-callout">'
                                +'<p class="p"><a href="'+link[j]+'">'+ket[j]+'</a></p>'
                                +'<p class="more"><a href="'+link[j]+'">Read More…</a></p>'
                            +'</div>'
                        +'</div>'
                        +'<div class="carousel-image">'
                            +'<a href="'+link[j]+'"></a>'
                            +'<a  class="prev-image" style="opacity: 0.2; ">'
                                +'<img class="" src="'+img[prev]+'" alt="'+img[prev]+'" title="'+img[prev]+'" width="522" height="348">'
                            +'</a>'
                            +'<a href="#" class="prev-image" style="opacity: 0.2; ">'
                                +'<img class="" src="'+img[prev]+'" alt="'+img[prev]+'" title="'+img[prev]+'" width="522" height="348">'
                            +'</a>'
                            +'<img class="main-image" src="'+img[j]+'" alt="'+img[j]+'" title="'+img[j]+'" width="522" height="348">'
                            +'<a href="#" class="next-image" style="opacity: 0.2; ">'
                                +'<img class="" src="'+img[next]+'" alt="'+img[next]+'" title="'+img[next]+'" width="522" height="348">'
                            +'</a>'
                            +'<a  class="next-image" style="opacity: 0.2; ">'
                                +'<img class="" src="'+img[next]+'" alt="'+img[next]+'" title="'+img[next]+'" width="522" height="348">'
                            +'</a>'
                        +'</div>'
                    +'</div>';
                }
                $('.carousel-image-content').html(carousel);
            }
        }
    });

    //gagasan terbaru 2
    $.ajax({
        'url': "<?php echo site_url('web/gagasanjson');?>",
        'dataType': 'json',
        'success': function(data){
            if(data.tulisan!=null){
                gagasan='';
                $.each(data.tulisan, function(i,n){
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    gagasan+='<h2><strong>Gagasan</strong> '+n['judul']+'</h2>'
                        +'<p class="p">'
                            +strip_tags(n['tulisan'],'').substr(0,300).toLowerCase()+'[...]'
                        +'</p>'
                        +'<p class="data"><a class="more" href="'+url+'lihat2/gagasan/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'
                            +'Read more…</a>'
                        +'</p>';
                });
                $('.gagasan-terbaru').html(gagasan);
            }
        }
    });

    //gagasan terbaru 2
    $.ajax({
        'url': "<?php echo site_url('web/quotejson');?>",
        'dataType': 'json',
        'success': function(data){
            if(data.tulisan!=null){
                quote='';
                $.each(data.tulisan, function(i,n){
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    quote='<h2><strong>Quote</strong></h2>'
                        +'<div class="text-center">'
                        +'<h2><i class="fa fa-quote-left"></i> '+strip_tags(n['tulisan'],'').substr(0,80).toLowerCase()+'[...] <i class="fa fa-quote-right"></i></h2>'
                        +'<p class="data"><a class="more" href="'+url+'lihat2/quote/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'
                            +'Read more…</a>'
                        +'</p>'
                    +'</div>';
                });
                $('.quote-terbaru').html(quote);
            }
        }
    });

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

$(document).ready(function(){
    /*$('.pdf-icon').on('click',function(){
        window.print();
    });*/

    $('#btn-seacrh-beranda').on('click',function(){
        if($('#text-pencarian-beranda').val()!=''){
            $('#form-pencarian-beranda').submit();
        }
    });

    $('#text-pencarian-beranda').on('blur',function(){
        if($('#text-pencarian-beranda').val()!=''){
            $('#form-pencarian-beranda').submit();
        }
    });
});

function get_more_home_items(){
    var dari = $('#get-more').val();
    //alert(dari);
    var sampai = 6;
    $('#get-more').val(eval(dari)+6);
    var url="<?php echo site_url();?>";
    var base_url = "<?php echo base_url()?>";
    var three="<?php echo$this->uri->segment(3);?>";

    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    var months_ = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $.ajax({
        'url': "<?php echo site_url('web/moretulisanterbarujson/"+dari+"/"+sampai+"');?>",
        //'url': "<?php echo site_url('web/semuatulisanterbarujson/"+dari+"/"+sampai+"');?>",
        'dataType': 'json',
        'success': function(data){
            //console.log('semua tulisan');
            //console.log(data.tulisan);
            if(data.tulisan!=null){
                berita='';
                i=1;
                id_img='';
                $.each(data.tulisan, function(i,n){
                    judul=strip_tags(n['judul'].replace(/[~`!@#$%^&*()+=<,>.?:;]/g,'')).split(' ');
                    judul_='';
                    for(x=0;x<judul.length;x++){
                        if(x==0){
                            judul_+=judul[x];
                        }else{
                            judul_+='-'+judul[x];
                        }
                    }
                    if(n['tipe']=='berita'){
                        tipe='blue';
                        tulisan='Berita';
                        icon='edit';
                        link='berita';
                    }else if(n['tipe']=='quote'){
                        tipe='yellow';
                        tulisan='Quote';
                        icon='quote-left';
                        link='quote';
                    }else if(n['tipe']=='pengumuman'){
                        tipe='green-old';
                        tulisan='Pengumuman';
                        icon='thumb-tack';
                        link='pengumuman';
                    }else if(n['tipe']=='event'){
                        tipe='pink';
                        tulisan='Event';
                        icon='calendar';
                        link='event';
                    }else if(n['tipe']=='gagasan'){
                        tipe='green';
                        tulisan='Gagasan';
                        icon='paperclip';
                        link='gagasan';
                    }else if(n['tipe']=='album'){
                        tipe='ungu';
                        tulisan='Album';
                        icon='picture-o';
                        link='album';
                    }else{
                        tipe='blue';
                        tulisan='Berita';
                        icon='edit';
                        link='berita';
                    }
                    if(n['tipe']=='event'){
                        len_str=120;
                        tgl=n['tgl_tulisan'].split(' ');
                        var date = new Date(tgl[0]);
                        tgl_=tgl[0].split('-');
                        berita+='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'
                            +'<div class="listing berita listing-'+tipe+' shadow" style="height:252px">'
                                +'<div class="first item-'+tipe+'" style="height:250px">'
                                    +'<strong class="channel-more"><a href="'+url+'lihat2/'+link+'""><i class="fa fa-'+icon+'"></i> '+tulisan+'</a></strong>';
                                    berita+='<div class="event-item">'
                                        +'<div class="event-date">'
                                            +months_[date.getMonth(n['tgl_tulisan'])]+'<br>'+tgl_[2]
                                        +'</div>'
                                        +'<div class="event-judul">'
                                            +'<h3 class="h3"><a href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'+ucfirst(n['judul'].substr(0,30).toLowerCase())+'...</a></h3>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="event-content" style="height:100px">'
                                        +'<p class="p">'+strip_tags(n['tulisan'],'').substr(0,len_str)+'[…] <a class="more" href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">Read more…</a></p>';
                                        berita+='<p class="data-">'
                                            +'<i class="fa fa-calendar"></i> '
                                            +myDays[date.getDay()]+', '
                                            +tgl_[2]+' '
                                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                                            +tgl_[0]
                                        +'</p>';
                                    berita+='</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    }else if(n['tipe']=='quote'){
                        len_str=110;
                        berita+='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'
                            +'<div class="listing berita listing-'+tipe+' shadow" style="height:252px">'
                                +'<div class="first item-'+tipe+'" style="height:250px">'
                                    +'<strong class="channel-more"><a href="'+url+'lihat2/'+link+'"><i class="fa fa-'+icon+'"></i> '+tulisan+'</a></strong>';
                                    berita+='<h3 class="h3"><a href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">Quote</a></h3>'
                                    +'<div class="event-content" style="height:100px">'
                                        +'<p class="p">'
                                            +'<span class="quote">'
                                                +'<i class="fa fa-quote-left"></i> '
                                                +strip_tags(n['tulisan'],'').toString().substr(0,len_str).replace('<p class="p">','').replace('</p>','')+'[…]'
                                                +' <i class="fa fa-quote-right"></i>'
                                            +'</span>'
                                            +'<a class="more" href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">Read more…</a>'
                                        +'</p>';
                                        tgl=n['tgl_tulisan'].split(' ');
                                        var date = new Date(tgl[0]);
                                        tgl_=tgl[0].split('-');
                                        berita+='<p class="data-">'
                                            +'<i class="fa fa-calendar"></i> '
                                            +myDays[date.getDay()]+', '
                                            +tgl_[2]+' '
                                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                                            +tgl_[0]
                                        +'</p>';
                                    berita+='</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    }else if(n['tipe']=='album'){
                        berita+='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'
                            +'<div class="listing berita- listing-'+tipe+' shadow" style="height:252px">'
                                +'<div class="first item-'+tipe+'" style="height:250px">'
                                    +'<strong class="channel-more"><a href="'+url+'lihat2/'+link+'"><i class="fa fa-'+icon+'"></i> '+tulisan+'</a></strong>';
                                    berita+='<h3 class="h3"><a href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'+ucfirst(n['judul'].substr(0,30).toLowerCase())+'...</a></h3>'
                                    +'<div class="event-content album-overflow" id="album-overflow" style="height:130px">'
                                        +'<div class="album-area-'+n['id_tulisan']+'"></div>';
                                        id_img+=n['id_tulisan']+'|'
                                        tgl=n['tgl_tulisan'].split(' ');
                                        var date = new Date(tgl[0]);
                                        tgl_=tgl[0].split('-');
                                        berita+='<p class="data-">'
                                            +'<i class="fa fa-calendar"></i> '
                                            +myDays[date.getDay()]+', '
                                            +tgl_[2]+' '
                                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                                            +tgl_[0]
                                        +'</p>';
                                    berita+='</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    }else{
                        len_str=130;
                        berita+='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'
                            +'<div class="listing berita listing-'+tipe+' shadow" style="height:252px">'
                                +'<div class="first item-'+tipe+'" style="height:250px">'
                                    +'<strong class="channel-more"><a href="'+url+'lihat2/'+link+'"><i class="fa fa-'+icon+'"></i> '+tulisan+'</a></strong>';
                                    berita+='<h3 class="h3"><a href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">'+ucfirst(n['judul'].substr(0,30).toLowerCase())+'...</a></h3>'
                                    +'<div class="event-content" style="height:100px">'
                                        +'<p class="p">'+strip_tags(n['tulisan'],'').substr(0,len_str)+'[…] <a class="more" href="'+url+'lihat2/'+link+'/'+n['id_tulisan']+'-'+judul_.toLowerCase()+'">Read more…</a></p>';
                                        tgl=n['tgl_tulisan'].split(' ');
                                        var date = new Date(tgl[0]);
                                        tgl_=tgl[0].split('-');
                                        berita+='<p class="data-">'
                                            +'<i class="fa fa-calendar"></i> '
                                            +myDays[date.getDay()]+', '
                                            +tgl_[2]+' '
                                            +months[date.getMonth(n['tgl_tulisan'])]+' '
                                            +tgl_[0]
                                        +'</p>';
                                    berita+='</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>';
                    }
                });
                berita+='';
                $('.list-tulisan-lainnya-beranda').append(berita);

                id_img_2=id_img.split('|');
                $.each(id_img_2, function(i,n){
                    if(n!=''){
                        tumbnail_gambar(n);
                    }
                });
            }
        }
    });
}

function isi(data){
    if(data.error==0){
        ul = '<ul>';
        $.each(data.kategori, function(i,n){
            j=getRandomInt(1,8);
            ul+='<li id="hapus-row-kategori-'+n['id_kategori']+'" class="kat-'+n['slug']+' filter-'+warna[j%8]+'"><a href="'+url+'lihat2/kategori/'+n['slug']+'">'+n['kategori']+'</a></li>';
            kat_id(n['id_kategori'],0);
        });
        ul+='</ul>';
        $(".list-kategori-beranda").html(ul);
    }
    $('.kat-'+three).addClass('active');
}

function kat_id(id,i){
    $.ajax({
        'type': 'POST',
        'url': '<?php echo site_url("kategori/getkategori");?>',
        'dataType': 'json',
        'data': 'id_kat='+id,
        success: function(data){
            //console.log(data);
            j=i+1;
            list_kategori = '';
            $.each(data.data.kategori, function(i,n){
                strip2='';
                for(k=0;k<j;k++){
                    strip2+='&nbsp;&nbsp;';
                }
                x=getRandomInt(1,8);
                list_kategori += '<li id="hapus-row-kategori-'+n['id_kategori']+'" class="kat-'+n['slug']+' filter-'+warna[x%8]+'"><a href="'+url+'lihat2/kategori/'+n['slug']+'">'+strip2+'<i class="glyphicon glyphicon-arrow-right"></i> '+n['kategori']+'</a></li>';

                kat_id(n['id_kategori'],j);
            });
            $(list_kategori).insertAfter("#hapus-row-kategori-"+id);
            $('.kat-'+three).addClass('active');
        }
    });
}

/*function isi2(data){
    if(data.error==0){
        ul = '<ul>';
        $.each(data.kategori, function(i,n){
            j=getRandomInt(1,8);
            ul+='<li id="hapus-row-kategori-'+n['id_kategori']+'" class="kat-'+n['slug']+' filter-'+warna[j%8]+'"><a class="active-trail" href="'+url+'lihat2/kategori/'+n['slug']+'">'+n['kategori']+'</a></li>';
            kat_id2(n['id_kategori'],0);
        });
        ul+='</ul>';
        $(".list-kategori-beranda").html(ul);
    }
    $('.kat-'+three).addClass('active-trail');
}

function kat_id2(id,i){
    $.ajax({
        'type': 'POST',
        'url': '<?php echo site_url("kategori/getkategori");?>',
        'dataType': 'json',
        'data': 'id_kat='+id,
        success: function(data){
            console.log(data);
            j=i+1;
            list_kategori = '<ul style="margin-left:0;padding-bottom:0;">';
            $.each(data.data.kategori, function(i,n){
                strip2='';
                for(k=0;k<j;k++){
                    strip2+='&nbsp;&nbsp;&nbsp;';
                }
                x=getRandomInt(1,8);
                list_kategori += '<li style="margin-left:-40px;" id="hapus-row-kategori-'+n['id_kategori']+'" class="kat-'+n['slug']+' filter-'+warna[x%8]+'"><a href="'+url+'lihat2/kategori/'+n['slug']+'">'+strip2+'<i class="glyphicon glyphicon-arrow-right"></i> '+n['kategori']+'</a></li>';

                kat_id2(n['id_kategori'],j);
            });
            list_kategori += '</ul>';
            $("#hapus-row-kategori-"+id).append(list_kategori);
            //$("#hapus-row-kategori-"+id).addClass('active-trail');
            $('.kat-'+three).addClass('active-trail');
        }
    });
}*/

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function tumbnail_gambar(three){
    $.ajax({
        'url': "<?php echo site_url('album/lihat2gambar/"+three+"');?>",
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
    thumbnail = '';
    i=1;
    $.each(data.gambar, function(i,n){
        if(i==1){
            img='<a class="thumbnail" rel="lightbox[group]" href="'+data.path+'/'+n+'">'
                    +'<img src="'+data.path+'/'+n+'" class="group1" title="'+n+'" style="opacity:1">'
                +'</a>';
            $('.album-img-utama-'+id).html(img);
        }else{
            var element_count = 0;
            for(var e in data.gambar){
                if(data.gambar.hasOwnProperty(e)){
                    element_count++;
                }
            }
            if(element_count<6){
                if(i<=3){
                    thumbnail+='<div class="thumb">'
                        +'<a class="thumbnail" rel="lightbox[group]" href="'+data.path+'/'+n+'">'
                            +'<img src="'+data.path+'/'+n+'" class="group1" style="width:100%;height:126px" title="'+n+'">'
                        +'</a>'
                    +'</div>';
                }
            }else{
                if(i<=6){
                    if(i==2){
                        thumbnail+='<div class="thumb">'
                            +'<a class="thumbnail" rel="lightbox[group]" href="'+data.path+'/'+n+'">'
                                +'<img src="'+data.path+'/'+n+'" class="group1" style="width:100%;height:126px" title="'+n+'">'
                            +'</a>'
                        +'</div>';
                    }else{
                        thumbnail+='<div class="thumb" style="width:25%">'
                            +'<a class="thumbnail" rel="lightbox[group]" href="'+data.path+'/'+n+'">'
                                +'<img src="'+data.path+'/'+n+'" class="group1" style="width:100%;height:63px;float:left" title="'+n+'">'
                            +'</a>'
                        +'</div>';
                    }
                }
            }
        }
        i++;
    });
    $('.album-area-'+id).html(thumbnail);
    $("[rel^='lightbox']").prettyPhoto();
}

function feed(id,tipe){
    var url="<?php echo site_url();?>";
    //window.location.assign(url+'lihat2/feed/'+id+'/'+tipe);
    window.open(url+'lihat2/feed/'+id+'/'+tipe, '_blank');
}

function pdf(id,tipe){
    var url="<?php echo site_url();?>";
    //window.location.assign(url+'lihat2/printPDF/'+id+'/'+tipe);
    window.open(url+'lihat2/printPDF/'+id+'/'+tipe, '_blank');
}

function feed_(id,tipe){
    var url="<?php echo site_url();?>";
    //window.location.assign(url+'lihat2/feed/'+id+'/'+tipe);
    window.open(url+'lihat2/feed/'+id+'/'+tipe, '_blank');
}

function strip_tags(str, allow) {
  allow = (((allow || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return str.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
  });
}

function ucfirst(str) {
  str += '';
  var f = str.charAt(0)
    .toUpperCase();
  return f + str.substr(1);
}

</script>

<noscript>Your browser does not support JavaScript!</noscript>