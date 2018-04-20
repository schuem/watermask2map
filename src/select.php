<?php
require_once 'dbconnect.php';
if (isset($_GET['id'])) {
  // $sql = "SELECT ST_AsGeoJSON(geom) AS geom, id_cogerh, ingestion_time, area, s.name FROM masks m " 
  //         . "INNER JOIN source s on m.source_id = s.source_id WHERE id_cogerh = '".$_GET['id']."' "
  //         . "ORDER BY ingestion_time DESC";
  // $sql = "SELECT row_to_json(f) AS feature FROM "
  //         . "(SELECT 'Feature' AS type, ST_AsGeoJSON(geom)::json As geometry, "
  //         . "row_to_json (SELECT id_cogerh, ingestion_time, area, s.name FROM masks m "
  //         . "INNER JOIN source s on m.source_id = s.source_id WHERE id_cogerh = '".$_GET['id']."' "
  //         . "ORDER BY ingestion_time DESC) AS f";
  $sql = "SELECT json_build_object(
            'type',       'Feature',
            'id',         id,
            'geometry',   ST_AsGeoJSON(geom)::json,
            'properties', json_build_object(
                'feat_type',      ST_GeometryType(geom),
                'id_cogerh',      id_cogerh,
                'ingestion_time', ingestion_time,
                'area',           area,
                'source',         s.name
             )
          ) AS features FROM masks m "
          . "INNER JOIN source s on m.source_id = s.source_id WHERE id_cogerh = '".$_GET['id']."' "
          . "ORDER BY ingestion_time DESC";
  $res = pg_query($sql);
  $arr_data = pg_fetch_all($res);
  //print_r($arr_data);
  // works with first $sql query to decode already encoded json,
  // otherwise it will be encoded twice
  $processed = array();
  // foreach ($arr_data as &$d) {
  //   $d['features'] = json_decode($d['features'], TRUE);
  //   //print_r($d);
  // //   //echo $d['features'];
  // }
  
  foreach ($arr_data as $key => $value) {
    //print_r(json_decode($d['features'], TRUE));
    //echo empty($value['features']) ? 'leeres Features' : 'FEATURE!';
    //echo nl2br("\n\n");
    //$processed = $processed + json_decode($d['features'], TRUE);
    $processed[$key] = json_decode($value['features'], TRUE);
    //echo "is array:" . is_array(json_decode($d, TRUE));
    //print_r($d);
    //echo $d['features'];
  }

  //print_r($processed);
  //echo count($processed);
  $json = json_encode($processed);
  // write json file to disc and echo
  //file_put_contents('reservoirsById.json', $json);
  echo $json;

  //echo "json_encode($arr_data, JSON_PRETTY_PRINT)";

  // echo "<table class='table table-bordered table-condensed'>";
  //   echo "<caption> Data for Cogerh ID ".$arr_data[0]['id_cogerh']."</caption>";
  //   // header
  //   echo "<thead><tr>";
  //     echo "<th>Ingestion Time</th>";
  //     echo "<th>Area</th>";
  //     echo "<th>Source</th>";
  //   echo "</thead></tr>";
  //   // content
  //   echo "<tbody>";
  //     foreach ($arr_data as $v) {
  //       echo "<tr>";
  //         echo "<td>" .$v['ingestion_time']. "</td>";
  //         echo "<td>" .$v['area']. "</td>";
  //         echo "<td>" .$v['name']. "</td>";
  //       echo "</tr>";
  //     }
  //   echo "</tbody>";
  // echo "</table>";


  //print_r(pg_fetch_all($res));



}
?>
