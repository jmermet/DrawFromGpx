<?php
if(isset($_REQUEST['map_select'])) {

    $rutes1 = $gpxMain->getRoute();
      if($rutes1 <> null) {
         $rutes1 = $rutes1[0]->getRoutept();
      } else {
        $rutes1 = $gpxMain->getTrack();
        $rutes1 = $rutes1[0]->getTrackseg();
        $rutes1 = $rutes1[0]->getTrackpt();
      }

      $ListerealWP = '';
      $ListeNameWP = '';
      $tabNameWP = array();
      $listeWP= $gpxMain->getWaypoint();

      foreach ($listeWP as $objetWP) {
        $lat = (string)$objetWP->getLat();
        $lon = (string)$objetWP->getLon();
        $name = (string)$objetWP->getName();
        //$name = convertNameWP($name);
        $tabNameWP[] = $name;
        if (strlen($ListerealWP) == 0) {
            $ListerealWP = $lon.','.$lat;
            $ListeNameWP = $name;
        } else {
            $ListerealWP = $ListerealWP.','.$lon.','.$lat;
            $ListeNameWP = $ListeNameWP. ',' .$name;
        }

      }
      //var_dump($tabNameWP);

    $points = '';
    foreach ($rutes1 as $wp) {
        $lat = (string)$wp->getLat();
        $lon = (string)$wp->getLon();
        if (strlen($points) == 0) {
            $points = $lon.','.$lat;
        } else {
            $points = $points.','.$lon.','.$lat;
        }
    }
  }
?>
<html lang="en">
  <head>
    <link rel="stylesheet" href="https://openlayers.org/en/v4.3.4/css/ol.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css">
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v4.3.3/build/ol.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
    <script src="lib/jquery-2.1.3.js"></script>

  </head>
  <body>

    <h2>My Map</h2>
    <div id="ol-map-big" class="ol-map-big" style="height:600px; width:600px;"></div>

    <div id="info" class="has-warning">pas de sélection</div>
    <div>

      <form class="form-inline">
        <label>Dessin: Forme géométrique</label>
        <select id="type">
          <option value="None">Pas d'outil sélectionné: zoomer, sélectionner un WP ou déplacer la carte</option>
          <option value="arrow">Flèche multipoints au clic</option>
          <option value="LineString">Ligne  à main levée</option>
          <option value="Polygon">Polygone  à main levée</option>
          <option value="Circle">Cercle  à main levée</option>

        </select>
      </form>

      <button id="rotate-left" title="Rotate clockwise">↻</button>
      <button id="rotate-right" title="Rotate counterclockwise">↺</button>

      <a id="export-png" class="btn btn-default"><i class="fa fa-download"></i> télécharger au format PNG</a>

    <script type="text/javascript">

          var realWP = '<?=$ListerealWP;?>';
          var nameWP = '<?=$ListeNameWP;?>';
          var points = "<?=$points;?>";
          points = points.split(',');
          realWP = realWP.split(',');
          nameWP = nameWP.split(',');
          var j = 0;
          var iconFeature = [];
          var wpFeature = [];
          var linesFeature = [];
          var linea = [];
          var points2 = new Array();
          var realWP2 = new Array();
          var point_aux = new Array();
          var wp_aux = new Array();


          //creation des  points
          for (i=0; i < points.length; i=i+2) {
            points2[j] = new ol.geom.Point(ol.proj.transform([parseFloat(points[i]), parseFloat(points[i+1])], 'EPSG:4326', 'EPSG:3857'));
            point_aux[j] =  new ol.geom.Point([parseFloat(points[i]), parseFloat(points[i+1])]);
            iconFeature[j] = new ol.Feature({
                geometry: points2[j],
                name: 'Null Point',
                population: 4,
                rainfall: 5
            });

            //style des points
            var iconStyle = new ol.style.Style({
                image: new ol.style.Circle({
                  radius: 2,
                  fill: new ol.style.Fill({color: '#ff6600', opacity: 0.5}),  // ff6600 orange
                  stroke: new ol.style.Stroke({color: '#ffffff', width: 1, opacity: 0.5})
                })
            });

            iconFeature[j].setStyle(iconStyle);

            j++;
          }

          var styleSegmentBleu = new ol.style.Style({
            stroke: new ol.style.Stroke({
              color: '#0038ff',   // 2fff00 vert #0038ff bleu
              width: 2
            })
          });
          var styleSegmentRouge = new ol.style.Style({
            stroke: new ol.style.Stroke({
              color: '#ff0000',   // 2fff00 vert #0038ff bleu
              width: 3
            })
          });



          //creation des lignes
            j=0;
            var styleLigne = {
              strokeColor: '#EF2831', //rouge
              strokeOpacity: 1,
              strokeWidth: 8
            };
            var linesFeature = Array();

            for (i=0; i < points2.length; i=i+1) {

              a = points2[i].getCoordinates();

              if((i+1)<points2.length) {
                  b = points2[i+1].getCoordinates();
                  linesFeature[j] = new ol.geom.LineString([a, b]);
              }

              linesFeature[j] = new ol.Feature(linesFeature[j], null, styleSegmentBleu);
              linesFeature[j].setStyle(styleSegmentBleu);

              j++;

            }


          //creation real WP
          var z = 0;
          for (x=0; x < realWP.length; x=x+2) {
            wpFeature[z]  = new ol.Feature({
              geometry: new ol.geom.Point(ol.proj.transform([parseFloat(realWP[x]), parseFloat(realWP[x+1])], 'EPSG:4326', 'EPSG:3857')),
              name: nameWP[z],
              population: 4000,
              rainfall: 500
            });

            var iconStyle = new ol.style.Style({
                image: new ol.style.Circle({
                  radius: 5,
                  fill: new ol.style.Fill({color: '#ff0000', opacity: 0.5}),
                  stroke: new ol.style.Stroke({color: '#ffffff', width: 1, opacity: 0.5})
                })
            });
            wpFeature[z].setStyle(iconStyle);

            z++;
          }





          var vectorLinesSource = new ol.source.Vector({
              //create empty vector
          });

          var vectorLinesSource = new ol.source.Vector({
            features: linesFeature
          });

          var vectorLineLayer = new ol.layer.Vector({
            source: vectorLinesSource
          });
          var vectorSource = new ol.source.Vector({
            features: iconFeature
          });

          var vectorLayer = new ol.layer.Vector({
            source: vectorSource
          });


          var vectorSourceWP = new ol.source.Vector({
            features: wpFeature
          });

          var vectorLayerWP = new ol.layer.Vector({
            source: vectorSourceWP,
            style: new ol.style.Style({
              fill: new ol.style.Fill({
                color: 'rgba(255, 255, 255, 2.2)'
              }),
              stroke: new ol.style.Stroke({
                color: '#ffcc33',
                width: 2
              }),
              image: new ol.style.Circle({
                radius: 7,
                fill: new ol.style.Fill({
                  color: '#ffcc33'
                })
              })
            })
          });

          //dessin à main levée
          var sourceDessin = new ol.source.Vector({wrapX: false});

          var vectorDessin = new ol.layer.Vector({
            source: sourceDessin,
            style: new ol.style.Style({
              fill: new ol.style.Fill({
                color: 'rgba(255, 255, 255, 0.2)'
              }),
              stroke: new ol.style.Stroke({
                color: '#ff0000',
                width: 4
              }),
              image: new ol.style.Circle({
                radius: 7,
                fill: new ol.style.Fill({
                  color: '#ffcc33'
                })
              })
            })
          });

          // style pour les dessins des fleches
          var styleFunction = function(feature) {
            var geometry = feature.getGeometry();
            var stylesFleche = [
              // linestring
              new ol.style.Style({
                stroke: new ol.style.Stroke({
                  color: '#ff0000',
                  width: 5
                })
              })
            ];

            geometry.forEachSegment(function(start, end) {
              var dx = end[0] - start[0];
              var dy = end[1] - start[1];
              var rotation = Math.atan2(dy, dx);
              // arrows
              stylesFleche.push(new ol.style.Style({
                geometry: new ol.geom.Point(end),
                image: new ol.style.Icon({
                  src: 'img/fleche-rouge.png',
                  anchor: [0.75, 0.5],
                  rotateWithView: true,
                  rotation: -rotation
                })
              }));

            });
            map.removeInteraction(select); // on desactive la selection au clic pour eviter la selection de la fleche lors de la fin du dessin de la fleche
            return stylesFleche;
          };

          // le vector fleches
          var sourceArrow = new ol.source.Vector();
          var vectorArrow = new ol.layer.Vector({
            source: sourceArrow,
            style: styleFunction
          });

          //la vue est centrée sur le 1er WP
          var center = ol.proj.transform([parseFloat(points[0]), parseFloat(points[1])], 'EPSG:4326', 'EPSG:3857');
          var view = new ol.View({
                  center: center,
                  zoom: 17
                });


          // Contact map
          var map = new ol.Map({
              target: 'ol-map-big',
              layers: [
                new ol.layer.Tile({
                  source: new ol.source.OSM({
                    url: 'https://api.mapbox.com/styles/v1/cyclope001/cj821rt6981me2st3j92w8imq/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiY3ljbG9wZTAwMSIsImEiOiJjajgyMXFlcTcwM2ZnMnhzNHltcWFsZ2s3In0.W8N3B5aqWmBOSyD6o13z0A'
                  })
                }),  vectorLineLayer, vectorLayer, vectorLayerWP, vectorDessin, vectorArrow
              ],
              view: view
          });

          // a normal select interaction to handle click
          var select = new ol.interaction.Select();
          map.addInteraction(select);


           var selectedFeatures = select.getFeatures();


          var infoBox = document.getElementById('info');

          selectionWP = '';
          selectedFeatures.on(['add', 'remove'], function() {
            var names = selectedFeatures.getArray().map(function(feature) {
              selectionWP = feature.get('name');
              return feature.get('name');
            });
            if (names.length > 0) {
              infoBox.innerHTML = names.join(', ');
              for(i=0;i<3;i++) {
                $(infoBox).fadeTo('slow', 0.5).fadeTo('slow', 1.0).css('color','#FF0000');;
              }
            } else {
              infoBox.innerHTML = 'Pas de sélection';
            }
          });

          function onClick(id, callback) {
            document.getElementById(id).addEventListener('click', callback);
          }

          onClick('rotate-left', function() {
            view.animate({
              rotation: view.getRotation() + Math.PI / 8
            });
          });

          onClick('rotate-right', function() {
            view.animate({
              rotation: view.getRotation() - Math.PI / 8
            });
          });

          var typeSelect = document.getElementById('type');



          var draw; // global so we can remove it later
          function selectInteraction() {
            var value = typeSelect.value;
            if (value !== 'None' && value !== 'arrow') {
              draw = new ol.interaction.Draw({
                source: sourceDessin,
                type: /** @type {ol.geom.GeometryType} */ (typeSelect.value),
                style: styleSegmentRouge,
                freehand: true
              });

            }
            if (value == 'arrow'){
                draw = new ol.interaction.Draw({
                  source: sourceArrow,
                 type: /** @type {ol.geom.GeometryType} */ ('LineString'),
                });
            }
            if (value == 'None'){
                map.removeInteraction(draw);
                map.addInteraction(select); // on active la selection au clic sur la carte
            }  else {
              map.addInteraction(draw);
            }

          }


          /**
           * Handle change event.
           */
          typeSelect.onchange = function() {
            map.removeInteraction(draw);
            selectInteraction();
          };

          selectInteraction();

          // on clic pour export en donnant comme nom le WP selectionné
          document.getElementById('export-png').addEventListener('click', function() {
            map.once('postcompose', function(event) {
              var canvas = event.context.canvas;
              if (selectionWP == '') { selectionWP = 'map' };
              if (navigator.msSaveBlob) {
                navigator.msSaveBlob(canvas.msToBlob(), selectionWP +'.png');
              } else {
                canvas.toBlob(function(blob) {
                  saveAs(blob, selectionWP +'.png');
                });
              }
            });
            map.renderSync();
          });


     </script>


 <?php
$mapas = scandir("uploads");
array_shift($mapas);
array_shift($mapas);
array_shift($mapas);

?>

    <form action="tests.php">
    <select name="map_select">
      <?php
      //print_r($mapas);

      for($i = 0; $i < count($mapas); $i++) {
        $select = '';
        if ($_REQUEST['map_select'] == "uploads/".$mapas[$i]) $select='selected=selected';
        echo "<option ".$select." value='uploads/".$mapas[$i]."'>".$mapas[$i]."</option>";
        } ?>
    </select>
    <button type="submit">Charger le GPX sur la carte</button>

    </form>


    </div>
  </body>

</html>