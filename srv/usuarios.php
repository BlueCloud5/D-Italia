<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";

ejecutaServicio(function () {

  $lista = select(pdo: Bd::pdo(),  from: USUARIO,  orderBy: USU_CUE);

  $render = "";
  $contador = 1;
  foreach ($lista as $modelo) {
    $encodeId = urlencode($modelo[USU_ID]);
    $id = htmlentities($encodeId);

    $roles = select(pdo: Bd::pdo(), from: USU_ROL, where: [USU_ID => $id]);
    $rolesLista = "<ul style='text-align: start'>";
    foreach ($roles as $rol) {
      $rolesLista .= "<li>" . htmlentities($rol[ROL_ID]) . "</li>";
    }
    $rolesLista .= "</ul>";

    $cue = htmlentities($modelo[USU_CUE]);
    $render .=
      "<tr>
        <td>
          $contador
        </td>
        <td>
          $cue
        </td>
        <td>
          $rolesLista
        </td>
        <td>
          <div class='btn-group'>
            <a class='btn btn-warning text-white' href='modificaUsuario.html?id=$id'><i class='fa fa-pencil'></i></a>
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
