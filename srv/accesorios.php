<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/../lib/php/fetchAll.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ACCESORIO.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";
require_once __DIR__ . "/TABLA_COLOR.php";

ejecutaServicio(function () {

  $lista = fetchAll(Bd::pdo()->query(
    "SELECT
      A.ACC_ID,
      A.ACC_MODELO,
      A.ACC_PRECIO,
      A.ACC_DESCRIPCION,
      A.ACC_ESTADO,
      A.ACC_FECHA_CREACION,
      AR.ARCH_ID,
      CA.CAT_NOMBRE,
      CO.COL_HEXADECIMAL,
      CO.COL_NOMBRE
     FROM ACCESORIO A
      LEFT JOIN CATEGORIA CA
      ON A.CAT_ID = CA.CAT_ID
      LEFT JOIN COLOR CO
      ON A.COL_ID = CO.COL_ID
      LEFT JOIN ARCHIVO AR
      ON A.ARCH_ID = AR.ARCH_ID
     ORDER BY A.ACC_MODELO"
  ));

  $render = "";
  $contador = 1;
  foreach ($lista as $modelo) {
    $encodeId = urlencode($modelo[ACC_ID]);
    $id = htmlentities($encodeId);
    $modeloVes = htmlentities($modelo[ACC_MODELO]);
    $descripcion = htmlentities($modelo[ACC_DESCRIPCION]);
    $precio = htmlentities("$" . number_format($modelo[ACC_PRECIO], 2));
    $estado = htmlentities($modelo[ACC_ESTADO]);
    $fechaDeCreacion = htmlentities($modelo[ACC_FECHA_CREACION]);

    $encodeArchId = $modelo[ARCH_ID] === null ? "" : urlencode($modelo[ARCH_ID]);
    $archId = $encodeArchId === "" ? "" : htmlentities($encodeArchId);
    $src = $archId === "" ? "" : "../srv/archivo.php?id=$archId";

    $catNombre = htmlentities($modelo[CAT_NOMBRE]);
    $hexadecimal = htmlentities($modelo[COL_HEXADECIMAL]);
    $colNombre = htmlentities($modelo[COL_NOMBRE]);
    $render .=
      "<tr>
        <td>
          $contador
        </td>
        <td>
          $modeloVes
        </td>
        <td>
          $precio
        </td>
        <td>
          $catNombre
        </td>
        <td>
          <label class='color-label' style='background-color: $hexadecimal;'></label>
          <br>
          $colNombre
        </td>
        <td>
          $descripcion
        </td>
        <td>
          <img src='$src' class='img-thumbnail' width='100px'>
        </td>
        <td>
          $fechaDeCreacion
        </td>
        <td>
          $estado
        </td>
        <td>
          <div class='btn-group'>
            <a class='btn btn-warning text-white' href='modificaAccesorio.html?id=$id'><i class='fa fa-pencil'></i></a>
            <button class='btn bg-danger text-white fw-bold' type='button' onclick='confirmDelete(\"$id\")'>
              <i class='fa fa-times'></i>
            </button>
          </div>
        </td>
      </tr>";
    $contador++;
  }

  devuelveJson(["lista" => ["innerHTML" => $render]]);
});
