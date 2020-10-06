<?php
//receive pages from local storage
$request_body = file_get_contents('php://input');
if (!$request_body) {
	die();
}
$file_name = 'project_'.time().'_'.mt_rand(10000, 99999).'.zip';
$file = file_put_contents($file_name, $request_body);
if(file_exists($file_name))
{
	echo $file_name;
}