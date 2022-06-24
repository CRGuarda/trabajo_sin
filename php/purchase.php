<?php
include "./connection.php";
include "./header.php";

echo $header_html;
$total = 0;
if (isset($_GET['pago'])) {
  $qry = $conn->query("SELECT * FROM metodos_pago");
  $qryLocal = $conn->query("SELECT l.local, c.ciudad FROM locales l, ciudades c WHERE l.idCIUDAD = c.idCIUDAD AND l.idCIUDAD = " . $_SESSION['idCiudad']);
  $local = mysqli_fetch_array($qryLocal);
  echo '<div class="col-sm-2 mt-1 mb-2 ms-2"><a class="ms-2" href="./carrito.php">Volver</a></div>
     <h4 class="ms-2">Seleccionar método de pago:</h4>
   <form action="" method="post" class="ms-2">
   <div class="row mb-3">
      <label for="metodo" class="col-sm-1 col-form-label">Método de pago:</label>
      <div class="col-sm-2">
        <select class="form-select" name="metodo" id="metodo" required>
    <option value="">--Escoge un metodo--</option>';
  while ($result = mysqli_fetch_array($qry)) {
    echo '<option value="' . $result['idMETODOS_PAGO'] . '">' . $result['metodo_pago'] . '</option>';
  }
  echo '</select>';
  echo    '</div>';
  echo  '</div>';

  echo '<h5>Recojo en: <b>' . $local['local'] . ' - ' . $local['ciudad'] . '</b></h5>';
  echo '<h4>Lista de productos:</h4>';
  echo '<table class="table">
  <thead>
    <tr>
      <td>Producto</td>
      <td>Marca</td>
      <td>Cantidad</td>
      <td>Subtotal (S/)</td>
      <td>&nbsp;</td>
    </tr>
  </thead>
  <tbody>';

  foreach ($_SESSION["cart"] as $key => $value) {

    $qry = $conn->query('SELECT s.stock stock, upper(p.producto) producto, upper(m.marca) marca,p.precio  from productos p, stock_local s, locales l, marcas m WHERE m.idMARCA = p.idMARCA AND p.idPRODUCTO = s.idPRODUCTO AND s.idLOCAL = l.idLOCAL and l.idCIUDAD = ' . $_SESSION['idCiudad'] . ' AND s.idPRODUCTO =' . $key);
    $stockTienda = mysqli_fetch_array($qry);
    if ($value["qty"] != 0) {
      echo '<tr>';
      echo '<td>';
      echo $stockTienda['producto'];
      echo '</td>';
      echo '<td>';
      echo $stockTienda['marca'];
      echo '</td>';
      echo '<td>';
      echo $value["qty"];
      echo '</td>';
      echo '<td>';
      echo $value["qty"] * $stockTienda['precio'];
      echo '</td>';
      echo '</tr>';
      $total = $total + $value["qty"] * $stockTienda['precio'];
    }
  }
  echo '</tbody>
</table>';
  echo "<h4>Total a pagar: <b>S/ $total</b></h4>";
  echo  '<button type="submit" class="btn btn-primary" name="btnVenta">Confirmar venta</button>';
  echo '</form>';
}

if (isset($_POST['metodo'])) {

  $_SESSION['idMetodoPago'] = $_POST['metodo'];
  $qryLocalVenta = $conn->query('SELECT idLOCAL FROM locales WHERE idCIUDAD =' . $_SESSION['idCiudad']);
  $localVenta = mysqli_fetch_array($qryLocalVenta);
  $qryVentas = $conn->query('INSERT INTO ventas (fecha, estado, idUSUARIO, idMETODOS_PAGO, idLOCAL) VALUES ( SYSDATE(), "ACTIVO", ' . $_SESSION['user_id'] . ', ' . $_SESSION['idMetodoPago'] . ', ' . $localVenta['idLOCAL'] . ')');

  if ($qryVentas) {
    foreach ($_SESSION["cart"] as $key => $value) {
      $qryIDVenta = $conn->query('SELECT idVENTA from ventas WHERE idUSUARIO= ' . $_SESSION['user_id'] . ' AND idMETODOS_PAGO = ' . $_SESSION['idMetodoPago'] . ' AND idLOCAL= ' . $localVenta['idLOCAL'] . ' ORDER BY fecha DESC LIMIT 1');
      $qryPrecio = $conn->query('SELECT precio FROM productos WHERE idPRODUCTO = ' . $key);
      $precio = mysqli_fetch_array($qryPrecio);
      $idVenta = mysqli_fetch_array($qryIDVenta);
      $qryDetalleVentas = $conn->query('INSERT INTO detalle_ventas (cantidad, idPRODUCTO, idVENTA, precioVenta) VALUES ( ' . $value['qty'] . ', ' . $key . ',' . $idVenta['idVENTA'] . ', ' . $precio['precio'] . ' )');
    }

    unset($_SESSION['cart']);
    header("Location: ./historial.php");
  }
}



echo $footer_html;
