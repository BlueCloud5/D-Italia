<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaCue.php";
require_once __DIR__ . "/../lib/php/validaMatch.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");
    $cue = recuperaTexto("cue");
    $match = password_hash(recuperaTexto("match"), PASSWORD_DEFAULT);

    $cue = validaCue($cue);
    $match = validaMatch($match);

    update(
        pdo: Bd::pdo(),
        table: USUARIO,
        set: [USU_CUE => $cue, USU_MATCH => $match],
        where: [USU_ID => $id]
    );

    devuelveJson([
        "id" => ["value" => $id],
        "cue" => ["value" => $cue],
        "match" => ["value" => $match]
    ]);
});
