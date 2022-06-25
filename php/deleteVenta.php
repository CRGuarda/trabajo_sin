<?php
include "./connection.php";
include "./header.php";

echo $header_html;

if (isset($_GET['id'])) {
  $qryUpdate = $conn->query('UPDATE ventas SET estado = "CANCELADO" WHERE idVENTA = ' . $_GET['id']);
  $qryStock = $conn->query('SELECT d.idPRODUCTO, d.cantidad, v.idLOCAL FROM ventas v , detalle_ventas d WHERE v.idVENTA = d.idVENTA  AND v.idVENTA = ' . $_GET['id']);
  while ($result = mysqli_fetch_array($qryStock)) {
    $qryUpdate = $conn->query('UPDATE stock_local SET stock = stock + ' . $result['cantidad'] . ' WHERE idPRODUCTO = ' . $result['idPRODUCTO'] . ' AND idLOCAL = ' . $result['idLOCAL']);
  }
}

echo $footer_html;