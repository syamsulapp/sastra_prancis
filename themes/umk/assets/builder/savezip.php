<?php
//what not need to copy
$excludes = array('_builder.html', '_template.html', 'gulpfile.js', 'builder', 'node_modules', 'includes', '.', '..');
//current temp folder
$dst = 'output_'.time().'_'.mt_rand(10000, 99999);
//copy from where 
$src = '../';

//receive pages from local storage
$request_body = file_get_contents('php://input');
if (!$request_body) {
	die();
}
$pages = json_decode($request_body);

//function to copy files and folders from source to destination
function recurse_copy($src,$dst,$excludes) { 
    $dir = opendir($src); 
    //create temp folder
    mkdir($dst);
    while(false !== ( $filename = readdir($dir)) ) { 
        if (!in_array($filename, $excludes)) { 
        	// var_dump(expression)
            if ( is_dir($src . '/' . $filename) ) { 
                recurse_copy($src . '/' . $filename, $dst . '/' . $filename, $excludes); 
            } 
            else { 
                copy($src . '/' . $filename,$dst . '/' . $filename); 
            } 
        } 
    } 
    closedir($dir); 
} 

if(extension_loaded('zip') && $pages) {
	
		//copying files to temporary folder
		recurse_copy($src, $dst, $excludes);

		//saving pages from local storage
		foreach ($pages as $pagename => $pagecode) {
			file_put_contents($dst.'/' . $pagename . '.html', $pagecode, LOCK_EX);
		}

		//creating ZIP
		// Get real path for our folder
		$rootPath = realpath($dst);
		$zip_name = $dst.'.zip';

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($zip_name, ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
		    // Skip directories (they would be added automatically)
		    if (!$file->isDir())
		    {
		        // Get real and relative path for current file
		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($filePath, $relativePath);
		    }
		}

		// Zip archive will be created only after closing object
		$zip->close();

		if(file_exists($zip_name))
		{
		// zip to download
			//sending archive name to download
			echo $zip_name;
		}

} else {
	$error = "You dont have ZIP extension";
}