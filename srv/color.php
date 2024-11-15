<?php

require_once __DIR__ . "/../lib/php/NOT_FOUND.php";
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/ProblemDetails.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_COLOR.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");

    $modelo =
        selectFirst(pdo: Bd::pdo(),  from: COLOR,  where: [COL_ID => $id]);

    if ($modelo === false) {
        $idHtml = htmlentities($id);
        throw new ProblemDetails(
            status: NOT_FOUND,
            title: "Color no encontrado.",
            type: "/error/colornoencontrado.html",
            detail: "No se encontró ningún color con el id $idHtml.",
        );
    }

    devuelveJson([
        "id" => ["value" => $id],
        "nombre" => ["value" => $modelo[COL_NOMBRE]],
        "hexadecimal" => ["value" => $modelo[COL_HEXADECIMAL]],
        "descripcion" => ["value" => $modelo[COL_DESCRIPCION]],
        "estado" => [$modelo[COL_ESTADO]]
    ]);
});
