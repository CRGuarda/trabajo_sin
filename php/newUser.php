<?php
include "./connection.php";
include "./header.php";

echo $header_html;

if ($conn) {
  $qry = $conn->query('SELECT * FROM ciudades');
  echo '<br>';
  echo '<div class="col-sm-2">&nbsp<a href="../index.php">Volver</a></div>';
  echo '<br>';
  echo '<form action="" method="post">';
  echo '<div class="row mb-3">';
  echo    '<label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<input type="text" class="form-control" id="nombre" name="nombre" autofocus required>';
  echo    '</div>';
  echo  '</div>';
  echo '<div class="row mb-3">';
  echo    '<label for="apellidos" class="col-sm-2 col-form-label">Apellido:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<input type="text" class="form-control" id="apellidos" name="apellidos" required>';
  echo    '</div>';
  echo  '</div>';
  echo '<div class="row mb-3">';
  echo    '<label for="nickname" class="col-sm-2 col-form-label">Nickname:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<input type="text" class="form-control" id="nickname" name="nickname" required>';
  echo    '</div>';
  echo  '</div>';
  echo '<div class="row mb-3">';
  echo    '<label for="ciudad" class="col-sm-2 col-form-label">Ciudad:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<select class="form-select" name="ciudad" id="ciudad" required>';
  echo  '<option value="">--Escoge una ciudad--</option>';
  while ($result = mysqli_fetch_array($qry)) {
    echo '<option value="' . $result['idCIUDAD'] . '">' . $result['ciudad'] . '</option>';
  }
  echo '</select>';
  echo    '</div>';
  echo  '</div>';
  echo '<div class="row mb-3">';
  echo    '<label for="password" class="col-sm-2 col-form-label">Password:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<input type="password" class="form-control" id="password" name="password" required>';
  echo    '</div>';
  echo  '</div>';
  echo  '<button type="submit" class="btn btn-primary">Ingresar usuario</button>';
  echo '</form>';
}

$nombre = '';
$apellidos = '';
$nickname = '';
$idCiudad = '';
$password = '';
$idRol = 2;

if (!empty($_POST["nombre"]) && !empty($_POST["apellidos"]) && !empty($_POST["nickname"]) && !empty($_POST["ciudad"]) && !empty($_POST["password"])) {
  $GLOBALS['nombre'] = $_POST["nombre"];
  $GLOBALS['apellidos'] = $_POST["apellidos"];
  $GLOBALS['nickname'] = $_POST["nickname"];
  $GLOBALS['idCiudad'] = $_POST["ciudad"];
  $GLOBALS['password'] = $_POST["password"];

  $validar = $conn->query("SELECT nickname FROM usuarios WHERE nickname = '$nickname'");

  if (mysqli_num_rows($validar) == 0) {
    $qry2 = $conn->query("INSERT INTO usuarios(nombres, apellidos, nickname, idROL, idCIUDAD) VALUES ('$nombre','$apellidos','$nickname','$idRol','$idCiudad')");

    if ($qry2) {
      $qry3 = $conn->query("SELECT idUSUARIO FROM usuarios WHERE nickname = '$nickname'");
      while ($result = mysqli_fetch_array($qry3)) {
        $qry4 = $conn->query("INSERT INTO contrasenas (contrasena, idUSUARIO) VALUES('" . md5($password) . "','" . $result['idUSUARIO'] . "')");
      }
    }
  } else {
    echo 'Usuario ya existe';
  };
}









echo $footer_html;