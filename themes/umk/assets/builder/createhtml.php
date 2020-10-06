<?php
$request_body = file_get_contents('php://input');
$pages = json_decode($request_body);
foreach ($pages as $pagename => $pagecode) {
	file_put_contents('../' . $pagename . '.html', $pagecode, LOCK_EX);
	// var_dump($pagecode);
}
// var_dump($data);
// foreach ($pages as $name => $code) {
	
// }