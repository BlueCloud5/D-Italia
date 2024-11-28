<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/recuperaArray.php";
require_once __DIR__ . "/../lib/php/validaCue.php";
require_once __DIR__ . "/../lib/php/validaMatch.php";
require_once __DIR__ . "/../lib/php/validaCorreo.php";
require_once __DIR__ . "/../lib/php/validaEstado.php";
require_once __DIR__ . "/../lib/php/validaFechaDeCreacion.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_ROL.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";

ejecutaServicio(function () {

    $cue = recuperaTexto("cue");
    $correo = recuperaTexto("correo");
    $match = recuperaTexto("match");
    $estado = recuperaTexto("estado");
    $rolIds = recuperaArray("rolIds");

    $cue = validaCue($cue);
    $correo = validaCorreo($correo);

    if ($match === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta el match.",
            type: "/error/faltamatch.html",
            detail: "La solicitud no tiene el valor de match.",
        );

    if ($match === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Match en blanco.",
            type: "/error/matchenblanco.html",
            detail: "Pon texto en el campo match.",
        );

    $match = password_hash($match, PASSWORD_DEFAULT);

    $estado = validaEstado($estado);
    $fechaDeCreacion = date("Y-m-d H:i:s");

    $pdo = Bd::pdo();
    $pdo->beginTransaction();

    insert(
        pdo: $pdo,
        into: USUARIO,
        values: [
            USU_CUE => $cue,
            USU_MATCH => $match,
            USU_CORREO => $correo,
            USU_ESTADO => $estado,
            USU_FECHA_CREACION => $fechaDeCreacion
        ]
    );
    $usuId = $pdo->lastInsertId();

    if ($rolIds) {
        insertBridges(
            pdo: $pdo,
            into: USU_ROL,
            valuesDePadre: [USU_ID => $usuId],
            valueDeHijos: [ROL_ID => $rolIds]
        );
    } else {
        insertBridges(
            pdo: $pdo,
            into: USU_ROL,
            valuesDePadre: [USU_ID => $usuId],
            valueDeHijos: [ROL_ID => [ROL_ID_CLIENTE]]
        );
    }

    $pdo->commit();

    $encodeUsuId = urlencode($usuId);
    devuelveCreated("/srv/usuario.php?id=$encodeUsuId", [
        "id" => ["value" => $usuId],
        "cue" => ["value" => $cue],
        "match" => ["value" => $match],
        "correo" => ["value" => $correo],
        "estado" => ["value" => $estado],
        "fechaDeCreacion" => ["value" => $fechaDeCreacion],
        "rolIds" => ["value" => $rolIds],
    ]);
});
