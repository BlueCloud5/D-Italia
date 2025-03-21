<?php

require_once __DIR__ . "/../lib/php/NOT_FOUND.php";
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/ProblemDetails.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_CONTACTO.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");

    $modelo =
        selectFirst(pdo: Bd::pdo(),  from: CONTACTO,  where: [CON_ID => $id]);

    if ($modelo === false) {
        $idHtml = htmlentities($id);
        throw new ProblemDetails(
            status: NOT_FOUND,
            title: "Mensaje de contacto no encontrado.",
            type: "/error/contactonoencontrado.html",
            detail: "No se encontró ningún mensaje de contacto con el id $idHtml.",
        );
    }

    devuelveJson([
        "id" => ["value" => $id],
        "nombre" => ["value" => $modelo[CON_NOMBRE]],
        "apellidos" => ["value" => $modelo[CON_APELLIDOS]],
        "correo" => ["value" => $modelo[CON_CORREO]],
        "telefono" => ["value" => $modelo[CON_TELEFONO]],
        "mensaje" => ["value" => $modelo[CON_MENSAJE]]
    ]);
});
