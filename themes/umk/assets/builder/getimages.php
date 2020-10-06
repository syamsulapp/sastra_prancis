<?php
// if ((int)$_POST['img'] === 1) {
	


	$imagesFolder = 'images';
	$imagesArray = array();

	$src = '../' . $imagesFolder;

	// Get real path for our folder
	$rootPath = realpath($src);

	// Create recursive directory iterator
	$files = new RecursiveIteratorIterator(
	    new RecursiveDirectoryIterator($rootPath),
	    RecursiveIteratorIterator::LEAVES_ONLY
	);

	foreach ($files as $name => $file)
	{
	    // Skip directories
	    if (!$file->isDir())
	    {
	        // Get real and relative path for current file
	        $filePath = $file->getRealPath();
	        $relativePath = substr($filePath, strlen($rootPath) + 1);
	        // echo  $imagesFolder . DIRECTORY_SEPARATOR . $relativePath . '<br>';


	        $imagesArray[] = array(
	        		'title' => $imagesFolder . "/" . str_replace("\\", "/", $relativePath),
	        		'value' => $imagesFolder . "/" . str_replace("\\", "/", $relativePath),
	        	);

	        // echo $imagesFolder . DIRECTORY_SEPARATOR . $relativePath . '<br>';
			// echo(  $imagesFolder . "/" . str_replace("\\", "/", $relativePath) ).'<br>';

	    }
	}

	echo( json_encode($imagesArray) );

//} //end if