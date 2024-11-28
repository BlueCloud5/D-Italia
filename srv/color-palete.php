<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_COLOR.php";

ejecutaServicio(function () {

    $colores = select(pdo: Bd::pdo(), from: COLOR, orderBy: COL_NOMBRE);

    $count = 0;
    $render = "";

    foreach ($colores as $color) {
        $id = htmlentities($color[COL_ID]);
        $nombre = htmlentities($color[COL_NOMBRE]);
        $valorHex = htmlentities($color[COL_HEXADECIMAL]);

        $class = $count >= 3 ? 'color-option d-none' : 'color-option';
        $render .= "
            <div class='$class'>
                <input type='checkbox' id='color{$nombre}Ves' name='colores[]' value='{$id}'>
                <label class='color-label' for='color{$nombre}Ves' style='background-color: {$valorHex};'></label>
                <span class='color'>{$nombre}</span>
            </div>
        ";
        $count++;
    }

    $render .= "
        <div class='d-grid gap-2'>
            <button id='toggleColorsVes' class='btn btn-sm' style='color: #E6C3AA;'>
                <i class='fa-solid fa-plus'></i> Mostrar más
            </button>
        </div>";

    devuelveJson([
        "colorContainerVestidos" => ["innerHTML" => $render],
        "colorContainerAccesorios" => ["innerHTML" => $render]
    ]);
});
