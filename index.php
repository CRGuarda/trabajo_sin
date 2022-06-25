<?php
include "./php/connection.php";
include "./php/header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/bootstrap.css">
  <title>Grupo 10</title>
</head>

<body>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="">GRUPO 10</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="">Inicio
                <span class="visually-hidden">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./php/showProducts.php">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./php/login.php"><?php
                                                          echo isset($_SESSION['user_id']) ? 'Perfil' : 'Iniciar sesión'; ?></a>
            </li>

            <?php
            echo isset($_SESSION['user_id']) ? '<li class="nav-item">
              <a class="nav-link" href="./php/carrito.php">Carrito</a>
            </li>' : '';
            echo isset($_SESSION["user_id"]) ? "<li class='nav-item'>
              <a class='nav-link' href='./php/historial.php'>Historial</a>
            </li>" : '';     ?>
            <li class="nav-item">
              <a class="nav-link" href="./php/about.php">Acerca</a>
            </li>
          </ul>
          <form action="" method="post" class="d-flex">
            <input class="form-control me-sm-2" type="text" placeholder="Buscar">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
          </form>
        </div>
      </div>
    </nav>
  </div>

  <?php
  echo "<img class='img-fluid' width='100%' src='./img/index.png'>";
  ?>

  <?php
  echo $footer_html;
