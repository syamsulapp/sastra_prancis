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

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>

    <!-- uikit -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/uikit/css/uikit.almost-flat.min.css"/>

    <!-- altair admin login page -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/login_page.min.css" />

</head>
<body class="login_page">
    <!-- content start -->
    <?php
    if(isset($modules)&&isset($content)&&$this->uri->segment(2)!='template'){
        include(APPPATH.'modules/'.$modules.'/views/'.$content.'.php');
    }else{
        include(APPPATH.'modules/web/views/v_web_baru.php');
    }
    ?>
    <!-- content end -->

    <!-- common functions -->
    <script src="<?php echo base_url();?>assets/js/common.min.js"></script>
    <!-- altair core functions -->
    <script src="<?php echo base_url();?>assets/js/altair_admin_common.min.js"></script>

    <!-- altair login page functions -->
    <script src="<?php echo base_url();?>assets/js/login.min.js"></script>
</body>
</html>