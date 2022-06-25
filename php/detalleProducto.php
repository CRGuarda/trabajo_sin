<?php
include "./connection.php";
include "./header.php";

echo $header_html;


if (isset($_GET["id"])) {
  if (isset($_SESSION['user_id'])) {
    $qry = $conn->query('SELECT p.*, s.stock from productos p, stock_local s, locales l WHERE p.idPRODUCTO = s.idPRODUCTO AND s.idLOCAL = l.idLOCAL AND s.idPRODUCTO =' . $_GET["id"] . ' and l.idCIUDAD = ' . $_SESSION['idCiudad'] . ' ORDER BY s.stock DESC');



    while ($result = mysqli_fetch_array($qry)) {

      $qry2 = $conn->query("SELECT marca FROM marcas WHERE idMARCA = " . $result['idMARCA']);

      if (mysqli_num_rows($qry2) == 1) {

        while ($result2 = mysqli_fetch_array($qry2)) {
          $userSession = isset($_SESSION['user_id']) ? '<a href="./add_to_cart.php?id=' . $result['idPRODUCTO'] . '">Añadir al carrito 🛒</a></div></div>' : '</div></div>';
          $stockValidate = ($result['stock'] == 0) ? '' : $userSession;
          $alert = isset($_SESSION["alert"]) ? '<script language="javascript">alert("' . $_SESSION['alert'] . '");</script>' : '';

          echo '
          <div class="ms-3 mt-3"><a href="./showProducts.php">Ir a Productos</a></div>
          <div class="row">
            <div class="col">
              <br><img class="picture" src="../img/' . $result['imagen'] . '" alt="imagen de prueba">  
            </div>

            <div class="col">

              <h3><br>' . $result2['marca'] . '</h3>
              <h1> ' . $result['producto'] . '</h1>
              <h3><br> ' . $result['descProducto'] . '</h3>
              <h3><br>Stock: ' . $result['stock'] . '</h3>
              <h2><br> Precio: S/' . $result['precio'] . '</h2>

            ' . $stockValidate . $alert . '</div>';




          unset($_SESSION["alert"]);
          /*  try {
            if (isset($_SESSION['user_id'])) {
              echo '<a href="./carrito.php?id=' . $result['idPRODUCTO'] . '">Añadir</a>';
            } else {
              echo '';
            }
          } catch (\Throwable $th) {
            //throw $th;
          } finally {
            echo '</div>
                    </div>';
          } */
        }
      }
    }
    echo '</div>';
  }else{

    ##para los de sin sesion

    $qry = $conn->query('SELECT p.*, s.stock from productos p, stock_local s, locales l WHERE p.idPRODUCTO = s.idPRODUCTO AND s.idLOCAL = l.idLOCAL AND s.idPRODUCTO =' . $_GET["id"] );

    while ($result = mysqli_fetch_array($qry)) {

      $qry2 = $conn->query("SELECT marca FROM marcas WHERE idMARCA = " . $result['idMARCA']);

      if (mysqli_num_rows($qry2) == 1) {

        while ($result2 = mysqli_fetch_array($qry2)) {
     

          echo '
          <div class="ms-3 mt-3"><a href="./showProducts.php">Ir a Productos</a></div>
          <div class="row">
            <div class="col">
              <br><img class="picture" src="../img/' . $result['imagen'] . '" alt="imagen de prueba">  
            </div>

            <div class="col">

              <h3><br>' . $result2['marca'] . '</h3>
              <h1> ' . $result['producto'] . '</h1>
              <h3><br> ' . $result['descProducto'] . '</h3>
              <h2><br> Precio: S/' . $result['precio'] . '</h2>

            </div>';




          unset($_SESSION["alert"]);

        }
      }
    }
    echo '</div>';


  }
} else {
  echo '<h5>SELECCIONE EL DETALLE EN LA LISTA DE PRODUCTOS</h5>';
}















echo $footer_html;
