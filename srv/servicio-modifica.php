<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaNombre.php";
require_once __DIR__ . "/../lib/php/validaDescripcion.php";
require_once __DIR__ . "/../lib/php/validaEstado.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_SERVICIO.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");
    $nombre = recuperaTexto("nombre");
    $descripcion = recuperaTexto("descripcion");
    $estado = recuperaTexto("estado");

    $nombre = validaNombre($nombre);
    $descripcion = validaDescripcion($descripcion);
    $estado = validaEstado($estado);

    update(
        pdo: Bd::pdo(),
        table: SERVICIO,
        set: [SER_NOMBRE => $nombre, SER_DESCRIPCION => $descripcion, SER_ESTADO => $estado],
        where: [SER_ID => $id]
    );

    devuelveJson([
        "id" => ["value" => $id],
        "nombre" => ["value" => $nombre],
        "descripcion" => ["value" => $descripcion],
        "estado" => ["value" => $estado]
    ]);
});
