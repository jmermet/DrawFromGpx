<?php
class Trackseg {
	
	private $trkpt = array();
	private $extensions;

	public function __construct() {}

public function setExtension($extension){
	$this->extension = $extension;
}

public function getExtensions() {
	return $this->extensions;
}

public function getTrackpt() {
	return $this->trkpt;
}

public function addTrackpt($strkpt) {
  array_push($this->trkpt, $strkpt);
}

public function setTrackpt($strkpt) {
	$this->trkpt=$strkpt;
}

public function createTrackpt($strkpt) {
	$this->addTrkpt($strkpt);
}

}


?>