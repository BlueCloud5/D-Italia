<?php

require_once __DIR__ . "/../lib/php/NOT_FOUND.php";
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/ProblemDetails.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");

    $modelo =
        selectFirst(pdo: Bd::pdo(),  from: CATEGORIA,  where: [CAT_ID => $id]);

    if ($modelo === false) {
        $idHtml = htmlentities($id);
        throw new ProblemDetails(
            status: NOT_FOUND,
            title: "Categoría no encontrada.",
            type: "/error/categorianoencontrada.html",
            detail: "No se encontró ninguna categoría con el id $idHtml.",
        );
    }

    devuelveJson([
        "id" => ["value" => $id],
        "nombre" => ["value" => $modelo[CAT_NOMBRE]],
        "descripcion" => ["value" => $modelo[CAT_DESCRIPCION]],
        "estado" => [$modelo[CAT_ESTADO]]
    ]);
});
