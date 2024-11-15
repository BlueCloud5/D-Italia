<?php

require_once __DIR__ . "/../lib/php/NOT_FOUND.php";
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/ProblemDetails.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");

    $modelo =
        selectFirst(pdo: Bd::pdo(),  from: USUARIO,  where: [USU_ID => $id]);
    $roles = select(pdo: Bd::pdo(), from: USU_ROL, where: [USU_ID => $id]);

    if ($modelo === false) {
        $idHtml = htmlentities($id);
        throw new ProblemDetails(
            status: NOT_FOUND,
            title: "Usuario no encontrado.",
            type: "/error/usuarionoencontrado.html",
            detail: "No se encontró ningún usuario con el id $idHtml.",
        );
    }

    devuelveJson([
        "id" => ["value" => $id],
        "cue" => ["value" => $modelo[USU_CUE]],
        "match" => ["value" => $modelo[USU_MATCH]],
        "roles[]" => ["value" => $roles]
    ]);
});
