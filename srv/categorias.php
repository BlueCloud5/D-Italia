<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";

ejecutaServicio(function () {

  $lista = select(pdo: Bd::pdo(),  from: CATEGORIA,  orderBy: CAT_NOMBRE);

  $render = "";
  $contador = 1;
  foreach ($lista as $modelo) {
    $encodeId = urlencode($modelo[CAT_ID]);
    $id = htmlentities($encodeId);
    $nombre = htmlentities($modelo[CAT_NOMBRE]);
    $descripcion = htmlentities($modelo[CAT_DESCRIPCION]);
    $estado = htmlentities($modelo[CAT_ESTADO]);
    $render .=
      "<tr>
        <td>
          $contador
        </td>
        <td>
          $nombre
        </td>
        <td>
          $descripcion
        </td>
        <td>
          $estado
        </td>
        <td>
          <div class='btn-group'>
            <a class='btn btn-warning text-white' href='modificaCategoria.html?id=$id'><i class='fa fa-pencil'></i></a>
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
