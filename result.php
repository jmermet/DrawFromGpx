<?php
function __autoload($class_name) {
    include $class_name . '.php';
}

public function loadGPX() {
if (file_exists('uploads/sample.gpx')) {
    $xml = simplexml_load_file('uploads/sample.gpx');
    foreach( $xml->children() AS $child ) {
        $name = $child->getName();
        //crea waypoints
        if ($name == 'wpt') {
            $wayp1 = new Waypoint();
            $wayp1->setLat($child['lat']);
            $wayp1->setLon($child['lon']);
            $wayp1->setName($child->children()->getName());
            //print_r('Tipo: '.$name.'    ');
            //echo 'Latitut:'.$wayp1->getLat().' Lon:'.$wayp1->getLon().'  ';
            $name = $child->children()->getName();
            if ($name = 'ele') {
                $wayp1->setElevation($child->children());
                echo 'childchild:'.$child->children().'<br/>';
            }
            if ($name = 'time') {
                $wayp1->setTime($child->children());
                echo 'childchild2:'.$child->children().'<br/>';
            }
        }
        //crea traks
        if ($name == 'trk') {
            $trk1 = new Track();
            foreach( $child->children() AS $grandchild ) {
                $grandname = $grandchild->getName();
                if ($grandname == 'name') {
                    $trk1->setName($grandchild);
                    echo 'Nombre track: '. $trk1->getName().' <br>';
                }
                if ($grandname == 'trkseg') {
                    foreach( $grandchild->children() AS $greatgrandchild ) {

                        $greatgrandname = $greatgrandchild->getName();
                        //print_r($greatgrandname.' <- Tipo ');
                        //echo '<br/>';
                        if ($greatgrandname == 'trkpt') {
                            $trkLat= $greatgrandchild['lat'];
                            $trkLon= $greatgrandchild['lon'];

                            //echo $greatgrandchild['lat'].' '.$greatgrandchild['lon'];
                            foreach( $greatgrandchild->children() AS $elegreatgrandchild ) {
                                $trkTime = $elegreatgrandchild;
                                //echo $elegreatgrandchild.'<-><br/>';
                            }
                        }
                        if ($greatgrandname == 'ele') {
                            $trkEle=$greatgrandchild;
                            //print_r($greatgrandchild);
                        } 
                        $trk1->createPoint($trkLat,$trkLon,$trkTime,$trkEle);  
                    }
                }
            }
        }
        //TO DO: crear rutas
        if ($name == 'rte') {
            $rte1 = new Route();
            foreach( $child->children() AS $grandchild ) {
                $grandname = $grandchild->getName();
                if ($grandname == 'name') {
                    $trk1->setName($grandchild);
                    echo 'Nombre track: '. $trk1->getName().' <br>';
                }
                if ($grandname == 'trkseg') {
                    foreach( $grandchild->children() AS $greatgrandchild ) {

                        $greatgrandname = $greatgrandchild->getName();
                        //print_r($greatgrandname.' <- Tipo ');
                        //echo '<br/>';
                        if ($greatgrandname == 'trkpt') {
                            $trkLat= $greatgrandchild['lat'];
                            $trkLon= $greatgrandchild['lon'];

                            //echo $greatgrandchild['lat'].' '.$greatgrandchild['lon'];
                            foreach( $greatgrandchild->children() AS $elegreatgrandchild ) {
                                $trkTime = $elegreatgrandchild;
                                //echo $elegreatgrandchild.'<-><br/>';
                            }
                        }
                        if ($greatgrandname == 'ele') {
                            $trkEle=$greatgrandchild;
                            //print_r($greatgrandchild);
                        } 
                        $trk1->createPoint($trkLat,$trkLon,$trkTime,$trkEle);  
                    }
                }
            }
        }
        echo "<br>";
    }

} else {
    exit('Failed to open gpx.');
}
} 
?>
