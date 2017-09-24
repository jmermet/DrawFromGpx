<?php

class GPX {
	private $metadata;
	private $wpt = Array();
	private $rte = Array();
	private $trk = Array();
	private $extensions;

public function __construct() {

}

public function getTrack() {
	return $this->trk;
}

public function addTrack($strk) {
  array_push($this->trk, $strk);
}

public function setTrackpt($strk) {
	$this->trk=$strk;
}

public function createTrackpt($strk) {
	$this->addTrack($strk);
}


public function getRoute() {
	if(count($this->rte) == 0) {
		return null;
	} else {
		return $this->rte;

	}

}

public function addRoute($srte) {
  array_push($this->rte, $srte);
}

public function setRoute($srte) {
	$this->rte=$srte;
}

public function createRoute($srte) {
	$this->addRoute($srte);
}


public function getWaypoint() {
	return $this->wpt;
}

public function addWaypoint($swpt) {
  array_push($this->wpt, $swpt);
}

public function setWaypoint($swpt) {
	$this->wpt=$swpt;
}

public function createWaypoint($swpt) {
	$this->addWaypoint($swpt);
}


}

?>