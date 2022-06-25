
<?php
session_start();
$userValidate = isset($_SESSION['user_id']) ? 'Perfil' : 'Iniciar sesión';
$carritoValidate = isset($_SESSION["user_id"]) ? "<li class='nav-item'>
              <a class='nav-link' href='./carrito.php'>Carrito</a>
            </li>" : '';
$historialValidate = isset($_SESSION["user_id"]) ? "<li class='nav-item'>
              <a class='nav-link' href='./historial.php'>Historial</a>
            </li>" : '';            
$header_html = '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <title>Grupo 10</title>
</head>

<body>
<div>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">GRUPO 10</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
          aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="../index.php">Inicio
                <span class="visually-hidden">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./showProducts.php">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./login.php">' . $userValidate . '</a>
            </li>
            '
  . $carritoValidate . '<li class="nav-item">'
  . $historialValidate . '<li class="nav-item">
              <a class="nav-link" href="./about.php">Acerca</a>
            </li>
          </ul>
          <form action="" method="post" class="d-flex">
            <input class="form-control me-sm-2" type="text" placeholder="Buscar">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
          </form>
        </div>
      </div>
    </nav>

</div>';

$footer_html = '</body>
  </html>';
