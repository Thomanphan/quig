<?php
require_once('config.php');
require_once('class.Cache.php');
require_once('class.Phrase.php');
require_once('class.PhrasePNGBuilder.php');
require_once('loadPhrases.php');

// Use the cached phrase if possible
$cache = new Cache( $cacheFile, $cacheTime );
$result = $cache->fetch();
if( $result === FALSE ) {
	$phrase = getPhrase();
	$cache->store( $phrase );
} else {
	$phrase = $result;
}

$imageFile = $cacheFolder.'/'. $phrase->md5( ) .'.png';

// Dont create the image if it already exists.
if ( !file_exists( $imageFile ) ) {
	$pngBuilder = new PhrasePNGBuilder( $textFont, $authorFont, $textSize, $authorSize );
	$pngBuilder->phrase( $phrase, $charactersPerLine );
	$image = $pngBuilder->build( );
	// Save the image
	imagepng( $image, $imageFile );
	// Unload resources.
	imagedestroy( $image );
}

// Do not output image if calling from console.
if( php_sapi_name( ) !== 'cli' ) {
	// Headers HTTP
	header( 'Content-type: image/png' );
	header( 'Cache-Control: max-age='. $cacheTime .', must-revalidate' );
	header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time( ) + $cacheTime ) . ' GMT' );
	// Display the image
	readfile( $imageFile );
} else {
	echo $phrase;
}
?>
