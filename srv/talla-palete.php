<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_TALLA.php";

ejecutaServicio(function () {

    $tallas = select(pdo: Bd::pdo(), from: TALLA, orderBy: TALL_VALOR);

    $render = "";

    foreach ($tallas as $talla) {
        $id = htmlentities($talla[TALL_ID]);
        $valor = htmlentities($talla[TALL_VALOR]);

        $render .= '
            <div class="size-option">
                <input type="checkbox" id="talla' . $valor . '" name="tallas[]" value="' . $id . '">
                <label class="size-label" for="talla' . $valor . '">' . $valor . '</label>
            </div>
        ';
    }
    
    devuelveJson(["tallaContainer" => ["innerHTML" => $render]]);
});
