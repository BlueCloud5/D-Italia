<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_COLOR.php";

ejecutaServicio(function () {

    $lista = select(pdo: Bd::pdo(),  from: COLOR,  orderBy: COL_NOMBRE);

    $render = "<option value=''>-- Sin color --</option>";
    foreach ($lista as $modelo) {
        $id = htmlentities($modelo[COL_ID]);
        $nombre = htmlentities($modelo[COL_NOMBRE]);
        $render .= "<option value='$id'>{$nombre}</option>";
    }

    devuelveJson(["colId" => ["innerHTML" => $render]]);
});
