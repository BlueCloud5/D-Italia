<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaNombre.php";
require_once __DIR__ . "/../lib/php/validaHexadecimal.php";
require_once __DIR__ . "/../lib/php/validaDescripcion.php";
require_once __DIR__ . "/../lib/php/validaEstado.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_COLOR.php";

ejecutaServicio(function () {

    $nombre = recuperaTexto("nombre");
    $hexadecimal = strtoupper(recuperaTexto("hexadecimal"));
    $descripcion = recuperaTexto("descripcion");
    $estado = recuperaTexto("estado");

    $nombre = validaNombre($nombre);
    $hexadecimal = validaHexadecimal($hexadecimal);
    $descripcion = validaDescripcion($descripcion);
    $estado = validaEstado($estado);

    $pdo = Bd::pdo();
    insert(pdo: $pdo, into: COLOR, values: [COL_NOMBRE => $nombre, COL_HEXADECIMAL => $hexadecimal, COL_DESCRIPCION => $descripcion, COL_ESTADO => $estado]);
    $id = $pdo->lastInsertId();

    $encodeId = urlencode($id);
    devuelveCreated("/srv/color.php?id=$encodeId", [
        "id" => ["value" => $id],
        "nombre" => ["value" => $nombre],
        "hexadecimal" => ["value" => $hexadecimal],
        "descripcion" => ["value" => $descripcion],
        "estado" => ["value" => $estado]
    ]);
});
