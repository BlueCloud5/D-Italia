<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/fetchAll.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_VESTIDO.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";
require_once __DIR__ . "/TABLA_COLOR.php";
require_once __DIR__ . "/TABLA_TALLA.php";

ejecutaServicio(function () {

  $lista = fetchAll(Bd::pdo()->query(
    "SELECT
      V.VES_ID,
      V.VES_MODELO,
      V.VES_PRECIO,
      V.VES_DESCRIPCION,
      V.VES_ESTADO,
      V.VES_FECHA_CREACION,
      AR.ARCH_ID,
      CA.CAT_NOMBRE,
      CO.COL_HEXADECIMAL,
      CO.COL_NOMBRE,
      TA.TALL_VALOR
     FROM VESTIDO V
      LEFT JOIN CATEGORIA CA
      ON V.CAT_ID = CA.CAT_ID
      LEFT JOIN COLOR CO
      ON V.COL_ID = CO.COL_ID
      LEFT JOIN TALLA TA
      ON V.TALL_ID = TA.TALL_ID
      LEFT JOIN ARCHIVO AR
      ON V.ARCH_ID = AR.ARCH_ID
     ORDER BY V.VES_MODELO"
  ));

  $render = "";
  $contador = 1;
  foreach ($lista as $modelo) {
    $encodeId = urlencode($modelo[VES_ID]);
    $id = htmlentities($encodeId);
    $modeloVes = htmlentities($modelo[VES_MODELO]);
    $descripcion = htmlentities($modelo[VES_DESCRIPCION]);
    $precio = htmlentities("$" . number_format($modelo[VES_PRECIO], 2));
    $estado = htmlentities($modelo[VES_ESTADO]);
    $fechaDeCreacion = htmlentities($modelo[VES_FECHA_CREACION]);

    $encodeArchId = $modelo[ARCH_ID] === null ? "" : urlencode($modelo[ARCH_ID]);
    $archId = $encodeArchId === "" ? "" : htmlentities($encodeArchId);
    $src = $archId === "" ? "" : "../srv/archivo.php?id=$archId";

    $catNombre = htmlentities($modelo[CAT_NOMBRE]);
    $hexadecimal = htmlentities($modelo[COL_HEXADECIMAL]);
    $colNombre = htmlentities($modelo[COL_NOMBRE]);
    $tallValor = htmlentities($modelo[TALL_VALOR]);
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
          $tallValor
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
            <a class='btn btn-warning text-white' href='modificaVestido.html?id=$id'><i class='fa fa-pencil'></i></a>
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
