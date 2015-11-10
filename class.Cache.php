<?php
class Cache {
	private $file;
	private $time;
	private $apc;
	private $data;

	function __construct( $cacheFile, $cacheTime ) {
		$this->file = $cacheFile;
		$this->cacheTime = $cacheTime;
		$this->apc = extension_loaded( 'apc' );
	}

	function fetch( ){
		if( $this->apc ) {
			$result = apc_fetch( $this->file );
			if ( $result === FALSE ) {
				return $result; // Cache miss (no content or outdated content)
			} else {
				$this->data = $result;
				return $result; // Cache Hit
			}
		} else if( !file_exists( $this->file ) ) {
			return FALSE; // Cache miss (no content)
		} else {
			$this->data = unserialize( file_get_contents( $this->file ) );
			if ( $this->data['timestamp'] + $this->cacheTime < time( ) ) {
				return FALSE; // Cache miss (outdated content)
			} else {
				return $this->data['content']; // Cache Hit
			}
		}
	}

	function store( $content ){
		if( $this->apc ) {
			apc_store( $this->file, $content, $this->cacheTime );
		} else {
			$content = array(
				'timestamp'   => time() ,
				'content' => $content
			);
			file_put_contents( $this->file, serialize( $content ) );
		}
	}

	function delete(){
		if( $this->apc ) {
			apc_delete( $this->file );
		} else {
			file_exists( $this->file ) and unlink( $this->file );
		}
	}
}
?>
