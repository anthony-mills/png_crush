<?php
/**
* PNG compression script that leverages the tinypng.com compression service
* to recursively compress all of the PNG files that live under a directory path.
*
* @author Anthony Mills <me@anthony-mills.com>
* @link http://www.anthony-mills.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License V3
*/
define("APIKEY", 'tiny.com API key');
$imgPath = '/directory/path/of/images/';

$pathObjects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($imgPath), RecursiveIteratorIterator::SELF_FIRST);

foreach($pathObjects as $pngFile){
	if ((!empty($pngFile)) && (stristr($pngFile, '.png'))) {
		compressImage($pngFile);
	}
}

function compressImage($pngFile)
{
	echo 'Compressing: ' . $pngFile . "\r\n";
	if ((!file_exists($pngFile)) ) {
		die('Cant find file');
	}
	$fileContents = file_get_contents($pngFile);

	/**
	* Upload a copy of the image to the API
	*/
	$apiRequest = curl_init();
	curl_setopt_array($apiRequest, array(
	  CURLOPT_URL => "https://api.tinypng.com/shrink",
	  CURLOPT_USERPWD => "api:" . APIKEY,
	  CURLOPT_POSTFIELDS => $fileContents,
	  CURLOPT_BINARYTRANSFER => true,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_HEADER => true,
	  CURLOPT_SSL_VERIFYPEER => true
	));

	$apiResponse = curl_exec($apiRequest);

	/**
	* Download the compressed copy of the image
	*/
	if (curl_getinfo($apiRequest, CURLINFO_HTTP_CODE) === 201) {
	  $responseHeaders = substr($apiResponse, 0, curl_getinfo($apiRequest, CURLINFO_HEADER_SIZE));
	  foreach (explode("\r\n", $responseHeaders) as $responseHeader) {
	    if (substr($responseHeader, 0, 10) === "Location: ") {
	      $apiRequest = curl_init();
	      curl_setopt_array($apiRequest, array(
	        CURLOPT_URL => substr($responseHeader, 10),
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_SSL_VERIFYPEER => true
	      ));
	      file_put_contents($pngFile, curl_exec($apiRequest));
	    }
	  }

	} else {
	  echo (curl_error($apiRequest));
	  /* Something went wrong! */
	  echo ("Compression failed");
	}	
}

