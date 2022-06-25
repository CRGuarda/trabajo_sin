<?php
include './header.php';
include './connection.php';

echo $header_html;

if (isset($_SESSION['user_id'])) {
  echo '<div class=" ms-2 mt-2">
  <h1>Historial de ventas</h1>
  <p>Esta es la lista de ventas que ha realizado con nosotros</p>
</div>';

  echo '<table class="table">
  <thead>
    <tr>
      <td>ID Transacción</td>
      <td>Fecha</td>
      <td>Estado</td>
      <td>Método de Pago</td>
      <td>Local</td>
      <td>Opciones</td>
    </tr>
  </thead>
  <tbody>';


      $qryid = $conn->query('SELECT idVENTA FROM ventas v WHERE v.idUSUARIO = ' . $_SESSION['user_id'].' ORDER BY fecha DESC' );
      
      if ($qryid) {
        while($idventa=mysqli_fetch_array($qryid)){
        
          $qry = $conn->query('SELECT * FROM ventas v, metodos_pago m, locales l, ciudades c WHERE v.idMETODOS_PAGO=m.idMETODOS_PAGO AND v.idLOCAL=l.idLOCAL AND l.idCIUDAD=c.idCIUDAD and v.idVENTA ='.$idventa['idVENTA'].' and v.idUSUARIO = ' . $_SESSION['user_id'] );
          $venta = mysqli_fetch_array($qry);
          echo '<tr>';
          echo '<td>';
          echo $venta['idVENTA'];
          echo '</td>';
          echo '<td>';
          echo $venta['fecha'];
          echo '</td>';
          echo '<td>';
          echo $venta["estado"];
          echo '</td>';
          echo '<td>';
          echo $venta["metodo_pago"];
          echo '</td>';
          echo '<td>';
          echo $venta["local"].'-'.$venta["ciudad"];
          echo '</td>';
          echo '<td>';
          echo '<a href="detalleVenta.php?id=' . $idventa['idVENTA']  . '">Ver detalle</a>&nbsp;&nbsp;';
          /* echo '<a href="remove_from_cart.php?remove_all=1&id=' . $key . '">Eliminar</a>'; */
          echo '</td>';
        }

/*         echo '<a href="remove_from_cart.php?remove_all=1&id=' . $key . '">Eliminar</a>';
        echo '</td>';
        echo '</tr>';  */
      }


    echo '</tbody>
</table>';
  } 
 else {
  echo '<h3 class="ms-3 mt-2"><a href="./login.php">INICIE SESIÓN<a> PARA ENTRAR AL CARRITO</h4>';
}

echo $footer_html;
