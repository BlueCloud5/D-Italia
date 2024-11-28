<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/fetchAll.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";

ejecutaServicio(function () {

  $lista = fetchAll(Bd::pdo()->query(
    "SELECT
      U.USU_ID,
      U.USU_CUE,
      U.USU_CORREO,
      U.USU_FECHA_CREACION,
      U.USU_ESTADO,
      AR.ARCH_ID,
      GROUP_CONCAT(UR.ROL_ID, '') AS roles
     FROM USUARIO U
      LEFT JOIN USU_ROL UR
      ON U.USU_ID = UR.USU_ID
      LEFT JOIN ARCHIVO AR
      ON U.ARCH_ID = AR.ARCH_ID
     GROUP BY U.USU_CUE
     ORDER BY U.USU_CUE"
  ));

  $render = "";
  $contador = 1;
  foreach ($lista as $modelo) {
    $encodeUsuId = urlencode($modelo[USU_ID]);
    $usuId = htmlentities($encodeUsuId);
    $usuCue = htmlentities($modelo[USU_CUE]);
    $roles = $modelo["roles"] === null || $modelo["roles"] === ""
      ? "<em>-- Sin roles --</em>"
      : htmlentities($modelo["roles"]);
    $usuCorreo = htmlentities($modelo[USU_CORREO]);

    if ($modelo[ARCH_ID] === null) {
      $src = "../recursos/images/perfil/default/anonimo.png";
    } else {
      $archId = htmlentities(urlencode($modelo['ARCH_ID']));
      $src = "../srv/archivo.php?id=$archId";
    }

    $usuFechaDeCreacion = htmlentities($modelo[USU_FECHA_CREACION]);
    $usuEstado = htmlentities($modelo[USU_ESTADO]);
    $render .=
      "<tr>
        <td>
          $contador
        </td>
        <td>
          $usuCue
        </td>
        <td>
          $usuCorreo
        </td>
        <td>
          $roles
        </td>
        <td>
          <img src='$src' class='img-thumbnail' width='100px'>
        </td>
        <td>
          $usuFechaDeCreacion
        </td>
        <td>
          $usuEstado
        </td>
        <td>
          <div class='btn-group'>
            <a class='btn btn-warning text-white' href='modificaUsuario.html?id=$usuId'><i class='fa fa-pencil'></i></a>
            <button class='btn bg-danger text-white fw-bold' type='button' onclick='confirmDelete(\"$usuId\")'>
              <i class='fa fa-times'></i>
            </button>
          </div>
        </td>
      </tr>";
    $contador++;
  }

  devuelveJson(["lista" => ["innerHTML" => $render]]);
});
