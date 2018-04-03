<?php
require_once 'dbconnect.php';
if (isset($_GET['id'])) {
  $sql = "SELECT * FROM masks WHERE id_cogerh = '".$_GET['id']."'";
  $res = pg_query($sql);
  print_r(pg_fetch_array($res, NULL, PGSQL_ASSOC));
}
?>
