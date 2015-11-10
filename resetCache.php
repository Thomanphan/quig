<?php
require_once( 'config.php' );
require_once( 'class.Cache.php' );
$cache = new Cache( $cacheFile, $cacheTime );
$cache->delete();
?>
