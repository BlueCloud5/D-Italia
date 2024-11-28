<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaValorTalla.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_TALLA.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");
    $valor = recuperaTexto("valor");

    $valor = validaValorTalla($valor);

    update(
        pdo: Bd::pdo(),
        table: TALLA,
        set: [TALL_VALOR => $valor],
        where: [TALL_ID => $id]
    );

    devuelveJson([
        "id" => ["value" => $id],
        "valor" => ["value" => $valor]
    ]);
});
