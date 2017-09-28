<?php
function __autoload($class_name) {
    include $class_name . '.php';
}

function convertNameWP($name){
	$retour = preg_replace("#[ ,.;:'%&()\-\"]+#", "-", $name);
	$retour = mb_convert_encoding($retour, 'HTML-ENTITIES', 'UTF-8');
	$retour = preg_replace(array('/ß/', '/&(..)lig;/', '/&([aouAOU])uml;/', '/&(.)[^;]*;/'), array('ss', "$1", "$1".'e', "$1"), $retour);
	$retour = preg_replace("#[^a-zA-Z0-9]#", " ", $retour);
	$retour = trim($retour);
	return($retour);
}

if(isset($_REQUEST['map_select'])) {
	$mapa = $_REQUEST['map_select'];

	//$gpx = simplexml_load_file("uploads/sample.gpx");
	//$gpx = simplexml_load_file("uploads/FantasyIsland.gpx");
	$gpx = simplexml_load_file($mapa);
	//$gpx->saveXML();
	$gpxMain = new Gpx();

	foreach ($gpx->wpt as $wpt) {
		$attrs = $wpt->attributes();
		$wpt->name = convertNameWP($wpt->name);
		$wayp1 = new Waypoint((float)$attrs['lat'],(float)$attrs['lon'],(float)$wpt->ele,strtotime((string)$wpt->time),(float)$wpt->magvar,(float)$wpt->geoidheight,(string)$wpt->name,(string)$wpt->cmt,(string)$wpt->desc,(string)$wpt->src,(string)$wpt->link,(string)$wpt->sym,(string)$wpt->type,(string)$wpt->fix,(int)$wpt->sat,(float)$wpt->hdop,(float)$wpt->vdop,(float)$wpt->pdop,(float)$wpt->ageofgpsdata,(int)$wpt->eledpgsid,(string)$wpt->extension);
		$gpxMain->addWaypoint($wayp1);
	}

	foreach ($gpx->trk as $trk) {
		//trk represents a track - an ordered list of points describing a path.
		$trk1 = new Track((string)$trk->name,(string)$trk->cmt,(string)$trk->desc,(string)$trk->src,(string)$trk->link,(int)$trk->number,(string)$trk->type,(array)$trk->extensions,(float)$trk->elevation);
		foreach ($trk->trkseg as $trkseg) {
			//A Track Segment holds a list of Track Points which are logically connected in order. To represent a single GPS track where GPS reception was lost, or the GPS receiver was turned off, start a new Track Segment for each continuous span of track data.
			$trkseg1 = new Trackseg();
			$trkseg1->setExtensions = (array)$trkseg->extensions;
			$trk1->createTrackseg($trkseg1);
			foreach ($trkseg->trkpt as $wpt) {
				$attrs = $wpt->attributes();
				$wayp3 = new Waypoint((float)$attrs['lat'],(float)$attrs['lon'],(float)$wpt->ele,strtotime((string)$wpt->time),(float)$wpt->magvar,(float)$wpt->geoidheight,(string)$wpt->name,(string)$wpt->cmt,(string)$wpt->desc,(string)$wpt->src,(string)$wpt->link,(string)$wpt->sym,(string)$wpt->type,(string)$wpt->fix,(int)$wpt->sat,(float)$wpt->hdop,(float)$wpt->vdop,(float)$wpt->pdop,(float)$wpt->ageofgpsdata,(int)$wpt->eledpgsid,(string)$wpt->extension);
				$trkseg1->addTrackpt($wayp3);
			}
		}
		$gpxMain->addTrack($trk1);
	}

	foreach ($gpx->trkseg as $trkseg) {
		$trk1 = new Track((string)$trk->name,(string)$trk->cmt,(string)$trk->desc,(string)$trk->src,(string)$trk->link,(int)$trk->number,(string)$trk->type,(array)$trk->extensions,(float)$trk->elevation);
		//A Track Segment holds a list of Track Points which are logically connected in order. To represent a single GPS track where GPS reception was lost, or the GPS receiver was turned off, start a new Track Segment for each continuous span of track data.
		$trkseg1 = new Trackseg();
		$trkseg1->setExtensions = (array)$trkseg->extensions;
		$trk1->createTrackseg($trkseg1);
		foreach ($trkseg->trkpt as $wpt) {
			$attrs = $wpt->attributes();
			$wayp3 = new Waypoint((float)$attrs['lat'],(float)$attrs['lon'],(float)$wpt->ele,strtotime((string)$wpt->time),(float)$wpt->magvar,(float)$wpt->geoidheight,(string)$wpt->name,(string)$wpt->cmt,(string)$wpt->desc,(string)$wpt->src,(string)$wpt->link,(string)$wpt->sym,(string)$wpt->type,(string)$wpt->fix,(int)$wpt->sat,(float)$wpt->hdop,(float)$wpt->vdop,(float)$wpt->pdop,(float)$wpt->ageofgpsdata,(int)$wpt->eledpgsid,(string)$wpt->extension);
			$trkseg1->addTrackpt($wayp3);
		}
		$gpxMain->addTrack($trk1);
	}

	foreach ($gpx->rte as $rte) {
		$rte1 = new Route();
		$rte1->setName((string)$rte->name);
		foreach ($rte->rtept as $wpt) {
			$attrs = $wpt->attributes();
			$wayp2 = new Waypoint((float)$attrs['lat'],(float)$attrs['lon'],(float)$wpt->ele,strtotime((string)$wpt->time),(float)$wpt->magvar,(float)$wpt->geoidheight,(string)$wpt->name,(string)$wpt->cmt,(string)$wpt->desc,(string)$wpt->src,(string)$wpt->link,(string)$wpt->sym,(string)$wpt->type,(string)$wpt->fix,(int)$wpt->sat,(float)$wpt->hdop,(float)$wpt->vdop,(float)$wpt->pdop,(float)$wpt->ageofgpsdata,(int)$wpt->eledpgsid,(string)$wpt->extension);
			$rte1->addRoutept($wayp2);
		}

		$gpxMain->addRoute($rte1);
	}

	// on sauvegarde cette version du GPX avec les bons noms de wp
	$gpx->asXML($mapa);

	// echo "<pre>";
	// print_r($gpxMain);
	// echo "</pre>";

	/*
	echo "<hr>";
	$rutes[0]->setName("Jisus");
	echo $rutes[0]->getName();+"<br>";
	echo "<hr>";*/
	//Error
	//$rutes[0]->setName(12);

	//$traksegs1 = $rutes[0]->getTrackseg();
	//$trkpts1 = $traksegs1[0]->getTrackpt();
	//echo $trkpts1[3]->getName();


}
include 'map.php';

?>