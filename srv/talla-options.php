<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_TALLA.php";

ejecutaServicio(function () {

    $lista = select(pdo: Bd::pdo(),  from: TALLA,  orderBy: TALL_VALOR);

    $render = "<option value=''>-- Sin talla --</option>";
    foreach ($lista as $modelo) {
        $id = htmlentities($modelo[TALL_ID]);
        $valor = htmlentities($modelo[TALL_VALOR]);
        $render .= "<option value='$id'>{$valor}</option>";
    }

    devuelveJson(["tallId" => ["innerHTML" => $render]]);
});
