<?php
include "./connection.php";
include "./header.php";

echo $header_html;

if ($conn) {
  $qry = $conn->query('SELECT * FROM ciudades');
  $qry2 = $conn->query('SELECT * FROM locales');
  echo '<div class="col-sm-2 mt-1 mb-2"><a class="ms-2" href="./login.php">Volver</a></div>
     <h4 class="ms-2">Registrar Local:</h4>
   <form action="" method="post" class="ms-2">
   <div class="row mb-3">
      <label for="local" class="col-sm-2 col-form-label">Local:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="local" name="local" autofocus required>
      </div>
    </div>
   <div class="row mb-3">
      <label for="ciudad" class="col-sm-2 col-form-label">Ciudad:</label>
      <div class="col-sm-4">
        <select class="form-select" name="ciudad" id="ciudad" required>
    <option value="">--Escoge una ciudad--</option>';
  while ($result = mysqli_fetch_array($qry)) {
    echo '<option value="' . $result['idCIUDAD'] . '">' . $result['ciudad'] . '</option>';
  }
  echo '</select>';
  echo    '</div>';
  echo  '</div>';
  echo  '<button type="submit" class="btn btn-primary">Ingresar local</button>';
  echo '</form>';

  echo "<div class='container mt-5'>
          <div class='row'>
            <div class='col-sm-8'>
              <h3>Locales</h3>
            </div>
          </div>
          <div class='row'>
            <div class='col-sm-2'>&nbsp;</div>
            <div class='col-sm-8'>
              <table class='table'>
                <thead>
                  <tr>
                    <td>idLOCAL</td>
                    <td>Local</td>
                    <td>Ciudad</td>
                  </tr>
                </thead>
              <tbody>";

  while ($result2 = mysqli_fetch_array($qry2)) {
    $qry3 = $conn->query("SELECT * FROM ciudades WHERE idCIUDAD =" . $result2['idCIUDAD']);
    if (mysqli_num_rows($qry3) == 1) {
      while ($result3 = mysqli_fetch_array($qry3)) {
        echo '<tr>';
        echo '<td>';
        echo $result2['idLOCAL'];
        echo '</td>';
        echo '<td>';
        echo $result2['local'];
        echo '</td>';
        echo '<td>';
        echo $result3['ciudad'];
        echo '</td>';
        echo '<td>';
        echo '<a href="./deleteLocal.php?id=' . $result2['idLOCAL'] . '">Eliminar<a/>';
        echo '</td>';
      }
    }
  }
}

$local = '';
$ciudad = '';

if (!empty($_POST["local"]) && !empty($_POST["ciudad"])) {
  $local = $_POST["local"];
  $ciudad = $_POST["ciudad"];

  $validar = $conn->query("SELECT * FROM locales WHERE idCIUDAD = $ciudad");

  if (mysqli_num_rows($validar) == 0) {
    $qry2 = $conn->query("INSERT INTO locales (local, idCIUDAD) VALUES ('$local','$ciudad')");
    if ($qry2) {
      header("Location: ./newLocal.php");
    }
  } else {
    echo
    '<script language="javascript">alert("No se puede crear más de un local por ciudad");</script>';
  };
}

echo $footer_html;
