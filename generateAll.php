<?php
require_once('config.php');
require_once('class.Cache.php');
require_once('class.Phrase.php');
require_once('class.PhrasePNGBuilder.php');
require_once('loadPhrases.php');

$counter = 0;
$pngBuilder = new PhrasePNGBuilder( $textFont, $authorFont, $textSize, $authorSize );

// Generate images for all phrases that have not been generated before
foreach( getPhrases( ) AS $phrase ) {
	$text = wordwrap( $phrase->phrase( ), $charactersPerLine );
	$author = $phrase->author( );

	$hash = $phrase->md5( );
	$imageFile = $cacheFolder.'/'.$hash.'.png';
	if( !file_exists($imageFile) ) {
		$pngBuilder->phrase( $phrase, $charactersPerLine );
		$image = $pngBuilder->build();
		// Save the image
		imagepng( $image, $imageFile );
		// Unload resources.
		imagedestroy( $image );
		$counter++;
	}
}

// Update image cache if empty
$cache = new Cache( $cacheFile, $cacheTime );
$phrase = $cache->fetch();
if( $phrase === FALSE ) {
	$phrase = getPhrase();
	$cache->store( $phrase );
}

echo "Generated {$counter} phrases as png files, current is: {$phrase}";
?>

