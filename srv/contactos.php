<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_CONTACTO.php";

ejecutaServicio(function () {

  $lista = select(pdo: Bd::pdo(),  from: CONTACTO,  orderBy: CON_NOMBRE);

  $render = "";
  $contador = 1;
  foreach ($lista as $modelo) {
    $encodeId = urlencode($modelo[CON_ID]);
    $id = htmlentities($encodeId);
    $nombre = htmlentities($modelo[CON_NOMBRE]);
    $apellidos = htmlentities($modelo[CON_APELLIDOS]);
    $correo = htmlentities($modelo[CON_CORREO]);
    $telefono = htmlentities($modelo[CON_TELEFONO]);
    $mensaje = htmlentities($modelo[CON_MENSAJE]);
    $render .=
      "<tr>
        <td>
          $contador
        </td>
        <td>
          $nombre $apellidos
        </td>
        <td>
          $correo
        </td>
        <td>
          $telefono
        </td>
        <td>
          <div class='btn-group'>
            <a class='btn btn-info text-white' href='visualizaContacto.html?id=$id'><i class='fa fa-eye'></i></a>
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
