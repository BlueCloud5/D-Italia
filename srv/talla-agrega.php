<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaValorTalla.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_TALLA.php";

ejecutaServicio(function () {

    $valor = recuperaTexto("valor");

    $valor = validaValorTalla($valor);

    $pdo = Bd::pdo();
    insert(pdo: $pdo, into: TALLA, values: [TALL_VALOR => $valor]);
    $id = $pdo->lastInsertId();

    $encodeId = urlencode($id);
    devuelveCreated("/srv/talla.php?id=$encodeId", [
        "id" => ["value" => $id],
        "valor" => ["value" => $valor]
    ]);
});
