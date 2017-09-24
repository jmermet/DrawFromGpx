
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
      $listeWP= $gpxMain->getWaypoint();

      foreach ($listeWP as $objetWP) {
        $lat = (string)$objetWP->getLat();
        $lon = (string)$objetWP->getLon();
        if (strlen($ListerealWP) == 0) {
            $ListerealWP = $lon.','.$lat;
        } else {
            $ListerealWP = $ListerealWP.','.$lon.','.$lat;
        }

      }
      //var_dump($ListerealWP);




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
    <link rel="stylesheet" href="https://openlayers.org/en/v4.3.3/css/ol.css" type="text/css">
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v4.3.3/build/ol.js"></script>
    <script src="lib/jquery-2.1.3.js"></script>

  </head>
  <body>

    <h2>My Map</h2>
    <div id="ol-map-big" class="ol-map-big" style="height:600px; width:600px;"></div>
    <div>
      <form class="form-inline">
        <label>Forme géométrique</label>
        <select id="type">
          <option value="LineString">Ligne  à main levée</option>
          <option value="Polygon">Polygone  à main levée</option>
          <option value="Circle">Cercle  à main levée</option>
          <option value="arrow">Flèche multipoints au clic</option>
          <option value="None">Rien</option>
        </select>
    </form>

    <script type="text/javascript">

          var realWP = '<?=$ListerealWP;?>';
          var points = "<?=$points;?>";
                    //console.log(points);
          points = points.split(',');
          realWP = realWP.split(',');
          var j = 0;
          var iconFeature = [];
          var wpFeature = [];
          var linesFeature = [];
          var linea = [];
          var points2 = new Array();
          var realWP2 = new Array();
          var point_aux = new Array();
          var wp_aux = new Array();







          //crea puntos
          for (i=0; i < points.length; i=i+2) {
            points2[j] = new ol.geom.Point(ol.proj.transform([parseFloat(points[i]), parseFloat(points[i+1])], 'EPSG:4326', 'EPSG:3857'));
            point_aux[j] =  new ol.geom.Point([parseFloat(points[i]), parseFloat(points[i+1])]);
            iconFeature[j] = new ol.Feature({
                geometry: points2[j],
                name: 'Null Point',
                population: 4000,
                rainfall: 500
            });

            //DA ESTILO A LOS PUNTOS
            var iconStyle = new ol.style.Style({
                image: new ol.style.Circle({
                  radius: 2,
                  fill: new ol.style.Fill({color: '#ff6600', opacity: 0.5}),
                  stroke: new ol.style.Stroke({color: '#ffffff', width: 1, opacity: 0.5})
                })
            });

            //AÑADE EL ESTILO A LOS PUNTOS
            iconFeature[j].setStyle(iconStyle);
            //iconFeature.push(iconFeature1);

            j++;
          }



          //LINEAS
          j=0;
          var style = {
            strokeColor: '#EF2831',
            strokeOpacity: 1,
            strokeWidth: 8
          };
          var linesFeature = Array();

          for (i=0; i < points2.length; i=i+1) {

            //console.log(points2[j].getCoordinates());
            a = points2[i].getCoordinates();

            if((i+1)<points2.length) {
                b = points2[i+1].getCoordinates();
            }

            linesFeature[j] = new ol.geom.LineString([a, b]);

            linesFeature[j] = new ol.Feature(linesFeature[j], null, style);


              j++;

          }


          //creation real WP
          var z = 0;
          for (x=0; x < realWP.length; x=x+2) {
            wpFeature[z]  = new ol.Feature({
              geometry: new ol.geom.Point(ol.proj.transform([parseFloat(realWP[x]), parseFloat(realWP[x+1])], 'EPSG:4326', 'EPSG:3857')),
              name: 'Null Island',
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

            // wpFeature[x] = new ol.Feature({
            //     geometry: new ol.geom.Point(ol.proj.transform([parseFloat(5.8), parseFloat(4502)], 'EPSG:4326', 'EPSG:3857')),
            //     name: 'WP'
            // });



          var vectorLinesSource = new ol.source.Vector({
              //create empty vector
          });


            //console.log(linesFeature);

            //var fea=new ol.Feature.Vector(linesFeature[0], {}, styleLine);



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
                color: 'rgba(255, 255, 255, 0.2)'
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

          var sourceDessin = new ol.source.Vector({wrapX: false});

          var vectorDessin = new ol.layer.Vector({
            source: sourceDessin
          });

          var styleFunction = function(feature) {
            var geometry = feature.getGeometry();
            var styles = [
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
              styles.push(new ol.style.Style({
                geometry: new ol.geom.Point(end),
                image: new ol.style.Icon({
                  src: 'img/fleche-rouge.png',
                  anchor: [0.75, 0.5],
                  rotateWithView: true,
                  rotation: -rotation
                })
              }));
            });

            return styles;
          };

          var sourceArrow = new ol.source.Vector();
          var vectorArrow = new ol.layer.Vector({
            source: sourceArrow,
            style: styleFunction
          });





          // Contact map
          var map = new ol.Map({
              target: 'ol-map-big',
              layers: [
                new ol.layer.Tile({
                  source: new ol.source.OSM()
                }),  vectorLineLayer, vectorLayer, vectorLayerWP, vectorDessin, vectorArrow
              ],
              view: new ol.View({
                center: ol.proj.transform([parseFloat(points[0]), parseFloat(points[1])], 'EPSG:4326', 'EPSG:3857'),
                //center: a,
                zoom: 14
              })
          });




          var typeSelect = document.getElementById('type');

          var draw; // global so we can remove it later
          function addInteraction() {
            var value = typeSelect.value;
            if (value !== 'None' && value !== 'arrow') {
              draw = new ol.interaction.Draw({
                source: sourceDessin,
                type: /** @type {ol.geom.GeometryType} */ (typeSelect.value),
                freehand: true
              });

            }
            if (value == 'arrow'){
                draw = new ol.interaction.Draw({
                  source: sourceArrow,
                 type: /** @type {ol.geom.GeometryType} */ ('LineString')
                });
            }
            if (value == 'None'){
                map.removeInteraction(draw);
            }  else {
              map.addInteraction(draw);
            }

          }


          /**
           * Handle change event.
           */
          typeSelect.onchange = function() {
            map.removeInteraction(draw);
            addInteraction();
          };

          addInteraction();


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
      print_r($mapas);
      for($i = 0; $i < count($mapas); $i++) {
        echo "<option value='uploads/".$mapas[$i]."'>".$mapas[$i]."</option>";
        } ?>
    </select>
    <button type="submit">Cambiar</button>

    </form>


    </div>
  </body>

</html>