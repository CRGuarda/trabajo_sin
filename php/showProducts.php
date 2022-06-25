<?php
include "./connection.php";
include "./header.php";

echo $header_html;

if ($conn) {
  if (isset($_SESSION['user_id'])) {
    $qry = $conn->query('SELECT p.*, s.stock from productos p, stock_local s, locales l WHERE p.idPRODUCTO = s.idPRODUCTO AND s.idLOCAL = l.idLOCAL and l.idCIUDAD = ' . $_SESSION['idCiudad'] . ' ORDER BY s.stock DESC');
  } else {
    $qry = $conn->query('SELECT p.*, s.stock from productos p, stock_local s, locales l WHERE p.idPRODUCTO = s.idPRODUCTO AND s.idLOCAL = l.idLOCAL ORDER BY s.stock DESC');
  }
  echo "<div class='ms-3 mt-3'><a href='../index.php'>Inicio</a></div>
<div class='row mt-2'>";
  if (!isset($_SESSION['user_id'])) {
    echo '<div class="me-3 row">
    <div class="alert alert-dismissible alert-danger">
  <h4 class="alert-heading">ATENCIÓN!</h4>
  <p class="mb-0">Para poder usar el carrito de compras, es necesario tener una sesión activa. Por favor, <a href="./login.php" class="alert-link">inicie sesión</a>.</p>
</div>
</div>';
  } else {
    $qryLocal = $conn->query("SELECT * FROM locales WHERE idCIUDAD= " . $_SESSION['idCiudad'] . " LIMIT 1");
    if (mysqli_num_rows($qryLocal) == 1) {
      $resultLocal = mysqli_fetch_array($qryLocal);

      echo
      '<div class="row mb-2">
      <label for="local" class="col-sm-auto col-form-label ms-2">Local de recojo en ' . $_SESSION['ciudad'] . ':</label>
      <div class="col-sm-auto">
      <fieldset disabled>
        <input type="text" placeholder="' . $resultLocal['local'] . '"class="form-control form-control-sm" id="local" name="local" autofocus required>
        </fieldset>
      </div>
      <div class="col-sm-auto"><p class="text-primary">Para cambiar local de recojo, cambie su <a href="./login.php"><strong>ciudad</strong></a>.</p></div>
    </div>';
    } else {
      echo '<div class="row mb-2">
      <label for="local" class="col-sm-auto ms-3 col-form-label">No existe local de recojo en ' . $_SESSION['ciudad'] . '</label>
      <div class="col-sm-auto"><p class="text-primary mt-2">Para cambiar local de recojo, cambie su <a href="./login.php"><strong>ciudad</strong></a>.</p></div>
      </div>';
    }
  }


  while ($result = mysqli_fetch_array($qry)) {
    $qry2 = $conn->query("SELECT marca FROM marcas WHERE idMARCA = " . $result['idMARCA']);

    if (mysqli_num_rows($qry2) == 1) {

      while ($result2 = mysqli_fetch_array($qry2)) {
        $userSession = isset($_SESSION['user_id']) ? '<a href="./add_to_cart.php?id=' . $result['idPRODUCTO'] . '">Añadir al carrito 🛒</a>' : '';
        $addValidate = ($result['stock'] == 0) ? '' : $userSession;
        $stockValidate = (isset($_SESSION['user_id'])) ? ' - Stock: ' . $result['stock'] : '';
        $alert = isset($_SESSION["alert"]) ? '<script language="javascript">alert("' . $_SESSION['alert'] . '");</script>' : '';
        echo '
        <div class="card bg-light mb-4 ms-3 col-sm-5" style="max-width: 20rem;">
          <div class="card-header">' . $result2['marca'] . $stockValidate . '</div>
          <div class="card-body">
            <h4 class="card-title">' . $result['producto'] . ' - <b class="text-danger">S/' . $result['precio'] . '</b></h4>
            <img class="picture" src="../img/' . $result['imagen'] . '" alt="imagen de prueba">
            <p class="card-text mt-2">' . $result['descProducto'] . '</p>
            <a href="./detalleProducto.php?id=' . $result['idPRODUCTO'] . '"><strong>Ver detalle</strong></a><p>
            ' . $addValidate . $alert . '</div>
  </div>';
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
  /* echo '</div>
  </div>'; */
}



echo $footer_html;
