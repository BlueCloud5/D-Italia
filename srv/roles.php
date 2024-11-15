<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ROL.php";

ejecutaServicio(function () {

  $lista = select(pdo: Bd::pdo(),  from: ROL,  orderBy: ROL_ID);

  $render = "";
  foreach ($lista as $modelo) {
    $encodeId = urlencode($modelo[ROL_ID]);
    $id = htmlentities($encodeId);
    $render .=
      "<div class='form-check'>
        <input type='checkbox' class='form-check-input' id='$id' name='roles[]' value='$id'>
        <label class='form-check-label' for='$id'>$id</label>
      </div>";
  }

  devuelveJson(["roles" => ["innerHTML" => $render]]);
});
