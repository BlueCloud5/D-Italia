<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/../lib/php/fetchAll.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_VESTIDO.php";
require_once __DIR__ . "/TABLA_ARCHIVO.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";
require_once __DIR__ . "/TABLA_COLOR.php";
require_once __DIR__ . "/TABLA_TALLA.php";

ejecutaServicio(function () {

    $lista = fetchAll(Bd::pdo()->query(
        "SELECT
          V.VES_ID,
          V.VES_MODELO,
          V.VES_PRECIO,
          V.VES_DESCRIPCION,
          V.VES_ESTADO,
          V.VES_FECHA_CREACION,
          AR.ARCH_ID,
          CA.CAT_NOMBRE,
          CO.COL_HEXADECIMAL,
          CO.COL_NOMBRE,
          TA.TALL_VALOR
         FROM VESTIDO V
          LEFT JOIN CATEGORIA CA
          ON V.CAT_ID = CA.CAT_ID
          LEFT JOIN COLOR CO
          ON V.COL_ID = CO.COL_ID
          LEFT JOIN TALLA TA
          ON V.TALL_ID = TA.TALL_ID
          LEFT JOIN ARCHIVO AR
          ON V.ARCH_ID = AR.ARCH_ID
         ORDER BY V.VES_MODELO"
    ));

    $render = "";
    foreach ($lista as $VESTIDO) {
        $encodeId = urlencode($VESTIDO[VES_ID]);
        $id = htmlentities($encodeId);
        $modelo = htmlentities($VESTIDO[VES_MODELO]);
        $categoria = htmlentities($VESTIDO[CAT_NOMBRE]);
        $descripcion = htmlentities($VESTIDO[VES_DESCRIPCION]);
        $precio = number_format($VESTIDO[VES_PRECIO], 2);
        $archId = htmlentities($VESTIDO[ARCH_ID]);

        $imagenSrc = $archId
            ? "../srv/archivo.php?id=" . urlencode($archId)
            : "vista/recursos/images/VESTIDOs/default.png";

        $render .= "
        <div class='col-12 col-md-6 col-lg-4 mb-5'>
            <a class='product-item' href='#'>
                <img src='{$imagenSrc}' class='img-fluid product-thumbnail'>
                <h3 class='product-id' style='display: none;'>{$id}</h3>
                <h3 class='product-title'>{$modelo}</h3>
                <h3 class='product-cate' hidden>$categoria</h3>
                <h3 class='product-desc' hidden>$descripcion</h3>
                <strong class='product-price'>$ {$precio}</strong>
                <span class='icon-cross'>
                    <img src='../recursos/images/cross.svg' class='img-fluid'>
                </span>
            </a>
        </div>";
    }

    devuelveJson(["tarjetasVes" => ["innerHTML" => $render]]);
});
