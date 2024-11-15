<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaCue.php";
require_once __DIR__ . "/../lib/php/validaMatch.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";

ejecutaServicio(function () {

    $cue = recuperaTexto("cue");
    $match = password_hash(recuperaTexto("match"), PASSWORD_DEFAULT);

    $cue = validaCue($cue);
    $match = validaMatch($match);

    $pdo = Bd::pdo();
    insert(pdo: $pdo, into: USUARIO, values: [USU_CUE => $cue, USU_MATCH => $match]);
    $id = $pdo->lastInsertId();

    $encodeId = urlencode($id);
    devuelveCreated("/srv/usuario.php?id=$encodeId", [
        "id" => ["value" => $id],
        "cue" => ["value" => $cue],
        "match" => ["value" => $match]
    ]);
});
