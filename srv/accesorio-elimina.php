<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/delete.php";
require_once __DIR__ . "/../lib/php/devuelveNoContent.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ACCESORIO.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";

ejecutaServicio(function () {

    $accId = recuperaIdEntero("id");

    $pdo = Bd::pdo();
    $pdo->beginTransaction();

    $accesorio =
        selectFirst(pdo: $pdo, from: ACCESORIO, where: [ACC_ID => $accId]);
    if ($accesorio !== false) {
        delete(pdo: $pdo, from: ACCESORIO, where: [ACC_ID => $accId]);
        if ($accesorio[ARCH_ID] !== null) {
            delete(pdo: $pdo, from: ARCHIVO, where: [ARCH_ID => $accesorio[ARCH_ID]]);
        }
    }

    $pdo->commit();

    devuelveNoContent();
});
