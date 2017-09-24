<?php

class Waypoint {
	private $lat;
	private $lon;
	private $elevation;
	private $time;
	private $magvar;
	private $geoidheight;
	private $name;
	private $cmt;
	private $desc;
	private $src;
	private $link;
	private $sym;
	private $type;
	private $fix;
	private $sat;
	private $hdop;
	private $vdop;
	private $pdop;
	private $ageofdgpsdata;
	private $dgpsid;
	private $extension;

public function __construct($slat = null,$slon = null,$selevation = null,$stime,$smagvar = null,$sgeoidheight = null,$sname = null,$scmt = null,$sdesc = null,$ssrc = null,$slink = null,$ssym = null,$stype = null,$sfix = null,$ssat = null,$shdop = null,$svdop = null,$spdop = null,$sageofgpsdata = null,$sdgpsid = null,$sextension = null) {

$this->setLat($slat);
$this->setLon($slon);
$this->setElevation($selevation);
$this->setTime($stime);
$this->setMagvar($smagvar);
$this->setGeoidheight($sgeoidheight);
$this->setName($sname);
$this->setCmt($scmt);
$this->setDesc($sdesc);
$this->setLink($slink);
$this->setSrc($ssrc);
$this->setType($stype);
$this->setFix($sfix);
$this->setSat($ssat);
$this->setHdop($shdop);
$this->setPdop($pdop);
$this->setVdop($svdop);
$this->setAgeofdgpsdata($sageofdgpsdata);
$this->setDgpsid($sdgpsid);
$this->setExtension($sextension);
}

public function getLat(){
	return $this->lat;
}

public function setLat($lat){
if (!is_float($lat)) {
	throw new Exception('Not a decimal.');
} elseif(-90.0 >= $lat || $lat >= 90.0) {
		throw new Exception('Not a decimal.');
} else {
	$this->lat = $lat;
}
}

public function getLon(){
	return $this->lon;
}

public function setLon($lon){
if (!is_float($lon)) {
	throw new Exception('Not a decimal.');
} elseif(-180.0 >= $lon || $lon >= 180.0) {
		throw new Exception('Not a decimal.');
} else {
	$this->lon = $lon;
}

}

public function getElevation(){
	return $this->elevation;
}

public function setElevation($elevation){
	if (!is_float($elevation)) {
		throw new Exception('Not a decimal.');
	} else {
		$this->elevation = $elevation;
	}
}


public function getTime(){
	return $this->time;
}

public function setTime($time){
	$this->time = $time;
}

public function getMagvar(){

	return $this->magvar;
}

public function setMagvar($magvar){
	if (!is_float($magvar)) {
		throw new Exception('Not a decimal.');
	} elseif($magvar != null) {
		if(0.0 >= $magvar || $magvar > 360.0) {
			throw new Exception('Wrong degree. 0.0 <= value < 360.0');
		} 
	}else {
		$this->magvar = $magvar;
	}

}

public function getGeoidheight(){
	return $this->geoidheight;
}

public function setGeoidheight($geoidheight){
	if (!is_float($geoidheight)) {
		throw new Exception('Not a decimal.');
	} else {
		$this->geoidheight = $geoidheight;
	}

}

public function getName(){
	return $this->name;
}

public function setName($sname) {
        if (!is_string($sname))
        {
            throw new Exception('Not a string.');
        } else {
       		$this->name = $sname; 	
        }
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

public function getSym(){
	return $this->sym;
}

public function setSym($sym){
	if (!is_string($sym))
    {
    	throw new Exception('Not a string.');
    } else {
    	$this->sym = $sym;	
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

public function getFix(){
	return $this->fix;
}

public function setFix($fix){
	if ($fix != null) {
		if (!is_string($fix))
	    {
	    	throw new Exception('Not a string.');
	    } elseif ($fix !=  'none'|| $fix != '2d'|| $fix != '3d'|| $fix != 'dgps'|| $fix != 'pps') {
	    	throw new Exception('Not valid fix.');
	    } else {
			$this->fix = $fix;
	    }
	}
}

public function getSat(){
	return $this->sat;
}

public function setSat($sat){
    if (!is_int($sat)) {
    	throw new Exception('Not a number.');
    }elseif($sat<0) {
		throw new Exception('Number must be positive.');
	} else {
			$this->sat = $sat;
	}
}

public function getHdop(){

	return $this->hdop;
}

public function setHdop($hdop){
	if (!is_float($hdop)) {
		throw new Exception('Not a decimal.');
	} else {
	$this->hdop = $hdop;
	}
}

public function getVdop(){
	return $this->vdop;
}

public function setVdop($vdop){
	if (!is_float($vdop)) {
		throw new Exception('Not a decimal.');
	} else {
		$this->vdop = $vdop;
	}

}

public function getPdop(){
	return $this->pdop;
}

public function setPdop($pdop){
	if ($pdop != null) {
		if (!is_float($pdop)) {
		throw new Exception('Not a decimal.');
		} else {
			$this->pdop = $pdop;
		}	
	}

}

public function getAgeofdgpsdata(){
	return $this->ageofdgpsdata;
}

public function setAgeofdgpsdata($ageofdgpsdata){
	if ($ageofdgpsdata != null) {
		if (!is_float($ageofdgpsdata)) {
			throw new Exception('Not a decimal.');
		} else {
		$this->ageofdgpsdata = $ageofdgpsdata;
		}
	}

}

public function getDgpsid(){
	return $this->dgpsid;
}

public function setDgpsid($dgpsid){
	if ($dgpsid != null) {
		if (!is_int($dgpsid)) {
			throw new Exception('Not a decimal.');
		} elseif(0 >= $dgpsid || $dgpsid >= 1023) {
			throw new Exception('Not valid. (0 <= value <= 1023)');
		}else {
		$this->dgpsid = $dgpsid;
		}
 	}
}

public function getExtension(){
	return $this->extension;
}

public function setExtension($extension){
	$this->extension = $extension;
}


}

?>