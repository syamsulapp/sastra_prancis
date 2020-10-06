<?php
//folder to upload
$folder_name = '!uploads';
$dst = DIRECTORY_SEPARATOR . 'images'. DIRECTORY_SEPARATOR . $folder_name  . DIRECTORY_SEPARATOR;
$src = '../';
$upload_path = realpath($src).$dst;
if (!is_dir($upload_path)) {
	mkdir($upload_path);
}

//upload files
if (!empty($_FILES)) {
    $temp_file = $_FILES['file']['tmp_name'];
    $target_file =  $upload_path . DIRECTORY_SEPARATOR . $_FILES['file']['name'];    
    move_uploaded_file($temp_file,$target_file);
}