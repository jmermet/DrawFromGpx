<?php

class Track {

	private $name;
	private $cmt;
	private $desc;
	private $src;
	private $link;
	private $number;
	private $type;
	private $extensions;
	private $trackseg = array();



public function __construct($sname = null, $scmt = null,$sdesc = null,$ssrc = null,$slink = null,$snumber = null,$stype = null,$sextensions = null,$selevation = null) {

$this->setName($sname);
$this->setCmt($scmt);
$this->setDesc($sdesc);
$this->setSrc($ssrc);
$this->setLink($slink);
$this->setNumber($srnumber);
$this->setType($stype);
$this->setExtensions($sextensions);

}


public function setName($sname) {
    if (!is_string($sname))
    {
        throw new Exception('Not a string.');
    } else {
   		$this->name = $sname; 	
    }
}

public function getName() {
	return $this->name;
}

public function getTrackseg() {
	return $this->trackseg;
}

public function addTrackseg($spoint) {
  array_push($this->trackseg, $spoint);
}

public function setTrackseg($spoints) {
	$this->points=$spoints;
}

public function createTrackseg($spoint) {
	$this->addTrackseg($spoint);
}



public function getCmt(){
	return $this->cmt;
}

public function setCmt($cmt){
    if (!is_string($cmt))
    {
        throw new Exception('Not a string.');
    } else {
		$this->cmt = $cmt;	
    }
}

public function getDesc(){
	return $this->desc;
}

public function setDesc($desc){
    if (!is_string($desc))
    {
        throw new Exception('Not a string.');
    } else {
	$this->desc = $desc;
    }
}

public function getSrc(){
	return $this->src;
}

public function setSrc($src){
    if (!is_string($src))
    {
        throw new Exception('Not a string.');
    } else {
		$this->src = $src;
    }
}

public function getLink(){
	return $this->link;
}

public function setLink($link){
	if($link != null)  {
		if (!is_string($link)) {
    		throw new Exception('Not a string.');
	    } else {
	    	$this->link = $link;	
	    }
	}
}


public function getNumber(){
	return $this->number;
}

public function setNumber($number){
	if($numbr != null) {
	    if (!is_int($number)) {
	    	throw new Exception('Not a number.');
	    }elseif($number<0) {
			throw new Exception('Number must be positive.');
		} else {
			$this->number = $number;
		}
	}
}

public function getType(){
	return $this->type;
}
public function setType($type){
	 if (!is_string($type))
    {
    	throw new Exception('Not a string.');
    } else {
		$this->type = $type;
    }

}

public function getExtensions(){
	return $this->extensions;
}

public function setExtensions($extensions){
	$this->extensions = $extensions;
}

}
?>