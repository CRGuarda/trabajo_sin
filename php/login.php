<?php
include "./connection.php";
include "./header.php";
include "./adminAccess.php";


echo $header_html;

if (isset($_SESSION['user_id'])) {
  $rolVerifier = ($_SESSION['user_rol'] == 1) ? 'ADMIN' : '';
  echo "<h3 class='mt-3 ms-2'>Bienvenid@, " . $_SESSION['nombres'] . " " . $_SESSION['apellidos'] . " - <b class='text-danger'>" . $rolVerifier . "</b></h3>";
  echo "<h6 class='mt-3 ms-2'>Ciudad actual: " . $_SESSION['ciudad'] . "</h6>";

  if ($_SESSION['user_rol'] == 1) {
    echo $admin;
  }
  echo '<div class="me-3 row">
    <div class="alert alert-dismissible alert-warning">
  <h4 class="alert-heading">ALERTA!</h4>
  <p class="mb-0">Cambiar de ciudad eliminará tu carrito de compras.</p>
</div>
</div>';
  $qryCiudad = $conn->query("SELECT * from ciudades WHERE idCIUDAD <> " . $_SESSION['idCiudad']);
  echo
  '<form action="" method=post>
  <div class="row mb-3">
      <label for="ciudad" class="col-sm-1 ms-2 col-form-label">Cambiar ciudad:</label>
      <div class="col-sm-2">
        <select class="form-select" name="ciudad" id="ciudad" required>
    <option value="">--Escoge una ciudad--</option>';



  while ($result = mysqli_fetch_array($qryCiudad)) {
    echo '<option value="' . $result['idCIUDAD'] . '">' . $result['ciudad'] . '</option>';
  }
  echo '</select>';
  echo    '</div>';
  echo  '</div>';
  echo  '<button type="submit" class="btn btn-primary ms-5 mb-5 col-sm-2"name="cambioCiudad">Cambiar ciudad</button>';
  echo '</form>';


  echo '<form action="./login.php" method=post>
  <button class="btn btn-primary ms-2" name="logout">LOG OUT</button>
  </form>';
} else {
  echo '
<h4 class="ms-3 mt-3">Iniciar sesión:</h4>
  <form action="" method="post" class="ms-3">
    <div class="row mb-3">
      <label for="nickname" class="col-sm-1 col-form-label">Nickname:</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="nickname" name="nickname" autofocus required>
      </div>
    </div>
    <div class="row mb-3">
      <label for="password" class="col-sm-1 col-form-label">Password:</label>
      <div class="col-sm-2">
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
  </form>
  <div>
  <a class="ms-3" href="./newUser.php">Registrarse</a>
  </div>
  ';


  $nickname = '';
  $password = '';

  if (!empty($_POST["nickname"]) && !empty($_POST["password"])) {
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];

    if ($conn) {
      $qry = $conn->query("SELECT * FROM usuarios WHERE nickname = '$nickname'");
      if (mysqli_num_rows($qry) == 1) {
        $user = mysqli_fetch_array($qry);
        $pass = md5($password);

        $qry2 = $conn->query('SELECT idCONTRASENA FROM contrasenas WHERE idUSUARIO =' . $user['idUSUARIO'] . " AND contrasena = '$pass'");
        if (mysqli_num_rows($qry2) == 1) {
          $qry3 = $conn->query("SELECT * FROM ciudades WHERE idCIUDAD = " . $user['idCIUDAD']);
          $city = mysqli_fetch_array($qry3);
          $_SESSION['user_id'] = $user['idUSUARIO'];
          $_SESSION['nickname'] = $nickname;
          $_SESSION['user_rol'] = $user['idROL'];
          $_SESSION['nombres'] = $user['nombres'];
          $_SESSION['apellidos'] = $user['apellidos'];
          $_SESSION['idCiudad'] = $user['idCIUDAD'];
          $_SESSION['ciudad'] = $city['ciudad'];

          header("Location: ./login.php");
        } else {
          echo
          '<script language="javascript">alert("Contraseña inválida");</script>';
        }
      } else {
        echo
        '<script language="javascript">alert("No existe usuario con nickname ' . $nickname . ' ");</script>';
      }
    }
  }
}

if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: ./login.php");
}

if (isset($_POST['cambioCiudad'])) {

  $update = $conn->query("UPDATE usuarios SET idCIUDAD = " . $_POST['ciudad'] . " WHERE idUSUARIO = " . $_SESSION['user_id']);
  if ($update) {
    $query = $conn->query("SELECT * FROM ciudades WHERE idCIUDAD =" . $_POST['ciudad']);
    $ciudad = mysqli_fetch_array($query);
    $_SESSION['ciudad'] = $ciudad['ciudad'];
    $_SESSION['idCiudad'] = $_POST['ciudad'];
    unset($_SESSION['cart']);
  }
  header("Location: ./login.php");
}







echo $footer_html;
