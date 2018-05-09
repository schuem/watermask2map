<?php
require_once 'dbconnect.php';
if (isset($_GET['id'])) {
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
  //$sql = "SELECT * FROM MASKS WHERE id_cogerh = '".$_GET['id']."' ";
  $res = pg_query($sql);

  // echo pg_result_error($res);
  // echo "\n";
  // echo pg_result_status($res);
  // echo "\n";
  // echo pg_num_rows($res);
  // echo "\n";
  //echo pg_options($connection); 
  

  if (!$res) {
    echo "Ein Fehler ist aufgetreten.\n";
    exit;
  }
  $arr_data = pg_fetch_all($res);
  pg_free_result($res);
  pg_close($connection);
  //print_r($arr_data);
  // echo is_array($arr_data) ? 'Array' : 'kein Array';
  //echo "\n";

  $processed = array();
  
  foreach (($arr_data) as $key => $value) {
    //print_r(json_decode($value['features'], TRUE));
    //echo empty($value['features']) ? 'leeres Features' : 'FEATURE!';
    //echo nl2br("\n\n");
    $processed[$key] = json_decode($value['features'], TRUE);
  }

  $json = json_encode($processed);
  
  // write json file to disc and echo
  //file_put_contents('reservoirsById.json', $json);
  echo $json;
  
}
?>
