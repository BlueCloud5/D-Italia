<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ACCESORIO.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";

ejecutaServicio(function () {
    // Consulta a la base de datos
    $lista = select(
        pdo: Bd::pdo(),
        from: ACCESORIO,
        orderBy: ACC_MODELO
    );

    // Construir el HTML de las tarjetas
    $render = "";
    foreach ($lista as $accesorio) {
        $id = htmlentities($accesorio[ACC_ID]);
        $modelo = htmlentities($accesorio[ACC_MODELO]);
        $precio = number_format($accesorio[ACC_PRECIO], 2);
        $archId = htmlentities($accesorio[ARCH_ID]);

        // Verificar si existe una referencia a la imagen
        $imagenSrc = $archId 
            ? "../srv/archivo.php?id=" . urlencode($archId) 
            : "vista/recursos/images/accesorios/default.png";

        $render .= "
        <div class='col-12 col-md-6 col-lg-4 mb-5'>
            <a class='product-item' href='#'>
                <img src='{$imagenSrc}' class='img-fluid product-thumbnail'>
                <h3 class='product-id' style='display: none;'>{$id}</h3>
                <h3 class='product-title'>{$modelo}</h3>
                <strong class='product-price'>$ {$precio}</strong>
                <span class='icon-cross'>
                    <img src='../recursos/images/cross.svg' class='img-fluid'>
                </span>
            </a>
        </div>";
    }

    // Retornar el HTML en formato JSON
    devuelveJson(["tarjetasAcc" => ["innerHTML" => $render]]);
});
