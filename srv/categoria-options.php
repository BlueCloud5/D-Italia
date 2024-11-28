<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";

ejecutaServicio(function () {

    $lista = select(pdo: Bd::pdo(),  from: CATEGORIA,  orderBy: CAT_NOMBRE);

    $render = "<option value=''>-- Sin categoría --</option>";
    foreach ($lista as $modelo) {
        $id = htmlentities($modelo[CAT_ID]);
        $nombre = htmlentities($modelo[CAT_NOMBRE]);
        $render .= "<option value='$id'>{$nombre}</option>";
    }

    devuelveJson(["catId" => ["innerHTML" => $render]]);
});
