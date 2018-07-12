<?php
require_once 'dbconnect.php';
if (isset($_GET['id'])) {
  $sql = "SELECT json_build_object(
            'type',       'Feature',
            'id',         id,
            'geometry',   ST_AsGeoJSON(geom)::json,
            'properties', json_build_object(
                'feat_type',      ST_GeometryType(geom),
                'id_funceme',      id_funceme,
                'ingestion_time', ingestion_time,
                'area',           area,
                'source',         s.name
             )
          ) AS features FROM masks m "
          . "INNER JOIN source s on m.source_id = s.source_id WHERE id_funceme = '".$_GET['id']."' "
          . "ORDER BY ingestion_time DESC";
  $res = pg_query($connection, $sql);

  if (!$res) {
    echo "Ein Fehler ist aufgetreten.\n";
    exit;
  }

  $arr_data = pg_fetch_all($res);
  pg_free_result($res);
  //pg_close($connection);

  $processed = array();

  foreach (($arr_data) as $key => $value) {
    $processed[$key] = json_decode($value['features'], TRUE);
  }

  $json = json_encode($processed);

  echo $json;

}
?>
