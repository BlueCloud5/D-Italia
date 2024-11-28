<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_TALLA.php";

ejecutaServicio(function () {

  $lista = select(pdo: Bd::pdo(),  from: TALLA,  orderBy: TALL_VALOR);

  $render = "";
  $contador = 1;
  foreach ($lista as $modelo) {
    $encodeId = urlencode($modelo[TALL_ID]);
    $id = htmlentities($encodeId);
    $valorTalla = htmlentities($modelo[TALL_VALOR]);
    $render .=
      "<tr>
        <td>
          $contador
        </td>
        <td>
          $valorTalla
        </td>
        <td>
          <div class='btn-group'>
            <a class='btn btn-warning text-white' href='modificaTalla.html?id=$id'><i class='fa fa-pencil'></i></a>
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
