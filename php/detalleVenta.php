<?php
include './header.php';
include './connection.php';

echo $header_html;
$total = 0;

if (isset($_SESSION['user_id'])) {
  echo '
<div class="ms-3 mt-3"><a href="./historial.php">Regresar a Historial</a></div>
<div class=" ms-2 mt-2">
  <h1>Detalle de venta</h1>
  <p>Esta es la lista de productos que compraste con nosotros</p>
</div>';

  echo '<table class="table">
  <thead>
    <tr>
      <td>Producto</td>
      <td>Marca</td>
      <td>Cantidad</td>
      <td>Precio</td>
      <td>Subtotal</td>
    </tr>
  </thead>
  <tbody>';


    

      if (isset($_GET["id"])) {
        $qryid = $conn->query('SELECT p.idPRODUCTO FROM ventas v, productos p, detalle_ventas dv WHERE dv.idPRODUCTO=p.idPRODUCTO and v.idVENTA=dv.idVENTA and v.idVENTA ='.$_GET["id"].' and v.idUSUARIO =' . $_SESSION['user_id'] );
        while($idproducto=mysqli_fetch_array($qryid)){
        
          $qryidproducto = $conn->query('SELECT * FROM ventas v, productos p, detalle_ventas dv, marcas m WHERE dv.idPRODUCTO=p.idPRODUCTO and v.idVENTA=dv.idVENTA and p.idPRODUCTO = '.$idproducto['idPRODUCTO'].' and m.idMARCA=p.idMARCA and v.idVENTA ='.$_GET["id"].' and v.idUSUARIO =' . $_SESSION['user_id']  );
          $venta = mysqli_fetch_array($qryidproducto);
          echo '<tr>';
          echo '<td>';
          echo $venta['producto'];
          echo '</td>';
          echo '<td>';
          echo $venta['marca'];
          echo '</td>';
          echo '<td>';
          echo $venta["cantidad"];
          echo '</td>';
          echo '<td>';
          echo $venta["precioVenta"];
          echo '</td>';
          echo '<td>';
          echo $venta["precioVenta"]*$venta["cantidad"];
          echo '</td>';
          $total = $total + $venta["precioVenta"] *$venta["cantidad"];

        }
        
      }
      

    echo '</tbody>
</table>';
echo "<h4>Total pagado: <b>S/ $total</b></h4>";
  } 
 else {
  echo '<h3 class="ms-3 mt-2"><a href="./login.php">INICIE SESIÓN<a> PARA ENTRAR AL CARRITO</h4>';
}

echo $footer_html;
