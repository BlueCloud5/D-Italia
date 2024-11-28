<?php

require_once __DIR__ . "/../lib/php/BAD_REQUEST.php";
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaBytes.php";
require_once __DIR__ . "/../lib/php/recuperaDecimal.php";
require_once __DIR__ . "/../lib/php/recuperaEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaModelo.php";
require_once __DIR__ . "/../lib/php/validaDescripcion.php";
require_once __DIR__ . "/../lib/php/validaPrecio.php";
require_once __DIR__ . "/../lib/php/validaEstado.php";
require_once __DIR__ . "/../lib/php/validaCatId.php";
require_once __DIR__ . "/../lib/php/validaColId.php";
require_once __DIR__ . "/../lib/php/validaTallId.php";
require_once __DIR__ . "/../lib/php/ProblemDetails.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_VESTIDO.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";
require_once __DIR__ . "/TABLA_COLOR.php";
require_once __DIR__ . "/TABLA_TALLA.php";
require_once __DIR__ . "/validaImagen.php";

ejecutaServicio(function () {

    $modelo = recuperaTexto("modelo");
    $catId = recuperaEntero("catId");
    $tallId = recuperaEntero("tallId");
    $colId = recuperaEntero("colId");
    $descripcion = recuperaTexto("descripcion");
    $precio = recuperaDecimal("precio");
    $estado = recuperaTexto("estado");
    $bytes = recuperaBytes("imagen");

    $modelo = validaModelo($modelo);
    $catId = validaCatId($catId);
    $tallId = validaTallId($tallId);
    $colId = validaColId($colId);   
    $descripcion = validaDescripcion($descripcion);
    $precio = validaPrecio($precio);
    $estado = validaEstado($estado);
    $fechaDeCreacion = date("Y-m-d H:i:s");
    $bytes = validaImagen($bytes);

    if ($bytes === "") {
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Imagen vacía.",
            type: "/error/imagenvacia.html",
            detail: "Selecciona un archivo que no esté vacío."
        );
    }

    $pdo = Bd::pdo();
    $pdo->beginTransaction();

    insert(pdo: $pdo,  into: ARCHIVO,  values: [ARCH_BYTES => $bytes]);
    $archId = $pdo->lastInsertId();

    insert(
        pdo: $pdo,
        into: VESTIDO,
        values: [
            VES_MODELO => $modelo,
            VES_DESCRIPCION => $descripcion,
            VES_PRECIO => $precio,
            VES_ESTADO => $estado,
            VES_FECHA_CREACION => $fechaDeCreacion,
            ARCH_ID => $archId,
            CAT_ID => $catId,
            COL_ID => $colId,
            TALL_ID => $tallId
        ]
    );
    $id = $pdo->lastInsertId();

    $pdo->commit();

    $encodeId = urlencode($id);
    $encodeArchId = urlencode($archId);
    $htmlEncodeArchId = htmlentities($encodeArchId);
    // Los bytes se descargan con "archivo.php"; no desde aquí.
    devuelveCreated("/srv/vestido.php?id=$encodeId", [
        "id" => ["value" => $id],
        "modelo" => ["value" => $modelo],
        "descripcion" => ["value" => $descripcion],
        "precio" => ["value" => "$" . number_format($precio, 2)],
        "estado" => ["value" => $estado],
        "fechaDeCreacion" => ["value" => $fechaDeCreacion],
        "imagen" => ["data-file" => "/srv/archivo.php?id=$htmlEncodeArchId"],
        "catId" => ["value" => $catId],
        "colId" => ["value" => $colId],
        "tallId" => ["value" => $tallId]
    ]);
});
