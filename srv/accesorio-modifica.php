<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaBytes.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/recuperaDecimal.php";
require_once __DIR__ . "/../lib/php/validaModelo.php";
require_once __DIR__ . "/../lib/php/validaDescripcion.php";
require_once __DIR__ . "/../lib/php/validaPrecio.php";
require_once __DIR__ . "/../lib/php/validaEstado.php";
require_once __DIR__ . "/../lib/php/validaFechaDeCreacion.php";
require_once __DIR__ . "/../lib/php/validaCatId.php";
require_once __DIR__ . "/../lib/php/validaColId.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ACCESORIO.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";
require_once __DIR__ . "/TABLA_COLOR.php";
require_once __DIR__ . "/validaImagen.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");
    $modelo = recuperaTexto("modelo");
    $catId = recuperaEntero("catId");
    $colId = recuperaEntero("colId");
    $descripcion = recuperaTexto("descripcion");
    $precio = recuperaDecimal("precio");
    $estado = recuperaTexto("estado");
    $fechaDeCreacion = recuperaTexto("fechaDeCreacion");
    $bytes = recuperaBytes("imagen");

    $modelo = validaModelo($modelo);
    $catId = validaCatId($catId);
    $colId = validaColId($colId);
    $descripcion = validaDescripcion($descripcion);
    $precio = validaPrecio($precio);
    $estado = validaEstado(estado: $estado);
    $fechaDeCreacion = validaFechaDeCreacion($fechaDeCreacion);
    $bytes = validaImagen($bytes);

    $pdo = Bd::pdo();
    $pdo->beginTransaction();

    $accesorio =
        selectFirst(pdo: $pdo, from: ACCESORIO, where: [ACC_ID => $id]);

    if ($accesorio === false) {
        $prodIdHtml = htmlentities($id);
        throw new ProblemDetails(
            status: NOT_FOUND,
            title: "Accesorio no encontrado.",
            type: "/error/accesorionoencontrado.html",
            detail: "No se encontró ningún accesorio con el id $prodIdHtml.",
        );
    }

    $archId = $accesorio[ARCH_ID];

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
    }

    update(
        pdo: $pdo,
        table: ACCESORIO,
        set: [
            ACC_MODELO => $modelo,
            ACC_DESCRIPCION => $descripcion,
            ACC_PRECIO => $precio,
            ACC_ESTADO => $estado,
            ACC_FECHA_CREACION => $fechaDeCreacion,
            ARCH_ID => $archId,
            CAT_ID => $catId,
            COL_ID => $colId
        ],
        where: [ACC_ID => $id]
    );

    $pdo->commit();

    $encodeArchId = $archId === null ? "" : urlencode($archId);
    $htmlEncodeArchId = htmlentities($encodeArchId);
    // Los bytes se descargan con "archivo.php"; no desde aquí.

    devuelveJson([
        "id" => ["value" => $id],
        "modelo" => ["value" => $modelo],
        "descripcion" => ["value" => $descripcion],
        "precio" => ["value" => "$" . number_format($precio, 2)],
        "estado" => ["value" => $estado],
        "fechaDeCreacion" => ["value" => $fechaDeCreacion],
        "imagen" => [
            "data-file" => $htmlEncodeArchId === ""
                ? ""
                : "../srv/archivo.php?id=$htmlEncodeArchId"
        ],
        "catId" => ["value" => $catId],
        "colId" => ["value" => $colId]
    ]);
});
