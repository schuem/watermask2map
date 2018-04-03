<?php
require_once 'dbconnect.php';
if (isset($_GET['id'])) {
  $sql = "SELECT id_cogerh, ingestion_time, area, s.name FROM masks m " 
          . "INNER JOIN source s on m.source_id = s.source_id WHERE id_cogerh = '".$_GET['id']."' "
          . "ORDER BY ingestion_time DESC";
  $res = pg_query($sql);
  $arr_data = pg_fetch_all($res);

  echo "<table class='table table-bordered table-condensed'>";
    echo "<caption> Data for Cogerh ID ".$arr_data[0]['id_cogerh']."</caption>";
    // header
    echo "<thead><tr>";
      echo "<th>Ingestion Time</th>";
      echo "<th>Area</th>";
      echo "<th>Source</th>";
    echo "</thead></tr>";
    // content
    echo "<tbody>";
      foreach ($arr_data as $v) {
        echo "<tr>";
          echo "<td>" .$v['ingestion_time']. "</td>";
          echo "<td>" .$v['area']. "</td>";
          echo "<td>" .$v['name']. "</td>";
        echo "</tr>";
      }
    echo "</tbody>";
  echo "</table>";
  //print_r(pg_fetch_all($res));
}
?>
