<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaCatId(false|null|int $catId)
{

    if ($catId === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta catId.",
            type: "/error/faltacatId.html",
            detail: "La solicitud no tiene el valor de catId."
        );

    if ($catId === null)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Categoría sin selección.",
            type: "/error/categoriaenblanco.html",
            detail: "Selecciona una opción del campo categoría.",
        );

    return $catId;
}
