<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
        <link rel="shortcut icon" href="<?php if(isset($site['website']['logo_img_left'])){echo base_url('assets/file/img/'.$site['website']['logo_img_left']);} ?>" type="image/x-icon"/>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php if(isset($site['web']['blogname'])){echo$site['web']['blogname'];} echo' | ';if(isset($site['web']['blogpagetitle'])){echo$site['web']['blogpagetitle'];} ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GG Dev, gedank gorenk">
    <meta name="author" content="GG Dev">
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
    <!--font-awesome-->
    <link href="<?php echo base_url('assets/font-awesome/font-awesome.css'); ?>" rel="stylesheet" type="text/css" />
    <!--css_ku-->
    <link href="<?php echo base_url('assets/frontend/css/login.css'); ?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="view-content">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-12" style="z-index:100;padding:10px;">
                    <div class="logo">
                        <img src="<?php if(isset($site['web']['blogimgheader']))echo$site['web']['blogimgheader'];?>" style="max-width:100%;max-height:100%">
                    </div>
                    <div class="header-judul">
                        <div class="name-web blogname"><?php if(isset($site['web']['blogname']))echo$site['web']['blogname'];?></div>
                        <div class="description-web blogdescription"><?php if(isset($site['web']['blogdescription']))echo$site['web']['blogdescription'];?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="view-content bg-grey-old-2" style="min-height:200px">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-12" style="z-index:100">
                    <br />
                    <h1 class="title-berita" style="margin-bottom:80px">
                        <?php if(isset($site['web']['blogpagetitle'])){echo$site['web']['blogpagetitle'];}?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="view-content-berita">
        <div style="position:absolute;margin-top:-230px">
            <!--<img class="logo-background" src="<?php //if(isset($site['web']['blogimgheader']))echo$site['web']['blogimgheader'];?>">-->
        </div>

        <!-- content start -->
        <?php
        if(isset($modules)&&isset($content)&&$this->uri->segment(2)!='template'){
            include(APPPATH.'modules/'.$modules.'/views/'.$content.'.php');
        }else{
            include(APPPATH.'modules/web/views/v_web_baru.php');
        }
        ?>
        <!-- content end -->

    </div>
</body>
</html>

<script src="<?php echo base_url('assets/jquery/jquery-2.1.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugin/validation/jquery.validate.js'); ?>"></script>
<script>
    $(document).ready(function () {
        $('#form-login').validate();
        $('#form-lupapass').validate();
        $('#form-newpass').validate();
        $('#login-box').fadeIn("slow");
        $('#lupapass-box').fadeIn("slow");
        $('#newpass-box').fadeIn("slow");
    });

    function login(){
        if($('#usr').val()!=''&&$('#psw').val()!=''){
            $('#login-box').fadeOut("slow");
        }
    }

    function back(){
        $().fadeOut("slow");
        window.location.assign("<?php echo site_url('index.php'); ?>");
    }

    function back_login(){
        $().fadeOut("slow");
        window.location.assign("<?php echo site_url('login'); ?>");
    }

    function back_lupapass(){
        $().fadeOut("slow");
        window.location.assign("<?php echo site_url('login/lupapass'); ?>");
    }

    function check_konfirmasi(){
        if(document.getElementById('password2').value!=document.getElementById('password1').value){
            $('#msg').show();
            $('#isi-psn').html('Konfirmasi Password tidak tepat!');
            window.setTimeout(function(){
                $('#msg').fadeOut('slow');
            }, 2000);
        }
    }
</script>
<script language="JavaScript">
    var left="";
    var right="";
    var msg=" -<?php if(isset($site['web']['blogname'])){echo$site['web']['blogname'];} echo' | ';if(isset($site['web']['blogpagetitle'])){echo$site['web']['blogpagetitle'];}?>- ";
    var speed=200;

    function scroll_title() {
            document.title=left+msg+right;
            msg=msg.substring(1,msg.length)+msg.charAt(0);
            setTimeout("scroll_title()",speed);
    }
    scroll_title();
</script>

<!--message-->
<?php if($this->session->userdata('psn')!=''){?>
<script>
$(document).ready(function () {
    $('#msg').show();
    window.setTimeout(function(){
      $('#msg').fadeOut('slow');
        jQuery.ajax({
            type : "GET",
            url : "<?php echo site_url('login/hps_ses_msg'); ?>",
            dataType: 'json',
            success: function(data){
                console.log(data);
            }
        });
    }, 2000);
});
</script>
<?php } ?>
<div id="msg" class="modal fade bs-warning-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display:none;top:200px" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-center">
        <div class="modal-content">
            <div class="modal-body text-center">
                <i class="icon icon-warning-sign"></i>
                <msg id="isi-psn"><?php print_r($this->session->userdata('psn'));?></msg>
            </div>
        </div>
    </div>
</div>

<!--<a href="gedankgorenk.net">By GG Developer</a>-->
<!--you can send a message to gedankgorenk@rocketmail.com-->