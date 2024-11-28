<?php

require_once __DIR__ . "/../lib/php/NOT_FOUND.php";
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/ProblemDetails.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_VESTIDO.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";
require_once __DIR__ . "/TABLA_COLOR.php";
require_once __DIR__ . "/TABLA_TALLA.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");

    $modelo =
        selectFirst(pdo: Bd::pdo(),  from: VESTIDO,  where: [VES_ID => $id]);

    if ($modelo === false) {
        $idHtml = htmlentities($id);
        throw new ProblemDetails(
            status: NOT_FOUND,
            title: "Vestido no encontrado.",
            type: "/error/vestidonoencontrado.html",
            detail: "No se encontró ningún vestido con el id $idHtml.",
        );
    }

    $encodeArchId = $modelo[ARCH_ID] === null ? "" : urlencode($modelo[ARCH_ID]);
    $htmlEncodeArchId = htmlentities($encodeArchId);

    devuelveJson([
        "id" => ["value" => $id],
        "modelo" => ["value" => $modelo[VES_MODELO]],
        "descripcion" => ["value" => $modelo[VES_DESCRIPCION]],
        "precio" => ["value" => $modelo[VES_PRECIO]],
        "estado" => [$modelo[VES_ESTADO]],
        "fechaDeCreacion" => ["value" => $modelo[VES_FECHA_CREACION]],
        "imagen" => [
            "data-file" => $htmlEncodeArchId === ""
                ? ""
                : "../srv/archivo.php?id=$htmlEncodeArchId"
        ],
        "catId" => ["value" => $modelo[CAT_ID]],
        "colId" => ["value" => $modelo[COL_ID]],
        "tallId" => ["value" => $modelo[TALL_ID]]
    ]);
});
