<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaBytes.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/recuperaArray.php";
require_once __DIR__ . "/../lib/php/validaCue.php";
require_once __DIR__ . "/../lib/php/validaCorreo.php";
require_once __DIR__ . "/../lib/php/validaEstado.php";
require_once __DIR__ . "/../lib/php/validaFechaDeCreacion.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/delete.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_ROL.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";

ejecutaServicio(function () {

    $usuId = recuperaIdEntero("id");
    $cue = recuperaTexto("cue");
    $correo = recuperaTexto("correo");
    $estado = recuperaTexto("estado");
    $fechaDeCreacion = recuperaTexto("fechaDeCreacion");
    $rolIds = recuperaArray("rolIds");
    $bytes = recuperaBytes("imagen");

    $cue = validaCue($cue);
    $correo = validaCorreo($correo);
    $estado = validaEstado($estado);
    $fechaDeCreacion = validaFechaDeCreacion($fechaDeCreacion);

    $pdo = Bd::pdo();
    $pdo->beginTransaction();

    $usuario =
        selectFirst(pdo: $pdo, from: USUARIO, where: [USU_ID => $usuId]);

    if ($usuario === false) {
        $prodIdHtml = htmlentities($usuId);
        throw new ProblemDetails(
            status: NOT_FOUND,
            title: "Usuario no encontrado.",
            type: "/error/usuarioonoencontrado.html",
            detail: "No se encontró ningún usuario con el id $prodIdHtml.",
        );
    }

    update(
        pdo: $pdo,
        table: USUARIO,
        set: [
            USU_CUE => $cue,
            USU_CORREO => $correo,
            USU_ESTADO => $estado,
            USU_FECHA_CREACION => $fechaDeCreacion
        ],
        where: [USU_ID => $usuId]
    );

    delete(pdo: $pdo, from: USU_ROL, where: [USU_ID => $usuId]);
    insertBridges(
        pdo: $pdo,
        into: USU_ROL,
        valuesDePadre: [USU_ID => $usuId],
        valueDeHijos: [ROL_ID => $rolIds]
    );

    $archId = $usuario[ARCH_ID];

    if ($bytes !== "") {
        if ($archId === null) {
            insert(pdo: $pdo, into: ARCHIVO, values: [ARCH_BYTES => $bytes]);
            $archId = $pdo->lastInsertId();
        } else {
            update(
                pdo: $pdo,
                table: ARCHIVO,
                set: [ARCH_BYTES => $bytes],
                where: [ARCH_ID => $archId]
            );
        }

        update(
            pdo: $pdo,
            table: USUARIO,
            set: [ARCH_ID => $archId],
            where: [USU_ID => $usuId]
        );
    }

    $pdo->commit();

    $encodeArchId = $archId === null ? "" : urlencode($archId);
    $htmlEncodeArchId = htmlentities($encodeArchId);

    devuelveJson([
        "id" => ["value" => $usuId],
        "cue" => ["value" => $cue],
        "estado" => ["value" => $estado],
        "rolIds" => ["value" => $rolIds],
        "imagen" => [
            "data-file" => $htmlEncodeArchId === ""
                ? ""
                : "../srv/archivo.php?id=$htmlEncodeArchId"
        ]
    ]);
});
