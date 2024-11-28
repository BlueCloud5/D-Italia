<?php

require_once __DIR__ . "/../lib/php/fetchAll.php";

function detVentaConsulta(PDO $pdo, int $ventaId)
{
    return fetchAll(
        $pdo->query(
            "SELECT
            DV.PROD_ID,
            P.PROD_NOMBRE,
            P.PROD_EXISTENCIAS,
            P.PROD_PRECIO,
            DV.DTV_CANTIDAD,
            DV.DTV_PRECIO
            FROM DET_VENTA DV, PRODUCTO P
            WHERE
            DV.PROD_ID = P.PROD_ID
            AND DV.VENT_ID = :VENT_ID
            ORDER BY P.PROD_NOMBRE"
        ),
        [":VENT_ID" => $ventaId]
    );
}
