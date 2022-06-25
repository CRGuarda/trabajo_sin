<?php
include './header.php';
include './connection.php';

echo $header_html;

if (isset($_SESSION['idCiudad'])) {
  echo '<div class=" ms-2 mt-2">
  <h1>Carrito de compras</h1>
  <p>Esta es la lista de productos agregados al carrito</p>
</div>';

  if (isset($_SESSION["cart"])) {
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
        echo '<td>';
        if ($value["qty"] >= $stockTienda['stock']) {
          echo '';
        } else {
          echo '<a href="remove_from_cart.php?add=1&id=' . $key . '">Aumentar</a>&nbsp;&nbsp;';
        }

        echo '<a href="remove_from_cart.php?id=' . $key  . '">Disminuir</a>&nbsp;&nbsp;';
        echo '<a href="remove_from_cart.php?remove_all=1&id=' . $key . '">Eliminar</a>';
        echo '</td>';
        echo '</tr>';
      }
    }

    echo '</tbody>
</table>';
    echo '<a href="./purchase.php?pago=1"><button class= "btn btn-primary ms-3">Check-out</button></a>';
  } else {
    echo '<h4>NO TIENE PRODUCTOS EN EL CARRITO!!! COMPRE, POR FAVOR 😁😁😁😁😁😁</h4>';
  }
} else {
  echo '<h3 class="ms-3 mt-2"><a href="./login.php">INICIE SESIÓN<a> PARA ENTRAR AL CARRITO</h4>';
}

echo $footer_html;
